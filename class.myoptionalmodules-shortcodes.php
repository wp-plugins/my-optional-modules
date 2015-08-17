<?php 
/**
 * CLASS myoptionalmodules_shortcodes()
 *
 * File last update: 10.0.9.6
 *
 * All shortcodes for My Optional Modules
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_shortcodes{

	function __construct() {
		remove_shortcode ( 'mom_embed' );
		remove_shortcode ( 'mom_hidden' );
		remove_shortcode ( 'mom_charts' );

		add_shortcode    ( 'mom_embed' , array ( $this , 'embed' ) );
		add_shortcode    ( 'mom_hidden' , array ( $this , 'hidden' ) );
		add_shortcode    ( 'mom_charts' , array ( $this , 'charts' ) );
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
	
	function charts ( $atts ) {

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
}
$myoptionalmodules_shortcodes = new myoptionalmodules_shortcodes();