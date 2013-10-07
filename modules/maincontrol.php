<?php 

	if(!defined('MyOptionalModules')) {
	die('You can not call this file directly.');
	}

 ## MOM Main Control
	## MOM
	## 	register activation/deactivation hooks
	##	register options page
	if (is_admin() ) {
		add_action("admin_menu", "my_optional_modules_add_options_page");
	}
	
	## Get the options set up by the plugin for use throughout
	$mommaincontrol_obwcountplus = get_option("mommaincontrol_obwcountplus");
	$mommaincontrol_momrups = get_option("mommaincontrol_momrups");	
	$mommaincontrol_momse = get_option("mommaincontrol_momse");
	$mommaincontrol_mompaf = get_option("mommaincontrol_mompaf");
	$mommaincontrol_momja = get_option("mommaincontrol_momja");
	
	## MOM options page
		function my_optional_modules_add_options_page() {																
			$myoptionalmodules_options = add_options_page("MOM: Main Control", "MOM: Main Control", "manage_options", "mommaincontrol", "my_optional_modules_page_content");
		}	
		
	## Check if admin or not
	if (is_admin() ) { 
	
	##	Update options if form is submitted
		function update_myoptionalmodules_options() {
			global $mommaincontrol_obwcountplus;
			global $mommaincontrol_momrups;
			global $mommaincontrol_momse;
			global $mommaincontrol_mompaf;
			global $mommaincontrol_momja;
			
			if(isset($_POST['momsave'])){
				if ($_REQUEST["mommaincontrol_uninstall_all"] == 1 || $_REQUEST["mommaincontrol_uninstall_all"] == 3) {
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 1) {	
						global $table_prefix, $table_suffix, $wpdb;
						$table_name = $table_prefix . $table_suffix . 'rotating_universal_passwords';
						$wpdb->query("DROP TABLE {$table_name}");											
						delete_option("obwcountplus_1_countdownfrom");
						delete_option("obwcountplus_2_remaining");
						delete_option("obwcountplus_3_total");
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
					}
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 3) {
						global $table_prefix, $table_suffix, $wpdb;
						$table_name = $table_prefix . $table_suffix . 'rotating_universal_passwords';
						$wpdb->query("DROP TABLE {$table_name}");											
						delete_option("obwcountplus_1_countdownfrom");
						delete_option("obwcountplus_2_remaining");
						delete_option("obwcountplus_3_total");
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
					}
				} else {					
						if ($_REQUEST["mommaincontrol_obwcountplus"] != "$mommaincontrol_obwcountplus") { 
							update_option("mommaincontrol_obwcountplus",$_REQUEST["mommaincontrol_obwcountplus"]); 
							
							if ($_REQUEST["mommaincontrol_obwcountplus"] == 1) {
								## If we're enabling Count++ for the first time, set up its options.
								if (!get_option("obwcountplus_1_countdownfrom") || !get_option("obwcountplus_2_remaining") || !get_option("obwcountplus_3_total")) {
									add_option("obwcountplus_1_countdownfrom","0","Word goal to count down to?");
									add_option("obwcountplus_2_remaining","remaining","Word to describe remaining amount of words until goal.");
									add_option("obwcountplus_3_total","total","Word to describe words total present on blog.");
								}
							}
							if ($_REQUEST["mommaincontrol_obwcountplus"] == 3) {
								## If we're uninstalling Count++, remove the options from the database.
									delete_option("obwcountplus_1_countdownfrom");
									delete_option("obwcountplus_2_remaining");
									delete_option("obwcountplus_3_total");
							}
						}
						
						if ($_REQUEST["mommaincontrol_momrups"] != "$mommaincontrol_momrups") { 
							update_option("mommaincontrol_momrups",$_REQUEST["mommaincontrol_momrups"]); 
						
							if ($_REQUEST["mommaincontrol_momrups"] == 1) {
								if (!get_option("rotating_universal_passwords_1") || !get_option("rotating_universal_passwords_2") || !get_option("rotating_universal_passwords_3") || !get_option("rotating_universal_passwords_4") || !get_option("rotating_universal_passwords_5") || !get_option("rotating_universal_passwords_6") || !get_option("rotating_universal_passwords_7") || !get_option("rotating_universal_passwords_8")) {
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
											
					if ($_REQUEST["mommaincontrol_momse"] != "$mommaincontrol_momse") { 
						update_option("mommaincontrol_momse",$_REQUEST["mommaincontrol_momse"]); 
						
						if ($_REQUEST["mommaincontrol_momse"] == 1) {
							if (!get_option('simple_announcement_with_exclusion_9') || !get_option('simple_announcement_with_exclusion_9_2') || !get_option('simple_announcement_with_exclusion_9_3') || !get_option('simple_announcement_with_exclusion_9_4') || !get_option('simple_announcement_with_exclusion_9_5') || !get_option('simple_announcement_with_exclusion_9_7') || !get_option('simple_announcement_with_exclusion_9_8') || !get_option('simple_announcement_with_exclusion_9_9') || !get_option('simple_announcement_with_exclusion_9_10') || !get_option('simple_announcement_with_exclusion_9_11') || !get_option('simple_announcement_with_exclusion_9_12') || !get_option('simple_announcement_with_exclusion_9_13') || !get_option('simple_announcement_with_exclusion_9_14') ) {			
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
							}
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
						}
					}

					if ($_REQUEST["mommaincontrol_mompaf"] != "$mommaincontrol_mompaf") { 
						update_option("mommaincontrol_mompaf",$_REQUEST["mommaincontrol_mompaf"]); 
						
						if ($_REQUEST["mommaincontrol_mompaf"] == 1) {
							## If we're enabling Post as Front for the first time, set up its options.
							if (!get_option('mompaf_post')) {
								add_option("mompaf_post","","Post ID to use as front page");
							}
						}
						if ($_REQUEST["mommaincontrol_mompaf"] == 3) {
							## If we're uninstalling Post as Front, remove the options from the database.
								delete_option("mompaf_post");
						}
					}
					
					if ($_REQUEST["mommaincontrol_momja"] != "$mommaincontrol_momja") { 
						update_option("mommaincontrol_momja",$_REQUEST["mommaincontrol_momja"]); 
						
						if ($_REQUEST["mommaincontrol_momja"] == 1) {
							## If we're enabling Jump Around for the first time, set up its options.				
								if (!get_option('jump_around_0') || !get_option('jump_around_1') || !get_option('jump_around_2') || !get_option('jump_around_3') || !get_option('jump_around_4') || !get_option('jump_around_5') || !get_option('jump_around_6') || !get_option('jump_around_7') || !get_option('jump_around_8')){ 
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
				}
			}
		}
		
	##	Form to save the plugin options from.
		function my_optional_modules_form() {
			global $mommaincontrol_obwcountplus;
			global $mommaincontrol_momrups;
			global $mommaincontrol_momse;
			global $mommaincontrol_mompaf;
			global $mommaincontrol_momja;
		
			echo "
			
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_obwcountplus\">Count++</label>
				</th>
				<td>
					<select id=\"mommaincontrol_obwcountplus\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_obwcountplus\">
					<option value=\"0\" 
					";
						if ($mommaincontrol_obwcountplus == 0 || $mommaincontrol_obwcountplus == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if ($mommaincontrol_obwcountplus == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>
					<em>Count all words from all published posts (word count).  Optional: Keep track of a Total Word Goal.</em>
				</td>
			</tr>";

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
						if ($mommaincontrol_momja == 0 || $mommaincontrol_momja == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if ($mommaincontrol_momja == 1) { echo "selected=\"selected\""; }
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
					<label for=\"mommaincontrol_mompaf\">Post as Front (PAF)</label>
				</th>
				<td>
					<select id=\"mommaincontrol_mompaf\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_mompaf\">
					<option value=\"0\" 
					";
						if ($mommaincontrol_mompaf == 0 || $mommaincontrol_mompaf == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if ($mommaincontrol_mompaf == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>
					<em>Select a specific post to be your home page, or make your home page your most recent post.</em>
				</td>
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
						if ($mommaincontrol_momrups == 0 || $mommaincontrol_momrups == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if ($mommaincontrol_momrups == 1) { echo "selected=\"selected\""; }
					echo ">Yes</option>
					<option value=\"3\">Uninstall</option>
						</select>
				</td>
				<td>
					<em>Hide password-protected content using [rups]the shortcode[/rups].  Passwords are rotated once per day.</em>
				</td>
			</tr>";
			}
			
			echo "<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_momse\">Simply Exclude (SE)</label>
				</th>
				<td>
					<select id=\"mommaincontrol_momse\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_momse\">
					<option value=\"0\" 
					";
						if ($mommaincontrol_momse == 0 || $mommaincontrol_momse == 3) { echo "selected=\"selected\""; }
					echo ">No</option>					
					<option value=\"1\" 
					";
						if ($mommaincontrol_momse == 1) { echo "selected=\"selected\""; }
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
					<em>Uninstalls all options associated with all modules and deactivates them.  If you choose to Nuke the install, it uninstalls <strong>everything</strong> associated with this plugin (for plugin deletion purposes).  If you decide to nuke it, you'll need to deactivate/reactivate the plugin.</em>
				</td>
			</tr>			

			
			";
		}
	
	##	Plugin options page output.
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
				
			echo "<h3 class=\"title\">Modules</h3>";
				
			if(isset($_POST['momsave'])){
				echo "<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>";
			}
			if ($_REQUEST["mommaincontrol_uninstall_all"] == 3) {
				$uninstalled = 1;
				echo "<div id=\"setting-error-settings_nuked\" class=\"updated settings-error\"><p>All settings associated with MOM have been wiped from your database.  You may now uninstall this plugin.  All customized settings for individual modules have been lost, however.</p><p>Thanks for using <em>My Optional Modules</em>, and good luck in your future endeavors!</div>";
			}				
				
			if ($uninstalled == 1) { } else {
				echo "<form method=\"post\">
					<table class=\"form-table\">
						<tbody>
						<td>Module name</td>
						<td>Activated?</td>
						<td>Description</td>
				";
				my_optional_modules_form();
				echo "
						</tbody>
					</table>
					<p class=\"submit\">
						<input id=\"momsave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"momsave\"></input>
					</p>
				</form>";
			}
			
			echo "</div>";
		}

				if(isset($_POST["momsave"])){
					if ($_REQUEST["momsave"]) { 
						update_myoptionalmodules_options();
					}
				}		
	
	} 
 ?>