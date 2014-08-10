<?php 

/**
 *
 * Shortcodes
 *
 * Various shortcode functions used by different modules
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
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

/**
 *
 * Output a list of posts with more than 1 upvote
 *
 * [topvoted]
 * amount : number of posts to output
 *
 */
if( !function_exists( 'vote_the_posts_top' ) ) {

	function vote_the_posts_top( $atts, $content = null ) {

		global $wpdb,$wp,$post;

		extract(

			shortcode_atts( array (

				'amount' => 10

			), $atts )

		);

		$amount = intval( $amount );

		ob_start();
		wp_reset_query();

		$votesPosts = $wpdb->prefix . 'momvotes_posts';
		$query_sql  = $wpdb->get_results( "SELECT ID,UP from $votesPosts  WHERE UP > 1 ORDER BY UP DESC LIMIT $amount" );

		if( count( $query_sql ) ) {

			echo '<ul class="topVotes">';
				
			foreach ( $query_sql as $post_id ) {

				$votes = intval( $post_id->UP );
				$id    = intval( $post_id->ID );
				$link  = get_permalink( $id );
				$title = get_the_title( $id );
				
				echo '<li><a href="' . $link . '" rel="bookmark" title="Permanent Link to ' . $title . '">' . $title . ' &mdash; ( ' . $votes . ' )</a></li>';

			}

			echo '</ul>';

		}
		
		wp_reset_query();
		
		return ob_get_clean();

	}

}


