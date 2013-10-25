<?php 

	// Main Control Panel
	// MCP contents
	// options page
	//   - options form (save)
	//   - options form (output)
	//   - options page (output)
	// set home page post content

	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }
		
	// Check if admin or not
	if (is_admin() ) { 

		// options page
		add_action("admin_menu", "my_optional_modules_add_options_page");
		function my_optional_modules_add_options_page() { $myoptionalmodules_options = add_options_page("MOM: Main Control", "MOM: Main Control", "manage_options", "mommaincontrol", "my_optional_modules_page_content"); }	
	
		// options form (save)
		function update_myoptionalmodules_options() {
			if(isset($_POST['momsave'])){
				if ($_REQUEST["mommaincontrol_uninstall_all"] == 1 || $_REQUEST["mommaincontrol_uninstall_all"] == 3 || $_REQUEST["mommaincontrol_uninstall_all"] == 4 || $_REQUEST["mommaincontrol_uninstall_all"] == 5) {
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 5) {	
						update_option("mommaincontrol_obwcountplus",0);
						update_option("mommaincontrol_momrups",0);
						update_option("mommaincontrol_momse",0);
						update_option("mommaincontrol_mompaf",0);
						update_option("mommaincontrol_momja",0);			
						update_option("mommaincontrol_shorts",0);
						update_option("mommaincontrol_analytics",0);
						update_option("mommaincontrol_reviews",0);
						update_option("mommaincontrol_fontawesome",0);
						update_option("mommaincontrol_versionnumbers",0);
					}
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 4) {	
						update_option("mommaincontrol_obwcountplus",1);
						update_option("mommaincontrol_momrups",1);
						update_option("mommaincontrol_momse",1);
						update_option("mommaincontrol_mompaf",1);
						update_option("mommaincontrol_momja",1);			
						update_option("mommaincontrol_shorts",1);
						update_option("mommaincontrol_analytics",1);
						update_option("mommaincontrol_reviews",1);
						update_option("mommaincontrol_fontawesome",1);
						update_option("mommaincontrol_versionnumbers",1);

							global $wpdb;
							add_option("obwcountplus_1_countdownfrom","0","Word goal to count down to?");
							add_option("obwcountplus_2_remaining","remaining","Word to describe remaining amount of words until goal.");
							add_option("obwcountplus_3_total","total","Word to describe words total present on blog.");
							add_option("obwcountplus_4_custom","","Custom output.");
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
							add_option("rotating_universal_passwords_1","","Sun password");
							add_option("rotating_universal_passwords_2","","Mon password");
							add_option("rotating_universal_passwords_3","","Tue password");
							add_option("rotating_universal_passwords_4","","Wed password");
							add_option("rotating_universal_passwords_5","","Thu password");
							add_option("rotating_universal_passwords_6","","Fri password");
							add_option("rotating_universal_passwords_7","","Sat password");
							add_option("rotating_universal_passwords_8","7","Attempts");
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
							add_option("mompaf_post","0","Post ID to use as front page");
							add_option("jump_around_0","post","Post wrap");
							add_option("jump_around_1","entry-title","Link wrap");
							add_option("jump_around_2","previous-link","Previous link");
							add_option("jump_around_3","next-link","Next link");
							add_option("jump_around_4","65","Previous");
							add_option("jump_around_5","83","View");
							add_option("jump_around_6","68","Next");
							add_option("jump_around_7","90","Older posts");
							add_option("jump_around_8","88","Newer posts");
							add_option("momanalytics_code","","Tracking ID");
							add_option("momreviews_search", "");
							add_option("momreviews_css", "
							/* Colors */
							.momreview .block { background-color: #fff; color: #000; }
							.momreview section.reviewed { background-color: #fff; color: #000; }
							.momreview ::selection { background: #222; color: #fff; }
							.momreview label { color: #111; text-shadow: 1px 1px 2px #ccc; }
							/* Containers */
							.momreview { margin: 0 auto; width: 95%; }
							.momreview .block { padding-top: 5px; margin: 0 auto 0 auto; }
							.momreview label { width: 95%; min-height: 35px; margin: 0 auto; display: block; cursor: pointer; }
							.momreview .reviewed { width: 93%; height: 0; padding: 0 15px 0 15px; display: block; overflow: hidden; box-sizing: border-box; margin: auto; } 
							/* Do not edit below this line */
							/* unless you know what you're doing. */
							.momreview label span { font-weight: bold; float:right; }
							.momreview input[type='checkbox']  { display: none; }
							.momreview .block input[type='checkbox']:checked ~ .reviewed { height: auto; margin: -25px auto 5px auto; }
							.momreview .block input[type='checkbox'] ~ label span:first-of-type { display:block; visibility:visible; float:right; margin:0 -5px 0 0; }
							.momreview .block input[type='checkbox'] ~ label span:last-of-type,
							.momreview .block input[type='checkbox']:checked ~ label span:first-of-type { display:none; visibility:hidden; float:right; }
							.momreview .block input[type='checkbox']:checked ~ label span:last-of-type { display:block; visibility:visible; float:right; }
							", "Reviews CSS" );
							$review_table_name = $wpdb->prefix . $wpdb->suffix . "momreviews";
							$reviews_sql = "CREATE TABLE $review_table_name (
							ID INT( 11 ) NOT NULL PRIMARY KEY AUTO_INCREMENT , 
							TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
							LINK TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
							TITLE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
							REVIEW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
							RATING TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
							);";
							require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
							dbDelta( $reviews_sql );						
						
					}
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 1) {	
						update_option("mommaincontrol_obwcountplus",0);
						update_option("mommaincontrol_momrups",0);
						update_option("mommaincontrol_momse",0);
						update_option("mommaincontrol_mompaf",0);
						update_option("mommaincontrol_momja",0);			
						update_option("mommaincontrol_shorts",0);
						update_option("mommaincontrol_analytics",0);
						update_option("mommaincontrol_reviews",0);
						update_option("mommaincontrol_fontawesome",0);
						update_option("mommaincontrol_versionnumbers",0);
						global $wpdb;
						$table_name = $wpdb->prefix . $wpdb->suffix . 'rotating_universal_passwords';
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
						$reviews_table_name = $wpdb->prefix . $wpdb->suffix . 'momreviews';
						$wpdb->query("DROP TABLE {$reviews_table_name}");							
						delete_option("momreviews_css");
						delete_option("momreviews_search");
					}
					if ($_REQUEST["mommaincontrol_uninstall_all"] == 3) {
						global $wpdb;
						$table_name = $wpdb->prefix . $wpdb->suffix . 'rotating_universal_passwords';
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
						delete_option("mommaincontrol_reviews");					
						delete_option("mommaincontrol_fontawesome");
						delete_option("mommaincontrol_versionnumbers");
						$reviews_table_name = $wpdb->prefix . $wpdb->suffix . 'momreviews';
						$wpdb->query("DROP TABLE {$reviews_table_name}");	
						delete_option("momreviews_css");
						delete_option("momreviews_search");
					}
				} else {					
						if ($_REQUEST["mommaincontrol_obwcountplus"] != "" . get_option("mommaincontrol_obwcountplus") ."") { 
							update_option("mommaincontrol_obwcountplus",$_REQUEST["mommaincontrol_obwcountplus"]); 
							
							if ($_REQUEST["mommaincontrol_obwcountplus"] == 1) {
								// If we're enabling Count++ for the first time, set up its options.
									add_option("obwcountplus_1_countdownfrom","0","Word goal to count down to?");
									add_option("obwcountplus_2_remaining","remaining","Word to describe remaining amount of words until goal.");
									add_option("obwcountplus_3_total","total","Word to describe words total present on blog.");
									add_option("obwcountplus_4_custom","","Custom output.");
							}
							if ($_REQUEST["mommaincontrol_obwcountplus"] == 3) {
								// If we're uninstalling Count++, remove the options from the database.
									delete_option("obwcountplus_1_countdownfrom");
									delete_option("obwcountplus_2_remaining");
									delete_option("obwcountplus_3_total");
									delete_option("obwcountplus_4_custom");
							}
						}
						
						if ($_REQUEST["mommaincontrol_fontawesome"] != "" . get_option("mommaincontrol_fontawesome") . "") {
							update_option("mommaincontrol_fontawesome",1);
						}
						if ($_REQUEST["mommaincontrol_versionnumbers"] != "" . get_option("mommaincontrol_versionnumbers") . "") {
							update_option("mommaincontrol_versionnumbers",1);
						}
						
						if ($_REQUEST["mommaincontrol_momrups"] != "" . get_option("mommaincontrol_momrups") . "") { 
							update_option("mommaincontrol_momrups",$_REQUEST["mommaincontrol_momrups"]); 
						
							if ($_REQUEST["mommaincontrol_momrups"] == 1) {
									// Create table for lockouts (if bad password attempts are made, store IPs, timer, etc.
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
									// core settings
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
							// If we're enabling Post as Front for the first time, set up its options.
								add_option("mompaf_post","0","Post ID to use as front page");
						}
						if ($_REQUEST["mommaincontrol_mompaf"] == 3) {
							// If we're uninstalling Post as Front, remove the options from the database.
								delete_option("mompaf_post");
						}
					}
					
					if ($_REQUEST["mommaincontrol_momja"] != "" . get_option("mommaincontrol_momja") ."") { 
						update_option("mommaincontrol_momja",$_REQUEST["mommaincontrol_momja"]); 
						
						if ($_REQUEST["mommaincontrol_momja"] == 1) {
							// If we're enabling Jump Around for the first time, set up its options.				
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
							// If we're enabling Count++ for the first time, set up its options.				
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
							// If we're enabling Analytics for the first time, set up its options.				
									add_option("momanalytics_code","","Tracking ID");
						}
						if ($_REQUEST["mommaincontrol_analytics"] == 3) {
							// If we're enabling Analytics for the first time, set up its options.				
							delete_option("momanalytics_code");
						}						
					}

						if ($_REQUEST["mommaincontrol_reviews"] != "" . get_option("mommaincontrol_reviews") . "") { 
							update_option("mommaincontrol_reviews",$_REQUEST["mommaincontrol_reviews"]); 
						
							if ($_REQUEST["mommaincontrol_reviews"] == 1) {
add_option("momreviews_css", "
/* Colors */
.momreview .block { background-color: #fff; color: #000; }
.momreview section.reviewed { background-color: #fff; color: #000; }
.momreview ::selection { background: #222; color: #fff; }
.momreview label { color: #111; text-shadow: 1px 1px 2px #ccc; }
/* Containers */
.momreview { margin: 0 auto; width: 95%; }
.momreview .block { padding-top: 5px; margin: 0 auto 0 auto; }
.momreview label { width: 95%; min-height: 35px; margin: 0 auto; display: block; cursor: pointer; }
.momreview .reviewed { width: 93%; height: 0; padding: 0 15px 0 15px; display: block; overflow: hidden; box-sizing: border-box; margin: auto; } 
/* Do not edit below this line */
/* unless you know what you're doing. */
.momreview label span { font-weight: bold; float:right; }
.momreview input[type='checkbox']  { display: none; }
.momreview .block input[type='checkbox']:checked ~ .reviewed { height: auto; margin: -25px auto 5px auto; }
.momreview .block input[type='checkbox'] ~ label span:first-of-type { display:block; visibility:visible; float:right; margin:0 -5px 0 0; }
.momreview .block input[type='checkbox'] ~ label span:last-of-type,
.momreview .block input[type='checkbox']:checked ~ label span:first-of-type { display:none; visibility:hidden; float:right; }
.momreview .block input[type='checkbox']:checked ~ label span:last-of-type { display:block; visibility:visible; float:right; }
", "Reviews CSS" );
							global $wpdb;
							$review_table_name = $wpdb->prefix . $wpdb->suffix . "momreviews";
							$reviews_sql = "CREATE TABLE $review_table_name (
								ID INT( 11 ) NOT NULL PRIMARY KEY AUTO_INCREMENT , 
								TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
								LINK TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
								TITLE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
								REVIEW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
								RATING TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
							);";
							require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
							dbDelta( $reviews_sql );
							}
							if ($_REQUEST["mommaincontrol_reviews"] == 3) {
								delete_option("mommaincontrol_reviews");
								delete_option("momreviews_css");
								delete_option("momreviews_search");
							}
						}
					
				}
			}
		}
		
		// options form (output)
		function my_optional_modules_form() {
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_analytics\"><strong>Analytics</strong></label>
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
				// Analytics
				if (get_option("mommaincontrol_analytics") == 1) { include('analytics.php'); }	
				echo "</td>
			</tr>
						
			<tr valign=\"top\">
				<th scope=\"row\"><label for=\"mommaincontrol_obwcountplus\"><strong>Count++</strong></label></th>
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
				<th scope=\"row\"><strong>Jump Around</strong></th>
				<td>Activated (Standalone)</td>
				<td>You currently have the standalone version of Jump Around installed and active.  Please disable and delete it to use this module.</td>
			</tr>"; } else {			
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_momja\"><strong>Jump Around</strong></label>
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
			
			echo "
				<tr valign=\"top\">
					<th scope=\"row\">
						<label for=\"mommaincontrol_reviews\"><strong>Reviews</strong></label>
					</th>
					<td>
						<select id=\"mommaincontrol_reviews\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_reviews\">
						<option value=\"0\" 
						";
							if (get_option("mommaincontrol_reviews") == 0 || get_option("mommaincontrol_reviews") == 3) { echo "selected=\"selected\""; }
						echo ">No</option>					
						<option value=\"1\" 
						";
							if (get_option("mommaincontrol_reviews") == 1) { echo "selected=\"selected\""; }
						echo ">Yes</option>
						<option value=\"3\">Uninstall</option>
							</select>
					</td>
					<td><em>Rate and review anything.</em></td>
				</tr>
				<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_mompaf\"><strong>Post as Front</strong></label>
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
				// Post as Front
				if (get_option("mommaincontrol_mompaf") == 1) { include('postasfront.php'); }	

				echo "</td>
			</tr>";

			if(is_plugin_active('rotating-universal-passwords/RUPs.php')){
			echo "
			<tr valign=\"top\">
				<th scope=\"row\"><strong>Passwords</strong></th>
				<td>Activated (Standalone)</td>
				<td>You currently have the standalone version of RUPs installed and active.  Please disable and delete it to use this module.</td>
			</tr>"; } else {			
			echo "
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mommaincontrol_momrups\"><strong>Passwords</strong></label>
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
					<label for=\"mommaincontrol_shorts\"><strong>Shortcodes!</strong></label>
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
					<label for=\"mommaincontrol_momse\"><strong>Exclude</strong></label>
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
					<label for=\"mommaincontrol_uninstall_all\"><strong>All Modules</strong></label>
				</th>
				<td>
					<select id=\"mommaincontrol_uninstall_all\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_uninstall_all\">
					<option value=\"0\"></option>					
					<option value=\"4\">Activate all</option>
					<option value=\"5\">Deactivate all</option>
					<option value=\"1\">Reset all</option>
					<option value=\"3\">Nuke</option>
					</select>
				</td>
				<td>
					<em>Activate all/deactivate all activates or deactivates all modules.  Reset all deactivates all modules, and deletes all options associated with them.  Nuke deletes all options associated with this plugin, and allows for you to cleanly disable and delete it.  (You will need to deactivate and reactivate the plugin in order to use it again after using Nuke.)</em>
				</td>
			</tr>			
			";
		}
	
		// options form (output)
		function my_optional_modules_page_content() {
			echo "
			<div class=\"wrap\">
				<div id=\"icon-options-general\" class=\"icon32\"></div>
				<h2>My Optional Modules</h2>";
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
				<tr valign=\"top\"><td><h3 class=\"title\">Modules</h3></td></tr>
				<tr valign=\"top\">
						<td><u>Module name</u></td>
						<td><u>Activated?</u></td>
						<td><u>Description</u></td>
				</tr>
				";
				my_optional_modules_form();
				echo "</tbody>
					</table>
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
					<tbody>				
						<tr valign=\"top\"><td><h3 class=\"title\">Tweaks</h3></td></tr>
						<tr valign=\"top\"><td><strong>Font Awesome</strong></td>
						<td>
						<select id=\"mommaincontrol_fontawesome\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_fontawesome\">
						<option value=\"0\" 
						";
							if (get_option("mommaincontrol_fontawesome") == 0) { echo "selected=\"selected\""; }
						echo ">No</option>					
						<option value=\"1\" 
						";
							if (get_option("mommaincontrol_fontawesome") == 1) { echo "selected=\"selected\""; }
						echo ">Yes</option>
						</select>
						</td>
						<td><em>Enable <a href=\"http://fortawesome.github.io/Font-Awesome/\">Font Awesome</a> on your theme, allowing you to use all available <a href=\"http://fortawesome.github.io/Font-Awesome/icons/\">icons</a>.  (Don't fgorget to prefix all font awesome i class calls with fa ( <i class='fa some-icon'</i>) or you will get broken font images.)</td></tr>

						<tr valign=\"top\"><td><strong>Hide WP Version</strong></td>
						<td>
						<select id=\"mommaincontrol_versionnumbers\" class=\"regular-text\" type=\"text\" name=\"mommaincontrol_versionnumbers\">
						<option value=\"0\" 
						";
							if (get_option("mommaincontrol_versionnumbers") == 0) { echo "selected=\"selected\""; }
						echo ">No</option>					
						<option value=\"1\" 
						";
							if (get_option("mommaincontrol_versionnumbers") == 1) { echo "selected=\"selected\""; }
						echo ">Yes</option>
						</select>
						</td>
						<td><em>Hide Wordpress version number from enqueued scripts and stylesheets on the front end of your website.</em></td></tr>
					</tbody>
				</table>
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\"><tbody><tr valign=\"top\"><td><input id=\"momsave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"momsave\"></input></td><td>Save any changes made to any options above.</td></tr></tbody></table>
				</form>
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
					<tbody>				
						<tr valign=\"top\"><td><h3 class=\"title\">Tools</h3></td></tr>";
							include( 'databasecleaner.php');
				echo "	
					</tbody>
				</table>
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
					<tbody>
						<tr>
							<td><p><h3 class=\"title\"><em>Don't forget</em> to <a href=\"http://wordpress.org/support/view/plugin-reviews/my-optional-modules\">rate and review</a> this plugin &mdash; it would be greatly appreciated!</h3></p></td>
						</tr>
					</tbody>
				</table>
				</div>";				
			}
		}
		if(isset($_POST["momsave"])){ update_myoptionalmodules_options(); }
	} 
 ?>