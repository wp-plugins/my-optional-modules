<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	
	if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE.'?b='.$BOARD;}
	if($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;}
	echo '<form name="regularboardsearch" id="tinysearch" method="post" action="'.$ACTION.'">';wp_nonce_field('regularboardsearch');echo '<input type="text" name="boardsearch" id="boardsearch" placeholder="Search ';if($THREAD == ''){echo $BOARD;}if($THREAD != ''){echo 'this thread';} echo ' for..." /><input type="submit" class="hidden" id="searchsub" name="searchsub" value="Search" /></form>';
	if($lock == 1)echo '<div class="tinythread"><span class="tinysubject">This board is currently locked.</span></div>';
	if($THREAD == '' && $BOARD != ''){echo '<div class="tinythread"><span class="tinysubject">Thread</span><span class="tinyreplies">Replies</span><span class="tinydate">Age</span></div>';}
	
	foreach($getposts as $posts){
			$loadme = $imageboard_subject = $TYPE = $URL = $thread_url = $COMMENT = $SUBJECT = $gotModReply = $thread_url = $title = $ID = $thread_reply = $IP = $locked = $sticky = $date = $MODERATOR = $PARENT = $VUP = $board = $EMAIL = $USERID = $name = '';
			$SUBJECT = $posts->SUBJECT;
			$checkforupvote = $checkfordownvote = $threads = 0;
			$getReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = $posts->ID");
			$getvotestatus = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = $theIP_us32str AND THREAD = $posts->ID");
			if($SEARCH != '' && $THREAD != '')$gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ( EMAIL = '".$SEARCH."' OR COMMENT LIKE '%".$SEARCH."%' OR SUBJECT LIKE '%".$SEARCH."%' OR URL LIKE '%".$SEARCH."%' ) AND PARENT = $posts->ID ORDER BY LAST ASC");
			if($SEARCH == '' && $THREAD != '')$gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = $posts->ID ORDER BY LAST ASC");
			if($THREAD != '')$gotReply = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE REPLYTO = $posts->ID ORDER BY REPLYTO DESC");
			if($THREAD != ''){$title = $posts->SUBJECT;if($title == ''){$title = 'No subject';}$title = str_replace('\\','',$title);echo '<script type="text/javascript">document.title = \''.$title.'\';</script>';}
			if($SEARCH != '' && $THREAD != '')echo '<hr /><em>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i> Searching this thread for '.$SEARCH.'.  Returned '.count($gotReplies).' results.</em><hr />';
			$thread_reply = '<span><i class="fa fa-angle-right"> No. <a href="#COMMENTFORM" onclick="replyThis(event)">'.$posts->ID.'</a></i></span> ';
			$date = '<span class="tinydate">'.timesincethis($posts->DATE).' <a href="?t='.intval($posts->ID).'">##</a></span>';
			if($posts->STICKY == 1){$sticky = '<span><i class="fa fa-thumb-tack"></i></span>';}if($posts->STICKY == 0){$sticky = '<span><i class="fa fa-thumb-tack faded"></i></span>';}if($posts->LOCKED == 1){$locked = '<span><i class="fa fa-lock"></i></span>';}if($posts->LOCKED == 0){$locked = '<span><i class="fa fa-unlock"></i></span>';}
			if(strtolower($posts->EMAIL) != 'heaven'){if($posts->MODERATOR == 1){$name = '<a class="mod" href="'.$profilelink.'"> '.$posts->USERID.'</a>';}if($posts->MODERATOR == 2){$name = '<a class="usermod" href="'.$profilelink.'"> '.$posts->USERID.'</a>';}if($posts->MODERATOR == 0){$name = '<a href="'.$profilelink.'"> '.$posts->USERID.'</a>';}}
			else{$name = ' --- ';}
			if($posts->TYPE == 'URL' && $posts->URL != '')$thread_url = '<a class="opURL" href="'.esc_url($posts->URL).'"><i class="fa fa-link"></i></a>';
			$COMMENT = rb_format($posts->COMMENT);
			$SUBJECT = $SUBJECT;
			if($SUBJECT == ''){$SUBJECT = 'No subject';}else{$SUBJECT = $SUBJECT;}
			foreach($getvotestatus as $votestatus){if($votestatus->MESSAGE == 'Upvote'){$checkforupvote++;}if($votestatus->MESSAGE == 'Downvote'){$checkfordownvote++;}}
			$totalREPLIES = count($getReplies);
			if($THREAD == ''){$thread_reply_link = '<span><i class="fa fa-reply"> <a href="?b='.$posts->BOARD.'&amp;t='.$posts->ID.'">Reply</a> ('.count($getReplies).')</i></span>';}
			if($posts->TYPE == 'image'){$THREADIMGS++;}
			if($THREAD == ''){$loadme = '<i id="'.$posts->ID.'" class="fa fa-plus-square loadme hidden" data="'.$THISPAGE.'?t='.$posts->ID.'"></i><i id="'.$posts->ID.'" class="fa fa-minus-square hideme hidden"></i>';}
			if($posts->TYPE == 'video'){$vidimg = '<img class="tinyvid" src="http://img.youtube.com/vi/'.$posts->URL.'/0.jpg" />';}
			else{$vidimg = '';}																
			if($posts->PARENT == 0){if($posts->MODERATOR == 0){$getModReply = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$posts->ID."' AND MODERATOR = '1' LIMIT 1");}if($posts->MODERATOR != 0){$getModReply = 0;}if(count($getModReply) > 0 && $getModReply != 0){$gotModReply = ' modreplied';}if($gotModReply != ''){$modishere = ' <i class="fa fa-star"></i>';}$SUBJECT =  '<span class="tinysubject'.$gotModReply.'">'.$thread_url.$vidimg.'<a href="?b='.$posts->BOARD.'&amp;t='.$posts->ID.'#'.$posts->ID.'">'.$modishere.$SUBJECT.'</a> '.$loadme.'</span>';}
			else{$SUBJECT =  '<span class="tinysubject">'.$thread_url.$vidimg.'<a href="?b='.$posts->BOARD.'&amp;t='.$posts->PARENT.'#'.$posts->ID.'#'.$posts->ID.'">'.$SUBJECT.'</a> '.$loadme.'</span> <a href="?b='.$posts->BOARD.'">'.$posts->BOARD.'</a></span>';}
			if($posts->URL != '' && $posts->TYPE == 'image'){$op_embed = '<a href="'.$posts->URL.'"><img class="imageOP" src="'.$posts->URL.'" alt="'.$posts->URL.'" /></a>';}
			elseif($posts->TYPE == 'video' && $posts->URL != ''){if($profilevideo == 0){$op_embed = '<iframe src="http://www.youtube.com/embed/'.$posts->URL.'?loon=1&amp;playlist='.$posts->URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" width="420" height="315" frameborder="0" allowfullscreen></iframe>';}elseif($profilevideo ==1){$op_embed = '<a class="rb_yt" data="'.$posts->URL.'" href="http://youtube.com/watch?v='.$posts->URL.'"><img class="ytthumb" src="http://img.youtube.com/vi/'.$posts->URL.'/0.jpg"></a><div id="'.$posts->URL.'"></div>';}}
			else{$op_embed = '';}
			$imageboard_subject = $SUBJECT.$op_embed;
			if($checkforupvote > 0 && $checkfordownvote == 0){$op_approval_button = '<label for="APPROVE'.$posts->ID.'" id="'.$posts->ID.'" data="'.$THISPAGE.'?t='.$posts->ID.'&amp;a=vote&amp;v=1"><i class="fa fa-thumbs-up"></i></label>';}
			elseif($checkforupvote == 0 && $checkfordownvote > 0){$op_approval_button = '';}
			else{$op_approval_button = '<label for="APPROVE'.$posts->ID.'" id="'.$posts->ID.'" data="'.$THISPAGE.'?t='.$posts->ID.'&amp;a=vote&amp;v=1"><i class="fa fa-thumbs-o-up"></i></label>';}
			if($checkfordownvote > 0 && $checkforupvote == 0){$op_disapproval_button = '<label for="DISAPPROVE'.$posts->ID.'" id="'.$posts->ID.'" data="'.$THISPAGE.'?t='.$posts->ID.'&amp;a=vote&amp;v=2"><i class="fa fa-thumbs-down"></i></label>';}
			elseif($checkfordownvote == 0 && $checkforupvote > 0){$op_disapproval_button = '';}
			else{$op_disapproval_button = '<label for="DISAPPROVE'.$posts->ID.'" id="'.$posts->ID.'" data="'.$THISPAGE.'?t='.$posts->ID.'&amp;a=vote&amp;v=2"><i class="fa fa-thumbs-o-down"></i></label>';}
			if($THREAD == ''){$thread_header = '<div class="tinythread" id="thread'.$posts->ID.'">'.$SUBJECT.'<span class="tinyreplies">'.$totalREPLIES.'</span>'.$date.'<div id="load'.$posts->ID.'"></div></div>';}
			if($THREAD != ''){$thread_header = '<div class="tinythread" id="thread'.$posts->ID.'">'.$SUBJECT.'</div>';}
			echo $thread_header;if($THREAD != ''){echo '<div class="tinycomment" id="'.$posts->ID.'">'.$op_embed.$COMMENT.'<hr class="clear" />';if($COMMENT != ''){ echo '<i id="'.$posts->ID.'" class="fa fa-plus-square srcme hidden" data="'.$THISPAGE.'?t='.$posts->ID.'"> show source</i><i id="'.$posts->ID.'" class="fa fa-minus-square srchideme hidden"> hide source</i><div id="src'.$posts->ID.'"></div><hr />'; }echo '<div class="approvalrating" id="rating'.$posts->ID.'">'.$op_approval_button.$op_disapproval_button.$posts->UP.'</div><div class="tinymeta">'.$sticky.$locked.'</div><div class="tinymeta"><span class="tinyname">'.$name.'</span></div><div class="tinymeta full">'.$date.'</div></div>';echo '<div class="omitted'.$posts->ID.'" id="omitted">';}

			if(count($gotReplies) > 0 && $THREAD != ''){
				foreach($gotReplies as $replies){
					$THREADREPLIES++;
					$checkforupvote = $checkfordownvote =  0;
					$reply_attached_link = $reply_embed = $imgclass = $reply_date = $reply_attached_link = '';
					$gotReply = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE REPLYTO = $replies->ID ORDER BY REPLYTO DESC");
					$getvotestatus = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '$theIP_us32str' AND THREAD = $replies->ID");
					if($replies->MODERATOR == 1 && strtolower($replies->EMAIL) != 'heaven'){$reply_name = '<a class="mod" href="'.$profilelink.'"> '.$replies->USERID.'</a>';}
					if($replies->MODERATOR == 2 && strtolower($replies->EMAIL) != 'heaven'){$reply_name = '<a class="usermod" href="'.$profilelink.'"> '.$replies->USERID.'</a>';}
					if(strtolower($replies->EMAIL) == 'heaven'){$reply_name = ' ???';}
					if($replies->MODERATOR != 1 && $replies->MODERATOR != 2){$reply_name = '<a href="'.$profilelink.'"> '.$replies->USERID.'</a>';}
					foreach($getvotestatus as $votestatus){if($votestatus->MESSAGE == 'Upvote'){$checkforupvote++;}if($votestatus->MESSAGE == 'Downvote'){$checkfordownvote++;}}
					if($checkforupvote > 0 && $checkfordownvote == 0){$reply_approval_button = '<label for="APPROVE'.$replies->ID.'" id="'.$replies->ID.'" data="'.$THISPAGE.'?t='.$replies->ID.'&amp;a=vote&amp;v=1"><i class="fa fa-thumbs-up"></i></label>'; }
					elseif($checkforupvote == 0 && $checkfordownvote > 0){$reply_approval_button = ''; }
					else{$reply_approval_button = '<label for="APPROVE'.$replies->ID.'" id="'.$replies->ID.'" data="'.$THISPAGE.'?t='.$replies->ID.'&amp;a=vote&amp;v=1"><i class="fa fa-thumbs-o-up"></i></label>'; }
					if($checkfordownvote > 0 && $checkforupvote == 0){$reply_disapproval_button = '<label for="DISAPPROVE'.$replies->ID.'" id="'.$replies->ID.'" data="'.$THISPAGE.'?t='.$replies->ID.'&amp;a=vote&amp;v=2"><i class="fa fa-thumbs-down"></i></label>';}
					elseif($checkfordownvote == 0 && $checkforupvote > 0){$reply_disapproval_button = '';}
					else{$reply_disapproval_button = '<label for="DISAPPROVE'.$replies->ID.'" id="'.$replies->ID.'" data="'.$THISPAGE.'?t='.$replies->ID.'&amp;a=vote&amp;v=2"><i class="fa fa-thumbs-o-down"></i></label>';}
					$reply_date = timesincethis($replies->DATE);
					if($replies->TYPE == 'image'){$THREADIMGS++;}
					if($replies->TYPE == 'URL' && $replies->URL != '')$reply_attached_link = '<span><i class="fa fa-angle-right"> <a href="'.esc_url($replies->URL).'">Attached link</a></i></span>';
					$SUBJECT  = '<span>'.$replies->SUBJECT.'</span>';
					$COMMENT = rb_format($replies->COMMENT);
					$postNo = '<span><i class="fa fa-angle-right"> No. <a href="#COMMENTFORM" onclick="replyThis(event)">'.$replies->ID.'</a></i></span>';
					$thread_karma = '<span><i class="fa fa-heart"> '.intval($replies->UP).'</i></span>';
					if($replies->URL != '' && $replies->TYPE == 'image'){if($COMMENT != ''){$imgclass = 'REPLY';}if($COMMENT == ''){$imgclass = 'OP';}$reply_embed = '<a href="'.$replies->URL.'"><img class="image'.$imgclass.'" alt="'.$replies->URL.'" src="'.$replies->URL.'"/></a>'; }
					elseif($replies->TYPE == 'video' && $replies->URL != ''){if($profilevideo == 0){$reply_embed = '<iframe src="http://www.youtube.com/embed/'.$replies->URL.'?loop=1&amp;playlist='.$replies->URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" width="420" heigh="315" frameborder="0" allowfullscreen></iframe>';}elseif($profilevideo == 1){$reply_embed = '<a class="rb_yt" data="'.$replies->URL.'" href="http://youtube.com/watch?v='.$replies->URL.'"><img class="ytthumb" src="http://img.youtube.com/vi/'.$replies->URL.'/0.jpg"></a><div id="'.$replies->URL.'"></div>';}}
					echo '<div class="tinycomment below" id="'.$replies->ID.'">';
					if(count($gotReply) > 0){echo '<span class="tinycreplies">'.$replies->ID.' '; foreach($gotReply as $replyid){ $replychild = intval($replyid->ID); $replyparent = intval($replyid->PARENT); $replyboard = strtolower($replyid->BOARD); $reply_link = '?b='.$replyboard.'&amp;t='.$replyparent.'&amp;'.$replychild.'#'.$replychild.'">'.$replychild; echo '<i class="fa fa-reply"> <a href="'.$reply_link.'</i></a>';} echo '</span>';}
					echo '<div class="meta">'.$SUBJECT.$postNo.$reply_attached_link;if($replies->REPLYTO != 0){echo ' <span><a href="?b='.$BOARD.'&amp;t='.$THREAD.'&amp'.$replies->REPLYTO.'#'.$replies->REPLYTO.'"><i class="fa fa-angle-double-right">'.$replies->REPLYTO.'</i></a></span>';}echo '</div>'.$reply_embed.$COMMENT.'<hr class="clear" />';
					if($COMMENT != ''){ echo '<i id="'.$replies->ID.'" class="fa fa-plus-square srcme hidden" data="'.$THISPAGE.'?t='.$replies->ID.'"> show source</i><i id="'.$replies->ID.'" class="fa fa-minus-square srchideme hidden"> hide source</i><div id="src'.$replies->ID.'"></div><hr />'; }
					echo '<div class="approvalrating" id="rating'.$replies->ID.'">'.$reply_approval_button.$reply_disapproval_button.intval($replies->UP).'</div><div class="tinymeta"><!--reply_meta--></div><div class="tinymeta"><span class="tinyname">'.$reply_name.'</span></div><div class="tinymeta full"><span class="tinydate">'.$reply_date.'  <a href="?t='.$replies->ID.'">##</a></span></div></div>';
				}
			}
		}
	
	if($BOARD != '' && $THREAD == ''){
		$i       = 0;
		$results = intval($_GET['n']);
		$paging  = round($totalpages / $postsperpage);
		if($paging > 0){$pageresults = round($paging / 10);echo '<div class="pages">';if($results > 1) echo '<a href="?b='.$BOARD.'">Latest</a> ';if($results > 2)echo '<a href="?b='.$BOARD.'&amp;n='.($results - 1).'">Newer</a> ';if($results < $paging && $results == '')echo '<a href="?b='.$BOARD.'&amp;n=2">Older</a> ';if($results < $paging && $results != '')echo '<a href="?b='.$BOARD.'&amp;n='.($results + 1).'">Older</a> ';echo '</div>';}
	}
	$threadexists = 1;
	
	?>