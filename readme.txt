=== My Optional Modules ===
Contributors: Matthew Trevino
Tags: word count, word goal, countdown, total, rups, rotating universal passwords, sha512, encyrption, salt, exclusion, exclude, tags, categories, archives, post formats, post-formats, formats, hide
Requires at least: 3.6
Tested up to: 3.6.1
Stable tag: 1.0.3.1

A bundle of optional Wordpress modules to enhance functionality.

== Description ==
My Optional Modules (or MOM) is a bundle of optional modules for Wordpress which give extra functionality not currently available in a fresh installation. 
They are designed to be lightweight and easilly implemented by even the most novice of Wordpress users.

= Modules currently available: =
* Count++, a module to count words on the blog and countdown from an (optional) total count goal.
* RUPs, a module for storing 7 unique (SHA512 salted) passwords, and then hiding content with a shortcode (and IP based lockout) that is unlockable using the current days password.
* Simply Exclude (SE), a module to hide tags, categories, and post formats from the front page, the archives, the search results, or the feed (or all).


== Installation ==

1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it.
4. You'll find settings for the plugin under Settings->MOM: Main Control.


== Changelog ==
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
