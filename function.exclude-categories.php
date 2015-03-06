<?php 

/**
 * Returns a list of categories, excluding ones hidden by Exclusion rules for user levels
 *
 * For use in templates
 * my_optional_modules_exclude_categories();
 */

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}
if( !function_exists( 'my_optional_modules_exclude_categories' ) ) {
	function my_optional_modules_exclude_categories() {
		$loggedOutCats = 0;
		if( 1 == get_option( 'mommaincontrol_momse' ) ) {
			global $myoptionalmodules_plugin;
			$MOM_Exclude_level0Categories  = 0;
			$MOM_Exclude_level1Categories  = 0;
			$MOM_Exclude_level2Categories  = 0;
			$MOM_Exclude_level7Categories  = 0;
			$MOM_Exclude_level0Categories  = sanitize_text_field ( get_option( 'MOM_Exclude_Categories_level0Categories' ) );
			$MOM_Exclude_level1Categories  = sanitize_text_field ( get_option( 'MOM_Exclude_Categories_level1Categories' ) );
			$MOM_Exclude_level2Categories  = sanitize_text_field ( get_option( 'MOM_Exclude_Categories_level2Categories' ) );
			$MOM_Exclude_level7Categories  = sanitize_text_field ( get_option( 'MOM_Exclude_Categories_level7Categories' ) );
			if( 0 == $myoptionalmodules_plugin->user_level ) {
				$loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			}
			if( 1 == $myoptionalmodules_plugin->user_level ) {
				$loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			}
			if( 2 == $myoptionalmodules_plugin->user_level ) {
				$loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			}
			if( 3 == $myoptionalmodules_plugin->user_level ) {
				$loggedOutCats = $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			}
			if( 4 == $myoptionalmodules_plugin->user_level ) {
				$loggedOutCats = $MOM_Exclude_level7Categories;
			} else {
				$loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;				
			}
			$c1 = explode( ',', $loggedOutCats );
			foreach( $c1 as &$C1 ){ $C1 = $C1 . ','; }
			$c_1 = rtrim( implode( $c1 ), ',' );
			$c11 = explode( ',', str_replace( ' ', '', $c_1 ) );
			$c11array = array( $c11 );
			$loggedOutCats = array_filter( $c11 );
		}
		$category_ids = my_optional_modules_get_category_ids();
		foreach( $category_ids as $cat_id ) {
			if( $loggedOutCats ) {
				if( in_array( $cat_id, $loggedOutCats ) )continue;
			}
			$cat  = get_category( $cat_id );
			$link = get_category_link( $cat_id );
			echo '<li><a href="' . $link . '" title="link to ' . $cat->name . '">' . $cat->name . '</a></li>';
		}
		$MOM_Exclude_level0Categories = null;
		$MOM_Exclude_level1Categories = null;
		$MOM_Exclude_level2Categories = null;
		$MOM_Exclude_level7Categories = null;
		$c1                           = null;
		$C1                           = null;
		$c11                          = null;
		$c11array                     = null;
		$category_ids                 = null;
		$cat                          = null;
		$link                         = null;
		$loggedOutCats                = null;
	}
}