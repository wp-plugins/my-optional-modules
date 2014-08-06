<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

add_shortcode( 'topvoted', 'vote_the_posts_top' );
add_filter( 'the_content', 'do_shortcode','vote_the_posts_top' );
function vote_the_posts_top($atts,$content = null){
	extract(
		shortcode_atts(array(
			'amount' => 10
		), $atts)
	);	
	$amount = esc_sql(intval($amount));
	global $wpdb,$wp,$post;
	ob_start();
	wp_reset_query();
	$votesPosts = $wpdb->prefix.'momvotes_posts';
	$query_sql = $wpdb->get_results ( "SELECT ID,UP from $votesPosts  WHERE UP > 1 ORDER BY UP DESC LIMIT $amount" );
	if ($query_sql) {
		echo '<ul class="topVotes">
			<li>Top ' . $amount . ' posts</li>';
		foreach ($query_sql as $post_id) {
			$votes = intval($post_id->UP);
			$id = intval($post_id->ID);
			$link = get_permalink($id);
			echo '<li><a href="' . $link . '" rel="bookmark" title="Permanent Link to ' . get_the_title( $id ) . '">' . get_the_title( $id ) . ' &mdash; ( ' . $votes . ' )</a></li>';
		}
		echo '</ul>';
	}else{}
	wp_reset_query();
	return ob_get_clean();
}


	$mom_review_global = 0;
	function mom_reviews_shortcode($atts, $content = null){
		global $mom_review_global;
		$mom_review_global++;
		ob_start();
		extract(
			shortcode_atts(array(
				'type'	=> '',
				'orderby' => 'ID',
				'order' => 'ASC',
				'meta' => 1,
				'expand' => '+',
				'retract' => '-',
				'id' => '',
				'open' => 0
			), $atts)
		);	
		if( $id ) {
			$id_fetch_att = esc_sql($id);
		} else {
			$id_fetch = $id_fetch_att = '';
		}
		if(is_numeric($id_fetch_att)){$id_fetch = $id_fetch_att;}
		$order_by     = esc_sql($orderby);
		$order_dir    = esc_sql($order);
		$result_type  = myoptionalmodules_sanistripents($type);
		$meta_show    = myoptionalmodules_sanistripents($meta);
		$expand_this  = myoptionalmodules_sanistripents($expand);
		$retract_this = myoptionalmodules_sanistripents($retract);
		$is_open      = myoptionalmodules_sanistripents($open);
		global $wpdb;
		$mom_reviews_table_name = $wpdb->prefix.'momreviews';
		if($id_fetch != ''){
			$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE ID IN ($id_fetch) ORDER BY $order_by $order_dir");
		}else{
			if($result_type != ''){
				$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE IN ($result_type) ORDER BY $order_by $order_dir");
			}else{
				$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY $order_by $order_dir");
			}
		}
		foreach($reviews as $reviews_results){
			if($reviews_results->RATING == '.5') $reviews_results->RATING = '<i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '1') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '2') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '3') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '4') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
			if($reviews_results->RATING == '1.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '2.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '3.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>';
			if($reviews_results->RATING == '4.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>';
			if($reviews_results->REVIEW != ''){$this_ID = $reviews_results->ID;echo '<div ';if($result_type != ''){echo 'id="'.esc_attr($result_type).'"';}echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="'.$this_ID.''.$mom_review_global.'" ';if($is_open == 1){echo ' checked';}echo '/><label for="'.$this_ID.''.$mom_review_global.'">';if($reviews_results->TITLE != ''){echo $reviews_results->TITLE;}echo '<span>'.$expand_this.'</span><span>'.$retract_this.'</span></label><section class="reviewed">';if($meta_show == 1){if($reviews_results->TYPE != ''){echo ' [ <em>'.$reviews_results->TYPE.'</em> ] ';}if($reviews_results->LINK != ''){echo ' [ <a href="'.esc_url($reviews_results->LINK).'">#</a> ] ';}}echo '<hr />'.$reviews_results->REVIEW;if($reviews_results->RATING != ''){echo ' <p>'.$reviews_results->RATING.'</p> ';}echo '</section></article></div>';}
			elseif($reviews_results->REVIEW == ''){$this_ID = $reviews_results->ID;echo '<div ';if($result_type != ''){echo 'id="'.esc_attr($result_type).'"';}echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="'.$this_ID.''.$mom_review_global.'" ';if($is_open == 1){echo ' checked';}echo '/><label>';if($reviews_results->TITLE != ''){if($reviews_results->LINK != ''){echo '<a href="'.esc_url($reviews_results->LINK).'">';}echo $reviews_results->TITLE;if($reviews_results->LINK != ''){echo '</a>';}}echo '<span>'.$reviews_results->RATING.'</span><span></span></label></article></div>';}
		}
		return ob_get_clean();
	}

		function font_fa_shortcode($atts, $content = null){
			extract(
				shortcode_atts(array(
					"i" => ''
				), $atts)
			);
			$icon = esc_attr($i);
			if($icon != ''){$iconfinal = $icon;}
			ob_start();
			echo '<i class="fa fa-'.$iconfinal.'"></i>';
			return ob_get_clean();
		}
	
	function mom_onthisday_template(){
		$current_day   = date('d');
		$current_month = date('m');
		if(is_category()){
			$category_current = get_the_category();
			$category = $category_current[0]->cat_ID;	
		}
		if(is_tag()){
			$tagged = get_query_var('tag');
			$tag = esc_attr($tagged);
		}	
		wp_reset_query();
		if(is_category()){query_posts( "cat=$category&monthnum=$current_month&day=$current_day&posts_per_page=-1" );}
		elseif(is_tag()){query_posts( "tag=$tag&monthnum=$current_month&day=$current_day&posts_per_page=-1" );}
		else{query_posts( "monthnum=$current_month&day=$current_day&posts_per_page=-1" );}
		$posts = 0;
		while(have_posts()):the_post();
		$posts++;
		if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">on this day</span>';}
		if($posts > 0){
			$postid = get_the_id();
			echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
		}
			endwhile;
		if($posts == 0){
			$posts++;
			if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">5 random posts</span>';}
			query_posts( "orderby=rand&posts_per_page=5&ignore_sticky_posts=1" );
			while(have_posts()):the_post();
			$postid = get_the_id();
			echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
			endwhile;
		}
		echo '</div>';
		wp_reset_query();
	}
	function mom_onthisday($atts,$content = null){
		extract(
			shortcode_atts(array(
				'amount' => '-1',
				'title' => 'On this day',
				'cat' => ''
			), $atts)
		);
		global $post;
		$postid = $post->ID;
		if($cat == 'current'){
			$category_current = get_the_category($postid);
			$category = $category_current[0]->cat_ID;
		}else{
			$category = esc_attr($cat);
		}
		$onthisday = esc_attr($title);
		$postid = get_the_ID();
		$current_day = date('d');
		$current_month = date('m');
		$postsperpage = esc_attr($amount);
		query_posts( "cat=$category&monthnum=$current_month&day=$current_day&post_per_page=$postsperpage" );
		ob_start();
		$posts = 0;
		while(have_posts()):the_post();
		$posts++;
		if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">on this day</span>';}
		if($posts > 0){
			$postid = get_the_id();
			echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo get_the_post_thumbnail($postid, 'thumbnail', array('class' => 'mom_thumb'));echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
		}
			endwhile;
		if($posts == 0){
			$posts++;
			if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">5 random posts</span>';}
			query_posts( "orderby=rand&post_per_page=5&ignore_sticky_posts=1" );
			while(have_posts()):the_post();
			$postid = get_the_id();
			echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo get_the_post_thumbnail($postid, 'thumbnail', array('class' => 'mom_thumb'));echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
			endwhile;
		}
		echo '</div>';
		wp_reset_query();
		return ob_get_clean();
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
	$momverifier_verification_step = 0;
	function mom_google_map_shortcode($atts, $content = null){
		ob_start();
		extract(
			shortcode_atts(array(
				'width' => '100%',
				'height' => '350px',
				'frameborder' => '0',
				'align' => 'center',
				'address' => '',
				'info_window' => 'A',
				'zoom' => '14',
				'companycode' => ''
			), $atts)
		);
		$mgms_output = 'q='.urlencode($address).'&amp;cid='.urlencode($companycode);
		echo '
		<div class="mom_map">
			<iframe align="'.esc_attr($align).'" width="'.esc_attr($width).'" height="'.esc_attr($height).'" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;'.htmlentities($mgms_output).'&amp;output=embed&amp;z='.esc_attr($zoom).'&amp;iwloc='.esc_attr($info_window).'&amp;visual_refresh=true"></iframe>
		</div>
		';
		return ob_get_clean();
	}
	function mom_reddit_shortcode($atts, $content = null){
		global $wpdb, $id, $post_title;
		$query = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND ID = '$id'";
		$reddit = $wpdb->get_results($query);
		if($reddit){
			foreach($reddit as $reddit_info){
				$post_title = strip_tags($reddit_info->post_title);
			}
		extract(
			shortcode_atts(array(
				'url' => '' . $get_permalink . '',
				'target' => '',
				'title' => '' . $post_title . '',
				'bgcolor' => '',
				'border' => ''
			), $atts)
		);
		ob_start();
		echo '
		<div class="mom_reddit">
		<script type="text/javascript">
			reddit_url = "'.esc_url($url).'";
			reddit_target = "'.esc_attr($target).'";
			reddit_title = "'.esc_attr($title).'";
			reddit_bgcolor = "'.esc_attr($bgcolor).'";
			reddit_bordercolor = "'.esc_attr($border).'";
		</script>
		<script type="text/javascript" src="http://www.reddit.com/static/button/button3.js"></script>
		</div>';
		return ob_get_clean();
		}
	}
	function mom_restrict_shortcode($atts, $content = null){
		extract(
			shortcode_atts(array(
				'message' => 'You must be logged in to view this content.',
				'comments' => '',
				'form' => ''
			), $atts)
		);
		ob_start();
		if(is_user_logged_in()){return $content;}else{
			echo '<div class="mom_restrict">'.htmlentities($message).'</div>';
			if($comments == '1'){
				add_filter('comments_template','restricted_comments_view');
				function restricted_comments_view($comment_template){
					return dirname(__FILE__).'/includes/templates/comments.php';
				}
			}
			if($comments == '2'){
				add_filter('comments_open','restricted_comments_form',10,2);
				function restricted_comments_form($open,$post_id){
					$post = get_post($post_id);
					$open = false;
					return $open;
				}	
			}
		}		
		return ob_get_clean();
	}
	function mom_progress_shortcode($atts,$content = null){
		extract(
			shortcode_atts(array(
				'align' => 'none',
				'fillcolor' => '#ccc',
				'maincolor' => '#000',
				'height' => '15',
				'fontsize' => '15',
				'level' => '',
				'margin' => '0 auto',
				'talign' => 'center',
				'width' => '95'
			), $atts)
		);
		$align_fetch = sanitize_text_field($align);
		$fillcolor_fetch = sanitize_text_field($fillcolor);
		$height_fetch = sanitize_text_field($height);
		$level_fetch = sanitize_text_field($level);
		$maincolor_fetch = sanitize_text_field($maincolor);
		$margin_fetch = sanitize_text_field($margin);
		$width_fetch = sanitize_text_field($width);
		ob_start();
		if($align_fetch == 'left'){$align_fetch_final = 'float: left';}
		elseif($align_fetch == 'right'){$align_fetch_final = 'float: right';}
		else {$align_fetch_final = 'clear: both';}
		echo '<div class="mom_progress" style="'.$align_fetch_final.';height:'.$height_fetch.'px;display:block;width:'.$width_fetch.'%;margin:'.$margin_fetch.';background-color:'.$maincolor_fetch.'"><div style="display:block;height:'.$height_fetch.'px;width:'.$level_fetch.'%;background-color:'.$fillcolor_fetch.';"></div></div>';
		return ob_get_clean();
	}
	function mom_verify_shortcode($atts,$content = null){
		global $post;
			global $ipaddress;
			if($ipaddress !== false){
			$ipaddress = ip2long($ipaddress);
			if(is_numeric($ipaddress)){
				$theIP = $ipaddress;}else{
				$theIP = 0;
			}
			ob_start();
			extract(
				shortcode_atts(array(
					"age" => '',
					"answer" => '',
					"logged" => 1,
					"message" => 'Please verify your age by typing it here',
					"fail" => 'You are not able to view this content at this time.',
					"logging" => 0,
					"background" => 'transparent',
					"stats" => '',
					"single" => 0,
					"cmessage" => 'Correct',
					"imessage" => 'Incorrect',
					"deactivate" => 0
				), $atts)
			);
			global $momverifier_verification_step;
			$momverifier_verification_step++;
			$thePostId = $post->ID;
			$theBackground = esc_sql(myoptionalmodules_sanistripents($background));
			$theAge = esc_sql(myoptionalmodules_sanistripents($age));
			$isLogged = esc_sql(myoptionalmodules_sanistripents($logged));
			$theMessage = esc_sql(myoptionalmodules_sanistripents($message));
			$theAnswer = esc_sql(myoptionalmodules_sanistripents($answer));
			$failMessage = $fail;
			$isLogged = esc_sql(myoptionalmodules_sanistripents($logged));
			$isLogging = esc_sql(myoptionalmodules_sanistripents($logging));
			$attempts = esc_sql(myoptionalmodules_sanistripents($single));
			$correctResultMessage = esc_sql(myoptionalmodules_sanistripents($cmessage));
			$incorrectResultMessage = esc_sql(myoptionalmodules_sanistripents($imessage));
			$isDeactivated = esc_sql(myoptionalmodules_sanistripents($deactivate));
			$verificationID = $momverifier_verification_step.''.$thePostId;
			$statsMessage = esc_sql(myoptionalmodules_sanistripents($stats));
			$alreadyAttempted = 0;
			if(is_numeric($attempts) && $attempts == 1){
				global $wpdb;
				$verification_table_name = $wpdb->prefix.'momverification';
				$getNumberofAttempts = $wpdb->get_results("SELECT IP,POST,CORRECT FROM $verification_table_name WHERE IP = '".$theIP."' AND POST = '" . $verificationID . "'");	
				$alreadyAttempted = count($getNumberofAttempts);
				foreach($getNumberofAttempts as $numberofattempts){
					$isCorrect = $numberofattempts->CORRECT;
				}
			}
			if(is_numeric($isLogged) && $isLogged == 0 && is_user_logged_in()){
				$isCorrect = 1;
			} elseif(is_numeric($isLogged) && $isLogged == 1){		
				if($alreadyAttempted != 1){
					if(!$_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.''] != '' && $isDeactivated != 1){
					return '
					<blockquote style="display:block;clear:both;margin:5px auto 5px auto;padding:5px;font-size:25px;">
					<p>'.$theMessage.'</p>
					<form style="clear:both;display:block;padding:5px;margin:0 auto 5px auto;width:98%;overflow:hidden;border-radius:3px;background-color:#'.$theBackground.';" class="momAgeVerification" method="post" action="'.esc_url(get_permalink()).'">
						<input style="clear:both;font-size:25px;width:99%;margin:0 auto;" type="text" name="ageVerification'.esc_attr($momverifier_verification_step).esc_attr($thePostId).'">
						<input style="clear:both;font-size:20px;width:100%;margin:0 auto;" type="submit" name="submit" class="submit clear" value="Submit">
					</form>
					</blockquote>
					';
					}
				}
				if($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.''] != ''){
					if($theAge != '' && is_numeric($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']) && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
						$ageEntered = ($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']);
						if($ageEntered >= $theAge){
							$isCorrect = 1;
						}else{
							$isCorrect = 0;
						}
					} elseif($theAnswer != '' && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
						$answerGiven = ($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']);
						$correctAnswer = strtolower($theAnswer);
						$answered = strtolower($answerGiven);					
						if($answered === $correctAnswer){
							$isCorrect = 1;
						}else{
							$isCorrect = 0;
						}
					}		
				}			
			}
			if(is_numeric($isLogging) && $isLogging == 1 || is_numeric($isLogging) && $isLogging == 3 || is_numeric($attempts) && $attempts == 1){
				global $wpdb;
				$verification_table_name = $wpdb->prefix.'momverification';
				$getIPforCurrentTransaction = $wpdb->get_results("SELECT IP,POST FROM $verification_table_name WHERE IP = '".$theIP."' AND POST = '".$verificationID."'");
				if(count($getIPforCurrentTransaction) <= 0 && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
					if($theAge != '' && is_numeric($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']) && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
						$ageEntered	= ($_REQUEST['ageVerification' . $momverifier_verification_step . $thePostId . '']);
						if($ageEntered >= $theAge){		
						$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','1','$theIP')");
						}else{
						$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','0','$theIP')");
						}
					}
					elseif($theAnswer != '' && $_REQUEST['ageVerification' . $momverifier_verification_step . $thePostId . '']){
						$answerGiven = ($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']);
						$correctAnswer = strtolower($theAnswer);
						$answered = strtolower($answerGiven);				
						if($answered === $correctAnswer){				
						$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','1','$theIP')");
						}else{
						$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','0','$theIP')");
						}
					}
				}
				if($isLogging != 1){
					$incorrect = $wpdb->get_results("SELECT CORRECT FROM $verification_table_name WHERE POST = '".$verificationID."' AND CORRECT = '0'");
					$correct = $wpdb->get_results("SELECT CORRECT FROM $verification_table_name WHERE POST = '".$verificationID."' AND CORRECT = '1'");
					$incorrectCount = count($incorrect);
					$correctCount = count($correct);
					if(count($correct) > 0 && count($incorrect) > 0){$totalCount = ($incorrectCount + $correctCount);}else{$totalCount = 1;}					
					$percentCorrect = ($correctCount/$totalCount * 100);
					$percentIncorrect = ($incorrectCount/$totalCount * 100);
					if($statsMessage == ''){$statsMessage = $theMessage;}
					return '<div style="clear:both;display:block;width:99%;margin:10px auto 10px auto;overflow:auto;background-color:#f6fbff;border:1px solid #4a5863;border-radius:3px;padding:5px;"><p>'.$statsMessage.'</p><div class="mom_progress" style="clear:both;height:20px;display:block;width:95%; margin:5px auto 5px auto;background-color:#ff0000"><div title="'.$correctCount.'" style="display:block;height:20px;width:'.$percentCorrect.'%;background-color:#1eff00;"></div></div><div style="font-size:15px;margin:-5px auto;width:95%;"><span style="float:left;text-align:left;">'.$correctResultMessage.' ('.$percentCorrect.'%)</span><span style="float:right;text-align:right;">'.$incorrectResultMessage.' ('.$percentIncorrect.'%)</span></div></div>';
				}
			}
			if($isCorrect == 1){return $content;}elseif($isCorrect == 0 && $deactivate != 1){return $failMessage;}
			return ob_get_clean();
		}else{
			// Return nothing, the IP address is fake.
		}
	}	