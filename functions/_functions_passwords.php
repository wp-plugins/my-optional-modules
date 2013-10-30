<?php 

    //  add shortcode
    add_shortcode('rups', 'rotating_universal_passwords_shortcode');    
    add_filter('the_content', 'do_shortcode', 'rotating_universal_passwords_shortcode');        
    
    // shortcode content
    function rotating_universal_passwords_shortcode($atts, $content = null) {
        ob_start();
        global $my_optional_modules_passwords_salt;
        if ( isset($_SERVER["REMOTE_ADDR"]) ) { 
            $RUPs_origin = $_SERVER["REMOTE_ADDR"]; 
        } else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) { 
            $RUPs_origin = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
        } else if ( isset($_SERVER["HTTP_CLIENT_IP"]) ) { 
            $RUPs_origin = $_SERVER["HTTP_CLIENT_IP"]; 
        }
        $RUPs_ip_addr = $RUPs_origin; 
        $RUPs_s32int = ip2long($RUPs_ip_addr); 
        $RUPs_us32str = sprintf("%u",$RUPs_s32int);            
        if (date("D") === "Sun") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_1"); $rotating_universal_passwords_today_is = "Sunday"; }
        if (date("D") === "Mon") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_2"); $rotating_universal_passwords_today_is = "Monday"; }
        if (date("D") === "Tue") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_3"); $rotating_universal_passwords_today_is = "Tuesday"; }
        if (date("D") === "Wed") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_4"); $rotating_universal_passwords_today_is = "Wednesday"; }
        if (date("D") === "Thu") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_5"); $rotating_universal_passwords_today_is = "Thursday"; }
        if (date("D") === "Fri") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_6"); $rotating_universal_passwords_today_is = "Friday"; }
        if (date("D") === "Sat") { $rotating_universal_passwords_todays_password = get_option("rotating_universal_passwords_7"); $rotating_universal_passwords_today_is = "Saturday"; }    
        $rups_md5passa = hash("sha512", $my_optional_modules_passwords_salt . $_POST['rups_pass']);
        global $wpdb;
        $RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
        $RUPs_result = $wpdb->get_results ("SELECT ID FROM $RUPs_table_name WHERE IP = '".$RUPs_s32int."'");
        if (isset($_POST['rups_pass'])) {
            if ($rups_md5passa === $rotating_universal_passwords_todays_password) {        
                if (count ($RUPs_result) > 0) {
                    $RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
                    $wpdb->query(" DELETE FROM $RUPs_table_name WHERE IP = '$RUPs_s32int' ");
            }
                return $content;
            } else {
                $RUPs_date = date("Y-m-d H:i:s");  
                $RUPs_table_name = $wpdb->prefix . "rotating_universal_passwords";
                $RUPs_URL = get_permalink();
                
                if (count ($RUPs_result) > 0) {
                    $wpdb->query("UPDATE $RUPs_table_name SET ATTEMPTS = ATTEMPTS + 1 WHERE IP = $RUPs_s32int");
                    $wpdb->query("UPDATE $RUPs_table_name SET DATE = '$RUPs_date' WHERE IP = $RUPs_s32int");
                    $wpdb->query("UPDATE $RUPs_table_name SET URL = '",get_permalink(),"' WHERE IP = $RUPs_s32int");
                } else {
                    $wpdb->query("INSERT INTO $RUPs_table_name (ID, DATE, IP, ATTEMPTS, URL) VALUES ('','$RUPs_date','$RUPs_s32int','1','$RUPs_URL')") ;
                }
            }
        }
        $RUPs_attempts = $wpdb->get_results ("SELECT DATE,ATTEMPTS FROM $RUPs_table_name WHERE IP = '".$RUPs_s32int."'");
        if (count ($RUPs_attempts) > 0) {
            foreach ($RUPs_attempts as $RUPs_attempt_count) {
                $RUPs_attempted = $RUPs_attempt_count->ATTEMPTS;
                $RUPs_dated = $RUPs_attempt_count->DATE;
                if ($RUPs_attempted < get_option("rotating_universal_passwords_8") ) {
                    if(isset($_POST)) {
                        echo "<form method=\"post\" action=\"",get_permalink(),"\">
                        <input type=\"text\" name=\"rups_pass\" placeholder=\"Today is ",$rotating_universal_passwords_today_is,".\" >
                        <input type=\"submit\" name=\"submit\" class=\"submit\" value=\"Submit\" >
                        </form>";
                    }
                }
                elseif ($RUPs_attempted >= get_option("rotating_universal_passwords_8") ) { 
                    echo "<blockquote>You have been locked out.  If you feel this is an error, please contact the admin with the following <strong>id:",$RUPs_s32int,"</strong> to inquire further.</blockquote>";
                } else {            
                    if(isset($_POST)) {
                        echo "<form method=\"post\" action=\"",get_permalink(),"\">
                        <input type=\"text\" name=\"rups_pass\" placeholder=\"Today is ",$rotating_universal_passwords_today_is,".\" >
                        <input type=\"submit\" name=\"submit\" class=\"submit\" value=\"Submit\" >
                        </form>";
                    }
                }
            }
        } else {
            if(isset($_POST)) {
                echo "<form method=\"post\" action=\"",get_permalink(),"\">
                <input type=\"text\" name=\"rups_pass\" placeholder=\"Today is ",$rotating_universal_passwords_today_is,".\" >
                <input type=\"submit\" name=\"submit\" class=\"submit\" value=\"Submit\" >
                </form>";
            }            
        }
        return ob_get_clean();
    }
?>