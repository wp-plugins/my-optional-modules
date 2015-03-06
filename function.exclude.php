<?php 
/**
 * function.exclude
 * Exclude posts from the loop based on a set of options
 */ 

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
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
$MOM_Exclude_Users_CategoryArchives       = 0;
$MOM_Exclude_Users_SearchResults          = 0;
$MOM_Exclude_Users_Day                    = 0;
$MOM_Exclude_Categories_Front             = get_option( 'MOM_Exclude_Categories_Front' );
$MOM_Exclude_Categories_TagArchives       = get_option( 'MOM_Exclude_Categories_TagArchives' );
$MOM_Exclude_Categories_SearchResults     = get_option( 'MOM_Exclude_Categories_SearchResults' );
$MOM_Exclude_Categories_RSS               = get_option( 'MOM_Exclude_Categories_RSS' );
$MOM_Exclude_Tags_Front                   = get_option( 'MOM_Exclude_Tags_Front' );
$MOM_Exclude_Tags_RSS                     = get_option( 'MOM_Exclude_Tags_RSS' );
$MOM_Exclude_Tags_CategoryArchives        = get_option( 'MOM_Exclude_Tags_CategoryArchives' );
$MOM_Exclude_Tags_SearchResults           = get_option( 'MOM_Exclude_Tags_SearchResults' );
$MOM_Exclude_PostFormats_Front            = get_option( 'MOM_Exclude_PostFormats_Front' );
$MOM_Exclude_PostFormats_CategoryArchives = get_option( 'MOM_Exclude_PostFormats_CategoryArchives' );
$MOM_Exclude_PostFormats_TagArchives      = get_option( 'MOM_Exclude_PostFormats_TagArchives' );
$MOM_Exclude_PostFormats_SearchResults    = get_option( 'MOM_Exclude_PostFormats_SearchResults' );
$MOM_Exclude_PostFormats_Visitor          = get_option( 'MOM_Exclude_PostFormats_Visitor' );
$MOM_Exclude_PostFormats_RSS              = get_option( 'MOM_Exclude_PostFormats_RSS' );
$MOM_Exclude_Tags_Day                     = get_option( 'MOM_Exclude_Tags_Tags' . $date_day . '' );
$MOM_Exclude_Cats_Day                     = get_option( 'MOM_Exclude_Categories_Categories' . $date_day . '' );
$MOM_Exclude_Users_RSS                    = get_option( 'MOM_Exclude_Users_RSS' );
$MOM_Exclude_Users_Front                  = get_option( 'MOM_Exclude_Users_Front' );
$MOM_Exclude_Users_TagArchives            = get_option( 'MOM_Exclude_Users_TagArchives' );
$MOM_Exclude_Users_CategoryArchives       = get_option( 'MOM_Exclude_Users_CategoryArchives' );
$MOM_Exclude_Users_SearchResults          = get_option( 'MOM_Exclude_Users_SearchResults' );
$MOM_Exclude_Users_Day                    = get_option( 'MOM_Exclude_Users_Users' . $date_day . '' );
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
	$MOM_Exclude_level0Users       = get_option( 'MOM_Exclude_Users_level0Users' ); 
	$MOM_Exclude_level1Users       = get_option( 'MOM_Exclude_Users_level1Users' ); 
	$MOM_Exclude_level2Users       = get_option( 'MOM_Exclude_Users_level2Users' ); 
	$MOM_Exclude_level7Users       = get_option( 'MOM_Exclude_Users_level7Users' ); 
	$MOM_Exclude_level0Categories  = get_option( 'MOM_Exclude_Categories_level0Categories' ); 
	$MOM_Exclude_level1Categories  = get_option( 'MOM_Exclude_Categories_level1Categories' ); 
	$MOM_Exclude_level2Categories  = get_option( 'MOM_Exclude_Categories_level2Categories' ); 
	$MOM_Exclude_level7Categories  = get_option( 'MOM_Exclude_Categories_level7Categories' ); 
	$MOM_Exclude_level0Tags        = get_option( 'MOM_Exclude_Tags_level0Tags' );
	$MOM_Exclude_level1Tags        = get_option( 'MOM_Exclude_Tags_level1Tags' );
	$MOM_Exclude_level2Tags        = get_option( 'MOM_Exclude_Tags_level2Tags' );
	$MOM_Exclude_level7Tags        = get_option( 'MOM_Exclude_Tags_level7Tags' );
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
	$MOM_Exclude_level0Users       = get_option( 'MOM_Exclude_Users_level0Users' ); 
	$MOM_Exclude_level1Users       = get_option( 'MOM_Exclude_Users_level1Users' ); 
	$MOM_Exclude_level2Users       = get_option( 'MOM_Exclude_Users_level2Users' ); 
	$MOM_Exclude_level7Users       = get_option( 'MOM_Exclude_Users_level7Users' );				
	$MOM_Exclude_level0Categories  = get_option( 'MOM_Exclude_Categories_level0Categories' ); 
	$MOM_Exclude_level1Categories  = get_option( 'MOM_Exclude_Categories_level1Categories' ); 
	$MOM_Exclude_level2Categories  = get_option( 'MOM_Exclude_Categories_level2Categories' ); 
	$MOM_Exclude_level7Categories  = get_option( 'MOM_Exclude_Categories_level7Categories' ); 
	$MOM_Exclude_level0Tags        = get_option( 'MOM_Exclude_Tags_level0Tags' ); 
	$MOM_Exclude_level1Tags        = get_option( 'MOM_Exclude_Tags_level1Tags' ); 
	$MOM_Exclude_level2Tags        = get_option( 'MOM_Exclude_Tags_level2Tags' ); 
	$MOM_Exclude_level7Tags        = get_option( 'MOM_Exclude_Tags_level7Tags' );
	if( 0 == $myoptionalmodules_plugin->user_level ) {
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
	$u1              = explode( ',', $MOM_Exclude_Users_CategoryArchives );
	$t1              = explode( ',', $MOM_Exclude_Tags_CategoryArchives );
	$formats_to_hide = $MOM_Exclude_PostFormats_CategoryArchives;
}
if( $query->is_tag ) {
	$u1              = explode( ',', $MOM_Exclude_Users_TagArchives );
	$c1              = explode( ',', $MOM_Exclude_Categories_TagArchives );
	$formats_to_hide = $MOM_Exclude_PostFormats_TagArchives;
}
if( $query->is_search ) {
	$u1              = explode( ',', $MOM_Exclude_Users_SearchResults );
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
	if( $query->is_single ) {
		$query->set( 'author__not_in', $users_to_hide );
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
$MOM_Exclude_Users_CategoryArchives       = null;
$MOM_Exclude_Users_SearchResults          = null;
$MOM_Exclude_Users_Day                    = null;
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
$MOM_Exclude_Users_CategoryArchives       = null;
$MOM_Exclude_Users_SearchResults          = null;
$MOM_Exclude_Users_Day                    = null;