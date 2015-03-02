<?php 
/**
 * Plugin Name: My Optional Modules
 * Plugin URI: //wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 7
 * Author: Matthew Trevino
 * Author URI: //wordpress.org/plugins/my-optional-modules/
 *	
 * LICENSE
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program;if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

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
include( '_initialize.php' );

include( 'shortcode.mediaembed.php' );
include( 'shortcode.attachment-loop.php' );
include( 'shortcode.mini-loop.php' );
include( '_initialize.shortcode.php' );

if( current_user_can( 'edit_dashboard' ) ){
	include( 'admin.font-awesome-post-edit.php' );
	include( 'admin.save-and-delete.php' );
	include( 'admin.settings-page-content.php' );
}