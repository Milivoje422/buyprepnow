<?php

###################################################################
#                                                             	  #
#	The property of ICEPAY www.icepay.eu                          #
#                                                             	  #
#   The merchant is entitled to change de ICEPAY plug-in code,	  #
#	any changes will be at merchant's own risk.		              #
#	Requesting ICEPAY support for a modified plug-in will be      #
#	charged in accordance with the standard ICEPAY tariffs.	      #
#                                                             	  #
###################################################################

/**
 * ICEPAY Wordpress Payment module - Main script
 * 
 * @version 2.0.0
 * @author Wouter van Tilburg, Ricardo Jacobs
 * @license http://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3 (GPL-3.0)
 * @copyright Copyright (c) 2012 ICEPAY B.V.
 * 
 * Below are settings required for Wordpress
 * 
 * Plugin Name: ICEPAY for WP e-Commerce
 * Plugin URI: http://wordpress.org/extend/plugins/icepay/ 
 * Description: Enables ICEPAY within WP eCommerce
 * Author: ICEPAY
 * Version: 2.0.1
 * Author URI: http://www.icepay.com
 */
require_once(realpath(dirname(__FILE__)) . '/api/icepay_api_webservice.php');
require_once(realpath(dirname(__FILE__)) . '/classes/helper.php');
require_once(realpath(dirname(__FILE__)) . '/classes/form.php');
require_once(realpath(dirname(dirname(__FILE__))) . '/wp-e-commerce/wpsc-core/wpsc-functions.php');
require_once(realpath(dirname(dirname(__FILE__))) . '/wp-e-commerce/wpsc-includes/merchant.class.php');
require_once(realpath(dirname(dirname(__FILE__))) . '/wp-e-commerce/wpsc-includes/purchaselogs.class.php');

// Add hook for activation
register_activation_hook(__FILE__, 'ICEPAY_register');

