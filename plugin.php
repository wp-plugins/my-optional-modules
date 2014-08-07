<?php 

/**
 * Plugin Name: My Optional Modules
 * Plugin URI: http://wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 5.5.7.1
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

/**
 *
 * Include all of our necessary files for this plugin to function properly 
 * These files are included in the order they are needed. Rearranging them 
 * may break functionality.
 *
 */
include( plugin_dir_path(__FILE__) . '_my_optional_modules_user_roles.php' );                                   // Determine the connecting users role (or lack of)
include( plugin_dir_path(__FILE__) . '_my_optional_modules_IP_validation.php' );                                // Validate connecting IP and check it against the DNSBL
include( plugin_dir_path(__FILE__) . '_my_optional_modules_installation.php' );                                 // Installation
include( plugin_dir_path(__FILE__) . '_my_optional_modules_scripts.php' );                                      // Plugin scripts
include( plugin_dir_path(__FILE__) . '_my_optional_modules_variables.php' );                                    // Plugin variables
include( plugin_dir_path(__FILE__) . '_my_optional_modules_functions.php' );                                    // Plugin functions
include( plugin_dir_path(__FILE__) . '_my_optional_modules_forms.php' );                                        // Form handling
include( plugin_dir_path(__FILE__) . '_my_optional_modules_settings.php' );                                     // Settings
include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_reviews_settings.php' );           // Module->Reviews(settings)
include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_count_settings.php' );             // Module->Count++(settings)
include( plugin_dir_path(__FILE__) . '_my_optional_modules_database_cleaner.php' );                             // Database cleaner
include( plugin_dir_path(__FILE__) . '_my_optional_modules_shortcodes.php' );                                   // Shortcodes
include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_passwords.php' );                  // Module->Passwords
include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_shortcodes_information.php' );     // Module->Shortcodes (information page)
include( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_miniloop.php' );                   // Module->Miniloops



	





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
				$section = array( 'RSS','Front page','Category archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
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
						'automobile','bank','behance','behance-square','bomb','building','cab','car','child','circle-o-notch','circle-thin','codepen',
						'cube','cubes','database','delicious','deviantart','digg','drupal','empire','envelope-square','fax','file-archive-o','file-audio-o',
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