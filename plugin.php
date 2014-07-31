<?php 

/**
 * Plugin Name: My Optional Modules
 * Plugin URI: http://wordpress.org/plugins/my-optional-modules/
 * Description: Optional modules and additions for Wordpress.
 * Version: 5.5.6.3
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

	// User Role Checking
	$user_level = 0;
	if( is_user_logged_in() && current_user_can('read') ) { $user_level = 0; }
	if( is_user_logged_in() && current_user_can('delete_posts') ) { $user_level = 1; }
	if( is_user_logged_in() && current_user_can('delete_published_posts') ) { $user_level = 2; }
	if( is_user_logged_in() && current_user_can('read_private_pages') ) { $user_level = 4; }
	if( is_user_logged_in() && current_user_can('edit_dashboard') ) { $user_level = 7; }

	// IP Validation
	// Check if the connecting IP address is a valid one
	if( inet_pton( $_SERVER['REMOTE_ADDR'] ) === false ) {
		$ipaddress = false;
	}
	if( inet_pton( $_SERVER['REMOTE_ADDR'] ) !== false ) {
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
							global $content;?>
							<form method="post" class="clear">
								<section class="clear">
									<label class="left" for="reviews_title">title</label>
									<input class="right" type="text" name="reviews_title" placeholder="Enter title here"></section>
								<section class="clear">
									<label class="left" for="reviews_type">type</label>
									<input class="right" type="text" name="reviews_type" placeholder="Review type"></section>
								<section class="clear">
									<label class="left" for="reviews_link">url</label>
									<input class="right" type="text" name="reviews_link" placeholder="Relevant URL" ></section>
								<section class="clear">
									<?php wp_editor($content,$name = 'reviews_review',$id = 'reviews_review',$prev_id = 'title',$media_buttons = true, $tab_index = 2);?>
								</section>
								<br />
								<section class="clear">
									<label class="left" for="reviews_rating">rating</label>
									<input class="right" type="text" name="reviews_rating" placeholder="Your rating">
								</section>
								<br />
								<section class="clear">
									<input id="reviewsubmit" type="submit" value="Add review" name="reviewsubmit"/>
								</section>
							</form>
						<?php }
						function reviews_page_content(){ ?>
							<strong class="sectionTitle">Reviews Settings</strong>
							<form class="clear" method="post" class="reviews_item_form">
							<section class="clear">
								<label class="left" for="filterResults_type">Filter by type</label>
								<input class="right" type="text" name="filterResults_type" placeholder="Filter by type" <?php if(get_option('momreviews_search') != ""){ ?>value="<?php echo get_option('momreviews_search');?><?php }?>">
							</section>
							<section class="clear">
								<input type="submit" name="filterResults" value="Accept">
							</section>
							</form>
							<?php 
								global $wpdb;
								$mom_reviews_table_name = $wpdb->prefix . "momreviews";
								$filtered_search = get_option('momreviews_search');
								if(get_option('momreviews_search') != ""){
									$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE = '$filtered_search' ORDER BY ID DESC");
								}else{
									$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
								} ?>

							<div class="momresults">
							<?php foreach($reviews as $reviews_results){
								$this_ID = $reviews_results->ID;?>
								
								<section class="clear">
									<br />
									<strong>Review ID</strong> <?php echo $reviews_results->ID;?> &mdash; Title: <?php echo $reviews_results->TITLE;?> &mdash;  Review type: <?php echo $reviews_results->TYPE; ?>
									<?php 
										if(!isset($_POST['edit_'.$this_ID.''])){
											if(!isset($_POST['delete_'.$this_ID.''])){ ?>
											<form action="" method="post">
												<input class="left" type="submit" name="delete_<?php echo $this_ID;?>" value="Delete">
											</form>
										<?php } else { ?>
											<form action="" method="post">
												<input class="left" type="submit" name="cancel" id="cancel" value="Cancel"/>
												<input class="left" type="submit" name="delete_confirm_<?php echo $this_ID;?>" value="Confirm"/>
											</form>
										<?php } ?>
										<form method="post">
											<input class="left" type="submit" name="edit_<?php echo $this_ID;?>" value="Edit">
										</form>										
									<?php } ?>
								</section>
								<?php if(isset($_POST['edit_'.$this_ID.''])){ ?>
									<form method="post" class="clear">
									<section class="clear">
										<label class="left" for="reviews_title">title</label>
										<input class="right" type="text" name="reviews_title_<?php echo $this_ID;?>" placeholder="Enter title here" value="<?php echo $reviews_results->TITLE;?>"/></section>
									<section class="clear">
										<label class="left" for="reviews_type">type</label>
										<input class="right" type="text" name="reviews_type_<?php echo $this_ID;?>" placeholder="Review type" value="<?php echo $reviews_results->TYPE;?>"/></section>
									<section class="clear">
										<label class="left" for="reviews_link">url</label>
										<input class="right" type="text" name="reviews_link_<?php echo $this_ID;?>" placeholder="Relevant URL" value="<?php echo $reviews_results->LINK;?>"/></section>
									<section class="clear">
									<?php 
										$thisContent = $reviews_results->REVIEW;
										wp_editor($content = $thisContent,$name = 'edit_review_'.$this_ID.'',$id = 'edit_review_'.$this_ID.'',$prev_id = 'title',$media_buttons = true,$tab_index = 1); ?>
									</section>
									<br />
									<section class="clear">
										<label for="reviews_rating">rating</label>
										<input class="right" type="text" name="reviews_rating_<?php echo $this_ID;?>" placeholder="Your rating" value="<?php echo $reviews_results->RATING;?>"/>
									</section>
									<section class="clear">
										<input id="submit_edit_<?php echo $this_ID;?>" type="submit" value="Save these edits" name="submit_edit_<?php echo $this_ID;?>">
										<input type="submit" name="cancel" id="cancel" value="Cancel these edits"/>
									</section>
									</form>
								<?php }
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
							} ?>
							</div>
							<p></p>
							<?php 
							if(!isset($_POST['edit_'.$this_ID.''])){ print_mom_reviews_form(); }							
						}
					reviews_page_content();?>
					<p></p>
					<form class="clear" method="post" action="" name="momReviews">
						<label for="mom_reviews_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate Reviews module</label>
						<input type="text" class="hidden" value="<?php if(get_option('mommaincontrol_reviews') == 1){ ?>0<?php } else { ?>1<?php }?>" name="reviews" />
						<input type="submit" id="mom_reviews_mode_submit" name="mom_reviews_mode_submit" value="Submit" class="hidden" />
					</form>
					<p>
						<i class="fa fa-info">&mdash;</i> [momreviews] shortcode accepts the following parameters to output a loop of your reviews: type, 
						orderbye, order, meta, expand, retract, id, and open.
					</p>
					<p>
						<i class="fa fa-code">&mdash;</i> <strong>type</strong> &mdash; Only grab reviews of this type (default: blank)<br />
						<i class="fa fa-code">&mdash;</i> <strong>orderby</strong> &mdash; order by type, link, title, or rating (default: ID)<br />
						<i class="fa fa-code">&mdash;</i> <strong>order</strong> &mdash;  ASC or DESC (ascending or descending) (default: ASC)<br />
						<i class="fa fa-code">&mdash;</i> <strong>meta</strong> &mdash;  1 or 0 (show meta (additional) information or not) (default: 1)<br />
						<i class="fa fa-code">&mdash;</i> <strong>expand</strong> &mdash;  Text for the expand link (default: + )<br />
						<i class="fa fa-code">&mdash;</i> <strong>retract</strong> &mdash;  Text for the retract link (default: - )<br />
						<i class="fa fa-code">&mdash;</i> <strong>id</strong> &mdash; If an ID is specified, the loop will only return that review<br />
						<i class="fa fa-code">&mdash;</i> <strong>open</strong> &mdash; 1 or 0 (open by default, closed by default) (default: 0)<br />
					</p>
					<p>
						<i class="fa fa-info">&mdash;</i> Reviews that have a numerical value for rating (.5 to 5) will instead display stars ( <i class="fa fa-star-half-o"></i> for .5, <i class="fa fa-star"></i> for whole).  <em>Example</em>: a rating of 3.5 would display as <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>.
					</p>
				<?php }
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
				$showmepages = get_pages(); ?>
				<strong class="sectionTitle">Takeover Settings</strong>
				<form class="clear" method="post">
					<section class="clear">
						<label class="left" for="MOM_themetakeover_horizontal_galleries">Horizontal Galleries</label>
						<select class="right" id="MOM_themetakeover_horizontal_galleries" name="MOM_themetakeover_horizontal_galleries">
							<option value="0" <?php selected($MOM_themetakeover_horizontal_galleries, 0);?> >No</option>
							<option value="1" <?php selected($MOM_themetakeover_horizontal_galleries, 1);?> >Yes</option>
						</select>
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_youtubefrontpage">Youtube for 404s</label>
						<input class="right" type="text" id="MOM_themetakeover_youtubefrontpage" name="MOM_themetakeover_youtubefrontpage" value="<?php esc_url(get_option('MOM_themetakeover_youtubefrontpage'));?>">
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_fitvids"><a href="http://fitvidsjs.com/">Fitvid</a> .class</label>
						<input class="right" type="text" id="MOM_themetakeover_fitvids" name="MOM_themetakeover_fitvids" value="<?php esc_attr(get_option('MOM_themetakeover_fitvids'))?>">
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_postdiv">Post content .div</label>
						<input class="right" type="text" placeholder=".entry" id="MOM_themetakeover_postdiv" name="MOM_themetakeover_postdiv" value="<?php esc_attr(get_option('MOM_themetakeover_postdiv'));?>">
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_postelement">Post title .element</label>
						<input class="right" type="text" placeholder="h1" id="MOM_themetakeover_postelement" name="MOM_themetakeover_postelement" value="<?php esc_attr(get_option('MOM_themetakeover_postelement'));?>">
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_posttoggle">Toggle text</label>
						<input class="right" type="text" placeholder="Toggle contents" id="MOM_themetakeover_posttoggle" name="MOM_themetakeover_posttoggle" value="<?php esc_attr(get_option('MOM_themetakeover_posttoggle'));?>">
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_topbar">Enable navbar</label>
						<select class="right" id="MOM_themetakeover_topbar" name="MOM_themetakeover_topbar">
							<option value="1" <?php selected($MOM_themetakeover_topbar, 1);?>>Yes (top)</option>
							<option value="2" <?php selected($MOM_themetakeover_topbar, 2);?>>Yes (bottom)</option>
							<option value="0" <?php selected($MOM_themetakeover_topbar, 0);?>>No</option>
						</select>
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_extend">Extend navbar</label>
						<select class="right" id="MOM_themetakeover_extend" name="MOM_themetakeover_extend">
							<option value="1" <?php selected($MOM_themetakeover_extend, 1);?>>Yes</option>
							<option value="0" <?php selected($MOM_themetakeover_extend, 0);?>>No</option>
						</select>
					</section>			
					<section class="clear">
						<label class="left" for="MOM_themetakeover_topbar_color">Navbar scheme</label>
						<select class="right" id="MOM_themetakeover_topbar_color" name="MOM_themetakeover_topbar_color">
							<option value="1" <?php selected($MOM_themetakeover_topbar_color, 1);?>>Dark</option>
							<option value="2" <?php selected($MOM_themetakeover_topbar_color, 2);?>>Light</option>
							<option value="4" <?php selected($MOM_themetakeover_topbar_color, 4);?>>Red</option>
							<option value="5" <?php selected($MOM_themetakeover_topbar_color, 5);?>>Green</option>
							<option value="6" <?php selected($MOM_themetakeover_topbar_color, 6);?>>Blue</option>
							<option value="7" <?php selected($MOM_themetakeover_topbar_color, 7);?>>Yellow</option>
							<option value="3" <?php selected($MOM_themetakeover_topbar_color, 3);?>>Default</option>
						</select>
					</section>			
					<section class="clear">
						<label class="left" for="MOM_themetakeover_topbar_search">Enable search bar</label>
						<select class="right" id="MOM_themetakeover_topbar_search" name="MOM_themetakeover_topbar_search">
							<option value="0" <?php selected($MOM_themetakeover_topbar_search, 0);?>>No</option>
							<option value="1" <?php selected($MOM_themetakeover_topbar_search, 1);?>>Yes</option>
						</select>
					</section>						
					<section class="clear">
						<label class="left" for="MOM_themetakeover_topbar_share">Share icons</label>
						<select class="right" id="MOM_themetakeover_topbar_share" name="MOM_themetakeover_topbar_share">
							<option value="0" <?php selected($MOM_themetakeover_topbar_share, 0);?>>No</option>
							<option value="1" <?php selected($MOM_themetakeover_topbar_share, 1);?>>Yes</option>
						</select>
					</section>						
					<section class="clear">
						<label class="left" for="MOM_themetakeover_archivepage">Archives page</label>
						<select class="right" name="MOM_themetakeover_archivepage" class="allpages" id="MOM_themetakeover_archivepage">
						<option value="">Home page</option>					
						<?php foreach($showmepages as $pagesshown){ ?>
							<option name="MOM_themetakeover_archivepage" id="mompaf_<?php echo esc_attr($pagesshown->ID); ?>" value="<?php echo esc_attr($pagesshown->ID);?>"
							<?php $selectedarchivespage = $pagesshown->ID;
							$MOM_themetakeover_archivepage = get_option('MOM_themetakeover_archivepage');
							selected($MOM_themetakeover_archivepage, $selectedarchivespage);?>
							><?php echo $pagesshown->post_title; ?></option>
						<?php } ?>
						</select>
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_backgroundimage">Custom BG Image</label>
						<select class="right" id="MOM_themetakeover_backgroundimage" name="MOM_themetakeover_backgroundimage">
							<option value="0" <?php selected($MOM_themetakeover_backgroundimage, 0);?>>No</option>
							<option value="1" <?php selected($MOM_themetakeover_backgroundimage, 1);?>>Yes</option>
						</select>
					</section>
					<section class="clear">
						<label class="left" for="MOM_themetakeover_wowhead">Wowhead (<a href="http://www.wowhead.com/tooltips">?</a>)</label>
						<select class="right" id="MOM_themetakeover_wowhead" name="MOM_themetakeover_wowhead">
							<option value="1" <?php selected($MOM_themetakeover_wowhead, 1);?>>Yes</option>
							<option value="0" <?php selected($MOM_themetakeover_wowhead, 0);?>>No</option>
						</select>
					</section>
					<input id="momthemetakeoversave" type="submit" value="Save Changes" name="momthemetakeoversave" />
				</form>
				<p></p>
				<form class="clear" method="post" action="" name="momThemTakeover">
					<label for="mom_themetakeover_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate the Takeover module</label>
					<input type="text" class="hidden" value="<?php if(get_option('mommaincontrol_themetakeover') == 1){ ?>0<?php }else{ ?>1 <?php } ?>" name="themetakeover" />
					<input type="submit" id="mom_themetakeover_mode_submit" name="mom_themetakeover_mode_submit" value="Submit" class="hidden" />
				</form>
				<p><i class="fa fa-info">&mdash;</i> This module will attempt take over certain functionalities 
				of your current them and add additional functionality that wasn't (previously) there.</p>
				<p><i class="fa fa-youtube">&mdash;</i> Youtube for 404s accepts a Youtube URL, and will set up a 404 
				page featuring that video.</p>
				<p><i class="fa fa-info">&mdash;</i> Fitvid .class accepts a container class that your media embeds are wrapped 
				in to apply the Fitvids JS functionality to.</p>
				<p><i class="fa fa-info">&mdash;</i>Post content .div, title .element, and Toggle text need to be set in order 
				to implement automatic lists for pages and posts that are extremely long and have sections denoted by 
				title elements (like h1).</p>
			<?php }
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
?>