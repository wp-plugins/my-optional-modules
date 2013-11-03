<?php

	function mom_SEO_header() {
		global $post;

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
			$authorID                 = $post->post_author;
			$excerpt_from             = get_post( $postid ); 
			$postid                   = $post->ID;
			$post_title               = get_post_field( 'post_title', $postid );			
			$post_content             = get_post_field( 'post_content', $postid );
			$publishedTime            = get_post_field( 'post_date', $postid );
			$modifiedTime             = get_post_field( 'post_modified', $postid );
			$post_link                = get_permalink( $post->ID );
			$sitename_content         = get_bloginfo( 'site_name' );
			$description_content      = get_bloginfo( 'description' );
			$theAuthor_first          = get_the_author_meta( 'user_firstname', $authorID );
			$theAuthor_last           = get_the_author_meta( 'user_lastname', $authorID );
			$theAuthor_nice           = get_the_author_meta( 'user_nicename', $authorID );
			$twitter_personal_content = get_the_author_meta( 'twitter_personal', $authorID );
			$twitter_site_content     = get_option( 'site_twitter' );
			$locale_content           = get_locale();
			$featured_image           = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );	
			$featuredImage            = $featured_image[0];
			$currentURL               = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
			$excerpt                  = get_post_field( 'post_content', $postid );
			$excerpt                  = htmlentities($excerpt);
			$excerpt                  = substr( $excerpt,0,155 );
			$excerpt_short            = substr( $excerpt, 0, strrpos( $excerpt,' ')).'...';
			
			
	
			if ( $excerpt_short != "" ) { 
				$theExcerpt           = "<meta property=\"og:description\" content=\"" . $excerpt_short . "\"/>\n";
			} else {
				$theExcerpt           = "";
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
				echo "<meta property=\"og:author\" content=\"" . $theAuthor_first . " " . $theAuthor_last . " (" . $theAuthor_nice . ")" . "\"/>\n";
				echo "<meta property=\"og:title\" content=\""; wp_title( '|', true, 'right' ); echo "\"/>\n";
				echo "<meta property=\"og:site_name\" content=\"" . get_bloginfo( 'site_name' ) . "\"/>\n";
				echo $theExcerpt . "";
				echo "<meta property=\"og:entry-title\" content=\"" . htmlentities( get_post_field('post_title', $postid) ) . "\"/>\n";
				echo "<meta property=\"og:locale\" content=\"" . $locale_content . "\"/>\n";
				echo "<meta property=\"og:published_time\" content=\"" . $publishedTime . "\"/>\n";
				echo "<meta property=\"og:modified_time\" content=\"" . $modifiedTime . "\"/>\n";
				echo "<meta property=\"og:updated\" content=\"" . $modifiedTime . "\"/>\n";
				$category_names=get_the_category($postid);
				foreach($category_names as $categoryNames){
					echo "<meta property=\"og:section\" content=\"" . $categoryNames->cat_name . "\"/>\n";
				}			
				$tagNames = get_the_tags($postid);
				if ($tagNames) {
					foreach($tagNames as $tagName) {
						echo "<meta property=\"og:article:tag\" content=\"" . $tagName->name . "\"/>\n";
					}
				}	
				echo "<meta property=\"og:url\" content=\"" . esc_url( get_permalink( $post->ID ) ) . "\"/>\n";
				echo "<meta property=\"og:type\" content=\"article\"/>\n";
				echo $theFeaturedImage;
                echo $Twitter_start;
				echo $Twitter_site;
				echo $Twitter_author;
			} else {
				echo "<meta property=\"og:description\" content=\"" . $description_content . "\"/>\n";
				echo "<meta property=\"og:title\" content=\""; wp_title( '|', true, 'right' ); echo "\"/>\n";
				echo "<meta property=\"og:locale\" content=\"" . $locale_content . "\"/>\n";
				echo "<meta property=\"og:site_name\" content=\"" . get_bloginfo( 'site_name' ) . "\"/>\n";
				echo "<meta property=\"og:url\" content=\"" . esc_url( $currentURL ) . "\"/>\n";
				echo "<meta property=\"og:type\" content=\"website\"/>\n";
			}
			
			if ( is_search() || is_404() || is_archive() ) {
				echo "<meta name=\"robots\" content=\"noarchive\"/>\n";
				echo "<meta name=\"robots\" content=\"nofollow\"/>\n";
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
			if ( is_single() ) {
			$postid                   = $post->ID;
			$post_title               = get_post_field( 'post_title', $postid );			
			function extractCommonWords($string){
				global $post;
				$postid         = $post->ID;
				$post_title     = get_post_field( 'post_title', $postid );			
				$postTitle      = strtolower( $post_title);
				$wordsInTitle   = preg_replace("/[^\w\ _]+/", '', $postTitle); // strip all punctuation characters, news lines, etc.
				$wordsInTitle   = preg_split("/\s+/", $postTitle); // split by left over spaces				
				$wordsInTitle   = preg_replace('/\"/','',$wordsInTitle);
				
				$htmlElementsToIgnore = array(
					"html","body","div","span","object","iframe",
					"h1","h2","h3","h4","h5","h6","p","blockquote","pre",
					"abbr","address","cite","code",
					"del","dfn","em","img","ins","kbd","q","samp",
					"small","strong","sub","sup","var",
					"b","i","dl","dt","dd","ol","ul","li",
					"fieldset","form","label","legend",
					"table","caption","tbody","tfoot","thead","tr","th","td",
					"article","aside","canvas","details","figcaption","figure", 
					"footer","header","hgroup","menu","nav","section","summary",
					"time","mark","audio","video",
					"nav","style","hr","input","title","category"
				);
				
				// Could use some more common words to weed out stupid keywords
				$wordsToSkip = array(
					"a","about","an","and","are","as","at","after",
					"article","aside","anything","actually","actuality","actual",
					"around",
					"b","be","by","back","but","been","being","biz",
					"c","com","could","come","class",
					"d","de","didn't","div","details",
					"e","en","even","evens","eight","ever","everyone","everyone's",
					"everyones","every",
					"f","for","from","first","firstly","four","five",
					"figure","footer",
					"g","good","great","grand","get","go",
					"h","how","his","her","have","having","haven't",
					"header","html",
					"i","in","is","it","into","if","item","id","img",
					"important",
					"j","just","jest",
					"k",
					"l","la","li","list","like","laid","lie","lay","lying",
					"less",
					"m","more",
					"n","never","nine","net","nav","needs","need","needing","needy","needed",
					"o","of","on","or","out","our","other","others","odd","odds",
					"object","org","ol",
					"p","people","perhaps","place","pre","post",
					"q",
					"r",
					"s","so","some","say","see","she","she'll","six","seven",
					"same",
					"summary","section","slightly","seen",
					"strong","speaks","speak","speaking","spoken","spake",
					"somebody","somebodies","somebody's","somebodys",
					"should","shoulda","should've","still",
					"t","that","the","this","to","the","their","there","they're","two",
					"till","those","these","time","things","take","taking","taken","took",
					"takes","together","thee","thy","thou",
					"too","three","ten","think","them","tags","tag",
					"then","than","thus","thusly","they","them","than",
					"u","und","up","use","ul","used","using","uses",
					"v",
					"w","was","what","when","where","who","will","with","www",
					"whose","who's","whom","we","work","which","whichever",
					"wanted","wanting","wants","want",
					"well","we'll","wouldn't","wasn't","way","ways","writing",
					"would","woulda","were","weren't","werent",
					"written",
					"x",
					"y","year","your","you're","your","yours","you","you've",
					"youre","youve",
					"z"
				);
				$stopWords = array_merge($wordsInTitle, $wordsToSkip, $htmlElementsToIgnore);
				$string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
				$string = trim($string); // trim the string
				$string = preg_replace('/\[.+\]/U', '', $string);
				$string = preg_replace('/<(pre)(?:(?!<\/\1).)*?<\/\1>/s','',$string); // don't look between <pre></pre> tags
				$string = preg_replace('/<(a)(?:(?!<\/\1).)*?<\/\1>/s','',$string); // don't look between <pre></pre> tags				
				$string = preg_replace('/[^\s\S]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
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
				$wordCountArr = array_slice($wordCountArr, 0, 5);
				return $wordCountArr;
			}			
				$content            = get_post_field( 'post_content', $postid );
				$words              = extractCommonWords($content);
				$focusWord          = implode(',', array_keys($words));
				echo "<meta name=\"keywords\" content=\"" . $focusWord . "\"/>\n";				
			}		
		}
		add_filter( 'wp_head', 'momFindfocus' );
	}
	
	mom_SEO_header();

?>