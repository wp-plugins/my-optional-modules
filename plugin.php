<?php 
/*
Plugin Name: My Optional Modules
Plugin URI: http://www.onebillionwords.com/boards/?board=mom
Description: Optional modules and additions for Wordpress.
Version: 5.4.9.6
Author: Matthew Trevino
Author URI: http://onebillionwords.com/
*/
	
	// LICENSE
	// This program is free software; you can redistribute it and/or modify
	// it under the terms of the GNU General Public License, version 2, as
	// published by the Free Software Foundation.
	
	// This program is distributed in the hope that it will be useful,
	// but WITHOUT ANY WARRANTY; without even the implied warranty of
	// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	// GNU General Public License for more details.
	
	// You should have received a copy of the GNU General Public License
	// along with this program;if not, write to the Free Software
	// Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	// (A) Dependencies
	// (B) Installation
	// (B) (1) Plugin variables
	// (B) (2) Plugin functions
	// (B) (3) Plugin form handling
	// (C) Plugin settings	
	// (E) Reviews          (settings page)
	// (E) (1) Reviews      (shortcode)
	// (I) Font Awesome     (shortcode)
	// (J) Count++          (settings page)
	// (L) Jump Around      (settings page)
	// (M) Post Voting      (functions)
	// (W) Database Cleaner (functions)
	// (X) Plugin javascript
	// (Y) Quick press
	// (Z) Etc.
	
	// 	SECTION D > Passwords
	// 		(D0) Settings > Settings page
	// 		(D1) Functions > Functions([shortcode])
	// 	SECTION F > Shortcodes
	// 		(F0) Settings > Settings display (informational purposes screen)
	// 		(F1) Shortcodes > [shortcodes]
	//	SECTION G > Meta
	// 		(G0) Functions > Meta functions
	// 	SECTION H > Theme Takeover
	// 		(H0) Settings > Settings page
	// 		(H1) Functions > Theme Takeover functions
	// 	SECTION J > Count++
	// 		(J1) Functions > Count++ Theme functions
	// 	SECTION K > Exclude
	// 		(K0) Settings > Settings page
	// 		(K1) Functions > Exclude functions
	// 	SECTION N > REGULARD BOARD
	// 		(N0) Functions > Regular Board






	// (A) Dependencies
		define('MyOptionalModules',true);
		require_once(ABSPATH.'wp-includes/pluggable.php');
		require_once('HTMLPurifier.standalone.php');
		$config                             = HTMLPurifier_Config::createDefault();
		$purifier                           = new HTMLPurifier($config);
		
		
		$my_optional_modules_passwords_salt = get_option('mom_passwords_salt');
		$passwordField                      = 0;

		if(function_exists('akismet_admin_init')){
			require_once('akismet.class.php');
		}
	//
	
	
	
	
	// (B) Installation
		register_activation_hook(__FILE__,'myoptionalmodules_main_control_install');
		add_action('wp','myoptionalmodules_enqueuescripts');
		add_action('admin_enqueue_scripts','mom_styles');
		add_action('admin_enqueue_scripts','MOMFontAwesomeIncluded');
		add_action('wp_print_styles','MOMMainCSS');
		
		function mom_styles($hook){
			if('settings_page_mommaincontrol' != $hook)
			return;
			wp_register_style('mom_admin_css',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/adminstyle/css.css');
			wp_register_style('font_awesome',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.min.css');
			wp_enqueue_style('font_awesome');
			wp_enqueue_style('mom_admin_css');	
		}
		
		function MOMFontAwesomeIncluded(){
			wp_register_style('font_awesome',plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.min.css');
			wp_enqueue_style('font_awesome');
		}
		
		function MOMMainCSS(){
			$myStyleFile = WP_PLUGIN_URL . '/my-optional-modules/includes/css/myoptionalmodules05492702.css';
			wp_register_style('my_optional_modules',$myStyleFile);
			wp_enqueue_style('my_optional_modules');
		}
	// 




	// (B) (1) Plugin variables
		$mommodule_analytics = esc_attr(get_option('mommaincontrol_analytics'));
		$mommodule_focus = esc_attr(get_option('mommaincontrol_focus'));
		$mommodule_prettycanon = $mommodule_fixcanon = $mommodule_analytics = $mommodule_count = $mommodule_exclude = $mommodule_focus = $mommodule_fontawesome = 
		$mommodule_jumparound = $mommodule_lazyload = $mommodule_maintenance = $mommodule_meta = $mommodule_passwords = 
		$mommodule_postasfront = $mommodule_reviews = $mommodule_shortcodes = $mommodule_themetakeover = $mommodule_versionnumbers = false;
		if($mommodule_analytics == 1)$mommodule_analytics = true;
		$mommodule_count = esc_attr(get_option('mommaincontrol_obwcountplus'));
		if($mommodule_count == 1)$mommodule_count = true;
		$mommodule_exclude = esc_attr(get_option('mommaincontrol_momse'));
		if($mommodule_exclude == 1)$mommodule_exclude = true;
		if($mommodule_exclude === true)add_action('after_setup_theme','myoptionalmodules_postformats');
		if($mommodule_exclude === true)add_action('pre_get_posts','mom_exclude_filter_posts');
		if($mommodule_focus == 1)$mommodule_focus = true;
		$mommodule_fontawesome = esc_attr(get_option('mommaincontrol_fontawesome'));
		if($mommodule_fontawesome == 1)$mommodule_fontawesome = true;
		if($mommodule_fontawesome === true)add_action('wp_enqueue_scripts','myoptionalmodules_scripts');
		if($mommodule_fontawesome === true)add_shortcode('font-fa','font_fa_shortcode');
		if($mommodule_fontawesome === true)add_filter('the_content','do_shortcode','font_fa_shortcode');
		$mommodule_jumparound = esc_attr(get_option('mommaincontrol_momja'));
		if($mommodule_jumparound == 1)$mommodule_jumparound = true;
		$mommodule_authorarchives = esc_attr(get_option('mommaincontrol_authorarchives'));
		if($mommodule_authorarchives == 1)$mommodule_authorarchives = true;
		if($mommodule_authorarchives === true)add_action('template_redirect','myoptionalmodules_disableauthorarchives');
		$mommodule_datearchives = esc_attr(get_option('mommaincontrol_datearchives'));
		if($mommodule_datearchives == 1)$mommodule_datearchives = true;
		if($mommodule_datearchives === true)add_action('wp','myoptionalmodules_disabledatearchives');
		if($mommodule_datearchives === true)add_action('template_redirect','myoptionalmodules_disabledatearchives');
		$mommodule_footerscripts = esc_attr(get_option('mommaincontrol_footerscripts'));
		if($mommodule_footerscripts == 1)$mommodule_footerscripts = true;
		if($mommodule_footerscripts === true)add_action('wp_enqueue_scripts','myoptionalmodules_footerscripts');
		if($mommodule_footerscripts === true)add_action('wp_footer','wp_print_scripts',5);
		if($mommodule_footerscripts === true)add_action('wp_footer','wp_enqueue_scripts',5);
		if($mommodule_footerscripts === true)add_action('wp_footer','wp_print_head_scripts',5);
		$mommodule_protectrss = esc_attr(get_option('mommaincontrol_protectrss'));
		if($mommodule_protectrss == 1)$mommodule_protectrss = true;
		if($mommodule_protectrss === true)add_filter('the_content_feed','myoptionalmodules_rsslinkback');
		if($mommodule_protectrss === true)add_filter('the_excerpt_rss','myoptionalmodules_rsslinkback');
		$mommodule_lazyload = esc_attr(get_option('mommaincontrol_lazyload'));
		if($mommodule_lazyload == 1)$mommodule_lazyload = true;
		$mommodule_maintenance = esc_attr(get_option('mommaincontrol_maintenance'));
		if($mommodule_maintenance == 1)$mommodule_maintenance = true;
		if($mommodule_maintenance === true)add_action('wp','momMaintenance');
		
		$mommodule_meta = esc_attr(get_option('mommaincontrol_meta'));
		if($mommodule_meta == 1)$mommodule_meta = true;
		if($mommodule_meta === true)mom_SEO_header();
		if($mommodule_meta === true)add_filter('admin_init','myoptionalmodules_add_fields_to_general');
		if($mommodule_meta === true)add_filter('user_contactmethods','myoptionalmodules_add_fields_to_profile');
		if($mommodule_meta === true)add_filter('jetpack_enable_opengraph','__return_false',99);
		if($mommodule_meta === true)add_action('wp_head','mom_meta_module');
		
		$mommodule_rb = esc_attr(get_option('mommaincontrol_regularboard'));
		if($mommodule_rb == 1)$mommodule_rb = true;
		if($mommodule_rb === true)add_filter('jetpack_enable_opengraph','__return_false',99);
		
		$mommodule_passwords = esc_attr(get_option('mommaincontrol_momrups'));
		if($mommodule_passwords == 1)$mommodule_passwords = true;
		if($mommodule_passwords === true)add_shortcode('rups','rotating_universal_passwords_shortcode');
		if($mommodule_passwords === true)add_filter('the_content','do_shortcode','rotating_universal_passwords_shortcode');
		$mommodule_postasfront = esc_attr(get_option('mommaincontrol_mompaf'));
		if($mommodule_postasfront == 1)$mommodule_postasfront = true;
		if($mommodule_postasfront === true)add_action('wp','myoptionalmodules_postasfront');
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
		if($mommodule_versionnumbers === true)add_filter('style_loader_src','myoptionalmodules_removeversion',0);
		if($mommodule_versionnumbers === true)add_filter('script_loader_src','myoptionalmodules_removeversion',0);
		$momthemetakeover_youtube = esc_url(get_option('MOM_themetakeover_youtubefrontpage'));
		$mommodule_fixcanon = esc_attr(get_option('mommaincontrol_fixcanon'));
		if($mommodule_fixcanon == 1)$mommodule_fixcanon = true;
		if($mommodule_fixcanon === true)if( function_exists( 'rel_canonical' ) ){ remove_action( 'wp_head', 'rel_canonical' ); }
		if($mommodule_fixcanon === true)if( function_exists( 'mom_canonical' ) ){    add_action( 'wp_head', 'mom_canonical' ); }
		
	//
	
	
	
	
	// (B) (2) Plugin functions
	// http://stackoverflow.com/questions/10912185/how-to-add-apostrophes-around-strings-from-an-imploded-array-in-a-mysql-in-state
	function rb_apply_quotes($item){
		return "'" . mysql_real_escape_string($item) . "'";
	}
	
	// Generate a random password 
	// http://stackoverflow.com/questions/5438760/generate-random-5-characters-string
	$seed = str_split('abcdefghijklmnopqrstuvwxyz'
					 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
					 .'0123456789!@#$%^&*()'); // and any other characters
	shuffle($seed); // probably optional since array_is randomized; this may be redundant
	$rand = '';
	foreach (array_rand($seed, 10) as $k) $rand .= $seed[$k];			
	// Generate a random number
	// http://stackoverflow.com/questions/5438760/generate-random-5-characters-string
	$seednum = str_split('1'.
						 '2'.
						 '3'.
						 '4'.
						 '5'.
						 '6'); // and any other characters
	shuffle($seednum); // probably optional since array_is randomized; this may be redundant
	$randnum1 = '';
	$randnum2 = '';
	foreach (array_rand($seednum, 2) as $rk) $randnum1 .= $seednum[$rk];
	foreach (array_rand($seednum, 2) as $rk) $randnum2 .= $seednum[$rk];

	
	//http://www.daniweb.com/web-development/php/code/303115/very-simple-bbcode
	function rb_format($data){
	$input = array(
	'/\\\r/is',
	'/\\\n/is',
	'/\  - (.*?)\|\|/is',
	'/\  - (.*?)\|\|\|\|/is',	
	'/\    (.*?)\|\|/is',
	'/\    (.*?)\|\|\|\|/is',
	'/\:\:(.*?)\:\:/is',
	'/\*\*\*(.*?)\*\*\*/is',
	'/\*\*(.*?)\*\*/is',
	'/\*(.*?)\*/is',
	'/\~\~(.*?)\~\~/is',
	'/\{\{(.*?)\}\}/is',
	'/-\-\-\-/is',
	'/\|\|/is',
	'/\`(.*?)\`/is',
	'/\[spoiler](.*?)\[\/spoiler]/is',
	);
	$output = array(
	'||',
	'||',
	'<ul><li>$1</li></ul>',
	'<ul><li>$1</li></ul>',
	'<p><span class="quotes"> &#62; $1 </span></p>',
	'<a href="#$1"> &#62;&#62; $1 </a><br />',
	'<a href="#$1"> &#62;&#62; $1 </a><br />',
	'<strong><em>$1</em></strong>',
	'<strong>$1</strong>',
	'<em>$1</em>',
	'<span class="strike">$1</span>',
	'<blockquote>$1</blockquote>',
	'<hr />',
	'<br />',
	'<code>$1</code>',
	'<span class="spoiler">$1</span>',
	);
	$rtrn = preg_replace ($input, $output, $data);
	return $rtrn;
	}																
	
	// http://stackoverflow.com/questions/2398725/using-php-substr-and-strip-tags-while-retaining-formatting-and-without-break
	function regularboard_html_cut($text, $max_length)
	{
		$tags   = array();
		$result = "";

		$is_open   = false;
		$grab_open = false;
		$is_close  = false;
		$in_double_quotes = false;
		$in_single_quotes = false;
		$tag = "";

		$i = 0;
		$stripped = 0;

		$stripped_text = strip_tags($text);

		while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
		{
			$symbol  = $text{$i};
			$result .= $symbol;

			switch ($symbol)
			{
			   case '<':
					$is_open   = true;
					$grab_open = true;
					break;

			   case '"':
				   if ($in_double_quotes)
					   $in_double_quotes = false;
				   else
					   $in_double_quotes = true;

				break;

				case "'":
				  if ($in_single_quotes)
					  $in_single_quotes = false;
				  else
					  $in_single_quotes = true;

				break;

				case '/':
					if ($is_open && !$in_double_quotes && !$in_single_quotes)
					{
						$is_close  = true;
						$is_open   = false;
						$grab_open = false;
					}

					break;

				case ' ':
					if ($is_open)
						$grab_open = false;
					else
						$stripped++;

					break;

				case '>':
					if ($is_open)
					{
						$is_open   = false;
						$grab_open = false;
						array_push($tags, $tag);
						$tag = "";
					}
					else if ($is_close)
					{
						$is_close = false;
						array_pop($tags);
						$tag = "";
					}

					break;

				default:
					if ($grab_open || $is_close)
						$tag .= $symbol;

					if (!$is_open && !$is_close)
						$stripped++;
			}

			$i++;
		}

		while ($tags)
			$result .= "</".array_pop($tags).">";

		return $result;
	}
	
	// This is necessary to get Regular Board URLs to play nicely with scrapers and open graph.
	// Unnecessary if you don't want to use Regular Board.
	function mom_canonical(){
		global $wp,$post;
		$BOARD                 = '';
		$THREAD                = '';
		$pretty = esc_attr(get_option('mommaincontrol_prettycanon'));
		
		if($prettycanon != 1 && is_page() && $_GET['board'] != '' || $prettycanon != 1 && is_single() && $_GET['board'] != ''){
			$THISPAGE          = home_url('/');
			if($_GET['board'] != ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']))));
			if($_GET['board'] == ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents($post->post_name)));
			if($BOARD         != ''                    )$THREAD = esc_sql(intval($_GET['thread']));	
			if($BOARD         != '' && $THREAD != 0    ){$canonical = $THISPAGE.'?board='.$BOARD.'&amp;thread='.$THREAD;}
			elseif($BOARD     != '' && $THREAD == 0    ){$canonical = $THISPAGE.'?board='.$BOARD;}
		}
		elseif($prettycanon == 1 && is_page() && $_GET['board'] != '' || $prettycanon == 1 && is_single() && $_GET['board'] != ''){
			$THISPAGE          = home_url('/');
			if($_GET['board'] != ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']))));
			if($_GET['board'] == ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents($post->post_name)));
			if($BOARD         != ''                    )$THREAD = esc_sql(intval($_GET['thread']));	
			if($BOARD         != '' && $THREAD != 0    ){$canonical = $THISPAGE.'?thread='.$THREAD;}
			elseif($BOARD     != '' && $THREAD == 0    ){$canonical = $THISPAGE;}
		}		
		elseif(is_home()){
			$canonical         = $THISPAGE;
		}
		else{
			$THISPAGE          = 'http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
			$canonical         = $THISPAGE;
		}
		
		
		
		echo "\n";
		echo '<link rel=\'canonical\' href=\''.$canonical.'\' />';echo "\n";
	}
	
	function timesincethis($date,$granularity=2) {
		$retval = '';
		$date = strtotime($date);
		$difference = time() - $date;
		$periods = array('decade' => 315360000,
			'year' => 31536000,
			'month' => 2628000,
			'week' => 604800, 
			'day' => 86400,
			'hour' => 3600,
			'minute' => 60,
			'second' => 1);

		foreach ($periods as $key => $value) {
			if ($difference >= $value) {
				$time = floor($difference/$value);
				$difference %= $value;
				$retval .= ($retval ? ' ' : '').$time.' ';
				$retval .= (($time > 1) ? $key.'s' : $key);
				$granularity--;
			}
			if ($granularity == '0') { break; }
		}
		return $retval.' ago';      
	}	
	
	
		if(esc_attr($_SERVER['SERVER_ADDR']) == '127.0.0.1' || esc_attr($_SERVER['SERVER_ADDR']) == '::1'){
			$ipaddress = esc_attr($_SERVER["REMOTE_ADDR"]);		
		}else{
			if(isset($_SERVER["REMOTE_ADDR"])){
				$ipaddress = esc_attr($_SERVER["REMOTE_ADDR"]);
			}else{
				$ipaddress = false;
			}
			//https://www.countryipblocks.net/bogons/htaccessdeny_ipv4_bogons.txt
			$rb_blacklist_ips = array(
				'127.255.255.255','127.255.255..*',
				'0.0.0..*','5.133.64..*','10.0.0..*','24.50.160..*','24.51.0..*','24.51.224..*','24.53.96..*','24.53.192..*','24.54.64..*','24.102.64..*',
				'24.104.160..*','24.104.192..*','24.105.64..*','24.129.192..*','24.140.224..*','24.143.128..*','24.146.32..*','24.146.64..*','24.152.0..*',
				'24.156.176..*','31.13.184..*','31.22.8..*','31.132.8..*','31.132.32..*','31.133.96..*','31.210.16..*','37.18.128..*','41.245.0..*','62.12.96..*',
				'62.61.192..*','62.122.224..*','62.182.40..*','64.71.72..*','64.110.16..*','64.110.24..*','64.110.128..*','64.110.136..*','64.136.98..*','64.136.100..*',
				'64.136.104..*','64.187.210..*','64.187.212..*','64.187.216..*','66.85.1..*','66.85.3..*','66.85.7..*','66.85.8..*','66.85.10..*','66.85.12..*','66.85.14..*',
				'66.85.21..*','66.85.22..*','66.85.25..*','66.85.26..*','66.85.28..*','66.85.34..*','66.85.41..*','66.85.43..*','66.85.44..*','66.85.48..*','66.85.56..*',
				'66.85.59..*','66.85.60..*','66.85.63..*','66.85.64..*','66.85.67..*','66.85.70..*','66.85.72..*','66.85.80..*','66.85.82..*','66.85.84..*','66.85.88..*',
				'66.85.91..*','66.85.92..*','66.85.240..*','66.85.248..*','66.85.252..*','66.85.254..*','66.128.32..*','66.159.108..*','66.170.180..*','66.170.184..*',
				'66.175.232..*','66.180.72..*','66.230.240..*','66.230.248..*','66.245.176..*','66.245.184..*','67.21.32..*','67.21.38..*','67.21.40..*','67.22.120..*',
				'68.65.120..*','68.65.124..*','69.12.1..*','69.12.2..*','69.12.4..*','69.12.8..*','69.12.11..*','69.12.12..*','69.12.16..*','69.12.25..*','69.12.26..*',
				'69.12.28..*','69.12.32..*','69.12.36..*','69.12.38..*','69.12.41..*','69.12.42..*','69.12.44..*','69.12.48..*','69.12.52..*','69.12.55..*','69.12.56..*',
				'69.12.64..*','69.12.96..*','69.12.104..*','69.12.106..*','69.12.108..*','69.12.112..*','69.166.0..*','69.166.8..*','71.19.128..*','77.73.16..*','78.24.88..*',
				'78.41.80..*','79.170.144..*','79.174.0..*','80.66.192..*','80.67.128..*','80.95.0..*','80.241.136..*','80.249.112..*','80.254.224..*','81.16.16..*','81.26.64..*',
				'81.161.224..*','83.143.72..*','83.143.104..*','83.143.112..*','83.219.96..*','85.8.128..*','85.255.80..*','87.101.80..*','89.19.32..*','89.207.176..*','91.193.4..*',
				'91.193.112..*','91.193.248..*','91.194.192..*','91.194.214..*','91.196.180..*','91.196.200..*','91.198.170..*','91.198.210..*','91.199.30..*','91.199.82..*','91.199.87..*',
				'91.199.168..*','91.200.240..*','91.201.140..*','91.202.248..*','91.205.196..*','91.207.222..*','91.207.230..*','91.208.137..*','91.209.21..*','91.209.22..*','91.209.99..*',
				'91.209.149..*','91.209.209..*','91.212.14..*','91.212.73..*','91.212.107..*','91.213.117..*','91.213.138..*','91.213.151..*','91.216.39..*','91.216.122..*','91.217.80..*',
				'91.217.167..*','91.217.207..*','91.217.250..*','91.218.56..*','91.220.28..*','91.220.71..*','91.220.186..*','91.220.203..*','91.223.70..*','91.223.169..*','91.224.64..*',
				'91.226.84..*','91.228.231..*','91.229.46..*','91.230.134..*','91.230.136..*','91.230.182..*','91.230.228..*','91.232.129..*','91.233.120..*','91.238.18..*','92.60.32..*',
				'93.177.64..*','93.185.160..*','94.103.112..*','94.247.136..*','95.130.224..*','95.174.64..*','100.64.0..*','102.0.0..*','103.32.0..*','103.64.0..*','103.128.0..*','103.192.0..*',
				'103.224.107..*','103.224.120..*','103.224.128..*','103.225.0..*','103.226.0..*','103.228.0..*','103.232.0..*','104.16.0..*','104.32.0..*','104.64.0..*','104.128.0..*','105.0.0..*',
				'105.64.0..*','105.178.0..*','105.188.0..*','107.155.192..*','107.161.112..*','107.167.160..*','107.167.192..*','107.171.0..*','107.178.0..*','107.180.0..*','107.184.0..*','109.71.152..*',
				'109.236.48..*','127.0.0..*','128.0.156..*','129.0.0..*','129.18.0..*','129.45.0..*','129.56.0..*','129.122.0..*','129.140.0..*','129.205.0..*','129.232.0..*','130.51.0..*','130.185.112..*',
				'130.211.0..*','131.0.0..*','131.72.0..*','131.100.0..*','131.108.0..*','131.161.0..*','131.221.0..*','131.255.0..*','132.157.0..*','132.184.0..*','132.191.0..*','132.251.0..*','132.255.0..*',
				'137.64.0..*','137.115.0..*','137.171.0..*','137.196.0..*','137.255.0..*','138.0.0..*','138.36.0..*','138.59.0..*','138.94.0..*','138.97.0..*','138.99.0..*','138.117.0..*','138.118.0..*','138.121.0..*',
				'138.122.0..*','138.128.0..*','138.128.130..*','138.128.132..*','138.128.136..*','138.128.144..*','138.128.160..*','138.128.192..*','138.185.0..*','138.186.0..*','138.204.0..*','138.219.0..*',
				'138.229.16..*','138.229.32..*','138.229.64..*','138.229.128..*','138.255.0..*','139.64.0..*','140.235.0..*','142.54.8..*','142.54.18..*','142.54.20..*','142.54.24..*','142.54.42..*','142.54.44..*',
				'142.54.192..*','142.54.202..*','142.54.204..*','143.0.0..*','143.137.0..*','143.202.0..*','143.208.0..*','143.255.0..*','144.172.64..*','144.172.128..*','146.71.0..*','148.0.0..*','148.101.0..*',
				'148.102.0..*','148.163.0..*','148.163.128..*','148.163.160..*','148.163.176..*','148.163.180..*','148.163.184..*','148.163.192..*','148.255.0..*','152.0.0..*','152.156.0..*','152.166.0..*','152.168.0..*',
				'152.200.0..*','152.230.0..*','152.232.0..*','152.240.0..*','154.65.88..*','154.66.112..*','154.67.128..*','154.68.128..*','154.70.80..*','154.70.208..*','154.70.224..*','154.72.8..*','154.72.16..*','154.72.48..*',
				'154.72.64..*','154.72.128..*','154.73.0..*','154.74.0..*','154.76.0..*','154.104.0..*','154.112.0..*','154.128.0..*','155.0.0..*','155.11.0..*','155.12.0..*','155.89.0..*','155.93.0..*','155.94.64..*','155.94.128..*',
				'155.196.0..*','155.251.0..*','155.254.0..*','155.254.2..*','155.254.4..*','155.254.8..*','155.254.16..*','155.254.32..*','155.254.64..*','155.254.131..*','155.254.132..*','155.254.136..*','155.254.144..*','155.254.160..*',
				'155.254.192..*','155.255.0..*','156.0.0..*','156.38.0..*','156.155.0..*','156.156.0..*','156.160.0..*','156.192.0..*','157.131.0..*','158.51.0..*','158.222.0..*','158.222.32..*','158.222.40..*','158.222.48..*','158.222.64..*','158.222.96..*',
				'158.222.102..*','158.222.104..*','158.222.112..*','158.222.128..*','160.0.0..*','160.77.0..*','160.89.0..*','160.90.0..*','160.105.0..*','160.113.0..*','160.119.0..*','160.120.0..*','160.152.0..*','160.154.0..*','160.156.0..*',
				'160.160.0..*','160.176.0..*','160.182.0..*','160.184.0..*','160.224.0..*','160.226.0..*','160.242.0..*','160.255.0..*','161.0.0..*','161.10.0..*','161.18.0..*','161.22.0..*','161.56.0..*','161.138.0..*','161.140.0..*','161.212.0..*',
				'161.234.0..*','161.255.0..*','162.244.0..*','162.252.0..*','165.0.0..*','165.16.0..*','165.49.0..*','165.50.0..*','165.52.0..*','165.56.0..*','165.73.0..*','165.90.0..*','165.169.0..*','165.210.0..*','165.255.0..*','167.0.0..*',
				'167.56.0..*','167.108.0..*','167.116.0..*','167.249.0..*','167.250.0..*','168.0.0..*','168.90.0..*','168.121.0..*','168.181.0..*','168.194.0..*','168.196.0..*',
				'168.205.0..*','168.211.0..*','168.227.0..*','168.228.0..*','168.232.0..*','168.235.64..*','168.235.128..*','168.253.0..*','169.0.0..*','169.159.0..*','169.197.64..*','169.197.128..*','169.239.0..*','169.254.0..*',
				'169.255.0..*','170.0.0..*','170.75.128..*','170.78.0..*','170.80.0..*','170.84.0..*','170.150.0..*','170.231.0..*','170.233.0..*','170.238.0..*','170.244.0..*','170.254.0..*','172.16.0..*','172.64.0..*','173.213.0..*',
				'173.224.160..*','173.224.170..*','173.224.172..*','176.53.128..*','176.98.32..*','176.101.168..*','176.105.144..*','176.105.224..*','176.113.40..*','176.113.64..*','176.118.160..*','176.118.192..*','177.8.156..*',
				'177.8.220..*','177.11.128..*','177.22.188..*','177.22.252..*','177.37.32..*','177.44.220..*','177.47.88..*','177.52.172..*','177.71.92..*','177.74.64..*','177.74.208..*',
				'177.84.76..*','177.84.156..*','177.85.44..*','177.85.76..*','177.85.92..*','177.86.28..*','177.86.156..*','177.86.236..*','177.87.12..*','177.87.28..*','177.87.124..*','177.87.156..*','177.87.204..*',
				'177.87.236..*','177.87.252..*','177.89.0..*','177.91.60..*','177.91.76..*','177.91.140..*','177.91.248..*','177.92.0..*','177.124.44..*','177.125.44..*','177.125.60..*','177.125.124..*',
				'177.125.180..*','177.125.252..*','177.128.140..*','177.128.204..*','177.128.220..*','177.129.28..*','177.136.76..*','177.136.84..*','177.136.172..*','177.137.56..*','177.137.88..*',
				'177.137.120..*','177.137.152..*','177.137.248..*','177.152.52..*','177.152.124..*','177.152.188..*','177.154.20..*','177.154.28..*','177.154.84..*','177.155.84..*','177.155.252..*','177.184.212..*',
				'177.184.220..*','177.184.248..*','177.185.124..*','177.185.152..*','177.190.64..*','177.190.212..*','177.190.244..*','177.190.248..*','177.222.128..*','177.223.112..*','177.223.240..*','177.234.128..*','177.235.0..*',
				'177.240.0..*','178.20.208..*','178.217.88..*','178.217.232..*','178.218.192..*','178.249.232..*','178.255.112..*','179.0.150..*','179.0.156..*','179.0.192..*','179.10.0..*','179.16.0..*',
				'179.34.0..*','179.51.64..*','179.54.0..*','179.96.168..*','179.96.184..*','179.96.200..*',
				'179.96.216..*','179.96.232..*','179.97.8..*','179.97.24..*','179.97.48..*','179.97.72..*','179.97.88..*','179.97.192..*','179.105.0..*','179.106.72..*','179.106.88..*','179.106.168..*','179.107.8..*','179.107.48..*','179.107.84..*',
				'179.107.92..*','179.107.112..*','179.107.128..*','179.107.208..*','179.108.24..*','179.108.72..*','179.108.88..*','179.108.184..*','179.108.240..*','179.109.8..*','179.109.56..*','179.109.88..*','179.109.204..*','179.124.12..*',
				'179.124.48..*','179.124.132..*','179.124.176..*','179.124.204..*','179.124.240..*','179.125.20..*','179.125.104..*','179.127.72..*','179.127.116..*','179.140.0..*','179.189.16..*','179.189.40..*','179.189.72..*','179.189.112..*',
				'179.189.144..*','179.189.200..*','179.189.216..*','179.189.240..*','179.190.64..*','179.191.8..*','179.191.56..*','179.191.224..*','181.39.0..*','181.76.0..*','181.212.0..*','181.216.0..*','181.233.148..*','185.1.3..*','185.1.22..*',
				'185.1.24..*','185.1.32..*','185.1.64..*','185.1.128..*','185.45.96..*','185.45.128..*','185.46.0..*','185.48.0..*','185.64.0..*','185.128.0..*','186.183.0..*','186.189.252..*','186.209.92..*','186.209.220..*','186.219.60..*','186.226.220..*',
				'186.227.124..*','186.227.156..*','186.227.188..*','186.232.104..*','186.235.60..*','186.235.92..*','186.235.188..*','186.235.252..*','186.237.60..*','186.250.144..*','187.0.164..*','187.0.168..*','187.16.0..*','187.49.144..*',
				'187.49.160..*','187.49.248..*','187.73.112..*','187.73.176..*','187.85.60..*','187.86.200..*','187.95.208..*','187.103.192..*','187.120.160..*','187.180.0..*','187.191.96..*','187.191.128..*','187.255.0..*','188.66.24..*','188.92.120..*',
				'189.39.192..*','189.45.176..*','189.50.208..*','189.84.32..*','189.84.64..*','189.84.136..*','189.85.96..*','189.90.80..*','189.90.144..*','189.113.48..*','189.113.176..*','189.126.0..*','189.201.196..*','189.201.200..*','189.201.208..*',
				'189.201.228..*','189.201.232..*','189.201.252..*','189.204.128..*','189.207.0..*','189.213.128..*','190.5.160..*','190.15.32..*','190.108.96..*','190.124.176..*','191.5.60..*','191.5.64..*',
				'191.5.128..*','191.6.0..*','191.8.0..*','191.16.0..*','191.32.0..*','191.80.0..*','191.97.16..*','191.97.64..*','191.97.128..*','191.98.128..*','191.100.0..*','191.112.0..*','191.120.0..*','191.128.0..*','191.241.20..*','191.241.80..*','191.241.224..*',
				'191.242.160..*','191.242.196..*','191.242.220..*','191.242.244..*','191.243.4..*','191.243.132..*',
				'192.0.0..*','192.0.1..*','192.0.2..*','192.0.3..*','192.5.0..*','192.5.11..*','192.5.31..*','192.5.46..*','192.5.51..*','192.5.57..*','192.5.58..*','192.5.60..*','192.5.68..*','192.5.71..*','192.5.104..*','192.5.151..*','192.5.154..*','192.5.203..*','192.5.211..*',
				'192.5.221..*','192.5.222..*','192.5.241..*','192.5.255..*','192.9.200..*','192.9.255..*','192.12.0..*','192.12.2..*','192.12.18..*','192.12.20..*','192.12.23..*','192.12.26..*','192.12.31..*','192.12.41..*','192.12.45..*','192.12.46..*','192.12.51..*',
				'192.12.55..*','192.12.103..*','192.12.108..*','192.12.128..*','192.12.144..*','192.12.146..*','192.12.148..*','192.12.154..*','192.12.172..*','192.12.219..*','192.12.221..*','192.12.222..*','192.12.236..*','192.12.250..*','192.16.73..*','192.16.174..*',
				'192.25.115..*','192.25.116..*','192.26.9..*','192.26.20..*','192.26.27..*','192.26.98..*','192.26.104..*','192.26.129..*','192.26.130..*','192.26.132..*','192.26.137..*','192.26.138..*','192.26.144..*','192.26.146..*','192.26.255..*','192.30.36..*',
				'192.30.38..*','192.30.51..*','192.30.52..*','192.30.54..*','192.30.60..*','192.30.62..*','192.30.88..*','192.30.90..*','192.30.95..*','192.30.97..*','192.30.98..*','192.30.101..*','192.30.102..*','192.30.109..*','192.30.110..*','192.30.112..*','192.30.114..*',
				'192.30.120..*','192.30.123..*','192.30.124..*','192.30.126..*','192.30.140..*','192.30.143..*','192.30.144..*','192.30.146..*','192.30.150..*','192.30.188..*','192.30.190..*','192.30.201..*','192.30.203..*','192.30.204..*','192.30.210..*','192.30.224..*',
				'192.30.227..*','192.30.244..*','192.30.246..*',
				'192.30.249..*','192.30.250..*','192.31.15..*','192.31.47..*','192.31.49..*','192.31.50..*','192.31.60..*','192.31.91..*','192.31.93..*','192.31.94..*','192.31.103..*','192.31.104..*','192.31.109..*','192.31.110..*','192.31.125..*','192.31.126..*','192.31.144..*',
				'192.31.157..*','192.31.163..*','192.31.165..*','192.31.177..*','192.31.178..*','192.31.182..*','192.31.188..*','192.31.190..*','192.31.208..*','192.31.214..*','192.31.228..*','192.31.234..*','192.31.237..*','192.31.242..*','192.31.244..*','192.31.251..*','192.31.255..*',
				'192.33.0..*','192.33.11..*','192.33.17..*','192.33.18..*','192.33.22..*','192.33.32..*','192.33.34..*','192.33.132..*','192.33.136..*','192.33.139..*','192.33.146..*','192.33.167..*','192.33.168..*','192.33.191..*','192.33.252..*','192.33.255..*','192.34.16..*','192.34.18..*',
				'192.34.24..*','192.34.26..*','192.34.32..*','192.34.34..*','192.34.48..*','192.34.51..*','192.34.68..*','192.34.73..*','192.34.74..*','192.34.88..*','192.34.91..*','192.34.104..*','192.34.106..*','192.34.117..*','192.34.118..*','192.34.144..*','192.34.146..*','192.34.168..*',
				'192.34.170..*','192.34.176..*','192.34.178..*','192.34.180..*','192.34.196..*','192.34.198..*','192.34.213..*','192.34.215..*','192.34.232..*','192.34.245..*','192.34.246..*','192.35.61..*','192.35.85..*','192.35.104..*','192.35.127..*','192.35.139..*','192.35.140..*',
				'192.35.157..*','192.35.158..*','192.35.181..*','192.35.199..*','192.35.249..*','192.35.250..*','192.35.252..*','192.35.255..*','192.40.4..*','192.40.6..*','192.40.23..*','192.40.24..*','192.40.26..*','192.40.28..*','192.40.30..*','192.40.40..*','192.40.42..*','192.40.44..*',
				'192.40.46..*','192.40.49..*','192.40.50..*','192.40.52..*','192.40.55..*','192.40.60..*','192.40.62..*','192.40.64..*','192.40.66..*','192.40.68..*','192.40.81..*','192.40.82..*','192.40.108..*','192.40.110..*','192.40.117..*','192.40.118..*','192.40.140..*','192.40.142..*',
				'192.40.152..*','192.40.154..*','192.40.157..*','192.40.158..*','192.40.200..*','192.40.202..*','192.40.216..*','192.40.218..*','192.40.229..*','192.40.230..*','192.40.244..*','192.40.247..*','192.40.250..*','192.40.252..*','192.40.255..*','192.41.102..*','192.41.138..*',
				'192.41.177..*','192.41.200..*','192.41.226..*','192.41.228..*','192.41.248..*','192.42.0..*','192.42.2..*','192.42.71..*','192.42.72..*','192.42.74..*','192.42.96..*','192.42.110..*','192.42.112..*','192.42.147..*','192.42.155..*','192.42.205..*','192.42.241..*',
				'192.42.246..*','192.42.251..*','192.42.255..*','192.43.0..*','192.43.186..*','192.43.190..*','192.43.206..*','192.43.215..*','192.43.223..*','192.43.224..*','192.43.230..*','192.43.232..*','192.43.238..*','192.43.242..*','192.43.246..*','192.43.255..*','192.44.68..*',
				'192.44.70..*','192.44.255..*','192.47.253..*','192.47.255..*','192.48.82..*','192.48.98..*','192.48.101..*','192.48.102..*','192.48.105..*','192.48.136..*','192.48.138..*','192.48.140..*','192.48.142..*','192.48.210..*','192.48.218..*','192.48.220..*','192.48.223..*',
				'192.48.230..*','192.48.233..*','192.48.236..*','192.48.239..*','192.48.240..*','192.48.243..*','192.48.255..*','192.51.48..*','192.51.192..*','192.52.74..*','192.52.109..*','192.52.114..*','192.52.118..*','192.52.158..*','192.52.162..*','192.52.166..*','192.52.168..*',
				'192.52.192..*','192.52.227..*','192.52.228..*','192.52.241..*','192.52.242..*','192.52.250..*','192.52.255..*','192.54.53..*','192.54.76..*','192.54.92..*','192.54.123..*','192.54.136..*','192.54.140..*','192.54.227..*','192.54.229..*','192.54.252..*','192.54.255..*',
				'192.55.0..*','192.55.82..*','192.55.85..*','192.55.96..*','192.55.104..*','192.55.119..*','192.55.120..*','192.55.128..*','192.55.130..*','192.55.191..*','192.55.192..*','192.55.200..*','192.55.205..*','192.55.215..*','192.55.217..*','192.55.225..*','192.55.231..*',
				'192.55.241..*','192.55.242..*','192.55.245..*','192.55.247..*','192.55.250..*','192.58.0..*','192.58.90..*','192.58.96..*','192.58.118..*','192.58.131..*','192.58.132..*','192.58.137..*','192.58.138..*','192.58.148..*','192.58.193..*','192.58.198..*','192.58.214..*',
				'192.58.219..*','192.58.252..*','192.58.255..*','192.64.0..*','192.64.2..*','192.64.18..*','192.64.29..*','192.64.30..*','192.64.36..*','192.64.39..*','192.64.70..*','192.64.89..*','192.64.90..*','192.64.97..*','192.64.98..*','192.64.124..*','192.64.126..*','192.64.156..*',
				'192.64.160..*','192.64.165..*','192.64.166..*','192.64.196..*','192.64.199..*','192.64.200..*','192.64.206..*','192.64.224..*','192.65.0..*','192.65.50..*','192.65.79..*','192.65.81..*','192.65.133..*','192.65.134..*','192.65.138..*','192.65.141..*','192.65.154..*',
				'192.65.168..*','192.65.170..*','192.65.172..*','192.65.178..*','192.65.181..*','192.65.213..*','192.65.229..*','192.65.230..*','192.65.247..*','192.65.255..*','192.67.0..*','192.67.2..*','192.67.5..*','192.67.7..*','192.67.10..*','192.67.36..*','192.67.38..*','192.67.40..*',
				'192.67.54..*','192.67.64..*','192.67.66..*','192.67.68..*','192.67.72..*','192.67.75..*','192.67.88..*','192.67.131..*','192.67.159..*','192.67.164..*','192.67.166..*','192.67.169..*','192.67.172..*','192.67.185..*','192.67.188..*','192.67.222..*','192.67.224..*',
				'192.67.250..*','192.67.253..*','192.67.255..*','192.68.24..*','192.68.29..*','192.68.116..*','192.68.149..*','192.68.150..*','192.68.157..*','192.68.158..*','192.68.163..*','192.68.164..*','192.68.178..*','192.68.188..*','192.68.190..*','192.68.203..*','192.68.208..*',
				'192.68.234..*','192.68.255..*','192.69.1..*','192.69.2..*','192.69.20..*','192.69.22..*','192.69.44..*','192.69.47..*','192.69.65..*','192.69.66..*','192.69.72..*','192.69.75..*','192.69.81..*','192.69.82..*','192.69.85..*','192.69.86..*','192.69.100..*','192.69.102..*',
				'192.69.113..*','192.69.114..*','192.69.118..*','192.69.129..*','192.69.130..*','192.69.141..*','192.69.143..*','192.69.148..*','192.69.159..*','192.69.188..*','192.69.191..*','192.69.228..*','192.69.232..*','192.69.235..*','192.69.244..*','192.69.246..*','192.70.131..*',
				'192.70.163..*','192.70.164..*','192.70.191..*','192.70.214..*','192.70.220..*','192.70.243..*','192.70.246..*','192.70.255..*','192.72.0..*','192.72.2..*','192.72.255..*','192.73.0..*','192.73.11..*','192.73.18..*','192.73.23..*','192.73.45..*','192.73.54..*','192.73.69..*',
				'192.73.80..*','192.73.214..*','192.73.223..*','192.74.127..*','192.74.136..*','192.75.0..*','192.75.11..*','192.75.62..*','192.75.106..*','192.75.135..*','192.75.136..*','192.75.187..*','192.75.188..*','192.75.190..*','192.75.196..*','192.75.199..*','192.75.209..*',
				'192.75.211..*','192.75.255..*','192.76.4..*','192.76.117..*','192.76.118..*','192.76.120..*','192.76.133..*','192.76.180..*','192.76.185..*','192.76.255..*','192.77.0..*','192.77.20..*','192.77.22..*','192.77.111..*','192.77.128..*','192.77.145..*','192.77.180..*',
				'192.77.182..*','192.77.184..*','192.77.187..*','192.77.235..*','192.78.0..*','192.80.8..*','192.80.25..*','192.80.26..*','192.80.28..*','192.80.45..*','192.80.58..*','192.80.60..*','192.80.63..*','192.80.74..*','192.80.76..*','192.80.80..*','192.80.204..*','192.80.206..*',
				'192.80.214..*','192.80.255..*','192.81.9..*','192.81.10..*','192.81.49..*','192.81.50..*','192.81.56..*','192.81.58..*','192.81.60..*','192.81.63..*','192.81.64..*','192.81.66..*','192.81.70..*','192.81.72..*','192.81.75..*','192.81.84..*','192.81.86..*','192.81.89..*',
				'192.81.90..*','192.81.96..*','192.81.98..*','192.81.108..*','192.81.110..*','192.81.112..*','192.81.115..*','192.81.120..*','192.81.122..*','192.81.140..*','192.81.142..*','192.81.161..*','192.81.162..*','192.81.164..*','192.81.167..*','192.81.180..*','192.81.191..*',
				'192.81.193..*','192.81.195..*','192.81.228..*','192.81.231..*','192.81.232..*','192.81.235..*','192.81.254..*','192.82.102..*','192.82.109..*','192.82.122..*','192.82.144..*','192.82.146..*','192.82.152..*','192.82.209..*','192.82.210..*','192.82.232..*','192.82.242..*',
				'192.82.245..*','192.82.246..*','192.83.103..*','192.83.110..*','192.83.112..*','192.83.156..*','192.83.164..*','192.83.201..*','192.83.205..*','192.83.222..*','192.83.245..*','192.83.254..*','192.84.0..*','192.84.4..*','192.84.6..*','192.84.23..*','192.84.34..*',
				'192.84.52..*','192.84.54..*','192.84.100..*','192.84.110..*','192.84.126..*','192.84.175..*','192.84.209..*','192.84.225..*','192.84.249..*','192.84.255..*','192.86.0..*','192.86.21..*','192.86.22..*','192.86.81..*','192.86.122..*','192.86.130..*','192.86.160..*',
				'192.86.255..*','192.88.0..*','192.88.15..*','192.88.16..*','192.88.18..*','192.88.20..*','192.88.50..*','192.88.96..*','192.88.100..*','192.88.109..*','192.88.121..*','192.88.126..*','192.88.134..*','192.88.155..*','192.88.178..*','192.88.186..*','192.88.198..*',
				'192.88.255..*','192.91.0..*','192.91.139..*','192.91.144..*','192.91.198..*','192.91.204..*','192.91.234..*','192.91.249..*','192.91.255..*','192.92.8..*','192.92.17..*','192.92.85..*','192.92.87..*','192.92.97..*','192.92.102..*','192.92.117..*','192.92.140..*',
				'192.92.157..*','192.92.176..*','192.92.182..*','192.92.186..*','192.92.193..*','192.92.196..*','192.92.212..*','192.92.214..*','192.92.235..*','192.94.0..*','192.94.49..*','192.94.66..*','192.94.70..*','192.94.72..*','192.94.110..*','192.94.124..*','192.94.153..*',
				'192.94.166..*','192.94.203..*','192.94.204..*','192.94.206..*','192.94.251..*','192.95.64..*','192.95.66..*','192.96.0..*','192.96.17..*','192.96.18..*','192.96.23..*','192.96.36..*','192.96.41..*','192.96.42..*','192.96.44..*','192.96.59..*','192.96.62..*',
				'192.96.73..*','192.96.78..*','192.96.103..*','192.96.135..*','192.96.136..*','192.96.143..*','192.96.145..*','192.96.156..*','192.96.159..*','192.96.176..*','192.96.192..*','192.96.233..*','192.96.244..*','192.96.255..*','192.100.0..*','192.100.29..*','192.100.82..*',
				'192.100.87..*','192.100.157..*','192.100.171..*','192.100.177..*','192.100.182..*','192.100.186..*','192.100.198..*','192.100.206..*','192.100.214..*','192.100.228..*','192.100.247..*','192.100.248..*','192.100.251..*','192.100.252..*','192.100.254..*','192.100.255..*',
				'192.101.0..*','192.101.5..*','192.101.9..*','192.101.10..*','192.101.32..*','192.101.45..*','192.101.46..*','192.101.72..*','192.101.74..*','192.101.79..*','192.101.138..*','192.101.143..*','192.101.160..*','192.101.174..*','192.101.199..*','192.101.255..*','192.102.0..*',
				'192.102.15..*','192.102.85..*','192.102.86..*','192.102.222..*','192.102.254..*','192.103.0..*','192.103.11..*','192.103.12..*','192.103.26..*','192.103.131..*','192.103.249..*','192.103.250..*','192.104.0..*','192.104.4..*','192.104.20..*','192.104.38..*','192.104.49..*',
				'192.104.73..*','192.104.111..*','192.104.136..*','192.104.148..*','192.104.151..*','192.104.159..*','192.104.160..*','192.104.162..*','192.104.243..*','192.104.255..*','192.107.0..*','192.107.6..*','192.107.111..*','192.107.120..*','192.107.133..*','192.107.135..*',
				'192.107.144..*','192.107.255..*','192.108.50..*','192.108.127..*','192.108.227..*','192.108.232..*','192.108.239..*','192.108.254..*','192.109.45..*','192.109.75..*','192.109.92..*','192.109.99..*','192.109.103..*','192.109.104..*','192.109.120..*','192.110.0..*',
				'192.110.150..*','192.110.153..*','192.110.155..*','192.110.169..*','192.110.170..*','192.110.220..*','192.110.222..*','192.110.255..*','192.111.0..*','192.111.31..*','192.111.37..*','192.111.38..*','192.111.54..*','192.111.84..*','192.111.111..*','192.111.214..*',
				'192.111.224..*','192.111.230..*','192.111.251..*','192.111.253..*','192.111.255..*','192.112.0..*','192.112.23..*','192.112.29..*','192.112.35..*','192.112.37..*','192.112.69..*','192.112.148..*','192.112.150..*','192.112.180..*','192.112.255..*','192.119.0..*',
				'192.119.2..*','192.119.132..*','192.119.134..*','192.120.0..*','192.122.0..*','192.122.149..*','192.122.150..*','192.122.201..*','192.122.202..*','192.122.204..*','192.122.206..*','192.122.215..*','192.122.255..*','192.124.0..*','192.124.18..*','192.124.23..*',
				'192.124.29..*','192.124.30..*','192.124.44..*','192.124.119..*','192.124.126..*','192.124.129..*','192.124.132..*','192.124.156..*','192.124.165..*','192.124.166..*','192.124.168..*','192.124.224..*','192.124.236..*','192.124.249..*','192.124.255..*','192.126.0..*',
				'192.126.69..*','192.126.70..*','192.129.0..*','192.129.70..*','192.129.76..*','192.129.78..*','192.129.99..*','192.129.111..*','192.131.0..*','192.131.4..*','192.131.21..*','192.131.44..*','192.131.88..*','192.131.107..*','192.131.110..*','192.131.134..*',
				'192.131.136..*','192.131.233..*','192.131.234..*','192.131.255..*','192.132.0..*','192.132.5..*','192.132.8..*','192.132.27..*','192.132.28..*','192.132.30..*','192.132.32..*','192.132.44..*','192.132.59..*','192.132.61..*','192.132.62..*','192.132.205..*','192.132.212..*',
				'192.132.243..*','192.132.255..*','192.133.0..*','192.133.4..*','192.133.6..*','192.133.13..*','192.133.16..*','192.133.26..*','192.133.45..*','192.133.47..*','192.133.49..*','192.133.72..*','192.133.75..*','192.133.80..*','192.133.82..*','192.133.85..*','192.133.90..*',
				'192.133.101..*','192.133.106..*','192.133.247..*','192.133.248..*','192.133.255..*','192.135.0..*','192.135.39..*','192.135.50..*','192.135.54..*','192.135.60..*','192.135.62..*','192.135.93..*','192.135.109..*','192.135.110..*','192.135.123..*','192.135.136..*',
				'192.135.188..*','192.135.194..*','192.135.196..*','192.135.199..*','192.135.204..*','192.135.206..*','192.135.218..*','192.135.223..*','192.135.224..*','192.135.230..*','192.135.248..*','192.135.251..*','192.135.255..*','192.136.0..*','192.136.36..*','192.136.53..*',
				'192.136.103..*','192.136.104..*','192.136.113..*','192.136.116..*','192.136.118..*','192.136.135..*','192.136.157..*','192.136.158..*','192.138.0..*','192.138.9..*','192.138.10..*','192.138.99..*','192.138.133..*','192.138.148..*','192.138.161..*','192.138.164..*',
				'192.138.189..*','192.138.206..*','192.138.209..*','192.138.210..*','192.138.212..*','192.138.218..*','192.138.227..*','192.138.255..*','192.139.0..*','192.139.3..*','192.139.5..*','192.139.18..*','192.139.20..*','192.139.62..*','192.139.128..*','192.139.131..*',
				'192.139.132..*','192.139.139..*','192.139.147..*','192.139.189..*','192.139.192..*','192.139.205..*','192.139.255..*','192.140.0..*','192.145.231..*','192.146.0..*','192.146.113..*','192.146.118..*','192.146.130..*','192.146.138..*','192.146.154..*','192.146.186..*',
				'192.146.190..*','192.146.199..*','192.146.229..*','192.146.230..*','192.146.255..*','192.147.0..*','192.147.2..*','192.147.24..*','192.147.37..*','192.147.70..*','192.147.116..*','192.147.148..*','192.147.210..*','192.147.218..*','192.147.231..*','192.147.241..*',
				'192.147.255..*','192.148.104..*','192.148.106..*','192.148.111..*','192.148.173..*','192.148.219..*','192.148.254..*','192.149.0..*','192.149.8..*','192.149.10..*','192.149.17..*','192.149.23..*','192.149.39..*','192.149.55..*','192.149.58..*','192.149.67..*',
				'192.149.72..*','192.149.76..*','192.149.84..*','192.149.88..*','192.149.90..*','192.149.95..*','192.149.96..*','192.149.104..*','192.149.115..*','192.149.210..*','192.149.219..*','192.149.234..*','192.149.245..*','192.149.246..*','192.149.253..*','192.149.254..*',
				'192.150.0..*','192.150.41..*','192.150.42..*','192.150.44..*','192.150.46..*','192.150.48..*','192.150.50..*','192.150.57..*','192.150.73..*','192.150.74..*','192.150.77..*','192.150.85..*','192.150.86..*','192.150.116..*','192.150.123..*','192.150.142..*',
				'192.150.151..*','192.150.160..*','192.150.174..*','192.150.185..*','192.150.207..*','192.150.211..*','192.150.213..*','192.150.214..*','192.150.244..*','192.150.255..*','192.151.0..*','192.151.130..*','192.152.0..*','192.152.10..*','192.152.22..*','192.152.24..*',
				'192.152.28..*','192.152.66..*','192.152.79..*','192.152.91..*','192.152.110..*','192.152.118..*','192.152.129..*','192.152.130..*','192.152.132..*','192.152.135..*','192.152.152..*','192.152.157..*','192.152.158..*','192.152.180..*','192.152.192..*','192.152.203..*',
				'192.152.213..*','192.152.214..*','192.152.224..*','192.152.255..*','192.153.0..*','192.153.6..*','192.153.14..*','192.153.25..*','192.153.46..*','192.153.52..*','192.153.117..*','192.153.120..*','192.153.155..*','192.153.184..*','192.153.186..*','192.153.255..*',
				'192.154.0..*','192.154.3..*','192.154.7..*','192.154.13..*','192.154.14..*','192.154.26..*','192.154.59..*','192.154.80..*','192.154.124..*','192.154.126..*','192.154.131..*','192.155.0..*','192.155.7..*','192.155.8..*','192.155.69..*','192.155.70..*','192.155.158..*',
				'192.156.157..*','192.156.164..*','192.156.190..*','192.156.196..*','192.156.216..*','192.156.218..*','192.156.230..*','192.156.232..*','192.156.235..*','192.156.236..*','192.156.238..*','192.156.240..*','192.156.251..*','192.156.255..*','192.157.0..*','192.157.6..*',
				'192.157.18..*','192.157.28..*','192.157.30..*','192.157.39..*','192.157.74..*','192.158.0..*','192.158.3..*','192.158.25..*','192.158.26..*','192.158.62..*','192.158.214..*','192.158.253..*','192.158.255..*','192.159.0..*','192.159.8..*','192.159.31..*','192.159.37..*',
				'192.159.38..*','192.159.68..*','192.159.91..*','192.159.93..*','192.159.116..*','192.159.119..*','192.159.120..*','192.159.123..*','192.159.142..*','192.160.0..*','192.160.24..*','192.160.45..*','192.160.48..*','192.160.50..*','192.160.54..*','192.160.66..*','192.160.101..*',
				'192.160.102..*','192.160.111..*','192.160.128..*','192.160.188..*','192.160.215..*','192.160.250..*','192.160.255..*','192.161.0..*','192.161.5..*','192.161.6..*','192.161.38..*','192.161.66..*','192.161.130..*','192.162.204..*','192.163.0..*','192.163.21..*','192.163.22*',
				'192.168.0..*','192.169.5..*','192.169.6..*','192.169.10..*','192.169.19..*','192.169.42..*','192.169.66..*','192.170.129..*','192.170.130..*','192.171.0..*','192.171.6..*','192.171.13..*','192.171.14..*','192.171.18..*','192.171.114..*','192.172.224..*','192.172.233..*',
				'192.172.240..*','192.172.255..*','192.173.0..*','192.173.5..*','192.173.6..*','192.173.13..*','192.173.14..*','192.173.25..*','192.173.26..*','192.174.0..*','192.174.15..*','192.174.69..*','192.174.70..*','192.175.0..*','192.175.6..*','192.175.13..*','192.175.14..*',
				'192.175.22..*','192.175.49..*','192.175.50..*','192.184.5..*','192.184.6..*','192.187.26..*','192.187.62..*','192.188.0..*','192.188.2..*','192.188.8..*','192.188.84..*','192.188.88..*','192.188.91..*','192.188.95..*','192.188.120..*','192.188.123..*','192.188.176..*',
				'192.188.183..*','192.188.201..*','192.188.223..*','192.188.251..*','192.188.255..*','192.189.0..*','192.189.2..*','192.189.4..*','192.189.6..*','192.189.12..*','192.189.21..*','192.189.25..*','192.189.26..*','192.189.28..*','192.189.40..*','192.189.59..*','192.189.78..*',
				'192.189.85..*','192.189.152..*','192.189.200..*','192.189.204..*','192.189.248..*','192.189.255..*','192.190.0..*','192.190.7..*','192.190.15..*','192.190.20..*','192.190.30..*','192.190.32..*','192.190.42..*','192.190.92..*','192.190.94..*','192.190.188..*','192.190.206..*',
				'192.190.225..*','192.190.226..*','192.190.255..*','192.195.0..*','192.195.3..*','192.195.4..*','192.195.32..*','192.195.36..*','192.195.77..*','192.195.78..*','192.195.84..*','192.195.109..*','192.195.173..*','192.195.174..*','192.195.203..*','192.195.237..*',
				'192.195.242..*','192.195.251..*','192.195.253..*','192.195.255..*','192.196.0..*','192.197.58..*','192.197.89..*','192.197.91..*','192.197.92..*','192.197.122..*','192.197.156..*','192.197.207..*','192.197.245..*','192.197.255..*','192.198.8..*',
				'192.198.26..*','192.198.79..*','192.198.178..*','192.199.0..*','192.199.10..*','192.199.178..*','192.200.0..*','192.200.9..*','192.200.10..*','192.203.0..*','192.203.37..*','192.203.98..*','192.203.219..*','192.203.231..*','192.203.237..*','192.203.239..*',
				'192.203.253..*','192.203.254..*','192.206.0..*','192.206.8..*','192.206.18..*','192.206.36..*','192.206.45..*','192.206.46..*','192.206.53..*','192.206.54..*','192.206.63..*','192.206.69..*','192.206.70..*','192.206.72..*','192.206.92..*','192.206.95..*',
				'192.206.96..*','192.206.110..*','192.206.136..*','192.206.183..*','192.206.202..*','192.206.204..*','192.206.238..*','192.206.255..*','192.207.0..*','192.207.12..*','192.207.16..*','192.207.18..*','192.207.34..*','192.207.49..*','192.207.55..*','192.207.59..*',
				'192.207.60..*','192.207.62..*','192.207.115..*','192.207.195..*','192.207.200..*','192.207.204..*','192.207.206..*','192.207.252..*','192.207.255..*','192.208.0..*','192.208.29..*','192.208.30..*','192.208.114..*','192.208.158..*','192.209.0..*','192.209.17..*',
				'192.209.18..*','192.209.62..*','192.210.0..*','192.210.11..*','192.210.42..*','192.211.0..*','192.211.11..*','192.211.46..*','192.214.97..*','192.214.98..*','192.219.0..*','192.219.250..*','192.219.255..*','192.222.0..*','192.222.9..*','192.222.10..*','192.222.101..*',
				'192.222.102..*','192.223.0..*','192.223.9..*','192.223.10..*','192.223.64..*','192.225.0..*','192.225.26..*','192.225.57..*','192.225.58..*','192.225.153..*','192.225.154..*','192.227.0..*','192.228.0..*','192.228.93..*','192.228.94..*','192.229.0..*','192.229.21..*',
				'192.229.22..*','192.231.0..*','192.231.5..*','192.231.35..*','192.231.36..*','192.231.65..*','192.231.84..*','192.231.114..*','192.231.116..*','192.231.120..*','192.231.134..*','192.231.155..*','192.231.175..*','192.231.176..*','192.231.188..*','192.231.214..*',
				'192.231.237..*','192.231.249..*','192.231.250..*','192.231.255..*','192.232.0..*','192.232.11..*','192.234.0..*','192.234.31..*','192.234.32..*','192.234.34..*','192.234.37..*','192.234.38..*','192.234.40..*','192.234.79..*','192.234.88..*','192.234.104..*','192.234.113..*',
				'192.234.118..*','192.234.120..*','192.234.158..*','192.234.192..*','192.234.202..*','192.234.204..*','192.234.221..*','192.234.255..*','192.236.0..*','192.236.9..*','192.236.10..*','192.236.26..*','192.238.0..*','192.238.11..*','192.240.47..*','192.243.33..*',
				'192.243.34..*','192.243.36..*','192.243.39..*','192.243.213..*','192.243.214..*','192.245.0..*','192.245.2..*','192.245.30..*','192.245.118..*','192.245.140..*','192.245.157..*','192.245.158..*','192.245.160..*','192.245.181..*','192.245.193..*','192.245.255..*',
				'192.247.0..*','192.247.11..*','192.250.20..*','192.250.29..*','192.251.0..*','192.251.17..*','192.251.18..*','192.251.104..*','192.251.106..*','192.251.128..*','192.251.198..*','192.251.200..*','192.251.237..*','192.251.238..*','192.252.240..*','192.253.0..*','192.253.201..*','192.253.202..*','193.17.70..*','193.17.224..*','193.22.244..*','193.25.122..*','193.25.194..*','193.26.14..*','193.27.76..*','193.28.43..*','193.28.255..*','193.30.40..*','193.30.166..*','193.32.128..*','193.32.176..*','193.32.192..*','193.33.40..*','193.41.47..*','193.43.94..*','193.43.149..*','193.53.105..*','193.57.128..*','193.58.237..*','193.58.248..*','193.104.67..*','193.104.153..*','193.105.95..*','193.105.96..*','193.105.121..*','193.105.162..*','193.107.208..*','193.108.20..*','193.108.26..*','193.108.215..*','193.109.219..*','193.110.0..*','193.110.93..*','193.111.168..*','193.143.97..*','193.161.255..*','193.164.134..*','193.164.222..*','193.164.248..*','193.169.170..*','193.169.238..*','193.176.42..*','193.178.170..*','193.193.162..*','193.193.164..*','193.193.182..*','193.194.155..*','193.200.16..*','193.200.56..*','193.200.194..*','193.201.38..*','193.201.114..*','193.201.149..*','193.202.31..*','193.227.122..*','193.239.154..*','193.239.160..*','193.243.161..*','193.254.244..*','194.0.104..*','194.0.221..*','194.0.248..*','194.4.64..*','194.8.48..*','194.8.86..*','194.9.18..*','194.9.184..*','194.9.216..*','194.9.222..*','194.26.114..*','194.28.44..*','194.30.176..*','194.31.52..*','194.31.255..*','194.33.88..*','194.38.0..*','194.41.1..*','194.50.46..*','194.50.235..*','194.55.152..*','194.60.205..*','194.105.60..*','194.110.200..*','194.116.228..*','194.126.154..*','194.126.176..*','194.145.113..*','194.146.70..*','194.149.93..*','194.150.180..*','194.153.73..*','194.153.80..*','194.153.102..*','194.153.157..*','194.153.185..*','194.176.99..*','194.213.10..*','194.213.17..*','194.242.22..*','194.242.56..*','194.246.100..*','194.247.182..*','194.247.186..*','195.5.96..*','195.5.176..*','195.8.102..*','195.35.102..*','195.35.104..*','195.35.119..*','195.39.214..*','195.49.232..*','195.54.170..*','195.60.88..*','195.80.230..*','195.85.248..*','195.88.150..*','195.88.234..*','195.95.130..*','195.177.108..*','195.177.194..*','195.184.72..*','195.191.176..*','195.191.198..*','195.226.215..*','195.234.82..*','195.234.92..*','195.238.243..*','195.242.187..*','195.244.14..*','195.245.96..*','195.246.219..*','195.248.240..*','195.254.154..*','196.2.224..*','196.6.104..*','196.6.112..*','196.6.174..*','196.6.176..*','196.6.208..*','196.6.216..*','196.6.224..*','196.6.232..*','196.10.51..*','196.10.56..*','196.10.122..*','196.10.140..*','196.10.148..*','196.10.214..*','196.11.32..*','196.11.63..*','196.11.80..*','196.11.103..*','196.11.135..*','196.11.150..*','196.11.152..*','196.11.175..*','196.11.176..*','196.11.189..*','196.11.190..*','196.11.206..*','196.11.231..*','196.11.234..*','196.11.250..*','196.11.255..*','196.13.0..*','196.13.101..*','196.13.102..*','196.13.104..*','196.13.112..*','196.13.121..*','196.13.122..*','196.13.124..*','196.13.126..*','196.13.133..*','196.13.134..*','196.13.136..*','196.13.161..*','196.13.169..*','196.13.173..*','196.13.174..*','196.13.176..*','196.13.186..*','196.13.191..*','196.13.192..*','196.13.201..*','196.13.202..*','196.13.204..*','196.13.206..*','196.13.208..*','196.13.223..*','196.13.242..*','196.13.244..*','196.13.252..*','196.28.9..*','196.32.8..*','196.32.16..*','196.32.248..*','196.40.112..*','196.40.176..*','196.41.64..*','196.42.128..*','196.43.252..*','196.47.192..*','196.49.2..*','196.49.4..*','196.49.8..*','196.49.16..*','196.49.32..*','196.49.64..*','196.49.128..*','196.50.0..*','196.60.0..*','196.64.0..*','196.128.0..*','196.192.16..*','196.192.48..*','196.192.72..*','196.192.84..*','196.192.88..*','196.192.116..*','196.192.120..*','196.192.126..*','196.192.128..*','196.192.136..*','196.192.144..*','196.192.160..*','196.192.192..*','196.200.192..*','196.201.0..*','196.201.8..*','196.201.96..*','196.201.232..*','196.202.160..*','196.202.224..*','196.207.64..*','196.207.128..*','196.216.24..*','196.216.96..*','196.216.132..*','196.216.136..*','196.216.204..*','196.216.215..*','196.216.216..*','196.216.224..*','196.220.128..*','196.223.29..*','196.223.144..*','196.224.0..*','196.250.0..*','198.12.32..*','198.17.110..*','198.17.120..*','198.17.231..*','198.17.232..*','198.18.0..*','198.23.26..*','198.49.128..*',
				'201.87.232..*','201.130.16..*','201.130.81..*','201.130.82..*','201.130.84..*','201.130.88..*','201.131.6..*','201.131.10..*','201.131.24..*','201.131.37..*','201.131.38..*','201.131.41..*','201.131.42..*','201.131.45..*',
				'201.131.46..*','201.131.49..*','201.131.50..*','201.131.60..*','201.131.66..*','201.131.68..*','201.131.73..*','201.131.74..*','201.131.77..*','201.131.78..*','201.131.80..*','201.131.90..*','201.131.92..*','201.131.97..*',
				'201.131.98..*','201.131.101..*','201.131.102..*','201.131.106..*','201.131.110..*'
				,'198.49.132..*','198.50.16..*','198.51.100..*','198.58.8..*','198.58.12..*','198.72.6..*','198.89.86..*','198.89.186..*','198.89.188..*','198.90.6..*','198.90.14..*','198.90.74..*','198.91.14..*','198.91.22..*','198.91.42..*','198.91.74..*','198.96.4..*','198.96.220..*',
				'198.96.242..*','198.97.14..*','198.97.30..*','198.97.52..*','198.97.77..*','198.97.102..*','198.97.202..*','198.97.224..*','198.97.232..*','198.97.238..*','198.97.241..*','198.97.242..*','198.97.248..*','198.97.255..*','198.98.14..*','198.98.22..*','198.98.178..*',
				'198.99.26..*','198.100.22..*','198.100.42..*','198.100.94..*','198.101.26..*','198.102.70..*','198.102.80..*','198.105.14..*','198.105.26..*','198.105.158..*','198.133.128..*','198.133.167..*','198.134.6..*','198.134.14..*','198.134.208..*','198.134.255..*','198.135.47..*',
				'198.135.74..*','198.135.80..*','198.135.124..*','198.135.126..*','198.135.192..*','198.140.255..*','198.147.136..*','198.147.156..*','198.147.176..*','198.147.202..*','198.147.219..*','198.147.247..*','198.147.255..*','198.148.15..*','198.160.58..*','198.161.83..*',
				'198.161.239..*','198.169.10..*','198.169.62..*','198.169.172..*','198.180.198..*','198.185.26..*','198.185.62..*','198.186.6..*','199.4.161..*','199.4.190..*','199.4.255..*','199.5.26..*','199.5.137..*','199.5.147..*','199.5.189..*','199.5.194..*','199.5.201..*',
				'199.5.223..*','199.5.255..*','199.6.15..*','199.7.47..*','199.7.84..*','199.7.93..*','199.9.3..*','199.9.13..*','199.9.14..*','199.9.57..*','199.9.58..*','199.10.14..*','199.10.26..*','199.10.64..*','199.10.84..*','199.10.87..*','199.10.105..*','199.10.123..*','199.10.180..*',
				'199.10.202..*','199.10.253..*','199.10.254..*','199.15.26..*','199.15.74..*','199.15.89..*','199.15.90..*','199.16.31..*','199.19.58..*','199.21.15..*','199.26.53..*','199.26.54..*','199.26.65..*','199.26.66..*','199.26.136..*','199.26.164..*','199.26.183..*','199.26.184..*','199.26.190..*','199.26.192..*','199.26.219..*','199.26.220..*','199.26.242..*','199.26.255..*','199.27.6..*','199.27.30..*','199.30.46..*','199.33.26..*','199.33.66..*','199.33.76..*','199.33.78..*','199.33.80..*','199.33.82..*','199.33.89..*','199.33.90..*','199.33.93..*','199.33.94..*','199.33.116..*','199.33.118..*','199.33.143..*','199.33.210..*','199.33.218..*','199.33.226..*','199.33.230..*','199.33.232..*','199.33.255..*','199.34.114..*','199.36.10..*','199.36.26..*','199.38.25..*','199.38.26..*','199.38.143..*','199.38.148..*','199.38.158..*','199.43.114..*','199.43.184..*','199.43.195..*','199.43.196..*','199.43.198..*','199.43.206..*','199.43.224..*','199.43.255..*','199.47.15..*','199.47.37..*','199.47.38..*','199.48.13..*','199.48.14..*','199.58.13..*','199.58.14..*','199.59.6..*','199.59.31..*','199.59.42..*','199.60.63..*','199.60.100..*','199.60.116..*','199.60.232..*','199.60.255..*','199.66.30..*','199.68.6..*','199.68.14..*','199.68.26..*','199.68.53..*','199.68.54..*','199.71.93..*','199.71.159..*','199.71.186..*','199.71.209..*','199.71.255..*','199.73.25..*','199.73.81..*','199.74.162..*','199.74.205..*','199.74.255..*','199.79.172..*','199.79.185..*','199.79.231..*','199.79.241..*','199.79.255..*','199.83.25..*','199.84.255..*','199.85.7..*','199.85.63..*','199.85.98..*','199.85.200..*','199.85.244..*','199.85.255..*','199.87.1..*','199.88.130..*','199.88.141..*','199.88.191..*','199.88.245..*','199.88.253..*','199.88.255..*','199.89.49..*','199.89.129..*','199.89.139..*','199.89.149..*','199.89.194..*','199.89.220..*','199.89.224..*','199.101.42..*','199.103.26..*','199.103.100..*','199.114.14..*','199.114.202..*','199.115.26..*','199.115.54..*','199.116.6..*','199.119.26..*','199.120.58..*','199.121.254..*','199.123.14..*','199.123.30..*','199.124.6..*','199.124.26..*','199.124.58..*','199.127.42..*','199.166.18..*','199.166.236..*','199.166.244..*','199.166.251..*','199.168.10..*','199.168.26..*','199.168.42..*','199.175.160..*','199.180.26..*','199.181.182..*','199.181.192..*','199.181.238..*','199.184.14..*','199.184.126..*','199.184.142..*','199.184.160..*','199.185.130..*','199.185.174..*','199.185.180..*','199.185.184..*','199.187.114..*','199.188.6..*','199.188.14..*','199.189.6..*','199.189.26..*','199.189.62..*','199.190.194..*','199.190.196..*','199.191.50..*','199.191.54..*','199.193.6..*','199.193.14..*','199.195.6..*','199.195.14..*','199.195.114..*','199.196.6..*','199.197.10..*','199.198.210..*','199.198.214..*','199.200.6..*','199.200.14..*','199.212.86..*','199.223.114..*','199.230.10..*','199.230.30..*','199.241.26..*','199.241.62..*','199.242.26..*','199.242.180..*','199.244.14..*','199.244.26..*','199.244.198..*','199.244.250..*','199.245.98..*','199.245.100..*','199.245.142..*','199.245.208..*','199.246.168..*','199.248.6..*','199.248.62..*','199.248.244..*','199.249.14..*','199.249.110..*','199.250.14..*','199.253.10..*','199.253.26..*','200.0.8..*','200.0.32..*','200.0.48..*','200.0.56..*','200.0.60..*','200.0.67..*','200.0.68..*','200.0.71..*','200.0.72..*','200.0.81..*','200.0.85..*','200.0.86..*','200.0.89..*','200.0.90..*','200.0.92..*','200.0.100..*','200.0.102..*','200.0.114..*','200.1.216..*','200.2.100..*','200.3.16..*','200.5.9..*','200.5.32..*','200.6.35..*','200.6.36..*','200.6.44..*','200.6.48..*','200.6.128..*','200.6.132..*','200.7.0..*','200.7.8..*','200.7.12..*','200.9.0..*','200.9.2..*','200.9.65..*','200.9.67..*','200.9.68..*','200.9.76..*','200.9.78..*','200.9.85..*','200.9.86..*','200.9.88..*','200.9.92..*','200.9.94..*','200.9.102..*','200.9.104..*','200.9.112..*','200.9.114..*','200.9.116..*','200.9.120..*','200.9.123..*','200.9.124..*','200.9.129..*','200.9.130..*','200.9.132..*','200.9.136..*','200.9.140..*','200.9.143..*','200.9.144..*','200.9.148..*','200.9.158..*','200.9.160..*','200.9.164..*','200.9.169..*','200.9.170..*','200.9.172..*','200.9.174..*','200.9.181..*','200.9.182..*','200.9.184..*','200.9.186..*','200.9.200..*','200.9.202..*','200.9.206..*','200.9.214..*','200.9.220..*','200.9.224..*','200.9.226..*','200.9.229..*','200.9.234..*','200.9.249..*','200.9.250..*','200.9.252..*','200.10.4..*','200.10.32..*','200.10.48..*','200.10.56..*','200.10.132..*','200.10.136..*','200.10.138..*','200.10.141..*','200.10.144..*','200.10.146..*','200.10.153..*','200.10.154..*','200.10.156..*','200.10.158..*','200.10.163..*','200.10.164..*','200.10.173..*','200.10.174..*','200.10.176..*','200.10.180..*','200.10.183..*','200.10.185..*','200.10.187..*','200.10.189..*','200.10.191..*','200.10.192..*','200.10.209..*','200.10.210..*','200.10.227..*','200.10.245..*','200.11.8..*','200.12.0..*','200.12.131..*','200.12.139..*','200.12.157..*','200.13.8..*','200.14.36..*','200.18.112..*','200.23.31..*','200.23.65..*','200.23.68..*','200.23.78..*','200.23.80..*','200.23.84..*','200.23.115..*','200.23.116..*','200.23.118..*','200.23.148..*','200.23.152..*','200.23.180..*','200.23.189..*','200.23.205..*','200.23.206..*','200.23.224..*','200.23.254..*','200.24.10..*','200.24.12..*','200.24.128..*','200.33.4..*','200.33.28..*','200.33.40..*','200.33.51..*','200.33.67..*','200.33.81..*','200.33.82..*','200.33.85..*','200.33.88..*','200.33.96..*','200.33.108..*','200.33.113..*','200.33.115..*','200.33.117..*','200.33.125..*','200.33.126..*','200.33.128..*','200.33.152..*','200.33.164..*','200.33.174..*','200.33.203..*','200.33.253..*','200.34.0..*','200.34.160..*','200.34.171..*','200.34.173..*','200.34.205..*','200.34.206..*','200.34.210..*','200.34.215..*','200.34.216..*','200.34.220..*','200.34.224..*','200.35.156..*','200.39.64..*','200.39.160..*','200.49.32..*','200.52.16..*','200.52.144..*','200.53.8..*','200.53.16..*','200.53.192..*','200.59.208..*','200.63.104..*','200.66.112..*','200.77.176..*','200.79.184..*','200.94.240..*','200.95.172..*','200.95.176..*','200.95.192..*','200.107.96..*','200.126.49..*','200.126.50..*','200.126.52..*','200.126.56..*','200.142.176..*','200.188.0..*','200.188.128..*','200.189.8..*','200.189.42..*','200.189.44..*','200.192.105..*','200.192.106..*','200.192.234..*','200.192.236..*','200.194.0..*','200.196.128..*','200.215.160..*','200.219.148..*','200.219.156..*','200.225.0..*','200.225.96..*','200.225.128..*','200.229.80..*','200.229.144..*','200.229.208..*','200.229.250..*','200.229.252..*','200.236.64..*','200.239.0..*','201.7.164..*','201.7.168..*','201.7.208..*','201.55.192..*','201.71.0..*','201.71.192..*','201.77.96..*','201.77.144..*',
				'201.131.113..*','201.131.114..*','201.131.118..*','201.131.121..*','201.131.122..*','201.131.124..*','201.131.136..*','201.131.144..*','201.131.160..*','201.131.208..*','201.131.224..*','201.131.236..*','201.131.240..*',
				'201.131.250..*','201.139.80..*','201.139.172..*','201.139.184..*','201.139.216..*','201.140.208..*','201.140.224..*','201.142.128..*','201.148.96..*','201.148.160..*','201.148.208..*','201.148.224..*','201.149.96..*',
				'201.150.12..*','201.150.16..*','201.150.48..*','201.150.80..*','201.150.96..*','201.150.144..*','201.150.160..*','201.157.192..*','201.158.8..*','201.158.20..*','201.158.24..*','201.158.40..*','201.158.48..*','201.158.108..*',
				'201.158.120..*','201.159.8..*','201.159.24..*','201.159.44..*','201.159.52..*','201.159.56..*','201.159.72..*','201.159.84..*','201.159.88..*','201.159.108..*','201.159.112..*','201.159.144..*','201.159.168..*',
				'201.159.180..*','201.159.184..*','201.159.216..*','201.159.248..*','201.161.64..*','201.162.64..*','201.162.128..*','201.166.192..*','201.169.0..*','201.175.48..*','201.175.64..*','201.219.232..*','201.219.240..*','201.219.248..*',
				'203.0.113..*','204.9.28..*','204.10.112..*','204.10.160..*','204.11.112..*','204.13.212..*','204.13.252..*','204.14.0..*','204.14.80..*','204.16.212..*','204.28.104..*','204.44.140..*','204.48.54..*','204.48.56..*','204.48.112..*',
				'204.62.52..*','204.63.144..*','204.63.214..*','204.77.128..*','204.86.116..*','204.87.205..*','204.89.16..*','204.89.24..*','204.110.188..*','204.115.224..*','204.124.88..*','204.124.116..*','204.124.140..*','204.128.130..*','204.139.56..*',
				'204.153.0..*','204.153.120..*','204.153.122..*','204.153.128..*','204.154.124..*','204.154.200..*','204.154.248..*','204.174.100..*','204.225.113..*','205.142.64..*','205.142.148..*','205.143.40..*','205.145.144..*','205.147.88..*','205.149.8..*',
				'205.151.210..*','205.153.208..*','205.166.22..*','205.172.120..*','205.173.78..*','205.173.126..*','205.175.210..*','205.175.212..*','205.175.216..*','205.189.36..*','205.189.44..*','205.196.24..*','205.207.148..*','205.210.20..*','205.210.164..*',
				'205.211.166..*','206.41.72..*','206.41.104..*','206.51.33..*','206.51.240..*','206.53.136..*','206.53.168..*','206.53.200..*','206.55.172..*','206.71.8..*','206.71.136..*','206.72.212..*','206.72.216..*','206.80.232..*','206.81.104..*',
				'206.82.104..*','206.83.8..*','206.83.40..*','206.83.136..*','206.83.228..*','206.108.114..*','206.123.28..*','206.124.40..*','206.124.104..*','206.125.200..*','206.126.72..*','206.126.200..*','206.126.226..*','206.126.232..*','206.126.242..*',
				'206.126.246..*','206.126.248..*','206.126.251..*','206.126.252..*','206.126.255..*','206.127.136..*','206.127.168..*','206.130.4..*','206.130.6..*','206.130.10..*','206.130.15..*','206.130.22..*','206.130.62..*','206.130.65..*','206.130.85..*',
				'206.130.88..*','206.130.94..*','206.130.148..*','206.130.228..*','206.130.243..*','206.167.70..*','206.183.168..*','206.197.200..*','206.211.216..*','206.221.80..*','206.223.129..*','206.251.36..*','206.253.136..*','207.45.72..*','207.90.192..*',
				'207.126.136..*','207.174.128..*','207.174.131..*','207.174.132..*','207.174.144..*','207.174.152..*','207.174.158..*','207.174.160..*','207.174.168..*','207.174.192..*','207.174.200..*','207.174.204..*','207.174.208..*','207.174.212..*','207.174.216..*',
				'207.191.160..*','207.231.104..*','207.231.168..*','207.244.136..*','207.248.66..*','207.248.74..*','207.248.76..*','207.248.80..*','207.248.85..*','207.248.86..*','207.248.92..*','207.248.101..*','207.248.102..*','207.248.106..*','207.248.116..*',
				'207.248.121..*','207.248.123..*','207.248.124..*','207.248.192..*','208.66.224..*','208.67.28..*','208.67.212..*','208.68.252..*','208.70.180..*','208.73.100..*','208.77.140..*','208.78.224..*','208.79.120..*','208.79.160..*','208.83.224..*','208.85.32..*',
				'208.88.236..*','208.89.60..*','208.89.108..*','208.90.136..*','208.91.44..*','208.91.88..*','208.91.90..*','208.92.88..*','208.93.144..*','209.27.48..*','209.74.104..*','209.131.232..*','209.177.72..*','209.182.104..*','209.198.208..*','209.205.224..*',
				'209.251.24..*','212.87.192..*','213.5.232..*','213.108.240..*','213.150.192..*','213.172.128..*','213.173.32..*','213.217.0..*','216.10.224..*','216.10.232..*','216.10.234..*','216.10.236..*','216.21.4..*','216.21.8..*','216.21.12..*',
				'216.21.18..*','216.99.16..*','216.105.164..*','216.105.168..*','216.116.136..*','216.131.16..*','216.151.42..*','216.151.46..*','216.170.120..*','216.226.192..*','216.252.161..*','216.252.162..*','216.252.164..*','216.252.168..*','216.252.208..*','216.252.220..*',
				'217.29.128..*','217.29.208..*','217.78.64..*','224.0.0..*','240.0.0..*'
			);
			foreach($rb_blacklist_ips as $blacklistedip){
				if(eregi($blacklistedip,$_SERVER['REMOTE_ADDR'])){
					$ipaddress = false;
				}
			}
		}
			
		
		
		//http://snipplr.com/view/64564/
		function myoptionalmodules_checkdnsbl($ip){
			$dnsbl_lookup=array(
				'dnsbl-1.uceprotect.net',
				'dnsbl-2.uceprotect.net',
				'dnsbl-3.uceprotect.net',
				'dnsbl.sorbs.net',
				'zen.spamhaus.org',
				'dnsbl-2.uceprotect.net',
				'dnsbl-3.uceprotect.net'
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
		
		//http://stackoverflow.com/questions/2422482/how-do-i-create-a-tripcode-system
		function myoptionalmodules_tripcode($name){
			if(ereg("(#|!)(.*)", $name, $matches)){
				$cap  = $matches[2];
				$cap  = strtr($cap,"&amp;", "&");
				$cap  = strtr($cap,",", ",");
				$salt = substr($cap."H.",1,2);
				$salt = ereg_replace("[^\.-z]",".",$salt);
				$salt = strtr($salt,":;<=>?@[\\]^_`","ABCDEFGabcdef"); 
				return substr(crypt($cap,$salt),-10)."";
			}
		}
		
		//http://scottnix.com/thematic-snippets/
		if(get_option('MOM_themetakeover_backgroundimage') == 1){
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
		
		function myoptionalmodules_rsslinkback($content){
			return $content.'<p><a href="'.esc_url(get_permalink($post->ID)).'">'.htmlentities(get_post_field('post_title',$postid)).'</a> via <a href="'.esc_url(home_url('/')).'">'.get_bloginfo('site_name').'</a></p>';
		}
		
		function myoptionalmodules_footerscripts(){
			remove_action('wp_head','wp_print_scripts');
			remove_action('wp_head','wp_print_head_scripts',9);
			remove_action('wp_head','wp_enqueue_scripts',1);
		}
		
		function myoptionalmodules_disableauthorarchives(){
			global $wp_query;
			if(is_author()){
				if(sizeof(get_users('who=authors'))===1)
					wp_redirect(get_bloginfo('url'));
			}
		}
		
		function myoptionalmodules_disabledatearchives(){
			global $wp_query;
			if(is_date() || is_year() || is_month() || is_day() || is_time() || is_new_day()){
				$homeURL = esc_url(home_url('/'));
				if(have_posts()):the_post();
				header('location:'.$homeURL);
				exit;
				endif;
			}
		}
		
		// Stripping paint with a flame-thrower.
		function myoptionalmodules_sanistripents($string){
			return sanitize_text_field(strip_tags(htmlentities($string)));
		}
		
		function myoptionalmodules_numbersnospaces($string){
			return sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',($string)))))));
		}
		
		function myoptionalmodules_excludecategories(){
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
		
		function myoptionalmodules_add_fields_to_profile($profile_fields){
			$profile_fields['twitter_personal'] = 'Twitter Username';
			return $profile_fields;
		}
		function myoptionalmodules_add_fields_to_general(){
			register_setting('general','site_twitter','esc_attr');
			add_settings_field('site_twitter','<label for="site_twitter">'.__('Twitter Site username','site_twitter').'</label>' ,'myoptionalmodules_add_twitter_to_general_html','general');
		}
		function myoptionalmodules_add_twitter_to_general_html(){
			$twitter = get_option('site_twitter','');
			echo '<input id="site_twitter" name="site_twitter" value="'.$twitter.'"/>';
		}
		
		function myoptionalmodules_main_control_install(){
			if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){
				$availableCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890./';
				$generateSalt = '';
				for($i = 0; $i < 22; $i++){
					$generateSalt .= $availableCharacters[rand(0, strlen($availableCharacters) - 1)];
				}
				add_option('mom_passwords_salt',$generateSalt);
			}
			else{
				update_option('mommaincontrol_momrups',0);
			}
			update_option('mommaincontrol_focus','');
			delete_option('momreviews_css');
			add_option('mommaincontrol_passwords_activated',1);					
			add_option('mommaincontrol_reviews_activated',1);
			add_option('mommaincontrol_shorts_activated',1);
		}
		
		if(get_option('mommaincontrol_momse') == 1 && get_option('MOM_themetakeover_youtubefrontpage') == ''){
				function myoptionalmodules_404Redirection(){
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
			add_action('wp','myoptionalmodules_404Redirection',1);
		}
		
		function myoptionalmodules_postasfront(){	
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
			if(!function_exists('is_login_page')){
				function is_login_page() {
					return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
				}		
			}
			if(!is_login_page()){
				if(!is_user_logged_in() && get_option('mommaincontrol_maintenance') == 1){
					$maintenanceURL = esc_url(get_option('momMaintenance_url'));
					if($maintenanceURL == ''){
						die('Maintenance mode currently active.  Please try again later.');
					}else{
						header('location:'.$maintenanceURL);exit;
					}
				}
			}
		}
		
		function myoptionalmodules_removeversion($src){
			if(strpos($src,'ver='.get_bloginfo('version')))
				$src = remove_query_arg('ver',$src);
			return $src;
		}
		
		function myoptionalmodules_scripts(){
			wp_register_style('font_awesome', plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.min.css');
			wp_enqueue_style('font_awesome');
		}
		
		function myoptionalmodules_postformats(){
			add_theme_support('post-formats', array('aside','gallery','link','image','quote','status','video','audio','chat'));
		}
	//
	
	
	
	

	// (B) (3) Plugin form handling
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
				$option = array('mommaincontrol_prettycanon','mommaincontrol_fixcanon','mommaincontrol_regularboard_activated','mommaincontrol_regularboard','mommaincontrol_votes_activated','mommaincontrol_protectrss','MOM_themetakeover_extend','MOM_themetakeover_backgroundimage',
				'MOM_themetakeover_topbar_search','MOM_themetakeover_topbar_share','MOM_themetakeover_topbar_color','mommaincontrol_footerscripts','mommaincontrol_authorarchives','mommaincontrol_datearchives','MOM_themetakeover_wowhead',
				'mom_passwords_salt','mommaincontrol_obwcountplus','mommaincontrol_momrups','mommaincontrol_momse','mommaincontrol_mompaf','mommaincontrol_momja','mommaincontrol_shorts','mommaincontrol_analytics','mommaincontrol_reviews',
				'mommaincontrol_fontawesome','mommaincontrol_versionnumbers','mommaincontrol_lazyload','mommaincontrol_meta','mommaincontrol_focus','mommaincontrol_maintenance','mommaincontrol_themetakeover','mommaincontrol_setfocus',
				'mommaincontrol','mompaf_post','obwcountplus_1_countdownfrom','obwcountplus_2_remaining','obwcountplus_3_total','obwcountplus_4_custom','rotating_universal_passwords_1','rotating_universal_passwords_2','rotating_universal_passwords_3',
				'rotating_universal_passwords_4','rotating_universal_passwords_5','rotating_universal_passwords_6','rotating_universal_passwords_7','rotating_universal_passwords_8','MOM_Exclude_VisitorCategories','MOM_Exclude_VisitorTags',
				'MOM_Exclude_Categories_Front','MOM_Exclude_Categories_TagArchives','MOM_Exclude_Categories_SearchResults','MOM_Exclude_Tags_Front','MOM_Exclude_Tags_CategoryArchives','MOM_Exclude_Tags_SearchResults','MOM_Exclude_PostFormats_Front',
				'MOM_Exclude_PostFormats_CategoryArchives','MOM_Exclude_PostFormats_TagArchives','MOM_Exclude_PostFormats_SearchResults','MOM_Exclude_Categories_RSS','MOM_Exclude_Tags_RSS','MOM_Exclude_PostFormats_RSS','MOM_Exclude_TagsSun',
				'MOM_Exclude_TagsMon','MOM_Exclude_TagsTue','MOM_Exclude_TagsWed','MOM_Exclude_TagsThu','MOM_Exclude_TagsFri','MOM_Exclude_TagsSat','MOM_Exclude_CategoriesSun','MOM_Exclude_CategoriesMon','MOM_Exclude_CategoriesTue','MOM_Exclude_CategoriesWed',
				'MOM_Exclude_CategoriesThu','MOM_Exclude_CategoriesFri','MOM_Exclude_CategoriesSat','MOM_Exclude_level0Categories','MOM_Exclude_level1Categories','MOM_Exclude_level2Categories','MOM_Exclude_level7Categories','MOM_Exclude_level0Tags',
				'MOM_Exclude_level1Tags','MOM_Exclude_level2Tags','MOM_Exclude_level7Tags','MOM_Exclude_URL','MOM_Exclude_URL_User','MOM_Exclude_PostFormats_Visitor','MOM_Exclude_NoFollow','simple_announcement_with_exclusion_cat_visitor',
				'simple_announcement_with_exclusion_tag_visitor','mommaincontrol_passwords_activated','MOM_themetakeover_youtubefrontpage','MOM_themetakeover_topbar','MOM_themetakeover_archivepage','MOM_themetakeover_fitvids','MOM_themetakeover_postdiv',
				'MOM_themetakeover_postelement','MOM_themetakeover_posttoggle','mommaincontrol_shorts_activated','jump_around_0','jump_around_1','jump_around_2','jump_around_3','jump_around_4','jump_around_5','jump_around_6','jump_around_7',
				'jump_around_8','mommaincontrol_reviews_activated','momanalytics_code','momreviews_css','momreviews_search','momMaintenance_url','mommaincontrol_votes');
				foreach ($option as &$value){
					delete_option($value);
				}
			}else{	
				if(isset($_POST['MOMsave'])){}
				if(isset($_POST['mom_prettycanon_mode_submit']))update_option('mommaincontrol_prettycanon',$_REQUEST['prettycanon']);
				if(isset($_POST['mom_fixcanon_mode_submit']))update_option('mommaincontrol_fixcanon',$_REQUEST['fixcanon']);
				if(isset($_POST['mom_regularboard_mode_submit']))update_option('mommaincontrol_regularboard',$_REQUEST['regularboard']);
				if(isset($_POST['mom_themetakeover_mode_submit']))update_option('mommaincontrol_themetakeover',$_REQUEST['themetakeover']);
				if(isset($_POST['mom_protectrss_mode_submit']))update_option('mommaincontrol_protectrss',$_REQUEST['protectrss']);
				if(isset($_POST['mom_footerscripts_mode_submit']))update_option('mommaincontrol_footerscripts',$_REQUEST['footerscripts']);
				if(isset($_POST['mom_author_archives_mode_submit']))update_option('mommaincontrol_authorarchives',$_REQUEST['authorarchives']);
				if(isset($_POST['mom_date_archives_mode_submit']))update_option('mommaincontrol_datearchives',$_REQUEST['datearchives']);
				if(isset($_POST['mom_votes_mode_submit']))update_option('mommaincontrol_votes',$_REQUEST['votes']);
				if(isset($_POST['mom_exclude_mode_submit']))update_option('mommaincontrol_momse',$_REQUEST['exclude']);
				if(isset($_POST['mom_passwords_mode_submit']))update_option('mommaincontrol_momrups',$_REQUEST['passwords']);
				if(isset($_POST['mom_reviews_mode_submit']))update_option('mommaincontrol_reviews',$_REQUEST['reviews']);
				if(isset($_POST['mom_shortcodes_mode_submit']))update_option('mommaincontrol_shorts',$_REQUEST['shortcodes']);
				if(isset($_POST['MOMclear']))update_option('mommaincontrol_focus','');
				if(isset($_POST['MOMthemetakeover']))update_option('mommaincontrol_focus','themetakeover');
				if(isset($_POST['MOMexclude']))update_option('mommaincontrol_focus','exclude');
				if(isset($_POST['MOMfontfa']))update_option('mommaincontrol_focus','fontfa');
				if(isset($_POST['MOMcount']))update_option('mommaincontrol_focus','count');
				if(isset($_POST['MOMjumparound']))update_option('mommaincontrol_focus','jumparound');
				if(isset($_POST['MOMpasswords']))update_option('mommaincontrol_focus','passwords');
				if(isset($_POST['MOMreviews']))update_option('mommaincontrol_focus','reviews');
				if(isset($_POST['MOMshortcodes']))update_option('mommaincontrol_focus','shortcodes');
				if(isset($_POST['mom_fontawesome_mode_submit']))update_option('mommaincontrol_fontawesome',$_REQUEST['mommaincontrol_fontawesome']);
				if(isset($_POST['mom_lazy_mode_submit']))update_option('mommaincontrol_lazyload',$_REQUEST['mommaincontrol_lazyload']);
				if(isset($_POST['mom_versions_submit']))update_option('mommaincontrol_versionnumbers',$_REQUEST['mommaincontrol_versionnumbers']);
				if(isset($_POST['mom_meta_mode_submit']))update_option('mommaincontrol_meta',$_REQUEST['mommaincontrol_meta']);
				if(isset($_POST['mom_maintenance_mode_submit']))update_option('mommaincontrol_maintenance',$_REQUEST['maintenanceMode']);
				if(isset($_POST['mom_analytics_mode_submit']))update_option('mommaincontrol_analytics',$_REQUEST['analytics']);
				if(isset($_POST['mom_postasfront_mode_submit']))update_option('mommaincontrol_mompaf',$_REQUEST['postasfront']);
				if(!get_option('mommaincontrol_mompaf'))add_option('mompaf_post',0);
				if(isset($_POST['mom_maintenance_mode_submit']))add_option('momMaintenance_url','');
				if(isset($_POST['mom_postasfront_post_submit'])){
					update_option('momMaintenance_url',$_REQUEST['momMaintenance_url']);
					update_option('momanalytics_code',$_REQUEST['momanalytics_code']);
					update_option('mompaf_post',$_REQUEST['mompaf_post']);
				}
				if(isset($_POST['mom_count_mode_submit'])){
					update_option('mommaincontrol_obwcountplus',$_REQUEST['countplus']);
					add_option('obwcountplus_1_countdownfrom',0);
					add_option('obwcountplus_2_remaining','remaining');
					add_option('obwcountplus_3_total','total');
				}
				if(isset($_POST['mom_jumparound_mode_submit'])){
					update_option('mommaincontrol_momja',$_REQUEST['jumparound']);
					add_option('jump_around_0','.post');
					add_option('jump_around_1','.entry-title');
					add_option('jump_around_2','.previous-link');
					add_option('jump_around_3','.next-link');
					add_option('jump_around_4',65);
					add_option('jump_around_5',83);
					add_option('jump_around_6',68);
					add_option('jump_around_7',90);
					add_option('jump_around_8',88);
				}
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
						ID BIGINT(22) NOT NULL AUTO_INCREMENT , 
						NAME TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						SHORTNAME TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						DESCRIPTION TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						RULES TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						SFW TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						MODS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						JANITORS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						POSTCOUNT BIGINT(22) NOT NULL ,
						LOCKED BIGINT(22) NOT NULL ,
						PRIMARY KEY  (ID)
						);";
						$regularboardSQLb = "CREATE TABLE $regularboard_posts(
						ID BIGINT(22) NOT NULL AUTO_INCREMENT , 
						PARENT BIGINT(22) NOT NULL ,
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
						STICKY TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						LOCKED TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						PASSWORD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						REPLYTO BIGINT(22) NOT NULL ,
						UP BIGINT(22) NOT NULL ,
						PRIMARY KEY  (ID)
						);";
						$regularboardSQLc = "CREATE TABLE $regularboard_users(
						ID BIGINT(22) NOT NULL AUTO_INCREMENT , 
						DATE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						IP INT(11) NOT NULL,
						THREAD BIGINT(22) NOT NULL  , 
						PARENT BIGINT(22) NOT NULL,
						BANNED INT(11) NOT NULL,
						MESSAGE TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						LENGTH TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						KARMA BIGINT(22) NOT NULL , 
						PASSWORD TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						HEAVEN TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						VIDEO TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
						BOARDS TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
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
				if(isset($_POST['mom_passwords_mode_submit'])){
					add_option('rotating_universal_passwords_1','');
					add_option('rotating_universal_passwords_2','');
					add_option('rotating_universal_passwords_3','');
					add_option('rotating_universal_passwords_4','');
					add_option('rotating_universal_passwords_5','');
					add_option('rotating_universal_passwords_6','');
					add_option('rotating_universal_passwords_7','');
					add_option('rotating_universal_passwords_8','7');
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
				if(isset($_POST['mom_postasfront_mode_submit'])){
					add_option('mompaf_post',0);
				}
				if(isset($_POST['mom_reviews_mode_submit'])){
					add_option('mommaincontrol_reviews_activated',1);
					add_option('momreviews_search','');
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
			}
			if(isset($_POST['reset_rups'])){
				delete_option('rotating_universal_passwords_1');delete_option('rotating_universal_passwords_2');delete_option('rotating_universal_passwords_3');delete_option('rotating_universal_passwords_4');delete_option('rotating_universal_passwords_5');delete_option('rotating_universal_passwords_6');delete_option('rotating_universal_passwords_7');	
				add_option('rotating_universal_passwords_1','');add_option('rotating_universal_passwords_2','');add_option('rotating_universal_passwords_3','');add_option('rotating_universal_passwords_4','');add_option('rotating_universal_passwords_5','');add_option('rotating_universal_passwords_6','');add_option('rotating_universal_passwords_7','');	
			}
			if(
			isset($_POST['delete_unused_terms']) || 
			isset($_POST['delete_post_revisions']) || 
			isset($_POST['delete_unapproved_comments']) || 
			isset($_POST['deleteAllClutter'])){
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
					update_option($k,$v);
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
	//

	
	
	
	
	// (C) Plugin settings
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
				my optional modules / <a href="http://www.onebillionwords.com/boards/?board=mom/">documentation + support</a> / <a href="http://wordpress.org/support/view/plugin-reviews/my-optional-modules">rate and review</a>
				<div class="myoptionalmodules">
				<section class="switches clear">
				<form method="post"><section><label class="configurationlabel" for="MOMclear">Home</label><input id="MOMclear" name="MOMclear" class="hidden" type="submit"></section></form>';
				if(get_option('mommaincontrol_reviews') == 1){echo '<form class="config" method="post"><section><label class="configurationlabel" for="MOMreviews">Reviews</label><i class="fa fa-cogs"></i><input id="MOMreviews" name="MOMreviews" class="hidden" type="submit"></section></form>';}else{echo '<form method="post" action="" name="momReviews"><label for="mom_reviews_mode_submit">Reviews</label>';if(get_option('mommaincontrol_reviews') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_reviews') == 1){echo '0';}else{echo '1';}echo '" name="reviews" /><input type="submit" id="mom_reviews_mode_submit" name="mom_reviews_mode_submit" value="Submit" class="hidden" /></form>';}
				if(get_option('mommaincontrol_obwcountplus') == 1){echo '<form class="config" method="post"><section><label class="configurationlabel" for="MOMcount"></i>Count++</label><i class="fa fa-cogs"></i><input id="MOMcount" name="MOMcount" class="hidden" type="submit"></section></form>';}else{echo '<form method="post" action="" name="momCount"><label for="mom_count_mode_submit">Count++</label>';if(get_option('mommaincontrol_obwcountplus') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_obwcountplus') == 1){echo '0';}else{echo '1';}echo '" name="countplus" /><input type="submit" id="mom_count_mode_submit" name="mom_count_mode_submit" value="Submit" class="hidden" /></form>';}
				if(get_option('mommaincontrol_momse') == 1){echo '<form class="config" method="post"><section><label class="configurationlabel" for="MOMexclude">Exclude</label><i class="fa fa-cogs"></i><input id="MOMexclude" name="MOMexclude" class="hidden" type="submit"></section></form>';}else{echo '<form method="post" action="" name="momExclude"><label for="mom_exclude_mode_submit">Exclude</label>';if(get_option('mommaincontrol_momse') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momse') == 1){echo '0';}else{echo '1';}echo '" name="exclude" /><input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" /></form>';}
				if(get_option('mommaincontrol_momja') == 1){echo '<form class="config" method="post"><section><label class="configurationlabel" for="MOMjumparound">Jump Around</label><i class="fa fa-cogs"></i><input id="MOMjumparound" name="MOMjumparound" class="hidden" type="submit"></section></form>';}else{echo '<form method="post" action="" name="momJumpAround"><label for="mom_jumparound_mode_submit">Jump Around</label>';if(get_option('mommaincontrol_momja') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momja') == 1){echo '0';}else{echo '1';}echo '" name="jumparound" /><input type="submit" id="mom_jumparound_mode_submit" name="mom_jumparound_mode_submit" value="Submit" class="hidden" /></form>';}
				if(get_option('mommaincontrol_shorts') == 1){echo '<form class="config" method="post"><section><label class="configurationlabel" for="MOMshortcodes"></i>Shortcodes</label><i class="fa fa-cogs"></i><input id="MOMshortcodes" name="MOMshortcodes" class="hidden" type="submit"></section></form>';}else{echo '<form method="post" action="" name="momShortcodes"><label for="mom_shortcodes_mode_submit">Shortcodes</label>';if(get_option('mommaincontrol_shorts') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_shorts') == 1){echo '0';}else{echo '1';}echo '" name="shortcodes" /><input type="submit" id="mom_shortcodes_mode_submit" name="mom_shortcodes_mode_submit" value="Submit" class="hidden" /></form>';}
				if(get_option('mommaincontrol_themetakeover') == 1){echo '<form class="config" method="post"><section><label class="configurationlabel" for="MOMthemetakeover"></i>Takeover</label><i class="fa fa-cogs"></i><input id="MOMthemetakeover" name="MOMthemetakeover" class="hidden" type="submit"></section></form>';}else{echo '<form method="post" action="" name="momThemTakeover"><label for="mom_themetakeover_mode_submit">Theme Takeover</label>';if(get_option('mommaincontrol_themetakeover') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_themetakeover') == 1){echo '0';}else{echo '1';}echo '" name="themetakeover" /><input type="submit" id="mom_themetakeover_mode_submit" name="mom_themetakeover_mode_submit" value="Submit" class="hidden" /></form>';}
				if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH && get_option('mommaincontrol_momrups') == 1){echo '<form class="config" method="post"><section><label class="configurationlabel" for="MOMpasswords">Passwords</label><i class="fa fa-cogs"></i><input id="MOMpasswords" name="MOMpasswords" class="hidden" type="submit"></section></form>';}else{if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){ echo '<form method="post" action="" name="momPasswords"><label for="mom_passwords_mode_submit">Passwords</label>';if(get_option('mommaincontrol_momrups') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momrups') == 1){echo '0';}else{echo '1';}echo '" name="passwords" /><input type="submit" id="mom_passwords_mode_submit" name="mom_passwords_mode_submit" value="Submit" class="hidden" /></form>';}}
				echo '
				<form method="post" action="" name="momVotes"><label for="mom_votes_mode_submit">Post votes</label>';if(get_option('mommaincontrol_votes') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_votes') == 1){echo '0';}else{echo '1';}echo '" name="votes" /><input type="submit" id="mom_votes_mode_submit" name="mom_votes_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="protectrss"><label for="mom_protectrss_mode_submit">&copy; RSS feed</label>';if(get_option('mommaincontrol_protectrss') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_protectrss') == 1){echo '0';}else{echo '1';}echo '" name="protectrss" /><input type="submit" id="mom_protectrss_mode_submit" name="mom_protectrss_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="fontawesome"><label for="mom_fontawesome_mode_submit">Font Awesome</label>';if(get_option('mommaincontrol_fontawesome') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_fontawesome') == 1){echo '0';}else{echo '1';}echo '" name="mommaincontrol_fontawesome" /><input type="submit" id="mom_fontawesome_mode_submit" name="mom_fontawesome_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="hidewpversions"><label for="mom_versions_submit">Hide WP Version</label>';if(get_option('mommaincontrol_versionnumbers') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_versionnumbers') == 1){echo '0';}else{echo '1';}echo '" name="mommaincontrol_versionnumbers" /><input type="submit" id="mom_versions_submit" name="mom_versions_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="footerscripts"><label for="mom_footerscripts_mode_submit">JS to footer</label>';if(get_option('mommaincontrol_footerscripts') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_footerscripts') == 1){echo '0';}else{echo '1';}echo '" name="footerscripts" /><input type="submit" id="mom_footerscripts_mode_submit" name="mom_footerscripts_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="lazyload"><label for="mom_lazy_mode_submit">Lazy Load</label>';if(get_option('mommaincontrol_lazyload') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_lazyload') == 1){echo '0';}else{echo '1';}echo '" name="mommaincontrol_lazyload" /><input type="submit" id="mom_lazy_mode_submit" name="mom_lazy_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="meta"><label for="mom_meta_mode_submit">Meta</label>';if(get_option('mommaincontrol_meta') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_meta') == 1){echo '0';}else{echo '1';}echo '" name="mommaincontrol_meta" /><input type="submit" id="mom_meta_mode_submit" name="mom_meta_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="authorarchives"><label for="mom_author_archives_mode_submit">Disable Authors</label>';if(get_option('mommaincontrol_authorarchives') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_authorarchives') == 1){echo '0';}else{echo '1';}echo '" name="authorarchives" /><input type="submit" id="mom_author_archives_mode_submit" name="mom_author_archives_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="datearchives"><label for="mom_date_archives_mode_submit">Disable Dates</label>';if(get_option('mommaincontrol_datearchives') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_datearchives') == 1){echo '0';}else{echo '1';}echo '" name="datearchives" /><input type="submit" id="mom_date_archives_mode_submit" name="mom_date_archives_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="regularboard"><label for="mom_regularboard_mode_submit">Regular Board</label>';if(get_option('mommaincontrol_regularboard') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_regularboard') == 1){echo '0';}else{echo '1';}echo '" name="regularboard" /><input type="submit" id="mom_regularboard_mode_submit" name="mom_regularboard_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="fixcanon"><label for="mom_fixcanon_mode_submit">Fix Canon</label>';if(get_option('mommaincontrol_fixcanon') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_fixcanon') == 1){echo '0';}else{echo '1';}echo '" name="fixcanon" /><input type="submit" id="mom_fixcanon_mode_submit" name="mom_fixcanon_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="prettycanon"><label for="mom_prettycanon_mode_submit">Pretty Canon</label>';if(get_option('mommaincontrol_prettycanon') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input class="hidden" type="text" value="';if(get_option('mommaincontrol_prettycanon') == 1){echo '0';}else{echo '1';}echo '" name="prettycanon" /><input type="submit" id="mom_prettycanon_mode_submit" name="mom_prettycanon_mode_submit" value="Submit" class="hidden" /></form>
				<form method="post" action="" name="momAnalytics"><label for="mom_analytics_mode_submit">Analytics</label>';if(get_option('mommaincontrol_analytics') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_analytics') == 1){echo '0';}else{echo '1';}echo '" name="analytics" /><input type="submit" id="mom_analytics_mode_submit" name="mom_analytics_mode_submit" class="hidden" value="Submit" /></form>
				<form method="post" action="" name="momMaintenance"><label for="mom_maintenance_mode_submit">Maintenance</label>';if(get_option('mommaincontrol_maintenance') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_maintenance') == 1){echo '0';}else{echo '1';}echo '" name="maintenanceMode" class="hidden" /><input type="submit" id="mom_maintenance_mode_submit" name="mom_maintenance_mode_submit" class="hidden" value="Submit" /></form>
				<form method="post" action="" name="mompaf"><label for="mom_postasfront_mode_submit">Post as Front</label>';if(get_option('mommaincontrol_mompaf') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_mompaf') == 1){echo '0';}else{echo '1';}echo '" name="postasfront" class="hidden" /><input type="submit" id="mom_postasfront_mode_submit" name="mom_postasfront_mode_submit" class="hidden" value="Submit" /></form>
				';
				if(!isset($_POST['mom_delete_step_one'])){
				echo '
				<form method="post" action="" name="mom_delete_step_one">
				<label for="mom_delete_step_one" class="onoff0">Uninstall</label>
				<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hidden" value="Submit" />
				</form>
				';
				}
				if(isset($_POST['mom_delete_step_one'])){
				echo '
					<form method="post" action="" name="MOM_UNINSTALL_EVERYTHING">
					<label for="MOM_UNINSTALL_EVERYTHING" class="onoff1">Confirm this</label>
					<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hidden" value="Submit" />
					</form>';
				}
				echo '
				</div>
				<div class="myoptionalmodules">
				<form method="post" action="">
				<section class="single left"><label>Analytics property ID</label><input onClick="this.select();" type="text" value="'.get_option('momanalytics_code').'" name="momanalytics_code" placeholder="UA-XXXXXXXX-X" /></section>
				<section class="single left"><label>URL for maintenance mode</label><input placeholder="http://url.tld" onClick="this.select();" type="text" value="'.get_option('momMaintenance_url').'" name="momMaintenance_url" /></section>
				<section class="single left"><label>Post as front</label><select name="mompaf_post" id="mompaf_0"><option value="0" ';$mompaf_post = get_option('mompaf_post');selected( $options['mompaf_post'], 0);echo '/>Latest post</option>';$showmeposts = get_posts(array('posts_per_page' => -1));foreach($showmeposts as $postsshown){echo '<option name="mompaf_post" id="mompaf_'.$postsshown->ID.'" value="'.$postsshown->ID.'"';$postID = $postsshown->ID;$selected = selected( $mompaf_post, $postID);echo '>'.$postsshown->post_title.'</option>';}echo '</select></section>
				<section class="single left"><label for="mom_postasfront_post_submit" class="save"><i class="fa fa-save"></i></label><input type="submit" id="mom_postasfront_post_submit" name="mom_postasfront_post_submit" value="Submit" class="hidden"></section>
				</form>
				</section>
				</div>
				<div class="myoptionalmodules">
				<section>
				<div class="large left">';
				my_optional_modules_cleaner_module();
				echo '
				</div>
				</section>
				';
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
						echo '<i class="fa fa-code"></i> The hash generated for this file is: <strong class="on">';
						$file = plugin_dir_path( __FILE__ ).'plugin.php';
						$file_handler = fopen($file,'r'); 
						$contents = fread($file_handler, filesize($file)); 
						fclose($file_handler); 
						$contents = esc_attr($contents);
						$contents = str_replace(array("\n","\t","\r"),"",$contents);
						echo hash('sha1',$contents);
						echo '</strong>';
					}
				}
			echo '</div>';
			}
		}
	//
		



	/****************************** SECTION D -/- (D0) Settings -/- Passwords */
		if(current_user_can('manage_options')){
			function my_optional_modules_passwords_module(){
				echo '<span class="moduletitle">
				<form method="post" action="" name="momPasswords"><label for="mom_passwords_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_momrups') == 1){echo '0';}else{echo '1';}echo '" name="passwords" /><input type="submit" id="mom_passwords_mode_submit" name="mom_passwords_mode_submit" value="Submit" class="hidden" /></form>		
				</span><div class="clear"></div><div class="settings">';
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
	//





	/****************************** SECTION D -/- (D1) Functions -/- Passwords */
		function rotating_universal_passwords_shortcode($atts, $content = null){
			if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){
				ob_start();
				global $passwordField;
				global $my_optional_modules_passwords_salt;
				$passwordField++;	
				global $ipaddress;
				if($ipaddress !== false){
					$RUPs_ip_addr = esc_sql($ipaddress);
					$RUPs_s32int = esc_sql(ip2long($RUPs_ip_addr));
					$RUPs_us32str = esc_sql(sprintf("%u",$RUPs_s32int));
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
								$RUPs_date = esc_sql(date('Y-m-d H:i:s'));
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
			}else{
				// Return nothing, the IP address is fake.
			}
		}
	//




	// (E) Reviews (settings page)
		if(current_user_can('manage_options')){
				function my_optional_modules_reviews_module(){
							function update_mom_reviews(){
								global $table_prefix,$wpdb;
								$reviews_table_name = $table_prefix.'momreviews';                        
								$reviews_type   = esc_sql($_REQUEST['reviews_type']);
								$reviews_link   = esc_url($_REQUEST['reviews_link']);
								$reviews_title  = esc_sql($_REQUEST['reviews_title']);
								$reviews_review = $_REQUEST['reviews_review'];
								$reviews_review = wpautop($reviews_review);
								$reviews_rating = esc_sql($_REQUEST['reviews_rating']);
								$reviews_rating = stripslashes_deep($reviews_rating);
								$reviews_type = stripslashes_deep($reviews_type);
								$reviews_title = stripslashes_deep($reviews_title);
								$wpdb->query("INSERT INTO $reviews_table_name (ID,TYPE,LINK,TITLE,REVIEW,RATING) VALUES ('','$reviews_type','$reviews_link','$reviews_title','$reviews_review','$reviews_rating')") ;
								echo '<meta http-equiv="refresh" content="0;url="'.plugin_basename(__FILE__).'" />';
							}
							if(isset($_POST['filterResults'])){
								$filter_type = esc_sql($_REQUEST['filterResults_type']);
								$filter_type_fetch = sanitize_text_field($filter_type);
								update_option('momreviews_search',$filter_type_fetch);
						}
						if(isset($_POST['reviewsubmit']))update_mom_reviews();
						function print_mom_reviews_form(){
							echo '
							<div class="settingsInput">
							<form method="post" class="addForm">
							<section>title<input type="text" name="reviews_title" placeholder="Enter title here"></section>
							<section>type<input type="text" name="reviews_type" placeholder="Review type"></section>
							<section>url<input type="text" name="reviews_link" placeholder="Relevant URL" ></section>
							<section class="editor">';
							wp_editor($content,$name = 'reviews_review',$id = 'reviews_review',$prev_id = 'title',$media_buttons = true, $tab_index = 2);
							echo '
							</section>
							<section><label>rating</label><input type="text" name="reviews_rating" placeholder="Your rating"></section>
							<section><input id="reviewsubmit" type="submit" value="Add review" name="reviewsubmit"/></section>
							</form>
							</div>
							</div>';
						}
						function reviews_page_content(){
							echo '
							<span class="moduletitle">
							<form method="post" action="" name="momReviews"><label for="mom_reviews_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_reviews') == 1){echo '0';}else{echo '1';}echo '" name="reviews" /><input type="submit" id="mom_reviews_mode_submit" name="mom_reviews_mode_submit" value="Submit" class="hidden" /></form>
							</span>
							<div class="settings clear">
							<div class="settingsInfo taller">
							<form method="post" class="reviews_item_form">
							<input type="text" name="filterResults_type" placeholder="Filter by type"';if(get_option('momreviews_search') != "")echo 'value="'.get_option('momreviews_search').'"';echo '>
							<input type="submit" name="filterResults" value="Accept">
							</form>';
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
								echo '
								<div class="momdata">
								<div class="reviewitem">
								<section class="id">id:'.$reviews_results->ID.'</section>
								<span class="review">'.$reviews_results->TITLE.'</span>';
								if(!isset($_POST['edit_'.$this_ID.''])){
									if(!isset($_POST['delete_'.$this_ID.''])){echo '<form action="" method="post"><input class="deleteSubmit" type="submit" name="delete_'.$this_ID.'" value="Delete"></form>';}
									else{echo '<form class="confirm" action="" method="post"><input type="submit" name="cancel" id"cancel" value="No"/><input class="deleteSubmit" type="submit" name="delete_confirm_'.$this_ID.'" value="Confirm"/></form>';}
									echo '<form method="post"><input class="editSubmit" type="submit" name="edit_'.$this_ID.'" value="Edit"></form>';
								}
								echo '
								<section class="type">type: '.$reviews_results->TYPE.'</section>
								</div>';
								if(isset($_POST['edit_'.$this_ID.''])){
									echo '
									<div class="editing">
									<form method="post" class="addForm">
									<section>title<input type="text" name="reviews_title_'.$this_ID.'" placeholder="Enter title here" value="'.$reviews_results->TITLE.'"/></section>
									<section>type<input type="text" name="reviews_type_'.$this_ID.'" placeholder="Review type" value="'.$reviews_results->TYPE.'"/></section>
									<section>url<input type="text" name="reviews_link_'.$this_ID.'" placeholder="Relevant URL" value="'.$reviews_results->LINK.'"/></section>
									<section class="editor">';
									$thisContent = $reviews_results->REVIEW;
									wp_editor($content = $thisContent,$name = 'edit_review_'.$this_ID.'',$id = 'edit_review_'.$this_ID.'',$prev_id = 'title',$media_buttons = true,$tab_index = 1);
									echo '
									</section>
									<section>rating<input type="text" name="reviews_rating_'.$this_ID.'" placeholder="Your rating" value="'.$reviews_results->RATING.'"/></section>
									<section><input id="submit_edit_'.$this_ID.'" type="submit" value="Save these edits" name="submit_edit_'.$this_ID.'"><input type="submit" name="cancel" id"cancel" value="Cancel these edits"/></section>
									</form>
									</div>';
								}
								if(isset($_POST['submit_edit_'.$this_ID.''])){
									global $table_prefix, $wpdb;
									$reviews_table_name = $table_prefix.'momreviews';                        
									$edit_type     = esc_sql($_REQUEST['reviews_type_'.$this_ID.'']);
									$edit_link     = esc_sql($_REQUEST['reviews_link_'.$this_ID.'']);
									$edit_title    = esc_sql($_REQUEST['reviews_title_'.$this_ID.'']);
									$edit_review   = $_REQUEST['edit_review_'.$this_ID.''];
									$edit_review   = wpautop($edit_review);
									$edit_rating   = esc_sql($_REQUEST['reviews_rating_'.$this_ID.'']);
									$edit_rating   = stripslashes_deep($edit_rating);
									$edit_type     = stripslashes_deep($edit_type);
									$edit_title    = stripslashes_deep($edit_title);
									$wpdb->query("UPDATE $reviews_table_name SET TYPE = '$edit_type', LINK = '$edit_link', TITLE = '$edit_title', REVIEW = '$edit_review', RATING = '$edit_rating' WHERE ID = $this_ID") ;
									echo '<meta http-equiv="refresh" content="0;url='.$current.'" />';
								}
								if(isset($_POST['delete_confirm_'.$this_ID.''])){
									$current = plugin_basename(__FILE__);
									$wpdb->query("DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID'");
									echo '<meta http-equiv="refresh" content="0;url='.$current.'" />';
								}
								if(isset($_POST['cancel'])){}
								echo '</div>';
							}
							echo '</div></div>';
							print_mom_reviews_form();
						}
					reviews_page_content();
				}
		}
	//
	
	
	
	
	// (E) (1) Reviews (shortcode)
		$mom_review_global = 0;
		function mom_reviews_shortcode($atts, $content = null){
			global $mom_review_global;
			$mom_review_global++;
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
			$id_fetch_att = esc_sql($id);
			if(is_numeric($id_fetch_att)){$id_fetch = $id_fetch_att;}
			$order_by     = esc_sql($orderby);
			$order_dir    = esc_sql($order);
			$result_type  = myoptionalmodules_sanistripents($type);
			$meta_show    = myoptionalmodules_sanistripents($meta);
			$expand_this  = myoptionalmodules_sanistripents($expand);
			$retract_this = myoptionalmodules_sanistripents($retract);
			$is_open      = myoptionalmodules_sanistripents($open);
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
				if($reviews_results->RATING == '.5') $reviews_results->RATING = '<i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '1') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '2') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '3') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '4') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
				if($reviews_results->RATING == '1.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '2.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '3.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>';
				if($reviews_results->RATING == '4.5') $reviews_results->RATING = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>';
				if($reviews_results->REVIEW != ''){$this_ID = $reviews_results->ID;echo '<div ';if($result_type != ''){echo 'id="'.esc_attr($result_type).'"';}echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="'.$this_ID.''.$mom_review_global.'" ';if($is_open == 1){echo ' checked';}echo '/><label for="'.$this_ID.''.$mom_review_global.'">';if($reviews_results->TITLE != ''){echo $reviews_results->TITLE;}echo '<span>'.$expand_this.'</span><span>'.$retract_this.'</span></label><section class="reviewed">';if($meta_show == 1){if($reviews_results->TYPE != ''){echo ' [ <em>'.$reviews_results->TYPE.'</em> ] ';}if($reviews_results->LINK != ''){echo ' [ <a href="'.esc_url($reviews_results->LINK).'">#</a> ] ';}}echo '<hr />'.$reviews_results->REVIEW;if($reviews_results->RATING != ''){echo ' <p>'.$reviews_results->RATING.'</p> ';}echo '</section></article></div>';}
				elseif($reviews_results->REVIEW == ''){$this_ID = $reviews_results->ID;echo '<div ';if($result_type != ''){echo 'id="'.esc_attr($result_type).'"';}echo ' class="momreview"><article class="block"><input type="checkbox" name="review" id="'.$this_ID.''.$mom_review_global.'" ';if($is_open == 1){echo ' checked';}echo '/><label>';if($reviews_results->TITLE != ''){if($reviews_results->LINK != ''){echo '<a href="'.esc_url($reviews_results->LINK).'">';}echo $reviews_results->TITLE;if($reviews_results->LINK != ''){echo '</a>';}}echo '<span>'.$reviews_results->RATING.'</span><span></span></label></article></div>';}
			}
			return ob_get_clean();
		}
	//




	/****************************** SECTION F -/- (F0) Settings -/- Shortcodes */
		if(current_user_can('manage_options')){
			function my_optional_modules_shortcodes_module(){
				echo "
					<span class=\"moduletitle\">";
					echo '
					<form method="post" action="" name="momShortcodes"><label for="mom_shortcodes_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_shorts') == 1){echo '0';}else{echo '1';}echo '" name="shortcodes" /><input type="submit" id="mom_shortcodes_mode_submit" name="mom_shortcodes_mode_submit" value="Submit" class="hidden" /></form>
					';
					echo "
					</span>
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
									</tbody>
									</table>
								</td>
							</tr>					
						</tbody>
					</table>
				</div>";
			}
		}
	//




	/****************************** SECTION F -/- (F1) Functions -/- Shortcodes */
		function mom_onthisday_template(){
			$current_day   = date('d');
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
				global $ipaddress;
				if($ipaddress !== false){
				$ipaddress = ip2long($ipaddress);
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
				$theBackground = esc_sql(myoptionalmodules_sanistripents($background));
				$theAge = esc_sql(myoptionalmodules_sanistripents($age));
				$isLogged = esc_sql(myoptionalmodules_sanistripents($logged));
				$theMessage = esc_sql(myoptionalmodules_sanistripents($message));
				$theAnswer = esc_sql(myoptionalmodules_sanistripents($answer));
				$failMessage = $fail;
				$isLogged = esc_sql(myoptionalmodules_sanistripents($logged));
				$isLogging = esc_sql(myoptionalmodules_sanistripents($logging));
				$attempts = esc_sql(myoptionalmodules_sanistripents($single));
				$correctResultMessage = esc_sql(myoptionalmodules_sanistripents($cmessage));
				$incorrectResultMessage = esc_sql(myoptionalmodules_sanistripents($imessage));
				$isDeactivated = esc_sql(myoptionalmodules_sanistripents($deactivate));
				$verificationID = $momverifier_verification_step.''.$thePostId;
				$statsMessage = esc_sql(myoptionalmodules_sanistripents($stats));
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
							<input style="clear:both;font-size:20px;width:100%;margin:0 auto;" type="submit" name="submit" class="submit clear" value="Submit">
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
			}else{
				// Return nothing, the IP address is fake.
			}
		}	
	//





	/****************************** SECTION G -/- (G0) Functions -/- Meta */
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
	//





/****************************** SECTION H -/- (H0) Settings -/- Theme Takeover */
		if(current_user_can('manage_options')){
			function my_optional_modules_theme_takeover_module(){
				$MOM_themetakeover_topbar = get_option('MOM_themetakeover_topbar');
				$MOM_themetakeover_extend = get_option('MOM_themetakeover_extend');
				$MOM_themetakeover_topbar_color = get_option('MOM_themetakeover_topbar_color');
				$MOM_themetakeover_topbar_search = get_option('MOM_themetakeover_topbar_search');
				$MOM_themetakeover_topbar_share = get_option('MOM_themetakeover_topbar_share');
				$MOM_themetakeover_backgroundimage = get_option('MOM_themetakeover_backgroundimage');
				$MOM_themetakeover_wowhead = get_option('MOM_themetakeover_wowhead');
				$showmepages = get_pages(); 		
				echo '
				<span class="moduletitle">
				<form method="post" action="" name="momThemTakeover"><label for="mom_themetakeover_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_themetakeover') == 1){echo '0';}else{echo '1';}echo '" name="themetakeover" /><input type="submit" id="mom_themetakeover_mode_submit" name="mom_themetakeover_mode_submit" value="Submit" class="hidden" /></form>
				</span><div class="clear"></div><div class="settings"><form method="post">
				<div class="clear"></div>
				<div class="exclude">
					<section><label for="MOM_themetakeover_youtubefrontpage">Youtube URL for 404s</label><input type="text" id="MOM_themetakeover_youtubefrontpage" name="MOM_themetakeover_youtubefrontpage" value="'.esc_url(get_option('MOM_themetakeover_youtubefrontpage')).'"></section>
					<section><hr /></section>
					<section><label for="MOM_themetakeover_fitvids"><a href="http://fitvidsjs.com/">Fitvid</a> .class</label><input type="text" id="MOM_themetakeover_fitvids" name="MOM_themetakeover_fitvids" value="'.esc_attr(get_option('MOM_themetakeover_fitvids')).'"></section>
					<section><hr /></section>
					<section><label for="MOM_themetakeover_postdiv">Post content .div</label><input type="text" placeholder=".entry" id="MOM_themetakeover_postdiv" name="MOM_themetakeover_postdiv" value="'.esc_attr(get_option('MOM_themetakeover_postdiv')).'"></section>
					<section><label for="MOM_themetakeover_postelement">Post title .element</label><input type="text" placeholder="h1" id="MOM_themetakeover_postelement" name="MOM_themetakeover_postelement" value="'.esc_attr(get_option('MOM_themetakeover_postelement')).'"></section>
					<section><label for="MOM_themetakeover_posttoggle">Toggle text</label><input type="text" placeholder="Toggle contents" id="MOM_themetakeover_posttoggle" name="MOM_themetakeover_posttoggle" value="'.esc_attr(get_option('MOM_themetakeover_posttoggle')).'"></section>
				</div>
				
				<div class="exclude">
					<section><label for="MOM_themetakeover_topbar">Enable navbar</label>
						<select id="MOM_themetakeover_topbar" name="MOM_themetakeover_topbar">
							<option value="1"'; selected($MOM_themetakeover_topbar, 1); echo '>Yes (top)</option>
							<option value="2"'; selected($MOM_themetakeover_topbar, 2); echo '>Yes (bottom)</option>
							<option value="0"'; selected($MOM_themetakeover_topbar, 0); echo '>No</option>
						</select>
					</section>
					<section><label for="MOM_themetakeover_extend">Extend navbar</label>
						<select id="MOM_themetakeover_extend" name="MOM_themetakeover_extend">
							<option value="1"'; selected($MOM_themetakeover_extend, 1); echo '>Yes</option>
							<option value="0"'; selected($MOM_themetakeover_extend, 0); echo '>No</option>
						</select>
					</section>			
					<section><label for="MOM_themetakeover_topbar_color">Navbar scheme</label>
						<select id="MOM_themetakeover_topbar_color" name="MOM_themetakeover_topbar_color">
							<option value="1"'; selected($MOM_themetakeover_topbar_color, 1); echo '>Dark</option>
							<option value="2"'; selected($MOM_themetakeover_topbar_color, 2); echo '>Light</option>
							<option value="4"'; selected($MOM_themetakeover_topbar_color, 4); echo '>Red</option>
							<option value="5"'; selected($MOM_themetakeover_topbar_color, 5); echo '>Green</option>
							<option value="6"'; selected($MOM_themetakeover_topbar_color, 6); echo '>Blue</option>
							<option value="7"'; selected($MOM_themetakeover_topbar_color, 7); echo '>Yellow</option>
							<option value="3"'; selected($MOM_themetakeover_topbar_color, 3); echo '>Default</option>
						</select>
					</section>			
					<section><label for="MOM_themetakeover_topbar_search">Enable search bar</label>
						<select id="MOM_themetakeover_topbar_search" name="MOM_themetakeover_topbar_search">
							<option value="0"'; selected($MOM_themetakeover_topbar_search, 0); echo '>No</option>
							<option value="1"'; selected($MOM_themetakeover_topbar_search, 1); echo '>Yes</option>
						</select>
					</section>						
					<section><label for="MOM_themetakeover_topbar_share">Share icons</label>
						<select id="MOM_themetakeover_topbar_share" name="MOM_themetakeover_topbar_share">
							<option value="0"'; selected($MOM_themetakeover_topbar_share, 0); echo '>No</option>
							<option value="1"'; selected($MOM_themetakeover_topbar_share, 1); echo '>Yes</option>
						</select>
					</section>						
					<section>
					<label for="MOM_themetakeover_archivepage">Archives page</label>
					<select name="MOM_themetakeover_archivepage" class="allpages" id="MOM_themetakeover_archivepage">
					<option value="">Home page</option>';
					
					foreach($showmepages as $pagesshown){
						echo '
						<option name="MOM_themetakeover_archivepage" id="mompaf_'.esc_attr($pagesshown->ID).'" value="'.esc_attr($pagesshown->ID).'"'; 
						$selectedarchivespage = $pagesshown->ID;
						$MOM_themetakeover_archivepage = get_option('MOM_themetakeover_archivepage');
						selected($MOM_themetakeover_archivepage, $selectedarchivespage); echo '>
						'.$pagesshown->post_title.'</option>';
					}
					
					echo '
					</select></section>
					<section><hr /></section>
					<section><label for="MOM_themetakeover_backgroundimage">Enable Custom BG Image</label>
						<select id="MOM_themetakeover_backgroundimage" name="MOM_themetakeover_backgroundimage">
							<option value="0"'; selected($MOM_themetakeover_backgroundimage, 0); echo '>No</option>
							<option value="1"'; selected($MOM_themetakeover_backgroundimage, 1); echo '>Yes</option>
						</select>
					</section>
					<section><hr /></section>
					<section><label for="MOM_themetakeover_wowhead">Enable Wowhead Tooltips (<a href="http://www.wowhead.com/tooltips">?</a>)</label>
						<select id="MOM_themetakeover_wowhead" name="MOM_themetakeover_wowhead">
							<option value="1"'; selected($MOM_themetakeover_wowhead, 1); echo '>Yes</option>
							<option value="0"'; selected($MOM_themetakeover_wowhead, 0); echo '>No</option>
						</select>
					</section>
				</div>
				<div class="exclude">
				<input id="momthemetakeoversave" type="submit" value="Save Changes" name="momthemetakeoversave" /></form>
				</div></div><div class="new"></div>';
			}
		}
	//
	
	
	
	
	
	/****************************** SECTION H -/- (H1) Functions -/- Theme Takeover */
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
				if(function_exists('myoptionalmodules_excludecategories'))myoptionalmodules_excludecategories();
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
	//




	// (I) Font Awesome (shortcode)
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
	//




	// (J) Count++ (settings page)
		if(current_user_can('manage_options')){
			function my_optional_modules_count_module(){
					echo '<span class="moduletitle">';
					echo '<form method="post" action="" name="momCount"><label for="mom_count_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_obwcountplus') == 1){echo '0';}else{echo '1';}echo '" name="countplus" /><input type="submit" id="mom_count_mode_submit" name="mom_count_mode_submit" value="Submit" class="hidden" /></form>';
					echo '</span><form method="post"><div class="clear"></div><div class="settings">';
					echo '<div class="countplus"><section><label for="obwcountplus_1_countdownfrom">Goal (<em>0</em> for none)</label><input id="obwcountplus_1_countdownfrom" type="text" value="'.esc_attr(get_option('obwcountplus_1_countdownfrom')).'" name="obwcountplus_1_countdownfrom"></section><section><label for="obwcountplus_2_remaining">Text for remaining</label><input id="obwcountplus_2_remaining" type="text" value="'.esc_attr(get_option('obwcountplus_2_remaining')).'" name="obwcountplus_2_remaining"></section><section><label for="obwcountplus_3_total">Text for published</label><input id="obwcountplus_3_total" type="text" value="'.esc_attr(get_option('obwcountplus_3_total')).'" name="obwcountplus_3_total"></section><section><label for="obwcountplus_4_custom">Custom output</label><input id="obwcountplus_4_custom" type="text" value="'.esc_attr(get_option('obwcountplus_4_custom')).'" name="obwcountplus_4_custom"></section></div>';
					echo '<input id="obwcountsave" type="submit" value="Save Changes" name="obwcountsave"></form><div class="templatetags"><section>Custom output example: (with goal)<span class="right">%total% words of %remain% published</span></section><section>Custom output example: (without goal) <span class="right">%total% words published</span></section><section>Custom output example: (numbers only)(total on blog) <span class="right">%total%</span></section><section>Custom output example: (numbers only)(total remain of goal) <span class="right">%remain%</span></section><section>Template tag: (single post word count)<span class="right"><code>obwcountplus_total();</code></span></section><section>Custom output:<span class="right"><code>countsplusplus();</code></span></section><section>Total words + remaining:<span class="right"><code>obwcountplus_count();</code></span></section><section>Total words:<span class="right"><code>obwcountplus_total();</code></span></section><section>Remainig:(displays total published if goal reached)<span class="right"><code>obwcountplus_remaining();</code></span></section></div><p class="creditlink">Count++ is adapted from <a href="http://wordpress.org/plugins/post-word-count/">Post Word Count</a> by <a href="http://profiles.wordpress.org/nickmomrik/">Nick Momrik</a>.</p>';
				}
			}
	//
	
	
	
	
	
/****************************** SECTION J -/- (J1) Functions -/- Count++ */
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
	//





/****************************** SECTION K -/- (K0) Settings -/- Exclude */
		if(current_user_can('manage_options')){
			function my_optional_modules_exclude_module(){
				$MOM_Exclude_PostFormats_RSS = get_option('MOM_Exclude_PostFormats_RSS');
				$MOM_Exclude_PostFormats_Front = get_option('MOM_Exclude_PostFormats_Front');
				$MOM_Exclude_PostFormats_CategoryArchives = get_option('MOM_Exclude_PostFormats_CategoryArchives');
				$MOM_Exclude_PostFormats_TagArchives = get_option('MOM_Exclude_PostFormats_TagArchives');
				$MOM_Exclude_PostFormats_SearchResults = get_option('MOM_Exclude_PostFormats_SearchResults');
				$MOM_Exclude_PostFormats_Visitor = get_option('MOM_Exclude_PostFormats_Visitor');
				$MOM_Exclude_Hide_Dashboard = get_option('MOM_Exclude_Hide_Dashboard');
				$MOM_Exclude_NoFollow = get_option('MOM_Exclude_NoFollow');
				$MOM_Exclude_URL = get_option('MOM_Exclude_URL');
				$MOM_Exclude_URL_User = get_option('MOM_Exclude_URL_User');			
				$showmepages = get_pages(); 			
				$showmecats = get_categories('taxonomy=category&hide_empty=0'); 
				$showmetags = get_categories('taxonomy=post_tag&hide_empty=0');
				echo '<span class="moduletitle">
				<form method="post" action="" name="momExclude"><label for="mom_exclude_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_momse') == 1){echo '0';}else{echo '1';}echo '" name="exclude" /><input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" /></form>
				</span><div class="clear"></div><div class="settings"><form method="post">
					<div class="listing">
					<div class="list"><span>Category (<strong>ID</strong>)</span>';
					foreach($showmecats as $catsshown){
						echo '
						<span>'.$catsshown->cat_name.'(<strong>'.$catsshown->cat_ID.'</strong>)</span>';
					}
				echo '
				</div>
				<div class="list"><span>Tag (<strong>ID</strong>)</span>';
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
				</div>
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
				<div class="exclude">
				<section><span class="left">hide post formats</span></section>
				<section class="break"><span class="right">from area</span></section>
				<section><hr/></section>
				<section>
					<label for="MOM_Exclude_PostFormats_RSS">RSS</label>
					<select name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
						<option value="">none</option>
						<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-aside'); echo '>Aside</option>
						<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-gallery'); echo '>Gallery</option>
						<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-link'); echo '>Link</option>
						<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-image'); echo '>Image</option>
						<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-quote'); echo '>Quote</option>
						<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-status'); echo '>Status</option>
						<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-video'); echo '>Video</option>
						<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-audio'); echo '>Audio</option>
						<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-chat'); echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_Front">front page</label>
					<select name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
						<option value="">none</option>
						<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Front, 'post-format-aside'); echo '>Aside</option>
						<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Front,'post-format-gallery'); echo '>Gallery</option>
						<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Front,'post-format-link'); echo '>Link</option>
						<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Front,'post-format-image'); echo '>Image</option>
						<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Front,'post-format-quote'); echo '>Quote</option>
						<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Front,'post-format-status'); echo '>Status</option>
						<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Front,'post-format-video'); echo '>Video</option>
						<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Front,'post-format-audio'); echo '>Audio</option>
						<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Front,'post-format-chat'); echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_CategoryArchives">archives</label>
					<select name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
						<option value="">none</option>
						<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_CategoryArchives, 'post-format-aside'); echo '>Aside</option>
						<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-gallery'); echo '>Gallery</option>
						<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-link'); echo '>Link</option>
						<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-image'); echo '>Image</option>
						<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-quote'); echo '>Quote</option>
						<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-status'); echo '>Status</option>
						<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-video'); echo '>Video</option>
						<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-audio'); echo '>Audio</option>
						<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-chat'); echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_TagArchives">tags</label>
					<select name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
						<option value="">none</option>
						<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-aside'); echo '>Aside</option>
						<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-gallery'); echo '>Gallery</option>
						<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-link'); echo '>Link</option>
						<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-image'); echo '>Image</option>
						<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-quote'); echo '>Quote</option>
						<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-status'); echo '>Status</option>
						<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-video'); echo '>Video</option>
						<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-audio'); echo '>Audio</option>
						<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-chat'); echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_SearchResults">search results</label>
					<select name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
						<option value="">none</option>
						<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-aside'); echo '>Aside</option>
						<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-gallery'); echo '>Gallery</option>
						<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-link'); echo '>Link</option>
						<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-image'); echo '>Image</option>
						<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-quote'); echo '>Quote</option>
						<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-status'); echo '>Status</option>
						<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-video'); echo '>Video</option>
						<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-audio'); echo '>Audio</option>
						<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-chat'); echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_Visitor">logged out</label>
					<select name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
						<option value="">none</option>
						<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-aside'); echo '>Aside</option>
						<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-gallery'); echo '>Gallery</option>
						<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-link'); echo '>Link</option>
						<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-image'); echo '>Image</option>
						<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-quote'); echo '>Quote</option>
						<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-status'); echo '>Status</option>
						<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-video'); echo '>Video</option>
						<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-audio'); echo '>Audio</option>
						<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-chat'); echo '>Chat</option>
					</select>
				</section>
				<section class="break"><span class="right">additional settings</span></section>
				<section><hr/></section>
				<section>
				<label for="MOM_Exclude_Hide_Dashboard">Hide Dash for all but admin</label>
				<select name="MOM_Exclude_Hide_Dashboard" class="allpages" id="MOM_Exclude_Hide_Dashboard">
				<option '; selected($MOM_Exclude_Hide_Dashboard, 1); echo 'value="1">Yes</option>
				<option '; selected($MOM_Exclude_Hide_Dashboard, 0); echo 'value="0">No</option>
				</select>
				</section>
				<section>
				<label for="MOM_Exclude_NoFollow">No Follow User Level Hidden</label>
				<select name="MOM_Exclude_NoFollow" class="allpages" id="MOM_Exclude_NoFollow">
				<option '; selected($MOM_Exclude_NoFollow, 1); echo 'value="1">Yes</option>
				<option '; selected($MOM_Exclude_NoFollow, 0); echo 'value="0">No</option>
				</select>
				</section>
				<section>
				<label for="MOM_Exclude_URL">Redirect 404s (logged in)</label>
				<select name="MOM_Exclude_URL" class="allpages" id="MOM_Exclude_URL">
					<option value="">Home page</option>';
					foreach($showmepages as $pagesshown){ echo '<option name="MOM_Exclude_URL" id="mompaf_'.$pagesshown->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownID = $pagesshown->ID; selected($MOM_Exclude_URL, $pagesshownID); echo '> '.$pagesshown->post_title.'</option>'; }
					echo '
				</select>
				</section>
				<section>
				<label for="MOM_Exclude_URL_User">Redirect 404s (logged out)</label>
				<select name="MOM_Exclude_URL_User" class="allpages" id="MOM_Exclude_URL_User">
					<option value=""/>Home page</option>';
					foreach($showmepages as $pagesshownuser){ echo '<option name="MOM_Exclude_URL_User" id="mompaf_'.$pagesshownuser->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownuserID = $pagesshownuser->ID; selected ($MOM_Exclude_URL_User, $pagesshownuserID); echo '> '.$pagesshownuser->post_title.'</option>';}
					echo '
				</select>
				</section>
				<input id="momsesave" type="submit" value="Save Changes" name="momsesave"></form></div></div>';
			}
		}
	//
	
	
	
	
	
