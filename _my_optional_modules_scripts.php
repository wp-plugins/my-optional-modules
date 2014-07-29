<?php 

if ( !defined ( 'MyOptionalModules' ) ) { 
	die ();
}

if ( !function_exists ( 'my_optional_modules_scripts' ) ) {
	function my_optional_modules_scripts(){
		function mom_jquery(){
			
			if(get_option('MOM_themetakeover_fitvids') != ''){
				$fitvids = plugins_url().'/my-optional-modules/includes/javascript/fitvids.js';
				wp_register_script( 'fitvids', $fitvids, array( 'jquery' ) );
			}
			if(get_option('mommaincontrol_lazyload') == 1){
				$lazyLoad = '//cdn.jsdelivr.net/jquery.lazyload/1.9.0/jquery.lazyload.min.js';
				$lazyLoadFunctions = plugins_url().'/my-optional-modules/includes/javascript/lazyload.js';
				wp_register_script( 'lazyload', $lazyLoad, array( 'jquery' ) );
				wp_register_script( 'lazyloadFunctions', $lazyLoadFunctions, array( 'jquery' ) );
			}
			if(get_option('MOM_themetakeover_wowhead') == 1){
				$wowhead = '//static.wowhead.com/widgets/power.js';
				$tooltips = plugins_url().'/my-optional-modules/includes/javascript/wowheadtooltips.js';
				wp_register_script( 'wowhead', $wowhead, array( 'jquery' ) );
				wp_register_script( 'wowheadTooltips', $tooltips, array( 'jquery' ) );
			}
			if(get_option('MOM_themetakeover_topbar') == 1){
				$stucktothetop = plugins_url().'/my-optional-modules/includes/javascript/stucktothetop.js';
				wp_register_script( 'stuckToTop', $stucktothetop, array( 'jquery' ) );
			}
			if(get_option('MOM_themetakeover_topbar') == 2){
				$stucktothebottom = plugins_url().'/my-optional-modules/includes/javascript/stucktothebottom.js';
				wp_register_script( 'stucktothebottom', $stucktothebottom, array( 'jquery' ) );
			}
		}
		add_action('wp_enqueue_scripts','mom_jquery');
		function MOMScriptsFooter(){
			if(get_option('momanalytics_code') != '' || 
			get_option('mommaincontrol_momja') == 1 && is_archive() || 
			get_option('mommaincontrol_momja') == 1 && is_home() || 
			get_option('mommaincontrol_momja') == 1 && is_search() || 
			get_option('MOM_themetakeover_fitvids') != '' || 
			get_option('MOM_themetakeover_postdiv') != '' && get_option('MOM_themetakeover_postelement') != ''){
			echo '
			<script type=\'text/javascript\'>';
			if(get_option('momanalytics_code') != ''){
				echo '
				(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
				ga(\'create\',\''.get_option('momanalytics_code').'\',\''.home_url('/').'\');
				ga(\'send\',\'pageview\');
				';
			}			
			
			
				echo 'jQuery(document).ready(function($){';
				if(get_option('mommaincontrol_momja') == 1){
					if(is_archive() || is_home() || is_search()){
						echo '
						$(\'input,textarea\').keydown(function(e){
							e.stopPropagation();
						});
						var hash = window.location.hash.substr(1);
						if(hash != false && hash != \'undefined\'){
							$(\'#\'+hash+\'\').addClass(\'current\');
							$(document).keydown(function(e){
							switch(e.which){
								case '.get_option('jump_around_4').':
									var $current = $(\''.get_option('jump_around_0').'.current\'),
									$prev_embed = $current.prev();
									$(\'html, body\').animate({scrollTop:$prev_embed.offset().top - 100}, 500);
									$current.removeClass(\'current\');
									$prev_embed.addClass(\'current\');
									window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
									e.preventDefault();
									return;
								break;
								case '.get_option('jump_around_6').': 
									var $current = $(\''.get_option('jump_around_0').'.current\'),
									$next_embed = $current.next(\''.get_option('jump_around_0').'\');
									$(\'html, body\').animate({scrollTop:$next_embed.offset().top - 100}, 500);
									$current.removeClass(\'current\');
									$next_embed.addClass(\'current\');
									window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
									e.preventDefault();
									return;
								break;
								case '.get_option('jump_around_5').': 
										if(jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\'))
										document.location.href=jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\');
										e.preventDefault();
										return;
										break;
								default: return; 
							}
						});
						}else{
						$(\''.get_option('jump_around_0').':eq(0)\').addClass(\'current\');
						$(document).keydown(function(e){
							switch(e.which){
								case '.get_option('jump_around_4').': 
									var $current = $(\''.get_option('jump_around_0').'.current\'),
									$prev_embed = $current.prev();
									$(\'html, body\').animate({scrollTop:$prev_embed.offset().top - 100}, 500);
									$current.removeClass(\'current\');
									$prev_embed.addClass(\'current\');
									window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
									e.preventDefault();
									return;
								break;
								case '.get_option('jump_around_6').': 
									var $current = $(\''.get_option('jump_around_0').'.current\'),
									$next_embed = $current.next(\''.get_option('jump_around_0').'\');
									$(\'html, body\').animate({scrollTop:$next_embed.offset().top - 100}, 500);
									$current.removeClass(\'current\');
									$next_embed.addClass(\'current\');
									window.location.hash = $(\''.get_option('jump_around_0').'.current\').attr(\'id\');
									e.preventDefault();
									return;
								break;
								case '.get_option('jump_around_5').': 
										if(jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\'))
										document.location.href=jQuery(\'.current '.get_option('jump_around_1').'\').attr(\'href\');
										e.preventDefault();
										return;
										break;
							}
							
						});
						}
						if($(\''.get_option('jump_around_2').'\').is(\'*\')){
						$(document).keydown(function(e){
							switch(e.which){
								case '.get_option('jump_around_7').': 
									document.location.href=jQuery(\''.get_option('jump_around_2').'\').attr(\'href\');
									e.preventDefault();
									return;
									break;
							}
							
						});
						}
						if($(\''.get_option('jump_around_3').'\').is(\'*\')){
						$(document).keydown(function(e){
							switch(e.which){
								case '.get_option('jump_around_8').': 
									document.location.href=jQuery(\''.get_option('jump_around_3').'\').attr(\'href\');
									e.preventDefault();
									return;
									break;
							}
						});
						}
						';
					}
				}
				// Fitvids
				if(get_option('MOM_themetakeover_fitvids') != ''){
					$fitvidContainer = get_option('MOM_themetakeover_fitvids');
					echo '
					$(\''.$fitvidContainer.'\').fitVids();';
				}
				// Post/page list(s) / scroll-to-top arrow
				if(get_option('MOM_themetakeover_postdiv') != '' && get_option('MOM_themetakeover_postelement') != ''){
					if(is_single() || is_page()){
						$entrydiv = esc_attr(get_option('MOM_themetakeover_postdiv'));
						$entryele = esc_attr(get_option('MOM_themetakeover_postelement'));
						$entrytoggle = esc_attr(get_option('MOM_themetakeover_posttoggle'));
						echo '
						$("body").append("<div class=\'scrolltotop\'><a href=\'#top\'><i class=\'fa fa-arrow-up\'></i></a></div>"); 
						if($("'.$entrydiv.' > '.$entryele.'").length){
							$("'.$entrydiv.'").prepend("<hr /><span id=\'createalisttog\'><i class=\'fa fa-angle-up\'></i> '.$entrytoggle.'</span><span id=\'createalisttogd\' class=\'hidden\'><i class=\'fa fa-angle-down\'></i> '.$entrytoggle.'</span><div class=\'createalist_listitems hidden\'><ol></ol></div><hr />"); 
							$(function(){
								var list = $(\'.createalist_listitems ol\');
								$("'.$entrydiv.' '.$entryele.'").each(function(){
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
								$(window).scroll(function(){
									var scroll = $(window).scrollTop();
										if(scroll >= 500){
											$(".scrolltotop").addClass("show");
									}else{
											$(".scrolltotop").removeClass("show");
									}
								});
							});
						};';
					}
				}
				echo '});</script>';
			}
		}
		add_action('wp_footer','MOMScriptsFooter',99999);
	}
}