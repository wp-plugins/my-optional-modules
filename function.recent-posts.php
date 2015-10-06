<?php 
/**
 * FUNCTION myoptionalmodules_WP_Widget_Recent_Posts()
 *
 * File last update: 10.1.9
 *
 * Alters the default 'Recent Posts' widget to exclude the post
 * that is currently being viewed ( is_single() )
 *
 * This is pretty much a copy/paste from core, so we aren't going 
 * to be altering TOO much of the original code.
 */

defined('MyOptionalModules') or exit;

if ( get_option ( 'myoptionalmodules_recentpostswidget' ) ) {

	function myoptionalmodules_WP_Widget_Recent_Posts() {
		register_widget ( 'myoptionalmodules_WP_Widget_Recent_Posts' );
	}
	add_action ( 'widgets_init' , 'myoptionalmodules_WP_Widget_Recent_Posts' );

	/**
	 * Recent_Posts widget class
	 *
	 * @since 2.8.0
	 */
	class myoptionalmodules_WP_Widget_Recent_Posts extends WP_Widget {
		function __construct() {
			$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
			parent::__construct('recent-posts', __('Recent Posts'), $widget_ops);
			$this->alt_option_name = 'widget_recent_entries';

			add_action( 'save_post', array($this, 'flush_widget_cache') );
			add_action( 'deleted_post', array($this, 'flush_widget_cache') );
			add_action( 'switch_theme', array($this, 'flush_widget_cache') );
		}
		function widget($args, $instance) {
			$cache = wp_cache_get('widget_recent_posts', 'widget');
			global $wp;
			global $post;
			if ( !is_array($cache) )
				$cache = array();
			if ( ! isset( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;
			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo $cache[ $args['widget_id'] ];
				return;
			}
			ob_start();
			extract($args);
			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
			if ( ! $number )
				$number = 10;
			$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

			$post_id = get_the_ID();
			if( is_single() ) {
				if ( get_option ( 'myoptionalmodules_keeptitle_recentpostswidget' ) ) {
					$r  = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
				} else {
					$r  = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'post__not_in' => array( $post_id ) ) ) );
				}
			} else {
				$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
			}
			
			if ($r->have_posts()) :
	?>
			<?php echo $before_widget; ?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul>
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<li>
					<?php if ( get_the_ID() == $post_id && is_single() && get_option ( 'myoptionalmodules_keeptitle_recentpostswidget' ) ) { ?>
						<b class="mom-bold-title"><?php if ( get_the_title() ) the_title(); else the_ID(); ?>
					<?php } else { ?>
						<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
					<?php }?>
				<?php if ( $show_date ) : ?>
					<span class="post-date"><?php echo get_the_date(); ?></span>
				<?php endif; ?>
				<?php if ( get_the_ID() == $post_id && is_single() && get_option ( 'myoptionalmodules_keeptitle_recentpostswidget' ) ) { ?>
					</b>
				<?php }?>
				</li>
			<?php endwhile; ?>
			</ul>
			<?php echo $after_widget; ?>
	<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
			endif;
			$cache[$args['widget_id']] = ob_get_flush();
			wp_cache_set('widget_recent_posts', $cache, 'widget');
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			$instance['show_date'] = (bool) $new_instance['show_date'];
			$this->flush_widget_cache();
			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['widget_recent_entries']) )
				delete_option('widget_recent_entries');
			return $instance;
		}
		function flush_widget_cache() {
			wp_cache_delete('widget_recent_posts', 'widget');
		}
		function form( $instance ) {
			$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
	?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

			<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
	<?php
		}
	}
}