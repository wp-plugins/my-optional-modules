<?php 
/**
 * CLASS myoptionalmodules_extras()
 *
 * File last update: 9.1.6
 *
 * Functionality for:
 * - Full-length feature images
 * - Javascripts to footer
 * - Exclude posts
 */ 

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_extras {

	function __construct() {

		global $myoptionalmodules_featureimagewidth , $myoptionalmodules_javascripttofooter , $myoptionalmodules_exclude;
		if( $myoptionalmodules_featureimagewidth ) {
			add_action ( 'wp_head' , array ( $this , 'thumbnails' ) );
		}

		if( $myoptionalmodules_javascripttofooter ) {
			add_action ( 'wp_enqueue_scripts', array ( $this , 'remove' ) );
			add_action ( 'wp_footer' , 'wp_enqueue_scripts' , 5 );
			add_action ( 'wp_footer' , 'wp_print_head_scripts' , 5 );
		}

		if( $myoptionalmodules_exclude ) {
			add_action( 'pre_get_posts', array ( $this , 'exclude' ) );	
		}

	}

	// Full-length feature images
	function thumbnails() {

		$output = "<style> .post-thumbnail { width: 100%; } .post-thumbnail img { width: 100%; height: auto; } </style> \n";
		echo $output;

	}

	function remove() {

		remove_action ( 'wp_head' , 'wp_print_head_scripts' , 9 );
		remove_action ( 'wp_head' , 'wp_enqueue_scripts' , 1 );

	}

	// Exclude posts
	function exclude( $query ) {

		include( 'function.exclude.php' );

	}

}

$myoptionalmodules_extras = new myoptionalmodules_extras();