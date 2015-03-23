<?php 
/*
 * CLASS SHORTCODE myoptionalmodules_hidden()
 *
 * File last update: 9.1.5
 *
 * Hide content from is_home/is_single OR users who are not logged in
 * - [mom_hidden single='0/1' logged='0/1'] content [/mom_hidden]
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_hidden{

	function construct() {

		add_shortcode( 'mom_hidden' , array ( $this , 'shortcode' ) );

	}

	function shortcode( $atts, $content ) {
		global $wp , $post;
		
		extract (
			shortcode_atts ( 
				array (
					'logged'  => 0, // (1) on (0) off // whether or not viewer needs to be logged in to view content
					'single'  => 0  // (1) on (0) off // whether or not content will be hidden on single post view
				)
				, $atts 
			)
		);
		
		$logged = intval ( $logged );
		$single = intval ( $single );
		
		if( is_single() || is_page() )
			$view = 1;
		else
			$view = 0;
		
		if( $logged && !is_user_logged_in() )
			$content = null;
		if( !$single && !$view )
			$content = null;
		if( $single && $view )
			$content = null;

		return do_shortcode ( $content );

	}

}

$myoptionalmodules_shortcode_hidden = new myoptionalmodules_hidden();
$myoptionalmodules_shortcode_hidden->construct();