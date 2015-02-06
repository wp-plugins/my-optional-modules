=== My Optional Modules ===
Contributors: boyevul
Tags: comments, version, pingbacks, author, date, archives, disable, horizontal, galleries, font awesome, share, RSS, DNSBL, ajax, garbage, removal, trash, footer, lazy load, exclude, remove, hide, front page, search results, authors, categories, tags, post formats, read more, single post, miniloop, attachment, media, embedder, oEmbed
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 5.8.1

An assortment of functions to enhance WordPress.

== Description ==
MOM features an assortment of functions designed to add (or extend) functionality within WordPress. ( We're also available 
on [Github](https://github.com/onebillion/mom). )

= Disable WordPress components =
*	Comments
*	Version number in source
*	Pingbacks to you
*	Author based archives
*	Date based archives

= Enable WordPress extras =
*	Horizontal slider galleries
*	Font Awesome
*	Scriptless social sharing links
*	RSS link backs to your site
*	DNSBL for the comments form
*	Ajax for the comments form

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
*	Turn your front page into a single post
&	Add a CSS class to next and previous links for styling purposes
*	Enable ?random post functionality
*	Change the value of "read more..." for excerpts

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

== Changelog ==

= 5.8.1 =
* Read more... setting wasn't very clear as to what the field was for

= 5.8.* =
* Exclue Taxonomies can now exclude Authors from anywhere on the blog (excluding single post views for obvious reasons)
* FitText.js belonged to a module that hasn't been used for quite some time (FitText.js removed)
* More information regarding how many of what is being deleted for Trash Removal

= 5.7.* =
* If Share Icons are enabled but Font Awesome is not, links default text (instead of trying to use icons)
* Previously undocumented theme developer functions are now documented (somewhat) on the settings page
* DNSBL redundancies removed
* Admin screen streamlining
* Plugin uninstall wasn't erasing some of the Exclusion parameters. (Fixed)
* Added a way to disable pingbacks
* Font Awesome 4.3
* When enabling/disabling share icons/post exclusion, scrolling is unnecessary
* Read more and Theme:Twenty Fifteen conflict resolved
* Meta generator removal for removing WordPress version from source
* Fix for horizontal galleries to properly display the appropriate images for each individual gallery
* Tested up to/requires at least tag updated
* Create a random link query (like ?random or ?goto) to allow visitors to pull a random post from your blog
* FitText footer script moved to fittext.js
* Edit the text of the 'read more...' link
* Apply custom link classes to 'next' and 'previous' post/posts links (single and archive navigation links)
* User_level(s) altered so that 'logged out' does not mean the same as 'subscriber'.
* Draft deletion added to database cleaner; not tied to "clear all database clutter" button
* Miniloops should only attempt to output content if there are actually posts in the loop to output
* [mom_attachments] returns a specified number of recently uploaded images (unformated) that link to the post they were added to
* Added default values for reference for [mom_miniloop] on control panel
* Outdated uninstallation for options no longer used removed
* Protocol-relative css inclusion for plugin stylesheet
* Nonces added to adminstrative menus. (Make sure your install is correct, and has SALTs and KEYS defined in wp-config)
* The settings page will alert you to the presence (or lack thereof) of SALTS and KEYS in the wp-config file
* Scriptless share buttons added: google-plus, facebook, reddit, twitter, and email shares

= 6.5.* =
* Disable comments if the user is listed on (any) 1 of 7 DNSBL
* Font Awesome updated to current version of 4.2 (40 new icons added)
* miniloop shortcode functionality call to action misplaced
* Admin page CSS @media queries for better display
* All unused code from 5.5.X has been removed
* All uninstallation functionality that has been outdated for quite some time now has been removed