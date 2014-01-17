	jQuery(document).ready(function($){

		var hash = window.location.hash.substr(1);
		if(hash != false && hash != 'undefined'){
			$('#'+hash+'').addClass('current');
			$(location.hash + '.reply').addClass('active');
		};
		var hash = window.location.hash.substr(1);
		if(hash != false && hash != 'undefined'){
			$('#'+hash+'').addClass('current');
			$(location.hash + '.tinycomment').addClass('active');
		};		
		
		$('.loadmore').click(function(){
			var regbo_urlid = $(this).attr('xdata');
			var regbo_url = $(this).attr('data');
			$('.omitted'+regbo_urlid).load(regbo_url + ' div.op div.reply');
			$(this).addClass('hidden');
		});
		
		$('.reload').click(function(){
			var regbo_relurl = $(this).attr('data');
			$('#omitted').load(regbo_relurl + ' div.reply');
		});
		
	});

	function replyThis(event){
		var targ = event.target || event.srcElement;
		document.getElementById("REPLYTO").value += targ.textContent || targ.innerText;
	}
	function formatThis(event){
		var targ = event.target || event.srcElement;
		document.getElementById("COMMENT").value += targ.textContent || targ.innerText;
	}	
	function reportThis(event){
		var targ = event.target || event.srcElement;
		document.getElementById("report_ids").value += targ.textContent || targ.innerText;
	}	