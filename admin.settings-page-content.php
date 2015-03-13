<?php
/**
 * ADMIN Settings Page Content
 *
 * File last update: 9
 *
 * Content of the /wp-admin/ SETTINGS PAGE for this plugin
 * INCLUDING all SAVE OPERATIONS.
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

if( current_user_can ( 'edit_dashboard' ) && is_admin() ){
	add_action ( 'admin_menu' , 'my_optional_modules_add_options_page' );

	function my_optional_modules_add_options_page() {
		add_options_page ( 'My Optional Modules' , 'My Optional Modules' , 'manage_options' , 'mommaincontrol' ,'my_optional_modules_page_content' );
	}

	function my_optional_modules_page_content() {
		echo '
		<div class="MOMSettings">';

			class myoptionalmodules_settings_form {

				function _construct() {
					global $table_prefix , $wpdb;

					// Trash Removal
					if (
						isset ( $_POST['optimizeTables'] ) ||
						isset ( $_POST['delete_drafts'] ) ||
						isset ( $_POST['delete_unused_terms'] ) ||
						isset ( $_POST['delete_post_revisions'] ) ||
						isset ( $_POST['delete_unapproved_comments'] ) ||
						isset ( $_POST['deleteAllClutter'] )
					) {
						$postsTable    = $table_prefix.'posts';
						$commentsTable = $table_prefix.'comments';
						$termsTable2   = $table_prefix.'terms';
						$termsTable    = $table_prefix.'term_taxonomy';

						if ( isset( $_POST['delete_post_revisions'] ) && check_admin_referer( 'deletePostRevisionsForm' ) ) {
							$wpdb->query( "DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_status` = 'auto-draft' OR `post_status` = 'trash'" );
						}

						if ( isset ( $_POST['delete_unapproved_comments'] ) && check_admin_referer( 'deleteUnapprovedCommentsForm' ) ) {
							$wpdb->query( "DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
						}

						if ( isset( $_POST['delete_unused_terms'] ) && check_admin_referer( 'deleteUnusedTermsForm' ) ) {
							$wpdb->query( "DELETE FROM `$termsTable2` WHERE `term_id` IN ( select `term_id` from `$termsTable` WHERE `count` = 0 )" );
							$wpdb->query( "DELETE FROM `$termsTable` WHERE `count` = 0" );
						}

						if ( isset( $_POST['delete_drafts'] ) && check_admin_referer( 'deleteDraftsForm' ) ) {
							$wpdb->query( "DELETE FROM `$postsTable` WHERE `post_status` = 'draft'" );
						}

						if ( isset( $_POST['deleteAllClutter'] ) && check_admin_referer( 'deleteAllClutterForm' ) ) {
							$wpdb->query( "DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_status` = 'auto-draft' OR `post_status` = 'trash'" );
							$wpdb->query( "DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
							$wpdb->query( "DELETE FROM `$termsTable2` WHERE `term_id` IN ( select `term_id` from `$termsTable` WHERE `count` = 0 )" );
							$wpdb->query( "DELETE FROM `$termsTable` WHERE `count` = 0" );
						}

						if ( isset( $_POST['optimizeTables'] ) && check_admin_referer( 'optimizeTablesForm' ) ) {
							$wpdb->query( "OPTIMIZE TABLE `$postsTable` " );
							$wpdb->query( "OPTIMIZE TABLE `$commentsTable` " );
							$wpdb->query( "OPTIMIZE TABLE `$termsTable2` " );
							$wpdb->query( "OPTIMIZE TABLE `$termsTable` " );
						}
					}

					$options_disable = array (
						'myoptionalmodules_plugincss' ,
						'myoptionalmodules_disablecomments' ,
						'myoptionalmodules_removecode' ,
						'myoptionalmodules_disablepingbacks' ,
						'myoptionalmodules_authorarchives' ,
						'myoptionalmodules_datearchives'
					);
					$keys_disable = array (
						' Plugin CSS' ,
						' Comment form' ,
						' Unnecessary Code' ,
						' Pingbacks' ,
						' Author Archives' ,
						' Date Archives'
					);
					$options_enable = array (
						'myoptionalmodules_metatags' ,
						'myoptionalmodules_horizontalgalleries' ,
						'myoptionalmodules_fontawesome' ,
						'myoptionalmodules_sharelinks' ,
						'myoptionalmodules_rsslinkbacks' ,
						'myoptionalmodules_404s'
					);
					$keys_enable = array (
						' Meta Tags' ,
						' Horizontal Galleries' ,
						' Font Awesome' ,
						' Social Links' ,
						' RSS Linkbacks' ,
						' 404s-to-home'
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
						'myoptionalmodules_commentspamfield' ,
						'myoptionalmodules_ajaxcomments'
					);
					$keys_comment_form = array (
						' DNSBL' ,
						' Spam trap' ,
						' Ajax'
					);
					$options_extras = array (
						'myoptionalmodules_nelio' ,
						'myoptionalmodules_featureimagewidth_submit' ,
						'myoptionalmodules_javascripttofooter' ,
						'myoptionalmodules_lazyload' ,
						'myoptionalmodules_recentpostswidget' ,
						'myoptionalmodules_exclude'
					);
					$keys_extras = array (
						' External Thumbnails' ,
						' Full-width feature images' ,
						' Javascript-to-Footer' ,
						' Lazyload' ,
						' Recent Posts Widget' ,
						' Enable Exclude Posts'
					);
					$theme_extras = array (
						'myoptionalmodules_google' ,
						'myoptionalmodules_previouslinkclass' ,
						'myoptionalmodules_nextlinkclass' ,
						'myoptionalmodules_readmore' ,
						'myoptionalmodules_randompost' ,
						'myoptionalmodules_randomtitles' ,
						'myoptionalmodules_randomdescriptions' ,
						'myoptionalmodules_frontpage' ,
						'myoptionalmodules_miniloopmeta' ,
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
								$value = intval ( $_POST[ $option ] );
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
					}
					echo '
					<div class="settings-section">
						<div class="full">
							<div class="small">
								<strong>Trash Removal</strong>
								<form method="post" action="#trash-removal" name="optimizeTables">';
									wp_nonce_field ( 'optimizeTablesForm' );
									echo '
									<label for="optimizeTables"><i class="fa fa-rocket"></i>Optimize Tables</label>
									<input class="hidden" id="optimizeTables" type="submit" value="Go" name="optimizeTables">
								</form>
								<form method="post" action="#trash-removal" name="deleteAllClutter">';
									wp_nonce_field ( 'deleteAllClutterForm' );
									echo '
									<label for="deleteAllClutter"><i class="fa fa-trash-o"></i>All Trash</label>
									<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
								</form>
								<form method="post" action="#trash-removal" name="deletePostRevisionsForm">';
									wp_nonce_field ( 'deletePostRevisionsForm' );
									echo '
									<label for="delete_post_revisions"><i class="fa fa-trash-o"></i>Revisions + AutoDrafts</label>
									<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
								</form>
								<form method="post" action="#trash-removal" name="deleteUnapprovedCommentsForm">';
									wp_nonce_field ( 'deleteUnapprovedCommentsForm' );
									echo '
									<label for="delete_unapproved_comments"><i class="fa fa-trash-o"></i>Comments</label>
									<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
								</form>
								<form method="post" action="#trash-removal" name="deleteUnusedTermsForm">';
									wp_nonce_field ( 'deleteUnusedTermsForm' );
									echo '
									<label for="delete_unused_terms"><i class="fa fa-trash-o"></i>Orphan Tags + Categories</label>
									<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
								</form>
								<form method="post" action="#trash-removal" name="deleteDraftsForm">';
									wp_nonce_field ( 'deleteDraftsForm' );
									echo '
									<label for="delete_drafts"><i class="fa fa-trash-o"></i>Drafts</label>
									<input class="hidden" id="delete_drafts" type="submit" value="Go" name="delete_drafts">
								</form>
							</div>
							<div class="right-section">
								<div>
									<strong>My Optional Modules</strong>
									<section>
									<p>Need help? <a href="https://wordpress.org/support/plugin/my-optional-modules">Support forum</a></p>
									<p>Need information? <a href="http://iamnotu.com/my-optional-modules/">Documentation</a></p>
									<p>Give it a rating? <a href="https://wordpress.org/support/view/plugin-reviews/my-optional-modules">Review</a></p>
									</section>
								</div>
							</div>
						</div>
						<form method="post" name="myoptionalmodules_settings_form" action="" class="MOM_form">';
							wp_nonce_field ( 'myoptionalmodules_settings_form' );
							echo '
							<div class="left-section">
								<div>
									<strong>Disable</strong>';
									foreach ( $options_disable as &$option ) {
										$title   = str_replace( $options_disable , $keys_disable , $option );
										$checked = null;

										if ( get_option ( $option ) )
											$checked = ' checked';
										echo "
										<section>
											<input type='checkbox' value='1' name='$option' id='$option'$checked> $title
										</section>";
									}
								echo '
								</div>
								<div>
									<strong>Enable</strong>';
									foreach ( $options_enable as &$option ) {
										$title = str_replace( $options_enable , $keys_enable , $option );
										$checked = null;

										if ( get_option ( $option ) )
											$checked = ' checked';
										echo "
										<section>
											<input type='checkbox' value='1' name='$option' id='$option'$checked> $title
										</section>";
									}
								echo '
								</div>';

								if ( get_option ( 'myoptionalmodules_sharelinks' ) ) {
									echo '
									<div>
										<strong>Social Links</strong>';
										foreach ( $options_shares as &$option ) {
											$title = str_replace ( $options_shares , $keys_shares , $option );
											$checked = null;

											if ( get_option ( $option ) )
												$checked = ' checked';
											echo "
											<section>
												<input type='checkbox' value='1' name='$option' id='$option'$checked> $title
											</section>";
										}
										echo '
										</div>';
								}
							echo '
							<div>
								<strong>Comment Form</strong>';
								foreach ( $options_comment_form as &$option ) {
									$title = str_replace ( $options_comment_form , $keys_comment_form , $option );
									$checked = null;

									if ( get_option ( $option ) )
										$checked = ' checked';
									echo "
									<section>
										<input type='checkbox' value='1' name='$option' id='$option'$checked> $title
									</section>";
								}
								echo '
								</div>
								<div>
									<strong>Extras</strong>';
									foreach ( $options_extras as &$option ) {
										$title = str_replace ( $options_extras , $keys_extras , $option );
										$checked = null;

										if ( get_option( $option ) )
											$checked = ' checked';
											echo "
											<section>
												<input type='checkbox' value='1' name='$option' id='$option'$checked> $title
											</section>";
									}
									echo '
									</div>
								</div>
								<div class="right-section">
									<div>
										<strong>Theme Extras</strong>
										<select name="myoptionalmodules_frontpage" id="mompaf_0">
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
												<option name='myoptionalmodules_frontpage' id='mompaf_'$postsshown->ID' value='$postsshown->ID'";
												$postID   = $postsshown->ID;
												$selected = selected ( $myoptionalmodules_frontpage , $postID );
												echo "
												>Front page: '$postsshown->post_title'</option>";
											}
										echo '
										</select>';
										$google = $previousclass = $nextclass = $readmore = $randompost = $randomtitles = $randomdescriptions = null;
										$google             = get_option( 'myoptionalmodules_google' );
										$previousclass      = get_option( 'myoptionalmodules_previouslinkclass' );
										$nextclass          = get_option( 'myoptionalmodules_nextlinkclass' );
										$readmore           = get_option( 'myoptionalmodules_readmore' );
										$randompost         = get_option( 'myoptionalmodules_randompost' );
										$randomtitles       = get_option( 'myoptionalmodules_randomtitles' );
										$randomdescriptions = get_option( 'myoptionalmodules_randomdescriptions' );
										$miniloop_meta      = get_option( 'myoptionalmodules_miniloopmeta' );
										$miniloop_style     = get_option( 'myoptionalmodules_miniloopstyle' );
										$miniloop_amount    = get_option( 'myoptionalmodules_miniloopamount' );
										echo "
										<section>
											<label>Miniloop: meta</label>
											<input type='text' id='myoptionalmodules_miniloopmeta' name='myoptionalmodules_miniloopmeta' value='$miniloop_meta' />
										</section>
										<section>";
											echo '
											<select name="myoptionalmodules_miniloopstyle" id="myoptionalmodules_miniloopstyle">
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
											<label>Miniloop: amount</label>
											<input type='text' id='myoptionalmodules_miniloopamount' name='myoptionalmodules_miniloopamount' value='$miniloop_amount' />
										</section>
										<section>
											<label>Google Tracking ID</label>
											<input type='text' id='myoptionalmodules_google' name='myoptionalmodules_google' value='$google' />
										</section>
										<section>
											<label>Previous link class</label>
											<input type='text' id='myoptionalmodules_previouslinkclass' name='myoptionalmodules_previouslinkclass' value='$previousclass' />
										</section>
										<section>
											<label>Next link class</label>
											<input type='text' id='myoptionalmodules_nextlinkclass' name='myoptionalmodules_nextlinkclass' value='$nextclass' />
										</section>
										<section>
											<label>Read more... value</label>
											<input type='text' id='myoptionalmodules_readmore' name='myoptionalmodules_readmore' value='$readmore' />
										</section>
										<section>
											<label>yoursite.tld/<em>?random</em> keyword</label>
											<input type='text' id='myoptionalmodules_randompost' name='myoptionalmodules_randompost' value='$randompost' />
										</section>
										<section>
											<label>Random::site::titles</label>
											<textarea id='myoptionalmodules_randomtitles' name='myoptionalmodules_randomtitles'>$randomtitles</textarea>
										</section>
										<section>
											<label>Random::site::description</label>
											<textarea id='myoptionalmodules_randomdescriptions' name='myoptionalmodules_randomdescriptions'>$randomdescriptions</textarea>
										</section>
									</div>
								</div>
								<div class='clear'>";

									if ( get_option ( 'myoptionalmodules_exclude' ) ) {
										$showmepages = get_pages();
										$showmecats  = get_categories ( 'taxonomy=category&hide_empty=0' );
										$showmetags  = get_categories ( 'taxonomy=post_tag&hide_empty=0' );
										$showmeusers = get_users();
										$tagcount    = 0;
										$catcount    = 0;
										$usercount   = 0;
										echo '
										<div class="fullwidth">
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
														<label for='$exc'>$title</label>
														<input type='text' id='$exc' name='$exc' value='$option'>
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
													echo "<code>$catsshown->cat_ID</code> &nbsp;&nbsp;";
												}
											echo '
											</p>';

											if ( $catcount > 0 ) {
												foreach ( $exclude as $exc ) {
													$title  = str_replace ( $exclude , $section , $exc );
													$option = sanitize_text_field ( get_option ( $exc ) );
													echo "
													<section>
														<label for='$exc'>$title</label>
														<input type='text' id='$exc' name='$exc' value='$option'>
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
														echo "<code>$tagsshown->cat_ID</code> &nbsp;&nbsp;";
													}
												echo '
												</p>';
												foreach ( $exclude as $exc ) {
													$title  = str_replace ( $exclude , $section , $exc );
													$option = sanitize_text_field ( get_option ( $exc ) );
													echo "
													<section>
														<label for='$exc'>$title</label>
														<input type='text' id='$exc' name='$exc' value='$option'>
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
											<select name='$keys' id='$keys'>
												<option value=''>$title (none)</option>
												<option value='post-format-aside'";   selected ( get_option ( $keys ) , 'post-format-aside'   ); echo ">$title (aside)</option>
												<option value='post-format-gallery'"; selected ( get_option ( $keys ) , 'post-format-gallery' ); echo ">$title (gallery)</option>
												<option value='post-format-link'";    selected ( get_option ( $keys ) , 'post-format-link'    ); echo ">$title (link)</option>
												<option value='post-format-image'";   selected ( get_option ( $keys ) , 'post-format-image'   ); echo ">$title (image)</option>
												<option value='post-format-quote'";   selected ( get_option ( $keys ) , 'post-format-quote'   ); echo ">$title (quote)</option>
												<option value='post-format-status'";  selected ( get_option ( $keys ) , 'post-format-status'  ); echo ">$title (status)</option>
												<option value='post-format-video'";   selected ( get_option ( $keys ) , 'post-format-video'   ); echo ">$title (video)</option>
												<option value='post-format-audio'";   selected ( get_option ( $keys ) , 'post-format-audio'   ); echo ">$title (audio)</option>
												<option value='post-format-chat'";    selected ( get_option ( $keys ) , 'post-format-chat'    ); echo ">$title (chat)</option>
											</select>";
										}
										$title = null;
										echo '
										</section>
									</div>';
									$showmepages = $showmecats = $showmetags = $showmeusers = $tagcount = $catcount = $usercount = null;
								}
								echo '
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
						</form>
					</div>';
				}
			}
			$myoptionalmodules_settings_form = new myoptionalmodules_settings_form();
			$myoptionalmodules_settings_form->_construct();
		echo '
		</div>';
	}
}