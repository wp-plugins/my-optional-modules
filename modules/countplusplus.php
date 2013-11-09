<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: COUNT++

    if (is_admin() ) { 

        function my_optional_modules_count_module() {
    
            function update_obwcountplus_options() {
                if ( $_REQUEST[ 'obwcountplus_countdownfrom' ] != '' . get_option( 'obwcountplus_1_countdownfrom'   ) . '' && is_numeric( $_REQUEST[ 'obwcountplus_countdownfrom' ] ) ) { 
                    update_option( 'obwcountplus_1_countdownfrom',$_REQUEST[ 'obwcountplus_countdownfrom' ] ); 
                }
                if ( $_REQUEST[ 'obwcountplus_remaining'     ] != '' . get_option( 'obwcountplus_2_remaining'       ) . ""                                                            ) { 
                    update_option( 'obwcountplus_2_remaining',$_REQUEST[ 'obwcountplus_remaining' ] ); 
                }
                if ( $_REQUEST[ 'obwcountplus_total'         ] != '' . get_option( 'obwcountplus_3_total'           ) . ''                                                            ) { 
                    update_option( 'obwcountplus_3_total',$_REQUEST[ 'obwcountplus_total' ] ); 
                }
                if ( $_REQUEST[ 'obwcountplus_custom'        ] != '' . get_option( 'obwcountplus_4_custom'          ) . ''                                                            ) { 
                    update_option( 'obwcountplus_4_custom',$_REQUEST[ 'obwcountplus_custom' ] ); 
                }
                if ( $_REQUEST[ 'obwcountplus_countdownfrom' ] == ''                                                                                                                  ) { 
                    update_option( 'obwcountplus_1_countdownfrom','0' ); 
                }
                if ( $_REQUEST[ 'obwcountplus_remaining'     ] == ''                                                                                                                  ) { 
                    update_option( 'obwcountplus_2_remaining','remaining' ); 
                }
                if ( $_REQUEST[ 'obwcountplus_total'         ] == ''                                                                                                                  ) { 
                    update_option( 'obwcountplus_3_total','total' ); 
                }
                if ( $_REQUEST[ 'obwcountplus_custom'        ] == ''                                                                                                                  ) { 
                    update_option( 'obwcountplus_4_custom','' ); 
                }
            }
			
			
			
			

			function obwcountplus_form() {
                echo "
				<div class=\"countplus\">
				    <section>
                        <label for=\"obwcountplus_countdownfrom\">Goal (<em>0</em> for none)</label>
                        <input id=\"obwcountplus_countdownfrom\" type=\"text\" value=\"". get_option( 'obwcountplus_1_countdownfrom' ) . "\" name=\"obwcountplus_countdownfrom\">
                    </section>
				    <section>
                        <label for=\"obwcountplus_remaining\">Text for remaining</label>
                        <input id=\"obwcountplus_remaining\" type=\"text\" value=\"". get_option( 'obwcountplus_2_remaining' ) . "\" name=\"obwcountplus_remaining\">
                    </section>
				    <section>
                        <label for=\"obwcountplus_total\">Text for published</label>
                        <input id=\"obwcountplus_total\" type=\"text\" value=\"". get_option( 'obwcountplus_3_total' ) . "\" name=\"obwcountplus_total\">
                    </section>
                    <section>				
                        <label for=\"obwcountplus_custom\">Custom output</label>
                        <input id=\"obwcountplus_custom\" type=\"text\" value=\"". get_option( 'obwcountplus_4_custom' ) . "\" name=\"obwcountplus_custom\">
                    </section>    
                </div>";
            }





            function obwcountplus_page_content() {
                    echo "
                    <form method=\"post\">
						<span class=\"moduletitle\">__count++<em>let's play the counting game</em></span>
						<div class=\"clear\"></div>				
						<div class=\"settings\">";
                        obwcountplus_form();
                        echo "<input id=\"obwcountsave\" type=\"submit\" value=\"Save Changes\" name=\"obwcountsave\">
						
                    </form>
					
					<div class=\"templatetags\">
					<section>Custom output example: (with goal)<span class=\"right\">%total% words of %remain% published</span></section>
					<section>Custom output example: (without goal) <span class=\"right\">%total% words published</span></section>
					<section>Custom output example: (numbers only)(total on blog) <span class=\"right\">%total%</span></section>
					<section>Custom output example: (numbers only)(total remain of goal) <span class=\"right\">%remain%</span></section>
					<section>Template tag: (single post word count)<span class=\"right\"><code>obwcountplus_total();</code></span></section>
					<section>Custom output:<span class=\"right\"><code>countsplusplus();</code></span></section>
					<section>Total words + remaining:<span class=\"right\"><code>obwcountplus_count();</code></span></section>
					<section>Total words:<span class=\"right\"><code>obwcountplus_total();</code></span></section>
					<section>Remainig:(displays total published if goal reached)<span class=\"right\"><code>obwcountplus_remaining();</code></span></section>
					</div>

					<p class=\"creditlink\">Count++ is adapted from <a href=\"http://wordpress.org/plugins/post-word-count/\">Post Word Count</a> by <a href=\"http://profiles.wordpress.org/nickmomrik/\">Nick Momrik</a>.</p>
					
					
					";
            }





            if(isset( $_POST[ 'obwcountsave' ] ) ) {
				update_obwcountplus_options(); 
				echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
			}





            obwcountplus_page_content();

		}
        
        my_optional_modules_count_module();
        
    }

?>