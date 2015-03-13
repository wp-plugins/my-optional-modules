<?php 
/**
 * CLASS myoptionalmodules_misc()
 *
 * File last update: 9.1
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

		if( get_option ( 'myoptionalmodules_miniloopmeta' ) && get_option ( 'myoptionalmodules_miniloopstyle' ) && get_option ( 'myoptionalmodules_miniloopamount' ) ) {
			add_filter ( 'the_content' , array ( $this , 'miniloop' ) );
		}	
	
		if( get_option ( 'myoptionalmodules_google' ) )
			add_action ( 'wp_head' , array ( $this , 'google_analytics' ) );


		if( get_option ( 'myoptionalmodules_frontpage' ) && 'off' != get_option ( 'myoptionalmodules_frontpage' ) )
			add_action ( 'wp' , array ( $this , 'front_post' ) );


		if( '' != get_option ( 'myoptionalmodules_previouslinkclass' ) ) {
			add_filter ( 'previous_posts_link_attributes', array ( $this , 'previous_link_class' ) );
			add_filter ( 'previous_post_link' , array ( $this , 'previous_link' ) );
		}

		if( '' != get_option ( 'myoptionalmodules_nextlinkclass' ) ) {
			add_filter ( 'next_posts_link_attributes', array ( $this , 'next_link_class' ) );
			add_filter ( 'next_post_link', array ( $this , 'next_link' ) );
		}

		if( '' != get_option ( 'myoptionalmodules_readmore' ) ) {
			add_filter ( 'the_content_more_link' , array ( $this , 'read_more' ) );
			add_filter ( 'excerpt_more' , array ( $this , 'read_more' ) );
		}

		if( '' != get_option ( 'myoptionalmodules_randompost' ) )
			add_action ( 'wp' , array ( $this , 'random' ) );

		if( '' != get_option ( 'myoptionalmodules_randomtitles' ) )
			add_filter ( 'pre_option_blogname' , array ( $this , 'random_title' ) , 10 , 2 );

		if( '' != get_option ( 'myoptionalmodules_randomdescriptions' ) )
			add_filter ( 'pre_option_blogdescription' , array ( $this , 'random_description' ) , 10 , 2 );

	}

	// Miniloops
	function miniloop( $content ) {

		global $wp, $post;

		if( is_single() ) {
			$meta   = sanitize_text_field ( get_option ( 'myoptionalmodules_miniloopmeta' ) );
			$key    = get_post_meta ( $post->ID , $meta , true );
			$style  = sanitize_text_field ( strtolower ( get_option ( 'myoptionalmodules_miniloopstyle' ) ) );
			$amount = intval ( get_option ( 'myoptionalmodules_miniloopamount' ) );
			if( $key && $meta )
				$output = do_shortcode ( '[mom_miniloop meta="' . $meta . '" key="' . $key . '" style="' . $style . '" amount="' . $amount . '" ]' );
			else
				$output = null;
			return $content . $output;
		} else {
			return $content;
		}

	}

	// Google Analytics
	function google_analytics() {

		$tracking_id = sanitize_text_field( get_option( 'myoptionalmodules_google' ) );

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
			ga('create', '$tracking_id', '$url');
			ga('send', 'pageview');
		</script>\n\n";

	}

	// Frontpage post
	function front_post() {

		if( is_home() && 'off' != get_option ( 'myoptionalmodules_frontpage' ) ) {

			if( is_numeric ( get_option ( 'myoptionalmodules_frontpage' ) ) )
				$mompaf_front = get_option( 'myoptionalmodules_frontpage' );
			elseif( get_option ( 'myoptionalmodules_frontpage' ) == 'on' )
				$mompaf_front = '';

			if( have_posts() ) : the_post();
				header( 'location:' . esc_url( get_permalink( $mompaf_front ) ) ); 
				exit; 
			endif;

		}

	}

	// Previous/Next Link Class
	function previous_link_class() {

		return 'class="' . get_option ( 'myoptionalmodules_previouslinkclass' ) . '"';

	}

	function previous_link( $output ) {

		$class = 'class="' . get_option( 'myoptionalmodules_previouslinkclass' ) . '"';
		return str_replace ( '<a href=' , '<a '.$class.' href=' , $output);

	}

	function next_link_class() {

		return 'class="' . get_option ( 'myoptionalmodules_nextlinkclass' ) . '"';

	}

	function next_link( $output ) {

		$class = 'class="' . get_option ( 'myoptionalmodules_nextlinkclass' ) . '"';
		return str_replace ( '<a href=' , '<a '.$class.' href=' , $output);	
	}

	// Read More
	function read_more( $more ) {

		if( '%blank%' == get_option ( 'myoptionalmodules_readmore' ) )
			return '';
		else
			return '<a href="' . get_permalink() . '">' . sanitize_text_field ( get_option ( 'myoptionalmodules_readmore' ) ) . '</a>';

	}

	// Random
	function random() {

		$random = sanitize_text_field ( esc_html ( get_option ( 'myoptionalmodules_randompost' ) ) );

		if( isset( $_GET[ $random ] ) ) {
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

		global $wp;

		$titles = '';

		if( '' != get_option( 'myoptionalmodules_randomtitles' ) )
			$titles = sanitize_text_field( get_option( 'myoptionalmodules_randomtitles' ) );

		$title = explode ( '::' , $titles );
		return $title[ array_rand ( $title ) ];

	}

	// Random Descriptions
	function random_description( $title ) {

		global $wp;

		$descriptions = '';

		if( '' != get_option( 'myoptionalmodules_randomdescriptions' ) )
			$descriptions = sanitize_text_field ( get_option ( 'myoptionalmodules_randomdescriptions' ) );

		$descriptions = explode ( '::' , $descriptions );
		return $descriptions[ array_rand ( $descriptions ) ];

	}

}