<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	if(count($usprofile) > 0){
		foreach($usprofile as $theprofile){
			$userip = intval($theprofile->IP);
			$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE USERID = $PROFILE AND EMAIL != 'heaven' AND PUBLIC = 1");
			$totalpages = count($countpages);
			$results = intval($_GET['n']);
			if($results){
				$start = ($results - 1) * $postsperpage;
			}else{
				$start = 0;
			}
			$count = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE USERID = $PROFILE AND EMAIL != 'heaven' AND PUBLIC = 1 ORDER BY DATE DESC");
			$posts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE USERID = $PROFILE AND EMAIL != 'heaven' AND PUBLIC = 1 ORDER BY DATE DESC LIMIT $start,$postsperpage");
			$postcount = count($countpages);
			$userid = intval($theprofile->ID);
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
					echo '<div id="'.intval($thisuserposts->ID).'" class="tinythread">';
					$board = $thisuserposts->BOARD;
					$id = $thisuserposts->ID;
					$date = $thisuserposts->DATE;
					$parent = '';
					if($thisuserposts->PARENT == 0){
						$posttype = 'new thread';
					}
					if($thisuserposts->PARENT != 0){
						$posttype = 'new reply';
					}
					$bl = $wpdb->get_results("SELECT URL FROM $regularboard_boards WHERE SHORTNAME = '".$board."' LIMIT 1");
					if($thisuserposts->PARENT != 0){
						$parent = $thisuserposts->PARENT;
					}
					if($thisuserposts->PARENT  > 0){
						$parent = 't='.$parent.'#'.$id;
					}
					if($thisuserposts->PARENT == 0){
						$parent = 't='.$id;
					}
					$link = $THISPAGE.'?b='.$board.'&amp;'.$parent;
					$SUBJECT =  $thisuserposts->SUBJECT;
					echo '<span class="tinysubject"><a href="'.$link.'">';
					if($SUBJECT != ''){
						echo $SUBJECT;
					}else{
						echo 'No subject specified';
					}
					echo '</a><i id="'.$id.'" class="fa fa-plus-square loadme hidden" data="'.$THISPAGE.'?t='.$id.'"></i><i id="'.$id.'" class="fa fa-minus-square hideme hidden"></i></span></span><span class="tinyreplies">'.intval($thisuserposts->UP).'</span><span class="tinydate">'.timesincethis($date).' <a href="?t='.intval($thisuserposts->ID).'">##</a></span><div id="load'.$id.'"></div></div>';
				}
				echo '</div></div>';
			}else{
				echo '<div class="tinythread"><span class="tinysubject">User has not contributed anything.</span></div>';
			}
			echo '</div></div>';
		}
	}
	$i = 0;
	$results = intval($_GET['n']);
	$paging  = round($totalpages / $postsperpage);
	if($paging > 0){
		$pageresults = round($paging / 10);
		echo '<div class="pages">';
		if($results > 1) echo '<a href="?u='.$PROFILE.'">Latest</a> ';
		if($results > 2)echo '<a href="?b='.$PROFILE.'&amp;n='.($results - 1).'">Newer</a> ';
		if($paging > 1 && $results < $paging && $results == '')echo '<a href="?u='.$PROFILE.'&amp;n=2">Older</a> ';
		if($results < $paging && $results != ''){
			echo '<a href="?u='.$PROFILE.'&amp;n='.($results + 1).'">Older</a> ';
		}
		echo '</div>';
	}
	echo '</div>';

?>