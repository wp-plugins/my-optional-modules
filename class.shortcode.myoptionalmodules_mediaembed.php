<?php 

if( !defined( 'MyOptionalModules' ) ) { 
	die( 'You can not call this file directly.' ); 
}

class myoptionalmodules_mediaembed_shortcode{

	function construct() {
		add_shortcode( 'mom_embed', array( $this, 'shortcode' ) );
	}

	function shortcode( $atts ) {
		$url   = null;
		$class = null;
	
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
		
		$url   = null;
		$class = null;
	}

}