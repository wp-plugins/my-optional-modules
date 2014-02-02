<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	$ID2SET = $_REQUEST['admin_ids'];
	if(current_user_can('manage_options') || $ISUSERMOD === true){
		if(isset($_POST['admin_lock']) && $ID2SET != ''){
			$doLock = $wpdb->update($regularboard_posts,array('LOCKED' => 1),array('ID' => $ID2SET),array('%d'));
		}
		if(isset($_POST['admin_unlock']) && $ID2SET != ''){
			$doUnlock = $wpdb->update($regularboard_posts, array('LOCKED' => 0), array('ID' => $ID2SET),array('%d'));
		}
		if(isset($_POST['admin_sticky']) && $ID2SET != ''){
			$doSticky = $wpdb->update($regularboard_posts,array('STICKY' => 1), array('ID' => $ID2SET),array('%d'));
		}
		if(isset($_POST['admin_unsticky']) && $ID2SET != ''){
			$doUnsticky = $wpdb->update($regularboard_posts,array('STICKY' => 0), array('ID' => $ID2SET),array('%d'));
		}
	}
	if(isset($_POST['admin_delete']) && $ID2SET != ''){
		$delete = 0;
		$getIDfromID = $wpdb->get_results("SELECT PARENT FROM $regularboard_posts WHERE ID = $ID2SET LIMIT 1");
		if(current_user_can('manage_options')){
			$delete++;
			$wpdb->delete($regularboard_posts, array('ID' => $ID2SET),array('%d'));
			foreach($getIDfromID as $parentCheck){
				$delete++;
				$parent = $parentCheck->PARENT;
				if($PARENT == 0){
					$wpdb->delete($regularboard_posts,array('PARENT' => $ID2SET),array('%d'));
				}
			}
			$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT - ".$delete." WHERE SHORTNAME = '$BOARD'");
		}
		if($ISUSERMOD === true || $ISUSERJANITOR === true){
			$delete = 0;
			$wpdb->delete($regularboard_posts,array('ID' => $ID2SET,'MODERATOR' => 0),array('%d'));
			foreach($getIDfromID as $parentCheck){
				$delete++;
				$parent = $parentCheck->PARENT;
				if($PARENT == 0){
					$wpdb->delete($regularboard_posts,array('PARENT' => $ID2SET),array('%d'));
				}
			}
			$wpdb->query("UPDATE $regularboard_boards SET POSTCOUNT = POSTCOUNT - ".$delete." WHERE SHORTNAME = '$BOARD'");
		}
	}
	if(isset($_POST['admin_move']) && $ID2SET != '' && $_REQUEST['admin_reason'] != ''){
		$getIDfromID = $wpdb->get_results("SELECT PARENT FROM $regularboard_posts WHERE ID = $ID2SET LIMIT 1");
		$setBoard = esc_sql($_REQUEST['admin_reason']);
		if(current_user_can('manage_options')){
			$wpdb->update($regularboard_posts,array('BOARD' => $setBoard),array('ID' => $ID2SET), array('%s'));
			foreach($getIDfromID as $parentCheck){
				$parent = $parentCheck->PARENT;
				if($PARENT == 0){
					$wpdb->update($regularboard_posts,array('BOARD' => $setBoard),array('PARENT' => $ID2SET),array('%s'));
				}
			}
		}
		if($ISUSERMOD === true || $ISUSERJANITOR === true){
			$wpdb->update($regularboard_posts,array('BOARD' => $setBoard),array('ID' => $ID2SET,'MODERATOR' => 0),array('%s'));
			foreach($getIDfromID as $parentCheck){
				$parent = $parentCheck->PARENT;
				if($PARENT == 0){
					$wpdb->update($regularboard_posts,array('BOARD' => $setBoard),array('PARENT' => $ID2SET),array('%s'));
				}
			}
		}
	}
	if(isset($_POST['admin_ban']) && $ID2SET != ''){
		if(current_user_can('manage_options')){$getIPfromID = $wpdb->get_results("SELECT IP FROM $regularboard_posts WHERE ID = $ID2SET LIMIT 1");
		foreach($getIPfromID as $gotIP){
			$IP = $gotIP->IP;
			$PARENT = $gotIP->PARENT;
			$MESSAGE = esc_sql($_REQUEST['admin_reason']);
			$LENGTH = esc_sql($_REQUEST['admin_length']);
			$wpdb->query($wpdb->prepare("INSERT INTO $regularboard_users ( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s,%s )",'',$current_timestamp,$IP,$ID2SET,$PARENT,$BOARD,1,$MESSAGE,$LENGTH,0,'',0,0,'',''));
		}
	}
	if($ISUSERMOD === true){
		$getIPfromID = $wpdb->get_results("SELECT IP FROM $regularboard_posts WHERE ID = $ID2SET AND MODERATOR != 1 LIMIT 1");
		foreach($getIPfromID as $gotIP){
			$IP = $gotIP->IP;
			$PARENT  = $gotIP->PARENT;
			$MESSAGE = esc_sql($_REQUEST['admin_reason']);
			$LENGTH = esc_sql($_REQUEST['admin_length']);
			$wpdb->query($wpdb->prepare("INSERT INTO $regularboard_users ( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%d,%s,%s,%s,%s )",'',$current_timestamp,$IP,$ID2SET,$PARENT,$BOARD,1,$MESSAGE,$LENGTH,0,'',0,0,'',''));
			}
		}
	}

?>
