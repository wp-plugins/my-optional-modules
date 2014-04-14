<?php 

/**
 * My Optional Modules Functions
 *
 * (1) Functions used throughout the plugin.
 *
 * @package regular_board
 */	

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

if ( !function_exists ( 'rb_apply_quotes' ) ) {
	function rb_apply_quotes($item){
		return "'" . mysql_real_escape_string($item) . "'";
	}
}

// Generate a random password 
$seed = str_split('abcdefghijklmnopqrstuvwxyz'
				 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
				 .'0123456789!@#$%^&*()');
shuffle($seed);
$rand = '';
foreach (array_rand($seed, 10) as $k) $rand .= $seed[$k];			
// Generate a random number
$seednum = str_split('1'.
					 '2'.
					 '3'.
					 '4'.
					 '5'.
					 '6');
shuffle($seednum);
$randnum1 = '';
$randnum2 = '';
foreach (array_rand($seednum, 2) as $rk) $randnum1 .= $seednum[$rk];
foreach (array_rand($seednum, 2) as $rk) $randnum2 .= $seednum[$rk];

if ( !function_exists ( 'rb_format' ) ) {
	function rb_format($data){
		$input = array(
			'/\\\r/is',
			'/\\\n/is',
			'/\    (.*?)    /is',
			'/\>\>(.*?)\>\>/is',
			'/\*\*\*(.*?)\*\*\*/is',
			'/\*\*(.*?)\*\*/is',
			'/\*(.*?)\*/is',
			'/\~\~(.*?)\~\~/is',
			'/\{\{(.*?)\}\}/is',
			'/-\-\-\-/is',
			'/—\-/is',
			'/\|/is',
			'/\`(.*?)\`/is',
			'/\[spoiler](.*?)\[\/spoiler]/is',
			'/\[http:\/\/i.imgur.com\/(.*?)]/is',
			'/\[http:\/\/imgur.com\/a\/(.*?)]/is',
			'/\[/is',
			'/\]/is',
			'/\\\/is',
		);
		$output = array(
			'<br />',
			'',
			'<span class="quotes"> &#62; $1 </span><br />',
			'<a href="#$1"> &#62;&#62; $1 </a><br />',
			'<strong><em>$1</em></strong>',
			'<strong>$1</strong>',
			'<em>$1</em>',
			'<span class="strike">$1</span>',
			'<blockquote>$1</blockquote>',
			'<hr />',
			'<hr />',
			'<br />',
			'<code>$1</code>',
			'<span class="spoiler">$1</span>',
			' <a href="http://i.imgur.com/$1"/><img src="http://i.imgur.com/$1" class="imageOP" /></a> ',
			'<iframe class="imgur-album" width="100%" height="550" frameborder="0" src="http://imgur.com/a/$1/embed"></iframe>',
			'&#91;',
			'&#93;',
			'',
		);
		$rtrn = preg_replace ($input, $output, $data);
		return wpautop($rtrn);
	}
}	

if ( !function_exists ( 'regularboard_html_cut' ) ) {
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
		while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length) {
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
				if ($is_open && !$in_double_quotes && !$in_single_quotes) {
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
				if ($is_open) {
					$is_open   = false;
					$grab_open = false;
					array_push($tags, $tag);
					$tag = "";
				}
				else if ($is_close) {
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
}

if ( !function_exists ( 'mom_canonical' ) ) {
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
			if($BOARD         != '' && $THREAD != 0    ){$canonical = $THISPAGE.'?b='.$BOARD.'&amp;t='.$THREAD;}
			elseif($BOARD     != '' && $THREAD == 0    ){$canonical = $THISPAGE.'?b='.$BOARD;}
		}
		elseif($prettycanon == 1 && is_page() && $_GET['board'] != '' || $prettycanon == 1 && is_single() && $_GET['board'] != ''){
			$THISPAGE          = home_url('/');
			if($_GET['board'] != ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents(preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['board']))));
			if($_GET['board'] == ''                    )$BOARD  = esc_sql(strtolower(myoptionalmodules_sanistripents($post->post_name)));
			if($BOARD         != ''                    )$THREAD = esc_sql(intval($_GET['thread']));	
			if($BOARD         != '' && $THREAD != 0    ){$canonical = $THISPAGE.'?t='.$THREAD;}
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
		echo '<link rel=\'canonical\' href=\''.htmlentities($canonical).'\' />';echo "\n";
	}
}

if ( !function_exists ( 'timesincethis' ) ) {
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
}

