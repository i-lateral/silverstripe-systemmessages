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
        "ExpiryDate"    => "SS_Datetime"
    );

    private static $has_one = array(
        'Link'		=> 'Link'
    );

    private static $belongs_many_many = array(
        "ClosedBy" => "Member"
    );

    /**
     * Link to close this message
     *
     * @return string
     */
    public function CloseLink()
    {
        return Controller::curr()->Link("closesystemmessage");
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
            $match = Cookie::get("systemmessage.closed.{$this->ID}");
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
        }
    }
}