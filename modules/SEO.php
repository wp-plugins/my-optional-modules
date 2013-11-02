<?php

	function mom_SEO_header() {
		global $post;	
		if ( is_admin() ) {
			function add_fields_to_profile($profile_fields) {
				$profile_fields[ 'twitter_personal' ] = 'Twitter Username';
				return $profile_fields;
			}
			function add_fields_to_general() {
				register_setting( 'general', 'site_twitter', 'esc_attr' );
				add_settings_field( 'site_twitter', '<label for="site_twitter">'.__('Twitter Site username' , 'site_twitter' ).'</label>' , 'add_twitter_to_general_html', 'general' );				
				
			}			
			function add_twitter_to_general_html() {
			$twitter = get_option( 'site_twitter', '');
			echo '<input id="site_twitter" name="site_twitter" value="' . $twitter . '"/>';
			}
			
			add_filter( 'admin_init', 'add_fields_to_general');
			add_filter( 'user_contactmethods', 'add_fields_to_profile');
		}
		
		function mom_grab_author_count() {
			$authorsCounted = 0;
			global $wpdb;
			$countAuthors = (array) $wpdb->get_results("
					SELECT DISTINCT('post_author')
					FROM {$wpdb->posts}
				", object);
			foreach ( $countAuthors as $authorCount ) {
					$authorsCounted++;
			}
			
			if ( $authorsCounted == 1 ) {
				add_action( "wp", "mom_author_archives_author" );
				function mom_author_archives_author() {	
					if ( is_author() ) {
						$homeURL = esc_url( home_url('/') );
						if (have_posts()) : the_post();
						header("location: " . $homeURL );
						exit;
						endif;
					}
				}
			}
		}
		mom_grab_author_count();
		
		add_action( "wp", "mom_author_archives" );
		function mom_author_archives() {	
			if ( is_date() ||
				 is_year() ||
				 is_month() || 
				 is_day() || 
				 is_time() || 
				 is_new_day() 				 
			   ) {
				$homeURL = esc_url( home_url('/') );
				if (have_posts()) : the_post();
				header("location: " . $homeURL );
				exit;
				endif;
			}
		}

				
		
	
		function mom_meta_module() {
			$theExcerpt               = '';
			$theFeaturedImage         = '';
			$Twitter_start            = '';
			$Twitter_site             = '';
			$Twitter_author           = '';
			$postid                   = $post->ID;
			$authorID                 = $post->post_author;
			$excerpt_from             = get_post( $postid ); 
			$post_content             = get_post_field( 'post_content', $postid );
			$post_title				  = get_post_field( 'post_title', $postid );
			$publishedTime            = get_post_field( 'post_date', $postid );
			$modifiedTime             = get_post_field( 'post_modified', $postid );
			$post_link                = get_permalink( $post->ID );
			$post_title               = get_post_field( 'post_title', $postid );
			$sitename_content         = get_bloginfo( 'site_name' );
			$description_content      = get_bloginfo( 'description' );
			$twitter_personal_content = get_the_author_meta( 'twitter_personal', $authorID );
			$twitter_site_content     = get_option( 'site_twitter' );
			$locale_content           = get_locale();
			$featured_image           = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );	
			$featuredImage            = $featured_image[0];
			$the_excerpt              = $excerpt_from->post_excerpt;
			$excerpt                  = htmlentities( $the_excerpt );
			$currentURL               = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
			
	
			if ( $excerpt != "" ) { 
				$theExcerpt           = "<meta property=\"og:description\" content=\"" . htmlentities( $excerpt_from->post_excerpt ) . "\"/>\n";
			} else {
				$theExcerpt           = "<meta property=\"og:description\" content=\"" . htmlentities( get_the_excerpt() ) . "\"/>";
			}
			if ( $featuredImage != "" ) { 
				$theFeaturedImage     = "<meta property=\"og:image\" content=\"" . $featuredImage  . "\"/>\n";
			}			
			if ( $twitter_personal_content != "" || $twitter_site_content != "" ) { 
				$Twitter_start        = "<meta name=\"twitter:card\" value=\"summary\">\n";
				if ( $twitter_site_content != "" ) { 
				$Twitter_site         = "<meta name=\"twitter:site\" value=\"" . get_option( 'site_twitter' ) . "\">\n"; }
				if ( $twitter_personal_content != "" ) { 
				$Twitter_author       = "<meta name=\"twitter:creator\" value=\"" . get_the_author_meta( 'twitter_personal', $authorID ) . "\">\n"; }
			}			
			if ( is_single() || is_page() ) {
			    echo "\n";
				echo "<link rel=\"canonical\" href=\"" . esc_url( get_permalink( $post->ID ) ) . "\"/>\n";
				echo "<meta name=\"og:title\" content=\""; wp_title( '|', true, 'right' ); echo "\"/>\n";
				echo "<meta name=\"og:site_name\" content=\"" . get_bloginfo( 'site_name' ) . "\"/>\n";
				echo $theExcerpt;
				echo "<meta property=\"og:title\" content=\"" . htmlentities( get_post_field('post_title', $postid) ) . "\"/>\n";
				echo "<meta property=\"og:locale\" content=\"" . $locale_content . "\"/>\n";
				echo "<meta property=\"og:published_time\" content=\"" . $publishedTime . "\"/>\n";
				echo "<meta property=\"og:modified_time\" content=\"" . $modifiedTime . "\"/>\n";
				$category_names=get_the_category($postid);
				foreach($category_names as $categoryNames){
					echo "<meta property=\"og:section\" content=\"" . $categoryNames->cat_name . "\"/>\n";
				}			
				$tagNames = get_the_tags($postid);
				if ($tagNames) {
					foreach($tagNames as $tagName) {
						echo "<meta property=\"og:tag\" content=\"" . $tagName->name . "\"/>\n";
					}
				}	
				echo "<meta property=\"og:url\" content=\"" . esc_url( get_permalink( $post->ID ) ) . "\"/>\n";
				echo "<meta property=\"og:type\" content=\"article\"/>\n";
				echo $theFeaturedImage;
                echo $Twitter_start;
				echo $Twitter_site;
				echo $Twitter_author;
				echo "\n";
			} else {
			    echo "\n";
				echo "<link rel=\"canonical\" href=\"" . esc_url( $currentURL ) . "\"/>\n";
				echo "<meta name=\"description\" content=\"" . $description_content . "\"/>\n";
				echo "<meta property=\"og:title\" content=\""; wp_title( '|', true, 'right' ); echo "\"/>\n";
				echo "<meta property=\"og:locale\" content=\"" . $locale_content . "\"/>\n";
				echo "<meta name=\"og:site_name\" content=\"" . get_bloginfo( 'site_name' ) . "\"/>\n";
				echo "<meta property=\"og:url\" content=\"" . esc_url( $currentURL ) . "\"/>\n";
				echo "<meta property=\"og:type\" content=\"website\"/>\n";
				echo "\n";
			}
			
			if ( is_search() || is_404() || is_archive() ) {
				echo "\n";
				echo "<meta name=\"robots\" content=\"noarchive\"/>\n";
				echo "<meta name=\"robots\" content=\"nofollow\"/>\n";
				echo "\n";
			}
			
		}
		add_action('wp_head', 'mom_meta_module');   
		
		function momSEOfeed($content) {
			return $content . "<p><a href=\"" . esc_url( get_permalink( $post->ID ) ) . "\">" . htmlentities( get_post_field('post_title', $postid) ) . "</a> via <a href=\"" . esc_url( home_url('/') ) . "\">" . get_bloginfo( 'site_name' ) . "</a></p>";
		}
		add_filter('the_content_feed', 'momSEOfeed');
		add_filter('the_excerpt_rss',  'momSEOfeed');		
	}
		
		
	mom_SEO_header();

?>