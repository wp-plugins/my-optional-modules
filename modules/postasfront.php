<?php 
// Module name: Post as Front (PAF)
// Module contents
//   - options form (save)
//   - options form (output)
//   - options page (output)
if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }


if(isset($_POST["mompafsave"])){ update_option("mompaf_post",$_REQUEST["mompaf_post"]); } 

if (is_admin() ) { 
	// options form (output)
	function mompaf_form() {
		echo "<div class=\"settingsExtra\"><select id=\"mompaf_post\" type=\"text\" name=\"mompaf_post\">
		<option value=\"0\">Most recent post</option>";
		$showmeposts =  get_posts( array('posts_per_page' => -1 )); 
		foreach ($showmeposts as $postsshown) {
		echo "<option value=\"" . $postsshown->ID . "\""; 
		if (get_option('mompaf_post') == $postsshown->ID) { echo "selected=\"selected\""; }
		echo ">$postsshown->post_title</option>";
		}		
		echo "
		</select>
		<input id=\"mompafsave\" type=\"submit\" value=\"Save\" name=\"mompafsave\"></input></div>";
	}
		
	// options page (output)
	mompaf_form();
}
?>