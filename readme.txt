=== My Optional Modules ===
Contributors: boyevul
Tags: reddit, meta, og, twitter, facebook, google, description, title, 404, comments, version, pingbacks, author, date, archives, disable, horizontal, galleries, font awesome, share, RSS, DNSBL, garbage, removal, trash, footer, exclude, remove, hide, front page, search results, authors, categories, tags, single post, miniloop, attachment, media, embedder, oEmbed
Requires at least: 4.1
Tested up to: 4.3.2
Stable tag: 11.1.2

An assortment of functions to enhance WordPress.

== Description ==
MOM features an assortment of functions designed to add (or extend) functionality within WordPress.

= One-click optimizations... =
*	Optimize the WordPress database
*	Remove revisions and autodrafts
*	Remove unapproved / trashed / spam comments
*	Remove orphaned tags and categories
*	Remove drafts

= (Optionally) disable... =
*	all comments, sitewide
*	XHTML generator, CSS / JS ids, feed links, RSD, WLW manifest, adjacent post links, etc.
*	Pingbacks
*	Author / date-based archives

= (Optionally) enable... =
*	OG:tag / Twitter card integration
*	Horizontal [gallery]
*	Font Awesome
*	Scriptless social share links
*	Link back to your site on all RSS items
*	Redirect (all) 404s to the homepage

= Comment Form Components =
*	DNS Blacklist integration with customizable database list
*	Hidden spam fields to aid in protection from bots

= (Optional) extra features =
*	Javascript(s) to the footer
*	Alter the behavior of the recent posts widget
*	Set the homepage as a post
*	enable Disqus for comments
*	Google Analytics/Verification / Alexa Verification / Bing Validation
*	Random post URL 

= Exclude Posts =
*	Exclude posts based on author, category, tag, or post format
*	Exclude them from feed, home, archives, day of the week, or user level

== Installation ==
= 3-step installation =
1.	Upload /my-optional-modules/ to your plguins folder.
2.	Navigate to your plugins menu in your Wordpress admin.
3.	Activate it, and navigate to Dashboard->Settings->My Optional Modules for configuration.

= Settings =
All settings on the admin page ( Dashboard->Settings->My Optional Modules ) are labelled appropriately, 
and contain relevant information as to what they do. When in doubt, read.

= 3-step uninstallation =
1.	Navigate to Dashboard->Settings->My Optional Modules.
2.	Click on Uninstall.
3.	Confirm uninstall.

== Shortcodes ==
= [mom_miniloop] =
Allows you embed a miniature loop of posts based on several customizable parameters.

1. `thumbs` :: show thumbnails :: 1(yes) 0(no) :: default: 1
1. `downsize` :: downsize thumbnail image quality :: 1(yes) 0(no) :: default: 1
1. `show_link` :: display link text :: 1(yes) 0(no) :: default: 1
1. `amount` :: how many posts to display :: default: 4
1. `offset` :: offset loop by x amount of posts :: default: 0
1. `paging` :: page the results? :: 1(yes) 0(no) :: default: 0
1. `year` :: define a year for the posts to be drawn from :: current:123 defined:2014,2013,2012... :: default: none
1. `month` :: define a month for the posts to be drawn from :: current:123 define:1,2,3,4... :: default: none
1. `day` :: define a day for the posts to be drawn from :: current:123 define:1,2,3,4... :: default: none
1. `exclude` :: (comma separated) list of post IDs to exclude :: default: none
1. `link_content` :: alpha-numeric value for the post title :: default: none (defaults to post title)
1. `category` :: (comma separated) list of numerical ID(s) or category name(s) to draw posts from (do not mix IDs and names) :: default: none
1. `key` :: posts with THIS meta key VALUE :: default: none
1. `meta` :: posts with THIS meta KEY :: default: none
1. `cache_results` :: cache the results of this loop :: true(yes) false(no) :: default: false
1. `style` :: define the style to use for the loop :: columns,slider,tiled,list,blurbs :: default: tiled
1. `orderby` :: order the posts by... :: ID,author,title,name,type,date,modified,parent,rand,none :: default: post_date
1. `order` :: order the posts in... :: DESC(descending order) or ASC(ascending) :: default: DESC
1. `post_status` :: posts with THIS post status :: publish,pending,draft,auto-draft,future,private,inherit,trash,any :: default: publish

= [mom_embed url='URL'] =
Embeds content from the following websites: Animoto, AShemaleTube, Blip, CollegeHumor, DailyMotion, DeviantArt,EmbedArticles, Flickr, 
FunnyOrDie, gist.github, Gyfcat, Hulu, ign, Imgur, Instagram, iSnare, Issuu, 
Kickstarter, Liveleak, Meetup, Mixcloud, Photobucket, PollDaddy, Pornhub, Redtube, 
Rdio, Revision3, Scribd, SlideShare, SmugMug, SoundCloud, Spotify, TED, Tumblr, 
Vidme, Vimeo, Vine, WordPress.tv, Youtube

You can set size='small/medium' to affect the size of the embed (in some rare cases).

