<?php 

/**
 *
 * Add Font Awesome icons to post edit screen
 *
 * 
 * 
 *
 * Since ?
 * @my_optional_modules
 *
 */

/**
 *
 * Don't call this file directly
 *
 */
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

if( current_user_can( 'manage_options' ) ) {

	$css = plugins_url() . '/' . plugin_basename( dirname( __FILE__ ) ) . '/includes/';

	add_action( 'wp_enqueue_admin_scripts', 'myoptionalmodules_scripts' );

	function momEditorScreen( $post_type ) {

		$screen         = get_current_screen();
		$edit_post_type = $screen->post_type;

		if( $edit_post_type != 'post' )
		if( $edit_post_type != 'page' )
		return;

			if( 1 == get_option( 'mommaincontrol_fontawesome' ) ) { ?>


				<div class="momEditorScreen postbox">
					<h3>Font Awesome Icons</h3>
					<div class="inside">
						<style>
							ol#momEditorMenu {width:95%;margin:0 auto;overflow:auto;overflow-x:hidden;overflow-y:auto;height:200px}
							ol#momEditorMenu li {width:auto; margin:2px; float:left; list-style:none; display:block; padding:5px; line-height:20px; font-size:13px;}
							ol#momEditorMenu li span:hover {cursor:pointer; background-color:#fff; color:#4b5373;}
							ol#momEditorMenu li span {margin-right:5px; width:18px; height:19px; display:block; float:left; overflow:hidden; color: #fff; background-color:#4b5373; border-radius:3px; font-size:20px;}
							ol#momEditorMenu li.clear {clear:both; display:block; width:100%;}
							ol#momEditorMenu li.icon {width:18px; height:16px; overflow:hidden; font-size:20px; line-height:22px; margin:5px}
							ol#momEditorMenu li.icon:hover {cursor:pointer; color:#441515; background-color:#ececec; border-radius:3px;}
						</style>					
						<ol id="momEditorMenu">
							<li class="clear"></li>
							<?php $icon = array(
								'automobile','bank','behance','behance-square','bomb','building','cab','car','child','circle-o-notch','circle-thin','codepen',
								'cube','cubes','database','delicious','deviantart','digg','drupal','empire','envelope-square','fax','file-archive-o','file-audio-o',
								'file-code-o','file-excel-o','file-image-o','file-movie-o','file-pdf-o','file-photo-o',
								'file-picture-o','file-powerpoint-o','file-sound-o','file-video-o','file-word-o','file-zip-o',
								'ge','git','git-square','google','graduation-cap','hacker-news','header','history','institution',
								'joomla','jsfiddle','language','life-bouy','life-ring','life-saver','mortar-board','openid','paper-plane',
								'paper-plane-o','paragraph','paw','pied-piper','pied-piper-alt','pied-piper-square','qq','ra','rebel',
								'recycle','reddit','reddit-square','send','send-o','share-alt','share-alt-square','slack','sliders',
								'soundcloud','space-shuttle','spoon','spotify','steam','steam-square','stumbleupon','stumbleupon-circle',
								'support','taxi','tencent-weibo','tree','university','vine','wechat','weixin','wordpress','yahoo',
								'adjust','anchor','archive','arrows','arrows-h','arrows-v','asterisk',
								'ban','bar-chart-o','barcode','bars','beer','bell','bell-o','bolt','book',
								'bookmark','bookmark-o','briefcase','bug','building-o','bullhorn','bullseye',
								'calendar','calendar-o','camera','camera-retro','caret-square-o-down','caret-square-o-left',
								'caret-square-o-right','caret-square-o-up','certificate','check','check-circle','check-circle-o',
								'check-square','check-square-o','circle','circle-o','clock-o','cloud','cloud-download','cloud-upload',
								'code','code-fork','coffee','cog','cogs','comment','comment-o','comments','comments-o','compass','credit-card',
								'crop','crosshairs','cutlery','dashboard','edit','ellipsis-h','ellipsis-v','envelope','envelope-o','eraser',
								'exchange','exclamation','exclamation-circle','exclamation-triangle','external-link','external-link-square',
								'eye','eye-slash','female','fighter-jet','film','filter','fire','fire-extinguisher','flag','flag-checkered',
								'flag-o','flash','flask','folder','folder-o','folder-open','folder-open-o','frown-o','gamepad','gavel',
								'gear','gears','gift','glass','globe','group','hdd-o','headphones','heart','heart-o','home','inbox',
								'info','info-circle','key','keyboard-o','laptop','leaf','legal','lemon-o','level-down','level-up','lightbulb-o',
								'location-arrow','lock','magic','magnet','mail-forward','mail-reply','mail-reply-all','male','map-marker',
								'meh-o','microphone','microphone-slash','minus','minus-circle','minus-square','minus-square-o','mobile',
								'mobile-phone','money','moon-o','music','pencil','pencil-square','pencil-square-o','phone','phone-square',
								'picture-o','plane','plus','plus-circle','plus-square','plus-square-o','power-off','print','puzzle-piece',
								'qrcode','question','question-circle','quote-left','quote-right','random','refresh','reply','reply-all',
								'retweet','road','rocket','rss','rss-square','search','search-minus','search-plus','share','share-square',
								'share-square-o','shield','shopping-cart','sign-in','sign-out','signal','sitemap','smile-o','sort',
								'sort-alpha-asc','sort-alpha-desc','sort-amount-asc','sort-amount-desc','sort-asc','sort-desc','sort-down',
								'sort-numeric-asc','sort-numeric-desc','sort-up','spinner','square','square-o','star','star-half','star-half-empty',
								'star-half-full','star-half-o','star-o','subscript','suitcase','sun-o','superscript','tablet','tachometer','tag',
								'tags','tasks','terminal','thumb-tack','thumbs-down','thumbs-o-down','thumbs-o-up','thumbs-up','ticket','times',
								'times-circle','times-circle-o','tint','toggle-down','toggle-left','toggle-right','toggle-up','trash-o','trophy',
								'truck','umbrella','unlock','unlock-alt','unsorted','video-camera','volume-down','volume-off','volume-up',
								'warning','wheelchair','wrench','check-square','check-square-o','circle','circle-o','dot-circle-o',
								'minus-square','minus-square-o','plus-square','plus-square-o','square','square-o',
								'bitcoin','btc','cny','dollar','eur','euro','gbp','inr','jpy','krw','money','rmb','rouble','rub','ruble',
								'rupee','try','turkish-lira','usd','won','yen','align-center','align-justify','align-left','align-right',
								'bold','chain','chain-broken','clipboard','columns','copy','cut','dedent','eraser','file','file-o',
								'file-text','file-text-o','files-o','floppy-o','font','indent','italic','link','list','list-alt','list-ol',
								'list-ul','outdent','paperclip','paste','repeat','rotate-left','rotate-right','save','scissors','strikethrough',
								'table','text-height','text-width','th','th-large','th-list','underline','undo','unlink','angle-double-down',
								'angle-double-left','angle-double-right','angle-double-up','angle-down','angle-left','angle-right','angle-up',
								'arrow-circle-down','arrow-circle-left','arrow-circle-o-down','arrow-circle-o-left','arrow-circle-o-right',
								'arrow-circle-o-up','arrow-circle-right','arrow-circle-up','arrow-down','arrow-left','arrow-right','arrow-up',
								'arrows','arrows-alt','arrows-h','arrows-v','caret-down','caret-left','caret-right','caret-square-o-down',
								'caret-square-o-left','caret-square-o-right','caret-square-o-up','caret-up','chevron-circle-down',
								'chevron-circle-left','chevron-circle-right','chevron-circle-up','chevron-down','chevron-left','chevron-right',
								'chevron-up','hand-o-down','hand-o-left','hand-o-right','hand-o-up','long-arrow-down','long-arrow-left',
								'long-arrow-right','long-arrow-up','toggle-down','toggle-left','toggle-right','toggle-up','arrows-alt','backward',
								'compress','eject','expand','fast-backward','fast-forward','forward','pause','play','play-circle','play-circle-o',
								'step-backward','step-forward','stop','youtube-play','ambulance','h-square','hospital-o','medkit','plus-square',
								'stethoscope','user-md','wheelchair','adn','android','apple','bitbucket','bitbucket-square','bitcoin','btc','css3',
								'dribbble','dropbox','facebook','facebook-square','flickr','foursquare','github','github-alt','github-square','gittip',
								'google-plus','google-plus-square','html5','instagram','linkedin','linkedin-square','linux','maxcdn','pagelines',
								'pinterest','pinterest-square','renren','skype','stack-exchange','stack-overflow','trello','tumblr','tumblr-square',
								'twitter','twitter-square','vimeo-square','vk','weibo','windows','xing','xing-square','youtube','youtube-play',
								'youtube-square'
							);
							foreach ($icon as &$value){ ?>
								<li onclick="addText(event)" title="<i class='fa fa-<?php echo sanitize_text_field( $value );?>'></i>" class="fa fa-<?php echo sanitize_text_field( $value );?> icon"><span>&#60;i class="fa fa-<?php echo sanitize_text_field( $value );?>"&#62;&#60;/i&#62;</span></li>
							<?php } ?>
						</ol>
						<script>
							function addText(event){
								var targ = event.target || event.srcElement;
								document.getElementById("content").value += targ.textContent || targ.innerText;
							}
						</script>
					</div>
				</div>

			<?php }
		}	
		add_action( 'edit_form_after_editor','momEditorScreen' );
	}