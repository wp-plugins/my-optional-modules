<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //MY OPTIONAL MODULES
    //MODULE: FONT AWESOME SHORTCODES

    if (is_admin() ) {
        function my_optional_modules_fontfa_module() {
            function mom_fontfa_page_content() {
                echo "
                <div class=\"wrap\">
                <h2>Font Awesome Shortcodes</h2>
                <p>Current version: <code>4.0</code></p>
                <p>Usage: <code>[font-fa i=\"iconName\"]</code>.</p>
                <p>Icons are found <a href=\"http://fortawesome.github.io/Font-Awesome/icons/\">here</a>.  Each icon has a name (like this: fa-adjust).  For the shortcode, you don't need <code>fa-</code>. So, for <code><i class=\"fa fa-adjust\"></i> fa-adjust</code>, you'd simply need to type <code>[font-fa i=\"adjust\"]</code></p>
                </div>
                ";
            }
            mom_fontfa_page_content();
        }
    }
    my_optional_modules_fontfa_module();
    
?>