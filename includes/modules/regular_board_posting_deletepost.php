<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	$checkPassword = esc_sql($_REQUEST['DELETEPASSWORD']);
	$checkID = esc_sql(intval($_REQUEST['report_ids']));
	$checkPass = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PASSWORD = '".$checkPassword."' AND ID = $checkID AND PUBLIC = 1");
	$correct = 0;
	if(count($checkPass) > 0){
		foreach($checkPass as $checked){
			$PARENT = $checked->PARENT;
			$wpdb->query("DELETE FROM $regularboard_posts WHERE ID = $checkID AND PUBLIC = 1");
			if($PARENT == 0){
				$wpdb->query("DELETE FROM $regularboard_posts WHERE PARENT = $checkID AND PUBLIC = 1");
			}
			$correct = 1;
		}
	}
	if($BOARD != '' && $THREAD == ''){
		$REDIRECTO = $THISPAGE.'?b='.$BOARD;
	}
	if($BOARD != '' && $THREAD != ''){
		$REDIRECTO = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;
	}
	if($correct == 1 || $correct == 0){
		echo '<h3>';
		if($correct == 0){
			echo 'Wrong password.';
		}
		if($correct == 1){
			echo 'Post deleted!';
		}
		echo '<br />click <a href="'.esc_url($REDIRECTO).'">here</a> if you are not redirected.';
		echo '<meta http-equiv="refresh" content="5;URL= '.$REDIRECTO.'">';
		echo '</h3>';
	}

?>