<?php
/**
 * DentalPro Elite Child Theme Functions
 *
 * This child theme safely inherits all functionality from the DentalPro Elite
 * parent theme. Add your custom functions and overrides here.
 *
 * @package developer-starter-pro-child
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue parent and child theme stylesheets.
 * Parent stylesheet is loaded first, child stylesheet overrides it.
 */
function dental_child_enqueue_styles() {
	// Enqueue parent theme stylesheet.
	wp_enqueue_style(
		'developer-starter-pro-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'developer-starter-pro' )->get( 'Version' )
	);

	// Enqueue child theme stylesheet.
	wp_enqueue_style(
		'developer-starter-pro-child',
		get_stylesheet_uri(),
		array( 'developer-starter-pro-parent' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'dental_child_enqueue_styles' );

/**
 * Add your custom functions below this line.
 *
 * Example: Override a parent theme function
 *
 * if ( ! function_exists( 'your_custom_function' ) ) {
 *     function your_custom_function() {
 *         // Your custom code here
 *     }
 * }
 */
