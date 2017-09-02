jQuery(function() {
    (function($) {
        $('#refreshPaymentmethodsButton').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: 'admin-ajax.php',
                data: {
                    action: 'icepay_getPaymentMethods'
                },
                beforeSend: function() {
                    $('#refreshPaymentmethodsButton').val('Refreshing Paymentmethods...').attr('disabled', 'disabled');
                },
                success: function(html) {            
                    location.reload(true);
                }
            });
        });
    })(jQuery.noConflict());
});