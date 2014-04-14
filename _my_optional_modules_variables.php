<?php 

/**
 * My Optional Modules Variables
 *
 * (1) Variables used throughout the plugin.
 *
 * @package regular_board
 */	

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

$mommodule_focus = esc_attr(get_option('mommaincontrol_focus'));
$mommodule_prettycanon    = false; 
$mommodule_fixcanon       = false; 
$mommodule_analytics      = false; 
$mommodule_count          = false; 
$mommodule_exclude        = false; 
$mommodule_focus          = false; 
$mommodule_fontawesome    = false; 
$mommodule_jumparound     = false; 
$mommodule_lazyload       = false; 
$mommodule_maintenance    = false; 
$mommodule_meta           = false; 
$mommodule_passwords      = false; 
$mommodule_postasfront    = false; 
$mommodule_reviews        = false; 
$mommodule_shortcodes     = false; 
$mommodule_themetakeover  = false; 
$mommodule_versionnumbers = false;
$mommodule_jumparound     = intval ( get_option ( 'mommaincontrol_momja' ) );
$mommodule_count          = intval ( get_option ( 'mommaincontrol_obwcountplus' ) );
$mommodule_exclude        = intval ( get_option ( 'mommaincontrol_momse' ) );
$mommodule_fontawesome    = intval ( get_option ( 'mommaincontrol_fontawesome' ) );
$mommodule_authorarchives = intval ( get_option ( 'mommaincontrol_authorarchives' ) );
$mommodule_datearchives   = intval ( get_option ( 'mommaincontrol_datearchives' ) );
$mommodule_footerscripts  = intval ( get_option ( 'mommaincontrol_footerscripts' ) );
$mommodule_protectrss     = intval ( get_option ( 'mommaincontrol_protectrss' ) );
$mommodule_lazyload       = intval ( get_option ( 'mommaincontrol_lazyload' ) );
$mommodule_maintenance    = intval ( get_option ( 'mommaincontrol_maintenance' ) );
$mommodule_meta           = intval ( get_option ( 'mommaincontrol_meta' ) );
$mommodule_rb             = intval ( get_option ( 'mommaincontrol_regularboard' ) );
$mommodule_passwords      = intval ( get_option ( 'mommaincontrol_momrups' ) );
$mommodule_reviews        = intval ( get_option ( 'mommaincontrol_reviews' ) );
$mommodule_shortcodes     = intval ( get_option ( 'mommaincontrol_shorts' ) );
$mommodule_themetakeover  = intval ( get_option ( 'mommaincontrol_themetakeover' ) );
$mommodule_versionnumbers = intval ( get_option ( 'mommaincontrol_versionnumbers' ) );
$mommodule_fixcanon       = intval ( get_option ( 'mommaincontrol_fixcanon' ) );
$momthemetakeover_youtube = esc_url  ( get_option ( 'MOM_themetakeover_youtubefrontpage' ) );
if ( $mommodule_analytics      == 1 ) $mommodule_analytics      = true;
if ( $mommodule_count          == 1 ) $mommodule_count          = true;
if ( $mommodule_exclude        == 1 ) $mommodule_exclude        = true;
if ( $mommodule_focus          == 1 ) $mommodule_focus          = true;
if ( $mommodule_fontawesome    == 1 ) $mommodule_fontawesome    = true;
if ( $mommodule_jumparound     == 1 ) $mommodule_jumparound     = true;
if ( $mommodule_authorarchives == 1 ) $mommodule_authorarchives = true;
if ( $mommodule_datearchives   == 1 ) $mommodule_datearchives   = true;
if ( $mommodule_footerscripts  == 1 ) $mommodule_footerscripts  = true;
if ( $mommodule_protectrss     == 1 ) $mommodule_protectrss     = true;
if ( $mommodule_lazyload       == 1 ) $mommodule_lazyload       = true;
if ( $mommodule_maintenance    == 1 ) $mommodule_maintenance    = true;
if ( $mommodule_meta           == 1 ) $mommodule_meta           = true;
if ( $mommodule_rb             == 1 ) $mommodule_rb             = true;
if ( $mommodule_passwords      == 1 ) $mommodule_passwords      = true;
if ( $mommodule_reviews        == 1 ) $mommodule_reviews        = true;
if ( $mommodule_shortcodes     == 1 ) $mommodule_shortcodes     = true;
if ( $mommodule_themetakeover  == 1 ) $mommodule_themetakeover  = true;
if ( $mommodule_versionnumbers == 1 ) $mommodule_versionnumbers = true;
if ( $mommodule_fixcanon       == 1 ) $mommodule_fixcanon       = true;
if ( $mommodule_exclude        === true ) add_action ( 'after_setup_theme', 'myoptionalmodules_postformats' );
if ( $mommodule_exclude        === true ) include( plugin_dir_path(__FILE__) . '/includes/modules/exclude_filter_posts.php');
if ( $mommodule_fontawesome    === true ) add_action ( 'wp_enqueue_scripts', 'myoptionalmodules_scripts' );
if ( $mommodule_authorarchives === true ) add_action ( 'template_redirect', 'myoptionalmodules_disableauthorarchives' );
if ( $mommodule_datearchives   === true ) add_action ( 'wp', 'myoptionalmodules_disabledatearchives' );
if ( $mommodule_datearchives   === true ) add_action ( 'template_redirect', 'myoptionalmodules_disabledatearchives' );
if ( $mommodule_footerscripts  === true ) add_action ( 'wp_enqueue_scripts', 'myoptionalmodules_footerscripts' );
if ( $mommodule_footerscripts  === true ) add_action ( 'wp_footer', 'wp_print_scripts', 5 );
if ( $mommodule_footerscripts  === true ) add_action ( 'wp_footer', 'wp_enqueue_scripts', 5 );
if ( $mommodule_footerscripts  === true ) add_action ( 'wp_footer', 'wp_print_head_scripts', 5 );
if ( $mommodule_maintenance    === true ) add_action ( 'wp', 'momMaintenance' );
if ( $mommodule_meta           === true ) add_action ( 'wp_head', 'mom_meta_module' );
if ( $mommodule_fontawesome    === true ) add_filter ( 'the_content', 'do_shortcode', 'font_fa_shortcode' );
if ( $mommodule_protectrss     === true ) add_filter ( 'the_content_feed', 'myoptionalmodules_rsslinkback' );
if ( $mommodule_protectrss     === true ) add_filter ( 'the_excerpt_rss', 'myoptionalmodules_rsslinkback' );
if ( $mommodule_meta           === true ) add_filter ( 'admin_init', 'myoptionalmodules_add_fields_to_general' );
if ( $mommodule_meta           === true ) add_filter ( 'user_contactmethods', 'myoptionalmodules_add_fields_to_profile' );
if ( $mommodule_meta           === true ) add_filter ( 'jetpack_enable_opengraph', '__return_false', 99 );
if ( $mommodule_rb             === true ) add_filter ( 'jetpack_enable_opengraph', '__return_false', 99 );
if ( $mommodule_versionnumbers === true ) add_filter ( 'style_loader_src', 'myoptionalmodules_removeversion', 0 );
if ( $mommodule_versionnumbers === true ) add_filter ( 'script_loader_src', 'myoptionalmodules_removeversion', 0 );

