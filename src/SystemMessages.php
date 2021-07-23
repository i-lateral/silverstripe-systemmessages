<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\ORM\ArrayList;
use SilverStripe\Security\Member;
use SilverStripe\View\ViewableData;
use ilateral\SilverStripe\SystemMessages\SystemMessage;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Security\Security;

/**
 * Simple object to hold generic settings and functions
 * for SystemMessages object.
 *
 * @package SystemMessages
 * @author Mo <morven@ilateral.co.uk>
 */
class SystemMessages extends ViewableData
{
    const BACK_URL = "BackURL";

    /**
     * Get the most recent, open system message for the current
     * user.
     *
     * @return SystemMessage
     */
    public function Message()
    {
        return $this->OpenMessages()->first();
    }

    /**
     * Get the most recent message and render into a template
     *
     * @return string HTML of the message
     */
    public function RenderedMessage()
    {
        return $this->renderWith(
            SystemMessage::class,
            array(
                "Message" => $this->Message()
            )
        );
    }
    /**
     * Get all open messages and render
     *
     * @return string HTML of the message
     */
    public function RenderedMessages()
    {
        $return = [];

        foreach ($this->OpenMessages() as $message) {
            $return[] = $this->renderWith(
                SystemMessage::class,
                [ "Message" => $message ]
            );
        }

        $html = DBHTMLText::create('RenderedMessages');
        $html->setValue(implode('', $return));
        
        return $html;
    }


    public function OpenMessages()
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
}
