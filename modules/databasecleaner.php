<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: CLEANER

    if (is_admin() ) {

        function my_optional_modules_cleaner_module() {
            global $table_prefix, $table_suffix, $wpdb;
            $revisions_count = 0;
            $comments_count = 0;
            $terms_count = 0;
            $postsTable = $table_prefix . $table_suffix . 'posts';
            $commentsTable = $table_prefix . $table_suffix . 'comments';
            $termsTable2 = $table_prefix . $table_suffix . 'terms';
            $termsTable = $table_prefix . $table_suffix . 'term_taxonomy';
            $revisions_total = $wpdb->get_results ( "SELECT ID FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto_draft' OR `post_status` = 'trash'" );
            $comments_total = $wpdb->get_results ( "SELECT comment_ID FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
            $terms_total = $wpdb->get_results ( "SELECT term_taxonomy_id FROM `" . $termsTable . "` WHERE `count` = '0'" );
            
            foreach ( $revisions_total as $retot ) {
                $revisions_count++;
            }
            
            foreach ( $comments_total as $comtot ) {
                $comments_count++;
            }
            
            foreach ( $terms_total as $termstot ) {
                $this_term = $termstot->term_id;
                $terms_count++;
            }

			$totalClutter = ( $terms_count + $comments_count + $revisions_count );
            
            echo "
            
            <section class=\"trash\">
            <label for=\"deleteAllClutter\"><i class=\"fa fa-trash-o\"></i><span>Clear Post, Comment, and Tag/Category clutter.</span><em>" . $totalClutter . "</em></label>
            <form method=\"post\"><input class=\"hidden\" id=\"deleteAllClutter\" type=\"submit\" value=\"Go\" name=\"deleteAllClutter\"></form>
            </section>

            <section class=\"trash\">
            <label for=\"delete_post_revisions\"><i class=\"fa fa-trash-o\"></i><span>Clear auto-drafts, trashed posts, and revisions.</span><em>" . $revisions_count . "</em></label>
            <form method=\"post\"><input class=\"hidden\" id=\"delete_post_revisions\" type=\"submit\" value=\"Go\" name=\"delete_post_revisions\"></form>
            </section>

            <section class=\"trash\">
            <label for=\"delete_unapproved_comments\"><i class=\"fa fa-trash-o\"></i><span>Clear spam comments, trashed comments, and unapproved comments.</span><em>" . $comments_count . "</em></label>
            <form method=\"post\"><input class=\"hidden\" id=\"delete_unapproved_comments\" type=\"submit\" value=\"Go\" name=\"delete_unapproved_comments\"></form>
            </section>

            <section class=\"trash\">
            <label for=\"delete_unused_terms\"><i class=\"fa fa-trash-o\"></i><span>Clear tags and categories that have no associated posts.</span><em>" . $terms_count . "</em></label>
            <form method=\"post\"><input class=\"hidden\" id=\"delete_unused_terms\" type=\"submit\" value=\"Go\" name=\"delete_unused_terms\"></form>
            </section>
			";
            
            if(
                isset( $_POST[ 'delete_unused_terms' ] ) || 
                isset( $_POST [ 'delete_post_revisions' ] ) || 
                isset( $_POST[ 'delete_unapproved_comments' ] ) || 
                isset( $_POST[ 'deleteAllClutter' ] ) ) 
            {
                if( isset( $_POST[ 'delete_post_revisions' ] ) ) {
                    $wpdb->query( "DELETE FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'" );
                }
                
                if( isset( $_POST[ 'delete_unapproved_comments' ] ) ) {
                    $wpdb->query( "DELETE FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
                }
                
                if( isset( $_POST[ 'delete_unused_terms' ] ) ) {
                    $wpdb->query( "DELETE FROM `" . $termsTable2 . "` WHERE `term_id` IN (select `term_id` from `" . $termsTable . "` WHERE `count` = 0 )" );
                    $wpdb->query( "DELETE FROM `" . $termsTable . "` WHERE `count` = 0" );
                }
        
                if( isset( $_POST[ 'deleteAllClutter' ] ) ) {
                    $wpdb->query( "DELETE FROM `" . $postsTable . "` WHERE `post_type` = 'revision' OR `post_type` = 'auto-draft' OR `post_status` = 'trash'" );
                    $wpdb->query( "DELETE FROM `" . $commentsTable . "` WHERE `comment_approved` = '0' OR `comment_approved` = 'post-trashed' or `comment_approved` = 'spam'" );
                    $wpdb->query( "DELETE FROM `" . $termsTable2 . "` WHERE `term_id` IN (select `term_id` from `" . $termsTable . "` WHERE `count` = 0 )" );
                    $wpdb->query( "DELETE FROM `" . $termsTable . "` WHERE `count` = 0");
                }
                echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
            }
        }
    
        my_optional_modules_cleaner_module();
    
    }
    
?>