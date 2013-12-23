	jQuery(document).ready(function($){
		$( function() {
			$("form").sisyphus();
		});
		var hash = window.location.hash.substr(1);
		if(hash != false && hash != 'undefined'){
			$('#'+hash+'').addClass('current');
			$(location.hash + '.reply').addClass('active');
		};
		$('.loadmore').click(function(){
			var regbo_urlid = $(this).parent().attr('id');
			var regbo_url = $(this).attr('data');
			$('.omitted'+regbo_urlid).load(regbo_url + ' div#omitted div.reply');
			$(this).addClass('hidden');
		});
		$('.reload').click(function(){
			var regbo_relurl = $(this).attr('data');
			$('#omitted').load(regbo_relurl + ' div#omitted div.reply');
		});
	});
