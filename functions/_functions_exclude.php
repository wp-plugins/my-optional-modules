<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	require_once(ABSPATH.'wp-includes/pluggable.php');
	if(!is_user_logged_in()){
		function exclude_post_by_category($query){
			if(get_option('MOM_Exclude_VisitorCategories') == ''){$loggedOutCats = '0,0';}
			$loggedOutCats = get_option('MOM_Exclude_VisitorCategories');
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
						$page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'",$page_slug,$post_type));
					}
					if ($page) {
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
			if(get_option('MOM_Exclude_VisitorTags') == ''){$loggedOutTags = '0,0';}
			$loggedOutTags = get_option('MOM_Exclude_VisitorTags');
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
		add_action('pre_get_posts','exclude_post_by_tag');
		add_action('pre_get_posts','exclude_post_by_category');
	}
	add_action('pre_get_posts','momse_filter_home');
	function momse_filter_home($query){
		if(get_option('MOM_Exclude_Categories_Front') == ''){$MOM_Exclude_Categories_Front = '0,0';}
		if(get_option('MOM_Exclude_Tags_Front') == ''){$MOM_Exclude_Tags_Front = '0,0';}
		if(get_option('MOM_Exclude_Categories_TagArchives') == ''){$MOM_Exclude_Categories_TagArchives = '0,0';}
		if(get_option('MOM_Exclude_Categories_SearchResults') == ''){$MOM_Exclude_Categories_SearchResults = '0,0';}
		if(get_option('MOM_Exclude_Tags_CategoryArchives') == ''){$MOM_Exclude_Tags_CategoryArchives = '0,0';}
		if(get_option('MOM_Exclude_Tags_SearchResults') == ''){$MOM_Exclude_Tags_SearchResults = '0,0';}
		if(get_option('MOM_Exclude_PostFormats_Front') == ''){$MOM_Exclude_PostFormats_Front = '0,0';}
		if(get_option('MOM_Exclude_PostFormats_CategoryArchives') == ''){$MOM_Exclude_PostFormats_CategoryArchives = '0,0';}
		if(get_option('MOM_Exclude_PostFormats_TagArchives') == ''){$MOM_Exclude_PostFormats_TagArchives = '0,0';}
		if(get_option('MOM_Exclude_PostFormats_SearchResults') == ''){$MOM_Exclude_PostFormats_SearchResults = '0,0';}
		if(get_option('MOM_Exclude_Categories_RSS') == ''){$MOM_Exclude_Categories_RSS = '0,0';}
		if(get_option('MOM_Exclude_Tags_RSS') == ''){$MOM_Exclude_Tags_RSS = '0,0';}
		if(get_option('MOM_Exclude_PostFormats_RSS') == ''){$MOM_Exclude_PostFormats_RSS = '0,0';}
		if(get_option('MOM_Exclude_Tags_Day') == ''){$MOM_Exclude_Tags_Day = '0,0';}
		if(get_option('MOM_Exclude_Cats_Day') == ''){$MOM_Exclude_Cats_Day = '0,0';}
		if(get_option('MOM_Exclude_VisitorCategories') == ''){$loggedOutCats = '0,0';}
		if(get_option('MOM_Exclude_VisitorTags') == ''){$loggedOutTags = '0,0';}
		
		
		$MOM_Exclude_Categories_Front = get_option('MOM_Exclude_Categories_Front');
		$MOM_Exclude_Tags_Front = get_option('MOM_Exclude_Tags_Front');
		$MOM_Exclude_Categories_TagArchives = get_option('MOM_Exclude_Categories_TagArchives');
		$MOM_Exclude_Categories_SearchResults = get_option('MOM_Exclude_Categories_SearchResults');
		$MOM_Exclude_Tags_CategoryArchives = get_option('MOM_Exclude_Tags_CategoryArchives');
		$MOM_Exclude_Tags_SearchResults = get_option('MOM_Exclude_Tags_SearchResults');
		$MOM_Exclude_PostFormats_Front = get_option('MOM_Exclude_PostFormats_Front');
		$MOM_Exclude_PostFormats_CategoryArchives = get_option('MOM_Exclude_PostFormats_CategoryArchives');
		$MOM_Exclude_PostFormats_TagArchives = get_option('MOM_Exclude_PostFormats_TagArchives');
		$MOM_Exclude_PostFormats_SearchResults = get_option('MOM_Exclude_PostFormats_SearchResults');
		$MOM_Exclude_Categories_RSS = get_option('MOM_Exclude_Categories_RSS');
		$MOM_Exclude_Tags_RSS = get_option('MOM_Exclude_Tags_RSS');
		$MOM_Exclude_PostFormats_RSS = get_option('MOM_Exclude_PostFormats_RSS');
		if(date('D') === 'Sun'){$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsSun');}
		if(date('D') === 'Mon'){$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsMon');}
		if(date('D') === 'Tue'){$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsTue');} 
		if(date('D') === 'Wed'){$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsWed');}
		if(date('D') === 'Thu'){$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsThu');}
		if(date('D') === 'Fri'){$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsFri');}
		if(date('D') === 'Sat'){$MOM_Exclude_Tags_Day = get_option('MOM_Exclude_TagsSun');}
		if(date('D') === 'Sun'){$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesSun');}
		if(date('D') === 'Mon'){$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesMon');}
		if(date('D') === 'Tue'){$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesTue');} 
		if(date('D') === 'Wed'){$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesWed');}
		if(date('D') === 'Thu'){$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesThu');}
		if(date('D') === 'Fri'){$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesFri');}
		if(date('D') === 'Sat'){$MOM_Exclude_Cats_Day = get_option('MOM_Exclude_CategoriesSat');}		
		$loggedOutCats = get_option('MOM_Exclude_VisitorCategories');
		$loggedOutTags = get_option('MOM_Exclude_VisitorTags');
		$rss_day = explode(',',$MOM_Exclude_Tags_Day);
		foreach ($rss_day as &$rss_day_1){$rss_day_1 = ''.$rss_day_1.',';}
		$rss_day_1 = implode($rss_day);
		$rssday = explode(',',str_replace(' ','',$rss_day_1));
		$rss_day_cat = explode(',',$MOM_Exclude_Cats_Day);
		foreach ($rss_day_cat as &$rss_day_1_cat){$rss_day_1_cat = ''.$rss_day_1_cat.',';}
		$rss_day_1_cat = implode($rss_day_cat);
		$rssday_cat = explode(',', str_replace(' ','',$rss_day_1_cat));		
		if(!is_user_logged_in()){
			$c1 = explode(',',$loggedOutCats);
			foreach($c1 as &$C1){ $C1 = ''.$C1.',';}
			$c_1 = rtrim(implode($c1),',');
			$hideLoggedOutCats = explode(',',str_replace(' ','',$c_1));
			$t1 = explode(',',$loggedOutTags);
			foreach($t1 as &$T1){$T1 = ''.$T1.',';}
			$t11 = rtrim(implode($t1),',');
			$hideLoggedOutTags = explode(',',str_replace(' ','',$t11));
		}else{
			if ( $query->is_feed){$c1 = explode(',',$MOM_Exclude_Categories_RSS);}
			if ( $query->is_feed){$t1 = explode(',',$MOM_Exclude_Tags_RSS);}
			if ( $query->is_home){$c1 = explode(',',$MOM_Exclude_Categories_Front);}
			if ( $query->is_home){$t1 = explode(',',$MOM_Exclude_Tags_Front);}
			if ( $query->is_category){$t1 = explode(',',$MOM_Exclude_Tags_CategoryArchives);}
			if ( $query->is_tag){$c1 = explode(',',$MOM_Exclude_Categories_TagArchives);}
			if ( $query->is_search){$c1 = explode(',',$MOM_Exclude_Categories_SearchResults);}
			if ( $query->is_search){$t1 = explode(',',$MOM_Exclude_Tags_SearchResults);}
			foreach($c1 as &$C1){$C1 = ''.$C1.',';}
			$c_1 = rtrim(implode($c1),',');
			$hideLoggedOutCats = explode(',',str_replace(' ','',$c_1));
			foreach($t1 as &$T1) {$T1 = ''.$T1.',';}
			$t11 = rtrim(implode($t1),',');
			$hideLoggedOutTags = explode(',',str_replace(' ','',$t_1));
		}
		if ($query->is_feed){
			$rss1 = explode(',',$MOM_Exclude_Categories_RSS);
			foreach($rss1 as &$RSS1){$RSS1 = ''.$RSS1.',';}
			$rss_1 = implode($rss1);
			$rss11 = explode(',',str_replace(' ','',$rss_1));
			$rss2 = explode(',', $MOM_Exclude_Tags_RSS);
			foreach ($rss2 as &$RSS2) { $RSS2 = "".$RSS2.","; }
			$rss_2 = implode($rss2);
			$rss22 = explode(',',str_replace(' ','',$rss_2));
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
					'terms' => array($MOM_Exclude_PostFormats_RSS),
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
			$query->set('tax_query',$tax_query);
		}
		if($query->is_main_query() && !is_admin()){
			if($query->is_home()){
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
						'terms' => array($MOM_Exclude_PostFormats_Front),
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
			elseif ($query->is_category()){
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
						'terms' => array($MOM_Exclude_PostFormats_CategoryArchives),
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
				$query->set('tax_query',$tax_query);
			}
			elseif ($query->is_tag()){
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
						'terms' => array($MOM_Exclude_PostFormats_TagArchives),
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
				$query->set('tax_query',$tax_query);
			}
			elseif ($query->is_search()){
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
						'terms' => array($MOM_Exclude_PostFormats_SearchResults),
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
				$query->set('tax_query',$tax_query);
			}
		}
	}
?>