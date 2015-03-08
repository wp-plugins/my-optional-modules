<?php 
/**
 * class.myoptionalmodules-misc
 * Front page as post, previous/next link classes, read more... override, random site titles/descriptions
 *  - Check if ANY of the options for these things are switched before further deciding which functionality
 *    to enable. If none of these options are switched on via settings, then skip this class altogether.
 */

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

class myoptionalmodules_misc {

	function actions() {
		if( get_option( 'myoptionalmodules_google' ) ) {
			add_action( 'wp_footer', array( $this, 'google_analytics' ) );
		}
		if( get_option( 'myoptionalmodules_frontpage' ) && 'off' != get_option( 'myoptionalmodules_frontpage' ) ) {
			add_action ( 'wp', array( $this, 'front_post' ) );
		}
		if( '' != get_option( 'myoptionalmodules_previouslinkclass' ) ) {
			add_filter( 'previous_posts_link_attributes', array( $this, 'previous_link_class' ) );
			add_filter( 'previous_post_link', array( $this, 'previous_link' ) );
		}
		if( '' != get_option( 'myoptionalmodules_nextlinkclass' ) ) {
			add_filter( 'next_posts_link_attributes', array( $this, 'next_link_class' ) );
			add_filter( 'next_post_link', array( $this, 'next_link' ) );
		}
		if( '' != get_option( 'myoptionalmodules_readmore' ) ) {
			add_filter( 'the_content_more_link', array( $this, 'read_more' ) );
			add_filter( 'excerpt_more', array( $this, 'read_more' ) );
		}
		if( '' != get_option( 'myoptionalmodules_randompost' ) ) {
			add_action( 'wp', array( $this, 'random' ) );
		}
		if( '' != get_option( 'myoptionalmodules_randomtitles' ) ) {
			add_filter( 'pre_option_blogname', array( $this, 'random_title' ), 10, 2 );
		}
		if( '' != get_option( 'myoptionalmodules_randomdescriptions' ) ) {
			add_filter( 'pre_option_blogdescription', array( $this, 'random_description' ), 10, 2 );	
		}
	}
	
	function google_analytics() {

$tracking_id = sanitize_text_field( get_option( 'myoptionalmodules_google' ) );
if( is_single() || is_page() )
	$url = get_permalink();
else
	$url = esc_url( home_url ('/' ) );

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
	
	function front_post() {
		if( is_home() && 'off' != get_option( 'myoptionalmodules_frontpage' ) ) {
			if( is_numeric( get_option( 'myoptionalmodules_frontpage' ) ) ) {
				$mompaf_front = get_option( 'myoptionalmodules_frontpage' );
			} elseif( get_option( 'myoptionalmodules_frontpage' ) == 'on' ) {
				$mompaf_front = '';
			}
			if( have_posts() ) : the_post();
			header( 'location:' . esc_url( get_permalink( $mompaf_front ) ) ); 
			exit; 
			endif;
		}
	}
	function previous_link_class() {
		return 'class="' . get_option( 'myoptionalmodules_previouslinkclass' ) . '"';
	}
	function previous_link( $output ) {
		$class = 'class="' . get_option( 'myoptionalmodules_previouslinkclass' ) . '"';
		return str_replace( '<a href=', '<a '.$class.' href=', $output);
	}
	function next_link_class() {
		return 'class="' . get_option( 'myoptionalmodules_nextlinkclass' ) . '"';
	}
	function next_link( $output ) {
		$class = 'class="' . get_option( 'myoptionalmodules_nextlinkclass' ) . '"';
		return str_replace( '<a href=', '<a '.$class.' href=', $output);	
	}
	function read_more( $more ) {
		if( '%blank%' == get_option( 'myoptionalmodules_readmore' ) ) {
			return '';
		} else {
			return '<a href="' . get_permalink() . '">' . sanitize_text_field( get_option( 'myoptionalmodules_readmore' ) ) . '</a>';
		}
	}
	function random() {

		$random = sanitize_text_field( get_option( 'myoptionalmodules_randompost' ) );

		if( isset( $_GET[ $random ] ) ) {
			$args = array(
				'numberposts' => 1,
				'post_type'   => 'post',
				'post_status' => 'publish',
				'orderby'     => 'rand'
			);
			$get_all = get_posts( $args );
			foreach ($get_all as $all_posts) {
				$random_post=$all_posts->ID;
			}
			header( 'location:' . esc_url( get_permalink( $random_post ) ) ); exit;
		}

	}
	function random_title( $title ) {
		global $wp;
		$titles = '';
		if( '' != get_option( 'myoptionalmodules_randomtitles' ) ) {
			$titles = sanitize_text_field( get_option( 'myoptionalmodules_randomtitles' ) );
		}
		$title = explode( '::', $titles );
		return $title[ array_rand( $title ) ];
	}
	function random_description( $title ) {
		global $wp;
		$descriptions = '';
		if( '' != get_option( 'myoptionalmodules_randomdescriptions' ) ) {
			$descriptions = sanitize_text_field( get_option( 'myoptionalmodules_randomdescriptions' ) );
		}
		$descriptions = explode( '::', $descriptions );
		return $descriptions[ array_rand( $descriptions ) ];
	}

}