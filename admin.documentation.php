<?php 
if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
} ?>


<p>
	Plugin Documentation
</p>

<hr />

<p>
	Like this plugin? Don't forget to <a href="//wordpress.org/support/view/plugin-reviews/my-optional-modules">rate</a> it! 
	Want to report a problem? Head to the <a href="//wordpress.org/support/plugin/my-optional-modules">support forum</a>.
</p>

<hr />

<p>
	Trash Removal
</p>
<p>
	<code>Revisions + AutoDrafts</code> removes post revisions and auto-drafts from the database.<br />
	<code>Comments</code> removes spam comments, unapproved comments, and trashed comments.<br />
	<code>Orphan Tags + Categories</code> removes tags and categories that have 0 posts associated with them.<br />
	<code>Drafts</code> removes post drafts.<br />
	<code>All trash</code> removes all of the above, except for drafts.<br />
	<code>Optimize tables</code> removes overhead from your database.
</p>

<hr />

<p>
	Disable<br /><br />
	<code>Plugin CSS</code> disables the plugins CSS file from being included.<br />
	<code>Comment form</code> disables comments sitewide.<br />
	<code>Unnecessary code</code> removes version information, stylesheet IDs, and head junk, as well as 
	enqueues JQUERY from a CDN (instead of locally)<br />
	<code>Pingbacks</code> disables pingbacks.<br />
	<code>Author Archives</code> disables author archives if there is only one author on the site.<br />
	<code>Date Archives</code> disables date archives.
</p>

<hr />

<p>
	Enable<br /><br />
	<code>Meta Tags</code> enables Open Graph tags.<br />
	<code>Horizontal Galleries</code> transform image galleries into horizontal slider galleries.<br />
	<code>Font Awesome</code> enables Font Awesome.<br />
	<code>Social Links</code> enables scriptless social sharing links.<br />
	<code>RSS Linkbacks</code> appends a link back to your site on all RSS items.<br />
	<code>404s-to-home</code> redirects all 404s to the homepage.
</p>

<hr />

<p>
	Comment form<br /><br />
	<code>DNSBL</code> blocks comment forms from IPs listed on a DNS Blacklist.<br />
	<code>Spam trap</code> adds an extra hidden field to the comment form to trick bots.<br />
	<code>Ajax</code> makes it so commenting doesn't refresh the page.
</p>

<hr />

<p>
	Extras<br /><br />
	<code>External thumbnails</code> is <a href="https://wordpress.org/plugins/external-featured-image/">Nelio Featured Image</a> with [mom_embed]/oEmbed support.<br />
	<code>Full-width feature images</code> attempts to make the feature image 100% of its parent container.<br />
	<code>Javascript-to-footer</code> moves Javascripts to the footer.<br />
	<code>Lazyload</code> enables <a href="https://github.com/tuupola/jquery_lazyload">Lazyload</a> for post images.<br />
	<code>Recent Posts Widget</code> alters the behavior of the default Recent Posts Widget to exclude the post currently being viewd (in single post)<br />
	<code>Enable Exclude Posts</code> enables the exclude posts module, which allows you to exclude posts from almost anywhere on the site.
</p>
	
<hr />

<p>
	Theme Extras<br /><br />
	<code>Front page is..</code> changes your front page to a specific post or the latest post.<br />
	<code>Previous link class</code> and <code>next link class</code> apply a .class to the previous and next page links<br />
	<code>Read more.. value</code> changes the value of 'Read more...' on excerpts. %blank% for blank.<br />
	<code>yoursite.tld/?random keyword</code> allows yout specify a keyword to attach to a URL (as exampled) to take you to a random post.</code>
	<code>Random::site::titles</code> allows you create a list of random site titles to rotate to (site title 1::site title 2::site title 3::and so on)<br />
	<code>Random::site::description</code> is the same as random::site:;titles, except for the description.
</p>

<hr />

<p>
	<code>Save</code> saves all options.<br />
	<code>Reset</code> resets ALL options (after confirmation)<br />
	<code>Uninstall</code> is the same as reset, except it also primes your installation for the complete removal of this plugin (after confirmation)
</p>

<hr />

<p>
	Shortcodes
</p>

<p>
	<code>[mom_embed]</code><br />
	<code>url</code>   URL of media to embed<br />
	<code>class</code> Optional class for the container of the media<br /><br />
	Supported media:<br />
		Image links<br />
		Imgur albums<br />
		Youtube/youtu.be (?t parameter also supported)<br />
		Soundcloud<br />
		Vimeo<br />
		Gfycat<br />
		Funnyordie<br />
		Vine<br />
		All WordPress supported <a href="http://codex.wordpress.org/Embeds">embeds</a>
</p>
<p>
	<code>[mom_attachments]</code> inserts a loop of recent images that link to their respective posts.<br />
	Defaults: <code>[mom_attachments amount="1" class="" ]</code><br /><br />
	<span><code>amount</code> How many images to show.<br />
	<span><code>class</code> The .class of the links, for CSS purposes.<br />
</p>

<p>
	<code>[mom_miniloop]</code><br />
	Defaults: <code>[mom_miniloop paging="0" show_link="1" month="" day="" year="" meta="series" key="" link_content="" amount="4" style="tiled" offset="0" category="" orderby="post_date" order="DESC" post_status="publish" cache="false"]</code><br /><br />
	<code>paging</code> 1 (on) / 0 (off)<br />
	<code>show_link</code> 1 (on) / 0 (off)<br />
	<code>month</code> 1-2 digit date / <code>123</code> for today's date<br />
	<code>day</code> 1-2 digit date / <code>123</code> for today's date<br />
	<code>year</code> 1-4 digit date / <code>123</code> for today's date<br />
	<code>meta</code> a meta-key name.<br />
	<code>key</code> a meta-key value.<br />
	<code>link_content</code> Text of the permalink to the post.<br />
	<code>amount</code> How many posts to show in the loop.<br />
	<code>style</code> <em>columns, list, slider, tiled</em><br />
	<code>offset</code> How many posts to skip ahead in the loop.<br />
	<code>category</code> Category ID(s) or names (comma-separated if multiple values).<br />
	<code>orderby</code> Order posts in the loop by a <a href="//codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">particular value</a>.<br />
	<code>order</code> <em>ASC</em> (ascending) or <em>DESC</em> (descending)<br />
	<code>post_status</code> Display posts based on their <a href="//codex.wordpress.org/Class_Reference/WP_Query#Status_Parameters">status</a>.<br />
	<code>cache</code> Cache the results of this loop. <em>true</em> or <em>false</em>.<br />
</p>

<hr />

<p>
	Theme Developers may use the following functions in your themes for additional functionality.<br /><br />
	<code>my_optional_modules_exclude_categories()</code> for a category list that hides categories based on your Exclude Taxonomies: Exclude Categories settings.<br /><br />
	<code>new mom_mediaEmbed( 'MEDIA URL' )</code> for media embeds with <a href="http://codex.wordpress.org/Embeds">oEmbed</a> fallback (supports imgur image links AND albums, youtube/youtu.be (with ?t parameter), soundcloud, vimeo, gfycat, funnyordie, and vine).
</p>