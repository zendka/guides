<?php


/**
 * Add settings page
 */
add_action( 'admin_menu', function () {
	add_menu_page( 'Guides Settings', 'Guides Settings', 'manage_options', 'guides_page', 'guides_options_page',
		'dashicons-admin-settings', 81 );
} );

/**
 * Settings page callback
 */
function guides_options_page() {
	?>
	<div class="wrap">
		<h2>Guides Settings</h2>

		<form method="post" action="options.php">
			<?php settings_fields( 'guides_settings' ); ?>
			<?php do_settings_sections( 'guides_page' ); ?>
			<?php submit_button( __( 'Add Country', 'guides' ) ); ?>
		</form>
	</div>
	<?php
}

/**
 * Register settings, section and field
 */
add_action( 'admin_init', function () {
	register_setting( 'guides_settings', 'guides_countries', 'guides_countries_validate' );

	add_settings_section( 'guides_section', '', 'guides_settings_section', 'guides_page' );
	add_settings_field( 'guides_countries', 'Countries', 'guides_countries_field', 'guides_page', 'guides_section' );
} );

/**
 * Validate option
 */
function guides_countries_validate( $input ) {
	$countries = get_option( 'guides_countries' );
	if ( ! empty( $input ) && ! in_array( $input, $countries ) ) {
		$countries[] = $input;
		sort( $countries, SORT_NATURAL | SORT_FLAG_CASE );
	}

	return $countries;
}

/**
 * Settings section callback
 */
function guides_settings_section() {
	echo 'You cannot edit or delete existing countries. It is a security measure to avoid loss of data.<br />';
	echo 'You can however add a new country bellow:';
}

/**
 * Settings field callback
 */
function guides_countries_field() {
	$countries = get_option( 'guides_countries' );

	// Readonly inputs containing the other countries
	foreach ( $countries as $country ) {
		echo "<p><input name='guides_countries' type='text' id='guides_countries' value='$country' readonly='readonly' 
			class='regular-text code'></p>";
	}

	// Input for entering a new country
	echo "<p><input name='guides_countries' type='text' id='guides_countries' placeholder='New Country' 
			class='regular-text code'></p>";
}
