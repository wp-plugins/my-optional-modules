<?php 
/**
 * function.exclude
 * Exclude posts from the loop based on a set of options
 */ 

if(!defined('MyOptionalModules')){
	die();
}

global $myoptionalmodules_plugin;
$date_day = date( 'D' );

/**
 * Set default variables
 * Set them (initially) to nothing
 * Then, grab the value from the database and reset them
 */
$c1	     = array( '0' );
$t1	     = array( '0' );
$rss_day = array( '0' );
$u1      = array( '0' );
$t11     = 0;
$c_1     = 0;
$u_1     = 0;
$loggedOutUsers                           = 0;
$loggedOutCats                            = 0;
$loggedOutTags                            = 0;
$chck_users                               = 0; 
$chck_cats                                = 0;
$chck_tags                                = 0;
$MOM_Exclude_Categories_Front             = 0;
$MOM_Exclude_Categories_TagArchives       = 0;
$MOM_Exclude_Categories_SearchResults     = 0;
$MOM_Exclude_Categories_RSS               = 0;
$MOM_Exclude_Tags_Front                   = 0;
$MOM_Exclude_Tags_RSS                     = 0;
$MOM_Exclude_Tags_CategoryArchives        = 0;
$MOM_Exclude_Tags_SearchResults           = 0;
$MOM_Exclude_PostFormats_Front            = 0;
$MOM_Exclude_PostFormats_CategoryArchives = 0;
$MOM_Exclude_PostFormats_TagArchives      = 0;
$MOM_Exclude_PostFormats_SearchResults    = 0;
$MOM_Exclude_PostFormats_Visitor          = 0;
$MOM_Exclude_PostFormats_RSS              = 0;
$MOM_Exclude_Tags_Day                     = 0;
$MOM_Exclude_Cats_Day                     = 0;
$MOM_Exclude_Users_RSS                    = 0;
$MOM_Exclude_Users_Front                  = 0;
$MOM_Exclude_Users_TagArchives            = 0;
$myoptionalmodules_exclude_userscategoryarchives       = 0;
$myoptionalmodules_exclude_userssearchresults          = 0;
$MOM_Exclude_Users_Day                    = 0;
$MOM_Exclude_Categories_Front             = sanitize_text_field( get_option( 'myoptionalmodules_exclude_categoriesfront' ) );
$MOM_Exclude_Categories_TagArchives       = sanitize_text_field( get_option( 'myoptionalmodules_exclude_categoriestagarchives' ) );
$MOM_Exclude_Categories_SearchResults     = sanitize_text_field( get_option( 'myoptionalmodules_exclude_categoriessearchresults' ) );
$MOM_Exclude_Categories_RSS               = sanitize_text_field( get_option( 'myoptionalmodules_exclude_categoriesrss' ) );
$MOM_Exclude_Tags_Front                   = sanitize_text_field( get_option( 'myoptionalmodules_exclude_tagsfront' ) );
$MOM_Exclude_Tags_RSS                     = sanitize_text_field( get_option( 'myoptionalmodules_exclude_tagsrss' ) );
$MOM_Exclude_Tags_CategoryArchives        = sanitize_text_field( get_option( 'myoptionalmodules_exclude_tagscategoryarchives' ) );
$MOM_Exclude_Tags_SearchResults           = sanitize_text_field( get_option( 'myoptionalmodules_exclude_tagssearchresults' ) );
$MOM_Exclude_PostFormats_Front            = sanitize_text_field( get_option( 'myoptionalmodules_exclude_postformatsfront' ) );
$MOM_Exclude_PostFormats_CategoryArchives = sanitize_text_field( get_option( 'myoptionalmodules_exclude_postformatscategoryarchives' ) );
$MOM_Exclude_PostFormats_TagArchives      = sanitize_text_field( get_option( 'myoptionalmodules_exclude_postformatstagarchives' ) );
$MOM_Exclude_PostFormats_SearchResults    = sanitize_text_field( get_option( 'myoptionalmodules_exclude_postformatssearchresults' ) );
$MOM_Exclude_PostFormats_Visitor          = sanitize_text_field( get_option( 'myoptionalmodules_exclude_visitorpostformats' ) );
$MOM_Exclude_PostFormats_RSS              = sanitize_text_field( get_option( 'myoptionalmodules_exclude_postformatsrss' ) );
$MOM_Exclude_Tags_Day                     = sanitize_text_field( get_option( 'myoptionalmodules_exclude_tagstags' . $date_day . '' ) );
$MOM_Exclude_Cats_Day                     = sanitize_text_field( get_option( 'myoptionalmodules_exclude_categoriescategories' . $date_day . '' ) );
$MOM_Exclude_Users_RSS                    = sanitize_text_field( get_option( 'myoptionalmodules_exclude_usersrss' ) );
$MOM_Exclude_Users_Front                  = sanitize_text_field( get_option( 'myoptionalmodules_exclude_usersfront' ) );
$MOM_Exclude_Users_TagArchives            = sanitize_text_field( get_option( 'myoptionalmodules_exclude_userstagarchives' ) );
$myoptionalmodules_exclude_userscategoryarchives       = sanitize_text_field( get_option( 'myoptionalmodules_exclude_userscategoryarchives' ) );
$myoptionalmodules_exclude_userssearchresults          = sanitize_text_field( get_option( 'myoptionalmodules_exclude_userssearchresults' ) );
$MOM_Exclude_Users_Day                    = sanitize_text_field( get_option( 'myoptionalmodules_exclude_usersusers' . $date_day . '' ) );
/**
 * Get the (current) days values
 * Only both with this if there's something to actually bother with
 */
