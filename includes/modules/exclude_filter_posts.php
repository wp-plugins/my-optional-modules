<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

function mom_exclude_filter_posts($query){
	$c1	  = array ( '0' );
	$lt_1 = array ( '0' );
	$t1	  = array ( '0' );
	$t_1  = array ( '0' );
	$c_1  = '0';
	
	if ( !get_option ( 'MOM_Exclude_Categories_Front' ) )             { $MOM_Exclude_Categories_Front             = '0'; } else { $MOM_Exclude_Categories_Front            = get_option ( 'MOM_Exclude_Categories_Front' ); }
	if ( !get_option ( 'MOM_Exclude_Categories_TagArchives' ) )       { $MOM_Exclude_Categories_TagArchives       = '0'; } else { $MOM_Exclude_Categories_TagArchives      = get_option ( 'MOM_Exclude_Categories_TagArchives' ); }
	if ( !get_option ( 'MOM_Exclude_Categories_SearchResults' ) )     { $MOM_Exclude_Categories_SearchResults     = '0'; } else { $MOM_Exclude_Categories_SearchResults    = get_option ( 'MOM_Exclude_Categories_SearchResults' ); }
	if ( !get_option ( 'MOM_Exclude_Categories_RSS' ) )               { $MOM_Exclude_Categories_RSS               = '0'; } else { $MOM_Exclude_Categories_RSS              = get_option ( 'MOM_Exclude_Categories_RSS' ); }
	if ( !get_option ( 'MOM_Exclude_Tags_RSS' ) )                     { $MOM_Exclude_Tags_RSS                     = '0'; } else { $MOM_Exclude_Tags_RSS                    = get_option ( 'MOM_Exclude_Tags_RSS' ); }
	if ( !get_option ( 'MOM_Exclude_Tags_Front' ) )                   { $MOM_Exclude_Tags_Front                   = '0'; } else { $MOM_Exclude_Tags_Front                  = get_option ( 'MOM_Exclude_Tags_Front' ); }
	if ( !get_option ( 'MOM_Exclude_Tags_CategoryArchives' ) )        { $MOM_Exclude_Tags_CategoryArchives        = '0'; } else { $MOM_Exclude_Tags_CategoryArchives       = get_option ( 'MOM_Exclude_Tags_CategoryArchives' ); }
	if ( !get_option ( 'MOM_Exclude_Tags_SearchResults' ) )           { $MOM_Exclude_Tags_SearchResults           = '0'; } else { $MOM_Exclude_Tags_SearchResults          = get_option ( 'MOM_Exclude_Tags_SearchResults' ); }
	if ( !get_option ( 'MOM_Exclude_PostFormats_Front' ) )            { $MOM_Exclude_PostFormats_Front            = ''; } else { $MOM_Exclude_PostFormats_Front            = get_option ( 'MOM_Exclude_PostFormats_Front' ); }
	if ( !get_option ( 'MOM_Exclude_PostFormats_CategoryArchives' ) ) { $MOM_Exclude_PostFormats_CategoryArchives = ''; } else { $MOM_Exclude_PostFormats_CategoryArchives = get_option ( 'MOM_Exclude_PostFormats_CategoryArchives' ); }
	if ( !get_option ( 'MOM_Exclude_PostFormats_TagArchives' ) )      { $MOM_Exclude_PostFormats_TagArchives      = ''; } else { $MOM_Exclude_PostFormats_TagArchives      = get_option ( 'MOM_Exclude_PostFormats_TagArchives' ); }
	if ( !get_option ( 'MOM_Exclude_PostFormats_SearchResults' ) )    { $MOM_Exclude_PostFormats_SearchResults    = ''; } else { $MOM_Exclude_PostFormats_SearchResults    = get_option ( 'MOM_Exclude_PostFormats_SearchResults' ); }
	if ( !get_option ( 'MOM_Exclude_PostFormats_Visitor' ) )          { $MOM_Exclude_PostFormats_Visitor          = ''; } else { $MOM_Exclude_PostFormats_Visitor          = get_option ( 'MOM_Exclude_PostFormats_Visitor' ); }
	if ( !get_option ( 'MOM_Exclude_PostFormats_RSS' ) )              { $MOM_Exclude_PostFormats_RSS              = ''; } else { $MOM_Exclude_PostFormats_RSS              = get_option ( 'MOM_Exclude_PostFormats_RSS' ); }
	if ( !get_option ( 'MOM_Exclude_Cats_Day' ) )                     { $MOM_Exclude_Cats_Day                     = '0'; }
	if ( !get_option ( 'MOM_Exclude_Tags_Day' ) )                     { $MOM_Exclude_Tags_Day                     = '0'; }
	if ( date ( 'D' ) === 'Sun' )                                     { $MOM_Exclude_Tags_Day                     = get_option ( 'MOM_Exclude_TagsSun' ); }
	if ( date ( 'D' ) === 'Mon' )                                     { $MOM_Exclude_Tags_Day                     = get_option ( 'MOM_Exclude_TagsMon' ); }
	if ( date ( 'D' ) === 'Tue' )                                     { $MOM_Exclude_Tags_Day                     = get_option ( 'MOM_Exclude_TagsTue' ); }
	if ( date ( 'D' ) === 'Wed' )                                     { $MOM_Exclude_Tags_Day                     = get_option ( 'MOM_Exclude_TagsWed' ); }
	if ( date ( 'D' ) === 'Thu' )                                     { $MOM_Exclude_Tags_Day                     = get_option ( 'MOM_Exclude_TagsThu' ); }
	if ( date ( 'D' ) === 'Fri' )                                     { $MOM_Exclude_Tags_Day                     = get_option ( 'MOM_Exclude_TagsFri' ); }
	if ( date ( 'D' ) === 'Sat' )                                     { $MOM_Exclude_Tags_Day                     = get_option ( 'MOM_Exclude_TagsSun' ); }
	if ( date ( 'D' ) === 'Sun' )                                     { $MOM_Exclude_Cats_Day                     = get_option ( 'MOM_Exclude_CategoriesSun' ); }
	if ( date ( 'D' ) === 'Mon' )                                     { $MOM_Exclude_Cats_Day                     = get_option ( 'MOM_Exclude_CategoriesMon' ); }
	if ( date ( 'D' ) === 'Tue' )                                     { $MOM_Exclude_Cats_Day                     = get_option ( 'MOM_Exclude_CategoriesTue' ); }
	if ( date ( 'D' ) === 'Wed' )                                     { $MOM_Exclude_Cats_Day                     = get_option ( 'MOM_Exclude_CategoriesWed' ); }
	if ( date ( 'D' ) === 'Thu' )                                     { $MOM_Exclude_Cats_Day                     = get_option ( 'MOM_Exclude_CategoriesThu' ); }
	if ( date ( 'D' ) === 'Fri' )                                     { $MOM_Exclude_Cats_Day                     = get_option ( 'MOM_Exclude_CategoriesFri' ); }
	if ( date ( 'D' ) === 'Sat' )                                     { $MOM_Exclude_Cats_Day                     = get_option ( 'MOM_Exclude_CategoriesSat' ); }
	
	$rss_day       = explode (',', $MOM_Exclude_Tags_Day );
	foreach ( $rss_day as &$rss_day_1 ) { $rss_day_1 = '' . $rss_day_1 . ','; }
	$rss_day_1     = implode ( $rss_day );
	$rssday        = explode ( ',', str_replace (' ', '', $rss_day_1 ) );
	$rss_day_cat   = explode ( ',', $MOM_Exclude_Cats_Day );
	if ( is_array ( $rss_day_cat ) ) { foreach ( $rss_day_cat as &$rss_day_1_cat ) { $rss_day_1_cat = '' . $rss_day_1_cat . ','; } }
	$rss_day_1_cat = implode ( $rss_day_cat );
	$rssday_cat    = explode ( ',', str_replace ( ' ', '', $rss_day_1_cat ) );
	
	if ( !is_user_logged_in() ) {
		$loggedOutCats = '0';
		$loggedOutTags = '0';
		
		$MOM_Exclude_VisitorCategories = '';
		$MOM_Exclude_level0Categories  = '';
		$MOM_Exclude_level1Categories  = '';
		$MOM_Exclude_level2Categories  = '';
		$MOM_Exclude_level7Categories  = '';
		$MOM_Exclude_VisitorTags       = '';
		$MOM_Exclude_level0Tags        = '';
		$MOM_Exclude_level1Tags        = '';
		$MOM_Exclude_level2Tags        = '';
		$MOM_Exclude_level7Tags        = '';
		
		if ( get_option ( 'MOM_Exclude_VisitorCategories') ) { $MOM_Exclude_VisitorCategories = get_option ( 'MOM_Exclude_VisitorCategories' ); } else { $MOM_Exclude_VisitorCategories = '0'; }
		if ( get_option ( 'MOM_Exclude_level0Categories') )  { $MOM_Exclude_level0Categories  = get_option ( 'MOM_Exclude_level0Categories' );  } else { $MOM_Exclude_level0Categories  = '0'; }
		if ( get_option ( 'MOM_Exclude_level1Categories') )  { $MOM_Exclude_level1Categories  = get_option ( 'MOM_Exclude_level1Categories' );  } else { $MOM_Exclude_level1Categories  = '0'; }
		if ( get_option ( 'MOM_Exclude_level2Categories') )  { $MOM_Exclude_level2Categories  = get_option ( 'MOM_Exclude_level2Categories' );  } else { $MOM_Exclude_level2Categories  = '0'; }
		if ( get_option ( 'MOM_Exclude_level7Categories') )  { $MOM_Exclude_level7Categories  = get_option ( 'MOM_Exclude_level7Categories' );  } else { $MOM_Exclude_level7Categories  = '0'; }
		if ( get_option ( 'MOM_Exclude_VisitorTags') )       { $MOM_Exclude_VisitorTags       = get_option ( 'MOM_Exclude_VisitorTags' );       } else { $MOM_Exclude_VisitorTags       = '0'; }
		if ( get_option ( 'MOM_Exclude_level0Tags') )        { $MOM_Exclude_level0Tags        = get_option ( 'MOM_Exclude_level0Tags' );        } else { $MOM_Exclude_level0Tags        = '0'; }
		if ( get_option ( 'MOM_Exclude_level1Tags') )        { $MOM_Exclude_level1Tags        = get_option ( 'MOM_Exclude_level1Tags' );        } else { $MOM_Exclude_level1Tags        = '0'; }
		if ( get_option ( 'MOM_Exclude_level2Tags') )        { $MOM_Exclude_level2Tags        = get_option ( 'MOM_Exclude_level2Tags' );        } else { $MOM_Exclude_level2Tags        = '0'; }
		
		$loggedOutCats     = $MOM_Exclude_VisitorCategories . ',' . $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		$loggedOutTags     = $MOM_Exclude_VisitorTags . ',' . $MOM_Exclude_level0Tags . ',' . $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
		$lc1               = array_unique ( explode ( ',', $loggedOutCats ) );
		foreach ( $lc1 as &$LC1 ) { $LC1 = '' . $LC1 . ','; }
		$lc_1              = rtrim ( implode ( $lc1 ), ',' );
		$hideLoggedOutCats = explode ( ',', str_replace ( ' ', '', $loggedOutCats ) );
		$lt1               = array_unique ( explode ( ',', $loggedOutTags ) );
		foreach ( $lt1 as &$LT1 ) { $LT1 = '' . $LT1 . ','; }
		$lt11              = rtrim ( implode ( $lt1 ), ',' );
		$hideLoggedOutTags = explode ( ',', str_replace ( ' ', '', $lt11 ) );
		$hidePostFormats   = $MOM_Exclude_PostFormats_Visitor;
		
	} else {
		get_currentuserinfo();
		global $user_level;
		$loggedOutCats = '0';
		$loggedOutTags = '0';
		if ( get_option ( 'MOM_Exclude_VisitorCategories') )     { $MOM_Exclude_VisitorCategories = get_option ( 'MOM_Exclude_VisitorCategories' ); } else { $MOM_Exclude_VisitorCategories = '0'; }
		if ( get_option ( 'MOM_Exclude_level0Categories') )      { $MOM_Exclude_level0Categories  = get_option ( 'MOM_Exclude_level0Categories' );  } else { $MOM_Exclude_level0Categories  = '0'; }
		if ( get_option ( 'MOM_Exclude_level1Categories') )      { $MOM_Exclude_level1Categories  = get_option ( 'MOM_Exclude_level1Categories' );  } else { $MOM_Exclude_level1Categories  = '0'; }
		if ( get_option ( 'MOM_Exclude_level2Categories') )      { $MOM_Exclude_level2Categories  = get_option ( 'MOM_Exclude_level2Categories' );  } else { $MOM_Exclude_level2Categories  = '0'; }
		if ( get_option ( 'MOM_Exclude_level7Categories') )      { $MOM_Exclude_level7Categories  = get_option ( 'MOM_Exclude_level7Categories' );  } else { $MOM_Exclude_level7Categories  = '0'; }		
		if ( get_option ( 'MOM_Exclude_VisitorTags') )           { $MOM_Exclude_VisitorTags       = get_option ( 'MOM_Exclude_VisitorTags' );       } else { $MOM_Exclude_VisitorTags       = '0'; }
		if ( get_option ( 'MOM_Exclude_level0Tags') )            { $MOM_Exclude_level0Tags        = get_option ( 'MOM_Exclude_level0Tags' );        } else { $MOM_Exclude_level0Tags        = '0'; }
		if ( get_option ( 'MOM_Exclude_level1Tags') )            { $MOM_Exclude_level1Tags        = get_option ( 'MOM_Exclude_level1Tags' );        } else { $MOM_Exclude_level1Tags        = '0'; }
		if ( get_option ( 'MOM_Exclude_level2Tags') )            { $MOM_Exclude_level2Tags        = get_option ( 'MOM_Exclude_level2Tags' );        } else { $MOM_Exclude_level2Tags        = '0'; }
		if ( get_option ( 'MOM_Exclude_level7Categories') != '' ){$MOM_Exclude_level7Categories   = get_option( 'MOM_Exclude_level7Categories' );   } else { $MOM_Exclude_level7Categories  = '0'; }
		
		if ( $user_level       == 0 ) { $loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories; 
		} elseif ( $user_level == 1 ) { $loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		} elseif ( $user_level == 2 ) { $loggedOutCats = $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		} elseif ( $user_level == 7 ) { $loggedOutCats = $MOM_Exclude_level7Categories; }
		
		if ( $user_level      == 0 ) { $loggedOutTags = $MOM_Exclude_level0Tags . ',' . $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
		} elseif( $user_level == 1 ) { $loggedOutTags = $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
		} elseif( $user_level == 2 ) { $loggedOutTags = $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
		} elseif( $user_level == 7 ) { $loggedOutTags = $MOM_Exclude_level7Tags; }
		
		$hideLoggedOutCats = explode ( ',', str_replace (' ', '', $c_1 ) );
		$hideLoggedOutTags = explode ( ',', str_replace (' ', '', $t11 ) );
		$lc1               = array_unique ( explode ( ',', $loggedOutCats ) );
		foreach ( $lc1 as &$LC1 ) { $LC1 = '' . $LC1 . ','; }
		$lc_1              = rtrim ( implode ( $lc1 ), ',' );
		$hideLoggedOutCats = explode (',', str_replace ( ' ', '', $loggedOutCats ) );
		$lt1               = array_unique ( explode (',', $loggedOutTags ) );
		foreach ( $lt1 as &$LT1 ) { $LT1 = '' . $LT1 .','; }
		$lt11              = rtrim ( implode ( $lt1 ), ',' );
		$hideLoggedOutTags = explode ( ',', str_replace (' ', '', $lt11 ) );
	}
	
	if ( $query->is_feed )     { $c1 = explode (',', $MOM_Exclude_Categories_RSS ); $hidePostFormats           = $MOM_Exclude_PostFormats_RSS; $t1           = explode ( ',', $MOM_Exclude_Tags_RSS ); }
	if ( $query->is_home )     { $c1 = explode (',', $MOM_Exclude_Categories_Front ); $hidePostFormats         = $MOM_Exclude_PostFormats_Front; $t1         = explode ( ',', $MOM_Exclude_Tags_Front ); }
	if ( $query->is_category ) { $t1 = explode (',', $MOM_Exclude_Tags_CategoryArchives ); $hidePostFormats    = $MOM_Exclude_PostFormats_CategoryArchives; }
	if ( $query->is_tag )      { $c1 = explode (',', $MOM_Exclude_Categories_TagArchives ); $hidePostFormats   = $MOM_Exclude_PostFormats_TagArchives; }
	if ( $query->is_search )   { $c1 = explode (',', $MOM_Exclude_Categories_SearchResults ); $hidePostFormats = $MOM_Exclude_PostFormats_SearchResults; $t1 = explode ( ',',$MOM_Exclude_Tags_SearchResults ); }
	
	foreach ( $c1 as &$C1 ) { $C1 = '' . $C1 . ','; }
	$c_1               = rtrim ( implode ( $c1 ), ',' );
	$hideUserCats      = explode (',', str_replace (' ', '', $c_1 ) );
	foreach ( $t1 as &$T1 ) { $T1 = '' . $T1 . ','; }
	$t11               = rtrim ( implode ( $t1 ), ',' );
	$hideUserTags      = explode ( ',', str_replace ( ' ', '', $t11 ) );
	$hideAllCategories = array_merge ( ( array ) $hideUserCats, ( array ) $hideLoggedOutCats, ( array ) $rssday_cat );
	$hideAllTags       = array_merge ( ( array ) $hideUserTags, ( array ) $hideLoggedOutTags, ( array ) $rssday );
	$hideAllCategories = array_filter ( array_unique ( $hideAllCategories ) );
	$hideAllTags       = array_filter ( array_unique ( $hideAllTags ) );	
	
	if ( $query->is_feed || $query->is_home || $query->is_search || $query->is_tag || $query->is_category ) {
		$tax_query = array (
			'ignore_sticky_posts' => true,
			'post_type' => 'any',
			array (
				'taxonomy' => 'category',
				'terms' => $hideAllCategories,
				'field' => 'id',
				'operator' => 'NOT IN'
			),
			array (
				'taxonomy' => 'post_tag',
				'terms' => $hideAllTags,
				'field' => 'id',
				'operator' => 'NOT IN'
			),
			array (
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array($hidePostFormats),
				'operator' => 'NOT IN'
			)
		);
		$query->set ( 'tax_query', $tax_query );
	}
}