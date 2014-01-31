<?php 
	if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	
	if(get_option('mommaincontrol_regularboard') == 1) $rb_v = '05492867';
	if(get_option('mommaincontrol_regularboard') == 1) add_action('wp_enqueue_scripts','rb_style');
	if(get_option('mommaincontrol_regularboard') == 1) add_action('wp_head','rb_head');
	if(get_option('mommaincontrol_regularboard') == 1) add_shortcode('regularboard','regularboard_shortcode');
	if(get_option('mommaincontrol_regularboard') == 1) add_filter('the_content','do_shortcode','regularboard_shortcode');

	function rb_404(){
		echo '<div class="tinythread"><span class="tinysubject">404</span></div><div class="tinycomment">
		<p>The resource you are looking for does not exist.</p>
		<hr />
		<p class="information tiny"><i class="fa fa-thumbs-up"></i> Posts and replies can be Approved of (or Disapproved) - which will add (or detract) from your overall Approval rating on this site.
		Ratings are tracked by IP address alone - posting from different IP addresses will obviously mean different Approval ratings for each of your posts.</p>
		<p class="information tiny"><i class="fa fa-user"></i> We use your IP address to identify you, for the purposes of user stats, and for the purposes of board moderation.  Your IP address is never made 
		publicly available.  All users are <em>anonymous</em> (in the sense that there are no names attached to their posts).</p>
		<p class="information tiny"><i class="fa fa-terminal"></i> Did you know that you can format your comments using special code?  Surrounding a word with *s, like *this*, will result in an <em>italicized</em> 
		word, while **this** will result in a <strong>bold</strong> word.  Read <a href="?a=help">this</a> for more information.</p>
		<p class="information tiny"><i class="fa fa-warning"></i> Now that you\'ve made your first post, this information screen will no longer be presented to you.  Instead, in the future, when making new posts,
		you will simply be automatically forwarded to them.  Now go forth - and be a productive member of this community!</p>
		</div></div>';
		echo '<script type="text/javascript">document.title = \'404\';</script>';
	}	
	function get_domain($url){
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
			return $regs['domain'];
		}
		return false;
	}
	function rb_style(){
		global $wp,$post,$rb_v;
		$content = $post->post_content;
		if( has_shortcode( $content, 'regularboard' )){
			$regularboard = plugins_url().'/my-optional-modules/includes/javascript/regularboard'.$rb_v.'.js';
			$regbostyle = WP_PLUGIN_URL . '/my-optional-modules/includes/css/regularboard'.$rb_v.'.css';
			wp_register_style('regular_board',$regbostyle);
			wp_enqueue_style('regular_board');	
			wp_deregister_script('regularboard');
			wp_register_script('regularboard',$regularboard,'','',null,false);
			wp_enqueue_script('regularboard');		
		}
	}
	function rb_head($atts){
		global $wp,$post,$wpdb,$purifier;
		$regularboard_boards  = $wpdb->prefix.'regularboard_boards';
		$regularboard_posts   = $wpdb->prefix.'regularboard_posts';
		$content              = $post->post_content;
		if( has_shortcode( $content, 'regularboard' )){
			$BOARD  = esc_sql(strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b'])));
			$THREAD = esc_sql(intval($_GET['t']));
			if($THREAD != ''){
				$getres = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
			}
			if(count($getres) == 1){
				foreach($getres as $meta){
					// Preset variables to nothing.
					$canonical   = '';
					$author      = '';                     $title       = '';    
					$site        = '';                     $locale      = '';
					$published   = '';                     $last        = '';
					$image       = '';                     $video       = '';
					$description = '';                     $locale      = get_locale();
					$site        = get_bloginfo('name');   $THISPAGE    = home_url('/');
					$pretty = esc_attr(get_option('mommaincontrol_prettycanon'));
					$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b']))));
					
					if($meta->PARENT == 0)$THREAD = intval($_GET['t']);
					if($meta->PARENT != 0)$THREAD = intval($meta->PARENT).'#'.intval($_GET['t']);
					$canonical = $THISPAGE.'?b='.$meta->BOARD.'&amp;t='.$THREAD;
					
					$author          =          $purifier->purify($meta->MODERATOR);
					$title           =          str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',$meta->SUBJECT)));
					if($title       == '')      $title = 'No subject';
					$published       =          $purifier->purify($meta->DATE);
					$last            =          $purifier->purify($meta->LAST);
					$type            =          $purifier->purify($meta->TYPE);
					if($type        == 'image') $purifier->purify($image = $meta->URL);
					if($type        == 'video') $video = 'http://youtube.com/watch?v='.$meta->URL;
					$description     =          $purifier->purify(strip_tags($meta->COMMENT));
					$description     =			str_replace(array('||||','||','*','{{','}}','>>',' >','~~',' - ','----','::','`','    '),'',(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',$description)))))));
					$description     =          substr($description,0,150);
					
					echo "\n";
					if($canonical   != ''){echo '<meta property="og:url" content="'.$canonical.'" />                                   ';echo "\n";}
					if($title       != ''){echo '<meta property="og:title" content="'.$title.'" />                                     ';echo "\n";}
					if($site        != ''){echo '<meta property="og:site_name" content="'.$site.'" />                                  ';echo "\n";}
					if($locale      != ''){echo '<meta property="og:locale" content="'.$locale.'" />                                   ';echo "\n";}
					if($image       != ''){
						echo '<meta property="og:image" content="'.$image.'" />                                     ';echo "\n";}
					if($video       != ''){
						echo '<meta property="og:video" content="http://www.youtube.com/v/'.$meta->URL.'?autohide=1&amp;version=3" />                                     ';echo "\n";
						echo '<meta property="og:video:type" content="application/x-shockwave-flash" />                                                                   ';echo "\n";
						echo '<meta property="og:video:height" content="720" />                                                                                           ';echo "\n";
						echo '<meta property="og:video:width" content="1280" />                                                                                           ';echo "\n";
						echo '<meta property="og:type" content="video" />									                                                              ';echo "\n";
						echo '<meta property="og:image" content="http://img.youtube.com/vi/'.$meta->URL.'/0.jpg" />                                                       ';echo "\n";
					}else{
						if($published   != ''){echo '<meta property="og:published_time" content="'.$published.'" />                        ';echo "\n";}
						if($published   != ''){echo '<meta property="og:modified_time" content="'.$published.'" />                         ';echo "\n";}
						if($last        != ''){echo '<meta property="og:updated" content="'.$last.'" />                                    ';echo "\n";}
						echo '<meta property="og:type" content="article" />                                                                ';echo "\n";
					}
					if($description != ''){echo '<meta property="og:description" content="'.$description.'" />                         ';echo "\n\n";}
				}
			}
		}
	}

	function regularboard_shortcode($atts,$content = null){
		extract( shortcode_atts(array( 'bannedmessage' => 'YOU ARE BANNED', 'postedmessage' => 'POSTED!!!', 'requirelogged' => '0', 'enableurl' => '1', 'enablerep' => '1', 'maxbody' => '1800', 'maxreplies' => '500', 'maxtext' => '75', 'boards' => '', 'loggedonly' => '', 'userflood' => '', 'imgurid' => ''), $atts) );
		global $purifier,$wpdb,$wp,$post,$ipaddress,$rand,$randnum1,$randnum2,$rb_v;
		$boardid = $boardname = $boardshort = $boarddescription = $boardmods = $boardjans = $boardposts = '';
		$wordpressname = get_bloginfo('name');
		$thisimageupload = '';
		if($imgurid != '' && isset($_POST['submitimgur'])){
			$img = $_FILES['img'];
			if($img['name'] == ''){
			}else{
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
				}else{
				}
			}
		}		
		$doesnotexist																			  = 0;
		myoptionalmodules_checkdnsbl($checkThisIP);
		$theIP                                                                                    = esc_sql($ipaddress);
		$theIP_s32int                                                                             = esc_sql(ip2long($ipaddress));
		$theIP_us32str                                                                            = esc_sql(sprintf("%u",$theIP_s32int));
		$checkThisIP                                                                              = esc_sql($theIP);
		$current_timestamp                                                                        = date('Y-m-d H:i:s');
		$requirelogged                                                                            = intval($requirelogged);
		$maxreplies                                                                               = intval($maxreplies);
		$maxbody                                                                                  = intval($maxbody);
		$maxtext                                                                                  = intval($maxtext);
		$loggedonly                                                                               = $loggedonly;
		$bannedmessage                                                                            = $bannedmessage;
		$postedmessage                                                                            = $postedmessage;
		$regularboard_boards                                                                      = $wpdb->prefix.'regularboard_boards';
		$regularboard_posts                                                                       = $wpdb->prefix.'regularboard_posts';
		$regularboard_users                                                                       = $wpdb->prefix.'regularboard_users';
		$QUERY                                                                                    = esc_sql(myoptionalmodules_sanistripents($_SERVER['QUERY_STRING']));
		$SEARCH						                                         	                  = '';
		$modishere                                                                                = '';
		$THREADIMGS                                                                               = '';
		$blog_title                                                                               = get_bloginfo();
		$BOARD                                                                                    = esc_sql(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b']));
		$AREA                                                                                     = esc_sql(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['a']));
		$VOTE                                                                                     = intval($_GET['v']);
		$PROFILE                                                                                  = intval($_GET['u']);
		$THREAD                                                                                   = intval($_GET['t']);
		$profileid = $PROFILE                                                                     = intval($PROFILE);
		$BOARD                                                                                    = strtolower($BOARD);
		$AREA                                                                                     = strtolower($AREA);
		$ISUSERMOD                                                                                = false;
		$ISUSER                                                                                   = true;
		$posting                                                                                  = 1;
		$postsperpage                                                                             = 50;		
			$myinformation                                                                            = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
			$iexist = 0;
			if(count($myinformation) > 0){
				foreach($myinformation as $myinfo){
					$profilekarma = intval($myinfo->KARMA);
					$profileid = intval($myinfo->ID);
					$profileheaven = intval($myinfo->HEAVEN);
					$profilevideo = intval($myinfo->VIDEO);
					if($profilevideo == '')$profilevideo = 0;
					$profilepassword = esc_sql($myinfo->PASSWORD);
					$profilefollow = esc_sql($myinfo->FOLLOWING);
					$following = esc_sql($profilefollow);
					$boards = esc_sql($myinfo->BOARDS);
					$following = esc_sql($myinfo->FOLLOWING);
					$profileboards = esc_sql($myinfo->BOARDS);
					$iexist = 1;
				}
			}
		$getBoards                                                                                = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME != '' ORDER BY NAME ASC");
		$getRules																				  = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '' LIMIT 1");
		if($boards != '') $boards                                                                 = explode(',',$boards);
		if($boards != '') $boards                                                                 = array_map('rb_apply_quotes',$boards);
		if($following != '') $following                                                           = explode(',',$following);
		if($following != '') $following                                                           = array_map('rb_apply_quotes',$following);
		if(isset($_POST['searchsub']) && $_REQUEST['boardsearch'] != '') $SEARCH                  = esc_sql(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_REQUEST['boardsearch'])));
		if($BOARD != '')  $getCurrentBoard                                                        = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '".$BOARD."' LIMIT 1");
		if(count($getCurrentBoard) > 0 && $BOARD != ''){
			foreach($getCurrentBoard as $currentBoardInformation){
				$lock             = intval($currentBoardInformation->LOCKED);
				$boardid          = intval($currentBoardInformation->ID);
				$boardname        = $currentBoardInformation->NAME;
				$boardshort       = $currentBoardInformation->SHORTNAME;
				$boarddescription = str_replace(array('||||','||','*','{{','}}','>>',' >','~~',' - ','----','::','`','    ','\\','\\n','\\t','\\r'),'',$currentBoardInformation->DESCRIPTION);
				$boardrules       = $currentBoardInformation->RULES;
				$boardmods        = $currentBoardInformation->MODS;
				$boardjans        = $currentBoardInformation->JANITORS;
				$boardposts       = intval($currentBoardInformation->BOARDPOSTS);
				$requirelogged    = intval($currentBoardInformation->LOGGED);
				$boardsfw         = $currentBoardInformation->SFW;
				$boardheader      = '<div class="tinythread"><span class="tinysubject"><a href="?b='.$boardshort.'">'.$boardname.'</a></span><span class="tinyreplies">'.$boardsfw.'</span><span class="tinydate">'.$boardshort.'</span></div>
				                     <div class="tinythread"><span class="tinysubject">'.$boarddescription.'</span></div>';
				echo '<script type="text/javascript">document.title = \''.$boardname.' / '.$boardshort.'\';</script>';
			}
		}else{
				$boardheader     = '<div class="tinythread"><span class="tinysubject">'.get_bloginfo('name').'</span><span class="tinyreplies"><a title="Regular Board v.'.$rb_v.'" href="https://github.com/onebillion/mom">'.$rb_v.'</a></span></div>';
		}
		if($BOARD != '' )$getBoards                                                               = $wpdb->get_results("SELECT * FROM $regularboard_boards ORDER BY SHORTNAME ASC");
		if($BOARD != '' )$getUser                                                                 = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = 1 LIMIT 1");
		if($BOARD != '' )$getLastPost                                                             = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = '".$theIP_us32str."' ORDER BY ID DESC LIMIT 1");
		if($BOARD != '' && $THREAD == '') $targetpage                                             = '?b='.$BOARD;
		if($BOARD != '' && $THREAD == '') $countpages                                             = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0");
		if($BOARD != '' && $THREAD == '') $totalpages                                             = count($countpages);
		if($BOARD != '' && $THREAD == '') $results                                                = intval($_GET['n']);
		if($BOARD != '' && $THREAD == '') if($results){$start                                     = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD != '' && $THREAD == '') if($SEARCH == '') $getposts                       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0 ORDER BY STICKY DESC, LAST DESC LIMIT $start,$postsperpage");
		if($BOARD != '' && $THREAD == '') if($SEARCH != '') $getposts                       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ( EMAIL = '".$SEARCH."' OR COMMENT LIKE '%".$SEARCH."%' OR SUBJECT LIKE '%".$SEARCH."%' OR URL LIKE '%".$SEARCH."%' ) AND BOARD = '".$BOARD."' ORDER BY ID");
		if($BOARD != '' && $THREAD != '')	$getposts                                       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND ID = '".$THREAD."' AND PARENT = 0 LIMIT 1");
		if($BOARD != '' && $THREAD != '') $countParentReplies                                     = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = '".$THREAD."'");
		if($BOARD != '' && $THREAD != '') $THREADREPLIES = $THREADIMGS                            = 0;
		if($AREA == 'topics' || $BOARD == '' && $AREA == '' && $THREAD == '') $countpages                              = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE PARENT = 0");
		if($AREA == 'topics' || $BOARD == '' && $AREA == '' && $THREAD == '') $totalpages                              = count($countpages);
		if($AREA == 'topics' || $BOARD == '' && $AREA == '' && $THREAD == '') $results                                 = intval($_GET['n']);
		if($AREA == 'topics' || $BOARD == '' && $AREA == '' && $THREAD == '') if($results){$start                      = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($AREA == 'topics' || $BOARD == '' && $AREA == '' && $THREAD == '') $getposts                          = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = 0 ORDER BY DATE DESC LIMIT $start,$postsperpage");
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $countpages                       = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE PARENT != 0");
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $totalpages                       = count($countpages);
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $results                          = intval($_GET['n']);
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') if($results){$start               = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $getposts                   = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT != 0 ORDER BY DATE DESC LIMIT $start,$postsperpage");		
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') $countpages                           = $wpdb->get_results("SELECT ID FROM $regularboard_posts");
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') $totalpages                           = count($countpages);
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') $results                              = intval($_GET['n']);
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') if($results){$start                   = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') $getposts                       = $wpdb->get_results("SELECT * FROM $regularboard_posts ORDER BY DATE DESC LIMIT $start,$postsperpage");
		if($BOARD == '' && $AREA == 'users' && $THREAD == '') $countpages                           = $wpdb->get_results("SELECT ID FROM $regularboard_users WHERE BANNED = 8");
		if($BOARD == '' && $AREA == 'users' && $THREAD == '') $totalpages                           = count($countpages);
		if($BOARD == '' && $AREA == 'users' && $THREAD == '') $results                              = intval($_GET['n']);
		if($BOARD == '' && $AREA == 'users' && $THREAD == '') if($results){$start                   = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'users' && $THREAD == '') $getposts                       = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 8 ORDER BY ID DESC LIMIT $start,$postsperpage");
		
		
		
		$tlast = 0;
		if($THREAD != ''){
			if($AREA != 'newtopic'){
				$getParentAuthor = $wpdb->get_results("SELECT USERID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND ID = $THREAD LIMIT 1");
				$getReplyAuthor  = $wpdb->get_results("SELECT USERID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = $THREAD ORDER BY ID ASC LIMIT 1");
				if(count($getParentAuthor) > 0){
					foreach($getParentAuthor as $tauthor){
						if($tauthor->USERID == $profileid)$tlast++;
					}
				}
				if(count($getReplyAuthor) > 0){
					foreach($getReplyAuthor as $rauthor){
						if($rauthor->USERID == $profileid)$tlast++;
					}
				}
			}
		}
		
		
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $countpages            = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD IN (".join(',',$boards).")");
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $totalpages            = count($countpages);
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $results               = intval($_GET['n']);
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') if($results){$start    = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $getposts        = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD IN (".join(',',$boards).") ORDER BY DATE DESC LIMIT $start,$postsperpage");

		if($BOARD == '' && $AREA == 'following' && $THREAD == '') $countpages             = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE USERID IN (".join(',',$following).")");
		if($BOARD == '' && $AREA == 'following' && $THREAD == '') $totalpages             = count($countpages);
		if($BOARD == '' && $AREA == 'following' && $THREAD == '') $results                = intval($_GET['n']);
		if($BOARD == '' && $AREA == 'following' && $THREAD == '') if($results){$start     = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'following' && $THREAD == '') $getposts         = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE USERID IN (".join(',',$following).") ORDER BY DATE DESC LIMIT $start,$postsperpage");		
		
		if($BOARD == '' && $THREAD != '')$post = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
		
		if($PROFILE != '') $reviews_table                                                         = $wpdb->prefix.'momreviews';
		if($PROFILE != '') $usprofile                                                             = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE ID = $profileid AND BANNED = 8 LIMIT 1");
		if($PROFILE != '') $ktrophies                                                             = $wpdb->get_results("SELECT * FROM $reviews_table WHERE TYPE = 'karma' OR TYPE='activeposts'");

		// User role
		$current_user                                                                             = wp_get_current_user();
		$current_user_login                                                                       = $current_user->user_login;
		if(current_user_can('manage_options')) $ISMODERATOR                                       = true;
		if($boardmods != '') $usermods                                                            = explode(',',$boardmods);
		if($boardmods != '') if(in_array($current_user_login,$usermods)) $ISUSERMOD               = true;
		if($usermod != '') $usermod                                                               = array($usermod);
		if($boardjans != '') $userjanitors                                                        = explode(',',$boardjans);
		if($boardjans != '') if(in_array($current_user_login,$userjanitors)) $ISUSERJANITOR       = true;
		if($ISMODERATOR   === true) $ISUSER                                                       = false;
		if($ISUSERMOD     === true) $ISUSER                                                       = false;
		if($ISUSERJANITOR === true) $ISUSER                                                       = false;		

		if($AREA == 'bans' && $ISMODERATOR === true) $getUsers                                    = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 1");
		if($ISMODERATOR === true)$getReports                                                      = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 3");
		
		if($lock == 1){
			if($ISUSER === true)$posting = 0;
			if($ISUSER !== true)$posting = 1;
		}
		
		$THISPAGE      = get_permalink();

		foreach($getBoards as $cboard){
			$BOARDRULES = rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($cboard->RULES)))))));
		}
		
		if($BOARD != '' && $THREAD != '' && $ID == $THREAD)$ACTION = $THISPAGE.'?b='.$BOARD;
		elseif($BOARD != '' && $THREAD == '')$ACTION = $THISPAGE.'?b='.$BOARD;
		elseif($BOARD != '' && $THREAD != '')$ACTION = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;
		
		if($ipaddress === false){
		
		}else{
		
		
		
					// Admin Form Handling
					if(current_user_can('manage_options') || $ISUSERMOD === true || $ISUSERJANITOR === true){
						if(isset($_REQUEST['admin_ids']))$ID2SET = $_REQUEST['admin_ids'];
						if(current_user_can('manage_options') || $ISUSERMOD === true){
							if(isset($_POST['admin_lock']) && $ID2SET != '')$doLock = $wpdb->update($regularboard_posts,array('LOCKED' => 1),array('ID' => $ID2SET),array('%d'));
							if(isset($_POST['admin_unlock']) && $ID2SET != '')$doUnlock = $wpdb->update($regularboard_posts, array('LOCKED' => 0), array('ID' => $ID2SET),array('%d'));
							if(isset($_POST['admin_sticky']) && $ID2SET != '')$doSticky = $wpdb->update($regularboard_posts,array('STICKY' => 1), array('ID' => $ID2SET),array('%d'));
							if(isset($_POST['admin_unsticky']) && $ID2SET != '')$doUnsticky = $wpdb->update($regularboard_posts,array('STICKY' => 0), array('ID' => $ID2SET),array('%d'));	
						}
						if(isset($_POST['admin_delete']) && $ID2SET != ''){
							$delete = 0;
							$getIDfromID = $wpdb->get_results("SELECT PARENT FROM $regularboard_posts WHERE ID = $ID2SET LIMIT 1");
							if(current_user_can('manage_options')){
								$delete++;
								$wpdb->delete($regularboard_posts, array('ID' => $ID2SET),array('%d'));
								foreach($getIDfromID as $parentCheck){
									$delete++;
									$parent = $parentCheck->PARENT;
									if($PARENT == 0){
										$wpdb->delete($regularboard_posts,array('PARENT' => $ID2SET),array('%d'));
									}
								}
								$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT - ".$delete." WHERE SHORTNAME = '$BOARD'");
							}
							if($ISUSERMOD === true || $ISUSERJANITOR === true){
								$delete = 0;
								$wpdb->delete($regularboard_posts,array('ID' => $ID2SET,'MODERATOR' => 0),array('%d'));
								foreach($getIDfromID as $parentCheck){
									$delete++;
									$parent = $parentCheck->PARENT;
									if($PARENT == 0){
										$wpdb->delete($regularboard_posts,array('PARENT' => $ID2SET),array('%d'));
									}
								}
								$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT - ".$delete." WHERE SHORTNAME = '$BOARD'");								
							}
						}
						if(isset($_POST['admin_move']) && $ID2SET != '' && $_REQUEST['admin_reason'] != ''){
							$getIDfromID = $wpdb->get_results("SELECT PARENT FROM $regularboard_posts WHERE ID = $ID2SET LIMIT 1");
							$setBoard = esc_sql($_REQUEST['admin_reason']);
							if(current_user_can('manage_options')){
								$wpdb->update($regularboard_posts,
								array('BOARD' => $setBoard),
								array('ID' => $ID2SET), 
								array('%s'));

								foreach($getIDfromID as $parentCheck){
									$parent = $parentCheck->PARENT;
									if($PARENT == 0){
										$wpdb->update($regularboard_posts,
										array('BOARD' => $setBoard),
										array('PARENT' => $ID2SET),
										array('%s'));
									}
								}
							}
							
							if($ISUSERMOD === true || $ISUSERJANITOR === true){
								$wpdb->update($regularboard_posts,
								array('BOARD' => $setBoard),
								array('ID' => $ID2SET,'MODERATOR' => 0),
								array('%s'));

								foreach($getIDfromID as $parentCheck){
									$parent = $parentCheck->PARENT;
									if($PARENT == 0){
										$wpdb->update($regularboard_posts,
										array('BOARD' => $setBoard),
										array('PARENT' => $ID2SET),
										array('%s'));
									}
								}
							}
						}
						if(isset($_POST['admin_ban']) && $ID2SET != ''){
							if(current_user_can('manage_options')){
								$getIPfromID = $wpdb->get_results("SELECT IP FROM $regularboard_posts WHERE ID = $ID2SET LIMIT 1");
								foreach($getIPfromID as $gotIP){
									$IP = $gotIP->IP;
									$PARENT = $gotIP->PARENT;
									$MESSAGE = esc_sql($_REQUEST['admin_reason']);
									$LENGTH = esc_sql($_REQUEST['admin_length']);
									$wpdb->query(
										$wpdb->prepare(
											"INSERT INTO $regularboard_users 
											( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) 
											VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s,%s )",
											'',
											$current_timestamp,
											$IP,
											$ID2SET,
											$PARENT,
											$BOARD,
											1,
											$MESSAGE,
											$LENGTH,
											0,
											'',
											0,
											0,
											'',
											''
										)
									);
								}
							}
							if($ISUSERMOD === true){
								$getIPfromID = $wpdb->get_results("SELECT IP FROM $regularboard_posts WHERE ID = $ID2SET AND MODERATOR != 1 LIMIT 1");
								foreach($getIPfromID as $gotIP){
									$IP      = $gotIP->IP;
									$PARENT  = $gotIP->PARENT;
									$MESSAGE = esc_sql($_REQUEST['admin_reason']);
									$LENGTH = esc_sql($_REQUEST['admin_length']);
									$wpdb->query(
										$wpdb->prepare(
											"INSERT INTO $regularboard_users 
											( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) 
											VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%d,%s,%s,%s,%s )",
											'',
											$current_timestamp,
											$IP,
											$ID2SET,
											$PARENT,
											$BOARD,
											1,
											$MESSAGE,
											$LENGTH,
											0,
											'',
											0,
											0,
											'',
											''
										)
									);
								}
							}
						}
					}
			
			ob_start();
			echo '<div class="boardAll">';

			if($ISMODERATOR === true && count($getReports) > 0){ echo '<div class="tinythread"><span class="tinysubject"><a href="?a=reports">'.count($getReports).' reports need your attention.</a></span></div>';}
			
			echo $boardheader;
			
				if(count($getBoards) > 0){
					echo '<div class="tinythread"><div class="boards"><span>boards</span> ';
					foreach($getBoards as $gotBoards){
						$short = $gotBoards->SHORTNAME;
						echo '<span><a href="?b='.$short.'">'.$short.'</a></span>';
					}
					echo '</div></div>';
				}			
			
			echo '<div class="userbar">';
			if($iexist == 1 && $profileboards != ''){echo '<a href="?a=subscribed">subscribed</a>';}if($iexist == 1 && $profilefollow != ''){echo '<a href="?a=following">following</a>';}echo '<a href="?a=topics">topics</a><a href="?a=replies">replies</a><a href="?a=all">all</a><a href="?a=stats">stats</a><a href="?a=users">users</a>';if($ISMODERATOR === true){echo '<a href="?a=create">admin</a>';}if($iexist == 1){echo '<a href="?u='.$profileid.'">history</a>';}if($iexist == 1){echo '<a href="?a=options">options</a>';}echo '<a href="?a=help">help</a><a href="?a=info">info</a>';if($BOARD != '' && $posting == 1 && $iexist == 1 && $AREA != 'newtopic'){echo '<a class="newtopic" href="'.$THISPAGE.'?b='.$BOARD.'&amp;a=newtopic">New topic</a><span class="hidden notopic">Cancel new topic</span>'; }
			echo '</div><div class="newtopic"></div>';

			if($imgurid != ''){if(!isset($_POST['submitimgur'])){echo '<div class="tinythread"><form class="imgur" enctype="multipart/form-data" method="POST"><span class="tinysubject"><input name="img" size="35" type="file"/></span><span class="tinyreplies"><input type="submit" id="submitimgur" name="submitimgur" value="Upload"/></span></form></div>';}else{echo '<div class="tinythread"><span class="tinysubject">Image URL:'.$thisimageupload.'</span></div><div class="tinycomment"><img src="'.$thisimageupload.'" class="imageOP" alt="'.$thisimageupload.'" /></div>';}}
			
			if($THREAD != '' && $AREA == 'vote' && $VOTE != ''){
			
				$checkforupvote   =  0;
				$checkfordownvote =  0;
				$getvotestatus    =  $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND THREAD = '".$THREAD."'");
				$getthreadkarma   =  $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
				foreach($getthreadkarma as $karma){
					$points = intval($karma->UP);
					$user = intval($karma->USERID);
				}
				foreach($getvotestatus as $votestatus){
					if($votestatus->MESSAGE == 'Upvote')$checkforupvote++;
					if($votestatus->MESSAGE == 'Downvote')$checkfordownvote++;
				}
				if($VOTE == 2){
					$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
					foreach($getUP as $gotUP){
						$UP = $gotUP->UP;
						$up = $UP + 1;
						$down = $UP - 1;
					}
					$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
					foreach($getUSER as $USERED){
						$KARMA = $USERED->KARMA;
						$kup = $KARMA + 1;
						$kdown = $KARMA - 1;
					}											
					if($checkfordownvote > 0){
						$wpdb->delete( $regularboard_users, array( 'THREAD' => $THREAD, 'IP' => $theIP_us32str),array( '%d','%d') );
						$wpdb->update( $regularboard_posts, array( 'UP' => $up ), array( 'ID' => $THREAD), array( '%d') );
						$wpdb->update( $regularboard_users, array( 'KARMA' => $kup ), array( 'ID' => $user, 'BANNED' => '8'), array( '%d','%d') );
						echo '<span class="points">'.($points + 1).'</span>';
					}
					if($checkfordownvote == 0){
						$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','$THREAD','0','9','Downvote','','0','','0','0','','')");
						$wpdb->update( $regularboard_posts, array( 'UP' => $down ), array( 'ID' => $THREAD), array( '%d') );
						$wpdb->update( $regularboard_users, array( 'KARMA' => $kdown ), array( 'ID' => $user, 'BANNED' => '8'), array( '%d') );
						echo '<span class="points">'.($points - 1).'</span>';
					}
				}
				if($VOTE == 1){
					$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
					foreach($getUP as $gotUP){
						$UP = $gotUP->UP;
						$up = $UP + 1;
						$down = $UP - 1;
					}
					$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
					foreach($getUSER as $USERED){
						$KARMA = $USERED->KARMA;
						$kup = $KARMA + 1;
						$kdown = $KARMA - 1;
					}																			
					if($checkforupvote > 0){
						$wpdb->delete($regularboard_users, array('THREAD' => $THREAD, 'IP' => $theIP_us32str),array( '%d','%d') );
						$wpdb->update($regularboard_posts, array( 'UP' => $down ), array( 'ID' => $THREAD), array( '%d') );
						$wpdb->update($regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $theIP_us32str, 'BANNED' => '8'), array( '%d','%d') );
						echo '<span class="points">'.($points - 1).'</span>';
					}
					if($checkforupvote == 0){
						$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','$THREAD','0','9','Upvote','','0','','0','0','','')");
						$wpdb->update($regularboard_posts, array( 'UP' => $up ), array( 'ID' => $THREAD), array( '%d') );
						$wpdb->update($regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $theIP_us32str, 'BANNED' => '8'), array( '%d') );
						echo '<span class="points">'.($points + 1).'</span>';
					}
				}
				echo '</div>';
			
			}elseif($AREA == 'options' && $iexist == 1){
				if(isset($_POST['options'])){
					$password = esc_sql($_REQUEST['password']); $heaven = intval($_REQUEST['heaven']); $video = intval($_REQUEST['video']); $boards = esc_sql($_REQUEST['boards']); $follow = esc_sql($_REQUEST['follow']); $wpdb->query("UPDATE $regularboard_users SET VIDEO = $video WHERE ID = $profileid"); $wpdb->query("UPDATE $regularboard_users SET HEAVEN = $heaven WHERE ID = $profileid"); $wpdb->query("UPDATE $regularboard_users SET PASSWORD = '$password' WHERE ID = $profileid"); $wpdb->query("UPDATE $regularboard_users SET BOARDS = '$boards' WHERE ID = $profileid"); $wpdb->query("UPDATE $regularboard_users SET FOLLOWING = '$follow' WHERE ID = $profileid"); echo '<meta http-equiv="refresh" content="0;URL=?a=options">'; 
				}
				if(isset($_POST['donatenow']) && $_REQUEST['donate'] != '' && $_REQUEST['points'] != ''){$points = intval($_REQUEST['points']);$to = intval($_REQUEST['donate']);if($points <= $profilekarma){$wpdb->query("UPDATE $regularboard_users SET KARMA = KARMA - $points WHERE ID = $profileid");$wpdb->query("UPDATE $regularboard_users SET KARMA = KARMA + $points WHERE ID = $to");echo '<meta http-equiv="refresh" content="0;URL=?a=options">';}}echo '<div class="tinythread"><span class="tinysubject">You have '.$profilekarma.' points - enter user ID to donate to</span></div><form method="post" class="COMMENTFORM boardcreation" name="donatepoints" action="?a=options">';wp_nonce_field('donatepoints');echo '<section class="full"><p>Donate points to this user:</p><input type="text" name="donate" id="donate" value="" placeholder="User ID to donate to" /></section><section class="full"><p>Amount of points to donate (will be taken from your total):</p><input type="text" name="points" id="points" value="" placeholder="Amount" /></section><section class="full"><label class="create" for="donatenow">Donate now!</label><input class="hidden" type="submit" name="donatenow" id="donatenow" value="Donate now!" /></section></form><hr /><div class="tinythread"><span class="tinysubject">Options</span></div><form method="post" class="COMMENTFORM boardcreation" name="useroptions" action="?a=options">';wp_nonce_field('useroptions');echo '<section class="full"><p>Set a password to use on every post you make (default password is always random):</p><input type="text" name="password" id="password" value="'.$profilepassword.'" placeholder="'.$rand.'" /></section><hr /><section class="full"><p>Comma-separated list of boards you wish to subscribe to (available boards below) (example: board, board, board):<br />';foreach($getBoards as $board){echo '<span class="board">'.$board->SHORTNAME.'</span>';}echo '</p><input type="text" name="boards" id="boards" value="'.$profileboards.'" placeholder="Boards" /></section><hr /><section class="full"><p>Comma-separated list of user IDs to follow:<br /></p><input type="text" name="follow" id="follow" value="'.$profilefollow.'" placeholder="User IDs" /></section><hr /><section class="full"><p>Whether or not you wish the e-mail field to be prepopulated with <code>heaven</code></p><select class="full" name="heaven" id="heaven"><option ';if($profileheaven == 0){echo 'selected="selected" ';}echo 'value="0">Always heaven off</option><option ';if($profileheaven == 1){echo 'selected="selected" ';} echo 'value="1">Always heaven on</option></select></section><hr /><section class="full"><p>Whether or not you wish Youtube embeds to be enabled</p><select class="full" name="video" id="video"><option ';if($profilevideo == 0){echo 'selected="selected" ';}echo 'value="0">Show embedded Youtube videos</option><option ';if($profilevideo == 1){echo 'selected="selected" ';}echo 'value="1">Display a link to the video without embedding it</option></select></section><hr /><section class="full"><label class="create" for="options">Save these options</label><input class="hidden" type="submit" name="options" id="options" value="Save these options" /></section></form></div><script type="text/javascript">document.title = \'Options\';</script>';
			}elseif($AREA == 'info'){
				echo '<div class="tinythread"><span class="tinysubject">Rules</span></div>';if(count($getRules) > 0){foreach($getRules as $gotRules){$rules = wpautop(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($gotRules->RULES)))))))));echo '<div class="tinythread"><span class="tinysubject">Rules (all boards)</span></div><div class="tinycomment">'.$rules.'</div>';}}if(count($getBoards) > 0){foreach($getBoards as $gotBoards){$description = wpautop(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($gotBoards->DESCRIPTION)))))))));$short = $gotBoards->SHORTNAME;$name = $gotBoards->NAME;$sfw = $gotBoards->SFW;$rules = wpautop(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($gotBoards->RULES)))))))));if($gotBoards->LOCKED == 0){$posting = '<p><i class="fa fa-unlock"> Board unlocked, posting enabled.</i></p>';}if($gotBoards->LOCKED == 1){$posting = '<p><i class="fa fa-lock"> Board locked, posting disabled.</i></p>';}echo '<div class="tinythread"><span class="tinysubject"><a href="?b='.$short.'">'.$name.'</a></span><span class="tinyreplies">'.$sfw.'</span><span class="tinydate">'.$short.'</span></div><div class="tinycomment">'.$description.'<hr />'.$rules.'<hr />'.$posting.'</div>';}echo '</div>';}
			
			}elseif($PROFILE != ''){
				if(count($usprofile) > 0){
					foreach($usprofile as $theprofile){
						$userip    = intval($theprofile->IP);
						$countpages                                             = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE USERID = $PROFILE AND EMAIL != 'heaven'");
						$totalpages                                             = count($countpages);
						$results                                                = intval($_GET['n']);
						if($results){$start                                     = ($results - 1) * $postsperpage;}else{$start = 0;}
						$count = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE USERID = $PROFILE AND EMAIL != 'heaven' ORDER BY DATE DESC");
						$posts  = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE USERID = $PROFILE AND EMAIL != 'heaven' ORDER BY DATE DESC LIMIT $start,$postsperpage");
						$postcount = count($countpages);
						$userid    = intval($theprofile->ID);
						$userkarma = intval($theprofile->KARMA);
						
						$dust = 0;
						echo '<div class="tinystats"><div id="trophycase"><div class="tinythread"><span class="tinysubject">Achievement</span><span class="tinyreplies">Count</i></span><span class="tinydate">Description</span></div>';
						foreach($ktrophies as $k){
							if($userkarma >= $k->RATING && $k->TYPE == 'karma'){
								$dust++;
								echo '<div class="tinythread"><span class="tinysubject">'.$k->TITLE.'</span><span class="tinyreplies">'.$dust.'</span><span class="tinydate">'.str_replace(array('<p>','</p>'),'',$k->REVIEW).'</span></div>';
							}
							if($postcount >= $k->RATING && $k->TYPE == 'activeposts'){
								$dust++;
								echo '<div class="tinythread"><span class="tinysubject">'.$k->TITLE.'</span><span class="tinyreplies">'.$dust.'</span><span class="tinydate">'.str_replace(array('<p>','</p>'),'',$k->REVIEW).'</span></div>';
							}
						}			
						
						echo '<hr />';
						
						if(count($posts) > 0){
							echo '<div class="tinystats"><div id="trophycase"><div class="tinythread"><span class="tinysubject">Active posts: '.$postcount.'</span><span class="tinyreplies"> '.($userkarma + $dust).'</i></span><span class="tinydate">First seen '.timesincethis($theprofile->DATE).'</span></div>';
							foreach($posts as $thisuserposts){
								if(intval($thisuserposts->UP) >= 1){
									echo '<div id="'.intval($thisuserposts->ID).'" class="tinythread">';
									$board =  $thisuserposts->BOARD;
									$id =  $thisuserposts->ID;
									$date =  $thisuserposts->DATE;
									$parent =  '';
									if($thisuserposts->PARENT == 0){ $posttype = 'new thread'; }
									if($thisuserposts->PARENT != 0){ $posttype = 'new reply'; }
									$bl =  $wpdb->get_results("SELECT URL FROM $regularboard_boards WHERE SHORTNAME = '".$board."' LIMIT 1");
									if($thisuserposts->PARENT != 0)$parent = $thisuserposts->PARENT;
									if($thisuserposts->PARENT  > 0)$parent = 't='.$parent.'#'.$id;
									if($thisuserposts->PARENT == 0)$parent = 't='.$id;
									$link = $THISPAGE.'?b='.$board.'&amp;'.$parent;
									$SUBJECT =  str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($thisuserposts->SUBJECT))))))));
									echo '<span class="tinysubject"><a href="'.$link.'">';if($SUBJECT != ''){echo $SUBJECT;}else{echo 'No subject specified';}echo '</a><i id="'.$id.'" class="fa fa-plus-square loadme hidden" data="'.$THISPAGE.'?t='.$id.'"></i><i id="'.$id.'" class="fa fa-minus-square hideme hidden"></i></span></span><span class="tinyreplies">'.intval($thisuserposts->UP).'</span><span class="tinydate">'.timesincethis($date).' <a href="?t='.intval($thisuserposts->ID).'">##</a></span><div id="load'.$id.'"></div></div>';
								}
							}
							echo '</div></div>';
						}else{echo '<div class="tinythread"><span class="tinysubject">User has not contributed anything.</span></div>';}echo '</div></div>';
					}
				}
				$i       = 0;
				$results = intval($_GET['n']);
				$paging  = round($totalpages / $postsperpage);
				if($paging > 0){$pageresults = round($paging / 10);echo '<div class="pages">';if($results > 1) echo '<a href="?u='.$PROFILE.'">Latest</a> ';if($results > 2)echo '<a href="?b='.$PROFILE.'&amp;n='.($results - 1).'">Newer</a> ';if($paging > 1 && $results < $paging && $results == '')echo '<a href="?u='.$PROFILE.'&amp;n=2">Older</a> ';if($results < $paging && $results != '')echo '<a href="?u='.$PROFILE.'&amp;n='.($results + 1).'">Older</a> ';echo '</div>';}
				echo '</div>';
				
			}elseif($AREA == 'stats'){
					echo '<table class="stats">';
					if(count($getBoards) > 0){
					echo '<tr valign="top">
					<td><strong>Board</strong></td>
					<td><strong>10 minutes</strong></td>
					<td><strong>2 hours</strong></td>
					<td><strong>12 hours</strong></td>
					<td><strong>1 day</strong></td>
					<td><strong>Posts (all)</strong></td>
					<td><strong>Mod posts (all)</strong></td>
					<td><strong>User posts (all)</strong></td>
					<td><strong>You</strong></td>
					</tr>';					
						foreach($getBoards as $gotBoards){
						echo '<tr valign="top">';
							$BOARDNAME = esc_sql(myoptionalmodules_sanistripents($gotBoards->SHORTNAME));
							$BOARDLONG = esc_sql(myoptionalmodules_sanistripents($gotBoards->NAME));
							$countPosts  = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."'");
							$min10_t   = 0;
							$hou02_t   = 0;
							$hou12_t   = 0;
							$hou24_t   = 0;
							$count     = 0;
							$mod       = 0;
							$usr       = 0;
							$iposted   = 0;
							$currently = strtotime($current_timestamp);
							foreach($countPosts as $counted){
								$timedif = strtotime($counted->DATE);
								$moderator = $counted->MODERATOR;
								$type = $counted->TYPE;
								if($currently - 600 <= $timedif && $timedif + 600 >= $currently)$min10_t++;
								if($currently - 7200 <= $timedif && $timedif + 7200 >= $currently)$hou02_t++;
								if($currently - 43200 <= $timedif && $timedif + 43200 >= $currently)$hou12_t++;
								if($currently - 86400 <= $timedif && $timedif + 86400 >= $currently)$hou24_t++;
								if($moderator >  0)$mod++;
								if($moderator == 0)$usr++;									
								if($counted->IP == $theIP_us32str)$iposted++;
								$count++;
							}
							echo '<td><a href="?b='.$BOARDNAME.'">'.$BOARDNAME.'</a></td>';
							echo '
							<td>'.$min10_t.'</td>
							<td>'.$hou02_t.'</td>
							<td>'.$hou12_t.'</td>
							<td>'.$hou24_t.'</td>
							<td>'.$count.'</td>
							<td>'.$mod.'</td>
							<td>'.$usr.'</td>
							<td>'.$iposted.'</td>'
							;
						echo '</tr>';
						}
					}
					echo '</table></div>';
				}elseif($AREA == 'help'){
					echo '<div class="tinythread">Images may only be linked to from these sites</div><hr /><div class="tinythread">E-mail field</div><div class="tinythread"><span class="tinyspan">You type</span><span class="tinyspan">You get</span></div><div class="tinythread"><span class="tinyspan">heaven</span><span class="tinyspan">Post is not tied to your public profile.</span></div><div class="tinythread"><span class="tinyspan">sage</span><span class="tinyspan">Do not bump a thread (if replying).</span></div><hr /><div class="tinythread">Comment formatting</div><div class="tinythread"><span class="tinyspan">You type</span><span class="tinyspan">You get</span></div><div class="tinythread"><span class="tinyspan">**bold**</span><span class="tinyspan"><strong>bold</strong></span></div><div class="tinythread"><span class="tinyspan">*italics*</span><span class="tinyspan"><em>italics</em></span></div><div class="tinythread"><span class="tinyspan">***bold and italic***</span><span class="tinyspan"><strong><em>bold and italic</em></strong></span></div><div class="tinythread"><span class="tinyspan"> >>#>> (where # is the post number of a reply)</span><span class="tinyspan"><a href="#1"> >> 1</a></span></div><div class="tinythread"><span class="tinyspan">~~strikethrough~~</span><span class="tinyspan"><span class="strike">Strikethrough</span></span></div><div class="tinythread"><span class="tinyspan">(4 blank spaces)quote(4 blank spaces)</span><span class="tinyspan"><span class="quotes"> > quote</span></span></div><div class="tinythread"><span class="tinyspan">----</span><span class="tinyspan">Horizontal divider</span></div><div class="tinythread"><span class="tinyspan">||, ||||</span><span class="tinyspan">New line, new paragraph</span></div><div class="tinythread"><span class="tinyspan">`code`</span><span class="tinyspan"><code>code</code></span></div><div class="tinythread"><span class="tinyspan">This is a [spoiler]spoiler[/spoiler].</span><span class="tinyspan">This is a <span class="spoiler">spoiler</span>.</span></div></div>';
				}elseif($AREA == 'create' || $AREA == 'bans' || $AREA == 'reports'){
					echo '<div class="tinystats">';
						if($ISMODERATOR === true){
							echo '<span class="adminnav"><a href="?a=create">Create/delete a board</a><a href="?a=bans">Manage bans</a><a href="?a=reports">View reports</a></span>';
							
							if($AREA == 'create'){
								
								// Form handling for creating a new board
								if(isset($_POST['CREATEBOARD']) && $_REQUEST['SHORTNAME'] != strtolower('mainrules')){
									$LOCKED = intval($_REQUEST['LOCKED']);
									$LOGGED = intval($_REQUEST['LOGGED']);
									$MODS = esc_sql($_REQUEST['MODS']);
									$JANITORS = esc_sql($_REQUEST['JANITORS']);
									$NAME = myoptionalmodules_sanistripents($_REQUEST['NAME']);
									$SHORTNAME = esc_sql(myoptionalmodules_sanistripents(strtolower($_REQUEST['SHORTNAME'])));
									$DESCRIPTION = esc_sql($purifier->purify($_REQUEST['DESCRIPTION']));
									$RULES = esc_sql($purifier->purify($_REQUEST['RULES']));
									$SFW = esc_sql($purifier->purify($_REQUEST['SFW']));
									$getBoards = $wpdb->get_results("SELECT SHORTNAME FROM $regularboard_boards WHERE SHORTNAME = '$SHORTNAME'");
									if(count($getBoards) == 0){
										$wpdb->query( 
											$wpdb->prepare(
												"INSERT INTO $regularboard_boards 
												( NAME, SHORTNAME, DESCRIPTION, RULES, SFW, MODS, JANITORS, POSTCOUNT, LOCKED, LOGGED ) 
												VALUES ( %s, %s, %s, %s, %s, %s, %s, %d, %d, %d )",
													$NAME,
													$SHORTNAME,
													$DESCRIPTION,
													$RULES,
													$SFW,
													$MODS,
													$JANITORS,
													0,
													$LOCKED,
													$LOGGED
												)
										);								
									}else{
										$wpdb->delete( ''.$regularboard_boards.'', array('SHORTNAME' => ''.$SHORTNAME.''),array( '%s') );							
										$wpdb->query( 
											$wpdb->prepare(
												"INSERT INTO $regularboard_boards 
												( NAME, SHORTNAME, DESCRIPTION, RULES, SFW, MODS, JANITORS, POSTCOUNT, LOCKED, LOGGED ) 
												VALUES ( %s, %s, %s, %s, %s, %s, %s, %d, %d, %d )",
													$NAME,
													$SHORTNAME,
													$DESCRIPTION,
													$RULES,
													$SFW,
													$MODS,
													$JANITORS,
													0,
													$LOCKED,
													$LOGGED
												)
										);								
									}
								}
								if(isset($_POST['DELETEBOARD']) && $_REQUEST['DELETETHIS'] != '' ){
										$DELETETHIS = esc_sql(myoptionalmodules_sanistripents($_REQUEST['DELETETHIS']));
										$wpdb->delete( ''.$regularboard_posts.'', array('BOARD' => ''.$DELETETHIS.''),array( '%s') );
										$wpdb->delete( ''.$regularboard_boards.'', array('SHORTNAME' => ''.$DELETETHIS.''),array( '%s') );
										echo '<meta http-equiv="refresh" content="0;URL=?a=create">';
								}
								
								// Force update tables
								$labeltext = 'Click to force update tables.';
								if(isset($_POST['UPGRADE'])){
									$wpdb->query("ALTER TABLE $regularboard_posts ADD URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER COMMENT");
									$wpdb->query("ALTER TABLE $regularboard_posts ADD TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER URL");
									$wpdb->query("ALTER TABLE $regularboard_posts ADD STICKY TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER LAST");
									$wpdb->query("ALTER TABLE $regularboard_posts ADD LOCKED TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER STICKY");
									$wpdb->query("ALTER TABLE $regularboard_posts ADD PASSWORD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER LOCKED");
									$wpdb->query("ALTER TABLE $regularboard_posts ADD UP BIGINT( 22 ) NOT NULL AFTER REPLYTO");
									$wpdb->query("ALTER TABLE $regularboard_posts ADD REPLYTO BIGINT( 22 ) NOT NULL AFTER PASSWORD");
									$wpdb->query("ALTER TABLE $regularboard_posts ADD USERID BIGINT( 22 ) NOT NULL AFTER UP");
									$wpdb->query("ALTER TABLE $regularboard_posts CHANGE `ID` `ID` BIGINT( 22 ) NOT NULL AUTO_INCREMENT");
									$wpdb->query("ALTER TABLE $regularboard_posts CHANGE `COMMENT` `COMMENT` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");
									$wpdb->query("ALTER TABLE $regularboard_posts CHANGE `PARENT` `PARENT` BIGINT( 22 ) NOT NULL");
									$wpdb->query("ALTER TABLE $regularboard_users CHANGE `ID` `ID` BIGINT( 22 ) NOT NULL AUTO_INCREMENT");
									$wpdb->query("ALTER TABLE $regularboard_users CHANGE `PARENT` `PARENT` BIGINT( 22 ) NOT NULL");
									$wpdb->query("ALTER TABLE $regularboard_users ADD KARMA BIGINT( 22 ) NOT NULL AFTER LENGTH");
									$wpdb->query("ALTER TABLE $regularboard_users ADD THREAD BIGINT ( 22 ) NOT NULL AFTER IP");
									$wpdb->query("ALTER TABLE $regularboard_users ADD DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER ID");
									$wpdb->query("ALTER TABLE $regularboard_users ADD BOARD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER PARENT");
									$wpdb->query("ALTER TABLE $regularboard_users ADD LENGTH TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER MESSAGE");
									$wpdb->query("ALTER TABLE $regularboard_users ADD PASSWORD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER KARMA");
									$wpdb->query("ALTER TABLE $regularboard_users ADD HEAVEN TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER PASSWORD");
									$wpdb->query("ALTER TABLE $regularboard_users ADD VIDEO TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER HEAVEN");
									$wpdb->query("ALTER TABLE $regularboard_users ADD BOARDS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER VIDEO");
									$wpdb->query("ALTER TABLE $regularboard_users ADD FOLLOWING TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER BOARDS");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER RULES");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD SFW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER URL");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD MODS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER SFW");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD JANITORS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER MODS");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD POSTCOUNT BIGINT( 22 ) NOT NULL AFTER JANITORS");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD LOCKED BIGINT( 22 ) NOT NULL AFTER POSTCOUNT");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD LOGGED BIGINT( 22 ) NOT NULL AFTER LOCKED");
									$wpdb->query("ALTER TABLE $regularboard_boards DROP URL");
									
									$allusers = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8'");
									$allposts = $wpdb->get_results("SELECT * FROM $regularboard_posts ");
									foreach($allusers as $users){
										$ip = $users->IP;
										$id = $users->ID;
										foreach($allposts as $posts){
												$wpdb->query("UPDATE $regularboard_posts SET USERID = $id WHERE IP = '$ip' AND EMAIL != 'heaven'");
										}
									}
									
									
									$labeltext = 'Tables updated!';
								}
								echo '<form method="post" class="upgrade"><label for="UPGRADE"><i class="fa fa-coffee"> '.$labeltext.'</i></label><input type="submit" name="UPGRADE" id="UPGRADE" value="An upgrade is necessary." class="hidden" /></form><a class="boardedit" href="?a=create&amp;b=mainrules">Edit main rules</a>';if(count($getBoards) > 0){foreach($getBoards as $gotBoard){if($gotBoard->SHORTNAME != ''){$board = esc_sql($gotBoard->SHORTNAME);$name  = esc_sql($gotBoard->NAME);echo '<a class="boardedit" href="?a=create&amp;b='.$board.'">Edit '.$board.'</a>';}}}
								if($BOARD == ''){
									echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?a=create">';
									wp_nonce_field('createaboard');
									echo '<section class="full"><input type="text" name="SHORTNAME" id="SHORTNAME" placeholder="Shortname (cannot be mainrules - reserved name)" /></section>
									<section class="full"><input type="text" name="NAME" id="NAME" placeholder="Expanded board name" /></section>
									<section class="full"><input type="text" name="DESCRIPTION" id="DESCRIPTION" placeholder="Short description" /></section>
									<section class="full"><input type="text" name="MODS" id="MODS" placeholder="User moderators" /></section>
									<section class="full"><input type="text" name="JANITORS" id="JANITORS" placeholder="User janitors" /></section>
									<section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board - leave shortname and expanded board name blank to create rules for the entire board."></textarea></section>
									<section class="full"><select class="full" name="LOCKED" id="LOCKED"><option value="0">Posting enabled (board unlocked)</option><option value="1">Posting disabled (board locked)</option></select></section>
									<section class="full"><select class="full" name="SFW" id="SFW"><option value="SFW">Safe-for-work (NSFW not allowed)</option><option value="NSFW">Not-Safe-For-Work</option></select></section>
									<section class="full"><select class="full" name="LOGGED" id="LOGGED"><option value="0">Everyone may interact</option><option value="1">Logged-in users only</option></select></section>
									<section class="full"><label class="create" for="CREATEBOARD">Create this board</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Create this board" /></section>
									</form>';
								}
								elseif($BOARD == 'mainrules'){
									$editboard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '' LIMIT 1");
									foreach($editboard as $editBoard){
										echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?a=create">';
										wp_nonce_field('createaboard');
										echo '
										<section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board">'.str_replace(array('<p>','</p>','<br />'),'||',(str_replace(array('\\n','\\t','\\r'),'||',$editBoard->RULES))).'</textarea></section>
										<section class="full"><label class="create" for="CREATEBOARD">Edit main rules</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Edit main rules" /></section>
										</form>';
									}
								}								
								else{
									$editboard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '$BOARD' LIMIT 1");
									foreach($editboard as $editBoard){
										echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?a=create">';
										wp_nonce_field('createaboard');
										echo '<section class="full"><input type="text" value="'.$editBoard->SHORTNAME.'" name="SHORTNAME" id="SHORTNAME" placeholder="Shortname" /></section>
										<section class="full"><input type="text" value="'.$editBoard->NAME.'"name="NAME" id="NAME" placeholder="Expanded board name" /></section>
										<section class="full"><input type="text" value="'.$editBoard->DESCRIPTION.'"name="DESCRIPTION" id="DESCRIPTION" placeholder="Short description" /></section>
										<section class="full"><input type="text" value="'.$editBoard->MODS.'"name="MODS" id="MODS" placeholder="User moderators" /></section>
										<section class="full"><input type="text" value="'.$editBoard->JANITORS.'"name="JANITORS" id="JANITORS" placeholder="User janitors" /></section>
										<section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board">'.str_replace(array('<p>','</p>','<br />'),'||',(str_replace(array('\\n','\\t','\\r'),'||',$editBoard->RULES))).'</textarea></section>
										<section class="full"><select class="full" name="LOCKED" id="LOCKED"><option  '; if($editBoard->LOCKED == 0){ echo 'selected="selected" ';  } echo 'value="0">Posting enabled (board unlocked)</option><option  '; if($editBoard->LOCKED == 1){ echo 'selected="selected" ';  } echo 'value="1">Posting disabled (board locked)</option></select></section>
										<section class="full"><select class="full" name="SFW" id="SFW"><option '; if($editBoard->SFW == 'SFW'){ echo 'selected="selected" ';  } echo 'value="SFW">Safe-for-work (NSFW not allowed)</option><option '; if($editBoard->SFW == 'NSFW'){ echo 'selected="selected" ';  } echo 'value="NSFW">Not-Safe-For-Work</option></select></section>
										<section class="full"><select class="full" name="LOGGED" id="LOGGED"><option '; if($editBoard->LOGGED == '0'){ echo 'selected="selected" ';  } echo 'value="0">Everyone may interact</option><option '; if($editBoard->LOGGED == '1'){ echo 'selected="selected" ';  } echo 'value="1">Logged-in users only</option></select></section>
										<section class="full"><label class="create" for="CREATEBOARD">Edit this board</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Edit this board" /></section>
										</form>';
									}
								}
								
								// Nuke a board
								if(count($getBoards) > 0){
									echo '<form method="post" class="boardselect" name="deleteaboard" action="?a=create">';
									wp_nonce_field('deleteaboard');
									echo '<select name="DELETETHIS" id="DELETETHIS">';
									foreach($getBoards as $gotBoard){
										if($gotBoard->SHORTNAME != ''){
											$board = esc_sql($gotBoard->SHORTNAME);
											$name  = esc_sql($gotBoard->NAME);
											echo '<option value="'.$board.'">/'.$board.'/ - '.$name.'</option>';
										}
									}
									echo '</select>
									<input type="submit" name="DELETEBOARD" id="DELETEBOARD" value="Nuke, Destroy, and Salt the Earth." />
									</form>';
								}			
							}
							
							if($AREA == 'reports'){
								// Reported threads
								echo '<div class="boardreports">
								<div class="tinythread"><span class="tinysubject">Reason reported</span><span class="tinyreplies">Link</span><span class="tinydate">Actions</span></div>
								<form name="reports" action="?a=reports" class="create" method="post">';
								wp_nonce_field('reports');
								if(count($getReports) > 0){
									foreach($getReports as $gotReports){
										$userIP = long2ip($gotReports->IP);
										$thisID = intval($gotReports->ID);
										$thisThread = intval($gotReports->THREAD);
										$thisParent = intval($gotReports->PARENT);
										$userMESSAGE = $gotReports->MESSAGE;
										$thisBoard = $gotReports->BOARD;
										if($thisParent== 0)$URL = '?b='.$thisBoard.'&amp;t='.$thisThread;
										if($thisParent!= 0)$URL = '?b='.$thisBoard.'&amp;t='.$thisParent.'#'.$thisThread;
										echo '<div class="tinythread"><span class="tinysubject">';
										if($userMESSAGE != '')echo ''.$userMESSAGE.'';
										if($userMESSAGE == '')echo 'No reason given.';
										echo '</span><span class="tinyreplies"><a href="'.$URL.'">[Reported thread]</a></span>';
										echo '<span class="tinydate"><label for="dismiss'.$thisID.'" class="button">[Dismiss]</label><label for="delete'.$thisID.'" class="button">[Delete]</label><input class="hidden" type="submit" name="dismiss'.$thisID.'" id="dismiss'.$thisID.'" value="Dismiss" /><input class="hidden" type="submit" name="delete'.$thisID.'" id="delete'.$thisID.'" value="Handle" /></span>';
										echo '</div>';
										if(isset($_POST['dismiss'.$thisID])){
											$wpdb->query("DELETE FROM $regularboard_users WHERE ID = '".$thisID."'");
											echo '<meta http-equiv="refresh" content="0;URL=?a=reports">';
										}
										if(isset($_POST['delete'.$thisID])){
											$delete = 0;
											$delete++;
											if($thisParent == 0){
												$countreps = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = $thisThread");
												foreach($countreps as $countedreplies){ $delete++; }
												$wpdb->delete( ''.$regularboard_posts.'', array('PARENT' => ''.$thisThread.''),array( '%d') );
											}
											$wpdb->delete( ''.$regularboard_posts.'', array('ID' => ''.$thisThread.''),array( '%d' ) );
											$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$thisID.''),array( '%d' ) );
											$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT - $delete WHERE SHORTNAME = '$thisBoard'");
											echo '<div class="tinythread"><span class="tinysubject"><i class="fa fa-undo fa-spin"></i></span></div><meta http-equiv="refresh" content="0;URL=?a=reports">';
										}						
									}
								}else{ echo '<div class="tinythread"><span class="tinysubject">Nothing to see here!</span></div>'; }
								echo '</form></div>';
							}
							
							if($AREA == 'bans'){
							
									if(isset($_POST['BAN']) && $_REQUEST['IP'] != ''){
										$IP      = esc_sql(ip2long($_REQUEST['IP']));
										$ID2SET  =  0;
										$PARENT  =  0;
										$BOARD   = '';
										$MESSAGE = ' (Banned by admin).';
										$LENGTH  = 0;
										$wpdb->query(
											$wpdb->prepare(
												"INSERT INTO $regularboard_users 
												( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) 
												VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s,%s )",
												'',
												$current_timestamp,
												$IP,
												$ID2SET,
												$PARENT,
												$BOARD,
												1,
												$MESSAGE,
												$LENGTH,
												0,
												'',
												0,
												0,
												'',
												''
											)
										);
										echo '<meta http-equiv="refresh" content="0;URL=?a=bans">';
									}
							

									echo '<form method="post" id="createban" class="COMMENTFORM boardcreation" name="createban" action="?a=bans">';
									wp_nonce_field('createban');
									echo '
									<section class="full"><input type="text" name="IP" id="IP" placeholder="IP Address to ban (standard format or long format)" /></section>
									<section class="full"><label class="create" for="BAN">Ban this IP</label><input class="hidden" type="submit" name="BAN" id="BAN" value="Ban this IP" /></section>
									</form>';
							
								echo '<div class="boardreports">
								<div class="tinythread"><span class="tinysubject">Reason for ban</span><span class="tinyreplies">Ban ID</span><span class="tinydate">Actions</span></div>
								<form name="unban" action="?a=bans" class="create" method="post">';
								wp_nonce_field('unban');
								if(count($getUsers) > 0){
									foreach($getUsers as $gotUsers){
										$userIP      = long2ip($gotUsers->IP);
										$thisID      = intval($gotUsers->ID);
										$userMESSAGE = $gotUsers->MESSAGE;
										echo '<div class="tinythread"><span class="tinysubject">';
										if($userMESSAGE != ''){echo '<span>'.$userMESSAGE.'</span>';}
										if($userMESSAGE == ''){echo '<span>No ban reason given.</span>';}
										echo '</span><span class="tinyreplies">'.$thisID.'</span><span class="tinydate"><label for="unban'.$thisID.'" class="button">[Unban '.$userIP.']</label><input class="hidden" type="submit" name="unban'.$thisID.'" id="unban'.$thisID.'" /></span></div>';
										if(isset($_POST['unban'.$thisID])){
											$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$thisID.'','BANNED' => '1'),array( '%d','%d') );
											echo '<div class="tinythread"><span class="tinysubject"><i class="fa fa-undo fa-spin"></i></span></div><meta http-equiv="refresh" content="0;URL=?a=bans">';
										}
									}
								}else{ echo '<div class="tinythread"><span class="tinysubject">No bans (yet) - great!</span></div>'; }
								echo '</form></div>';
							}

						}else{
						}
						echo '</div></div>';
				}
			
			
		elseif($BOARD != ''){
			if(count($getLastPost) > 0){
				if($userflood != ''){
					$userflood = array($userflood);
					$MYID = $current_user->user_login;
				}
				foreach($getLastPost as $lastPost){
					$MODERATOR = $lastPost->MODERATOR;
					if($userflood != '' && in_array($MYID,$userflood) || current_user_can('manage_options')){
							$timegateactive = false;
					}else{
						$time = $lastPost->DATE;
						$postedOn = strtotime($time);
						$currently = strtotime($current_timestamp);
						$timegate = $currently - $postedOn;
						if($timegate < 10){
							$timegateactive = true;
						}
					}
				}
			}
			if(isset($_POST['delete_this']) && $_REQUEST['report_ids'] !== '' && $_REQUEST['DELETEPASSWORD'] !== ''){
				$checkPassword = esc_sql($_REQUEST['DELETEPASSWORD']);
				$checkID = esc_sql(intval($_REQUEST['report_ids']));
				$checkPass = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PASSWORD = '".$checkPassword."' AND ID = '".$checkID."'");
				$correct = 0;
				if(count($checkPass) > 0){
					foreach($checkPass as $checked){
						$PARENT = $checked->PARENT;
						$wpdb->query("DELETE FROM $regularboard_posts WHERE ID = '".$checkID."'");
						if($PARENT == 0)$wpdb->query("DELETE FROM $regularboard_posts WHERE PARENT = '".$checkID."'");
						$correct = 1;
					}
				}
				if($BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?b='.$BOARD;}
				if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;}
				if($correct == 1 || $correct == 0){
					echo '<h3>';
					if($correct == 0)echo 'Wrong password.';
					if($correct == 1)echo 'Post deleted!';
					echo '<br />click <a href="'.esc_url($REDIRECTO).'">here</a> if you are not redirected.';
					echo '<meta http-equiv="refresh" content="5;URL= '.$REDIRECTO.'">';
					echo '</h3>';
				}
			}else{
				if(count($getCurrentBoard) > 0){
					$userIsBanned = 0;
					if(!is_user_logged_in() && $requirelogged == 1){
						echo '<div class="tinythread"><span class="tinysubject">You are not logged in.</span></div></div>';
					}elseif(!is_user_logged_in() && $requirelogged == 0 || is_user_logged_in()){
						foreach($getCurrentBoard as $gotCurrentBoard){
							$boardName = myoptionalmodules_sanistripents($gotCurrentBoard->NAME);
							$boardShort = myoptionalmodules_sanistripents($gotCurrentBoard->SHORTNAME);
							$boardDescription = $purifier->purify($gotCurrentBoard->DESCRIPTION);
							$boardDescription = str_replace('\\\\\\\'','\'',$boardDescription);
							$boardrules = $purifier->purify($gotCurrentBoard->RULES);
							$boardrules  = str_replace('\n','',$boardrules);
							$boardrules  = str_replace('\r','<br />',$boardrules);
							if ($DNSBL === true){
								$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1',' being blacklisted by the DNSBL.','0','0','','0','0','','')");
							}elseif(count($getUser) > 0){
								foreach($getUser as $banneddetails){
									$LENGTH = $banneddetails->LENGTH;									
									$FILED = $banneddetails->DATE;
									if($LENGTH != '0'){
										$DATEFILED = strtotime($banneddetails->DATE);
										$CURRENTDATE = strtotime($current_timestamp);
										if(strpos(strtolower($LENGTH),'minute')) {$bantime = intval($LENGTH) * 60;}
										elseif(strpos(strtolower($LENGTH),'hour'))   {$bantime = intval($LENGTH) * 60 * 60;}
										elseif(strpos(strtolower($LENGTH),'day'))    {$bantime = intval($LENGTH) * 60 * 60 * 24;}
										elseif(strpos(strtolower($LENGTH),'week'))   {$bantime = intval($LENGTH) * 60 * 60 * 24 * 7;}
										elseif(strpos(strtolower($LENGTH),'month'))  {$bantime = intval($LENGTH) * 60 * 60 * 24 * 7 * 30;}
										elseif(strpos(strtolower($LENGTH),'year'))   {$bantime = intval($LENGTH) * 60 * 60 * 24 * 7 * 30 * 365;}
										else{$bantime = intval($LENGTH) * 60;}
										$banIsActiveFor = ($DATEFILED + $bantime);
									}
									if($LENGTH == '0'){$LENGTH = 'Permanent';}
									if($LENGTH != '0'){if($CURRENTDATE > $banIsActiveFor){ $banLifted = 1;}else{ $banLifted = 0;}}
									else{$banLifted = 0;}
									echo '<div class="tinythread"><span class="tinysubject">'.$purifier->purify($bannedmessage).'</span></div>
									<div class="tinycomment">
									<div class="commentMeta">';
									foreach($getUser as $gotUser){
										$BANID = intval($gotUser->ID);
										$IP = intval($gotUser->IP);
										$BANNED = intval($gotUser->BANNED);
										$MESSAGE = myoptionalmodules_sanistripents($gotUser->MESSAGE);
										$MESSAGE = str_replace('\\\\\\\'','\'',$MESSAGE);
										if($MESSAGE == '')$MESSAGE = '<em>No reason given</em>';
										echo '<span><i class="fa fa-user"> Your IP: '.$ipaddress.'</i></span><span><i class="fa fa-clock-o"> Length: '.$LENGTH.'</i></span></div>';
										echo '<p>You have been banned from using these boards';
										if ($LENGTH === 'Permanent'){echo ' permanently';}
										if ($LENGTH !== 'Permanent'){echo ' for '.$LENGTH;}
										echo '.  Your ban was filed on '.$FILED.'.  The reason given for your ban was:</p><p>'.$MESSAGE.'</p><p>If you wish to appeal this ban, please e-mail the moderators of this board with the following ID: '.$BANID.', with the subject line <em>Ban Appeal</em>, and someone will get back to you shortly.  If there is no moderation e-mail on file, there is nothing more for you to do here.</p><p>Have a nice day.</p>';
										echo '</div>';
									}
									echo '</div>';
									if($LENGTH != '0'){
										if($banLifted == '1'){
											$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$BANID.'','BANNED' => '1'),array( '%d','%d') );
										}
									}
								}
							}elseif($userIsBanned == 0){
								if($THREAD != ''){
								$currentCountNomber = count($countParentReplies);
								}
								if(isset($_POST['FORMSUBMIT']))include(plugin_dir_path(__FILE__).'/regular_board_post_action.php');
								if(!isset($_POST['FORMSUBMIT'])){
									include(plugin_dir_path(__FILE__).'/regular_board_post_form.php');
									if($_REQUEST['DELETEPASSWORD'] == ''){include(plugin_dir_path(__FILE__).'/regular_board_delete_post_action.php');}
									if($AREA != 'newtopic' && $correct != 3){
										if(count($getposts) > 0){
											include(plugin_dir_path(__FILE__) . '/regular_board_board_loop.php');
										}
									}											
									if($THREAD != '' && $threadexists == 1){
										echo '</div><div class="threadinformation"><div class="leftmeta"><a href="?b='.$BOARD.'">Return</a><a href="#top">Top</a><span class="reload" data="'.$THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD.'">Update</span></div><i class="fa fa-reply"> '.$THREADREPLIES.'</i> &nbsp; <i class="fa fa-camera-retro"> '.$THREADIMGS.'</i></div>';
									}
									if($threadexists == 1){
										echo '<div class="tinybottom">';
										if($ISUSER === true || $ISUSERJANITOR === true){
											echo '<form name="reporttomods" method="post" action="'.$ACTION.'">';wp_nonce_field('reporttomods');echo '<section class="full"><input type="text" name="report_ids" id="report_ids" value="" placeholder="Post No." /></section><section class="full"><input type="text" name="report_reason" value="" placeholder="Reason (if reporting)" /></section><section class="full"><input type="password" name="DELETEPASSWORD" id="DELETEPASSWORD" /></section><section class="labels"><label class="submit" title="Edit (password required)" for="edit_this">Edit</label><label class="submit" title="Report" for="report_this">Report</label><label class="submit" title="Delete (password required)" for="delete_this">Delete</label></section><input type="submit" name="edit_this" value="edit" id="edit_this" class="hidden" /><input type="submit" name="report_this" value="report" id="report_this" class="hidden" /><input type="submit" name="delete_this" value="delete" id="delete_this" class="hidden" /></form>';
										}
										if(current_user_can('manage_options') || $ISUSERMOD === true || $ISUSERJANITOR === true){
											echo '<form name="moderator" method="post" action="'.$ACTION.'">';wp_nonce_field('moderator');echo '<section class="full"><input type="text" name="admin_ids" value="" placeholder="Post No." /></section>';if($ISUSERMOD === true || current_user_can('manage_options')){echo '<section class="full"><input type="text" name="admin_reason" value="" placeholder="Reason4ban shortname4move" /></section><section class="full"><input type="text" name="admin_length" value="" placeholder="Length of ban (0 for forever)" /></section>';}echo '<section class="labels">';if($ISUSERMOD === true || current_user_can('manage_options')){echo '<label class="submit" title="Edit" for="admin_edit">edit</label><label class="submit" title="Move" for="admin_move">move</label><label class="submit" title="Make sticky" for="admin_sticky">sticky</label><label class="submit" title="Lock thread" for="admin_lock">lock</label><label class="submit" title="Unsticky" for="admin_unsticky">unsticky</label><label class="submit" title="Unlock thread" for="admin_unlock">unlock</label><label class="submit" title="Ban" for="admin_ban">ban</label><input type="submit" name="admin_move" value="Move" id="admin_move" class="hidden" /><input type="submit" name="admin_ban" value="Ban" id="admin_ban" class="hidden" /><input type="submit" name="admin_edit" value="Edit" id="admin_edit" class="hidden" /><input type="submit" name="admin_sticky" value="Sticky" id="admin_sticky" class="hidden" /><input type="submit" name="admin_lock" value="Lock" id="admin_lock" class="hidden" /><input type="submit" name="admin_unsticky" value="Unsticky" id="admin_unsticky" class="hidden" /><input type="submit" name="admin_unlock" value="Unlock" id="admin_unlock" class="hidden" />';}echo '<label class="submit" title="Delete" for="admin_delete"><i class="fa fa-trash-o"></i></label><input type="submit" name="admin_delete" value="Delete" id="admin_delete" class="hidden" /></section></form>';
										}
									echo '</div></div>';
									}
									
								}
							}
						}
					}
				}
				else{$doesnotexist++;}
			}
		}
						elseif($BOARD == '' && $AREA == '' && $THREAD == '' || $AREA == 'topics' || $AREA  == 'replies' || $AREA  == 'subscribed' || $AREA  == 'following' || $AREA  == 'all'){ include(plugin_dir_path(__FILE__).'/regular_board_activity_loops.php'); }
						elseif($BOARD == '' && $AREA == 'users' && $THREAD == ''){ include(plugin_dir_path(__FILE__).'/regular_board_user_loop.php'); }
						elseif($BOARD == '' && $THREAD != ''){ include(plugin_dir_path(__FILE__).'/regular_board_single.php'); }
						else{$doesnotexist++;}
					
				}
		if($doesnotexist > 0)rb_404();
		return ob_get_clean();	
		}
	?>