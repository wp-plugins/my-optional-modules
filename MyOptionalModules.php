<?php
/*
Plugin Name: My Optional Modules
Plugin URI: http://www.onebillionwords.com/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 5.2.7
Author: Matthew Trevino
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
	define('MyOptionalModules', TRUE );
	require_once( plugin_dir_path( __FILE__ ).'_postedit.php');
	require_once( plugin_dir_path( __FILE__ ).'modules/maincontrol.php');
	add_action('admin_enqueue_scripts','mom_styles');
	if(get_option('mommaincontrol_obwcountplus') == 1){include(plugin_dir_path( __FILE__ ).'functions/_functions_countplusplus.php');}
	if(get_option('mommaincontrol_momse') == 1){include(plugin_dir_path( __FILE__ ).'functions/_functions_exclude.php');
		add_action( 'after_setup_theme', 'mom_exclude_postformat_theme_support' );
		function mom_exclude_postformat_theme_support(){
			add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );
		}		
	}
	if(get_option('mommaincontrol_momja') == 1){include(plugin_dir_path( __FILE__ ).'functions/_functions_jumparound.php');}	
	if(get_option('mommaincontrol_momrups') == 1){include(plugin_dir_path( __FILE__ ).'functions/_functions_passwords.php');}
	if(get_option('mommaincontrol_reviews') == 1){include(plugin_dir_path( __FILE__ ).'functions/_functions_reviews.php');}
	if(get_option('mommaincontrol_shorts') == 1){include(plugin_dir_path( __FILE__ ).'functions/_functions_shortcodes.php');}
	if(get_option('mommaincontrol_meta') == 1){include(plugin_dir_path( __FILE__ ).'modules/SEO.php');}
	if(get_option('mommaincontrol_themetakeover') == 1){include(plugin_dir_path( __FILE__ ).'functions/_functions_themetakeover.php');}
	register_activation_hook( __FILE__,'my_optional_modules_main_control_install');
	function my_optional_modules_main_control_install(){
	update_option('mommaincontrol_focus','');}
	function mom_styles($hook){if('settings_page_mommaincontrol' != $hook)return;mom_list_styles();}
	function mom_list_styles(){
		wp_register_style('roboto','http://fonts.googleapis.com/css?family=Roboto');
		wp_register_style('mom_admin_css',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/adminstyle/css.css');
		wp_register_style('font_awesome',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.css');
		wp_enqueue_style('roboto');
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('mom_admin_css');
	}
	if(get_option('mommaincontrol_fontawesome') == 1){
	function mom_plugin_scripts(){
	$css = plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/';
			wp_enqueue_style('font_awesome', $css.'fontawesome/css/font-awesome.css');
		}
		add_action('wp_enqueue_scripts','mom_plugin_scripts');
	}	
	if(get_option('mommaincontrol_fontawesome') == 1){include( plugin_dir_path( __FILE__ ).'functions/_functions_fontawesome.php');}
	if(get_option('mommaincontrol_versionnumbers') == 1){
		function mom_remove_version_numbers($src){
			if(strpos($src,'ver='.get_bloginfo('version')))
				$src = remove_query_arg('ver',$src);
			return $src;
		}
		add_filter('style_loader_src','mom_remove_version_numbers',0);
		add_filter('script_loader_src','mom_remove_version_numbers',0);
	}	
	if(get_option('mommaincontrol_maintenance') == 1){
		add_action('wp','momMaintenance');
		function momMaintenance(){
			if(!is_user_logged_in() && get_option('momMaintenance_url') != ''){
				$maintenanceURL = esc_url(get_option('momMaintenance_url'));
				if ($_SERVER['REQUEST_URI'] === $maintenanceURL){
				} else {
					header('location:'.$maintenanceURL); 
					exit;
				}
			} else {}
		}
	}
	if(get_option('mommaincontrol_mompaf') == 1 ){
		add_action( "wp", "mompaf_filter_home" );
		function mompaf_filter_home(){	
			if (is_home()){
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
	if(get_option('mommaincontrol_analytics') == 1 && get_option('momanalytics_code') != ''){
		function mom_analytics(){
			echo '<script>
						(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
						})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
						ga(\'create\',\''.get_option('momanalytics_code').'\',\''.home_url('/').'\');
						ga(\'send\',\'pageview\');
				</script>';
		}
		add_action('wp_footer','mom_analytics');
	}
	if(get_option('mommaincontrol_lazyload') == 1 ){
		function mom_jquery(){
			wp_deregister_script('jquery');
			wp_register_script('jquery', "http".($_SERVER['SERVER_PORT'] == 443 ? "s" : "")."://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js",'','', null, false);
			wp_enqueue_script('jquery');		
		}
		function mom_lazy_load(){
			$lazyLoad = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
			$placeholder = plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/javascript/placeholder.png';
			echo '
			<script type=\'text/javascript\' src=\''.$lazyLoad.'\'></script>
			<script>
				$(document).ready(function (){
					$("img").wrap(function(){
						$(this).wrap(function(){
							var newimg = \'<img src="'.$placeholder.'" data-original="\' + $(this).attr(\'src\') + \'" width="\' + $(this).attr(\'width\') + \'" height="\' + $(this).attr(\'height\') + \'" class="lazy \' + $(this).attr(\'class\') + \'">\';
							return newimg;  
						});
						return \'<noscript>\';
					});
				});
			</script>
			<script>
				jQuery(document).ready(function ($){
					$("img.lazy").lazyload(
					{data_attribute: "original" 
					});
				});
			</script>';
		}
		add_action('wp_enqueue_scripts','mom_jquery');
		add_action('wp_footer','mom_lazy_load');   
	}
	if(get_option('mommaincontrol_momse') == 1 && get_option('MOM_themetakeover_youtubefrontpage') == ''){
		function MOMExclude404Redirection() {
			if(!is_user_logged_in()){
				if(get_option('MOM_Exclude_URL') != ''){ $RedirectURL = get_permalink(get_option('MOM_Exclude_URL')); }else{ $RedirectURL = get_bloginfo('wpurl');}
			}else{
				if(get_option('MOM_Exclude_URL_User') != ''){ $RedirectURL = get_permalink(get_option('MOM_Exclude_URL_User')); }else{ $RedirectURL = get_bloginfo('wpurl');}
			}
			global $wp_query;
			if ($wp_query->is_404) {
				wp_redirect($RedirectURL,301);exit;
			}
		}
	add_action('wp', 'MOMExclude404Redirection', 1);
	}
?>