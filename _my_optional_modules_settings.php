<?php 

/**
 * My Optional Modules Settings Page
 *
 * (1) Back-end settings page for MOM
 *
 * @package my_optional_modules
 */	

if(current_user_can('manage_options')){
	// Add options page for plugin to Wordpress backend
	add_action('admin_menu','my_optional_modules_add_options_page');
	function my_optional_modules_add_options_page(){
		add_options_page('My Optional Modules','My Optional Modules','manage_options','mommaincontrol','my_optional_modules_page_content'); 
	}

	// Content to display on the options page
	function my_optional_modules_page_content(){ ?>

	<div class="MOMSettings">
		<div class="setting">
		<h2>My Optional Modules</h2>
		[<a href="http://wordpress.org/support/view/plugin-reviews/my-optional-modules">rate/review</a>]
		</div>
		<hr />
		<div class="setting">
			<?php if( !isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
				<form method="post" action="" name="mom_delete_step_one">
				<label for="mom_delete_step_one">Initiate uninstall of My Optional Modules <i class="fa fa-exclamation"></i></label>
				<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hidden" value="Submit" />
				</form>
			<?php } ?>
			<?php if( isset( $_POST[ 'mom_delete_step_one' ] ) ) { ?>
				<form method="post" action="" name="MOM_UNINSTALL_EVERYTHING">
				<label for="MOM_UNINSTALL_EVERYTHING">Confirm uninstall &mdash; Cannot be undone <i class="fa fa-exclamation-triangle"></i></label>
				<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hidden" value="Submit" />
				</form>
			<?php } ?>			
		</div>
		<hr />
		<div class="setting">
			<form method="post" action="">
				<section class="clear">
					<label>Set a blog post as your front page</label>
					<select name="mompaf_post" id="mompaf_0">
						<option value="off"<?php if ( get_option('mompaf_post') == 'off' ) { ?> selected="selected"<?php } ?>>Disabled</option>
						<option value="on"<?php if ( get_option('mompaf_post') == 'on') { ?> selected="selected"<?php } ?>/>Latest post</option>
							<?php $mompaf_post = get_option('mompaf_post');
							selected( $options['mompaf_post'], 0 );
							$showmeposts = get_posts(array('posts_per_page' => -1));
							foreach($showmeposts as $postsshown){ ?>
								<option name="mompaf_post" id="mompaf_'<?php echo $postsshown->ID; ?>" value="<?php echo $postsshown->ID; ?>"
								<?php $postID = $postsshown->ID;
								$selected = selected( $mompaf_post, $postID); ?>
								><?php echo $postsshown->post_title; ?></option>
						<?php } ?>
					</select>
				</section>
				<input type="submit" id="mom_postasfront_post_submit" name="mom_postasfront_post_submit" value="Set it!" class="clear">
			</form>
		</div>
		<hr />
		<div class="setting">
		<?php global $table_prefix, $wpdb;
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
			<form method="post">
			<label for="deleteAllClutter">Clear <u>all</u> database clutter<i class="fa fa-trash-o"> <?php echo esc_attr( $totalClutter );?></i></label>
			<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
			</form>
			<form method="post">
			<label for="delete_post_revisions">
				Clear <u>post</u> clutter
				<i class="fa fa-trash-o"> <?php echo esc_attr ( $revisions_count );?></i>
			</label>
			<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
			</form>
			<form method="post">
			<label for="delete_unapproved_comments">
				Clear <u>comment</u> clutter
				<i class="fa fa-trash-o"> <?php echo esc_attr ( $comments_count );?></i>
			</label>
			<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
			</form>
			<form method="post">
			<label for="delete_unused_terms">
				Clear <u>taxonomy</u> clutter
				<i class="fa fa-trash-o"> <?php echo esc_attr ( $terms_count );?></i>
			</label>
			<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
			</form>
		</div>
		<hr />
		<div class="setting">
			<form method="post" action="" name="momComments">
				<label for="mom_comments_mode_submit">Disable comments site-wide
				<?php if( 1 == get_option( 'mommaincontrol_comments' ) ) { ?>
					<i class="fa fa-check-circle"></i>
				<?php } else { ?>
					<i class="fa fa-circle"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_comments' ) ){ echo 0; } else { echo 1; }?>" name="comments" />
				<input type="submit" id="mom_comments_mode_submit" name="mom_comments_mode_submit" value="Submit" class="hidden" />
				</form>
				
			<form method="post" action="" name="momAjaxComments">
				<label for="mom_ajax_comments_mode_submit">Ajaxify Comments 
				<?php if( 1 == get_option( 'MOM_themetakeover_ajaxcomments' ) ) { ?>
					<i class="fa fa-check-circle"></i>
				<?php } else { ?>
					<i class="fa fa-circle"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_themetakeover_ajaxcomments' ) ){ echo 0; } else { echo 1; }?>" name="ajaxify" />
				<input type="submit" id="mom_ajax_comments_mode_submit" name="mom_ajax_comments_mode_submit" value="Submit" class="hidden" />
				</form>

			<form method="post" action="" name="momHorizontalGalleries">
				<label for="mom_horizontal_galleries_mode_submit">Horizontal Galleries
				<?php if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ) { ?>
					<i class="fa fa-check-circle"></i>
				<?php } else { ?>
					<i class="fa fa-circle"></i>
				<?php }?></label>
				<input type="text" class="hidden" value="<?php if( 1 == get_option( 'MOM_themetakeover_horizontal_galleries' ) ){ echo 0; } else { echo 1; }?>" name="hgalleries" />
				<input type="submit" id="mom_horizontal_galleries_mode_submit" name="mom_horizontal_galleries_mode_submit" value="Submit" class="hidden" />
				</form>				
				
				<form method="post" action="" name="protectrss">
					<label for="mom_protectrss_mode_submit">Append link-back on RSS items
					<?php if( 1 == get_option( 'mommaincontrol_protectrss' ) ) { ?>
						<i class="fa fa-check-circle"></i>
					<?php } else { ?>
						<i class="fa fa-circle"></i>
					<?php }?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_protectrss' ) ) { echo 0; } else { echo 1; } ?>" name="protectrss" />
					<input type="submit" id="mom_protectrss_mode_submit" name="mom_protectrss_mode_submit" value="Submit" class="hidden" />
				</form>				
				<form method="post" action="" name="fontawesome">
					<label for="mom_fontawesome_mode_submit">Enable Font Awesome
					<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>
						<i class="fa fa-check-circle"></i>
					<?php } else { ?>
						<i class="fa fa-circle"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_fontawesome" />
					<input type="submit" id="mom_fontawesome_mode_submit" name="mom_fontawesome_mode_submit" value="Submit" class="hidden" />
				</form>				
				<form method="post" action="" name="hidewpversions">
					<label for="mom_versions_submit">Hide WordPress version from source-code
					<?php if( 1 == get_option( 'mommaincontrol_versionnumbers' ) ) { ?>
						<i class="fa fa-check-circle"></i>
					<?php } else { ?>
						<i class="fa fa-circle"></i>
					<?php }?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_versionnumbers' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_versionnumbers" />
					<input type="submit" id="mom_versions_submit" name="mom_versions_submit" value="Submit" class="hidden" />
				</form>				
				<form method="post" action="" name="footerscripts">
					<label for="mom_footerscripts_mode_submit">Move .js to footer
					<?php if( 1== get_option( 'mommaincontrol_footerscripts' ) ){ ?>
						<i class="fa fa-check-circle"></i>
					<?php }else{ ?>
						<i class="fa fa-circle"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_footerscripts' ) ) { echo 0; } else { echo 1; } ?>" name="footerscripts" />
					<input type="submit" id="mom_footerscripts_mode_submit" name="mom_footerscripts_mode_submit" value="Submit" class="hidden" />
				</form>
				<form method="post" action="" name="lazyload">
					<label for="mom_lazy_mode_submit">Lazy Load for post images
					<?php if( 1 == get_option( 'mommaincontrol_lazyload' ) ) { ?>
						<i class="fa fa-check-circle"></i>
					<?php } else { ?>
						<i class="fa fa-circle"></i>
					<?php } ?></label>
					<input type="text" class="hidden" value="<?php if( 1 == get_option( 'mommaincontrol_lazyload' ) ) { echo 0; } else { echo 1; } ?>" name="mommaincontrol_lazyload" />
					<input type="submit" id="mom_lazy_mode_submit" name="mom_lazy_mode_submit" value="Submit" class="hidden" />
				</form>
				<form method="post" action="" name="authorarchives">
					<label for="mom_author_archives_mode_submit">Disable Author-based archives
					<?php if( 1 == get_option( 'mommaincontrol_authorarchives' ) ) { ?>
						<i class="fa fa-check-circle"></i>
					<?php } else { ?>
						<i class="fa fa-circle"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_authorarchives' ) ) { echo 0; } else { echo 1; } ?>" name="authorarchives" />
					<input type="submit" id="mom_author_archives_mode_submit" name="mom_author_archives_mode_submit" value="Submit" class="hidden" />
				</form>
				<form method="post" action="" name="datearchives">
					<label for="mom_date_archives_mode_submit">Disable Date-based archives
					<?php if( 1 == get_option( 'mommaincontrol_datearchives' ) ) { ?>
						<i class="fa fa-check-circle"></i>
					<?php } else { ?>
						<i class="fa fa-circle"></i>
					<?php } ?></label>
					<input class="hidden" type="text" value="<?php if( 1 == get_option( 'mommaincontrol_datearchives' ) ) { echo 0; } else { echo 1; } ?>" name="datearchives" />
					<input type="submit" id="mom_date_archives_mode_submit" name="mom_date_archives_mode_submit" value="Submit" class="hidden" />
				</form>
		</div>
		<hr />
		<div class="setting">

		</div>
		<hr />
		<div class="setting">
				<div class="clear"><i class="fa fa-code"></i> <code>[mom_miniloop]</code>  inserts a loop of posts via shortcode.</div>
				<span><code>meta=""</code>: a meta-key name.<br /></span>
				<span><code>key=""</code>: a meta-key value.<br /></span>
				<span><code>paging=""</code>: <em>1</em> to turn on, <em>0</em> to turn off.<br /></span>
				<span><code>show_link=""</code>: <em>1</em> to turn on, <em>0</em> to turn off.<br /></span>
				<span><code>link_content=""</code>: Text of the permalink to the post.<br /></span>
				<span><code>amount=""</code>: How many posts to show in the loop.<br /></span>
				<span><code>style=""</code>: <em>columns, list, slider, tiled</em><br /></span>
				<span><code>offset=""</code>: How many posts to skip ahead in the loop.<br /></span>
				<span><code>category=""</code>: Category ID(s) or names (comma-separated if multiple values).<br /></span>
				<span><code>orderby=""</code>: Order posts in the loop by a <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">particular value</a>.<br /></span>
				<span><code>order=""</code>: <em>ASC</em> (ascending) or <em>DESC</em> (descending)<br /></span>
				<span><code>post_status=""</code>: Display posts based on their <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Status_Parameters">status</a>.<br /></span>
				<span><code>year=""</code>: A 4-digit year to pull posts from. (<em>123</em> for current year)<br /></span>
				<span><code>month=""</code>: A 1-2 digit month to pull posts from. (1-12). (<em>123</em> for current month)<br /></span>
				<span><code>day=""</code>: A 1-2 digit day to pull posts from. (1-31). (<em>123</em> for current day)<br /></span>
				<span><code>cache=""</code>: Cache the results of this loop. <em>true</em> or <em>false</em>.<br /></span>
		
		</div>
		<hr />
		<div class="setting">
		<?php 
		$MOM_Exclude_PostFormats_RSS = get_option('MOM_Exclude_PostFormats_RSS');
		$MOM_Exclude_PostFormats_Front = get_option('MOM_Exclude_PostFormats_Front');
		$MOM_Exclude_PostFormats_CategoryArchives = get_option('MOM_Exclude_PostFormats_CategoryArchives');
		$MOM_Exclude_PostFormats_TagArchives = get_option('MOM_Exclude_PostFormats_TagArchives');
		$MOM_Exclude_PostFormats_SearchResults = get_option('MOM_Exclude_PostFormats_SearchResults');
		$MOM_Exclude_PostFormats_Visitor = get_option('MOM_Exclude_PostFormats_Visitor');
		$showmepages = get_pages(); 			
		$showmecats = get_categories('taxonomy=category&hide_empty=0'); 
		$showmetags = get_categories('taxonomy=post_tag&hide_empty=0');
		echo '
		<form method="post" class="clear">
			<section class="clear">
			<p><strong class="sectionTitle">Hide Categories from..</strong></p>
			<div class="list"><span>Category (<strong>ID</strong>)</span>';
			foreach($showmecats as $catsshown){
				echo '
				<span>'.$catsshown->cat_name.'<em>'.$catsshown->cat_ID.'</em></span>';
			}
		echo '</div><div class="rightContainer">';
		$exclude = array('MOM_Exclude_Categories_RSS','MOM_Exclude_Categories_Front','MOM_Exclude_Categories_TagArchives','MOM_Exclude_Categories_SearchResults','MOM_Exclude_Categories_CategoriesSun','MOM_Exclude_Categories_CategoriesMon','MOM_Exclude_Categories_CategoriesTue','MOM_Exclude_Categories_CategoriesWed','MOM_Exclude_Categories_CategoriesThu','MOM_Exclude_Categories_CategoriesFri','MOM_Exclude_Categories_CategoriesSat','MOM_Exclude_Categories_level0Categories','MOM_Exclude_Categories_level1Categories','MOM_Exclude_Categories_level2Categories','MOM_Exclude_Categories_level7Categories');
		$section = array( 'RSS','Front page','Tag archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
		foreach($exclude as $exc ) {
				$title = str_replace($exclude,$section,$exc);
				echo '<section><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
		}				
		echo '</div>
		</section>
		<section class="clear">
		<p><strong class="sectionTitle">Hide Tags from..</strong></p>
		<div class="list"><span>Tag (<strong>ID</strong>)</span>';
			foreach($showmetags as $tagsshown){
				echo '<span>'.$tagsshown->cat_name.'<em>'.$tagsshown->cat_ID.'</em></span>';
			}
		echo '</div><div class="rightContainer">';
		$exclude = array('MOM_Exclude_Tags_RSS','MOM_Exclude_Tags_Front','MOM_Exclude_Tags_CategoryArchives','MOM_Exclude_Tags_SearchResults','MOM_Exclude_Tags_TagsSun','MOM_Exclude_Tags_TagsMon','MOM_Exclude_Tags_TagsTue','MOM_Exclude_Tags_TagsWed','MOM_Exclude_Tags_TagsThu','MOM_Exclude_Tags_TagsFri','MOM_Exclude_Tags_TagsSat','MOM_Exclude_Tags_level0Tags','MOM_Exclude_Tags_level1Tags','MOM_Exclude_Tags_level2Tags','MOM_Exclude_Tags_level7Tags');
		$section = array( 'RSS','Front page','Category archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
		foreach($exclude as $exc ) {
				$title = str_replace($exclude,$section,$exc);
				echo '<section><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
		}				
		echo '</div>
		</section>
		<section class="clear">
			<p><strong class="sectionTitle">Hide Post Formats from..</strong></p>
			<select name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
				<option value="">RSS -> none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-aside'); echo '>RSS -> Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-gallery'); echo '>RSS -> Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-link'); echo '>RSS -> Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-image'); echo '>RSS -> Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-quote'); echo '>RSS -> Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-status'); echo '>RSS -> Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-video'); echo '>RSS -> Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-audio'); echo '>RSS -> Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-chat'); echo '>RSS -> Chat</option>
			</select>
			<select name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
				<option value="">Front Page -> none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Front, 'post-format-aside'); echo '>Front Page -> Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Front,'post-format-gallery'); echo '>Front Page -> Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Front,'post-format-link'); echo '>Front Page -> Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Front,'post-format-image'); echo '>Front Page -> Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Front,'post-format-quote'); echo '>Front Page -> Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Front,'post-format-status'); echo '>Front Page -> Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Front,'post-format-video'); echo '>Front Page -> Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Front,'post-format-audio'); echo '>Front Page -> Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Front,'post-format-chat'); echo '>Front Page -> Chat</option>
			</select>
			<select name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
				<option value="">Archives -> none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_CategoryArchives, 'post-format-aside'); echo '>Archives -> Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-gallery'); echo '>Archives -> Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-link'); echo '>Archives -> Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-image'); echo '>Archives -> Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-quote'); echo '>Archives -> Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-status'); echo '>Archives -> Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-video'); echo '>Archives -> Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-audio'); echo '>Archives -> Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-chat'); echo '>Archives -> Chat</option>
			</select>
			<select name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
				<option value="">Tags -> none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-aside'); echo '>Tags -> Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-gallery'); echo '>Tags -> Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-link'); echo '>Tags -> Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-image'); echo '>Tags -> Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-quote'); echo '>Tags -> Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-status'); echo '>Tags -> Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-video'); echo '>Tags -> Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-audio'); echo '>Tags -> Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-chat'); echo '>Tags -> Chat</option>
			</select>
			<select name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
				<option value="">Search -> none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-aside'); echo '>Search -> Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-gallery'); echo '>Search -> Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-link'); echo '>Search -> Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-image'); echo '>Search -> Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-quote'); echo '>Search -> Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-status'); echo '>Search -> Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-video'); echo '>Search -> Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-audio'); echo '>Search -> Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-chat'); echo '>Search -> Chat</option>
			</select>
			<select name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
				<option value="">Logged out -> none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-aside'); echo '>Logged out -> Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-gallery'); echo '>Logged out -> Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-link'); echo '>Logged out -> Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-image'); echo '>Logged out -> Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-quote'); echo '>Logged out -> Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-status'); echo '>Logged out -> Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-video'); echo '>Logged out -> Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-audio'); echo '>Logged out -> Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-chat'); echo '>Logged out -> Chat</option>
			</select>
		</section>
		<input id="momsesave" type="submit" value="Exclude them!" name="momsesave"></form>';?>		
		</div>
	</div>
	<?php 
	}
}