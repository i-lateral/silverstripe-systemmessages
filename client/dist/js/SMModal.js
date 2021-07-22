(function($) {
    var use_bootstrap = $UseBootstrap;

    function SMModal(object) {
        if (use_bootstrap) {
            object.modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
        } else {
            object.lightbox_me({
                centered: true, 
                destroyOnClose: true,
                closeClick: false,
                closeEsc: false
            });
        }
    };

    $('.system-message-modal').each(function() {
        delay_time = $(this).attr('data-delay');
        object = $(this);
        if (delay_time > 0) {
            var idle_timer = setTimeout(
                function () { 
                    SMModal(object);
                },
                delay_time * 1000
            );

            $('*').bind(
                'click mouseup mousedown keydown keypress keyup submit change scroll resize dblclick',
                function () {
                    clearTimeout(idle_timer);
                    idle_timer = setTimeout(
                        function () { 
                            SMModal(object);
                        },
                        delay_tTime * 1000
                    );
                }
            );
        } else {
            SMModal($(this));
        }
    });
}(jQuery));