<% with $Message %>
    <% if $isOpen %>
        <% if $Type == "Banner" %>
            <% require css("systemmessages/css/system_messages.css") %>
            <div class="system-message system-message-banner tools-alert alert alert-$MessageType">
                <a href="$CloseLink" class="system-message-close-button close" data-dismiss="alert" title="$ButtonText">&times;</a>
                
                <div class="system-message-content">
                    $Content
                </div>

                <div class="system-message-buttons">
                    <% if $Link.LinkURL %>
                        <a href="{$CloseLink}?BackURL={$Link.LinkURL}" $Link.TargetAttr class="btn system-message-link-button">$Link.Title</a>
                    <% end_if %>

                    <a href="$CloseLink" class="btn system-message-close-button" data-dismiss="alert" title="$ButtonText">$ButtonText</a>
                </div>
            </div>
        <% else %>
            <% if $UseDefaultJS %>
                <% require javascript("silverstripe/admin:thirdparty/jquery/jquery.js") %>
                <% require javascript("i-lateral/silverstripe-systemmessages:client/dist/js/jquery.lightbox_me.min.js") %>
                <% require javascript("i-lateral/silverstripe-systemmessages:client/dist/js/sm_lightbox.min.js") %>
                <% require css("i-lateral/silverstripe-systemmessages:client/dist/css/system_messages.css") %>
            <% else_if $UseBootstrap %>
                <% require javascript("i-lateral/silverstripe-systemmessages:client/dist/js/sm_bootstrap.min.js") %>
            <% end_if %>

            <div class="modal fade system-message<% if not $UseBootstrap %> system-message-lightbox<% else %> system-message-bsmodal<% end_if %>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content system-message-content alert alert-$MessageType">
                        <div class="modal-body">
                            $Content
                        </div>

                        <div class="modal-footer system-message-buttons">
                            <% if $Link.LinkURL %>
                                <a href="{$CloseLink}?BackURL={$Link.LinkURL}" $Link.TargetAttr class="btn btn-default system-message-link-button">$Link.Title</a>
                            <% end_if %>

                            <a href="$CloseLink" class="btn btn-default system-message-close-button">$ButtonText</a>
                        </div>
                    </div>
                </div>
            </div>
        <% end_if %>
    <% end_if %>
<% end_with %>