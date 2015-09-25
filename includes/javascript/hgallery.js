jQuery(document).ready(function($){
	
	$(document)
		.on('click', '.close-mom-gallery-image', function(e)
		{
			e.preventDefault();
			$('.mom-hgallery-catch')
				.empty();
		});

	$('[id^=mom-hgallery-gallery-]')
		.each(function()
		{
			var selector = $(this)
				.attr('id');
			var gid = $(this)
				.attr('data-gallery-id');
			$(document)
				.on('click', '#' + selector + ' a img', function(e)
				{
					e.preventDefault();
					var iid = $(this)
						.parent()
						.parent()
						.parent()
						.attr('img-id');
					var cap = $('figcaption#' + iid + '')
						.attr('img-comment');
					if (cap)
					{
						cap = '<span class="image-caption">' + cap + '</span>';
					}
					else
					{
						cap = '<span class="image-caption"></span>';
					}
					var url = $(this)
						.attr('src');
					var cla = $(this)
						.attr('class');
					var wid = $(this)
						.attr('width');
					var hei = $(this)
						.attr('height');
					if (url.indexOf('-' + wid + 'x' + hei + '') !== -1)
					{
						var img = url.split('-' + wid + 'x' + hei + '')[0];
						var ext = '.' + url.substr((url.lastIndexOf('.') + 1));
					}
					else
					{
						var img = url;
						var ext = '';
					}
					$('#mom_hgallery_catch_' + gid)
						.html('<i class="close-mom-gallery-image fa fa-close"> close</i><a href="' + img + ext + '"><img src="' + img + ext +
							'" class="hgallery-loaded" /></a>' + cap + '');
				});
		});
	
});