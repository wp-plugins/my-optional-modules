<?php 

/**
 *
 * Installation
 *
 * Handles everything that needs to occur upon activation of the plugin
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

register_activation_hook( __FILE__, 'my_optional_modules_main_installation' );
add_action( 'wp', 'my_optional_modules_scripts' );
add_action( 'admin_enqueue_scripts', 'my_optional_modules_stylesheets' );
add_action( 'admin_enqueue_scripts', 'my_optional_modules_font_awesome' );
add_action( 'wp_print_styles', 'my_optional_modules_main_stylesheet' );

if( !function_exists( 'my_optional_modules_main_installation' ) ) {

	function my_optional_modules_main_installation(){

		global $wpdb;
		
		/**
		 *
		 * Regular Board is no longer a part of My Optional Modules
		 * and will now be removed from previous installations that are
		 * upgrading that may have had it installed.
		 *
		 */
		$regularboard_boards = $wpdb->prefix . 'regularboard_boards';
		$regularboard_posts = $wpdb->prefix . 'regularboard_posts';
		$regularboard_users = $wpdb->prefix . 'regularboard_users';
		$wpdb->query( "DROP TABLE '$regularboard_boards'" );
		$wpdb->query( "DROP TABLE '$regularboard_posts'" );
		$wpdb->query( "DROP TABLE '$regularboard_users'" );
		delete_option( 'mommaincontrol_regularboard_activated' );
		
		/**
		 *
		 * Remove options that the plugin no longer uses or references 
		 * from previous versions
		 * 
		 */
		delete_option( 'mom_passwords_salt' );
		update_option( 'mommaincontrol_focus', '' );
		delete_option( 'momreviews_css' );
		delete_option( 'mom_postasfront_mode_submit' );
		delete_option( 'mommaincontrol_analytics' );
		delete_option( 'mom_passwords_salt' );
		
		add_option( 'mommaincontrol_passwords_activated', 1 );					
		add_option( 'mommaincontrol_reviews_activated', 1 );
		add_option( 'mommaincontrol_shorts_activated', 1 );

	}
	
}