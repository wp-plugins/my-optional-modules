<?php 

/**
 *
 * Module->Takeover->Mini Loops
 * [mom_miniloop]
 *
 * Display a miniloop of posts from the blog based on shortcode parameters in
 * a variety of different styles. Can be used multiple times on the same page.
 *
 * Since 5.5.6.7
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

/**
 *
 * Grab the value of the option to see whether or not miniloops are enabled 
 * from Module->Takeover->Mini Loops (yes/no)
 * If they are enabled, we'll enable the shortcode to be used on the installation
 * If they aren't, the shortcode will not function properly
 *
 */
if( get_option( 'MOM_themetakeover_tiledfrontpage' ) == 1 && get_option( 'mommaincontrol_themetakeover' ) == 1 ) {

	add_filter( 'the_content', 'do_shortcode', 'mom_miniloop' );
	add_shortcode( 'mom_miniloop', 'mom_tiled_frontpage' );

}

/**
 *
 * [mom_miniloop] shortcode functionality
 *
 */
function mom_tiled_frontpage( $atts ) {
	
	/**
	 *
	 * Grab the current user's level set previously in the main plugin 
	 * for use in this shortcode(where necessary and called for)
	 *
	 */
	global $user_level,$paged,$post;

	/**
	 *
	 * Set up some default values that we can override later
	 *
	 */

	$maxposts       = get_option( 'posts_per_page' );
	$category_count = 0;
	$alt            = 0;
	$recent_count   = 0;
	$exclude_cats   = '';
	$related_class  = ' element';

	$check_key      = sanitize_text_field ( get_option( 'MOM_themetakeover_series_key' ) );
	if( $check_key ) {
	
		$series = get_post_meta($post->ID, $check_key, true);
	
	} else {
		
		$series = get_post_meta($post->ID, 'series', true);
		
	}
	
	/**
	 *
	 * Shortcode attributes(to be set inside of the shortcode)
	 * [mom_miniloop thumbs="1" show_link="1" amount="4" exclude_user="0" downsize="1"...]
	 * These attributes will be used as the default settings, which can be overridden by 
	 * attributes set inside of the shortcode.
	 *
	 */
	extract(

		shortcode_atts( array(
			
			'exclude'       => '',                  // post IDs to exclude
			'thumbs'        => 1,					// 1(yes) 0(no)	
			'show_link'     => 1,					// 1(yes) 0(no)
			'link_content'  => '',					// alpha-numeric value for post content (defaults to post title) (ex: "Click me")
			'amount'        => 4,					// numerical value of how many posts to return in the loop
			'exclude_user'  => 0,					// 1(yes) 0(no) (use exclude user category settings from Exclude module)
			'downsize'      => 1,					// 1(yes) 0(no) (downsize thumbnails image quality and size)
			'style'         => 'tiled',				// columns,slider,tiled,list
			'offset'        => 0,					// how many posts to offset 
			'category'      => '',					// numerical ID(s) or category name(s) (multiple separated by commas) (do not mix the two)
			'orderby'       => 'post_date',			// none,ID,author,title,name,type,date,modified,parent,rand
			'order'         => 'DESC',				// DESC(descending) or ASC(ascending)
			'post_status'   => 'publish',			// publish,pending,draft,auto-draft,future,private,inherit,trash,any
			'cache_results' => false,				// true or false
			'year'          => '',					// numerical date (year) (ex: 2014,2013,2012,2011..)
			'month'         => '',					// numerical date (month) (ex: 1,2,3,4,5,6,7,8,9,10,11,12)
			'day'           => '',					// numerical date (day) (ex: 1,2,3,4,5,6,7,8,9,10,11,...)
			'votes'         => 0,                   // display votes associated with each post (if voting module is on) (default: 0 / off)
			'paging'        => 0,					// Whether or not to page the results
			'meta'          => '',                  // Posts with THIS meta key
			'key'           => '',                  // Post with THIS meta key VALUE                    
			'related'       => 0
			

		), $atts )

	);
	
	if( $related ) {
		
		$related_class = ' sidebar';
		$title         = sanitize_text_field ( get_option( 'MOM_themetakeover_series_title' ) );
		
	}


	if( $meta == strtolower( 'series' ) && $related != 1 ) {

		$key     = $series;
		$amount  = -1;
		$exclude = $post->ID;

	}
	
	if( $related ) {

		$amount  = -1;
		$exclude = $post->ID;
		$meta    = sanitize_text_field ( get_option( 'MOM_themetakeover_series_key' ) );
		$key     = sanitize_text_field ( get_post_meta($post->ID, $meta, true) );

	}
	
	/**
	 *
	 * Module->Exclude( Categories->(Logged out, Subscriber, Contributor, Author)
	 * 0/1: Logged Out, Subscriber / 2: Contributor / 7: Author
	 * [mom_miniloop exclude_user="1"]
	 * Will use the settings from Module-Exclude to hide categories from these mini loops 
	 * based on the user's user level (or lack thereof)
	 *
	 */
	if( get_option( 'MOM_Exclude_Categories_level7Categories') && $user_level == 7 ) {

		$exclude_cats  = get_option( 'MOM_Exclude_Categories_level7Categories' );

	} elseif( get_option( 'MOM_Exclude_Categories_level2Categories') && $user_level == 2 ) {

		$exclude_cats  = get_option( 'MOM_Exclude_Categories_level2Categories' );

	} elseif( get_option( 'MOM_Exclude_Categories_level1Categories') && $user_level == 1 ) {

		$exclude_cats  = get_option( 'MOM_Exclude_Categories_level1Categories' );

	} elseif( get_option( 'MOM_Exclude_Categories_level0Categories') && $user_level == 0 ) {

		$exclude_cats  = get_option( 'MOM_Exclude_lCategories_evel0Categories' );

	}

	/**
	 *
	 * Set up our initial container for the miniloop
	 *
	 */
	if( 1 != $related ) {

		$open = '<div class="mom_postrotation mom_recentPostRotationFull_' . $style .'">';

	} else {

		echo '<div class="mom_postrotation mom_recentPostRotationFull_' . $style .'">';

	}

	/**
	 *
	 * Set up our arguments for the loops based on the shortcode attributes
	 * or presets (in case no attributes were specified in the shortcode)
	 * We'll need 4 total loops - two for categories specified by name (if we're drawing from specific
	 * categories), and two for categories specified by id (if we're drawing from specific categories)
	 * We'll need to then further differentiate between those as to whether or not we're 
	 * also excluding categories based on user levels.
	 *
	 */

	if( 1 == $paging ) {

		if( is_single() ) {
			
		}
	
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;

	}

	if( intval( $category ) ) {

		if( $exclude_user == 1 ) {

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
						'category__not_in' => $exclude_cats,
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
						'category__not_in' => $exclude_cats,
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
						'category__not_in' => $exclude_cats,
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
						'category__not_in' => $exclude_cats,
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

		}

	} else {

		if( $exclude_user == 1 ) {

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
						'category__not_in' => array( $exclude_cats ),
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
						'category__not_in' => array( $exclude_cats ),
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
						'category__not_in' => array( $exclude_cats ),
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
						'category__not_in' => array( $exclude_cats ),
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

	}
	$myposts = get_posts( $args );
	
	if( $related ) {
		$post_counter = 0;
		foreach( $myposts as $post ) {
			$post_counter++;
		}
		if( $title && $post_counter ) {

			echo '<h2 class="mom_related_title">' . $title . '</h2>';

		}
	}
	
	/**
	 *
	 * [mom_miniloop style="slider"]
	 *
	 */
	if( $style == strtolower('slider') ) {

	if( 1 != $related ) {

		$open .= '<div class="mom_slide_container slide_container_inner"><div class="slide_container_inner">';

		/**
		 *
		 * Count the number of posts returned from the loop.
		 * Since each thumbnail will be 500px in width, we can 
		 * safely assume that posts * 500px will give us a container 
		 * that is the right width to house all of the returned items
		 * for our inner container.
		 *
		 */
		$post_counter = 0;

		$open .= '<style>';

		foreach( $myposts as $post ) {

			$post_counter++;

		}

		$open .= '.mom_postrotation .slide_container_inner { width:' . $post_counter * 500 . 'px; }</style>';

	} else {

		echo '<div class="mom_slide_container slide_container_inner"><div class="slide_container_inner">';

		/**
		 *
		 * Count the number of posts returned from the loop.
		 * Since each thumbnail will be 500px in width, we can 
		 * safely assume that posts * 500px will give us a container 
		 * that is the right width to house all of the returned items
		 * for our inner container.
		 *
		 */
		$post_counter = 0;

		echo '<style>';

		foreach( $myposts as $post ) {

			$post_counter++;

		}

		echo '.mom_postrotation .slide_container_inner { width:' . $post_counter * 500 . 'px; }</style>';
	
	}

	}

	/**
	 *
	 * [mom_miniloop style="columns"]
	 *
	 */
	if( $style == strtolower( 'columns' ) ) {

		if( 1 != $related ) {

			$open .= '<div class="mom_minicolumns"><div>';

		} else {

			echo '<div class="mom_minicolumns"><div>';

		}

	}
	
	/**
	 *
	 * [mom_miniloop style="list"]
	 *
	 */
	if( $style == strtolower( 'list' ) ) {
	
		if( 1 != $related ) {

			$open .= '<div class="mom_minilist"><div>';

		} else {

			echo '<div class="mom_minilist"><div>';

		}

	}

	/**
	 *
	 * [mom_miniloop style="tiled"]
	 *
	 */
	if( $style == strtolower( 'tiled' ) ) {
	
	if( 1 != $related ) {

		$open .= '<div>';
	
	} else {

		echo '<div>';

	}

	}
	
	
	/**
	 *
	 * Start the loop
	 *
	 */
	query_posts( $args );
	
	if( 1 != $related ) {
		ob_start();
	}
	
	if( have_posts() ): while( have_posts()) : the_post();

	/**
	 *
	 * Set up any post information that can only be gathered while inside of the loop
	 *
	 */
	$id            = get_the_ID();
	$link_text     = '';
	$link          = esc_url( get_permalink( $id ) );
	$title         = get_the_title( $id );
	$date          = get_the_date();
	$comment_count = get_comments_number();
	$since         = mom_timesince( $date );
	$author        = get_the_author();

	/**
	 *
	 * Grab the category(s) associated with the post
	 *
	 */
	$categories = get_the_category( $id );
	$separator = ' ';
	$output = '';

	/**
	 *
	 * Set up link text, and determine whether or not to use custom link text
	 * [mom_miniloop link_content="Click me!"] would result in links that say "Click me!"
	 * while the default is to just use the title of the post as the link text
	 *
	 */
	if( '' == $link_content ) {

		$link_text_text = get_the_title( $id );

	} else {
	
		$link_text_text = $link_content;

	}
	
	if( $show_link == 1 ) {

		$link_text = '<a class="mediaNotPresent" href="' . get_permalink( $id ) . '">' . $link_text_text . '</a>';

	}

	/**
	 *
	 * Determine what post number we're currently on relative to the amount of posts 
	 * in the loop; has nothing to do with the post's ID
	 *
	 */
	$recent_count++;

	$vote_count  = '';

	if( function_exists( 'mom_grab_vote_count' ) && 1 == $votes ) {

		$vote_count = mom_grab_vote_count( $id );

	}
	
	/**
	 *
	 * Grab the thumbnail associated with the post, and then fetch an appropriate URL 
	 * based on whether we want the full image or a "downsized" image (thumbnail quality)
	 * [mom_miniloop downsize="1"] for thumbnail quality, while default is full
	 *
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
	 *
	 * [mom_miniloop style="list"]
	 *
	 */
	if( $style == strtolower( 'list' ) ) {

		echo '<section class="post' . $related_class . '"><div class="counter">' . $recent_count . '</div>';

			if( $thumb_path ) {

				echo '<div class="thumb"><img src="' . $thumb_path . '" /></div>';

			}

			echo '<div class="text"><span class="title"><a href="' . $link . '">' . $title . '</a></span><span class="author">posted <date title="' . $date . '">' . $since . '</date> by ' . $author . ' to ';

				if( $categories ) {

					foreach( array_slice( $categories, 0, 1 ) as $category ) {

						$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;

					}

				echo trim( $output, $separator );

				}

				echo '</span><span class="meta"><a href="' . $link . '">' . $comment_count . ' comments</a> ' . $vote_count . '</span></div>
		</section>';

	}
	
	/**
	 *
	 * [mom_miniloop style="columns"]
	 *
	 */
	if( $style == strtolower( 'columns' ) ) {

		echo '<div class="column' . $related_class . '">' . $vote_count . '<div class="inner" ';

		if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {

			echo 'style="background-image:url(\'' . $thumb_path . '\');"';

		}

		echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a><span class="link">' . $link_text . '<em><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a></em></span></div>';
		echo '</div>';

	}

	/**
	 *
	 * [mom_miniloop style="slider"] 
	 *
	 */
	if( $style == strtolower( 'slider' ) ) {
	
			echo '<div class="slide"><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"><img class="slide" src="' . $thumb_path . '" /><span class="title">'. $link_text_text . $vote_count . '</span></a></div>';

	}

	/**
	 *
	 * [mom_miniloop style="tiled"] 
	 *
	 */
	if( $style == strtolower('tiled') ) {

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

				echo 'style="background-image:url(\'' . $thumb_path . '\');"';

			}
			
			echo '>';
			echo $vote_count . $link_text;

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
				
				echo ' style="background-image:url(\'' . $thumb_path . '\');"';
			}

			echo '>';
			echo $vote_count . $link_text . '</div>';
		}
		
		if( $recent_count == 4 ) {

			echo '</div></div>';

		}
		

	}


	/**
	 *
	 * End the loop
	 *
	 */
	endwhile;

	if( 1 == $paging ) {

		echo '<div class="mom_miniloop_navigation">'; posts_nav_link('&#8734;','Previous','Next'); echo '</div>';

	}

	else;
	endif;

	/**
	 *
	 * Close all open containers associated with this miniloop
	 *
	 */
	if( 1 != $related ) {

		$close = '</div></div></div>';

	} else { 

		echo '</div></div></div>';

	}

	/**
	 *
	 * Reset all post data from previous loop
	 *
	 */
	wp_reset_query();
	
	if( 1 != $related ) {
		return $open . ob_get_clean() . $close;
	} else { }
	
}