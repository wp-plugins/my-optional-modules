<?php

	## Module name: Jump Around
	## Module contents
	## enqueue jquery, add footer script
	## options page
	##   - options form (save)
	##   - options form (output)
	##   - options page (output)
	## footer script contents
	
	if(!defined('MyOptionalModules')) {	die('You can not call this file directly.'); }

	## enqueue jquery, add footer script 
	if (!is_admin()) add_action("wp_enqueue_scripts", "Jump_Around_jquery_enqueue", 11);
	function Jump_Around_jquery_enqueue() {
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
		wp_enqueue_script('jquery');
	}
	add_action('wp_footer', 'jump_around_footer_script');
	
	if (is_admin() ) {
		
		## options page
		add_action("admin_menu", "momja_add_options_page");
		function momja_add_options_page() { $obwcountplus_options = add_options_page("MOM: Jump Around", " &not; MOM: Jump Around", "manage_options", "momja", "momja_page_content"); }	
		
		## options form (save)
		function update_JA() {
			if ( $_REQUEST["jump_around_0"] || $_REQUEST["jump_around_1"] || $_REQUEST["jump_around_2"] || $_REQUEST["jump_around_3"] || $_REQUEST["jump_around_4"] || $_REQUEST["jump_around_5"] || $_REQUEST["jump_around_6"] || $_REQUEST["jump_around_7"] || $_REQUEST["jump_around_8"]  ) {
				update_option("jump_around_0",$_REQUEST["jump_around_0"]);
				update_option("jump_around_1",$_REQUEST["jump_around_1"]);
				update_option("jump_around_2",$_REQUEST["jump_around_2"]);
				update_option("jump_around_3",$_REQUEST["jump_around_3"]);
				update_option("jump_around_4",$_REQUEST["jump_around_4"]);
				update_option("jump_around_5",$_REQUEST["jump_around_5"]);
				update_option("jump_around_6",$_REQUEST["jump_around_6"]);
				update_option("jump_around_7",$_REQUEST["jump_around_7"]);
				update_option("jump_around_8",$_REQUEST["jump_around_8"]);
			}
		}
		
		## options form (output)
		function print_jump_around_form() {
			echo "
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"jump_around_0\">Post container class</label></th>
					<td><input type=\"text\" name=\"jump_around_0\" value=\"" . get_option("jump_around_0") . "\" /></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"jump_around_1\">Post permalink class:</label></th>
					<td><input type=\"text\" name=\"jump_around_1\" value=\"" . get_option("jump_around_1") . "\" /></td>
				</tr>
				<tr valign=\"top\">		
					<th scope=\"row\"><label for=\"jump_around_2\">Previous posts link wrapper</label></th>
					<td><input type=\"text\" name=\"jump_around_2\" value=\"" . get_option("jump_around_2") . "\" /></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"jump_around_3\">Next posts link wrapper</label></th>
					<td><input type=\"text\" name=\"jump_around_3\" value=\"" . get_option("jump_around_3") . "\" /></td>
				</tr>
				<tr valign=\"top\">
					<th scope=\"row\"><label for=\"jump_around_4\">Previous key</label></th>
					<td><select name=\"jump_around_4\">
							<option value=\"65\"";if (get_option("jump_around_4") == "65") { echo " selected=\"selected\""; } echo ">a</option>
							<option value=\"66\"";if (get_option("jump_around_4") == "66") { echo " selected=\"selected\""; } echo ">b</option>
							<option value=\"67\"";if (get_option("jump_around_4") == "67") { echo " selected=\"selected\""; } echo ">c</option>
							<option value=\"68\"";if (get_option("jump_around_4") == "68") { echo " selected=\"selected\""; } echo ">d</option>
							<option value=\"69\"";if (get_option("jump_around_4") == "69") { echo " selected=\"selected\""; } echo ">e</option>
							<option value=\"70\"";if (get_option("jump_around_4") == "70") { echo " selected=\"selected\""; } echo ">f</option>
							<option value=\"71\"";if (get_option("jump_around_4") == "71") { echo " selected=\"selected\""; } echo ">g</option>
							<option value=\"72\"";if (get_option("jump_around_4") == "72") { echo " selected=\"selected\""; } echo ">h</option>
							<option value=\"73\"";if (get_option("jump_around_4") == "73") { echo " selected=\"selected\""; } echo ">i</option>
							<option value=\"74\"";if (get_option("jump_around_4") == "74") { echo " selected=\"selected\""; } echo ">j</option>
							<option value=\"75\"";if (get_option("jump_around_4") == "75") { echo " selected=\"selected\""; } echo ">k</option>
							<option value=\"76\"";if (get_option("jump_around_4") == "76") { echo " selected=\"selected\""; } echo ">l</option>
							<option value=\"77\"";if (get_option("jump_around_4") == "77") { echo " selected=\"selected\""; } echo ">m</option>
							<option value=\"78\"";if (get_option("jump_around_4") == "78") { echo " selected=\"selected\""; } echo ">n</option>
							<option value=\"79\"";if (get_option("jump_around_4") == "79") { echo " selected=\"selected\""; } echo ">o</option>
							<option value=\"80\"";if (get_option("jump_around_4") == "80") { echo " selected=\"selected\""; } echo ">p</option>
							<option value=\"81\"";if (get_option("jump_around_4") == "81") { echo " selected=\"selected\""; } echo ">q</option>
							<option value=\"82\"";if (get_option("jump_around_4") == "82") { echo " selected=\"selected\""; } echo ">r</option>
							<option value=\"83\"";if (get_option("jump_around_4") == "83") { echo " selected=\"selected\""; } echo ">s</option>
							<option value=\"84\"";if (get_option("jump_around_4") == "84") { echo " selected=\"selected\""; } echo ">t</option>
							<option value=\"85\"";if (get_option("jump_around_4") == "85") { echo " selected=\"selected\""; } echo ">u</option>
							<option value=\"86\"";if (get_option("jump_around_4") == "86") { echo " selected=\"selected\""; } echo ">v</option>
							<option value=\"87\"";if (get_option("jump_around_4") == "87") { echo " selected=\"selected\""; } echo ">w</option>
							<option value=\"88\"";if (get_option("jump_around_4") == "88") { echo " selected=\"selected\""; } echo ">x</option>
							<option value=\"89\"";if (get_option("jump_around_4") == "89") { echo " selected=\"selected\""; } echo ">y</option>
							<option value=\"90\"";if (get_option("jump_around_4") == "90") { echo " selected=\"selected\""; } echo ">z</option>
							<option value=\"48\"";if (get_option("jump_around_4") == "48") { echo " selected=\"selected\""; } echo ">0</option>
							<option value=\"49\"";if (get_option("jump_around_4") == "49") { echo " selected=\"selected\""; } echo ">1</option>
							<option value=\"50\"";if (get_option("jump_around_4") == "50") { echo " selected=\"selected\""; } echo ">2</option>
							<option value=\"51\"";if (get_option("jump_around_4") == "51") { echo " selected=\"selected\""; } echo ">3</option>
							<option value=\"52\"";if (get_option("jump_around_4") == "52") { echo " selected=\"selected\""; } echo ">4</option>
							<option value=\"53\"";if (get_option("jump_around_4") == "53") { echo " selected=\"selected\""; } echo ">5</option>
							<option value=\"54\"";if (get_option("jump_around_4") == "54") { echo " selected=\"selected\""; } echo ">6</option>
							<option value=\"55\"";if (get_option("jump_around_4") == "55") { echo " selected=\"selected\""; } echo ">7</option>
							<option value=\"56\"";if (get_option("jump_around_4") == "56") { echo " selected=\"selected\""; } echo ">8</option>
							<option value=\"57\"";if (get_option("jump_around_4") == "57") { echo " selected=\"selected\""; } echo ">9</option>
							<option value=\"37\"";if (get_option("jump_around_4") == "37") { echo " selected=\"selected\""; } echo ">left arrow</option>
							<option value=\"38\"";if (get_option("jump_around_4") == "38") { echo " selected=\"selected\""; } echo ">up arrow</option>
							<option value=\"39\"";if (get_option("jump_around_4") == "39") { echo " selected=\"selected\""; } echo ">right arrow</option>
							<option value=\"40\"";if (get_option("jump_around_4") == "40") { echo " selected=\"selected\""; } echo ">down arrow</option>
						</select></td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"jump_around_5\">Open currently selected key</label></th>
						<td><select name=\"jump_around_5\">
							<option value=\"65\"";if (get_option("jump_around_5") == "65") { echo " selected=\"selected\""; } echo ">a</option>
							<option value=\"66\"";if (get_option("jump_around_5") == "66") { echo " selected=\"selected\""; } echo ">b</option>
							<option value=\"67\"";if (get_option("jump_around_5") == "67") { echo " selected=\"selected\""; } echo ">c</option>
							<option value=\"68\"";if (get_option("jump_around_5") == "68") { echo " selected=\"selected\""; } echo ">d</option>
							<option value=\"69\"";if (get_option("jump_around_5") == "69") { echo " selected=\"selected\""; } echo ">e</option>
							<option value=\"70\"";if (get_option("jump_around_5") == "70") { echo " selected=\"selected\""; } echo ">f</option>
							<option value=\"71\"";if (get_option("jump_around_5") == "71") { echo " selected=\"selected\""; } echo ">g</option>
							<option value=\"72\"";if (get_option("jump_around_5") == "72") { echo " selected=\"selected\""; } echo ">h</option>
							<option value=\"73\"";if (get_option("jump_around_5") == "73") { echo " selected=\"selected\""; } echo ">i</option>
							<option value=\"74\"";if (get_option("jump_around_5") == "74") { echo " selected=\"selected\""; } echo ">j</option>
							<option value=\"75\"";if (get_option("jump_around_5") == "75") { echo " selected=\"selected\""; } echo ">k</option>
							<option value=\"76\"";if (get_option("jump_around_5") == "76") { echo " selected=\"selected\""; } echo ">l</option>
							<option value=\"77\"";if (get_option("jump_around_5") == "77") { echo " selected=\"selected\""; } echo ">m</option>
							<option value=\"78\"";if (get_option("jump_around_5") == "78") { echo " selected=\"selected\""; } echo ">n</option>
							<option value=\"79\"";if (get_option("jump_around_5") == "79") { echo " selected=\"selected\""; } echo ">o</option>
							<option value=\"80\"";if (get_option("jump_around_5") == "80") { echo " selected=\"selected\""; } echo ">p</option>
							<option value=\"81\"";if (get_option("jump_around_5") == "81") { echo " selected=\"selected\""; } echo ">q</option>
							<option value=\"82\"";if (get_option("jump_around_5") == "82") { echo " selected=\"selected\""; } echo ">r</option>
							<option value=\"83\"";if (get_option("jump_around_5") == "83") { echo " selected=\"selected\""; } echo ">s</option>
							<option value=\"84\"";if (get_option("jump_around_5") == "84") { echo " selected=\"selected\""; } echo ">t</option>
							<option value=\"85\"";if (get_option("jump_around_5") == "85") { echo " selected=\"selected\""; } echo ">u</option>
							<option value=\"86\"";if (get_option("jump_around_5") == "86") { echo " selected=\"selected\""; } echo ">v</option>
							<option value=\"87\"";if (get_option("jump_around_5") == "87") { echo " selected=\"selected\""; } echo ">w</option>
							<option value=\"88\"";if (get_option("jump_around_5") == "88") { echo " selected=\"selected\""; } echo ">x</option>
							<option value=\"89\"";if (get_option("jump_around_5") == "89") { echo " selected=\"selected\""; } echo ">y</option>
							<option value=\"90\"";if (get_option("jump_around_5") == "90") { echo " selected=\"selected\""; } echo ">z</option>
							<option value=\"48\"";if (get_option("jump_around_5") == "48") { echo " selected=\"selected\""; } echo ">0</option>
							<option value=\"49\"";if (get_option("jump_around_5") == "49") { echo " selected=\"selected\""; } echo ">1</option>
							<option value=\"50\"";if (get_option("jump_around_5") == "50") { echo " selected=\"selected\""; } echo ">2</option>
							<option value=\"51\"";if (get_option("jump_around_5") == "51") { echo " selected=\"selected\""; } echo ">3</option>
							<option value=\"52\"";if (get_option("jump_around_5") == "52") { echo " selected=\"selected\""; } echo ">4</option>
							<option value=\"53\"";if (get_option("jump_around_5") == "53") { echo " selected=\"selected\""; } echo ">5</option>
							<option value=\"54\"";if (get_option("jump_around_5") == "54") { echo " selected=\"selected\""; } echo ">6</option>
							<option value=\"55\"";if (get_option("jump_around_5") == "55") { echo " selected=\"selected\""; } echo ">7</option>
							<option value=\"56\"";if (get_option("jump_around_5") == "56") { echo " selected=\"selected\""; } echo ">8</option>
							<option value=\"57\"";if (get_option("jump_around_5") == "57") { echo " selected=\"selected\""; } echo ">9</option>
							<option value=\"37\"";if (get_option("jump_around_5") == "37") { echo " selected=\"selected\""; } echo ">left arrow</option>
							<option value=\"38\"";if (get_option("jump_around_5") == "38") { echo " selected=\"selected\""; } echo ">up arrow</option>
							<option value=\"39\"";if (get_option("jump_around_5") == "39") { echo " selected=\"selected\""; } echo ">right arrow</option>
							<option value=\"40\"";if (get_option("jump_around_5") == "40") { echo " selected=\"selected\""; } echo ">down arrow</option>
						</select></td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"jump_around_6\">Next key</label></th>
						<td><select name=\"jump_around_6\">
							<option value=\"65\"";if (get_option("jump_around_6") == "65") { echo " selected=\"selected\""; } echo ">a</option>
							<option value=\"66\"";if (get_option("jump_around_6") == "66") { echo " selected=\"selected\""; } echo ">b</option>
							<option value=\"67\"";if (get_option("jump_around_6") == "67") { echo " selected=\"selected\""; } echo ">c</option>
							<option value=\"68\"";if (get_option("jump_around_6") == "68") { echo " selected=\"selected\""; } echo ">d</option>
							<option value=\"69\"";if (get_option("jump_around_6") == "69") { echo " selected=\"selected\""; } echo ">e</option>
							<option value=\"70\"";if (get_option("jump_around_6") == "70") { echo " selected=\"selected\""; } echo ">f</option>
							<option value=\"71\"";if (get_option("jump_around_6") == "71") { echo " selected=\"selected\""; } echo ">g</option>
							<option value=\"72\"";if (get_option("jump_around_6") == "72") { echo " selected=\"selected\""; } echo ">h</option>
							<option value=\"73\"";if (get_option("jump_around_6") == "73") { echo " selected=\"selected\""; } echo ">i</option>
							<option value=\"74\"";if (get_option("jump_around_6") == "74") { echo " selected=\"selected\""; } echo ">j</option>
							<option value=\"75\"";if (get_option("jump_around_6") == "75") { echo " selected=\"selected\""; } echo ">k</option>
							<option value=\"76\"";if (get_option("jump_around_6") == "76") { echo " selected=\"selected\""; } echo ">l</option>
							<option value=\"77\"";if (get_option("jump_around_6") == "77") { echo " selected=\"selected\""; } echo ">m</option>
							<option value=\"78\"";if (get_option("jump_around_6") == "78") { echo " selected=\"selected\""; } echo ">n</option>
							<option value=\"79\"";if (get_option("jump_around_6") == "79") { echo " selected=\"selected\""; } echo ">o</option>
							<option value=\"80\"";if (get_option("jump_around_6") == "80") { echo " selected=\"selected\""; } echo ">p</option>
							<option value=\"81\"";if (get_option("jump_around_6") == "81") { echo " selected=\"selected\""; } echo ">q</option>
							<option value=\"82\"";if (get_option("jump_around_6") == "82") { echo " selected=\"selected\""; } echo ">r</option>
							<option value=\"83\"";if (get_option("jump_around_6") == "83") { echo " selected=\"selected\""; } echo ">s</option>
							<option value=\"84\"";if (get_option("jump_around_6") == "84") { echo " selected=\"selected\""; } echo ">t</option>
							<option value=\"85\"";if (get_option("jump_around_6") == "85") { echo " selected=\"selected\""; } echo ">u</option>
							<option value=\"86\"";if (get_option("jump_around_6") == "86") { echo " selected=\"selected\""; } echo ">v</option>
							<option value=\"87\"";if (get_option("jump_around_6") == "87") { echo " selected=\"selected\""; } echo ">w</option>
							<option value=\"88\"";if (get_option("jump_around_6") == "88") { echo " selected=\"selected\""; } echo ">x</option>
							<option value=\"89\"";if (get_option("jump_around_6") == "89") { echo " selected=\"selected\""; } echo ">y</option>
							<option value=\"90\"";if (get_option("jump_around_6") == "90") { echo " selected=\"selected\""; } echo ">z</option>
							<option value=\"48\"";if (get_option("jump_around_6") == "48") { echo " selected=\"selected\""; } echo ">0</option>
							<option value=\"49\"";if (get_option("jump_around_6") == "49") { echo " selected=\"selected\""; } echo ">1</option>
							<option value=\"50\"";if (get_option("jump_around_6") == "50") { echo " selected=\"selected\""; } echo ">2</option>
							<option value=\"51\"";if (get_option("jump_around_6") == "51") { echo " selected=\"selected\""; } echo ">3</option>
							<option value=\"52\"";if (get_option("jump_around_6") == "52") { echo " selected=\"selected\""; } echo ">4</option>
							<option value=\"53\"";if (get_option("jump_around_6") == "53") { echo " selected=\"selected\""; } echo ">5</option>
							<option value=\"54\"";if (get_option("jump_around_6") == "54") { echo " selected=\"selected\""; } echo ">6</option>
							<option value=\"55\"";if (get_option("jump_around_6") == "55") { echo " selected=\"selected\""; } echo ">7</option>
							<option value=\"56\"";if (get_option("jump_around_6") == "56") { echo " selected=\"selected\""; } echo ">8</option>
							<option value=\"57\"";if (get_option("jump_around_6") == "57") { echo " selected=\"selected\""; } echo ">9</option>
							<option value=\"37\"";if (get_option("jump_around_6") == "37") { echo " selected=\"selected\""; } echo ">left arrow</option>
							<option value=\"38\"";if (get_option("jump_around_6") == "38") { echo " selected=\"selected\""; } echo ">up arrow</option>
							<option value=\"39\"";if (get_option("jump_around_6") == "39") { echo " selected=\"selected\""; } echo ">right arrow</option>
							<option value=\"40\"";if (get_option("jump_around_6") == "40") { echo " selected=\"selected\""; } echo ">down arrow</option>
						</select></td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"jump_around_7\">Older posts key</label></th>
						<td><select name=\"jump_around_7\">
							<option value=\"65\"";if (get_option("jump_around_7") == "65") { echo " selected=\"selected\""; } echo ">a</option>
							<option value=\"66\"";if (get_option("jump_around_7") == "66") { echo " selected=\"selected\""; } echo ">b</option>
							<option value=\"67\"";if (get_option("jump_around_7") == "67") { echo " selected=\"selected\""; } echo ">c</option>
							<option value=\"68\"";if (get_option("jump_around_7") == "68") { echo " selected=\"selected\""; } echo ">d</option>
							<option value=\"69\"";if (get_option("jump_around_7") == "69") { echo " selected=\"selected\""; } echo ">e</option>
							<option value=\"70\"";if (get_option("jump_around_7") == "70") { echo " selected=\"selected\""; } echo ">f</option>
							<option value=\"71\"";if (get_option("jump_around_7") == "71") { echo " selected=\"selected\""; } echo ">g</option>
							<option value=\"72\"";if (get_option("jump_around_7") == "72") { echo " selected=\"selected\""; } echo ">h</option>
							<option value=\"73\"";if (get_option("jump_around_7") == "73") { echo " selected=\"selected\""; } echo ">i</option>
							<option value=\"74\"";if (get_option("jump_around_7") == "74") { echo " selected=\"selected\""; } echo ">j</option>
							<option value=\"75\"";if (get_option("jump_around_7") == "75") { echo " selected=\"selected\""; } echo ">k</option>
							<option value=\"76\"";if (get_option("jump_around_7") == "76") { echo " selected=\"selected\""; } echo ">l</option>
							<option value=\"77\"";if (get_option("jump_around_7") == "77") { echo " selected=\"selected\""; } echo ">m</option>
							<option value=\"78\"";if (get_option("jump_around_7") == "78") { echo " selected=\"selected\""; } echo ">n</option>
							<option value=\"79\"";if (get_option("jump_around_7") == "79") { echo " selected=\"selected\""; } echo ">o</option>
							<option value=\"80\"";if (get_option("jump_around_7") == "80") { echo " selected=\"selected\""; } echo ">p</option>
							<option value=\"81\"";if (get_option("jump_around_7") == "81") { echo " selected=\"selected\""; } echo ">q</option>
							<option value=\"82\"";if (get_option("jump_around_7") == "82") { echo " selected=\"selected\""; } echo ">r</option>
							<option value=\"83\"";if (get_option("jump_around_7") == "83") { echo " selected=\"selected\""; } echo ">s</option>
							<option value=\"84\"";if (get_option("jump_around_7") == "84") { echo " selected=\"selected\""; } echo ">t</option>
							<option value=\"85\"";if (get_option("jump_around_7") == "85") { echo " selected=\"selected\""; } echo ">u</option>
							<option value=\"86\"";if (get_option("jump_around_7") == "86") { echo " selected=\"selected\""; } echo ">v</option>
							<option value=\"87\"";if (get_option("jump_around_7") == "87") { echo " selected=\"selected\""; } echo ">w</option>
							<option value=\"88\"";if (get_option("jump_around_7") == "88") { echo " selected=\"selected\""; } echo ">x</option>
							<option value=\"89\"";if (get_option("jump_around_7") == "89") { echo " selected=\"selected\""; } echo ">y</option>
							<option value=\"90\"";if (get_option("jump_around_7") == "90") { echo " selected=\"selected\""; } echo ">z</option>
							<option value=\"48\"";if (get_option("jump_around_7") == "48") { echo " selected=\"selected\""; } echo ">0</option>
							<option value=\"49\"";if (get_option("jump_around_7") == "49") { echo " selected=\"selected\""; } echo ">1</option>
							<option value=\"50\"";if (get_option("jump_around_7") == "50") { echo " selected=\"selected\""; } echo ">2</option>
							<option value=\"51\"";if (get_option("jump_around_7") == "51") { echo " selected=\"selected\""; } echo ">3</option>
							<option value=\"52\"";if (get_option("jump_around_7") == "52") { echo " selected=\"selected\""; } echo ">4</option>
							<option value=\"53\"";if (get_option("jump_around_7") == "53") { echo " selected=\"selected\""; } echo ">5</option>
							<option value=\"54\"";if (get_option("jump_around_7") == "54") { echo " selected=\"selected\""; } echo ">6</option>
							<option value=\"55\"";if (get_option("jump_around_7") == "55") { echo " selected=\"selected\""; } echo ">7</option>
							<option value=\"56\"";if (get_option("jump_around_7") == "56") { echo " selected=\"selected\""; } echo ">8</option>
							<option value=\"57\"";if (get_option("jump_around_7") == "57") { echo " selected=\"selected\""; } echo ">9</option>
							<option value=\"37\"";if (get_option("jump_around_7") == "37") { echo " selected=\"selected\""; } echo ">left arrow</option>
							<option value=\"38\"";if (get_option("jump_around_7") == "38") { echo " selected=\"selected\""; } echo ">up arrow</option>
							<option value=\"39\"";if (get_option("jump_around_7") == "39") { echo " selected=\"selected\""; } echo ">right arrow</option>
							<option value=\"40\"";if (get_option("jump_around_7") == "40") { echo " selected=\"selected\""; } echo ">down arrow</option>
						</select></td>
					</tr>
					<tr valign=\"top\">
						<th scope=\"row\"><label for=\"jump_around_8\">Newer posts key</label></th>
						<td><select name=\"jump_around_8\">
							<option value=\"65\"";if (get_option("jump_around_8") == "65") { echo " selected=\"selected\""; } echo ">a</option>
							<option value=\"66\"";if (get_option("jump_around_8") == "66") { echo " selected=\"selected\""; } echo ">b</option>
							<option value=\"67\"";if (get_option("jump_around_8") == "67") { echo " selected=\"selected\""; } echo ">c</option>
							<option value=\"68\"";if (get_option("jump_around_8") == "68") { echo " selected=\"selected\""; } echo ">d</option>
							<option value=\"69\"";if (get_option("jump_around_8") == "69") { echo " selected=\"selected\""; } echo ">e</option>
							<option value=\"70\"";if (get_option("jump_around_8") == "70") { echo " selected=\"selected\""; } echo ">f</option>
							<option value=\"71\"";if (get_option("jump_around_8") == "71") { echo " selected=\"selected\""; } echo ">g</option>
							<option value=\"72\"";if (get_option("jump_around_8") == "72") { echo " selected=\"selected\""; } echo ">h</option>
							<option value=\"73\"";if (get_option("jump_around_8") == "73") { echo " selected=\"selected\""; } echo ">i</option>
							<option value=\"74\"";if (get_option("jump_around_8") == "74") { echo " selected=\"selected\""; } echo ">j</option>
							<option value=\"75\"";if (get_option("jump_around_8") == "75") { echo " selected=\"selected\""; } echo ">k</option>
							<option value=\"76\"";if (get_option("jump_around_8") == "76") { echo " selected=\"selected\""; } echo ">l</option>
							<option value=\"77\"";if (get_option("jump_around_8") == "77") { echo " selected=\"selected\""; } echo ">m</option>
							<option value=\"78\"";if (get_option("jump_around_8") == "78") { echo " selected=\"selected\""; } echo ">n</option>
							<option value=\"79\"";if (get_option("jump_around_8") == "79") { echo " selected=\"selected\""; } echo ">o</option>
							<option value=\"80\"";if (get_option("jump_around_8") == "80") { echo " selected=\"selected\""; } echo ">p</option>
							<option value=\"81\"";if (get_option("jump_around_8") == "81") { echo " selected=\"selected\""; } echo ">q</option>
							<option value=\"82\"";if (get_option("jump_around_8") == "82") { echo " selected=\"selected\""; } echo ">r</option>
							<option value=\"83\"";if (get_option("jump_around_8") == "83") { echo " selected=\"selected\""; } echo ">s</option>
							<option value=\"84\"";if (get_option("jump_around_8") == "84") { echo " selected=\"selected\""; } echo ">t</option>
							<option value=\"85\"";if (get_option("jump_around_8") == "85") { echo " selected=\"selected\""; } echo ">u</option>
							<option value=\"86\"";if (get_option("jump_around_8") == "86") { echo " selected=\"selected\""; } echo ">v</option>
							<option value=\"87\"";if (get_option("jump_around_8") == "87") { echo " selected=\"selected\""; } echo ">w</option>
							<option value=\"88\"";if (get_option("jump_around_8") == "88") { echo " selected=\"selected\""; } echo ">x</option>
							<option value=\"89\"";if (get_option("jump_around_8") == "89") { echo " selected=\"selected\""; } echo ">y</option>
							<option value=\"90\"";if (get_option("jump_around_8") == "90") { echo " selected=\"selected\""; } echo ">z</option>
							<option value=\"48\"";if (get_option("jump_around_8") == "48") { echo " selected=\"selected\""; } echo ">0</option>
							<option value=\"49\"";if (get_option("jump_around_8") == "49") { echo " selected=\"selected\""; } echo ">1</option>
							<option value=\"50\"";if (get_option("jump_around_8") == "50") { echo " selected=\"selected\""; } echo ">2</option>
							<option value=\"51\"";if (get_option("jump_around_8") == "51") { echo " selected=\"selected\""; } echo ">3</option>
							<option value=\"52\"";if (get_option("jump_around_8") == "52") { echo " selected=\"selected\""; } echo ">4</option>
							<option value=\"53\"";if (get_option("jump_around_8") == "53") { echo " selected=\"selected\""; } echo ">5</option>
							<option value=\"54\"";if (get_option("jump_around_8") == "54") { echo " selected=\"selected\""; } echo ">6</option>
							<option value=\"55\"";if (get_option("jump_around_8") == "55") { echo " selected=\"selected\""; } echo ">7</option>
							<option value=\"56\"";if (get_option("jump_around_8") == "56") { echo " selected=\"selected\""; } echo ">8</option>
							<option value=\"57\"";if (get_option("jump_around_8") == "57") { echo " selected=\"selected\""; } echo ">9</option>
							<option value=\"37\"";if (get_option("jump_around_8") == "37") { echo " selected=\"selected\""; } echo ">left arrow</option>
							<option value=\"38\"";if (get_option("jump_around_8") == "38") { echo " selected=\"selected\""; } echo ">up arrow</option>
							<option value=\"39\"";if (get_option("jump_around_8") == "39") { echo " selected=\"selected\""; } echo ">right arrow</option>
							<option value=\"40\"";if (get_option("jump_around_8") == "40") { echo " selected=\"selected\""; } echo ">down arrow</option>
							</select></td>
						</tr>
		";
		}
		
		## options page (output)
		function momja_page_content() { 
			echo "	
			<div class=\"wrap\">
				<div id=\"icon-options-general\" class=\"icon32\"></div>
				<h2>Jump Around</h2>
				<p>Navigate posts by pressing keys on the keyboard.</p>		
				<p>
					Default keys:<br />
					<strong>a</strong> : previous / 
					<strong>d</strong> : next / 
					<strong>s</strong> : open currently selected post / 
					<strong>z</strong> : older posts / 
					<strong>x</strong> : newer posts 
				</p>
				<p>Adds a class of .current to the currently selected item (which you can style in .css). Custom keys must not be the same.  Each one must be different.</p>";
				if(isset($_POST['update_JA'])){
					echo "<div id=\"setting-error-settings_updated\" class=\"updated settings-error\"><p>Settings saved.</p></div>";
				}		
				echo "
				<form method=\"post\">
					<table class=\"form-table\">
						<tbody>
					";
					print_jump_around_form();
					echo "
						</tbody>
					</table>
					<p class=\"submit\">
						<input id=\"update_JA\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"update_JA\"></input>
					</p>
				</form>
				";
				if ($_REQUEST["update_JA"]) { update_JA(); }
				echo "
				<p>If you can not get this to work with your current theme, some minor template modifications may be in order.  However, since every theme is potentially unique from the last, I can't exactly give you step-by-step instructions on how to edit your current theme.</p>
				<p>If you are unsure of how to edit templates, your best resources are as follows: <a href=\"http://reddit.com/r/wordpress/\">/r/Wordpress on Reddit</a>, <a href=\"http://stackoverflow.com/\">Stack Overflow</a>, or the <a href=\"http://wordpress.org/support/\">Wordpress.org Support Forums</a>.</p>
				<p>Firefox users may easily find class names by right-clicking on the element in question and using the <strong>Inspect Element</strong> to figure out the class name of your current item.</p>
				<p><em>Thanks to <a href=\"http://stackoverflow.com/questions/1939041/change-hash-without-reload-in-jquery\">jitter</a> &amp; <a href=\"http://stackoverflow.com/questions/13694277/scroll-to-next-div-using-arrow-keys\">mVChr</a></em></p>
			</div>";
		}
	}
	
	## footer script contents
	function jump_around_footer_script(){
		if (is_archive() || is_home() || is_search() ) { 
			echo "
			<script type=\"text/javascript\">
			jQuery( document ).ready( function($) {

			\$('input,textarea').keydown( function(e) {
				e.stopPropagation();
			});

			var hash = window.location.hash.substr(1);
			if(hash != false && hash != 'undefined') {
				\$('#'+hash+'').addClass('current');
				\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_4") . ":
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$prev_embed = \$current.prev();
						\$('html, body').animate({scrollTop:\$prev_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$prev_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_6") . ": 
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$next_embed = \$current.next('" . get_option("jump_around_0") . "');
						\$('html, body').animate({scrollTop:\$next_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$next_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_5") . ": 
							if(jQuery('.current " . get_option("jump_around_1") . "').attr('href'))
							document.location.href=jQuery('.current " . get_option("jump_around_1") . "').attr('href');
							e.preventDefault();
							return;
							break;
					default: return; 
				}
				
			});
			}else{
			\$('" . get_option("jump_around_0") . ":eq(0)').addClass('current');
			\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_4") . ": 
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$prev_embed = \$current.prev();
						\$('html, body').animate({scrollTop:\$prev_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$prev_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_6") . ": 
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$next_embed = \$current.next('" . get_option("jump_around_0") . "');
						\$('html, body').animate({scrollTop:\$next_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$next_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_5") . ": 
							if(jQuery('.current " . get_option("jump_around_1") . "').attr('href'))
							document.location.href=jQuery('.current " . get_option("jump_around_1") . "').attr('href');
							e.preventDefault();
							return;
							break;
				}
				
			});
			}

			if (\$('" . get_option("jump_around_2") . "').is('*')) {
			\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_7") . ": 
						document.location.href=jQuery('" . get_option("jump_around_2") . "').attr('href');
						e.preventDefault();
						return;
						break;
				}
				
			});
			}

			if (\$('" . get_option("jump_around_3") . "').is('*')) {
			\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_8") . ": 
						document.location.href=jQuery('" . get_option("jump_around_3") . "').attr('href');
						e.preventDefault();
						return;
						break;
				}
				
			});
			}
			});
			</script>
			";
		}
	} 
?>