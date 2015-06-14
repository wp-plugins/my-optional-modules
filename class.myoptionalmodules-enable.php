<?php 
/**
 * CLASS myoptionalmodules_enable()
 *
 * File last update: 10.0.4
 *
 * Functionality for:
 * - Meta Tags
 * - Horizontal Galleries
 * - Share Links
 * - RSS Linkbacks
 * - 404s
 * - Font Awesome
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_enable {

	function __construct() {
		global $myoptionalmodules_metatags , $myoptionalmodules_horizontalgalleries , $myoptionalmodules_sharelinks , $myoptionalmodules_rsslinkbacks , $myoptionalmodules_404s , $myoptionalmodules_fontawesome;
		if( $myoptionalmodules_metatags ):
			add_action ( 'wp_head' , array ( $this , 'meta' ) );
			add_filter ( 'jetpack_enable_opengraph' , '__return_false' , 99 );
			add_filter ( 'user_contactmethods' , array ( $this , 'twitter' ) );
			add_filter ( 'admin_init' , array ( $this , 'twitter' ) );
		endif;

		if( $myoptionalmodules_horizontalgalleries ):
			remove_shortcode ( 'gallery' );
			add_action ( 'init' , array ( $this , 'horizontal_gallery_shortcode' ) , 99 );
			add_filter ( 'use_default_gallery_style' , '__return_false' );
		endif;

		if( $myoptionalmodules_sharelinks ):
			add_filter ( 'the_content' , array ( $this , 'share' ) );
		endif;

		if( $myoptionalmodules_rsslinkbacks ):
			add_filter ( 'the_content_feed' , array ( $this , 'rss' ) );
			add_filter ( 'the_excerpt_rss' , array ( $this , 'rss' ) );
		endif;

		if( $myoptionalmodules_404s ):
			add_action ( 'wp' , array ( $this , 'no_404s' ) );
		endif;

		if( $myoptionalmodules_fontawesome ):
			add_action ( 'wp_head' , array ( $this , 'fontawesome' ) );
			add_action ( 'init' , array ( $this , 'fontawesome_shortcode' ) , 99 );
		endif;
	}

	// Twitter Field for User Profiles
	function twitter( $profile_fields ){
		$profile_fields['twitter_personal'] = 'Twitter handle';
		return $profile_fields;
	}

	// Meta Tags (og:/Twitter)
	function meta(){

		global $post, $wp;

		$author    = null;

		// OG:
		$id             = null;
		$title          = null;
		$type           = null;
		$thumbnail      = null;
		$image          = null;
		$url            = null;
		$site           = null;
		$excerpt        = null;
		$external       = null;
		$host           = null;
		$path           = null;
		$video_w        = null;
		$video_h        = null;
		$published_time = null;
		$modified_time  = null;
		$posttags       = null;
		$numtags        = null;
		$num            = null;

		if( is_single() || is_page() )
			$id = $post->ID;

		if( is_single() || is_page() || is_author() )
			$author = $post->post_author;

		$og_type = 'image';
	
		if( is_single() || is_page() ) {
			$type  = 'article';
			$title = sanitize_text_field ( str_replace ( '\'' , '' , get_post_field ( 'post_title' , $id ) ) );
			$image = wp_get_attachment_image_src ( get_post_thumbnail_id ( $id ) , 'single-post-thumbnail' );
			$image = $image[0];
		
			// If External Feature Images isn't enabled, we can't use this function.
			if ( function_exists ( 'myoptionalmodules_get_thumbnail_src' ) )
				$external = myoptionalmodules_get_thumbnail_src( $id );

			if( $external ) {
				if ( isset ( parse_url ( $external ) [ 'host'  ] ) )
					$host  = parse_url ( $external ) [ 'host'  ];
				if ( isset ( parse_url ( $external ) [ 'path'  ] ) )
					$path  = parse_url ( $external ) [ 'path'  ];

				if( strpos ( $host , 'youtube.com' ) !== false ) {
					$video     = explode ( '/' , $external );
					$video     = $video [ sizeof ( $video ) - 1 ];
					$og_type   = 'video';
					$image     = "//youtube.com/v/$video?version=3&amp;autohide=1";
					$video_w   = '398';
					$video_h   = '264';
					$thumbnail = "//img.youtube.com/vi/$video/0.jpg";
					$type      = 'video';
				}

				if( strpos ( $host , 'imgur.com' ) !== false && strpos ( $path , '/album/' ) === false )
					$image   = $external;

			}

			$url      = get_permalink( $id );
			$site     = get_bloginfo( 'name' );
			$excerpt  = strip_tags ( esc_html ( preg_replace ( '/\s\s+/i' , '' , get_the_excerpt ( ) ) ) );
		} else {
			$title    = get_bloginfo ( 'name' );
			$url      = esc_url ( home_url ( '/' ) );
			$type     = 'website';
		}

		if( is_author() ) {
			$type  = 'profile';
			$url   = get_author_posts_url( $author );
		}

		$title          = sanitize_text_field ( str_replace ( '\'' , '' , $title ) );
		$url            = sanitize_text_field ( str_replace ( array ( 'https:' , 'http:' ) , '' , esc_url ( $url ) ) );
		$title          = sanitize_text_field( $title );
		$site           = sanitize_text_field( $site );
		$excerpt        = sanitize_text_field( $excerpt );
		$type           = sanitize_text_field( $type );
		$image          = sanitize_text_field( $image );
		$video_w        = sanitize_text_field( $video_w );
		$video_h        = sanitize_text_field( $video_h );
		$url            = sanitize_text_field( $url );
		$published_time = get_the_date( 'Y-m-dTH:i:sP');
		$modified_time  = get_the_modified_date( 'Y-m-dTH:i:sP');
		$posttags       = get_the_tags();
		$numtags        = count ( $posttags );
		$num            = 0;
		
		if ( $title ):          echo "\n<meta property='og:title' content='{$title}'>";                          endif;
		if ( $site ):           echo "\n<meta property='og:site_name' content='{$site}'>";                       endif;
		if ( $excerpt ):        echo "\n<meta property='og:description' content='{$excerpt}'>";                  endif;
		if ( $type ):           echo "\n<meta property='og:type' content='{$type}'>";                            endif;
		if ( $thumbnail ):      echo "\n<meta property='og:image' content='{$thumbnail}'>";                      endif;
		if ( $image ):          echo "\n<meta property='og:$og_type' content='{$image}'>";                       endif;
		if ( $video_w ):        echo "\n<meta property='og:video:width' content='{$video_w}'>";                  endif;
		if ( $video_h ):        echo "\n<meta property='og:video:height' content='{$video_h}'>";                 endif;
		if ( $url ):            echo "\n<meta property='og:url' content='{$url}'>";                              endif;
		if ( $published_time ): echo "\n<meta property='article:published_time' content='{$published_time}' />"; endif;
		if ( $modified_time ):  echo "\n<meta property='article:modified_time' content='{$modified_time}' />";   endif;
		if ( $modified_time ):  echo "\n<meta property='og:updated_time' content='{$modified_time}' />";         endif;
		if ($posttags):
			echo "\n<meta property='article:tag' content='";
			  foreach( $posttags as $tag ):
				echo "{$tag->name}";
				if ( ++$num !== $numtags ):
					echo ',';
				endif;
			  endforeach;
			echo "' />";
		endif;

		$id             = null;
		$title          = null;
		$type           = null;
		$thumbnail      = null;
		$image          = null;
		$url            = null;
		$site           = null;
		$excerpt        = null;
		$external       = null;
		$host           = null;
		$path           = null;
		$video_w        = null;
		$video_h        = null;
		$published_time = null;
		$modified_time  = null;
		$posttags       = null;
		$numtags        = null;
		$num            = null;

		// Twitter
		$card        = null;
		$attribution = null;
		
		if( is_single() || is_page() ) {
			$card        = 'summary';
			$attribution = get_the_author_meta ( 'twitter_personal' , $author );
			$attribution = sanitize_text_field ( str_replace ( array ( '@' , '\'' ) , '' , $attribution ) );

			if( $attribution ) {
				$card        = sanitize_text_field ( $card );
				$attribution = sanitize_text_field ( $attribution );

				if( $card )        echo "\n<meta name='twitter:card' content='{$card}'>";
				if( $attribution ) echo "\n<meta name='twitter:creator' content='@{$attribution}'>";

			}

			$card         = null;
			$attribution  = null;

		}
		
		// No-index/No-Follow archives/404s/search results to avoid duplicate content
		if( 
			is_search() || 
			is_404() || 
			is_archive() 
		){ 
			echo "\n<meta name='robots' content='noindex,noarchive'>";
		}

		echo "\n\n";
		
		$author = null;

	}

	// Horizontal Gallery Shortcode
	function horizontal_gallery_shortcode() {

		add_shortcode ( 'gallery' , array ( $this , 'shortcode_output' ) );

	}

	// CORE Gallery Shortcode copy/paste and altered for Horizontal display
	function shortcode_output( $attr ) {

		$post            = get_post();
		static $instance = 0;

		++$instance;

		if ( has_shortcode ( $post->post_content , 'gallery' ) ) {
			if ( ! empty( $attr[ 'ids' ] ) ) {
				// 'ids' is explicitly ordered, unless you specify otherwise.
				if ( empty ( $attr[ 'orderby' ] ) )
				$attr[ 'orderby' ] = 'post__in';
				$attr[ 'include' ] = $attr[ 'ids' ];
			}
			/**
			 * Filter the default gallery shortcode output.
			 *
			 * If the filtered output isn't empty, it will be used instead of generating
			 * the default gallery template.
			 *
			 * @since 2.5.0
			 *
			 * @see gallery_shortcode()
			 *
			 * @param string $output The gallery output. Default empty.
			 * @param array  $attr   Attributes of the gallery shortcode.
			 */
			$output = apply_filters( 'post_gallery', '', $attr );
			if ( $output != '' )
				return $output;
			// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			if ( isset( $attr[ 'orderby' ] ) ) {
				$attr[ 'orderby' ] = sanitize_sql_orderby( $attr[ 'orderby' ] );
				if ( !$attr[ 'orderby' ] )
					unset( $attr[ 'orderby' ] );
			}
			$html5 = current_theme_supports( 'html5', 'gallery' );
			extract(shortcode_atts(array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post ? $post->ID : 0,
				'itemtag'    => $html5 ? 'figure'     : 'dl',
				'icontag'    => $html5 ? 'div'        : 'dt',
				'captiontag' => $html5 ? 'figcaption' : 'dd',
				'columns'    => 3,
				'size'       => 'thumbnail',
				'include'    => '',
				'exclude'    => '',
				'link'       => ''
			), $attr, 'gallery' ) );
			$id = intval( $id );
			if ( 'RAND' == $order )
				$orderby = 'none';
			if ( !empty($include) ) {
				$_attachments = get_posts( array( 'include' => $include, 'post_status' => null, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
				$attachments = array();
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			} elseif ( !empty($exclude) ) {
				$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => null, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
			} else {
				$attachments = get_children( array( 'post_parent' => $id, 'post_status' => null, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
			}
			if ( empty($attachments) )
				return '';
			if ( is_feed() ) {
				$output = "\n";
				foreach ( $attachments as $att_id => $attachment )
					$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
				return $output;
			}
			$itemtag = tag_escape($itemtag);
			$captiontag = tag_escape($captiontag);
			$icontag = tag_escape($icontag);
			$valid_tags = wp_kses_allowed_html( 'post' );
			if ( ! isset( $valid_tags[ $itemtag ] ) )
				$itemtag = 'dl';
			if ( ! isset( $valid_tags[ $captiontag ] ) )
				$captiontag = 'dd';
			if ( ! isset( $valid_tags[ $icontag ] ) )
				$icontag = 'dt';
			$columns = intval($columns);
			$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
			$float = is_rtl() ? 'right' : 'left';
			$selector = "gallery-{$instance}";
			$gallery_style = $gallery_div = '';
			/**
			 * Filter whether to print default gallery styles.
			 *
			 * @since 3.1.0
			 *
			 * @param bool $print Whether to print default gallery styles.
			 *                    Defaults to false if the theme supports HTML5 galleries.
			 *                    Otherwise, defaults to true.
			 */
			if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
				$gallery_style = "
				<style type='text/css'>
					#{$selector} {
						margin: auto;
					}
					#{$selector} .gallery-item {
						float: {$float};
						margin-top: 10px;
						text-align: center;
						width: {$itemwidth}%;
					}
					#{$selector} img {
						border: 2px solid #cfcfcf;
					}
					#{$selector} .gallery-caption {
						margin-left: 0;
					}
					/* see gallery_shortcode() in wp-includes/media.php */
				</style>\n\t\t";
			}
			$items = 0;
			foreach ( $attachments as $id => $attachment ) {
				++$items;
			}
			$div_length = ( $items * 150 ) . 'px';
			$size_class = sanitize_html_class( $size );
		$gallery_div = "<div id='mom-hgallery-$selector' data-gallery-id='{$id}' class='horizontalGallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>
				<div style=\"width:" . $div_length . "\" class=\"innerGallery\">";
			/**
			 * Filter the default gallery shortcode CSS styles.
			 *
			 * @since 2.5.0
			 *
			 * @param string $gallery_style Default gallery shortcode CSS styles.
			 * @param string $gallery_div   Opening HTML div container for the gallery shortcode output.
			 */
			$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );
			$i = 0;
			foreach ( $attachments as $id => $attachment ) {
				if ( ! empty( $link ) && 'file' === $link )
					$image_output = wp_get_attachment_link( $id, $size, false, false );
				elseif ( ! empty( $link ) && 'none' === $link )
					$image_output = wp_get_attachment_image( $id, $size, false );
				else
					$image_output = wp_get_attachment_link( $id, $size, true, false );
				$image_meta  = wp_get_attachment_metadata( $id );
				$orientation = '';
				if ( isset( $image_meta[ 'height' ], $image_meta[ 'width' ] ) )
					$orientation = ( $image_meta[ 'height' ] > $image_meta[ 'width' ] ) ? 'portrait' : 'landscape';
				$output .= "<{$itemtag} class='gallery-item'>";
				$output .= "
					<{$icontag} class='gallery-icon {$orientation}'>
						$image_output
					</{$icontag}>";
				if ( $captiontag && trim($attachment->post_excerpt) ) {
					$output .= "
						<{$captiontag} class='wp-caption-text gallery-caption'>
						" . wptexturize($attachment->post_excerpt) . "
						</{$captiontag}>";
				}
				$output .= "</{$itemtag}>";
				if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
					$output .= '<br style="clear: both" />';
				}
			}
			$output .= "
				</div></div><div id='mom_hgallery_catch_{$id}' class='mom-hgallery-catch'></div>\n";
			return $output;
		}
	}

	// Enqueue Font Awesome/Shortcode
	function fontawesome() {

		$font_awesome_css = plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css';
		$font_awesome_css = str_replace ( array ( 'https:', 'http:' ) , '' , esc_url ( $font_awesome_css ) );
echo "<script>
	var cb = function() {
	var l = document.createElement('link'); l.rel = 'stylesheet';
	l.href = '{$font_awesome_css}';
	var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);
	};
	var raf = requestAnimationFrame || mozRequestAnimationFrame ||
	webkitRequestAnimationFrame || msRequestAnimationFrame;
	if (raf) raf(cb);
	else window.addEventListener('load', cb);
