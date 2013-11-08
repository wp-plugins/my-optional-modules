<?php  if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}

	if(is_admin() ){
			function momAdminOptions(){
				$css = plugins_url()."/".plugin_basename(dirname(__FILE__)).'/includes/';
					wp_enqueue_style('font_awesome', $css.'fontawesome/css/font-awesome.css');
				add_action('wp_enqueue_admin_scripts','mom_plugin_scripts');		
			
				// Add info panel to post edit screen
				function momEditorScreen( $post_type ){
					$screen = get_current_screen();
					$edit_post_type = $screen->post_type;
					if($edit_post_type != 'post')
						return;
					if(get_option('mommaincontrol_shorts') == 1 || 
						 get_option('mommaincontrol_reviews') == 1 ||
						 get_option('mommaincontrol_rups') == 1 ||
						 get_option('mommaincontrol_fontawesome') == 1
					){
						echo "				
						<div class=\"momEditorScreen postbox\">
							<h3>Shortcodes provided by My Optional Modules</h3>
							<div class=\"inside\">
								<style>
									ol#momEditorMenu {width:95%; margin:0 auto; overflow:auto; overflow:hidden;}
									ol#momEditorMenu li {width:auto; margin:2px; float:left; list-style:none; display:block; padding:5px; line-height:20px; font-size:13px;}
									ol#momEditorMenu li span:hover {cursor:pointer; background-color:#fff; color:#4b5373;}
									ol#momEditorMenu li span {margin-right:5px; width:18px; height:19px; display:block; float:left; overflow:hidden; color: #fff; background-color:#4b5373; border-radius:3px; font-size:20px;}
									ol#momEditorMenu li.clear {clear:both; display:block; width:100%;}
									ol#momEditorMenu li.icon {width:18px; height:16px; overflow:hidden; font-size:20px; line-height:22px; margin:5px}
									ol#momEditorMenu li.icon:hover {cursor:pointer; color:#441515; background-color:#ececec; border-radius:3px;}
								</style>					
													
								<ol id=\"momEditorMenu\">";
									if(get_option('mommaincontrol_shorts') == 1 ){
										echo "<li>Google map<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_map address=\"\"]</span></li>";
										echo "<li>Reddit button<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_reddit]</span></li>";
										echo "<li>Restrict<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_restrict]content[/mom_restrict]</span></li>";
										echo "<li>Progress bar<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_progress level=\"\"]</span></li>";
										echo "<li>Verifier<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[mom_verify age=\"18\"]some content[/mom_verify]</span></li>";
									}
									if(get_option('mommaincontrol_reviews') == 1 ){
										echo "<li>Reviews<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[momreviews]</span></li>";
									}
									if(get_option('mommaincontrol_momrups') == 1 ){
										echo "<li>Passwords<span class=\"fa fa-plus-square\" onclick=\"addText(event)\">[rups]content[/rups]</span></li>";
									}
									if(get_option('mommaincontrol_fontawesome') == 1 ){
										echo "<li class=\"clear\"></li>";
										// Medical Icons
										echo '<li onclick="addText(event)" class="icon fa fa-ambulance"><span>&#60;i class="fa fa-ambulance"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-medkit"><span>&#60;i class="fa fa-medkit"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-user-md"><span>&#60;i class="fa fa-user-md"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-h-square"><span>&#60;i class="fa fa-h-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-plus-square"><span>&#60;i class="fa fa-plus-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-wheelchair"><span>&#60;i class="fa fa-wheelchair"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-hospital"><span>&#60;i class="fa fa-hospital"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-stethoscope"><span>&#60;i class="fa fa-stethoscope"&#62;&#60;/i&#62;</span></li>';	
										// Brand Icons
										echo '<li onclick="addText(event)" class="icon fa fa-adn"><span>&#60;i class="fa fa-adn"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bitbucket"><span>&#60;i class="fa fa-bitbucket"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-btc"><span>&#60;i class="fa fa-btc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-dropbox"><span>&#60;i class="fa fa-dropbox"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-flickr"><span>&#60;i class="fa fa-flickr"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-github-alt"><span>&#60;i class="fa fa-github-alt"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-google-plus"><span>&#60;i class="fa fa-google-plus"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-instagram"><span>&#60;i class="fa fa-instagram"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-linux"><span>&#60;i class="fa fa-linux"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-pinterest"><span>&#60;i class="fa fa-pinterest"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-skype"><span>&#60;i class="fa fa-skype"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-trello"><span>&#60;i class="fa fa-trello"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-twitter"><span>&#60;i class="fa fa-twitter"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-vk"><span>&#60;i class="fa fa-vk"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-xing"><span>&#60;i class="fa fa-xing"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-youtube-play"><span>&#60;i class="fa fa-youtube-play"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-android"><span>&#60;i class="fa fa-android"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bitbucket-square"><span>&#60;i class="fa fa-bitbucket-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-css3"><span>&#60;i class="fa fa-css3"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-facebook"><span>&#60;i class="fa fa-facebook"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-foursquare"><span>&#60;i class="fa fa-foursquare"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-github-square"><span>&#60;i class="fa fa-github-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-google-plus-square"><span>&#60;i class="fa fa-google-plus-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-linkedin"><span>&#60;i class="fa fa-linkedin"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-maxcdn"><span>&#60;i class="fa fa-maxcdn"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-pinterest-square"><span>&#60;i class="fa fa-pinterest-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-stack-exchange"><span>&#60;i class="fa fa-stack-exchange"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tumblr"><span>&#60;i class="fa fa-tumblr"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-twitter-square"><span>&#60;i class="fa fa-twitter-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-weibo"><span>&#60;i class="fa fa-weibo"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-xing-square"><span>&#60;i class="fa fa-xing-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-youtube-square"><span>&#60;i class="fa fa-youtube-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-apple"><span>&#60;i class="fa fa-apple"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bitcoin"><span>&#60;i class="fa fa-bitcoin"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-dribbble"><span>&#60;i class="fa fa-dribbble"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-facebook-square"><span>&#60;i class="fa fa-facebook-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-github"><span>&#60;i class="fa fa-github"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-gittip"><span>&#60;i class="fa fa-gittip"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-html5"><span>&#60;i class="fa fa-html5"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-linkedin-square"><span>&#60;i class="fa fa-linkedin-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-pagelines"><span>&#60;i class="fa fa-pagelines"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-renren"><span>&#60;i class="fa fa-renren"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-stack-overflow"><span>&#60;i class="fa fa-stack-overflow"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tumblr-square"><span>&#60;i class="fa fa-tumblr-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-vimeo-square"><span>&#60;i class="fa fa-vimeo-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-windows"><span>&#60;i class="fa fa-windows"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-youtube"><span>&#60;i class="fa fa-youtube"&#62;&#60;/i&#62;</span></li>';	
										// Video player icons
										echo '<li onclick="addText(event)" class="icon fa fa-backward"><span>&#60;i class="fa fa-backward"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-fast-forward"><span>&#60;i class="fa fa-fast-forward"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-pause"><span>&#60;i class="fa fa-pause"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-play-circle-o"><span>&#60;i class="fa fa-play-circle-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-step-backward"><span>&#60;i class="fa fa-step-backward"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-youtube-play"><span>&#60;i class="fa fa-youtube-play"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-eject"><span>&#60;i class="fa fa-eject"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-forward"><span>&#60;i class="fa fa-forward"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-play"><span>&#60;i class="fa fa-play"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-resize-full"><span>&#60;i class="fa fa-resize-full"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-step-forward"><span>&#60;i class="fa fa-step-forward"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-fast-backward"><span>&#60;i class="fa fa-fast-backward"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-fullscreen"><span>&#60;i class="fa fa-fullscreen"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-play-circle"><span>&#60;i class="fa fa-play-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-resize-small"><span>&#60;i class="fa fa-resize-small"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-stop"><span>&#60;i class="fa fa-stop"&#62;&#60;/i&#62;</span></li>';	
										// Directional icons
										echo '<li onclick="addText(event)" class="icon fa fa-angle-double-down"><span>&#60;i class="fa fa-angle-double-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-angle-double-up"><span>&#60;i class="fa fa-angle-double-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-angle-right"><span>&#60;i class="fa fa-angle-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-left"><span>&#60;i class="fa fa-arrow-circle-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-right"><span>&#60;i class="fa fa-arrow-circle-o-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-up"><span>&#60;i class="fa fa-arrow-circle-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-right"><span>&#60;i class="fa fa-arrow-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-left"><span>&#60;i class="fa fa-caret-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-left"><span>&#60;i class="fa fa-caret-square-o-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-up"><span>&#60;i class="fa fa-caret-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-right"><span>&#60;i class="fa fa-chevron-circle-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-left"><span>&#60;i class="fa fa-chevron-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-hand-o-down"><span>&#60;i class="fa fa-hand-o-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-hand-o-up"><span>&#60;i class="fa fa-hand-o-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-right"><span>&#60;i class="fa fa-long-arrow-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-left"><span>&#60;i class="fa fa-toggle-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-angle-double-left"><span>&#60;i class="fa fa-angle-double-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-angle-down"><span>&#60;i class="fa fa-angle-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-angle-up"><span>&#60;i class="fa fa-angle-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-down"><span>&#60;i class="fa fa-arrow-circle-o-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-up"><span>&#60;i class="fa fa-arrow-circle-o-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-down"><span>&#60;i class="fa fa-arrow-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-up"><span>&#60;i class="fa fa-arrow-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-right"><span>&#60;i class="fa fa-caret-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-right"><span>&#60;i class="fa fa-caret-square-o-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-down"><span>&#60;i class="fa fa-chevron-circle-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-up"><span>&#60;i class="fa fa-chevron-circle-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-right"><span>&#60;i class="fa fa-chevron-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-hand-o-left"><span>&#60;i class="fa fa-hand-o-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-down"><span>&#60;i class="fa fa-long-arrow-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-up"><span>&#60;i class="fa fa-long-arrow-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-right"><span>&#60;i class="fa fa-toggle-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-angle-double-right"><span>&#60;i class="fa fa-angle-double-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-angle-left"><span>&#60;i class="fa fa-angle-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-down"><span>&#60;i class="fa fa-arrow-circle-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-o-left"><span>&#60;i class="fa fa-arrow-circle-o-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-circle-right"><span>&#60;i class="fa fa-arrow-circle-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-arrow-left"><span>&#60;i class="fa fa-arrow-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-down"><span>&#60;i class="fa fa-caret-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-down"><span>&#60;i class="fa fa-caret-square-o-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-up"><span>&#60;i class="fa fa-caret-square-o-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-circle-left"><span>&#60;i class="fa fa-chevron-circle-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-down"><span>&#60;i class="fa fa-chevron-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chevron-up"><span>&#60;i class="fa fa-chevron-up"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-hand-o-right"><span>&#60;i class="fa fa-hand-o-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-long-arrow-left"><span>&#60;i class="fa fa-long-arrow-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-down"><span>&#60;i class="fa fa-toggle-down"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-up"><span>&#60;i class="fa fa-toggle-up"&#62;&#60;/i&#62;</span></li>';	
										// Text editor icons
										echo '<li onclick="addText(event)" class="icon fa fa-align-center"><span>&#60;i class="fa fa-align-center"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-align-right"><span>&#60;i class="fa fa-align-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chain-broken"><span>&#60;i class="fa fa-chain-broken"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-copy"><span>&#60;i class="fa fa-copy"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-eraser"><span>&#60;i class="fa fa-eraser"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-file-text"><span>&#60;i class="fa fa-file-text"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-floppy-o"><span>&#60;i class="fa fa-floppy-o"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-italic"><span>&#60;i class="fa fa-italic"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-list-alt"><span>&#60;i class="fa fa-list-alt"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-outdent"><span>&#60;i class="fa fa-outdent"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-repeat"><span>&#60;i class="fa fa-repeat"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-save"><span>&#60;i class="fa fa-save"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-table"><span>&#60;i class="fa fa-table"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-th"><span>&#60;i class="fa fa-th"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-underline"><span>&#60;i class="fa fa-underline"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-align-justify"><span>&#60;i class="fa fa-align-justify"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-bold"><span>&#60;i class="fa fa-bold"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-clipboard"><span>&#60;i class="fa fa-clipboard"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-cut"><span>&#60;i class="fa fa-cut"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-file"><span>&#60;i class="fa fa-file"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-file-text-o"><span>&#60;i class="fa fa-file-text-o"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-font"><span>&#60;i class="fa fa-font"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-link"><span>&#60;i class="fa fa-link"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-list-ol"><span>&#60;i class="fa fa-list-ol"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-paperclip"><span>&#60;i class="fa fa-paperclip"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-rotate-left"><span>&#60;i class="fa fa-rotate-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-scissors"><span>&#60;i class="fa fa-scissors"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-text-height"><span>&#60;i class="fa fa-text-height"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-th-large"><span>&#60;i class="fa fa-th-large"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-undo"><span>&#60;i class="fa fa-undo"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-align-left"><span>&#60;i class="fa fa-align-left"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-chain"><span>&#60;i class="fa fa-chain"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-columns"><span>&#60;i class="fa fa-columns"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-dedent"><span>&#60;i class="fa fa-dedent"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-file-o"><span>&#60;i class="fa fa-file-o"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-files-o"><span>&#60;i class="fa fa-files-o"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-indent"><span>&#60;i class="fa fa-indent"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-list"><span>&#60;i class="fa fa-list"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-list-ul"><span>&#60;i class="fa fa-list-ul"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-paste"><span>&#60;i class="fa fa-paste"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-rotate-right"><span>&#60;i class="fa fa-rotate-right"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-strikethrough"><span>&#60;i class="fa fa-strikethrough"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-text-width"><span>&#60;i class="fa fa-text-width"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-th-list"><span>&#60;i class="fa fa-th-list"&#62;&#60;/i&#62;</span></li>';	
										echo '<li onclick="addText(event)" class="icon fa fa-unlink"><span>&#60;i class="fa fa-unlink"&#62;&#60;/i&#62;</span></li>';	
										// Currency icons
										echo '<li onclick="addText(event)" class="icon fa fa-bitcoin"><span>&#60;i class="fa fa-bitcoin"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-dollar"><span>&#60;i class="fa fa-dollar"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-gbp"><span>&#60;i class="fa fa-gbp"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-krw"><span>&#60;i class="fa fa-krw"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-rouble"><span>&#60;i class="fa fa-rouble"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-rupee"><span>&#60;i class="fa fa-rupee"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-usd"><span>&#60;i class="fa fa-usd"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-btc"><span>&#60;i class="fa fa-btc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-eur"><span>&#60;i class="fa fa-eur"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-inr"><span>&#60;i class="fa fa-inr"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-money"><span>&#60;i class="fa fa-money"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-rub"><span>&#60;i class="fa fa-rub"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-try"><span>&#60;i class="fa fa-try"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-won"><span>&#60;i class="fa fa-won"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-cny"><span>&#60;i class="fa fa-cny"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-euro"><span>&#60;i class="fa fa-euro"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-jpy"><span>&#60;i class="fa fa-jpy"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-rmb"><span>&#60;i class="fa fa-rmb"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-ruble"><span>&#60;i class="fa fa-ruble"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-turkish-lira"><span>&#60;i class="fa fa-turkish-lira"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-yen"><span>&#60;i class="fa fa-yen"&#62;&#60;/i&#62;</span></li>';
										// Form control icons
										echo '<li onclick="addText(event)" class="icon fa fa-check-square"><span>&#60;i class="fa fa-check-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-circle-o"><span>&#60;i class="fa fa-circle-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-minus-square-o"><span>&#60;i class="fa fa-minus-square-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-check-square-o"><span>&#60;i class="fa fa-check-square-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-dot-circle-o"><span>&#60;i class="fa fa-dot-circle-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-square"><span>&#60;i class="fa fa-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-circle"><span>&#60;i class="fa fa-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-minus-square"><span>&#60;i class="fa fa-minus-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-square-o"><span>&#60;i class="fa fa-square-o"&#62;&#60;/i&#62;</span></li>';
										// Web application icons
										echo '<li onclick="addText(event)" class="icon fa fa-adjust"><span>&#60;i class="fa fa-adjust"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-anchor"><span>&#60;i class="fa fa-anchor"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-archive"><span>&#60;i class="fa fa-archive"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-asterisk"><span>&#60;i class="fa fa-asterisk"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-ban"><span>&#60;i class="fa fa-ban"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bar-chart-o"><span>&#60;i class="fa fa-bar-chart-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-barcode"><span>&#60;i class="fa fa-barcode"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-beer"><span>&#60;i class="fa fa-beer"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bell"><span>&#60;i class="fa fa-bell"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bell-o"><span>&#60;i class="fa fa-bell-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bolt"><span>&#60;i class="fa fa-bolt"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-book"><span>&#60;i class="fa fa-book"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bookmark"><span>&#60;i class="fa fa-bookmark"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bookmark-o"><span>&#60;i class="fa fa-bookmark-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-briefcase"><span>&#60;i class="fa fa-briefcase"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bug"><span>&#60;i class="fa fa-bug"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-building"><span>&#60;i class="fa fa-building"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bullhorn"><span>&#60;i class="fa fa-bullhorn"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-bullseye"><span>&#60;i class="fa fa-bullseye"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-calendar"><span>&#60;i class="fa fa-calendar"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-calendar-o"><span>&#60;i class="fa fa-calendar-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-camera"><span>&#60;i class="fa fa-camera"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-camera-retro"><span>&#60;i class="fa fa-camera-retro"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-down"><span>&#60;i class="fa fa-caret-square-o-down"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-left"><span>&#60;i class="fa fa-caret-square-o-left"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-right"><span>&#60;i class="fa fa-caret-square-o-right"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-caret-square-o-up"><span>&#60;i class="fa fa-caret-square-o-up"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-certificate"><span>&#60;i class="fa fa-certificate"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-check"><span>&#60;i class="fa fa-check"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-check-circle"><span>&#60;i class="fa fa-check-circle"&#62;&#60;/i&#62;</span></li>';
										
										echo '<li onclick="addText(event)" class="icon fa fa-check-circle-o"><span>&#60;i class="fa fa-check-circle-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-check-square"><span>&#60;i class="fa fa-check-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-check-square-o"><span>&#60;i class="fa fa-check-square-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-circle"><span>&#60;i class="fa fa-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-circle-o"><span>&#60;i class="fa fa-circle-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-clock-o"><span>&#60;i class="fa fa-clock-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-cloud"><span>&#60;i class="fa fa-cloud"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-cloud-download"><span>&#60;i class="fa fa-cloud-download"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-cloud-upload"><span>&#60;i class="fa fa-cloud-upload"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-code"><span>&#60;i class="fa fa-code"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-code-fork"><span>&#60;i class="fa fa-code-fork"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-coffee"><span>&#60;i class="fa fa-coffee"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-cog"><span>&#60;i class="fa fa-cog"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-cogs"><span>&#60;i class="fa fa-cogs"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-collapse-o"><span>&#60;i class="fa fa-collapse-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-comment"><span>&#60;i class="fa fa-comment"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-comment-o"><span>&#60;i class="fa fa-comment-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-comments"><span>&#60;i class="fa fa-comments"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-comments-o"><span>&#60;i class="fa fa-comments-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-compass"><span>&#60;i class="fa fa-compass"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-credit-card"><span>&#60;i class="fa fa-credit-card"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-crop"><span>&#60;i class="fa fa-crop"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-crosshairs"><span>&#60;i class="fa fa-crosshairs"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-cutlery"><span>&#60;i class="fa fa-cutlery"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-dashboard"><span>&#60;i class="fa fa-dashboard"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-desktop"><span>&#60;i class="fa fa-desktop"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-dot-circle-o"><span>&#60;i class="fa fa-dot-circle-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-download"><span>&#60;i class="fa fa-download"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-edit"><span>&#60;i class="fa fa-edit"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-ellipsis-horizontal"><span>&#60;i class="fa fa-ellipsis-horizontal"&#62;&#60;/i&#62;</span></li>';
										
										echo '<li onclick="addText(event)" class="icon fa fa-ellipsis-vertical"><span>&#60;i class="fa fa-ellipsis-vertical"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-envelope"><span>&#60;i class="fa fa-envelope"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-envelope-o"><span>&#60;i class="fa fa-envelope-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-eraser"><span>&#60;i class="fa fa-eraser"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-exchange"><span>&#60;i class="fa fa-exchange"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-exclamation"><span>&#60;i class="fa fa-exclamation"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-exclamation-circle"><span>&#60;i class="fa fa-exclamation-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-exclamation-triangle"><span>&#60;i class="fa fa-exclamation-triangle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-expand-o"><span>&#60;i class="fa fa-expand-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-external-link"><span>&#60;i class="fa fa-external-link"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-external-link-square"><span>&#60;i class="fa fa-external-link-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-eye"><span>&#60;i class="fa fa-eye"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-eye-slash"><span>&#60;i class="fa fa-eye-slash"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-female"><span>&#60;i class="fa fa-female"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-fighter-jet"><span>&#60;i class="fa fa-fighter-jet"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-film"><span>&#60;i class="fa fa-film"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-filter"><span>&#60;i class="fa fa-filter"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-fire"><span>&#60;i class="fa fa-fire"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-fire-extinguisher"><span>&#60;i class="fa fa-fire-extinguisher"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-flag"><span>&#60;i class="fa fa-flag"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-flag-checkered"><span>&#60;i class="fa fa-flag-checkered"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-flag-o"><span>&#60;i class="fa fa-flag-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-flash"><span>&#60;i class="fa fa-flash"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-flask"><span>&#60;i class="fa fa-flask"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-folder"><span>&#60;i class="fa fa-folder"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-folder-o"><span>&#60;i class="fa fa-folder-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-folder-open"><span>&#60;i class="fa fa-folder-open"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-folder-open-o"><span>&#60;i class="fa fa-folder-open-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-frown-o"><span>&#60;i class="fa fa-frown-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-gamepad"><span>&#60;i class="fa fa-gamepad"&#62;&#60;/i&#62;</span></li>';

										echo '<li onclick="addText(event)" class="icon fa fa-gavel"><span>&#60;i class="fa fa-gavel"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-gear"><span>&#60;i class="fa fa-gear"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-gears"><span>&#60;i class="fa fa-gears"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-gift"><span>&#60;i class="fa fa-gift"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-glass"><span>&#60;i class="fa fa-glass"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-globe"><span>&#60;i class="fa fa-globe"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-group"><span>&#60;i class="fa fa-group"&#62;&#60;/i&#62;</span></li>';
										// hdd-o seems to be broken ## echo '<li onclick="addText(event)" class="icon fa fa-hdd-o"><span>&#60;i class="fa fa-hdd-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-headphones"><span>&#60;i class="fa fa-headphones"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-heart"><span>&#60;i class="fa fa-heart"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-heart-o"><span>&#60;i class="fa fa-heart-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-home"><span>&#60;i class="fa fa-home"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-inbox"><span>&#60;i class="fa fa-inbox"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-info"><span>&#60;i class="fa fa-info"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-info-circle"><span>&#60;i class="fa fa-info-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-key"><span>&#60;i class="fa fa-key"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-keyboard-o"><span>&#60;i class="fa fa-keyboard-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-laptop"><span>&#60;i class="fa fa-laptop"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-leaf"><span>&#60;i class="fa fa-leaf"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-legal"><span>&#60;i class="fa fa-legal"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-lemon-o"><span>&#60;i class="fa fa-lemon-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-level-down"><span>&#60;i class="fa fa-level-down"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-level-up"><span>&#60;i class="fa fa-level-up"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-lightbulb-o"><span>&#60;i class="fa fa-lightbulb-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-location-arrow"><span>&#60;i class="fa fa-location-arrow"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-lock"><span>&#60;i class="fa fa-lock"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-magic"><span>&#60;i class="fa fa-magic"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-magnet"><span>&#60;i class="fa fa-magnet"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-mail-forward"><span>&#60;i class="fa fa-mail-forward"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-mail-reply"><span>&#60;i class="fa fa-mail-reply"&#62;&#60;/i&#62;</span></li>';
										
										echo '<li onclick="addText(event)" class="icon fa fa-mail-reply-all"><span>&#60;i class="fa fa-mail-reply-all"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-male"><span>&#60;i class="fa fa-male"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-map-marker"><span>&#60;i class="fa fa-map-marker"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-meh-o"><span>&#60;i class="fa fa-meh-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-microphone"><span>&#60;i class="fa fa-microphone"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-microphone-slash"><span>&#60;i class="fa fa-microphone-slash"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-minus"><span>&#60;i class="fa fa-minus"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-minus-circle"><span>&#60;i class="fa fa-minus-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-minus-square"><span>&#60;i class="fa fa-minus-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-minus-square-o"><span>&#60;i class="fa fa-minus-square-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-mobile"><span>&#60;i class="fa fa-mobile"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-mobile-phone"><span>&#60;i class="fa fa-mobile-phone"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-money"><span>&#60;i class="fa fa-money"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-moon-o"><span>&#60;i class="fa fa-moon-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-move"><span>&#60;i class="fa fa-move"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-music"><span>&#60;i class="fa fa-music"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-pencil"><span>&#60;i class="fa fa-pencil"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-pencil-square"><span>&#60;i class="fa fa-pencil-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-pencil-square-o"><span>&#60;i class="fa fa-pencil-square-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-phone"><span>&#60;i class="fa fa-phone"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-phone-square"><span>&#60;i class="fa fa-phone-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-picture-o"><span>&#60;i class="fa fa-picture-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-plane"><span>&#60;i class="fa fa-plane"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-plus"><span>&#60;i class="fa fa-plus"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-plus-circle"><span>&#60;i class="fa fa-plus-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-plus-square"><span>&#60;i class="fa fa-plus-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-power-off"><span>&#60;i class="fa fa-power-off"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-print"><span>&#60;i class="fa fa-print"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-puzzle-piece"><span>&#60;i class="fa fa-puzzle-piece"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-qrcode"><span>&#60;i class="fa fa-qrcode"&#62;&#60;/i&#62;</span></li>';
										
										echo '<li onclick="addText(event)" class="icon fa fa-question"><span>&#60;i class="fa fa-question"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-question-circle"><span>&#60;i class="fa fa-question-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-quote-left"><span>&#60;i class="fa fa-quote-left"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-quote-right"><span>&#60;i class="fa fa-quote-right"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-random"><span>&#60;i class="fa fa-random"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-refresh"><span>&#60;i class="fa fa-refresh"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-reorder"><span>&#60;i class="fa fa-reorder"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-reply"><span>&#60;i class="fa fa-reply"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-reply-all"><span>&#60;i class="fa fa-reply-all"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-resize-horizontal"><span>&#60;i class="fa fa-resize-horizontal"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-resize-vertical"><span>&#60;i class="fa fa-resize-vertical"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-retweet"><span>&#60;i class="fa fa-retweet"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-road"><span>&#60;i class="fa fa-road"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-rocket"><span>&#60;i class="fa fa-rocket"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-rss"><span>&#60;i class="fa fa-rss"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-rss-square"><span>&#60;i class="fa fa-rss-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-search"><span>&#60;i class="fa fa-search"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-search-minus"><span>&#60;i class="fa fa-search-minus"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-search-plus"><span>&#60;i class="fa fa-search-plus"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-share"><span>&#60;i class="fa fa-share"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-share-square"><span>&#60;i class="fa fa-share-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-share-square-o"><span>&#60;i class="fa fa-share-square-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-shield"><span>&#60;i class="fa fa-shield"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-shopping-cart"><span>&#60;i class="fa fa-shopping-cart"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sign-in"><span>&#60;i class="fa fa-sign-in"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sign-out"><span>&#60;i class="fa fa-sign-out"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-signal"><span>&#60;i class="fa fa-signal"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sitemap"><span>&#60;i class="fa fa-sitemap"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-smile-o"><span>&#60;i class="fa fa-smile-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort"><span>&#60;i class="fa fa-sort"&#62;&#60;/i&#62;</span></li>';
										
										echo '<li onclick="addText(event)" class="icon fa fa-sort-alpha-asc"><span>&#60;i class="fa fa-sort-alpha-asc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-alpha-desc"><span>&#60;i class="fa fa-sort-alpha-desc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-amount-asc"><span>&#60;i class="fa fa-sort-amount-asc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-amount-desc"><span>&#60;i class="fa fa-sort-amount-desc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-asc"><span>&#60;i class="fa fa-sort-asc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-desc"><span>&#60;i class="fa fa-sort-desc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-down"><span>&#60;i class="fa fa-sort-down"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-numeric-asc"><span>&#60;i class="fa fa-sort-numeric-asc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-numeric-desc"><span>&#60;i class="fa fa-sort-numeric-desc"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sort-up"><span>&#60;i class="fa fa-sort-up"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-spinner"><span>&#60;i class="fa fa-spinner"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-square"><span>&#60;i class="fa fa-square"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-square-o"><span>&#60;i class="fa fa-square-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-star"><span>&#60;i class="fa fa-star"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-star-half"><span>&#60;i class="fa fa-star-half"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-star-half-empty"><span>&#60;i class="fa fa-star-half-empty"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-star-half-full"><span>&#60;i class="fa fa-star-half-full"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-star-half-o"><span>&#60;i class="fa fa-star-half-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-star-o"><span>&#60;i class="fa fa-star-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-subscript"><span>&#60;i class="fa fa-subscript"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-suitcase"><span>&#60;i class="fa fa-suitcase"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-sun-o"><span>&#60;i class="fa fa-sun-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-superscript"><span>&#60;i class="fa fa-superscript"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tablet"><span>&#60;i class="fa fa-tablet"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tachometer"><span>&#60;i class="fa fa-tachometer"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tag"><span>&#60;i class="fa fa-tag"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tags"><span>&#60;i class="fa fa-tags"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tasks"><span>&#60;i class="fa fa-tasks"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-terminal"><span>&#60;i class="fa fa-terminal"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-thumb-tack"><span>&#60;i class="fa fa-thumb-tack"&#62;&#60;/i&#62;</span></li>';
										
										echo '<li onclick="addText(event)" class="icon fa fa-thumbs-down"><span>&#60;i class="fa fa-thumbs-down"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-thumbs-o-down"><span>&#60;i class="fa fa-thumbs-o-down"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-thumbs-o-up"><span>&#60;i class="fa fa-thumbs-o-up"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-thumbs-up"><span>&#60;i class="fa fa-thumbs-up"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-ticket"><span>&#60;i class="fa fa-ticket"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-times"><span>&#60;i class="fa fa-times"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-times-circle"><span>&#60;i class="fa fa-times-circle"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-times-circle-o"><span>&#60;i class="fa fa-times-circle-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-tint"><span>&#60;i class="fa fa-tint"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-down"><span>&#60;i class="fa fa-toggle-down"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-left"><span>&#60;i class="fa fa-toggle-left"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-right"><span>&#60;i class="fa fa-toggle-right"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-toggle-up"><span>&#60;i class="fa fa-toggle-up"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-trash-o"><span>&#60;i class="fa fa-trash-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-trophy"><span>&#60;i class="fa fa-trophy"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-truck"><span>&#60;i class="fa fa-truck"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-umbrella"><span>&#60;i class="fa fa-umbrella"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-unlock"><span>&#60;i class="fa fa-unlock"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-unlock-o"><span>&#60;i class="fa fa-unlock-o"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-unsorted"><span>&#60;i class="fa fa-unsorted"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-upload"><span>&#60;i class="fa fa-upload"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-user"><span>&#60;i class="fa fa-user"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-video-camera"><span>&#60;i class="fa fa-video-camera"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-volume-down"><span>&#60;i class="fa fa-volume-down"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-volume-off"><span>&#60;i class="fa fa-volume-off"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-volume-up"><span>&#60;i class="fa fa-volume-up"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-warning"><span>&#60;i class="fa fa-warning"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-wheelchair"><span>&#60;i class="fa fa-wheelchair"&#62;&#60;/i&#62;</span></li>';
										echo '<li onclick="addText(event)" class="icon fa fa-wrench"><span>&#60;i class="fa fa-wrench"&#62;&#60;/i&#62;</span></li>';
									}
									echo "</ol>
									<script>
									function addText(event){
										var targ = event.target || event.srcElement;
										document.getElementById(\"content\").value += targ.textContent || targ.innerText;
									}
									</script>
							</div>
						</div>";
					}
				}
				add_action('edit_form_after_editor','momEditorScreen');
			}
		momAdminOptions();
	}
?>