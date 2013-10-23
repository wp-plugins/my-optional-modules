<?php 

	// Module name: Reviews
	//  add shortcode
	//  options page
	//   - options form (save)
	//   - options form (output)
	//   - options page (output)
	//  shortcode content
	
	if(!defined('MyOptionalModules')) {	die('You can not call this file directly.'); }
	
	//  add shortcode
	add_shortcode('momreviews', 'mom_reviews_shortcode');	
	add_filter('the_content', 'do_shortcode', 'mom_reviews_shortcode');	

	function reviews_paragraph($str) {
		$arr=explode("\n",$str);
		$out='';

		for($i=0;$i<count($arr);$i++) {
			if(strlen(trim($arr[$i]))>0)
				$out.='<p>'.trim($arr[$i]).'</p>';
		}
		return $out;
	}
	
	if (is_admin() ) {
		//  options page
		add_action("admin_menu", "mom_reviews_options_add_options_page");
		function mom_reviews_options_add_options_page() {$reviews_options = add_options_page("MOM: Reviews", " &not; MOM: Reviews", "manage_options", "momreviewreviews", "reviews_page_content"); }

		
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
		}
		
		// options form (output)
		function print_mom_reviews_form() {
			echo "
				<td valign=\"top\">
					<form method=\"post\">
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
							<tbody>
								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_title\" placeholder=\"Review title (Required)\" required=\"required\"></td></tr>
								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_type\" placeholder=\"Review type (Required)\" required=\"required\"></td></tr>
								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_link\" placeholder=\"Relevant URL (optional)\" ></td></tr>
								
								<tr valign=\"top\"><td>";
									the_editor($content, $name = 'reviews_review', $id = 'reviews_review', $prev_id = 'title', $media_buttons = false, $tab_index = 2);
								echo "</td></tr>

								<tr valign=\"top\"><td><input type=\"text\" name=\"reviews_rating\" placeholder=\"Your rating (Required)\" required=\"required\"></td></tr>
								<tr valign=\"top\"><td><input id=\"reviewsubmit\" class=\"button button-primary\" type=\"submit\" value=\"Add review\" name=\"reviewsubmit\"></input></td></tr>	
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
									<li>Place the shortcode <code>[momreviews]</code> where you would like to show your list of reviews.</li>
									<li>To show a loop of specific review types, use <code>[momreviews type=\"type\"]</code>.</li>
									<li>Use the table below to delete specific reviews.</li>
									<li>Shortcodes may not execute properly in the review table below, although they may display normally on your live site. (Check and make sure before you delete a review thinking you've made a mistake.)</li>
								</ol></blockquote>
				<hr />
				<table class=\"form-table\" border=\"1\">
					<tbody>								
						<style>
							input[type='text'] { width: 100%; display:block; cursor:pointer;}
							.review { margin: 0 auto 0 auto; width: 95%; }
							.review .block { padding-top: 5px; margin: 0 auto 0 auto;}
							.review .block input[type='checkbox']:checked ~ .reviewed {height: auto; margin: -25px auto 5px auto;}
							.review input[type='checkbox']  {display: none;}
							.review label {width: 95%; min-height: 35px; margin: 0 auto; display: block; cursor: pointer; }
							.review label:hover { }
							.review span {font-weight: bold;float:right;}
							.review .block input[type='checkbox'] ~ label span:first-of-type {display:block;visibility:visible;float:right;margin:0 -5px 0 0;}
							.review .block input[type='checkbox'] ~ label span:last-of-type {display:none;visibility:hidden;float:right;}
							.review .block input[type='checkbox']:checked ~ label span:first-of-type {display:none;visibility:hidden;float:right;}
							.review .block input[type='checkbox']:checked ~ label span:last-of-type {display:block;visibility:visible;float:right;}
							.review .reviewed { width: 93%; height: 0; padding: 0 15px 0 15px;display: block;overflow: hidden; box-sizing: border-box; margin: auto;} 
							.review h4 {color: #111;text-align: right;text-shadow: 1px 1px 2px #fff;position: absolute;bottom: 20px;right: 15px;}
							.review h4 a {color: #111;text-decoration: none;}
							.review ::selection {background: #222;color: #fff;}
						</style>
			";

					global $wpdb;
					$mom_reviews_table_name = $wpdb->prefix . "momreviews";
					$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
					foreach ($reviews as $reviews_results) {
						$this_ID = $reviews_results->ID;
							echo "<tr><td>
							<div class=\"review\">
								<article class=\"block\">
									<input type=\"checkbox\" name=\"review\" id=\"" . $this_ID . "\" checked />
									<label for=\"" . $this_ID . "\">" .  $reviews_results->TITLE . "<span>+</span><span>-</span></label>
									<section class=\"reviewed\">
										<strong>Review type</strong>: <em>" . $reviews_results->TYPE . "</em> &mdash; ";
										if ($reviews_results->LINK != "") { echo "<a href=\"" . $reviews_results->LINK . "\">#</a> &mdash;"; }
										echo "<strong>Rating</strong>: <em>" . $reviews_results->RATING . "</em></strong><hr />" . $reviews_results->REVIEW . "
									</section>
									<form method=\"post\" class=\"reviews_item_form\"><input type=\"submit\" name=\"$this_ID\" value=\"Delete\"></form>";
									if(isset($_POST[$this_ID])){
										$current = plugin_basename(__FILE__);
										$wpdb->query(" DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID' ");
										echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
									}
									echo "
								</article>
							</div>";
					}
				echo "</td></tr></tbody></table></td>";
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
		ob_start();
		extract(
			shortcode_atts(array(
				"type" => '',
			), $atts)
		);	
		$result_type = sanitize_text_field ($type);
		echo "
			<style>
				.review { margin: 0 auto 0 auto; width: 95%; }
				.review .block { padding-top: 5px; margin: 0 auto 0 auto;}
				.review .block input[type='checkbox']:checked ~ .reviewed {height: auto; margin: -25px auto 5px auto;}
				.review input[type='checkbox']  {display: none;}
				.review label {width: 95%; min-height: 35px; margin: 0 auto; display: block; cursor: pointer; }
				.review label:hover { }
				.review span {font-weight: bold;float:right;}
				.review .block input[type='checkbox'] ~ label span:first-of-type {display:block;visibility:visible;float:right;margin:0 -5px 0 0;}
				.review .block input[type='checkbox'] ~ label span:last-of-type {display:none;visibility:hidden;float:right;}
				.review .block input[type='checkbox']:checked ~ label span:first-of-type {display:none;visibility:hidden;float:right;}
				.review .block input[type='checkbox']:checked ~ label span:last-of-type {display:block;visibility:visible;float:right;}
				.review .reviewed { width: 93%; height: 0; padding: 0 15px 0 15px;display: block;overflow: hidden; box-sizing: border-box; margin: auto;} 
				.review h4 {color: #111;text-align: right;text-shadow: 1px 1px 2px #fff;position: absolute;bottom: 20px;right: 15px;}
				.review h4 a {color: #111;text-decoration: none;}
				.review ::selection {background: #222;color: #fff;}
			</style>
		";
		global $wpdb;
		$mom_reviews_table_name = $wpdb->prefix . "momreviews";
		if ($result_type == "") {
			$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
		} else {
			$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE = '$result_type' ORDER BY ID DESC");
		}
		foreach ($reviews as $reviews_results) {
			$this_ID = $reviews_results->ID;
				echo "<div "; if ($result_type != "") { echo "id=\"$result_type\""; } echo " class=\"review\"><article class=\"block\"><input type=\"checkbox\" name=\"review\" id=\"" . $this_ID . "\" checked /><label for=\"" . $this_ID . "\">" .  $reviews_results->TITLE . "<span>+</span><span>-</span></label><section class=\"reviewed\"><strong>Review type</strong>: <em>" . $reviews_results->TYPE . "</em> &mdash; ";if ($reviews_results->LINK != "") { echo "<a href=\"" . $reviews_results->LINK . "\">#</a> &mdash;"; }echo "<strong>Rating</strong>: <em>" . $reviews_results->RATING . "</em></strong><hr />" . $reviews_results->REVIEW . "</section></article></div>";
		}		
		return ob_get_clean();
	}
?>