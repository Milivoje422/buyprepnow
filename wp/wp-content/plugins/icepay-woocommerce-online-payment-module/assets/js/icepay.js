jQuery(function () {
    (function ($) {
        $('.icepay-postback-url').click(function () {
            $(this).select();
        });

        var button = '<input id="ic_refreshpaymentmethods" type="submit" value="' + objectL10n.refresh + '" class="button-primary" />';
        $('.icpaymentmethods').append(button);

        $('.icepay-postback-url').attr('readonly', 'readonly');

        $('#ic_refreshpaymentmethods').click(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: 'admin-ajax.php',
                data: {
                    action: 'ic_getpaymentmethods'
                },
                beforeSend: function () {
                    $('#ic_refreshpaymentmethods').val(objectL10n.loading).css('cursor', 'waiting').attr('disabled', 'disabled');
                    $('body').css('cursor', 'progress');
                    $("#IC_methods").empty();
                },
                success: function (html) {
                    $('#IC_methods').append(html);
                    $('#ic_refreshpaymentmethods').val(objectL10n.refresh).removeAttr('disabled');
                    $('body').css('cursor', 'auto');
                }
            });
        });

        $('h2.tabs').each(function() {
            var $active, $content, $links = $(this).find('a');

            $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
            $active.addClass('nav-tab-active');
            $content = $($active[0].hash);

            $links.not($active).each(function () {
                $(this.hash).hide();
            });

            $(this).on('click', 'a', function(e){
                $active.removeClass('nav-tab-active');
                $content.hide();

                $active = $(this);
                $content = $(this.hash);

                $active.addClass('nav-tab-active');
                $active.blur();
                $content.show();

                e.preventDefault();
            });
        });
    })(jQuery.noConflict());
});