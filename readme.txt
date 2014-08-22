=== My Optional Modules ===
Contributors: boyevul
Tags: front, home, database, cleaner, disable, comments, RSS, javascript, footer, archives, author, ajax, font awesome, lazy load, horizontal, gallery, hide, version, mini, loop, exclude, category, tag, post format
Requires at least: 3.9.1
Tested up to: 4.0
Stable tag: 5.6.1.2

An assortment of functions to enhance WordPress.

== Description ==
MOM features an assortment of functions designed to add (or extend) functionality within WordPress.

= 5.5.X -> 5.6 =
I felt that MOM was drastically out of whack with what I had originally intended for this plugin. The need 
for course correction was immediate; a hefty amount of internal code was slashed entirely. Only the core 
functionality (the functionality that I felt was not only done well, but embodied the spirit of why I began 
this project in the first place) was kept. 5.6 marks a new direction for MOM.

= Modules: =
* Ability to set a blog post as your front page
* Clear database clutter at the push of a button
* Disable comments sitewide 
* Append a link back to your RSS items
* Disable author and date-based archives
* Hide categories, tags, and post formats from almost anywhere on your blog
* ..and more

== Installation ==
= 3-step installation =
1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it.
4. You'll find settings under Dashboard->Settings->My Optional Modules

== Screenshots ==
1. Horizontal gallery (Takeover->Horizontal Galleries)(Theme: Twenty Fourteen)
2. 'dropdown' style mini-loop (Takeover->Mini Loops) (Theme: Twenty Fourteen)
3. 'list' style mini-loop w/ post vote display (Post Votes module enabled) (Theme: Twenty Fourteen)

== Changelog ==
* 5.6.1.2  miniloop shortcode functionality call to action misplaced
* 5.6.1.1  Admin page CSS @media queries for better display
* 5.6.1    All unused code from 5.5.X has been removed
* 5.6.1    All uninstallation functionality that has been outdated for quite some time now has been removed
* 5.6      Removed: (1) count++ (2) Shortcodes (3) Navbar (4) Post Votes (5) Meta (6) Maintenance Mode (7) Wowhead (8) Fitvids (9) Analytics (10) Passwords (11) Reviews (12) Jump Around (13) Takeover
* 5.5.8.3  Navbar CSS changes.
* 5.5.8.2  [mom_miniloops]/series widget should only be attempting to output if in post and the key is properly defined
* 5.5.8.1  Module->Meta better handling for information when 404
* 5.5.8.1  Module->Takeover->Miniloop [style: slider] post thumbs changed to scale more appropriately
* 5.5.8.0  unclosed em element closed in Module->Takeover->Miniloops.
* 5.5.8.0  deprecated function replaced in Module->Takeover->Navbar
* 5.5.7.9  [mom_miniloops]:: style 'dropdown' (REMOVED) / 'columns' (excerpt removed from output) / code updated to allow proper positioning in content 
* 5.5.7.9  [mom_archives] shortcode information added to module->Shortcodes (with minor CSS tweaks to the output)
* 5.5.7.8  Comma separated list of pages and posts can now be specified for maintenance URL (instead of just site-wide maintenance)
* 5.5.7.7  Series styles removed as only list was translating properly to widget
* 5.5.7.7  Series posts working correctly, as wrong values were being grabbed previously
* 5.5.7.6  Series changed to widget
* 5.5.7.5  Series: append a miniloop to the bottom of posts based on a meta key (for instance, all posts with a metakey "series" have a loop of those posts attached to them, excluding the currently viewed post)
* 5.5.7.5  [mom_miniloop] meta parameters added ( the NAME of a meta key that you wish to pull posts associated with)
* 5.5.7.5  [mom_miniloop] key parameters added ( the VALUE of a meta key that you wish to pull posts associated with)
* 5.5.7.5  key and meta may be combined to pull posts that meet BOTH values (like, for example, a series of posts sharing the same meta keys/values)
* 5.5.7.4  [mom_miniloop] vote parameters added (0 (off) 1 (on) (default: 0)) display upvote count for posts in the loop
* 5.5.7.4  [mom_miniloop] style added: list for an ordered list of posts
* 5.5.7.3  removed: shortcode [mom_verify]
* 5.5.7.3  removed: 'top x posts' from [topvoted] shortcode (Post votes module)
* 5.5.7.2  removed: function: mom_onthisday_template (for use in templates) (use do_shortcode mom_onthisday to replace functionality previously provided by mom_onthisday_template
* 5.5.7.2  [mom_onthisday] no longer uses post thumbnails in its output, and the default CSS for this module has been changed so that it is 100% the width of whatever its parent container is
* 5.5.7.1  If Font Awesome is not turned on, but Post Voting is, it will enqueue the Font Awesome CSS (because the vote buttons rely on it)
* 5.5.7.1  Changed how Post Voting is initiated to work better with other plugins that utilize content filtering.
* 5.5.7.0  Fixed wording on 'Hide Tags from.." portion of exclude (Tag archives was supposed to be Category archives)
* 5.5.7.0  Post voting (downvotes added) (functionality slightly changed to work better and to accommodate downvoting)
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