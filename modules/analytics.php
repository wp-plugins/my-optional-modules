<?php 
	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }
	if (is_admin() ) { 
		echo "
		<div class=\"settingsExtra\">
		<input id=\"momanalytics_code\" type=\"text\" name=\"momanalytics_code\" value=\"" . get_option("momanalytics_code") . "\" placeholder=\"UA-XXXXXXXX-X\">
		<input id=\"momanasave\" type=\"submit\" value=\"Save\" name=\"momanasave\"></input>
		</div>
		";

		if(isset($_POST["momanasave"])){ 
			update_option("momanalytics_code",$_REQUEST["momanalytics_code"]);
			echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";			
		}
	}
?>