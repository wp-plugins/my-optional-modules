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
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

/**
 *
 * Grab the value of the option to see whether or not miniloops are enabled 
 * from Module->Takeover->Mini Loops (yes/no)
 * If they are enabled, we'll enable the shortcode to be used on the installation
 * If they aren't, the shortcode will not function properly
 *
 */
if( get_option( 'MOM_themetakeover_tiledfrontpage' ) == 1 ) {

	add_filter ( 'the_content', 'do_shortcode', 'mom_miniloop' );
	add_shortcode ( 'mom_miniloop', 'mom_tiled_frontpage' );

}

/**
 *
 * [mom_miniloop] shortcode functionality
 *
 */
function mom_tiled_frontpage( $atts, $content = null ) {

	/**
	 *
	 * Grab the current user's level set previously in the main plugin 
	 * for use in this shortcode (where necessary and called for)
	 *
	 */
	global $user_level;

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

	/**
	 *
	 * Shortcode attributes (to be set inside of the shortcode)
	 * [mom_miniloop thumbs="1" show_link="1" amount="4" exclude_user="0" downsize="1"...]
	 * These attributes will be used as the default settings, which can be overridden by 
	 * attributes set inside of the shortcode.
	 *
	 */
	extract(

		shortcode_atts(array(
			'thumbs'        => 1,					// 1(yes) 0(no)	
			'show_link'     => 1,					// 1(yes) 0(no)
			'link_content'  => '',					// alpha-numeric value for post content (defaults to post title) (ex: "Click me")
			'amount'        => 4,					// numerical value of how many posts to return in the loop
			'exclude_user'  => 0,					// 1(yes) 0(no) (use exclude user category settings from Exclude module)
			'downsize'      => 1,					// 1(yes) 0(no) (downsize thumbnails image quality and size)
			'style'         => 'tiled',				// tiled,slider,dropdown
			'offset'        => 0,					// how many posts to offset 
			'category'      => '',					// numerical ID(s) or category name(s) (multiple separated by commas) (do not mix the two)
			'orderby'       => 'post_date',			// none,ID,author,title,name,type,date,modified,parent,rand
			'order'         => 'DESC',				// DESC(descending) or ASC(ascending)
			'post_status'   => 'publish',			// publish,pending,draft,auto-draft,future,private,inherit,trash,any
			'cache_results' => false,				// true or false
			'year'          => '',					// numerical date (year) (ex: 2014,2013,2012,2011..)
			'month'         => '',					// numerical date (month) (ex: 1,2,3,4,5,6,7,8,9,10,11,12)
			'day'           => ''					// numerical date (day) (ex: 1,2,3,4,5,6,7,8,9,10,11,...)
		), $atts)

	);

	/**
	 *
	 * Module->Exclude( Categories->(Logged out, Subscriber, Contributor, Author)
	 * 0/1: Logged Out, Subscriber / 2: Contributor / 7: Author
	 * [mom_miniloop exclude_user="1"]
	 * Will use the settings from Module-Exclude to hide categories from these mini loops 
	 * based on the user's user level (or lack thereof)
	 *
	 */
	if ( get_option ( 'MOM_Exclude_Categories_level7Categories') && $user_level == 7 ) {

		$exclude_cats  = get_option ( 'MOM_Exclude_Categories_level7Categories' );

	} elseif ( get_option ( 'MOM_Exclude_Categories_level2Categories') && $user_level == 2 ) {

		$exclude_cats  = get_option ( 'MOM_Exclude_Categories_level2Categories' );

	} elseif ( get_option ( 'MOM_Exclude_Categories_level1Categories') && $user_level == 1 ) {

		$exclude_cats  = get_option ( 'MOM_Exclude_Categories_level1Categories' );

	} elseif ( get_option ( 'MOM_Exclude_Categories_level0Categories') && $user_level == 0 ) {

		$exclude_cats  = get_option ( 'MOM_Exclude_lCategories_evel0Categories' );

	}

	/**
	 *
	 * Set up our initial container for the miniloop
	 *
	 */
	echo '<div class="mom_postrotation mom_recentPostRotationFull_' . $style .'">';

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
	if( intval( $category ) ) {

		if( $exclude_user == 1 ) {

			$args = array(
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
				'category__not_in' => $exclude_cats
			);

		} else {

			$args = array(
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
				'day'              => $day
			);

		}

	} else {

		if( $exclude_user == 1 ) {

			$args = array(
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
				'category__not_in' => array( $exclude_cats )
			);

		} else {

			$args = array(
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
				'day'              => $day
			);

		}

	}
	$myposts = get_posts( $args );
	
	/**
	 *
	 * [mom_miniloop style="slider"]
	 *
	 */
	if( $style == strtolower('slider') ) {

		echo '<div class="mom_slide_container"><div class="slide_container_inner">';

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

	/**
	 *
	 * [mom_miniloop style="dropdown"]
	 *
	 */
	if ( $style == strtolower( 'dropdown' ) ) {

		echo '<div class="mom_minidropdown">';

	}

	/**
	 *
	 * [mom_miniloop style="dropdown"]
	 *
	 */
	if ( $style == strtolower( 'columns' ) ) {

		echo '<div class="mom_minicolumns">';

	}	
	
	/**
	 *
	 * Start the loop
	 *
	 */
	foreach( $myposts as $post ) : setup_postdata( $post );

	/**
	 *
	 * Set up any post information that can only be gathered while inside of the loop
	 *
	 */
	$id = $post->ID;
	$link_text = '';
	$link  = esc_url( get_permalink( $id ) );
	$title = get_the_title( $id );

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

	/**
	 *
	 * Grab the content of the post, strip all tags, and then cut its length 
	 * to 100 characters so that it will display properly in the container 
	 *
	 */
	$the_excerpt = get_the_content( $id );
	$the_excerpt = sanitize_text_field( $the_excerpt );
	$the_excerpt = substr( $the_excerpt, 0, 100 );
	
	/**
	 *
	 * Grab the thumbnail associated with the post, and then fetch an appropriate URL 
	 * based on whether we want the full image or a "downsized" image (thumbnail quality)
	 * [mom_miniloop downsize="1"] for thumbnail quality, while default is full
	 *
	 */
	$media = get_post_meta( $id, 'media', true );
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
	 * [mom_miniloop style="columns"]
	 *
	 */
	if( $style == strtolower( 'columns' ) ) {

		echo '<div class="column"><div class="inner" ';

		if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {

			echo 'style="background-image:url(\'' . $thumb_path . '\');"';

		}

		echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a><span class="link">' . $link_text . '<em><a class="mediaNotPresent" href="' . get_permalink( $id ) . '">' . $the_excerpt . '</a></span></div>';
		echo '</div>';

	}

	/**
	 *
	 * [mom_miniloop style="dropdown"] 
	 *
	 */
	if( $style == strtolower( 'dropdown' ) ) {

			/**
			 *
			 * Grab the category(s) associated with the post
			 *
			 */
			$categories = get_the_category( $id );
			$separator = ' ';
			$output = '';

			echo '<span>';
			if( $thumb_path && $thumbs == 1 ) {

				echo '<a class="image" href="' . get_permalink( $id ) . '"><img class="slide" src="' . $thumb_path . '" /></a>';

			}
			
			echo '<strong class="post_link">';
			echo $link_text;
			echo '</strong>';
			echo '<p>';
			
			if( $the_excerpt ) {

				echo $the_excerpt;

			} else {

				if( $link_text_text ) {

					echo $link_text_text;

				} else {

					echo '[View this post...]';

				}

			}

			echo '<em class="categories">';

			if( $categories ) {

				foreach( $categories as $category ) {

					$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;

				}

			echo trim( $output, $separator );

			}

			echo '</em></p></span>';
	}

	/**
	 *
	 * [mom_miniloop style="slider"] 
	 *
	 */
	if ( $style == strtolower( 'slider' ) ) {
			echo '<div class="slide"><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"><img class="slide" src="' . $thumb_path . '" /><span class="title">'. $link_text_text . '</span></a></div>';
	}

	/**
	 *
	 * [mom_miniloop style="tiled"] 
	 *
	 */
	if( $style == strtolower('tiled') ) {
	
		if( $recent_count == 1 ) {

			$container = 'feature';
			echo '<div class="' . $container . '">';

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
				
				echo ' style="background-image:url(\'' . $thumb_path . '\');"';
			}

			echo '>';
			echo $link_text . '</div>';
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
	endforeach;

	/**
	 *
	 * Close all open containers associated with this miniloop
	 *
	 */
	if ( $style == strtolower( 'dropdown' ) ) {

		echo '</div>';

	}

	if ( $style == strtolower( 'slider' ) ) {

		echo '</div></div></div>';

	}
	
	if ( $style == strtolower( 'tiled' ) ) {

		echo '</div></div>';

	}

	if ( $style == strtolower( 'columns' ) ) {

		echo '</div>';

	}

	/**
	 *
	 * Reset all post data from previous loop
	 *
	 */
	wp_reset_postdata();
}