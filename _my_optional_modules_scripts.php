<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

if ( !function_exists ( 'my_optional_modules_scripts' ) ) {
	function my_optional_modules_scripts(){
		function mom_jquery(){
			if( get_option( 'MOM_themetakeover_tiledfrontpage' ) == 1 ) {
				$fittext = plugins_url().'/my-optional-modules/includes/javascript/fittext.js';
				wp_register_script( 'fittext', $fittext, array( 'jquery' ) );
				wp_enqueue_script( 'fittext' );
			}
			if(get_option('mommaincontrol_lazyload') == 1){
				$lazyLoad = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
				$lazyLoadFunctions = plugins_url().'/my-optional-modules/includes/javascript/lazyload.js';
				wp_register_script( 'lazyload', $lazyLoad, array( 'jquery' ) );
				wp_register_script( 'lazyloadFunctions', $lazyLoadFunctions, array( 'jquery' ) );
				wp_enqueue_script( 'lazyload' );
				wp_enqueue_script( 'lazyloadFunctions' );
			}
		}
		add_action('wp_enqueue_scripts','mom_jquery');
		function MOMScriptsFooter(){
			if( get_option('MOM_themetakeover_tiledfrontpage') == 1 ){
			echo '
			<script type=\'text/javascript\'>';
				echo 'jQuery(document).ready(function($){';
				if( get_option( 'MOM_themetakeover_tiledfrontpage' ) == 1 ) {
					echo 'jQuery(".recentPostRotationFull .thumbnailFull a.mediaNotPresent").fitText();';
				}
				echo '});</script>';
			}
		}
		add_action('wp_footer','MOMScriptsFooter',99999);
	}
}