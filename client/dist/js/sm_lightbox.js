(function($) {
    $( document ).ready(function() {
        $('.system-message-lightbox').lightbox_me({
            centered: true, 
            destroyOnClose: true,
            closeClick: false,
            closeEsc: false
        });
    });
}(jQuery));