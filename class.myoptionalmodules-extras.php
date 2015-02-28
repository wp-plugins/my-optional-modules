<?php 
/**
 * class.myoptionalmodules-extras
 * Full-width thumbnails, javascript to footer, lazy loading, exclusion functionality
 *  - Check if ANY of the options for these things are switched before further deciding which functionality
 *    to enable. If none of these options are switched on via settings, then skip this class altogether.
 */ 

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}
class myoptionalmodules_extras {
	function actions() {
		if( 1 == get_option( 'mommaincontrol_thumbnail' ) ) {
			add_action( 'wp_head', array( $this, 'thumbnails' ) );
		}
		if( 1 == get_option( 'mommaincontrol_footerscripts' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'remove' ) );
			add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
			add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
		}
		if( 1 == get_option( 'mommaincontrol_momse' ) ) {
			add_action( 'pre_get_posts', array( $this, 'exclude' ) );	
		}
	}
	function remove() {
		remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
		remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	}
	function thumbnails() {
		$output = "<style> .post-thumbnail { width: 100%; } .post-thumbnail img { width: 100%; height: auto; } </style> \n";
		echo $output;
	}
	function exclude( $query ) {
		include( 'function.exclude.php' );
	}
}