function ICEPAY_register() {
    global $wpdb;

    $table_name = $wpdb->prefix . "wpsc_icepay_transactions";
    $sql = "CREATE TABLE $table_name (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `order_id` int(11) NOT NULL,
        `status` varchar(255) NOT NULL,
        `transaction_id` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


class ICEPAY extends wpsc_merchant {

    private $version;
    private $pluginURL;

    public function __construct()
    {
        $this->version = ICEPAY_Helper::getVersion();
        $this->pluginURL = plugins_url('', __FILE__);
        $this->settings = get_option('icepay_options');
        $this->paymentMethods = get_option('icepay-paymentmethods');

        add_action('init', array($this, 'setPaymentMethods'));
        add_action('init', array($this, 'response'));
        add_action('wpsc_submit_checkout', array($this, 'checkOut'));
        add_action('admin_menu', array($this, 'addMenuItem'));
        add_action('admin_init', array($this, 'initSettings'));
        add_action('wp_ajax_icepay_getPaymentMethods', array($this, 'getPaymentMethods'));

        load_plugin_textdomain('icepay', false, $this->pluginURL . '/languages/');

        if (ICEPAY_Helper::isIcepayPage()) {
            wp_enqueue_script('icepay', $this->pluginURL . '/assets/js/icepay.js', array('jquery'), '1.0');
            wp_enqueue_style('icepay', $this->pluginURL . '/assets/css/icepay.css', array(), '1.0');
        }

        if (!empty($this->settings['icepay_merchantid']) && !empty($this->settings['icepay_secretcode']) && empty($this->paymentMethods)) {
            $this->updateInternal = true;
            $this->getPaymentMethods();
        }
    }

    public function getPaymentMethods()
    {
        if (!$this->updateInternal) {
            if (!current_user_can('manage_options')) {
                return;
            }

            if (isset($_GET['page']) && $_GET['page'] != 'icepay-configuration-fetch')
                return;
        }

        try {
            $webservice = Icepay_Api_Webservice::getInstance()->paymentMethodService();
            $webservice->setMerchantID($this->settings['icepay_merchantid'])
                    ->setSecretCode($this->settings['icepay_secretcode']);

            $paymentMethods = $webservice->retrieveAllPaymentmethods()->asArray();

            update_option('icepay-paymentmethods', serialize($paymentMethods));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function initSettings()
    {
        register_setting('icepay', 'eg_setting_name');
        register_setting('icepay_options', 'icepay_options', array('ICEPAY_Form', 'validateSettings'));

        // Add Main Settings section
        add_settings_section('icepay_main', __('Main Settings', 'icepay'), false, 'icepay_config');

        // Add Main Settings fields
        add_settings_field('icepay_url', __('URL for postback, success and error', 'icepay'), array('ICEPAY_Form', 'urlSettings'), 'icepay_config', 'icepay_main', array("icepay_url", __('Copy-paste this into your ICEPAY Merchant Thank you page, Error page and Postback URL', 'icepay')));
        add_settings_field('icepay_merchantid', __('Merchant ID', 'icepay'), array('ICEPAY_Form', 'textfieldSettings'), 'icepay_config', 'icepay_main', array("icepay_merchantid"));
        add_settings_field('icepay_secretcode', __('Secretcode (API key)', 'icepay'), array('ICEPAY_Form', 'textfieldSettings'), 'icepay_config', 'icepay_main', array("icepay_secretcode"));

        // Add Additional Settings
        add_settings_section('icepay_extra', __('Additional Settings', 'icepay'), false, 'icepay_config');

        // Add Additional Settings fields
        add_settings_field('icepay_description', __('Description on transaction statement of customer', 'icepay'), array('ICEPAY_Form', 'textfieldSettings'), 'icepay_config', 'icepay_extra', array("icepay_description", __('Some payment methods allow customized descriptions on the transaction statement. If left empty the WP Order ID is used. (Max 100 char.)', 'icepay')));
        add_settings_field('icepay_ipcheck', __('(Optional) Custom IP Range for IP Check for Postback', 'icepay'), array('ICEPAY_Form', 'textfieldSettings'), 'icepay_config', 'icepay_extra', array("icepay_ipcheck", __('For example a proxy: 1.222.333.444-100.222.333.444 For multiple ranges use a , seperator: 1.222.333.444-100.222.333.444,2.222.333.444-200.222.333.444', 'icepay')));
    }

    public function addMenuItem()
    {
        add_options_page('ICEPAY', 'ICEPAY Configuration', 'manage_options', 'icepay-configuration', array($this, 'renderAdmin'));
    }

    public function renderAdmin()
    {
        include(realpath(dirname(__FILE__)) . '/templates/admin.php');
    }

    public function checkOut()
    {
        global $wpsc_cart, $wpdb;

        // Check if payment is done by ICEPAY
        if (!isset($_POST['icepay_paymentmethod']))
            return false;

        $gateway = $_POST['custom_gateway'];
        $pmCode = get_option($gateway . "_code");

        try {
            $webservice = Icepay_Api_Webservice::getInstance()->paymentService();
            $webservice->addToExtendedCheckoutList(array('AFTERPAY'))
                    ->setMerchantID($this->settings['icepay_merchantid'])
                    ->setSecretCode($this->settings['icepay_secretcode']);

            // Initiate icepay object
            $ic_obj = new StdClass();

            // Get the grand total of order
            $ic_obj->amount = intval($wpsc_cart->total_price * 100);
            $ic_obj->country = $wpsc_cart->selected_country;

            // Get the used currency for the shop
            $currency = $wpdb->get_row("SELECT `code` FROM `" . WPSC_TABLE_CURRENCY_LIST . "` WHERE `id`='" . get_option('currency_type') . "' LIMIT 1");
            $ic_obj->currency = $currency->code;

            // Get the Wordpress language and adjust format so ICEPAY accepts it.
            $language_locale = get_bloginfo('language');
            $ic_obj->language = strtoupper(substr($language_locale, 0, 2));

            // Get the order and fetch the order id   
            $issuer = (isset($_POST[$pmCode . '_issuer'])) ? $_POST[$pmCode . '_issuer'] : 'DEFAULT';

            $paymentObj = new Icepay_PaymentObject();
            $paymentObj->setOrderID($wpsc_cart->log_id)
                    ->setDescription($this->settings['icepay_description'])
                    ->setReference($wpsc_cart->log_id)
                    ->setAmount(intval($ic_obj->amount))
                    ->setCurrency($ic_obj->currency)
                    ->setCountry($ic_obj->country)
                    ->setLanguage($ic_obj->language)
                    ->setPaymentMethod($pmCode)
                    ->setIssuer($issuer);

            // If extended checkout is required, add order details
            if ($webservice->isExtendedCheckoutRequiredByPaymentMethod($pmCode)) {
                $purchlogitem = new wpsc_purchaselogs_items($wpsc_cart->log_id);

                // Consumer information
                Icepay_Order::getInstance()
                        ->setConsumer(Icepay_Order_Consumer::create()
                                ->setConsumerID($purchlogitem->extrainfo->user_ID)
                                ->setEmail($purchlogitem->userinfo['billingemail']['value'])
                                ->setPhone($purchlogitem->userinfo['billingphone']['value'])
                );

                // Billing Address
                $billingAddress = Icepay_Order_Address::create()
                        ->setInitials($purchlogitem->userinfo['billingfirstname']['value'])
                        ->setLastName($purchlogitem->userinfo['billinglastname']['value'])
                        ->setStreet(Icepay_Order_Helper::getStreetFromAddress($purchlogitem->userinfo['billingaddress']['value']))
                        ->setHouseNumber(Icepay_Order_Helper::getHouseNumberFromAddress($purchlogitem->userinfo['billingaddress']['value']))
                        ->setHouseNumberAddition(Icepay_Order_Helper::getHouseNumberAdditionFromAddress($purchlogitem->userinfo['billingaddress']['value']))
                        ->setZipCode($purchlogitem->userinfo['billingpostcode']['value'])
                        ->setCity($purchlogitem->userinfo['billingcity']['value'])
                        ->setCountry($purchlogitem->userinfo['billingcountry']['value']);

                Icepay_Order::getInstance()->setBillingAddress($billingAddress);

                // Shipping address (If empty clone billing address)
                if ($purchlogitem->userinfo['shippingaddress']['value'] == '') {
                    $shippingAddress = clone $billingAddress;
                } else {
                    $shippingAddress = Icepay_Order_Address::create()
                            ->setInitials($purchlogitem->userinfo['shippingfirstname']['value'])
                            ->setLastName($purchlogitem->userinfo['shippinglastname']['value'])
                            ->setStreet(Icepay_Order_Helper::getStreetFromAddress($purchlogitem->userinfo['shippingaddress']['value']))
                            ->setHouseNumber(Icepay_Order_Helper::getHouseNumberFromAddress($purchlogitem->userinfo['shippingaddress']['value']))
                            ->setHouseNumberAddition(Icepay_Order_Helper::getHouseNumberAdditionFromAddress($purchlogitem->userinfo['shippingaddress']['value']))
                            ->setZipCode($purchlogitem->userinfo['shippingpostcode']['value'])
                            ->setCity($purchlogitem->userinfo['shippingcity']['value'])
                            ->setCountry($purchlogitem->userinfo['shippingcountry']['value']);
                }

                Icepay_Order::getInstance()->setShippingAddress($shippingAddress);

                // Tax fix
                $totalXMLPrice = 0;

                // Products
                foreach ($purchlogitem->allcartcontent as $product) {
                    // Get tax rate
                    $taxRate = (int) round($purchlogitem->extrainfo->wpec_taxes_rate, 0);

                    // Get price in cents
                    $unitPrice = (int) (string) ($product->price * 100);

                    // Get price including taxes
                    $totalPrice = (int) (string) ($unitPrice * (($taxRate / 100) + 1));

                    Icepay_Order::getInstance()
                            ->addProduct(Icepay_Order_Product::create()
                                    ->setProductID($product->id)
                                    ->setProductName($product->name)
                                    ->setDescription($product->custom_message)
                                    ->setQuantity($product->quantity)
                                    ->setUnitPrice($totalPrice)
                                    ->setVATCategory(Icepay_Order_VAT::getCategoryForPercentage($taxRate))
                    );

                    $totalXMLPrice += ($totalPrice * $product->quantity);
                }




                // Shipping Costs                
                $shippingCosts = (int) (string) ($purchlogitem->extrainfo->base_shipping * 100);
                Icepay_Order::getInstance()->setShippingCosts($shippingCosts);

                $totalXMLPrice += $shippingCosts;

                if ($ic_obj->amount - $totalXMLPrice == 1) {
                    Icepay_Order::getInstance()
                            ->addProduct(Icepay_Order_Product::create()
                                    ->setProductID('00')
                                    ->setProductName('BTW Correctie')
                                    ->setDescription('BTW Correctie')
                                    ->setQuantity('1')
                                    ->setUnitPrice(1)
                                    ->setVATCategory(Icepay_Order_VAT::getCategoryForPercentage(0))
                    );
                }
            }

            /* Start the transaction */
            if ($webservice->isExtendedCheckoutRequiredByPaymentMethod($pmCode)) {
                $transactionObj = $webservice->extendedCheckOut($paymentObj);
            } else {
                $transactionObj = $webservice->CheckOut($paymentObj);
            }

            // Get payment url and redirect to paymentscreen
            $url = $transactionObj->getPaymentScreenURL();

            // Insert payment into ICEPAY table
            $table_name = $wpdb->prefix . "wpsc_icepay_transactions";
            $wpdb->insert($table_name, array('order_id' => $wpsc_cart->log_id, 'status' => Icepay_StatusCode::OPEN, 'transaction_id' => NULL));

            header("location: {$url}");
            exit();
        } catch (Exception $e) {
            $this->set_error_message($e->getMessage());
            $this->return_to_checkout();
        }
    }

    public function response()
    {
        global $wpdb, $wp_version;

        if (isset($_GET['page']) && $_GET['page'] == 'icepayresult') {

            // Postback
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $icepay = Icepay_Project_Helper::getInstance()->postback();
                $icepay->setMerchantID($this->settings['icepay_merchantid'])
                        ->setSecretCode($this->settings['icepay_secretcode'])
                        ->doIPCheck(true);

                if ($this->settings['icepay_ipcheck'] != '') {
                    $ipRanges = explode(",", $this->settings['icepay_ipcheck']);

                    foreach ($ipRanges as $ipRange) {
                        $ip = explode("-", $ipRange);
                        $icepay->setIPRange($ip[0], $ip[1]);
                    }
                }

                if ($icepay->validate()) {
                    $data = $icepay->GetPostback();

                    $orderID = $data->orderID;

                    $this->purchase_id = $orderID;

                    $table_icepay = $wpdb->prefix . "wpsc_icepay_transactions";
                    $ic_order = $wpdb->get_row("SELECT * FROM $table_icepay WHERE `order_id` = $orderID");
                    $order = $wpdb->get_row("SELECT * FROM `" . WPSC_TABLE_PURCHASE_LOGS . "` WHERE id = $orderID");

                    if ($icepay->canUpdateStatus($ic_order->status)) {
                        if ($data->status == Icepay_StatusCode::OPEN)
                            delete_transient("{$order->sessionid}_pending_email_sent");

                        if ($data->status == Icepay_StatusCode::SUCCESS)
                            delete_transient("{$order->sessionid}_receipt_email_sent");

                        $processed = $this->getEcommerceStatus(($data->status));
                        $wpdb->update($table_icepay, array('status' => $data->status, 'transaction_id' => $data->transactionID), array('order_id' => $orderID));
                        $this->set_transaction_details($data->transactionID, $processed);
                        transaction_results($order->sessionid, false, $data->transactionID);
                    }
                } else {
                    if ($icepay->isVersionCheck()) {
                        $dump = array(
                            "module" => sprintf("ICEPAY WPEC payment module version %s using PHP API version %s", ICEPAY_VERSION, Icepay_Project_Helper::getInstance()->getReleaseVersion()), //<--- Module version and PHP API version
                            "notice" => "Checksum validation passed!"
                        );

                        if ($icepay->validateVersion()) {
                            $dump["additional"] = array(
                                "Wordpress" => $wp_version, // CMS name & version
                                "E-Commerce" => WPSC_VERSION // Webshop name & version
                            );
                        } else {
                            $dump["notice"] = "Checksum failed! Merchant ID and Secret code probably incorrect.";
                        }
                        var_dump($dump);
                        exit();
                    }
                }
            } else {
                $icepay = Icepay_Project_Helper::getInstance()->result();

                try {
                    $icepay->setMerchantID($this->settings['icepay_merchantid'])
                            ->setSecretCode($this->settings['icepay_secretcode']);
                } catch (Exception $e) {
                    echo "Postback URL installed successfully.";
                }

                if ($icepay->validate()) {
                    // No order ID??
                    $order = $wpdb->get_row("SELECT `sessionid` FROM `" . WPSC_TABLE_PURCHASE_LOGS . "` ORDER BY `id` DESC LIMIT 1");

                    switch ($icepay->getStatus()) {
                        case Icepay_StatusCode::ERROR:
                            wp_redirect(get_option('transact_url'));
                            exit();
                            break;
                        case Icepay_StatusCode::OPEN:
                        case Icepay_StatusCode::SUCCESS:
                            set_transient("{$order->sessionid}_pending_email_sent", true, 60 * 60 * 12);
                            set_transient("{$order->sessionid}_receipt_email_sent", true, 60 * 60 * 12);
                            $this->go_to_transaction_results($order->sessionid);
                            exit();
                            break;
                    }
                }

                exit();
            }
        }
    }

    public function getEcommerceStatus($status)
    {
        if ($status == Icepay_StatusCode::ERROR)
            return 6; // 'Payment Declined'

        if ($status == Icepay_StatusCode::OPEN)
            return 2; // 'Order Received'

        if ($status == Icepay_StatusCode::SUCCESS)
            return 3; // 'Accepted Payment'

        return 6;
    }

    public function setPaymentMethods()
    {

        global $nzshpcrt_gateways, $num, $gateway_checkout_form_fields, $wpdb, $wpsc_cart;

        $gatewayNames = get_option('payment_gateway_names');
        
        if (!$this->paymentMethods)
            return;
        
        $filter = Icepay_Api_Webservice::getInstance()->filtering()->loadFromArray(unserialize($this->paymentMethods));

        if (!is_admin()) {
            $amount = (int) (string) ($wpsc_cart->total_price * 100);
            $filter->filterByAmount($amount);
            $currency = $wpdb->get_row("SELECT `code` FROM `" . WPSC_TABLE_CURRENCY_LIST . "` WHERE `id`='" . get_option('currency_type') . "' LIMIT 1");
            $filter->filterByCurrency($currency->code);
        }

        $filteredPaymentMethods = $filter->getFilteredPaymentmethods();

        foreach ($filteredPaymentMethods as $paymentMethod) {
            $num++;

            $nzshpcrt_gateways[$num] = array(
                'name' => 'ICEPAY ' . $paymentMethod['Description'],
                'is_exclusive' => true,
                'payment_type' => 'icepay_checkout',
                'payment_gateway' => 'icepay',
                'internalname' => 'icepay_' . strtolower($paymentMethod['PaymentMethodCode']),
                'display_name' => $paymentMethod['Description'],
                'form' => 'paymentMethodForm'
            );
            
            add_option($nzshpcrt_gateways[$num]['internalname'] . "_code", $paymentMethod['PaymentMethodCode']);

            $image = $this->pluginURL . "/assets/images/{$paymentMethod['PaymentMethodCode']}.png";

            $issuers = $paymentMethod['Issuers'];

            $output = "";
            $output .= "<tr><td><p><img src='{$image}' width='163' border=0/></p>";

            if (count($issuers) > 1) {
                $output .= "<p><select name='{$paymentMethod['PaymentMethodCode']}_issuer' style='width:163px;'>";
                foreach ($issuers as $issuer) {

                    if ($issuer['IssuerKeyword'] == 'CCAUTOCHECKOUT' || $issuer['IssuerKeyword'] == 'IDEALINCASSO')
                        continue;

                    $issuerName = $issuer['Description'];

                    if ($issuer['Description'] == 'KNAB')
                        $issuerName = 'KNAB Bank';

                    $output .= sprintf("<option value='%s'>%s</option>", $issuer['IssuerKeyword'], __($issuerName, 'icepay'));
                }
                $output .= "</select></p>";
            } else if (count($issuers) == 1) {
                $output .= "<input type='hidden' name='{$paymentMethod['PaymentMethodCode']}_issuer' value='{$issuers[0]['IssuerKeyword']}' />";
            }

            $output .= "</td></tr>";
            $output .= sprintf("<input type='hidden' name='icepay_paymentmethod' value='%s' />", $paymentMethod['PaymentMethodCode']);

            $gateway_checkout_form_fields[$nzshpcrt_gateways[$num]['internalname']] .= $output;
            if (!isset($gatewayNames[$nzshpcrt_gateways[$num]['internalname']]))
                $gatewayNames[$nzshpcrt_gateways[$num]['internalname']] = $paymentMethod['Description'];
        }

        update_option('payment_gateway_names', $gatewayNames);
    }

}

new ICEPAY();