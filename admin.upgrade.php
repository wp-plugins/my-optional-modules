<?php 

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}
if( is_admin() ) {
	
		// 8-RC-1.2
		if( get_option( 'myoptionalmodules_admin_toggledisable' ) ) delete_option( 'myoptionalmodules_admin_toggledisable' );
		if( get_option( 'myoptionalmodules_admin_toggleenable' ) ) delete_option( 'myoptionalmodules_admin_toggleenable' );
		if( get_option( 'myoptionalmodules_admin_toggleshare' ) ) delete_option( 'myoptionalmodules_admin_toggleshare' );
		if( get_option( 'myoptionalmodules_admin_togglecomment' ) ) delete_option( 'myoptionalmodules_admin_togglecomment' );
		if( get_option( 'myoptionalmodules_admin_toggleextras' ) ) delete_option( 'myoptionalmodules_admin_toggleextras' );
		if( get_option( 'myoptionalmodules_admin_togglemisc' ) ) delete_option( 'myoptionalmodules_admin_togglemisc' );
		if( get_option( 'myoptionalmodules_admin_toggletrash' ) ) delete_option( 'myoptionalmodules_admin_toggletrash' );
		if( get_option( 'myoptionalmodules_admin_toggleshortcodes' ) ) delete_option( 'myoptionalmodules_admin_toggleshortcodes' );
		if( get_option( 'myoptionalmodules_admin_toggledevelopers' ) ) delete_option( 'myoptionalmodules_admin_toggledevelopers' );
		if( get_option( 'myoptionalmodules_admin_togglecategories' ) ) delete_option( 'myoptionalmodules_admin_togglecategories' );
	
		// 7 to 8
		$myoptionalmodules_frontpage = sanitize_text_field( get_option( 'mompaf_post' ) );
		$myoptionalmodules_nelio = sanitize_text_field( get_option( 'mommaincontrol_externalthumbs' ) );
		$myoptionalmodules_plugincss = sanitize_text_field( get_option( 'mommaincontrol_enablecss' ) );		
		$myoptionalmodules_404s = sanitize_text_field( get_option( 'mommaincontrol_404' ) );
		$myoptionalmodules_rsslinkbacks = sanitize_text_field( get_option( 'mommaincontrol_protectrss' ) );
		$myoptionalmodules_javascripttofooter = sanitize_text_field( get_option( 'mommaincontrol_footerscripts' ) );
		$myoptionalmodules_authorarchives = sanitize_text_field( get_option( 'mommaincontrol_authorarchives' ) );
		$myoptionalmodules_datearchives = sanitize_text_field( get_option( 'mommaincontrol_datearchives' ) );
		$myoptionalmodules_disablecomments = sanitize_text_field( get_option( 'mommaincontrol_comments' ) );
		$myoptionalmodules_removecode = sanitize_text_field( get_option( 'mommaincontrol_wordpress' ) );
		$myoptionalmodules_dnsbl = sanitize_text_field( get_option( 'mommaincontrol_dnsbl' ) );
		$myoptionalmodules_ajaxcomments = sanitize_text_field( get_option( 'MOM_themetakeover_ajaxcomments' ) );
		$myoptionalmodules_commentspamfield = sanitize_text_field( get_option( 'MOM_themetakeover_hidden_field' ) );
		$myoptionalmodules_featureimagewidth = sanitize_text_field( get_option( 'mommaincontrol_thumbnail' ) );
		$myoptionalmodules_recentpostswidget = sanitize_text_field( get_option( 'mommaincontrol_recent_posts' ) );
		$myoptionalmodules_randomdescriptions = sanitize_text_field( get_option( 'mommodule_random_descriptions' ) );
		$myoptionalmodules_randomtitles = sanitize_text_field( get_option( 'mommodule_random_title' ) );
		$myoptionalmodules_horizontalgalleries = sanitize_text_field( get_option( 'MOM_themetakeover_horizontal_galleries' ) );
		$myoptionalmodules_metatags = sanitize_text_field( get_option( 'MOM_themetakeover_meta_tags' ) );
		$myoptionalmodules_exclude = sanitize_text_field( get_option( 'mommaincontrol_momse' ) );
		$myoptionalmodules_sharelinks = sanitize_text_field( get_option( 'mommaincontrol_momshare' ) );
		$myoptionalmodules_fontawesome = sanitize_text_field( get_option( 'mommaincontrol_fontawesome' ) );
		$myoptionalmodules_lazyload = sanitize_text_field( get_option( 'mommaincontrol_lazyload' ) );
		$myoptionalmodules_disablepingbacks = sanitize_text_field( get_option( 'mommaincontrol_disablepingbacks' ) );
		$myoptionalmodules_exclude_visitorpostformats = sanitize_text_field( get_option( 'MOM_Exclude_PostFormats_Visitor' ) );
		$myoptionalmodules_exclude_usersrss = sanitize_text_field( get_option( 'MOM_Exclude_Users_RSS' ) );
		$myoptionalmodules_exclude_usersfront = sanitize_text_field( get_option( 'MOM_Exclude_Users_Front' ) );
		$myoptionalmodules_exclude_userstagarchives = sanitize_text_field( get_option( 'MOM_Exclude_Users_TagArchives' ) );
		$myoptionalmodules_admin_togglecategories = sanitize_text_field( get_option( 'toggle_categories' ) );
		$myoptionalmodules_admin_toggledevelopers = sanitize_text_field( get_option( 'toggle_developers' ) );
		$myoptionalmodules_admin_toggleshortcodes = sanitize_text_field( get_option( 'toggle_shortcodes' ) );
		$myoptionalmodules_admin_togglemisc = sanitize_text_field( get_option( 'toggle_misc' ) );
		$myoptionalmodules_admin_toggleextras = sanitize_text_field( get_option( 'toggle_extras' ) );
		$myoptionalmodules_admin_togglecomment = sanitize_text_field( get_option( 'toggle_comment' ) );
		$myoptionalmodules_admin_toggleshare = sanitize_text_field( get_option( 'toggle_share' ) );
		$myoptionalmodules_admin_toggleenable = sanitize_text_field( get_option( 'toggle_enable' ) );
		$myoptionalmodules_admin_toggledisable = sanitize_text_field( get_option( 'toggle_disable' ) );
		$myoptionalmodules_admin_toggletrash = sanitize_text_field( get_option( 'toggle_trash' ) );
		$myoptionalmodules_randompost = sanitize_text_field( get_option( 'mom_random_get' ) );
		$myoptionalmodules_readmore = sanitize_text_field( get_option( 'mom_readmore_content' ) );
		$myoptionalmodules_google = sanitize_text_field( get_option( 'mom_google_tracking_id' ) );
		$myoptionalmodules_previouslinkclass = sanitize_text_field( get_option( 'mom_previous_link_class' ) );
		$myoptionalmodules_nextlinkclass = sanitize_text_field( get_option( 'mom_next_link_class' ) );
		$myoptionalmodules_sharelinks_email = sanitize_text_field( get_option( 'MOM_enable_share_email' ) );
		$myoptionalmodules_sharelinks_facebook = sanitize_text_field( get_option( 'MOM_enable_share_facebook' ) );
		$myoptionalmodules_sharelinks_twitter = sanitize_text_field( get_option( 'MOM_enable_share_twitter' ) );
		$myoptionalmodules_sharelinks_google = sanitize_text_field( get_option( 'MOM_enable_share_google' ) );
		$myoptionalmodules_sharelinks_reddit = sanitize_text_field( get_option( 'MOM_enable_share_reddit' ) );
		$myoptionalmodules_sharelinks_pages = sanitize_text_field( get_option( 'MOM_enable_share_pages' ) );
		$myoptionalmodules_shareslinks_top = sanitize_text_field( get_option( 'MOM_enable_share_top' ) );
		$myoptionalmodules_exclude_userscategoryarchives = sanitize_text_field( get_option( 'MOM_Exclude_Users_CategoryArchives' ) );
		$myoptionalmodules_exclude_userssearchresults = sanitize_text_field( get_option( 'MOM_Exclude_Users_SearchResults' ) );
		$myoptionalmodules_exclude_usersuserssun = sanitize_text_field( get_option( 'MOM_Exclude_Users_UsersSun' ) );
		$myoptionalmodules_exclude_usersusersmon = sanitize_text_field( get_option( 'MOM_Exclude_Users_UsersMon' ) );
		$myoptionalmodules_exclude_usersuserstue = sanitize_text_field( get_option( 'MOM_Exclude_Users_UsersTue' ) );
		$myoptionalmodules_exclude_usersuserswed = sanitize_text_field( get_option( 'MOM_Exclude_Users_UsersWed' ) );
		$myoptionalmodules_exclude_usersusersthu = sanitize_text_field( get_option( 'MOM_Exclude_Users_UsersThu' ) );
		$myoptionalmodules_exclude_usersusersfri = sanitize_text_field( get_option( 'MOM_Exclude_Users_UsersFri' ) );
		$myoptionalmodules_exclude_usersuserssat = sanitize_text_field( get_option( 'MOM_Exclude_Users_UsersSat' ) );
		$myoptionalmodules_exclude_userslevel10users = sanitize_text_field( get_option( 'MOM_Exclude_Users_level0Users' ) );
		$myoptionalmodules_exclude_userslevel1users = sanitize_text_field( get_option( 'MOM_Exclude_Users_level1Users' ) );
		$myoptionalmodules_exclude_userslevel2users = sanitize_text_field( get_option( 'MOM_Exclude_Users_level2Users' ) );
		$myoptionalmodules_exclude_userslevel7users = sanitize_text_field( get_option( 'MOM_Exclude_Users_level7Users' ) );
		$myoptionalmodules_exclude_postformatsfront = sanitize_text_field( get_option( 'MOM_Exclude_PostFormats_Front' ) );
		$myoptionalmodules_exclude_postformatscategoryarchives = sanitize_text_field( get_option( 'MOM_Exclude_PostFormats_CategoryArchives' ) );
		$myoptionalmodules_exclude_postformatstagarchives = sanitize_text_field( get_option( 'MOM_Exclude_PostFormats_TagArchives' ) );
		$myoptionalmodules_exclude_postformatssearchresults = sanitize_text_field( get_option( 'MOM_Exclude_PostFormats_SearchResults' ) );
		$myoptionalmodules_exclude_categoriesfront = sanitize_text_field( get_option( 'MOM_Exclude_Categories_Front' ) );
		$myoptionalmodules_exclude_categoriestagarchives = sanitize_text_field( get_option( 'MOM_Exclude_Categories_TagArchives' ) );
		$myoptionalmodules_exclude_tagstagssun = sanitize_text_field( get_option( 'MOM_Exclude_Tags_TagsSun' ) );
		$myoptionalmodules_exclude_tagstagsmon = sanitize_text_field( get_option( 'MOM_Exclude_Tags_TagsMon' ) );
		$myoptionalmodules_exclude_tagstagstue = sanitize_text_field( get_option( 'MOM_Exclude_Tags_TagsTue' ) );
		$myoptionalmodules_exclude_tagstagswed = sanitize_text_field( get_option( 'MOM_Exclude_Tags_TagsWed' ) );
		$myoptionalmodules_exclude_tagstagsthu = sanitize_text_field( get_option( 'MOM_Exclude_Tags_TagsThu' ) );
		$myoptionalmodules_exclude_tagstagsfri = sanitize_text_field( get_option( 'MOM_Exclude_Tags_TagsFri' ) );
		$myoptionalmodules_exclude_tagstagssat = sanitize_text_field( get_option( 'MOM_Exclude_Tags_TagsSat' ) );
		$myoptionalmodules_exclude_categoriescategoriessun = sanitize_text_field( get_option( 'MOM_Exclude_Categories_CategoriesSun' ) );
		$myoptionalmodules_exclude_categoriescategoriesmon = sanitize_text_field( get_option( 'MOM_Exclude_Categories_CategoriesMon' ) );
		$myoptionalmodules_exclude_categoriescategoriesthu = sanitize_text_field( get_option( 'MOM_Exclude_Categories_CategoriesThu' ) );
		$myoptionalmodules_exclude_categoriescategoriestue = sanitize_text_field( get_option( 'MOM_Exclude_Categories_CategoriesTue' ) );
		$myoptionalmodules_exclude_categoriescategorieswed = sanitize_text_field( get_option( 'MOM_Exclude_Categories_CategoriesWed' ) );
		$myoptionalmodules_exclude_categoriescategoriesfri = sanitize_text_field( get_option( 'MOM_Exclude_Categories_CategoriesFri' ) );
		$myoptionalmodules_exclude_categoriescategoriessat = sanitize_text_field( get_option( 'MOM_Exclude_Categories_CategoriesSat' ) );
		$myoptionalmodules_exclude_categoriessearchresults = sanitize_text_field( get_option( 'MOM_Exclude_Categories_SearchResults' ) );
		$myoptionalmodules_exclude_categoriesrss = sanitize_text_field( get_option( 'MOM_Exclude_Categories_RSS' ) );
		$myoptionalmodules_exclude_tagsrss = sanitize_text_field( get_option( 'MOM_Exclude_Tags_RSS' ) );
		$myoptionalmodules_exclude_tagsfront = sanitize_text_field( get_option( 'MOM_Exclude_Tags_Front' ) );
		$myoptionalmodules_exclude_tagscategoryarchives = sanitize_text_field( get_option( 'MOM_Exclude_Tags_CategoryArchives' ) );
		$myoptionalmodules_exclude_tagssearchresults = sanitize_text_field( get_option( 'MOM_Exclude_Tags_SearchResults' ) );
		$myoptionalmodules_exclude_postformatsrss = sanitize_text_field( get_option( 'MOM_Exclude_PostFormats_RSS' ) );
		$myoptionalmodules_exclude_tagstags = sanitize_text_field( get_option( 'MOM_Exclude_Tags_Tags' ) );
		$myoptionalmodules_exclude_categoriescategories = sanitize_text_field( get_option( 'MOM_Exclude_Categories_Categories' ) ); delete_option( 'MOM_Exclude_Categories_Categories' ); 
		$myoptionalmodules_exclude_categories_level0categories = sanitize_text_field( get_option( 'MOM_Exclude_Categories_level0Categories' ) );
		$myoptionalmodules_exclude_categorieslevel2categories = sanitize_text_field( get_option( 'MOM_Exclude_Categories_level2Categories' ) );
		$myoptionalmodules_exclude_categorieslevel1categories = sanitize_text_field( get_option( 'MOM_Exclude_Categories_level1Categories' ) );
		$myoptionalmodules_exclude_categorieslevel7categories = sanitize_text_field( get_option( 'MOM_Exclude_Categories_level7Categories' ) );
		$myoptionalmodules_exclude_tagslevel0tags = sanitize_text_field( get_option( 'MOM_Exclude_Tags_level0Tags' ) );
		$myoptionalmodules_exclude_tagslevel1tags = sanitize_text_field( get_option( 'MOM_Exclude_Tags_level1Tags' ) );
		$myoptionalmodules_exclude_tagslevel2tags = sanitize_text_field( get_option( 'MOM_Exclude_Tags_level2Tags' ) );
		$myoptionalmodules_exclude_tagslevel7tags = sanitize_text_field( get_option( 'MOM_Exclude_Tags_level7Tags' ) );

		if( $myoptionalmodules_frontpage ) update_option( 'myoptionalmodules_frontpage', $myoptionalmodules_frontpage ); delete_option( 'mompaf_post' ); 
		if( $myoptionalmodules_nelio ) update_option( 'myoptionalmodules_nelio', $myoptionalmodules_nelio ); delete_option( 'mommaincontrol_externalthumbs' ); 
		if( $myoptionalmodules_plugincss ) update_option( 'myoptionalmodules_plugincss', $myoptionalmodules_plugincss ); delete_option( 'mommaincontrol_enablecss' ); 
		if( $myoptionalmodules_404s ) update_option( 'myoptionalmodules_404s', $myoptionalmodules_404s ); delete_option( 'mommaincontrol_404' ); 
		if( $myoptionalmodules_rsslinkbacks ) update_option( 'myoptionalmodules_rsslinkbacks', $myoptionalmodules_rsslinkbacks ); delete_option( 'mommaincontrol_protectrss' ); 
		if( $myoptionalmodules_javascripttofooter ) update_option( 'myoptionalmodules_javascripttofooter', $myoptionalmodules_javascripttofooter ); delete_option( 'mommaincontrol_footerscripts' ); 
		if( $myoptionalmodules_authorarchives ) update_option( 'myoptionalmodules_authorarchives', $myoptionalmodules_authorarchives ); delete_option( 'mommaincontrol_authorarchives' ); 
		if( $myoptionalmodules_datearchives ) update_option( 'myoptionalmodules_datearchives', $myoptionalmodules_datearchives ); delete_option( 'mommaincontrol_datearchives' ); 
		if( $myoptionalmodules_disablecomments ) update_option( 'myoptionalmodules_disablecomments', $myoptionalmodules_disablecomments ); delete_option( 'mommaincontrol_comments' ); 
		if( $myoptionalmodules_removecode ) update_option( 'myoptionalmodules_removecode', $myoptionalmodules_removecode ); delete_option( 'mommaincontrol_wordpress' ); 
		if( $myoptionalmodules_dnsbl ) update_option( 'myoptionalmodules_dnsbl', $myoptionalmodules_dnsbl ); delete_option( 'mommaincontrol_dnsbl' ); 
		if( $myoptionalmodules_ajaxcomments ) update_option( 'myoptionalmodules_ajaxcomments', $myoptionalmodules_ajaxcomments ); delete_option( 'MOM_themetakeover_ajaxcomments' ); 
		if( $myoptionalmodules_commentspamfield ) update_option( 'myoptionalmodules_commentspamfield', $myoptionalmodules_commentspamfield ); delete_option( 'MOM_themetakeover_hidden_field' ); 
		if( $myoptionalmodules_featureimagewidth ) update_option( 'myoptionalmodules_featureimagewidth', $myoptionalmodules_featureimagewidth ); delete_option( 'mommaincontrol_thumbnail' ); 
		if( $myoptionalmodules_recentpostswidget ) update_option( 'myoptionalmodules_recentpostswidget', $myoptionalmodules_recentpostswidget ); delete_option( 'mommaincontrol_recent_posts' ); 
		if( $myoptionalmodules_randomdescriptions ) update_option( 'myoptionalmodules_randomdescriptions', $myoptionalmodules_randomdescriptions ); delete_option( 'mommodule_random_description' ); delete_option( 'mommodule_random_descriptions' );
		if( $myoptionalmodules_randomtitles ) update_option( 'myoptionalmodules_randomtitles', $myoptionalmodules_randomtitles ); delete_option( 'mommodule_random_title' ); 
		if( $myoptionalmodules_horizontalgalleries ) update_option( 'myoptionalmodules_horizontalgalleries', $myoptionalmodules_horizontalgalleries ); delete_option( 'MOM_themetakeover_horizontal_galleries' ); 
		if( $myoptionalmodules_metatags ) update_option( 'myoptionalmodules_metatags', $myoptionalmodules_metatags ); delete_option( 'MOM_themetakeover_meta_tags' ); 
		if( $myoptionalmodules_exclude ) update_option( 'myoptionalmodules_exclude', $myoptionalmodules_exclude ); delete_option( 'mommaincontrol_momse' ); 
		if( $myoptionalmodules_sharelinks ) update_option( 'myoptionalmodules_sharelinks', $myoptionalmodules_sharelinks ); 
		if( $myoptionalmodules_fontawesome ) update_option( 'myoptionalmodules_fontawesome', $myoptionalmodules_fontawesome ); delete_option( 'mommaincontrol_fontawesome' ); 
		if( $myoptionalmodules_lazyload ) update_option( 'myoptionalmodules_lazyload', $myoptionalmodules_lazyload ); delete_option( 'mommaincontrol_lazyload' ); 
		if( $myoptionalmodules_disablepingbacks ) update_option( 'myoptionalmodules_disablepingbacks', $myoptionalmodules_disablepingbacks ); delete_option( 'mommaincontrol_disablepingbacks' ); 
		if( $myoptionalmodules_exclude_visitorpostformats ) update_option( 'myoptionalmodules_exclude_visitorpostformats', $myoptionalmodules_exclude_visitorpostformats ); delete_option( 'MOM_Exclude_PostFormats_Visitor' ); 
		if( $myoptionalmodules_exclude_usersrss ) update_option( 'myoptionalmodules_exclude_usersrss', $myoptionalmodules_exclude_usersrss ); delete_option( 'MOM_Exclude_Users_RSS' ); 
		if( $myoptionalmodules_exclude_usersfront ) update_option( 'myoptionalmodules_exclude_usersfront', $myoptionalmodules_exclude_usersfront ); delete_option( 'MOM_Exclude_Users_Front' ); 
		if( $myoptionalmodules_exclude_userstagarchives ) update_option( 'myoptionalmodules_exclude_userstagarchives', $myoptionalmodules_exclude_userstagarchives ); delete_option( 'MOM_Exclude_Users_TagArchives' ); 
		if( $myoptionalmodules_randompost ) update_option( 'myoptionalmodules_randompost', $myoptionalmodules_randompost ); delete_option( 'mom_random_get' ); 
		if( $myoptionalmodules_readmore ) update_option( 'myoptionalmodules_readmore', $myoptionalmodules_readmore ); delete_option( 'mom_readmore_content' ); 
		if( $myoptionalmodules_google ) update_option( 'myoptionalmodules_google', $myoptionalmodules_google ); delete_option( 'mom_google_tracking_id' ); 
		if( $myoptionalmodules_previouslinkclass ) update_option( 'myoptionalmodules_previouslinkclass', $myoptionalmodules_previouslinkclass ); delete_option( 'mom_previous_link_class' ); 
		if( $myoptionalmodules_nextlinkclass ) update_option( 'myoptionalmodules_nextlinkclass', $myoptionalmodules_nextlinkclass ); delete_option( 'mom_next_link_class' ); 
		if( $myoptionalmodules_exclude_postformatsfront ) update_option( 'myoptionalmodules_exclude_postformatsfront', $myoptionalmodules_exclude_postformatsfront ); delete_option( 'MOM_Exclude_PostFormats_Front' ); 
		if( $myoptionalmodules_exclude_postformatscategoryarchives ) update_option( 'myoptionalmodules_exclude_postformatscategoryarchives', $myoptionalmodules_exclude_postformatscategoryarchives ); delete_option( 'MOM_Exclude_PostFormats_CategoryArchives' ); 
		if( $myoptionalmodules_exclude_postformatstagarchives ) update_option( 'myoptionalmodules_exclude_postformatstagarchives', $myoptionalmodules_exclude_postformatstagarchives ); delete_option( 'MOM_Exclude_PostFormats_TagArchives' ); 
		if( $myoptionalmodules_exclude_postformatssearchresults ) update_option( 'myoptionalmodules_exclude_postformatssearchresults', $myoptionalmodules_exclude_postformatssearchresults ); delete_option( 'MOM_Exclude_PostFormats_SearchResults' ); 
		if( $myoptionalmodules_exclude_categoriesfront ) update_option( 'myoptionalmodules_exclude_categoriesfront', $myoptionalmodules_exclude_categoriesfront ); delete_option( 'MOM_Exclude_Categories_Front' ); 
		if( $myoptionalmodules_exclude_categoriestagarchives ) update_option( 'myoptionalmodules_exclude_categoriestagarchives', $myoptionalmodules_exclude_categoriestagarchives ); delete_option( 'MOM_Exclude_Categories_TagArchives' ); 
		if( $myoptionalmodules_exclude_categoriesrss ) update_option( 'myoptionalmodules_exclude_categoriesrss', $myoptionalmodules_exclude_categoriesrss ); delete_option( 'MOM_Exclude_Categories_RSS' ); 
		if( $myoptionalmodules_exclude_tagsrss ) update_option( 'myoptionalmodules_exclude_tagsrss', $myoptionalmodules_exclude_tagsrss ); delete_option( 'MOM_Exclude_Tags_RSS' ); 
		if( $myoptionalmodules_exclude_tagsfront ) update_option( 'myoptionalmodules_exclude_tagsfront', $myoptionalmodules_exclude_tagsfront ); delete_option( 'MOM_Exclude_Tags_Front' ); 
		if( $myoptionalmodules_exclude_tagscategoryarchives ) update_option( 'myoptionalmodules_exclude_tagscategoryarchives', $myoptionalmodules_exclude_tagscategoryarchives ); delete_option( 'MOM_Exclude_Tags_CategoryArchives' ); 
		if( $myoptionalmodules_exclude_tagssearchresults ) update_option( 'myoptionalmodules_exclude_tagssearchresults', $myoptionalmodules_exclude_tagssearchresults ); delete_option( 'MOM_Exclude_Tags_SearchResults' ); 
		if( $myoptionalmodules_exclude_postformatsrss ) update_option( 'myoptionalmodules_exclude_postformatsrss', $myoptionalmodules_exclude_postformatsrss ); delete_option( 'MOM_Exclude_PostFormats_RSS' ); 
		if( $myoptionalmodules_exclude_tagstags ) update_option( 'myoptionalmodules_exclude_tagstags', $myoptionalmodules_exclude_tagstags ); delete_option( 'MOM_Exclude_Tags_Tags' ); 
		if( $myoptionalmodules_exclude_categoriescategories ) update_option( 'myoptionalmodules_exclude_categoriescategories', $myoptionalmodules_exclude_categoriescategories );
		if( $myoptionalmodules_sharelinks_email ) update_option( 'myoptionalmodules_sharelinks_email', $myoptionalmodules_sharelinks_email ); delete_option( 'MOM_enable_share_email' ); 
		if( $myoptionalmodules_sharelinks_facebook ) update_option( 'myoptionalmodules_sharelinks_facebook', $myoptionalmodules_sharelinks_facebook ); delete_option( 'MOM_enable_share_facebook' ); 
		if( $myoptionalmodules_sharelinks_twitter ) update_option( 'myoptionalmodules_sharelinks_twitter', $myoptionalmodules_sharelinks_twitter ); delete_option( 'MOM_enable_share_twitter' ); 
		if( $myoptionalmodules_sharelinks_google ) update_option( 'myoptionalmodules_sharelinks_google', $myoptionalmodules_sharelinks_google ); delete_option( 'MOM_enable_share_google' ); 
		if( $myoptionalmodules_sharelinks_reddit ) update_option( 'myoptionalmodules_sharelinks_reddit', $myoptionalmodules_sharelinks_reddit ); delete_option( 'MOM_enable_share_reddit' ); 
		if( $myoptionalmodules_sharelinks_pages ) update_option( 'myoptionalmodules_sharelinks_pages', $myoptionalmodules_sharelinks_pages ); delete_option( 'MOM_enable_share_pages' ); delete_option( 'mommaincontrol_momshare' ); 
		if( $myoptionalmodules_shareslinks_top ) update_option( 'myoptionalmodules_shareslinks_top', $myoptionalmodules_shareslinks_top ); delete_option( 'MOM_enable_share_top' );
		if( $myoptionalmodules_exclude_tagstagssun ) update_option( 'myoptionalmodules_exclude_tagstagssun', $myoptionalmodules_exclude_tagstagssun ); delete_option( 'MOM_Exclude_Tags_TagsSun ' ); 
		if( $myoptionalmodules_exclude_tagstagsmon ) update_option( 'myoptionalmodules_exclude_tagstagsmon', $myoptionalmodules_exclude_tagstagsmon ); delete_option( 'MOM_Exclude_Tags_TagsMon' ); 
		if( $myoptionalmodules_exclude_tagstagstue ) update_option( 'myoptionalmodules_exclude_tagstagstue', $myoptionalmodules_exclude_tagstagstue ); delete_option( 'MOM_Exclude_Tags_TagsTue' ); 
		if( $myoptionalmodules_exclude_tagstagswed ) update_option( 'myoptionalmodules_exclude_tagstagswed', $myoptionalmodules_exclude_tagstagswed ); delete_option( 'MOM_Exclude_Tags_TagsWed' ); 
		if( $myoptionalmodules_exclude_tagstagsthu ) update_option( 'myoptionalmodules_exclude_tagstagsthu', $myoptionalmodules_exclude_tagstagsthu ); delete_option( 'MOM_Exclude_Tags_TagsThu' ); 
		if( $myoptionalmodules_exclude_tagstagsfri ) update_option( 'myoptionalmodules_exclude_tagstagsfri', $myoptionalmodules_exclude_tagstagsfri ); delete_option( 'MOM_Exclude_Tags_TagsFri' ); 
		if( $myoptionalmodules_exclude_tagstagssat ) update_option( 'myoptionalmodules_exclude_tagstagssat', $myoptionalmodules_exclude_tagstagssat ); delete_option( 'MOM_Exclude_Tags_TagsSat' ); 
		if( $myoptionalmodules_exclude_userscategoryarchives ) update_option( 'myoptionalmodules_exclude_userscategoryarchives', $myoptionalmodules_exclude_userscategoryarchives ); delete_option( 'MOM_Exclude_Users_CategoryArchives' ); 
		if( $myoptionalmodules_exclude_userssearchresults ) update_option( 'myoptionalmodules_exclude_userssearchresults', $myoptionalmodules_exclude_userssearchresults ); delete_option( 'MOM_Exclude_Users_SearchResults' ); 
		if( $myoptionalmodules_exclude_userslevel10users ) update_option( 'myoptionalmodules_exclude_userslevel10users', $myoptionalmodules_exclude_userslevel10users ); delete_option( 'MOM_Exclude_Users_level0Users' ); 
		if( $myoptionalmodules_exclude_userslevel1users ) update_option( 'myoptionalmodules_exclude_userslevel1users', $myoptionalmodules_exclude_userslevel1users ); delete_option( 'MOM_Exclude_Users_level1Users' ); 
		if( $myoptionalmodules_exclude_userslevel2users ) update_option( 'myoptionalmodules_exclude_userslevel2users', $myoptionalmodules_exclude_userslevel2users ); delete_option( 'MOM_Exclude_Users_level2Users' ); 
		if( $myoptionalmodules_exclude_userslevel7users ) update_option( 'myoptionalmodules_exclude_userslevel7users', $myoptionalmodules_exclude_userslevel7users ); delete_option( 'MOM_Exclude_Users_level7Users' ); 
		if( $myoptionalmodules_exclude_categoriescategoriessun ) update_option( 'myoptionalmodules_exclude_categoriescategoriessun', $myoptionalmodules_exclude_categoriescategoriessun ); delete_option( 'MOM_Exclude_Categories_CategoriesSun' ); 
		if( $myoptionalmodules_exclude_categoriescategoriesmon ) update_option( 'myoptionalmodules_exclude_categoriescategoriesmon', $myoptionalmodules_exclude_categoriescategoriesmon ); delete_option( 'MOM_Exclude_Categories_CategoriesMon' ); 
		if( $myoptionalmodules_exclude_categoriescategoriestue ) update_option( 'myoptionalmodules_exclude_categoriescategoriestue', $myoptionalmodules_exclude_categoriescategoriestue ); delete_option( 'MOM_Exclude_Categories_CategoriesTue' ); 
		if( $myoptionalmodules_exclude_categoriescategorieswed ) update_option( 'myoptionalmodules_exclude_categoriescategorieswed', $myoptionalmodules_exclude_categoriescategorieswed ); delete_option( 'MOM_Exclude_Categories_CategoriesWed' ); 
		if( $myoptionalmodules_exclude_categoriescategoriesthu ) update_option( 'myoptionalmodules_exclude_categoriescategoriesthu', $myoptionalmodules_exclude_categoriescategoriesthu ); delete_option( 'MOM_Exclude_Categories_CategoriesThu' ); 
		if( $myoptionalmodules_exclude_categoriescategoriesfri ) update_option( 'myoptionalmodules_exclude_categoriescategoriesfri', $myoptionalmodules_exclude_categoriescategoriesfri ); delete_option( 'MOM_Exclude_Categories_CategoriesFri' ); 
		if( $myoptionalmodules_exclude_categoriescategoriessat ) update_option( 'myoptionalmodules_exclude_categoriescategoriessat', $myoptionalmodules_exclude_categoriescategoriessat ); delete_option( 'MOM_Exclude_Categories_CategoriesSat' ); 
		if( $myoptionalmodules_exclude_categoriessearchresults ) update_option( 'myoptionalmodules_exclude_categoriessearchresults', $myoptionalmodules_exclude_categoriessearchresults ); delete_option( 'MOM_Exclude_Categories_SearchResults' );		
		if( $myoptionalmodules_exclude_usersuserssun ) update_option( 'myoptionalmodules_exclude_usersuserssun', $myoptionalmodules_exclude_usersuserssun ); delete_option( 'MOM_Exclude_Users_UsersSun' ); 
		if( $myoptionalmodules_exclude_usersusersmon ) update_option( 'myoptionalmodules_exclude_usersusersmon', $myoptionalmodules_exclude_usersusersmon ); delete_option( 'MOM_Exclude_Users_UsersMon' ); 
		if( $myoptionalmodules_exclude_usersuserstue ) update_option( 'myoptionalmodules_exclude_usersuserstue', $myoptionalmodules_exclude_usersuserstue ); delete_option( 'MOM_Exclude_Users_UsersTue' ); 
		if( $myoptionalmodules_exclude_usersuserswed ) update_option( 'myoptionalmodules_exclude_usersuserswed', $myoptionalmodules_exclude_usersuserswed ); delete_option( 'MOM_Exclude_Users_UsersWed' ); 
		if( $myoptionalmodules_exclude_usersusersthu ) update_option( 'myoptionalmodules_exclude_usersusersthu', $myoptionalmodules_exclude_usersusersthu ); delete_option( 'MOM_Exclude_Users_UsersThu' ); 
		if( $myoptionalmodules_exclude_usersusersfri ) update_option( 'myoptionalmodules_exclude_usersusersfri', $myoptionalmodules_exclude_usersusersfri ); delete_option( 'MOM_Exclude_Users_UsersFri' ); 
		if( $myoptionalmodules_exclude_usersuserssat ) update_option( 'myoptionalmodules_exclude_usersuserssat', $myoptionalmodules_exclude_usersuserssat ); delete_option( 'MOM_Exclude_Users_UsersSat' ); 		
		if( $myoptionalmodules_admin_togglecategories ) update_option( 'myoptionalmodules_admin_togglecategories', $myoptionalmodules_admin_togglecategories ); delete_option( 'toggle_categories' ); 
		if( $myoptionalmodules_admin_toggledevelopers ) update_option( 'myoptionalmodules_admin_toggledevelopers', $myoptionalmodules_admin_toggledevelopers ); delete_option( 'toggle_developers' ); 
		if( $myoptionalmodules_admin_toggleshortcodes ) update_option( 'myoptionalmodules_admin_toggleshortcodes', $myoptionalmodules_admin_toggleshortcodes ); delete_option( 'toggle_shortcodes' ); 
		if( $myoptionalmodules_admin_togglemisc ) update_option( 'myoptionalmodules_admin_togglemisc', $myoptionalmodules_admin_togglemisc ); delete_option( 'toggle_misc' ); 
		if( $myoptionalmodules_admin_toggleextras ) update_option( 'myoptionalmodules_admin_toggleextras', $myoptionalmodules_admin_toggleextras ); delete_option( 'toggle_extras' ); 
		if( $myoptionalmodules_admin_togglecomment ) update_option( 'myoptionalmodules_admin_togglecomment', $myoptionalmodules_admin_togglecomment ); delete_option( 'toggle_comment' ); 
		if( $myoptionalmodules_admin_toggleshare ) update_option( 'myoptionalmodules_admin_toggleshare', $myoptionalmodules_admin_toggleshare ); delete_option( 'toggle_share' ); 
		if( $myoptionalmodules_admin_toggleenable ) update_option( 'myoptionalmodules_admin_toggleenable', $myoptionalmodules_admin_toggleenable ); delete_option( 'toggle_enable' ); 
		if( $myoptionalmodules_admin_toggledisable ) update_option( 'myoptionalmodules_admin_toggledisable', $myoptionalmodules_admin_toggledisable ); delete_option( 'toggle_disable' ); 
		if( $myoptionalmodules_admin_toggletrash ) update_option( 'myoptionalmodules_admin_toggletrash', $myoptionalmodules_admin_toggletrash ); delete_option( 'toggle_trash' );
		if( $myoptionalmodules_exclude_categories_level0categories ) update_option( 'myoptionalmodules_exclude_categories_level0categories', $myoptionalmodules_exclude_categories_level0categories ); delete_option( 'MOM_Exclude_Categories_level0Categories' ); 
		if( $myoptionalmodules_exclude_categorieslevel1categories ) update_option( 'myoptionalmodules_exclude_categorieslevel1categories', $myoptionalmodules_exclude_categorieslevel1categories ); delete_option( 'MOM_Exclude_Categories_level1Categories' ); 
		if( $myoptionalmodules_exclude_categorieslevel2categories ) update_option( 'myoptionalmodules_exclude_categorieslevel2categories', $myoptionalmodules_exclude_categorieslevel2categories ); delete_option( 'MOM_Exclude_Categories_level2Categories' ); 
		if( $myoptionalmodules_exclude_categorieslevel7categories ) update_option( 'myoptionalmodules_exclude_categorieslevel7categories', $myoptionalmodules_exclude_categorieslevel7categories ); delete_option( 'MOM_Exclude_Categories_level7Categories' ); 
		if( $myoptionalmodules_exclude_tagslevel0tags ) update_option( 'myoptionalmodules_exclude_tagslevel0tags', $myoptionalmodules_exclude_tagslevel0tags ); delete_option( 'MOM_Exclude_Tags_level0Tags' ); 
		if( $myoptionalmodules_exclude_tagslevel1tags ) update_option( 'myoptionalmodules_exclude_tagslevel1tags', $myoptionalmodules_exclude_tagslevel1tags ); delete_option( 'MOM_Exclude_Tags_level1Tags' ); 
		if( $myoptionalmodules_exclude_tagslevel2tags ) update_option( 'myoptionalmodules_exclude_tagslevel2tags', $myoptionalmodules_exclude_tagslevel2tags ); delete_option( 'MOM_Exclude_Tags_level2Tags' ); 
		if( $myoptionalmodules_exclude_tagslevel7tags ) update_option( 'myoptionalmodules_exclude_tagslevel7tags', $myoptionalmodules_exclude_tagslevel7tags ); delete_option( 'MOM_Exclude_Tags_level7Tags' ); 
		delete_option( 'MOM_Exclude_Tags_Single' ); 
		delete_option( 'mom_save_form_submit' ); 
		delete_option( 'mommaincontrol_versionnumbers' ); 
		delete_option( 'mom_external_thumbs' ); 
		delete_option( 'MOM_Exclude_Categories_Single' ); 
		delete_option( 'MOM_Exclude_PostFormats_Single' ); 
		delete_option( 'momsesave' ); 
		delete_option( 'MOM_Exclude_Users_Single' ); 		
		delete_option( 'MOM_force_single' ); 
		delete_option( 'mom_disablepingbacks_submit' ); 
		delete_option( 'mom_comments_mode_submit' ); 
		
		// Update version
		update_option( 'myoptionalmodules_upgrade_version', $myoptionalmodules_upgrade_version  );
}