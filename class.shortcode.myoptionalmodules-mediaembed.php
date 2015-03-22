<?php 
/**
 * CLASS SHORTCODE myoptionalmodules_mediaembed_shortcode()
 *
 * File last update: 9.1.4
 *
 * Allow a media embed through shortcode
 * - [mom_embed url='URL']
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_mediaembed_shortcode{

	function construct() {

		add_shortcode( 'mom_embed' , array ( $this , 'shortcode' ) );

	}

	function shortcode( $atts ) {

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

			if( $class )
				sanitize_text_field ( esc_html ( $class ) );

			ob_start();

			if( $class )
				echo '<div class="' . $class . '">';

			new mom_mediaEmbed ( $url );

			if( $class )
				echo '</div>';

			return ob_get_clean();

		}
		
		$url   = null;
		$class = null;

	}

}

$myoptionalmodules_mediaembed_shortcode = new myoptionalmodules_mediaembed_shortcode();
$myoptionalmodules_mediaembed_shortcode->construct();