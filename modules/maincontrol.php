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

	## MOM options page
		function my_optional_modules_add_options_page() {																
			$myoptionalmodules_options = add_options_page("MOM: Main Control", "MOM: Main Control", "manage_options", "mommaincontrol", "my_optional_modules_page_content");
		}	
	
	## Check if admin or not
	if (is_admin() ) { 
	
	##	Update options if form is submitted
		function update_myoptionalmodules_options() {
			global $mommaincontrol_obwcountplus;
				if(isset($_POST['momsave'])){

				if ($_REQUEST["mommaincontrol_obwcountplus"] != "$mommaincontrol_obwcountplus") { 
					update_option("mommaincontrol_obwcountplus",$_REQUEST["mommaincontrol_obwcountplus"]); 
					
					if ($_REQUEST["mommaincontrol_obwcountplus"] == 1) {
						## If we're enabling Count++ for the first time, set up its options.
						if (!get_option("obwcountplus_1_countdownfrom") || !get_option("obwcountplus_2_remaining") || !get_option("obwcountplus_3_total") || !get_option("obwcountplus_delete")) {
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
							global $RUPs_db_version;
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

				
				
			}		
		}
		
	##	Form to save the plugin options from.
		function my_optional_modules_form() {
			global $mommaincontrol_obwcountplus;
			global $mommaincontrol_momrups;
		
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
			
			if(is_plugin_active('rotating-universal-passwords/RUPs.php')){
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">RUPs</th>
				<td>Activate (Standalone)</td>
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
			</tr>
			";
		}
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
					
				if (is_plugin_inactive('rotating-universal-passwords/RUPs.php')){
					echo "
						<div class=\"updated settings-error\"><p>You currently have the standalone version of RUPs installed (but not active).  It is advised to delete this plugin as <em>My Optional Modules</em> incorporates the same functions and options, and both plugins will conflict with each other (if you decided to activate both the RUPs plugin and the RUPs module at the same time).</p></div>
					";
				}
					
				echo "<h3 class=\"title\">Modules</h3>
				";
				
				if(isset($_POST['momsave'])){
					echo "
						<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>
					";
				}
				
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
				</form>
				</div>
				";
		}

				if(isset($_POST["momsave"])){
					if ($_REQUEST["momsave"]) { 
						update_myoptionalmodules_options();
					}
				}		
	
	} 
 ?>