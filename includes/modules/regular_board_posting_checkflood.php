<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	if(count($getLastPost) > 0){
		if($userflood != ''){
			$userflood = array($userflood);
			$MYID = $current_user->user_login;
		}
		foreach($getLastPost as $lastPost){
			$MODERATOR = $lastPost->MODERATOR;
			if($userflood != '' && in_array($MYID,$userflood) || current_user_can('manage_options')){
				$timegateactive = false;
			}else{
				$time = $lastPost->DATE;
				$postedOn = strtotime($time);
				$currently = strtotime($current_timestamp);
				$timegate = $currently - $postedOn;
				if($timegate < 10){
					$timegateactive = true;
				}
			}
		}
	}

?>