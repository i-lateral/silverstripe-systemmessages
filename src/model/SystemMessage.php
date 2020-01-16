<?php

namespace ilateral\SilverStripe\SystemMessages;

use gorriecoe\Link\Models\Link;
use SilverStripe\Control\Cookie;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Session;
use SilverStripe\Security\Member;
use gorriecoe\LinkField\LinkField;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use ilateral\SilverStripe\SystemMessages\SystemMessages;

/**
 * A system message that can be loaded onto the front end of a site and dismissed
 * via a button click.
 *
 * @package SystemMessage
 * @author Mo <morven@ilateral.co.uk>
 */
class SystemMessage extends DataObject
{
    private static $table_name = 'SystemMessage';

    private static $db = array(
        "Content"       => "HTMLText",
        "ButtonText"    => "Varchar",
        "StartDate"     => "Datetime",
        "ExpiryDate"    => "Datetime",
        "Delay" => 'Int',
        "Type" => "Enum('Banner,Modal','Banner')",
        "MessageType" => "Enum('success,info,warning,danger','success')"
    );

    private static $has_one = array(
        'Link'      => Link::class
    );

    private static $belongs_many_many = array(
        "ClosedBy" => Member::class
    );

    private static $field_labels = array(
        'Link' => 'Link to page or file'
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
        
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();

        if ($member) {
            $match = $this->isClosedByMember($member);
        } else {
            $cookie = Cookie::get("systemmessage.closed.{$this->ID}");
            $e_session = $session->get("systemmessage.closed.{$this->ID}");

            if ($cookie || $e_session) {
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
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();

        if ($member) {
            $member->ClosedMessages()->add($this);
        } else {
            Cookie::set("systemmessage.closed.{$this->ID}", true);
            $session->set("systemmessage.closed.{$this->ID}", true);
        }
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
        $self = $this;

        $this->beforeUpdateCMSFields(
            function ($fields) use ($self) {
                $fields->removeByName('LinkID');

                // Add description to delay field
                $delay_field = $fields->dataFieldByName('Delay');
                if (!empty($delay_field)) {
                    $delay_field->setDescription(
                        _t(__CLASS__ . ".DelayDescription", 'Delay in seconds to open this message')
                    );
                }
        
                if ($self->exists()) {
                    $fields->addFieldToTab(
                        'Root.Main',
                        LinkField::create('Link', $self->fieldLabel('Link'), $this)
                    );
                }
            }
        );

        return parent::getCMSFields();
    }
}
