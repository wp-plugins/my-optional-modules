<?php 

	// Module name: Analytics
	// Module contents
	//   - options form (save)
	//   - options form (output)
	//   - options page (output)

	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

	if (is_admin() ) { 
	
		// options form (save)
		function update_momana_options() {
			if(isset($_POST['momanasave'])){
				update_option("momanalytics_code",$_REQUEST["momanalytics_code"]);
			}		
		}
		
		// options form (output)
		function momana_form() {
			echo "
				<tr valign=\"top\">
					<td>
						<a href=\"https://support.google.com/analytics/answer/1032385?hl=en\">(?)</a> 
						<input id=\"momanalytics_code\" class=\"regular-text\" type=\"text\" name=\"momanalytics_code\" value=\"" . get_option("momanalytics_code") . "\" placeholder=\"UA-XXXXXXXX-X\">
						<input id=\"momanasave\" class=\"button button-primary\" type=\"submit\" value=\"Save Changes\" name=\"momanasave\"></input>
					</td>
				</tr>
			";
		}
	
		// options page (output)
		
			echo "
				<form method=\"post\">
					<table class=\"form-table\"  style=\"margin-top: -8px; margin-left: -10px;\">
						<tbody>
			";
			momana_form();
			echo "
						</tbody>
					</table>
				</form>			
			";
			if(isset($_POST["momanasave"])){ update_momana_options(); } 
		
	}
?>