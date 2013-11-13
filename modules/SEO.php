<?php
	function mom_SEO_header(){
		global $post;
		if(is_admin()){
			function momSEO_add_fields_to_profile($profile_fields){
				$profile_fields['twitter_personal'] = 'Twitter Username';
				return $profile_fields;
			}
			function momSEO_add_fields_to_general(){
				register_setting('general','site_twitter','esc_attr');
				add_settings_field('site_twitter','<label for="site_twitter">'.__('Twitter Site username','site_twitter' ).'</label>' ,'mom_SEO_add_twitter_to_general_html','general');
			}
			function mom_SEO_add_twitter_to_general_html(){
			$twitter = get_option('site_twitter','');
			echo '<input id="site_twitter" name="site_twitter" value="'.$twitter.'"/>';
			}
			add_filter('admin_init', 'momSEO_add_fields_to_general');
			add_filter('user_contactmethods', 'momSEO_add_fields_to_profile');
		}
		function mom_grab_author_count()
		{
			if(is_author())
			{
				if(sizeof(get_users())===1)
					wp_redirect(get_bloginfo('url'));
			}
		}
		add_action( 'template_redirect', 'mom_grab_author_count' );
		
		function momSEO_disable_date_based_archives(){
			if(is_date() || is_year() || is_month() || is_day() || is_time() || is_new_day()){
				$homeURL = esc_url(home_url('/'));
				if(have_posts()):the_post();
				header('location:'.$homeURL);
				exit;
				endif;
			}
		}
		add_action('wp','momSEO_disable_date_based_archives');
		function mom_meta_module(){
			global $post;
			$theExcerpt = '';
			$theFeaturedImage = '';
			$Twitter_start = '';
			$Twitter_site = '';
			$Twitter_author = '';
			$authorID = $post->post_author;
			$excerpt_from = get_post($postid);
			$postid = $post->ID;
			$post_title = get_post_field('post_title',$postid);
			$post_content = get_post_field('post_content',$postid);
			$publishedTime = get_post_field('post_date',$postid);
			$modifiedTime = get_post_field('post_modified',$postid);
			$post_link = get_permalink($post->ID);
			$sitename_content = get_bloginfo('site_name');
			$description_content = get_bloginfo('description');
			$theAuthor_first = get_the_author_meta('user_firstname',$authorID);
			$theAuthor_last = get_the_author_meta('user_lastname',$authorID);
			$theAuthor_nice = get_the_author_meta('user_nicename',$authorID);
			$twitter_personal_content = get_the_author_meta('twitter_personal',$authorID);
			$twitter_site_content = get_option('site_twitter');
			$locale_content = get_locale();
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'single-post-thumbnail');
			$featuredImage = $featured_image[0];
			$currentURL = add_query_arg($wp->query_string,'',home_url($wp->request));
			$excerpt = get_post_field('post_content', $postid);
			$excerpt = strip_tags($excerpt );
			$excerpt = esc_html($excerpt);
			$excerpt = preg_replace('/\s\s+/i','',$excerpt);
			$excerpt = substr($excerpt,0,155 );
			$excerpt_short = substr( $excerpt,0,strrpos($excerpt,' ')).'...';
			if($excerpt_short != ''){$theExcerpt = '<meta property="og:description" content="'.$excerpt_short.'"/>';}
			if($featuredImage != ''){$theFeaturedImage = '<meta property="og:image" content="'.$featuredImage.'"/>';}
			if($twitter_personal_content != '' || $twitter_site_content != ''){$Twitter_start = '<meta name="twitter:card" value="summary">';}
			if($twitter_site_content != ''){$Twitter_site = '<meta name="twitter:site" value="'.$twitter_site_content.'">';}
			if($twitter_personal_content != ''){$Twitter_author = '<meta name="twitter:creator" value="'.$twitter_personal_content.'">';}
			if(is_single() || is_page()){
				echo '
				<meta property="og:author" content="'.$theAuthor_first.' '.$theAuthor_last.' ('.$theAuthor_nice.') "/>
				<meta property="og:title" content="';wp_title( '|',true,'right');echo'"/>
				<meta property="og:site_name" content="'.get_bloginfo('site_name').'"/>
				'.$theExcerpt.'
				<meta property="og:entry-title" content="'.htmlentities(get_post_field('post_title',$postid)).'"/>
				<meta property="og:locale" content="'.$locale_content.'"/>
				<meta property="og:published_time" content="'.$publishedTime.'"/>
				<meta property="og:modified_time" content="'.$modifiedTime.'"/>
				<meta property="og:updated" content="'.$modifiedTime.'"/>';
				$category_names=get_the_category($postid);
				foreach($category_names as $categoryNames){
					echo '
					<meta property="og:section" content="'.$categoryNames->cat_name.'"/>';
				}
				$tagNames = get_the_tags($postid);
				if($tagNames){
					foreach($tagNames as $tagName){
						echo '
						<meta property="og:article:tag" content="'.$tagName->name.'"/>';
					}
				}
				echo '
				<meta property="og:url" content="'.esc_url(get_permalink($post->ID)).'"/>
				<meta property="og:type" content="article"/>
				'.$theFeaturedImage.'
				'.$Twitter_start.'
				'.$Twitter_site.'
				'.$Twitter_author.'
				';
			} else {
				echo '
				<meta property="og:description" content="'.$description_content.'"/>
				<meta property="og:title" content="';wp_title('|',true,'right');echo '"/>
				<meta property="og:locale" content="'.$locale_content.'"/>
				<meta property="og:site_name" content="'.get_bloginfo('site_name').'"/>
				<meta property="og:url" content="'.esc_url($currentURL).'"/>
				<meta property="og:type" content="website"/>
				';
			}
			if(is_search() || is_404() || is_archive()){
				echo '
				<meta name="robots" content="noarchive"/>
				<meta name="robots" content="nofollow"/>
				';
			}
		}
		add_action('wp_head','mom_meta_module');
		function momSEOfeed($content){
			return $content.'<p><a href="'.esc_url(get_permalink($post->ID)).'">'.htmlentities(get_post_field('post_title',$postid)).'</a> via <a href="'.esc_url(home_url('/')).'">'.get_bloginfo('site_name').'</a></p>';
		}
		add_filter('the_content_feed','momSEOfeed');
		add_filter('the_excerpt_rss','momSEOfeed');
		function momSEOheadscripts(){
			remove_action('wp_head','wp_print_scripts');
			remove_action('wp_head','wp_print_head_scripts',9);
			remove_action('wp_head','wp_enqueue_scripts',1);
		}
		add_action('wp_enqueue_scripts','momSEOheadscripts');
		add_action('wp_footer','wp_print_scripts',5);
		add_action('wp_footer','wp_enqueue_scripts',5);
		add_action('wp_footer','wp_print_head_scripts',5);
		add_filter('jetpack_enable_opengraph', '__return_false',99);
	}
	mom_SEO_header();
?>