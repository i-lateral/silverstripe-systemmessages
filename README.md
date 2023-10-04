Silverstripe System Messages Module
===================================


[![Build Status](https://api.travis-ci.org/i-lateral/silverstripe-systemmessages.svg?branch=master)](https://travis-ci.org/i-lateral/silverstripe-systemmessages)
[![Latest Stable Version](https://poser.pugx.org/i-lateral/silverstripe-systemmessages/v/stable)](https://packagist.org/packages/i-lateral/silverstripe-systemmessages)
[![Total Downloads](https://poser.pugx.org/i-lateral/silverstripe-systemmessages/downloads)](https://packagist.org/packages/i-lateral/silverstripe-systemmessages)
[![License](https://poser.pugx.org/i-lateral/silverstripe-systemmessages/license)](https://packagist.org/packages/i-lateral/silverstripe-systemmessages)

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

Once installed, messages will be added automatically to your templates. Alternatively, you can add the following template variable:

    $SystemMessages

to any templates you require messages to appear on.

You can manage messages in the admin area using the
"Messages" tab.

### Built in JS libs

By default, system messages uses lightbox_me for modal messages. 
This can be disabled in the config for using your own jquery, disabling
this will give the message the default bootstrap modal classes.

config.yml 

    SystemMessages:
      use_default_js: false

_config.php

    SystemMessages::config()->use_default_js = false;
    
### Bootstrap support

All HTML uses bootstrap class names as well as custom system message ones
but the modal box will not auto open on load.

To enable modal auto opening on load, change the **use_bootstrap** config
variable:

config.yml 

    SystemMessages:
      use_bootstrap: true

_config.php

    SystemMessages::config()->use_bootstrap = true;