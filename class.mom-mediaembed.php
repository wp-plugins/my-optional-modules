<?php 
/**
 * class.mom_mediaEmbed
 * new mom_mediaEmbed( 'URL' )
 */

if(!defined('MyOptionalModules')){
	die();
}

class mom_mediaEmbed {

	var $url;

	function mom_mediaEmbed ( $url ) {

		$url       = esc_url ( $url );
		$host      = null;
		$path      = null;
		$query     = null;
		$timestamp = null;

		if ( filter_var( $url, FILTER_VALIDATE_URL ) !== false )
			if ( isset ( parse_url ( $url ) [ 'host'  ] ) ) 
				$host  = parse_url ( $url ) [ 'host'  ];
			if ( isset ( parse_url ( $url ) [ 'path'  ] ) )
				$path  = parse_url ( $url ) [ 'path'  ];
			if ( isset ( parse_url ( $url ) [ 'query' ] ) )
				$query = parse_url ( $url ) [ 'query' ];

		if ( $host ) {

			if( strpos ( $host, 'funnyordie.com' ) !== false ) {
				$url = explode ( '/' , $url );
				$url = $url [ sizeof ( $url ) - 2 ];
				echo '
				<object width="640" height="400" id="ordie_player_' . $url . '" data="http://player.ordienetworks.com/flash/fodplayer.swf">
					<param name="movie" value="http://player.ordienetworks.com/flash/fodplayer.swf" />
					<param name="flashvars" value="key=' . $url . '" />
					<param name="allowfullscreen" value="true" />
					<param name="allowscriptaccess" value="always">
					<embed width="640" height="400" flashvars="key=' . $url . '" allowfullscreen="true" allowscriptaccess="always" quality="high" src="http://player.ordienetworks.com/flash/fodplayer.swf" name="ordie_player_5325b03b52" type="application/x-shockwave-flash"></embed>
				</object>
				';
			}

			// gfycat
			elseif( strpos ( $host , 'gfycat.com' ) !== false ) {
				$url = str_replace ( array ( 'https://' , 'http://' , 'gfycat.com' ), '', $url );
				echo '<iframe src="//gfycat.com/iframe/' . $url . '" frameborder="0" scrolling="no" width="592" height="320" ></iframe>';
			}

			// imgur
			elseif ( strpos ( $host , 'imgur.com' ) !== false ) {
				$url = str_replace ( array ( 'https://' , 'http://' , 'imgur.com/album/' , 'i.imgur.com/' ) , '' , $url );
				if ( strpos ( $path , '/album/' ) !== false ) 
					echo '<iframe class="imgur-album" width="100%" height="550" frameborder="0" src="//imgur.com/a/' . $url . '/embed"></iframe>';
				else
					echo '<img class="image" alt="image" src="//i.imgur.com/' . $url . '"/>';
			}

			// liveleak
			elseif( strpos ( $host , 'liveleak.com' ) !== false ) {
				$url = str_replace( 'i=', '', $query );
				echo '
				<object width="640" height="390" data="http://www.liveleak.com/e/' . $url . '">
					<param name="movie" value="http://www.liveleak.com/e/' . $url . '" />
					<param name="wmode" value="transparent" />
					<embed src="http://www.liveleak.com/e/' . $url . '"
						type="application/x-shockwave-flash"
						wmode="transparent"
						width="640"
						height="390" />
				</object>';
			}

			// soundcloud
			elseif( strpos ( $host , 'soundcloud.com' ) !== false ) {
				echo '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="http://w.soundcloud.com/player/?url=' . $url . '&auto_play=false&color=915f33&theme_color=00FF00"></iframe>'; 
			}

			// vimeo
			elseif( strpos( $host , 'vimeo.com' ) !== false ) {
				$url = explode( '/' , $url );
				$url = $url [ sizeof ( $url ) - 1 ];
				echo '<iframe src="//player.vimeo.com/video/' . $url . '?title=0&amp;byline=0&amp;portrait=0&amp;color=d6cece" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'; 
			}

			// vine
			elseif( strpos ( $host , 'vine.co' ) !== false && strpos ( $path , 'v' ) !== false ) {
				echo '<iframe class="vine-embed" src="//' . $url . '/embed/postcard" width="600" height="600" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>';
			}
			
			// youtube
			elseif ( strpos ( $host , 'youtube.com' ) !== false || strpos ( $host , 'youtu.be' ) !== false ) {
				if ( strpos ( strtolower ( $url ), '038;t=' ) !== false && strpos ( strtolower ( $url ), 'list=' ) === false ) {
					$url_parse = parse_url ( strtolower ( $url ) );
					$timeStamp = sanitize_text_field ( str_replace ( '038;t=', '', $url_parse [ 'fragment' ] ) );
					$minutes   = 0;
					$seconds   = 0;
					if ( strpos( $timeStamp, 'm' ) !== false && strpos ( $timeStamp, 's' ) !== false ) {
						$parts     = str_replace ( array ( 'm' , 's' ) , '' , $timeStamp );
						list ( $minutes , $seconds ) = $parts = str_split ( $parts );
						$minutes   = $minutes * 60;
						$seconds   = $seconds * 1;
					} elseif ( strpos ( $timeStamp , 'm' ) !== true && strpos ( $timeStamp , 's' ) !== false ) {
						$seconds   = str_replace( 's' , '' , $timeStamp ) * 1;
					} elseif ( strpos ( $timeStamp , 'm' ) !== false && strpos ( $timeStamp, 's' ) !== true ) {
						$minutes   = str_replace ( 'm' , '' , $timeStamp ) * 60;
					} else {
						$minutes = 0;
						$seconds = 0;
					}
					$timeStamp = '&amp;start-' . $minutes + $seconds;
				}
				if ( strpos ( $host , 'youtu.be' ) !== false )
					$url = explode ( '/' , $url );
					$url = $url [ sizeof ( $url ) - 1 ];
				if ( strpos ( $host , 'youtu.be' ) === false )
					$url = str_replace ( array ( 'v=' , '&' ) , '' , $query );
				echo '
				<object width="640" height="390" data="https://www.youtube.com/v/' . $url . '?version=3&amp;start=' . $timeStamp . '">
					<param name="movie" value="https://www.youtube.com/v/' . $url . '?version=3&amp;start=' . $timeStamp . '" />
					<param name="allowScriptAccess" value="always" />
					<embed src="https://www.youtube.com/v/' . $url . '?version=3' . $timeStamp . '"
						type="application/x-shockwave-flash"
						allowscriptaccess="always"
						width="640" 
						height="390" />
				</object>';
			}

			// embeds not handled by the above
			// codex.wordpress.org/Embeds
			else {
				echo wp_oembed_get( $url );
			}

		}

	}

}