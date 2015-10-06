<?php 
/**
 * FUNCTION(ality) Exclude Posts
 *
 * File last update: 10.2
 *
 * Alter the query to remove posts based on many parameters
 */ 

defined('MyOptionalModules') or exit;

global $myoptionalmodules_plugin;

$myoptionalmodules_exclude_categoriesfront = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriesfront' ) );
$myoptionalmodules_exclude_categoriestagarchives = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriestagarchives' ) );
$myoptionalmodules_exclude_categoriessearchresults = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriessearchresults' ) );
$myoptionalmodules_exclude_categoriesrss = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriesrss' ) );
$myoptionalmodules_exclude_tagsfront = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagsfront' ) );
$myoptionalmodules_exclude_tagsrss = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagsrss' ) );
$myoptionalmodules_exclude_tagscategoryarchives = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagscategoryarchives' ) );
$myoptionalmodules_exclude_tagssearchresults = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagssearchresults' ) );
$myoptionalmodules_exclude_postformatsfront = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_postformatsfront' ) );
$myoptionalmodules_exclude_postformatscategoryarchives = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_postformatscategoryarchives' ) );
$myoptionalmodules_exclude_postformatstagarchives = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_postformatstagarchives' ) );
$myoptionalmodules_exclude_postformatssearchresults = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_postformatssearchresults' ) );
$myoptionalmodules_exclude_visitorpostformats = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_visitorpostformats' ) );
$myoptionalmodules_exclude_postformatsrss = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_postformatsrss' ) );
$myoptionalmodules_exclude_usersrss = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersrss' ) );
$myoptionalmodules_exclude_usersfront = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersfront' ) );
$myoptionalmodules_exclude_userstagarchives = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_userstagarchives' ) );
$myoptionalmodules_exclude_userscategoryarchives = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_userscategoryarchives' ) );
$myoptionalmodules_exclude_userssearchresults = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_userssearchresults' ) );
$myoptionalmodules_exclude_userslevel10users = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_userslevel10users' ) );
$myoptionalmodules_exclude_userslevel1users = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_userslevel1users' ) );
$myoptionalmodules_exclude_userslevel2users = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_userslevel2users' ) );
$myoptionalmodules_exclude_userslevel7users = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_userslevel7users' ) );
$myoptionalmodules_exclude_categories_level0categories = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categories_level0categories' ) );
$myoptionalmodules_exclude_categorieslevel1categories = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categorieslevel1categories' ) );
$myoptionalmodules_exclude_categorieslevel2categories = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categorieslevel2categories' ) );
$myoptionalmodules_exclude_categorieslevel7categories = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categorieslevel7categories' ) );
$myoptionalmodules_exclude_tagslevel0tags = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagslevel0tags' ) );
$myoptionalmodules_exclude_tagslevel1tags = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagslevel1tags' ) );
$myoptionalmodules_exclude_tagslevel2tags = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagslevel2tags' ) );
$myoptionalmodules_exclude_tagslevel7tags = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagslevel7tags' ) );
$myoptionalmodules_exclude_tagstagssun = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagstagssun' ) );
$myoptionalmodules_exclude_tagstagsmon = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagstagsmon' ) );
$myoptionalmodules_exclude_tagstagstue = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagstagstue' ) );
$myoptionalmodules_exclude_tagstagswed = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagstagswed' ) );
$myoptionalmodules_exclude_tagstagsthu = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagstagsthu' ) );
$myoptionalmodules_exclude_tagstagsfri = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagstagsfri' ) );
$myoptionalmodules_exclude_tagstagssat = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_tagstagssat' ) );
$myoptionalmodules_exclude_categoriescategoriessun = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriescategoriessun' ) );
$myoptionalmodules_exclude_categoriescategoriesmon = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriescategoriesmon' ) );
$myoptionalmodules_exclude_categoriescategoriestue = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriescategoriestue' ) );
$myoptionalmodules_exclude_categoriescategorieswed = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriescategorieswed' ) );
$myoptionalmodules_exclude_categoriescategoriesthu = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriescategoriesthu' ) );
$myoptionalmodules_exclude_categoriescategoriesfri = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriescategoriesfri' ) );
$myoptionalmodules_exclude_categoriescategoriessat = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_categoriescategoriessat' ) );
$myoptionalmodules_exclude_usersuserssun = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersuserssun' ) );
$myoptionalmodules_exclude_usersusersmon = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersusersmon' ) );
$myoptionalmodules_exclude_usersuserstue = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersuserstue' ) );
$myoptionalmodules_exclude_usersuserswed = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersuserswed' ) );
$myoptionalmodules_exclude_usersusersthu = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersusersthu' ) );
$myoptionalmodules_exclude_usersusersfri = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersusersfri' ) );
$myoptionalmodules_exclude_usersuserssat = sanitize_text_field ( get_option ( 'myoptionalmodules_exclude_usersuserssat' ) );
$date_day = strtolower( date( 'D' ) );

