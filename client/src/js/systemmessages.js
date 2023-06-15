let tingle = require('tingle.js');

function ajaxquery(url) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {};
    xhttp.open("GET", url, true);
    xhttp.send();
}

function sytemmessagemodal(object, close_url) {
    var modal = new tingle.modal({
        footer: true,
        stickyFooter: true,
        cssClass: ['system-message-modal-box'],
        closeMethods: [],
        beforeClose: function() {
            ajaxquery(close_url);
            return true;
        }
    });

    var content_holders = object.getElementsByClassName("system-message-modal-content");
    var footer_holders = object.getElementsByClassName("system-message-modal-footer");

    if (content_holders.length > 0) {
        modal.setContent(content_holders[0].innerHTML);
    }
    if (footer_holders.length > 0) {
        modal.setFooterContent(footer_holders[0].innerHTML);
    }

    modal.addFooterBtn(
        object.dataset.closetext,
        'tingle-btn tingle-btn--danger tingle-btn--pull-right',
        function() { modal.close(); }
    );
    modal.open();
};

document.body.addEventListener(
    'click',
    function(event) {
        target  = event.target;

        if (target.classList.contains('system-message-banner-close-button')) {
            let banner_id = target.dataset.closeid;
            event.preventDefault();
            ajaxquery(target.href);
            let banner = document.getElementById(banner_id);

            if (document.contains(banner)) {
                banner.remove();
            }
        }
    }
);

var modals = document.getElementsByClassName('system-message-modal');

for (var i = 0; i < modals.length; i++) {
    var modal = modals[i];
    var delay_time = modal.dataset.delay;
    var close_url = modal.dataset.closeurl;
    if (delay_time > 0) {
        setTimeout(
            function () { sytemmessagemodal(modal, close_url); },
            delay_time * 1000
        );
    } else {
        sytemmessagemodal(modal, close_url);
    }

    modal.remove();
}