<% if $isOpen %>
    <% if $Type == "Banner" %>
        <div id="system-message-banner-{$ID}" class="system-message system-message-banner tools-alert alert alert-$MessageType">
            <a href="{$CloseLink}" class="system-message-banner-close-button close" title="{$ButtonText}" data-closeid="system-message-banner-{$ID}">&times;</a>
            
            <div class="system-message-content">
                $Content

                <% if $Link.LinkURL %>
                    <a href="{$CloseLink}?BackURL={$Link.LinkURL}" $Link.TargetAttr class="tingle-btn tingle-btn--default system-message-link-button">$Link.Title</a>
                <% end_if %>
            </div>
        </div>
    <% else %>
        <div class="system-message system-message-modal" tabindex"-1" data-delay="{$Delay}" data-closeurl="{$CloseLink}">
            <div class="system-message-modal-content">$Content</div>

            <% if $Link.LinkURL %><div class="system-message-modal-footer">
                <a href="{$CloseLink}?BackURL={$Link.LinkURL}" $Link.TargetAttr class="tingle-btn tingle-btn--default system-message-link-button">$Link.Title</a>
            </div><% end_if %>
        </div>
    <% end_if %>
<% end_if %>