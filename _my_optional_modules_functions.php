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

// (1) Calculate time between (date) and (date)
if( !function_exists( 'mom_timesince' ) ) {

	function mom_timesince( $date, $granularity=2 ) {

		$retval     = '';
		$date       = strtotime( $date );
		$difference = time() - $date;
		
		$periods = array(

			' decades' => 315360000, 
			' years' => 31536000, 
			' months' => 2628000, 
			' weeks' => 604800,  
			' days' => 86400, 
			' hours' => 3600, 
			' minutes' => 60, 
			' seconds' => 1 

		);

		foreach( $periods as $key => $value ) {

			if( $difference >= $value ) {

				$time = floor ( $difference/$value );
				$difference %= $value;
				$retval .= ( $retval ? ' ' : '' ) . $time . '';
				$retval .= ( ( $time > 1 ) ? $key : $key );
				$granularity--;

			}

			if( $granularity == '0' ) {

				break; 

			}

		}

		return $retval . ' ago';

	}	
}

/**
 *
 * Count++ Functionality
 * Template functions
 *
 * obwcountplus_total()     :: prints single post word count
 * countsplusplus()         :: prints custom output (set above)
 * obwcountplus_count()     :: prints the total words + remaining (of goal)
 * obwcountplus_total()     :: prints the total words
 * obwcountplus_remaining() :: prints the remaining (or the total if the goal was reached)
 *
 */
if( $mommodule_count == 1 ) {

	if( !function_exists( 'countsplusplus' ) ) {

		function countsplusplus() {

			$oldcount = 0;
			
			global $wpdb;
			
			$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
			$words = $wpdb->get_results( $query );

			if( $words ) {

				foreach( $words as $word ) {

					$post       = strip_tags( $word->post_content );
					$post       = explode( ' ',$post );
					$count      = count( $post );
					$totalcount = $count + $oldcount;
					$oldcount   = $totalcount;

				}

			} else {

				$totalcount=0;

			}

			$remain	   = number_format( get_option( 'obwcountplus_1_countdownfrom' ) - $totalcount );
			$c_custom  = sanitize_text_field( htmlentities( get_option( 'obwcountplus_4_custom' ) ) );
			$c_search  = array( '%total%', '%remain%' );
			$c_replace = array( $totalcount, $remain );
			
			echo str_replace( $c_search, $c_replace, $c_custom );

		}

	}

	if( !function_exists( 'obwcountplus_single' ) ) {

		function obwcountplus_single() {

			$oldcount = 0;

			global $wpdb, $post;

			$postid	= $post->ID;

			$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND ID = '$postid'";
			$words = $wpdb->get_results( $query );

			if( $words ) {

				foreach( $words as $word ) {
					$post       = strip_tags( $word->post_content );
					$post       = explode( ' ', $post );
					$count      = count( $post );
					$totalcount = $count + $oldcount;
					$oldcount   = $totalcount;

				}

			} else {

				$totalcount = 0;

			}

			if( is_single() ) {
				echo esc_attr( number_format( $totalcount ) );

			}

		}

	}
	
	if( !function_exists( 'obwcountplus_remaining' ) ) {

		function obwcountplus_remaining() {

			$oldcount = 0;

			global $wpdb;

			$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
			$words = $wpdb->get_results( $query );

			if( $words ) {

				foreach( $words as $word ) {

					$post       = strip_tags( $word->post_content );
					$post       = explode( ' ', $post );
					$count      = count( $post );
					$totalcount = $count + $oldcount;
					$oldcount   = $totalcount;

				}

			}else{

				$totalcount=0;

			}

			if(
				$totalcount >= get_option( 'obwcountplus_1_countdownfrom' ) ||
				get_option( 'obwcountplus_1_countdownfrom' ) == 0
			 ){

				echo esc_attr(number_format($totalcount));

			} else {

				echo esc_attr( number_format( get_option( 'obwcountplus_1_countdownfrom' ) - $totalcount ) );

			}

		}

	}

	if( !function_exists( 'obwcountplus_total' ) ) {

		function obwcountplus_total() {

			$oldcount = 0;
			
			global $wpdb;
			
			$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
			$words = $wpdb->get_results( $query );

			if( $words ){

				foreach( $words as $word ) {

					$post       = strip_tags( $word->post_content );
					$post       = explode( ' ', $post );
					$count      = count($post);
					$totalcount = $count + $oldcount;
					$oldcount   = $totalcount;

				}

			} else {

				$totalcount = 0;

			}

			echo esc_attr( number_format( $totalcount ) );

		}

	}

	if( !function_exists( 'obwcountplus_count' ) ) {

		function obwcountplus_count() {

			$oldcount   = 0;
			$totalcount = 0;

			global $wpdb;
			$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
			$words = $wpdb->get_results($query);
			
			if($words){

				foreach( $words as $word ) {

					$post       = strip_tags( $word->post_content );
					$post       = explode( ' ',$post );
					$count      = count( $post );
					$totalcount = $count + $oldcount;
					$oldcount   = $totalcount;

				}

			}
			
			if(
				$totalcount >= get_option('obwcountplus_1_countdownfrom') ||
				get_option('obwcountplus_1_countdownfrom') == 0
			){

				echo esc_attr( number_format( $totalcount ) . " " . get_option( 'obwcountplus_3_total' ) );

			} else {

				echo esc_attr( number_format( get_option( 'obwcountplus_1_countdownfrom' ) - $totalcount ) . ' ' . get_option( 'obwcountplus_2_remaining' ) . ' (' . number_format( $totalcount ) . ' ' . get_option( 'obwcountplus_3_total' ) . ')' );

			}

		}

	}

}

