<?php

namespace ilateral\SilverStripe\SystemMessages;

use SilverStripe\Core\Extension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class MessageInjector extends Extension
{
    public function afterCallActionHandler(HTTPRequest $request, $action, $response)
    {
        $params = $request->routeParams();

        if (!isset($params['Controller']) || !method_exists($response, 'getValue')) {
            return $response;
        }

        /** @var SystemMessages */
        $helper = Injector::inst()->get(SystemMessages::class);
        $blacklist = $helper->getBlacklistedControllers();
        $controller = $params['Controller'];

        foreach ($blacklist as $class) {
            if (is_a($controller, $class, true)) {
                return $response;
            }
        }

        $message_html = $helper->forTemplate();
        $html = $response->getValue();
        $html = preg_replace(
            '#(<body(>+|[\s]+(.*)?>))#i',
            '\\1' . $message_html,
            $html
        );

        $response->setValue($html);

        return $response;
    }
}