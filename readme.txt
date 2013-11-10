=== My Optional Modules ===
Contributors: boyevul
Tags: redirect,404,redirect,maintenance,members,action,maintenance,simple,poll,polling,age,restrict,verify,gate,questions,verifier,verification,answers,quiz,scripts,javascript,footer,lazy,lazyload,twitter,google+,opengraph,meta,keywords,jquery,dynamic,no-js,collapse,expand,css-only,css,reviews,review,custom,tinymce,loggedin,hidecomments,hide,comments,restrict,commentform,commenttemplate,reddit,googlemaps,google,submit,button,share,gps,coords,embed,keyboardnavigation,post,homepage,frontpage,home,navigate,wordcount,wordgoal,countdown,total,rups,rotatinguniversalpasswords,sha512,encyrption,salt,exclusion,exclude,tags,categories,archives,postformats,post-formats,formats,hide
Requires at least: 3.6
Tested up to: 3.6.1
Stable tag: 5.2.5

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

= Modules: =
* Count++, a module to count words on the blog and countdown from an (optional) total count goal.
* Exclude, a module to hide tags, categories, and post formats from the front page, the archives, the search results, or the feed (or all).
* Jump Around, a module that allows users to navigate posts by pressing keys on the keyboard.
* Maintenance, a module that allows you to specify a URL to redirect to for all non-logged in users while Maintenance Mode is active.
* Post as Front, a module that allows you to select a specific post to be your home page, or make your home page your most recent post.
* Passwords, a module for storing 7 unique (SHA512 salted) passwords, and then hiding content with a shortcode (and IP based lockout) that is unlockable using the current days password.
* Reviews allows you to create custom reviews on anything you want, and display them on a post or a page.
* Shortcodes!, a module that adds useful shortcodes for posts and pages.

= Tweaks: =
* Analaytics automatic embedding.
* Automatically enable all images in posts and pages to use Lazy Load.
* Hide WP Version from enqueued scripts and stylesheets.

= Meta: =
* Auto-generate meta tags (open-graph and otherwise).
* Appends linkbacks on RSS items (against scrapers).
* noarchive/nofollow on 404/search pages/archives.
* Disables Author archives if only one author exists.
* Disables date based archives to avoid duplicate content.
* Moves Javascript to the footer to decrease page load times.
* Returns 5 keywords for the post in meta:keywords, based on most used words.

= Tools: =
* Database cleaner to mass-delete trashed/revisions/drafts, unapproved/trashed/spam comments, or unused tags and categories.

== Installation ==
= 3-step installation =
1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it.

== Screenshots ==
1. Setting page on a fresh installation, with everything directly at your fingertips.
2. Reviews module (after a module with settings is activated, it will appear in the menu opposite of uninstall).
3. Reviews module (again) with a look at the edit feature.
4. The Exclude module is now even easier to hide categories, tags, and post formats.
5. Continuing in the fashion of the one-click enabling, settings for the modules that only have one will be shown, regardless of whether or not they are activated for ease of use.  
6. Trash collection is provided by the 4 trash icons, along with the items that are present to be purged and what those items belong to.
7. Uninstalling is still just two clicks away (should you ever wish to discontinue using MOM).  Simply double-tap that button, deactivate, and delete.


== Changelog ==
= 5.2.+ =
* 5.2.5 / Redirecting unatuhorized viewers from posts based on user level is now applied to all 404s.  You may choose whether to redirect to the front page or to a specific page.  Tied to the Exclude module so 404 redirection is only active when Exclude is active.
* 5.2.4 / Bugfix: Exclude: Redirecting isn't working quite as intended upon further testing.  Disabled for now.
* 5.2.3 / Module: Exclude: Hide Post Formats from logged out added.
* 5.2.3 / Module: Exclude: Post formats now properly added to edit post screen. (Will not hide single post view like logged out cat and tag hiding does.)
* 5.2.3 / Module: Exclude: Hide categories and tags from users based on level (0,1,2,7 / subscriber,contributor,author,editor).  Any categories and tags hidden by user level will subsequently be hidden from all users not currently logged in.
* 5.2.3 / Module: Exclude: Redirect viewers who don't meet the level requirements (based on hidden by user level/logged out) to a specific page.
* 5.2.2 / Hotfix: Exclude -> Filter tags for logged out visitors was not being called.  If options are empty, variables will be preset to suppress errors.
* 5.2.1 / Hotfix: Reviews.
* 5.2.0 / Complete UI rehaul.  Now with even more... thing.

