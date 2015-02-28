<?php 
/**
 * class.myoptionalmodules
 * These actions are enabled REGARDLESS of settings.
 * These are values that we need to grab and use throughout the plugin.
 */
 
if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

class myoptionalmodules {
	
	public $user_level, $ipaddress, $DNSBL;
	/**
	 * Add actions
	 *  - plugin dependent scripts
	 *  - font awesome
	 *  - plugin stylesheet
	 *  - admin stylesheet
	 *  - post formats
	 */
	function actions() {
		add_action  ( 'wp', array( $this, 'scripts' ) );
		add_action  ( 'admin_enqueue_scripts', array( $this, 'font_awesome' ) );
		if( 0 == get_option( 'mommaincontrol_enablecss' ) || !get_option( 'mommaincontrol_enablecss' ) ) {
			add_action  ( 'wp_print_styles', array( $this, 'plugin_stylesheets' ) );
		}
		add_action  ( 'admin_enqueue_scripts', array( $this, 'stylesheets' ) );
		add_action  ( 'after_setup_theme', array( $this, 'post_formats' ) );
	}
	function scripts(){
		if( 1 == get_option( 'mommaincontrol_lazyload' ) ) {
			function mom_jquery(){
				$lazyLoad          = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
				$lazyLoadFunctions = str_replace( array( 'https:', 'http:' ), '', esc_url( plugins_url().'/my-optional-modules/includes/javascript/lazyload.js' ) );
				wp_enqueue_script( 'lazyload', $lazyLoad, array( 'jquery' ) );
				wp_enqueue_script( 'lazyloadFunctions', $lazyLoadFunctions, array( 'jquery' ) );
			}
			add_action( 'wp_enqueue_scripts', 'mom_jquery' );
		}
	}
	function font_awesome() {
		$font_awesome_css = str_replace( array( 'https:', 'http:' ), '', esc_url( plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' ) );
		wp_register_style( 'font_awesome', $font_awesome_css );
		wp_enqueue_style( 'font_awesome' );
	}
	function plugin_stylesheets() {
		$myStyleFile = str_replace( array( 'https:', 'http:' ), '', esc_url( WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules.css' ) );
		wp_register_style( 'my_optional_modules', $myStyleFile );
		wp_enqueue_style( 'my_optional_modules' );
	}
	function stylesheets( $hook ){
		if( 'settings_page_mommaincontrol' != $hook )
		return;
		$font_awesome_css = str_replace( array( 'https:', 'http:' ), '', esc_url( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' ) );
		$mom_admin_css    = str_replace( array( 'https:', 'http:' ), '', esc_url( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/adminstyle/css.css' ) );
		wp_enqueue_style( 'mom_admin_css', $mom_admin_css );
		wp_enqueue_style( 'font_awesome',  $font_awesome_css );
	}
	function post_formats() {
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'gallery',
				'link',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat'
			)
		);
	}
	/**
	 * Fetch user level
	 *  - level 1 (subscriber)
	 *  - level 2 (author)
	 *  - level 3 (editor)
	 *  - level 4 (admin)
	 *  - level 0 (not logged in)
	 */
	function userlevel() {
		if( is_user_logged_in() ) {
			if( current_user_can( 'read' ) )                   $this->user_level = 1;
			if( current_user_can( 'delete_posts' ) )           $this->user_level = 2;
			if( current_user_can( 'delete_published_posts' ) ) $this->user_level = 3;
			if( current_user_can( 'edit_dashboard' ) )         $this->user_level = 4;
		} else {
			$this->user_level = 0;
		}
	}
	function validate_ip_address() {	
		/**
		 * Validate the IP address
		 * "This function converts a human readable IPv4 or IPv6 address
		 * (if PHP was built with IPv6 support enabled) into an address 
		 * family appropriate 32bit or 128bit binary structure."
		 * Read more at: //php.net/manual/en/function.inet-pton.php
		 */
		if( inet_pton( $_SERVER[ 'REMOTE_ADDR' ] ) === false ) {
			$this->ipaddress = false;
			/**
			 * If the IP address can't validate, treat it like it's hostile, and flag it 
			 * as being DNSBL listed (regardless of whether it actually is or isn't)
			 */
			$this->DNSBL = true;
		} else {
			// If the IP address DOES validate, pass it along for further analysis
			$this->ipaddress = esc_attr( $_SERVER[ 'REMOTE_ADDR' ] );
			$this->DNSBL = false;
		}

		// Check the IP address (if it was validated) against the DNSBL
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
				$reverse_ip=implode(".",array_reverse(explode(".",$this->ipaddress) ) );
				foreach($dnsbl_lookup as $host){
					if( checkdnsrr( $reverse_ip.".".$host.".","A" ) ) {
						$listed.=$reverse_ip.'.'.$host;
					}
				}
			}
			if( is_user_logged_in() && current_user_can( 'edit_dashboard' ) ) {
				$this->DNSBL == false;
			}
			elseif( $listed ) {
				// If the IP is listed on one of the blacklists, treat it as a hostile
				$this->DNSBL     === true;
				$this->ipaddress === false;
			} else {
				// If the IP was NOT listed on one of the blacklists, treat it as a friendly
				$this->DNSBL === false;
			}

	}

}