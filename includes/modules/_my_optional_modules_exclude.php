<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

add_action ( 'pre_get_posts', 'mom_exclude_filter_posts' );
function mom_exclude_filter_posts ( $query ) {
	
	$t11  = 0;
	$c1	  = array ( '0' );
	$lt_1 = array ( '0' );
	$t1	  = array ( '0' );
	$t_1  = array ( '0' );
	$c_1  = 0;
	
	if ( !get_option ( 'MOM_Exclude_Categories_Front' ) ) { 
		$MOM_Exclude_Categories_Front = 0; 
	} else { 
		$MOM_Exclude_Categories_Front = get_option ( 'MOM_Exclude_Categories_Front' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Categories_TagArchives' ) ) { 
		$MOM_Exclude_Categories_TagArchives = 0; 
	} else { 
		$MOM_Exclude_Categories_TagArchives = get_option ( 'MOM_Exclude_Categories_TagArchives' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Categories_SearchResults' ) ) { 
		$MOM_Exclude_Categories_SearchResults = 0;
	} else {
		$MOM_Exclude_Categories_SearchResults = get_option ( 'MOM_Exclude_Categories_SearchResults' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Categories_RSS' ) ) { 
		$MOM_Exclude_Categories_RSS = 0; 
	} else {
		$MOM_Exclude_Categories_RSS = get_option ( 'MOM_Exclude_Categories_RSS' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Tags_RSS' ) ) { 
		$MOM_Exclude_Tags_RSS = 0; 
	} else {
		$MOM_Exclude_Tags_RSS = get_option ( 'MOM_Exclude_Tags_RSS' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Tags_Front' ) ) { 
		$MOM_Exclude_Tags_Front = 0; 
	} else {
		$MOM_Exclude_Tags_Front = get_option ( 'MOM_Exclude_Tags_Front' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Tags_CategoryArchives' ) ) { 
		$MOM_Exclude_Tags_CategoryArchives = 0; 
	} else {
		$MOM_Exclude_Tags_CategoryArchives = get_option ( 'MOM_Exclude_Tags_CategoryArchives' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Tags_SearchResults' ) ) { 
		$MOM_Exclude_Tags_SearchResults = 0; 
	} else {
		$MOM_Exclude_Tags_SearchResults = get_option ( 'MOM_Exclude_Tags_SearchResults' ); 
	}
	if ( !get_option ( 'MOM_Exclude_PostFormats_Front' ) ) { 
		$MOM_Exclude_PostFormats_Front = 0; 
	} else {
		$MOM_Exclude_PostFormats_Front = get_option ( 'MOM_Exclude_PostFormats_Front' ); 
	}
	if ( !get_option ( 'MOM_Exclude_PostFormats_CategoryArchives' ) ) { 
		$MOM_Exclude_PostFormats_CategoryArchives = 0; 
	} else {
		$MOM_Exclude_PostFormats_CategoryArchives = get_option ( 'MOM_Exclude_PostFormats_CategoryArchives' ); 
	}
	if ( !get_option ( 'MOM_Exclude_PostFormats_TagArchives' ) ) { 
		$MOM_Exclude_PostFormats_TagArchives = 0; 
	} else {
		$MOM_Exclude_PostFormats_TagArchives = get_option ( 'MOM_Exclude_PostFormats_TagArchives' ); 
	}
	if ( !get_option ( 'MOM_Exclude_PostFormats_SearchResults' ) ) { 
		$MOM_Exclude_PostFormats_SearchResults = 0; 
	} else {
		$MOM_Exclude_PostFormats_SearchResults = get_option ( 'MOM_Exclude_PostFormats_SearchResults' ); 
	}
	if ( !get_option ( 'MOM_Exclude_PostFormats_Visitor' ) ) { 
		$MOM_Exclude_PostFormats_Visitor = 0; 
	} else {
		$MOM_Exclude_PostFormats_Visitor = get_option ( 'MOM_Exclude_PostFormats_Visitor' ); 
	}
	if ( !get_option ( 'MOM_Exclude_PostFormats_RSS' ) ) { 
		$MOM_Exclude_PostFormats_RSS = 0; 
	} else {
		$MOM_Exclude_PostFormats_RSS = get_option ( 'MOM_Exclude_PostFormats_RSS' ); 
	}
	if ( !get_option ( 'MOM_Exclude_Cats_Day' ) ) { 
		$MOM_Exclude_Cats_Day = 0; 
	}
	if ( !get_option ( 'MOM_Exclude_Tags_Day' ) ) { 
		$MOM_Exclude_Tags_Day = 0; 
	}
	if ( date ( 'D' ) === 'Sun' ) {
		$MOM_Exclude_Tags_Day = get_option ( 'MOM_Exclude_TagsSun' ); 
		$MOM_Exclude_Cats_Day = get_option ( 'MOM_Exclude_CategoriesSun' ); 
	}
	if ( date ( 'D' ) === 'Mon' ) {
		$MOM_Exclude_Tags_Day = get_option ( 'MOM_Exclude_TagsMon' ); 
		$MOM_Exclude_Cats_Day = get_option ( 'MOM_Exclude_CategoriesMon' ); 
	}
	if ( date ( 'D' ) === 'Tue' ) {
		$MOM_Exclude_Tags_Day = get_option ( 'MOM_Exclude_TagsTue' ); 
		$MOM_Exclude_Cats_Day = get_option ( 'MOM_Exclude_CategoriesTue' ); 
	}
	if ( date ( 'D' ) === 'Wed' ) {
		$MOM_Exclude_Tags_Day = get_option ( 'MOM_Exclude_TagsWed' ); 
		$MOM_Exclude_Cats_Day = get_option ( 'MOM_Exclude_CategoriesWed' ); 
	}
	if ( date ( 'D' ) === 'Thu' ) {
		$MOM_Exclude_Tags_Day = get_option ( 'MOM_Exclude_TagsThu' ); 
		$MOM_Exclude_Cats_Day = get_option ( 'MOM_Exclude_CategoriesThu' ); 
	}
	if ( date ( 'D' ) === 'Fri' ) {
		$MOM_Exclude_Tags_Day = get_option ( 'MOM_Exclude_TagsFri' ); 
		$MOM_Exclude_Cats_Day = get_option ( 'MOM_Exclude_CategoriesFri' ); 
	}
	if ( date ( 'D' ) === 'Sat' ) {
		$MOM_Exclude_Tags_Day = get_option ( 'MOM_Exclude_TagsSun' ); 
		$MOM_Exclude_Cats_Day = get_option ( 'MOM_Exclude_CategoriesSat' ); 
	}
	
	$rss_day       = explode (',', $MOM_Exclude_Tags_Day );

	foreach ( $rss_day as &$rss_day_1 ) { 
		$rss_day_1 = '' . $rss_day_1 . ','; 
	}

	$rss_day_1     = implode ( $rss_day );
	$rssday        = explode ( ',', str_replace (' ', '', $rss_day_1 ) );
	$rss_day_cat   = explode ( ',', $MOM_Exclude_Cats_Day );

	if ( is_array ( $rss_day_cat ) ) { 
		foreach ( $rss_day_cat as &$rss_day_1_cat ) { 
			$rss_day_1_cat = '' . $rss_day_1_cat . ','; 
		} 
	}

	$rss_day_1_cat = implode ( $rss_day_cat );
	$rssday_cat    = explode ( ',', str_replace ( ' ', '', $rss_day_1_cat ) );
	
	if ( !is_user_logged_in() ) {
		
		$loggedOutCats = $loggedOutTags = $MOM_Exclude_VisitorCategories = $MOM_Exclude_level0Categories = $MOM_Exclude_level1Categories = $MOM_Exclude_level2Categories = 
		$MOM_Exclude_level7Categories = $MOM_Exclude_VisitorTags = $MOM_Exclude_level0Tags = $MOM_Exclude_level1Tags = $MOM_Exclude_level2Tags = $MOM_Exclude_level7Tags = 0;

		if ( get_option ( 'MOM_Exclude_VisitorCategories') ) {
			$MOM_Exclude_VisitorCategories = get_option ( 'MOM_Exclude_VisitorCategories' ); 
		}
		if ( get_option ( 'MOM_Exclude_level0Categories') ) {
			$MOM_Exclude_level0Categories = get_option ( 'MOM_Exclude_level0Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_level1Categories') ) {
			$MOM_Exclude_level1Categories = get_option ( 'MOM_Exclude_level1Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_level2Categories') ) {
			$MOM_Exclude_level2Categories = get_option ( 'MOM_Exclude_level2Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_level7Categories') ) {
			$MOM_Exclude_level7Categories = get_option ( 'MOM_Exclude_level7Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_VisitorTags') ) {
			$MOM_Exclude_VisitorTags = get_option ( 'MOM_Exclude_VisitorTags' );
		}
		if ( get_option ( 'MOM_Exclude_level0Tags') ) {
			$MOM_Exclude_level0Tags = get_option ( 'MOM_Exclude_level0Tags' );
		}
		if ( get_option ( 'MOM_Exclude_level1Tags') ) {
			$MOM_Exclude_level1Tags = get_option ( 'MOM_Exclude_level1Tags' );
		}
		if ( get_option ( 'MOM_Exclude_level2Tags') ) {
			$MOM_Exclude_level2Tags = get_option ( 'MOM_Exclude_level2Tags' );
		}

		$loggedOutCats = $MOM_Exclude_VisitorCategories . ',' . $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		$loggedOutTags = $MOM_Exclude_VisitorTags . ',' . $MOM_Exclude_level0Tags . ',' . $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
		$lc1 = array_unique ( explode ( ',', $loggedOutCats ) );
		
		foreach ( $lc1 as &$LC1 ) { 
			$LC1 = '' . $LC1 . ','; 
		}
		
		$lc_1 = rtrim ( implode ( $lc1 ), ',' );
		$hideLoggedOutCats = explode ( ',', str_replace ( ' ', '', $loggedOutCats ) );
		$lt1 = array_unique ( explode ( ',', $loggedOutTags ) );
		
		foreach ( $lt1 as &$LT1 ) { 
			$LT1 = '' . $LT1 . ','; 
		}
		
		$lt11 = rtrim ( implode ( $lt1 ), ',' );
		$hideLoggedOutTags = explode ( ',', str_replace ( ' ', '', $lt11 ) );
		$formats_to_hide   = $MOM_Exclude_PostFormats_Visitor;

	} else {

		get_currentuserinfo();
		global $user_level;
		$loggedOutCats = $loggedOutTags = $MOM_Exclude_VisitorCategories = $MOM_Exclude_level0Categories = $MOM_Exclude_level1Categories = $MOM_Exclude_level2Categories = 
		$MOM_Exclude_level7Categories = $MOM_Exclude_VisitorTags = $MOM_Exclude_level0Tags = $MOM_Exclude_level1Tags = $MOM_Exclude_level2Tags = $MOM_Exclude_level7Tags = 0;
		
		if ( get_option ( 'MOM_Exclude_Categories_VisitorCategories') ) { 
			$MOM_Exclude_VisitorCategories = get_option ( 'MOM_Exclude_Categories_VisitorCategories' ); 
		}
		if ( get_option ( 'MOM_Exclude_Categories_level0Categories') ) { 
			$MOM_Exclude_level0Categories  = get_option ( 'MOM_Exclude_Categories_level0Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_Categories_level1Categories') ) { 
			$MOM_Exclude_level1Categories  = get_option ( 'MOM_Exclude_Categories_level1Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_Categories_level2Categories') ) { 
			$MOM_Exclude_level2Categories  = get_option ( 'MOM_Exclude_Categories_level2Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_Categories_level7Categories') ) { 
			$MOM_Exclude_level7Categories  = get_option ( 'MOM_Exclude_Categories_level7Categories' ); 
		}
		if ( get_option ( 'MOM_Exclude_Tags_VisitorTags') ) { 
			$MOM_Exclude_VisitorTags = get_option ( 'MOM_Exclude_Tags_VisitorTags' ); 
		}
		if ( get_option ( 'MOM_Exclude_Tags_level0Tags') ) { 
			$MOM_Exclude_level0Tags = get_option ( 'MOM_Exclude_Tags_level0Tags' ); 
		}
		if ( get_option ( 'MOM_Exclude_Tags_level1Tags') ) { 
			$MOM_Exclude_level1Tags = get_option ( 'MOM_Exclude_Tags_level1Tags' ); 
		}
		if ( get_option ( 'MOM_Exclude_Tags_level2Tags') ) { 
			$MOM_Exclude_level2Tags = get_option ( 'MOM_Exclude_Tags_level2Tags' ); 
		}
		if ( get_option ( 'MOM_Exclude_level7Categories') ) { 
			$MOM_Exclude_level7Categories = get_option( 'MOM_Exclude_level7Categories' ); 
		}
		
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
	
	if ( $query->is_feed ) { 
		$c1 = explode ( ',', $MOM_Exclude_Categories_RSS ); 
		$formats_to_hide = $MOM_Exclude_PostFormats_RSS; 
		$t1 = explode ( ',', $MOM_Exclude_Tags_RSS ); 
	}
	if ( $query->is_home ) { 
		$c1 = explode ( ',', $MOM_Exclude_Categories_Front ); 
		$formats_to_hide = $MOM_Exclude_PostFormats_Front; 
		$t1 = explode ( ',', $MOM_Exclude_Tags_Front ); 
	}
	if ( $query->is_category ) { 
		$t1 = explode ( ',', $MOM_Exclude_Tags_CategoryArchives ); 
		$formats_to_hide = $MOM_Exclude_PostFormats_CategoryArchives; 
	}
	if ( $query->is_tag ) { 
		$c1 = explode ( ',', $MOM_Exclude_Categories_TagArchives ); 
		$formats_to_hide = $MOM_Exclude_PostFormats_TagArchives; 
	}
	if ( $query->is_search ) { 
		$c1 = explode ( ',', $MOM_Exclude_Categories_SearchResults ); 
		$formats_to_hide = $MOM_Exclude_PostFormats_SearchResults; 
		$t1 = explode ( ',',$MOM_Exclude_Tags_SearchResults ); 
	}
	
	foreach ( $c1 as &$C1 ) { 
		$C1 = '' . $C1 . ','; 
	}
	
	$c_1               = rtrim ( implode ( $c1 ), ',' );
	$hideUserCats      = explode (',', str_replace (' ', '', $c_1 ) );
	foreach ( $t1 as &$T1 ) { 
		$T1 = '' . $T1 . ','; 
	}

	$t11               = rtrim ( implode ( $t1 ), ',' );
	$hideUserTags      = explode ( ',', str_replace ( ' ', '', $t11 ) );
	$categories_to_hide = array_merge ( ( array ) $hideUserCats, ( array ) $hideLoggedOutCats, ( array ) $rssday_cat );
	$tags_to_hide       = array_merge ( ( array ) $hideUserTags, ( array ) $hideLoggedOutTags, ( array ) $rssday );
	$categories_to_hide = array_filter ( array_unique ( $categories_to_hide ) );
	$tags_to_hide       = array_filter ( array_unique ( $tags_to_hide ) );	
	
	
	if ( $query->is_main_query() ) {
		if ( $query->is_feed || $query->is_home || $query->is_search || $query->is_tag || $query->is_category ) {
			$tax_query = array (
				'ignore_sticky_posts' => true,
				'post_type' => 'any',
				array (
					'taxonomy' => 'category',
					'terms' => $categories_to_hide,
					'field' => 'id',
					'operator' => 'NOT IN'
				),
				array (
					'taxonomy' => 'post_tag',
					'terms' => $tags_to_hide,
					'field' => 'id',
					'operator' => 'NOT IN'
				),
				array (
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array($formats_to_hide),
					'operator' => 'NOT IN'
				)
			);
			$query->set ( 'tax_query', $tax_query );
		}
	}
	
}