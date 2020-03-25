<?php

// Enable Subsite Support if needed
if(class_exists('Subsite')) {
    SystemMessageAdmin::add_extension('SubsiteMenuExtension');
    SystemMessage::add_extension("SystemMessage_SubsiteExtension");
}
