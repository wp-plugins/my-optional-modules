<?php 

/**
 *
 * Shortcodes
 *
 * Various shortcode functions used by different modules
 *
 * Since ?
 * @my_optional_modules
 *
 */

/**
 *
 * Don't call this file directly
 *
 */
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

/**
 *
 * Font Awesome shortcode
 * allows quick embedding of Font Awesome icons by using the following template:
 * [font-fa i="ICON"] where ICON is the name of an icon
 * For instance: RSS icon would be [font-fa i="rss"]
 * Full list of icons: //fortawesome.github.io/Font-Awesome/icons/
 * Appropriate icon names are sans the fa- (fa-child would simply be child, fa-empire would simply be empire, etc..)
 *
 */
if( !function_exists( 'font_fa_shortcode' ) ) {

	function font_fa_shortcode( $atts, $content = null ) {

		extract(

			shortcode_atts( array (

				"i" => ''

			), $atts )

		);

		$icon = esc_attr( $i );

		if( '' != $icon ) {

			$iconfinal = $icon;

		}

		ob_start();

		return '<i class="fa fa-' . $iconfinal . '"></i>';

		return ob_get_clean();

	}

}