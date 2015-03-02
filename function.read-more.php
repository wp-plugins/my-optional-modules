<?php 

/**
 * Destroy the default Twenty Fifteen excerpt 'read more' content
 */

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}

if( get_option( 'mom_readmorecontent' ) ) {
	function twentyfifteen_excerpt_more( $more ) {

	}
}