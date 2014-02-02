<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	
	if($posting == 0){
		if($AREA == 'newtopic'){echo '<div class="tinythread"><span class="tinysubject">This board is currently locked.</span></div></div>';}
	}elseif($posting == 1 && $SEARCH == ''){
		
		if(count($getBoards) == 1){
			foreach($getBoards as $Board){
				$BOARD = $Board->SHORTNAME;
			}
		}
		
		if($BOARD != ''){
			if(filter_var($checkThisIP,FILTER_VALIDATE_IP)){ $IPPASS = true; }
			elseif(filter_var($checkThisIP,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){ $IPPASS = true; }
			else{ $IPPASS = false;}
				if($timegateactive === true){echo '<div class="tinythread"><span class="tinysubject">'. (10 - $timegate) . ' seconds until you can post again.</span></div>';
				}else{
					if($posting != 1){echo '<div class="tinythread"><span class="tinysubject">Read-Only Mode</span></div>';
					}
					elseif($posting == 1 && $IPPASS === false){echo '<div class="tinythread"><span class="tinysubject">You are not permitted to post.</span></div>';
					}
					elseif($posting == 1 && $IPPASS === true){	
						if($THREAD != '' && $currentCountNomber >= $maxreplies){
						}else{
							$LOCKED = 0;
							if($THREAD != '')$checkLOCK = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE LOCKED = '1' AND ID = '".$THREAD."' LIMIT 1");
							if(count($checkLOCK) == 1)$LOCKED = 1;
							if($LOCKED == 1 )echo '<div class="tinythread"><span class="tinysubject">Thread locked.</span></div>';
							if($LOCKED == 0){
							$correct = 0;
							if($iexist == 0){
							if(isset($_POST['iexist']) && $_REQUEST['addme'] == $theIP_s32int && $iexist == 0){
								$IP      = $theIP_s32int;
								$wpdb->query(
									$wpdb->prepare(
										"INSERT INTO $regularboard_users 
										( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) 
										VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s,%s )",
										'',
										$current_timestamp,
										$IP,
										0,
										0,
										'',
										8,
										'new user',
										'',
										1,
										'',
										0,
										0,
										'',
										''
									)
								);
								echo '<meta http-equiv="refresh" content="0">';
							}			
							echo '<div class="tinythread"><p>In order to verify that you are not a bot, you will need to fill out this form.  You will only need to do this once.  Until you fill out this form, you may not comment on this board.</p><form method="post" class="upgrade"><label for="iexist">Type <code>'.$theIP_s32int.'</code> and press enter.</label><input type="text" id="addme" name="addme" class="addme" value="" placeholder="'.$theIP_s32int.'" /><input type="submit" name="iexist" id="iexist" value="Add me." class="hidden" /></form></div>';
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
											$editComment = $EDITTHREAD->COMMENT;
											$editSubject = str_replace('\\','',$EDITTHREAD->SUBJECT);
											echo '<form name="editform" method="post" action="'.$THISPAGE.'?a=post" class="COMMENTFORM">';wp_nonce_field('editform');echo '<input type="hidden" value="" name="LINK" /><input type="hidden" value="" name="PAGE" /><input type="hidden" value="" name="LOGIN" /><input type="hidden" value="" name="USERNAME" /><input type="hidden" value="'.$checkID.'" id="editthisthread" name="editthisthread" /><section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" value="'.$editSubject.'" /></section><section class="full"><textarea id="COMMENT" name="COMMENT">'.str_replace(array('[',']'),array('&#91;','&#93;'),$editComment).'</textarea></section><section class="formbottom"><section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="';if($EDITTHREAD->TYPE == 'video'){ echo 'http://youtube.com/watch?v='.$EDITTHREAD->URL; } else { echo $EDITTHREAD->URL; } echo '" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section><section class="email"><input type="text" id="EMAIL" maxlength="'.$maxtext.'" name="EMAIL" placeholder="heaven/sage/roll" value="';if($profileheaven == 1){echo 'heaven';}echo '" /></section><section class="replytothis"><input type="text" id="REPLYTO" maxlength="'.$maxtext.'" name="REPLYTO" '; if($EDITTHREAD->REPLYTO != 0){ echo 'value="'.$EDITTHREAD->REPLYTO.'"';}echo ' placeholder="No. ###" /></section></section><span id="count"></span><section class="full submission"><label for="FORMSUBMIT" class="submit">Post</label><input type="submit" name="FORMSUBMIT" id="FORMSUBMIT" /></section></form></div>';
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
								if($correct == 0 && $AREA == 'newtopic' || $correct == 0 && $THREAD != '' && count($getposts) > 0){
									if($tlast == 0){
										echo '<div class="tinyreply"><form name="regularboard" method="post" action="'.$THISPAGE.'?a=post" class="COMMENTFORM">';wp_nonce_field('regularboard');echo '<input type="hidden" value="" name="LINK" /><input type="hidden" value="" name="PAGE" /><input type="hidden" value="" name="LOGIN" /><input type="hidden" value="" name="USERNAME" />';if($profilepassword == ''){$profilepassword = $rand;}echo '<section class="full"><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" /></section><section class="full"><textarea id="COMMENT" name="COMMENT" placeholder="Comment"></textarea></section><section class="formbottom">';if($enableurl == 1 && $THREAD == ''){echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$thisimageupload.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';}if($enablerep == 1 && $THREAD != ''){echo '<section class="attachURL"><input type="text" id="URL" maxlength="'.$maxtext.'" value="'.$thisimageupload.'" name="URL" placeholder=".jpg,gif,png/youtube/http" /></section>';}echo '<section class="email"><input type="text" id="EMAIL" maxlength="'.$maxtext.'" name="EMAIL" placeholder="heaven/sage/roll" value="';if($profileheaven == 1){echo 'heaven';}echo '" /></section>';if($THREAD != ''){echo '<section class="replytothis"><input type="text" id="REPLYTO" maxlength="'.$maxtext.'" name="REPLYTO" placeholder="No. ###" /></section>';}echo '</section><span id="count"></span><section class="full submission"><label for="FORMSUBMIT" class="submit">';if($THREAD != ''){echo 'Reply';}else{echo 'Post';}echo '</label><input type="submit" name="FORMSUBMIT" id="FORMSUBMIT" /></section></form></div>';if($AREA == 'newtopic'){echo '</div>';}
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
									}else{
										echo '<div class="tinythread">You were the last poster.  Edit your previous post or wait for a new post to comment further.</div>';
									}
								}
							}
						}
					}
				}
			}
		}
		$doesnotexist = 0;
	}
?>