<?php 

/**
 * My Optional Modules Functions
 *
 * (1) Functions used throughout the plugin.
 *
 * @package regular_board
 */	

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}


/**
 *
 * Admin Stylesheet
 * Only enqueue it if we're browsing the admin page for My Optional Modules
 *
 */
if ( !function_exists ( 'my_optional_modules_stylesheets' ) ) {

	function my_optional_modules_stylesheets( $hook ){

		if( 'settings_page_mommaincontrol' != $hook )
		return;
		wp_register_style ( 'mom_admin_css', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/adminstyle/css.css' );
		wp_register_style ( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style  ( 'font_awesome' );
		wp_enqueue_style  ( 'mom_admin_css' );

	}

}

/**
 *
 * Font Awesome CSS enqueue
 *
 */
if ( !function_exists ( 'my_optional_modules_font_awesome' ) ) {

	function my_optional_modules_font_awesome() {

		wp_register_style ( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style ( 'font_awesome' );

	}

}

/**
 *
 * My Optional Modules stylesheet used throughout for the different modules
 *
 */
if ( !function_exists ( 'my_optional_modules_main_stylesheet' ) ) {

	function my_optional_modules_main_stylesheet() {

		$myStyleFile = WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules05568.css';
		wp_register_style ( 'my_optional_modules', $myStyleFile );
		wp_enqueue_style ( 'my_optional_modules' );

	}

}

	// http://davidwalsh.name/wordpress-ajax-comments
	function mom_ajaxComment($comment_ID, $comment_status) {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			$comment = get_comment($comment_ID);
			wp_notify_postauthor($comment_ID, $comment->comment_type);
			$commentContent = getCommentHTML($comment);
			die($commentContent);
		}
	}	
	function mom_limit_comment($comment) {
		$limit = intval(get_option('MOM_themetakeover_commentlength'));
		if($limit && $limit > 0 ) {
			$comment = strip_tags( htmlentities( substr( $comment,0,$limit ) ) );
			return $comment;
		}
	}
	function mom_limit_comment_field($comment_field) {
		$limit = intval(get_option('MOM_themetakeover_commentlength'));
		if( $limit > 0 ) {
			$limit = ' maxlength="' . intval(get_option('MOM_themetakeover_commentlength')) . '"';
		} else {
			$limit = '';
		}
		$comment_field =
			'<p class="comment-form-comment">
				<textarea required' . $limit . 'id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
			</p>';
		return $comment_field;
	}
	add_filter('comment_form_field_comment','mom_limit_comment_field');

	// Exclude -> Hide Dash (from user levels below 7)
	if( !function_exists( 'mom_remove_the_dashboard' ) ) {
		if( $user_level < 7 && get_option( 'MOM_Exclude_Hide_Dashboard' ) ) {
			function mom_remove_the_dashboard(){
				global $menu, $submenu, $user_ID;
				$the_user = new WP_User ( $user_ID );
				reset ( $menu ); $page = key ( $menu );
				while ( ( __ ( 'Dashboard' ) != $menu[$page][0] ) && next ( $menu ) )
				$page = key ( $menu );
				if ( __ ( 'Dashboard' ) == $menu[$page][0] ) unset ( $menu[$page] );
				reset ( $menu ); $page = key ( $menu );
				while( !$the_user->has_cap ( $menu[$page][1] ) && next( $menu ) )
				$page = key ( $menu );
				if ( preg_match ( '#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI'] ) && ( 'index.php' != $menu[$page][2] ) )
				wp_redirect ( get_option ( 'siteurl' ) . '/wp-admin/profile.php' );
			}
			add_action ( 'admin_menu', 'mom_remove_the_dashboard' );
		}
	}

	// Takeover -> Custom BG Image
	if( !function_exists( 'MOM_themetakeover_backgroundimage' ) ) {
		if( get_option( 'MOM_themetakeover_backgroundimage' ) ) {
			$backgroundargs = array( 
				'default-image'          => '',
				'default-color'          => '',
				'wp-head-callback'       => '_custom_background_cb',
				'admin-head-callback'    => '',
				'admin-preview-callback' => ''
			);
			add_theme_support( 'custom-background', array(
				'default-color' => 'fff',
			) );
		}
	}
	
	// RSS feed (link back)
	if( !function_exists( 'myoptionalmodules_rsslinkback' ) ) { 
		function myoptionalmodules_rsslinkback($content){
			return $content.'<p><a href="'.esc_url(get_permalink($post->ID)).'">'.htmlentities(get_post_field('post_title',$postid)).'</a> via <a href="'.esc_url(home_url('/')).'">'.get_bloginfo('site_name').'</a></p>';
		}
	}

	// JS to Footer (moves javascript to footer)
	if( !function_exists( 'myoptionalmodules_footerscripts' ) ) {
		function myoptionalmodules_footerscripts(){
			remove_action( 'wp_head','wp_print_scripts' );
			remove_action( 'wp_head','wp_print_head_scripts',9 );
			remove_action( 'wp_head','wp_enqueue_scripts',1 );
		}
	}
	
	// Disable Authors (archives)(if there is only 1 author on the blog)
	if( !function_exists( 'myoptionalmodules_disableauthorarchives' ) ) {
		function myoptionalmodules_disableauthorarchives(){
			global $wp_query;
			if( is_author() ) {
				if( sizeof( get_users( 'who=authors' ) ) ===1 )
				wp_redirect( get_bloginfo( 'url' ) );
			}
		}
	}
	
	// Disable Date (based archives)
	if( !function_exists( 'myoptionalmodules_disabledatearchives' ) ) {
		function myoptionalmodules_disabledatearchives(){
			global $wp_query;
			if( is_date() || is_year() || is_month() || is_day() || is_time() || is_new_day() ) {
				$homeURL = esc_url(home_url('/'));
				if( have_posts() ):the_post();
				header('location:'.$homeURL);
				exit;
				endif;
			}
		}
	}

	// Stripping paint with a flamethrower.
	// Sanitize_text_field->strip_tags->htmlentities->string
	if( !function_exists( 'myoptionalmodules_sanistripents' ) ) {
		function myoptionalmodules_sanistripents($string){
			return sanitize_text_field( strip_tags( htmlentities( $string ) ) );
		}
	}

	// Take an alphanumeric string, return only numbers, take out any spaces.
	if( !function_exists( 'myoptionalmodules_numbersnospaces' ) ) {
		function myoptionalmodules_numbersnospaces($string){
			return sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',($string)))))));
		}
	}

if ( !function_exists ( 'myoptionalmodules_excludecategories' ) ) {
	function myoptionalmodules_excludecategories(){
		if($mommodule_exclude == 1){
			get_currentuserinfo();
			global $user_level;
			$nofollowCats = array('0');
			if(!is_user_logged_in()){
				$nofollowCats = get_option('MOM_Exclude_VisitorCategories').','.get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');	
			}
			if(is_user_logged_in()){
				if($user_level == 0){$nofollowCats = get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
				if($user_level <= 1){$nofollowCats = get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
				if($user_level <= 2){$nofollowCats = get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
				if($user_level <= 7){$nofollowCats = get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
			}
			$c1 = explode(',',$nofollowCats);
			foreach($c1 as &$C1){$C1 = ''.$C1.',';}
			$c_1 = rtrim(implode($c1),',');
			$c11 = explode(',',str_replace(' ','',$c_1));
			$c11array = array($c11);
			$array = array('0');
			$nofollowcats = array_filter($c11);
		}
		$category_ids = get_all_category_ids();
		foreach($category_ids as $cat_id){
			if($nofollowcats != ''){
				if(in_array($cat_id, $nofollowcats))continue;
			}
			$cat = get_category($cat_id);
			$link = get_category_link($cat_id);
			echo '<li><a href="'.$link.'" title="link to '.$cat->name.'">'.$cat->name.'</a></li>';
		}
	}
}


	
if ( get_option ( 'mommaincontrol_momse' ) == 1 && !get_option ( 'MOM_themetakeover_youtubefrontpage' ) ) {
	if ( !function_exists ( 'myoptionalmodules_404Redirection' ) ) {
		function myoptionalmodules_404Redirection(){
			if ( is_user_logged_in() ) {
				if ( get_option ( 'MOM_Exclude_URL' ) == 'NULL' ) {
					
				} else { 
					if ( get_option ( 'MOM_Exclude_URL' ) ) { 
						$RedirectURL = esc_url ( get_permalink ( get_option ( 'MOM_Exclude_URL' ) ) ); 
					} else { 
						$RedirectURL = get_bloginfo ( 'wpurl' );
					}
					global $wp_query;
					if($wp_query->is_404){
						wp_redirect($RedirectURL,301);exit;
					}
				}
			}else{
				if ( get_option ( 'MOM_Exclude_URL_User' ) == 'NULL' ) {
					
				} else {
					if ( get_option ( 'MOM_Exclude_URL_User' ) ) { 
						$RedirectURL = esc_url ( get_permalink ( get_option ( 'MOM_Exclude_URL_User' ) ) ); 
					} else { 
						$RedirectURL = get_bloginfo ( 'wpurl' );
					}
					global $wp_query;
					if($wp_query->is_404){
						wp_redirect($RedirectURL,301);exit;
					}
				}
			}
		}
		add_action('wp','myoptionalmodules_404Redirection',1);
	}
}
	
if ( !function_exists ( 'myoptionalmodules_postasfront' ) ) {
	function myoptionalmodules_postasfront(){	
		if(is_home()){
			if(get_option('mompaf_post') == 'off'){
				// Do nothing
			}elseif(is_numeric(get_option('mompaf_post'))){
				$mompaf_front = get_option('mompaf_post');
			}elseif(get_option('mompaf_post') == 'on'){
				$mompaf_front = '';
			}
			if(have_posts()):the_post();
			header('location:'.esc_url(get_permalink($mompaf_front)));exit;endif;
		}
	}
}

if ( !function_exists ( 'momMaintenance' ) ) {
	function momMaintenance(){
		if(!function_exists('is_login_page')){
			function is_login_page() {
				return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
			}		
		}
		if(!is_login_page()){
			if(!is_user_logged_in() && get_option('mommaincontrol_maintenance') == 1){
				$maintenanceURL = esc_url(get_option('momMaintenance_url'));
				if($maintenanceURL == ''){
					die('Maintenance mode currently active.  Please try again later.');
				}else{
					header('location:'.$maintenanceURL);exit;
				}
			}
		}
	}
}

if ( !function_exists ( 'myoptionalmodules_removeversion' ) ) {
	function myoptionalmodules_removeversion($src){
		if(strpos($src,'ver='.get_bloginfo('version')))
			$src = remove_query_arg('ver',$src);
		return $src;
	}
}

if ( !function_exists ( 'myoptionalmodules_scripts' ) ) {
	function myoptionalmodules_scripts(){
		wp_register_style('font_awesome', plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.min.css');
		wp_enqueue_style('font_awesome');
	}
}

if ( !function_exists ( 'myoptionalmodules_postformats' ) ) {
	function myoptionalmodules_postformats(){
		add_theme_support('post-formats', array('aside','gallery','link','image','quote','status','video','audio','chat'));
	}
}