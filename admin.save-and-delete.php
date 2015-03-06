<?php 

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}

if( isset( $_POST[ 'MOM_UPGRADE' ] ) && check_admin_referer( 'MOM_UPGRADE' ) ) {
	include( 'admin.upgrade.php' );	
}elseif( isset( $_POST[ 'MOM_UNINSTALL_EVERYTHING' ] ) && check_admin_referer( 'MOM_UNINSTALL_EVERYTHING' ) ) {
	$option = array( 
		'myoptionalmodules_upgrade_version',
		'myoptionalmodules_nelio',
		'myoptionalmodules_plugincss',
		'myoptionalmodules_404s',
		'myoptionalmodules_rsslinkbacks',
		'myoptionalmodules_javascripttofooter',
		'myoptionalmodules_authorarchives',
		'myoptionalmodules_datearchives',
		'myoptionalmodules_disablecomments',
		'myoptionalmodules_removecode',
		'myoptionalmodules_dnsbl',
		'myoptionalmodules_ajaxcomments',
		'myoptionalmodules_commentspamfield',
		'myoptionalmodules_featureimagewidth',
		'myoptionalmodules_recentpostswidget',
		'myoptionalmodules_randomdescriptions',
		'myoptionalmodules_randomtitles',
		'myoptionalmodules_horizontalgalleries',
		'myoptionalmodules_metatags',
		'myoptionalmodules_exclude',
		'myoptionalmodules_sharelinks',
		'myoptionalmodules_fontawesome',
		'myoptionalmodules_lazyload',
		'myoptionalmodules_disablepingbacks',
		'myoptionalmodules_frontpage',
		'myoptionalmodules_exclude_visitorpostformats',
		'myoptionalmodules_exclude_usersrss',
		'myoptionalmodules_exclude_usersfront',
		'myoptionalmodules_exclude_userstagarchives',
		'myoptionalmodules_exclude_userscategoryarchives',
		'myoptionalmodules_exclude_userssearchresults',
		'myoptionalmodules_exclude_usersuserssun',
		'myoptionalmodules_exclude_usersusersmon',
		'myoptionalmodules_exclude_usersuserstue',
		'myoptionalmodules_exclude_usersuserswed',
		'myoptionalmodules_exclude_usersusersthu',
		'myoptionalmodules_exclude_usersusersfri',
		'myoptionalmodules_exclude_usersuserssat',
		'myoptionalmodules_exclude_userslevel10users',
		'myoptionalmodules_exclude_userslevel1users',
		'myoptionalmodules_exclude_userslevel2users',
		'myoptionalmodules_exclude_userslevel7users',
		'myoptionalmodules_exclude_postformatsfront',
		'myoptionalmodules_exclude_postformatscategoryarchives',
		'myoptionalmodules_exclude_postformatstagarchives',
		'myoptionalmodules_exclude_postformatssearchresults',
		'myoptionalmodules_exclude_categoriesfront',
		'myoptionalmodules_exclude_categoriestagarchives',
		'myoptionalmodules_exclude_tagstagssun',
		'myoptionalmodules_exclude_tagstagsmon',
		'myoptionalmodules_exclude_tagstagstue',
		'myoptionalmodules_exclude_tagstagswed',
		'myoptionalmodules_exclude_tagstagsthu',
		'myoptionalmodules_exclude_tagstagsfri',
		'myoptionalmodules_exclude_tagstagssat',
		'myoptionalmodules_exclude_categoriescategoriessun',
		'myoptionalmodules_exclude_categoriescategoriesmon',
		'myoptionalmodules_exclude_categoriescategoriestue',
		'myoptionalmodules_exclude_categoriescategorieswed',
		'myoptionalmodules_exclude_categoriescategoriesthu',
		'myoptionalmodules_exclude_categoriescategoriesfri',
		'myoptionalmodules_exclude_categoriescategoriessat',
		'myoptionalmodules_exclude_categoriessearchresults',
		'myoptionalmodules_exclude_categoriesrss',
		'myoptionalmodules_exclude_tagsrss',
		'myoptionalmodules_exclude_tagsfront',
		'myoptionalmodules_exclude_tagscategoryarchives',
		'myoptionalmodules_exclude_tagssearchresults',
		'myoptionalmodules_exclude_postformatsfront',
		'myoptionalmodules_exclude_tagstags',
		'myoptionalmodules_exclude_categoriescategories',
		'myoptionalmodules_exclude_categories_level0categories',
		'myoptionalmodules_exclude_categorieslevel1categories',
		'myoptionalmodules_exclude_categorieslevel2categories',
		'myoptionalmodules_exclude_categorieslevel7categories',
		'myoptionalmodules_exclude_tagslevel0tags',
		'myoptionalmodules_exclude_tagslevel1tags',
		'myoptionalmodules_exclude_tagslevel2tags',
		'myoptionalmodules_exclude_tagslevel7tags',
		'myoptionalmodules_shareslinks_top',
		'myoptionalmodules_sharelinks_pages',
		'myoptionalmodules_sharelinks_reddit',
		'myoptionalmodules_sharelinks_google',
		'myoptionalmodules_sharelinks_twitter',
		'myoptionalmodules_sharelinks_facebook',
		'myoptionalmodules_sharelinks_email',
		'myoptionalmodules_nextlinkclass',
		'myoptionalmodules_previouslinkclass',
		'myoptionalmodules_google',
		'myoptionalmodules_readmore',
		'myoptionalmodules_randompost',
		'myoptionalmodules_admin_toggletrash',
		'myoptionalmodules_admin_toggledisable',
		'myoptionalmodules_admin_toggleenable',
		'myoptionalmodules_admin_toggleshare',
		'myoptionalmodules_admin_togglecomment',
		'myoptionalmodules_admin_toggleextras',
		'myoptionalmodules_admin_togglemisc',
		'myoptionalmodules_admin_toggleshortcodes',
		'myoptionalmodules_admin_toggledevelopers',
		'myoptionalmodules_admin_togglecategories',
		'myoptionalmodules_exclude_postformatsrss'
	);
	foreach( $option as &$value ) {
		delete_option( $value );
	}
} else {
	
	if( isset( $_POST[ 'myoptionalmodules_featureimagewidth_submit' ] ) && check_admin_referer( 'myoptionalmodules_featureimagewidth_submit' ) )
		update_option( 'myoptionalmodules_featureimagewidth', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_featureimagewidth' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_recentpostswidget_submit' ] ) && check_admin_referer( 'myoptionalmodules_recentpostswidget_submit' ) )
		update_option( 'myoptionalmodules_recentpostswidget', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_recentpostswidget' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_rsslinkbacks_submit' ] ) && check_admin_referer( 'myoptionalmodules_rsslinkbacks_submit' ) )
		update_option( 'myoptionalmodules_rsslinkbacks', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_rsslinkbacks' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_404s_submit' ] ) && check_admin_referer( 'myoptionalmodules_404s_submit' ) )
		update_option( 'myoptionalmodules_404s', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_404s' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_javascripttofooter_submit' ] ) && check_admin_referer( 'myoptionalmodules_javascripttofooter_submit' ) )
		update_option( 'myoptionalmodules_javascripttofooter', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_javascripttofooter' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_authorarchives_submit' ] ) && check_admin_referer( 'myoptionalmodules_authorarchives_submit' ) )
		update_option( 'myoptionalmodules_authorarchives', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_authorarchives' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_datearchives_submit' ] ) && check_admin_referer( 'myoptionalmodules_datearchives_submit' ) )
		update_option( 'myoptionalmodules_datearchives', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_datearchives' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_plugincss_submit' ] ) && check_admin_referer( 'myoptionalmodules_plugincss_submit' ) )
		update_option( 'myoptionalmodules_plugincss', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_plugincss' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_disablecomments_submit' ] ) && check_admin_referer( 'myoptionalmodules_disablecomments_submit' ) )
		update_option( 'myoptionalmodules_disablecomments', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_disablecomments' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_removecode_submit' ] ) && check_admin_referer( 'myoptionalmodules_removecode_submit' ) )
		update_option( 'myoptionalmodules_removecode', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_removecode' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_dnsbl_submit' ] ) && check_admin_referer( 'myoptionalmodules_dnsbl_submit' ) )
		update_option( 'myoptionalmodules_dnsbl', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_dnsbl' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_ajaxcomments_submit' ] ) && check_admin_referer( 'myoptionalmodules_ajaxcomments_submit' ) )
		update_option( 'myoptionalmodules_ajaxcomments', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_ajaxcomments' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_commentspamfield_submit' ] ) && check_admin_referer( 'myoptionalmodules_commentspamfield_submit' ) )
		update_option( 'myoptionalmodules_commentspamfield', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_commentspamfield' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_exclude_submit' ] ) && check_admin_referer( 'myoptionalmodules_exclude_submit' ) )
		update_option( 'myoptionalmodules_exclude', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_exclude' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_sharelinks_submit' ] ) && check_admin_referer( 'myoptionalmodules_sharelinks_submit' ) )
		update_option( 'myoptionalmodules_sharelinks', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_sharelinks' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_shareslinks_top_submit' ] ) && check_admin_referer( 'myoptionalmodules_shareslinks_top_submit' ) )
		update_option( 'myoptionalmodules_shareslinks_top', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_shareslinks_top' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_sharelinks_pages_submit' ] ) && check_admin_referer( 'myoptionalmodules_sharelinks_pages_submit' ) )
		update_option( 'myoptionalmodules_sharelinks_pages', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_sharelinks_pages' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_sharelinks_reddit_submit' ] ) && check_admin_referer( 'myoptionalmodules_sharelinks_reddit_submit' ) )
		update_option( 'myoptionalmodules_sharelinks_reddit', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_sharelinks_reddit' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_sharelinks_twitter_submit' ] ) && check_admin_referer( 'myoptionalmodules_sharelinks_twitter_submit' ) )
		update_option( 'myoptionalmodules_sharelinks_twitter', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_sharelinks_twitter' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_sharelinks_email_submit' ] ) && check_admin_referer( 'myoptionalmodules_sharelinks_email_submit' ) )
		update_option( 'myoptionalmodules_sharelinks_email', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_sharelinks_email' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_sharelinks_google_submit' ] ) && check_admin_referer( 'myoptionalmodules_sharelinks_google_submit' ) )
		update_option( 'myoptionalmodules_sharelinks_google', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_sharelinks_google' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_sharelinks_facebook_submit' ] ) && check_admin_referer( 'myoptionalmodules_sharelinks_facebook_submit' ) )
		update_option( 'myoptionalmodules_sharelinks_facebook', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_sharelinks_facebook' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_metatags_submit' ] ) && check_admin_referer( 'myoptionalmodules_metatags_submit' ) )
		update_option( 'myoptionalmodules_metatags', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_metatags' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_horizontalgalleries_submit' ] ) && check_admin_referer( 'myoptionalmodules_horizontalgalleries_submit' ) )
		update_option( 'myoptionalmodules_horizontalgalleries', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_horizontalgalleries' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_fontawesome_submit' ] ) && check_admin_referer( 'myoptionalmodules_fontawesome_submit' ) )
		update_option( 'myoptionalmodules_fontawesome', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_fontawesome' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_lazyload_submit' ] ) && check_admin_referer( 'myoptionalmodules_lazyload_submit' ) )
		update_option( 'myoptionalmodules_lazyload', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_lazyload' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_disablepingbacks_submit' ] ) && check_admin_referer( 'myoptionalmodules_disablepingbacks_submit' ) )
		update_option( 'myoptionalmodules_disablepingbacks', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_disablepingbacks' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_toggletrash_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_toggletrash_submit' ) )
		update_option( 'myoptionalmodules_admin_toggletrash', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_toggletrash' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_toggledisable_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_toggledisable_submit' ) )
		update_option( 'myoptionalmodules_admin_toggledisable', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_toggledisable' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_toggleenable_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_toggleenable_submit' ) )
		update_option( 'myoptionalmodules_admin_toggleenable', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_toggleenable' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_toggleshare_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_toggleshare_submit' ) )
		update_option( 'myoptionalmodules_admin_toggleshare', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_toggleshare' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_togglecomment_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_togglecomment_submit' ) )
		update_option( 'myoptionalmodules_admin_togglecomment', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_togglecomment' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_toggleextras_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_toggleextras_submit' ) )
		update_option( 'myoptionalmodules_admin_toggleextras', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_toggleextras' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_togglemisc_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_togglemisc_submit' ) )
		update_option( 'myoptionalmodules_admin_togglemisc', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_togglemisc' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_toggleshortcodes_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_toggleshortcodes_submit' ) )
		update_option( 'myoptionalmodules_admin_toggleshortcodes', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_toggleshortcodes' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_toggledevelopers_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_toggledevelopers_submit' ) )
		update_option( 'myoptionalmodules_admin_toggledevelopers', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_toggledevelopers' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_admin_togglecategories_submit' ] ) && check_admin_referer( 'myoptionalmodules_admin_togglecategories_submit' ) )
		update_option( 'myoptionalmodules_admin_togglecategories', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_admin_togglecategories' ] ) );
	if( isset( $_POST[ 'myoptionalmodules_nelio_submit' ] ) && check_admin_referer( 'myoptionalmodules_nelio_submit' ) )
		update_option( 'myoptionalmodules_nelio', sanitize_text_field( $_REQUEST[ 'myoptionalmodules_nelio' ] ) );
	if( isset( $_POST[ 'momsesave' ] ) && check_admin_referer( 'hidecategoriesfrom' ) ) {
		foreach( $_REQUEST as $k => $v ) {
			$v = sanitize_text_field( $v );
			if( $v  ) update_option( $k, $v );
			if( !$v ) delete_option( $k );
		}
	}
	if( isset( $_POST[ 'mom_save_form_submit' ] ) && check_admin_referer( 'mom_save_form' ) ) {
		$_REQUEST[ 'myoptionalmodules_frontpage' ] = sanitize_text_field( $_REQUEST[ 'myoptionalmodules_frontpage' ] );
		$_REQUEST[ 'previous_link_class' ]         = sanitize_text_field( str_replace( '.', '', $_REQUEST[ 'previous_link_class' ] ) );
		$_REQUEST[ 'google_tracking_id' ]          = sanitize_text_field( $_REQUEST[ 'google_tracking_id' ] );
		$_REQUEST[ 'next_link_class' ]             = sanitize_text_field( str_replace( '.', '', $_REQUEST[ 'next_link_class' ] ) );
		$_REQUEST[ 'read_more' ]                   = sanitize_text_field( $_REQUEST[ 'read_more' ] );
		$_REQUEST[ 'randomget' ]                   = sanitize_text_field( $_REQUEST[ 'randomget' ] );
		$_REQUEST[ 'randomsitetitles' ]            = sanitize_text_field( $_REQUEST[ 'randomsitetitles' ] );
		$_REQUEST[ 'randomsitedescriptions' ]      = sanitize_text_field( $_REQUEST[ 'randomsitedescriptions' ] );
		update_option( 'myoptionalmodules_randompost', $_REQUEST[ 'randomget' ] );
		update_option( 'myoptionalmodules_google', $_REQUEST[ 'google_tracking_id' ] );
		update_option( 'myoptionalmodules_previouslinkclass', $_REQUEST[ 'previous_link_class' ] );
		update_option( 'myoptionalmodules_nextlinkclass', $_REQUEST[ 'next_link_class' ] );
		update_option( 'myoptionalmodules_readmore', $_REQUEST[ 'read_more' ] );
		update_option( 'myoptionalmodules_frontpage', $_REQUEST[ 'myoptionalmodules_frontpage' ] );
		update_option( 'myoptionalmodules_randomtitles', $_REQUEST[ 'randomsitetitles' ] );
		update_option( 'myoptionalmodules_randomdescriptions', $_REQUEST[ 'randomsitedescriptions' ] );
	}
	/**
	 * Automatically delete empty/'0' options
	 */
	$check_for_blanks = array(
		'myoptionalmodules_featureimagewidth',
		'myoptionalmodules_recentpostswidget',
		'myoptionalmodules_rsslinkbacks',
		'myoptionalmodules_404s',
		'myoptionalmodules_javascripttofooter',
		'myoptionalmodules_authorarchives',
		'myoptionalmodules_datearchives',
		'myoptionalmodules_plugincss',
		'myoptionalmodules_disablecomments',
		'myoptionalmodules_removecode',
		'myoptionalmodules_dnsbl',
		'myoptionalmodules_ajaxcomments',
		'myoptionalmodules_commentspamfield',
		'myoptionalmodules_exclude',
		'myoptionalmodules_sharelinks',
		'myoptionalmodules_shareslinks_top',
		'myoptionalmodules_sharelinks_pages',
		'myoptionalmodules_sharelinks_reddit',
		'myoptionalmodules_sharelinks_twitter',
		'myoptionalmodules_sharelinks_email',
		'myoptionalmodules_sharelinks_google',
		'myoptionalmodules_sharelinks_facebook',
		'myoptionalmodules_metatags',
		'myoptionalmodules_horizontalgalleries',
		'myoptionalmodules_fontawesome',
		'myoptionalmodules_lazyload',
		'myoptionalmodules_disablepingbacks',
		'myoptionalmodules_admin_toggletrash',
		'myoptionalmodules_admin_toggledisable',
		'myoptionalmodules_admin_toggleenable',
		'myoptionalmodules_admin_toggleshare',
		'myoptionalmodules_admin_togglecomment',
		'myoptionalmodules_admin_toggleextras',
		'myoptionalmodules_admin_togglemisc',
		'myoptionalmodules_admin_toggleshortcodes',
		'myoptionalmodules_admin_toggledevelopers',
		'myoptionalmodules_admin_togglecategories',
		'myoptionalmodules_nelio',
		'myoptionalmodules_randompost',
		'myoptionalmodules_google',
		'myoptionalmodules_previouslinkclass',
		'myoptionalmodules_nextlinkclass',
		'myoptionalmodules_readmore',
		'myoptionalmodules_frontpage',
		'myoptionalmodules_randomtitles',
		'myoptionalmodules_randomdescriptions'
	);
	foreach( $check_for_blanks as &$blanks ){
		if( get_option( $blanks ) ) {
			if( '' == get_option( $blanks ) || 0 == get_option( $blanks ) ) {
				delete_option( $blanks );
			}
		}
	}
}