<?php 

/**
 * My Optional Modules Database Cleaner
 *
 * (1) Clean the database of certain junk items
 *
 * @package regular_board
 */	

if( !defined( 'MyOptionalModules' ) ) {
	die (); 
}

function my_optional_modules_cleaner_module() {
	if( current_user_can( 'manage_options' ) ) {
	global $table_prefix, $wpdb;
	if( isset($_POST[ 'delete_unused_terms' ] ) || isset( $_POST[ 'delete_post_revisions' ] ) || isset( $_POST[ 'delete_unapproved_comments' ] ) || isset( $_POST[ 'deleteAllClutter' ] ) ) {
		$postsTable = $table_prefix.'posts';
		$commentsTable = $table_prefix.'comments';
		$termsTable2 = $table_prefix.'terms';
		$termsTable = $table_prefix.'term_taxonomy';
		if( isset( $_POST[ 'delete_post_revisions' ] ) ) {
			$wpdb->query("DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");
		}
		if( isset ($_POST[ 'delete_unapproved_comments' ] ) ) {
			$wpdb->query("DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
		}
		if( isset( $_POST[ 'delete_unused_terms' ] ) ) {
			$wpdb->query("DELETE FROM `$termsTable2` WHERE `term_id` IN (select `term_id` from `$termsTable` WHERE `count` = 0)");
			$wpdb->query("DELETE FROM `$termsTable` WHERE `count` = 0");
		}
		if( isset( $_POST[ 'deleteAllClutter' ] ) ) {
			$wpdb->query("DELETE FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'");
			$wpdb->query("DELETE FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'");
			$wpdb->query("DELETE FROM `$termsTable2` WHERE `term_id` IN (select `term_id` from `$termsTable` WHERE `count` = 0)");
			$wpdb->query("DELETE FROM `$termsTable` WHERE `count` = 0");
		}
	}		
	$revisions_count = $comments_count = $terms_count = 0;
	$postsTable      = $table_prefix . 'posts';
	$commentsTable   = $table_prefix . 'comments';
	$termsTable2     = $table_prefix . 'terms';
	$termsTable      = $table_prefix . 'term_taxonomy';
	$revisions_total = $wpdb->get_results ( "SELECT ID FROM `$postsTable` WHERE `post_type` = 'revision' OR `post_type` = 'auto_draft' OR `post_status` = 'trash'" );
	$comments_total  = $wpdb->get_results ( "SELECT comment_ID FROM `$commentsTable` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
	$terms_total     = $wpdb->get_results ( "SELECT term_taxonomy_id FROM `$termsTable` WHERE `count` = '0'" );
	if( count( $revisions_total ) ) { 
		foreach ( $revisions_total as $retot ) { 
			$revisions_count++; 
		}
	}
	if( count( $comments_total ) ) {
		foreach ( $comments_total as $comtot ) { 
			$comments_count++; 
		}
	}
	if( count( $terms_total ) ) {
		foreach ( $terms_total as $termstot  ) {
			$terms_count++; 
		}
	}
	$totalClutter    = ( $terms_count + $comments_count + $revisions_count ); ?>
	
		<section class="trash">
			<?php if( $totalClutter ) { ?>
			<label for="deleteAllClutter">
				<i class="fa fa-trash-o"></i>
				<span>Click to clear All clutter</span>
				<em>&mdash; <?php echo esc_attr( $totalClutter );?></em>
				<?php } else { ?>
				<i class="fa fa-trash-o">&mdash;</i> No database clutter to clear
				<?php }?>				
			</label>
			<form method="post">
				<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
			</form>
		</section>
		<section class="trash">
			<?php if( $revisions_count ) { ?>
			<label for="delete_post_revisions">
				<i class="fa fa-trash-o"></i>
				<span>Click to clear Post clutter</span>
				<em>&mdash; <?php echo esc_attr ( $revisions_count );?></em>
				<?php }?>
			</label>
			<form method="post">
				<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
			</form>
		</section>
		<section class="trash">
			<?php if( $comments_count ) { ?>
			<label for="delete_unapproved_comments">
				<i class="fa fa-trash-o"></i>
				<span>Click to clear Comment clutter</span>
				<em>&mdash; <?php echo esc_attr ( $comments_count );?></em>
				<?php }?>				
			</label>
			<form method="post">
				<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
			</form>
		</section>
		<section class="trash">
			<label for="delete_unused_terms">
				<?php if( $terms_count ) { ?>
				<i class="fa fa-trash-o"></i>
				<span>Click to clear Taxonomy clutter</span>
				<em>&mdash; <?php echo esc_attr ( $terms_count );?></em>
				<?php }?>
			</label>
			<form method="post">
				<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
			</form>
		</section>
	<?php 
	}
}