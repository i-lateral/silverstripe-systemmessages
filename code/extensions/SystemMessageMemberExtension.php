<?php

class SystemMessageMemberExtension extends Extension
{
    private static $many_many = array(
        "ClosedMessages" => "SystemMessage"
    );
}