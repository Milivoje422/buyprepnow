<?php

class ICEPAY_Helper {

    public static function generateListItems($paymentMethods, &$variables) {
        if ($paymentMethods) {
            foreach ($paymentMethods as $paymentMethod) {
                $link = admin_url() . "admin.php?page=wc-settings&tab=checkout&section=icepay_paymentmethod_{$paymentMethod->id}";

                $variables['{list}'] .= "<tr>";
                $variables['{list}'] .= "<td colspan=\"2\" class=\"name\">{$paymentMethod->pm_name}</td>";
                $variables['{list}'] .= "<td class=\"settings\"><a class=\"button\" href=\"{$link}\">" . __( 'Settings', 'woocommerce' ) . "</td>";
                $variables['{list}'] .= "</tr>";
            }
        } else {
            $variables['{error}'] = '<div class="updated woocommerce-message below-h2"><p>'. __('Warning: There are no payment methods configured yet.', 'icepay') . '</p></div>';
        }
    }
    
    public static function generateAjaxListItems($paymentMethod, $i) {
        $link = admin_url() . "admin.php?page=wc-settings&tab=checkout&section=icepay_paymentmethod_{$i}";

        $variables = "<tr>";
        $variables .= "<tr>";
        $variables .= "<td colspan=\"2\" class=\"name\">{$paymentMethod['Description']}</td>";
        $variables .= "<td class=\"settings\"><a class=\"button\" href=\"{$link}\">" . __( 'Settings', 'woocommerce' ) . "</td>";
        $variables .= "</tr>";

        return $variables;
    }
    
    public static function generateAjaxError($message) {
        return "<div class='updated woocommerce-message below-h2'><p>{$message}</p></div>";
    }

    public static function isIcepayPage($id) {
        if (isset($_GET['section']) && (stripos($_GET['section'], $id) !== false))
            return true;

        return false;
    }
    
    public static function getVersion() {
        return $version = '2.3.6';
    }
    
    public static function addUpgradeNotice($message) {
        update_option('ICEPAY_UpgradeNotice', $message);
    }
    
    public static function isUpgradeNoticeAvailable() {
        if (get_option('ICEPAY_UpgradeNotice', false))
            return true;        
        
        return false;
    }
    
    public static function getUpgradeNotice() {
        $flashMessage = get_option('ICEPAY_UpgradeNotice');
        
        update_option('ICEPAY_UpgradeNotice', false);
        
        return $flashMessage;
    }
    
    public static function generateUpgradeNotice(&$variables) {
        $upgradeNotice = self::getUpgradeNotice();
        $variables['{upgrade_notice}'] = "<div class='updated woocommerce-message below-h2'><p>{$upgradeNotice}</p></div>";
    }

}
