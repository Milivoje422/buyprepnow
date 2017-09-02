<div style="background-image: url('<?php echo $this->pluginURL . '/assets/images/icepay-header.png'; ?>" id="icepay-header">
    <div id="icepay-header-info">
        <?php printf('%s %s', __('Module Version', 'icepay'), $this->version); ?> |
        <a href="http://www.icepay.com/downloads/pdf/manuals/wordpress-ecommerce/manual-wordpress-ecommerce.pdf" target="_BLANK">
            <?php printf(__('View the manual', 'icepay')); ?>
        </a> | 
        <a href="http://www.icepay.com"  target="_BLANK">
            <?php printf(__('Visit the ICEPAY website', 'icepay')); ?>
        </a>                    
    </div>
</div>

<div id="icepay-container">    
    <table class="icepay-settings">

        <form action="options.php" method="post">
            <?php settings_fields('icepay_options'); ?>
            <?php do_settings_sections('icepay_config'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e(__('Save Changes')); ?>" />
        </form>

        <?php if ((!empty($this->settings['icepay_merchantid']) && (!empty($this->settings['icepay_secretcode'])))) { ?>
            <h3 id='paymentMethodsHeader'>Paymentmethods</h3>       

            <ul id='icepay-paymentmethod-list'> 
                <?php
                if (!empty($this->paymentMethods)) {
                    foreach (unserialize($this->paymentMethods) as $paymentMethod) {
                        ?>
                        <li><a href='<?php echo get_option('siteurl') . "/wp-admin/options-general.php?page=wpsc-settings&tab=gateway&payment_gateway_id=icepay_{$paymentMethod['PaymentMethodCode']}"; ?>'><?php echo $paymentMethod['Description']; ?></a></li>
                    <?php } ?>
                </ul>
                <?php
            }
        }
        ?>
        <input type='button' id='refreshPaymentmethodsButton' value='Refresh PaymentMethods' />
        <noscript>
        <div class='error ic_getpaymentmethods_error'>Javascript must be enabled in your browser in order to fetch paymentmethods.</div>
        </noscript> 
    </table>
</div>