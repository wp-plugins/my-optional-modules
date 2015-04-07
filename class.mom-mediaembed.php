<?php 
/**
 * CLASS mom_mediaEmbed()
 *
 * File last update: 9.1.8
 *
 * Create a media embed from a URL in a template (or other) by passing a 
 * URL through the class:
 * - new mom_mediaEmbed( 'URL' )
 *
 * Separate multiple embeds with :: ( URL::URL2::URL3::URL4 )
 */

if ( !defined ('MyOptionalModules' ) ) {
	die();
}

class mom_mediaEmbed {

	var $url;

	function mom_mediaEmbed ( $url ) {

		$url    = esc_url ( $url );
		$output = $host = $path = $query = $timestamp = $thumbnail = $embed = null;
		
		$urls = explode ( '::' , $url );
		
		foreach ( $urls as $url ) {
			
			$output .= '<div class="media-embed">';
			
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
					$url = sanitize_text_field ( $url );
					$output .= "
					<object width='640' height='400' id='ordie_player_{$url}' data='http://player.ordienetworks.com/flash/fodplayer.swf'>
						<param name='movie' value='http://player.ordienetworks.com/flash/fodplayer.swf' />
						<param name='flashvars' value='key={$url}' />
						<param name='allowfullscreen' value='true' />
						<param name='allowscriptaccess' value='always'>
						<embed width='640' height='400' flashvars='key={$url}' allowfullscreen='true' allowscriptaccess='always' quality='high' src='http://player.ordienetworks.com/flash/fodplayer.swf' name='ordie_player_5325b03b52' type='application/x-shockwave-flash'></embed>
					</object>
					";
				}

				// gfycat
				elseif( strpos ( $host , 'gfycat.com' ) !== false ) {
					$url = str_replace ( array ( 'https://' , 'http://' , 'gfycat.com' ), '', $url );
					$url = sanitize_text_field ( $url );
					$output .= "<iframe src='//gfycat.com/iframe{$url}' frameborder='0' scrolling='no' width='592' height='320' ></iframe>";
				}

				// imgur
				elseif ( strpos ( $host , 'imgur.com' ) !== false ) {
					$url = str_replace ( array ( 'https://' , 'http://' , 'imgur.com/a/' , 'i.imgur.com/' ) , '' , $url );
					$url = sanitize_text_field ( $url );
					if ( strpos ( $path , '/a/' ) !== false ) 
						$output .= "<iframe class='imgur-album' src='//imgur.com/a/{$url}/embed'></iframe>";
					else
						$output .= "<img class='imgur-image' alt='image' src='//i.imgur.com/{$url}'/>";
				}

				// liveleak
				elseif( strpos ( $host , 'liveleak.com' ) !== false ) {
					$url = str_replace( 'i=', '', $query );
					$url = sanitize_text_field ( $url );
					$output .= "
					<object width='640' height='390' data='http://www.liveleak.com/e/{$url}'>
						<param name='movie' value='http://www.liveleak.com/e/{$url}' />
						<param name='wmode' value='transparent' />
						<embed src='http://www.liveleak.com/e/{$url}'
							type='application/x-shockwave-flash'
							wmode='transparent'
							width='640'
							height='390' />
					</object>";
				}

				// soundcloud
				elseif( strpos ( $host , 'soundcloud.com' ) !== false ) {
					$url = sanitize_text_field ( $url );
					$output .= "<iframe class='soundcloud-embed' src='http://w.soundcloud.com/player/?url={$url}&auto_play=false&color=915f33&theme_color=00FF00'></iframe>"; 
				}

				// vimeo
				elseif( strpos( $host , 'vimeo.com' ) !== false ) {
					$url = explode( '/' , $url );
					$url = $url [ sizeof ( $url ) - 1 ];
					$url = sanitize_text_field ( $url );
					$output .= "<iframe src='//player.vimeo.com/video/{$url}?title=0&amp;byline=0&amp;portrait=0&amp;color=d6cece' class='vimeo-embed' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
				}

				// vine
				elseif( strpos ( $host , 'vine.co' ) !== false && strpos ( $path , 'v' ) !== false ) {
					$url = sanitize_text_field ( $url );
					$output .= "<iframe class='vine-embed' src='{$url}/embed/postcard'></iframe><script async src='//platform.vine.co/static/scripts/embed.js' charset='utf-8'></script>";
				}
				
				// youtube
				elseif ( strpos ( $host , 'youtube.com' ) !== false || strpos ( $host , 'youtu.be' ) !== false ) {
					if ( strpos ( strtolower ( $url ), '038;t=' ) !== false && strpos ( strtolower ( $url ), 'list=' ) === false ) {
						$url_parse = parse_url ( strtolower ( $url ) );
						$timestamp = sanitize_text_field ( str_replace ( '038;t=', '', $url_parse [ 'fragment' ] ) );
						$minutes   = 0;
						$seconds   = 0;
						if ( strpos( $timestamp, 'm' ) !== false && strpos ( $timestamp, 's' ) !== false ) {
							$parts     = str_replace ( array ( 'm' , 's' ) , '' , $timestamp );
							list ( $minutes , $seconds ) = $parts = str_split ( $parts );
							$minutes   = $minutes * 60;
							$seconds   = $seconds * 1;
						} elseif ( strpos ( $timestamp , 'm' ) !== true && strpos ( $timestamp , 's' ) !== false ) {
							$seconds   = str_replace( 's' , '' , $timestamp ) * 1;
						} elseif ( strpos ( $timestamp , 'm' ) !== false && strpos ( $timestamp, 's' ) !== true ) {
							$minutes   = str_replace ( 'm' , '' , $timestamp ) * 60;
						} else {
							$minutes = 0;
							$seconds = 0;
						}
						$timestamp = '&amp;start-' . $minutes + $seconds;
					}
					if ( strpos ( $host , 'youtu.be' ) !== false )
						$url = explode ( '/' , $url );
						$url = $url [ sizeof ( $url ) - 1 ];
					if ( strpos ( $host , 'youtu.be' ) === false )
						$url = str_replace ( array ( 'v=' , '&' ) , '' , $query );
			
					$url       = sanitize_text_field ( $url );
					$thumbnail = "//img.youtube.com/vi/{$url}/0.jpg";
					
					$output .= "
					<div id='mom-youtube-{$url}' class='mom-youtube-content-div'>
						<img src='{$thumbnail}' data-time='{$timestamp}' data-video='{$url}' id='mom-youtube-thumbnail-{$url}' class='skipLazy mom-youtube-thumbnail' />
						<i class='mom-youtube-play-button fa fa-play-circle'> &mdash; click thumbnail to play</i>
					</div>
					<noscript>
						<object width='640' height='390' data='https://www.youtube.com/v/{$url}?version=3{$timestamp}'>
							<param name='movie' value='https://www.youtube.com/v/{$url}?version=3{$timestamp}' />
							<param name='allowScriptAccess' value='always' />
							<embed src='https://www.youtube.com/v/{$url}?version=3{$timestamp}'
							type='application/x-shockwave-flash'
							allowscriptaccess='always'
							width='640' 
							height='390' />
						</object>
					</noscript>";
				}
				
				// gists
				elseif ( strpos ( $host , 'gist.github.com' ) !== false ) {
					$path    = sanitize_text_field ( $path );
					$output .= "<script src='https://gist.github.com{$path}.js'></script>";
				}

				// embeds not handled by the above
				// codex.wordpress.org/Embeds
				else {
					$url = sanitize_text_field ( $url );
					echo wp_oembed_get ( $url );
				}
				
				$output .= '</div>';
			
			}

		}
		
		echo $output;

	}

}