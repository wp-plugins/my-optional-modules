<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}
	function mom_jquery(){
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http".($_SERVER['SERVER_PORT'] == 443 ? "s" : "")."://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js",'','', null, false);
		wp_enqueue_script('jquery');
		if(get_option('MOM_themetakeover_fitvids') != ''){
			$fitvids = plugins_url().'/my-optional-modules/includes/javascript/fitvids.js';
			wp_deregister_script('fitvids');
			wp_register_script('fitvids',$fitvids,'','',null,false);
			wp_enqueue_script('fitvids');
		}
		if(get_option('mommaincontrol_lazyload') == 1 ){
			$lazyLoad = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
			$placeholder = plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/includes/javascript/placeholder.png';
			wp_deregister_script('lazyload');
			wp_register_script('lazyload',$lazyLoad,'','',null,false);
			wp_enqueue_script('lazyload');
		}
	}
	add_action('wp_enqueue_scripts','mom_jquery');
	function MOMScriptsFooter(){
		echo '
		<script type=\'text/javascript\'>';
		if(get_option('mommaincontrol_analytics') == 1 && get_option('momanalytics_code') != ''){
			echo '
			(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
			ga(\'create\',\''.get_option('momanalytics_code').'\',\''.home_url('/').'\');
			ga(\'send\',\'pageview\');
			';
		}			
		echo 'jQuery(document).ready(function ($){';
		// Fitvids
		if(get_option('MOM_themetakeover_fitvids') != ''){
			$fitvidContainer = get_option('MOM_themetakeover_fitvids');
			echo '
			$(\''.$fitvidContainer.'\').fitVids();';
		}
		// Lazyload
		if(get_option('mommaincontrol_lazyload') == 1 ){
			echo '
			$("img").wrap(function(){
					$(this).wrap(function(){
						var newimg = \'<img src="'.$placeholder.'" data-original="\' + $(this).attr(\'src\') + \'" width="\' + $(this).attr(\'width\') + \'" height="\' + $(this).attr(\'height\') + \'" class="lazy \' + $(this).attr(\'class\') + \'">\';
						return newimg;  
					});
					return \'<noscript>\';
				});
			$("img.lazy").lazyload(
				{data_attribute: "original" 
			});';
		}
		// Navbar
		if(get_option('MOM_themetakeover_topbar') == 1){
			echo '
			$(window).scroll(function() {
				var scroll = $(window).scrollTop();
					if (scroll >= 100) {
						$(".momnavbar").addClass("stucktothetop");
				} else {
						$(".momnavbar").removeClass("stucktothetop");
				}
			});';	
		}
		// Post/page list(s) / scroll-to-top arrow
		if(get_option('MOM_themetakeover_postdiv') != '' && get_option('MOM_themetakeover_postelement') != ''){
			if(is_single() || is_page()){
				$entrydiv = esc_attr(get_option('MOM_themetakeover_postdiv'));
				$entryele = esc_attr(get_option('MOM_themetakeover_postelement'));
				$entrytoggle = esc_attr(get_option('MOM_themetakeover_posttoggle'));
				echo '
				$("body").append("<div class=\'scrolltotop\'><a href=\'#top\'><i class=\'fa fa-arrow-up\'></i></a></div>"); 
				if($("'.$entrydiv.' '.$entryele.'").length){
					$("'.$entrydiv.'").prepend("<hr /><span id=\'createalisttog\'><i class=\'fa fa-angle-up\'></i> '.$entrytoggle.'</span><span id=\'createalisttogd\' class=\'hidden\'><i class=\'fa fa-angle-down\'></i> '.$entrytoggle.'</span><div class=\'createalist_listitems hidden\'><ol></ol></div><hr />"); 
					$(function() {
						var list = $(\'.createalist_listitems ol\');
						$("'.$entrydiv.' '.$entryele.'").each(function() {
							$(this).prepend(\'<a name="\' + $(this).text() + \'"></a>\');
							$(list).append(\'<li><a href="#\' + $(this).text() + \'">\' +  $(this).text() + \'</a></li>\');
						});
						$(\'#createalisttog\').click(function(){
							$(\'.createalist_listitems\').removeClass(\'hidden\');
							$(\'#createalisttog\').addClass(\'hidden\');
							$(\'#createalisttogd\').removeClass(\'hidden\');
						});
						$(\'#createalisttogd\').click(function(){
							$(\'.createalist_listitems\').addClass(\'hidden\');
							$(\'#createalisttogd\').addClass(\'hidden\');
							$(\'#createalisttog\').removeClass(\'hidden\');
						});					
						$(window).scroll(function() {
							var scroll = $(window).scrollTop();
								if (scroll >= 500) {
									$(".scrolltotop").addClass("show");
							} else {
									$(".scrolltotop").removeClass("show");
							}
						});
					});
				};';
			}
		}
		echo '
		});
		</script>';
	}
	add_action('wp_footer','MOMScriptsFooter');
?>