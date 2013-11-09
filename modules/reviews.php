<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}
	//	MY OPTIONAL MODULES
	//		MODULE: REVIEWS
	if (is_admin() ) {
		function my_optional_modules_reviews_module() {
			function mom_closetags( $html ) {
				// http://stackoverflow.com/questions/3059398/how-to-close-unclosed-html-tags
				preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
				$openedtags = $result[1];
				preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
				$closedtags = $result[1];
				$len_opened = count ( $openedtags );
				if( count ( $closedtags ) == $len_opened )
				{
				return $html;
				}
				$openedtags = array_reverse ( $openedtags );
				for( $i = 0; $i < $len_opened; $i++ )
				{
					if ( !in_array ( $openedtags[$i], $closedtags ) )
					{
					$html .= "</" . $openedtags[$i] . ">";
					}
					else
					{
					unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
					}
				}
				return $html;
			}
			function update_mom_reviews() {
				global $table_prefix, $table_suffix, $wpdb;
				$reviews_table_name = $table_prefix . $table_suffix . 'momreviews';			
					$reviews_type = str_replace('"','\'',($_REQUEST[ 'reviews_type' ]));
					$reviews_link = str_replace('"','\'',($_REQUEST[ 'reviews_link' ]));
					$reviews_title = str_replace('"','\'',($_REQUEST[ 'reviews_title' ]));
					$reviews_reviewed = mom_closetags( $_REQUEST[ 'reviews_review' ] ) ;
					$reviews_review = wpautop( $reviews_reviewed );
					$reviews_rating = str_replace('"','\'',($_REQUEST[ 'reviews_rating' ]));
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
					
					<form method=\"post\" class=\"addForm\">
								<section>title<input type=\"text\" name=\"reviews_title\" placeholder=\"Enter title here\"></section>
								<section>type<input type=\"text\" name=\"reviews_type\" placeholder=\"Review type\"></section>
								<section>url<input type=\"text\" name=\"reviews_link\" placeholder=\"Relevant URL\" ></section>
								<section class=\"editor\">
									";
										wp_editor($content, $name = 'reviews_review', $id = 'reviews_review', $prev_id = 'title', $media_buttons = true, $tab_index = 2);
									echo "
								</section>
								<section><label>rating</label><input type=\"text\" name=\"reviews_rating\" placeholder=\"Your rating\"></section>
								<section><input id=\"reviewsubmit\" type=\"submit\" value=\"Add review\" name=\"reviewsubmit\"/></section>
					</form>
					</div>
						
					<form method=\"post\" class=\"csssubmit\">
						<section><textarea name=\"css\">" . get_option('momreviews_css') . "</textarea></section>
						<section><input id=\"csssubmit\" type=\"submit\" value=\"Save CSS\" name=\"csssubmit\"></input></section>
					</form>
					</div>
				";
			}
			
			function reviews_page_content() {
				echo "	
					<span class=\"moduletitle\">__reviews<em>[momreviews]</em></span>
					<div class=\"clear\"></div>
					<div class=\"settings\">
					
						<div class=\"settingsInfo taller\">
						<form method=\"post\" class=\"reviews_item_form\">
							<input type=\"text\" name=\"filterResults_type\" placeholder=\"Filter by type\""; if ( get_option("momreviews_search") != "") echo "value=\"" . get_option("momreviews_search") . "\""; echo ">
							<input type=\"submit\" name=\"filterResults\" value=\"Accept\">
						</form>
						";
						
						
					global $wpdb;
						$mom_reviews_table_name = $wpdb->prefix . "momreviews";
						$filtered_search = get_option('momreviews_search');
						
						if ( get_option("momreviews_search") != "" ) {
							$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE = '$filtered_search' ORDER BY ID DESC");
						} else {
							$reviews = $wpdb->get_results ("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
						}
						echo '<div class="momresults">';
						foreach ($reviews as $reviews_results) {
							$this_ID = $reviews_results->ID;
								echo "<div class=\"momdata\">";
								
								echo "
								<div class=\"reviewitem\">
										<section class=\"id\">id:".$reviews_results->ID."</section>
										<span class=\"review\">".$reviews_results->TITLE."</span>
										
									";
					if(!isset($_POST['edit_'.$this_ID.''])){ 
					if(!isset($_POST['delete_'.$this_ID.''])){ echo "<form method=\"post\"><input class=\"deleteSubmit\" type=\"submit\" name=\"delete_".$this_ID."\" value=\"Delete\"></form>"; }
					else{echo "<form class=\"confirm\" method=\"post\"><input type=\"submit\" name=\"cancel\" id\"cancel\" value=\"Nevermind, I'd like to keep it.\"/><input class=\"deleteSubmit\" type=\"submit\" name=\"delete_confirm_".$this_ID."\" value=\"Confirm your deletion of item ".$reviews_results->ID."\"/></form>";}
					echo "<form method=\"post\"><input class=\"editSubmit\" type=\"submit\" name=\"edit_".$this_ID."\" value=\"Edit\"></form>";
					}	echo "								
								<section class=\"type\">type: ".$reviews_results->TYPE."</section>
								</div>";
							if(isset($_POST['edit_'.$this_ID.''])){
								echo "
								<div class=\"editing\">
								<form method=\"post\" class=\"addForm\">
											<section>title<input type=\"text\" name=\"reviews_title_".$this_ID."\" placeholder=\"Enter title here\" value=\"".$reviews_results->TITLE."\"/></section>
											<section>type<input type=\"text\" name=\"reviews_type_".$this_ID."\" placeholder=\"Review type\" value=\"".$reviews_results->TYPE."\"/></section>
											<section>url<input type=\"text\" name=\"reviews_link_".$this_ID."\" placeholder=\"Relevant URL\" value=\"".$reviews_results->LINK."\"/></section>
											<section class=\"editor\">
												";
													wp_editor($content = $reviews_results->REVIEW, $name = 'edit_review_'.$this_ID.'', $id = 'edit_review_'.$this_ID.'', $prev_id = 'title', $media_buttons = true, $tab_index = 1);
												echo "</section>
											<section>rating<input type=\"text\" name=\"reviews_rating_".$this_ID."\" placeholder=\"Your rating\" value=\"".$reviews_results->RATING."\"/></section>
											<section><input id=\"submit_edit_".$this_ID."\" type=\"submit\" value=\"Save these edits\" name=\"submit_edit_".$this_ID."\"><input type=\"submit\" name=\"cancel\" id\"cancel\" value=\"Nevermind, don't edit anything.\"/></section>
								</form>
								</div>";
							}
					if(isset($_POST['submit_edit_'.$this_ID.''])){
						global $table_prefix, $table_suffix, $wpdb;
						$reviews_table_name = $table_prefix . $table_suffix . 'momreviews';			
							$edit_type = str_replace('"','\'',($_REQUEST[ 'reviews_type_'.$this_ID.'' ]));
							$edit_link = str_replace('"','\'',($_REQUEST[ 'reviews_link_'.$this_ID.'' ]));
							$edit_title = str_replace('"','\'',($_REQUEST[ 'reviews_title_'.$this_ID.'' ]));
							$edit_reviewed = mom_closetags( $_REQUEST[ 'edit_review_'.$this_ID.'' ] ) ;
							$edit_review = wpautop( $reviews_reviewed );
							$edit_rating = str_replace('"','\'',($_REQUEST[ 'reviews_rating_'.$this_ID.'' ]));
							$wpdb->query("UPDATE $reviews_table_name SET TYPE = '$edit_type', LINK = '$edit_link', TITLE = '$edit_title', REVIEW = '$edit_review', RATING = '$edit_rating' WHERE ID = $this_ID") ;
							echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
					}

					if(isset($_POST['delete_confirm_'.$this_ID.''])){
						$current = plugin_basename(__FILE__);
						$wpdb->query("DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID'");
						echo "<meta http-equiv=\"refresh\" content=\"0;url=\"$current\" />";
					}
					if(isset($_POST['cancel'])){
					
					}
						
					
					echo "</div>";
					}	
					echo '</div>';
	
							echo "</div>";
					print_mom_reviews_form();
					echo '</div>';
						
	
					
			}
			
			reviews_page_content();
		}
		
		my_optional_modules_reviews_module();
	
	}	
?>