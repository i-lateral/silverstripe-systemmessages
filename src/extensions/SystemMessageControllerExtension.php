<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use ilateral\SilverStripe\SystemMessages\SystemMessage;
use ilateral\SilverStripe\SystemMessages\SystemMessages;

class SystemMessageControllerExtension extends Extension
{
    private static $allowed_actions = array(
        "closesystemmessage"
    );

    public function onAfterInit()
    {
        Requirements::css("i-lateral/silverstripe-systemmessages:client/dist/styles/systemmessages.css");
        Requirements::javascript('i-lateral/silverstripe-systemmessages:client/dist/js/systemmessages.js');
    }

    public function SystemMessages()
    {
        return SystemMessages::create();
    }

    /**
     * Close the message passed by the URL's ID and return.
     * If the user is currently logged in, then mark it against
     * their account, else drop a cookie.
     *
     * @return SS_Response
     */
    public function closesystemmessage()
    {
        /** @var Controller */
        $owner = $this->getOwner();
        $request = $owner->getRequest();
        $id = $request->param("ID");
        $back_url = $request->getVar(SystemMessages::BACK_URL);
        $message = SystemMessage::get()->byID($id);
        $member = Security::getCurrentUser();

        // If not a message then generate an error
        if (!$message) {
            return $owner->httpError(500);
        }

        if ($member) {
            $message->close($member);
        } else {
            $message->close();
        }

        if (!empty($back_url)) {
            return $owner->redirect($back_url);
        } else {
            return $owner->redirectBack();
        }
    }
}
