<?php 
/*
Plugin Name: My Optional Modules
Plugin URL: //iamnotu.com/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 9.1
Author: Matthew Trevino
Author URI: //iamnotu.com

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

$myoptionalmodules_plugin_version  = '9';

define ( 'MyOptionalModules', true );
require_once( ABSPATH . 'wp-includes/pluggable.php' );

include( '_versions.php' );
include( 'function.category-ids.php' );
include( 'function.exclude-categories.php' );
include( 'function.recent-posts.php' );
include( 'function.featured-images.php' );
include( 'function.read-more.php' );
include( 'class.mom-mediaembed.php' ); 
include( 'class.myoptionalmodules.php' );
include( 'class.myoptionalmodules-enable.php' );
include( 'class.myoptionalmodules-disable.php' );
include( 'class.myoptionalmodules-commentform.php' );
include( 'class.myoptionalmodules-extras.php' );
include( 'class.myoptionalmodules-misc.php' );
include( 'class.shortcode.myoptionalmodules-attachmentloop.php' );
include( 'class.shortcode.myoptionalmodules-mediaembed.php' );
include( 'class.shortcode.myoptionalmodules-hidden.php' );
include( 'function.shortcode.myoptionalmodules-miniloop.php' );
include( '_initialize.php' );

if( current_user_can( 'edit_dashboard' ) && is_admin() ){
	class myoptionalmodules_admin_css {

		function actions() {

			add_action ( 'admin_enqueue_scripts', array( $this, 'stylesheets' ) );

		}

		function stylesheets ( $hook ) {

			global $myoptionalmodules_plugin_version;

			if( 'settings_page_mommaincontrol' != $hook ) return;

			$font_awesome_css = str_replace ( array ( 'https:', 'http:' ), '', esc_url ( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' ) );
			$mom_admin_css    = str_replace ( array ( 'https:', 'http:' ), '', esc_url ( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/adminstyle/css' . $myoptionalmodules_plugin_version . '.css' ) );
			wp_enqueue_style ( 'mom_admin_css' , $mom_admin_css );
			wp_enqueue_style ( 'font_awesome' ,  $font_awesome_css );

		}

	}

	$myoptionalmodules_admin_css = new myoptionalmodules_admin_css();
	$myoptionalmodules_admin_css->actions();

	include( 'admin.font-awesome-post-edit.php' );
	include( 'admin.settings-page-content.php' );
}