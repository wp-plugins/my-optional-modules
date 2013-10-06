<?php
/*
Plugin Name: My Optional Modules
Plugin URI: http://onebillionwords.com
Description: Optional modules and additions for Wordpress.
Version: 1
Author: Matthew Trevino
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
	}
	include( plugin_dir_path( __FILE__ ) . 'modules/maincontrol.php');
	
	## Load Count++ if we ask for it
	if (get_option("mommaincontrol_obwcountplus") == 1) {	
		include( plugin_dir_path( __FILE__ ) . 'modules/countplusplus.php');
	}
	## Load RUPs if we ask for it
	if (get_option("mommaincontrol_momrups") == 1) {	
		include( plugin_dir_path( __FILE__ ) . 'modules/rups.php');
	}
	


?>
