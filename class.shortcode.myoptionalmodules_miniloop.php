<?php 

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}

class myoptionalmodules_miniloop_shortcode{

	function construct() {
		add_shortcode( 'mom_miniloop', array( $this, 'shortcode' ) );
	}
	
	function shortcode( $atts ) {
		global $paged, $post;
		
		$thumbs         = null;
		$show_link      = null;
		$amount         = null;
		$downsize       = null;
		$offset         = null;
		$paging         = null;
		$year           = null;
		$month          = null;
		$day            = null;
		$link_content   = null;
		$style          = null;
		$category       = null;
		$category_name  = null;
		$category_id    = null;
		$orderby        = null;
		$order          = null;
		$post_status    = null;
		$cache_results  = null;
		$meta           = null;
		$key            = null;
		$title          = null;
		$exclude_cats   = null;
		$post_counter   = 0;
		$category_count = 0;
		$alt            = 0;
		$recent_count   = 0;
		$maxposts       = get_option( 'posts_per_page' );
		$series         = get_post_meta($post->ID, 'series', true);

		extract(
			shortcode_atts( 
				array(
					'thumbs'        => 1,           // 1(yes) 0(no)
					'show_link'     => 1,           // 1(yes) 0(no)
					'amount'        => 4,           // numerical value of how many posts to return in the loop
					'downsize'      => 1,           // 1(yes) 0(no) (downsize thumbnails image quality and size)
					'offset'        => 0,           // how many posts to offset 
					'paging'        => 0,           // Whether or not to page the results
					'year'          => null,        // numerical date (year) (ex: 2014,2013,2012,2011..)
					'month'         => null,        // numerical date (month) (ex: 1,2,3,4,5,6,7,8,9,10,11,12)
					'day'           => null,        // numerical date (day) (ex: 1,2,3,4,5,6,7,8,9,10,11,...)
					'exclude'       => null,        // post IDs to exclude
					'link_content'  => null,        // alpha-numeric value for post content (defaults to post title) (ex: "Click me")
					'category'      => null,        // numerical ID(s) or category name(s) (multiple separated by commas) (do not mix the two)
					'key'           => null,        // Post with THIS meta key VALUE
					'cache_results' => false,       // true or false
					'style'         => 'tiled',     // columns,slider,tiled,list
					'orderby'       => 'post_date', // none,ID,author,title,name,type,date,modified,parent,rand
					'order'         => 'DESC',      // DESC(descending) or ASC(ascending)
					'post_status'   => 'publish',   // publish,pending,draft,auto-draft,future,private,inherit,trash,any
					'meta'          => 'series'     // Posts with THIS meta key
				), $atts 
			)
		);

		$thumbs        = sanitize_text_field( $thumbs );
		$show_link     = sanitize_text_field( $show_link );
		$amount        = sanitize_text_field( $amount );
		$downsize      = sanitize_text_field( $downsize );
		$offset        = sanitize_text_field( $offset );
		$paging        = sanitize_text_field( $paging );
		$year          = sanitize_text_field( $year );
		$month         = sanitize_text_field( $month );
		$day           = sanitize_text_field( $day );
		$exclude       = sanitize_text_field( $exclude );
		$link_content  = sanitize_text_field( $link_content );
		$category      = sanitize_text_field( $category );
		$orderby       = sanitize_text_field( $orderby );
		$order         = sanitize_text_field( $order );
		$post_status   = sanitize_text_field( $post_status );
		$cache_results = sanitize_text_field( $cache_results );
		$meta          = sanitize_text_field( $meta );
		$key           = sanitize_text_field( $key );
		$style         = strtolower( sanitize_text_field( $style ) );
		
		if( 123 == $year ) { 
			$year = date( 'Y' );
		}
		if( 123 == $month ) { 
			$month = date( 'n' );
		}
		if( 123 == $day ) { 
			$day = date( 'j' );
		}
		if( $meta == strtolower( 'series' ) ) {
			$key     = $series;
			$amount  = -1;
			$exclude = $post->ID;
		}
		if( intval( $category ) ) {
			$category_id   = $category;
		} else {
			$category_name = $category;
		}
		
		$open = '<div class="loopdeloopRotation loopdeloop_' . $style .'">';

		if( $paging ) {
			$paged = (get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
		}

		if( $key ) {
			$args = array(
				'post__not_in'     => array( $exclude ),
				'posts_per_page'   => $amount,
				'offset'           => $offset,
				'category'         => $category_id,
				'category_name'    => $category_name,
				'orderby'          => $orderby,
				'order'            => $order,
				'post_type'        => 'post',
				'post_status'      => $post_status,
				'suppress_filters' => true,
				'cache_results'    => $cache_results,
				'year'             => $year,
				'monthnum'         => $month,
				'day'              => $day,
				'paged'            => $paged,
				'meta_query'       => array(
					array( 
						'key'     => $meta,
						'value'   => array( $key ),
						'compare' => 'IN',
					)
				)
			);
		} else {
			$args = array(
			'post__not_in'     => array( $exclude ),
			'posts_per_page'   => $amount,
			'offset'           => $offset,
			'category'         => $category_id,
			'category_name'    => $category_name,
			'orderby'          => $orderby,
			'order'            => $order,
			'post_type'        => 'post',
			'post_status'      => $post_status,
			'suppress_filters' => true,
			'cache_results'    => $cache_results,
			'year'             => $year,
			'monthnum'         => $month,
			'day'              => $day,
			'paged'            => $paged,
			'meta_key'         => $meta
			);
		}
		$myposts = get_posts( $args );
			
		foreach( $myposts as $post ) {
			++$post_counter;
		}
		
		if( 0 < $post_counter ) {
			if( $style == 'slider') {
				$open .= '<div class="loopdeloop_slideContainer inner"><div class="inner"><style>.loopdeloopRotation .inner { width:' . $post_counter * 500 . 'px; }</style>';
			} else {
				$open .= '<div class="loopdeloop_' . $style . '"><div>';
			}			

			query_posts( $args );
			ob_start();

			if( have_posts() ): while( have_posts() ) : the_post();

			$id            = get_the_ID();
			$link_text     = null;
			$link          = esc_url( get_permalink( $id ) );
			$title         = get_the_title( $id );
			$date          = get_the_date();
			$comment_count = get_comments_number();
			$author        = get_the_author();
			$categories    = get_the_category( $id );

			if( !$link_content ) {
				$link_text_text = get_the_title( $id );
			} else {
				$link_text_text = $link_content;
			}
			if( $show_link == 1 ) {
				$link_text = '<a class="mediaNotPresent" href="' . get_permalink( $id ) . '">' . $link_text_text . '</a>';
			}

			++$recent_count;

			$media = get_post_meta( $id, 'media', true );
			$thumb_path = null;
			if( wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
				$post_thumbnail_id = get_post_thumbnail_id( $id );
				if( $downsize == 1 ) {
					$thumb_array = image_downsize( $post_thumbnail_id, 'thumbnail' );
					$thumb_path = $thumb_array[0];	
				} else {
					$thumb_path = wp_get_attachment_url( get_post_thumbnail_id( $id ) );
				}
			}
				
			if( $style == 'list' ) {
				echo '<section class="post element"><div class="counter">' . $recent_count . '</div>';
				if( $thumb_path ) {
					echo '<div class="thumb"><img src="' . $thumb_path . '" /></div>';
				}
				echo '<div class="text"><span class="title"><a href="' . $link . '">' . $title . '</a></span>';
				echo '<span class="meta">' . the_excerpt() . '</span>';
				echo '</div>
				</section>';
			}
			if( $style == 'columns' ) {
				echo '<div class="column element"><div class="inner"';
				if( $thumb_path ) {
					echo ' style="background-image:url(\'' . $thumb_path . '\' );"';
				}
				echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a><span class="link">' . $link_text . '<em><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a></em></span></div>';
				echo '</div>';
			}
			if( $style == 'slider' ) {
					echo '<div class="slide"';
					if( $thumb_path ) {
						echo ' style="background-image:url(\'' . $thumb_path . '\' );"';
				}			
				echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"><span class="title">'. $link_text_text . '</span></a></div>';
			}
			if( $style == 'tiled' ) {
					if( $recent_count == 1 ) {
					$container = 'feature';
					echo '<div class="feature">';
					}
				if( $recent_count == 2 ) {
					$container = 'second';
					echo '<div class="' . $container . '">';
				}
				if( $recent_count == 3 ) {
					$container = 'secondThird';
					echo '<div class="' . $container . '">';
				}
				if( $recent_count <= 4 ) {
					echo '<div class="thumbnailFull';
				}
				if( $recent_count == 2 ) {
					echo ' leftSmall';
				}
				if( $recent_count <= 4 ) {
					echo '"';
					if( $thumb_path ) {
						echo ' style="background-image:url(\'' . $thumb_path . '\' );"';
					}
					echo '>';
					echo $link_text;
				}
				echo '</div>';
				if( $recent_count > 4 ) {
					if( $recent_count % 3 == 0 ) {
						$container = 'second leftSmall';
					} else {
						$container = 'secondThird';
					}
					echo '<div class="' . $container . '"><div class="thumbnailFull"';
					if( wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
						$post_thumbnail_id = get_post_thumbnail_id( $id );
						if( $downsize ) {
							$thumb_array = image_downsize( $post_thumbnail_id, 'thumbnail' );
							$thumb_path = $thumb_array[0];	
						} else {
							$thumb_path = wp_get_attachment_url( get_post_thumbnail_id( $id ) );
						}
						echo ' style="background-image:url(\'' . $thumb_path . '\' );"';
					}
					echo '>';
					echo $link_text . '</div>';
				}
				if( $recent_count == 4 ) {
					echo '</div></div>';
				}
			}

			endwhile;
			if( $paging ) {
				echo '<div class="loopdeloopNavigation">'; posts_nav_link( '&#8734;','Previous','Next' ); echo '</div>';
			}
			else;
			endif;
			
			$close = '</div></div></div>';
				
			wp_reset_query();
				
			return $open . ob_get_clean() . $close;

		}

		$open           = null;
		$close          = null;
		$thumbs         = null;
		$show_link      = null;
		$amount         = null;
		$downsize       = null;
		$offset         = null;
		$paging         = null;
		$year           = null;
		$month          = null;
		$day            = null;
		$link_content   = null;
		$style          = null;
		$category       = null;
		$category_name  = null;
		$category_id    = null;
		$orderby        = null;
		$order          = null;
		$post_status    = null;
		$cache_results  = null;
		$meta           = null;
		$key            = null;
		$title          = null;
		$maxposts       = null;
		$category_count = null;
		$alt            = null;
		$recent_count   = null;
		$exclude_cats   = null;
		$series         = null;
		$year           = null;
		$month          = null;
		$day            = null;
		$post_counter   = null;
	}

}