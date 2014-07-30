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
		
		<div class="moduleHeader">
			<strong class="sectionTitle">My Optional Modules</strong>
			<p>
				Configure this plugins many settings on this page.<br />
				Found this plugin useful? Don't forget to <a href="http://wordpress.org/support/view/plugin-reviews/my-optional-modules">rate and review</a>!
			</p>
		</div>
		<div class="left">
			<strong class="sectionTitle">Modules</strong>
			<?php echo '
				<form class="config" method="post">
					<section>
						<label class="configurationlabel" for="MOMclear">Home</label>
						<input id="MOMclear" name="MOMclear" class="hidden" type="submit">
					</section>
				</form>
				<hr />
				<p>Has options</p>';
				if(get_option('mommaincontrol_reviews') == 1){
					echo '
					<form class="config" method="post">
						<section>
							<label class="configurationlabel" for="MOMreviews">Reviews</label>
							<i class="fa fa-cogs"></i>
							<input id="MOMreviews" name="MOMreviews" class="hidden" type="submit">
						</section>
					</form>';
				}else{
					echo '
					<form class="config" method="post" action="" name="momReviews">
						<label for="mom_reviews_mode_submit">Reviews</label>';
						if(get_option('mommaincontrol_reviews') == 1){
							echo '<i class="fa fa-check-square"></i>';
						}else{
							echo '<i class="fa fa-square"></i>';
						}
						echo '<input type="text" class="hidden" value="';
						if(get_option('mommaincontrol_reviews') == 1){
							echo '0';
						}else{
							echo '1';
						}
						echo '" name="reviews" />
						<input type="submit" id="mom_reviews_mode_submit" name="mom_reviews_mode_submit" value="Submit" class="hidden" />
					</form>';
				}
				if(get_option('mommaincontrol_obwcountplus') == 1){
					echo '
					<form class="config" method="post">
						<section>
							<label class="configurationlabel" for="MOMcount">Count++</label>
								<i class="fa fa-cogs"></i>
								<input id="MOMcount" name="MOMcount" class="hidden" type="submit">
						</section>
					</form>';
				}else{
					echo '
					<form class="config" method="post" action="" name="momCount">
						<label for="mom_count_mode_submit">Count++</label>';
						if(get_option('mommaincontrol_obwcountplus') == 1){
							echo '<i class="fa fa-check-square"></i>';
						}else{
							echo '<i class="fa fa-square"></i>';
						}
						echo '<input type="text" class="hidden" value="';
						if(get_option('mommaincontrol_obwcountplus') == 1){
							echo '0';
						}else{
							echo '1';
						}
						echo '" name="countplus" />
						<input type="submit" id="mom_count_mode_submit" name="mom_count_mode_submit" value="Submit" class="hidden" />
					</form>';
				}
				
				if(get_option('mommaincontrol_momse') == 1){
					echo '
					<form class="config" method="post">
						<section>
							<label class="configurationlabel" for="MOMexclude">Exclude</label>
							<i class="fa fa-cogs"></i>
							<input id="MOMexclude" name="MOMexclude" class="hidden" type="submit">
						</section>
					</form>';
				}else{
					echo '<form class="config" method="post" action="" name="momExclude"><label for="mom_exclude_mode_submit">Exclude</label>';if(get_option('mommaincontrol_momse') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momse') == 1){echo '0';}else{echo '1';}echo '" name="exclude" /><input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" />
					</form>';
				}
				
				if(get_option('mommaincontrol_momja') == 1){
					echo '
					<form class="config" method="post"><section><label class="configurationlabel" for="MOMjumparound">Jump Around</label><i class="fa fa-cogs"></i><input id="MOMjumparound" name="MOMjumparound" class="hidden" type="submit"></section></form>';}else{echo '<form class="config" method="post" action="" name="momJumpAround"><label for="mom_jumparound_mode_submit">Jump Around</label>';if(get_option('mommaincontrol_momja') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momja') == 1){echo '0';}else{echo '1';}echo '" name="jumparound" /><input type="submit" id="mom_jumparound_mode_submit" name="mom_jumparound_mode_submit" value="Submit" class="hidden" />
					</form>';
				}
				
				if(get_option('mommaincontrol_shorts') == 1){
					echo '
					<form class="config" method="post"><section><label class="configurationlabel" for="MOMshortcodes"></i>Shortcodes</label><i class="fa fa-cogs"></i><input id="MOMshortcodes" name="MOMshortcodes" class="hidden" type="submit"></section></form>';}else{echo '<form class="config" method="post" action="" name="momShortcodes"><label for="mom_shortcodes_mode_submit">Shortcodes</label>';if(get_option('mommaincontrol_shorts') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_shorts') == 1){echo '0';}else{echo '1';}echo '" name="shortcodes" /><input type="submit" id="mom_shortcodes_mode_submit" name="mom_shortcodes_mode_submit" value="Submit" class="hidden" />
					</form>';
				}
				
				if(get_option('mommaincontrol_themetakeover') == 1){
					echo '
					<form class="config" method="post"><section><label class="configurationlabel" for="MOMthemetakeover"></i>Takeover</label><i class="fa fa-cogs"></i><input id="MOMthemetakeover" name="MOMthemetakeover" class="hidden" type="submit"></section></form>';}else{echo '<form class="config" method="post" action="" name="momThemTakeover"><label for="mom_themetakeover_mode_submit">Takeover</label>';if(get_option('mommaincontrol_themetakeover') == 1){echo '<i class="fa fa-check-square"></i>';}else{echo '<i class="fa fa-square"></i>';}echo '<input type="text" class="hidden" value="';if(get_option('mommaincontrol_themetakeover') == 1){echo '0';}else{echo '1';}echo '" name="themetakeover" /><input type="submit" id="mom_themetakeover_mode_submit" name="mom_themetakeover_mode_submit" value="Submit" class="hidden" />
					</form>';
				}
				
				if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH && get_option('mommaincontrol_momrups') == 1){
					echo '
					<form class="config" method="post">
						<section>
							<label class="configurationlabel" for="MOMpasswords">Passwords</label>
							<i class="fa fa-cogs"></i><input id="MOMpasswords" name="MOMpasswords" class="hidden" type="submit">
						</section>
					</form>';
				}else{
					if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){
						echo '
						<form class="config"  method="post" action="" name="momPasswords">
							<label for="mom_passwords_mode_submit">Passwords</label>';
							if(get_option('mommaincontrol_momrups') == 1){
								echo '<i class="fa fa-check-square"></i>';
							}else{
								echo '<i class="fa fa-square"></i>';
							}
							echo '<input type="text" class="hidden" value="';
							if(get_option('mommaincontrol_momrups') == 1){
								echo '0';
							}else{
								echo '1';
							}
							echo '" name="passwords" /><input type="submit" id="mom_passwords_mode_submit" name="mom_passwords_mode_submit" value="Submit" class="hidden" />
						</form>';
					}
				}
				
				echo '
				<hr />
				<p>Has <em>no</em> options</p>
				<form class="config" method="post" action="" name="momVotes">
					<label for="mom_votes_mode_submit">Post votes</label>';
					if(get_option('mommaincontrol_votes') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input type="text" class="hidden" value="';
					if(get_option('mommaincontrol_votes') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="votes" /><input type="submit" id="mom_votes_mode_submit" name="mom_votes_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="protectrss">
					<label for="mom_protectrss_mode_submit">&copy; RSS feed</label>';
					if(get_option('mommaincontrol_protectrss') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_protectrss') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="protectrss" /><input type="submit" id="mom_protectrss_mode_submit" name="mom_protectrss_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="fontawesome">
					<label for="mom_fontawesome_mode_submit">Font Awesome</label>';
					if(get_option('mommaincontrol_fontawesome') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_fontawesome') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="mommaincontrol_fontawesome" /><input type="submit" id="mom_fontawesome_mode_submit" name="mom_fontawesome_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="hidewpversions">
					<label for="mom_versions_submit">Hide WP Version</label>';
					if(get_option('mommaincontrol_versionnumbers') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_versionnumbers') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="mommaincontrol_versionnumbers" /><input type="submit" id="mom_versions_submit" name="mom_versions_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="footerscripts">
					<label for="mom_footerscripts_mode_submit">JS to footer</label>';
					if(get_option('mommaincontrol_footerscripts') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_footerscripts') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="footerscripts" /><input type="submit" id="mom_footerscripts_mode_submit" name="mom_footerscripts_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="lazyload">
					<label for="mom_lazy_mode_submit">Lazy Load</label>';
					if(get_option('mommaincontrol_lazyload') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input type="text" class="hidden" value="';
					if(get_option('mommaincontrol_lazyload') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="mommaincontrol_lazyload" /><input type="submit" id="mom_lazy_mode_submit" name="mom_lazy_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="meta">
					<label for="mom_meta_mode_submit">Meta</label>';
					if(get_option('mommaincontrol_meta') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input type="text" class="hidden" value="';
					if(get_option('mommaincontrol_meta') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="mommaincontrol_meta" /><input type="submit" id="mom_meta_mode_submit" name="mom_meta_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="authorarchives">
					<label for="mom_author_archives_mode_submit">Disable Authors</label>';
					if(get_option('mommaincontrol_authorarchives') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_authorarchives') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="authorarchives" /><input type="submit" id="mom_author_archives_mode_submit" name="mom_author_archives_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="datearchives">
					<label for="mom_date_archives_mode_submit">Disable Dates</label>';
					if(get_option('mommaincontrol_datearchives') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_datearchives') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="datearchives" /><input type="submit" id="mom_date_archives_mode_submit" name="mom_date_archives_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="fixcanon">
					<label for="mom_fixcanon_mode_submit">Fix Canon</label>';
					if(get_option('mommaincontrol_fixcanon') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_fixcanon') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="fixcanon" /><input type="submit" id="mom_fixcanon_mode_submit" name="mom_fixcanon_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="prettycanon">
					<label for="mom_prettycanon_mode_submit">Pretty Canon</label>';
					if(get_option('mommaincontrol_prettycanon') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';
					}
					echo '<input class="hidden" type="text" value="';
					if(get_option('mommaincontrol_prettycanon') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="prettycanon" /><input type="submit" id="mom_prettycanon_mode_submit" name="mom_prettycanon_mode_submit" value="Submit" class="hidden" />
				</form>
				
				<form class="config" method="post" action="" name="momMaintenance">
					<label for="mom_maintenance_mode_submit">Maintenance</label>';
					if(get_option('mommaincontrol_maintenance') == 1){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-square"></i>';}
						echo '<input type="text" class="hidden" value="';
					if(get_option('mommaincontrol_maintenance') == 1){
						echo '0';
					}else{
						echo '1';
					}
					echo '" name="maintenanceMode" class="hidden" /><input type="submit" id="mom_maintenance_mode_submit" name="mom_maintenance_mode_submit" class="hidden" value="Submit" />
				</form>';
				
				if(!isset($_POST['mom_delete_step_one'])){
					echo '
					<form class="config" method="post" action="" name="mom_delete_step_one">
					<label for="mom_delete_step_one" class="onoff0">Uninstall</label>
					<input type="submit" id="mom_delete_step_one" name="mom_delete_step_one" class="hidden" value="Submit" />
					</form>
					';
				}
				if(isset($_POST['mom_delete_step_one'])){
					echo '
					<form class="config" method="post" action="" name="MOM_UNINSTALL_EVERYTHING">
					<label for="MOM_UNINSTALL_EVERYTHING" class="onoff1">Confirm this</label>
					<input type="submit" id="MOM_UNINSTALL_EVERYTHING" name="MOM_UNINSTALL_EVERYTHING" class="hidden" value="Submit" />
					</form>';
				}
			?>
		</div>
		<div class="right">
			<strong class="sectionTitle textAlignRight">Settings</strong>
			<?php 
			if ( get_option('mommaincontrol_focus') ) {
				if(get_option('mommaincontrol_obwcountplus') == 1 && get_option('mommaincontrol_focus') == 'count'){
					my_optional_modules_count_module();
				}elseif(get_option('mommaincontrol_momse') == 1 && get_option('mommaincontrol_focus') == 'exclude'){
					my_optional_modules_exclude_module();
				}elseif(get_option('mommaincontrol_momja') == 1 && get_option('mommaincontrol_focus') == 'jumparound'){
					my_optional_modules_jump_around_module();
				}elseif(get_option('mommaincontrol_momrups') == 1 && get_option('mommaincontrol_focus') == 'passwords'){
					my_optional_modules_passwords_module();
				}elseif(get_option('mommaincontrol_reviews') == 1 && get_option('mommaincontrol_focus') == 'reviews'){
					my_optional_modules_reviews_module();
				}elseif(get_option('mommaincontrol_shorts') == 1 && get_option('mommaincontrol_focus') == 'shortcodes'){
					my_optional_modules_shortcodes_module();
				}elseif(get_option('mommaincontrol_themetakeover') == 1 && get_option('mommaincontrol_focus') == 'themetakeover'){
					my_optional_modules_theme_takeover_module();
				}
			} else { ?>
				<strong class="sectionTitle">Misc. Settings (that don't have a proper home)</strong>
				<form class="clear" method="post" action="">
					<section class="clear">
						<label class="left">Analytics ID</label>
						<input class="right" onClick="this.select();" type="text" value="<?php echo get_option('momanalytics_code');?>" name="momanalytics_code" placeholder="UA-XXXXXXXX-X" />
					</section>
					<section class="clear">
						<label class="left">Maintenance URL</label>
						<input class="right" placeholder="http://url.tld" onClick="this.select();" type="text" value="<?php echo get_option('momMaintenance_url');?>" name="momMaintenance_url" />
					</section>
					<section class="clear">
						<label class="left">Post as front</label>
						<select class="right" name="mompaf_post" id="mompaf_0">
							<option value="off"
								<?php if ( get_option('mompaf_post') == 'off' ) { ?> 
									selected="selected" 
								<?php } ?>
								>Disabled</option>
							<option value="on"
								<?php if ( get_option('mompaf_post') == 'on') { ?> 
									selected="selected"
								<?php } ?>
								/>Latest post</option>
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
					<input type="submit" id="mom_postasfront_post_submit" name="mom_postasfront_post_submit" value="Save these options" >
					</form>
					<p></p>
					<?php my_optional_modules_cleaner_module(); ?>
					
					<p>
						<i class="fa fa-warning">&mdash;</i> Any warnings will display here:<br /><br />
						<?php if(defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH){
						}else{ ?>
							<i class="fa fa-info">&mdash;</i> CRYPT_BLOWFISH is not available.  Passwords module disabled.<br />
						<?php } ?>
					</p>
			<?php } ?>			
		</div>
	
	</div>
	
	
	<?php 
	}
}