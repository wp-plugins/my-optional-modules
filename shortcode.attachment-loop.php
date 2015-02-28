<?php 

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

if( !function_exists( 'mom_attachments_shortcode' ) ) {
	function mom_attachments_shortcode( $atts ) {
		global $post,$wp;
		/**
		 * Shortcode attributes(to be set inside of the shortcode)
		 * These attributes will be used as the default settings, which can be overridden by 
		 * attributes set inside of the shortcode.
		 */
		extract(
			shortcode_atts( array(
				'amount' => 1,                // numerical value of how many attachments to return			
				'class'  => 'mom_attachment'  // default class for the linked attachments
			), $atts )
		);
		if( $amount ) $amount = intval( $amount );
		if( $class  ) $class  = sanitize_text_field( $class );
		// Get all image attachments
		$all_images = get_posts(
			array(
				'post_type' => 'attachment',
				'numberposts' => $amount,
				'post_mime_type ' => 'image',
			)
		);
		$output = '';
		foreach ( $all_images as $image ) {
			$id               = $image->ID;
			$parent_id        = $image->post_parent;
			$parent_title     = get_the_title( $parent_id );
			$parent_permalink = get_the_permalink( $parent_id );
			$mime_type        = get_post_mime_type( $id );
			$attachment       = wp_get_attachment_url($id, 'full' );
			if( 'image/jpeg' == $mime_type || 'image/png' == $mime_type || 'image/gif' == $mime_type ) {
				$output .= '<a class="' . $class . '" href="' . $parent_permalink . '"><img src="' . $attachment . '" /></a>';
			}
		}
		return $output;
	}
}