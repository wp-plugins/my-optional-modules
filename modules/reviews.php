<?php 

	// Module name: Reviews
	//  add shortcode
	//  options page
	//   - options form (save)
	//   - options form (output)
	//   - options page (output)
	//  shortcode content
	
	if(!defined('MyOptionalModules')) {	die('You can not call this file directly.'); }
	$mom_review_global = 0;

	//  add shortcode
	add_shortcode('momreviews', 'mom_reviews_shortcode');	
	add_filter('the_content', 'do_shortcode', 'mom_reviews_shortcode');	

	if (is_admin() ) {
		//  options page
		add_action("admin_menu", "mom_reviews_options_add_options_page");
		function mom_reviews_options_add_options_page() {$reviews_options = add_options_page("MOM: Reviews", " &not; MOM: Reviews", "manage_options", "momreviews", "reviews_page_content"); }

		
		// options form (save)
		function update_mom_reviews() {
			global $table_prefix, $table_suffix, $wpdb;
			$reviews_table_name = $table_prefix . $table_suffix . 'momreviews';			
				$reviews_type = $_REQUEST["reviews_type"];
				$reviews_link = $_REQUEST["reviews_link"];
				$reviews_title = $_REQUEST["reviews_title"];
				$reviews_reviewed = $_REQUEST["reviews_review"];
				$reviews_review = wpautop($reviews_reviewed);
				$reviews_rating = $_REQUEST["reviews_rating"]; 
				$wpdb->query("INSERT INTO $reviews_table_name (ID,TYPE,LINK,TITLE,REVIEW,RATING) VALUES ('','$reviews_type','$reviews_link','$reviews_title','$reviews_review','$reviews_rating')") ;
				echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
		}
		function update_mom_css() {
			$newCSS = stripslashes_deep($_REQUEST["css"]);
			update_option("momreviews_css",$newCSS); 
			echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
		}
		
		// options form (output)
		function print_mom_reviews_form() {
			echo "
				<td valign=\"top\">
					<form method=\"post\">
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
							<tbody>
								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_title\" placeholder=\"Review title\"></td></tr>
								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_type\" placeholder=\"Review type\"></td></tr>
								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_link\" placeholder=\"Relevant URL\" ></td></tr>
								
								<tr valign=\"top\"><td>";
									the_editor($content, $name = 'reviews_review', $id = 'reviews_review', $prev_id = 'title', $media_buttons = false, $tab_index = 2);
								echo "</td></tr>

								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_rating\" placeholder=\"Your rating\"></td></tr>
								<tr valign=\"top\"><td><input id=\"reviewsubmit\" class=\"button button-primary\" type=\"submit\" value=\"Add review\" name=\"reviewsubmit\"></input></td></tr>	
							</tbody>
						</table>
					</form>

				<form method=\"post\">
					<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
						<tbody>
								<tr valign=\"top\"><td>
									<div class=\"momreview\">
										<article class=\"block\">
											<input type=\"checkbox\" name=\"momreview\" id=\"test\" />
											<label for=\"test\">Title<span>+</span><span>-</span></label>
											<section class=\"reviewed\">
												<em>Review type</em> &mdash;
												<a href=\"http://onebillionwords.com/\">#</a>
												<hr />
												<p>This is your review.  It will be formatted with the appropriate HTML, and 
												even images (if you have added any).</p>
												<p>This is just a <em>display purposes only</em> block to show you how your css
												will affect the display.</p>
												<p><em>Helpful</em></p>
											</section>
										</article>
									</div>
								</td></tr>
								<tr valign=\"top\"><td><textarea name=\"css\">" . get_option('momreviews_css') . "</textarea></td></tr>
								<tr valign=\"top\"><td><input id=\"csssubmit\" class=\"button button-primary\" type=\"submit\" value=\"Save CSS\" name=\"csssubmit\"></input></td></tr>
						</tbody>
					</table>
				</form>

				
				</td>
				

			";
		}

		// options page (output)
		function reviews_page_content() {
			echo "	
			<div class=\"wrap\">
				<div id=\"icon-options-general\" class=\"icon32\"></div>
				<h2>Reviews</h2>
			";
			if ($_REQUEST["reviewsubmit"]) { update_mom_reviews(); }
			if ($_REQUEST["csssubmit"]) { update_mom_css(); }
			echo "
				<h3 class=\"title\">Add a review</h3>
				<table class=\"form-table\" border=\"1\">
					<tbody>
						<tr>
							<td valign=\"top\"><strong>Usage</strong><br />
								<blockquote><ol>
									<li>Review title is the title of the review.</li>
									<li>Review type can be anything: book, movie, cd, ponytail, whatever.</li>
									<li>Relevant URL (if used) should link to something relevant to the review; if you're reviewing a film, link 
									to the IMDB page.  If you're reviewing a book, link to the author's website.  It's optional, however.</li>
									<li>Use the text field to write a review.  Use HTML if you want to.</li>
									<li>Rating can be anything: It sucked!, 5 out of 10, jolly rancher!, whatever.</li>
									<li>Use the table below to delete specific reviews.</li>
									<li>Shortcodes may not execute properly in the review table below, although they may display normally on your live site. (Check and make sure before you delete a review thinking you've made a mistake.)</li>
								</ol>
								<ol>
									<li><code>[momreviews]</code> = all reviews</li>
									<li><code>[momreviews type=\"'type'\"]</code>/<code>[momreviews type=\"1\"] = reviews from review type <em>type</em></li>
									<li><code>[momreviews type=\"'type1','type2','type3'\"]</code> = reviews from reviews types <em>type1, type2, and type3</em>.</code>.</li>
								</ol>
								<ol>
									<li>The shortcode accepts a variety of options.:</li>
									<li> &mdash; type <strong>or</strong> id (default is blank) : parameters explained above (see code with list of types or single type usage above.) <strong>or</strong> the id of the particular review you want to display (as found in the table below).  (Either or, but not both type and id can be used.)</li>
									<li> &mdash; orderby (default is ID) : available parameters: ID,TYPE,LINK,TITLE,REVIEW,RATING.  Usage: <code>[momreviews orderby=\"LINK\"]</code></li>
									<li> &mdash;&mdash; ID is the ID of the review, and will increment by 1 sequentially with each new review added to the database. </li>
									<li> &mdash;&mdash; TYPE is the kind of review you are adding (if any).</li>
									<li> &mdash;&mdash; LINK is the relevant URL you have attached to your review (if any).</li>
									<li> &mdash;&mdash; TITLE is the title of the review (if any).</li>
									<li> &mdash;&mdash; REVIEW is the review itself for the item in question (if any).</li>
									<li> &mdash;&mdash; RATING is the rating you gave it (if any).</li>
									<li> &mdash; order (default is DESC) : available parameters: DESC or ASC. Usage: <code>[momreviews order=\"DESC\"]</code></li>
									<li> &mdash; meta (default is 1) : 1 is to show meta values (review type, rating, and relevant link).  0 is to hide this section altogether.  Usage: <code>[momreviews meta=\"1\"]</code></li>
									<li> &mdash; expand (default is +) : what to show (on the right) when a review is collapsed.</li>
									<li> &mdash; retract (default is -) : what to show (on the right) when a review is expanded.</li>
									<li> &mdash;&mdash; if using Font Awesome, use <code>expand=\"&lt;i class='fa fa-arrow-down'>&lt;/i>\"</code> and <code>retract=\"&lt;i class='fa fa-arrow-up'>&lt;/i>\"</code> (examples) as your expand and retract display.</li>
									<li>Multiple parameter usage: <code>[momreviews type=\"'book'\" orderby=\"TITLE\" order=\"DESC\" meta=\"0\" expand=\"Show\" retract=\"Hide\"]</code>
								</blockquote>

				<hr />
				<table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
					<tbody>							
					<tr valign=\"top\">
					<td></td>
					<td>Filter these results</td>
					<form method=\"post\" class=\"reviews_item_form\">
						<td><input type=\"text\" name=\"filterResults_type\" placeholder=\"Filter by type\"></td>
						<td><input type=\"submit\" name=\"filterResults\" value=\"Accept\"></td>
					</form>
					</tr>
					<tr valign=\"top\">
					<td><strong>ID</strong></td>
					<td><strong>Type</strong></td>
					<td><strong>Content</strong></td>
					<td><strong>Delete</strong></td>
					</tr>
<style>
textarea, input[type='text'] { width: 100%; display:block; cursor:pointer;}
textarea { height: 250px; }
" . get_option('momreviews_css') . "
</style>
			";
					global $wpdb;
					$mom_reviews_table_name = $wpdb->prefix . "momreviews";
					if (isset($_POST["filterResults"]) && $_REQUEST["filterResults_type"] != ""){
					$filter_type = $_REQUEST["filterResults_type"];		
					$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE = '$filter_type' ORDER BY ID DESC");
					} else {
					$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
					}
					foreach ($reviews as $reviews_results) {
						$this_ID = $reviews_results->ID;
							echo "<tr><td>" . $this_ID . "</td>
							<td>" . $reviews_results->TYPE . "</td>
							<td>
							<div class=\"momreview\">
								<article class=\"block\">
									<input type=\"checkbox\" name=\"momreview\" id=\"" . $this_ID . "\" />
									<label for=\"" . $this_ID . "\">" .  $reviews_results->TITLE . "<span>+</span><span>-</span></label>
									<section class=\"reviewed\">
										<em>" . $reviews_results->TYPE . "</em> &mdash; ";
										if ($reviews_results->LINK != "") { echo "<a href=\"" . $reviews_results->LINK . "\">#</a> &mdash;"; }
										echo "<em>" . $reviews_results->RATING . "</em> <hr />" . $reviews_results->REVIEW . "
									</section>
								</article>
							</div>";
				echo "</td><td>
				<form method=\"post\" class=\"reviews_item_form\"><input type=\"submit\" name=\"$this_ID\" value=\"Delete\"></form>";
				if(isset($_POST[$this_ID])){
					$current = plugin_basename(__FILE__);
					$wpdb->query(" DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID' ");
					echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
				}
				}
				echo "</tr></tbody></table></td>";
				print_mom_reviews_form();
				echo "
					</tr>
					</tbody>
				</table>
			</div>
			";

		}
	}
	
	// shortcode content
	function mom_reviews_shortcode($atts, $content = null) {
		global $mom_review_global;
		$mom_review_global++;
		if ($mom_review_global == 1) { mom_reviews_style(); } else { }
		ob_start();
		extract(
			shortcode_atts(array(
				"type" => '',
				"orderby" => 'ID',
				"order" => 'ASC',
				"meta" => '1',
				"expand" => "+",
				"retract" => "-",
				"id" => "",
			), $atts)
		);	
		$id_fetch = sanitize_text_field ($id);
		$result_type = sanitize_text_field ($type);
		$order_by = sanitize_text_field ($orderby);
		$order_dir = sanitize_text_field ($order);
		$meta_show = sanitize_text_field ($meta);
		$expand_this = $expand;
		$retract_this = $retract;
		echo "
		";
		global $wpdb;
		$mom_reviews_table_name = $wpdb->prefix . "momreviews";
		
		if ($id_fetch != "" && is_numeric($id_fetch)) {
			$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE ID = '$id_fetch' ORDER BY $order_by $order_dir LIMIT 1");
		} else {
			if ($result_type != "") { 
				$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE IN ($result_type) ORDER BY $order_by $order_dir");
			} else {
				$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY $order_by $order_dir");
			}
		}
		
		foreach ($reviews as $reviews_results) {
			$this_ID = $reviews_results->ID;
				echo "<div "; if ($result_type != "") { echo "id=\"$result_type\""; } echo " class=\"momreview\"><article class=\"block\"><input type=\"checkbox\" name=\"review\" id=\"" . $this_ID . "" . $mom_review_global . "\" /><label for=\"" . $this_ID . "" . $mom_review_global . "\">"; if ($reviews_results->TITLE != "") { echo $reviews_results->TITLE; } echo "<span>" . $expand_this . "</span><span>" . $retract_this . "</span></label><section class=\"reviewed\">"; if ($meta_show == 1 ) { if ($reviews_results->TYPE != "") { echo " [ <em>" . $reviews_results->TYPE . "</em> ] ";} if ($reviews_results->LINK != "") { echo " [ <a href=\"" . $reviews_results->LINK . "\">#</a> ] "; } } if ($reviews_results->REVIEW != "") { echo "<hr />" . $reviews_results->REVIEW . ""; } if ($reviews_results->RATING != "") { echo " <p><em>" . $reviews_results->RATING . "</em></p> "; } echo "</section></article></div>";
		}		
		return ob_get_clean();
	}
	
	function mom_reviews_style() {
		echo "<style>" . get_option('momreviews_css') . "</style>
		";
	}
	
?>