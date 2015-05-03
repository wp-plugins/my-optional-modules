<?php 
/**
 * Version information
 *
 * File last update: 10.0.4
 *
 * Define which versions of (what) to enqueue from CDN, making sure
 * to always update for current releases.
 *
 * //cdnjs.com/
 * - Last checked 10.0.4
 * - - 1.9.1 //cdnjs.com/libraries/jquery.lazyload
 * - - 2.1.4 //cdnjs.com/libraries/jquery
 * - - 1.2.1 //cdnjs.com/libraries/jquery-migrate
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

$myoptionalmodules_lazyload_version      = esc_url( '//cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js' );
$myoptionalmodules_jquery_version        = esc_url( '//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js' );
$myoptionalmodules_jquerymigrate_version = esc_url( '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js' );