<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

if(current_user_can('manage_options')){
	global $wpdb;
	$votesPosts = $wpdb->prefix.'momvotes_posts';
	$votesVotes = $wpdb->prefix.'momvotes_votes';
	$RUPs_table_name = $wpdb->prefix.'rotating_universal_passwords';
	$review_table_name = $wpdb->prefix.'momreviews';
	$verification_table_name = $wpdb->prefix.'momverification';
	if(isset($_POST['MOM_UNINSTALL_EVERYTHING'])){
		add_option('mommaincontrol_passwords_activated',1);					
		add_option('mommaincontrol_reviews_activated',1);
		add_option('mommaincontrol_shorts_activated',1);
		add_option('mommaincontrol_votes_activated',1);
		if(get_option('mommaincontrol_votes_activated') == 0){$wpdb->query("DROP TABLE ".$votesPosts."");$wpdb->query("DROP TABLE ".$votesVotes."");}
		if(get_option('mommaincontrol_passwords_activated') == 0){$wpdb->query("DROP TABLE ".$RUPs_table_name."");}
		if(get_option('mommaincontrol_reviews_activated') == 0){$wpdb->query("DROP TABLE ".$review_table_name."");}
		if(get_option('mommaincontrol_shorts_activated') == 0){$wpdb->query("DROP TABLE ".$verification_table_name."");}
		$option = array('MOM_themetakeover_ajaxcomments','MOM_themetakeover_commentlength','MOM_themetakeover_horizontal_galleries','mommaincontrol_prettycanon','mommaincontrol_fixcanon','mommaincontrol_votes_activated','mommaincontrol_protectrss','MOM_themetakeover_extend','MOM_themetakeover_backgroundimage',
		'MOM_themetakeover_topbar_search','MOM_themetakeover_topbar_share','MOM_themetakeover_topbar_color','mommaincontrol_footerscripts','mommaincontrol_authorarchives','mommaincontrol_datearchives','MOM_themetakeover_wowhead',
		'mom_passwords_salt','mommaincontrol_obwcountplus','mommaincontrol_momrups','mommaincontrol_momse','mommaincontrol_mompaf','mommaincontrol_momja','mommaincontrol_shorts','mommaincontrol_reviews',
		'mommaincontrol_fontawesome','mommaincontrol_versionnumbers','mommaincontrol_lazyload','mommaincontrol_meta','mommaincontrol_focus','mommaincontrol_maintenance','mommaincontrol_themetakeover','mommaincontrol_setfocus',
		'mommaincontrol','mompaf_post','obwcountplus_1_countdownfrom','obwcountplus_2_remaining','obwcountplus_3_total','obwcountplus_4_custom','rotating_universal_passwords_1','rotating_universal_passwords_2','rotating_universal_passwords_3',
		'rotating_universal_passwords_4','rotating_universal_passwords_5','rotating_universal_passwords_6','rotating_universal_passwords_7','rotating_universal_passwords_8','MOM_Exclude_VisitorCategories','MOM_Exclude_VisitorTags',
		'MOM_Exclude_Categories_Front','MOM_Exclude_Categories_TagArchives','MOM_Exclude_Categories_SearchResults','MOM_Exclude_Tags_Front','MOM_Exclude_Tags_CategoryArchives','MOM_Exclude_Tags_SearchResults','MOM_Exclude_PostFormats_Front',
		'MOM_Exclude_PostFormats_CategoryArchives','MOM_Exclude_PostFormats_TagArchives','MOM_Exclude_PostFormats_SearchResults','MOM_Exclude_Categories_RSS','MOM_Exclude_Tags_RSS','MOM_Exclude_PostFormats_RSS','MOM_Exclude_TagsSun',
		'MOM_Exclude_TagsMon','MOM_Exclude_TagsTue','MOM_Exclude_TagsWed','MOM_Exclude_TagsThu','MOM_Exclude_TagsFri','MOM_Exclude_TagsSat','MOM_Exclude_CategoriesSun','MOM_Exclude_CategoriesMon','MOM_Exclude_CategoriesTue','MOM_Exclude_CategoriesWed',
		'MOM_Exclude_CategoriesThu','MOM_Exclude_CategoriesFri','MOM_Exclude_CategoriesSat','MOM_Exclude_level0Categories','MOM_Exclude_level1Categories','MOM_Exclude_level2Categories','MOM_Exclude_level7Categories','MOM_Exclude_level0Tags',
		'MOM_Exclude_level1Tags','MOM_Exclude_level2Tags','MOM_Exclude_level7Tags','MOM_Exclude_URL','MOM_Exclude_URL_User','MOM_Exclude_PostFormats_Visitor','MOM_Exclude_NoFollow','simple_announcement_with_exclusion_cat_visitor',
		'simple_announcement_with_exclusion_tag_visitor','mommaincontrol_passwords_activated','MOM_themetakeover_youtubefrontpage','MOM_themetakeover_topbar','MOM_themetakeover_archivepage','MOM_themetakeover_fitvids','MOM_themetakeover_postdiv',
		'MOM_themetakeover_postelement','MOM_themetakeover_posttoggle','mommaincontrol_shorts_activated','jump_around_0','jump_around_1','jump_around_2','jump_around_3','jump_around_4','jump_around_5','jump_around_6','jump_around_7',
		'jump_around_8','mommaincontrol_reviews_activated','momanalytics_code','momreviews_css','momreviews_search','momMaintenance_url','mommaincontrol_votes');
		foreach ($option as &$value){
			delete_option($value);
		}
	}else{	
		if(isset($_POST['MOMsave'])){}
		if(isset($_POST['mom_themetakeover_mode_submit']))update_option('mommaincontrol_themetakeover',$_REQUEST['themetakeover']);
		if(isset($_POST['mom_protectrss_mode_submit']))update_option('mommaincontrol_protectrss',$_REQUEST['protectrss']);
		if(isset($_POST['mom_footerscripts_mode_submit']))update_option('mommaincontrol_footerscripts',$_REQUEST['footerscripts']);
		if(isset($_POST['mom_author_archives_mode_submit']))update_option('mommaincontrol_authorarchives',$_REQUEST['authorarchives']);
		if(isset($_POST['mom_date_archives_mode_submit']))update_option('mommaincontrol_datearchives',$_REQUEST['datearchives']);
		if(isset($_POST['mom_votes_mode_submit']))update_option('mommaincontrol_votes',$_REQUEST['votes']);
		if(isset($_POST['mom_exclude_mode_submit']))update_option('mommaincontrol_momse',$_REQUEST['exclude']);
		if(isset($_POST['mom_passwords_mode_submit']))update_option('mommaincontrol_momrups',$_REQUEST['passwords']);
		if(isset($_POST['mom_reviews_mode_submit']))update_option('mommaincontrol_reviews',$_REQUEST['reviews']);
		if(isset($_POST['mom_shortcodes_mode_submit']))update_option('mommaincontrol_shorts',$_REQUEST['shortcodes']);
		if(isset($_POST['MOMclear']))update_option('mommaincontrol_focus','');
		if(isset($_POST['MOMthemetakeover']))update_option('mommaincontrol_focus','themetakeover');
		if(isset($_POST['MOMexclude']))update_option('mommaincontrol_focus','exclude');
		if(isset($_POST['MOMfontfa']))update_option('mommaincontrol_focus','fontfa');
		if(isset($_POST['MOMcount']))update_option('mommaincontrol_focus','count');
		if(isset($_POST['MOMjumparound']))update_option('mommaincontrol_focus','jumparound');
		if(isset($_POST['MOMpasswords']))update_option('mommaincontrol_focus','passwords');
		if(isset($_POST['MOMreviews']))update_option('mommaincontrol_focus','reviews');
		if(isset($_POST['MOMshortcodes']))update_option('mommaincontrol_focus','shortcodes');
		if(isset($_POST['mom_fontawesome_mode_submit']))update_option('mommaincontrol_fontawesome',$_REQUEST['mommaincontrol_fontawesome']);
		if(isset($_POST['mom_lazy_mode_submit']))update_option('mommaincontrol_lazyload',$_REQUEST['mommaincontrol_lazyload']);
		if(isset($_POST['mom_versions_submit']))update_option('mommaincontrol_versionnumbers',$_REQUEST['mommaincontrol_versionnumbers']);
		if(isset($_POST['mom_meta_mode_submit']))update_option('mommaincontrol_meta',$_REQUEST['mommaincontrol_meta']);
		if(isset($_POST['mom_maintenance_mode_submit']))update_option('mommaincontrol_maintenance',$_REQUEST['maintenanceMode']);
		if(!get_option('mommaincontrol_mompaf'))add_option('mompaf_post','off');
		if(isset($_POST['mom_maintenance_mode_submit']))add_option('momMaintenance_url','');
		
		if(isset($_POST['mom_postasfront_post_submit'])){
			update_option('momMaintenance_url',$_REQUEST['momMaintenance_url']);
			update_option('momanalytics_code',$_REQUEST['momanalytics_code']);
			update_option('mompaf_post',$_REQUEST['mompaf_post']);
		}
		
		if(isset($_POST['mom_count_mode_submit'])){
			update_option('mommaincontrol_obwcountplus',$_REQUEST['countplus']);
			add_option('obwcountplus_1_countdownfrom',0);
			add_option('obwcountplus_2_remaining','remaining');
			add_option('obwcountplus_3_total','total');
		}
		if(isset($_POST['mom_jumparound_mode_submit'])){
			update_option('mommaincontrol_momja',$_REQUEST['jumparound']);
			add_option('jump_around_0','.post');
			add_option('jump_around_1','.entry-title');
			add_option('jump_around_2','.previous-link');
			add_option('jump_around_3','.next-link');
			add_option('jump_around_4',65);
			add_option('jump_around_5',83);
			add_option('jump_around_6',68);
			add_option('jump_around_7',90);
			add_option('jump_around_8',88);
		}
		
		
		if(isset($_POST['mom_votes_mode_submit'])){
			add_option('mommaincontrol_votes_activated',1);					
			if(get_option('mommaincontrol_votes_activated') == 1){
				$votesSQLa = "CREATE TABLE $votesVotes(
					ID INT(11) NOT NULL AUTO_INCREMENT , 
					IP INT(11) NOT NULL,
					VOTE INT(11) NOT NULL,
					PRIMARY KEY  (ID)
				);";
				$votesSQLb = "CREATE TABLE $votesPosts(
					ID INT(11) NOT NULL AUTO_INCREMENT , 
					UP INT(11) NOT NULL,
					DOWN BIGINT(11) NOT NULL,
					PRIMARY KEY  (ID)
				);";
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($votesSQLa);	
				dbDelta($votesSQLb);	
				update_option('mommaincontrol_votes_activated',0);
			}
		}
		
		if(isset($_POST['mom_passwords_mode_submit'])){
			add_option('rotating_universal_passwords_1','');
			add_option('rotating_universal_passwords_2','');
			add_option('rotating_universal_passwords_3','');
			add_option('rotating_universal_passwords_4','');
			add_option('rotating_universal_passwords_5','');
			add_option('rotating_universal_passwords_6','');
			add_option('rotating_universal_passwords_7','');
			add_option('rotating_universal_passwords_8','7');
			add_option('mommaincontrol_passwords_activated',1);					
			if(get_option('mommaincontrol_passwords_activated') == 1){
				$RUPs_sql = "CREATE TABLE $RUPs_table_name(
					ID INT(11) NOT NULL AUTO_INCREMENT , 
					DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
					URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
					ATTEMPTS INT(11) NOT NULL, 
					IP INT(11) NOT NULL,
					PRIMARY KEY  (ID)
				);";
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($RUPs_sql);	
				update_option('mommaincontrol_passwords_activated',0);
			}
		}
		add_option('mompaf_post','off');
		if(isset($_POST['mom_reviews_mode_submit'])){
			add_option('mommaincontrol_reviews_activated',1);
			add_option('momreviews_search','');
			if(get_option('mommaincontrol_reviews_activated') == 1){
				global $wpdb;
				$review_table_name = $wpdb->prefix.'momreviews';
				$reviews_sql = "CREATE TABLE $review_table_name (
					ID INT(11) NOT NULL AUTO_INCREMENT,
					TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					LINK TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					TITLE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					REVIEW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					RATING TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					PRIMARY KEY  (ID)
				);";
				require_once(ABSPATH.'wp-admin/includes/upgrade.php');
				dbDelta($reviews_sql);
				update_option('mommaincontrol_reviews_activated',0);
			}
		}
		if(isset($_POST['mom_shortcodes_mode_submit'])){
			add_option('mommaincontrol_shorts_activated',1);
			if(get_option('mommaincontrol_shorts_activated') == 1){
				global $wpdb;
				$verification_table_name = $wpdb->prefix.'momverification';
				$verification_sql = "CREATE TABLE $verification_table_name(
					ID INT(11) NOT NULL AUTO_INCREMENT,
					POST INT(11) NOT NULL, 
					CORRECT INT(11) NOT NULL, 
					IP INT(11) NOT NULL,
					PRIMARY KEY  (ID)
				);";
				require_once(ABSPATH.'wp-admin/includes/upgrade.php');
				dbDelta($verification_sql);
				update_option('mommaincontrol_shorts_activated',0);
			}
		}
	}
	if(isset($_POST['reset_rups'])){
		delete_option('rotating_universal_passwords_1');delete_option('rotating_universal_passwords_2');delete_option('rotating_universal_passwords_3');delete_option('rotating_universal_passwords_4');delete_option('rotating_universal_passwords_5');delete_option('rotating_universal_passwords_6');delete_option('rotating_universal_passwords_7');	
		add_option('rotating_universal_passwords_1','');add_option('rotating_universal_passwords_2','');add_option('rotating_universal_passwords_3','');add_option('rotating_universal_passwords_4','');add_option('rotating_universal_passwords_5','');add_option('rotating_universal_passwords_6','');add_option('rotating_universal_passwords_7','');	
	}
	if(isset($_POST['passwordsSave'])){
		global $my_optional_modules_passwords_salt;
		foreach($_REQUEST as $k => $v){
			if($v != '')update_option($k,wp_hash($v));
		}
		update_option('rotating_universal_passwords_8',$_REQUEST['rotating_universal_passwords_8']);
	}	
	if(isset($_POST['momsesave'])){
		foreach($_REQUEST as $k => $v){
			update_option($k,$v);
		}
		update_option('MOM_Exclude_PostFormats_Visitor',sanitize_text_field($_REQUEST['MOM_Exclude_PostFormats_Visitor']));
		update_option('MOM_Exclude_PostFormats_RSS',sanitize_text_field($_REQUEST['MOM_Exclude_PostFormats_RSS']));
		update_option('MOM_Exclude_PostFormats_Front',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_Front'])));
		update_option('MOM_Exclude_PostFormats_CategoryArchives',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_CategoryArchives'])));
		update_option('MOM_Exclude_PostFormats_TagArchives',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_TagArchives'])));
		update_option('MOM_Exclude_PostFormats_SearchResults',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_SearchResults'])));
		update_option('MOM_Exclude_URL',$_REQUEST['MOM_Exclude_URL']);
		update_option('MOM_Exclude_URL_User',$_REQUEST['MOM_Exclude_URL_User']);
		update_option('MOM_Exclude_NoFollow',$_REQUEST['MOM_Exclude_NoFollow']);
		update_option('MOM_Exclude_Hide_Dashboard',$_REQUEST['MOM_Exclude_Hide_Dashboard']);
	}	
	if(isset($_POST['obwcountsave']) || isset($_POST['momthemetakeoversave']) || isset($_POST['update_JA'])){
		foreach($_REQUEST as $k => $v){
			update_option("$k","$v");
		}	
	}
}