<?php 

/**
 * My Optional Modules Functions
 *
 * (1) Functions used throughout the plugin.
 *
 * @package regular_board
 */	

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}



function mom_get_all_category_ids() {
	if ( ! $cat_ids = wp_cache_get( 'all_category_ids', 'category' ) ) {
		$cat_ids = get_terms( 'category', array('fields' => 'ids', 'get' => 'all') );
		wp_cache_add( 'all_category_ids', $cat_ids, 'category' );
	}
	return $cat_ids;
}

// (1) Calculate time between (date) and (date)
if( !function_exists( 'mom_timesince' ) ) {

	function mom_timesince( $date, $granularity=2 ) {

		$retval     = '';
		$date       = strtotime( $date );
		$difference = time() - $date;
		
		$periods = array(

			' decades' => 315360000, 
			' years' => 31536000, 
			' months' => 2628000, 
			' weeks' => 604800,  
			' days' => 86400, 
			' hours' => 3600, 
			' minutes' => 60, 
			' seconds' => 1 

		);

		foreach( $periods as $key => $value ) {

			if( $difference >= $value ) {

				$time = floor ( $difference/$value );
				$difference %= $value;
				$retval .= ( $retval ? ' ' : '' ) . $time . '';
				$retval .= ( ( $time > 1 ) ? $key : $key );
				$granularity--;

			}

			if( $granularity == '0' ) {

				break; 

			}

		}

		return $retval . ' ago';

	}	
}



/**
*
* No Comments
* Disable comments display and form
*
*/
if( get_option('mommaincontrol_comments') == 1){

add_filter( 'comments_template','mom_disablecomments' );
add_filter( 'comments_open','mom_disablecommentsform',10,2 );

if( !function_exists( 'mom_disablecomments' ) ) {

	function mom_disablecomments( $comment_template ) {

		return dirname( __FILE__ ) . '/includes/templates/comments.php';

	}

}

if( !function_exists( 'mom_disablecommentsform' ) ) {

	function mom_disablecommentsform( $open,$post_id ) {

		$post = get_post( $post_id );
		$open = false;
		return $open;

	}

}

}

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




/**
*
* Admin Stylesheet
* Only enqueue it if we're browsing the admin page for My Optional Modules
*
*/
if( !function_exists( 'my_optional_modules_stylesheets' ) ) {

function my_optional_modules_stylesheets( $hook ){

	if( 'settings_page_mommaincontrol' != $hook )
	return;
	wp_register_style( 'mom_admin_css', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/adminstyle/css.css' );
	wp_register_style( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'font_awesome' );
	wp_enqueue_style( 'mom_admin_css' );

}

}

/**
*
* Font Awesome CSS enqueue
*
*/
if( !function_exists( 'my_optional_modules_font_awesome' ) ) {

function my_optional_modules_font_awesome() {

	wp_register_style( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'font_awesome' );

}

}

/**
*
* My Optional Modules stylesheet used throughout for the different modules
*
*/
if( !function_exists( 'my_optional_modules_main_stylesheet' ) ) {

function my_optional_modules_main_stylesheet() {

	$myStyleFile = WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules05568.css';
	wp_register_style( 'my_optional_modules', $myStyleFile );
	wp_enqueue_style( 'my_optional_modules' );

}

}

// http://davidwalsh.name/wordpress-ajax-comments
function mom_ajaxComment($comment_ID, $comment_status) {
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		$comment = get_comment($comment_ID);
		wp_notify_postauthor($comment_ID, $comment->comment_type);
		$commentContent = getCommentHTML($comment);
		die($commentContent);
	}
}	

// RSS feed (link back)
if( !function_exists( 'myoptionalmodules_rsslinkback' ) ) { 
	function myoptionalmodules_rsslinkback($content){
		global $post;
			return $content.'<p><a href="'.esc_url(get_permalink($post->ID)).'">'.htmlentities(get_post_field('post_title',$post->ID)).'</a> via <a href="'.esc_url(home_url('/')).'">'.get_bloginfo('site_name').'</a></p>';
	}
}

// JS to Footer (moves javascript to footer)
if( !function_exists( 'myoptionalmodules_footerscripts' ) ) {
	function myoptionalmodules_footerscripts(){
		remove_action( 'wp_head','wp_print_scripts' );
		remove_action( 'wp_head','wp_print_head_scripts',9 );
		remove_action( 'wp_head','wp_enqueue_scripts',1 );
	}
}

