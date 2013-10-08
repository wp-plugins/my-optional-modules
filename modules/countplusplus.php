<?php 

	if(!defined('MyOptionalModules')) {
	die('You can not call this file directly.');
	}

 ## OBWCOUNTPLUS (aka count++)
	## obwcountplus adapted from: http://wordpress.org/plugins/post-word-count/ by Nick Momrik
	## obwcountplus
	##	register options page
	if (is_admin() ) {
		add_action("admin_menu", "obwcountplus_add_options_page");
	}
	
	## Get the options set up by the plugin for use throughout
	$obwcountplus_countdownfrom = get_option("obwcountplus_1_countdownfrom");
	$obwcountplus_remaining = get_option("obwcountplus_2_remaining");
	$obwcountplus_total = get_option("obwcountplus_3_total");

	## obwcountplus options page
		function obwcountplus_add_options_page() {																
			$obwcountplus_options = add_options_page("MOM: Count++", " &not; MOM: Count++", "manage_options", "obwcountplus", "obwcountplus_page_content");
		}	
	
	## Check if admin or not
	if (is_admin() ) { 
	
	##	Update options if form is submitted
		function update_obwcountplus_options() {
			global $obwcountplus_countdownfrom;
			global $obwcountplus_posttypes;
			global $obwcountplus_remaining;
			global $obwcountplus_total;
				if(isset($_POST['obwcountsave'])){
				if ($_REQUEST["obwcountplus_countdownfrom"] != "$obwcountplus_countdownfrom" && is_numeric($_REQUEST["obwcountplus_countdownfrom"])) { update_option("obwcountplus_1_countdownfrom",$_REQUEST["obwcountplus_countdownfrom"]); }
				if ($_REQUEST["obwcountplus_remaining"] != "$obwcountplus_remaining") { update_option("obwcountplus_2_remaining",$_REQUEST["obwcountplus_remaining"]); }
				if ($_REQUEST["obwcountplus_total"] != "$obwcountplus_total") { update_option("obwcountplus_3_total",$_REQUEST["obwcountplus_total"]); }

				if ($_REQUEST["obwcountplus_countdownfrom"] == "") { update_option("obwcountplus_1_countdownfrom","0"); }
				if ($_REQUEST["obwcountplus_remaining"] == "") { update_option("obwcountplus_2_remaining","remaining"); }
				if ($_REQUEST["obwcountplus_total"] == "") { update_option("obwcountplus_3_total","total"); }				
				
			}		
		}
		
	##	Form to save the plugin options from.
		function obwcountplus_form() {
			global $obwcountplus_countdownfrom;
			global $obwcountplus_remaining;
			global $obwcountplus_total;
		
			echo "
			
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"obwcountplus_countdownfrom\">Word count goal (0 for none)</label>
				</th>
				<td>
					<input id=\"obwcountplus_countdownfrom\" class=\"regular-text\" type=\"text\" value=\"". $obwcountplus_countdownfrom . "\" name=\"obwcountplus_countdownfrom\"></input>
				</td>
			</tr>
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"obwcountplus_remaining\">Text for remaining words (to goal)</label>
				</th>
				<td>
					<input id=\"obwcountplus_remaining\" class=\"regular-text\" type=\"text\" value=\"". $obwcountplus_remaining . "\" name=\"obwcountplus_remaining\"></input>
				</td>
			</tr>						
			<tr valign=\"top\">
				<th scope=\"row\">
					<label for=\"obwcountplus_total\">Text for words published</label>
				</th>
				<td>
					<input id=\"obwcountplus_total\" class=\"regular-text\" type=\"text\" value=\"". $obwcountplus_total . "\" name=\"obwcountplus_total\"></input>
				</td>
			</tr>
			";
		}
	
	##	Plugin options page output.
		function obwcountplus_page_content() {
				echo "
				<div class=\"wrap\">
					<div id=\"icon-options-general\" class=\"icon32\"></div>
					<h2>Count++</h2>
					<p>Count++ is adapted from <a href=\"http://wordpress.org/plugins/post-word-count/\">Post Word Count</a> by <a href=\"http://profiles.wordpress.org/nickmomrik/\">Nick Momrik</a>.</p>
					<h3 class=\"title\">Settings</h3>
				";
				
				if(isset($_POST['obwcountsave'])){
					echo "
						<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>
					";
				}
				
				echo "<form method=\"post\">
					<table class=\"form-table\">
						<tbody>
				";
				obwcountplus_form();
				echo "
						</tbody>
					</table>
					<p class=\"submit\">
						<input id=\"obwcountsave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"obwcountsave\"></input>
					</p>
				</form>
				
				<h3 class=\"title\">Usage</h3>
				<p><em>Display total words and words remaining</em><br />
				<code>&lt;?php if(function_exists('obwcountplus_count')){ obwcountplus_count(); } ?&gt;</code></p>
				<p><em>Display numerical value of total words only</em><br />			
				<code>&lt;?php if(function_exists('obwcountplus_total')){ obwcountplus_total(); } ?&gt;</code></p>
				<p><em>Display numerical value of remaining words (will result in total if goal has been reached)</em><br />			
				<code>&lt;?php if(function_exists('obwcountplus_remaining')){ obwcountplus_remaining(); } ?&gt;</code></p>
				<p><em>Display numerical value of the current number of words in the post (only visable on single post views)</em><br />			
				<code>&lt;?php if(function_exists('obwcountplus_single')){ obwcountplus_single(); } ?&gt;</code></p>				
				
				</div>
				";
		}

				if(isset($_POST["obwcountsave"])){
					if ($_REQUEST["obwcountsave"]) { 
						update_obwcountplus_options();
					}
				}		
	
	}

	## Template function to output count according to parameters
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
			echo $totalcount; 
			} else {
			}
	}	
	
	function obwcountplus_remaining() {
		global $obwcountplus_countdownfrom;
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

		if ($totalcount >= $obwcountplus_countdownfrom || $obwcountplus_countdownfrom == 0) {
			echo $totalcount;
		} else {
			echo number_format($obwcountplus_countdownfrom - $totalcount);
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

			echo $totalcount;
	}
	
	function obwcountplus_count() {
		global $obwcountplus_countdownfrom;
		global $obwcountplus_remaining;
		global $obwcountplus_total;
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

		if ($totalcount >= $obwcountplus_countdownfrom || $obwcountplus_countdownfrom == 0) {
			echo $totalcount . " " . $obwcountplus_total;
		} else {
			echo number_format($obwcountplus_countdownfrom - $totalcount) . ' ' . $obwcountplus_remaining . ' (' . number_format($totalcount) . ' '. $obwcountplus_total . ')' ;
		} 
	}
?>