/**
 * Set default variables
 * Set them (initially) to nothing
 * Then, grab the value from the database and reset them
 */

$chck_users = $chck_cats = $chck_tags = $t11 = $c_1 = $u_1 = null;
 
$c1 = $t1 = $rss_day = 
$u1 = array ( '0' );

if( $date_day == 'sun' ):
	$MOM_Exclude_Tags_Day  = $myoptionalmodules_exclude_tagstagssun;
	$MOM_Exclude_Cats_Day  = $myoptionalmodules_exclude_categoriescategoriessun;
	$MOM_Exclude_Users_Day = $myoptionalmodules_exclude_usersuserssun;
elseif( $date_day == 'mon' ):
	$MOM_Exclude_Tags_Day  = $myoptionalmodules_exclude_tagstagsmon;
	$MOM_Exclude_Cats_Day  = $myoptionalmodules_exclude_categoriescategoriesmon;
	$MOM_Exclude_Users_Day = $myoptionalmodules_exclude_usersusersmon;
elseif( $date_day == 'tue' ):
	$MOM_Exclude_Tags_Day  = $myoptionalmodules_exclude_tagstagstue;
	$MOM_Exclude_Cats_Day  = $myoptionalmodules_exclude_categoriescategoriestue;
	$MOM_Exclude_Users_Day = $myoptionalmodules_exclude_usersuserstue;
elseif( $date_day == 'wed' ):
	$MOM_Exclude_Tags_Day  = $myoptionalmodules_exclude_tagstagswed;
	$MOM_Exclude_Cats_Day  = $myoptionalmodules_exclude_categoriescategorieswed;
	$MOM_Exclude_Users_Day = $myoptionalmodules_exclude_usersuserswed;
elseif( $date_day == 'thu' ):
	$MOM_Exclude_Tags_Day  = $myoptionalmodules_exclude_tagstagsthu;
	$MOM_Exclude_Cats_Day  = $myoptionalmodules_exclude_categoriescategoriesthu;
	$MOM_Exclude_Users_Day = $myoptionalmodules_exclude_usersusersthu;
elseif( $date_day == 'fri' ):
	$MOM_Exclude_Tags_Day  = $myoptionalmodules_exclude_tagstagsfri;
	$MOM_Exclude_Cats_Day  = $myoptionalmodules_exclude_categoriescategoriesfri;
	$MOM_Exclude_Users_Day = $myoptionalmodules_exclude_usersusersfri;
elseif( $date_day == 'sat' ):
	$MOM_Exclude_Tags_Day  = $myoptionalmodules_exclude_tagstagssat;
	$MOM_Exclude_Cats_Day  = $myoptionalmodules_exclude_categoriescategoriessat;
	$MOM_Exclude_Users_Day = $myoptionalmodules_exclude_usersuserssat;
endif;

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
if ( 0 == $myoptionalmodules_plugin->user_level ):
	$loggedOutUsers = "{$myoptionalmodules_exclude_userslevel10users},{$myoptionalmodules_exclude_userslevel1users},{$myoptionalmodules_exclude_userslevel2users},{$myoptionalmodules_exclude_userslevel7users}";
	$loggedOutCats  = "{$myoptionalmodules_exclude_categories_level0categories},{$myoptionalmodules_exclude_categorieslevel1categories},{$myoptionalmodules_exclude_categorieslevel2categories},{$myoptionalmodules_exclude_categorieslevel7categories}";
	$loggedOutTags  = "{$myoptionalmodules_exclude_tagslevel0tags},{$myoptionalmodules_exclude_tagslevel1tags},{$myoptionalmodules_exclude_tagslevel2tags},{$myoptionalmodules_exclude_tagslevel7tags}";
	$lu1 = array_unique ( explode ( ',' , $loggedOutUsers ) );
	foreach ( $lu1 as &$LU1 ) { 
		$LU1 = $LU1 . ','; 
	}
	$lu_1 = rtrim ( implode ( $lu1 ) , ',' );				
	$hideLoggedOutUsers = explode ( ',' , str_replace ( ' ' , '' , $loggedOutUsers ) );
	$lc1 = array_unique ( explode( ',' , $loggedOutCats ) );
	foreach ( $lc1 as &$LC1 ) { 
		$LC1 = $LC1 . ','; 
	}
	$lc_1 = rtrim ( implode( $lc1 ) , ',' );
	$hideLoggedOutCats = explode ( ',' , str_replace ( ' ' , '' , $loggedOutCats ) );
	$lt1 = array_unique ( explode ( ',' , $loggedOutTags ) );
	foreach ( $lt1 as &$LT1 ) { 
		$LT1 = $LT1 . ','; 
	}
	$lt11 = rtrim ( implode ( $lt1 ) , ',' );
	$hideLoggedOutTags = explode ( ',' , str_replace ( ' ' , '' , $lt11 ) );
	$formats_to_hide   = $myoptionalmodules_exclude_visitorpostformats;
