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
	}

	/**
	 * Retrieve hierarchical menu for given post type
	 *
	 * @param string $post_type
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
