	jQuery(document).ready(function($){
		$( function() {
			$("form").sisyphus();
		});
		var hash = window.location.hash.substr(2);
		if(hash != false && hash != 'undefined'){
			$('#'+hash+'').addClass('current');
			$(location.hash + '.reply').addClass('active');
		};
		$('.loadmore').click(function(){
			var regbo_urlid = $(this).parent().parent().attr('id');
			var regbo_url = $(this).attr('data');
			$('.omitted'+regbo_urlid).load(regbo_url + ' div#omitted div.reply');
		});
		$('.reload').click(function(){
			var regbo_relurl = $(this).attr('data');
			$('#omitted').load(regbo_relurl + ' div#omitted div.reply');
		});
		$('.toggelthis').click(function(){
			var regbo_divid = $(this).parent().attr('id');
			if($(this).parent().hasClass('toggled')){
			$('#'+regbo_divid+' .shortinfo').addClass('hidden');
			$('#'+regbo_divid+'').removeClass('toggled');
			$('#'+regbo_divid+' .toggelthis.fa.fa-plus').addClass('hidden');
			$('#'+regbo_divid+' .toggelthis.fa.fa-minus').removeClass('hidden');
			}else{
			$('#'+regbo_divid+' .toggelthis.fa.fa-minus').addClass('hidden');
			$('#'+regbo_divid+' .toggelthis.fa.fa-plus').removeClass('hidden');
			$('#'+regbo_divid+' .shortinfo').removeClass('hidden');
			$('#'+regbo_divid+'').addClass('toggled');
			}
		});
	});