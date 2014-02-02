<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	echo '<table class="stats">';
	if(count($getBoards) > 0){
		echo '<tr valign="top"><td><strong>Board</strong></td><td><strong>10 minutes</strong></td><td><strong>2 hours</strong></td><td><strong>12 hours</strong></td><td><strong>1 day</strong></td><td><strong>Posts (all)</strong></td><td><strong>Mod posts (all)</strong></td><td><strong>User posts (all)</strong></td><td><strong>You</strong></td></tr>';
		foreach($getBoards as $gotBoards){
			echo '<tr valign="top">';
			$BOARDNAME = esc_sql(myoptionalmodules_sanistripents($gotBoards->SHORTNAME));
			$BOARDLONG = esc_sql(myoptionalmodules_sanistripents($gotBoards->NAME));
			$countPosts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."'");
			$min10_t = 0;
			$hou02_t = 0;
			$hou12_t = 0;
			$hou24_t = 0;
			$count = 0;
			$mod = 0;
			$usr = 0;
			$iposted = 0;
			$currently = strtotime($current_timestamp);
			foreach($countPosts as $counted){
				$timedif = strtotime($counted->DATE);
				$moderator = $counted->MODERATOR;
				$type = $counted->TYPE;
				if($currently - 600 <= $timedif && $timedif + 600 >= $currently){
					$min10_t++;
				}
				if($currently - 7200 <= $timedif && $timedif + 7200 >= $currently){
					$hou02_t++;
				}
				if($currently - 43200 <= $timedif && $timedif + 43200 >= $currently){
					$hou12_t++;
				}
				if($currently - 86400 <= $timedif && $timedif + 86400 >= $currently){
					$hou24_t++;
				}
				if($moderator >  0){
					$mod++;
				}
				if($moderator == 0){
					$usr++;
				}
				if($counted->IP == $theIP_us32str){
					$iposted++;
				}
				$count++;
			}
			echo '<td><a href="?b='.$BOARDNAME.'">'.$BOARDNAME.'</a></td>';
			echo '<td>'.$min10_t.'</td><td>'.$hou02_t.'</td><td>'.$hou12_t.'</td><td>'.$hou24_t.'</td><td>'.$count.'</td><td>'.$mod.'</td><td>'.$usr.'</td><td>'.$iposted.'</td>';
			echo '</tr>';
		}
	}
	echo '</table></div>';

?>