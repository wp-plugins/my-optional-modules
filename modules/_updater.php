<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}

    global $wpdb;
    $RUPs_table_name         = $wpdb->prefix . $wpdb->suffix . "rotating_universal_passwords";
    $review_table_name       = $wpdb->prefix . $wpdb->suffix . "momreviews";
	$verification_table_name = $wpdb->prefix . $wpdb->suffix . "momverification";

	if ( isset( $_POST[ 'MOM_UNINSTALL_EVERYTHING' ] ) ) {
		$wpdb->query( "DROP TABLE {$RUPs_table_name}" );
		$wpdb->query( "DROP TABLE {$review_table_name}" );
		$wpdb->query( "DROP TABLE {$verification_table_name}" );
        delete_option( 'mommaincontrol_obwcountplus' );
        delete_option( 'mommaincontrol_momrups' );
        delete_option( 'mommaincontrol_momse' );
        delete_option( 'mommaincontrol_mompaf' );
        delete_option( 'mommaincontrol_momja' );            
        delete_option( 'mommaincontrol_shorts' );
        delete_option( 'mommaincontrol_analytics' );
        delete_option( 'mommaincontrol_reviews' );
        delete_option( 'mommaincontrol_fontawesome' );
        delete_option( 'mommaincontrol_versionnumbers' );
		delete_option( 'mommaincontrol_lazyload' );
		delete_option( 'mommaincontrol_meta' );
        delete_option( 'mommaincontrol_focus');
		delete_option( 'mommaincontrol_maintenance');		

		delete_option( 'obwcountplus_1_countdownfrom' );
		delete_option( 'obwcountplus_2_remaining' );
		delete_option( 'obwcountplus_3_total' );
		delete_option( 'obwcountplus_4_custom' );

		delete_option( 'rotating_universal_passwords_1' );
		delete_option( 'rotating_universal_passwords_2' );
		delete_option( 'rotating_universal_passwords_3' );
		delete_option( 'rotating_universal_passwords_4' );
		delete_option( 'rotating_universal_passwords_5' );
		delete_option( 'rotating_universal_passwords_6' );
		delete_option( 'rotating_universal_passwords_7' );
		delete_option( 'rotating_universal_passwords_8' );    
		
		delete_option('MOM_Exclude_VisitorCategories');
		delete_option('MOM_Exclude_VisitorTags');
		delete_option('MOM_Exclude_Categories_Front');
		delete_option('MOM_Exclude_Categories_TagArchives');
		delete_option('MOM_Exclude_Categories_SearchResults');
		delete_option('MOM_Exclude_Tags_Front');
		delete_option('MOM_Exclude_Tags_CategoryArchives');
		delete_option('MOM_Exclude_Tags_SearchResults');
		delete_option('MOM_Exclude_PostFormats_Front');
		delete_option('MOM_Exclude_PostFormats_CategoryArchives');
		delete_option('MOM_Exclude_PostFormats_TagArchives');
		delete_option('MOM_Exclude_PostFormats_SearchResults');
		delete_option('MOM_Exclude_Categories_RSS');
		delete_option('MOM_Exclude_Tags_RSS');
		delete_option('MOM_Exclude_PostFormats_RSS');
		delete_option('MOM_Exclude_TagsSun');
		delete_option('MOM_Exclude_TagsMon');
		delete_option('MOM_Exclude_TagsTue');
		delete_option('MOM_Exclude_TagsWed');
		delete_option('MOM_Exclude_TagsThu');
		delete_option('MOM_Exclude_TagsFri');
		delete_option('MOM_Exclude_TagsSat');
		delete_option('MOM_Exclude_CategoriesSun');
		delete_option('MOM_Exclude_CategoriesMon');
		delete_option('MOM_Exclude_CategoriesTue');
		delete_option('MOM_Exclude_CategoriesWed');
		delete_option('MOM_Exclude_CategoriesThu');
		delete_option('MOM_Exclude_CategoriesFri');
		delete_option('MOM_Exclude_CategoriesSat');
		
		delete_option( 'mommaincontrol_setfocus' );
		delete_option( 'mommaincontrol' );
		delete_option( 'mompaf_post' );

		delete_option( 'jump_around_0' );
		delete_option( 'jump_around_1' );
		delete_option( 'jump_around_2' );
		delete_option( 'jump_around_3' );
		delete_option( 'jump_around_4' );
		delete_option( 'jump_around_5' );
		delete_option( 'jump_around_6' );
		delete_option( 'jump_around_7' );
		delete_option( 'jump_around_8' );        
		delete_option( 'momanalytics_code' );            
		delete_option( 'momreviews_css' );
		delete_option( 'momreviews_search' );
		delete_option( 'momMaintenance_url' );
		delete_option('simple_announcement_with_exclusion_cat_visitor');
		delete_option('simple_announcement_with_exclusion_tag_visitor');
	
	} else {	
	
		// Form handling for options a
		if(isset($_POST['MOMsave'])){}
		if(isset($_POST['mom_count_mode_submit'])){update_option('mommaincontrol_obwcountplus',$_REQUEST['countplus']);}
		if(isset($_POST['mom_exclude_mode_submit'])){update_option('mommaincontrol_momse',$_REQUEST['exclude']);}
		if(isset($_POST['mom_jumparound_mode_submit'])){update_option('mommaincontrol_momja',$_REQUEST['jumparound']);}
		if(isset($_POST['mom_passwords_mode_submit'])){update_option('mommaincontrol_momrups',$_REQUEST['passwords']);}
		if(isset($_POST['mom_reviews_mode_submit'])){update_option('mommaincontrol_reviews',$_REQUEST['reviews']); }
		if(isset($_POST['mom_shortcodes_mode_submit'])){update_option('mommaincontrol_shorts',$_REQUEST['shortcodes']);}
		if(isset($_POST['MOMclear'])){update_option('mommaincontrol_focus','');}
		if(isset($_POST['MOMexclude'])){update_option('mommaincontrol_focus','exclude');}
		if(isset($_POST['MOMfontfa'])){update_option('mommaincontrol_focus','fontfa');}
		if(isset($_POST['MOMcount'])){update_option('mommaincontrol_focus','count');}
		if(isset($_POST['MOMjumparound'])){update_option('mommaincontrol_focus','jumparound');}
		if(isset($_POST['MOMpasswords'])){update_option('mommaincontrol_focus','passwords');}
		if(isset($_POST['MOMreviews'])){update_option('mommaincontrol_focus','reviews'); }
		if(isset($_POST['MOMshortcodes'])){update_option('mommaincontrol_focus','shortcodes');}
		if(isset($_POST['mom_maintenance_url_submit'])){update_option('momMaintenance_url',$_REQUEST['momMaintenance_url']);}
		if(isset($_POST['mom_analytics_code_submit'])){update_option('momanalytics_code',$_REQUEST['momanalytics_code']);}
		if(isset($_POST['mom_postasfront_post_submit'])){update_option('mompaf_post',$_REQUEST['mompaf_post']);}
		if(isset($_POST['mom_fontawesome_mode_submit'])){update_option('mommaincontrol_fontawesome',$_REQUEST['mommaincontrol_fontawesome']);}
		if(isset($_POST['mom_lazy_mode_submit'])){update_option('mommaincontrol_lazyload',$_REQUEST['mommaincontrol_lazyload']);}
		if(isset($_POST['mom_versions_submit'])){update_option('mommaincontrol_versionnumbers',$_REQUEST['mommaincontrol_versionnumbers']);}
		if(isset($_POST['mom_meta_mode_submit'])){update_option('mommaincontrol_meta',$_REQUEST['mommaincontrol_meta']);}
		if(isset($_POST['mom_maintenance_mode_submit'])){update_option('mommaincontrol_maintenance',$_REQUEST['maintenanceMode']);}
		if(isset($_POST['mom_analytics_mode_submit'])){update_option('mommaincontrol_analytics',$_REQUEST['analytics']);}
		if(isset($_POST['mom_postasfront_mode_submit'])){update_option('mommaincontrol_mompaf',$_REQUEST['postasfront']);
		if(!get_option('mommaincontrol_mompaf')){add_option('mompaf_post',0);}}
		if($_POST['mom_count_mode_submit']){add_option('obwcountplus_1_countdownfrom',0);}
		if($_POST['mom_count_mode_submit']){add_option('obwcountplus_2_remaining','remaining');}
		if($_POST['mom_count_mode_submit']){add_option('obwcountplus_3_total','total');}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_0','post');}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_1','entry-title');}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_2','previous-link');}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_3','next-link');}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_4',65);}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_5',83);}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_6',68);}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_7',90);}
		if($_POST['mom_jumparound_mode_submit']){add_option('jump_around_8',88);}
		if($_POST[ 'mom_passwords_mode_submit']){add_option('rotating_universal_passwords_8','7');}    
		
		if ( $_POST[ 'mom_passwords_mode_submit'      ] ) {
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
		if($_POST['mom_postasfront_mode_submit']){add_option('mompaf_post',0); }    
		if ( $_POST[ 'mom_reviews_mode_submit' ] ) {
		add_option("momreviews_search", "");
		add_option( 'momreviews_css','
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
	/* unless you know what you\'re doing. */
	.momreview label span { font-weight: bold; float:right; }
	.momreview input[type=\'checkbox\']  { display: none; }
	.momreview .block input[type=\'checkbox\']:checked ~ .reviewed { height: auto; margin: -25px auto 5px auto; }
	.momreview .block input[type=\'checkbox\'] ~ label span:first-of-type { display:block; visibility:visible; float:right; margin:0 -5px 0 0; }
	.momreview .block input[type=\'checkbox\'] ~ label span:last-of-type,
	.momreview .block input[type=\'checkbox\']:checked ~ label span:first-of-type { display:none; visibility:hidden; float:right; }
	.momreview .block input[type=\'checkbox\']:checked ~ label span:last-of-type { display:block; visibility:visible; float:right; }
	','Reviews CSS' );
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
		if ( $_POST[ 'mom_shortcodes_mode_submit' ] ) {
			global $wpdb;
			$verification_table_name = $wpdb->prefix . $wpdb->suffix . "momverification";
			$verification_sql = "CREATE TABLE $verification_table_name (
			ID INT( 11 ) NOT NULL PRIMARY KEY AUTO_INCREMENT , 
			POST INT( 11 ) NOT NULL, 
			CORRECT INT( 11 ) NOT NULL, 
			IP INT( 11 ) NOT NULL
			);";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $verification_sql );		
		}
		if ( $_POST[ 'mom_maintenance_mode_submit' ] ) {
			add_option( 'momMaintenance_url','','Maintenance URL to redirect to when in maintenance mode.' );
		}
	}
?>