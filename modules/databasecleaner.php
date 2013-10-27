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
	$trash_total = ($revisions_count+$comments_count+$terms_count);
	echo "
	<div class=\"new\">
		<div class=\"panelSection clear\">
			<div class=\"info panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-eraser\"></i> Database cleaner</span>
				</section>
				<p>Clean your database of unnecessary clutter.</p>
			</div>
			<div class=\"panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-trash-o\"></i> All Clutter</span>
					<form method=\"post\"><input id=\"delete_all\" class=\"button button-primary\" type=\"submit\" value=\"Go\" name=\"delete_all\"></input></form>
				</section>
				<p>";
				if ( $trash_total != 0 ) { echo "Delete $trash_total items of post, comment, and tag clutter."; }
				else { echo "Nothing to see here."; }
				echo "</p>
			</div>
			<div class=\"panel left\">
				<section class=\"title clear\">
					<span></span>
				</section>
				<p></p>
			</div>			
		</div>
		<div class=\"panelSection clear\">
			<div class=\"panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-pencil\"></i> Post Clutter</span>
					<form method=\"post\"><input id=\"delete_post_revisions\" class=\"button button-primary\" type=\"submit\" value=\"Go\" name=\"delete_post_revisions\"></input></form>
				</section>
				<p>";
				if ( $revisions_count != 0 ) { echo "Delete $revisions_count post revisions, post drafts, and trashed posts."; }
				else { echo "Nothing to see here."; }
				echo "</p>
			</div>
			<div class=\"panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-comment\"></i> Comment Clutter</span>
					<form method=\"post\"><input id=\"delete_unapproved_comments\" class=\"button button-primary\" type=\"submit\" value=\"Go\" name=\"delete_unapproved_comments\"></input></form>
				</section>
				<p>";
				if ( $comments_count != 0 ) { echo "Delete $comments_count unapproved comments, trashed comments, and spam comments."; }
				else { echo "Nothing to see here."; }
				echo "</p>
			</div>
			<div class=\"panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-tag\"></i> Tag/Cat Clutter</span>
					<form method=\"post\"><input id=\"delete_unused_terms\" class=\"button button-primary\" type=\"submit\" value=\"Go\" name=\"delete_unused_terms\"></input></form>
				</section>
				<p>";
				if ( $terms_count != 0 ) { echo "Delete $terms_count tags and categories with no posts associated with them."; } 
				else { echo "Nothing to see here."; }
				echo "</p>
			</div>
		</div>
	</div>
	";
		if(isset($_POST['delete_unused_terms']) || isset($_POST['delete_post_revisions']) || isset($_POST['delete_unapproved_comments']) || isset($_POST['delete_all'])){
			if(isset($_POST['delete_post_revisions'])){
				$wpdb->query("DELETE FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");				
				
			}
			if(isset($_POST['delete_unapproved_comments'])){
				$wpdb->query("DELETE FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");				
			}			
			if(isset($_POST['delete_unused_terms'])){
				$wpdb->query("DELETE FROM `" . $termsTable2 . "` WHERE `term_id` IN (select `term_id` from `" . $termsTable . "` WHERE `count` = 0 )");
				$wpdb->query("DELETE FROM `" . $termsTable . "` WHERE `count` = 0");		
			}
			if(isset($_POST['delete_all'])){
				$wpdb->query("DELETE FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");				
				$wpdb->query("DELETE FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");				
				$wpdb->query("DELETE FROM `" . $termsTable2 . "` WHERE `term_id` IN (select `term_id` from `" . $termsTable . "` WHERE `count` = 0 )");
				$wpdb->query("DELETE FROM `" . $termsTable . "` WHERE `count` = 0");		

			}			
			echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
		}
	}
?>