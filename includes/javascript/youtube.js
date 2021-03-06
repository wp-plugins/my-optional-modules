jQuery(document).ready(function($){	
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
			$( '.embed').fitVids();
		});
	});
});