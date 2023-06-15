<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldConfig;
use ilateral\SilverStripe\SystemMessages\SystemMessage;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

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

    public function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        $config
             ->removeComponentsByType(GridFieldAddNewButton::class)
             ->addComponent(new GridFieldAddNewMultiClass());

        return $config;
    }
}
