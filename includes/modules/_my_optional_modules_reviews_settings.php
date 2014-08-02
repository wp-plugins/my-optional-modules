<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

if(current_user_can('manage_options')){
			function my_optional_modules_reviews_module(){
						
						function update_mom_reviews(){
							global $table_prefix,$wpdb;
							$reviews_table_name = $table_prefix.'momreviews';                        
							$reviews_type = esc_sql($_REQUEST['reviews_type']);
							$reviews_link = esc_url($_REQUEST['reviews_link']);
							$reviews_title = esc_sql($_REQUEST['reviews_title']);
							$reviews_review = $_REQUEST['reviews_review'];
							$reviews_review = wpautop($reviews_review);
							$reviews_rating = esc_sql($_REQUEST['reviews_rating']);
							$reviews_rating = stripslashes_deep($reviews_rating);
							$reviews_type = stripslashes_deep($reviews_type);
							$reviews_title = stripslashes_deep($reviews_title);
							$wpdb->query(
								"INSERT INTO $reviews_table_name (
									ID,
									TYPE,
									LINK,
									TITLE,
									REVIEW,
									RATING
								) VALUES (
									'',
									'$reviews_type',
									'$reviews_link',
									'$reviews_title',
									'$reviews_review',
									'$reviews_rating'
								)"
							);
							echo '<meta http-equiv="refresh" content="0;url="'.plugin_basename(__FILE__).'" />';
						}
						
						if(isset($_POST['filterResults'])){
							$filter_type = esc_sql($_REQUEST['filterResults_type']);
							$filter_type_fetch = sanitize_text_field($filter_type);
							update_option('momreviews_search',$filter_type_fetch);
						}
						
						if(isset($_POST['reviewsubmit']))update_mom_reviews();
						
						function print_mom_reviews_form(){
							global $content;?>
							<form method="post" class="clear">
								<section class="clear">
									<label class="left" for="reviews_title">title</label>
									<input class="right" type="text" name="reviews_title" placeholder="Enter title here"></section>
								<section class="clear">
									<label class="left" for="reviews_type">type</label>
									<input class="right" type="text" name="reviews_type" placeholder="Review type"></section>
								<section class="clear">
									<label class="left" for="reviews_link">url</label>
									<input class="right" type="text" name="reviews_link" placeholder="Relevant URL" ></section>
								<section class="clear">
									<?php wp_editor($content,$name = 'reviews_review',$id = 'reviews_review',$prev_id = 'title',$media_buttons = true, $tab_index = 2);?>
								</section>
								<br />
								<section class="clear">
									<label class="left" for="reviews_rating">rating</label>
									<input class="right" type="text" name="reviews_rating" placeholder="Your rating">
								</section>
								<br />
								<section class="clear">
									<input id="reviewsubmit" type="submit" value="Add review" name="reviewsubmit"/>
								</section>
							</form>
						<?php }
						
						function reviews_page_content(){ ?>
						<strong class="sectionTitle">Reviews Settings</strong>
						<form class="clear" method="post" class="reviews_item_form">
						<section class="clear">
							<label class="left" for="filterResults_type">Filter by type</label>
							<input class="right" type="text" name="filterResults_type" placeholder="Filter by type" <?php if(get_option('momreviews_search') != ""){ ?>value="<?php echo get_option('momreviews_search');?><?php }?>">
						</section>
						<section class="clear">
							<input type="submit" name="filterResults" value="Accept">
						</section>
						</form>
						<?php 
							global $wpdb;
							$mom_reviews_table_name = $wpdb->prefix . "momreviews";
							$filtered_search = get_option('momreviews_search');
							if(get_option('momreviews_search') != ""){
								$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE = '$filtered_search' ORDER BY ID DESC");
							}else{
								$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY ID DESC");
							} ?>

						<div class="momresults">
						<?php 
							
							$this_ID = 0;
							foreach($reviews as $reviews_results){
							$this_ID = $reviews_results->ID;?>
							
							<section class="clear">
								<br />
								<strong>Review ID</strong> <?php echo $reviews_results->ID;?> &mdash; Title: <?php echo $reviews_results->TITLE;?> &mdash;  Review type: <?php echo $reviews_results->TYPE; ?>
								<?php 
									if(!isset($_POST['edit_'.$this_ID.''])){
										if(!isset($_POST['delete_'.$this_ID.''])){ ?>
										<form action="" method="post">
											<input class="left" type="submit" name="delete_<?php echo $this_ID;?>" value="Delete">
										</form>
									<?php } else { ?>
										<form action="" method="post">
											<input class="left" type="submit" name="cancel" id="cancel" value="Cancel"/>
											<input class="left" type="submit" name="delete_confirm_<?php echo $this_ID;?>" value="Confirm"/>
										</form>
									<?php } ?>
									<form method="post">
										<input class="left" type="submit" name="edit_<?php echo $this_ID;?>" value="Edit">
									</form>										
								<?php } ?>
							</section>
							<?php if(isset($_POST['edit_'.$this_ID.''])){ ?>
								<form method="post" class="clear">
								<section class="clear">
									<label class="left" for="reviews_title">title</label>
									<input class="right" type="text" name="reviews_title_<?php echo $this_ID;?>" placeholder="Enter title here" value="<?php echo $reviews_results->TITLE;?>"/></section>
								<section class="clear">
									<label class="left" for="reviews_type">type</label>
									<input class="right" type="text" name="reviews_type_<?php echo $this_ID;?>" placeholder="Review type" value="<?php echo $reviews_results->TYPE;?>"/></section>
								<section class="clear">
									<label class="left" for="reviews_link">url</label>
									<input class="right" type="text" name="reviews_link_<?php echo $this_ID;?>" placeholder="Relevant URL" value="<?php echo $reviews_results->LINK;?>"/></section>
								<section class="clear">
								<?php 
									$thisContent = $reviews_results->REVIEW;
									wp_editor($content = $thisContent,$name = 'edit_review_'.$this_ID.'',$id = 'edit_review_'.$this_ID.'',$prev_id = 'title',$media_buttons = true,$tab_index = 1); ?>
								</section>
								<br />
								<section class="clear">
									<label for="reviews_rating">rating</label>
									<input class="right" type="text" name="reviews_rating_<?php echo $this_ID;?>" placeholder="Your rating" value="<?php echo $reviews_results->RATING;?>"/>
								</section>
								<section class="clear">
									<input id="submit_edit_<?php echo $this_ID;?>" type="submit" value="Save these edits" name="submit_edit_<?php echo $this_ID;?>">
									<input type="submit" name="cancel" id="cancel" value="Cancel these edits"/>
								</section>
								</form>
							<?php }
							if(isset($_POST['submit_edit_'.$this_ID.''])){
								global $table_prefix, $wpdb;
								$reviews_table_name = $table_prefix.'momreviews';                        
								$edit_type     = esc_sql($_REQUEST['reviews_type_'.$this_ID.'']);
								$edit_link     = esc_sql($_REQUEST['reviews_link_'.$this_ID.'']);
								$edit_title    = esc_sql($_REQUEST['reviews_title_'.$this_ID.'']);
								$edit_review   = $_REQUEST['edit_review_'.$this_ID.''];
								$edit_review   = wpautop($edit_review);
								$edit_rating   = esc_sql($_REQUEST['reviews_rating_'.$this_ID.'']);
								$edit_rating   = stripslashes_deep($edit_rating);
								$edit_type     = stripslashes_deep($edit_type);
								$edit_title    = stripslashes_deep($edit_title);
								$wpdb->query("UPDATE $reviews_table_name SET TYPE = '$edit_type', LINK = '$edit_link', TITLE = '$edit_title', REVIEW = '$edit_review', RATING = '$edit_rating' WHERE ID = $this_ID") ;
							}
							if(isset($_POST['delete_confirm_'.$this_ID.''])){
								$current = plugin_basename(__FILE__);
								$wpdb->query("DELETE FROM $mom_reviews_table_name WHERE ID = '$this_ID'");
							}
							if(isset($_POST['cancel'])){}
						} ?>
						</div>
						<p></p>
						<?php if(!isset($_POST['edit_'.$this_ID.''])){ 
							print_mom_reviews_form(); 
						} 
						} 
						reviews_page_content();?>
				<p></p>
				<form class="clear" method="post" action="" name="momReviews">
					<label for="mom_reviews_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate Reviews module</label>
					<input type="text" class="hidden" value="<?php if(get_option('mommaincontrol_reviews') == 1){ ?>0<?php } else { ?>1<?php }?>" name="reviews" />
					<input type="submit" id="mom_reviews_mode_submit" name="mom_reviews_mode_submit" value="Submit" class="hidden" />
				</form>
				<p>
					<i class="fa fa-info">&mdash;</i> [momreviews] shortcode accepts the following parameters to output a loop of your reviews: type, 
					orderbye, order, meta, expand, retract, id, and open.
				</p>
				<p>
					<i class="fa fa-code">&mdash;</i> <strong>type</strong> &mdash; Only grab reviews of this type (default: blank)<br />
					<i class="fa fa-code">&mdash;</i> <strong>orderby</strong> &mdash; order by type, link, title, or rating (default: ID)<br />
					<i class="fa fa-code">&mdash;</i> <strong>order</strong> &mdash;  ASC or DESC (ascending or descending) (default: ASC)<br />
					<i class="fa fa-code">&mdash;</i> <strong>meta</strong> &mdash;  1 or 0 (show meta (additional) information or not) (default: 1)<br />
					<i class="fa fa-code">&mdash;</i> <strong>expand</strong> &mdash;  Text for the expand link (default: + )<br />
					<i class="fa fa-code">&mdash;</i> <strong>retract</strong> &mdash;  Text for the retract link (default: - )<br />
					<i class="fa fa-code">&mdash;</i> <strong>id</strong> &mdash; If an ID is specified, the loop will only return that review<br />
					<i class="fa fa-code">&mdash;</i> <strong>open</strong> &mdash; 1 or 0 (open by default, closed by default) (default: 0)<br />
				</p>
				<p>
					<i class="fa fa-info">&mdash;</i> Reviews that have a numerical value for rating (.5 to 5) will instead display stars ( <i class="fa fa-star-half-o"></i> for .5, <i class="fa fa-star"></i> for whole).  <em>Example</em>: a rating of 3.5 would display as <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>.
				</p>
			<?php }
}