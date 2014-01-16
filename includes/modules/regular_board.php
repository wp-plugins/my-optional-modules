<?php 
	if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	
	// Regular Board (build 05492751)

	function rb_style(){
		global $wp,$post;
		$content = $post->post_content;
		if( has_shortcode( $content, 'regularboard' )){
			$regbostyle = WP_PLUGIN_URL . '/my-optional-modules/includes/css/regularboard05492751.css';
			wp_register_style('regular_board',$regbostyle);
			wp_enqueue_style('regular_board');	
		}
	}
	add_action('wp_enqueue_scripts','rb_style');
	
	if(get_option('mommaincontrol_regularboard') == 1){
		function custom_sidebar() {
			$args = array(
				'id'            => 'regbo-sidebar',
				'name'          => __( 'Regular Board Sidebar', 'text_domain' ),
				'description'   => __( 'Appears in the sidebar of the Regular Board.', 'text_domain' ),
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
			);
			register_sidebar( $args );
		}
		// Hook into the 'widgets_init' action
		add_action( 'widgets_init', 'custom_sidebar' );
	}

	
	function rb_head($atts){
		global $wp,$post,$wpdb,$purifier;
		$regularboard_boards  = $wpdb->prefix.'regularboard_boards';
		$regularboard_posts   = $wpdb->prefix.'regularboard_posts';
		$content              = $post->post_content;
		if( has_shortcode( $content, 'regularboard' )){
	
			$BOARD             = '';
			if($_GET['board'] != '')$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']))));
			if($_GET['board'] == '')$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents($post->post_name)));
			if($BOARD != ''        )$THREAD = esc_sql(intval($_GET['thread']));

			if($BOARD != '' && $THREAD != 0){
				$getres = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' AND PARENT = 0 AND BOARD = '".$BOARD."' LIMIT 1");
			}
			elseif($BOARD != '' && $THREAD == 0){
				$getres = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '".$BOARD."' LIMIT 1");
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
					$site        = get_bloginfo('name');
					if($THREAD == 0){
						$author          =          $purifier->purify($site.' admin');
						$title           =          $purifier->purify($site);
						$description     =          $purifier->purify(strip_tags($meta->DESCRIPTION));
						
						$description     =			str_replace(array('||||','||','*','{{','}}','>>',' >','~~',' - ','----','::','`','    '),'',(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',$description)))))));
						$description     =          substr($description,0,150);
						echo "\n";
						if($author      != ''){echo '<meta property="og:author" content="'.$author.'" />           ';echo "\n";}
						if($title       != ''){echo '<meta property="og:title" content="'.$title.'" />             ';echo "\n";}
						if($site        != ''){echo '<meta property="og:site_name" content="'.$site.'" />          ';echo "\n";}
						if($locale      != ''){echo '<meta property="og:locale" content="'.$locale.'" />           ';echo "\n";}
						if($description != ''){echo '<meta property="og:description" content="'.$description.'" /> ';echo "\n";}
						echo '<meta property="og:type" content="website" />';echo "\n\n";
					}
					elseif($THREAD > 0){
						$THISPAGE          = home_url('/');
						$pretty = esc_attr(get_option('mommaincontrol_prettycanon'));

						if($pretty == 1){
							if($_GET['board'] != ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']))));
							if($_GET['board'] == ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents($post->post_name)));
							if($BOARD         != ''                    )$THREAD = esc_sql(intval($_GET['thread']));	
							if($BOARD         != '' && $THREAD != 0    ){$canonical = $THISPAGE.$BOARD.'/?thread='.$THREAD;}
							elseif($BOARD     != '' && $THREAD == 0    ){$canonical = $THISPAGE;}
						}else{
							if($_GET['board'] != ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']))));
							if($_GET['board'] == ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents($post->post_name)));
							if($BOARD         != ''                    )$THREAD = esc_sql(intval($_GET['thread']));	
							if($BOARD         != '' && $THREAD != 0    ){$canonical = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
						}
						$author          =          $purifier->purify($meta->MODERATOR);
						if($author      == 1)       $purifier->purify($author = $site.' admin');
						elseif($author  == 2)       $purifier->purify($author = $site.' moderator');
						elseif($author  == 0)       $purifier->purify($author = $site.' user');
						$title           =          $purifier->purify($meta->SUBJECT);
						if($title       == '')      $title = 'No subject';
						$title           =          str_replace('\\\\\\\'','\'',$title);
						$title           =          str_replace('\\\\\\','',$title);							
						$published       =          $purifier->purify($meta->DATE);
						$last            =          $purifier->purify($meta->LAST);
						$type            =          $purifier->purify($meta->TYPE);
						if($type        == 'image') $purifier->purify($image       = $meta->URL);
						if($type        == 'video') $purifier->purify($video       = $meta->URL);
						$description     =          $purifier->purify(strip_tags($meta->COMMENT));
						$description     =			str_replace(array('||||','||','*','{{','}}','>>',' >','~~',' - ','----','::','`','    '),'',(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',$description)))))));
						$description     =          substr($description,0,150);
						
						if($type        == 'video'){
								preg_match('/src="([^"]+)"/', $video, $match);
								$video = $match[1];
							}
						
						echo "\n";
						if($canonical   != ''){echo '<meta property="og:url" content="'.$canonical.'" />           ';echo "\n";}
						if($author      != ''){echo '<meta property="og:author" content="'.$author.'" />           ';echo "\n";}
						if($title       != ''){echo '<meta property="og:title" content="'.$title.'" />             ';echo "\n";}
						if($site        != ''){echo '<meta property="og:site_name" content="'.$site.'" />          ';echo "\n";}
						if($locale      != ''){echo '<meta property="og:locale" content="'.$locale.'" />           ';echo "\n";}
						if($published   != ''){echo '<meta property="og:published_time" content="'.$published.'" />';echo "\n";}
						if($published   != ''){echo '<meta property="og:modified_time" content="'.$published.'" /> ';echo "\n";}
						if($last        != ''){echo '<meta property="og:updated" content="'.$last.'" />            ';echo "\n";}
						if($image       != ''){echo '<meta property="og:image" content="'.$image.'" />             ';echo "\n";}
						if($video       != ''){echo '<meta property="og:video" content="'.$video.'" />             ';echo "\n";}
						if($description != ''){echo '<meta property="og:description" content="'.$description.'" /> ';echo "\n";}
						echo '<meta property="og:type" content="article" />';echo "\n\n";
					}
				}
			}
		}
	}	
	add_action('wp_head','rb_head');	





	function regularboard_shortcode($atts,$content = null){
		$wordpressname = get_bloginfo('name');
		extract(
			shortcode_atts(array(
				'sideopen'		  => '1',
				'boardheader'	  => '',
				'homelink'		  => '',
				'boards'		  => '',
				'bannedimg'       => '',
				'bannedmessage'   => 'YOU ARE BANNED',
				'board'           => '',
				'boardimage'      => '',
				'boardrules'      => '',
				'cutoff'          => '500',
				'defaultname'     => 'anonymous',
				'enableurl'       => '1',
				'enablerep'       => '1',
				'enablereports'   => '1',
				'enableemail'     => '1',
				'loggedonly'      => '',
				'lock'            => '',
				'maxbody'         => '1800',
				'maxreplies'      => '500',
				'maxtext'         => '75',
				'modcode'         => '##MOD',
				'noboard'         => 'Board does not exist',
				'nothreads'       => 'No threads to display',
				'nothreadsimg'    => '',
				'noboardimg'      => '',
				'postedimg'       => '',
				'postedmessage'   => 'POSTED!!!',
				'posting'         => '1',
				'requirelogged'   => '0',
				'style'           => 'imageboard',
				'showboards'      => '1',
				'threadsper'      => '15',
				'timebetween'     => '0',
				'trustedimg'      => '',
				'userflood'       => '',
				'usermodcode'     => '##JUNIORMOD',
				'usermod'         => '',
				'userjanitor'     => '',
				'untrusteddomain' => ''
			), $atts)
		);	
		
		global $purifier,$wpdb,$wp,$post,$ipaddress,$rand,$randnum1,$randnum2;
		
		// User role
		$current_user       = wp_get_current_user();
		$current_user_login = $current_user->user_login;
		if(current_user_can('manage_options'))$ISMODERATOR = true;
		if($usermod != ''){
			$usermods = explode(',',$usermod);
			if(in_array($current_user_login,$usermods))$ISUSERMOD = true;
		}
		if($userjanitor != ''){
			$userjanitors = explode(',',$userjanitor);
			if(in_array($current_user_login,$userjanitors))$ISUSERJANITOR = true;
		}
								   $ISUSER = true;
		if($ISMODERATOR   === true)$ISUSER = false;
		if($ISUSERMOD     === true)$ISUSER = false;
		if($ISUSERJANITOR === true)$ISUSER = false;

		// User IP address
		myoptionalmodules_checkdnsbl($checkThisIP);
		$theIP         = esc_sql(myoptionalmodules_sanistripents($ipaddress));
		$theIP_s32int  = esc_sql(myoptionalmodules_sanistripents(ip2long($ipaddress)));
		$theIP_us32str = esc_sql(myoptionalmodules_sanistripents(sprintf("%u",$theIP_s32int)));
		$checkThisIP   = esc_sql(myoptionalmodules_sanistripents($theIP));			
		
		// [shortcode] attributes
		$current_timestamp               = date('Y-m-d H:i:s');
		$boardrules                      = esc_url($boardrules);
		if($trustedimg != '')$trustedimg = explode(',',$trustedimg);
		$untrusteddomain                 = explode(',',$untrusteddomain);
		$requirelogged                   = intval($requirelogged);
		$showboards                      = intval($showboards);
		$maxreplies                      = intval($maxreplies);
		$enableemail                     = intval($enableemail);
		$sideopen					     = intval($sideopen);
		$enablereports                   = intval($enablereports);
		$dataadslot                      = $dataadslot;
		$style                           = $style;
		$lock                            = $lock;
		$board                           = $board;
		$loggedonly                      = $loggedonly;
		$nothreads                       = $nothreads;
		$noboard                         = $noboard;
		$defaultname                     = $defaultname;
		$bannedmessage                   = $bannedmessage;
		$postedmessage                   = $postedmessage;
		$modcode                         = $modcode;
		$usermodcode                     = $usermodcode;
		$userjanitorcode                 = $userjanitorcode;
		$nothreadsimg                    = $nothreadsimg;
		$noboardimg                      = $noboardimg;
		$bannedimg                       = $bannedimg;
		$postedimg                       = $postedimg;
		$boardimage                      = $boardimage;
		$regularboard_boards             = $wpdb->prefix.'regularboard_boards';
		$regularboard_posts              = $wpdb->prefix.'regularboard_posts';
		$regularboard_users              = $wpdb->prefix.'regularboard_users';
		$QUERY                           = esc_sql(myoptionalmodules_sanistripents($_SERVER['QUERY_STRING']));
		
		$blog_title = get_bloginfo();
		
		// [shortcode] queries
		if($boards == ''){
			$getBoards = $wpdb->get_results("SELECT * FROM $regularboard_boards ORDER BY NAME ASC");
		}
		
		if($boards != ''){
			$boards = explode(',',$boards);
			$boards = array_map('rb_apply_quotes',$boards);
			$getBoards = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME IN (".join(',',$boards).") ORDER BY NAME ASC");
		}
		if(isset($_POST['searchsub']) && $_REQUEST['boardsearch'] != ''){
			$SEARCH = esc_sql(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_REQUEST['boardsearch'])));
		}
			
		if($board == '')$BOARD = esc_sql(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board'])));
		if($board != '')$BOARD = $board;
		if($board != '')$BoardIsSet = true;
		if($loggedonly != ''){
			$loggedonly = array($loggedonly);
			foreach($loggedonly as $LOGGEDONLY){
				$LOGGEDONLY = explode(',',$LOGGEDONLY);
				if(in_array($BOARD,$LOGGEDONLY)){
					$requirelogged = 1;
				}
			}
		}
		if($lock != ''){
			$lock = array($lock);
			foreach($lock as $LOCK);
			$LOCK = explode(',',$LOCK);
			if(in_array($BOARD,$LOCK)){
				$posting = 0;
			}
		}
		$AREA          = esc_sql(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['area'])));
		$PROFILE          = esc_sql(myoptionalmodules_sanistripents(preg_replace("/[^0-9 ]/", '', $_GET['profile'])));
		$THREAD        = intval($_GET['thread']);
		$BOARD         = strtolower($BOARD);

		if($BOARD != ''){
			$getCurrentBoard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '".$BOARD."' LIMIT 1");
		}
		
		$AREA          = strtolower($AREA);
		$PROFILE       = intval($PROFILE);
		$THISPAGE      = get_permalink();
		$isSFW = 0;
		$isNSFW = 0;
		foreach($getBoards as $cboard){
			if($cboard->SHORTNAME == $BOARD){
				if($cboard->URL != '')$BOARDURL = $cboard->URL;
				if($cboard->SFW == 'SFW')$isSFW++;
				if($cboard->SFW == 'NSFW')$isNSFW++;
			}
			$BOARDRULES = $cboard->RULES;
			$BOARDRULES =  str_replace('\\r','<br />',$BOARDRULES);
			$BOARDRULES =  str_replace('\\n','<br />',$BOARDRULES);
		}
		if($isSFW == 1) $sfwnsfw = 'S F W';
		if($isNSFW == 1) $sfwnsfw = 'N S F W';
		if($isSFW == '' && $isNSFW == '') $sfwnsfw = 'S F W';

		if($BOARDURL != ''){
			if($BOARD != '' && $THREAD != '' && $ID == $THREAD)$ACTION = $THISPAGE;
			elseif($BOARD != '' && $THREAD == '')$ACTION = $THISPAGE;
			elseif($BOARD != '' && $THREAD != '')$ACTION = $THISPAGE.'?thread='.$THREAD;
		}else{
			if($BoardIsSet !== true){
				if($BOARD != '' && $THREAD != '' && $ID == $THREAD)$ACTION = $THISPAGE.'?board='.$BOARD;
				elseif($BOARD != '' && $THREAD == '')$ACTION = $THISPAGE.'?board='.$BOARD;
				elseif($BOARD != '' && $THREAD != '')$ACTION = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;
			}
			if($BoardIsSet === true){
				if($BOARD != '' && $THREAD != '' && $ID == $THREAD)$ACTION = $THISPAGE;
				elseif($BOARD != '' && $THREAD == '')$ACTION = $THISPAGE;
				elseif($BOARD != '' && $THREAD != '')$ACTION = $THISPAGE.'?thread='.$THREAD;
			}													
		}				
			
		if($ipaddress !== false){
			// Display the User's Karma to them
			$myinformation = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
			
			if($homelink == '')$homelink = home_url('/');
			if($homelink != '')$homelink = esc_url($homelink);
			
			echo '<div class="boardAll">';
			
			if(count($getCurrentBoard) > 0){
				foreach($getCurrentBoard as $thisBoardDesc){ 
					$BOARDDESC = $purifier->purify($thisBoardDesc->DESCRIPTION);
					$BOARDNAME = $purifier->purify($thisBoardDesc->NAME);
					echo '<div class="boardDescription"><h1>'.$BOARDNAME.'</h1><p>'.$BOARDDESC.'</p></div>';
				}
			}
			
			
			if(count($myinformation) > 0){foreach($myinformation as $myinfo){$mykarma = $myinfo->KARMA;echo '<span class="alert" id="mybar"><em><a href="'.$homelink.'"><i class="fa fa-home"></i></a></em> / <a href="?profile='.intval($myinfo->ID).'"><i class="fa fa-user"> <em>My Stats</em></i></a> ( <em class="karma"><i class="fa fa-heart"> '.$mykarma.' </i></em> )</span>';}}
			echo '<div class="boardheader">';
			if($boardheader != '')echo '<img src="'.$boardheader.'" alt="'.$boardheader.'" />';
			echo '</div>';
			echo '<div class="logoContainer">';
			if($boardimage != '')echo '<img src="'.esc_url($boardimage).'" class="skipLazy logo" alt="Logo" />';
			echo '</div>';
			echo '<div class="boardnav">';
			if($showboards == 1){
				echo '<span class="left button">Boards</span>';
				if(count($getBoards) > 0){
					foreach($getBoards as $gotBoards){
						$BOARDNAME = esc_sql(myoptionalmodules_sanistripents($gotBoards->SHORTNAME));
						$BOARDLONG = esc_sql(myoptionalmodules_sanistripents($gotBoards->NAME));
						$BOARDDESC = esc_sql(myoptionalmodules_sanistripents($gotBoards->DESCRIPTION));
						$BOARDURL = esc_sql(myoptionalmodules_sanistripents($gotBoards->URL));
						$getBoardPostsTopics = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."' ORDER BY ID DESC LIMIT 1");
						if($BOARDURL != ''){
							echo '<a href="'.$BOARDURL.'/">'.$BOARDLONG;
						}elseif($BOARDURL == ''){
							echo '<a href="?board='.$BOARDNAME.'">'.$BOARDLONG;
						}
						echo '</a>';
					}
				}
			}
			echo '</div>';
			
			
			echo '
			<div class="boardInformation">';
			// Search form
			
				echo '<form name="regularboardsearch" id="regularboardsearch" method="post" action="'.$ACTION.'">';wp_nonce_field('regularboardsearch');echo '<input type="text" name="boardsearch" id="boardsearch" placeholder="Search '.$BOARD.' for..." /><input type="submit" class="hidden" id="searchsub" name="searchsub" value="Search" /></form>';
			
			// Display Board activity
			if($showboards == 1){
				if(count($getBoards) > 0){
					foreach($getBoards as $gotBoards){
						$BOARDNAME = esc_sql(myoptionalmodules_sanistripents($gotBoards->SHORTNAME));
						$BOARDLONG = esc_sql(myoptionalmodules_sanistripents($gotBoards->NAME));
						$BOARDDESC = esc_sql(myoptionalmodules_sanistripents($gotBoards->DESCRIPTION));
						$BOARDURL = esc_sql(myoptionalmodules_sanistripents($gotBoards->URL));
						$getBoardPostsTopics = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."' ORDER BY ID DESC LIMIT 1");
						echo '<section class="infolink">';
						if($BOARDURL != ''){
							echo '<a href="'.$BOARDURL.'/">'.$BOARDLONG.' ( '.$gotBoards->SFW.' )<br />';
						}elseif($BOARDURL == ''){
							echo '<a href="?board='.$BOARDNAME.'">'.$BOARDLONG.' ( '.$gotBoards->SFW.' )<br />';
						}
						foreach($getBoardPostsTopics as $posts){
							$DATE = $posts->DATE;$DATE = timesincethis($DATE);echo $DATE;
						}
						echo '</a></section>';
					}
				}
			}

			echo '<section class="infolink"><a href="?area=stats">stats</a></section>';
			if($boardrules != '')echo '<section class="infolink"><a href="'.$boardrules.'">rules</a></section>';
			if($ISMODERATOR === true)echo '<section class="infolink"><a href="?area=create">admin</a></section>';
			if($ISMODERATOR === true)$posting = 1;
			// Delete/report form for threads and replies
				
				echo '<hr />';
				if($BOARD != '' && $BOARD != '_front'){
					if($enableurl == 1 || $enablerep == 1){
						if($trustedimg != ''){
							$trstd = 0;
							foreach($trustedimg as $trusted){$trstd++; echo '<section class="infolink">Trusted image host #'.$trstd.': <a href="'.esc_url('http://'.$trusted).'">'.$trusted.'</a></section>';}
						}
					}
					if($BOARDRULES != ''){ echo '<section class="infolink">'.$BOARDRULES.'</section>'; }
					
					echo '<hr />';
				}
				
				
				if ( dynamic_sidebar('Regular Board Sidebar') );

				
				if($ISUSER === true){
					echo '
					<div class="reportdelete">
					<i class="fa fa-user"> User Controls</i><br />
					<form name="reporttomods" method="post" action="'.$ACTION.'">';
					wp_nonce_field('reporttomods');
					echo '
					<section class="full"><input type="text" name="report_ids" id="report_ids" value="" placeholder="Post No." /></section>
					<section class="full"><input type="text" name="report_reason" value="" placeholder="Reason (if reporting)" /></section>
					<section class="full"><input type="password" name="DELETEPASSWORD" id="DELETEPASSWORD" value="'.$rand.'" /></section>
					<label title="Edit (password required)" for="edit_this"><i class="fa fa-pencil"></i></label>
					<label title="Report" for="report_this"><i class="fa fa-warning"></i></label>
					<label title="Delete (password required)" for="delete_this"><i class="fa fa-trash-o"></i></label>
					<input type="submit" name="edit_this" value="edit" id="edit_this" class="hidden" />
					<input type="submit" name="report_this" value="report" id="report_this" class="hidden" />
					<input type="submit" name="delete_this" value="delete" id="delete_this" class="hidden" />
					</form>
					</div>';
				}
				
			if(current_user_can('manage_options') || $ISUSERMOD === true || $ISUSERJANITOR === true){
				echo '<div class="modactions">';
				echo '
				<i class="fa fa-user"> Board Moderation Controls</i><br />
				<form name="moderator" method="post" action="'.$ACTION.'">';
				wp_nonce_field('moderator');
				echo '
				<section class="full"><input type="text" name="admin_ids" value="" placeholder="Post No." /></section>
				<section class="full">';
				if($ISUSERMOD === true || current_user_can('manage_options')){
					echo '
					<input type="text" name="admin_reason" value="" placeholder="Reason4ban shortname4move" />
					<input type="text" name="admin_length" value="" placeholder="Length of ban (0 for forever)" /></section>
					<label class="submit" title="Edit" for="admin_edit"><i class="fa fa-pencil"></i></label>
					<label class="submit" title="Move" for="admin_move"><i class="fa fa-repeat"></i></label>
					<label class="submit" title="Make sticky" for="admin_sticky"><i class="fa fa-thumb-tack"></i></label>
					<label class="submit" title="Lock thread" for="admin_lock"><i class="fa fa-lock"></i></label>
					<label class="submit" title="Unsticky" for="admin_unsticky"><i class="fa fa-ban"></i><i class="fa fa-thumb-tack absolute"></i></label>
					<label class="submit" title="Unlock thread" for="admin_unlock"><i class="fa fa-ban"></i><i class="fa fa-lock absolute"></i></label>
					<label class="submit" title="Ban" for="admin_ban"><i class="fa fa-ban"></i></label>
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
				</form>
				';
				echo '</div>';
				
				// Admin Form Handling
					if(current_user_can('manage_options') || $ISUSERMOD === true || $ISUSERJANITOR === true){
						$ID2SET = $_REQUEST['admin_ids'];
						if(current_user_can('manage_options') || $ISUSERMOD === true){
							if(isset($_POST['admin_lock']) && $ID2SET != '')$doLock = $wpdb->update($regularboard_posts,array('LOCKED' => 1),array('ID' => $ID2SET),array('%d'));
							if(isset($_POST['admin_unlock']) && $ID2SET != '')$doUnlock = $wpdb->update($regularboard_posts, array('LOCKED' => 0), array('ID' => $ID2SET),array('%d'));
							if(isset($_POST['admin_sticky']) && $ID2SET != '')$doSticky = $wpdb->update($regularboard_posts,array('STICKY' => 1), array('ID' => $ID2SET),array('%d'));
							if(isset($_POST['admin_unsticky']) && $ID2SET != '')$doUnsticky = $wpdb->update($regularboard_posts,array('STICKY' => 0), array('ID' => $ID2SET),array('%d'));	
						}
						if(isset($_POST['admin_delete']) && $ID2SET != ''){
							$getIDfromID = $wpdb->get_results("SELECT PARENT FROM $regularboard_posts WHERE ID = $ID2SET LIMIT 1");
							if(current_user_can('manage_options')){
								$wpdb->delete($regularboard_posts, array('ID' => $ID2SET),array('%d'));
								foreach($getIDfromID as $parentCheck){
									$parent = $parentCheck->PARENT;
									if($PARENT == 0){
										$wpdb->delete($regularboard_posts,array('PARENT' => $ID2SET),array('%d'));
									}
								}
							}
							if($ISUSERMOD === true || $ISUSERJANITOR === true){
								$wpdb->delete($regularboard_posts,array('ID' => $ID2SET,'MODERATOR' => 0),array('%d'));
								foreach($getIDfromID as $parentCheck){
									$parent = $parentCheck->PARENT;
									if($PARENT == 0){
										$wpdb->delete($regularboard_posts,array('PARENT' => $ID2SET),array('%d'));
									}
								}										
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
											( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA ) 
											VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d )",
											'',
											$current_timestamp,
											$IP,
											$ID2SET,
											$PARENT,
											$BOARD,
											1,
											$MESSAGE,
											$LENGTH,
											0
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
											( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA ) 
											VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d )",
											'',
											$current_timestamp,
											$IP,
											$ID2SET,
											$PARENT,
											$BOARD,
											1,
											$MESSAGE,
											$LENGTH,
											0
										)
									);		
								}
							}
						}
				}
				
			}

		echo '</div>
		<div class="boardDisplay">';

			
			
			if($PROFILE != ''){
				$reviews_table = $wpdb->prefix.'momreviews';
				$profileid = intval($PROFILE);
				$usprofile = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE ID = $profileid AND BANNED = 8 LIMIT 1");
				$ktrophies  = $wpdb->get_results("SELECT * FROM $reviews_table WHERE TYPE = 'karma' OR type='activeposts'");
				if(count($usprofile) > 0){
					foreach($usprofile as $theprofile){
						
						$userip    = intval($theprofile->IP);
						$count = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = $userip ORDER BY UP DESC LIMIT 10");
						$posts  = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = $userip");
						$images = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = $userip AND TYPE = 'image' ORDER BY UP DESC, DATE DESC LIMIT 10");
						$postcount = count($posts);
						$userid    = intval($theprofile->ID);
						$userkarma = intval($theprofile->KARMA);
						echo '<div><div class="boardposts"><div class="op">';
						echo '<div class="commentMeta">';
						echo '<span><i class="fa fa-heart karma"> '.$userkarma.'</i></span>';
						echo '<span><i class="fa fa-clock-o"> First seen '.timesincethis($theprofile->DATE).'</i></span>';
						echo '<span><i class="fa fa-volume-up"> Active posts: '.$postcount.'</i></span>';
						echo '</div><div id="omitted">';
						 if(count($images) > 0 || count($count) > 0){
							
							$img = 0;
							foreach($images as $imgcount){if($imgcount->TYPE == 'image')$img++;}
							echo '<div class="commentREPLYuser"><div style="width:'.($img * 250).'px">';
							foreach($images as $thisuserimages){
								$board            =  $thisuserimages->BOARD;
								$id               =  $thisuserimages->ID;
								$parent           =  '';
								if($thisuserimages->PARENT > 0)$parent = $thisuserimages->PARENT;
								if($thisuserimages->PARENT  > 0)$parent = 'thread='.$parent.'#'.$id;
								if($thisuserimages->PARENT == 0)$parent = 'thread='.$id;									
								$bl               =  $wpdb->get_results("SELECT URL FROM $regularboard_boards WHERE SHORTNAME = '".$board."' LIMIT 1");
								foreach($bl as $boardlink){
									$boardurl         =  $boardlink->URL;
								}								
								if($boardurl == ''){
									if($BoardIsSet !== true){$link = $THISPAGE.'?board='.$board.'&amp;'.$parent;}
									if($BoardIsSet === true){$link = $THISPAGE.'?'.$parent;}
								}else{
									$link = $boardurl.'/?'.$parent;
								}
								if($img <= 10){
									if($thisuserimages->TYPE == 'image' && $thisuserimages->URL != ''){
										echo '<a href="'.$link.'"><img src="'.$thisuserimages->URL.'" class="imageREPLY" /></a>';
									}
								}
							}
							
							echo '</div></div>';
							
							echo '<div id="trophycase" class="reply"><div class="replycontent">
							<div class="commentREPLY"><blockquote>';
							echo '<h1><i class="fa fa-trophy gold"> Milestones</i></h1>';
							
							$dust = 0;
							foreach($ktrophies as $k){
								$rating = $k->RATING;
								if($rating >= $userkarma){
									$dust++;
									$achievement =  $k->REVIEW;
									$achievement =  str_replace('<p>','',$achievement);
									$achievement =  str_replace('</p>','',$achievement);
									echo '<div class="trophy"><em class="title">'.$k->TITLE.'</em><br />'.$achievement.'</div>';
								}
								if($rating >= $postcount){
									$dust++;
									$achievement =  $k->REVIEW;
									$achievement =  str_replace('<p>','',$achievement);
									$achievement =  str_replace('</p>','',$achievement);										
									echo '<div class="trophy"><em class="title">'.$k->TITLE.'</em><br />'.$achievement.'</div>';
								}									
							}
							if($dust == 0)echo '<i class="fa fa-meh-o karma"> Nothing here but dust.</i>';
							if($dust  > 0)echo '<i class="fa fa-smile-o karma"> '.$dust.' milestones have been reached!</i>';
							echo '</blockquote></div></div></div>';
							
							$postc = 0;
							foreach($count as $thisuserposts){
								if(intval($thisuserposts->UP) >= 1){
									$postc++;
									if($postc <= 10){
										echo '<div id="'.intval($thisuserposts->ID).'" class="reply '.intval($thisuserposts->ID).'">';
										echo '<div class="replycontent">';
										$board            =  $thisuserposts->BOARD;
										$id               =  $thisuserposts->ID;
										$parent           =  '';
										$bl               =  $wpdb->get_results("SELECT URL FROM $regularboard_boards WHERE SHORTNAME = '".$board."' LIMIT 1");
										foreach($bl as $boardlink){
											$boardurl         =  $boardlink->URL;
										}
										if($thisuserposts->PARENT != 0)$parent = $thisuserposts->PARENT;
										if($thisuserposts->PARENT  > 0)$parent = 'thread='.$parent.'#'.$id;
										if($thisuserposts->PARENT == 0)$parent = 'thread='.$id;
										
										if($boardurl == ''){
											if($BoardIsSet !== true){$link = $THISPAGE.'?board='.$board.'&amp;'.$parent;}
											if($BoardIsSet === true){$link = $THISPAGE.'?'.$parent;}
										}else{
											$link = $boardurl.'/?'.$parent;
										}
										$SUBJECT          =  rb_format($thisuserposts->SUBJECT);
										$SUBJECT          =  str_replace('\\\\\\\'','\'',$SUBJECT);
										$SUBJECT          =  str_replace('\\\\\\','',$SUBJECT);									
										$SUBJECT          =  str_replace('\\r','<br />',$SUBJECT);
										$SUBJECT          =  str_replace('\\n','<br />',$SUBJECT);
										echo '<div class="commentREPLY"><blockquote class="topten">';
										echo ''.$postc.' > <a href="'.$link.'">';
										if($SUBJECT != ''){echo $SUBJECT;}else{echo 'No subject specified';}
										echo '</a><br />This ';if($thisuserposts->PARENT == 0){echo 'thread';}else{echo 'comment';}echo ' received '.intval($thisuserposts->UP).' <i class="fa fa-heart"></i>s.</blockquote></div>';
										echo '</div></div>';
									}
								}
							}
						 }
						echo '</div></div></div></div>';
						
					}
				}else{
					//echo '<meta http-equiv="refresh" content="0;URL='.$THISPAGE.'">';
				}
				
			
			}elseif($AREA == 'stats'){
			
				echo '<div class="boardlist"><div class="op">
				<span class="subject"><em>Stats for '.get_bloginfo('site_name').'</em></span>';
				echo '<div class="commentMeta"><span><i class="fa fa-exclamation"> Counts active (non-deleted) content only.</i></span></div>';
				echo '<div class="commentContainer commentOP">';
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
				</tr>';					
					foreach($getBoards as $gotBoards){
					echo '<tr valign="top">';
						$BOARDNAME = esc_sql(myoptionalmodules_sanistripents($gotBoards->SHORTNAME));
						$BOARDLONG = esc_sql(myoptionalmodules_sanistripents($gotBoards->NAME));
						$BOARDURL  = esc_url(myoptionalmodules_sanistripents($gotBoards->URL)); 
						$countPosts  = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."'");
						$min10_t   = 0;
						$hou02_t   = 0;
						$hou12_t   = 0;
						$hou24_t   = 0;
						$count     = 0;
						$mod       = 0;
						$usr       = 0;
						$urls      = 0;
						$vids      = 0;
						$imgs      = 0;
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
							if($type == 'image')$imgs++;
							if($type == 'video')$vids++;
							if($type == 'url')$urls++;
							if($counted->IP == $theIP_us32str)$iposted++;
							$count++;

						}
						
						if($BOARDURL != '')echo '<td><a href="'.$BOARDURL.'/">'.$BOARDNAME.'</a></td>';
						if($BOARDURL == '')echo '<td><a href="?board='.$BOARDNAME.'">'.$BOARDNAME.'</a></td>';
						
						echo '
						<td>'.$min10_t.'</td>
						<td>'.$hou02_t.'</td>
						<td>'.$hou12_t.'</td>
						<td>'.$hou24_t.'</td>
						<td>'.$count.'</td>
						<td>'.$mod.'</td>
						<td>'.$usr.'</td>';
						
					echo '</tr>';
					
					}
				}
				$countall  = $wpdb->get_results("SELECT * FROM $regularboard_posts");
				$countips  = $wpdb->get_results("SELECT Distinct IP FROM $regularboard_posts");
				$allCounted = 0;
				$ipCounted = 0;
				$mods = 0;
				$usrs = 0;
				$myPosts = 0;
				foreach($countall as $countAll){
					if($countAll->IP == $theIP_us32str)$myPosts++;
					$allCounted++;
					$moderator = $countAll->MODERATOR;
					if($moderator >  0)$mods++;
					if($moderator == 0)$usrs++;
				}
				foreach($countips as $countIPS){$ipCounted++;}
				$modratio = round(($mods / $allCounted) * 100);
				$usrratio = round(($usrs / $allCounted) * 100);
				echo '
				</table>
				<table class="stats">
				<tr valign="top"><td>All threads and replies</td></tr>
				<tr valign="top">
				<td>Total posts</td>
				<td>Total users</td>
				<td>Mods</td>
				<td>Users</td>
				</tr>
				<tr valign="top">
				<td>'.$allCounted.'</td>
				<td>'.$ipCounted.'</td>
				<td>'.$modratio.'%</td>
				<td>'.$usrratio.'%</td>
				</tr>
				</table>
				<table class="stats"><tr valign="top"><td>%s</td></tr>';
				
				if(count($getBoards) > 0){
					foreach($getBoards as $gotBoards){
					echo '<tr valign="top">';
						$BOARDNAME = esc_sql(myoptionalmodules_sanistripents($gotBoards->SHORTNAME));
						$BOARDLONG = esc_sql(myoptionalmodules_sanistripents($gotBoards->NAME));
						$BOARDURL  = esc_url(myoptionalmodules_sanistripents($gotBoards->URL)); 
						$countPosts  = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."' AND PARENT = '0'");
						$countReplies  = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."' AND PARENT != '0'");
						$modt       = 0;
						$usrt       = 0;
						$countt = count($countPosts)+count($countReplies);
						$countt = round(($countt / $allCounted) * 100);
						
						if($BOARDURL != '')echo '<td><a href="'.$BOARDURL.'/">'.$BOARDNAME.'</a></td>';
						if($BOARDURL == '')echo '<td><a href="?board='.$BOARDNAME.'">'.$BOARDNAME.'</a></td>';
						
						echo '
						<td style="width:100%"><span style="height:20px;background-color:#000;width:100%;display:block"><span style="height:100%;background-color:#fff;width:'.$countt.'%;display:block;"></span></span></td>
						<td>'.$countt.'%</td>';
						
					echo '</tr>';
					}
				}
				
				
				echo '</table>
				<table class="stats">';
					if($myPosts >  0) $contributions = round(($allCounted / $myPosts) * 100);
					if($myPosts == 0) $contributions = 0;
					echo '
					<tr valign="top"><td>We see you as <code>'.$checkThisIP.'</code>.  Your contributions account for '.$contributions.'% of this content.</td></tr></table>';
					
					echo '</div></div>';
			
			

			
			}elseif($AREA == 'create'){
				if($ISMODERATOR === true){
					$getUsers = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 1");
					$getReports = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE BANNED = 3");
					$grabAll = $wpdb->get_results("SELECT * FROM $regularboard_posts");
					

					echo '<div class="mainboard boardposts"><div class="op"><span class="subject">Board Moderation</span>';

					// Force update tables
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
						$wpdb->query("ALTER TABLE $regularboard_boards ADD URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER RULES");
						$wpdb->query("ALTER TABLE $regularboard_boards ADD SFW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER URL");
						echo '<hr />
						<em><strong>Tables updated!</strong></em>';
					}else{
						echo '
						<hr />
						<form method="post" class="topic threadform" >
						<label for="UPGRADE" class="full submit">Click HERE to Force update tables (if new installation or upgrading)</label>
						<input type="submit" name="UPGRADE" id="UPGRADE" value="An upgrade is necessary." class="hidden" />
						</form>
						';
					}
					

					echo '
					<hr />
					Create a new board (or edit an existing one by using the <strong>shortname</strong> of a board that already exists)
					<form method="post" id="COMMENTFORM" class="topic threadform" name="createaboard" action="?area=create">';
					wp_nonce_field('createaboard');
					echo '
					<section class="small"><input type="text" name="SHORTNAME" id="SHORTNAME" placeholder="Shortname" /></section>
					<section class="small"><input type="text" name="NAME" id="NAME" placeholder="Expanded board name" /></section>
					<section class="small"><input type="text" name="DESCRIPTION" id="DESCRIPTION" placeholder="Short description" /></section>
					<section class="small"><input type="text" name="URL" id="URL" placeholder="Board URL (OPTIONAL)" /></section>
					<section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board (HTML allowed)"></textarea></section>
					<section class="full"><select class="full" name="SFW" id="SFW"><option value="SFW">Safe-for-work (NSFW not allowed)</option><option value="NSFW">Not-Safe-For-Work</option></select></section>
					<section class="full"><label class="submit full" for="CREATEBOARD">Create this board</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Create this board" /></section>
					</form>
					<hr />
					';
					
					echo '<p><i class="fa fa-warning"></i> Nuking a board deletes all threads associated with that board.  Use with caution.</p>';
					if(count($getBoards) > 0){
							echo '<p>
							<form method="post" class="create" name="deleteaboard" action="?area=create">';
							wp_nonce_field('deleteaboard');
							echo '
							<select name="DELETETHIS" id="DELETETHIS">';
							foreach($getBoards as $gotBoard){
								$board = esc_sql($gotBoard->SHORTNAME);
								$name  = esc_sql($gotBoard->NAME);
								echo '
								<option value="'.$board.'">/'.$board.'/ - '.$name.'</option>';
							}
							echo '
							</select>
							<input type="submit" name="DELETEBOARD" id="DELETEBOARD" value="Nuke" />
							</form></p><hr />';
					}						
					
					// Reported threads
					echo '<p><strong>Reports</strong>: Dismiss to delete report, Delete to delete the thread/reply <strong>and</strong> report.</p>';
					echo '<form name="reports" action="?area=create" class="create" method="post">';
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
								//echo '<meta http-equiv="refresh" content="0;URL=?area=create">';
							}
							if(isset($_POST['delete'.$thisID])){
								if($thisParent == 0){
									$wpdb->delete( ''.$regularboard_posts.'', array('PARENT' => ''.$thisID.''),array( '%d') );
								}
								$wpdb->delete( ''.$regularboard_posts.'', array('ID' => ''.$thisID.''),array( '%d' ) );
								$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$thisID.''),array( '%d' ) );
								//echo '<meta http-equiv="refresh" content="0;URL=?area=create">';
							}							
						}
					}else{
						echo '<p><em>Nothing to see here!</em></p>';
					}
					echo '</form><hr />
					<p><strong>Bans</strong> Unban banned IPs here.  Probably best to leave them here.</p>
					<form name="unban" action="?area=create" class="create" method="post">
					';
					wp_nonce_field('unban');
					if(count($getUsers) > 0){
						foreach($getUsers as $gotUsers){
							$userIP = long2ip($gotUsers->IP);
							$thisID = intval($gotUsers->ID);
							$userMESSAGE = $gotUsers->MESSAGE;
							echo '<p>';
							echo '<strong>Ban ID: '.$thisID.'</strong> &mdash; Banned for ';
							if($userMESSAGE != '')echo '<span>'.$userMESSAGE.'</span>';
							if($userMESSAGE == '')echo '<span>No ban reason given.</span>';
							echo ' &mdash; <label for="unban'.$thisID.'">[ >> Unban '.$userIP.' ]</label>';
							echo '<input class="hidden" type="submit" name="unban'.$thisID.'" id="unban'.$thisID.'" />';
							echo '';
							if(isset($_POST['unban'.$thisID])){
								$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$thisID.'','BANNED' => '1'),array( '%d','%d') );
								//echo '<meta http-equiv="refresh" content="0;URL=?area=create">';
							}
							echo '</p>';
						}
					}else{
						echo '<p><em>No bans (yet) - great!</em></p>';
					}
					echo '</form><hr />';


					if(isset($_POST['DELETEBOARD']) && $_REQUEST['DELETETHIS'] != '' ){
							$DELETETHIS = esc_sql(myoptionalmodules_sanistripents($_REQUEST['DELETETHIS']));
							$wpdb->delete( ''.$regularboard_posts.'', array('BOARD' => ''.$DELETETHIS.''),array( '%s') );
							$wpdb->delete( ''.$regularboard_boards.'', array('SHORTNAME' => ''.$DELETETHIS.''),array( '%s') );
							//echo '<meta http-equiv="refresh" content="0;URL=?area=create">';
					}
					echo '	
					
					</div>';
					if(isset($_POST['CREATEBOARD']) && $_REQUEST['NAME'] != '' && $_REQUEST['SHORTNAME'] != ''){
						$NAME = myoptionalmodules_sanistripents($_REQUEST['NAME']);
						$SHORTNAME = esc_sql(myoptionalmodules_sanistripents(strtolower($_REQUEST['SHORTNAME'])));
						$DESCRIPTION = esc_sql($purifier->purify($_REQUEST['DESCRIPTION']));
						$RULES = esc_sql($purifier->purify(wpautop($_REQUEST['RULES'])));
						$SFW = esc_sql($purifier->purify($_REQUEST['SFW']));
						$URL = esc_url($_REQUEST['URL']);
						$getBoards = $wpdb->get_results("SELECT SHORTNAME FROM $regularboard_boards WHERE SHORTNAME = '$SHORTNAME'");
						if(count($getBoards) == 0){
							$wpdb->query( 
								$wpdb->prepare(
									"INSERT INTO $regularboard_boards 
									( NAME, SHORTNAME, DESCRIPTION, RULES, URL, SFW ) 
									VALUES ( %s, %s, %s, %s, %s, %s )",
										$NAME,
										$SHORTNAME,
										$DESCRIPTION,
										$RULES,
										$URL,
										$SFW
									)
							);								
						}else{
							$wpdb->delete( ''.$regularboard_boards.'', array('SHORTNAME' => ''.$SHORTNAME.''),array( '%s') );							
							$wpdb->query( 
								$wpdb->prepare(
									"INSERT INTO $regularboard_boards 
									( NAME, SHORTNAME, DESCRIPTION, RULES, URL, SFW ) 
									VALUES ( %s, %s, %s, %s, %s, %s )",
										$NAME,
										$SHORTNAME,
										$DESCRIPTION,
										$RULES,
										$URL,
										$SFW
									)
							);								
						}
					}
					echo '
					</div>
					</div>';
				}
			}
		



		// Board view
		elseif($BOARD != '' && $BOARD != '_front'){
			// Get Results
			$getBoards = $wpdb->get_results("SELECT * FROM $regularboard_boards ORDER BY SHORTNAME ASC");
			$getUser = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = 1 LIMIT 1");
			$getLastPost = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE IP = '".$theIP_us32str."' ORDER BY ID DESC LIMIT 1");
			
			if($THREAD == ''){
				$postsperpage = intval($threadsper);
				if($BoardIsSet !== true) $targetpage = '?board='.$BOARD;
				if($BoardIsSet === true) $targetpage = get_permalink();
				$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0");
				$totalpages = count($countpages);
				$results = mysql_escape_string($_GET['results']);
				if($results){$start = ($results - 1) * $postsperpage;}else{$start = 0;}
				if($SEARCH == '')$getParentPosts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0 ORDER BY STICKY DESC, UP DESC, LAST DESC LIMIT $start,$postsperpage");
				if($SEARCH != '')$getParentPosts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ( EMAIL = '".$SEARCH."' OR COMMENT LIKE '%".$SEARCH."%' OR SUBJECT LIKE '%".$SEARCH."%' OR URL LIKE '%".$SEARCH."%' ) AND BOARD = '".$BOARD."' ORDER BY ID");
			}
			
			if($THREAD != ''){
				$getParentPosts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND ID = '".$THREAD."' AND PARENT = 0 LIMIT 1");
				$countParentReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = '".$THREAD."'");
				$THREADREPLIES = $THREADIMGS = 0;
			}
			
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
					}						
					else{
						$time = $lastPost->DATE;
						$postedOn = strtotime($time);
						$currently = strtotime($current_timestamp);
						$timegate = $currently - $postedOn;
						if($timegate < $timebetween){
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
				if($BoardIsSet !== true)if($BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD;}
				if($BoardIsSet === true)if($BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE;}
				if($BoardIsSet !== true)if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
				if($BoardIsSet === true)if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?thread='.$THREAD;}
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
						echo '<h3>YOU ARE NOT LOGGED IN.</h3>';
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
									$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1',' being blacklisted by the DNSBL.','0','0')");
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
										echo '<div class="mainboard boardposts"><div class="op">';
										echo '<span class="subject">'.$purifier->purify($bannedmessage).'</span><div class="commentMeta">';
										if($bannedimg != '')echo '<img class="imageOP" src="'.$bannedimg.'" />';
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
													if($BOARDURL   != ''   )if($BOARD != '' && $THREAD == ''){$WebsiteURL = $BOARDURL.'/';}
													if($BOARDURL   != ''   )if($BOARD != '' && $THREAD != ''){$WebsiteURL = $BOARDURL.'/?thread='.$THREAD;}
													if($BoardIsSet !== true)if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD;}
													if($BoardIsSet === true)if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE;}
													if($BoardIsSet !== true)if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
													if($BoardIsSet === true)if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?thread='.$THREAD;}
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
												if($_REQUEST['COMMENT'] == '' && $_REQUEST['URL'] == '') {
													echo '<div><div class="boardposts"><div class="op"><span class="subject">Can\'t submit an empty comment or URL.  Go back and fill one of those out.</span>';
													echo '</div></div></div>';
												}elseif($_REQUEST['LINK'] != '' || $_REQUEST['PAGE'] != '' || $_REQUEST['LOGIN'] != '' || $_REQUEST['USERNAME'] != ''){
													$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1','filling out hidden form areas (likely bot).','0','0')");
												}elseif($IS_IT_SPAM == 1){
													$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1','Akismet detected you as SPAM.','0','0')");
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
															$enteredCOMMENT    = regularboard_html_cut(strip_tags(esc_sql(wpautop($_REQUEST['COMMENT']))),$maxbody);
															$enteredCOMMENT    = str_replace(array('<p>','</p>'),'||',(str_replace(array('\\n','\\t','\\r'),'||',$enteredCOMMENT)));
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
																$checkUserExists = $wpdb->get_results("SELECT ID FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
																if(count($checkUserExists) == 0){
																	$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','0','0','8','Karma count','','0')");
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
																	$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','0','0','5','unoriginal','10 minutes','')");
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
													if($BoardIsSet !== true)if($BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$IDGOTO;}
													if($BoardIsSet === true)if($BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?thread='.$IDGOTO;}
												}
												
												if($BoardIsSet !== true)if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
												if($BoardIsSet === true)if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?thread='.$THREAD;}
												
												if($edited == 0 || $edited == 1 || $timegateactive !== true){
													
													echo '<span class="postedMessage">';
													if($edited == 1){ echo 'Edited successfully!'; }
													elseif($duplicate_found === true){echo 'Duplicate found  -  Post discarded.';}
													else{echo esc_attr($postedmessage);}
													echo '</span>';
													
													if($edited == 1){
														echo '
														<p>Automatically forwarding you to your edited <a href="'.$REDIRECTO.'">post</a>.</p>
														<hr />';
														echo '<meta http-equiv="refresh" content="3;URL= '.esc_url($REDIRECTO).'">';
													}elseif($duplicate_found === true){
														echo '
														<p>To view the found duplicate content, you may click <a href="'.$REDIRECTO.'">here</a>.  Otherwise, please go back and correct your post.  You have '.$mutecount.' more attempts before Auto-Mute is enabled.  Once Auto-Mute is enabled, you will not be able to interact with these boards for 10 minutes.</p>
														<hr />
														<p class="information"><i class="fa fa-warning"></i> As part of this board\'s Auto-Mute feature, content that has already been submitted may not be submitted again.  
														What this means is that you can not submit the exact same content more than once.  Any IP address that attempts 
														to do this more than 5 times will be temporarily banned from using this board for 10 minutes.</p>
														<p class="information"><i class="fa fa-question"></i> The simplest way that you can avoid these temporary bans by submitting thought provoking and <strong>original</strong> content and links,
														instead of submitting things that have already been submitted before.  There <strong>is</strong> a search function to browse the board via keywords.  Perhaps searching for your 
														content before submitting it will aid you in the future.</p>';
													}else{
														if($isnew == 0){
															if($postedimg != ''){echo '<img class="infoimg" src="'.$postedimg.'" />';}
															if(count($checkUserExists) == 0){
																echo '
																<p>You\'ve just your first post.  Click <a href="'.$REDIRECTO.'">here</a> to be taken to it.</p>
																<hr />';
																echo '<p class="information"><i class="fa fa-thumbs-up"></i> Posts and replies can be Approved of (or Disapproved) - which will add (or detract) from your overall Approval rating on this site.
																Ratings are tracked by IP address alone - posting from different IP addresses will obviously mean different Approval ratings for each of your posts.</p>
																<p class="information"><i class="fa fa-user"></i> We use your IP address to identify you, for the purposes of user stats, and for the purposes of board moderation.  Your IP address is never made 
																publicly available.  All users are <em>anonymous</em> (in the sense that there are no names attached to their posts).</p>
																<p class="information"><i class="fa fa-terminal"></i> Did you know that you can format your comments using special code?  Surrounding a word with *s, like *this*, will result in an <em>italicized</em> 
																word, while **this** will result in a <strong>bold</strong> word.  Toggle the formatting help for more info on this!</p>
																<p class="information"><i class="fa fa-warning"></i> Now that you\'ve made your first post, this information screen will no longer be presented to you.  Instead, in the future, when making new posts,
																you will simply be automatically forwarded to them.  Now go forth - and be a productive member of this community!</p>';
															}else{
															echo '
																<p>Automatically forwarding you to your new <a href="'.$REDIRECTO.'">post</a>.</p>
																<hr />';
																echo '<meta http-equiv="refresh" content="3;URL= '.esc_url($REDIRECTO).'">';
															}
														}
													}
													
													
													
												}
											}
										}elseif(isset($_POST['FORMSUBMIT']) && $timegateactive === true){
													echo 'You can\'t do that yet.';
													
									}}
									if(!isset($_POST['FORMSUBMIT'])){
											echo '<div>';
											if($posting == 1 && $SEARCH == ''){
											if($THREAD == ''){
												if(filter_var($checkThisIP,FILTER_VALIDATE_IP)){ $IPPASS = true; }
												elseif(filter_var($checkThisIP,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){ $IPPASS = true; }
												else{ $IPPASS = false;}
													if($timegateactive === true){
														echo '<div class="timegate"><h3>'. ($timebetween - $timegate) . ' seconds until you can post again.</h3></div>';
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
																			foreach($checkPass as $EDITTHREAD){
																					$editComment = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',(str_replace('\\r\\n','||',($EDITTHREAD->COMMENT))))))));
																					$editSubject = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"||",($EDITTHREAD->SUBJECT))))));
																				echo '<form class="topic newthread" name="editform" method="post" action="'.$ACTION.'" id="COMMENTFORM">';
																				wp_nonce_field('editform');
																				echo '<input type="hidden" value="" name="LINK" />';
																				echo '<input type="hidden" value="" name="PAGE" />';
																				echo '<input type="hidden" value="" name="LOGIN" />';
																				echo '<input type="hidden" value="" name="USERNAME" />';
																				echo '<input type="hidden" value="'.$checkID.'" id="editthisthread" name="editthisthread" />';
																				echo '<label for="formextra" class="formtoggle"><i class="fa fa-plus-square-o"> toggle formatting help</i></label><input type="checkbox" class="hidden" id="formextra" name="formextra" />';
																				echo '<section class="formextras">';
																				echo '<section class="full"><table class="formatting"><tr><td>Effect</td><td>What you type</td><td>What you get</td></tr><tr><td>Bold</td><td><span title="Bold" onclick="formatThis(event)">**bold**</span></td><td><strong>bold</strong></tr><tr><td>Italics</td><td><span title="Italics" onclick="formatThis(event)">*italics*</span></td><td><em>italics</em></td></tr><tr><td>Strike</td><td><span title="Strike" onclick="formatThis(event)">~~strike~~</span></td><td><span class="strike">strike</span></td></tr><tr><td>Bold+Italic</td><td><span title="Bold and Italic" onclick="formatThis(event)">***bold italic***</span></td><td><strong><em>bold italic</em></strong></td></tr><tr><td>Quote</td><td><span title="Quote" onclick="formatThis(event)">{{Quoted text}}</span></td><td><blockquote>quoted text</blockquote></td></tr><tr><td>Alt. quote</td><td>4 spaces:<br />&nbsp;&nbsp;&nbsp;&nbsp;this is a quote</td><td><br /><span class="quotes">> this is a quote</span></td></tr><tr><td>Alt. Reply to</td><td>::101||</td><td><a href="#101">>> 101</a></td></tr><tr><td>New line, new paragraph</td><td><span title="New line" onclick="formatThis(event)">||</span>,<span title="New paragraph" onclick="formatThis(event)">||||</span></td><td>(trust us, it happens.)</td></tr><tr><td>List</td><td><span title="New list" onclick="formatThis(event)">2 spaces<br />&nbsp;&nbsp;- List item ||</span></td><td><ul><li>List item</li></ul></td></tr><tr><td>Code</td><td><span title="Code" onclick="formatThis(event)">`code`</span></td><td><code>code</code></td></tr><tr><td>Spoiler</td><td>This is a [spoiler]spoiler[/spoiler].</td><td>This is a <span class="spoiler">spoiler</span>.</td></tr></table></section>';
																				echo '</section>';
																				if($ISUSER !== true || $ISUSERJANITOR !== true)echo '<section class="passwordthis"><input type="password" id="PASSWORD" maxlength="'.$maxtext.'" name="PASSWORD" value="'.$EDITTHREAD->PASSWORD.'" /></section>';
																				echo '<section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" value="'.$editSubject.'" /></section>';
																				echo '<section class="full"><textarea id="COMMENT" name="COMMENT">'.$editComment.'</textarea></section>';
																				echo '<section class="formbottom">';
																				if($enableurl == 1 && $THREAD == '')echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$EDITTHREAD->URL.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';
																				echo '<section class="replytothis"><input type="text" id="REPLYTO" maxlength="'.$maxtext.'" name="REPLYTO" '; if($EDITTHREAD->REPLYTO != 0){ echo 'value="'.$EDITTHREAD->REPLYTO.'"';}echo ' placeholder="No. ###" /></section>';
																				echo '</section><span id="count"></span>';
																				$correct = 3;
																			}
																		}
																	}
																	if($correct == 0){
																		echo '
																		<form class="topic newthread" name="regularboard" method="post" action="'.$ACTION.'" id="COMMENTFORM">';
																		wp_nonce_field('regularboard');
																		echo '<input type="hidden" value="" name="LINK" />';
																		echo '<input type="hidden" value="" name="PAGE" />';
																		echo '<input type="hidden" value="" name="LOGIN" />';
																		echo '<input type="hidden" value="" name="USERNAME" />';
																		echo '<label for="formextra" class="formtoggle"><i class="fa fa-plus-square-o"> toggle formatting help</i></label><input type="checkbox" class="hidden" id="formextra" name="formextra" />';
																		echo '<section class="formextras">';
																		echo '<section class="full"><table class="formatting"><tr><td>Effect</td><td>What you type</td><td>What you get</td></tr><tr><td>Bold</td><td><span title="Bold" onclick="formatThis(event)">**bold**</span></td><td><strong>bold</strong></tr><tr><td>Italics</td><td><span title="Italics" onclick="formatThis(event)">*italics*</span></td><td><em>italics</em></td></tr><tr><td>Strike</td><td><span title="Strike" onclick="formatThis(event)">~~strike~~</span></td><td><span class="strike">strike</span></td></tr><tr><td>Bold+Italic</td><td><span title="Bold and Italic" onclick="formatThis(event)">***bold italic***</span></td><td><strong><em>bold italic</em></strong></td></tr><tr><td>Quote</td><td><span title="Quote" onclick="formatThis(event)">{{Quoted text}}</span></td><td><blockquote>quoted text</blockquote></td></tr><tr><td>Alt. quote</td><td>4 spaces:<br />&nbsp;&nbsp;&nbsp;&nbsp;this is a quote</td><td><br /><span class="quotes">> this is a quote</span></td></tr><tr><td>Alt. Reply to</td><td>::101||</td><td><a href="#101">>> 101</a></td></tr><tr><td>New line, new paragraph</td><td><span title="New line" onclick="formatThis(event)">||</span>,<span title="New paragraph" onclick="formatThis(event)">||||</span></td><td>(trust us, it happens.)</td></tr><tr><td>List</td><td><span title="New list" onclick="formatThis(event)">2 spaces<br />&nbsp;&nbsp;- List item ||</span></td><td><ul><li>List item</li></ul></td></tr><tr><td>Code</td><td><span title="Code" onclick="formatThis(event)">`code`</span></td><td><code>code</code></td></tr><tr><td>Spoiler</td><td>This is a [spoiler]spoiler[/spoiler].</td><td>This is a <span class="spoiler">spoiler</span>.</td></tr></table></section>';
																		echo '</section>';
																		echo '<section class="passwordthis"><input type="password" id="PASSWORD" maxlength="'.$maxtext.'" name="PASSWORD" value="'.$rand.'" /></section>';
																		echo '<section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" /></section>';
																		echo '<section class="full"><textarea id="COMMENT" name="COMMENT" placeholder="Comment"></textarea></section>';
																		echo '<section class="formbottom">';
																		if($enableurl == 1 && $THREAD == ''){echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';}
																		if($enablerep == 1 && $THREAD != '')echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';
																		if($enableemail == 1)echo '<section class="email"><input type="text" id="EMAIL" maxlength="'.$maxtext.'" name="EMAIL" placeholder="E-mail" /></section>';
																		echo '</section><span id="count"></span>';
																	}
																	echo '<section class="full submission"><label for="FORMSUBMIT" class="submit">Post</label><input type="submit" name="FORMSUBMIT" id="FORMSUBMIT" /></section>';
																	echo '</form>';
																}
																
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
																$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$IP','$ID2REPORT','$THEPARENT','$BOARD','3','$REPORTMESSAGE','$LENGTH','0')");
																echo '<span class="alert">Report received.  Thank you!</span>';
															}elseif($exists == 0){
																echo '<span class="alert">Thread does not exist.</span>';
															}elseif(count($grabReport) > 0){
																echo '<span class="alert">Thread has already been reported.</span>';
															}
															echo '<hr />';
														}
													}
												
												echo '</div>';
												}
												
												echo '<div class="boardposts">';

												// Board data display (if board exists) start
												$totalREPLIES = 0;
												if(count($getParentPosts) > 0){
												
													if($BoardIsSet !== true)if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD;}
													if($BoardIsSet === true)if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE;}
													if($BoardIsSet !== true)if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
													if($BoardIsSet === true)if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?thread='.$THREAD;}
													
													
													
													
													
													// Thread[start]
													foreach($getParentPosts as $parentPosts){
														$gotModReply      =            '';
														$ID               =            intval($parentPosts->ID);														
														if($THREAD != ''){
															$jTitle 			= $purifier->purify($parentPosts->SUBJECT);
															if($jTitle         == '') $jTitle = 'No subject';
															$jTitle          	= str_replace('\\\\\\\'','\'',$jTitle);
															$originaltitle      = get_the_title($ID);
															echo '
															<script type="text/javascript">
																	document.title = \''.$jTitle.' \\\ '.$BOARD.'\';
															</script>';
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
														if($STICKY == 0)$sticky =      '';
														if($LOCKED == 1)$locked =      '<span><i class="fa fa-lock"></i></span>';
														if($LOCKED == 0)$locked =      '';
														if($STICKY != 1)$date =        '<span><i class="fa fa-clock-o"> '.timesincethis($DATE).'</i></span>';
														$MODERATOR        =            intval($parentPosts->MODERATOR);
														$PARENT           =            intval($parentPosts->PARENT);
														$VUP              =            intval($parentPosts->UP);
														$thread_karma     =            '<span><i class="fa fa-heart"> '.$VUP.'</i></span>';
														$BOARD            =            $parentPosts->BOARD;
														$EMAIL            =            $parentPosts->EMAIL;
														if($MODERATOR == 1)$name = '<span><i class="fa fa-user"><a href="'.$profilelink.'"> '.$modcode.'</a></i></span>';
														elseif($MODERATOR == 2)$name = '<span><i class="fa fa-user"><a href="'.$profilelink.'"> '.$usermodcode.'</a></i></span>';
														elseif($MODERATOR == 0){
															if(strtolower($EMAIL) == 'heaven'){
																$name = '<span><i class="fa fa-user"> ??? </i></span>';
															}else{
																$name = '<span><i class="fa fa-user"><a href="'.$profilelink.'"> '.$defaultname.'</a></i></span>';
															}
														}
														if($EMAIL != ''){
															if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){
																$op_trip = ''; 
															}else{
																$op_trip = '<span class="trip"> <i class="fa fa-exclamation"> '.$EMAIL.'</i></span>';
															}
														}
														$IAMOP            =            $parentPosts->EMAIL;
														$LAST             =            $parentPosts->LAST;
														$SUBJECT          =            $parentPosts->SUBJECT;
														$TYPE             =            $parentPosts->TYPE;
														$URL              =            $parentPosts->URL;
														$thread_url = '';
														if($TYPE == 'URL' && $URL != '')$thread_url = '<span><i class="fa fa-link"> <a href="'.esc_url($URL).'">Attached link</a></i></span>';
														
														$COMMENT = wpautop(rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($parentPosts->COMMENT))))))));
														if($style === 'imageboard' && $THREAD == '' || $style === 'imageboard' && $THREAD != '' || $style === 'textboard' && $THREAD != ''){
															if($THREAD == ''){
																$COMMENT = regularboard_html_cut($COMMENT,$cutoff);
																if(strlen($COMMENT) > $cutoff)$COMMENT = $COMMENT.'<p><small>(View thread to read the rest of this comment.)</small></p>';
															}else{
																$COMMENT = $COMMENT;
															}
															$COMMENT = '<div class="commentContainer commentOP">'.$COMMENT.'</div>';
															$show_thread_comment = true;
														}												
														$SUBJECT          =            str_replace('\\\\\\\'','\'',$SUBJECT);
														if($SUBJECT      == '')        $SUBJECT = 'No subject';
														if($SUBJECT      != '')        $SUBJECT = $SUBJECT;
														if($SEARCH != '' && $THREAD != '') $gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ( EMAIL = '".$SEARCH."' OR COMMENT LIKE '%".$SEARCH."%' OR SUBJECT LIKE '%".$SEARCH."%' OR URL LIKE '%".$SEARCH."%' ) AND PARENT = $ID ORDER BY UP DESC, LAST ASC");
														if($SEARCH == '' && $THREAD       != '')            $gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."' ORDER BY UP DESC, LAST ASC");
														if($SEARCH != '')echo '<hr /><em>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i> Searching this thread for '.$SEARCH.'.  Returned '.count($gotReplies).' results.</em><hr />';
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
														if($BoardIsSet !== true)if($THREAD == '')$thread_reply_link = '<span><i class="fa fa-reply"> <a href="?board='.$BOARD.'&amp;thread='.$ID.'">Reply</a> ('.count($getReplies).')</i></span>';
														if($BoardIsSet === true)if($THREAD == '')$thread_reply_link = '<span><i class="fa fa-reply"> <a href="?thread='.$ID.'">Reply</a> ('.count($getReplies).')</i></span>';															
														if($style === 'imageboard'){
															if($totalREPLIES >= 4)      $totalREPLYS = $totalREPLIES - 3;
															if($totalREPLIES >= 3)      $totalREPLYS = $totalREPLIES - 3;
															if($totalREPLIES == 2)      $totalREPLYS = $totalREPLIES - 2;
															if($totalREPLIES == 1)      $totalREPLYS = $totalREPLIES - 1;
															if($totalREPLIES == 0)      $totalREPLYS = $totalREPLIES - 0;
															if($THREAD       == '')     $gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."' ORDER BY DATE ASC LIMIT $totalREPLYS,3");
														}															
														if($TYPE         == 'image')    $THREADIMGS++;
														if($PARENT == 0){
															if($MODERATOR == 0)$getModReply       = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."' AND MODERATOR = '1' LIMIT 1");
															if(count($getModReply) > 0)$gotModReply = ' modreplied';
															if($gotModReply != '')$modishere = ' <i class="fa fa-star"></i>';
															if($BoardIsSet  !== true)    $SUBJECT =  '<span class="subject'.$gotModReply.'"> <a class="left posttitle" href="?board='.$BOARD.'&amp;thread='.$ID.'">'.$modishere.$SUBJECT.'</a></span>';
															if($BoardIsSet  === true)    $SUBJECT =  '<span class="subject'.$gotModReply.'"> <a class="left posttitle" href="?thread='.$ID.'">'.$modishere.$SUBJECT.'</a></span>';
														}else{
															if($BoardIsSet  !== true)    $SUBJECT =  '<span class="subject"> <a class="left posttitle" href="?board='.$BOARD.'&amp;thread='.$PARENT.'#'.$ID.'">'.$SUBJECT.'</a></span>';
															if($BoardIsSet  === true)    $SUBJECT =  '<span class="subject"> <a class="left posttitle" href="?thread='.$PARENT.'#'.$ID.'">'.$SUBJECT.'</a></span>';
														}
														if($style === 'imageboard' && $THREAD == '' || $style === 'imageboard' && $THREAD != '' || $style === 'textboard' && $THREAD != ''){
															if($URL != '' && $TYPE == 'image'){
																$op_embed = '<a href="'.$URL.'"><img class="imageOP" src="'.$URL.'" alt="'.$URL.'" /></a>';
															}elseif($TYPE == 'video' && $URL != ''){
																$op_embed = '<iframe src="http://www.youtube.com/embed/'.$parentPosts->URL.'?loop=1&amp;playlist='.$parentPosts->URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" frameborder="0" allowfullscreen></iframe>';
															}else{
																$op_embed = '';
															}
														}else{
															$imageboard_subject = '';
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
																$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Downvote','','0')");
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
																$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Upvote','','0')");
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
														if($style === 'imageboard' && $THREAD == '' || $style === 'imageboard' && $THREAD != '' || $style === 'textboard' && $THREAD != ''){
															$thread_header = 
															 $imageboard_subject
															. '<div class="commentMeta">'
															. $op_approval_button
															. $op_disapproval_button
															. $thread_karma
															. $thread_reply
															. $sticky
															. $locked
															. $date
															. $name
															. $karma_count
															. $op_trip
															. $thread_url
															. $thread_reply_link
															. '</div>';
														}else{
															$thread_header = 
															 '<section>'
															. $SUBJECT
															. '<div class="commentMeta">'
															. $op_approval_button
															. $op_disapproval_button
															. $thread_karma
															. $thread_reply
															. $sticky
															. $locked
															. $date
															. $name
															. $karma_count
															. $op_trip
															. $thread_url
															. $thread_reply_link
															. '</div>'
															. '</section>';
														}
														
														// All of the parent thread information comes together here:
														echo '<div class="op" id="'.$ID.'">'.$thread_header;if($show_thread_comment === true)echo $COMMENT;
														
														// Replies DIV/load more link opens up here
														if($style === 'imageboard'){
															if($THREAD == '' && $totalREPLIES >= 4){
																echo '
																<i class="loadmore" xdata="'.$ID.'" data="';
																if($BOARDURL != '') { echo $BOARDURL.'/?thread='.$ID; }
																elseif($BoardIsSet !== true) { echo $THISPAGE.'?board='.$BOARD.'&amp;thread='.$ID; }
																elseif($BoardIsSet === true) { echo $THISPAGE.'?thread='.$ID; }
																echo '">'.$totalREPLYS.' posts omitted.  Click to load or reply to view all</i>';
															}
															if($THREAD == ''){
																echo '<div class="omitted'.$ID.'" id="omitted">';
															}
														}
														if($THREAD != '')echo '<div class="omitted'.$ID.'" id="omitted">';
														if($THREAD != '' && $totalREPLIES >= 3)echo '<a class="loadmore" href="#COMMENTFORM">Skip to comment form</a>';
														
														
														
														
														
														// Replies[start]
														if(count($gotReplies) > 0){
															if($style === 'imageboard' && $THREAD == '' || $style === 'imageboard' && $THREAD != '' || $style === 'textboard' && $THREAD != ''){
																// Reply->loop[start]
																foreach($gotReplies as $REPLIES){
																	// Reply->data_setup[start]
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
																	$this_is_op = '';
																	if($EMAIL == $IAMOP && $EMAIL != ''){$this_is_op = ' <strong>(OP)</strong>';}
																	if($MODERATOR == 1){$reply_name = '<span><i class="fa fa-user"><a href="'.$profilelink.'"> '.$modcode.$this_is_op.'</a></i></span>';}
																	if($MODERATOR == 2){$reply_name = '<span><i class="fa fa-user"><a href="'.$profilelink.'"> '.$usermodcode.$this_is_op.'</a></i></span>';}
																	if(strtolower($EMAIL) == 'heaven'){$reply_name = '<span><i class="fa fa-user"> ???'.$this_is_op;}
																	if($MODERATOR != 1 && $MODERATOR != 2){$reply_name = '<span><i class="fa fa-user"><a href="'.$profilelink.'"> '.$defaultname.$this_is_op.'</a></i></span>';}
																	if($EMAIL != ''){ if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){ $reply_trip = ''; }else{ $reply_trip = '<span class="trip"> <i class="fa fa-exclamation"> '.$EMAIL.'</i></span>'; } }		
																	if(isset($_POST['DISAPPROVE'.$ID])){ echo '<meta http-equiv="refresh" content="0">'; $getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1"); foreach($getUP as $gotUP){ $UP = $gotUP->UP; $up = $UP + 1; $down = $UP - 1; } $getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1"); foreach($getUSER as $USERED){ $KARMA = $USERED->KARMA; $kup = $KARMA + 1; $kdown = $KARMA - 1; } if($checkfordownvote > 0){ $wpdb->delete( $regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') ); $wpdb->update( $regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') ); $wpdb->update( $regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') ); } if($checkfordownvote == 0){ $wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Downvote','','0')"); $wpdb->update( $regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') ); $wpdb->update( $regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') ); } }
																	if(isset($_POST['APPROVE'.$ID])){ echo '<meta http-equiv="refresh" content="0">'; $getUP   = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$ID."' LIMIT 1"); foreach($getUP as $gotUP){ $UP = $gotUP->UP; $up = $UP + 1; $down = $UP - 1; } $getUSER   = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$IP."' AND BANNED = '8' LIMIT 1"); foreach($getUSER as $USERED){$KARMA = $USERED->KARMA; $kup = $KARMA + 1; $kdown = $KARMA - 1; } if($checkforupvote > 0){ $wpdb->delete($regularboard_users, array('THREAD' => $ID, 'IP' => $theIP_us32str),array( '%d','%d') ); $wpdb->update($regularboard_posts, array( 'UP' => $down ), array( 'ID' => $ID), array( '%d') ); $wpdb->update($regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d','%d') ); } if($checkforupvote == 0){ $wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA) VALUES ('','$current_timestamp','$theIP_us32str','$ID','$PARENT','9','Upvote','','0')"); $wpdb->update($regularboard_posts, array( 'UP' => $up ), array( 'ID' => $ID), array( '%d') ); $wpdb->update($regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $IP, 'BANNED' => '8'), array( '%d') ); }  }
																	if($checkforupvote > 0 && $checkfordownvote == 0){ $reply_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>'; }elseif($checkforupvote == 0 && $checkfordownvote > 0){ $reply_approval_button = ''; }else{ $reply_approval_button = '<span><form method="post" action="'.$ACTION.'" name="APPROVE"><label for="APPROVE'.$ID.'"><i class="fa fa-thumbs-o-up"></i></label><input type="submit" class="hidden" name="APPROVE'.$ID.'" id="APPROVE'.$ID.'" /></form></span>'; }
																	if($checkfordownvote > 0 && $checkforupvote == 0){ $reply_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>'; }elseif($checkfordownvote == 0 && $checkforupvote > 0){ $reply_disapproval_button = ''; }else{ $reply_disapproval_button = '<span><form method="post" action="'.$ACTION.'" name="DISAPPROVE"><label for="DISAPPROVE'.$ID.'"><i class="fa fa-thumbs-o-down"></i></label><input type="submit" class="hidden" name="DISAPPROVE'.$ID.'" id="DISAPPROVE'.$ID.'" /></form></span>'; }
																	$reply_karma = '<span><em class="karma"><i class="fa fa-heart"> '.$KARMA.'</i></em></span>'; 
																	$reply_date = '<span><i class="fa fa-clock-o"> '.timesincethis($REPLIES->DATE).'</i></span>';
																	$TYPE = $REPLIES->TYPE;
																	if($TYPE == 'image') $THREADIMGS++;
																	$reply_attached_link = '';
																	if($TYPE == 'URL' && $URL != '')$reply_attached_link = '<span><i class="fa fa-link"> <a href="'.esc_url($URL).'">Attached link</a></i></span>';
																	$SUBJECT  = rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',('<span class="replysubject">'.$REPLIES->SUBJECT.'</span>')))));
																	if($THREAD != '')$COMMENT = wpautop(rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($REPLIES->COMMENT))))))));
																	if($THREAD == '' && strlen($REPLIES->COMMENT) <= $cutoff)$COMMENT = regularboard_html_cut(rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($REPLIES->COMMENT))))))),$cutoff);
																	if($THREAD == '' && strlen($REPLIES->COMMENT) > $cutoff)$COMMENT = regularboard_html_cut(rb_format(str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"<br />",($REPLIES->COMMENT))))))),$cutoff).'...';
																	$THISPAGE = get_permalink();
																	$postNo = '<span><i class="fa fa-angle-right"> No. <a href="#COMMENTFORM" onclick="replyThis(event)">'.$ID.'</a></i></span>';
																	$thread_karma = '<span><i class="fa fa-heart"> '.intval($REPLIES->UP).'</i></span>';
																	$reply_embed = '';
																	if($URL != '' && $TYPE == 'image'){
																		if($COMMENT != '')$imgclass = 'REPLY';
																		if($COMMENT == '')$imgclass = 'OP';
																	$reply_embed = '<a href="'.$URL.'"><img class="image'.$imgclass.'" alt="'.$URL.'" src="'.$URL.'"/></a>'; 
																	}elseif($TYPE == 'video' && $URL != ''){ $reply_embed = '<iframe src="http://www.youtube.com/embed/'.$URL.'?loop=1&amp;playlist='.$URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" frameborder="0" allowfullscreen></iframe>'; }
																	// Reply->data_setup[end]
																	// Reply->content[start]
																	echo '<div class="reply'; if($EMAIL == $IAMOP && $EMAIL != ''){echo ' iamop';} echo '" id="'.$ID.'"><div class="replycontent">' . $SUBJECT . '<div class="commentMeta">' . $reply_approval_button . $reply_disapproval_button . $thread_karma . $postNo;
																	if($REPLYTO != 0){
																		if($BoardIsSet !== true)$reply_link = '?board='.$BOARD.'&amp;thread='.$THREAD.'&amp;'.$REPLYTO.'#'.$REPLYTO.'">';
																		if($BoardIsSet === true)$reply_link = '?thread='.$THREAD.'&amp;'.$REPLYTO.'#'.$REPLYTO.'">';																		
																		echo '<span><i class="fa fa-reply"> <a href="'.$reply_link.$REPLYTO.'</a></i></span>';
																	}
																	echo $reply_name . $reply_trip . $reply_karma . $reply_date . $reply_attached_link . '</div>';
																	if(count($gotReply) > 0){
																		echo '<span class="commentReplies"><span><i class="fa fa-reply"> Replies</i></span>'; foreach($gotReply as $replyid){ $replychild = intval($replyid->ID); $replyparent = intval($replyid->PARENT); $replyboard = strtolower($replyid->BOARD); 
																		if($BoardIsSet !== true)$reply_link = '?board='.$replyboard.'&amp;thread='.$replyparent.'&amp;'.$replychild.'#'.$replychild.'">'.$replychild; 
																		if($BoardIsSet === true)$reply_link = '?thread='.$replyparent.'&amp;'.$replychild.'#'.$replychild.'">'.$replychild; 
																		echo '<span><i class="fa fa-dot-circle-o"> <a href="'.$reply_link.'</a></i></span>'; } echo '</span>'; 
																	}
																	echo '<section class="commentREPLY">'.$reply_embed.$COMMENT.'</section></div></div>';
																	// Reply->content[end]
																}
																// Reply->loop[end]
															}
														}
														if($style == 'imageboard' && $THREAD == '')echo '</div>';
														// Replies[end]
														

														// Reply-form->thread[start]
														if($THREAD != ''){
															echo '</div>';
															echo '<div class="commentMeta"><span><i class="fa fa-reply"> ';
															if($BoardIsSet !== true) echo '<a href="?board='.$BOARD.'"> return to '.$BOARD.'</a>';
															if($BoardIsSet === true) echo '<a href="'.esc_url(get_permalink($post->ID)).'"> return to '.$BOARD.'</a>';
															echo '</i></span>';
															if($maxreplies > 0){ echo '<span><i class="fa fa-comment"> ...or contribute something to this thread ('.$THREADREPLIES.' replies so far)</i></span>'; }
															echo '</div>';
															if(filter_var($checkThisIP,FILTER_VALIDATE_IP)){ $IPPASS = true; }
															elseif(filter_var($checkThisIP,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){ $IPPASS = true; }
															else{ $IPPASS = false;}
															if($timegateactive === true){
																echo '<div class="timegate"><h3>'. ($timebetween - $timegate) . ' seconds until you can post again.</h3></div>';
															}else{
																if($posting != 1){
																	echo '<h3>Read-Only Mode</h3>';
																}
																elseif($posting == 1 && $IPPASS === false){
																	echo '<h3>You are not permitted to post.</h3>';
																}
																elseif($posting == 1 && $IPPASS === true){

																	if($currentCountNomber >= $maxreplies){
																		
																	}else{
																		$LOCKED = 0;
																		if($THREAD != '')$checkLOCK = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE LOCKED = '1' AND ID = '".$THREAD."' LIMIT 1");
																		if(count($checkLOCK) == 1)$LOCKED = 1;
																		if($LOCKED == 1 )echo '<h3><i class="fa fa-lock"></i> THREAD LOCKED</h3>';
																		if($LOCKED == 0){
																			
																			$correct = 0;
																			
																			if(isset($_POST['edit_this']) && $_REQUEST['report_ids'] !== '' && $_REQUEST['DELETEPASSWORD'] !== '' || 
																				$ISMODERATOR === true && isset($_POST['admin_edit']) && $_REQUEST['admin_ids'] !== '' || 
																				$ISUSERMOD === true && isset($_POST['admin_edit']) && $_REQUEST['admin_ids'] !== '' ){
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
																					foreach($checkPass as $EDITTHREAD){
																						$editComment = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array('\\n','\\t','\\r'),'||',(str_replace('\\r\\n','||',($EDITTHREAD->COMMENT))))))));
																						$editSubject = str_replace('\\\\\\\'','\'',(str_replace('\\\\\\','',(str_replace(array("\n","\t","\r"),"||",($EDITTHREAD->SUBJECT))))));
																						echo '<form class="topic threadform" name="editform" method="post" action="'.$ACTION.'" id="COMMENTFORM">';
																						wp_nonce_field('editform');
																						echo '<input type="hidden" value="" name="LINK" />';
																						echo '<input type="hidden" value="" name="PAGE" />';
																						echo '<input type="hidden" value="" name="LOGIN" />';
																						echo '<input type="hidden" value="" name="USERNAME" />';
																						echo '<input type="hidden" value="'.$checkID.'" id="editthisthread" name="editthisthread" />';
																						echo '<label for="formextra" class="formtoggle"><i class="fa fa-plus-square-o"> toggle formatting help</i></label><input type="checkbox" class="hidden" id="formextra" name="formextra" />';
																						echo '<section class="formextras">';
																						echo '<section class="full"><table class="formatting"><tr><td>Effect</td><td>What you type</td><td>What you get</td></tr><tr><td>Bold</td><td><span title="Bold" onclick="formatThis(event)">**bold**</span></td><td><strong>bold</strong></tr><tr><td>Italics</td><td><span title="Italics" onclick="formatThis(event)">*italics*</span></td><td><em>italics</em></td></tr><tr><td>Strike</td><td><span title="Strike" onclick="formatThis(event)">~~strike~~</span></td><td><span class="strike">strike</span></td></tr><tr><td>Bold+Italic</td><td><span title="Bold and Italic" onclick="formatThis(event)">***bold italic***</span></td><td><strong><em>bold italic</em></strong></td></tr><tr><td>Quote</td><td><span title="Quote" onclick="formatThis(event)">{{Quoted text}}</span></td><td><blockquote>quoted text</blockquote></td></tr><tr><td>Alt. quote</td><td>4 spaces:<br />&nbsp;&nbsp;&nbsp;&nbsp;this is a quote</td><td><br /><span class="quotes">> this is a quote</span></td></tr><tr><td>Alt. Reply to</td><td>::101||</td><td><a href="#101">>> 101</a></td></tr><tr><td>New line, new paragraph</td><td><span title="New line" onclick="formatThis(event)">||</span>,<span title="New paragraph" onclick="formatThis(event)">||||</span></td><td>(trust us, it happens.)</td></tr><tr><td>List</td><td><span title="New list" onclick="formatThis(event)">2 spaces<br />&nbsp;&nbsp;- List item ||</span></td><td><ul><li>List item</li></ul></td></tr><tr><td>Code</td><td><span title="Code" onclick="formatThis(event)">`code`</span></td><td><code>code</code></td></tr><tr><td>Spoiler</td><td>This is a [spoiler]spoiler[/spoiler].</td><td>This is a <span class="spoiler">spoiler</span>.</td></tr></table></section>';
																						echo '</section>';
																						if($ISUSER !== true || $ISUSERJANITOR !== true)echo '<section class="passwordthis"><input type="password" id="PASSWORD" maxlength="'.$maxtext.'" name="PASSWORD" value="'.$EDITTHREAD->PASSWORD.'" /></section>';
																						echo '<section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" value="'.$editSubject.'" /></section>';
																						echo '<section class="full"><textarea id="COMMENT" name="COMMENT">'.$editComment.'</textarea></section>';
																						echo '<section class="formbottom">';
																						if($enableurl == 1 && $THREAD == '')echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$EDITTHREAD->URL.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';
																						if($enablerep == 1 && $THREAD != '')echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$EDITTHREAD->URL.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';
																						echo '<section class="replytothis"><input type="text" id="REPLYTO" maxlength="'.$maxtext.'" name="REPLYTO" '; if($EDITTHREAD->REPLYTO != 0){ echo 'value="'.$EDITTHREAD->REPLYTO.'"';}echo ' placeholder="No. ###" /></section>';
																						echo '</section><span id="count"></span>';
																						$correct = 3;
																					}
																				}
																			}
																			if($correct == 0){
																				echo '<form class="reply topic threadform" name="regularboard" method="post" action="'.$ACTION.'" id="COMMENTFORM">';
																				wp_nonce_field('regularboard');
																				echo '<input type="hidden" value="" name="LINK" />';
																				echo '<input type="hidden" value="" name="PAGE" />';
																				echo '<input type="hidden" value="" name="LOGIN" />';
																				echo '<input type="hidden" value="" name="USERNAME" />';
																				echo '<label for="formextra" class="formtoggle"><i class="fa fa-plus-square-o"> toggle formatting help</i></label><input type="checkbox" class="hidden" id="formextra" name="formextra" />';
																				echo '<section class="formextras">';
																				echo '<section class="full"><table class="formatting"><tr><td>Effect</td><td>What you type</td><td>What you get</td></tr><tr><td>Bold</td><td><span title="Bold" onclick="formatThis(event)">**bold**</span></td><td><strong>bold</strong></tr><tr><td>Italics</td><td><span title="Italics" onclick="formatThis(event)">*italics*</span></td><td><em>italics</em></td></tr><tr><td>Strike</td><td><span title="Strike" onclick="formatThis(event)">~~strike~~</span></td><td><span class="strike">strike</span></td></tr><tr><td>Bold+Italic</td><td><span title="Bold and Italic" onclick="formatThis(event)">***bold italic***</span></td><td><strong><em>bold italic</em></strong></td></tr><tr><td>Quote</td><td><span title="Quote" onclick="formatThis(event)">{{Quoted text}}</span></td><td><blockquote>quoted text</blockquote></td></tr><tr><td>Alt. quote</td><td>4 spaces:<br />&nbsp;&nbsp;&nbsp;&nbsp;this is a quote</td><td><br /><span class="quotes">> this is a quote</span></td></tr><tr><td>Alt. Reply to</td><td>::101||</td><td><a href="#101">>> 101</a></td></tr><tr><td>New line, new paragraph</td><td><span title="New line" onclick="formatThis(event)">||</span>,<span title="New paragraph" onclick="formatThis(event)">||||</span></td><td>(trust us, it happens.)</td></tr><tr><td>List</td><td><span title="New list" onclick="formatThis(event)">2 spaces<br />&nbsp;&nbsp;- List item ||</span></td><td><ul><li>List item</li></ul></td></tr><tr><td>Code</td><td><span title="Code" onclick="formatThis(event)">`code`</span></td><td><code>code</code></td></tr><tr><td>Spoiler</td><td>This is a [spoiler]spoiler[/spoiler].</td><td>This is a <span class="spoiler">spoiler</span>.</td></tr></table></section>';
																				echo '</section>';
																				echo '<section class="passwordthis"><input type="password" id="PASSWORD" maxlength="'.$maxtext.'" name="PASSWORD" value="'.$rand.'" /></section>';
																				echo '<section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" /></section>';
																				echo '<section class="full"><textarea id="COMMENT" name="COMMENT" placeholder="Comment"></textarea></section>';
																				echo '<section class="formbottom">';
																				if($enableurl == 1 && $THREAD == ''){echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';}
																				if($enablerep == 1 && $THREAD != '')echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';
																				if($enableemail == 1)echo '<section class="email"><input type="text" id="EMAIL" maxlength="'.$maxtext.'" name="EMAIL" placeholder="E-mail" /></section>';
																				if($THREAD != '')echo '<section class="replytothis"><input type="text" id="REPLYTO" maxlength="'.$maxtext.'" name="REPLYTO" placeholder="No. ###" /></section>';
																				echo '</section><span id="count"></span>';
																				
																			}

																				echo '<section class="full submission"><label for="FORMSUBMIT" class="submit">Post</label><input type="submit" name="FORMSUBMIT" id="FORMSUBMIT" /></section>';
																				echo '</form>';
																				
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
																				
																		}
																	}
																}
															}												
															echo '<div>';
														}
														// Reply-form->thread[end]
														
														
														
														
														
														if($THREAD == '')echo '</div>';
													}
													// Thread[end]
													
													
													
													
													if($BOARD != '' && $THREAD == ''){
														// Board index paging
														$i = 0;
														$results = 1;
														$paging = round($totalpages / $postsperpage);
														if($paging > 0){
															$pageresults = round($paging / 10);
															echo '<div class="pages">';
															if($results == '' || $results == 1) echo 'Previous ';
															if($results > 1)if($BoardIsSet !== true)echo '<a href="?board='.$BOARD.'&amp;results='.($results - 1).'">Previous</a> ';
															if($results > 1)if($BoardIsSet === true)echo '<a href="?results='.($results - 1).'">Previous</a> ';
															echo ' &mdash; Page '.$results.' of '.$paging.' &mdash; ';
															if($results == $paging ){ echo 'Next'; $results = 1; $paging = 1; }
															elseif($results < $paging)if($BoardIsSet !== true)echo '<a href="?board='.$BOARD.'&amp;results='.($results + 1).'">Next</a> ';
															elseif($results < $paging)if($BoardIsSet === true)echo '<a href="?results='.($results + 1).'">Next</a> ';
															echo '</div>';
														}
													if($THREAD == '' && $BOARD != ''){ echo '<div class="threadinformation"></div>';}
														echo '</div></div>';
													}
													echo '</div>';
													$threadexists = 1;
													
												}else{
													// If no board or thread to display start
													$threadexists = 0;
													echo '<div class="op"><span class="subject">'.$nothreads.'</span>';
													if($nothreadsimg != '')echo '<img class="imageOP" src="'.$nothreadsimg.'" />';
													echo '</div>';
												}
												
												if($THREAD != '' && $threadexists != 0){
													// [Return],[Top],[Refresh] links as well as image and reply count stars-bar
													echo '
													<div class="threadinformation">
														<div class="leftmeta">';
															if($BoardIsSet !== true) echo '<a href="?board='.$BOARD.'">[ Return ]</a>';
															if($BoardIsSet === true) echo '<a href="'.esc_url(get_permalink($post->ID)).'">[ Return ]</a>';
															echo '<a href="#top">[ Top ]</a>
															<span class="reload" data="';
															if($BoardIsSet !== true) echo $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;
															if($BoardIsSet === true) echo $THISPAGE.'?thread='.$THREAD;
															echo '">[ <i class="fa fa-refresh"> Update</i> ]</span>
														</div>
														['.$THREADREPLIES.' replies] ['.$THREADIMGS.' images] 
														</div>
													</div></div>';
												}
												
										}
									}
								}
							}
							
						}else{
							// Requested board does not exist
							echo '<div><div class="boardposts"><div class="op"><span class="subject">'.$noboard.'</span>';
							if($nothreadsimg != ''){echo '<img class="imageOP" src="'.$noboardimg.'" />';}
							echo '</div></div>';
						}
						
					}
			}else{
				if($BOARD == '' && $AREA == '' || $BOARD == '_front'){
				echo '<div class="boardlist">';
				if(count($getBoards) > 0){
					foreach($getBoards as $gotBoards){
						$BOARDNAME = esc_sql(myoptionalmodules_sanistripents($gotBoards->SHORTNAME));
						$BOARDLONG = esc_sql(myoptionalmodules_sanistripents($gotBoards->NAME));
						$BOARDDESC = esc_sql(myoptionalmodules_sanistripents($gotBoards->DESCRIPTION));
						$BOARDDESC = str_replace('\\\\\\\\\\\\\\\'','\'',$BOARDDESC);
						$BOARDSFW  = $gotBoards->SFW;
						$BOARDURL  = esc_url(myoptionalmodules_sanistripents($gotBoards->URL)); 
						if($BOARDDESC != '')$BOARDDESC = ' &mdash; <em>'.$BOARDDESC.'</em>';
						$getBoardPostsTopics = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."' ORDER BY DATE DESC LIMIT 10");
						echo '
						<section class="clear item">';
						echo '<span class="item">';
						if($BOARDURL != '')echo '<a href="'.$BOARDURL.'/">'.$BOARDLONG;
						if($BOARDURL == '')echo '<a href="?board='.$BOARDNAME.'">'.$BOARDLONG;
						echo '</a></span>';
						$c = 1;
						if($membersonly != 1){
							foreach($getBoardPostsTopics as $posts){
								
								$subject = '';
								if($posts->TYPE == '' || $posts->TYPE == 'URL' || $posts->TYPE == 'image' && $BOARDSFW == 'NSFW' || $posts->TYPE == 'video'){
									$subject = $posts->SUBJECT;
									$subject = str_replace('\\\\\\\'','\'',$subject);
									if($subject == '')$subject = '<em>no subject</em>';
								}
								elseif($posts->TYPE == 'image' && $BOARDSFW == 'SFW'){
									$subject = '<img src="'.$posts->URL.'" class="imageOP" />';
								}
								
								$id = $posts->ID;
								echo '<span class="item">';
								if($posts->PARENT >  0)$reply = '?thread='.$posts->PARENT.'#'.$posts->ID;
								if($posts->PARENT == 0)$reply = '?thread='.$posts->ID.'';
								if($BOARDURL != '')echo '<a href="'.$BOARDURL.'/'.$reply.'">'.$subject;
								if($BOARDURL == '')echo '<a href="?board='.$BOARDNAME.'&amp;'.$reply.'">'.$subject;
								echo ' <small>posted '.timesincethis($posts->DATE).'</small></a></span>';
							}
						}
						echo '
						</section>';
					}
				}
				
			
				
				echo '
			</div>';
			}
			}
		if($THREAD != '')echo '</div></div>';
		if($AREA != '')echo '</div>';
		}
	}
	if(get_option('mommaincontrol_regularboard') == 1)add_shortcode('regularboard','regularboard_shortcode');
	if(get_option('mommaincontrol_regularboard') == 1)add_filter('the_content','do_shortcode','regularboard_shortcode');

	
	
	
	
?>