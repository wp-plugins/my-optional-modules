<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	$checkforupvote = 0;
	$checkfordownvote = 0;
	$getvotestatus = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND THREAD = '".$THREAD."'");
	$getthreadkarma = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
	foreach($getthreadkarma as $karma){
		$points = intval($karma->UP);
		$user = intval($karma->USERID);
	}
	foreach($getvotestatus as $votestatus){
		if($votestatus->MESSAGE == 'Upvote'){
			$checkforupvote++;
		}
		if($votestatus->MESSAGE == 'Downvote'){
			$checkfordownvote++;
		}
	}
	if($VOTE == 2){
		$getUP = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
		foreach($getUP as $gotUP){
			$UP = $gotUP->UP;
			$up = $UP + 1;
			$down = $UP - 1;
		}
		$getUSER = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
		foreach($getUSER as $USERED){
			$KARMA = $USERED->KARMA;
			$kup = $KARMA + 1;
			$kdown = $KARMA - 1;
		}
		if($checkfordownvote > 0){
			$wpdb->delete( $regularboard_users, array( 'THREAD' => $THREAD, 'IP' => $theIP_us32str),array( '%d','%d') );
			$wpdb->update( $regularboard_posts, array( 'UP' => $up ), array( 'ID' => $THREAD), array( '%d') );
			$wpdb->update( $regularboard_users, array( 'KARMA' => $kup ), array( 'ID' => $user, 'BANNED' => '8'), array( '%d','%d') );
			echo '<span class="points">'.($points + 1).'</span>';
		}
		if($checkfordownvote == 0){
			$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','$THREAD','0','9','Downvote','','0','','0','0','','')");
			$wpdb->update( $regularboard_posts, array( 'UP' => $down ), array( 'ID' => $THREAD), array( '%d') );
			$wpdb->update( $regularboard_users, array( 'KARMA' => $kdown ), array( 'ID' => $user, 'BANNED' => '8'), array( '%d') );
			echo '<span class="points">'.($points - 1).'</span>';
		}
	}
	if($VOTE == 1){
		$getUP = $wpdb->get_results("SELECT UP FROM $regularboard_posts WHERE ID = '".$THREAD."' LIMIT 1");
		foreach($getUP as $gotUP){
			$UP = $gotUP->UP;
			$up = $UP + 1;
			$down = $UP - 1;
		}
		$getUSER = $wpdb->get_results("SELECT KARMA FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = '8' LIMIT 1");
		foreach($getUSER as $USERED){
			$KARMA = $USERED->KARMA;
			$kup = $KARMA + 1;
			$kdown = $KARMA - 1;
		}
		if($checkforupvote > 0){
			$wpdb->delete($regularboard_users, array('THREAD' => $THREAD, 'IP' => $theIP_us32str),array( '%d','%d') );
			$wpdb->update($regularboard_posts, array( 'UP' => $down ), array( 'ID' => $THREAD), array( '%d') );
			$wpdb->update($regularboard_users, array( 'KARMA' => $kdown ), array( 'IP' => $theIP_us32str, 'BANNED' => '8'), array( '%d','%d') );
			echo '<span class="points">'.($points - 1).'</span>';
		}
		if($checkforupvote == 0){
			$wpdb->query("INSERT INTO $regularboard_users (ID, DATE, IP, THREAD, PARENT, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING) VALUES ('','$current_timestamp','$theIP_us32str','$THREAD','0','9','Upvote','','0','','0','0','','')");
			$wpdb->update($regularboard_posts, array( 'UP' => $up ), array( 'ID' => $THREAD), array( '%d') );
			$wpdb->update($regularboard_users, array( 'KARMA' => $kup ), array( 'IP' => $theIP_us32str, 'BANNED' => '8'), array( '%d') );
			echo '<span class="points">'.($points + 1).'</span>';
		}
	}
	echo '</div>';
		
?>