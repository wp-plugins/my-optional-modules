<?php 
/**
 * CLASS myoptionalmodules_misc()
 *
 * File last update: 9.1.3
 *
 * Functionality for:
 * - Miniloops
 * - Google Analytics
 * - Frontpage post
 * - Previous/Next Link Class
 * - Read More
 * - Random Post
 * - Random Titles
 * - Random Descriptions
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_misc {

	function actions() {
		
		global $myoptionalmodules_randompost , $myoptionalmodules_google , $myoptionalmodules_frontpage , $myoptionalmodules_previouslinkclass , $myoptionalmodules_nextlinkclass , $myoptionalmodules_readmore , $myoptionalmodules_randomtitles , $myoptionalmodules_randomdescriptions;
		
		add_filter ( 'the_content' , array ( $this , 'miniloop' ) );
	
		if( $myoptionalmodules_google )
			add_action ( 'wp_head' , array ( $this , 'google_analytics' ) );

		if( $myoptionalmodules_frontpage && 'off' != $myoptionalmodules_frontpage )
			add_action ( 'wp' , array ( $this , 'front_post' ) );

		if( $myoptionalmodules_previouslinkclass ) {
			add_filter ( 'previous_posts_link_attributes', array ( $this , 'previous_link_class' ) );
			add_filter ( 'previous_post_link' , array ( $this , 'previous_link' ) );
		}

		if( $myoptionalmodules_nextlinkclass ) {
			add_filter ( 'next_posts_link_attributes', array ( $this , 'next_link_class' ) );
			add_filter ( 'next_post_link', array ( $this , 'next_link' ) );
		}

		if( $myoptionalmodules_readmore ) {
			add_filter ( 'the_content_more_link' , array ( $this , 'read_more' ) );
			add_filter ( 'excerpt_more' , array ( $this , 'read_more' ) );
		}

		if( $myoptionalmodules_randompost )
			add_action ( 'wp' , array ( $this , 'random' ) );

		if( $myoptionalmodules_randomtitles )
			add_filter ( 'pre_option_blogname' , array ( $this , 'random_title' ) , 10 , 2 );

		if( $myoptionalmodules_randomdescriptions )
			add_filter ( 'pre_option_blogdescription' , array ( $this , 'random_description' ) , 10 , 2 );

	}

	// Miniloops
	function miniloop( $content ) {

		global $wp, $post;

		$meta   = null;
		$style  = null;
		$amount = null;
		
		global $myoptionalmodules_miniloopmeta , $myoptionalmodules_miniloopstyle , $myoptionalmodules_miniloopamount;
		

		if( is_single() && $myoptionalmodules_miniloopmeta && $myoptionalmodules_miniloopstyle && $myoptionalmodules_miniloopamount) {
			$key    = get_post_meta ( $post->ID , $meta , true );
			if( $key && $meta )
				$output = do_shortcode ( '[mom_miniloop meta="' . $myoptionalmodules_miniloopmeta . '" key="' . $key . '" style="' . $myoptionalmodules_miniloopstyle . '" amount="' . $myoptionalmodules_miniloopamount . '" ]' );
			else
				$output = null;
			return $content . $output;
		} else {
			return $content;
		}

	}

	// Google Analytics
	function google_analytics() {
		
		global $myoptionalmodules_google;

		if( is_single() || is_page() )
			$url = get_permalink();
		else
			$url = esc_url ( home_url ('/' ) );

		echo "
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', '$myoptionalmodules_google', '$url');
			ga('send', 'pageview');
		</script>\n\n";

	}

	// Frontpage post
	function front_post() {
		
		global $myoptionalmodules_frontpage;

		if( is_home() && 'off' != $myoptionalmodules_frontpage ) {

			if( is_numeric ( $myoptionalmodules_frontpage ) )
				$myoptionalmodules_frontpage = $myoptionalmodules_frontpage;
			elseif( $myoptionalmodules_frontpage )
				$myoptionalmodules_frontpage = '';

			if( have_posts() ) : the_post();
				header( 'location:' . esc_url( get_permalink( $myoptionalmodules_frontpage ) ) ); 
				exit; 
			endif;
		}

	}

	// Previous/Next Link Class
	function previous_link_class() {
		
		global $myoptionalmodules_previouslinkclass;
		return 'class="' . $myoptionalmodules_previouslinkclass . '"';

	}

	function previous_link( $output ) {

		global $myoptionalmodules_previouslinkclass;
		$class = 'class="' . $myoptionalmodules_previouslinkclass . '"';
		return str_replace ( '<a href=' , '<a '.$class.' href=' , $output);

	}

	function next_link_class() {

		global $myoptionalmodules_nextlinkclass;
		return 'class="' . $myoptionalmodules_nextlinkclass . '"';

	}

	function next_link( $output ) {

		global $myoptionalmodules_nextlinkclass;
		$class = 'class="' . $myoptionalmodules_nextlinkclass . '"';
		return str_replace ( '<a href=' , '<a '.$class.' href=' , $output);	

	}

	// Read More
	function read_more( $more ) {

		global $myoptionalmodules_readmore;
		if( '%blank%' == $myoptionalmodules_readmore )
			return '';
		else
			return '<a href="' . get_permalink() . '">' . $myoptionalmodules_readmore . '</a>';

	}

	// Random
	function random() {

		global $myoptionalmodules_randompost;

		if( isset( $_GET[ $myoptionalmodules_randompost ] ) ) {
			$args = array (
				'numberposts' => 1,
				'post_type'   => 'post',
				'post_status' => 'publish',
				'orderby'     => 'rand'
			);

			$get_all = get_posts ( $args );

			foreach ( $get_all as $all_posts ) {
				$random_post = $all_posts->ID;
			}

			header ( 'location:' . esc_url ( get_permalink ( $random_post ) ) ); exit;
		}

	}

	// Random Titles
	function random_title( $title ) {

		global $wp, $myoptionalmodules_randomtitles;

		$titles = '';

		if( '' != $myoptionalmodules_randomtitles )
			$titles = $myoptionalmodules_randomtitles;

		$title = explode ( '::' , $titles );
		return $title[ array_rand ( $title ) ];

	}

	// Random Descriptions
	function random_description( $title ) {

		global $wp, $myoptionalmodules_randomdescriptions;

		$descriptions = '';

		if( '' != $myoptionalmodules_randomdescriptions )
			$descriptions = $myoptionalmodules_randomdescriptions;

		$descriptions = explode ( '::' , $descriptions );
		return $descriptions[ array_rand ( $descriptions ) ];

	}

}