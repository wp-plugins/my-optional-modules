	<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	echo '
	<h1>My Optional Modules Plugin Help/Information</h1>
	<hr />
	<h1>Regular Board</h1>
	<p>Regular Board Files (/my-optional-modules/includes/modules) (note: all files begin with regular_board_ that pertain to Regular Board): activity_loops, admin_form_action, admin_panel, board_information, board_loop, board_stats, delete_post_action, help, post_action, post_form, post_voting, posting_checkflood, posting_deletepost, posting_userbanned, profile_loop, single, user_loop, user_options</p>
	<p>When activating Regular Board, you will also want to activate the following modules: Font Awesome, Fix Canon, and Pretty Canon. Fix canon and pretty canon attempt to fix the canonical linking to correspond with the URLs that Regular Board uses to display boards and threads and provide Open Graph support for social media sites, while Font Awesome is a special font used throughout the code.</p>
	<p>Shortcode attributes: [regularboard]</p>
	<p>bannedmessage, postedmessage, enableurl, enablerep, maxbody, maxreplies, maxtext, boards, userflood, imgurid</p>
	<p>bannedmessage/postedmessage (text-string) bannedmessage displays to users who are banned (default: YOU ARE BANNED) while postedmessage displays to users when they have made a successful post (default: POSTED!!!).</p>
	<p>enableurl/enablerep (1 = on, 0 = off) enables (or disables) URL embedding on new posts (enableurl) or replies (enablerep).</p>
	<p>maxbody/maxreplies/maxtext (integer) Maximum characters in comment (maxbody), replies per thread (maxreplies), and characters in text-fields (maxtext) (defaults: 1800, 500, 75)</p>
	<p>userflood (comma-separated listing of WordPress usernames) is a list of users who can bypass the flood gate (mechanism designed to keep users from flooding the board).</p>
	<p>imgurid is tied to the Imgur API (register an application with anonymous usage without user authorization and use the application ID for this attribute). imgurid enables an upload form to upload directly to Imgur from your board installation.</p>
	<p>Creating boards: In order to access the admin panels, you must be logged in on your main (admin) WordPress account. When logged in, the admin link will be available.</p>
	<p>When creating a new board, the following fields are available: shortname, expanded board name, short description, user moderators, user janitors, rules…, posting enabled/posting disabled, safe-for-work/not-safe-for-work, everyone may interact/logged-in users only. While some of these are self-explanatory, the following fields are of main importance: shortname (this will be the part of the URL that you use to go directly to the board. shortname b will result in a URL of ?b=b while shortname board will results in ?b=board. User moderators and User janitors are comma separated lists of WordPress usernames. User moderators can do everything the moderator (main admin) can do, apart from interact with the admin menu (this means deleting threads, banning users, and locking and stickying threads. User janitors can only delete threads. If a board is set to logged-in users only, this means the board can only be interacted with by users who are logged in.</p>
	<p>IP addresses can be banned manually by going to Manage bans from the admin screen, either by inputting a long form of the IP or the regular format of an IP address.</p>
	<p>When a thread is reported, it will show up in View reports. If you are logged in as admin, you will also see a notification at the top of the screen alerting you to the fact that reports need your attention.</p>
	<hr />
	';
	
	?>