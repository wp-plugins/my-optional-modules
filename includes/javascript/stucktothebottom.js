	jQuery(document).ready(function($){
		$(window).scroll(function(){
			var scroll = $(window).scrollTop();
				if(scroll >= 0){
					$(".momnavbar").addClass("stucktothebottom");
			}else{
					$(".momnavbar").removeClass("stucktothebottom");
			}
		});
	});