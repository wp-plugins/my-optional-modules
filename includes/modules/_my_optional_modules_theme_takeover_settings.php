<?php
if( !defined( 'MyOptionalModules' ) ) { 
	die();
}
if(current_user_can('manage_options')){
	function my_optional_modules_theme_takeover_module(){
		$MOM_themetakeover_topbar = get_option('MOM_themetakeover_topbar');
		$MOM_themetakeover_extend = get_option('MOM_themetakeover_extend');
		$MOM_themetakeover_topbar_color = get_option('MOM_themetakeover_topbar_color');
		$MOM_themetakeover_topbar_search = get_option('MOM_themetakeover_topbar_search');
		$MOM_themetakeover_topbar_share = get_option('MOM_themetakeover_topbar_share');
		$MOM_themetakeover_backgroundimage = get_option('MOM_themetakeover_backgroundimage');
		$MOM_themetakeover_wowhead = get_option('MOM_themetakeover_wowhead');
		$MOM_themetakeover_horizontal_galleries = get_option('MOM_themetakeover_horizontal_galleries');
		$MOM_themetakeover_ajaxcomments = get_option('MOM_themetakeover_ajaxcomments');
		$MOM_themetakeover_tiledfrontpage = get_option('MOM_themetakeover_tiledfrontpage');
		$MOM_themetakeover_commentlength = get_option('MOM_themetakeover_commentlength');
		$showmepages = get_pages(); ?>
		<strong class="sectionTitle">Takeover Settings</strong>
		<form class="clear" method="post">
		
			<section class="clear">
				<label class="left" for="MOM_themetakeover_tiledfrontpage">Tiled Front Page</label>
				<select class="right" id="MOM_themetakeover_tiledfrontpage" name="MOM_themetakeover_tiledfrontpage">
					<option value="0" <?php selected($MOM_themetakeover_tiledfrontpage, 0);?> >No</option>
					<option value="1" <?php selected($MOM_themetakeover_tiledfrontpage, 1);?> >Yes</option>
				</select>				
			</section>
		
			<p></p>
		
			<section class="clear">
				<label class="left" for="MOM_themetakeover_ajaxcomments">Ajaxify Comments</label>
				<select class="right" id="MOM_themetakeover_ajaxcomments" name="MOM_themetakeover_ajaxcomments">
					<option value="0" <?php selected($MOM_themetakeover_ajaxcomments, 0);?> >No</option>
					<option value="1" <?php selected($MOM_themetakeover_ajaxcomments, 1);?> >Yes</option>
				</select>
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_commentlength">Max Comment Length</label>
				<input class="right" type="text" id="MOM_themetakeover_commentlength" name="MOM_themetakeover_commentlength" value="<?php echo $MOM_themetakeover_commentlength; ?>" />
			</section>					
			<section class="clear">
				<label class="left" for="MOM_themetakeover_horizontal_galleries">Horizontal Galleries</label>
				<select class="right" id="MOM_themetakeover_horizontal_galleries" name="MOM_themetakeover_horizontal_galleries">
					<option value="0" <?php selected($MOM_themetakeover_horizontal_galleries, 0);?> >No</option>
					<option value="1" <?php selected($MOM_themetakeover_horizontal_galleries, 1);?> >Yes</option>
				</select>
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_fitvids"><a href="http://fitvidsjs.com/">Fitvid</a> .class</label>
				<input class="right" type="text" id="MOM_themetakeover_fitvids" name="MOM_themetakeover_fitvids" value="<?php echo esc_attr(get_option('MOM_themetakeover_fitvids'))?>">
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_postdiv">Post content .div</label>
				<input class="right" type="text" placeholder=".entry" id="MOM_themetakeover_postdiv" name="MOM_themetakeover_postdiv" value="<?php echo esc_attr(get_option('MOM_themetakeover_postdiv'));?>">
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_postelement">Post title .element</label>
				<input class="right" type="text" placeholder="h1" id="MOM_themetakeover_postelement" name="MOM_themetakeover_postelement" value="<?php echo esc_attr(get_option('MOM_themetakeover_postelement'));?>">
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_posttoggle">Toggle text</label>
				<input class="right" type="text" placeholder="Toggle contents" id="MOM_themetakeover_posttoggle" name="MOM_themetakeover_posttoggle" value="<?php echo esc_attr(get_option('MOM_themetakeover_posttoggle'));?>">
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_topbar">Enable navbar</label>
				<select class="right" id="MOM_themetakeover_topbar" name="MOM_themetakeover_topbar">
					<option value="1" <?php selected($MOM_themetakeover_topbar, 1);?>>Yes (top)</option>
					<option value="2" <?php selected($MOM_themetakeover_topbar, 2);?>>Yes (bottom)</option>
					<option value="0" <?php selected($MOM_themetakeover_topbar, 0);?>>No</option>
				</select>
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_extend">Extend navbar</label>
				<select class="right" id="MOM_themetakeover_extend" name="MOM_themetakeover_extend">
					<option value="1" <?php selected($MOM_themetakeover_extend, 1);?>>Yes</option>
					<option value="0" <?php selected($MOM_themetakeover_extend, 0);?>>No</option>
				</select>
			</section>			
			<section class="clear">
				<label class="left" for="MOM_themetakeover_topbar_color">Navbar scheme</label>
				<select class="right" id="MOM_themetakeover_topbar_color" name="MOM_themetakeover_topbar_color">
					<option value="1" <?php selected($MOM_themetakeover_topbar_color, 1);?>>Dark</option>
					<option value="2" <?php selected($MOM_themetakeover_topbar_color, 2);?>>Light</option>
					<option value="4" <?php selected($MOM_themetakeover_topbar_color, 4);?>>Red</option>
					<option value="5" <?php selected($MOM_themetakeover_topbar_color, 5);?>>Green</option>
					<option value="6" <?php selected($MOM_themetakeover_topbar_color, 6);?>>Blue</option>
					<option value="7" <?php selected($MOM_themetakeover_topbar_color, 7);?>>Yellow</option>
					<option value="3" <?php selected($MOM_themetakeover_topbar_color, 3);?>>Default</option>
				</select>
			</section>			
			<section class="clear">
				<label class="left" for="MOM_themetakeover_topbar_search">Enable search bar</label>
				<select class="right" id="MOM_themetakeover_topbar_search" name="MOM_themetakeover_topbar_search">
					<option value="0" <?php selected($MOM_themetakeover_topbar_search, 0);?>>No</option>
					<option value="1" <?php selected($MOM_themetakeover_topbar_search, 1);?>>Yes</option>
				</select>
			</section>						
			<section class="clear">
				<label class="left" for="MOM_themetakeover_topbar_share">Share icons</label>
				<select class="right" id="MOM_themetakeover_topbar_share" name="MOM_themetakeover_topbar_share">
					<option value="0" <?php selected($MOM_themetakeover_topbar_share, 0);?>>No</option>
					<option value="1" <?php selected($MOM_themetakeover_topbar_share, 1);?>>Yes</option>
				</select>
			</section>						
			<section class="clear">
				<label class="left" for="MOM_themetakeover_archivepage">Archives page</label>
				<select class="right" name="MOM_themetakeover_archivepage" class="allpages" id="MOM_themetakeover_archivepage">
				<option value="">Home page</option>					
				<?php foreach($showmepages as $pagesshown){ ?>
					<option name="MOM_themetakeover_archivepage" id="mompaf_<?php echo esc_attr($pagesshown->ID); ?>" value="<?php echo esc_attr($pagesshown->ID);?>"
					<?php $selectedarchivespage = $pagesshown->ID;
					$MOM_themetakeover_archivepage = get_option('MOM_themetakeover_archivepage');
					selected($MOM_themetakeover_archivepage, $selectedarchivespage);?>
					><?php echo $pagesshown->post_title; ?></option>
				<?php } ?>
				</select>
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_backgroundimage">Custom BG Image</label>
				<select class="right" id="MOM_themetakeover_backgroundimage" name="MOM_themetakeover_backgroundimage">
					<option value="0" <?php selected($MOM_themetakeover_backgroundimage, 0);?>>No</option>
					<option value="1" <?php selected($MOM_themetakeover_backgroundimage, 1);?>>Yes</option>
				</select>
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_wowhead">Wowhead (<a href="http://www.wowhead.com/tooltips">?</a>)</label>
				<select class="right" id="MOM_themetakeover_wowhead" name="MOM_themetakeover_wowhead">
					<option value="1" <?php selected($MOM_themetakeover_wowhead, 1);?>>Yes</option>
					<option value="0" <?php selected($MOM_themetakeover_wowhead, 0);?>>No</option>
				</select>
			</section>
			<input id="momthemetakeoversave" type="submit" value="Save Changes" name="momthemetakeoversave" />
		</form>
		<p></p>
		<form class="clear" method="post" action="" name="momThemTakeover">
			<label for="mom_themetakeover_mode_submit"><i class="fa fa-ban"></i> Click to Deactivate the Takeover module</label>
			<input type="text" class="hidden" value="<?php if(get_option('mommaincontrol_themetakeover') == 1){ ?>0<?php }else{ ?>1 <?php } ?>" name="themetakeover" />
			<input type="submit" id="mom_themetakeover_mode_submit" name="mom_themetakeover_mode_submit" value="Submit" class="hidden" />
		</form>
		<p><i class="fa fa-info">&mdash;</i> This module will attempt take over certain functionalities 
		of your current them and add additional functionality that wasn't (previously) there.</p>
		<p><i class="fa fa-info">&mdash;</i> Max Comment Length should be set to 0 (or blank) if you wish to use the default limit (which is none, as far as I know). 
		You should also be aware that when imposing limits on comments, <strong>all</strong> formatting and tags <strong>will</strong> be stripped from the 
		comment before it is saved.</p>
		<p><i class="fa fa-info">&mdash;</i> Fitvid .class accepts a container class that your media embeds are wrapped 
		in to apply the Fitvids JS functionality to.</p>
		<p><i class="fa fa-info">&mdash;</i>Post content .div, title .element, and Toggle text need to be set in order 
		to implement automatic lists for pages and posts that are extremely long and have sections denoted by 
		title elements (like h1).</p>
	<?php }
}