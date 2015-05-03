;(function( $ ){

  'use strict';

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        'iframe[src*="player.vimeo.com"]',
        'iframe[src*="youtube.com"]',
        'iframe[src*="youtube-nocookie.com"]',
        'iframe[src*="kickstarter.com"][src*="video.html"]',
        'object',
        'embed'
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(count){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + count;
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );

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
			$(".media-embed").fitVids();
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