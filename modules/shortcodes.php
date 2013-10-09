<?php 

	## Module name: Shortcodes!
	## Module contents
	##  options page
	## add shortcodes
	##	Google map embed
	##  Reddit submit button
	
	if(!defined('MyOptionalModules')) {	die('You can not call this file directly.'); }
	
	if (is_admin() ) {

		##  options page
		add_action("admin_menu", "mom_shortcodes_page");
		function mom_shortcodes_page() {$RUPs_options = add_options_page("MOM: Shortcodes!", " &not; MOM: Shortcodes!", "manage_options", "momshorts", "mom_shortcodes_page_content"); }
		
		## options page (output)
		function mom_shortcodes_page_content() { 
			global $theSalt;
			echo "	
				<div class=\"wrap\">
					<div id=\"icon-options-general\" class=\"icon32\"></div>
					<h2>Shortcodes!</h2>
					<p>A collection of shortcodes to use in your posts and pages.</p>
					<p>If a shortcode has parameters, you will use those parameters like this: <em>paramater=\"value\"</em></p>
					
					<table class=\"form-table\" border=\"1\">
						<tbody>
							<tr valign=\"top\">
								[<a href=\"#google_maps\">map</a>] 
								&mdash; [<a href=\"#reddit_button\">reddit</a>]
							</tr>
							<tr valign=\"top\" id=\"google_maps\">
								<td valign=\"top\"><strong>Google Maps</strong><br />Embed a Google map.<br />Based on <a href=\"http://wordpress.org/plugins/very-simple-google-maps/\">Very Simple Google Maps</a> by <a href=\"http://profiles.wordpress.org/masterk/\">Michael Aronoff</a><hr /><br />
								<u>Parameters</u> <br />
								width<br />
								height<br />
								frameborder<br />
								align<br />
								address<br />
								info_window<br />
								zoom<br />
								companycode<br />
								<hr />
								<u>Defaults</u> <br />
								Width: 100% <br />
								Height: 350px <br />
								Frameborder: 0 <br />
								Align: center <br />
								</td>
								<td valign=\"top\">
									<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
									<tbody>
									<tr><td><code>[mom_map address=\"38.573333,-109.549167\"]</code></td><td><em>GPS</em></td></tr>
									<tr><td><iframe align=\"center\" width=\"100%\" height=\"350px\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&q=38.573333%2C-109.549167&amp;cid=&output=embed&z=14&iwloc=A&visual_refresh=true\"></iframe></td></tr>
									<tr><td><code>[mom_map address=\"1600 Pennsylvania Ave NW, Washington, D.C., DC\"]</code></td><td><em>Street Address</em></td></tr>
									<tr><td><iframe align=\"center\" width=\"100%\" height=\"350px\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&q=1600+Pennsylvania+Ave+NW%2C+Washington%2C+D.C.%2C+DC+&amp;cid=&output=embed&z=14&iwloc=A&visual_refresh=true\"></iframe></td></tr>
									</tbody>
									</table>
								</td>
								
							</tr>
							
							<tr valign=\"top\" id=\"reddit_button\">
								<td valign=\"top\"><strong>Reddit button</strong><br />Create a customizable submit button for the current post.<br /><hr /><br />
								<u>Parameters</u><br />
								target<br />
								title<br />
								bgcolor<br />
								border<br />
								<hr />
								<u>Defaults</u> <br />
								title: post title<br />
								bgcolor: transparent<br />
								border (color): transparent<br />
								</td>
								<td valign=\"top\">
									<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
									<tbody>
									<tr><td><code>[mom_reddit]</code></td><td><em>Default</em></td></tr>
									<tr>
										<td>
										<script type=\"text/javascript\">
											reddit_url = \"http://reddit.com/\";
											reddit_target = \"\";
											reddit_title = \"Test\";
											reddit_bgcolor = \"\";
											reddit_bordercolor = \"\";
										</script>
										<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
										</td>
									</tr>			
									<tr><td><code>[mom_reddit target=\"news\"]</code></td><td><em>Targeting <a href=\"http://reddit.com/r/news/\">/r/news</a></em></td></tr>
									<tr>
										<td>
										<script type=\"text/javascript\">
											reddit_url = \"http://reddit.com/\";
											reddit_target = \"news\";
											reddit_title = \"Reddit\";
											reddit_bgcolor = \"\";
											reddit_bordercolor = \"\";
										</script>
										<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
										</td>
									</tr>
									<tr><td><code>[mom_reddit bgcolor=\"000\" border=\"000\"]</code></td><td><em>Black background/border</em></td></tr>
									<tr>
										<td>
										<script type=\"text/javascript\">
											reddit_url = \"http://test.com/\";
											reddit_target = \"\";
											reddit_title = \"Reddit\";
											reddit_bgcolor = \"000\";
											reddit_bordercolor = \"000\";
										</script>
										<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
										</td>
									</tr>
									</tbody>
									</table>
								</td>
							</tr>							
						</tbody>
					</table>					
			";
		}
	}
	
	
	
	## add shortcodes
		## Google map embed 
		add_shortcode('mom_map', 'mom_google_map_shortcode');
		function mom_google_map_shortcode($atts, $content = null) {
			extract(
				shortcode_atts(array(
					"width" => '100%',
					"height" => '350px',
					"frameborder" => '0',
					"align" => 'center',
					"address" => '',
					"info_window" => 'A',
					"zoom" => '14',
					"companycode" => ''
				), $atts)
			);
			$mgms_output = 'q=' . urlencode($address) . '&cid=' . urlencode($companycode);
			echo "
			<div class=\"mom_map\">
				<iframe align=\"" . $align . "\" width=\"" . $width . "\" height=\"" . $height . "\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&amp;" . htmlentities($mgms_output) . "&amp;output=embed&amp;z=" . $zoom . "&amp;iwloc=" . $info_window . "&amp;visual_refresh=true\"></iframe>
			</div>
			";
		}
		
		## Reddit submit button
		add_shortcode('mom_reddit', 'mom_reddit_shortcode');
		function mom_reddit_shortcode($atts, $content = null) {
			global $wpdb, $id, $post_title;
			$query = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND ID = '$id'";
			$reddit = $wpdb->get_results($query);
			if ($reddit) {
				foreach ($reddit as $reddit_info) {
					$post_title = strip_tags($reddit_info->post_title);
				}
			extract(
				shortcode_atts(array(
					"url" => '' . $get_permalink . '',
					"target" => '',
					"title" => '' . $post_title . '',
					"bgcolor" => '',
					"border" => ''
				), $atts)
			);
			echo "
			<script type=\"text/javascript\">
				reddit_url = \"" . $url . "\";
				reddit_target = \"" . $target . "\";
				reddit_title = \"" . $title . "\";
				reddit_bgcolor = \"" . $bgcolor . "\";
				reddit_bordercolor = \"" . $border . "\";
			</script>
			<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
			";
			}
		}			

	
?>