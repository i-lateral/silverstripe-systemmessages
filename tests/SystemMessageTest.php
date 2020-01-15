<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\Control\Cookie;
use SilverStripe\Control\Session;
use SilverStripe\Dev\SapphireTest;
use ilateral\SilverStripe\SystemMessages\SystemMessage;
use SilverStripe\ORM\FieldType\DBDatetime;
use ilateral\SilverStripe\SystemMessages\SystemMessages;

class SystemMessageTest extends SapphireTest
{
    
    protected static $fixture_file = 'SystemMessages.yml';

    /**
     * Test to see if a message closed by a user is flagged as "closed" or "open"
     *
     */
    public function testClosedByUser()
    {
        $member = $this->objFromFixture('Member', 'User1');
        $message = $this->objFromFixture(SystemMessage::class, 'SecondMessage');
        $this->assertTrue($message->isClosedByMember($member));
        $this->assertTrue($message->isClosed($member));
        $this->assertFalse($message->isOpen($member));
    }

    /**
     * Test to see if message is closed via cookie is flagged as "closed" or
     * "open"
     */
    public function testClosedByCookie()
    {
        // Get message and set Cookie
        $message = $this->objFromFixture(SystemMessage::class, 'FirstMessage');
        Cookie::set("systemmessage.closed.{$message->ID}", true);

        $this->assertTrue($message->isClosed());
        $this->assertFalse($message->isOpen());
    }

    /**
     * Test to see if message is closed via cookie is flagged as "closed" or
     * "open"
     */
    public function testClosedBySession()
    {
        // Get message and set Cookie
        $message = $this->objFromFixture(SystemMessage::class, 'FirstMessage');
        Session::set("systemmessage.closed.{$message->ID}", true);

        $this->assertTrue($message->isClosed());
        $this->assertFalse($message->isOpen());
    }

    /**
     * A message that is past shouldnt be visible
     *
     */
    public function testExpired()
    {
        DBDatetime::set_mock_now('2013-10-10 20:00:00');

        $messages = SystemMessages::create()->OpenMessages();

        $this->assertEquals("First Message", $messages->first()->Content);

        DBDatetime::clear_mock_now();
    }

    /**
     * A message that hasn't started yet should not be visible
     *
     */
    public function testNotStarted()
    {
        DBDatetime::set_mock_now('2013-08-10 20:00:00');

        $messages = SystemMessages::create()->OpenMessages();

        $this->assertEquals("Second Message", $messages->first()->Content);

        DBDatetime::clear_mock_now();
    }
}