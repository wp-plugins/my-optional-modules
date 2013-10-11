<?php 

	## Module name: Count++
	##  Salt (change immediately)
	##  add shortcode
	##  options page
	##   - options form (save)
	##   - options form (output)
	##   - options page (output)
	##  shortcode content
	
	if(!defined('MyOptionalModules')) {	die('You can not call this file directly.'); }

	## Salt (change immediately)
	$theSalt = "fasdf789F&S*()D&f89sjf8s7d90f87as09df70a9s8d7f908&J)(F*S&()D&f09
	fasdfuas8df9a7sd89g7J()*G&S()D&*g90sd78fg907asd90fg7s90d8f7g90s7d0f98g790sd7f90gs7d90f7g09sd7f0g7sd90fg7
	g*&G()D&()G&)Df7gj90sd78f09g8s7dj90f7g0s9d7f90g7ds907g09d7sfgsdfgsdf;;;-sd-f-gsd9fg908()&()G*&D()*F&g90d
	gs87df90g7s90df7g90sd78f90g7)(*&G()SDGJ(&)F(g7j0sz7df08g7s0d8f7g0s8df7g08sdf09g60J*^G)D&*fg6d0f7g0d8f7g0
	gf89&)(G*&D)(*F&GJ)Dfs70df78gs0d8f70g9s78df0g70*(&G()D*&Fg7d90fg87s90d8f7g09s7df09ghs70d98h7df87hs08f7h0
	87890&F()*&)SD(&*)(F*&)(&*)g7d-f7-gdfg-d7f-g7_&G_D&*F&G*d8g7jd890fg78df7g89d7fg78*(GD*F*gd8fg8d89fgfgfgf";
	$theMethod = "sha512";

	##  add shortcode
	add_shortcode('rups', 'rotating_universal_passwords_shortcode');	
	add_filter('the_content', 'do_shortcode', 'rotating_universal_passwords_shortcode');	
	
	if (is_admin() ) {
		##  options page
		add_action("admin_menu", "rotating_universal_passwords_options_add_options_page");
		function rotating_universal_passwords_options_add_options_page() {$RUPs_options = add_options_page("MOM: RUPs", " &not; MOM: RUPs", "manage_options", "momrups", "rotating_universal_passwords_page_content"); }

		
		## options form (save)
		function update_rotating_universal_passwords() {
			$rotating_universal_passwords_encryption = get_option("rotating_universal_passwords_9");
			global $theSalt;
			if ( $_REQUEST["rotating_universal_passwords_1"] ||	$_REQUEST["rotating_universal_passwords_2"] || $_REQUEST["rotating_universal_passwords_3"] || $_REQUEST["rotating_universal_passwords_4"] || $_REQUEST["rotating_universal_passwords_5"] || $_REQUEST["rotating_universal_passwords_6"] || $_REQUEST["rotating_universal_passwords_7"] || $_REQUEST["rotating_universal_passwords_8"] ) {
				$pass1 = $_REQUEST["rotating_universal_passwords_1"];
				$pass2 = $_REQUEST["rotating_universal_passwords_2"];
				$pass3 = $_REQUEST["rotating_universal_passwords_3"];
				$pass4 = $_REQUEST["rotating_universal_passwords_4"];
				$pass5 = $_REQUEST["rotating_universal_passwords_5"];
				$pass6 = $_REQUEST["rotating_universal_passwords_6"];
				$pass7 = $_REQUEST["rotating_universal_passwords_7"];
				$pass_final_1 = hash("sha512", $theSalt . $pass1);
				$pass_final_2 = hash("sha512", $theSalt . $pass2);
				$pass_final_3 = hash("sha512", $theSalt . $pass3);
				$pass_final_4 = hash("sha512", $theSalt . $pass4);
				$pass_final_5 = hash("sha512", $theSalt . $pass5);
				$pass_final_6 = hash("sha512", $theSalt . $pass6);
				$pass_final_7 = hash("sha512", $theSalt . $pass7);
				if ($_POST['rotating_universal_passwords_1'] !== "" ) {update_option("rotating_universal_passwords_1",$pass_final_1); }
				if ($_POST['rotating_universal_passwords_2'] !== "" ) {update_option("rotating_universal_passwords_2",$pass_final_2); }
				if ($_POST['rotating_universal_passwords_3'] !== "" ) {update_option("rotating_universal_passwords_3",$pass_final_3); }
				if ($_POST['rotating_universal_passwords_4'] !== "" ) {update_option("rotating_universal_passwords_4",$pass_final_4); }
				if ($_POST['rotating_universal_passwords_5'] !== "" ) {update_option("rotating_universal_passwords_5",$pass_final_5); }
				if ($_POST['rotating_universal_passwords_6'] !== "" ) {update_option("rotating_universal_passwords_6",$pass_final_6); }
				if ($_POST['rotating_universal_passwords_7'] !== "" ) {update_option("rotating_universal_passwords_7",$pass_final_7); }			
				if ($_POST['rotating_universal_passwords_8'] !== "" ) {update_option("rotating_universal_passwords_8",$_REQUEST["rotating_universal_passwords_8"]);}
			}
		}	
		
		## options form (output)
		function print_rotating_universal_passwords_form() {
			global $theSalt;
			echo "
				
				<td valign=\"top\">
				
				<form method=\"post\" class=\"rups\">
					<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
						<tbody>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_1\">Sunday's password:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_1\" "; if (get_option("rotating_universal_passwords_1") !== "") { echo "placeholder=\"Hashed and set.\""; } else { echo "class=\"notset\" placeholder=\"password not set\""; } echo " /></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_2\">Monday's password:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_2\" "; if (get_option("rotating_universal_passwords_2") !== "") { echo "placeholder=\"Hashed and set.\""; } else { echo "class=\"notset\" placeholder=\"password not set\""; } echo " /></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_3\">Tuesday's password:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_3\" "; if (get_option("rotating_universal_passwords_3") !== "") { echo "placeholder=\"Hashed and set.\""; } else { echo "class=\"notset\" placeholder=\"password not set\""; } echo " /></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_4\">Wednesday's password:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_4\" "; if (get_option("rotating_universal_passwords_4") !== "") { echo "placeholder=\"Hashed and set.\""; } else { echo "class=\"notset\" placeholder=\"password not set\""; } echo " /></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_5\">Thursday's password:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_5\" "; if (get_option("rotating_universal_passwords_5") !== "") { echo "placeholder=\"Hashed and set.\""; } else { echo "class=\"notset\" placeholder=\"password not set\""; } echo " /></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_6\">Friday's password:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_6\" "; if (get_option("rotating_universal_passwords_6") !== "") { echo "placeholder=\"Hashed and set.\""; } else { echo "class=\"notset\" placeholder=\"password not set\""; } echo " /></td>
							</tr>		
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_7\">Saturday's password:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_7\" "; if (get_option("rotating_universal_passwords_7") !== "") { echo "placeholder=\"Hashed and set.\""; } else { echo "class=\"notset\" placeholder=\"password not set\""; } echo " /></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"rotating_universal_passwords_8\">Attempts before lockout:</label></th>
								<td><input type=\"text\" name=\"rotating_universal_passwords_8\" value=\""; if (get_option("rotating_universal_passwords_8") !== "") { echo get_option("rotating_universal_passwords_8"); } echo "\" /></td>
								<tr valign=\"top\">
									<td><p class=\"submit\"><input type=\"submit\" class=\"button button-primary\" name=\"submit\" value=\"Save changes\" /></p></td>
								</tr>
						</tbody>
					</table>
				</form>
				
				<form method=\"post\" class=\"rups\">
					<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
						<tbody>
								<tr valign=\"top\">
									<td><p class=\"submit\"><input type=\"submit\" class=\"button button-primary\" name=\"reset_rups\" value=\"Reset passwords\" /></p></td>
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
								<td>Post origin</td>
								<td>Clear lock?</td>
							</tr>			
					";
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
								$current = plugin_basename(__FILE__);
								$wpdb->query(" DELETE FROM $RUPs_table_name WHERE ID = '$this_ID' ");
								echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
							}
					}			
					echo "
						</tbody>
					</table>
				</td>
			
			";
			
			
		
			if (is_admin()) {
				if ($_POST['reset_rups'] ) {
					delete_option("rotating_universal_passwords_1");
					delete_option("rotating_universal_passwords_2");
					delete_option("rotating_universal_passwords_3");
					delete_option("rotating_universal_passwords_4");
					delete_option("rotating_universal_passwords_5");
					delete_option("rotating_universal_passwords_6");
					delete_option("rotating_universal_passwords_7");	
					add_option("rotating_universal_passwords_1","","Sun password");
					add_option("rotating_universal_passwords_2","","Mon password");
					add_option("rotating_universal_passwords_3","","Tue password");
					add_option("rotating_universal_passwords_4","","Wed password");
					add_option("rotating_universal_passwords_5","","Thu password");
					add_option("rotating_universal_passwords_6","","Fri password");
					add_option("rotating_universal_passwords_7","","Sat password");	
				}	
			}
		}

		## options page (output)
		function rotating_universal_passwords_page_content() { 
			global $theSalt;
			echo "	
				<div class=\"wrap\">
					<div id=\"icon-options-general\" class=\"icon32\"></div>
					<h2>RUPs</h2>
			";
			if ($theSalt == "fasdf789F&S*()D&f89sjf8s7d90f87as09df70a9s8d7f908&J)(F*S&()D&f09
			fasdfuas8df9a7sd89g7J()*G&S()D&*g90sd78fg907asd90fg7s90d8f7g90s7d0f98g790sd7f90gs7d90f7g09sd7f0g7sd90fg7
			g*&G()D&()G&)Df7gj90sd78f09g8s7dj90f7g0s9d7f90g7ds907g09d7sfgsdfgsdf;;;-sd-f-gsd9fg908()&()G*&D()*F&g90d
			gs87df90g7s90df7g90sd78f90g7)(*&G()SDGJ(&)F(g7j0sz7df08g7s0d8f7g0s8df7g08sdf09g60J*^G)D&*fg6d0f7g0d8f7g0
			gf89&)(G*&D)(*F&GJ)Dfs70df78gs0d8f70g9s78df0g70*(&G()D*&Fg7d90fg87s90d8f7g09s7df09ghs70d98h7df87hs08f7h0
			87890&F()*&)SD(&*)(F*&)(&*)g7d-f7-gdfg-d7f-g7_&G_D&*F&G*d8g7jd890fg78df7g89d7fg78*(GD*F*gd8fg8d89fgfgfgf") {
			echo "
					<div class=\"updated settings-error\">
						<p>
							<h3>Your salt needs to be changed</h3>
							<ol>
								<li>From your Wordpress menu, hover over <em>Plugins</em>, and select <strong>editor</strong>.</li>
								<li>From the dropdown menu next to <strong>Select plugin to edit</strong>, select My Optional Modules, and cliick <em>select</em>.</li>
								<li>Click on <em>my-optional-modules/modules/rups.php</em>, and locate the line of text that starts with <strong>\$theSalt</strong>.</li>
								<li>Highlight all of the text located between the quotation marks, delete, and replace with any fairly long string of random alpha-numeric-ascii characters.</li>
								<li>Once done, click <strong>update file</strong>, and this warning should go away.</li>
							</ol>
						</p>
					</div>";
				}
				
					if ($_REQUEST["submit"]) { update_rotating_universal_passwords(); }
					
					echo "
					<h3 class=\"title\">Settings</h3>
					<table class=\"form-table\" border=\"1\">
						<tbody>
							<tr>
								<td valign=\"top\"><strong>Usage</strong><br />
									Surround content in your posts and pages that you wish to password protect using the shortcode.
									<hr />
									<p><code>[rups]content[/rups]</code></p>
								</td>
					";
					print_rotating_universal_passwords_form();
					echo "
						</tr>
						</tbody>
					</table>
				</div>
			";

		}
	}
	
	## shortcode content
	function rotating_universal_passwords_shortcode($atts, $content = null) {
		ob_start();
		global $theSalt;
		if ( isset($_SERVER["REMOTE_ADDR"]) ) { 
			$RUPs_origin = $_SERVER["REMOTE_ADDR"]; 
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) { 
			$RUPs_origin = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
		} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) ) { 
			$RUPs_origin = $_SERVER["HTTP_CLIENT_IP"]; 
		}
		$RUPs_ip_addr = $RUPs_origin; 
		$RUPs_s32int = ip2long($RUPs_ip_addr); 
		$RUPs_us32str = sprintf("%u",$RUPs_s32int);			
		if (date("D") === "Sun") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_1"); $rotating_universal_passwords_today_is = "Sunday"; }
		if (date("D") === "Mon") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_2"); $rotating_universal_passwords_today_is = "Monday"; }
		if (date("D") === "Tue") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_3"); $rotating_universal_passwords_today_is = "Tuesday"; }
		if (date("D") === "Wed") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_4"); $rotating_universal_passwords_today_is = "Wednesday"; }
		if (date("D") === "Thu") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_5"); $rotating_universal_passwords_today_is = "Thursday"; }
		if (date("D") === "Fri") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_6"); $rotating_universal_passwords_today_is = "Friday"; }
		if (date("D") === "Sat") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_7"); $rotating_universal_passwords_today_is = "Saturday"; }	
		$rups_md5passa = hash("sha512", $theSalt . $_POST['rups_pass']);
		global $wpdb;
		$RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
		$RUPs_result = $wpdb->get_results ("SELECT ID FROM $RUPs_table_name WHERE IP = '".$RUPs_s32int."'");
		if (isset($_POST['rups_pass'])) {
			if ($rups_md5passa === $rotating_universal_passwords_todays_password) {		
				if (count ($RUPs_result) > 0) {
					$RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
					$wpdb->query(" DELETE FROM $RUPs_table_name WHERE IP = '$RUPs_s32int' ");
			}
				return $content;
			} else {
				$RUPs_date = date("Y-m-d H:i:s");  
				$RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
				$RUPs_URL = get_permalink();
				
				if (count ($RUPs_result) > 0) {
					$wpdb->query("UPDATE $RUPs_table_name SET ATTEMPTS = ATTEMPTS + 1 WHERE IP = $RUPs_s32int");
					$wpdb->query("UPDATE $RUPs_table_name SET DATE = '$RUPs_date' WHERE IP = $RUPs_s32int");
					$wpdb->query("UPDATE $RUPs_table_name SET URL = '",get_permalink(),"' WHERE IP = $RUPs_s32int");
				} else {
					$wpdb->query("INSERT INTO $RUPs_table_name (ID, DATE, IP, ATTEMPTS, URL) VALUES ('','$RUPs_date','$RUPs_s32int','1','$RUPs_URL')") ;
				}
			}
		}
		$RUPs_attempts = $wpdb->get_results ("SELECT DATE,ATTEMPTS FROM $RUPs_table_name WHERE IP = '".$RUPs_s32int."'");
		if (count ($RUPs_attempts) > 0) {
			foreach ($RUPs_attempts as $RUPs_attempt_count) {
				$RUPs_attempted = $RUPs_attempt_count->ATTEMPTS;
				$RUPs_dated = $RUPs_attempt_count->DATE;
				if ($RUPs_attempted < get_option("rotating_universal_passwords_8") ) {
					if(isset($_POST)) {
						echo "<form method=\"post\" action=\"",get_permalink(),"\">
						<input type=\"text\" name=\"rups_pass\" placeholder=\"Today is ",$rotating_universal_passwords_today_is,".\" >
						<input type=\"submit\" name=\"submit\" class=\"submit\" value=\"Submit\" >
						</form>";
					}
				}
				elseif ($RUPs_attempted >= get_option("rotating_universal_passwords_8") ) { 
					echo "<blockquote>You have been locked out.  If you feel this is an error, please contact the admin with the following <strong>id:",$RUPs_s32int,"</strong> to inquire further.</blockquote>";
				} else {			
					if(isset($_POST)) {
						echo "<form method=\"post\" action=\"",get_permalink(),"\">
						<input type=\"text\" name=\"rups_pass\" placeholder=\"Today is ",$rotating_universal_passwords_today_is,".\" >
						<input type=\"submit\" name=\"submit\" class=\"submit\" value=\"Submit\" >
						</form>";
					}
				}
			}
		} else {
			if(isset($_POST)) {
				echo "<form method=\"post\" action=\"",get_permalink(),"\">
				<input type=\"text\" name=\"rups_pass\" placeholder=\"Today is ",$rotating_universal_passwords_today_is,".\" >
				<input type=\"submit\" name=\"submit\" class=\"submit\" value=\"Submit\" >
				</form>";
			}			
		}
		return ob_get_clean();
	}
?>