<?php

class Guides_Menu_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct( 'guides_menu_widget', __( 'Guides Menu', 'trusted' ),
			array( 'description' => __( 'A hierarchical menu of the guides', 'guides' ) ) );
	}

	/**
	 * Outputs the content of the widget on the frontend
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$post_type = get_post_type();

		if ( ! in_array( $post_type, guides_get_post_types() ) ) {
			return;
		}

		// Before and after widget arguments are defined by themes
		echo $args['before_widget'];

		// Widget title
		echo $args['before_title'];
		echo apply_filters( 'widget_title', get_post_type_object( $post_type )->labels->name );
		echo $args['after_title'];

		// Widget body
		echo self::get_menu( $post_type );

		echo $args['after_widget'];

		// Add class "current" to the currently active link
		?>
		<script>
			(function ($) {
				$(".widget_guides_menu_widget a").each(function () {
					if ($(this).attr('href') == window.location.href) {
						$(this).addClass("current");
					}
				});
			})(jQuery);
		</script>
		<?php
	}

	/**
	 * Retrieve hierarchical menu for given post type
	 *
	 * @param string $post_type
	 *
	 * @return string|void HTML menu
	 */
	static function get_menu( $post_type ) {
		$transient_key = 'guides_menu_' . $post_type;
		$menu          = get_transient( $transient_key );
		if ( $menu === false ) {
			$menu = wp_page_menu( array( 'post_type' => $post_type, 'post_status' => 'private', 'echo' => false ) );
			set_transient( $transient_key, $menu, 60 * 5 );
		}

		return $menu;
	}
}

/*
 * Register widget
 */
add_action( 'widgets_init', function () {
	register_widget( 'Guides_Menu_Widget' );
} );

/*
 * Invalidate menu widget cache when updating posts
 */
add_action( 'save_post', 'guides_invalidate_menu_cache' );
function guides_invalidate_menu_cache( $post_id ) {
	$transient_key = 'guides_menu_' . get_post_type( $post_id );
	delete_transient( $transient_key );
}
