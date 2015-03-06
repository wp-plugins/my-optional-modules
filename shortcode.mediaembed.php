<?php 

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

if( !function_exists( 'mom_mediaembed_shortcode' ) ) {
	function mom_mediaembed_shortcode( $atts ) {
		extract(
			shortcode_atts( array(
				'url' => '',
				'class' => ''
			), $atts )
		);
		if( $url ) {
			$url = esc_url( $url );
			if( $class ) { 
				sanitize_text_field( $class ); 
			}
			ob_start();
			if( $class ) {
				echo '<div class="' . $class . '">';
			}
			new mom_mediaEmbed( $url );
			if( $class ) {
				echo '</div>';
			}
			return ob_get_clean();			
		}
	}
}