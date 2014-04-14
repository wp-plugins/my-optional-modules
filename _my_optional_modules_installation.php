<?php 

/**
 * My Optional Modules Installation
 *
 * (1) Install and update if upgrading
 * (2) Enqueue footer scripts if necessary
 * (3) Include stylesheets if called for
 *
 * @package regular_board
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
		if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){
			$availableCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890./';
			$generateSalt = '';
			for($i = 0; $i < 22; $i++){
				$generateSalt .= $availableCharacters[rand(0, strlen($availableCharacters) - 1)];
			}
			add_option('mom_passwords_salt',$generateSalt);
		}
		else{
			update_option('mommaincontrol_momrups',0);
		}
		
		update_option ( 'mommaincontrol_focus', '' );
		delete_option ( 'momreviews_css' );
		delete_option ( 'mom_postasfront_mode_submit' );
		delete_option ( 'mommaincontrol_analytics' );
		delete_option ( 'mom_passwords_salt' );
		add_option    ( 'mommaincontrol_passwords_activated', 1 );					
		add_option    ( 'mommaincontrol_reviews_activated', 1 );
		add_option    ( 'mommaincontrol_shorts_activated', 1 );
		
		$mommodule_rb = esc_attr ( get_option ( 'mommaincontrol_regularboard' ) );
		if ( $mommodule_rb == 1 ) {
			global $wpdb, $wp;
			$regularboard_boards = $wpdb->prefix . 'regularboard_boards';
			$regularboard_posts = $wpdb->prefix . 'regularboard_posts';
			$regularboard_users = $wpdb->prefix . 'regularboard_users';
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER COMMENT" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER URL" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD STICKY TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER LAST" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD LOCKED TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER STICKY" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD PASSWORD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER LOCKED" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD UP BIGINT( 22 ) NOT NULL AFTER REPLYTO" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD REPLYTO BIGINT( 22 ) NOT NULL AFTER PASSWORD" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD USERID BIGINT( 22 ) NOT NULL AFTER UP" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts ADD PUBLIC BIGINT( 22 ) NOT NULL AFTER USERID" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts CHANGE `ID` `ID` BIGINT( 22 ) NOT NULL AUTO_INCREMENT" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts CHANGE `COMMENT` `COMMENT` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts CHANGE `PARENT` `PARENT` BIGINT( 22 ) NOT NULL" );
			$wpdb->query ( "ALTER TABLE $regularboard_users CHANGE `ID` `ID` BIGINT( 22 ) NOT NULL AUTO_INCREMENT" );
			$wpdb->query ( "ALTER TABLE $regularboard_users CHANGE `PARENT` `PARENT` BIGINT( 22 ) NOT NULL" );
			$wpdb->query ( "ALTER TABLE $regularboard_posts CHANGE `IP` `IP` BIGINT( 22 ) NOT NULL" );
			$wpdb->query ( "ALTER TABLE $regularboard_users CHANGE `IP` `IP` BIGINT( 22 ) NOT NULL" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD NAME TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER IP" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD EMAIL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER NAME" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD KARMA BIGINT( 22 ) NOT NULL AFTER LENGTH" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD THREAD BIGINT ( 22 ) NOT NULL AFTER IP" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER ID" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD BOARD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER PARENT" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD LENGTH TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER MESSAGE" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD PASSWORD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER KARMA" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD HEAVEN TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER PASSWORD" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD VIDEO TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER HEAVEN" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD BOARDS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER VIDEO" );
			$wpdb->query ( "ALTER TABLE $regularboard_users ADD FOLLOWING TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER BOARDS" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards ADD URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER RULES" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards ADD SFW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER URL" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards ADD MODS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER SFW" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards ADD JANITORS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER MODS" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards ADD POSTCOUNT BIGINT( 22 ) NOT NULL AFTER JANITORS" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards ADD LOCKED BIGINT( 22 ) NOT NULL AFTER POSTCOUNT" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards ADD LOGGED BIGINT( 22 ) NOT NULL AFTER LOCKED" );
			$wpdb->query ( "ALTER TABLE $regularboard_boards DROP URL" );
			$allusers = $wpdb->get_results ( "SELECT * FROM $regularboard_users BANNED = '8'" );
			foreach ( $allusers as $users ) {
				$ip = $users->IP;
				$id = $users->ID;
				foreach ( $allposts as $posts ) {
					$wpdb->query ( "UPDATE $regularboard_posts SET USERID = $id WHERE IP = '$ip' AND EMAIL != 'heaven'" );
				}
			}
			$wpdb->query ( "UPDATE $regularboard_posts SET PUBLIC = 1 WHERE PUBLIC = 0" );
		}
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