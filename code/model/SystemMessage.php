<?php

/**
 * A system message that can be loaded onto the front end of a site and dismissed
 * via a button click.
 *
 * @package SystemMessage
 * @author Mo <morven@ilateral.co.uk>
 */
class SystemMessage extends DataObject
{
    private static $db = array(
        "Content"       => "HTMLText",
        "ButtonText"    => "Varchar",
        "StartDate"     => "SS_Datetime",
        "ExpiryDate"    => "SS_Datetime",
        "Type" => "Enum('Banner,Modal','Banner')",
        "MessageType" => "Enum('success,info,warning,danger','success')"
    );

    private static $has_one = array(
        'Link'		=> 'Link'
    );

    private static $belongs_many_many = array(
        "ClosedBy" => "Member"
    );

    private static $summary_fields = array(
        "Content.Summary" => "Content",
        "StartDate"       => "Starts",
        "ExpiryDate"      => "Expires",
        "MessageType" => "Message Type"
    );

    private static $defaults = array(
        "ButtonText" => "Close"
    );

    /**
     * Link to close this message
     *
     * @return string
     */
    public function CloseLink()
    {
        return Controller::join_links(
            Controller::curr()->Link("closesystemmessage"),
            $this->ID
        );
    }

    /**
     * Has the current message been closed by the selected member
     *
     * @param Member $member A member object to check
     * @return Boolean
     */
    public function isClosedByMember(Member $member)
    {
        $match = $this->ClosedBy()->byID($member->ID);
        return ($match) ? true : false;
    }

    /**
     * Is the current message closed (either by the passed member or a
     * cookie)
     *
     * @param Int $memberID ID of member to search for (if not set current member is used)
     * @return Boolean
     */
    public function isClosed(Member $member = null)
    {
        $match = false;

        if ($member) {
            $match = $this->isClosedByMember($member);
        } else {
            $cookie = Cookie::get("systemmessage.closed.{$this->ID}");
            $session = Session::get("systemmessage.closed.{$this->ID}");

            if ($cookie || $session) {
                $match = true;
            }
        }

        return ($match) ? true : false;
    }

    /**
     * Is the current message open (either by the passed member or a
     * cookie)
     *
     * @param Int $memberID ID of member to search for (if not set current member is used)
     * @return Boolean
     */
    public function isOpen(Member $member = null)
    {
        return !$this->isClosed($member);
    }

    /**
     * Close this message for the current user, either
     * via the database  or by a cookie
     *
     * @param Member $member If we want to close for a member
     * @return NULL
     */
    public function Close(Member $member = null)
    {
        if ($member) {
            $member->ClosedMessages()->add($this);
        } else {
            Cookie::set("systemmessage.closed.{$this->ID}", true);
            Session::set("systemmessage.closed.{$this->ID}", true);
        }
    }

    /**
     * Pass the global JS config (for use in our templates).
     *
     * @return Boolean
     */
    public function UseDefaultJS()
    {
        return SystemMessages::config()->use_default_js;
    }

    /**
     * Pass the global Bootstrap config (for use in our templates).
     *
     * @return Boolean
     */
    public function UseBootstrap()
    {
        return SystemMessages::config()->use_bootstrap;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link to page or file'));

        return $fields;
    }
}