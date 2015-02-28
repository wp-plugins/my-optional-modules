=== My Optional Modules ===
Contributors: boyevul
Tags: random, description, title, 404, comments, version, pingbacks, author, date, archives, disable, horizontal, galleries, font awesome, share, RSS, DNSBL, ajax, garbage, removal, trash, footer, lazy load, exclude, remove, hide, front page, search results, authors, categories, tags, post formats, read more, single post, miniloop, attachment, media, embedder, oEmbed
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 6.0.8

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

= Enable even more extras =
*	One click database garbage removal
*	Move Javascript to the footer
*	Enable Lazy Load for images in posts

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

= Take advantage of shortcodes =
*	An attachments loop to show off images (that link to their respective posts)
*	A highly customizable post loop 

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

= 6.0.8 =
* Fixed an issue with my_optional_modules_exclude_categories() that would return errors if exclusion module was turned off

= 6.0.* =
* Minor change to how Font Awesome shortcodes behave
* Minor change to how mom_miniloop, mom_attachments, mom_mediaembed_shortcode shortcodes were implemented as they were/may have been interfering with other plugins ability to properly initiate certain shortcodes (SyntaxHighllighter Evolved as one example).
* [mom_embed] will now embed media using mom_mediaEmbed - supports imgur albums, youtube with ?t parameter, soundcloud, vimeo, gfycat, funnyordie, vine, with oEmbed fallback for WordPress supported embeds not covered.
* Moved External Thumbnails and Recent Posts Widget to Extras menu
* Previous function no longer being used removed
* Uninstallation procedure missing a recently added option for removal 
* miniloop additional div close
* miniloop list style now outputs the excerpt in place of time since post, author and category information
* Further limit function inclusions if they aren't being called for via settings
* Pre-increment swapped for all instances of variables using post-incremement (++$variable instead of $variable++)
* $_SERVER['REQUEST_TIME'] replaces time()
* In some instances, strlen has been replaced by isset
* Optionally remove the inclusion of the plugin's CSS (you WILL need to style everything should you decide to disable the plugin CSS) (advanced option)
* WordPress default post thumbnail integration as fallback if external thumbnail non-existent (or nothing if neither)
* Function moved
* Fixed issue with moving scripts to footer also moving the stylesheets
* Code clean-up
* Settings page descriptions altered
