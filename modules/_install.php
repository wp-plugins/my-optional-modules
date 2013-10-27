<?php if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }
	
	// Install script
	update_option("mommaincontrol_shorts",$_REQUEST["mommaincontrol_shorts"]);
	update_option("mommaincontrol_analytics",$_REQUEST["mommaincontrol_analytics"]);
	update_option("mommaincontrol_reviews",$_REQUEST["mommaincontrol_reviews"]);
	update_option("mommaincontrol_momja",$_REQUEST["mommaincontrol_momja"]);							
	update_option("mommaincontrol_momse",$_REQUEST["mommaincontrol_momse"]);
	update_option("mommaincontrol_momrups",$_REQUEST["mommaincontrol_momrups"]);
	update_option("mommaincontrol_fontawesome",$_REQUEST["mommaincontrol_fontawesome"]);
	update_option("mommaincontrol_versionnumbers",$_REQUEST["mommaincontrol_versionnumbers"]);
	update_option("mommaincontrol_obwcountplus",$_REQUEST["mommaincontrol_obwcountplus"]);				
					
	// Count++
	if ( $_REQUEST["mommaincontrol_obwcountplus"] == 1 && !get_option('obwcountplus_1_countdownfrom') ) { add_option("obwcountplus_1_countdownfrom","0","Word goal to count down to?"); }
	if ( $_REQUEST["mommaincontrol_obwcountplus"] == 1 && !get_option('obwcountplus_2_remaining') ) { add_option("obwcountplus_2_remaining","remaining","Word to describe remaining amount of words until goal."); }
	if ( $_REQUEST["mommaincontrol_obwcountplus"] == 1 && !get_option('obwcountplus_3_total') ) { add_option("obwcountplus_3_total","total","Word to describe words total present on blog."); }
	if ( $_REQUEST["mommaincontrol_obwcountplus"] == 1 && !get_option('obwcountplus_4_custom') ) { add_option("obwcountplus_4_custom","","Custom output."); }

	// Passwords
	if ($_REQUEST["mommaincontrol_momrups"] == 1) {
		global $wpdb;
		$RUPs_table_name = $wpdb->prefix . $wpdb->suffic . "rotating_universal_passwords";
		$RUPs_sql = "CREATE TABLE $RUPs_table_name (
		ID INT( 11 ) NOT NULL PRIMARY KEY AUTO_INCREMENT , 
		DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		ATTEMPTS INT( 11 ) NOT NULL, 
		IP INT( 11 ) NOT NULL
		);";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $RUPs_sql );
	}	
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_1') ) { add_option("rotating_universal_passwords_1","","Sun password"); }
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_2') ) { add_option("rotating_universal_passwords_2","","Mon password"); }
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_3') ) { add_option("rotating_universal_passwords_3","","Tue password"); }
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_4') ) { add_option("rotating_universal_passwords_4","","Wed password"); }
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_5') ) { add_option("rotating_universal_passwords_5","","Thu password"); }
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_6') ) { add_option("rotating_universal_passwords_6","","Fri password"); }
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_7') ) { add_option("rotating_universal_passwords_7","","Sat password"); }
	if ( $_REQUEST["mommaincontrol_momrups"] == 1 && !get_option('rotating_universal_passwords_8') ) { add_option("rotating_universal_passwords_8","7","Attempts"); }

	// Exclude				
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9') ) { add_option("simple_announcement_with_exclusion_9","","Categories front"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_2') ) { add_option("simple_announcement_with_exclusion_9_2","","Categories front and tag"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_3') ) { add_option("simple_announcement_with_exclusion_9_3","","Categories everywhere"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_4') ) { add_option("simple_announcement_with_exclusion_9_4","","tags front"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_5') ) { add_option("simple_announcement_with_exclusion_9_5","","tags front and category"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_7') ) { add_option("simple_announcement_with_exclusion_9_7","","tags everywhere"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_8') ) { add_option("simple_announcement_with_exclusion_9_8","","format everywhere"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_9') ) { add_option("simple_announcement_with_exclusion_9_9","","format everywhere"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_10') ) { add_option("simple_announcement_with_exclusion_9_10","","format everywhere"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_11') ) { add_option("simple_announcement_with_exclusion_9_11","","format everywhere"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_12') ) { add_option("simple_announcement_with_exclusion_9_12","","Exclude cats from feed"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_13') ) { add_option("simple_announcement_with_exclusion_9_13","","Exclude tags from feed"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_9_14') ) { add_option("simple_announcement_with_exclusion_9_14","","Exclude post-format from feed"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_sun') ) { add_option("simple_announcement_with_exclusion_sun","","Exclude Sunday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_mon') ) { add_option("simple_announcement_with_exclusion_mon","","Exclude Monday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_tue') ) { add_option("simple_announcement_with_exclusion_tue","","Exclude Tuesday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_wed') ) { add_option("simple_announcement_with_exclusion_wed","","Exclude Wednesday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_thu') ) { add_option("simple_announcement_with_exclusion_thu","","Exclude Thursday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_fri') ) { add_option("simple_announcement_with_exclusion_fri","","Exclude Friday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_sat') ) { add_option("simple_announcement_with_exclusion_sat","","Exclude Saturday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_cat_') ) { add_option("simple_announcement_with_exclusion_cat_sun","","Exclude categories Sunday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_cat_') ) { add_option("simple_announcement_with_exclusion_cat_mon","","Exclude categories Monday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_cat_') ) { add_option("simple_announcement_with_exclusion_cat_tue","","Exclude categories Tuesday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_cat_') ) { add_option("simple_announcement_with_exclusion_cat_wed","","Exclude categories Wednesday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_cat_') ) { add_option("simple_announcement_with_exclusion_cat_thu","","Exclude categories Thursday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_cat_') ) { add_option("simple_announcement_with_exclusion_cat_fri","","Exclude categories Friday"); } 
	if ( $_REQUEST["mommaincontrol_momse"] == 1 && !get_option('simple_announcement_with_exclusion_cat_') ) { add_option("simple_announcement_with_exclusion_cat_sat","","Exclude categories Saturday"); } 
	if ( $_REQUEST["mommaincontrol_mompaf"] != "" . get_option('mommaincontrol_mompaf') . "") { update_option("mommaincontrol_mompaf",$_REQUEST["mommaincontrol_mompaf"]); }
	if ( $_REQUEST["mommaincontrol_mompaf"] == 1 && !get_option('mompaf_post') ) { add_option("mompaf_post","0","Post ID to use as front page"); }

	// Jump Around					
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_0","post","Post wrap"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_1","entry-title","Link wrap"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_2","previous-link","Previous link"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_3","next-link","Next link"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_4","65","Previous"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_5","83","View"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_6","68","Next"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_7","90","Older posts"); }
	if ( $_REQUEST["mommaincontrol_momja"] == 1 && !get_option('jump_around_0') ) { add_option("jump_around_8","88","Newer posts"); }

	if ( $_REQUEST["mommaincontrol_analytics"] == 1 && !get_option('momanalytics_code') ) { add_option("momanalytics_code","","Tracking ID"); }

	if ( $_REQUEST["mommaincontrol_reviews"] == 1 && !get_option('momreviews_css') ) {
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
	
?>