else:
	if ( 1 == $myoptionalmodules_plugin->user_level ):
		$loggedOutUsers = "{$myoptionalmodules_exclude_userslevel1users},{$myoptionalmodules_exclude_userslevel2users},{$myoptionalmodules_exclude_userslevel7users}";
		$loggedOutCats  = "{$myoptionalmodules_exclude_categorieslevel1categories},{$myoptionalmodules_exclude_categorieslevel2categories},{$myoptionalmodules_exclude_categorieslevel7categories}";
		$loggedOutTags  = "{$myoptionalmodules_exclude_tagslevel1tags},{$myoptionalmodules_exclude_tagslevel2tags},{$myoptionalmodules_exclude_tagslevel7tags}";
	elseif ( 2 == $myoptionalmodules_plugin->user_level ):
		$loggedOutUsers = "{$myoptionalmodules_exclude_userslevel1users},{$myoptionalmodules_exclude_userslevel2users},{$myoptionalmodules_exclude_userslevel7users}";
		$loggedOutCats  = "{$myoptionalmodules_exclude_categorieslevel1categories},{$myoptionalmodules_exclude_categorieslevel2categories},{$myoptionalmodules_exclude_categorieslevel7categories}";
		$loggedOutTags  = "{$myoptionalmodules_exclude_tagslevel1tags},{$myoptionalmodules_exclude_tagslevel2tags},{$myoptionalmodules_exclude_tagslevel7tags}";
	elseif ( 3 == $myoptionalmodules_plugin->user_level ):
		$loggedOutUsers = "{$myoptionalmodules_exclude_userslevel2users},{$myoptionalmodules_exclude_userslevel7users}";
		$loggedOutCats  = "{$myoptionalmodules_exclude_categorieslevel2categories},{$myoptionalmodules_exclude_categorieslevel7categories}";
		$loggedOutTags  = "{$myoptionalmodules_exclude_tagslevel2tags},{$myoptionalmodules_exclude_tagslevel7tags}";
	elseif ( 4 == $myoptionalmodules_plugin->user_level ):
		$loggedOutUsers = "{$myoptionalmodules_exclude_userslevel7users}";
		$loggedOutCats  = "{$myoptionalmodules_exclude_categorieslevel7categories}";
		$loggedOutTags  = "{$myoptionalmodules_exclude_tagslevel7tags}";
	else:
		$loggedOutUsers = "{$myoptionalmodules_exclude_userslevel10users},{$myoptionalmodules_exclude_userslevel1users},{$myoptionalmodules_exclude_userslevel2users},{$myoptionalmodules_exclude_userslevel7users}";
		$loggedOutCats  = "{$myoptionalmodules_exclude_categories_level0categories},{$myoptionalmodules_exclude_categorieslevel1categories},{$myoptionalmodules_exclude_categorieslevel2categories},{$myoptionalmodules_exclude_categorieslevel7categories}";
		$loggedOutTags  = "{$myoptionalmodules_exclude_tagslevel0tags},{$myoptionalmodules_exclude_tagslevel1tags},{$myoptionalmodules_exclude_tagslevel2tags},{$myoptionalmodules_exclude_tagslevel7tags}";
	endif;
	
	$hideLoggedOutUsers = explode ( ',' , str_replace ( ' ' , '' , $u_1 ) );
	$hideLoggedOutCats  = explode ( ',' , str_replace ( ' ' , '' , $c_1 ) );
	$hideLoggedOutTags  = explode ( ',' , str_replace ( ' ' , '' , $t11 ) );
	$lu1                = array_unique ( explode ( ',' , $loggedOutUsers ) );
	foreach( $lu1 as &$LU1 ) { $LU1 = $LU1 . ','; }
	$lu_1               = rtrim ( implode ( $lu1 ) , ',' );
	$hideLoggedOutUsers = explode ( ',' , str_replace ( ' ' , '' , $loggedOutUsers ) );
	$lc1                = array_unique ( explode ( ',' , $loggedOutCats ) );
	foreach( $lc1 as &$LC1 ) { $LC1 = $LC1 . ','; }
	$lc_1               = rtrim ( implode ( $lc1 ) , ',' );
	$hideLoggedOutCats  = explode ( ',' , str_replace ( ' ' , '' , $loggedOutCats ) );
	$lt1                = array_unique ( explode ( ',' , $loggedOutTags ) );
	foreach( $lt1 as &$LT1 ) { $LT1 = $LT1 . ','; }
	$lt11               = rtrim ( implode ( $lt1 ) , ',' );
	$hideLoggedOutTags  = explode ( ',' , str_replace ( ' ' , '' , $lt11 ) );
