<?php

	$momverifier_verification_step = 0;

    // Google map embed 
    add_shortcode('mom_map', 'mom_google_map_shortcode');
    add_filter('the_content', 'do_shortcode', 'mom_map');
    function mom_google_map_shortcode($atts, $content = null) {
        ob_start();
        extract(
            shortcode_atts(array(
                "width" => '100%',
                "height" => '350px',
                "frameborder" => '0',
                "align" => 'center',
                "address" => '',
                "info_window" => 'A',
                "zoom" => '14',
                "companycode" => ''
            ), $atts)
        );
        $mgms_output = 'q=' . urlencode($address) . '&cid=' . urlencode($companycode);
        echo "
        <div class=\"mom_map\">
            <iframe align=\"" . $align . "\" width=\"" . $width . "\" height=\"" . $height . "\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&amp;" . htmlentities($mgms_output) . "&amp;output=embed&amp;z=" . $zoom . "&amp;iwloc=" . $info_window . "&amp;visual_refresh=true\"></iframe>
        </div>
        ";
        return ob_get_clean();
    }
        
    // Reddit submit button
    add_shortcode('mom_reddit', 'mom_reddit_shortcode');
    add_filter('the_content', 'do_shortcode', 'mom_reddit');
    function mom_reddit_shortcode($atts, $content = null) {
        global $wpdb, $id, $post_title;
        $query = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND ID = '$id'";
        $reddit = $wpdb->get_results($query);
        if ($reddit) {
            foreach ($reddit as $reddit_info) {
                $post_title = strip_tags($reddit_info->post_title);
            }
        extract(
            shortcode_atts(array(
                "url" => '' . $get_permalink . '',
                "target" => '',
                "title" => '' . $post_title . '',
                "bgcolor" => '',
                "border" => ''
            ), $atts)
        );
        ob_start();
        echo "
        <div class=\"mom_reddit\">
        <script type=\"text/javascript\">
            reddit_url = \"" . $url . "\";
            reddit_target = \"" . $target . "\";
            reddit_title = \"" . $title . "\";
            reddit_bgcolor = \"" . $bgcolor . "\";
            reddit_bordercolor = \"" . $border . "\";
        </script>
        <script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
        </div>";
        return ob_get_clean();
        }
    }

    // Restrict content to logged in users
    add_shortcode('mom_restrict', 'mom_restrict_shortcode');
    add_filter('the_content', 'do_shortcode', 'mom_restrict');
    function mom_restrict_shortcode($atts, $content = null) {
        extract(
            shortcode_atts(array(
                "message" => 'You must be logged in to view this content.',
                "comments" => '',
                "form" => ''
            ), $atts)
        );
        ob_start();
        if ( is_user_logged_in() ) {
            return $content;
        } else {
            echo "<div class=\"mom_restrict\">" . htmlentities($message) . "</div>";
            if ($comments == "1") {
                add_filter( 'comments_template', 'restricted_comments_view' );
                function restricted_comments_view( $comment_template ) {
                    return dirname( __FILE__) . '/comment_template.php';
                }
            }
            if ($comments == "2") {
                add_filter( 'comments_open', 'restricted_comments_form', 10, 2 );
                function restricted_comments_form( $open, $post_id ) {
                    $post = get_post( $post_id );
                    $open = false;
                    return $open;
                }    
            }
        }        
        return ob_get_clean();
    }
    
    // Progress bars
    add_shortcode('mom_progress', 'mom_progress_shortcode');
    add_filter('the_content', 'do_shortcode', 'mom_progress');
    function mom_progress_shortcode($atts, $content = null) {
        extract(
            shortcode_atts(array(
                "align" => 'none',
                "fillcolor" => '#ccc',
                "maincolor" => '#000',
                "height" => '15',
                "fontsize" => '15',
                "level" => '',
                "margin" => '0 auto',
                "talign" => 'center',
                "width" => '95%',
            ), $atts)
        );
        $align_fetch = sanitize_text_field ($align);
        $fillcolor_fetch = sanitize_text_field ($fillcolor);
        $height_fetch = sanitize_text_field ($height);
        $level_fetch = sanitize_text_field ($level);
        $maincolor_fetch = sanitize_text_field ($maincolor);
        $margin_fetch = sanitize_text_field ($margin);
        $width_fetch = sanitize_text_field ($width);
        ob_start();
        if ( $align_fetch == "left" ) { $align_fetch_final = "float: left;"; }
        elseif ($align_fetch == "right" ) { $align_fetch_final = "float: right;"; }
        else { $align_fetch_final = "clear: both; "; }
        echo "<div class=\"mom_progress\" style=\"" . $align_fetch_final . "; height:" . $height_fetch . "px; display: block; width:" . $width_fetch . "%;  margin: $margin_fetch; background-color:" . $maincolor_fetch . "\"><div style=\"display: block; height:" . $height_fetch . "px; width:" . $level_fetch . "%; background-color: $fillcolor_fetch;\"></div></div>";
        return ob_get_clean();
    }
	
    // Verifier
    add_shortcode('mom_verify', 'mom_verify_shortcode');
    add_filter('the_content', 'do_shortcode', 'mom_verify');
    function mom_verify_shortcode($atts, $content = null) {
		global $post;
		// Determine origin IP
        if ( isset($_SERVER["REMOTE_ADDR"]) ) { 
            $ipAddress = $_SERVER["REMOTE_ADDR"]; 
        } else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) { 
            $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
        } else if ( isset($_SERVER["HTTP_CLIENT_IP"]) ) { 
            $ipAddress = $_SERVER["HTTP_CLIENT_IP"]; 
        }
		$ipaddress = ip2long($ipAddress);
		if ( is_numeric( $ipaddress ) ) { 
			$theIP = $ipaddress; } else {
			$theIP = 0;
		}
		// Shortcode arguments
		ob_start();
        extract(
            shortcode_atts(array(
                "age"          => '',
				"answer"       => '',
				"logged"       => 1,
				"message"      => 'Please verify your age by typing it here',
				"fail"         => 'You are not able to view this content at this time.',
				"logging"      => 0,
				"background"   => 'transparent',
				"stats"        => '',
				"single"       => 0,
				"cmessage"     => 'Correct',
				"imessage"     => 'Incorrect',
				"deactivate"   => 0
            ), $atts)
        );
		// sanitization techniques for all inputs
		global $momverifier_verification_step;
		$momverifier_verification_step++;
		$thePostId              = $post->ID;
		$theBackground          = sanitize_text_field( strip_tags( htmlentities( $background ) ) );
		$theAge                 = sanitize_text_field( strip_tags( htmlentities( $age        ) ) );
		$isLogged               = sanitize_text_field( strip_tags( htmlentities( $logged     ) ) );
		$theMessage             = sanitize_text_field( strip_tags( htmlentities( $message    ) ) );
		$theAnswer              = sanitize_text_field( strip_tags( htmlentities( $answer     ) ) );
		$failMessage            = sanitize_text_field( strip_tags( htmlentities( $fail       ) ) );
		$isLogged               = sanitize_text_field( strip_tags( htmlentities( $logged     ) ) );
		$isLogging              = sanitize_text_field( strip_tags( htmlentities( $logging    ) ) );
		$attempts               = sanitize_text_field( strip_tags( htmlentities( $single     ) ) );
		$correctResultMessage   = sanitize_text_field( strip_tags( htmlentities( $cmessage   ) ) );
		$incorrectResultMessage = sanitize_text_field( strip_tags( htmlentities( $imessage   ) ) );
		$isDeactivated          = sanitize_text_field( strip_tags( htmlentities( $deactivate ) ) );
		$verificationID         = $momverifier_verification_step . '' . $thePostId;
		$statsMessage           = sanitize_text_field( strip_tags( htmlentities( $stats      ) ) );
        $alreadyAttempted       = 0;
		
		if ( is_numeric( $attempts ) && $attempts == 1 ) {
			global $wpdb;
			$verification_table_name    = $wpdb->prefix . $wpdb->suffix . "momverification";
			$getNumberofAttempts        = $wpdb->get_results ("SELECT IP,POST,CORRECT FROM $verification_table_name WHERE IP = '".$theIP."' AND POST = '" . $verificationID . "'");	
			$alreadyAttempted           = count( $getNumberofAttempts);
			foreach ($getNumberofAttempts as $numberofattempts) {
				$isCorrect = $numberofattempts->CORRECT;
			}
		}
		
		// Question/verification form and logic
		if ( is_numeric($isLogged) && $isLogged == 0 && is_user_logged_in() ) {
			$isCorrect = 1;
		} elseif ( is_numeric( $isLogged ) && $isLogged == 1 ) {		
			
			if ( $alreadyAttempted != 1 ) {
				if ( !$_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] != '' && $isDeactivated != 1 ) {
				return "
				<blockquote style=\"display:block;clear:both;margin:5px auto 5px auto;padding:5px;font-size:25px;\">
				<p>" . $theMessage . "</p>
				<form style=\"clear:both;display:block;padding:5px;margin:0 auto 5px auto;width:98%;overflow:hidden;border-radius:3px;background-color:#" . $theBackground . ";\" class=\"momAgeVerification\" method=\"post\" action=\"" . get_permalink() . "\">
					<input style=\"clear:both;font-size:25px;width:99%;margin:0 auto;\" type=\"text\" name=\"ageVerification" . $momverifier_verification_step . $thePostId . "\">
					<input style=\"clear:both;font-size:20px;width:100%;margin:0 auto;\" type=\"submit\" name=\"submit\" class=\"submit\" value=\"Submit\" >
				</form>
				</blockquote>
				";
				}
			}
			
			if ( $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] != '' ) {
				if ( $theAge != '' && is_numeric( $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] ) && $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] ) {
					$ageEntered    = ( $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] );
					if ( $ageEntered >= $theAge ) {
						$isCorrect = 1;
					} else {
						$isCorrect = 0;
					}
				} elseif ( $theAnswer != '' && $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] ) {
					$answerGiven   = ( $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] );
					$correctAnswer = strtolower( $theAnswer   );
					$answered      = strtolower( $answerGiven );					
					if ( $answered === $correctAnswer ) {
						$isCorrect = 1;
					} else {
						$isCorrect = 0;
					}
				}		
			}			
		}
		// Logging
		if ( is_numeric( $isLogging ) && $isLogging == 1 || is_numeric( $isLogging ) && $isLogging == 3 || is_numeric( $attempts ) && $attempts == 1 ) {
			global $wpdb;
			$verification_table_name    = $wpdb->prefix . $wpdb->suffix . "momverification";
			$getIPforCurrentTransaction = $wpdb->get_results ("SELECT IP,POST FROM $verification_table_name WHERE IP = '".$theIP."' AND POST = '" . $verificationID . "'");
			if ( count ( $getIPforCurrentTransaction ) <= 0 && $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] ) {
				if ( $theAge != '' && is_numeric( $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] ) && $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] ) {
					$ageEntered    = ( $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] );
					if ( $ageEntered >= $theAge ) {		
					// correct answer
					$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','1','$theIP')");
					} else {
					// incorrect answer
					$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','0','$theIP')");
					}
				}
				elseif ( $theAnswer != '' && $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] ) {
					$answerGiven   = ( $_REQUEST[ 'ageVerification' . $momverifier_verification_step . $thePostId . '' ] );
					$correctAnswer = strtolower( $theAnswer   );
					$answered      = strtolower( $answerGiven );				
					if ( $answered === $correctAnswer ) {				
					// correct answer
					$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','1','$theIP')");
					} else {
					// incorrect answer
					$wpdb->query("INSERT INTO $verification_table_name (ID, POST, CORRECT, IP) VALUES ('','$verificationID','0','$theIP')");
					}
				}
			}
			// Statistics
			if ( $isLogging != 1 ) {
				$incorrect            = $wpdb->get_results ("SELECT CORRECT FROM $verification_table_name WHERE POST = '" . $verificationID . "' AND CORRECT = '0' ");
				$correct              = $wpdb->get_results ("SELECT CORRECT FROM $verification_table_name WHERE POST = '" . $verificationID . "' AND CORRECT = '1' ");
				$incorrectCount   = count ( $incorrect );
				$correctCount     = count ( $correct );
				if ( count ( $correct ) > 0 && count ( $incorrect ) > 0 ) { $totalCount = ( $incorrectCount + $correctCount ); } else { $totalCount = 1; }					
				$percentCorrect   = ( $correctCount/$totalCount * 100 );
				$percentIncorrect = ( $incorrectCount/$totalCount * 100 );
				if ( $statsMessage == '' ) { $statsMessage = $theMessage; }
				return "<div style=\"clear:both;display:block;width:99%;margin:10px auto 10px auto;overflow:auto;background-color:#f6fbff;border:1px solid #4a5863;border-radius:3px;padding:5px;\"><p>" . $statsMessage . "</p><div class=\"mom_progress\" style=\"clear:both; height:20px; display: block; width:95%;  margin:5px auto 5px auto; background-color:#ff0000\"><div title=\"" . $correctCount . "\" style=\"display: block; height:20px; width:" . $percentCorrect . "%; background-color:#1eff00;\"></div></div><div style=\"font-size:15px;margin:-5px auto;width:95%;\"><span style=\"float:left;text-align:left;\">" . $correctResultMessage . " (" . $percentCorrect . "%)</span><span style=\"float:right;text-align:right;\">" . $incorrectResultMessage . " (" . $percentIncorrect . "%)</span></div></div>";
			}
		}
		if ( $isCorrect == 1 ) {
			return $content;
		} elseif ( $isCorrect == 0 && $deactivate != 1 ) {
			return "<blockquote class=\"momAgeVerification\">" . $failMessage . "</blockquote>";
		}
        return ob_get_clean();
    }	
	
	
?>