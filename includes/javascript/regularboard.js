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
		
		$('.reload').click(function(){
			var regbo_relurl = $(this).attr('data');
			$('#omitted').load(regbo_relurl + ' div.tinycomment.below');
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