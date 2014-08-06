=== My Optional Modules ===
Contributors: boyevul
Tags: 4chan,gravatar,youtube,DNSBL,akismet,ipv4,ipv6,htmlpurifier,tripcode,sage,chan,capcodes,board,bbs,forum,anonymous,post,posting,user,submission,submitted,voting,votes,vote,rate,rating,post rating,post-rating,post-voting,year,day,month,archive,recycle,previous,fitvid,navbar,navigation,custom,youtube,video,redirect,404,redirect,maintenance,members,action,maintenance,simple,poll,polling,age,restrict,verify,gate,questions,verifier,verification,answers,quiz,scripts,javascript,footer,lazy,lazyload,twitter,google+,opengraph,meta,keywords,jquery,dynamic,no-js,collapse,expand,css-only,css,reviews,review,custom,tinymce,loggedin,hidecomments,hide,comments,restrict,commentform,commenttemplate,reddit,googlemaps,google,submit,button,share,gps,coords,embed,keyboardnavigation,post,homepage,frontpage,home,navigate,wordcount,wordgoal,countdown,total,rups,rotatinguniversalpasswords,sha512,encyrption,salt,exclusion,exclude,tags,categories,archives,postformats,post-formats,formats,hide
Requires at least: 3.9.1
Tested up to: 4.0
Stable tag: 5.5.6.9

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
* Exclude: hide tags, categories, and post formats from areas of the site (rss, front page, archives, search) with ability to also hide based on user level and whether or not the viewer is logged in.  Hide tags and categories based on what day of the week it is.  Custom 404 redirects for viewers who are logged in and viewers who are not.  Ability to hide the dashboard for everyone but admin.  Template function to display all categories except those that are hidden, which is also based on whether or not the user is logged in.  Ability to apply no follow, no index to hidden categories and all links in posts inside of those categories.
* Count++, a module to count words on the blog and countdown from an (optional) total count goal.
* Jump Around, a module that allows users to navigate posts by pressing keys on the keyboard.
* Maintenance, a module that allows you to specify a URL to redirect to for all non-logged in users while Maintenance Mode is active.
* Post as Front, a module that allows you to select a specific post to be your home page, or make your home page your most recent post.
* Passwords, a module for storing 7 unique passwords, and then hiding content with a shortcode (and IP based lockout) that is unlockable using the current days password.
* Reviews allows you to create custom reviews on anything you want, and display them on a post or a page.
* Shortcodes!, a module that adds useful shortcodes for posts and pages.
* Theme Takeover: Youtube 404; navbar that disables the Wordpress Admin Bar and gives you a bar similar to RES (with limited functionality)
* Post Voting: Add a vote box to each post via template function. (display top posts with a shortcode [topvoted]).

= Tweaks: =
* Analaytics automatic embedding.
* Automatically enable all images in posts and pages to use Lazy Load.
* Hide WP Version from enqueued scripts and stylesheets.
* Disable author archives (if only 1 author)
* Disable all date/time based archives
* Move JS to footer
* Attach linkbacks to all RSS feed items

= Meta: =
* Auto-generate meta tags (open-graph and otherwise).
* noarchive/nofollow on 404/search pages/archives.
* Disables Jetpack open graph.

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
* 5.5.6.9  Exclude (code cleanup)
* 5.5.6.8  addition: no comments (disables comments site-wide at the click of a button)
* 5.5.6.8  unregistered variable: vote fix (Post votes module)
* 5.5.6.8  Mini Loops addition: style: dropdown - list of post items with thumbnail, excerpt, and category links
* 5.5.6.8  Mini Loops addition: style: slider - show_link (1/0: whether or not to show link text by default) - link_content (text content of the link (default is the post title)
* 5.5.6.7  Takeover->Mini Loops (added) (shortcode: [mom_miniloop] - output a mini-loop of posts based on several configurable parameters
* 5.5.6.6  Fixed minor glitch in script enqueueing
* 5.5.6.5  Youtube for 404s removed (Takeover module)
* 5.5.6.4  Takeover additions: Ajax Comments & Comment Length Limiter
* 5.5.6.3  Hide Admin Menu was hiding from the wrong people. (fixed)
* 5.5.6.3  Fix Canon and Pretty Canon (left overs from the previous version of Regular Board) were removed (no longer used)
* 5.5.6.2  Admin interface reworked.
* 5.5.6.1  71 new icons added to Font Awesome (Font Awesome updated to current version)
* 5.5.6.1  Shortcodes page rewrite
* 5.5.6.0  Post voting automatically adds the vote box to the post
* 5.5.6.0  Variable:content fixed in Reviews Module
* 5.5.6.0  Takeover Module now correctly calls functionality only if it is actually activated
* 5.5.6.0  Horizontal Galleries (Takeover Module) added. Transforms [gallery] into a horizontal, single-column, scrollable container
* 5.5.6.0  Wowhead tooltips (Takeover Module) fixed to include the correct path
* 5.5.6.0  (correct) use of wp_register_scripts replaces previous (incorrect) use
* 5.5.5.9  Replace user_levels with current_user_can (roles)
* 5.5.5.8  Admin panel error involving database cleaner resolved
* 5.(.)    HTMLPurifier (added)
* 5.(.)    Regular Board (added)
* 5.(.)    All scripts (.js,script) moved to a single file, enqueued)
* 5.(.)    Minor bug fixes
* 5.(.)    'Module Breaking' bug squashed
* 5.(.)    Shortcode Verifier (added); Maintenance Mode (added); Plugin compatability check (added); FitVid (added); Page/Post lists from headers (added);
* 5.(.)    (Some files) have had 'unnecessary' whitespace removed
* 5.(.)    Interface overhaul (2)
* 5.(.)    Minor bug fixes
* 5.(.)    Cleanup from 4.x.x
* 5.(.)    Lazy Load (added); Meta (added); Theme Takeover(added)

* 4.(.)  Minor bug fixes
* 4.(.)  Shortcode progress bar (added);
* 4.(.)  Interface overhaul

* 3.(.)  Minor bug fixes
* 3.(.)  Code redundancies removed
* 3.(.)  Reviews (added);

* 2.(.)  Exclude now enables all post formats (automatically)
* 2.(.)  Database cleaner (added)
* 2.(.)  Minor bug fixes

* 1.(.)  Initial release
* 1.(.)  Official plugin support page created
* 1.(.)  Google Analytics (added); Exclude (added); Count++ (added); Shortcodes (added); Post as Front (added); Jump Around (added); Passwords (added)
* 1.(.)  Settings page 'tidied' up (Passwords/Jump AroundExclude)
* 1.(.)  Bug fixes (Post as Front, shortcodes
* 1.(.)  Simply Exclude module updates - can now hide categories based on what day of the week it is.  (You will need to deactivate/reactive the module to take advantage of this.)
* 1.(.)  Count++ module updates- tidied up settings page, displayed message can be customized.
* 1.(.)  Code cleaned