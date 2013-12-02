	jQuery(document).ready(function($){
		$(window).scroll(function(){
			var scroll = $(window).scrollTop();
				if(scroll >= 0){
					$(".momnavbar").addClass("stucktothetop");
			}else{
					$(".momnavbar").removeClass("stucktothetop");
			}
		});
	});