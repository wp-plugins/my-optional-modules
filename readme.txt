=== My Optional Modules ===
Contributors: boyevul
Tags: DNSBL, front, home, database, cleaner, disable, comments, RSS, javascript, footer, archives, author, ajax, font awesome, lazy load, horizontal, gallery, hide, version, mini, loop, exclude, category, tag, post format
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 5.8.0

An assortment of functions to enhance WordPress.

== Description ==
MOM features an assortment of functions designed to add (or extend) functionality within WordPress.

= (Optional) Modules: =
* Set the front page as a particular post
* Clear database garbage
* Disable WordPress version info in source code
* Comments functionality modules:
* + Disable comments site-wide
* + or disable comments for users who appear on one of several DNS Black Lists (DNSBL)
* + and/or ajaxify the comments form
* Disable pingbacks
* Transform default image galleries into horizontal sliders
* Append links back to your site on all RSS items
* Enable Font Awesome
* Javascripts to the footer
* Lazy Load for images in posts
* Disable archives for dates and/or authors
* Mini-loops to be deployed on posts and pages:
* + Miniature post loops (via shortcode)
* + Attachment loops (via shortcode) for images (with links to their parent posts)
* Exclude posts from RSS, the front page, tag/category/date archives, and search results, based on:
* + the author
* + the category
* + the tag
* + post format
* + the day of the week
* + who's logged in 



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
* 5.8.0 : Exclue Taxonomies can now exclude Authors from anywhere on the blog (excluding single post views for obvious reasons)
* 5.8.0 : FitText.js belonged to a module that hasn't been used for quite some time (FitText.js removed)
* 5.8.0 : More information regarding how many of what is being deleted for Trash Removal
* ----- : -----------------
* 5.7.9 : If Share Icons are enabled but Font Awesome is not, links default text (instead of trying to use icons)
* 5.7.9 : Previously undocumented theme developer functions are now documented (somewhat) on the settings page
* 5.7.9 : DNSBL redundancies removed
* 5.7.8 : Admin screen streamlining
* 5.7.8 : Plugin uninstall wasn't erasing some of the Exclusion parameters. (Fixed)
* 5.7.8 : Added a way to disable pingbacks
* 5.7.7 : Font Awesome 4.3
* 5.7.6 : When enabling/disabling share icons/post exclusion, scrolling is unnecessary
* 5.7.6 : Read more and Theme:Twenty Fifteen conflict resolved
* 5.7.5 : meta generator removal for removing WordPress version from source
* 5.7.4 : Fix for horizontal galleries to properly display the appropriate images for each individual gallery
* 5.7.3 : Tested up to/requires at least tag updated
* 5.7.2 : create a random link query (like ?random or ?goto) to allow visitors to pull a random post from your blog
* 5.7.2 : fittext footer script moved to fittext.js
* 5.7.2 : edit the text of the 'read more...' link
* 5.7.2 : apply custom link classes to 'next' and 'previous' post/posts links (single and archive navigation links)
* 5.7.2 : user_level(s) altered so that 'logged out' does not mean the same as 'subscriber'.
* 5.7.2 : draft deletion added to database cleaner; not tied to "clear all database clutter" button
* 5.7.1 : miniloops should only attempt to output content if there are actually posts in the loop to output
* 5.7.1 : [mom_attachments] returns a specified number of recently uploaded images (unformated) that link to the post they were added to
* 5.7.0 : Added default values for reference for [mom_miniloop] on control panel
* 5.7.0 : Outdated uninstallation for options no longer used removed
* 5.7.0 : protocol-relative css inclusion for plugin stylesheet
* 5.7.0 : nonces added to adminstrative menus. (Make sure your install is correct, and has SALTs and KEYS defined in wp-config)
* 5.7.0 : the settings page will alert you to the presence (or lack thereof) of SALTS and KEYS in the wp-config file
* 5.7.0 : scriptless share buttons added: google-plus, facebook, reddit, twitter, and email shares
* ----- : -----------------
* 5.6.0 : Disable comments if the user is listed on (any) 1 of 7 DNSBL
* 5.6.0 : Font Awesome updated to current version of 4.2 (40 new icons added)
* 5.6.0 : miniloop shortcode functionality call to action misplaced
* 5.6.0 : Admin page CSS @media queries for better display
* 5.6.0 : All unused code from 5.5.X has been removed
* 5.6.0 : All uninstallation functionality that has been outdated for quite some time now has been removed