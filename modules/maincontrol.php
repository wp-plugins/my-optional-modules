<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	//	MY OPTIONAL MODULES (MAIN CONTROL)
	//	CONTENTS
	//	Add options page for plugin to Wordpress backend
	//	Update base options when main form is submitted
	//	Main form content to display on the options page
	//	Content to display on the options page  
	if (is_admin()){ 
		memory_get_usage();
		// Load our updater file to handle form requests for options
		include(plugin_dir_path(__FILE__) . '_updater.php');
		// Add options page for plugin to Wordpress backend
		add_action('admin_menu','my_optional_modules_add_options_page');
		function my_optional_modules_add_options_page(){ 
			add_options_page('My Optional Modules', 'My Optional Modules', 'manage_options', 'mommaincontrol', 'my_optional_modules_page_content'); 
		}
		// Content to display on the options page
		function my_optional_modules_page_content(){
			if(get_option('mommaincontrol_analytics') == 0){if(function_exists('mom_analytics')){$analyticsConflict = 1;}}
			if(get_option('mommaincontrol_obwcountplus') == 0){if(function_exists('my_optional_modules_count_module') || function_exists('update_obwcountplus_options') || function_exists('obwcountplus_form') || function_exists('obwcountplus_page_content') || function_exists('countsplusplus') || function_exists('obwcountplus_single') || function_exists('obwcountplus_remaining') || function_exists('obwcountplus_total') || function_exists('obwcountplus_count')){$countConflict = 1;}}
			if(get_option('mommaincontrol_momse') == 0){if(function_exists('exclude_post_by_category') || function_exists('exclude_post_by_tag') || function_exists('my_optional_modules_exclude_module') || function_exists('update_momse_options') || function_exists('momse_form') || function_exists('momse_page_content') || function_exists('momse_filter_home')){$excludeConflict = 1;}}
			if(get_option('mommaincontrol_fontawesome') == 0){if(function_exists('mom_plugin_scripts') || function_exists('font_fa_shortcode')){$fontaweomeConflict = 1;}}
			if(get_option('mommaincontrol_versionnumbers') == 0){if(function_exists('mom_remove_version_numbers')){$hidewpversionConflict = 1;}}
			if(get_option('mommaincontrol_momja') == 0){if(function_exists('my_optional_modules_jump_around_module') || function_exists('update_JA') || function_exists('print_jump_around_form') || function_exists('momja_page_content') || function_exists('Jump_Around_jquery_enqueue') || function_exists('jump_around_footer_script')){$jumparoundConflict = 1;}}
			if(get_option('mommaincontrol_lazyload') == 0){if(function_exists('mom_jquery') || function_exists('mom_lazy_load')){$lazyloadConflict = 1;}}
			if(get_option('mommaincontrol_maintenance') == 0){if(function_exists('momMaintenance')){$maintenanceConflict = 1;}}
			if(get_option('mommaincontrol_meta') == 0){if(function_exists('momSEO_add_fields_to_profile') || function_exists('momSEO_add_fields_to_general') || function_exists('mom_SEO_add_twitter_to_general_html') || function_exists('mom_grab_author_count') || function_exists('mom_author_archives_author') || function_exists('mom_author_archives') || function_exists('mom_meta_module') || function_exists('momSEOfeed') || function_exists('momSEOheadscripts') || function_exists('momFindfocus') || function_exists('momSEO_extractCommonWords')){$metaConflict = 1;}}
			if(get_option('mommaincontrol_momrups') == 0){if(function_exists('my_optional_modules_passwords_module') || function_exists('update_rotating_universal_passwords') || function_exists('print_rotating_universal_passwords_form') || function_exists('rotating_universal_passwords_page_content') || function_exists('rotating_universal_passwords_shortcode')){$passwordsConflict = 1;}}
			if(get_option('mommaincontrol_mompaf') == 0){if(function_exists('mompaf_filter_home')){$postasfrontConflict = 1;}}
			if(get_option('mommaincontrol_reviews') == 0){if(function_exists('my_optional_modules_reviews_module') || function_exists('mom_closetags') || function_exists('update_mom_reviews') || function_exists('update_mom_css') || function_exists('print_mom_reviews_form') || function_exists('reviews_page_content') || function_exists('mom_reviews_shortcode') || function_exists('mom_reviews_style')){$reviewsConflict = 1;}}
			if(get_option('mommaincontrol_shorts') == 0){if(function_exists('my_optional_modules_shortcodes_module') || function_exists('mom_shortcodes_page_content') || function_exists('mom_google_map_shortcode') || function_exists('mom_reddit_shortcode') || function_exists('mom_restrict_shortcode') || function_exists('restricted_comments_view') || function_exists('restricted_comments_form') || function_exists('mom_progress_shortcode') || function_exists('mom_verify_shortcode')){$shortcodesConflict = 1;}}
				echo '
				<div class="wrap">
					<span class="moduletitlemain">my optional modules<em>this <strong>is</strong> the pro version.</em></span>
					<div class="new"></div>
					<div class="reminder">
					<i class="fa fa-heart-o"></i> <a href="http://wordpress.org/support/view/plugin-reviews/my-optional-modules">take 5 seconds and review it, won\'t you?</a><span class="right"><strong>remember!  <i class="fa fa-check-square-o"></i> means that it\'s <u>activated</u> and <i class="fa fa-square-o"></i> means that it\'s <u>not</u>.</strong></span>
					</div>
					<div class="powerstation">
						<section class="powerstationbutton">
						<label class="fa fa-bolt"></label>
						</section>
						<section class="formbutton">
							<label class="title">fullmods</label>
						</section>						
						<section class="formbutton">
							<form method="post" name="momReviews">
							<label for="mom_reviews_mode_submit" class="';
								if(get_option('mommaincontrol_reviews') == 1){echo 'on';}
								if(get_option('mommaincontrol_reviews') == 0){echo 'off';}
							echo '">
								<i class="';
								if(get_option('mommaincontrol_reviews') == 1){echo 'fa fa-check-square-o';}
								if(get_option('mommaincontrol_reviews') == 0){echo 'fa fa-square-o';}												
								echo '
								"></i>Reviews
							</label>
							<input type="text" value="';
								if(get_option('mommaincontrol_reviews') == 1){echo '0';}
								if(get_option('mommaincontrol_reviews') == 0){echo '1';}
							echo '
							" name="reviews" class="hide" />
							<input type="submit" id="mom_reviews_mode_submit" name="mom_reviews_mode_submit" class="hide" value="Submit" />
							</form>
						</section>
						';
						// Count++ form section
						echo '
						<section class="formbutton">
							<form method="post" action="" name="momCount">
							<label for="mom_count_mode_submit" class="';
								if(get_option('mommaincontrol_obwcountplus') == 1){echo 'on';}
								if(get_option('mommaincontrol_obwcountplus') == 0){echo 'off';}
							echo '">
								<i class="';
								if(get_option('mommaincontrol_obwcountplus') == 1){echo 'fa fa-check-square-o';}
								if(get_option('mommaincontrol_obwcountplus') == 0){echo 'fa fa-square-o';}												
								echo '
								"></i>Count++
							</label>
							<input type="text" value="';
								if(get_option('mommaincontrol_obwcountplus') == 1){echo '0';}
								if(get_option('mommaincontrol_obwcountplus') == 0){echo '1';}
							echo '
							" name="countplus" class="hide" />
							<input type="submit" id="mom_count_mode_submit" name="mom_count_mode_submit" class="hide" value="Submit" />
							</form>
						</section>';
						// Exclude form section
						echo '
						<section class="formbutton">
							<form method="post" action="" name="momExclude">
							<label for="mom_exclude_mode_submit" class="';
								if(get_option('mommaincontrol_momse') == 1){echo 'on';}
								if(get_option('mommaincontrol_momse') == 0){echo 'off';}
							echo '">
								<i class="';
								if(get_option('mommaincontrol_momse') == 1){echo 'fa fa-check-square-o';}
								if(get_option('mommaincontrol_momse') == 0){echo 'fa fa-square-o';}												
								echo '"></i>Exclude
							</label>
							<input type="text" value="';
								if(get_option('mommaincontrol_momse') == 1){echo '0';}
								if(get_option('mommaincontrol_momse') == 0){echo '1';}
							echo '" name="exclude" class="hide" />
							<input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" class="hide" value="Submit" />
							</form>
						</section>';
						// Jump Around form section
						echo '
						<section class="formbutton">
							<form method="post" action="" name="momJumpAround">
							<label for="mom_jumparound_mode_submit" class="';
								if(get_option('mommaincontrol_momja') == 1){echo 'on';}
								if(get_option('mommaincontrol_momja') == 0){echo 'off';}
							echo '">
								<i class="';
								if(get_option('mommaincontrol_momja') == 1){echo 'fa fa-check-square-o';}
								if(get_option('mommaincontrol_momja') == 0){echo 'fa fa-square-o';}												
								echo '"></i>Jump Around
							</label>
							<input type="text" value="';
								if(get_option('mommaincontrol_momja') == 1){echo '0';}
								if(get_option('mommaincontrol_momja') == 0){echo '1';}
							echo '
							" name="jumparound" class="hide" />
							<input type="submit" id="mom_jumparound_mode_submit" name="mom_jumparound_mode_submit" class="hide" value="Submit" />
							</form>
						</section>';
						// Passwords form section
						echo '
						<section class="formbutton">
							<form method="post" action="" name="momPasswords">
							<label for="mom_passwords_mode_submit" class="';
								if(get_option('mommaincontrol_momrups') == 1){echo 'on';}
								if(get_option('mommaincontrol_momrups') == 0){echo 'off';}
							echo '">
								<i class="';
								if(get_option('mommaincontrol_momrups') == 1){echo 'fa fa-check-square-o';}
								if(get_option('mommaincontrol_momrups') == 0){echo 'fa fa-square-o';}												
								echo '
								"></i>Passwords
							</label>
							<input type="text" value="';
								if(get_option('mommaincontrol_momrups') == 1){echo '0';}
								if(get_option('mommaincontrol_momrups') == 0){echo '1';}
							echo '
							" name="passwords" class="hide" />
							<input type="submit" id="mom_passwords_mode_submit" name="mom_passwords_mode_submit" class="hide" value="Submit" />
							</form>
						</section>';
						// Shortcodes! form section
						echo '
						<section class="formbutton">
							<form method="post" action="" name="momShortcodes">
							<label for="mom_shortcodes_mode_submit" class="';
								if(get_option('mommaincontrol_shorts') == 1){echo 'on';}
								if(get_option('mommaincontrol_shorts') == 0){echo 'off';}
							echo '">
								<i class="';
								if(get_option('mommaincontrol_shorts') == 1){echo 'fa fa-check-square-o';}
								if(get_option('mommaincontrol_shorts') == 0){echo 'fa fa-square-o';}												
								echo '
								"></i>Shortcodes
							</label>
							<input type="text" value="';
								if(get_option('mommaincontrol_shorts') == 1){echo '0';}
								if(get_option('mommaincontrol_shorts') == 0){echo '1';}
							echo '
							" name="shortcodes" class="hide" />
							<input type="submit" id="mom_shortcodes_mode_submit" name="mom_shortcodes_mode_submit" class="hide" value="Submit" />
							</form>
						</section>
						<section class="clear"></section>';						
						
					
												// Font Awesome section
												echo '
												<section class="formbutton">
												<label class="title">automods</label>
												</section>
												<section class="formbutton">
													<form method="post" action="" name="fontawesome">
													<label for="mom_fontawesome_mode_submit" class="';
														if(get_option('mommaincontrol_fontawesome') == 1){echo 'on';}
														if(get_option('mommaincontrol_fontawesome') == 0){echo 'off';}
													echo '">
														<i class="';
														if(get_option('mommaincontrol_fontawesome') == 1){echo 'fa fa-check-square-o';}
														if(get_option('mommaincontrol_fontawesome') == 0){echo 'fa fa-square-o';}	
														echo '
														"></i>Font Awesome
													</label>
													<input type="text" value="';
														if(get_option('mommaincontrol_fontawesome') == 1){echo '0';}
														if(get_option('mommaincontrol_fontawesome') == 0){echo '1';}
													echo '
													" name="mommaincontrol_fontawesome" class="hide" />
													<input type="submit" id="mom_fontawesome_mode_submit" name="mom_fontawesome_mode_submit" class="hide" value="Submit" />
													</form>
												</section>';	
												// Hide WP versions section
												echo '
												<section class="formbutton">
													<form method="post" action="" name="hidewpversions">
													<label for="mom_versions_submit" class="';
														if(get_option('mommaincontrol_versionnumbers') == 1){echo 'on';}
														if(get_option('mommaincontrol_versionnumbers') == 0){echo 'off';}
													echo '">
														<i class="';
														if(get_option('mommaincontrol_versionnumbers') == 1){echo 'fa fa-check-square-o';}
														if(get_option('mommaincontrol_versionnumbers') == 0){echo 'fa fa-square-o';}	
														echo '
														"></i>Hide WP Version
													</label>
													<input type="text" value="';
														if(get_option('mommaincontrol_versionnumbers') == 1){echo '0';}
														if(get_option('mommaincontrol_versionnumbers') == 0){echo '1';}
													echo '
													" name="mommaincontrol_versionnumbers" class="hide" />
													<input type="submit" id="mom_versions_submit" name="mom_versions_submit" class="hide" value="Submit" />
													</form>
												</section>';	
												// Lazy Load section
												echo '
												<section class="formbutton">
													<form method="post" action="" name="lazyload">
													<label for="mom_lazy_mode_submit" class="';
														if(get_option('mommaincontrol_lazyload') == 1){echo 'on';}
														if(get_option('mommaincontrol_lazyload') == 0){echo 'off';}
													echo '">
														<i class="';
														if(get_option('mommaincontrol_lazyload') == 1){echo 'fa fa-check-square-o';}
														if(get_option('mommaincontrol_lazyload') == 0){echo 'fa fa-square-o';}	
														echo '
														"></i>Lazy Load
													</label>
													<input type="text" value="';
														if(get_option('mommaincontrol_lazyload') == 1){echo '0';}
														if(get_option('mommaincontrol_lazyload') == 0){echo '1';}
													echo '
													" name="mommaincontrol_lazyload" class="hide" />
													<input type="submit" id="mom_lazy_mode_submit" name="mom_lazy_mode_submit" class="hide" value="Submit" />
													</form>
												</section>';	
												// Meta section
												echo '<section class="formbutton">
													<form method="post" action="" name="meta">
													<label for="mom_meta_mode_submit" class="';
														if(get_option('mommaincontrol_meta') == 1){echo 'on';}
														if(get_option('mommaincontrol_meta') == 0){echo 'off';}
													echo '">
														<i class="';
														if(get_option('mommaincontrol_meta') == 1){echo 'fa fa-check-square-o';}
														if(get_option('mommaincontrol_meta') == 0){echo 'fa fa-square-o';}	
														echo '
														"></i>Meta
													</label>
													<input type="text" value="';
														if(get_option('mommaincontrol_meta') == 1){echo '0';}
														if(get_option('mommaincontrol_meta') == 0){echo '1';}
													echo '" name="mommaincontrol_meta" class="hide" />
													<input type="submit" id="mom_meta_mode_submit" name="mom_meta_mode_submit" class="hide" value="Submit" />
													</form>
												</section>';						
						
					echo '</div>
					
					<div class="simplemods">';
												// Analytics form section
												echo '
												<section class="formbutton simple">
													<form method="post" action="" name="momAnalytics">
													<label for="mom_analytics_mode_submit" class="';
														if(get_option('mommaincontrol_analytics') == 1){echo 'on';}
														if(get_option('mommaincontrol_analytics') == 0){echo 'off';}
													echo '">
														<i class="';
														if(get_option('mommaincontrol_analytics') == 1){echo 'fa fa-check-square-o';}
														if(get_option('mommaincontrol_analytics') == 0){echo 'fa fa-square-o';}												
														echo '
														"></i>Analytics
													</label>
													<input type="text" value="';
														if(get_option('mommaincontrol_analytics') == 1){echo '0';}
														if(get_option('mommaincontrol_analytics') == 0){echo '1';}
													echo '
													" name="analytics" class="hide" />
													<input type="submit" id="mom_analytics_mode_submit" name="mom_analytics_mode_submit" class="hide" value="Submit" />
													</form>';
													
														echo '
														<form class="setting" method="post" action="">
														<input onClick="this.select();" type="text" value="' . get_option('momanalytics_code') . '" name="momanalytics_code" class="setting" placeholder="UA-XXXXXXXX-X" />
														<input type="submit" id="mom_analytics_code_submit" name="mom_analytics_code_submit" value="Submit" class="hide">
														</form>
														';
													
												echo '
												</section>';
												// Maintenance mode form section
												echo '
												<section class="formbutton simple">
													<form method="post" action="" name="momMaintenance">
													<label for="mom_maintenance_mode_submit" class="';
														if(get_option('mommaincontrol_maintenance') == 1){echo 'on';}
														if(get_option('mommaincontrol_maintenance') == 0){echo 'off';}
													echo '">
														<i class="';
														if(get_option('mommaincontrol_maintenance') == 1){echo 'fa fa-check-square-o';}
														if(get_option('mommaincontrol_maintenance') == 0){echo 'fa fa-square-o';}												
														echo '
														"></i>Maintenance
													</label>
													<input type="text" value="';
														if(get_option('mommaincontrol_maintenance') == 1){echo '0';}
														if(get_option('mommaincontrol_maintenance') == 0){echo '1';}
													echo '
													" name="maintenanceMode" class="hide" />
													<input type="submit" id="mom_maintenance_mode_submit" name="mom_maintenance_mode_submit" class="hide" value="Submit" />
													</form>';
													
														echo '
														<form class="setting" method="post" action="">
														<input placeholder="http://url.tld" onClick="this.select();" type="text" value="' . get_option('momMaintenance_url') . '" name="momMaintenance_url" class="setting" />
														<input type="submit" id="mom_maintenance_url_submit" name="mom_maintenance_url_submit" value="Submit" class="hide">
														</form>
														';
													
												echo '
												</section>';
												// Post as front form section
												echo '
												<section class="formbutton simple">
													<form method="post" action="" name="mompaf">
													<label for="mom_postasfront_mode_submit" class="';
														if(get_option('mommaincontrol_mompaf') == 1){echo 'on';}
														if(get_option('mommaincontrol_mompaf') == 0){echo 'off';}
													echo '">
														<i class="';
														if(get_option('mommaincontrol_mompaf') == 1){echo 'fa fa-check-square-o';}
														if(get_option('mommaincontrol_mompaf') == 0){echo 'fa fa-square-o';}	
														echo '
														"></i>Post as Front
													</label>
													<input type="text" value="';
														if(get_option('mommaincontrol_mompaf') == 1){echo '0';}
														if(get_option('mommaincontrol_mompaf') == 0){echo '1';}
													echo '
													" name="postasfront" class="hide" />
													<input type="submit" id="mom_postasfront_mode_submit" name="mom_postasfront_mode_submit" class="hide" value="Submit" />
													</form>';
													
														echo '
														<form class="setting" method="post" action="">
																
																<select name="mompaf_post" class="setting" id="mompaf_0">
																<option value="0" '; if (get_option('mompaf_post') == 0){echo 'selected="selected"';} echo '/>Latest post</option>';
																	$showmeposts = get_posts(array('posts_per_page' => -1)); 
																	foreach ($showmeposts as $postsshown){
																		echo '<option name="mompaf_post" id="mompaf_'.$postsshown->ID.'" value="'.$postsshown->ID.'"'; 
																		if (get_option('mompaf_post') == $postsshown->ID){echo ' selected="selected"';} echo '>
																		'.$postsshown->post_title.'</option>';
																	}
																	echo '
																	</select>
														<label for="mom_postasfront_post_submit" class="select"><i class="fa fa-save"></i>Save</label>
														<input type="submit" id="mom_postasfront_post_submit" name="mom_postasfront_post_submit" value="Submit" class="hide">
														</form>
														';
													
												echo '
												</section>
					
					</div>
					
					<div class="databasecleaner">';
					include(plugin_dir_path(__FILE__).'databasecleaner.php');
					echo '</div>';
					
					if(!isset($_POST['introduction'])){
					echo '
					<form class="introduction" method="post">
					<input type="submit" value="Having trouble?" name="introduction">
					</form>';
					}else{
					echo '
					<form class="introduction" method="post">
					<input type="submit" value="Problem solved?" name="cancel">
					</form>
					';
					}
					if(isset($_POST['introduction'])){
					echo '
					<div class="introduction">
					<p>questions?  bug reports?  comments?<br /><a href="http://www.onebillionwords.com/my-optional-modules/">my optional modules</a> official plugin page.</p>
					</div>
					';
					}
					echo '
					<div class="postbox-container" style="width:798px;margin-right:5px;">
						<div class="metabox-holder">
							<div class="meta-box-sortables ui-sortable">
								<div id="modules" class="postbox">';
									
											if(!isset($_POST['mom_delete_step_one'])){
											echo '
											<section>
												<form class="uninstall" method="post" action="" name="mom_delete_step_one">
												<label for="mom_delete_step_one" class="off">
													<i class="fa fa-warning"></i> Click to Uninstall
												</label>
												<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hide" value="Submit" />
												</form>
											</section>';
											}
											if(isset($_POST['mom_delete_step_one'])){
											echo '
											<section>
												<form class="uninstall" method="post" action="" name="MOM_UNINSTALL_EVERYTHING">
												<label for="MOM_UNINSTALL_EVERYTHING" class="off">
													<i class="fa fa-warning"></i> Confirm Uninstall
												</label>
												<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hide" value="Submit" />
												</form>
											</section>';
											}																				
									
									
											echo '
											<form method="post" class="topnavigation">
												<section><label class="configurationlabel" for="MOMclear">Home</label>
												<input id="MOMclear" name="MOMclear" class="hidden" type="submit"></section>
											';
											if (
												get_option('mommaincontrol_obwcountplus') == 1 || 
												get_option('mommaincontrol_momse') == 1 || 
												get_option('mommaincontrol_momrups') == 1 || 
												get_option('mommaincontrol_momja') == 1 || 
												get_option('mommaincontrol_shorts') == 1 || 
												get_option('mommaincontrol_reviews') == 1 
											){
												if(get_option('mommaincontrol_obwcountplus') == 1){ 
													echo '<section><label class="configurationlabel" for="MOMcount"></i>Count++</label><input id="MOMcount" name="MOMcount" class="hidden" type="submit"></section>';
												}
												if(get_option('mommaincontrol_momse') == 1){
													echo '<section><label class="configurationlabel" for="MOMexclude">Exclude</label><input id="MOMexclude" name="MOMexclude" class="hidden" type="submit"></section>';
												}
												if(get_option('mommaincontrol_momrups') == 1){
													echo '<section><label class="configurationlabel" for="MOMpasswords">Passwords</label><input id="MOMpasswords" name="MOMpasswords" class="hidden" type="submit"></section>';
												}
												if(get_option('mommaincontrol_momja') == 1){
													echo '<section><label class="configurationlabel" for="MOMjumparound">Jump Around</label><input id="MOMjumparound" name="MOMjumparound" class="hidden" type="submit"></section>'; 
												}
												if (get_option('mommaincontrol_reviews') == 1){
													echo '<section><label class="configurationlabel" for="MOMreviews">Reviews</label><input id="MOMreviews" name="MOMreviews" class="hidden" type="submit"></section>'; 
												}
												if (get_option('mommaincontrol_shorts') == 1){
													echo '<section><label class="configurationlabel" for="MOMshortcodes"></i>Shortcodes</label><input id="MOMshortcodes" name="MOMshortcodes" class="hidden" type="submit"></section>'; 
												}
											}		
											echo '</form>									
									
									
									
									<div class="inside">';
									
									
									
										if(get_option('mommaincontrol_focus') == ''){
											// Upgrade from old option names to new option names and transfer all previous settings to the new ones
											if(get_option('mommaincontrol_momse') == 1){
												function MOMExcludeUpgrade(){$MOMExclude01 = (get_option('simple_announcement_with_exclusion_cat_visitor'));$MOMExclude02 = (get_option('simple_announcement_with_exclusion_tag_visitor'));$MOMExclude03 = (get_option('simple_announcement_with_exclusion_9'));$MOMExclude04 = (get_option('simple_announcement_with_exclusion_9_2'));$MOMExclude05 = (get_option('simple_announcement_with_exclusion_9_3'));$MOMExclude06 = (get_option('simple_announcement_with_exclusion_9_4'));$MOMExclude07 = (get_option('simple_announcement_with_exclusion_9_5'));$MOMExclude08 = (get_option('simple_announcement_with_exclusion_9_7'));$MOMExclude09 = (get_option('simple_announcement_with_exclusion_9_8'));$MOMExclude10 = (get_option('simple_announcement_with_exclusion_9_9'));$MOMExclude11 = (get_option('simple_announcement_with_exclusion_9_10'));$MOMExclude12 = (get_option('simple_announcement_with_exclusion_9_11'));$MOMExclude13 = (get_option('simple_announcement_with_exclusion_9_12'));$MOMExclude14 = (get_option('simple_announcement_with_exclusion_9_13'));$MOMExclude15 = (get_option('simple_announcement_with_exclusion_9_14'));$MOMExclude16 = (get_option('simple_announcement_with_exclusion_sun'));$MOMExclude17 = (get_option('simple_announcement_with_exclusion_mon'));$MOMExclude18 = (get_option('simple_announcement_with_exclusion_tue'));$MOMExclude19 = (get_option('simple_announcement_with_exclusion_wed'));$MOMExclude20 = (get_option('simple_announcement_with_exclusion_thu'));$MOMExclude21 = (get_option('simple_announcement_with_exclusion_fri'));$MOMExclude22 = (get_option('simple_announcement_with_exclusion_sat'));$MOMExclude23 = (get_option('simple_announcement_with_exclusion_cat_sun'));$MOMExclude24 = (get_option('simple_announcement_with_exclusion_cat_mon'));$MOMExclude25 = (get_option('simple_announcement_with_exclusion_cat_tue'));$MOMExclude26 = (get_option('simple_announcement_with_exclusion_cat_wed'));$MOMExclude27 = (get_option('simple_announcement_with_exclusion_cat_thu'));$MOMExclude28 = (get_option('simple_announcement_with_exclusion_cat_fri'));$MOMExclude29 = (get_option('simple_announcement_with_exclusion_cat_sat'));add_option('MOM_Exclude_VisitorCategories',$MOMExclude01);delete_option('simple_announcement_with_exclusion_cat_visitor');add_option('MOM_Exclude_VisitorTags',$MOMExclude02);delete_option('simple_announcement_with_exclusion_tag_visitor');add_option('MOM_Exclude_Categories_Front',$MOMExclude03);delete_option('simple_announcement_with_exclusion_9');add_option('MOM_Exclude_Categories_TagArchives',$MOMExclude04);delete_option('simple_announcement_with_exclusion_9_2');add_option('MOM_Exclude_Categories_SearchResults',$MOMExclude05);delete_option('simple_announcement_with_exclusion_9_3');add_option('MOM_Exclude_Tags_Front',$MOMExclude06);delete_option('simple_announcement_with_exclusion_9_4');add_option('MOM_Exclude_Tags_CategoryArchives',$MOMExclude07);delete_option('simple_announcement_with_exclusion_9_5');add_option('MOM_Exclude_Tags_SearchResults',$MOMExclude08);delete_option('simple_announcement_with_exclusion_9_7');add_option('MOM_Exclude_PostFormats_Front',$MOMExclude09);delete_option('simple_announcement_with_exclusion_9_8');add_option('MOM_Exclude_PostFormats_CategoryArchives',$MOMExclude10);delete_option('simple_announcement_with_exclusion_9_9');add_option('MOM_Exclude_PostFormats_TagArchives',$MOMExclude11);delete_option('simple_announcement_with_exclusion_9_10');add_option('MOM_Exclude_PostFormats_SearchResults',$MOMExclude12);delete_option('simple_announcement_with_exclusion_9_11');add_option('MOM_Exclude_Categories_RSS',$MOMExclude13);delete_option('simple_announcement_with_exclusion_9_12');add_option('MOM_Exclude_Tags_RSS',$MOMExclude14);delete_option('simple_announcement_with_exclusion_9_13');add_option('MOM_Exclude_PostFormats_RSS',$MOMExclude15);delete_option('simple_announcement_with_exclusion_9_14');add_option('MOM_Exclude_TagsSun',$MOMExclude16);delete_option('simple_announcement_with_exclusion_sun');add_option('MOM_Exclude_TagsMon',$MOMExclude17);delete_option('simple_announcement_with_exclusion_mon');add_option('MOM_Exclude_TagsTue',$MOMExclude18);delete_option('simple_announcement_with_exclusion_tue');add_option('MOM_Exclude_TagsWed',$MOMExclude19);delete_option('simple_announcement_with_exclusion_wed');add_option('MOM_Exclude_TagsThu',$MOMExclude20);delete_option('simple_announcement_with_exclusion_thu');add_option('MOM_Exclude_TagsFri',$MOMExclude21);delete_option('simple_announcement_with_exclusion_fri');add_option('MOM_Exclude_TagsSat',$MOMExclude22);delete_option('simple_announcement_with_exclusion_sat');add_option('MOM_Exclude_CategoriesSun',$MOMExclude23);delete_option('simple_announcement_with_exclusion_cat_sun');add_option('MOM_Exclude_CategoriesMon',$MOMExclude24);delete_option('simple_announcement_with_exclusion_cat_mon');add_option('MOM_Exclude_CategoriesTue',$MOMExclude25);delete_option('simple_announcement_with_exclusion_cat_tue');add_option('MOM_Exclude_CategoriesWed',$MOMExclude26);delete_option('simple_announcement_with_exclusion_cat_wed');add_option('MOM_Exclude_CategoriesThu',$MOMExclude27);delete_option('simple_announcement_with_exclusion_cat_thu');add_option('MOM_Exclude_CategoriesFri',$MOMExclude28);delete_option('simple_announcement_with_exclusion_cat_fri');add_option('MOM_Exclude_CategoriesSat',$MOMExclude29);delete_option('simple_announcement_with_exclusion_cat_sat');}		
												if(get_option('simple_announcement_with_exclusion_cat_visitor') != '' || get_option('simple_announcement_with_exclusion_tag_visitor') != '' || get_option('simple_announcement_with_exclusion_9') != '' || get_option('simple_announcement_with_exclusion_9_2') != '' || get_option('simple_announcement_with_exclusion_9_3') != '' || get_option('simple_announcement_with_exclusion_9_4') != '' || get_option('simple_announcement_with_exclusion_9_5') != '' || get_option('simple_announcement_with_exclusion_9_7') != '' || get_option('simple_announcement_with_exclusion_9_8') != '' || get_option('simple_announcement_with_exclusion_9_9') != '' || get_option('simple_announcement_with_exclusion_9_10') != '' || get_option('simple_announcement_with_exclusion_9_11') != '' || get_option('simple_announcement_with_exclusion_9_12') != '' || get_option('simple_announcement_with_exclusion_9_13') != '' || get_option('simple_announcement_with_exclusion_9_14') != '' || get_option('simple_announcement_with_exclusion_sun') != '' || get_option('simple_announcement_with_exclusion_mon') != '' || get_option('simple_announcement_with_exclusion_tue') != '' || get_option('simple_announcement_with_exclusion_wed') != '' || get_option('simple_announcement_with_exclusion_thu') != '' || get_option('simple_announcement_with_exclusion_fri') != '' || get_option('simple_announcement_with_exclusion_sat') != '' || get_option('simple_announcement_with_exclusion_cat_sun') != '' || get_option('simple_announcement_with_exclusion_cat_mon') != '' || get_option('simple_announcement_with_exclusion_cat_tue') != '' || get_option('simple_announcement_with_exclusion_cat_wed') != '' || get_option('simple_announcement_with_exclusion_cat_thu') != '' || get_option('simple_announcement_with_exclusion_cat_fri') != '' || get_option('simple_announcement_with_exclusion_cat_sat') != '' ){
												echo '<label class="upgrade" for="MOMExcludeUpgrade"><i class="fa fa-exclamation-triangle"></i> Click here to upgrade Exclude</label>
												<form method="post"><input id="MOMExcludeUpgrade" name="MOMExcludeUpgrade" type="submit" value="Submit" class="hidden"/></form>';
												if(isset($_POST['MOMExcludeUpgrade'])){MOMExcludeUpgrade();echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}}
											}
											echo '
											<div class="panelSection clear plugin">
												<blockquote>
												<p>';
												echo 'Module information<br />';
												if(!get_option('mommaincontrol_analytics')){echo 'Analytics has never been activated.<br />';}else{echo 'Analytics has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_obwcountplus')){echo 'Count++ has never been activated.<br />';}else{echo 'Count++ has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_momse')){echo 'Exclude has never been activated.<br />';}else{echo 'Exclude has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_fontawesome')){echo 'Font Awesome has never been activated.<br />';}else{echo 'Font Awesome has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_versionnumbers')){echo 'Hide WP Version has never been activated..<br />';}else{echo 'Hide WP Version has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_momja')){echo 'Jump Around has never been activated.<br />';}else{echo 'Jump Around has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_lazyload')){echo 'Lazy Load has never been activated.<br />';}else{echo 'Lazy Load has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_maintenance')){echo 'Maintenance Mode has never been activated.<br />';}else{echo 'Maintenance Mode has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_meta')){echo 'Meta has never been activated.<br />';}else{echo 'Meta has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_momrups')){echo 'Passwords has never been activated.<br />';}else{echo 'Passwords has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_mompaf')){echo 'Post as Front has never been activated.<br />';}else{echo 'Post as Front has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_reviews')){echo 'Reviews has never been activated.<br />';}else{echo 'Reviews has been activated/deactivated at least once.<br />';}
												if(!get_option('mommaincontrol_shorts')){echo 'Shortcodes has never been activated.<br />';}else{echo 'Shortcodes has been activated/deactivated at least once.<br />';}
												echo '
												</p>
												<p>';
												$checkSalt = wp_salt();if($checkSalt == ''){echo 'No salt detected for Module: Passwords.<br />';}
												$momConflicts = 0;
												if($analyticsConflict == 1){$momConflicts++;echo 'Conflicts found: Analytics';echo '<br />';}
												if($countConflict == 1){$momConflicts++;echo 'Conflicts found: Count++';echo '<br />';}
												if($excludeConflict == 1){$momConflicts++;echo 'Conflicts found: Exclude';echo '<br />';}
												if($fontaweomeConflict == 1){ $momConflicts++;echo 'Conflicts found: Font Awesome';echo '<br />';}
												if($hidewpversionConflict == 1){$momConflicts++;echo 'Conflicts found: Hide WP Version';echo '<br />';}
												if($jumparoundConflict == 1){$momConflicts++;echo 'Conflicts found: Jump Around';echo '<br />';}
												if($lazyloadConflict == 1){$momConflicts++;echo 'Conflicts found: Lazy Load';echo '<br />';}
												if($maintenanceConflict == 1){$momConflicts++;echo 'Conflicts found: Maintenance mode';echo '<br />';}
												if($metaConflict == 1){$momConflicts++;echo 'Conflicts found: Meta';echo '<br />';}
												if($passwordsConflict == 1){$momConflicts++;echo 'Conflicts found: Passwords';echo '<br />';}
												if($postasfrontConflict == 1){$momConflicts++;echo 'Conflict found: Post as Front';echo '<br />';}
												if($reviewsConflict == 1){$momConflicts++;echo 'Conflicts found: Reviews';echo '<br />';}
												if($shortcodesConflict == 1){$momConflicts++;echo 'Conflicts found: Shortcodes';echo '<br />';}
												echo '</p>';
											echo '
												</blockquote>
											</div>';
										}
										if(get_option('mommaincontrol_focus') != ''){
											echo '
											<div class="panelSection clear plugin">';
												if(get_option('mommaincontrol_obwcountplus') == 1 && get_option('mommaincontrol_focus') == 'count'){include(plugin_dir_path(__FILE__).'countplusplus.php');}
												elseif(get_option('mommaincontrol_momse') == 1 && get_option('mommaincontrol_focus') == 'exclude'){include(plugin_dir_path(__FILE__).'exclude.php');}
												elseif(get_option('mommaincontrol_momja') == 1 && get_option('mommaincontrol_focus') == 'jumparound'){include(plugin_dir_path(__FILE__).'jumparound.php');}
												elseif(get_option('mommaincontrol_momrups') == 1 && get_option('mommaincontrol_focus') == 'passwords'){include(plugin_dir_path(__FILE__).'passwords.php');}
												elseif(get_option('mommaincontrol_reviews') == 1 && get_option('mommaincontrol_focus') == 'reviews'){include(plugin_dir_path(__FILE__).'reviews.php');}
												elseif(get_option('mommaincontrol_shorts') == 1 && get_option('mommaincontrol_focus') == 'shortcodes'){include(plugin_dir_path(__FILE__).'shortcodes.php');}
											echo '</div>';
										}
									echo '
									</div>
								</div>
							</div>
						</div>
					</div>
				<div class="clear"></div>';
		}
	}
 ?>