<?php 
/**
 * CLASS myoptionalmodules_shortcodes()
 *
 * File update: 10.1.8
 *
 * All shortcodes for My Optional Modules
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

function mom_reddit_formatting ( $comment ) {
	$input = array (
		'/\*(.*?)\*/is' ,
		'/\*\*(.*?)\*\*/is' ,
		'/\*\*\*(.*?)\*\*\*/is' ,
		'/\~\~(.*?)\~\~/is' ,
		'/-\-\-\-/is' ,
		'/\`(.*?)\`/is' ,
	);
	$output = array (
		'<em>$1</em>' ,
		'<b>$1</b>' ,
		'<b><em>$1</em></b>' ,
		'<strike>$1</strike>' ,
		'<hr />' ,
		'<code>$1</code>' ,
	);
	$rtrn = preg_replace ( $input , $output , $comment );
	return $rtrn;
}	

class myoptionalmodules_shortcodes{

	function __construct() {
		
		/**
		 * Customize shortcode code
		 */
		
		global $myoptionalmodules_custom_embed;
		global $myoptionalmodules_custom_hidden; 
		global $myoptionalmodules_custom_charts;
		global $myoptionalmodules_custom_categories;
		global $myoptionalmodules_custom_redditfeed;
		
		if( '' == $myoptionalmodules_custom_embed ){
			$myoptionalmodules_custom_embed = 'mom_embed';
		}
		if( '' == $myoptionalmodules_custom_hidden ){
			$myoptionalmodules_custom_hidden = 'mom_hidden';
		}
		if( '' == $myoptionalmodules_custom_charts ){
			$myoptionalmodules_custom_charts = 'mom_charts';
		}
		if( '' == $myoptionalmodules_custom_categories ){
			$myoptionalmodules_custom_categories = 'mom_categories';
		}
		if( '' == $myoptionalmodules_custom_redditfeed ){
			$myoptionalmodules_custom_reddtifeed = 'mom_reddit';
		}
		
		remove_shortcode ( $myoptionalmodules_custom_embed );
		remove_shortcode ( $myoptionalmodules_custom_hidden );
		remove_shortcode ( $myoptionalmodules_custom_charts );
		remove_shortcode ( $myoptionalmodules_custom_categories );
		remove_shortcode ( $myoptionalmodules_custom_redditfeed );
		add_shortcode    ( $myoptionalmodules_custom_embed , array ( $this , 'embed' ) );
		add_shortcode    ( $myoptionalmodules_custom_hidden , array ( $this , 'hidden' ) );
		add_shortcode    ( $myoptionalmodules_custom_charts , array ( $this , 'charts' ) );
		add_shortcode    ( $myoptionalmodules_custom_categories , array ( $this , 'categories' ) );
		add_shortcode    ( $myoptionalmodules_custom_redditfeed , array ( $this , 'reddit' ) );
	}
	
	function embed( $atts ) {
		$url   = null;
		$class = null;
		extract (
			shortcode_atts ( 
				array (
					'url' => '',
					'class' => ''
				), 
				$atts 
			)
		);
		if( $url ) {
			$url = esc_url ( $url );
			if( $class ) {
				sanitize_text_field ( esc_html ( $class ) );
			}
			ob_start();
			if( $class ) {
				echo "<div class='{$class}'>";
			}
			new mom_mediaEmbed ( $url );
			if( $class ) {
				echo '</div>';
			}
			return ob_get_clean();
		}
		$url   = null;
		$class = null;
	}	
	
	function hidden( $atts, $content ) {
		global $wp , $post;
		extract (
			shortcode_atts ( 
				array (
					'logged'  => 0, // (1) on (0) off // whether or not viewer needs to be logged in to view content
					'single'  => 0  // (1) on (0) off // whether or not content will be hidden on single post view
				)
				, $atts 
			)
		);
		$logged = intval ( $logged );
		$single = intval ( $single );
		if( is_single() || is_page() ) {
			$view = 1;
		} else {
			$view = 0;
		}
		if( $logged && !is_user_logged_in() ) {
			$content = null;
		}
		if( !$single && !$view ) {
			$content = null;
		}
		if( $single && $view ) {
			$content = null;
		}
		return do_shortcode ( $content );
	}
	
