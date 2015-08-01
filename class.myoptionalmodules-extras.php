<?php 
/**
 * CLASS myoptionalmodules_extras()
 *
 * File last update: 10.0.9.3
 *
 * Functionality for:
 * - Favicon
 * - Full-length feature images
 * - Javascripts to footer
 * - Exclude posts
 */ 

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_extras {

	function __construct() {

		global 
			$myoptionalmodules_featureimagewidth , 
			$myoptionalmodules_javascripttofooter , 
			$myoptionalmodules_exclude ,
			$myoptionalmodules_favicon;

		if ( $myoptionalmodules_favicon ) {
			add_action ( 'wp_head' , array ( $this , 'favicon' ) );
		}

		if( $myoptionalmodules_featureimagewidth ) {
			add_action ( 'wp_head' , array ( $this , 'thumbnails' ) );
		}

		if( $myoptionalmodules_javascripttofooter ) {
			add_action ( 'wp_enqueue_scripts' , array ( $this , 'remove' ) );
			add_action ( 'wp_footer' , 'wp_enqueue_scripts' , 5 );
			add_action ( 'wp_footer' , 'wp_print_head_scripts' , 5 );
		}

		if( $myoptionalmodules_exclude ) {
			add_action( 'pre_get_posts' , array ( $this , 'exclude' ) );	
		}

	}

	/**
	 * Theme -> Favicon
	 * Enable favicon for your theme by placing 
	 * the URL to the .ico file in theme->Favicon URL
	 */	
	function favicon() {
		global $myoptionalmodules_favicon;
		if ( $myoptionalmodules_favicon ) {
			$url    = esc_url ( $myoptionalmodules_favicon );
			$output = "<link rel='shortcut icon' href='{$url}' />\n";
			echo $output;
		}
	}
	
	/**
	 * Extras -> Full-width feature images
	 * Forces .post-thumbnail and .post-thumbnail img
	 * to be 100% the width of their parent containers
	 */
	function thumbnails() {
		$output = "
			<style>
				.post-thumbnail{width:100%;}
				.post-thumbnail img{height:auto;width:100%;} 
			</style>\n
		";
		echo $output;
	}

	/**
	 * Extras -> Javascript-to-footer
	 * Remove enqueued scripts from wp_head
	 */
	function remove() {
		remove_action ( 'wp_head' , 'wp_print_head_scripts' , 9 );
		remove_action ( 'wp_head' , 'wp_enqueue_scripts' , 1 );
	}

	/**
	 * Extras -> Enable Exclude Posts
	 * Exclude posts from the loop based on several
	 * parameters (set in options).
	 */	
	function exclude( $query ) {
		global $myoptionalmodules_blank_counter;
		++$myoptionalmodules_blank_counter;
		if ( 1 == $myoptionalmodules_blank_counter ) {
			include( 'function.exclude.php' );
		}
	}
}

$myoptionalmodules_extras = new myoptionalmodules_extras();