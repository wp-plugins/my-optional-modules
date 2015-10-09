<?php
/**
 * ADMIN Settings Page Content
 *
 * File last update: 10.4
 *
 * Content of the /wp-admin/ SETTINGS PAGE for this plugin
 * INCLUDING all SAVE OPERATIONS.
 */

defined('MyOptionalModules') or exit;

if( current_user_can ( 'edit_dashboard' ) && is_admin() ){
	add_action ( 'admin_menu' , 'my_optional_modules_add_options_page' );

	function my_optional_modules_add_options_page() {
		add_options_page ( 'My Optional Modules' , 'My Optional Modules' , 'manage_options' , 'mommaincontrol' ,'my_optional_modules_page_content' );
	}

	function my_optional_modules_page_content() {
		echo '
		<div class="MOMSettings">';

			class myoptionalmodules_settings_form {

				function __construct() {
					global $table_prefix;
					global $wpdb;

					// Trash Removal
					if (
						isset ( $_POST['optimizeTables'] ) ||
						isset ( $_POST['delete_drafts'] ) ||
						isset ( $_POST['delete_unused_terms'] ) ||
						isset ( $_POST['delete_post_revisions'] ) ||
						isset ( $_POST['delete_unapproved_comments'] ) ||
						isset ( $_POST['deleteAllClutter'] )
					) {

						if ( isset( $_POST['delete_post_revisions'] ) && check_admin_referer( 'deletePostRevisionsForm' ) ) {
							$wpdb->query ( 
								$wpdb->prepare ( 
									"
									DELETE FROM $wpdb->posts 
									WHERE post_type = %s 
									OR post_status = %s 
									OR post_status = %s
									OR post_status = %s
									" ,
									'revision' ,
									'post_status' ,
									'auto-draft' ,
									'trash'
								)
							);
						}

						if ( isset ( $_POST['delete_unapproved_comments'] ) && check_admin_referer( 'deleteUnapprovedCommentsForm' ) ) {
							$wpdb->query ( 
								$wpdb->prepare (
									"
									DELETE FROM $wpdb->comments 
									WHERE comment_approved = %d 
									OR comment_approved = %s 
									OR comment_approved = %s 
									" ,
									0 ,
									'post-trashed' ,
									'spam'
								)
							);
						}

						if ( isset( $_POST['delete_unused_terms'] ) && check_admin_referer( 'deleteUnusedTermsForm' ) ) {
							$wpdb->query (
								$wpdb->prepare ( 
									"
									DELETE FROM $wpdb->terms 
									WHERE term_id IN ( 
										SELECT term_id FROM $wpdb->term_taxonomy WHERE count = %d
									)
									" ,
									0
								)
							);
							$wpdb->query ( 
								$wpdb->prepare (
									"
									DELETE FROM $wpdb->term_taxonomy 
									WHERE count = %d
									" ,
									0
								)
							);
						}

						if ( isset( $_POST['delete_drafts'] ) && check_admin_referer( 'deleteDraftsForm' ) ) {
							$wpdb->query ( 
								$wpdb->prepare (
									"
									DELETE FROM $wpdb->posts 
									WHERE post_status = %s 
									",
									'draft'
								)
							);
						}

						if ( isset( $_POST['deleteAllClutter'] ) && check_admin_referer( 'deleteAllClutterForm' ) ) {
							$wpdb->query ( 
								$wpdb->prepare ( 
									"
									DELETE FROM $wpdb->posts 
									WHERE post_type = %s 
									OR post_status = %s 
									OR post_status = %s
									OR post_status = %s
									" ,
									'revision' ,
									'post_status' ,
									'auto-draft' ,
									'trash'
								)
							);
							$wpdb->query ( 
								$wpdb->prepare (
									"
									DELETE FROM $wpdb->comments 
									WHERE comment_approved = %d 
									OR comment_approved = %s 
									OR comment_approved = %s 
									" ,
									0 ,
									'post-trashed' ,
									'spam'
								)
							);
							$wpdb->query (
								$wpdb->prepare ( 
									"
									DELETE FROM $wpdb->terms 
									WHERE term_id IN ( 
										SELECT term_id FROM $wpdb->term_taxonomy WHERE count = %d
									)
									" ,
									0
								)
							);
							$wpdb->query ( 
								$wpdb->prepare (
									"
									DELETE FROM $wpdb->term_taxonomy 
									WHERE count = %d
									" ,
									0
								)
							);
							$wpdb->query ( 
								$wpdb->prepare (
									"
									DELETE FROM $wpdb->posts 
									WHERE post_status = %s 
									",
									'draft'
								)
							);
						}

						if ( isset( $_POST['optimizeTables'] ) && check_admin_referer( 'optimizeTablesForm' ) ) {
							$wpdb->query ( "OPTIMIZE TABLE $wpdb->posts" );
							$wpdb->query ( "OPTIMIZE TABLE $wpdb->comments" );
							$wpdb->query ( "OPTIMIZE TABLE $wpdb->terms" );
							$wpdb->query ( "OPTIMIZE TABLE $wpdb->term_taxonomy" );
						}
					}

					$options_disable = array (
						'myoptionalmodules_plugincss' ,
						'myoptionalmodules_pluginscript' ,
						'myoptionalmodules_pluginshortcodes' ,
						'myoptionalmodules_disablecomments' ,
						'myoptionalmodules_removecode' ,
						'myoptionalmodules_disablepingbacks' ,
						'myoptionalmodules_authorarchives' ,
						'myoptionalmodules_datearchives'
					);
					$keys_disable = array (
						' Disable Plugin CSS <em>Keeps this plugins CSS from enqueueing. You will need to manually style all plugin elements yourself.</em>' ,
						' Disable Plugin Script <em>Keeps this plugins main jquery script from loading. You will lose some functionality.</em>' ,
						' Disable Plugin Shortcodes <em>You may choose to disable the file class.myoptionalmodules-shortcodes.php in its entirety. [mom_embed], [mom_hidden], [mom_charts], [mom_categories], and [mom_reddit] will no longer work.</em>' ,
						' Disable Comment form <em>Removes the comment form from every portion of your site, and replaces it with a blank template.</em>' ,
						' Remove Unnecessary Code <em>Removes the XHTML generator, CSS and JS ids, feed links, Really Simple Discovery link, WLW Manifest link, adjacent posts links, and other such code clutter.</em>' ,
						' Disable Pingbacks <em>Disables pingbacks to your site.</em>' ,
						' Disable Author Archives <em>Disables all author based archives, and will instead redirect users to your homepage when accessing them.</em>' ,
						' Disable Date Archives <em>Disables all date based archives, and will instead redirect users to your homepage when accessing them.</em>'
					);
					$options_enable = array (
						'myoptionalmodules_metatags' ,
						'myoptionalmodules_horizontalgalleries' ,
						'myoptionalmodules_newwindow' ,
						'myoptionalmodules_fontawesome' ,
						'myoptionalmodules_sharelinks' ,
						'myoptionalmodules_rsslinkbacks' ,
						'myoptionalmodules_404s'
					);
					$keys_enable = array (
						' Enable Meta Tags <em>Enable meta tags for your posts.</em>' ,
						' Enable Horizontal Galleries <em>Turn all image galleries into horizontal image galleries.</em>' ,
						' Disable Horizontal Galleries script <em>Open gallery images normally</em>' ,
						' Enable Font Awesome <em>Enable the use of Font Awesome on your site.</em>' ,
						' Enable Social Links <em>Enable scriptless share buttons for your posts/pages.</em>' ,
						' Enable RSS Linkbacks <em>Appends a link back to your site on all RSS items.</em>' ,
						' Enable 404s-to-home <em>Redirects all 404s to your homepage.</em>'
					);

					$options_shares = array (
						'myoptionalmodules_sharelinks_reddit' ,
						'myoptionalmodules_sharelinks_google' ,
						'myoptionalmodules_sharelinks_twitter' ,
						'myoptionalmodules_sharelinks_facebook' ,
						'myoptionalmodules_sharelinks_email' ,
						'myoptionalmodules_shareslinks_top' ,
						'myoptionalmodules_sharelinks_pages'
					);
					$keys_shares = array (
						' reddit' ,
						' google plus' ,
						' twitter' ,
						' facebook' ,
						' email' ,
						' place at top' ,
						' place on pages'
					);
					$options_comment_form = array (
						'myoptionalmodules_dnsbl' ,
						'myoptionalmodules_lookups' ,
						'myoptionalmodules_commentspamfield'
					);
					$keys_comment_form = array (
						' DNSBL <em>Checks a commentors IP against several DNS Blacklists to determine if the commentor is a potential threat or not. Discards the comment if they are listed.</em>' ,
						' DNSBL Databases <em>DNSBL databases to use. Use <a href="//dnsbl.info/dnsbl-list.php">this</a> list for reference. One database per line.</em>' ,
						' Spam trap <em>Enables a simple spam field for commentors who are not logged in that will discard the comment if filled out (potentially by a bot).</em>' ,
					);
					$options_extras = array (
						'myoptionalmodules_javascripttofooter' ,
						'myoptionalmodules_recentpostswidget' ,
						'myoptionalmodules_keeptitle_recentpostswidget' ,
						'myoptionalmodules_exclude' ,
						'myoptionalmodules_analyticspostsonly'
					);
					$keys_extras = array (
						' Javascript-to-Footer <em>Move all JS to the footer.</em>' ,
						' Recent Posts Widget <em>Changes the behavior of the Recent Posts Widget to exclude the currently viewed post from its list.</em>' ,
						' Recent Posts Widget (Keep the title) <em>Instead of excluding the entry from the list, de-link and bold it.</em>' ,
						' Enable Exclude Posts <em>Exclude posts from anywhere on the site, based on many different settings.</em>' ,
						' Analytics On Single Only <em>Only use Google Analytics on single posts. Set your Google Tracking ID below.</em>' ,
					);
					$theme_extras = array (
						'myoptionalmodules_sharelinks_text' ,
						'myoptionalmodules_google' ,
						'myoptionalmodules_custom_embed' ,
						'myoptionalmodules_custom_hidden' ,
						'myoptionalmodules_custom_charts' ,
						'myoptionalmodules_custom_categories' ,
						'myoptionalmodules_custom_redditfeed' ,
						'myoptionalmodules_custom_miniloop' ,
						'myoptionalmodules_verification' ,
						'myoptionalmodules_alexa' ,
						'myoptionalmodules_bing' ,
						'myoptionalmodules_randompost' ,
						'myoptionalmodules_frontpage' ,
						'myoptionalmodules_miniloopmeta' ,
						'myoptionalmodules_disqus' ,
						'myoptionalmodules_miniloopstyle' ,
						'myoptionalmodules_miniloopamount' 
					);
					$options_exclude = array (
						'myoptionalmodules_exclude_usersrss' ,
						'myoptionalmodules_exclude_usersfront' ,
						'myoptionalmodules_exclude_userscategoryarchives' ,
						'myoptionalmodules_exclude_userstagarchives' ,
						'myoptionalmodules_exclude_userssearchresults' ,
						'myoptionalmodules_exclude_usersuserssun' ,
						'myoptionalmodules_exclude_usersusersmon' ,
						'myoptionalmodules_exclude_usersuserstue' ,
						'myoptionalmodules_exclude_usersuserswed' ,
						'myoptionalmodules_exclude_usersusersthu' ,
						'myoptionalmodules_exclude_usersusersfri' ,
						'myoptionalmodules_exclude_usersuserssat' ,
						'myoptionalmodules_exclude_userslevel10users' ,
						'myoptionalmodules_exclude_userslevel1users' ,
						'myoptionalmodules_exclude_userslevel2users' ,
						'myoptionalmodules_exclude_userslevel7users' ,
						'myoptionalmodules_exclude_categoriesrss' ,
						'myoptionalmodules_exclude_categoriesfront' ,
						'myoptionalmodules_exclude_categoriestagarchives' ,
						'myoptionalmodules_exclude_categoriessearchresults' ,
						'myoptionalmodules_exclude_categoriescategoriessun' ,
						'myoptionalmodules_exclude_categoriescategoriesmon' ,
						'myoptionalmodules_exclude_categoriescategoriestue' ,
						'myoptionalmodules_exclude_categoriescategorieswed' ,
						'myoptionalmodules_exclude_categoriescategoriesthu' ,
						'myoptionalmodules_exclude_categoriescategoriesfri' ,
						'myoptionalmodules_exclude_categoriescategoriessat' ,
						'myoptionalmodules_exclude_categories_level0categories' ,
						'myoptionalmodules_exclude_categorieslevel1categories' ,
						'myoptionalmodules_exclude_categorieslevel2categories' ,
						'myoptionalmodules_exclude_categorieslevel7categories' ,
						'myoptionalmodules_exclude_tagsrss' ,
						'myoptionalmodules_exclude_tagsfront' ,
						'myoptionalmodules_exclude_tagscategoryarchives' ,
						'myoptionalmodules_exclude_tagssearchresults' ,
						'myoptionalmodules_exclude_tagstagssun' ,
						'myoptionalmodules_exclude_tagstagsmon' ,
						'myoptionalmodules_exclude_tagstagstue' ,
						'myoptionalmodules_exclude_tagstagswed' ,
						'myoptionalmodules_exclude_tagstagsthu' ,
						'myoptionalmodules_exclude_tagstagsfri' ,
						'myoptionalmodules_exclude_tagstagssat' ,
						'myoptionalmodules_exclude_tagslevel0tags' ,
						'myoptionalmodules_exclude_tagslevel1tags' ,
						'myoptionalmodules_exclude_tagslevel2tags' ,
						'myoptionalmodules_exclude_tagslevel7tags' ,
						'myoptionalmodules_exclude_postformatsrss' ,
						'myoptionalmodules_exclude_postformatsfront' ,
						'myoptionalmodules_exclude_postformatscategoryarchives' ,
						'myoptionalmodules_exclude_postformatstagarchives' ,
						'myoptionalmodules_exclude_postformatssearchresults' ,
						'myoptionalmodules_exclude_visitorpostformats'
					);
					$all_options = array_merge ( $options_disable , $options_enable , $options_shares , $options_comment_form , $options_extras );
					$all_fields  = array_merge ( $theme_extras , $options_exclude );

					if ( isset ( $_POST['myoptionalmodules_settings_form'] ) && check_admin_referer ( 'myoptionalmodules_settings_form' ) ) {
						foreach ( $all_options as &$option ) {

							if ( isset ( $_POST[ $option ] ) ) {
								if ( 'myoptionalmodules_lookups' == $option ) {
									$value = str_replace (
										array ( 'https://' , 'http://' , ',' ) ,
										'' ,
										$_POST[ $option ]
									);
									$value = $_POST[ $option ];
									$value = implode ( "\n" , array_map ( 'sanitize_text_field' , explode ( "\n" , $value ) ) );
								} else {
									$value = intval ( $_POST[ $option ] );
								}
								update_option( $option , $value );
							} else {
								delete_option ( $option );
							}
						}
						$value = null;
						foreach ( $all_fields as &$field ) {

							if ( isset ( $_REQUEST[ $field ] ) ) {

								if ( $field == 'myoptionalmodules_previouslinkclass' )
									$_REQUEST['myoptionalmodules_previouslinkclass'] = str_replace( '.' , '' , $_REQUEST['myoptionalmodules_previouslinkclass'] );
								
								if ( $field == 'myoptionalmodules_verification' )
									$_REQUEST['myoptionalmodules_verification'] = str_replace ( array ( '<meta name=\"google-site-verification\" content=\"' , '\" />' ) , '' , $_REQUEST['myoptionalmodules_verification' ] );
								
								if ( $field == 'myoptionalmodules_nextlinkclass' )
									$_REQUEST['myoptionalmodules_nextlinkclass']     = str_replace( '.' , '' , $_REQUEST['myoptionalmodules_nextlinkclass'] );
								$value = sanitize_text_field ( $_REQUEST[ $field ] );
								update_option ( $field , $value );
							}
						}
						$value = null;
					}

					if ( isset ( $_POST['myoptionalmodules_settings_reset_confirm'] ) && check_admin_referer ( 'myoptionalmodules_settings_form' ) ) {
						foreach ( $all_options as &$option ) {
								delete_option ( $option );
						}
						foreach ( $all_fields as &$field ) {
								delete_option ( $field );
						}
					}

					if ( isset ( $_POST['myoptionalmodules_settings_uninstall_confirm'] ) && check_admin_referer ( 'myoptionalmodules_settings_form' ) ) {
						foreach ( $all_options as &$option ) {
								delete_option ( $option );
						}
						foreach ( $all_fields as &$field ) {
								delete_option ( $field );
						}
						delete_option ( 'myoptionalmodules_upgrade_version' );
						delete_option ( 'myoptionalmodules_ajaxcomments' );
						delete_option ( 'myoptionalmodules_previouslinkclass' );
						delete_option ( 'myoptionalmodules_nextlinkclass' );
						delete_option ( 'myoptionalmodules_randomdescriptions' );
						delete_option ( 'myoptionalmodules_randomtitles' );
						delete_option ( 'myoptionalmodules_featureimagewidth_submit' );
						delete_option ( 'myoptionalmodules_readmore' );
						delete_option ( 'myoptionalmodules_favicon' );
						delete_option ( 'myoptionalmodules_nelio' );
						delete_option ( 'myoptionalmodules_lazyload' );
					}
					echo '
					
					<div id="myoptionalmodules">
						<div class="clear">
						<div class="setting">
							<em>tools</em>
							<form class="clutter" method="post" action="" name="optimizeTables">';
								wp_nonce_field ( 'optimizeTablesForm' );
								echo '
								<label for="optimizeTables"><i class="fa fa-rocket"></i>Optimize Tables <em>Optimize your sites SQL tables.</em></label>
								<input class="hidden" id="optimizeTables" type="submit" value="Go" name="optimizeTables">
							</form>
							<form class="clutter" method="post" action="" name="deleteAllClutter">';
								wp_nonce_field ( 'deleteAllClutterForm' );
								echo '
								<label for="deleteAllClutter"><i class="fa fa-trash-o"></i>Empty Trash <em>Perform all of the below trash removal actions, instantly.</em></label>
								<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
							</form>
							<form class="clutter" method="post" action="" name="deletePostRevisionsForm">';
								wp_nonce_field ( 'deletePostRevisionsForm' );
								echo '
								<label for="delete_post_revisions"><i class="fa fa-trash-o"></i>Delete Revisions/Autodrafts <em>Delete revisions, auto-drafts, and empties the trash.</em></label>
								<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
							</form>
							<form class="clutter" method="post" action="" name="deleteUnapprovedCommentsForm">';
								wp_nonce_field ( 'deleteUnapprovedCommentsForm' );
								echo '
								<label for="delete_unapproved_comments"><i class="fa fa-trash-o"></i>Clean Up Comments <em>Deletes unapproved comments, comments belonged to trashed posts, or comments labeled as spam.</em></label>
								<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
							</form>
							<form class="clutter" method="post" action="" name="deleteUnusedTermsForm">';
								wp_nonce_field ( 'deleteUnusedTermsForm' );
								echo '
								<label for="delete_unused_terms"><i class="fa fa-trash-o"></i>Clean Up Tags/Categories <em>Removes tags and categories that have no posts associated with them.</em></label>
								<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
							</form>
							<form class="clutter" method="post" action="" name="deleteDraftsForm">';
								wp_nonce_field ( 'deleteDraftsForm' );
								echo '
								<label for="delete_drafts"><i class="fa fa-trash-o"></i>Delete Drafts <em>Delete all drafts.</em></label>
								<input class="hidden" id="delete_drafts" type="submit" value="Go" name="delete_drafts">
							</form>
						</div>

						<form method="post" name="myoptionalmodules_settings_form" action="" class="MOM_form">';
						wp_nonce_field ( 'myoptionalmodules_settings_form' );
						echo '
							<div class="setting">
								<em>disable</em>';
								foreach ( $options_disable as &$option ) {
									$title   = str_replace( $options_disable , $keys_disable , $option );
									$checked = null;
									if ( get_option ( $option ) )
										$checked = ' checked';
									echo "
									<section>
										<input type='checkbox' value='1' name='{$option}' id='{$option}'{$checked}> <label for='{$option}'>{$title}</label>
									</section>";
								}								
							echo '</div>
							</div>
							<div class="clear">';
							
							if( !get_option ( 'myoptionalmodules_disablecomments' ) ) {
								echo '<div class="setting">
									<em>comments</em>';
										foreach ( $options_comment_form as &$option ) {
											
											if ( 'myoptionalmodules_lookups' == $option ) {
												$title = str_replace ( $options_comment_form , $keys_comment_form , $option );
												$value = get_option ( $option );
												echo "
												<section>
													<label for='{$option}'>{$title}</label>
													<textarea class='full-text' name='{$option}' id='{$option}'>{$value}</textarea>
													<small>Defaults (leave blank): <br />dnsbl-1.uceprotect.net<br /> dnsbl-2.uceprotect.net<br /> dnsbl-3.uceprotect.net<br /> dnsbl.sorbs.net<br /> zen.spamhaus.org</small>
												</section><hr />";								
											} else {
												$title = str_replace ( $options_comment_form , $keys_comment_form , $option );
												$checked = null;
												if ( get_option ( $option ) )
													$checked = ' checked';
												echo "
												<section>
													<input type='checkbox' value='1' name='{$option}' id='{$option}'{$checked}> <label for='{$option}'>{$title}</label>
												</section>";
											}
										}
								echo '</div>';
							} else {
								echo '<div class="setting"><em>The comment form is disabled</em><section>Comment-related modules are currently inaccessible.</section></div>';
							}
							
							echo '<div class="setting">
								<em>enable</em>';
								foreach ( $options_enable as &$option ) {
									$title = str_replace( $options_enable , $keys_enable , $option );
									$checked = null;

									if ( get_option ( $option ) )
										$checked = ' checked';
									echo "
									<section>
										<input type='checkbox' value='1' name='{$option}' id='{$option}'{$checked}> <label for='{$option}'>{$title}</label>
									</section>";
								}
								if ( get_option ( 'myoptionalmodules_sharelinks' ) ) {
										$myoptionalmodules_sharelinks_text = sanitize_text_field ( get_option ( 'myoptionalmodules_sharelinks_text' ) );
										echo "
										<hr /><label>Share text &mdash; <small>ex: share via:</small></label>
										<input type='text' value='{$myoptionalmodules_sharelinks_text}' id='myoptionalmodules_sharelinks_text' name='myoptionalmodules_sharelinks_text' />";
										foreach ( $options_shares as &$option ) {
											$title = str_replace ( $options_shares , $keys_shares , $option );
											$checked = null;
											if ( get_option ( $option ) )
												$checked = ' checked';
											echo "
											<section>
												<input type='checkbox' value='1' name='{$option}' id='{$option}'{$checked}> <label for='{$option}'>{$title}</label>
											</section>";
										}
								}
							echo '</div>
							</div>
							<div class="clear">
							<div class="setting">
								<em>extras</em>';
								foreach ( $options_extras as &$option ) {
									$title = str_replace ( $options_extras , $keys_extras , $option );
									$checked = null;

									if ( get_option( $option ) )
										$checked = ' checked';
										echo "
										<section>
											<input type='checkbox' value='1' name='{$option}' id='{$option}'{$checked}> <label for='{$option}'>{$title}</label>
										</section>";
								}
							echo'</div>
							<div class="setting">
								<em>theme</em>
								<section>
								<label for="mompaf_0">Set homepage as a post <em>Like setting the homepage as a page, this 
								setting allows you to set your homepage as a post.</em></label>
								<select class="full-text" name="myoptionalmodules_frontpage" id="mompaf_0">
									<option value="off"';
									if ( get_option ( 'myoptionalmodules_frontpage' ) == 'off' )
										echo 'selected="selected"';
									echo '>Front page is default</option>
									<option value="on"';
									if ( get_option ( 'myoptionalmodules_frontpage' ) == 'on' )
										echo 'selected="selected"';
									echo '/>Front Page will be your latest post</option>';
									$myoptionalmodules_frontpage = get_option ( 'myoptionalmodules_frontpage' );
									selected ( get_option ( 'myoptionalmodules_frontpage' ) , 0 );
									$showmeposts = get_posts ( array ( 'posts_per_page' => -1 ) );
									foreach ( $showmeposts as $postsshown ) {
										echo "
										<option name='myoptionalmodules_frontpage' id='mompaf_{$postsshown->ID}' value='{$postsshown->ID}'";
										$postID       = $postsshown->ID;
										$selected     = selected ( $myoptionalmodules_frontpage , $postID );
										$post_title   = substr( $postsshown->post_title , 0 , 48 );
										$title_length = strlen( $post_title );
										if( $title_length > 47 ) {
											$post_title = "{$post_title}...";
										}
										echo "
										>Front page: '{$post_title}'</option>";
									}
								echo '
								</select></section>';
								$google               = $verification     = $alexa            =
								$bing                 = $randompost       = $miniloop_meta    =
								$miniloop_style       = $miniloop_amount  = $disqus           =
								$shortcode_embed      = $shortcode_hidden = $shortcode_charts =
								$shortcode_categories = null;
								
								$google               = sanitize_text_field ( get_option ( 'myoptionalmodules_google' ) );
								$verification         = sanitize_text_field ( get_option ( 'myoptionalmodules_verification' ) );
								$alexa                = sanitize_text_field ( get_option ( 'myoptionalmodules_alexa' ) );
								$bing                 = sanitize_text_field ( get_option ( 'myoptionalmodules_bing' ) );
								$randompost           = sanitize_text_field ( get_option ( 'myoptionalmodules_randompost' ) );
								$miniloop_meta        = sanitize_text_field ( get_option ( 'myoptionalmodules_miniloopmeta' ) );
								$miniloop_style       = sanitize_text_field ( get_option ( 'myoptionalmodules_miniloopstyle' ) );
								$miniloop_amount      = sanitize_text_field ( get_option ( 'myoptionalmodules_miniloopamount' ) );										
								$disqus               = sanitize_text_field ( get_option ( 'myoptionalmodules_disqus' ) );
								$shortcode_embed      = sanitize_text_field ( get_option ( 'myoptionalmodules_custom_embed' ) );
								$shortcode_hidden     = sanitize_text_field ( get_option ( 'myoptionalmodules_custom_hidden' ) );
								$shortcode_charts     = sanitize_text_field ( get_option ( 'myoptionalmodules_custom_charts' ) );
								$shortcode_categories = sanitize_text_field ( get_option ( 'myoptionalmodules_custom_categories' ) );
								$shortcode_redditfeed = sanitize_text_field ( get_option ( 'myoptionalmodules_custom_redditfeed' ) );
								$shortcode_miniloop   = sanitize_text_field ( get_option ( 'myoptionalmodules_custom_miniloop' ) );
								
								if( !get_option('myoptionalmodules_pluginshortcodes') ) {
									echo "
									<section><hr /><strong>Shortcode Customization</strong></section>
									<section>
										<label for='myoptionalmodules_custom_embed'>Embed shortcode parameter <small>&mdash; default: mom_embed</small>
										<input class='full-text' type='text' id='myoptionalmodules_custom_embed' name='myoptionalmodules_custom_embed' value='{$shortcode_embed}' />
									</section>
									<section>
										<label for='myoptionalmodules_custom_hidden'>Hidden shortcode parameter <small>&mdash; default: mom_hidden</small>
										<input class='full-text' type='text' id='myoptionalmodules_custom_hidden' name='myoptionalmodules_custom_hidden' value='{$shortcode_hidden}' />
									</section>
									<section>
										<label for='myoptionalmodules_custom_charts'>Charts shortcode parameter <small>&mdash; default: mom_charts</small>
										<input class='full-text' type='text' id='myoptionalmodules_custom_charts' name='myoptionalmodules_custom_charts' value='{$shortcode_charts}' />
									</section>
									<section>
										<label for='myoptionalmodules_custom_categories'>Categories shortcode parameter <small>&mdash; default: mom_categories</small>
										<input class='full-text' type='text' id='myoptionalmodules_custom_categories' name='myoptionalmodules_custom_categories' value='{$shortcode_categories}' />
									</section>
									<section>
										<label for='myoptionalmodules_custom_redditfeed'>reddit feed shortcode parameter <small>&mdash; default: mom_reddit</small>
										<input class='full-text' type='text' id='myoptionalmodules_custom_redditfeed' name='myoptionalmodules_custom_redditfeed' value='{$shortcode_redditfeed}' />
									</section>
									<section>
										<label for='myoptionalmodules_custom_miniloop'>Miniloop shortcode parameter <small>&mdash; default: mom_miniloop</small>
										<input class='full-text' type='text' id='myoptionalmodules_custom_miniloop' name='myoptionalmodules_custom_miniloop' value='{$shortcode_miniloop}' />
									</section>
									<section><hr /></section>";
								} else {
									echo '<section><hr><strong>Shortcodes are disabled. <small>Shortcode-related settings are inaccessible.</small></strong><hr /></section>';
								}								
								echo "								
								<section>
									<label for='myoptionalmodules_disqus'>Disqus Shortname <small>&mdash; <strong>this</strong>.disqus.com</small> <em>Enables Disqus comments for your posts.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_disqus' name='myoptionalmodules_disqus' value='{$disqus}' />
								</section>
								<section>
									<label for='myoptionalmodules_miniloopmeta'>Miniloop: meta <em>This is the name of a custom field that will tie posts together. If Post A and Post C share the value 'video game' while Post B has the value 'movie',
									Post A and Post C will be considered similar to each other, regardless of category.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_miniloopmeta' name='myoptionalmodules_miniloopmeta' value='$miniloop_meta' />
								</section>
								<section>";
									echo '
									<label for="myoptionalmodules_miniloopstyle">Miniloop: style <em>Choose a display style for your miniloop. Your miniloop
									will always be displayed following your post content.</em></label>
									<select class="full-text" name="myoptionalmodules_miniloopstyle" id="myoptionalmodules_miniloopstyle">
										<option value="">Miniloop style: not set</option>
										<option value="columns"'; selected ( $miniloop_style , 'columns' ); echo '>Miniloop style: Columns</option>
										<option value="list"';    selected ( $miniloop_style , 'list'    ); echo '>Miniloop style: List</option>
										<option value="slider"';  selected ( $miniloop_style , 'slider'  ); echo '>Miniloop style: Slider</option>
										<option value="tiled"';   selected ( $miniloop_style , 'tiled'   ); echo '>Miniloop style: Tiled</option>
										<option value="blurbs"';  selected ( $miniloop_style , 'blurbs'  ); echo '>Miniloop style: Blurbs</option>
									</select>';
								echo "
								</section>
								<section>
									<label for='myoptionalmodules_miniloopamount'>Miniloop: amount <em>How many posts to display. Can be as many or as few as you desire.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_miniloopamount' name='myoptionalmodules_miniloopamount' value='{$miniloop_amount}' />
								</section>
								<section>
									<label>Google Tracking ID <em>Your Google Analytics Tracking ID.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_google' name='myoptionalmodules_google' value='{$google}' />
								</section>
								<section>
									<label>Google Verification Content <em><a href='https://sites.google.com/site/webmasterhelpforum/en/verification-specifics'>Google Webmaster Tools verification details</a>.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_verification' name='myoptionalmodules_verification' value='{$verification}' />
								</section>
								<section>
									<label>Alexa Verify ID <em><a href='http://www.alexa.com/siteowners/claim'>Claim Your Site on Alexa</a> and enter the verification ID here.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_alexa' name='myoptionalmodules_alexa' value='{$alexa}' />
								</section>
								<section>
									<label>Bing Validated ID <em><a href='http://www.bing.com/webmaster/help/how-to-verify-ownership-of-your-site-afcfefc6'>Verify Ownership of Your Website (with Bing)</a>. Your Bing Validated ID is the content of msvalidate.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_bing' name='myoptionalmodules_bing' value='{$bing}' />
								</section>
								<section>
									<label for='myoptionalmodules_randompost'>yoursite.tld/<code>?random</code> keyword <em>Creates a redirect for a random post. Loading up yoursite.tld/?KEYWORD will load a random post.</em></label>
									<input class='full-text' type='text' id='myoptionalmodules_randompost' name='myoptionalmodules_randompost' value='{$randompost}' />
								</section>";
							echo '</div>
							</div>
							<div class="clear">
							<div id="exclude-components-content">';
								if ( get_option ( 'myoptionalmodules_exclude' ) ) {
									$showmepages = get_pages();
									$showmecats  = get_categories ( 'taxonomy=category&hide_empty=0' );
									$showmetags  = get_categories ( 'taxonomy=post_tag&hide_empty=0' );
									$showmeusers = get_users();
									$tagcount    = 0;
									$catcount    = 0;
									$usercount   = 0;
									echo '
									<div class="setting full">
										<strong>Exclude Posts</strong>
										<p>Each field takes a comma-separated list of items for exclusion from the specified
										section of the blog. When filling out each field, <code>this is the value you will use</code>. Names are there for reference.</p>
										<p>Exclusions based on user roles (guest, subscriber, contributor, author) will prevent those user roles
										from being able to view the post as a single page (is_single()). The error message will be wrapped in the div <code>.mom-unauthorized-content</code> 
										for CSS-styling purposes.</p>';
										$myoptionalmodules_exclude_postformatsrss              = get_option ( 'myoptionalmodules_exclude_postformatsrss' );
										$myoptionalmodules_exclude_postformatsfront            = get_option ( 'myoptionalmodules_exclude_postformatsfront' );
										$myoptionalmodules_exclude_postformatscategoryarchives = get_option ( 'myoptionalmodules_exclude_postformatscategoryarchives' );
										$myoptionalmodules_exclude_postformatstagarchives      = get_option ( 'myoptionalmodules_exclude_postformatstagarchives' );
										$myoptionalmodules_exclude_postformatssearchresults    = get_option ( 'myoptionalmodules_exclude_postformatssearchresults' );
										$myoptionalmodules_exclude_visitorpostformats          = get_option ( 'myoptionalmodules_exclude_visitorpostformats' );
										echo '
										<section>
											<p>Exclude these <code>Authors</code> from</p>
											<p>';
												foreach ( $showmeusers as $usersshown ) {
													echo $usersshown->user_nicename;
													echo "<code>$usersshown->ID</code> &nbsp;&nbsp;";
												}
											echo '
											</p>';
											$exclude = array (
												'myoptionalmodules_exclude_usersrss' ,
												'myoptionalmodules_exclude_usersfront' ,
												'myoptionalmodules_exclude_userscategoryarchives' ,
												'myoptionalmodules_exclude_userstagarchives' ,
												'myoptionalmodules_exclude_userssearchresults' ,
												'myoptionalmodules_exclude_usersuserssun' ,
												'myoptionalmodules_exclude_usersusersmon' ,
												'myoptionalmodules_exclude_usersuserstue' ,
												'myoptionalmodules_exclude_usersuserswed' ,
												'myoptionalmodules_exclude_usersusersthu' ,
												'myoptionalmodules_exclude_usersusersfri' ,
												'myoptionalmodules_exclude_usersuserssat' ,
												'myoptionalmodules_exclude_userslevel10users' ,
												'myoptionalmodules_exclude_userslevel1users' ,
												'myoptionalmodules_exclude_userslevel2users' ,
												'myoptionalmodules_exclude_userslevel7users' ,
											);
											$section = array (
												'feed' ,
												'home' ,
												'category archives' ,
												'tag archives' ,
												'search results' ,
												'Sunday' ,
												'Monday' ,
												'Tuesday' ,
												'Wednesday' ,
												'Thursday' ,
												'Friday' ,
												'Saturday' ,
												'not logged in' ,
												'subscribers' ,
												'contributors' ,
												'authors'
											);
											foreach ( $exclude as $exc ) {
												$title  = str_replace ( $exclude , $section, $exc );
												$option = sanitize_text_field ( get_option ( $exc ) );
												echo "
												<section>
													<label for='{$exc}'>{$title}</label>
													<input type='text' id='{$exc}' name='{$exc}' value='{$option}'>
												</section>";
											}
											$title = $option = null;
										echo '
										</section>';
										$exclude = array (
											'myoptionalmodules_exclude_categoriesrss' ,
											'myoptionalmodules_exclude_categoriesfront' ,
											'myoptionalmodules_exclude_categoriestagarchives' ,
											'myoptionalmodules_exclude_categoriessearchresults' ,
											'myoptionalmodules_exclude_categoriescategoriessun' ,
											'myoptionalmodules_exclude_categoriescategoriesmon' ,
											'myoptionalmodules_exclude_categoriescategoriestue' ,
											'myoptionalmodules_exclude_categoriescategorieswed' ,
											'myoptionalmodules_exclude_categoriescategoriesthu' ,
											'myoptionalmodules_exclude_categoriescategoriesfri' ,
											'myoptionalmodules_exclude_categoriescategoriessat' ,
											'myoptionalmodules_exclude_categories_level0categories' ,
											'myoptionalmodules_exclude_categorieslevel1categories' ,
											'myoptionalmodules_exclude_categorieslevel2categories' ,
											'myoptionalmodules_exclude_categorieslevel7categories' ,
										);
										$section = array (
											'feed' ,
											'home' ,
											'tag archives' ,
											'search results' ,
											'Sunday' ,
											'Monday' ,
											'Tuesday' ,
											'Wednesday' ,
											'Thursday' ,
											'Friday' ,
											'Saturday' ,
											'not logged in' ,
											'subscribers' ,
											'contributors' ,
											'authors'
										);
										echo '
										<section>
											<p>Exclude these <code>categories</code> from...</p>
										<p>';
											foreach ( $showmecats as $catsshown ) {
												++$catcount;
												echo $catsshown->cat_name;
												echo "<code>{$catsshown->cat_ID}</code> &nbsp;&nbsp;";
											}
										echo '
										</p>';

										if ( $catcount > 0 ) {
											foreach ( $exclude as $exc ) {
												$title  = str_replace ( $exclude , $section , $exc );
												$option = sanitize_text_field ( get_option ( $exc ) );
												echo "
												<section>
													<label for='{$exc}'>{$title}</label>
													<input type='text' id='{$exc}' name='{$exc}' value='{$option}'>
												</section>";
											}
											$title = $option = null;
										}
									echo '
									</section>';
									foreach ( $showmetags as $tagsshown ) {
										++$tagcount;
									}

									if ( $tagcount ) {
										$exclude = array (
											'myoptionalmodules_exclude_tagsrss' ,
											'myoptionalmodules_exclude_tagsfront' ,
											'myoptionalmodules_exclude_tagscategoryarchives' ,
											'myoptionalmodules_exclude_tagssearchresults' ,
											'myoptionalmodules_exclude_tagstagssun' ,
											'myoptionalmodules_exclude_tagstagsmon' ,
											'myoptionalmodules_exclude_tagstagstue' ,
											'myoptionalmodules_exclude_tagstagswed' ,
											'myoptionalmodules_exclude_tagstagsthu' ,
											'myoptionalmodules_exclude_tagstagsfri' ,
											'myoptionalmodules_exclude_tagstagssat' ,
											'myoptionalmodules_exclude_tagslevel0tags' ,
											'myoptionalmodules_exclude_tagslevel1tags' ,
											'myoptionalmodules_exclude_tagslevel2tags' ,
											'myoptionalmodules_exclude_tagslevel7tags'
										);
										$section = array (
											'feed' ,
											'home' ,
											'category archives' ,
											'search' ,
											'Sunday' ,
											'Monday' ,
											'Tuesday' ,
											'Wednesday' ,
											'Thursday' ,
											'Friday' ,
											'Saturday' ,
											'not logged in' ,
											'subscribers' ,
											'contributors' ,
											'authors'
										);
										echo '
										<section>
											<p>Exclude these <code>tags</code> from...</p>
											<p>';
												foreach ( $showmetags as $tagsshown ) {
													echo $tagsshown->cat_name;
													echo "<code>{$tagsshown->cat_ID}</code> &nbsp;&nbsp;";
												}
											echo '
											</p>';
											foreach ( $exclude as $exc ) {
												$title  = str_replace ( $exclude , $section , $exc );
												$option = sanitize_text_field ( get_option ( $exc ) );
												echo "
												<section>
													<label for='{$exc}'>{$title}</label>
													<input type='text' id='{$exc}' name='{$exc}' value='{$option}'>
												</section>";
											}
											$title = $option = null;
										echo '
										</section>';
									}
									$keys_post_formats = array (
										'myoptionalmodules_exclude_postformatsrss' ,
										'myoptionalmodules_exclude_postformatsfront' ,
										'myoptionalmodules_exclude_postformatscategoryarchives' ,
										'myoptionalmodules_exclude_postformatstagarchives' ,
										'myoptionalmodules_exclude_postformatssearchresults' ,
										'myoptionalmodules_exclude_visitorpostformats'
									);
									$fields_post_formats = array (
										'RSS' ,
										'Front page' ,
										'Archives' ,
										'Tags' ,
										'Search' ,
										'Logged out'
									);
									echo '
									<section>
									<p>Exclude these <code>Post Formats</code> from...</p>';
									foreach ( $keys_post_formats as &$keys ) {
										$title = str_replace ( $keys_post_formats , $fields_post_formats , $keys );
										echo "
										<select name='{$keys}' id='$keys'>
											<option value=''>{$title} (none)</option>
											<option value='post-format-aside'";   selected ( get_option ( $keys ) , 'post-format-aside'   ); echo ">{$title} (aside)</option>
											<option value='post-format-gallery'"; selected ( get_option ( $keys ) , 'post-format-gallery' ); echo ">{$title} (gallery)</option>
											<option value='post-format-link'";    selected ( get_option ( $keys ) , 'post-format-link'    ); echo ">{$title} (link)</option>
											<option value='post-format-image'";   selected ( get_option ( $keys ) , 'post-format-image'   ); echo ">{$title} (image)</option>
											<option value='post-format-quote'";   selected ( get_option ( $keys ) , 'post-format-quote'   ); echo ">{$title} (quote)</option>
											<option value='post-format-status'";  selected ( get_option ( $keys ) , 'post-format-status'  ); echo ">{$title} (status)</option>
											<option value='post-format-video'";   selected ( get_option ( $keys ) , 'post-format-video'   ); echo ">{$title} (video)</option>
											<option value='post-format-audio'";   selected ( get_option ( $keys ) , 'post-format-audio'   ); echo ">{$title} (audio)</option>
											<option value='post-format-chat'";    selected ( get_option ( $keys ) , 'post-format-chat'    ); echo ">{$title} (chat)</option>
										</select>";
									}
									$title = null;
									echo '
									</section>
								</div>';
								$showmepages = $showmecats = $showmetags = $showmeusers = $tagcount = $catcount = $usercount = null;
							}
							echo '</div>							
								<div class="clear">
									<input type="submit" value="Save" class="button button-primary" name="myoptionalmodules_settings_form" id="myoptionalmodules_settings_form">';
									if ( !isset ( $_POST['myoptionalmodules_settings_reset'] ) )
										echo '
										<input type="submit" value="Reset" class="button button-primary" name="myoptionalmodules_settings_reset" id="myoptionalmodules_settings_reset">';
									else
										echo '
										<input type="submit" value="Reset Confirm" class="button button-primary" name="myoptionalmodules_settings_reset_confirm" id="myoptionalmodules_settings_reset_confirm">';
									if ( !isset ( $_POST['myoptionalmodules_settings_uninstall'] ) )
										echo '
										<input type="submit" value="Uninstall" class="button button-primary" name="myoptionalmodules_settings_uninstall" id="myoptionalmodules_settings_uninstall">';
									else
										echo '
										<input type="submit" value="Uninstall Confirm" class="button button-primary" name="myoptionalmodules_settings_uninstall_confirm" id="myoptionalmodules_settings_uninstall_confirm">';
							echo '
							</div>
							</div>
						</form>
					</div>';
				}
			}
			$myoptionalmodules_settings_form = new myoptionalmodules_settings_form();
		echo '
		</div>';
	}
}