	function charts( $atts ) {

		/*
		 * [mom_charts type='TYPE' content='CONTENT' total_possible='TOTAL POSSIBLE' overall='0/1']
		 *
		 * [mom_charts type='bar' content='Acting:9::Story:5::Tone:6' total_possible='10' overall='1']
		 * results in a bar graph with 3 items (acting, story, tone) with percent filled based on 
		 * ratings (9, 5, 6) out of total possible (10).
		 *
		 * ITEM DESCRIPTION:RATING::ITEM DESCRIPTION 2:RATING 2:ITEM DESCRIPTION 3:RATING 3...
		 * Item descriptions should not have numbers, ratings should only be numbers.
		 */
	
		$type = $output = null;
		extract (
			shortcode_atts (
				array (
					'type'           => '' ,
					'content'        => '' ,
					'total_possible' => 10 ,
					'overall'        => 0 ,
				)
				, $atts
			)
		);
		$type           = sanitize_text_field ( $type );
		$content        = sanitize_text_field ( $content );
		$total_possible = sanitize_text_field ( $total_possible );
		$overall        = intval ( $overall );
		if ( 'bar' == $type ) {
			$description = $ratings = null;
			$ratings = explode ( '::' , $content );
			if ( $content ) {
				if ( $ratings ) {
					$rate_increase  = $rating_tot = $overall_increase = 0;
					$output .= '<div class="rating">';
					foreach ( $ratings as $rating ) {
						++$rate_increase;
						$invidual_rating = explode ( ':' , $rating );
						$output .= '<div>';
						if ( $invidual_rating ) {
							foreach ( $invidual_rating as $rated ) {
								if ( preg_match_all ('/\((.*?)\)/' , $rated , $match ) ) {
										$description = $match[1];
								}
								$rated       = preg_replace ( "/\([^)]+\)/" , "" , $rated);
								$rating_nom  = preg_replace ( '/[^0-9,.]/' , '' , $rated );
								$rating_tit  = preg_replace ( '/[0-9]+/'   , '' , $rated );
								$percent     = ( $rating_nom / $total_possible * 100 );
								$overall_increase = $overall_increase + $rating_nom;
								$output .= "<em>{$rating_tit}</em>";
								$output .= "<strong>{$rating_nom}</strong>";
								$output .= "<hr style='top:0;left:5px;position:absolute;z-index:0;width:{$percent}%;background-color:rgba(0,0,0,.1);overflow:hidden;height:1px;' />";
								if ( $description ) {
									foreach ( $description as $des ) {
										$des = esc_html ( $des );
										$output .= "<span>{$des}</span>";
									}
								}
								$rating_tot = $rating_tot + $rating_nom;
							}
						}
						$output .= '</div>';
					}
					if ( $overall ) {
						$total_available = $rate_increase * $total_possible;
						$percent         = ( $overall_increase / $total_available * 100 );
						$output .= '<div>';
						$output .= "<em>Overall</em>";
						$output .= "<strong>{$overall_increase} / {$total_available}</strong>";
						$output .= "<hr style='top:0;left:5px;position:absolute;z-index:0;width:{$percent}%;background-color:rgba(0,0,0,.1);overflow:hidden;height:1px;' />";
						$output .= '</div>';
					}
					$output      .= '</div>';
				}
			}
		}
		return $output;
	}
	
	function categories() {
		$output = null;
		$output .= '<div class="mom_cat-container">';
		$args = array(
			'orderby' => 'name',
			'parent' => 0
		);
		$categories = get_categories( $args );
		foreach ( $categories as $category ) {
			$link = get_category_link( $category->term_id );
			$output .= "<div class='mom_cat-containers'><span><strong><a href='{$link}'>{$category->name}</a></strong></span>{$category->description}</div>";
		}
		$output .= '</div>';
		
		return $output;
	}
	
	function reddit( $atts ) {
		extract (
			shortcode_atts ( 
				array (
					'sub'         => '' ,
					'thread'      => '' ,
					'limit'       => 10 ,
					'title'       => '' ,
					'description' => 0
				)
				, $atts 
			)
		);
		
		$sub    = sanitize_text_field ( $sub );
		$thread = sanitize_text_field ( $thread );
		$limit  = intval ( $limit );
		$title  = sanitize_text_field ( $title );
		$output = null;
		$count  = 0;
		
		if ( $sub || $thread ) {
		
			if ( $sub && !$thread ) {
				$url = "https://www.reddit.com/r/{$sub}/.rss?limit={$limit}";
			} elseif ( $thread && !$sub ) {
				$url = "{$thread}/.rss?limit={$limit}";
			} else {
				$url = null;
			}
			
			if ( $url ) {
			
				$content = file_get_contents( $url );

				$x = new SimpleXmlElement( $content );
				$x->channel->title = sanitize_text_field ( $x->channel->title );
				$x->channel->description = sanitize_text_field ( $x->channel->description );
				$x->channel->description = mom_reddit_formatting ( $x->channel->description );
				
				if ( 'search results' != strtolower ( $x->channel->title ) ) {
				
					$channel_title = strtolower( str_replace( array( 'https://www.reddit.com/r/', '/' ), '', $x->channel->link ) );
					
					if ( '%blank%' == $title ) {
						$title = null;
					} elseif ( $title ) {
						$title = "<h1>{$title}</h1>";
					} elseif ( !$title ) {
						$title = "<h1><a href='{$x->channel->link}'>{$x->channel->title}</a></h1>";
					}
					
					if ( $sub && !$thread ) {
						if ( $description ) {
							$description = "<h2>{$x->channel->description}</h2>";
						} else {
							$description = null;
						}
					} elseif ( $thread && !$sub ) {
						$description = null;
						$title = null;
					}
					
					$output .= "
						<div class='mom-reddit-feed'>
							{$title}{$description}
							
					";
					foreach( $x->channel->item as $entry ){
						
						$entry->description = sanitize_text_field ( $entry->description );
						$entry->description = mom_reddit_formatting ( $entry->description );
						
						++$count;
						$post_type = null;
						if( strpos( $entry->description, 'SC_OFF' ) !== false ){
							$post_type = "<small>(self.{$channel_title})</small>";
						}
						if ( $sub && !$thread ) {
							$output .= "<h3><a href='{$entry->link}'>{$entry->title} {$post_type}</a></h3>";
						} elseif ( $thread && !$sub && '[deleted]' != $entry->description ) {
							if ( $count > 1 ) {
								$output .= "<p>{$entry->description} <small><a href='{$entry->link}'>#</a></small></p>";
							}
						}
					}
					$output .= "</div>";
				
				}
				
			}
		
		}
		
		return $output;
		
	}
	
}
$myoptionalmodules_shortcodes = new myoptionalmodules_shortcodes();