= [mom_hidden]CONTENT[/mom_hidden] =
Allows for content to be hidden from users who are not logged in, or for content to be hidden 
from single_post views (but visible everywhere else).

Example: [mom_hidden logged='1/0' single='1/0']CONTENT[/mom_hidden] where 1 is true and 0 is false.

= [mom_charts] =
Allows for the creation of simple charts graphing information.

Example: [mom_charts type='bar' content='item description 1:5::item description 2:10' total_possible='10' overall='1']

Each item is followed by a numerical value, which is then followed by a separator. In this example, 
we have ITEM(1):VALUE(2)::ITEM(2):VALUE(2). Item descriptions should not have numbers, and numerical 
values should be numerical only. Total possible is the total amount possible for any given numerical value,
while overall determines if the overall score is to be displayed.

= [mom_categories] =
Creates a display column(s) of all parent categories, with links, and descriptions of each.

= [mom_reddit] =
Embed a subreddit.

1. `sub` :: the sub you wish to embed :: default: none
1. `search` :: keyword to search for :: combine with `sub` to search within that sub only :: default: none
1. `sort` :: combine with `search` to sort results :: top,relevance,new,comments,relevance2 :: default: relevance
1. `sticky` :: include sticky posts :: 1(yes) 0(no) :: default: 1
1. `score` :: exclude posts below a certain score :: default: 1
1. `nsfw` :: show posts that are marked as NSFW :: 1(yes) 0(no) :: default: 1
1. `type` :: which type of posts to show :: all, self, or links :: default: all
1. `amount` :: how many results to return :: default: 25
1. `header` :: display link back to sub on reddit :: 1(yes) 0(no) :: default: 1
1. `credit` :: display powered by text :: 1(yes) 0(no) :: default: 1
1. `from` :: determine when to draw posts from :: hour,day,week,month,year,all :: default: all

`sub` examples: sub, sub/new, sub/rising, sub/controversial, sub/top.

Example: [mom_reddit sub='all' search='' sort='relevance' sticky=1 score=0 nsfw=1 type=all amount=25 header=1 credit=1 from='all']

== Screenshots ==
1.	A horizontal gallery in a post.
2.	Share icons displayed at the top of the post content.

== Changelog ==
= 11.1 / 11.1.1 / 11.1.2 = 
*	*Release Date - 11th, October, 2015*
*	**Additional parameters can be set for [mom_reddit]**
*	[mom_reddit] now uses .json instead of .rss (and just works better)

= 11 =
*	*Release Date - 10th, October, 2015*
*	Admin interface *should be* easier to navigate

= 10.4 =
* 	*Release Date - 9th, October, 2015*
*	Minor change to how exclude posts handles dated exclusion parameters
*	Set homepage as post skips sticky post when front page is set to latest post
*	[mom_miniloop] information added to readme
*	[mom_miniloop] shortcode parameter able to be customized
*	[mom_miniloop] bugfixes

= 10.3 =
*	*Release Date - 8th, October, 2015*
*	Specify your own list of DNSBL to use with the DNSBL comment setting
*	When posts are hidden based on user levels, the comment form is disabled for those users as well
*	myoptionalmodules10.css renamed to simply css.css

= 10.2 =
*	*Release Date - 5th, October, 2015*
*	fixed an error when excluding posts based on user levels

= 10.1.9 =
*   *Release Date - 28th, September, 2015*
*	Post title for share icons use htmlentities for cases that involve titles that would break html output
*	Clean up globals
*	Allow for .class application to current post link in recent posts widget instead of removing link altogether
*	Lazy Load was removed in a previous version, although the option to enable/disable it was left behind.

= 10.1.8 =
*	*Release Date - 25th, September, 2015*
*	For reddit thread comment display, do not show [deleted] comments.
*	Ability to disable horizontal gallery script.

= 10.1.7 =
*	*Release Date - 14th, September, 2015*
*	(added) [mom_reddit] for embedding subreddit feeds
*	Remove background color from share links for better theme integration

= 10.1.3 =
*	*Release Date - 7th, September, 2015*
*	(added) [mom_categories] shortcode (parent category display)
*	[mom_embed] imgur album/gallery display code update to current (official) embed code
*	Customize shortcode [code] (some restrictions may apply, with regards to words WordPress uses internally)

= 10.1.0.2 =
*	*Release Date - 28th, August, 2015*
*	(removed) oEmbed featured images
*	Only include certain necessary files for functionality when functionality is specifically turned on in settings
*	Miniloops will now ignore sticky posts

= 10.1.0.1 =
*	*Release Date - 26th, August, 2015*
*	*Most* items on settings page now describe what they do.

= 10.1.0.0 =
*	*Release Date - 25th, August, 2015*
*	Blank Comments Template restored to original version

