<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	echo '<div class="tinythread"><span class="tinysubject">Users</span><span class="tinyreplies">Points</span><span class="tinydate">Member for</span></div>';
	if(count($getposts) > 0){
		foreach($getposts as $posts){
			$id = intval($posts->ID);
			$points = intval($posts->KARMA);
			$date = timesincethis($posts->DATE);
			echo '<div class="tinythread"><span class="tinysubject"><a href="?u='.$id.'">User '.$id.'</a>';if($ISMODERATOR == 1){ echo ' :: '.long2ip($posts->IP); }echo '</span><span class="tinyreplies">'.$points.'</span><span class="tinydate">'.$date.'</span></div>';
		}
	}
	$i = 0;
	$results = intval($_GET['n']);
	$paging  = round($totalpages / $postsperpage);
	if($paging > 0){
		$pageresults = round($paging / 10);
		echo '<div class="pages">';
		if($results > 1){
			echo '<a href="?a=users">Latest</a> ';
		}
		if($results > 2){
			echo '<a href="?a=users&amp;n='.($results - 1).'">Newer</a> ';
		}
		if($results < $paging && $results == ''){
			echo '<a href="?a=users&amp;n=2">Older</a> ';
		}
		if($results < $paging && $results != ''){
			echo '<a href="?a=users&amp;n='.($results + 1).'">Older</a> ';
		}
		echo '</div>';
	}
	echo '</div>';
	echo '<script type="text/javascript">document.title = \'All users\';</script>';
	
	?>