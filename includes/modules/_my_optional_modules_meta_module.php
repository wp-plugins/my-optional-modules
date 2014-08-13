<?php 

if(!defined('MyOptionalModules')){die();}
function myoptionalmodules_metainformation(){
	global $wp,$post;
	if( $post  ) $postid = $post->ID;
	if( !$post ) $postid = 0;
	$theExcerpt = '';
	$theFeaturedImage = '';
	$Twitter_start = '';
	$Twitter_site = '';
	$Twitter_author = '';
	if( $post  ) $authorID = $post->post_author;
	if( !$post ) $authorID = 0;
	$excerpt_from = get_post($postid);
	$post_title = get_post_field('post_title',$postid);
	$post_content = get_post_field('post_content',$postid);
	$publishedTime = get_post_field('post_date',$postid);
	$modifiedTime = get_post_field('post_modified',$postid);
	if( $post  ) $post_link = get_permalink($post->ID);
	if( !$post ) $post_link = 0;
	$sitename_content = get_bloginfo('site_name');
	$description_content = get_bloginfo('description');
	$theAuthor_first = get_the_author_meta('user_firstname',$authorID);
	$theAuthor_last = get_the_author_meta('user_lastname',$authorID);
	$theAuthor_nice = get_the_author_meta('user_nicename',$authorID);
	$twitter_personal_content = get_the_author_meta('twitter_personal',$authorID);
	$twitter_site_content = get_option('site_twitter');
	$locale_content = get_locale();
	if( $post  ) $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
	if( !$post ) $featured_image = 0;
	$featuredImage = $featured_image[0];
	$currentURL = add_query_arg($wp->query_string,'',home_url($wp->request));
	$excerpt = get_post_field('post_content', $postid);
	$excerpt = strip_tags($excerpt);
	$excerpt = esc_html($excerpt);
	$excerpt = preg_replace('/\s\s+/i','',$excerpt);
	$excerpt = substr($excerpt,0,155);
	$excerpt_short = substr($excerpt,0,strrpos($excerpt,' ')).'...';
	$excerpt_short = preg_replace('@\[.*?\]@','', $excerpt);		
	if($excerpt_short != ''){$theExcerpt = '<meta property="og:description" content="'.$excerpt_short.'"/>';}
	if($featuredImage != ''){$theFeaturedImage = '<meta property="og:image" content="'.$featuredImage.'"/>';}
	if($twitter_personal_content != '' || $twitter_site_content != ''){$Twitter_start = '<meta name="twitter:card" value="summary">';}
	if($twitter_site_content != ''){$Twitter_site = '<meta name="twitter:site" value="'.$twitter_site_content.'">';}
	if($twitter_personal_content != ''){$Twitter_author = '<meta name="twitter:creator" value="'.$twitter_personal_content.'">';}
	if(is_single() || is_page()){
		echo '
		<meta property="og:author" content="'.$theAuthor_first.' '.$theAuthor_last.' ('.$theAuthor_nice.') "/>
		<meta property="og:title" content="';wp_title('|',true,'right');echo'"/>
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
	}else{
		echo '
		<meta property="og:description" content="'.$description_content.'"/>
		<meta property="og:title" content="';wp_title('|',true,'right');echo '"/>
		<meta property="og:locale" content="'.$locale_content.'"/>
		<meta property="og:site_name" content="'.get_bloginfo('site_name').'"/>
		<meta property="og:url" content="'.esc_url($currentURL).'"/>
		<meta property="og:type" content="website"/>
		';
	}
	if(is_search() || is_404() || is_archive())echo '<meta name="robots" content="noindex,nofollow"/>';
}
if ( !function_exists ( 'myoptionalmodules_add_fields_to_profile' ) ) {
	function myoptionalmodules_add_fields_to_profile($profile_fields){
		$profile_fields['twitter_personal'] = 'Twitter Username';
		return $profile_fields;
	}
}
if ( !function_exists ( 'myoptionalmodules_add_fields_to_general' ) ) {
	function myoptionalmodules_add_fields_to_general(){
		register_setting('general','site_twitter','esc_attr');
		add_settings_field('site_twitter','<label for="site_twitter">'.__('Twitter Site username','site_twitter').'</label>' ,'myoptionalmodules_add_twitter_to_general_html','general');
	}
}
if ( !function_exists ( 'myoptionalmodules_add_twitter_to_general_html' ) ) {
	function myoptionalmodules_add_twitter_to_general_html(){
		$twitter = get_option('site_twitter','');
		echo '<input id="site_twitter" name="site_twitter" value="'.$twitter.'"/>';
	}
}
add_filter('admin_init', 'myoptionalmodules_add_fields_to_general');
add_filter('user_contactmethods', 'myoptionalmodules_add_fields_to_profile');
add_filter('jetpack_enable_opengraph', '__return_false', 99);
add_action('wp_head', 'myoptionalmodules_metainformation');