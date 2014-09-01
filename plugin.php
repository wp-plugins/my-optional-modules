<?php 

/**
 * Plugin Name: My Optional Modules
 * Plugin URI: http://wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 5.6.1.4
 * Author: Matthew Trevino
 * Author URI: http://wordpress.org/plugins/my-optional-modules/
 *	
 * LICENSE
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program;if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

 /**
  *
  * This is free software. You don't pay anything for it.
  * This is a hobby. This is not my job. I don't get paid for it.
  *
  * Please be kind to me. I spend a lot of my free time doing this.
  * There are bound to be bugs in it sometimes. 
  * And I'll have them fixed as soon as I spot them.
  * I do my best to ensure that there aren't, but I'm only human;
  * things sometimes slip by.  
  *
  */

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

define( 'MyOptionalModules', true );
require_once( ABSPATH . 'wp-includes/pluggable.php' );
add_action( 'wp', 'my_optional_modules_scripts' );
add_action( 'admin_enqueue_scripts', 'my_optional_modules_stylesheets' );
add_action( 'admin_enqueue_scripts', 'my_optional_modules_font_awesome' );
add_action( 'wp_print_styles', 'my_optional_modules_main_stylesheet' );
add_action( 'after_setup_theme', 'myoptionalmodules_postformats' );

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

/**
 *
 * Currently, the plugin treats users who are not logged in and subscribers as the 
 * level (which may or may not be changed sometime in the future)
 *
 */
if( is_user_logged_in() ) {

	if( current_user_can('read') )                   $user_level = 0;	// Subscriber
	if( current_user_can('delete_posts') )           $user_level = 1;	// 
	if( current_user_can('delete_published_posts') ) $user_level = 2;	// 
	if( current_user_can('read_private_pages') )     $user_level = 4;	// 
	if( current_user_can('edit_dashboard') )         $user_level = 7;	// Admin
	
} else {

	$user_level = 0;													// Not logged in
	
}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

/**
 *
 * Validate the IP address
 * "This function converts a human readable IPv4 or IPv6 address
 * (if PHP was built with IPv6 support enabled) into an address 
 * family appropriate 32bit or 128bit binary structure."
 * Read more at: //php.net/manual/en/function.inet-pton.php
 *
 */
if( inet_pton( $_SERVER['REMOTE_ADDR'] ) === false ) {

	$ipaddress = false;
	
	/**
	 *
	 * If the IP address can't validate, treat it like it's hostile, and flag it 
	 * as being DNSBL listed (regardless of whether it actually is or isn't)
	 *
	 */
	$DNSBL = true;

} else {

	/**
	 *
	 * If the IP address DOES validate, pass it along for further analysis
	 *
	 */
	$ipaddress = esc_attr( $_SERVER[ 'REMOTE_ADDR' ] );

}

if( !function_exists ( 'myoptionalmodules_checkdnsbl' ) ) {

	/**
	 *
	 * Check the IP address (if it was validated) against the DNSBL
	 *
	 */
	function myoptionalmodules_checkdnsbl($ipaddress){

		global $ipaddress, $DNSBL;

		$listed = 0;

		/**
		 *
		 * Blacklists to check
		 * Extensive list found here: //dnsbl.info/dnsbl-list.php
		 *
		 */
		$dnsbl_lookup=array(
			'dnsbl-1.uceprotect.net',
			'dnsbl-2.uceprotect.net',
			'dnsbl-3.uceprotect.net',
			'dnsbl.sorbs.net',
			'zen.spamhaus.org',
			'dnsbl-2.uceprotect.net',
			'dnsbl-3.uceprotect.net'
		);

		if( $ipaddress ) {

			$reverse_ip=implode(".",array_reverse(explode(".",$ipaddress)));

			foreach($dnsbl_lookup as $host){

				if( checkdnsrr( $reverse_ip.".".$host.".","A" ) ) {

					$listed.=$reverse_ip.'.'.$host;

				}

			}

		}

		if( $listed ) {

			/**
			 *
			 * If the IP is listed on one of the blacklists, treat it as a hostile
			 *
			 */
			$DNSBL     === true;
			$ipaddress === false;

		} else {

			/**
			 *
			 * If the IP was NOT listed on one of the blacklists, treat it as a friendly
			 *
			 */
			$DNSBL === false;

		}

	}

} else {

	/**
	 *
	 * If a function already exists called myoptionalmodules_checkdnsbl (it shouldn't),
	 * we want a fallback to whitelist IPs (because they won't be getting checked if 
	 * the function is being overridden).
	 * This keeps our plugin functions that rely on the DNSBL check from breaking (completely)
	 *
	 */
	$DNSBL === false;

}

/**
 * Currently, no functions within this plugin actually utilize DNSBL IP checking (anymore)
 * However, I'm keeping this here for any (possible) future use.
 *
 * Don't check the DNSBL if the user is logged in and 
 * level 7 (likely an admin account).
 */
if( 7 != $user_level ) {

	$ipaddress = myoptionalmodules_checkdnsbl( $ipaddress );

	
} else {

	$DNSBL = false;

}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

register_activation_hook( __FILE__, 'my_optional_modules_main_installation' );

if( !function_exists( 'my_optional_modules_main_installation' ) ) {

	function my_optional_modules_main_installation(){

		delete_option( 'mommaincontrol_passwords_activated' );					
		delete_option( 'mommaincontrol_reviews_activated' );
		delete_option( 'mommaincontrol_shorts_activated' );

	}

}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

if( !function_exists( 'my_optional_modules_scripts' ) ) {

	function my_optional_modules_scripts(){

		function mom_jquery(){

			$fittext = plugins_url().'/my-optional-modules/includes/javascript/fittext.js';
			wp_enqueue_script( 'fittext', $fittext, array( 'jquery' ) );

			if( 1 == get_option( 'mommaincontrol_lazyload' ) ) {

				$lazyLoad = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
				$lazyLoadFunctions = plugins_url().'/my-optional-modules/includes/javascript/lazyload.js';
				wp_enqueue_script( 'lazyload', $lazyLoad, array( 'jquery' ) );
				wp_enqueue_script( 'lazyloadFunctions', $lazyLoadFunctions, array( 'jquery' ) );

			}

		}

		add_action( 'wp_enqueue_scripts', 'mom_jquery' );

		function MOMScriptsFooter(){			

			echo '
			<script type=\'text/javascript\'>';
				echo 'jQuery(document).ready(function($){';

					echo 'jQuery(".recentPostRotationFull .thumbnailFull a.mediaNotPresent").fitText();';
					

				echo '});</script>';

			

		}

		add_action( 'wp_footer', 'MOMScriptsFooter', 99999 );

	}

}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

$date_day                          = date( 'D' );
$date_y                            = date( 'Y' );
$date_m                            = date( 'n' );
$date_d                            = date( 'j' );

$mommodule_exclude                 = intval( get_option( 'mommaincontrol_momse' ) );
$mommodule_fontawesome             = intval( get_option( 'mommaincontrol_fontawesome' ) );
$mommodule_authorarchives          = intval( get_option( 'mommaincontrol_authorarchives' ) );
$mommodule_datearchives            = intval( get_option( 'mommaincontrol_datearchives' ) );
$mommodule_footerscripts           = intval( get_option( 'mommaincontrol_footerscripts' ) );
$mommodule_protectrss              = intval( get_option( 'mommaincontrol_protectrss' ) );
$mommodule_lazyload                = intval( get_option( 'mommaincontrol_lazyload' ) );
$mommodule_versionnumbers          = intval( get_option( 'mommaincontrol_versionnumbers' ) );
$horizontal_galleries              = intval( get_option( 'MOM_themetakeover_horizontal_galleries' ) );
$momthemetakeover_ajaxcomments     = intval( get_option( 'MOM_themetakeover_ajaxifycomments' ) );

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

