<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

	//	MY OPTIONAL MODULES
	//		MODULE: COUNT++

	if (is_admin() ) { 

		function my_optional_modules_count_module() {
	
			function update_obwcountplus_options() {
				if ( $_REQUEST[ 'obwcountplus_countdownfrom' ] != '' . get_option("obwcountplus_1_countdownfrom") . '' && is_numeric( $_REQUEST[ 'obwcountplus_countdownfrom' ] ) ) { 
					update_option("obwcountplus_1_countdownfrom",$_REQUEST["obwcountplus_countdownfrom"]); 
				}
				if ( $_REQUEST[ 'obwcountplus_remaining' ] != '' . get_option("obwcountplus_2_remaining") . "") { 
					update_option( 'obwcountplus_2_remaining',$_REQUEST[ 'obwcountplus_remaining' ] ); 
				}
				if ( $_REQUEST[ 'obwcountplus_total' ] != '' . get_option("obwcountplus_3_total") . '') { 
					update_option( 'obwcountplus_3_total',$_REQUEST[ 'obwcountplus_total' ] ); 
				}
				if ( $_REQUEST[ 'obwcountplus_custom' ] != '' . get_option("obwcountplus_4_custom") . '') { 
					update_option( 'obwcountplus_4_custom',$_REQUEST[ 'obwcountplus_custom' ] ); 
				}
				if ( $_REQUEST[ 'obwcountplus_countdownfrom' ] == '') { 
					update_option( 'obwcountplus_1_countdownfrom','0' ); 
				}
				if ( $_REQUEST[ 'obwcountplus_remaining' ] == '') { 
					update_option( 'obwcountplus_2_remaining','remaining' ); 
				}
				if ( $_REQUEST[ 'obwcountplus_total' ] == '') { 
					update_option( 'obwcountplus_3_total','total' ); 
				}
				if ( $_REQUEST[ 'obwcountplus_custom' ] == '') { 
					update_option( 'obwcountplus_4_custom','' ); 
				}
				echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
			}

			function obwcountplus_form() {
				echo "
					<table class=\"form-table\" border=\"1\" style=\"margin:5px; \">
						<tbody>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"obwcountplus_countdownfrom\">Goal (<em>0</em> for none)</label></th>
								<td><input id=\"obwcountplus_countdownfrom\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_1_countdownfrom' ) . "\" name=\"obwcountplus_countdownfrom\"></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"obwcountplus_remaining\">Text for remaining words (to goal)</label></th>
								<td><input id=\"obwcountplus_remaining\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_2_remaining' ) . "\" name=\"obwcountplus_remaining\"></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"obwcountplus_total\">Text for words published</label></th>
								<td><input id=\"obwcountplus_total\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_3_total' ) . "\" name=\"obwcountplus_total\"></td>
							</tr>
							<tr valign=\"top\">
								<th scope=\"row\"><label for=\"obwcountplus_custom\">Custom output</label></th>
								<td><input id=\"obwcountplus_custom\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_4_custom' ) . "\" name=\"obwcountplus_custom\"></td>
							</tr>
							<tr valign=\"top\">
								<td>
									How to use custom output
								</td>
								<td>
									%total% will be replaced with the total words on the blog<br />
									%remain% will be replaced with the remaining words of the total<br /><hr />
									<p>Examples:<br />
									<code>There are %total% words with %remain% left to go!</code><br /> will output 
									<em>There are 90 words with 10 left to go!</em> (if you have a goal of 100 words 
									set and there are currently 90 words published.</p>
									<p>If you've already reached your goal, %remain% will be a negative number.</p>
								</td>
							</tr>
						</tbody>
					</table>
				";
			}

			function obwcountplus_page_content() {
				echo "
				<div class=\"wrap\">
					<h2>Count++</h2>";
					echo "
					<form method=\"post\">
						<table class=\"form-table\" border=\"1\">
							<tbody>
								<tr>
									<td>
										<p>Count++ is adapted from <a href=\"http://wordpress.org/plugins/post-word-count/\">Post Word Count</a> by <a href=\"http://profiles.wordpress.org/nickmomrik/\">Nick Momrik</a>.</p>
									</td>
								</tr>
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
									<td valign=\"top\">";
										obwcountplus_form();
									echo "
									</td>
								</tr>
							</tbody>
						</table>
						<p class=\"submit\"><input id=\"obwcountsave\" type=\"submit\" value=\"Save Changes\" name=\"obwcountsave\"></p>
					</form>
				</div>";
			}
			
			if(isset( $_POST[ 'obwcountsave' ] ) ) { update_obwcountplus_options(); }

			obwcountplus_page_content();
		
		}
		
		my_optional_modules_count_module();
		
	}
	
?>