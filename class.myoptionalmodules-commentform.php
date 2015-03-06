<?php 
/**
 * class.myoptionalmodules-commentform
 * DNSBL blocklist, extra field (spam trap), Ajax
 *  - Check if ANY of the options for these things are switched before further deciding which functionality
 *    to enable. If none of these options are switched on via settings, then skip this class altogether.
 */
if(!defined('MyOptionalModules')) { die('You can not call this file directly.'); }

class myoptionalmodules_comment_form {

	function actions() {
		if( 1 == get_option( 'MOM_themetakeover_ajaxifycomments' ) ) {
			add_action ( 'comment_post', array( $this, 'ajax' ), 20, 2 );
		}
		if( 1 == get_option( 'MOM_themetakeover_hidden_field' ) ) {
				add_filter( 'comment_form_default_fields', array( $this, 'spam_field' ) );
				add_action( 'comment_form_logged_in_after', array( $this, 'spam_field' ) );
				add_action( 'comment_form_after_fields', array( $this, 'spam_field' ) );
				add_filter( 'preprocess_comment', array( $this, 'field_check' ) );
		}		
	}
	function ajax( $comment_ID, $comment_status ) {
		if( isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && 'xmlhttprequest' == strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) ) {
			$comment = get_comment($comment_ID);
			$commentContent = getCommentHTML($comment);
			wp_notify_postauthor( $comment_ID, $comment->comment_type );
			die( $commentContent );
		}
	}
	function spam_field( $fields ) {
		$fields[ 'spam' ] = '<input id="mom_fill_me_out" name="mom_fill_me_out" type="hidden" value="" />';
		return $fields;
	}
	function field_check( $commentdata ) {
		if ( $_REQUEST['mom_fill_me_out'] )
		wp_die( __( '<strong>Error</strong>: You seem to have filled something out that you shouldn\'t have.' ) );
		return $commentdata;
	}

}