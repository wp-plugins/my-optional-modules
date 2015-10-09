<?php 
/**
 * FUNCTION functions
 *
 * File last update: 10.4
 *
 * Generic functions used throughout the plugin for
 * various purposes.
 *
 */

defined ( 'MyOptionalModules' ) or exit;

/**
 * Protocol relative URL(s)
 * Strips both https: and http: from the supplied URL
 * so that it is in compliance with websites that use 
 * https: exclusively.
 */
function mom_strip_protocol ( $url ) {
	$url = str_replace ( array ( 'https:' , 'http:' ) , '' , esc_url ( $url ) );
	return $url;
}