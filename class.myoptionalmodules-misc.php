<?php 
/**
 * CLASS myoptionalmodules_misc()
 *
 * File last update: 10.0.5
 *
 * Functionality for:
 * - Disqus Universal Code
 * - Miniloops
 * - Google Analytics
 * - Google Site Verification
 * - Bing Site Verification
 * - Alexa Site Verification
 * - Frontpage post
 * - Previous/Next Link Class
 * - Read More
 * - Random Post
 * - Random Titles
 * - Random Descriptions
 */

if ( !defined ( 'MyOptionalModules' ) ) {
	die();
}

class myoptionalmodules_misc {

	function __construct() {
		global $myoptionalmodules_disqus , $myoptionalmodules_randompost , $myoptionalmodules_bing , $myoptionalmodules_alexa , $myoptionalmodules_google , $myoptionalmodules_verification , $myoptionalmodules_frontpage , $myoptionalmodules_previouslinkclass , $myoptionalmodules_nextlinkclass , $myoptionalmodules_readmore , $myoptionalmodules_randomtitles , $myoptionalmodules_randomdescriptions;
		if( $myoptionalmodules_disqus ):
			add_filter ( 'comments_template' , array ( $this , 'disqus_code' ) );
		endif;
		add_filter ( 'the_content' , array ( $this , 'miniloop' ) );
		if( $myoptionalmodules_google ):
			add_action ( 'wp_head' , array ( $this , 'google_analytics' ) );
		endif;
		if( $myoptionalmodules_bing ):
			add_action ( 'wp_head' , array ( $this , 'bing' ) );
		endif;
		if( $myoptionalmodules_alexa ):
			add_action ( 'wp_head' , array ( $this , 'alexa' ) );
		endif;
		if( $myoptionalmodules_verification ):
			add_action ( 'wp_head' , array ( $this , 'site_verification' ) );
		endif;
		if( $myoptionalmodules_frontpage && 'off' != $myoptionalmodules_frontpage ):
			add_action ( 'wp' , array ( $this , 'front_post' ) );
		endif;
		if( $myoptionalmodules_previouslinkclass ):
			add_filter ( 'previous_posts_link_attributes', array ( $this , 'previous_link_class' ) );
			add_filter ( 'previous_post_link' , array ( $this , 'previous_link' ) );
		endif;
		if( $myoptionalmodules_nextlinkclass ):
			add_filter ( 'next_posts_link_attributes', array ( $this , 'next_link_class' ) );
			add_filter ( 'next_post_link', array ( $this , 'next_link' ) );
		endif;
		if( $myoptionalmodules_readmore ):
			add_filter ( 'the_content_more_link' , array ( $this , 'read_more' ) );
			add_filter ( 'excerpt_more' , array ( $this , 'read_more' ) );
		endif;
		if( $myoptionalmodules_randompost ):
			add_action ( 'wp' , array ( $this , 'random' ) );
		endif;
		if( $myoptionalmodules_randomtitles ):
			add_filter ( 'pre_option_blogname' , array ( $this , 'random_title' ) , 10 , 2 );
		endif;
		if( $myoptionalmodules_randomdescriptions ):
			add_filter ( 'pre_option_blogdescription' , array ( $this , 'random_description' ) , 10 , 2 );
		endif;
	}

	// Disqus Universal Code
	function disqus_code ( $comment_template ) {
		return dirname( __FILE__ ) . '/includes/templates/disqus.php';
	}
	
	// Miniloops
	function miniloop ( $content ) {
		global $wp , $post , $myoptionalmodules_miniloopmeta , $myoptionalmodules_miniloopstyle , $myoptionalmodules_miniloopamount;
		if( is_single() && $myoptionalmodules_miniloopmeta && $myoptionalmodules_miniloopstyle && $myoptionalmodules_miniloopamount):
			$key    = sanitize_text_field ( get_post_meta ( $post->ID , $myoptionalmodules_miniloopmeta , true ) );
			if( $key && $myoptionalmodules_miniloopmeta ):
				$output = do_shortcode ( "[mom_miniloop meta='{$myoptionalmodules_miniloopmeta}' key='{$key}' style='{$myoptionalmodules_miniloopstyle}' amount='{$myoptionalmodules_miniloopamount}' ]" );
			else:
				$output = null;
			endif;
			return do_shortcode ( $content ) . $output;
		else:
			return do_shortcode ( $content );
		endif;
	}

