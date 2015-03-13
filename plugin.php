<?php 
/*
Plugin Name: My Optional Modules
Plugin URL: //wordpress.org/plugins/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 8-RC-1.5.6
Author: Matthew Trevino
Author URI: //wordpress.org/plugins/my-optional-modules/

LICENSE
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program;if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * MAIN PLUGIN FILE
 *
 * Initialize all functionality for this plugin
 */

$myoptionalmodules_plugin_version  = '8RC152';
$myoptionalmodules_upgrade_version = 3;

define ( 'MyOptionalModules', true );
require_once( ABSPATH . 'wp-includes/pluggable.php' );

if ( $myoptionalmodules_upgrade_version == get_option('myoptionalmodules_upgrade_version') ) {
	/* LAST UPDATED */ /* FILE TO INCLUDE */
	/* 8-RC-1.5.6   */ include( '_versions.php' );
	/* 8-RC-1.5.6   */ include( 'function.category-ids.php' );
	/* 8-RC-1.5.6   */ include( 'function.exclude-categories.php' );
	/* 8-RC-1.5.6   */ include( 'function.recent-posts.php' );
	/* 8-RC-1.5.6   */ include( 'function.featured-images.php' );
	/* 8-RC-1.5.6   */ include( 'function.read-more.php' );
	/* 8-RC-1.5.6   */ include( 'class.mom-mediaembed.php' ); 
	/* 8-RC-1.5.6   */ include( 'class.myoptionalmodules.php' );
	/* 8-RC-1.5.6   */ include( 'class.myoptionalmodules-enable.php' );
	/* 8-RC-1.5.6   */ include( 'class.myoptionalmodules-disable.php' );
	/* 8-RC-1.5.6   */ include( 'class.myoptionalmodules-commentform.php' );
	/* 8-RC-1.5.6   */ include( 'class.myoptionalmodules-extras.php' );
	/* 8-RC-1.5.6   */ include( 'class.myoptionalmodules-misc.php' );
	/* 8-RC-1.5.6   */ include( 'class.shortcode.myoptionalmodules_attachmentloop.php' );
	/* 8-RC-1.5.6   */ include( 'class.shortcode.myoptionalmodules_mediaembed.php' );
	/* 8-RC-1.5.6   */ include( 'class.shortcode.myoptionalmodules_hidden.php' );
	/* 8-RC-1.5.6   */ include( 'function.shortcode.myoptionalmodules_miniloop.php' );
	/* 8-RC-1.5.6   */ include( '_initialize.php' );
}

if( current_user_can( 'edit_dashboard' ) && is_admin() ){

	class myoptionalmodules_admin_css {

		function actions() {

			add_action ( 'admin_enqueue_scripts', array( $this, 'stylesheets' ) );

		}

		function stylesheets ( $hook ) {

			global $myoptionalmodules_plugin_version;
			if( 'settings_page_mommaincontrol' != $hook )
			return;
			$font_awesome_css = str_replace ( array ( 'https:', 'http:' ), '', esc_url ( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' ) );
			$mom_admin_css    = str_replace ( array ( 'https:', 'http:' ), '', esc_url ( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/adminstyle/css' . $myoptionalmodules_plugin_version . '.css' ) );
			wp_enqueue_style ( 'mom_admin_css', $mom_admin_css );
			wp_enqueue_style ( 'font_awesome',  $font_awesome_css );

		}
	}

	$myoptionalmodules_admin_css = new myoptionalmodules_admin_css();
	$myoptionalmodules_admin_css->actions();

	/* LAST UPDATED */ /* FILE TO INCLUDE */
	/* 8-RC-1.5.6   */ include( 'admin.font-awesome-post-edit.php' );
	/* 8-RC-1.5.6   */ include( 'admin.settings-page-content.php' );

}