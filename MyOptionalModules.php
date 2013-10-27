<?php
/*
Plugin Name: My Optional Modules
Plugin URI: http://www.onebillionwords.com/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 4.0.7
Author: One Billion Words
Author URI: http://onebillionwords.com
*/

	// LICENSE
	// This program is free software; you can redistribute it and/or modify
	// it under the terms of the GNU General Public License, version 2, as 
	// published by the Free Software Foundation.
	// 
	// This program is distributed in the hope that it will be useful,
	// but WITHOUT ANY WARRANTY; without even the implied warranty of
	// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	// GNU General Public License for more details.
	// 
	// You should have received a copy of the GNU General Public License
	// along with this program; if not, write to the Free Software
	// Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	// ADDITIONAL NOTES
	//	If you find any bugs, please: report them to me!  
	//	admin@onebillionwords.com (subject line: My Optional Modules bug).
	//	Your feedback and help is greatly appreciated.

	// CONTENTS
	//	Disallow individual file loading
	//	Activation hook for plugin
	//	Admin stylesheet enqueue
	//	Font awesome enqueue
	//	Hide version numbers from enqueue scripts and stylesheets
	//	Post as front redirection
	//	Google Analytics code injection
	//	Conditionally load modules; load main control panel for plugin

	// Disallow individual file loading
	define( 'MyOptionalModules', TRUE );
	
	// Activation hook for plugin
	register_activation_hook( __FILE__, "my_optional_modules_main_control_install" );
	function my_optional_modules_main_control_install() {
		add_option( 'mommaincontrol_focus','','Focus module' );
		add_option( 'mommaincontrol_obwcountplus','0','Count++ activated?' );
		add_option( 'mommaincontrol_momrups','0','RUPs activated?' );
		add_option( 'mommaincontrol_momse','0','Simply Exclude activated?' );
		add_option( 'mommaincontrol_mompaf','0','Post as Front activated?' );
		add_option( 'mommaincontrol_momja','0','Jump Around activated?' );
		add_option( 'mommaincontrol_shorts','0','Shortcodes! activated?' );
		add_option( 'mommaincontrol_analytics','0','Analytics activated?' );
		add_option( 'mommaincontrol_reviews','0','Reviews activated?' );
		add_option( 'mommaincontrol_fontawesome','0','Font Awesome activated?' );
		add_option( 'mommaincontrol_versionnumbers','0','Version numbers hidden?' );
	}

	// Admin stylesheet enqueue
	function mom_list_styles() {
		wp_register_style( 'roboto', 'http://fonts.googleapis.com/css?family=Roboto' );
		wp_register_style( 'mom_admin_css', plugins_url() . "/" . plugin_basename(dirname(__FILE__)) . "/includes/adminstyle/css.css" );
		wp_register_style('font_awesome', plugins_url() . "/" . plugin_basename(dirname(__FILE__)) . '/includes/fontawesome/css/font-awesome.css' );
		wp_enqueue_style( 'roboto' );
		wp_enqueue_style( 'font_awesome' );
		wp_enqueue_style( 'mom_admin_css' );	
	}
	function mom_styles($hook) {
		if( 'settings_page_mommaincontrol' != $hook ) return; mom_list_styles();
	}
	add_action( 'admin_enqueue_scripts', 'mom_styles' );

	// Font awesome enqueue
	if ( get_option( 'mommaincontrol_fontawesome' ) == 1 && !is_admin() ) {
	function mom_plugin_scripts() {
	$css = plugins_url() . "/" . plugin_basename(dirname(__FILE__)) . '/includes/';
			wp_enqueue_style('font_awesome', $css . 'fontawesome/css/font-awesome.css' );
		}
		add_action( 'wp_enqueue_scripts', 'mom_plugin_scripts' );
	}	

	// Hide version numbers from enqueue scripts and stylesheets
	if ( get_option( 'mommaincontrol_versionnumbers' ) == 1 && !is_admin() ) {
		function mom_remove_version_numbers( $src ) {
			if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
				$src = remove_query_arg( 'ver', $src );
			return $src;
		}
		add_filter( 'style_loader_src', 'mom_remove_version_numbers', 0 );
		add_filter( 'script_loader_src', 'mom_remove_version_numbers', 0 );
	}	

	// Post as front redirection
	if ( get_option( 'mommaincontrol_mompaf' ) == 1 ) { 
		add_action( "wp", "mompaf_filter_home" );
		function mompaf_filter_home() {	
			if (is_home()) {
				if (is_numeric(get_option("mompaf_post"))){
					$mompaf_front = get_option("mompaf_post");
				} else {
					$mompaf_front = "";
				}
				if (have_posts()) : the_post();
				header("location: ".get_permalink($mompaf_front));
				exit;
				endif;
			}
		}	
	}	

	// Google Analytics code injection
	if ( get_option( 'mommaincontrol_analytics' ) == 1 && get_option( 'momanalytics_code' ) != '' ) {
		function mom_analytics() {
			echo "<script>
						(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
						})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
						ga('create', '" . get_option("momanalytics_code") . "', '" . home_url('/') . "');
						ga('send', 'pageview');
				</script>";
		}
		add_action('wp_footer', 'mom_analytics');		
	}

	// Conditionally load modules; load main control panel for plugin
	include( plugin_dir_path( __FILE__ ) . 'modules/maincontrol.php');
	if ( get_option( 'mommaincontrol_obwcountplus' ) == 1) { include( plugin_dir_path( __FILE__ ) . 'functions/_functions_countplusplus.php' ); }
	if ( get_option( 'mommaincontrol_momse' ) == 1 ) { include( plugin_dir_path( __FILE__ ) . 'functions/_functions_exclude.php' ); }	
	if ( get_option( 'mommaincontrol_momja' ) == 1 ) { include( plugin_dir_path( __FILE__ ) . 'functions/_functions_jumparound.php' ); }	
	if ( get_option( 'mommaincontrol_momrups' ) == 1 ) { include( plugin_dir_path( __FILE__ ) . 'functions/_functions_passwords.php' ); }
	if ( get_option( 'mommaincontrol_reviews' ) == 1 ) { include( plugin_dir_path( __FILE__ ) . 'functions/_functions_reviews.php' ); }
	if ( get_option( 'mommaincontrol_shorts' ) == 1 ) { include( plugin_dir_path( __FILE__ ) . 'functions/_functions_shortcodes.php' ); }

?>