// Disable Authors (archives)(if there is only 1 author on the blog)
if( !function_exists( 'myoptionalmodules_disableauthorarchives' ) ) {
	function myoptionalmodules_disableauthorarchives(){
		global $wp_query;
		if( is_author() ) {
			if( sizeof( get_users( 'who=authors' ) ) ===1 )
			wp_redirect( get_bloginfo( 'url' ) );
		}
	}
}

// Disable Date (based archives)
if( !function_exists( 'myoptionalmodules_disabledatearchives' ) ) {
	function myoptionalmodules_disabledatearchives(){
		global $wp_query;
		if( is_date() || is_year() || is_month() || is_day() || is_time() || is_new_day() ) {
			$homeURL = esc_url( home_url( '/' ) );
			if( have_posts() ):the_post();
			header( 'location:' . $homeURL );
			exit;
			endif;
		}
	}
}

if( !function_exists( 'myoptionalmodules_excludecategories' ) ) {
	function myoptionalmodules_excludecategories(){
		global $user_level,$mommodule_exclude;
		if( $mommodule_exclude == 1 ) {
			
			$MOM_Exclude_level0Categories  = get_option( 'MOM_Exclude_Categories_level0Categories' ); 
			$MOM_Exclude_level1Categories  = get_option( 'MOM_Exclude_Categories_level1Categories' ); 
			$MOM_Exclude_level2Categories  = get_option( 'MOM_Exclude_Categories_level2Categories' ); 
			$MOM_Exclude_level7Categories  = get_option( 'MOM_Exclude_Categories_level7Categories' ); 
			$loggedOutCats                 = 0;
			
			if( '' == $MOM_Exclude_level0Categories ) $MOM_Exclude_level0Categories = 0;
			if( '' == $MOM_Exclude_level1Categories ) $MOM_Exclude_level1Categories = 0;
			if( '' == $MOM_Exclude_level2Categories ) $MOM_Exclude_level2Categories = 0;
			if( '' == $MOM_Exclude_level7Categories ) $MOM_Exclude_level7Categories = 0;

			if( $user_level == 0 ) $loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			if( $user_level == 1 ) $loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			if( $user_level == 2 ) $loggedOutCats = $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			if( $user_level == 7 ) $loggedOutCats = $MOM_Exclude_level7Categories;
			
			$c1 = explode(',',$loggedOutCats);
			foreach($c1 as &$C1){$C1 = ''.$C1.',';}
			$c_1 = rtrim(implode($c1),',');
			$c11 = explode(',',str_replace(' ','',$c_1));
			$c11array = array($c11);
			$loggedOutCats = array_filter($c11);
		}
		$category_ids = mom_get_all_category_ids();
		foreach( $category_ids as $cat_id ) {
			if( $loggedOutCats ) {
				if( in_array( $cat_id, $loggedOutCats ) )continue;
			}
			$cat = get_category( $cat_id );
			$link = get_category_link( $cat_id );
			echo '<li><a href="' . $link . '" title="link to ' . $cat->name . '">' . $cat->name . '</a></li>';
		}
	}
}

if( !function_exists( 'myoptionalmodules_postasfront' ) ) {
	function myoptionalmodules_postasfront(){	
		if( is_home() ) {
			if( get_option('mompaf_post' ) == 'off' ) {
				// Do nothing
			} elseif( is_numeric( get_option( 'mompaf_post' ) ) ) {
				$mompaf_front = get_option( 'mompaf_post' );
			} elseif( get_option( 'mompaf_post' ) == 'on' ) {
				$mompaf_front = '';
			}
			if( have_posts() ):the_post();
			header('location:' . esc_url( get_permalink( $mompaf_front) ) ); exit; endif;
		}
	}
}

if( !function_exists( 'myoptionalmodules_removeversion' ) ) {
	function myoptionalmodules_removeversion($src){
		if( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) { 
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}
}

if( !function_exists( 'myoptionalmodules_scripts' ) ) {
	function myoptionalmodules_scripts(){
		wp_register_style( 'font_awesome', plugins_url() . '/' . plugin_basename( dirname( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'font_awesome' );
	}
}

if( !function_exists( 'myoptionalmodules_postformats' ) ) {
	function myoptionalmodules_postformats(){
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	}
}