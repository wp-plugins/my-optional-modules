<?php 
/**
 * CLASS myoptionalmodules_modules()
 *
 * File last update: 10.0.9.7
 *
 * Functionality for:
 * - Favicon
 * - Full-length feature images
 * - Javascripts to footer
 * - Exclude posts
 */ 

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_modules {

	function __construct() {

		global 
			$myoptionalmodules_javascripttofooter , 
			$myoptionalmodules_exclude ,
			$myoptionalmodules_metatags , 
			$myoptionalmodules_horizontalgalleries , 
			$myoptionalmodules_sharelinks , 
			$myoptionalmodules_rsslinkbacks , 
			$myoptionalmodules_404s , 
			$myoptionalmodules_fontawesome ,
			$myoptionalmodules_plugin , 
			$myoptionalmodules_disablepingbacks , 
			$myoptionalmodules_authorarchives , 
			$myoptionalmodules_datearchives , 
			$myoptionalmodules_disablecomments , 
			$myoptionalmodules_dnsbl , 
			$myoptionalmodules_removecode ,
			$myoptionalmodules_disqus , 
			$myoptionalmodules_randompost , 
			$myoptionalmodules_bing , 
			$myoptionalmodules_alexa , 
			$myoptionalmodules_google , 
			$myoptionalmodules_verification , 
			$myoptionalmodules_frontpage , 
			$myoptionalmodules_readmore , 
			$myoptionalmodules_commentspamfield;

		if( $myoptionalmodules_javascripttofooter ) {
			add_action ( 'wp_enqueue_scripts' , array ( $this , 'remove' ) );
			add_action ( 'wp_footer' , 'wp_enqueue_scripts' , 5 );
			add_action ( 'wp_footer' , 'wp_print_head_scripts' , 5 );
		}

		if( $myoptionalmodules_exclude ) {
			add_action( 'pre_get_posts' , array ( $this , 'exclude' ) );	
		}	
		if( $myoptionalmodules_metatags ) {
			add_action ( 'wp_head' , array ( $this , 'meta' ) );
			add_filter ( 'jetpack_enable_opengraph' , '__return_false' , 99 );
			add_filter ( 'user_contactmethods' , array ( $this , 'twitter' ) );
			add_filter ( 'admin_init' , array ( $this , 'twitter' ) );
		}
		if( $myoptionalmodules_horizontalgalleries ) {
			remove_shortcode ( 'gallery' );
			add_action ( 'init' , array ( $this , 'horizontal_gallery_shortcode' ) , 99 );
			add_filter ( 'use_default_gallery_style' , '__return_false' );
		}

		if( $myoptionalmodules_sharelinks ) {
			add_filter ( 'the_content' , array ( $this , 'share' ) );
		}

		if( $myoptionalmodules_rsslinkbacks ) {
			add_filter ( 'the_content_feed' , array ( $this , 'rss' ) );
			add_filter ( 'the_excerpt_rss' , array ( $this , 'rss' ) );
		}

		if( $myoptionalmodules_404s ) {
			add_action ( 'wp' , array ( $this , 'no_404s' ) );
		}

		if( $myoptionalmodules_fontawesome ) {
			add_action ( 'wp_head' , array ( $this , 'fontawesome' ) );
			add_action ( 'init' , array ( $this , 'fontawesome_shortcode' ) , 99 );
		}
		if( $myoptionalmodules_disablepingbacks ) {
			add_filter( 'xmlrpc_methods' , array ( $this , 'pingbacks' ) );
		}

		if( $myoptionalmodules_authorarchives ) {
			add_action( 'template_redirect', array ( $this , 'author_archives' ) );
		}

		if( $myoptionalmodules_datearchives ) {
			add_action( 'wp', array ( $this , 'date_archives' ) );
			add_action( 'template_redirect' , array ( $this , 'date_archives' ) );
		}

		if ( $myoptionalmodules_dnsbl ) {
			add_filter ( 'preprocess_comment' , array ( $this , 'dnsbl_check' ) );
		}
		
		if( 
			$myoptionalmodules_disablecomments 
		){
			add_filter ( 'comments_template' , array ( $this , 'comments' ) );
			add_filter ( 'comments_open' , array ( $this , 'comments_form') , 10, 2 );
		}

		if( $myoptionalmodules_removecode ) {
			if ( !in_array ( $GLOBALS['pagenow'] , array ( 'wp-login.php' , 'wp-register.php' ) ) ) {
				remove_action ('wp_head' , 'wp_generator');
				add_filter    ( 'style_loader_src' , array ( $this , 'versions' ) , 0 );
				add_filter    ( 'script_loader_src' , array ( $this , 'versions' ) , 0 );
				add_action    ('init', array ( $this , 'head_cleanup' ) );
				add_filter    ( 'style_loader_tag' , array ( $this , 'css_ids' ) );
				add_action    ( 'init', array ( $this , 'replace_jquery' ) );
				add_filter    ( 'wp_default_scripts' , array( $this , 'rem_j_migrate' ) );
				add_action    ( 'wp_enqueue_scripts' , array( $this , 'add_j_migrate' ) );
			}
		}
		if( $myoptionalmodules_disqus ) {
			add_filter ( 'comments_template' , array ( $this , 'disqus_code' ) );
		}
		add_filter ( 'the_content' , array ( $this , 'miniloop' ) );
		if( $myoptionalmodules_google ) {
			add_action ( 'wp_head' , array ( $this , 'google_analytics' ) );
		}
		if( $myoptionalmodules_bing ) {
			add_action ( 'wp_head' , array ( $this , 'bing' ) );
		}
		if( $myoptionalmodules_alexa ) {
			add_action ( 'wp_head' , array ( $this , 'alexa' ) );
		}
		if( $myoptionalmodules_verification ) {
			add_action ( 'wp_head' , array ( $this , 'site_verification' ) );
		}
		if( $myoptionalmodules_frontpage && 'off' != $myoptionalmodules_frontpage ) {
			add_action ( 'wp' , array ( $this , 'front_post' ) );
		}
		if( $myoptionalmodules_readmore ) {
			add_filter ( 'the_content_more_link' , array ( $this , 'read_more' ) );
			add_filter ( 'excerpt_more' , array ( $this , 'read_more' ) );
		}
		if( $myoptionalmodules_randompost ) {
			add_action ( 'wp' , array ( $this , 'random' ) );
		}
		if( $myoptionalmodules_commentspamfield ) {
				add_filter ( 'comment_form_default_fields' , array ( $this , 'spam_field' ) );
				add_action ( 'comment_form_logged_in_after' , array ( $this , 'spam_field' ) );
				add_action ( 'comment_form_after_fields' , array ( $this , 'spam_field' ) );
				add_filter ( 'preprocess_comment' , array ( $this , 'field_check' ) );
		}

	}
	
	/**
	 * Extras -> Javascript-to-footer
	 * Remove enqueued scripts from wp_head
	 */
	function remove() {
		remove_action ( 'wp_head' , 'wp_print_head_scripts' , 9 );
		remove_action ( 'wp_head' , 'wp_enqueue_scripts' , 1 );
	}

	/**
	 * Extras -> Enable Exclude Posts
	 * Exclude posts from the loop based on several
	 * parameters (set in options).
	 */	
	function exclude( $query ) {
		global $myoptionalmodules_blank_counter;
		++$myoptionalmodules_blank_counter;
		if ( 1 == $myoptionalmodules_blank_counter ) {
			include( 'function.exclude.php' );
		}
	}
	
	// Twitter Field for User Profiles
	function twitter( $profile_fields ){
		$profile_fields['twitter_personal'] = 'Twitter handle';
		return $profile_fields;
	}

	// Meta Tags (og:/Twitter)
	function meta() {

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
		
		// Noindex/Noarchive archives/404s/search results to avoid duplicate content
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
				
				$image_comment = null;
				if ( $attachment->post_excerpt ):
					$image_comment = strip_tags ( htmlentities ( $attachment->post_excerpt ) );
				endif;
				
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
				$output .= "<{$itemtag} img-id='{$id}' class='gallery-item'>";
				$output .= "
					<{$icontag} class='gallery-icon {$orientation}'>
						{$image_output}
					</{$icontag}>";
				if ( $captiontag && trim($attachment->post_excerpt) ) {
					$output .= "
						<{$captiontag} img-comment='{$image_comment}' id='{$id}' class='wp-caption-text gallery-caption'>
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
	
	// Removing Superfluous Code
	function replace_jquery() {

		global $myoptionalmodules_jquery_version;

		if( !is_admin()) {
			wp_deregister_script ( 'jquery' );
			wp_register_script   ( 'jquery' , $myoptionalmodules_jquery_version , false );
			wp_enqueue_script    ( 'jquery' );
		}

	}

	function rem_j_migrate( &$scripts ) {
		if( !is_admin() ) {
			$scripts->remove ( 'jquery' );
			$scripts->add ( 'jquery' , false , array ( 'jquery-core' ) );
		}
	}

	function add_j_migrate() {

		global $myoptionalmodules_jquerymigrate_version;

		wp_deregister_script ( 'jquery-migrate' );
		wp_register_script (
			'jquery-migrate',
			$myoptionalmodules_jquerymigrate_version,
			array( 'jquery' ),
			true
		);

		wp_enqueue_script ( 'jquery-migrate' );

	}

	//benword.com/how-to-hide-that-youre-using-wordpress/
	function head_cleanup() {

		  global $wp_widget_factory;

		  remove_action ( 'wp_head' , 'feed_links' , 2);
		  remove_action ( 'wp_head' , 'feed_links_extra' , 3);
		  remove_action ( 'wp_head' , 'rsd_link');
		  remove_action ( 'wp_head' , 'wlwmanifest_link');
		  remove_action ( 'wp_head' , 'adjacent_posts_rel_link_wp_head' , 10 , 0);
		  remove_action ( 'wp_head' , 'wp_generator');
		  remove_action ( 'wp_head' , 'wp_shortlink_wp_head' , 10 , 0);
		  remove_action ( 'wp_head' , array ( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] , 'recent_comments_style' ) );
		  add_filter    ( 'use_default_gallery_style' , '__return_null' );
	}

	// REMOVE stylesheet IDs
	//blog.codecentric.de/en/2011/10/wordpress-and-mod_pagespeed-why-combine_css-does-not-work/
	function css_ids( $link ) {

		return preg_replace ( "/id='.*-css'/" , '' , $link );

	}

	// Version Information
	function versions( $src ) {

		if( strpos ( $src , 'ver=' . get_bloginfo ( 'version' ) ) ) { 
			$src = remove_query_arg ( 'ver' , $src );
		}

		return $src;

	}

	// Disable author archives on blogs with only 1 author
	function author_archives(){

		global $wp_query;

		if( is_author() ) {
			if( sizeof ( get_users ( 'who=authors' ) ) === 1 )
				wp_redirect ( get_bloginfo ( 'url' ) );
		}

	}

	// Disable date archives
	function date_archives(){

		global $wp_query;

		if( 
			is_date()    || 
			is_year()    || 
			is_month()   || 
			is_day()     || 
			is_time()    || 
			is_new_day() 
		) {
			$homeURL = esc_url ( home_url ( '/' ) );

			if ( have_posts() ):the_post();
			header( 'location:' . $homeURL );
			exit;
			endif;
		}

	}

	// Blank Comments template
	function comments( $comment_template ) {

		return dirname( __FILE__ ) . '/includes/templates/comments.php';

	}

	// Destroy the Comments Form (if we need to)
	function comments_form( $open , $post_id ) {

		$post = get_post ( $post_id );
		return false;

	}	

	// Disable Pingback.php
	function pingbacks( $methods ) {

		unset ( $methods['pingback.ping'] );
		return $methods;

	}
	// Disqus Universal Code
	function disqus_code ( $comment_template ) {
		return dirname( __FILE__ ) . '/includes/templates/disqus.php';
	}
	
	// Miniloops
	function miniloop ( $content ) {
		global $wp , $post , $myoptionalmodules_miniloopmeta , $myoptionalmodules_miniloopstyle , $myoptionalmodules_miniloopamount;
		if( is_single() && $myoptionalmodules_miniloopmeta && $myoptionalmodules_miniloopstyle && $myoptionalmodules_miniloopamount):
			$key    = sanitize_text_field ( get_post_meta ( $post->ID , $myoptionalmodules_miniloopmeta , true ) );
			if( $key && $myoptionalmodules_miniloopmeta ):
				$output = do_shortcode ( "[mom_miniloop meta='{$myoptionalmodules_miniloopmeta}' key='{$key}' style='{$myoptionalmodules_miniloopstyle}' amount='{$myoptionalmodules_miniloopamount}' ]" );
			else:
				$output = null;
			endif;
			return do_shortcode ( $content ) . $output;
		else:
			return do_shortcode ( $content );
		endif;
	}

	// Google Analytics
	// Don't show if user is admin
	function google_analytics() {
		global $wp , $myoptionalmodules_google , $myoptionalmodules_analyticspostsonly;
		if ( !current_user_can ( 'manage_options' ) ):
			$output = "
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				ga('create', '{$myoptionalmodules_google}', 'auto');
				ga('send', 'pageview');
			</script>\n\n
			";
			
			if ( $myoptionalmodules_analyticspostsonly ):
				if ( is_single() ):
					echo $output;
				endif;
			else:
				echo $output;
			endif;
			
		endif;
	}
	
	// Site Verification Content
	// + Google
	// + Bing
	// + Alexa
	function site_verification() {
		global $myoptionalmodules_verification;
		echo "<meta name='google-site-verification' content='{$myoptionalmodules_verification}' />\n\n";
	}
	function bing() {
		global $myoptionalmodules_bing;
		echo "<meta name='msvalidate.01' content='{$myoptionalmodules_bing}' />\n";
	}
	function alexa() {
		global $myoptionalmodules_alexa;
		echo "<meta name='alexaVerifyID' content='{$myoptionalmodules_alexa}'/>\n";	
	}

	// Frontpage post
	function front_post( $query ) {
		global $myoptionalmodules_frontpage;
		
	if( is_home() && 'off' != $myoptionalmodules_frontpage ):
			if( is_numeric ( $myoptionalmodules_frontpage ) ):
				$myoptionalmodules_frontpage = $myoptionalmodules_frontpage;
			elseif( $myoptionalmodules_frontpage ):
				$myoptionalmodules_frontpage = '';
			endif;
			if( have_posts() ) : the_post();
				header( 'location:' . esc_url( get_permalink( $myoptionalmodules_frontpage ) ) ); 
				exit; 
			endif;
		endif;
	}

	// Read More
	function read_more( $more ) {
		global $myoptionalmodules_readmore;
		$get_link = esc_url ( get_permalink() );
		if( '%blank%' == $myoptionalmodules_readmore ):
			return '';
		else:
			return "<a href='{$get_link}'>{$myoptionalmodules_readmore}</a>";
		endif;
	}

	// Random post
	function random() {
		global $myoptionalmodules_randompost;
		if( isset( $_GET[ $myoptionalmodules_randompost ] ) ):
			$args = array (
				'numberposts' => 1,
				'post_type'   => 'post',
				'post_status' => 'publish',
				'orderby'     => 'rand'
			);
			$get_all = get_posts ( $args );
			foreach ( $get_all as $all_posts ):
				$random_post = $all_posts->ID;
			endforeach;
			header ( 'location:' . esc_url ( get_permalink ( $random_post ) ) ); exit;
		endif;
	}

	// Spam field
	// Spam field will not show up for visitors who are logged in
	function spam_field( $fields ) {
		$fields[ 'spam' ] = '<input id="mom_fill_me_out" name="mom_fill_me_out" type="hidden" value="" />';
		return $fields;
	}
	function field_check( $commentdata ) {
		if ( $_REQUEST['mom_fill_me_out'] ) {
			wp_die (  __ ( '<strong>Error</strong>: You seem to have filled something out that you shouldn\'t have.' ) );
		}
		return $commentdata;
	}
	
	function dnsbl_check ( $commentdata ) {
		global $myoptionalmodules_plugin;
		$myoptionalmodules_plugin->validate_ip_address();
		if ( true === $myoptionalmodules_plugin->DNSBL ) {
			wp_die (  __ ( '<strong>Error</strong>: You can\'t do that.' ) );
		}
		return $commentdata;
	}
}

$myoptionalmodules_modules = new myoptionalmodules_modules();