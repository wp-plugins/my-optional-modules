<?php
/*
Plugin Name: My Optional Modules
Plugin URI: http://www.onebillionwords.com/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 5.1.3
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
		add_option( 'mommaincontrol_lazyload','0','Lazy load activated?' );
		add_option( 'mommaincontrol_meta','0','Meta acitvated?' );
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
	if ( get_option( 'mommaincontrol_fontawesome' ) == 1 ) {
	function mom_plugin_scripts() {
	$css = plugins_url() . "/" . plugin_basename(dirname(__FILE__)) . '/includes/';
			wp_enqueue_style('font_awesome', $css . 'fontawesome/css/font-awesome.css' );
		}
		add_action( 'wp_enqueue_scripts', 'mom_plugin_scripts' );
	}	
	if ( get_option( 'mommaincontrol_fontawesome' ) == 1) { include( plugin_dir_path( __FILE__ ) . 'functions/_functions_fontawesome.php' ); }

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
	if ( get_option( 'mommaincontrol_meta' ) == 1 || get_option( 'mommaincontrol_meta' ) == 2 || get_option( 'mommaincontrol_meta' ) == 3  ) { 
		include( plugin_dir_path( __FILE__ ) . 'modules/SEO.php' ); 
	}
	
	// Add buttons to post edit screen for modules that have shortcodes
	if ( is_admin() ) {
		function momAdminOptions() {
			$css = plugins_url() . "/" . plugin_basename(dirname(__FILE__)) . '/includes/';
				wp_enqueue_style('font_awesome', $css . 'fontawesome/css/font-awesome.css' );
			add_action( 'wp_enqueue_admin_scripts', 'mom_plugin_scripts' );		
		
			// Add info panel to post edit screen
			function momEditorScreen( $post_type ) {
				$screen = get_current_screen();
				$edit_post_type = $screen->post_type;
				if ( $edit_post_type != 'post' )
					return;
				if ( get_option( 'mommaincontrol_shorts'      ) == 1 || 
				     get_option( 'mommaincontrol_reviews'     ) == 1 ||
					 get_option( 'mommaincontrol_rups'        ) == 1 ||
					 get_option( 'mommaincontrol_fontawesome' ) == 1
				) {
					echo "				
					<div class=\"momEditorScreen postbox\">
						<h3>Shortcodes provided by My Optional Modules</h3>
						<div class=\"inside\">
							<style>
								ol#momEditorMenu { width:95%; margin:0 auto; overflow:auto; overflow:hidden; }
								ol#momEditorMenu li { width:auto; margin:2px; float:left; list-style:none; display:block; padding:5px; line-height:20px; font-size:13px;}
								ol#momEditorMenu li span:hover { cursor:pointer; background-color:#fff; color:#4b5373;}
								ol#momEditorMenu li span { margin-right:5px; width:18px; height:19px; display:block; float:left; overflow:hidden; color: #fff; background-color:#4b5373; border-radius:3px; font-size:20px;}
								ol#momEditorMenu li.clear { clear:both; display:block; width:100%;}
								ol#momEditorMenu li.icon { width:18px; height:16px; overflow:hidden; font-size:20px; line-height:22px; margin:5px}
								ol#momEditorMenu li.icon:hover { cursor:pointer; color:#441515; background-color:#ececec; border-radius:3px;}
							</style>					
												
							<ol id=\"momEditorMenu\">";
								if ( get_option( 'mommaincontrol_shorts' ) == 1 ) {
									echo "<li>Google map<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_map address=\"\"]</span></li>";
									echo "<li>Reddit button<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_reddit]</span></li>";
									echo "<li>Restrict<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_restrict]content[/mom_restrict]</span></li>";
									echo "<li>Progress bar<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_progress level=\"\"]</span></li>";
									echo "<li>Verifier<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_verify age=\"18\"]some content[/mom_verify]</span></li>";
								}
								if ( get_option( 'mommaincontrol_reviews' ) == 1 ) {
									echo "<li>Reviews<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[momreviews]</span></li>";
								}
								if ( get_option( 'mommaincontrol_momrups' ) == 1 ) {
									echo "<li>Passwords<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[rups]content[/rups]</span></li>";
								}
								if ( get_option( 'mommaincontrol_fontawesome' ) == 1 ) {
									echo "<li class=\"clear\"></li>";
									// Medical Icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-ambulance\"><span>[font-fa i=\"ambulance\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-medkit\"><span>[font-fa i=\"medkit\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-user-md\"><span>[font-fa i=\"user-md\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-h-square\"><span>[font-fa i=\"h-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-plus-square\"><span>[font-fa i=\"plus-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-wheelchair\"><span>[font-fa i=\"wheelchair\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-hospital\"><span>[font-fa i=\"hospital\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-stethoscope\"><span>[font-fa i=\"stethoscope\"]</span></li>";	
									// Brand Icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-adn\"><span>[font-fa i=\"adn\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bitbucket\"><span>[font-fa i=\"bitbucket\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-btc\"><span>[font-fa i=\"btc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-dropbox\"><span>[font-fa i=\"dropbox\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-flickr\"><span>[font-fa i=\"flickr\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-github-alt\"><span>[font-fa i=\"github-alt\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-google-plus\"><span>[font-fa i=\"google-plus\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-instagram\"><span>[font-fa i=\"instagram\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-linux\"><span>[font-fa i=\"linux\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-pinterest\"><span>[font-fa i=\"pinterest\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-skype\"><span>[font-fa i=\"skype\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-trello\"><span>[font-fa i=\"trello\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-twitter\"><span>[font-fa i=\"twitter\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-vk\"><span>[font-fa i=\"vk\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-xing\"><span>[font-fa i=\"xing\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-youtube-play\"><span>[font-fa i=\"youtube-play\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-android\"><span>[font-fa i=\"android\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bitbucket-square\"><span>[font-fa i=\"bitbucket-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-css3\"><span>[font-fa i=\"css3\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-facebook\"><span>[font-fa i=\"facebook\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-foursquare\"><span>[font-fa i=\"foursquare\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-github-square\"><span>[font-fa i=\"github-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-google-plus-square\"><span>[font-fa i=\"google-plus-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-linkedin\"><span>[font-fa i=\"linkedin\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-maxcdn\"><span>[font-fa i=\"maxcdn\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-pinterest-square\"><span>[font-fa i=\"pinterest-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-stack-exchange\"><span>[font-fa i=\"stack-exchange\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tumblr\"><span>[font-fa i=\"tumblr\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-twitter-square\"><span>[font-fa i=\"twitter-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-weibo\"><span>[font-fa i=\"weibo\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-xing-square\"><span>[font-fa i=\"xing-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-youtube-square\"><span>[font-fa i=\"youtube-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-apple\"><span>[font-fa i=\"apple\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bitcoin\"><span>[font-fa i=\"bitcoin\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-dribbble\"><span>[font-fa i=\"dribbble\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-facebook-square\"><span>[font-fa i=\"facebook-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-github\"><span>[font-fa i=\"github\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-gittip\"><span>[font-fa i=\"gittip\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-html5\"><span>[font-fa i=\"html5\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-linkedin-square\"><span>[font-fa i=\"linkedin-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-pagelines\"><span>[font-fa i=\"pagelines\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-renren\"><span>[font-fa i=\"renren\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-stack-overflow\"><span>[font-fa i=\"stack-overflow\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tumblr-square\"><span>[font-fa i=\"tumblr-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-vimeo-square\"><span>[font-fa i=\"vimeo-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-windows\"><span>[font-fa i=\"windows\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-youtube\"><span>[font-fa i=\"youtube\"]</span></li>";	
									// Video player icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-backward\"><span>[font-fa i=\"backward\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-fast-forward\"><span>[font-fa i=\"fast-forward\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-pause\"><span>[font-fa i=\"pause\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-play-circle-o\"><span>[font-fa i=\"play-circle-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-step-backward\"><span>[font-fa i=\"step-backward\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-youtube-play\"><span>[font-fa i=\"youtube-play\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-eject\"><span>[font-fa i=\"eject\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-forward\"><span>[font-fa i=\"forward\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-play\"><span>[font-fa i=\"play\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-resize-full\"><span>[font-fa i=\"resize-full\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-step-forward\"><span>[font-fa i=\"step-forward\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-fast-backward\"><span>[font-fa i=\"fast-backward\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-fullscreen\"><span>[font-fa i=\"fullscreen\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-play-circle\"><span>[font-fa i=\"play-circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-resize-small\"><span>[font-fa i=\"resize-small\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-stop\"><span>[font-fa i=\"stop\"]</span></li>";	
									// Directional icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-double-down\"><span>[font-fa i=\"angle-double-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-double-up\"><span>[font-fa i=\"angle-double-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-right\"><span>[font-fa i=\"angle-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-left\"><span>[font-fa i=\"arrow-circle-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-o-right\"><span>[font-fa i=\"arrow-circle-o-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-up\"><span>[font-fa i=\"arrow-circle-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-right\"><span>[font-fa i=\"arrow-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-left\"><span>[font-fa i=\"caret-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-left\"><span>[font-fa i=\"caret-square-o-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-up\"><span>[font-fa i=\"caret-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-circle-right\"><span>[font-fa i=\"chevron-circle-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-left\"><span>[font-fa i=\"chevron-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-hand-o-down\"><span>[font-fa i=\"hand-o-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-hand-o-up\"><span>[font-fa i=\"hand-o-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-long-arrow-right\"><span>[font-fa i=\"long-arrow-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-left\"><span>[font-fa i=\"toggle-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-double-left\"><span>[font-fa i=\"angle-double-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-down\"><span>[font-fa i=\"angle-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-up\"><span>[font-fa i=\"angle-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-o-down\"><span>[font-fa i=\"arrow-circle-o-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-o-up\"><span>[font-fa i=\"arrow-circle-o-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-down\"><span>[font-fa i=\"arrow-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-up\"><span>[font-fa i=\"arrow-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-right\"><span>[font-fa i=\"caret-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-right\"><span>[font-fa i=\"caret-square-o-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-circle-down\"><span>[font-fa i=\"chevron-circle-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-circle-up\"><span>[font-fa i=\"chevron-circle-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-right\"><span>[font-fa i=\"chevron-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-hand-o-left\"><span>[font-fa i=\"hand-o-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-long-arrow-down\"><span>[font-fa i=\"long-arrow-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-long-arrow-up\"><span>[font-fa i=\"long-arrow-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-right\"><span>[font-fa i=\"toggle-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-double-right\"><span>[font-fa i=\"angle-double-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-angle-left\"><span>[font-fa i=\"angle-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-down\"><span>[font-fa i=\"arrow-circle-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-o-left\"><span>[font-fa i=\"arrow-circle-o-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-circle-right\"><span>[font-fa i=\"arrow-circle-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-arrow-left\"><span>[font-fa i=\"arrow-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-down\"><span>[font-fa i=\"caret-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-down\"><span>[font-fa i=\"caret-square-o-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-up\"><span>[font-fa i=\"caret-square-o-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-circle-left\"><span>[font-fa i=\"chevron-circle-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-down\"><span>[font-fa i=\"chevron-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chevron-up\"><span>[font-fa i=\"chevron-up\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-hand-o-right\"><span>[font-fa i=\"hand-o-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-long-arrow-left\"><span>[font-fa i=\"long-arrow-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-down\"><span>[font-fa i=\"toggle-down\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-up\"><span>[font-fa i=\"toggle-up\"]</span></li>";	
									// Text editor icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-align-center\"><span>[font-fa i=\"align-center\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-align-right\"><span>[font-fa i=\"align-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chain-broken\"><span>[font-fa i=\"chain-broken\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-copy\"><span>[font-fa i=\"copy\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-eraser\"><span>[font-fa i=\"eraser\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-file-text\"><span>[font-fa i=\"file-text\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-floppy-o\"><span>[font-fa i=\"floppy-o\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-italic\"><span>[font-fa i=\"italic\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-list-alt\"><span>[font-fa i=\"list-alt\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-outdent\"><span>[font-fa i=\"outdent\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-repeat\"><span>[font-fa i=\"repeat\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-save\"><span>[font-fa i=\"save\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-table\"><span>[font-fa i=\"table\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-th\"><span>[font-fa i=\"th\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-underline\"><span>[font-fa i=\"underline\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-align-justify\"><span>[font-fa i=\"align-justify\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bold\"><span>[font-fa i=\"bold\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-clipboard\"><span>[font-fa i=\"clipboard\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cut\"><span>[font-fa i=\"cut\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-file\"><span>[font-fa i=\"file\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-file-text-o\"><span>[font-fa i=\"file-text-o\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-font\"><span>[font-fa i=\"font\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-link\"><span>[font-fa i=\"link\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-list-ol\"><span>[font-fa i=\"list-ol\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-paperclip\"><span>[font-fa i=\"paperclip\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rotate-left\"><span>[font-fa i=\"rotate-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-scissors\"><span>[font-fa i=\"scissors\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-text-height\"><span>[font-fa i=\"text-height\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-th-large\"><span>[font-fa i=\"th-large\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-undo\"><span>[font-fa i=\"undo\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-align-left\"><span>[font-fa i=\"align-left\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-chain\"><span>[font-fa i=\"chain\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-columns\"><span>[font-fa i=\"columns\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-dedent\"><span>[font-fa i=\"dedent\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-file-o\"><span>[font-fa i=\"file-o\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-files-o\"><span>[font-fa i=\"files-o\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-indent\"><span>[font-fa i=\"indent\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-list\"><span>[font-fa i=\"list\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-list-ul\"><span>[font-fa i=\"list-ul\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-paste\"><span>[font-fa i=\"paste\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rotate-right\"><span>[font-fa i=\"rotate-right\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-strikethrough\"><span>[font-fa i=\"strikethrough\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-text-width\"><span>[font-fa i=\"text-width\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-th-list\"><span>[font-fa i=\"th-list\"]</span></li>";	
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-unlink\"><span>[font-fa i=\"unlink\"]</span></li>";	
									// Currency icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bitcoin\"><span>[font-fa i=\"bitcoin\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-dollar\"><span>[font-fa i=\"dollar\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-gbp\"><span>[font-fa i=\"gbp\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-krw\"><span>[font-fa i=\"krw\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rouble\"><span>[font-fa i=\"rouble\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rupee\"><span>[font-fa i=\"rupee\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-usd\"><span>[font-fa i=\"usd\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-btc\"><span>[font-fa i=\"btc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-eur\"><span>[font-fa i=\"eur\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-inr\"><span>[font-fa i=\"inr\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-money\"><span>[font-fa i=\"money\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rub\"><span>[font-fa i=\"rub\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-try\"><span>[font-fa i=\"try\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-won\"><span>[font-fa i=\"won\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cny\"><span>[font-fa i=\"cny\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-euro\"><span>[font-fa i=\"euro\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-jpy\"><span>[font-fa i=\"jpy\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rmb\"><span>[font-fa i=\"rmb\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-ruble\"><span>[font-fa i=\"ruble\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-turkish-lira\"><span>[font-fa i=\"turkish-lira\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-yen\"><span>[font-fa i=\"yen\"]</span></li>";
									// Form control icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-check-square\"><span>[font-fa i=\"check-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-circle-o\"><span>[font-fa i=\"circle-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-minus-square-o\"><span>[font-fa i=\"minus-square-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-check-square-o\"><span>[font-fa i=\"check-square-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-dot-circle-o\"><span>[font-fa i=\"dot-circle-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-square\"><span>[font-fa i=\"square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-circle\"><span>[font-fa i=\"circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-minus-square\"><span>[font-fa i=\"minus-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-square-o\"><span>[font-fa i=\"square-o\"]</span></li>";
									// Web application icons
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-adjust\"><span>[font-fa i=\"adjust\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-anchor\"><span>[font-fa i=\"anchor\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-archive\"><span>[font-fa i=\"archive\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-asterisk\"><span>[font-fa i=\"asterisk\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-ban\"><span>[font-fa i=\"ban\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bar-chart-o\"><span>[font-fa i=\"bar-chart-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-barcode\"><span>[font-fa i=\"barcode\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-beer\"><span>[font-fa i=\"beer\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bell\"><span>[font-fa i=\"bell\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bell-o\"><span>[font-fa i=\"bell-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bolt\"><span>[font-fa i=\"bolt\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-book\"><span>[font-fa i=\"book\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bookmark\"><span>[font-fa i=\"bookmark\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bookmark-o\"><span>[font-fa i=\"bookmark-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-briefcase\"><span>[font-fa i=\"briefcase\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bug\"><span>[font-fa i=\"bug\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-building\"><span>[font-fa i=\"building\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bullhorn\"><span>[font-fa i=\"bullhorn\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-bullseye\"><span>[font-fa i=\"bullseye\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-calendar\"><span>[font-fa i=\"calendar\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-calendar-o\"><span>[font-fa i=\"calendar-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-camera\"><span>[font-fa i=\"camera\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-camera-retro\"><span>[font-fa i=\"camera-retro\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-down\"><span>[font-fa i=\"caret-square-o-down\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-left\"><span>[font-fa i=\"caret-square-o-left\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-right\"><span>[font-fa i=\"caret-square-o-right\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-caret-square-o-up\"><span>[font-fa i=\"caret-square-o-up\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-certificate\"><span>[font-fa i=\"certificate\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-check\"><span>[font-fa i=\"check\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-check-circle\"><span>[font-fa i=\"check-circle\"]</span></li>";
									
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-check-circle-o\"><span>[font-fa i=\"check-circle-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-check-square\"><span>[font-fa i=\"check-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-check-square-o\"><span>[font-fa i=\"check-square-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-circle\"><span>[font-fa i=\"circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-circle-o\"><span>[font-fa i=\"circle-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-clock-o\"><span>[font-fa i=\"clock-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cloud\"><span>[font-fa i=\"cloud\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cloud-download\"><span>[font-fa i=\"cloud-download\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cloud-upload\"><span>[font-fa i=\"cloud-upload\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-code\"><span>[font-fa i=\"code\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-code-fork\"><span>[font-fa i=\"code-fork\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-coffee\"><span>[font-fa i=\"coffee\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cog\"><span>[font-fa i=\"cog\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cogs\"><span>[font-fa i=\"cogs\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-collapse-o\"><span>[font-fa i=\"collapse-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-comment\"><span>[font-fa i=\"comment\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-comment-o\"><span>[font-fa i=\"comment-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-comments\"><span>[font-fa i=\"comments\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-comments-o\"><span>[font-fa i=\"comments-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-compass\"><span>[font-fa i=\"compass\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-credit-card\"><span>[font-fa i=\"credit-card\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-crop\"><span>[font-fa i=\"crop\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-crosshairs\"><span>[font-fa i=\"crosshairs\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-cutlery\"><span>[font-fa i=\"cutlery\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-dashboard\"><span>[font-fa i=\"dashboard\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-desktop\"><span>[font-fa i=\"desktop\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-dot-circle-o\"><span>[font-fa i=\"dot-circle-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-download\"><span>[font-fa i=\"download\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-edit\"><span>[font-fa i=\"edit\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-ellipsis-horizontal\"><span>[font-fa i=\"ellipsis-horizontal\"]</span></li>";
									
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-ellipsis-vertical\"><span>[font-fa i=\"ellipsis-vertical\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-envelope\"><span>[font-fa i=\"envelope\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-envelope-o\"><span>[font-fa i=\"envelope-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-eraser\"><span>[font-fa i=\"eraser\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-exchange\"><span>[font-fa i=\"exchange\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-exclamation\"><span>[font-fa i=\"exclamation\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-exclamation-circle\"><span>[font-fa i=\"exclamation-circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-exclamation-triangle\"><span>[font-fa i=\"exclamation-triangle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-expand-o\"><span>[font-fa i=\"expand-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-external-link\"><span>[font-fa i=\"external-link\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-external-link-square\"><span>[font-fa i=\"external-link-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-eye\"><span>[font-fa i=\"eye\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-eye-slash\"><span>[font-fa i=\"eye-slash\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-female\"><span>[font-fa i=\"female\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-fighter-jet\"><span>[font-fa i=\"fighter-jet\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-film\"><span>[font-fa i=\"film\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-filter\"><span>[font-fa i=\"filter\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-fire\"><span>[font-fa i=\"fire\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-fire-extinguisher\"><span>[font-fa i=\"fire-extinguisher\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-flag\"><span>[font-fa i=\"flag\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-flag-checkered\"><span>[font-fa i=\"flag-checkered\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-flag-o\"><span>[font-fa i=\"flag-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-flash\"><span>[font-fa i=\"flash\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-flask\"><span>[font-fa i=\"flask\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-folder\"><span>[font-fa i=\"folder\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-folder-o\"><span>[font-fa i=\"folder-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-folder-open\"><span>[font-fa i=\"folder-open\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-folder-open-o\"><span>[font-fa i=\"folder-open-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-frown-o\"><span>[font-fa i=\"frown-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-gamepad\"><span>[font-fa i=\"gamepad\"]</span></li>";

									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-gavel\"><span>[font-fa i=\"gavel\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-gear\"><span>[font-fa i=\"gear\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-gears\"><span>[font-fa i=\"gears\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-gift\"><span>[font-fa i=\"gift\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-glass\"><span>[font-fa i=\"glass\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-globe\"><span>[font-fa i=\"globe\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-group\"><span>[font-fa i=\"group\"]</span></li>";
									// hdd-o seems to be broken ## echo "<li onclick=\"addText(event)\" class=\"icon fa fa-hdd-o\"><span>[font-fa i=\"hdd-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-headphones\"><span>[font-fa i=\"headphones\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-heart\"><span>[font-fa i=\"heart\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-heart-o\"><span>[font-fa i=\"heart-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-home\"><span>[font-fa i=\"home\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-inbox\"><span>[font-fa i=\"inbox\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-info\"><span>[font-fa i=\"info\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-info-circle\"><span>[font-fa i=\"info-circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-key\"><span>[font-fa i=\"key\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-keyboard-o\"><span>[font-fa i=\"keyboard-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-laptop\"><span>[font-fa i=\"laptop\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-leaf\"><span>[font-fa i=\"leaf\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-legal\"><span>[font-fa i=\"legal\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-lemon-o\"><span>[font-fa i=\"lemon-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-level-down\"><span>[font-fa i=\"level-down\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-level-up\"><span>[font-fa i=\"level-up\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-lightbulb-o\"><span>[font-fa i=\"lightbulb-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-location-arrow\"><span>[font-fa i=\"location-arrow\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-lock\"><span>[font-fa i=\"lock\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-magic\"><span>[font-fa i=\"magic\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-magnet\"><span>[font-fa i=\"magnet\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-mail-forward\"><span>[font-fa i=\"mail-forward\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-mail-reply\"><span>[font-fa i=\"mail-reply\"]</span></li>";
									
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-mail-reply-all\"><span>[font-fa i=\"mail-reply-all\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-male\"><span>[font-fa i=\"male\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-map-marker\"><span>[font-fa i=\"map-marker\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-meh-o\"><span>[font-fa i=\"meh-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-microphone\"><span>[font-fa i=\"microphone\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-microphone-slash\"><span>[font-fa i=\"microphone-slash\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-minus\"><span>[font-fa i=\"minus\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-minus-circle\"><span>[font-fa i=\"minus-circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-minus-square\"><span>[font-fa i=\"minus-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-minus-square-o\"><span>[font-fa i=\"minus-square-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-mobile\"><span>[font-fa i=\"mobile\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-mobile-phone\"><span>[font-fa i=\"mobile-phone\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-money\"><span>[font-fa i=\"money\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-moon-o\"><span>[font-fa i=\"moon-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-move\"><span>[font-fa i=\"move\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-music\"><span>[font-fa i=\"music\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-pencil\"><span>[font-fa i=\"pencil\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-pencil-square\"><span>[font-fa i=\"pencil-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-pencil-square-o\"><span>[font-fa i=\"pencil-square-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-phone\"><span>[font-fa i=\"phone\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-phone-square\"><span>[font-fa i=\"phone-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-picture-o\"><span>[font-fa i=\"picture-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-plane\"><span>[font-fa i=\"plane\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-plus\"><span>[font-fa i=\"plus\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-plus-circle\"><span>[font-fa i=\"plus-circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-plus-square\"><span>[font-fa i=\"plus-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-power-off\"><span>[font-fa i=\"power-off\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-print\"><span>[font-fa i=\"print\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-puzzle-piece\"><span>[font-fa i=\"puzzle-piece\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-qrcode\"><span>[font-fa i=\"qrcode\"]</span></li>";
									
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-question\"><span>[font-fa i=\"question\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-question-circle\"><span>[font-fa i=\"question-circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-quote-left\"><span>[font-fa i=\"quote-left\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-quote-right\"><span>[font-fa i=\"quote-right\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-random\"><span>[font-fa i=\"random\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-refresh\"><span>[font-fa i=\"refresh\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-reorder\"><span>[font-fa i=\"reorder\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-reply\"><span>[font-fa i=\"reply\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-reply-all\"><span>[font-fa i=\"reply-all\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-resize-horizontal\"><span>[font-fa i=\"resize-horizontal\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-resize-vertical\"><span>[font-fa i=\"resize-vertical\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-retweet\"><span>[font-fa i=\"retweet\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-road\"><span>[font-fa i=\"road\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rocket\"><span>[font-fa i=\"rocket\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rss\"><span>[font-fa i=\"rss\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-rss-square\"><span>[font-fa i=\"rss-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-search\"><span>[font-fa i=\"search\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-search-minus\"><span>[font-fa i=\"search-minus\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-search-plus\"><span>[font-fa i=\"search-plus\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-share\"><span>[font-fa i=\"share\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-share-square\"><span>[font-fa i=\"share-square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-share-square-o\"><span>[font-fa i=\"share-square-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-shield\"><span>[font-fa i=\"shield\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-shopping-cart\"><span>[font-fa i=\"shopping-cart\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sign-in\"><span>[font-fa i=\"sign-in\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sign-out\"><span>[font-fa i=\"sign-out\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-signal\"><span>[font-fa i=\"signal\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sitemap\"><span>[font-fa i=\"sitemap\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-smile-o\"><span>[font-fa i=\"smile-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort\"><span>[font-fa i=\"sort\"]</span></li>";
									
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-alpha-asc\"><span>[font-fa i=\"sort-alpha-asc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-alpha-desc\"><span>[font-fa i=\"sort-alpha-desc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-amount-asc\"><span>[font-fa i=\"sort-amount-asc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-amount-desc\"><span>[font-fa i=\"sort-amount-desc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-asc\"><span>[font-fa i=\"sort-asc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-desc\"><span>[font-fa i=\"sort-desc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-down\"><span>[font-fa i=\"sort-down\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-numeric-asc\"><span>[font-fa i=\"sort-numeric-asc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-numeric-desc\"><span>[font-fa i=\"sort-numeric-desc\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sort-up\"><span>[font-fa i=\"sort-up\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-spinner\"><span>[font-fa i=\"spinner\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-square\"><span>[font-fa i=\"square\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-square-o\"><span>[font-fa i=\"square-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-star\"><span>[font-fa i=\"star\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-star-half\"><span>[font-fa i=\"star-half\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-star-half-empty\"><span>[font-fa i=\"star-half-empty\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-star-half-full\"><span>[font-fa i=\"star-half-full\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-star-half-o\"><span>[font-fa i=\"star-half-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-star-o\"><span>[font-fa i=\"star-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-subscript\"><span>[font-fa i=\"subscript\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-suitcase\"><span>[font-fa i=\"suitcase\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-sun-o\"><span>[font-fa i=\"sun-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-superscript\"><span>[font-fa i=\"superscript\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tablet\"><span>[font-fa i=\"tablet\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tachometer\"><span>[font-fa i=\"tachometer\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tag\"><span>[font-fa i=\"tag\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tags\"><span>[font-fa i=\"tags\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tasks\"><span>[font-fa i=\"tasks\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-terminal\"><span>[font-fa i=\"terminal\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-thumb-tack\"><span>[font-fa i=\"thumb-tack\"]</span></li>";
									
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-thumbs-down\"><span>[font-fa i=\"thumbs-down\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-thumbs-o-down\"><span>[font-fa i=\"thumbs-o-down\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-thumbs-o-up\"><span>[font-fa i=\"thumbs-o-up\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-thumbs-up\"><span>[font-fa i=\"thumbs-up\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-ticket\"><span>[font-fa i=\"ticket\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-times\"><span>[font-fa i=\"times\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-times-circle\"><span>[font-fa i=\"times-circle\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-times-circle-o\"><span>[font-fa i=\"times-circle-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-tint\"><span>[font-fa i=\"tint\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-down\"><span>[font-fa i=\"toggle-down\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-left\"><span>[font-fa i=\"toggle-left\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-right\"><span>[font-fa i=\"toggle-right\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-toggle-up\"><span>[font-fa i=\"toggle-up\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-trash-o\"><span>[font-fa i=\"trash-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-trophy\"><span>[font-fa i=\"trophy\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-truck\"><span>[font-fa i=\"truck\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-umbrella\"><span>[font-fa i=\"umbrella\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-unlock\"><span>[font-fa i=\"unlock\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-unlock-o\"><span>[font-fa i=\"unlock-o\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-unsorted\"><span>[font-fa i=\"unsorted\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-upload\"><span>[font-fa i=\"upload\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-user\"><span>[font-fa i=\"user\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-video-camera\"><span>[font-fa i=\"video-camera\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-volume-down\"><span>[font-fa i=\"volume-down\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-volume-off\"><span>[font-fa i=\"volume-off\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-volume-up\"><span>[font-fa i=\"volume-up\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-warning\"><span>[font-fa i=\"warning\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-wheelchair\"><span>[font-fa i=\"wheelchair\"]</span></li>";
									echo "<li onclick=\"addText(event)\" class=\"icon fa fa-wrench\"><span>[font-fa i=\"wrench\"]</span></li>";
								}
								echo "</ol>
								<script>
								function addText(event) {
									var targ = event.target || event.srcElement;
									document.getElementById(\"content\").value += targ.textContent || targ.innerText;
								}
								</script>
						</div><!-- .inside -->
					</div><!-- .postbox -->";
				}
			}
			add_action( 'edit_form_after_editor', 'momEditorScreen' );
		}
	momAdminOptions();
	}

	// Lazy load 
	if ( get_option( 'mommaincontrol_lazyload' ) == 1 ) { 
		function mom_jquery() {
			wp_deregister_script('jquery');
			wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", '', '', null, false);
			wp_enqueue_script('jquery');		
		}
	
		function mom_lazy_load() {
			$lazyLoad = "//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js";
			$placeholder = plugins_url() . '/' . plugin_basename(dirname(__FILE__)) . '/includes/javascript/placeholder.png';
			echo "
			<script type='text/javascript' src='" . $lazyLoad . "'></script>
			<script>
				$(document).ready(function () {
					$(\"img\").wrap(function() {
						$(this).wrap(function() {
							var newimg = '<img src=\"" . $placeholder . "\" data-original=\"' + $(this).attr('src') + '\" width=\"' + $(this).attr('width') + '\" height=\"' + $(this).attr('height') + '\" class=\"lazy ' + $(this).attr('class') + '\">';
							return newimg;  
						});
						return '<noscript>';
					});
				});
			</script>
			<script>
				jQuery(document).ready(function ($) {
					$(\"img.lazy\").lazyload(
					{ data_attribute: \"original\" 
					});
				});
			</script>";
		}
		add_action( 'wp_enqueue_scripts', 'mom_jquery' );
		add_action( 'wp_footer', 'mom_lazy_load' );   
	}

	
?>
