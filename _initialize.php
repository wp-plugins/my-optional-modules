<?php 
/**
 * _INITIALIZE
 *
 * File last update: 8-RC-1.5.6
 *
 * Initialize all of our plugin actions, based on the settings
 * set by the admin in /wp-admin/.
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

$myoptionalmodules_plugin                    = new myoptionalmodules();
$myoptionalmodules_enable                    = new myoptionalmodules_enable();
$myoptionalmodules_disable                   = new myoptionalmodules_disable();
$myoptionalmodules_comment_form              = new myoptionalmodules_comment_form();
$myoptionalmodules_extras                    = new myoptionalmodules_extras();
$myoptionalmodules_misc                      = new myoptionalmodules_misc();
$myoptionalmodules_shortcode_hidden          = new myoptionalmodules_hidden();
$myoptionalmodules_attachment_loop_shortcode = new myoptionalmodules_attachment_loop_shortcode();
$myoptionalmodules_mediaembed_shortcode      = new myoptionalmodules_mediaembed_shortcode();

$myoptionalmodules_plugin->actions();
$myoptionalmodules_plugin->userlevel();
$myoptionalmodules_plugin->validate_ip_address();
$myoptionalmodules_enable->actions();
$myoptionalmodules_disable->actions();
$myoptionalmodules_comment_form->actions();
$myoptionalmodules_extras->actions();
$myoptionalmodules_misc->actions();
$myoptionalmodules_shortcode_hidden->construct();
$myoptionalmodules_attachment_loop_shortcode->construct();
$myoptionalmodules_mediaembed_shortcode->construct();