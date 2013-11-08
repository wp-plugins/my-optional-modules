<?php if(!defined('MyOptionalModules')){die('You can not call this file directly.');}
	if (!is_admin()) add_action("wp_enqueue_scripts", "Jump_Around_jquery_enqueue", 11);
	function Jump_Around_jquery_enqueue() {
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
		wp_enqueue_script('jquery');
	}
	add_action('wp_footer', 'jump_around_footer_script');	
	function jump_around_footer_script(){
		if (is_archive() || is_home() || is_search() ) { 
			echo "
			<script type=\"text/javascript\">
			jQuery( document ).ready( function($) {

			\$('input,textarea').keydown( function(e) {
				e.stopPropagation();
			});
			var hash = window.location.hash.substr(1);
			if(hash != false && hash != 'undefined') {
				\$('#'+hash+'').addClass('current');
				\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_4") . ":
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$prev_embed = \$current.prev();
						\$('html, body').animate({scrollTop:\$prev_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$prev_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_6") . ": 
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$next_embed = \$current.next('" . get_option("jump_around_0") . "');
						\$('html, body').animate({scrollTop:\$next_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$next_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_5") . ": 
							if(jQuery('.current " . get_option("jump_around_1") . "').attr('href'))
							document.location.href=jQuery('.current " . get_option("jump_around_1") . "').attr('href');
							e.preventDefault();
							return;
							break;
					default: return; 
				}
			});
			}else{
			\$('" . get_option("jump_around_0") . ":eq(0)').addClass('current');
			\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_4") . ": 
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$prev_embed = \$current.prev();
						\$('html, body').animate({scrollTop:\$prev_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$prev_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_6") . ": 
						var \$current = \$('" . get_option("jump_around_0") . ".current'),
						\$next_embed = \$current.next('" . get_option("jump_around_0") . "');
						\$('html, body').animate({scrollTop:\$next_embed.offset().top - 100}, 500);
						\$current.removeClass('current');
						\$next_embed.addClass('current');
						window.location.hash = \$('" . get_option("jump_around_0") . ".current').attr('id');
						e.preventDefault();
						return;
					break;
					case " . get_option("jump_around_5") . ": 
							if(jQuery('.current " . get_option("jump_around_1") . "').attr('href'))
							document.location.href=jQuery('.current " . get_option("jump_around_1") . "').attr('href');
							e.preventDefault();
							return;
							break;
				}
				
			});
			}
			if (\$('" . get_option("jump_around_2") . "').is('*')) {
			\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_7") . ": 
						document.location.href=jQuery('" . get_option("jump_around_2") . "').attr('href');
						e.preventDefault();
						return;
						break;
				}
				
			});
			}
			if (\$('" . get_option("jump_around_3") . "').is('*')) {
			\$(document).keydown(function(e){
				switch(e.which) {
					case " . get_option("jump_around_8") . ": 
						document.location.href=jQuery('" . get_option("jump_around_3") . "').attr('href');
						e.preventDefault();
						return;
						break;
				}
				
			});
			}
			});
			</script>
			";
		}
	} 
?>