$rss_day = explode( ',', $MOM_Exclude_Tags_Day );
if( is_array( $rss_day ) ) {
	foreach( $rss_day as &$rss_day_1 ) {
		$rss_day_1 = $rss_day_1 . ',';
	}
}
$rss_day_1     = implode( $rss_day );
$rssday        = explode( ',', str_replace ( ' ', '', $rss_day_1 ) );
$rss_day_cat   = explode( ',', $MOM_Exclude_Cats_Day );
if( is_array( $rss_day_cat ) ) {
	foreach( $rss_day_cat as &$rss_day_1_cat ) {
		$rss_day_1_cat = $rss_day_1_cat . ',';
	}
}
$rss_day_1_cat = implode( $rss_day_cat );
$rssday_cat    = explode( ',', str_replace ( ' ', '', $rss_day_1_cat ) );
$rss_day_user   = explode( ',', $MOM_Exclude_Users_Day );
if( is_array( $rss_day_user ) ) {
	foreach( $rss_day_user as &$rss_day_1_user ) {
		$rss_day_1_user = $rss_day_1_user . ',';
	}
}
$rss_day_1_user = implode( $rss_day_user );
$rssday_user    = explode( ',', str_replace ( ' ', '', $rss_day_1_user ) );
/**
 * Grab values for a user who is not logged in
 */
