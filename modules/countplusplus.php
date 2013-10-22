<?php 

	// Module name: Count++
	//  Module contents
	//  options page
	//   - options form (save)
	//   - options form (output)
	//   - options page (output)
	//  template functions
	//   - single
	//   - remaining
	//   - total
	//   - count

	if(!defined('MyOptionalModules')) {	die('You can not call this file directly.'); }

	if (is_admin() ) { 
		// options page
		add_action("admin_menu", "obwcountplus_add_options_page");
		function obwcountplus_add_options_page() { 
			$obwcountplus_options = add_options_page("MOM: Count++", " &not; MOM: Count++", "manage_options", "obwcountplus", "obwcountplus_page_content");
		}	
	
		//	options form (save)
		function update_obwcountplus_options() {
				if(isset($_POST['obwcountsave'])){
				if ($_REQUEST["obwcountplus_countdownfrom"] != "" . get_option("obwcountplus_1_countdownfrom") . "" && is_numeric($_REQUEST["obwcountplus_countdownfrom"])) { update_option("obwcountplus_1_countdownfrom",$_REQUEST["obwcountplus_countdownfrom"]); }
				if ($_REQUEST["obwcountplus_remaining"] != "" . get_option("obwcountplus_2_remaining") . "") { update_option("obwcountplus_2_remaining",$_REQUEST["obwcountplus_remaining"]); }
				if ($_REQUEST["obwcountplus_total"] != "" . get_option("obwcountplus_3_total") . "") { update_option("obwcountplus_3_total",$_REQUEST["obwcountplus_total"]); }
				if ($_REQUEST["obwcountplus_custom"] != "" . get_option("obwcountplus_4_custom") . "") { update_option("obwcountplus_4_custom",$_REQUEST["obwcountplus_custom"]); }
				if ($_REQUEST["obwcountplus_countdownfrom"] == "") { update_option("obwcountplus_1_countdownfrom","0"); }
				if ($_REQUEST["obwcountplus_remaining"] == "") { update_option("obwcountplus_2_remaining","remaining"); }
				if ($_REQUEST["obwcountplus_total"] == "") { update_option("obwcountplus_3_total","total"); }				
				if ($_REQUEST["obwcountplus_custom"] == "") { update_option("obwcountplus_4_custom",""); }				
				
			}		
		}
		
		//	options form (output)
		function obwcountplus_form() {
			echo "
			<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
				<tbody>			
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"obwcountplus_countdownfrom\">Goal (<em>0</em> for none)</label></th>
						<td><input id=\"obwcountplus_countdownfrom\" class=\"regular-text\" type=\"text\" value=\"". get_option("obwcountplus_1_countdownfrom") . "\" name=\"obwcountplus_countdownfrom\"></input></td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"obwcountplus_remaining\">Text for remaining words (to goal)</label></th>
						<td><input id=\"obwcountplus_remaining\" class=\"regular-text\" type=\"text\" value=\"". get_option("obwcountplus_2_remaining") . "\" name=\"obwcountplus_remaining\"></input></td>
					</tr>						
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"obwcountplus_total\">Text for words published</label></th>
						<td><input id=\"obwcountplus_total\" class=\"regular-text\" type=\"text\" value=\"". get_option("obwcountplus_3_total") . "\" name=\"obwcountplus_total\"></input></td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"obwcountplus_custom\">Custom output</label></th>
						<td><input id=\"obwcountplus_custom\" class=\"regular-text\" type=\"text\" value=\"". get_option("obwcountplus_4_custom") . "\" name=\"obwcountplus_custom\"></input></td>
					</tr>
					<tr valign=\"top\">					
						<td>How to use custom output</td>
						<td>%total% will be replaced with the total words on the blog<br />
						%remain% will be replaced with the remaining words of the total<br /><hr />
						
						<p>Examples:<br />
						<code>There are %total% words with %remain% left to go!</code><br /> will output 
						<em>There are 90 words with 10 left to go!</em> (if you have a goal of 100 words 
						set and there are currently 90 words published.</p>
						<p>If you've already reached your goal, %remain% will be a negative number.</p>
						
						</td>
						</td>
					</tr>					
				</tbody>
			</table>
			";
		}
	
		//	options page (output)
		function obwcountplus_page_content() {
				echo "
				<div class=\"wrap\">
					<div id=\"icon-options-general\" class=\"icon32\"></div>
					<h2>Count++</h2>
					<h3 class=\"title\">Settings</h3>
				";
				if(isset($_POST['obwcountsave'])){ echo "<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>"; }
				echo "
					<form method=\"post\">
						<table class=\"form-table\" border=\"1\">
							<tbody>
								<tr><td></td><td><p>Count++ is adapted from <a href=\"http://wordpress.org/plugins/post-word-count/\">Post Word Count</a> by <a href=\"http://profiles.wordpress.org/nickmomrik/\">Nick Momrik</a>.</p></td></tr>
								<tr valign=\"top\">
									<td valign=\"top\">
										<h3 class=\"title\">Usage</h3>
										<p><em>Custom output</em><br />
										<code>&lt;?php if(function_exists('countsplusplus')){ countsplusplus(); } ?&gt;</code></p>
										<p><em>Display total words and words remaining</em><br />
										<code>&lt;?php if(function_exists('obwcountplus_count')){ obwcountplus_count(); } ?&gt;</code></p>
										<p><em>Display numerical value of total words only</em><br />			
										<code>&lt;?php if(function_exists('obwcountplus_total')){ obwcountplus_total(); } ?&gt;</code></p>
										<p><em>Display numerical value of remaining words (will result in total if goal has been reached)</em><br />			
										<code>&lt;?php if(function_exists('obwcountplus_remaining')){ obwcountplus_remaining(); } ?&gt;</code></p>
										<p><em>Display numerical value of the current number of words in the post (only visable on single post views)</em><br />			
										<code>&lt;?php if(function_exists('obwcountplus_single')){ obwcountplus_single(); } ?&gt;</code></p>				
									</td>
									<td valign=\"top\">
							
				";
				obwcountplus_form();
				echo "
									</td>
								</tr>
							</tbody>
						</table>
						<p class=\"submit\"><input id=\"obwcountsave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"obwcountsave\"></input></p>
					</form>
				</div>
				";
		}
		if(isset($_POST["obwcountsave"])){ update_obwcountplus_options(); }		
	}

	// template functions
	function countsplusplus() {
		
		global $wpdb;
		$now = gmdate("Y-m-d H:i:s",time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if ($words) {
			foreach ($words as $word) {
					$post = strip_tags($word->post_content);
					$post = explode(' ', $post);
					$count = count($post);
					$totalcount = $count + $oldcount;
					$oldcount = $totalcount;
			}
		} else {
				$totalcount=0;
		}			

		$remain = number_format(get_option("obwcountplus_1_countdownfrom") - $totalcount);
		$c_custom = get_option("obwcountplus_4_custom");
		$c_search = array("%total%","%remain%");
		$c_replace = array("$totalcount","$remain");
		echo str_replace($c_search,$c_replace,$c_custom);

	}
	
	function obwcountplus_single() {
		global $wpdb, $id;
		$now = gmdate("Y-m-d H:i:s",time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post' AND ID = '$id'";
		$words = $wpdb->get_results($query);
		if ($words) {
			foreach ($words as $word) {
				$post = strip_tags($word->post_content);
				$post = explode(' ', $post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
			if (is_single()) {
			echo number_format($totalcount); 
			} else {
			}
	}	
	
	function obwcountplus_remaining() {
		global $wpdb;
		$now = gmdate("Y-m-d H:i:s",time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if ($words) {
			foreach ($words as $word) {
				$post = strip_tags($word->post_content);
				$post = explode(' ', $post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
		if ($totalcount >= get_option("obwcountplus_1_countdownfrom") || get_option("obwcountplus_1_countdownfrom") == 0) {
			echo number_format($totalcount);
		} else {
			echo number_format(get_option("obwcountplus_1_countdownfrom") - $totalcount);
		} 
	}	
	
	function obwcountplus_total() {
		global $wpdb;
		$now = gmdate("Y-m-d H:i:s",time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if ($words) {
			foreach ($words as $word) {
				$post = strip_tags($word->post_content);
				$post = explode(' ', $post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
			echo number_format($totalcount);
	}
	
	function obwcountplus_count() {
		global $wpdb;
		$now = gmdate("Y-m-d H:i:s",time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if ($words) {
			foreach ($words as $word) {
				$post = strip_tags($word->post_content);
				$post = explode(' ', $post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
		if ($totalcount >= get_option("obwcountplus_1_countdownfrom") || get_option("obwcountplus_1_countdownfrom") == 0) {
			echo number_format($totalcount) . " " . get_option("obwcountplus_3_total");
		} else {
			echo number_format(get_option("obwcountplus_1_countdownfrom") - $totalcount) . ' ' . get_option("obwcountplus_2_remaining") . ' (' . number_format($totalcount) . ' '. get_option("obwcountplus_3_total") . ')' ;
		} 
	}
?>