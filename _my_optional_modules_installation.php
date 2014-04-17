<?php 

/**
 * My Optional Modules Installation
 *
 * (1) Install and update if upgrading
 * (2) Enqueue footer scripts if necessary
 * (3) Include stylesheets if called for
 *
 * @package my_optional_modules
 */	

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

register_activation_hook ( __FILE__, 'my_optional_modules_main_installation' );
add_action ( 'wp', 'my_optional_modules_scripts' );
add_action ( 'admin_enqueue_scripts', 'my_optional_modules_stylesheets' );
add_action ( 'admin_enqueue_scripts', 'my_optional_modules_font_awesome' );
add_action ( 'wp_print_styles', 'my_optional_modules_main_stylesheet' );

if ( !function_exists ( 'my_optional_modules_main_installation' ) ) {
	function my_optional_modules_main_installation(){

		global $wpdb;
		$regularboard_boards = $wpdb->prefix.'regularboard_boards';
		$regularboard_posts = $wpdb->prefix.'regularboard_posts';
		$regularboard_users = $wpdb->prefix.'regularboard_users';
		$wpdb->query ( "DROP TABLE '$regularboard_boards'" );
		$wpdb->query ( "DROP TABLE '$regularboard_posts'" );
		$wpdb->query ( "DROP TABLE '$regularboard_users'" );
		delete_option ( 'mommaincontrol_regularboard_activated' );
		delete_option ( 'mom_passwords_salt' );
		update_option ( 'mommaincontrol_focus', '' );
		delete_option ( 'momreviews_css' );
		delete_option ( 'mom_postasfront_mode_submit' );
		delete_option ( 'mommaincontrol_analytics' );
		delete_option ( 'mom_passwords_salt' );
		add_option    ( 'mommaincontrol_passwords_activated', 1 );					
		add_option    ( 'mommaincontrol_reviews_activated', 1 );
		add_option    ( 'mommaincontrol_shorts_activated', 1 );

	}
}

include ( plugin_dir_path(__FILE__) . '_my_optional_modules_scripts.php' );

if ( !function_exists ( 'my_optional_modules_stylesheets' ) ) {
	function my_optional_modules_stylesheets( $hook ){
		if ( 'settings_page_mommaincontrol' != $hook )
		return;
		wp_register_style ( 'mom_admin_css', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/adminstyle/css.css' );
		wp_register_style ( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style  ( 'font_awesome' );
		wp_enqueue_style  ( 'mom_admin_css' );
	}
}
if ( !function_exists ( 'my_optional_modules_font_awesome' ) ) {
	function my_optional_modules_font_awesome() {
		wp_register_style ( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style ( 'font_awesome' );
	}
}
if ( !function_exists ( 'my_optional_modules_main_stylesheet' ) ) {
	function my_optional_modules_main_stylesheet() {
		$myStyleFile = WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules05492702.css';
		wp_register_style ( 'my_optional_modules', $myStyleFile );
		wp_enqueue_style ( 'my_optional_modules' );
	}
}