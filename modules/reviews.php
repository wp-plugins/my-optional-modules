<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: REVIEWS

    if (is_admin() ) {
            
        function my_optional_modules_reviews_module() {
        
            function update_mom_reviews() {
                global $table_prefix, $table_suffix, $wpdb;
                $reviews_table_name = $table_prefix . $table_suffix . 'momreviews';            
                    $reviews_type = $_REQUEST[ 'reviews_type' ];
                    $reviews_link = $_REQUEST[ 'reviews_link' ];
                    $reviews_title = $_REQUEST[ 'reviews_title' ];
                    $reviews_reviewed = $_REQUEST[ 'reviews_review' ];
                    $reviews_review = wpautop( $reviews_reviewed );
                    $reviews_rating = $_REQUEST[ 'reviews_rating' ]; 
                    $wpdb->query("INSERT INTO $reviews_table_name (ID,TYPE,LINK,TITLE,REVIEW,RATING) VALUES ('','$reviews_type','$reviews_link','$reviews_title','$reviews_review','$reviews_rating')") ;
                    echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
            }

            if (isset( $_POST[ 'filterResults' ] ) ) {
                $filter_type = $_REQUEST[ 'filterResults_type' ];        
                $filter_type_fetch = sanitize_text_field ( $filter_type );
                update_option( 'momreviews_search',$filter_type_fetch );
            }
                
            function update_mom_css() {
                $newCSS = stripslashes_deep( $_REQUEST[ 'css' ] );
                update_option( 'momreviews_css',$newCSS ); 
                echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
            }
            
            if ( $_REQUEST[ 'reviewsubmit']) { update_mom_reviews(); }
            if ( $_REQUEST[ 'csssubmit']) { update_mom_css(); }

            function print_mom_reviews_form() {
                echo "
					<div class=\"settingsInput\">
                    <form method=\"post\">
                                <section><label>Review title</label><input type=\"text\" name=\"reviews_title\" placeholder=\"Review title\"></section>
                                <section><label>Review type</label><input type=\"text\" name=\"reviews_type\" placeholder=\"Review type\"></section>
                                <section><label>Relevant URL</label><input type=\"text\" name=\"reviews_link\" placeholder=\"Relevant URL\" ></section>
                                
                                    ";
                                        the_editor($content, $name = 'reviews_review', $id = 'reviews_review', $prev_id = 'title', $media_buttons = true, $tab_index = 2);
                                    echo "
								
                                <section><label>Your rating</label><input type=\"text\" name=\"reviews_rating\" placeholder=\"Your rating\"></section>
                                <section><input id=\"reviewsubmit\" type=\"submit\" value=\"Add review\" name=\"reviewsubmit\"></input></section>
                    </form>
					<div class=\"clear new\">				
                        <div class=\"momreview\">
                            <article class=\"block\">
                                <input type=\"checkbox\" name=\"momreview\" id=\"test\" />
                                <label for=\"test\">Title<span>+</span><span>-</span></label>
                                <section class=\"reviewed\">
                                <em>Review type</em> &mdash;
                                <a href=\"http://onebillionwords.com/\">#</a>
                                <hr />
                                <p>This is your review.  It will be formatted with the appropriate HTML, and 
                                even images (if you have added any).</p>
                                <p>This is just a <em>display purposes only</em> block to show you how your css
                                will affect the display.</p>
                                <p><em>Helpful</em></p>
                            </section>
                        </article>
                    </div>
					<form method=\"post\">
						<section><textarea name=\"css\">" . get_option('momreviews_css') . "</textarea></section>
                        <section><input id=\"csssubmit\" type=\"submit\" value=\"Save CSS\" name=\"csssubmit\"></input></section>
                    </form>
				</div>";
            }
            
            function reviews_page_content() {
                echo "    
                <div class=\"wrap\">
					<div class=\"settings\">
						<div class=\"settingsInfo\">
								<h2>Usage</h2>
                                    <blockquote><ol>
                                        <li>Review title is the title of the review.</li>
                                        <li>Review type can be anything: book, movie, cd, ponytail, whatever.</li>
                                        <li>Relevant URL (if used) should link to something relevant to the review; if you're reviewing a film, link 
                                        to the IMDB page.  If you're reviewing a book, link to the author's website.  It's optional, however.</li>
                                        <li>Use the text field to write a review.  Use HTML if you want to.</li>
                                        <li>Rating can be anything: It sucked!, 5 out of 10, jolly rancher!, whatever.</li>
                                        <li>Use the table below to delete specific reviews.</li>
                                        <li>Shortcodes may not execute properly in the review table below, although they may display normally on your live site. (Check and make sure before you delete a review thinking you've made a mistake.)</li>
                                </ol>
                                <ol>
                                    <li><code>[momreviews]</code> = all reviews</li>
                                    <li><code>[momreviews type=\"'type'\"]</code> / <code>[momreviews type=\"'1'\"]</code> = reviews from review type <em>type</em></li>
                                    <li><code>[momreviews type=\"'type1','type2','type3'\"]</code> /  <code>[momreviews type=\"'1','2','3'\"]</code> = reviews from reviews types <em>type1, type2, and type3</em>. <strong>or</strong> with the IDs 1, 2, and 3.</code>.</li>
                                </ol>
                                <ol>
                                    <li>The shortcode accepts a variety of options.:</li>
                                    <li> &mdash; type <strong>or</strong> id (default is blank) : parameters explained above (see code with list of types or single type usage above.) <strong>or</strong> the id(s) of the particular review you want to display (as found in the table below).  (Either or, but not both type and id can be used.)</li>
                                    <li> &mdash; orderby (default is ID) : available parameters: ID,TYPE,LINK,TITLE,REVIEW,RATING.  Usage: <code>[momreviews orderby=\"LINK\"]</code></li>
                                    <li> &mdash;&mdash; ID is the ID of the review, and will increment by 1 sequentially with each new review added to the database. </li>
                                    <li> &mdash;&mdash; TYPE is the kind of review you are adding (if any).</li>
                                    <li> &mdash;&mdash; LINK is the relevant URL you have attached to your review (if any).</li>
                                    <li> &mdash;&mdash; TITLE is the title of the review (if any).</li>
                                    <li> &mdash;&mdash; REVIEW is the review itself for the item in question (if any).</li>
                                    <li> &mdash;&mdash; RATING is the rating you gave it (if any).</li>
                                    <li> &mdash; order (default is DESC) : available parameters: DESC or ASC. Usage: <code>[momreviews order=\"DESC\"]</code></li>
                                    <li> &mdash; meta (default is 1) : 1 is to show meta values (review type, rating, and relevant link).  0 is to hide this section altogether.  Usage: <code>[momreviews meta=\"1\"]</code></li>
                                    <li> &mdash; expand (default is +) : what to show (on the right) when a review is collapsed.</li>
                                    <li> &mdash; retract (default is -) : what to show (on the right) when a review is expanded.</li>
                                    <li> &mdash;&mdash; if using Font Awesome, use <code>expand=\"&lt;i class='fa fa-arrow-down'>&lt;/i>\"</code> and <code>retract=\"&lt;i class='fa fa-arrow-up'>&lt;/i>\"</code> (examples) as your expand and retract display.</li>
                                    <li>Multiple parameter usage: <code>[momreviews type=\"'book'\" orderby=\"TITLE\" order=\"DESC\" meta=\"0\" expand=\"Show\" retract=\"Hide\"]</code>
                                </blockquote>
							</div>";
                    print_mom_reviews_form();
                    echo "
                    
						</div>
						
						<div class=\"clear new\"></div>
						<div class=\"settingsInfo full\">
                        <section><label>Filter these results</label>
                        <form method=\"post\" class=\"reviews_item_form\">
                            <input type=\"text\" name=\"filterResults_type\" placeholder=\"Filter by type (or blank for all results)\""; if ( get_option("momreviews_search") != "") echo "value=\"" . get_option("momreviews_search") . "\""; echo ">
                            <input type=\"submit\" name=\"filterResults\" value=\"Accept\">
                        </form>
						</section>
                    
                        <style>
                        textarea, input[type='text'] { width: 100%; display:block; cursor:pointer;}
                        textarea { height: 250px; }
                        " . get_option('momreviews_css') . "
                        </style>";
                        
                        global $wpdb;
                        $mom_reviews_table_name = $wpdb->prefix . "momreviews";
                        $filtered_search = get_option('momreviews_search');
                        
                        if ( get_option("momreviews_search") != "" ) {
                            $reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE = '$filtered_search' ORDER BY ID DESC");
                        } else {
                            $reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
                        }
                        
                        foreach ($reviews as $reviews_results) {
                            $this_ID = $reviews_results->ID;
                                echo "
                                
                                <div class=\"momreview\">
                                    <article class=\"block\">
                                        <input type=\"checkbox\" name=\"momreview\" id=\"" . $this_ID . "\" />
                                        <label for=\"" . $this_ID . "\">" .  $reviews_results->TITLE . " ( ID: " . $this_ID . " / TYPE: " . $reviews_results->TYPE . ") <span>+</span><span>-</span></label>
                                        <section class=\"reviewed\">
                                            <em>" . $reviews_results->TYPE . "</em> &mdash; ";
                                            if ($reviews_results->LINK != "") { echo "<a href=\"" . esc_url( $reviews_results->LINK ) . "\">#</a> &mdash;"; }
                                            echo "<em>" . $reviews_results->RATING . "</em> <hr />" . $reviews_results->REVIEW . "
                                        </section>
                                    </article>
                                </div>";
                    echo "
                    <form method=\"post\"><input class=\"deleteSubmit\" type=\"submit\" name=\"$this_ID\" value=\"Delete\"></form>";
                    if(isset($_POST[$this_ID])){
                        $current = plugin_basename(__FILE__);
                        $wpdb->query(" DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID' ");
                        echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
                    }
                    }
                    echo "</div></div>";
            }
            
            reviews_page_content();
        }
        
        my_optional_modules_reviews_module();
    
    }    
?>