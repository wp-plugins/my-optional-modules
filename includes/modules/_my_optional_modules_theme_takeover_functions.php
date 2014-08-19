<?php 

/**
 *
 * Module->Takeover->Functionality
 *
 * Different functions utilized by the Takeover module
 *
 * Since ?
 * @my_optional_modules
 *
 */

/**
 *
 * Don't call this file directly
 *
 */
if( !defined( 'MyOptionalModules' ) ) {

	die();

}

if( 1 == get_option( 'mommaincontrol_themetakeover' ) ) {

	if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ) {

		remove_shortcode( 'gallery', 'gallery_shortcode' );
		add_action( 'init', 'mom_gallery_shortcode_add', 99 );

		function mom_gallery_shortcode_add() {

			add_shortcode( 'gallery', 'mom_gallery_shortcode' );

		}
		add_filter( 'use_default_gallery_style', '__return_false' );

		/**
		 * The Gallery shortcode.
		 *
		 * This implements the functionality of the Gallery Shortcode for displaying
		 * WordPress images on a post.
		 *
		 * @since 2.5.0
		 *
		 * @param array $attr {
		 *     Attributes of the gallery shortcode.
		 *
		 *     @type string $order      Order of the images in the gallery. Default 'ASC'. Accepts 'ASC', 'DESC'.
		 *     @type string $orderby    The field to use when ordering the images. Default 'menu_order ID'.
		 *                              Accepts any valid SQL ORDERBY statement.
		 *     @type int    $id         Post ID.
		 *     @type string $itemtag    HTML tag to use for each image in the gallery.
		 *                              Default 'dl', or 'figure' when the theme registers HTML5 gallery support.
		 *     @type string $icontag    HTML tag to use for each image's icon.
		 *                              Default 'dt', or 'div' when the theme registers HTML5 gallery support.
		 *     @type string $captiontag HTML tag to use for each image's caption.
		 *                              Default 'dd', or 'figcaption' when the theme registers HTML5 gallery support.
		 *     @type int    $columns    Number of columns of images to display. Default 3.
		 *     @type string $size       Size of the images to display. Default 'thumbnail'.
		 *     @type string $ids        A comma-separated list of IDs of attachments to display. Default empty.
		 *     @type string $include    A comma-separated list of IDs of attachments to include. Default empty.
		 *     @type string $exclude    A comma-separated list of IDs of attachments to exclude. Default empty.
		 *     @type string $link       What to link each image to. Default empty (links to the attachment page).
		 *                              Accepts 'file', 'none'.
		 * }
		 * @return string HTML content to display gallery.
		 */
		function mom_gallery_shortcode( $attr ) {

			global $post,$attr,$wp;
			$post = get_post();

			static $instance = 0;
			$instance++;

			if ( ! empty( $attr['ids'] ) ) {

				// 'ids' is explicitly ordered, unless you specify otherwise.
				if ( empty( $attr['orderby'] ) )
					$attr['orderby'] = 'post__in';
				$attr['include'] = $attr['ids'];

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
			if ( isset( $attr['orderby'] ) ) {

				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				if ( !$attr['orderby'] )
					unset( $attr['orderby'] );

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

			), $attr, 'gallery'));

			$id = intval( $id );
			if ( 'RAND' == $order )
				$orderby = 'none';

			if ( !empty($include) ) {
				$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

				$attachments = array();

				foreach ( $_attachments as $key => $val ) {

					$attachments[$val->ID] = $_attachments[$key];
				}

			} elseif ( !empty($exclude) ) {

				$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			} else {

				$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

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

				$items++;

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
				if ( isset( $image_meta['height'], $image_meta['width'] ) )
			
					$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

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
	
	if( 1 == get_option( 'MOM_themetakeover_topbar' ) || 2 == get_option( 'MOM_themetakeover_topbar' ) ) {

		function mom_topbar() {

			global $wp, $post;

			ob_start();

			the_title_attribute();
			$title = ob_get_clean();

			if( is_single() || is_page() ) {

				$postid    = intval( $post->ID );
				$the_title = sanitize_text_field( get_post_field( 'post_title',$postid ) );
				$post_link = esc_url( get_permalink( $post->ID ) );

			} else {

				$the_title = get_bloginfo('site_name');
				$post_link = esc_url(home_url('/'));

			}

			echo '<div class="momnavbar ';

			if( 1 == get_option( 'MOM_themetakeover_topbar_color') ) {

				$scheme = 'momschemedark'; 
				echo 'navbardark ';

			} elseif( 2 == get_option( 'MOM_themetakeover_topbar_color') ) {

				$scheme = 'momschemelight'; 
				echo 'navbarlight ';

			} elseif( 4 == get_option( 'MOM_themetakeover_topbar_color') ) {

				$scheme = 'momschemered'; 
				echo 'navbarred ';

			} elseif( 5 == get_option( 'MOM_themetakeover_topbar_color') ) {

				$scheme = 'momschemegreen'; 
				echo 'navbargreen ';

			} elseif( 6 == get_option( 'MOM_themetakeover_topbar_color') ) {

				$scheme = 'momschemeblue'; 
				echo 'navbarblue ';

			} elseif( 7 == get_option( 'MOM_themetakeover_topbar_color') ) {

				$scheme = 'momschemeyellow'; 
				echo 'navbaryellow ';

			} else {

				$scheme = 'momschemedefault'; 
				echo 'navbardefault ';

			}

			if(get_option('MOM_themetakeover_topbar') == 1){ $isTop = 'down'; echo 'navbartop';}elseif(get_option('MOM_themetakeover_topbar') == 2){ $isTop = 'up'; echo 'navbarbottom';} echo'">';
			echo '<ul class="momnavbarcategories">
			<li><a href="'.esc_url(home_url('/')).'">Front</a></li>';
			$args = array('numberposts'=>'1');
			$latestpost = wp_get_recent_posts($args);
			foreach($latestpost as $latest){
				echo '<li><a href="'.esc_url(get_permalink($latest["ID"])).'" title="'.esc_attr($latest["post_title"]).'" >Latest</a></li>';
			}		
			if(get_option('MOM_themetakeover_topbar_share') == 1){
				//http://www.webdesignerforum.co.uk/topic/70328-easy-social-sharing-buttons-for-wordpress-without-a-plugin/
				$excerpt = htmlentities( str_replace( ' ', '%20', get_the_excerpt() ) ); 
				$title   = str_replace( ' ', '%20', get_the_title() );				
				echo '<li><a class="twitter" href="http://twitter.com/home?status=Reading:' . esc_url( $post_link ) . '" title="Share this post on Twitter!"><i class="fa fa-twitter"></i></a></li>
				<li><a class="facebook" href="http://www.facebook.com/sharer.php?u=' . esc_url( $post_link ) . '&amp;t=' . $title . '" title="Share this post on Facebook!" onclick="window.open(this.href); return false;"><i class="fa fa-facebook"></i></a></li>
				<li><a class="google" href="https://plus.google.com/share?url=' . esc_url( $post_link ) . '"><i class="fa fa-google-plus"></i></a></li>
				<li><a class="email fa fa-envelope" href="mailto:?subject=' . $title . '&amp;body=' . $excerpt. '%20[' . get_the_permalink() . ']"></a>
				';
			}
			if(get_option('MOM_themetakeover_archivepage') != ''){ echo '<li><a href="'.esc_url(get_permalink(get_option('MOM_themetakeover_archivepage'))).'">All</a></li>'; }
			$counter = 0;
			$max = 1; 
			$taxonomy = 'category';
			$terms = get_terms($taxonomy);
			shuffle($terms);
			if($terms){
				foreach($terms as $term){
					$counter++;
					if($counter <= $max){
					echo '<li><a href="'.get_category_link($term->term_id).'" title="'.sprintf(__("View all posts in %s"), $term->name).'" '.'>Random</a></li>';
					}
				}
			}
			if(function_exists('myoptionalmodules_excludecategories'))myoptionalmodules_excludecategories();
			echo '</ul></div>';
			if(get_option('MOM_themetakeover_extend') == 1){
				echo '<div class="momnavbar_extended'.esc_attr($isTop).'">';
				if($isTop == 'up'){echo '<label for="momnavbarextended"><span class="momnavbar_tab '.esc_attr($scheme).'"><i class="fa fa-chevron-'.esc_attr($isTop).'"></i></span></label>';
				}
				echo '<input id="momnavbarextended" type="checkbox" class="hidden" />
				<div class="momnavbar_extended_inner  '.esc_attr($scheme).'">
				<div class="siteInformation">
					<ul class="momnavbar_pages">';wp_list_pages('title_li&depth=1');echo'</ul>';
					if(is_single()){if(function_exists('obwcountplus_single')){echo '<span>'; obwcountplus_single();echo' words</span>';}}
					if(function_exists('obwcountplus_total')){echo '<span>';obwcountplus_total();echo ' total</span>';}
					$tags = get_tags('number=10&orderby=count');
					$html = '<div class="listalltags">';
					foreach ( $tags as $tag ) {
						$tag_link = get_tag_link( $tag->term_id );
						$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
						$html .= "{$tag->name}</a>";
					}
					$html .= '</div>';
					echo $html;
				echo '</div><div class="recentPostListing">
				<ul>';
					$argsb=array(
						'numberposts'=>12,
						'post_type'=>'post',
						'post_status'=>'publish',
					);					
					$recent_posts = wp_get_recent_posts($argsb);
					foreach( $recent_posts as $recent ){
						echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
					}
				echo '</ul>
				</div>';
				echo '<div class="recentPostListingThumbnails '.esc_attr($scheme).'">';
					$args=array(
						'numberposts'=>25,
						'post_type'=>'post',
						'post_status'=>'publish',
						'meta_key'=>'_thumbnail_id',
					);		
					$recent_posts = wp_get_recent_posts($args);
					foreach( $recent_posts as $recentthumbs ){
						$url = wp_get_attachment_url( get_post_thumbnail_id($recentthumbs["ID"]) );
						echo '<a class="thumbnail" href="' . get_permalink($recentthumbs["ID"]) . '" title="'.esc_attr($recentthumbs["post_title"]).'" ><img class="skipLazy" src="'.$url.'" /></a>';
					}
				echo '</div>
				
				</div>';
				if($isTop == 'down'){echo '<label for="momnavbarextended"><span class="momnavbar_tab '.esc_attr($scheme).'"><i class="fa fa-chevron-'.esc_attr($isTop).'"></i></span></label>';}
				echo '</div>';
			}
		}
		add_action('wp_footer','mom_topbar');
		// http://plugins.svn.wordpress.org/wp-toolbar-removal/trunk/wp-toolbar-removal.php
		remove_action('init','wp_admin_bar_init');
		remove_filter('init','wp_admin_bar_init');
		remove_action('wp_head','wp_admin_bar');
		remove_filter('wp_head','wp_admin_bar');
		remove_action('wp_footer','wp_admin_bar');
		remove_filter('wp_footer','wp_admin_bar');
		remove_action('admin_head','wp_admin_bar');
		remove_filter('admin_head','wp_admin_bar');
		remove_action('admin_footer','wp_admin_bar');
		remove_filter('admin_footer','wp_admin_bar');
		remove_action('wp_head','wp_admin_bar_class');
		remove_filter('wp_head','wp_admin_bar_class');
		remove_action('wp_footer','wp_admin_bar_class');
		remove_filter('wp_footer','wp_admin_bar_class');
		remove_action('admin_head','wp_admin_bar_class');
		remove_filter('admin_head','wp_admin_bar_class');
		remove_action('admin_footer','wp_admin_bar_class');
		remove_filter('admin_footer','wp_admin_bar_class');
		remove_action('wp_head','wp_admin_bar_css');
		remove_filter('wp_head','wp_admin_bar_css');
		remove_action('wp_head','wp_admin_bar_dev_css');
		remove_filter('wp_head','wp_admin_bar_dev_css');
		remove_action('wp_head','wp_admin_bar_rtl_css');
		remove_filter('wp_head','wp_admin_bar_rtl_css');
		remove_action('wp_head','wp_admin_bar_rtl_dev_css');
		remove_filter('wp_head','wp_admin_bar_rtl_dev_css');
		remove_action('admin_head','wp_admin_bar_css');
		remove_filter('admin_head','wp_admin_bar_css');
		remove_action('admin_head','wp_admin_bar_dev_css');
		remove_filter('admin_head','wp_admin_bar_dev_css');
		remove_action('admin_head','wp_admin_bar_rtl_css');
		remove_filter('admin_head','wp_admin_bar_rtl_css');
		remove_action('admin_head','wp_admin_bar_rtl_dev_css');
		remove_filter('admin_head','wp_admin_bar_rtl_dev_css');
		remove_action('wp_footer','wp_admin_bar_js');
		remove_filter('wp_footer','wp_admin_bar_js');
		remove_action('wp_footer','wp_admin_bar_dev_js');
		remove_filter('wp_footer','wp_admin_bar_dev_js');
		remove_action('admin_footer','wp_admin_bar_js');
		remove_filter('admin_footer','wp_admin_bar_js');
		remove_action('admin_footer','wp_admin_bar_dev_js');
		remove_filter('admin_footer','wp_admin_bar_dev_js');
		remove_action('locale','wp_admin_bar_lang');
		remove_filter('locale','wp_admin_bar_lang');
		remove_action('wp_head','wp_admin_bar_render', 1000);
		remove_filter('wp_head','wp_admin_bar_render', 1000);
		remove_action('wp_footer','wp_admin_bar_render', 1000);
		remove_filter('wp_footer','wp_admin_bar_render', 1000);
		remove_action('admin_head','wp_admin_bar_render', 1000);
		remove_filter('admin_head','wp_admin_bar_render', 1000);
		remove_action('admin_footer','wp_admin_bar_render', 1000);
		remove_filter('admin_footer','wp_admin_bar_render', 1000);
		remove_action('admin_footer','wp_admin_bar_render');
		remove_filter('admin_footer','wp_admin_bar_render');
		remove_action('wp_ajax_adminbar_render','wp_admin_bar_ajax_render', 1000);
		remove_filter('wp_ajax_adminbar_render','wp_admin_bar_ajax_render', 1000);
		remove_action('wp_ajax_adminbar_render','wp_admin_bar_ajax_render');
		remove_filter('wp_ajax_adminbar_render','wp_admin_bar_ajax_render');				
	}
}