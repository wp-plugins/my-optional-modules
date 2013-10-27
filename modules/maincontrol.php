<?php 

	// Main Control Panel
	// MCP contents
	// options page
	//   - options form (save)
	//   - options form (output)
	//   - options page (output)
	// set home page post content

	if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }
		
	// Check if admin or not
	if (is_admin() ) { 

		// options page
		add_action("admin_menu", "my_optional_modules_add_options_page");
		function my_optional_modules_add_options_page() { $myoptionalmodules_options = add_options_page("My Optional Modules", "My Optional Modules", "manage_options", "mommaincontrol", "my_optional_modules_page_content"); }	
	
		// options form (save)
		function update_myoptionalmodules_options() {
			if(isset($_POST['momsave'])){
				if ($_REQUEST["mommaincontrol_uninstall_all"] == 1 || $_REQUEST["mommaincontrol_uninstall_all"] == 3 || $_REQUEST["mommaincontrol_uninstall_all"] == 4 || $_REQUEST["mommaincontrol_uninstall_all"] == 5) {
					include('_uninstall.php');
				} else {					
					include('_install.php');
				}
			}
		}
		
		// options form (output)
		function my_optional_modules_form() {
		echo "
		<div class=\"panelSection clear\">
			<div class=\"panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-link\"></i> Analytics</span>
					<select id=\"mommaincontrol_analytics\" type=\"text\" name=\"mommaincontrol_analytics\"><option value=\"0\" "; if (get_option("mommaincontrol_analytics") == 0) { echo "selected=\"selected\""; } echo ">Off</option> <option value=\"1\" "; if (get_option("mommaincontrol_analytics") == 1) { echo "selected=\"selected\""; } echo ">On</option> </select>
				</section>";
				if (get_option("mommaincontrol_analytics") == 0) { echo "<p>Insert your Google Analytics tracking code.</p>"; }
				if (get_option("mommaincontrol_analytics") == 1) { include('analytics.php'); }	
			echo "</div>
			<div class=\"panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-bar-chart-o\"></i> Count++</span>
					<select id=\"mommaincontrol_obwcountplus\" type=\"text\" name=\"mommaincontrol_obwcountplus\"><option value=\"0\" "; if (get_option("mommaincontrol_obwcountplus") == 0) { echo "selected=\"selected\""; } echo ">Off</option> <option value=\"1\" "; if (get_option("mommaincontrol_obwcountplus") == 1) { echo "selected=\"selected\""; } echo ">On</option> </select>
				</section>
				<p>Count all words published with optional total word goal.</p>
			</div>
			<div class=\"info panel left\">
				<section class=\"title clear\">
					<span><i class=\"fa fa-book\"></i> Modules</span>
				</section>
				<p>Modules to add functionality to your Wordpress installation.</p>
			</div>	
		</div>
		<div class=\"panelSection clear\">
		<div class=\"panel left\">
		";			
		if(is_plugin_active('jump-around/jumparound.php')){
		echo "
			<section class=\"title clear\">
				<span>Jump Around</span>
			</section>
			<p>You currently have the standalone version of Jump Around installed and active.  Please disable and delete it to use this module.</p>
		"; } else {			
		echo "
			<section class=\"title clear\">		
				<span><i class=\"fa fa-gamepad\"></i> Jump Around</strong></span>
				<select id=\"mommaincontrol_momja\" type=\"text\" name=\"mommaincontrol_momja\"><option value=\"0\" "; if (get_option("mommaincontrol_momja") == 0) { echo "selected=\"selected\""; } echo ">Off</option> <option value=\"1\" "; if (get_option("mommaincontrol_momja") == 1) { echo "selected=\"selected\""; } echo ">On</option> </select>
			</section>
			<p>Navigate posts by pressing keys on the keyboard. (<strong>May require template editing</strong>)</p>
		";
		}		
		
		echo "
		</div>
		<div class=\"panel left\">
			<section class=\"title clear\">		
				<span><i class=\"fa fa-thumbs-up\"></i> Reviews</span>
				<select id=\"mommaincontrol_reviews\" type=\"text\" name=\"mommaincontrol_reviews\"><option value=\"0\" "; if (get_option("mommaincontrol_reviews") == 0) { echo "selected=\"selected\""; } echo ">Off</option> <option value=\"1\" "; if (get_option("mommaincontrol_reviews") == 1) { echo "selected=\"selected\""; } echo ">On</option> </select>
			</section>
			<p>Rate and review anything, and display a specialized list of reviews via shortcode.</p>
		</div>
		<div class=\"panel left\">
			<section class=\"title clear\">		
				<span><i class=\"fa fa-thumb-tack\"></i> Post as Front</strong></span>
				<select id=\"mommaincontrol_mompaf\" type=\"text\" name=\"mommaincontrol_mompaf\"><option value=\"0\" "; if (get_option("mommaincontrol_mompaf") == 0) { echo "selected=\"selected\""; } echo ">Off</option> <option value=\"1\" "; if (get_option("mommaincontrol_mompaf") == 1) { echo "selected=\"selected\""; } echo ">On</option> </select>
			</section>
		";
		if (get_option("mommaincontrol_mompaf") == 0) { echo "<p>Select a specific post to be your home page, or make your home page your most recent post.</p>"; }
		// Post as Front
		if (get_option("mommaincontrol_mompaf") == 1) { include('postasfront.php'); }	
			
		echo "
		</div>
		</div>
		<div class=\"panelSection clear\">";
		if(is_plugin_active('rotating-universal-passwords/RUPs.php')){ 
		
		} else {
			echo "
			<div class=\"panel left\">
				<section class=\"title clear\">		
					<span><i class=\"fa fa-lock\"></i> Passwords</span>
					<select id=\"mommaincontrol_momrups\" type=\"text\" name=\"mommaincontrol_momrups\"> <option value=\"0\" "; if (get_option("mommaincontrol_momrups") == 0) { echo "selected=\"selected\""; } echo ">Off</option> <option value=\"1\" "; if (get_option("mommaincontrol_momrups") == 1) { echo "selected=\"selected\""; } echo ">On</option>  </select>
				</section>
				<p>Hide password-protected content using [rups]the shortcode[/rups].  Passwords are rotated once per day.</p>
			</div>
			";
		}

		echo "
			<div class=\"panel left\">
				<section class=\"title clear\">		
					<span><i class=\"fa fa-pencil\"></i> Shortcodes!</span>
					<select id=\"mommaincontrol_shorts\" type=\"text\" name=\"mommaincontrol_shorts\"><option value=\"0\""; if ( get_option("mommaincontrol_shorts") == 0 ) { echo "selected=\"selected\""; } echo ">Off</option><option value=\"1\""; if ( get_option("mommaincontrol_shorts") == 1 ) { echo "selected=\"selected\""; } echo ">On</option></select>
				</section>	
				<p>A collection of various shortcodes that you can use in your posts and pages.</p>
			</div>
			
			<div class=\"panel left\">
				<section class=\"title clear\">
						<span><i class=\"fa fa-minus\"></i> Exclude</span>
						<select id=\"mommaincontrol_momse\" type=\"text\" name=\"mommaincontrol_momse\"><option value=\"0\" "; if (get_option("mommaincontrol_momse") == 0) { echo "selected=\"selected\""; } echo ">Off</option> <option value=\"1\" "; if (get_option("mommaincontrol_momse") == 1) { echo "selected=\"selected\""; } echo ">On</option></select>
				</section>
				<p>Exclude tags, post formats, and categories from anywhere on your blog.</p>
			</div>
		</div>
		
		<div class=\"panelSection clear new\">
				<div class=\"info panel left\">
					<section class=\"title clear\">
						<span><i class=\"fa fa-wrench\"></i> Tweaks</span>
					</section>
					<p>Tweaks for your current theme, no configuration required.</p>
				</div>
				<div class=\"panel left\">
					<section class=\"title clear\">
						<span><i class=\"fa fa-flag\"></i> Font Awesome</span>
						<select id=\"mommaincontrol_fontawesome\" type=\"text\" name=\"mommaincontrol_fontawesome\"><option value=\"0\" "; if (get_option("mommaincontrol_fontawesome") == 0) { echo "selected=\"selected\""; } echo ">Off</option><option value=\"1\" "; if (get_option("mommaincontrol_fontawesome") == 1) { echo "selected=\"selected\""; } echo ">On</option></select>
					</section>
					<p>Enable <a href=\"http://fortawesome.github.io/Font-Awesome/\">Font Awesome</a> on your theme, allowing you to use all available <a href=\"http://fortawesome.github.io/Font-Awesome/icons/\">icons</a>.</p>
				</div>
				<div class=\"panel left\">
					<section class=\"title clear\">
						<span><i class=\"fa fa-cog\"></i> Hide WP Version</span>
						<select id=\"mommaincontrol_versionnumbers\" type=\"text\" name=\"mommaincontrol_versionnumbers\"><option value=\"0\" "; if (get_option("mommaincontrol_versionnumbers") == 0) { echo "selected=\"selected\""; } echo ">Off</option><option value=\"1\" "; if (get_option("mommaincontrol_versionnumbers") == 1) { echo "selected=\"selected\""; } echo ">On</option></select>
					</section>
					<p>Hide Wordpress version number from enqueued scripts and stylesheets on the front end of your website.</p>
				</div>
		</div>
		
		<div class=\"panelSection clear new\">
				<div class=\"important panel left\">
					<section class=\"title clear\">
						<span><i class=\"fa fa-bolt\"></i> All</span>
						<select id=\"mommaincontrol_uninstall_all\" type=\"text\" name=\"mommaincontrol_uninstall_all\"><option value=\"0\"></option> <option value=\"4\">Activate all</option> <option value=\"5\">Deactivate all</option> <option value=\"1\">Reset all</option> <option value=\"3\">Nuke</option> </select>
					</section>
					<p>Control all modules.  Use nuke to completely uninstall this plugin.</p>
				</div>
		";
		
	if(isset($_POST['momsave']) || isset($_POST['mompafsave'])){
		echo "
		<div class=\"panel left\">
			<section class=\"title clear\">
				<span><i class=\"fa fa-floppy-o\"></i> Saved</span>
				<input id=\"momsave\" class=\"right button button-primary\" type=\"submit\" value=\"Go\" name=\"momsave\">				
			</section>
			<p>All settings saved.</p>
		</div>
		";	
	} else {
		echo "
		<div class=\"panel left\">
			<section class=\"title clear\">
				<span><i class=\"fa fa-floppy-o\"></i> Save</span>
				<input id=\"momsave\" class=\"right button button-primary\" type=\"submit\" value=\"Go\" name=\"momsave\">
			</section>
			<p>Save all module settings.</p>
		</div>
		";
		}
	echo "
		<div class=\"info panel left\">
			<section class=\"title clear\">
				<span><i class=\"fa fa-heart\"></i> MoM?</span>
			</section>
			<p><a href=\"http://wordpress.org/support/view/plugin-reviews/my-optional-modules\">Rate and review it</a> on Wordpress &mdash; it'd be greatly appreciated!</p>
		</div>	
	</div>";
	}
	
		// options form (output)
function my_optional_modules_page_content() {

	if ( get_option("mommaincontrol_obwcountplus") == 1 || get_option("mommaincontrol_momse") == 1 || get_option("mommaincontrol_momrups") == 1 || get_option("mommaincontrol_momja") == 1 || get_option("mommaincontrol_shorts") == 1 || get_option("mommaincontrol_reviews") == 1 ) { 
		echo "<div class=\"leftMenu\"><form method=\"post\">
		<label for=\"MOMclear\"><i class=\"fa fa-refresh\"></i></label><input id=\"MOMclear\" name=\"MOMclear\" type=\"submit\">
		";
			if ( get_option("mommaincontrol_obwcountplus") == 1 ) { echo "<label for=\"MOMcount\"><i title=\"Count++ settings\" class=\"fa fa-bar-chart-o"; if ( get_option('mommaincontrol_focus') == "count" ) { echo " active"; } echo "\"></i></label><input id=\"MOMcount\" name=\"MOMcount\" type=\"submit\">"; }
			if ( get_option("mommaincontrol_momse") == 1 ) { echo "<label for=\"MOMexclude\"><i title=\"Exclude settings\" class=\"fa fa-minus"; if ( get_option('mommaincontrol_focus') == "exclude" ) { echo " active"; } echo "\"></i></label><input id=\"MOMexclude\" name=\"MOMexclude\" type=\"submit\">"; }
			if ( get_option("mommaincontrol_momrups") == 1 ) { echo "<label for=\"MOMpasswords\"><i title=\"Passwords settings\" class=\"fa fa-lock"; if ( get_option('mommaincontrol_focus') == "passwords" ) { echo " active"; } echo "\"></i></label><input id=\"MOMpasswords\" name=\"MOMpasswords\" type=\"submit\">"; }
			if ( get_option("mommaincontrol_momja") == 1 ) { echo "<label for=\"MOMjumparound\"><i title=\"Jump Around settings\" class=\"fa fa-gamepad"; if ( get_option('mommaincontrol_focus') == "jumparound" ) { echo " active"; } echo "\"></i></label><input id=\"MOMjumparound\" name=\"MOMjumparound\" type=\"submit\">"; }
			if ( get_option("mommaincontrol_reviews") == 1 ) { echo "<label for=\"MOMreviews\"><i title=\"Reviews settings\" class=\"fa fa-thumbs-up"; if ( get_option('mommaincontrol_focus') == "reviews" ) { echo " active"; } echo "\"></i></label><input id=\"MOMreviews\" name=\"MOMreviews\" type=\"submit\">"; }
			if ( get_option("mommaincontrol_shorts") == 1 ) { echo "<label for=\"MOMshortcodes\"><i title=\"Shortcodes settings\" class=\"fa fa-pencil"; if ( get_option('mommaincontrol_focus') == "shortcodes" ) { echo " active"; } echo "\"></i></label><input id=\"MOMshortcodes\" name=\"MOMshortcodes\" type=\"submit\">"; }
		echo "</form></div>";
	}
	if(isset($_POST["MOMclear"])){ update_option("mommaincontrol_focus",""); echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}
	if(isset($_POST["MOMexclude"])){ update_option("mommaincontrol_focus","exclude"); echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}
	if(isset($_POST["MOMcount"])){ update_option("mommaincontrol_focus","count"); echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}
	if(isset($_POST["MOMjumparound"])){ update_option("mommaincontrol_focus","jumparound"); echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}
	if(isset($_POST["MOMpasswords"])){ update_option("mommaincontrol_focus","passwords"); echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}
	if(isset($_POST["MOMreviews"])){ update_option("mommaincontrol_focus","reviews"); echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}
	if(isset($_POST["MOMshortcodes"])){ update_option("mommaincontrol_focus","shortcodes"); echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";}
	
	echo "<div class=\"allSections\">
		<div class=\"allSectionsContent\">
			<h2><i class=\"fa fa-cog\"></i> My Optional Modules</h2>";
			if ($_REQUEST["mommaincontrol_uninstall_all"] == 3) {
				$uninstalled = 1;
				echo "<div id=\"setting-error-settings_nuked\" class=\"updated settings-error\"><p>All settings associated with MOM have been wiped from your database.  You may now uninstall this plugin.  All customized settings for individual modules have been lost, however.</p><p>Thanks for using <em>My Optional Modules</em>, and good luck in your future endeavors!</div>";
			}				
			if ($uninstalled == 1) { } else {
				
				if ( get_option('mommaincontrol_focus') == "" ) {
				echo "<form method=\"post\">";
				my_optional_modules_form();
				echo "</form>";	
				include( 'databasecleaner.php');
				} else {
					echo "<div class=\"panelSection clear plugin\">";
					if ( get_option('mommaincontrol_focus') == "count" ) { include( plugin_dir_path( __FILE__ ) . 'countplusplus.php'); }
					elseif ( get_option('mommaincontrol_focus') == "exclude" ) { include( plugin_dir_path( __FILE__ ) . 'exclude.php'); }
					elseif ( get_option('mommaincontrol_focus') == "jumparound" ) { include( plugin_dir_path( __FILE__ ) . 'jumparound.php'); }
					elseif ( get_option('mommaincontrol_focus') == "passwords" ) { include( plugin_dir_path( __FILE__ ) . 'passwords.php'); }
					elseif ( get_option('mommaincontrol_focus') == "reviews" ) { include( plugin_dir_path( __FILE__ ) . 'reviews.php'); }
					elseif ( get_option('mommaincontrol_focus') == "shortcodes" ) { include( plugin_dir_path( __FILE__ ) . 'shortcodes.php'); }
					echo "</div>";
				}
			}
	echo "
		</div>
	</div>
	";
}

		if(isset($_POST["momsave"])){ update_myoptionalmodules_options(); }
	} 
 ?>