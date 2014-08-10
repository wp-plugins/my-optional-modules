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
$mommodule_focus                   = esc_attr(get_option('mommaincontrol_focus'));

$mommodule_jumparound              = intval( get_option( 'mommaincontrol_momja' ) );
$mommodule_count                   = intval( get_option( 'mommaincontrol_obwcountplus' ) );
$mommodule_exclude                 = intval( get_option( 'mommaincontrol_momse' ) );
$mommodule_fontawesome             = intval( get_option( 'mommaincontrol_fontawesome' ) );
$mommodule_authorarchives          = intval( get_option( 'mommaincontrol_authorarchives' ) );
$mommodule_datearchives            = intval( get_option( 'mommaincontrol_datearchives' ) );
$mommodule_footerscripts           = intval( get_option( 'mommaincontrol_footerscripts' ) );
$mommodule_protectrss              = intval( get_option( 'mommaincontrol_protectrss' ) );
$mommodule_lazyload                = intval( get_option( 'mommaincontrol_lazyload' ) );
$mommodule_maintenance             = intval( get_option( 'mommaincontrol_maintenance' ) );
$mommodule_passwords               = intval( get_option( 'mommaincontrol_momrups' ) );
$mommodule_reviews                 = intval( get_option( 'mommaincontrol_reviews' ) );
$mommodule_shortcodes              = intval( get_option( 'mommaincontrol_shorts' ) );
$mommodule_versionnumbers          = intval( get_option( 'mommaincontrol_versionnumbers' ) );
$mommaincontrol_themetakeover      = intval( get_option( 'mommaincontrol_themetakeover' ) );
$horizontal_galleries              = intval( get_option( 'MOM_themetakeover_horizontal_galleries' ) );
$mommodule_meta                    = intval( get_option( 'mommaincontrol_meta' ) );
$momthemetakeover_commentlength    = get_option( 'MOM_themetakeover_commentlength' );
$momthemetakeover_ajaxcomments     = get_option( 'MOM_themetakeover_ajaxifycomments' );
$mom_votes                         = get_option( 'mommaincontrol_votes' );

if( $mommodule_exclude            == 1 ) include( plugin_dir_path( __FILE__ ) . '/includes/modules/_my_optional_modules_exclude.php');
if( $mommaincontrol_themetakeover == 1 ) include( plugin_dir_path( __FILE__ ) . '/includes/modules/_my_optional_modules_theme_takeover_settings.php' );
if( $mommaincontrol_themetakeover == 1 ) include( plugin_dir_path( __FILE__ ) . '/includes/modules/_my_optional_modules_theme_takeover_functions.php' );
if( $mommodule_meta               == 1 ) include( plugin_dir_path( __FILE__ ) . '/includes/modules/_my_optional_modules_meta_module.php' );


if( $mommodule_exclude            == 1 ) add_action( 'after_setup_theme', 'myoptionalmodules_postformats' );
if( $mommodule_fontawesome        == 1 || $mom_votes == 1 ) add_action( 'wp_enqueue_scripts', 'myoptionalmodules_scripts' );
if( $mommodule_authorarchives     == 1 ) add_action( 'template_redirect', 'myoptionalmodules_disableauthorarchives' );
if( $mommodule_datearchives       == 1 ) add_action( 'wp', 'myoptionalmodules_disabledatearchives' );
if( $mommodule_datearchives       == 1 ) add_action( 'template_redirect', 'myoptionalmodules_disabledatearchives' );
if( $mommodule_footerscripts      == 1 ) add_action( 'wp_enqueue_scripts', 'myoptionalmodules_footerscripts' );
if( $mommodule_footerscripts      == 1 ) add_action( 'wp_footer', 'wp_print_scripts', 5 );
if( $mommodule_footerscripts      == 1 ) add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
if( $mommodule_footerscripts      == 1 ) add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
if( $mommodule_maintenance        == 1 ) add_action( 'wp', 'momMaintenance' );
if( $mommodule_fontawesome        == 1 ) add_filter( 'the_content', 'do_shortcode', 'font_fa_shortcode' );
if( $mommodule_protectrss         == 1 ) add_filter( 'the_content_feed', 'myoptionalmodules_rsslinkback' );
if( $mommodule_protectrss         == 1 ) add_filter( 'the_excerpt_rss', 'myoptionalmodules_rsslinkback' );
if( $mommodule_versionnumbers     == 1 ) add_filter( 'style_loader_src', 'myoptionalmodules_removeversion', 0 );
if( $mommodule_versionnumbers     == 1 ) add_filter( 'script_loader_src', 'myoptionalmodules_removeversion', 0 );

