<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	foreach($getUser as $banneddetails){
		$LENGTH = $banneddetails->LENGTH;
		$FILED = $banneddetails->DATE;
		if($LENGTH != 0){
			$DATEFILED = strtotime($banneddetails->DATE);
			$CURRENTDATE = strtotime($current_timestamp);
			if(strpos(strtolower($LENGTH),'minute')) {
				$bantime = intval($LENGTH) * 60;
			}elseif(strpos(strtolower($LENGTH),'hour')){
				$bantime = intval($LENGTH) * 60 * 60;
			}elseif(strpos(strtolower($LENGTH),'day')){
				$bantime = intval($LENGTH) * 60 * 60 * 24;
			}elseif(strpos(strtolower($LENGTH),'week')){
				$bantime = intval($LENGTH) * 60 * 60 * 24 * 7;
			}elseif(strpos(strtolower($LENGTH),'month')){
				$bantime = intval($LENGTH) * 60 * 60 * 24 * 7 * 30;
			}elseif(strpos(strtolower($LENGTH),'year')){
				$bantime = intval($LENGTH) * 60 * 60 * 24 * 7 * 30 * 365;
			}else{
				$bantime = intval($LENGTH) * 60;
			}
			$banIsActiveFor = ($DATEFILED + $bantime);
		}
		if($LENGTH == 0){
			$LENGTH = 'Permanent';
		}
		if($LENGTH != 0){
			if($CURRENTDATE > $banIsActiveFor){ 
				$banLifted = 1;
			}else{
				$banLifted = 0;
			}
		}else{
			$banLifted = 0;
		}
		echo '<div class="tinythread"><span class="tinysubject">'.$bannedmessage.'</span></div><div class="tinycomment"><div class="commentMeta">';
		foreach($getUser as $gotUser){
			$BANID = intval($gotUser->ID);
			$IP = intval($gotUser->IP);
			$BANNED = intval($gotUser->BANNED);
			$MESSAGE = myoptionalmodules_sanistripents($gotUser->MESSAGE);
			$MESSAGE = rb_format($MESSAGE);
			if($MESSAGE == ''){
				$MESSAGE = '<em>No reason given</em>';
			}
			echo '<span><i class="fa fa-user"> Your IP: '.$ipaddress.'</i></span><span><i class="fa fa-clock-o"> Length: '.$LENGTH.'</i></span></div>';
			echo '<p>You have been banned from using these boards';
			if ($LENGTH === 'Permanent'){
				echo ' permanently';
			}
			if ($LENGTH !== 'Permanent'){
				echo ' for '.$LENGTH;
			}
			echo '.  Your ban was filed on '.$FILED.'.  The reason given for your ban was:</p><p>'.$MESSAGE.'</p><p>If you wish to appeal this ban, please e-mail the moderators of this board with the following ID: '.$BANID.', with the subject line <em>Ban Appeal</em>, and someone will get back to you shortly.  If there is no moderation e-mail on file, there is nothing more for you to do here.</p><p>Have a nice day.</p>';
			echo '</div>';
		}
		echo '</div>';
		if($LENGTH != 0){
			if($banLifted == '1'){
				$wpdb->delete( ''.$regularboard_users.'', array('ID' => ''.$BANID.'','BANNED' => '1'),array( '%d','%d') );
			}
		}
	}
	
?>