if( 1 == $mommodule_exclude ) {

	add_action( 'pre_get_posts', 'mom_exclude_filter_posts' );

	if( !function_exists( 'mom_exclude_filter_posts' ) ) {

		function mom_exclude_filter_posts( $query ) {
			
			global $date_day;
			
			$c1	     = array( '0' );
			$lt_1    = array( '0' );
			$t1	     = array( '0' );
			$t_1     = array( '0' );
			$rss_day = array( '0' );
			$t11     = 0;
			$c_1     = 0;

			$MOM_Exclude_Categories_Front             = get_option( 'MOM_Exclude_Categories_Front' );
			$MOM_Exclude_Categories_TagArchives       = get_option( 'MOM_Exclude_Categories_TagArchives' );
			$MOM_Exclude_Categories_SearchResults     = get_option( 'MOM_Exclude_Categories_SearchResults' );
			$MOM_Exclude_Categories_RSS               = get_option( 'MOM_Exclude_Categories_RSS' );
			$MOM_Exclude_Tags_RSS                     = get_option( 'MOM_Exclude_Tags_RSS' );
			$MOM_Exclude_Tags_Front                   = get_option( 'MOM_Exclude_Tags_Front' );
			$MOM_Exclude_Tags_CategoryArchives        = get_option( 'MOM_Exclude_Tags_CategoryArchives' );
			$MOM_Exclude_Tags_SearchResults           = get_option( 'MOM_Exclude_Tags_SearchResults' );
			$MOM_Exclude_PostFormats_Front            = get_option( 'MOM_Exclude_PostFormats_Front' );
			$MOM_Exclude_PostFormats_CategoryArchives = get_option( 'MOM_Exclude_PostFormats_CategoryArchives' );
			$MOM_Exclude_PostFormats_TagArchives      = get_option( 'MOM_Exclude_PostFormats_TagArchives' );
			$MOM_Exclude_PostFormats_SearchResults    = get_option( 'MOM_Exclude_PostFormats_SearchResults' );
			$MOM_Exclude_PostFormats_Visitor          = get_option( 'MOM_Exclude_PostFormats_Visitor' );
			$MOM_Exclude_PostFormats_RSS              = get_option( 'MOM_Exclude_PostFormats_RSS' );
			$MOM_Exclude_Tags_Day                     = get_option( 'MOM_Exclude_Tags_Tags' . $date_day . '' );
			$MOM_Exclude_Cats_Day                     = get_option( 'MOM_Exclude_Categories_Categories' . $date_day . '' );

			if( '' == $MOM_Exclude_Categories_Front ) $MOM_Exclude_Categories_Front                         = 0;
			if( '' == $MOM_Exclude_Categories_TagArchives ) $MOM_Exclude_Categories_TagArchives             = 0;
			if( '' == $MOM_Exclude_Categories_SearchResults ) $MOM_Exclude_Categories_SearchResults         = 0;
			if( '' == $MOM_Exclude_Categories_RSS ) $MOM_Exclude_Categories_RSS                             = 0;
			if( '' == $MOM_Exclude_Tags_RSS ) $MOM_Exclude_Tags_RSS                                         = 0;
			if( '' == $MOM_Exclude_Tags_Front ) $MOM_Exclude_Tags_Front                                     = 0;
			if( '' == $MOM_Exclude_Tags_CategoryArchives ) $MOM_Exclude_Tags_CategoryArchives               = 0;
			if( '' == $MOM_Exclude_Tags_SearchResults ) $MOM_Exclude_Tags_SearchResults                     = 0;
			if( '' == $MOM_Exclude_PostFormats_Front ) $MOM_Exclude_PostFormats_Front                       = 0;
			if( '' == $MOM_Exclude_PostFormats_CategoryArchives ) $MOM_Exclude_PostFormats_CategoryArchives = 0;
			if( '' == $MOM_Exclude_PostFormats_TagArchives ) $MOM_Exclude_PostFormats_TagArchives           = 0;
			if( '' == $MOM_Exclude_PostFormats_SearchResults ) $MOM_Exclude_PostFormats_SearchResults       = 0;
			if( '' == $MOM_Exclude_PostFormats_Visitor ) $MOM_Exclude_PostFormats_Visitor                   = 0;
			if( '' == $MOM_Exclude_PostFormats_RSS ) $MOM_Exclude_PostFormats_RSS                           = 0;
			if( '' == $MOM_Exclude_Tags_Day ) $MOM_Exclude_Tags_Day                                         = 0;
			if( '' == $MOM_Exclude_Cats_Day ) $MOM_Exclude_Cats_Day                                         = 0;
			
			
			$rss_day = explode( ',', $MOM_Exclude_Tags_Day );
			
			foreach( $rss_day as &$rss_day_1 ) {

				$rss_day_1 = $rss_day_1 . ',';

			}

			$rss_day_1     = implode( $rss_day );
			$rssday        = explode( ',', str_replace (' ', '', $rss_day_1 ) );
			$rss_day_cat   = explode( ',', $MOM_Exclude_Cats_Day );

			if( is_array( $rss_day_cat ) ) {

				foreach( $rss_day_cat as &$rss_day_1_cat ) {

					$rss_day_1_cat = $rss_day_1_cat . ',';

				}

			}

			$rss_day_1_cat = implode( $rss_day_cat );
			$rssday_cat    = explode( ',', str_replace ( ' ', '', $rss_day_1_cat ) );
			
			if( !is_user_logged_in() ) {
				
				$MOM_Exclude_level0Categories  = get_option( 'MOM_Exclude_Categories_level0Categories' ); 
				$MOM_Exclude_level1Categories  = get_option( 'MOM_Exclude_Categories_level1Categories' ); 
				$MOM_Exclude_level2Categories  = get_option( 'MOM_Exclude_Categories_level2Categories' ); 
				$MOM_Exclude_level7Categories  = get_option( 'MOM_Exclude_Categories_level7Categories' ); 
				$MOM_Exclude_level0Tags        = get_option( 'MOM_Exclude_Tags_level0Tags' );
				$MOM_Exclude_level1Tags        = get_option( 'MOM_Exclude_Tags_level1Tags' );
				$MOM_Exclude_level2Tags        = get_option( 'MOM_Exclude_Tags_level2Tags' );
				$MOM_Exclude_level7Tags        = get_option( 'MOM_Exclude_Tags_level7Tags' );
				$loggedOutCats                                                           = 0;
				$loggedOutTags                                                           = 0;

				if( '' == $MOM_Exclude_level0Categories ) $MOM_Exclude_level0Categories  = 0;
				if( '' == $MOM_Exclude_level1Categories ) $MOM_Exclude_level1Categories  = 0;
				if( '' == $MOM_Exclude_level2Categories ) $MOM_Exclude_level2Categories  = 0;
				if( '' == $MOM_Exclude_level7Categories ) $MOM_Exclude_level7Categories  = 0;
				if( '' == $MOM_Exclude_level0Tags ) $MOM_Exclude_level0Tags              = 0;
				if( '' == $MOM_Exclude_level1Tags ) $MOM_Exclude_level1Tags              = 0;
				if( '' == $MOM_Exclude_level2Tags ) $MOM_Exclude_level2Tags              = 0;
				if( '' == $MOM_Exclude_level7Tags ) $MOM_Exclude_level7Tags              = 0;
				
				$loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
				$loggedOutTags = $MOM_Exclude_level0Tags . ',' . $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
				
				$lc1 = array_unique( explode( ',', $loggedOutCats ) );
				
				foreach( $lc1 as &$LC1 ) { 
					$LC1 = $LC1 . ','; 
				}
				
				$lc_1 = rtrim( implode( $lc1 ), ',' );
				$hideLoggedOutCats = explode ( ',', str_replace ( ' ', '', $loggedOutCats ) );
				$lt1 = array_unique ( explode ( ',', $loggedOutTags ) );
				
				foreach( $lt1 as &$LT1 ) { 
					$LT1 = $LT1 . ','; 
				}
				
				$lt11 = rtrim( implode( $lt1 ), ',' );
				$hideLoggedOutTags = explode( ',', str_replace ( ' ', '', $lt11 ) );
				$formats_to_hide   = $MOM_Exclude_PostFormats_Visitor;

			} else {

				global $user_level;

				$MOM_Exclude_level0Categories  = get_option( 'MOM_Exclude_Categories_level0Categories' ); 
				$MOM_Exclude_level1Categories  = get_option( 'MOM_Exclude_Categories_level1Categories' ); 
				$MOM_Exclude_level2Categories  = get_option( 'MOM_Exclude_Categories_level2Categories' ); 
				$MOM_Exclude_level7Categories  = get_option( 'MOM_Exclude_Categories_level7Categories' ); 
				$MOM_Exclude_level0Tags        = get_option( 'MOM_Exclude_Tags_level0Tags' ); 
				$MOM_Exclude_level1Tags        = get_option( 'MOM_Exclude_Tags_level1Tags' ); 
				$MOM_Exclude_level2Tags        = get_option( 'MOM_Exclude_Tags_level2Tags' ); 
				$MOM_Exclude_level7Tags        = get_option( 'MOM_Exclude_Tags_level7Tags' );
				$loggedOutCats                 = 0;
				$loggedOutTags                 = 0;
				
				if( '' == $MOM_Exclude_level0Categories ) $MOM_Exclude_level0Categories = 0;
				if( '' == $MOM_Exclude_level1Categories ) $MOM_Exclude_level1Categories = 0;
				if( '' == $MOM_Exclude_level2Categories ) $MOM_Exclude_level2Categories = 0;
				if( '' == $MOM_Exclude_level7Categories ) $MOM_Exclude_level7Categories = 0;
				if( '' == $MOM_Exclude_level0Tags ) $MOM_Exclude_level0Tags             = 0;
				if( '' == $MOM_Exclude_level1Tags ) $MOM_Exclude_level1Tags             = 0;
				if( '' == $MOM_Exclude_level2Tags ) $MOM_Exclude_level2Tags             = 0; 
				if( '' == $MOM_Exclude_level7Tags ) $MOM_Exclude_level7Tags             = 0;

				if( $user_level == 0 ) $loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
				if( $user_level == 1 ) $loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
				if( $user_level == 2 ) $loggedOutCats = $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
				if( $user_level == 7 ) $loggedOutCats = $MOM_Exclude_level7Categories;

				if( $user_level == 0 ) $loggedOutTags = $MOM_Exclude_level0Tags . ',' . $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
				if( $user_level == 1 ) $loggedOutTags = $MOM_Exclude_level1Tags . ',' . $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
				if( $user_level == 2 ) $loggedOutTags = $MOM_Exclude_level2Tags . ',' . $MOM_Exclude_level7Tags;
				if( $user_level == 7 ) $loggedOutTags = $MOM_Exclude_level7Tags;	

				$hideLoggedOutCats = explode ( ',', str_replace (' ', '', $c_1 ) );
				$hideLoggedOutTags = explode ( ',', str_replace (' ', '', $t11 ) );
				$lc1               = array_unique ( explode ( ',', $loggedOutCats ) );
				foreach( $lc1 as &$LC1 ) { $LC1 = $LC1 . ','; }
				$lc_1              = rtrim ( implode ( $lc1 ), ',' );
				$hideLoggedOutCats = explode (',', str_replace ( ' ', '', $loggedOutCats ) );
				$lt1               = array_unique ( explode (',', $loggedOutTags ) );
				foreach( $lt1 as &$LT1 ) { $LT1 = $LT1 .','; }
				$lt11              = rtrim ( implode ( $lt1 ), ',' );
				$hideLoggedOutTags = explode ( ',', str_replace (' ', '', $lt11 ) );

			}

			if( $query->is_feed ) {

				$c1              = explode( ',', $MOM_Exclude_Categories_RSS );
				$formats_to_hide = $MOM_Exclude_PostFormats_RSS;
				$t1              = explode( ',', $MOM_Exclude_Tags_RSS );

			}
			
			if( $query->is_home ) {

				$c1              = explode( ',', $MOM_Exclude_Categories_Front );
				$formats_to_hide = $MOM_Exclude_PostFormats_Front;
				$t1              = explode( ',', $MOM_Exclude_Tags_Front );

			}
			
			if( $query->is_category ) {

				$t1              = explode( ',', $MOM_Exclude_Tags_CategoryArchives );
				$formats_to_hide = $MOM_Exclude_PostFormats_CategoryArchives;

			}

			if( $query->is_tag ) {

				$c1              = explode( ',', $MOM_Exclude_Categories_TagArchives );
				$formats_to_hide = $MOM_Exclude_PostFormats_TagArchives;

			}

			if( $query->is_search ) {

				$c1              = explode( ',', $MOM_Exclude_Categories_SearchResults );
				$formats_to_hide = $MOM_Exclude_PostFormats_SearchResults;
				$t1              = explode( ',',$MOM_Exclude_Tags_SearchResults );

			}
			
			foreach( $c1 as &$C1 ) { 

				$C1 = $C1 . ','; 

			}
			
			$c_1               = rtrim ( implode ( $c1 ), ',' );
			$hideUserCats      = explode (',', str_replace (' ', '', $c_1 ) );

			foreach( $t1 as &$T1 ) { 

				$T1 = $T1 . ','; 

			}

			$t11                = rtrim( implode ( $t1 ), ',' );
			$hideUserTags       = explode( ',', str_replace ( ' ', '', $t11 ) );
			$categories_to_hide = array_merge( ( array ) $hideUserCats, ( array ) $hideLoggedOutCats, ( array ) $rssday_cat );
			$tags_to_hide       = array_merge( ( array ) $hideUserTags, ( array ) $hideLoggedOutTags, ( array ) $rssday );
			$categories_to_hide = array_filter( array_unique ( $categories_to_hide ) );
			$tags_to_hide       = array_filter( array_unique ( $tags_to_hide ) );	
			
			
			if( $query->is_main_query() ) {

				if( $query->is_feed || $query->is_home || $query->is_search || $query->is_tag || $query->is_category ) {

					$tax_query = array (
						'ignore_sticky_posts' => true,
						'post_type'           => 'any',
						array (
							'taxonomy'        => 'category',
							'terms'           => $categories_to_hide,
							'field'           => 'id',
							'operator'        => 'NOT IN'
						),
						array (
							'taxonomy'        => 'post_tag',
							'terms'           => $tags_to_hide,
							'field'           => 'id',
							'operator'        => 'NOT IN'
						),
						array (
							'taxonomy'        => 'post_format',
							'field'           => 'slug',
							'terms'           => array($formats_to_hide),
							'operator'        => 'NOT IN'
						)
					);
					$query->set( 'tax_query', $tax_query );

				}

			}

		}

	}

}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */
if( 1 == $mommodule_fontawesome ) {

	add_action( 'wp_enqueue_scripts', 'myoptionalmodules_scripts' );

}

if( 1 == $mommodule_authorarchives ) {

	add_action( 'template_redirect', 'myoptionalmodules_disableauthorarchives' );

}

if( 1 == $mommodule_datearchives ) {

	add_action( 'wp', 'myoptionalmodules_disabledatearchives' );
	add_action( 'template_redirect', 'myoptionalmodules_disabledatearchives' );

}

if( 1 == $mommodule_footerscripts ) {

	add_action( 'wp_enqueue_scripts', 'myoptionalmodules_footerscripts' );
	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );

}

if( 1 == $mommodule_fontawesome ) {

	add_filter( 'the_content', 'do_shortcode', 'font_fa_shortcode' );

}

if( 1 == $mommodule_protectrss ) {

	add_filter( 'the_content_feed', 'myoptionalmodules_rsslinkback' );
	add_filter( 'the_excerpt_rss', 'myoptionalmodules_rsslinkback' );

}

if( 1 == $mommodule_versionnumbers ) {

	add_filter( 'style_loader_src', 'myoptionalmodules_removeversion', 0 );
	add_filter( 'script_loader_src', 'myoptionalmodules_removeversion', 0 );

}

if( 1 == $momthemetakeover_ajaxcomments ) {

	add_action ( 'comment_post', 'mom_ajaxComment', 20, 2 );

}

