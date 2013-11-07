<?php 

    // Font Awesome shortcodes
    add_shortcode('font-fa', 'font_fa_shortcode');
    add_filter('the_content', 'do_shortcode', 'font_fa_shortcode');    
    
    function font_fa_shortcode($atts, $content = null) {
        extract(
            shortcode_atts(array(
                "i" => '',
            ), $atts)
        );    
        $icon = sanitize_text_field($i);
        if ( $icon != "" ) { $iconfinal = $icon; }
        ob_start();
        echo "<i class=\"fa fa-" . $iconfinal . "\"></i>";
        return ob_get_clean();    
    }
 
?>