<?php 

/**
 * FUNCTION my_optional_modules_exclude_categories()
 *
 * File last update: 9.1.2
 *
 * Returns a list of categories that follow the 'exclusion' rules (if any).
 * This is a template tag:
 * - my_optional_modules_exclude_categories();
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

function my_optional_modules_exclude_categories() {

	$loggedOutCats = 0;

	global $myoptionalmodules_exclude, $myoptionalmodules_plugin , $myoptionalmodules_exclude_categorieslevel0categories , $myoptionalmodules_exclude_categorieslevel1categories , $myoptionalmodules_exclude_categorieslevel2categories , $myoptionalmodules_exclude_categorieslevel7categories;
	if ( $myoptionalmodules_exclude ) {

		$MOM_Exclude_level0Categories  = 0;
		$MOM_Exclude_level1Categories  = 0;
		$MOM_Exclude_level2Categories  = 0;
		$MOM_Exclude_level7Categories  = 0;
		$MOM_Exclude_level0Categories  = $myoptionalmodules_exclude_categorieslevel0categories;
		$MOM_Exclude_level1Categories  = $myoptionalmodules_exclude_categorieslevel1categories;
		$MOM_Exclude_level2Categories  = $myoptionalmodules_exclude_categorieslevel2categories;
		$MOM_Exclude_level7Categories  = $myoptionalmodules_exclude_categorieslevel7categories;

		if ( 0 == $myoptionalmodules_plugin->user_level ) {
			$loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		}
		if ( 1 == $myoptionalmodules_plugin->user_level ) {
			$loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		}
		if ( 2 == $myoptionalmodules_plugin->user_level ) {
			$loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		}
		if ( 3 == $myoptionalmodules_plugin->user_level ) {
			$loggedOutCats = $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
		}
		if ( 4 == $myoptionalmodules_plugin->user_level ) {
			$loggedOutCats = $MOM_Exclude_level7Categories;
		} else {
			$loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;				
		}

		$c1 = explode ( ',' , $loggedOutCats );
		foreach ( $c1 as &$C1 ) { $C1 = $C1 . ','; }
		$c_1           = rtrim ( implode ( $c1 ) , ',' );
		$c11           = explode ( ',' , str_replace ( ' ' , '' , $c_1 ) );
		$c11array      = array ( $c11 );
		$loggedOutCats = array_filter ( $c11 );
	}

	$category_ids = my_optional_modules_get_category_ids();
	
	foreach ( $category_ids as $cat_id ) {

		if ( $loggedOutCats ) {
			if ( in_array ( $cat_id , $loggedOutCats ) ) continue;
		}

		$cat  = get_category ( $cat_id );
		$link = get_category_link ( $cat_id );

		echo '<li><a href="' . $link . '" title="link to ' . $cat->name . '">' . $cat->name . '</a></li>';

	}

	$c1                           = null;
	$C1                           = null;
	$c11                          = null;
	$c11array                     = null;
	$category_ids                 = null;
	$cat                          = null;
	$link                         = null;
	$loggedOutCats                = null;

}