if( !is_user_logged_in() ) {
	$MOM_Exclude_level0Users       = 0;
	$MOM_Exclude_level1Users       = 0;
	$MOM_Exclude_level2Users       = 0;
	$MOM_Exclude_level7Users       = 0;
	$MOM_Exclude_level0Categories  = 0;
	$MOM_Exclude_level1Categories  = 0;
	$MOM_Exclude_level2Categories  = 0;
	$MOM_Exclude_level7Categories  = 0;
	$MOM_Exclude_level0Tags        = 0;
	$MOM_Exclude_level1Tags        = 0;
	$MOM_Exclude_level2Tags        = 0;
	$MOM_Exclude_level7Tags        = 0;
	$loggedOutUsers                = 0;
	$loggedOutCats                 = 0;
	$loggedOutTags                 = 0;
	$MOM_Exclude_level0Users       = get_option( 'myoptionalmodules_exclude_userslevel10users' ); 
	$MOM_Exclude_level1Users       = get_option( 'myoptionalmodules_exclude_userslevel1users' ); 
	$MOM_Exclude_level2Users       = get_option( 'myoptionalmodules_exclude_userslevel2users' ); 
	$MOM_Exclude_level7Users       = get_option( 'myoptionalmodules_exclude_userslevel7users' ); 
	$MOM_Exclude_level0Categories  = get_option( 'myoptionalmodules_exclude_categories_level0categories' ); 
	$MOM_Exclude_level1Categories  = get_option( 'myoptionalmodules_exclude_categorieslevel1categories' ); 
	$MOM_Exclude_level2Categories  = get_option( 'myoptionalmodules_exclude_categorieslevel2categories' ); 
	$MOM_Exclude_level7Categories  = get_option( 'myoptionalmodules_exclude_categorieslevel7categories' ); 
	$MOM_Exclude_level0Tags        = get_option( 'myoptionalmodules_exclude_tagslevel0tags' );
	$MOM_Exclude_level1Tags        = get_option( 'myoptionalmodules_exclude_tagslevel1tags' );
	$MOM_Exclude_level2Tags        = get_option( 'myoptionalmodules_exclude_tagslevel2tags' );
	$MOM_Exclude_level7Tags        = get_option( 'myoptionalmodules_exclude_tagslevel7tags' );
	$loggedOutUsers = $MOM_Exclude_level0Users . ',' . $MOM_Exclude_level1Users . ',' . $MOM_Exclude_level2Users . ',' . $MOM_Exclude_level7Users;
	$loggedOutCats  = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
	$loggedOutTags  = $MOM_Exclude_level0Tags . ',' . $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
	$lu1 = array_unique( explode( ',', $loggedOutUsers ) );
	foreach( $lu1 as &$LU1 ) { 
		$LU1 = $LU1 . ','; 
	}
	$lu_1 = rtrim( implode( $lu1 ), ',' );				
	$hideLoggedOutUsers = explode ( ',', str_replace ( ' ', '', $loggedOutUsers ) );
	$lc1 = array_unique( explode( ',', $loggedOutCats ) );
	foreach( $lc1 as &$LC1 ) { 
		$LC1 = $LC1 . ','; 
	}
	$lc_1 = rtrim( implode( $lc1 ), ',' );
	$hideLoggedOutCats = explode ( ',', str_replace ( ' ', '', $loggedOutCats ) );
	$lt1 = array_unique ( explode ( ',', $loggedOutTags ) );
	foreach( $lt1 as &$LT1 ) { 
		$LT1 = $LT1 . ','; 
	}
	$lt11 = rtrim( implode( $lt1 ), ',' );
	$hideLoggedOutTags = explode( ',', str_replace ( ' ', '', $lt11 ) );
	$formats_to_hide   = $MOM_Exclude_PostFormats_Visitor;
} else {
	$loggedOutUsers                = 0;
	$loggedOutCats                 = 0;
	$loggedOutTags                 = 0;
	$MOM_Exclude_level0Users       = 0;
	$MOM_Exclude_level1Users       = 0;
	$MOM_Exclude_level2Users       = 0;
	$MOM_Exclude_level7Users       = 0;				
	$MOM_Exclude_level0Categories  = 0;
	$MOM_Exclude_level1Categories  = 0;
	$MOM_Exclude_level2Categories  = 0;
	$MOM_Exclude_level7Categories  = 0;
	$MOM_Exclude_level0Tags        = 0;
	$MOM_Exclude_level1Tags        = 0;
	$MOM_Exclude_level2Tags        = 0; 
	$MOM_Exclude_level7Tags        = 0;
	$MOM_Exclude_level0Users       = get_option( 'myoptionalmodules_exclude_userslevel10users' ); 
	$MOM_Exclude_level1Users       = get_option( 'myoptionalmodules_exclude_userslevel1users' ); 
	$MOM_Exclude_level2Users       = get_option( 'myoptionalmodules_exclude_userslevel2users' ); 
	$MOM_Exclude_level7Users       = get_option( 'myoptionalmodules_exclude_userslevel7users' );				
	$MOM_Exclude_level0Categories  = get_option( 'myoptionalmodules_exclude_categories_level0categories' ); 
	$MOM_Exclude_level1Categories  = get_option( 'myoptionalmodules_exclude_categorieslevel1categories' ); 
	$MOM_Exclude_level2Categories  = get_option( 'myoptionalmodules_exclude_categorieslevel2categories' ); 
	$MOM_Exclude_level7Categories  = get_option( 'myoptionalmodules_exclude_categorieslevel7categories' ); 
	$MOM_Exclude_level0Tags        = get_option( 'myoptionalmodules_exclude_tagslevel0tags' ); 
	$MOM_Exclude_level1Tags        = get_option( 'myoptionalmodules_exclude_tagslevel1tags' ); 
	$MOM_Exclude_level2Tags        = get_option( 'myoptionalmodules_exclude_tagslevel2tags' ); 
	$MOM_Exclude_level7Tags        = get_option( 'myoptionalmodules_exclude_tagslevel7tags' );
	if( !$myoptionalmodules_plugin->user_level ) {
		$loggedOutUsers = $MOM_Exclude_level0Users . ',' . $MOM_Exclude_level1Users . ',' . $MOM_Exclude_level2Users . ',' . $MOM_Exclude_level7Users;
		$loggedOutCats  = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		$loggedOutTags  = $MOM_Exclude_level0Tags . ',' . $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
	}
	if( 1 == $myoptionalmodules_plugin->user_level ) {
		$loggedOutUsers = $MOM_Exclude_level1Users . ',' . $MOM_Exclude_level2Users . ',' . $MOM_Exclude_level7Users;
		$loggedOutCats  = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		$loggedOutTags  = $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
	}
	if( 2 == $myoptionalmodules_plugin->user_level ) {
		$loggedOutUsers = $MOM_Exclude_level1Users . ',' . $MOM_Exclude_level2Users . ',' . $MOM_Exclude_level7Users;
		$loggedOutCats  = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		$loggedOutTags  = $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
	}
	if( 3 == $myoptionalmodules_plugin->user_level ) {
		$loggedOutUsers = $MOM_Exclude_level2Users . ',' . $MOM_Exclude_level7Users;
		$loggedOutCats  = $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		$loggedOutTags  = $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
	}
	if( 4 == $myoptionalmodules_plugin->user_level ) {
		$loggedOutUsers = $MOM_Exclude_level7Users;				
		$loggedOutCats  = $MOM_Exclude_level7Categories;
		$loggedOutTags  = $MOM_Exclude_level7Tags;
	}
	
	$hideLoggedOutUsers = explode ( ',', str_replace ( ' ', '', $u_1 ) );
	$hideLoggedOutCats  = explode ( ',', str_replace ( ' ', '', $c_1 ) );
	$hideLoggedOutTags  = explode ( ',', str_replace ( ' ', '', $t11 ) );
	$lu1                = array_unique ( explode ( ',', $loggedOutUsers ) );
	foreach( $lu1 as &$LU1 ) { $LU1 = $LU1 . ','; }
	$lu_1               = rtrim ( implode ( $lu1 ), ',' );
	$hideLoggedOutUsers = explode ( ',', str_replace ( ' ', '', $loggedOutUsers ) );
	$lc1                = array_unique ( explode ( ',', $loggedOutCats ) );
	foreach( $lc1 as &$LC1 ) { $LC1 = $LC1 . ','; }
	$lc_1               = rtrim ( implode ( $lc1 ), ',' );
	$hideLoggedOutCats  = explode ( ',', str_replace ( ' ', '', $loggedOutCats ) );
	$lt1                = array_unique ( explode ( ',', $loggedOutTags ) );
	foreach( $lt1 as &$LT1 ) { $LT1 = $LT1 .','; }
	$lt11               = rtrim ( implode ( $lt1 ), ',' );
	$hideLoggedOutTags  = explode ( ',', str_replace ( ' ', '', $lt11 ) );
}