if( !function_exists( 'my_optional_modules_add_my_shortcodes' ) ) {
	add_action ( 'init', 'my_optional_modules_add_my_shortcodes', 99 );
	function my_optional_modules_add_my_shortcodes() {
		global $mommodule_fontawesome;
		if( 1 == $mommodule_fontawesome ) { 

			add_shortcode( 'font-fa',  'font_fa_shortcode' );

		}

	}

}

if( get_option( 'mompaf_post' ) ) {

	if( 'off' != get_option( 'mompaf_post' ) ) {

		add_action ( 'wp', 'myoptionalmodules_postasfront' );

	}

}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

function mom_get_all_category_ids() {
	if ( ! $cat_ids = wp_cache_get( 'all_category_ids', 'category' ) ) {
		$cat_ids = get_terms( 'category', array('fields' => 'ids', 'get' => 'all') );
		wp_cache_add( 'all_category_ids', $cat_ids, 'category' );
	}
	return $cat_ids;
}

// (1) Calculate time between (date) and (date)
if( !function_exists( 'mom_timesince' ) ) {

	function mom_timesince( $date, $granularity=2 ) {

		$retval     = '';
		$date       = strtotime( $date );
		$difference = time() - $date;
		
		$periods = array(

			' decades' => 315360000, 
			' years' => 31536000, 
			' months' => 2628000, 
			' weeks' => 604800,  
			' days' => 86400, 
			' hours' => 3600, 
			' minutes' => 60, 
			' seconds' => 1 

		);

		foreach( $periods as $key => $value ) {

			if( $difference >= $value ) {

				$time = floor ( $difference/$value );
				$difference %= $value;
				$retval .= ( $retval ? ' ' : '' ) . $time . '';
				$retval .= ( ( $time > 1 ) ? $key : $key );
				$granularity--;

			}

			if( $granularity == '0' ) {

				break; 

			}

		}

		return $retval . ' ago';

	}	
}



/**
*
* No Comments
* Disable comments display and form
*
*/

if( 1 == get_option( 'mommaincontrol_comments' ) || 1 == get_option( 'mommaincontrol_dnsbl' ) && true === $DNSBL ){

	add_filter( 'comments_template','mom_disablecomments' );
	add_filter( 'comments_open','mom_disablecommentsform',10,2 );

	if( !function_exists( 'mom_disablecomments' ) ) {

		function mom_disablecomments( $comment_template ) {

			return dirname( __FILE__ ) . '/includes/templates/comments.php';

		}

	}

	if( !function_exists( 'mom_disablecommentsform' ) ) {

		function mom_disablecommentsform( $open,$post_id ) {

			$post = get_post( $post_id );
			$open = false;
			return $open;

		}

	}

}

if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ) {

	remove_shortcode( 'gallery', 'gallery_shortcode' );
	add_action( 'init', 'mom_gallery_shortcode_add', 99 );

	function mom_gallery_shortcode_add() {

		add_shortcode( 'gallery', 'mom_gallery_shortcode' );

	}
	add_filter( 'use_default_gallery_style', '__return_false' );

	/**
	 * The Gallery shortcode.
	 *
	 * This implements the functionality of the Gallery Shortcode for displaying
	 * WordPress images on a post.
	 *
	 * @since 2.5.0
	 *
	 * @param array $attr {
	 *     Attributes of the gallery shortcode.
	 *
	 *     @type string $order      Order of the images in the gallery. Default 'ASC'. Accepts 'ASC', 'DESC'.
	 *     @type string $orderby    The field to use when ordering the images. Default 'menu_order ID'.
	 *                              Accepts any valid SQL ORDERBY statement.
	 *     @type int    $id         Post ID.
	 *     @type string $itemtag    HTML tag to use for each image in the gallery.
	 *                              Default 'dl', or 'figure' when the theme registers HTML5 gallery support.
	 *     @type string $icontag    HTML tag to use for each image's icon.
	 *                              Default 'dt', or 'div' when the theme registers HTML5 gallery support.
	 *     @type string $captiontag HTML tag to use for each image's caption.
	 *                              Default 'dd', or 'figcaption' when the theme registers HTML5 gallery support.
	 *     @type int    $columns    Number of columns of images to display. Default 3.
	 *     @type string $size       Size of the images to display. Default 'thumbnail'.
	 *     @type string $ids        A comma-separated list of IDs of attachments to display. Default empty.
	 *     @type string $include    A comma-separated list of IDs of attachments to include. Default empty.
	 *     @type string $exclude    A comma-separated list of IDs of attachments to exclude. Default empty.
	 *     @type string $link       What to link each image to. Default empty (links to the attachment page).
	 *                              Accepts 'file', 'none'.
	 * }
	 * @return string HTML content to display gallery.
	 */
	function mom_gallery_shortcode( $attr ) {

		global $post,$attr,$wp;
		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {

			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];

		}

		/**
		 * Filter the default gallery shortcode output.
		 *
		 * If the filtered output isn't empty, it will be used instead of generating
		 * the default gallery template.
		 *
		 * @since 2.5.0
		 *
		 * @see gallery_shortcode()
		 *
		 * @param string $output The gallery output. Default empty.
		 * @param array  $attr   Attributes of the gallery shortcode.
		 */
		$output = apply_filters( 'post_gallery', '', $attr );
		if ( $output != '' )
			return $output;

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {

			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );

		}

		$html5 = current_theme_supports( 'html5', 'gallery' );
		extract(shortcode_atts(array(

			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => $html5 ? 'figure'     : 'dl',
			'icontag'    => $html5 ? 'div'        : 'dt',
			'captiontag' => $html5 ? 'figcaption' : 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			'link'       => ''

		), $attr, 'gallery'));

		$id = intval( $id );
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();

			foreach ( $_attachments as $key => $val ) {

				$attachments[$val->ID] = $_attachments[$key];
			}

		} elseif ( !empty($exclude) ) {

			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		} else {

			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		}

		if ( empty($attachments) )
			return '';

		if ( is_feed() ) {

			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;

		}

		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$icontag = tag_escape($icontag);
		$valid_tags = wp_kses_allowed_html( 'post' );

		if ( ! isset( $valid_tags[ $itemtag ] ) )

			$itemtag = 'dl';

		if ( ! isset( $valid_tags[ $captiontag ] ) )

			$captiontag = 'dd';

		if ( ! isset( $valid_tags[ $icontag ] ) )

			$icontag = 'dt';

		$columns = intval($columns);
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = $gallery_div = '';

		/**
		 * Filter whether to print default gallery styles.
		 *
		 * @since 3.1.0
		 *
		 * @param bool $print Whether to print default gallery styles.
		 *                    Defaults to false if the theme supports HTML5 galleries.
		 *                    Otherwise, defaults to true.
		 */
		if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {

			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					border: 2px solid #cfcfcf;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
				/* see gallery_shortcode() in wp-includes/media.php */
			</style>\n\t\t";

		}

		$items = 0;
		foreach ( $attachments as $id => $attachment ) {

			$items++;

		}
		$div_length = ( $items * 150 ) . 'px';
		
		$size_class = sanitize_html_class( $size );
		$gallery_div = "<div id='$selector' class='horizontalGallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>
			<div style=\"width:" . $div_length . "\" class=\"innerGallery\">";

		/**
		 * Filter the default gallery shortcode CSS styles.
		 *
		 * @since 2.5.0
		 *
		 * @param string $gallery_style Default gallery shortcode CSS styles.
		 * @param string $gallery_div   Opening HTML div container for the gallery shortcode output.
		 */
		$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {

			if ( ! empty( $link ) && 'file' === $link )

				$image_output = wp_get_attachment_link( $id, $size, false, false );

			elseif ( ! empty( $link ) && 'none' === $link )

				$image_output = wp_get_attachment_image( $id, $size, false );

			else

				$image_output = wp_get_attachment_link( $id, $size, true, false );

			$image_meta  = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) )
		
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon {$orientation}'>
					$image_output
				</{$icontag}>";

			if ( $captiontag && trim($attachment->post_excerpt) ) {

				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";

			}

			$output .= "</{$itemtag}>";

			if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {

				$output .= '<br style="clear: both" />';

			}

		}

		$output .= "
			</div></div>\n";

		return $output;

	}
	
}




/**
*
* Admin Stylesheet
* Only enqueue it if we're browsing the admin page for My Optional Modules
*
*/
if( !function_exists( 'my_optional_modules_stylesheets' ) ) {

	function my_optional_modules_stylesheets( $hook ){

		if( 'settings_page_mommaincontrol' != $hook )
		return;
		wp_register_style( 'mom_admin_css', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/adminstyle/css.css' );
		wp_register_style( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'font_awesome' );
		wp_enqueue_style( 'mom_admin_css' );

	}

}

/**
*
* Font Awesome CSS enqueue
*
*/
if( !function_exists( 'my_optional_modules_font_awesome' ) ) {

	function my_optional_modules_font_awesome() {

		wp_register_style( 'font_awesome', plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'font_awesome' );

	}

}

/**
*
* My Optional Modules stylesheet used throughout for the different modules
*
*/
if( !function_exists( 'my_optional_modules_main_stylesheet' ) ) {

	function my_optional_modules_main_stylesheet() {

		$myStyleFile = WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules05568.css';
		wp_register_style( 'my_optional_modules', $myStyleFile );
		wp_enqueue_style( 'my_optional_modules' );

	}

}

// http://davidwalsh.name/wordpress-ajax-comments
function mom_ajaxComment( $comment_ID, $comment_status ) {

	if( isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && 'xmlhttprequest' == strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) ) {

		$comment = get_comment($comment_ID);
		$commentContent = getCommentHTML($comment);

		wp_notify_postauthor( $comment_ID, $comment->comment_type );


		die( $commentContent );

	}

}	

// RSS feed (link back)
if( !function_exists( 'myoptionalmodules_rsslinkback' ) ) { 

	function myoptionalmodules_rsslinkback($content){

		global $post;
		return $content . '<p><a href="' . esc_url( get_permalink( $post->ID ) ) . '">'.htmlentities( get_post_field( 'post_title', $post->ID ) ) . '</a> via <a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'site_name' ) . '</a></p>';
	}

}

// JS to Footer (moves javascript to footer)
if( !function_exists( 'myoptionalmodules_footerscripts' ) ) {

	function myoptionalmodules_footerscripts(){

		remove_action( 'wp_head','wp_print_scripts' );
		remove_action( 'wp_head','wp_print_head_scripts',9 );
		remove_action( 'wp_head','wp_enqueue_scripts',1 );

	}

}

// Disable Authors (archives)(if there is only 1 author on the blog)
if( !function_exists( 'myoptionalmodules_disableauthorarchives' ) ) {

	function myoptionalmodules_disableauthorarchives(){

		global $wp_query;

		if( is_author() ) {

			if( sizeof( get_users( 'who=authors' ) ) ===1 )
			wp_redirect( get_bloginfo( 'url' ) );

		}

	}

}

// Disable Date (based archives)
if( !function_exists( 'myoptionalmodules_disabledatearchives' ) ) {

	function myoptionalmodules_disabledatearchives(){

		global $wp_query;

		if( is_date() || is_year() || is_month() || is_day() || is_time() || is_new_day() ) {

			$homeURL = esc_url( home_url( '/' ) );
			if( have_posts() ):the_post();
			header( 'location:' . $homeURL );
			exit;
			endif;

		}

	}

}

