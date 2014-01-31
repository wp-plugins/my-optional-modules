	<?php 
	if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	if(isset($_POST['report_this']) && $_REQUEST['report_ids'] != ''){
		$ID2REPORT = intval($_REQUEST['report_ids']);
		$REPORTMESSAGE = esc_sql($_REQUEST['report_reason']);
		$IP = esc_sql($theIP_us32str);
		$grabReport = $wpdb->get_results("SELECT * FROM $regularboard_users WHERE THREAD = $ID2REPORT AND BANNED = 3");
		$grabParentofReport = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE ID = $ID2REPORT");
		$exists = 0;
		if(count($grabReport) > 0){
			foreach($grabParentofReport as $theParent){
				$thisPARENT = $theParent->PARENT;
				if($thisPARENT == 0){$THEPARENT = 0;}
				else{$THEPARENT = $thisPARENT;}
				$exists++;
			}
		}
		echo $exists;
		if(count($grabReport) == 0 && $exists == 0){
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO $regularboard_users 
				( ID, DATE, IP, THREAD, PARENT, BOARD, BANNED, MESSAGE, LENGTH, KARMA, PASSWORD, HEAVEN, VIDEO, BOARDS, FOLLOWING ) 
				VALUES ( %d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%s,%d,%d,%s,%s )",
				'',
				$current_timestamp,
				$IP,
				$ID2REPORT,
				$THEPARENT,
				$BOARD,
				3,
				$REPORTMESSAGE,
				$LENGTH,
				0,
				1,
				0,
				0,
				'',
				''
			)
		);																
		echo '<div class="tinythread"><span class="tinysubject">Report received.  Thank you!</span></div>';}
		elseif($exists == 0){ echo '<div class="tinythread"><span class="tinysubject">Thread does not exist.</span></div>';}
		elseif(count($grabReport) > 0){ echo '<div class="tinythread"><span class="tinysubject">Thread has already been reported.</span></div>';}
	}
	
	?>