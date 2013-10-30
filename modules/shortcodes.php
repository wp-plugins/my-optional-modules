<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: SHORTCODES

    if (is_admin() ) {
    
        function my_optional_modules_shortcodes_module() {

            function mom_shortcodes_page_content() {
                echo "
                <div class=\"wrap\">
                    <h2>Shortcodes!</h2>

                    <table class=\"form-table\" border=\"1\">
                        <tbody>
                            
                            <tr valign=\"top\">
                                <p>[<a href=\"#google_maps\">map</a>] 
                                &mdash; [<a href=\"#reddit_button\">reddit</a>] 
                                &mdash; [<a href=\"#restrict\">restrict content to logged in users</a>] 
								&mdash; [<a href=\"#progress_bars\">progress bars</a>]</p>
                            </tr>
                            <tr valign=\"top\" id=\"google_maps\">
                                <td valign=\"top\">
                                    <strong>Google Maps</strong>
                                    <br />Embed a Google map.<br />Based on <a href=\"http://wordpress.org/plugins/very-simple-google-maps/\">Very Simple Google Maps</a> by <a href=\"http://profiles.wordpress.org/masterk/\">Michael Aronoff</a><hr />
                                    <u>Parameters</u><br />width<br />height<br />frameborder<br />align<br />address<br />info_window<br />zoom<br />    companycode<hr />
                                    <u>Defaults</u><br />Width: 100% <br />Height: 350px <br />Frameborder: 0 <br />Align: center<hr />
                                    div class .mom_map
                                </td>
                                <td valign=\"top\">
                                    <table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
                                    <tbody>
                                    <tr><td><code>[mom_map address=\"38.573333,-109.549167\"]</code></td><td><em>GPS</em></td></tr>
                                    <tr><td><iframe align=\"center\" width=\"100%\" height=\"350px\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&q=38.573333%2C-109.549167&amp;cid=&output=embed&z=14&iwloc=A&visual_refresh=true\"></iframe></td></tr>
                                    <tr><td><code>[mom_map address=\"1600 Pennsylvania Ave NW, Washington, D.C., DC\"]</code></td><td><em>Street Address</em></td></tr>
                                    <tr><td><iframe align=\"center\" width=\"100%\" height=\"350px\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?&q=1600+Pennsylvania+Ave+NW%2C+Washington%2C+D.C.%2C+DC+&amp;cid=&output=embed&z=14&iwloc=A&visual_refresh=true\"></iframe></td></tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr valign=\"top\" id=\"reddit_button\" style=\"background-color:#f4faff;\">
                                <td valign=\"top\">
                                    <strong>Reddit button</strong>
                                    <br />Create a customizable submit button for the current post.<hr />
                                    <u>Parameters</u><br />target<br />title<br />bgcolor<br />border<hr />
                                    <u>Defaults</u> <br />title: post title<br />bgcolor: transparent<br />border (color): transparent<hr />
                                    div class .mom_reddit
                                </td>
                                <td valign=\"top\">
                                    <table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <code>[mom_reddit]</code></td><td><em>Default</em>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <script type=\"text/javascript\">
                                                    reddit_url = \"http://reddit.com/\";
                                                    reddit_target = \"\";
                                                    reddit_title = \"Test\";
                                                    reddit_bgcolor = \"\";
                                                    reddit_bordercolor = \"\";
                                                    </script>
                                                    <script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <code>[mom_reddit target=\"news\"]</code></td><td><em>Targeting <a href=\"http://reddit.com/r/news/\">/r/news</a></em>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <script type=\"text/javascript\">
                                                    reddit_url = \"http://reddit.com/\";
                                                    reddit_target = \"news\";
                                                    reddit_title = \"Reddit\";
                                                    reddit_bgcolor = \"\";
                                                    reddit_bordercolor = \"\";
                                                    </script>
                                                    <script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <code>[mom_reddit bgcolor=\"000\" border=\"000\"]</code></td><td><em>Black background/border</em>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <script type=\"text/javascript\">
                                                        reddit_url = \"http://test.com/\";
                                                        reddit_target = \"\";
                                                        reddit_title = \"Reddit\";
                                                        reddit_bgcolor = \"000\";
                                                        reddit_bordercolor = \"000\";
                                                    </script>
                                                    <script type=\"text/javascript\" src=\"http://www.reddit.com/static/button/button3.js\"></script>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr valign=\"top\" id=\"restrict\">
                                <td valign=\"top\">
                                    <strong>Restrict content to logged in users</strong><br />Restrict content to users who are not logged in, including commenting or viewing comments.<hr />
                                    <u>Parameters</u><br />message<br />comments<hr />
                                    <u>Defaults</u> <br /> message: You must be logged in to view this content.<hr />
                                    div class .mom_restrict
                                </td>
                                <td valign=\"top\">
                                    <table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <code>[mom_restrict]some content[/mom_restrict]</code></td><td><em>Default</em>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Logged in users see:<br />some content
                                                    <p>Users who are not logged in see:<br />You must be logged in to view this content.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <code>[mom_restrict comments=\"1\" message=\"Log in to view this content!\"]some content[/mom_restrict]</code></td><td><em>Comments and form are hidden</em>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Logged in users see:<br />some content
                                                    <p>Users who are not logged in see:<br />Log in to view this content!<br />(<em>Comment form and comments are hidden.)</em>)</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <code>[mom_restrict comments=\"2\" message=\"Log in to view this content!\"]some content[/mom_restrict]</code></td><td><em>Comment form is hidden</em>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Logged in users see:<br />some content
                                                    <p>Users who are not logged in see:<br />Log in to view this content!<br />(<em>Comment form is hidden</em>)</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
							
                            <tr valign=\"top\" id=\"progress_bars\">
                                <td valign=\"top\" style=\"max-width:300px;\">
                                    <strong>Progress bars</strong>
                                    <br />Create bars that fill up, based on your parameters, to show progression towards a goal.<hr />
                                    <u>Parameters</u><br />align, fillcolor, maincolor, 
									height, level, margin, 
									width<hr />
                                    <u>Defaults</u><br />align: none<br />fillcolor: #ccc<br />maincolor: #000<br />height: 15<br />level:<br />margin: 0 auto<br />width: 95%<br /><hr />
                                    div class .mom_progress<hr />
									The <code>level</code> refers to the % of the main bar to be filled.  So a level of 51 would fill it 51%, 29 would fill it 29%, 75 would fill it 75%, and so on.
                                </td>
                                <td valign=\"top\">
                                    <table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
                                    <tbody>
                                    <tr><td><code>[mom_progress level=\"10\"]</code></td><td><em>Default, level 10</em></td></tr>
                                    <tr><td>
										<div id=\"1\" class=\"mom_progress\" style=\"clear: both; height:15px; display: block; width:95%%; margin: 0 auto; background-color:#000\"><div style=\"display: block; height:15px; width:10%; background-color: #ccc;\"></div></div>
									</td></tr>
                                    <tr><td><code>[mom_progress level=\"70\" maincolor=\"#ff0000\" fillcolor=\"#009cff\"]</code></td><td><em>Level 70, custom colors</em></td></tr>
                                    <tr><td>
										<div id=\"2\" class=\"mom_progress\" style=\"clear: both; height:15px; display: block; width:95%; margin: 0 auto; background-color:#ff0000\"><div style=\"display: block; height:15px; width:70%; background-color: #009cff;\"></div></div>
									</td></tr>
                                    <tr><td><code>[mom_progress height=\"50\" level=\"70\" maincolor=\"#ff0000\" fillcolor=\"#009cff\"]</code></td><td><em>Level 70, custom colors, height of 50 (translates to 50px)</em></td></tr>
                                    <tr><td>
										<div id=\"3\" class=\"mom_progress\" style=\"clear: both; height:50px; display: block; width:95%; margin: 0 auto; background-color:#ff0000\"><div style=\"display: block; height:50px; width:70%; background-color: #009cff;\"></div></div>
									</td></tr>									
                                    </tbody>
                                    </table>
                                </td>
                            </tr>							
							
                        </tbody>
                    </table>
                </div>";
            }
            
            mom_shortcodes_page_content();
            
        }
        
        my_optional_modules_shortcodes_module();
        
    }

?>