<?php if(!defined('MyOptionalModules')){ die('You can not call this file directly.');}$themetakeover_youtubeurl = get_option('MOM_themetakeover_youtubefrontpage');$themetakeoverfindvideoid = $themetakeover_youtubeurl;parse_str(parse_url($themetakeoverfindvideoid,PHP_URL_QUERY),$thevideoidforyoutube);$thevideoid = $thevideoidforyoutube['v'];  	$themetakeover_youtubedivs = get_option('MOM_themetakeover_youtubedivs');
$fitvids = plugins_url().'/my-optional-modules/includes/javascript/fitvids.js';?>
<!DOCTYPE html>
	<html <?php language_attributes();?>>
	<head>
		<meta charset="UTF-8" />
		<title><?php wp_title( '|',true,'right');?></title>
		<link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
		<?php wp_head();?>
	</head>
	<body <?php body_class();?>>
		<div class="youtubethemetakeoveroverlay">
			<h3>4 0 4</h3>
			<form role="search" method="get" class="youtube404search" id="searchform" action="<?php echo esc_url(home_url('/'));?>">
				<div>
					<input type="text" value="" name="s" id="youtube404" placeholder="Search" /><input type="submit" id="yt404searchsubmit" value="Search" />
				</div>
			</form>
			<div class="youtubethemetakeover">
				<iframe src="http://www.youtube.com/embed/<?php echo esc_html($thevideoid);?>?autoplay=1&amp;loop=1&amp;playlist=<?php echo esc_html($thevideoid);?>&amp;controls=0&amp;showinfo=0&amp;autohide=1" frameborder="0" allowfullscreen></iframe>
			</div>
			<p>go <a href="<?php echo esc_url(home_url('/'));?>">home</a> - nothing to see here.</p>
		</div>
		<?php wp_footer();?>
		<script type="text/javascript" src="<?php echo esc_html($fitvids);?>"></script>
		<script>
			jQuery(document).ready(function ($){
				$(".youtubethemetakeover").fitVids();
			});
		</script>
	</body>
</html>