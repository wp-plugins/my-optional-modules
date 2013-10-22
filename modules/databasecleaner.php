<?php 

	// Database cleaner

	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

	if (is_admin()) {
	$revisions_count = 0;
	global $table_prefix, $table_suffix, $wpdb;
	$postsTable = $table_prefix . $table_suffix . 'posts';
	$revisions_total = $wpdb->get_results ("SELECT ID FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto_draft' OR `post_status` = 'trash'");
	foreach ($revisions_total as $retot) {
		$revisions_count++;
	}
	$comments_count = 0;
	$commentsTable = $table_prefix . $table_suffix . 'comments';
	$comments_total = $wpdb->get_results ("SELECT comment_ID FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
	foreach ($comments_total as $comtot) {
		$comments_count++;
	}
	$terms_count = 0;
	$termsTable = $table_prefix . $table_suffix . 'term_taxonomy';
	$termsTable2 = $table_prefix . $table_suffix . 'terms';
	$terms_total = $wpdb->get_results ("SELECT term_taxonomy_id FROM `" . $termsTable . "` WHERE `count` = '0'");
	foreach ($terms_total as $termstot) {
		$this_term = $termstot->term_id;
		$terms_count++;
	}					
	echo "<tr valign=\"top\">
			<td><strong>Database cleaner</strong><hr />Clean your database of unnecessary clutter.</td>
			<td>
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">		
					<tbody>
						<tr><td><form method=\"post\"><input id=\"delete_post_revisions\" class=\"button button-primary\" type=\"submit\" value=\"Delete ($revisions_count)\" name=\"delete_post_revisions\"></input></form></td><td>Post clutter</td></tr>
						<tr><td><form method=\"post\"><input id=\"delete_unapproved_comments\" class=\"button button-primary\" type=\"submit\" value=\"Delete ($comments_count)\" name=\"delete_unapproved_comments\"></input></form></td><td>Comment clutter</td></tr>
						<tr><td><form method=\"post\"><input id=\"delete_unused_terms\" class=\"button button-primary\" type=\"submit\" value=\"Delete ($terms_count)\" name=\"delete_unused_terms\"></input></form></td><td>Tag clutter</td></tr>
						<tr><td><form method=\"post\"><input id=\"delete_all\" class=\"button button-primary\" type=\"submit\" value=\"Delete all (" . ($revisions_count+$comments_count+$terms_count) . ")\" name=\"delete_all\"></input></form></td><td>Clear all clutter</td></tr>
					</tbody>
				</table>
			</td>
		</tr>				
		";
		if(isset($_POST['delete_post_revisions']) || isset($_POST['delete_all'])){
			$wpdb->query("DELETE FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");				
		}
		if(isset($_POST['delete_unapproved_comments']) || isset($_POST['delete_all'])){
			$wpdb->query("DELETE FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");				
		}			
		if(isset($_POST['delete_unused_terms']) || isset($_POST['delete_all'])){
			$wpdb->query("DELETE FROM `" . $termsTable2 . "` WHERE `term_id` IN (select `term_id` from `" . $termsTable . "` WHERE `count` = 0 )");
			$wpdb->query("DELETE FROM `" . $termsTable . "` WHERE `count` = 0");		
		}
	}
?>