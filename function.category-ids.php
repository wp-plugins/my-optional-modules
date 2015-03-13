<?php 

/**
 * FUNCTION my_optional_modules_get_category_ids()
 *
 * File last update: 8-RC-1.5.6
 *
 * Returns all category IDs for the blog.
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

function my_optional_modules_get_category_ids() {

	$cat_ids = null;
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

	return $cat_ids;
	$cat_ids = null;

}