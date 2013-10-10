<?php 

	## Module name: Simply Exclude (SE)
	## Module contents
	## add action to filter posts
	## options page
	##   - options form (save)
	##   - options form (output)
	##   - options page (output)
	## filter posts action content

	if(!defined('MyOptionalModules')) {	die('You can not call this file directly.'); }
	
	## add action to filter posts
	add_action( "pre_get_posts", "momse_filter_home" );
	
	if (is_admin() ) { 
	
	## options page
	add_action("admin_menu", "momse_add_options_page");
	function momse_add_options_page() {	$obwcountplus_options = add_options_page("MOM: SE", " &not; MOM: SE", "manage_options", "momse", "momse_page_content"); }	
	
	## options form (save)
	function update_momse_options() {
		if(isset($_POST['momsesave'])){
			if ($_REQUEST["simple_announcement_with_exclusion_9"] != "" . get_option('simple_announcement_with_exclusion_9') . "") { update_option("simple_announcement_with_exclusion_9",$_REQUEST["simple_announcement_with_exclusion_9"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_2"] != "". get_option('simple_announcement_with_exclusion_9_2') . "") { update_option("simple_announcement_with_exclusion_9_2",$_REQUEST["simple_announcement_with_exclusion_9_2"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_3"] != "" . get_option('simple_announcement_with_exclusion_9_3') . "") { update_option("simple_announcement_with_exclusion_9_3",$_REQUEST["simple_announcement_with_exclusion_9_3"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_4"] != "" . get_option('simple_announcement_with_exclusion_9_4') . "") { update_option("simple_announcement_with_exclusion_9_4",$_REQUEST["simple_announcement_with_exclusion_9_4"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_5"] != "" . get_option('simple_announcement_with_exclusion_9_5') ."") { update_option("simple_announcement_with_exclusion_9_5",$_REQUEST["simple_announcement_with_exclusion_9_5"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_7"] != "" . get_option('simple_announcement_with_exclusion_9_7') . "") { update_option("simple_announcement_with_exclusion_9_7",$_REQUEST["simple_announcement_with_exclusion_9_7"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_8"] != "" . get_option('simple_announcement_with_exclusion_9_8') ."") { update_option("simple_announcement_with_exclusion_9_8",$_REQUEST["simple_announcement_with_exclusion_9_8"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_9"] != "" . get_option('simple_announcement_with_exclusion_9_9') . "") { update_option("simple_announcement_with_exclusion_9_9",$_REQUEST["simple_announcement_with_exclusion_9_9"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_10"] != "" . get_option('simple_announcement_with_exclusion_9_10') . "") { update_option("simple_announcement_with_exclusion_9_10",$_REQUEST["simple_announcement_with_exclusion_9_10"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_11"] != "" . get_option('simple_announcement_with_exclusion_9_11') . "") { update_option("simple_announcement_with_exclusion_9_11",$_REQUEST["simple_announcement_with_exclusion_9_11"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_12"] != "" . get_option('simple_announcement_with_exclusion_9_12') . "") { update_option("simple_announcement_with_exclusion_9_12",$_REQUEST["simple_announcement_with_exclusion_9_12"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_13"] != "" . get_option('simple_announcement_with_exclusion_9_13') . "") { update_option("simple_announcement_with_exclusion_9_13",$_REQUEST["simple_announcement_with_exclusion_9_13"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_9_14"] != "" . get_option('simple_announcement_with_exclusion_9_14') . "") { update_option("simple_announcement_with_exclusion_9_14",$_REQUEST["simple_announcement_with_exclusion_9_14"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_sun"] != "" . get_option('simple_announcement_with_exclusion_sun') . "") { update_option("simple_announcement_with_exclusion_sun",$_REQUEST["simple_announcement_with_exclusion_sun"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_mon"] != "" . get_option('simple_announcement_with_exclusion_mon') . "") { update_option("simple_announcement_with_exclusion_mon",$_REQUEST["simple_announcement_with_exclusion_mon"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_tue"] != "" . get_option('simple_announcement_with_exclusion_tue') . "") { update_option("simple_announcement_with_exclusion_tue",$_REQUEST["simple_announcement_with_exclusion_tue"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_wed"] != "" . get_option('simple_announcement_with_exclusion_wed') . "") { update_option("simple_announcement_with_exclusion_wed",$_REQUEST["simple_announcement_with_exclusion_wed"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_thu"] != "" . get_option('simple_announcement_with_exclusion_thu') . "") { update_option("simple_announcement_with_exclusion_thu",$_REQUEST["simple_announcement_with_exclusion_thu"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_fri"] != "" . get_option('simple_announcement_with_exclusion_fri') . "") { update_option("simple_announcement_with_exclusion_fri",$_REQUEST["simple_announcement_with_exclusion_fri"]); }
			if ($_REQUEST["simple_announcement_with_exclusion_sat"] != "" . get_option('simple_announcement_with_exclusion_sat') . "") { update_option("simple_announcement_with_exclusion_sat",$_REQUEST["simple_announcement_with_exclusion_sat"]); }
		
		}		
	}
		
	## options form (output)
		function momse_form() {
			echo "
				<tr valign=\"top\" id=\"reddit_button\">
					<th scope=\"row\"><strong>Categories</strong><br /><hr />
					Usage:<br />
					<p>Comma separated lists for multiple exclusions (or single ids).</p>
					<p>Example: 1,2,3</p></th>
					<td>
			";
					$showmecats =  get_categories('taxonomy=category'); 
					echo "<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
					<tr><td>Category</td><td>ID</td></tr>";
					foreach ($showmecats as $catsshown) {
						echo "<tr><td><strong>",$catsshown->cat_name,"</strong></td><td><em>",$catsshown->cat_ID,"</em></td></tr>";
					}		
					echo "</table>";
			echo "
					</td>
				<td valign=\"top\">
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
				<tbody>				
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_12\">Hide from RSS</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9_12\" name=\"simple_announcement_with_exclusion_9_12\" value=\"" . get_option('simple_announcement_with_exclusion_9_12') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9\">Hide from front page</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9\" name=\"simple_announcement_with_exclusion_9\" value=\"" . get_option('simple_announcement_with_exclusion_9') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_2\">Hide from tag archives</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9_2\" name=\"simple_announcement_with_exclusion_9_2\" value=\"" . get_option('simple_announcement_with_exclusion_9_2') . "\">
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_3\">Hide from search results</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9_3\" name=\"simple_announcement_with_exclusion_9_3\" value=\"" . get_option('simple_announcement_with_exclusion_9_3') . "\">
				</tr>	
				</tbody>
				</table>
				</td>
				</tr>
				<tr valign=\"top\" id=\"reddit_button\" style=\"background-color:#f4faff;\">
					<th scope=\"row\"><strong>Tags</strong><br /><hr />
					Usage:<br />
					<p>Comma separated lists for multiple exclusions (or single ids).</p>
					<p>Example: 1,2,3</p>					
					</th>
					<td>
			";
						$showmetags =  get_categories('taxonomy=post_tag'); 
						echo "<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
						<tr><td>Tag</td><td>ID</td></tr>";
						foreach ($showmetags as $tagsshown) {
							echo "<tr><td><strong>",$tagsshown->cat_name,"</strong></td><td><em>",$tagsshown->cat_ID,"</em></td></tr>";
						}		
						echo "</table>";
			echo "
					</td>
				<td valign=\"top\">
				<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
				<tbody>
				<tr>
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_13\">Hide from RSS</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9_13\" name=\"simple_announcement_with_exclusion_9_13\" value=\"" . get_option('simple_announcement_with_exclusion_9_13') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_4\">Hide from front page</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9_4\" name=\"simple_announcement_with_exclusion_9_4\" value=\"" . get_option('simple_announcement_with_exclusion_9_4') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_5\">Hide from category archives</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9_5\" name=\"simple_announcement_with_exclusion_9_5\" value=\"" . get_option('simple_announcement_with_exclusion_9_5') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_7\">Hide from search results</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_9_7\" name=\"simple_announcement_with_exclusion_9_7\" value=\"" . get_option('simple_announcement_with_exclusion_9_7') . "\"></td>
				</tr>			
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_sun\">Hide on Sunday</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_sun\" name=\"simple_announcement_with_exclusion_sun\" value=\"" . get_option('simple_announcement_with_exclusion_sun') . "\"></td>
				</tr>				
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_mon\">Hide on Monday</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_mon\" name=\"simple_announcement_with_exclusion_mon\" value=\"" . get_option('simple_announcement_with_exclusion_mon') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_tue\">Hide on Tuesday</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_tue\" name=\"simple_announcement_with_exclusion_tue\" value=\"" . get_option('simple_announcement_with_exclusion_tue') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_wed\">Hide on Wednesday</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_wed\" name=\"simple_announcement_with_exclusion_wed\" value=\"" . get_option('simple_announcement_with_exclusion_wed') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_thu\">Hide on Thursday</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_thu\" name=\"simple_announcement_with_exclusion_thu\" value=\"" . get_option('simple_announcement_with_exclusion_thu') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_fri\">Hide on Friday</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_fri\" name=\"simple_announcement_with_exclusion_fri\" value=\"" . get_option('simple_announcement_with_exclusion_fri') . "\"></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_sat\">Hide on Saturday</label></th>
					<td><input type=\"text\" id=\"simple_announcement_with_exclusion_sat\" name=\"simple_announcement_with_exclusion_sat\" value=\"" . get_option('simple_announcement_with_exclusion_sat') . "\"></td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>

				<tr valign=\"top\" id=\"reddit_button\">
				<th scope=\"row\"><strong>Post formats</strong></th>
				<td valign=\"top\"></td>
					<td valign=\"top\">
					<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
					<tbody>
					<tr>
						<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_14\">Hide from RSS</label></th>
						<td><select name=\"simple_announcement_with_exclusion_9_14\" id=\"simple_announcement_with_exclusion_9_14\">
								<option value=\"\">none</option>
								<option value=\"post-format-aside\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-aside") { echo " selected=\"selected\""; } echo ">Aside</option>
								<option value=\"post-format-gallery\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-gallery") { echo " selected=\"selected\""; } echo ">Gallery</option>
								<option value=\"post-format-link\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-link") { echo " selected=\"selected\""; } echo ">Link</option>
								<option value=\"post-format-image\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-image") { echo " selected=\"selected\""; } echo ">Image</option>
								<option value=\"post-format-quote\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-quote") { echo " selected=\"selected\""; } echo ">Quote</option>
								<option value=\"post-format-status\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-status") { echo " selected=\"selected\""; } echo ">Status</option>
								<option value=\"post-format-video\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-video") { echo " selected=\"selected\""; } echo ">Video</option>
								<option value=\"post-format-audio\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-audio") { echo " selected=\"selected\""; } echo ">Audio</option>
								<option value=\"post-format-chat\"";if (get_option('simple_announcement_with_exclusion_9_14') === "post-format-chat") { echo " selected=\"selected\""; } echo ">Chat</option>
							</select>
						</td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_14\">Hide from front page</label></th>
						<td><select name=\"simple_announcement_with_exclusion_9_8\" id=\"simple_announcement_with_exclusion_9_8\">
								<option value=\"\">none</option>
								<option value=\"post-format-aside\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-aside") { echo " selected=\"selected\""; } echo ">Aside</option>
								<option value=\"post-format-gallery\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-gallery") { echo " selected=\"selected\""; } echo ">Gallery</option>
								<option value=\"post-format-link\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-link") { echo " selected=\"selected\""; } echo ">Link</option>
								<option value=\"post-format-image\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-image") { echo " selected=\"selected\""; } echo ">Image</option>
								<option value=\"post-format-quote\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-quote") { echo " selected=\"selected\""; } echo ">Quote</option>
								<option value=\"post-format-status\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-status") { echo " selected=\"selected\""; } echo ">Status</option>
								<option value=\"post-format-video\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-video") { echo " selected=\"selected\""; } echo ">Video</option>
								<option value=\"post-format-audio\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-audio") { echo " selected=\"selected\""; } echo ">Audio</option>
								<option value=\"post-format-chat\"";if (get_option('simple_announcement_with_exclusion_9_8') === "post-format-chat") { echo " selected=\"selected\""; } echo ">Chat</option>
							</select>
						</td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_14\">Hide from archives</label></th>
						<td><select name=\"simple_announcement_with_exclusion_9_9\" id=\"simple_announcement_with_exclusion_9_9\">
								<option value=\"\">none</option>
								<option value=\"post-format-aside\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-aside") { echo " selected=\"selected\""; } echo ">Aside</option>
								<option value=\"post-format-gallery\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-gallery") { echo " selected=\"selected\""; } echo ">Gallery</option>
								<option value=\"post-format-link\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-link") { echo " selected=\"selected\""; } echo ">Link</option>
								<option value=\"post-format-image\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-image") { echo " selected=\"selected\""; } echo ">Image</option>
								<option value=\"post-format-quote\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-quote") { echo " selected=\"selected\""; } echo ">Quote</option>
								<option value=\"post-format-status\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-status") { echo " selected=\"selected\""; } echo ">Status</option>
								<option value=\"post-format-video\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-video") { echo " selected=\"selected\""; } echo ">Video</option>
								<option value=\"post-format-audio\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-audio") { echo " selected=\"selected\""; } echo ">Audio</option>
								<option value=\"post-format-chat\"";if (get_option('simple_announcement_with_exclusion_9_9') === "post-format-chat") { echo " selected=\"selected\""; } echo ">Chat</option>
							</select>
						</td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_14\">Hide from tag archives</label></th>
						<td><select name=\"simple_announcement_with_exclusion_9_10\" id=\"simple_announcement_with_exclusion_9_10\">
							<option value=\"\">none</option>
							<option value=\"post-format-aside\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-aside") { echo " selected=\"selected\""; } echo ">Aside</option>
							<option value=\"post-format-gallery\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-gallery") { echo " selected=\"selected\""; } echo ">Gallery</option>
							<option value=\"post-format-link\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-link") { echo " selected=\"selected\""; } echo ">Link</option>
							<option value=\"post-format-image\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-image") { echo " selected=\"selected\""; } echo ">Image</option>
							<option value=\"post-format-quote\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-quote") { echo " selected=\"selected\""; } echo ">Quote</option>
							<option value=\"post-format-status\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-status") { echo " selected=\"selected\""; } echo ">Status</option>
							<option value=\"post-format-video\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-video") { echo " selected=\"selected\""; } echo ">Video</option>
							<option value=\"post-format-audio\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-audio") { echo " selected=\"selected\""; } echo ">Audio</option>
							<option value=\"post-format-chat\"";if (get_option('simple_announcement_with_exclusion_9_10') === "post-format-chat") { echo " selected=\"selected\""; } echo ">Chat</option>
							</select>
						</td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"simple_announcement_with_exclusion_9_14\">Hide from search results</label></th>
						<td><select name=\"simple_announcement_with_exclusion_9_11\" id=\"simple_announcement_with_exclusion_9_11\">
							<option value=\"\">none</option>
							<option value=\"post-format-aside\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-aside") { echo " selected=\"selected\""; } echo ">Aside</option>
							<option value=\"post-format-gallery\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-gallery") { echo " selected=\"selected\""; } echo ">Gallery</option>
							<option value=\"post-format-link\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-link") { echo " selected=\"selected\""; } echo ">Link</option>
							<option value=\"post-format-image\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-image") { echo " selected=\"selected\""; } echo ">Image</option>
							<option value=\"post-format-quote\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-quote") { echo " selected=\"selected\""; } echo ">Quote</option>
							<option value=\"post-format-status\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-status") { echo " selected=\"selected\""; } echo ">Status</option>
							<option value=\"post-format-video\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-video") { echo " selected=\"selected\""; } echo ">Video</option>
							<option value=\"post-format-audio\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-audio") { echo " selected=\"selected\""; } echo ">Audio</option>
							<option value=\"post-format-chat\"";if (get_option('simple_announcement_with_exclusion_9_11') === "post-format-chat") { echo " selected=\"selected\""; } echo ">Chat</option>
							</select>
						</td>
					</tr>
				</tbody>
				</table>
				</td>
				</tr>
			";
		}
	
	## options page (output)
		function momse_page_content() {
				echo "
					<div class=\"wrap\">
						<div id=\"icon-options-general\" class=\"icon32\"></div>
						<h2>Simply Exclude</h2>
						<p>Exclude categories, tags, and post formats from archive views, category views, tag archives, search results, the RSS feed, or the front page.</p>		
						<h3 class=\"title\">Settings</h3>
				";
					if(isset($_POST['momsesave'])){ echo "<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>"; }
					echo "<form method=\"post\">
						<table class=\"form-table\" border=\"1\">
							<tbody>
					";
					momse_form();
					echo "
							</tbody>
						</table>
						<p class=\"submit\"><input id=\"momsesave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"momsesave\"></input></p>
					</form>
					</div>
				";
		}
		if(isset($_POST["momsesave"])){ update_momse_options();	}		
	}

	## filter posts action content
	function momse_filter_home( $query ) {	
		$simple_announcement_with_exclusion_9 = get_option('simple_announcement_with_exclusion_9');
		$simple_announcement_with_exclusion_9_2 = get_option('simple_announcement_with_exclusion_9_2');
		$simple_announcement_with_exclusion_9_3 = get_option('simple_announcement_with_exclusion_9_3');
		$simple_announcement_with_exclusion_9_4 = get_option('simple_announcement_with_exclusion_9_4');
		$simple_announcement_with_exclusion_9_5 = get_option('simple_announcement_with_exclusion_9_5');
		$simple_announcement_with_exclusion_9_7 = get_option('simple_announcement_with_exclusion_9_7');
		$simple_announcement_with_exclusion_9_8 = get_option('simple_announcement_with_exclusion_9_8');
		$simple_announcement_with_exclusion_9_9 = get_option('simple_announcement_with_exclusion_9_9');
		$simple_announcement_with_exclusion_9_10 = get_option('simple_announcement_with_exclusion_9_10');
		$simple_announcement_with_exclusion_9_11 = get_option('simple_announcement_with_exclusion_9_11');
		$simple_announcement_with_exclusion_9_12 = get_option('simple_announcement_with_exclusion_9_12');
		$simple_announcement_with_exclusion_9_13 = get_option('simple_announcement_with_exclusion_9_13');
		$simple_announcement_with_exclusion_9_14 = get_option('simple_announcement_with_exclusion_9_14');
		if (date("D") === "Sun") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_sun'); }
		if (date("D") === "Mon") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_mon'); }
		if (date("D") === "Tue") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_tue'); } 
		if (date("D") === "Wed") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_wed'); }
		if (date("D") === "Thu") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_thu'); }
		if (date("D") === "Fri") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_fri'); }
		if (date("D") === "Sat") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_sat'); }

		$rss_day = explode(',', $simple_announcement_with_exclusion_day);
		foreach ($rss_day as &$rss_day_1) { $rss_day_1 = "".$rss_day_1.","; }
		$rss_day_1 = implode($rss_day);		
		$rssday = explode(',', str_replace(' ', '', $rss_day_1));
		
		if ($query->is_feed) {
			$rss1 = explode(',', $simple_announcement_with_exclusion_9_12);
			foreach ($rss1 as &$RSS1) { $RSS1 = "".$RSS1.","; }
			$rss_1 = implode($rss1);		
			$rss11 = explode(',', str_replace(' ', '', $rss_1));
			$rss2 = explode(',', $simple_announcement_with_exclusion_9_13);
			foreach ($rss2 as &$RSS2) { $RSS2 = "".$RSS2.","; }
			$rss_2 = implode($rss2);		
			$rss22 = explode(',', str_replace(' ', '', $rss_2));
			$tax_query = array(
				'relation' => 'AND OR',
				array(
					'taxonomy' => 'category',
					'terms' => $rss11,
					'field' => 'id',
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'post_tag',
					'terms' => $rss22,
					'field' => 'id',
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array( $simple_announcement_with_exclusion_9_14 ),
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'post_tag',
					'terms' => $rssday,
					'field' => 'id',
					'operator' => 'NOT IN'
				),				
			);
			$query->set( 'tax_query', $tax_query );						
		}
			
		if ( $query->is_main_query() && !is_admin() ) {
			if ( $query->is_home() ) {
				$c1 = explode(',', $simple_announcement_with_exclusion_9);
				foreach ($c1 as &$C1) { $C1 = "".$C1.","; }
				$c_1 = implode($c1);		
				$c11 = explode(',', str_replace(' ', '', $c_1));
				$t1 = explode(',', $simple_announcement_with_exclusion_9_4);
				foreach ($t1 as &$T1) { $T1 = "".$T1.","; }
				$t_1 = implode($t1);		
				$t11 = explode(',', str_replace(' ', '', $t_1));
			
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $c11,
						'field' => 'id',
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $t11,
						'field' => 'id',
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_8 ),
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),
				);
				$query->set( 'tax_query', $tax_query );
			}

			elseif ( $query->is_category()) {
				$t2 = explode(',', $simple_announcement_with_exclusion_9_5);
				foreach ($t2 as &$T2) { $T2 = "".$T2.","; }
				$t_2 = implode($t2);
				$t22 = explode(',', str_replace(' ', '', $t_2));
					
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'post_tag',
						'terms' => $t22,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_9 ),
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),					
				);
				$query->set( 'tax_query', $tax_query );				
			}

			elseif ( $query->is_tag() ) {
				$c3 = explode(',', $simple_announcement_with_exclusion_9_2);
				foreach ($c3 as &$C3) { $C3 = "".$C3.","; }
				$c_3 = implode($c3);
				$c33 = explode(',', str_replace(' ', '', $c_3));
			
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $c33,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_10 ),
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),					
				);
				$query->set( 'tax_query', $tax_query );
			}		

			elseif ( $query->is_search() ) {
				$c4 = explode(',', $simple_announcement_with_exclusion_9_3);
				foreach ($c4 as &$C4) { $C4 = "".$C4.","; }
				$c_4 = implode($c4);		
				$c44 = explode(',', str_replace(' ', '', $c_4));
				$t4 = explode(',', $simple_announcement_with_exclusion_9_7);
				foreach ($t4 as &$T4) { $T4 = "".$T4.","; }
				$t_4 = implode($t4);		
				$t44 = explode(',', str_replace(' ', '', $t_4));			
					
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $c44,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $t44,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_11 ),
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),					
				);
				$query->set( 'tax_query', $tax_query );					
			}
		}
	}
?>