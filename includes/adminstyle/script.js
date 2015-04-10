jQuery(document).ready(function($){

	$( '[id^=toggle-]' ).each(function() {
		var targetdiv = $(this).attr('data-div');

		if(window.location.hash){
			var hash = window.location.hash.substring(1);
			if(targetdiv == hash){
				$('#'+hash+'.disabled').toggleClass('enabled');
				$('#'+hash+'.disabled').toggleClass('disabled');
			}else{
				if($(targetdiv+'.enabled')){
					$('#'+targetdiv+'').addClass('disabled');
				}
			}
		}
		
		$(this).on('click',function(e){
			e.preventDefault();
			window.location.hash = this.hash;
			$('.enabled').each(function() {
				$(this).addClass('disabled');
			});
			$('#'+targetdiv+'').removeClass('disabled');
			$('#'+targetdiv+'').addClass('enabled');
		});
	});
	

	

});