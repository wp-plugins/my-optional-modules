<?php 
	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }
	
	// Uninstall script
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
		update_option("mommaincontrol_focus","");
	}
	if ($_REQUEST["mommaincontrol_uninstall_all"] == 4) {	
		global $wpdb;
		$RUPs_table_name = $wpdb->prefix . $wpdb->suffix . "rotating_universal_passwords";
		$review_table_name = $wpdb->prefix . $wpdb->suffix . "momreviews";
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
		add_option("obwcountplus_1_countdownfrom","0","Word goal to count down to?");
		add_option("obwcountplus_2_remaining","remaining","Word to describe remaining amount of words until goal.");
		add_option("obwcountplus_3_total","total","Word to describe words total present on blog.");
		add_option("obwcountplus_4_custom","","Custom output.");
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
		global $wpdb;
		$table_name = $wpdb->prefix . $wpdb->suffix . 'rotating_universal_passwords';
		$reviews_table_name = $wpdb->prefix . $wpdb->suffix . 'momreviews';
		$wpdb->query("DROP TABLE {$table_name}");		
		$wpdb->query("DROP TABLE {$reviews_table_name}");								
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
		delete_option("momreviews_css");
		delete_option("momreviews_search");
	}

	if ($_REQUEST["mommaincontrol_uninstall_all"] == 3) {
		global $wpdb;
		$table_name = $wpdb->prefix . $wpdb->suffix . 'rotating_universal_passwords';
		$reviews_table_name = $wpdb->prefix . $wpdb->suffix . 'momreviews';
		$wpdb->query("DROP TABLE {$reviews_table_name}");	
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
		delete_option("momreviews_css");
		delete_option("momreviews_search");
		delete_option("mommaincontrol_focus");
	}
?>