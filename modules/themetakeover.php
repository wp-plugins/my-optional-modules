<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}
	if(is_admin()){ 
		function my_optional_modules_theme_takeover_module(){
			function update_momthemetakeover_options(){
				if(isset($_POST['momthemetakeoversave'])){
					update_option('MOM_themetakeover_youtubefrontpage',$_REQUEST['MOM_themetakeover_youtubefrontpage']);
					update_option('MOM_themetakeover_topbar',$_REQUEST['MOM_themetakeover_topbar']);
					update_option('MOM_themetakeover_archivepage',$_REQUEST['MOM_themetakeover_archivepage']);
				}
			}
			function mom_themetakeover_form(){
				echo '<div class="clear"></div>
				
				<div class="exclude">
					<section><label for="MOM_themetakeover_youtubefrontpage">Youtube URL for 404s</label><input type="text" id="MOM_themetakeover_youtubefrontpage" name="MOM_themetakeover_youtubefrontpage" value="'.get_option('MOM_themetakeover_youtubefrontpage').'"></section>
				</div>';
				echo '
				<div class="exclude">
					<section><label for="MOM_themetakeover_topbar">Enable navbar</label>
						<select id="MOM_themetakeover_topbar" name="MOM_themetakeover_topbar">
							<option value="1"'; if(get_option('MOM_themetakeover_topbar') == 1) { echo ' selected="selected"';} echo '">Yes</section>
							<option value="0"'; if(get_option('MOM_themetakeover_topbar') == 0) { echo ' selected="selected"';} echo '">No</section>
						</select>
					</section>';
				if(get_option('mommaincontrol_shorts') == 1){
				$showmepages = get_pages(); 
				echo '<section>
				<label for="MOM_themetakeover_archivepage">Archives page</label>
				<select name="MOM_themetakeover_archivepage" class="allpages" id="MOM_themetakeover_archivepage">
					<option value="">Home page</option>';
					foreach ($showmepages as $pagesshown){
						echo '<option name="MOM_themetakeover_archivepage" id="mompaf_'.$pagesshown->ID.'" value="'.$pagesshown->ID.'"'; 
						if (get_option('MOM_themetakeover_archivepage') == $pagesshown->ID){echo ' selected="selected"';} echo '>
						'.$pagesshown->post_title.'</option>';
					}
					echo '
				</select>
				</section>';
				}else{
				echo '<section>
				<label>__Dependency: Shortcodes (not enabled)</label>
				</section>';
				}
				echo '</div>
				<div class="exclude">

				</section>';
			}
			function mom_themetakeover_page_content(){
				echo '
				<span class="moduletitle">__theme takeover<em>easy theme manipulation</em></span>
				<div class="clear"></div>				
				<div class="settings">
				<form method="post">';
						mom_themetakeover_form();
						echo '
						<input id="momthemetakeoversave" type="submit" value="Save Changes" name="momthemetakeoversave">
					</form>
				</div>
				</div>
				</div>
				<div class="new"></div>';
			}
			if(isset($_POST['momthemetakeoversave'])){update_momthemetakeover_options();}
			mom_themetakeover_page_content();
		}
		my_optional_modules_theme_takeover_module();
	}
?>