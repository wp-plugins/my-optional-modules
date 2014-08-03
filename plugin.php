<?php 

/**
 * Plugin Name: My Optional Modules
 * Plugin URI: http://wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 5.5.6.6
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
 
	define( 'MyOptionalModules', true );
	require_once( ABSPATH . 'wp-includes/pluggable.php' );
	
	$passwordField = 0;

	// User Role Checking
	if( is_user_logged_in() ) {
		if( current_user_can('read') ) { $user_level = 0; }
		if( current_user_can('delete_posts') ) { $user_level = 1; }
		if( current_user_can('delete_published_posts') ) { $user_level = 2; }
		if( current_user_can('read_private_pages') ) { $user_level = 4; }
		if( current_user_can('edit_dashboard') ) { $user_level = 7; }
	} else {
		$user_level = 0;
	}

	// IP Validation
	// Check if the connecting IP address is a valid one
	if( inet_pton( $_SERVER['REMOTE_ADDR'] ) === false ) {
		$ipaddress = false;
	} else {
		$ipaddress = esc_attr( $_SERVER[ 'REMOTE_ADDR' ] );
	}
	// If the IP is valid, check it against the DNSBL
	if( !function_exists ( 'myoptionalmodules_checkdnsbl' ) ) {
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
			if( $ipaddress ) {
				$reverse_ip=implode(".",array_reverse(explode(".",$ipaddress)));
				foreach($dnsbl_lookup as $host){
					if(checkdnsrr($reverse_ip.".".$host.".","A")){
						$listed.=$reverse_ip.'.'.$host;
					}
				}
			}
			if( $listed ) {
				$DNSBL === true;
			} else {
				$DNSBL === false;
			}
		}
	}	
	
	include( plugin_dir_path(__FILE__) . '_my_optional_modules_installation.php' );
	include( plugin_dir_path(__FILE__) . '_my_optional_modules_variables.php' );
	include( plugin_dir_path(__FILE__) . '_my_optional_modules_functions.php' );
	include( plugin_dir_path(__FILE__) . '_my_optional_modules_forms.php' );
	include( plugin_dir_path(__FILE__) . '_my_optional_modules_settings.php' );
	include( plugin_dir_path(__FILE__) . '_my_optional_modules_shortcodes.php' );
	include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_passwords.php' );
	
	include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_reviews_settings.php' );

	include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_shortcodes_information.php' );

	/**
	 * Initiate Takeover module functionality if the module is active
	 */
	if( get_option( 'mommaincontrol_themetakeover' ) == 1 ) {
		include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_theme_takeover_settings.php' );
		include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_theme_takeover_functions.php' );
	}
	
	/**
	 * Append meta information if Meta module is active
	 */
	if( get_option( 'mommaincontrol_meta' ) == 1 ) {
		include( plugin_dir_path( __FILE__ ) . 'includes/modules/_my_optional_modules_meta_module.php' );
	}

	
	//

	// (J) Count++ (settings page)
		if(current_user_can('manage_options')){
			function my_optional_modules_count_module(){ ?>
					<strong class="sectionTitle">Count++ Settings</strong>
					<form class="clear" method="post">
						<section class="clear">
							<label class="left" for="obwcountplus_1_countdownfrom">Goal (<em>0</em> for none)</label>
							<input class="right" id="obwcountplus_1_countdownfrom" type="text" value="<?php echo esc_attr(get_option('obwcountplus_1_countdownfrom'));?>" name="obwcountplus_1_countdownfrom">
						</section>
						<section class="clear">
							<label class="left" for="obwcountplus_2_remaining">Text for remaining</label>
							<input class="right" id="obwcountplus_2_remaining" type="text" value="<?php echo esc_attr(get_option('obwcountplus_2_remaining'));?>" name="obwcountplus_2_remaining">
						</section>
						<section class="clear">
							<label class="left" for="obwcountplus_3_total">Text for published</label>
							<input class="right" id="obwcountplus_3_total" type="text" value="<?php echo esc_attr(get_option('obwcountplus_3_total'));?>" name="obwcountplus_3_total">
						</section>
						<section class="clear">
							<label class="left" for="obwcountplus_4_custom">Custom output</label>
							<input class="right" id="obwcountplus_4_custom" type="text" value="<?php echo esc_attr(get_option('obwcountplus_4_custom'));?>" name="obwcountplus_4_custom">
						</section>
						<p></p>
						<input id="obwcountsave" type="submit" value="Save Changes" name="obwcountsave">
					</form>
					<p></p>
					<form method="post" action="" name="momCount" class="clear">
						<label for="mom_count_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate the Count++ module</label>
						<input type="text" class="hidden" value="
							<?php if(get_option('mommaincontrol_obwcountplus') == 1){ ?>
								0
							<?php }else{ ?>
								1
							<?php } ?>
							" name="countplus" />
						<input type="submit" id="mom_count_mode_submit" name="mom_count_mode_submit" value="Submit" class="hidden" />
					</form>
					<p>
						<i class="fa fa-info">&mdash;</i> The <em>custom output</em> field accepts a templated input to customize the 
						output of the module. <strong>%total%</strong> prints the total words on the blog, 
						while <strong>%remain%</strong> prints the (goal - total).
					</p>
					<p>
						Template tags (for use in theme files):<br />
						<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_total()</strong> prints single post word count<br />
						<i class="fa fa-code">&mdash;</i> <strong>countsplusplus()</strong> prints custom output (set above)<br />
						<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_count()</strong> prints the total words + remaining (of goal)<br />
						<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_total()</strong> prints the total words<br />
						<i class="fa fa-code">&mdash;</i> <strong>obwcountplus_remaining()</strong> prints the remaining (or the total if the goal was reached)<br />
					</p>
					<p>
						<i class="fa fa-heart">&mdash;</i> Count++ was adapted from <a href="http://wordpress.org/plugins/post-word-count/">Post Word Count</a>, a plugin by <a href="http://profiles.wordpress.org/nickmomrik/">Nick Momrik</a>.
					</p>
				<?php }
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
				echo '
				<strong class="sectionTitle">Exclude Settings</strong>
				<form method="post" class="clear">
					<p><strong class="sectionTitle">Hide Categories from..</strong>
					<i class="fa fa-info">&mdash;</i> Separate multiple categories with commas</p>
					<div class="list"><span>Category (<strong>ID</strong>)</span>';
					foreach($showmecats as $catsshown){
						echo '
						<span>'.$catsshown->cat_name.'(<strong>'.$catsshown->cat_ID.'</strong>)</span>';
					}
				echo '</div><br />';
				$exclude = array('MOM_Exclude_Categories_RSS','MOM_Exclude_Categories_Front','MOM_Exclude_Categories_TagArchives','MOM_Exclude_Categories_SearchResults','MOM_Exclude_Categories_CategoriesSun','MOM_Exclude_Categories_CategoriesMon','MOM_Exclude_Categories_CategoriesTue','MOM_Exclude_Categories_CategoriesWed','MOM_Exclude_Categories_CategoriesThu','MOM_Exclude_Categories_CategoriesFri','MOM_Exclude_Categories_CategoriesSat','MOM_Exclude_Categories_level0Categories','MOM_Exclude_Categories_level1Categories','MOM_Exclude_Categories_level2Categories','MOM_Exclude_Categories_level7Categories');
				$section = array( 'RSS','Front page','Tag archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
				foreach($exclude as $exc ) {
						$title = str_replace($exclude,$section,$exc);
						echo '<section class="clear"><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
				}				
				echo '<hr />
				<p><strong class="sectionTitle">Hide Tags from..</strong>
				<i class="fa fa-info">&mdash;</i> Separate multiple tags with commas</p>
				<div class="list"><span>Tag (<strong>ID</strong>)</span>';
					foreach($showmetags as $tagsshown){
						echo '<span>'.$tagsshown->cat_name.'(<strong>'.$tagsshown->cat_ID.'</strong>)</span>';
					}
				echo '</div><br />';
				$exclude = array('MOM_Exclude_Tags_RSS','MOM_Exclude_Tags_Front','MOM_Exclude_Tags_CategoryArchives','MOM_Exclude_Tags_SearchResults','MOM_Exclude_Tags_TagsSun','MOM_Exclude_Tags_TagsMon','MOM_Exclude_Tags_TagsTue','MOM_Exclude_Tags_TagsWed','MOM_Exclude_Tags_TagsThu','MOM_Exclude_Tags_TagsFri','MOM_Exclude_Tags_TagsSat','MOM_Exclude_Tags_level0Tags','MOM_Exclude_Tags_level1Tags','MOM_Exclude_Tags_level2Tags','MOM_Exclude_Tags_level7Tags');
				$section = array( 'RSS','Front page','Tag archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
				foreach($exclude as $exc ) {
						$title = str_replace($exclude,$section,$exc);
						echo '<section class="clear"><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
				}				
				echo '<hr />
				
				<strong class="sectionTitle">Hide Post Formats from..</strong>
				<section class="clear">
					<label class="left" for="MOM_Exclude_PostFormats_RSS">RSS</label>
					<select class="right" name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
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
				<section class="clear">
					<label class="left" for="MOM_Exclude_PostFormats_Front">front page</label>
					<select class="right" name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
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
				<section class="clear">
					<label class="left" for="MOM_Exclude_PostFormats_CategoryArchives">archives</label>
					<select class="right" name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
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
				<section class="clear">
					<label class="left" for="MOM_Exclude_PostFormats_TagArchives">tags</label>
					<select class="right" name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
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
				<section class="clear">
					<label class="left" for="MOM_Exclude_PostFormats_SearchResults">search results</label>
					<select class="right" name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
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
				<section class="clear">
					<label class="left" for="MOM_Exclude_PostFormats_Visitor">logged out</label>
					<select class="right" name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
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

				<hr />

				<p><strong class="sectionTitle">Additional settings</strong>
				<i class="fa fa-info">&mdash;</i> <em>Hide dash</em> hides the dash from all users except 
				for admin. <em>No follow user</em> no follows categories hidden from nonusers. <em>User 404s</em> 
				and <em>Visitor 404s</em> will redirect 404 errors for (logged in) and (non-logged in) visitors.</p>
				<section class="clear">
					<label class="left" for="MOM_Exclude_Hide_Dashboard">Hide Dash</label>
					<select class="right" name="MOM_Exclude_Hide_Dashboard" class="allpages" id="MOM_Exclude_Hide_Dashboard">
						<option '; selected($MOM_Exclude_Hide_Dashboard, 1); echo 'value="1">Yes</option>
						<option '; selected($MOM_Exclude_Hide_Dashboard, 0); echo 'value="0">No</option>
					</select>
				</section>
				<section class="clear">
					<label class="left" for="MOM_Exclude_NoFollow">No Follow User</label>
					<select class="right" name="MOM_Exclude_NoFollow" class="allpages" id="MOM_Exclude_NoFollow">
						<option '; selected($MOM_Exclude_NoFollow, 1); echo 'value="1">Yes</option>
						<option '; selected($MOM_Exclude_NoFollow, 0); echo 'value="0">No</option>
					</select>
				</section>
				<section class="clear">
					<label class="left" for="MOM_Exclude_URL">User 404s</label>
					<select class="right" name="MOM_Exclude_URL" class="allpages" id="MOM_Exclude_URL">
						<option value="NULL">Off</option>
						<option value="">Home page</option>';
						foreach($showmepages as $pagesshown){ echo '<option name="MOM_Exclude_URL" id="mompaf_'.$pagesshown->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownID = $pagesshown->ID; selected($MOM_Exclude_URL, $pagesshownID); echo '> '.$pagesshown->post_title.'</option>'; }
						echo '
					</select>
				</section>
				<section class="clear">
					<label class="left" for="MOM_Exclude_URL_User">Visitor 404s</label>
					<select class="right" name="MOM_Exclude_URL_User" class="allpages" id="MOM_Exclude_URL_User">
						<option value="NULL">Off</option>
						<option value=""/>Home page</option>';
						foreach($showmepages as $pagesshownuser){ echo '<option name="MOM_Exclude_URL_User" id="mompaf_'.$pagesshownuser->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownuserID = $pagesshownuser->ID; selected ($MOM_Exclude_URL_User, $pagesshownuserID); echo '> '.$pagesshownuser->post_title.'</option>';}
						echo '
					</select>
				</section>
				<input id="momsesave" type="submit" value="Save Changes" name="momsesave"></form>

				<form class="clear" method="post" action="" name="momExclude">
				<label for="mom_exclude_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate Exclude module</label>
				<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momse') == 1){echo '0';}else{echo '1';}echo '" name="exclude" /><input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" />
				</form>';
				
				
			}
		}
	//
	
	
	
	
	
/**
 * (module) Exclude
 * Exclude categories and tags from anywhere on the WordPress installation.
 */

get_currentuserinfo();
global $user_level;

/**
 * Disable dashboard for non-admin
 * (1) Hide dash for all but the admin.
 */



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
	global $user_level;
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
				<strong class="sectionTitle">Jump Around Settings</strong>
				<form  class="clear" method="post">';
					foreach ($o as &$value){
						$text = str_replace($o,$f,$value);
						$label = 'jump_around_'.$value;
						if($value <= 3){
							echo '
							<section class="clear"><label class="left" for="'.$label.'">'.$text.'</label>
							<input class="right" type="text" id="'.$label.'" name="'.$label.'" value="'.get_option($label).'" /></section>';
						}
						elseif($value == 4 || $value > 4){
							if($value == 4)echo '';
							echo '
							<section class="clear"><label class="left" for="'.$label.'">'.$text.'</label>
							<select class="right" name="'.$label.'">';
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
				<p></p>
				<form class="clear" method="post" action="" name="mom_jumparound_mode_submit">
					<label for="mom_jumparound_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate Jump Around module</label>
					<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momja') == 1){echo '0';}else{echo '1';}echo '" name="jumparound" /><input type="submit" id="mom_jumparound_mode_submit" name="mom_jumparound_mode_submit" value="Submit" class="hidden" />
				</form>
				<p><i class="fa fa-info">&mdash; </i> Keyboard navigation on any area that isn\'t a single post or page view.</p>
				<p><i class="fa fa-code">&mdash;</i> Example(s): <em>.div, .div a, .div h1, .div h1 a</em></p>
				<p><i class="fa fa-heart">&mdash;</i> Thanks to <a href="http://stackoverflow.com/questions/1939041/change-hash-without-reload-in-jquery">jitter</a> &amp; <a href="http://stackoverflow.com/questions/13694277/scroll-to-next-div-using-arrow-keys">mVChr</a> for the help.</em></p>
				';
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
			$query_sql = $wpdb->get_results ( "SELECT ID,UP from $votesPosts  WHERE UP > 1 ORDER BY UP DESC LIMIT $amount" );
			if ($query_sql) {
				echo '<ul class="topVotes">
					<li>Top ' . $amount . ' posts</li>';
				foreach ($query_sql as $post_id) {
					$votes = intval($post_id->UP);
					$id = intval($post_id->ID);
					$link = get_permalink($id);
					echo '<li><a href="' . $link . '" rel="bookmark" title="Permanent Link to ' . get_the_title( $id ) . '">' . get_the_title( $id ) . ' &mdash; ( ' . $votes . ' )</a></li>';
				}
				echo '</ul>';
			}else{}
			wp_reset_query();
			return ob_get_clean();
		}
		
		if(get_option('mommaincontrol_votes') == 1){
			add_shortcode('topvoted','vote_the_posts_top');
			add_filter('the_content','do_shortcode','vote_the_posts_top');
			add_filter('the_content','vote_the_post');
			function vote_the_post($content){
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
						$vote = '';
						$votesTOTAL = intval($gotID->UP);
						$getIP = $wpdb->get_results("SELECT ID,IP,VOTE FROM $votesVotes WHERE ID = '".$theID."' AND IP = '".$theIP_us32str."' LIMIT 1");
						if(count($getIP) == 0) {
							if(isset($_POST[$theID.'-up-submit'])){
								$wpdb->query("UPDATE $votesPosts SET UP = UP + 1 WHERE ID = $theID");
								$wpdb->query("INSERT INTO $votesVotes (ID, IP, VOTE) VALUES ($theID,$theIP_us32str,1)");
							}
							$vote = '<div class="vote_the_post" id="'.esc_attr($theID).'">
							<form action="" id="'.esc_attr($theID).'-up" method="post"><label for="'.esc_attr($theID).'-up-submit" class="upvote"><i class="fa fa-heart"></i></label><input type="submit" name="'.esc_attr($theID).'-up-submit" id="'.esc_attr($theID).'-up-submit" /></form>
							<span class="voteAmount">'.esc_attr($votesTOTAL).' <i class="fa fa-heart">\'s</i></span>
							</div>';
						}else{
							foreach($getIP as $gotIP){
								$vote = esc_sql(esc_attr($gotIP->VOTE));
								if($vote == 1 && isset($_POST[$theID.'-up-submit'])){
									$wpdb->query("UPDATE $votesPosts SET UP = UP - 1 WHERE ID = $theID");
									$wpdb->query("DELETE FROM $votesVotes WHERE IP = '$theIP_us32str' AND ID = '$theID'");
								}
								if($vote == 1)$CLASS = ' active';
								$vote = '<div class="vote_the_post" id="'.esc_attr($theID).'">
								<form action="" id="'.esc_attr($theID).'-up" method="post"><label for="'.esc_attr($theID).'-up-submit" class="upvote"><i class="fa fa-heart'.$CLASS.'"></i></label><input type="submit" name="'.esc_attr($theID).'-up-submit" id="'.esc_attr($theID).'-up-submit" /></form>
								<span class="voteAmount">'.esc_attr($votesTOTAL).' <i class="fa fa-heart">\'s</i> </span>
								</div>';
							}
						}			
					}		
				// Return nothing, the IP address is fake.
				}else{}
				
				echo $content . $vote;
				
			}
		}
	//


