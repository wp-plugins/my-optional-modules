<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

	//	MY OPTIONAL MODULES
	//		MODULE: EXCLUDE

	if (is_admin() ) { 

		function my_optional_modules_exclude_module() {

			add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

			function update_momse_options() {
				if ( isset( $_POST[ 'momsesave' ] ) ) {
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9' ] != '' . get_option( 'simple_announcement_with_exclusion_9' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9',$_REQUEST[ 'simple_announcement_with_exclusion_9' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_2' ] != ''. get_option( 'simple_announcement_with_exclusion_9_2' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_2',$_REQUEST[ 'simple_announcement_with_exclusion_9_2' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_3' ] != '' . get_option( 'simple_announcement_with_exclusion_9_3' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_3',$_REQUEST[ 'simple_announcement_with_exclusion_9_3' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_4' ] != '' . get_option( 'simple_announcement_with_exclusion_9_4' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_4',$_REQUEST[ 'simple_announcement_with_exclusion_9_4' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_5' ] != '' . get_option( 'simple_announcement_with_exclusion_9_5' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_5',$_REQUEST[ 'simple_announcement_with_exclusion_9_5' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_7' ] != '' . get_option( 'simple_announcement_with_exclusion_9_7' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_7',$_REQUEST[ 'simple_announcement_with_exclusion_9_7' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_8' ] != '' . get_option( 'simple_announcement_with_exclusion_9_8' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_8',$_REQUEST[ 'simple_announcement_with_exclusion_9_8' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_9' ] != '' . get_option( 'simple_announcement_with_exclusion_9_9' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_9',$_REQUEST[ 'simple_announcement_with_exclusion_9_9' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_10' ] != '' . get_option( 'simple_announcement_with_exclusion_9_10' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_10',$_REQUEST[ 'simple_announcement_with_exclusion_9_10' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_11' ] != '' . get_option( 'simple_announcement_with_exclusion_9_11' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_11',$_REQUEST[ 'simple_announcement_with_exclusion_9_11' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_12' ] != '' . get_option( 'simple_announcement_with_exclusion_9_12' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_12',$_REQUEST[ 'simple_announcement_with_exclusion_9_12' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_13' ] != '' . get_option( 'simple_announcement_with_exclusion_9_13' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_13',$_REQUEST[ 'simple_announcement_with_exclusion_9_13' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_9_14' ] != '' . get_option( 'simple_announcement_with_exclusion_9_14' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_9_14',$_REQUEST[ 'simple_announcement_with_exclusion_9_14' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_sun' ] != '' . get_option( 'simple_announcement_with_exclusion_sun' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_sun',$_REQUEST[ 'simple_announcement_with_exclusion_sun' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_mon' ] != '' . get_option( 'simple_announcement_with_exclusion_mon' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_mon',$_REQUEST[ 'simple_announcement_with_exclusion_mon' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_tue' ] != '' . get_option( 'simple_announcement_with_exclusion_tue' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_tue',$_REQUEST[ 'simple_announcement_with_exclusion_tue' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_wed' ] != '' . get_option( 'simple_announcement_with_exclusion_wed' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_wed',$_REQUEST[ 'simple_announcement_with_exclusion_wed' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_thu' ] != '' . get_option( 'simple_announcement_with_exclusion_thu' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_thu',$_REQUEST[ 'simple_announcement_with_exclusion_thu' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_fri' ] != '' . get_option( 'simple_announcement_with_exclusion_fri' ) . '' ) {
						update_option( 'simple_announcement_with_exclusion_fri',$_REQUEST[ 'simple_announcement_with_exclusion_fri' ] ); 
					}
					if ( $_REQUEST[ 'simple_announcement_with_exclusion_sat' ] != '' . get_option( 'simple_announcement_with_exclusion_sat' ) . '' ) {
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
				<tr valign=\"top\">
					<th scope=\"row\">
						<strong>Categories</strong><hr />
						Usage:<br />
						<p>Comma separated lists for multiple exclusions (or single ids).</p>
						<p>Example: 1,2,3</p>
					</th>
					<td>";
					
					$showmecats =  get_categories( 'taxonomy=category' ); 
					
						echo "
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
							<tr>
								<td>Category</td>
								<td>ID</td>
							</tr>";
									
							foreach ( $showmecats as $catsshown ) {
								echo "
								<tr>
									<td>
										<strong>",$catsshown->cat_name,"</strong></td><td><em>",$catsshown->cat_ID,"</em>
									</td>
								</tr>";
							}
							
						echo "
						</table>
					</td>
					<td valign=\"top\">
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
							<tbody>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_12\">Hide from RSS</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9_12\" name=\"simple_announcement_with_exclusion_9_12\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_12' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9\">Hide from front page</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9\" name=\"simple_announcement_with_exclusion_9\" value=\"" . get_option( 'simple_announcement_with_exclusion_9' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_2\">Hide from tag archives</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9_2\" name=\"simple_announcement_with_exclusion_9_2\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_2' ) . "\">
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_3\">Hide from search results</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9_3\" name=\"simple_announcement_with_exclusion_9_3\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_3' ) . "\">
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_cat_sun\">Hide on Sunday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_cat_sun\" name=\"simple_announcement_with_exclusion_cat_sun\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_sun' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_cat_mon\">Hide on Monday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_cat_mon\" name=\"simple_announcement_with_exclusion_cat_mon\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_mon' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_cat_tue\">Hide on Tuesday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_cat_tue\" name=\"simple_announcement_with_exclusion_cat_tue\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_tue' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_cat_wed\">Hide on Wednesday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_cat_wed\" name=\"simple_announcement_with_exclusion_cat_wed\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_wed' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_cat_thu\">Hide on Thursday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_cat_thu\" name=\"simple_announcement_with_exclusion_cat_thu\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_thu' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_cat_fri\">Hide on Friday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_cat_fri\" name=\"simple_announcement_with_exclusion_cat_fri\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_fri' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_cat_sat\">Hide on Saturday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_cat_sat\" name=\"simple_announcement_with_exclusion_cat_sat\" value=\"" . get_option( 'simple_announcement_with_exclusion_cat_sat' ) . "\">
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
						
				<tr valign=\"top\" id=\"reddit_button\" style=\"background-color:#f4faff;\">
					<th scope=\"row\"><strong>Tags</strong><hr />
						Usage:<br />
						<p>Comma separated lists for multiple exclusions (or single ids).</p>
						<p>Example: 1,2,3</p>
					</th>
					<td>";

					$showmetags =  get_categories( 'taxonomy=post_tag' ); 

					echo "
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
							<tbody>
								<tr valign=\"top\">
									<td>Tag</td>
									<td>ID</td>
								</tr>";
								
								foreach ( $showmetags as $tagsshown ) {
									echo "
									<tr valign=\"top\">
										<td>
											<strong>",$tagsshown->cat_name,"</strong></td><td><em>",$tagsshown->cat_ID,"</em>
										</td>
									</tr>";
								}
								
							echo "
							</tbody>
						</table>
					</td>
					<td valign=\"top\">
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
							<tbody>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_13\">Hide from RSS</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9_13\" name=\"simple_announcement_with_exclusion_9_13\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_13' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_4\">Hide from front page</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9_4\" name=\"simple_announcement_with_exclusion_9_4\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_4' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_5\">Hide from category archives</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9_5\" name=\"simple_announcement_with_exclusion_9_5\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_5' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_7\">Hide from search results</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_9_7\" name=\"simple_announcement_with_exclusion_9_7\" value=\"" . get_option( 'simple_announcement_with_exclusion_9_7' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_sun\">Hide on Sunday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_sun\" name=\"simple_announcement_with_exclusion_sun\" value=\"" . get_option( 'simple_announcement_with_exclusion_sun' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_mon\">Hide on Monday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_mon\" name=\"simple_announcement_with_exclusion_mon\" value=\"" . get_option( 'simple_announcement_with_exclusion_mon' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_tue\">Hide on Tuesday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_tue\" name=\"simple_announcement_with_exclusion_tue\" value=\"" . get_option( 'simple_announcement_with_exclusion_tue' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_wed\">Hide on Wednesday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_wed\" name=\"simple_announcement_with_exclusion_wed\" value=\"" . get_option( 'simple_announcement_with_exclusion_wed' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_thu\">Hide on Thursday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_thu\" name=\"simple_announcement_with_exclusion_thu\" value=\"" . get_option( 'simple_announcement_with_exclusion_thu' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_fri\">Hide on Friday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_fri\" name=\"simple_announcement_with_exclusion_fri\" value=\"" . get_option( 'simple_announcement_with_exclusion_fri' ) . "\">
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_sat\">Hide on Saturday</label>
									</th>
									<td>
										<input type=\"text\" id=\"simple_announcement_with_exclusion_sat\" name=\"simple_announcement_with_exclusion_sat\" value=\"" . get_option( 'simple_announcement_with_exclusion_sat' ) . "\">
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>

				<tr valign=\"top\">
					<th scope=\"row\"><strong>Post formats</strong></th>
					<td valign=\"top\">
						<table class=\"form-table\" border=\"1\" style=\"margin:5px; background-color:#fff;\">
							<tbody>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_14\">Hide from RSS</label>
									</th>
									<td>
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
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_8\">Hide from front page</label>
									</th>
									<td>
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
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_9\">Hide from archives</label>
									</th>
									<td>
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
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_10\">Hide from tag archives</label>
									</th>
									<td>
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
									</td>
								</tr>
								<tr valign=\"top\">
									<th scope=\"row\">
										<label for=\"simple_announcement_with_exclusion_9_11\">Hide from search results</label>
									</th>
									<td>
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
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>";
			}

			function momse_page_content() {
				echo "
				<div class=\"wrap\">
					<h2>Exclude</h2>
					<form method=\"post\">
						<table class=\"form-table\" border=\"1\">
							<tbody>";
								momse_form();
							echo "
							</tbody>
						</table>
						<input id=\"momsesave\" type=\"submit\" value=\"Save Changes\" name=\"momsesave\">
					</form>
				</div>";
			}
			
			if( isset( $_POST[ 'momsesave' ] ) ) { update_momse_options(); }
			
			momse_page_content();
			
		}

		my_optional_modules_exclude_module();

	}

?>