/**
 *
 * No Comments
 * Disable comments display and form
 *
 */
if( get_option('mommaincontrol_comments') == 1){

	add_filter( 'comments_template','mom_disablecomments' );
	add_filter( 'comments_open','mom_disablecommentsform',10,2 );

	if( !function_exists( 'mom_disablecomments' ) ) {

		function mom_disablecomments( $comment_template ) {

			return dirname( __FILE__ ) . '/includes/templates/comments.php';

		}

	}
	
	if( !function_exists( 'mom_disablecommentsform' ) ) {

		function mom_disablecommentsform( $open,$post_id ) {

			$post = get_post( $post_id );
			$open = false;
			return $open;

		}

	}

}

/**
 *
 * Related posts
 * Append a list of related posts to the bottom of the post
 *
 */

	if( get_option( 'mommaincontrol_themetakeover' ) == 1 ) {
		add_filter( 'the_content', 'mom_related_posts' );
	}

	if( !function_exists( 'mom_related_posts' ) ) {

		function mom_related_posts( $content ) {

			global $post;
			$key     = sanitize_text_field ( get_option( 'MOM_themetakeover_series_key' ) );
			$style   = sanitize_text_field ( get_option( 'MOM_themetakeover_series_style' ) );
			$series  = sanitize_text_field ( get_post_meta($post->ID, $key, true) );
			
			if( $key && $style && '' != $series ) {
				
				$related = do_shortcode('[mom_miniloop meta="' . $key . '" style="' . $style . '" related="1"]');

			} else {

				$related = '';

			}

			return $content . $related;

		}

	}



/**
 *
 * Post Voting 
 * Automatically add the vote bar to the bottom of each post
 *
 */