if( $momthemetakeover_ajaxcomments     ) add_action ( 'comment_post', 'mom_ajaxComment', 20, 2 );
if( $momthemetakeover_commentlength && $momthemetakeover_commentlength > 0 ) add_filter ( 'pre_comment_content', 'mom_limit_comment' );


add_action ( 'init', 'my_optional_modules_add_my_shortcodes', 99 );
if ( !function_exists ( 'my_optional_modules_add_my_shortcodes' ) ) {

	function my_optional_modules_add_my_shortcodes() {

		global $mom_votes,$mommaincontrol_themetakeover,$horizontal_galleries,$mommodule_passwords,$mommodule_reviews,$mommodule_shortcodes,$mommodule_fontawesome,$mommodule_passwords,$mommodule_reviews;
		if( $mom_votes                  == 1 ) add_shortcode( 'topvoted', 'vote_the_posts_top' );
		if( $mom_votes                  == 1 ) add_filter( 'the_content', 'do_shortcode','vote_the_posts_top' );
		
		if( $mommodule_reviews          == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_reviews_shortcode' );
		if( $mommodule_reviews          == 1 ) add_shortcode( 'momreviews', 'mom_reviews_shortcode' );

		if( $mommodule_fontawesome      == 1 ) add_shortcode( 'font-fa',  'font_fa_shortcode' );

		if( $mommodule_passwords        == 1 ) add_filter( 'the_content', 'do_shortcode', 'rotating_universal_passwords_shortcode' );
		if( $mommodule_passwords        == 1 ) add_shortcode( 'rups', 'rotating_universal_passwords_shortcode' );

		if( $mommodule_shortcodes       == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_onthisday' );
		if( $mommodule_shortcodes       == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_archives' );
		if( $mommodule_shortcodes       == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_map' );
		if( $mommodule_shortcodes       == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_reddit' );
		if( $mommodule_shortcodes       == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_restrict' );
		if( $mommodule_shortcodes       == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_progress' );
		if( $mommodule_shortcodes       == 1 ) add_filter( 'the_content', 'do_shortcode', 'mom_verify' );
		if( $mommodule_shortcodes       == 1 ) add_shortcode( 'mom_archives', 'mom_archives' );
		if( $mommodule_shortcodes       == 1 ) add_shortcode( 'mom_onthisday', 'mom_onthisday' );
		if( $mommodule_shortcodes       == 1 ) add_shortcode( 'mom_map', 'mom_google_map_shortcode' );
		if( $mommodule_shortcodes       == 1 ) add_shortcode( 'mom_reddit', 'mom_reddit_shortcode' );
		if( $mommodule_shortcodes       == 1 ) add_shortcode( 'mom_restrict', 'mom_restrict_shortcode' );
		if( $mommodule_shortcodes       == 1 ) add_shortcode( 'mom_progress', 'mom_progress_shortcode' );
		if( $mommodule_shortcodes       == 1 ) add_shortcode( 'mom_verify', 'mom_verify_shortcode' );

	}

}

if ( get_option ( 'mompaf_post' ) ) {
	if ( get_option ( 'mompaf_post' ) != 'off' ) add_action ( 'wp', 'myoptionalmodules_postasfront' );
}