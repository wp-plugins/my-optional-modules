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
		$url  = sanitize_text_field( esc_url ( $url ) );
		//$chck = sanitize_text_field( strtolower( $url ) );
		if( preg_match( '/\/\/(.*imgur\.com\/.*)/i', $url ) ) {
			if( strpos( strtolower( $url ), 'imgur.com/a/' ) !== false ) {
				$url = substr ( $url, 19 );
				echo '<iframe class="imgur-album" width="100%" height="550" frameborder="0" src="//imgur.com/a/' . $url . '/embed"></iframe>'; 
			} else {
				$url = esc_url ( $url );
				echo '<img class="image" alt="image" src="' . $url . '"/>';
			}
		}
		elseif( preg_match( '/\/\/(.*youtube\.com\/.*)/i', $url ) ) {
			// Probably a much better way of doing this..
			$timeStamp = '';
			if( strpos( strtolower( $url ), '038;t=' ) !== false && strpos( strtolower( $url ), 'list=' ) === false ) {
				$url_parse = parse_url( strtolower( $url ) );
				$timeStamp = sanitize_text_field( str_replace( '038;t=', '', $url_parse[ 'fragment' ] ) );
				$minutes   = 0;
				$seconds   = 0;
				if( strpos( $timeStamp, 'm' ) !== false && strpos( $timeStamp, 's' ) !== false ){
					$parts     = str_replace( array( 'm','s' ), '', $timeStamp );
					list( $minutes, $seconds ) = $parts = str_split( $parts );
					$minutes   = $minutes * 60;
					$seconds   = $seconds * 1;
				} elseif( strpos( $timeStamp, 'm' ) !== true && strpos( $timeStamp, 's' ) !== false ) {
					$seconds   = str_replace( 's', '', $timeStamp ) * 1;
				} elseif( strpos( $timeStamp, 'm' ) !== false && strpos( $timeStamp, 's' ) !== true ) {
					$minutes   = str_replace( 'm', '', $timeStamp ) * 60;
				} else {
					$minutes = 0;
					$seconds = 0;
				}
				
				$timeStamp = $minutes + $seconds;

			}
			if ( preg_match ( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) {
				$match[1] = sanitize_text_field ( $match[1] );
				$video_id = $match[1];
				$url      = $video_id;
			}
			echo '
			<object width="640" height="390" data="https://www.youtube.com/v/' . $url . '?version=3&amp;start=' . $timeStamp . '">
				<param name="movie" value="https://www.youtube.com/v/' . $url . '?version=3&amp;start=' . $timeStamp . '" />
				<param name="allowScriptAccess" value="always" />
				<embed src="https://www.youtube.com/v/' . $url . '?version=3&amp;start=' . $timeStamp . '"
					type="application/x-shockwave-flash"
					allowscriptaccess="always"
					width="640" 
					height="390" />
				
			</object>
			';
		}
		elseif( preg_match( '/\/\/(.*liveleak\.com\/.*)/i', $url ) ) {
			$url      = parse_url( $url );
			$video_id = str_replace( 'i=', '', $url[ 'query' ] );
			echo '
				<object width="640" height="390" data="http://www.liveleak.com/e/' . $video_id . '">
					<param name="movie" value="http://www.liveleak.com/e/' . $video_id . '" />
					<param name="wmode" value="transparent" />
					<embed src="http://www.liveleak.com/e/' . $video_id . '" 
						type="application/x-shockwave-flash" 
						wmode="transparent" 
						width="640" 
						height="390" />
				</object>
			';              
		}			
		elseif( preg_match( '/\/\/(.*youtu\.be\/.*)/i', $url ) ) {
			$url = explode( '/', $url );
			$url = $url[sizeof($url)-1];
			echo '
			<object width="640" height="390" data="https://www.youtube.com/v/' . $url . '?version=3">
				<param name="movie" value="https://www.youtube.com/v/' . $url . '?version=3" />
				<param name="allowScriptAccess" value="always" />
				<embed src="https://www.youtube.com/v/' . $url . '?version=3"
					type="application/x-shockwave-flash"
					allowscriptaccess="always"
					width="640" 
					height="390" />
			</object>
			';              
		}           
		elseif( preg_match( '/\/\/(.*soundcloud\.com\/.*)/i', $url ) ) {
			echo '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="http://w.soundcloud.com/player/?url=' . $url . '&auto_play=false&color=915f33&theme_color=00FF00"></iframe>'; 
		}
		elseif( preg_match( '/\/\/(.*vimeo\.com\/.*)/i', $url ) ) {
			$url = explode( '/', $url );
			$url = $url[sizeof($url)-1];
			echo '<iframe src="//player.vimeo.com/video/' . $url . '?title=0&amp;byline=0&amp;portrait=0&amp;color=d6cece" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'; 
		}
		elseif( preg_match( '/\/\/(.*gfycat\.com\/.*)/i', $url ) ) {
			$url = str_replace ( '//gfycat.com/', '', $url );
			echo '<iframe src="//gfycat.com/iframe/' . $url . '" frameborder="0" scrolling="no" width="592" height="320" ></iframe>';
		}
		elseif( preg_match( '/\/\/(.*funnyordie\.com\/.*)/i', $url ) ) {
			$url = explode( '/', $url );
			$url = $url[sizeof($url)-2];
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
		elseif( preg_match( '/\/\/(.*vine\.co\/.*)/i', $url ) ) {
			$url = $url . '/embed/postcard';
			echo '<iframe class="vine-embed" src="' . $url . '" width="600" height="600" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>';
		} else {
			// //codex.wordpress.org/Embeds
			echo wp_oembed_get( $url );
		}
	}
}