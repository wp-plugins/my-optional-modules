<?php 

	global $myoptionalmodules_disqus;
	echo "
	<div id='disqus_thread'></div>
	<script type='text/javascript'>
		var disqus_shortname = '{$myoptionalmodules_disqus}';
		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
	</script>";

?>