= 5.1.+ =
* 5.1.9.1 / Ability to add html to reviews fields for a wider variety of display types added.
* 5.1.9.0 / Bugfix: module: Post as Front
* 5.1.8.0 / Ability to edit reviews has been added, as well as delete confirm for items.
* 5.1.8.0 / Some files have had unnecessary whitespace removed.
* 5.1.7.0 / Modified: code: Exclude: forms have been 'idiot-proofed'.
* 5.1.7.0 / Modified: code: Exclude: upon upgrading to 5.1.7, you may (or may not) want to do a 'resubmit' on your current data-set.  Simply go to the Exclude settings page, and press the save button.  This will resubmit your current data using the new functionality.
* 5.1.7.0 / Bugfix: module: Exclude: a couple of exclusion rules were left out by mistake.  This mistake has been rectified.
* 5.1.6.0 / Deactivate/activate the Exclude module after updating.
* 5.1.6.0 / Exclude: Hide specific posts and tags from people who aren't logged in. (This will hide them from the feed as well)
* 5.1.6.0 / Exclude: If you are hiding tags or categories from non logged in users, the content returned will be from your 404 template.
* 5.1.6.0 / Bugfix: module: Jump Around has had its installation procedure fixed.
* 5.1.5.0 / UI changed.  Should be more intuitive, easier to navigate, and easier to activate and deactivate modules.
* 5.1.5.0 / Compatability check added to make sure there are no conflicting functions between other plugins and themes and the functions used in MOM.
* 5.1.4.0 / An extremely simple maintenance mode has been added.
* 5.1.3.0 / Bugfix: module: Reviews now have the content of the review formatted properly.
* 5.1.3.0 / Bugfix: function: obwcountplus_single().
* 5.1.2.0 / Verifier: Added the option to set the correct and incorrect stats messages, providing the ability to set up impromptu 'yes/no' type polls/questions (think 'Did you find this article useful?  Yes or no.')
* 5.1.1.0 / Hotfix for positioning of Verifier output/form.
* 5.1.0.0 / Disable/renable the Shortcodes! module for changes to take effect.
* 5.1.0.0 / Verifier shortcode added.  This one is a bit of a beast, so best to check the documentation.
* 5.1.0.0 / Verifier: gate content with an age check, or a question.
* 5.1.0.0 / Verifier: log unique correct and incorrect answers and optionally show these stats.
* 5.1.0.0 / Verifier: ability to set a gate as a one time event or not.