/**
 * Piece all arrays together properly to be utilized for the loop
 */
if( $query->is_feed ) {
	$u1              = explode( ',', $MOM_Exclude_Users_RSS );
	$c1              = explode( ',', $MOM_Exclude_Categories_RSS );
	$formats_to_hide = $MOM_Exclude_PostFormats_RSS;
	$t1              = explode( ',', $MOM_Exclude_Tags_RSS );
}
if( $query->is_home ) {
	$u1              = explode( ',', $MOM_Exclude_Users_Front );
	$c1              = explode( ',', $MOM_Exclude_Categories_Front );
	$formats_to_hide = $MOM_Exclude_PostFormats_Front;
	$t1              = explode( ',', $MOM_Exclude_Tags_Front );
}
if( $query->is_category ) {
	$u1              = explode( ',', $myoptionalmodules_exclude_userscategoryarchives );
	$t1              = explode( ',', $MOM_Exclude_Tags_CategoryArchives );
	$formats_to_hide = $MOM_Exclude_PostFormats_CategoryArchives;
}
if( $query->is_tag ) {
	$u1              = explode( ',', $MOM_Exclude_Users_TagArchives );
	$c1              = explode( ',', $MOM_Exclude_Categories_TagArchives );
	$formats_to_hide = $MOM_Exclude_PostFormats_TagArchives;
}
if( $query->is_search ) {
	$u1              = explode( ',', $myoptionalmodules_exclude_userssearchresults );
	$c1              = explode( ',', $MOM_Exclude_Categories_SearchResults );
	$formats_to_hide = $MOM_Exclude_PostFormats_SearchResults;
	$t1              = explode( ',', $MOM_Exclude_Tags_SearchResults );

}
foreach( $c1 as &$C1 ) { 
	$C1 = $C1 . ','; 
}
$c_1               = rtrim ( implode ( $c1 ), ',' );
$hideUserCats      = explode ( ',', str_replace ( ' ', '', $c_1 ) );
foreach( $u1 as &$U1 ) { 
	$U1 = $U1 . ','; 
}
$u_1               = rtrim ( implode ( $u1 ), ',' );
$hideUserUsers      = explode ( ',', str_replace ( ' ', '', $u_1 ) );		
foreach( $t1 as &$T1 ) { 
	$T1 = $T1 . ','; 
}
$t11                = rtrim( implode ( $t1 ), ',' );
$hideUserTags       = explode( ',', str_replace ( ' ', '', $t11 ) );
$users_to_hide      = array_merge( ( array ) $hideUserUsers, ( array ) $hideLoggedOutUsers, ( array ) $rssday_user );
$categories_to_hide = array_merge( ( array ) $hideUserCats, ( array ) $hideLoggedOutCats, ( array ) $rssday_cat );
$tags_to_hide       = array_merge( ( array ) $hideUserTags, ( array ) $hideLoggedOutTags, ( array ) $rssday );
$users_to_hide      = array_filter( array_unique ( $users_to_hide ) );
$categories_to_hide = array_filter( array_unique ( $categories_to_hide ) );
$tags_to_hide       = array_filter( array_unique ( $tags_to_hide ) );	

