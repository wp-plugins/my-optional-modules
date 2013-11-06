<?php 

		require_once(ABSPATH.'wp-includes/pluggable.php');
		if(!is_user_logged_in()){
			function exclude_post_by_category($query){
				$loggedOutCats = get_option('simple_announcement_with_exclusion_cat_visitor');
					$c1 = explode(',',$loggedOutCats);
					foreach($c1 as &$C1) { $C1 = ''.$C1.',';}
					$c_1 = rtrim(implode($c1),',');
					$c11 = explode(',',str_replace(' ','',$c_1));
					$c11array = array($c11);
				$excluded_category_ids = $c11;
				if($query->is_main_query()){
					if($query->is_single()){
						if(($query->query_vars['p'])){
							$page= $query->query_vars['p'];
						}else if(isset($query->query_vars['name'])){
							$page_slug = $query->query_vars['name'];
							$post_type = 'post';
							global $wpdb;
							$page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'",$page_slug, $post_type));
						}
						if ( $page ) {
							$post_categories = wp_get_post_categories($page);
							foreach ($excluded_category_ids as $category_id){
								if(in_array($category_id,$post_categories)){
									$query->set('p',-$category_id);
									break;
								}
							}
						}	
					}
				}
			}
			function exclude_post_by_tag($query){
				$loggedOutTags = get_option('simple_announcement_with_exclusion_tag_visitor');
					$t1 = explode(',',$loggedOutTags);
					foreach ($t1 as &$T1){$T1 = ''.$T1.',';}
					$t_1 = implode($t1);
					$t11 = explode(',',str_replace(' ','',$t_1));
				$excluded_tag_ids = $t11;
				if($query->is_main_query()){
					if($query->is_single()){
						if(($query->query_vars['p'])){
							$page= $query->query_vars['p'];
						}else if(isset($query->query_vars['name'])){
							$page_slug = $query->query_vars['name'];
							$post_type = 'post';
							global $wpdb;
							$page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'",$page_slug, $post_type));
						}
						if($page){
							$post_tags = wp_get_post_tags($page);
							foreach($excluded_tag_ids as $tag_id){
								if(in_array($tag_id,$post_tags)){
									$query->set( 'p',-$tag_id);
									break;
								}
							}
						}
					}
				}
			}
			add_action('pre_get_posts','exclude_post_by_category');
			add_action('pre_get_posts','exclude_post_by_category');
		}


	// filter posts action content
	add_action( "pre_get_posts", "momse_filter_home" );
	function momse_filter_home( $query ) {	
	
		$simple_announcement_with_exclusion_9									= get_option('simple_announcement_with_exclusion_9');
		$simple_announcement_with_exclusion_9_2									= get_option('simple_announcement_with_exclusion_9_2');
		$simple_announcement_with_exclusion_9_3									= get_option('simple_announcement_with_exclusion_9_3');
		$simple_announcement_with_exclusion_9_4									= get_option('simple_announcement_with_exclusion_9_4');
		$simple_announcement_with_exclusion_9_5									= get_option('simple_announcement_with_exclusion_9_5');
		$simple_announcement_with_exclusion_9_7									= get_option('simple_announcement_with_exclusion_9_7');
		$simple_announcement_with_exclusion_9_8									= get_option('simple_announcement_with_exclusion_9_8');
		$simple_announcement_with_exclusion_9_9									= get_option('simple_announcement_with_exclusion_9_9');
		$simple_announcement_with_exclusion_9_10								= get_option('simple_announcement_with_exclusion_9_10');
		$simple_announcement_with_exclusion_9_11								= get_option('simple_announcement_with_exclusion_9_11');
		$simple_announcement_with_exclusion_9_12								= get_option('simple_announcement_with_exclusion_9_12');
		$simple_announcement_with_exclusion_9_13								= get_option('simple_announcement_with_exclusion_9_13');
		$simple_announcement_with_exclusion_9_14								= get_option('simple_announcement_with_exclusion_9_14');
		if (date("D") === "Sun"){$simple_announcement_with_exclusion_day		= get_option('simple_announcement_with_exclusion_sun');}
		if (date("D") === "Mon"){$simple_announcement_with_exclusion_day		= get_option('simple_announcement_with_exclusion_mon');}
		if (date("D") === "Tue"){$simple_announcement_with_exclusion_day		= get_option('simple_announcement_with_exclusion_tue');} 
		if (date("D") === "Wed"){$simple_announcement_with_exclusion_day		= get_option('simple_announcement_with_exclusion_wed');}
		if (date("D") === "Thu"){$simple_announcement_with_exclusion_day		= get_option('simple_announcement_with_exclusion_thu');}
		if (date("D") === "Fri"){$simple_announcement_with_exclusion_day		= get_option('simple_announcement_with_exclusion_fri');}
		if (date("D") === "Sat"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_sat');}
		if (date("D") === "Sun"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_sun');}
		if (date("D") === "Mon"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_mon');}
		if (date("D") === "Tue"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_tue');} 
		if (date("D") === "Wed"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_wed');}
		if (date("D") === "Thu"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_thu');}
		if (date("D") === "Fri"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_fri');}
		if (date("D") === "Sat"){$simple_announcement_with_exclusion_cat_day 	= get_option('simple_announcement_with_exclusion_cat_sat');}		
		
		$loggedOutCats = get_option('simple_announcement_with_exclusion_cat_visitor');
		$loggedOutTags = get_option('simple_announcement_with_exclusion_tag_visitor');
		$rss_day = explode(',',$simple_announcement_with_exclusion_day);
		foreach ($rss_day as &$rss_day_1){$rss_day_1 = ''.$rss_day_1.',';}
		$rss_day_1 = implode($rss_day);
		$rssday = explode(',',str_replace(' ','',$rss_day_1));
		$rss_day_cat = explode(',',$simple_announcement_with_exclusion_cat_day);
		foreach ($rss_day_cat as &$rss_day_1_cat){$rss_day_1_cat = ''.$rss_day_1_cat.',';}
		$rss_day_1_cat = implode($rss_day_cat);
		$rssday_cat = explode(',', str_replace(' ','',$rss_day_1_cat));		
		
		if(is_user_logged_in()){
			$c1 = explode(',',$simple_announcement_with_exclusion_9);
			foreach($c1 as &$C1){ $C1 = ''.$C1.',';}
			$c_1 = implode($c1);
			$hideLoggedOutCats = explode(',',str_replace(' ','',$c_1));
			$t1 = explode(',',$simple_announcement_with_exclusion_9_4);
			foreach($t1 as &$T1){$T1 = ''.$T1.',';}
			$t_1 = implode($t1);
			$hideLoggedOutTags = explode(',',str_replace(' ','',$t_1));
			}else{
			$c1 = explode(',',$loggedOutCats);
			foreach($c1 as &$C1){$C1 = ''.$C1.',';}
			$c_1 = implode($c1);
			$hideLoggedOutCats = explode(',',str_replace(' ','',$c_1));
			$t1 = explode(',',$loggedOutTags);
			foreach($t1 as &$T1) {$T1 = ''.$T1.',';}
			$t_1 = implode($t1);
			$hideLoggedOutTags = explode(',',str_replace(' ','',$t_1));
		}
		
		if ($query->is_feed) {
			$rss1 = explode(',', $simple_announcement_with_exclusion_9_12);
			foreach ($rss1 as &$RSS1) { $RSS1 = "".$RSS1.","; }
			$rss_1 = implode($rss1);		
			$rss11 = explode(',', str_replace(' ', '', $rss_1));
			$rss2 = explode(',', $simple_announcement_with_exclusion_9_13);
			foreach ($rss2 as &$RSS2) { $RSS2 = "".$RSS2.","; }
			$rss_2 = implode($rss2);		
			$rss22 = explode(',', str_replace(' ', '', $rss_2));
			$tax_query = array(
				'relation' => 'AND OR',
				array(
					'taxonomy' => 'category',
					'terms' => $rss11,
					'field' => 'id',
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'post_tag',
					'terms' => $rss22,
					'field' => 'id',
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array( $simple_announcement_with_exclusion_9_14 ),
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'post_tag',
					'terms' => $rssday,
					'field' => 'id',
					'operator' => 'NOT IN'
				),				
				array(
					'taxonomy' => 'category',
					'terms' => $rssday_cat,
					'field' => 'id',
					'operator' => 'NOT IN'
				),				
				array(
					'taxonomy' => 'category',
					'terms' => $hideLoggedOutTags,
					'field' => 'id',
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'category',
					'terms' => $hideLoggedOutCats,
					'field' => 'id',
					'operator' => 'NOT IN'
				),					
			);
			$query->set( 'tax_query', $tax_query );						
		}
			
		if ( $query->is_main_query() && !is_admin() ) {
		
			if ( $query->is_home() ) {
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $hideLoggedOutCats,
						'field' => 'id',
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $hideLoggedOutTags,
						'field' => 'id',
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_8 ),
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'category',
						'terms' => $rssday_cat,
						'field' => 'id',
						'operator' => 'NOT IN'
					),						
				);
				$query->set( 'tax_query', $tax_query );
			}

			elseif ( $query->is_category()) {
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'post_tag',
						'terms' => $hideLoggedOutTags,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_9 ),
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),					
					array(
						'taxonomy' => 'category',
						'terms' => $rssday_cat,
						'field' => 'id',
						'operator' => 'NOT IN'
					),		
					array(
						'taxonomy' => 'category',
						'terms' => $hideLoggedOutCats,
						'field' => 'id',
						'operator' => 'NOT IN'
					),					
				);
				$query->set( 'tax_query', $tax_query );				
			}

			elseif ( $query->is_tag() ) {
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $hideLoggedOutCats,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_10 ),
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),					
					array(
						'taxonomy' => 'category',
						'terms' => $rssday_cat,
						'field' => 'id',
						'operator' => 'NOT IN'
					),						
					array(
						'taxonomy' => 'category',
						'terms' => $hideLoggedOutTags,
						'field' => 'id',
						'operator' => 'NOT IN'
					),					
				);
				$query->set( 'tax_query', $tax_query );
			}		

			elseif ( $query->is_search() ) {
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $hideLoggedOutCats,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $hideLoggedOutTags,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( $simple_announcement_with_exclusion_9_11 ),
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $rssday,
						'field' => 'id',
						'operator' => 'NOT IN'
					),		
					array(
						'taxonomy' => 'category',
						'terms' => $rssday_cat,
						'field' => 'id',
						'operator' => 'NOT IN'
					),						
				);
				$query->set( 'tax_query', $tax_query );					
			}
		
		}
	}
?>