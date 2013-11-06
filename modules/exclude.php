<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: EXCLUDE

    if (is_admin() ) { 

        function my_optional_modules_exclude_module() {

            add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

            function update_momse_options() {
                if ( isset( $_POST[ 'momsesave' ] ) ) {
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_visitor'       ] != '' . get_option( 'simple_announcement_with_exclusion_cat_visitor'       ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_visitor',$_REQUEST[ 'simple_announcement_with_exclusion_cat_visitor' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_tag_visitor'       ] != '' . get_option( 'simple_announcement_with_exclusion_tag_visitor'       ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_tag_visitor',$_REQUEST[ 'simple_announcement_with_exclusion_tag_visitor' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9'       ] != '' . get_option( 'simple_announcement_with_exclusion_9'       ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9',$_REQUEST[ 'simple_announcement_with_exclusion_9' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_2'     ] != '' . get_option( 'simple_announcement_with_exclusion_9_2'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_2',$_REQUEST[ 'simple_announcement_with_exclusion_9_2' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_3'     ] != '' . get_option( 'simple_announcement_with_exclusion_9_3'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_3',$_REQUEST[ 'simple_announcement_with_exclusion_9_3' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_4'     ] != '' . get_option( 'simple_announcement_with_exclusion_9_4'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_4',$_REQUEST[ 'simple_announcement_with_exclusion_9_4' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_5'     ] != '' . get_option( 'simple_announcement_with_exclusion_9_5'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_5',$_REQUEST[ 'simple_announcement_with_exclusion_9_5' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_7'     ] != '' . get_option( 'simple_announcement_with_exclusion_9_7'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_7',$_REQUEST[ 'simple_announcement_with_exclusion_9_7' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_8'     ] != '' . get_option( 'simple_announcement_with_exclusion_9_8'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_8',$_REQUEST[ 'simple_announcement_with_exclusion_9_8' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_9'     ] != '' . get_option( 'simple_announcement_with_exclusion_9_9'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_9',$_REQUEST[ 'simple_announcement_with_exclusion_9_9' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_10'    ] != '' . get_option( 'simple_announcement_with_exclusion_9_10'    ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_10',$_REQUEST[ 'simple_announcement_with_exclusion_9_10' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_11'    ] != '' . get_option( 'simple_announcement_with_exclusion_9_11'    ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_11',$_REQUEST[ 'simple_announcement_with_exclusion_9_11' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_12'    ] != '' . get_option( 'simple_announcement_with_exclusion_9_12'    ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_12',$_REQUEST[ 'simple_announcement_with_exclusion_9_12' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_13'    ] != '' . get_option( 'simple_announcement_with_exclusion_9_13'    ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_13',$_REQUEST[ 'simple_announcement_with_exclusion_9_13' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_14'    ] != '' . get_option( 'simple_announcement_with_exclusion_9_14'    ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_9_14',$_REQUEST[ 'simple_announcement_with_exclusion_9_14' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_sun'     ] != '' . get_option( 'simple_announcement_with_exclusion_sun'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_sun',$_REQUEST[ 'simple_announcement_with_exclusion_sun' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_mon'     ] != '' . get_option( 'simple_announcement_with_exclusion_mon'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_mon',$_REQUEST[ 'simple_announcement_with_exclusion_mon' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_tue'     ] != '' . get_option( 'simple_announcement_with_exclusion_tue'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_tue',$_REQUEST[ 'simple_announcement_with_exclusion_tue' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_wed'     ] != '' . get_option( 'simple_announcement_with_exclusion_wed'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_wed',$_REQUEST[ 'simple_announcement_with_exclusion_wed' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_thu'     ] != '' . get_option( 'simple_announcement_with_exclusion_thu'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_thu',$_REQUEST[ 'simple_announcement_with_exclusion_thu' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_fri'     ] != '' . get_option( 'simple_announcement_with_exclusion_fri'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_fri',$_REQUEST[ 'simple_announcement_with_exclusion_fri' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_sat'     ] != '' . get_option( 'simple_announcement_with_exclusion_sat'     ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_sat',$_REQUEST[ 'simple_announcement_with_exclusion_sat' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_sun' ] != '' . get_option( 'simple_announcement_with_exclusion_cat_sun' ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_sun',$_REQUEST[ 'simple_announcement_with_exclusion_cat_sun' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_mon' ] != '' . get_option( 'simple_announcement_with_exclusion_cat_mon' ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_mon',$_REQUEST[ 'simple_announcement_with_exclusion_cat_mon' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_tue' ] != '' . get_option( 'simple_announcement_with_exclusion_cat_tue' ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_tue',$_REQUEST[ 'simple_announcement_with_exclusion_cat_tue' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_wed' ] != '' . get_option( 'simple_announcement_with_exclusion_cat_wed' ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_wed',$_REQUEST[ 'simple_announcement_with_exclusion_cat_wed' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_thu' ] != '' . get_option( 'simple_announcement_with_exclusion_cat_thu' ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_thu',$_REQUEST[ 'simple_announcement_with_exclusion_cat_thu' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_fri' ] != '' . get_option( 'simple_announcement_with_exclusion_cat_fri' ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_fri',$_REQUEST[ 'simple_announcement_with_exclusion_cat_fri' ] ); 
                    }
                    if ( $_REQUEST[ 'simple_announcement_with_exclusion_cat_sat' ] != '' . get_option( 'simple_announcement_with_exclusion_cat_sat' ) . '' ) {
                        update_option( 'simple_announcement_with_exclusion_cat_sat',$_REQUEST[ 'simple_announcement_with_exclusion_cat_sat' ] ); 
                    }
                    echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
                }
            }

            function momse_form() {
                echo "
				<div class=\"settingsInfo\">
                    <h2>Categories</h2>
					<div class=\"list\">";
                    $showmecats =  get_categories( 'taxonomy=category' ); 
					foreach ( $showmecats as $catsshown ) {
						echo "
                        <span>",$catsshown->cat_name,"/<strong>",$catsshown->cat_ID,"</strong></span>";
                    }
                echo "
					</div>
				</div>
				<div class=\"settingsInput\">
					<section>Comma separate multiple IDs (1,2,3)</section>
					<section><label for=\"simple_announcement_with_exclusion_cat_visitor\">Hide from logged out</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_visitor\" name=\"simple_announcement_with_exclusion_cat_visitor\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_visitor' ) . "\"></section>
					<section><label for=\"simple_announcement_with_exclusion_9_12\">Hide from RSS</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_9_12\" name=\"simple_announcement_with_exclusion_9_12\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_12' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_9\">Hide from front page</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_9\" name=\"simple_announcement_with_exclusion_9\" value=\"" . get_option( 'simple_announcement_with_exclusion_9' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_9_2\">Hide from tag archives</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_9_2\" name=\"simple_announcement_with_exclusion_9_2\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_2' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_9_3\">Hide from search results</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_9_3\" name=\"simple_announcement_with_exclusion_9_3\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_3' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_cat_sun\">Hide on Sunday</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_sun\" name=\"simple_announcement_with_exclusion_cat_sun\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_sun' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_cat_mon\">Hide on Monday</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_mon\" name=\"simple_announcement_with_exclusion_cat_mon\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_mon' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_cat_tue\">Hide on Tuesday</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_tue\" name=\"simple_announcement_with_exclusion_cat_tue\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_tue' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_cat_wed\">Hide on Wednesday</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_wed\" name=\"simple_announcement_with_exclusion_cat_wed\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_wed' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_cat_thu\">Hide on Thursday</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_thu\" name=\"simple_announcement_with_exclusion_cat_thu\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_thu' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_cat_fri\">Hide on Friday</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_fri\" name=\"simple_announcement_with_exclusion_cat_fri\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_fri' ) . "\"></section>
                    <section><label for=\"simple_announcement_with_exclusion_cat_sat\">Hide on Saturday</label>
                    <input type=\"text\" id=\"simple_announcement_with_exclusion_cat_sat\" name=\"simple_announcement_with_exclusion_cat_sat\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_sat' ) . "\"></section>
				</div>
				<div class=\"clear top\"></div>
				<div class=\"settingsInfo\">
				<h2>Tags</h2>
				<div class=\"list\">";
                    $showmetags =  get_categories( 'taxonomy=post_tag' ); 
                        foreach ( $showmetags as $tagsshown ) {
                        echo "<span>",$tagsshown->cat_name,"/<strong>",$tagsshown->cat_ID,"</strong></span>";
                    }
				echo "
                </div>
				</div>
                <div class=\"settingsInput\">
				<section>Comma separate multiple IDs (1,2,3)</section>
				<section><label for=\"simple_announcement_with_exclusion_tag_visitor\">Hide from logged out</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_tag_visitor\" name=\"simple_announcement_with_exclusion_tag_visitor\" value=\"" . get_option( 'simple_announcement_with_exclusion_tag_visitor' ) . "\"></section>				
				<section><label for=\"simple_announcement_with_exclusion_9_13\">Hide from RSS</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_9_13\" name=\"simple_announcement_with_exclusion_9_13\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_13' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_9_4\">Hide from front page</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_9_4\" name=\"simple_announcement_with_exclusion_9_4\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_4' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_9_5\">Hide from category archives</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_9_5\" name=\"simple_announcement_with_exclusion_9_5\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_5' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_9_7\">Hide from search results</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_9_7\" name=\"simple_announcement_with_exclusion_9_7\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_7' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_sun\">Hide on Sunday</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_sun\" name=\"simple_announcement_with_exclusion_sun\" value=\"" . get_option( 'simple_announcement_with_exclusion_sun' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_mon\">Hide on Monday</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_mon\" name=\"simple_announcement_with_exclusion_mon\" value=\"" . get_option( 'simple_announcement_with_exclusion_mon' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_tue\">Hide on Tuesday</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_tue\" name=\"simple_announcement_with_exclusion_tue\" value=\"" . get_option( 'simple_announcement_with_exclusion_tue' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_wed\">Hide on Wednesday</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_wed\" name=\"simple_announcement_with_exclusion_wed\" value=\"" . get_option( 'simple_announcement_with_exclusion_wed' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_thu\">Hide on Thursday</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_thu\" name=\"simple_announcement_with_exclusion_thu\" value=\"" . get_option( 'simple_announcement_with_exclusion_thu' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_fri\">Hide on Friday</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_fri\" name=\"simple_announcement_with_exclusion_fri\" value=\"" . get_option( 'simple_announcement_with_exclusion_fri' ) . "\"></section>
                <section><label for=\"simple_announcement_with_exclusion_sat\">Hide on Saturday</label>
                <input type=\"text\" id=\"simple_announcement_with_exclusion_sat\" name=\"simple_announcement_with_exclusion_sat\" value=\"" . get_option( 'simple_announcement_with_exclusion_sat' ) . "\"></section>
				</div>
				<div class=\"clear top\"></div>
				<div class=\"settingsInfo\">
				<h2>Post Formats</h2>
				</div>
				<div class=\"settingsInput\">
				<section>
                    <label for=\"simple_announcement_with_exclusion_9_14\">Hide from RSS</label>
                    <select name=\"simple_announcement_with_exclusion_9_14\" id=\"simple_announcement_with_exclusion_9_14\">
                        <option value=\"\">none</option>
                        <option value=\"post-format-aside\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-aside' ) { echo " selected=\"selected\""; } echo ">Aside</option>
                        <option value=\"post-format-gallery\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-gallery' ) { echo " selected=\"selected\""; } echo ">Gallery</option>
                        <option value=\"post-format-link\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-link' ) { echo " selected=\"selected\""; } echo ">Link</option>
                        <option value=\"post-format-image\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-image' ) { echo " selected=\"selected\""; } echo ">Image</option>
                        <option value=\"post-format-quote\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-quote' ) { echo " selected=\"selected\""; } echo ">Quote</option>
                        <option value=\"post-format-status\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-status' ) { echo " selected=\"selected\""; } echo ">Status</option>
                        <option value=\"post-format-video\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-video' ) { echo " selected=\"selected\""; } echo ">Video</option>
                        <option value=\"post-format-audio\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-audio' ) { echo " selected=\"selected\""; } echo ">Audio</option>
                        <option value=\"post-format-chat\""; if ( get_option( 'simple_announcement_with_exclusion_9_14' ) == 'post-format-chat' ) { echo " selected=\"selected\""; } echo ">Chat</option>
                    </select>
				</section>
				<section>
                    <label for=\"simple_announcement_with_exclusion_9_8\">Hide from front page</label>
                    <select name=\"simple_announcement_with_exclusion_9_8\" id=\"simple_announcement_with_exclusion_9_8\">
                        <option value=\"\">none</option>
                        <option value=\"post-format-aside\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-aside' ) { echo " selected=\"selected\""; } echo ">Aside</option>
                        <option value=\"post-format-gallery\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-gallery' ) { echo " selected=\"selected\""; } echo ">Gallery</option>
                        <option value=\"post-format-link\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-link' ) { echo " selected=\"selected\""; } echo ">Link</option>
                        <option value=\"post-format-image\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-image' ) { echo " selected=\"selected\""; } echo ">Image</option>
                        <option value=\"post-format-quote\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-quote' ) { echo " selected=\"selected\""; } echo ">Quote</option>
                        <option value=\"post-format-status\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-status' ) { echo " selected=\"selected\""; } echo ">Status</option>
                        <option value=\"post-format-video\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-video' ) { echo " selected=\"selected\""; } echo ">Video</option>
                        <option value=\"post-format-audio\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-audio' ) { echo " selected=\"selected\""; } echo ">Audio</option>
                        <option value=\"post-format-chat\""; if ( get_option( 'simple_announcement_with_exclusion_9_8' ) == 'post-format-chat' ) { echo " selected=\"selected\""; } echo ">Chat</option>
                    </select>
				</section>
				<section>
                    <label for=\"simple_announcement_with_exclusion_9_9\">Hide from archives</label>
                    <select name=\"simple_announcement_with_exclusion_9_9\" id=\"simple_announcement_with_exclusion_9_9\">
                        <option value=\"\">none</option>
                        <option value=\"post-format-aside\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-aside' ) { echo " selected=\"selected\""; } echo ">Aside</option>
                        <option value=\"post-format-gallery\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-gallery' ) { echo " selected=\"selected\""; } echo ">Gallery</option>
                        <option value=\"post-format-link\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-link' ) { echo " selected=\"selected\""; } echo ">Link</option>
                        <option value=\"post-format-image\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-image' ) { echo " selected=\"selected\""; } echo ">Image</option>
                        <option value=\"post-format-quote\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-quote' ) { echo " selected=\"selected\""; } echo ">Quote</option>
                        <option value=\"post-format-status\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-status' ) { echo " selected=\"selected\""; } echo ">Status</option>
                        <option value=\"post-format-video\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-video' ) { echo " selected=\"selected\""; } echo ">Video</option>
                        <option value=\"post-format-audio\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-audio' ) { echo " selected=\"selected\""; } echo ">Audio</option>
                        <option value=\"post-format-chat\""; if (get_option( 'simple_announcement_with_exclusion_9_9' ) == 'post-format-chat' ) { echo " selected=\"selected\""; } echo ">Chat</option>
                    </select>
				</section>
				<section>
                    <label for=\"simple_announcement_with_exclusion_9_10\">Hide from tag archives</label>
                    <select name=\"simple_announcement_with_exclusion_9_10\" id=\"simple_announcement_with_exclusion_9_10\">
                        <option value=\"\">none</option>
                        <option value=\"post-format-aside\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-aside' ) { echo " selected=\"selected\""; } echo ">Aside</option>
                        <option value=\"post-format-gallery\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-gallery' ) { echo " selected=\"selected\""; } echo ">Gallery</option>
                        <option value=\"post-format-link\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-link' ) { echo " selected=\"selected\""; } echo ">Link</option>
                        <option value=\"post-format-image\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-image' ) { echo " selected=\"selected\""; } echo ">Image</option>
                        <option value=\"post-format-quote\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-quote' ) { echo " selected=\"selected\""; } echo ">Quote</option>
                        <option value=\"post-format-status\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-status' ) { echo " selected=\"selected\""; } echo ">Status</option>
                        <option value=\"post-format-video\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-video' ) { echo " selected=\"selected\""; } echo ">Video</option>
                        <option value=\"post-format-audio\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-audio' ) { echo " selected=\"selected\""; } echo ">Audio</option>
                        <option value=\"post-format-chat\"";if (get_option( 'simple_announcement_with_exclusion_9_10' ) == 'post-format-chat' ) { echo " selected=\"selected\""; } echo ">Chat</option>
                    </select>
				</section>
				<section>
                    <label for=\"simple_announcement_with_exclusion_9_11\">Hide from search results</label>
                    <select name=\"simple_announcement_with_exclusion_9_11\" id=\"simple_announcement_with_exclusion_9_11\">
						<option value=\"\">none</option>
						<option value=\"post-format-aside\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-aside' ) { echo " selected=\"selected\""; } echo ">Aside</option>
						<option value=\"post-format-gallery\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-gallery' ) { echo " selected=\"selected\""; } echo ">Gallery</option>
						<option value=\"post-format-link\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-link' ) { echo " selected=\"selected\""; } echo ">Link</option>
						<option value=\"post-format-image\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-image' ) { echo " selected=\"selected\""; } echo ">Image</option>
						<option value=\"post-format-quote\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-quote' ) { echo " selected=\"selected\""; } echo ">Quote</option>
						<option value=\"post-format-status\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-status' ) { echo " selected=\"selected\""; } echo ">Status</option>
						<option value=\"post-format-video\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-video' ) { echo " selected=\"selected\""; } echo ">Video</option>
						<option value=\"post-format-audio\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-audio' ) { echo " selected=\"selected\""; } echo ">Audio</option>
						<option value=\"post-format-chat\"";if (get_option( 'simple_announcement_with_exclusion_9_11' ) == 'post-format-chat' ) { echo " selected=\"selected\""; } echo ">Chat</option>
					</select>
				</section>
				</div>";
            }

            function momse_page_content() {
                echo "
                    <form method=\"post\">
                        <div class=\"settings\">";
                        momse_form();
                        echo "
                        <input id=\"momsesave\" type=\"submit\" value=\"Save Changes\" name=\"momsesave\">
						</div>
                    </form>";
            }
			
            if( isset( $_POST[ 'momsesave' ] ) ) { update_momse_options(); }
            momse_page_content();
			
        }
		
        my_optional_modules_exclude_module();
    }

?>