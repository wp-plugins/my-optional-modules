<?php 
/*
Plugin Name: My Optional Modules
Plugin URL: //iamnotu.com/my-optional-modules/
Description: Optional modules and additions for Wordpress.
Version: 9.1.2
Author: Matthew Trevino
Author URI: //iamnotu.com

LICENSE
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program;if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * MAIN PLUGIN FILE
 *
 * Initialize all functionality for this plugin
 */

$myoptionalmodules_plugin_version       = '9';

$myoptionalmodules_metatags                            = $myoptionalmodules_horizontalgalleries                = $myoptionalmodules_sharelinks = 
$myoptionalmodules_rsslinkbacks                        = $myoptionalmodules_404s                               = $myoptionalmodules_fontawesome = 
$myoptionalmodules_shareslinks_top                     = $myoptionalmodules_sharelinks_pages                   = $myoptionalmodules_sharelinks_reddit = 
$myoptionalmodules_sharelinks_google                   = $myoptionalmodules_sharelinks_twitter                 = $myoptionalmodules_sharelinks_facebook = 
$myoptionalmodules_sharelinks_email                    = $myoptionalmodules_dnsbl                              = $myoptionalmodules_ajaxcomments = 
$myoptionalmodules_commentspamfield                    = $myoptionalmodules_disablepingbacks                   = $myoptionalmodules_authorarchives = 
$myoptionalmodules_datearchives                        = $myoptionalmodules_disablecomments                    = $myoptionalmodules_dnsbl = 
$myoptionalmodules_removecode                          = $myoptionalmodules_featureimagewidth                  = $myoptionalmodules_javascripttofooter = 
$myoptionalmodules_exclude                             = $myoptionalmodules_nelio                              = $myoptionalmodules_recentpostswidget = 
$myoptionalmodules_google                              = $myoptionalmodules_frontpage                          = $myoptionalmodules_previouslinkclass = 
$myoptionalmodules_nextlinkclass                       = $myoptionalmodules_readmore                           = $myoptionalmodules_randompost = 
$myoptionalmodules_randomtitles                        = $myoptionalmodules_randomdescriptions                 = $myoptionalmodules_miniloopmeta = 
$myoptionalmodules_miniloopstyle                       = $myoptionalmodules_miniloopamount                     = $myoptionalmodules_exclude_categorieslevel0categories = 
$myoptionalmodules_exclude_categorieslevel1categories  = $myoptionalmodules_exclude_categorieslevel2categories = $myoptionalmodules_exclude_categorieslevel7categories = 
$myoptionalmodules_exclude_categoriesfront             = $myoptionalmodules_exclude_categoriestagarchives      = $myoptionalmodules_exclude_categoriessearchresults = 
$myoptionalmodules_exclude_categoriesrss               = $myoptionalmodules_exclude_tagsfront                  = $myoptionalmodules_exclude_tagsrss = 
$myoptionalmodules_exclude_tagscategoryarchives        = $myoptionalmodules_exclude_tagssearchresults          = $myoptionalmodules_exclude_postformatsfront = 
$myoptionalmodules_exclude_postformatscategoryarchives = $myoptionalmodules_exclude_postformatstagarchives     = $myoptionalmodules_exclude_postformatssearchresults = 
$myoptionalmodules_exclude_visitorpostformats          = $myoptionalmodules_exclude_postformatsrss             = $myoptionalmodules_exclude_usersrss = 
$myoptionalmodules_exclude_usersfront                  = $myoptionalmodules_exclude_userstagarchives           = $myoptionalmodules_exclude_userscategoryarchives = 
$myoptionalmodules_exclude_userssearchresults          = $myoptionalmodules_exclude_userslevel10users          = $myoptionalmodules_exclude_userslevel1users = 
$myoptionalmodules_exclude_userslevel2users            = $myoptionalmodules_exclude_userslevel7users           = $myoptionalmodules_exclude_tagslevel0tags = 
$myoptionalmodules_exclude_tagslevel1tags              = $myoptionalmodules_exclude_tagslevel2tags             = $myoptionalmodules_exclude_tagslevel7tags = 
$myoptionalmodules_exclude_tagstagssun                 = $myoptionalmodules_exclude_tagstagsmon                = $myoptionalmodules_exclude_tagstagstue = 
$myoptionalmodules_exclude_tagstagswed                 = $myoptionalmodules_exclude_tagstagsthu                = $myoptionalmodules_exclude_tagstagsfri = 
$myoptionalmodules_exclude_tagstagssat                 = $myoptionalmodules_exclude_categoriescategoriessun    = $myoptionalmodules_exclude_categoriescategoriesmon = 
$myoptionalmodules_exclude_categoriescategoriestue     = $myoptionalmodules_exclude_categoriescategorieswed    = $myoptionalmodules_exclude_categoriescategoriesthu = 
$myoptionalmodules_exclude_categoriescategoriesfri     = $myoptionalmodules_exclude_categoriescategoriessat    = $myoptionalmodules_exclude_usersuserssun = 
$myoptionalmodules_exclude_usersusersmon               = $myoptionalmodules_exclude_usersuserstue              = $myoptionalmodules_exclude_usersuserswed = 
$myoptionalmodules_exclude_usersusersthu               = $myoptionalmodules_exclude_usersusersfri              = $myoptionalmodules_exclude_usersuserssat =
null;

