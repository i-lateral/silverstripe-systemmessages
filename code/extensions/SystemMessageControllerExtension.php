<?php

class SystemMessageControllerExtension extends Extension
{
    private static $allowed_actions = array(
        "closesystemmessage"
    );

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

        // If not a message then generate an error 
        if (!$message) {
            return $this->owner->httpError(500);
        }

        if ($member) {
            $message->close($member);
        } else {
            $message->close();
        }

        return $this->owner->redirectBack();
    }
}