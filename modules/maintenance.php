<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: MAINTENANCE

    if (is_admin() ) {
        function my_optional_modules_maintenance_module() {
            function update_maintenance_mom() {
                update_option( 'momMaintenance_url',sanitize_text_field( $_REQUEST[ 'momMaintenance_url'   ] ) );
            }
            if ($_REQUEST["update_maintenance_mom"]) { update_maintenance_mom(); }
            function print_maintenance_form() {
                echo "
				<div class=\"settingsExtra\">
				<form method=\"post\">
					<label for=\"momMaintenance_url\">Outside URL here:</label>
					<input type=\"text\" name=\"momMaintenance_url\" value=\"" . get_option( 'momMaintenance_url' ) . "\" />
				<input id=\"update_maintenance_mom\" type=\"submit\" value=\"Save\" name=\"update_maintenance_mom\">
				</form>
				</div>";
            }
			print_maintenance_form();
        }
    }
    my_optional_modules_maintenance_module();
    
?>