= 5.0.+ =
* 5.0.9 / Title rewrites removed (this really should be handled on a theme level, in my opinion.)
* 5.0.9 / Buttons add to post editing screen; if a module has a shortcode, a button for it will be added for easy access to that shortcode.
* 5.0.9 / Meta: Excerpt handling hotfixed to remove html tags from the output.
* 5.0.9 / Meta: reWrite titles (so that page content is clearer).
* 5.0.9 / Meta: A few minor tweaks and fixes.
* 5.0.9 / Meta: keywords will not be present in the title; keywords will not be html elements; list of words to ignore improved.
* 5.0.9 / Meta: keywords no longer based on tags present (I just wasn't happy with the results that this approach was producing).
* 5.0.9 / Meta: hotfixed string comparison for tag -> most used word.
* 5.0.8 / Meta: Compare the tags of the post against the content of the post, filter out commonly used words, and determine the focus word of the post.
* 5.0.8 / Meta: Canonical link taken out of header og/meta elements as this should be handled on a theme level.
* 5.0.8 / Meta: moves scripts to the footer (in a way that doesn't interfere with other scripts being called by certain modules)
* 5.0.7 / Hotfix for Twitter (author).
* 5.0.6 / Hotfix for author count logic.
* 5.0.5 / Meta disables author archives if there is only a single author with posts; disables date based archives as well.
* 5.0.5 / Meta noarchive/nofollows 404s and archive pages.
* 5.0.5 / Appends "Post title" via "Site title" with link-backs to your feeds.
* 5.0.5 / Meta embeds Open Graph (og:) protocol tags on all posts, pages, and portions of the site.
* 5.0.4 / Hotfix.
* 5.0.2 / Improved keyword generation for the Meta module.  It will now ignore numbers, anything inside of pre /pre, and any [shortcode] codes.
* 5.0.1 / Better output filtering on Reviews.
* 5.0.1 / Add Twitter username field to profile field for use in meta, keywords and site Twitter username to general settings.
* 5.0.1 / Enable Meta keywords, description, and other meta properties (like og:title,og:image,og:description, and so-forth) automatically for posts and pages.
* 5.0.1 / Lazy Load added; automatically converts (for those with javascript enabled) images in posts (added via gallery - single or multiple) to be loaded via Lazy Load, decreasing page load times.
* 5.0.0 / Exclude installation bug fix.
* 5.0.0 / Further code cleanup on remaining files that weren't previously cleaned up in the 4.0.+ series.
* 5.0.0 / Install procedures (activate all, deactivate all, reset, nuke) corrected.
* 5.0.0 / Module settings pages have had their CSS altered to be more uniform.

= 4.0.+ = 
* 4.0.9 / CSS fixed
* 4.0.9 / Progress bar shortcodes added.
* 4.0.8 / Further code cleanup.  
* 4.0.8 / _uninstall and _install functionality moved to _update.
* 4.0.7 / Passwords uses the salt provided by Wordpress (you don't have to edit the salt yourself).  Requires you to update your passwords to rehash them.
* 4.0.7 / Code cleanup, including minor bug fixes and removal of a couple of functions that were left over from early releases that are no longer used or supported.
* 4.0.6 / URLs in Reviews escaped.
* 4.0.5 / Admin interface has been completely overhauled, with all settings pages for all modules either being consolidated completely to a single screen.
* 4.0.5 / various bug fixes.
* 4.0.4 / Searching Reviews on admin page now sticks those results until another search term is entered.  (Required Reviews module deactivate/reactivate to function.)
* 4.0.3 / Multiple IDs can be called with Reviews.
* 4.0.2 / Fixed f***ing closing </code> tag.  Where's my coffee at?
* 4.0.1 / Reviews admin page spruced up a tad.
* 4.0.1 / New parameter added: id (allows you to show a single review based on the id of the review).
* 4.0.0 / Font Awesome fixed, readded.  (Updates to the way font awesome uses the i class for its fonts noted on settings screen).

= 3.0.+ =
* 3.0.9 / Minor bug fixes.
* 3.0.8 / Expand and retract text (Reviews) customizable in shortcode.  Rating moved outside of meta to below review (so it is still visible when meta is being hidden.)
* 3.0.7 / A few more [momreviews] shortcode options added.
* 3.0.6 / Activate all hotfix.
* 3.0.6 / When options are saved, page refreshes to update current settings as they have been set.
* 3.0.6 / Many redundancies in the code have been removed.
* 3.0.6 / se.php and rups.php have been renamed exclude.php and passwords.php.
* 3.0.6 / Uninstall All Modules has been renamed to All Modules (on the main settings page), has 2 new options (Activate all, Deactivate all), and has had its description updated to reflect the changes.
* 3.0.5 / Wording for reviews has been removed (Review type:, rating:).
* 3.0.4 / In order to keep from calling the CSS in places that the shortcode for Reviews wasn't being used, the CSS has been moved from the header and place above the shortcode output.
* 3.0.4 / Multiple review types can be stringed together into a single output block.
* 3.0.4 / Multiple Review shortcode usages with the same output will now behave appropriately when menu items are clicked.
* 3.0.4 / An old function that was no longer being used by the Reviews module has been removed from the code.
* Hotfix: CSS 's no longer escaped
* Minor tweaks, bug fixes.
* Review CSS edit box added.  Disable and renable the Review module to use this feature.
* Title, type, URL, and rating are now optional fields.
* CSS for Reviews injected into header (wp_head)
* Stray checked tag removed from items in reviews output.
* Module: Reviews added - it allows you to create custom reviews of anything and show them (via shortcode) on a post or page.

= 2.0.+ =
* RUPs is now just Passwords.  Simply Exclude (SE) is now just Exclude.
* Added delete all button to Database cleaner to one-click delete all database clutter.
* Simply Exclude (SE) now automatically enables all post types.
* Tools section added to Main Control page.
* Database cleaner added to Tools section, which allows the admin to mass delete: post revisions, post drafts, trashed posts, unapproved comments, trashed comments, spam comments, unused tags, or unused categories at the push of a button.

= 1.0.+ =
* Added module to insert Google Analytics tracking code.
* Updated modules will need to be deactivated/reactivated for new options to be fully available upon upgrading.
* Modules updated: Simply Exclude (SE), Count++.
* Simply Exclude module updates - can now hide categories based on what day of the week it is.  (You will need to deactivate/reactive the module to take advantage of this.)
* Count++ module updates- tidied up settings page, displayed message can be customized.
* RUPs and Jump Around have had their pages tidied up.
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
* Removed global variables from modules.
* Due to the way RUPs handles the user defined salt, $theSalt global was left in (for admin convenience).
* Cleaned up code for all modules.
* Fixed: Number formatting (commas)
* Module update: Count++
* - 3 new functions added: output total words (numerical only), total remaining (numerical only), and total words in post (single post view only, numerical only)
* [This is just a test] removed / leftover (accidentally left in)
* 2 Uninstall methods: reset all and nuke.  
* Reset all erases all options associated with all modules.  
* Nuke erases all options associated with the plugin itself, which includes any separate tables it has created to store information for future usage.
* Module 4: Post as Front (PAF)
* - Select a specific post to be your home page, or make your home page your most recent post.
* Module 5: Jump Around
* - Navigate posts by pressing keys on the keyboard.
* Module 3: SE (Simply Exclude)
* - Exclude a single or comma-separated list of tags and categories from: front page, archives, search results, or feed.
* - can exclude tags, categories, and post formats.
* Official Plugin page updated, plugin page created.
* Version updates (plugin file)
* Checks for previously installed RUPs (standalone plugin).
* If RUPs is installed AND active, the RUPs module will be unavailable until the RUPs plugin is deactivated.
* Initial release.
* Module 1: Post Word Count (http://wordpress.org/plugins/post-word-count/)
* - added an options page to allow for word goal and word change.
* - updated code to only count words in published posts.
* Module 2: RUPs (Rotating Universal Passwords)
* - if you were using the original RUPs plugin, this module takes advantage of previous settings.
* - to continue using your same passwords, simiply delete the RUPs plugin folder, and activate the RUPs module.
