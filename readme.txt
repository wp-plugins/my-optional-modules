=== My Optional Modules ===
Contributors: boyevul
Tags: meta, og, twitter, facebook, google, random, description, title, 404, comments, version, pingbacks, author, date, archives, disable, horizontal, galleries, font awesome, share, RSS, DNSBL, ajax, garbage, removal, trash, footer, lazy load, exclude, remove, hide, front page, search results, authors, categories, tags, post formats, read more, single post, miniloop, attachment, media, embedder, oEmbed
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 8-RC-1.3.1

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

= Take advantage of theme developer options =
*	a category list that uses the options from the exlude setup
*	a media embedder with oEmbed fallback

== To-Do ==
*	Optimize option calls 
*	Remove 7->8 upgrade once majority of users are using version 8

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

= 8-RC-1.2 / 8-RC-1.3 / 8-RC-1.3.1 =
* Options should now be able to be enabled/disabled properly (bugfix) (persistent)

= 8-RC-1.1 =
* Upgrade version '2' (upgrade)
* Settings page now utilizes a single form (upgrade)
* Plugin documentation (addition)
* Ability to reset all plugin settings added (addition)
* Google Tracking Code now properly tracks single post/page views instead of treating every hit like a hit to the homepage (bugfix)

= 8-RC-1 =
* 'mom_miniloop', 'mom_attachments', 'mom_embed' code optimized (shortcode) (upgrade)
* When saving options, if values are empty, they are removed from the database (upgrade)
* 'Uninstall' missing options rounded up (100% cleaning up after itself) (bugfix)
* Insert Google Analytics tracking code on your blog (addition)
* Exclusion rules for user levels now affects single post view (addition)
* 'Meta tags' enables open graph (og:) tags with optional Twitter card information (addition)