if( $mom_votes == 1 ) {

	add_filter( 'the_content', 'mom_vote_the_post' );
	
	if( !function_exists( 'mom_grab_vote_count' ) ) {

		function mom_grab_vote_count( $id ) {

			global $wpdb;
			
			$id         = intval( $id );
			$votesPosts = $wpdb->prefix . 'momvotes_posts';
			$up         = $wpdb->get_var( "SELECT UP FROM $votesPosts WHERE ID = $id" );

			if( $up ) {
				return '<i class="fa fa-arrow-up"> ' . $up . '</i>';
			}

		}

	}
	
	if( !function_exists( 'mom_vote_the_post' ) ) {

		function mom_vote_the_post( $content ) {

			global $wpdb, $wp, $post, $ipaddress;

			$votesPosts = $wpdb->prefix . 'momvotes_posts';
			$votesVotes = $wpdb->prefix . 'momvotes_votes';

			if( $ipaddress !== false ) {

				$theIP         = esc_sql( esc_attr( $ipaddress ) );
				$theIP_s32int  = esc_sql( esc_attr( ip2long( $ipaddress ) ) );
				$theIP_us32str = esc_sql( esc_attr( sprintf( "%u", $theIP_s32int ) ) );
				$theID         = esc_sql( intval( $post->ID ) );
				$getID         = $wpdb->get_results( "SELECT ID, UP, DOWN FROM $votesPosts WHERE ID = $theID LIMIT 1" );

				if( count( $getID ) == 0 ) {

					$vote = '';
					$wpdb->query( "INSERT INTO $votesPosts ( ID, UP, DOWN ) VALUES ( $theID, 1, 0 ) " );

				}

				foreach( $getID as $gotID ) {

					$vote       = '';
					$votesTOTAL = intval( $gotID->UP + $gotID->DOWN );
					$getIP      = $wpdb->get_results( "SELECT ID, IP, VOTE FROM $votesVotes WHERE ID = '$theID' AND IP = '$theIP_us32str' LIMIT 1" );
					$up         = intval( $gotID->UP );
					$down       = intval( $gotID->DOWN );
					
					
					if( count( $getIP ) == 0 ) {

						if( isset( $_POST[$theID.'-up-submit'] ) ) {

							$wpdb->query( "UPDATE $votesPosts SET UP = UP + 1 WHERE ID = $theID" );
							$wpdb->query( "INSERT INTO $votesVotes ( ID, IP, VOTE ) VALUES ( $theID, $theIP_us32str, 1 )" );

						}
						
						if( isset( $_POST[$theID.'-down-submit'] ) ) {

							$wpdb->query( "UPDATE $votesPosts SET DOWN = DOWN + 1 WHERE ID = $theID" );
							$wpdb->query( "INSERT INTO $votesVotes ( ID, IP, VOTE ) VALUES ( $theID, $theIP_us32str, 2 )" );

						}						

						$vote = '
						<div class="vote_the_post" id="' . $theID . '">
							<form action="" id="' . $theID . '-down" method="post">
								<label for="' . $theID . '-down-submit" class="upvote">
									<i class="fa fa-arrow-down"></i>
								</label>
								<input type="submit" name="' . $theID . '-down-submit" id="' . $theID . '-down-submit" />
							</form>						
							<form action="" id="' . $theID . '-up" method="post">
								<label for="' . $theID . '-up-submit" class="upvote">
									<i class="fa fa-arrow-up"></i>
								</label>
								<input type="submit" name="' . $theID . '-up-submit" id="' . $theID . '-up-submit" />
							</form>
							<span class="voteAmount">' . $up . ' &mdash; <small>' . $votesTOTAL . ' votes</small></span>
						</div>';

					} else {

						foreach( $getIP as $gotIP ) {

							$class_up   = '';
							$class_down = '';
							$voted       = esc_sql( esc_attr( $gotIP->VOTE ) );
							
							if( $voted == 1 ) {
							
								$class_up   = ' active';
								$class_down = ' inactive';
							
							}
							
							if( $voted == 2 ) {
							
								$class_down = ' active';
								$class_up   = ' inactive';
							
							}
							
							if( $voted == 1 && isset( $_POST[$theID.'-up-submit'] ) ) {

								$wpdb->query( "UPDATE $votesPosts SET UP = UP - 1 WHERE ID = $theID" );
								$wpdb->query( "DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = $theID" );

							}

							if( $voted == 1 && isset( $_POST[$theID.'-down-submit'] ) ) {

								$wpdb->query( "UPDATE $votesPosts SET UP = UP - 1 WHERE ID = $theID" );
								$wpdb->query( "DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = $theID" );
								$wpdb->query( "UPDATE $votesPosts SET DOWN = DOWN + 1 WHERE ID = $theID" );
								$wpdb->query( "INSERT INTO $votesVotes ( ID, IP, VOTE ) VALUES ( $theID, $theIP_us32str, 2 )" );

							}							
							
							if( $voted == 2 && isset( $_POST[$theID.'-down-submit'] ) ) {

								$wpdb->query( "UPDATE $votesPosts SET DOWN = DOWN - 1 WHERE ID = $theID" );
								$wpdb->query( "DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = $theID" );

							}
							
							if( $voted == 2 && isset( $_POST[$theID.'-up-submit'] ) ) {

								$wpdb->query( "UPDATE $votesPosts SET DOWN = DOWN - 1 WHERE ID = $theID" );
								$wpdb->query( "DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = $theID" );
								$wpdb->query( "UPDATE $votesPosts SET UP = UP + 1 WHERE ID = $theID" );
								$wpdb->query( "INSERT INTO $votesVotes ( ID, IP, VOTE ) VALUES ( $theID, $theIP_us32str, 1 )" );

							}							

							$vote = '
							<div class="vote_the_post" id="' . $theID . '">
								<form action="" id="' . $theID . '-down" method="post">
									<label for="' . $theID . '-down-submit" class="upvote">
										<i class="fa fa-arrow-down' . $class_down . '"></i>
									</label>
									<input type="submit" name="' . $theID . '-down-submit" id="' . $theID . '-down-submit" />
								</form>						
								<form action="" id="' . $theID . '-up" method="post">
									<label for="' . $theID . '-up-submit" class="upvote">
										<i class="fa fa-arrow-up' . $class_up . '"></i>
									</label>
									<input type="submit" name="' . $theID . '-up-submit" id="' . $theID . '-up-submit" />
								</form>
								<span class="voteAmount">' . $up . ' &mdash; <small>' . $votesTOTAL . ' votes</small></span>
							</div>';
						
						}
						
					}

				}

			} else { 

				$vote = '';

			}

			return $content . $vote;
		}

	}

}

