jQuery(document).ready(function($){
	
	/** 
	 * Contents
	 * 1.0 Youtube Embeds
	 * 2.0 Horizontal Gallery Image Clicks
	**/	
	
	// 1.0 Youtube embeds
	$( '[id^=mom-youtube-]' ).each(function() {
		var mom_youtube_id   = $(this).attr('data-video');
		var mom_youtube_time = $(this).attr('data-time');
		$( '#mom-youtube-thumbnail-' + mom_youtube_id ).css({ "visibility":"visible", "display":"block" , "width":"640" , "height":"auto"});
		$( '#mom-youtube-' + mom_youtube_id + ' .mom-youtube-play-button' ).css({ "visibility":"visible", "display":"block"});
		$( '#mom-youtube-thumbnail-' + mom_youtube_id ).live( 'click', function( event){
			$( this ) .parent().append(
				"<object width='640' height='390' data='https://www.youtube.com/v/" + mom_youtube_id + "?version=3&amp;autoplay=1" + mom_youtube_time + "'> \
				<param name='movie' value='https://www.youtube.com/v/" + mom_youtube_id + "?version=3&amp;autoplay=1" + mom_youtube_time + "' /> \
				<param name='allowScriptAccess' value='always' /> \
				<embed src='https://www.youtube.com/v/" + mom_youtube_id + "?version=3&amp;autoplay=1" + mom_youtube_time + "'\
				type='application/x-shockwave-flash' \
				allowscriptaccess='always' \
				width='640' \
				height='390' /> \
				</object>"
			);
			$( '#mom-youtube-thumbnail-' + mom_youtube_id ).remove();
			$( '#mom-youtube-' + mom_youtube_id + ' .mom-youtube-play-button' ).remove();
		});
	});
	
	// 2.0 Horizontal Gallery Image Clicks
	$( '[id^=mom-hgallery-gallery-]' ).each(function() {
		var selector = $(this).attr('id');
		var gid = $(this).attr('data-gallery-id');
		$(document).on('click', '#' + selector + ' a img', function(e){
			e.preventDefault();
			var url = $(this).attr('src');
			var cla = $(this).attr('class');
			var wid = $(this).attr('width');
			var hei = $(this).attr('height');
			if ( url.indexOf( '-'+wid+'x'+hei+'' ) !== -1 ) {
				var img = url.split('-'+wid+'x'+hei+'')[0];
				var ext = '.' + url.substr( ( url.lastIndexOf('.') + 1 ) );
			} else {
				var img = url;
				var ext = '';
			}			
			$('#mom_hgallery_catch_' + gid).html('<a href="'+img+ext+'"><img src="'+img+ext+'" class="hgallery-loaded" /></a>');
		});
	});
	
});