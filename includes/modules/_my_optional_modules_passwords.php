<?php 

/**
 * My Optional Modules Passwords
 *
 * (1) Passwords settings page and functionality
 *
 * @package regular_board
 */	

if ( current_user_can ( 'manage_options' ) ) {
	if ( !function_exists ( 'my_optional_modules_passwords_module' ) ) { 
		function my_optional_modules_passwords_module() { ?>
			<strong class="sectionTitle">Passwords Settings</strong>
			<form method="post">
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_1">Sunday:</label>
						<input class="right" type="text" name="rotating_universal_passwords_1"<?php if ( get_option ( 'rotating_universal_passwords_1' ) ) { ?>placeholder="Hashed and set."<?php } else { ?>class="notset" placeholder="password not set"<?php } ?>/>
					</section>
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_2">Monday:</label>
						<input class="right" type="text" name="rotating_universal_passwords_2"<?php if ( get_option ( 'rotating_universal_passwords_2' ) ) { ?>placeholder="Hashed and set."<?php } else { ?>class="notset" placeholder="password not set"<?php } ?>/>
					</section>
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_3">Tuesday:</label>
						<input class="right" type="text" name="rotating_universal_passwords_3"<?php if ( get_option ( 'rotating_universal_passwords_3' ) ) { ?>placeholder="Hashed and set."<?php } else { ?>class="notset" placeholder="password not set"<?php } ?>/>
					</section>
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_4">Wednesday:</label>
						<input class="right" type="text" name="rotating_universal_passwords_4"<?php if ( get_option ( 'rotating_universal_passwords_4' ) ) { ?>placeholder="Hashed and set."<?php } else { ?>class="notset" placeholder="password not set"<?php } ?>/>
					</section>
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_5">Thursday:</label>
						<input class="right" type="text" name="rotating_universal_passwords_5"<?php if ( get_option ( 'rotating_universal_passwords_5' ) ) { ?>placeholder="Hashed and set."<?php } else { ?>class="notset" placeholder="password not set"<?php } ?>/>
					</section>
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_6">Friday:</label>
						<input class="right" type="text" name="rotating_universal_passwords_6"<?php if ( get_option ( 'rotating_universal_passwords_6' ) ) { ?>placeholder="Hashed and set."<?php } else { ?>class="notset" placeholder="password not set"<?php } ?>/>
					</section>
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_7">Saturday:</label>
						<input class="right" type="text" name="rotating_universal_passwords_7"<?php if ( get_option ( 'rotating_universal_passwords_7' ) ) { ?>placeholder="Hashed and set."<?php } else { ?>class="notset" placeholder="password not set"<?php } ?>/>
					</section>
					<section class="clear">
						<label class="left" for="rotating_universal_passwords_8">Attempts allowed:</label>
						<input class="right" type="text" name="rotating_universal_passwords_8" value="<?php if ( get_option ( 'rotating_universal_passwords_8' ) ) { ?><?php echo get_option('rotating_universal_passwords_8');?><?php } ?>" />
					</section>
					<section class="clear">
						<input class="right" type="submit" name="passwordsSave" id="passwordsSave" value="Save changes" />
						<input class="right" type="submit" name="reset_rups" id="reset_rups" value="Reset passwords" />
					</section>
			</form>
			<p></p>
			<form class="clear" method="post" action="" name="momPasswords">
				<label for="mom_passwords_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate Passwords module</label>
				<input type="text" class="hidden" value="<?php if(get_option('mommaincontrol_momrups') == 1){ ?>0<?php } else { ?>1<?php } ?>" name="passwords" />
				<input type="submit" id="mom_passwords_mode_submit" name="mom_passwords_mode_submit" value="Submit" class="hidden" />
			</form>
			<p>
				<i class="fa fa-info">&mdash;</i> [rups] Some content [/rups] will hide your content behind a password gate, 
				the password of which will be the current day's password (that you set). This content's password will change, 
				depending on the day (and <strong>if</strong> you have a password set <strong>for</strong> that day).
			</p>
			<p></p>
			<?php 
			global $wpdb;
			$RUPs_attempts_amount = get_option ( 'rotating_universal_passwords_8' );
			$RUPs_table_name      = $wpdb->prefix . 'rotating_universal_passwords';
			$RUPs_locks           = $wpdb->get_results ( "SELECT ID,DATE,IP,URL FROM $RUPs_table_name WHERE ATTEMPTS >= $RUPs_attempts_amount ORDER BY ID DESC" );
			foreach ( $RUPs_locks as $RUPs_locks_admin ) {
				$this_ID = sanitize_text_field ( intval ( $RUPs_locks_admin->ID ) ); ?>
				<strong class="sectionTitle">Clear locks</strong>
				<form class="clear" method="post" class="RUPs_item_form">
					<section class="clear">
						<span class="left"><strong><?php echo $RUPs_locks_admin->DATE; ?></strong></span>
						<span class="right"><a href="<?php echo $RUPs_locks_admin->URL;?>">Link</a> [user ID: <?php echo $RUPs_locks_admin->ID;?>]</span>
					</section>
					<section class="clear">
						<input type="submit" name="<?php echo $this_ID; ?>" value="Clear lock">
					</section>
				</form>
				<?php if ( isset ( $_POST [ $this_ID ] ) ) {
					$wpdb->query ( "DELETE FROM $RUPs_table_name WHERE ID = $this_ID " );
				}
			}
		}
	}
}

