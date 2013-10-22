<?php 

	## Main Control Panel
	## MCP contents
	## options page
	##   - options form (save)
	##   - options form (output)
	##   - options page (output)
	## set home page post content

	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }
		
	## Check if admin or not
	if (is_admin() ) { 

		## options page
		add_action("admin_menu", "my_optional_modules_add_options_page");
		function my_optional_modules_add_options_page() { $myoptionalmodules_options = add_options_page("MOM: Main Control", "MOM: Main Control", "manage_options", "mommaincontrol", "my_optional_modules_page_content"); }	
	
		## options form (save)
		function update_myoptionalmodules_options() {
			if(isset($_POST['momsave'])){
				if ($_REQUEST["mommaincontrol_uninstall_all"] == 1 || $_REQUEST["mommaincontrol_uninstall_all"] == 3) {
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 1) {	
						update_option("mommaincontrol_obwcountplus",0);
						update_option("mommaincontrol_momrups",0);
						update_option("mommaincontrol_momse",0);
						update_option("mommaincontrol_mompaf",0);
						update_option("mommaincontrol_momja",0);			
						update_option("mommaincontrol_shorts",0);
						update_option("mommaincontrol_analytics",0);
						global $table_prefix, $table_suffix, $wpdb;
						$table_name = $table_prefix . $table_suffix . 'rotating_universal_passwords';
						$wpdb->query("DROP TABLE {$table_name}");											
						delete_option("obwcountplus_1_countdownfrom");
						delete_option("obwcountplus_2_remaining");
						delete_option("obwcountplus_3_total");
						delete_option("obwcountplus_4_custom");
						delete_option("rotating_universal_passwords_1");
						delete_option("rotating_universal_passwords_2");
						delete_option("rotating_universal_passwords_3");
						delete_option("rotating_universal_passwords_4");
						delete_option("rotating_universal_passwords_5");
						delete_option("rotating_universal_passwords_6");
						delete_option("rotating_universal_passwords_7");
						delete_option("rotating_universal_passwords_8");	
						delete_option("simple_announcement_with_exclusion_9");
						delete_option("simple_announcement_with_exclusion_9_2");
						delete_option("simple_announcement_with_exclusion_9_3");
						delete_option("simple_announcement_with_exclusion_9_4");
						delete_option("simple_announcement_with_exclusion_9_5");
						delete_option("simple_announcement_with_exclusion_9_7");
						delete_option("simple_announcement_with_exclusion_9_8");
						delete_option("simple_announcement_with_exclusion_9_9");
						delete_option("simple_announcement_with_exclusion_9_10");
						delete_option("simple_announcement_with_exclusion_9_11");
						delete_option("simple_announcement_with_exclusion_9_12");
						delete_option("simple_announcement_with_exclusion_9_13");
						delete_option("simple_announcement_with_exclusion_9_14");		
						delete_option("simple_announcement_with_exclusion_cat_sun");
						delete_option("simple_announcement_with_exclusion_cat_mon");
						delete_option("simple_announcement_with_exclusion_cat_tue");
						delete_option("simple_announcement_with_exclusion_cat_wed");
						delete_option("simple_announcement_with_exclusion_cat_thu");
						delete_option("simple_announcement_with_exclusion_cat_fri");
						delete_option("simple_announcement_with_exclusion_cat_sat");												
						delete_option("simple_announcement_with_exclusion_cat_sun");
						delete_option("simple_announcement_with_exclusion_cat_mon");
						delete_option("simple_announcement_with_exclusion_cat_tue");
						delete_option("simple_announcement_with_exclusion_cat_wed");
						delete_option("simple_announcement_with_exclusion_cat_thu");
						delete_option("simple_announcement_with_exclusion_cat_fri");
						delete_option("simple_announcement_with_exclusion_cat_sat");
						delete_option("mompaf_post");
						delete_option("jump_around_0");
						delete_option("jump_around_1");
						delete_option("jump_around_2");
						delete_option("jump_around_3");
						delete_option("jump_around_4");
						delete_option("jump_around_5");
						delete_option("jump_around_6");
						delete_option("jump_around_7");
						delete_option("jump_around_8");		
						delete_option("momanalytics_code");						
					}
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 3) {
						global $table_prefix, $table_suffix, $wpdb;
						$table_name = $table_prefix . $table_suffix . 'rotating_universal_passwords';
						$wpdb->query("DROP TABLE {$table_name}");											
						delete_option("obwcountplus_1_countdownfrom");
						delete_option("obwcountplus_2_remaining");
						delete_option("obwcountplus_3_total");
						delete_option("obwcountplus_4_custom");
						delete_option("rotating_universal_passwords_1");
						delete_option("rotating_universal_passwords_2");
						delete_option("rotating_universal_passwords_3");
						delete_option("rotating_universal_passwords_4");
						delete_option("rotating_universal_passwords_5");
						delete_option("rotating_universal_passwords_6");
						delete_option("rotating_universal_passwords_7");
						delete_option("rotating_universal_passwords_8");	
						delete_option("simple_announcement_with_exclusion_9");
						delete_option("simple_announcement_with_exclusion_9_2");
						delete_option("simple_announcement_with_exclusion_9_3");
						delete_option("simple_announcement_with_exclusion_9_4");
						delete_option("simple_announcement_with_exclusion_9_5");
						delete_option("simple_announcement_with_exclusion_9_7");
						delete_option("simple_announcement_with_exclusion_9_8");
						delete_option("simple_announcement_with_exclusion_9_9");
						delete_option("simple_announcement_with_exclusion_9_10");
						delete_option("simple_announcement_with_exclusion_9_11");
						delete_option("simple_announcement_with_exclusion_9_12");
						delete_option("simple_announcement_with_exclusion_9_13");
						delete_option("simple_announcement_with_exclusion_9_14");		
						delete_option("simple_announcement_with_exclusion_sun");
						delete_option("simple_announcement_with_exclusion_mon");
						delete_option("simple_announcement_with_exclusion_tue");
						delete_option("simple_announcement_with_exclusion_wed");
						delete_option("simple_announcement_with_exclusion_thu");
						delete_option("simple_announcement_with_exclusion_fri");
						delete_option("simple_announcement_with_exclusion_sat");
						delete_option("simple_announcement_with_exclusion_cat_sun");
						delete_option("simple_announcement_with_exclusion_cat_mon");
						delete_option("simple_announcement_with_exclusion_cat_tue");
						delete_option("simple_announcement_with_exclusion_cat_wed");
						delete_option("simple_announcement_with_exclusion_cat_thu");
						delete_option("simple_announcement_with_exclusion_cat_fri");
						delete_option("simple_announcement_with_exclusion_cat_sat");												
						delete_option("simple_announcement_with_exclusion_cat_sun");
						delete_option("simple_announcement_with_exclusion_cat_mon");
						delete_option("simple_announcement_with_exclusion_cat_tue");
						delete_option("simple_announcement_with_exclusion_cat_wed");
						delete_option("simple_announcement_with_exclusion_cat_thu");
						delete_option("simple_announcement_with_exclusion_cat_fri");
						delete_option("simple_announcement_with_exclusion_cat_sat");						
						delete_option("mompaf_post");
						delete_option("jump_around_0");
						delete_option("jump_around_1");
						delete_option("jump_around_2");
						delete_option("jump_around_3");
						delete_option("jump_around_4");
						delete_option("jump_around_5");
						delete_option("jump_around_6");
						delete_option("jump_around_7");
						delete_option("jump_around_8");					
						delete_option("mommaincontrol_obwcountplus");
						delete_option("mommaincontrol_momrups");	
						delete_option("mommaincontrol_momse");
						delete_option("mommaincontrol_mompaf");
						delete_option("mommaincontrol_momja");
						delete_option("mommaincontrol_shorts");
						delete_option("mommaincontrol_analytics");						
						delete_option("momanalytics_code");						
					}
				} else {					
						if ($_REQUEST["mommaincontrol_obwcountplus"] != "" . get_option("mommaincontrol_obwcountplus") ."") { 
							update_option("mommaincontrol_obwcountplus",$_REQUEST["mommaincontrol_obwcountplus"]); 
							
							if ($_REQUEST["mommaincontrol_obwcountplus"] == 1) {
								## If we're enabling Count++ for the first time, set up its options.
									add_option("obwcountplus_1_countdownfrom","0","Word goal to count down to?");
									add_option("obwcountplus_2_remaining","remaining","Word to describe remaining amount of words until goal.");
									add_option("obwcountplus_3_total","total","Word to describe words total present on blog.");
									add_option("obwcountplus_4_custom","","Custom output.");
							}
							if ($_REQUEST["mommaincontrol_obwcountplus"] == 3) {
								## If we're uninstalling Count++, remove the options from the database.
									delete_option("obwcountplus_1_countdownfrom");
									delete_option("obwcountplus_2_remaining");
									delete_option("obwcountplus_3_total");
									delete_option("obwcountplus_4_custom");
							}
						}
						
						if ($_REQUEST["mommaincontrol_momrups"] != "" . get_option("mommaincontrol_momrups") . "") { 
							update_option("mommaincontrol_momrups",$_REQUEST["mommaincontrol_momrups"]); 
						
							if ($_REQUEST["mommaincontrol_momrups"] == 1) {
									## Create table for lockouts (if bad password attempts are made, store IPs, timer, etc.
									global $wpdb;
									$RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
									$RUPs_sql = "CREATE TABLE $RUPs_table_name (
									ID INT( 11 ) NOT NULL PRIMARY KEY AUTO_INCREMENT , 
									DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
									URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
									ATTEMPTS INT( 11 ) NOT NULL, 
									IP INT( 11 ) NOT NULL
									);";
									require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
									dbDelta( $RUPs_sql );
									## core settings
									add_option("rotating_universal_passwords_1","","Sun password");
									add_option("rotating_universal_passwords_2","","Mon password");
									add_option("rotating_universal_passwords_3","","Tue password");
									add_option("rotating_universal_passwords_4","","Wed password");
									add_option("rotating_universal_passwords_5","","Thu password");
									add_option("rotating_universal_passwords_6","","Fri password");
									add_option("rotating_universal_passwords_7","","Sat password");
									add_option("rotating_universal_passwords_8","7","Attempts");
							}
							if ($_REQUEST["mommaincontrol_momrups"] == 3) {
								delete_option("rotating_universal_passwords_1");
								delete_option("rotating_universal_passwords_2");
								delete_option("rotating_universal_passwords_3");
								delete_option("rotating_universal_passwords_4");
								delete_option("rotating_universal_passwords_5");
								delete_option("rotating_universal_passwords_6");
								delete_option("rotating_universal_passwords_7");
								delete_option("rotating_universal_passwords_8");
							}
						}
											
					if ($_REQUEST["mommaincontrol_momse"] != "" . get_option("mommaincontrol_momse") . "") { 
						update_option("mommaincontrol_momse",$_REQUEST["mommaincontrol_momse"]); 
						
						if ($_REQUEST["mommaincontrol_momse"] == 1) {
								add_option("simple_announcement_with_exclusion_9","","Categories front");
								add_option("simple_announcement_with_exclusion_9_2","","Categories front and tag");
								add_option("simple_announcement_with_exclusion_9_3","","Categories everywhere");
								add_option("simple_announcement_with_exclusion_9_4","","tags front");
								add_option("simple_announcement_with_exclusion_9_5","","tags front and category");
								add_option("simple_announcement_with_exclusion_9_7","","tags everywhere");		
								add_option("simple_announcement_with_exclusion_9_8","","format everywhere");		
								add_option("simple_announcement_with_exclusion_9_9","","format everywhere");		
								add_option("simple_announcement_with_exclusion_9_10","","format everywhere");		
								add_option("simple_announcement_with_exclusion_9_11","","format everywhere");	
								add_option("simple_announcement_with_exclusion_9_12","","Exclude cats from feed");
								add_option("simple_announcement_with_exclusion_9_13","","Exclude tags from feed");
								add_option("simple_announcement_with_exclusion_9_14","","Exclude post-format from feed");		
								add_option("simple_announcement_with_exclusion_sun","","Exclude Sunday");
								add_option("simple_announcement_with_exclusion_mon","","Exclude Monday");
								add_option("simple_announcement_with_exclusion_tue","","Exclude Tuesday");
								add_option("simple_announcement_with_exclusion_wed","","Exclude Wednesday");
								add_option("simple_announcement_with_exclusion_thu","","Exclude Thursday");
								add_option("simple_announcement_with_exclusion_fri","","Exclude Friday");
								add_option("simple_announcement_with_exclusion_sat","","Exclude Saturday");
								add_option("simple_announcement_with_exclusion_cat_sun","","Exclude categories Sunday");
								add_option("simple_announcement_with_exclusion_cat_mon","","Exclude categories Monday");
								add_option("simple_announcement_with_exclusion_cat_tue","","Exclude categories Tuesday");
								add_option("simple_announcement_with_exclusion_cat_wed","","Exclude categories Wednesday");
								add_option("simple_announcement_with_exclusion_cat_thu","","Exclude categories Thursday");
								add_option("simple_announcement_with_exclusion_cat_fri","","Exclude categories Friday");
								add_option("simple_announcement_with_exclusion_cat_sat","","Exclude categories Saturday");								
						}
						if ($_REQUEST["mommaincontrol_momse"] == 3) {
							delete_option("simple_announcement_with_exclusion_9");
							delete_option("simple_announcement_with_exclusion_9_2");
							delete_option("simple_announcement_with_exclusion_9_3");
							delete_option("simple_announcement_with_exclusion_9_4");
							delete_option("simple_announcement_with_exclusion_9_5");
							delete_option("simple_announcement_with_exclusion_9_7");
							delete_option("simple_announcement_with_exclusion_9_8");
							delete_option("simple_announcement_with_exclusion_9_9");
							delete_option("simple_announcement_with_exclusion_9_10");
							delete_option("simple_announcement_with_exclusion_9_11");
							delete_option("simple_announcement_with_exclusion_9_12");
							delete_option("simple_announcement_with_exclusion_9_13");
							delete_option("simple_announcement_with_exclusion_9_14");
							delete_option("simple_announcement_with_exclusion_sun");
							delete_option("simple_announcement_with_exclusion_mon");
							delete_option("simple_announcement_with_exclusion_tue");
							delete_option("simple_announcement_with_exclusion_wed");
							delete_option("simple_announcement_with_exclusion_thu");
							delete_option("simple_announcement_with_exclusion_fri");
							delete_option("simple_announcement_with_exclusion_sat");				
							delete_option("simple_announcement_with_exclusion_cat_sun");
							delete_option("simple_announcement_with_exclusion_cat_mon");
							delete_option("simple_announcement_with_exclusion_cat_tue");
							delete_option("simple_announcement_with_exclusion_cat_wed");
							delete_option("simple_announcement_with_exclusion_cat_thu");
							delete_option("simple_announcement_with_exclusion_cat_fri");
							delete_option("simple_announcement_with_exclusion_cat_sat");												
							delete_option("simple_announcement_with_exclusion_cat_sun");
							delete_option("simple_announcement_with_exclusion_cat_mon");
							delete_option("simple_announcement_with_exclusion_cat_tue");
							delete_option("simple_announcement_with_exclusion_cat_wed");
							delete_option("simple_announcement_with_exclusion_cat_thu");
							delete_option("simple_announcement_with_exclusion_cat_fri");
							delete_option("simple_announcement_with_exclusion_cat_sat");
						}
					}

					if ($_REQUEST["mommaincontrol_mompaf"] != "" . get_option("mommaincontrol_mompaf") . "") { 
						update_option("mommaincontrol_mompaf",$_REQUEST["mommaincontrol_mompaf"]); 
						
						if ($_REQUEST["mommaincontrol_mompaf"] == 1) {
							## If we're enabling Post as Front for the first time, set up its options.
								add_option("mompaf_post","0","Post ID to use as front page");
						}
						if ($_REQUEST["mommaincontrol_mompaf"] == 3) {
							## If we're uninstalling Post as Front, remove the options from the database.
								delete_option("mompaf_post");
						}
					}
					
					if ($_REQUEST["mommaincontrol_momja"] != "" . get_option("mommaincontrol_momja") ."") { 
						update_option("mommaincontrol_momja",$_REQUEST["mommaincontrol_momja"]); 
						
						if ($_REQUEST["mommaincontrol_momja"] == 1) {
							## If we're enabling Jump Around for the first time, set up its options.				
									add_option("jump_around_0","post","Post wrap");
									add_option("jump_around_1","entry-title","Link wrap");
									add_option("jump_around_2","previous-link","Previous link");
									add_option("jump_around_3","next-link","Next link");
									add_option("jump_around_4","65","Previous");
									add_option("jump_around_5","83","View");
									add_option("jump_around_6","68","Next");
									add_option("jump_around_7","90","Older posts");
									add_option("jump_around_8","88","Newer posts");
						}
						if ($_REQUEST["mommaincontrol_momja"] == 3) {
							## If we're enabling Count++ for the first time, set up its options.				
							delete_option("jump_around_0");
							delete_option("jump_around_1");
							delete_option("jump_around_2");
							delete_option("jump_around_3");
							delete_option("jump_around_4");
							delete_option("jump_around_5");
							delete_option("jump_around_6");
							delete_option("jump_around_7");
							delete_option("jump_around_8");
					
						}
					}
					
					if ($_REQUEST["mommaincontrol_shorts"] != "" . get_option("mommaincontrol_shorts") ."") { 
						update_option("mommaincontrol_shorts",$_REQUEST["mommaincontrol_shorts"]); 
					}

					if ($_REQUEST["mommaincontrol_analytics"] != "" . get_option("mommaincontrol_analytics") ."") { 
						update_option("mommaincontrol_analytics",$_REQUEST["mommaincontrol_analytics"]); 
						
						if ($_REQUEST["mommaincontrol_analytics"] == 1) {
							## If we're enabling Analytics for the first time, set up its options.				
									add_option("momanalytics_code","","Tracking ID");
						}
						if ($_REQUEST["mommaincontrol_analytics"] == 3) {
							## If we're enabling Analytics for the first time, set up its options.				
							delete_option("momanalytics_code");
						}						
						
						
					}					
					
				}
			}
		}
		
		## options form (output)
		function my_optional_modules_form() {
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_analytics\">Analytics</label>
				</th>
				<td>
					<select id=\"mommaincontrol_analytics\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_analytics\">
					<option value=\"0\" 
						";
							if (get_option("mommaincontrol_analytics") == 0 || get_option("mommaincontrol_analytics") == 3) { echo "selected=\"selected\""; }
							echo ">No</option>					
							<option value=\"1\" 
							";
							if (get_option("mommaincontrol_analytics") == 1) { echo "selected=\"selected\""; }
							echo ">Yes</option>
							<option value=\"3\">Uninstall</option>
						</select>
					</td>
				<td>";
				if (get_option("mommaincontrol_analytics") == 0 || get_option("mommaincontrol_analytics") == 3) { echo "<em>Insert your Google Analytics tracking code.</em>"; }
				## Analytics
				if (get_option("mommaincontrol_analytics") == 1) { include('analytics.php'); }	
				echo "</td>
			</tr>
						
			<tr valign=\"top\">
				<th scope=\"row\"><label for=\"mommaincontrol_obwcountplus\">Count++</label></th>
				<td>
					<select id=\"mommaincontrol_obwcountplus\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_obwcountplus\">
					<option value=\"0\" 
					";
						if (get_option("mommaincontrol_obwcountplus") == 0 || get_option("mommaincontrol_obwcountplus") == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if (get_option("mommaincontrol_obwcountplus") == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td><em>Count all words from all published posts (word count).  Optional: Keep track of a Total Word Goal.</em></td>
			</tr>
			";

			if(is_plugin_active('jump-around/jumparound.php')){
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">Jump Around</th>
				<td>Activated (Standalone)</td>
				<td>You currently have the standalone version of Jump Around installed and active.  Please disable and delete it to use this module.</td>
			</tr>"; } else {			
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_momja\">Jump Around</label>
				</th>
				<td>
					<select id=\"mommaincontrol_momja\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_momja\">
					<option value=\"0\" 
					";
						if (get_option("mommaincontrol_momja") == 0 || get_option("mommaincontrol_momja") == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if (get_option("mommaincontrol_momja") == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>
					<em>Navigate posts by pressing keys on the keyboard. (<strong>May require template editing</strong>)</em>
				</td>
			</tr>";
			}		
			
			echo "<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_mompaf\">Post as Front</label>
				</th>
				<td>
					<select id=\"mommaincontrol_mompaf\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_mompaf\">
					<option value=\"0\" 
					";
						if (get_option("mommaincontrol_mompaf") == 0 || get_option("mommaincontrol_mompaf") == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if (get_option("mommaincontrol_mompaf") == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>";
				if (get_option("mommaincontrol_mompaf") == 0 || get_option("mommaincontrol_mompaf") == 3) { echo "<em>Select a specific post to be your home page, or make your home page your most recent post.</em>"; }
				## Post as Front
				if (get_option("mommaincontrol_mompaf") == 1) { include('postasfront.php'); }	

				echo "</td>
			</tr>";
			
			if(is_plugin_active('rotating-universal-passwords/RUPs.php')){
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">RUPs</th>
				<td>Activated (Standalone)</td>
				<td>You currently have the standalone version of RUPs installed and active.  Please disable and delete it to use this module.</td>
			</tr>"; } else {			
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_momrups\">RUPs</label>
				</th>
				<td>
					<select id=\"mommaincontrol_momrups\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_momrups\">
					<option value=\"0\" 
					";
						if (get_option("mommaincontrol_momrups") == 0 || get_option("mommaincontrol_momrups") == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if (get_option("mommaincontrol_momrups") == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>
					<em>Hide password-protected content using [rups]the shortcode[/rups].  Passwords are rotated once per day.</em>
				</td>
			</tr>";
			}
			
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_shorts\">Shortcodes!</label>
				</th>
				<td>
					<select id=\"mommaincontrol_shorts\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_shorts\">
					<option value=\"0\" 
					";
						if (get_option("mommaincontrol_shorts") == 0 || get_option("mommaincontrol_shorts") == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if (get_option("mommaincontrol_shorts") == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>
					<em>A collection of various shortcodes that you can use in your posts and pages.</em>
				</td>
			</tr>			
			
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_momse\">Simply Exclude (SE)</label>
				</th>
				<td>
					<select id=\"mommaincontrol_momse\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_momse\">
					<option value=\"0\" 
					";
						if (get_option("mommaincontrol_momse") == 0 || get_option("mommaincontrol_momse") == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if (get_option("mommaincontrol_momse") == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>
					<em>Exclude tags, post formats, and categories from the front page, category/tag archives, search results, or the RSS feed.</em>
				</td>
			</tr>			

			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_uninstall_all\">Uninstall/Deactivate All Modules</label>
				</th>
				<td>
					<select id=\"mommaincontrol_uninstall_all\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_uninstall_all\">
					<option value=\"0\"></option>					
					<option value=\"1\">Reset all</option>
					<option value=\"3\">Nuke</option>
					</select>
				</td>
				<td>
					<em>Uninstalls all options associated with all modules and deactivates them.  If you choose to Nuke the install, it uninstalls <strong>everything</strong> associated with this plugin (for plugin deletion purposes).  If you decide to nuke it, you may need to deactivate/reactivate the plugin.</em>
				</td>
			</tr>			

			
			";
		}
	
		## options form (output)
		function my_optional_modules_page_content() {
			echo "
			<div class=\"wrap\">
				<div id=\"icon-options-general\" class=\"icon32\"></div>
				<h2>My Optional Modules</h2>
				<p>My Optional Modules (or <em>MOM</em>) is a bundle of optional modules for Wordpress 
				which give extra functionality 
				not currently available in a fresh installation.  They are designed to be lightweight and easilly implemented by even the most novice of 
				Wordpress users.</p>
				<p>Deactivating modules will deactivate their associated functionality.  All code examples accounts for this with 
				a check to see if the function being called exists (is active).</p>";
			if(isset($_POST['momsave']) || isset($_POST['mompafsave'])){
				echo "<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>";
			}
			if ($_REQUEST["mommaincontrol_uninstall_all"] == 3) {
				$uninstalled = 1;
				echo "<div id=\"setting-error-settings_nuked\" class=\"updated settings-error\"><p>All settings associated with MOM have been wiped from your database.  You may now uninstall this plugin.  All customized settings for individual modules have been lost, however.</p><p>Thanks for using <em>My Optional Modules</em>, and good luck in your future endeavors!</div>";
			}				
			if ($uninstalled == 1) { } else {
				echo "<form method=\"post\">
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
				<tbody>				
				<tr valign=\"top\"><td>Modules</td></tr>
				<tr valign=\"top\">
						<td>Module name</td>
						<td>Activated?</td>
						<td>Description</td>
				</tr>
				";
				my_optional_modules_form();
				echo "</tbody>
					<tr valign=\"top\"><td><input id=\"momsave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"momsave\"></input></td></tr>
					</table>
				</form>";
				
					$revisions_count = 0;
					global $table_prefix, $table_suffix, $wpdb;
					$postsTable = $table_prefix . $table_suffix . 'posts';
					$revisions_total = $wpdb->get_results ("SELECT ID FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto_draft' OR `post_status` = 'trash'");
					foreach ($revisions_total as $retot) {
						$revisions_count++;
					}
					$comments_count = 0;
					$commentsTable = $table_prefix . $table_suffix . 'comments';
					$comments_total = $wpdb->get_results ("SELECT comment_ID FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
					foreach ($comments_total as $comtot) {
						$comments_count++;
					}					
					$terms_count = 0;
					$termsTable = $table_prefix . $table_suffix . 'term_taxonomy';
					$termsTable2 = $table_prefix . $table_suffix . 'terms';
					$terms_total = $wpdb->get_results ("SELECT term_taxonomy_id FROM `" . $termsTable . "` WHERE `count` = '0'");
					foreach ($terms_total as $termstot) {
					    $this_term = $termstot->term_id;
						$terms_count++;
					}					
				
				echo "<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
				<tbody>				
				<tr valign=\"top\"><td>Tools</td></tr>
				<tr valign=\"top\">
						<td>Database cleaner</td>
						<td>
							<form method=\"post\"><input id=\"delete_post_revisions\" class=\"button button-primary\" type=\"submit\" value=\"Delete " . $revisions_count . " revisions, drafts, and trashed posts\" name=\"delete_post_revisions\"></input></form><br />
							<form method=\"post\"><input id=\"delete_unapproved_comments\" class=\"button button-primary\" type=\"submit\" value=\"Delete " . $comments_count . " unapproved, trashed, or spam comments\" name=\"delete_unapproved_comments\"></input></form><br />
							<form method=\"post\"><input id=\"delete_unused_terms\" class=\"button button-primary\" type=\"submit\" value=\"Delete " . $terms_count . " unused tags and categories\" name=\"delete_unused_terms\"></input></form>
						</td>
						<td>Clean your database of unnecessary clutter.</td>
				</tr>				
				";
			}
			echo "</div>";
			
			if(isset($_POST['delete_post_revisions'])){
						$wpdb->query("DELETE FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");				
			}
			if(isset($_POST['delete_unapproved_comments'])){
						$wpdb->query("DELETE FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");				
			}			
			if(isset($_POST['delete_unused_terms'])){
						$wpdb->query("DELETE FROM `" . $termsTable2 . "` WHERE `term_id` IN (select `term_id` from `" . $termsTable . "` WHERE `count` = 0 )");
						$wpdb->query("DELETE FROM `" . $termsTable . "` WHERE `count` = 0");
						
			}			
			
		}
		
		if(isset($_POST["momsave"])){
			if ($_REQUEST["momsave"]) { 
				update_myoptionalmodules_options();
			}
		}
	} 
 ?>