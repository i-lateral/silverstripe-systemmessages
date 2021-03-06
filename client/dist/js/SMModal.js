(function($) {
    var UseBootstrap = $UseBootstrap;
    function SMModal($object) {
        if (UseBootstrap) {
            $object.modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
        } else {
            $object.lightbox_me({
                centered: true, 
                destroyOnClose: true,
                closeClick: false,
                closeEsc: false
            });
        }
    };

    $('.system-message-modal').each(function() {
        DelayTime = $(this).attr('data-delay');
        $object = $(this);
        if (DelayTime > 0) {
            var idleTimer = setTimeout(function () { 
                SMModal($object);
            }, DelayTime * 1000);

            $('*').bind('click mouseup mousedown keydown keypress keyup submit change scroll resize dblclick', function () {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(function () { 
                    SMModal($object);
                }, DelayTime * 1000);
            });
        } else {
            SMModal($(this));
        }
    });
}(jQuery));