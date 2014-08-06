=== My Optional Modules ===
Contributors: boyevul
Tags: reviews,count,exclude,jump,shortcode,takeover,password,comments,vote,feed,font awesome,hide,version,footer,lazy load,meta,disable,authors,dates,maintenance,analytics,gallery,google maps,reddit,restrict,progress,verifier,loop,mini,ajax,fitvid,navbar,share,bg,wowhead,jquery,tag,category,format,hide,sunday,monday,tuesday,wednesday,thursday,friday,saturday,front page,tag archives,search results,logged out,subscriber,contributor,author,category archive
Requires at least: 3.9.1
Tested up to: 4.0
Stable tag: 5.5.7.0

A bundle of optional Wordpress modules to enhance functionality.

== Description ==
My Optional Modules (or MOM) is a bundle of optional modules for Wordpress which give extra functionality not currently available in a fresh installation. 
They are designed to be lightweight and easilly implemented by even the most novice of Wordpress users.

= Adaptations =
* The following modules could not have existed without the work from previous plugins and authors:
* 'Count++': adapted from [Post Word Count](http://wordpress.org/plugins/post-word-count/) by [Nick Momrik](http://profiles.wordpress.org/nickmomrik/).
* 'Google Maps' [shortcodes]: adapted from [Very Simple Google Maps](http://wordpress.org/plugins/very-simple-google-maps/) by [Michael Araonoff](http://profiles.wordpress.org/masterk/).

= Modules: =
* 'Reviews': Create small reviews and display them in their own configurable loops.
* 'Count': Template tag for outputting blog and post word counts.
* 'Exclude': Exclude post categories, tags, and types from different areas based on different parameters.
* 'Jump Around': Enables post navigation using the keyboard.
* 'Shortcodes': A variety of different shortcodes that provide different functionality.
* 'Takeover': Different additions that add functionality to your theme.
* 'Passwords': Passwords that rotate on a daily basis to hide content with a shortcode.
* 'Analytics': Automatic Google analytics installation via UA-ID.
* 'No Comments': Disable comments site-wide at the click of a button.
* 'Post votes': Enable voting on posts, like Reddit.
* '&copy; RSS feed': Add a link back to your blog on all of your RSS feed items.
* 'Font Awesome': Enable the of Font Awesome for your posts.
* 'Hide WP Version': Strips the WordPress version out of your viewable source.
* 'JS to footer': Move all javascript in your theme to the footer.
* 'Lazy Load': Enable lazy load for images.
* 'Meta': Enable automatic open graph integration for posts.
* 'Disable Authors': Disable author archives if there is only one author.
* 'Disable Dates': Disable date based archives.
* 'Maintenace': Redirect non-logged in users to a specified URL while admin can still view the blog.

== Installation ==
= 3-step installation =
1. Upload /my-optional-modules/ to your plguins folder.
2. Navigate to your plugins menu in your Wordpress admin.
3. Activate it.
4. You'll find settings under Dashboard->Settings->My Optional Modules

== Screenshots ==
1. Horizontal gallery (Takeover->Horizontal Galleries)(Theme: Twenty Fourteen)
2. 'dropdown' style mini-loop (Takeover->Mini Loops) (Theme: Twenty Fourteen)

== Changelog ==
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