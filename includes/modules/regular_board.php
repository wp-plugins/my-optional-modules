<?php 
	if(!defined('MyOptionalModules')){die('You can not call this file directly.');}
	if(get_option('mommaincontrol_regularboard') == 1){
		$rb_v = '05492874';
		add_action('wp_enqueue_scripts','rb_style');
		add_action('wp_head','rb_head');
		add_shortcode('regularboard','regularboard_shortcode');
		add_filter('the_content','do_shortcode','regularboard_shortcode');
	}
	function rb_404(){
		echo '<div class="tinythread"><span class="tinysubject">404</span></div><div class="tinycomment"><p>The resource you are looking for does not exist.</p><hr /><p class="information tiny"><i class="fa fa-thumbs-up"></i> Posts and replies can be Approved of (or Disapproved) - which will add (or detract) from your overall Approval rating on this site.Ratings are tracked by IP address alone - posting from different IP addresses will obviously mean different Approval ratings for each of your posts.</p><p class="information tiny"><i class="fa fa-user"></i> We use your IP address to identify you, for the purposes of user stats, and for the purposes of board moderation.  Your IP address is never made publicly available.  All users are <em>anonymous</em> (in the sense that there are no names attached to their posts).</p><p class="information tiny"><i class="fa fa-terminal"></i> Did you know that you can format your comments using special code?  Surrounding a word with *s, like *this*, will result in an <em>italicized</em> word, while **this** will result in a <strong>bold</strong> word.  Read <a href="?a=help">this</a> for more information.</p><p class="information tiny"><i class="fa fa-warning"></i> Now that you\'ve made your first post, this information screen will no longer be presented to you.  Instead, in the future, when making new posts,you will simply be automatically forwarded to them.  Now go forth - and be a productive member of this community!</p></div></div><script type="text/javascript">document.title = \'404\';</script>';
	}
	function get_domain($url){
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
			return $regs['domain'];
		}
		return false;
	}
	function rb_style(){global $wp,$post,$rb_v;$content = $post->post_content;if( has_shortcode( $content, 'regularboard' )){$regularboard = plugins_url().'/my-optional-modules/includes/javascript/regularboard'.$rb_v.'.js';$regbostyle = WP_PLUGIN_URL . '/my-optional-modules/includes/css/regularboard'.$rb_v.'.css';wp_register_style('regular_board',$regbostyle);wp_enqueue_style('regular_board');	wp_deregister_script('regularboard');wp_register_script('regularboard',$regularboard,'','',null,false);wp_enqueue_script('regularboard');}}
	function rb_head($atts){global $wp,$post,$wpdb,$purifier;$regularboard_boards = $wpdb->prefix.'regularboard_boards';$regularboard_posts = $wpdb->prefix.'regularboard_posts';$content = $post->post_content;if( has_shortcode( $content, 'regularboard' )){$BOARD = esc_sql(strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b'])));$THREAD = esc_sql(intval($_GET['t']));if($THREAD != ''){$getres = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");}if(count($getres) == 1){foreach($getres as $meta){$canonical = $author = $title = $site = $locale = $published = $last = $image = $video = $description = '';$locale = get_locale();$site = get_bloginfo('name'); $THISPAGE = home_url('/');$pretty = esc_attr(get_option('mommaincontrol_prettycanon'));$BOARD = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b']))));if($meta->PARENT == 0){$THREAD = intval($_GET['t']);}if($meta->PARENT != 0){$THREAD = intval($meta->PARENT).'#'.intval($_GET['t']);}$canonical = $THISPAGE.'?b='.$meta->BOARD.'&amp;t='.$THREAD;$author = $purifier->purify($meta->MODERATOR);$title = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',$meta->SUBJECT)));if($title == ''){$title = 'No subject';}$published = $purifier->purify($meta->DATE);$last = $purifier->purify($meta->LAST);$type = $purifier->purify($meta->TYPE);if($type == 'image'){$purifier->purify($image = $meta->URL);}if($type == 'video'){$video = 'http://youtube.com/watch?v='.$meta->URL;}$description = $purifier->purify(strip_tags($meta->COMMENT));$description = str_replace(array('||||','||','*','{{','}}','>>',' >','~~',' - ','----','::','`','    '),'',(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',$description)))))));$description = substr($description,0,150);echo "\n";if($canonical != ''){echo '<meta property="og:url" content="'.$canonical.'" /> ';echo "\n";}if($title != ''){echo '<meta property="og:title" content="'.$title.'" /> ';echo "\n";}if($site != ''){echo '<meta property="og:site_name" content="'.$site.'" /> ';echo "\n";}if($locale != ''){echo '<meta property="og:locale" content="'.$locale.'" /> ';echo "\n";}if($image != ''){echo '<meta property="og:image" content="'.$image.'" /> ';echo "\n";}if($video != ''){echo '<meta property="og:video" content="http://www.youtube.com/v/'.$meta->URL.'?autohide=1&amp;version=3" /> ';echo "\n";echo '<meta property="og:video:type" content="application/x-shockwave-flash" /> ';echo "\n";echo '<meta property="og:video:height" content="720" /> ';echo "\n";echo '<meta property="og:video:width" content="1280" /> ';echo "\n";echo '<meta property="og:type" content="video" /> ';echo "\n";echo '<meta property="og:image" content="http://img.youtube.com/vi/'.$meta->URL.'/0.jpg" /> ';echo "\n";}else{if($published != ''){echo '<meta property="og:published_time" content="'.$published.'" /> ';echo "\n";}if($published != ''){echo '<meta property="og:modified_time" content="'.$published.'" /> ';echo "\n";}if($last != ''){echo '<meta property="og:updated" content="'.$last.'" /> ';echo "\n";}echo '<meta property="og:type" content="article" /> ';echo "\n";}if($description != ''){echo '<meta property="og:description" content="'.$description.'" /> ';echo "\n\n";}}}}}

	function regularboard_shortcode($atts,$content = null){
		extract(
			shortcode_atts(
				array(
					'bannedmessage' => 'YOU ARE BANNED',
					'postedmessage' => 'POSTED!!!',
					'enableurl' => '1',
					'enablerep' => '1',
					'maxbody' => '1800',
					'maxreplies' => '500',
					'maxtext' => '75',
					'boards' => '',
					'userflood' => '',
					'imgurid' => ''
				), $atts
			)
		);
		global $wpdb,$wp,$post,$ipaddress,$rand,$randnum1,$randnum2,$rb_v;
		if($ipaddress !== false){
			$iexist = $requirelogged = $doesnotexist = 0;
			$thisimageupload = $SEARCH = $modishere = $THREADIMGS = $profilelink = $boardid = $boardname = $boardshort = $boarddescription = $boardmods = $boardjans = $boardposts = '';
			$wordpressname = get_bloginfo('name');
			$blog_title = get_bloginfo();
			
			if($imgurid != '' && isset($_POST['submitimgur'])){
				$img = $_FILES['img'];
				if($img['name'] != ''){
					$filename = $img['tmp_name'];
					$client_id = "$imgurid";
					$handle = fopen($filename, "r");
					$data = fread($handle, filesize($filename));
					$pvars = array('image' => base64_encode($data));
					$timeout = 30;
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
					curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
					$out = curl_exec($curl);
					curl_close ($curl);
					$pms = json_decode($out,true);
					$url = $pms['data']['link'];
					if($url!= ''){
						$thisimageupload = $url;
					}
				}
			}
				
			$THISPAGE            = get_permalink();
			myoptionalmodules_checkdnsbl($checkThisIP);
			$theIP               = esc_sql($ipaddress);
			$theIP_s32int        = esc_sql(ip2long($ipaddress));
			$theIP_us32str       = esc_sql(sprintf("%u",$theIP_s32int));
			$checkThisIP         = esc_sql($theIP);
			$current_timestamp   = date('Y-m-d H:i:s');
			$maxreplies          = intval($maxreplies);
			$maxbody             = intval($maxbody);
			$maxtext             = intval($maxtext);
			$regularboard_boards = $wpdb->prefix.'regularboard_boards';
			$regularboard_posts  = $wpdb->prefix.'regularboard_posts';
			$regularboard_users  = $wpdb->prefix.'regularboard_users';
			$QUERY               = esc_sql(myoptionalmodules_sanistripents($_SERVER['QUERY_STRING']));
			$BOARD               = esc_sql(strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b'])));
			$AREA                = esc_sql(strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['a'])));
			$VOTE                = intval($_GET['v']);
			$PROFILE             = intval($_GET['u']);
			$THREAD              = intval($_GET['t']);
			$profileid           = intval($PROFILE);
			$PROFILE             = intval($PROFILE);
			$ISUSERMOD           = false;
			$ISUSER              = true;
			$posting             = 1;
			$postsperpage        = 50;
			
			$myinformation = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
			if(count($myinformation) > 0){
				foreach($myinformation as $myinfo){
					$profilekarma     = intval($myinfo->KARMA);
					$profileid        = intval($myinfo->ID);
					$profileheaven    = intval($myinfo->HEAVEN);
					$profilevideo     = intval($myinfo->VIDEO);
					if($profilevideo == ''){
						$profilevideo = 0;
					}
					$profilelink      = '?u='.$profileid;
					$profilepassword  = esc_sql($myinfo->PASSWORD);
					$profilefollow    = esc_sql($myinfo->FOLLOWING);
					$following        = esc_sql($profilefollow);
					$boards           = esc_sql($myinfo->BOARDS);
					$following        = esc_sql($myinfo->FOLLOWING);
					$profileboards    = esc_sql($myinfo->BOARDS);
					$iexist           = 1;
					
					if($boards != ''){
						$boards       = explode(',',$boards);
						$boards       = array_map('rb_apply_quotes',$boards);
					}
					if($following != ''){
						$following    = explode(',',$following);
						$following    = array_map('rb_apply_quotes',$following);
					}
					
				}
			}
			$getBoards     = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME != '' ORDER BY NAME ASC");
			if(count($getBoards) == 1){
				foreach($getBoards as $Board){
					$THISBOARD = $Board->SHORTNAME;
				}
			}
			$getRules      = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '' LIMIT 1");
			
			if(isset($_POST['searchsub']) && $_REQUEST['boardsearch'] != ''){
				$SEARCH = esc_sql(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_REQUEST['boardsearch'])));
			}
			
			if($BOARD != ''){
				$getCurrentBoard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '".$BOARD."' LIMIT 1");
			}
			if($BOARD == '' && count($getBoards) == 1){
				$getCurrentBoard  = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '".$THISBOARD."' LIMIT 1");
			}
			
			if(count($getCurrentBoard) > 0 && $BOARD != ''){
				foreach($getCurrentBoard as $currentBoardInformation){
					$lock = intval($currentBoardInformation->LOCKED);
					$boardid = intval($currentBoardInformation->ID);
					$boardname        = $currentBoardInformation->NAME;
					$boardshort       = $currentBoardInformation->SHORTNAME;
					$boarddescription = $currentBoardInformation->DESCRIPTION;
					$boardrules       = $currentBoardInformation->RULES;
					$boardmods        = $currentBoardInformation->MODS;
					$boardjans        = $currentBoardInformation->JANITORS;
					$boardposts       = intval($currentBoardInformation->BOARDPOSTS);
					$requirelogged    = intval($currentBoardInformation->LOGGED);
					$boardsfw         = $currentBoardInformation->SFW;
					$boardheader      = '<div class="tinythread"><span class="tinysubject"><a href="?b='.$boardshort.'">'.$boardname.'</a></span><span class="tinyreplies">'.$boardsfw.'</span><span class="tinydate">'.$boardshort.'</span></div><div class="tinythread"><span class="tinysubject">'.$boarddescription.'</span></div>';
					echo '<script type="text/javascript">document.title = \''.$boardname.' / '.$boardshort.'\';</script>';
				}
			}else{
				$boardheader = '<div class="tinythread"><span class="tinysubject">'.get_bloginfo('name').'</span></div>';
			}
				
			if($BOARD != '' ){
				$getBoards   = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME != '' ORDER BY SHORTNAME ASC");
				$getUser     = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = 1 LIMIT 1");
				$getLastPost = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = '".$theIP_us32str."' ORDER BY ID DESC LIMIT 1");
			}
			if($BOARD != '' && $THREAD == ''){
				$targetpage = '?b='.$BOARD;
				$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0");
				$totalpages = count($countpages);
				$results = intval($_GET['n']);
				if($results){
					$start = ($results - 1) * $postsperpage;
				}else{
					$start = 0;
				}
				if($SEARCH == ''){
					$getposts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0 ORDER BY STICKY DESC, LAST DESC LIMIT $start,$postsperpage");
				}
				if($SEARCH != ''){
					$getposts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ( EMAIL = '".$SEARCH."' OR COMMENT LIKE '%".$SEARCH."%' OR SUBJECT LIKE '%".$SEARCH."%' OR URL LIKE '%".$SEARCH."%' ) AND BOARD = '".$BOARD."' ORDER BY ID");
				}
			}
			if($BOARD != '' && $THREAD != ''){
				$getposts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND ID = '".$THREAD."' AND PARENT = 0 LIMIT 1");
				$countParentReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = '".$THREAD."'");
				$THREADREPLIES = $THREADIMGS = 0;
				}
			if($AREA == 'topics' || $BOARD == '' && $AREA == '' && $THREAD == ''){
				$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE PARENT = 0");
				$totalpages = count($countpages);
				$results = intval($_GET['n']);
				if($results){
					$start = ($results - 1) * $postsperpage;
				}else{
					$start = 0;
				}
				$getposts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = 0 ORDER BY DATE DESC LIMIT $start,$postsperpage");
			}
			if($BOARD == '' && $AREA == 'replies' && $THREAD == ''){
				$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE PARENT != 0");
				$totalpages = count($countpages);
				$results = intval($_GET['n']);
				if($results){
					$start = ($results - 1) * $postsperpage;
				}else{
					$start = 0;
				}
				$getposts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT != 0 ORDER BY DATE DESC LIMIT $start,$postsperpage");
			}
			if($BOARD == '' && $AREA == 'all' && $THREAD == ''){
				$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts");
				$totalpages = count($countpages);
				$results = intval($_GET['n']);
				if($results){
					$start = ($results - 1) * $postsperpage;
				}else{
					$start = 0;
				}
				$getposts = $wpdb->get_results("SELECT * FROM $regularboard_posts ORDER BY DATE DESC LIMIT $start,$postsperpage");
			}
			if($BOARD == '' && $AREA == 'users' && $THREAD == ''){
			$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_users WHERE BANNED = 8");
			$totalpages = count($countpages);
			$results = intval($_GET['n']);
			if($results){
				$start = ($results - 1) * $postsperpage;
			}else{
				$start = 0;
			}
			$getposts = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 8 ORDER BY ID DESC LIMIT $start,$postsperpage");
			}
				
			$tlast = 0;
			if($THREAD != ''){
				if($AREA != 'newtopic'){
					$getParentAuthor = $wpdb->get_results("SELECT USERID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND ID = $THREAD LIMIT 1");
					$getReplyAuthor  = $wpdb->get_results("SELECT USERID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = $THREAD ORDER BY ID ASC LIMIT 1");
					if(count($getParentAuthor) > 0){
						foreach($getParentAuthor as $tauthor){
							if($tauthor->USERID == $profileid){
								$tlast++;
							}
						}
					}
					if(count($getReplyAuthor) > 0){
						foreach($getReplyAuthor as $rauthor){
							if($rauthor->USERID == $profileid){
								$tlast++;
							}
						}
					}
				}
			}
				
			if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != ''){
				$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD IN (".join(',',$boards).")");
				$totalpages = count($countpages);
				$results = intval($_GET['n']);
				if($results){
					$start = ($results - 1) * $postsperpage;
				}else{
					$start = 0;
				}
				$getposts= $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD IN (".join(',',$boards).") ORDER BY DATE DESC LIMIT $start,$postsperpage");
			}
			if($BOARD == '' && $AREA == 'following' && $THREAD == ''){
				$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE USERID IN (".join(',',$following).")");
				$totalpages = count($countpages);
				$results = intval($_GET['n']);
				if($results){
					$start = ($results - 1) * $postsperpage;
				}else{
					$start = 0;
				}
				$getposts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE USERID IN (".join(',',$following).") ORDER BY DATE DESC LIMIT $start,$postsperpage");
			}
			if($BOARD == '' && $THREAD != ''){
				$post = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
			}
			if($PROFILE != ''){
				$reviews_table = $wpdb->prefix.'momreviews';
				$usprofile = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE ID = $profileid AND BANNED = 8 LIMIT 1");
				$ktrophies = $wpdb->get_results("SELECT * FROM $reviews_table WHERE TYPE = 'karma' OR TYPE='activeposts'");
			}

			$current_user = wp_get_current_user();
			$current_user_login = $current_user->user_login;
			if(current_user_can('manage_options')){
				$ISMODERATOR = true;
			}
			if($boardmods != ''){
				$usermods = explode(',',$boardmods);
				if(in_array($current_user_login,$usermods)){
					$ISUSERMOD = true;
				}
			}
			if($boardjans != ''){
				$userjanitors = explode(',',$boardjans);
				if(in_array($current_user_login,$userjanitors)){
					$ISUSERJANITOR = true;
				}
			}
			if($usermod != ''){
				$usermod = array($usermod);
			}
			if($ISMODERATOR === true){
				$ISUSER = false;
			}
			if($ISUSERMOD === true){
				$ISUSER = false;
			}
			if($ISUSERJANITOR === true){
				$ISUSER = false;
			}
						
			if($AREA == 'bans' && $ISMODERATOR === true){
				$getUsers = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 1");
			}
			if($ISMODERATOR === true){
				$getReports = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 3");
			}
			if($lock == 1){
				if($ISUSER === true){
					$posting = 0;
				}
				if($ISUSER !== true){
					$posting = 1;
				}
			}
				
			if(count($getBoards) > 0){
				foreach($getBoards as $cboard){
					$BOARDRULES = rb_format($cboard->RULES);
				}
			}
				
			if(count($getBoards == 1)){
				if($BOARD != '' && $THREAD != '' && $ID == $THREAD){
					$ACTION = $THISPAGE.'?b='.$THISBOARD;
				}elseif($BOARD != '' && $THREAD == ''){
					$ACTION = $THISPAGE.'?b='.$THISBOARD;
				}elseif($BOARD != '' && $THREAD != ''){
					$ACTION = $THISPAGE.'?b='.$THISBOARD.'&amp;t='.$THREAD;
				}elseif($BOARD == '' && $THREAD == ''){
					$ACTION = $THISPAGE.'?b='.$THISBOARD;
				}
			}else{
				if($BOARD != '' && $THREAD != '' && $ID == $THREAD){
					$ACTION = $THISPAGE.'?b='.$BOARD;
				}elseif($BOARD != '' && $THREAD == ''){
					$ACTION = $THISPAGE.'?b='.$BOARD;
				}elseif($BOARD != '' && $THREAD != ''){
					$ACTION = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;
				}
			}
				
			if(current_user_can('manage_options') || $ISUSERMOD === true || $ISUSERJANITOR === true){
				if(isset($_REQUEST['admin_ids'])){
					include(plugin_dir_path(__FILE__).'/regular_board_admin_form_action.php');
				}
			}
				
			ob_start();
				
			echo '<div class="boardAll">';
				
			if($ISMODERATOR === true && count($getReports) > 0){
				echo '<div class="tinythread"><span class="tinysubject"><a href="?a=reports">'.count($getReports).' reports need your attention.</a></span></div>';
			}
				
			echo $boardheader;
				
			if(count($getBoards) > 1){
				echo '<div class="tinythread"><div class="boards"><span>boards</span> ';
				foreach($getBoards as $gotBoards){
					$short = $gotBoards->SHORTNAME;
					echo '<span><a href="?b='.$short.'">'.$short.'</a></span>';
				}
				echo '</div></div>';
			}
			
			echo '<div class="userbar">';
			
			if($iexist == 1 && $profileboards != ''){
				echo '<a href="?a=subscribed">subscribed</a>';
			}
			if($iexist == 1 && $profilefollow != ''){
				echo '<a href="?a=following">following</a>';
			}
			
			echo '<a href="?a=topics">topics</a><a href="?a=replies">replies</a><a href="?a=all">all</a><a href="?a=stats">stats</a><a href="?a=users">users</a>';
			
			if($ISMODERATOR === true){
				echo '<a href="?a=create">admin</a>';
			}
			if($iexist == 1){
				echo '<a href="?u='.$profileid.'">history</a>';
				echo '<a href="?a=options">options</a>';
			}
				
			echo '<a href="?a=help">help</a><a href="?a=info">info</a>';
				
			if($BOARD != '' && $posting == 1 && $iexist == 1 && $AREA == '' || $THISBOARD != ''){
				echo '<a class="newtopic" href="'.$THISPAGE.'?b='.$BOARD.'&amp;a=newtopic">New topic</a><span class="hidden notopic">Cancel new topic</span>';
			}
				
			echo '</div><div class="newtopic"></div>';
				
			if($imgurid != ''){
				if(!isset($_POST['submitimgur'])){
					echo '<div class="tinythread"><form class="imgur" enctype="multipart/form-data" method="POST"><span class="tinysubject"><input name="img" size="35" type="file"/></span><span class="tinyreplies"><input type="submit" id="submitimgur" name="submitimgur" value="Upload"/></span></form></div>';
				}else{
					echo '<div class="tinythread"><span class="tinysubject">Image URL:'.$thisimageupload.'</span></div><div class="tinycomment"><img src="'.$thisimageupload.'" class="imageOP" alt="'.$thisimageupload.'" /></div>';
				}
			}
				
			if($AREA == 'newtopic'){
				if(count($getBoards) == 1){
					foreach($getBoards as $Board){
						$BOARD = $Board->SHORTNAME;
					}
				}
			}
				
			if($THREAD != '' && $AREA == 'vote' && $VOTE != ''){
				include(plugin_dir_path(__FILE__).'/regular_board_post_voting.php');
			}elseif($AREA == 'options' && $iexist == 1){
				include(plugin_dir_path(__FILE__).'/regular_board_user_options.php');
			}elseif($AREA == 'info'){
				include(plugin_dir_path(__FILE__).'/regular_board_board_information.php');
			}elseif($PROFILE != ''){
				include(plugin_dir_path(__FILE__).'/regular_board_profile_loop.php');
			}elseif($AREA == 'stats'){
				include(plugin_dir_path(__FILE__).'/regular_board_board_stats.php');
			}elseif($AREA == 'help'){
				include(plugin_dir_path(__FILE__).'/regular_board_help.php');
			}elseif($AREA == 'create' || $AREA == 'bans' || $AREA == 'reports'){
				include(plugin_dir_path(__FILE__).'/regular_board_admin_panel.php');
			}elseif($BOARD != ''){
					
				include(plugin_dir_path(__FILE__).'/regular_board_posting_checkflood.php');
					
				if(isset($_POST['delete_this']) && $_REQUEST['report_ids'] !== '' && $_REQUEST['DELETEPASSWORD'] !== ''){
					include(plugin_dir_path(__FILE__).'/regular_board_posting_deletepost.php');
				}else{
					if(count($getCurrentBoard) > 0){
						$userIsBanned = 0;
						if(!is_user_logged_in() && $requirelogged == 1){
							echo '<div class="tinythread"><span class="tinysubject">You are not logged in.</span></div></div>';
						}elseif(!is_user_logged_in() && $requirelogged == 0 || is_user_logged_in()){
							foreach($getCurrentBoard as $gotCurrentBoard){
								$boardName = myoptionalmodules_sanistripents($gotCurrentBoard->NAME);
								$boardShort = myoptionalmodules_sanistripents($gotCurrentBoard->SHORTNAME);
								$boardDescription = rb_format($boardDescription);
								$boardrules = rb_format($gotCurrentBoard->RULES);
								if ($DNSBL === true){
									$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1',' being blacklisted by the DNSBL.','0','0','','0','0','','')");
								}elseif(count($getUser) > 0){
									include(plugin_dir_path(__FILE__).'/regular_board_posting_userbanned.php');
								}elseif($userIsBanned == 0){
									if($THREAD != ''){
										$currentCountNomber = count($countParentReplies);
									}
									if(isset($_POST['FORMSUBMIT'])){
										include(plugin_dir_path(__FILE__).'/regular_board_post_action.php');
									}
									if(!isset($_POST['FORMSUBMIT'])){
										include(plugin_dir_path(__FILE__).'/regular_board_post_form.php');
										if($_REQUEST['DELETEPASSWORD'] == ''){
											include(plugin_dir_path(__FILE__).'/regular_board_delete_post_action.php');
										}
										if($AREA != 'newtopic' && $correct != 3){
											if(count($getposts) > 0){
												include(plugin_dir_path(__FILE__) . '/regular_board_board_loop.php');
											}
										}
										if($THREAD != '' && $threadexists == 1){
											echo '</div><div class="threadinformation"><div class="leftmeta">';
											if($THISBOARD != ''){
												echo '<a href="'.$THISPAGE.'">Return</a>';
											}else{
												echo '<a href="?b='.$BOARD.'">Return</a>';
											}
											echo '<a href="#top">Top</a><span class="reload" data="'.$THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD.'">Update</span></div><i class="fa fa-reply"> '.$THREADREPLIES.'</i> &nbsp; <i class="fa fa-camera-retro"> '.$THREADIMGS.'</i></div>';
										}
										if($threadexists == 1){
											echo '<div class="tinybottom">';
											if($ISUSER === true || $ISUSERJANITOR === true){
												echo '<form name="reporttomods" method="post" action="'.$ACTION.'">';
												wp_nonce_field('reporttomods');
												echo '<section class="full"><input type="text" name="report_ids" id="report_ids" value="" placeholder="Post No." /></section><section class="full"><input type="text" name="report_reason" value="" placeholder="Reason (if reporting)" /></section><section class="full"><input type="password" name="DELETEPASSWORD" id="DELETEPASSWORD" /></section><section class="labels"><label class="submit" title="Edit (password required)" for="edit_this">Edit</label><label class="submit" title="Report" for="report_this">Report</label><label class="submit" title="Delete (password required)" for="delete_this">Delete</label></section><input type="submit" name="edit_this" value="edit" id="edit_this" class="hidden" /><input type="submit" name="report_this" value="report" id="report_this" class="hidden" /><input type="submit" name="delete_this" value="delete" id="delete_this" class="hidden" /></form>';
											}
											if(current_user_can('manage_options') || $ISUSERMOD === true || $ISUSERJANITOR === true){
												echo '<form name="moderator" method="post" action="'.$ACTION.'">';
												wp_nonce_field('moderator');
												echo '<section class="full"><input type="text" name="admin_ids" value="" placeholder="Post No." /></section>';
												if($ISUSERMOD === true || current_user_can('manage_options')){
													echo '<section class="full"><input type="text" name="admin_reason" value="" placeholder="Reason4ban shortname4move" /></section><section class="full"><input type="text" name="admin_length" value="" placeholder="Length of ban (0 for forever)" /></section>';
												}
												echo '<section class="labels">';
												if($ISUSERMOD === true || current_user_can('manage_options')){
													echo '<label class="submit" title="Edit" for="admin_edit">edit</label><label class="submit" title="Move" for="admin_move">move</label><label class="submit" title="Make sticky" for="admin_sticky">sticky</label><label class="submit" title="Lock thread" for="admin_lock">lock</label><label class="submit" title="Unsticky" for="admin_unsticky">unsticky</label><label class="submit" title="Unlock thread" for="admin_unlock">unlock</label><label class="submit" title="Ban" for="admin_ban">ban</label><input type="submit" name="admin_move" value="Move" id="admin_move" class="hidden" /><input type="submit" name="admin_ban" value="Ban" id="admin_ban" class="hidden" /><input type="submit" name="admin_edit" value="Edit" id="admin_edit" class="hidden" /><input type="submit" name="admin_sticky" value="Sticky" id="admin_sticky" class="hidden" /><input type="submit" name="admin_lock" value="Lock" id="admin_lock" class="hidden" /><input type="submit" name="admin_unsticky" value="Unsticky" id="admin_unsticky" class="hidden" /><input type="submit" name="admin_unlock" value="Unlock" id="admin_unlock" class="hidden" />';
												}
												echo '<label class="submit" title="Delete" for="admin_delete"><i class="fa fa-trash-o"></i></label><input type="submit" name="admin_delete" value="Delete" id="admin_delete" class="hidden" /></section></form>';
											}
											echo '</div></div>';
										}
									}
								}
							}
						}
					}else{
						$doesnotexist++;
					}
				}
			}elseif($AREA == 'post'){
				include(plugin_dir_path(__FILE__).'/regular_board_post_action.php');
				echo '</div>';
			}elseif($BOARD == '' && $AREA == '' && $THREAD == '' || $AREA == 'topics' || $AREA  == 'replies' || $AREA  == 'subscribed' || $AREA  == 'following' || $AREA  == 'all'){
				include(plugin_dir_path(__FILE__).'/regular_board_activity_loops.php');
			}elseif($BOARD == '' && $AREA == 'users' && $THREAD == ''){
				include(plugin_dir_path(__FILE__).'/regular_board_user_loop.php');
			}elseif($BOARD == '' && $THREAD != ''){
				include(plugin_dir_path(__FILE__).'/regular_board_single.php');
			}else{
				$doesnotexist++;
			}
		}
		if($doesnotexist > 0){
			rb_404();
		}
		return ob_get_clean();
	}
?>