if( !function_exists( 'myoptionalmodules_excludecategories' ) ) {

	function myoptionalmodules_excludecategories(){

		global $user_level, $mommodule_exclude;

		if( $mommodule_exclude == 1 ) {
			
			$MOM_Exclude_level0Categories  = get_option( 'MOM_Exclude_Categories_level0Categories' ); 
			$MOM_Exclude_level1Categories  = get_option( 'MOM_Exclude_Categories_level1Categories' ); 
			$MOM_Exclude_level2Categories  = get_option( 'MOM_Exclude_Categories_level2Categories' ); 
			$MOM_Exclude_level7Categories  = get_option( 'MOM_Exclude_Categories_level7Categories' ); 
			$loggedOutCats                 = 0;
			
			if( '' == $MOM_Exclude_level0Categories ) $MOM_Exclude_level0Categories = 0;
			if( '' == $MOM_Exclude_level1Categories ) $MOM_Exclude_level1Categories = 0;
			if( '' == $MOM_Exclude_level2Categories ) $MOM_Exclude_level2Categories = 0;
			if( '' == $MOM_Exclude_level7Categories ) $MOM_Exclude_level7Categories = 0;

			if( 0 == $user_level ) $loggedOutCats = $MOM_Exclude_level0Categories . ',' . $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			if( 1 == $user_level ) $loggedOutCats = $MOM_Exclude_level1Categories . ',' . $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			if( 2 == $user_level ) $loggedOutCats = $MOM_Exclude_level2Categories . ',' . $MOM_Exclude_level7Categories;
			if( 7 == $user_level ) $loggedOutCats = $MOM_Exclude_level7Categories;
			
			$c1 = explode( ',', $loggedOutCats );
			foreach( $c1 as &$C1 ){ $C1 = $C1 . ','; }
			$c_1 = rtrim( implode( $c1 ), ',' );
			$c11 = explode( ',', str_replace( ' ', '', $c_1 ) );
			$c11array = array( $c11 );
			$loggedOutCats = array_filter( $c11 );

		}

		$category_ids = mom_get_all_category_ids();

		foreach( $category_ids as $cat_id ) {

			if( $loggedOutCats ) {

				if( in_array( $cat_id, $loggedOutCats ) )continue;

			}

			$cat  = get_category( $cat_id );
			$link = get_category_link( $cat_id );

			echo '<li><a href="' . $link . '" title="link to ' . $cat->name . '">' . $cat->name . '</a></li>';

		}

	}

}

if( !function_exists( 'myoptionalmodules_postasfront' ) ) {

	function myoptionalmodules_postasfront(){

		if( is_home() ) {

			if( 'off' == get_option('mompaf_post' ) ) {

			} elseif( is_numeric( get_option( 'mompaf_post' ) ) ) {

				$mompaf_front = get_option( 'mompaf_post' );

			} elseif( get_option( 'mompaf_post' ) == 'on' ) {

				$mompaf_front = '';

			}

			if( have_posts() ):the_post();
			header('location:' . esc_url( get_permalink( $mompaf_front) ) ); 
			exit; 
			endif;

		}

	}

}

if( !function_exists( 'myoptionalmodules_removeversion' ) ) {

	function myoptionalmodules_removeversion( $src ){

		if( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) { 

			$src = remove_query_arg( 'ver', $src );

		}

		return $src;

	}

}

