<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\Core\Extension;
use ilateral\SilverStripe\SystemMessages\SystemMessage;

class SystemMessageMemberExtension extends Extension
{
    private static $many_many = array(
        "ClosedMessages" => SystemMessage::class
    );
}