$myoptionalmodules_getallpluginoptions  = wp_load_alloptions();
foreach( $myoptionalmodules_getallpluginoptions as $name => $value ) {
	$value = sanitize_text_field ( $value );
	if( $name == 'myoptionalmodules_metatags' && $value == 1 ) $myoptionalmodules_metatags                       = 1;
	if( $name == 'myoptionalmodules_horizontalgalleries' && $value == 1 ) $myoptionalmodules_horizontalgalleries = 1;
	if( $name == 'myoptionalmodules_sharelinks' && $value == 1 ) $myoptionalmodules_sharelinks                   = 1;
	if( $name == 'myoptionalmodules_rsslinkbacks' && $value == 1 ) $myoptionalmodules_rsslinkbacks               = 1;
	if( $name == 'myoptionalmodules_404s' && $value == 1 ) $myoptionalmodules_404s                               = 1;
	if( $name == 'myoptionalmodules_fontawesome' && $value == 1 ) $myoptionalmodules_fontawesome                 = 1;
	if( $name == 'myoptionalmodules_shareslinks_top' && $value == 1 ) $myoptionalmodules_shareslinks_top         = 1;
	if( $name == 'myoptionalmodules_sharelinks_pages' && $value == 1 ) $myoptionalmodules_sharelinks_pages       = 1;
	if( $name == 'myoptionalmodules_sharelinks_reddit' && $value == 1 ) $myoptionalmodules_sharelinks_reddit     = 1;
	if( $name == 'myoptionalmodules_sharelinks_google' && $value == 1 ) $myoptionalmodules_sharelinks_google     = 1;
	if( $name == 'myoptionalmodules_sharelinks_twitter' && $value == 1 ) $myoptionalmodules_sharelinks_twitter   = 1;
	if( $name == 'myoptionalmodules_sharelinks_facebook' && $value == 1 ) $myoptionalmodules_sharelinks_facebook = 1;
	if( $name == 'myoptionalmodules_sharelinks_email' && $value == 1 ) $myoptionalmodules_sharelinks_email       = 1;
	if( $name == 'myoptionalmodules_dnsbl' && $value == 1 ) $myoptionalmodules_dnsbl                             = 1;
	if( $name == 'myoptionalmodules_ajaxcomments' && $value == 1 ) $myoptionalmodules_ajaxcomments               = 1;
	if( $name == 'myoptionalmodules_commentspamfield' && $value == 1 ) $myoptionalmodules_commentspamfield       = 1;
	if( $name == 'myoptionalmodules_disablepingbacks' && $value == 1 ) $myoptionalmodules_disablepingbacks       = 1;
	if( $name == 'myoptionalmodules_authorarchives' && $value == 1 ) $myoptionalmodules_authorarchives           = 1;
	if( $name == 'myoptionalmodules_datearchives' && $value == 1 ) $myoptionalmodules_datearchives               = 1;
	if( $name == 'myoptionalmodules_disablecomments' && $value == 1 ) $myoptionalmodules_disablecomments         = 1;
	if( $name == 'myoptionalmodules_dnsbl' && $value == 1 ) $myoptionalmodules_dnsbl                             = 1;
	if( $name == 'myoptionalmodules_removecode' && $value == 1 ) $myoptionalmodules_removecode                   = 1;
	if( $name == 'myoptionalmodules_featureimagewidth' && $value == 1 ) $myoptionalmodules_featureimagewidth     = 1;
	if( $name == 'myoptionalmodules_javascripttofooter' && $value == 1 ) $myoptionalmodules_javascripttofooter   = 1;
	if( $name == 'myoptionalmodules_exclude' && $value == 1 ) $myoptionalmodules_exclude                         = 1;
	if( $name == 'myoptionalmodules_nelio' && $value == 1 ) $myoptionalmodules_nelio                             = 1;
	if( $name == 'myoptionalmodules_recentpostswidget' && $value == 1 ) $myoptionalmodules_recentpostswidget     = 1;
	if( $name == 'myoptionalmodules_google' && $value ) $myoptionalmodules_google                                = $value;
	if( $name == 'myoptionalmodules_frontpage' && 'off' != $value ) $myoptionalmodules_frontpage                 = $value;
	if( $name == 'myoptionalmodules_previouslinkclass' && $value ) $myoptionalmodules_previouslinkclass          = $value;
	if( $name == 'myoptionalmodules_nextlinkclass' && $value ) $myoptionalmodules_nextlinkclass                  = $value;
	if( $name == 'myoptionalmodules_readmore' && $value ) $myoptionalmodules_readmore                            = $value;
	if( $name == 'myoptionalmodules_randompost' && $value ) $myoptionalmodules_randompost                        = esc_html ( $value );
	if( $name == 'myoptionalmodules_randomtitles' && $value ) $myoptionalmodules_randomtitles                    = $value;
	if( $name == 'myoptionalmodules_randomdescriptions' && $value ) $myoptionalmodules_randomdescriptions        = $value;
	if( $name == 'myoptionalmodules_miniloopmeta' && $value ) $myoptionalmodules_miniloopmeta                    = $value;
	if( $name == 'myoptionalmodules_miniloopstyle' && $value ) $myoptionalmodules_miniloopstyle                  = strtolower( $value );
	if( $name == 'myoptionalmodules_miniloopamount' && $value ) $myoptionalmodules_miniloopamount                = intval( $value );
	if($name == 'myoptionalmodules_exclude_categorieslevel0categories' && $value ) $myoptionalmodules_exclude_categorieslevel0categories   = $value;
	if($name == 'myoptionalmodules_exclude_categorieslevel1categories' && $value ) $myoptionalmodules_exclude_categorieslevel1categories   = $value;
	if($name == 'myoptionalmodules_exclude_categorieslevel2categories' && $value ) $myoptionalmodules_exclude_categorieslevel2categories   = $value;
	if($name == 'myoptionalmodules_exclude_categorieslevel7categories' && $value ) $myoptionalmodules_exclude_categorieslevel7categories   = $value;
	if($name == 'myoptionalmodules_exclude_categoriesfront' && $value ) $myoptionalmodules_exclude_categoriesfront                         = $value;
	if($name == 'myoptionalmodules_exclude_categoriestagarchives' && $value ) $myoptionalmodules_exclude_categoriestagarchives             = $value;
	if($name == 'myoptionalmodules_exclude_categoriessearchresults' && $value ) $myoptionalmodules_exclude_categoriessearchresults         = $value;
	if($name == 'myoptionalmodules_exclude_categoriesrss' && $value ) $myoptionalmodules_exclude_categoriesrss                             = $value;
	if($name == 'myoptionalmodules_exclude_tagsfront' && $value ) $myoptionalmodules_exclude_tagsfront                                     = $value;
	if($name == 'myoptionalmodules_exclude_tagsrss' && $value ) $myoptionalmodules_exclude_tagsrss                                         = $value;
	if($name == 'myoptionalmodules_exclude_tagscategoryarchives' && $value ) $myoptionalmodules_exclude_tagscategoryarchives               = $value;
	if($name == 'myoptionalmodules_exclude_tagssearchresults' && $value ) $myoptionalmodules_exclude_tagssearchresults                     = $value;
	if($name == 'myoptionalmodules_exclude_postformatsfront' && $value ) $myoptionalmodules_exclude_postformatsfront                       = $value;
	if($name == 'myoptionalmodules_exclude_postformatscategoryarchives' && $value ) $myoptionalmodules_exclude_postformatscategoryarchives = $value;
	if($name == 'myoptionalmodules_exclude_postformatstagarchives' && $value ) $myoptionalmodules_exclude_postformatstagarchives           = $value;
	if($name == 'myoptionalmodules_exclude_postformatssearchresults' && $value ) $myoptionalmodules_exclude_postformatssearchresults       = $value;
	if($name == 'myoptionalmodules_exclude_visitorpostformats' && $value ) $myoptionalmodules_exclude_visitorpostformats                   = $value;
	if($name == 'myoptionalmodules_exclude_postformatsrss' && $value ) $myoptionalmodules_exclude_postformatsrss                           = $value;
	if($name == 'myoptionalmodules_exclude_usersrss' && $value ) $myoptionalmodules_exclude_usersrss                                       = $value;
	if($name == 'myoptionalmodules_exclude_usersfront' && $value ) $myoptionalmodules_exclude_usersfront                                   = $value;
	if($name == 'myoptionalmodules_exclude_userstagarchives' && $value ) $myoptionalmodules_exclude_userstagarchives                       = $value;
	if($name == 'myoptionalmodules_exclude_userscategoryarchives' && $value ) $myoptionalmodules_exclude_userscategoryarchives             = $value;
	if($name == 'myoptionalmodules_exclude_userssearchresults' && $value ) $myoptionalmodules_exclude_userssearchresults                   = $value;
	if($name == 'myoptionalmodules_exclude_userslevel10users' && $value ) $myoptionalmodules_exclude_userslevel10users                     = $value;
	if($name == 'myoptionalmodules_exclude_userslevel1users' && $value ) $myoptionalmodules_exclude_userslevel1users                       = $value;
	if($name == 'myoptionalmodules_exclude_userslevel2users' && $value ) $myoptionalmodules_exclude_userslevel2users                       = $value;
	if($name == 'myoptionalmodules_exclude_userslevel7users' && $value ) $myoptionalmodules_exclude_userslevel7users                       = $value;
	if($name == 'myoptionalmodules_exclude_tagslevel0tags' && $value ) $myoptionalmodules_exclude_tagslevel0tags                           = $value;
	if($name == 'myoptionalmodules_exclude_tagslevel1tags' && $value ) $myoptionalmodules_exclude_tagslevel1tags                           = $value;
	if($name == 'myoptionalmodules_exclude_tagslevel2tags' && $value ) $myoptionalmodules_exclude_tagslevel2tags                           = $value;
	if($name == 'myoptionalmodules_exclude_tagslevel7tags' && $value ) $myoptionalmodules_exclude_tagslevel7tags                           = $value;
	if($name == 'myoptionalmodules_exclude_tagstagssun' && $value ) $myoptionalmodules_exclude_tagstagssun                                 = $value;
	if($name == 'myoptionalmodules_exclude_tagstagsmon' && $value ) $myoptionalmodules_exclude_tagstagsmon                                 = $value;
	if($name == 'myoptionalmodules_exclude_tagstagstue' && $value ) $myoptionalmodules_exclude_tagstagstue                                 = $value;
	if($name == 'myoptionalmodules_exclude_tagstagswed' && $value ) $myoptionalmodules_exclude_tagstagswed                                 = $value;
	if($name == 'myoptionalmodules_exclude_tagstagsthu' && $value ) $myoptionalmodules_exclude_tagstagsthu                                 = $value;
	if($name == 'myoptionalmodules_exclude_tagstagsfri' && $value ) $myoptionalmodules_exclude_tagstagsfri                                 = $value;
	if($name == 'myoptionalmodules_exclude_tagstagssat' && $value ) $myoptionalmodules_exclude_tagstagssat                                 = $value;
	if($name == 'myoptionalmodules_exclude_categoriescategoriessun' && $value ) $myoptionalmodules_exclude_categoriescategoriessun         = $value;
	if($name == 'myoptionalmodules_exclude_categoriescategoriesmon' && $value ) $myoptionalmodules_exclude_categoriescategoriesmon         = $value;
	if($name == 'myoptionalmodules_exclude_categoriescategoriestue' && $value ) $myoptionalmodules_exclude_categoriescategoriestue         = $value;
	if($name == 'myoptionalmodules_exclude_categoriescategorieswed' && $value ) $myoptionalmodules_exclude_categoriescategorieswed         = $value;
	if($name == 'myoptionalmodules_exclude_categoriescategoriesthu' && $value ) $myoptionalmodules_exclude_categoriescategoriesthu         = $value;
	if($name == 'myoptionalmodules_exclude_categoriescategoriesfri' && $value ) $myoptionalmodules_exclude_categoriescategoriesfri         = $value;
	if($name == 'myoptionalmodules_exclude_categoriescategoriessat' && $value ) $myoptionalmodules_exclude_categoriescategoriessat         = $value;
	if($name == 'myoptionalmodules_exclude_usersuserssun' && $value ) $myoptionalmodules_exclude_usersuserssun                             = $value;
	if($name == 'myoptionalmodules_exclude_usersusersmon' && $value ) $myoptionalmodules_exclude_usersusersmon                             = $value;
	if($name == 'myoptionalmodules_exclude_usersuserstue' && $value ) $myoptionalmodules_exclude_usersuserstue                             = $value;
	if($name == 'myoptionalmodules_exclude_usersuserswed' && $value ) $myoptionalmodules_exclude_usersuserswed                             = $value;
	if($name == 'myoptionalmodules_exclude_usersusersthu' && $value ) $myoptionalmodules_exclude_usersusersthu                             = $value;
	if($name == 'myoptionalmodules_exclude_usersusersfri' && $value ) $myoptionalmodules_exclude_usersusersfri                             = $value;
	if($name == 'myoptionalmodules_exclude_usersuserssat' && $value ) $myoptionalmodules_exclude_usersuserssat                             = $value;
}

