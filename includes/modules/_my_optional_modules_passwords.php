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
		function my_optional_modules_passwords_module() {
			echo '<span class="moduletitle">
			<form method="post" action="" name="momPasswords"><label for="mom_passwords_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_momrups') == 1){echo '0';}else{echo '1';}echo '" name="passwords" /><input type="submit" id="mom_passwords_mode_submit" name="mom_passwords_mode_submit" value="Submit" class="hidden" /></form>		
			</span><div class="clear"></div><div class="settings">';
			echo '
				<form method="post">
					<div class="countplus">
						<section><label for="rotating_universal_passwords_1">Sunday:</label>
						<input type="text" name="rotating_universal_passwords_1" '; 
						if ( get_option ( 'rotating_universal_passwords_1' ) ) {
							echo 'placeholder="Hashed and set."'; 
						} else {
							echo 'class="notset" placeholder="password not set"';
						}
						echo ' /></section>
						<section><label for="rotating_universal_passwords_2">Monday:</label>
						<input type="text" name="rotating_universal_passwords_2" ';
						if ( get_option ( 'rotating_universal_passwords_2' ) ) {
							echo 'placeholder="Hashed and set."';
						} else {
							echo 'class="notset" placeholder="password not set"';
						}
						echo ' /></section>
						<section><label for="rotating_universal_passwords_3">Tuesday:</label>
						<input type="text" name="rotating_universal_passwords_3" '; 
						if ( get_option ( 'rotating_universal_passwords_3' ) ) {
							echo 'placeholder="Hashed and set."'; 
						} else {
							echo 'class="notset" placeholder="password not set"';
						}
						echo ' /></section>
						<section><label for="rotating_universal_passwords_4">Wednesday:</label>
						<input type="text" name="rotating_universal_passwords_4" '; 
						if ( get_option ( 'rotating_universal_passwords_4' ) ) {
							echo 'placeholder="Hashed and set."'; 
						} else {
							echo 'class="notset" placeholder="password not set"';
						}
						echo ' /></section>
						<section><label for="rotating_universal_passwords_5">Thursday:</label>
						<input type="text" name="rotating_universal_passwords_5" '; 
						if ( get_option ( 'rotating_universal_passwords_5' ) ) {
							echo 'placeholder="Hashed and set."'; 
						} else {
							echo 'class="notset" placeholder="password not set"';
						}
						echo ' /></section>
						<section><label for="rotating_universal_passwords_6">Friday:</label>
						<input type="text" name="rotating_universal_passwords_6" '; 
						if ( get_option ( 'rotating_universal_passwords_6' ) ) {
							echo 'placeholder="Hashed and set."'; 
						} else {
							echo 'class="notset" placeholder="password not set"';
						}
						echo ' /></section>
						<section><label for="rotating_universal_passwords_7">Saturday:</label>
						<input type="text" name="rotating_universal_passwords_7" '; 
						if ( get_option ( 'rotating_universal_passwords_7' ) ) {
							echo 'placeholder="Hashed and set."'; 
						} else {
							echo 'class="notset" placeholder="password not set"';
						}
						echo ' /></section>
						<section><label for="rotating_universal_passwords_8">Attempts before lockout:</label>
						<input type="text" name="rotating_universal_passwords_8" value="'; 
						if ( get_option ( 'rotating_universal_passwords_8' ) ) {
							echo get_option('rotating_universal_passwords_8');
						} 
						echo '" /></section>
						</div>
						<input type="submit" name="passwordsSave" id="passwordsSave" value="Save changes" />
						<input type="submit" name="reset_rups" id="reset_rups" value="Reset passwords" />
				</form>
				<div class="clear new">
				<div class="lockouts">
				<h2>Current locks</h2>
					<div class="clear locked">
						<span><strong>Date/time</strong></span>
						<span>User ID</span>
						<span>Originating post</span>
						<span>Clear</span>
					</div>';
					
					global $wpdb;
					$RUPs_attempts_amount = get_option ( 'rotating_universal_passwords_8' );
					$RUPs_table_name      = $wpdb->prefix . 'rotating_universal_passwords';
					$RUPs_locks           = $wpdb->get_results ( "SELECT ID,DATE,IP,URL FROM $RUPs_table_name WHERE ATTEMPTS >= $RUPs_attempts_amount ORDER BY ID DESC" );
					foreach ( $RUPs_locks as $RUPs_locks_admin ) {
						
						$this_ID = sanitize_text_field ( intval ( $RUPs_locks_admin->ID ) );
						echo '
						<div class="clear locked">
							<span><strong>' . $RUPs_locks_admin->DATE . '</strong></span>
							<span>' . $RUPs_locks_admin->IP . '</span>
							<span><a href="' . $RUPs_locks_admin->URL . '">Link</a></span>
							<span>
								<form method="post" class="RUPs_item_form">
									<input type="submit" name="' . $this_ID . '" value="Clear lock">
								</form>
							</span>
						</div>
						';
						if ( isset ( $_POST [ $this_ID ] ) ) {
							$wpdb->query ( "DELETE FROM $RUPs_table_name WHERE ID = $this_ID " );
						}
						
					}
					
			echo '</div></div></div>';
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
				$rups_md5passa = wp_hash ( $_REQUEST['rups_pass'] );
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
							$wpdb->query ( "UPDATE $RUPs_table_name SET ATTEMPTS = ATTEMPTS + 1 WHERE IP = $RUPs_s32int" );
							$wpdb->query ( "UPDATE $RUPs_table_name SET DATE = '$RUPs_date' WHERE IP = $RUPs_s32int" );
							$wpdb->query ( "UPDATE $RUPs_table_name SET URL = '$RUPs_URL' WHERE IP = $RUPs_s32int" );
						} else {
							$wpdb->query ( "INSERT INTO $RUPs_table_name ( ID, DATE, IP, ATTEMPTS, URL ) VALUES ( '','$RUPs_date','$RUPs_s32int','1','$RUPs_URL' )" ) ;
						}
					}
				}
				$RUPs_attempts = $wpdb->get_results ( "SELECT DATE, ATTEMPTS FROM $RUPs_table_name WHERE IP = '$RUPs_s32int'" );
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
							echo "<blockquote>You have been locked out.  If you feel this is an error, please contact the admin with the following <strong>id:" . $RUPs_s32int . "</strong> to inquire further.</blockquote>";
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