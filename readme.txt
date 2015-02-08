=== My Optional Modules ===
Contributors: boyevul
Tags: 404, comments, version, pingbacks, author, date, archives, disable, horizontal, galleries, font awesome, share, RSS, DNSBL, ajax, garbage, removal, trash, footer, lazy load, exclude, remove, hide, front page, search results, authors, categories, tags, post formats, read more, single post, miniloop, attachment, media, embedder, oEmbed
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 5.8.2

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

= 5.8.2 =
* Some functions now only "exist" if their module is actually turned on via settings
* Wording on Author Archive disable changed to better reflect what was actually happening
* Onclick Font Awesome inserts at cursor
* Onclick Font Awesome uses [font-fa] shortcode instead of pure html
* Enable all 404s to redirect to the homepage
* Admin screen CSS additions

= 5.8.* =
* Read more... setting wasn't very clear as to what the field was for
* Exclue Taxonomies can now exclude Authors from anywhere on the blog (excluding single post views for obvious reasons)
* FitText.js belonged to a module that hasn't been used for quite some time (FitText.js removed)
* More information regarding how many of what is being deleted for Trash Removal