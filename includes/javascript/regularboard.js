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

	var left = document.getElementById("boardform"), // left div outside of the event.
		// this saves javascript from doing extra work
		stop = (left.offsetTop - 60); // -60 so it won't be jumpy

	window.onscroll = function (e) {
		 // cross-browser compatible scrollTop.
	 var scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;


	 if (scrollTop >= stop) { // if user scrolls to 60px from the top of the left div
		left.className = 'stick'; // add the sticky class
	 } else {
		left.className = ''; // remove the sticky class
	 }

	}	