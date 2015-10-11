<?php
/**
 * CLASS mom-reddit()
 *
 * File last update: 11.1
 *
 * Embed a subreddit into WordPress
 *
 * [mom_reddit sub='']
 *
 */

defined('MyOptionalModules') or exit;

class mom_reddit {
	
	function __construct() {

		$myoptionalmodules_custom_redditfeed = sanitize_text_field ( get_option ( 'myoptionalmodules_custom_redditfeed' ) );
		if ( '' == $myoptionalmodules_custom_redditfeed ) {

			$myoptionalmodules_custom_reddtifeed = 'mom_reddit';

		}
		
		remove_shortcode ( $myoptionalmodules_custom_redditfeed );
		add_shortcode ( $myoptionalmodules_custom_redditfeed , array ( $this , 'shortcode' ) );
		add_action  ( 'wp_print_styles' , array ( $this , 'stylesheet' ) );

	}
	

	function stylesheet() {

		$reddit_css = str_replace ( 
			array (  
				'https:' , 'http:' 
			) , 
			'' , 
			plugins_url() . '/' . plugin_basename ( dirname ( __FILE__ ) ) . '/css.css'
		);
		wp_register_style ( 'reddit_css' , $reddit_css );
		wp_enqueue_style  ( 'reddit_css' );

	}

	function shortcode ( $atts ) {

		extract (
			shortcode_atts (
				array (
					'sub'  => '' ,
				),
				$atts
			)
		);

		$sub = strtolower ( sanitize_text_field ( $sub ) );
		
		if ( $sub ):
			$json = json_decode ( file_get_contents ( 'http://reddit.com/r/' . sanitize_text_field ( $sub ) . '/.json' ) );
		elseif ( $user ):
			$json = json_decode ( file_get_contents ( 'http://reddit.com/user/' . sanitize_text_field ( $user ) . '/.json' ) );
		endif;
		
		$output = null;
		
		if ( $sub || $user ):
			$data = $json->data->children;
			
			if ( $sub ):
				if ( $data ):
					$output .= '<div class="myoptionalmodules-subreddit">';
					foreach ( $data as $value ):
						$domain    = null;
						$title     = null;
						$url       = null;
						$permalink = null;
						$author    = null;
						$stickied  = null;
						$created   = null;
						$thumb     = null;
						$gild      = null;
						$comments  = null;
						$score     = null;
						$nsfw      = null;
						$over18    = false;
						$div       = 'nonstickied';
						$padding   = 'no-image';
						
						if ( true == $value->data->stickied ):
							$div      = 'stickied';
							$stickied = '<i class="fa fa-sticky-note"> sticky</i>';
						endif;
						if ( $value->data->domain ):
							$domain = sanitize_text_field ( $value->data->domain );
							$domain = "<small>(<a href='//reddit.com/domain/{$domain}'>{$domain}</a>)</small>";
						endif;
						if ( $value->data->title ):
							$title = sanitize_text_field ( $value->data->title );
						endif;
						if ( $value->data->url ):
							$url = esc_url ( $value->data->url );
							$url = "<a href='{$url}'>{$title}</a>";
						endif;
						if ( $value->data->gilded ):
							$gild = intval ( $value->data->gilded );
						endif;
						if ( $value->data->permalink ):
							$permalink = esc_url ( '//reddit.com/' . $value->data->permalink );
						endif;
						if ( $value->data->num_comments ): 
							$comments = intval ( $value->data->num_comments );
							$comments = "<a href='{$permalink}'>{$comments} comments</a>";
						else:
							$comments = '<em>no comments</em>';
						endif;
						if ( $value->data->score ):
							$score = intval ( $value->data->score );
							$score = "<span class='listing-score'>{$score}</span>";
						else:
							$score = '<span class="listing-score">0</span>';
						endif;
						if ( $value->data->author ):
							$author = sanitize_text_field ( $value->data->author );
							$author = " by <a href='//reddit.com/user/{$author}'>{$author}</a>";
						endif;
						if ( $value->data->created_utc ):
							$date = $value->data->created_utc;
							$date = date( 'Y-m-d H:i:s' , $date );
							$date = "submitted {$author} on {$date}";
						endif;
						if ( 'self' != strtolower ( $value->data->thumbnail ) ):
							if ( true == $value->data->over_18 ):
								$thumb = null;
								$nsfw  = '<span class="nsfw">nsfw</span>';
							else:
								if ( !strpos ( strtolower ( $value->data->title ) , 'spoiler' ) ):
									$padding = 'image';
									$thumb   = esc_url ( $value->data->thumbnail );
									$thumb   = "<img src='{$thumb}' class='thumb' />";
								else:
									$thumb   = null;
								endif;
							endif;
						else:
							$thumb = null;
						endif;
						
						$output .= "
							<div class='reddit-item-listing {$div} {$padding}'>
								{$score}{$stickied}
								{$thumb}
								<span class='listing-title'>
									{$url} {$domain}
								</span>
								<span class='listing-date'>
									{$date}
								</span>
								<span class='listing-information'>
								{$nsfw} {$comments}
								</span>
							</div>
						";
					endforeach;
					$output .= '</div>';
				endif;
			endif;
		endif;
		
		return $output;

	}
	
}

$mom_reddit = new mom_reddit();