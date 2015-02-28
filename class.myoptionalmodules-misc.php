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
		if( get_option( 'mompaf_post' ) && 'off' != get_option( 'mompaf_post' ) ) {
			add_action ( 'wp', array( $this, 'front_post' ) );
		}
		if( '' != get_option( 'mom_previous_link_class' ) ) {
			add_filter( 'previous_posts_link_attributes', array( $this, 'previous_link_class' ) );
			add_filter( 'previous_post_link', array( $this, 'previous_link' ) );
		}
		if( '' != get_option( 'mom_next_link_class' ) ) {
			add_filter( 'next_posts_link_attributes', array( $this, 'next_link_class' ) );
			add_filter( 'next_post_link', array( $this, 'next_link' ) );
		}
		if( '' != get_option( 'mom_readmore_content' ) ) {
			add_filter( 'the_content_more_link', array( $this, 'read_more' ) );
			add_filter( 'excerpt_more', array( $this, 'read_more' ) );
		}
		if( '' != get_option( 'mom_random_get' ) ) {
			add_action( 'wp', array( $this, 'random' ) );
		}
		if( '' != get_option( 'mommodule_random_title' ) ) {
			add_filter( 'pre_option_blogname', array( $this, 'random_title' ), 10, 2 );
		}
		if( '' != get_option( 'mommodule_random_descriptions' ) ) {
			add_filter( 'pre_option_blogdescription', array( $this, 'random_description' ), 10, 2 );	
		}
	}
	function front_post() {
		if( is_home() && 'off' != get_option( 'mompaf_post' ) ) {
			if( is_numeric( get_option( 'mompaf_post' ) ) ) {
				$mompaf_front = get_option( 'mompaf_post' );
			} elseif( get_option( 'mompaf_post' ) == 'on' ) {
				$mompaf_front = '';
			}
			if( have_posts() ) : the_post();
			header( 'location:' . esc_url( get_permalink( $mompaf_front ) ) ); 
			exit; 
			endif;
		}
	}
	function previous_link_class() {
		return 'class="' . get_option( 'mom_previous_link_class' ) . '"';
	}
	function previous_link( $output ) {
		$class = 'class="' . get_option( 'mom_previous_link_class' ) . '"';
		return str_replace( '<a href=', '<a '.$class.' href=', $output);
	}
	function next_link_class() {
		return 'class="' . get_option( 'mom_next_link_class' ) . '"';
	}
	function next_link( $output ) {
		$class = 'class="' . get_option( 'mom_next_link_class' ) . '"';
		return str_replace( '<a href=', '<a '.$class.' href=', $output);	
	}
	function read_more( $more ) {
		if( '%blank%' == get_option( 'mom_readmore_content' ) ) {
			return '';
		} else {
			return '<a href="' . get_permalink() . '">' . sanitize_text_field( get_option( 'mom_readmore_content' ) ) . '</a>';
		}
	}
	function random() {

		$random = sanitize_text_field( get_option( 'mom_random_get' ) );

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
		if( '' != get_option( 'mommodule_random_title' ) ) {
			$titles = sanitize_text_field( get_option( 'mommodule_random_title' ) );
		}
		$title = explode( '::', $titles );
		return $title[ array_rand( $title ) ];
	}
	function random_description( $title ) {
		global $wp;
		$descriptions = '';
		if( '' != get_option( 'mommodule_random_descriptions' ) ) {
			$descriptions = sanitize_text_field( get_option( 'mommodule_random_descriptions' ) );
		}
		$descriptions = explode( '::', $descriptions );
		return $descriptions[ array_rand( $descriptions ) ];
	}

}