/*
 * Database cleaner
 * Clean the following junk items from the database with a click of the button:
 *  - (1) Revisions ( revision, auto drafts, trash )
 *  - (2) Comments ( unapproved, trashed, spam )
 *  - (3) Terms ( categories and tags with no associated posts )\
 *  - (4) All at once
 */
if( current_user_can( 'manage_options' ) ) {
	include( plugin_dir_path(__FILE__) . '_my_optional_modules_database_cleaner.php' );
}




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
						$icon = array(
						'automobile','bank','behance','behance-square','bomb','building',
						'cab','car','child','circle-o-notch','circle-thin','codepen',
						'cube','cubes','database','delicious','deviantart','digg',
						'drupal','empire','envelope-square','fax','file-archive-o','file-audio-o',
						'file-code-o','file-excel-o','file-image-o','file-movie-o','file-pdf-o','file-photo-o',
						'file-picture-o','file-powerpoint-o','file-sound-o','file-video-o','file-word-o','file-zip-o',
						'ge','git','git-square','google','graduation-cap','hacker-news','header','history','institution',
						'joomla','jsfiddle','language','life-bouy','life-ring','life-saver','mortar-board','openid','paper-plane',
						'paper-plane-o','paragraph','paw','pied-piper','pied-piper-alt','pied-piper-square','qq','ra','rebel',
						'recycle','reddit','reddit-square','send','send-o','share-alt','share-alt-square','slack','sliders',
						'soundcloud','space-shuttle','spoon','spotify','steam','steam-square','stumbleupon','stumbleupon-circle',
						'support','taxi','tencent-weibo','tree','university','vine','wechat','weixin','wordpress','yahoo',
						'adjust','anchor','archive','arrows','arrows-h','arrows-v','asterisk',
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
						echo '<li onclick="addText(event)" title="<i class=\'fa fa-' . $value . '\'></i>" class="fa fa-'.$value.' icon"><span>&#60;i class="fa fa-'.$value.'"&#62;&#60;/i&#62;</span></li>';
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
	

	/**
	 * Tiled Front Page
	 */
	if( get_option( 'MOM_themetakeover_tiledfrontpage' ) == 1 ) {
		add_filter ( 'the_content', 'do_shortcode', 'mom_tiled' );
		add_shortcode ( 'mom_tiled', 'mom_tiled_frontpage' );
	}
	function mom_tiled_frontpage($atts, $content = null){

		$maxposts = get_option( 'posts_per_page' );
		$recent_count = 0;
		
		extract(
			shortcode_atts(array(
				'downsize' => 1,
				'style' => 'tiled',
				'offset' => 0,
				'category' => '',
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_status' => 'publish'
			), $atts)
		);
		
		echo '<div class="mom_postrotation mom_recentPostRotationFull_' . $style .'">';
		
		$args = array(
			'posts_per_page'   => 4,
			'offset'           => $offset,
			'category'         => $category,
			'orderby'          => $orderby,
			'order'            => $order,
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'post',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => $post_status,
			'suppress_filters' => true
		);
		$myposts = get_posts( $args );
		foreach( $myposts as $post ) : setup_postdata( $post ); 
		$id    = $post->ID;
		$link  = esc_url ( get_permalink( $id ) );
		$title = get_the_title( $id );
				
		$recent_count++;
		$media = get_post_meta($id, 'media', true);
		if( $recent_count == 1 ) {
			$container = 'feature';
			echo '<div class="' . $container . '">';					
		}
		if( $recent_count == 2 ) {
			$container = 'second';
			echo '<div class="' . $container . '">';
		}
		if( $recent_count == 3 ) {
			$container = 'secondThird';
			echo '<div class="' . $container . '">';
		}
		echo '<div class="thumbnailFull';
		if( $recent_count == 2 ) {				
			echo ' leftSmall';
		}
		echo '"';
		if( '' != wp_get_attachment_url( get_post_thumbnail_id($id) ) ) {
			$post_thumbnail_id = get_post_thumbnail_id( $id );
			if( $downsize == 1 ) {
				$thumb_array = image_downsize( $post_thumbnail_id, 'thumbnail' );
				$thumb_path = $thumb_array[0];	
			} else {
				$thumb_path = wp_get_attachment_url( get_post_thumbnail_id($id) );
			}

			echo 'style="background-image:url(\'' . $thumb_path . '\');"';
		}
		echo '>';
		
		
			echo '<a class="mediaNotPresent" href="' . get_permalink($id) . '">' . get_the_title($id). '</a>';
		
		
		echo '</div>';
		if( $recent_count == 4 ) {
			echo '</div></div></div>';
		}				
			
		endforeach;
		wp_reset_postdata();
		
		echo '</div>';
		
	}