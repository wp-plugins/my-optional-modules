<?php 

/**
 * Plugin Name: My Optional Modules
 * Plugin URI: http://wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 5.5.6.1
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
 
define ( 'MyOptionalModules', true );
require_once ( ABSPATH . 'wp-includes/pluggable.php' );
$passwordField = 0;
include   ( plugin_dir_path(__FILE__) . '_my_optional_modules_installation.php' );
include   ( plugin_dir_path(__FILE__) . '_my_optional_modules_variables.php' );
include   ( plugin_dir_path(__FILE__) . '_my_optional_modules_functions.php' );

// User levels were deprecated - let's set our levels based on what the user can do (roles)
if(is_user_logged_in()){
	if ( current_user_can('edit_dashboard') ) { $user_level = 7; }
	elseif ( current_user_can('read_private_pages') ) { $user_level = 4; }
	elseif ( current_user_can('delete_published_posts') ) { $user_level = 2; }
	elseif ( current_user_can('delete_posts') ) { $user_level = 1; }
	elseif ( current_user_can('read') ) { $user_level = 0; }
}

	// (B) (3) Plugin form handling
		if(current_user_can('manage_options')){
			global $wpdb;
			$votesPosts = $wpdb->prefix.'momvotes_posts';
			$votesVotes = $wpdb->prefix.'momvotes_votes';
			$RUPs_table_name = $wpdb->prefix.'rotating_universal_passwords';
			$review_table_name = $wpdb->prefix.'momreviews';
			$verification_table_name = $wpdb->prefix.'momverification';
			if(isset($_POST['MOM_UNINSTALL_EVERYTHING'])){
				add_option('mommaincontrol_passwords_activated',1);					
				add_option('mommaincontrol_reviews_activated',1);
				add_option('mommaincontrol_shorts_activated',1);
				add_option('mommaincontrol_votes_activated',1);
				if(get_option('mommaincontrol_votes_activated') == 0){$wpdb->query("DROP TABLE ".$votesPosts."");$wpdb->query("DROP TABLE ".$votesVotes."");}
				if(get_option('mommaincontrol_passwords_activated') == 0){$wpdb->query("DROP TABLE ".$RUPs_table_name."");}
				if(get_option('mommaincontrol_reviews_activated') == 0){$wpdb->query("DROP TABLE ".$review_table_name."");}
				if(get_option('mommaincontrol_shorts_activated') == 0){$wpdb->query("DROP TABLE ".$verification_table_name."");}
				$option = array('MOM_themetakeover_horizontal_galleries','MOM_themetakeover_horizontal_galleries','mommaincontrol_prettycanon','mommaincontrol_fixcanon','mommaincontrol_votes_activated','mommaincontrol_protectrss','MOM_themetakeover_extend','MOM_themetakeover_backgroundimage',
				'MOM_themetakeover_topbar_search','MOM_themetakeover_topbar_share','MOM_themetakeover_topbar_color','mommaincontrol_footerscripts','mommaincontrol_authorarchives','mommaincontrol_datearchives','MOM_themetakeover_wowhead',
				'mom_passwords_salt','mommaincontrol_obwcountplus','mommaincontrol_momrups','mommaincontrol_momse','mommaincontrol_mompaf','mommaincontrol_momja','mommaincontrol_shorts','mommaincontrol_reviews',
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
				if(!get_option('mommaincontrol_mompaf'))add_option('mompaf_post','off');
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
				add_option('mompaf_post','off');
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
			if(isset($_POST['passwordsSave'])){
				global $my_optional_modules_passwords_salt;
				foreach($_REQUEST as $k => $v){
					if($v != '')update_option($k,wp_hash($v));
				}
				update_option('rotating_universal_passwords_8',$_REQUEST['rotating_universal_passwords_8']);
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

	
	
	
	
	include   ( plugin_dir_path(__FILE__) . '_my_optional_modules_settings.php' );
	include   ( plugin_dir_path(__FILE__) . '/includes/modules/_my_optional_modules_passwords.php' );






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
							global $content;
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
								}
								if(isset($_POST['delete_confirm_'.$this_ID.''])){
									$current = plugin_basename(__FILE__);
									$wpdb->query("DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID'");
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
					echo '
					</span>
					<div class="settings">
					

					<section id="googlemaps">
						<h2>Google Maps</h2>
						<p>
							Embed a Google map, with optional paramaters.
						</p>
						<p>
							Shortcode: [mom_map]<br />
							Paramters: width, height, frameborder, align, address, info_window, zoom, companycode
						</p>
						<p>
							<em>Notes on the address attribute</em>:<br />
							Address can be GPS coords (example: 38.573333, -109.549167) or a physical address (1600 Pennsylvania AVE NW, Washington, D.C., DC)
						</p>
						<p>
							Shortcode default attributes:<br />
							width (100%), height (350px), frameborder (0), align (center)
						</p>
					</section>
					
					<section id="reddit">
						<h2>Reddit Button</h2>
						<p>
							Create a customizable submit button for the current post.
						</p>
						<p>
							Examples:<br />
							Targeting a specific subreddit: [mom_reddit target="news"]<br />
							Customizing appearance: [mom_reddit bgcolor="000" border="000"]
						</p>
						<p>
							Shortcode: [mom_reddit]<br />
							Parameters: target, title, bgcolor, border
						</p>
						<p>
							Shortcode default attributes:<br />
							title (the title of the current post), bgcolor (transparent), border (transparent)<br />
							container: div.mom_reddit
						</p>
					</section>
					
					<section id="restrict">
						<h2>Restrict content to logged in users</h2>
						<p>
							Restrict the viewing of content to users who are logged in (including commenting and viewing comments)
						</p>
						<p>
							Shortcode: [mom_restrict] Content to hide [/mom_restrict]<br />
							Paramters: message, comments
						</p>
						<p>
							Examples:<br />
							Comments and comment form are hidden: [mom_restrict comments="1"]Some content [/mom_restrict]<br />
							Comment form is hidden: [mom_restrict comments="2"] Some content [/mom_restrict]
						</p>
						<p>
							Shortcode default attributes:<br />
							message (You must be logged in to view this content.)
							container: div.mom_restrict
						</p>
					</section>
					
					<section id="progress">
						<h2>Progress Bars</h2>
						<p>
							Create bars that fill up, based on specific set parameters.
						</p>
						<p>
							Shortcode: [mom_progress]<br />
							Parameters: align, fillcolor, maincolor, height, level, margin, width
						</p>
						<p>
							Examples:<br />
								Fill 10%: [mom_progress level="10"]<br />
								Fill 70% with custom colors: [mom_progress level="70" maincolor="#ff0000" fillcolor="#009cff"]<br />
								Fill 70% with custom height: [mom_progress level="70" height="50"]
						<p>
							Shortcode default attributes:<br />
							align (none), fillcolor (#ccc), maincolor (#000), height (15), level (0), margin (0 auto), width (95%)
							container: div.mom_progress
						</p>
					</section>
					
					<section id="verifier">
						<h2>Verifier</h2>
						<p>
							Content gate with a customizable input prompt with optional tracking of unique right/wrong answers.
						</p>
						<p>
							[mom_verify]<br />
							Parameters: age, answer, logged, message, fail, logging, background, cmmessage, imessage
						</p>
						
						<p>
							Examples:<br />
							Set up a poll with a yes/no answer: [mom_verify message="Did you find this article useful? Yes or no." answer="yes" cmessage="Found this useful" imessage="Didn\'t find this useful" logging="3" single="1"][/mom_verify]<br />
							Gate content to ages 18+: [mom_verify age="18"] Content to gate [/mom_verify]<br />
							Answer the question correctly to see the content: [mom_verify answer="Hank Hill" message="Who sells propane and propane accessories?"] Some content to hide [/mom_verify]<br />
							Custom background: [mom_verify age="18" background="fff"] some content to hide [/mom_verify]
						</p>
						<p>
							Shortcode default attributes:<br />
							cmessage (Correct), imessage (Incorrect), age (), logged (1), message (Please verify your age by typing it here), fail (You are not able to view this content at this time), logging (0), background (transparent), single (0), deactivate (0)<br />
							container: blockquote.momAgeVerification, form.momAgeVerification
						</p>
					</section>
					
					<section id="onthisday">
						<h2>On this day</h2>
						<p>
							Embed a small post loop that grabs posts for the current day from previous years.
						</p>
						<p>
							Examples:<br />
							Display past posts from this category only: [mom_onthisday cat="current"]<br />
							Display 2 past posts in a div with the title "Previous years": [mom_onthisday title="previous years" amount="2"]
						</p>
						<p>
							[mom_onthisday]<br />
							Paramaters: cat, amount, title<br />
							Template tag: mom_onthisday_template()
						</p>
						
					</section>
					
					</div>';
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
				$MOM_themetakeover_horizontal_galleries = get_option('MOM_themetakeover_horizontal_galleries');
				$showmepages = get_pages(); 		
				echo '
				<span class="moduletitle">
				<form method="post" action="" name="momThemTakeover"><label for="mom_themetakeover_mode_submit">Deactivate</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_themetakeover') == 1){echo '0';}else{echo '1';}echo '" name="themetakeover" /><input type="submit" id="mom_themetakeover_mode_submit" name="mom_themetakeover_mode_submit" value="Submit" class="hidden" /></form>
				</span><div class="clear"></div><div class="settings"><form method="post">
				<div class="clear"></div>
				
				<div class="exclude">
					<section><label for="MOM_themetakeover_horizontal_galleries">Enable Horizontal Galleries</label>
						<select id="MOM_themetakeover_horizontal_galleries" name="MOM_themetakeover_horizontal_galleries">
							<option value="0"'; selected($MOM_themetakeover_horizontal_galleries, 0); echo '>No</option>
							<option value="1"'; selected($MOM_themetakeover_horizontal_galleries, 1); echo '>Yes</option>
						</select>
					</section>				
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
	if(get_option('mommaincontrol_themetakeover') == 1){
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
		if(get_option('MOM_themetakeover_horizontal_galleries') == 1 ) {
			remove_shortcode( 'gallery', 'gallery_shortcode' );
			add_action( 'init', 'mom_gallery_shortcode_add', 99 );
			function mom_gallery_shortcode_add() {
				add_shortcode( 'gallery', 'mom_gallery_shortcode' );
			}
			add_filter( 'use_default_gallery_style', '__return_false' );
			/**
			 * The Gallery shortcode.
			 *
			 * This implements the functionality of the Gallery Shortcode for displaying
			 * WordPress images on a post.
			 *
			 * @since 2.5.0
			 *
			 * @param array $attr {
			 *     Attributes of the gallery shortcode.
			 *
			 *     @type string $order      Order of the images in the gallery. Default 'ASC'. Accepts 'ASC', 'DESC'.
			 *     @type string $orderby    The field to use when ordering the images. Default 'menu_order ID'.
			 *                              Accepts any valid SQL ORDERBY statement.
			 *     @type int    $id         Post ID.
			 *     @type string $itemtag    HTML tag to use for each image in the gallery.
			 *                              Default 'dl', or 'figure' when the theme registers HTML5 gallery support.
			 *     @type string $icontag    HTML tag to use for each image's icon.
			 *                              Default 'dt', or 'div' when the theme registers HTML5 gallery support.
			 *     @type string $captiontag HTML tag to use for each image's caption.
			 *                              Default 'dd', or 'figcaption' when the theme registers HTML5 gallery support.
			 *     @type int    $columns    Number of columns of images to display. Default 3.
			 *     @type string $size       Size of the images to display. Default 'thumbnail'.
			 *     @type string $ids        A comma-separated list of IDs of attachments to display. Default empty.
			 *     @type string $include    A comma-separated list of IDs of attachments to include. Default empty.
			 *     @type string $exclude    A comma-separated list of IDs of attachments to exclude. Default empty.
			 *     @type string $link       What to link each image to. Default empty (links to the attachment page).
			 *                              Accepts 'file', 'none'.
			 * }
			 * @return string HTML content to display gallery.
			 */
			function mom_gallery_shortcode( $attr ) {
				global $post,$attr,$wp;
				$post = get_post();

				static $instance = 0;
				$instance++;

				if ( ! empty( $attr['ids'] ) ) {
					// 'ids' is explicitly ordered, unless you specify otherwise.
					if ( empty( $attr['orderby'] ) )
						$attr['orderby'] = 'post__in';
					$attr['include'] = $attr['ids'];
				}

				/**
				 * Filter the default gallery shortcode output.
				 *
				 * If the filtered output isn't empty, it will be used instead of generating
				 * the default gallery template.
				 *
				 * @since 2.5.0
				 *
				 * @see gallery_shortcode()
				 *
				 * @param string $output The gallery output. Default empty.
				 * @param array  $attr   Attributes of the gallery shortcode.
				 */
				$output = apply_filters( 'post_gallery', '', $attr );
				if ( $output != '' )
					return $output;

				// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
				if ( isset( $attr['orderby'] ) ) {
					$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
					if ( !$attr['orderby'] )
						unset( $attr['orderby'] );
				}

				$html5 = current_theme_supports( 'html5', 'gallery' );
				extract(shortcode_atts(array(
					'order'      => 'ASC',
					'orderby'    => 'menu_order ID',
					'id'         => $post ? $post->ID : 0,
					'itemtag'    => $html5 ? 'figure'     : 'dl',
					'icontag'    => $html5 ? 'div'        : 'dt',
					'captiontag' => $html5 ? 'figcaption' : 'dd',
					'columns'    => 3,
					'size'       => 'thumbnail',
					'include'    => '',
					'exclude'    => '',
					'link'       => ''
				), $attr, 'gallery'));

				$id = intval($id);
				if ( 'RAND' == $order )
					$orderby = 'none';

				if ( !empty($include) ) {
					$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

					$attachments = array();
					foreach ( $_attachments as $key => $val ) {
						$attachments[$val->ID] = $_attachments[$key];
					}
				} elseif ( !empty($exclude) ) {
					$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
				} else {
					$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
				}

				if ( empty($attachments) )
					return '';

				if ( is_feed() ) {
					$output = "\n";
					foreach ( $attachments as $att_id => $attachment )
						$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
					return $output;
				}

				$itemtag = tag_escape($itemtag);
				$captiontag = tag_escape($captiontag);
				$icontag = tag_escape($icontag);
				$valid_tags = wp_kses_allowed_html( 'post' );
				if ( ! isset( $valid_tags[ $itemtag ] ) )
					$itemtag = 'dl';
				if ( ! isset( $valid_tags[ $captiontag ] ) )
					$captiontag = 'dd';
				if ( ! isset( $valid_tags[ $icontag ] ) )
					$icontag = 'dt';

				$columns = intval($columns);
				$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
				$float = is_rtl() ? 'right' : 'left';

				$selector = "gallery-{$instance}";

				$gallery_style = $gallery_div = '';

				/**
				 * Filter whether to print default gallery styles.
				 *
				 * @since 3.1.0
				 *
				 * @param bool $print Whether to print default gallery styles.
				 *                    Defaults to false if the theme supports HTML5 galleries.
				 *                    Otherwise, defaults to true.
				 */
				if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
					$gallery_style = "
					<style type='text/css'>
						#{$selector} {
							margin: auto;
						}
						#{$selector} .gallery-item {
							float: {$float};
							margin-top: 10px;
							text-align: center;
							width: {$itemwidth}%;
						}
						#{$selector} img {
							border: 2px solid #cfcfcf;
						}
						#{$selector} .gallery-caption {
							margin-left: 0;
						}
						/* see gallery_shortcode() in wp-includes/media.php */
					</style>\n\t\t";
				}

				$items = 0;
				foreach ( $attachments as $id => $attachment ) {
					$items++;
				}
				$div_length = ( $items * 150 ) . 'px';
				
				$size_class = sanitize_html_class( $size );
				$gallery_div = "<div id='$selector' class='horizontalGallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>
					<div style=\"width:" . $div_length . "\" class=\"innerGallery\">";

				/**
				 * Filter the default gallery shortcode CSS styles.
				 *
				 * @since 2.5.0
				 *
				 * @param string $gallery_style Default gallery shortcode CSS styles.
				 * @param string $gallery_div   Opening HTML div container for the gallery shortcode output.
				 */
				$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

				$i = 0;
				foreach ( $attachments as $id => $attachment ) {
					if ( ! empty( $link ) && 'file' === $link )
						$image_output = wp_get_attachment_link( $id, $size, false, false );
					elseif ( ! empty( $link ) && 'none' === $link )
						$image_output = wp_get_attachment_image( $id, $size, false );
					else
						$image_output = wp_get_attachment_link( $id, $size, true, false );

					$image_meta  = wp_get_attachment_metadata( $id );

					$orientation = '';
					if ( isset( $image_meta['height'], $image_meta['width'] ) )
						$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

					$output .= "<{$itemtag} class='gallery-item'>";
					$output .= "
						<{$icontag} class='gallery-icon {$orientation}'>
							$image_output
						</{$icontag}>";
					if ( $captiontag && trim($attachment->post_excerpt) ) {
						$output .= "
							<{$captiontag} class='wp-caption-text gallery-caption'>
							" . wptexturize($attachment->post_excerpt) . "
							</{$captiontag}>";
					}
					$output .= "</{$itemtag}>";
					if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
						$output .= '<br style="clear: both" />';
					}
				}

				$output .= "
					</div></div>\n";

				return $output;
			}
			
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
					<option value="NULL">Off</option>
					<option value="">Home page</option>';
					foreach($showmepages as $pagesshown){ echo '<option name="MOM_Exclude_URL" id="mompaf_'.$pagesshown->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownID = $pagesshown->ID; selected($MOM_Exclude_URL, $pagesshownID); echo '> '.$pagesshown->post_title.'</option>'; }
					echo '
				</select>
				</section>
				<section>
				<label for="MOM_Exclude_URL_User">Redirect 404s (logged out)</label>
				<select name="MOM_Exclude_URL_User" class="allpages" id="MOM_Exclude_URL_User">
					<option value="NULL">Off</option>
					<option value=""/>Home page</option>';
					foreach($showmepages as $pagesshownuser){ echo '<option name="MOM_Exclude_URL_User" id="mompaf_'.$pagesshownuser->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownuserID = $pagesshownuser->ID; selected ($MOM_Exclude_URL_User, $pagesshownuserID); echo '> '.$pagesshownuser->post_title.'</option>';}
					echo '
				</select>
				</section>
				<input id="momsesave" type="submit" value="Save Changes" name="momsesave"></form></div></div>';
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

if ( $user_level <=7 && get_option( 'MOM_Exclude_Hide_Dashboard' ) == 1 ) {
	function remove_the_dashboard(){
		global $menu, $submenu, $user_ID;
		$the_user = new WP_User ( $user_ID );
		reset ( $menu ); $page = key ( $menu );
		while ( ( __ ( 'Dashboard' ) != $menu[$page][0] ) && next ( $menu ) )
		$page = key ( $menu );
		if ( __ ( 'Dashboard' ) == $menu[$page][0] ) unset ( $menu[$page] );
		reset ( $menu ); $page = key ( $menu );
		while( !$the_user->has_cap ( $menu[$page][1] ) && next( $menu ) )
		$page = key ( $menu );
		if ( preg_match ( '#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI'] ) && ( 'index.php' != $menu[$page][2] ) )
		wp_redirect ( get_option ( 'siteurl' ) . '/wp-admin/profile.php' );
	}
	add_action ( 'admin_menu', 'remove_the_dashboard' );
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
?>