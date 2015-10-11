<?php
/**
 * CLASS mom-reddit()
 *
 * File last update: 11.1.1
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
					'sub'    => ''    ,
					'sticky' => 1     ,
					'score'  => 0     ,
					'thumbs' => 1     ,
					'nsfw'   => 1     ,
					'type'   => 'all' ,
					'amount' => '25'  ,
				),
				$atts
			)
		);

		$count  = 0;
		$sub    = strtolower ( sanitize_text_field ( $sub ) );
		$type   = strtolower ( sanitize_text_field ( $type ) );
		$sticky = intval ( $sticky );
		$score  = intval ( $score );
		$thumbs = intval ( $thumbs );
		$nsfw   = intval ( $nsfw );
		
		$output_open = null;
		$post        = null;
		$output_end  = null;
		
		if ( $sub ):
			$json = json_decode ( file_get_contents ( 'http://reddit.com/r/' . sanitize_text_field ( $sub ) . '/.json' ) );
		endif;
		
		if ( $sub || $user ):
			$data = $json->data->children;
			
			if ( $sub ):
				if ( $data ):
					$output_open .= "
					<div class='myoptionalmodules-subreddit'>
						<span class='title-bar'><a href='//reddit.com/r/{$sub}'>r/{$sub}</a></span>
						<div class='inner'><i class='fa fa-reddit'> powered by <a href='//reddit.com/'>reddit</a></i>";
					foreach ( $data as $value ):
						++$count;
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
						$points    = null;
						$is_nsfw   = null;
						$over18    = false;
						$div       = 'nonstickied';
						$padding   = 'no-image';
						$is_self   = $value->data->is_self;
						
						$subreddit = strtolower ( sanitize_text_field ( $value->data->subreddit ) );
						
						if ( true == $value->data->stickied ):
							$div      = 'stickied';
							$stickied = '<i class="fa fa-sticky-note"> sticky</i>';
						endif;
						if ( $value->data->domain ):
							$domain_raw = sanitize_text_field ( $value->data->domain );
							$domain     = sanitize_text_field ( $value->data->domain );
							$domain     = "<small>(<a href='//reddit.com/domain/{$domain}'>{$domain}</a>)</small>";
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
							$comments = "<a href='{$permalink}'><em>no comments</em></a>";
						endif;
						if ( $value->data->score ):
							$raw_score = intval ( $value->data->score );
							$points    = intval ( $value->data->score );
							$points    = "<span class='listing-score'>{$points}</span>";
						else:
							$points = '<span class="listing-score">0</span>';
						endif;
						if ( $value->data->author ):
							$author = sanitize_text_field ( $value->data->author );
							$author = " by <a href='//reddit.com/user/{$author}'>{$author}</a>";
						endif;
						if ( $value->data->created_utc ):
							$date          = $value->data->created_utc;
							$date_readable = date( 'Y-m-d H:i:s' , $date );
							$date          = human_time_diff ( $date , current_time ( 'timestamp' ) );
							$date          = "submitted {$author} {$date} ago";
						endif;
						if ( $value->data->thumbnail && false == $is_self ):
							
							if ( true == $value->data->over_18 ):
								$thumb   = null;
								$is_nsfw = '<span class="nsfw">nsfw</span>';
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
						
						if ( !$thumbs ):
							$padding = 'no-image';
							$thumb   = null;
						endif;
						
						if ( $score >= $raw_score || $count > $amount ):
							$post .= '';
						elseif ( !$sticky && 'stickied' == $div ):
							$post .= '';
						elseif ( !$nsfw && $is_nsfw ):
							$post .= '';
						elseif ( 'self' == $type && false == $is_self ):
							$post .= '';
						elseif ( 'links' == $type && true == $is_self ):
							$post .= '';							
						else:
							$post .= "
								<div class='reddit-item-listing {$div} {$padding}'>
									{$points}{$stickied}
									{$thumb}
									<span class='listing-title'>
										{$url} {$domain}
									</span>
									<span class='listing-date'>
										{$date}
									</span>
									<span class='listing-information'>
									{$is_nsfw} {$comments}
									</span>
								</div>
							";
						endif;

					endforeach;
					$output_end .= '</div></div>';
				endif;
			endif;
		endif;
		
		return $output_open . $post . $output_end;

	}
	
}

$mom_reddit = new mom_reddit();