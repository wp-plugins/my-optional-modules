<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}
	$mom_review_global = 0;
	add_shortcode('momreviews','mom_reviews_shortcode');	
	add_filter('the_content','do_shortcode','mom_reviews_shortcode');	
	function mom_reviews_shortcode($atts, $content = null){
		global $mom_review_global;
		$mom_review_global++;
		if($mom_review_global == 1){mom_reviews_style();}else{}
		ob_start();
		extract(
			shortcode_atts(array(
				"type" => '',
				"orderby" => 'ID',
				"order" => 'ASC',
				"meta" => '1',
				"expand" => "+",
				"retract" => "-",
				"id" => "",
			), $atts)
		);	
		$id_fetch_att = $id;
		if(is_numeric($id_fetch_att)){$id_fetch = $id_fetch_att;}
		$result_type = $type;
		$order_by = $orderby;
		$order_dir = $order;
		$meta_show = $meta;
		$expand_this = $expand;
		$retract_this = $retract;
		global $wpdb;
		$mom_reviews_table_name = $wpdb->prefix . "momreviews";
		if($id_fetch != ''){
			$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE ID IN ($id_fetch) ORDER BY $order_by $order_dir");
		}else{
			if($result_type != ''){
				$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name WHERE TYPE IN ($result_type) ORDER BY $order_by $order_dir");
			}else{
				$reviews = $wpdb->get_results("SELECT ID,TYPE,LINK,TITLE,REVIEW,RATING FROM $mom_reviews_table_name ORDER BY $order_by $order_dir");
			}
		}
		foreach($reviews as $reviews_results){
			$this_ID = $reviews_results->ID;
				echo "<div "; if($result_type != ''){echo "id=\"" . $result_type . "\"";}echo " class=\"momreview\"><article class=\"block\"><input type=\"checkbox\" name=\"review\" id=\"".$this_ID."".$mom_review_global."\" /><label for=\"".$this_ID."".$mom_review_global."\">";if($reviews_results->TITLE != ''){echo $reviews_results->TITLE;}echo "<span>".$expand_this."</span><span>".$retract_this."</span></label><section class=\"reviewed\">";if($meta_show == 1){if($reviews_results->TYPE != ''){echo " [ <em>".$reviews_results->TYPE."</em> ] ";}if($reviews_results->LINK != ''){echo " [ <a href=\"".esc_url($reviews_results->LINK)."\">#</a> ] ";}}if($reviews_results->REVIEW != ''){echo "<hr />".$reviews_results->REVIEW."";}if($reviews_results->RATING != ''){echo " <p><em>".$reviews_results->RATING."</em></p> ";}echo "</section></article></div>";
		}		
		return ob_get_clean();
	}
	function mom_reviews_style(){
		echo "<style>".get_option('momreviews_css')."</style>
		";
	}
?>