define ( 'MyOptionalModules', true );
require_once( ABSPATH . 'wp-includes/pluggable.php' );

include( '_versions.php' );
include( 'function.category-ids.php' );
include( 'function.exclude-categories.php' );
include( 'function.recent-posts.php' );
include( 'function.featured-images.php' );
include( 'function.read-more.php' );
include( 'class.mom-mediaembed.php' ); 
include( 'class.myoptionalmodules.php' );
include( 'class.myoptionalmodules-enable.php' );
include( 'class.myoptionalmodules-disable.php' );
include( 'class.myoptionalmodules-commentform.php' );
include( 'class.myoptionalmodules-extras.php' );
include( 'class.myoptionalmodules-misc.php' );
include( 'class.shortcode.myoptionalmodules-attachmentloop.php' );
include( 'class.shortcode.myoptionalmodules-mediaembed.php' );
include( 'class.shortcode.myoptionalmodules-hidden.php' );
include( 'function.shortcode.myoptionalmodules-miniloop.php' );
include( '_initialize.php' );

if( current_user_can( 'edit_dashboard' ) && is_admin() ){
	class myoptionalmodules_admin_css {

		function actions() {

			add_action ( 'admin_enqueue_scripts', array( $this, 'stylesheets' ) );

		}

		function stylesheets ( $hook ) {

			global $myoptionalmodules_plugin_version;

			if( 'settings_page_mommaincontrol' != $hook ) return;

			$font_awesome_css = str_replace ( array ( 'https:', 'http:' ), '', esc_url ( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/fontawesome/css/font-awesome.min.css' ) );
			$mom_admin_css    = str_replace ( array ( 'https:', 'http:' ), '', esc_url ( plugins_url() . '/' . plugin_basename( dirname ( __FILE__ ) ) . '/includes/adminstyle/css' . $myoptionalmodules_plugin_version . '.css' ) );
			wp_enqueue_style ( 'mom_admin_css' , $mom_admin_css );
			wp_enqueue_style ( 'font_awesome' ,  $font_awesome_css );

		}

	}

	$myoptionalmodules_admin_css = new myoptionalmodules_admin_css();
	$myoptionalmodules_admin_css->actions();

	include( 'admin.font-awesome-post-edit.php' );
	include( 'admin.settings-page-content.php' );
}

$myoptionalmodules_metatags                            = $myoptionalmodules_horizontalgalleries                = $myoptionalmodules_sharelinks = 
$myoptionalmodules_rsslinkbacks                        = $myoptionalmodules_404s                               = $myoptionalmodules_fontawesome = 
$myoptionalmodules_shareslinks_top                     = $myoptionalmodules_sharelinks_pages                   = $myoptionalmodules_sharelinks_reddit = 
$myoptionalmodules_sharelinks_google                   = $myoptionalmodules_sharelinks_twitter                 = $myoptionalmodules_sharelinks_facebook = 
$myoptionalmodules_sharelinks_email                    = $myoptionalmodules_dnsbl                              = $myoptionalmodules_ajaxcomments = 
$myoptionalmodules_commentspamfield                    = $myoptionalmodules_disablepingbacks                   = $myoptionalmodules_authorarchives = 
$myoptionalmodules_datearchives                        = $myoptionalmodules_disablecomments                    = $myoptionalmodules_dnsbl = 
$myoptionalmodules_removecode                          = $myoptionalmodules_featureimagewidth                  = $myoptionalmodules_javascripttofooter = 
$myoptionalmodules_exclude                             = $myoptionalmodules_nelio                              = $myoptionalmodules_recentpostswidget = 
$myoptionalmodules_google                              = $myoptionalmodules_frontpage                          = $myoptionalmodules_previouslinkclass = 
$myoptionalmodules_nextlinkclass                       = $myoptionalmodules_readmore                           = $myoptionalmodules_randompost = 
$myoptionalmodules_randomtitles                        = $myoptionalmodules_randomdescriptions                 = $myoptionalmodules_miniloopmeta = 
$myoptionalmodules_miniloopstyle                       = $myoptionalmodules_miniloopamount                     = $myoptionalmodules_exclude_categorieslevel0categories = 
$myoptionalmodules_exclude_categorieslevel1categories  = $myoptionalmodules_exclude_categorieslevel2categories = $myoptionalmodules_exclude_categorieslevel7categories = 
$myoptionalmodules_exclude_categoriesfront             = $myoptionalmodules_exclude_categoriestagarchives      = $myoptionalmodules_exclude_categoriessearchresults = 
$myoptionalmodules_exclude_categoriesrss               = $myoptionalmodules_exclude_tagsfront                  = $myoptionalmodules_exclude_tagsrss = 
$myoptionalmodules_exclude_tagscategoryarchives        = $myoptionalmodules_exclude_tagssearchresults          = $myoptionalmodules_exclude_postformatsfront = 
$myoptionalmodules_exclude_postformatscategoryarchives = $myoptionalmodules_exclude_postformatstagarchives     = $myoptionalmodules_exclude_postformatssearchresults = 
$myoptionalmodules_exclude_visitorpostformats          = $myoptionalmodules_exclude_postformatsrss             = $myoptionalmodules_exclude_usersrss = 
$myoptionalmodules_exclude_usersfront                  = $myoptionalmodules_exclude_userstagarchives           = $myoptionalmodules_exclude_userscategoryarchives = 
$myoptionalmodules_exclude_userssearchresults          = $myoptionalmodules_exclude_userslevel10users          = $myoptionalmodules_exclude_userslevel1users = 
$myoptionalmodules_exclude_userslevel2users            = $myoptionalmodules_exclude_userslevel7users           = $myoptionalmodules_exclude_tagslevel0tags = 
$myoptionalmodules_exclude_tagslevel1tags              = $myoptionalmodules_exclude_tagslevel2tags             = $myoptionalmodules_exclude_tagslevel7tags = 
$myoptionalmodules_exclude_tagstagssun                 = $myoptionalmodules_exclude_tagstagsmon                = $myoptionalmodules_exclude_tagstagstue = 
$myoptionalmodules_exclude_tagstagswed                 = $myoptionalmodules_exclude_tagstagsthu                = $myoptionalmodules_exclude_tagstagsfri = 
$myoptionalmodules_exclude_tagstagssat                 = $myoptionalmodules_exclude_categoriescategoriessun    = $myoptionalmodules_exclude_categoriescategoriesmon = 
$myoptionalmodules_exclude_categoriescategoriestue     = $myoptionalmodules_exclude_categoriescategorieswed    = $myoptionalmodules_exclude_categoriescategoriesthu = 
$myoptionalmodules_exclude_categoriescategoriesfri     = $myoptionalmodules_exclude_categoriescategoriessat    = $myoptionalmodules_exclude_usersuserssun = 
$myoptionalmodules_exclude_usersusersmon               = $myoptionalmodules_exclude_usersuserstue              = $myoptionalmodules_exclude_usersuserswed = 
$myoptionalmodules_exclude_usersusersthu               = $myoptionalmodules_exclude_usersusersfri              = $myoptionalmodules_exclude_usersuserssat =
null;