<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }
    
    //    MY OPTIONAL MODULES (MAIN CONTROL)
    
    //    CONTENTS
    //        Add options page for plugin to Wordpress backend
    //        Update base options when main form is submitted
    //        Main form content to display on the options page
    //        Content to display on the options page  

    if ( is_admin() ) { 
		memory_get_usage();
		// Load our updater file to handle form requests for options
		include( plugin_dir_path( __FILE__ ) . '_updater.php');
	
	
        // Add options page for plugin to Wordpress backend
        add_action("admin_menu", "my_optional_modules_add_options_page");
        function my_optional_modules_add_options_page() { 
            add_options_page( 'My Optional Modules', 'My Optional Modules', 'manage_options', 'mommaincontrol', 'my_optional_modules_page_content'); 
        }





        // Content to display on the options page
        function my_optional_modules_page_content() {

			if ( get_option( 'mommaincontrol_analytics' ) == 0 ) { if ( function_exists( 'mom_analytics' ) ) { $analyticsConflict = 1; } }
			if ( get_option( 'mommaincontrol_obwcountplus' ) == 0 ) { if ( function_exists( 'my_optional_modules_count_module' ) || function_exists( 'update_obwcountplus_options' ) || function_exists( 'obwcountplus_form' ) || function_exists( 'obwcountplus_page_content' ) || function_exists( 'countsplusplus' ) || function_exists( 'obwcountplus_single' ) || function_exists( 'obwcountplus_remaining' ) || function_exists( 'obwcountplus_total' ) || function_exists( 'obwcountplus_count' ) ) { $countConflict = 1; } }
			if ( get_option( 'mommaincontrol_momse' ) == 0 ) { if ( function_exists('exclude_post_by_category') || function_exists('exclude_post_by_tag') || function_exists( 'my_optional_modules_exclude_module' ) || function_exists( 'update_momse_options' ) || function_exists( 'momse_form' ) || function_exists( 'momse_page_content' ) || function_exists( 'momse_filter_home' ) ) { $excludeConflict = 1; } }
			if ( get_option( 'mommaincontrol_fontawesome' ) == 0 ) { if ( function_exists( 'mom_plugin_scripts' ) || function_exists( 'font_fa_shortcode' ) ) { $fontaweomeConflict = 1; } }
			if ( get_option( 'mommaincontrol_versionnumbers' ) == 0 ) { if ( function_exists( 'mom_remove_version_numbers' ) ) { $hidewpversionConflict = 1; } }
			if ( get_option( 'mommaincontrol_momja' ) == 0 ) { if ( function_exists( 'my_optional_modules_jump_around_module' ) || function_exists( 'update_JA' ) || function_exists( 'print_jump_around_form' ) || function_exists( 'momja_page_content' ) || function_exists( 'Jump_Around_jquery_enqueue' ) || function_exists( 'jump_around_footer_script' ) ) { $jumparoundConflict = 1; } }
			if ( get_option( 'mommaincontrol_lazyload' ) == 0 ) { if ( function_exists( 'mom_jquery' ) || function_exists( 'mom_lazy_load' ) ) { $lazyloadConflict = 1; } }
			if ( get_option( 'mommaincontrol_maintenance' ) == 0  ) { if ( function_exists( 'momMaintenance' ) ) { $maintenanceConflict = 1; } }
			if ( get_option( 'mommaincontrol_meta' ) == 0 ) { if ( function_exists( 'momSEO_add_fields_to_profile' ) || function_exists( 'momSEO_add_fields_to_general' ) || function_exists( 'mom_SEO_add_twitter_to_general_html' ) || function_exists( 'mom_grab_author_count' ) || function_exists( 'mom_author_archives_author' ) || function_exists( 'mom_author_archives' ) || function_exists( 'mom_meta_module' ) || function_exists( 'momSEOfeed' ) || function_exists( 'momSEOheadscripts' ) || function_exists( 'momFindfocus' ) || function_exists( 'momSEO_extractCommonWords' ) ) { $metaConflict = 1; } }
			if ( get_option( 'mommaincontrol_momrups' ) == 0  ) { if ( function_exists( 'my_optional_modules_passwords_module' ) || function_exists( 'update_rotating_universal_passwords' ) || function_exists( 'print_rotating_universal_passwords_form' ) || function_exists( 'rotating_universal_passwords_page_content' ) || function_exists( 'rotating_universal_passwords_shortcode' ) ) { $passwordsConflict = 1; } }
			if ( get_option( 'mommaincontrol_mompaf' ) == 0 ) { if ( function_exists( 'mompaf_filter_home' ) ) { $postasfrontConflict = 1; } }
			if ( get_option( 'mommaincontrol_reviews') == 0 ) { if ( function_exists( 'my_optional_modules_reviews_module' ) || function_exists( 'mom_closetags' ) || function_exists( 'update_mom_reviews' ) || function_exists( 'update_mom_css' ) || function_exists( 'print_mom_reviews_form' ) || function_exists( 'reviews_page_content' ) || function_exists( 'mom_reviews_shortcode' ) || function_exists( 'mom_reviews_style' ) ) { $reviewsConflict = 1; } }
			if ( get_option( 'mommaincontrol_shorts' ) == 0 ) { if ( function_exists( 'my_optional_modules_shortcodes_module' ) || function_exists( 'mom_shortcodes_page_content' ) || function_exists( 'mom_google_map_shortcode' ) || function_exists( 'mom_reddit_shortcode' ) || function_exists( 'mom_restrict_shortcode' ) || function_exists( 'restricted_comments_view' ) || function_exists( 'restricted_comments_form' ) || function_exists( 'mom_progress_shortcode' ) || function_exists( 'mom_verify_shortcode' ) ) { $shortcodesConflict = 1; } }
		
            echo "
				<div class=\"wrap\">
					<h2>My Optional Modules</h2>
					<div class=\"postbox-container\" style=\"width:685px;margin-right:5px;\">
						<div class=\"metabox-holder\">
							<div class=\"meta-box-sortables ui-sortable\">
								<div id=\"modules\" class=\"postbox\" >
									<h3 class=\"hndle\"><span>Control Panel</span></h3>";echo "
									<div class=\"inside\">";
										
										if ( get_option( 'mommaincontrol_focus'        ) == '' ) {

										echo "<blockquote>";
										include( plugin_dir_path( __FILE__ ) . 'databasecleaner.php');
										echo "</blockquote>
										
										<div class=\"panelSection clear plugin\">
											<blockquote>
											<ol>";
											echo "<li class=\"listtitle\">Module information<ol>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_analytics'      ) ) { echo "Analytics has never been activated..<br />";        } else { echo "Analytics has been activated/deactivated at least once.<br />";        } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_obwcountplus'   ) ) { echo "Count++ has never been activated.<br />";           } else { echo "Count++ has been activated/deactivated at least once.<br />";          } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_momse'          ) ) { echo "Exclude has never been activated..<br />";          } else { echo "Exclude has been activated/deactivated at least once.<br />";          } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_fontawesome'    ) ) { echo "Font Awesome has never been activated..<br />";     } else { echo "Font Awesome has been activated/deactivated at least once.<br />";     } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_versionnumbers' ) ) { echo "Hide WP Version has never been activated..<br />";  } else { echo "Hide WP Version has been activated/deactivated at least once.<br />";  } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_momja'          ) ) { echo "Jump Around has never been activated..<br />";      } else { echo "Jump Around has been activated/deactivated at least once.<br />";      } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_lazyload'       ) ) { echo "Lazy Load has never been activated..<br />";        } else { echo "Lazy Load has been activated/deactivated at least once.<br />";        } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_maintenance'    ) ) { echo "Maintenance Mode has never been activated..<br />"; } else { echo "Maintenance Mode has been activated/deactivated at least once.<br />"; } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_meta'           ) ) { echo "Meta has never been activated..<br />";             } else { echo "Meta has been activated/deactivated at least once.<br />";             } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_momrups'        ) ) { echo "Passwords has never been activated.<br />";         } else { echo "Passwords has been activated/deactivated at least once.<br />";        } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_mompaf'         ) ) { echo "Post as Front has never been activated..<br />";    } else { echo "Post as Front has been activated/deactivated at least once.<br />";    } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_reviews'        ) ) { echo "Reviews has never been activated..<br />";          } else { echo "Reviews has been activated/deactivated at least once.<br />";          } echo "</li>";
											echo "<li>"; if ( !get_option( 'mommaincontrol_shorts'         ) ) { echo "Shortcodes has never been activated..<br />";       } else { echo "Shortcodes has been activated/deactivated at least once.<br />";       } echo "</li>";
											echo "
											</ol></li>
											
											<li class=\"listtitle\">Compatability check<ol>";
											global $wp_version;
											mom_check_repo_version();
											echo "<li>";                         if ( $wp_version < '3.7' ) { echo "Your WordPress installation may be out of date."; } else { echo "Wordpress version is 3.7.1 - looks good."; } echo "</li>";
											echo "<li>"; $checkSalt = wp_salt(); if ( $checkSalt == ''       ) { echo "No salt detected."; } else { echo "Salt for Passwords detected as: " . $checkSalt; } echo "</li>";
											// Check conflicts
											$momConflicts = 0;
											if ( $analyticsConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Analytics"; echo "</li>"; }
											if ( $countConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Count++"; echo "</li>";  }
											if ( $excludeConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Exclude"; echo "</li>"; }
											if ( $fontaweomeConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Font Awesome"; echo "</li>"; }
											if ( $hidewpversionConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Hide WP Version"; echo "</li>"; }
											if ( $jumparoundConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Jump Around"; echo "</li>"; }
											if ( $lazyloadConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Lazy Load"; echo "</li>"; }
											if ( $maintenanceConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Maintenance mode"; echo "</li>"; }
											if ( $metaConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Meta"; echo "</li>"; }
											if ( $passwordsConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Passwords"; echo "</li>"; }
											if ( $postasfrontConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflict found: Post as Front"; echo "</li>";  }
											if ( $reviewsConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Reviews"; echo "</li>"; }
											if ( $shortcodesConflict == 1 ) { echo "<li>"; $momConflicts++; echo "Conflicts found: Shortcodes"; echo "</li>"; }
											if ( $momConflicts == 0 ) { echo "<li>No plugin conflicts were found.  Looks good!</li>"; } else { echo "<li>" . $momConflicts . " conflicts were found.  If refreshing the page does not clear this message, then there really is a conflict."; }
											echo "</ol></li>
											</ol>
											</blockquote>
										</div>";
										}
										
										if ( get_option( 'mommaincontrol_focus' ) != '' ) {
											echo "
											<div class=\"panelSection clear plugin\">";
												if     ( get_option( 'mommaincontrol_obwcountplus') == 1 && get_option( 'mommaincontrol_focus' ) == 'count'       ) { include( plugin_dir_path( __FILE__ ) . 'countplusplus.php'); }
												elseif ( get_option( 'mommaincontrol_momse') == 1 && get_option( 'mommaincontrol_focus' ) == 'exclude'            ) { include( plugin_dir_path( __FILE__ ) . 'exclude.php');       }
												elseif ( get_option( 'mommaincontrol_momja') == 1 && get_option( 'mommaincontrol_focus' ) == 'jumparound'         ) { include( plugin_dir_path( __FILE__ ) . 'jumparound.php');    }
												elseif ( get_option( 'mommaincontrol_momrups') == 1 && get_option( 'mommaincontrol_focus' ) == 'passwords'        ) { include( plugin_dir_path( __FILE__ ) . 'passwords.php');     }
												elseif ( get_option( 'mommaincontrol_reviews') == 1 && get_option( 'mommaincontrol_focus' ) == 'reviews'          ) { include( plugin_dir_path( __FILE__ ) . 'reviews.php');       }
												elseif ( get_option( 'mommaincontrol_shorts') == 1 && get_option( 'mommaincontrol_focus' ) == 'shortcodes'        ) { include( plugin_dir_path( __FILE__ ) . 'shortcodes.php');    }
											echo "
											</div>";
										}										
										
									echo "	
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class=\"postbox-container side\" style=\"width:200px;\">
						<div class=\"metabox-holder\">
							<div class=\"meta-box-sortables ui-sortable\">
								<div id=\"information\" class=\"postbox\">
									<h3 class=\"hdnle\"><span>Modules</span></h3>
									<div class=\"inside\">
									
										<div class=\"moduleform\">";
											
											if ( !isset( $_POST[ 'mom_delete_step_one' ] ) ) {
											echo "
											<section>";
												echo "
												<form method=\"post\" action=\"\" name=\"mom_delete_step_one\">
												<label for=\"mom_delete_step_one\" class=\"off\">
													<i class=\"fa fa-trash-o\"></i> Uninstall Step 1 of 2
												</label>
												<input type=\"submit\" id=\"mom_delete_step_one\" name=\"mom_delete_step_one\" class=\"hide\" value=\"Submit\" />
												</form>
											</section>";
											}
											if ( isset( $_POST[ 'mom_delete_step_one' ] ) ) {
											echo "
											<section>";
												echo "
												<form method=\"post\" action=\"\" name=\"MOM_UNINSTALL_EVERYTHING\">
												<label for=\"MOM_UNINSTALL_EVERYTHING\" class=\"off\">
													<i class=\"fa fa-trash-o\"></i> Confirm Step 2 of 2
												</label>
												<input type=\"submit\" id=\"MOM_UNINSTALL_EVERYTHING\" name=\"MOM_UNINSTALL_EVERYTHING\" class=\"hide\" value=\"Submit\" />
												</form>
											</section>";
											}											
										
											echo "
											<form method=\"post\">
												<section><label class=\"configurationlabel\" for=\"MOMclear\"><i class=\"fa fa-home\"></i>Home</label>
												<input id=\"MOMclear\" name=\"MOMclear\" class=\"hidden\" type=\"submit\"></section>
											";
											if ( 
												get_option( 'mommaincontrol_obwcountplus' ) == 1 || 
												get_option( 'mommaincontrol_momse'        ) == 1 || 
												get_option( 'mommaincontrol_momrups'      ) == 1 || 
												get_option( 'mommaincontrol_momja'        ) == 1 || 
												get_option( 'mommaincontrol_shorts'       ) == 1 || 
												get_option( 'mommaincontrol_reviews'      ) == 1 
											) {
												echo "<section><label class=\"labeltitle\"><i class=\"fa fa-level-down\"></i><span>Configuration</span></label></section>";										
												if ( get_option( 'mommaincontrol_obwcountplus' ) == 1 ) { 
													echo "<section><label class=\"configurationlabel\" for=\"MOMcount\"><i title=\"Count++ settings\" class=\"fa fa-cog"; 
													if ( get_option( 'mommaincontrol_focus' ) == "count" ) {
														echo " active"; 
													}
													echo "\"></i>Count++</label><input id=\"MOMcount\" name=\"MOMcount\" class=\"hidden\" type=\"submit\"></section>"; 
												}
												if ( get_option( 'mommaincontrol_momse' ) == 1 ) {
													echo "<section><label class=\"configurationlabel\" for=\"MOMexclude\"><i title=\"Exclude settings\" class=\"fa fa-cog"; 
													if ( get_option( 'mommaincontrol_focus' ) == "exclude" ) {
														echo " active"; 
													}
													echo "\"></i>Exclude</label><input id=\"MOMexclude\" name=\"MOMexclude\" class=\"hidden\" type=\"submit\"></section>"; 
												}
												if ( get_option( 'mommaincontrol_momrups' ) == 1 ) {
													echo "<section><label class=\"configurationlabel\" for=\"MOMpasswords\"><i title=\"Passwords settings\" class=\"fa fa-cog"; 
													if ( get_option( 'mommaincontrol_focus' ) == "passwords" ) {
														echo " active"; 
													}
													echo "\"></i>Passwords</label><input id=\"MOMpasswords\" name=\"MOMpasswords\" class=\"hidden\" type=\"submit\"></section>"; 
												}
												if ( get_option( 'mommaincontrol_momja' ) == 1 ) {
													echo "<section><label class=\"configurationlabel\" for=\"MOMjumparound\"><i title=\"Jump Around settings\" class=\"fa fa-cog"; 
													if ( get_option( 'mommaincontrol_focus' ) == "jumparound" ) {
														echo " active"; 
													}
													echo "\"></i>Jump Around</label><input id=\"MOMjumparound\" name=\"MOMjumparound\" class=\"hidden\" type=\"submit\"></section>"; 
												}
												if ( get_option( 'mommaincontrol_reviews' ) == 1 ) {
													echo "<section><label class=\"configurationlabel\" for=\"MOMreviews\"><i title=\"Reviews settings\" class=\"fa fa-cog"; 
													if ( get_option( 'mommaincontrol_focus' ) == "reviews" ) {
														echo " active"; 
													}
													echo "\"></i>Reviews</label><input id=\"MOMreviews\" name=\"MOMreviews\" class=\"hidden\" type=\"submit\"></section>"; 
												}
												if ( get_option( 'mommaincontrol_shorts' ) == 1 ) {
													echo "<section><label class=\"configurationlabel\" for=\"MOMshortcodes\"><i title=\"Shortcodes settings\" class=\"fa fa-cog"; 
													if ( get_option( 'mommaincontrol_focus' ) == "shortcodes" ) {
														echo " active"; 
													}
													echo "\"></i>Shortcodes</label><input id=\"MOMshortcodes\" name=\"MOMshortcodes\" class=\"hidden\" type=\"submit\"></section>"; 
												}
											}		
											echo "</form>";
											echo "<div class=\"clear new\"></div>";
											echo "<section><label class=\"labeltitle\"><i class=\"fa fa-level-down\"></i><span>FullMods</span></label></section>";										
											
												// Count++ form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momCount\">
													<label for=\"mom_count_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_obwcountplus' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_obwcountplus' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_obwcountplus' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_obwcountplus' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Count++
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_obwcountplus' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_obwcountplus' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"countplus\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_count_mode_submit\" name=\"mom_count_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";
											
											
												// Exclude form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momExclude\">
													<label for=\"mom_exclude_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_momse' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_momse' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_momse' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_momse' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Exclude
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_momse' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_momse' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"exclude\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_exclude_mode_submit\" name=\"mom_exclude_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";
											
												// Jump Around form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momJumpAround\">
													<label for=\"mom_jumparound_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_momja' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_momja' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_momja' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_momja' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Jump Around
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_momja' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_momja' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"jumparound\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_jumparound_mode_submit\" name=\"mom_jumparound_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";
											
												// Passwords form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momPasswords\">
													<label for=\"mom_passwords_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_momrups' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_momrups' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_momrups' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_momrups' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Passwords
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_momrups' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_momrups' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"passwords\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_passwords_mode_submit\" name=\"mom_passwords_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";
											
												// Reviews form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momReviews\">
													<label for=\"mom_reviews_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_reviews' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_reviews' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_reviews' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_reviews' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Reviews
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_reviews' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_reviews' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"reviews\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_reviews_mode_submit\" name=\"mom_reviews_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";
											
												// Shortcodes! form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momShortcodes\">
													<label for=\"mom_shortcodes_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_shorts' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_shorts' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_shorts' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_shorts' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Shortcodes
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_shorts' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_shorts' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"shortcodes\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_shortcodes_mode_submit\" name=\"mom_shortcodes_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";											
											
											echo "<div class=\"clear new\"></div>";
											echo "<section><label class=\"labeltitle\"><i class=\"fa fa-level-down\"></i><span>SimpleMods</span></label></section>";
											
												// Analytics form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momAnalytics\">
													<label for=\"mom_analytics_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_analytics' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_analytics' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_analytics' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_analytics' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Analytics
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_analytics' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_analytics' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"analytics\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_analytics_mode_submit\" name=\"mom_analytics_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>";
													if( get_option( 'mommaincontrol_analytics' ) == 1 ) {
														echo "
														<form class=\"setting\" method=\"post\" action=\"\">
														<input onClick=\"this.select();\" type=\"text\" value=\"" . get_option( 'momanalytics_code' ) . "\" name=\"momanalytics_code\" class=\"setting\" placeholder=\"UA-XXXXXXXX-X\" />
														<input type=\"submit\" id=\"mom_analytics_code_submit\" name=\"mom_analytics_code_submit\" value=\"Submit\" class=\"hide\">
														</form>
														";
													}
												echo "
												</section>";
											
												// Maintenance mode form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"momMaintenance\">
													<label for=\"mom_maintenance_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_maintenance' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_maintenance' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_maintenance' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_maintenance' ) == 0 ) { echo "fa fa-square-o"; }												
														echo "
														\"></i>Maintenance
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_maintenance' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_maintenance' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"maintenanceMode\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_maintenance_mode_submit\" name=\"mom_maintenance_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>";
													if( get_option( 'mommaincontrol_maintenance' ) == 1 ) {
														echo "
														<form class=\"setting\" method=\"post\" action=\"\">
														<input onClick=\"this.select();\" type=\"text\" value=\"" . get_option( 'momMaintenance_url' ) . "\" name=\"momMaintenance_url\" class=\"setting\" />
														<input type=\"submit\" id=\"mom_maintenance_url_submit\" name=\"mom_maintenance_url_submit\" value=\"Submit\" class=\"hide\">
														</form>
														";
													}
												echo "
												</section>";
											
												// Post as front form section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"mompaf\">
													<label for=\"mom_postasfront_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_mompaf' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_mompaf' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_mompaf' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_mompaf' ) == 0 ) { echo "fa fa-square-o"; }	
														echo "
														\"></i>Post as Front
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_mompaf' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_mompaf' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"postasfront\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_postasfront_mode_submit\" name=\"mom_postasfront_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>";
													if( get_option( 'mommaincontrol_mompaf' ) == 1 ) {
														echo "
														<form class=\"setting\" method=\"post\" action=\"\">
																<div class=\"overflow\">
																<input name=\"mompaf_post\" id=\"mompaf_0\" type=\"radio\" value=\"0\" "; if ( get_option( 'mompaf_post' ) == 0 ) { echo "checked"; } echo "/><label class=\"selectlabel\" for=\"mompaf_0\">Latest post</label>";
																	$showmeposts = get_posts( array( 'posts_per_page' => -1 ) ); 
																	foreach ( $showmeposts as $postsshown ) {
																		echo "<input name=\"mompaf_post\" type=\"radio\" id=\"mompaf_" . $postsshown->ID . "\" value=\"" . $postsshown->ID . "\""; if ( get_option( 'mompaf_post' ) == $postsshown->ID ) { echo " checked"; } echo "><label class=\"selectlabel\" for=\"mompaf_" . $postsshown->ID . "\">$postsshown->post_title</label>";
																	}
																	echo "
																	</div>
														<label for=\"mom_postasfront_post_submit\" class=\"select\"><i class=\"fa fa-save\"></i>Save</label>
														<input type=\"submit\" id=\"mom_postasfront_post_submit\" name=\"mom_postasfront_post_submit\" value=\"Submit\" class=\"hidden\">
														</form>
														";
													}
												echo "
												</section>";	
											
											echo "<div class=\"clear new\"></div>";
											echo "<section><label class=\"labeltitle\"><i class=\"fa fa-level-down\"></i><span>AutoMods</span></label></section>";
											
												// Font Awesome section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"fontawesome\">
													<label for=\"mom_fontawesome_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_fontawesome' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_fontawesome' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_fontawesome' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_fontawesome' ) == 0 ) { echo "fa fa-square-o"; }	
														echo "
														\"></i>Font Awesome
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_fontawesome' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_fontawesome' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"mommaincontrol_fontawesome\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_fontawesome_mode_submit\" name=\"mom_fontawesome_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";	
											
												// Hide WP versions section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"hidewpversions\">
													<label for=\"mom_versions_submit\" class=\"";
														if( get_option( 'mommaincontrol_versionnumbers' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_versionnumbers' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_versionnumbers' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_versionnumbers' ) == 0 ) { echo "fa fa-square-o"; }	
														echo "
														\"></i>Hide WP Version
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_versionnumbers' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_versionnumbers' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"mommaincontrol_versionnumbers\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_versions_submit\" name=\"mom_versions_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";	
											
												// Lazy Load section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"lazyload\">
													<label for=\"mom_lazy_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_lazyload' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_lazyload' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_lazyload' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_lazyload' ) == 0 ) { echo "fa fa-square-o"; }	
														echo "
														\"></i>Lazy Load
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_lazyload' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_lazyload' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"mommaincontrol_lazyload\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_lazy_mode_submit\" name=\"mom_lazy_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";	
											
												// Meta section
												echo "
												<section>";
													echo "
													<form method=\"post\" action=\"\" name=\"meta\">
													<label for=\"mom_meta_mode_submit\" class=\"";
														if( get_option( 'mommaincontrol_meta' ) == 1 ) { echo "on"; }
														if( get_option( 'mommaincontrol_meta' ) == 0 ) { echo "off"; }
													echo
													"\">
														<i class=\"";
														if( get_option( 'mommaincontrol_meta' ) == 1 ) { echo "fa fa-check-square-o"; }
														if( get_option( 'mommaincontrol_meta' ) == 0 ) { echo "fa fa-square-o"; }	
														echo "
														\"></i>Meta
													</label>
													<input type=\"text\" value=\"";
														if( get_option( 'mommaincontrol_meta' ) == 1 ) { echo "0"; }
														if( get_option( 'mommaincontrol_meta' ) == 0 ) { echo "1"; }
													echo "
													\" name=\"mommaincontrol_meta\" class=\"hide\" />
													<input type=\"submit\" id=\"mom_meta_mode_submit\" name=\"mom_meta_mode_submit\" class=\"hide\" value=\"Submit\" />
													</form>
												</section>";
										echo "
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<div class=\"clear\"></div>";
				echo "<code><em>My Optional Modules</em> <sup>" . round(number_format((memory_get_usage()/1024))) . "kb memory in use. <sup>Tireless nights.<sup>Restless days.<sup>Caffeine, nicotine.<sup>Tomorrow awaits.</sup></sup></sup></sup></sup></code>";
        }
    } 
    
 ?>