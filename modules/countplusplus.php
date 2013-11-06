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
				<div class=\"settingsInput\">
				    <section>
                        <label for=\"obwcountplus_countdownfrom\">Goal (<em>0</em> for none)</label>
                        <input id=\"obwcountplus_countdownfrom\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_1_countdownfrom' ) . "\" name=\"obwcountplus_countdownfrom\">
                    </section>
				    <section>
                        <label for=\"obwcountplus_remaining\">Text for remaining</label>
                        <input id=\"obwcountplus_remaining\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_2_remaining' ) . "\" name=\"obwcountplus_remaining\">
                    </section>
				    <section>
                        <label for=\"obwcountplus_total\">Text for published</label>
                        <input id=\"obwcountplus_total\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_3_total' ) . "\" name=\"obwcountplus_total\">
                    </section>
                    <section>				
                        <label for=\"obwcountplus_custom\">Custom output</label>
                        <input id=\"obwcountplus_custom\" class=\"regular-text\" type=\"text\" value=\"". get_option( 'obwcountplus_4_custom' ) . "\" name=\"obwcountplus_custom\">
                    </section>    
				    <section>
                        <p>How to use custom output<br />
                        %total% will be replaced with the total words on the blog<br />
                        %remain% will be replaced with the remaining words of the total</p>
                    </section>
				    <section>
    				    <p>Examples:<br />
                        <code>There are %total% words with %remain% left to go!</code><br /> will output 
                        <em>There are 90 words with 10 left to go!</em> (if you have a goal of 100 words 
                        set and there are currently 90 words published.</p>
                        <p>If you've already reached your goal, %remain% will be a negative number.</p>
				    </section>
                </div>";
            }





            function obwcountplus_page_content() {
                    echo "
                    <form method=\"post\">
						<div class=\"settings\">
							<div class=\"settingsInfo\">
								<p>Count++ is adapted from <a href=\"http://wordpress.org/plugins/post-word-count/\">Post Word Count</a> by <a href=\"http://profiles.wordpress.org/nickmomrik/\">Nick Momrik</a>.</p>
								<strong>Usage</strong>
								<p><em>Custom output</em><br />
								<code>&lt;?php if(function_exists('countsplusplus')){ countsplusplus(); } ?&gt;</code></p>
								<p><em>Total words + remaining</em><br />
								<code>&lt;?php if(function_exists('obwcountplus_count')){ obwcountplus_count(); } ?&gt;</code></p>
								<p><em>Total words</em><br />
								<code>&lt;?php if(function_exists('obwcountplus_total')){ obwcountplus_total(); } ?&gt;</code></p>
								<p><em>Remainig (total if goal reached)</em><br />
								<code>&lt;?php if(function_exists('obwcountplus_remaining')){ obwcountplus_remaining(); } ?&gt;</code></p>
								<p><em>Total words in post (single)</em><br />
								<code>&lt;?php if(function_exists('obwcountplus_single')){ obwcountplus_single(); } ?&gt;</code></p>
							</div>
                        ";
                        obwcountplus_form();
                        echo "<input id=\"obwcountsave\" type=\"submit\" value=\"Save Changes\" name=\"obwcountsave\">
						</div>
                    </form>";
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