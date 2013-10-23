=== My Optional Modules ===
Contributors: One Billion Words
Tags: reviews,review,custom,tinymce,logged in, hide comments, hide, comments, restrict, comment form, comment template, reddit, google maps, google, submit, button, share, gps, coords, embed, keyboard navigation, post, home page, front page, home, navigate, word count, word goal, countdown, total, rups, rotating universal passwords, sha512, encyrption, salt, exclusion, exclude, tags, categories, archives, post formats, post-formats, formats, hide
Requires at least: 3.6
Tested up to: 3.6.1
Stable tag: 3.0.3

A bundle of optional Wordpress modules to enhance functionality.

== Description ==
My Optional Modules (or MOM) is a bundle of optional modules for Wordpress which give extra functionality not currently available in a fresh installation. 
They are designed to be lightweight and easilly implemented by even the most novice of Wordpress users.

= No Unnecessary Load =
MOM only loads what you want it to load - so no matter how many modules come packaged, the only ones that get loaded are the ones that you ask for.

= Standing on the shoulders of geniuses =
* The following modules could not have existed without the work from previous plugins and authors:
* Count++ is adapted from [Post Word Count](http://wordpress.org/plugins/post-word-count/) by [Nick Momrik](http://profiles.wordpress.org/nickmomrik/).
* Google Maps in the Shortcodes! module adapted from [Very Simple Google Maps](http://wordpress.org/plugins/very-simple-google-maps/) by [Michael Araonoff](http://profiles.wordpress.org/masterk/).

= Modules currently available: =
* Count++, a module to count words on the blog and countdown from an (optional) total count goal.
* Passwords, a module for storing 7 unique (SHA512 salted) passwords, and then hiding content with a shortcode (and IP based lockout) that is unlockable using the current days password.
* Exclude, a module to hide tags, categories, and post formats from the front page, the archives, the search results, or the feed (or all).
* Post as Front, a module that allows you to select a specific post to be your home page, or make your home page your most recent post.
* Jump Around, a module that allows users to navigate posts by pressing keys on the keyboard.
* Shortcodes!, a module that adds useful shortcodes for posts and pages.
* Analaytics automatic embedding.
* Reviews allows you to create custom reviews on anything you want, and display them on a post or a page.
* Database cleaner to mass-delete trashed/revisions/drafts, unapproved/trashed/spam comments, or unused tags and categories.

= Shortcodes =
* Google maps embedding.
* Reddit submit button.
* Restrict content to logged in users, with the option to selectively allow comments (both form and viewing of) to logged in users only.

== Installation ==

1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it.
4. You'll find settings for the plugin under Settings->MOM: Main Control.


== Changelog ==
= 3.0.0 / 3.0.1 / 3.0.2 / 3.0.3 =
* Hotfix: CSS 's no longer escaped
* Minor tweaks, bug fixes.
* Review CSS edit box added.  Disable and renable the Review module to use this feature.
* Title, type, URL, and rating are now optional fields.
* CSS for Reviews injected into header (wp_head)
* Stray checked tag removed from items in reviews output.
* Module: Reviews added - it allows you to create custom reviews of anything and show them (via shortcode) on a post or page.

= 2 / 2.1 / 2.2 =
* RUPs is now just Passwords.  Simply Exclude (SE) is now just Exclude.
* Added delete all button to Database cleaner to one-click delete all database clutter.
* Simply Exclude (SE) now automatically enables all post types.
* Tools section added to Main Control page.
* Database cleaner added to Tools section, which allows the admin to mass delete: post revisions, post drafts, trashed posts, unapproved comments, trashed comments, spam comments, unused tags, or unused categories at the push of a button.

= 1.0.9 / 1.0.9.1 =
* Added module to insert Google Analytics tracking code.
* Updated modules will need to be deactivated/reactivated for new options to be fully available upon upgrading.
* Modules updated: Simply Exclude (SE), Count++.
* Simply Exclude module updates - can now hide categories based on what day of the week it is.  (You will need to deactivate/reactive the module to take advantage of this.)
* Count++ module updates- tidied up settings page, displayed message can be customized.
* RUPs and Jump Around have had their pages tidied up.


= 1.0.8 / 1.0.8.1 / 1.0.8.2 / 1.0.8.3 / 1.0.8.4 / 1.0.8.5 / 1.0.8.5.1 =
* Post as Front minor glitch fixed.
* Post as Front now correctly pre-selects saved post (if set to anything other than Most Recent Post).
* Options page for Post as front removed, and settings move to MOM: Main Control (since there was only one settings anyway).
* SE settings page tidied up.
* SE can now hide tags based on what day of the week it is.  (You will need to deactivate/reactivate the module to take advantage of this.)
* Fixed Post as Front to display all posts.
* Added shortcode to selectively hide content and comments (both the viewing of and commenting of) from viewers who are not logged in.
* Fixed shortcode positioning so that it stays where you put it.
* Module 6: Shortcodes!
* - A module that introduces some useful shortcodes that you can incorporate into posts and pages.

= 1.0.7 =
* Removed global variables from modules.
* Due to the way RUPs handles the user defined salt, $theSalt global was left in (for admin convenience).
* Cleaned up code for all modules.

= 1.0.6 / 1.0.6.1 =
* Fixed: Number formatting (commas)
* Module update: Count++
* - 3 new functions added: output total words (numerical only), total remaining (numerical only), and total words in post (single post view only, numerical only)

= 1.0.5 / 1.0.5.1 =
* [This is just a test] removed / leftover (accidentally left in)
* 2 Uninstall methods: reset all and nuke.  
* Reset all erases all options associated with all modules.  
* Nuke erases all options associated with the plugin itself, which includes any separate tables it has created to store information for future usage.

= 1.0.4 =
* Module 4: Post as Front (PAF)
* - Select a specific post to be your home page, or make your home page your most recent post.
* Module 5: Jump Around
* - Navigate posts by pressing keys on the keyboard.

= 1.0.3 = 
* Module 3: SE (Simply Exclude)
* - Exclude a single or comma-separated list of tags and categories from: front page, archives, search results, or feed.
* - can exclude tags, categories, and post formats.

= 1.0.2 =
* Official Plugin page updated, plugin page created.

= 1.0.1 =
* Version updates (plugin file)
* Checks for previously installed RUPs (standalone plugin).
* If RUPs is installed AND active, the RUPs module will be unavailable until the RUPs plugin is deactivated.

= 1.0.0 =
* Initial release.
* Module 1: Post Word Count (http://wordpress.org/plugins/post-word-count/)
* - added an options page to allow for word goal and word change.
* - updated code to only count words in published posts.
* Module 2: RUPs (Rotating Universal Passwords)
* - if you were using the original RUPs plugin, this module takes advantage of previous settings.
* - to continue using your same passwords, simiply delete the RUPs plugin folder, and activate the RUPs module.