/****************************** SECTION K -/- (K1) Settings -/- Exclude */
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
	//





	// (L) Jump Around (settings page)
		if(current_user_can('manage_options') && is_admin() && get_option('mommaincontrol_momja') == 1){
			function my_optional_modules_jump_around_module(){
				$o = array(0,1,2,3,4,5,6,7,8);
				$f = array(
					'Post container',
					'Permalink',
					'Previous Posts',
					'Next posts',
					'Previous Key',
					'Open current',
					'Next key',
					'Older posts key',
					'Newer posts key');
				$k = array(65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,48,49,50,51,52,53,54,55,56,57,37,38,39,40);
				$b = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9,'left arrow','up arrow','right arrow','down arrow');
				echo '
				<span class="moduletitle">
					<form method="post" action="" name="mom_jumparound_mode_submit"><label for="mom_jumparound_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_momja') == 1){echo '0';}else{echo '1';}echo '" name="jumparound" /><input type="submit" id="mom_jumparound_mode_submit" name="mom_jumparound_mode_submit" value="Submit" class="hidden" /></form>
				</span>
				<div class="countplus clear form">
				<p class="clear">jump around / <em>Thanks to <a href="http://stackoverflow.com/questions/1939041/change-hash-without-reload-in-jquery">jitter</a> &amp; <a href="http://stackoverflow.com/questions/13694277/scroll-to-next-div-using-arrow-keys">mVChr</a> for the help.</em></p>
				<p class="clear">Keyboard navigation on any area that isn\'t a single post or page view.</p>
				<p class="clear">Example(s): <em>.div, .div a, .div h1, .div h1 a</em></p>
				<form method="post">';
					foreach ($o as &$value){
						$text = str_replace($o,$f,$value);
						$label = 'jump_around_'.$value;
						if($value <= 3){
							echo '
							<section><label for="'.$label.'">'.$text.'</label>
							<input type="text" id="'.$label.'" name="'.$label.'" value="'.get_option($label).'" /></section>';
						}
						elseif($value == 4 || $value > 4){
							if($value == 4)echo '';
							echo '
							<section><label for="'.$label.'">'.$text.'</label>
							<select name="'.$label.'">';
								foreach($k as &$key){
									echo '
									<option value="'.$key.'"'; selected(get_option($label), ''.$key.''); echo '>'.str_replace($k,$b,$key).'</option>';
								}
							echo '
							</select></section>';
						}
					}
				echo '	
				
				<input id="update_JA" type="submit" value="Save" name="update_JA">
				</form>
				</div>';
			}
		}
	//
	




	// (M) Post Voting (functions)
		function vote_the_posts_top($atts,$content = null){
			extract(
				shortcode_atts(array(
					'amount' => 10
				), $atts)
			);	
			$amount = esc_sql(intval($amount));
			global $wpdb,$wp,$post;
			ob_start();
			wp_reset_query();
			$votesPosts = $wpdb->prefix.'momvotes_posts';
			$query_sql = "SELECT ID,UP from $votesPosts  WHERE UP > 1 ORDER BY UP DESC LIMIT $amount";
			$query_result = $wpdb->get_col( $wpdb->prepare ($query_sql, OBJECT));
			if ($query_result) {
				foreach ($query_result as $post_id) {
					$post = &get_post( $post_id );
					setup_postdata($post);
					echo '<li><a href="';the_permalink();echo'" rel="bookmark" title="Permanent Link to ';the_title_attribute();echo'">';the_title();echo'</a></li>';
				}
			}else{}
			wp_reset_query();
			return ob_get_clean();
		}
		
		if(get_option('mommaincontrol_votes') == 1){	
			add_shortcode('topvoted','vote_the_posts_top');
			add_filter('the_content','do_shortcode','vote_the_posts_top');
			function vote_the_post(){
				global $wpdb,$wp,$post;
				$votesPosts = $wpdb->prefix.'momvotes_posts';
				$votesVotes = $wpdb->prefix.'momvotes_votes';
					global $ipaddress;
					if($ipaddress !== false){
					$theIP         = esc_sql(esc_attr($ipaddress));
					$theIP_s32int  = esc_sql(esc_attr(ip2long($ipaddress)));
					$theIP_us32str = esc_sql(esc_attr(sprintf("%u",$theIP_s32int)));
					$theID         = esc_sql(intval($post->ID));
					$getID         = $wpdb->get_results("SELECT ID,UP,DOWN FROM $votesPosts WHERE ID = '".$theID."' LIMIT 1");
					if(count($getID) == 0){
						$wpdb->query("INSERT INTO $votesPosts (ID, UP, DOWN) VALUES ($theID,1,0)");
					}
					foreach($getID as $gotID){
						$votesTOTAL = intval($gotID->UP);
						$getIP = $wpdb->get_results("SELECT ID,IP,VOTE FROM $votesVotes WHERE ID = '".$theID."' AND IP = '".$theIP_us32str."' LIMIT 1");
						if(count($getIP) == 0) {
							if(isset($_POST[$theID.'-up-submit'])){
								$wpdb->query("UPDATE $votesPosts SET UP = UP + 1 WHERE ID = $theID");
								$wpdb->query("INSERT INTO $votesVotes (ID, IP, VOTE) VALUES ($theID,$theIP_us32str,1)");
							}
							echo '<div class="vote_the_post" id="'.esc_attr($theID).'">';
							echo '<form action="" id="'.esc_attr($theID).'-up" method="post"><label for="'.esc_attr($theID).'-up-submit" class="upvote"><i class="fa fa-heart"></i></label><input type="submit" name="'.esc_attr($theID).'-up-submit" id="'.esc_attr($theID).'-up-submit" /></form>';
							echo '<span>'.esc_attr($votesTOTAL).'</span>';
							echo '</div>';
						}else{
							foreach($getIP as $gotIP){
								$vote = esc_sql(esc_attr($gotIP->VOTE));
								if($vote == 1 && isset($_POST[$theID.'-up-submit'])){
									$wpdb->query("UPDATE $votesPosts SET UP = UP - 1 WHERE ID = $theID");
									$wpdb->query("DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = '$theID'");
								}
								if($vote == 1)$CLASS = ' active';
								echo '<div class="vote_the_post" id="'.esc_attr($theID).'">';
								echo '<form action="" id="'.esc_attr($theID).'-up" method="post"><label for="'.esc_attr($theID).'-up-submit" class="upvote"><i class="fa fa-heart'.$CLASS.'"></i></label><input type="submit" name="'.esc_attr($theID).'-up-submit" id="'.esc_attr($theID).'-up-submit" /></form>';
								echo '<span>'.esc_attr($votesTOTAL).'</span>';
								echo '</div>';
							}
						}			
					}		
				// Return nothing, the IP address is fake.
				}else{}
			}
		}
	//


	/****************************** SECTION N -/- (N0) Functions -/- Regular Board */
	include(plugin_dir_path(__FILE__) . '/includes/modules/regular_board.php');




	// (W) Database Cleaner (functions)
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
	//




	// (X) Plugin Javascript
		function myoptionalmodules_enqueuescripts(){
			function mom_jquery(){
				wp_deregister_script('jquery');
				wp_register_script('jquery', "http".($_SERVER['SERVER_PORT'] == 443 ? "s" : "")."://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js",'','', null, false);
				wp_enqueue_script('jquery');
				
				if(get_option('MOM_themetakeover_fitvids') != ''){
					$fitvids = plugins_url().'/my-optional-modules/includes/javascript/fitvids.js';
					wp_deregister_script('fitvids');
					wp_register_script('fitvids',$fitvids,'','',null,false);
					wp_enqueue_script('fitvids');
				}
				if(get_option('mommaincontrol_lazyload') == 1){
					$lazyLoad = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
					$lazyLoadFunctions = plugins_url().'/my-optional-modules/includes/javascript/lazyload.js';
					wp_deregister_script('lazyload');
					wp_register_script('lazyload',$lazyLoad,'','',null,false);
					wp_enqueue_script('lazyload');
					wp_deregister_script('lazyLoadFunctions');
					wp_register_script('lazyLoadFunctions',$lazyLoadFunctions,'','',null,false);
					wp_enqueue_script('lazyLoadFunctions');			
				}
				if(get_option('MOM_themetakeover_wowhead') == 1){
					$wowhead = '//static.wowhead.com/widgets/power.js';
					$tooltips = plugins_url().'/my-optional-modules/includes/javascript/wowheadtooltips.js';
					wp_deregister_script('wowhead');
					wp_register_script('wowhead',$wowhead,'','',null,false);
					wp_enqueue_script('wowhead');
					wp_deregister_script('wowheadtooltips');
					wp_register_script('wowheadtooltips',$wowheadtooltips,'','',null,false);
					wp_enqueue_script('wowheadtooltips');			
				}		
				global $wp,$post;
				$content = $post->post_content;
				$regularboard = plugins_url().'/my-optional-modules/includes/javascript/regularboard.js';
				if( has_shortcode( $content, 'regularboard' )){
					wp_deregister_script('regularboard');
					wp_register_script('regularboard',$regularboard,'','',null,false);
					wp_enqueue_script('regularboard');		
				}
				if(get_option('MOM_themetakeover_topbar') == 1){
					$stucktothetop = plugins_url().'/my-optional-modules/includes/javascript/stucktothetop.js';
					wp_deregister_script('stucktothetop');
					wp_register_script('stucktothetop',$stucktothetop,'','',null,false);
					wp_enqueue_script('stucktothetop');				
				}
				if(get_option('MOM_themetakeover_topbar') == 2){
					$stucktothebottom = plugins_url().'/my-optional-modules/includes/javascript/stucktothebottom.js';
					wp_deregister_script('stucktothebottom');
					wp_register_script('stucktothebottom',$stucktothebottom,'','',null,false);
					wp_enqueue_script('stucktothebottom');		
				}
			}
			add_action('wp_enqueue_scripts','mom_jquery');
			function MOMScriptsFooter(){
				if(get_option('mommaincontrol_analytics') == 1 && get_option('momanalytics_code') != '' || 
				get_option('mommaincontrol_momja') == 1 && is_archive() || 
				get_option('mommaincontrol_momja') == 1 && is_home() || 
				get_option('mommaincontrol_momja') == 1 && is_search() || 
				get_option('MOM_themetakeover_fitvids') != '' || 
				get_option('MOM_themetakeover_postdiv') != '' && get_option('MOM_themetakeover_postelement') != ''){
				echo '
				<script type=\'text/javascript\'>';
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
					echo '});</script>';
				}
			}
			add_action('wp_footer','MOMScriptsFooter',99999);
		}
	//




	// (Y) Quick press
		if(current_user_can('manage_options')){
			$css = plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/';
			add_action('wp_enqueue_admin_scripts','myoptionalmodules_scripts');		
			function momEditorScreen($post_type){
				$screen = get_current_screen();
				$edit_post_type = $screen->post_type;
				if($edit_post_type != 'post')
				if($edit_post_type != 'page')
				return;
					if(get_option('mommaincontrol_fontawesome') == 1){
					echo '
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
								<li class="clear"></li>';
								$icon = array('adjust','anchor','archive','arrows','arrows-h','arrows-v','asterisk',
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
								'youtube-square');
							foreach ($icon as &$value){
								echo '<li onclick="addText(event)" class="fa fa-'.$value.' icon"><span>&#60;i class="fa fa-'.$value.'"&#62;&#60;/i&#62;</span></li>';
							}
						echo '
						</ol>
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
	//




	// (Z) Etc
	//		Report all bugs to admin@regularboard.org
	//		Additional support can be provided to those who ask for it at the following URL:
	//		http://www.regularboard.org/
	//		Ends
	//
	
	
	

?>