endif;

/**
 * Piece all arrays together properly to be utilized for the loop
 */
if ( $query->is_feed ):
	$u1              = explode ( ',' , $myoptionalmodules_exclude_usersrss );
	$c1              = explode ( ',' , $myoptionalmodules_exclude_categoriesrss );
	$t1              = explode ( ',' , $myoptionalmodules_exclude_tagsrss );
	$formats_to_hide = $myoptionalmodules_exclude_postformatsrss;
elseif ( $query->is_category ):
	$u1              = explode ( ',' , $myoptionalmodules_exclude_userscategoryarchives );
	$t1              = explode ( ',' , $myoptionalmodules_exclude_tagscategoryarchives );
	$formats_to_hide = $myoptionalmodules_exclude_postformatscategoryarchives;
elseif ( $query->is_tag ):
	$u1              = explode ( ',' , $myoptionalmodules_exclude_userstagarchives );
	$c1              = explode ( ',' , $myoptionalmodules_exclude_categoriestagarchives );
	$formats_to_hide = $myoptionalmodules_exclude_postformatstagarchives;
elseif ( $query->is_search ):
	$u1              = explode ( ',' , $myoptionalmodules_exclude_userssearchresults );
	$c1              = explode ( ',' , $myoptionalmodules_exclude_categoriessearchresults );
	$t1              = explode ( ',' , $myoptionalmodules_exclude_tagssearchresults );
	$formats_to_hide = $myoptionalmodules_exclude_postformatssearchresults;
else:
	$u1              = explode ( ',' , $myoptionalmodules_exclude_usersfront );
	$c1              = explode ( ',' , $myoptionalmodules_exclude_categoriesfront );
	$t1              = explode ( ',' , $myoptionalmodules_exclude_tagsfront );
	$formats_to_hide = $myoptionalmodules_exclude_postformatsfront;
endif;

foreach( $c1 as &$C1 ) {
	$C1 = $C1 . ','; 
}
$c_1               = rtrim ( implode ( $c1 ), ',' );
$hideUserCats      = explode ( ',', str_replace ( ' ', '', $c_1 ) );
foreach ( $u1 as &$U1 ) { 
	$U1 = $U1 . ','; 
}
$u_1               = rtrim ( implode ( $u1 ), ',' );
$hideUserUsers      = explode ( ',', str_replace ( ' ', '', $u_1 ) );		
foreach ( $t1 as &$T1 ) { 
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


$users_to_hide      = preg_replace ( '/,+/' , ',' , $users_to_hide );
$categories_to_hide = preg_replace ( '/,+/' , ',' , $categories_to_hide );
$tags_to_hide       = preg_replace ( '/,+/' , ',' , $tags_to_hide );
$loggedOutUsers     = preg_replace ( '/,+/' , ',' , $loggedOutUsers );
$loggedOutCats      = preg_replace ( '/,+/' , ',' , $loggedOutCats );
$loggedOutTags      = preg_replace ( '/,+/' , ',' , $loggedOutTags );


/**
 * Loop alteration magic
 */
if( $query->is_main_query() ) :
	if( $query->is_feed || $query->is_home || $query->is_search || $query->is_tag || $query->is_category ):
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
		$query->set ( 'tax_query' , $tax_query );
		$query->set ( 'author__not_in' , $users_to_hide );
	endif;
endif;

/**
 * Exclusion rules based on user levels will determine if these posts 
 * can be viewed in is_single() or not.
 */
if ( $loggedOutUsers ):
	$chck_users = str_replace ( ',' , ',' , $loggedOutUsers );
endif;
if ( $loggedOutCats ):
	$chck_cats  = str_replace ( ',' , ',' , $loggedOutCats );
endif;
if ( $loggedOutTags ):
	$chck_tags  = str_replace ( ',' , ',' , $loggedOutTags );
endif;

if ( intval ( $chck_users ) || intval ( $chck_cats ) || intval ( $chck_tags ) ):
	add_filter( 'the_content', 'myoptionalmodules_destroy_content_view', 20 );
	if(!function_exists('myoptionalmodules_destroy_content_view')){
		function myoptionalmodules_destroy_content_view( $content ) {
			if( is_single() ):
				$content = '<div class="mom-unauthorized-content">You do not have permission to view this content.</div>';
				return do_shortcode ( $content );
			endif;
		}
	}
endif;