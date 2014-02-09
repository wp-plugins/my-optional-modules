<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	
	if(count($post) > 0){
		foreach($post as $p){
			$shortname = esc_sql($p->BOARD);
			$checklogged = $wpdb->get_results("SELECT * FROM $regularboard_boards WHERE SHORTNAME = '$shortname' LIMIT 1");
			foreach($checklogged as $LOGGED){if($LOGGED->LOGGED == 1){$requirelogged = 1;}}
			if(!is_user_logged_in() && $requirelogged == 1){echo '<div class="tinythread"><span class="tinysubject">You are not logged in.</span></div>';}
			else{
				$NAME = $LINK = $SUBJECT = $COMMENT = $EMBED = $NO = $IMGCLASS = '';
				$gotReply = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE REPLYTO = $p->ID AND PUBLIC = 1 ORDER BY REPLYTO DESC");
				
				if(is_numeric($p->EMAIL)){
					$NAME = $p->EMAIL;
				}elseif(strtolower($p->EMAIL) != 'heaven'){ 
					if($p->MODERATOR == 1){
						$NAME = '<a class="mod" href="'.$profilelink.'"> '.$p->USERID.'</a>';
					} 
					if($p->MODERATOR == 2){
						$NAME = '<a class="usermod" href="'.$profilelink.'"> '.$p->USERID.'</a>';
					} 
					if($p->MODERATOR == 0){
						$NAME = '<a href="'.$profilelink.'"> '.$p->USERID.'</a>';
					} 
				}
				
				else{$NAME = '---';}
				if($p->TYPE == 'URL' && $p->URL != '')$LINK = '<span><i class="fa fa-angle-right"> <a href="'.esc_url($p->URL).'">Attached link</a></i></span>';
				$SUBJECT = rb_format('<span>'.$p->SUBJECT.'</span>');
				$COMMENT = rb_format($p->COMMENT);
				if($p->PARENT == 0) $perma = '?b='.$p->BOARD.'&amp;t='.$p->ID;
				if($p->PARENT != 0) $perma = '?b='.$p->BOARD.'&amp;t='.$p->PARENT.'#'.$p->ID;
				if($p->REPLYTO != 0) $REPLYINGTO = '<p> >><a href="?t='.$p->REPLYTO.'">'.$p->REPLYTO.'</a></p>';
				$NO = '<span><i class="fa fa-angle-right"> No. <a href="'.$perma.'">'.$p->ID.'</a></i></span>';
				if($p->URL != '' && $p->TYPE == 'image'){if($p->COMMENT != ''){$IMGCLASS = 'REPLY';}if($p->COMMENT == ''){$IMGCLASS = 'OP';}$EMBED = '<a href="'.$p->URL.'"><img class="image'.$IMGCLASS.'" alt="'.$p->URL.'" src="'.$p->URL.'"/></a>'; }
				elseif($p->TYPE == 'video' && $p->URL != ''){if($profilevideo == 0){$EMBED = '<iframe src="http://www.youtube.com/embed/'.$p->URL.'?loop=1&amp;playlist='.$p->URL.'&amp;controls=0&amp;showinfo=0&amp;autohide=1" width="420" height="315" frameborder="0" allowfullscreen></iframe>'; }elseif($profilevideo == 1){$EMBED = '<a class="rb_yt" data="'.$p->URL.'" href="http://youtube.com/watch?v='.$p->URL.'"><img class="ytthumb" src="http://img.youtube.com/vi/'.$p->URL.'/0.jpg"></a><div id="'.$p->URL.'"></div>';}}
				echo '<div class="tinycomment below" id="'.$p->ID.'">';
				if(count($gotReply) > 0){
					echo '<p>Replies: '; 
					foreach($gotReply as $replyid){
						if($replyid->PARENT == 0)$reply_link = '?b='.$replyid->BOARD.'&amp;t='.$replyid->ID.'">'.$replyid->ID;
						if($replyid->PARENT != 0)$reply_link = '?b='.$replyid->BOARD.'&amp;t='.$replyid->PARENT.'&amp;'.$replyid->ID.'#'.$replyid->ID.'">'.$replyid->PARENT;
						echo ' >><a href="'.$reply_link.'</i></a>'; 
					}
					echo '</p>'; 
				}
				$checkforupvote = $checkfordownvote = 0;
				$getvotestatus = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = $theIP_us32str AND THREAD = $p->ID");
				foreach($getvotestatus as $votestatus){if($votestatus->MESSAGE == 'Upvote'){$checkforupvote++;}if($votestatus->MESSAGE == 'Downvote'){$checkfordownvote++;}}				
				if($checkforupvote > 0 && $checkfordownvote == 0){$op_approval_button = '<label for="APPROVE'.$p->ID.'" id="'.$p->ID.'" data="'.$THISPAGE.'?t='.$p->ID.'&amp;a=vote&amp;v=1"><i class="fa fa-thumbs-up"></i></label>';}
				elseif($checkforupvote == 0 && $checkfordownvote > 0){$op_approval_button = '';}
				else{$op_approval_button = '<label for="APPROVE'.$p->ID.'" id="'.$p->ID.'" data="'.$THISPAGE.'?t='.$p->ID.'&amp;a=vote&amp;v=1"><i class="fa fa-thumbs-o-up"></i></label>';}
				if($checkfordownvote > 0 && $checkforupvote == 0){$op_disapproval_button = '<label for="DISAPPROVE'.$p->ID.'" id="'.$p->ID.'" data="'.$THISPAGE.'?t='.$p->ID.'&amp;a=vote&amp;v=2"><i class="fa fa-thumbs-down"></i></label>';}
				elseif($checkfordownvote == 0 && $checkforupvote > 0){$op_disapproval_button = '';}
				else{$op_disapproval_button = '<label for="DISAPPROVE'.$p->ID.'" id="'.$p->ID.'" data="'.$THISPAGE.'?t='.$p->ID.'&amp;a=vote&amp;v=2"><i class="fa fa-thumbs-o-down"></i></label>';}
				
				
				echo '<div class="meta">'.$SUBJECT.$NO.$LINK.'</div>'.$EMBED.$REPLYINGTO.$COMMENT.'<hr class="clear" />
				<div class="approvalrating" id="rating'.$p->ID.'">'.$op_approval_button.$op_disapproval_button.$p->UP.'</div>
				<div class="tinymeta"><span class="tinyname">'.$NAME.'</span></div>
				<div class="tinymeta full"><span class="tinydate">'.timesincethis($p->DATE).'</span></div>
				</div>
				<div class="tinythread"><span class="tinysubject">For display purposes only.  Click <a href="'.$perma.'">here</a> to be taken to this thread.</span></div>';
				echo '<hr />';
				if($p->COMMENT != ''){
					echo '<div class="tinythread"><span class="tinysubject">Source:</span></div>
					<div class="tinycomment src"><textarea class="src">'.str_replace(array('[',']','\n','\r','\\'),array('&#91;','&#93;','','',''),$p->COMMENT).'</textarea></div>';
				}
				
				
			}
		}
	}else{
		if($notfound != '')echo '<img src="'.$notfound.'" alt="404" class="404" />';
		rb_404();
	}						
	echo '</div>';
	
	?>