<?php

/**
 * Simple object to hold generic settings and functions
 * for SystemMessages object.
 *
 * @package SystemMessages
 * @author Mo <morven@ilateral.co.uk>
 */
class SystemMessages extends ViewableData
{
    /**
     * Set whether or not to use edfault JS libs (such as Lightbox_me)
     *
     * @var boolean
     * @config
     */
    private static $use_default_js = true;

    /**
     * Set whether to use Bootstrap specific libs (currently only modal JS)
     *
     * @var boolean
     * @config
     */
    private static $use_bootstrap = false;

    /**
     * Get the most recent, open system message for the current
     * user.
     *
     * @return SystemMessage
     */
    public function Message() {
        return $this->OpenMessages()->first();
    }

    /**
     * Get the most recent message and render into a template
     * 
     * @return string HTML of the message
     */
    public function RenderedMessage() {
        return $this->renderWith(
            "SystemMessage",
            array(
                "Message" => $this->Message()
            )
        );
    }

    public function OpenMessages() {
        $now = SS_Datetime::now()->Value;
        $return = ArrayList::create();
        $member = Member::currentUser();
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

        return $return;
    }

}