if( !function_exists( 'myoptionalmodules_scripts' ) ) {

	function myoptionalmodules_scripts(){

		wp_enqueue_style( 'font_awesome', plugins_url() . '/' . plugin_basename( dirname( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );

	}

}

if( !function_exists( 'myoptionalmodules_postformats' ) ) {

	function myoptionalmodules_postformats(){

		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	}

}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

if( current_user_can( 'manage_options' ) ) {

	if( isset( $_POST[ 'MOM_UNINSTALL_EVERYTHING' ] ) ) {

		$option = array( 

			'mommaincontrol_protectrss',
			'mommaincontrol_footerscripts',
			'mommaincontrol_authorarchives',
			'mommaincontrol_datearchives',
			'mommaincontrol_comments',
			'mommaincontrol_dnsbl',
			'MOM_themetakeover_ajaxcomments',
			'MOM_themetakeover_horizontal_galleries',
			'mommaincontrol_momse',
			'mommaincontrol_fontawesome',
			'mommaincontrol_lazyload',
			'mommaincontrol_versionnumbers',
			'mompaf_post',
			'MOM_Exclude_PostFormats_Visitor',
			'MOM_Exclude_PostFormats_RSS',
			'MOM_Exclude_PostFormats_Front',
			'MOM_Exclude_PostFormats_CategoryArchives',
			'MOM_Exclude_PostFormats_TagArchives',
			'MOM_Exclude_PostFormats_SearchResults',
			'MOM_Exclude_Categories_Front',
			'MOM_Exclude_Categories_TagArchives',
			'MOM_Exclude_Categories_SearchResults',
			'MOM_Exclude_Categories_RSS',
			'MOM_Exclude_Tags_RSS',
			'MOM_Exclude_Tags_Front',
			'MOM_Exclude_Tags_CategoryArchives',
			'MOM_Exclude_Tags_SearchResults',
			'MOM_Exclude_PostFormats_Front',
			'MOM_Exclude_PostFormats_CategoryArchives',
			'MOM_Exclude_PostFormats_TagArchives',
			'MOM_Exclude_PostFormats_SearchResults',
			'MOM_Exclude_PostFormats_Visitor',
			'MOM_Exclude_PostFormats_RSS',
			'MOM_Exclude_Tags_Tags',
			'MOM_Exclude_Categories_Categories',
			'MOM_Exclude_Categories_level0Categories',
			'MOM_Exclude_Categories_level1Categories',
			'MOM_Exclude_Categories_level2Categories',
			'MOM_Exclude_Categories_level7Categories',
			'MOM_Exclude_Tags_level0Tags',
			'MOM_Exclude_Tags_level1Tags',
			'MOM_Exclude_Tags_level2Tags',
			'MOM_Exclude_Tags_level7Tags'

		);

		foreach( $option as &$value ) {

			delete_option( $value );

		}

	} else {

		if( isset( $_POST[ 'mom_protectrss_mode_submit' ] ) ) {

			update_option('mommaincontrol_protectrss',$_REQUEST['protectrss']);

		}

		if( isset( $_POST[ 'mom_footerscripts_mode_submit' ] ) ) {
		
			update_option('mommaincontrol_footerscripts',$_REQUEST['footerscripts']);

		}

		if( isset( $_POST[ 'mom_author_archives_mode_submit' ] ) ) { 

			update_option('mommaincontrol_authorarchives',$_REQUEST['authorarchives']);

		}

		if( isset( $_POST[ 'mom_date_archives_mode_submit' ] ) ) { 

			update_option('mommaincontrol_datearchives',$_REQUEST['datearchives']);

		}

		if( isset( $_POST[ 'mom_comments_mode_submit' ] ) ) { 

			update_option('mommaincontrol_comments',$_REQUEST['comments']);

		}

		if( isset( $_POST[ 'mom_dnsbl_mode_submit' ] ) ) {

			update_option('mommaincontrol_dnsbl',$_REQUEST['dnsbl']);

		}

		if( isset( $_POST[ 'mom_ajax_comments_mode_submit' ] ) ) { 

			update_option('MOM_themetakeover_ajaxcomments',$_REQUEST['ajaxify']);

		}

		if( isset( $_POST[ 'mom_exclude_mode_submit' ] ) ) { 

			update_option('mommaincontrol_momse',$_REQUEST['exclude']);

		}		

		if( isset( $_POST[ 'mom_horizontal_galleries_mode_submit' ] ) ) { 

			update_option('MOM_themetakeover_horizontal_galleries',$_REQUEST['hgalleries']);

		}

		if( isset( $_POST[ 'mom_fontawesome_mode_submit' ] ) ) { 

			update_option('mommaincontrol_fontawesome',$_REQUEST['mommaincontrol_fontawesome']);

		}
		
		if( isset( $_POST[ 'mom_lazy_mode_submit' ] ) ) { 

			update_option('mommaincontrol_lazyload',$_REQUEST['mommaincontrol_lazyload']);

		}
		
		if( isset( $_POST[ 'mom_versions_submit' ] ) ) { 

			update_option('mommaincontrol_versionnumbers',$_REQUEST['mommaincontrol_versionnumbers']);

		}

		if( !get_option( 'mommaincontrol_mompaf' ) ) {

			add_option( 'mompaf_post', 'off' );

		}

		if( isset( $_POST[ 'mom_postasfront_post_submit' ] ) ) {

			update_option( 'mompaf_post', $_REQUEST[ 'mompaf_post' ] );

		}

		add_option( 'mompaf_post', 'off' );

	}
	
	if( isset( $_POST[ 'momsesave' ] ) ) {

		foreach( $_REQUEST as $k => $v ) {
			update_option( $k, $v );
		}

		update_option( 'MOM_Exclude_PostFormats_Visitor', sanitize_text_field( $_REQUEST[ 'MOM_Exclude_PostFormats_Visitor' ] ) );
		update_option( 'MOM_Exclude_PostFormats_RSS', sanitize_text_field( $_REQUEST[ 'MOM_Exclude_PostFormats_RSS' ] ) );
		update_option( 'MOM_Exclude_PostFormats_Front', sanitize_text_field( $_REQUEST[ 'MOM_Exclude_PostFormats_Front' ] ) );
		update_option( 'MOM_Exclude_PostFormats_CategoryArchives', sanitize_text_field( $_REQUEST[ 'MOM_Exclude_PostFormats_CategoryArchives' ] ) );
		update_option( 'MOM_Exclude_PostFormats_TagArchives', sanitize_text_field( $_REQUEST[ 'MOM_Exclude_PostFormats_TagArchives' ] ) );
		update_option( 'MOM_Exclude_PostFormats_SearchResults', sanitize_text_field( $_REQUEST[ 'MOM_Exclude_PostFormats_SearchResults' ] ) );

	}	
}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

if(current_user_can('manage_options')){
	// Add options page for plugin to Wordpress backend
	add_action('admin_menu','my_optional_modules_add_options_page');
	function my_optional_modules_add_options_page(){
		add_options_page('My Optional Modules','My Optional Modules','manage_options','mommaincontrol','my_optional_modules_page_content'); 
	}

	// Content to display on the options page
	function my_optional_modules_page_content(){ ?>

	<div class="MOMSettings">
		<div class="setting">
		<h2>My Optional Modules</h2>
		[<a href="//wordpress.org/support/view/plugin-reviews/my-optional-modules">rate/review</a>] 
		[<a href="//wordpress.org/support/plugin/my-optional-modules">support</a>]
		</div>
		<hr />
		<div class="setting">
			<?php if( !isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
				<form method="post" action="" name="mom_delete_step_one">
				<label for="mom_delete_step_one">Initiate uninstall of My Optional Modules <i class="fa fa-exclamation"></i></label>
				<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hidden" value="Submit" />
				</form>
			<?php } ?>
			<?php if( isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
				<form method="post" action="" name="MOM_UNINSTALL_EVERYTHING">
				<label for="MOM_UNINSTALL_EVERYTHING">Confirm uninstall &mdash; Cannot be undone <i class="fa fa-exclamation-triangle"></i></label>
				<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hidden" value="Submit" />
				</form>
			<?php } ?>			
		</div>
		<hr />
		<div class="setting">
			<form method="post" action="">
				<section class="clear">
					<label>Set a blog post as your front page</label>
					<select name="mompaf_post" id="mompaf_0">
						<option value="off"<?php if ( get_option('mompaf_post') == 'off' ) { ?> selected="selected"<?php } ?>>Disabled</option>
						<option value="on"<?php if ( get_option('mompaf_post') == 'on') { ?> selected="selected"<?php } ?>/>Latest post</option>
							<?php $mompaf_post = get_option('mompaf_post');
							selected( $options['mompaf_post'], 0 );
							$showmeposts = get_posts(array('posts_per_page' => -1));
							foreach($showmeposts as $postsshown){ ?>
								<option name="mompaf_post" id="mompaf_'<?php echo $postsshown->ID; ?>" value="<?php echo $postsshown->ID; ?>"
								<?php $postID = $postsshown->ID;
								$selected = selected( $mompaf_post, $postID); ?>
								><?php echo $postsshown->post_title; ?></option>
						<?php } ?>
					</select>
				</section>
				<input type="submit" id="mom_postasfront_post_submit" name="mom_postasfront_post_submit" value="Set it!" class="clear">
			</form>
		</div>
		<hr />
		<div class="setting">
		<?php global $table_prefix, $wpdb;
		if( isset($_POST[ 'delete_unused_terms' ] ) || isset( $_POST[ 'delete_post_revisions' ] ) || isset( $_POST[ 'delete_unapproved_comments' ] ) || isset( $_POST[ 'deleteAllClutter' ] ) ) {
			$postsTable = $table_prefix.'posts';
			$commentsTable = $table_prefix.'comments';
			$termsTable2 = $table_prefix.'terms';
			$termsTable = $table_prefix.'term_taxonomy';
			if( isset( $_POST[ 'delete_post_revisions' ] ) ) {
				$wpdb->query("DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");
			}
			if( isset ($_POST[ 'delete_unapproved_comments' ] ) ) {
				$wpdb->query("DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
			}
			if( isset( $_POST[ 'delete_unused_terms' ] ) ) {
				$wpdb->query("DELETE FROM `$termsTable2` WHERE `term_id` IN (select `term_id` from `$termsTable` WHERE `count` = 0)");
				$wpdb->query("DELETE FROM `$termsTable` WHERE `count` = 0");
			}
			if( isset( $_POST[ 'deleteAllClutter' ] ) ) {
				$wpdb->query("DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");
				$wpdb->query("DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
				$wpdb->query("DELETE FROM `$termsTable2` WHERE `term_id` IN (select `term_id` from `$termsTable` WHERE `count` = 0)");
				$wpdb->query("DELETE FROM `$termsTable` WHERE `count` = 0");
			}
		}		
		$revisions_count = $comments_count = $terms_count = 0;
		$postsTable      = $table_prefix . 'posts';
		$commentsTable   = $table_prefix . 'comments';
		$termsTable2     = $table_prefix . 'terms';
		$termsTable      = $table_prefix . 'term_taxonomy';
		$revisions_total = $wpdb->get_results ( "SELECT ID FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_type` = 'auto_draft' OR `post_status` = 'trash'" );
		$comments_total  = $wpdb->get_results ( "SELECT comment_ID FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
		$terms_total     = $wpdb->get_results ( "SELECT term_taxonomy_id FROM `$termsTable` WHERE `count` = '0'" );
		if( count( $revisions_total ) ) { 
			foreach ( $revisions_total as $retot ) { 
				$revisions_count++; 
			}
		}
		if( count( $comments_total ) ) {
			foreach ( $comments_total as $comtot ) { 
				$comments_count++; 
			}
		}
		if( count( $terms_total ) ) {
			foreach ( $terms_total as $termstot  ) {
				$terms_count++; 
			}
		}
		$totalClutter    = ( $terms_count + $comments_count + $revisions_count ); ?>
			<form method="post">
			<label for="deleteAllClutter">Clear <u>all</u> database clutter<i class="fa fa-trash-o"> <?php echo esc_attr( $totalClutter );?></i></label>
			<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
			</form>
			<form method="post">
			<label for="delete_post_revisions">
				Clear <u>post</u> clutter
				<i class="fa fa-trash-o"> <?php echo esc_attr ( $revisions_count );?></i>
			</label>
			<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
			</form>
			<form method="post">
			<label for="delete_unapproved_comments">
				Clear <u>comment</u> clutter
				<i class="fa fa-trash-o"> <?php echo esc_attr ( $comments_count );?></i>
			</label>
			<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
			</form>
			<form method="post">
			<label for="delete_unused_terms">
				Clear <u>taxonomy</u> clutter
				<i class="fa fa-trash-o"> <?php echo esc_attr ( $terms_count );?></i>
			</label>
			<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
			</form>
		</div>
		<hr />
		<div class="setting">
			<p>
				<em>Simple Modules</em> &mdash; enable or disable individual modules<br />
				<em>key</em> &mdash; <i class="fa fa-toggle-off"> off</i> &mdash; <i class="fa fa-toggle-on"> on</i>
			</p>
			<hr />
			<form method="post" action="" name="momComments">
				<label for="mom_comments_mode_submit">Disable comments site-wide
				<?php if( 1 == get_option( 'mommaincontrol_comments' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_comments' ) ){ echo 0; } else { echo 1; }?>" name="comments" />
				<input type="submit" id="mom_comments_mode_submit" name="mom_comments_mode_submit" value="Submit" class="hidden" />
				</form>

			<form method="post" action="" name="momDNSBL">
				<label for="mom_dnsbl_mode_submit">DNSBL Comment Blocking
				<?php if( 1 == get_option( 'mommaincontrol_dnsbl' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_dnsbl' ) ){ echo 0; } else { echo 1; }?>" name="dnsbl" />
				<input type="submit" id="mom_dnsbl_mode_submit" name="mom_dnsbl_mode_submit" value="Submit" class="hidden" />
				</form>

			<form method="post" action="" name="momAjaxComments">
				<label for="mom_ajax_comments_mode_submit">Ajaxify Comments 
				<?php if( 1 == get_option( 'MOM_themetakeover_ajaxcomments' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_themetakeover_ajaxcomments' ) ){ echo 0; } else { echo 1; }?>" name="ajaxify" />
				<input type="submit" id="mom_ajax_comments_mode_submit" name="mom_ajax_comments_mode_submit" value="Submit" class="hidden" />
				</form>

			<form method="post" action="" name="momHorizontalGalleries">
				<label for="mom_horizontal_galleries_mode_submit">Horizontal Galleries
				<?php if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ){ echo 0; } else { echo 1; }?>" name="hgalleries" />
				<input type="submit" id="mom_horizontal_galleries_mode_submit" name="mom_horizontal_galleries_mode_submit" value="Submit" class="hidden" />
				</form>				
				
				<form method="post" action="" name="protectrss">
					<label for="mom_protectrss_mode_submit">Append link-back on RSS items
					<?php if( 1 == get_option( 'mommaincontrol_protectrss' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_protectrss' ) ) { echo 0; } else { echo 1; } ?>" name="protectrss" />
					<input type="submit" id="mom_protectrss_mode_submit" name="mom_protectrss_mode_submit" value="Submit" class="hidden" />
				</form>				
				<form method="post" action="" name="fontawesome">
					<label for="mom_fontawesome_mode_submit">Enable Font Awesome
					<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_fontawesome" />
					<input type="submit" id="mom_fontawesome_mode_submit" name="mom_fontawesome_mode_submit" value="Submit" class="hidden" />
				</form>				
				<form method="post" action="" name="hidewpversions">
					<label for="mom_versions_submit">Hide WordPress version from source-code
					<?php if( 1 == get_option( 'mommaincontrol_versionnumbers' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_versionnumbers' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_versionnumbers" />
					<input type="submit" id="mom_versions_submit" name="mom_versions_submit" value="Submit" class="hidden" />
				</form>				
				<form method="post" action="" name="footerscripts">
					<label for="mom_footerscripts_mode_submit">Move .js to footer
					<?php if( 1== get_option( 'mommaincontrol_footerscripts' ) ){ ?>
						<i class="fa fa-toggle-on"></i>
					<?php }else{ ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_footerscripts' ) ) { echo 0; } else { echo 1; } ?>" name="footerscripts" />
					<input type="submit" id="mom_footerscripts_mode_submit" name="mom_footerscripts_mode_submit" value="Submit" class="hidden" />
				</form>
				<form method="post" action="" name="lazyload">
					<label for="mom_lazy_mode_submit">Lazy Load for post images
					<?php if( 1 == get_option( 'mommaincontrol_lazyload' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?></label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_lazyload' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_lazyload" />
					<input type="submit" id="mom_lazy_mode_submit" name="mom_lazy_mode_submit" value="Submit" class="hidden" />
				</form>
				<form method="post" action="" name="authorarchives">
					<label for="mom_author_archives_mode_submit">Disable Author-based archives
					<?php if( 1 == get_option( 'mommaincontrol_authorarchives' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_authorarchives' ) ) { echo 0; } else { echo 1; } ?>" name="authorarchives" />
					<input type="submit" id="mom_author_archives_mode_submit" name="mom_author_archives_mode_submit" value="Submit" class="hidden" />
				</form>
				<form method="post" action="" name="datearchives">
					<label for="mom_date_archives_mode_submit">Disable Date-based archives
					<?php if( 1 == get_option( 'mommaincontrol_datearchives' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_datearchives' ) ) { echo 0; } else { echo 1; } ?>" name="datearchives" />
					<input type="submit" id="mom_date_archives_mode_submit" name="mom_date_archives_mode_submit" value="Submit" class="hidden" />
				</form>
		</div>
		<hr />
		<div class="setting">
				<div class="clear"><i class="fa fa-code"></i> <code>[mom_miniloop]</code>  inserts a loop of posts via shortcode.</div>
				<span><code>meta=""</code>: a meta-key name.<br /></span>
				<span><code>key=""</code>: a meta-key value.<br /></span>
				<span><code>paging=""</code>: <em>1</em> to turn on, <em>0</em> to turn off.<br /></span>
				<span><code>show_link=""</code>: <em>1</em> to turn on, <em>0</em> to turn off.<br /></span>
				<span><code>link_content=""</code>: Text of the permalink to the post.<br /></span>
				<span><code>amount=""</code>: How many posts to show in the loop.<br /></span>
				<span><code>style=""</code>: <em>columns, list, slider, tiled</em><br /></span>
				<span><code>offset=""</code>: How many posts to skip ahead in the loop.<br /></span>
				<span><code>category=""</code>: Category ID(s) or names (comma-separated if multiple values).<br /></span>
				<span><code>orderby=""</code>: Order posts in the loop by a <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">particular value</a>.<br /></span>
				<span><code>order=""</code>: <em>ASC</em> (ascending) or <em>DESC</em> (descending)<br /></span>
				<span><code>post_status=""</code>: Display posts based on their <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Status_Parameters">status</a>.<br /></span>
				<span><code>year=""</code>: A 4-digit year to pull posts from. (<em>123</em> for current year)<br /></span>
				<span><code>month=""</code>: A 1-2 digit month to pull posts from. (1-12). (<em>123</em> for current month)<br /></span>
				<span><code>day=""</code>: A 1-2 digit day to pull posts from. (1-31). (<em>123</em> for current day)<br /></span>
				<span><code>cache=""</code>: Cache the results of this loop. <em>true</em> or <em>false</em>.<br /></span>
		
		</div>
		<hr />
		<div class="setting">
			<p>
				<em>Advanced Modules</em> &mdash; these modules may have additional options to set<br />
				<em>key</em> &mdash; <i class="fa fa-toggle-off"> off</i> &mdash; <i class="fa fa-toggle-on"> on</i>
			</p>
			<hr />		
			<form method="post" action="" name="momExclude">
				<label for="mom_exclude_mode_submit">Enable Post Exclusion
				<?php if( 1 == get_option( 'mommaincontrol_momse' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_momse' ) ){ echo 0; } else { echo 1; }?>" name="exclude" />
				<input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" />
				</form>				
		</div>
		<?php if( 1 == get_option( 'mommaincontrol_momse' ) ) { ?>
			<hr />
			<div class="setting">
			<?php 
			$MOM_Exclude_PostFormats_RSS = get_option('MOM_Exclude_PostFormats_RSS');
			$MOM_Exclude_PostFormats_Front = get_option('MOM_Exclude_PostFormats_Front');
			$MOM_Exclude_PostFormats_CategoryArchives = get_option('MOM_Exclude_PostFormats_CategoryArchives');
			$MOM_Exclude_PostFormats_TagArchives = get_option('MOM_Exclude_PostFormats_TagArchives');
			$MOM_Exclude_PostFormats_SearchResults = get_option('MOM_Exclude_PostFormats_SearchResults');
			$MOM_Exclude_PostFormats_Visitor = get_option('MOM_Exclude_PostFormats_Visitor');
			$showmepages = get_pages(); 			
			$showmecats = get_categories('taxonomy=category&hide_empty=0'); 
			$showmetags = get_categories('taxonomy=post_tag&hide_empty=0');
			echo '
			<form method="post" class="clear">
				<section class="clear">
				<p><strong class="sectionTitle">Hide Categories from..</strong></p>
				<div class="list"><span>Category (<strong>ID</strong>)</span>';
				foreach($showmecats as $catsshown){
					echo '
					<span>'.$catsshown->cat_name.'<em>'.$catsshown->cat_ID.'</em></span>';
				}
			echo '</div><div class="rightContainer">';
			$exclude = array('MOM_Exclude_Categories_RSS','MOM_Exclude_Categories_Front','MOM_Exclude_Categories_TagArchives','MOM_Exclude_Categories_SearchResults','MOM_Exclude_Categories_CategoriesSun','MOM_Exclude_Categories_CategoriesMon','MOM_Exclude_Categories_CategoriesTue','MOM_Exclude_Categories_CategoriesWed','MOM_Exclude_Categories_CategoriesThu','MOM_Exclude_Categories_CategoriesFri','MOM_Exclude_Categories_CategoriesSat','MOM_Exclude_Categories_level0Categories','MOM_Exclude_Categories_level1Categories','MOM_Exclude_Categories_level2Categories','MOM_Exclude_Categories_level7Categories');
			$section = array( 'RSS','Front page','Tag archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
			foreach($exclude as $exc ) {
					$title = str_replace($exclude,$section,$exc);
					echo '<section><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
			}				
			echo '</div>
			</section>
			<section class="clear">
			<p><strong class="sectionTitle">Hide Tags from..</strong></p>
			<div class="list"><span>Tag (<strong>ID</strong>)</span>';
				foreach($showmetags as $tagsshown){
					echo '<span>'.$tagsshown->cat_name.'<em>'.$tagsshown->cat_ID.'</em></span>';
				}
			echo '</div><div class="rightContainer">';
			$exclude = array('MOM_Exclude_Tags_RSS','MOM_Exclude_Tags_Front','MOM_Exclude_Tags_CategoryArchives','MOM_Exclude_Tags_SearchResults','MOM_Exclude_Tags_TagsSun','MOM_Exclude_Tags_TagsMon','MOM_Exclude_Tags_TagsTue','MOM_Exclude_Tags_TagsWed','MOM_Exclude_Tags_TagsThu','MOM_Exclude_Tags_TagsFri','MOM_Exclude_Tags_TagsSat','MOM_Exclude_Tags_level0Tags','MOM_Exclude_Tags_level1Tags','MOM_Exclude_Tags_level2Tags','MOM_Exclude_Tags_level7Tags');
			$section = array( 'RSS','Front page','Category archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
			foreach($exclude as $exc ) {
					$title = str_replace($exclude,$section,$exc);
					echo '<section><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
			}				
			echo '</div>
			</section>
			<section class="clear">
				<p><strong class="sectionTitle">Hide Post Formats from..</strong></p>
				<select name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
					<option value="">RSS -> none</option>
					<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-aside'); echo '>RSS -> Aside</option>
					<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-gallery'); echo '>RSS -> Gallery</option>
					<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-link'); echo '>RSS -> Link</option>
					<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-image'); echo '>RSS -> Image</option>
					<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-quote'); echo '>RSS -> Quote</option>
					<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-status'); echo '>RSS -> Status</option>
					<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-video'); echo '>RSS -> Video</option>
					<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-audio'); echo '>RSS -> Audio</option>
					<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-chat'); echo '>RSS -> Chat</option>
				</select>
				<select name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
					<option value="">Front Page -> none</option>
					<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Front, 'post-format-aside'); echo '>Front Page -> Aside</option>
					<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Front,'post-format-gallery'); echo '>Front Page -> Gallery</option>
					<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Front,'post-format-link'); echo '>Front Page -> Link</option>
					<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Front,'post-format-image'); echo '>Front Page -> Image</option>
					<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Front,'post-format-quote'); echo '>Front Page -> Quote</option>
					<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Front,'post-format-status'); echo '>Front Page -> Status</option>
					<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Front,'post-format-video'); echo '>Front Page -> Video</option>
					<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Front,'post-format-audio'); echo '>Front Page -> Audio</option>
					<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Front,'post-format-chat'); echo '>Front Page -> Chat</option>
				</select>
				<select name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
					<option value="">Archives -> none</option>
					<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_CategoryArchives, 'post-format-aside'); echo '>Archives -> Aside</option>
					<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-gallery'); echo '>Archives -> Gallery</option>
					<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-link'); echo '>Archives -> Link</option>
					<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-image'); echo '>Archives -> Image</option>
					<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-quote'); echo '>Archives -> Quote</option>
					<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-status'); echo '>Archives -> Status</option>
					<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-video'); echo '>Archives -> Video</option>
					<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-audio'); echo '>Archives -> Audio</option>
					<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-chat'); echo '>Archives -> Chat</option>
				</select>
				<select name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
					<option value="">Tags -> none</option>
					<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-aside'); echo '>Tags -> Aside</option>
					<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-gallery'); echo '>Tags -> Gallery</option>
					<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-link'); echo '>Tags -> Link</option>
					<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-image'); echo '>Tags -> Image</option>
					<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-quote'); echo '>Tags -> Quote</option>
					<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-status'); echo '>Tags -> Status</option>
					<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-video'); echo '>Tags -> Video</option>
					<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-audio'); echo '>Tags -> Audio</option>
					<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-chat'); echo '>Tags -> Chat</option>
				</select>
				<select name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
					<option value="">Search -> none</option>
					<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-aside'); echo '>Search -> Aside</option>
					<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-gallery'); echo '>Search -> Gallery</option>
					<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-link'); echo '>Search -> Link</option>
					<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-image'); echo '>Search -> Image</option>
					<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-quote'); echo '>Search -> Quote</option>
					<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-status'); echo '>Search -> Status</option>
					<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-video'); echo '>Search -> Video</option>
					<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-audio'); echo '>Search -> Audio</option>
					<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-chat'); echo '>Search -> Chat</option>
				</select>
				<select name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
					<option value="">Logged out -> none</option>
					<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-aside'); echo '>Logged out -> Aside</option>
					<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-gallery'); echo '>Logged out -> Gallery</option>
					<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-link'); echo '>Logged out -> Link</option>
					<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-image'); echo '>Logged out -> Image</option>
					<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-quote'); echo '>Logged out -> Quote</option>
					<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-status'); echo '>Logged out -> Status</option>
					<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-video'); echo '>Logged out -> Video</option>
					<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-audio'); echo '>Logged out -> Audio</option>
					<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-chat'); echo '>Logged out -> Chat</option>
				</select>
			</section>
			<input id="momsesave" type="submit" value="Exclude them!" name="momsesave"></form>';?>		
			</div>
		<?php }?>
	</div>
	<?php 
	}
}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

/**
 *
 * Font Awesome shortcode
 * allows quick embedding of Font Awesome icons by using the following template:
 * [font-fa i="ICON"] where ICON is the name of an icon
 * For instance: RSS icon would be [font-fa i="rss"]
 * Full list of icons: //fortawesome.github.io/Font-Awesome/icons/
 * Appropriate icon names are sans the fa- (fa-child would simply be child, fa-empire would simply be empire, etc..)
 *
 */
if( !function_exists( 'font_fa_shortcode' ) ) {

	function font_fa_shortcode( $atts, $content = null ) {

		extract(

			shortcode_atts( array (

				"i" => ''

			), $atts )

		);

		$icon = esc_attr( $i );

		if( '' != $icon ) {

			$iconfinal = $icon;

		}

		ob_start();

		return '<i class="fa fa-' . $iconfinal . '"></i>';

		return ob_get_clean();

	}

}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

/**
 *
 * shortcode functionality
 *
 */
if( !function_exists( 'mom_miniloop_shortcode' ) ) { 

	function mom_miniloop_shortcode( $atts ) {
		
		/**
		 * Grab the current user's level set previously in the main plugin 
		 * for use in this shortcode(where necessary and called for)
		 */
		global $user_level, $paged,$post, $date_y, $date_m, $date_d;

		$thumbs        = '';
		$show_link     = '';
		$amount        = '';
		$downsize      = '';
		$offset        = '';
		$paging        = '';
		$related       = '';
		$year          = '';
		$month         = '';
		$day           = '';
		$link_content  = '';
		$style         = '';
		$category      = '';
		$orderby       = '';
		$order         = '';
		$post_status   = '';
		$cache_results = '';
		$meta          = '';
		$key           = '';
		$title         = '';
		
		/**
		 * Set up some default values that we can override later
		 */

		$maxposts       = get_option( 'posts_per_page' );
		$category_count = 0;
		$alt            = 0;
		$recent_count   = 0;
		$exclude_cats   = '';
		$related_class  = ' element';
		$series         = get_post_meta($post->ID, 'series', true);
		
		/**
		 * Shortcode attributes(to be set inside of the shortcode)
		 * [thumbs="1" show_link="1" amount="4" downsize="1"...]
		 * These attributes will be used as the default settings, which can be overridden by 
		 * attributes set inside of the shortcode.
		 */
		extract(

			shortcode_atts( array(
				
				'thumbs'        => 1,					// 1(yes) 0(no)	
				'show_link'     => 1,					// 1(yes) 0(no)
				'amount'        => 4,					// numerical value of how many posts to return in the loop
				'downsize'      => 1,					// 1(yes) 0(no) (downsize thumbnails image quality and size)
				'offset'        => 0,					// how many posts to offset 
				'paging'        => 0,					// Whether or not to page the results
				'related'       => 0,
				'year'          => '',					// numerical date (year) (ex: 2014,2013,2012,2011..)
				'month'         => '',					// numerical date (month) (ex: 1,2,3,4,5,6,7,8,9,10,11,12)
				'day'           => '',					// numerical date (day) (ex: 1,2,3,4,5,6,7,8,9,10,11,...)
				'exclude'       => '',                  // post IDs to exclude
				'link_content'  => '',					// alpha-numeric value for post content (defaults to post title) (ex: "Click me")
				'style'         => 'tiled',				// columns,slider,tiled,list
				'category'      => '',					// numerical ID(s) or category name(s) (multiple separated by commas) (do not mix the two)
				'orderby'       => 'post_date',			// none,ID,author,title,name,type,date,modified,parent,rand
				'order'         => 'DESC',				// DESC(descending) or ASC(ascending)
				'post_status'   => 'publish',			// publish,pending,draft,auto-draft,future,private,inherit,trash,any
				'cache_results' => false,				// true or false
				'meta'          => 'series',            // Posts with THIS meta key
				'key'           => '',                  // Post with THIS meta key VALUE
				'title'         => ''
				

			), $atts )

		);
		
		/**
		 * Escape shortcode attributes before passing them to the script
		 */
		$thumbs        = intval( $thumbs );
		$show_link     = intval( $show_link );
		$amount        = intval( $amount );
		$downsize      = intval( $downsize );
		$offset        = intval( $offset );
		$paging        = intval( $paging );
		$related       = intval( $related );
		$year          = intval( $year );
		$month         = intval( $month );
		$day           = intval( $day );
		$link_content  = sanitize_text_field( $link_content );
		$style         = sanitize_text_field( $style );
		$category      = sanitize_text_field( $category );
		$orderby       = sanitize_text_field( $orderby );
		$order         = sanitize_text_field( $order );
		$post_status   = sanitize_text_field( $post_status );
		$cache_results = sanitize_text_field( $cache_results );
		$meta          = sanitize_text_field( $meta );
		$key           = sanitize_text_field( $key );
		
		if( 123 == $year ) { 

			$year = $date_y;

		}
		if( 123 == $month ) { 

			$month = $date_m;

		}
		if( 123 == $day ) { 

			$day = $date_d;

		}
		
		if( $related ) {
			
			$related_class = ' sidebar';
			
		}


		if( $meta == strtolower( 'series' ) && $related != 1 ) {

			$key     = $series;
			$amount  = -1;
			$exclude = $post->ID;

		}
		
		if( $related ) {

			$amount  = -1;
			$exclude = $post->ID;
			$meta    = sanitize_text_field ( $meta );
			$key     = sanitize_text_field ( get_post_meta($post->ID, $meta, true) );

		}

		/**
		 * Set up our initial container for the miniloop
		 */
		if( 1 != $related ) {

			$open = '<div class="loopdeloopRotation loopdeloop_' . $style .'">';

		} else {

			echo '<div class="loopdeloopRotation loopdeloop_' . $style .'">';

		}

		/**
		 * Set up our arguments for the loops based on the shortcode attributes
		 * or presets (in case no attributes were specified in the shortcode)
		 * We'll need 4 total loops - two for categories specified by name (if we're drawing from specific
		 * categories), and two for categories specified by id (if we're drawing from specific categories)
		 * We'll need to then further differentiate between those as to whether or not we're 
		 * also excluding categories based on user levels.
		 */

		if( 1 == $paging ) {

			if( is_single() ) {
				
			}
		
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;

		}

		if( intval( $category ) ) {

			if( 1 == $paging ) {
			
				if( $key ) {

					$args = array(

						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category'         => $category,
						'orderby'          => $orderby,
						'order'            => $order,
						'post_type'        => 'post',
						'post_status'      => $post_status,
						'suppress_filters' => true,
						'cache_results'    => $cache_results,
						'year'             => $year,
						'monthnum'         => $month,
						'day'              => $day,
						'paged'            => $paged,
						'meta_query'       => array(
							array( 
								'key'     => $meta,
								'value'   => array( $key ),
								'compare' => 'IN',
							)
						)

					);
				

				} else {

					$args = array(

						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category'         => $category,
						'orderby'          => $orderby,
						'order'            => $order,
						'post_type'        => 'post',
						'post_status'      => $post_status,
						'suppress_filters' => true,
						'cache_results'    => $cache_results,
						'year'             => $year,
						'monthnum'         => $month,
						'day'              => $day,
						'paged'            => $paged,
						'meta_key'         => $meta

					);

				}

			} else {
				
				if( $key ) {

					$args = array(

						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category'         => $category,
						'orderby'          => $orderby,
						'order'            => $order,
						'post_type'        => 'post',
						'post_status'      => $post_status,
						'suppress_filters' => true,
						'cache_results'    => $cache_results,
						'year'             => $year,
						'monthnum'         => $month,
						'day'              => $day,
						'meta_query'       => array(
							array(

								'key'     => $meta,
								'value'   => array( $key ),
								'compare' => 'IN',

							)

						)

					);

				} else {
				
					$args = array(

						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category'         => $category,
						'orderby'          => $orderby,
						'order'            => $order,
						'post_type'        => 'post',
						'post_status'      => $post_status,
						'suppress_filters' => true,
						'cache_results'    => $cache_results,
						'year'             => $year,
						'monthnum'         => $month,
						'day'              => $day,
						'meta_key'         => $meta

					);
						
				}

			}

		} else {

			if( 1 == $paging ) {
					
				if( $key ) {
					
					$args = array(

						'post__not_in'     => array( $exclude ),
						'posts_per_page'   => $amount,
						'offset'           => $offset,
						'category_name'    => $category,
						'orderby'          => $orderby,
						'order'            => $order,
						'post_type'        => 'post',
						'post_status'      => $post_status,
						'suppress_filters' => true,
						'cache_results'    => $cache_results,
						'year'             => $year,
						'monthnum'         => $month,
						'day'              => $day,
						'paged'            => $paged,
						'meta_query'       => array(
								array(

									'key'     => $meta,
									'value'   => array( $key ),
									'compare' => 'IN',
								)

							)

						);				
					
					} else {
					
						$args = array(

							'post__not_in'     => array( $exclude ),
							'posts_per_page'   => $amount,
							'offset'           => $offset,
							'category_name'    => $category,
							'orderby'          => $orderby,
							'order'            => $order,
							'post_type'        => 'post',
							'post_status'      => $post_status,
							'suppress_filters' => true,
							'cache_results'    => $cache_results,
							'year'             => $year,
							'monthnum'         => $month,
							'day'              => $day,
							'paged'            => $paged,
							'meta_key'         => $meta

						);

					}
				} else {
					
					if( $key ) {

						$args = array(

							'post__not_in'     => array( $exclude ),
							'posts_per_page'   => $amount,
							'offset'           => $offset,
							'category_name'    => $category,
							'orderby'          => $orderby,
							'order'            => $order,
							'post_type'        => 'post',
							'post_status'      => $post_status,
							'suppress_filters' => true,
							'cache_results'    => $cache_results,
							'year'             => $year,
							'monthnum'         => $month,
							'day'              => $day,
							'meta_query'       => array(
								array( 
									'key'     => $meta,
									'value'   => array( $key ),
									'compare' => 'IN',
								)
							)

						);				
					
					} else {

						$args = array(

							'post__not_in'     => array( $exclude ),
							'posts_per_page'   => $amount,
							'offset'           => $offset,
							'category_name'    => $category,
							'orderby'          => $orderby,
							'order'            => $order,
							'post_type'        => 'post',
							'post_status'      => $post_status,
							'suppress_filters' => true,
							'cache_results'    => $cache_results,
							'year'             => $year,
							'monthnum'         => $month,
							'day'              => $day,
							'meta_key'         => $meta

						);

					}

				}

		}
		$myposts = get_posts( $args );
		
		if( $related ) {

			$post_counter = 0;

			foreach( $myposts as $post ) {

				$post_counter++;

			}

			if( $title && $post_counter ) {

				echo '<h2 class="loopdeloopTitle">' . $title . '</h2>';

			}

		}

		/**
		 * [style="slider"]
		 */
		if( $style == strtolower('slider') ) {

		if( 1 != $related ) {

			$open .= '<div class="loopdeloopSlideContainer inner"><div class="inner">';

			/**
			 * Count the number of posts returned from the loop.
			 * Since each thumbnail will be 500px in width, we can 
			 * safely assume that posts * 500px will give us a container 
			 * that is the right width to house all of the returned items
			 * for our inner container.
			 */
			$post_counter = 0;

			$open .= '<style>';

			foreach( $myposts as $post ) {

				$post_counter++;

			}

			$open .= '.loopdeloopRotation .inner { width:' . $post_counter * 500 . 'px; }</style>';

		} else {

			echo '<div class="loopdeloopSlideContainer inner"><div class="inner">';

			/**
			 * Count the number of posts returned from the loop.
			 * Since each thumbnail will be 500px in width, we can 
			 * safely assume that posts * 500px will give us a container 
			 * that is the right width to house all of the returned items
			 * for our inner container.
			 */
			$post_counter = 0;

			echo '<style>';

			foreach( $myposts as $post ) {

				$post_counter++;

			}

			echo '.loopdeloopRotation .inner { width:' . $post_counter * 500 . 'px; }</style>';
		
		}

		}

		/**
		 * [style="columns"]
		 */
		if( $style == strtolower( 'columns' ) ) {

			if( 1 != $related ) {

				$open .= '<div class="loopdeloopColumns"><div>';

			} else {

				echo '<div class="loopdeloopColumns"><div>';

			}

		}
		
		/**
		 * [style="list"]
		 */
		if( $style == strtolower( 'list' ) ) {
		
			if( 1 != $related ) {

				$open .= '<div class="loopdeloopList"><div>';

			} else {

				echo '<div class="loopdeloopList"><div>';

			}

		}

		/**
		 * [style="tiled"]
		 */
		if( $style == strtolower( 'tiled' ) ) {
		
		if( 1 != $related ) {

			$open .= '<div>';
		
		} else {

			echo '<div>';

		}

		}
		
		
		/**
		 * Start the loop
		 */
		query_posts( $args );
		
		if( 1 != $related ) {
			ob_start();
		}
		
		if( have_posts() ): while( have_posts()) : the_post();

		/**
		 * Set up any post information that can only be gathered while inside of the loop
		 */
		$id            = get_the_ID();
		$link_text     = '';
		$link          = esc_url( get_permalink( $id ) );
		$title         = get_the_title( $id );
		$date          = get_the_date();
		$comment_count = get_comments_number();
		$since         = mom_timesince( $date );
		$author        = get_the_author();

		/**
		 * Grab the category(s) associated with the post
		 */
		$categories = get_the_category( $id );
		$separator = ' ';
		$output = '';

		/**
		 * Set up link text, and determine whether or not to use custom link text
		 * [link_content="Click me!"] would result in links that say "Click me!"
		 * while the default is to just use the title of the post as the link text
		 */
		if( '' == $link_content ) {

			$link_text_text = get_the_title( $id );

		} else {
		
			$link_text_text = $link_content;

		}
		
		if( $show_link == 1 ) {

			$link_text = '<a class="mediaNotPresent" href="' . get_permalink( $id ) . '">' . $link_text_text . '</a>';

		}

		/**
		 * Determine what post number we're currently on relative to the amount of posts 
		 * in the loop; has nothing to do with the post's ID
		 */
		$recent_count++;

		
		/**
		 * Grab the thumbnail associated with the post, and then fetch an appropriate URL 
		 * based on whether we want the full image or a "downsized" image (thumbnail quality)
		 * [downsize="1"] for thumbnail quality, while default is full
		 */
		$media = get_post_meta( $id, 'media', true );
		$thumb_path = '';
		if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {

			$post_thumbnail_id = get_post_thumbnail_id( $id );
			
			if( $downsize == 1 ) {

				$thumb_array = image_downsize( $post_thumbnail_id, 'thumbnail' );
				$thumb_path = $thumb_array[0];	

			} else {

				$thumb_path = wp_get_attachment_url( get_post_thumbnail_id( $id ) );

			}

		}

		/**
		 * [style="list"]
		 */
		if( $style == strtolower( 'list' ) ) {

			echo '<section class="post' . $related_class . '"><div class="counter">' . $recent_count . '</div>';

				if( $thumb_path ) {

					echo '<div class="thumb"><img src="' . $thumb_path . '" /></div>';

				}

				echo '<div class="text"><span class="title"><a href="' . $link . '">' . $title . '</a></span>';
				
				if( 1 != $related ) {

					echo '<span class="author">posted <date title="' . $date . '">' . $since . '</date> by ' . $author . ' to ';

						if( $categories ) {

							foreach( array_slice( $categories, 0, 1 ) as $category ) {

								$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;

							}

						echo trim( $output, $separator );

						}

						echo '</span><span class="meta"><a href="' . $link . '">' . $comment_count . ' comments</a></span>';

				}
				
				echo '</div>
			</section>';

		}
		
		/**
		 * [style="columns"]
		 */
		if( $style == strtolower( 'columns' ) ) {

			echo '<div class="column' . $related_class . '"><div class="inner"';

			if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {

				echo ' style="background-image:url(\'' . $thumb_path . '\');"';

			}

			echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a><span class="link">' . $link_text . '<em><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"></a></em></span></div>';
			echo '</div>';

		}

		/**
		 * [style="slider"] 
		 */
		if( $style == strtolower( 'slider' ) ) {
		
				echo '<div class="slide"';
				if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {

					echo ' style="background-image:url(\'' . $thumb_path . '\');"';

				}			
				echo '><a class="mediaNotPresent" href="' . get_permalink( $id ) . '"><span class="title">'. $link_text_text . '</span></a></div>';

		}

		/**
		 * [style="tiled"] 
		 */
		if( $style == strtolower('tiled') ) {

			if( $recent_count == 1 ) {

				$container = 'feature';
				echo '<div class="feature">';

			}
			
			if( $recent_count == 2 ) {

				$container = 'second';
				echo '<div class="' . $container . '">';

			}
			
			if( $recent_count == 3 ) {

				$container = 'secondThird';
				echo '<div class="' . $container . '">';

			}
			
			if( $recent_count <= 4 ) {

				echo '<div class="thumbnailFull';

			}
			
			if( $recent_count == 2 ) {

				echo ' leftSmall';

			}

			if( $recent_count <= 4 ) {

				echo '"';

				if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {

					echo ' style="background-image:url(\'' . $thumb_path . '\');"';

				}
				
				echo '>';
				echo $link_text;

			}
			
			echo '</div>';
			if( $recent_count > 4 ) {

				if( $recent_count % 3 == 0 ) {

					$container = 'second leftSmall';

				} else {

					$container = 'secondThird';

				}

				echo '<div class="' . $container . '"><div class="thumbnailFull"';

				if( '' != wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
				
					$post_thumbnail_id = get_post_thumbnail_id( $id );
					
					if( $downsize == 1 ) {

						$thumb_array = image_downsize( $post_thumbnail_id, 'thumbnail' );
						$thumb_path = $thumb_array[0];	

					} else {

						$thumb_path = wp_get_attachment_url( get_post_thumbnail_id( $id ) );

					}
					
					echo ' style="background-image:url(\'' . $thumb_path . '\');"';
				}

				echo '>';
				echo $link_text . '</div>';
			}
			
			if( $recent_count == 4 ) {

				echo '</div></div>';

			}
			

		}


		/**
		 * End the loop
		 */
		endwhile;

		if( 1 == $paging ) {

			echo '<div class="loopdeloopNavigation">'; posts_nav_link('&#8734;','Previous','Next'); echo '</div>';

		}

		else;
		endif;

		/**
		 * Close all open containers associated with this miniloop
		 */
		if( 1 != $related ) {

			$close = '</div></div></div>';

		} else { 

			echo '</div></div></div>';

		}

		/**
		 * Reset all post data from previous loop
		 */
		wp_reset_query();
		
		if( 1 != $related ) {
			return $open . ob_get_clean() . $close;
		} else { }
		
	}

}

/**
 * Display a miniloop of posts from the blog based on shortcode parameters in
 * a variety of different styles. Can be used multiple times on the same page.
 */

add_filter( 'the_content', 'do_shortcode', 'mom_miniloop' );
add_shortcode( 'mom_miniloop', 'mom_miniloop_shortcode' );


/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */

if( current_user_can( 'manage_options' ) ) {

	$css = plugins_url() . '/' . plugin_basename( dirname( __FILE__ ) ) . '/includes/';

	add_action( 'wp_enqueue_admin_scripts', 'myoptionalmodules_scripts' );

	function momEditorScreen( $post_type ) {

		$screen         = get_current_screen();
		$edit_post_type = $screen->post_type;

		if( $edit_post_type != 'post' )
		if( $edit_post_type != 'page' )
		return;

		if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>

			<div class="momEditorScreen postbox">
				<h3>Font Awesome Icons</h3>
				<div class="inside">
					<style>
						ol#momEditorMenu {width:95%;margin:0 auto;overflow:auto;overflow-x:hidden;overflow-y:auto;height:200px}
						ol#momEditorMenu li {width:auto; margin:2px; float:left; list-style:none; display:block; padding:5px; line-height:20px; font-size:13px;}
						ol#momEditorMenu li span:hover {cursor:pointer; background-color:#fff; color:#4b5373;}
						ol#momEditorMenu li span {margin-right:5px; width:18px; height:19px; display:block; float:left; overflow:hidden; color: #fff; background-color:#4b5373; border-radius:3px; font-size:20px;}
						ol#momEditorMenu li.clear {clear:both; display:block; width:100%;}
						ol#momEditorMenu li.icon {width:18px; height:16px; overflow:hidden; font-size:20px; line-height:22px; margin:5px}
						ol#momEditorMenu li.icon:hover {cursor:pointer; color:#441515; background-color:#ececec; border-radius:3px;}
					</style>					
					<ol id="momEditorMenu">
						<li class="clear"></li>
						<?php $icon = array(
							'angellist','area-chart','at','bell-slash','bell-slash-o','bicycle','binoculars',
							'birthday-cake','bus','calculator','cc','cc-amex','cc-discover','cc-mastercard',
							'cc-paypal','cc-stripe','cc-visa','copyright','eyedropper','futbol-o','google-wallet',
							'ils','ioxhost','lastfm','lastfm-square','line-chart','meanpath','newspaper-o','paint-brush',
							'paypal','pie-chart','plug','shekel','sheqel','slideshare','soccer-ball-o','toggle-off',
							'toggle-on','trash','tty','twitch','wifi','yelp',
							'automobile','bank','behance','behance-square','bomb','building','cab','car','child','circle-o-notch','circle-thin','codepen',
							'cube','cubes','database','delicious','deviantart','digg','drupal','empire','envelope-square','fax','file-archive-o','file-audio-o',
							'file-code-o','file-excel-o','file-image-o','file-movie-o','file-pdf-o','file-photo-o',
							'file-picture-o','file-powerpoint-o','file-sound-o','file-video-o','file-word-o','file-zip-o',
							'ge','git','git-square','google','graduation-cap','hacker-news','header','history','institution',
							'joomla','jsfiddle','language','life-bouy','life-ring','life-saver','mortar-board','openid','paper-plane',
							'paper-plane-o','paragraph','paw','pied-piper','pied-piper-alt','qq','ra','rebel',
							'recycle','reddit','reddit-square','send','send-o','share-alt','share-alt-square','slack','sliders',
							'soundcloud','space-shuttle','spoon','spotify','steam','steam-square','stumbleupon','stumbleupon-circle',
							'support','taxi','tencent-weibo','tree','university','vine','wechat','weixin','wordpress','yahoo',
							'adjust','anchor','archive','arrows','arrows-h','arrows-v','asterisk',
							'ban','bar-chart-o','barcode','bars','beer','bell','bell-o','bolt','book',
							'bookmark','bookmark-o','briefcase','bug','building-o','bullhorn','bullseye',
							'calendar','calendar-o','camera','camera-retro','caret-square-o-down','caret-square-o-left',
							'caret-square-o-right','caret-square-o-up','certificate','check','check-circle','check-circle-o',
							'check-square','check-square-o','circle','circle-o','clock-o','cloud','cloud-download','cloud-upload',
							'code','code-fork','coffee','cog','cogs','comment','comment-o','comments','comments-o','compass','credit-card',
							'crop','crosshairs','cutlery','dashboard','edit','ellipsis-h','ellipsis-v','envelope','envelope-o','eraser',
							'exchange','exclamation','exclamation-circle','exclamation-triangle','external-link','external-link-square',
							'eye','eye-slash','female','fighter-jet','film','filter','fire','fire-extinguisher','flag','flag-checkered',
							'flag-o','flash','flask','folder','folder-o','folder-open','folder-open-o','frown-o','gamepad','gavel',
							'gear','gears','gift','glass','globe','group','hdd-o','headphones','heart','heart-o','home','inbox',
							'info','info-circle','key','keyboard-o','laptop','leaf','legal','lemon-o','level-down','level-up','lightbulb-o',
							'location-arrow','lock','magic','magnet','mail-forward','mail-reply','mail-reply-all','male','map-marker',
							'meh-o','microphone','microphone-slash','minus','minus-circle','minus-square','minus-square-o','mobile',
							'mobile-phone','money','moon-o','music','pencil','pencil-square','pencil-square-o','phone','phone-square',
							'picture-o','plane','plus','plus-circle','plus-square','plus-square-o','power-off','print','puzzle-piece',
							'qrcode','question','question-circle','quote-left','quote-right','random','refresh','reply','reply-all',
							'retweet','road','rocket','rss','rss-square','search','search-minus','search-plus','share','share-square',
							'share-square-o','shield','shopping-cart','sign-in','sign-out','signal','sitemap','smile-o','sort',
							'sort-alpha-asc','sort-alpha-desc','sort-amount-asc','sort-amount-desc','sort-asc','sort-desc','sort-down',
							'sort-numeric-asc','sort-numeric-desc','sort-up','spinner','square','square-o','star','star-half','star-half-empty',
							'star-half-full','star-half-o','star-o','subscript','suitcase','sun-o','superscript','tablet','tachometer','tag',
							'tags','tasks','terminal','thumb-tack','thumbs-down','thumbs-o-down','thumbs-o-up','thumbs-up','ticket','times',
							'times-circle','times-circle-o','tint','toggle-down','toggle-left','toggle-right','toggle-up','trash-o','trophy',
							'truck','umbrella','unlock','unlock-alt','unsorted','video-camera','volume-down','volume-off','volume-up',
							'warning','wheelchair','wrench','check-square','check-square-o','circle','circle-o','dot-circle-o',
							'minus-square','minus-square-o','plus-square','plus-square-o','square','square-o',
							'bitcoin','btc','cny','dollar','eur','euro','gbp','inr','jpy','krw','money','rmb','rouble','rub','ruble',
							'rupee','try','turkish-lira','usd','won','yen','align-center','align-justify','align-left','align-right',
							'bold','chain','chain-broken','clipboard','columns','copy','cut','dedent','eraser','file','file-o',
							'file-text','file-text-o','files-o','floppy-o','font','indent','italic','link','list','list-alt','list-ol',
							'list-ul','outdent','paperclip','paste','repeat','rotate-left','rotate-right','save','scissors','strikethrough',
							'table','text-height','text-width','th','th-large','th-list','underline','undo','unlink','angle-double-down',
							'angle-double-left','angle-double-right','angle-double-up','angle-down','angle-left','angle-right','angle-up',
							'arrow-circle-down','arrow-circle-left','arrow-circle-o-down','arrow-circle-o-left','arrow-circle-o-right',
							'arrow-circle-o-up','arrow-circle-right','arrow-circle-up','arrow-down','arrow-left','arrow-right','arrow-up',
							'arrows','arrows-alt','arrows-h','arrows-v','caret-down','caret-left','caret-right','caret-square-o-down',
							'caret-square-o-left','caret-square-o-right','caret-square-o-up','caret-up','chevron-circle-down',
							'chevron-circle-left','chevron-circle-right','chevron-circle-up','chevron-down','chevron-left','chevron-right',
							'chevron-up','hand-o-down','hand-o-left','hand-o-right','hand-o-up','long-arrow-down','long-arrow-left',
							'long-arrow-right','long-arrow-up','toggle-down','toggle-left','toggle-right','toggle-up','arrows-alt','backward',
							'compress','eject','expand','fast-backward','fast-forward','forward','pause','play','play-circle','play-circle-o',
							'step-backward','step-forward','stop','youtube-play','ambulance','h-square','hospital-o','medkit','plus-square',
							'stethoscope','user-md','wheelchair','adn','android','apple','bitbucket','bitbucket-square','bitcoin','btc','css3',
							'dribbble','dropbox','facebook','facebook-square','flickr','foursquare','github','github-alt','github-square','gittip',
							'google-plus','google-plus-square','html5','instagram','linkedin','linkedin-square','linux','maxcdn','pagelines',
							'pinterest','pinterest-square','renren','skype','stack-exchange','stack-overflow','trello','tumblr','tumblr-square',
							'twitter','twitter-square','vimeo-square','vk','weibo','windows','xing','xing-square','youtube','youtube-play',
							'youtube-square'
						);
						foreach ($icon as &$value){ ?>
							<li onclick="addText(event)" title="<i class='fa fa-<?php echo sanitize_text_field( $value );?>'></i>" class="fa fa-<?php echo sanitize_text_field( $value );?> icon"><span>&#60;i class="fa fa-<?php echo sanitize_text_field( $value );?>"&#62;&#60;/i&#62;</span></li>
						<?php } ?>
					</ol>
					<?php 
					 /**
					  * This function needs to be altered so that it adds the code at the cursor position, 
					  * instead of at the end of the text field as it does currently).
					  *
					  */
					?>
					<script>
						function addText(event){
							var targ = event.target || event.srcElement;
							document.getElementById("content").value += targ.textContent || targ.innerText;
						}
					</script>
				</div>
			</div>

		<?php }
	}	
	add_action( 'edit_form_after_editor','momEditorScreen' );
}

/**
 *
 * ---------------------------------------------------------------------------------------
 *
 */
