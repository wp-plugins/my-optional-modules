<?php
/*
Plugin Name: My Optional Modules
Plugin URI: http://www.onebillionwords.com/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 1.0.8.5.1
Author: One Billion Words
Author URI: http://onebillionwords.com
*/
	## This program is free software; you can redistribute it and/or modify
	## it under the terms of the GNU General Public License, version 2, as 
	## published by the Free Software Foundation.
	## 
	## This program is distributed in the hope that it will be useful,
	## but WITHOUT ANY WARRANTY; without even the implied warranty of
	## MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	## GNU General Public License for more details.
	## 
	## You should have received a copy of the GNU General Public License
	## along with this program; if not, write to the Free Software
	## Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	## Call modules
	define('MyOptionalModules', TRUE);

	## Register Main Control activation, install options, call main control file
	register_activation_hook( __FILE__, "my_optional_modules_main_control_install" );
	function my_optional_modules_main_control_install() {
		add_option("mommaincontrol_obwcountplus","0","Count++ activated?");
		add_option("mommaincontrol_momrups","0","RUPs activated?");
		add_option("mommaincontrol_momse","0","Simply Exclude activated?");
		add_option("mommaincontrol_mompaf","0","Post as Front activated?");
		add_option("mommaincontrol_momja","0","Jump Around activated?");
		add_option("mommaincontrol_shorts","0","Shortcodes! activated?");
	}
	include( plugin_dir_path( __FILE__ ) . 'modules/maincontrol.php');
	
	## Conditional module loading
	## Count++
	if (get_option("mommaincontrol_obwcountplus") == 1) { include( plugin_dir_path( __FILE__ ) . 'modules/countplusplus.php'); }
		
	## RUPs
	if (get_option("mommaincontrol_momrups") == 1) { include( plugin_dir_path( __FILE__ ) . 'modules/rups.php'); }
		
	## Simply Exclude
	if (get_option("mommaincontrol_momse") == 1) { include( plugin_dir_path( __FILE__ ) . 'modules/se.php'); }	
		
	## Post as Front
	if (get_option("mommaincontrol_mompaf") == 1) { 
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
		
	## Jump Around
	if (get_option("mommaincontrol_momja") == 1) { include( plugin_dir_path( __FILE__ ) . 'modules/jumparound.php'); }	
	
	## Shortcodes! 
	if (get_option("mommaincontrol_shorts") == 1) { include( plugin_dir_path( __FILE__ ) . 'modules/shortcodes.php'); }
?>
