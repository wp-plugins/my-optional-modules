<?php 
	if(get_option('MOM_themetakeover_youtubefrontpage') != ''){
		function mom_youtube404(){
			global $wp_query;
			if ($wp_query->is_404){
				function MOMthemetakeover_youtubefrontpage(){
					wp_register_style('mom_404_css',plugins_url().'/my-optional-modules/includes/css/_404style.css');
					wp_enqueue_style('mom_404_css');
					include(plugin_dir_path(__FILE__) . '_404template.php');
				}
			}
		}
		add_action('wp','mom_youtube404');
		function templateRedirect(){
			global $wp_query;
			if ($wp_query->is_404){
				MOMthemetakeover_youtubefrontpage();
				exit;
			}
		}
		add_action('template_redirect','templateRedirect');
	}
	if(get_option('MOM_themetakeover_topbar') == 1){
		function mom_topbar_css(){
		echo '
		<style>
		div.momnavbar{cursor:pointer;text-transform:uppercase;position:absolute;top:0;left:0;width:100%;height:30px;display:block;background-color:#fff;text-indent:5px;font-size:10px;padding:3px 0 2px 0;overflow:hidden;line-height:13px;z-index:999;}
		div.momnavbar div{width:100%;display:block;overflow:hidden;height:15px;border-bottom:1px solid #000;position:relative;}
		div.momnavbar ul{width:100%;margin:0 auto !important;position:absolute !important;top:0 !important;left:0 !important;padding:0px !important; border:none !important;}
		div.momnavbar ul li{float:left !important;display:block !important;width:auto !important;margin:0 5px auto !important;list-style:none !important;padding:0px !important;}
		div.momnavbar span{float:right !important;margin:0 5px 0 !important;padding:0px !important;}
		div.momlistcategories{clear:both;margin:25px auto;width:95%;}
		div.momlistcategories h4{margin:55px 0 25px 0;}
		div.momlistcategories div{padding:5px;clear:both;overflow:hidden;width:100%;margin:5px auto;}
		div.momlistcategories div:hover{height:auto;overflow-y:auto;overflow-x:hidden;border:1px solid #454343;background-color:#f7f7f7;}
		div.momlistcategories span{float:right;}
		div.momlistcategories section{clear:both;margin:5px auto;width:100%;font-size:14px;}
		div.momlistcategories section article{clear:both;margin:0 auto;width:100%;font-size:15px;line-height:18px;}
		</style>
		';
		}
		add_action('wp_head','mom_topbar_css');
		function mom_topbar(){
			echo '
			<div class="momnavbar">
			<div>';
					if(get_option('mommaincontrol_fontawesome') == 1){ echo '<i class="fa fa-home"></i> ';}
					echo '<a href="'.esc_url(home_url('/')).'">Front</a> - ';
			if(get_option('mommaincontrol_fontawesome') == 1){ echo '<i class="fa fa-clock-o"></i> ';}
			echo 'Latest Post/';
			$args = array('numberposts'=>'1');
			$latestpost = wp_get_recent_posts($args);
			foreach($latestpost as $latest){
				echo ' <a href="'.get_permalink($latest["ID"]) . '" title="Look '.esc_attr($latest["post_title"]).'" >'.$latest["post_title"].'</a>';
			}
			
			if(is_user_logged_in()){
				if(is_single() && current_user_can('edit_post',$id)){
					echo '  |  '; edit_post_link('Edit this post');
				}
			}
			echo '<span>';
			if(function_exists('obwcountplus_total')){ 
				if(!is_single()){obwcountplus_total();}else{obwcountplus_single();}
				echo ' published words';
			}
			echo '</span></div>
			<div>
			<ul>';
			
			if(get_option('mommaincontrol_shorts') == 1){echo '<li><a href="'.esc_url(get_permalink(get_option('MOM_themetakeover_archivepage'))).'">All</a></li>';}
			
			$counter = 0;
			$max = 1; 
			$taxonomy = 'category';
			$terms = get_terms($taxonomy);
			shuffle ($terms);
			//echo 'shuffled';
			if ($terms) {
				foreach($terms as $term) {
					$counter++;
					if ($counter <= $max) {
					echo '<li><a href="' . get_category_link( $term->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $term->name ) . '" ' . '>Random</a></li>';
					}
				}
			}
			mom_exclude_list_categories();
			echo '</ul></div></div>';
		}
		add_action('wp_footer','mom_topbar');
		// http://plugins.svn.wordpress.org/wp-toolbar-removal/trunk/wp-toolbar-removal.php
		remove_action( 'init', 'wp_admin_bar_init' );
		remove_filter( 'init', 'wp_admin_bar_init' );
		remove_action( 'wp_head', 'wp_admin_bar' );
		remove_filter( 'wp_head', 'wp_admin_bar' );
		remove_action( 'wp_footer', 'wp_admin_bar' );
		remove_filter( 'wp_footer', 'wp_admin_bar' );
		remove_action( 'admin_head', 'wp_admin_bar' );
		remove_filter( 'admin_head', 'wp_admin_bar' );
		remove_action( 'admin_footer', 'wp_admin_bar' );
		remove_filter( 'admin_footer', 'wp_admin_bar' );
		remove_action( 'wp_head', 'wp_admin_bar_class' );
		remove_filter( 'wp_head', 'wp_admin_bar_class' );
		remove_action( 'wp_footer', 'wp_admin_bar_class' );
		remove_filter( 'wp_footer', 'wp_admin_bar_class' );
		remove_action( 'admin_head', 'wp_admin_bar_class' );
		remove_filter( 'admin_head', 'wp_admin_bar_class' );
		remove_action( 'admin_footer', 'wp_admin_bar_class' );
		remove_filter( 'admin_footer', 'wp_admin_bar_class' );
		remove_action( 'wp_head', 'wp_admin_bar_css' );
		remove_filter( 'wp_head', 'wp_admin_bar_css' );
		remove_action( 'wp_head', 'wp_admin_bar_dev_css' );
		remove_filter( 'wp_head', 'wp_admin_bar_dev_css' );
		remove_action( 'wp_head', 'wp_admin_bar_rtl_css' );
		remove_filter( 'wp_head', 'wp_admin_bar_rtl_css' );
		remove_action( 'wp_head', 'wp_admin_bar_rtl_dev_css' );
		remove_filter( 'wp_head', 'wp_admin_bar_rtl_dev_css' );
		remove_action( 'admin_head', 'wp_admin_bar_css' );
		remove_filter( 'admin_head', 'wp_admin_bar_css' );
		remove_action( 'admin_head', 'wp_admin_bar_dev_css' );
		remove_filter( 'admin_head', 'wp_admin_bar_dev_css' );
		remove_action( 'admin_head', 'wp_admin_bar_rtl_css' );
		remove_filter( 'admin_head', 'wp_admin_bar_rtl_css' );
		remove_action( 'admin_head', 'wp_admin_bar_rtl_dev_css' );
		remove_filter( 'admin_head', 'wp_admin_bar_rtl_dev_css' );
		remove_action( 'wp_footer', 'wp_admin_bar_js' );
		remove_filter( 'wp_footer', 'wp_admin_bar_js' );
		remove_action( 'wp_footer', 'wp_admin_bar_dev_js' );
		remove_filter( 'wp_footer', 'wp_admin_bar_dev_js' );
		remove_action( 'admin_footer', 'wp_admin_bar_js' );
		remove_filter( 'admin_footer', 'wp_admin_bar_js' );
		remove_action( 'admin_footer', 'wp_admin_bar_dev_js' );
		remove_filter( 'admin_footer', 'wp_admin_bar_dev_js' );
		remove_action( 'locale', 'wp_admin_bar_lang' );
		remove_filter( 'locale', 'wp_admin_bar_lang' );
		remove_action( 'wp_head', 'wp_admin_bar_render', 1000 );
		remove_filter( 'wp_head', 'wp_admin_bar_render', 1000 );
		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
		remove_filter( 'wp_footer', 'wp_admin_bar_render', 1000 );
		remove_action( 'admin_head', 'wp_admin_bar_render', 1000 );
		remove_filter( 'admin_head', 'wp_admin_bar_render', 1000 );
		remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
		remove_filter( 'admin_footer', 'wp_admin_bar_render', 1000 );
		remove_action( 'admin_footer', 'wp_admin_bar_render' );
		remove_filter( 'admin_footer', 'wp_admin_bar_render' );
		remove_action( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render', 1000 );
		remove_filter( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render', 1000 );
		remove_action( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render' );
		remove_filter( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render' );				
	}
	
?>