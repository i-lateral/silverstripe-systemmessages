<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\ORM\ArrayList;
use SilverStripe\Dev\Deprecation;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Security\Security;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\DevelopmentAdmin;
use SilverStripe\Dev\DevBuildController;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBHTMLText;
use ilateral\SilverStripe\SystemMessages\SystemMessage;
use SilverStripe\CMS\Controllers\RootURLController;

/**
 * Simple object to hold generic settings and functions
 * for SystemMessages object.
 *
 * @package SystemMessages
 * @author Mo <morven@ilateral.co.uk>
 */
class SystemMessages
{
    use Configurable, Injectable;

    const BACK_URL = "BackURL";

    private static $inject_css = true;

    private static $inject_js = true;

    private static $controller_blacklist = [
        DevBuildController::class,
        DevelopmentAdmin::class,
        LeftAndMain::class
    ];

    public function getBlacklistedControllers(): array
    {
        return Config::inst()->get(static::class, 'controller_blacklist');
    }

    /**
     * Get the most recent, open system message for the current
     * user.
     *
     * @return SystemMessage
     */
    public function getMessage()
    {
        return $this
            ->getOpenMessages()
            ->first();
    }

    public function getRenderedMessage(): string
    {
        $message = $this->getMessage();

        if (empty($message)) {
            return "";
        }

        return $message->forTemplate()->RAW();
    }

    public function getRenderedMessages()
    {
        $return = [];

        foreach ($this->getOpenMessages() as $message) {
            /** @var SystemMessage $message */
            $return[] = $message->forTemplate()->RAW();
        }

        $html = DBHTMLText::create('RenderedMessages');
        $html->setValue(implode('', $return));

        return $html;
    }

    public function getOpenMessages(): ArrayList
    {
        $now = DBDatetime::now()->Value;
        $return = ArrayList::create();
        $member = Security::getCurrentUser();
        $filter = array(
            "StartDate:LessThan" => $now,
            "ExpiryDate:GreaterThan" => $now
        );

        // Get all applicable messages
        $messages = SystemMessage::get()
            ->filter($filter)
            ->sort("StartDate", "ASC");

        // Loop through messages and only add relevent to the list
        foreach ($messages as $message) {
            if ($message->isOpen($member)) {
                $return->add($message);
            }
        }

        return $return->removeDuplicates();
    }


    public function Message()
    {
        Deprecation::notice(
            3.3,
            "Message Depreciated, use getMessage instead"
        );
        return $this->getMessage();
    }

    public function RenderedMessage()
    {
        Deprecation::notice(
            3.3,
            "RenderedMessage Depreciated, use getRenderedMessage or auto injection"
        );
        return $this->getRenderedMessage();
    }

    public function RenderedMessages()
    {
        Deprecation::notice(
            3.3,
            "RenderedMessages Depreciated, use getRenderedMessages or auto injection"
        );
        return $this->getRenderedMessages();
    }

    public function OpenMessages()
    {
        Deprecation::notice(
            3.3,
            "OpenMessages Depreciated, use getOpenMessages"
        );
        return $this->getOpenMessages();
    }
}
