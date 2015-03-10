<?php 
/**
 * class.myoptionalmodules-disable
 * Disable: comments, version number, pingbacks, author archives, date archives
 *  - Check if ANY of the options for these things are switched before further deciding which functionality
 *    to enable. If none of these options are switched on via settings, then skip this class altogether.
 */  

if(!defined('MyOptionalModules')){
	die();
}

class myoptionalmodules_disable {

	function actions() {
		if( 1 == get_option( 'myoptionalmodules_disablepingbacks' ) ) {
			add_filter( 'xmlrpc_methods', array( $this, 'pingbacks' ) );
		}
		if( 1 == get_option( 'myoptionalmodules_authorarchives' ) ) {
			add_action( 'template_redirect', array( $this, 'author_archives' ) );
		}
		if( 1 == get_option( 'myoptionalmodules_datearchives' ) ) {
			add_action( 'wp', array( $this, 'date_archives' ) );
			add_action( 'template_redirect', array( $this, 'date_archives' ) );
		}
		if( 1 == get_option( 'myoptionalmodules_removecode' ) ) {
			if ( !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
				remove_action('wp_head', 'wp_generator');
				add_filter( 'style_loader_src', array( $this, 'versions' ), 0 );
				add_filter( 'script_loader_src', array( $this, 'versions' ), 0 );
				add_action('init', array( $this, 'head_cleanup' ) );
				add_filter( 'style_loader_tag', array( $this, 'css_ids' ) );
				add_action( 'init', array( $this, 'replace_jquery' ) );
				add_filter( 'wp_default_scripts', array( $this, 'rem_j_migrate' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'add_j_migrate' ) );
			}
		}

	}
	
	
	
	/**
	 * Hide WordPress
	 */

	function replace_jquery() {
		global $myoptionalmodules_jquery_version;
		if (!is_admin()) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', $myoptionalmodules_jquery_version, false );
			wp_enqueue_script( 'jquery' );
		}
	}
	function rem_j_migrate( &$scripts)
	{
		if(!is_admin())
		{
			$scripts->remove( 'jquery');
			$scripts->add( 'jquery', false, array( 'jquery-core' ) );
		}
	}
	function add_j_migrate() {
		global $myoptionalmodules_jquerymigrate_version;
		wp_deregister_script( 'jquery-migrate');
		wp_register_script(
			'jquery-migrate',
			$myoptionalmodules_jquerymigrate_version,
			array( 'jquery' ),
			true
		);
		wp_enqueue_script( 'jquery-migrate' );
	}
	//benword.com/how-to-hide-that-youre-using-wordpress/
	function head_cleanup() {
		  remove_action('wp_head', 'feed_links', 2);
		  remove_action('wp_head', 'feed_links_extra', 3);
		  remove_action('wp_head', 'rsd_link');
		  remove_action('wp_head', 'wlwmanifest_link');
		  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		  remove_action('wp_head', 'wp_generator');
		  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
		  global $wp_widget_factory;
		  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
		  add_filter('use_default_gallery_style', '__return_null');
	}
	//blog.codecentric.de/en/2011/10/wordpress-and-mod_pagespeed-why-combine_css-does-not-work/
	function css_ids( $link ) {
		return preg_replace( "/id='.*-css'/", '', $link);
	}
	/**/
	
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