=== My Optional Modules ===
Contributors: boyevul
Tags: 4chan,gravatar,youtube,DNSBL,akismet,ipv4,ipv6,htmlpurifier,tripcode,sage,chan,capcodes,board,bbs,forum,anonymous,post,posting,user,submission,submitted,voting,votes,vote,rate,rating,post rating,post-rating,post-voting,year,day,month,archive,recycle,previous,fitvid,navbar,navigation,custom,youtube,video,redirect,404,redirect,maintenance,members,action,maintenance,simple,poll,polling,age,restrict,verify,gate,questions,verifier,verification,answers,quiz,scripts,javascript,footer,lazy,lazyload,twitter,google+,opengraph,meta,keywords,jquery,dynamic,no-js,collapse,expand,css-only,css,reviews,review,custom,tinymce,loggedin,hidecomments,hide,comments,restrict,commentform,commenttemplate,reddit,googlemaps,google,submit,button,share,gps,coords,embed,keyboardnavigation,post,homepage,frontpage,home,navigate,wordcount,wordgoal,countdown,total,rups,rotatinguniversalpasswords,sha512,encyrption,salt,exclusion,exclude,tags,categories,archives,postformats,post-formats,formats,hide
Requires at least: 3.8
Tested up to: 3.8
Stable tag: 5.4.9.2.7

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
* Passwords, a module for storing 7 unique (SHA512 salted) passwords, and then hiding content with a shortcode (and IP based lockout) that is unlockable using the current days password.
* Reviews allows you to create custom reviews on anything you want, and display them on a post or a page.
* Shortcodes!, a module that adds useful shortcodes for posts and pages.
* Theme Takeover: Youtube 404; navbar that disables the Wordpress Admin Bar and gives you a bar similar to RES (with limited functionality)
* Post Voting: Add a vote box to each post via template function. (display top posts with a shortcode).  

= Regular Board = 
* Regular Board is beta software.  There is bound to be bugs in it.
* [Regular Board Support Forum](http://regularboard.org/r) located @ [regularboard.org](http://regularboard.org)
* Disclaimer: may not work with all installations as CSS may need to be tweaked on a THEME level.
* Can set board to private (logged in users only)
* Supports Youtube/Youtu.be/image embedding (via URL)
* Supports DNSBL/Akismet/IPv4 and IPv6 validation (autobans DNSBL/Akismet results, disables posting for IP addresses that aren't IPv4/IPv6 valid)
* Supports Tripcodes and saging
* Unlike other *chan scripts, the important details that are inserted into the database are handled server-side, not client side with hidden fields.
* Capcodes for logged in mods
* Deployed via [shortcode]

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
* Regular Board (force update tables from admin)
* Additions
* User profiles for every user that posts. Highlights 10 recent images, 10 most approved threads and replies, and user milestones (board admin created achievements that are tracked by both post count and approval rating, and creating using the Reviews module).
* Reviews module has been integrated with the new user profiles. Board admins can specify achievements based on both karma (by creating a review of type of karma, the achievement title being the title of the review, and the necessary heart amount as the rating (with optional body content) or by creating a review of type activeposts, the achievement title being the title of the review, and the necessary post amount as the rating (with optional body content)) to display milestones on the user's profile.
* Automute will mute the user for 10 minutes (a mute is a temporary ban) if they try to submit an unoriginal comment 5 times (over any given period of time). Unoriginal comments are comments that already exist on the board.
* Disapprove buttons added, and the text for the buttons has been removed. (They are now just thumbs up and thumbs down icons)
* Changes
* _front properly tracks latest replies and threads without doubling output of thread if the latest reply is to a parent thread (previously listed by field LAST, now lists by field DATE).
* Board information, links, etc. has been moved to a collapsed section to the side of the main content to center focus on that content. Board navigation added to the top to allow navigation while this area is collapse.
* Sisyphus removed as it was causing issues with the editing of posts and replies.
* SFW/NSFW removed from [shortcode] in favor of new SFW designation when creating a board. Designate the board as either NSFW or SFW. (Requires a Force Update Tables).
* HTML formatting swapped for Reddit-style formatting (removes HTML tags from the equation). New formatting help available below the comment form.
* Banning a user no longer deletes all of their posts.
* Automuting pays attention to duplicate comments as well as duplicate URLs.
* Empty comments can be made as long as a unique URL is attached.
* Updates
* Youtube embedding has been changed. If you have Youtube embeds, you will need to manually edit them in the database to retain the video IDs and get rid of the iframe HTML code. This is all handled outside of the database now.
* Bugfix: When editing a post, upon successful edits, user is redirected back to the post.
* Time since had a minor bug (threads were trying to grab data for the date before it was actually available) making the time ago time stamp wrong. fixed
* Setting max replies to 0 no longer forces the form for new threads to quit functioning correctly.
* Stats should now be tracking videos, images, and URLs correctly.
* CSS updated so that certain comment/image combinations wouldn't push the comment past the edge of the screen.
* CSS updated so that the board would adapt better to certain themes.


= .5 =
* HTMLPurifier (added)
* Regular Board (added)
* All scripts (.js,script) moved to a single file, enqueued)
* Minor bug fixes
* 'Module Breaking' bug squashed
* Shortcode Verifier (added); Maintenance Mode (added); Plugin compatability check (added); FitVid (added); Page/Post lists from headers (added);
* (Some files) have had 'unnecessary' whitespace removed
* Interface overhaul (2)
* Minor bug fixes
* Cleanup from 4.x.x
* Lazy Load (added); Meta (added); Theme Takeover(added)

= .4 = 
* Minor bug fixes
* Shortcode progress bar (added);
* Interface overhaul

= .3 =
* Minor bug fixes
* Code redundancies removed
* Reviews (added);

= .2 =
* Exclude now enables all post formats (automatically)
* Database cleaner (added)
* Minor bug fixes

= .1 =
* Initial release
* Official plugin support page created
* Google Analytics (added); Exclude (added); Count++ (added); Shortcodes (added); Post as Front (added); Jump Around (added); Passwords (added)
* Settings page 'tidied' up (Passwords/Jump AroundExclude)
* Bug fixes (Post as Front, shortcodes
* Simply Exclude module updates - can now hide categories based on what day of the week it is.  (You will need to deactivate/reactive the module to take advantage of this.)
* Count++ module updates- tidied up settings page, displayed message can be customized.
* Code cleaned