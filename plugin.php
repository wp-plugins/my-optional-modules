<?php /*
Plugin Name: My Optional Modules
Plugin URI: http://www.onebillionwords.com/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 5.3.8.8.1
Author: Matthew Trevino
Author URI: http://onebillionwords.com
*******************************
LICENSE
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
*******************************
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*******************************
You should have received a copy of the GNU General Public License
along with this program;if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
/******************************
	(00) Contents
		SECTION A > Minor dependencies
		SECTION B > Overall
			(B0) Install > When plugin is activated, do stuff
			(B1) Variables > Set variables for main modules
			(B2) Main functions > Define functions that we need immediately
			(B3) Options > Saving and deleting
		SECTION C > Settings page
		SECTION D > Passwords
			(D0) Settings > Settings page
			(D1) Functions > Functions([shortcode])
		SECTION E > Reviews
			(E0) Settings > Settings page
			(E1) Functions > Reviews functions,[shortcode]
		SECTION F > Shortcodes
			(F0) Settings > Settings display (informational purposes screen)
			(F1) Shortcodes > [shortcodes]
		SECTION G > Meta
			(G0) Functions > Meta functions
		SECTION H > Theme Takeover
			(H0) Settings > Settings page
			(H1) Functions > Theme Takeover functions
		SECTION I > Font Awesome
			(I0) Shortcode > [font-fa] shortcode for Font Awesome <i></i>
		SECTION J > Count++
			(J0) Settings > Settings page
			(J1) Functions > Count++ Theme functions
		SECTION K > Exclude
			(K0) Settings > Settings page
			(K1) Functions > Exclude functions
		Section L > Jump Around
			(L0) Settings > Settings page
		SECTION M > POST VODING
			(M0) Functions > Post Voting
		SECTION N > REGULARD BOARD
			(N0) Functions > Regular Board
		SECTION X > Database cleaner
		SECTION Y > Post edit buttons
		SECTION Z > Additional information
/****************************** SECTION A -/- Dependencies  ******************************/
define('MyOptionalModules',true);
require_once(ABSPATH.'wp-includes/pluggable.php');
require_once('HTMLPurifier.standalone.php');
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
$my_optional_modules_passwords_salt = get_option('mom_passwords_salt');
$passwordField = 0;
if(function_exists('akismet_admin_init')){require_once('akismet.class.php');}
/****************************** SECTION B -/- (B0) Install ******************************/
register_activation_hook(__FILE__,'my_optional_modules_main_control_install');
add_action('wp','enqueueMOMscriptsFooter');
add_action('admin_enqueue_scripts','mom_styles');
add_action('admin_enqueue_scripts','MOMFontAwesomeIncluded');
add_action('wp_print_styles','MOMMainCSS');
function mom_styles($hook){
	if('settings_page_mommaincontrol' != $hook)
	return;
	wp_register_style('roboto','http://fonts.googleapis.com/css?family=Roboto');
	wp_register_style('mom_admin_css',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/adminstyle/css.css');
	wp_register_style('font_awesome',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.css');
	wp_enqueue_style('roboto');
	wp_enqueue_style('font_awesome');
	wp_enqueue_style('mom_admin_css');	
}
function MOMFontAwesomeIncluded(){
	wp_register_style('font_awesome',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.css');
	wp_enqueue_style('font_awesome');
}
function MOMMainCSS(){
	$myStyleFile = WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules.css';
	wp_register_style('my_optional_modules',$myStyleFile);
	wp_enqueue_style('my_optional_modules');
}
/****************************** SECTION B -/- (B1) Variables ******************************/
$mommodule_analytics = esc_attr(get_option('mommaincontrol_analytics'));
$mommodule_focus = esc_attr(get_option('mommaincontrol_focus'));

$mommodule_analytics = false;
$mommodule_count = false;			
$mommodule_exclude = false;
$mommodule_focus = false;			
$mommodule_fontawesome = false;
$mommodule_jumparound = false;		
$mommodule_lazyload = false;
$mommodule_maintenance = false;		
$mommodule_meta = false;
$mommodule_passwords = false;		
$mommodule_postasfront = false;
$mommodule_reviews = false;			
$mommodule_shortcodes = false;
$mommodule_themetakeover = false;	
$mommodule_versionnumbers = false;	

if($mommodule_analytics == 1)$mommodule_analytics = true;
$mommodule_count = esc_attr(get_option('mommaincontrol_obwcountplus'));

if($mommodule_count == 1)$mommodule_count = true;
$mommodule_exclude = esc_attr(get_option('mommaincontrol_momse'));

if($mommodule_exclude == 1)$mommodule_exclude = true;
if($mommodule_exclude === true)add_action('after_setup_theme','mom_exclude_postformat_theme_support');
if($mommodule_exclude === true)add_action('pre_get_posts','mom_exclude_filter_posts');
if($mommodule_focus == 1)$mommodule_focus = true;

$mommodule_fontawesome = esc_attr(get_option('mommaincontrol_fontawesome'));
if($mommodule_fontawesome == 1)$mommodule_fontawesome = true;
if($mommodule_fontawesome === true)add_action('wp_enqueue_scripts','mom_plugin_scripts');
if($mommodule_fontawesome === true)add_shortcode('font-fa','font_fa_shortcode');
if($mommodule_fontawesome === true)add_filter('the_content','do_shortcode','font_fa_shortcode');

$mommodule_jumparound = esc_attr(get_option('mommaincontrol_momja'));
if($mommodule_jumparound == 1)$mommodule_jumparound = true;

$mommodule_authorarchives = esc_attr(get_option('mommaincontrol_authorarchives'));
if($mommodule_authorarchives == 1)$mommodule_authorarchives = true;
if($mommodule_authorarchives === true)add_action('template_redirect','mom_grab_author_count');

$mommodule_datearchives = esc_attr(get_option('mommaincontrol_datearchives'));
if($mommodule_datearchives == 1)$mommodule_datearchives = true;
if($mommodule_datearchives === true)add_action('wp','mom_disable_date_based_archives');
if($mommodule_datearchives === true)add_action('template_redirect','mom_disable_date_based_archives');

$mommodule_footerscripts = esc_attr(get_option('mommaincontrol_footerscripts'));
if($mommodule_footerscripts == 1)$mommodule_footerscripts = true;
if($mommodule_footerscripts === true)add_action('wp_enqueue_scripts','momfooterscripts');
if($mommodule_footerscripts === true)add_action('wp_footer','wp_print_scripts',5);
if($mommodule_footerscripts === true)add_action('wp_footer','wp_enqueue_scripts',5);
if($mommodule_footerscripts === true)add_action('wp_footer','wp_print_head_scripts',5);

$mommodule_protectrss = esc_attr(get_option('mommaincontrol_protectrss'));
if($mommodule_protectrss == 1)$mommodule_protectrss = true;
if($mommodule_protectrss === true)add_filter('the_content_feed','momprotectrss');
if($mommodule_protectrss === true)add_filter('the_excerpt_rss','momprotectrss');

$mommodule_lazyload = esc_attr(get_option('mommaincontrol_lazyload'));
if($mommodule_lazyload == 1)$mommodule_lazyload = true;

$mommodule_maintenance = esc_attr(get_option('mommaincontrol_maintenance'));
if($mommodule_maintenance == 1)$mommodule_maintenance = true;
if($mommodule_maintenance === true)add_action('wp','momMaintenance');

$mommodule_meta = esc_attr(get_option('mommaincontrol_meta'));
if($mommodule_meta == 1)$mommodule_meta = true;
if($mommodule_meta === true)mom_SEO_header();
if($mommodule_meta === true)add_filter('admin_init','momSEO_add_fields_to_general');
if($mommodule_meta === true)add_filter('user_contactmethods','momSEO_add_fields_to_profile');
if($mommodule_meta === true)add_filter('jetpack_enable_opengraph','__return_false',99);
if($mommodule_meta === true)add_action('wp_head','mom_meta_module');

$mommodule_passwords = esc_attr(get_option('mommaincontrol_momrups'));
if($mommodule_passwords == 1)$mommodule_passwords = true;
if($mommodule_passwords === true)add_shortcode('rups','rotating_universal_passwords_shortcode');
if($mommodule_passwords === true)add_filter('the_content','do_shortcode','rotating_universal_passwords_shortcode');

$mommodule_postasfront = esc_attr(get_option('mommaincontrol_mompaf'));
if($mommodule_postasfront == 1)$mommodule_postasfront = true;
if($mommodule_postasfront === true)add_action('wp','mompaf_filter_home');

$mommodule_reviews = esc_attr(get_option('mommaincontrol_reviews'));
if($mommodule_reviews == 1)$mommodule_reviews = true;
if($mommodule_reviews === true)add_shortcode('momreviews','mom_reviews_shortcode');	
if($mommodule_reviews === true)add_filter('the_content','do_shortcode','mom_reviews_shortcode');	

$mommodule_shortcodes = esc_attr(get_option('mommaincontrol_shorts'));
if($mommodule_shortcodes == 1)$mommodule_shortcodes = true;
if($mommodule_shortcodes === true)add_shortcode('mom_archives','mom_archives');
if($mommodule_shortcodes === true)add_shortcode('mom_onthisday','mom_onthisday');
if($mommodule_shortcodes === true)add_shortcode('mom_map','mom_google_map_shortcode');
if($mommodule_shortcodes === true)add_shortcode('mom_reddit','mom_reddit_shortcode');
if($mommodule_shortcodes === true)add_shortcode('mom_restrict','mom_restrict_shortcode');
if($mommodule_shortcodes === true)add_shortcode('mom_progress','mom_progress_shortcode');
if($mommodule_shortcodes === true)add_shortcode('mom_verify','mom_verify_shortcode');
if($mommodule_shortcodes === true)add_filter('the_content','do_shortcode','mom_onthisday');
if($mommodule_shortcodes === true)add_filter('the_content','do_shortcode','mom_archives');
if($mommodule_shortcodes === true)add_filter('the_content','do_shortcode','mom_map');
if($mommodule_shortcodes === true)add_filter('the_content','do_shortcode','mom_reddit');
if($mommodule_shortcodes === true)add_filter('the_content','do_shortcode','mom_restrict');
if($mommodule_shortcodes === true)add_filter('the_content','do_shortcode','mom_progress');
if($mommodule_shortcodes === true)add_filter('the_content','do_shortcode','mom_verify');

$mommodule_themetakeover = esc_attr(get_option('mommaincontrol_themetakeover'));
if($mommodule_themetakeover == 1)$mommodule_themetakeover = true;

$mommodule_versionnumbers = esc_attr(get_option('mommaincontrol_versionnumbers'));
if($mommodule_versionnumbers == 1)$mommodule_versionnumbers = true;
if($mommodule_versionnumbers === true)add_filter('style_loader_src','mom_remove_version_numbers',0);
if($mommodule_versionnumbers === true)add_filter('script_loader_src','mom_remove_version_numbers',0);

$momthemetakeover_youtube = esc_url(get_option('MOM_themetakeover_youtubefrontpage'));
/****************************** SECTION B -/- (B2) Main Functions ******************************/
function checkdnsbl($ip){
	//http://snipplr.com/view/64564/
	$dnsbl_lookup=array(
		'dnsbl-1.uceprotect.net',
		'dnsbl-2.uceprotect.net',
		'dnsbl-3.uceprotect.net',
		'dnsbl.sorbs.net',
		'zen.spamhaus.org'
		);
	if($ip){
		$reverse_ip=implode(".",array_reverse(explode(".",$ip)));
		foreach($dnsbl_lookup as $host){
			if(checkdnsrr($reverse_ip.".".$host.".","A")){
				$listed.=$reverse_ip.'.'.$host;
			}
		}
	}
	if($listed){
		$DNSBL === true;
	}else{
		$DNSBL === false;
	}
}

function tripcode($name)
//http://stackoverflow.com/questions/2422482/how-do-i-create-a-tripcode-system
{
    if(ereg("(#|!)(.*)", $name, $matches))
    {
        $cap  = $matches[2];
        $cap  = strtr($cap,"&amp;", "&");
        $cap  = strtr($cap,",", ",");
        $salt = substr($cap."H.",1,2);
        $salt = ereg_replace("[^\.-z]",".",$salt);
        $salt = strtr($salt,":;<=>?@[\\]^_`","ABCDEFGabcdef"); 
        return substr(crypt($cap,$salt),-10)."";
    }
}

if(get_option('MOM_themetakeover_backgroundimage') == 1){
	//http://scottnix.com/thematic-snippets/
	$backgroundargs = array( 
		'default-image'          => '',
		'default-color'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', array(
		'default-color' => 'fff',
	) );
}
function momprotectrss($content){
		return $content.'<p><a href="'.esc_url(get_permalink($post->ID)).'">'.htmlentities(get_post_field('post_title',$postid)).'</a> via <a href="'.esc_url(home_url('/')).'">'.get_bloginfo('site_name').'</a></p>';
}
function momfooterscripts(){
	remove_action('wp_head','wp_print_scripts');
	remove_action('wp_head','wp_print_head_scripts',9);
	remove_action('wp_head','wp_enqueue_scripts',1);
}
function mom_grab_author_count(){
	global $wp_query;
	if(is_author())
	{
		if(sizeof(get_users('who=authors'))===1)
			wp_redirect(get_bloginfo('url'));
	}
}
function mom_disable_date_based_archives(){
	global $wp_query;
	if(is_date() || is_year() || is_month() || is_day() || is_time() || is_new_day()){
		$homeURL = esc_url(home_url('/'));
		if(have_posts()):the_post();
		header('location:'.$homeURL);
		exit;
		endif;
	}
}
function sanistripents($string){
	return sanitize_text_field(strip_tags(htmlentities($string)));
}
function unique_numbersonly_nospaces($string){
	return sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',($string)))))));
}
function mom_exclude_list_categories(){
	if($mommodule_exclude == 1){
		get_currentuserinfo();
		global $user_level;
		$nofollowCats = array('0');
		if(!is_user_logged_in()){
			$nofollowCats = get_option('MOM_Exclude_VisitorCategories').','.get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');	
		}
		if(is_user_logged_in()){
			if($user_level == 0){$nofollowCats = get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
			if($user_level <= 1){$nofollowCats = get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
			if($user_level <= 2){$nofollowCats = get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
			if($user_level <= 7){$nofollowCats = get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
		}
		$c1 = explode(',',$nofollowCats);
		foreach($c1 as &$C1){$C1 = ''.$C1.',';}
		$c_1 = rtrim(implode($c1),',');
		$c11 = explode(',',str_replace(' ','',$c_1));
		$c11array = array($c11);
		$array = array('0');
		$nofollowcats = array_filter($c11);
	}
		$category_ids = get_all_category_ids();
		foreach($category_ids as $cat_id){
			if($nofollowcats != ''){
				if(in_array($cat_id, $nofollowcats))continue;
			}
			$cat = get_category($cat_id);
			$link = get_category_link($cat_id);
			echo '<li><a href="'.$link.'" title="link to '.$cat->name.'">'.$cat->name.'</a></li>';
		}
}
function momSEO_add_fields_to_profile($profile_fields){
	$profile_fields['twitter_personal'] = 'Twitter Username';
	return $profile_fields;
}
function momSEO_add_fields_to_general(){
	register_setting('general','site_twitter','esc_attr');
	add_settings_field('site_twitter','<label for="site_twitter">'.__('Twitter Site username','site_twitter').'</label>' ,'mom_SEO_add_twitter_to_general_html','general');
}
function mom_SEO_add_twitter_to_general_html(){
	$twitter = get_option('site_twitter','');
	echo '<input id="site_twitter" name="site_twitter" value="'.$twitter.'"/>';
}
function enqueueMOMscriptsFooter(){
	function mom_jquery(){
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http".($_SERVER['SERVER_PORT'] == 443 ? "s" : "")."://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js",'','', null, false);
		wp_enqueue_script('jquery');
		
		$sisyphus = plugins_url().'/my-optional-modules/includes/javascript/sisyphus.js';
		wp_deregister_script('sisyphus');
		wp_register_script('sisyphus',$sisyphus,'','',null,false);
		wp_enqueue_script('sisyphus');
		
		if(get_option('MOM_themetakeover_fitvids') != ''){
			$fitvids = plugins_url().'/my-optional-modules/includes/javascript/fitvids.js';
			wp_deregister_script('fitvids');
			wp_register_script('fitvids',$fitvids,'','',null,false);
			wp_enqueue_script('fitvids');
		}
		if(get_option('mommaincontrol_lazyload') == 1){
			$lazyLoad = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
			wp_deregister_script('lazyload');
			wp_register_script('lazyload',$lazyLoad,'','',null,false);
			wp_enqueue_script('lazyload');
		}
		if(get_option('MOM_themetakeover_wowhead') == 1){
			$wowhead = '//static.wowhead.com/widgets/power.js';
			wp_deregister_script('wowhead');
			wp_register_script('wowhead',$wowhead,'','',null,false);
			wp_enqueue_script('wowhead');
		}		
	}
	add_action('wp_enqueue_scripts','mom_jquery');
	function MOMScriptsFooter(){
		echo '
		<script type=\'text/javascript\'>';
		if(get_option('MOM_themetakeover_wowhead') == 1){
			echo '
			var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }
			';
		}
		if(get_option('mommaincontrol_analytics') == 1 && get_option('momanalytics_code') != ''){
			echo '
			(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
			ga(\'create\',\''.get_option('momanalytics_code').'\',\''.home_url('/').'\');
			ga(\'send\',\'pageview\');
			';
		}			
		echo 'jQuery(document).ready(function($){';
		
		echo '$( function() {
			$("form").sisyphus();
		});';
		echo '	
			var hash = window.location.hash.substr(2);
			if(hash != false && hash != \'undefined\'){
				$(\'#\'+hash+\'\').addClass(\'current\');		
				$(location.hash + \'.reply\').addClass(\'active\');
			};
		';
		
		if(get_option('mommaincontrol_momja') == 1){
			if(is_archive() || is_home() || is_search()){
				echo '
				$(\'input,textarea\').keydown(function(e){
					e.stopPropagation();
				});
				var hash = window.location.hash.substr(1);
				if(hash != false && hash != \'undefined\'){
					$(\'#\'+hash+\'\').addClass(\'current\');
					$(document).keydown(function(e){
					switch(e.which){
						case '.get_option('jump_around_4').':
							var $current = $(\''.get_option('jump_around_0').'.current\'),
							$prev_embed = $current.prev();
							$(\'html, body\').animate({scrollTop:$prev_embed.offset().top - 100}, 500);
							$current.removeClass(\'current\');
							$prev_embed.addClass(\'current\');
							window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
							e.preventDefault();
							return;
						break;
						case '.get_option('jump_around_6').': 
							var $current = $(\''.get_option('jump_around_0').'.current\'),
							$next_embed = $current.next(\''.get_option('jump_around_0').'\');
							$(\'html, body\').animate({scrollTop:$next_embed.offset().top - 100}, 500);
							$current.removeClass(\'current\');
							$next_embed.addClass(\'current\');
							window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
							e.preventDefault();
							return;
						break;
						case '.get_option('jump_around_5').': 
								if(jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\'))
								document.location.href=jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\');
								e.preventDefault();
								return;
								break;
						default: return; 
					}
				});
				}else{
				$(\''.get_option('jump_around_0').':eq(0)\').addClass(\'current\');
				$(document).keydown(function(e){
					switch(e.which){
						case '.get_option('jump_around_4').': 
							var $current = $(\''.get_option('jump_around_0').'.current\'),
							$prev_embed = $current.prev();
							$(\'html, body\').animate({scrollTop:$prev_embed.offset().top - 100}, 500);
							$current.removeClass(\'current\');
							$prev_embed.addClass(\'current\');
							window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
							e.preventDefault();
							return;
						break;
						case '.get_option('jump_around_6').': 
							var $current = $(\''.get_option('jump_around_0').'.current\'),
							$next_embed = $current.next(\''.get_option('jump_around_0').'\');
							$(\'html, body\').animate({scrollTop:$next_embed.offset().top - 100}, 500);
							$current.removeClass(\'current\');
							$next_embed.addClass(\'current\');
							window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
							e.preventDefault();
							return;
						break;
						case '.get_option('jump_around_5').': 
								if(jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\'))
								document.location.href=jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\');
								e.preventDefault();
								return;
								break;
					}
					
				});
				}
				if($(\''.get_option('jump_around_2').'\').is(\'*\')){
				$(document).keydown(function(e){
					switch(e.which){
						case '.get_option('jump_around_7').': 
							document.location.href=jQuery(\''.get_option('jump_around_2').'\').attr(\'href\');
							e.preventDefault();
							return;
							break;
					}
					
				});
				}
				if($(\''.get_option('jump_around_3').'\').is(\'*\')){
				$(document).keydown(function(e){
					switch(e.which){
						case '.get_option('jump_around_8').': 
							document.location.href=jQuery(\''.get_option('jump_around_3').'\').attr(\'href\');
							e.preventDefault();
							return;
							break;
					}
					
				});
				}
				';
			}
		}
		// Fitvids
		if(get_option('MOM_themetakeover_fitvids') != ''){
			$fitvidContainer = get_option('MOM_themetakeover_fitvids');
			echo '
			$(\''.$fitvidContainer.'\').fitVids();';
		}
		// Lazyload
		if(get_option('mommaincontrol_lazyload') == 1){
			$placeholder = plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/javascript/placeholder.png';
			echo '
			$("img").wrap(function(){
				if($(this).hasClass("skipLazy")){
				}else{
					$(this).wrap(function(){
						var newimg = \'<img src="'.$placeholder.'" data-original="\' + $(this).attr(\'src\') + \'" width="\' + $(this).attr(\'width\') + \'" height="\' + $(this).attr(\'height\') + \'" class="lazy \' + $(this).attr(\'class\') + \'">\';
						return newimg;
					});
					return \'<noscript>\';
				}
				});
			$("img.lazy").lazyload(
				{
				data_attribute: "original",
				skip_invisible: false
			});';
		}
		// Navbar
		if(get_option('MOM_themetakeover_topbar') == 1){
			echo '
			$(window).scroll(function(){
				var scroll = $(window).scrollTop();
					if(scroll >= 0){
						$(".momnavbar").addClass("stucktothetop");
				}else{
						$(".momnavbar").removeClass("stucktothetop");
				}
			});';	
		}
		if(get_option('MOM_themetakeover_topbar') == 2){
			echo '
			$(window).scroll(function(){
				var scroll = $(window).scrollTop();
					if(scroll >= 0){
						$(".momnavbar").addClass("stucktothebottom");
				}else{
						$(".momnavbar").removeClass("stucktothebottom");
				}
			});';	
		}		
		// Post/page list(s) / scroll-to-top arrow
		if(get_option('MOM_themetakeover_postdiv') != '' && get_option('MOM_themetakeover_postelement') != ''){
			if(is_single() || is_page()){
				$entrydiv = esc_attr(get_option('MOM_themetakeover_postdiv'));
				$entryele = esc_attr(get_option('MOM_themetakeover_postelement'));
				$entrytoggle = esc_attr(get_option('MOM_themetakeover_posttoggle'));
				echo '
				$("body").append("<div class=\'scrolltotop\'><a href=\'#top\'><i class=\'fa fa-arrow-up\'></i></a></div>"); 
				if($("'.$entrydiv.' > '.$entryele.'").length){
					$("'.$entrydiv.'").prepend("<hr /><span id=\'createalisttog\'><i class=\'fa fa-angle-up\'></i> '.$entrytoggle.'</span><span id=\'createalisttogd\' class=\'hidden\'><i class=\'fa fa-angle-down\'></i> '.$entrytoggle.'</span><div class=\'createalist_listitems hidden\'><ol></ol></div><hr />"); 
					$(function(){
						var list = $(\'.createalist_listitems ol\');
						$("'.$entrydiv.' '.$entryele.'").each(function(){
							$(this).prepend(\'<a name="\' + $(this).text() + \'"></a>\');
							$(list).append(\'<li><a href="#\' + $(this).text() + \'">\' +  $(this).text() + \'</a></li>\');
						});
						$(\'#createalisttog\').click(function(){
							$(\'.createalist_listitems\').removeClass(\'hidden\');
							$(\'#createalisttog\').addClass(\'hidden\');
							$(\'#createalisttogd\').removeClass(\'hidden\');
						});
						$(\'#createalisttogd\').click(function(){
							$(\'.createalist_listitems\').addClass(\'hidden\');
							$(\'#createalisttogd\').addClass(\'hidden\');
							$(\'#createalisttog\').removeClass(\'hidden\');
						});					
						$(window).scroll(function(){
							var scroll = $(window).scrollTop();
								if(scroll >= 500){
									$(".scrolltotop").addClass("show");
							}else{
									$(".scrolltotop").removeClass("show");
							}
						});
					});
				};';
			}
		}
		echo '
		});
		</script>';
	}
	add_action('wp_footer','MOMScriptsFooter',99999);
}
function my_optional_modules_main_control_install(){
	if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){
	$availableCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890./';
	$generateSalt = '';
	for($i = 0; $i < 22; $i++){
		$generateSalt .= $availableCharacters[rand(0, strlen($availableCharacters) - 1)];
	}
	add_option('mom_passwords_salt',$generateSalt);}
	else{update_option('mommaincontrol_momrups',0);}
	update_option('mommaincontrol_focus','');
	add_option('mommaincontrol_passwords_activated',1);					
	add_option('mommaincontrol_reviews_activated',1);
	add_option('mommaincontrol_shorts_activated',1);
}
if(get_option('mommaincontrol_momse') == 1 && get_option('MOM_themetakeover_youtubefrontpage') == ''){
		function MOMExclude404Redirection(){
				if(!is_user_logged_in()){
						if(get_option('MOM_Exclude_URL') != ''){$RedirectURL = esc_url(get_permalink(get_option('MOM_Exclude_URL')));}else{$RedirectURL = get_bloginfo('wpurl');}
				}else{
						if(get_option('MOM_Exclude_URL_User') != ''){$RedirectURL = esc_url(get_permalink(get_option('MOM_Exclude_URL_User')));}else{$RedirectURL = get_bloginfo('wpurl');}
				}
				global $wp_query;
				if($wp_query->is_404){
						wp_redirect($RedirectURL,301);exit;
				}
		}
	add_action('wp','MOMExclude404Redirection',1);
}
function mompaf_filter_home(){	
	if(is_home()){
		if(is_numeric(get_option('mompaf_post'))){
			$mompaf_front = get_option('mompaf_post');
		}else{
			$mompaf_front = '';
		}
		if(have_posts()):the_post();
		header('location:'.esc_url(get_permalink($mompaf_front)));exit;endif;
	}
}
function momMaintenance(){
	if(!is_user_logged_in() && get_option('mommaincontrol_maintenance') == 1){
		$maintenanceURL = esc_url(get_option('momMaintenance_url'));
		if($maintenanceURL == ''){
			die('Maintenance mode currently active.  Please try again later.');
		}else{
			header('location:'.$maintenanceURL);exit;
		}
	}else{
			
	}
}
function mom_remove_version_numbers($src){
	if(strpos($src,'ver='.get_bloginfo('version')))
		$src = remove_query_arg('ver',$src);
	return $src;
}
function mom_plugin_scripts(){
	wp_register_style('font_awesome', plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.css');
	wp_enqueue_style('font_awesome');
}
function mom_exclude_postformat_theme_support(){
	add_theme_support('post-formats', array('aside','gallery','link','image','quote','status','video','audio','chat'));
}
/****************************** SECTION B -/- (B3) Options ******************************/
if(current_user_can('manage_options')){
global $wpdb;
$regularboard_boards = $wpdb->prefix.'regularboard_boards';
$regularboard_posts = $wpdb->prefix.'regularboard_posts';
$regularboard_users = $wpdb->prefix.'regularboard_users';
$votesPosts = $wpdb->prefix.'momvotes_posts';
$votesVotes = $wpdb->prefix.'momvotes_votes';
$RUPs_table_name = $wpdb->prefix.'rotating_universal_passwords';
$review_table_name = $wpdb->prefix.'momreviews';
$verification_table_name = $wpdb->prefix.'momverification';
if(isset($_POST['MOM_UNINSTALL_EVERYTHING'])){
	add_option('mommaincontrol_regularboard_activated',1);
	add_option('mommaincontrol_passwords_activated',1);					
	add_option('mommaincontrol_reviews_activated',1);
	add_option('mommaincontrol_shorts_activated',1);
	add_option('mommaincontrol_votes_activated',1);
	if(get_option('mommaincontrol_regularboard_activated') == 0){$wpdb->query("DROP TABLE ".$regularboard_boards."");$wpdb->query("DROP TABLE ".$regularboard_posts."");$wpdb->query("DROP TABLE ".$regularboard_users."");}
	if(get_option('mommaincontrol_votes_activated') == 0){$wpdb->query("DROP TABLE ".$votesPosts."");$wpdb->query("DROP TABLE ".$votesVotes."");}
	if(get_option('mommaincontrol_passwords_activated') == 0){$wpdb->query("DROP TABLE ".$RUPs_table_name."");}
	if(get_option('mommaincontrol_reviews_activated') == 0){$wpdb->query("DROP TABLE ".$review_table_name."");}
	if(get_option('mommaincontrol_shorts_activated') == 0){$wpdb->query("DROP TABLE ".$verification_table_name."");}
	delete_option('mommaincontrol_regularboard_activated');
	delete_option('mommaincontrol_regularboard');
	delete_option('mommaincontrol_votes_activated');
	delete_option('mommaincontrol_protectrss');
	delete_option('MOM_themetakeover_extend');
	delete_option('MOM_themetakeover_backgroundimage');
	delete_option('MOM_themetakeover_topbar_search');
	delete_option('MOM_themetakeover_topbar_share');
	delete_option('MOM_themetakeover_topbar_color');
	delete_option('mommaincontrol_footerscripts');
	delete_option('mommaincontrol_authorarchives');
	delete_option('mommaincontrol_datearchives');
	delete_option('MOM_themetakeover_wowhead');
	delete_option('mom_passwords_salt');
	delete_option('mommaincontrol_obwcountplus');
	delete_option('mommaincontrol_momrups');
	delete_option('mommaincontrol_momse');
	delete_option('mommaincontrol_mompaf');
	delete_option('mommaincontrol_momja');
	delete_option('mommaincontrol_shorts');
	delete_option('mommaincontrol_analytics');
	delete_option('mommaincontrol_reviews');
	delete_option('mommaincontrol_fontawesome');
	delete_option('mommaincontrol_versionnumbers');
	delete_option('mommaincontrol_lazyload');
	delete_option('mommaincontrol_meta');
	delete_option('mommaincontrol_focus');
	delete_option('mommaincontrol_maintenance');
	delete_option('mommaincontrol_themetakeover');
	delete_option('mommaincontrol_setfocus');
	delete_option('mommaincontrol');
	delete_option('mompaf_post');
	delete_option('obwcountplus_1_countdownfrom');
	delete_option('obwcountplus_2_remaining');
	delete_option('obwcountplus_3_total');
	delete_option('obwcountplus_4_custom');
	delete_option('rotating_universal_passwords_1');
	delete_option('rotating_universal_passwords_2');
	delete_option('rotating_universal_passwords_3');
	delete_option('rotating_universal_passwords_4');
	delete_option('rotating_universal_passwords_5');
	delete_option('rotating_universal_passwords_6');
	delete_option('rotating_universal_passwords_7');
	delete_option('rotating_universal_passwords_8');	
	delete_option('MOM_Exclude_VisitorCategories');
	delete_option('MOM_Exclude_VisitorTags');
	delete_option('MOM_Exclude_Categories_Front');
	delete_option('MOM_Exclude_Categories_TagArchives');
	delete_option('MOM_Exclude_Categories_SearchResults');
	delete_option('MOM_Exclude_Tags_Front');
	delete_option('MOM_Exclude_Tags_CategoryArchives');
	delete_option('MOM_Exclude_Tags_SearchResults');
	delete_option('MOM_Exclude_PostFormats_Front');
	delete_option('MOM_Exclude_PostFormats_CategoryArchives');
	delete_option('MOM_Exclude_PostFormats_TagArchives');
	delete_option('MOM_Exclude_PostFormats_SearchResults');
	delete_option('MOM_Exclude_Categories_RSS');
	delete_option('MOM_Exclude_Tags_RSS');
	delete_option('MOM_Exclude_PostFormats_RSS');
	delete_option('MOM_Exclude_TagsSun');
	delete_option('MOM_Exclude_TagsMon');
	delete_option('MOM_Exclude_TagsTue');
	delete_option('MOM_Exclude_TagsWed');
	delete_option('MOM_Exclude_TagsThu');
	delete_option('MOM_Exclude_TagsFri');
	delete_option('MOM_Exclude_TagsSat');
	delete_option('MOM_Exclude_CategoriesSun');
	delete_option('MOM_Exclude_CategoriesMon');
	delete_option('MOM_Exclude_CategoriesTue');
	delete_option('MOM_Exclude_CategoriesWed');
	delete_option('MOM_Exclude_CategoriesThu');
	delete_option('MOM_Exclude_CategoriesFri');
	delete_option('MOM_Exclude_CategoriesSat');
	delete_option('MOM_Exclude_level0Categories');
	delete_option('MOM_Exclude_level1Categories');
	delete_option('MOM_Exclude_level2Categories');
	delete_option('MOM_Exclude_level7Categories');
	delete_option('MOM_Exclude_level0Tags');
	delete_option('MOM_Exclude_level1Tags');
	delete_option('MOM_Exclude_level2Tags');
	delete_option('MOM_Exclude_level7Tags');
	delete_option('MOM_Exclude_URL');
	delete_option('MOM_Exclude_URL_User');
	delete_option('MOM_Exclude_PostFormats_Visitor');
	delete_option('MOM_Exclude_NoFollow');
	delete_option('simple_announcement_with_exclusion_cat_visitor');
	delete_option('simple_announcement_with_exclusion_tag_visitor');
	delete_option('mommaincontrol_passwords_activated');
	delete_option('MOM_themetakeover_youtubefrontpage');
	delete_option('MOM_themetakeover_topbar');
	delete_option('MOM_themetakeover_archivepage');
	delete_option('MOM_themetakeover_fitvids');
	delete_option('MOM_themetakeover_postdiv');
	delete_option('MOM_themetakeover_postelement');
	delete_option('MOM_themetakeover_posttoggle');
	delete_option('mommaincontrol_shorts_activated');
	delete_option('jump_around_0');
	delete_option('jump_around_1');
	delete_option('jump_around_2');
	delete_option('jump_around_3');
	delete_option('jump_around_4');
	delete_option('jump_around_5');
	delete_option('jump_around_6');
	delete_option('jump_around_7');
	delete_option('jump_around_8');
	delete_option('mommaincontrol_reviews_activated');
	delete_option('momanalytics_code');
	delete_option('momreviews_css');
	delete_option('momreviews_search');
	delete_option('momMaintenance_url');
	delete_option('mommaincontrol_votes');
}else{	
	// Form handling for options a
	if(isset($_POST['MOMsave'])){}
	if(isset($_POST['mom_regularboard_mode_submit'])){update_option('mommaincontrol_regularboard',$_REQUEST['regularboard']);}
	if(isset($_POST['mom_themetakeover_mode_submit'])){update_option('mommaincontrol_themetakeover',$_REQUEST['themetakeover']);}
	if(isset($_POST['mom_protectrss_mode_submit'])){update_option('mommaincontrol_protectrss',$_REQUEST['protectrss']);}
	if(isset($_POST['mom_footerscripts_mode_submit'])){update_option('mommaincontrol_footerscripts',$_REQUEST['footerscripts']);}
	if(isset($_POST['mom_author_archives_mode_submit'])){update_option('mommaincontrol_authorarchives',$_REQUEST['authorarchives']);}
	if(isset($_POST['mom_date_archives_mode_submit'])){update_option('mommaincontrol_datearchives',$_REQUEST['datearchives']);}
	if(isset($_POST['mom_count_mode_submit'])){update_option('mommaincontrol_obwcountplus',$_REQUEST['countplus']);}
	if(isset($_POST['mom_votes_mode_submit'])){update_option('mommaincontrol_votes',$_REQUEST['votes']);}
	if(isset($_POST['mom_exclude_mode_submit'])){update_option('mommaincontrol_momse',$_REQUEST['exclude']);}
	if(isset($_POST['mom_jumparound_mode_submit'])){update_option('mommaincontrol_momja',$_REQUEST['jumparound']);}
	if(isset($_POST['mom_passwords_mode_submit'])){update_option('mommaincontrol_momrups',$_REQUEST['passwords']);}
	if(isset($_POST['mom_reviews_mode_submit'])){update_option('mommaincontrol_reviews',$_REQUEST['reviews']);}
	if(isset($_POST['mom_shortcodes_mode_submit'])){update_option('mommaincontrol_shorts',$_REQUEST['shortcodes']);}
	if(isset($_POST['MOMclear'])){update_option('mommaincontrol_focus','');}
	if(isset($_POST['MOMthemetakeover'])){update_option('mommaincontrol_focus','themetakeover');}
	if(isset($_POST['MOMexclude'])){update_option('mommaincontrol_focus','exclude');}
	if(isset($_POST['MOMfontfa'])){update_option('mommaincontrol_focus','fontfa');}
	if(isset($_POST['MOMcount'])){update_option('mommaincontrol_focus','count');}
	if(isset($_POST['MOMjumparound'])){update_option('mommaincontrol_focus','jumparound');}
	if(isset($_POST['MOMpasswords'])){update_option('mommaincontrol_focus','passwords');}
	if(isset($_POST['MOMreviews'])){update_option('mommaincontrol_focus','reviews');}
	if(isset($_POST['MOMshortcodes'])){update_option('mommaincontrol_focus','shortcodes');}
	if(isset($_POST['mom_postasfront_post_submit'])){update_option('momMaintenance_url',$_REQUEST['momMaintenance_url']);}
	if(isset($_POST['mom_postasfront_post_submit'])){update_option('momanalytics_code',$_REQUEST['momanalytics_code']);}
	if(isset($_POST['mom_postasfront_post_submit'])){update_option('mompaf_post',$_REQUEST['mompaf_post']);}
	if(isset($_POST['mom_fontawesome_mode_submit'])){update_option('mommaincontrol_fontawesome',$_REQUEST['mommaincontrol_fontawesome']);}
	if(isset($_POST['mom_lazy_mode_submit'])){update_option('mommaincontrol_lazyload',$_REQUEST['mommaincontrol_lazyload']);}
	if(isset($_POST['mom_versions_submit'])){update_option('mommaincontrol_versionnumbers',$_REQUEST['mommaincontrol_versionnumbers']);}
	if(isset($_POST['mom_meta_mode_submit'])){update_option('mommaincontrol_meta',$_REQUEST['mommaincontrol_meta']);}
	if(isset($_POST['mom_maintenance_mode_submit'])){update_option('mommaincontrol_maintenance',$_REQUEST['maintenanceMode']);}
	if(isset($_POST['mom_analytics_mode_submit'])){update_option('mommaincontrol_analytics',$_REQUEST['analytics']);}
	if(isset($_POST['mom_postasfront_mode_submit'])){update_option('mommaincontrol_mompaf',$_REQUEST['postasfront']);
	if(!get_option('mommaincontrol_mompaf')){add_option('mompaf_post',0);}}
	if(isset($_POST['mom_count_mode_submit'])){add_option('obwcountplus_1_countdownfrom',0);}
	if(isset($_POST['mom_count_mode_submit'])){add_option('obwcountplus_2_remaining','remaining');}
	if(isset($_POST['mom_count_mode_submit'])){add_option('obwcountplus_3_total','total');}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_0','post');}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_1','entry-title');}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_2','previous-link');}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_3','next-link');}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_4',65);}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_5',83);}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_6',68);}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_7',90);}
	if(isset($_POST['mom_jumparound_mode_submit'])){add_option('jump_around_8',88);}
	if(isset($_POST['mom_passwords_mode_submit'])){
		$availableCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890./';
		$generateSalt = '';
		for($i = 0; $i < 22; $i++){
			$generateSalt .= $availableCharacters[rand(0, strlen($availableCharacters) - 1)];
		}
		add_option('mom_passwords_salt',$generateSalt);
	}
	
	if(isset($_POST['mom_regularboard_mode_submit'])){
		add_option('mommaincontrol_regularboard_activated',1);
		if(get_option('mommaincontrol_regularboard_activated') == 1){
		$regularboardSQLa = "CREATE TABLE $regularboard_boards(
		ID INT(11) NOT NULL AUTO_INCREMENT , 
		NAME TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		SHORTNAME TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		DESCRIPTION TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		RULES TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		PRIMARY KEY  (ID)
		);";
		$regularboardSQLb = "CREATE TABLE $regularboard_posts(
		ID INT(11) NOT NULL AUTO_INCREMENT , 
		PARENT INT(11) NOT NULL ,
		IP INT(11) NOT NULL ,
		DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		EMAIL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		SUBJECT TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		COMMENT TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		BOARD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		MODERATOR TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		LAST TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		PRIMARY KEY  (ID)
		);";
		$regularboardSQLc = "CREATE TABLE $regularboard_users(
		ID INT(11) NOT NULL AUTO_INCREMENT , 
		IP INT(11) NOT NULL,
		PARENT INT(11) NOT NULL,
		BANNED INT(11) NOT NULL,
		MESSAGE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		PRIMARY KEY  (ID)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($regularboardSQLa);
		dbDelta($regularboardSQLb);
		dbDelta($regularboardSQLc);
		update_option('mommaincontrol_regularboard_activated',0);
		}
	}
	
	if(isset($_POST['mom_votes_mode_submit'])){
		add_option('mommaincontrol_votes_activated',1);					
		if(get_option('mommaincontrol_votes_activated') == 1){
		$votesSQLa = "CREATE TABLE $votesVotes(
		ID INT(11) NOT NULL AUTO_INCREMENT , 
		IP INT(11) NOT NULL,
		VOTE INT(11) NOT NULL,
		PRIMARY KEY  (ID)
		);";
		$votesSQLb = "CREATE TABLE $votesPosts(
		ID INT(11) NOT NULL AUTO_INCREMENT , 
		UP INT(11) NOT NULL,
		DOWN INT(11) NOT NULL,
		PRIMARY KEY  (ID)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($votesSQLa);	
		dbDelta($votesSQLb);	
		update_option('mommaincontrol_votes_activated',0);
		}
	}
	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_1','');}	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_2','');}	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_3','');}	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_4','');}	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_5','');}	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_6','');}	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_7','');}	
	if(isset($_POST['mom_passwords_mode_submit'])){add_option('rotating_universal_passwords_8','7');}	
	if(isset($_POST['mom_passwords_mode_submit'])){
		add_option('mommaincontrol_passwords_activated',1);					
		if(get_option('mommaincontrol_passwords_activated') == 1){
		$RUPs_sql = "CREATE TABLE $RUPs_table_name(
		ID INT(11) NOT NULL AUTO_INCREMENT , 
		DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		ATTEMPTS INT(11) NOT NULL, 
		IP INT(11) NOT NULL,
		PRIMARY KEY  (ID)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($RUPs_sql);	
		update_option('mommaincontrol_passwords_activated',0);
		}
	}
	if(isset($_POST['mom_postasfront_mode_submit'])){add_option('mompaf_post',0);}	
	if(isset($_POST['mom_reviews_mode_submit'])){
	add_option('mommaincontrol_reviews_activated',1);
	add_option('momreviews_search','');
	add_option('momreviews_css',"/* Colors */\n.momreview .block {background-color: #fff; color: #000;}\n.momreview section.reviewed {background-color: #fff; color: #000;}\n.momreview ::selection {background: #222; color: #fff;}\n.momreview label {color: #111; text-shadow: 1px 1px 2px #ccc;}\n/* Containers */\n.momreview {margin: 0 auto; width: 95%;}\n.momreview .block {padding-top: 5px; margin: 0 auto 0 auto;}\n.momreview label {width: 95%; min-height: 35px; margin: 0 auto; display: block; cursor: pointer;}\n.momreview .reviewed {width: 93%; height: 0; padding: 0 15px 0 15px; display: block; overflow: hidden; box-sizing: border-box; margin: auto;}\n/* Do not edit below this line */\n/* unless you know what you're doing. */\n.momreview label span {font-weight: bold; float:right;}\n.momreview input[type='checkbox']{display: none;}\n.momreview .block input[type='checkbox']:checked ~ .reviewed {height: auto; margin: -25px auto 5px auto;}\n.momreview .block input[type='checkbox'] ~ label span:first-of-type {display:block; visibility:visible; float:right; margin:0 -5px 0 0;}\n.momreview .block input[type='checkbox'] ~ label span:last-of-type,\n.momreview .block input[type='checkbox']:checked ~ label span:first-of-type {display:none; visibility:hidden; float:right;}\n.momreview .block input[type='checkbox']:checked ~ label span:last-of-type {display:block; visibility:visible; float:right;}\n");
	if(get_option('mommaincontrol_reviews_activated') == 1){
	global $wpdb;
	$review_table_name = $wpdb->prefix.'momreviews';
	$reviews_sql = "CREATE TABLE $review_table_name (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		LINK TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		TITLE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		REVIEW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		RATING TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		PRIMARY KEY  (ID)
	);";
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	dbDelta($reviews_sql);
	update_option('mommaincontrol_reviews_activated',0);
	}	
	}
	if(isset($_POST['mom_reviews_mode_submit'])){add_option('mommaincontrol_reviews_activated',1);}
	if(isset($_POST['mom_shortcodes_mode_submit'])){add_option('mommaincontrol_shorts_activated',1);}
	if(isset($_POST['mom_shortcodes_mode_submit'])){
	add_option('mommaincontrol_shorts_activated',1);
	if(get_option('mommaincontrol_shorts_activated') == 1){
		global $wpdb;
		$verification_table_name = $wpdb->prefix.'momverification';
		$verification_sql = "CREATE TABLE $verification_table_name(
			ID INT(11) NOT NULL AUTO_INCREMENT,
			POST INT(11) NOT NULL, 
			CORRECT INT(11) NOT NULL, 
			IP INT(11) NOT NULL,
			PRIMARY KEY  (ID)
		);";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($verification_sql);
		update_option('mommaincontrol_shorts_activated',0);
	}
	}
	if(isset($_POST['mom_maintenance_mode_submit'])){
			add_option('momMaintenance_url','');
		}
}
	if(isset($_POST['reset_rups'])){
		delete_option('rotating_universal_passwords_1');delete_option('rotating_universal_passwords_2');delete_option('rotating_universal_passwords_3');delete_option('rotating_universal_passwords_4');delete_option('rotating_universal_passwords_5');delete_option('rotating_universal_passwords_6');delete_option('rotating_universal_passwords_7');	
		add_option('rotating_universal_passwords_1','');add_option('rotating_universal_passwords_2','');add_option('rotating_universal_passwords_3','');add_option('rotating_universal_passwords_4','');add_option('rotating_universal_passwords_5','');add_option('rotating_universal_passwords_6','');add_option('rotating_universal_passwords_7','');	
	}
	if(
		isset($_POST['delete_unused_terms']) || 
		isset($_POST['delete_post_revisions']) || 
		isset($_POST['delete_unapproved_comments']) || 
		isset($_POST['deleteAllClutter'])) 
	{
		$postsTable = $table_prefix.'posts';
		$commentsTable = $table_prefix.'comments';
		$termsTable2 = $table_prefix.'terms';
		$termsTable = $table_prefix.'term_taxonomy';
		if(isset($_POST['delete_post_revisions'])){
			$wpdb->query("DELETE FROM `".$postsTable."` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");
		}
		if(isset($_POST['delete_unapproved_comments'])){
			$wpdb->query("DELETE FROM `".$commentsTable."` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
		}
		if(isset($_POST['delete_unused_terms'])){
			$wpdb->query("DELETE FROM `".$termsTable2."` WHERE `term_id` IN (select `term_id` from `".$termsTable."` WHERE `count` = 0)");
			$wpdb->query("DELETE FROM `".$termsTable."` WHERE `count` = 0");
		}
		if(isset($_POST['deleteAllClutter'])){
			$wpdb->query("DELETE FROM `".$postsTable."` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");
			$wpdb->query("DELETE FROM `".$commentsTable."` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
			$wpdb->query("DELETE FROM `".$termsTable2."` WHERE `term_id` IN (select `term_id` from `".$termsTable."` WHERE `count` = 0)");
			$wpdb->query("DELETE FROM `".$termsTable."` WHERE `count` = 0");
		}
	}
	// Module form saving 
	if(isset($_POST['passwordsSave'])){
		global $my_optional_modules_passwords_salt;
		foreach($_REQUEST as $k => $v){
			if($v != '')update_option($k,crypt($v,'$2a$'.$my_optional_modules_passwords_salt));
		}
		update_option('rotating_universal_passwords_8',$_REQUEST['rotating_universal_passwords_8']);
		update_option('mom_passwords_salt',$_REQUEST['mom_passwords_salt']);
	}	
	if(isset($_POST['momsesave'])){
		foreach($_REQUEST as $k => $v){
			update_option($k,unique_numbersonly_nospaces($v));
		}	
		update_option('MOM_Exclude_PostFormats_Visitor',sanitize_text_field($_REQUEST['MOM_Exclude_PostFormats_Visitor']));
		update_option('MOM_Exclude_PostFormats_RSS',sanitize_text_field($_REQUEST['MOM_Exclude_PostFormats_RSS']));
		update_option('MOM_Exclude_PostFormats_Front',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_Front'])));
		update_option('MOM_Exclude_PostFormats_CategoryArchives',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_CategoryArchives'])));
		update_option('MOM_Exclude_PostFormats_TagArchives',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_TagArchives'])));
		update_option('MOM_Exclude_PostFormats_SearchResults',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_SearchResults'])));
		update_option('MOM_Exclude_URL',$_REQUEST['MOM_Exclude_URL']);
		update_option('MOM_Exclude_URL_User',$_REQUEST['MOM_Exclude_URL_User']);
		update_option('MOM_Exclude_NoFollow',$_REQUEST['MOM_Exclude_NoFollow']);
		update_option('MOM_Exclude_Hide_Dashboard',$_REQUEST['MOM_Exclude_Hide_Dashboard']);
	}	
	if(isset($_POST['obwcountsave']) || isset($_POST['momthemetakeoversave']) || isset($_POST['update_JA'])){
		foreach($_REQUEST as $k => $v){
			update_option($k,$v);
		}	
	}
}
/****************************** SECTION C -/- (C0) Settings -/- Main Plugin Page ******************************/
if(current_user_can('manage_options')){
	// Add options page for plugin to Wordpress backend
	add_action('admin_menu','my_optional_modules_add_options_page');
	function my_optional_modules_add_options_page(){
		add_options_page('My Optional Modules','My Optional Modules','manage_options','mommaincontrol','my_optional_modules_page_content'); 
	}
	// Content to display on the options page
	function my_optional_modules_page_content(){
		echo '
		<div class="wrap">
		<code>my optional modules / <a href="http://www.onebillionwords.com/my-optional-modules/">documentation</a> / <a href="http://wordpress.org/support/view/plugin-reviews/my-optional-modules">rate and review</a></code>
		<code class="right"><a href="http://onebillionwords.com/">one billion words</a></code>
		<div class="myoptionalmodules">
		<code>click a module to <strong class="on">activate</strong>/<strong class="off">deactivate</strong> it.</code>
		<section>
		<div class="small left">
		<form method="post" name="momReviews"><label for="mom_reviews_mode_submit" class="onoff';if(get_option('mommaincontrol_reviews') == 1){echo '1';}else{echo '0';}echo'">Reviews<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_reviews') == 1){echo '0';}if(get_option('mommaincontrol_reviews') == 0){echo '1';}echo '" name="reviews" /><input type="submit" id="mom_reviews_mode_submit" name="mom_reviews_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="momCount"><label for="mom_count_mode_submit" class="onoff';if(get_option('mommaincontrol_obwcountplus') == 1){echo '1';}else{echo '0';}echo'">Count++<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_obwcountplus') == 1){echo '0';}if(get_option('mommaincontrol_obwcountplus') == 0){echo '1';}echo '" name="countplus" /><input type="submit" id="mom_count_mode_submit" name="mom_count_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="momExclude"><label for="mom_exclude_mode_submit" class="onoff';if(get_option('mommaincontrol_momse') == 1){echo '1';}else{echo '0';}echo'">Exclude<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_momse') == 1){echo '0';}if(get_option('mommaincontrol_momse') == 0){echo '1';}echo '" name="exclude" /><input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="momVotes"><label for="mom_votes_mode_submit" class="onoff';if(get_option('mommaincontrol_votes') == 1){echo '1';}else{echo '0';}echo'">Post votes<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_votes') == 1){echo '0';}if(get_option('mommaincontrol_votes') == 0){echo '1';}echo '" name="votes" /><input type="submit" id="mom_votes_mode_submit" name="mom_votes_mode_submit" value="Submit" class="hidden" /></form>
		</div>
		<div class="small left">
		<form method="post" action="" name="momJumpAround"><label for="mom_jumparound_mode_submit" class="onoff';if(get_option('mommaincontrol_momja') == 1){echo '1';}else{echo '0';}echo'">Jump Around<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_momja') == 1){echo '0';}if(get_option('mommaincontrol_momja') == 0){echo '1';}echo '" name="jumparound" /><input type="submit" id="mom_jumparound_mode_submit" name="mom_jumparound_mode_submit" value="Submit" class="hidden" /></form>';
		if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){ echo '<form method="post" action="" name="momPasswords"><label for="mom_passwords_mode_submit" class="onoff';if(get_option('mommaincontrol_momrups') == 1){echo '1';}else{echo '0';}echo'">Passwords<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_momrups') == 1){echo '0';}if(get_option('mommaincontrol_momrups') == 0){echo '1';}echo '" name="passwords" /><input type="submit" id="mom_passwords_mode_submit" name="mom_passwords_mode_submit" value="Submit" class="hidden" /></form>';}
		echo '<form method="post" action="" name="momShortcodes"><label for="mom_shortcodes_mode_submit" class="onoff';if(get_option('mommaincontrol_shorts') == 1){echo '1';}else{echo '0';}echo'">Shortcodes<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_shorts') == 1){echo '0';}if(get_option('mommaincontrol_shorts') == 0){echo '1';}echo '" name="shortcodes" /><input type="submit" id="mom_shortcodes_mode_submit" name="mom_shortcodes_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="protectrss"><label for="mom_protectrss_mode_submit" class="onoff';if(get_option('mommaincontrol_protectrss') == 1){echo '1';}else{echo '0';}echo'">&copy; RSS feed<span></span></label><input class="hidden" type="text" value="';if(get_option('mommaincontrol_protectrss') == 1){echo '0';}if(get_option('mommaincontrol_protectrss') == 0){echo '1';}echo '" name="protectrss" /><input type="submit" id="mom_protectrss_mode_submit" name="mom_protectrss_mode_submit" value="Submit" class="hidden" /></form>
		</div>
		<div class="small left">
		<form method="post" action="" name="momThemTakeover"><label for="mom_themetakeover_mode_submit" class="onoff';if(get_option('mommaincontrol_themetakeover') == 1){echo '1';}else{echo '0';}echo'">Theme Takeover<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_themetakeover') == 1){echo '0';}if(get_option('mommaincontrol_themetakeover') == 0){echo '1';}echo '" name="themetakeover" /><input type="submit" id="mom_themetakeover_mode_submit" name="mom_themetakeover_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="fontawesome"><label for="mom_fontawesome_mode_submit" class="onoff';if(get_option('mommaincontrol_fontawesome') == 1){echo '1';}else{echo '0';}echo'">Font Awesome<span></span></label><input class="hidden" type="text" value="';if(get_option('mommaincontrol_fontawesome') == 1){echo '0';}if(get_option('mommaincontrol_fontawesome') == 0){echo '1';}echo '" name="mommaincontrol_fontawesome" /><input type="submit" id="mom_fontawesome_mode_submit" name="mom_fontawesome_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="hidewpversions"><label for="mom_versions_submit" class="onoff';if(get_option('mommaincontrol_versionnumbers') == 1){echo '1';}else{echo '0';}echo'">Hide WP Version<span></span></label><input class="hidden" type="text" value="';if(get_option('mommaincontrol_versionnumbers') == 1){echo '0';}if(get_option('mommaincontrol_versionnumbers') == 0){echo '1';}echo '" name="mommaincontrol_versionnumbers" /><input type="submit" id="mom_versions_submit" name="mom_versions_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="footerscripts"><label for="mom_footerscripts_mode_submit" class="onoff';if(get_option('mommaincontrol_footerscripts') == 1){echo '1';}else{echo '0';}echo'">Move JS to Footer<span></span></label><input class="hidden" type="text" value="';if(get_option('mommaincontrol_footerscripts') == 1){echo '0';}if(get_option('mommaincontrol_footerscripts') == 0){echo '1';}echo '" name="footerscripts" /><input type="submit" id="mom_footerscripts_mode_submit" name="mom_footerscripts_mode_submit" value="Submit" class="hidden" /></form>
		</div>
		<div class="small left">
		<form method="post" action="" name="lazyload"><label for="mom_lazy_mode_submit" class="onoff';if(get_option('mommaincontrol_lazyload') == 1){echo '1';}else{echo '0';}echo'">Lazy Load<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_lazyload') == 1){echo '0';}if(get_option('mommaincontrol_lazyload') == 0){echo '1';}echo '" name="mommaincontrol_lazyload" /><input type="submit" id="mom_lazy_mode_submit" name="mom_lazy_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="meta"><label for="mom_meta_mode_submit" class="onoff';if(get_option('mommaincontrol_meta') == 1){echo '1';}else{echo '0';}echo'">Meta<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_meta') == 1){echo '0';}if(get_option('mommaincontrol_meta') == 0){echo '1';}echo '" name="mommaincontrol_meta" /><input type="submit" id="mom_meta_mode_submit" name="mom_meta_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="authorarchives"><label for="mom_author_archives_mode_submit" class="onoff';if(get_option('mommaincontrol_authorarchives') == 1){echo '1';}else{echo '0';}echo'">Disable Authors<span></span></label><input class="hidden" type="text" value="';if(get_option('mommaincontrol_authorarchives') == 1){echo '0';}if(get_option('mommaincontrol_authorarchives') == 0){echo '1';}echo '" name="authorarchives" /><input type="submit" id="mom_author_archives_mode_submit" name="mom_author_archives_mode_submit" value="Submit" class="hidden" /></form>
		<form method="post" action="" name="datearchives"><label for="mom_date_archives_mode_submit" class="onoff';if(get_option('mommaincontrol_datearchives') == 1){echo '1';}else{echo '0';}echo'">Disable Dates<span></span></label><input class="hidden" type="text" value="';if(get_option('mommaincontrol_datearchives') == 1){echo '0';}if(get_option('mommaincontrol_datearchives') == 0){echo '1';}echo '" name="datearchives" /><input type="submit" id="mom_date_archives_mode_submit" name="mom_date_archives_mode_submit" value="Submit" class="hidden" /></form>
		</div>';

		echo '<div class="small left">
		<form method="post" action="" name="regularboard"><label for="mom_regularboard_mode_submit" class="onoff';if(get_option('mommaincontrol_regularboard') == 1){echo '1';}else{echo '0';}echo'">Regular Board<span></span></label><input class="hidden" type="text" value="';if(get_option('mommaincontrol_regularboard') == 1){echo '0';}if(get_option('mommaincontrol_regularboard') == 0){echo '1';}echo '" name="regularboard" /><input type="submit" id="mom_regularboard_mode_submit" name="mom_regularboard_mode_submit" value="Submit" class="hidden" /></form>
		';
		if(!isset($_POST['mom_delete_step_one'])){
		echo '
		<section>
			<form method="post" action="" name="mom_delete_step_one">
			<label for="mom_delete_step_one" class="onoff0">
				Uninstall<span><i class="fa fa-exclamation"></i></span>
			</label>
			<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hidden" value="Submit" />
			</form>
		</section>';
		}
		if(isset($_POST['mom_delete_step_one'])){
		echo '
		<section>
			<form method="post" action="" name="MOM_UNINSTALL_EVERYTHING">
			<label for="MOM_UNINSTALL_EVERYTHING" class="onoff1">
				Confirm this<span><i class="fa fa-exclamation-circle"></i></span>
			</label>
			<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hidden" value="Submit" />
			</form>
		</section>';
		}			
		echo '
		</div>
		</section>
		</div>
		<div class="myoptionalmodules">
		<section>
		<div class="small left">
		<form method="post" action="" name="momAnalytics"><label for="mom_analytics_mode_submit" class="onoff';if(get_option('mommaincontrol_analytics') == 1){echo '1';}else{echo '0';}echo'">Analytics<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_analytics') == 1){echo '0';}else{echo '1';}echo '" name="analytics" /><input type="submit" id="mom_analytics_mode_submit" name="mom_analytics_mode_submit" class="hidden" value="Submit" /></form>
		<form method="post" action="" name="momMaintenance"><label for="mom_maintenance_mode_submit" class="onoff';if(get_option('mommaincontrol_maintenance') == 1){echo '1';}else{echo '0';}echo'">Maintenance<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_maintenance') == 1){echo '0';}else{echo '1';}echo '" name="maintenanceMode" class="hidden" /><input type="submit" id="mom_maintenance_mode_submit" name="mom_maintenance_mode_submit" class="hidden" value="Submit" /></form>
		<form method="post" action="" name="mompaf"><label for="mom_postasfront_mode_submit" class="onoff';if(get_option('mommaincontrol_mompaf') == 1){echo '1';}else{echo '0';}echo'">Post as Front<span></span></label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_mompaf') == 1){echo '0';}else{echo '1';}echo '" name="postasfront" class="hidden" /><input type="submit" id="mom_postasfront_mode_submit" name="mom_postasfront_mode_submit" class="hidden" value="Submit" /></form>
		</div>
		<div class="small left">
		<form method="post" action=""><input onClick="this.select();" type="text" value="'.get_option('momanalytics_code').'" name="momanalytics_code" placeholder="UA-XXXXXXXX-X" />
		<input placeholder="http://url.tld" onClick="this.select();" type="text" value="'.get_option('momMaintenance_url').'" name="momMaintenance_url" />
		<select name="mompaf_post" id="mompaf_0"><option value="0" ';if(get_option('mompaf_post') == 0){echo 'selected="selected"';}echo '/>Latest post</option>';$showmeposts = get_posts(array('posts_per_page' => -1)); foreach($showmeposts as $postsshown){echo '<option name="mompaf_post" id="mompaf_'.$postsshown->ID.'" value="'.$postsshown->ID.'"'; if(get_option('mompaf_post') == $postsshown->ID){echo ' selected="selected"';}echo '>'.$postsshown->post_title.'</option>';}echo '</select>
		</div>
		<div class="small left">
		<label for="mom_postasfront_post_submit" class="onoff1_solo">Save<span></span></label><input type="submit" id="mom_postasfront_post_submit" name="mom_postasfront_post_submit" value="Submit" class="hidden"></form>
		</div>
		</section>
		</div>
		<div class="myoptionalmodules">
		<code>Clutter clogs up your database.  Click one to get rid of it.</code>
		<section>
		<div class="large left">';
		my_optional_modules_cleaner_module();
		echo '
		</div>
		</section>
		</div>
		<div class="myoptionalmodules">
		<section>
		<code>If a module is <strong class="on">activated</strong>, you can configure it by clicking on its link in this box.</code>
		<form method="post" class="topnavigation"><section><label class="configurationlabel" for="MOMclear">Home</label><input id="MOMclear" name="MOMclear" class="hidden" type="submit"></section>';
		if(get_option('mommaincontrol_obwcountplus') == 1 || get_option('mommaincontrol_momse') == 1 || get_option('mommaincontrol_momrups') == 1 || get_option('mommaincontrol_momja') == 1 || get_option('mommaincontrol_shorts') == 1 || get_option('mommaincontrol_reviews') == 1 || get_option('mommaincontrol_themetakeover') == 1){
		if(get_option('mommaincontrol_obwcountplus') == 1){echo '<section><label class="configurationlabel" for="MOMcount"></i>Count++</label><input id="MOMcount" name="MOMcount" class="hidden" type="submit"></section>';}
		if(get_option('mommaincontrol_momse') == 1){echo '<section><label class="configurationlabel" for="MOMexclude">Exclude</label><input id="MOMexclude" name="MOMexclude" class="hidden" type="submit"></section>';}
		if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){if(get_option('mommaincontrol_momrups') == 1){echo '<section><label class="configurationlabel" for="MOMpasswords">Passwords</label><input id="MOMpasswords" name="MOMpasswords" class="hidden" type="submit"></section>';}}
		if(get_option('mommaincontrol_momja') == 1){echo '<section><label class="configurationlabel" for="MOMjumparound">Jump Around</label><input id="MOMjumparound" name="MOMjumparound" class="hidden" type="submit"></section>';}
		if(get_option('mommaincontrol_reviews') == 1){echo '<section><label class="configurationlabel" for="MOMreviews">Reviews</label><input id="MOMreviews" name="MOMreviews" class="hidden" type="submit"></section>';}
		if(get_option('mommaincontrol_shorts') == 1){echo '<section><label class="configurationlabel" for="MOMshortcodes"></i>Shortcodes</label><input id="MOMshortcodes" name="MOMshortcodes" class="hidden" type="submit"></section>';}if(get_option('mommaincontrol_themetakeover') == 1){echo '<section><label class="configurationlabel" for="MOMthemetakeover"></i>Takeover</label><input id="MOMthemetakeover" name="MOMthemetakeover" class="hidden" type="submit"></section>';}
		echo '</form>';}
		echo '
		</section>
		</div>';
		if(get_option('mommaincontrol_focus') != ''){
			echo '
			<div class="panelSection clear plugin">';
			if(get_option('mommaincontrol_obwcountplus') == 1 && get_option('mommaincontrol_focus') == 'count'){my_optional_modules_count_module();}
			elseif(get_option('mommaincontrol_momse') == 1 && get_option('mommaincontrol_focus') == 'exclude'){my_optional_modules_exclude_module();}
			elseif(get_option('mommaincontrol_momja') == 1 && get_option('mommaincontrol_focus') == 'jumparound'){my_optional_modules_jump_around_module();}
			elseif(get_option('mommaincontrol_momrups') == 1 && get_option('mommaincontrol_focus') == 'passwords'){my_optional_modules_passwords_module();}
			elseif(get_option('mommaincontrol_reviews') == 1 && get_option('mommaincontrol_focus') == 'reviews'){my_optional_modules_reviews_module();}
			elseif(get_option('mommaincontrol_shorts') == 1 && get_option('mommaincontrol_focus') == 'shortcodes'){my_optional_modules_shortcodes_module();}
			elseif(get_option('mommaincontrol_themetakeover') == 1 && get_option('mommaincontrol_focus') == 'themetakeover'){my_optional_modules_theme_takeover_module();}
			echo '</div>';
		}else{
			if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){}else{ '<code>CRYPT_BLOWFISH is not available.  Passwords module disabled.</code><br />';}
			if(!isset($_POST['generateHash']))echo '<form action="" method="post" name="generateHash"><input type="submit" name="generateHash" id="generateHash" value="Generate the file hash to check."/></form>';
			if(isset($_POST['generateHash'])){
				echo '<code>The has generated for this file is: <strong class="on">';
				$file = plugin_dir_path( __FILE__ ).'plugin.php';
				$file_handler = fopen($file,'r'); 
				$contents = fread($file_handler, filesize($file)); 
				fclose($file_handler); 
				$contents = esc_attr($contents);
				$contents = str_replace(array("\n","\t","\r"),"",$contents);
				echo hash('sha1',$contents);
				echo '</strong></code>';
			}
		}
	echo '</div>';
	}
}
/****************************** SECTION D -/- (D0) Settings -/- Passwords ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_passwords_module(){
		echo '<span class="moduletitle">__passwords<em>[rups]hide this content[/rups]</em></span><div class="clear"></div><div class="settings">';
		echo '
			<form method="post">
				<div class="countplus">
					<section><label for="rotating_universal_passwords_1">Sunday:</label>
					<input type="text" name="rotating_universal_passwords_1" '; 
					if(get_option('rotating_universal_passwords_1') !== ''){
						echo 'placeholder="Hashed and set."'; 
					}else{
					echo 'class="notset" placeholder="password not set"';}
					echo ' /></section>
					<section><label for="rotating_universal_passwords_2">Monday:</label>
					<input type="text" name="rotating_universal_passwords_2" ';
					if(get_option('rotating_universal_passwords_2') !== ''){
						echo 'placeholder="Hashed and set."';
					}else{
					echo 'class="notset" placeholder="password not set"';}
					echo ' /></section>
					<section><label for="rotating_universal_passwords_3">Tuesday:</label>
					<input type="text" name="rotating_universal_passwords_3" '; 
					if(get_option('rotating_universal_passwords_3') !== ''){
						echo 'placeholder="Hashed and set."'; 
					}else{
					echo 'class="notset" placeholder="password not set"';}
					echo ' /></section>
					<section><label for="rotating_universal_passwords_4">Wednesday:</label>
					<input type="text" name="rotating_universal_passwords_4" '; 
					if(get_option('rotating_universal_passwords_4') !== ''){
						echo 'placeholder="Hashed and set."'; 
					}else{
					echo 'class="notset" placeholder="password not set"';}
					echo ' /></section>
					<section><label for="rotating_universal_passwords_5">Thursday:</label>
					<input type="text" name="rotating_universal_passwords_5" '; 
					if(get_option('rotating_universal_passwords_5') !== ''){
						echo 'placeholder="Hashed and set."'; 
					}else{
					echo 'class="notset" placeholder="password not set"';}
					echo ' /></section>
					<section><label for="rotating_universal_passwords_6">Friday:</label>
					<input type="text" name="rotating_universal_passwords_6" '; 
					if(get_option('rotating_universal_passwords_6') !== ''){
						echo 'placeholder="Hashed and set."'; 
					}else{
					echo 'class="notset" placeholder="password not set"';}
					echo ' /></section>
					<section><label for="rotating_universal_passwords_7">Saturday:</label>
					<input type="text" name="rotating_universal_passwords_7" '; 
					if(get_option('rotating_universal_passwords_7') !== ''){
						echo 'placeholder="Hashed and set."'; 
					}else{
					echo 'class="notset" placeholder="password not set"';}
					echo ' /></section>
					<section><label for="rotating_universal_passwords_8">Attempts before lockout:</label>
					<input type="text" name="rotating_universal_passwords_8" value="'; 
					if(get_option('rotating_universal_passwords_8') !== ''){
						echo get_option('rotating_universal_passwords_8');
					}echo '" /></section>
					<section><label for="mom_passwords_salt">Salt (22 characters/(a-Z,0-9,./ <strong>only</strong>)</label>
					<input type="text" maxlength="22" name="mom_passwords_salt" value="'; 
					if(get_option('mom_passwords_salt') !== ''){
						echo get_option('mom_passwords_salt');
					}echo '" /></section>					
					</div>
					<input type="submit" name="passwordsSave" id="passwordsSave" value="Save changes" />
					<input type="submit" name="reset_rups" id="reset_rups" value="Reset passwords" />
			</form>
			<div class="clear new">
			<div class="lockouts">
			<h2>Current locks</h2>
				<div class="clear locked">
					<span><strong>Date/time</strong></span>
					<span>User ID</span>
					<span>Originating post</span>
					<span>Clear</span>
				</div>';
				global $wpdb;
				$RUPs_attempts_amount = get_option('rotating_universal_passwords_8');
				$RUPs_table_name = $wpdb->prefix.'rotating_universal_passwords';
				$RUPs_locks = $wpdb->get_results("SELECT ID,DATE,IP,URL FROM $RUPs_table_name WHERE ATTEMPTS >= $RUPs_attempts_amount ORDER BY ID DESC");
				foreach($RUPs_locks as $RUPs_locks_admin){
					$this_ID = $RUPs_locks_admin->ID;
					echo '
					<div class="clear locked">
					<span><strong>'.$RUPs_locks_admin->DATE.'</strong></span>
					<span>'.$RUPs_locks_admin->IP.'</span>
					<span><a href="'.$RUPs_locks_admin->URL.'">Link</a></span>
					<span><form method="post" class="RUPs_item_form"><input type="submit" name="'.$this_ID.'" value="Clear lock"></span></form>
					</div>
					';
					if(isset($_POST[$this_ID])){
						$wpdb->query("DELETE FROM $RUPs_table_name WHERE ID = '$this_ID'");
					}
				}
		echo '</div></div></div>';
	}
}
/****************************** SECTION D -/- (D1) Functions -/- Passwords ******************************/
function rotating_universal_passwords_shortcode($atts, $content = null){
	if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){
		ob_start();
		global $passwordField;
		global $my_optional_modules_passwords_salt;
		$passwordField++;	
		if(isset($_SERVER["REMOTE_ADDR"])){
			$RUPs_origin = esc_attr($_SERVER["REMOTE_ADDR"]);
		} else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$RUPs_origin = esc_attr($_SERVER["HTTP_X_FORWARDED_FOR"]); 
		} else if(isset($_SERVER["HTTP_CLIENT_IP"])){
			$RUPs_origin = esc_attr($_SERVER["HTTP_CLIENT_IP"]); 
		}
		$RUPs_ip_addr = $RUPs_origin;
		$RUPs_s32int = ip2long($RUPs_ip_addr);
		$RUPs_us32str = sprintf("%u",$RUPs_s32int);
		if(date('N') === '7'){$rotating_universal_passwords_todays_password = get_option('rotating_universal_passwords_1');$rotating_universal_passwords_today_is = 'Sunday';}
		if(date('N') === '1'){$rotating_universal_passwords_todays_password = get_option('rotating_universal_passwords_2');$rotating_universal_passwords_today_is = 'Monday';}
		if(date('N') === '2'){$rotating_universal_passwords_todays_password = get_option('rotating_universal_passwords_3');$rotating_universal_passwords_today_is = 'Tuesday';}
		if(date('N') === '3'){$rotating_universal_passwords_todays_password = get_option('rotating_universal_passwords_4');$rotating_universal_passwords_today_is = 'Wednesday';}
		if(date('N') === '4'){$rotating_universal_passwords_todays_password = get_option('rotating_universal_passwords_5');$rotating_universal_passwords_today_is = 'Thursday';}
		if(date('N') === '5'){$rotating_universal_passwords_todays_password = get_option('rotating_universal_passwords_6');$rotating_universal_passwords_today_is = 'Friday';}
		if(date('N') === '6'){$rotating_universal_passwords_todays_password = get_option('rotating_universal_passwords_7');$rotating_universal_passwords_today_is = 'Saturday';}
			if($rotating_universal_passwords_todays_password != ''){
			$rups_md5passa = crypt($_REQUEST['rups_pass'],'$2a$'.$my_optional_modules_passwords_salt);
			global $wpdb;
			$RUPs_table_name = $wpdb->prefix.'rotating_universal_passwords';
			$RUPs_result = $wpdb->get_results("SELECT ID FROM $RUPs_table_name WHERE IP = '".$RUPs_s32int."'");
			if(isset($_POST['rups_pass'])){
				if($rups_md5passa === $rotating_universal_passwords_todays_password){
					if(count($RUPs_result) > 0){
						$RUPs_table_name = $wpdb->prefix.'rotating_universal_passwords';
						$wpdb->query("DELETE FROM $RUPs_table_name WHERE IP = '$RUPs_s32int'");
				}
					return $content;
				}else{
					$RUPs_date = date('Y-m-d H:i:s');
					$RUPs_table_name = $wpdb->prefix.'rotating_universal_passwords';
					$RUPs_URL = esc_url(get_permalink());
					if(count($RUPs_result) > 0){
						$wpdb->query("UPDATE $RUPs_table_name SET ATTEMPTS = ATTEMPTS + 1 WHERE IP = $RUPs_s32int");
						$wpdb->query("UPDATE $RUPs_table_name SET DATE = '$RUPs_date' WHERE IP = $RUPs_s32int");
						$wpdb->query("UPDATE $RUPs_table_name SET URL = '".esc_url(get_permalink())."' WHERE IP = $RUPs_s32int");
					}else{
						$wpdb->query("INSERT INTO $RUPs_table_name (ID, DATE, IP, ATTEMPTS, URL) VALUES ('','$RUPs_date','$RUPs_s32int','1','$RUPs_URL')") ;
					}
				}
			}
			$RUPs_attempts = $wpdb->get_results("SELECT DATE,ATTEMPTS FROM $RUPs_table_name WHERE IP = '".$RUPs_s32int."'");
			if(count($RUPs_attempts) > 0){
				foreach($RUPs_attempts as $RUPs_attempt_count){
					$RUPs_attempted = $RUPs_attempt_count->ATTEMPTS;
					$RUPs_dated = $RUPs_attempt_count->DATE;
					if($RUPs_attempted < get_option('rotating_universal_passwords_8')){
						$attempts = get_option('rotating_universal_passwords_8');
						$attemptsLeft = $attempts - $RUPs_attempted . ' attempts left.';
						if(isset($_POST)){
							echo '<form method="post" name="password_'.$passwordField.'" id="RUPS'.$passwordField.'" action="'.esc_url(get_permalink()).'">';
							wp_nonce_field('password_'.$passwordField);
							echo '<input type="text" class="password" name="rups_pass" placeholder="'.$attemptsLeft.'Enter the password for '.esc_attr($rotating_universal_passwords_today_is).'." >
							<input type="submit" name="submit" class="hidden" value="Submit">
							</form>';
						}
					}
					elseif($RUPs_attempted >= get_option('rotating_universal_passwords_8')){
						echo "<blockquote>You have been locked out.  If you feel this is an error, please contact the admin with the following <strong>id:".$RUPs_s32int."</strong> to inquire further.</blockquote>";
					}else{			
						if(isset($_POST)){
							echo '<form method="post" name="password_'.$passwordField.'" id="RUPS'.$passwordField.'" action="'.esc_url(get_permalink()).'">';
							wp_nonce_field('password_'.$passwordField);
							echo '<input type="text" class="password" name="rups_pass" placeholder="'.$attemptsLeft.'Enter the password for '.esc_attr($rotating_universal_passwords_today_is).'." >
							<input type="submit" name="submit" class="hidden" value="Submit">
							</form>';
						}
					}
				}
			}else{
				if(isset($_POST)){
					echo '<form method="post" name="password_'.$passwordField.'" id="RUPS'.$passwordField.'" action="'.esc_url(get_permalink()).'">';
					wp_nonce_field('password_'.$passwordField);
					echo '<input type="text" class="password" name="rups_pass" placeholder="'.$attemptsLeft.'Enter the password for '.esc_attr($rotating_universal_passwords_today_is).'." >
					<input type="submit" name="submit" class="hidden" value="Submit">
					</form>';
				}
			}
			return ob_get_clean();
		}else{
		ob_start();
		echo '<blockquote>'.esc_attr($rotating_universal_passwords_today_is).'\'s password is blank or missing.</blockquote>';
		return ob_get_clean();
		}
	}
}
/****************************** SECTION E -/- (E0) Settings -/- Reviews ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_reviews_module(){
		function mom_closetags($html){
			// http://stackoverflow.com/questions/3059398/how-to-close-unclosed-html-tags
			preg_match_all("#<([a-z]+)(.*)?(?!/)>#iU", $html, $result);
			$openedtags = $result[1];
			preg_match_all("#</([a-z]+)>#iU", $html, $result);
			$closedtags = $result[1];
			$len_opened = count($openedtags);
			if(count($closedtags) == $len_opened)
			{
			return $html;
			}
			$openedtags = array_reverse($openedtags);
			for($i = 0; $i < $len_opened; $i++)
			{
				if(!in_array($openedtags[$i], $closedtags))
				{
				$html .= "</" . $openedtags[$i] . ">";
				}
				else
				{
				unset($closedtags[array_search($openedtags[$i], $closedtags)]);
				}
			}
			return $html;
		}
		function update_mom_reviews(){
			global $table_prefix,$wpdb;
			$reviews_table_name = $table_prefix.'momreviews';			
				$reviews_type = str_replace('"','\'',($_REQUEST['reviews_type']));
				$reviews_link = str_replace('"','\'',($_REQUEST['reviews_link']));
				$reviews_title = str_replace('"','\'',($_REQUEST['reviews_title']));
				$reviews_reviewed = $_REQUEST['reviews_review'];
				$reviews_review = wpautop($reviews_reviewed);
				$reviews_rating = str_replace('"','\'',($_REQUEST['reviews_rating']));
				$wpdb->query("INSERT INTO $reviews_table_name (ID,TYPE,LINK,TITLE,REVIEW,RATING) VALUES ('','$reviews_type','$reviews_link','$reviews_title','$reviews_review','$reviews_rating')") ;
				echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
		}
		if(isset($_POST['filterResults'])){
			$filter_type = $_REQUEST['filterResults_type'];		
			$filter_type_fetch = sanitize_text_field($filter_type);
			update_option('momreviews_search',$filter_type_fetch);
		}
			
		function update_mom_css(){
			$newCSS = stripslashes_deep($_REQUEST['css']);
			update_option('momreviews_css',$newCSS); 
			echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
		}
		if(isset($_POST['reviewsubmit']))update_mom_reviews();
		if(isset($_POST['csssubmit']))update_mom_css();
		function print_mom_reviews_form(){
			echo "
				<div class=\"settingsInput\">
				<form method=\"post\" class=\"addForm\">
							<section>title<input type=\"text\" name=\"reviews_title\" placeholder=\"Enter title here\"></section>
							<section>type<input type=\"text\" name=\"reviews_type\" placeholder=\"Review type\"></section>
							<section>url<input type=\"text\" name=\"reviews_link\" placeholder=\"Relevant URL\" ></section>
							<section class=\"editor\">
								";
									wp_editor($content,$name = 'reviews_review',$id = 'reviews_review',$prev_id = 'title',$media_buttons = true, $tab_index = 2);
								echo "
							</section>
							<section><label>rating</label><input type=\"text\" name=\"reviews_rating\" placeholder=\"Your rating\"></section>
							<section><input id=\"reviewsubmit\" type=\"submit\" value=\"Add review\" name=\"reviewsubmit\"/></section>
				</form>
				</div>
				<form method=\"post\" class=\"csssubmit\">
					<section><textarea name=\"css\">".get_option('momreviews_css')."</textarea></section>
					<section><input id=\"csssubmit\" type=\"submit\" value=\"Save CSS\" name=\"csssubmit\" /></section>
				</form>
				</div>
			";
		}
		function reviews_page_content(){
			echo "	
				<span class=\"moduletitle\">__reviews<em>[momreviews]</em></span>
				<div class=\"clear\"></div>
				<div class=\"settings\">
					<div class=\"settingsInfo taller\">
					<form method=\"post\" class=\"reviews_item_form\">
						<input type=\"text\" name=\"filterResults_type\" placeholder=\"Filter by type\"";if(get_option('momreviews_search') != "")echo "value=\"" . get_option('momreviews_search') . "\""; echo ">
						<input type=\"submit\" name=\"filterResults\" value=\"Accept\">
					</form>
					";
				global $wpdb;
					$mom_reviews_table_name = $wpdb->prefix . "momreviews";
					$filtered_search = get_option('momreviews_search');
					
					if(get_option('momreviews_search') != ""){
						$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE = '$filtered_search' ORDER BY ID DESC");
					}else{
						$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
					}
					echo '<div class="momresults">';
					foreach($reviews as $reviews_results){
						$this_ID = $reviews_results->ID;
							echo "<div class=\"momdata\">";
							
							echo "
							<div class=\"reviewitem\">
									<section class=\"id\">id:".$reviews_results->ID."</section>
									<span class=\"review\">".$reviews_results->TITLE."</span>	
								";
				if(!isset($_POST['edit_'.$this_ID.''])){
				if(!isset($_POST['delete_'.$this_ID.''])){echo "<form method=\"post\"><input class=\"deleteSubmit\" type=\"submit\" name=\"delete_".$this_ID."\" value=\"Delete\"></form>";}
				else{echo "<form class=\"confirm\" method=\"post\"><input type=\"submit\" name=\"cancel\" id\"cancel\" value=\"Nevermind, I'd like to keep it.\"/><input class=\"deleteSubmit\" type=\"submit\" name=\"delete_confirm_".$this_ID."\" value=\"Confirm your deletion of item ".$reviews_results->ID."\"/></form>";}
				echo "<form method=\"post\"><input class=\"editSubmit\" type=\"submit\" name=\"edit_".$this_ID."\" value=\"Edit\"></form>";
				}	echo "								
							<section class=\"type\">type: ".$reviews_results->TYPE."</section>
							</div>";
						if(isset($_POST['edit_'.$this_ID.''])){
							echo "
							<div class=\"editing\">
							<form method=\"post\" class=\"addForm\">
										<section>title<input type=\"text\" name=\"reviews_title_".$this_ID."\" placeholder=\"Enter title here\" value=\"".$reviews_results->TITLE."\"/></section>
										<section>type<input type=\"text\" name=\"reviews_type_".$this_ID."\" placeholder=\"Review type\" value=\"".$reviews_results->TYPE."\"/></section>
										<section>url<input type=\"text\" name=\"reviews_link_".$this_ID."\" placeholder=\"Relevant URL\" value=\"".$reviews_results->LINK."\"/></section>
										<section class=\"editor\">
											";
												$thisContent = $reviews_results->REVIEW;
												wp_editor($content = $thisContent, $name = 'edit_review_'.$this_ID.'', $id = 'edit_review_'.$this_ID.'', $prev_id = 'title', $media_buttons = true, $tab_index = 1);
											echo "</section>
										<section>rating<input type=\"text\" name=\"reviews_rating_".$this_ID."\" placeholder=\"Your rating\" value=\"".$reviews_results->RATING."\"/></section>
										<section><input id=\"submit_edit_".$this_ID."\" type=\"submit\" value=\"Save these edits\" name=\"submit_edit_".$this_ID."\"><input type=\"submit\" name=\"cancel\" id\"cancel\" value=\"Nevermind, don't edit anything.\"/></section>
							</form>
							</div>";
						}
				if(isset($_POST['submit_edit_'.$this_ID.''])){
					global $table_prefix, $wpdb;
					$reviews_table_name = $table_prefix.'momreviews';			
						$edit_type = str_replace('"','\'',($_REQUEST['reviews_type_'.$this_ID.'']));
						$edit_link = str_replace('"','\'',($_REQUEST['reviews_link_'.$this_ID.'']));
						$edit_title = str_replace('"','\'',($_REQUEST['reviews_title_'.$this_ID.'']));
						$edit_reviewed = $_REQUEST['edit_review_'.$this_ID.''];
						$edit_review = wpautop($edit_reviewed);
						$edit_rating = str_replace('"','\'',($_REQUEST['reviews_rating_'.$this_ID.'']));
						$wpdb->query("UPDATE $reviews_table_name SET TYPE = '$edit_type', LINK = '$edit_link', TITLE = '$edit_title', REVIEW = '$edit_review', RATING = '$edit_rating' WHERE ID = $this_ID") ;
						echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
				}
				if(isset($_POST['delete_confirm_'.$this_ID.''])){
					$current = plugin_basename(__FILE__);
					$wpdb->query("DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID'");
					echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
				}
				if(isset($_POST['cancel'])){
				}
				echo "</div>";
				}	
				echo '</div>';
				echo '</div>';
				print_mom_reviews_form();
		}
		reviews_page_content();
	}
}	
/****************************** SECTION E -/- (E1) Functions -/- Reviews ******************************/
$mom_review_global = 0;
function mom_reviews_shortcode($atts, $content = null){
	global $mom_review_global;
	$mom_review_global++;
	if($mom_review_global == 1){mom_reviews_style();}else{}
	ob_start();
	extract(
		shortcode_atts(array(
			'type'	=> '',
			'orderby' => 'ID',
			'order' => 'ASC',
			'meta' => 1,
			'expand' => '+',
			'retract' => '-',
			'id' => '',
			'open' => 0
		), $atts)
	);	
	$id_fetch_att = esc_attr($id);
	if(is_numeric($id_fetch_att)){$id_fetch = $id_fetch_att;}
	$result_type = $type;
	$order_by = $orderby;
	$order_dir = $order;
	$meta_show = $meta;
	$expand_this = $expand;
	$retract_this = $retract;
	$is_open = $open;
	global $wpdb;
	$mom_reviews_table_name = $wpdb->prefix.'momreviews';
	if($id_fetch != ''){
		$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE ID IN ($id_fetch) ORDER BY $order_by $order_dir");
	}else{
		if($result_type != ''){
			$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE IN ($result_type) ORDER BY $order_by $order_dir");
		}else{
			$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY $order_by $order_dir");
		}
	}
	foreach($reviews as $reviews_results){
	if($reviews_results->REVIEW != ''){$this_ID = $reviews_results->ID;echo '<div ';if($result_type != ''){echo 'id="'.esc_attr($result_type).'"';}echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="'.$this_ID.''.$mom_review_global.'" ';if($is_open == 1){echo ' checked';}echo '/><label for="'.$this_ID.''.$mom_review_global.'">';if($reviews_results->TITLE != ''){echo $reviews_results->TITLE;}echo '<span>'.$expand_this.'</span><span>'.$retract_this.'</span></label><section class="reviewed">';if($meta_show == 1){if($reviews_results->TYPE != ''){echo ' [ <em>'.$reviews_results->TYPE.'</em> ] ';}if($reviews_results->LINK != ''){echo ' [ <a href="'.esc_url($reviews_results->LINK).'">#</a> ] ';}}echo '<hr />'.$reviews_results->REVIEW;if($reviews_results->RATING != ''){echo ' <p>'.$reviews_results->RATING.'</p> ';}echo '</section></article></div>';}
	elseif($reviews_results->REVIEW == ''){$this_ID = $reviews_results->ID;echo '<div ';if($result_type != ''){echo 'id="'.esc_attr($result_type).'"';}echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="'.$this_ID.''.$mom_review_global.'" ';if($is_open == 1){echo ' checked';}echo '/><label>';if($reviews_results->TITLE != ''){if($reviews_results->LINK != ''){echo '<a href="'.esc_url($reviews_results->LINK).'">';}echo $reviews_results->TITLE;if($reviews_results->LINK != ''){echo '</a>';}}echo '<span>'.$reviews_results->RATING.'</span><span></span></label></article></div>';}
	}
	return ob_get_clean();
}
function mom_reviews_style(){echo '<style>'.get_option('momreviews_css').'</style>';}
/****************************** SECTION F -/- (F0) Settings -/- Shortcodes ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_shortcodes_module(){
		echo "
			<div class=\"settings\">
			<table class=\"form-table\" border=\"1\">
				<tbody>
					<tr valign=\"top\">
						<p>[<a href=\"#google_maps\">map</a>] 
						&mdash; [<a href=\"#reddit_button\">reddit</a>] 
						&mdash; [<a href=\"#restrict\">restrict content to logged in users</a>] 
						&mdash; [<a href=\"#progress_bars\">progress bars</a>]
						&mdash; [<a href=\"#verifier\">verifier</a>]
						&mdash; [<a href=\"#onthisday\">on this day</a>]</p>
					</tr>
					<tr valign=\"top\" id=\"google_maps\">
						<td valign=\"top\">
							<strong>Google Maps</strong>
							<br />Embed a Google map.<br />Based on <a href=\"http://wordpress.org/plugins/very-simple-google-maps/\">Very Simple Google Maps</a> by <a href=\"http://profiles.wordpress.org/masterk/\">Michael Aronoff</a><hr />
							<u>Parameters</u><br />width<br />height<br />frameborder<br />align<br />address<br />info_window<br />zoom<br />	companycode<hr />
							<u>Defaults</u><br />Width: 100% <br />Height: 350px <br />Frameborder: 0 <br />Align: center<hr />
							div class .mom_map
						</td>
						<td valign=\"top\">
							<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
							<tbody>
							<tr><td><code>[mom_map address=\"38.573333,-109.549167\"]</code></td><td><em>GPS</em></td></tr>
							<tr><td><iframe align=\"center\" width=\"100%\" height=\"350px\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&q=38.573333%2C-109.549167&amp;cid=&output=embed&z=14&iwloc=A&visual_refresh=true\"></iframe></td></tr>
							<tr><td><code>[mom_map address=\"1600 Pennsylvania Ave NW, Washington, D.C., DC\"]</code></td><td><em>Street Address</em></td></tr>
							<tr><td><iframe align=\"center\" width=\"100%\" height=\"350px\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&q=1600+Pennsylvania+Ave+NW%2C+Washington%2C+D.C.%2C+DC+&amp;cid=&output=embed&z=14&iwloc=A&visual_refresh=true\"></iframe></td></tr>
							</tbody>
							</table>
						</td>
					</tr>
					<tr valign=\"top\" id=\"reddit_button\" style=\"background-color:#f4faff;\">
						<td valign=\"top\">
							<strong>Reddit button</strong>
							<br />Create a customizable submit button for the current post.<hr />
							<u>Parameters</u><br />target<br />title<br />bgcolor<br />border<hr />
							<u>Defaults</u> <br />title: post title<br />bgcolor: transparent<br />border (color): transparent<hr />
							div class .mom_reddit
						</td>
						<td valign=\"top\">
							<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
								<tbody>
									<tr>
										<td>
											<code>[mom_reddit]</code></td><td><em>Default</em>
										</td>
									</tr>
									<tr>
										<td>
											<script type=\"text/javascript\">
											reddit_url = \"http://reddit.com/\";
											reddit_target = \"\";
											reddit_title = \"Test\";
											reddit_bgcolor = \"\";
											reddit_bordercolor = \"\";
											</script>
											<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
										</td>
									</tr>
									<tr>
										<td>
											<code>[mom_reddit target=\"news\"]</code></td><td><em>Targeting <a href=\"http://reddit.com/r/news/\">/r/news</a></em>
										</td>
									</tr>
									<tr>
										<td>
											<script type=\"text/javascript\">
											reddit_url = \"http://reddit.com/\";
											reddit_target = \"news\";
											reddit_title = \"Reddit\";
											reddit_bgcolor = \"\";
											reddit_bordercolor = \"\";
											</script>
											<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
										</td>
									</tr>
									<tr>
										<td>
											<code>[mom_reddit bgcolor=\"000\" border=\"000\"]</code></td><td><em>Black background/border</em>
										</td>
									</tr>
									<tr>
										<td>
											<script type=\"text/javascript\">
												reddit_url = \"http://test.com/\";
												reddit_target = \"\";
												reddit_title = \"Reddit\";
												reddit_bgcolor = \"000\";
												reddit_bordercolor = \"000\";
											</script>
											<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr valign=\"top\" id=\"restrict\">
						<td valign=\"top\">
							<strong>Restrict content to logged in users</strong><br />Restrict content to users who are not logged in, including commenting or viewing comments.<hr />
							<u>Parameters</u><br />message<br />comments<hr />
							<u>Defaults</u> <br /> message: You must be logged in to view this content.<hr />
							div class .mom_restrict
						</td>
						<td valign=\"top\">
							<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
								<tbody>
									<tr>
										<td>
											<code>[mom_restrict]some content[/mom_restrict]</code></td><td><em>Default</em>
										</td>
									</tr>
									<tr>
										<td>
											Logged in users see:<br />some content
											<p>Users who are not logged in see:<br />You must be logged in to view this content.</p>
										</td>
									</tr>
									<tr>
										<td>
											<code>[mom_restrict comments=\"1\" message=\"Log in to view this content!\"]some content[/mom_restrict]</code></td><td><em>Comments and form are hidden</em>
										</td>
									</tr>
									<tr>
										<td>
											Logged in users see:<br />some content
											<p>Users who are not logged in see:<br />Log in to view this content!<br />(<em>Comment form and comments are hidden.)</em>)</p>
										</td>
									</tr>
									<tr>
										<td>
											<code>[mom_restrict comments=\"2\" message=\"Log in to view this content!\"]some content[/mom_restrict]</code></td><td><em>Comment form is hidden</em>
										</td>
									</tr>
									<tr>
										<td>
											Logged in users see:<br />some content
											<p>Users who are not logged in see:<br />Log in to view this content!<br />(<em>Comment form is hidden</em>)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr valign=\"top\" id=\"progress_bars\">
						<td valign=\"top\">
							<strong>Progress bars</strong>
							<br />Create bars that fill up, based on your parameters, to show progression towards a goal.<hr />
							<u>Parameters</u><br />align, fillcolor, maincolor, 
							height, level, margin, 
							width<hr />
							<u>Defaults</u><br />align: none<br />fillcolor: #ccc<br />maincolor: #000<br />height: 15<br />level:<br />margin: 0 auto<br />width: 95%<br /><hr />
							div class .mom_progress<hr />
							The <code>level</code> refers to the % of the main bar to be filled.  So a level of 51 would fill it 51%, 29 would fill it 29%, 75 would fill it 75%, and so on.
						</td>
						<td valign=\"top\">
							<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
							<tbody>
							<tr><td><code>[mom_progress level=\"10\"]</code></td><td><em>Default, level 10</em></td></tr>
							<tr><td>
								<div id=\"1\" class=\"mom_progress\" style=\"clear: both; height:15px; display: block; width:95%; margin: 0 auto; background-color:#000\"><div style=\"display: block; height:15px; width:10%; background-color: #ccc;\"></div></div>
							</td></tr>
							<tr><td><code>[mom_progress level=\"70\" maincolor=\"#ff0000\" fillcolor=\"#009cff\"]</code></td><td><em>Level 70, custom colors</em></td></tr>
							<tr><td>
								<div id=\"2\" class=\"mom_progress\" style=\"clear: both; height:15px; display: block; width:95%; margin: 0 auto; background-color:#ff0000\"><div style=\"display: block; height:15px; width:70%; background-color: #009cff;\"></div></div>
							</td></tr>
							<tr><td><code>[mom_progress height=\"50\" level=\"70\" maincolor=\"#ff0000\" fillcolor=\"#009cff\"]</code></td><td><em>Level 70, custom colors, height of 50 (translates to 50px)</em></td></tr>
							<tr><td>
								<div id=\"3\" class=\"mom_progress\" style=\"clear: both; height:50px; display: block; width:95%; margin: 0 auto; background-color:#ff0000\"><div style=\"display: block; height:50px; width:70%; background-color: #009cff;\"></div></div>
							</td></tr>									
							</tbody>
							</table>
						</td>
					</tr>		
					<tr valign=\"top\" id=\"verifier\">
						<td valign=\"top\">
							<strong>Verifier</strong>
							<br />Gate content with a customizable input prompt with optional tracking of unique right and wrong answers.<hr />
							<u>Parameters</u><br />age,answer,logged,message,fail,logging,background<hr />
							<u>Defaults</u><br />cmessage: Correct<br />imessage: Incorrect<br />age:<br />answer:<br />logged:1<br />message: Please verify your age by typing it here<br />fail: You are not able to view this content at this time.<br />logging: 0<br />background: transparent<br />single: 0<br />deactivate: 0<br />
							<p><u>age</u>: (numeric only) set the age you want to be entered into the form to be considered valid.  (Both age and answer <strong>cannot</strong> be used together.</p>
							<p><u>answer</u>: (alphanumeric) enter the right answer that needs to be input into the form to show the content.</p>
							<p><u>logged</u>: (0 or 1) 1 is to show the form to everyone - even people logged in.  0 will hide the verification for people who are logged in.</p>
							<p><u>message</u>: Message to display in the form to let users know what needs to be input.</p>
							<p><u>fail</u>: Message that is shown when the wrong answer is given, or the age entered is too young.</p>
							<p><u>logging</u>: (0 or 1 or 3) If set to 1, each unique answer given to each form will be tracked in the database, allowing access to statistical data.  Only one record per IP address per form will be saved.  3 will show (below the form) a box containing the % of right and wrong answers, and will enable logging.</p>
							<p><u>background</u>: Hex color code for the background of the form.</p>
							<p><u>single</u>: (0 or 1) Set to 1 to allow only one attempt.  Right or wrong, once the attempt has been made, the form will no longer show.</p>
							<p><u>cmessage</u>: (if stats are being displayed) the message for the % of correct votes</p>
							<p><u>imessage</u>: (if stats are being displayed) the message for the % of incorrect votes</p>
							<p><u>deactivate</u>: (0 or 1) 1 to deactivate a form.</p>
							<p>Case does not matter with question and answer - they are both converted to lowercase upon comparing for correct answers.</p>
							<p>Background <strong>can</strong> be <code>transparent</code>.</p>
							<p>You could also inner-content blank ([mom_verify]no content here[/mom_verify], and define logging as <code>3</code> to create a poll-type question.</p>
							<hr />
							blockquote.momAgeVerification<br />
							form.momAgeVerification<br />
							<hr />
						</td>
						<td valign=\"top\">
							<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
							<tbody>
							<tr><td>How to set up a two answer poll:<br />
							<ul>
							<li>Let's say you want to set up a poll for \"Was this article helpful?\".  Set your answer to 'yes' - we only need it for stats.</li>
							<li>Set your correct message to \"Found this useful\" (or whatever wording you want for the people who thought it was useful), and incorrect to \"Didn't find this useful\".</li>
							<li>All answers that are \"yes\" will be counted as \"Found this useful\".  Any other answers will be counted as not.</li><li>Your message could be something like: \"Did you find this article useful?  Yes or no.\"</li></ul>
							<hr />Example: <code>[mom_verify message=\"Did you find this article useful?  Yes or no.\" answer=\"yes\" cmessage=\"Found this useful\" imessage=\"Didn't find this useful\" logging=\"3\" single=\"1\"][/mom_verify]</code>
							</td></tr>
							<tr><td><code>[mom_verify age=\"18\"]some content[/mom_verify]</code></td><td><em>Default, correct age input 18 or over</em></td></tr>
							<tr><td><code>[mom_verify answer=\"hank HIlL\" message=\"Who sells propane and propane accessories?\"]some content[/mom_verify]</code></td><td><em>Default, question and answer set.</em></td></tr>
							<tr><td><code>[mom_verify age=\"18\" background=\"fff\"]some content[/mom_verify]</code></td><td><em>Black background, 18+ age gate</em></td></tr>
							</tbody>
							</table>
						</td>
					</tr>
					<tr valign=\"top\" id=\"onthisday\">
						<td valign=\"top\">
							<strong>On this day</strong>
							<br />Embed a small widget that grabs posts for the current day (minus the post that is currently being viewed) for previous years, or if no posts are found, will display 5 posts at random.  Template tag available to display 5 posts from previous years on this day for categories, tags, and front pages (will also display 5 random if none found).<hr />
							<br />Shortcode: [mom_onthisday]<br />Template tag: mom_onthisday_template();<br />
							<u>Parameters</u><br />cat<br />amount<br />title<br />
							<u>Defaults</u><br />amount: -1 <br />cat: <br />title: on this day<br /><hr />
						</td>
						<td valign=\"top\">
							<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
							<tbody>
							<tr><td><code>[mom_onthisday cat=\"current\"]</code></td><td><em>Display past posts from this category only</em></td></tr>
							<tr><td><code>[mom_onthisday title=\"previous years\" amount=\"2\"]</code></td><td><em>Display 2 past posts in a div with the title <em>previous years</em>.</em></td></tr>
							<tr><td><iframe align=\"center\" width=\"100%\" height=\"350px\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&q=1600+Pennsylvania+Ave+NW%2C+Washington%2C+D.C.%2C+DC+&amp;cid=&output=embed&z=14&iwloc=A&visual_refresh=true\"></iframe></td></tr>
							</tbody>
							</table>
						</td>
					</tr>					
				</tbody>
			</table>
		</div>";
	}
}
/****************************** SECTION F -/- (F1) Functions -/- Shortcodes ******************************/
function mom_onthisday_template(){
	$current_day = date('d');
	$current_month = date('m');
	if(is_category()){
		$category_current = get_the_category();
		$category = $category_current[0]->cat_ID;	
	}
	if(is_tag()){
		$tagged = get_query_var('tag');
		$tag = esc_attr($tagged);
	}	
	wp_reset_query();
	if(is_category()){query_posts( "cat=$category&monthnum=$current_month&day=$current_day&posts_per_page=-1" );}
	elseif(is_tag()){query_posts( "tag=$tag&monthnum=$current_month&day=$current_day&posts_per_page=-1" );}
	else{query_posts( "monthnum=$current_month&day=$current_day&posts_per_page=-1" );}
	$posts = 0;
	while(have_posts()):the_post();
	$posts++;
	if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">on this day</span>';}
	if($posts > 0){
		$postid = get_the_id();
		echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
	}
		endwhile;
	if($posts == 0){
		$posts++;
		if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">5 random posts</span>';}
		query_posts( "orderby=rand&posts_per_page=5&ignore_sticky_posts=1" );
		while(have_posts()):the_post();
		$postid = get_the_id();
		echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
		endwhile;
	}
	echo '</div>';
	wp_reset_query();
}
function mom_onthisday($atts,$content = null){
	extract(
		shortcode_atts(array(
			'amount' => '-1',
			'title' => 'On this day',
			'cat' => ''
		), $atts)
	);
	global $post;
	$postid = $post->ID;
	if($cat == 'current'){
		$category_current = get_the_category($postid);
		$category = $category_current[0]->cat_ID;
	}else{
		$category = esc_attr($cat);
	}
	$onthisday = esc_attr($title);
	$postid = get_the_ID();
	$current_day = date('d');
	$current_month = date('m');
	$postsperpage = esc_attr($amount);
	query_posts( "cat=$category&monthnum=$current_month&day=$current_day&post_per_page=$postsperpage" );
	ob_start();
	$posts = 0;
	while(have_posts()):the_post();
	$posts++;
	if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">on this day</span>';}
	if($posts > 0){
		$postid = get_the_id();
		echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo get_the_post_thumbnail($postid, 'thumbnail', array('class' => 'mom_thumb'));echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
	}
		endwhile;
	if($posts == 0){
		$posts++;
		if($posts == 1){echo '<div id="mom_onthisday"><span class="onthisday">5 random posts</span>';}
		query_posts( "orderby=rand&post_per_page=5&ignore_sticky_posts=1" );
		while(have_posts()):the_post();
		$postid = get_the_id();
		echo '<section class="mom_onthisday"><a href="';the_permalink();echo'">';echo get_the_post_thumbnail($postid, 'thumbnail', array('class' => 'mom_thumb'));echo '<div class="mom_onthisday">';echo '<span class="title">';the_title();echo '</span><span class="theyear">';the_date('Y'); echo'</span>';echo '</div></a></section>';
		endwhile;
	}
	echo '</div>';
	wp_reset_query();
	return ob_get_clean();
}
function mom_archives($atts,$content = null){
	if(!is_user_logged_in()){
		$nofollowCats = get_option('MOM_Exclude_VisitorCategories').','.get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');
	}
	if(is_user_logged_in()){
		if($user_level == 0){$loggedOutCats = get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
		if($user_level <= 1){$loggedOutCats = get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
		if($user_level <= 2){$loggedOutCats = get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
		if($user_level <= 7){$loggedOutCats = get_option('MOM_Exclude_level7Categories').','.get_option('MOM_Exclude_Categories_Front').','.get_option('MOM_Exclude_Categories_TagArchives').','.get_option('MOM_Exclude_Categories_SearchResults');}
	}
	$c1 = explode(',',$nofollowCats);
	foreach($c1 as &$C1){$C1 = ''.$C1.',';}
	$c_1 = rtrim(implode($c1),',');
	$c11 = explode(',',str_replace(' ','',$c_1));
	$c11array = array($c11);
	$nofollowcats = $c11;
	$category_ids = get_all_category_ids();
	ob_start();
	echo '<div class="momlistcategories">';foreach($category_ids as $cat_id){if(in_array($cat_id, $nofollowcats)) continue;$cat = get_category($cat_id);$link = get_category_link($cat_id);echo '<div><a href="'.esc_url($link).'" title="link to '.esc_attr($cat->name).'">'.esc_attr($cat->name).'</a><span>'.esc_attr($cat->count).'</span><section>'.esc_attr($cat->description);$args = array('numberposts'=>'1','category'=>$cat_id);$latestpost = wp_get_recent_posts($args);foreach($latestpost as $latest){echo '<article><em><a href="'.esc_url(get_permalink($latest["ID"])).'" title="'.esc_attr($latest["post_title"]).'" >'.esc_attr($latest["post_title"]).'</a></em></article>';}echo '</section></div>';}echo '</div>';
	return ob_get_clean();
}
$momverifier_verification_step = 0;
function mom_google_map_shortcode($atts, $content = null){
	ob_start();
	extract(
		shortcode_atts(array(
			'width' => '100%',
			'height' => '350px',
			'frameborder' => '0',
			'align' => 'center',
			'address' => '',
			'info_window' => 'A',
			'zoom' => '14',
			'companycode' => ''
		), $atts)
	);
	$mgms_output = 'q='.urlencode($address).'&amp;cid='.urlencode($companycode);
	echo '
	<div class="mom_map">
		<iframe align="'.esc_attr($align).'" width="'.esc_attr($width).'" height="'.esc_attr($height).'" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;'.htmlentities($mgms_output).'&amp;output=embed&amp;z='.esc_attr($zoom).'&amp;iwloc='.esc_attr($info_window).'&amp;visual_refresh=true"></iframe>
	</div>
	';
	return ob_get_clean();
}
function mom_reddit_shortcode($atts, $content = null){
	global $wpdb, $id, $post_title;
	$query = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND ID = '$id'";
	$reddit = $wpdb->get_results($query);
	if($reddit){
		foreach($reddit as $reddit_info){
			$post_title = strip_tags($reddit_info->post_title);
		}
	extract(
		shortcode_atts(array(
			'url' => '' . $get_permalink . '',
			'target' => '',
			'title' => '' . $post_title . '',
			'bgcolor' => '',
			'border' => ''
		), $atts)
	);
	ob_start();
	echo '
	<div class="mom_reddit">
	<script type="text/javascript">
		reddit_url = "'.esc_url($url).'";
		reddit_target = "'.esc_attr($target).'";
		reddit_title = "'.esc_attr($title).'";
		reddit_bgcolor = "'.esc_attr($bgcolor).'";
		reddit_bordercolor = "'.esc_attr($border).'";
	</script>
	<script type="text/javascript" src="http://www.reddit.com/static/button/button3.js"></script>
	</div>';
	return ob_get_clean();
	}
}
function mom_restrict_shortcode($atts, $content = null){
	extract(
		shortcode_atts(array(
			'message' => 'You must be logged in to view this content.',
			'comments' => '',
			'form' => ''
		), $atts)
	);
	ob_start();
	if(is_user_logged_in()){return $content;}else{
		echo '<div class="mom_restrict">'.htmlentities($message).'</div>';
		if($comments == '1'){
			add_filter('comments_template','restricted_comments_view');
			function restricted_comments_view($comment_template){
				return dirname(__FILE__).'/includes/templates/comments.php';
			}
		}
		if($comments == '2'){
			add_filter('comments_open','restricted_comments_form',10,2);
			function restricted_comments_form($open,$post_id){
				$post = get_post($post_id);
				$open = false;
				return $open;
			}	
		}
	}		
	return ob_get_clean();
}
function mom_progress_shortcode($atts,$content = null){
	extract(
		shortcode_atts(array(
			'align' => 'none',
			'fillcolor' => '#ccc',
			'maincolor' => '#000',
			'height' => '15',
			'fontsize' => '15',
			'level' => '',
			'margin' => '0 auto',
			'talign' => 'center',
			'width' => '95'
		), $atts)
	);
	$align_fetch = sanitize_text_field($align);
	$fillcolor_fetch = sanitize_text_field($fillcolor);
	$height_fetch = sanitize_text_field($height);
	$level_fetch = sanitize_text_field($level);
	$maincolor_fetch = sanitize_text_field($maincolor);
	$margin_fetch = sanitize_text_field($margin);
	$width_fetch = sanitize_text_field($width);
	ob_start();
	if($align_fetch == 'left'){$align_fetch_final = 'float: left';}
	elseif($align_fetch == 'right'){$align_fetch_final = 'float: right';}
	else {$align_fetch_final = 'clear: both';}
	echo '<div class="mom_progress" style="'.$align_fetch_final.';height:'.$height_fetch.'px;display:block;width:'.$width_fetch.'%;margin:'.$margin_fetch.';background-color:'.$maincolor_fetch.'"><div style="display:block;height:'.$height_fetch.'px;width:'.$level_fetch.'%;background-color:'.$fillcolor_fetch.';"></div></div>';
	return ob_get_clean();
}
function mom_verify_shortcode($atts,$content = null){
	global $post;
	if(isset($_SERVER["REMOTE_ADDR"])){
		$ipAddress = $_SERVER["REMOTE_ADDR"]; 
	} else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
	} else if(isset($_SERVER["HTTP_CLIENT_IP"])){
		$ipAddress = $_SERVER["HTTP_CLIENT_IP"]; 
	}
	$ipaddress = ip2long($ipAddress);
	if(is_numeric($ipaddress)){
		$theIP = $ipaddress;}else{
		$theIP = 0;
	}
	ob_start();
	extract(
		shortcode_atts(array(
			"age" => '',
			"answer" => '',
			"logged" => 1,
			"message" => 'Please verify your age by typing it here',
			"fail" => 'You are not able to view this content at this time.',
			"logging" => 0,
			"background" => 'transparent',
			"stats" => '',
			"single" => 0,
			"cmessage" => 'Correct',
			"imessage" => 'Incorrect',
			"deactivate" => 0
		), $atts)
	);
	global $momverifier_verification_step;
	$momverifier_verification_step++;
	$thePostId = $post->ID;
	$theBackground = sanistripents($background);
	$theAge = sanistripents($age);
	$isLogged = sanistripents($logged);
	$theMessage = sanistripents($message);
	$theAnswer = sanistripents($answer);
	$failMessage = $fail;
	$isLogged = sanistripents($logged);
	$isLogging = sanistripents($logging);
	$attempts = sanistripents($single);
	$correctResultMessage = sanistripents($cmessage);
	$incorrectResultMessage = sanistripents($imessage);
	$isDeactivated = sanistripents($deactivate);
	$verificationID = $momverifier_verification_step.''.$thePostId;
	$statsMessage = sanistripents($stats);
	$alreadyAttempted = 0;
	if(is_numeric($attempts) && $attempts == 1){
		global $wpdb;
		$verification_table_name = $wpdb->prefix.'momverification';
		$getNumberofAttempts = $wpdb->get_results("SELECT IP,POST,CORRECT FROM $verification_table_name WHERE IP = '".$theIP."' AND POST = '" . $verificationID . "'");	
		$alreadyAttempted = count($getNumberofAttempts);
		foreach($getNumberofAttempts as $numberofattempts){
			$isCorrect = $numberofattempts->CORRECT;
		}
	}
	if(is_numeric($isLogged) && $isLogged == 0 && is_user_logged_in()){
		$isCorrect = 1;
	} elseif(is_numeric($isLogged) && $isLogged == 1){		
		if($alreadyAttempted != 1){
			if(!$_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.''] != '' && $isDeactivated != 1){
			return '
			<blockquote style="display:block;clear:both;margin:5px auto 5px auto;padding:5px;font-size:25px;">
			<p>'.$theMessage.'</p>
			<form style="clear:both;display:block;padding:5px;margin:0 auto 5px auto;width:98%;overflow:hidden;border-radius:3px;background-color:#'.$theBackground.';" class="momAgeVerification" method="post" action="'.esc_url(get_permalink()).'">
				<input style="clear:both;font-size:25px;width:99%;margin:0 auto;" type="text" name="ageVerification'.esc_attr($momverifier_verification_step).esc_attr($thePostId).'">
				<input style="clear:both;font-size:20px;width:100%;margin:0 auto;" type="submit" name="submit" class="submit" value="Submit">
			</form>
			</blockquote>
			';
			}
		}
		if($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.''] != ''){
			if($theAge != '' && is_numeric($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']) && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
				$ageEntered = ($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']);
				if($ageEntered >= $theAge){
					$isCorrect = 1;
				}else{
					$isCorrect = 0;
				}
			} elseif($theAnswer != '' && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
				$answerGiven = ($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']);
				$correctAnswer = strtolower($theAnswer);
				$answered = strtolower($answerGiven);					
				if($answered === $correctAnswer){
					$isCorrect = 1;
				}else{
					$isCorrect = 0;
				}
			}		
		}			
	}
	if(is_numeric($isLogging) && $isLogging == 1 || is_numeric($isLogging) && $isLogging == 3 || is_numeric($attempts) && $attempts == 1){
		global $wpdb;
		$verification_table_name = $wpdb->prefix.'momverification';
		$getIPforCurrentTransaction = $wpdb->get_results("SELECT IP,POST FROM $verification_table_name WHERE IP = '".$theIP."' AND POST = '".$verificationID."'");
		if(count($getIPforCurrentTransaction) <= 0 && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
			if($theAge != '' && is_numeric($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']) && $_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']){
				$ageEntered	= ($_REQUEST['ageVerification' . $momverifier_verification_step . $thePostId . '']);
				if($ageEntered >= $theAge){		
				$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','1','$theIP')");
				}else{
				$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','0','$theIP')");
				}
			}
			elseif($theAnswer != '' && $_REQUEST['ageVerification' . $momverifier_verification_step . $thePostId . '']){
				$answerGiven = ($_REQUEST['ageVerification'.$momverifier_verification_step.$thePostId.'']);
				$correctAnswer = strtolower($theAnswer);
				$answered = strtolower($answerGiven);				
				if($answered === $correctAnswer){				
				$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','1','$theIP')");
				}else{
				$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','0','$theIP')");
				}
			}
		}
		if($isLogging != 1){
			$incorrect = $wpdb->get_results("SELECT CORRECT FROM $verification_table_name WHERE POST = '".$verificationID."' AND CORRECT = '0'");
			$correct = $wpdb->get_results("SELECT CORRECT FROM $verification_table_name WHERE POST = '".$verificationID."' AND CORRECT = '1'");
			$incorrectCount = count($incorrect);
			$correctCount = count($correct);
			if(count($correct) > 0 && count($incorrect) > 0){$totalCount = ($incorrectCount + $correctCount);}else{$totalCount = 1;}					
			$percentCorrect = ($correctCount/$totalCount * 100);
			$percentIncorrect = ($incorrectCount/$totalCount * 100);
			if($statsMessage == ''){$statsMessage = $theMessage;}
			return '<div style="clear:both;display:block;width:99%;margin:10px auto 10px auto;overflow:auto;background-color:#f6fbff;border:1px solid #4a5863;border-radius:3px;padding:5px;"><p>'.$statsMessage.'</p><div class="mom_progress" style="clear:both;height:20px;display:block;width:95%; margin:5px auto 5px auto;background-color:#ff0000"><div title="'.$correctCount.'" style="display:block;height:20px;width:'.$percentCorrect.'%;background-color:#1eff00;"></div></div><div style="font-size:15px;margin:-5px auto;width:95%;"><span style="float:left;text-align:left;">'.$correctResultMessage.' ('.$percentCorrect.'%)</span><span style="float:right;text-align:right;">'.$incorrectResultMessage.' ('.$percentIncorrect.'%)</span></div></div>';
		}
	}
	if($isCorrect == 1){return $content;}elseif($isCorrect == 0 && $deactivate != 1){return $failMessage;}
	return ob_get_clean();
}	
/****************************** SECTION G -/- (G0) Functions -/- Meta ******************************/
function mom_SEO_header(){
	global $post;
	function mom_meta_module(){
		global $wp,$post;
		$postid = $post->ID;
		$theExcerpt = '';
		$theFeaturedImage = '';
		$Twitter_start = '';
		$Twitter_site = '';
		$Twitter_author = '';
		$authorID = $post->post_author;
		$excerpt_from = get_post($postid);
		$post_title = get_post_field('post_title',$postid);
		$post_content = get_post_field('post_content',$postid);
		$publishedTime = get_post_field('post_date',$postid);
		$modifiedTime = get_post_field('post_modified',$postid);
		$post_link = get_permalink($post->ID);
		$sitename_content = get_bloginfo('site_name');
		$description_content = get_bloginfo('description');
		$theAuthor_first = get_the_author_meta('user_firstname',$authorID);
		$theAuthor_last = get_the_author_meta('user_lastname',$authorID);
		$theAuthor_nice = get_the_author_meta('user_nicename',$authorID);
		$twitter_personal_content = get_the_author_meta('twitter_personal',$authorID);
		$twitter_site_content = get_option('site_twitter');
		$locale_content = get_locale();
		$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
		$featuredImage = $featured_image[0];
		$currentURL = add_query_arg($wp->query_string,'',home_url($wp->request));
		$excerpt = get_post_field('post_content', $postid);
		$excerpt = strip_tags($excerpt);
		$excerpt = esc_html($excerpt);
		$excerpt = preg_replace('/\s\s+/i','',$excerpt);
		$excerpt = substr($excerpt,0,155);
		$excerpt_short = substr($excerpt,0,strrpos($excerpt,' ')).'...';
		$excerpt_short = preg_replace('@\[.*?\]@','', $excerpt);		
		if($excerpt_short != ''){$theExcerpt = '<meta property="og:description" content="'.$excerpt_short.'"/>';}
		if($featuredImage != ''){$theFeaturedImage = '<meta property="og:image" content="'.$featuredImage.'"/>';}
		if($twitter_personal_content != '' || $twitter_site_content != ''){$Twitter_start = '<meta name="twitter:card" value="summary">';}
		if($twitter_site_content != ''){$Twitter_site = '<meta name="twitter:site" value="'.$twitter_site_content.'">';}
		if($twitter_personal_content != ''){$Twitter_author = '<meta name="twitter:creator" value="'.$twitter_personal_content.'">';}
		if(is_single() || is_page()){
			echo '
			<meta property="og:author" content="'.$theAuthor_first.' '.$theAuthor_last.' ('.$theAuthor_nice.') "/>
			<meta property="og:title" content="';wp_title('|',true,'right');echo'"/>
			<meta property="og:site_name" content="'.get_bloginfo('site_name').'"/>
			'.$theExcerpt.'
			<meta property="og:entry-title" content="'.htmlentities(get_post_field('post_title',$postid)).'"/>
			<meta property="og:locale" content="'.$locale_content.'"/>
			<meta property="og:published_time" content="'.$publishedTime.'"/>
			<meta property="og:modified_time" content="'.$modifiedTime.'"/>
			<meta property="og:updated" content="'.$modifiedTime.'"/>';
			$category_names=get_the_category($postid);
			foreach($category_names as $categoryNames){
				echo '
				<meta property="og:section" content="'.$categoryNames->cat_name.'"/>';
			}
			$tagNames = get_the_tags($postid);
			if($tagNames){
				foreach($tagNames as $tagName){
					echo '
					<meta property="og:article:tag" content="'.$tagName->name.'"/>';
				}
			}
			echo '
			<meta property="og:url" content="'.esc_url(get_permalink($post->ID)).'"/>
			<meta property="og:type" content="article"/>
			'.$theFeaturedImage.'
			'.$Twitter_start.'
			'.$Twitter_site.'
			'.$Twitter_author.'
			';
		}else{
			echo '
			<meta property="og:description" content="'.$description_content.'"/>
			<meta property="og:title" content="';wp_title('|',true,'right');echo '"/>
			<meta property="og:locale" content="'.$locale_content.'"/>
			<meta property="og:site_name" content="'.get_bloginfo('site_name').'"/>
			<meta property="og:url" content="'.esc_url($currentURL).'"/>
			<meta property="og:type" content="website"/>
			';
		}
		if(is_search() || is_404() || is_archive())echo '<meta name="robots" content="noindex,nofollow"/>';
	}
}
/****************************** SECTION H -/- (H0) Settings -/- Theme Takeover ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_theme_takeover_module(){
		echo '<span class="moduletitle">__theme takeover<em>easy theme manipulation</em></span><div class="clear"></div><div class="settings"><form method="post">';
		echo '<div class="clear"></div>
		<div class="exclude">
			<section><label for="MOM_themetakeover_youtubefrontpage">Youtube URL for 404s</label><input type="text" id="MOM_themetakeover_youtubefrontpage" name="MOM_themetakeover_youtubefrontpage" value="'.esc_url(get_option('MOM_themetakeover_youtubefrontpage')).'"></section>
			<section><hr /></section>
			<section><label for="MOM_themetakeover_fitvids"><a href="http://fitvidsjs.com/">Fitvid</a> .class</label><input type="text" id="MOM_themetakeover_fitvids" name="MOM_themetakeover_fitvids" value="'.esc_attr(get_option('MOM_themetakeover_fitvids')).'"></section>
			<section><hr /></section>
			<section><label for="MOM_themetakeover_postdiv">Post content .div</label><input type="text" placeholder=".entry" id="MOM_themetakeover_postdiv" name="MOM_themetakeover_postdiv" value="'.esc_attr(get_option('MOM_themetakeover_postdiv')).'"></section>
			<section><label for="MOM_themetakeover_postelement">Post title .element</label><input type="text" placeholder="h1" id="MOM_themetakeover_postelement" name="MOM_themetakeover_postelement" value="'.esc_attr(get_option('MOM_themetakeover_postelement')).'"></section>
			<section><label for="MOM_themetakeover_posttoggle">Toggle text</label><input type="text" placeholder="Toggle contents" id="MOM_themetakeover_posttoggle" name="MOM_themetakeover_posttoggle" value="'.esc_attr(get_option('MOM_themetakeover_posttoggle')).'"></section>
		</div>';
		echo '
		<div class="exclude">
			<section><label for="MOM_themetakeover_topbar">Enable navbar</label>
				<select id="MOM_themetakeover_topbar" name="MOM_themetakeover_topbar">
					<option value="1"';if(get_option('MOM_themetakeover_topbar') == 1){echo ' selected="selected"';}echo '>Yes (top)</option>
					<option value="2"';if(get_option('MOM_themetakeover_topbar') == 2){echo ' selected="selected"';}echo '>Yes (bottom)</option>
					<option value="0"';if(get_option('MOM_themetakeover_topbar') == 0){echo ' selected="selected"';}echo '>No</option>
				</select>
			</section>
			<section><label for="MOM_themetakeover_extend">Extend navbar</label>
				<select id="MOM_themetakeover_extend" name="MOM_themetakeover_extend">
					<option value="1"';if(get_option('MOM_themetakeover_extend') == 1){echo ' selected="selected"';}echo '>Yes</option>
					<option value="0"';if(get_option('MOM_themetakeover_extend') == 0){echo ' selected="selected"';}echo '>No</option>
				</select>
			</section>			
			<section><label for="MOM_themetakeover_topbar_color">Navbar scheme</label>
				<select id="MOM_themetakeover_topbar_color" name="MOM_themetakeover_topbar_color">
					<option value="1"';if(get_option('MOM_themetakeover_topbar_color') == 1){echo ' selected="selected"';}echo '>Dark</option>
					<option value="2"';if(get_option('MOM_themetakeover_topbar_color') == 2){echo ' selected="selected"';}echo '>Light</option>
					<option value="4"';if(get_option('MOM_themetakeover_topbar_color') == 4){echo ' selected="selected"';}echo '>Red</option>
					<option value="5"';if(get_option('MOM_themetakeover_topbar_color') == 5){echo ' selected="selected"';}echo '>Green</option>
					<option value="6"';if(get_option('MOM_themetakeover_topbar_color') == 6){echo ' selected="selected"';}echo '>Blue</option>
					<option value="7"';if(get_option('MOM_themetakeover_topbar_color') == 7){echo ' selected="selected"';}echo '>Yellow</option>
					<option value="3"';if(get_option('MOM_themetakeover_topbar_color') == 3){echo ' selected="selected"';}echo '>Default</option>
				</select>
			</section>			
			<section><label for="MOM_themetakeover_topbar_search">Enable search bar</label>
				<select id="MOM_themetakeover_topbar_search" name="MOM_themetakeover_topbar_search">
					<option value="0"';if(get_option('MOM_themetakeover_topbar_search') == 0){echo ' selected="selected"';}echo '>No</option>
					<option value="1"';if(get_option('MOM_themetakeover_topbar_search') == 1){echo ' selected="selected"';}echo '>Yes</option>
				</select>
			</section>						
			<section><label for="MOM_themetakeover_topbar_share">Share icons</label>
				<select id="MOM_themetakeover_topbar_share" name="MOM_themetakeover_topbar_share">
					<option value="0"';if(get_option('MOM_themetakeover_topbar_share') == 0){echo ' selected="selected"';}echo '>No</option>
					<option value="1"';if(get_option('MOM_themetakeover_topbar_share') == 1){echo ' selected="selected"';}echo '>Yes</option>
				</select>
			</section>						
			';
			$showmepages = get_pages(); 
			echo '<section>
			<label for="MOM_themetakeover_archivepage">Archives page</label>
			<select name="MOM_themetakeover_archivepage" class="allpages" id="MOM_themetakeover_archivepage">
			<option value="">Home page</option>';
			foreach($showmepages as $pagesshown){
				echo '<option name="MOM_themetakeover_archivepage" id="mompaf_'.esc_attr($pagesshown->ID).'" value="'.esc_attr($pagesshown->ID).'"'; 
				if(get_option('MOM_themetakeover_archivepage') == $pagesshown->ID){echo ' selected="selected"';}echo '>
				'.$pagesshown->post_title.'</option>';
			}
			echo '</select></section>';
		echo '<section><hr /></section>';
		echo '<section><label for="MOM_themetakeover_backgroundimage">Enable Custom BG Image</label>
				<select id="MOM_themetakeover_backgroundimage" name="MOM_themetakeover_backgroundimage">
					<option value="0"';if(get_option('MOM_themetakeover_backgroundimage') == 0){echo ' selected="selected"';}echo '>No</option>
					<option value="1"';if(get_option('MOM_themetakeover_backgroundimage') == 1){echo ' selected="selected"';}echo '>Yes</option>
				</select>
			</section>';
		echo '<section><hr /></section>';
		echo '<section><label for="MOM_themetakeover_wowhead">Enable Wowhead Tooltips (<a href="http://www.wowhead.com/tooltips">?</a>)</label>
				<select id="MOM_themetakeover_wowhead" name="MOM_themetakeover_wowhead">
					<option value="1"';if(get_option('MOM_themetakeover_wowhead') == 1){echo ' selected="selected"';}echo '>Yes</option>
					<option value="0"';if(get_option('MOM_themetakeover_wowhead') == 0){echo ' selected="selected"';}echo '>No</option>
				</select>
			</section>';		
		echo '</div><div class="exclude">';
		echo '<input id="momthemetakeoversave" type="submit" value="Save Changes" name="momthemetakeoversave"></form></div></div></div><div class="new"></div>';
	}
}
/****************************** SECTION H -/- (H1) Functions -/- Theme Takeover ******************************/
if(get_option('MOM_themetakeover_youtubefrontpage') != ''){
	function mom_youtube404(){
		global $wp_query;
		if($wp_query->is_404){
			function MOMthemetakeover_youtubefrontpage(){
				include(plugin_dir_path(__FILE__) . '/includes/templates/404.php');
			}
		}
	}
	add_action('wp','mom_youtube404');
	function templateRedirect(){
		global $wp_query;
		if($wp_query->is_404){
			MOMthemetakeover_youtubefrontpage();
			exit;
		}
	}
	add_action('template_redirect','templateRedirect');
}
if(get_option('MOM_themetakeover_topbar') == 1 || get_option('MOM_themetakeover_topbar') == 2){
	function mom_topbar(){
		global $wp,$post;
		ob_start();
		the_title_attribute();
		$title = ob_get_clean();		
		if(is_single() || is_page()){
			$postid = $post->ID;
			$the_title = get_post_field('post_title',$postid);
			$post_link = get_permalink($post->ID);
		}else{
			$the_title = get_bloginfo('site_name');
			$post_link = esc_url(home_url('/'));
		}
		echo '<div class="momnavbar ';
		if(get_option('MOM_themetakeover_topbar_color') == 1){$scheme = 'momschemelight'; echo 'navbarlight ';}
		elseif(get_option('MOM_themetakeover_topbar_color') == 2){$scheme = 'momschemedark'; echo 'navbardark ';}
		elseif(get_option('MOM_themetakeover_topbar_color') == 4){$scheme = 'momschemered'; echo 'navbarred ';}
		elseif(get_option('MOM_themetakeover_topbar_color') == 5){$scheme = 'momschemegreen'; echo 'navbargreen ';}
		elseif(get_option('MOM_themetakeover_topbar_color') == 6){$scheme = 'momschemeblue'; echo 'navbarblue ';}
		elseif(get_option('MOM_themetakeover_topbar_color') == 7){$scheme = 'momschemeyellow'; echo 'navbaryellow ';}
		else{$scheme = 'momschemedefault'; echo 'navbardefault ';}
		if(get_option('MOM_themetakeover_topbar') == 1){ $isTop = 'down'; echo 'navbartop';}elseif(get_option('MOM_themetakeover_topbar') == 2){ $isTop = 'up'; echo 'navbarbottom';} echo'">';
		if(get_option('MOM_themetakeover_topbar_search') == 1){
			echo '<label for="s" class="momsearchthis fa fa-search"></label>';get_search_form();
		}
		echo '<ul class="momnavbarcategories">
		<li><a href="'.esc_url(home_url('/')).'">Front</a></li>';
		$args = array('numberposts'=>'1');
		$latestpost = wp_get_recent_posts($args);
		foreach($latestpost as $latest){
			echo '<li><a href="'.esc_url(get_permalink($latest["ID"])).'" title="'.esc_attr($latest["post_title"]).'" >Latest</a></li>';
		}		
		if(get_option('MOM_themetakeover_topbar_share') == 1){
			//http://www.webdesignerforum.co.uk/topic/70328-easy-social-sharing-buttons-for-wordpress-without-a-plugin/
			echo '<li><a href="http://twitter.com/home?status=Reading:'.esc_url($post_link).'" title="Share this post on Twitter!" target="_blank"><i class="fa fa-twitter"></i></a></li>
			<li><a href="http://www.facebook.com/sharer.php?u='.esc_url($post_link).'&amp;t='.esc_attr(urlencode($the_title)).'" title="Share this post on Facebook!" onclick="window.open(this.href); return false;"><i class="fa fa-facebook"></i></a></li>
			<li><a target="_blank" href="https://plus.google.com/share?url='.esc_url($post_link).'"><i class="fa fa-google-plus"></i></a></li>
			';
		}
		if(get_option('MOM_themetakeover_archivepage') != ''){ echo '<li><a href="'.esc_url(get_permalink(get_option('MOM_themetakeover_archivepage'))).'">All</a></li>'; }
		$counter = 0;
		$max = 1; 
		$taxonomy = 'category';
		$terms = get_terms($taxonomy);
		shuffle($terms);
		if($terms){
			foreach($terms as $term){
				$counter++;
				if($counter <= $max){
				echo '<li><a href="'.get_category_link($term->term_id).'" title="'.sprintf(__("View all posts in %s"), $term->name).'" '.'>Random</a></li>';
				}
			}
		}
		if(function_exists('mom_exclude_list_categories'))mom_exclude_list_categories();
		echo '</ul></div>';
		if(get_option('MOM_themetakeover_extend') == 1){
			echo '<div class="momnavbar_extended'.esc_attr($isTop).'">';
			if($isTop == 'up'){echo '<label for="momnavbarextended"><span class="momnavbar_tab '.esc_attr($scheme).'"><i class="fa fa-chevron-'.esc_attr($isTop).'"></i></span></label>';
			echo '<ul class="momnavbar_pagesup">';wp_list_pages('title_li&depth=1');echo'</ul>';
			}
			echo '<input id="momnavbarextended" type="checkbox" class="hidden" />
			<div class="momnavbar_extended_inner  '.esc_attr($scheme).'">
			<h3 class="clear">'.esc_attr(get_bloginfo('name')).'</h3>
			<p class="siteinfo">'.esc_attr(get_bloginfo('description')).'</p>';
			if(is_single()){if(function_exists('obwcountplus_single')){echo '<span>'; obwcountplus_single();echo' words</span>';}}
			if(function_exists('obwcountplus_total')){echo '<span>';obwcountplus_total();echo ' total</span>';}
			$tags = get_tags('number=10&orderby=count');
			$html = '<div class="listalltags">';
			foreach ( $tags as $tag ) {
				$tag_link = get_tag_link( $tag->term_id );
				$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
				$html .= "{$tag->name}</a>";
			}
			$html .= '</div>';
			echo $html;		
			echo '<div class="recentPostListingThumbnails '.esc_attr($scheme).'">';
				$args=array(
					'numberposts'=>25,
					'post_type'=>'post',
					'post_status'=>'publish',
					'meta_key'=>'_thumbnail_id',
				);		
				$recent_posts = wp_get_recent_posts($args);
				foreach( $recent_posts as $recentthumbs ){
					$url = wp_get_attachment_url( get_post_thumbnail_id($recentthumbs["ID"]) );
					echo '<a class="thumbnail" href="' . get_permalink($recentthumbs["ID"]) . '" title="'.esc_attr($recentthumbs["post_title"]).'" ><img class="skipLazy greyscale" src="'.$url.'" /></a>';
				}
			echo '</div>';
			echo '<div class="recentPostListing">
			<ul>';
				$argsb=array(
					'numberposts'=>12,
					'post_type'=>'post',
					'post_status'=>'publish',
				);					
				$recent_posts = wp_get_recent_posts($argsb);
				foreach( $recent_posts as $recent ){
					echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
				}
			echo '</ul>
			</div>
			</div>';
			if($isTop == 'down'){echo '<label for="momnavbarextended"><span class="momnavbar_tab '.esc_attr($scheme).'"><i class="fa fa-chevron-'.esc_attr($isTop).'"></i></span></label>
						<ul class="momnavbar_pagesdown">';wp_list_pages('title_li&depth=1');echo'</ul>';}
			echo '</div>';
		}
	}
	add_action('wp_footer','mom_topbar');
	// http://plugins.svn.wordpress.org/wp-toolbar-removal/trunk/wp-toolbar-removal.php
	remove_action('init','wp_admin_bar_init');
	remove_filter('init','wp_admin_bar_init');
	remove_action('wp_head','wp_admin_bar');
	remove_filter('wp_head','wp_admin_bar');
	remove_action('wp_footer','wp_admin_bar');
	remove_filter('wp_footer','wp_admin_bar');
	remove_action('admin_head','wp_admin_bar');
	remove_filter('admin_head','wp_admin_bar');
	remove_action('admin_footer','wp_admin_bar');
	remove_filter('admin_footer','wp_admin_bar');
	remove_action('wp_head','wp_admin_bar_class');
	remove_filter('wp_head','wp_admin_bar_class');
	remove_action('wp_footer','wp_admin_bar_class');
	remove_filter('wp_footer','wp_admin_bar_class');
	remove_action('admin_head','wp_admin_bar_class');
	remove_filter('admin_head','wp_admin_bar_class');
	remove_action('admin_footer','wp_admin_bar_class');
	remove_filter('admin_footer','wp_admin_bar_class');
	remove_action('wp_head','wp_admin_bar_css');
	remove_filter('wp_head','wp_admin_bar_css');
	remove_action('wp_head','wp_admin_bar_dev_css');
	remove_filter('wp_head','wp_admin_bar_dev_css');
	remove_action('wp_head','wp_admin_bar_rtl_css');
	remove_filter('wp_head','wp_admin_bar_rtl_css');
	remove_action('wp_head','wp_admin_bar_rtl_dev_css');
	remove_filter('wp_head','wp_admin_bar_rtl_dev_css');
	remove_action('admin_head','wp_admin_bar_css');
	remove_filter('admin_head','wp_admin_bar_css');
	remove_action('admin_head','wp_admin_bar_dev_css');
	remove_filter('admin_head','wp_admin_bar_dev_css');
	remove_action('admin_head','wp_admin_bar_rtl_css');
	remove_filter('admin_head','wp_admin_bar_rtl_css');
	remove_action('admin_head','wp_admin_bar_rtl_dev_css');
	remove_filter('admin_head','wp_admin_bar_rtl_dev_css');
	remove_action('wp_footer','wp_admin_bar_js');
	remove_filter('wp_footer','wp_admin_bar_js');
	remove_action('wp_footer','wp_admin_bar_dev_js');
	remove_filter('wp_footer','wp_admin_bar_dev_js');
	remove_action('admin_footer','wp_admin_bar_js');
	remove_filter('admin_footer','wp_admin_bar_js');
	remove_action('admin_footer','wp_admin_bar_dev_js');
	remove_filter('admin_footer','wp_admin_bar_dev_js');
	remove_action('locale','wp_admin_bar_lang');
	remove_filter('locale','wp_admin_bar_lang');
	remove_action('wp_head','wp_admin_bar_render', 1000);
	remove_filter('wp_head','wp_admin_bar_render', 1000);
	remove_action('wp_footer','wp_admin_bar_render', 1000);
	remove_filter('wp_footer','wp_admin_bar_render', 1000);
	remove_action('admin_head','wp_admin_bar_render', 1000);
	remove_filter('admin_head','wp_admin_bar_render', 1000);
	remove_action('admin_footer','wp_admin_bar_render', 1000);
	remove_filter('admin_footer','wp_admin_bar_render', 1000);
	remove_action('admin_footer','wp_admin_bar_render');
	remove_filter('admin_footer','wp_admin_bar_render');
	remove_action('wp_ajax_adminbar_render','wp_admin_bar_ajax_render', 1000);
	remove_filter('wp_ajax_adminbar_render','wp_admin_bar_ajax_render', 1000);
	remove_action('wp_ajax_adminbar_render','wp_admin_bar_ajax_render');
	remove_filter('wp_ajax_adminbar_render','wp_admin_bar_ajax_render');				
}
/****************************** SECTION I -/- (I0) Functions -/- Font Awesome ******************************/
function font_fa_shortcode($atts, $content = null){
	extract(
		shortcode_atts(array(
			"i" => ''
		), $atts)
	);
	$icon = esc_attr($i);
	if($icon != ''){$iconfinal = $icon;}
	ob_start();
	echo '<i class="fa fa-'.$iconfinal.'"></i>';
	return ob_get_clean();
}
/****************************** SECTION J -/- (J0) Settings -/- Count++ ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_count_module(){
			echo '<form method="post"><span class="moduletitle">__count++<em>Count words published</em></span><div class="clear"></div><div class="settings">';
			echo '<div class="countplus"><section><label for="obwcountplus_1_countdownfrom">Goal (<em>0</em> for none)</label><input id="obwcountplus_1_countdownfrom" type="text" value="'.esc_attr(get_option('obwcountplus_1_countdownfrom')).'" name="obwcountplus_1_countdownfrom"></section><section><label for="obwcountplus_2_remaining">Text for remaining</label><input id="obwcountplus_2_remaining" type="text" value="'.esc_attr(get_option('obwcountplus_2_remaining')).'" name="obwcountplus_2_remaining"></section><section><label for="obwcountplus_3_total">Text for published</label><input id="obwcountplus_3_total" type="text" value="'.esc_attr(get_option('obwcountplus_3_total')).'" name="obwcountplus_3_total"></section><section><label for="obwcountplus_4_custom">Custom output</label><input id="obwcountplus_4_custom" type="text" value="'.esc_attr(get_option('obwcountplus_4_custom')).'" name="obwcountplus_4_custom"></section></div>';
			echo '<input id="obwcountsave" type="submit" value="Save Changes" name="obwcountsave"></form><div class="templatetags"><section>Custom output example: (with goal)<span class="right">%total% words of %remain% published</span></section><section>Custom output example: (without goal) <span class="right">%total% words published</span></section><section>Custom output example: (numbers only)(total on blog) <span class="right">%total%</span></section><section>Custom output example: (numbers only)(total remain of goal) <span class="right">%remain%</span></section><section>Template tag: (single post word count)<span class="right"><code>obwcountplus_total();</code></span></section><section>Custom output:<span class="right"><code>countsplusplus();</code></span></section><section>Total words + remaining:<span class="right"><code>obwcountplus_count();</code></span></section><section>Total words:<span class="right"><code>obwcountplus_total();</code></span></section><section>Remainig:(displays total published if goal reached)<span class="right"><code>obwcountplus_remaining();</code></span></section></div><p class="creditlink">Count++ is adapted from <a href="http://wordpress.org/plugins/post-word-count/">Post Word Count</a> by <a href="http://profiles.wordpress.org/nickmomrik/">Nick Momrik</a>.</p>';
		}
	}
/****************************** SECTION J -/- (J1) Functions -/- Count++ ******************************/
function countsplusplus(){
	$oldcount = 0;
	global $wpdb;
	$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
	$words = $wpdb->get_results($query);
	if($words){
		foreach($words as $word){
			$post = strip_tags($word->post_content);
			$post = explode(' ',$post);
			$count = count($post);
			$totalcount = $count + $oldcount;
			$oldcount = $totalcount;
		}
	}else{
		$totalcount=0;
	}
	$remain	= number_format(get_option('obwcountplus_1_countdownfrom') - $totalcount);
	$c_custom = sanitize_text_field(htmlentities(get_option('obwcountplus_4_custom')));
	$c_search = array('%total%','%remain%');
	$c_replace = array($totalcount,$remain);
	echo str_replace($c_search,$c_replace,$c_custom);
}
function obwcountplus_single(){
	$oldcount = 0;
	global $wpdb, $post;
	$postid	= $post->ID;
	$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND ID = '$postid'";
	$words = $wpdb->get_results($query);
	if($words){
		foreach($words as $word){
			$post = strip_tags($word->post_content);
			$post = explode(' ', $post);
			$count = count($post);
			$totalcount = $count + $oldcount;
			$oldcount = $totalcount;
		}
	}else{
		$totalcount=0;
	}
	if(is_single()){
		echo esc_attr(number_format($totalcount));
	}
}
function obwcountplus_remaining(){
	$oldcount = 0;
	global $wpdb;
	$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
	$words = $wpdb->get_results($query);
	if($words){
		foreach($words as $word){
			$post = strip_tags($word->post_content);
			$post = explode(' ', $post);
			$count = count($post);
			$totalcount = $count + $oldcount;
			$oldcount = $totalcount;
		}
	}else{
		$totalcount=0;
	}
	if(
		$totalcount >= get_option('obwcountplus_1_countdownfrom') ||
		get_option('obwcountplus_1_countdownfrom') == 0
	 ){
		echo esc_attr(number_format($totalcount));
	}else{
		echo esc_attr(number_format(get_option('obwcountplus_1_countdownfrom') - $totalcount));
	}
}
function obwcountplus_total(){
	$oldcount = 0;
	global $wpdb;
	$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
	$words = $wpdb->get_results($query);
	if($words){
		foreach($words as $word){
			$post = strip_tags($word->post_content);
			$post = explode(' ', $post);
			$count = count($post);
			$totalcount = $count + $oldcount;
			$oldcount = $totalcount;
		}
	}else{
		$totalcount=0;
	}
	echo esc_attr(number_format($totalcount));
}
function obwcountplus_count(){
	$oldcount = 0;
	global $wpdb;
	$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'";
	$words = $wpdb->get_results($query);
	if($words){
		foreach($words as $word){
			$post = strip_tags($word->post_content);
			$post = explode(' ',$post);
			$count = count($post);
			$totalcount = $count + $oldcount;
			$oldcount = $totalcount;
		}
	}else{
		$totalcount=0;
	}
	if(
		$totalcount >= get_option('obwcountplus_1_countdownfrom') ||
		get_option('obwcountplus_1_countdownfrom') == 0
	){
		echo esc_attr(number_format($totalcount)." ".get_option('obwcountplus_3_total'));
	}else{
		echo esc_attr(number_format(get_option('obwcountplus_1_countdownfrom') - $totalcount).' '.get_option('obwcountplus_2_remaining').' ('.number_format($totalcount).' '.get_option('obwcountplus_3_total').')');
	}
}
/****************************** SECTION K -/- (K0) Settings -/- Exclude ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_exclude_module(){
			echo '<span class="moduletitle">__exclude<em>separate multiple ids with commas (1,2,3,...)</em></span><div class="clear"></div><div class="settings"><form method="post">';
			echo '
				<div class="listing">
				<div class="list"><span>Category (<strong>ID</strong>)</span>';
				$showmecats = get_categories('taxonomy=category&hide_empty=0'); 
				foreach($showmecats as $catsshown){
					echo '
					<span>'.$catsshown->cat_name.'(<strong>'.$catsshown->cat_ID.'</strong>)</span>';
				}
			echo '
			</div>
			<div class="list"><span>Tag (<strong>ID</strong>)</span>';
				$showmetags = get_categories('taxonomy=post_tag&hide_empty=0');
					foreach($showmetags as $tagsshown){
					echo '<span>'.$tagsshown->cat_name.'(<strong>'.$tagsshown->cat_ID.'</strong>)</span>';
				}
			echo '
			</div>
			</div>				
			<input class="allitems" type="text" onclick="this.select();" value="';
			foreach($showmecats as $catsall){
				echo $catsall->cat_ID.',';
			}
			echo '"/>
			<input class="allitems" type="text" onclick="this.select();" value="';
			foreach($showmetags as $tagsall){
				echo $tagsall->cat_ID.',';
			}				
			echo '"/>
			<div class="clear"></div>
			
			<div class="exclude">
				<section><span class="left">hide categories</span></section>
				<section class="break"><span class="right"></span></section>
				<section><hr/></section>	
				<section><label for="MOM_Exclude_Categories_RSS">RSS</label><input type="text" id="MOM_Exclude_Categories_RSS" name="MOM_Exclude_Categories_RSS" value="'.get_option('MOM_Exclude_Categories_RSS').'"></section>
				<section><label for="MOM_Exclude_Categories_Front">front page</label><input type="text" id="MOM_Exclude_Categories_Front" name="MOM_Exclude_Categories_Front" value="'.get_option('MOM_Exclude_Categories_Front').'"></section>
				<section><label for="MOM_Exclude_Categories_TagArchives">tag archives</label><input type="text" id="MOM_Exclude_Categories_TagArchives" name="MOM_Exclude_Categories_TagArchives" value="'.get_option('MOM_Exclude_Categories_TagArchives').'"></section>
				<section><label for="MOM_Exclude_Categories_SearchResults">search results</label><input type="text" id="MOM_Exclude_Categories_SearchResults" name="MOM_Exclude_Categories_SearchResults" value="'.get_option('MOM_Exclude_Categories_SearchResults').'"></section>
				<section class="break"><span class="right"></span></section>					
				<section><hr/></section>	
				<section><label for="MOM_Exclude_CategoriesSun">Sunday</label><input type="text" id="MOM_Exclude_CategoriesSun" name="MOM_Exclude_CategoriesSun" value="'.get_option('MOM_Exclude_CategoriesSun').'"></section>
				<section><label for="MOM_Exclude_CategoriesMon">Monday</label><input type="text" id="MOM_Exclude_CategoriesMon" name="MOM_Exclude_CategoriesMon" value="'.get_option('MOM_Exclude_CategoriesMon').'"></section>
				<section><label for="MOM_Exclude_CategoriesTue">Tuesday</label><input type="text" id="MOM_Exclude_CategoriesTue" name="MOM_Exclude_CategoriesTue" value="'.get_option('MOM_Exclude_CategoriesTue').'"></section>
				<section><label for="MOM_Exclude_CategoriesWed">Wednesday</label><input type="text" id="MOM_Exclude_CategoriesWed" name="MOM_Exclude_CategoriesWed" value="'.get_option('MOM_Exclude_CategoriesWed').'"></section>
				<section><label for="MOM_Exclude_CategoriesThu">Thursday</label><input type="text" id="MOM_Exclude_CategoriesThu" name="MOM_Exclude_CategoriesThu" value="'.get_option('MOM_Exclude_CategoriesThu').'"></section>
				<section><label for="MOM_Exclude_CategoriesFri">Friday</label><input type="text" id="MOM_Exclude_CategoriesFri" name="MOM_Exclude_CategoriesFri" value="'.get_option('MOM_Exclude_CategoriesFri').'"></section>
				<section><label for="MOM_Exclude_CategoriesSat">Saturday</label><input type="text" id="MOM_Exclude_CategoriesSat" name="MOM_Exclude_CategoriesSat" value="'.get_option('MOM_Exclude_CategoriesSat').'"></section>
				<section class="break"><span class="right"></span></section>
				<section><hr/></section>	
				<section><label for="MOM_Exclude_VisitorCategories">logged out</label><input type="text" id="MOM_Exclude_VisitorCategories" name="MOM_Exclude_VisitorCategories" value="'.get_option('MOM_Exclude_VisitorCategories').'"></section>
				<section><label for="MOM_Exclude_level0Categories">subscriber</label><input type="text" id="MOM_Exclude_level0Categories" name="MOM_Exclude_level0Categories" value="'.get_option('MOM_Exclude_level0Categories').'"></section>
				<section><label for="MOM_Exclude_level1Categories">contributor</label><input type="text" id="MOM_Exclude_level1Categories" name="MOM_Exclude_level1Categories" value="'.get_option('MOM_Exclude_level1Categories').'"></section>
				<section><label for="MOM_Exclude_level2Categories">author</label><input type="text" id="MOM_Exclude_level2Categories" name="MOM_Exclude_level2Categories" value="'.get_option('MOM_Exclude_level2Categories').'"></section>
				<section><label for="MOM_Exclude_level7Categories">editor</label><input type="text" id="MOM_Exclude_level7Categories" name="MOM_Exclude_level7Categories" value="'.get_option('MOM_Exclude_level7Categories').'"></section>
				
			</div>';
			echo '
			<div class="exclude">
				<section><span class="left">hide tags</span></section>
				<section class="break"><span class="right">from area</span></section>				
				<section><hr/></section>					
				<section><label for="MOM_Exclude_Tags_RSS">RSS</label><input type="text" id="MOM_Exclude_Tags_RSS" name="MOM_Exclude_Tags_RSS" value="'.get_option('MOM_Exclude_Tags_RSS').'"></section>
				<section><label for="MOM_Exclude_Tags_Front">front page</label><input type="text" id="MOM_Exclude_Tags_Front" name="MOM_Exclude_Tags_Front" value="'.get_option('MOM_Exclude_Tags_Front').'"></section>
				<section><label for="MOM_Exclude_Tags_CategoryArchives">categories</label><input type="text" id="MOM_Exclude_Tags_CategoryArchives" name="MOM_Exclude_Tags_CategoryArchives" value="'.get_option('MOM_Exclude_Tags_CategoryArchives').'"></section>
				<section><label for="MOM_Exclude_Tags_SearchResults">search results</label><input type="text" id="MOM_Exclude_Tags_SearchResults" name="MOM_Exclude_Tags_SearchResults" value="'.get_option('MOM_Exclude_Tags_SearchResults').'"></section>
				<section class="break"><span class="right">from day</span></section>					
				<section><hr/></section>	
				<section><label for="MOM_Exclude_TagsSun">Sunday</label><input type="text" id="MOM_Exclude_TagsSun" name="MOM_Exclude_TagsSun" value="'.get_option('MOM_Exclude_TagsSun').'"></section>
				<section><label for="MOM_Exclude_TagsMon">Monday</label><input type="text" id="MOM_Exclude_TagsMon" name="MOM_Exclude_TagsMon" value="'.get_option('MOM_Exclude_TagsMon').'"></section>
				<section><label for="MOM_Exclude_TagsTue">Tuesday</label><input type="text" id="MOM_Exclude_TagsTue" name="MOM_Exclude_TagsTue" value="'.get_option('MOM_Exclude_TagsTue').'"></section>
				<section><label for="MOM_Exclude_TagsWed">Wednesday</label><input type="text" id="MOM_Exclude_TagsWed" name="MOM_Exclude_TagsWed" value="'.get_option('MOM_Exclude_TagsWed').'"></section>
				<section><label for="MOM_Exclude_TagsThu">Thursday</label><input type="text" id="MOM_Exclude_TagsThu" name="MOM_Exclude_TagsThu" value="'.get_option('MOM_Exclude_TagsThu').'"></section>
				<section><label for="MOM_Exclude_TagsFri">Friday</label><input type="text" id="MOM_Exclude_TagsFri" name="MOM_Exclude_TagsFri" value="'.get_option('MOM_Exclude_TagsFri').'"></section>
				<section><label for="MOM_Exclude_TagsSat">Saturday</label><input type="text" id="MOM_Exclude_TagsSat" name="MOM_Exclude_TagsSat" value="'.get_option('MOM_Exclude_TagsSat').'"></section>
				<section class="break"><span class="right">from user level</span></section>
				<section><hr/></section>	
				<section><label for="MOM_Exclude_VisitorTags">logged out</label><input type="text" id="MOM_Exclude_VisitorTags" name="MOM_Exclude_VisitorTags" value="'.get_option('MOM_Exclude_VisitorTags').'"></section>				
				<section><label for="MOM_Exclude_level0Tags">subscriber</label><input type="text" id="MOM_Exclude_level0Tags" name="MOM_Exclude_level0Tags" value="'.get_option('MOM_Exclude_level0Tags').'"></section>
				<section><label for="MOM_Exclude_level1Tags">contributor</label><input type="text" id="MOM_Exclude_level1Tags" name="MOM_Exclude_level1Tags" value="'.get_option('MOM_Exclude_level1Tags').'"></section>
				<section><label for="MOM_Exclude_level2Tags">author</label><input type="text" id="MOM_Exclude_level2Tags" name="MOM_Exclude_level2Tags" value="'.get_option('MOM_Exclude_level2Tags').'"></section>
				<section><label for="MOM_Exclude_level7Tags">editor</label><input type="text" id="MOM_Exclude_level7Tags" name="MOM_Exclude_level7Tags" value="'.get_option('MOM_Exclude_level7Tags').'"></section>
			</div>
			<div class="exclude">';
			echo '
			<section><span class="left">hide post formats</span></section>
			<section class="break"><span class="right">from area</span></section>
			<section><hr/></section>
			<section>
				<label for="MOM_Exclude_PostFormats_RSS">RSS</label>
				<select name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
					<option value="">none</option>
					<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
					<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
					<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
					<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
					<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
					<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
					<option value="post-format-video"';if( get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
					<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
					<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
				</select>
			</section>
			<section>
				<label for="MOM_Exclude_PostFormats_Front">front page</label>
				<select name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
					<option value="">none</option>
					<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
					<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
					<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
					<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
					<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
					<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
					<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
					<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
					<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
				</select>
			</section>
			<section>
				<label for="MOM_Exclude_PostFormats_CategoryArchives">archives</label>
				<select name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
					<option value="">none</option>
					<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
					<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
					<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
					<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
					<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
					<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
					<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
					<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
					<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives')	=== 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
				</select>
			</section>
			<section>
				<label for="MOM_Exclude_PostFormats_TagArchives">tags</label>
				<select name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
					<option value="">none</option>
					<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-aside'){echo ' selected="selected"';} echo '>Aside</option>
					<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-gallery'){echo ' selected="selected"';} echo '>Gallery</option>
					<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-link'){echo ' selected="selected"';} echo '>Link</option>
					<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-image'){echo ' selected="selected"';} echo '>Image</option>
					<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-quote'){echo ' selected="selected"';} echo '>Quote</option>
					<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-status'){echo ' selected="selected"';} echo '>Status</option>
					<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-video'){echo ' selected="selected"';} echo '>Video</option>
					<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-audio'){echo ' selected="selected"';} echo '>Audio</option>
					<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-chat'){echo ' selected="selected"';} echo '>Chat</option>
				</select>
			</section>
			<section>
				<label for="MOM_Exclude_PostFormats_SearchResults">search results</label>
				<select name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
					<option value="">none</option>
					<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
					<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
					<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
					<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
					<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
					<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
					<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
					<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
					<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
				</select>
			</section>
			<section>
				<label for="MOM_Exclude_PostFormats_Visitor">logged out</label>
				<select name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
					<option value="">none</option>
					<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
					<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
					<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
					<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
					<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
					<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
					<option value="post-format-video"';if( get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
					<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
					<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
				</select>
			</section>';
			$showmepages = get_pages(); 
			echo '
			<section class="break"><span class="right">additional settings</span></section>
			<section><hr/></section>
			<section>
			<label for="MOM_Exclude_Hide_Dashboard">Hide Dash for all but admin</label>
			<select name="MOM_Exclude_Hide_Dashboard" class="allpages" id="MOM_Exclude_Hide_Dashboard">
			<option ';if(get_option('MOM_Exclude_Hide_Dashboard') == 1){echo ' selected="selected" ';} echo 'value="1">Yes</option>
			<option ';if(get_option('MOM_Exclude_Hide_Dashboard') == 0){echo ' selected="selected" ';} echo 'value="0">No</option>
			</select>
			</section>
			<section>
			<label for="MOM_Exclude_NoFollow">No Follow User Level Hidden</label>
			<select name="MOM_Exclude_NoFollow" class="allpages" id="MOM_Exclude_NoFollow">
			<option ';if(get_option('MOM_Exclude_NoFollow') == 1){echo ' selected="selected" ';} echo 'value="1">Yes</option>
			<option ';if(get_option('MOM_Exclude_NoFollow') == 0){echo ' selected="selected" ';} echo 'value="0">No</option>
			</select>
			</section>
			<section>
			<label for="MOM_Exclude_URL">Redirect 404s (logged in)</label>
			<select name="MOM_Exclude_URL" class="allpages" id="MOM_Exclude_URL">
				<option value="">Home page</option>';
				foreach($showmepages as $pagesshown){
					echo '<option name="MOM_Exclude_URL" id="mompaf_'.$pagesshown->ID.'" value="'.$pagesshown->ID.'"'; 
					if(get_option('MOM_Exclude_URL') == $pagesshown->ID){echo ' selected="selected"';} echo '>
					'.$pagesshown->post_title.'</option>';
				}
				echo '
			</select>
			</section>
			<section>
			<label for="MOM_Exclude_URL_User">Redirect 404s (logged out)</label>
			<select name="MOM_Exclude_URL_User" class="allpages" id="MOM_Exclude_URL_User">
				<option value=""/>Home page</option>';
				foreach($showmepages as $pagesshownuser){
					echo '<option name="MOM_Exclude_URL_User" id="mompaf_'.$pagesshownuser->ID.'" value="'.$pagesshown->ID.'"'; 
					if(get_option('MOM_Exclude_URL_User') == $pagesshownuser->ID){echo ' selected="selected"';} echo '>
					'.$pagesshownuser->post_title.'</option>';
				}
				echo '
			</select>
			</section>';
			echo '<input id="momsesave" type="submit" value="Save Changes" name="momsesave"></form></div></div>';
		}
}
/****************************** SECTION K -/- (K1) Settings -/- Exclude ******************************/
get_currentuserinfo();
global $user_level;	
if($user_level <=7 && get_option('MOM_Exclude_Hide_Dashboard') == 1){
	// http://wordpress.org/support/topic/hide-dashboard-for-all-except-admin-without-plugin?replies=5
	function remove_the_dashboard(){
		global $menu, $submenu, $user_ID;
		$the_user = new WP_User($user_ID);
		reset($menu); $page = key($menu);
		while((__('Dashboard') != $menu[$page][0]) && next($menu))
		$page = key($menu);
		if(__('Dashboard') == $menu[$page][0]) unset($menu[$page]);
		reset($menu); $page = key($menu);
		while(!$the_user->has_cap($menu[$page][1]) && next($menu))
		$page = key($menu);
		if(preg_match('#wp-admin/?(index.php)?$#',$_SERVER['REQUEST_URI']) && ('index.php' != $menu[$page][2]))
		wp_redirect(get_option('siteurl') . '/wp-admin/profile.php');
	}
	add_action('admin_menu','remove_the_dashboard');
}
if(!is_user_logged_in() || is_user_logged_in() && $user_level == 0 || is_user_logged_in() && $user_level == 1 || is_user_logged_in() && $user_level == 2 || is_user_logged_in() && $user_level == 7){
	function exclude_post_by_category($query){
	$loggedOutCats = '0';
	if(!is_user_logged_in()){
		$loggedOutCats = get_option('MOM_Exclude_VisitorCategories').','.get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories');
	}else{
		get_currentuserinfo();
		global $user_level;
		$loggedOutCats = '0';
		if($user_level == 0){$loggedOutCats = get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories');}
		if($user_level <= 1){$loggedOutCats = get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories');}
		if($user_level <= 2){$loggedOutCats = get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories');}
		if($user_level <= 7){$loggedOutCats = get_option('MOM_Exclude_level7Categories');}
	}
		$c1 = explode(',',$loggedOutCats);
		foreach($c1 as &$C1){$C1 = ''.$C1.',';}
		$c_1 = rtrim(implode($c1),',');
		$c11 = explode(',',str_replace(' ','',$c_1));
		$c11array = array($c11);
		$excluded_category_ids = array_filter($c11);
		if($query->is_main_query()){
			if($query->is_single()){
				if(($query->query_vars['p'])){
					$page= $query->query_vars['p'];
				}else if(isset($query->query_vars['name'])){
					$page_slug = $query->query_vars['name'];
					$post_type = 'post';
					global $wpdb;
					$page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'",$page_slug,$post_type));
				}
				if($page){
					$post_categories = wp_get_post_categories($page);
					foreach($excluded_category_ids as $category_id){
						if(in_array($category_id,$post_categories)){
							$query->set('p',-$category_id);
							break;
						}
					}
				}	
			}
		}
	}
	function exclude_post_by_tag($query){
	$loggedOutTags = '0';
	if(!is_user_logged_in()){
		$loggedOutTags = get_option('MOM_Exclude_VisitorTags').','.get_option('MOM_Exclude_level0Tags').','.get_option('MOM_Exclude_level1Tags').','.get_option('MOM_Exclude_level2Tags').','.get_option('MOM_Exclude_level7Tags');
	}else{
		get_currentuserinfo();
		if($user_level == 0){$loggedOutTags = get_option('MOM_Exclude_level0Tags').','.get_option('MOM_Exclude_level1Tags').','.get_option('MOM_Exclude_level2Tags').','.get_option('MOM_Exclude_level7Tags');}
		if($user_level <= 1){$loggedOutTags = get_option('MOM_Exclude_level1Tags').','.get_option('MOM_Exclude_level2Tags').','.get_option('MOM_Exclude_level7Tags');}
		if($user_level <= 2){$loggedOutTags = get_option('MOM_Exclude_level2Tags').','.get_option('MOM_Exclude_level7Tags');}
		if($user_level <= 7){$loggedOutTags = get_option('MOM_Exclude_level7Tags');}
	}
			$t1 = explode(',',$loggedOutTags);
			foreach($t1 as &$T1){$T1 = ''.$T1.',';}
			$t_1 = implode($t1);
			$t11 = explode(',',str_replace(' ','',$t_1));
		$excluded_tag_ids = array_filter($t11);
		if($query->is_main_query()){
			if($query->is_single()){
				if(($query->query_vars['p'])){
					$page= $query->query_vars['p'];
				}else if(isset($query->query_vars['name'])){
					$page_slug = $query->query_vars['name'];
					$post_type = 'post';
					global $wpdb;
					$page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'",$page_slug, $post_type));
				}
				if($page){
					$post_tags = wp_get_post_tags($page);
					foreach($excluded_tag_ids as $tag_id){
						if(in_array($tag_id,$post_tags)){
							$query->set('p',-$tag_id);
							break;
						}
					}
				}
			}
		}
	}
	add_action('pre_get_posts','exclude_post_by_tag');
	add_action('pre_get_posts','exclude_post_by_category');
}
if(get_option('MOM_Exclude_NoFollow') != 0){
	add_filter('wp_list_categories','exclude_nofollow');
	add_filter('the_category','exclude_nofollow_categories');
	function exclude_nofollow($text){
		$text = stripslashes($text);
		$text = preg_replace_callback('|<a (.+?)>|i','wp_rel_nofollow_callback', $text);
		return $text;
	}
	function exclude_nofollow_categories($text){
		$text = str_replace('rel="category tag"', "", $text);
		$text = exclude_nofollow($text);
		return $text;
	}
	function exclude_no_index_cat()
	{
		$nofollowCats = get_option('MOM_Exclude_VisitorCategories').','.get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories');	
		$c1 = explode(',',$nofollowCats);
		foreach($c1 as &$C1){$C1 = ''.$C1.',';}
		$c_1 = rtrim(implode($c1),',');
		$c11 = explode(',',str_replace(' ','',$c_1));
		$c11array = array($c11);
		$nofollowcats = $c11;
		if(is_category($nofollowcats) && !is_feed())
		{
				echo '<meta name="robots" content="noindex, nofollow" />';
		}
	}
	add_action('wp_head','exclude_no_index_cat');
	function nofollow_the_author_posts_link($deprecated = ''){
		global $authordata;
		printf(
			'<a rel="nofollow" href="%1$s" title="%2$s">%3$s</a>',
			get_author_posts_url($authordata->ID,$authordata->user_nicename),
			sprintf( __('Posts by %s'), attribute_escape(get_the_author())),
			get_the_author()
		);
	}	
	function nofollow_cat_posts($text){
	$loggedOutCats = get_option('MOM_Exclude_VisitorCategories').','.get_option('MOM_Exclude_level0Categories').','.get_option('MOM_Exclude_level1Categories').','.get_option('MOM_Exclude_level2Categories').','.get_option('MOM_Exclude_level7Categories');	
	$c1 = explode(',',$loggedOutCats);
	foreach($c1 as &$C1){$C1 = ''.$C1.',';}
	$c_1 = rtrim(implode($c1),',');
	$c11 = explode(',',str_replace(' ','',$c_1));
	$c11array = array($c11);
	$excluded_category_ids = $c11;
	global $post;
			if(in_category($excluded_category_ids)){
					$text = stripslashes(wp_rel_nofollow($text));
			}
			return $text;
	}
	add_filter('the_content','nofollow_cat_posts');
}
function mom_exclude_filter_posts($query){
	$c1	= array('0');
	$lt_1 = array('0');
	$t1	= array('0');
	$t_1 = array('0');
	$c_1 = '0';
	if(get_option('MOM_Exclude_Categories_Front') == ''){$MOM_Exclude_Categories_Front = '0';}else{$MOM_Exclude_Categories_Front = get_option('MOM_Exclude_Categories_Front');}
	if(get_option('MOM_Exclude_Categories_TagArchives') == ''){$MOM_Exclude_Categories_TagArchives = '0';}else{$MOM_Exclude_Categories_TagArchives = get_option('MOM_Exclude_Categories_TagArchives');}
	if(get_option('MOM_Exclude_Categories_SearchResults') == ''){$MOM_Exclude_Categories_SearchResults = '0';}else{$MOM_Exclude_Categories_SearchResults = get_option('MOM_Exclude_Categories_SearchResults');}
	if(get_option('MOM_Exclude_Categories_RSS') == ''){$MOM_Exclude_Categories_RSS = '0';}else{$MOM_Exclude_Categories_RSS = get_option('MOM_Exclude_Categories_RSS');}
	if(get_option('MOM_Exclude_Tags_RSS') == ''){$MOM_Exclude_Tags_RSS = '0';}else{$MOM_Exclude_Tags_RSS = get_option('MOM_Exclude_Tags_RSS');}
	if(get_option('MOM_Exclude_Tags_Front') == ''){$MOM_Exclude_Tags_Front = '0';}else{$MOM_Exclude_Tags_Front = get_option('MOM_Exclude_Tags_Front');}
	if(get_option('MOM_Exclude_Tags_CategoryArchives') == ''){$MOM_Exclude_Tags_CategoryArchives = '0';}else{$MOM_Exclude_Tags_CategoryArchives = get_option('MOM_Exclude_Tags_CategoryArchives');}
	if(get_option('MOM_Exclude_Tags_SearchResults') == ''){$MOM_Exclude_Tags_SearchResults = '0';}else{$MOM_Exclude_Tags_SearchResults = get_option('MOM_Exclude_Tags_SearchResults');}
	if(get_option('MOM_Exclude_PostFormats_Front') == ''){$MOM_Exclude_PostFormats_Front = '';}else{$MOM_Exclude_PostFormats_Front = get_option('MOM_Exclude_PostFormats_Front');}
	if(get_option('MOM_Exclude_PostFormats_CategoryArchives') == ''){$MOM_Exclude_PostFormats_CategoryArchives = '';}else{$MOM_Exclude_PostFormats_CategoryArchives = get_option('MOM_Exclude_PostFormats_CategoryArchives');}
	if(get_option('MOM_Exclude_PostFormats_TagArchives') == ''){$MOM_Exclude_PostFormats_TagArchives = '';}else{$MOM_Exclude_PostFormats_TagArchives = get_option('MOM_Exclude_PostFormats_TagArchives');}
	if(get_option('MOM_Exclude_PostFormats_SearchResults') == ''){$MOM_Exclude_PostFormats_SearchResults = '';}else{$MOM_Exclude_PostFormats_SearchResults = get_option('MOM_Exclude_PostFormats_SearchResults');}
	if(get_option('MOM_Exclude_PostFormats_Visitor') == ''){$MOM_Exclude_PostFormats_Visitor = '';}else{$MOM_Exclude_PostFormats_Visitor = get_option('MOM_Exclude_PostFormats_Visitor');}
	if(get_option('MOM_Exclude_PostFormats_RSS') == ''){$MOM_Exclude_PostFormats_RSS = '';}else{$MOM_Exclude_PostFormats_RSS = get_option('MOM_Exclude_PostFormats_RSS');}
	if(get_option('MOM_Exclude_Cats_Day') == ''){$MOM_Exclude_Cats_Day = '0';}
	if(get_option('MOM_Exclude_Tags_Day') == ''){$MOM_Exclude_Tags_Day = '0';}
	if(date('D') === 'Sun'){if(get_option('') == 'MOM_Exclude_Tags_Day')$MOM_Exclude_Tags_Day = '0';}else{$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsSun');}
	if(date('D') === 'Mon'){if(get_option('') == 'MOM_Exclude_Tags_Day')$MOM_Exclude_Tags_Day = '0';}else{$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsMon');}
	if(date('D') === 'Tue'){if(get_option('') == 'MOM_Exclude_Tags_Day')$MOM_Exclude_Tags_Day = '0';}else{$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsTue');}
	if(date('D') === 'Wed'){if(get_option('') == 'MOM_Exclude_Tags_Day')$MOM_Exclude_Tags_Day = '0';}else{$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsWed');}
	if(date('D') === 'Thu'){if(get_option('') == 'MOM_Exclude_Tags_Day')$MOM_Exclude_Tags_Day = '0';}else{$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsThu');}
	if(date('D') === 'Fri'){if(get_option('') == 'MOM_Exclude_Tags_Day')$MOM_Exclude_Tags_Day = '0';}else{$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsFri');}
	if(date('D') === 'Sat'){if(get_option('') == 'MOM_Exclude_Tags_Day')$MOM_Exclude_Tags_Day = '0';}else{$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsSun');}
	if(date('D') === 'Sun'){if(get_option('') == 'MOM_Exclude_Cats_Day')$MOM_Exclude_Cats_Day = '0';}else{$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesSun');}
	if(date('D') === 'Mon'){if(get_option('') == 'MOM_Exclude_Cats_Day')$MOM_Exclude_Cats_Day = '0';}else{$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesMon');}
	if(date('D') === 'Tue'){if(get_option('') == 'MOM_Exclude_Cats_Day')$MOM_Exclude_Cats_Day = '0';}else{$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesTue');}
	if(date('D') === 'Wed'){if(get_option('') == 'MOM_Exclude_Cats_Day')$MOM_Exclude_Cats_Day = '0';}else{$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesWed');}
	if(date('D') === 'Thu'){if(get_option('') == 'MOM_Exclude_Cats_Day')$MOM_Exclude_Cats_Day = '0';}else{$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesThu');}
	if(date('D') === 'Fri'){if(get_option('') == 'MOM_Exclude_Cats_Day')$MOM_Exclude_Cats_Day = '0';}else{$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesFri');}
	if(date('D') === 'Sat'){if(get_option('') == 'MOM_Exclude_Cats_Day')$MOM_Exclude_Cats_Day = '0';}else{$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesSat');}
	$rss_day = explode(',',$MOM_Exclude_Tags_Day);
	foreach($rss_day as &$rss_day_1){$rss_day_1 = ''.$rss_day_1.',';}
	$rss_day_1 = implode($rss_day);
	$rssday = explode(',',str_replace(' ','',$rss_day_1));
	$rss_day_cat = explode(',',$MOM_Exclude_Cats_Day);
	if(is_array($rss_day_cat)){foreach($rss_day_cat as &$rss_day_1_cat){$rss_day_1_cat = ''.$rss_day_1_cat.',';}}
	$rss_day_1_cat = implode($rss_day_cat);
	$rssday_cat = explode(',', str_replace(' ','',$rss_day_1_cat));		
	if(!is_user_logged_in()){
		$loggedOutCats = '0';
		$loggedOutTags = '0';
		if(get_option('MOM_Exclude_VisitorCategories') != ''){$MOM_Exclude_VisitorCategories = get_option('MOM_Exclude_VisitorCategories');}else{$MOM_Exclude_VisitorCategories = '0';}
		if(get_option('MOM_Exclude_level0Categories') != ''){$MOM_Exclude_level0Categories = get_option('MOM_Exclude_level0Categories');}else{$MOM_Exclude_level0Categories = '0';}
		if(get_option('MOM_Exclude_level1Categories') != ''){$MOM_Exclude_level1Categories = get_option('MOM_Exclude_level1Categories');}else{$MOM_Exclude_level1Categories = '0';}
		if(get_option('MOM_Exclude_level2Categories') != ''){$MOM_Exclude_level2Categories = get_option('MOM_Exclude_level2Categories');}else{$MOM_Exclude_level2Categories = '0';}
		if(get_option('MOM_Exclude_level7Categories') != ''){$MOM_Exclude_level7Categories = get_option('MOM_Exclude_level7Categories');}else{$MOM_Exclude_level7Categories = '0';}
		if(get_option('MOM_Exclude_VisitorTags') != ''){$MOM_Exclude_VisitorTags = get_option('MOM_Exclude_VisitorTags');}else{$MOM_Exclude_VisitorTags = '0';}
		if(get_option('MOM_Exclude_level0Tags') != ''){$MOM_Exclude_level0Tags = get_option('MOM_Exclude_level0Tags');}else{$MOM_Exclude_level0Tags = '0';}
		if(get_option('MOM_Exclude_level1Tags') != ''){$MOM_Exclude_level1Tags = get_option('MOM_Exclude_level1Tags');}else{$MOM_Exclude_level1Tags = '0';}
		if(get_option('MOM_Exclude_level2Tags') != ''){$MOM_Exclude_level2Tags = get_option('MOM_Exclude_level2Tags');}else{$MOM_Exclude_level2Tags = '0';}		
		$loggedOutCats = $MOM_Exclude_VisitorCategories.','.$MOM_Exclude_level0Categories.','.$MOM_Exclude_level1Categories.','.$MOM_Exclude_level2Categories.','.$MOM_Exclude_level7Categories;
		$loggedOutTags = $MOM_Exclude_VisitorTags.','.$MOM_Exclude_level0Tags.','.$MOM_Exclude_level1Tags.','.$MOM_Exclude_level2Tags.','.$MOM_Exclude_level7Tags;
		$lc1 = array_unique(explode(',',$loggedOutCats));
		foreach($lc1 as &$LC1){$LC1 = ''.$LC1.',';}
		$lc_1 = rtrim(implode($lc1),',');
		$hideLoggedOutCats = explode(',',str_replace(' ','',$loggedOutCats));
		$lt1 = array_unique(explode(',',$loggedOutTags));
		foreach($lt1 as &$LT1){$LT1 = ''.$LT1.',';}
		$lt11 = rtrim(implode($lt1),',');
		$hideLoggedOutTags = explode(',',str_replace(' ','',$lt11));
		$hidePostFormats = $MOM_Exclude_PostFormats_Visitor;
	}else{
		get_currentuserinfo();
		global $user_level;
		$loggedOutCats = '0';
		$loggedOutTags = '0';
		if(get_option('MOM_Exclude_VisitorCategories') != ''){$MOM_Exclude_VisitorCategories = get_option('MOM_Exclude_VisitorCategories');}else{$MOM_Exclude_VisitorCategories = '0';}
		if(get_option('MOM_Exclude_level0Categories') != ''){$MOM_Exclude_level0Categories = get_option('MOM_Exclude_level0Categories');}else{$MOM_Exclude_level0Categories = '0';}
		if(get_option('MOM_Exclude_level1Categories') != ''){$MOM_Exclude_level1Categories = get_option('MOM_Exclude_level1Categories');}else{$MOM_Exclude_level1Categories = '0';}
		if(get_option('MOM_Exclude_level2Categories') != ''){$MOM_Exclude_level2Categories = get_option('MOM_Exclude_level2Categories');}else{$MOM_Exclude_level2Categories = '0';}
		if(get_option('MOM_Exclude_level7Categories') != ''){$MOM_Exclude_level7Categories = get_option('MOM_Exclude_level7Categories');}else{$MOM_Exclude_level7Categories = '0';}		
		if(get_option('MOM_Exclude_VisitorTags') != ''){$MOM_Exclude_VisitorTags = get_option('MOM_Exclude_VisitorTags');}else{$MOM_Exclude_VisitorTags = '0';}
		if(get_option('MOM_Exclude_level0Tags') != ''){$MOM_Exclude_level0Tags = get_option('MOM_Exclude_level0Tags');}else{$MOM_Exclude_level0Tags = '0';}
		if(get_option('MOM_Exclude_level1Tags') != ''){$MOM_Exclude_level1Tags = get_option('MOM_Exclude_level1Tags');}else{$MOM_Exclude_level1Tags = '0';}
		if(get_option('MOM_Exclude_level2Tags') != ''){$MOM_Exclude_level2Tags = get_option('MOM_Exclude_level2Tags');}else{$MOM_Exclude_level2Tags = '0';}
		if(get_option('MOM_Exclude_level7Categories') != ''){$MOM_Exclude_level7Categories = get_option('MOM_Exclude_level7Categories');}else{$MOM_Exclude_level7Categories = '0';}				
		if($user_level == 0){$loggedOutCats = $MOM_Exclude_level0Categories.','.$MOM_Exclude_level1Categories.','.$MOM_Exclude_level2Categories.','.$MOM_Exclude_level7Categories;}
		elseif($user_level == 1){$loggedOutCats = $MOM_Exclude_level1Categories.','.$MOM_Exclude_level2Categories.','.$MOM_Exclude_level7Categories;}
		elseif($user_level == 2){$loggedOutCats = $MOM_Exclude_level2Categories.','.$MOM_Exclude_level7Categories;}
		elseif($user_level == 7){$loggedOutCats = $MOM_Exclude_level7Categories;}
		if($user_level == 0){$loggedOutTags = $MOM_Exclude_level0Tags.','.$MOM_Exclude_level1Tags.','.$MOM_Exclude_level2Tags.','.$MOM_Exclude_level7Tags;}
		elseif($user_level == 1){$loggedOutTags = $MOM_Exclude_level1Tags.','.$MOM_Exclude_level2Tags.','.$MOM_Exclude_level7Tags;}
		elseif($user_level == 2){$loggedOutTags = $MOM_Exclude_level2Tags.','.$MOM_Exclude_level7Tags;}
		elseif($user_level == 7){$loggedOutTags = $MOM_Exclude_level7Tags;}
		$hideLoggedOutCats = explode(',',str_replace(' ','',$c_1));
		$hideLoggedOutTags = explode(',',str_replace(' ','',$t11));
		$lc1 = array_unique(explode(',',$loggedOutCats));
		foreach($lc1 as &$LC1){$LC1 = ''.$LC1.',';}
		$lc_1 = rtrim(implode($lc1),',');
		$hideLoggedOutCats = explode(',',str_replace(' ','',$loggedOutCats));
		$lt1 = array_unique(explode(',',$loggedOutTags));
		foreach($lt1 as &$LT1){$LT1 = ''.$LT1.',';}
		$lt11 = rtrim(implode($lt1),',');
		$hideLoggedOutTags = explode(',',str_replace(' ','',$lt11));
	}
	if($query->is_feed){$c1 = explode(',',$MOM_Exclude_Categories_RSS);$hidePostFormats = $MOM_Exclude_PostFormats_RSS;$t1 = explode(',',$MOM_Exclude_Tags_RSS);}
	if($query->is_home){$c1 = explode(',',$MOM_Exclude_Categories_Front);$hidePostFormats = $MOM_Exclude_PostFormats_Front;$t1 = explode(',',$MOM_Exclude_Tags_Front);}
	if($query->is_category){$t1 = explode(',',$MOM_Exclude_Tags_CategoryArchives);$hidePostFormats = $MOM_Exclude_PostFormats_CategoryArchives;}
	if($query->is_tag){$c1 = explode(',',$MOM_Exclude_Categories_TagArchives);$hidePostFormats = $MOM_Exclude_PostFormats_TagArchives;}
	if($query->is_search){$c1 = explode(',',$MOM_Exclude_Categories_SearchResults);$hidePostFormats = $MOM_Exclude_PostFormats_SearchResults;$t1 = explode(',',$MOM_Exclude_Tags_SearchResults);}
	foreach($c1 as &$C1){$C1 = ''.$C1.',';}
	$c_1 = rtrim(implode($c1),',');
	$hideUserCats = explode(',',str_replace(' ','',$c_1));
	foreach($t1 as &$T1){$T1 = ''.$T1.',';}
	$t11 = rtrim(implode($t1),',');
	$hideUserTags = explode(',',str_replace(' ','',$t11));
	$hideAllCategories = array_merge((array)$hideUserCats,(array)$hideLoggedOutCats,(array)$rssday_cat);
	$hideAllTags = array_merge((array)$hideUserTags,(array)$hideLoggedOutTags,(array)$rssday);
	$hideAllCategories = array_filter(array_unique($hideAllCategories));
	$hideAllTags = array_filter(array_unique($hideAllTags));	
	if($query->is_feed || $query->is_home || $query->is_search || $query->tag || $query->is_category){
		$tax_query = array(
			'ignore_sticky_posts' => true,
			'post_type' => 'any',
			array(
				'taxonomy' => 'category',
				'terms' => $hideAllCategories,
				'field' => 'id',
				'operator' => 'NOT IN'
			),
			array(
				'taxonomy' => 'post_tag',
				'terms' => $hideAllTags,
				'field' => 'id',
				'operator' => 'NOT IN'
			),
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array($hidePostFormats),
				'operator' => 'NOT IN'
			)
		);
		$query->set('tax_query',$tax_query);
	}
}
/****************************** SECTION L -/- (L0) Settings -/- Jump Around ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_jump_around_module(){
			echo '<span class="moduletitle">__jump_around<em>keyboard navigation</em></span><div class="clear"></div><div class="settings"><form method="post">';
			echo '
			<div class="countplus">
				<section><label for="jump_around_0">Post container:</label>
				<input type="text" name="jump_around_0" value="'.get_option('jump_around_0').'" /></section>
				<section><label for="jump_around_1">Permalink:</label>
				<input type="text" name="jump_around_1" value="'.get_option('jump_around_1').'" /></section>
				<section><label for="jump_around_2">Previous posts</label>
				<input type="text" name="jump_around_2" value="'.get_option('jump_around_2').'" /></section>
				<section><label for="jump_around_3">Next posts</label>
				<input type="text" name="jump_around_3" value="'.get_option('jump_around_3').'" /></section>
				<section><label for="jump_around_4">Previous key</label>
				<select name="jump_around_4">
					<option value="65"';if(get_option('jump_around_4') == '65'){echo ' selected="selected"';}echo '>a</option>
					<option value="66"';if(get_option('jump_around_4') == '66'){echo ' selected="selected"';}echo '>b</option>
					<option value="67"';if(get_option('jump_around_4') == '67'){echo ' selected="selected"';}echo '>c</option>
					<option value="68"';if(get_option('jump_around_4') == '68'){echo ' selected="selected"';}echo '>d</option>
					<option value="69"';if(get_option('jump_around_4') == '69'){echo ' selected="selected"';}echo '>e</option>
					<option value="70"';if(get_option('jump_around_4') == '70'){echo ' selected="selected"';}echo '>f</option>
					<option value="71"';if(get_option('jump_around_4') == '71'){echo ' selected="selected"';}echo '>g</option>
					<option value="72"';if(get_option('jump_around_4') == '72'){echo ' selected="selected"';}echo '>h</option>
					<option value="73"';if(get_option('jump_around_4') == '73'){echo ' selected="selected"';}echo '>i</option>
					<option value="74"';if(get_option('jump_around_4') == '74'){echo ' selected="selected"';}echo '>j</option>
					<option value="75"';if(get_option('jump_around_4') == '75'){echo ' selected="selected"';}echo '>k</option>
					<option value="76"';if(get_option('jump_around_4') == '76'){echo ' selected="selected"';}echo '>l</option>
					<option value="77"';if(get_option('jump_around_4') == '77'){echo ' selected="selected"';}echo '>m</option>
					<option value="78"';if(get_option('jump_around_4') == '78'){echo ' selected="selected"';}echo '>n</option>
					<option value="79"';if(get_option('jump_around_4') == '79'){echo ' selected="selected"';}echo '>o</option>
					<option value="80"';if(get_option('jump_around_4') == '80'){echo ' selected="selected"';}echo '>p</option>
					<option value="81"';if(get_option('jump_around_4') == '81'){echo ' selected="selected"';}echo '>q</option>
					<option value="82"';if(get_option('jump_around_4') == '82'){echo ' selected="selected"';}echo '>r</option>
					<option value="83"';if(get_option('jump_around_4') == '83'){echo ' selected="selected"';}echo '>s</option>
					<option value="84"';if(get_option('jump_around_4') == '84'){echo ' selected="selected"';}echo '>t</option>
					<option value="85"';if(get_option('jump_around_4') == '85'){echo ' selected="selected"';}echo '>u</option>
					<option value="86"';if(get_option('jump_around_4') == '86'){echo ' selected="selected"';}echo '>v</option>
					<option value="87"';if(get_option('jump_around_4') == '87'){echo ' selected="selected"';}echo '>w</option>
					<option value="88"';if(get_option('jump_around_4') == '88'){echo ' selected="selected"';}echo '>x</option>
					<option value="89"';if(get_option('jump_around_4') == '89'){echo ' selected="selected"';}echo '>y</option>
					<option value="90"';if(get_option('jump_around_4') == '90'){echo ' selected="selected"';}echo '>z</option>
					<option value="48"';if(get_option('jump_around_4') == '48'){echo ' selected="selected"';}echo '>0</option>
					<option value="49"';if(get_option('jump_around_4') == '49'){echo ' selected="selected"';}echo '>1</option>
					<option value="50"';if(get_option('jump_around_4') == '50'){echo ' selected="selected"';}echo '>2</option>
					<option value="51"';if(get_option('jump_around_4') == '51'){echo ' selected="selected"';}echo '>3</option>
					<option value="52"';if(get_option('jump_around_4') == '52'){echo ' selected="selected"';}echo '>4</option>
					<option value="53"';if(get_option('jump_around_4') == '53'){echo ' selected="selected"';}echo '>5</option>
					<option value="54"';if(get_option('jump_around_4') == '54'){echo ' selected="selected"';}echo '>6</option>
					<option value="55"';if(get_option('jump_around_4') == '55'){echo ' selected="selected"';}echo '>7</option>
					<option value="56"';if(get_option('jump_around_4') == '56'){echo ' selected="selected"';}echo '>8</option>
					<option value="57"';if(get_option('jump_around_4') == '57'){echo ' selected="selected"';}echo '>9</option>
					<option value="37"';if(get_option('jump_around_4') == '37'){echo ' selected="selected"';}echo '>left arrow</option>
					<option value="38"';if(get_option('jump_around_4') == '38'){echo ' selected="selected"';}echo '>up arrow</option>
					<option value="39"';if(get_option('jump_around_4') == '39'){echo ' selected="selected"';}echo '>right arrow</option>
					<option value="40"';if(get_option('jump_around_4') == '40'){echo ' selected="selected"';}echo '>down arrow</option>
				</select></section>
				<section><label for="jump_around_5">Open currently selected key</label>
				<select name="jump_around_5">
					<option value="65"';if(get_option('jump_around_5') == '65'){echo ' selected="selected"';}echo '>a</option>
					<option value="66"';if(get_option('jump_around_5') == '66'){echo ' selected="selected"';}echo '>b</option>
					<option value="67"';if(get_option('jump_around_5') == '67'){echo ' selected="selected"';}echo '>c</option>
					<option value="68"';if(get_option('jump_around_5') == '68'){echo ' selected="selected"';}echo '>d</option>
					<option value="69"';if(get_option('jump_around_5') == '69'){echo ' selected="selected"';}echo '>e</option>
					<option value="70"';if(get_option('jump_around_5') == '70'){echo ' selected="selected"';}echo '>f</option>
					<option value="71"';if(get_option('jump_around_5') == '71'){echo ' selected="selected"';}echo '>g</option>
					<option value="72"';if(get_option('jump_around_5') == '72'){echo ' selected="selected"';}echo '>h</option>
					<option value="73"';if(get_option('jump_around_5') == '73'){echo ' selected="selected"';}echo '>i</option>
					<option value="74"';if(get_option('jump_around_5') == '74'){echo ' selected="selected"';}echo '>j</option>
					<option value="75"';if(get_option('jump_around_5') == '75'){echo ' selected="selected"';}echo '>k</option>
					<option value="76"';if(get_option('jump_around_5') == '76'){echo ' selected="selected"';}echo '>l</option>
					<option value="77"';if(get_option('jump_around_5') == '77'){echo ' selected="selected"';}echo '>m</option>
					<option value="78"';if(get_option('jump_around_5') == '78'){echo ' selected="selected"';}echo '>n</option>
					<option value="79"';if(get_option('jump_around_5') == '79'){echo ' selected="selected"';}echo '>o</option>
					<option value="80"';if(get_option('jump_around_5') == '80'){echo ' selected="selected"';}echo '>p</option>
					<option value="81"';if(get_option('jump_around_5') == '81'){echo ' selected="selected"';}echo '>q</option>
					<option value="82"';if(get_option('jump_around_5') == '82'){echo ' selected="selected"';}echo '>r</option>
					<option value="83"';if(get_option('jump_around_5') == '83'){echo ' selected="selected"';}echo '>s</option>
					<option value="84"';if(get_option('jump_around_5') == '84'){echo ' selected="selected"';}echo '>t</option>
					<option value="85"';if(get_option('jump_around_5') == '85'){echo ' selected="selected"';}echo '>u</option>
					<option value="86"';if(get_option('jump_around_5') == '86'){echo ' selected="selected"';}echo '>v</option>
					<option value="87"';if(get_option('jump_around_5') == '87'){echo ' selected="selected"';}echo '>w</option>
					<option value="88"';if(get_option('jump_around_5') == '88'){echo ' selected="selected"';}echo '>x</option>
					<option value="89"';if(get_option('jump_around_5') == '89'){echo ' selected="selected"';}echo '>y</option>
					<option value="90"';if(get_option('jump_around_5') == '90'){echo ' selected="selected"';}echo '>z</option>
					<option value="48"';if(get_option('jump_around_5') == '48'){echo ' selected="selected"';}echo '>0</option>
					<option value="49"';if(get_option('jump_around_5') == '49'){echo ' selected="selected"';}echo '>1</option>
					<option value="50"';if(get_option('jump_around_5') == '50'){echo ' selected="selected"';}echo '>2</option>
					<option value="51"';if(get_option('jump_around_5') == '51'){echo ' selected="selected"';}echo '>3</option>
					<option value="52"';if(get_option('jump_around_5') == '52'){echo ' selected="selected"';}echo '>4</option>
					<option value="53"';if(get_option('jump_around_5') == '53'){echo ' selected="selected"';}echo '>5</option>
					<option value="54"';if(get_option('jump_around_5') == '54'){echo ' selected="selected"';}echo '>6</option>
					<option value="55"';if(get_option('jump_around_5') == '55'){echo ' selected="selected"';}echo '>7</option>
					<option value="56"';if(get_option('jump_around_5') == '56'){echo ' selected="selected"';}echo '>8</option>
					<option value="57"';if(get_option('jump_around_5') == '57'){echo ' selected="selected"';}echo '>9</option>
					<option value="37"';if(get_option('jump_around_5') == '37'){echo ' selected="selected"';}echo '>left arrow</option>
					<option value="38"';if(get_option('jump_around_5') == '38'){echo ' selected="selected"';}echo '>up arrow</option>
					<option value="39"';if(get_option('jump_around_5') == '39'){echo ' selected="selected"';}echo '>right arrow</option>
					<option value="40"';if(get_option('jump_around_5') == '40'){echo ' selected="selected"';}echo '>down arrow</option>
				</select></section>
				<section><label for="jump_around_6">Next key</label>
				<select name="jump_around_6">
					<option value="65"';if(get_option('jump_around_6') == '65'){echo ' selected="selected"';}echo '>a</option>
					<option value="66"';if(get_option('jump_around_6') == '66'){echo ' selected="selected"';}echo '>b</option>
					<option value="67"';if(get_option('jump_around_6') == '67'){echo ' selected="selected"';}echo '>c</option>
					<option value="68"';if(get_option('jump_around_6') == '68'){echo ' selected="selected"';}echo '>d</option>
					<option value="69"';if(get_option('jump_around_6') == '69'){echo ' selected="selected"';}echo '>e</option>
					<option value="70"';if(get_option('jump_around_6') == '70'){echo ' selected="selected"';}echo '>f</option>
					<option value="71"';if(get_option('jump_around_6') == '71'){echo ' selected="selected"';}echo '>g</option>
					<option value="72"';if(get_option('jump_around_6') == '72'){echo ' selected="selected"';}echo '>h</option>
					<option value="73"';if(get_option('jump_around_6') == '73'){echo ' selected="selected"';}echo '>i</option>
					<option value="74"';if(get_option('jump_around_6') == '74'){echo ' selected="selected"';}echo '>j</option>
					<option value="75"';if(get_option('jump_around_6') == '75'){echo ' selected="selected"';}echo '>k</option>
					<option value="76"';if(get_option('jump_around_6') == '76'){echo ' selected="selected"';}echo '>l</option>
					<option value="77"';if(get_option('jump_around_6') == '77'){echo ' selected="selected"';}echo '>m</option>
					<option value="78"';if(get_option('jump_around_6') == '78'){echo ' selected="selected"';}echo '>n</option>
					<option value="79"';if(get_option('jump_around_6') == '79'){echo ' selected="selected"';}echo '>o</option>
					<option value="80"';if(get_option('jump_around_6') == '80'){echo ' selected="selected"';}echo '>p</option>
					<option value="81"';if(get_option('jump_around_6') == '81'){echo ' selected="selected"';}echo '>q</option>
					<option value="82"';if(get_option('jump_around_6') == '82'){echo ' selected="selected"';}echo '>r</option>
					<option value="83"';if(get_option('jump_around_6') == '83'){echo ' selected="selected"';}echo '>s</option>
					<option value="84"';if(get_option('jump_around_6') == '84'){echo ' selected="selected"';}echo '>t</option>
					<option value="85"';if(get_option('jump_around_6') == '85'){echo ' selected="selected"';}echo '>u</option>
					<option value="86"';if(get_option('jump_around_6') == '86'){echo ' selected="selected"';}echo '>v</option>
					<option value="87"';if(get_option('jump_around_6') == '87'){echo ' selected="selected"';}echo '>w</option>
					<option value="88"';if(get_option('jump_around_6') == '88'){echo ' selected="selected"';}echo '>x</option>
					<option value="89"';if(get_option('jump_around_6') == '89'){echo ' selected="selected"';}echo '>y</option>
					<option value="90"';if(get_option('jump_around_6') == '90'){echo ' selected="selected"';}echo '>z</option>
					<option value="48"';if(get_option('jump_around_6') == '48'){echo ' selected="selected"';}echo '>0</option>
					<option value="49"';if(get_option('jump_around_6') == '49'){echo ' selected="selected"';}echo '>1</option>
					<option value="50"';if(get_option('jump_around_6') == '50'){echo ' selected="selected"';}echo '>2</option>
					<option value="51"';if(get_option('jump_around_6') == '51'){echo ' selected="selected"';}echo '>3</option>
					<option value="52"';if(get_option('jump_around_6') == '52'){echo ' selected="selected"';}echo '>4</option>
					<option value="53"';if(get_option('jump_around_6') == '53'){echo ' selected="selected"';}echo '>5</option>
					<option value="54"';if(get_option('jump_around_6') == '54'){echo ' selected="selected"';}echo '>6</option>
					<option value="55"';if(get_option('jump_around_6') == '55'){echo ' selected="selected"';}echo '>7</option>
					<option value="56"';if(get_option('jump_around_6') == '56'){echo ' selected="selected"';}echo '>8</option>
					<option value="57"';if(get_option('jump_around_6') == '57'){echo ' selected="selected"';}echo '>9</option>
					<option value="37"';if(get_option('jump_around_6') == '37'){echo ' selected="selected"';}echo '>left arrow</option>
					<option value="38"';if(get_option('jump_around_6') == '38'){echo ' selected="selected"';}echo '>up arrow</option>
					<option value="39"';if(get_option('jump_around_6') == '39'){echo ' selected="selected"';}echo '>right arrow</option>
					<option value="40"';if(get_option('jump_around_6') == '40'){echo ' selected="selected"';}echo '>down arrow</option>
				</select></section>
				<section><label for="jump_around_7">Older posts key</label>
				<select name="jump_around_7">
					<option value="65"';if(get_option('jump_around_7') == '65'){echo ' selected="selected"';}echo '>a</option>
					<option value="66"';if(get_option('jump_around_7') == '66'){echo ' selected="selected"';}echo '>b</option>
					<option value="67"';if(get_option('jump_around_7') == '67'){echo ' selected="selected"';}echo '>c</option>
					<option value="68"';if(get_option('jump_around_7') == '68'){echo ' selected="selected"';}echo '>d</option>
					<option value="69"';if(get_option('jump_around_7') == '69'){echo ' selected="selected"';}echo '>e</option>
					<option value="70"';if(get_option('jump_around_7') == '70'){echo ' selected="selected"';}echo '>f</option>
					<option value="71"';if(get_option('jump_around_7') == '71'){echo ' selected="selected"';}echo '>g</option>
					<option value="72"';if(get_option('jump_around_7') == '72'){echo ' selected="selected"';}echo '>h</option>
					<option value="73"';if(get_option('jump_around_7') == '73'){echo ' selected="selected"';}echo '>i</option>
					<option value="74"';if(get_option('jump_around_7') == '74'){echo ' selected="selected"';}echo '>j</option>
					<option value="75"';if(get_option('jump_around_7') == '75'){echo ' selected="selected"';}echo '>k</option>
					<option value="76"';if(get_option('jump_around_7') == '76'){echo ' selected="selected"';}echo '>l</option>
					<option value="77"';if(get_option('jump_around_7') == '77'){echo ' selected="selected"';}echo '>m</option>
					<option value="78"';if(get_option('jump_around_7') == '78'){echo ' selected="selected"';}echo '>n</option>
					<option value="79"';if(get_option('jump_around_7') == '79'){echo ' selected="selected"';}echo '>o</option>
					<option value="80"';if(get_option('jump_around_7') == '80'){echo ' selected="selected"';}echo '>p</option>
					<option value="81"';if(get_option('jump_around_7') == '81'){echo ' selected="selected"';}echo '>q</option>
					<option value="82"';if(get_option('jump_around_7') == '82'){echo ' selected="selected"';}echo '>r</option>
					<option value="83"';if(get_option('jump_around_7') == '83'){echo ' selected="selected"';}echo '>s</option>
					<option value="84"';if(get_option('jump_around_7') == '84'){echo ' selected="selected"';}echo '>t</option>
					<option value="85"';if(get_option('jump_around_7') == '85'){echo ' selected="selected"';}echo '>u</option>
					<option value="86"';if(get_option('jump_around_7') == '86'){echo ' selected="selected"';}echo '>v</option>
					<option value="87"';if(get_option('jump_around_7') == '87'){echo ' selected="selected"';}echo '>w</option>
					<option value="88"';if(get_option('jump_around_7') == '88'){echo ' selected="selected"';}echo '>x</option>
					<option value="89"';if(get_option('jump_around_7') == '89'){echo ' selected="selected"';}echo '>y</option>
					<option value="90"';if(get_option('jump_around_7') == '90'){echo ' selected="selected"';}echo '>z</option>
					<option value="48"';if(get_option('jump_around_7') == '48'){echo ' selected="selected"';}echo '>0</option>
					<option value="49"';if(get_option('jump_around_7') == '49'){echo ' selected="selected"';}echo '>1</option>
					<option value="50"';if(get_option('jump_around_7') == '50'){echo ' selected="selected"';}echo '>2</option>
					<option value="51"';if(get_option('jump_around_7') == '51'){echo ' selected="selected"';}echo '>3</option>
					<option value="52"';if(get_option('jump_around_7') == '52'){echo ' selected="selected"';}echo '>4</option>
					<option value="53"';if(get_option('jump_around_7') == '53'){echo ' selected="selected"';}echo '>5</option>
					<option value="54"';if(get_option('jump_around_7') == '54'){echo ' selected="selected"';}echo '>6</option>
					<option value="55"';if(get_option('jump_around_7') == '55'){echo ' selected="selected"';}echo '>7</option>
					<option value="56"';if(get_option('jump_around_7') == '56'){echo ' selected="selected"';}echo '>8</option>
					<option value="57"';if(get_option('jump_around_7') == '57'){echo ' selected="selected"';}echo '>9</option>
					<option value="37"';if(get_option('jump_around_7') == '37'){echo ' selected="selected"';}echo '>left arrow</option>
					<option value="38"';if(get_option('jump_around_7') == '38'){echo ' selected="selected"';}echo '>up arrow</option>
					<option value="39"';if(get_option('jump_around_7') == '39'){echo ' selected="selected"';}echo '>right arrow</option>
					<option value="40"';if(get_option('jump_around_7') == '40'){echo ' selected="selected"';}echo '>down arrow</option>
				</select></section>
				<section><label for="jump_around_8">Newer posts key</label>
				<select name="jump_around_8">
					<option value="65"';if(get_option('jump_around_8') == '65'){echo ' selected="selected"';}echo '>a</option>
					<option value="66"';if(get_option('jump_around_8') == '66'){echo ' selected="selected"';}echo '>b</option>
					<option value="67"';if(get_option('jump_around_8') == '67'){echo ' selected="selected"';}echo '>c</option>
					<option value="68"';if(get_option('jump_around_8') == '68'){echo ' selected="selected"';}echo '>d</option>
					<option value="69"';if(get_option('jump_around_8') == '69'){echo ' selected="selected"';}echo '>e</option>
					<option value="70"';if(get_option('jump_around_8') == '70'){echo ' selected="selected"';}echo '>f</option>
					<option value="71"';if(get_option('jump_around_8') == '71'){echo ' selected="selected"';}echo '>g</option>
					<option value="72"';if(get_option('jump_around_8') == '72'){echo ' selected="selected"';}echo '>h</option>
					<option value="73"';if(get_option('jump_around_8') == '73'){echo ' selected="selected"';}echo '>i</option>
					<option value="74"';if(get_option('jump_around_8') == '74'){echo ' selected="selected"';}echo '>j</option>
					<option value="75"';if(get_option('jump_around_8') == '75'){echo ' selected="selected"';}echo '>k</option>
					<option value="76"';if(get_option('jump_around_8') == '76'){echo ' selected="selected"';}echo '>l</option>
					<option value="77"';if(get_option('jump_around_8') == '77'){echo ' selected="selected"';}echo '>m</option>
					<option value="78"';if(get_option('jump_around_8') == '78'){echo ' selected="selected"';}echo '>n</option>
					<option value="79"';if(get_option('jump_around_8') == '79'){echo ' selected="selected"';}echo '>o</option>
					<option value="80"';if(get_option('jump_around_8') == '80'){echo ' selected="selected"';}echo '>p</option>
					<option value="81"';if(get_option('jump_around_8') == '81'){echo ' selected="selected"';}echo '>q</option>
					<option value="82"';if(get_option('jump_around_8') == '82'){echo ' selected="selected"';}echo '>r</option>
					<option value="83"';if(get_option('jump_around_8') == '83'){echo ' selected="selected"';}echo '>s</option>
					<option value="84"';if(get_option('jump_around_8') == '84'){echo ' selected="selected"';}echo '>t</option>
					<option value="85"';if(get_option('jump_around_8') == '85'){echo ' selected="selected"';}echo '>u</option>
					<option value="86"';if(get_option('jump_around_8') == '86'){echo ' selected="selected"';}echo '>v</option>
					<option value="87"';if(get_option('jump_around_8') == '87'){echo ' selected="selected"';}echo '>w</option>
					<option value="88"';if(get_option('jump_around_8') == '88'){echo ' selected="selected"';}echo '>x</option>
					<option value="89"';if(get_option('jump_around_8') == '89'){echo ' selected="selected"';}echo '>y</option>
					<option value="90"';if(get_option('jump_around_8') == '90'){echo ' selected="selected"';}echo '>z</option>
					<option value="48"';if(get_option('jump_around_8') == '48'){echo ' selected="selected"';}echo '>0</option>
					<option value="49"';if(get_option('jump_around_8') == '49'){echo ' selected="selected"';}echo '>1</option>
					<option value="50"';if(get_option('jump_around_8') == '50'){echo ' selected="selected"';}echo '>2</option>
					<option value="51"';if(get_option('jump_around_8') == '51'){echo ' selected="selected"';}echo '>3</option>
					<option value="52"';if(get_option('jump_around_8') == '52'){echo ' selected="selected"';}echo '>4</option>
					<option value="53"';if(get_option('jump_around_8') == '53'){echo ' selected="selected"';}echo '>5</option>
					<option value="54"';if(get_option('jump_around_8') == '54'){echo ' selected="selected"';}echo '>6</option>
					<option value="55"';if(get_option('jump_around_8') == '55'){echo ' selected="selected"';}echo '>7</option>
					<option value="56"';if(get_option('jump_around_8') == '56'){echo ' selected="selected"';}echo '>8</option>
					<option value="57"';if(get_option('jump_around_8') == '57'){echo ' selected="selected"';}echo '>9</option>
					<option value="37"';if(get_option('jump_around_8') == '37'){echo ' selected="selected"';}echo '>left arrow</option>
					<option value="38"';if(get_option('jump_around_8') == '38'){echo ' selected="selected"';}echo '>up arrow</option>
					<option value="39"';if(get_option('jump_around_8') == '39'){echo ' selected="selected"';}echo '>right arrow</option>
					<option value="40"';if(get_option('jump_around_8') == '40'){echo ' selected="selected"';}echo '>down arrow</option>
				</select></section>
			</div>
			<input id="update_JA" type="submit" value="Save Changes" name="update_JA">';
			echo '</form></div><div class="templatetags"><section>Filter for classes<span class="right">.div</span></section><section>Filter for links in classes<span class="right">.div a</span></section><section>Filter for elements in classes<span class="right">.div h1</span></section><section>Filter for linked elements in classes<span class="right">.div h1 a</span></section><div class="new"><p class="creditlink"><em>Thanks to <a href="http://stackoverflow.com/questions/1939041/change-hash-without-reload-in-jquery">jitter</a> &amp; <a href="http://stackoverflow.com/questions/13694277/scroll-to-next-div-using-arrow-keys">mVChr</a> for the help.</em></p></div></div>';
		}
}
/****************************** SECTION X -/- (X0) Functions -/- Database Cleaner ******************************/
if(current_user_can('manage_options')){
	function my_optional_modules_cleaner_module(){
		global $table_prefix,$wpdb;
		$revisions_count = 0;
		$comments_count = 0;
		$terms_count = 0;
		$postsTable = $table_prefix.'posts';
		$commentsTable = $table_prefix.'comments';
		$termsTable2 = $table_prefix.'terms';
		$termsTable = $table_prefix.'term_taxonomy';
		$revisions_total = $wpdb->get_results("SELECT ID FROM `".$postsTable."` WHERE `post_type` = 'revision' OR `post_type` = 'auto_draft' OR `post_status` = 'trash'");
		$comments_total = $wpdb->get_results("SELECT comment_ID FROM `".$commentsTable."` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
		$terms_total = $wpdb->get_results("SELECT term_taxonomy_id FROM `".$termsTable."` WHERE `count` = '0'");
		foreach($revisions_total as $retot){$revisions_count++;}
		foreach($comments_total as $comtot){$comments_count++;}
		foreach($terms_total as $termstot){$this_term = $termstot->term_id;$terms_count++;}
		$totalClutter = ($terms_count + $comments_count + $revisions_count);
		echo '<section class="trash"><label for="deleteAllClutter"><i class="fa fa-trash-o"></i><span>All clutter</span><em>'.esc_attr($totalClutter).'</em></label><form method="post"><input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter"></form></section>';
		echo '<section class="trash"><label for="delete_post_revisions"><i class="fa fa-trash-o"></i><span>Post clutter</span><em>'.esc_attr($revisions_count).'</em></label><form method="post"><input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions"></form></section>';
		echo '<section class="trash"><label for="delete_unapproved_comments"><i class="fa fa-trash-o"></i><span>Comment clutter</span><em>'.esc_attr($comments_count).'</em></label><form method="post"><input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments"></form></section>';
		echo '<section class="trash"><label for="delete_unused_terms"><i class="fa fa-trash-o"></i><span>Taxonomy clutter</span><em>'.esc_attr($terms_count).'</em></label><form method="post"><input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms"></form></section>';
	}
}
/****************************** SECTION M -/- (M0) Functions -/- Post Voting *****************************************/
function vote_the_posts_top($atts,$content = null){
	extract(
		shortcode_atts(array(
			'amount' => 10
		), $atts)
	);	
	$amount = intval($amount);
	global $wpdb,$wp,$post;
	ob_start();
	wp_reset_query();
	$votesPosts = $wpdb->prefix.'momvotes_posts';
	$query_sql = "SELECT ID,UP,DOWN from $votesPosts ORDER BY UP DESC LIMIT $amount";
	$query_result = $wpdb->get_col( $wpdb->prepare ($query_sql, OBJECT));
	if ($query_result) {
	echo '<div class="topVotes">';
	foreach ($query_result as $post_id) {
		$post = &get_post( $post_id );
		setup_postdata($post);
		echo '<div class="votedPost">';
		echo '<a href="';the_permalink();echo'" rel="bookmark" title="Permanent Link to ';the_title_attribute();echo'">';the_title();echo'</a>';
		vote_the_post();
		echo '</div>';
	}}else{}	
	echo '</div>';
	wp_reset_query();
	return ob_get_clean();
}
if(get_option('mommaincontrol_votes') == 1)add_shortcode('topvoted','vote_the_posts_top');
if(get_option('mommaincontrol_votes') == 1)add_filter('the_content','do_shortcode','vote_the_posts_top');
if(get_option('mommaincontrol_votes') == 1){	
	function vote_the_post(){
		global $wpdb,$wp,$post;
		$votesPosts = $wpdb->prefix.'momvotes_posts';
		$votesVotes = $wpdb->prefix.'momvotes_votes';
		if(isset($_SERVER["REMOTE_ADDR"])){
			$ip_address = esc_attr($_SERVER["REMOTE_ADDR"]);
		} else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip_address = esc_attr($_SERVER["HTTP_X_FORWARDED_FOR"]);
		} else if(isset($_SERVER["HTTP_CLIENT_IP"])){
			$ip_address = esc_attr($_SERVER["HTTP_CLIENT_IP"]);
		}
		$theIP = esc_attr($ip_address);
		$theIP_s32int = esc_attr(ip2long($ip_address));
		$theIP_us32str = esc_attr(sprintf("%u",$theIP_s32int));
		$theID = intval($post->ID);
		$getID = $wpdb->get_results("SELECT ID,UP,DOWN FROM $votesPosts WHERE ID = '".$theID."' LIMIT 1");
		if(count($getID) == 0){
			$wpdb->query("INSERT INTO $votesPosts (ID, UP, DOWN) VALUES ($theID,1,0)");
		}
		foreach($getID as $gotID){
			$votesUP = intval($gotID->UP);
			$votesDOWN = intval($gotID->DOWN);
			$votesTOTAL = intval($votesUP + $votesDOWN);
			if($votesUP > $votesDOWN){$votesTOTAL = $votesUP - $votesDOWN;}
			elseif($votesUP < $votesDOWN){$votesTOTAL = $votesDOWN - $votesUP;}
			elseif($votesUP == $votesDOWN){$votesTOTAL = $votesUP - $votesDOWN;}
			elseif($votesDOWN > $votesUP){$votesTOTAL = $votesDOWN - $votesUP;}
			if($votesTOTAL <= 0){$votesTOTAL = 0;}
			$getIP = $wpdb->get_results("SELECT ID,IP,VOTE FROM $votesVotes WHERE ID = '".$theID."' AND IP = '".$theIP_us32str."' LIMIT 1");
			if(count($getIP) == 0) {
				if(isset($_POST[$theID.'-up-submit'])){
					$wpdb->query("UPDATE $votesPosts SET UP = UP + 1 WHERE ID = $theID");
					$wpdb->query("INSERT INTO $votesVotes (ID, IP, VOTE) VALUES ($theID,$theIP_us32str,1)");
				}
				if(isset($_POST[$theID.'-down-submit'])){
					$wpdb->query("UPDATE $votesPosts SET DOWN = DOWN + 1 WHERE ID = $theID");
					$wpdb->query("INSERT INTO $votesVotes (ID, IP, VOTE) VALUES ($theID,$theIP_us32str,0)");
				}			
				echo '<span class="vote_the_post" id="'.esc_attr($theID).'">';
				echo '<form action="" id="'.esc_attr($theID).'-up" method="post"><label for="'.esc_attr($theID).'-up-submit" class="upvote"><i class="fa fa-arrow-up"></i></label><input type="submit" name="'.esc_attr($theID).'-up-submit" id="'.esc_attr($theID).'-up-submit" /></form>';
				echo '<form action="" id="'.esc_attr($theID).'-down" method="post"><label for="'.esc_attr($theID).'-down-submit" class="downvote"><i class="fa fa-arrow-down"></i></label><input type="submit" name="'.esc_attr($theID).'-down-submit" id="'.esc_attr($theID).'-down-submit" /></form>';
				echo '<span>'.esc_attr($votesTOTAL).'</span>';
				echo '</span>';
			}else{
				foreach($getIP as $gotIP){
					$vote = esc_attr($gotIP->VOTE);
					if($vote == 1 && isset($_POST[$theID.'-up-submit'])){
						$wpdb->query("UPDATE $votesPosts SET UP = UP - 1 WHERE ID = $theID");
						$wpdb->query("DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = '$theID'");
					}
					if($vote == 0 && isset($_POST[$theID.'-down-submit'])){
						$wpdb->query("UPDATE $votesPosts SET DOWN = DOWN - 1 WHERE ID = $theID");
						$wpdb->query("DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = '$theID'");
					}
					echo '<span class="vote_the_post" id="'.esc_attr($theID).'">';
					echo '<form id="'.esc_attr($theID).'-up" method="post"><label for="'.esc_attr($theID).'-up-submit" class="upvote"><i class="fa fa-arrow-up ';if($vote == 1){ echo 'active';} echo '"></i></label><input type="submit" name="'.esc_attr($theID).'-up-submit" id="'.esc_attr($theID).'-up-submit" /></form>';
					echo '<form id="'.esc_attr($theID).'-down" method="post"><label for="'.esc_attr($theID).'-down-submit" class="downvote"><i class="fa fa-arrow-down '; if($vote == 0){ echo 'active';} echo '"></i></label><input type="submit" name="'.esc_attr($theID).'-down-submit" id="'.esc_attr($theID).'-down-submit" /></form>';
					echo '<span>'.esc_attr($votesTOTAL).'</span>';
					echo '</span>';
				}
			}			
		}		
	}
}
/****************************** SECTION N -/- (N0) Functions -/- Regular Board****************************************/
function regularboard_shortcode($atts,$content = null){
	extract(
		shortcode_atts(array(
			'timebetween' => '0',
			'cutoff' => '500',
			'maxbody' => '1800',
			'maxtext' => '75',
			'nothreads' => 'No threads to display',
			'noboard' => 'Board does not exist',
			'bannedmessage' => 'YOU ARE BANNED',
			'postedmessage' => 'POSTED!!!',
			'modcode' => '##MOD',
			'posting' => '1',
			'threadsper' => '15',
			'enableurl' => '1',
			'enablerep' => '0',
			'defaultname' => 'anonymous',
			'requirelogged' => '0',
			'credits' => 'All trademarks and copyrights on this page are owned by their respective parties.  Comments are owned by (and the responsibility of) the Poster.'
		), $atts)
	);	
	global $purifier;
	if(current_user_can('manage_options'))$ISMODERATOR = true;
	if(!current_user_can('manage_options'))$ISMODERATOR = false;
	$credits = $purifier->purify($credits);
	$nothreads = $purifier->purify($nothreads);
	$noboard = $purifier->purify($noboard);
	$defaultname = $purifier->purify($defaultname);
	$bannedmessage = $purifier->purify($bannedmessage);
	$postedmessage = $purifier->purify($postedmessage);
	$modcode = $purifier->purify($modcode);
	echo '<div class="boardDisplay">';
	global $wpdb,$wp,$post;
	$current_timestamp = date('Y-m-d H:i:s');
	$regularboard_boards = $wpdb->prefix.'regularboard_boards';
	$regularboard_posts = $wpdb->prefix.'regularboard_posts';
	$regularboard_users = $wpdb->prefix.'regularboard_users';
	if(isset($_SERVER["REMOTE_ADDR"])){
		$ip_address = sanistripents($_SERVER["REMOTE_ADDR"]);
	} else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ip_address = sanistripents($_SERVER["HTTP_X_FORWARDED_FOR"]);
	} else if(isset($_SERVER["HTTP_CLIENT_IP"])){
		$ip_address = sanistripents($_SERVER["HTTP_CLIENT_IP"]);
	}
	$theIP = sanistripents($ip_address);
	$theIP_s32int = sanistripents(ip2long($ip_address));
	$theIP_us32str = sanistripents(sprintf("%u",$theIP_s32int));
	$checkThisIP = long2ip($theIP);
	checkdnsbl($checkThisIP);
	$QUERY = sanistripents($_SERVER['QUERY_STRING']);
	$BOARD = sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']));
	$AREA = sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['area']));
	$THREAD = intval($_GET['thread']);
	$BOARD = strtolower($BOARD);
	$AREA = strtolower($AREA);
	if($AREA == 'create'){
		if($ISMODERATOR === true){
			$getUsers = $wpdb->get_results("SELECT ID,IP,PARENT,BANNED,MESSAGE FROM $regularboard_users WHERE BANNED = 1");
			echo '<div class="banned"><h3 class="options">CREATE/DELETE/UNBAN</h3>';
			$checkTable = $wpdb->get_results("SHOW COLUMNS FROM `$regularboard_posts` LIKE 'URL'");
			$checkTable = $wpdb->get_results("SHOW COLUMNS FROM `$regularboard_posts` LIKE 'TYPE'");
			if(count($checkTable) > 0){}else{
				echo '
				<hr />
				<form method="post" class="left">
				<input type="submit" name="UPGRADE" id="UPGRADE" value="An upgrade is necessary." />
				</form>
				<hr />
				';
				if(isset($_POST['UPGRADE'])){
					$wpdb->query("ALTER TABLE $regularboard_posts ADD URL TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER COMMENT");
					$wpdb->query("ALTER TABLE $regularboard_posts ADD TYPE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER URL");
				}
			}			
			echo '<form method="post" name="OPTIONSFORM" action="?area=create">';
			wp_nonce_field('OPTIONSFORM');
			echo '<input type="text" name="SHORTNAME" id="SHORTNAME" placeholder="Shortname" />
			<input type="text" name="NAME" id="NAME" placeholder="Expanded board name" />
			<input type="text" name="DESCRIPTION" id="DESCRIPTION" placeholder="Short description" />
			<textarea name="RULES" id="RULES" placeholder="Rules for this board (HTML allowed)"></textarea>
			<input type="submit" name="CREATEBOARD" id="CREATEBOARD" value="Create this board" />
			<input type="text" name="DELETETHIS" id="DELETETHIS" placeholder="Shortname of board to delete" />
			<input type="submit" name="DELETEBOARD" id="DELETEBOARD" value="Delete this board" />';
			foreach($getUsers as $gotUsers){
			$userIP = long2ip($gotUsers->IP);
			$userMESSAGE = $gotUsers->MESSAGE;
			echo '<span>'.$userIP.' / '.$userMESSAGE.'</span>';
			echo '<input type="submit" name="UNBAN'.$userIP.'" id="UNBAN'.$userIP.'" value="Unban '.$userIP.'" />';
			if(isset($_POST['UNBAN'.$userIP.''])){
				$wpdb->query("DELETE FROM $regularboard_users WHERE IP = '".$userIP."'");
			}
			}
			echo '</form></div>';
			if(isset($_POST['DELETEBOARD']) && $_REQUEST['DELETETHIS'] != '' ){
			$DELETETHIS = sanistripents($_REQUEST['DELETETHIS']);
				$getBoards = $wpdb->get_results("SELECT SHORTNAME FROM $regularboard_boards WHERE SHORTNAME = '$DELETETHIS'");
				if(count($getBoards) == 0){
					echo '<h3 class="options">'.$DELETETHIS.' DOESN\'T EXIST</h3>';
				}else{
				$wpdb->query("DELETE FROM $regularboard_posts WHERE BOARD = '".$DELETETHIS."'");
				$wpdb->query("DELETE FROM $regularboard_boards WHERE SHORTNAME = '".$DELETETHIS."'");
				echo '<h3 class="options">'.$DELETETHIS.' DELETED</h3>';
			}
			}
			if(isset($_POST['CREATEBOARD']) && $_REQUEST['NAME'] != '' && $_REQUEST['SHORTNAME'] != ''){
			$NAME = sanistripents($_REQUEST['NAME']);
			$SHORTNAME = sanistripents($_REQUEST['SHORTNAME']);
			$DESCRIPTION = $purifier->purify($_REQUEST['DESCRIPTION']);
			$RULES = $purifier->purify(wpautop($_REQUEST['RULES']));
			$getBoards = $wpdb->get_results("SELECT SHORTNAME FROM $regularboard_boards WHERE SHORTNAME = '$SHORTNAME'");
			if(count($getBoards) == 0){
				$wpdb->query("INSERT INTO $regularboard_boards (NAME, SHORTNAME, DESCRIPTION, RULES) VALUES ('$NAME','$SHORTNAME','$DESCRIPTION','$RULES')") ;
				echo '<h3 class="options">'.$SHORTNAME.' CREATED</h3>';
			}else{
				echo '<h3 class="options">'.$SHORTNAME.' EXISTS</h3>';
			}
			}
			echo '</div>';
		}else{
			echo '<div class="banned"><h3 class="banned">NOT LOGGED IN.</h3></div></div>';
		}
	}
	elseif($BOARD != ''){
		
		// Get Results
		$getBoards = $wpdb->get_results("SELECT SHORTNAME FROM $regularboard_boards ORDER BY SHORTNAME ASC");
		$getCurrentBoard = $wpdb->get_results("SELECT ID,NAME,SHORTNAME,DESCRIPTION,RULES FROM $regularboard_boards WHERE SHORTNAME = '".$BOARD."' LIMIT 1");
		$getUser = $wpdb->get_results("SELECT ID,IP,PARENT,BANNED,MESSAGE FROM $regularboard_users WHERE IP = '".$theIP_us32str."' AND BANNED = 1 LIMIT 1");
		if($THREAD == '')$postsperpage = intval($threadsper);
		if($THREAD == '')$targetpage = '?board='.$BOARD;
		if($THREAD == '')$countpages = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0");
		if($THREAD == '')$totalpages = count($countpages);
		if($THREAD == '')$results = mysql_escape_string($_GET['results']);
		if($THREAD == '')if($results){$start = ($results - 1) * $postsperpage;}else{$start = 0;}
		if($THREAD == '')$getParentPosts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND PARENT = 0 ORDER BY LAST DESC LIMIT $start,$postsperpage");
		if($THREAD != '')$getParentPosts = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE BOARD = '".$BOARD."' AND ID = '".$THREAD."' AND PARENT = 0 LIMIT 1");
		$getLastPost = $wpdb->get_results("SELECT IP,DATE,ID,MODERATOR FROM $regularboard_posts WHERE IP = '".$theIP_us32str."' ORDER BY ID DESC LIMIT 1");
		$getLastPosts = $wpdb->get_results("SELECT ID,PARENT,BOARD,COMMENT,SUBJECT,TYPE,URL,DATE FROM $regularboard_posts WHERE IP = '".$theIP_us32str."' ORDER BY ID DESC LIMIT 5");
		echo '
		<div class="left mycontrols">
			<i class="fa fa-plus-square"></i> User Menu';
			if(count($getLastPosts) >0){
				foreach($getLastPosts as $MYLASTPOSTS){
					$myID = $MYLASTPOSTS->ID;
					$myPARENT = $MYLASTPOSTS->PARENT;
					$myBOARD = $MYLASTPOSTS->BOARD;
					$myCOMMENT = $MYLASTPOSTS->COMMENT;
					$mySUBJECT = $MYLASTPOSTS->SUBJECT;
					$myTYPE = $MYLASTPOSTS->TYPE;
					$myURL = $MYLASTPOSTS->URL;
					$myDATE = $MYLASTPOSTS->DATE;
					echo '<div>';
					if($myPARENT == 0)echo '<a href="?board='.$myBOARD.'&amp;thread='.$myID.'"><i class="fa fa-pencil"></i> '.$myID.'</a>';
					if($myPARENT != 0)echo '<a href="?board='.$myBOARD.'&amp;thread='.$myPARENT.'&amp;?goto#'.$myID.'"><i class="fa fa-comment"></i> '.$myID.'</a>';
					
					echo '<div class="attachedcomment">';
					if($mySUBJECT != '')echo '<strong>'.$mySUBJECT.'</strong> /';
					echo '('.$myDATE.')<br />';
					if($myTYPE == 'image' && $myURL != '')echo '<img class="imageREPLY" src="'.$myURL.'" height="75" />';
					echo substr($myCOMMENT,0,$cutoff);if(strlen($myCOMMENT) > 500)echo '...';					
					echo '</div></div>';
				}
			}else{
				echo '<h3 class="info">Nothing but dust.  You haven\'t posted anything... yet.</h3>';
			}
		echo '</div>
		';

		// Board listing
		echo '<span class="boardlisting textright">';
		if(count($getBoards) > 0){
			echo '[';
			foreach($getBoards as $gotBoards){
				$BOARDNAME = sanistripents($gotBoards->SHORTNAME);
				echo '
				<a rel="nofollow" href="?board='.$BOARDNAME.'">'.$BOARDNAME.'</a>';
			}
			echo ']';
		}
		echo '[<a href="'.get_permalink().'">Home</a>]';
		if($ISMODERATOR === true){
			echo '[<a href="?area=create">Add/Delete/Unban</a>]';
		}
		echo '</span>';

		// Determine time between between the last post and the flood protection time amount
		if(count($getLastPost) > 0){
			foreach($getLastPost as $lastPost){
				$MODERATOR = $lastPost->MODERATOR;
				if($MODERATOR != 1){
					$time = $lastPost->DATE;
					$postedOn = strtotime($time);
					$currently = strtotime($current_timestamp);
					$timegate = $currently - $postedOn;
					if($timegate < $timebetween){
						$timegateactive = true;
					}
				}elseif($MODERATOR == 1){
						$timegateactive = false;
				}
			}
		}
		
		// Show board content if the requested board exists
		if(count($getCurrentBoard) > 0){
		
			// If set to members only, display this message in place of board content to users who are not logged in.
			if(!is_user_logged_in() && $requirelogged == 1){
				echo '<h3 class="banned">YOU ARE NOT LOGGED IN.</h3>';
			}
			
			// Continue if user is logged in or logged in not required
			elseif(!is_user_logged_in() && $requirelogged == 0 || is_user_logged_in()){
				
				// Board content
				foreach($getCurrentBoard as $gotCurrentBoard){
					$boardName = sanistripents($gotCurrentBoard->NAME);
					$boardShort = sanistripents($gotCurrentBoard->SHORTNAME);
					$boardDescription = $purifier->purify($gotCurrentBoard->DESCRIPTION);
					$boardrules = $purifier->purify($gotCurrentBoard->RULES);
					
					// If user is not banned, check if their IP is blacklisted on the DNSBL.  If it is, autoban them.
					if ($DNSBL === true)
					{
						$wpdb->query("INSERT INTO $regularboard_users (ID, IP, PARENT, BANNED, MESSAGE) VALUES ('','$theIP_us32str','$ID','1',' being blacklisted by the DNSBL.')");
					}
					
					// If user is banned, don't go any further.
					elseif(count($getUser) > 0)
					{
						echo '<div class="banned"><h3 class="banned">'.$purifier->purify($bannedmessage).'</h3>';
						foreach($getUser as $gotUser){
							$IP = intval($gotUser->IP);
							$BANNED = intval($gotUser->BANNED);
							$MESSAGE = sanistripents($gotUser->MESSAGE);
							if($MESSAGE != '')echo 'Your IP Address, '.$ip_address.' has been banned for '.$MESSAGE.'.';
						}
						echo '</div>';
					}
					
					// If user is not banned, and they haven't been listed on the DNSBL, let them view the board content.
					else
					{
									// Form handling
									if(isset($_POST['FORMSUBMIT']))
									{
									
										$IS_IT_SPAM = 0;
										if(function_exists('akismet_admin_init')){
											$APIKey = sanistripents(get_option('wordpress_api_key'));
											$THISPAGE = get_permalink();
											if($BOARD != '' && $THREAD == ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD;}
											elseif($BOARD != '' && $THREAD != ''){$WebsiteURL = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
											$akismet = new Akismet($WebsiteURL, $APIKey);
											if($akismet->isKeyValid()) {}else{echo 'Your API key is NOT valid!';die();}
											if ($_SERVER["REQUEST_METHOD"] == 'POST') {
												//CHANGE the $_REQUEST items to match your form field input element names
												$akismet = new Akismet($WebsiteURL, $APIKey); //
												$akismet->setCommentAuthorEmail($_REQUEST["EMAIL"]);
												$akismet->setCommentAuthorURL($_REQUEST["URL"]);
												$akismet->setCommentContent($_REQUEST["COMMENT"]);
												$akismet->setPermalink($_SERVER["HTTP_REFERER"]);
												if($akismet->isCommentSpam()) {
												$IS_IS_SPAM = 1;
												}
											}					
										}									
									
										if($_REQUEST['COMMENT'] == '') 
										{
											echo '<h3 class="info">CAN\'T SUBMIT AN EMPTY COMMENT</h3>';
										}
										elseif($_REQUEST['LINK'] != '' || $_REQUEST['PAGE'] != '' || $_REQUEST['LOGIN'] != '' || $_REQUEST['USERNAME'] != '' || $_REQUREST['PASSWORD'] != '')
										{
											$wpdb->query("INSERT INTO $regularboard_users (ID, IP, PARENT, BANNED, MESSAGE) VALUES ('','$theIP_us32str','$ID','1','filling out hidden form areas (likely bot).')");
										}
										elseif($IS_IT_SPAM == 1){
											$wpdb->query("INSERT INTO $regularboard_users (ID, IP, PARENT, BANNED, MESSAGE) VALUES ('','$theIP_us32str','$ID','1','Akismet detected you as a spammer.')");
										}
										else
										{
											if($IS_IT_SPAM == 1) {
												
											} else {
												if($THREAD == '' && $enableurl == 1 || $THREAD != ''  && $enablerep == 1)
												{
													$cleanURL = sanistripents($_REQUEST['URL']);
													
													// http://frankkoehl.com/2009/09/http-status-code-curl-php/
													$ch = curl_init();
													$opts = array(CURLOPT_RETURNTRANSFER => true,
													CURLOPT_URL => $cleanURL,
													CURLOPT_NOBODY => true,
													CURLOPT_TIMEOUT => 10);
													curl_setopt_array($ch, $opts);
													curl_exec($ch);
													$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
													curl_close($ch);
													if($cleanURL != ''){
														$path_info = pathinfo($cleanURL);
														if(strpos(strtolower($cleanURL),'youtu.be/')){
															$VIDEOID = substr($cleanURL,16);
															$TYPE = 'video';
															$URL = '<iframe src="http://www.youtube.com/embed/'.sanistripents($VIDEOID).'?loop=1&amp;playlist='.sanistripents($VIDEOID).'&amp;controls=0&amp;showinfo=0&amp;autohide=1" frameborder="0" allowfullscreen></iframe>';
														}
														elseif(strpos(strtolower($cleanURL),'youtube.com/watch?v=')){
															parse_str(parse_url($cleanURL, PHP_URL_QUERY), $VIDEO_VAR);
															$VIDEOID = $VIDEO_VAR['v'];
															$TYPE = 'video';
															$URL = '<iframe src="http://www.youtube.com/embed/'.sanistripents($VIDEOID).'?loop=1&amp;playlist='.sanistripents($VIDEOID).'&amp;controls=0&amp;showinfo=0&amp;autohide=1" frameborder="0" allowfullscreen></iframe>';
														}														
														elseif($status == '200' && getimagesize($cleanURL) !== false){
															if($path_info['extension'] == 'jpg' ||
																$path_info['extension'] == 'gif' ||
																$path_info['extension'] == 'jpeg' ||
																$path_info['extension'] == 'png'){
																$TYPE = 'image';
																$URL = $cleanURL;
															}
														}else{
															$TYPE = '';
															$URL = '';
														}
													}
												}
												if($THREAD != '')$enteredPARENT = intval($THREAD);
												if($THREAD == '')$enteredPARENT = 0;
												$cleanCOMMENT = $purifier->purify($_REQUEST['COMMENT']);
												$cleanCOMMENT = substr($cleanCOMMENT,0,$maxbody);
												$enteredCOMMENT = wpautop($cleanCOMMENT);
												$enteredSUBJECT = sanistripents($_REQUEST['SUBJECT']);
												$enteredSUBJECT = substr($enteredSUBJECT,0,$maxtext);
												$checkCOMMENT = strtolower($enteredCOMMENT);
												$getDuplicate = $wpdb->get_results("SELECT COMMENT FROM $regularboard_posts WHERE COMMENT = '".$checkCOMMENT."' AND BOARD = '".$BOARD."' LIMIT 1");
												if(count($getDuplicate) == 0){
													echo '<h3 class="info">'.esc_attr($postedmessage).'<br />click <a href="'.esc_url($REDIRECTO).'">here</a> if you are not redirected.</h3>';
													if(filter_var($_REQUEST['EMAIL'],FILTER_VALIDATE_EMAIL)){
														$enteredEMAIL = sanistripents(($_REQUEST['EMAIL']));
													}else{
														$enteredEMAIL = sanistripents(tripcode(($_REQUEST['EMAIL'])));
													}
													$enteredEMAIL = substr($enteredEMAIL,0,$maxtext);
													if($ISMODERATOR === true){
														$wpdb->query("INSERT INTO $regularboard_posts (ID, PARENT, IP, DATE, EMAIL, SUBJECT, COMMENT, URL, TYPE, BOARD, MODERATOR, LAST) VALUES ('','$enteredPARENT','$theIP_us32str','$current_timestamp','$enteredEMAIL','$enteredSUBJECT','$enteredCOMMENT','$URL','$TYPE','$BOARD','1','$current_timestamp')") ;
													}else{
														$wpdb->query("INSERT INTO $regularboard_posts (ID, PARENT, IP, DATE, EMAIL, SUBJECT, COMMENT, URL, TYPE, BOARD, MODERATOR, LAST) VALUES ('','$enteredPARENT','$theIP_us32str','$current_timestamp','$enteredEMAIL','$enteredSUBJECT','$enteredCOMMENT','$URL','$TYPE','$BOARD','0','$current_timestamp')") ;
													}
														if($THREAD != '' && $LAST != '9999-12-25 23:59:59' && strtolower($enteredEMAIL) != 'sage'){
															$wpdb->query("UPDATE $regularboard_posts SET LAST = '$current_timestamp' WHERE ID = '$ID'");
														}
														
												}else{
													echo '<h3 class="info">DUPLICATE CONTENT DETECTED - POST DISCARED<br />GO BACK AND FIX YOUR COMMENT.</h3>';
												}
											}
										}
										$THISPAGE = get_permalink();
										if(strtolower($enteredEMAIL) == 'noko' && $THREAD != ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
										elseif(strtolower($enteredEMAIL) == 'noko' && $THREAD == ''){$REDIRECTO = $THISPAGE.'?board='.$BOARD;}
										elseif($BOARD != '' && $THREAD == '' && strtolower($enteredEMAIL) != 'noko'){$REDIRECTO = $THISPAGE.'?board='.$BOARD;}
										elseif($BOARD != '' && $THREAD != '' && strtolower($enteredEMAIL) != 'noko'){$REDIRECTO = $THISPAGE.'?board='.$BOARD;}
										if(count($getDuplicate) == 0){echo '<meta http-equiv="refresh" content="5;URL= '.$REDIRECTO.'">';}
									}
									if(!isset($_POST['FORMSUBMIT']))
									{
					
						echo '<h3 class="boardName">'.$boardName.'</h3>';
						echo '<p class="boardDescription">'.$boardDescription.'</p>';
						if($THREAD != ''){echo '<p class="reply">Posting Mode: Reply <a rel="nofollow" href="?board='.$BOARD.'">[Return]</a></p>';}
						echo '<div class="mainboard"><div class="boardform">';
						if(filter_var($checkThisIP,FILTER_VALIDATE_IP)){ $IPPASS = true; }
						elseif(filter_var($checkThisIP,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){ $IPPASS = true; }
						else{ $IPPASS = false;}
						
							if($timegateactive === true){
								echo '<div class="timegate"><h3>'. ($timebetween - $timegate) . ' seconds until you can post again.</h3></div>';
							}else{
								if($posting != 1){
									echo '<h3 class="readonly">Read-Only Mode</h3>';
								}
								elseif($posting == 1 && $IPPASS === false){
									echo '<h3 class="readonly">You are not permitted to post.</h3>';
								}
								elseif($posting == 1 && $IPPASS === true){
								
									$LOCKED = 0;
									if($THREAD != '')$checkLOCK = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE LAST = '0' AND ID = '".$THREAD."' LIMIT 1");
									if(count($checkLOCK) == 1)$LOCKED = 1;
									if($LOCKED == 1 )echo '<h3 class="readonly"><i class="fa fa-lock"></i> THREAD LOCKED</h3>';
									if($LOCKED == 0){
									
										
										echo '<form class="topic" name="regularboard" method="post" action="';
										if($BOARD != '' && $THREAD == '')echo '?board='.$BOARD;
										if($BOARD != '' && $THREAD != '')echo '?board='.$BOARD.'&amp;thread='.$THREAD;
										echo '">';
										wp_nonce_field('regularboard');
										echo '<input type="hidden" value="" name="LINK" />';
										echo '<input type="hidden" value="" name="PAGE" />';
										echo '<input type="hidden" value="" name="LOGIN" />';
										echo '<input type="hidden" value="" name="USERNAME" />';
										echo '<input type="hidden" value="" name="PASSWORD" />';
										echo '<section><label for="EMAIL">E-mail</label><input type="text" id="EMAIL" maxlength="'.$maxtext.'" name="EMAIL" placeholder="E-mail" /></section>';
										if($enableurl == 1 && $THREAD == ''){echo '<section><label for="URL"><i class="fa fa-camera-retro"></i> URL</label><input type="text" id="URL" maxlength="'.$maxtext.'" name="URL" placeholder="URL (.jpg/.gif/.png)(youtube)" /></section>';}
										if($enablerep == 1 && $THREAD != ''){echo '<section><label for="URL"><i class="fa fa-camera-retro"></i> URL</label><input type="text" id="URL" maxlength="'.$maxtext.'" name="URL" placeholder="URL (.jpg/.gif/.png)(youtube)" /></section>';}
										echo '<section><label for="SUBJECT">Subject</label><input type="text" id="SUBJECT" maxlength="'.$maxtext.'" name="SUBJECT" placeholder="Subject" /></section>';
										echo '<section><label for="COMMENT">Comment</label><textarea id="COMMENT" maxlength="'.$maxbody.'" name="COMMENT" placeholder="Comment"></textarea></section>';
										echo '<section><label for="FORMSUBMIT" class="submit">Post a new ';if($THREAD == ''){echo 'topic';}elseif($THREAD != ''){echo 'reply';}echo '</label><input type="submit" name="FORMSUBMIT" id="FORMSUBMIT" /></section>';
										echo '</form>';
									
									}
								}
							}
						
						echo '</div><div class="boardposts">';
						if($boardrules != '')echo '<div class="rules">'.$boardrules.'</div>';
						$totalREPLIES = 0;
						if(count($getParentPosts) > 0){
							// Start board loop
							
							foreach($getParentPosts as $parentPosts){
								$ID = $parentPosts->ID;
								$IAMOP = $parentPosts->IP;
								$getReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."'");
								$totalREPLIES = count($getReplies);
								if($totalREPLIES >= 4)$totalREPLYS = $totalREPLIES - 3;
								if($totalREPLIES >= 3)$totalREPLYS = $totalREPLIES - 3;
								if($totalREPLIES == 2)$totalREPLYS = $totalREPLIES - 2;
								if($totalREPLIES == 1)$totalREPLYS = $totalREPLIES - 1;
								if($totalREPLIES == 0)$totalREPLYS = $totalREPLIES - 0;
								if($THREAD == '')$gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."' ORDER BY DATE ASC LIMIT $totalREPLYS,3");
								if($THREAD != '')$gotReplies = $wpdb->get_results("SELECT * FROM $regularboard_posts WHERE PARENT = '".$ID."' ORDER BY LAST DESC");
								$TYPE = $parentPosts->TYPE;
								$URL = $parentPosts->URL;
								$MODERATOR = $parentPosts->MODERATOR;
								$PARENT = $parentPosts->PARENT;
								$IP = $parentPosts->IP;
								$DATE = $parentPosts->DATE;
								$EMAIL = $parentPosts->EMAIL;
								$SUBJECT = $parentPosts->SUBJECT;
								$COMMENT = $parentPosts->COMMENT;
								$BOARD = $parentPosts->BOARD;
								$LAST = $parentPosts->LAST;
								if($IP == $theIP_us32str && isset($_POST['DELETE'.$ID.''])){
									$wpdb->query("DELETE FROM $regularboard_posts WHERE ID = '".$ID."'");
									$wpdb->query("DELETE FROM $regularboard_posts WHERE PARENT = '".$ID."'");
									$THISMESSAGE = 'THREAD/REPLY '.$ID.' DELETED.';
									$THISPAGE = get_permalink();
									if($BOARD != '' && $THREAD != '' && $ID == $THREAD)$REDIRECTO = $THISPAGE.'?board='.$BOARD;
									elseif($BOARD != '' && $THREAD == '')$REDIRECTO = $THISPAGE.'?board='.$BOARD;
									elseif($BOARD != '' && $THREAD != '')$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;
									echo '<h3 class="info">'.$THISMESSAGE.'</h3>';
									echo '<meta http-equiv="refresh" content="3;URL= '.$REDIRECTO.'">';									
								}								
								elseif(	
									$ISMODERATOR === true && isset($_POST['STICKY'.$ID.'']) ||
									$ISMODERATOR === true && isset($_POST['UNSTICKY'.$ID.'']) || 
									$ISMODERATOR === true && isset($_POST['LOCK'.$ID.'']) || 
									$ISMODERATOR === true && isset($_POST['UNLOCK'.$ID.'']) || 
									$ISMODERATOR === true && isset($_POST['DELETE'.$ID.'']) || 
									$ISMODERATOR === true && isset($_POST['BAN'.$ID.''])
								){
									if($ISMODERATOR === true && isset($_POST['STICKY'.$ID.'']))$wpdb->query("UPDATE $regularboard_posts SET LAST = '9999-12-25 23:59:59' WHERE ID = '$ID'");$THISMESSAGE = 'THREAD '.$ID.' MADE STICKY';
									if($ISMODERATOR === true && isset($_POST['UNSTICKY'.$ID.'']))$wpdb->query("UPDATE $regularboard_posts SET LAST = '$DATE' WHERE ID = '$ID'");$THISMESSAGE = 'THREAD '.$ID.' STICKY REVOKED';
									if($ISMODERATOR === true && isset($_POST['LOCK'.$ID.'']))$wpdb->query("UPDATE $regularboard_posts SET LAST = '0' WHERE ID = '$ID'");$THISMESSAGE = 'THREAD '.$ID.' LOCKED';
									if($ISMODERATOR === true && isset($_POST['UNLOCK'.$ID.'']))$wpdb->query("UPDATE $regularboard_posts SET LAST = '$DATE' WHERE ID = '$ID'");$THISMESSAGE = 'THREAD '.$ID.' UNLOCKED';
									if($ISMODERATOR === true && isset($_POST['BAN'.$ID.''])){
										$MESSAGE = $_REQUEST['MESSAGE'];
										$wpdb->query("INSERT INTO $regularboard_users (ID, IP, PARENT, BANNED, MESSAGE) VALUES ('','$IP','$ID','1','$MESSAGE')");
										$wpdb->query("DELETE FROM $regularboard_posts WHERE IP = '".$IP."'");
										$THISMESSAGE = 'USER '.$IP.' BANNED FOR '.$MESSAGE;
									}
									if($ISMODERATOR === true && isset($_POST['DELETE'.$ID.''])){
										$wpdb->query("DELETE FROM $regularboard_posts WHERE ID = '".$ID."'");
										$wpdb->query("DELETE FROM $regularboard_posts WHERE PARENT = '".$ID."'");
										$THISMESSAGE = 'THREAD '.$ID.' DELETED.';
									}
									$THISPAGE = get_permalink();
									if($BOARD != '' && $THREAD == '')$REDIRECTO = $THISPAGE.'?board='.$BOARD;
									if($BOARD != '' && $THREAD != '')$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;
									echo '<h3 class="info">'.$THISMESSAGE.'</h3>';
									echo '<meta http-equiv="refresh" content="3;URL= '.$REDIRECTO.'">';
								}else{								
									echo '<div class="op">';
									if($URL != '' && $TYPE == 'image')echo '<span class="fileinfo">File:<a href="'.$URL.'">'.$URL.'</a></span>';
									if($LAST == '9999-12-25 23:59:59')echo '<i class="fa fa-thumb-tack"></i> ';
									if($LAST == '0')echo '<i class="fa fa-lock"></i> ';
									echo '
									<span class="OP">';
									if($SUBJECT != '')echo '<span class="subject">'.$SUBJECT.'</span>';
									if($EMAIL != ''){
										echo get_avatar($EMAIL,32);
									}				
									echo '<span class="name">';
									if(strtolower($EMAIL) == 'heaven'){echo '';}
									else{echo $defaultname;}
									echo '
									</span>';
									if($EMAIL != ''){
										echo '
										<span class="trip">';
										if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){
										}else{
											echo $EMAIL;
										} 
											echo'
											</span>';
									}
									echo '
									</span>';
									if($MODERATOR == 1)echo '<span class="mod">'.$modcode.'</span>';
									if($LAST != '9999-12-25 23:59:59')echo '
									<span class="date">'.$DATE.'</span>
									<span class="postid">No.'.$ID.' </span>'; 
									if($THREAD == '')echo ' [<a rel="nofollow" href="?board='.$BOARD.'&amp;thread='.$ID.'">Reply</a>] ('.count($getReplies).')';
									if($IP == $theIP_us32str){
										echo '<div class="controlpaneluser">';
										echo '<form method="post" class="inline" name="DELETE"><label for="DELETE'.$ID.'"><i class="fa fa-trash-o"></i></label><input type="submit" class="hidden" id="DELETE'.$ID.'" name="DELETE'.$ID.'" /></form>';
										echo '</div>';
									}
									if($ISMODERATOR === true){
										echo '<div class="controlpanel">';
										if($LAST != '9999-12-25 23:59:59')echo '<form method="post" class="inline" name="STICKY"><label for="STICKY'.$ID.'"><i class="off fa fa-thumb-tack"></i></label><input type="submit" class="hidden" id="STICKY'.$ID.'" name="STICKY'.$ID.'" /></form>';
										if($LAST == '9999-12-25 23:59:59')echo '<form method="post" class="inline" name="UNSTICKY"><label for="UNSTICKY'.$ID.'"><i class="on fa fa-thumb-tack"></i></label><input type="submit" class="hidden" id="UNSTICKY'.$ID.'" name="UNSTICKY'.$ID.'" /></form>';
										if($LAST != '0')echo '<form method="post" class="inline" name="LOCK"><label for="LOCK'.$ID.'"><i class="off fa fa-lock"></i></label><input type="submit" class="hidden" id="LOCK'.$ID.'" name="LOCK'.$ID.'" /></form>';
										if($LAST == '0')echo '<form method="post" class="inline" name="UNLOCK"><label for="UNLOCK'.$ID.'"><i class="on fa fa-lock"></i></label><input type="submit" class="hidden" id="UNLOCK'.$ID.'" name="UNLOCK'.$ID.'" /></form>';
										if($MODERATOR != 1){
											echo '<form method="post" class="inline" name="DELETE"><label for="DELETE'.$ID.'"><i class="fa fa-trash-o"></i></label><input type="submit" class="hidden" id="DELETE'.$ID.'" name="DELETE'.$ID.'" /></form>';
											echo '<form method="post" class="inline" name="DELETE"><label for="BAN'.$ID.'">[Ban / </label><input type="text" name="MESSAGE" placeholder="Reason" />]<input type="submit" class="hidden" id="BAN'.$ID.'" name="BAN'.$ID.'" /></form>';
										}
										echo '</div>';
									}
									if($URL != '' && $TYPE == 'image'){
										echo $purifier->purify('<img class="imageOP" src="'.$URL.'" height="250" />');
									}elseif($TYPE == 'video' && $URL != ''){echo $URL;}
									if($THREAD == '')echo substr($COMMENT,0,$cutoff);
									if($THREAD == '' && strlen($COMMENT) > 500)echo '...';
									if($THREAD != '')echo $COMMENT;
									
									if($THREAD == ''){
										if($totalREPLIES >= 4) echo ' <span class="omitted">'.$totalREPLYS.' posts omitted.  Click <a rel="nofollow" href="?board='.$BOARD.'&amp;thread='.$ID.'">here</a> to view.</span>';
										if($totalREPLIES >= 4) echo '<div id="omitted'.$ID.'"></div>';
									}
									if(count($gotReplies) > 0){
										foreach($gotReplies as $REPLIES){
											$TYPE = $REPLIES->TYPE;
											$URL = $REPLIES->URL;
											$MODERATOR = intval($REPLIES->MODERATOR);
											$ID = intval($REPLIES->ID);
											$PARENT = intval($REPLIES->PARENT);
											$IP = intval($REPLIES->IP);
											$DATE = sanistripents($REPLIES->DATE);
											$EMAIL = sanistripents($REPLIES->EMAIL);
											$SUBJECT = sanistripents($REPLIES->SUBJECT);
											$COMMENT = $REPLIES->COMMENT;
											$BOARD = sanistripents($REPLIES->BOARD);							
											if($IP == $theIP_us32str && isset($_POST['DELETE'.$ID.''])){
												$wpdb->query("DELETE FROM $regularboard_posts WHERE ID = '".$ID."'");
												$wpdb->query("DELETE FROM $regularboard_posts WHERE PARENT = '".$ID."'");
												$THISMESSAGE = 'THREAD/REPLY '.$ID.' DELETED.';
												$THISPAGE = get_permalink();
												if($BOARD != '' && $THREAD != '' && $ID == $THREAD)$REDIRECTO = $THISPAGE.'?board='.$BOARD;
												elseif($BOARD != '' && $THREAD == '')$REDIRECTO = $THISPAGE.'?board='.$BOARD;
												elseif($BOARD != '' && $THREAD != '')$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;
												echo '<h3 class="info">'.$THISMESSAGE.'</h3>';
												echo '<meta http-equiv="refresh" content="3;URL= '.$REDIRECTO.'">';									
											}								
											elseif(	
												$ISMODERATOR === true && isset($_POST['DELETE'.$ID.'']) || 
												$ISMODERATOR === true && isset($_POST['BAN'.$ID.''])
											){
												if($ISMODERATOR === true && isset($_POST['BAN'.$ID.''])){
													$MESSAGE = $_REQUEST['MESSAGE'];
													$wpdb->query("INSERT INTO $regularboard_users (ID, IP, PARENT, BANNED, MESSAGE) VALUES ('','$IP','$ID','1','$MESSAGE')");
													$wpdb->query("DELETE FROM $regularboard_posts WHERE IP = '".$IP."'");
													$THISMESSAGE = 'USER '.$IP.' BANNED FOR '.$MESSAGE;
												}
												if($ISMODERATOR === true && isset($_POST['DELETE'.$ID.''])){
													$wpdb->query("DELETE FROM $regularboard_posts WHERE ID = '".$ID."'");
													$wpdb->query("DELETE FROM $regularboard_posts WHERE PARENT = '".$ID."'");
													$THISMESSAGE = 'THREAD '.$ID.' DELETED.';
												}
												$THISPAGE = get_permalink();
												if($BOARD != '' && $THREAD == '')$REDIRECTO = $THISPAGE.'?board='.$BOARD;
												if($BOARD != '' && $THREAD != '')$REDIRECTO = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;
												echo '<h3 class="info">'.$THISMESSAGE.'</h3>';
												echo '<meta http-equiv="refresh" content="3;URL= '.$REDIRECTO.'">';
												}else{
												echo '<div class="reply" id="'.$ID.'">';
												if($URL != '' && $TYPE == 'image')echo '<span class="fileinfo">File:<a href="'.$URL.'">'.$URL.'</a></span>';
												echo '
												<span class="OP">';
												if($EMAIL != ''){
													echo get_avatar($EMAIL,32);
												}										
												echo '<span class="name">';
												if(strtolower($EMAIL) == 'heaven'){echo '';}
												else{echo $defaultname;}
												if($IP == $IAMOP)echo ' <span class="thisisOP">(OP)</span>';
												echo '
												</span>';
												if($EMAIL != ''){
													echo ' 
													<span class="trip">';
													if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){
													}else{
														echo $EMAIL;
													}
													echo'
													</span>';
												}
												echo '
												</span>';
												if($MODERATOR == 1){echo '<span class="mod">'.$modcode.'</span>';}
												echo '
												<span class="date">'.$DATE.'</span>
												<span class="postid">No.'.$ID.'</span>';
											if($IP == $theIP_us32str){
													echo '<div class="controlpaneluser">';
													echo '<form method="post" class="inline" name="DELETE"><label for="DELETE'.$ID.'"><i class="fa fa-trash-o"></i></label><input type="submit" class="hidden" id="DELETE'.$ID.'" name="DELETE'.$ID.'" /></form>';
													echo '</div>';
											}								
											if($ISMODERATOR === true){ 
												echo '<div class="controlpanel">';
												if($MODERATOR != 1){
													echo '<form method="post" class="inline" name="DELETE"><label for="DELETE'.$ID.'"><i class="fa fa-trash-o"></i></label><input type="submit" class="hidden" id="DELETE'.$ID.'" name="DELETE'.$ID.'" /></form>';
													echo '<form method="post" class="inline" name="DELETE"><label for="BAN'.$ID.'">[Ban / </label><input type="text" name="MESSAGE" placeholder="Reason" />]<input type="submit" class="hidden" id="BAN'.$ID.'" name="BAN'.$ID.'" /></form>';
												}
												echo '</div>';
											}
												echo '<section>';
											if($URL != '' && $TYPE == 'image'){
												echo $purifier->purify('<img class="imageREPLY" src="'.$URL.'" height="125" />');
											}elseif($TYPE == 'video' && $URL != ''){echo $URL;}
													if($THREAD != '')echo $purifier->purify($COMMENT);
													if($THREAD == '')echo substr($COMMENT,0,$cutoff);
													if($THREAD == '' && strlen($COMMENT) > 500)echo '...';
													echo '</section></div>';								
											}
										}
									}
									echo '</div>';
								}
							}
							if($BOARD != '' && $THREAD == ''){
								$i = 0;
								$paging = round($totalpages / $postsperpage);
								if($paging > 0){
								echo '<div class="pages">Go to page ';
									while ($i < $paging) {
										$i++;
										echo '<a ';if($i == $results){ echo 'class="focus" '; } echo 'href="?board='.$BOARD.'&amp;results='.$i.'">'.$i.'</a>';
									}
								echo '</div>';
								}
								echo '</div></div>';
							}
						}else{
							echo '<h3 class="info">'.$nothreads.'</h3>';
						}
						if($THREAD != '')echo '</div></div>';
					}
					}
				}
		}
		}else{
			echo '<h3 class="banned">'.$noboard.'</h3>';
		}
	if(!isset($_POST['FORMSUBMIT']))echo '<p class="credits">'.$credits.'</p></div>';
	}else{
		$getBoards = $wpdb->get_results("SELECT SHORTNAME,NAME,DESCRIPTION FROM $regularboard_boards ");
		echo '<div class="boardlist">';
		if(count($getBoards) > 0){
			echo '<div>';
			echo '<h3>Boards</h3>';
			foreach($getBoards as $gotBoards){
				$BOARDNAME = sanistripents($gotBoards->SHORTNAME);
				$BOARDLONG = sanistripents($gotBoards->NAME);
				$BOARDDESC = sanistripents($gotBoards->DESCRIPTION);
				$getBoardPostsPosts = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."' ");
				$getBoardPostsTopics = $wpdb->get_results("SELECT ID FROM $regularboard_posts WHERE BOARD = '".$BOARDNAME."' AND PARENT = '0'");
				echo '
					<a rel="nofollow" href="?board='.$BOARDNAME.'">'.$BOARDLONG.'</a>';
				}
			echo '</div></div></div>';
		}
	}
}
if(get_option('mommaincontrol_regularboard') == 1)add_shortcode('regularboard','regularboard_shortcode');
if(get_option('mommaincontrol_regularboard') == 1)add_filter('the_content','do_shortcode','regularboard_shortcode');

/****************************** SECTION Y -/- (Y0) Functions -/- Javascript for modules ******************************/
if(current_user_can('manage_options')){
			$css = plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/';
			add_action('wp_enqueue_admin_scripts','mom_plugin_scripts');		
			// Add info panel to post edit screen
			function momEditorScreen($post_type){
				$screen = get_current_screen();
				$edit_post_type = $screen->post_type;
				if($edit_post_type != 'post')
					return;
				if(get_option('mommaincontrol_shorts') == 1 || 
					 get_option('mommaincontrol_reviews') == 1 ||
					 get_option('mommaincontrol_rups') == 1 ||
					 get_option('mommaincontrol_fontawesome') == 1
				){
					echo '
					<div class="momEditorScreen postbox">
						<h3>Shortcodes provided by My Optional Modules</h3>
						<div class="inside">
							<style>
								ol#momEditorMenu {width:95%; margin:0 auto; overflow:auto; overflow:hidden;}
								ol#momEditorMenu li {width:auto; margin:2px; float:left; list-style:none; display:block; padding:5px; line-height:20px; font-size:13px;}
								ol#momEditorMenu li span:hover {cursor:pointer; background-color:#fff; color:#4b5373;}
								ol#momEditorMenu li span {margin-right:5px; width:18px; height:19px; display:block; float:left; overflow:hidden; color: #fff; background-color:#4b5373; border-radius:3px; font-size:20px;}
								ol#momEditorMenu li.clear {clear:both; display:block; width:100%;}
								ol#momEditorMenu li.icon {width:18px; height:16px; overflow:hidden; font-size:20px; line-height:22px; margin:5px}
								ol#momEditorMenu li.icon:hover {cursor:pointer; color:#441515; background-color:#ececec; border-radius:3px;}
							</style>					
												
							<ol id="momEditorMenu">';
								if(get_option('mommaincontrol_shorts') == 1){
									echo '<li>Google map<span class="fa fa-plus-square" onclick="addText(event)">[mom_map address=""]</span></li>';
									echo '<li>Reddit button<span class="fa fa-plus-square" onclick="addText(event)">[mom_reddit]</span></li>';
									echo '<li>Restrict<span class="fa fa-plus-square" onclick="addText(event)">[mom_restrict]content[/mom_restrict]</span></li>';
									echo '<li>Progress bar<span class="fa fa-plus-square" onclick="addText(event)">[mom_progress level=""]</span></li>';
									echo '<li>Verifier<span class="fa fa-plus-square" onclick="addText(event)">[mom_verify age="18"]some content[/mom_verify]</span></li>';
								}
								if(get_option('mommaincontrol_reviews') == 1){
									echo '<li>Reviews<span class="fa fa-plus-square" onclick="addText(event)">[momreviews]</span></li>';
								}
								if(get_option('mommaincontrol_momrups') == 1){
									echo '<li>Passwords<span class="fa fa-plus-square" onclick="addText(event)">[rups]content[/rups]</span></li>';
								}
								if(get_option('mommaincontrol_fontawesome') == 1){
									echo '<li class="clear"></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-ambulance"><span>&#60;i class="fa fa-ambulance"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-medkit"><span>&#60;i class="fa fa-medkit"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-user-md"><span>&#60;i class="fa fa-user-md"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-h-square"><span>&#60;i class="fa fa-h-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-plus-square"><span>&#60;i class="fa fa-plus-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-wheelchair"><span>&#60;i class="fa fa-wheelchair"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-hospital"><span>&#60;i class="fa fa-hospital"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-stethoscope"><span>&#60;i class="fa fa-stethoscope"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-adn"><span>&#60;i class="fa fa-adn"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bitbucket"><span>&#60;i class="fa fa-bitbucket"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-btc"><span>&#60;i class="fa fa-btc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-dropbox"><span>&#60;i class="fa fa-dropbox"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-flickr"><span>&#60;i class="fa fa-flickr"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-github-alt"><span>&#60;i class="fa fa-github-alt"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-google-plus"><span>&#60;i class="fa fa-google-plus"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-instagram"><span>&#60;i class="fa fa-instagram"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-linux"><span>&#60;i class="fa fa-linux"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-pinterest"><span>&#60;i class="fa fa-pinterest"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-skype"><span>&#60;i class="fa fa-skype"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-trello"><span>&#60;i class="fa fa-trello"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-twitter"><span>&#60;i class="fa fa-twitter"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-vk"><span>&#60;i class="fa fa-vk"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-xing"><span>&#60;i class="fa fa-xing"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-youtube-play"><span>&#60;i class="fa fa-youtube-play"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-android"><span>&#60;i class="fa fa-android"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bitbucket-square"><span>&#60;i class="fa fa-bitbucket-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-css3"><span>&#60;i class="fa fa-css3"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-facebook"><span>&#60;i class="fa fa-facebook"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-foursquare"><span>&#60;i class="fa fa-foursquare"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-github-square"><span>&#60;i class="fa fa-github-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-google-plus-square"><span>&#60;i class="fa fa-google-plus-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-linkedin"><span>&#60;i class="fa fa-linkedin"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-maxcdn"><span>&#60;i class="fa fa-maxcdn"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-pinterest-square"><span>&#60;i class="fa fa-pinterest-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-stack-exchange"><span>&#60;i class="fa fa-stack-exchange"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tumblr"><span>&#60;i class="fa fa-tumblr"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-twitter-square"><span>&#60;i class="fa fa-twitter-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-weibo"><span>&#60;i class="fa fa-weibo"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-xing-square"><span>&#60;i class="fa fa-xing-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-youtube-square"><span>&#60;i class="fa fa-youtube-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-apple"><span>&#60;i class="fa fa-apple"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bitcoin"><span>&#60;i class="fa fa-bitcoin"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-dribbble"><span>&#60;i class="fa fa-dribbble"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-facebook-square"><span>&#60;i class="fa fa-facebook-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-github"><span>&#60;i class="fa fa-github"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-gittip"><span>&#60;i class="fa fa-gittip"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-html5"><span>&#60;i class="fa fa-html5"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-linkedin-square"><span>&#60;i class="fa fa-linkedin-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-pagelines"><span>&#60;i class="fa fa-pagelines"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-renren"><span>&#60;i class="fa fa-renren"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-stack-overflow"><span>&#60;i class="fa fa-stack-overflow"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tumblr-square"><span>&#60;i class="fa fa-tumblr-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-vimeo-square"><span>&#60;i class="fa fa-vimeo-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-windows"><span>&#60;i class="fa fa-windows"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-youtube"><span>&#60;i class="fa fa-youtube"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-backward"><span>&#60;i class="fa fa-backward"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-fast-forward"><span>&#60;i class="fa fa-fast-forward"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-pause"><span>&#60;i class="fa fa-pause"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-play-circle-o"><span>&#60;i class="fa fa-play-circle-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-step-backward"><span>&#60;i class="fa fa-step-backward"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-youtube-play"><span>&#60;i class="fa fa-youtube-play"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-eject"><span>&#60;i class="fa fa-eject"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-forward"><span>&#60;i class="fa fa-forward"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-play"><span>&#60;i class="fa fa-play"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-resize-full"><span>&#60;i class="fa fa-resize-full"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-step-forward"><span>&#60;i class="fa fa-step-forward"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-fast-backward"><span>&#60;i class="fa fa-fast-backward"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-fullscreen"><span>&#60;i class="fa fa-fullscreen"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-play-circle"><span>&#60;i class="fa fa-play-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-resize-small"><span>&#60;i class="fa fa-resize-small"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-stop"><span>&#60;i class="fa fa-stop"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-double-down"><span>&#60;i class="fa fa-angle-double-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-double-up"><span>&#60;i class="fa fa-angle-double-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-right"><span>&#60;i class="fa fa-angle-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-left"><span>&#60;i class="fa fa-arrow-circle-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-right"><span>&#60;i class="fa fa-arrow-circle-o-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-up"><span>&#60;i class="fa fa-arrow-circle-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-right"><span>&#60;i class="fa fa-arrow-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-left"><span>&#60;i class="fa fa-caret-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-left"><span>&#60;i class="fa fa-caret-square-o-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-up"><span>&#60;i class="fa fa-caret-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-right"><span>&#60;i class="fa fa-chevron-circle-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-left"><span>&#60;i class="fa fa-chevron-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-hand-o-down"><span>&#60;i class="fa fa-hand-o-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-hand-o-up"><span>&#60;i class="fa fa-hand-o-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-right"><span>&#60;i class="fa fa-long-arrow-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-left"><span>&#60;i class="fa fa-toggle-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-double-left"><span>&#60;i class="fa fa-angle-double-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-down"><span>&#60;i class="fa fa-angle-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-up"><span>&#60;i class="fa fa-angle-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-down"><span>&#60;i class="fa fa-arrow-circle-o-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-up"><span>&#60;i class="fa fa-arrow-circle-o-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-down"><span>&#60;i class="fa fa-arrow-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-up"><span>&#60;i class="fa fa-arrow-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-right"><span>&#60;i class="fa fa-caret-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-right"><span>&#60;i class="fa fa-caret-square-o-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-down"><span>&#60;i class="fa fa-chevron-circle-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-up"><span>&#60;i class="fa fa-chevron-circle-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-right"><span>&#60;i class="fa fa-chevron-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-hand-o-left"><span>&#60;i class="fa fa-hand-o-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-down"><span>&#60;i class="fa fa-long-arrow-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-up"><span>&#60;i class="fa fa-long-arrow-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-right"><span>&#60;i class="fa fa-toggle-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-double-right"><span>&#60;i class="fa fa-angle-double-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-angle-left"><span>&#60;i class="fa fa-angle-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-down"><span>&#60;i class="fa fa-arrow-circle-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-left"><span>&#60;i class="fa fa-arrow-circle-o-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-right"><span>&#60;i class="fa fa-arrow-circle-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-arrow-left"><span>&#60;i class="fa fa-arrow-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-down"><span>&#60;i class="fa fa-caret-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-down"><span>&#60;i class="fa fa-caret-square-o-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-up"><span>&#60;i class="fa fa-caret-square-o-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-left"><span>&#60;i class="fa fa-chevron-circle-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-down"><span>&#60;i class="fa fa-chevron-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chevron-up"><span>&#60;i class="fa fa-chevron-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-hand-o-right"><span>&#60;i class="fa fa-hand-o-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-left"><span>&#60;i class="fa fa-long-arrow-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-down"><span>&#60;i class="fa fa-toggle-down"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-up"><span>&#60;i class="fa fa-toggle-up"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-align-center"><span>&#60;i class="fa fa-align-center"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-align-right"><span>&#60;i class="fa fa-align-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chain-broken"><span>&#60;i class="fa fa-chain-broken"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-copy"><span>&#60;i class="fa fa-copy"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-eraser"><span>&#60;i class="fa fa-eraser"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-file-text"><span>&#60;i class="fa fa-file-text"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-floppy-o"><span>&#60;i class="fa fa-floppy-o"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-italic"><span>&#60;i class="fa fa-italic"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-list-alt"><span>&#60;i class="fa fa-list-alt"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-outdent"><span>&#60;i class="fa fa-outdent"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-repeat"><span>&#60;i class="fa fa-repeat"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-save"><span>&#60;i class="fa fa-save"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-table"><span>&#60;i class="fa fa-table"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-th"><span>&#60;i class="fa fa-th"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-underline"><span>&#60;i class="fa fa-underline"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-align-justify"><span>&#60;i class="fa fa-align-justify"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-bold"><span>&#60;i class="fa fa-bold"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-clipboard"><span>&#60;i class="fa fa-clipboard"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-cut"><span>&#60;i class="fa fa-cut"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-file"><span>&#60;i class="fa fa-file"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-file-text-o"><span>&#60;i class="fa fa-file-text-o"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-font"><span>&#60;i class="fa fa-font"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-link"><span>&#60;i class="fa fa-link"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-list-ol"><span>&#60;i class="fa fa-list-ol"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-paperclip"><span>&#60;i class="fa fa-paperclip"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-rotate-left"><span>&#60;i class="fa fa-rotate-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-scissors"><span>&#60;i class="fa fa-scissors"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-text-height"><span>&#60;i class="fa fa-text-height"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-th-large"><span>&#60;i class="fa fa-th-large"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-undo"><span>&#60;i class="fa fa-undo"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-align-left"><span>&#60;i class="fa fa-align-left"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-chain"><span>&#60;i class="fa fa-chain"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-columns"><span>&#60;i class="fa fa-columns"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-dedent"><span>&#60;i class="fa fa-dedent"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-file-o"><span>&#60;i class="fa fa-file-o"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-files-o"><span>&#60;i class="fa fa-files-o"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-indent"><span>&#60;i class="fa fa-indent"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-list"><span>&#60;i class="fa fa-list"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-list-ul"><span>&#60;i class="fa fa-list-ul"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-paste"><span>&#60;i class="fa fa-paste"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-rotate-right"><span>&#60;i class="fa fa-rotate-right"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-strikethrough"><span>&#60;i class="fa fa-strikethrough"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-text-width"><span>&#60;i class="fa fa-text-width"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-th-list"><span>&#60;i class="fa fa-th-list"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-unlink"><span>&#60;i class="fa fa-unlink"&#62;&#60;/i&#62;</span></li>';	
									echo '<li onclick="addText(event)" class="icon fa fa-bitcoin"><span>&#60;i class="fa fa-bitcoin"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-dollar"><span>&#60;i class="fa fa-dollar"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-gbp"><span>&#60;i class="fa fa-gbp"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-krw"><span>&#60;i class="fa fa-krw"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-rouble"><span>&#60;i class="fa fa-rouble"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-rupee"><span>&#60;i class="fa fa-rupee"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-usd"><span>&#60;i class="fa fa-usd"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-btc"><span>&#60;i class="fa fa-btc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-eur"><span>&#60;i class="fa fa-eur"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-inr"><span>&#60;i class="fa fa-inr"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-money"><span>&#60;i class="fa fa-money"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-rub"><span>&#60;i class="fa fa-rub"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-try"><span>&#60;i class="fa fa-try"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-won"><span>&#60;i class="fa fa-won"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-cny"><span>&#60;i class="fa fa-cny"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-euro"><span>&#60;i class="fa fa-euro"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-jpy"><span>&#60;i class="fa fa-jpy"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-rmb"><span>&#60;i class="fa fa-rmb"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-ruble"><span>&#60;i class="fa fa-ruble"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-turkish-lira"><span>&#60;i class="fa fa-turkish-lira"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-yen"><span>&#60;i class="fa fa-yen"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-check-square"><span>&#60;i class="fa fa-check-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-circle-o"><span>&#60;i class="fa fa-circle-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-minus-square-o"><span>&#60;i class="fa fa-minus-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-check-square-o"><span>&#60;i class="fa fa-check-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-dot-circle-o"><span>&#60;i class="fa fa-dot-circle-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-square"><span>&#60;i class="fa fa-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-circle"><span>&#60;i class="fa fa-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-minus-square"><span>&#60;i class="fa fa-minus-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-square-o"><span>&#60;i class="fa fa-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-adjust"><span>&#60;i class="fa fa-adjust"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-anchor"><span>&#60;i class="fa fa-anchor"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-archive"><span>&#60;i class="fa fa-archive"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-asterisk"><span>&#60;i class="fa fa-asterisk"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-ban"><span>&#60;i class="fa fa-ban"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bar-chart-o"><span>&#60;i class="fa fa-bar-chart-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-barcode"><span>&#60;i class="fa fa-barcode"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-beer"><span>&#60;i class="fa fa-beer"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bell"><span>&#60;i class="fa fa-bell"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bell-o"><span>&#60;i class="fa fa-bell-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bolt"><span>&#60;i class="fa fa-bolt"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-book"><span>&#60;i class="fa fa-book"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bookmark"><span>&#60;i class="fa fa-bookmark"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bookmark-o"><span>&#60;i class="fa fa-bookmark-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-briefcase"><span>&#60;i class="fa fa-briefcase"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bug"><span>&#60;i class="fa fa-bug"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-building"><span>&#60;i class="fa fa-building"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bullhorn"><span>&#60;i class="fa fa-bullhorn"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-bullseye"><span>&#60;i class="fa fa-bullseye"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-calendar"><span>&#60;i class="fa fa-calendar"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-calendar-o"><span>&#60;i class="fa fa-calendar-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-camera"><span>&#60;i class="fa fa-camera"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-camera-retro"><span>&#60;i class="fa fa-camera-retro"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-down"><span>&#60;i class="fa fa-caret-square-o-down"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-left"><span>&#60;i class="fa fa-caret-square-o-left"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-right"><span>&#60;i class="fa fa-caret-square-o-right"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-up"><span>&#60;i class="fa fa-caret-square-o-up"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-certificate"><span>&#60;i class="fa fa-certificate"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-check"><span>&#60;i class="fa fa-check"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-check-circle"><span>&#60;i class="fa fa-check-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-check-circle-o"><span>&#60;i class="fa fa-check-circle-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-check-square"><span>&#60;i class="fa fa-check-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-check-square-o"><span>&#60;i class="fa fa-check-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-circle"><span>&#60;i class="fa fa-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-circle-o"><span>&#60;i class="fa fa-circle-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-clock-o"><span>&#60;i class="fa fa-clock-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-cloud"><span>&#60;i class="fa fa-cloud"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-cloud-download"><span>&#60;i class="fa fa-cloud-download"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-cloud-upload"><span>&#60;i class="fa fa-cloud-upload"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-code"><span>&#60;i class="fa fa-code"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-code-fork"><span>&#60;i class="fa fa-code-fork"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-coffee"><span>&#60;i class="fa fa-coffee"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-cog"><span>&#60;i class="fa fa-cog"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-cogs"><span>&#60;i class="fa fa-cogs"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-collapse-o"><span>&#60;i class="fa fa-collapse-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-comment"><span>&#60;i class="fa fa-comment"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-comment-o"><span>&#60;i class="fa fa-comment-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-comments"><span>&#60;i class="fa fa-comments"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-comments-o"><span>&#60;i class="fa fa-comments-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-compass"><span>&#60;i class="fa fa-compass"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-credit-card"><span>&#60;i class="fa fa-credit-card"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-crop"><span>&#60;i class="fa fa-crop"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-crosshairs"><span>&#60;i class="fa fa-crosshairs"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-cutlery"><span>&#60;i class="fa fa-cutlery"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-dashboard"><span>&#60;i class="fa fa-dashboard"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-desktop"><span>&#60;i class="fa fa-desktop"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-dot-circle-o"><span>&#60;i class="fa fa-dot-circle-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-download"><span>&#60;i class="fa fa-download"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-edit"><span>&#60;i class="fa fa-edit"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-ellipsis-horizontal"><span>&#60;i class="fa fa-ellipsis-horizontal"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-ellipsis-vertical"><span>&#60;i class="fa fa-ellipsis-vertical"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-envelope"><span>&#60;i class="fa fa-envelope"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-envelope-o"><span>&#60;i class="fa fa-envelope-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-eraser"><span>&#60;i class="fa fa-eraser"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-exchange"><span>&#60;i class="fa fa-exchange"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-exclamation"><span>&#60;i class="fa fa-exclamation"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-exclamation-circle"><span>&#60;i class="fa fa-exclamation-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-exclamation-triangle"><span>&#60;i class="fa fa-exclamation-triangle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-expand-o"><span>&#60;i class="fa fa-expand-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-external-link"><span>&#60;i class="fa fa-external-link"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-external-link-square"><span>&#60;i class="fa fa-external-link-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-eye"><span>&#60;i class="fa fa-eye"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-eye-slash"><span>&#60;i class="fa fa-eye-slash"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-female"><span>&#60;i class="fa fa-female"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-fighter-jet"><span>&#60;i class="fa fa-fighter-jet"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-film"><span>&#60;i class="fa fa-film"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-filter"><span>&#60;i class="fa fa-filter"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-fire"><span>&#60;i class="fa fa-fire"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-fire-extinguisher"><span>&#60;i class="fa fa-fire-extinguisher"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-flag"><span>&#60;i class="fa fa-flag"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-flag-checkered"><span>&#60;i class="fa fa-flag-checkered"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-flag-o"><span>&#60;i class="fa fa-flag-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-flash"><span>&#60;i class="fa fa-flash"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-flask"><span>&#60;i class="fa fa-flask"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-folder"><span>&#60;i class="fa fa-folder"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-folder-o"><span>&#60;i class="fa fa-folder-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-folder-open"><span>&#60;i class="fa fa-folder-open"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-folder-open-o"><span>&#60;i class="fa fa-folder-open-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-frown-o"><span>&#60;i class="fa fa-frown-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-gamepad"><span>&#60;i class="fa fa-gamepad"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-gavel"><span>&#60;i class="fa fa-gavel"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-gear"><span>&#60;i class="fa fa-gear"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-gears"><span>&#60;i class="fa fa-gears"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-gift"><span>&#60;i class="fa fa-gift"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-glass"><span>&#60;i class="fa fa-glass"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-globe"><span>&#60;i class="fa fa-globe"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-group"><span>&#60;i class="fa fa-group"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-headphones"><span>&#60;i class="fa fa-headphones"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-heart"><span>&#60;i class="fa fa-heart"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-heart-o"><span>&#60;i class="fa fa-heart-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-home"><span>&#60;i class="fa fa-home"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-inbox"><span>&#60;i class="fa fa-inbox"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-info"><span>&#60;i class="fa fa-info"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-info-circle"><span>&#60;i class="fa fa-info-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-key"><span>&#60;i class="fa fa-key"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-keyboard-o"><span>&#60;i class="fa fa-keyboard-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-laptop"><span>&#60;i class="fa fa-laptop"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-leaf"><span>&#60;i class="fa fa-leaf"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-legal"><span>&#60;i class="fa fa-legal"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-lemon-o"><span>&#60;i class="fa fa-lemon-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-level-down"><span>&#60;i class="fa fa-level-down"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-level-up"><span>&#60;i class="fa fa-level-up"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-lightbulb-o"><span>&#60;i class="fa fa-lightbulb-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-location-arrow"><span>&#60;i class="fa fa-location-arrow"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-lock"><span>&#60;i class="fa fa-lock"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-magic"><span>&#60;i class="fa fa-magic"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-magnet"><span>&#60;i class="fa fa-magnet"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-mail-forward"><span>&#60;i class="fa fa-mail-forward"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-mail-reply"><span>&#60;i class="fa fa-mail-reply"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-mail-reply-all"><span>&#60;i class="fa fa-mail-reply-all"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-male"><span>&#60;i class="fa fa-male"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-map-marker"><span>&#60;i class="fa fa-map-marker"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-meh-o"><span>&#60;i class="fa fa-meh-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-microphone"><span>&#60;i class="fa fa-microphone"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-microphone-slash"><span>&#60;i class="fa fa-microphone-slash"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-minus"><span>&#60;i class="fa fa-minus"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-minus-circle"><span>&#60;i class="fa fa-minus-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-minus-square"><span>&#60;i class="fa fa-minus-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-minus-square-o"><span>&#60;i class="fa fa-minus-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-mobile"><span>&#60;i class="fa fa-mobile"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-mobile-phone"><span>&#60;i class="fa fa-mobile-phone"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-money"><span>&#60;i class="fa fa-money"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-moon-o"><span>&#60;i class="fa fa-moon-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-move"><span>&#60;i class="fa fa-move"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-music"><span>&#60;i class="fa fa-music"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-pencil"><span>&#60;i class="fa fa-pencil"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-pencil-square"><span>&#60;i class="fa fa-pencil-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-pencil-square-o"><span>&#60;i class="fa fa-pencil-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-phone"><span>&#60;i class="fa fa-phone"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-phone-square"><span>&#60;i class="fa fa-phone-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-picture-o"><span>&#60;i class="fa fa-picture-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-plane"><span>&#60;i class="fa fa-plane"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-plus"><span>&#60;i class="fa fa-plus"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-plus-circle"><span>&#60;i class="fa fa-plus-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-plus-square"><span>&#60;i class="fa fa-plus-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-power-off"><span>&#60;i class="fa fa-power-off"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-print"><span>&#60;i class="fa fa-print"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-puzzle-piece"><span>&#60;i class="fa fa-puzzle-piece"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-qrcode"><span>&#60;i class="fa fa-qrcode"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-question"><span>&#60;i class="fa fa-question"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-question-circle"><span>&#60;i class="fa fa-question-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-quote-left"><span>&#60;i class="fa fa-quote-left"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-quote-right"><span>&#60;i class="fa fa-quote-right"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-random"><span>&#60;i class="fa fa-random"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-refresh"><span>&#60;i class="fa fa-refresh"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-reorder"><span>&#60;i class="fa fa-reorder"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-reply"><span>&#60;i class="fa fa-reply"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-reply-all"><span>&#60;i class="fa fa-reply-all"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-resize-horizontal"><span>&#60;i class="fa fa-resize-horizontal"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-resize-vertical"><span>&#60;i class="fa fa-resize-vertical"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-retweet"><span>&#60;i class="fa fa-retweet"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-road"><span>&#60;i class="fa fa-road"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-rocket"><span>&#60;i class="fa fa-rocket"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-rss"><span>&#60;i class="fa fa-rss"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-rss-square"><span>&#60;i class="fa fa-rss-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-search"><span>&#60;i class="fa fa-search"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-search-minus"><span>&#60;i class="fa fa-search-minus"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-search-plus"><span>&#60;i class="fa fa-search-plus"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-share"><span>&#60;i class="fa fa-share"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-share-square"><span>&#60;i class="fa fa-share-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-share-square-o"><span>&#60;i class="fa fa-share-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-shield"><span>&#60;i class="fa fa-shield"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-shopping-cart"><span>&#60;i class="fa fa-shopping-cart"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sign-in"><span>&#60;i class="fa fa-sign-in"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sign-out"><span>&#60;i class="fa fa-sign-out"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-signal"><span>&#60;i class="fa fa-signal"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sitemap"><span>&#60;i class="fa fa-sitemap"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-smile-o"><span>&#60;i class="fa fa-smile-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort"><span>&#60;i class="fa fa-sort"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-alpha-asc"><span>&#60;i class="fa fa-sort-alpha-asc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-alpha-desc"><span>&#60;i class="fa fa-sort-alpha-desc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-amount-asc"><span>&#60;i class="fa fa-sort-amount-asc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-amount-desc"><span>&#60;i class="fa fa-sort-amount-desc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-asc"><span>&#60;i class="fa fa-sort-asc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-desc"><span>&#60;i class="fa fa-sort-desc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-down"><span>&#60;i class="fa fa-sort-down"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-numeric-asc"><span>&#60;i class="fa fa-sort-numeric-asc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-numeric-desc"><span>&#60;i class="fa fa-sort-numeric-desc"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sort-up"><span>&#60;i class="fa fa-sort-up"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-spinner"><span>&#60;i class="fa fa-spinner"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-square"><span>&#60;i class="fa fa-square"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-square-o"><span>&#60;i class="fa fa-square-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-star"><span>&#60;i class="fa fa-star"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-star-half"><span>&#60;i class="fa fa-star-half"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-star-half-empty"><span>&#60;i class="fa fa-star-half-empty"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-star-half-full"><span>&#60;i class="fa fa-star-half-full"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-star-half-o"><span>&#60;i class="fa fa-star-half-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-star-o"><span>&#60;i class="fa fa-star-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-subscript"><span>&#60;i class="fa fa-subscript"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-suitcase"><span>&#60;i class="fa fa-suitcase"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-sun-o"><span>&#60;i class="fa fa-sun-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-superscript"><span>&#60;i class="fa fa-superscript"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tablet"><span>&#60;i class="fa fa-tablet"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tachometer"><span>&#60;i class="fa fa-tachometer"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tag"><span>&#60;i class="fa fa-tag"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tags"><span>&#60;i class="fa fa-tags"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tasks"><span>&#60;i class="fa fa-tasks"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-terminal"><span>&#60;i class="fa fa-terminal"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-thumb-tack"><span>&#60;i class="fa fa-thumb-tack"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-thumbs-down"><span>&#60;i class="fa fa-thumbs-down"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-thumbs-o-down"><span>&#60;i class="fa fa-thumbs-o-down"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-thumbs-o-up"><span>&#60;i class="fa fa-thumbs-o-up"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-thumbs-up"><span>&#60;i class="fa fa-thumbs-up"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-ticket"><span>&#60;i class="fa fa-ticket"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-times"><span>&#60;i class="fa fa-times"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-times-circle"><span>&#60;i class="fa fa-times-circle"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-times-circle-o"><span>&#60;i class="fa fa-times-circle-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-tint"><span>&#60;i class="fa fa-tint"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-down"><span>&#60;i class="fa fa-toggle-down"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-left"><span>&#60;i class="fa fa-toggle-left"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-right"><span>&#60;i class="fa fa-toggle-right"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-toggle-up"><span>&#60;i class="fa fa-toggle-up"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-trash-o"><span>&#60;i class="fa fa-trash-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-trophy"><span>&#60;i class="fa fa-trophy"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-truck"><span>&#60;i class="fa fa-truck"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-umbrella"><span>&#60;i class="fa fa-umbrella"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-unlock"><span>&#60;i class="fa fa-unlock"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-unlock-o"><span>&#60;i class="fa fa-unlock-o"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-unsorted"><span>&#60;i class="fa fa-unsorted"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-upload"><span>&#60;i class="fa fa-upload"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-user"><span>&#60;i class="fa fa-user"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-video-camera"><span>&#60;i class="fa fa-video-camera"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-volume-down"><span>&#60;i class="fa fa-volume-down"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-volume-off"><span>&#60;i class="fa fa-volume-off"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-volume-up"><span>&#60;i class="fa fa-volume-up"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-warning"><span>&#60;i class="fa fa-warning"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-wheelchair"><span>&#60;i class="fa fa-wheelchair"&#62;&#60;/i&#62;</span></li>';
									echo '<li onclick="addText(event)" class="icon fa fa-wrench"><span>&#60;i class="fa fa-wrench"&#62;&#60;/i&#62;</span></li>';
								}
								echo '</ol>
								<script>
								function addText(event){
									var targ = event.target || event.srcElement;
									document.getElementById("content").value += targ.textContent || targ.innerText;
								}
								</script>
						</div>
					</div>';
				}
			}	
			add_action('edit_form_after_editor','momEditorScreen');
}
/****************************** SECTION Z -/- Additional information ******************************
	Report all bugs to admin@onebillionwords.com
	Additional support can be provided to those who ask for it at the following URL:
	http://www.onebillionwords.com/my-optional-modules/
	Ends
*/		
?>