/**
 *
 * Admin Stylesheet
 * Only enqueue it if we're browsing the admin page for My Optional Modules
 *
 */
if( !function_exists( 'my_optional_modules_stylesheets' ) ) {

	function my_optional_modules_stylesheets( $hook ){

		if( 'settings_page_mommaincontrol' != $hook )
		return;
		wp_register_style( 'mom_admin_css', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/adminstyle/css.css' );
		wp_register_style( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'font_awesome' );
		wp_enqueue_style( 'mom_admin_css' );

	}

}

/**
 *
 * Font Awesome CSS enqueue
 *
 */
if( !function_exists( 'my_optional_modules_font_awesome' ) ) {

	function my_optional_modules_font_awesome() {

		wp_register_style( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'font_awesome' );

	}

}

/**
 *
 * My Optional Modules stylesheet used throughout for the different modules
 *
 */
if( !function_exists( 'my_optional_modules_main_stylesheet' ) ) {

	function my_optional_modules_main_stylesheet() {

		$myStyleFile = WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules05568.css';
		wp_register_style( 'my_optional_modules', $myStyleFile );
		wp_enqueue_style( 'my_optional_modules' );

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
	function mom_archives($atts,$content = null){
		if(!is_user_logged_in()){
			$nofollowCats = get_option('MOM_Exclude_VisitorCategories').','.get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');
		}
		if(is_user_logged_in()){
			if($user_level == 0){$loggedOutCats = get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
			if($user_level <= 1){$loggedOutCats = get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
			if($user_level <= 2){$loggedOutCats = get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
			if($user_level <= 7){$loggedOutCats = get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
		}
		$c1 = explode(',',$nofollowCats);
		foreach($c1 as &$C1){$C1 = ''.$C1.',';}
		$c_1 = rtrim(implode($c1),',');
		$c11 = explode(',',str_replace(' ','',$c_1));
		$c11array = array($c11);
		$nofollowcats = $c11;
		$category_ids = get_all_category_ids();
		ob_start();
		echo '<div class="momlistcategories">';foreach($category_ids as $cat_id){if(in_array($cat_id, $nofollowcats)) continue;$cat = get_category($cat_id);$link = get_category_link($cat_id);echo '<div><a href="'.esc_url($link).'" title="link to '.esc_attr($cat->name).'">'.esc_attr($cat->name).'</a><span>'.esc_attr($cat->count).'</span><section>'.esc_attr($cat->description);$args = array('numberposts'=>'1','category'=>$cat_id);$latestpost = wp_get_recent_posts($args);foreach($latestpost as $latest){echo '<article><em><a href="'.esc_url(get_permalink($latest["ID"])).'" title="'.esc_attr($latest["post_title"]).'" >'.esc_attr($latest["post_title"]).'</a></em></article>';}echo '</section></div>';}echo '</div>';
		return ob_get_clean();
	}