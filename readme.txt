=== My Optional Modules ===
Contributors: boyevul
Tags: DNSBL, front, home, database, cleaner, disable, comments, RSS, javascript, footer, archives, author, ajax, font awesome, lazy load, horizontal, gallery, hide, version, mini, loop, exclude, category, tag, post format
Requires at least: 3.9.1
Tested up to: 4.0
Stable tag: 5.7.2

An assortment of functions to enhance WordPress.

== Description ==
MOM features an assortment of functions designed to add (or extend) functionality within WordPress.

= (Optional) Modules: =
* Set the front page of the blog as an individual post (or your latest post)
* Clear database trash with a single button
* Disable comments site-wide (or disable comments if user is listed on 1 of 7 DNSBL lists)
* Ajaxify the comments form
* Turn WordPress default galleries into horizontal sliders
* Append links back to your blog on all of your RSS items
* Enable the use of Font Awesome
* Hide the WordPress version from your source code
* Move all Javascripts to the footer
* Enable Lazy Load for images in posts
* Disable Author and Date-based archives
* Attach miniature loops anywhere, allowing the display of any post based on multiple parameters
* Attach miniature attachment loops anywhere, allowing the display of recently uploaded images (with accompanying link to the post they were added to)
* Exclude posts from almost anywhere on your blog, based on many different parameters

== Installation ==
= 3-step installation =
1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it.
4. You'll find settings under Dashboard->Settings->My Optional Modules

== Changelog ==
* 5.7.2    create a random link query (like ?random or ?goto) to allow visitors to pull a random post from your blog
* 5.7.2    fittext footer script moved to fittext.js
* 5.7.2    edit the text of the 'read more...' link
* 5.7.2    apply custom link classes to 'next' and 'previous' post/posts links (single and archive navigation links)
* 5.7.2    user_level(s) altered so that 'logged out' does not mean the same as 'subscriber'.
* 5.7.2    draft deletion added to database cleaner; not tied to "clear all database clutter" button
* 5.7.1    miniloops should only attempt to output content if there are actually posts in the loop to output
* 5.7.1    [mom_attachments] returns a specified number of recently uploaded images (unformated) that link to the post they were added to
* 5.7      Added default values for reference for [mom_miniloop] on control panel
* 5.7      Outdated uninstallation for options no longer used removed
* 5.7      protocol-relative css inclusion for plugin stylesheet
* 5.7      nonces added to adminstrative menus. (Make sure your install is correct, and has SALTs and KEYS defined in wp-config)
* 5.7      the settings page will alert you to the presence (or lack thereof) of SALTS and KEYS in the wp-config file
* 5.7      scriptless share buttons added: google-plus, facebook, reddit, twitter, and email shares
* 5.6      Disable comments if the user is listed on (any) 1 of 7 DNSBL
* 5.6      Font Awesome updated to current version of 4.2 (40 new icons added)
* 5.6      miniloop shortcode functionality call to action misplaced
* 5.6      Admin page CSS @media queries for better display
* 5.6      All unused code from 5.5.X has been removed
* 5.6      All uninstallation functionality that has been outdated for quite some time now has been removed