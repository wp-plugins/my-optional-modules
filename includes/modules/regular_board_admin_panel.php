<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	echo '<div class="tinystats">';
	if($ISMODERATOR === true){
		echo '<span class="adminnav"><a href="?a=create">Create/delete a board</a><a href="?a=bans">Manage bans</a><a href="?a=reports">View reports</a></span>';
		if($AREA == 'create'){
			if(isset($_POST['CREATEBOARD']) && $_REQUEST['SHORTNAME'] != strtolower('mainrules')){
				$LOCKED = intval($_REQUEST['LOCKED']);
				$LOGGED = intval($_REQUEST['LOGGED']);
				$MODS = esc_sql($_REQUEST['MODS']);
				$JANITORS = esc_sql($_REQUEST['JANITORS']);
				$NAME = myoptionalmodules_sanistripents($_REQUEST['NAME']);
				$SHORTNAME = esc_sql(myoptionalmodules_sanistripents(strtolower($_REQUEST['SHORTNAME'])));
				$DESCRIPTION = esc_sql($_REQUEST['DESCRIPTION']);
				$RULES = esc_sql($_REQUEST['RULES']);
				$SFW = esc_sql($_REQUEST['SFW']);
				$getBoards = $wpdb->get_results("SELECT SHORTNAME FROM $regularboard_boards WHERE SHORTNAME = '$SHORTNAME'");
				if(count($getBoards) == 0){$wpdb->query( $wpdb->prepare("INSERT INTO $regularboard_boards ( NAME, SHORTNAME, DESCRIPTION, RULES, SFW, MODS, JANITORS, POSTCOUNT, LOCKED, LOGGED ) VALUES ( %s, %s, %s, %s, %s, %s, %s, %d, %d, %d )", $NAME,$SHORTNAME,$DESCRIPTION,$RULES,$SFW,$MODS,$JANITORS,0,$LOCKED,$LOGGED));
			}else{
				$wpdb->delete( ''.$regularboard_boards.'', array('SHORTNAME' => ''.$SHORTNAME.''),array( '%s') );
				$wpdb->query( $wpdb->prepare("INSERT INTO $regularboard_boards ( NAME, SHORTNAME, DESCRIPTION, RULES, SFW, MODS, JANITORS, POSTCOUNT, LOCKED, LOGGED ) VALUES ( %s, %s, %s, %s, %s, %s, %s, %d, %d, %d )",$NAME,$SHORTNAME,$DESCRIPTION,$RULES,$SFW,$MODS,$JANITORS,0,$LOCKED,$LOGGED));
			}
		}
		if(isset($_POST['DELETEBOARD']) && $_REQUEST['DELETETHIS'] != '' ){
			$DELETETHIS = esc_sql(myoptionalmodules_sanistripents($_REQUEST['DELETETHIS']));
			$wpdb->delete( ''.$regularboard_posts.'', array('BOARD' => ''.$DELETETHIS.''),array( '%s') );
			$wpdb->delete( ''.$regularboard_boards.'', array('SHORTNAME' => ''.$DELETETHIS.''),array( '%s') );
			echo '<meta http-equiv="refresh" content="0;
			URL=?a=create">';
		}
		echo '<a class="boardedit" href="?a=create&amp;b=mainrules">Edit main rules</a>';
		if(count($getBoards) > 0){
			foreach($getBoards as $gotBoard){
				if($gotBoard->SHORTNAME != ''){
					$board = esc_sql($gotBoard->SHORTNAME);
					$name  = esc_sql($gotBoard->NAME);
					echo '<a class="boardedit" href="?a=create&amp;b='.$board.'">Edit '.$board.'</a>';
				}
			}
		}
		if($BOARD == ''){
			echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?a=create">';
			wp_nonce_field('createaboard');
			echo '<section class="full"><input type="text" name="SHORTNAME" id="SHORTNAME" placeholder="Shortname (cannot be mainrules - reserved name)" /></section><section class="full"><input type="text" name="NAME" id="NAME" placeholder="Expanded board name" /></section><section class="full"><input type="text" name="DESCRIPTION" id="DESCRIPTION" placeholder="Short description" /></section><section class="full"><input type="text" name="MODS" id="MODS" placeholder="User moderators" /></section><section class="full"><input type="text" name="JANITORS" id="JANITORS" placeholder="User janitors" /></section><section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board - leave shortname and expanded board name blank to create rules for the entire board."></textarea></section><section class="full"><select class="full" name="LOCKED" id="LOCKED"><option value="0">Posting enabled (board unlocked)</option><option value="1">Posting disabled (board locked)</option></select></section><section class="full"><select class="full" name="SFW" id="SFW"><option value="SFW">Safe-for-work (NSFW not allowed)</option><option value="NSFW">Not-Safe-For-Work</option></select></section><section class="full"><select class="full" name="LOGGED" id="LOGGED"><option value="0">Everyone may interact</option><option value="1">Logged-in users only</option></select></section><section class="full"><label class="create" for="CREATEBOARD">Create this board</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Create this board" /></section></form>';
		}elseif($BOARD == 'mainrules'){
			$editboard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '' LIMIT 1");
			foreach($editboard as $editBoard){
				echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?a=create">';
				wp_nonce_field('createaboard');
				echo '<section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board">'.str_replace(array('<p>','</p>','<br />'),'||',(str_replace(array('\\n','\\t','\\r'),'||',$editBoard->RULES))).'</textarea></section><section class="full"><label class="create" for="CREATEBOARD">Edit main rules</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Edit main rules" /></section></form>';
			}
		}else{
			$editboard = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '$BOARD' LIMIT 1");
			foreach($editboard as $editBoard){
				echo '<form method="post" class="COMMENTFORM boardcreation" name="createaboard" action="?a=create">';wp_nonce_field('createaboard');echo '<section class="full"><input type="text" value="'.$editBoard->SHORTNAME.'" name="SHORTNAME" id="SHORTNAME" placeholder="Shortname" /></section><section class="full"><input type="text" value="'.$editBoard->NAME.'"name="NAME" id="NAME" placeholder="Expanded board name" /></section><section class="full"><input type="text" value="'.$editBoard->DESCRIPTION.'"name="DESCRIPTION" id="DESCRIPTION" placeholder="Short description" /></section><section class="full"><input type="text" value="'.$editBoard->MODS.'"name="MODS" id="MODS" placeholder="User moderators" /></section><section class="full"><input type="text" value="'.$editBoard->JANITORS.'"name="JANITORS" id="JANITORS" placeholder="User janitors" /></section><section class="full"><textarea name="RULES" id="RULES" placeholder="Rules for this board">'.str_replace(array('<p>','</p>','<br />'),'||',(str_replace(array('\\n','\\t','\\r'),'||',$editBoard->RULES))).'</textarea></section><section class="full"><select class="full" name="LOCKED" id="LOCKED"><option  ';if($editBoard->LOCKED == 0){echo 'selected="selected" ';}echo 'value="0">Posting enabled (board unlocked)</option><option  ';if($editBoard->LOCKED == 1){echo 'selected="selected" ';} echo 'value="1">Posting disabled (board locked)</option></select></section><section class="full"><select class="full" name="SFW" id="SFW"><option ';if($editBoard->SFW == 'SFW'){ echo 'selected="selected" ';  } echo 'value="SFW">Safe-for-work (NSFW not allowed)</option><option ';if($editBoard->SFW == 'NSFW'){ echo 'selected="selected" ';  } echo 'value="NSFW">Not-Safe-For-Work</option></select></section><section class="full"><select class="full" name="LOGGED" id="LOGGED"><option ';if($editBoard->LOGGED == '0'){ echo 'selected="selected" ';  } echo 'value="0">Everyone may interact</option><option ';if($editBoard->LOGGED == '1'){ echo 'selected="selected" ';  } echo 'value="1">Logged-in users only</option></select></section><section class="full"><label class="create" for="CREATEBOARD">Edit this board</label><input class="hidden" type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Edit this board" /></section></form>';
			}
		}
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
			echo '</select><input type="submit" name="DELETEBOARD" id="DELETEBOARD" value="Nuke, Destroy, and Salt the Earth." /></form>';
			}
		}if($AREA == 'reports'){
			echo '<div class="boardreports"><div class="tinythread"><span class="tinysubject">Reason reported</span><span class="tinyreplies">Link</span><span class="tinydate">Actions</span></div><form name="reports" action="?a=reports" class="create" method="post">';
			wp_nonce_field('reports');
			if(count($getReports) > 0){
				foreach($getReports as $gotReports){
					$userIP = long2ip($gotReports->IP);
					$thisID = intval($gotReports->ID);
					$thisThread = intval($gotReports->THREAD);
					$thisParent = intval($gotReports->PARENT);
					$userMESSAGE = $gotReports->MESSAGE;
					$thisBoard = $gotReports->BOARD;
					if($thisParent== 0){
						$URL = '?b='.$thisBoard.'&amp;t='.$thisThread;
					}
					if($thisParent!= 0){
						$URL = '?b='.$thisBoard.'&amp;t='.$thisParent.'#'.$thisThread;
					}
					echo '<div class="tinythread"><span class="tinysubject">';
					if($userMESSAGE != ''){
						echo ''.$userMESSAGE.'';
					}
					if($userMESSAGE == ''){
						echo 'No reason given.';
					}
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
							$countreps = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = $thisThread AND PUBLIC = 1");
							foreach($countreps as $countedreplies){
								$delete++;
							}
							$wpdb->delete( ''.$regularboard_posts.'', array('PARENT' => ''.$thisThread.''),array( '%d') );
						}
						$wpdb->delete( ''.$regularboard_posts.'', array('ID' => ''.$thisThread.''),array( '%d' ) );
						$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$thisID.''),array( '%d' ) );
						$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT - $delete WHERE SHORTNAME = '$thisBoard'");
						echo '<div class="tinythread"><span class="tinysubject"><i class="fa fa-undo fa-spin"></i></span></div><meta http-equiv="refresh" content="0;URL=?a=reports">';
					}
				}
			}else{
				echo '<div class="tinythread"><span class="tinysubject">Nothing to see here!</span></div>';
			}echo '</form></div>';
		}if($AREA == 'bans'){
			if(isset($_POST['BAN']) && $_REQUEST['IP'] != ''){
				$IP = esc_sql(ip2long($_REQUEST['IP']));
				$ID2SET = 0;
				$PARENT = 0;
				$BOARD = '';
				$MESSAGE = ' (Banned by admin).';
				$LENGTH  = 0;
				$wpdb->query($wpdb->prepare("INSERT INTO $regularboard_users ( ID, DATE, IP, NAME, EMAIL, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) VALUES ( %d,%s,%d,%s,%s,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s,%s )",'',$current_timestamp,$IP,'','',$ID2SET,$PARENT,$BOARD,1,$MESSAGE,$LENGTH,0,'',0,0,'',''));
				echo '<meta http-equiv="refresh" content="0;URL=?a=bans">';
			}
			echo '<form method="post" id="createban" class="COMMENTFORM boardcreation" name="createban" action="?a=bans">';
			wp_nonce_field('createban');
			echo '<section class="full"><input type="text" name="IP" id="IP" placeholder="IP Address to ban (standard format or long format)" /></section><section class="full"><label class="create" for="BAN">Ban this IP</label><input class="hidden" type="submit" name="BAN" id="BAN" value="Ban this IP" /></section></form>';
			echo '<div class="boardreports"><div class="tinythread"><span class="tinysubject">Reason for ban</span><span class="tinyreplies">Ban ID</span><span class="tinydate">Actions</span></div><form name="unban" action="?a=bans" class="create" method="post">';
			wp_nonce_field('unban');
			if(count($getUsers) > 0){
				foreach($getUsers as $gotUsers){
					$userIP = long2ip($gotUsers->IP);
					$thisID = intval($gotUsers->ID);
					$userMESSAGE = $gotUsers->MESSAGE;
					echo '<div class="tinythread"><span class="tinysubject">';
					if($userMESSAGE != ''){
						echo '<span>'.$userMESSAGE.'</span>';
					}
					if($userMESSAGE == ''){
						echo '<span>No ban reason given.</span>';
					}
					echo '</span><span class="tinyreplies">'.$thisID.'</span><span class="tinydate"><label for="unban'.$thisID.'" class="button">[Unban '.$userIP.']</label><input class="hidden" type="submit" name="unban'.$thisID.'" id="unban'.$thisID.'" /></span></div>';
					if(isset($_POST['unban'.$thisID])){
						$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$thisID.'','BANNED' => '1'),array( '%d','%d') );
						echo '<div class="tinythread"><span class="tinysubject"><i class="fa fa-undo fa-spin"></i></span></div><meta http-equiv="refresh" content="0;URL=?a=bans">';
					}
				}
			}else{
				echo '<div class="tinythread"><span class="tinysubject">No bans (yet) - great!</span></div>';
			}
			echo '</form></div>';
		}
	}
	echo '</div></div>';

?>