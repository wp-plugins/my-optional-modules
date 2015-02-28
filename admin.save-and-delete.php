<?php 

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

if( isset( $_POST[ 'MOM_UNINSTALL_EVERYTHING' ] ) && check_admin_referer( 'MOM_UNINSTALL_EVERYTHING' ) ) {
	$option = array( 
		'mommaincontrol_externalthumbs',
		'mommaincontrol_enablecss',
		'mom_external_thumbs',
		'mommaincontrol_404',
		'mommaincontrol_protectrss',
		'mommaincontrol_footerscripts',
		'mommaincontrol_authorarchives',
		'mommaincontrol_datearchives',
		'mommaincontrol_comments',
		'mommaincontrol_dnsbl',
		'MOM_themetakeover_ajaxcomments',
		'MOM_themetakeover_hidden_field',
		'mommaincontrol_thumbnail',
		'mommaincontrol_recent_posts',
		'mommodule_random_descriptions',
		'mommodule_random_title',
		'MOM_themetakeover_horizontal_galleries',
		'mommaincontrol_momse',
		'mommaincontrol_momshare',
		'mommaincontrol_fontawesome',
		'mommaincontrol_lazyload',
		'mommaincontrol_versionnumbers',
		'mommaincontrol_disablepingbacks',
		'mompaf_post',
		'MOM_Exclude_PostFormats_Visitor',
		'MOM_Exclude_Users_RSS',
		'MOM_Exclude_Users_Front',
		'MOM_Exclude_Users_TagArchives',
		'MOM_Exclude_Users_CategoryArchives',
		'MOM_Exclude_Users_SearchResults',
		'MOM_Exclude_Users_UsersSun',
		'MOM_Exclude_Users_UsersMon',
		'MOM_Exclude_Users_UsersTue',
		'MOM_Exclude_Users_UsersWed',
		'MOM_Exclude_Users_UsersThu',
		'MOM_Exclude_Users_UsersFri',
		'MOM_Exclude_Users_UsersSat',
		'MOM_Exclude_Users_level0Users',
		'MOM_Exclude_Users_level1Users',
		'MOM_Exclude_Users_level2Users',
		'MOM_Exclude_Users_level7Users',
		'MOM_Exclude_PostFormats_RSS',
		'MOM_Exclude_PostFormats_Front',
		'MOM_Exclude_PostFormats_CategoryArchives',
		'MOM_Exclude_PostFormats_TagArchives',
		'MOM_Exclude_PostFormats_SearchResults',
		'MOM_Exclude_Categories_Front',
		'MOM_Exclude_Categories_TagArchives',
		'MOM_Exclude_Tags_TagsSun',
		'MOM_Exclude_Tags_TagsMon',
		'MOM_Exclude_Tags_TagsTue',
		'MOM_Exclude_Tags_TagsWed',
		'MOM_Exclude_Tags_TagsThu',
		'MOM_Exclude_Tags_TagsFri',
		'MOM_Exclude_Tags_TagsSat',
		'MOM_Exclude_Categories_CategoriesSun',
		'MOM_Exclude_Categories_CategoriesMon',
		'MOM_Exclude_Categories_CategoriesTue',
		'MOM_Exclude_Categories_CategoriesWed',
		'MOM_Exclude_Categories_CategoriesThu',
		'MOM_Exclude_Categories_CategoriesFri',
		'MOM_Exclude_Categories_CategoriesSat',
		'MOM_Exclude_Categories_SearchResults',
		'MOM_Exclude_Categories_RSS',
		'MOM_Exclude_Tags_RSS',
		'MOM_Exclude_Tags_Front',
		'MOM_Exclude_Tags_CategoryArchives',
		'MOM_Exclude_Tags_SearchResults',
		'MOM_Exclude_PostFormats_Front',
		'MOM_Exclude_PostFormats_CategoryArchives',
		'MOM_Exclude_PostFormats_TagArchives',
		'MOM_Exclude_PostFormats_SearchResults',
		'MOM_Exclude_PostFormats_Visitor',
		'MOM_Exclude_PostFormats_RSS',
		'MOM_Exclude_Tags_Tags',
		'MOM_Exclude_Categories_Categories',
		'MOM_Exclude_Categories_level0Categories',
		'MOM_Exclude_Categories_level1Categories',
		'MOM_Exclude_Categories_level2Categories',
		'MOM_Exclude_Categories_level7Categories',
		'MOM_Exclude_Tags_level0Tags',
		'MOM_Exclude_Tags_level1Tags',
		'MOM_Exclude_Tags_level2Tags',
		'MOM_Exclude_Tags_level7Tags',
		'MOM_enable_share_top',
		'MOM_enable_share_pages',
		'MOM_enable_share_reddit',
		'MOM_enable_share_google',
		'MOM_enable_share_twitter',
		'MOM_enable_share_facebook',
		'MOM_enable_share_email',
		'mom_next_link_class',
		'mom_previous_link_class',
		'mom_readmore_content',
		'mom_random_get',
		'toggle_trash',
		'toggle_disable',
		'toggle_enable',
		'toggle_share',
		'toggle_comment',
		'toggle_extras',
		'toggle_misc',
		'toggle_shortcodes',
		'toggle_developers',
		'toggle_categories'
	);
	foreach( $option as &$value ) {
		delete_option( $value );
	}
} else {
	if( isset( $_POST[ 'mom_thumbnail_mode_submit' ] ) && check_admin_referer( 'thumbnail' ) ) {
		$_REQUEST[ 'thumbnail' ] = sanitize_text_field( $_REQUEST[ 'thumbnail' ] );
		update_option( 'mommaincontrol_thumbnail', $_REQUEST[ 'thumbnail' ] );
	}
	if( isset( $_POST[ 'mom_recent_posts_mode_submit' ] ) && check_admin_referer( 'recentposts' ) ) {
		$_REQUEST[ 'recentposts' ] = sanitize_text_field( $_REQUEST[ 'recentposts' ] );
		update_option( 'mommaincontrol_recent_posts', $_REQUEST[ 'recentposts' ] );
	}		
	if( isset( $_POST[ 'mom_protectrss_mode_submit' ] ) && check_admin_referer( 'protectrss' ) ) {
		$_REQUEST[ 'protectrss' ] = sanitize_text_field( $_REQUEST[ 'protectrss' ] );
		update_option( 'mommaincontrol_protectrss', $_REQUEST[ 'protectrss' ] );
	}
	if( isset( $_POST[ 'mom_404_mode_submit' ] ) && check_admin_referer( '404' ) ) {
		$_REQUEST[ '404' ] = sanitize_text_field( $_REQUEST[ '404' ] );
		update_option( 'mommaincontrol_404', $_REQUEST[ '404' ] );
	}		
	if( isset( $_POST[ 'mom_footerscripts_mode_submit' ] ) && check_admin_referer( 'footerscripts' ) ) {
		$_REQUEST[ 'footerscripts' ] = sanitize_text_field( $_REQUEST[ 'footerscripts' ] );
		update_option( 'mommaincontrol_footerscripts', $_REQUEST[ 'footerscripts' ] );
	}
	if( isset( $_POST[ 'mom_author_archives_mode_submit' ] ) && check_admin_referer( 'authorarchives' ) ) { 
		$_REQUEST[ 'authorarchives' ] = sanitize_text_field( $_REQUEST[ 'authorarchives' ] );
		update_option( 'mommaincontrol_authorarchives', $_REQUEST[ 'authorarchives' ] );
	}
	if( isset( $_POST[ 'mom_date_archives_mode_submit' ] ) && check_admin_referer( 'datearchives' ) ) { 
		$_REQUEST[ 'datearchives' ] = sanitize_text_field( $_REQUEST[ 'datearchives' ] );
		update_option( 'mommaincontrol_datearchives', $_REQUEST[ 'datearchives' ] );
	}
	if( isset( $_POST[ 'mom_plugin_css_mode_submit' ] ) && check_admin_referer( 'pluginCSS' ) ) { 
		$_REQUEST[ 'pluginCSS' ] = sanitize_text_field( $_REQUEST[ 'pluginCSS' ] );
		update_option( 'mommaincontrol_enablecss', $_REQUEST[ 'pluginCSS' ] );
	}		
	if( isset( $_POST[ 'mom_comments_mode_submit' ] ) && check_admin_referer( 'momComments' ) ) { 
		$_REQUEST[ 'comments' ] = sanitize_text_field( $_REQUEST[ 'comments' ] );		
		update_option( 'mommaincontrol_comments', $_REQUEST[ 'comments' ] );
	}
	if( isset( $_POST[ 'mom_dnsbl_mode_submit' ] ) && check_admin_referer( 'momDNSBL' ) ) {
		$_REQUEST[ 'dnsbl' ] = sanitize_text_field( $_REQUEST[ 'dnsbl' ] );
		update_option( 'mommaincontrol_dnsbl', $_REQUEST[ 'dnsbl' ] );
	}
	if( isset( $_POST[ 'mom_ajax_comments_mode_submit' ] ) && check_admin_referer( 'momAjaxComments' ) ) { 
		$_REQUEST[ 'ajaxify' ] = sanitize_text_field( $_REQUEST[ 'ajaxify' ] );
		update_option( 'MOM_themetakeover_ajaxcomments', $_REQUEST[ 'ajaxify' ] );
	}
	if( isset( $_POST[ 'mom_hidden_field_mode_submit' ] ) && check_admin_referer( 'momHiddenField' ) ) { 
		$_REQUEST[ 'hidden' ] = sanitize_text_field( $_REQUEST[ 'hidden' ] );
		update_option( 'MOM_themetakeover_hidden_field', $_REQUEST[ 'hidden' ] );
	}		
	if( isset( $_POST[ 'mom_exclude_mode_submit' ] ) && check_admin_referer( 'momExclude' ) ) { 
		$_REQUEST[ 'exclude' ] = sanitize_text_field( $_REQUEST[ 'exclude' ] );
		update_option( 'mommaincontrol_momse', $_REQUEST[ 'exclude' ] );
	}
	if( isset( $_POST[ 'mom_share_mode_submit' ] ) && check_admin_referer( 'momShare' ) ) { 
		$_REQUEST[ 'share' ] = sanitize_text_field( $_REQUEST[ 'share' ] );
		update_option( 'mommaincontrol_momshare', $_REQUEST[ 'share' ] );
	}
	if( 1 == get_option( 'mommaincontrol_momshare' ) ) {
		if( isset( $_POST[ 'MOM_enable_share_top' ] ) && check_admin_referer( 'momShareTop' ) ) { 
			$_REQUEST[ 'top' ] = sanitize_text_field( $_REQUEST[ 'top' ] );
			update_option( 'MOM_enable_share_top', $_REQUEST[ 'top' ] );
		}
		if( isset( $_POST[ 'MOM_enable_share_pages' ] ) && check_admin_referer( 'momSharePages' ) ) {
			$_REQUEST[ 'pages' ] = sanitize_text_field( $_REQUEST[ 'pages' ] );
			update_option( 'MOM_enable_share_pages', $_REQUEST[ 'pages' ] );
		}
		if( isset( $_POST[ 'MOM_enable_share_reddit' ] ) && check_admin_referer( 'momShareReddit' ) ) { 
			$_REQUEST[ 'reddit' ] = sanitize_text_field( $_REQUEST[ 'reddit' ] );
			update_option( 'MOM_enable_share_reddit', $_REQUEST[ 'reddit' ] );
		}
		if( isset( $_POST[ 'MOM_enable_share_twitter' ] ) && check_admin_referer( 'momShareTwitter' ) ) { 
			$_REQUEST[ 'twitter' ] = sanitize_text_field( $_REQUEST[ 'twitter' ] );
			update_option( 'MOM_enable_share_twitter', $_REQUEST[ 'twitter' ] );
		}
		if( isset( $_POST[ 'MOM_enable_share_email' ] ) && check_admin_referer( 'momShareEmail' ) ) { 
			$_REQUEST[ 'email' ] = sanitize_text_field( $_REQUEST[ 'email' ] );
			update_option( 'MOM_enable_share_email', $_REQUEST[ 'email' ] );
		}
		if( isset( $_POST[ 'MOM_enable_share_google' ] ) && check_admin_referer( 'momShareGoogle' ) ) { 
			$_REQUEST[ 'google' ] = sanitize_text_field( $_REQUEST[ 'google' ] );
			update_option( 'MOM_enable_share_google', $_REQUEST[ 'google' ] );
		}
		if( isset( $_POST[ 'MOM_enable_share_facebook' ] ) && check_admin_referer( 'momShareFacebook' ) ) { 
			$_REQUEST[ 'facebook' ] = sanitize_text_field( $_REQUEST[ 'facebook' ] );
			update_option( 'MOM_enable_share_facebook', $_REQUEST[ 'facebook' ] );
		}
	}
	if( isset( $_POST[ 'mom_horizontal_galleries_mode_submit' ] ) && check_admin_referer( 'momHorizontalGalleries' ) ) { 
		$_REQUEST[ 'hgalleries' ] = sanitize_text_field( $_REQUEST[ 'hgalleries' ] );
		update_option( 'MOM_themetakeover_horizontal_galleries', $_REQUEST[ 'hgalleries' ] );
	}
	if( isset( $_POST[ 'mom_fontawesome_mode_submit' ] ) && check_admin_referer( 'fontawesome' ) ) { 
		$_REQUEST[ 'mommaincontrol_fontawesome' ] = sanitize_text_field( $_REQUEST[ 'mommaincontrol_fontawesome' ] );
		update_option( 'mommaincontrol_fontawesome', $_REQUEST[ 'mommaincontrol_fontawesome' ] );
	}
	if( isset( $_POST[ 'mom_lazy_mode_submit' ] ) && check_admin_referer( 'lazyload' ) ) { 
		$_REQUEST[ 'mommaincontrol_lazyload' ] = sanitize_text_field( $_REQUEST[ 'mommaincontrol_lazyload' ] );
		update_option( 'mommaincontrol_lazyload', $_REQUEST[ 'mommaincontrol_lazyload' ] );
	}
	if( isset( $_POST[ 'mom_versions_submit' ] ) && check_admin_referer( 'hidewpversions' ) ) { 
		$_REQUEST[ 'mommaincontrol_versionnumbers' ] = sanitize_text_field( $_REQUEST[ 'mommaincontrol_versionnumbers' ] );
		update_option( 'mommaincontrol_versionnumbers', $_REQUEST[ 'mommaincontrol_versionnumbers' ] );
	}
	if( isset( $_POST[ 'mom_disablepingbacks_submit' ] ) && check_admin_referer( 'disablepingbacks' ) ) { 
		$_REQUEST[ 'mommaincontrol_disablepingbacks' ] = sanitize_text_field( $_REQUEST[ 'mommaincontrol_disablepingbacks' ] );
		update_option( 'mommaincontrol_disablepingbacks', $_REQUEST[ 'mommaincontrol_disablepingbacks' ] );
	}

	if( isset( $_POST[ 'momsesave' ] ) && check_admin_referer( 'hidecategoriesfrom' ) ) {
		foreach( $_REQUEST as $k => $v ) {
			$v = sanitize_text_field( $v );
			update_option( $k, $v );
		}
	}
	
	if( isset( $_POST[ 'toggle_trash_submit' ] ) && check_admin_referer( 'toggle_trash_form' ) ) {
		$_REQUEST[ 'toggle_trash' ] = sanitize_text_field( $_REQUEST[ 'toggle_trash' ] );
		update_option( 'toggle_trash', $_REQUEST[ 'toggle_trash' ] );			
	}
	if( isset( $_POST[ 'toggle_disable_submit' ] ) && check_admin_referer( 'toggle_disable_form' ) ) {
		$_REQUEST[ 'toggle_disable' ] = sanitize_text_field( $_REQUEST[ 'toggle_disable' ] );
		update_option( 'toggle_disable', $_REQUEST[ 'toggle_disable' ] );			
	}
	if( isset( $_POST[ 'toggle_enable_submit' ] ) && check_admin_referer( 'toggle_enable_form' ) ) {
		$_REQUEST[ 'toggle_enable' ] = sanitize_text_field( $_REQUEST[ 'toggle_enable' ] );
		update_option( 'toggle_enable', $_REQUEST[ 'toggle_enable' ] );			
	}
	if( isset( $_POST[ 'toggle_share_submit' ] ) && check_admin_referer( 'toggle_share_form' ) ) {
		$_REQUEST[ 'toggle_share' ] = sanitize_text_field( $_REQUEST[ 'toggle_share' ] );
		update_option( 'toggle_share', $_REQUEST[ 'toggle_share' ] );			
	}
	if( isset( $_POST[ 'toggle_comment_submit' ] ) && check_admin_referer( 'toggle_comment_form' ) ) {
		$_REQUEST[ 'toggle_comment' ] = sanitize_text_field( $_REQUEST[ 'toggle_comment' ] );
		update_option( 'toggle_comment', $_REQUEST[ 'toggle_comment' ] );			
	}
	if( isset( $_POST[ 'toggle_extras_submit' ] ) && check_admin_referer( 'toggle_extras_form' ) ) {
		$_REQUEST[ 'toggle_extras' ] = sanitize_text_field( $_REQUEST[ 'toggle_extras' ] );
		update_option( 'toggle_extras', $_REQUEST[ 'toggle_extras' ] );			
	}
	if( isset( $_POST[ 'toggle_misc_submit' ] ) && check_admin_referer( 'toggle_misc_form' ) ) {
		$_REQUEST[ 'toggle_misc' ] = sanitize_text_field( $_REQUEST[ 'toggle_misc' ] );
		update_option( 'toggle_misc', $_REQUEST[ 'toggle_misc' ] );			
	}
	if( isset( $_POST[ 'toggle_shortcodes_submit' ] ) && check_admin_referer( 'toggle_shortcodes_form' ) ) {
		$_REQUEST[ 'toggle_shortcodes' ] = sanitize_text_field( $_REQUEST[ 'toggle_shortcodes' ] );
		update_option( 'toggle_shortcodes', $_REQUEST[ 'toggle_shortcodes' ] );			
	}
	if( isset( $_POST[ 'toggle_developers_submit' ] ) && check_admin_referer( 'toggle_developers_form' ) ) {
		$_REQUEST[ 'toggle_developers' ] = sanitize_text_field( $_REQUEST[ 'toggle_developers' ] );
		update_option( 'toggle_developers', $_REQUEST[ 'toggle_developers' ] );			
	}
	if( isset( $_POST[ 'toggle_categories_submit' ] ) && check_admin_referer( 'toggle_categories_form' ) ) {
		$_REQUEST[ 'toggle_categories' ] = sanitize_text_field( $_REQUEST[ 'toggle_categories' ] );
		update_option( 'toggle_categories', $_REQUEST[ 'toggle_categories' ] );			
	}		
	
	if( !get_option( 'mommaincontrol_mompaf' ) ) {
		add_option( 'mompaf_post', 'off' );
	}

	if( isset( $_POST[ 'mom_save_form_submit' ] ) && check_admin_referer( 'mom_save_form' ) ) {
		$_REQUEST[ 'mompaf_post' ]           = sanitize_text_field( $_REQUEST[ 'mompaf_post' ] );
		$_REQUEST[ 'previous_link_class' ]   = sanitize_text_field( str_replace( '.', '', $_REQUEST[ 'previous_link_class' ] ) );
		$_REQUEST[ 'next_link_class' ]       = sanitize_text_field( str_replace( '.', '', $_REQUEST[ 'next_link_class' ] ) );
		$_REQUEST[ 'read_more' ]             = sanitize_text_field( $_REQUEST[ 'read_more' ] );
		$_REQUEST[ 'randomget' ]             = sanitize_text_field( $_REQUEST[ 'randomget' ] );
		$_REQUEST[ 'randomsitetitles' ]      = sanitize_text_field( $_REQUEST[ 'randomsitetitles' ] );
		$_REQUEST[ 'randomsitedescriptions' ] = sanitize_text_field( $_REQUEST[ 'randomsitedescriptions' ] );
		update_option( 'mom_random_get', $_REQUEST[ 'randomget' ] );
		update_option( 'mom_previous_link_class', $_REQUEST[ 'previous_link_class' ] );
		update_option( 'mom_next_link_class', $_REQUEST[ 'next_link_class' ] );
		update_option( 'mom_readmore_content', $_REQUEST[ 'read_more' ] );
		update_option( 'mompaf_post', $_REQUEST[ 'mompaf_post' ] );
		update_option( 'mommodule_random_title', $_REQUEST[ 'randomsitetitles' ] );
		update_option( 'mommodule_random_descriptions', $_REQUEST[ 'randomsitedescriptions' ] );
	}
	add_option( 'mompaf_post', 'off' );
	add_option( 'mommaincontrol_enablecss', 0 );
	
	if( isset( $_POST[ 'mom_external_thumbs_mode_submit' ] ) && check_admin_referer( 'externalthumbs' ) ) { 
		$_REQUEST[ 'externalthumbs' ] = sanitize_text_field( $_REQUEST[ 'externalthumbs' ] );
		update_option( 'mommaincontrol_externalthumbs', $_REQUEST[ 'externalthumbs' ] );
	}		
	
}