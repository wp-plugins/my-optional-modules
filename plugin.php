<?php 
/**
 * Plugin Name: My Optional Modules
 * Plugin URI: //wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 6.0.8
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
/**
 *
 * This is free software. You don't pay anything for it.
 * This is a hobby. This is not my job. I don't get paid for it.
 *
 * Please be kind to me. I spend a lot of my free time doing this.
 * There are bound to be bugs in it sometimes. 
 * And I'll have them fixed as soon as I spot them.
 * I do my best to ensure that there aren't, but I'm only human;
 * things sometimes slip by.  
 *
 */

 
	define ( 'MyOptionalModules', true );

	require_once( ABSPATH . 'wp-includes/pluggable.php' );

	/* 1.00 */ include( 'function.category-ids.php' );
	/* 1.00 */ include( 'function.exclude-categories.php' );
	/* 1.00 */ include( 'function.recent-posts.php' );
	/* 0.00 */ include( 'function.featured-images.php' );
	/* 1.00 */ include( 'function.read-more.php' );

	/* 0.00 */ include( 'class.mom-mediaembed.php' ); 
	/* 0.00 */ include( 'class.myoptionalmodules.php' );
	/* 1.00 */ include( 'class.myoptionalmodules-enable.php' );
	/* 0.00 */ include( 'class.myoptionalmodules-disable.php' );
	/* 0.00 */ include( 'class.myoptionalmodules-commentform.php' );
	/* 0.00 */ include( 'class.myoptionalmodules-extras.php' );
	/* 0.00 */ include( 'class.myoptionalmodules-misc.php' );
	/* 0.00 */ include( '_initialize.php' );

	/* 0.00 */ include( 'shortcode.mediaembed.php' );
	/* 0.00 */ include( 'shortcode.attachment-loop.php' );
	/* 0.00 */ include( 'shortcode.mini-loop.php' );
	/* 0.00 */ include( '_initialize.shortcode.php' );

	if( current_user_can( 'edit_dashboard' ) ){
		/* 0.00 */ include( 'admin.font-awesome-post-edit.php' );
		/* 0.00 */ include( 'admin.save-and-delete.php' );
		/* 0.00 */ include( 'admin.settings-page-content.php' );
	}