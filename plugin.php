<?php 

/**
 * Plugin Name: My Optional Modules
 * Plugin URI: http://wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 5.6
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
 
define( 'MyOptionalModules', true );
require_once( ABSPATH . 'wp-includes/pluggable.php' );

$passwordField                 = 0;
$mom_review_global             = 0;
$momverifier_verification_step = 0;

/**
 *
 * Include all of our necessary files for this plugin to function properly 
 * These files are included in the order they are needed. Rearranging them 
 * may break functionality.
 *
 */
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_user_roles.php' );                                   // Determine the connecting users role (or lack of)
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_IP_validation.php' );                                // Validate connecting IP and check it against the DNSBL
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_installation.php' );                                 // Installation
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_scripts.php' );                                      // Plugin scripts
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_variables.php' );                                    // Plugin variables
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_functions.php' );                                    // Plugin functions
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_forms.php' );                                        // Form handling
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_shortcodes.php' );                                   // Shortcodes
include( plugin_dir_path( __FILE__ ) . '_my_optional_modules_settings.php' );                                     // Settings
include( plugin_dir_path( __FILE__ ) . '_miniloop.php' );                           // Module->Miniloops
include( plugin_dir_path( __FILE__ ) . '_font_awesome_edit_screen.php' );          // New post Font Awesome icons addition