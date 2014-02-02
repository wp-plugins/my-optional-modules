<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	
	if($AREA == '' || $AREA == 'topics')$areatitle = 'All topics';
	if($AREA == 'replies')$areatitle = 'All replies';
	if($AREA == 'all')$areatitle = 'All activity';
	if($AREA == 'subscribed')$areatitle = 'Subscribed activity';
	if($AREA == 'following')$areatitle = 'Followed activity';
	
	if(count($getBoards) == 1)echo '<div class="tinythread"><span class="tinysubject">'.$areatitle.'</span><span class="tinyreplies">Poster</span><span class="tinydate">Age</span></div>';
	if(count($getBoards) > 1)echo '<div class="tinythread"><span class="tinysubject">'.$areatitle.'</span><span class="tinyreplies">Board</span><span class="tinydate">Age</span></div>';
	
	if(count($getposts) > 0){
		foreach($getposts as $posts){
			if($posts->SUBJECT != ''){$subject = $posts->SUBJECT;}else{$subject = '<em>no subject</em>';}
			echo '<div class="tinythread"><span class="tinysubject">';
			if($posts->TYPE == 'video')echo '<img class="tinyvid" src="http://img.youtube.com/vi/'.$posts->URL.'/0.jpg" alt="Youtube thumbnail" />';
			if (get_domain($posts->URL) == 'imgur.com'){if($posts->TYPE == 'image')echo '<img class="tinyvid" src="http://i.imgur.com/'.str_replace('.','s.',substr($posts->URL,19)).'" height="15" width="auto" />';}
			else{if($posts->TYPE == 'image')echo '<img class="tinyvid" src="'.$posts->URL.'" height="15" width="auto" />';}
			
			if($posts->URL == ''){echo '<a href="?b='.$posts->BOARD.'&amp;';if($posts->PARENT == 0){echo 't='.$posts->ID.'#'.$posts->ID;}else{echo 't='.$posts->PARENT.'#'.$posts->ID;}echo '">';}
			if($posts->TYPE != 'video' && $posts->URL != ''){echo '<a href="?b='.$posts->BOARD.'&amp;';if($posts->PARENT == 0){echo 't='.$posts->ID.'#'.$posts->ID;}else{echo 't='.$posts->PARENT.'#'.$posts->ID;}echo '"><i class="fa fa-comment"></i></a> / <a href="'.esc_url($posts->URL).'">';}
			if($posts->TYPE == 'video' && $posts->URL != ''){echo '<a href="?b='.$posts->BOARD.'&amp;';if($posts->PARENT == 0){echo 't='.$posts->ID.'#'.$posts->ID;}else{echo 't='.$posts->PARENT.'#'.$posts->ID;}echo '"><i class="fa fa-comment"></i></a> / <a href="http://youtube.com/watch?v='.$posts->URL.'">';}
			
			echo $subject.'</a> <i id="'.$posts->ID.'" class="fa fa-plus-square loadme hidden" data="'.$THISPAGE.'?t='.$posts->ID.'"></i><i id="'.$posts->ID.'" class="fa fa-minus-square hideme hidden"></i></span>';
			if(count($getBoards) == 1) echo '<span class="tinyreplies">';if($posts->EMAIL != strtolower('heaven')){echo '<a href="?u='.$posts->USERID.'">'.$posts->USERID.'</a>';}else{echo '----';}echo '</span>';
			if(count($getBoards) > 1) echo '<span class="tinyreplies"><a href="?b='.$posts->BOARD.'">'.$posts->BOARD.'</a></span>';
			echo '<span class="tinydate">'.timesincethis($posts->DATE).'  <a href="?t='.$posts->ID.'">##</a></span><div id="load'.$posts->ID.'"></div></div>';
		}
	}
	$i = 0;
	$results = intval($_GET['n']);
	$paging  = round($totalpages / $postsperpage);
	if($AREA == '')if($paging > 0){$pageresults = round($paging / 10);echo '<div class="pages">';if($results > 1) echo '<a href="'.$THISPAGE.'">Latest</a> ';if($results > 2) echo '<a href="?n='.($results - 1).'">Newer</a> ';if($paging > 1 && $results < $paging && $results == '')echo '<a href="?n=2">Older</a> ';if($results < $paging && $results != '')echo '<a href="?n='.($results + 1).'">Older</a> ';echo '</div>';}
	if($AREA != '')if($paging > 0){$pageresults = round($paging / 10);echo '<div class="pages">';if($results > 1) echo '<a href="?a='.$AREA.'">Latest</a> ';if($results > 2) echo '<a href="?a='.$AREA.'&amp;n='.($results - 1).'">Newer</a> ';if($paging > 1 && $results < $paging && $results == '')echo '<a href="?a='.$AREA.'&amp;n=2">Older</a> ';if($results < $paging && $results != '')echo '<a href="?a='.$AREA.'&amp;n='.($results + 1).'">Older</a> ';echo '</div>';}
	echo '</div>';
	echo '<script type="text/javascript">document.title = \''.$areatitle.'\';</script>';

	?>