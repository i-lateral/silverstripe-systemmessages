Silverstripe System Messages Module
===================================

Module for the Silverstripe CMS that adds content manageable messages to a site
(that can be closed by via a user) via a template variable.

## Author
This module was created by [i-lateral](http://www.i-lateral.com).

## Installation

Preferable you should installl this via composer using:
    # composer require "i-lateral/silverstripe-systemmessages:0.*"

Alternativley install this module by downloading and adding to:

[silverstripe-root]/systemmessages

Then run:
    
    http://yoursiteurl.com/dev/build/?flush=1

Or:

    # sake dev/build flush=1

## Usage

Once installed, you must add the template variable:

    $SystemMessages.RenderedMessage
    
to any templates you require messages to appear on.

You can manage messages in the admin area using the
"Messages" tab.


by default, system messages uses lightbox_me for modal messages. 
This can be disabled in the config for using your own jquery, disabling this will
give the message the default bootstrap modal classes.

config.yml 

    SystemMessages:
      UseDefaultJQuery: false