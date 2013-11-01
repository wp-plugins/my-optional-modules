<?php

	function mom_SEO_header() {
	
		if ( is_admin() ) {
			function add_fields_to_profile($profile_fields) {
				$profile_fields[ 'twitter_personal' ] = 'Twitter Username';
				return $profile_fields;
			}
			function add_fields_to_general() {
				register_setting( 'general', 'site_keywords', 'esc_attr' );
				add_settings_field( 'site_keywords', '<label for="site_keywords">'.__('Keywords (comma separated)' , 'site_keywords' ).'</label>' , 'add_keywords_to_general_html', 'general' );
				register_setting( 'general', 'site_twitter', 'esc_attr' );
				add_settings_field( 'site_twitter', '<label for="site_twitter">'.__('Twitter Site username' , 'site_twitter' ).'</label>' , 'add_twitter_to_general_html', 'general' );				
				
			}			
			function add_keywords_to_general_html() {
				$keywords = get_option( 'site_keywords', '' );
				echo '<textarea id="site_keywords" name="site_keywords">' . $keywords . '</textarea>';			
			}
			function add_twitter_to_general_html() {
			$twitter = get_option( 'site_twitter', '');
			echo '<input id="site_twitter" name="site_twitter" value="' . $twitter . '"/>';
			}
			
			add_filter( 'admin_init', 'add_fields_to_general');
			add_filter( 'user_contactmethods', 'add_fields_to_profile');
		}
		

		function extractCommonWords($string){
			  $stopWords = array('i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www');
		   
			  $string = preg_replace('/\s\s+/i', '', $string);
			  $string = trim($string);
			  $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); 
			  $string = strtolower($string); 
		   
			  preg_match_all('/\b.*?\b/i', $string, $matchWords);
			  $matchWords = $matchWords[0];
			  
			  foreach ( $matchWords as $key=>$item ) {
				  if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
					  unset($matchWords[$key]);
				  }
			  }   
			  $wordCountArr = array();
			  if ( is_array($matchWords) ) {
				  foreach ( $matchWords as $key => $val ) {
					  $val = strtolower($val);
					  if ( isset($wordCountArr[$val]) ) {
						  $wordCountArr[$val]++;
					  } else {
						  $wordCountArr[$val] = 1;
					  }
				  }
			  }
			  arsort($wordCountArr);
			  $wordCountArr = array_slice($wordCountArr, 0, 10);
			  return $wordCountArr;
		}	
	
		function grab_keywords() {
		
				
			// Keyword function http://www.hashbangcode.com/blog/extract-keywords-text-string-php-412.html
			global $post;
			$postid = $post->ID;
			$authorID = $post->post_author;
			$post_content = get_post_field('post_content', $postid);
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );	
			$featured_image_url = $featured_image[0];
			$post_link = get_permalink($post->ID);
			$post_title = get_post_field('post_title', $postid);
			$words = extractCommonWords($post_content);
			$keywords = implode(',', array_keys($words));
			$excerpt_from = get_post( $postid ); 
			$the_excerpt = $excerpt_from->post_excerpt;
			$description_content = get_bloginfo( 'description' );
			$twitter_personal_content = get_the_author_meta( 'twitter_personal', $authorID );
			$twitter_site_content = get_option( 'site_twitter' );
			$site_keywords = get_option( 'site_keywords' );
			$keywords_site_san = sanitize_text_field( $site_keywords );
			$keywords_site_html = htmlentities( $keywords_site_san );
			$post_title_final = htmlentities( $post_title );
			$the_excerpt_final = htmlentities( $the_excerpt );
					
			if ( is_single() || is_page() ) {
				if ( $description_content != "" )  echo "
<meta name=\"description\" content=\"$description_content\"/>"; 
				if ( $keywords != "" ) { echo "
<meta name=\"keywords\" content=\"$keywords\"/>"; }
				echo "
<meta property=\"og:title\" content=\"$post_title_final\"/>";
				if ( $featured_image_url != "" ) { echo "
<meta property=\"og:image\" content=\"$featured_image_url\"/>"; }
				if ( $the_excerpt_final != "" ) { echo "
<meta property=\"og:description\" content=\"$the_excerpt_final\"/>"; }
				echo "
<meta property=\"og:url\" content=\"$post_link\"/>
<meta property=\"og:type\" content=\"article\"/>";
				if ( $twitter_personal_content != "" || $twitter_site_content != "" ) {
					echo "
<meta name=\"twitter:card\" value=\"summary\">";
						
						if ( $twitter_site_content != "" ) { echo "
<meta name=\"twitter:site\" value=\"" . $twitter_site_content . "\">";
						}
						if ( $twitter_personal_content != "" ) { echo "
<meta name=\"twitter:creator\" value=\"" . $twitter_personal_content . "\">";
						}				
				}
			} else {
				if ( $keywords_site_html != "" ) { echo "
<meta name=\"keywords\" content=\"$keywords_site_html\"/>"; }
			}
			echo "
			
			";				
		}
		
		add_action('wp_head', 'grab_keywords');   
	}
	
	mom_SEO_header();

?>