add_action ( 'init', 'my_optional_modules_add_my_shortcodes', 99 );
if ( !function_exists ( 'my_optional_modules_add_my_shortcodes' ) ) {
	function my_optional_modules_add_my_shortcodes() {
		global $mommodule_passwords, $mommodule_reviews, $mommodule_shortcodes, $mommodule_fontawesome,	$mommodule_passwords, $mommodule_reviews;
		if ( $mommodule_passwords      === true ) add_filter ( 'the_content', 'do_shortcode', 'rotating_universal_passwords_shortcode' );
		if ( $mommodule_reviews        === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_reviews_shortcode' );
		if ( $mommodule_shortcodes     === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_onthisday' );
		if ( $mommodule_shortcodes     === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_archives' );
		if ( $mommodule_shortcodes     === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_map' );
		if ( $mommodule_shortcodes     === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_reddit' );
		if ( $mommodule_shortcodes     === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_restrict' );
		if ( $mommodule_shortcodes     === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_progress' );
		if ( $mommodule_shortcodes     === true ) add_filter ( 'the_content', 'do_shortcode', 'mom_verify' );
		if ( $mommodule_fontawesome    === true ) add_shortcode ( 'font-fa',  'font_fa_shortcode' );
		if ( $mommodule_passwords      === true ) add_shortcode ( 'rups', 'rotating_universal_passwords_shortcode' );
		if ( $mommodule_reviews        === true ) add_shortcode ( 'momreviews', 'mom_reviews_shortcode' );
		if ( $mommodule_shortcodes     === true ) add_shortcode ( 'mom_archives', 'mom_archives' );
		if ( $mommodule_shortcodes     === true ) add_shortcode ( 'mom_onthisday', 'mom_onthisday' );
		if ( $mommodule_shortcodes     === true ) add_shortcode ( 'mom_map', 'mom_google_map_shortcode' );
		if ( $mommodule_shortcodes     === true ) add_shortcode ( 'mom_reddit', 'mom_reddit_shortcode' );
		if ( $mommodule_shortcodes     === true ) add_shortcode ( 'mom_restrict', 'mom_restrict_shortcode' );
		if ( $mommodule_shortcodes     === true ) add_shortcode ( 'mom_progress', 'mom_progress_shortcode' );
		if ( $mommodule_shortcodes     === true ) add_shortcode ( 'mom_verify', 'mom_verify_shortcode' );
	}
}

if ( $mommodule_fixcanon       === true ) if ( function_exists ( 'rel_canonical' ) ) { remove_action ( 'wp_head', 'rel_canonical' ); }
if ( $mommodule_fixcanon       === true ) if ( function_exists ( 'mom_canonical' ) ) {    add_action ( 'wp_head', 'mom_canonical' ); }
if ( $mommodule_meta           === true ) mom_SEO_header();
if ( get_option ( 'mompaf_post' ) ) {
	if ( get_option ( 'mompaf_post' ) != 'off' ) add_action ( 'wp', 'myoptionalmodules_postasfront' );
}