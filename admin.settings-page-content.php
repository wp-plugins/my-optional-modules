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
?>
<div class="MOMSettings">
	<div class="settings-section" id="name">
		<span class="full-title">My Optional Modules</span>
		<div class="left-half">
			<em>Don't forget to <a href="//wordpress.org/support/view/plugin-reviews/my-optional-modules">rate and review</a> 
			this plugin if you found it helpful. Need help? Post your question on the 
			<a href="//wordpress.org/support/plugin/my-optional-modules">support</a> forum.</em>
			<br /><br />
			Enable/Disable the inclusion of plugin CSS (you'll need to style <strong>everything</strong> on your own 
			if you choose to disable its inclusion.
			
		</div>
		<div class="right-half">
			<form method="post" action="#name" name="pluginCSS">
				<?php wp_nonce_field( 'pluginCSS' ); ?>
				<label for="mom_plugin_css_mode_submit">
				<?php if( 1 == get_option( 'mommaincontrol_enablecss' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?>
				<span>Disable Plugin CSS</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_enablecss' ) ){ echo 0; } else { echo 1; }?>" name="pluginCSS" />
				<input type="submit" id="mom_plugin_css_mode_submit" name="mom_plugin_css_mode_submit" value="Submit" class="hidden" />
			</form>			
			<?php if( !isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
				<form method="post" action="#name" name="mom_delete_step_one">
				<?php wp_nonce_field( 'mom_delete_step_one' ); ?>
				<label for="mom_delete_step_one">
					<i class="fa fa-exclamation"></i>
					<span>Uninstall (1/2)</span>
				</label>
				<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hidden" value="Submit" />
				</form>
			<?php } ?>
			<?php if( isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
				<form method="post" action="#name" name="MOM_UNINSTALL_EVERYTHING">
				<?php wp_nonce_field( 'MOM_UNINSTALL_EVERYTHING' ); ?>
				<label for="MOM_UNINSTALL_EVERYTHING">
					<i class="fa fa-exclamation-triangle"></i>
					<span>Uninstall (2/2)</span>
				</label>
				<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hidden" value="Submit" />
				</form>
			<?php } ?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" class="donate">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHRwYJKoZIhvcNAQcEoIIHODCCBzQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYADDhH+NF6voC2cNiYO4gdaeGNYDQMpCUVkDj0KBxsEilu2CwvoI7aG5A/pQt7+JjwpT59MKWq28QoCygiRJcv/JIDK/TqcmEhnhxXlkIT3nnA4sjKc2sBNe1UVvMHPJ0OumAMPNBk8l1AAYEDj+/WvqG3M96sgsbAOxx4K7vZUUjELMAkGBSsOAwIaBQAwgcQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIpjNYfrXnbimAgaC5V4NYH4cqTrdEuNPVUJkmyLIUMl1LzAh5TvYU/Ncys+MQARrXntTer/nIN3PCuGYQNws/Eih1cV4QNJ8OZ5d9MzBy6NF7RAzPRzOGeca0G25O/V+47GDbuG0J9XK4QicsZZnnNs/dRX1Gwt6FBuppQeNCltFYMmIYo7L1BqL1A/dd/Vy5yUP5Wx9RjPE4LMKgRBFuhOH1EGi2cPRozqXWoIIDhzCCA4MwggLsoAMCAQICAQAwDQYJKoZIhvcNAQEFBQAwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMB4XDTA0MDIxMzEwMTMxNVoXDTM1MDIxMzEwMTMxNVowgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBR07d/ETMS1ycjtkpkvjXZe9k+6CieLuLsPumsJ7QC1odNz3sJiCbs2wC0nLE0uLGaEtXynIgRqIddYCHx88pb5HTXv4SZeuv0Rqq4+axW9PLAAATU8w04qqjaSXgbGLP3NmohqM6bV9kZZwZLR/klDaQGo1u9uDb9lr4Yn+rBQIDAQABo4HuMIHrMB0GA1UdDgQWBBSWn3y7xm8XvVk/UtcKG+wQ1mSUazCBuwYDVR0jBIGzMIGwgBSWn3y7xm8XvVk/UtcKG+wQ1mSUa6GBlKSBkTCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb22CAQAwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQUFAAOBgQCBXzpWmoBa5e9fo6ujionW1hUhPkOBakTr3YCDjbYfvJEiv/2P+IobhOGJr85+XHhN0v4gUkEDI8r2/rNk1m0GA8HKddvTjyGw/XqXa+LSTlDYkqI8OwR8GEYj4efEtcRpRYBxV8KxAW93YDWzFGvruKnnLbDAF6VR5w/cCMn5hzGCAZowggGWAgEBMIGUMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbQIBADAJBgUrDgMCGgUAoF0wGAYJKoZIhvcNAQkDMQsGCSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMTUwMjA1MTcwMzQxWjAjBgkqhkiG9w0BCQQxFgQU2SdHfNR8UlZzVqgN/DdfdNEJ0lIwDQYJKoZIhvcNAQEBBQAEgYB+L5BCnvgRlZwIshKEip9Gr5W+Lct6qS2zVH9BYFTI0n9Aawr7Co0B0kbdSpHEqWT4m71roz4Wo9D5oX82hfeECVnzxB9yLhF3ivOlSOP/Dsmb0VE/UWdEJdFSZp9JNIcIp1mThvBMix88QUI0/QL2KcPrhDCfzWQ1ecetRjEDcA==-----END PKCS7-----
			">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
	</div>
	<?php global $table_prefix, $wpdb;
	if( isset( $_POST[ 'delete_drafts' ] ) || isset( $_POST[ 'delete_unused_terms' ] ) || isset( $_POST[ 'delete_post_revisions' ] ) || isset( $_POST[ 'delete_unapproved_comments' ] ) || isset( $_POST[ 'deleteAllClutter' ] ) ) {
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
	<div class="settings-section<?php if( 1 == get_option( 'toggle_trash' ) ) { ?> toggled<?php }?>" id="trash-removal">
		<label class="full-title" for="toggle_trash_submit">Trash Removal</label>
		<form class="toggle" method="post" action="#trash-removal" name="toggle_trash_form">
			<?php wp_nonce_field( 'toggle_trash_form' ); ?>
			<label for="toggle_trash_submit"">
				<?php if( 0 == get_option( 'toggle_trash' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_trash" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_trash" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_trash_submit" type="submit" name="toggle_trash_submit">
		</form>
		<div class="left-half">
			<em>Removes clutter from the database.</em>
		</div>
		<div class="right-half">
			<form method="post" action="#trash-removal" name="deleteAllClutterForm">
				<?php wp_nonce_field( 'deleteAllClutterForm' ); ?>
				<label for="deleteAllClutter" title="<?php echo esc_attr( $totalClutter );?>">
					<i class="fa fa-trash-o"></i>
					<span>All</span>
				</label>
				<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
			</form>
			<form method="post" action="#trash-removal" name="deletePostRevisionsForm">
				<?php wp_nonce_field( 'deletePostRevisionsForm' ); ?>
				<label for="delete_post_revisions" title="<?php echo esc_attr( $revisions_count ); ?>">
					<i class="fa fa-trash-o"></i>
					<span>Posts</span>
				</label>
				<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
			</form>
			<form method="post" action="#trash-removal" name="deleteUnapprovedCommentsForm">
				<?php wp_nonce_field( 'deleteUnapprovedCommentsForm' ); ?>
				<label for="delete_unapproved_comments" title="<?php echo esc_attr( $comments_count ); ?>">
					<i class="fa fa-trash-o"></i>
					<span>Comments</span>
				</label>
				<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
			</form>
			<form method="post" action="#trash-removal" name="deleteUnusedTermsForm">
				<?php wp_nonce_field( 'deleteUnusedTermsForm' ); ?>
				<label for="delete_unused_terms" title="<?php echo esc_attr( $terms_count ); ?>">
					<i class="fa fa-trash-o"></i>
					<span>Taxes</span>
				</label>
				<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
			</form>
			<form method="post" action="#trash-removal" name="deleteDraftsForm">
				<?php wp_nonce_field( 'deleteDraftsForm' ); ?>
				<label for="delete_drafts" title="<?php echo esc_attr( $drafts_count ); ?>">
					<i class="fa fa-trash-o"></i>
					<span>Drafts</span>
				</label>
				<input class="hidden" id="delete_drafts" type="submit" value="Go" name="delete_drafts">
			</form>
		</div>
	<?php if( count( $drafts_total ) || count( $revisions_total ) || count( $comments_total ) || count( $terms_total ) ) { ?>
		<div class="clear">
				<em>Here's what you'll be deleting:</em> 
				<?php if( count( $drafts_total ) ) {
						echo '<code>' . $drafts_count . ' drafts</code>';
				}
				if( count( $revisions_total ) ) { 
						echo '<code>' . $revisions_count . ' revisions</code>'; 
				}
				if( count( $comments_total ) ) {
						echo '<code>' . $comments_count . ' unapproved comments</code>'; 
				}
				if( count( $terms_total ) ) {
						echo '<code>' . $terms_count . ' unused taxonomies</code>'; 
				} ?>
		</div>
	<?php }?>
	</div>
	<div class="settings-section<?php if( 1 == get_option( 'toggle_disable' ) ) { ?> toggled<?php }?>" id="disable">
		<label for="toggle_disable_submit" class="full-title">Disable components</label>
		<form class="toggle" method="post" action="#disable" name="toggle_disable_form">
			<?php wp_nonce_field( 'toggle_disable_form' ); ?>
			<label for="toggle_disable_submit"">
				<?php if( 0 == get_option( 'toggle_disable' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_disable" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_disable" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_disable_submit" type="submit" name="toggle_disable_submit">
		</form>
		<div class="left-half">
			<em>Completely disable comments, version number, pingbacks, author archives if there is only one author, or date archives.</em>
		</div>
		<div class="right-half">
			<form method="post" action="#disable" name="momComments">
				<?php wp_nonce_field( 'momComments' ); ?>
				<label for="mom_comments_mode_submit">
				<?php if( 1 == get_option( 'mommaincontrol_comments' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?>
				<span>Comments</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_comments' ) ){ echo 0; } else { echo 1; }?>" name="comments" />
				<input type="submit" id="mom_comments_mode_submit" name="mom_comments_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#disable" name="hidewpversions">
				<?php wp_nonce_field( 'hidewpversions' ); ?>
				<label for="mom_versions_submit">
				<?php if( 1 == get_option( 'mommaincontrol_versionnumbers' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?>
				<span>Version</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_versionnumbers' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_versionnumbers" />
				<input type="submit" id="mom_versions_submit" name="mom_versions_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#disable" name="disablepingbacks">
				<?php wp_nonce_field( 'disablepingbacks' ); ?>
				<label for="mom_disablepingbacks_submit">
				<?php if( 1 == get_option( 'mommaincontrol_disablepingbacks' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php }?>
				<span>Pingbacks</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_disablepingbacks' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_disablepingbacks" />
				<input type="submit" id="mom_disablepingbacks_submit" name="mom_disablepingbacks_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#disable" name="authorarchives">
				<?php wp_nonce_field( 'authorarchives' ); ?>
				<label for="mom_author_archives_mode_submit" title="Author-based archives">
				<?php if( 1 == get_option( 'mommaincontrol_authorarchives' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php } ?>
				<span>Author</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_authorarchives' ) ) { echo 0; } else { echo 1; } ?>" name="authorarchives" />
				<input type="submit" id="mom_author_archives_mode_submit" name="mom_author_archives_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#disable" name="datearchives">
				<?php wp_nonce_field( 'datearchives' ); ?>
				<label for="mom_date_archives_mode_submit" title="Dated-based archives">
				<?php if( 1 == get_option( 'mommaincontrol_datearchives' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php } ?>
				<span>Dates</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_datearchives' ) ) { echo 0; } else { echo 1; } ?>" name="datearchives" />
				<input type="submit" id="mom_date_archives_mode_submit" name="mom_date_archives_mode_submit" value="Submit" class="hidden" />
			</form>
		
		</div>
	</div>
	<div class="settings-section<?php if( 1 == get_option( 'toggle_enable' ) ) { ?> toggled<?php }?>" id="enable">
		<label for="toggle_enable_submit" class="full-title">Enable components</label>
		<form class="toggle" method="post" action="#enable" name="toggle_enable_form">
			<?php wp_nonce_field( 'toggle_enable_form' ); ?>
			<label for="toggle_enable_submit"">
				<?php if( 0 == get_option( 'toggle_enable' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_enable" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_enable" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_enable_submit" type="submit" name="toggle_enable_submit">
		</form>			
		<div class="left-half">
			<em>Horizontal galleries, Font Awesome, Share Icons, link backs on every RSS item, or redirect all 
			404s to the homepage.</em>
		</div>
		<div class="right-half">
			<form method="post" action="#enable" name="momHorizontalGalleries">
				<?php wp_nonce_field( 'momHorizontalGalleries' ); ?>
				<label for="mom_horizontal_galleries_mode_submit">
					<?php if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>Galleries</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ){ echo 0; } else { echo 1; }?>" name="hgalleries" />
				<input type="submit" id="mom_horizontal_galleries_mode_submit" name="mom_horizontal_galleries_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#enable" name="fontawesome">
				<?php wp_nonce_field( 'fontawesome' ); ?>
					<label id="font_awesome" for="mom_fontawesome_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?>
					<span>FA</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_fontawesome" />
				<input type="submit" id="mom_fontawesome_mode_submit" name="mom_fontawesome_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#enable" name="momShare">
				<?php wp_nonce_field( 'momShare' ); ?>
				<label for="mom_share_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_momshare' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>Share</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_momshare' ) ){ echo 0; } else { echo 1; }?>" name="share" />
				<input type="submit" id="mom_share_mode_submit" name="mom_share_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#enable" name="protectrss">
				<?php wp_nonce_field( 'protectrss' ); ?>
				<label for="mom_protectrss_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_protectrss' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>RSS Link</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_protectrss' ) ) { echo 0; } else { echo 1; } ?>" name="protectrss" />
				<input type="submit" id="mom_protectrss_mode_submit" name="mom_protectrss_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#enable" name="404">
				<?php wp_nonce_field( '404' ); ?>
				<label for="mom_404_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_404' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>404</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_404' ) ) { echo 0; } else { echo 1; } ?>" name="404" />
				<input type="submit" id="mom_404_mode_submit" name="mom_404_mode_submit" value="Submit" class="hidden" />
			</form>				
		</div>
	</div>
	<?php if( 1 == get_option( 'mommaincontrol_momshare' ) ) { ?>
		<div class="settings-section<?php if( 1 == get_option( 'toggle_share' ) ) { ?> toggled<?php }?>" id="shareicons">
			<label for="toggle_share_submit" class="full-title">Share Icons</label>
			<form class="toggle" method="post" action="#shareicons" name="toggle_share_form">
				<?php wp_nonce_field( 'toggle_share_form' ); ?>
				<label for="toggle_share_submit"">
					<?php if( 0 == get_option( 'toggle_share' ) ) { ?>
						<i class="fa fa-minus-square"></i>
						<input type="text" class="hidden" value="1" name="toggle_share" />
					<?php } else { ?>
						<i class="fa fa-plus-square"></i>
						<input type="text" class="hidden" value="0" name="toggle_share" />
					<?php }?>
				</label>
				<input class="hidden" id="toggle_share_submit" type="submit" name="toggle_share_submit">
			</form>				
			<div class="left-half">
				<em>Enable/disable different services. Determine whether or not these share links 
				will appear at the top of the post content or not. Toggle share icons/links for 
				pages as well.</em>
			</div>
			<div class="right-half">
				<form method="post" action="#shareicons" name="momShareReddit">
					<?php wp_nonce_field( 'momShareReddit' ); ?>
					<label for="MOM_enable_share_reddit">
						<?php if( 1 == get_option( 'MOM_enable_share_reddit' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
						<?php }?>
						<span>
							<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
								<i class="fa fa-reddit"></i>
							<?php } else { ?>
								reddit
							<?php }?>
						</span>
					</label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_enable_share_reddit' ) ){ echo 0; } else { echo 1; }?>" name="reddit" />
					<input type="submit" id="MOM_enable_share_reddit" name="MOM_enable_share_reddit" value="Submit" class="hidden" />
				</form>
				<form method="post" action="#shareicons" name="momShareGoogle">
					<?php wp_nonce_field( 'momShareGoogle' ); ?>
					<label for="MOM_enable_share_google">
						<?php if( 1 == get_option( 'MOM_enable_share_google' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
						<?php }?>
						<span>
							<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
								<i class="fa fa-google-plus"></i>
							<?php }else { ?>
								google+
							<?php }?>
						</span>
					</label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_enable_share_google' ) ){ echo 0; } else { echo 1; }?>" name="google" />
					<input type="submit" id="MOM_enable_share_google" name="MOM_enable_share_google" value="Submit" class="hidden" />
				</form>
				<form method="post" action="#shareicons" name="momShareTwitter">
					<?php wp_nonce_field( 'momShareTwitter' ); ?>
					<label for="MOM_enable_share_twitter">
						<?php if( 1 == get_option( 'MOM_enable_share_twitter' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
						<?php }?>
						<span>
							<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
								<i class="fa fa-twitter"></i>
							<?php }else {?>
								twitter
							<?php }?>
						</span>
					</label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_enable_share_twitter' ) ){ echo 0; } else { echo 1; }?>" name="twitter" />
					<input type="submit" id="MOM_enable_share_twitter" name="MOM_enable_share_twitter" value="Submit" class="hidden" />
				</form>
				<form method="post" action="#shareicons" name="momShareFacebook">
					<?php wp_nonce_field( 'momShareFacebook' ); ?>
					<label for="MOM_enable_share_facebook">
						<?php if( 1 == get_option( 'MOM_enable_share_facebook' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
						<?php }?>
						<span>
							<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
								<i class="fa fa-facebook"></i>
							<?php }else{ ?>
								facebook
							<?php }?>
						</span>
					</label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_enable_share_facebook' ) ){ echo 0; } else { echo 1; }?>" name="facebook" />
					<input type="submit" id="MOM_enable_share_facebook" name="MOM_enable_share_facebook" value="Submit" class="hidden" />
				</form>
				<form method="post" action="#shareicons" name="momShareEmail">
					<?php wp_nonce_field( 'momShareEmail' ); ?>
					<label for="MOM_enable_share_email">
						<?php if( 1 == get_option( 'MOM_enable_share_email' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
						<?php }?>
						<span>
							<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
								<i class="fa fa-envelope"></i>
							<?php }else{ ?>
								email
							<?php }?>
						</span>
					</label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_enable_share_email' ) ){ echo 0; } else { echo 1; }?>" name="email" />
					<input type="submit" id="MOM_enable_share_email" name="MOM_enable_share_email" value="Submit" class="hidden" />
				</form>
				<form method="post" action="#shareicons" name="momShareTop">
					<?php wp_nonce_field( 'momShareTop' ); ?>
					<label for="MOM_enable_share_top">
						<?php if( 1 == get_option( 'MOM_enable_share_top' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
						<?php }?>
						<span>At top</span>
					</label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_enable_share_top' ) ){ echo 0; } else { echo 1; }?>" name="top" />
					<input type="submit" id="MOM_enable_share_top" name="MOM_enable_share_top" value="Submit" class="hidden" />
				</form>
				<form method="post" action="#shareicons" name="momSharePages">
					<?php wp_nonce_field( 'momSharePages' ); ?>
					<label for="MOM_enable_share_pages">
						<?php if( 1 == get_option( 'MOM_enable_share_pages' ) ) { ?>
							<i class="fa fa-toggle-on"></i>
						<?php } else { ?>
							<i class="fa fa-toggle-off"></i>
						<?php }?>
						<span>On Pages</span>
					</label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_enable_share_pages' ) ){ echo 0; } else { echo 1; }?>" name="pages" />
					<input type="submit" id="MOM_enable_share_pages" name="MOM_enable_share_pages" value="Submit" class="hidden" />
				</form>
			</div>
		</div>
	<?php }?>		
	<div class="settings-section<?php if( 1 == get_option( 'toggle_comment' ) ) { ?> toggled<?php }?>" id="comment-modules">
		<label for="toggle_comment_submit" class="full-title">Comment Form Extras</label>
		<form class="toggle" method="post" action="#comment-modules" name="toggle_comment_form">
			<?php wp_nonce_field( 'toggle_comment_form' ); ?>
			<label for="toggle_comment_submit"">
				<?php if( 0 == get_option( 'toggle_comment' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_comment" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_comment" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_comment_submit" type="submit" name="toggle_comment_submit">
		</form>			
		<div class="left-half">
			<em>Block the form from bad IPs, Ajaxify it, or add an extra (hidden) field, 
			for users who are not logged in, that will 
			reject the comment if filled out (most likely by a bot).</em>
		</div>
		<div class="right-half">
			<form method="post" action="#comment-modules" name="momDNSBL">
				<?php wp_nonce_field( 'momDNSBL' ); ?>
				<label for="mom_dnsbl_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_dnsbl' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>DNSBL</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_dnsbl' ) ){ echo 0; } else { echo 1; }?>" name="dnsbl" />
				<input type="submit" id="mom_dnsbl_mode_submit" name="mom_dnsbl_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#comment-modules" name="momHiddenField">
				<?php wp_nonce_field( 'momHiddenField' ); ?>
				<label for="mom_hidden_field_mode_submit">
					<?php if( 1 == get_option( 'MOM_themetakeover_hidden_field' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>Extra Field</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_themetakeover_hidden_field' ) ){ echo 0; } else { echo 1; }?>" name="hidden" />
				<input type="submit" id="mom_hidden_field_mode_submit" name="mom_hidden_field_mode_submit" value="Submit" class="hidden" />
			</form>				
			<form method="post" action="#comment-modules" name="momAjaxComments">
				<?php wp_nonce_field( 'momAjaxComments' ); ?>
				<label for="mom_ajax_comments_mode_submit">
					<?php if( 1 == get_option( 'MOM_themetakeover_ajaxcomments' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>Ajax</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_themetakeover_ajaxcomments' ) ){ echo 0; } else { echo 1; }?>" name="ajaxify" />
				<input type="submit" id="mom_ajax_comments_mode_submit" name="mom_ajax_comments_mode_submit" value="Submit" class="hidden" />
			</form>
		</div>
	</div>
	<div class="settings-section<?php if( 1 == get_option( 'toggle_extras' ) ) { ?> toggled<?php }?>" id="extras">
		<label for="toggle_extras_submit" class="full-title">Extras</label>
		<form class="toggle" method="post" action="#extras" name="toggle_extras_form">
			<?php wp_nonce_field( 'toggle_extras_form' ); ?>
			<label for="toggle_extras_submit"">
				<?php if( 0 == get_option( 'toggle_extras' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_extras" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_extras" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_extras_submit" type="submit" name="toggle_extras_submit">
		</form>			
		<div class="left-half">
			<em>Enable the use of external media (utilizing mom_mediaEmbed) for post feature images (albums, images, and videos, with oEmbed fallback) (an alternate implentation of <a href="//wordpress.org/plugins/external-featured-image/">Nelio External Featured Image</a>)</em>
			<em>Force default post thumbnails to 100% of their container, move Javascript to footer, lazy load all post images, or the Post Exclusion module.</em>
			<em>Change the behaviour of the default Recent Posts widget to exclude the currently viewed post from the list.</em>

		</div>
		<div class="right-half">
			<form method="post" action="#extras" name="externalthumbs">
				<?php wp_nonce_field( 'externalthumbs' ); ?>
				<label for="mom_external_thumbs_mode_submit" title="External thumbnails">
				<?php if( 1 == get_option( 'mommaincontrol_externalthumbs' ) ) { ?>
					<i class="fa fa-toggle-on"></i>
				<?php } else { ?>
					<i class="fa fa-toggle-off"></i>
				<?php } ?>
				<span>External Thumbnails</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_externalthumbs' ) ) { echo 0; } else { echo 1; } ?>" name="externalthumbs" />
				<input type="submit" id="mom_external_thumbs_mode_submit" name="mom_external_thumbs_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#extras" name="thumbnail">
				<?php wp_nonce_field( 'thumbnail' ); ?>
				<label for="mom_thumbnail_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_thumbnail' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>Thumbnails</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_thumbnail' ) ) { echo 0; } else { echo 1; } ?>" name="thumbnail" />
				<input type="submit" id="mom_thumbnail_mode_submit" name="mom_thumbnail_mode_submit" value="Submit" class="hidden" />
			</form>			
			<form method="post" action="#extras" name="footerscripts">
				<?php wp_nonce_field( 'footerscripts' ); ?>
				<label for="mom_footerscripts_mode_submit">
					<?php if( 1== get_option( 'mommaincontrol_footerscripts' ) ){ ?>
						<i class="fa fa-toggle-on"></i>
					<?php }else{ ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?>
					<span>Javascript</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_footerscripts' ) ) { echo 0; } else { echo 1; } ?>" name="footerscripts" />
				<input type="submit" id="mom_footerscripts_mode_submit" name="mom_footerscripts_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#extras" name="lazyload">
				<?php wp_nonce_field( 'lazyload' ); ?>
				<label for="mom_lazy_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_lazyload' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php } ?>
					<span>Lazy</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_lazyload' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_lazyload" />
				<input type="submit" id="mom_lazy_mode_submit" name="mom_lazy_mode_submit" value="Submit" class="hidden" />
			</form>
			<form method="post" action="#extras" name="momExclude">
				<?php wp_nonce_field( 'momExclude' ); ?>
				<label for="mom_exclude_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_momse' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>Exclusion</span>
				</label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_momse' ) ){ echo 0; } else { echo 1; }?>" name="exclude" />
				<input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" />
			</form>				
			<div class="clear"></div>
			<form method="post" action="#extras" name="recentposts">
				<?php wp_nonce_field( 'recentposts' ); ?>
				<label for="mom_recent_posts_mode_submit">
					<?php if( 1 == get_option( 'mommaincontrol_recent_posts' ) ) { ?>
						<i class="fa fa-toggle-on"></i>
					<?php } else { ?>
						<i class="fa fa-toggle-off"></i>
					<?php }?>
					<span>Recent Posts Widget</span>
				</label>
				<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_recent_posts' ) ) { echo 0; } else { echo 1; } ?>" name="recentposts" />
				<input type="submit" id="mom_recent_posts_mode_submit" name="mom_recent_posts_mode_submit" value="Submit" class="hidden" />
			</form>
		</div>
	</div>
	<?php if( 1 == get_option( 'mommaincontrol_momse' ) ) { 
		$showmepages = get_pages(); 			
		$showmecats  = get_categories( 'taxonomy=category&hide_empty=0' ); 
		$showmetags  = get_categories( 'taxonomy=post_tag&hide_empty=0' );
		$showmeusers = get_users(  );
		$tagcount    = 0;
		$catcount    = 0;
		$usercount   = 0;
	?>
	<div class="settings-section<?php if( 1 == get_option( 'toggle_categories' ) ) { ?> toggled<?php }?>" id="categories">
		<label for="toggle_categories_submit" class="full-title">Exclude Taxonomies</label>
		<form class="toggle" method="post" action="#categories" name="toggle_categories_form">
			<?php wp_nonce_field( 'toggle_categories_form' ); ?>
			<label for="toggle_categories_submit"">
				<?php if( 0 == get_option( 'toggle_categories' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_categories" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_categories" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_categories_submit" type="submit" name="toggle_categories_submit">
		</form>

		<em class="full">Each field takes a comma-separated list of items for exclusion from the specified
		section of the blog. When filling out each field, <code>this is the value you will use</code>. Names are there for reference.</em>
		<?php 
		$MOM_Exclude_PostFormats_RSS              = get_option( 'MOM_Exclude_PostFormats_RSS' );
		$MOM_Exclude_PostFormats_Front            = get_option( 'MOM_Exclude_PostFormats_Front' );
		$MOM_Exclude_PostFormats_CategoryArchives = get_option( 'MOM_Exclude_PostFormats_CategoryArchives' );
		$MOM_Exclude_PostFormats_TagArchives      = get_option( 'MOM_Exclude_PostFormats_TagArchives' );
		$MOM_Exclude_PostFormats_SearchResults    = get_option( 'MOM_Exclude_PostFormats_SearchResults' );
		$MOM_Exclude_PostFormats_Visitor          = get_option( 'MOM_Exclude_PostFormats_Visitor' ); ?>
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
				'MOM_Exclude_Users_RSS',
				'MOM_Exclude_Users_Front',
				'MOM_Exclude_Users_CategoryArchives',
				'MOM_Exclude_Users_TagArchives',
				'MOM_Exclude_Users_SearchResults',
				'MOM_Exclude_Users_UsersSun',
				'MOM_Exclude_Users_UsersMon',
				'MOM_Exclude_Users_UsersTue',
				'MOM_Exclude_Users_UsersWed',
				'MOM_Exclude_Users_UsersThu',
				'MOM_Exclude_Users_UsersFri',
				'MOM_Exclude_Users_UsersSat',
				'MOM_Exclude_Users_level0Users',
				'MOM_Exclude_Users_level1Users',
				'MOM_Exclude_Users_level2Users',
				'MOM_Exclude_Users_level7Users',
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
						'MOM_Exclude_Categories_RSS',
						'MOM_Exclude_Categories_Front',
						'MOM_Exclude_Categories_TagArchives',
						'MOM_Exclude_Categories_SearchResults',
						'MOM_Exclude_Categories_CategoriesSun',
						'MOM_Exclude_Categories_CategoriesMon',
						'MOM_Exclude_Categories_CategoriesTue',
						'MOM_Exclude_Categories_CategoriesWed',
						'MOM_Exclude_Categories_CategoriesThu',
						'MOM_Exclude_Categories_CategoriesFri',
						'MOM_Exclude_Categories_CategoriesSat',
						'MOM_Exclude_Categories_level0Categories',
						'MOM_Exclude_Categories_level1Categories',
						'MOM_Exclude_Categories_level2Categories',
						'MOM_Exclude_Categories_level7Categories',
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
								'MOM_Exclude_Tags_RSS',
								'MOM_Exclude_Tags_Front',
								'MOM_Exclude_Tags_CategoryArchives',
								'MOM_Exclude_Tags_SearchResults',
								'MOM_Exclude_Tags_TagsSun',
								'MOM_Exclude_Tags_TagsMon',
								'MOM_Exclude_Tags_TagsTue',
								'MOM_Exclude_Tags_TagsWed',
								'MOM_Exclude_Tags_TagsThu',
								'MOM_Exclude_Tags_TagsFri',
								'MOM_Exclude_Tags_TagsSat',
								'MOM_Exclude_Tags_level0Tags',
								'MOM_Exclude_Tags_level1Tags',
								'MOM_Exclude_Tags_level2Tags',
								'MOM_Exclude_Tags_level7Tags' 
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
								<select name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
								<option value="">RSS -> none</option>
								<option value="post-format-aside"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-aside' ); echo '>RSS -> Aside</option>
								<option value="post-format-gallery"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-gallery' ); echo '>RSS -> Gallery</option>
								<option value="post-format-link"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-link' ); echo '>RSS -> Link</option>
								<option value="post-format-image"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-image' ); echo '>RSS -> Image</option>
								<option value="post-format-quote"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-quote' ); echo '>RSS -> Quote</option>
								<option value="post-format-status"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-status' ); echo '>RSS -> Status</option>
								<option value="post-format-video"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-video' ); echo '>RSS -> Video</option>
								<option value="post-format-audio"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-audio' ); echo '>RSS -> Audio</option>
								<option value="post-format-chat"'; selected( $MOM_Exclude_PostFormats_RSS, 'post-format-chat' ); echo '>RSS -> Chat</option>
							</select>
							<select name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
								<option value="">Front Page -> none</option>
								<option value="post-format-aside"'; selected( $MOM_Exclude_PostFormats_Front, 'post-format-aside' ); echo '>Front Page -> Aside</option>
								<option value="post-format-gallery"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-gallery' ); echo '>Front Page -> Gallery</option>
								<option value="post-format-link"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-link' ); echo '>Front Page -> Link</option>
								<option value="post-format-image"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-image' ); echo '>Front Page -> Image</option>
								<option value="post-format-quote"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-quote' ); echo '>Front Page -> Quote</option>
								<option value="post-format-status"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-status' ); echo '>Front Page -> Status</option>
								<option value="post-format-video"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-video' ); echo '>Front Page -> Video</option>
								<option value="post-format-audio"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-audio' ); echo '>Front Page -> Audio</option>
								<option value="post-format-chat"'; selected( $MOM_Exclude_PostFormats_Front,'post-format-chat' ); echo '>Front Page -> Chat</option>
							</select>
							<select name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
								<option value="">Archives -> none</option>
								<option value="post-format-aside"'; selected( $MOM_Exclude_PostFormats_CategoryArchives, 'post-format-aside' ); echo '>Archives -> Aside</option>
								<option value="post-format-gallery"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-gallery' ); echo '>Archives -> Gallery</option>
								<option value="post-format-link"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-link' ); echo '>Archives -> Link</option>
								<option value="post-format-image"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-image' ); echo '>Archives -> Image</option>
								<option value="post-format-quote"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-quote' ); echo '>Archives -> Quote</option>
								<option value="post-format-status"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-status' ); echo '>Archives -> Status</option>
								<option value="post-format-video"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-video' ); echo '>Archives -> Video</option>
								<option value="post-format-audio"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-audio' ); echo '>Archives -> Audio</option>
								<option value="post-format-chat"'; selected( $MOM_Exclude_PostFormats_CategoryArchives,'post-format-chat' ); echo '>Archives -> Chat</option>
							</select>
							<select name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
								<option value="">Tags -> none</option>
								<option value="post-format-aside"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-aside' ); echo '>Tags -> Aside</option>
								<option value="post-format-gallery"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-gallery' ); echo '>Tags -> Gallery</option>
								<option value="post-format-link"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-link' ); echo '>Tags -> Link</option>
								<option value="post-format-image"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-image' ); echo '>Tags -> Image</option>
								<option value="post-format-quote"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-quote' ); echo '>Tags -> Quote</option>
								<option value="post-format-status"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-status' ); echo '>Tags -> Status</option>
								<option value="post-format-video"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-video' ); echo '>Tags -> Video</option>
								<option value="post-format-audio"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-audio' ); echo '>Tags -> Audio</option>
								<option value="post-format-chat"'; selected( $MOM_Exclude_PostFormats_TagArchives, 'post-format-chat' ); echo '>Tags -> Chat</option>
							</select>
							<select name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
								<option value="">Search -> none</option>
								<option value="post-format-aside"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-aside' ); echo '>Search -> Aside</option>
								<option value="post-format-gallery"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-gallery' ); echo '>Search -> Gallery</option>
								<option value="post-format-link"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-link' ); echo '>Search -> Link</option>
								<option value="post-format-image"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-image' ); echo '>Search -> Image</option>
								<option value="post-format-quote"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-quote' ); echo '>Search -> Quote</option>
								<option value="post-format-status"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-status' ); echo '>Search -> Status</option>
								<option value="post-format-video"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-video' ); echo '>Search -> Video</option>
								<option value="post-format-audio"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-audio' ); echo '>Search -> Audio</option>
								<option value="post-format-chat"'; selected( $MOM_Exclude_PostFormats_SearchResults, 'post-format-chat' ); echo '>Search -> Chat</option>
							</select>
							<select name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
								<option value="">Logged out -> none</option>
								<option value="post-format-aside"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-aside' ); echo '>Logged out -> Aside</option>
								<option value="post-format-gallery"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-gallery' ); echo '>Logged out -> Gallery</option>
								<option value="post-format-link"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-link' ); echo '>Logged out -> Link</option>
								<option value="post-format-image"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-image' ); echo '>Logged out -> Image</option>
								<option value="post-format-quote"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-quote' ); echo '>Logged out -> Quote</option>
								<option value="post-format-status"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-status' ); echo '>Logged out -> Status</option>
								<option value="post-format-video"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-video' ); echo '>Logged out -> Video</option>
								<option value="post-format-audio"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-audio' ); echo '>Logged out -> Audio</option>
								<option value="post-format-chat"'; selected( $MOM_Exclude_PostFormats_Visitor, 'post-format-chat' ); echo '>Logged out -> Chat</option>
							</select>
						</section>'; ?>
		<input id="momsesave" type="submit" class="clear" value="Exclude them!" name="momsesave"></form>
		</div>
	<?php }?>
	<div class="settings-section<?php if( 1 == get_option( 'toggle_misc' ) ) { ?> toggled<?php }?>" id="misc">
		<label for="toggle_misc_submit" class="full-title">Misc. Theme Settings</label>
		<form class="toggle" method="post" action="#misc" name="toggle_misc_form">
			<?php wp_nonce_field( 'toggle_misc_form' ); ?>
			<label for="toggle_misc_submit"">
				<?php if( 0 == get_option( 'toggle_misc' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_misc" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_misc" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_misc_submit" type="submit" name="toggle_misc_submit">
		</form>			
		<em class="full">Setting keyword to <code>keyword</code> will make <code>yoursite.tld/?keyword</code> load a random post</em>
		<em class="full">Read more can be set to <code>%blank%</code> to make it blank</em>
		<form name="mom_save_form" method="post" action="#misc">
			<?php wp_nonce_field( 'mom_save_form' ); ?>
			<section>
				<select name="mompaf_post" id="mompaf_0">
					<option value="off"<?php if ( get_option( 'mompaf_post' ) == 'off' ) { ?> selected="selected"<?php } ?>>Front page is default</option>
					<option value="on"<?php if ( get_option( 'mompaf_post' ) == 'on' ) { ?> selected="selected"<?php } ?>/>Front Page will be your latest post</option>
						<?php $mompaf_post = get_option( 'mompaf_post' );
						selected( get_option( 'mompaf_post' ), 0 );
						$showmeposts = get_posts(array( 'posts_per_page' => -1) );
						foreach($showmeposts as $postsshown){ ?>
							<option name="mompaf_post" id="mompaf_'<?php echo $postsshown->ID; ?>" value="<?php echo $postsshown->ID; ?>"
							<?php $postID = $postsshown->ID;
							$selected = selected( $mompaf_post, $postID); ?>
							>Front page: "<?php echo $postsshown->post_title; ?>"</option>
					<?php } ?>
				</select>
			</section>
			<section>
				<label for="previous_link_class">Previous link class</label>
				<input type="text" id="previous_link_class" name="previous_link_class" value="<?php if( get_option( 'mom_previous_link_class' ) ) { echo get_option( 'mom_previous_link_class' ); } ?>" />
			</section>
			<section>
				<label for="next_link_class">Next link class</label>
				<input type="text" id="next_link_class" name="next_link_class" value="<?php if( get_option( 'mom_next_link_class' ) ) { echo get_option( 'mom_next_link_class' ); } ?>" />
			</section>
			<section>
				<label for="read_more">Read more... value</label>
				<input type="text" id="read_more" name="read_more" value="<?php if( get_option( 'mom_readmore_content' ) ) { 
					echo get_option( 'mom_readmore_content' ); 
				} ?>" />
			</section>
			<section>
				<label for="randomget">Set a keyword</label>
				<input type="text" id="randomget" name="randomget" value="<?php if( get_option( 'mom_random_get' ) ) { 
					echo get_option( 'mom_random_get' ); 
				} ?>" />
			</section>
			<br /><br />
			<section>
				<label for="randomsitetitles">
					Random site titles<br />
					Separate each item with <code>::</code>.<br /><code>title 1 :: title 2 :: title 3 :: ...</code><br /><br />
					</label>
				<textarea id="randomsitetitles" name="randomsitetitles"><?php if( get_option( 'mommodule_random_title' ) ) { echo get_option( 'mommodule_random_title' ); } ?></textarea>
			</section>
			<section>
				<label for="randomsitedescriptions">
					Random site description<br />
					Separate each item with <code>::</code>.<br /><code>Description 1 :: Description 2 :: Description 3 :: ...</code><br /><br />
					</label>
				<textarea id="randomsitedescriptions" name="randomsitedescriptions"><?php if( get_option( 'mommodule_random_descriptions' ) ) { echo get_option( 'mommodule_random_descriptions' ); } ?></textarea>
			</section>				
			<input type="submit" id="mom_save_form" name="mom_save_form_submit" value="Save">
		</form>			
	</div>
	<?php // [mom_attachments] shortcode information block ?>
	<div class="settings-section clear<?php if( 1 == get_option( 'toggle_shortcodes' ) ) { ?> toggled<?php }?>" id="shortcodes">
			<label for="toggle_shortcodes_submit" class="full-title">Shortcodes</label>
			<form class="toggle" method="post" action="#shortcodes" name="toggle_shortcodes_form">
				<?php wp_nonce_field( 'toggle_shortcodes_form' ); ?>
				<label for="toggle_shortcodes_submit"">
					<?php if( 0 == get_option( 'toggle_shortcodes' ) ) { ?>
						<i class="fa fa-minus-square"></i>
						<input type="text" class="hidden" value="1" name="toggle_shortcodes" />
					<?php } else { ?>
						<i class="fa fa-plus-square"></i>
						<input type="text" class="hidden" value="0" name="toggle_shortcodes" />
					<?php }?>
				</label>
				<input class="hidden" id="toggle_shortcodes_submit" type="submit" name="toggle_shortcodes_submit">
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
	<?php // [mom_miniloop] shortcode information block ?>
			<p>
				<span class="title">Miniloops</span>
				<code>[mom_miniloop]</code>  inserts a loop of posts via shortcode.
			</p>
			<p>
				<em>Defaults</em>: <code>[mom_miniloop paging="0" show_link="1" month="" day="" year="" meta="series" key="" link_content="" amount="4" style="tiled" offset="0" category="" orderby="post_date" order="DESC" post_status="publish" cache="false"]</code>
			</p>
			<p>
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
	<div class="settings-section clear<?php if( 1 == get_option( 'toggle_developers' ) ) { ?> toggled<?php }?>" id="developers">
		<label for="toggle_developers_submit" class="full-title">Developers</label>
		<form class="toggle" method="post" action="#developers" name="toggle_developers_form">
			<?php wp_nonce_field( 'toggle_developers_form' ); ?>
			<label for="toggle_developers_submit"">
				<?php if( 0 == get_option( 'toggle_developers' ) ) { ?>
					<i class="fa fa-minus-square"></i>
					<input type="text" class="hidden" value="1" name="toggle_developers" />
				<?php } else { ?>
					<i class="fa fa-plus-square"></i>
					<input type="text" class="hidden" value="0" name="toggle_developers" />
				<?php }?>
			</label>
			<input class="hidden" id="toggle_developers_submit" type="submit" name="toggle_developers_submit">
		</form>
		<p><strong>Theme Developers</strong> may use the following functions in your themes for additional functionality.</p>
		<p><span><code>my_optional_modules_exclude_categories()</code> for a category list that hides categories based on your <strong>Exclude Taxonomies: Exclude Categories</strong> settings.<br /></span></p>
		<p><span><code>new mom_mediaEmbed( 'MEDIA URL' )</code> for media embeds with <a href="http://codex.wordpress.org/Embeds">oEmbed</a> fallback (supports imgur image links AND albums, youtube/youtu.be (with ?t parameter), soundcloud, vimeo, gfycat, funnyordie, and vine).</p>
	</div>
	
</div>
<?php 
/** End options page */
}