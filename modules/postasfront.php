<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: POST AS FRONT

    if (is_admin() ) { 
    
        function my_optional_modules_post_as_front_module() {

            if( isset( $_POST[ 'mompafsave' ] ) ) { 
                update_option( 'mompaf_post',$_REQUEST[ 'mompaf_post' ] ); 
            } 

            function mompaf_form() {
                echo "
                <div class=\"settingsExtra\">
                    <select id=\"mompaf_post\" type=\"text\" name=\"mompaf_post\">
                        <option value=\"0\">Most recent post</option>";
                
                        $showmeposts = get_posts( array( 'posts_per_page' => -1 ) ); 
                        foreach ( $showmeposts as $postsshown ) {
                            echo "
                            <option value=\"" . $postsshown->ID . "\""; 
                            if ( get_option( 'mompaf_post' ) == $postsshown->ID ) { 
                                echo " selected=\"selected\""; 
                            }
                            echo "
                            >$postsshown->post_title</option>";
                        }
                        
                        echo "
                    </select>
                    <input id=\"mompafsave\" type=\"submit\" value=\"Save\" name=\"mompafsave\">
                </div>";
            }

                mompaf_form();

            }
        
        my_optional_modules_post_as_front_module();
        
    }
    
?>