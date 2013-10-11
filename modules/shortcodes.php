<?php 

	## Module name: Shortcodes!
	## Module contents
	##  options page
	## add shortcodes
	##	Google map embed
	##  Reddit submit button
	##  Restrict content to logged in users
	
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
					
					<table class=\"form-table\" border=\"1\">
						<tbody>
							<tr valign=\"top\">
								<p>[<a href=\"#google_maps\">map</a>] 
								&mdash; [<a href=\"#reddit_button\">reddit</a>] 
								&mdash; [<a href=\"#restrict\">restrict content to logged in users</a>]</p>
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
								<hr />
								div class .mom_map
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
							
							<tr valign=\"top\" id=\"reddit_button\" style=\"background-color:#f4faff;\">
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
								<hr />
								div class .mom_reddit
								</td>
								<td valign=\"top\">
									<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
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

							<tr valign=\"top\" id=\"restrict\">
								<td valign=\"top\"><strong>Restrict content to logged in users</strong><br />Restrict content to users who are not logged in, including commenting or viewing comments.<br /><hr /><br />
								<u>Parameters</u><br />
								message<br />
								comments<br />
								<hr />
								<u>Defaults</u> <br />
								message: You must be logged in to view this content.
								<hr />
								div class .mom_restrict
								</td>
								<td valign=\"top\">
									<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
									<tbody>
									<tr><td><code>[mom_restrict]some content[/mom_restrict]</code></td><td><em>Default</em></td></tr>
									<tr>
										<td>
										Logged in users see:<br />
										some content
										<p>
										Users who are not logged in see:<br />
										You must be logged in to view this content.</p>
										</td>
									</tr>
									<tr><td><code>[mom_restrict comments=\"1\" message=\"Log in to view this content!\"]some content[/mom_restrict]</code></td><td><em>Comments and form are hidden</em></td></tr>
									<tr>
										<td>
										Logged in users see:<br />
										some content
										<p>
										Users who are not logged in see:<br />
										Log in to view this content!<br />
										(<em>Comment form and comments are hidden.)</em>)
										</p>
										</td>
									</tr>
									<tr><td><code>[mom_restrict comments=\"2\" message=\"Log in to view this content!\"]some content[/mom_restrict]</code></td><td><em>Comment form is hidden</em></td></tr>
									<tr>
										<td>
										Logged in users see:<br />
										some content
										<p>
										Users who are not logged in see:<br />
										Log in to view this content!<br />
										(<em>Comment form is hidden</em>)
										</p>
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
		add_filter('the_content', 'do_shortcode', 'mom_map');
		function mom_google_map_shortcode($atts, $content = null) {
		ob_start();
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
			return ob_get_clean();
		}
		
		## Reddit submit button
		add_shortcode('mom_reddit', 'mom_reddit_shortcode');
		add_filter('the_content', 'do_shortcode', 'mom_reddit');
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
			ob_start();
			echo "
			<div class=\"mom_reddit\">
			<script type=\"text/javascript\">
				reddit_url = \"" . $url . "\";
				reddit_target = \"" . $target . "\";
				reddit_title = \"" . $title . "\";
				reddit_bgcolor = \"" . $bgcolor . "\";
				reddit_bordercolor = \"" . $border . "\";
			</script>
			<script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
			</div>
			";
			return ob_get_clean();
			}
		}

		## Restrict content to logged in users
		add_shortcode('mom_restrict', 'mom_restrict_shortcode');
		add_filter('the_content', 'do_shortcode', 'mom_restrict');
		function mom_restrict_shortcode($atts, $content = null) {
			extract(
					shortcode_atts(array(
					"message" => 'You must be logged in to view this content.',
					"comments" => '',
					"form" => ''
				), $atts)
			);
			ob_start();
			if ( is_user_logged_in() ) {
				return $content;
			} else {
				echo "<div class=\"mom_restrict\">" . htmlentities($message) . "</div>";
				if ($comments == "1") {
					add_filter( 'comments_template', 'restricted_comments_view' );
					function restricted_comments_view( $comment_template ) {
						return dirname( __FILE__) . '/comment_template.php';
					}
				}
				if ($comments == "2") {
					add_filter( 'comments_open', 'restricted_comments_form', 10, 2 );
					function restricted_comments_form( $open, $post_id ) {
						$post = get_post( $post_id );
						$open = false;
						return $open;
					}	
				}
				
			}		
			return ob_get_clean();
		}
?>