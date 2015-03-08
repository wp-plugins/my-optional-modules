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
			
			<?php 
				class myoptionalmodules_settings_form{
					
					
					function _construct(){

						global $myoptionalmodules_upgrade_version, $table_prefix, $wpdb;
						
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
						
						$options_disable = array(
							'myoptionalmodules_plugincss',
							'myoptionalmodules_disablecomments',
							'myoptionalmodules_removecode',
							'myoptionalmodules_disablepingbacks',
							'myoptionalmodules_authorarchives',
							'myoptionalmodules_datearchives'
						);
						$keys_disable = array(
							' Plugin CSS',
							' Comment form',
							' Unnecessary Code',
							' Pingbacks', 
							' Author Archives',
							' Date Archives'
						);
						$options_enable = array(
							'myoptionalmodules_metatags',
							'myoptionalmodules_horizontalgalleries',
							'myoptionalmodules_fontawesome',
							'myoptionalmodules_sharelinks',
							'myoptionalmodules_rsslinkbacks',
							'myoptionalmodules_404s'
						);
						$keys_enable = array( 
							' Meta Tags',
							' Horizontal Galleries',
							' Font Awesome',
							' Social Links',
							' RSS Linkbacks',
							' 404s-to-home'
						);
						$options_shares = array( 
							'myoptionalmodules_sharelinks_reddit',
							'myoptionalmodules_sharelinks_google',
							'myoptionalmodules_sharelinks_twitter',
							'myoptionalmodules_sharelinks_facebook',
							'myoptionalmodules_sharelinks_email',
							'myoptionalmodules_shareslinks_top',
							'myoptionalmodules_sharelinks_pages'
						);
						$keys_shares = array(
							' reddit',
							' google plus',
							' twitter',
							' facebook',
							' email',
							' place at top',
							' place on pages'
						);
						$options_comment_form = array(
							'myoptionalmodules_dnsbl',
							'myoptionalmodules_commentspamfield',
							'myoptionalmodules_ajaxcomments'
						);
						$keys_comment_form = array(
							' DNSBL',
							' Spam trap',
							' Ajax'
						);
						$options_extras = array(
							'myoptionalmodules_nelio_submit',
							'myoptionalmodules_featureimagewidth_submit',
							'myoptionalmodules_javascripttofooter',
							'myoptionalmodules_lazyload',
							'myoptionalmodules_recentpostswidget',
							'myoptionalmodules_exclude'
						);
						$keys_extras = array(
							' External Thumbnails',
							' Full-width feature images',
							' Javascript-to-Footer',
							' Lazyload',
							' Recent Posts Widget',
							' Enable Exclude Posts'
						);
						
						$theme_extras = array(
							'myoptionalmodules_google',
							'myoptionalmodules_previouslinkclass',
							'myoptionalmodules_nextlinkclass',
							'myoptionalmodules_readmore',
							'myoptionalmodules_randompost',
							'myoptionalmodules_randomtitles',
							'myoptionalmodules_randomdescriptions'
						);
						
						$options_exclude = array(
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
							'myoptionalmodules_exclude_tagslevel7tags', 				
							'myoptionalmodules_exclude_postformatsrss',
							'myoptionalmodules_exclude_postformatsfront',
							'myoptionalmodules_exclude_postformatscategoryarchives',
							'myoptionalmodules_exclude_postformatstagarchives',
							'myoptionalmodules_exclude_postformatssearchresults',
							'myoptionalmodules_exclude_visitorpostformats'
						);
						
						$all_options = array_merge( $options_disable, $options_enable, $options_shares, $options_comment_form, $options_extras );
						$all_fields  = array_merge( $theme_extras, $options_exclude );
						if( isset( $_POST[ 'myoptionalmodules_settings_form' ] ) && check_admin_referer( 'myoptionalmodules_settings_form' ) ) {
							foreach( $all_options as &$option ){
								if( isset( $_POST[ $option ] ) ){
									$value = intval( $_POST[ $option ] );
									if( $value )
										update_option( $option, $value );
									else
										delete_option( $option );
								}
							}
							$value = null;
							foreach( $all_fields as &$field ) {
								if( isset( $_REQUEST[ $field ] ) ) {
									if( $field == 'myoptionalmodules_previouslinkclass' )
										$_REQUEST[ 'myoptionalmodules_previouslinkclass' ] = str_replace( '.', '', $_REQUEST[ 'myoptionalmodules_previouslinkclass' ] );
									if( $field == 'myoptionalmodules_nextlinkclass' )
										$_REQUEST[ 'myoptionalmodules_nextlinkclass' ]     = str_replace( '.', '', $_REQUEST[ 'myoptionalmodules_nextlinkclass' ] );
									$value = sanitize_text_field( $_REQUEST[ $field ] );
									if( $value )
										update_option( $field, $value );
								}
							}
							$value = null;
						}
						if( isset( $_POST[ 'myoptionalmodules_settings_reset_confirm' ] ) && check_admin_referer( 'myoptionalmodules_settings_form' ) ) {
							foreach( $all_options as &$option ){
									delete_option( $option );
							}
							foreach( $all_fields as &$field ) {
									delete_option( $field );
							}							
						}
						if( isset( $_POST[ 'myoptionalmodules_settings_uninstall_confirm' ] ) && check_admin_referer( 'myoptionalmodules_settings_form' ) ) {
							foreach( $all_options as &$option ){
									delete_option( $option );
							}
							foreach( $all_fields as &$field ) {
									delete_option( $field );
							}
							delete_option( 'myoptionalmodules_upgrade_version' );
						}						
						echo '<div class="settings-section">';
						echo '<div class="full">
						<div class="small">';?>
							<strong>Trash Removal</strong>
							<form method="post" action="#trash-removal" name="optimizeTables">
								<?php wp_nonce_field( 'optimizeTablesForm' ); ?>
								<label for="optimizeTables"">
									<i class="fa fa-rocket"></i>
									Optimize Tables
								</label>
								<input class="hidden" id="optimizeTables" type="submit" value="Go" name="optimizeTables">
							</form>				
							<form method="post" action="#trash-removal" name="deleteAllClutter">
								<?php wp_nonce_field( 'deleteAllClutterForm' ); ?>
								<label for="deleteAllClutter">
									<i class="fa fa-trash-o"></i>
									All Trash
								</label>
								<input class="hidden" id="deleteAllClutter" type="submit" value="Go" name="deleteAllClutter">
							</form>
							<form method="post" action="#trash-removal" name="deletePostRevisionsForm">
								<?php wp_nonce_field( 'deletePostRevisionsForm' ); ?>
								<label for="delete_post_revisions">
									<i class="fa fa-trash-o"></i>
									Revisions + AutoDrafts
								</label>
								<input class="hidden" id="delete_post_revisions" type="submit" value="Go" name="delete_post_revisions">
							</form>
							<form method="post" action="#trash-removal" name="deleteUnapprovedCommentsForm">
								<?php wp_nonce_field( 'deleteUnapprovedCommentsForm' ); ?>
								<label for="delete_unapproved_comments">
									<i class="fa fa-trash-o"></i>
									Comments
								</label>
								<input class="hidden" id="delete_unapproved_comments" type="submit" value="Go" name="delete_unapproved_comments">
							</form>
							<form method="post" action="#trash-removal" name="deleteUnusedTermsForm">
								<?php wp_nonce_field( 'deleteUnusedTermsForm' ); ?>
								<label for="delete_unused_terms">
									<i class="fa fa-trash-o"></i>
									Orphan Tags + Categories
								</label>
								<input class="hidden" id="delete_unused_terms" type="submit" value="Go" name="delete_unused_terms">
							</form>
							<form method="post" action="#trash-removal" name="deleteDraftsForm">
								<?php wp_nonce_field( 'deleteDraftsForm' ); ?>
								<label for="delete_drafts">
									<i class="fa fa-trash-o"></i>
									Drafts
								</label>
								<input class="hidden" id="delete_drafts" type="submit" value="Go" name="delete_drafts">
							</form>
						<?php 
						echo '</div>';
						echo '<div class="right-section">
						<div><strong>My Optional Modules</strong>
							<section>';
								if( isset( $_POST[ 'MOM_UPGRADE' ] ) && check_admin_referer( 'MOM_UPGRADE' ) ) {
									include( 'admin.upgrade.php' );	
								}							
								if( $myoptionalmodules_upgrade_version != get_option( 'myoptionalmodules_upgrade_version' ) ) {
									echo '<form class="warning" method="post" action="" name="MOM_UPGRADE">';
									wp_nonce_field( 'MOM_UPGRADE' );
									echo '<label for="MOM_UPGRADE">
										<i class="fa fa-warning"></i>
										<code>Plugin is uninstalled or disabled due to a necessary database upgrade. Click here to fix, or, if uninstalling, disable and remove it from the plugins menu.</code>
									</label>
									<input type="submit" id="MOM_UPGRADE" name="MOM_UPGRADE" class="hidden" value="Submit" />
									</form>';
								}
							include( 'admin.documentation.php' );
							echo '</section>
						</div>
						</div>
						</div>';					
						
						echo '<form method="post" name="myoptionalmodules_settings_form" action="" class="MOM_form">';
						wp_nonce_field( 'myoptionalmodules_settings_form' );
						
						echo '<div class="left-section">';
						echo '<div><strong>Disable</strong>';
						foreach( $options_disable as &$option ){
							$title   = str_replace($options_disable, $keys_disable, $option);
							$checked = null;
							if( get_option($option) )$checked = ' checked';
							echo "<section><input type='checkbox' value='1' name='$option' id='$option'$checked> $title</section>";
						}
						echo '</div>';

						echo '<div><strong>Enable</strong>';
						foreach( $options_enable as &$option ){
							$title = str_replace($options_enable, $keys_enable, $option);
							$checked = null;
							if( get_option($option) )$checked = ' checked';
							echo "<section><input type='checkbox' value='1' name='$option' id='$option'$checked> $title</section>";
						}
						echo '</div>';
						
						if( get_option( 'myoptionalmodules_sharelinks' ) ){
							echo '<div><strong>Social Links</strong>';
							foreach( $options_shares as &$option ){
								$title = str_replace($options_shares, $keys_shares, $option);
								$checked = null;
								if( get_option($option) )$checked = ' checked';
								echo "<section><input type='checkbox' value='1' name='$option' id='$option'$checked> $title</section>";
							}
							echo '</div>';
						}
						
						echo '<div><strong>Comment Form</strong>';
						foreach( $options_comment_form as &$option ){
							$title = str_replace($options_comment_form, $keys_comment_form, $option);
							$checked = null;
							if( get_option($option) )$checked = ' checked';
							echo "<section><input type='checkbox' value='1' name='$option' id='$option'$checked> $title</section>";
						}
						echo '</div>';

						echo '<div><strong>Extras</strong>';
						foreach( $options_extras as &$option ){
							$title = str_replace($options_extras, $keys_extras, $option);
							$checked = null;
							if( get_option($option) )$checked = ' checked';
							echo "<section><input type='checkbox' value='1' name='$option' id='$option'$checked> $title</section>";
						}
						echo '</div>';
						echo '</div>';
						
						
						echo '<div class="right-section">';
						echo '<div><strong>Theme Extras</strong>
						<select name="myoptionalmodules_frontpage" id="mompaf_0">
							<option value="off"'; if ( get_option( 'myoptionalmodules_frontpage' ) == 'off' ) { echo 'selected="selected"'; } echo '>Front page is default</option>
							<option value="on"'; if ( get_option( 'myoptionalmodules_frontpage' ) == 'on' ) { echo 'selected="selected"'; } echo '/>Front Page will be your latest post</option>';
								$myoptionalmodules_frontpage = get_option( 'myoptionalmodules_frontpage' );
								selected( get_option( 'myoptionalmodules_frontpage' ), 0 );
								$showmeposts = get_posts(array( 'posts_per_page' => -1) );
								foreach($showmeposts as $postsshown){
									echo "<option name='myoptionalmodules_frontpage' id='mompaf_'$postsshown->ID' value='$postsshown->ID'";
									$postID = $postsshown->ID;
									$selected = selected( $myoptionalmodules_frontpage, $postID);
									echo ">Front page: '$postsshown->post_title'</option>";
								}
						echo '</select>';
						
						$google = $previousclass = $nextclass = $readmore = $randompost = 
						$randomtitles = $randomdescriptions = null;
						$google             = get_option( 'myoptionalmodules_google' );
						$previousclass      = get_option( 'myoptionalmodules_previouslinkclass' );
						$nextclass          = get_option( 'myoptionalmodules_nextlinkclass' );
						$readmore           = get_option( 'myoptionalmodules_readmore' );
						$randompost         = get_option( 'myoptionalmodules_randompost' ); 
						$randomtitles       = get_option( 'myoptionalmodules_randomtitles' );
						$randomdescriptions = get_option( 'myoptionalmodules_randomdescriptions' );
						
						echo "<section>
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
						</div>";
						
						echo '</div>';
						
						echo '<div class="clear">';?>

			<?php if( get_option( 'myoptionalmodules_exclude' ) ) { 
				$showmepages = get_pages(); 			
				$showmecats  = get_categories( 'taxonomy=category&hide_empty=0' ); 
				$showmetags  = get_categories( 'taxonomy=post_tag&hide_empty=0' );
				$showmeusers = get_users(  );
				$tagcount    = 0;
				$catcount    = 0;
				$usercount   = 0;
			?>
				<div class="fullwidth">
				<strong>Exclude Posts</strong>
				<p>Each field takes a comma-separated list of items for exclusion from the specified
				section of the blog. When filling out each field, <code>this is the value you will use</code>. Names are there for reference.</p>
				<p>Exclusions based on user roles (guest, subscriber, contributor, author) will prevent those user roles
				from being able to view the post as a single page (is_single()). The error message will be wrapped in the div <code>.mom-unauthorized-content</code> 
				for CSS-styling purposes.</p>
				<?php 
				$myoptionalmodules_exclude_postformatsrss              = get_option( 'myoptionalmodules_exclude_postformatsrss' );
				$myoptionalmodules_exclude_postformatsfront            = get_option( 'myoptionalmodules_exclude_postformatsfront' );
				$myoptionalmodules_exclude_postformatscategoryarchives = get_option( 'myoptionalmodules_exclude_postformatscategoryarchives' );
				$myoptionalmodules_exclude_postformatstagarchives      = get_option( 'myoptionalmodules_exclude_postformatstagarchives' );
				$myoptionalmodules_exclude_postformatssearchresults    = get_option( 'myoptionalmodules_exclude_postformatssearchresults' );
				$myoptionalmodules_exclude_visitorpostformats          = get_option( 'myoptionalmodules_exclude_visitorpostformats' ); ?>
					<hr />
					<p>Exclude <em>these</em> Author(s) <em>from</em></p>
					<p>
					<?php foreach($showmeusers as $usersshown){ ++$usercount; ?>
						<?php echo $usersshown->user_nicename; ?> <code><?php echo $usersshown->ID; ?></code> &mdash; 
					<?php }?>
					</p>
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
						' the feed',
						' the front page',
						' category archives',
						' tag archives',
						' any search results',
						' any area on Sunday',
						' any area on Monday',
						' any area on Tuesday',
						' any area on Wednesday',
						' any area on Thursday',
						' any area on Friday',
						' any area on Saturday',
						' any visitor who is not logged in',
						' any visitor who is a subscriber',
						' any visitor who is a contributor',
						' any visitor who is an author'
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
								<p>You have no users to exclude.</p>
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
								' the feed',
								' the front page',
								' tag archives',
								' any search results',
								' any area on Sunday',
								' any area on Monday',
								' any area on Tuesday',
								' any area on Wednesday',
								' any area on Thursday',
								' any area on Friday',
								' any area on Saturday',
								' any visitor who is not logged in',
								' any visitor who is a subscriber',
								' any visitor who is a contributor',
								' any visitor who is an author'						
							); ?>
							<hr />
							<p>Exclude <em>these</em> Categories <em>from</em></p>
							<p>
								<?php foreach($showmecats as $catsshown){ ++$catcount; ?>
									<?php echo $catsshown->cat_name; ?> <code><?php echo $catsshown->cat_ID; ?></code> &mdash; 
								<?php }?>
							</p>
							<?php 
								if( $catcount > 0 ) {
									foreach($exclude as $exc ) { 
									$title = str_replace($exclude, $section, $exc); ?>
									<section class="small-section">
										<label for="<?php echo $exc;?>"><?php echo $title;?></label>
										<input type="text" id="<?php echo $exc;?>" name="<?php echo $exc;?>" value="<?php echo get_option($exc);?>">
									</section>
								<?php } } else { ?>
									<p>You have no categories to exclude.</p>
								<?php }?>
							<hr />
							<span class="title-full">Exclude <em>these</em> Tag(s) <em>from</em></span>
							<p>
								<?php foreach($showmetags as $tagsshown){ 
									++$tagcount;?>
									<?php echo $tagsshown->cat_name;?> <code><?php echo $tagsshown->cat_ID;?></code> &mdash;
								<?php } ?>
							</p>
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
										' the feed',
										' the front page',
										' category archives',
										' any search results',
										' any area on Sunday',
										' any area on Monday',
										' any area on Tuesday',
										' any area on Wednesday',
										' any area on Thursday',
										' any area on Friday',
										' any area on Saturday',
										' any visitor who is not logged in',
										' any visitor who is a subscriber',
										' any visitor who is a contributor',
										' any visitor who is an author'
									);
									foreach($exclude as $exc ) {
										$title = str_replace($exclude, $section, $exc); ?>
										<section class="small-section">
											<label for="<?php echo $exc;?>"><?php echo $title;?></label>
											<input type="text" id="<?php echo $exc;?>" name="<?php echo $exc;?>" value="<?php echo get_option($exc);?>">
										</section>
							<?php }
								} else { ?>
									<p>You have no tags to exclude.</p>
								<?php } ?>
							<hr />
							<p>Exclude <em>these</em> Post Format(s) <em>from</em></p>
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
							</section>
						</div>';
				$showmepages = $showmecats  = $showmetags  = $showmeusers = $tagcount    = $catcount    = $usercount   = null;
			}
						
						
						echo '<div class="clear">';
						echo '<input type="submit" value="Save" class="button button-primary" name="myoptionalmodules_settings_form" id="myoptionalmodules_settings_form">';
						if( !isset( $_POST[ 'myoptionalmodules_settings_reset' ] ) ) {
							echo '<input type="submit" value="Reset" class="button button-primary" name="myoptionalmodules_settings_reset" id="myoptionalmodules_settings_reset">';
						} else {
							echo '<input type="submit" value="Reset Confirm" class="button button-primary" name="myoptionalmodules_settings_reset_confirm" id="myoptionalmodules_settings_reset_confirm">';
						}
						if( !isset( $_POST[ 'myoptionalmodules_settings_uninstall' ] ) ) {
							echo '<input type="submit" value="Uninstall" class="button button-primary" name="myoptionalmodules_settings_uninstall" id="myoptionalmodules_settings_uninstall">';
						} else {
							echo '<input type="submit" value="Uninstall Confirm" class="button button-primary" name="myoptionalmodules_settings_uninstall_confirm" id="myoptionalmodules_settings_uninstall_confirm">';
						}
						echo '</div>';
						echo '</form></div>';
					}
				
				}
				$myoptionalmodules_settings_form = new myoptionalmodules_settings_form();
				$myoptionalmodules_settings_form->_construct();
				
			?>
	</div>
<?php 
/** End options page */
}