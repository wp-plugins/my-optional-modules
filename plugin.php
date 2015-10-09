<?php 
/*
Plugin Name: My Optional Modules
Description: Optional modules and additions for Wordpress.
Version: 10.4
Author: boyevul
*/

define ( 'MyOptionalModules' , true );
require_once ( ABSPATH . 'wp-includes/pluggable.php' );

class myoptionalmodules_plugin_includes {
	function __construct() {
		include ( 'function.functions.php' );
		include ( 'function.recent-posts.php' ); 
		include ( 'function.shortcode.myoptionalmodules-miniloop.php' );
		include ( 'class.myoptionalmodules.php' );
		include ( 'class.myoptionalmodules-modules.php' );

		if ( !get_option ( 'myoptionalmodules_pluginshortcodes' ) ) {

			include ( 'class.mom-mediaembed.php' ); 
			include ( 'class.myoptionalmodules-shortcodes.php' );
			include ( 'function.shortcode.myoptionalmodules-miniloop.php' );

		}
	}
}
$myoptionalmodules_plugin_includes = new myoptionalmodules_plugin_includes();

if ( current_user_can ( 'edit_dashboard' ) && is_admin() ) {

	class myoptionalmodules_admin {
		function __construct() {
			add_action ( 'admin_enqueue_scripts', array( $this, 'stylesheets' ) );
		}
		function stylesheets ( $hook ) {
			if ( 'settings_page_mommaincontrol' != $hook ) return;
			$font_awesome_css = mom_strip_protocol ( plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
			$mom_admin_css    = mom_strip_protocol ( plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/adminstyle/css.css' );
			wp_enqueue_style ( 'mom_admin_css' , $mom_admin_css );
			wp_enqueue_style ( 'font_awesome' ,  $font_awesome_css );
		}
	}
	$myoptionalmodules_admin = new myoptionalmodules_admin();

	include ( 'admin.font-awesome-post-edit.php' );
	include ( 'admin.settings-page-content.php' );

}