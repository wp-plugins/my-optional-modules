<?php 
/**
 * Initiate main classes
 *
 */

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

$myoptionalmodules_plugin = new myoptionalmodules();
$myoptionalmodules_plugin->actions();
$myoptionalmodules_plugin->userlevel();
$myoptionalmodules_plugin->validate_ip_address();

$myoptionalmodules_enable = new myoptionalmodules_enable();
$myoptionalmodules_enable->actions();

$myoptionalmodules_disable = new myoptionalmodules_disable();
$myoptionalmodules_disable->actions();

$myoptionalmodules_comment_form = new myoptionalmodules_comment_form();
$myoptionalmodules_comment_form->actions();

$myoptionalmodules_extras = new myoptionalmodules_extras();
$myoptionalmodules_extras->actions();

$myoptionalmodules_misc = new myoptionalmodules_misc();
$myoptionalmodules_misc->actions();
