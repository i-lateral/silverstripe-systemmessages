<% with $Message %>
    <% if $isOpen %>
        <% if $Type == "Banner" %>
            <% require javascript("systemmessages/js/sm_banner.js") %>
            <% require css("systemmessages/css/system_messages.css") %>
            <div class="system-message system-message-banner alert alert-$MessageType">
                <a href="$CloseLink" class="btn system-message-close-button close" data-dismiss="alert" title="$ButtonText">&times;</a>
                <div class="system-message-content">
                    $Content
                </div>

                <div class="system-message-buttons">
                    <% if $Link.LinkURL %>
                        <a href="{$CloseLink}?BackURL={$Link.LinkURL}" $Link.TargetAttr class="btn system-message-link-button">$Link.Title</a>
                    <% end_if %>
                </div>
            </div>
        <% else %>
            <% if UseDefaultJQuery %>
                <% require javascript("systemmessages/js/jquery.lightbox_me.js") %>
                <% require javascript("systemmessages/js/sm_lightbox.js") %>
                <div class="system-message system-message-lightbox alert alert-$MessageType">
                <div class="system-message-content">
                    $Content
                </div>

                <div class="system-message-buttons">
                    <a href="$CloseLink" class="btn system-message-close-button">$ButtonText</a>
                    <% if $Link.LinkURL %>
                        <a href="{$CloseLink}?BackURL={$Link.LinkURL}" $Link.TargetAttr class="btn system-message-link-button">$Link.Title</a>
                    <% end_if %>
                </div>
                </div>
            <% else %>
                <% require javascript("systemmessages/js/sm_bootstrap.js") %>
                <div class="modal fade system-message system-message-bsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content system-message-content alert alert-$MessageType">
                    <div class="modal-body">
                        $Content
                    </div>
                    <div class="modal-footer system-message-buttons">
                        <a href="$CloseLink" class="btn btn-default system-message-close-button">$ButtonText</a>
                        <% if $Link.LinkURL %>
                            <a href="{$CloseLink}?BackURL={$Link.LinkURL}" $Link.TargetAttr class="btn system-message-link-button">$Link.Title</a>
                        <% end_if %>
                    </div>
                    </div>
                </div>
                </div>
            <% end_if %>
        <% end_if %>
    <% end_if %>
<% end_with %>