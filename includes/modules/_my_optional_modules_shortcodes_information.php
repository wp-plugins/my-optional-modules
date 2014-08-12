<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

if(current_user_can('manage_options')){
	function my_optional_modules_shortcodes_module(){
			echo '
				<p>
					<strong class="sectionTitle">Archives</strong>
					<em>Output a column list of categories, with post count and link to latest post in each.</em><br />
					&mdash; Shortcode: [mom_archives]<br />
					&mdash; there are no paramaters
					&mdash; will follow all rules set by the exclude module
				</p>
				<p>
					<strong class="sectionTitle">Google Maps</strong>
					<em>Embed a Google map, with optional paramaters.</em><br />
					&mdash; Shortcode: [mom_map]<br />
					&mdash; width, height, frameborder, align, address, info_window, zoom, companycode<br />
					&mdash; <em>Notes on the address attribute</em>:<br />
					&mdash;&mdash; Address examples(38.573333, -109.549167)(1600 Pennsylvania AVE NW, Washington, D.C., DC)<br />
					&mdash; Shortcode default attributes:<br />
					&mdash; width (100%), height (350px), frameborder (0), align (center)
				</p>
				<p>
					<strong class="sectionTitle">Reddit Button</strong>
					<em>Create a customizable submit button for the current post.</em><br />
					&mdash; Targeting a specific subreddit: [mom_reddit target="news"]<br />
					&mdash; Customizing appearance: [mom_reddit bgcolor="000" border="000"]<br />
					&mdash; Shortcode: [mom_reddit]<br />
					&mdash; Parameters: target, title, bgcolor, border<br />
					&mdash; Shortcode default attributes:<br />
					&mdash; title (the title of the current post), bgcolor (transparent), border (transparent)<br />
					&mdash; container: div.mom_reddit
				</p>
				<p>
					<strong class="sectionTitle">Restrict content to logged in users</strong>
					<em>Restrict the viewing of content to users who are logged in (including commenting and viewing comments)</em><br />
					&mdash; Shortcode: [mom_restrict] Content to hide [/mom_restrict]<br />
					&mdash; Paramters: message, comments<br />
					&mdash; Comments and comment form are hidden:<br />
					&mdash;&mdash; [mom_restrict comments="1"]Some content [/mom_restrict]<br />
					&mdash; Comment form is hidden: [mom_restrict comments="2"] Some content [/mom_restrict]<br />
					&mdash; Shortcode default attributes:<br />
					&mdash; message (You must be logged in to view this content.)<br />
					&mdash; container: div.mom_restrict
				</p>
				<p>
					<strong class="sectionTitle">Progress Bars</strong>
					<em>Create bars that fill up, based on specific set parameters.</em><br />
					&mdash; Shortcode: [mom_progress]<br />
					&mdash; Parameters: align, fillcolor, maincolor, height, level, margin, width<br />
					&mdash; Fill 10%: [mom_progress level="10"]<br />
					&mdash; Fill 70% with custom colors: [mom_progress level="70" maincolor="#ff0000" fillcolor="#009cff"]<br />
					&mdash; Fill 70% with custom height: [mom_progress level="70" height="50"]<br />
					&mdash; Shortcode default attributes:<br />
					&mdash; align (none), fillcolor (#ccc), maincolor (#000), height (15), level (0), margin (0 auto), width (95%)<br />
					&mdash; container: div.mom_progress
				</p>
				<p>
					<strong class="sectionTitle">On this day</strong>
					<em>Embed a small post loop that grabs posts for the current day from previous years.</em><br />
					&mdash; Shortcode: [mom_onthisday]<br />
					&mdash; Display past posts from this category only:<br />
					&mdash;&mdash; [mom_onthisday cat="current"]<br />
					&mdash; Display 2 past posts in a div with the title "Previous years":<br />
					&mdash;&mdash; [mom_onthisday title="previous years" amount="2"]<br />
					&mdash; Paramaters: cat, amount, title<br />
					&mdash; Template tag: mom_onthisday_template()
				</p>
				<p></p>
				<form class="clear" method="post" action="" name="momShortcodes"><label for="mom_shortcodes_mode_submit"><i class="fa fa-ban">&mdash;</i> Click to Deactivate Shortcodes Module</label><input type="text" class="hidden" value="';if(get_option('mommaincontrol_shorts') == 1){echo '0';}else{echo '1';}echo '" name="shortcodes" /><input type="submit" id="mom_shortcodes_mode_submit" name="mom_shortcodes_mode_submit" value="Submit" class="hidden" /></form>';
	}
}