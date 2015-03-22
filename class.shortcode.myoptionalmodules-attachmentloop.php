<?php 
/**
 * CLASS SHORTCODE myoptionalmodules_attachment_loop_shortcode()
 *
 * File last update: 9.1.4
 *
 * Shortcode to display a loop of recent images with links to the posts they belong to
 * [mom_attachments]
 */
 
if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_attachment_loop_shortcode{

	function construct() {

		add_shortcode ( 'mom_attachments' , array ( $this , 'shortcode' ) );

	}

	function shortcode( $atts ) {

		global $post,$wp;

		$amount           = null;
		$class            = null;
		$all_images       = null;
		$id               = null;
		$parent_id        = null;
		$parent_title     = null;
		$mime_type        = null;
		$attachment       = null;
		$output           = null;
		$parent_permalink = null;

		extract (
			shortcode_atts ( 
				array (
					'amount' => 1,                // numerical value of how many attachments to return			
					'class'  => 'mom_attachment'  // default class for the linked attachments
				), 
				$atts 
			)
		);

		if( $amount ) $amount = intval ( $amount );
		if( $class  ) $class  = sanitize_text_field ( esc_html ( $class ) );

		$all_images = get_posts (
			array (
				'post_type' => 'attachment',
				'numberposts' => $amount,
				'post_mime_type ' => 'image',
			)
		);

		$output .= '<div class="mom_attachments">';

		foreach ( $all_images as $image ) {
			$id               = $image->ID;
			$parent_id        = $image->post_parent;
			$parent_title     = get_the_title ( $parent_id );
			$parent_permalink = get_the_permalink ( $parent_id );
			$mime_type        = get_post_mime_type ( $id );
			$attachment       = wp_get_attachment_url ($id , 'full' );
			if( 
				'image/jpeg' == $mime_type || 
				'image/png' == $mime_type || 
				'image/gif' == $mime_type 
			) {
				$output .= '<a class="' . $class . '" href="' . $parent_permalink . '"><img src="' . $attachment . '" /></a>';
			}
		}

		$output .= '</div>';
		return $output;
		
		$amount           = null;
		$class            = null;
		$all_images       = null;
		$id               = null;
		$parent_id        = null;
		$parent_title     = null;
		$mime_type        = null;
		$attachment       = null;
		$output           = null;
		$parent_permalink = null;

	}

}

$myoptionalmodules_attachment_loop_shortcode = new myoptionalmodules_attachment_loop_shortcode();
$myoptionalmodules_attachment_loop_shortcode->construct();