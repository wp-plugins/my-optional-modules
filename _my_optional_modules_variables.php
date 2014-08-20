<?php 

/**
 *
 * Variables
 *
 * Define different variables for use throughout the plugin
 * Include appropriate files when we ask for them for different modules
 *
 * Since 1
 * @my_optional_modules
 *
 */

/**
 *
 * Don't call this file directly
 *
 */
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

$date_day                          = date( 'D' );
$date_y                            = date( 'Y' );
$date_m                            = date( 'n' );
$date_d                            = date( 'j' );

$mommodule_exclude                 = intval( get_option( 'mommaincontrol_momse' ) );
$mommodule_fontawesome             = intval( get_option( 'mommaincontrol_fontawesome' ) );
$mommodule_authorarchives          = intval( get_option( 'mommaincontrol_authorarchives' ) );
$mommodule_datearchives            = intval( get_option( 'mommaincontrol_datearchives' ) );
$mommodule_footerscripts           = intval( get_option( 'mommaincontrol_footerscripts' ) );
$mommodule_protectrss              = intval( get_option( 'mommaincontrol_protectrss' ) );
$mommodule_lazyload                = intval( get_option( 'mommaincontrol_lazyload' ) );
$mommodule_versionnumbers          = intval( get_option( 'mommaincontrol_versionnumbers' ) );
$horizontal_galleries              = intval( get_option( 'MOM_themetakeover_horizontal_galleries' ) );
$momthemetakeover_ajaxcomments     = intval( get_option( 'MOM_themetakeover_ajaxifycomments' ) );

if( 1 == $mommodule_exclude ) {

	include( plugin_dir_path( __FILE__ ) . '/includes/modules/_my_optional_modules_exclude.php' );

}

if( 1 == $mommodule_exclude ) {

	add_action( 'after_setup_theme', 'myoptionalmodules_postformats' );

}

if( 1 == $mommodule_fontawesome ) {

	add_action( 'wp_enqueue_scripts', 'myoptionalmodules_scripts' );

}

if( 1 == $mommodule_authorarchives ) {

	add_action( 'template_redirect', 'myoptionalmodules_disableauthorarchives' );

}

if( 1 == $mommodule_datearchives ) {

	add_action( 'wp', 'myoptionalmodules_disabledatearchives' );
	add_action( 'template_redirect', 'myoptionalmodules_disabledatearchives' );

}

if( 1 == $mommodule_footerscripts ) {

	add_action( 'wp_enqueue_scripts', 'myoptionalmodules_footerscripts' );
	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );

}

if( 1 == $mommodule_fontawesome ) {

	add_filter( 'the_content', 'do_shortcode', 'font_fa_shortcode' );

}

if( 1 == $mommodule_protectrss ) {

	add_filter( 'the_content_feed', 'myoptionalmodules_rsslinkback' );
	add_filter( 'the_excerpt_rss', 'myoptionalmodules_rsslinkback' );

}

if( 1 == $mommodule_versionnumbers ) {

	add_filter( 'style_loader_src', 'myoptionalmodules_removeversion', 0 );
	add_filter( 'script_loader_src', 'myoptionalmodules_removeversion', 0 );

}

if( 1 == $momthemetakeover_ajaxcomments ) {

	add_action ( 'comment_post', 'mom_ajaxComment', 20, 2 );

}

if( !function_exists( 'my_optional_modules_add_my_shortcodes' ) ) {
	add_action ( 'init', 'my_optional_modules_add_my_shortcodes', 99 );
	function my_optional_modules_add_my_shortcodes() {
		global $mommodule_fontawesome;
		if( 1 == $mommodule_fontawesome ) { 

			add_shortcode( 'font-fa',  'font_fa_shortcode' );

		}

	}

}

if( get_option( 'mompaf_post' ) ) {

	if( 'off' != get_option( 'mompaf_post' ) ) {

		add_action ( 'wp', 'myoptionalmodules_postasfront' );

	}

}