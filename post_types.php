<?php

/**
 * Get Guides post types
 *
 * @return array Array with the keys representing the labels and the values representing the post types
 */
function guides_get_post_types() {
	$post_types = array();

	$countries = get_option( 'guides_countries' );
	foreach ( $countries as $country ) {
		// The post type has max. 20 characters and cannot contain capital letters or spaces
		$post_type = substr( sanitize_key( $country ), 0, 20 );
		$post_types[$country] = $post_type;
	}
	return $post_types;
}

/**
 * Register Guides post types
 */
add_action( 'init', 'guides_register_post_types', 0 );
function guides_register_post_types() {
	$labels = array(
		'name'                  => _x( 'Guides', 'Post Type General Name', 'guides' ),
		'singular_name'         => _x( 'Guide', 'Post Type Singular Name', 'guides' ),
		'add_new_item'          => __( 'Add New Guide', 'guides' ),
		'edit_item'             => __( 'Edit Guide', 'guides' ),
		'new_item'              => __( 'New Guide', 'guides' ),
		'view_item'             => __( 'View Guide', 'guides' ),
		'search_items'          => __( 'Search Guides', 'guides' ),
		'not_found'             => __( 'No guides found', 'guides' ),
		'not_found_in_trash'    => __( 'No guides found in Trash', 'guides' ),
		'all_items'             => __( 'All Guides', 'guides' ),
		'archives'              => __( 'Guide Archives', 'guides' ),
		'insert_into_item'      => __( 'Insert into guide', 'guides' ),
		'uploaded_to_this_item' => __( 'Uploaded to this guide', 'guides' ),
		'filter_items_list'     => __( 'Filter guides list', 'guides' ),
		'items_list_navigation' => __( 'Guides list navigation', 'guides' ),
		'items_list'            => __( 'Guides list', 'guides' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true, // @todo
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'has_archive'         => false,
		'menu_icon'           => 'dashicons-flag',
		'menu_position'       => 100,
		'hierarchical'        => true,
		'supports'            => array( 'title', 'editor', 'page-attributes', 'revisions' ),
		'map_meta_cap'        => true,
	);

	$post_types = guides_get_post_types();
	foreach ( $post_types as $label => $post_type ) {
		$args['labels']['name']  = $label;
		$args['capability_type'] = $capability_type = $post_type . '_guide';
		$args['rewrite']['slug'] = sanitize_title($label);

		register_post_type( $post_type, $args );
	}
}

/**
 * Add private pages to the Parent dropdown
 *
 * By default WP only displays published pages
 * in the Page Attributes meta box (post edit page) and
 * the quick edit screen (all posts page)
 */
add_filter( 'page_attributes_dropdown_pages_args', 'guides_enable_private_parent_pages' );
add_filter( 'quick_edit_dropdown_pages_args', 'guides_enable_private_parent_pages' );
function guides_enable_private_parent_pages( $dropdown_args, $post = null ) {
	$dropdown_args['post_status'] = array( 'publish', 'private', );

	return $dropdown_args;
}

/*
 * Set default post visibility to Private
 */
add_action( 'post_submitbox_misc_actions', function () {
	global $pagenow;

	if ( $pagenow == 'post-new.php' && in_array( get_post_type(), guides_get_post_types() ) ) {
		?>
		<script type="text/javascript">
			(function ($) {
				try {
					$('#post-visibility-display').text('<?php echo __( 'Private' ); ?>');
					$('#hidden-post-visibility').val('private');
					$('#visibility-radio-public').attr('checked', false);
					$('#visibility-radio-password').attr('checked', false);
					$('#visibility-radio-private').attr('checked', true);
				} catch (err) {
				}
			})(jQuery);
		</script>
		<?php
	}
} );
