<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;
use SilverStripe\Control\Director;
use ilateral\SilverStripe\SystemMessages\SystemMessage;
use ilateral\SilverStripe\SystemMessages\SystemMessages;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\Requirements;

class SystemMessageControllerExtension extends Extension
{
    private static $load_jquery = false;
    private static $load_jquery_defer = false;

    private static $allowed_actions = array(
        "closesystemmessage"
    );

    public function onAfterInit()
    {
        if (Config::inst()->get(static::class, 'load_jquery')) {
            Requirements::javascript('silverstripe/admin:thirdparty/jquery/jquery.js');
        }
        if (Config::inst()->get(static::class, 'load_jquery_defer')) {
            Requirements::javascript('silverstripe/admin:thirdparty/jquery/jquery.js', ['defer' => true]);
        }

        Requirements::css("i-lateral/silverstripe-systemmessages:client/dist/css/system_messages.css");

        $vars = [
            "UseBootstrap" => Config::inst()->get(SystemMessages::class, 'use_bootstrap')
        ];

        Requirements::javascriptTemplate('vendor/i-lateral/silverstripe-systemmessages/client/dist/js/SMModal.js', $vars);
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
        $id = $this->owner->request->param("ID");
        $message = SystemMessage::get()->byID($id);
        $member = Member::currentUser();
        $action = $this->owner->request->getVars();

        // If not a message then generate an error
        if (!$message) {
            return $this->owner->httpError(500);
        }

        if ($member) {
            $message->close($member);
        } else {
            $message->close();
        }

        if ($action) {
            return $this->owner->redirect(Director::get_current_page()->Link());
        } else {
            return $this->owner->redirectBack();
        }
    }
}
