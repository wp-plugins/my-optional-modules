<?php 

if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

if( 1 == get_option( 'myoptionalmodules_nelio' ) ) {
	if( is_admin() ) {
		add_action( 'add_meta_boxes', 'myoptionalmodules_add_url_metabox' );
		function myoptionalmodules_add_url_metabox() {
			$excluded_post_types = array(
				'attachment', 'revision', 'nav_menu_item', 'wpcf7_contact_form',
			);
			foreach ( get_post_types( '', 'names' ) as $post_type ) {
				if ( in_array( $post_type, $excluded_post_types ) )
					continue;
				add_meta_box(
					'myoptionalmodules_url_metabox',
					'External Featured Image',
					'myoptionalmodules_url_metabox',
					$post_type,
					'side',
					'default'
				);
			}
		}
		function myoptionalmodules_url_metabox( $post ) {
			$myoptionalmodules_url = get_post_meta( $post->ID, _myoptionalmodules_url(), true );
			$myoptionalmodules_alt = get_post_meta( $post->ID, '_myoptionalmodules_alt', true );
			$has_img = strlen( $myoptionalmodules_url ) > 0;
			if ( $has_img ) {
				$hide_if_img = 'display:none;';
				$show_if_img = '';
			}
			else {
				$hide_if_img = '';
				$show_if_img = 'display:none;';
			}
			?>
			<input type="text" placeholder="ALT attribute" style="width:100%;margin-top:10px;<?php echo $show_if_img; ?>"
				id="myoptionalmodules_alt" name="myoptionalmodules_alt"
				value="<?php echo esc_attr( $myoptionalmodules_alt ); ?>" /><?php
			if ( $has_img ) { ?>
			<div id="myoptionalmodules_preview_block"><?php
			} else { ?>
			<div id="myoptionalmodules_preview_block" style="display:none;"><?php
			} ?>
				<div id="myoptionalmodules_image_wrapper" style="<?php
					echo (
						'width:100%;' .
						'max-width:300px;' .
						'height:200px;' . 
						'overflow:hidden;');
					?>">
					<?php if( $myoptionalmodules_url ) new mom_mediaEmbed( $myoptionalmodules_url ); ?>
				</div>
			<a id="myoptionalmodules_remove_button" href="#" onClick="javascript:myoptionalmodulesRemoveFeaturedImage();" style="<?php echo $show_if_img; ?>">Remove featured image</a>
			<script>
			function myoptionalmodulesRemoveFeaturedImage() {
				jQuery("#myoptionalmodules_preview_block").hide();
				jQuery("#myoptionalmodules_image_wrapper").hide();
				jQuery("#myoptionalmodules_remove_button").hide();
				jQuery("#myoptionalmodules_alt").hide();
				jQuery("#myoptionalmodules_alt").val('');
				jQuery("#myoptionalmodules_url").val('');
				jQuery("#myoptionalmodules_url").show();
				jQuery("#myoptionalmodules_preview_button").parent().show();
			}
			function myoptionalmodulesPreview() {
				jQuery("#myoptionalmodules_preview_block").show();
				jQuery("#myoptionalmodules_image_wrapper").css('background-image', "url('" + jQuery("#myoptionalmodules_url").val() + "')" );
				jQuery("#myoptionalmodules_image_wrapper").show();
				jQuery("#myoptionalmodules_remove_button").show();
				jQuery("#myoptionalmodules_alt").show();
				jQuery("#myoptionalmodules_url").hide();
				jQuery("#myoptionalmodules_preview_button").parent().hide();
			}
			</script>
			</div>
			<input type="text" placeholder="Image URL" style="width:100%;margin-top:10px;<?php echo $hide_if_img; ?>"
				id="myoptionalmodules_url" name="myoptionalmodules_url"
				value="<?php echo esc_attr( $myoptionalmodules_url ); ?>" />
			<div style="text-align:right;margin-top:10px;<?php echo $hide_if_img; ?>">
				<a class="button" id="myoptionalmodules_preview_button" onClick="javascript:myoptionalmodulesPreview();">Preview</a>
			</div>
			<?php
		}
		add_action( 'save_post', 'myoptionalmodules_save_url' );
		function myoptionalmodules_save_url( $post_ID ) {
			if ( isset( $_POST['myoptionalmodules_url'] ) ) {
				$url = strip_tags( $_POST['myoptionalmodules_url'] );
				update_post_meta( $post_ID, _myoptionalmodules_url(), $url );
			}

			if ( isset( $_POST['myoptionalmodules_alt'] ) )
				update_post_meta( $post_ID, '_myoptionalmodules_alt', strip_tags( $_POST['myoptionalmodules_alt'] ) );
		}
	}
	
	/**
	 * This function returns the post meta key. The key can be changed
	 * using the filter `myoptionalmodules_post_meta_key'
	 */
	function _myoptionalmodules_url() {
		return apply_filters( 'myoptionalmodules_post_meta_key', '_myoptionalmodules_url' );
	}
	/**
	 * This function returns whether the post whose id is $id uses an external
	 * featured image or not
	 */
	function uses_myoptionalmodules( $id ) {
		if( myoptionalmodules_get_thumbnail_src( $id ) )
			$image_url = myoptionalmodules_get_thumbnail_src( $id );
		elseif( has_post_thumbnail( $id ) )
			$image_url = wp_get_attachment_url( $id );
		else
			$image_url = '';
		if ( $image_url === false )
			return false;
		else
			return true;
	}
	/**
	 * This function returns the URL of the external featured image (if any), or
	 * false otherwise.
	 */
	function myoptionalmodules_get_thumbnail_src( $id ) {
		$image_url = get_post_meta( $id, _myoptionalmodules_url(), true );
		if ( !$image_url || !isset( $image_url ) )
			return false;
		return $image_url;
	}
	/**
	 * This function prints an image tag with the external featured image (if any).
	 * This tag, in fact, has a 1x1 px transparent gif image as its src, and
	 * includes the external featured image via inline CSS styling.
	 */
	function myoptionalmodules_the_html_thumbnail( $id, $size = false, $attr = array() ) {
		if ( uses_myoptionalmodules( $id ) )
			echo myoptionalmodules_get_html_thumbnail( $id );
	}
	/**
	 * This function returns the image tag with the external featured image (if
	 * any). This tag, in fact, has a 1x1 px transparent gif image as its src,
	 * and includes the external featured image via inline CSS styling.
	 */
	function myoptionalmodules_get_html_thumbnail( $id, $size = false, $attr = array() ) {
		if ( uses_myoptionalmodules( $id ) === false )
			return false;

		$image_url = myoptionalmodules_get_thumbnail_src( $id );

		$width = false;
		$height = false;
		$additional_classes = '';
		global $_wp_additional_image_sizes;
		if ( is_array( $size ) ) {
			$width = $size[0];
			$height = $size[1];
		}
		else if ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
			$width = $_wp_additional_image_sizes[ $size ]['width'];
			$height = $_wp_additional_image_sizes[ $size ]['height'];
			$additional_classes = 'attachment-' . $size . ' ';
		}
		if ( $width && $width > 0 ) $width = "width:${width}px;";
		else $width = '';
		if ( $height && $height > 0 ) $height = "height:${height}px;";
		else $height = '';
		if ( isset( $attr['class'] ) )
			$additional_classes .= $attr['class'];
		$alt = get_post_meta( $id, '_myoptionalmodules_alt', true );
		if ( isset( $attr['alt'] ) )
			$alt = $attr['alt'];
		if ( !$alt )
			$alt = '';
		new mom_mediaEmbed( $image_url );
	}
	// Overriding post thumbnail when necessary
	add_filter( 'genesis_pre_get_image', 'myoptionalmodules_genesis_thumbnail', 10, 3 );
	function myoptionalmodules_genesis_thumbnail( $unknown_param, $args, $post ) {
		$image_url = get_post_meta( $post->ID, _myoptionalmodules_url(), true );
		if ( !$image_url || !isset( $image_url ) ) {
			return false;
		}
		if ( $args['format'] == 'html' ) {
			$html = myoptionalmodules_replace_thumbnail( '', $post->ID, 0, $args['size'], $args['attr'] );
			$html = str_replace( 'style="', 'style="min-width:150px;min-height:150px;', $html );
			return $html;
		}
		else {
			return $image_url;
		}
	}
	// Overriding post thumbnail when necessary
	add_filter( 'post_thumbnail_html', 'myoptionalmodules_replace_thumbnail', 10, 5 );
	function myoptionalmodules_replace_thumbnail( $html, $post_id, $post_image_id, $size, $attr ) {
		if ( uses_myoptionalmodules( $post_id ) )
			$html = myoptionalmodules_get_html_thumbnail( $post_id, $size, $attr );
		return $html;
	}
	add_action( 'the_post', 'myoptionalmodules_fake_featured_image_if_necessary' );
	function myoptionalmodules_fake_featured_image_if_necessary( $post ) {
		if ( is_array( $post ) ) $post_ID = $post['ID'];
		else $post_ID = $post->ID;
		$has_myoptionalmodules = strlen( get_post_meta( $post_ID, _myoptionalmodules_url(), true ) ) > 0;
		$wordpress_featured_image = get_post_meta( $post_ID, '_thumbnail_id', true );
		if ( $has_myoptionalmodules && !$wordpress_featured_image )
			update_post_meta( $post_ID, '_thumbnail_id', -1 );
		if ( !$has_myoptionalmodules && $wordpress_featured_image == -1 )
			delete_post_meta( $post_ID, '_thumbnail_id' );
	}
}