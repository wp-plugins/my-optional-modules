<?php 

/**
 * Returns a list of all category IDs 
 */

if(!defined('MyOptionalModules')){
	die();
}

if( !function_exists( 'my_optional_modules_get_category_ids' ) ) {
	function my_optional_modules_get_category_ids() {
		if ( !$cat_ids = wp_cache_get( 'all_category_ids', 'category' ) ) {
			$cat_ids = get_terms( 
				'category', 
				array( 
					'fields' => 'ids', 
					'get'    => 'all' 
				) 
			);
			wp_cache_add( 
				'all_category_ids', 
				$cat_ids, 
				'category' 
			);
		}
		return $cat_ids;
	}
}