if( !function_exists( 'mom_reviews_shortcode' ) ) {

	function mom_reviews_shortcode($atts, $content = null){

		global $mom_review_global, $wpdb;
		$mom_review_global++;

		ob_start();

		extract(

			shortcode_atts( array (

				'type'	  => '',
				'orderby' => 'ID',
				'order'   => 'ASC',
				'meta'    => 1,
				'expand'  => '+',
				'retract' => '-',
				'id'      => '',
				'open'    => 0

			), $atts )

		);	

		if( $id ) {

			$id_fetch_att = esc_sql( $id );

		} else {

			$id_fetch     = '';
			$id_fetch_att = '';

		}

		if( is_numeric( $id_fetch_att ) ) {

			$id_fetch = $id_fetch_att;

		}
		
		$order_by               = esc_sql( $orderby );
		$order_dir              = esc_sql( $order );
		$result_type            = sanitize_text_field( $type );
		$meta_show              = sanitize_text_field( $meta );
		$expand_this            = sanitize_text_field( $expand );
		$retract_this           = sanitize_text_field( $retract );
		$is_open                = sanitize_text_field( $open );
		$mom_reviews_table_name = $wpdb->prefix . 'momreviews';

		if( '' != $id_fetch ) {

			$reviews = $wpdb->get_results( "SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE ID IN ($id_fetch) ORDER BY $order_by $order_dir" );

		} else {

			if( '' != $result_type ) {

				$reviews = $wpdb->get_results( "SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE IN ($result_type) ORDER BY $order_by $order_dir" );

			} else {

				$reviews = $wpdb->get_results( "SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY $order_by $order_dir" );

			}

		}

		if( count( $reviews ) ) {

			foreach( $reviews as $reviews_results ) {

				if( '.5'  == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if( '1'   == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if( '1.5' == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if( '2'   == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if( '2.5' == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if( '3'   == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if( '3.5' == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>';
				if( '4'   == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>';
				if( '4.5' == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>';
				if( '5'   == $reviews_results->RATING ) $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
				
				if( '' != $reviews_results->REVIEW ) { 

					$this_ID = $reviews_results->ID; echo '<div '; if( '' != $result_type ) { echo 'id="' . sanitize_text_field($result_type) . '"'; }echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="'.$this_ID.''.$mom_review_global.'" ';if($is_open == 1){echo ' checked';}echo '/><label for="'.$this_ID.''.$mom_review_global.'">';if($reviews_results->TITLE != ''){echo $reviews_results->TITLE;}echo '<span>'.$expand_this.'</span><span>'.$retract_this.'</span></label><section class="reviewed">';if($meta_show == 1){if($reviews_results->TYPE != ''){echo ' [ <em>'.$reviews_results->TYPE.'</em> ] ';}if($reviews_results->LINK != ''){echo ' [ <a href="'.esc_url($reviews_results->LINK).'">#</a> ] ';}}echo '<hr />'.$reviews_results->REVIEW;if($reviews_results->RATING != ''){echo ' <p>'.$reviews_results->RATING.'</p> ';}echo '</section></article></div>';

				}

				elseif( '' == $reviews_results->REVIEW ) { $this_ID = $reviews_results->ID; echo '<div '; if( '' != $result_type ) { echo 'id="' . sanitize_text_field( $result_type ) . '"'; } echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="' . $this_ID . '' . $mom_review_global.'" '; if( 1 == $is_open ) { echo ' checked'; } echo '/><label>'; if( '' != $reviews_results->TITLE ) { if( '' != $reviews_results->LINK ) { echo '<a href="' . esc_url( $reviews_results->LINK ) . '">'; } echo $reviews_results->TITLE; if( '' != $reviews_results->LINK ) { echo '</a>'; } } echo '<span>' . $reviews_results->RATING . '</span><span></span></label></article></div>'; }

			}

		}

		return ob_get_clean();

	}

}

/**
 *
 * Font Awesome shortcode
 * allows quick embedding of Font Awesome icons by using the following template:
 * [font-fa i="ICON"] where ICON is the name of an icon
 * For instance: RSS icon would be [font-fa i="rss"]
 * Full list of icons: //fortawesome.github.io/Font-Awesome/icons/
 * Appropriate icon names are sans the fa- (fa-child would simply be child, fa-empire would simply be empire, etc..)
 *
 */
if( !function_exists( 'font_fa_shortcode' ) ) {

	function font_fa_shortcode( $atts, $content = null ) {

		extract(

			shortcode_atts( array (

				"i" => ''

			), $atts )

		);

		$icon = esc_attr( $i );

		if( '' != $icon ) {

			$iconfinal = $icon;

		}

		ob_start();

		return '<i class="fa fa-' . $iconfinal . '"></i>';

		return ob_get_clean();

	}

}

/**
 *
 * Output a list of posts that were written on this day from previous years.
 * If no posts are found, a random assortment of 5 posts will be presented 
 * that is then re-randomized on each subsequent page refresh.
 *
 * [mom_onthisday] 
 *
 */
if( !function_exists( 'mom_onthisday' ) ) {

	function mom_onthisday( $atts, $content = null ) {

		extract(

			shortcode_atts( array(

				'amount' => '-1',
				'title'  => 'On this day',
				'cat'    => ''

			), $atts )

		);

		global $post;
		$postid = $post->ID;

		if( $cat == 'current' ) {

			$category_current = get_the_category( $postid );
			$category         = $category_current[0]->cat_ID;

		} else {

			$category = esc_attr( $cat );

		}

		$onthisday     = esc_attr( $title );
		$postid        = get_the_ID();
		$current_day   = date( 'd' );
		$current_month = date( 'm' );
		$postsperpage  = intval( $amount );

		query_posts( "cat=$category&monthnum=$current_month&day=$current_day&post_per_page=$postsperpage" );

		ob_start();

		$posts = 0;

		while( have_posts() ):the_post();

		$postid = get_the_id();
		$link   = get_the_permalink( $postid);
		$title  = get_the_title( $postid );
		$year   = get_the_date('Y');

		$posts++;

		if( $posts == 1 ) {

			echo '<div id="mom_onthisday"><span class="onthisday">on this day</span>';

		}

		if( $posts > 0 ) {

			echo '<section class="mom_onthisday"><div class="mom_onthisday"><a href="' . $link . '"><span class="title">' . $title . '</span><span class="theyear">' . $year . '</span></a></div></section>';

		}

		endwhile;

		if( $posts == 0 ) {

			$posts++;

			if( $posts == 1 ) { 

				echo '<div id="mom_onthisday"><span class="onthisday">5 random posts</span>';

			}

			query_posts( "orderby=rand&post_per_page=5&ignore_sticky_posts=1" );

			while( have_posts() ):the_post();

			$postid = get_the_id();
			$link   = get_the_permalink( $postid );
			$title  = get_the_title( $postid );
			$year   = get_the_date( 'Y' );

			echo '<section class="mom_onthisday"><a href="' . $link . '"><div class="mom_onthisday"><span class="title">' . $title . '</span><span class="theyear">' . $year . '</span></div></a></section>';
			endwhile;

		}

		echo '</div>';

		wp_reset_query();

		return ob_get_clean();
	}
	
}

/**
 *
 * Google Map embedding
 * [mom_map] 
 * address : can be GPS coordinates or a physical street address
 *
 */
if( !function_exists( 'mom_google_map_shortcode' ) ) {

	function mom_google_map_shortcode( $atts, $content = null ) {

		extract(

			shortcode_atts( array (

				'width'       => '100%',
				'height'      => '350px',
				'frameborder' => '0',
				'align'       => 'center',
				'address'     => '',
				'info_window' => 'A',
				'zoom'        => '14',
				'companycode' => ''

			), $atts )

		);

		ob_start();

		$address      = urlencode( $address );
		$companycode  = urlencode( $companycode );
		$align        = sanitize_text_field( $align );
		$width        = sanitize_text_field( $width );
		$height       = sanitize_text_field( $height );
		$zoom         = sanitize_text_field( $zoom );
		$info_window  = sanitize_text_field( $info_window );

		$mgms_output = 'q=' . $address . '&amp;cid=' . $companycode;

		$mgms_output  = htmlentities( $mgms_output );		

		$map = '<div class="mom_map"><iframe align="' . $align . '" width="' . $width . '" height="' . $height . '" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;' . $mgms_output . '&amp;output=embed&amp;z=' . $zoom . '&amp;iwloc=' . $info_window . '&amp;visual_refresh=true"></iframe></div>';

		return $map . ob_get_clean();

	}
	
}

/**
 *
 * Reddit shortcode 
 * [mom_reddit] inserts a button into the post to submit the post to Reddit
 * target    : Can specify a specific subreddit to default the button send-to
 * title     : Title of the post being submitted (defaults to post title)
 * bgcolor   : Background-color of the button
 * border    : Border color of the button
 *
 */
if( !function_exists( 'mom_reddit_shortcode' ) ) {

	function mom_reddit_shortcode( $atts, $content = null ) {

		global $wpdb, $id, $post_title;

		$id            = intval( $id );
		$get_permalink = get_permalink( $id );

		$query = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND ID = $id";

		$reddit = $wpdb->get_results( $query );

		if( $reddit ) {

			foreach( $reddit as $reddit_info ) {

				$post_title = strip_tags( $reddit_info->post_title );

			}

			extract(

				shortcode_atts( array (

					'url'     => '' . $get_permalink . '',
					'target'  => '',
					'title'   => '' . $post_title . '',
					'bgcolor' => '',
					'border'  => ''

				), $atts )

			);

			$url     = sanitize_text_field( $url );
			$target  = sanitize_text_field( $target );
			$title   = sanitize_text_field( $title );
			$bgcolor = sanitize_text_field( $bgcolor );
			$border  = sanitize_text_field( $border );

			ob_start();
			$object = '
			<div class="mom_reddit">
			<script type="text/javascript">
				reddit_url = "' . $url . '";
				reddit_target = "' . $target . '";
				reddit_title = "' . $title . '";
				reddit_bgcolor = "' . $bgcolor . '";
				reddit_bordercolor = "' . $border . '";
			</script>
			<script type="text/javascript" src="http://www.reddit.com/static/button/button3.js"></script>
			</div>';

			return $object . ob_get_clean();

		}

	}
	
}

/**
 *
 * Restrict content inside of shortcode to users who are logged in or 
 * restrict commenting to users who are logged in
 *
 * [mom_restrict] at the top of a post
 * comments / 1 or 2 ( 1 for comments form, 2 for both comments and form off )
 *
 */
if( !function_exists( 'mom_restrict_shortcode' ) ) {

	function mom_restrict_shortcode( $atts, $content = null ) {

		extract(

			shortcode_atts( array (

				'message'  => 'You must be logged in to view this content.',
				'comments' => '',
				'form'     => ''

			), $atts )

		);

		$message = htmlentities( $message );
		
		ob_start();
		
		if( is_user_logged_in() ) {

			return $content;
			
		} else {

			echo '<div class="mom_restrict">' . $message . '</div>';

			if( 1 == $comments ) {

				add_filter( 'comments_template', 'restricted_comments_view' );
				function restricted_comments_view( $comment_template ) {

					return dirname( __FILE__ ) . '/includes/templates/comments.php';

				}

			}

			if( 2 == $comments ){

				add_filter( 'comments_open', 'restricted_comments_form', 10, 2 );
				function restricted_comments_form( $open, $post_id ) {

					$post = get_post($post_id);
					$open = false;
					return $open;

				}

			}

		}

		return ob_get_clean();

	}

}

/**
 *
 * Progress bars
 * [mom_progressbar]
 * 
 * align     : left,right,none
 * fillcolor : #COLOR
 * maincolor : #COLOR
 * height    : number of pixels high
 * fontsize  : number
 * level     : fill amount ( 10 = 10%, 20 = 20%, 30 = 30%, .. )
 * margin    : margin for container ( default: 0 auto )
 * talign    : talign ( default: center )
 * width     : number (default: 95 (translates to 95% ) )
 * 
 */
if( !function_exists( 'mom_progress_shortcode' ) ) {

	function mom_progress_shortcode($atts,$content = null){

		extract(

			shortcode_atts( array(

				'align'     => 'none',
				'fillcolor' => '#ccc',
				'maincolor' => '#000',
				'height'    => 15,
				'fontsize'  => 15,
				'level'     => '',
				'margin'    => '0 auto',
				'talign'    => 'center',
				'width'     => 95

			), $atts )

		);

		$align_fetch     = sanitize_text_field( $align );
		$fillcolor_fetch = sanitize_text_field( $fillcolor );
		$height_fetch    = sanitize_text_field( $height );
		$level_fetch     = sanitize_text_field( $level );
		$maincolor_fetch = sanitize_text_field( $maincolor );
		$margin_fetch    = sanitize_text_field( $margin );
		$width_fetch     = sanitize_text_field( $width );

		ob_start();

		if( 'left' == $align_fetch ) { 

			$align_fetch_final = 'float: left';

		} elseif ( 'right' == $align_fetch ) { 

			$align_fetch_final = 'float: right';

		} else {

			$align_fetch_final = 'clear: both';

		}

		$bar = '<div class="mom_progress" style="' . $align_fetch_final . ';height:' . $height_fetch . 'px;display:block;width:' . $width_fetch . '%;margin:' . $margin_fetch . ';background-color:' . $maincolor_fetch . '"><div style="display:block;height:' . $height_fetch . 'px;width:' . $level_fetch . '%;background-color:' . $fillcolor_fetch . ';"></div></div>';

		return $bar . ob_get_clean();

	}

}