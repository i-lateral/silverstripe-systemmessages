<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\Admin\ModelAdmin;
use ilateral\SilverStripe\SystemMessages\SystemMessage;

/**
 * Admin interface 
 *
 */
class SystemMessageAdmin extends ModelAdmin
{
    private static $url_segment = 'systemmessages';

    private static $menu_title = 'System Messages';

    private static $menu_priority = 5;
    
    private static $managed_models = array(
        SystemMessage::class
    );
    
}