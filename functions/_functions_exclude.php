<?php 
	// filter posts action content
	add_action( "pre_get_posts", "momse_filter_home" );
	function momse_filter_home( $query ) {	
		$simple_announcement_with_exclusion_9 = get_option('simple_announcement_with_exclusion_9');
		$simple_announcement_with_exclusion_9_2 = get_option('simple_announcement_with_exclusion_9_2');
		$simple_announcement_with_exclusion_9_3 = get_option('simple_announcement_with_exclusion_9_3');
		$simple_announcement_with_exclusion_9_4 = get_option('simple_announcement_with_exclusion_9_4');
		$simple_announcement_with_exclusion_9_5 = get_option('simple_announcement_with_exclusion_9_5');
		$simple_announcement_with_exclusion_9_7 = get_option('simple_announcement_with_exclusion_9_7');
		$simple_announcement_with_exclusion_9_8 = get_option('simple_announcement_with_exclusion_9_8');
		$simple_announcement_with_exclusion_9_9 = get_option('simple_announcement_with_exclusion_9_9');
		$simple_announcement_with_exclusion_9_10 = get_option('simple_announcement_with_exclusion_9_10');
		$simple_announcement_with_exclusion_9_11 = get_option('simple_announcement_with_exclusion_9_11');
		$simple_announcement_with_exclusion_9_12 = get_option('simple_announcement_with_exclusion_9_12');
		$simple_announcement_with_exclusion_9_13 = get_option('simple_announcement_with_exclusion_9_13');
		$simple_announcement_with_exclusion_9_14 = get_option('simple_announcement_with_exclusion_9_14');
		if (date("D") === "Sun") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_sun'); }
		if (date("D") === "Mon") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_mon'); }
		if (date("D") === "Tue") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_tue'); } 
		if (date("D") === "Wed") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_wed'); }
		if (date("D") === "Thu") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_thu'); }
		if (date("D") === "Fri") { $simple_announcement_with_exclusion_day = get_option('simple_announcement_with_exclusion_fri'); }
		if (date("D") === "Sat") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_sat'); }
		if (date("D") === "Sun") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_sun'); }
		if (date("D") === "Mon") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_mon'); }
		if (date("D") === "Tue") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_tue'); } 
		if (date("D") === "Wed") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_wed'); }
		if (date("D") === "Thu") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_thu'); }
		if (date("D") === "Fri") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_fri'); }
		if (date("D") === "Sat") { $simple_announcement_with_exclusion_cat_day = get_option('simple_announcement_with_exclusion_cat_sat'); }		

		$rss_day = explode(',', $simple_announcement_with_exclusion_day);
		foreach ($rss_day as &$rss_day_1) { $rss_day_1 = "".$rss_day_1.","; }
		$rss_day_1 = implode($rss_day);		
		$rssday = explode(',', str_replace(' ', '', $rss_day_1));

		$rss_day_cat = explode(',', $simple_announcement_with_exclusion_cat_day);
		foreach ($rss_day_cat as &$rss_day_1_cat) { $rss_day_1_cat = "".$rss_day_1_cat.","; }
		$rss_day_1_cat = implode($rss_day_cat);		
		$rssday_cat = explode(',', str_replace(' ', '', $rss_day_1_cat));		
		
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
			);
			$query->set( 'tax_query', $tax_query );						
		}
			
		if ( $query->is_main_query() && !is_admin() ) {
			if ( $query->is_home() ) {
				$c1 = explode(',', $simple_announcement_with_exclusion_9);
				foreach ($c1 as &$C1) { $C1 = "".$C1.","; }
				$c_1 = implode($c1);		
				$c11 = explode(',', str_replace(' ', '', $c_1));
				$t1 = explode(',', $simple_announcement_with_exclusion_9_4);
				foreach ($t1 as &$T1) { $T1 = "".$T1.","; }
				$t_1 = implode($t1);		
				$t11 = explode(',', str_replace(' ', '', $t_1));
			
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $c11,
						'field' => 'id',
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $t11,
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
				$t2 = explode(',', $simple_announcement_with_exclusion_9_5);
				foreach ($t2 as &$T2) { $T2 = "".$T2.","; }
				$t_2 = implode($t2);
				$t22 = explode(',', str_replace(' ', '', $t_2));
					
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'post_tag',
						'terms' => $t22,
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
				);
				$query->set( 'tax_query', $tax_query );				
			}

			elseif ( $query->is_tag() ) {
				$c3 = explode(',', $simple_announcement_with_exclusion_9_2);
				foreach ($c3 as &$C3) { $C3 = "".$C3.","; }
				$c_3 = implode($c3);
				$c33 = explode(',', str_replace(' ', '', $c_3));
			
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $c33,
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
				);
				$query->set( 'tax_query', $tax_query );
			}		

			elseif ( $query->is_search() ) {
				$c4 = explode(',', $simple_announcement_with_exclusion_9_3);
				foreach ($c4 as &$C4) { $C4 = "".$C4.","; }
				$c_4 = implode($c4);		
				$c44 = explode(',', str_replace(' ', '', $c_4));
				$t4 = explode(',', $simple_announcement_with_exclusion_9_7);
				foreach ($t4 as &$T4) { $T4 = "".$T4.","; }
				$t_4 = implode($t4);		
				$t44 = explode(',', str_replace(' ', '', $t_4));			
					
				$tax_query = array(
					'relation' => 'AND OR',
					array(
						'taxonomy' => 'category',
						'terms' => $c44,
						'field' => 'id',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'post_tag',
						'terms' => $t44,
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