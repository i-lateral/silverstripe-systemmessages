<% with $Message %>
    <div class="system-message">
        <div class="system-message-content">
            $Content
        </div>

        <div class="system-message-buttons">
            <a href="$CloseLink" class="btn system-message-close-button">$ButtonText</a>
            <% if $Link %>
                <a href="$Link.LinkURL" class="btn system-message-close-button">$Link.Text</a>
            <% end_if %>
        </div>
    </div>
<% end_with %>