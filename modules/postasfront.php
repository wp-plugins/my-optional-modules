<?php 

	## Module name: Post as Front (PAF)
	## Module contents
	##   - options form (save)
	##   - options form (output)
	##   - options page (output)

	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

	if (is_admin() ) { 
	
		## options form (save)
		function update_mompaf_options() {
			if(isset($_POST['mompafsave'])){
				update_option("mompaf_post",$_REQUEST["mompaf_post"]);
			}		
		}
		
		## options form (output)
		function mompaf_form() {
			echo "
				<tr valign=\"top\">
					<td>
						<select id=\"mompaf_post\" class=\"regular-text\" type=\"text\" name=\"mompaf_post\">
						<option value=\"0\">Most recent post</option>";
							$showmeposts =  get_posts( array('posts_per_page' => -1 )); 
							foreach ($showmeposts as $postsshown) {
								echo "<option value=\"" . $postsshown->ID . "\""; 
								if (get_option('mompaf_post') == $postsshown->ID) { echo "selected=\"selected\""; }
								echo ">$postsshown->post_title</option>";
							}		
						echo "
						</select>
						<input id=\"mompafsave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"mompafsave\"></input>
					</td>
				</tr>
			";
		}
	
		## options page (output)
		
			echo "
				<form method=\"post\">
					<table class=\"form-table\"  style=\"margin-top: -8px; margin-left: -10px;\">
						<tbody>
			";
			mompaf_form();
			echo "
						</tbody>
					</table>
				</form>			
			";
			if(isset($_POST["mompafsave"])){ update_mompaf_options(); } 
		
	}
?>