<?php

/**
 * ICEPAY Woocommerce payment module
 *
 * @license   see LICENSE.md
 * @source    https://github.com/icepay/WooCommerce
 * @copyright Copyright (c) 2015 ICEPAY B.V.
 *
 * Plugin Name: ICEPAY Payment Module
 * Plugin URI: http://www.icepay.com/webshop-modules/online-payments-for-wordpress-woocommerce
 * Description: ICEPAY Payment Module for WooCommerce
 * Author: ICEPAY
 * Author URI: http://www.icepay.com
 * Version: 2.3.6
 * License: http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE
 */

add_action('plugins_loaded', 'ICEPAY_Init');

require(plugin_dir_path( __FILE__ ) . '/api/api/icepay_api_webservice.php');
require(plugin_dir_path( __FILE__ ) . '/classes/helper.php');

function ICEPAY_Init()
{
    /**
     * Load the Payment Gateway class if WooCommerce did not load it
     */
    if(!class_exists('WC_Payment_Gateway')) return;

    /**
     * Class ICEPAY
     */
    class ICEPAY extends WC_Payment_Gateway
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            // Enables shortcut link to ICEPAY settings on the plugin overview page
            add_filter('plugin_action_links', 'IC_add_action_plugin', 10, 5);

            // Load ICEPAY translations
            load_plugin_textdomain('icepay', false, dirname(plugin_basename(__FILE__)) . '/languages/');

            // Set core gateway settings
            $this->method_title = 'ICEPAY';
            $this->id = 'ICEPAY';
            $this->title = 'ICEPAY';

            $this->version = ICEPAY_Helper::getVersion();

            // Create admin configuration form
            $this->initForm();

            // Initialise gateway settings
            $this->init_settings();

            // Core gateway is for configuration use only and should never be enabled
            $this->enabled = false;

            // Add postback URL to configuration form
            $this->settings['postbackurl'] = add_query_arg('wc-api', 'icepay_result', home_url('/'));

            // Payment listener/API hook
            add_action('woocommerce_api_icepay_result', array($this, 'result'));

            // Since we use a class wrapper, our class is called  twice. To prevent double execution we do a check if the gateway is already registered.
            $loaded_gateways = apply_filters('woocommerce_payment_gateways', array());

            if (in_array($this->id, $loaded_gateways))
            {
                return;
            }

            // Add ICEPAY as WooCommerce gateway
            add_filter('woocommerce_payment_gateways', array($this, 'addGateway'));

            // Check if on admin page
            if (is_admin())
            {
                // Run install if false - not using install hook to make sure people who upgrade get the correct tables installed (Upgrade function was added later)
                if (!get_option('ICEPAY_Installed', false))
                {
                    $this->install();
                }

                add_action('woocommerce_update_options_payment_gateways_ICEPAY', array($this, 'process_admin_options'));

                // Ajax callback for getPaymentMethods
                add_action('wp_ajax_ic_getpaymentmethods', array($this, 'getPaymentMethods'));

                // Add scripts
                add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
            }
        }

        public function enqueueScripts()
        {
            // Add files only on ICEPAY's configuration page
            if (ICEPAY_helper::isIcepayPage($this->id))
            {
                wp_enqueue_script('icepay', plugin_dir_url( __FILE__ ) . 'assets/js/icepay.js', array('jquery'), $this->version);
                wp_enqueue_style('icepay', plugin_dir_url( __FILE__ ) . 'assets/css/icepay.css', array(), $this->version);

                wp_localize_script('icepay', 'objectL10n', array(
                    'loading' => __('Loading payment method data...', 'icepay'),
                    'refresh' => __('Refresh payment methods', 'icepay')
                ));
            }
        }

        public function result()
        {
            global $wpdb;

            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $icepay = Icepay_Project_Helper::getInstance()->postback();
                $icepay->setMerchantID(intval($this->settings['merchantid']))->setSecretCode($this->settings['secretcode']);

                if ($icepay->validate())
                {
                    $data = $icepay->GetPostback();
                    $order_id = $data->orderID;

                    $query = "SELECT * FROM `{$this->getTableWithPrefix('woocommerce_icepay_transactions')}` WHERE `id` = %d";
                    $ic_order = $wpdb->get_row($wpdb->prepare($query, $order_id));

                    $order = new WC_Order($ic_order->order_id);

                    if ($icepay->canUpdateStatus($ic_order->status))
                    {
                        switch ($data->status)
                        {
                            case Icepay_StatusCode::ERROR:
                                $order->add_order_note($data->statusCode);
                                break;
                            case Icepay_StatusCode::OPEN:
                                break;
                            case Icepay_StatusCode::AUTHORIZED:
                                $order->payment_complete();
                                break;
                            case Icepay_StatusCode::SUCCESS:
                                $order->payment_complete();
                                break;
                            case Icepay_StatusCode::REFUND:
                                $order->update_status('refunded');
                                $order->add_order_note($data->statusCode);
                                break;
                            case Icepay_StatusCode::CHARGEBACK:
                                $order->update_status('cancelled');
                                $order->add_order_note($data->statusCode);
                                break;
                        }

                        $wpdb->update($this->getTableWithPrefix('woocommerce_icepay_transactions'), array('status' => $data->status, 'transaction_id' => $data->transactionID), array('id' => $order_id));
                    }
                }
            }
            else
            {
                $icepay = Icepay_Project_Helper::getInstance()->result();

                try
                {
                    $icepay->setMerchantID($this->settings['merchantid'])->setSecretCode($this->settings['secretcode']);
                }
                catch (Exception $e)
                {
                    exit(__('Postback URL installed successfully.', 'icepay'));
                }

                if ($icepay->validate())
                {
                    $order_id = $_GET['OrderID'];

                    $query = "SELECT * FROM `{$this->getTableWithPrefix('woocommerce_icepay_transactions')}` WHERE `id` = %d";
                    $ic_order = $wpdb->get_row($wpdb->prepare($query, $order_id));

                    $order = new WC_Order($ic_order->order_id);

                    switch ($icepay->getStatus())
                    {
                        case Icepay_StatusCode::ERROR:
                            $order->add_order_note('User cancelled order.');
                            wp_safe_redirect($order->get_cancel_order_url());
                            break;
                        case Icepay_StatusCode::AUTHORIZED:
                        case Icepay_StatusCode::OPEN:
                        case Icepay_StatusCode::SUCCESS:
                            WC()->cart->empty_cart();
                            wp_safe_redirect($order->get_checkout_order_received_url());
                            break;
                    }
                }

                exit(__('Postback URL installed successfully.', 'icepay'));
            }
        }

        public function getPaymentMethods()
        {
            global $wpdb;

            try
            {
                $paymentService = Icepay_Api_Webservice::getInstance()->paymentMethodService();
                $paymentService->setMerchantID($this->settings['merchantid'])->setSecretCode($this->settings['secretcode']);

                $paymentMethods = $paymentService->retrieveAllPaymentmethods()->asArray();

                $pmInfoTable = $this->getTableWithPrefix('woocommerce_icepay_pminfo');
                $pmRawDataTable = $this->getTableWithPrefix('woocommerce_icepay_pmrawdata');

                // Clear old raw paymentdata in database
                $wpdb->query("TRUNCATE `{$pmRawDataTable}`");

                // Clear old pminfo data in database
                $wpdb->query("TRUNCATE `{$pmInfoTable}`");

                // Store new raw paymentdata in database
                $wpdb->insert($pmRawDataTable, array('raw_pm_data' => serialize($paymentMethods)));

                if ($paymentMethods > 0)
                {
                    $i = 1;
                    $html = '';

                    foreach ($paymentMethods as $paymentMethod)
                    {
                        $wpdb->insert($pmInfoTable, array('id' => $i, 'pm_code' => $paymentMethod['PaymentMethodCode'], 'pm_name' => $paymentMethod['Description']));

                        $html .= ICEPAY_Helper::generateAjaxListItems($paymentMethod, $i);

                        $i++;
                    }
                }
                else
                {
                    $html = ICEPAY_Helper::generateAjaxError(__('No active payment methods found for this merchant.', 'icepay'));
                }
            }
            catch (Exception $e)
            {
                $html = ICEPAY_Helper::generateAjaxError("An error occured: <b>{$e->getMessage()}</b>");
            }

            echo $html;

            // Always die on Ajax calls
            die();
        }

        public function admin_options()
        {
            global $wpdb;

            if (class_exists('SoapClient') === false)
            {
                die(ICEPAY_Helper::generateAjaxError(__('This plugin requires SOAP to make payments. Please contact your hosting provider to support SOAP.', 'icepay')));
            }

            ob_start();
            $this->generate_settings_html();
            $settings = ob_get_contents();
            ob_end_clean();

            $paymentMethods = $wpdb->get_results("SELECT * FROM `{$this->getTableWithPrefix('woocommerce_icepay_pminfo')}`");

            $variables = array(
                '{image}' => plugins_url('', __FILE__) . '/assets/images/icepay-header.png',
                '{version}' => $this->version,
                '{manual}' => __('View the manual', 'icepay'),
                '{website}' => __('Visit the ICEPAY website', 'icepay'),
                '{configuration}' => __('Configuration', 'icepay'),
                '{payment_methods}' => __('Payment methods', 'icepay'),
                '{information}' => __('Information', 'icepay'),
                // Ricardo (7-5-2015): This is a little hack-ish, but who you gonne call?
                '{settings}' => '<h3 class="wc-settings-sub-title">' . __('Merchant configuration', 'icepay') . '</h3>' . '<p>' . __('Your Merchant ID and Secretcode are available in the ICEPAY Merchant Portal. See the Manual for more information.', 'icepay') . '</p>' . $settings,
                '{missing_methods)' => __('Are there payments methods missing from this payment table? Enable or activate them in the ICEPAY Merchant Portal at', 'icepay'),
                '{refreshButtonValue}' => __('Refresh Payment methods', 'icepay'),
                '{error}' => '',
                '{list}' => '',
                '{upgrade_notice}' => '',
                '{IC_version}' => __('Module version', 'icepay'),
                '{WC_version_label}' => __('WC Version', 'woocommerce'),
                '{WC_version}' => WC()->version,
                '{WP_version_label}' => __('WP Version', 'woocommerce'),
                '{WP_version}' => get_bloginfo('version') . ' (' . get_bloginfo('language') . ')',
                '{IC_API}' => __('using ICEPAY API', 'icepay') . ' ' . Icepay_Project_Helper::getInstance()->getReleaseVersion(),
                '{IC_Support}' => __('Please include this information when you create a support ticket, this way we can help you better', 'icepay')
            );

            ICEPAY_Helper::generateListItems($paymentMethods, $variables);

            if (ICEPAY_Helper::isUpgradeNoticeAvailable())
            {
                ICEPAY_Helper::generateUpgradeNotice($variables);
            }

            $template = file_get_contents(plugin_dir_path(__FILE__) . 'templates/admin.php');

            foreach ($variables as $key => $value) {
                $template = str_replace($key, $value, $template);
            }

            echo $template;
        }

        public function addGateway($methods)
        {
            global $wpdb;

            $methods[] = 'ICEPAY';

            $paymentMethodCount = $wpdb->get_var("SELECT count(id) FROM `{$this->getTableWithPrefix('woocommerce_icepay_pminfo')}`");

            if ($paymentMethodCount != null)
            {
                $i = 1;

                while ($i <= $paymentMethodCount)
                {
                    $methods[] = "ICEPAY_PaymentMethod_{$i}";
                    $i++;
                }
            }

            return $methods;
        }

        private function initForm()
        {
            $this->form_fields = array(
                'postbackurl' => array(
                    'title' => __('Postback URL', 'icepay'),
                    'type' => 'text',
                    'description' => __('Copy and paste this URL to the Success, Error and Postback section of your ICEPAY merchant account page.', 'icepay'),
                    'desc_tip' => true
                ),
                'merchantid' => array(
                    'title' => __('Merchant ID', 'icepay'),
                    'type' => 'text',
                    'description' => __('Copy the Merchant ID from your ICEPAY account.', 'icepay'),
                    'desc_tip' => true
                ),
                'secretcode' => array(
                    'title' => __('Secretcode', 'icepay'),
                    'type' => 'text',
                    'description' => __('Copy the Secret Code from your ICEPAY account.', 'icepay'),
                    'desc_tip' => true
                ),
                'steptwo' => array(
                    'title' => __('Optional configuration', 'icepay'),
                    'type' => 'title'
                ),
                'descriptiontransaction' => array(
                    'title' => __('Description on transaction statement', 'icepay'),
                    'type' => 'text',
                    'description' => __('Some payment methods allow customized descriptions on the transaction statement. If left empty the Order ID is used. (Max 100 char.)', 'icepay'),
                    'desc_tip' => true
                )
            );
        }

        private function install()
        {
            global $wpdb;

            // Add custom status (To prevent user cancel - or re-pay on standard status pending)
            wp_insert_term(__('Awaiting Payment', 'icepay'), 'shop_order_status');

            // Install ICEPAY's transaction table
            $wpdb->query("CREATE TABLE IF NOT EXISTS `{$this->getTableWithPrefix('woocommerce_icepay_transactions')}` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `order_id` int(11) NOT NULL,
                `status` varchar(255) NOT NULL,
                `transaction_id` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            )");

            // Install ICEPAY's pminfo table
            $wpdb->query("CREATE TABLE IF NOT EXISTS `{$this->getTableWithPrefix('woocommerce_icepay_pminfo')}` (
                `id` int(11) NOT NULL,
                `pm_code` varchar(255),
                `pm_name` varchar(255)
            );");

            // Install ICEPAY's pmrawdata table
            $wpdb->query("CREATE TABLE IF NOT EXISTS `{$this->getTableWithPrefix('woocommerce_icepay_pmrawdata')}` (
                `raw_pm_data` LONGTEXT
            )");

            update_option('ICEPAY_Installed', true);
        }

        private function getTableWithPrefix($tableName)
        {
            global $wpdb;

            return $wpdb->prefix . $tableName;
        }
    }

    class ICEPAY_Paymentmethod_Core extends WC_Payment_Gateway
    {
        public function __construct()
        {
            global $wpdb;

            $paymentMethod = $wpdb->get_row("SELECT * FROM `{$this->getTableWithPrefix('woocommerce_icepay_pminfo')}` WHERE `id` = '{$this->pmCode}'");

            $this->id = "ICEPAY_{$paymentMethod->pm_code}";
            $this->method_title = "{$paymentMethod->pm_name}";
            $this->paymentMethodCode = $paymentMethod->pm_code;

            add_action("woocommerce_update_options_payment_gateways_{$this->id}", array($this, 'process_admin_options'));

            $this->form_fields = array(
                'stepone' => array(
                    'title' => $this->method_title,
                    'type' => 'title'
                ),
                'enabled' => array(
                    'title' => __('Active', 'icepay'),
                    'type' => 'checkbox',
                    'label' => ' ',
                    'description' => __('Enable or disable the payment method during the checkout process', 'icepay'),
                    'desc_tip' => true
                ),
                'displayname' => array(
                    'title' => __('Displayname', 'icepay'),
                    'type' => 'text',
                    'class' => 'ic-input',
                    'description' => __('Name that will be displayed during the checkout.', 'icepay'),
                    'desc_tip' => true
                )
            );

            $this->init_settings();

            if (empty($this->settings['displayname']))
            {
                $this->settings['displayname'] = $paymentMethod->pm_name;
            }

            $this->title = $this->get_option('displayname');
            $this->iceCoreSettings = get_option($this->plugin_id . 'ICEPAY_settings', null);

            $paymentMethods = $wpdb->get_var("SELECT raw_pm_data FROM `{$this->getTableWithPrefix('woocommerce_icepay_pmrawdata')}`");

            if ($paymentMethods != null)
            {
                $paymentMethods = unserialize($wpdb->get_var("SELECT raw_pm_data FROM `{$this->getTableWithPrefix('woocommerce_icepay_pmrawdata')}`"));

                $method = Icepay_Api_Webservice::getInstance()->singleMethod()->loadFromArray($paymentMethods);
                $pMethod = $method->selectPaymentMethodByCode($paymentMethod->pm_code);

                $issuers = $pMethod->getIssuers();

                $output = sprintf("<input type='hidden' name='paymentMethod' value='%s' />", $paymentMethod->pm_code);

                $image = sprintf("%s/assets/images/%s.png", plugins_url('', __FILE__), strtolower($paymentMethod->pm_code));
                $output .= "<img src='{$image}' />";

                if (count($issuers) > 1)
                {
                    __('AMEX', 'icepay');
                    __('VISA', 'icepay');
                    __('MASTER', 'icepay');
                    __('ABNAMRO', 'icepay');
                    __('ASNBANK', 'icepay');
                    __('ING', 'icepay');
                    __('RABOBANK', 'icepay');
                    __('SNSBANK', 'icepay');
                    __('SNSREGIOBANK', 'icepay');
                    __('TRIODOSBANK', 'icepay');
                    __('VANLANSCHOT', 'icepay');
                    __('KNAB', 'icepay');

                    $output .= "<select name='{$paymentMethod->pm_code}_issuer' style='width:164px; padding: 2px; margin-left: 7px;'>";
                    $output .= "<option selected='selected' disabled='disabled'>";
                    $output .= __('Choose your payment method', 'icepay');
                    $output .= "</option>";

                    foreach ($issuers as $issuer)
                    {
                        $output .= sprintf("<option value='%s'>%s</option>", $issuer['IssuerKeyword'], __($issuer['IssuerKeyword'], 'icepay'));
                    }

                    $output .= '</select>';
                }

                $this->description = $output;
            }
        }

        public function admin_options()
        {
            ob_start();
            $this->generate_settings_html();
            $settings = ob_get_contents();
            ob_end_clean();

            $variables = array(
                '{image}' => plugins_url('', __FILE__) . '/assets/images/icepay-header.png',
                '{manual}' => __('View the manual', 'icepay'),
                '{website}' => __('Visit the ICEPAY website', 'icepay'),
                '{settings}' => $settings
            );

            $template = file_get_contents(plugin_dir_path(__FILE__) . 'templates/admin_paymentmethod.php');

            foreach ($variables as $key => $value)
            {
                $template = str_replace($key, $value, $template);
            }

            echo $template;
        }

        public function process_payment($order_id)
        {
            global $wpdb;

            $order = new WC_Order($order_id);

            // Get the order and fetch the order id
            $orderID = $order->id;

            try
            {
                $webservice = Icepay_Api_Webservice::getInstance()->paymentService();
                $webservice->addToExtendedCheckoutList(array('AFTERPAY'))->setMerchantID($this->iceCoreSettings['merchantid'])->setSecretCode($this->iceCoreSettings['secretcode']);

                $paymentMethod = explode('_', $order->payment_method);
                $pmCode = strtoupper($paymentMethod[1]);

                if ($webservice->isExtendedCheckoutRequiredByPaymentMethod($pmCode))
                {
                    $consumerID = ($order->user_id == null) ? 'Guest' : $order->user_id;

                    // Set Consumer Info
                    Icepay_Order::getInstance()
                        ->setConsumer(Icepay_Order_Consumer::create()
                            ->setConsumerID($consumerID)
                            ->setEmail($order->billing_email)
                            ->setPhone($order->billing_phone)
                        );

                    // Add Products
                    foreach ($order->get_items() as $item)
                    {
                        $product = $order->get_product_from_item($item);

                        $pricePerProduct = $item['line_total'] / $item['qty'];

                        $taxRateMultiplier = round(($item['line_tax'] / $item['line_total']) + 1, 2);
                        $taxRatePercentage = round($item['line_tax'] / $item['line_total'] * 100, 2);

                        $price = round($pricePerProduct * $taxRateMultiplier, 2) * 100;

                        Icepay_Order::getInstance()
                            ->addProduct(Icepay_Order_Product::create()
                                ->setProductID($product->id)
                                ->setProductName(htmlentities($product->post->post_title))
                                ->setDescription(htmlentities($product->post->post_title))
                                ->setQuantity($item['qty'])
                                ->setUnitPrice($price)
                                ->setVATCategory(Icepay_Order_VAT::getCategoryForPercentage($taxRatePercentage))
                            );
                    };

                    $billingAddress = $order->billing_address_1 . " " . $order->billing_address_2;

                    // Billing Address
                    Icepay_Order::getInstance()
                        ->setBillingAddress(
                            Icepay_Order_Address::create()
                                ->setInitials($order->billing_first_name)
                                ->setLastName($order->billing_last_name)
                                ->setStreet(Icepay_Order_Helper::getStreetFromAddress($billingAddress))
                                ->setHouseNumber(Icepay_Order_Helper::getHouseNumberFromAddress($billingAddress))
                                ->setHouseNumberAddition(Icepay_Order_Helper::getHouseNumberAdditionFromAddress($billingAddress))
                                ->setZipCode($order->billing_postcode)
                                ->setCity($order->billing_city)
                                ->setCountry($order->billing_country)
                        );

                    $shippingAddress = $order->shipping_address_1 . " " . $order->shipping_address_2;

                    // Shipping Address
                    Icepay_Order::getInstance()
                        ->setShippingAddress(
                            Icepay_Order_Address::create()
                                ->setInitials($order->shipping_first_name)
                                ->setLastName($order->shipping_last_name)
                                ->setStreet(Icepay_Order_Helper::getStreetFromAddress($shippingAddress))
                                ->setHouseNumber(Icepay_Order_Helper::getHouseNumberFromAddress($shippingAddress))
                                ->setHouseNumberAddition(Icepay_Order_Helper::getHouseNumberAdditionFromAddress($shippingAddress))
                                ->setZipCode($order->shipping_postcode)
                                ->setCity($order->shipping_city)
                                ->setCountry($order->shipping_country)
                        );

                    // Shipping
                    if ($order->order_shipping != '0.00')
                    {
                        $taxRate = (int)(string)($order->order_shipping_tax / $order->order_shipping * 100);
                        $taxAmount = (int)(string)($order->order_shipping_tax * 100);
                        $shippingCosts = ((int)(string)($order->order_shipping * 100)) + $taxAmount;
                        Icepay_Order::getInstance()->setShippingCosts($shippingCosts, $taxRate);
                    }

                    // Discount
                    if ($order->order_discount != '0.00')
                    {
                        $orderDiscount = (int)(string)($order->order_discount * 100);
                        Icepay_Order::getInstance()->setOrderDiscountAmount($orderDiscount);
                    }
                }

                // Initiate icepay object
                $ic_obj = new StdClass();

                // Get the grand total of order
                $ic_obj->amount = (int)(string)($order->order_total * 100);

                // Get the billing country
                $ic_obj->country = $order->billing_country;

                // Get the used currency for the shop
                $ic_obj->currency = get_woocommerce_currency();

                // Get the Wordpress language and adjust format so ICEPAY accepts it.
                $language_locale = get_bloginfo('language');
                $ic_obj->language = strtoupper(substr($language_locale, 0, 2));

                // Get paymentclass
                $paymentMethods = unserialize($wpdb->get_var("SELECT raw_pm_data FROM `{$this->getTableWithPrefix('woocommerce_icepay_pmrawdata')}`"));

                $method = Icepay_Api_Webservice::getInstance()->singleMethod()->loadFromArray($paymentMethods);
                $pMethod = $method->selectPaymentMethodByCode($this->paymentMethodCode);

                $supportedIssuers = $pMethod->getIssuers();
                $issuerName = sprintf('%s_issuer', $paymentMethod[1]);

                if (isset($_POST[$issuerName]))
                {
                    $issuer = $_POST[$issuerName];
                }
                elseif (count($supportedIssuers > 0))
                {
                    $issuer = $supportedIssuers[0]['IssuerKeyword'];
                }
                else
                {
                    $issuer = 'DEFAULT';
                }

                $description = !empty($this->iceCoreSettings['descriptiontransaction']) ? $this->iceCoreSettings['descriptiontransaction'] : null;

                // Add transaction to ICEPAY table
                $wpdb->insert($this->getTableWithPrefix('woocommerce_icepay_transactions'), array('order_id' => $order_id, 'status' => Icepay_StatusCode::OPEN, 'transaction_id' => NULL));
                $lastid = $wpdb->insert_id;

                $paymentObj = new Icepay_PaymentObject();
                $paymentObj->setOrderID($lastid)
                    ->setDescription($description)
                    ->setReference($orderID)
                    ->setAmount($ic_obj->amount)
                    ->setCurrency($ic_obj->currency)
                    ->setCountry($ic_obj->country)
                    ->setLanguage($ic_obj->language)
                    ->setPaymentMethod($pmCode)
                    ->setIssuer($issuer);

                /* Start the transaction */
                if ($webservice->isExtendedCheckoutRequiredByPaymentMethod($pmCode))
                {
                    $transactionObj = $webservice->extendedCheckOut($paymentObj);
                }
                else
                {
                    $transactionObj = $webservice->CheckOut($paymentObj);
                }

                // Get payment url and redirect to paymentscreen
                $url = $transactionObj->getPaymentScreenURL();
            }
            catch (Exception $e)
            {
                if ($e->getMessage() == 'IC_ERR: Currency is not supported in country')
                {
                    $message = __('Currency is not supported by this payment method', 'icepay');
                }
                elseif ($e->getMessage() == 'IC_ERR: Duplicate IC_OrderID')
                {
                    $message = __('This order ID already exists. Please contact the shop.', 'icepay');
                }
                else
                {
                    $message = $e->getMessage();
                }

                wc_add_notice(__('Payment error:', 'woocommerce') . ' ' . $message, 'error');

                $order = new WC_Order($orderID);
                $order->add_order_note("Customer tried to make an attempt to complete the order but an error occured: {$message}");

                return false;
            }

            return array(
                'result' => 'success',
                'redirect' => $url
            );
        }

        private function getTableWithPrefix($tableName)
        {
            global $wpdb;

            return $wpdb->prefix . $tableName;
        }
    }

    function IC_add_action_plugin($actions, $plugin_file)
    {
        static $plugin;

        if (!isset($plugin))
        {
            $plugin = plugin_basename(__FILE__);
        }

        if ($plugin == $plugin_file)
        {
            $actions = array_merge(array('settings' => '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=icepay') . '">' . __('Settings', 'General') . '</a>'), $actions);
        }

        return $actions;
    }

    for ($i = 1; $i < 15; $i++)
    {
        require(realpath(dirname(__FILE__)) . "/classes/placeholder/paymentmethod{$i}.php");
    }

    new ICEPAY();
}
