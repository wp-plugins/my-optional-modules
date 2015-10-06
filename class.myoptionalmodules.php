<?php 
/**
 * CLASS myoptionalmodules()
 *
 * File last update: 10.1.9
 *
 * Actions REQUIRED by the plugin (unless otherwise noted).
 * Regardless of settings, these actions will always run.
 *
 */

defined('MyOptionalModules') or exit;

class myoptionalmodules {
	
	public $user_level, $ipaddress, $DNSBL;
	
	function __construct() {

		$myoptionalmodules_plugincss = sanitize_text_field ( get_option ( 'myoptionalmodules_plugincss' ) );

		add_action ( 'wp', array( $this, 'scripts' ) );
		add_action ( 'admin_enqueue_scripts' , array ( $this , 'font_awesome' ) );
	
		if( 1 == $myoptionalmodules_plugincss ):
		else:
			add_action  ( 'wp_print_styles' , array ( $this , 'plugin_stylesheets' ) );
		endif;

	}

	// Enqueue scripts
	function scripts(){
		// JQUERY dependent
		function mom_jquery(){
			$myoptionalmodules_pluginshortcodes = sanitize_text_field ( get_option ( 'myoptionalmodules_pluginshortcodes' ) );
			$myoptionalmodules_pluginscript = sanitize_text_field ( get_option ( 'myoptionalmodules_pluginscript' ) );
			$myoptionalmodules_newwindow = sanitize_text_field ( get_option ( 'myoptionalmodules_newwindow' ) );
			if ( 1 == $myoptionalmodules_pluginscript ){
				$pluginfunctions = null;
			}else{
				$pluginfunctions   = mom_strip_protocol ( plugins_url() . '/my-optional-modules/includes/javascript/script.js' );
				wp_enqueue_script ( 'mom_plugin_functions' , $pluginfunctions , array ( 'jquery' ) );
			}
			if ( 1 == $myoptionalmodules_newwindow ){
				$hgalleryfunctions = null;
			}else{
				$hgalleryfunctions = mom_strip_protocol ( plugins_url() . '/my-optional-modules/includes/javascript/hgallery.js' );
				wp_enqueue_script ( 'mom_hgallery_functions' , $hgalleryfunctions , array ( 'jquery' ) );
			}
			if ( 1 == $myoptionalmodules_pluginshortcodes ){
				$hgalleryfunctions = $youtubefunctions = null;
			}else{
				$youtubefunctions  = mom_strip_protocol ( plugins_url() . '/my-optional-modules/includes/javascript/youtube.js' );
				wp_enqueue_script ( 'mom_youtube_functions' , $youtubefunctions , array ( 'jquery' ) );
			}
		}
		add_action( 'wp_enqueue_scripts' , 'mom_jquery' );
	}

	// Enqueue Font Awesome for ADMIN
	function font_awesome() {
		$font_awesome_css = mom_strip_protocol ( plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' );
		wp_register_style ( 'font_awesome' , $font_awesome_css );
		wp_enqueue_style  ( 'font_awesome' );
	}

	// Enqueue plugin CSS
	function plugin_stylesheets() {
		$myoptionalmodules_plugin_version = '10';
		$myStyleFile = mom_strip_protocol ( WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules' . $myoptionalmodules_plugin_version . '.css' );
		wp_register_style ( 'my_optional_modules' , $myStyleFile );
		wp_enqueue_style  ( 'my_optional_modules' );
	}

	// GET USER LEVELs for use throughout
	function userlevel() {
		if( is_user_logged_in() ) :
			if( current_user_can ( 'edit_dashboard' ) ):
				$this->user_level = 4; // Admin
			elseif( current_user_can ( 'delete_published_posts' ) ):
				$this->user_level = 3; // Editor
			elseif( current_user_can ( 'delete_posts' ) ):
				$this->user_level = 2; // Author
			elseif( current_user_can ( 'read' ) ):
				$this->user_level = 1; // Subscriber
			endif;
		else:
			$this->user_level = 0;
		endif;
	}

	// Validate an IP address and check against DNSBlacklists (if enabled)
	function validate_ip_address() {
		$myoptionalmodules_dnsbl = sanitize_text_field ( get_option ( 'myoptionalmodules_dnsbl' ) );
		
		if( $myoptionalmodules_dnsbl ) {
			/**
			 * Validate the IP address
			 * "This function converts a human readable IPv4 or IPv6 address
			 * (if PHP was built with IPv6 support enabled) into an address 
			 * family appropriate 32bit or 128bit binary structure."
			 * Read more at: //php.net/manual/en/function.inet-pton.php
			 */
			if( inet_pton ( $_SERVER[ 'REMOTE_ADDR' ] ) === false ) {
				$this->ipaddress = false;
				/**
				 * If the IP address can't validate, treat it like it's hostile, and flag it 
				 * as being DNSBL listed (regardless of whether it actually is or isn't)
				 */
				$this->DNSBL = true;
			} else {
				/**
				 * If the IP address DOES validate, pass it along for further analysis
				 */
				$this->ipaddress = esc_attr ( $_SERVER[ 'REMOTE_ADDR' ] );
				$this->DNSBL     = false;
			}
			/**
			 * Check the IP address (if it was validated) against the DNSBL
			 */
			$listed = 0;
			/**
			 * Blacklists to check
			 * Extensive list found here: //dnsbl.info/dnsbl-list.php
			 */
			$dnsbl_lookup=array(
				'dnsbl-1.uceprotect.net',
				'dnsbl-2.uceprotect.net',
				'dnsbl-3.uceprotect.net',
				'dnsbl.sorbs.net',
				'zen.spamhaus.org'
			);

			if( $this->ipaddress ) {
				$reverse_ip=implode ("." , array_reverse(explode ( "." , $this->ipaddress ) ) );
				foreach( $dnsbl_lookup as $host ) {
					if( checkdnsrr ( $reverse_ip . "." . $host . "." , "A" ) ) {
						$listed .= $reverse_ip . '.' . $host;
					}
				}
			}

			if( is_user_logged_in() && current_user_can ( 'edit_dashboard' ) ) {
				$this->DNSBL == false;
			}
			elseif( $listed ) {
				/**
				 * If the IP is listed on one of the blacklists, treat it as a hostile
				 */
				$this->DNSBL     === true;
				$this->ipaddress === false;
			} else {
				/**
				 * If the IP was NOT listed on one of the blacklists, treat it as a friendly
				 */
				$this->DNSBL === false;
			}

		}
	}
}

$myoptionalmodules_plugin = new myoptionalmodules();
$myoptionalmodules_plugin->userlevel();