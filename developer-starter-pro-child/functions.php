<?php
/**
 * DentalPro Elite Child functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue parent and child stylesheets.
 */
function developer_starter_pro_child_enqueue_styles() {
	// Enqueue parent theme style.css
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), '1.0.0' );

	// Enqueue child theme style.css
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'developer_starter_pro_child_enqueue_styles' );
