<?php

	function mom_SEO_header() {

			function extractCommonWords($string){
			// Could use some more common words to weed out stupid keywords
				$stopWords = array(
					'a','about','an','and','are','as','at','after',
					'b','be','by','back','but',
					'c','com','could',
					'd','de',
					'e','en','even','evens',
					'f','for','from','first','firstly',
					'g','good','great','grand','get','go',
					'h','how','his','her','have','having','haven\'t',
					'i','in','is','it','into','if','item',
					'j',
					'k',
					'l','la','li','list',
					'm',
					'n',
					'o','of','on','or','out','our','other','others','odd','odds',
					'p','people',
					'q',
					'r',
					's','so','some','say','see','she','she\'ll',
					'strong',
					't','that','the','this','to','the','their','there','they\'re','two',
					'them','tags','tag',
					'then','than','thus','thusly','they','them','than',
					'u','und','up','use',
					'v',
					'w','was','what','when','where','who','will','with','www',
					'whose','who\'s','whom','we','work','which','whichever',
					'well','we\'ll','wouldn\'t','wasn\'t','way','ways',
					'x',
					'y','year','your','you\re','your','yours','you',
					'z'
				);
			   
				$string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
				$string = trim($string); // trim the string
				$string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
				$string = strtolower($string); // make it lowercase
			   
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
				$wordCountArr = array_slice($wordCountArr, 0, 1);
				return $wordCountArr;
			}
	
		// Add twitter fields to profile and general settings
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
		
		// Disable author archive if only one author
		function mom_grab_author_count() {
			$authorsCounted = 0;
			global $wpdb;
			$countAuthors = (array) $wpdb->get_results("
					SELECT DISTINCT(post_author)
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
		
		// Disable date-based archives
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

				
		
		// Conditional open graph and meta tag handling
		function mom_meta_module() {
		global $post;
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
			}			
			if ( $twitter_site_content != "" ) { 
				$Twitter_site         = "<meta name=\"twitter:site\" value=\"" . $twitter_site_content . "\">\n"; 
			}
			if ( $twitter_personal_content != "" ) { 
				$Twitter_author       = "<meta name=\"twitter:creator\" value=\"" . $twitter_personal_content . "\">\n"; 
			}
			
			if ( is_single() || is_page() ) {
			    echo "\n";
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
		
		// Append a backlink to every item in each feed, so that scrapers that steal your content
		// will also link back to you.
		function momSEOfeed($content) {
			return $content . "<p><a href=\"" . esc_url( get_permalink( $post->ID ) ) . "\">" . htmlentities( get_post_field('post_title', $postid) ) . "</a> via <a href=\"" . esc_url( home_url('/') ) . "\">" . get_bloginfo( 'site_name' ) . "</a></p>";
		}
		add_filter('the_content_feed', 'momSEOfeed');
		add_filter('the_excerpt_rss',  'momSEOfeed');		
		
		// Move Javascripts to the footer (also does it in a way that will not conflict with other scripts that are loaded by certain 
		// modules of this plugin - like Jump Around and Lazy Load.
		function momSEOheadscripts() {
			remove_action('wp_head', 'wp_print_scripts'); 
			remove_action('wp_head', 'wp_print_head_scripts', 9); 
			remove_action('wp_head', 'wp_enqueue_scripts', 1); 			
		}
		add_action( 'wp_enqueue_scripts', 'momSEOheadscripts' );
		add_action( 'wp_footer', 'wp_print_scripts', 5);
		add_action( 'wp_footer', 'wp_enqueue_scripts', 5);
		add_action( 'wp_footer', 'wp_print_head_scripts', 5);
		
		// Find the focus word of our post
		// Compare the content of the post against the words that it has been tagged with 
		// to find the most used word in the post that matches one of the tags
		// and use it as the single keyword for the post 
		function momFindfocus( ) {
			global $post;
			if ( is_single() ) { 
				$content            = get_post_field( 'post_content', $postid );
				$words              = extractCommonWords($content);
				$focusWord          = implode(array_keys($words));
				$theTags = get_the_tags($post->ID);
				if ($theTags) {
				foreach($theTags as $tag) {
					$focusedTagLink = get_tag_link($tag->term_id);
					$focusedTag     = strtolower($tag->name); 
					$focusedWord    = $focusWord;
					if ($focusedTag === $focusedWord ) { $theFocusWord = '<a href="' . $focusedTagLink . '">' . $tag->name  . '</a>'; }
					else { $theFocusWord = $focusWord; }
				}
				}			
				if ( $theFocusWord != '' ) {
					echo "<meta name=\"keywords\" content=\"" . $theFocusWord . "\"/>\n";
				}
			}		
		}
		add_filter( 'wp_head', 'momFindfocus' );
		
	}
		
		
	mom_SEO_header();

?>