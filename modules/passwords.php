<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

	//	MY OPTIONAL MODULES
	//		MODULE: PASSWORDS

	$my_optional_modules_passwords_salt = wp_salt();
	$theMethod = "sha512";
	
	if (is_admin() ) {
	
		function my_optional_modules_passwords_module() {

			function update_rotating_universal_passwords() {
				global $my_optional_modules_passwords_salt;
				$pass1 = $_REQUEST[ 'rotating_universal_passwords_1' ];
				$pass2 = $_REQUEST[ 'rotating_universal_passwords_2' ];
				$pass3 = $_REQUEST[ 'rotating_universal_passwords_3' ];
				$pass4 = $_REQUEST[ 'rotating_universal_passwords_4' ];
				$pass5 = $_REQUEST[ 'rotating_universal_passwords_5' ];
				$pass6 = $_REQUEST[ 'rotating_universal_passwords_6' ];
				$pass7 = $_REQUEST[ 'rotating_universal_passwords_7' ];
				$pass_final_1 = hash( 'sha512', $my_optional_modules_passwords_salt . $pass1 );
				$pass_final_2 = hash( 'sha512', $my_optional_modules_passwords_salt . $pass2 );
				$pass_final_3 = hash( 'sha512', $my_optional_modules_passwords_salt . $pass3 );
				$pass_final_4 = hash( 'sha512', $my_optional_modules_passwords_salt . $pass4 );
				$pass_final_5 = hash( 'sha512', $my_optional_modules_passwords_salt . $pass5 );
				$pass_final_6 = hash( 'sha512', $my_optional_modules_passwords_salt . $pass6 );
				$pass_final_7 = hash( 'sha512', $my_optional_modules_passwords_salt . $pass7 );
				if ( $_POST[ 'rotating_universal_passwords_1'] !== '' ) { update_option( 'rotating_universal_passwords_1',$pass_final_1 ); }
				if ( $_POST[ 'rotating_universal_passwords_2'] !== '' ) { update_option( 'rotating_universal_passwords_2',$pass_final_2 ); }
				if ( $_POST[ 'rotating_universal_passwords_3'] !== '' ) { update_option( 'rotating_universal_passwords_3',$pass_final_3 ); }
				if ( $_POST[ 'rotating_universal_passwords_4'] !== '' ) { update_option( 'rotating_universal_passwords_4',$pass_final_4 ); }
				if ( $_POST[ 'rotating_universal_passwords_5'] !== '' ) { update_option( 'rotating_universal_passwords_5',$pass_final_5 ); }
				if ( $_POST[ 'rotating_universal_passwords_6'] !== '' ) { update_option( 'rotating_universal_passwords_6',$pass_final_6 ); }
				if ( $_POST[ 'rotating_universal_passwords_7'] !== '' ) { update_option( 'rotating_universal_passwords_7',$pass_final_7 ); }			
				if ( $_POST[ 'rotating_universal_passwords_8'] !== '' ) { update_option( 'rotating_universal_passwords_8',$_REQUEST[ 'rotating_universal_passwords_8' ] ); }
				echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
			}
			
			if ( $_REQUEST[ 'passwordsSave' ] ) { update_rotating_universal_passwords(); }
			
			function print_rotating_universal_passwords_form() {
				global $my_optional_modules_passwords_salt;
				echo "
				<td valign=\"top\">
					<form method=\"post\">
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
							<tbody>
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_1\">Sunday:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_1\" "; 
									if ( get_option( 'rotating_universal_passwords_1' ) !== '' ) { 
										echo "placeholder=\"Hashed and set.\""; 
									} else { 
										echo "class=\"notset\" placeholder=\"password not set\""; }
									echo " /></td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_2\">Monday:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_2\" "; 
									if ( get_option( 'rotating_universal_passwords_2' ) !== '' ) { 
										echo "placeholder=\"Hashed and set.\""; 
									} else { 
										echo "class=\"notset\" placeholder=\"password not set\""; }
									echo " /></td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_3\">Tuesday:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_3\" "; 
									if ( get_option( 'rotating_universal_passwords_3' ) !== '' ) { 
										echo "placeholder=\"Hashed and set.\""; 
									} else { 
										echo "class=\"notset\" placeholder=\"password not set\""; }
									echo " /></td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_4\">Wednesday:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_4\" "; 
									if ( get_option( 'rotating_universal_passwords_4' ) !== '' ) { 
										echo "placeholder=\"Hashed and set.\""; 
									} else { 
										echo "class=\"notset\" placeholder=\"password not set\""; }
									echo " /></td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_5\">Thursday:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_5\" "; 
									if ( get_option( 'rotating_universal_passwords_5' ) !== '' ) { 
										echo "placeholder=\"Hashed and set.\""; 
									} else { 
										echo "class=\"notset\" placeholder=\"password not set\""; }
									echo " /></td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_6\">Friday:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_6\" "; 
									if ( get_option( 'rotating_universal_passwords_6' ) !== '' ) {
										echo "placeholder=\"Hashed and set.\""; 
									} else { 
										echo "class=\"notset\" placeholder=\"password not set\""; }
									echo " /></td>
								</tr>		
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_7\">Saturday:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_7\" "; 
									if ( get_option( 'rotating_universal_passwords_7' ) !== '' ) {
										echo "placeholder=\"Hashed and set.\""; 
									} else { 
										echo "class=\"notset\" placeholder=\"password not set\""; }
									echo " /></td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\"><label for=\"rotating_universal_passwords_8\">Attempts before lockout:</label></th>
									<td><input type=\"text\" name=\"rotating_universal_passwords_8\" value=\""; 
									if ( get_option( 'rotating_universal_passwords_8' ) !== '' ) {
										echo get_option("rotating_universal_passwords_8"); 
									} echo "\" /></td>
									<tr valign=\"top\">
										<td>
											<input type=\"submit\" name=\"passwordsSave\" value=\"Save changes\" />
										</td>
										<td>
											<input type=\"submit\" name=\"reset_rups\" value=\"Reset passwords\" /></td>
										</td>
									</tr>
							</tbody>
						</table>
					</form>
					</td>
					<td valign=\"top\">
						<table class=\"form-table\">
							<tbody>
								<tr>
									<td>Date</td>
									<td>ID</td>
									<td>Origin</td>
									<td>Clear?</td>
								</tr>";
								
						global $wpdb;
						$RUPs_attempts_amount = get_option("rotating_universal_passwords_8");
						$RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
						$RUPs_locks = $wpdb->get_results ("SELECT ID,DATE,IP,URL FROM $RUPs_table_name WHERE ATTEMPTS >= $RUPs_attempts_amount ORDER BY ID DESC");
						foreach ($RUPs_locks as $RUPs_locks_admin) {
							$this_ID = $RUPs_locks_admin->ID;
								echo "
								<tr>
									<td><strong>",$RUPs_locks_admin->DATE,"</strong></td>
									<td>",$RUPs_locks_admin->IP,"</td>
									<td><a href=\"",$RUPs_locks_admin->URL,"\">Originating post</a></td>
									<td><form method=\"post\" class=\"RUPs_item_form\"><input type=\"submit\" name=\"$this_ID\" value=\"Clear lock\"></form></td>
								</tr>
								";
								if(isset($_POST[$this_ID])){
									$wpdb->query(" DELETE FROM $RUPs_table_name WHERE ID = '$this_ID' ");
								}
						}
						echo "
							</tbody>
						</table>
					</td>";
				
				
			
				if ($_POST['reset_rups'] ) {
					delete_option( 'rotating_universal_passwords_1' );
					delete_option( 'rotating_universal_passwords_2' );
					delete_option( 'rotating_universal_passwords_3' );
					delete_option( 'rotating_universal_passwords_4' );
					delete_option( 'rotating_universal_passwords_5' );
					delete_option( 'rotating_universal_passwords_6' );
					delete_option( 'rotating_universal_passwords_7' );	
					add_option( 'rotating_universal_passwords_1','','Sun password' );
					add_option( 'rotating_universal_passwords_2','','Mon password' );
					add_option( 'rotating_universal_passwords_3','','Tue password' );
					add_option( 'rotating_universal_passwords_4','','Wed password' );
					add_option( 'rotating_universal_passwords_5','','Thu password' );
					add_option( 'rotating_universal_passwords_6','','Fri password' );
					add_option( 'rotating_universal_passwords_7','','Sat password' );	
				}
				
			}

			function rotating_universal_passwords_page_content() { 
				echo "	
					<div class=\"wrap\">
						<h2>Passwords</h2>
						<table class=\"form-table\" border=\"1\">
							<tbody>
								<tr>
									<td valign=\"top\"><strong>Usage</strong><br />
										Surround content in your posts and pages that you wish to password protect using the shortcode.<hr />
										<p><code>[rups]content[/rups]</code></p>
									</td>";
									print_rotating_universal_passwords_form();
									echo "
								</tr>
							</tbody>
						</table>
					</div>";
			}
			
			rotating_universal_passwords_page_content();
		}
		
		my_optional_modules_passwords_module();
		
	}
?>