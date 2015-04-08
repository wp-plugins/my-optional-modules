<?php 
/**
 * CLASS myoptionalmodules_shortcodes()
 *
 * File last update: 9.1.8
 *
 * All shortcodes for My Optional Modules
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_shortcodes{

	function __construct() {
		remove_shortcode ( 'mom_attachments' );
		remove_shortcode ( 'mom_catalog' );
		remove_shortcode ( 'mom_embed' );
		remove_shortcode ( 'mom_hidden' );
		remove_shortcode ( 'mom_charts' );
		add_shortcode    ( 'mom_attachments' , array ( $this , 'attachments' ) );
		add_shortcode    ( 'mom_catalog' , array ( $this , 'catalog' ) );
		add_shortcode    ( 'mom_embed' , array ( $this , 'embed' ) );
		add_shortcode    ( 'mom_hidden' , array ( $this , 'hidden' ) );
		add_shortcode    ( 'mom_charts' , array ( $this , 'charts' ) );
	}
	
	function attachments( $atts ) {

		global $post,$wp;

		$amount           = null;
		$class            = null;
		$all_images       = null;
		$id               = null;
		$parent_id        = null;
		$parent_title     = null;
		$mime_type        = null;
		$attachment       = null;
		$output           = null;
		$parent_permalink = null;

		extract (
			shortcode_atts ( 
				array (
					'amount' => 1,                // numerical value of how many attachments to return			
					'class'  => 'mom_attachment'  // default class for the linked attachments
				), 
				$atts 
			)
		);

		if( $amount ) $amount = intval ( $amount );
		if( $class  ) $class  = sanitize_text_field ( esc_html ( $class ) );

		$all_images = get_posts (
			array (
				'post_type' => 'attachment',
				'numberposts' => $amount,
				'post_mime_type ' => 'image',
			)
		);

		$output .= '<div class="mom_attachments">';

		foreach ( $all_images as $image ) {
			$id               = $image->ID;
			$parent_id        = $image->post_parent;
			$parent_title     = get_the_title ( $parent_id );
			$parent_permalink = get_the_permalink ( $parent_id );
			$mime_type        = get_post_mime_type ( $id );
			$attachment       = wp_get_attachment_url ($id , 'full' );
			if( 
				'image/jpeg' == $mime_type || 
				'image/png' == $mime_type || 
				'image/gif' == $mime_type 
			) {
				$output .= "<a class='{$class}' href='{$parent_permalink}'><img src='{$attachment}'/></a>";
			}
		}

		$output .= '</div>';
		return $output;
		
		$amount           = null;
		$class            = null;
		$all_images       = null;
		$id               = null;
		$parent_id        = null;
		$parent_title     = null;
		$mime_type        = null;
		$attachment       = null;
		$output           = null;
		$parent_permalink = null;

	}
	
	function catalog( $atts, $content ) {
		global $wp , $wpdb , $post;

		$type        = $args           = $posts_array         = 
		$years_sql   = $month_sql      = $year = $month       =
		$month_name  = $link           = $get_categories      = 
		$name        = $title          = $count               = 
		null;
		
		extract (
			shortcode_atts ( 
				array (
					'type'          => '' ,      // 'tags','categories',etc.
					'count_display' => 0 ,       // 1 display counts 0 do not display counts
					'case'          => '' ,      // 'upper','lower','drop'
				)
				, $atts 
			)
		);

		$case          = sanitize_text_field ( strtolower ( $case ) );
		$count_display = intval ( $count_display );
		$type          = sanitize_text_field ( strtolower ( $type ) );

		$output  = '<div class="mom_catalog_display">';

		if ( 'categories' == $type ) {
			$args = array(
				'orderby'           => 'name',
				'order'             => 'ASC',
				'hide_empty'        => 1,
				'hierarchical'      => 1,
				'taxonomy'          => 'category',
				'pad_counts'        => false 
			);
			$get_categories  = get_categories ( $args );

			$output .= '<div class="mom_category_catalog">';
			$output .= '<p>';

			foreach ( $get_categories as $category ) {
				$link = get_category_link ( $category->cat_ID );
				$name = $category->cat_name;
				if ( 'upper' == $case )
					$name = strtoupper ( $name );
				elseif ( 'lower' == $case )
					$name = strtolower ( $name );
				elseif ( 'drop' == $case )
					$name = ucfirst ( $name );
				else
					$name = $name;
				
				if ( $count_display )
					$count = " <strong class='count'>({$category->category_count})</strong>";
				else
					$count = null;

				$title  = sprintf ( __( 'View all posts in %s' ), $name );
				$output.= "<span><a href='{$link}' title='{$title}'>{$name}</a>{$count}</span>";
			}

			$output .= '</p></div>';
		}

		if ( 'tags' == $type ) {
			$args      = 'posts_counts=1';
			$grab_tags = get_tags ( $args );

			$output .= '<div class="mom_tag_catalog">';
			$output .= '<p>';

			foreach ( $grab_tags as $tag ) {
				$tag_link = get_tag_link ( $tag->term_id );

				if( $count_display )
					$count = " <strong class='count'>({$tag->count})</strong>";
				else
					$count = null;

				$name = $tag->name;
				
				if ( 'upper' == $case )
					$name = strtoupper ( $name );
				elseif ( 'lower' == $case )
					$name = strtolower ( $name );
				elseif ( 'drop' == $case )
					$name = ucfirst ( $name );
				else
					$name = $name;
				
				$output .= "<span><a href='{$tag_link}' title='{$name} Tag' class='{$tag->slug}'>";
				$output .= "{$name}</a>{$count}</span>";
			}
			$output .= '</p>';
			$output .= '</div>';
		}

		if ( 'years' == $type ) {
			$output .= '<div class="mom_years_catalog">';

			$years_sql = $wpdb->get_results ( 
				"SELECT DISTINCT *,
				YEAR(post_date) as year 
				FROM $wpdb->posts 
				WHERE post_status = 'publish' 
				GROUP BY year 
				ORDER BY post_date DESC"
			);
			foreach($years_sql as $post ) {
				$year = mysql2date ( 'Y' , $post->post_date );
				$link = esc_urL ( get_year_link ( $year ) );

				$output .= '<p>';
				$output .= "<span><a href='$link'>$year</a></span>";

				$month_sql = $wpdb->get_results ( 
					"SELECT DISTINCT *,
					MONTH(post_date) as month
					FROM $wpdb->posts 
					WHERE post_status = 'publish' 
					AND YEAR(post_date) = '$year' 
					GROUP BY month 
					ORDER BY post_date DESC"
				);
				foreach( $month_sql as $post ) {
					$month       = mysql2date ( 'm' , $post->post_date );
					$month_2date = mysql2date ( 'M' , $year . '-' . $month );
					$link        = esc_url ( get_month_link ( $year , $month ) );

					if ( 'upper' == $case )
						$month_name = strtoupper ( $month_2date );
					elseif ( 'lower' == $case )
						$month_name = strtolower ( $month_2date );
					elseif ( 'drop' == $case )
						$month_name = ucfirst ( $month_2date );
					else
						$month_name = $month_2date;

					$output .= "<span><a href='{$link}'>{$month_name}</a></span>";
				}
				$output .= '</p>';
			}
			$output .= '</div>';
		}

		$output .= '</div>';

		return $output;

	}
	
	function embed( $atts ) {

		$url   = null;
		$class = null;
	
		extract (
			shortcode_atts ( 
				array (
					'url' => '',
					'class' => ''
				), 
				$atts 
			)
		);

		if( $url ) {
			$url = esc_url ( $url );

			if( $class )
				sanitize_text_field ( esc_html ( $class ) );

			ob_start();

			if( $class )
				echo "<div class='{$class}'>";

			new mom_mediaEmbed ( $url );

			if( $class )
				echo '</div>';

			return ob_get_clean();

		}
		
		$url   = null;
		$class = null;

	}	
	
	function hidden( $atts, $content ) {
		global $wp , $post;
		
		extract (
			shortcode_atts ( 
				array (
					'logged'  => 0, // (1) on (0) off // whether or not viewer needs to be logged in to view content
					'single'  => 0  // (1) on (0) off // whether or not content will be hidden on single post view
				)
				, $atts 
			)
		);
		
		$logged = intval ( $logged );
		$single = intval ( $single );
		
		if( is_single() || is_page() )
			$view = 1;
		else
			$view = 0;
		
		if( $logged && !is_user_logged_in() )
			$content = null;
		if( !$single && !$view )
			$content = null;
		if( $single && $view )
			$content = null;

		return do_shortcode ( $content );

	}
	
	function charts ( $atts ) {

		$type = $output = null;
		
		extract (
			shortcode_atts (
				array (
					'type'           => '' ,
					'content'        => '' ,
					'total_possible' => 10 ,
					'overall'        => 0 ,
				)
				, $atts
			)
		);
		
		$type           = sanitize_text_field ( $type );
		$content        = sanitize_text_field ( $content );
		$total_possible = sanitize_text_field ( $total_possible );
		$overall        = intval ( $overall );
		
		
		if ( 'bar' == $type ) {
			$description = $ratings = null;
			$ratings = explode ( '::' , $content );
			if ( $content ) {
				if ( $ratings ) {
					$rate_increase  = $rating_tot = $overall_increase = 0;
					$output .= '<div class="rating">';
					foreach ( $ratings as $rating ) {
						++$rate_increase;
						$invidual_rating = explode ( ':' , $rating );
						$output .= '<div>';
						if ( $invidual_rating ) {
							foreach ( $invidual_rating as $rated ) {
								if ( preg_match_all ('/\((.*?)\)/' , $rated , $match ) ) {
										$description = $match[1];
								}
								$rated       = preg_replace ( "/\([^)]+\)/" , "" , $rated);
								$rating_nom  = preg_replace ( '/[^0-9,.]/' , '' , $rated );
								$rating_tit  = preg_replace ( '/[0-9]+/'   , '' , $rated );
								$percent     = ( $rating_nom / $total_possible * 100 );
								$overall_increase = $overall_increase + $rating_nom;
								$output .= "<em>{$rating_tit}</em>";
								$output .= "<strong>{$rating_nom}</strong>";
								$output .= "<hr style='top:0;left:5px;position:absolute;z-index:0;width:{$percent}%;background-color:rgba(0,0,0,.1);overflow:hidden;height:1px;' />";
								if ( $description ) {
									foreach ( $description as $des ) {
										$des = esc_html ( $des );
										$output .= "<span>{$des}</span>";
									}
								}
								$rating_tot = $rating_tot + $rating_nom;
							}
						}
						$output .= '</div>';
					}
					if ( $overall ) {
						$total_available = $rate_increase * $total_possible;
						$percent         = ( $overall_increase / $total_available * 100 );
						$output .= '<div>';
						$output .= "<em>Overall</em>";
						$output .= "<strong>{$overall_increase} / {$total_available}</strong>";
						$output .= "<hr style='top:0;left:5px;position:absolute;z-index:0;width:{$percent}%;background-color:rgba(0,0,0,.1);overflow:hidden;height:1px;' />";
						$output .= '</div>';
					}
					$output      .= '</div>';
				}
			}
		}
		
		return $output;
		
		
	}		
	
}
$myoptionalmodules_shortcodes = new myoptionalmodules_shortcodes();