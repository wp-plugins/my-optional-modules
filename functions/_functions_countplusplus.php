<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}
	function countsplusplus(){
		global $wpdb;
		$now = gmdate('Y-m-d H:i:s',time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if($words){
			foreach($words as $word){
				$post = strip_tags($word->post_content);
				$post = explode(' ',$post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
		$remain	= number_format(get_option('obwcountplus_1_countdownfrom') - $totalcount);
		$c_custom = sanitize_text_field(htmlentities(get_option('obwcountplus_4_custom')));
		$c_search = array('%total%','%remain%');
		$c_replace = array($totalcount,$remain);
		echo str_replace($c_search,$c_replace,$c_custom);
	}
	function obwcountplus_single(){
		global $wpdb, $post;
		$postid	= $post->ID;
		$now = gmdate('Y-m-d H:i:s',time() );
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post' AND ID = '$postid'";
		$words = $wpdb->get_results($query);
		if($words){
			foreach($words as $word){
				$post = strip_tags($word->post_content);
				$post = explode(' ', $post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
		if(is_single()){
			echo number_format($totalcount);
		}
	}
	function obwcountplus_remaining(){
		global $wpdb;
		$now   = gmdate('Y-m-d H:i:s',time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if($words){
			foreach($words as $word){
				$post = strip_tags($word->post_content);
				$post = explode(' ', $post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
		if (
			$totalcount >= get_option('obwcountplus_1_countdownfrom') ||
			get_option('obwcountplus_1_countdownfrom') == 0
		   ){
			echo number_format($totalcount);
		}else{
			echo number_format(get_option('obwcountplus_1_countdownfrom') - $totalcount);
		}
	}
	function obwcountplus_total(){
		global $wpdb;
		$now = gmdate('Y-m-d H:i:s',time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if($words){
			foreach($words as $word){
				$post = strip_tags($word->post_content);
				$post = explode(' ', $post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
		echo number_format($totalcount);
	}
	function obwcountplus_count(){
		global $wpdb;
		$now = gmdate('Y-m-d H:i:s',time());
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < '$now' AND post_type = 'post'";
		$words = $wpdb->get_results($query);
		if($words){
			foreach($words as $word){
				$post = strip_tags($word->post_content);
				$post = explode(' ',$post);
				$count = count($post);
				$totalcount = $count + $oldcount;
				$oldcount = $totalcount;
			}
		} else {
			$totalcount=0;
		}
		if (
			$totalcount >= get_option('obwcountplus_1_countdownfrom') ||
			get_option('obwcountplus_1_countdownfrom') == 0
		   ) {
			echo number_format($totalcount)." ".get_option('obwcountplus_3_total');
		   } else {
			echo number_format(get_option('obwcountplus_1_countdownfrom') - $totalcount).' '.get_option('obwcountplus_2_remaining').' ('.number_format($totalcount).' '.get_option('obwcountplus_3_total' ).')';
		}
	}
?>