<?php 
/**
 * class.myoptionalmodules-disable
 * Disable: comments, version number, pingbacks, author archives, date archives
 *  - Check if ANY of the options for these things are switched before further deciding which functionality
 *    to enable. If none of these options are switched on via settings, then skip this class altogether.
 */  

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); } 

class myoptionalmodules_disable {

	function actions() {
		if( 1 == get_option( 'mommaincontrol_disablepingbacks' ) ) {
			add_filter( 'xmlrpc_methods', array( $this, 'pingbacks' ) );
		}
		if( 1 == get_option( 'mommaincontrol_versionnumbers' ) ) {
			remove_action('wp_head', 'wp_generator');
			add_filter( 'style_loader_src', array( $this, 'versions' ), 0 );
			add_filter( 'script_loader_src', array( $this, 'versions' ), 0 );
		}
		if( 1 == get_option( 'mommaincontrol_authorarchives' ) ) {
			add_action( 'template_redirect', array( $this, 'author_archives' ) );
		}
		if( 1 == get_option( 'mommaincontrol_datearchives' ) ) {
			add_action( 'wp', array( $this, 'date_archives' ) );
			add_action( 'template_redirect', array( $this, 'date_archives' ) );
		}

	}
	function versions( $src ) {
		if( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) { 
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}
	function author_archives(){
		global $wp_query;
		if( is_author() ) {
			if( sizeof( get_users( 'who=authors' ) ) ===1 )
			wp_redirect( get_bloginfo( 'url' ) );
		}
	}
	function date_archives(){
		global $wp_query;
		if( is_date() || is_year() || is_month() || is_day() || is_time() || is_new_day() ) {
			$homeURL = esc_url( home_url( '/' ) );
			if( have_posts() ):the_post();
			header( 'location:' . $homeURL );
			exit;
			endif;
		}
	}
	function pingbacks( $methods ) {
		unset( $methods['pingback.ping'] );
		return $methods;
	}
	
}