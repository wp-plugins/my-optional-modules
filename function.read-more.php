<?php 

/**
 * FUNCTION mom_readmorecontent()
 *
 * File last update: 8-RC-1.5.6
 *
 * Destroy the default excerpt created 'Twenty Fifteen'.
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

if ( get_option( 'mom_readmorecontent' ) ) {

	function twentyfifteen_excerpt_more( $more ) {

	}

}