	// Google Analytics
	function google_analytics() {
		global $myoptionalmodules_google;
		echo "
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', '{$myoptionalmodules_google}', 'auto');
			ga('send', 'pageview');
		</script>\n\n";
	}
	
	// Site Verification Content
	// + Google
	// + Bing
	// + Alexa
	function site_verification() {
		global $myoptionalmodules_verification;
		echo "<meta name='google-site-verification' content='{$myoptionalmodules_verification}' />\n\n";
	}
	function bing() {
		global $myoptionalmodules_bing;
		echo "<meta name='msvalidate.01' content='{$myoptionalmodules_bing}' />\n";
	}
	function alexa() {
		global $myoptionalmodules_alexa;
		echo "<meta name='alexaVerifyID' content='{$myoptionalmodules_alexa}'/>\n";	
	}

	// Frontpage post
	function front_post() {
		global $myoptionalmodules_frontpage;
		if( is_home() && 'off' != $myoptionalmodules_frontpage ):
			if( is_numeric ( $myoptionalmodules_frontpage ) ):
				$myoptionalmodules_frontpage = $myoptionalmodules_frontpage;
			elseif( $myoptionalmodules_frontpage ):
				$myoptionalmodules_frontpage = '';
			endif;
			if( have_posts() ) : the_post();
				header( 'location:' . esc_url( get_permalink( $myoptionalmodules_frontpage ) ) ); 
				exit; 
			endif;
		endif;
	}

	// Previous/Next Link Class
	function previous_link_class() {
		global $myoptionalmodules_previouslinkclass;
		return "class='{$myoptionalmodules_previouslinkclass}'";
	}
	function previous_link( $output ) {
		global $myoptionalmodules_previouslinkclass;
		$class = "class='{$myoptionalmodules_previouslinkclass}'";
		return str_replace ( '<a href=' , "<a {$class} href=" , $output);
	}
	function next_link_class() {
		global $myoptionalmodules_nextlinkclass;
		return "class='{$myoptionalmodules_nextlinkclass}'";
	}
	function next_link( $output ) {
		global $myoptionalmodules_nextlinkclass;
		$class = "class='{$myoptionalmodules_nextlinkclass}'";
		return str_replace ( '<a href=' , "<a {$class} href=" , $output);	
	}

	// Read More
	function read_more( $more ) {
		global $myoptionalmodules_readmore;
		$get_link = esc_url ( get_permalink() );
		if( '%blank%' == $myoptionalmodules_readmore ):
			return '';
		else:
			return "<a href='{$get_link}'>{$myoptionalmodules_readmore}</a>";
		endif;
	}

	// Random post
	function random() {
		global $myoptionalmodules_randompost;
		if( isset( $_GET[ $myoptionalmodules_randompost ] ) ):
			$args = array (
				'numberposts' => 1,
				'post_type'   => 'post',
				'post_status' => 'publish',
				'orderby'     => 'rand'
			);
			$get_all = get_posts ( $args );
			foreach ( $get_all as $all_posts ):
				$random_post = $all_posts->ID;
			endforeach;
			header ( 'location:' . esc_url ( get_permalink ( $random_post ) ) ); exit;
		endif;
	}

	// Random Titles
	function random_title( $title ) {
		global $wp, $myoptionalmodules_randomtitles;
		$titles = '';
		if( '' != $myoptionalmodules_randomtitles ):
			$titles = $myoptionalmodules_randomtitles;
		endif;
		$title = explode ( '::' , $titles );
		return $title[ array_rand ( $title ) ];
	}

	// Random Descriptions
	function random_description( $title ) {
		global $wp, $myoptionalmodules_randomdescriptions;
		$descriptions = '';
		if( '' != $myoptionalmodules_randomdescriptions ):
			$descriptions = $myoptionalmodules_randomdescriptions;
		endif;
		$descriptions = explode ( '::' , $descriptions );
		return $descriptions[ array_rand ( $descriptions ) ];
	}

}

$myoptionalmodules_misc = new myoptionalmodules_misc();