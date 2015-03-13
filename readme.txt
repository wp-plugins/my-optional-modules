=== My Optional Modules ===
Contributors: boyevul
Tags: meta, og, twitter, facebook, google, random, description, title, 404, comments, version, pingbacks, author, date, archives, disable, horizontal, galleries, font awesome, share, RSS, DNSBL, ajax, garbage, removal, trash, footer, lazy load, exclude, remove, hide, front page, search results, authors, categories, tags, post formats, read more, single post, miniloop, attachment, media, embedder, oEmbed
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 8-RC-1.5.6

An assortment of functions to enhance WordPress.

== Description ==
MOM features an assortment of functions designed to add (or extend) functionality within WordPress. ( We're also available 
on [Github](https://github.com/onebillion/mom). )

= Disable WordPress components =
*	Comments
*	Version number in source
*	Pingbacks to you
*	Author based archives, if there is only one author
*	Date based archives

= Enable WordPress extras =
*	Horizontal slider galleries
*	Font Awesome
*	Scriptless social sharing links
*	RSS link backs to your site
*	DNSBL for the comments form
*   Antibot hidden field for comment form
*	Ajax for the comments form
*   404 Redirects to the Front Page
*	One click database garbage removal
*	Move Javascript to the footer
*	Enable Lazy Load for images in posts
*   OG:tag integration w/ optional Twitter card tags

= Exclude posts from 'almost' anywhere =
*	Exclude authors, categories, tags, and post formats
*	Exclude them from RSS, front page, archives view, or search results
*	Exclude them based on what day it is
*	Exclude them based on user level (or if the visitor isn't logged in)

= Enable theme extras =
*   Force default post thumbnails to take up 100% of their container
*	Turn your front page into a single post
&	Add a CSS class to next and previous links for styling purposes
*	Enable ?random post functionality
*	Change the value of "read more..." for excerpts
*   Utilize a list of random site titles/descriptions
*   Easily integrate Google Analytics

= Remove Unnecessary Code = 
*	Hide version information
*	Remove id information from enqueued stylesheets
*	Remove identifying elements from the head
*	Enqueue jquery versions from CDN (and not locally)

= Take advantage of shortcodes =
*   A media embedder with oEmbed fallback
*	An attachments loop to show off images (that link to their respective posts)
*	A highly customizable post loop 
*	Hide content on a post

= Take advantage of theme developer options =
*	a category list that uses the options from the exlude setup
*	a media embedder with oEmbed fallback

== Installation ==
= 3-step installation =
1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it, and navigate to Dashboard->Settings->My Optional Modules for configuration.

= 3-step uninstallation =
1. Navigate to Dashboard->Settings->My Optional Modules.
2. Click on Uninstall.
3. Confirm uninstall.

== Screenshots ==
1. A horizontal gallery in a post.
2. Share icons displayed at the top of the post content.

== Changelog ==

= 8-RC-1.5.6 =
* 'function.exclude-categories' calling wrong options (bugfix)
* Files updated with information regarding when they were last changed (source)

= 8-RC-*.*.* =
* 8-RC-1.5.5 -- Fixed issue with 'Meta tags' where they would not function properly if 'External Thumbnails' weren't enabled
* 8-RC-1.5.5 -- 'External thumbnails', if using imgur or youtube, will output appropriate og:tags if 'Meta tags' are enabled
* 8-RC-1.5.4 -- Moved Google Analytics to wp_header (from wp_footer) (change)
* 8-RC-1.5.3 -- Issue with wrong option name being called for external thumbnails (bugfix)
* 8-RC-1.5.2 -- Youtube embeds with '[mom_embed]' utilize thumbnails to click to load the video. (Falls back to an embed if js is turned off browser side)
* 8-RC-1.5.1 -- undefined variable 'timeStamp' with '[mom_embed]' (bugfix)
* 8-RC-1.5.0 -- '[mom_embed]'/media embedding uses strpos > preg_match (upgrade)
* 8-RC-1.5.0 -- 'Font Awesome' shortcode menu on post creation screen sectioned off for slightly easier navigation
* 8-RC-1.4.0 -- Attach a default miniloop to the bottom of each post utilizing meta keys. (addition)
* 8-RC-1.4.0 -- [mom_hidden]content[/mom_hidden] allows you to specify content to hide based on parameters. (check shortcode documentation in admin) (addition)
* 8-RC-1.2/3 -- Options should now be able to be enabled/disabled properly (bugfix) (persistent)
* 8-RC-1.1.0 -- Upgrade version '2' (upgrade)
* 8-RC-1.1.0 -- Settings page now utilizes a single form (upgrade)
* 8-RC-1.1.0 -- Plugin documentation (addition)
* 8-RC-1.1.0 -- Ability to reset all plugin settings added (addition)
* 8-RC-1.1.0 -- Google Tracking Code now properly tracks single post/page views instead of treating every hit like a hit to the homepage (bugfix)
* 8-RC-1.0.0 -- 'mom_miniloop', 'mom_attachments', 'mom_embed' code optimized (shortcode) (upgrade)
* 8-RC-1.0.0 -- When saving options, if values are empty, they are removed from the database (upgrade)
* 8-RC-1.0.0 -- 'Uninstall' missing options rounded up (100% cleaning up after itself) (bugfix)
* 8-RC-1.0.0 -- Insert Google Analytics tracking code on your blog (addition)
* 8-RC-1.0.0 -- Exclusion rules for user levels now affects single post view (addition)
* 8-RC-1.0.0 -- 'Meta tags' enables open graph (og:) tags with optional Twitter card information (addition)