if(inet_pton($_SERVER['REMOTE_ADDR']) === false)$ipaddress = false;
if(inet_pton($_SERVER['REMOTE_ADDR']) !== false)$ipaddress = esc_attr($_SERVER['REMOTE_ADDR']);
if ( !function_exists ( 'myoptionalmodules_checkdnsbl' ) ) {
	function myoptionalmodules_checkdnsbl($ipaddress){
		$dnsbl_lookup=array(
			'dnsbl-1.uceprotect.net',
			'dnsbl-2.uceprotect.net',
			'dnsbl-3.uceprotect.net',
			'dnsbl.sorbs.net',
			'zen.spamhaus.org',
			'dnsbl-2.uceprotect.net',
			'dnsbl-3.uceprotect.net'
			);
		if($ipaddress){
			$reverse_ip=implode(".",array_reverse(explode(".",$ipaddress)));
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
}

if ( !function_exists ( 'myoptionalmodules_tripcode' ) ) {
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
}

if ( !function_exists ( 'MOM_themetakeover_backgroundimage' ) ) {
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
}

if ( !function_exists ( 'myoptionalmodules_rsslinkback' ) ) { 
	function myoptionalmodules_rsslinkback($content){
		return $content.'<p><a href="'.esc_url(get_permalink($post->ID)).'">'.htmlentities(get_post_field('post_title',$postid)).'</a> via <a href="'.esc_url(home_url('/')).'">'.get_bloginfo('site_name').'</a></p>';
	}
}

if ( !function_exists ( 'myoptionalmodules_footerscripts' ) ) {
	function myoptionalmodules_footerscripts(){
		remove_action('wp_head','wp_print_scripts');
		remove_action('wp_head','wp_print_head_scripts',9);
		remove_action('wp_head','wp_enqueue_scripts',1);
	}
}

if ( !function_exists ( 'myoptionalmodules_disableauthorarchives' ) ) {
	function myoptionalmodules_disableauthorarchives(){
		global $wp_query;
		if(is_author()){
			if(sizeof(get_users('who=authors'))===1)
			wp_redirect(get_bloginfo('url'));
		}
	}
}

if ( !function_exists ( 'myoptionalmodules_disabledatearchives' ) ) {
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
}

if ( !function_exists ( 'myoptionalmodules_sanistripents' ) ) {
	function myoptionalmodules_sanistripents($string){
		// Stripping paint with a flame-thrower.
		return sanitize_text_field(strip_tags(htmlentities($string)));
	}
}

if ( !function_exists ( 'myoptionalmodules_numbersnospaces' ) ) {
	function myoptionalmodules_numbersnospaces($string){
		return sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',($string)))))));
	}
}

if ( !function_exists ( 'myoptionalmodules_excludecategories' ) ) {
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
}

if ( !function_exists ( 'myoptionalmodules_add_fields_to_profile' ) ) {
	function myoptionalmodules_add_fields_to_profile($profile_fields){
		$profile_fields['twitter_personal'] = 'Twitter Username';
		return $profile_fields;
	}
}

if ( !function_exists ( 'myoptionalmodules_add_fields_to_general' ) ) {
	function myoptionalmodules_add_fields_to_general(){
		register_setting('general','site_twitter','esc_attr');
		add_settings_field('site_twitter','<label for="site_twitter">'.__('Twitter Site username','site_twitter').'</label>' ,'myoptionalmodules_add_twitter_to_general_html','general');
	}
}

if ( !function_exists ( 'myoptionalmodules_add_twitter_to_general_html' ) ) {
	function myoptionalmodules_add_twitter_to_general_html(){
		$twitter = get_option('site_twitter','');
		echo '<input id="site_twitter" name="site_twitter" value="'.$twitter.'"/>';
	}
}
	
if(get_option('mommaincontrol_momse') == 1 && get_option('MOM_themetakeover_youtubefrontpage') == ''){
	if ( !function_exists ( 'myoptionalmodules_404Redirection' ) ) {
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
}
	
if ( !function_exists ( 'myoptionalmodules_postasfront' ) ) {
	function myoptionalmodules_postasfront(){	
		if(is_home()){
			if(get_option('mompaf_post') == 'off'){
				// Do nothing
			}elseif(is_numeric(get_option('mompaf_post'))){
				$mompaf_front = get_option('mompaf_post');
			}elseif(get_option('mompaf_post') == 'on'){
				$mompaf_front = '';
			}
			if(have_posts()):the_post();
			header('location:'.esc_url(get_permalink($mompaf_front)));exit;endif;
		}
	}
}

if ( !function_exists ( 'momMaintenance' ) ) {
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
}

if ( !function_exists ( 'myoptionalmodules_removeversion' ) ) {
	function myoptionalmodules_removeversion($src){
		if(strpos($src,'ver='.get_bloginfo('version')))
			$src = remove_query_arg('ver',$src);
		return $src;
	}
}

if ( !function_exists ( 'myoptionalmodules_scripts' ) ) {
	function myoptionalmodules_scripts(){
		wp_register_style('font_awesome', plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/fontawesome/css/font-awesome.min.css');
		wp_enqueue_style('font_awesome');
	}
}

if ( !function_exists ( 'myoptionalmodules_postformats' ) ) {
	function myoptionalmodules_postformats(){
		add_theme_support('post-formats', array('aside','gallery','link','image','quote','status','video','audio','chat'));
	}
}