/**
 * Loop alteration magic
 */
if( $query->is_main_query() ) {
	if( $query->is_feed || $query->is_home || $query->is_search || $query->is_tag || $query->is_category ) {
		$tax_query = array (
			'ignore_sticky_posts' => true,
			'post_type'           => 'any',
			array (
				'taxonomy'        => 'category',
				'terms'           => $categories_to_hide,
				'field'           => 'id',
				'operator'        => 'NOT IN'
			),
			array (
				'taxonomy'        => 'post_tag',
				'terms'           => $tags_to_hide,
				'field'           => 'id',
				'operator'        => 'NOT IN'
			),
			array (
				'taxonomy'        => 'post_format',
				'field'           => 'slug',
				'terms'           => array($formats_to_hide),
				'operator'        => 'NOT IN'
			)
		);
		$query->set( 'tax_query', $tax_query );
		$query->set( 'author__not_in', $users_to_hide );
	}
}

/**
 * Exclusion rules based on user levels will determine if these posts 
 * can be viewed in is_single() or not.
 */
$chck_users = str_replace( ',', '', $loggedOutUsers );
$chck_cats  = str_replace( ',', '', $loggedOutCats );
$chck_tags  = str_replace( ',', '', $loggedOutTags );

if( $chck_users || $chck_cats || $chck_tags ) {
	add_filter( 'the_content', 'myoptionalmodules_destroy_content_view', 20 );
	if( !function_exists( 'myoptionalmodules_destroy_content_view' ) ) {
		function myoptionalmodules_destroy_content_view( $content ) {
			if( is_single() ) {
				$content = '<div class="mom-unauthorized-content">You do not have permission to view this content.</div>';
			}
			return $content;
		}
	}
}

$c1      = null;
$t1      = null;
$rss_day = null;
$u1      = null;
$t11     = null;
$c_1     = null;
$u_1     = null;
$MOM_Exclude_Categories_Front             = null;
$MOM_Exclude_Categories_TagArchives       = null;
$MOM_Exclude_Categories_SearchResults     = null;
$MOM_Exclude_Categories_RSS               = null;
$MOM_Exclude_Tags_Front                   = null;
$MOM_Exclude_Tags_RSS                     = null;
$MOM_Exclude_Tags_CategoryArchives        = null;
$MOM_Exclude_Tags_SearchResults           = null;
$MOM_Exclude_PostFormats_Front            = null;
$MOM_Exclude_PostFormats_CategoryArchives = null;
$MOM_Exclude_PostFormats_TagArchives      = null;
$MOM_Exclude_PostFormats_SearchResults    = null;
$MOM_Exclude_PostFormats_Visitor          = null;
$MOM_Exclude_PostFormats_RSS              = null;
$MOM_Exclude_Tags_Day                     = null;
$MOM_Exclude_Cats_Day                     = null;
$MOM_Exclude_Users_RSS                    = null;
$MOM_Exclude_Users_Front                  = null;
$MOM_Exclude_Users_TagArchives            = null;
$myoptionalmodules_exclude_userscategoryarchives       = null;
$myoptionalmodules_exclude_userssearchresults          = null;
$MOM_Exclude_Users_Day                    = null;
$chck_users                               = null; 
$chck_cats                                = null;
$loggedOutUsers                           = null;
$loggedOutCats                            = null;
$loggedOutTags                            = null;