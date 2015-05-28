=== My Optional Modules ===
Contributors: boyevul
Tags: meta, og, twitter, facebook, google, random, description, title, 404, comments, version, pingbacks, author, date, archives, disable, horizontal, galleries, font awesome, share, RSS, DNSBL, ajax, garbage, removal, trash, footer, lazy load, exclude, remove, hide, front page, search results, authors, categories, tags, post formats, read more, single post, miniloop, attachment, media, embedder, oEmbed
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 10.0.5

An assortment of functions to enhance WordPress.

== Description ==
MOM features an assortment of functions designed to add (or extend) functionality within WordPress.

= Trash Removal =
*	Optimize the WordPress database
*	Clean up reivisions and auto-drafts
*	Clean up unapproved comments, spam comments, and comments belonging to trashed posts
*	Clean up tags and categories with no posts associated with them
*	Clean up drafts

= Disable Components =
*	Disable comments site-wide
*	Remove superfluous code
*	Disable Pingbacks
*	Disable author archives on single author installations
*	Disable date archives

= Enable Components =
*	OG:tags and Twitter Card integration
*	Horizontal scrolling galleries
*	Font Awesome
*	Scriptless social share links
*	Links back to your site on all RSS items
*	Redirect 404s to the homepage

= Comment Form Components =
*	DNS Blacklist lookup for potential commenters
*	Hidden spam field to thwart bots

= Extra Features =
*	oEmbed featured images
*	Full-width feature images
*	Move Javascripts to the footer
*	Lazyload for images in posts
*	Remove the currently viewed post from the default 'Recent Posts' widget
*	Exclude posts from almost anywhere
*	Make the front page a post
*	Related posts by meta key
*	Google Analytics and Site Verification integration
*	Style previous and next links with a custom .class
*	Replace 'read more...' on excerpts
*	Enable a keyword for random posts
*	Set a selection of random site titles and descriptions

= Exclude Posts =
*	Exclude posts based on author, category, tag, or post format
*	Exclude them from feed, home, archives, day of the week, or user level

== Installation ==
= 3-step installation =
1.	Upload /my-optional-modules/ to your plguins folder.
2.	Navigate to your plugins menu in your Wordpress admin.
3.	Activate it, and navigate to Dashboard->Settings->My Optional Modules for configuration.

= 3-step uninstallation =
1.	Navigate to Dashboard->Settings->My Optional Modules.
2.	Click on Uninstall.
3.	Confirm uninstall.

== Screenshots ==
1.	A horizontal gallery in a post.
2.	Share icons displayed at the top of the post content.

== Changelog ==
= 10.0.5 =
*	*Release Date - *
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