<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}

	//	MY OPTIONAL MODULES
	//		MODULE: EXCLUDE

	if(is_admin()){ 

		// Upgrade exclude option names if old options are still present and new option names don't yet exist (in database)
		function MOMExcludeUpgrade(){$MOMExclude01 = (get_option('simple_announcement_with_exclusion_cat_visitor'));$MOMExclude02 = (get_option('simple_announcement_with_exclusion_tag_visitor'));$MOMExclude03 = (get_option('simple_announcement_with_exclusion_9'));$MOMExclude04 = (get_option('simple_announcement_with_exclusion_9_2'));$MOMExclude05 = (get_option('simple_announcement_with_exclusion_9_3'));$MOMExclude06 = (get_option('simple_announcement_with_exclusion_9_4'));$MOMExclude07 = (get_option('simple_announcement_with_exclusion_9_5'));$MOMExclude08 = (get_option('simple_announcement_with_exclusion_9_7'));$MOMExclude09 = (get_option('simple_announcement_with_exclusion_9_8'));$MOMExclude10 = (get_option('simple_announcement_with_exclusion_9_9'));$MOMExclude11 = (get_option('simple_announcement_with_exclusion_9_10'));$MOMExclude12 = (get_option('simple_announcement_with_exclusion_9_11'));$MOMExclude13 = (get_option('simple_announcement_with_exclusion_9_12'));$MOMExclude14 = (get_option('simple_announcement_with_exclusion_9_13'));$MOMExclude15 = (get_option('simple_announcement_with_exclusion_9_14'));$MOMExclude16 = (get_option('simple_announcement_with_exclusion_sun'));$MOMExclude17 = (get_option('simple_announcement_with_exclusion_mon'));$MOMExclude18 = (get_option('simple_announcement_with_exclusion_tue'));$MOMExclude19 = (get_option('simple_announcement_with_exclusion_wed'));$MOMExclude20 = (get_option('simple_announcement_with_exclusion_thu'));$MOMExclude21 = (get_option('simple_announcement_with_exclusion_fri'));$MOMExclude22 = (get_option('simple_announcement_with_exclusion_sat'));$MOMExclude23 = (get_option('simple_announcement_with_exclusion_cat_sun'));$MOMExclude24 = (get_option('simple_announcement_with_exclusion_cat_mon'));$MOMExclude25 = (get_option('simple_announcement_with_exclusion_cat_tue'));$MOMExclude26 = (get_option('simple_announcement_with_exclusion_cat_wed'));$MOMExclude27 = (get_option('simple_announcement_with_exclusion_cat_thu'));$MOMExclude28 = (get_option('simple_announcement_with_exclusion_cat_fri'));$MOMExclude29 = (get_option('simple_announcement_with_exclusion_cat_sat'));if(get_option('simple_announcement_with_exclusion_cat_visitor')){add_option('MOM_Exclude_VisitorCategories',$MOMExclude01);delete_option('simple_announcement_with_exclusion_cat_visitor');}if(get_option('simple_announcement_with_exclusion_tag_visitor')){add_option('MOM_Exclude_VisitorTags',$MOMExclude02);delete_option('simple_announcement_with_exclusion_tag_visitor');}if(get_option('simple_announcement_with_exclusion_9')){add_option('MOM_Exclude_Categories_Front',$MOMExclude03);delete_option('simple_announcement_with_exclusion_9');}if(get_option('simple_announcement_with_exclusion_9_2')){add_option('MOM_Exclude_Categories_TagArchives',$MOMExclude04);delete_option('simple_announcement_with_exclusion_9_2');}if(get_option('simple_announcement_with_exclusion_9_3')){add_option('MOM_Exclude_Categories_SearchResults',$MOMExclude05);delete_option('simple_announcement_with_exclusion_9_3');}if(get_option('simple_announcement_with_exclusion_9_4')){add_option('MOM_Exclude_Tags_Front',$MOMExclude06);delete_option('simple_announcement_with_exclusion_9_4');}if(get_option('simple_announcement_with_exclusion_9_5')){add_option('MOM_Exclude_Tags_CategoryArchives',$MOMExclude07);delete_option('simple_announcement_with_exclusion_9_5');}if(get_option('simple_announcement_with_exclusion_9_7')){add_option('MOM_Exclude_Tags_SearchResults',$MOMExclude08);delete_option('simple_announcement_with_exclusion_9_7');}if(get_option('simple_announcement_with_exclusion_9_8')){add_option('MOM_Exclude_PostFormats_Front',$MOMExclude09);delete_option('simple_announcement_with_exclusion_9_8');}if(get_option('simple_announcement_with_exclusion_9_9')){add_option('MOM_Exclude_PostFormats_CategoryArchives',$MOMExclude10);delete_option('simple_announcement_with_exclusion_9_9');}if(get_option('simple_announcement_with_exclusion_9_10')){add_option('MOM_Exclude_PostFormats_TagArchives',$MOMExclude11);delete_option('simple_announcement_with_exclusion_9_10');}if(get_option('simple_announcement_with_exclusion_9_11')){add_option('MOM_Exclude_PostFormats_SearchResults',$MOMExclude12);delete_option('simple_announcement_with_exclusion_9_11');}if(get_option('simple_announcement_with_exclusion_9_12')){add_option('MOM_Exclude_Categories_RSS',$MOMExclude13);delete_option('simple_announcement_with_exclusion_9_12');}if(get_option('simple_announcement_with_exclusion_9_13')){add_option('MOM_Exclude_Tags_RSS',$MOMExclude14);delete_option('simple_announcement_with_exclusion_9_13');}if(get_option('simple_announcement_with_exclusion_9_14')){add_option('MOM_Exclude_PostFormats_RSS',$MOMExclude15);delete_option('simple_announcement_with_exclusion_9_14');}if(get_option('simple_announcement_with_exclusion_sun')){add_option('MOM_Exclude_TagsSun',$MOMExclude16);delete_option('simple_announcement_with_exclusion_sun');}if(get_option('simple_announcement_with_exclusion_mon')){add_option('MOM_Exclude_TagsMon',$MOMExclude17);delete_option('simple_announcement_with_exclusion_mon');}if(get_option('simple_announcement_with_exclusion_tue')){add_option('MOM_Exclude_TagsTue',$MOMExclude18);delete_option('simple_announcement_with_exclusion_tue');}if(get_option('simple_announcement_with_exclusion_wed')){add_option('MOM_Exclude_TagsWed',$MOMExclude19);delete_option('simple_announcement_with_exclusion_wed');}if(get_option('simple_announcement_with_exclusion_thu')){add_option('MOM_Exclude_TagsThu',$MOMExclude20);delete_option('simple_announcement_with_exclusion_thu');}if(get_option('simple_announcement_with_exclusion_fri')){add_option('MOM_Exclude_TagsFri',$MOMExclude21);delete_option('simple_announcement_with_exclusion_fri');}if(get_option('simple_announcement_with_exclusion_sat')){add_option('MOM_Exclude_TagsSat',$MOMExclude22);delete_option('simple_announcement_with_exclusion_sat');}if(get_option('simple_announcement_with_exclusion_cat_sun')){add_option('MOM_Exclude_CategoriesSun',$MOMExclude23);delete_option('simple_announcement_with_exclusion_cat_sun');}if(get_option('simple_announcement_with_exclusion_cat_mon')){add_option('MOM_Exclude_CategoriesMon',$MOMExclude24);delete_option('simple_announcement_with_exclusion_cat_mon');}if(get_option('simple_announcement_with_exclusion_cat_tue')){add_option('MOM_Exclude_CategoriesTue',$MOMExclude25);delete_option('simple_announcement_with_exclusion_cat_tue');}if(get_option('simple_announcement_with_exclusion_cat_wed')){add_option('MOM_Exclude_CategoriesWed',$MOMExclude26);delete_option('simple_announcement_with_exclusion_cat_wed');}if(get_option('simple_announcement_with_exclusion_cat_thu')){add_option('MOM_Exclude_CategoriesThu',$MOMExclude27);delete_option('simple_announcement_with_exclusion_cat_thu');}if(get_option('simple_announcement_with_exclusion_cat_fri')){add_option('MOM_Exclude_CategoriesFri',$MOMExclude28);delete_option('simple_announcement_with_exclusion_cat_fri');}if(get_option('simple_announcement_with_exclusion_cat_sat')){add_option('MOM_Exclude_CategoriesSat',$MOMExclude29);delete_option('simple_announcement_with_exclusion_cat_sat');}}
		if (!get_option('MOM_Exclude_VisitorCategories') || get_option('MOM_Exclude_VisitorCategories') != '' ||!get_option('MOM_Exclude_VisitorCategories') || get_option('MOM_Exclude_VisitorCategories') != '' || !get_option('MOM_Exclude_VisitorTags') || get_option('MOM_Exclude_VisitorTags') != '' || !get_option('MOM_Exclude_Categories_Front') || get_option('MOM_Exclude_Categories_Front') != '' || !get_option('MOM_Exclude_Categories_TagArchives') || get_option('MOM_Exclude_Categories_TagArchives') != '' || !get_option('MOM_Exclude_Categories_SearchResults') || get_option('MOM_Exclude_Categories_SearchResults') != '' || !get_option('MOM_Exclude_Tags_Front') || get_option('MOM_Exclude_Tags_Front') != '' || !get_option('MOM_Exclude_Tags_CategoryArchives') || get_option('MOM_Exclude_Tags_CategoryArchives') != '' || !get_option('MOM_Exclude_Tags_SearchResults') || get_option('MOM_Exclude_Tags_SearchResults') != '' || !get_option('MOM_Exclude_PostFormats_Front') || get_option('MOM_Exclude_PostFormats_Front') != '' || !get_option('MOM_Exclude_PostFormats_CategoryArchives') || get_option('MOM_Exclude_PostFormats_CategoryArchives') != '' || !get_option('MOM_Exclude_PostFormats_TagArchives') || get_option('MOM_Exclude_PostFormats_TagArchives') != '' || !get_option('MOM_Exclude_PostFormats_SearchResults') || get_option('MOM_Exclude_PostFormats_SearchResults') != '' || !get_option('MOM_Exclude_Categories_RSS') || get_option('MOM_Exclude_Categories_RSS') != '' || !get_option('MOM_Exclude_Tags_RSS') || get_option('MOM_Exclude_Tags_RSS') != '' || !get_option('MOM_Exclude_PostFormats_RSS') || get_option('MOM_Exclude_PostFormats_RSS') != '' || !get_option('MOM_Exclude_TagsSun') || get_option('MOM_Exclude_TagsSun') != '' || !get_option('MOM_Exclude_TagsMon') || get_option('MOM_Exclude_TagsMon') != '' || !get_option('MOM_Exclude_TagsTue') || get_option('MOM_Exclude_TagsTue') != '' || !get_option('MOM_Exclude_TagsWed') || get_option('MOM_Exclude_TagsWed') != '' || !get_option('MOM_Exclude_TagsThu') || get_option('MOM_Exclude_TagsThu') != '' || !get_option('MOM_Exclude_TagsFri') || get_option('MOM_Exclude_TagsFri') != '' || !get_option('MOM_Exclude_TagsSat') || get_option('MOM_Exclude_TagsSat') != '' || !get_option('MOM_Exclude_CategoriesSun') || get_option('MOM_Exclude_CategoriesSun') != '' || !get_option('MOM_Exclude_CategoriesMon') || get_option('MOM_Exclude_CategoriesMon') != '' || !get_option('MOM_Exclude_CategoriesTue') || get_option('MOM_Exclude_CategoriesTue') != '' || !get_option('MOM_Exclude_CategoriesWed') || get_option('MOM_Exclude_CategoriesWed') != '' || !get_option('MOM_Exclude_CategoriesThu') || get_option('MOM_Exclude_CategoriesThu') != '' || !get_option('MOM_Exclude_CategoriesFri') || get_option('MOM_Exclude_CategoriesFri') != '' || !get_option('MOM_Exclude_CategoriesSat') || get_option('MOM_Exclude_CategoriesSat')){MOMExcludeUpgrade();}

		function my_optional_modules_exclude_module(){
		
			add_theme_support('post-formats',array('aside','gallery','link','image','quote','status','video','audio','chat'));
		
			function update_momse_options(){
				if(isset($_POST['momsesave'])){
					update_option('MOM_Exclude_VisitorCategories',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',($_REQUEST['MOM_Exclude_VisitorCategories']))))))));
					update_option('MOM_Exclude_Categories_RSS',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_RSS'])))))))));
					update_option('MOM_Exclude_Categories_Front',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_Front'])))))))));
					update_option('MOM_Exclude_Categories_TagArchives',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_TagArchives'])))))))));
					update_option('MOM_Exclude_Categories_SearchResults',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Categories_SearchResults'])))))))));
					update_option('MOM_Exclude_VisitorTags',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_VisitorTags'])))))))));
					update_option('MOM_Exclude_Tags_RSS',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_RSS'])))))))));
					update_option('MOM_Exclude_Tags_Front',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_Front'])))))))));
					update_option('MOM_Exclude_Tags_CategoryArchives',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_CategoryArchives'])))))))));
					update_option('MOM_Exclude_Tags_SearchResults',sanitize_text_field(implode(',',array_unique(explode(',',(preg_replace('/[^0-9,.]/','',(($_REQUEST['MOM_Exclude_Tags_SearchResults'])))))))));
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
				}
			}

			function momse_form(){
				echo '
				<div class="settingsInfo">
					<h2>Categories</h2>
					<div class="list">';
					$showmecats = get_categories('taxonomy=category'); 
					foreach($showmecats as $catsshown){
						echo '
						<span>'.$catsshown->cat_name.'(<strong>'.$catsshown->cat_ID.'</strong>)</span>';
					}
				echo '
					</div>
				</div>
				<div class="settingsInput">
					<section>Comma separate multiple IDs (1,2,3)</section>
					<section><label for="MOM_Exclude_VisitorCategories">Hide from logged out</label><input type="text" id="MOM_Exclude_VisitorCategories" name="MOM_Exclude_VisitorCategories" value="'.get_option('MOM_Exclude_VisitorCategories').'"></section>
					<section><label for="MOM_Exclude_Categories_RSS">Hide from RSS</label><input type="text" id="MOM_Exclude_Categories_RSS" name="MOM_Exclude_Categories_RSS" value="'.get_option('MOM_Exclude_Categories_RSS').'"></section>
					<section><label for="MOM_Exclude_Categories_Front">Hide from front page</label><input type="text" id="MOM_Exclude_Categories_Front" name="MOM_Exclude_Categories_Front" value="'.get_option('MOM_Exclude_Categories_Front').'"></section>
					<section><label for="MOM_Exclude_Categories_TagArchives">Hide from tag archives</label><input type="text" id="MOM_Exclude_Categories_TagArchives" name="MOM_Exclude_Categories_TagArchives" value="'.get_option('MOM_Exclude_Categories_TagArchives').'"></section>
					<section><label for="MOM_Exclude_Categories_SearchResults">Hide from search results</label><input type="text" id="MOM_Exclude_Categories_SearchResults" name="MOM_Exclude_Categories_SearchResults" value="'.get_option('MOM_Exclude_Categories_SearchResults').'"></section>
					<section><label for="MOM_Exclude_CategoriesSun">Hide on Sunday</label><input type="text" id="MOM_Exclude_CategoriesSun" name="MOM_Exclude_CategoriesSun" value="'.get_option('MOM_Exclude_CategoriesSun').'"></section>
					<section><label for="MOM_Exclude_CategoriesMon">Hide on Monday</label><input type="text" id="MOM_Exclude_CategoriesMon" name="MOM_Exclude_CategoriesMon" value="'.get_option('MOM_Exclude_CategoriesMon').'"></section>
					<section><label for="MOM_Exclude_CategoriesTue">Hide on Tuesday</label><input type="text" id="MOM_Exclude_CategoriesTue" name="MOM_Exclude_CategoriesTue" value="'.get_option('MOM_Exclude_CategoriesTue').'"></section>
					<section><label for="MOM_Exclude_CategoriesWed">Hide on Wednesday</label><input type="text" id="MOM_Exclude_CategoriesWed" name="MOM_Exclude_CategoriesWed" value="'.get_option('MOM_Exclude_CategoriesWed').'"></section>
					<section><label for="MOM_Exclude_CategoriesThu">Hide on Thursday</label><input type="text" id="MOM_Exclude_CategoriesThu" name="MOM_Exclude_CategoriesThu" value="'.get_option('MOM_Exclude_CategoriesThu').'"></section>
					<section><label for="MOM_Exclude_CategoriesFri">Hide on Friday</label><input type="text" id="MOM_Exclude_CategoriesFri" name="MOM_Exclude_CategoriesFri" value="'.get_option('MOM_Exclude_CategoriesFri').'"></section>
					<section><label for="MOM_Exclude_CategoriesSat">Hide on Saturday</label><input type="text" id="MOM_Exclude_CategoriesSat" name="MOM_Exclude_CategoriesSat" value="'.get_option('MOM_Exclude_CategoriesSat').'"></section>
				</div>';
				
				echo '
				<div class="clear top"></div>
				<div class="settingsInfo">
				<h2>Tags</h2>
				<div class="list">';
					$showmetags =  get_categories('taxonomy=post_tag');
						foreach ($showmetags as $tagsshown){
						echo '<span>'.$tagsshown->cat_name.'(<strong>'.$tagsshown->cat_ID.'</strong>)</span>';
					}
				echo '
				</div>
				</div>
				<div class="settingsInput">
					<section>Comma separate multiple IDs (1,2,3)</section>
					<section><label for="MOM_Exclude_VisitorTags">Hide from logged out</label><input type="text" id="MOM_Exclude_VisitorTags" name="MOM_Exclude_VisitorTags" value="'.get_option('MOM_Exclude_VisitorTags').'"></section>				
					<section><label for="MOM_Exclude_Tags_RSS">Hide from RSS</label><input type="text" id="MOM_Exclude_Tags_RSS" name="MOM_Exclude_Tags_RSS" value="'.get_option('MOM_Exclude_Tags_RSS').'"></section>
					<section><label for="MOM_Exclude_Tags_Front">Hide from front page</label><input type="text" id="MOM_Exclude_Tags_Front" name="MOM_Exclude_Tags_Front" value="'.get_option('MOM_Exclude_Tags_Front').'"></section>
					<section><label for="MOM_Exclude_Tags_CategoryArchives">Hide from category archives</label><input type="text" id="MOM_Exclude_Tags_CategoryArchives" name="MOM_Exclude_Tags_CategoryArchives" value="'.get_option('MOM_Exclude_Tags_CategoryArchives').'"></section>
					<section><label for="MOM_Exclude_Tags_SearchResults">Hide from search results</label><input type="text" id="MOM_Exclude_Tags_SearchResults" name="MOM_Exclude_Tags_SearchResults" value="'.get_option('MOM_Exclude_Tags_SearchResults').'"></section>
					<section><label for="MOM_Exclude_TagsSun">Hide on Sunday</label><input type="text" id="MOM_Exclude_TagsSun" name="MOM_Exclude_TagsSun" value="'.get_option('MOM_Exclude_TagsSun').'"></section>
					<section><label for="MOM_Exclude_TagsMon">Hide on Monday</label><input type="text" id="MOM_Exclude_TagsMon" name="MOM_Exclude_TagsMon" value="'.get_option('MOM_Exclude_TagsMon').'"></section>
					<section><label for="MOM_Exclude_TagsTue">Hide on Tuesday</label><input type="text" id="MOM_Exclude_TagsTue" name="MOM_Exclude_TagsTue" value="'.get_option('MOM_Exclude_TagsTue').'"></section>
					<section><label for="MOM_Exclude_TagsWed">Hide on Wednesday</label><input type="text" id="MOM_Exclude_TagsWed" name="MOM_Exclude_TagsWed" value="'.get_option('MOM_Exclude_TagsWed').'"></section>
					<section><label for="MOM_Exclude_TagsThu">Hide on Thursday</label><input type="text" id="MOM_Exclude_TagsThu" name="MOM_Exclude_TagsThu" value="'.get_option('MOM_Exclude_TagsThu').'"></section>
					<section><label for="MOM_Exclude_TagsFri">Hide on Friday</label><input type="text" id="MOM_Exclude_TagsFri" name="MOM_Exclude_TagsFri" value="'.get_option('MOM_Exclude_TagsFri').'"></section>
					<section><label for="MOM_Exclude_TagsSat">Hide on Saturday</label><input type="text" id="MOM_Exclude_TagsSat" name="MOM_Exclude_TagsSat" value="'.get_option('MOM_Exclude_TagsSat').'"></section>
				</div>
				<div class="clear top"></div>
				<div class="settingsInfo">
				<h2>Post Formats</h2>
				</div>
				<div class="settingsInput">';
				
				echo '
				<section>
					<label for=\"MOM_Exclude_PostFormats_RSS\">Hide from RSS</label>
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
					<label for="MOM_Exclude_PostFormats_Front">Hide from front page</label>
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
					<label for="MOM_Exclude_PostFormats_CategoryArchives">Hide from archives</label>
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
					<label for="MOM_Exclude_PostFormats_TagArchives">Hide from tag archives</label>
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
					<label for="MOM_Exclude_PostFormats_SearchResults">Hide from search results</label>
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

				</div>
				';
			}

			function momse_page_content(){
				echo '
				<form method="post">
					<div class="settings">';
						momse_form();
						echo '
						<input id="momsesave" type="submit" value="Save Changes" name="momsesave">
						</div>
					</form>';
			}
			if(isset($_POST['momsesave'])){update_momse_options();}
			momse_page_content();
		}
		
		my_optional_modules_exclude_module();
	}

?>