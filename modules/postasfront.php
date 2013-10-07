<?php 

	if(!defined('MyOptionalModules')) {
	die('You can not call this file directly.');
	}

 ## Post as Front
	## mompaf
	##	register options page
	if (is_admin() ) {
		add_action("admin_menu", "mompaf_add_options_page");
	}
	
	add_action( "wp", "mompaf_filter_home" );
	
	## Get the options set up by the plugin for use throughout
	$mompaf_post = get_option("mompaf_post");

	## mompaf options page
		function mompaf_add_options_page() {																
			$mompaf_options = add_options_page("MOM: PAF", " &not; MOM: PAF", "manage_options", "mompaf", "mompaf_page_content");
		}	
	
	## Check if admin or not
	if (is_admin() ) { 
	
	##	Update options if form is submitted
		function update_mompaf_options() {
			global $mompaf_post;
				if(isset($_POST['mompafsave'])){
				if ($_REQUEST["mompaf_post"] != "$mompaf_post" && is_numeric($_REQUEST["mompaf_post"])) { update_option("mompaf_post",$_REQUEST["mompaf_post"]); }
			
			}		
		}
		
	##	Form to save the plugin options from.
		function mompaf_form() {
			global $mompaf_post;
		
			echo "
			
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"mompaf_post\">Choose post</label>
				</th>
				<td>
					<select id=\"mompaf_post\" class=\"regular-text\" type=\"text\" name=\"mompaf_post\">
					<option value=\"\">Most recent post</option>";
						$showmeposts =  get_posts(); 
						foreach ($showmeposts as $postsshown) {
							echo "<option value=\"" . $postsshown->ID . "\">$postsshown->post_title</option>";
						}		
					echo "</select>
				</td>
			</tr>
			";
		}
	
	##	Plugin options page output.
		function mompaf_page_content() {
				echo "
				<div class=\"wrap\">
					<div id=\"icon-options-general\" class=\"icon32\"></div>
					<h2>Post as Front</h2>
					<p>Choose an individual post to be your home page, or choose <em>Most Recent Post</em> to make your home page your most recently published post.</p>
					<p>Will work in conunction with the <em>Simply Exclude</em> module and skip any post that is hidden from the front page.</p>
					<h3 class=\"title\">Settings</h3>
				";
				
				if(isset($_POST['mompafsave'])){
					echo "
						<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>
					";
				}
				
				echo "<form method=\"post\">
					<table class=\"form-table\">
						<tbody>
				";
				mompaf_form();
				echo "
						</tbody>
					</table>
					<p class=\"submit\">
						<input id=\"mompafsave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"mompafsave\"></input>
					</p>
				</form>			
				</div>
				";
		}

				if(isset($_POST["mompafsave"])){
					if ($_REQUEST["mompafsave"]) { 
						update_mompaf_options();
					}
				}		
	
	}
	
	function mompaf_filter_home() {	
		if (is_home()) {
			global $mompaf_post;
			
			if (is_numeric($mompaf_post)){
				$mompaf_front = $mompaf_post;
			} else {
				$mompaf_front = "";
			}
			
			if (have_posts()) : the_post();
			header("location: ".get_permalink($mompaf_front));
			exit;
			endif;
			echo "This is just a test";
		}
	}
	

?>