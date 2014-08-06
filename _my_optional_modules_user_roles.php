<?php 

/**
 *
 * Roles
 * Set the role of the user by determining if they are logged in, and what actions they 
 * can perform (if they are logged in).
 * 
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

/**
 *
 * Currently, the plugin treats users who are not logged in and subscribers as the 
 * level (which may or may not be changed sometime in the future)
 *
 */
if( is_user_logged_in() ) {

	if( current_user_can('read') )                   $user_level = 0;	// Subscriber
	if( current_user_can('delete_posts') )           $user_level = 1;	// 
	if( current_user_can('delete_published_posts') ) $user_level = 2;	// 
	if( current_user_can('read_private_pages') )     $user_level = 4;	// 
	if( current_user_can('edit_dashboard') )         $user_level = 7;	// Admin
	
} else {

	$user_level = 0;													// Not logged in
	
}