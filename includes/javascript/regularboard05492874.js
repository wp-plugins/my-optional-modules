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
		$('.rb_yt').click(function(e){
			e.preventDefault();
			var youtube_id = $(this).attr('data');
			$(this).empty();
			$('#'+youtube_id+'').html("<iframe src=\"http://www.youtube.com/embed/"+youtube_id+"?loop=1&amp;playlist="+youtube_id+"&amp;controls=0&amp;showinfo=0&amp;autohide=1\" width=\"420\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>");
		});

		$('.approvalrating label').click(function(e){
			e.preventDefault();
			$(this).empty();
			var vote_id = $(this).attr('data');
			var div_id = $(this).attr('id');
			$('#rating'+div_id+'').load(vote_id + ' .points');
		});		
		
		$('.imageEXPAC').click(function(e){
			e.preventDefault();
			$('img.image').toggleClass('hidden');
			$('.fa-plus').toggleClass('fa-minus');
			$(this).toggleClass('imageEXPAND');
		});		
		$('.imageOP').click(function(e){
			e.preventDefault();
			$(this).toggleClass('imageEXPAND');
		});
		$('.imageREPLY').click(function(e){
			e.preventDefault();
			$(this).toggleClass('imageEXPAND');
		});		
		
		$('a.newtopic').click(function(e){
			e.preventDefault();
			var newtopic_href = $(this).attr('href');
			$(this).addClass('hidden');
			$('span.notopic').removeClass('hidden');
			$('div.newtopic').load(newtopic_href + ' div.tinyreply');
			$('div.tinyreply').hide();
		});
		
		$('span.notopic').click(function(e){
			e.preventDefault();
			$(this).addClass('hidden');
			$('a.newtopic').removeClass('hidden');
			$('div.newtopic').empty();
			$('div.tinyreply').show();
		});		
		
		$('.loadme').removeClass('hidden');
		$('.loadme').click(function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#load'+regbo_id+'').load(regbo_url + ' div#'+regbo_id+'');
			$('#'+regbo_id+'.hideme').removeClass('hidden');
		});
		$('.hideme').click(function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#load'+regbo_id+'').empty();
			$('#'+regbo_id+'.loadme').removeClass('hidden');
		});		
		
		$('.srcme').removeClass('hidden');
		$('.srcme').click(function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#src'+regbo_id+'').load(regbo_url + ' div.src');
			$('#'+regbo_id+'.srchideme').removeClass('hidden');
		});
		$('.srchideme').click(function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#src'+regbo_id+'').empty();
			$('#'+regbo_id+'.srcme').removeClass('hidden');
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