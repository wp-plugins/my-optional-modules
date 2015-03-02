<?php 

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}

if( !function_exists( 'mom_miniloop_shortcode' ) ) { 
	function mom_miniloop_shortcode( $atts ) {
		/**
		 * Grab the current user's level set previously in the main plugin 
		 * for use in this shortcode(where necessary and called for)
		 */
		global $paged, $post;
		$thumbs        = null;
		$show_link     = null;
		$amount        = null;
		$downsize      = null;
		$offset        = null;
		$paging        = null;
		$related       = null;
		$year          = null;
		$month         = null;
		$day           = null;
		$link_content  = null;
		$style         = null;
		$category      = null;
		$orderby       = null;
		$order         = null;
		$post_status   = null;
		$cache_results = null;
		$meta          = null;
		$key           = null;
		$title         = null;
		
		/**
		 * Set up some default values that we can override later
		 */
		$maxposts       = get_option( 'posts_per_page' );
		$category_count = 0;
		$alt            = 0;
		$recent_count   = 0;
		$exclude_cats   = null;
		$related_class  = ' element';
		$series         = get_post_meta($post->ID, 'series', true);
		/**
		 * Shortcode attributes(to be set inside of the shortcode)
		 * [thumbs="1" show_link="1" amount="4" downsize="1"...]
		 * These attributes will be used as the default settings, which can be overridden by 
		 * attributes set inside of the shortcode.
		 */
		extract(
			shortcode_atts( array(
				'thumbs'        => 1,					// 1(yes) 0(no)	
				'show_link'     => 1,					// 1(yes) 0(no)
				'amount'        => 4,					// numerical value of how many posts to return in the loop
				'downsize'      => 1,					// 1(yes) 0(no) (downsize thumbnails image quality and size)
				'offset'        => 0,					// how many posts to offset 
				'paging'        => 0,					// Whether or not to page the results
				'related'       => 0,
				'year'          => null,				// numerical date (year) (ex: 2014,2013,2012,2011..)
				'month'         => null,				// numerical date (month) (ex: 1,2,3,4,5,6,7,8,9,10,11,12)
				'day'           => null,				// numerical date (day) (ex: 1,2,3,4,5,6,7,8,9,10,11,...)
				'exclude'       => null,                // post IDs to exclude
				'link_content'  => null,				// alpha-numeric value for post content (defaults to post title) (ex: "Click me")
				'style'         => 'tiled',				// columns,slider,tiled,list
				'category'      => null,				// numerical ID(s) or category name(s) (multiple separated by commas) (do not mix the two)
				'orderby'       => 'post_date',			// none,ID,author,title,name,type,date,modified,parent,rand
				'order'         => 'DESC',				// DESC(descending) or ASC(ascending)
				'post_status'   => 'publish',			// publish,pending,draft,auto-draft,future,private,inherit,trash,any
				'cache_results' => false,				// true or false
				'meta'          => 'series',            // Posts with THIS meta key
				'key'           => null,                // Post with THIS meta key VALUE
				'title'         => null
			), $atts )
		);
		/**
		 * Escape shortcode attributes before passing them to the script
		 */
		if( $thumbs )        $thumbs        = sanitize_text_field( $thumbs );
		if( $show_link )     $show_link     = sanitize_text_field( $show_link );
		if( $amount )        $amount        = sanitize_text_field( $amount );
		if( $downsize )      $downsize      = sanitize_text_field( $downsize );
		if( $offset )        $offset        = sanitize_text_field( $offset );
		if( $paging )        $paging        = sanitize_text_field( $paging );
		if( $related )       $related       = sanitize_text_field( $related );
		if( $year )          $year          = sanitize_text_field( $year );
		if( $month )         $month         = sanitize_text_field( $month );
		if( $day )           $day           = sanitize_text_field( $day );
		if( $link_content )  $link_content  = sanitize_text_field( $link_content );
		if( $style )         $style         = sanitize_text_field( $style );
		if( $category )      $category      = sanitize_text_field( $category );
		if( $orderby )       $orderby       = sanitize_text_field( $orderby );
		if( $order )         $order         = sanitize_text_field( $order );
		if( $post_status )   $post_status   = sanitize_text_field( $post_status );
		if( $cache_results ) $cache_results = sanitize_text_field( $cache_results );
		if( $meta )          $meta          = sanitize_text_field( $meta );
		if( $key )           $key           = sanitize_text_field( $key );
		if( 123 == $year ) { 
			$year = date( 'Y' );
		}
		if( 123 == $month ) { 
			$month = date( 'n' );
		}
		if( 123 == $day ) { 
			$day = date( 'j' );
		}
		if( $related ) {
			$related_class = ' sidebar';
		}
		if( $meta == strtolower( 'series' ) && $related != 1 ) {
			$key     = $series;
			$amount  = -1;
			$exclude = $post->ID;
		}
		if( $related ) {
			$amount  = -1;
			$exclude = $post->ID;
			$meta    = sanitize_text_field ( $meta );
			$key     = sanitize_text_field ( get_post_meta($post->ID, $meta, true) );
		}
		/**
		 * Set up our initial container for the miniloop
		 */
		if( 1 != $related ) {
			$open = '<div class="loopdeloopRotation loopdeloop_' . $style .'">';
		} else {
			echo '<div class="loopdeloopRotation loopdeloop_' . $style .'">';
		}
		/**
		 * Set up our arguments for the loops based on the shortcode attributes
		 * or presets (in case no attributes were specified in the shortcode)
		 * We'll need 4 total loops - two for categories specified by name (if we're drawing from specific
		 * categories), and two for categories specified by id (if we're drawing from specific categories)
		 * We'll need to then further differentiate between those as to whether or not we're 
		 * also excluding categories based on user levels.
		 */
		if( 1 == $paging ) {
			if( is_single() ) {
			}
			$paged = (get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
		}
		if( intval( $category ) ) {
			if( 1 == $paging ) {
				if( $key ) {
					$args = array(
						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category'         => $category,
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
						'category'         => $category,
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
			} else {
				if( $key ) {
					$args = array(
						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category'         => $category,
						'orderby'          => $orderby,
						'order'            => $order,
						'post_type'        => 'post',
						'post_status'      => $post_status,
						'suppress_filters' => true,
						'cache_results'    => $cache_results,
						'year'             => $year,
						'monthnum'         => $month,
						'day'              => $day,
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
						'category'         => $category,
						'orderby'          => $orderby,
						'order'            => $order,
						'post_type'        => 'post',
						'post_status'      => $post_status,
						'suppress_filters' => true,
						'cache_results'    => $cache_results,
						'year'             => $year,
						'monthnum'         => $month,
						'day'              => $day,
						'meta_key'         => $meta
					);
				}
			}
		} else {
			if( 1 == $paging ) {
				if( $key ) {
					$args = array(
						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category_name'    => $category,
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
							'category_name'    => $category,
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
				} else {
					if( $key ) {
						$args = array(
							'post__not_in'     => array( $exclude ),
							'posts_per_page'   => $amount,
							'offset'           => $offset,
							'category_name'    => $category,
							'orderby'          => $orderby,
							'order'            => $order,
							'post_type'        => 'post',
							'post_status'      => $post_status,
							'suppress_filters' => true,
							'cache_results'    => $cache_results,
							'year'             => $year,
							'monthnum'         => $month,
							'day'              => $day,
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
							'category_name'    => $category,
							'orderby'          => $orderby,
							'order'            => $order,
							'post_type'        => 'post',
							'post_status'      => $post_status,
							'suppress_filters' => true,
							'cache_results'    => $cache_results,
							'year'             => $year,
							'monthnum'         => $month,
							'day'              => $day,
							'meta_key'         => $meta
						);
					}
				}
		}
		$myposts = get_posts( $args );
		$post_counter = 0;
		foreach( $myposts as $post ) {
			++$post_counter;
		}
		if( 0 < $post_counter ) {
			if( $related ) {
				if( $title && $post_counter ) {
					echo '<h2 class="loopdeloopTitle">' . $title . '</h2>';
				}
			}
			/**
			 * [style="slider"]
			 */
			if( $style == strtolower( 'slider' ) ) {
				if( 1 != $related ) {
					$open .= '<div class="loopdeloopSlideContainer inner"><div class="inner">';
					/**
					 * Count the number of posts returned from the loop.
					 * Since each thumbnail will be 500px in width, we can 
					 * safely assume that posts * 500px will give us a container 
					 * that is the right width to house all of the returned items
					 * for our inner container.
					 */
					$post_counter = 0;
					$open .= '<style>';
					foreach( $myposts as $post ) {
						++$post_counter;
					}
					$open .= '.loopdeloopRotation .inner { width:' . $post_counter * 500 . 'px; }</style>';
				} else {
					echo '<div class="loopdeloopSlideContainer inner"><div class="inner">';
					/**
					 * Count the number of posts returned from the loop.
					 * Since each thumbnail will be 500px in width, we can 
					 * safely assume that posts * 500px will give us a container 
					 * that is the right width to house all of the returned items
					 * for our inner container.
					 */
					$post_counter = 0;
					echo '<style>';
					foreach( $myposts as $post ) {
						++$post_counter;
					}
					echo '.loopdeloopRotation .inner { width:' . $post_counter * 500 . 'px; }</style>';
				}
			}
			/**
			 * [style="columns"]
			 */
			if( $style == strtolower( 'columns' ) ) {
				if( 1 != $related ) {
					$open .= '<div class="loopdeloopColumns"><div>';
				} else {
					echo '<div class="loopdeloopColumns"><div>';
				}
			}
			/**
			 * [style="list"]
			 */
			if( $style == strtolower( 'list' ) ) {
				if( 1 != $related ) {
					$open .= '<div class="loopdeloopList"><div>';
				} else {
					echo '<div class="loopdeloopList"><div>';
				}
			}
			/**
			 * [style="tiled"]
			 */
			if( $style == strtolower( 'tiled' ) ) {
				if( 1 != $related ) {
					$open .= '<div>';
				} else {
					echo '<div>';
				}
			}
			/**
			 * Start the loop
			 */
			query_posts( $args );
			if( 1 != $related ) {
				ob_start();
			}
			if( have_posts() ): while( have_posts() ) : the_post();
			/**
			 * Set up any post information that can only be gathered while inside of the loop
			 */
			$id            = get_the_ID();
			$link_text     = null;
			$link          = esc_url( get_permalink( $id ) );
			$title         = get_the_title( $id );
			$date          = get_the_date();
			$comment_count = get_comments_number();
			$author        = get_the_author();
			/**
			 * Grab the category(s) associated with the post
			 */
			$categories = get_the_category( $id );
			$separator = ' ';
			$output = null;
			/**
			 * Set up link text, and determine whether or not to use custom link text
			 * [link_content="Click me!"] would result in links that say "Click me!"
			 * while the default is to just use the title of the post as the link text
			 */
			if( !$link_content ) {
				$link_text_text = get_the_title( $id );
			} else {
				$link_text_text = $link_content;
			}
			if( $show_link == 1 ) {
				$link_text = '<a class="mediaNotPresent" href="' . get_permalink( $id ) . '">' . $link_text_text . '</a>';
			}
			/**
			 * Determine what post number we're currently on relative to the amount of posts 
			 * in the loop; has nothing to do with the post's ID
			 */
			++$recent_count;
			/**
			 * Grab the thumbnail associated with the post, and then fetch an appropriate URL 
			 * based on whether we want the full image or a "downsized" image (thumbnail quality)
			 * [downsize="1"] for thumbnail quality, while default is full
			 */
			$media = get_post_meta( $id, 'media', true );
			$thumb_path = '';
			if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
				$post_thumbnail_id = get_post_thumbnail_id( $id );
				if( $downsize == 1 ) {
					$thumb_array = image_downsize( $post_thumbnail_id, 'thumbnail' );
					$thumb_path = $thumb_array[0];	
				} else {
					$thumb_path = wp_get_attachment_url( get_post_thumbnail_id( $id ) );
				}
			}
			/**
			 * [style="list"]
			 */
			if( $style == strtolower( 'list' ) ) {
				echo '<section class="post' . $related_class . '"><div class="counter">' . $recent_count . '</div>';
					if( $thumb_path ) {
						echo '<div class="thumb"><img src="' . $thumb_path . '" /></div>';
					}
					echo '<div class="text"><span class="title"><a href="' . $link . '">' . $title . '</a></span>';
					echo '<span class="meta">' . the_excerpt() . '</span>';
					echo '</div>
				</section>';
			}
			/**
			 * [style="columns"]
			 */
			if( $style == strtolower( 'columns' ) ) {
				echo '<div class="column' . $related_class . '"><div class="inner"';
				if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
					echo ' style="background-image:url(\'' . $thumb_path . '\' );"';
				}
				echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a><span class="link">' . $link_text . '<em><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a></em></span></div>';
				echo '</div>';
			}
			/**
			 * [style="slider"] 
			 */
			if( $style == strtolower( 'slider' ) ) {
					echo '<div class="slide"';
					if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
						echo ' style="background-image:url(\'' . $thumb_path . '\' );"';
					}			
					echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"><span class="title">'. $link_text_text . '</span></a></div>';
			}
			/**
			 * [style="tiled"] 
			 */
			if( $style == strtolower( 'tiled' ) ) {
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
					if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
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
					if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
						$post_thumbnail_id = get_post_thumbnail_id( $id );
						if( $downsize == 1 ) {
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
			/**
			 * End the loop
			 */
			endwhile;
			if( 1 == $paging ) {
				echo '<div class="loopdeloopNavigation">'; posts_nav_link( '&#8734;','Previous','Next' ); echo '</div>';
			}
			else;
			endif;
			/**
			 * Close all open containers associated with this miniloop
			 */
			if( 1 != $related ) {
				$close = '</div></div></div>';
			} else { 
				echo '</div></div></div>';
			}
			/**
			 * Reset all post data from previous loop
			 */
			wp_reset_query();
			if( 1 != $related ) {
				return $open . ob_get_clean() . $close;
			} else { }
		}

		$open           = null;
		$close          = null;
		$thumbs         = null;
		$show_link      = null;
		$amount         = null;
		$downsize       = null;
		$offset         = null;
		$paging         = null;
		$related        = null;
		$year           = null;
		$month          = null;
		$day            = null;
		$link_content   = null;
		$style          = null;
		$category       = null;
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
		$related_class  = null;
		$series         = null;
		$year           = null;
		$month          = null;
		$day            = null;

	}
}