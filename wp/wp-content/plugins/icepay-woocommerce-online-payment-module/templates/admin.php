<div style="background-image: url('{image}');" id="icepay-header">
    <div id="icepay-header-info">
        <a href="http://www.icepay.com/downloads/pdf/manuals/wordpress-woocommerce/manual-wordpress-woocommerce.pdf" target="_BLANK">{manual}</a> | <a href="http://www.icepay.com"  target="_BLANK">{website}</a>
    </div>
</div>

<br class="clear">

{upgrade_notice}
{error}

<h2 class='nav-tab-wrapper woo-nav-tab-wrapper tabs'>
    <a href='#tab1' class="nav-tab">{configuration}</a>
    <a href='#tab2' class="nav-tab">{payment_methods}</a>
    <a href='#tab3' class="nav-tab">{information}</a>
</h2>

<div id='tab1'>
    <table class="form-table">
        {settings}
    </table>
</div>

<div id='tab2'>
    <br class="clear">

    <table class="form-table" style="max-width:43%;">
        <tr valign="top">
            <td class="forminp">
                <table class="wc_gateways widefat" cellspacing="0">
                    <thead>
                    <tr>
                        <th colspan="2" class="name">{payment_methods}</th>
                        <th class="settings"></th>
                    </tr>
                    </thead>
                    <tbody id="IC_methods">
                        {list}
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="3"><span class="description"><input id="ic_refreshpaymentmethods" type="submit" value="Refresh payment methods" class="button-primary right"></span></th>
                    </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>

    <p>{missing_methods) <a href="https://portal.icepay.com/">portal.icepay.com</a></p>
</div>

<div id='tab3'>
    <br class="clear">

    <table class="wc_status_table widefat" cellspacing="0" id="status" style="max-width:45%;">
        <thead>
        <tr>
            <th colspan="3">ICEPAY Payment Module</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{IC_version}:</td>
            <td>{version}</td>
        </tr>
        <tr>
            <td></td>
            <td>{IC_API}</td>
        </tr>
        <tr>
            <td>{WC_version_label}:</td>
            <td>{WC_version}</td>
        </tr>
        <tr>
            <td>{WP_version_label}:</td>
            <td>{WP_version}</td>
        </tr>
        </tbody>
    </table>

    <p>{IC_Support}.</p>
</div>
