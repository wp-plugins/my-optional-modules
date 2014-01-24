<?php 
	if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	$rb_v = '05492834';
	
	function rb_style(){
		global $wp,$post,$rb_v;
		$content = $post->post_content;
		if( has_shortcode( $content, 'regularboard' )){
			$regbostyle = WP_PLUGIN_URL . '/my-optional-modules/includes/css/regularboard'.$rb_v.'.css';
			wp_register_style('regular_board',$regbostyle);
			wp_enqueue_style('regular_board');	
		}
	}
	add_action('wp_enqueue_scripts','rb_style');
	
	function rb_head($atts){
		global $wp,$post,$wpdb,$purifier;
		$regularboard_boards  = $wpdb->prefix.'regularboard_boards';
		$regularboard_posts   = $wpdb->prefix.'regularboard_posts';
		$content              = $post->post_content;
		if( has_shortcode( $content, 'regularboard' )){
			$BOARD  = esc_sql(strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board'])));
			$THREAD = esc_sql(intval($_GET['thread']));
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
					$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']))));
					
					if($meta->PARENT == 0)$THREAD = intval($_GET['thread']);
					if($meta->PARENT != 0)$THREAD = intval($meta->PARENT).'#'.intval($_GET['thread']);
					$canonical = $THISPAGE.'?board='.$meta->BOARD.'&amp;thread='.$THREAD;
					
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
	add_action('wp_head','rb_head');	

	function regularboard_shortcode($atts,$content = null){
		$wordpressname = get_bloginfo('name');
		extract(
			shortcode_atts(array(
				'modcode'         => '##MOD',
				'usermodcode'     => '##JUNIORMOD',
				'bannedmessage'   => 'YOU ARE BANNED',
				'defaultname'     => 'anonymous',
				'postedmessage'   => 'POSTED!!!',
				'requirelogged'   => '0',
				'enableurl'       => '1',
				'enablerep'       => '1',
				'enableemail'     => '1',
				'maxbody'         => '1800',
				'maxreplies'      => '500',
				'maxtext'         => '75',
				'boards'		  => '',
				'loggedonly'      => '',
				'trustedimg'      => '',
				'userflood'       => '',
				'untrusteddomain' => '',
				'imgurid'		  => ''
			), $atts)
		);	
		
		global $purifier,$wpdb,$wp,$post,$ipaddress,$rand,$randnum1,$randnum2,$rb_v;
		
		$thisimageupload = '';
		if($imgurid != ''){
			if(isset($_POST['submitimgur'])){
				$img = $_FILES['img'];
				if(isset($_POST['submitimgur'])){
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
			}		
		}

		$boardid = $boardname = $boardshort = $boarddescription = $boardmods = $boardjans = $boardposts = '';
		
		function rb_404(){
			echo '<div class="tinythread"><span class="tinysubject">404</span></div><div class="tinycomment">
			<p>The resource you are looking for does not exist.</p>
			<hr />';
			echo '
			<p class="information tiny"><i class="fa fa-thumbs-up"></i> Posts and replies can be Approved of (or Disapproved) - which will add (or detract) from your overall Approval rating on this site.
			Ratings are tracked by IP address alone - posting from different IP addresses will obviously mean different Approval ratings for each of your posts.</p>
			<p class="information tiny"><i class="fa fa-user"></i> We use your IP address to identify you, for the purposes of user stats, and for the purposes of board moderation.  Your IP address is never made 
			publicly available.  All users are <em>anonymous</em> (in the sense that there are no names attached to their posts).</p>
			<p class="information tiny"><i class="fa fa-terminal"></i> Did you know that you can format your comments using special code?  Surrounding a word with *s, like *this*, will result in an <em>italicized</em> 
			word, while **this** will result in a <strong>bold</strong> word.  Read <a href="?area=help">this</a> for more information.</p>
			<p class="information tiny"><i class="fa fa-warning"></i> Now that you\'ve made your first post, this information screen will no longer be presented to you.  Instead, in the future, when making new posts,
			you will simply be automatically forwarded to them.  Now go forth - and be a productive member of this community!</p>
			</div></div>';
			echo '<script type="text/javascript">document.title = \'404\';</script>';
		}
		
		myoptionalmodules_checkdnsbl($checkThisIP);
		$theIP                                                                                    = esc_sql($ipaddress);
		$theIP_s32int                                                                             = esc_sql(ip2long($ipaddress));
		$theIP_us32str                                                                            = esc_sql(sprintf("%u",$theIP_s32int));
		$checkThisIP                                                                              = esc_sql($theIP);
		$current_timestamp                                                                        = date('Y-m-d H:i:s');
		if($trustedimg != '')$trustedimg                                                          = explode(',',$trustedimg);
		$untrusteddomain                                                                          = explode(',',$untrusteddomain);
		$requirelogged                                                                            = intval($requirelogged);
		$maxreplies                                                                               = intval($maxreplies);
		$enableemail                                                                              = intval($enableemail);
		$loggedonly                                                                               = $loggedonly;
		$defaultname                                                                              = $defaultname;
		$bannedmessage                                                                            = $bannedmessage;
		$postedmessage                                                                            = $postedmessage;
		$modcode                                                                                  = $modcode;
		$usermodcode                                                                              = $usermodcode;
		$userjanitorcode                                                                          = $userjanitorcode;
		$regularboard_boards                                                                      = $wpdb->prefix.'regularboard_boards';
		$regularboard_posts                                                                       = $wpdb->prefix.'regularboard_posts';
		$regularboard_users                                                                       = $wpdb->prefix.'regularboard_users';
		$QUERY                                                                                    = esc_sql(myoptionalmodules_sanistripents($_SERVER['QUERY_STRING']));
		$SEARCH						                                         	                  = '';
		$modishere                                                                                = '';
		$gotReplies					                                                         	  = '';
		$THREADIMGS                                                                               = '';
		$blog_title                                                                               = get_bloginfo();
		$BOARD                                                                                    = esc_sql(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']));
		$AREA                                                                                     = esc_sql(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['area']));
		$PROFILE                                                                                  = esc_sql(preg_replace("/[^0-9 ]/", '', $_GET['profile']));
		$THREAD                                                                                   = intval($_GET['thread']);
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
					$profileid = $myinfo->ID;
					$profileheaven = $myinfo->HEAVEN;
					$profilevideo = $myinfo->VIDEO;
					if($profilevideo == '')$profilevideo = 0;
					$profilepassword = $myinfo->PASSWORD;
					if($profilepassword == '')$profilepassword = $rand;
					if($profilepassword != '')$profilepassword = $profilepassword;
					$boards = $myinfo->BOARDS;
					$profileboards = $boards;
					$iexist = 1;
				}
			}
		
		
		$getBoards                                                                                = $wpdb->get_results("SELECT * FROM $regularboard_boards ORDER BY NAME ASC");
		if($boards != '') $boards                                                                 = explode(',',$boards);
		if($boards != '') $boards                                                                 = array_map('rb_apply_quotes',$boards);
		if(isset($_POST['searchsub']) && $_REQUEST['boardsearch'] != '') $SEARCH                  = esc_sql(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_REQUEST['boardsearch'])));
		if($BOARD != '')  $getCurrentBoard                                                        = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '".$BOARD."' LIMIT 1");
		
		if(count($getCurrentBoard) > 0 && $BOARD != ''){
			foreach($getCurrentBoard as $currentBoardInformation){
				$lock             = intval($currentBoardInformation->LOCKED);
				$boardid          = intval($currentBoardInformation->ID);
				$boardname        = $currentBoardInformation->NAME;
				$boardshort       = $currentBoardInformation->SHORTNAME;
				$boarddescription = str_replace(array('||||','||','*','{{','}}','>>',' >','~~',' - ','----','::','`','    '),'',(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',$currentBoardInformation->DESCRIPTION)))))));
				$boardrules       = $currentBoardInformation->RULES;
				$boardmods        = $currentBoardInformation->MODS;
				$boardjans        = $currentBoardInformation->JANITORS;
				$boardposts       = intval($currentBoardInformation->BOARDPOSTS);
				$requirelogged    = intval($currentBoardInformation->LOGGED);
				$boardsfw         = $currentBoardInformation->SFW;
			
				$boardheader      = '<div class="tinythread"><span class="tinysubject"><a href="?board='.$boardshort.'">'.$boardname.'</a></span><span class="tinyreplies">'.$boardsfw.'</span><span class="tinydate">'.$boardshort.'</span></div>
				                     <div class="tinythread"><span class="tinysubject">'.$boarddescription.'</span></div>';
				
				echo '<script type="text/javascript">document.title = \''.$boardname.' / '.$boardshort.'\';</script>';
				
			}
		}else{
				$boardheader     = '<div class="tinythread"><span class="tinysubject">'.get_bloginfo('name').'</span><span class="tinyreplies" title="Regular Board v.'.$rb_v.'">'.$rb_v.'</span></div>';
		}
		
		if($BOARD != '' )$getBoards                                                               = $wpdb->get_results("SELECT * FROM $regularboard_boards ORDER BY SHORTNAME ASC");
		if($BOARD != '' )$getUser                                                                 = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = 1 LIMIT 1");
		if($BOARD != '' )$getLastPost                                                             = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = '".$theIP_us32str."' ORDER BY ID DESC LIMIT 1");
		if($BOARD != '' && $THREAD == '') $targetpage                                             = '?board='.$BOARD;
		if($BOARD != '' && $THREAD == '') $countpages                                             = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0");
		if($BOARD != '' && $THREAD == '') $totalpages                                             = count($countpages);
		if($BOARD != '' && $THREAD == '') $results                                                = mysql_escape_string($_GET['results']);
		if($BOARD != '' && $THREAD == '') if($results){$start                                     = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD != '' && $THREAD == '') if($SEARCH == '') $getParentPosts                       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0 ORDER BY STICKY DESC, LAST DESC LIMIT $start,$postsperpage");
		if($BOARD != '' && $THREAD == '') if($SEARCH != '') $getParentPosts                       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ( EMAIL = '".$SEARCH."' OR COMMENT LIKE '%".$SEARCH."%' OR SUBJECT LIKE '%".$SEARCH."%' OR URL LIKE '%".$SEARCH."%' ) AND BOARD = '".$BOARD."' ORDER BY ID");
		if($BOARD != '' && $THREAD != '')	$getParentPosts                                       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND ID = '".$THREAD."' AND PARENT = 0 LIMIT 1");
		if($BOARD != '' && $THREAD != '') $countParentReplies                                     = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = '".$THREAD."'");
		if($BOARD != '' && $THREAD != '') $THREADREPLIES = $THREADIMGS                            = 0;

		if($BOARD == '' && $AREA == '' && $THREAD == '') $countpages                              = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE PARENT = 0");
		if($BOARD == '' && $AREA == '' && $THREAD == '') $totalpages                              = count($countpages);
		if($BOARD == '' && $AREA == '' && $THREAD == '') $results                                 = mysql_escape_string($_GET['results']);
		if($BOARD == '' && $AREA == '' && $THREAD == '') if($results){$start                      = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == '' && $THREAD == '') $getParentPosts                          = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = 0 ORDER BY DATE DESC LIMIT $start,$postsperpage");
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $countpages                       = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE PARENT != 0");
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $totalpages                       = count($countpages);
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $results                          = mysql_escape_string($_GET['results']);
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') if($results){$start               = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'replies' && $THREAD == '') $getParentPosts                   = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT != 0 ORDER BY DATE DESC LIMIT $start,$postsperpage");		
		if($BOARD == '' && $AREA == 'sll' && $THREAD == '') $countpages                           = $wpdb->get_results("SELECT ID FROM $regularboard_posts");
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') $totalpages                           = count($countpages);
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') $results                              = mysql_escape_string($_GET['results']);
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') if($results){$start                   = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'all' && $THREAD == '') $getParentPosts                       = $wpdb->get_results("SELECT * FROM $regularboard_posts ORDER BY DATE DESC LIMIT $start,$postsperpage");

		
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $countpages            = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD IN (".join(',',$boards).")");
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $totalpages            = count($countpages);
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $results               = mysql_escape_string($_GET['results']);
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') if($results){$start    = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != '') $getParentPosts        = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD IN (".join(',',$boards).") ORDER BY DATE DESC LIMIT $start,$postsperpage");
		
		
		if($BOARD == '' && $THREAD != '')$gotReplies                                              = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
		
		if($PROFILE != '') $reviews_table                                                         = $wpdb->prefix.'momreviews';
		if($PROFILE != '') $usprofile                                                             = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE ID = $profileid AND BANNED = 8 LIMIT 1");
		if($PROFILE != '') $ktrophies                                                             = $wpdb->get_results("SELECT * FROM $reviews_table WHERE TYPE = 'karma' OR type='activeposts'");

		// User role
		$current_user                                                                             = wp_get_current_user();
		$current_user_login                                                                       = $current_user->user_login;
		if(current_user_can('manage_options')) $ISMODERATOR                                       = true;
		if($boardmods != '') $usermods                                                            = explode(',',$boardmods);
		if($boardmods != '') if(in_array($current_user_login,$usermods)) $ISUSERMOD               = true;
		if($boardjans != '') $userjanitors                                                        = explode(',',$boardjans);
		if($boardjans != '') if(in_array($current_user_login,$userjanitors)) $ISUSERJANITOR       = true;
		if($ISMODERATOR   === true) $ISUSER                                                       = false;
		if($ISUSERMOD     === true) $ISUSER                                                       = false;
		if($ISUSERJANITOR === true) $ISUSER                                                       = false;		

		if($AREA == 'bans' && $ISMODERATOR === true) $getUsers                                    = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 1");
		if($AREA == 'reports' && $ISMODERATOR === true) $getReports                               = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 3");
		
		if($lock == 1){
			if($ISUSER === true)$posting = 0;
			if($ISUSER !== true)$posting = 1;
		}
		
		$THISPAGE      = get_permalink();

		foreach($getBoards as $cboard){
			$BOARDRULES = rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($cboard->RULES)))))));
		}
		
		if($BOARD != '' && $THREAD != '' && $ID == $THREAD)$ACTION = $THISPAGE.'?board='.$BOARD;
		elseif($BOARD != '' && $THREAD == '')$ACTION = $THISPAGE.'?board='.$BOARD;
		elseif($BOARD != '' && $THREAD != '')$ACTION = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;
		
		if($ipaddress !== false){
		
		
		
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
											( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS ) 
											VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s )",
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
											( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS ) 
											VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%d,%s,%s,%s )",
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
											''
										)
									);
								}
							}
						}
					}
				
			echo '<div class="boardAll">';
			echo $boardheader;
			echo '<div class="userbar">';
			if($iexist == 1 && $profileboards != '')echo '<a href="?area=subscribed">subscribed</a>';
			echo '<a href="'.$THISPAGE.'">topics</a>
			<a href="?area=replies">replies</a>
			<a href="?area=all">all</a>
			<a href="?area=stats">stats</a>';
			if($ISMODERATOR === true)echo '<a href="?area=create">admin</a>';
			if($iexist == 1)echo '<a href="?profile='.$profileid.'">history</a>';
			if($iexist == 1)echo '<a href="?area=options">options</a>';
			echo '<a href="?area=help">help</a><a href="?area=info">info</a>';
			if($BOARD != '' && $posting == 1 && $iexist == 1){ echo '<a href="?board='.$BOARD.'&amp;area=newtopic">New topic</a>'; }
			echo '</div>';			

			if($AREA == 'options' && $iexist == 1){

			if(isset($_POST['options'])){
			
			$password = esc_sql($_REQUEST['password']);
			$heaven   = intval($_REQUEST['heaven']);
			$video    = intval($_REQUEST['video']);
			$boards   = esc_sql($_REQUEST['boards']);
			$wpdb->query("UPDATE $regularboard_users SET VIDEO = $video WHERE ID = $profileid");
			$wpdb->query("UPDATE $regularboard_users SET HEAVEN = $heaven WHERE ID = $profileid");
			$wpdb->query("UPDATE $regularboard_users SET PASSWORD = '$password' WHERE ID = $profileid");
			$wpdb->query("UPDATE $regularboard_users SET BOARDS = '$boards' WHERE ID = $profileid");
			echo '<meta http-equiv="refresh" content="0;URL=?area=options">';
			}
			echo '<div class="tinythread"><span class="tinysubject">Options</span></div>';
			echo '<form method="post" class="COMMENTFORM boardcreation" name="useroptions" action="?area=options">';
			wp_nonce_field('useroptions');
			echo '
			<section class="full"><p>Set a password to use on every post you make (default password is always random):</p><input type="text" name="password" id="password" value="'.$profilepassword.'" placeholder="Password" /></section>
			<hr />
			<section class="full"><p>Comma-separated list of boards you wish to subscribe to (available boards below) (example: board, board, board):<br />';
			
			foreach($getBoards as $board){
				echo '<span class="board">'.$board->SHORTNAME.'</span>';
			}			
			echo '</p><input type="text" name="boards" id="boards" value="'.$profileboards.'" placeholder="Boards" /></section>
			<hr />
			<section class="full"><p>Whether or not you wish the e-mail field to be prepopulated with <code>heaven</code></p><select class="full" name="heaven" id="heaven"><option ';if($profileheaven == 0){echo 'selected="selected" ';}echo 'value="0">Always heaven off</option><option ';if($profileheaven == 1){echo 'selected="selected" ';} echo 'value="1">Always heaven on</option></select></section>
			<hr />
			<section class="full"><p>Whether or not you wish Youtube embeds to be enabled</p><select class="full" name="video" id="video"><option ';if($profilevideo == 0){echo 'selected="selected" ';}echo 'value="0">Show embedded Youtube videos</option><option ';if($profilevideo == 1){echo 'selected="selected" ';}echo 'value="1">Display a link to the video without embedding it</option></select></section>
			<hr />
			<section class="full"><label class="create" for="options">Save these options</label><input class="hidden" type="submit" name="options" id="options" value="Save these options" /></section>
			</form>';			
			
			echo '</div>';
			echo '<script type="text/javascript">document.title = \'Options\';</script>';
			
			}elseif($AREA == 'info'){
				if(count($getBoards) > 0){
					echo '<div class="tinythread"><span class="tinysubject">Rules</span></div>';
					foreach($getBoards as $gotBoards){
						$description = wpautop(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($gotBoards->DESCRIPTION)))))))));
						$short = $gotBoards->SHORTNAME;
						$name = $gotBoards->NAME;
						$sfw = $gotBoards->SFW;
						$rules = wpautop(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($gotBoards->RULES)))))))));
						if($gotBoards->LOCKED == 0)$posting = '<p><i class="fa fa-unlock"> Board unlocked, posting enabled.</i></p>';
						if($gotBoards->LOCKED == 1)$posting = '<p><i class="fa fa-lock"> Board locked, posting disabled.</i></p>';
						echo '<div class="tinythread"><span class="tinysubject"><a href="?board='.$short.'">'.$name.'</a></span><span class="tinyreplies">'.$sfw.'</span><span class="tinydate">'.$short.'</span></div>
						<div class="tinycomment">'.$description.'<hr />'.$rules.'<hr />'.$posting.'</div>';
					}
					echo '</div>';
				}
			
			}elseif($PROFILE != ''){
				if(count($usprofile) > 0){
					foreach($usprofile as $theprofile){
						$userip    = intval($theprofile->IP);
						$countpages = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = $userip AND EMAIL != 'heaven'");
						$totalpages = count($countpages);
						$results = mysql_escape_string($_GET['results']);
						if($results){$start = ($results - 1) * $postsperpage;}else{$start = 0;}
						$count = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = $userip AND EMAIL != 'heaven' ORDER BY DATE DESC");
						$posts  = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = $userip AND EMAIL != 'heaven' LIMIT $start,$postsperpage");
						$postcount = count($posts);
						$userid    = intval($theprofile->ID);
						$userkarma = intval($theprofile->KARMA);
						if(count($count) > 0){
							echo '<div class="tinystats"><div id="trophycase"><div class="tinythread"><span class="tinysubject">Active posts: '.$postcount.'</span><span class="tinyreplies"> + '.$userkarma.'</i></span><span class="tinydate">First seen '.timesincethis($theprofile->DATE).'</span></div>';
							$dust = 0;
							foreach($ktrophies as $k){
								$rating = $k->RATING;
								if($rating >= $userkarma){
									$dust++;
									$achievement =  $k->REVIEW;
									$achievement =  str_replace('<p>','',$achievement);
									$achievement =  str_replace('</p>','',$achievement);
									echo '<div class="tinythread"><span class="tinysubject">'.$k->TITLE.'</span><span class="tinyreplies">'.$dust.'</span><span class="tinydate">'.$achievement.'</span></div>';
								}
								if($rating >= $postcount){
									$dust++;
									$achievement =  $k->REVIEW;
									$achievement =  str_replace('<p>','',$achievement);
									$achievement =  str_replace('</p>','',$achievement);										
									echo '<div class="tinythread"><span class="tinysubject">'.$k->TITLE.'</span><span class="tinyreplies">'.$dust.'</span><span class="tinydate">'.$achievement.'</span></div>';
								}
							}
							foreach($count as $thisuserposts){
								if(intval($thisuserposts->UP) >= 1){
									echo '<div id="'.intval($thisuserposts->ID).'" class="tinythread">';
									$board            =  $thisuserposts->BOARD;
									$id               =  $thisuserposts->ID;
									$date             =  $thisuserposts->DATE;
									$parent           =  '';
									if($thisuserposts->PARENT == 0){ $posttype = 'new thread'; }
									if($thisuserposts->PARENT != 0){ $posttype = 'new reply'; }
									$bl               =  $wpdb->get_results("SELECT URL FROM $regularboard_boards WHERE SHORTNAME = '".$board."' LIMIT 1");
									if($thisuserposts->PARENT != 0)$parent = $thisuserposts->PARENT;
									if($thisuserposts->PARENT  > 0)$parent = 'thread='.$parent.'#'.$id;
									if($thisuserposts->PARENT == 0)$parent = 'thread='.$id;
									$link = $THISPAGE.'?board='.$board.'&amp;'.$parent;
									$SUBJECT          =  str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($thisuserposts->SUBJECT))))))));
									echo '<span class="tinysubject"><a href="'.$link.'">';
									if($SUBJECT != ''){echo $SUBJECT;}else{echo 'No subject specified';}
									echo '</a></span><span class="tinyreplies">'.intval($thisuserposts->UP).'</span><span class="tinydate">'.timesincethis($date).' <a href="?thread='.intval($thisuserposts->ID).'">##</a></span>';
									echo '</div>';
								}
							}
						}
						echo '</div></div>';
					}
				}
				$i       = 0;
				$results = intval($_GET['results']);
				$paging  = round($totalpages / $postsperpage);
				if($paging > 0){
					$pageresults = round($paging / 10);
					echo '<div class="pages">';
					if($results > 1) echo '<a href="?profile='.$PROFILE.'">Latest</a> ';
					if($results > 2)echo '<a href="?board='.$PROFILE.'&amp;results='.($results - 1).'">Newer</a> ';
						if($results < $paging && $results == '')echo '<a href="?profile='.$PROFILE.'&amp;results=2">Older</a> ';
						if($results < $paging && $results != '')echo '<a href="?profile='.$PROFILE.'&amp;results='.($results + 1).'">Older</a> ';
					echo '</div>';
				}					
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
							echo '<td><a href="?board='.$BOARDNAME.'">'.$BOARDNAME.'</a></td>';
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
					
					echo '
						<div class="tinythread">E-mail field</div>
						<div class="tinythread"><span class="tinyspan">You type</span><span class="tinyspan">You get</span></div>
						<div class="tinythread"><span class="tinyspan">heaven</span><span class="tinyspan">Post is not tied to your public profile.</span></div>
						<div class="tinythread"><span class="tinyspan">sage</span><span class="tinyspan">Do not bump a thread (if replying).</span></div>
						<div class="tinythread"><span class="tinyspan">!tripcode or !!tripcode</span><span class="tinyspan">Regular <a href="http://en.wikipedia.org/wiki/Imageboard#Tripcodes">tripcode</a> or secure <a href="http://en.wikipedia.org/wiki/Imageboard#Tripcodes">tripcode</a>.</span></div>
						<div class="tinythread">Comment formatting</div>
						<div class="tinythread"><span class="tinyspan">You type</span><span class="tinyspan">You get</span></div>
						<div class="tinythread"><span class="tinyspan">**bold**</span><span class="tinyspan"><strong>bold</strong></span></div>
						<div class="tinythread"><span class="tinyspan">*italics*</span><span class="tinyspan"><em>italics</em></span></div>
						<div class="tinythread"><span class="tinyspan">***bold and italic***</span><span class="tinyspan"><strong><em>bold and italic</em></strong></span></div>
						<div class="tinythread"><span class="tinyspan">&nbsp;&nbsp;- List item ||,&nbsp;&nbsp;- List item |||| (2 spaces)</span><span class="tinyspan"><ul><li>List item</li></ul></span></div>
						<div class="tinythread"><span class="tinyspan">::#:: (where # is the post number of a reply)</span><span class="tinyspan"><a href="#1"> >> 1</a></span></div>
						<div class="tinythread"><span class="tinyspan">~~strikethrough~~</span><span class="tinyspan"><span class="strike">Strikethrough</span></span></div>
						<div class="tinythread"><span class="tinyspan">&nbsp;&nbsp;&nbsp;&nbsp;quote (4 spaces)</span><span class="tinyspan"><span class="quotes"> > quote</span></span></div>
						<div class="tinythread"><span class="tinyspan">----</span><span class="tinyspan"><hr /></span></div>
						<div class="tinythread"><span class="tinyspan">||, ||||</span><span class="tinyspan">New line, new paragraph</span></div>
						<div class="tinythread"><span class="tinyspan">`code`</span><span class="tinyspan"><code>code</code></span></div>
						<div class="tinythread"><span class="tinyspan">This is a [spoiler]spoiler[/spoiler].</span><span class="tinyspan">This is a <span class="spoiler">spoiler</span>.</span></div>
						</div>
					';
					
				}elseif($AREA == 'create' || $AREA == 'bans' || $AREA == 'reports'){
					echo '<div class="tinystats">';
						if($ISMODERATOR === true){
							echo '<span class="adminnav">
								<a href="?area=create">Create/delete a board</a>
								<a href="?area=bans">Manage bans</a>
								<a href="?area=reports">View reports</a>
							</span>';
							
							if($AREA == 'create'){
								
								// Form handling for creating a new board
								if(isset($_POST['CREATEBOARD']) && $_REQUEST['NAME'] != '' && $_REQUEST['SHORTNAME'] != ''){
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
										echo '<meta http-equiv="refresh" content="0;URL=?area=create">';
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
									$wpdb->query("ALTER TABLE $regularboard_posts CHANGE `ID` `ID` BIGINT( 22 ) NOT NULL AUTO_INCREMENT");
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
									$wpdb->query("ALTER TABLE $regularboard_boards ADD URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER RULES");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD SFW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER URL");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD MODS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER SFW");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD JANITORS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER MODS");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD POSTCOUNT BIGINT( 22 ) NOT NULL AFTER JANITORS");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD LOCKED BIGINT( 22 ) NOT NULL AFTER POSTCOUNT");
									$wpdb->query("ALTER TABLE $regularboard_boards ADD LOGGED BIGINT( 22 ) NOT NULL AFTER LOCKED");
									$wpdb->query("ALTER TABLE $regularboard_boards DROP URL");
									$labeltext = 'Tables updated!';
								}
								echo '<form method="post" class="upgrade">
								<label for="UPGRADE"><i class="fa fa-coffee"> '.$labeltext.'</i></label>
								<input type="submit" name="UPGRADE" id="UPGRADE" value="An upgrade is necessary." class="hidden" />
								</form>';
								if(count($getBoards) > 0){
									foreach($getBoards as $gotBoard){
										$board = esc_sql($gotBoard->SHORTNAME);
										$name  = esc_sql($gotBoard->NAME);
										echo '
										<a class="boardedit" href="?area=create&amp;board='.$board.'">Edit '.$board.'</a>';
									}
								}
								if($BOARD == ''){
									echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?area=create">';
									wp_nonce_field('createaboard');
									echo '<section class="full"><input type="text" name="SHORTNAME" id="SHORTNAME" placeholder="Shortname" /></section>
									<section class="full"><input type="text" name="NAME" id="NAME" placeholder="Expanded board name" /></section>
									<section class="full"><input type="text" name="DESCRIPTION" id="DESCRIPTION" placeholder="Short description" /></section>
									<section class="full"><input type="text" name="MODS" id="MODS" placeholder="User moderators" /></section>
									<section class="full"><input type="text" name="JANITORS" id="JANITORS" placeholder="User janitors" /></section>
									<section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board"></textarea></section>
									<section class="full"><select class="full" name="LOCKED" id="LOCKED"><option value="0">Posting enabled (board unlocked)</option><option value="1">Posting disabled (board locked)</option></select></section>
									<section class="full"><select class="full" name="SFW" id="SFW"><option value="SFW">Safe-for-work (NSFW not allowed)</option><option value="NSFW">Not-Safe-For-Work</option></select></section>
									<section class="full"><select class="full" name="LOGGED" id="LOGGED"><option value="0">Everyone may interact</option><option value="1">Logged-in users only</option></select></section>
									<section class="full"><label class="create" for="CREATEBOARD">Create this board</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Create this board" /></section>
									</form>';
								}
								if($BOARD != ''){
									$editboard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '$BOARD' LIMIT 1");
									foreach($editboard as $editBoard){
										echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?area=create">';
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
										<section class="full"><label class="create" for="CREATEBOARD">Edit this board</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Create this board" /></section>
										</form>';
									}
								}
								// Nuke a board
								if(count($getBoards) > 0){
									echo '<form method="post" class="boardselect" name="deleteaboard" action="?area=create">';
									wp_nonce_field('deleteaboard');
									echo '<select name="DELETETHIS" id="DELETETHIS">';
									foreach($getBoards as $gotBoard){
										$board = esc_sql($gotBoard->SHORTNAME);
										$name  = esc_sql($gotBoard->NAME);
										echo '<option value="'.$board.'">/'.$board.'/ - '.$name.'</option>';
									}
									echo '</select>
									<input type="submit" name="DELETEBOARD" id="DELETEBOARD" value="Nuke, Destroy, and Salt the Earth." />
									</form>';
								}			
							}
							
							if($AREA == 'reports'){
								// Reported threads
								echo '<div class="boardreports">
								<p><strong>Reports</strong>: Dismiss to delete report, Delete to delete the thread/reply <strong>and</strong> report.</p>
								<form name="reports" action="?area=reports" class="create" method="post">';
								wp_nonce_field('reports');
								if(count($getReports) > 0){
									foreach($getReports as $gotReports){
										$userIP = long2ip($gotReports->IP);
										$thisID = intval($gotReports->ID);
										$thisThread = intval($gotReports->THREAD);
										$thisParent = intval($gotReports->PARENT);
										$userMESSAGE = $gotReports->MESSAGE;
										$thisBoard = $gotReports->BOARD;
										if($thisParent== 0)$URL = '?board='.$thisBoard.'&amp;thread='.$thisThread;
										if($thisParent!= 0)$URL = '?board='.$thisBoard.'&amp;thread='.$thisParent.'#'.$thisThread;
										echo '<p><a href="'.$URL.'">'.$thisBoard.'->'.$thisThread.'</a> &mdash; ';
										if($userMESSAGE != '')echo ''.$userMESSAGE.'';
										if($userMESSAGE == '')echo 'No reason given.';
										echo '><label for="dismiss'.$thisID.'">[ >> Dismiss ]</label>';
										echo '<label for="delete'.$thisID.'">[ >> Delete ]</label><input class="hidden" type="submit" name="dismiss'.$thisID.'" id="dismiss'.$thisID.'" value="Dismiss" /><input class="hidden" type="submit" name="delete'.$thisID.'" id="delete'.$thisID.'" value="Handle" />';
										echo '</p>';
										if(isset($_POST['dismiss'.$thisID])){
											$wpdb->query("DELETE FROM $regularboard_users WHERE ID = '".$thisID."'");
											echo '<meta http-equiv="refresh" content="0;URL=?area=reports">';
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
											echo '<meta http-equiv="refresh" content="0;URL=?area=reports">';
										}						
									}
								}else{ echo '<p><em>Nothing to see here!</em></p>'; }
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
												( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS ) 
												VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s )",
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
												''
											)
										);
										echo '<meta http-equiv="refresh" content="0;URL=?area=bans">';
									}
							

									echo '<form method="post" id="createban" class="COMMENTFORM boardcreation" name="createban" action="?area=bans">';
									wp_nonce_field('createban');
									echo '
									<section class="full"><input type="text" name="IP" id="IP" placeholder="IP Address to ban (standard format or long format)" /></section>
									<section class="full"><label class="create" for="BAN">Ban this IP</label><input class="hidden" type="submit" name="BAN" id="BAN" value="Ban this IP" /></section>
									</form>';
							
								echo '<div class="boardreports"><p><strong>Bans</strong> Unban banned IPs here.  Probably best to leave them here.</p><form name="unban" action="?area=bans" class="create" method="post">';
								wp_nonce_field('unban');
								if(count($getUsers) > 0){
									foreach($getUsers as $gotUsers){
										$userIP      = long2ip($gotUsers->IP);
										$thisID      = intval($gotUsers->ID);
										$userMESSAGE = $gotUsers->MESSAGE;
										echo '<p><strong>Ban ID: '.$thisID.'</strong> &mdash; Banned for ';
										if($userMESSAGE != '')echo '<span>'.$userMESSAGE.'</span>';
										if($userMESSAGE == '')echo '<span>No ban reason given.</span>';
										echo ' &mdash; <label for="unban'.$thisID.'">[ >> Unban '.$userIP.' ]</label>';
										echo ' <input class="hidden" type="submit" name="unban'.$thisID.'" id="unban'.$thisID.'" />';
										if(isset($_POST['unban'.$thisID])){
											$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$thisID.'','BANNED' => '1'),array( '%d','%d') );
											echo '<meta http-equiv="refresh" content="0;URL=?area=bans">';
										}
										echo '</p>';
									}
								}else{ echo '<p><em>No bans (yet) - great!</em></p>'; }
								echo '</form></div>';
							}

						}else{
						}
						echo '</div></div>';
				}
			
			
			// Board view
			elseif($BOARD != ''){

				// Determine time between between the last post and the flood protection time amount
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
				
				// Show board content if the requested board exists
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
					if($BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD;}
					if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
					if($correct == 1 || $correct == 0){
						echo '<h3>';
						if($correct == 0)echo 'Wrong password.';
						if($correct == 1)echo 'Post deleted!';
						echo '<br />click <a href="'.esc_url($REDIRECTO).'">here</a> if you are not redirected.';
						//echo '<meta http-equiv="refresh" content="5;URL= '.$REDIRECTO.'">';
						echo '</h3>';
					}
				}else{
				
				if(count($getCurrentBoard) > 0){
						$userIsBanned = 0;
						// If set to members only, display this message in place of board content to users who are not logged in.
						if(!is_user_logged_in() && $requirelogged == 1){
							echo '<div class="tinythread"><span class="tinysubject">You are not logged in.</span></div></div>';
						}
						// Continue if user is logged in or logged in not required
						elseif(!is_user_logged_in() && $requirelogged == 0 || is_user_logged_in()){
							// Board content
								foreach($getCurrentBoard as $gotCurrentBoard){
									$boardName = myoptionalmodules_sanistripents($gotCurrentBoard->NAME);
									$boardShort = myoptionalmodules_sanistripents($gotCurrentBoard->SHORTNAME);
									$boardDescription = $purifier->purify($gotCurrentBoard->DESCRIPTION);
									$boardDescription = str_replace('\\\\\\\'','\'',$boardDescription);
									$boardrules = $purifier->purify($gotCurrentBoard->RULES);
									$boardrules  = str_replace('\n','',$boardrules);
									$boardrules  = str_replace('\r','<br />',$boardrules);
									// If user is not banned, check if their IP is blacklisted on the DNSBL.  If it is, autoban them.
									if ($DNSBL === true)
									{
										$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1',' being blacklisted by the DNSBL.','0','0','','0','0','')");
									}
									// If user is banned, don't go any further.
									elseif(count($getUser) > 0)
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
									if($LENGTH == '0'){
										$LENGTH = 'Permanent';
									}
										
									If($LENGTH != '0'){
										if($CURRENTDATE > $banIsActiveFor){ $banLifted = 1;}else{ $banLifted = 0;}
									}else{
										$banLifted = 0;
									}
										{
											echo '<div class="mainboard boardposts tinyban"><div class="op">';
											echo '<span class="subject">'.$purifier->purify($bannedmessage).'</span><div class="commentMeta">';
											foreach($getUser as $gotUser){
												$BANID = intval($gotUser->ID);
												$IP = intval($gotUser->IP);
												$BANNED = intval($gotUser->BANNED);
												$MESSAGE = myoptionalmodules_sanistripents($gotUser->MESSAGE);
												$MESSAGE = str_replace('\\\\\\\'','\'',$MESSAGE);
												if($MESSAGE == '')$MESSAGE = '<em>No reason given</em>';
												echo '<span><i class="fa fa-user"> Your IP: '.$ipaddress.'</i></span>
												<span><i class="fa fa-clock-o"> Length: '.$LENGTH.'</i></span></div>';
												echo '<div class="commentContainer commentOP">';
												echo '<p>You have been banned from using these boards';
												if ($LENGTH === 'Permanent'){echo ' permanently';}
												if ($LENGTH !== 'Permanent'){echo ' for '.$LENGTH;}
												echo '.  Your ban was filed on '.$FILED.'.  The reason given for your ban was:</p><p>'.$MESSAGE.'.</p><p>If you wish to appeal this ban, please e-mail the moderators of this board with the following ID: '.$BANID.', with the subject line <em>Ban Appeal</em>, and someone will get back to you shortly.  If there is no moderation e-mail on file, there is nothing more for you to do here.</p><p>Have a nice day.</p>';
												echo '</div>';
											}
											echo '</div></div>';
										}
									
									if($LENGTH != '0'){
										if($banLifted == '1'){
											$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$BANID.'','BANNED' => '1'),array( '%d','%d') );
											echo '<div class="mainboard boardposts"><div class="op"><span class="subject">Your ban is lifted - refresh the page to continue.</span></div></div>';
										}
									}
									
									}
									// If user is not banned, and they haven't been listed on the DNSBL, let them view the board content.
									elseif($userIsBanned == 0){
									
										if($THREAD != ''){
											$currentCountNomber = 0;
											foreach($countParentReplies as $currentCount){
												$currentCountNomber++;
											}
										}								
									
										// Form handling
										if(isset($_POST['FORMSUBMIT'])){
										if($posting == 1 && $timegateactive !== true){
											if(isset($_POST['FORMSUBMIT']) && $posting == 1 && $THREAD == '' || isset($_POST['FORMSUBMIT']) && $currentCountNomber < $maxreplies && $posting == 1 && $THREAD != ''){
													$IS_IT_SPAM = 0;
													if(function_exists('akismet_admin_init')){
														$APIKey = myoptionalmodules_sanistripents(get_option('wordpress_api_key'));
														$THISPAGE = get_permalink();
														if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD;}
														if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
														$akismet = new Akismet($WebsiteURL, $APIKey);
														if($akismet->isKeyValid()) {}else{echo 'Your API key is NOT valid!';die();}
														if ($_SERVER["REQUEST_METHOD"] == 'POST') {
															//CHANGE the $_REQUEST items to match your form field input element names
															$akismet = new Akismet($WebsiteURL, $APIKey); //
															$akismet->setCommentAuthorEmail(esc_sql($_REQUEST["EMAIL"]));
															$akismet->setCommentAuthorURL(esc_sql($_REQUEST["URL"]));
															$akismet->setCommentContent(esc_sql($_REQUEST["COMMENT"]));
															$akismet->setPermalink(esc_url($_SERVER["HTTP_REFERER"]));
															if($akismet->isCommentSpam()) {
															$IS_IS_SPAM = 1;
															}
														}					
													}
													$empty = 0;
													if($_REQUEST['COMMENT'] == '' && $_REQUEST['URL'] == '') {
														$empty = 1;
													}elseif($_REQUEST['LINK'] != '' || $_REQUEST['PAGE'] != '' || $_REQUEST['LOGIN'] != '' || $_REQUEST['USERNAME'] != ''){
														$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1','filling out hidden form areas (likely bot).','0','0','','0','0','')");
													}elseif($IS_IT_SPAM == 1){
														$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1','Akismet detected you as SPAM.','0','0','','0','0','')");
													}else{
														if($IS_IT_SPAM == 1) {
														}else{
															if($THREAD == '' && $enableurl == 1 || $THREAD != ''  && $enablerep == 1){
																$cleanURL = esc_url($_REQUEST['URL']);
																// http://frankkoehl.com/2009/09/http-status-code-curl-php/
																$ch = curl_init();
																$opts = array(CURLOPT_RETURNTRANSFER => true,
																CURLOPT_URL => $cleanURL,
																CURLOPT_NOBODY => true,
																CURLOPT_TIMEOUT => 10);
																curl_setopt_array($ch, $opts);
																curl_exec($ch);
																$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
																curl_close($ch);
																
																function get_domain($url){
																	$pieces = parse_url($url);
																	$domain = isset($pieces['host']) ? $pieces['host'] : '';
																	if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
																		return $regs['domain'];
																	}
																	return false;
																}
																if($untrusteddomain != ''){
																	foreach($untrusteddomain as $UNTRUSTED){
																		$untrusteddomain = get_domain($cleanURL);
																		if($untrusteddomain === $UNTRUSTED){$untrusted = 1;}
																		else{$untrusted = 0;}
																	}
																}
																if($untrusteddomain == ''){
																	$untrusted = 0;
																}
																
																if($cleanURL != '' && $untrusted == 0){
																	$path_info = pathinfo($cleanURL);
																	
																	if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $cleanURL, $match)) {
																		$VIDEOID = $match[1];																
																		$TYPE = 'video';
																		$URL = esc_sql($VIDEOID);
																	}
																	elseif($status == '200' && getimagesize($cleanURL) !== false){
																	if($trustedimg != ''){
																		foreach($trustedimg as $TRUSTED){
																			$trusteddomain = get_domain($cleanURL);
																			if($trusteddomain === $TRUSTED)$trusted = 1;
																		}
																	}
																	if($trustedimg == ''){
																		$trusted = 1;
																	}									
																	
																		if($path_info['extension'] == 'jpg' ||
																			$path_info['extension'] == 'gif' ||
																			$path_info['extension'] == 'jpeg' ||
																			$path_info['extension'] == 'png'){
																			
																			if($trusted == 1){
																				$TYPE = 'image';
																				$URL = $cleanURL;
																			}																		
																		}
																	}else{
																		$TYPE = 'URL';
																		if (false === strpos($cleanURL, '://')) {
																			$URL = 'http://'.$cleanURL;
																		}else{
																			$URL = esc_url($cleanURL);
																		}
																	}
																}else{
																	$TYPE = '';
																	$URL = '';
																}
															}
															
															if($THREAD != '')$enteredPARENT = intval($THREAD);
															if($THREAD == '')$enteredPARENT = 0;
															
															if($_REQUEST['COMMENT'] != ''){
																$enteredCOMMENT    = strip_tags(esc_sql($_REQUEST['COMMENT']));
																$enteredCOMMENT    = str_replace(array('<p>','</p>'),'||',(str_replace(array('\\n','\\t','\\r'),'||',$enteredCOMMENT)));
																$enteredCOMMENT    = substr($enteredCOMMENT,0,$maxbody);
																$checkCOMMENT    = $enteredCOMMENT;
															}else{
																$enteredCOMMENT = '';
															}
															$checkURL        = $URL;
															$enteredSUBJECT  = esc_sql($_REQUEST['SUBJECT']);
															$enteredSUBJECT  = substr($enteredSUBJECT,0,$maxtext);
															$enteredPASSWORD = esc_sql($_REQUEST['PASSWORD']);
															if($enteredPASSOWRD != '')$enteredPASSWORD = $enteredPASSWORD;
															if($enteredPASSWORD == '')$enteredPASSWORD = $rand;
															
															if($enteredCOMMENT == '' && $URL != '')$getDuplicate = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE URL = '".$checkURL."' AND BOARD = '".$BOARD."' LIMIT 1");
															if($enteredCOMMENT != '' && $URL == '')$getDuplicate = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE COMMENT = '".$checkCOMMENT."' AND BOARD = '".$BOARD."' LIMIT 1");
															if($enteredCOMMENT != '' && $URL != '')$getDuplicate = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE (COMMENT = '".$checkCOMMENT."' OR URL = '".$checkURL."') AND BOARD = '".$BOARD."' LIMIT 1");
															
															if(count($getDuplicate) == 0 || $_REQUEST['editthisthread'] != '' ){
																if($enableemail == 1){
																if($_REQUEST['EMAIL'] == 'roll'){
																	$enteredEMAIL = ''.$randnum1.' + '.$randnum2.' ('.($randnum1+$randnum2).')'; 
																}elseif($_REQUEST['EMAIL'] == strtolower('heaven')){
																	$enteredEMAIL = 'heaven';
																}else{
																	if(filter_var($_REQUEST['EMAIL'],FILTER_VALIDATE_EMAIL)){
																		$enteredEMAIL = esc_sql(myoptionalmodules_sanistripents(($_REQUEST['EMAIL'])));
																	}else{
																		$enteredEMAIL = esc_sql(myoptionalmodules_sanistripents(myoptionalmodules_tripcode(($_REQUEST['EMAIL']))));
																	}
																	$enteredEMAIL = substr($enteredEMAIL,0,$maxtext);
																}
																}else{
																	$enteredEMAIL = '';
																}
																
																if($ISMODERATOR === true)$modCode = 1;
																if($ISUSERMOD   === true)$modCode = 2;
																if($ISUSER      === true)$modCode = 0;

																if($_REQUEST['REPLYTO'] != ''){
																	$checkrepliedto = esc_sql(intval($_REQUEST['REPLYTO']));
																	$checkreplyto = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE ID = '".$checkrepliedto."' AND BOARD = '".$BOARD."' LIMIT 1");
																	if(count($checkreplyto) > 0){
																		$repliedto = $checkrepliedto;
																	}
																}
																if($_REQUEST['REPLYTO'] == ''){
																	$repliedto = intval(0);
																}
																$edited = 0;
																if($_REQUEST['editthisthread'] != '' && isset($_POST['FORMSUBMIT']) || 
																   $_REQUEST['admin_ids'] != '' && isset($_POST['FORMSUBMIT']) ){
																		
																		if($ISMODERATOR !== true){
																			$checkPassword = esc_sql($enteredPASSWORD);
																			$checkID = esc_sql(intval($_REQUEST['editthisthread']));
																			$checkPass = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PASSWORD = '".$checkPassword."' AND ID = '".$checkID."'");
																			if(count($checkPass) > 0){
																				foreach($checkPass as $Pass){
																					$last = $Pass->LAST;
																					$wpdb->update( ''.$regularboard_posts.'',
																					array( 'SUBJECT' => $enteredSUBJECT, 'COMMENT' => $enteredCOMMENT, 'URL' => $URL, 'TYPE' => $TYPE, 'REPLYTO' => $repliedto, 'LAST' => $last ),
																					array( 'ID' => ''.$checkID.'' ), 
																					array( '%s','%s','%s','%s','%d','%s'));
																					$edited = 1;
																				}
																			}else{
																				$edited = 3;
																				echo '<h3>Wrong password.';
																			}
																		}
																		if($ISMODERATOR === true){
																			$checkID = esc_sql(intval($_REQUEST['editthisthread']));
																			$checkPass = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$checkID."'");
																			if(count($checkPass) > 0){
																				foreach($checkPass as $Pass){
																					$last = $Pass->LAST;
																					$wpdb->update( ''.$regularboard_posts.'',
																					array( 'SUBJECT' => $enteredSUBJECT, 'COMMENT' => $enteredCOMMENT, 'URL' => $URL, 'TYPE' => $TYPE, 'PASSWORD' => $enteredPASSWORD, 'REPLYTO' => $repliedto, 'LAST' => $last ),
																					array( 'ID' => ''.$checkID.'' ), 
																					array( '%s','%s','%s','%s','%s','%d', '%s'));
																					$edited = 1;
																				}
																			}else{
																				$edited = 3;
																				echo '<h3>Wrong password.';
																			}
																		}																		
																}elseif($timegateactive !== true){
																	
																	$wpdb->query(
																		$wpdb->prepare(
																			"INSERT INTO $regularboard_posts 
																			( ID, PARENT, IP, DATE, EMAIL, SUBJECT, COMMENT, URL, TYPE, BOARD, MODERATOR, LAST, STICKY, LOCKED, PASSWORD, REPLYTO, UP ) 
																			VALUES ( %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, %d, %d, %s, %d, %d )",
																			'',
																			$enteredPARENT,
																			$theIP_us32str,
																			$current_timestamp,
																			$enteredEMAIL,
																			$enteredSUBJECT,
																			$enteredCOMMENT,
																			$URL,
																			$TYPE,
																			$BOARD,
																			$modCode,
																			$current_timestamp,
																			0,
																			0,
																			$enteredPASSWORD,
																			$repliedto,
																			1
																		)
																	);
																	
																	$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT + 1 WHERE SHORTNAME = '$BOARD'");
																	
																	$checkUserExists = $wpdb->get_results("SELECT ID FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
																	if(count($checkUserExists) == 0){
																		$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','0','0','8','Karma count','','0','','0','0','')");
																	}
																}
																
																if($THREAD != '' && $LOCKED != 1 && strtolower($enteredEMAIL) != 'sage'){
																	$wpdb->query("UPDATE $regularboard_posts SET LAST = '$current_timestamp' WHERE ID = '$THREAD'");
																}
																
															}else{
																if(count($getDuplicate) > 0){
																	$automute = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND MESSAGE = 'unoriginal' LIMIT 1");
																	if(count($automute) > 0){
																		foreach($automute as $getMuted){
																			if($getMuted->BANNED == 5)$wpdb->update( $regularboard_users, array( 'BANNED' => 4 ), array( 'IP' => $theIP_us32str, 'MESSAGE' => 'unoriginal'), array( '%d') );
																			if($getMuted->BANNED == 4)$wpdb->update( $regularboard_users, array( 'BANNED' => 3 ), array( 'IP' => $theIP_us32str, 'MESSAGE' => 'unoriginal'), array( '%d') );
																			if($getMuted->BANNED == 3)$wpdb->update( $regularboard_users, array( 'BANNED' => 2 ), array( 'IP' => $theIP_us32str, 'MESSAGE' => 'unoriginal'), array( '%d') );
																			if($getMuted->BANNED == 2)$wpdb->update( $regularboard_users, array( 'BANNED' => 1, 'MESSAGE' => 'You have tried on 5 different occasions to post unoriginal material to this board, and have consequently been muted' ), array( 'IP' => $theIP_us32str, 'MESSAGE' => 'unoriginal'), array( '%d','%s') );
																		}
																	}else{
																		$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','0','0','5','unoriginal','10 minutes','','','0','0','')");
																	}
																	if($getMuted->BANNED == 5){$mutecount = 4;}
																	elseif($getMuted->BANNED == 4){$mutecount = 3;}
																	elseif($getMuted->BANNED == 3){$mutecount = 2;}
																	elseif($getMuted->BANNED == 2){$mutecount = 1;}
																	elseif($getMuted->BANNED == 1){$mutecount = 0;}
																	else{$mutecount = 5;}
																	$duplicate_found = true;
																}
															}
															
														}
													}
													
													if($edited == 1){
														$LAST = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE (ID = $checkID OR PARENT = $checkID) ORDER BY ID DESC LIMIT 1");
													}else{
														$LAST = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = '".$theIP_us32str."' ORDER BY ID DESC LIMIT 1");
													}
													
													foreach($LAST as $LATEST){
														$IDGOTO = $LATEST->ID;
														if($BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$IDGOTO;}
													}
													
													if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
													
													if($empty == 0){
													if($edited == 0 || $edited == 1 || $timegateactive !== true){
														echo '<hr />';
														echo '<span class="postedMessage">';
														if($edited == 1){ echo 'Edited successfully!'; }
														elseif($duplicate_found === true){echo 'Duplicate found  -  Post discarded.';}
														else{echo esc_attr($postedmessage);}
														echo '</span>';
														
														$pclass = 'information tiny';
														
														if($edited == 1){
															echo '
															<p>Automatically forwarding you to your edited <a href="'.$REDIRECTO.'">post</a>.</p>
															<hr /></div>';
															echo '<meta http-equiv="refresh" content="3;URL= '.esc_url($REDIRECTO).'">';
														}elseif($duplicate_found === true){
															echo '
															<p>To view the found duplicate content, you may click <a href="'.$REDIRECTO.'">here</a>.  Otherwise, please go back and correct your post.  You have '.$mutecount.' more attempts before Auto-Mute is enabled.  Once Auto-Mute is enabled, you will not be able to interact with these boards for 10 minutes.</p>
															<hr />
															<p class="'.$pclass.'"><i class="fa fa-warning"></i> As part of this board\'s Auto-Mute feature, content that has already been submitted may not be submitted again.  
															What this means is that you can not submit the exact same content more than once.  Any IP address that attempts 
															to do this more than 5 times will be temporarily banned from using this board for 10 minutes.</p>
															<p class="'.$pclass.'"><i class="fa fa-question"></i> The simplest way that you can avoid these temporary bans by submitting thought provoking and <strong>original</strong> content and links,
															instead of submitting things that have already been submitted before.  There <strong>is</strong> a search function to browse the board via keywords.  Perhaps searching for your 
															content before submitting it will aid you in the future.</p>';
														}else{
															if($isnew == 0){
																if(count($checkUserExists) == 0){
																	echo '
																	<p>You\'ve just made your first post.  Click <a href="'.$REDIRECTO.'">here</a> to be taken to it.</p>
																	<hr />';
																	echo '<p class="'.$pclass.'"><i class="fa fa-thumbs-up"></i> Posts and replies can be Approved of (or Disapproved) - which will add (or detract) from your overall Approval rating on this site.
																	Ratings are tracked by IP address alone - posting from different IP addresses will obviously mean different Approval ratings for each of your posts.</p>
																	<p class="'.$pclass.'"><i class="fa fa-user"></i> We use your IP address to identify you, for the purposes of user stats, and for the purposes of board moderation.  Your IP address is never made 
																	publicly available.  All users are <em>anonymous</em> (in the sense that there are no names attached to their posts).</p>
																	<p class="'.$pclass.'"><i class="fa fa-terminal"></i> Did you know that you can format your comments using special code?  Surrounding a word with *s, like *this*, will result in an <em>italicized</em> 
																	word, while **this** will result in a <strong>bold</strong> word.  Read <a href="?area=help">this</a> for more information.</p>
																	<p class="'.$pclass.'"><i class="fa fa-warning"></i> Now that you\'ve made your first post, this information screen will no longer be presented to you.  Instead, in the future, when making new posts,
																	you will simply be automatically forwarded to them.  Now go forth - and be a productive member of this community!</p>';
																}else{
																echo '
																	<p>Automatically forwarding you to your new <a href="'.$REDIRECTO.'">post</a>.</p>
																	<hr /></div>';
																	echo '<meta http-equiv="refresh" content="3;URL= '.esc_url($REDIRECTO).'">';
																}
															}
														}
														
														
													}
														
													}
												}
											}elseif(isset($_POST['FORMSUBMIT']) && $timegateactive === true){
														echo 'You can\'t do that yet.';
														
										}}
				

										if(!isset($_POST['FORMSUBMIT'])){
												if($posting == 0){
													if($AREA == 'newtopic'){
													echo '<div class="tinythread"><span class="tinysubject">This board is currently locked.</span></div></div>';
													}
												}elseif($posting == 1 && $SEARCH == ''){
												if($BOARD != ''){
													
													if(filter_var($checkThisIP,FILTER_VALIDATE_IP)){ $IPPASS = true; }
													elseif(filter_var($checkThisIP,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){ $IPPASS = true; }
													else{ $IPPASS = false;}
														if($timegateactive === true){
															echo '<div class="timegate"><h3>'. (10 - $timegate) . ' seconds until you can post again.</h3></div>';
														}else{
															if($posting != 1){
																echo '<h3>Read-Only Mode</h3>';
															}
															elseif($posting == 1 && $IPPASS === false){
																echo '<h3>You are not permitted to post.</h3>';
															}
															elseif($posting == 1 && $IPPASS === true){	
																if($THREAD != '' && $currentCountNomber >= $maxreplies){
																}else{
																	$LOCKED = 0;
																	if($THREAD != '')$checkLOCK = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE LOCKED = '1' AND ID = '".$THREAD."' LIMIT 1");
																	if(count($checkLOCK) == 1)$LOCKED = 1;
																	if($LOCKED == 1 )echo '<h3><i class="fa fa-lock"></i> THREAD LOCKED</h3>';
																	if($LOCKED == 0){
																	$correct = 0;
																	if($iexist == 0){
																	if(isset($_POST['iexist']) && $_REQUEST['addme'] == $theIP_s32int && $iexist == 0){
																		$IP      = $theIP_s32int;
																		$wpdb->query(
																			$wpdb->prepare(
																				"INSERT INTO $regularboard_users 
																				( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS ) 
																				VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s )",
																				'',
																				$current_timestamp,
																				$IP,
																				0,
																				0,
																				'',
																				8,
																				'new user',
																				'',
																				0,
																				'',
																				0,
																				0,
																				''
																			)
																		);
																		echo '<meta http-equiv="refresh" content="0">';
																	}			
																	
																	echo '
																	<div class="tinythread">
																	<p>In order to verify that you are not a bot, you will need to fill out this form.  You will only need to do this once.  Until you fill out this form, you may not comment on this board.</p>
																	<form method="post" class="upgrade">
																	<label for="iexist">Type <code>'.$theIP_s32int.'</code> and press enter.</label>
																	<input type="text" id="addme" name="addme" class="addme" value="" placeholder="'.$theIP_s32int.'" />
																	<input type="submit" name="iexist" id="iexist" value="Add me." class="hidden" />
																	</form>
																	</div>';
																	if($AREA == 'newtopic')echo '</div>';
																	}else{															
																		if(isset($_POST['edit_this']) && $_REQUEST['report_ids'] !== '' && $_REQUEST['DELETEPASSWORD'] !== '' || 
																		$ISMODERATOR === true && isset($_POST['admin_edit']) && $_REQUEST['admin_ids'] !== '' || 
																		$ISUSERMOD === true && isset($_POST['admin_edit']) && $_REQUEST['admin_ids'] !== '') {
																			$checkPassword = esc_sql($_REQUEST['DELETEPASSWORD']);
																			if($ISMODERATOR === true){
																				$checkID = intval($_REQUEST['admin_ids']);
																				$checkPass = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = $checkID");
																			}
																			elseif($ISUSERMOD === true){
																				$checkID = intval($_REQUEST['admin_ids']);
																				$checkPass = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = $checkID AND MODERATOR != '1'");
																			}
																			elseif($ISMODERATOR !== true){
																				$checkID = intval($_REQUEST['report_ids']);
																				$checkPass = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PASSWORD = '".$checkPassword."' AND ID = $checkID");
																			}
																			if(count($checkPass) > 0){
																				echo '<div class="tinyreply">';
																				foreach($checkPass as $EDITTHREAD){
																					$editComment = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',(str_replace('\\r\\n','||',($EDITTHREAD->COMMENT))))))));
																					$editSubject = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"||",($EDITTHREAD->SUBJECT))))));
																					if($imgurid != ''){
																						echo '
																						<form class="imgur" enctype="multipart/form-data" method="POST">
																						<input name="img" size="35" type="file"/><input type="submit" id="submitimgur" name="submitimgur" value="Upload"/></form>';
																					}else{
																						echo '<span class="placeholder"></span>';
																					}
																					echo '<form name="editform" method="post" action="'.$ACTION.'" class="COMMENTFORM">';
																					wp_nonce_field('editform');
																					echo '<input type="hidden" value="" name="LINK" />';
																					echo '<input type="hidden" value="" name="PAGE" />';
																					echo '<input type="hidden" value="" name="LOGIN" />';
																					echo '<input type="hidden" value="" name="USERNAME" />';
																					echo '<input type="hidden" value="'.$checkID.'" id="editthisthread" name="editthisthread" />';
																					if($ISUSER !== true || $ISUSERJANITOR !== true)echo '<section class="passwordthis"><input type="password" id="PASSWORD" maxlength="'.$maxtext.'" name="PASSWORD" value="'.$EDITTHREAD->PASSWORD.'" /></section>';
																					echo '<section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" value="'.$editSubject.'" /></section>';
																					echo '<section class="full"><textarea id="COMMENT" name="COMMENT">'.$editComment.'</textarea></section>';
																					echo '<section class="formbottom">';
																					echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$EDITTHREAD->URL.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';
																					echo '<section class="replytothis"><input type="text" id="REPLYTO" maxlength="'.$maxtext.'" name="REPLYTO" '; if($EDITTHREAD->REPLYTO != 0){ echo 'value="'.$EDITTHREAD->REPLYTO.'"';}echo ' placeholder="No. ###" /></section>';
																					echo '</section><span id="count"></span>';
																					echo '<section class="full submission"><label for="FORMSUBMIT" class="submit">Post</label><input type="submit" name="FORMSUBMIT" id="FORMSUBMIT" /></section>';
																					echo '</form>';
																					echo '</div>';
																					echo '<script type="text/javascript">
																						var area = document.getElementById("COMMENT");
																						var message = document.getElementById("count");
																						var maxLength = '.$maxbody.';
																						var checkLength = function() {
																							if(area.value.length < maxLength) {
																								message.innerHTML = (maxLength-area.value.length);
																							}
																						}
																						setInterval(checkLength, 300);
																					</script>
																					</div>';																																						
																					$correct = 3;
																				}
																			}
																		}
																		if($correct == 0 && $AREA == 'newtopic' || $correct == 0 && $THREAD != '' && count($getParentPosts) > 0){
																			echo '<div class="tinyreply">';
																			if($imgurid != ''){
																				echo '
																				<form class="imgur" enctype="multipart/form-data" method="POST">
																				<input name="img" size="35" type="file"/><input type="submit" id="submitimgur" name="submitimgur" value="Upload"/></form>';
																			}else{
																				echo '<span class="placeholder"></span>';
																			}
																			echo '
																			<form name="regularboard" method="post" action="'.$ACTION.'" class="COMMENTFORM">';
																			wp_nonce_field('regularboard');
																			echo '<input type="hidden" value="" name="LINK" />';
																			echo '<input type="hidden" value="" name="PAGE" />';
																			echo '<input type="hidden" value="" name="LOGIN" />';
																			echo '<input type="hidden" value="" name="USERNAME" />';
																			echo '<section class="passwordthis"><input type="password" id="PASSWORD" maxlength="'.$maxtext.'" name="PASSWORD" value="'.$profilepassword.'" /></section>';
																			echo '<section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" /></section>';
																			echo '<section class="full"><textarea id="COMMENT" name="COMMENT" placeholder="Comment"></textarea></section>';
																			echo '<section class="formbottom">';
																			if($enableurl == 1 && $THREAD == ''){echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$thisimageupload.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';}
																			if($enablerep == 1 && $THREAD != '')echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$thisimageupload.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';
																			if($enableemail == 1)echo '<section class="email"><input type="text" id="EMAIL" maxlength="'.$maxtext.'" name="EMAIL" placeholder="E-mail" value="';if($profileheaven == 1){echo 'heaven';}echo '" /></section>';
																			if($THREAD != '')echo '<section class="replytothis"><input type="text" id="REPLYTO" maxlength="'.$maxtext.'" name="REPLYTO" placeholder="No. ###" /></section>';
																			echo '</section><span id="count"></span>';
																			echo '<section class="full submission"><label for="FORMSUBMIT" class="submit">Post</label><input type="submit" name="FORMSUBMIT" id="FORMSUBMIT" /></section>';
																			echo '</form>';
																			echo '</div>';
																			echo '<script type="text/javascript">
																			var area = document.getElementById("COMMENT");
																			var message = document.getElementById("count");
																			var maxLength = '.$maxbody.';
																			var checkLength = function() {
																			if(area.value.length < maxLength) {
																			message.innerHTML = (maxLength-area.value.length);
																			}
																			}
																			setInterval(checkLength, 300);
																			</script>';
																			if($AREA == 'newtopic')echo '</div>';
																		}
																	}
																}
															}
														}
													}
												}
													// Moderator thread and reply tools (for stickying/locking/deleting/banning via Post Nomber
													if($usermod != ''){
														$usermod = array($usermod);
													}
														if($_REQUEST['DELETEPASSWORD'] == ''){
															if(isset($_POST['report_this']) && $_REQUEST['report_ids'] != ''){
																$ID2REPORT = esc_sql(intval($_REQUEST['report_ids']));
																$REPORTMESSAGE = esc_sql($_REQUEST['report_reason']);
																$IP = esc_sql($theIP_us32str);
																$grabReport = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE THREAD = '".$ID2REPORT."'");
																$grabParentofReport = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$ID2REPORT."'");
																$exists = 0;
																$LENGTH = 1;
																foreach($grabParentofReport as $theParent){
																	$thisPARENT = $theParent->PARENT;
																	if($thisPARENT == 0){$THEPARENT = 0;}
																	else{$THEPARENT = $thisPARENT;}
																	$exists++;
																}
																if(count($grabReport) == 0 && $exists > 0){
																	$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$IP','$ID2REPORT','$THEPARENT','$BOARD','3','$REPORTMESSAGE','$LENGTH','0','','0','0','')");
																	echo '<span class="alert">Report received.  Thank you!</span>';
																}elseif($exists == 0){
																	echo '<span class="alert">Thread does not exist.</span>';
																}elseif(count($grabReport) > 0){
																	echo '<span class="alert">Thread has already been reported.</span>';
																}
																echo '<hr />';
															}
														}
													
													}
													
													

													// Board data display (if board exists) start
													$totalREPLIES = 0;
													if($AREA != 'newtopic' && $correct != 3){
														if(count($getParentPosts) > 0){
														
															if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD;}
															if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}

															// Search form
															echo '<form name="regularboardsearch" id="tinysearch" method="post" action="'.$ACTION.'">';wp_nonce_field('regularboardsearch');echo '<input type="text" name="boardsearch" id="boardsearch" placeholder="Search ';if($THREAD == ''){echo $BOARD;}if($THREAD != ''){echo 'this thread';} echo ' for..." /><input type="submit" class="hidden" id="searchsub" name="searchsub" value="Search" /></form>';

															// Thread[start]
															if($lock == 1)echo '<div class="tinythread"><span class="tinysubject">This board is currently locked.</span></div>';
															if($THREAD == '' && $BOARD != ''){
																echo '
																<div class="tinythread">
																<span class="tinysubject">Thread</span>
																<span class="tinyreplies">Replies</span>
																<span class="tinydate">Age</span>
																</div>';
															}
															foreach($getParentPosts as $parentPosts){
																$threads = 0;
																$gotModReply      =            '';
																$ID               =            intval($parentPosts->ID);														
																if($THREAD != ''){
																	$jTitle 			= $purifier->purify($parentPosts->SUBJECT);
																	if($jTitle         == '') $jTitle = 'No subject';
																	$jTitle          	= str_replace('\\\\\\\'','',$jTitle);
																	$originaltitle      = get_the_title($ID);
																	echo '
																	<script type="text/javascript">document.title = \''.$jTitle.' \\ '.$BOARD.'\';</script>
																	';
																}
																$thread_reply     =            '<span><i class="fa fa-angle-right"> No. <a href="#COMMENTFORM" onclick="replyThis(event)">'.$ID.'</a></i></span> ';
																$IP               =            intval($parentPosts->IP);
																$KARMACOUNT       =             $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$IP."'  AND BANNED = '8' LIMIT 1");
																foreach($KARMACOUNT as $KARMAD){$KARMA = $KARMAD->KARMA;$profilelink  = '?profile='.intval($KARMAD->ID);}
																$karma_count      =            '<span><i class="fa fa-heart karma"> '.$KARMA.'</i></span>';
																
																$LOCKED           =            intval($parentPosts->LOCKED);
																$STICKY           =            intval($parentPosts->STICKY);
																$DATE             =            $parentPosts->DATE;
																
																if($STICKY == 1)$sticky =      '<span><i class="fa fa-thumb-tack"></i></span>';
																if($STICKY == 0)$sticky =      '<span><i class="fa fa-thumb-tack faded"></i></span>';
																if($LOCKED == 1)$locked =      '<span><i class="fa fa-lock"></i></span>';
																if($LOCKED == 0)$locked =      '<span><i class="fa fa-unlock"></i></span>';
																$date = '<span class="tinydate">'.timesincethis($DATE).' <a href="?thread='.intval($parentPosts->ID).'">##</a></span>';
																$MODERATOR        =            intval($parentPosts->MODERATOR);
																$PARENT           =            intval($parentPosts->PARENT);
																$VUP              =            intval($parentPosts->UP);
																
																$thread_karma     =            '<span class="tinykarma">'.$VUP.'</span>';
																$BOARD            =            $parentPosts->BOARD;
																$EMAIL            =            $parentPosts->EMAIL;

																if($EMAIL == ''){
																	$op_trip = '';
																}
																if($EMAIL != ''){
																	if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){
																		$op_trip = ''; 
																	}else{
																		$op_trip = ' <i class="fa fa-exclamation"> '.$EMAIL.'</i>';
																	}
																}														
																if($MODERATOR == 1 && strtolower($EMAIL) != 'heaven')$name = '<a href="'.$profilelink.'"> '.$modcode.$op_trip.'</a>';
																elseif($MODERATOR == 2 && strtolower($EMAIL) != 'heaven')$name = '<a href="'.$profilelink.'"> '.$usermodcode.'</a>';
																elseif($MODERATOR == 0){
																	if(strtolower($EMAIL) == 'heaven'){
																		$name = '???';
																	}else{
																		$name = '<a href="'.$profilelink.'"> '.$defaultname.'</a>';
																	}
																}

																$IAMOP            =            $parentPosts->EMAIL;
																$LAST             =            $parentPosts->LAST;
																$SUBJECT          =            $parentPosts->SUBJECT;
																$TYPE             =            $parentPosts->TYPE;
																$URL              =            $parentPosts->URL;
																$thread_url = '';
																if($TYPE == 'URL' && $URL != '')$thread_url = '<a class="opURL" href="'.esc_url($URL).'"><i class="fa fa-link"></i></a>';
																$COMMENT = wpautop(rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($parentPosts->COMMENT))))))));
																
																$SUBJECT          =  str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($SUBJECT))))))));
																if($SUBJECT      == '')        $SUBJECT = 'No subject';
																if($SUBJECT      != '')        $SUBJECT = $SUBJECT;
																
																if($SEARCH != '' && $THREAD != '') $gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ( EMAIL = '".$SEARCH."' OR COMMENT LIKE '%".$SEARCH."%' OR SUBJECT LIKE '%".$SEARCH."%' OR URL LIKE '%".$SEARCH."%' ) AND PARENT = $ID ORDER BY LAST ASC");
																if($SEARCH == '' && $THREAD != '') $gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."' ORDER BY LAST ASC");
																if($SEARCH != '' && $THREAD != '')echo '<hr /><em>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i> Searching this thread for '.$SEARCH.'.  Returned '.count($gotReplies).' results.</em><hr />';
																if($THREAD       != '')            $gotReply   = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE REPLYTO = '".$ID."' ORDER BY REPLYTO DESC");
																$checkforupvote   =  0;
																$checkfordownvote =  0;
																$getvotestatus    =            $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND THREAD = '".$ID."'");
																foreach($getvotestatus as $votestatus){
																	if($votestatus->MESSAGE == 'Upvote')$checkforupvote++;
																	if($votestatus->MESSAGE == 'Downvote')$checkfordownvote++;
																}
																$getReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."'");
																$totalREPLIES     = count(     $getReplies);
																
																if($THREAD == '')$thread_reply_link = '<span><i class="fa fa-reply"> <a href="?board='.$BOARD.'&amp;thread='.$ID.'">Reply</a> ('.count($getReplies).')</i></span>';
																
																if($TYPE         == 'image')    $THREADIMGS++;
																
																if($PARENT == 0){
																	if($MODERATOR == 0)$getModReply       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."' AND MODERATOR = '1' LIMIT 1");
																	if($MODERATOR != 0)$getModReply		  = 0;
																	if(count($getModReply) > 0 && $getModReply != 0)$gotModReply = ' modreplied';
																	if($gotModReply != '')$modishere = ' <i class="fa fa-star"></i>';
																	$SUBJECT =  '<a class="tinysubject'.$gotModReply.'" href="?board='.$BOARD.'&amp;thread='.$ID.'#'.$parentPosts->ID.'">'.$modishere.$SUBJECT.'</a>';
																}else{
																	$SUBJECT =  '<a class="tinysubject" href="?board='.$BOARD.'&amp;thread='.$PARENT.'#'.$ID.'#'.$parentPosts->ID.'">'.$SUBJECT.'</a>';
																}														
																
																if($URL != '' && $TYPE == 'image'){
																	$op_embed = '<a href="'.$URL.'"><img class="imageOP" src="'.$URL.'" alt="'.$URL.'" /></a>';
																}elseif($TYPE == 'video' && $URL != ''){
																
																	if($profilevideo == 0){
																		$op_embed = '<iframe src="http://www.youtube.com/embed/'.$parentPosts->URL.'?loop=1&amp;playlist='.$parentPosts->URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" width="420" height="315" frameborder="0" allowfullscreen></iframe>';
																	}elseif($profilevideo ==1){
																		$op_embed = '<p><a href="http://youtube.com/watch?v='.$parentPosts->URL.'">Youtube Video Link</a></p>';
																	}
																	
																}else{
																	$op_embed = '';
																}
																
																$imageboard_subject = $SUBJECT.$op_embed;
																if(isset($_POST['DISAPPROVE'.$ID])){
																	echo '<meta http-equiv="refresh" content="0">';
																	$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1");
																	foreach($getUP as $gotUP){
																		$UP = $gotUP->UP;
																		$up = $UP + 1;
																		$down = $UP - 1;
																	}
																	$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1");
																	foreach($getUSER as $USERED){
																		$KARMA = $USERED->KARMA;
																		$kup = $KARMA + 1;
																		$kdown = $KARMA - 1;
																	}											
																	if($checkfordownvote > 0){
																		$wpdb->delete( $regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') );
																		$wpdb->update( $regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') );
																		$wpdb->update( $regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') );
																	}
																	if($checkfordownvote == 0){
																		$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Downvote','','0','','0','0','')");
																		$wpdb->update( $regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') );
																		$wpdb->update( $regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') );
																	}
																}
																if(isset($_POST['APPROVE'.$ID])){
																	echo '<meta http-equiv="refresh" content="0">';
																	$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1");
																	foreach($getUP as $gotUP){
																		$UP = $gotUP->UP;
																		$up = $UP + 1;
																		$down = $UP - 1;
																	}
																	$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1");
																	foreach($getUSER as $USERED){
																		$KARMA = $USERED->KARMA;
																		$kup = $KARMA + 1;
																		$kdown = $KARMA - 1;
																	}																			
																	if($checkforupvote > 0){
																		$wpdb->delete($regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') );
																		$wpdb->update($regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') );
																		$wpdb->update($regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') );
																	}
																	if($checkforupvote == 0){
																		$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Upvote','','0','','0','0','')");
																		$wpdb->update($regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') );
																		$wpdb->update($regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') );
																	}
																}
																if($checkforupvote > 0 && $checkfordownvote == 0){
																	$op_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>';
																}elseif($checkforupvote == 0 && $checkfordownvote > 0){
																	$op_approval_button = '';
																}else{
																	$op_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-o-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>';
																}
																if($checkfordownvote > 0 && $checkforupvote == 0){
																	$op_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>';
																}elseif($checkfordownvote == 0 && $checkforupvote > 0){
																	$op_disapproval_button = '';
																}else{
																	$op_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-o-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>';
																}	
																$vidimg = '';
																if($TYPE == 'video')$vidimg = '<img class="tinyvid" src="http://img.youtube.com/vi/'.$parentPosts->URL.'/0.jpg" />';
																if($THREAD == ''){
																	$thread_header = 
																	'<div class="tinythread" id="thread'.$ID.'">'.
																	$thread_url.$vidimg.$SUBJECT.
																	'<span class="tinyreplies">'.$totalREPLIES.'</span>'.
																	$date.
																	'</div>';
																}
																if($THREAD != ''){
																	$thread_header = 
																	'<div class="tinythread" id="thread'.$ID.'">'.$thread_url.$SUBJECT.'</div>';
																}
																echo $thread_header;
																if($THREAD != ''){
																	echo '<div class="tinycomment" id="'.$ID.'">'.$op_embed.$COMMENT.'
																	<hr />
																	<div class="approvalrating">'.$op_approval_button.$thread_karma.$op_disapproval_button.'</div>
																	<div class="tinymeta">'.$sticky.$locked.'</div>
																	<div class="tinymeta"><span class="tinyname">'.$name.'</span></div>
																	<div class="tinymeta full">'.$date.'</div>
																	</div>';
																}
																
																if($THREAD != '')echo '<div class="omitted'.$ID.'" id="omitted">';
																if(count($gotReplies) > 0){
																		if($gotReplies != ''){
																		foreach($gotReplies as $REPLIES){
																			$THREADREPLIES++;
																			$IP = intval($REPLIES->IP);
																			$KARMACOUNT = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$IP."'  AND BANNED = '8' LIMIT 1");
																			foreach($KARMACOUNT as $KARMAD){$KARMA = $KARMAD->KARMA;$profilelink  = '?profile='.intval($KARMAD->ID);}
																			$karma_count = '<span><i class="fa fa-heart karma"> '.$KARMA.'</i></span>';
																			$URL = $REPLIES->URL;
																			$REPLYTO = intval($REPLIES->REPLYTO);
																			$ID = intval($REPLIES->ID);
																			$gotReply = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE REPLYTO = '".$ID."' ORDER BY REPLYTO DESC");
																			$PARENT = intval($REPLIES->PARENT);
																			$EMAIL = $REPLIES->EMAIL;
																			$MODERATOR = intval($REPLIES->MODERATOR);
																			$reply_trip = '';
																			$this_is_op = '';
																			if($EMAIL != ''){ if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){ $reply_trip = ''; }else{ $reply_trip = ' <i class="fa fa-exclamation"> '.$EMAIL.'</i>'; } }
																			if($EMAIL == $IAMOP && $EMAIL != ''){$this_is_op = ' <strong>(OP)</strong>';}
																			if($MODERATOR == 1 && strtolower($EMAIL) != 'heaven'){$reply_name = '<a href="'.$profilelink.'"> '.$modcode.$reply_trip.$this_is_op.'</a>';}
																			if($MODERATOR == 2 && strtolower($EMAIL) != 'heaven'){$reply_name = '<a href="'.$profilelink.'"> '.$usermodcode.$reply_trip.$this_is_op.'</a>';}
																			if(strtolower($EMAIL) == 'heaven'){$reply_name = ' ???'.$this_is_op;}
																			if($MODERATOR != 1 && $MODERATOR != 2){$reply_name = '<a href="'.$profilelink.'"> '.$defaultname.$reply_trip.$this_is_op.'</a>';}
																			$checkforupvote   =  0;
																			$checkfordownvote =  0;
																			$getvotestatus    =            $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND THREAD = '".$ID."'");
																			foreach($getvotestatus as $votestatus){
																				if($votestatus->MESSAGE == 'Upvote')$checkforupvote++;
																				if($votestatus->MESSAGE == 'Downvote')$checkfordownvote++;
																			}																	
																			if(isset($_POST['DISAPPROVE'.$ID])){ 
																				echo '<meta http-equiv="refresh" content="0">'; 
																				$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1"); 
																				foreach($getUP as $gotUP){ 
																					$UP = $gotUP->UP; $up = $UP + 1; $down = $UP - 1; 
																				}
																				$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1");
																				foreach($getUSER as $USERED){
																					$KARMA = $USERED->KARMA;
																					$kup = $KARMA + 1;
																					$kdown = $KARMA - 1;
																				} 
																				if($checkfordownvote > 0){ 
																					$wpdb->delete( $regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') );
																					$wpdb->update( $regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') );
																					$wpdb->update( $regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') );
																				} 
																				if($checkfordownvote == 0){ 
																					$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Downvote','','0','','0','0','')");
																					$wpdb->update( $regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') );
																					$wpdb->update( $regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') );
																				}
																			}
																			if(isset($_POST['APPROVE'.$ID])){
																				echo '<meta http-equiv="refresh" content="0">'; 
																				$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1");
																				foreach($getUP as $gotUP){
																					$UP = $gotUP->UP; 
																					$up = $UP + 1; 
																					$down = $UP - 1; 
																				}
																				$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1"); 
																				foreach($getUSER as $USERED){
																					$KARMA = $USERED->KARMA; $kup = $KARMA + 1; $kdown = $KARMA - 1; 
																				} 
																				if($checkforupvote > 0){ 
																					$wpdb->delete($regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') ); 
																					$wpdb->update($regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') ); 
																					$wpdb->update($regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') ); 
																				} 
																				if($checkforupvote == 0){ 
																					$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Upvote','','0','','0','0','')");
																					$wpdb->update($regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') );
																					$wpdb->update($regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') );
																				} 
																			}
																			if($checkforupvote > 0 && $checkfordownvote == 0){
																				$reply_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>'; 
																			}elseif($checkforupvote == 0 && $checkfordownvote > 0){
																				$reply_approval_button = ''; 
																			}else{
																				$reply_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-o-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>'; 
																			}
																			if($checkfordownvote > 0 && $checkforupvote == 0){
																				$reply_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>'; 
																			}elseif($checkfordownvote == 0 && $checkforupvote > 0){
																				$reply_disapproval_button = ''; 
																			}else{
																				$reply_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-o-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>'; 
																			}
																			$reply_karma = '<span><em class="karma"><i class="fa fa-heart"> '.$KARMA.'</i></em></span>'; 
																			$reply_date = timesincethis($REPLIES->DATE);
																			$TYPE = $REPLIES->TYPE;
																			if($TYPE == 'image') $THREADIMGS++;
																			$reply_attached_link = '';
																			if($TYPE == 'URL' && $URL != '')$reply_attached_link = '<span><i class="fa fa-angle-right"> <a href="'.esc_url($URL).'">Attached link</a></i></span>';
																			$SUBJECT  = rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',('<span>'.$REPLIES->SUBJECT.'</span>')))));
																			$COMMENT = wpautop(rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($REPLIES->COMMENT))))))));
																			$THISPAGE = get_permalink();
																			$postNo = '<span><i class="fa fa-angle-right"> No. <a href="#COMMENTFORM" onclick="replyThis(event)">'.$ID.'</a></i></span>';
																			$thread_karma = '<span><i class="fa fa-heart"> '.intval($REPLIES->UP).'</i></span>';
																			$reply_embed = '';
																			if($URL != '' && $TYPE == 'image'){
																				if($COMMENT != '')$imgclass = 'REPLY';
																				if($COMMENT == '')$imgclass = 'OP';
																				$reply_embed = '<a href="'.$URL.'"><img class="image'.$imgclass.'" alt="'.$URL.'" src="'.$URL.'"/></a>'; 
																			}elseif($TYPE == 'video' && $URL != ''){ 
																				if($profilevideo == 0){
																					$reply_embed = '<iframe src="http://www.youtube.com/embed/'.$URL.'?loop=1&amp;playlist='.$URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" width="420" heigh="315" frameborder="0" allowfullscreen></iframe>'; 
																				}elseif($profilevideo == 1){
																					$reply_embed = '<p><a href="http://youtube.com/watch?v='.$parentPosts->URL.'">Youtube Video Link</a></p>';		
																				}
																			}
																			if(count($gotReply) > 0){
																				echo '<span class="tinycreplies">'.$ID.' '; foreach($gotReply as $replyid){ $replychild = intval($replyid->ID); $replyparent = intval($replyid->PARENT); $replyboard = strtolower($replyid->BOARD); 
																				$reply_link = '?board='.$replyboard.'&amp;thread='.$replyparent.'&amp;'.$replychild.'#'.$replychild.'">'.$replychild; 
																				echo '<i class="fa fa-reply"> <a href="'.$reply_link.'</i></a>'; } echo '</span>'; 
																			}					
																			echo '<div class="tinycomment below" id="'.$ID.'"><div class="meta">'.$SUBJECT.$postNo.$reply_attached_link;
																			
																			if($REPLYTO != '') echo ' <span><a href="?board='.$BOARD.'&amp;thread='.$THREAD.'&amp'.$REPLYTO.'#'.$REPLYTO.'"><i class="fa fa-angle-double-right">'.$REPLYTO.'</i></a></span>';
																			
																			echo '</div>'.$reply_embed.$COMMENT.'
																			<hr />
																			<div class="approvalrating">'.$reply_approval_button.'<span class="tinykarma">'.intval($REPLIES->UP).'</span>'.$reply_disapproval_button.'</div>
																			<div class="tinymeta"><!--reply_meta--></div>
																			<div class="tinymeta"><span class="tinyname">'.$reply_name.'</span></div>
																			<div class="tinymeta full"><span class="tinydate">'.$reply_date.'  <a href="?thread='.$ID.'">##</a></span></div>
																			</div>';																	
																		}
																	}
																}
															}
															
															if($BOARD != '' && $THREAD == ''){
																$i       = 0;
																$results = intval($_GET['results']);
																$paging  = round($totalpages / $postsperpage);
																if($paging > 0){
																	$pageresults = round($paging / 10);
																	echo '<div class="pages">';
																	if($results > 1) echo '<a href="?board='.$BOARD.'">Latest</a> ';
																	if($results > 2)echo '<a href="?board='.$BOARD.'&amp;results='.($results - 1).'">Newer</a> ';
																	if($results < $paging && $results == '')echo '<a href="?board='.$BOARD.'&amp;results=2">Older</a> ';
																	if($results < $paging && $results != '')echo '<a href="?board='.$BOARD.'&amp;results='.($results + 1).'">Older</a> ';
																	echo '</div>';
																}
															}
															$threadexists = 1;
														}else{
															$threadexists = 0;
														}
														
														// [Return],[Top],[Refresh] links as well as image and reply count stars-bar
														if($THREAD != '' && $threadexists == 1){
															echo '</div><div class="threadinformation"><div class="leftmeta"><a href="?board='.$BOARD.'">Return</a><a href="#top">Top</a></div><i class="fa fa-reply"> '.$THREADREPLIES.'</i> &nbsp; <i class="fa fa-camera-retro"> '.$THREADIMGS.'</i></div>';
														}
														
															if($threadexists == 1){
															echo '<div class="tinybottom">';
															if($ISMODERATOR === true)$posting = 1;
															if($ISUSER === true || $ISUSERJANITOR === true){
																echo '<form name="reporttomods" method="post" action="'.$ACTION.'">';
																wp_nonce_field('reporttomods');
																echo '
																<section class="full"><input type="text" name="report_ids" id="report_ids" value="" placeholder="Post No." /></section>
																<section class="full"><input type="text" name="report_reason" value="" placeholder="Reason (if reporting)" /></section>
																<section class="full"><input type="password" name="DELETEPASSWORD" id="DELETEPASSWORD" /></section>
																<section class="labels_small">
																<label class="submit" title="Edit (password required)" for="edit_this"><i class="fa fa-pencil"></i></label>
																<label class="submit" title="Report" for="report_this"><i class="fa fa-warning"></i></label>
																<label class="submit" title="Delete (password required)" for="delete_this"><i class="fa fa-trash-o"></i></label>
																</section>
																<input type="submit" name="edit_this" value="edit" id="edit_this" class="hidden" />
																<input type="submit" name="report_this" value="report" id="report_this" class="hidden" />
																<input type="submit" name="delete_this" value="delete" id="delete_this" class="hidden" />
																</form>';
															}	
															if(current_user_can('manage_options') || $ISUSERMOD === true || $ISUSERJANITOR === true){
															echo '
															<form name="moderator" method="post" action="'.$ACTION.'">';
															wp_nonce_field('moderator');
															echo '
															<section class="full"><input type="text" name="admin_ids" value="" placeholder="Post No." /></section>';
															if($ISUSERMOD === true || current_user_can('manage_options')){
																echo '
																<section class="full"><input type="text" name="admin_reason" value="" placeholder="Reason4ban shortname4move" /></section>
																<section class="full"><input type="text" name="admin_length" value="" placeholder="Length of ban (0 for forever)" /></section>';
															}
																echo '
																<section class="labels">';
															if($ISUSERMOD === true || current_user_can('manage_options')){
																echo '
																<label class="submit" title="Edit" for="admin_edit">edit</label>
																<label class="submit" title="Move" for="admin_move">move</label>
																<label class="submit" title="Make sticky" for="admin_sticky">sticky</label>
																<label class="submit" title="Lock thread" for="admin_lock">lock</label>
																<label class="submit" title="Unsticky" for="admin_unsticky">unsticky</label>
																<label class="submit" title="Unlock thread" for="admin_unlock">unlock</label>
																<label class="submit" title="Ban" for="admin_ban">ban</label>
																<input type="submit" name="admin_move" value="Move" id="admin_move" class="hidden" />
																<input type="submit" name="admin_ban" value="Ban" id="admin_ban" class="hidden" />
																<input type="submit" name="admin_edit" value="Edit" id="admin_edit" class="hidden" />
																<input type="submit" name="admin_sticky" value="Sticky" id="admin_sticky" class="hidden" />
																<input type="submit" name="admin_lock" value="Lock" id="admin_lock" class="hidden" />
																<input type="submit" name="admin_unsticky" value="Unsticky" id="admin_unsticky" class="hidden" />
																<input type="submit" name="admin_unlock" value="Unlock" id="admin_unlock" class="hidden" />';
															}
															echo '
															<label class="submit" title="Delete" for="admin_delete"><i class="fa fa-trash-o"></i></label>
															<input type="submit" name="admin_delete" value="Delete" id="admin_delete" class="hidden" />
															</section>
															</form>
															';
															}
														}
															echo '</div></div>';
													}
												}
											}
										}
									}
								}else{
									rb_404();
								}
							}
						}elseif($BOARD == '' && $AREA == '' && $THREAD == ''){
							echo '<div class="tinythread"><span class="tinysubject">Latest topics</span><span class="tinyreplies">Board</span><span class="tinydate">Age</span></div>';
							if(count($getParentPosts) > 0){
								foreach($getParentPosts as $posts){
									$subject = '';
									$id = $posts->ID;
									$subject =  str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($posts->SUBJECT))))))));
									if($subject == '')$subject = '<em>no subject</em>';
									$reply = 'thread='.$posts->ID.'#'.$posts->ID;
									echo '<div class="tinythread"><span class="tinysubject">';
									if($posts->TYPE == 'video')echo '<img class="tinyvid" src="http://img.youtube.com/vi/'.$posts->URL.'/0.jpg" alt="Youtube thumbnail" />';
									echo '<a href="?board='.$posts->BOARD.'&amp;'.$reply.'">'.$subject.'</a></span><span class="tinyreplies"><a href="?board='.$posts->BOARD.'">'.$posts->BOARD.'</a></span><span class="tinydate">'.timesincethis($posts->DATE).'  <a href="?thread='.intval($posts->ID).'">##</a></span></div>';
								}
							}
							$i       = 0;
							$results = intval($_GET['results']);
							$paging  = round($totalpages / $postsperpage);
							if($paging > 0){
								$pageresults = round($paging / 10);
								echo '<div class="pages">';
								if($results > 1) echo '<a href="'.$THISPAGE.'">Latest</a> ';
								if($results > 2) echo '<a href="?results='.($results - 1).'">Newer</a> ';
								if($results < $paging && $results == '')echo '<a href="?results=2">Older</a> ';
								if($results < $paging && $results != '')echo '<a href="?results='.($results + 1).'">Older</a> ';
								echo '</div>';
							}						
							echo '</div>';
							echo '<script type="text/javascript">document.title = \'Latest topics\';</script>';
						}elseif($BOARD == '' && $AREA == 'replies' && $THREAD == ''){
							echo '<div class="tinythread"><span class="tinysubject">Latest replies</span><span class="tinyreplies">Board</span><span class="tinydate">Age</span></div>';
							if(count($getParentPosts) > 0){
								foreach($getParentPosts as $posts){
									$subject = '';
									$id = $posts->ID;
									$subject =  str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($posts->SUBJECT))))))));
									if($subject == '')$subject = '<em>no subject</em>';
									$reply = 'thread='.$posts->PARENT.'#'.$posts->ID;
									echo '<div class="tinythread"><span class="tinysubject">';
									if($posts->TYPE == 'video')echo '<img class="tinyvid" src="http://img.youtube.com/vi/'.$posts->URL.'/0.jpg" alt="Youtube thumbnail" />';
									echo '<a href="?board='.$posts->BOARD.'&amp;'.$reply.'">'.$subject.'</a></span><span class="tinyreplies"><a href="?board='.$posts->BOARD.'">'.$posts->BOARD.'</a></span><span class="tinydate">'.timesincethis($posts->DATE).'  <a href="?thread='.intval($posts->ID).'">##</a></span></div>';
								}
							}
							$i       = 0;
							$results = intval($_GET['results']);
							$paging  = round($totalpages / $postsperpage);
							if($paging > 0){
								$pageresults = round($paging / 10);
								echo '<div class="pages">';
								if($results > 1) echo '<a href="?area=replies">Latest</a> ';
								if($results > 2) echo '<a href="?area=replies&amp;results='.($results - 1).'">Newer</a> ';
								if($results < $paging && $results == '')echo '<a href="?area=replies&amp;results=2">Older</a> ';
								if($results < $paging && $results != '')echo '<a href="?area=replies&amp;results='.($results + 1).'">Older</a> ';
								echo '</div>';
							}						
							echo '</div>';
							echo '<script type="text/javascript">document.title = \'Latest replies\';</script>';
						}elseif($BOARD == '' && $AREA == 'subscribed' && $THREAD == '' && $boards != ''){
							echo '<div class="tinythread"><span class="tinysubject">Subscribed boards</span><span class="tinyreplies">Board</span><span class="tinydate">Age</span></div>';
							if(count($getParentPosts) > 0){
								foreach($getParentPosts as $posts){
									$subject = '';
									$id = $posts->ID;
									$subject =  str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($posts->SUBJECT))))))));
									if($subject == '')$subject = '<em>no subject</em>';
									if($posts->PARENT != 0)$reply = 'thread='.$posts->PARENT.'#'.$posts->ID;
									if($posts->PARENT == 0)$reply = 'thread='.$posts->ID.'#'.$posts->ID;
									echo '<div class="tinythread"><span class="tinysubject">';
									if($posts->TYPE == 'video')echo '<img class="tinyvid" src="http://img.youtube.com/vi/'.$posts->URL.'/0.jpg" alt="Youtube thumbnail" />';
									echo '<a href="?board='.$posts->BOARD.'&amp;'.$reply.'">'.$subject.'</a></span><span class="tinyreplies"><a href="?board='.$posts->BOARD.'">'.$posts->BOARD.'</a></span><span class="tinydate">'.timesincethis($posts->DATE).'  <a href="?thread='.intval($posts->ID).'">##</a></span></div>';
								}
							}else{
								echo '<div class="tinythread"><span class="tinysubject">Nothing to show.</span></div>';
							}
							$i       = 0;
							$results = intval($_GET['results']);
							$paging  = round($totalpages / $postsperpage);
							if($paging > 0){
								$pageresults = round($paging / 10);
								echo '<div class="pages">';
								if($results > 1) echo '<a href="?area=subscribed">Latest</a> ';
								if($results > 2) echo '<a href="?area=subscribed&amp;results='.($results - 1).'">Newer</a> ';
								if($results < $paging && $results == '')echo '<a href="?area=subscribed&amp;results=2">Older</a> ';
								if($results < $paging && $results != '')echo '<a href="?area=subscribed&amp;results='.($results + 1).'">Older</a> ';
								echo '</div>';
							}						
							echo '</div>';
							echo '<script type="text/javascript">document.title = \'Subscribed boards\';</script>';											
						}elseif($BOARD == '' && $AREA == 'all' && $THREAD == ''){
							echo '<div class="tinythread"><span class="tinysubject">All activity</span><span class="tinyreplies">Board</span><span class="tinydate">Age</span></div>';
							if(count($getParentPosts) > 0){
								foreach($getParentPosts as $posts){
									$subject = '';
									$id = $posts->ID;
									$subject =  str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace('\\r','<br />',(str_replace('\\n','<br />',rb_format($posts->SUBJECT))))))));
									if($subject == '')$subject = '<em>no subject</em>';
									if($posts->PARENT != 0)$reply = 'thread='.$posts->PARENT.'#'.$posts->ID;
									if($posts->PARENT == 0)$reply = 'thread='.$posts->ID.'#'.$posts->ID;
									echo '<div class="tinythread"><span class="tinysubject">';
									if($posts->TYPE == 'video')echo '<img class="tinyvid" src="http://img.youtube.com/vi/'.$posts->URL.'/0.jpg" alt="Youtube thumbnail" />';
									echo '<a href="?board='.$posts->BOARD.'&amp;'.$reply.'">'.$subject.'</a></span><span class="tinyreplies"><a href="?board='.$posts->BOARD.'">'.$posts->BOARD.'</a></span><span class="tinydate">'.timesincethis($posts->DATE).'  <a href="?thread='.intval($posts->ID).'">##</a></span></div>';
								}
							}
							$i       = 0;
							$results = intval($_GET['results']);
							$paging  = round($totalpages / $postsperpage);
							if($paging > 0){
								$pageresults = round($paging / 10);
								echo '<div class="pages">';
								if($results > 1) echo '<a href="?area=all">Latest</a> ';
								if($results > 2) echo '<a href="?area=all&amp;results='.($results - 1).'">Newer</a> ';
								if($results < $paging && $results == '')echo '<a href="?area=all&amp;results=2">Older</a> ';
								if($results < $paging && $results != '')echo '<a href="?area=all&amp;results='.($results + 1).'">Older</a> ';
								echo '</div>';
							}						
							echo '</div>';
							echo '<script type="text/javascript">document.title = \'All activity\';</script>';							
						}elseif($BOARD == '' && $THREAD != ''){
						if(count($gotReplies) > 0){
							if($gotReplies != ''){
								foreach($gotReplies as $REPLIES){
									$requirelogged = 0;
									$shortname = esc_sql($REPLIES->BOARD);
									$checklogged = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '$shortname' LIMIT 1");
									foreach($checklogged as $LOGGED){
										if($LOGGED->LOGGED == 1){
											$requirelogged = 1;
										}
									}
										if(!is_user_logged_in() && $requirelogged == 1){
											echo '<div class="tinythread"><span class="tinysubject">You are not logged in.</span></div>';
										}else{
										echo '<div class="tinythread"><span class="tinysubject">Permanent link to '.$THREAD.'</span></div>';
										$THREADREPLIES++;
										$IP = intval($REPLIES->IP);
										$KARMACOUNT = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$IP."'  AND BANNED = '8' LIMIT 1");
										foreach($KARMACOUNT as $KARMAD){$KARMA = $KARMAD->KARMA;$profilelink  = '?profile='.intval($KARMAD->ID);}
										$karma_count = '<span><i class="fa fa-heart karma"> '.$KARMA.'</i></span>';
										$URL = $REPLIES->URL;
										$REPLYTO = intval($REPLIES->REPLYTO);
										$ID = intval($REPLIES->ID);
										$gotReply = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE REPLYTO = '".$ID."' ORDER BY REPLYTO DESC");
										$PARENT = intval($REPLIES->PARENT);
										$EMAIL = $REPLIES->EMAIL;
										$MODERATOR = intval($REPLIES->MODERATOR);
										$reply_trip = '';
										$this_is_op = '';
										if($EMAIL != ''){ if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){ $reply_trip = ''; }else{ $reply_trip = ' <i class="fa fa-exclamation"> '.$EMAIL.'</i>'; } }
										if($EMAIL == $IAMOP && $EMAIL != ''){$this_is_op = ' <strong>(OP)</strong>';}
										if($MODERATOR == 1 && strtolower($EMAIL) != 'heaven'){$reply_name = '<a href="'.$profilelink.'"> '.$modcode.$reply_trip.$this_is_op.'</a>';}
										if($MODERATOR == 2 && strtolower($EMAIL) != 'heaven'){$reply_name = '<a href="'.$profilelink.'"> '.$usermodcode.$reply_trip.$this_is_op.'</a>';}
										if(strtolower($EMAIL) == 'heaven'){$reply_name = ' ???'.$this_is_op;}
										if($MODERATOR != 1 && $MODERATOR != 2){$reply_name = '<a href="'.$profilelink.'"> '.$defaultname.$reply_trip.$this_is_op.'</a>';}
										$checkforupvote   =  0;
										$checkfordownvote =  0;
										$getvotestatus    =            $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND THREAD = '".$ID."'");
										foreach($getvotestatus as $votestatus){
											if($votestatus->MESSAGE == 'Upvote')$checkforupvote++;
											if($votestatus->MESSAGE == 'Downvote')$checkfordownvote++;
										}																	
										if(isset($_POST['DISAPPROVE'.$ID])){
											echo '<meta http-equiv="refresh" content="0">'; 
											$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1"); 
											foreach($getUP as $gotUP){ 
												$UP = $gotUP->UP; $up = $UP + 1; $down = $UP - 1; 
											}
											$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1");
											foreach($getUSER as $USERED){
												$KARMA = $USERED->KARMA;
												$kup = $KARMA + 1;
												$kdown = $KARMA - 1;
											} 
											if($checkfordownvote > 0){ 
												$wpdb->delete( $regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') );
												$wpdb->update( $regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') );
												$wpdb->update( $regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') );
											} 
											if($checkfordownvote == 0){ 
												$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Downvote','','0','','0','0','')");
												$wpdb->update( $regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') );
												$wpdb->update( $regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') );
											}
										}
										if(isset($_POST['APPROVE'.$ID])){
											echo '<meta http-equiv="refresh" content="0">'; 
											$getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1");
											foreach($getUP as $gotUP){
												$UP = $gotUP->UP; 
												$up = $UP + 1; 
												$down = $UP - 1; 
											}
											$getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1"); 
											foreach($getUSER as $USERED){
												$KARMA = $USERED->KARMA; $kup = $KARMA + 1; $kdown = $KARMA - 1; 
											} 
											if($checkforupvote > 0){ 
												$wpdb->delete($regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') ); 
												$wpdb->update($regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') ); 
												$wpdb->update($regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') ); 
											} 
											if($checkforupvote == 0){ 
												$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Upvote','','0','','0','0','')");
												$wpdb->update($regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') );
												$wpdb->update($regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') );
											} 
										}
										if($checkforupvote > 0 && $checkfordownvote == 0){
											$reply_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>'; 
										}elseif($checkforupvote == 0 && $checkfordownvote > 0){
											$reply_approval_button = ''; 
										}else{
											$reply_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-o-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>'; 
										}
										if($checkfordownvote > 0 && $checkforupvote == 0){
											$reply_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>'; 
										}elseif($checkfordownvote == 0 && $checkforupvote > 0){
											$reply_disapproval_button = ''; 
										}else{
											$reply_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-o-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>'; 
										}
										$reply_karma = '<span><em class="karma"><i class="fa fa-heart"> '.$KARMA.'</i></em></span>'; 
										$reply_date = timesincethis($REPLIES->DATE);
										$TYPE = $REPLIES->TYPE;
										if($TYPE == 'image') $THREADIMGS++;
										$reply_attached_link = '';
										if($TYPE == 'URL' && $URL != '')$reply_attached_link = '<span><i class="fa fa-angle-right"> <a href="'.esc_url($URL).'">Attached link</a></i></span>';
										$SUBJECT  = rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',('<span>'.$REPLIES->SUBJECT.'</span>')))));
										$COMMENT = wpautop(rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($REPLIES->COMMENT))))))));
										$THISPAGE = get_permalink();
										
										if($REPLIES->PARENT == 0) $perma = '?board='.$REPLIES->BOARD.'&amp;thread='.$REPLIES->ID;
										if($REPLIES->PARENT != 0) $perma = '?board='.$REPLIES->BOARD.'&amp;thread='.$REPLIES->PARENT.'#'.$REPLIES->ID;
										
										$postNo = '<span><i class="fa fa-angle-right"> No. <a href="'.$perma.'">'.$ID.'</a></i></span>';
										$thread_karma = '<span><i class="fa fa-heart"> '.intval($REPLIES->UP).'</i></span>';
										$reply_embed = '';
										if($URL != '' && $TYPE == 'image'){
											if($COMMENT != '')$imgclass = 'REPLY';
											if($COMMENT == '')$imgclass = 'OP';
											$reply_embed = '<a href="'.$URL.'"><img class="image'.$imgclass.'" alt="'.$URL.'" src="'.$URL.'"/></a>'; 
										}elseif($TYPE == 'video' && $URL != ''){ 
											if($profilevideo == 0){
												$reply_embed = '<iframe src="http://www.youtube.com/embed/'.$URL.'?loop=1&amp;playlist='.$URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" width="420" heigh="315" frameborder="0" allowfullscreen></iframe>'; 
											}elseif($profilevideo == 1){											
												$reply_embed = '<p><a href="http://youtube.com/watch?v='.$parentPosts->URL.'">Youtube Video Link</a></p>';
											}											
										}
										if(count($gotReply) > 0){
											echo '<span class="tinycreplies">'; foreach($gotReply as $replyid){ $replychild = intval($replyid->ID); $replyparent = intval($replyid->PARENT); $replyboard = strtolower($replyid->BOARD); 
											$reply_link = '?board='.$replyboard.'&amp;thread='.$replyparent.'&amp;'.$replychild.'#'.$replychild.'">'.$replychild; 
											echo '<i class="fa fa-reply"> <a href="'.$reply_link.'</i></a>'; } echo '</span>'; 
										}											
										echo '<div class="tinycomment below" id="'.$ID.'"><div class="meta">'.$SUBJECT.$postNo.$reply_attached_link.'</div>'.$reply_embed.$COMMENT.'
										<hr />
										<div class="approvalrating">'.$reply_approval_button.'<span class="tinykarma">'.intval($REPLIES->UP).'</span>'.$reply_disapproval_button.'</div>
										<div class="tinymeta"><!--reply_meta--></div>
										<div class="tinymeta"><span class="tinyname">'.$reply_name.'</span></div>
										<div class="tinymeta full"><span class="tinydate">'.$reply_date.'</span></div>
										</div>';																	
										echo '<div class="tinythread"><span class="tinysubject">For display purposes only.  Click <a href="'.$perma.'">here</a> to be taken to this thread.</span></div>';
									}
								}
							}
						}else{
							rb_404();
						}						
						echo '</div>';
					}else{
							
						rb_404();
					
				}
					
				}
			}
		
	
	if(get_option('mommaincontrol_regularboard') == 1)add_shortcode('regularboard','regularboard_shortcode');
	if(get_option('mommaincontrol_regularboard') == 1)add_filter('the_content','do_shortcode','regularboard_shortcode');
?>