if ( !function_exists ( 'rotating_universal_passwords_shortcode' ) ) { 
	function rotating_universal_passwords_shortcode($atts, $content = null){
	
		
		ob_start();
		global $passwordField, $my_optional_modules_passwords_salt, $ipaddress;
		$passwordField++;	
		
		if ( $ipaddress !== false ) {
			
			$RUPs_ip_addr = esc_sql ( $ipaddress );
			$RUPs_s32int  = esc_sql ( ip2long ( $RUPs_ip_addr ) );
			$RUPs_us32str = esc_sql ( sprintf ( "%u", $RUPs_s32int ) );
			
			if ( date ( 'N' ) === '1' ) { 
				$rotating_universal_passwords_todays_password = get_option ( 'rotating_universal_passwords_2' ); 
				$rotating_universal_passwords_today_is = 'Monday'; 
			}
			if ( date ( 'N' ) === '2' ) { 
				$rotating_universal_passwords_todays_password = get_option ( 'rotating_universal_passwords_3' ); 
				$rotating_universal_passwords_today_is = 'Tuesday'; 
			}
			if ( date ( 'N' ) === '3' ) { 
				$rotating_universal_passwords_todays_password = get_option ( 'rotating_universal_passwords_4' ); 
				$rotating_universal_passwords_today_is = 'Wednesday'; 
			}
			if ( date ( 'N' ) === '4' ) { 
				$rotating_universal_passwords_todays_password = get_option ( 'rotating_universal_passwords_5' );
				$rotating_universal_passwords_today_is = 'Thursday'; 
			}
			if ( date ( 'N' ) === '5' ) { 
				$rotating_universal_passwords_todays_password = get_option ( 'rotating_universal_passwords_6' ); 
				$rotating_universal_passwords_today_is = 'Friday'; 
			}
			if ( date ( 'N' ) === '6' ) { 
				$rotating_universal_passwords_todays_password = get_option ( 'rotating_universal_passwords_7' );
				$rotating_universal_passwords_today_is = 'Saturday'; 
			}
			if ( date ( 'N' ) === '7' ) { 
				$rotating_universal_passwords_todays_password = get_option ( 'rotating_universal_passwords_1' );
				$rotating_universal_passwords_today_is = 'Sunday'; 
			}
			
			if ( $rotating_universal_passwords_todays_password ) {
				if( isset( $_REQUEST['rups_pass'] ) ) {
					$rups_md5passa = wp_hash ( $_REQUEST['rups_pass'] );
				} else {
					$rups_md5passa = '';
				}
				global $wpdb;
				$RUPs_table_name = $wpdb->prefix . 'rotating_universal_passwords';
				$RUPs_result     = $wpdb->get_results ( "SELECT ID FROM $RUPs_table_name WHERE IP = '$RUPs_s32int'" );
				if ( isset ( $_POST['rups_pass'] ) ) {
					if ( $rups_md5passa === $rotating_universal_passwords_todays_password ) {
						if ( count ( $RUPs_result ) > 0 ) {
							$RUPs_table_name = $wpdb->prefix . 'rotating_universal_passwords';
							$wpdb->query ( "DELETE FROM $RUPs_table_name WHERE IP = '$RUPs_s32int'" );
					}
						return $content;
					} else {
						$RUPs_date       = esc_sql ( date ( 'Y-m-d H:i:s' ) );
						$RUPs_table_name = $wpdb->prefix . 'rotating_universal_passwords';
						$RUPs_URL        = esc_url ( get_permalink() );
						if ( count ( $RUPs_result ) > 0 ) {
							$wpdb->query ( "UPDATE $RUPs_table_name SET ATTEMPTS = ATTEMPTS + 1 WHERE IP = '$RUPs_s32int'" );
							$wpdb->query ( "UPDATE $RUPs_table_name SET DATE = '$RUPs_date' WHERE IP = '$RUPs_s32int'" );
							$wpdb->query ( "UPDATE $RUPs_table_name SET URL = '$RUPs_URL' WHERE IP = '$RUPs_s32int'" );
						} else {
							$wpdb->query ( "INSERT INTO $RUPs_table_name ( ID, DATE, IP, ATTEMPTS, URL ) VALUES ( '','$RUPs_date','$RUPs_s32int','1','$RUPs_URL' )" ) ;
						}
					}
				}
				$RUPs_attempts = $wpdb->get_results ( "SELECT DATE, ATTEMPTS FROM $RUPs_table_name WHERE IP = '$RUPs_s32int'" );
				$attemptsLeft = '';
				if ( count ( $RUPs_attempts ) > 0 ) {
					foreach ( $RUPs_attempts as $RUPs_attempt_count ) {
						$RUPs_attempted = $RUPs_attempt_count->ATTEMPTS;
						$RUPs_dated     = $RUPs_attempt_count->DATE;
						if ( $RUPs_attempted < get_option ( 'rotating_universal_passwords_8' ) ) {
							$attempts = get_option ( 'rotating_universal_passwords_8' );
							$attemptsLeft = $attempts - $RUPs_attempted . ' attempts left.';
							if ( isset ( $_POST ) ) {
								echo '<form method="post" name="password_' . $passwordField . '" id="RUPS' . $passwordField . '" action="' . esc_url ( get_permalink() ) . '">';
								wp_nonce_field ( 'password_' . $passwordField );
								echo '<input type="text" class="password" name="rups_pass" placeholder="' . $attemptsLeft . 'Enter the password for ' . esc_attr ( $rotating_universal_passwords_today_is ) . '." >
								<input type="submit" name="submit" class="hidden" value="Submit">
								</form>';
							}
						}
						elseif ( $RUPs_attempted >= get_option ( 'rotating_universal_passwords_8' ) ) {
							echo "<blockquote>You have been locked out.  If you feel this is an error, please contact the admin to inquire further.</blockquote>";
						} else {
							if ( isset ( $_POST ) ) {
								echo '<form method="post" name="password_' . $passwordField . '" id="RUPS' . $passwordField . '" action="' . esc_url(get_permalink()) . '">';
								wp_nonce_field ( 'password_' . $passwordField );
								echo '<input type="text" class="password" name="rups_pass" placeholder="' . $attemptsLeft . 'Enter the password for ' . esc_attr ( $rotating_universal_passwords_today_is ) . '." >
								<input type="submit" name="submit" class="hidden" value="Submit">
								</form>';
							}
						}
					}
				} else {
					if ( isset ( $_POST ) ) {
						echo '<form method="post" name="password_' . $passwordField . '" id="RUPS' . $passwordField . '" action="' . esc_url ( get_permalink() ) .'">';
						wp_nonce_field ( 'password_' . $passwordField );
						echo '<input type="text" class="password" name="rups_pass" placeholder="' . $attemptsLeft . 'Enter the password for ' . esc_attr ( $rotating_universal_passwords_today_is ) . '." >
						<input type="submit" name="submit" class="hidden" value="Submit">
						</form>';
					}
				}
				return ob_get_clean();
			} else {
			ob_start();
			echo '<blockquote>' . esc_attr ( $rotating_universal_passwords_today_is ) . '\'s password is blank or missing.</blockquote>';
			return ob_get_clean();
			}
		} else {
		// Return nothing, the IP address is fake.
		}
	}
}
//