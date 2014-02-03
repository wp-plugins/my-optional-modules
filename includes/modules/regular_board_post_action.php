<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

		if($THISBOARD != ''){
			$BOARD = $THISBOARD;
		}else{
			$BOARD = esc_sql($_REQUEST['board']);
			$checkboard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '$BOARD' LIMIT 1");
			if(count($checkboard) == 0){
				$timegateactive = true;
			}
		}

		if($timegateactive !== true){
			
			if($posting == 1 && $THREAD == '' || $currentCountNomber < $maxreplies && $posting == 1 && $THREAD != '' || $AREA == 'post'){
			
					$IS_IT_SPAM = 0;
					if(function_exists('akismet_admin_init')){
						$APIKey = myoptionalmodules_sanistripents(get_option('wordpress_api_key'));
						if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE.'?b='.$BOARD;}
						if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;}
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
					if($_REQUEST['COMMENT'] == '' && $URL == '') {
						$empty = 1;
					}elseif($_REQUEST['LINK'] != '' || $_REQUEST['PAGE'] != '' || $_REQUEST['LOGIN'] != '' || $_REQUEST['USERNAME'] != ''){
						$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1','filling out hidden form areas (likely bot).','0','0','','0','0','','')");
					}elseif($IS_IT_SPAM == 1){
						$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','0','0','1','Akismet detected you as SPAM.','0','0','','0','0','','')");
					}else{
						if($IS_IT_SPAM == 1) {
						}else{
							if($THREAD == '' && $enableurl == 1 || $THREAD != ''  && $enablerep == 1){
								if($URL == '')$cleanURL = sanitize_text_field(wp_strip_all_tags($_REQUEST['URL']));
								if($URL != '')$cleanURL = $URL;
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
								
								if($URL == ''){
									if($cleanURL != ''){
										$path_info = pathinfo($cleanURL);
										if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $cleanURL, $match)) {
											$VIDEOID = $match[1];																
											$TYPE = 'video';
											$URL = sanitize_text_field(wp_strip_all_tags($VIDEOID));
										}
										elseif($status == '200' && getimagesize($cleanURL) !== false){
											if($path_info['extension'] == 'jpg' ||
												$path_info['extension'] == 'gif' ||
												$path_info['extension'] == 'jpeg' ||
												$path_info['extension'] == 'png'){
												$TYPE = 'image';
												$URL = $cleanURL;
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
							}

							if($_REQUEST['PARENT'] != ''){$enteredPARENT = intval($_REQUEST['PARENT']);}
							elseif($THREAD != ''){$enteredPARENT = intval($THREAD);}
							elseif($THREAD == ''){$enteredPARENT = 0;}
							
							if($_REQUEST['COMMENT'] != ''){
								$enteredCOMMENT    = $_REQUEST['COMMENT'];
								$checkCOMMENT = $enteredCOMMENT    = substr($enteredCOMMENT,0,$maxbody);
								$checkCOMMENT = $enteredCOMMENT    = sanitize_text_field(wp_strip_all_tags(wpautop($enteredCOMMENT)));
							}else{
								$enteredCOMMENT = '';
							}
							$checkURL        = $URL;
							$enteredSUBJECT  = sanitize_text_field(wp_strip_all_tags($_REQUEST['SUBJECT']));
							$enteredSUBJECT  = substr($enteredSUBJECT,0,$maxtext);

							if($profilepassword != '')$enteredPASSWORD = sanitize_text_field(wp_strip_all_tags($profilepassword));
							if($profilepassword == '')$enteredPASSWORD = $rand;
							
							
							if($enteredCOMMENT == '' && $URL != '')$getDuplicate = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE URL = '".$checkURL."' AND BOARD = '".$BOARD."' LIMIT 1");
							if($enteredCOMMENT != '' && $URL == '')$getDuplicate = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE COMMENT = '".$checkCOMMENT."' AND BOARD = '".$BOARD."' LIMIT 1");
							if($enteredCOMMENT != '' && $URL != '')$getDuplicate = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE (COMMENT = '".$checkCOMMENT."' OR URL = '".$checkURL."') AND BOARD = '".$BOARD."' LIMIT 1");
							
							if(count($getDuplicate) == 0 || $_REQUEST['editthisthread'] != '' ){
								if($_REQUEST['EMAIL'] == 'roll'){
									$enteredEMAIL = ''.$randnum1.' + '.$randnum2.' ('.($randnum1+$randnum2).')'; 
								}elseif($_REQUEST['EMAIL'] == strtolower('heaven')){
									$enteredEMAIL = 'heaven';
									$profileid = '';
								}elseif($_REQUEST['EMAIL'] == strtolower('sage')){
									$enteredEMAIL = 'sage';
								}else{
									$enteredEMAIL = '';
								}
								
								if($ISMODERATOR === true)$modCode = 1;
								if($ISUSERMOD   === true)$modCode = 2;
								if($ISUSER      === true)$modCode = 0;

								if($_REQUEST['REPLYTO'] != ''){
									$checkrepliedto = intval($_REQUEST['REPLYTO']);
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
											$checkID = intval($_REQUEST['editthisthread']);
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
											$checkID = intval($_REQUEST['editthisthread']);
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
											( ID, PARENT, IP, DATE, EMAIL, SUBJECT, COMMENT, URL, TYPE, BOARD, MODERATOR, LAST, STICKY, LOCKED, PASSWORD, REPLYTO, UP, USERID ) 
											VALUES ( %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, %d, %d, %s, %d, %d, %d )",
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
											1,
											$profileid
										)
									);
									
									$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT + 1 WHERE SHORTNAME = '$BOARD'");
									
									$checkUserExists = $wpdb->get_results("SELECT ID FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
									if(count($checkUserExists) == 0){
										$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','0','0','8','Karma count','','0','','0','0','','')");
									}
								}
								
								if($THREAD != '' && $LOCKED != 1 && strtolower($enteredEMAIL) != 'sage'){
									$wpdb->query("UPDATE $regularboard_posts SET LAST = '$current_timestamp' WHERE ID = '$THREAD'");
								}
								$wpdb->delete($regularboard_posts, array('COMMENT' => '', 'TYPE' => '', 'URL' =>''),array('%s'));	
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
										$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','0','0','5','unoriginal','10 minutes','','','0','0','','')");
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
						if($LATEST->PARENT == 0 && $BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?b='.$BOARD.'&amp;t='.$IDGOTO;}
						if($LATEST->PARENT != 0 && $BOARD != '' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?b='.$BOARD.'&amp;t='.$LATEST->PARENT.'#'.$LATEST->ID;}
					}
					
					if($BOARD != '' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;}
					
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
							foreach($getDuplicate as $duplicate){
								if($duplicate->PARENT == 0)$REDIRECTO = $THISPAGE.'?b='.$duplicate->BOARD.'&amp;t='.$duplicate->ID;
								if($duplicate->PARENT != 0)$REDIRECTO = $THISPAGE.'?b='.$duplicate->BOARD.'&amp;t='.$duplicate->PARENT.'#'.$duplicate->ID;
							}
							echo '
							<p>To view the found duplicate content, you may click <a href="'.$REDIRECTO.'">here</a>.  Otherwise, please go back and correct your post.  You have '.$mutecount.' more attempts before Auto-Mute is enabled.  Once Auto-Mute is enabled, you will not be able to interact with these boards for 10 minutes.</p>
							<hr />
							<p class="'.$pclass.'"><i class="fa fa-warning"></i> As part of this board\'s Auto-Mute feature, content that has already been submitted may not be submitted again.  
							What this means is that you can not submit the exact same content more than once.  Any IP address that attempts 
							to do this more than 5 times will be temporarily banned from using this board for 10 minutes.</p>
							<p class="'.$pclass.'"><i class="fa fa-question"></i> The simplest way that you can avoid these temporary bans by submitting thought provoking and <strong>original</strong> content and links,
							instead of submitting things that have already been submitted before.  There <strong>is</strong> a search function to browse the board via keywords.  Perhaps searching for your 
							content before submitting it will aid you in the future.</p></div>';
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
									word, while **this** will result in a <strong>bold</strong> word.  Read <a href="?a=help">this</a> for more information.</p>
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
				}else{
					echo '<div class="tinythread"><span class="tinysubject">Nothing submitted.</span></div>';		
				}
			}elseif(isset($_POST['FORMSUBMIT']) && $timegateactive === true){ echo 'You can\'t do that yet.'; }
		
	?>