<?php 
/*
Plugin Name: My Optional Modules
Plugin URI: 
Description: Optional modules and additions for Wordpress.
Version: 10.2
Author: boyevul
Author URI: 

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

This plugin was released in 2013. Version 1 had 2 modules, initially. Rotating
Universal Passwords (RUPs) and obwcountplus (Count++) (an attempt to update 
http://wordpress.org/plugins/post-word-count/). 

Looking back, it's kind of funny to see what has been added and taken away from 
the plugin itself. And as I write this, on the 25th of September, 2015, I realize 
that for 2 years, I've worked on this for literally nobody, for the sole purpose 
of who knows, for a paycheck totalling 0$, to ensure that you, my unknown benefactors, 
gets some extra use out of your WordPress installation for an amount of thanks 
that I can count on a single hand.

Of course, if I were doing this for money or applause, I would have certainly picked 
something other than freely distributed software to spend my time working with.

I guess what I'm trying to say is: enjoy the free shit. You know, if you're even 
reading this. Whatever, who cares, none of it matters.

*/

/**
 * Initial Plugin Setup
 */
define ( 'MyOptionalModules', true );

/**
 * We need pluggable for certain plugin actions
 */
require_once ( ABSPATH . 'wp-includes/pluggable.php' );

/**
 * function.mom_strip_protocol($url)
 * strips both https: and http: from an included file's url so that 
 * it works correctly for BOTH https: and http: without serving up 
 * warnings. ALL INCLUDED FILES should be served as: //file.url.
 */
function mom_strip_protocol ( $url ) {
	$url = str_replace ( array ( 'https:' , 'http:' ) , '' , esc_url ( $url ) );
	return $url;
}

/**
 * Include plugin files
 */
if ( get_option ( 'myoptionalmodules_recentpostswidget' ) ) { 
	include ( 'function.recent-posts.php' ); 
}
if ( get_option ( 'myoptionalmodules_pluginshortcodes' ) ) {
	if ( 
		get_option ( 'myoptionalmodules_miniloopamount' ) && 
		get_option ( 'myoptionalmodules_miniloopstyle' ) && 
		get_option ( 'myoptionalmodules_miniloopmeta' ) 
	) {
		include ( 'function.shortcode.myoptionalmodules-miniloop.php' );
	}
} else {
	include ( 'class.mom-mediaembed.php' ); 
	include ( 'class.myoptionalmodules-shortcodes.php' );
	include ( 'function.shortcode.myoptionalmodules-miniloop.php' );
}
include ( 'class.myoptionalmodules.php' );
include ( 'class.myoptionalmodules-modules.php' );

/**
 * Admin functionality
 */
if( current_user_can( 'edit_dashboard' ) && is_admin() ) {
	class myoptionalmodules_admin_css {
		function __construct() {
			add_action ( 'admin_enqueue_scripts', array( $this, 'stylesheets' ) );
		}
		function stylesheets ( $hook ) {
			$myoptionalmodules_plugin_version = '10';
			if ( 'settings_page_mommaincontrol' != $hook ) return;
			$font_awesome_css = mom_strip_protocol ( plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
			$mom_admin_css    = mom_strip_protocol ( plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/adminstyle/css' . $myoptionalmodules_plugin_version . '.css' );
			wp_enqueue_style ( 'mom_admin_css' , $mom_admin_css );
			wp_enqueue_style ( 'font_awesome' ,  $font_awesome_css );
		}
	}
	$myoptionalmodules_admin_css = new myoptionalmodules_admin_css();
	include ( 'admin.font-awesome-post-edit.php' );
	include ( 'admin.settings-page-content.php' );
}