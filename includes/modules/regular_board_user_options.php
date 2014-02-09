<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	if(isset($_POST['options'])){
		$email = esc_sql($_REQUEST['email']);
		$name = esc_sql($_REQUEST['USERNAME']);
		$password = esc_sql($_REQUEST['password']);
		$newpassword = esc_sql($_REQUEST['newpassword']);
		$oldpassword = esc_sql($_REQUEST['oldpassword']);
		$heaven = intval($_REQUEST['heaven']);
		$video = intval($_REQUEST['video']);
		$boards = esc_sql($_REQUEST['boards']);
		$follow = esc_sql($_REQUEST['follow']);
		
		if($name != ''){
			$checkname = $wpdb->get_results("SELECT NAME FROM $regularboard_users WHERE NAME = '".$name."' AND ID != $profileid");
			if(count($checkname) == 0){
				$wpdb->query("UPDATE $regularboard_users SET NAME = '$name' WHERE ID = $profileid");	
			}else{
				echo '<i class="fa fa-warning"></i> <strong>'.$name.'</strong> is already taken.  Please use a different one.';
			}
		}
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			$wpdb->query("UPDATE $regularboard_users SET EMAIL = '$email' WHERE ID = $profileid");
		}
		
		$wpdb->query("UPDATE $regularboard_users SET VIDEO = $video WHERE ID = $profileid");
		$wpdb->query("UPDATE $regularboard_users SET HEAVEN = $heaven WHERE ID = $profileid");
		if($profilepassword == ''){
			$wpdb->query("UPDATE $regularboard_users SET PASSWORD = '$password' WHERE ID = $profileid");}
		if($profilepassword != ''){
			$wpdb->query("UPDATE $regularboard_users SET PASSWORD = '$newpassword' WHERE ID = $profileid AND PASSWORD = '$oldpassword'");
			$wpdb->query("UPDATE $regularboard_posts SET PASSWORD = '$newpassword' WHERE USERID = $profileid");
		}
		
		$wpdb->query("UPDATE $regularboard_users SET BOARDS = '$boards' WHERE ID = $profileid");
		$wpdb->query("UPDATE $regularboard_users SET FOLLOWING = '$follow' WHERE ID = $profileid");
	}
	if(isset($_POST['donatenow']) && $_REQUEST['donate'] != '' && $_REQUEST['points'] != ''){
		$points = intval($_REQUEST['points']);
		$to = intval($_REQUEST['donate']);
		if($points <= $profilekarma){
			$wpdb->query("UPDATE $regularboard_users SET KARMA = KARMA - $points WHERE ID = $profileid");
			$wpdb->query("UPDATE $regularboard_users SET KARMA = KARMA + $points WHERE ID = $to");
		}
	}
	echo '<div class="tinythread"><span class="tinysubject">You have '.$profilekarma.' points - enter user ID to donate to</span></div><form method="post" class="COMMENTFORM boardcreation" name="donatepoints" action="?a=options">';
	wp_nonce_field('donatepoints');
	echo '<section class="full"><p>Donate points to this user:</p><input type="text" name="donate" id="donate" value="" placeholder="User ID to donate to" /></section><section class="full"><p>Amount of points to donate (will be taken from your total):</p><input type="text" name="points" id="points" value="" placeholder="Amount" /></section><section class="full"><label class="create" for="donatenow">Donate now!</label><input class="hidden" type="submit" name="donatenow" id="donatenow" value="Donate now!" /></section></form>
	<hr />
	<div class="tinythread"><span class="tinysubject">Options'; if(isset($_POST['options'])){ echo ' <strong>Saved!</strong>';} echo '</span></div><form method="post" class="COMMENTFORM boardcreation" name="useroptions" action="?a=options">';
	wp_nonce_field('useroptions');
	echo '<section class="full">
	<p>Set your email address here (can also be blank) (this installation does not make publicly accessible this information):</p>
	<input type="text" name="email" id="email" placeholder="you@there.com" value="'.$profileemail.'" />
	</section>
	
	<section class="full">
	<p>Set a memorable name:</p>
	<input type="text" name="USERNAME" id="USERNAME" placeholder="Your memorable name" value="'.$profilename.'" />
	</section>	
	
	';
	
	echo '<section class="full">';
	if($profilepassword == ''){
		echo '<p>Set a password to use on every post you make (default password is always random):</p>';
		echo '<input type="text" name="password" id="password" placeholder="'.$rand.'" />';
	}
	if($profilepassword != ''){
		echo '<p>To change your current password, enter it in the first box and your new password in the second.'; 
		if(isset($_POST['options']) && $profilepassword != esc_sql($_REQUEST['oldpassword'])){ echo ' <strong>Password mismatch.</strong>';}
		if(isset($_POST['options']) && $profilepassword == esc_sql($_REQUEST['oldpassword'])){ echo ' <strong>Password changed.</strong>';}
		echo '</p>';
		
		echo '<input type="text" name="oldpassword" id="password" placeholder="Enter current password" />';
		echo '<input type="text" name="newpassword" id="password" placeholder="Enter new password" />';
	}
	echo '</section><hr />';
	if($THISBOARD == ''){ 
		echo '<section class="full"><p>Comma-separated list of boards you wish to subscribe to (available boards below) (example: board, board, board):<br />';
		foreach($getBoards as $board){
			echo '<span class="board">'.$board->SHORTNAME.'</span>';
		}
		echo '</p><input type="text" name="boards" id="boards" value="'.$profileboards.'" placeholder="Boards" /></section><hr />';
	}
	echo '<section class="full"><p>Comma-separated list of user IDs to follow:<br /></p><input type="text" name="follow" id="follow" value="'.$profilefollow.'" placeholder="User IDs" /></section><hr /><section class="full"><p>Whether or not you wish the e-mail field to be prepopulated with <code>heaven</code></p><select class="full" name="heaven" id="heaven"><option ';if($profileheaven == 0){echo 'selected="selected" ';}echo 'value="0">Give me the choice of posting anonymously</option><option ';if($profileheaven == 1){echo 'selected="selected" ';} echo 'value="1">Always post anonymously</option></select></section><hr /><section class="full"><p>Whether or not you wish Youtube embeds to be enabled</p><select class="full" name="video" id="video"><option ';if($profilevideo == 0){echo 'selected="selected" ';}echo 'value="0">Show embedded Youtube videos</option><option ';if($profilevideo == 1){echo 'selected="selected" ';}echo 'value="1">Display a link to the video without embedding it</option></select></section><hr /><section class="full"><label class="create" for="options">Save these options</label><input class="hidden" type="submit" name="options" id="options" value="Save these options" /></section></form></div><script type="text/javascript">document.title = \'Options\';</script>';

?>