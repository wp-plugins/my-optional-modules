<?php

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

add_action( 'admin_menu','my_optional_modules_add_options_page' );
function my_optional_modules_add_options_page(){
	add_options_page( 'My Optional Modules','My Optional Modules','manage_options','mommaincontrol','my_optional_modules_page_content' ); 
}
/**
 * Content to display on the options page
 */
function my_optional_modules_page_content(){
	global $myoptionalmodules_upgrade_version;
?>
	<div class="MOMSettings">
		<div class="settings-section" id="name">
			<span class="full-title">My Optional Modules <a href="//wordpress.org/support/view/plugin-reviews/my-optional-modules">Rate</a><a href="//wordpress.org/support/plugin/my-optional-modules">Support</a></span>
			<div class="right-half">

				<?php if( $myoptionalmodules_upgrade_version != get_option( 'myoptionalmodules_upgrade_version' ) ) { ?>
					<form method="post" action="#name" name="MOM_UPGRADE">
					<?php wp_nonce_field( 'MOM_UPGRADE' ); ?>
					<label for="MOM_UPGRADE">
						<i class="fa fa-exclamation"></i>
						Database Upgrade
						<span>A database upgrade is required</span>
					</label>
					<input type="submit" id="MOM_UPGRADE" name="MOM_UPGRADE" class="hidden" value="Submit" />
					</form>
				<?php } ?>
				
				<?php if( !isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
					<form method="post" action="#name" name="mom_delete_step_one">
					<?php wp_nonce_field( 'mom_delete_step_one' ); ?>
					<label for="mom_delete_step_one">
						<i class="fa fa-exclamation"></i>
						Uninstall
						<span>Click to initiate uninstall</span>
					</label>
					<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hidden" value="Submit" />
					</form>
				<?php } ?>
				<?php if( isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
					<form method="post" action="#name" name="MOM_UNINSTALL_EVERYTHING">
					<?php wp_nonce_field( 'MOM_UNINSTALL_EVERYTHING' ); ?>
					<label for="MOM_UNINSTALL_EVERYTHING">
						<i class="fa fa-exclamation-triangle"></i>
						Uninstall
						<span>Click to finalize uninstall</span>
					</label>
					<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hidden" value="Submit" />
					</form>
				<?php } ?>
			</div>
		</div>
		<?php if( $myoptionalmodules_upgrade_version == get_option( 'myoptionalmodules_upgrade_version' ) ) { ?>
			<?php global $table_prefix, $wpdb;
			if( isset( $_POST[ 'optimizeTables' ] ) && check_admin_referer( 'optimizeTablesForm' ) || isset( $_POST[ 'delete_drafts' ] ) || isset( $_POST[ 'delete_unused_terms' ] ) || isset( $_POST[ 'delete_post_revisions' ] ) || isset( $_POST[ 'delete_unapproved_comments' ] ) || isset( $_POST[ 'deleteAllClutter' ] ) ) {
				$postsTable    = $table_prefix.'posts';
				$commentsTable = $table_prefix.'comments';
				$termsTable2   = $table_prefix.'terms';
				$termsTable    = $table_prefix.'term_taxonomy';
				if( isset( $_POST[ 'delete_post_revisions' ] ) && check_admin_referer( 'deletePostRevisionsForm' ) ) {
					$wpdb->query( "DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_status` = 'auto-draft' OR `post_status` = 'trash'" );
				}
				if( isset ($_POST[ 'delete_unapproved_comments' ] ) && check_admin_referer( 'deleteUnapprovedCommentsForm' ) ) {
					$wpdb->query( "DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
				}
				if( isset( $_POST[ 'delete_unused_terms' ] ) && check_admin_referer( 'deleteUnusedTermsForm' ) ) {
					$wpdb->query( "DELETE FROM `$termsTable2` WHERE `term_id` IN ( select `term_id` from `$termsTable` WHERE `count` = 0 )" );
					$wpdb->query( "DELETE FROM `$termsTable` WHERE `count` = 0");
				}
				if( isset( $_POST[ 'delete_drafts' ] ) && check_admin_referer( 'deleteDraftsForm' ) ) {
					$wpdb->query( "DELETE FROM `$postsTable` WHERE `post_status` = 'draft'" );
				}
				if( isset( $_POST[ 'deleteAllClutter' ] ) && check_admin_referer( 'deleteAllClutterForm' ) ) {
					$wpdb->query( "DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_status` = 'auto-draft' OR `post_status` = 'trash'" );
					$wpdb->query( "DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
					$wpdb->query( "DELETE FROM `$termsTable2` WHERE `term_id` IN ( select `term_id` from `$termsTable` WHERE `count` = 0 )" );
					$wpdb->query( "DELETE FROM `$termsTable` WHERE `count` = 0" );
				}
				if( isset( $_POST[ 'optimizeTables' ] ) && check_admin_referer( 'optimizeTablesForm' ) ) {
					$wpdb->query( "OPTIMIZE TABLE `$postsTable` ");
					$wpdb->query( "OPTIMIZE TABLE `$commentsTable` ");
					$wpdb->query( "OPTIMIZE TABLE `$termsTable2` ");
					$wpdb->query( "OPTIMIZE TABLE `$termsTable` ");
				}
			}		
			$drafts_count = $revisions_count = $comments_count = $terms_count = 0;
			$postsTable      = $table_prefix . 'posts';
			$commentsTable   = $table_prefix . 'comments';
			$termsTable2     = $table_prefix . 'terms';
			$termsTable      = $table_prefix . 'term_taxonomy';
			$revisions_total = $wpdb->get_results ( "SELECT ID FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_type` = 'auto_draft' OR `post_status` = 'trash'" );
			$drafts_total    = $wpdb->get_results ( "SELECT ID FROM `$postsTable` WHERE `post_status` = 'draft'" );
			$comments_total  = $wpdb->get_results ( "SELECT comment_ID FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
			$terms_total     = $wpdb->get_results ( "SELECT term_taxonomy_id FROM `$termsTable` WHERE `count` = '0'" );
			if( count( $drafts_total ) ) {
				foreach( $drafts_total as $drafts ) {
					++$drafts_count;
				}			
			}
			if( count( $revisions_total ) ) { 
				foreach( $revisions_total as $retot ) { 
					++$revisions_count; 
				}
			}
			if( count( $comments_total ) ) {
				foreach( $comments_total as $comtot ) { 
					++$comments_count; 
				}
			}
			if( count( $terms_total ) ) {
				foreach( $terms_total as $termstot  ) {
					++$terms_count; 
				}
			}
			$totalClutter    = ( $terms_count + $comments_count + $revisions_count ); ?>
			<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_toggletrash' ) ) { ?> toggled<?php }?>" id="trash-removal">
				<label class="full-title" for="myoptionalmodules_admin_toggletrash_submit">Trash Removal</label>
				<form class="toggle" method="post" action="#trash-removal" name="myoptionalmodules_admin_toggletrash_submit">
					<?php wp_nonce_field( 'myoptionalmodules_admin_toggletrash_submit' ); ?>
					<label for="myoptionalmodules_admin_toggletrash_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_toggletrash' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_toggletrash" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_toggletrash" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_toggletrash_submit" type="submit" name="myoptionalmodules_admin_toggletrash_submit">
				</form>
				<div class="right-half">
					<form method="post" action="#trash-removal" name="optimizeTables">
						<?php wp_nonce_field( 'optimizeTablesForm' ); ?>
						<label for="optimizeTables"">
							<i class="fa fa-rocket"></i>
							Optimize Tables
							<span>Fix database overhead</span>
						</label>
						<input class="hidden" id="optimizeTables" type="submit" value="Go" name="optimizeTables">
					</form>				
					<form method="post" action="#trash-removal" name="deleteAllClutter">
						<?php wp_nonce_field( 'deleteAllClutterForm' ); ?>
						<label for="deleteAllClutter" title="<?php echo esc_attr( $totalClutter );?>">
							<i class="fa fa-trash-o"></i>
							All
							<span>Delete all (except for drafts)</span>
						</label>
						<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
					</form>
					<form method="post" action="#trash-removal" name="deletePostRevisionsForm">
						<?php wp_nonce_field( 'deletePostRevisionsForm' ); ?>
						<label for="delete_post_revisions" title="<?php echo esc_attr( $revisions_count ); ?>">
							<i class="fa fa-trash-o"></i>
							Revisions/Auto-drafts
							<?php if( count( $revisions_total ) ) { echo '<span>' . $revisions_count . ' revisions</span>'; } else { echo '<span>No trash here!</span>'; } ?>
						</label>
						<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
					</form>
					<form method="post" action="#trash-removal" name="deleteUnapprovedCommentsForm">
						<?php wp_nonce_field( 'deleteUnapprovedCommentsForm' ); ?>
						<label for="delete_unapproved_comments" title="<?php echo esc_attr( $comments_count ); ?>">
							<i class="fa fa-trash-o"></i>
							Unapproved/Spam/Trash Comments
							<?php if( count( $comments_total ) ) { echo '<span>' . $comments_count . ' unapproved comments</span>'; } else { echo '<span>No trash here!</span>'; } ?>
						</label>
						<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
					</form>
					<form method="post" action="#trash-removal" name="deleteUnusedTermsForm">
						<?php wp_nonce_field( 'deleteUnusedTermsForm' ); ?>
						<label for="delete_unused_terms" title="<?php echo esc_attr( $terms_count ); ?>">
							<i class="fa fa-trash-o"></i>
							Unused categories/tags
							<?php if( count( $terms_total ) ) { echo '<span>' . $terms_count . ' unused taxonomies</span>'; } else { echo '<span>No trash here!</span>'; } ?>
						</label>
						<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
					</form>
					<form method="post" action="#trash-removal" name="deleteDraftsForm">
						<?php wp_nonce_field( 'deleteDraftsForm' ); ?>
						<label for="delete_drafts" title="<?php echo esc_attr( $drafts_count ); ?>">
							<i class="fa fa-trash-o"></i>
							Post drafts
							<?php if( count( $drafts_total ) ) { echo '<span>' . $drafts_count . ' drafts</span>'; } else { echo '<span>No trash here!</span>'; } ?>
						</label>
						<input class="hidden" id="delete_drafts" type="submit" value="Go" name="delete_drafts">
					</form>
				</div>
			
				
				
				
				
			
			</div>
			
			<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_toggledisable' ) ) { ?> toggled<?php }?>" id="disable">
				<label for="myoptionalmodules_admin_toggledisable_submit" class="full-title">Disable components</label>
				<form class="toggle" method="post" action="#disable" name="myoptionalmodules_admin_toggledisable_submit">
					<?php wp_nonce_field( 'myoptionalmodules_admin_toggledisable_submit' ); ?>
					<label for="myoptionalmodules_admin_toggledisable_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_toggledisable' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_toggledisable" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_toggledisable" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_toggledisable_submit" type="submit" name="myoptionalmodules_admin_toggledisable_submit">
				</form>
				<div class="right-half">
					<form method="post" action="#name" name="myoptionalmodules_plugincss_submit">
						<?php wp_nonce_field( 'myoptionalmodules_plugincss_submit' ); ?>
						<label for="myoptionalmodules_plugincss_submit">
						<?php if( get_option( 'myoptionalmodules_plugincss' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
							<span>Plugin is not including its own CSS file</span>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
							<span>Plugin is including its own CSS file</span>
						<?php }?>
						Plugin CSS
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_plugincss' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_plugincss" />
						<input type="submit" id="myoptionalmodules_plugincss_submit" name="myoptionalmodules_plugincss_submit" value="Submit" class="hidden" />
					</form>	
					<form method="post" action="#disable" name="myoptionalmodules_disablecomments_submit">
						<?php wp_nonce_field( 'myoptionalmodules_disablecomments_submit' ); ?>
						<label for="myoptionalmodules_disablecomments_submit">
						<?php if( get_option( 'myoptionalmodules_disablecomments' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
							<span>Comments are disabled on posts and pages</span>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
							<span>Comments are enabled on posts and pages</span>
						<?php }?>
						Comments
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_disablecomments' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_disablecomments" />
						<input type="submit" id="myoptionalmodules_disablecomments_submit" name="myoptionalmodules_disablecomments_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#disable" name="myoptionalmodules_removecode_submit">
						<?php wp_nonce_field( 'myoptionalmodules_removecode_submit' ); ?>
						<label for="myoptionalmodules_removecode_submit">
						<?php if( get_option( 'myoptionalmodules_removecode' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
							<span>Removed: version info, style IDs, head junk - Added: CDN jquery</span>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
							<span>Your code is unaltered</span>
						<?php }?>
						Remove unnecessary code
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_removecode' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_removecode" />
						<input type="submit" id="myoptionalmodules_removecode_submit" name="myoptionalmodules_removecode_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#disable" name="myoptionalmodules_disablepingbacks_submit">
						<?php wp_nonce_field( 'myoptionalmodules_disablepingbacks_submit' ); ?>
						<label for="myoptionalmodules_disablepingbacks_submit">
						<?php if( get_option( 'myoptionalmodules_disablepingbacks' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
							<span>Pingbacks are disabled</span>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
							<span>Pingbacks are enabled</span>
						<?php }?>
						Pingbacks
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_disablepingbacks' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_disablepingbacks" />
						<input type="submit" id="myoptionalmodules_disablepingbacks_submit" name="myoptionalmodules_disablepingbacks_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#disable" name="myoptionalmodules_authorarchives_submit">
						<?php wp_nonce_field( 'myoptionalmodules_authorarchives_submit' ); ?>
						<label for="myoptionalmodules_authorarchives_submit" title="Author-based archives">
						<?php if( get_option( 'myoptionalmodules_authorarchives' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
							<span>Author archives (single-author blog) are disabled</span>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
							<span>Author archives are enabled</span>
						<?php } ?>
						Author Archives
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_authorarchives' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_authorarchives" />
						<input type="submit" id="myoptionalmodules_authorarchives_submit" name="myoptionalmodules_authorarchives_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#disable" name="myoptionalmodules_datearchives_submit">
						<?php wp_nonce_field( 'myoptionalmodules_datearchives_submit' ); ?>
						<label for="myoptionalmodules_datearchives_submit" title="Dated-based archives">
						<?php if( get_option( 'myoptionalmodules_datearchives' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
							<span>Date based archives are disabled</span>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
							<span>Date based archives are enabled</span>
						<?php } ?>
						Date Archives				
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_datearchives' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_datearchives" />
						<input type="submit" id="myoptionalmodules_datearchives_submit" name="myoptionalmodules_datearchives_submit" value="Submit" class="hidden" />
					</form>
				</div>
			</div>
			
			<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_toggleenable' ) ) { ?> toggled<?php }?>" id="enable">
				<label for="myoptionalmodules_admin_toggleenable_submit" class="full-title">Enable components</label>
				<form class="toggle" method="post" action="#enable" name="myoptionalmodules_admin_toggleenable_submit">
					<?php wp_nonce_field( 'myoptionalmodules_admin_toggleenable_submit' ); ?>
					<label for="myoptionalmodules_admin_toggleenable_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_toggleenable' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_toggleenable" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_toggleenable" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_toggleenable_submit" type="submit" name="myoptionalmodules_admin_toggleenable_submit">
				</form>
				<div class="right-half">
					<form method="post" action="#enable" name="myoptionalmodules_metatags_submit">
						<?php wp_nonce_field( 'myoptionalmodules_metatags_submit' ); ?>
						<label for="myoptionalmodules_metatags_submit">
							<?php if( get_option( 'myoptionalmodules_metatags' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>OG:tags enabled (Set optional Twitter handle in your profile)</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>OG:tags disabled</span>
							<?php }?>
							Meta Tags
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_metatags' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_metatags" />
						<input type="submit" id="myoptionalmodules_metatags_submit" name="myoptionalmodules_metatags_submit" value="Submit" class="hidden" />
					</form>				
					<form method="post" action="#enable" name="myoptionalmodules_horizontalgalleries_submit">
						<?php wp_nonce_field( 'myoptionalmodules_horizontalgalleries_submit' ); ?>
						<label for="myoptionalmodules_horizontalgalleries_submit">
							<?php if( get_option( 'myoptionalmodules_horizontalgalleries' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Image galleries are horizontal</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Image galleries are default</span>
							<?php }?>
							Horizontal Galleries
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_horizontalgalleries' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_horizontalgalleries" />
						<input type="submit" id="myoptionalmodules_horizontalgalleries_submit" name="myoptionalmodules_horizontalgalleries_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#enable" name="myoptionalmodules_fontawesome_submit">
						<?php wp_nonce_field( 'myoptionalmodules_fontawesome_submit' ); ?>
							<label id="font_awesome" for="myoptionalmodules_fontawesome_submit">
							<?php if( get_option( 'myoptionalmodules_fontawesome' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Font Awesome is enabled</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Font Awesome is not enabled</span>
							<?php } ?>
							Font Awesome
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_fontawesome' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_fontawesome" />
						<input type="submit" id="myoptionalmodules_fontawesome_submit" name="myoptionalmodules_fontawesome_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#enable" name="myoptionalmodules_sharelinks_submit">
						<?php wp_nonce_field( 'myoptionalmodules_sharelinks_submit' ); ?>
						<label for="myoptionalmodules_sharelinks_submit">
							<?php if( get_option( 'myoptionalmodules_sharelinks' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Social Share Links are enabled</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Social Share Links are not enabled</span>
							<?php }?>
							Social Share Links
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_sharelinks' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_sharelinks" />
						<input type="submit" id="myoptionalmodules_sharelinks_submit" name="myoptionalmodules_sharelinks_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#enable" name="myoptionalmodules_rsslinkbacks_submit">
						<?php wp_nonce_field( 'myoptionalmodules_rsslinkbacks_submit' ); ?>
						<label for="myoptionalmodules_rsslinkbacks_submit">
							<?php if( get_option( 'myoptionalmodules_rsslinkbacks' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Your RSS items are linking back to your blog</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Your RSS items are not linking back to you</span>
							<?php }?>
							RSS Link Backs
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_rsslinkbacks' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_rsslinkbacks" />
						<input type="submit" id="myoptionalmodules_rsslinkbacks_submit" name="myoptionalmodules_rsslinkbacks_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#enable" name="myoptionalmodules_404s_submit">
						<?php wp_nonce_field( 'myoptionalmodules_404s_submit' ); ?>
						<label for="myoptionalmodules_404s_submit">
							<?php if( get_option( 'myoptionalmodules_404s' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>All 404s are redirecting to the homepage</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>404s are being handled normally</span>
							<?php }?>
							404 Redirection
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_404s' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_404s" />
						<input type="submit" id="myoptionalmodules_404s_submit" name="myoptionalmodules_404s_submit" value="Submit" class="hidden" />
					</form>				
				</div>
			</div>
			<?php if( get_option( 'myoptionalmodules_sharelinks' ) ) { ?>
				<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_toggleshare' ) ) { ?> toggled<?php }?>" id="shareicons">
					<label for="myoptionalmodules_admin_toggleshare_submit" class="full-title">Share Icons</label>
					<form class="toggle" method="post" action="#shareicons" name="myoptionalmodules_admin_toggleshare_submit">
						<?php wp_nonce_field( 'myoptionalmodules_admin_toggleshare_submit' ); ?>
						<label for="myoptionalmodules_admin_toggleshare_submit"">
							<?php if( !get_option( 'myoptionalmodules_admin_toggleshare' ) ) { ?>
								<i class="fa fa-minus-square"></i>
								<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_toggleshare" />
							<?php } else { ?>
								<i class="fa fa-plus-square"></i>
								<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_toggleshare" />
							<?php }?>
						</label>
						<input class="hidden" id="myoptionalmodules_admin_toggleshare_submit" type="submit" name="myoptionalmodules_admin_toggleshare_submit">
					</form>				
					<div class="right-half">
						<form method="post" action="#shareicons" name="myoptionalmodules_sharelinks_reddit_submit">
							<?php wp_nonce_field( 'myoptionalmodules_sharelinks_reddit_submit' ); ?>
							<label for="myoptionalmodules_sharelinks_reddit_submit">
								<?php if( get_option( 'myoptionalmodules_sharelinks_reddit' ) ) { ?>
									<i class="fa fa-toggle-on"></i>
								<?php } else { ?>
									<i class="fa fa-toggle-off"></i>
								<?php }?>
								<span>
									<?php if( get_option( 'myoptionalmodules_fontawesome' ) ) { ?>
										<i class="fa fa-reddit"></i>
									<?php } else { ?>
										reddit
									<?php }?>
								</span>
								reddit
							</label>
							<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_sharelinks_reddit' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_sharelinks_reddit" />
							<input type="submit" id="myoptionalmodules_sharelinks_reddit_submit" name="myoptionalmodules_sharelinks_reddit_submit" value="Submit" class="hidden" />
						</form>
						<form method="post" action="#shareicons" name="myoptionalmodules_sharelinks_google_submit">
							<?php wp_nonce_field( 'myoptionalmodules_sharelinks_google_submit' ); ?>
							<label for="myoptionalmodules_sharelinks_google_submit">
								<?php if( get_option( 'myoptionalmodules_sharelinks_google' ) ) { ?>
									<i class="fa fa-toggle-on"></i>
								<?php } else { ?>
									<i class="fa fa-toggle-off"></i>
								<?php }?>
								<span>
									<?php if( get_option( 'myoptionalmodules_fontawesome' ) ) { ?>
										<i class="fa fa-google-plus"></i>
									<?php }else { ?>
										google+
									<?php }?>
								</span>
								google+
							</label>
							<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_sharelinks_google' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_sharelinks_google" />
							<input type="submit" id="myoptionalmodules_sharelinks_google_submit" name="myoptionalmodules_sharelinks_google_submit" value="Submit" class="hidden" />
						</form>
						<form method="post" action="#shareicons" name="myoptionalmodules_sharelinks_twitter_submit">
							<?php wp_nonce_field( 'myoptionalmodules_sharelinks_twitter_submit' ); ?>
							<label for="myoptionalmodules_sharelinks_twitter_submit">
								<?php if( get_option( 'myoptionalmodules_sharelinks_twitter' ) ) { ?>
									<i class="fa fa-toggle-on"></i>
								<?php } else { ?>
									<i class="fa fa-toggle-off"></i>
								<?php }?>
								<span>
									<?php if( get_option( 'myoptionalmodules_fontawesome' ) ) { ?>
										<i class="fa fa-twitter"></i>
									<?php }else {?>
										twitter
									<?php }?>
								</span>
								twitter
							</label>
							<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_sharelinks_twitter' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_sharelinks_twitter" />
							<input type="submit" id="myoptionalmodules_sharelinks_twitter_submit" name="myoptionalmodules_sharelinks_twitter_submit" value="Submit" class="hidden" />
						</form>
						<form method="post" action="#shareicons" name="myoptionalmodules_sharelinks_facebook_submit">
							<?php wp_nonce_field( 'myoptionalmodules_sharelinks_facebook_submit' ); ?>
							<label for="myoptionalmodules_sharelinks_facebook_submit">
								<?php if( get_option( 'myoptionalmodules_sharelinks_facebook' ) ) { ?>
									<i class="fa fa-toggle-on"></i>
								<?php } else { ?>
									<i class="fa fa-toggle-off"></i>
								<?php }?>
								<span>
									<?php if( get_option( 'myoptionalmodules_fontawesome' ) ) { ?>
										<i class="fa fa-facebook"></i>
									<?php }else{ ?>
										facebook
									<?php }?>
								</span>
								facebook
							</label>
							<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_sharelinks_facebook' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_sharelinks_facebook" />
							<input type="submit" id="myoptionalmodules_sharelinks_facebook_submit" name="myoptionalmodules_sharelinks_facebook_submit" value="Submit" class="hidden" />
						</form>
						<form method="post" action="#shareicons" name="myoptionalmodules_sharelinks_email_submit">
							<?php wp_nonce_field( 'myoptionalmodules_sharelinks_email_submit' ); ?>
							<label for="myoptionalmodules_sharelinks_email_submit">
								<?php if( get_option( 'myoptionalmodules_sharelinks_email' ) ) { ?>
									<i class="fa fa-toggle-on"></i>
								<?php } else { ?>
									<i class="fa fa-toggle-off"></i>
								<?php }?>
								<span>
									<?php if( get_option( 'myoptionalmodules_fontawesome' ) ) { ?>
										<i class="fa fa-envelope"></i>
									<?php }else{ ?>
										email
									<?php }?>
								</span>
								email
							</label>
							<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_sharelinks_email' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_sharelinks_email" />
							<input type="submit" id="myoptionalmodules_sharelinks_email_submit" name="myoptionalmodules_sharelinks_email_submit" value="Submit" class="hidden" />
						</form>
						<form method="post" action="#shareicons" name="myoptionalmodules_shareslinks_top_submit">
							<?php wp_nonce_field( 'myoptionalmodules_shareslinks_top_submit' ); ?>
							<label for="myoptionalmodules_shareslinks_top_submit">
								<?php if( get_option( 'myoptionalmodules_shareslinks_top' ) ) { ?>
									<i class="fa fa-toggle-on"></i>
									<span>Links are at the top of your post content</span>
								<?php } else { ?>
									<i class="fa fa-toggle-off"></i>
									<span>Links are at the bottom of your post content</span>
								<?php }?>
								Link location Top/Bottom
							</label>
							<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_shareslinks_top' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_shareslinks_top" />
							<input type="submit" id="myoptionalmodules_shareslinks_top_submit" name="myoptionalmodules_shareslinks_top_submit" value="Submit" class="hidden" />
						</form>
						<form method="post" action="#shareicons" name="myoptionalmodules_sharelinks_pages_submit">
							<?php wp_nonce_field( 'myoptionalmodules_sharelinks_pages_submit' ); ?>
							<label for="myoptionalmodules_sharelinks_pages_submit">
								<?php if( get_option( 'myoptionalmodules_sharelinks_pages' ) ) { ?>
									<i class="fa fa-toggle-on"></i>
									<span>Links are being included on pages</span>
								<?php } else { ?>
									<i class="fa fa-toggle-off"></i>
									<span>Links are not enabled on pages</span>
								<?php }?>
								Enable for pages
							</label>
							<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_sharelinks_pages' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_sharelinks_pages" />
							<input type="submit" id="myoptionalmodules_sharelinks_pages_submit" name="myoptionalmodules_sharelinks_pages_submit" value="Submit" class="hidden" />
						</form>
					</div>
				</div>
			<?php }?>		
			<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_togglecomment' ) ) { ?> toggled<?php }?>" id="comment-modules">
				<label for="myoptionalmodules_admin_togglecomment_submit" class="full-title">Comment Form Extras</label>
				<form class="toggle" method="post" action="#comment-modules" name="toggle_comment_form">
					<?php wp_nonce_field( 'toggle_comment_form' ); ?>
					<label for="myoptionalmodules_admin_togglecomment_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_togglecomment' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_togglecomment" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_togglecomment" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_togglecomment_submit" type="submit" name="myoptionalmodules_admin_togglecomment_submit">
				</form>			
				<div class="right-half">
					<form method="post" action="#comment-modules" name="myoptionalmodules_dnsbl_submit">
						<?php wp_nonce_field( 'myoptionalmodules_dnsbl_submit' ); ?>
						<label for="myoptionalmodules_dnsbl_submit">
							<?php if( get_option( 'myoptionalmodules_dnsbl' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Comment form is invisible to potentially malicious IPs</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Comment form is visible to everyone</span>
							<?php }?>
							DNSBL 
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_dnsbl' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_dnsbl" />
						<input type="submit" id="myoptionalmodules_dnsbl_submit" name="myoptionalmodules_dnsbl_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#comment-modules" name="myoptionalmodules_commentspamfield_submit">
						<?php wp_nonce_field( 'myoptionalmodules_commentspamfield_submit' ); ?>
						<label for="myoptionalmodules_commentspamfield_submit">
							<?php if( get_option( 'myoptionalmodules_commentspamfield' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Your comment form has an invisible spam trap</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>You are not using the spam trap</span>
							<?php }?>
							Spam Trap
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_commentspamfield' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_commentspamfield" />
						<input type="submit" id="myoptionalmodules_commentspamfield_submit" name="myoptionalmodules_commentspamfield_submit" value="Submit" class="hidden" />
					</form>				
					<form method="post" action="#comment-modules" name="myoptionalmodules_ajaxcomments_submit">
						<?php wp_nonce_field( 'myoptionalmodules_ajaxcomments_submit' ); ?>
						<label for="myoptionalmodules_ajaxcomments_submit">
							<?php if( get_option( 'myoptionalmodules_ajaxcomments' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Comment form is utilizing Ajax</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Comment form is behaving normally</span>
							<?php }?>
							Ajaxify
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_ajaxcomments' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_ajaxcomments" />
						<input type="submit" id="myoptionalmodules_ajaxcomments_submit" name="myoptionalmodules_ajaxcomments_submit" value="Submit" class="hidden" />
					</form>
				</div>
			</div>
			<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_toggleextras' ) ) { ?> toggled<?php }?>" id="extras">
				<label for="myoptionalmodules_admin_toggleextras_submit" class="full-title">Extras</label>
				<form class="toggle" method="post" action="#extras" name="toggle_extras_form">
					<?php wp_nonce_field( 'myoptionalmodules_admin_toggleextras_submit' ); ?>
					<label for="myoptionalmodules_admin_toggleextras_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_toggleextras' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_toggleextras" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_toggleextras" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_toggleextras_submit" type="submit" name="myoptionalmodules_admin_toggleextras_submit">
				</form>			
				<div class="right-half">
					<form method="post" action="#extras" name="myoptionalmodules_nelio_submit">
						<?php wp_nonce_field( 'myoptionalmodules_nelio_submit' ); ?>
						<label for="myoptionalmodules_nelio_submit" title="External thumbnails">
						<?php if( get_option( 'myoptionalmodules_nelio' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
							<span>You are able to set external media as thumbnails</span>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
							<span>You are not utilizing external media as thumbnails</span>
						<?php } ?>
						<a href="https://wordpress.org/plugins/external-featured-image/">Nelio Featured Image</a> + oEmbed
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_nelio' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_nelio" />
						<input type="submit" id="myoptionalmodules_nelio_submit" name="myoptionalmodules_nelio_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#extras" name="myoptionalmodules_featureimagewidth_submit">
						<?php wp_nonce_field( 'myoptionalmodules_featureimagewidth_submit' ); ?>
						<label for="myoptionalmodules_featureimagewidth_submit">
							<?php if( get_option( 'myoptionalmodules_featureimagewidth' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Featured Images fill their containers</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Featured Images are sized normally</span>
							<?php }?>
							Force Featured Image Width
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_featureimagewidth' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_featureimagewidth" />
						<input type="submit" id="myoptionalmodules_featureimagewidth_submit" name="myoptionalmodules_featureimagewidth_submit" value="Submit" class="hidden" />
					</form>			
					<form method="post" action="#extras" name="myoptionalmodules_javascripttofooter_submit">
						<?php wp_nonce_field( 'myoptionalmodules_javascripttofooter_submit' ); ?>
						<label for="myoptionalmodules_javascripttofooter_submit">
							<?php if( 1== get_option( 'myoptionalmodules_javascripttofooter' ) ){ ?>
								<i class="fa fa-toggle-on"></i>
								<span>Javascript is being moved to the footer</span>
							<?php }else{ ?>
								<i class="fa fa-toggle-off"></i>
								<span>Javascript is not being moved to the footer</span>
							<?php } ?>
							Javascript to Footer
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_javascripttofooter' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_javascripttofooter" />
						<input type="submit" id="myoptionalmodules_javascripttofooter_submit" name="myoptionalmodules_javascripttofooter_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#extras" name="myoptionalmodules_lazyload_submit">
						<?php wp_nonce_field( 'myoptionalmodules_lazyload_submit' ); ?>
						<label for="myoptionalmodules_lazyload_submit">
							<?php if( get_option( 'myoptionalmodules_lazyload' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Post Images are utilizing Lazy Load</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Post images are not utilizing Lazy Load</span>
							<?php } ?>
							Lazy Loading
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_lazyload' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_lazyload" />
						<input type="submit" id="myoptionalmodules_lazyload_submit" name="myoptionalmodules_lazyload_submit" value="Submit" class="hidden" />
					</form>
					<form method="post" action="#extras" name="myoptionalmodules_exclude_submit">
						<?php wp_nonce_field( 'myoptionalmodules_exclude_submit' ); ?>
						<label for="myoptionalmodules_exclude_submit">
							<?php if( get_option( 'myoptionalmodules_exclude' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>You are excluding posts from targeted locations</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>You are not excluding posts from anywhere</span>
							<?php }?>
							Exclude Posts from Areas of the Blog
						</label>
						<input type="text" class="hidden" value="<?php if( get_option( 'myoptionalmodules_exclude' ) ){ echo 0; } else { echo 1; }?>" name="myoptionalmodules_exclude" />
						<input type="submit" id="myoptionalmodules_exclude_submit" name="myoptionalmodules_exclude_submit" value="Submit" class="hidden" />
					</form>				
					<form method="post" action="#extras" name="myoptionalmodules_recentpostswidget_submit">
						<?php wp_nonce_field( 'myoptionalmodules_recentpostswidget_submit' ); ?>
						<label for="myoptionalmodules_recentpostswidget_submit">
							<?php if( get_option( 'myoptionalmodules_recentpostswidget' ) ) { ?>
								<i class="fa fa-toggle-on"></i>
								<span>Widget excludes currently viewed post from list</span>
							<?php } else { ?>
								<i class="fa fa-toggle-off"></i>
								<span>Widget behavior is normal</span>
							<?php }?>
							Recent Posts Widget
						</label>
						<input class="hidden" type="text" value="<?php if( get_option( 'myoptionalmodules_recentpostswidget' ) ) { echo 0; } else { echo 1; } ?>" name="myoptionalmodules_recentpostswidget" />
						<input type="submit" id="myoptionalmodules_recentpostswidget_submit" name="myoptionalmodules_recentpostswidget_submit" value="Submit" class="hidden" />
					</form>
				</div>
			</div>
			<?php if( get_option( 'myoptionalmodules_exclude' ) ) { 
				$showmepages = get_pages(); 			
				$showmecats  = get_categories( 'taxonomy=category&hide_empty=0' ); 
				$showmetags  = get_categories( 'taxonomy=post_tag&hide_empty=0' );
				$showmeusers = get_users(  );
				$tagcount    = 0;
				$catcount    = 0;
				$usercount   = 0;
			?>
			<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_togglecategories' ) ) { ?> toggled<?php }?>" id="categories">
				<label for="myoptionalmodules_admin_togglecategories_submit" class="full-title">Exclude Taxonomies</label>
				<form class="toggle" method="post" action="#categories" name="myoptionalmodules_admin_togglecategories_submit">
					<?php wp_nonce_field( 'myoptionalmodules_admin_togglecategories_submit' ); ?>
					<label for="myoptionalmodules_admin_togglecategories_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_togglecategories' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_togglecategories" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_togglecategories" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_togglecategories_submit" type="submit" name="myoptionalmodules_admin_togglecategories_submit">
				</form>

				<em class="full">Each field takes a comma-separated list of items for exclusion from the specified
				section of the blog. When filling out each field, <code>this is the value you will use</code>. Names are there for reference.</em>
				
				<em class="full">Exclusions based on user roles (guest, subscriber, contributor, author) will prevent those user roles
				from being able to view the post as a single page (is_single()). The error message will be wrapped in the div <code>.mom-unauthorized-content</code> 
				for CSS-styling purposes.</em>
				
				<?php 
				$myoptionalmodules_exclude_postformatsrss              = get_option( 'myoptionalmodules_exclude_postformatsrss' );
				$myoptionalmodules_exclude_postformatsfront            = get_option( 'myoptionalmodules_exclude_postformatsfront' );
				$myoptionalmodules_exclude_postformatscategoryarchives = get_option( 'myoptionalmodules_exclude_postformatscategoryarchives' );
				$myoptionalmodules_exclude_postformatstagarchives      = get_option( 'myoptionalmodules_exclude_postformatstagarchives' );
				$myoptionalmodules_exclude_postformatssearchresults    = get_option( 'myoptionalmodules_exclude_postformatssearchresults' );
				$myoptionalmodules_exclude_visitorpostformats          = get_option( 'myoptionalmodules_exclude_visitorpostformats' ); ?>
				<form method="post" class="exclude" name="hidecategoriesfrom">
					<?php wp_nonce_field( 'hidecategoriesfrom' ); ?>
					<div class="clear"></div>
					<span class="title-full">Exclude <em>these</em> Author(s) <em>from</em></span>
					<em class="full">
					<?php foreach($showmeusers as $usersshown){ ++$usercount; ?>
						<?php echo $usersshown->user_nicename; ?> <code><?php echo $usersshown->ID; ?></code> &mdash; 
					<?php }?>
					</em>					
					<?php $exclude = array( 
						'myoptionalmodules_exclude_usersrss',
						'myoptionalmodules_exclude_usersfront',
						'myoptionalmodules_exclude_userscategoryarchives',
						'myoptionalmodules_exclude_userstagarchives',
						'myoptionalmodules_exclude_userssearchresults',
						'myoptionalmodules_exclude_usersuserssun',
						'myoptionalmodules_exclude_usersusersmon',
						'myoptionalmodules_exclude_usersuserstue',
						'myoptionalmodules_exclude_usersuserswed',
						'myoptionalmodules_exclude_usersusersthu',
						'myoptionalmodules_exclude_usersusersfri',
						'myoptionalmodules_exclude_usersuserssat',
						'myoptionalmodules_exclude_userslevel10users',
						'myoptionalmodules_exclude_userslevel1users',
						'myoptionalmodules_exclude_userslevel2users',
						'myoptionalmodules_exclude_userslevel7users',
					); ?>
					<?php $section = array( 
						' the <strong>feed</strong>',
						' the <strong>front page</strong>',
						' <strong>category archives</strong>',
						' <strong>tag archives</strong>',
						' any <strong>search results</strong>',
						' any area on <strong>Sunday</strong>',
						' any area on <strong>Monday</strong>',
						' any area on <strong>Tuesday</strong>',
						' any area on <strong>Wednesday</strong>',
						' any area on <strong>Thursday</strong>',
						' any area on <strong>Friday</strong>',
						' any area on <strong>Saturday</strong>',
						' any visitor who is <strong>not logged in</strong>',
						' any visitor who is a <strong>subscriber</strong>',
						' any visitor who is a <strong>contributor</strong>',
						' any visitor who is an <strong>author</strong>'
					); ?>
					<?php 
						if( $usercount > 0 ) {
							foreach($exclude as $exc ) { 
								$title = str_replace($exclude, $section, $exc); ?>
								<section class="small-section">
									<label for="<?php echo $exc;?>"><?php echo $title;?></label>
									<input type="text" id="<?php echo $exc;?>" name="<?php echo $exc;?>" value="<?php echo get_option($exc);?>">
								</section>
							<?php } } else { ?>
								<em class="full">You have no users to exclude.</em>
							<?php }?>						
							<?php $exclude = array( 
								'myoptionalmodules_exclude_categoriesrss',
								'myoptionalmodules_exclude_categoriesfront',
								'myoptionalmodules_exclude_categoriestagarchives',
								'myoptionalmodules_exclude_categoriessearchresults',
								'myoptionalmodules_exclude_categoriescategoriessun',
								'myoptionalmodules_exclude_categoriescategoriesmon',
								'myoptionalmodules_exclude_categoriescategoriestue',
								'myoptionalmodules_exclude_categoriescategorieswed',
								'myoptionalmodules_exclude_categoriescategoriesthu',
								'myoptionalmodules_exclude_categoriescategoriesfri',
								'myoptionalmodules_exclude_categoriescategoriessat',
								'myoptionalmodules_exclude_categories_level0categories',
								'myoptionalmodules_exclude_categorieslevel1categories',
								'myoptionalmodules_exclude_categorieslevel2categories',
								'myoptionalmodules_exclude_categorieslevel7categories',
							); ?>
							<?php $section = array( 
								' the <strong>feed</strong>',
								' the <strong>front page</strong>',
								' <strong>tag archives</strong>',
								' any <strong>search results</strong>',
								' any area on <strong>Sunday</strong>',
								' any area on <strong>Monday</strong>',
								' any area on <strong>Tuesday</strong>',
								' any area on <strong>Wednesday</strong>',
								' any area on <strong>Thursday</strong>',
								' any area on <strong>Friday</strong>',
								' any area on <strong>Saturday</strong>',
								' any visitor who is <strong>not logged in</strong>',
								' any visitor who is a <strong>subscriber</strong>',
								' any visitor who is a <strong>contributor</strong>',
								' any visitor who is an <strong>author</strong>'						
							); ?>
							<div class="clear"></div>
							<span class="title-full">Exclude <em>these</em> Categories <em>from</em></span>
							<em class="full">
								<?php foreach($showmecats as $catsshown){ ++$catcount; ?>
									<?php echo $catsshown->cat_name; ?> <code><?php echo $catsshown->cat_ID; ?></code> &mdash; 
								<?php }?>
							</em>
							<?php 
								if( $catcount > 0 ) {
									foreach($exclude as $exc ) { 
									$title = str_replace($exclude, $section, $exc); ?>
									<section class="small-section">
										<label for="<?php echo $exc;?>"><?php echo $title;?></label>
										<input type="text" id="<?php echo $exc;?>" name="<?php echo $exc;?>" value="<?php echo get_option($exc);?>">
									</section>
								<?php } } else { ?>
									<em class="full">You have no categories to exclude.</em>
								<?php }?>
							<div class="clear"></div>
							<span class="title-full">Exclude <em>these</em> Tag(s) <em>from</em></span>
							<em class="full">
								<?php foreach($showmetags as $tagsshown){ 
									++$tagcount;?>
									<?php echo $tagsshown->cat_name;?> <code><?php echo $tagsshown->cat_ID;?></code> &mdash;
								<?php } ?>
							</em>
							<?php 
								if( $tagcount > 0 ) {
									$exclude = array( 
										'myoptionalmodules_exclude_tagsrss',
										'myoptionalmodules_exclude_tagsfront',
										'myoptionalmodules_exclude_tagscategoryarchives',
										'myoptionalmodules_exclude_tagssearchresults',
										'myoptionalmodules_exclude_tagstagssun',
										'myoptionalmodules_exclude_tagstagsmon',
										'myoptionalmodules_exclude_tagstagstue',
										'myoptionalmodules_exclude_tagstagswed',
										'myoptionalmodules_exclude_tagstagsthu',
										'myoptionalmodules_exclude_tagstagsfri',
										'myoptionalmodules_exclude_tagstagssat',
										'myoptionalmodules_exclude_tagslevel0tags',
										'myoptionalmodules_exclude_tagslevel1tags',
										'myoptionalmodules_exclude_tagslevel2tags',
										'myoptionalmodules_exclude_tagslevel7tags' 
									);
									$section = array( 
										' the <strong>feed</strong>',
										' the <strong>front page</strong>',
										' <strong>category archives</strong>',
										' any <strong>search results</strong>',
										' any area on <strong>Sunday</strong>',
										' any area on <strong>Monday</strong>',
										' any area on <strong>Tuesday</strong>',
										' any area on <strong>Wednesday</strong>',
										' any area on <strong>Thursday</strong>',
										' any area on <strong>Friday</strong>',
										' any area on <strong>Saturday</strong>',
										' any visitor who is <strong>not logged in</strong>',
										' any visitor who is a <strong>subscriber</strong>',
										' any visitor who is a <strong>contributor</strong>',
										' any visitor who is an <strong>author</strong>'
									);
									foreach($exclude as $exc ) {
										$title = str_replace($exclude, $section, $exc); ?>
										<section class="small-section">
											<label for="<?php echo $exc;?>"><?php echo $title;?></label>
											<input type="text" id="<?php echo $exc;?>" name="<?php echo $exc;?>" value="<?php echo get_option($exc);?>">
										</section>
							<?php }
								} else { ?>
									<em class="full">You have no tags to exclude.</em>
								<?php } ?>
				
							<div class="clear"></div>
								<span class="title-full">Exclude <em>these</em> Post Format(s) <em>from</em></span>
								<section>
									<?php echo '
										<select name="myoptionalmodules_exclude_postformatsrss" id="myoptionalmodules_exclude_postformatsrss">
										<option value="">RSS -> none</option>
										<option value="post-format-aside"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-aside' ); echo '>RSS -> Aside</option>
										<option value="post-format-gallery"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-gallery' ); echo '>RSS -> Gallery</option>
										<option value="post-format-link"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-link' ); echo '>RSS -> Link</option>
										<option value="post-format-image"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-image' ); echo '>RSS -> Image</option>
										<option value="post-format-quote"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-quote' ); echo '>RSS -> Quote</option>
										<option value="post-format-status"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-status' ); echo '>RSS -> Status</option>
										<option value="post-format-video"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-video' ); echo '>RSS -> Video</option>
										<option value="post-format-audio"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-audio' ); echo '>RSS -> Audio</option>
										<option value="post-format-chat"'; selected( $myoptionalmodules_exclude_postformatsrss, 'post-format-chat' ); echo '>RSS -> Chat</option>
									</select>
									<select name="myoptionalmodules_exclude_postformatsfront" id="myoptionalmodules_exclude_postformatsfront">
										<option value="">Front Page -> none</option>
										<option value="post-format-aside"'; selected( $myoptionalmodules_exclude_postformatsfront, 'post-format-aside' ); echo '>Front Page -> Aside</option>
										<option value="post-format-gallery"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-gallery' ); echo '>Front Page -> Gallery</option>
										<option value="post-format-link"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-link' ); echo '>Front Page -> Link</option>
										<option value="post-format-image"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-image' ); echo '>Front Page -> Image</option>
										<option value="post-format-quote"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-quote' ); echo '>Front Page -> Quote</option>
										<option value="post-format-status"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-status' ); echo '>Front Page -> Status</option>
										<option value="post-format-video"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-video' ); echo '>Front Page -> Video</option>
										<option value="post-format-audio"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-audio' ); echo '>Front Page -> Audio</option>
										<option value="post-format-chat"'; selected( $myoptionalmodules_exclude_postformatsfront,'post-format-chat' ); echo '>Front Page -> Chat</option>
									</select>
									<select name="myoptionalmodules_exclude_postformatscategoryarchives" id="myoptionalmodules_exclude_postformatscategoryarchives">
										<option value="">Archives -> none</option>
										<option value="post-format-aside"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives, 'post-format-aside' ); echo '>Archives -> Aside</option>
										<option value="post-format-gallery"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-gallery' ); echo '>Archives -> Gallery</option>
										<option value="post-format-link"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-link' ); echo '>Archives -> Link</option>
										<option value="post-format-image"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-image' ); echo '>Archives -> Image</option>
										<option value="post-format-quote"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-quote' ); echo '>Archives -> Quote</option>
										<option value="post-format-status"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-status' ); echo '>Archives -> Status</option>
										<option value="post-format-video"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-video' ); echo '>Archives -> Video</option>
										<option value="post-format-audio"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-audio' ); echo '>Archives -> Audio</option>
										<option value="post-format-chat"'; selected( $myoptionalmodules_exclude_postformatscategoryarchives,'post-format-chat' ); echo '>Archives -> Chat</option>
									</select>
									<select name="myoptionalmodules_exclude_postformatstagarchives" id="myoptionalmodules_exclude_postformatstagarchives">
										<option value="">Tags -> none</option>
										<option value="post-format-aside"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-aside' ); echo '>Tags -> Aside</option>
										<option value="post-format-gallery"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-gallery' ); echo '>Tags -> Gallery</option>
										<option value="post-format-link"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-link' ); echo '>Tags -> Link</option>
										<option value="post-format-image"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-image' ); echo '>Tags -> Image</option>
										<option value="post-format-quote"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-quote' ); echo '>Tags -> Quote</option>
										<option value="post-format-status"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-status' ); echo '>Tags -> Status</option>
										<option value="post-format-video"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-video' ); echo '>Tags -> Video</option>
										<option value="post-format-audio"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-audio' ); echo '>Tags -> Audio</option>
										<option value="post-format-chat"'; selected( $myoptionalmodules_exclude_postformatstagarchives, 'post-format-chat' ); echo '>Tags -> Chat</option>
									</select>
									<select name="myoptionalmodules_exclude_postformatssearchresults" id="myoptionalmodules_exclude_postformatssearchresults">
										<option value="">Search -> none</option>
										<option value="post-format-aside"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-aside' ); echo '>Search -> Aside</option>
										<option value="post-format-gallery"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-gallery' ); echo '>Search -> Gallery</option>
										<option value="post-format-link"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-link' ); echo '>Search -> Link</option>
										<option value="post-format-image"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-image' ); echo '>Search -> Image</option>
										<option value="post-format-quote"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-quote' ); echo '>Search -> Quote</option>
										<option value="post-format-status"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-status' ); echo '>Search -> Status</option>
										<option value="post-format-video"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-video' ); echo '>Search -> Video</option>
										<option value="post-format-audio"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-audio' ); echo '>Search -> Audio</option>
										<option value="post-format-chat"'; selected( $myoptionalmodules_exclude_postformatssearchresults, 'post-format-chat' ); echo '>Search -> Chat</option>
									</select>
									<select name="myoptionalmodules_exclude_visitorpostformats" id="myoptionalmodules_exclude_visitorpostformats">
										<option value="">Logged out -> none</option>
										<option value="post-format-aside"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-aside' ); echo '>Logged out -> Aside</option>
										<option value="post-format-gallery"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-gallery' ); echo '>Logged out -> Gallery</option>
										<option value="post-format-link"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-link' ); echo '>Logged out -> Link</option>
										<option value="post-format-image"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-image' ); echo '>Logged out -> Image</option>
										<option value="post-format-quote"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-quote' ); echo '>Logged out -> Quote</option>
										<option value="post-format-status"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-status' ); echo '>Logged out -> Status</option>
										<option value="post-format-video"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-video' ); echo '>Logged out -> Video</option>
										<option value="post-format-audio"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-audio' ); echo '>Logged out -> Audio</option>
										<option value="post-format-chat"'; selected( $myoptionalmodules_exclude_visitorpostformats, 'post-format-chat' ); echo '>Logged out -> Chat</option>
									</select>
								</section>'; ?>
				<input id="momsesave" type="submit" class="clear" value="Exclude them!" name="momsesave"></form>
				</div>
			<?php }?>
			<div class="settings-section<?php if( get_option( 'myoptionalmodules_admin_togglemisc' ) ) { ?> toggled<?php }?>" id="misc">
				<label for="myoptionalmodules_admin_togglemisc_submit" class="full-title">Misc. Theme Settings</label>
				<form class="toggle" method="post" action="#misc" name="myoptionalmodules_admin_togglemisc_submit">
					<?php wp_nonce_field( 'myoptionalmodules_admin_togglemisc_submit' ); ?>
					<label for="myoptionalmodules_admin_togglemisc_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_togglemisc' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_togglemisc" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_togglemisc" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_togglemisc_submit" type="submit" name="myoptionalmodules_admin_togglemisc_submit">
				</form>			
				<em class="full">Setting keyword to <code>keyword</code> will make <code>yoursite.tld/?keyword</code> load a random post</em>
				<em class="full">Read more can be set to <code>%blank%</code> to make it blank</em>
				<form name="mom_save_form" method="post" action="#misc">
					<?php wp_nonce_field( 'mom_save_form' ); ?>
					<section>
						<select name="myoptionalmodules_frontpage" id="mompaf_0">
							<option value="off"<?php if ( get_option( 'myoptionalmodules_frontpage' ) == 'off' ) { ?> selected="selected"<?php } ?>>Front page is default</option>
							<option value="on"<?php if ( get_option( 'myoptionalmodules_frontpage' ) == 'on' ) { ?> selected="selected"<?php } ?>/>Front Page will be your latest post</option>
								<?php $myoptionalmodules_frontpage = get_option( 'myoptionalmodules_frontpage' );
								selected( get_option( 'myoptionalmodules_frontpage' ), 0 );
								$showmeposts = get_posts(array( 'posts_per_page' => -1) );
								foreach($showmeposts as $postsshown){ ?>
									<option name="myoptionalmodules_frontpage" id="mompaf_'<?php echo $postsshown->ID; ?>" value="<?php echo $postsshown->ID; ?>"
									<?php $postID = $postsshown->ID;
									$selected = selected( $myoptionalmodules_frontpage, $postID); ?>
									>Front page: "<?php echo $postsshown->post_title; ?>"</option>
							<?php } ?>
						</select>
					</section>
					<section>
						<label for="google_tracking_id">Google Tracking ID</label>
						<input type="text" id="google_tracking_id" name="google_tracking_id" value="<?php if( get_option( 'myoptionalmodules_google' ) ) { echo get_option( 'myoptionalmodules_google' ); } ?>" />
					</section>			
					<section>
						<label for="previous_link_class">Previous link class</label>
						<input type="text" id="previous_link_class" name="previous_link_class" value="<?php if( get_option( 'myoptionalmodules_previouslinkclass' ) ) { echo get_option( 'myoptionalmodules_previouslinkclass' ); } ?>" />
					</section>
					<section>
						<label for="next_link_class">Next link class</label>
						<input type="text" id="next_link_class" name="next_link_class" value="<?php if( get_option( 'myoptionalmodules_nextlinkclass' ) ) { echo get_option( 'myoptionalmodules_nextlinkclass' ); } ?>" />
					</section>
					<section>
						<label for="read_more">Read more... value</label>
						<input type="text" id="read_more" name="read_more" value="<?php if( get_option( 'myoptionalmodules_readmore' ) ) { 
							echo get_option( 'myoptionalmodules_readmore' ); 
						} ?>" />
					</section>
					<section>
						<label for="randomget">Set a keyword</label>
						<input type="text" id="randomget" name="randomget" value="<?php if( get_option( 'myoptionalmodules_randompost' ) ) { 
							echo get_option( 'myoptionalmodules_randompost' ); 
						} ?>" />
					</section>
					<br /><br />
					<section>
						<label for="randomsitetitles">
							Random site titles<br />
							Separate each item with <code>::</code>.<br /><code>title 1 :: title 2 :: title 3 :: ...</code><br /><br />
							</label>
						<textarea id="randomsitetitles" name="randomsitetitles"><?php if( get_option( 'myoptionalmodules_randomtitles' ) ) { echo get_option( 'myoptionalmodules_randomtitles' ); } ?></textarea>
					</section>
					<section>
						<label for="randomsitedescriptions">
							Random site description<br />
							Separate each item with <code>::</code>.<br /><code>Description 1 :: Description 2 :: Description 3 :: ...</code><br /><br />
							</label>
						<textarea id="randomsitedescriptions" name="randomsitedescriptions"><?php if( get_option( 'myoptionalmodules_randomdescriptions' ) ) { echo get_option( 'myoptionalmodules_randomdescriptions' ); } ?></textarea>
					</section>				
					<input type="submit" id="mom_save_form" name="mom_save_form_submit" value="Save">
				</form>			
			</div>
			<?php // [mom_attachments] shortcode information block ?>
			<div class="settings-section clear<?php if( get_option( 'myoptionalmodules_admin_toggleshortcodes' ) ) { ?> toggled<?php }?>" id="shortcodes">
					<label for="myoptionalmodules_admin_toggleshortcodes_submit" class="full-title">Shortcodes</label>
					<form class="toggle" method="post" action="#shortcodes" name="myoptionalmodules_admin_toggleshortcodes_submit">
						<?php wp_nonce_field( 'myoptionalmodules_admin_toggleshortcodes_submit' ); ?>
						<label for="myoptionalmodules_admin_toggleshortcodes_submit"">
							<?php if( !get_option( 'myoptionalmodules_admin_toggleshortcodes' ) ) { ?>
								<i class="fa fa-minus-square"></i>
								<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_toggleshortcodes" />
							<?php } else { ?>
								<i class="fa fa-plus-square"></i>
								<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_toggleshortcodes" />
							<?php }?>
						</label>
						<input class="hidden" id="myoptionalmodules_admin_toggleshortcodes_submit" type="submit" name="myoptionalmodules_admin_toggleshortcodes_submit">
					</form>
					<p>
						<span class="title">Media Embeds</span>
						<code>[mom_embed]</code> inserts external media.
					</p>
					<p>
						<em>Defaults</em>: <code>[mom_embed url="" class="" ]</code>
					</p>
					<p>
						<span><code>url</code> URL to media in question<br /></span>
						<span><code>class</code> Optional div to wrap media in<br /></span>
					</p>
					<p>
						Media supported:<br />
						 - Image links<br />
						 - Imgur albums<br />
						 - Youtube/youtu.be (youtube links <strong>with</strong> ?t parameter, as well)<br />
						 - Soundcloud<br />
						 - Vimeo<br />
						 - Gfycat<br />
						 - Funnyordie<br />
						 - Vine<br />
						 - Any already <a href="http://codex.wordpress.org/Embeds">supported</a> oEmbed providers
					</p>
					<hr />
					<p>
						<span class="title">Attachment Loop</span>
						<code>[mom_attachments]</code> inserts a loop of recent images that link to their respective posts.
					</p>
					<p>
						<em>Defaults</em>: <code>[mom_attachments amount="1" class="" ]</code>
					</p>
					<p>
						<span><code>amount</code> How many images to show.<br /></span>
						<span><code>class</code> The .class of the links, for CSS purposes.<br /></span>
					</p>
					<hr />
					<p>
						<span class="title">Miniloops</span>
						<code>[mom_miniloop]</code>  inserts a loop of posts via shortcode.
						<em>Defaults</em>: <code>[mom_miniloop paging="0" show_link="1" month="" day="" year="" meta="series" key="" link_content="" amount="4" style="tiled" offset="0" category="" orderby="post_date" order="DESC" post_status="publish" cache="false"]</code>
						<span><code>paging</code> 1 (on) / 0 (off)<br /></span>
						<code>show_link</code> 1 (on) / 0 (off)<br /></span>
						<span><code>month</code> 1-2 digit date / <code>123</code> for today's date<br /></span>
						<code>day</code> 1-2 digit date / <code>123</code> for today's date<br /></span>
						<code>year</code> 1-4 digit date / <code>123</code> for today's date<br /></span>
						<span><code>meta</code> a meta-key name.<br /></span>
						<span><code>key</code> a meta-key value.<br /></span>
						<span><code>link_content</code> Text of the permalink to the post.<br /></span>
						<span><code>amount</code> How many posts to show in the loop.<br /></span>
						<span><code>style</code> <em>columns, list, slider, tiled</em><br /></span>
						<span><code>offset</code> How many posts to skip ahead in the loop.<br /></span>
						<span><code>category</code> Category ID(s) or names (comma-separated if multiple values).<br /></span>
						<span><code>orderby</code> Order posts in the loop by a <a href="//codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">particular value</a>.<br /></span>
						<span><code>order</code> <em>ASC</em> (ascending) or <em>DESC</em> (descending)<br /></span>
						<span><code>post_status</code> Display posts based on their <a href="//codex.wordpress.org/Class_Reference/WP_Query#Status_Parameters">status</a>.<br /></span>
						<span><code>cache</code> Cache the results of this loop. <em>true</em> or <em>false</em>.<br /></span>
					</p>
			</div>
			<?php // Theme functions ?>
			<div class="settings-section clear<?php if( get_option( 'myoptionalmodules_admin_toggledevelopers' ) ) { ?> toggled<?php }?>" id="developers">
				<label for="myoptionalmodules_admin_toggledevelopers_submit" class="full-title">Developers</label>
				<form class="toggle" method="post" action="#developers" name="myoptionalmodules_admin_toggledevelopers_submit">
					<?php wp_nonce_field( 'myoptionalmodules_admin_toggledevelopers_submit' ); ?>
					<label for="myoptionalmodules_admin_toggledevelopers_submit"">
						<?php if( !get_option( 'myoptionalmodules_admin_toggledevelopers' ) ) { ?>
							<i class="fa fa-minus-square"></i>
							<input type="text" class="hidden" value="1" name="myoptionalmodules_admin_toggledevelopers" />
						<?php } else { ?>
							<i class="fa fa-plus-square"></i>
							<input type="text" class="hidden" value="0" name="myoptionalmodules_admin_toggledevelopers" />
						<?php }?>
					</label>
					<input class="hidden" id="myoptionalmodules_admin_toggledevelopers_submit" type="submit" name="myoptionalmodules_admin_toggledevelopers_submit">
				</form>
				<p><strong>Theme Developers</strong> may use the following functions in your themes for additional functionality.</p>
				<p><span><code>my_optional_modules_exclude_categories()</code> for a category list that hides categories based on your <strong>Exclude Taxonomies: Exclude Categories</strong> settings.<br /></span></p>
				<p><span><code>new mom_mediaEmbed( 'MEDIA URL' )</code> for media embeds with <a href="http://codex.wordpress.org/Embeds">oEmbed</a> fallback (supports imgur image links AND albums, youtube/youtu.be (with ?t parameter), soundcloud, vimeo, gfycat, funnyordie, and vine).</p>
			</div>
		<?php } else { ?>
			<div class="settings-section">
				<span class="full-title">Warning</span>
				<em class="full">You're either running this plugin for the first time, recently uninstalled it, 
				or are upgrading from a previous version.</em>
				<em class="full">If upgrading or installing for the first time, please click <strong>Database Upgrade</strong> to initialize the plugin. 
				If uninstalling, you may deactivate and remove this plugin.</em>
			</div>
		<?php }?>
	</div>
<?php 
/** End options page */
}