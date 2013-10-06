=== My Optional Modules ===
Contributors: Matthew Trevino
Tags: word count, word goal, countdown, total, rups, rotating universal passwords, sha512, encyrption, salt
Requires at least: 3.6
Tested up to: 3.6.1
Stable tag: 1.1

A bundle of optional Wordpress modules to enhance functionality.

== Description ==
My Optional Modules (or MOM) is a bundle of optional modules for Wordpress which give extra functionality not currently available in a fresh installation. 
They are designed to be lightweight and easilly implemented by even the most novice of Wordpress users.

== Installation ==

1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it.
4. You'll find settings for the plugin under Settings->MOM: Main Control.


== Changelog ==

= 1.1 =
* Checks for previously installed RUPs (standalone plugin).
* If RUPs is installed AND active, the RUPs module will be unavailable until the RUPs plugin is deactivated.

= 1.0 =
* Initial release.
* Module 1: Post Word Count (http://wordpress.org/plugins/post-word-count/)
* - added an options page to allow for word goal and word change.
* - updated code to only count words in published posts.
* Module 2: RUPs (Rotating Universal Passwords)
* - if you were using the original RUPs plugin, this module takes advantage of previous settings.
* - to continue using your same passwords, simiply delete the RUPs plugin folder, and activate the RUPs module.
