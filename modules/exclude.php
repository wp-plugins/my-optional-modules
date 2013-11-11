<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}
	if(is_admin()){ 
		function my_optional_modules_exclude_module(){
			function update_momse_options(){
				if(isset($_POST['momsesave'])){
					update_option('MOM_Exclude_VisitorCategories',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_VisitorCategories']))))))));
					update_option('MOM_Exclude_VisitorTags',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_VisitorTags'])))))))));
					update_option('MOM_Exclude_Categories_RSS',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_RSS'])))))))));
					update_option('MOM_Exclude_Categories_Front',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_Front'])))))))));
					update_option('MOM_Exclude_Categories_TagArchives',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_TagArchives'])))))))));
					update_option('MOM_Exclude_Categories_SearchResults',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_SearchResults'])))))))));
					update_option('MOM_Exclude_Tags_RSS',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_RSS'])))))))));
					update_option('MOM_Exclude_Tags_Front',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_Front'])))))))));
					update_option('MOM_Exclude_Tags_CategoryArchives',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_CategoryArchives'])))))))));
					update_option('MOM_Exclude_Tags_SearchResults',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_SearchResults'])))))))));
					update_option('MOM_Exclude_PostFormats_Visitor',sanitize_text_field($_REQUEST['MOM_Exclude_PostFormats_Visitor']));
					update_option('MOM_Exclude_PostFormats_RSS',sanitize_text_field($_REQUEST['MOM_Exclude_PostFormats_RSS']));
					update_option('MOM_Exclude_PostFormats_Front',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_Front'])));
					update_option('MOM_Exclude_PostFormats_CategoryArchives',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_CategoryArchives'])));
					update_option('MOM_Exclude_PostFormats_TagArchives',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_TagArchives'])));
					update_option('MOM_Exclude_PostFormats_SearchResults',sanitize_text_field(($_REQUEST['MOM_Exclude_PostFormats_SearchResults'])));
					update_option('MOM_Exclude_TagsSun',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_TagsSun'])))))));
					update_option('MOM_Exclude_TagsMon',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_TagsMon'])))))));
					update_option('MOM_Exclude_TagsTue',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_TagsTue'])))))));
					update_option('MOM_Exclude_TagsWed',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_TagsWed'])))))));
					update_option('MOM_Exclude_TagsThu',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_TagsThu'])))))));
					update_option('MOM_Exclude_TagsFri',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_TagsFri'])))))));
					update_option('MOM_Exclude_TagsSat',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_TagsSat'])))))));
					update_option('MOM_Exclude_CategoriesSun',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_CategoriesSun']))))))));
					update_option('MOM_Exclude_CategoriesMon',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_CategoriesMon']))))))));
					update_option('MOM_Exclude_CategoriesTue',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_CategoriesTue']))))))));
					update_option('MOM_Exclude_CategoriesWed',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_CategoriesWed']))))))));
					update_option('MOM_Exclude_CategoriesThu',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_CategoriesThu']))))))));
					update_option('MOM_Exclude_CategoriesFri',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_CategoriesFri']))))))));
					update_option('MOM_Exclude_CategoriesSat',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_CategoriesSat']))))))));
					update_option('MOM_Exclude_level0Categories',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level0Categories']))))))));
					update_option('MOM_Exclude_level1Categories',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level1Categories']))))))));
					update_option('MOM_Exclude_level2Categories',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level2Categories']))))))));
					update_option('MOM_Exclude_level7Categories',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level7Categories']))))))));
					update_option('MOM_Exclude_level0Tags',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level0Tags']))))))));
					update_option('MOM_Exclude_level1Tags',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level1Tags']))))))));
					update_option('MOM_Exclude_level2Tags',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level2Tags']))))))));
					update_option('MOM_Exclude_level7Tags',sanitize_text_field(implode(',',array_unique(explode(',',preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_level7Tags']))))))));
					update_option('MOM_Exclude_URL',$_REQUEST['MOM_Exclude_URL']);
					update_option('MOM_Exclude_URL_User',$_REQUEST['MOM_Exclude_URL_User']);
					update_option('MOM_Exclude_NoFollow',$_REQUEST['MOM_Exclude_NoFollow']);
					update_option('MOM_Exclude_Hide_Dashboard',$_REQUEST['MOM_Exclude_Hide_Dashboard']);
				}
			}
			function momse_form(){
				echo '
					<div class="listing">
					<div class="list"><span>Category (<strong>ID</strong>)</span>';
					$showmecats = get_categories('taxonomy=category'); 
					foreach($showmecats as $catsshown){
						echo '
						<span>'.$catsshown->cat_name.'(<strong>'.$catsshown->cat_ID.'</strong>)</span>';
					}
				echo '
				</div>
				<div class="list"><span>Tag (<strong>ID</strong>)</span>';
					$showmetags =  get_categories('taxonomy=post_tag');
						foreach ($showmetags as $tagsshown){
						echo '<span>'.$tagsshown->cat_name.'(<strong>'.$tagsshown->cat_ID.'</strong>)</span>';
					}
				echo '
				</div>
				</div>				
				<input class="allitems" type="text" onclick="this.select();" value="';
				foreach($showmecats as $catsall){
					echo $catsall->cat_ID.',';
				}
				echo '"/>
				<input class="allitems" type="text" onclick="this.select();" value="';
				foreach ($showmetags as $tagsall){
					echo $tagsall->cat_ID.',';
				}				
				echo '"/>
				<div class="clear"></div>
				
				<div class="exclude">
					<section><span class="left">hide categories</span></section>
					<section class="break"><span class="right"></span></section>
					<section><hr/></section>	
					<section><label for="MOM_Exclude_Categories_RSS">RSS</label><input type="text" id="MOM_Exclude_Categories_RSS" name="MOM_Exclude_Categories_RSS" value="'.get_option('MOM_Exclude_Categories_RSS').'"></section>
					<section><label for="MOM_Exclude_Categories_Front">front page</label><input type="text" id="MOM_Exclude_Categories_Front" name="MOM_Exclude_Categories_Front" value="'.get_option('MOM_Exclude_Categories_Front').'"></section>
					<section><label for="MOM_Exclude_Categories_TagArchives">tag archives</label><input type="text" id="MOM_Exclude_Categories_TagArchives" name="MOM_Exclude_Categories_TagArchives" value="'.get_option('MOM_Exclude_Categories_TagArchives').'"></section>
					<section><label for="MOM_Exclude_Categories_SearchResults">search results</label><input type="text" id="MOM_Exclude_Categories_SearchResults" name="MOM_Exclude_Categories_SearchResults" value="'.get_option('MOM_Exclude_Categories_SearchResults').'"></section>
					<section class="break"><span class="right"></span></section>					
					<section><hr/></section>	
					<section><label for="MOM_Exclude_CategoriesSun">Sunday</label><input type="text" id="MOM_Exclude_CategoriesSun" name="MOM_Exclude_CategoriesSun" value="'.get_option('MOM_Exclude_CategoriesSun').'"></section>
					<section><label for="MOM_Exclude_CategoriesMon">Monday</label><input type="text" id="MOM_Exclude_CategoriesMon" name="MOM_Exclude_CategoriesMon" value="'.get_option('MOM_Exclude_CategoriesMon').'"></section>
					<section><label for="MOM_Exclude_CategoriesTue">Tuesday</label><input type="text" id="MOM_Exclude_CategoriesTue" name="MOM_Exclude_CategoriesTue" value="'.get_option('MOM_Exclude_CategoriesTue').'"></section>
					<section><label for="MOM_Exclude_CategoriesWed">Wednesday</label><input type="text" id="MOM_Exclude_CategoriesWed" name="MOM_Exclude_CategoriesWed" value="'.get_option('MOM_Exclude_CategoriesWed').'"></section>
					<section><label for="MOM_Exclude_CategoriesThu">Thursday</label><input type="text" id="MOM_Exclude_CategoriesThu" name="MOM_Exclude_CategoriesThu" value="'.get_option('MOM_Exclude_CategoriesThu').'"></section>
					<section><label for="MOM_Exclude_CategoriesFri">Friday</label><input type="text" id="MOM_Exclude_CategoriesFri" name="MOM_Exclude_CategoriesFri" value="'.get_option('MOM_Exclude_CategoriesFri').'"></section>
					<section><label for="MOM_Exclude_CategoriesSat">Saturday</label><input type="text" id="MOM_Exclude_CategoriesSat" name="MOM_Exclude_CategoriesSat" value="'.get_option('MOM_Exclude_CategoriesSat').'"></section>
					<section class="break"><span class="right"></span></section>
					<section><hr/></section>	
					<section><label for="MOM_Exclude_VisitorCategories">logged out</label><input type="text" id="MOM_Exclude_VisitorCategories" name="MOM_Exclude_VisitorCategories" value="'.get_option('MOM_Exclude_VisitorCategories').'"></section>
					<section><label for="MOM_Exclude_level0Categories">subscriber</label><input type="text" id="MOM_Exclude_level0Categories" name="MOM_Exclude_level0Categories" value="'.get_option('MOM_Exclude_level0Categories').'"></section>
					<section><label for="MOM_Exclude_level1Categories">contributor</label><input type="text" id="MOM_Exclude_level1Categories" name="MOM_Exclude_level1Categories" value="'.get_option('MOM_Exclude_level1Categories').'"></section>
					<section><label for="MOM_Exclude_level2Categories">author</label><input type="text" id="MOM_Exclude_level2Categories" name="MOM_Exclude_level2Categories" value="'.get_option('MOM_Exclude_level2Categories').'"></section>
					<section><label for="MOM_Exclude_level7Categories">editor</label><input type="text" id="MOM_Exclude_level7Categories" name="MOM_Exclude_level7Categories" value="'.get_option('MOM_Exclude_level7Categories').'"></section>
					
				</div>';
				echo '
				<div class="exclude">
					<section><span class="left">hide tags</span></section>
					<section class="break"><span class="right">from area</span></section>				
					<section><hr/></section>					
					<section><label for="MOM_Exclude_Tags_RSS">RSS</label><input type="text" id="MOM_Exclude_Tags_RSS" name="MOM_Exclude_Tags_RSS" value="'.get_option('MOM_Exclude_Tags_RSS').'"></section>
					<section><label for="MOM_Exclude_Tags_Front">front page</label><input type="text" id="MOM_Exclude_Tags_Front" name="MOM_Exclude_Tags_Front" value="'.get_option('MOM_Exclude_Tags_Front').'"></section>
					<section><label for="MOM_Exclude_Tags_CategoryArchives">categories</label><input type="text" id="MOM_Exclude_Tags_CategoryArchives" name="MOM_Exclude_Tags_CategoryArchives" value="'.get_option('MOM_Exclude_Tags_CategoryArchives').'"></section>
					<section><label for="MOM_Exclude_Tags_SearchResults">search results</label><input type="text" id="MOM_Exclude_Tags_SearchResults" name="MOM_Exclude_Tags_SearchResults" value="'.get_option('MOM_Exclude_Tags_SearchResults').'"></section>
					<section class="break"><span class="right">from day</span></section>					
					<section><hr/></section>	
					<section><label for="MOM_Exclude_TagsSun">Sunday</label><input type="text" id="MOM_Exclude_TagsSun" name="MOM_Exclude_TagsSun" value="'.get_option('MOM_Exclude_TagsSun').'"></section>
					<section><label for="MOM_Exclude_TagsMon">Monday</label><input type="text" id="MOM_Exclude_TagsMon" name="MOM_Exclude_TagsMon" value="'.get_option('MOM_Exclude_TagsMon').'"></section>
					<section><label for="MOM_Exclude_TagsTue">Tuesday</label><input type="text" id="MOM_Exclude_TagsTue" name="MOM_Exclude_TagsTue" value="'.get_option('MOM_Exclude_TagsTue').'"></section>
					<section><label for="MOM_Exclude_TagsWed">Wednesday</label><input type="text" id="MOM_Exclude_TagsWed" name="MOM_Exclude_TagsWed" value="'.get_option('MOM_Exclude_TagsWed').'"></section>
					<section><label for="MOM_Exclude_TagsThu">Thursday</label><input type="text" id="MOM_Exclude_TagsThu" name="MOM_Exclude_TagsThu" value="'.get_option('MOM_Exclude_TagsThu').'"></section>
					<section><label for="MOM_Exclude_TagsFri">Friday</label><input type="text" id="MOM_Exclude_TagsFri" name="MOM_Exclude_TagsFri" value="'.get_option('MOM_Exclude_TagsFri').'"></section>
					<section><label for="MOM_Exclude_TagsSat">Saturday</label><input type="text" id="MOM_Exclude_TagsSat" name="MOM_Exclude_TagsSat" value="'.get_option('MOM_Exclude_TagsSat').'"></section>
					<section class="break"><span class="right">from user level</span></section>
					<section><hr/></section>	
					<section><label for="MOM_Exclude_VisitorTags">logged out</label><input type="text" id="MOM_Exclude_VisitorTags" name="MOM_Exclude_VisitorTags" value="'.get_option('MOM_Exclude_VisitorTags').'"></section>				
					<section><label for="MOM_Exclude_level0Tags">subscriber</label><input type="text" id="MOM_Exclude_level0Tags" name="MOM_Exclude_level0Tags" value="'.get_option('MOM_Exclude_level0Tags').'"></section>
					<section><label for="MOM_Exclude_level1Tags">contributor</label><input type="text" id="MOM_Exclude_level1Tags" name="MOM_Exclude_level1Tags" value="'.get_option('MOM_Exclude_level1Tags').'"></section>
					<section><label for="MOM_Exclude_level2Tags">author</label><input type="text" id="MOM_Exclude_level2Tags" name="MOM_Exclude_level2Tags" value="'.get_option('MOM_Exclude_level2Tags').'"></section>
					<section><label for="MOM_Exclude_level7Tags">editor</label><input type="text" id="MOM_Exclude_level7Tags" name="MOM_Exclude_level7Tags" value="'.get_option('MOM_Exclude_level7Tags').'"></section>
				</div>
				<div class="exclude">';
				echo '
				<section><span class="left">hide post formats</span></section>
				<section class="break"><span class="right">from area</span></section>
				<section><hr/></section>
				<section>
					<label for="MOM_Exclude_PostFormats_RSS">RSS</label>
					<select name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
						<option value="">none</option>
						<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
						<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
						<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
						<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
						<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
						<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
						<option value="post-format-video"';if( get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
						<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
						<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_RSS') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_Front">front page</label>
					<select name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
						<option value="">none</option>
						<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
						<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
						<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-link' ){echo ' selected="selected"';}echo '>Link</option>
						<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
						<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
						<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
						<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
						<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
						<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_Front') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_CategoryArchives">archives</label>
					<select name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
						<option value="">none</option>
						<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
						<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
						<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-link' ){echo ' selected="selected"';}echo '>Link</option>
						<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
						<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
						<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
						<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
						<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
						<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_CategoryArchives') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_TagArchives">tags</label>
					<select name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
						<option value="">none</option>
						<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-aside'){ echo ' selected="selected"';} echo '>Aside</option>
						<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-gallery'){ echo ' selected="selected"';} echo '>Gallery</option>
						<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-link'){ echo ' selected="selected"';} echo '>Link</option>
						<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-image'){ echo ' selected="selected"';} echo '>Image</option>
						<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-quote'){ echo ' selected="selected"';} echo '>Quote</option>
						<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-status'){ echo ' selected="selected"';} echo '>Status</option>
						<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-video'){ echo ' selected="selected"';} echo '>Video</option>
						<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-audio'){ echo ' selected="selected"';} echo '>Audio</option>
						<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_TagArchives') === 'post-format-chat'){ echo ' selected="selected"';} echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_SearchResults">search results</label>
					<select name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
						<option value="">none</option>
						<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
						<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
						<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
						<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
						<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
						<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
						<option value="post-format-video"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
						<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
						<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_SearchResults') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
					</select>
				</section>
				<section>
					<label for="MOM_Exclude_PostFormats_Visitor">logged out</label>
					<select name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
						<option value="">none</option>
						<option value="post-format-aside"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-aside'){echo ' selected="selected"';}echo '>Aside</option>
						<option value="post-format-gallery"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-gallery'){echo ' selected="selected"';}echo '>Gallery</option>
						<option value="post-format-link"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-link'){echo ' selected="selected"';}echo '>Link</option>
						<option value="post-format-image"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-image'){echo ' selected="selected"';}echo '>Image</option>
						<option value="post-format-quote"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-quote'){echo ' selected="selected"';}echo '>Quote</option>
						<option value="post-format-status"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-status'){echo ' selected="selected"';}echo '>Status</option>
						<option value="post-format-video"';if( get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-video'){echo ' selected="selected"';}echo '>Video</option>
						<option value="post-format-audio"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-audio'){echo ' selected="selected"';}echo '>Audio</option>
						<option value="post-format-chat"';if(get_option('MOM_Exclude_PostFormats_Visitor') === 'post-format-chat'){echo ' selected="selected"';}echo '>Chat</option>
					</select>
				</section>';
				$showmepages = get_pages(); 
				echo '
				<section class="break"><span class="right">additional settings</span></section>
				<section><hr/></section>
				<section>
				<label for="MOM_Exclude_Hide_Dashboard">Hide Dash for all but admin</label>
				<select name="MOM_Exclude_Hide_Dashboard" class="allpages" id="MOM_Exclude_Hide_Dashboard">
				<option ';if(get_option('MOM_Exclude_Hide_Dashboard') == 1){echo ' selected="selected" ';} echo 'value="1">Yes</option>
				<option ';if(get_option('MOM_Exclude_Hide_Dashboard') == 0){echo ' selected="selected" ';} echo 'value="0">No</option>
				</select>
				</section>
				<section>
				<label for="MOM_Exclude_NoFollow">No Follow User Level Hidden</label>
				<select name="MOM_Exclude_NoFollow" class="allpages" id="MOM_Exclude_NoFollow">
				<option ';if(get_option('MOM_Exclude_NoFollow') == 1){echo ' selected="selected" ';} echo 'value="1">Yes</option>
				<option ';if(get_option('MOM_Exclude_NoFollow') == 0){echo ' selected="selected" ';} echo 'value="0">No</option>
				</select>
				</section>
				<section>
				<label for="MOM_Exclude_URL">Redirect 404s (logged in)</label>
				<select name="MOM_Exclude_URL" class="allpages" id="MOM_Exclude_URL">
					<option value="">Home page</option>';
					foreach ($showmepages as $pagesshown){
						echo '<option name="MOM_Exclude_URL" id="mompaf_'.$pagesshown->ID.'" value="'.$pagesshown->ID.'"'; 
						if (get_option('MOM_Exclude_URL') == $pagesshown->ID){echo ' selected="selected"';} echo '>
						'.$pagesshown->post_title.'</option>';
					}
					echo '
				</select>
				</section>
				<section>
				<label for="MOM_Exclude_URL_User">Redirect 404s (logged out)</label>
				<select name="MOM_Exclude_URL_User" class="allpages" id="MOM_Exclude_URL_User">
					<option value=""/>Home page</option>';
					foreach ($showmepages as $pagesshownuser){
						echo '<option name="MOM_Exclude_URL_User" id="mompaf_'.$pagesshownuser->ID.'" value="'.$pagesshown->ID.'"'; 
						if (get_option('MOM_Exclude_URL_User') == $pagesshownuser->ID){echo ' selected="selected"';} echo '>
						'.$pagesshownuser->post_title.'</option>';
					}
					echo '
				</select>
				</section>
				';
			}
			function momse_page_content(){
				echo '
				<span class="moduletitle">__exclude<em>separate multiple ids with commas (1,2,3,...)</em></span>
				<div class="clear"></div>				
				<div class="settings">
				<form method="post">';
						momse_form();
						echo '
						<input id="momsesave" type="submit" value="Save Changes" name="momsesave">
					</form>
				</div>
				</div>
				</div>
				<div class="new"></div>';
			}
			if(isset($_POST['momsesave'])){update_momse_options();}
			momse_page_content();
		}
		my_optional_modules_exclude_module();
	}
?>