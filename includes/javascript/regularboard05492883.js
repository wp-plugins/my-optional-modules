	jQuery(document).ready(function($){

		$('.loadme').removeClass('hidden');
		$('.srcme').removeClass('hidden');

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
		
		
		$(document).on('click','.reload',function(){
			var regbo_relurl = $(this).attr('data');
			$('#omitted').load(regbo_relurl + ' div.tinycomment.below');
		});
		$(document).on('click','.rb_yt',function(e){
			e.preventDefault();
			var youtube_id = $(this).attr('data');
			$(this).empty();
			$('#'+youtube_id+'').html("<iframe src=\"http://www.youtube.com/embed/"+youtube_id+"?autoplay=1&amp;loop=1&amp;playlist="+youtube_id+"&amp;controls=0&amp;showinfo=0&amp;autohide=1\" width=\"420\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>");
		});
		$(document).on('click','.approvalrating label',function(e){
			e.preventDefault();
			$(this).empty();
			var vote_id = $(this).attr('data');
			var div_id = $(this).attr('id');
			$('#rating'+div_id+'').load(vote_id + ' .points');
		});		
		$(document).on('click','a.newtopic',function(e){
			e.preventDefault();
			var newtopic_href = $(this).attr('href');
			$(this).addClass('hidden');
			$('span.notopic').removeClass('hidden');
			$('div.newtopic').load(newtopic_href + ' div.tinyreply');
			$('div.tinyreply').hide();
		});
		$(document).on('click','span.notopic',function(e){
			e.preventDefault();
			$(this).addClass('hidden');
			$('a.newtopic').removeClass('hidden');
			$('div.newtopic').empty();
			$('div.tinyreply').show();
		});		
		$(document).on('click','.loadme',function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#load'+regbo_id+'').load(regbo_url + ' div#'+regbo_id+'');
			$('#'+regbo_id+'.hideme').removeClass('hidden');
		});
		$(document).on('click','.hideme',function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#load'+regbo_id+'').empty();
			$('#'+regbo_id+'.loadme').removeClass('hidden');
		});
		$(document).on('click','.srcme',function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#src'+regbo_id+'').load(regbo_url + ' div.src');
			$('#'+regbo_id+'.srchideme').removeClass('hidden');
		});
		$(document).on('click','.srchideme',function(){
			var regbo_id = $(this).attr('id');
			var regbo_url = $(this).attr('data');
			$(this).addClass('hidden');
			$('#src'+regbo_id+'').empty();
			$('#'+regbo_id+'.srcme').removeClass('hidden');
		});				
		$(document).on('click','.imageEXPAC',function(e){
			e.preventDefault();
			$('img.image').toggleClass('hidden');
			$('.fa-plus').toggleClass('fa-minus');
			$(this).toggleClass('imageEXPAND');
		});
		$(document).on('click','.imageREPLY',function(e){
			e.preventDefault();
			$(this).toggleClass('imageEXPAND');
		});		
		$(document).on('click','.imageOP',function(e){
			e.preventDefault();
			$(this).toggleClass('imageEXPAND');
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