<?php
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
?>