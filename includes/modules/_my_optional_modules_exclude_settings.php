<?php 

/**
 *
 * Module->Exclude->Settings
 *
 * 
 * 
 *
 * Since ?
 * @my_optional_modules
 *
 */

/**
 *
 * Don't call this file directly
 *
 */
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

if(current_user_can('manage_options')){
	function my_optional_modules_exclude_module(){
		$MOM_Exclude_PostFormats_RSS = get_option('MOM_Exclude_PostFormats_RSS');
		$MOM_Exclude_PostFormats_Front = get_option('MOM_Exclude_PostFormats_Front');
		$MOM_Exclude_PostFormats_CategoryArchives = get_option('MOM_Exclude_PostFormats_CategoryArchives');
		$MOM_Exclude_PostFormats_TagArchives = get_option('MOM_Exclude_PostFormats_TagArchives');
		$MOM_Exclude_PostFormats_SearchResults = get_option('MOM_Exclude_PostFormats_SearchResults');
		$MOM_Exclude_PostFormats_Visitor = get_option('MOM_Exclude_PostFormats_Visitor');
		$MOM_Exclude_Hide_Dashboard = get_option('MOM_Exclude_Hide_Dashboard');
		$MOM_Exclude_NoFollow = get_option('MOM_Exclude_NoFollow');
		$MOM_Exclude_URL = get_option('MOM_Exclude_URL');
		$MOM_Exclude_URL_User = get_option('MOM_Exclude_URL_User');			
		$showmepages = get_pages(); 			
		$showmecats = get_categories('taxonomy=category&hide_empty=0'); 
		$showmetags = get_categories('taxonomy=post_tag&hide_empty=0');
		echo '
		<strong class="sectionTitle">Exclude Settings</strong>
		<form method="post" class="clear">
			<p><strong class="sectionTitle">Hide Categories from..</strong>
			<i class="fa fa-info">&mdash;</i> Separate multiple categories with commas</p>
			<div class="list"><span>Category (<strong>ID</strong>)</span>';
			foreach($showmecats as $catsshown){
				echo '
				<span>'.$catsshown->cat_name.'(<strong>'.$catsshown->cat_ID.'</strong>)</span>';
			}
		echo '</div><br />';
		$exclude = array('MOM_Exclude_Categories_RSS','MOM_Exclude_Categories_Front','MOM_Exclude_Categories_TagArchives','MOM_Exclude_Categories_SearchResults','MOM_Exclude_Categories_CategoriesSun','MOM_Exclude_Categories_CategoriesMon','MOM_Exclude_Categories_CategoriesTue','MOM_Exclude_Categories_CategoriesWed','MOM_Exclude_Categories_CategoriesThu','MOM_Exclude_Categories_CategoriesFri','MOM_Exclude_Categories_CategoriesSat','MOM_Exclude_Categories_level0Categories','MOM_Exclude_Categories_level1Categories','MOM_Exclude_Categories_level2Categories','MOM_Exclude_Categories_level7Categories');
		$section = array( 'RSS','Front page','Tag archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
		foreach($exclude as $exc ) {
				$title = str_replace($exclude,$section,$exc);
				echo '<section class="clear"><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
		}				
		echo '<hr />
		<p><strong class="sectionTitle">Hide Tags from..</strong>
		<i class="fa fa-info">&mdash;</i> Separate multiple tags with commas</p>
		<div class="list"><span>Tag (<strong>ID</strong>)</span>';
			foreach($showmetags as $tagsshown){
				echo '<span>'.$tagsshown->cat_name.'(<strong>'.$tagsshown->cat_ID.'</strong>)</span>';
			}
		echo '</div><br />';
		$exclude = array('MOM_Exclude_Tags_RSS','MOM_Exclude_Tags_Front','MOM_Exclude_Tags_CategoryArchives','MOM_Exclude_Tags_SearchResults','MOM_Exclude_Tags_TagsSun','MOM_Exclude_Tags_TagsMon','MOM_Exclude_Tags_TagsTue','MOM_Exclude_Tags_TagsWed','MOM_Exclude_Tags_TagsThu','MOM_Exclude_Tags_TagsFri','MOM_Exclude_Tags_TagsSat','MOM_Exclude_Tags_level0Tags','MOM_Exclude_Tags_level1Tags','MOM_Exclude_Tags_level2Tags','MOM_Exclude_Tags_level7Tags');
		$section = array( 'RSS','Front page','Category archives','Search results','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Logged out','Subscriber','Contributor','Author','Editor');
		foreach($exclude as $exc ) {
				$title = str_replace($exclude,$section,$exc);
				echo '<section class="clear"><label class="left" for="'.$exc.'">'.$title.'</label><input class="right" type="text" id="'.$exc.'" name="'.$exc.'" value="'.get_option($exc).'"></section>';
		}				
		echo '<hr />
		
		<strong class="sectionTitle">Hide Post Formats from..</strong>
		<section class="clear">
			<label class="left" for="MOM_Exclude_PostFormats_RSS">RSS</label>
			<select class="right" name="MOM_Exclude_PostFormats_RSS" id="MOM_Exclude_PostFormats_RSS">
				<option value="">none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-aside'); echo '>Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-gallery'); echo '>Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-link'); echo '>Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-image'); echo '>Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-quote'); echo '>Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-status'); echo '>Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-video'); echo '>Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-audio'); echo '>Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_RSS, 'post-format-chat'); echo '>Chat</option>
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_PostFormats_Front">front page</label>
			<select class="right" name="MOM_Exclude_PostFormats_Front" id="MOM_Exclude_PostFormats_Front">
				<option value="">none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Front, 'post-format-aside'); echo '>Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Front,'post-format-gallery'); echo '>Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Front,'post-format-link'); echo '>Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Front,'post-format-image'); echo '>Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Front,'post-format-quote'); echo '>Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Front,'post-format-status'); echo '>Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Front,'post-format-video'); echo '>Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Front,'post-format-audio'); echo '>Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Front,'post-format-chat'); echo '>Chat</option>
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_PostFormats_CategoryArchives">archives</label>
			<select class="right" name="MOM_Exclude_PostFormats_CategoryArchives" id="MOM_Exclude_PostFormats_CategoryArchives">
				<option value="">none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_CategoryArchives, 'post-format-aside'); echo '>Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-gallery'); echo '>Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-link'); echo '>Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-image'); echo '>Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-quote'); echo '>Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-status'); echo '>Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-video'); echo '>Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-audio'); echo '>Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_CategoryArchives,'post-format-chat'); echo '>Chat</option>
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_PostFormats_TagArchives">tags</label>
			<select class="right" name="MOM_Exclude_PostFormats_TagArchives" id="MOM_Exclude_PostFormats_TagArchives">
				<option value="">none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-aside'); echo '>Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-gallery'); echo '>Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-link'); echo '>Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-image'); echo '>Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-quote'); echo '>Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-status'); echo '>Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-video'); echo '>Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-audio'); echo '>Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_TagArchives, 'post-format-chat'); echo '>Chat</option>
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_PostFormats_SearchResults">search results</label>
			<select class="right" name="MOM_Exclude_PostFormats_SearchResults" id="MOM_Exclude_PostFormats_SearchResults">
				<option value="">none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-aside'); echo '>Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-gallery'); echo '>Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-link'); echo '>Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-image'); echo '>Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-quote'); echo '>Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-status'); echo '>Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-video'); echo '>Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-audio'); echo '>Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_SearchResults, 'post-format-chat'); echo '>Chat</option>
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_PostFormats_Visitor">logged out</label>
			<select class="right" name="MOM_Exclude_PostFormats_Visitor" id="MOM_Exclude_PostFormats_Visitor">
				<option value="">none</option>
				<option value="post-format-aside"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-aside'); echo '>Aside</option>
				<option value="post-format-gallery"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-gallery'); echo '>Gallery</option>
				<option value="post-format-link"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-link'); echo '>Link</option>
				<option value="post-format-image"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-image'); echo '>Image</option>
				<option value="post-format-quote"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-quote'); echo '>Quote</option>
				<option value="post-format-status"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-status'); echo '>Status</option>
				<option value="post-format-video"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-video'); echo '>Video</option>
				<option value="post-format-audio"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-audio'); echo '>Audio</option>
				<option value="post-format-chat"'; selected($MOM_Exclude_PostFormats_Visitor, 'post-format-chat'); echo '>Chat</option>
			</select>
		</section>

		<hr />

		<p><strong class="sectionTitle">Additional settings</strong>
		<i class="fa fa-info">&mdash;</i> <em>Hide dash</em> hides the dash from all users except 
		for admin. <em>No follow user</em> no follows categories hidden from nonusers. <em>User 404s</em> 
		and <em>Visitor 404s</em> will redirect 404 errors for (logged in) and (non-logged in) visitors.</p>
		<section class="clear">
			<label class="left" for="MOM_Exclude_Hide_Dashboard">Hide Dash</label>
			<select class="right" name="MOM_Exclude_Hide_Dashboard" class="allpages" id="MOM_Exclude_Hide_Dashboard">
				<option '; selected($MOM_Exclude_Hide_Dashboard, 1); echo 'value="1">Yes</option>
				<option '; selected($MOM_Exclude_Hide_Dashboard, 0); echo 'value="0">No</option>
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_NoFollow">No Follow User</label>
			<select class="right" name="MOM_Exclude_NoFollow" class="allpages" id="MOM_Exclude_NoFollow">
				<option '; selected($MOM_Exclude_NoFollow, 1); echo 'value="1">Yes</option>
				<option '; selected($MOM_Exclude_NoFollow, 0); echo 'value="0">No</option>
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_URL">User 404s</label>
			<select class="right" name="MOM_Exclude_URL" class="allpages" id="MOM_Exclude_URL">
				<option value="NULL">Off</option>
				<option value="">Home page</option>';
				foreach($showmepages as $pagesshown){ echo '<option name="MOM_Exclude_URL" id="mompaf_'.$pagesshown->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownID = $pagesshown->ID; selected($MOM_Exclude_URL, $pagesshownID); echo '> '.$pagesshown->post_title.'</option>'; }
				echo '
			</select>
		</section>
		<section class="clear">
			<label class="left" for="MOM_Exclude_URL_User">Visitor 404s</label>
			<select class="right" name="MOM_Exclude_URL_User" class="allpages" id="MOM_Exclude_URL_User">
				<option value="NULL">Off</option>
				<option value=""/>Home page</option>';
				foreach($showmepages as $pagesshownuser){ echo '<option name="MOM_Exclude_URL_User" id="mompaf_'.$pagesshownuser->ID.'" value="'.$pagesshown->ID.'"'; $pagesshownuserID = $pagesshownuser->ID; selected ($MOM_Exclude_URL_User, $pagesshownuserID); echo '> '.$pagesshownuser->post_title.'</option>';}
				echo '
			</select>
		</section>
		<input id="momsesave" type="submit" value="Save Changes" name="momsesave"></form>

		<form class="clear" method="post" action="" name="momExclude">
		<label for="mom_exclude_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate Exclude module</label>
		<input type="text" class="hidden" value="';if(get_option('mommaincontrol_momse') == 1){echo '0';}else{echo '1';}echo '" name="exclude" /><input type="submit" id="mom_exclude_mode_submit" name="mom_exclude_mode_submit" value="Submit" class="hidden" />
		</form>';
		
		
	}
}