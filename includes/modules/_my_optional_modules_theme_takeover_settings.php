<?php 

/**
 *
 * Module->Takeover->Settings Page
 *
 * Settings page for the Takeover module
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
if( !defined( 'MyOptionalModules' ) ) {

	die();

}

if( current_user_can( 'manage_options' ) ) {

	function my_optional_modules_theme_takeover_module() {

		$MOM_themetakeover_topbar               = get_option( 'MOM_themetakeover_topbar' );
		$MOM_themetakeover_extend               = get_option( 'MOM_themetakeover_extend' );
		$MOM_themetakeover_topbar_color         = get_option( 'MOM_themetakeover_topbar_color' );
		$MOM_themetakeover_topbar_share         = get_option( 'MOM_themetakeover_topbar_share' );
		$MOM_themetakeover_backgroundimage      = get_option( 'MOM_themetakeover_backgroundimage' );
		$MOM_themetakeover_wowhead              = get_option( 'MOM_themetakeover_wowhead' );
		$MOM_themetakeover_horizontal_galleries = get_option( 'MOM_themetakeover_horizontal_galleries' );
		$MOM_themetakeover_ajaxcomments         = get_option( 'MOM_themetakeover_ajaxcomments' );
		$MOM_themetakeover_tiledfrontpage       = get_option( 'MOM_themetakeover_tiledfrontpage' );
		$MOM_themetakeover_commentlength        = get_option( 'MOM_themetakeover_commentlength' );
		$MOM_themetakeover_series_style         = get_option( 'MOM_themetakeover_series_style' );
		$showmepages                            = get_pages(); ?>
		
		<strong class="sectionTitle">Takeover Settings</strong>
		<form class="clear" method="post">
			<section class="clear">
				<label class="left" for="MOM_themetakeover_tiledfrontpage">Mini Loops</label>
				<select class="right" id="MOM_themetakeover_tiledfrontpage" name="MOM_themetakeover_tiledfrontpage">
					<option value="0" <?php selected($MOM_themetakeover_tiledfrontpage, 0);?> >No</option>
					<option value="1" <?php selected($MOM_themetakeover_tiledfrontpage, 1);?> >Yes</option>
				</select>				
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_series_title">Series title</label>
				<input class="right" id="MOM_themetakeover_series_title" name="MOM_themetakeover_series_title" value="<?php echo get_option( 'MOM_themetakeover_series_title' ); ?>" />
			</section>
			<section class="clear">
				<label class="left" for="MOM_themetakeover_series_key">Series key</label>
				<input class="right" id="MOM_themetakeover_series_key" name="MOM_themetakeover_series_key" value="<?php echo get_option( 'MOM_themetakeover_series_key' ); ?>" />
			</section>
			<br />
			<blockquote>
				<i class="fa fa-info">&mdash;</i> <em>MOM Series Widget</em> will group posts together sharing the same custom key values<br />
				&mdash; To group posts together, give each post the same custom key as defined in the above <em>Series Key</em><br />
				&mdash; You can separate them by then giving each unique values<br />
				&mdash;&mdash; A series on videos about cars? Give some posts a custom key of <em>videos</em> with the value <em>cars</em>.<br /><br />
				<i class="fa fa-info">&mdash;</i> <em>[mom_miniloop]</em> will output a mini loop posts based on:<br />
				<blockquote>
					Parameters you set: <br />
					&mdash; <strong>meta</strong> (grab posts with a particular meta key (NOT VALUE))<br />
					&mdash; <strong>key</strong> (grab posts with a particular meta key VALUE (not tied directly to any particular meta KEY)<br />
					&mdash;&mdash; combine <strong>meta</strong> and <strong>key</strong> to further specify particular post sets<br />
					&mdash;&mdash;&mdash; example: Grab all posts that are part of a series (meta key: series) called videos (meta key value: videos):<br />
					&mdash;&mdash;&mdash; [mom_miniloop meta="series" key="videos"]<br /><br />
					&mdash; <strong>paging</strong> (<em>1</em> to page results, <em>0</em> not to (default: 0) )<br />
					&mdash;&mdash; if paging is turned on, amount becomes how many posts to display per page<br />
					&mdash;&mdash;&mdash; <strong>paging does not currently work properly on single posts</strong><br />
					&mdash;&mdash;&mdash; <strong>advised usage of paging is for blog pages set as the front page</strong><br />
					&mdash; <strong>votes</strong> (<em>1</em> to display <i class="fa fa-arrow-up"></i>s, 0 to disable (default: 0))<br />
					&mdash; <strong>show_link</strong> (show links by default (default:1))<br />
					&mdash; <strong>link_content</strong> (text of the link (default: none (defaults to post title)))<br />
					&mdash; <strong>amount</strong> (how many posts to show (default: 4))<br />
					&mdash; <strong>downsize</strong> (<em>1</em>:downsize to thumbnail size, <em>0</em>:use original size image (default:1)) <br />
					&mdash; <strong>style</strong><br />
					&mdash;&mdash;(<em>columns</em> for a 2-column setup w/ thumbnails and post excerpts)<br />
					&mdash;&mdash;(<em>list</em> for an ordered list of posts.)<br />
					&mdash;&mdash;(<em>slider</em> for a horizontal layout inside of a scrollable div)<br />
					&mdash;&mdash;(<em>tiled</em> for a tiled gallery layout)<br />
					&mdash;&mdash;(default: <em>tiled</em>)<br />
					&mdash; <strong>offset</strong> (how many posts to skip ahead in the loop (default: 0))<br />
					&mdash; <strong>category</strong> (a numerical category id or name (or comma separated list)(default: none))<br />
					&mdash; <strong>orderby</strong> (order your posts by <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">a  particular value</a> (default: post_date))<br />
					&mdash; <strong>order</strong> (order the posts in <em>ASC</em> (ascending) or <em>DESC</em> (descending) order (default: DESC))<br />
					&mdash; <strong>post_status</strong> (show posts associated with certain <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Status_Parameters">statuses</a> (default: publish))<br />
					&mdash; Date Based Parameters:<br />
					&mdash;&mdash; <strong>year</strong> (a 4-digit year (default: none))<br />
					&mdash;&mdash; <strong>month</strong> (a single-double digit month (1-12)(default: none))<br />
					&mdash;&mdash; <strong>day</strong> (a single-double digit day (1-31)(default:none:))<br />
					&mdash; <strong>cache</strong> (whether or not to add loop to cache (true or false) (default:false))<br />
					&mdash; <strong>exclude_user</strong> (1 to use user exclusion rules set in Exclude module (default:0))
				</blockquote>
			</blockquote>
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