= 10.0.9.8 / 10.0.9.9 =
*	*Release Date - 24th, August, 2015*
*	Removed post formats from the plugins (better suited to be enabled on a theme level)
*	*Post formats being implemented via this plugin was also known to cause some minor*
*	*issues with some themes and the way that they displayed post content*
*	The following update corrects *guideline violations* in this WordPress plugin
*	img.bi embedding removed (not GPL (creative commons), disallowed by WP)
*	cdnjs.cloudflare.com calls to jquery, and jquery-migrate removed from *unnecessary code* (offloading js, disallowed by WP)
*	lazyload now included locally (instead of from cdnjs.cloudflare.com)

= 10.0.9.7 =
*	*Release Date - 19, August, 2015*
*	Favicon replaced by Site Icon in WordPress Customizer

= 10.0.9.6 =
*	*Release Date - 17th, August, 2015*
*	Shortcode information added to readme
*	Unused/undocumented/ill formed shortcodes removed

= 10.0.9.5 = 
*	*Release Date - 14th, August, 2015*
*	ign.com added to [mom_embed]
*	DNSBL behavior changed to *on comment submission*

= 10.0.9.4 =
*	*Release Date - 1st, August, 2015*
*	Removed modules were either found to be (ultimately) useless
*	or better handled on the theme level.
*	(removed) Ajax Comment Form
*	(removed) Previous link class / Next link class
*	(removed) Random descriptions / titles
*	(removed) Full-width feature images
*	(removed) Read more... value
*	(changed) Admin Settings Page CSS

= 10.0.9.3 =
*	*Release Date - 31st, July, 2015*
*	jQuery version bump 2.1.4 -> 3.0.0-alpha1
*	Font Awesome version bump 4.4
*	Horizontal Galleries updated to include caption with on-click image event

= 10.0.9.2 =
*	*Release Date - 16th, July, 2015*
*	Set whether analytics shows only on single posts or everywhere

= 10.0.9 / 10.0.9.1 =
*	*Release Date - 13th, July, 2015*
*	Container name for fitvids in script fixed
*	Do include analytics code if user is admin

= 10.0.8 =
*	*Release Date - 9th, July, 2015*
*	img.bi and youtube embeds will determine which embed to use based on whether or not the plugin script is being included

= 10.0.7 =
*	*Release Date - 2nd, July, 2015*
*	img.bi, deviantart, redtube, and vid.me added to [mom_embed]

= 10.0.6 =
*	*Release Date - 14th, June, 2015*
*	Insert Disqus Universal Code
*   Ability to disable the My Optional Modules script.js load
*	Theme:Miniloop fix (display)
*   Excluding posts from logged out visitors not working on single post view, but error resolved regarding redeclaration

= 10.0.5 =
*	*Release Date - 28th, May, 2015*
*   Lazyload Font Awesome CSS
*   Bing and Alexa site verification added to 'Theme'
*   initial values 'null' for some options (instead of '0') (bugfix)

= 10.0.4 =
*	*Release Date - 3rd, May, 2015*
*	jquery version bump from 2.1.3 to 2.1.4 for CDN enqueued jquery
*	fitvids for media embeds, with changes to media embedding to enhance quality of return

= 10.0.3 =
*   *Release Date - 27th, April, 2015*
*   Further fixing for exclude posts

= 10.0.2 =
*	*Release Date - 25th, April, 2015*
*	Fix for exclusion module no longer excluding posts

= 10.0.1 =
*	*Release Date - 13th, April, 2015*
*	Exclusion hiding for single post content was not working correctly

= 10 =
*	*Release Date - 10th, April, 2015*
*	Admin style changed

= 9.1.8 =
*	*Release Date - 6th, April, 2015*
*	Favicon URL field added
*	mom_charts shortcode added
*	Horizontal galleries images loaded below on-click
*	Multiple embeds from a single mom_embed
*	gists added to mom_embed

= 9.1.7 =
*	*Release Date - 2nd, April, 2015*
*	[mom_catalog] shortcode added

= 9.1.6 =
*	*Release Date - 27th, March, 2015*
*	.media-embed wrapper class for media_embeds
*	mom_embed for Youtube utilizes click-to-play thumbnail with noscript object embed fallback
*	Change the 'Share via:' text ( or output nothing )
*	__construct utilized for classes

= 9.1.4 / 9.1.5 =
*	*Release Date - 22nd, March, 2015*
*	Several instances of return $content have been altered to work with [shortcodes] properly, under certain circumstances
*	Automatic 'Miniloop' bugfix ( wrong $variable )
*	$wpdb->prepare used for 'Trash Removal'
*	'Google Site Verification' added for Google Webmaster Tools
*	'noindex, nofollow' changed to 'noindex, noarchive' for 'Meta Tags' archives/search/404

= 9.1.3 =
*	*Release Date - 16th March, 2015*
*	Undefined variable 'myoptionalmodules_randompost'
*	In some instances, $values were being prematurely nulled

= 9.1.2 =
*	*Release Date - 15th March, 2015*
*	wp_load_alloptions() used in place of get_option()

= 9.1.1 / 9.1 / 9 =
*	*Release Date - 13th March, 2015*
*	'miniloop' meta/key fix
*	Fix for 'mom_embed' imgur albums