</script>
<noscript>
	<link rel='stylesheet' href='{$font_awesome_css}' type='text/css' media='all' />
</noscript>\n";
		$font_awesome_css = null;

	}

	function fontawesome_shortcode() {

		add_shortcode ( 'font-fa',  array ( $this , 'font_fa_shortcode' ) );

	}

	function font_fa_shortcode( $atts, $content = null ) {

		extract(
			shortcode_atts ( 
				array (
					"i" => ''
				), 
			$atts )
		);

		ob_start();
		return '<i class="fa fa-' . sanitize_text_field( $i ) . '"></i>';
		return ob_get_clean();

		$i = null;
	}

	// Share Links
	function share( $content ) {

		global 
		$wp                                  , $post                                 , $myoptionalmodules_fontawesome         , 
		$myoptionalmodules_shareslinks_top   , $myoptionalmodules_sharelinks_pages   , $myoptionalmodules_sharelinks_reddit   , 
		$myoptionalmodules_sharelinks_google , $myoptionalmodules_sharelinks_twitter , $myoptionalmodules_sharelinks_facebook , 
		$myoptionalmodules_sharelinks_email  , $myoptionalmodules_sharelinks_text;

		$excerpt     = htmlentities ( str_replace ( ' ' , '%20' , $post->post_excerpt ) ); 
		$title       = str_replace ( ' ' , '%20' , get_the_title ( $post->ID ) );
		$url         = esc_url ( get_the_permalink() );
		
		$output  = '<div class="mom_shareLinks">';
		
		if( $myoptionalmodules_sharelinks_text ):
			$myoptionalmodules_sharelinks_text = esc_html ( $myoptionalmodules_sharelinks_text );
			$output .= "<span>{$myoptionalmodules_sharelinks_text}</span>";
		endif;
		if( $myoptionalmodules_sharelinks_reddit && $myoptionalmodules_fontawesome ):
			$output .= "<a class='reddit fa fa-reddit' href='//www.reddit.com/submit?url={$url}'></a>";
		elseif( $myoptionalmodules_sharelinks_reddit && !$myoptionalmodules_fontawesome ):
			$output .= "<a class='reddit' href='//www.reddit.com/submit?url={$url}'>reddit</a>";
		endif;

		if( $myoptionalmodules_sharelinks_google && $myoptionalmodules_fontawesome  ):
			$output .= "<a class='google fa fa-google-plus' href='https://plus.google.com/share?url={$url}'></a>";
		elseif( $myoptionalmodules_sharelinks_google && !$myoptionalmodules_fontawesome  ):
			$output .= "<a class='google' href='https://plus.google.com/share?url={$url}'>google+</a>";
		endif;

		if( $myoptionalmodules_sharelinks_twitter && $myoptionalmodules_fontawesome  ):
			$output .= "<a class='twitter fa fa-twitter' href='//twitter.com/home?status=Reading:%20{$url}'></a>";
		elseif( $myoptionalmodules_sharelinks_twitter && !$myoptionalmodules_fontawesome  ):
			$output .= "<a class='twitter' href='//twitter.com/home?status=Reading:%20{$url}'>twitter</a>";
		endif;

		if( $myoptionalmodules_sharelinks_facebook && $myoptionalmodules_fontawesome  ):
			$output .= "<a class='facebook fa fa-facebook' href='//www.facebook.com/sharer.php?u={$url}&amp;t={$title}'></a>";
		elseif( $myoptionalmodules_sharelinks_facebook && !$myoptionalmodules_fontawesome  ):
			$output .= "<a class='facebook' href='//www.facebook.com/sharer.php?u={$url}&amp;t={$title}'>facebook</a>";
		endif;

		if( $myoptionalmodules_sharelinks_email && $myoptionalmodules_fontawesome  ):
			$output .= "<a class='email fa fa-envelope' href='mailto:?subject={$title}&amp;body=%20{$excerpt}[{$url}]'></a>";
		elseif( $myoptionalmodules_sharelinks_email && !$myoptionalmodules_fontawesome  ):
			$output .= "<a class='email' href='mailto:?subject={$title}&amp;body={$excerpt}%20[{$url}]'>email</a>";
		endif;

		$output .='</div>';

		if( is_single() && $myoptionalmodules_shareslinks_top ):
			return $output . $content;
		elseif( is_single() && !$myoptionalmodules_shareslinks_top ):
			return do_shortcode ( $content ) . $output;
		elseif( is_page() && $myoptionalmodules_sharelinks_pages):
			if( is_page() && $myoptionalmodules_shareslinks_top ):
				return $output . $content;
			elseif( is_page() && !$myoptionalmodules_shareslinks_top ):
				return do_shortcode ( $content ) . $output;
			endif;
		else:
			return do_shortcode ( $content );
		endif;

	}

	// RSS Linkbacks
	function rss($content){

		global $post;
		return $content . '<p><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . htmlentities( get_post_field( 'post_title', $post->ID ) ) . '</a> via <a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'site_name' ) . '</a></p>';

	}

	// 404s
	function no_404s() {

		if( is_404() ):
			header ( 'location:' . esc_url ( get_site_url() ) );
			exit;
		endif;

	}

}

$myoptionalmodules_enable = new myoptionalmodules_enable();