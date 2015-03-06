<?php 
/**
 * class.myoptionalmodules-enable
 * Horizontal galleries, Font Awesome, Share icons/links, RSS linkbacks, 404 redirects to home
 *  - Check if ANY of the options for these things are switched before further deciding which functionality
 *    to enable. If none of these options are switched on via settings, then skip this class altogether.
 */

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}

class myoptionalmodules_enable {
	function actions() {
		global $myoptionalmodules_plugin;
		if( get_option( 'mommaincontrol_comments' ) || get_option( 'mommaincontrol_dnsbl' ) && true === $myoptionalmodules_plugin->DNSBL ){
			add_filter( 'comments_template', array( $this, 'comments' ) );
			add_filter( 'comments_open', array( $this, 'comments_form'), 10, 2 );
		}
		if( get_option( 'MOM_themetakeover_horizontal_galleries' ) ) {
			remove_shortcode( 'gallery', 'gallery_shortcode' );
			add_action( 'init', array( $this, 'horizontal_gallery_shortcode'), 99 );
			add_filter( 'use_default_gallery_style', '__return_false' );
		}
		if( get_option( 'mommaincontrol_momshare' ) ) {
			add_filter( 'the_content', array( $this, 'share' ) );
		}
		if( get_option( 'mommaincontrol_protectrss' ) ) {
			add_filter( 'the_content_feed', array( $this, 'rss' ) );
			add_filter( 'the_excerpt_rss', array( $this, 'rss' ) );
		}
		if( get_option( 'mommaincontrol_404' ) ) {
			add_action( 'wp', array( $this, 'no_404s' ) );
		}
		if( get_option( 'mommaincontrol_fontawesome' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'fontawesome' ) );
			add_action ( 'init', array( $this, 'fontawesome_shortcode' ), 99 );
		}
	}

	function comments( $comment_template ) {
		return dirname( __FILE__ ) . '/includes/templates/comments.php';
	}

	function comments_form( $open, $post_id ) {
		$post = get_post( $post_id );
		return false;
	}

	function horizontal_gallery_shortcode() {
		add_shortcode( 'gallery', array( $this, 'shortcode_output' ) );
	}

	function fontawesome() {
		$font_awesome_css = plugins_url() . '/' . plugin_basename( dirname( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css';
		$font_awesome_css = str_replace( array( 'https:', 'http:' ), '', esc_url( $font_awesome_css ) );

		wp_enqueue_style( 'font_awesome',  $font_awesome_css );

		$font_awesome_css = null;
	}

	function fontawesome_shortcode() {
		add_shortcode( 'font-fa',  array( $this, 'font_fa_shortcode' ) );
	}

	function font_fa_shortcode( $atts, $content = null ) {
		extract(
			shortcode_atts( array (
				"i" => ''
			), $atts )
		);

		ob_start();
		return '<i class="fa fa-' . sanitize_text_field( $i ) . '"></i>';
		return ob_get_clean();

		$i = null;
	}

	function shortcode_output( $attr ) {
		$post = get_post();
		static $instance = 0;
		++$instance;
		if( has_shortcode( $post->post_content, 'gallery' ) ) {
			if ( ! empty( $attr[ 'ids' ] ) ) {
				// 'ids' is explicitly ordered, unless you specify otherwise.
				if ( empty( $attr[ 'orderby' ] ) )
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
			$gallery_div = "<div id='$selector' class='horizontalGallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>
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
				</div></div>\n";
			return $output;
		}
	}

	/**
	 * Social Share Links
	 */
	function share( $content ) {
		global $wp, $post;
		
		/**
		 * Settings and variables
		 */
		$fontawesome = sanitize_text_field( get_option( 'mommaincontrol_fontawesome' ) );
		$at_top      = sanitize_text_field( get_option( 'MOM_enable_share_top' ) );
		$on_pages    = sanitize_text_field( get_option( 'MOM_enable_share_pages' ) );
		$excerpt     = htmlentities( str_replace( ' ', '%20', $post->post_excerpt ) ); 
		$title       = str_replace( ' ', '%20', get_the_title( $post->ID ) );

		/**
		 * Content output
		 */
		$output = '<span class="mom_shareLinks">';
		$output .='Share via: ';	
		if( get_option( 'MOM_enable_share_reddit' ) && $fontawesome ) {
			$output .='<a class="reddit fa fa-reddit" href="//www.reddit.com/submit?url=' . get_the_permalink() . '"></a>';
		} elseif( get_option( 'MOM_enable_share_reddit' ) && !$fontawesome ) {
			$output .='<a class="reddit" href="//www.reddit.com/submit?url=' . get_the_permalink() . '">reddit</a>';
		}
		if( get_option( 'MOM_enable_share_google' ) && $fontawesome  ) {
			$output .='<a class="google fa fa-google-plus" href="https://plus.google.com/share?url=' . get_the_permalink() . '"></a>';
		} elseif( get_option( 'MOM_enable_share_google' ) && !$fontawesome  ) {
			$output .='<a class="google" href="https://plus.google.com/share?url=' . get_the_permalink() . '">google+</a>';
		}
		if( get_option( 'MOM_enable_share_twitter' ) && $fontawesome  ) {
			$output .='<a class="twitter fa fa-twitter" href="//twitter.com/home?status=Reading:%20' . get_the_permalink() . '"></a>';
		} elseif( get_option( 'MOM_enable_share_twitter' ) && !$fontawesome  ) {
			$output .='<a class="twitter" href="//twitter.com/home?status=Reading:%20' . get_the_permalink() . '">twitter</a>';
		}
		if( get_option( 'MOM_enable_share_facebook' ) && $fontawesome  ) {
			$output .='<a class="facebook fa fa-facebook" href="//www.facebook.com/sharer.php?u=' . get_the_permalink() . '&amp;t=' . $title . '"></a>';
		} elseif( get_option( 'MOM_enable_share_facebook' ) && !$fontawesome  ) {
			$output .='<a class="facebook" href="//www.facebook.com/sharer.php?u=' . get_the_permalink() . '&amp;t=' . $title . '">facebook</a>';
		}
		if( get_option( 'MOM_enable_share_email' ) && $fontawesome  ) {
			$output .='<a class="email fa fa-envelope" href="mailto:?subject=' . $title . '&amp;body=%20' . $excerpt . '[ ' . get_the_permalink() . ' ]"></a>';
		} elseif( get_option( 'MOM_enable_share_email' ) && !$fontawesome  ) {
			$output .='<a class="email" href="mailto:?subject=' . $title . '&amp;body=' . $excerpt . '%20[ ' . get_the_permalink() . ' ]">email</a>';
		}
		$output .='</span>';

		/**
		 * Determine if top or bottom of post, then display
		 */
		if( is_single() && $at_top ) {
			return $output . $content;
		} elseif( is_single() && !$at_top ) {
			return $content . $output;
		} elseif( is_page() && $on_pages) {
			if( is_page() && $at_top ) {
				return $output . $content;
			} elseif( is_page() && !$at_top ) {
				return $content . $output;
			}
		} else {
			return $content;
		}

		/**
		 * Done with these - drop them
		 */
		$fontawesome = null;
		$at_top      = null;
		$on_pages    = null;
		$excerpt     = null;
		$title       = null;
		$output      = null;
	}

	/**
	 * RSS Link Backs
	 */
	function rss($content){
		global $post;
		return $content . '<p><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . htmlentities( get_post_field( 'post_title', $post->ID ) ) . '</a> via <a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'site_name' ) . '</a></p>';
	}

	/**
	 * 404 Redirection
	 */
	function no_404s() {
		if( is_404() ) {
			header( 'location:' . esc_url( get_site_url() ) );
			exit;
		}
	}

}