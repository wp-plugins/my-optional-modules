<?php
/*
 * ADMIN Font Awesome
 *
 * File last update: 9.1.2
 *
 * Adds Font Awesome buttons to click to add to post edit content
 * while NOT IN VISUAL MODE. 
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}


$css  = plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/includes/';
add_action ( 'wp_enqueue_admin_scripts' , 'myoptionalmodules_scripts' );

function myoptionalmodules_fontfa_posteditscreen ( $post_type ) {

	$screen         = get_current_screen();
	$edit_post_type = $screen->post_type;

	if ( $edit_post_type != 'post' )
	if ( $edit_post_type != 'page' )
	return;

	global $myoptionalmodules_fontawesome;
	if ( $myoptionalmodules_fontawesome ) { ?>
		<div class="myoptionalmodules_fontfa_posteditscreen postbox">
			<h3>Font Awesome Icons &mdash; shortcode usage: [font-fa i="<em>icon-name</em>"] (<a href="http://fortawesome.github.io/Font-Awesome/icons/">Names</a>)</h3>
			<div class="inside">
				<style>
					ol#momEditorMenu {
						height:217px;
						margin:0 auto;
						overflow:auto;
						overflow-x:hidden;
						overflow-y:auto;
						width:100%;
					}
					ol#momEditorMenu .icon {
						cursor: pointer;
						font-size: 125%;
					}
					ol#momEditorMenu li {
						background-color: rgba(229,246,255,.1);
						border: 1px solid rgba(0,0,0,.1);
						cursor: pointer;
						float: left;
						list-style: none;
						margin: 0 0 1px 1px;
						padding: 15px;
						position: relative;
						text-align: center;
						text-shadow: 1px 1px 1px rgba(255,255,255,.6);
						width: 3%;
					}
					ol#momEditorMenu li.clear {
						background-color: transparent;
						border: 0px;
						margin: 0;
						text-align: left;
						width: 100%;
					}
				</style>
				<ol id="momEditorMenu">
					<?php
					$web_application_icons = array (
						'adjust'               , 'anchor'               , 'archive'             ,
						'area-chart'           , 'arrows'               , 'arrows-h'            ,
						'arrows-v'             , 'asterisk'             , 'at'                  ,
						'automobile'           , 'ban'                  , 'bank'                ,
						'bar-chart'            , 'bar-chart-o'          , 'barcode'             ,
						'bars'                 , 'bed'                  , 'beer'                ,
						'bell'                 , 'bell-o'               , 'bell-slash'          ,
						'bell-slash-o'         , 'bicycle'              , 'binoculars'          ,
						'birthday-cake'        , 'bolt'                 , 'bomb'                ,
						'book'                 , 'bookmark'             , 'bookmark-o'          ,
						'briefcase'            , 'bug'                  , 'building'            ,
						'building-o'           , 'bullhorn'             , 'bullseye'            ,
						'bus'                  , 'cab'                  , 'calculator'          ,
						'calendar'             , 'calendar-o'           , 'camera'              ,
						'camera-retro'         , 'car'                  , 'caret-square-o-down' ,
						'caret-square-o-left'  , 'caret-square-o-right' , 'caret-square-o-up'   ,
						'cart-arrow-down'      , 'cart-plus'            , 'cc'                  ,
						'certificate'          , 'check'                , 'check-circle'        ,
						'check-circle-o'       , 'check-square'         , 'check-square-o'      ,
						'child'                , 'circle'               , 'circle-o'            ,
						'circle-o-notch'       , 'circle-thin'          , 'clock-o'             ,
						'close'                , 'cloud'                , 'cloud-download'      ,
						'cloud-upload'         , 'code'                 , 'code-fork'           ,
						'coffee'               , 'cog'                  , 'cogs'                ,
						'comment'              , 'comment-o'            , 'comments'            ,
						'comments-o'           , 'compass'              , 'copyright'           ,
						'credit-card'          , 'crop'                 , 'crosshairs'          ,
						'cube'                 , 'cubes'                , 'cutlery'             ,
						'dashboard'            , 'database'             , 'desktop'             ,
						'diamond'              , 'dot-circle-o'         , 'download'            ,
						'edit'                 , 'ellipsis-h'           , 'ellipsis-v'          ,
						'envelope'             , 'envelope-o'           , 'envelope-square'     ,
						'eraser'               , 'exchange'             , 'exclamation'         ,
						'exclamation-circle'   , 'exclamation-triangle' , 'external-link'       ,
						'external-link-square' , 'eye'                  , 'eye-slash'           ,
						'eyedropper'           , 'fax'                  , 'female'              ,
						'fighter-jet'          , 'file-archive-o'       , 'file-audio-o'        ,
						'file-code-o'          , 'file-excel-o'         , 'file-image-o'        ,
						'file-movie-o'         , 'file-pdf-o'           , 'file-photo-o'        ,
						'file-picture-o'       , 'file-powerpoint-o'    , 'file-sound-o'        ,
						'file-video-o'         , 'file-word-o'          , 'file-zip-o'          ,
						'film'                 , 'filter'               , 'fire'                ,
						'fire-extinguisher'    , 'flag'                 , 'flag-checkered'      ,
						'flag-o'               , 'flash'                , 'flask'               ,
						'folder'               , 'folder-o'             , 'folder-open'         ,
						'folder-open-o'        , 'frown-o'              , 'futbol-o'            ,
						'gamepad'              , 'gavel'                , 'gear'                ,
						'gears'                , 'genderless'           , 'gift'                ,
						'glass'                , 'globe'                , 'graduation-cap'      ,
						'group'                , 'hdd-o'                , 'headphones'          ,
						'heart'                , 'heart-o'              , 'headphones'          ,
						'history'              , 'home'                 , 'hotel'               ,
						'image'                , 'inbox'                , 'info'                ,
						'info-circle'          , 'institution'          , 'key'                 ,
						'keyboard-o'           , 'language'             , 'laptop'              ,
						'leaf'                 , 'legal'                , 'lemon-o'             ,
						'level-down'           , 'level-up'             , 'life-bouy'           ,
						'life-buoy'            , 'life-ring'            , 'life-saver'          ,
						'lightbulb-o'          , 'line-chart'           , 'location-arrow'      ,
						'lock'                 , 'magic'                , 'magnet'              ,
						'mail-forward'         , 'mail-reply'           , 'mail-reply-all'      ,
						'male'                 , 'map-marker'           , 'meh-o'               ,
						'microphone'           , 'microphone-slash'     , 'minus'               ,
						'minus-circle'         , 'minus-square'         , 'minus-square-o'      ,
						'mobile'               , 'mobile-phone'         , 'money'               ,
						'moon-o'               , 'mortar-board'         , 'motorcycle'          ,
						'music'                , 'navicon'              , 'newspaper-o'         ,
						'paint-brush'          , 'paper-plane'          , 'paper-plane-o'       ,
						'paw'                  , 'pencil'               , 'pencil-square'       ,
						'pencil-square-o'      , 'phone'                , 'phone-square'        ,
						'photo'                , 'picture-o'            , 'pie-chart'           ,
						'plane'                , 'plug'                 , 'plus'                ,
						'plus-circle'          , 'plus-square'          , 'plus-square-o'       ,
						'power-off'            , 'print'                , 'puzzle-piece'        ,
						'qrcode'               , 'question'             , 'question-circle'     ,
						'quote-left'           , 'quote-right'          , 'random'              ,
						'recycle'              , 'refresh'              , 'remove'              ,
						'reorder'              , 'reply'                , 'reply-all'           ,
						'retweet'              , 'road'                 , 'rocket'              ,
						'rss'                  , 'rss-square'           , 'search'              ,
						'search-minus'         , 'search-plus'          , 'send'                ,
						'send-o'               , 'server'               , 'share'               ,
						'share-alt'            , 'share-alt-square'     , 'share-square'        ,
						'share-square-o'       , 'shield'               , 'ship'                ,
						'shopping-cart'        , 'sign-in'              , 'sign-out'            ,
						'signal'               , 'sitemap'              , 'sliders'             ,
						'smile-o'              , 'soccer-ball-o'        , 'sort'                ,
						'sort-alpha-asc'       , 'sort-alpha-desc'      , 'sort-amount-asc'     ,
						'sort-amount-desc'     , 'sort-asc'             , 'sort-desc'           ,
						'sort-down'            , 'sort-numeric-asc'     , 'sort-numeric-desc'   ,
						'sort-up'              , 'space-shuttle'        , 'spinner'             ,
						'spoon'                , 'square'               , 'square-o'            ,
						'star'                 , 'star-half'            , 'star-half-empty'     ,
						'star-half-full'       , 'star-half-o'          , 'star-o'              ,
						'street-view'          , 'suitcase'             , 'sun-o'               ,
						'support'              , 'tablet'               , 'tachometer'          ,
						'tag'                  , 'tags'                 , 'tasks'               ,
						'taxi'                 , 'terminal'             , 'thumb-tack'          ,
						'thumbs-down'          , 'thumbs-o-down'        , 'thumbs-o-up'         ,
						'thumbs-up'            , 'ticket'               , 'times'               ,
						'times-circle'         , 'times-circle-o'       , 'tint'                ,
						'toggle-down'          , 'toggle-left'          , 'toggle-off'          ,
						'toggle-on'            , 'toggle-right'         , 'toggle-up'           ,
						'trash'                , 'trash-o'              , 'tree'                ,
						'trophy'               , 'truck'                , 'tty'                 ,
						'umbrella'             , 'university'           , 'unlock'              ,
						'unlock-alt'           , 'unsorted'             , 'upload'              ,
						'user'                 , 'user-plus'            , 'user-secret'         ,
						'user-times'           , 'users'                , 'video-camera'        ,
						'volume-down'          , 'volume-off'           , 'volume-up'           ,
						'warning'              , 'wheelchair'           , 'wifi'                ,
						'wrench'
					);
					echo '<li class="clear">';
						echo '<li id="web-application-icons" class="clear"><small>Web Application Icons</small></li>';
						foreach ( $web_application_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$transportation_icons = array (
						'ambulance'   , 'automobile' , 'bicycle'       ,
						'bus'         , 'cab'        , 'car'           ,
						'fighter-jet' , 'motorcycle' , 'plane'         ,
						'rocket'      , 'ship'       , 'space-shuttle' ,
						'subway'      , 'taxi'       , 'train'         ,
						'truck'       , 'wheelchair'
					);
					echo '<li class="clear">';
						echo '<li id="transportation-icons" class="clear"><small>Transportation Icons</small></li>';
						foreach ( $transportation_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$gender_icons = array (
						'circle-thin'   , 'genderless'      , 'mars'          ,
						'mars-double'   , 'mars-stroke'     , 'mars-stroke-h' ,
						'mars-stroke-v' , 'mercury'         , 'neuter'        ,
						'transgender'   , 'transgender-alt' , 'venus'         ,
						'venus-double'  , 'venus-mars'
					);
					echo '<li class="clear">';
						echo '<li id="gender-icons" class="clear"><small>Gender Icons</small></li>';
						foreach ( $gender_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$file_type_icons = array (
						'file'         , 'file-archive-o' , 'file-audio-o'      ,
						'file-code-o'  , 'file-excel-o'   , 'file-image-o'      ,
						'file-movie-o' , 'file-o'         , 'file-pdf-o'        ,
						'file-photo-o' , 'file-picture-o' , 'file-powerpoint-o' ,
						'file-sound-o' , 'file-text'      , 'file-text-o'       ,
						'file-video-o' , 'file-word-o'    , 'file-zip-o'
					);
					echo '<li class="clear">';
						echo '<li id="file-type-icons" class="clear"><small>File Type Icons</small></li>';
						foreach ( $file_type_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$spinner_icons = array (
						'circle-o-notch' , 'cog' , 'gear' ,
						'refresh'        , 'spinner'
					);
					echo '<li class="clear">';
						echo '<li id="spinner-icons" class="clear"><small>Spinner Icons</small></li>';
						foreach ( $spinner_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$form_control_icons = array (
						'check-square'   , 'check-square-o' , 'circle'        ,
						'circle-o'       , 'dot-circle-o'   , 'minus-square'  ,
						'minus-square-o' , 'plus-square'    , 'plus-square-o' ,
						'square'         , 'square-o'
					);
					echo '<li class="clear">';
						echo '<li id="form-control-icons" class="clear"><small>Form Control Icons</small></li>';
						foreach ( $form_control_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$payment_icons = array (
						'cc-amex'     , 'cc-discover'   , 'cc-mastercard' ,
						'cc-paypal'   , 'cc-stripe'     , 'cc-visa'       ,
						'credit-card' , 'google-wallet' , 'paypal'
					);
					echo '<li class="clear">';
						echo '<li id="payment-icons" class="clear"><small>Payment Icons</small></li>';
						foreach ( $payment_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$chart_icons = array (
						'area-chart' , 'bar-chart' , 'bar-chart-o' ,
						'line-chart' , 'pie-chart'
					);
					echo '<li class="clear">';
						echo '<li id="chart-icons" class="clear"><small>Chart Icons</small></li>';
						foreach ( $chart_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$currency_icons = array (
						'bitcoin' , 'btc'    , 'cny'          ,
						'dollar'  , 'eur'    , 'euro'         ,
						'gbp'     , 'ils'    , 'inr'          ,
						'jpy'     , 'krw'    , 'money'        ,
						'rmb'     , 'rouble' , 'rub'          ,
						'ruble'   , 'rupee'  , 'shekel'       ,
						'sheqel'  , 'try'    , 'turkish-lira' ,
						'usd'     , 'won'    , 'yen'
					);
					echo '<li class="clear">';
						echo '<li id="currency-icons" class="clear"><small>Currency Icons</small></li>';
						foreach ( $currency_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$text_editor_icons = array (
						'align-center' , 'align-justify' , 'align-left'  ,
						'align-right'  , 'bold'          , 'chain'       ,
						'chain-broken' , 'clipboard'     , 'columns'     ,
						'copy'         , 'cut'           , 'dedent'      ,
						'eraser'       , 'file'          , 'file-o'      ,
						'file-text'    , 'file-text-o'   , 'files-o'     ,
						'floppy-o'     , 'font'          , 'header'      ,
						'indent'       , 'italic'        , 'link'        ,
						'list'         , 'list-alt'      , 'list-ol'     ,
						'list-ul'      , 'outdent'       , 'paperclip'   ,
						'paragraph'    , 'paste'         , 'repeat'      ,
						'rotate-left'  , 'rotate-right'  , 'save'        ,
						'scissors'     , 'strikethrough' , 'subscript'   ,
						'superscript'  , 'table'         , 'text-height' ,
						'text-width'   , 'th'            , 'th-large'    ,
						'th-list'      , 'underline'     , 'undo'        ,
						'unlink'
					);
					echo '<li class="clear">';
						echo '<li id="text-editor-icons" class="clear"><small>Text Editor Icons</small></li>';
						foreach ( $text_editor_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$directional_icons = array (
						'angle-double-down'    , 'angle-double-left'    , 'angle-double-right'   ,
						'angle-double-up'      , 'angle-down'           , 'angle-left'           ,
						'angle-right'          , 'angle-up'             , 'arrow-circle-down'    ,
						'arrow-circle-left'    , 'arrow-circle-o-down'  , 'arrow-circle-o-left'  ,
						'arrow-circle-o-right' , 'arrow-circle-o-up'    , 'arrow-circle-right'   ,
						'arrow-circle-up'      , 'arrow-down'           , 'arrow-left'           ,
						'arrow-right'          , 'arrow-up'             , 'arrows'               ,
						'arrows-alt'           , 'arrows-h'             , 'arrows-v'             ,
						'caret-down'           , 'caret-left'           , 'caret-right'          ,
						'caret-square-o-down'  , 'caret-square-o-left'  , 'caret-square-o-right' ,
						'caret-square-o-up'    , 'caret-up'             , 'chevron-circle-down'  ,
						'chevron-circle-left'  , 'chevron-circle-right' , 'chevron-circle-up'    ,
						'chevron-down'         , 'chevron-left'         , 'chevron-right'        ,
						'chevron-up'           , 'hand-o-down'          , 'hand-o-left'          ,
						'hand-o-right'         , 'hand-o-up'            , 'long-arrow-down'      ,
						'long-arrow-left'      , 'long-arrow-right'     , 'long-arrow-up'        ,
						'toggle-down'          , 'toggle-left'          , 'toggle-right'         ,
						'toggle-up'
					);
					echo '<li class="clear">';
						echo '<li id="directional-icons" class="clear"><small>Directional Icons</small></li>';
						foreach ( $directional_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$video_player_icons = array (
						'arrows-alt'    , 'backward'     , 'compress'      ,
						'eject'         , 'expand'       , 'fast-backward' ,
						'fast-forward'  , 'forward'      , 'pause'         ,
						'play'          , 'play-circle'  , 'play-circle-o' ,
						'step-backward' , 'step-forward' , 'stop'          ,
						'youtube-play'
					);
					echo '<li class="clear">';
						echo '<li id="video-player-icons" class="clear"><small>Video Player Icons</small></li>';
						foreach ( $video_player_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$brand_icons = array (
						'adn'               , 'android'          , 'angellist'           ,
						'apple'             , 'behance'          , 'behance-square'     ,
						'bitbucket'         , 'bitbucket-square' , 'bitcoin'            ,
						'btc'               , 'buysellads'       , 'cc-amex'            ,
						'cc-discover'       , 'cc-mastercard'    , 'cc-paypal'          ,
						'cc-stripe'         , 'cc-visa'          , 'codepen'            ,
						'connectdevelop'    , 'css3'             , 'dashcube'           ,
						'delicious'         , 'deviantart'       , 'digg'               ,
						'dribbble'          , 'dropbox'          , 'drupal'             ,
						'empire'            , 'facebook'         , 'facebook-f'         ,
						'facebook-official' , 'facebook-square'  , 'flickr'             ,
						'forumbee'          , 'foursquare'       , 'ge'                 ,
						'git'               , 'git-square'       , 'github'             ,
						'github-alt'        , 'github-square'    , 'gittip'             ,
						'google'            , 'google-plus'      , 'google-plus-square' ,
						'google-wallet'     , 'gratipay'         , 'hacker-news'        ,
						'html5'             , 'instagram'        , 'ioxhost'            ,
						'joomla'            , 'jsfiddle'         , 'lastfm'             ,
						'lastfm-square'     , 'leanpub'          , 'linkedin'           ,
						'linkedin-square'   , 'linux'            , 'maxcdn'             ,
						'meanpath'          , 'medium'           , 'openid'             ,
						'pagelines'         , 'paypal'           , 'pied-piper'         ,
						'pied-piper-alt'    , 'pinterest'        , 'pinterest-p'        ,
						'pinterest-square'  , 'qq'               , 'ra'                 ,
						'rebel'             , 'reddit'           , 'reddit-square'      ,
						'renren'            , 'sellsy'           , 'share-alt'          ,
						'share-alt-square'  , 'shirtsinbulk'     , 'simplybuilt'        ,
						'skyatlas'          , 'skype'            , 'slack'              ,
						'slideshare'        , 'soundcloud'       , 'spotify'            ,
						'stack-exchange'    , 'stack-overflow'   , 'steam'              ,
						'steam-square'      , 'stumbleupon'      , 'stumbleupon-circle' ,
						'tencent-weibo'     , 'trello'           , 'tumblr'             ,
						'tumblr-square'     , 'twitch'           , 'twitter'            ,
						'twitter-square'    , 'viacoin'          , 'vimeo-square'       ,
						'vine'              , 'vk'               , 'wechat'             ,
						'weibo'             , 'weixin'           , 'whatsapp'           ,
						'windows'           , 'wordpress'        , 'xing'               ,
						'xing-square'       , 'yahoo'            , 'yelp'               ,
						'youtube'           , 'youtube-play'     , 'youtube-square'
					);
					echo '<li class="clear">';
						echo '<li id="brand-icons" class="clear"><small>Brand Icons</small></li>';
						foreach ( $brand_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;

					$medical_icons = array (
						'ambulance' , 'h-square'    , 'heart'       ,
						'heart-o'   , 'heartbeat'   , 'hospital-o'  ,
						'medkit'    , 'plus-square' , 'stethoscope' ,
						'user-md'   , 'wheelchair'
					);
					echo '<li class="clear">';
						echo '<li id="medical-icons" class="clear"><small>Medical Icons</small></li>';
						foreach ( $medical_icons as &$icon ) {
							$icon = sanitize_text_field ( $icon );?>
							<li onclick="insertAtCaret('content','[font-fa i=\'<?php echo ( $icon );?>\']')" title="[font-fa i='<?php echo ( $icon );?>']">
								<i class="fa fa-<?php echo ( $icon );?>"></i>
							</li>
						<?php }
					echo '</li>';
					$icon = null;
				?>
				</ol>
				<script>
					function insertAtCaret(areaId,text) {
						var txtarea = document.getElementById(areaId);
						var scrollPos = txtarea.scrollTop;
						var strPos = 0;
						var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
							"ff" : (document.selection ? "ie" : false ) );
						if (br == "ie") {
							txtarea.focus();
							var range = document.selection.createRange();
							range.moveStart ('character', -txtarea.value.length);
							strPos = range.text.length;
						}
						else if (br == "ff") strPos = txtarea.selectionStart;
						var front = (txtarea.value).substring(0,strPos);
						var back = (txtarea.value).substring(strPos,txtarea.value.length);
						txtarea.value=front+text+back;
						strPos = strPos + text.length;
						if (br == "ie") {
							txtarea.focus();
							var range = document.selection.createRange();
							range.moveStart ('character', -txtarea.value.length);
							range.moveStart ('character', strPos);
							range.moveEnd ('character', 0);
							range.select();
						}
						else if (br == "ff") {
							txtarea.selectionStart = strPos;
							txtarea.selectionEnd = strPos;
							txtarea.focus();
						}
						txtarea.scrollTop = scrollPos;
					}
				</script>
			</div>
		</div>
	<?php }

}

add_action ( 'edit_form_after_editor' ,'myoptionalmodules_fontfa_posteditscreen' );