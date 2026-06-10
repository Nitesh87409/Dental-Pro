<?php
/**
 * Helper Functions
 *
 * Utility functions used throughout the DentalPro Elite theme.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a theme option value.
 *
 * @param string $key     The option key.
 * @param mixed  $default Default value if option not found.
 * @return mixed The option value.
 */
function developer_starter_pro_get_option( $key, $default = '' ) {
	$options = get_option( 'developer_starter_pro_options', array() );

	if ( isset( $options[ $key ] ) && '' !== $options[ $key ] ) {
		return $options[ $key ];
	}

	return $default;
}

/**
 * Get all theme options.
 *
 * @return array All theme options.
 */
function developer_starter_pro_get_all_options() {
	$defaults = developer_starter_pro_get_default_options();
	$options  = get_option( 'developer_starter_pro_options', array() );

	return wp_parse_args( $options, $defaults );
}

/**
 * Get default theme options.
 *
 * @return array Default options.
 */
function developer_starter_pro_get_default_options() {
	return array(
		// General.
		'clinic_name'      => 'DentalPro Elite',
		'clinic_phone'     => '+1 (555) 123-4567',
		'clinic_email'     => 'info@developer-starter-pro.developer-starter-pro',
		'clinic_address'   => '123 Dental Street, Medical District, City',
		'clinic_logo'      => '',

		// Colors.
		'color_primary'    => '#0D9488',
		'color_secondary'  => '#1E293B',
		'color_accent'     => '#F59E0B',

		// Header.
		'header_style'     => '1',
		'header_sticky'    => '1',

		// Footer.
		'footer_style'     => '1',

		// Social Media.
		'social_facebook'  => '',
		'social_instagram' => '',
		'social_twitter'   => '',
		'social_youtube'   => '',
		'social_linkedin'  => '',

		// Contact.
		'google_maps_key'   => '',
		'emergency_phone'   => '',
		'whatsapp_enabled'  => '0',
		'whatsapp_number'   => '',
		'whatsapp_message'  => 'Hello! I would like to book an appointment.',
		'whatsapp_position' => 'right',
		'working_hours'     => array(
			'monday'    => array( 'open' => '09:00', 'close' => '18:00', 'closed' => false ),
			'tuesday'   => array( 'open' => '09:00', 'close' => '18:00', 'closed' => false ),
			'wednesday' => array( 'open' => '09:00', 'close' => '18:00', 'closed' => false ),
			'thursday'  => array( 'open' => '09:00', 'close' => '18:00', 'closed' => false ),
			'friday'    => array( 'open' => '09:00', 'close' => '17:00', 'closed' => false ),
			'saturday'  => array( 'open' => '10:00', 'close' => '14:00', 'closed' => false ),
			'sunday'    => array( 'open' => '',      'close' => '',      'closed' => true ),
		),
	);
}

/**
 * Sanitize hex color.
 *
 * @param string $color Hex color value.
 * @return string Sanitized hex color.
 */
function developer_starter_pro_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return '';
}

/**
 * Get social media icons SVG.
 *
 * @param string $platform Social media platform name.
 * @return string SVG markup.
 */
function developer_starter_pro_get_social_icon( $platform ) {
	$icons = array(
		'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
		'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
		'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
		'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
		'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
	);

	return isset( $icons[ $platform ] ) ? $icons[ $platform ] : '';
}

/**
 * Get formatted working hours.
 *
 * @return array Working hours.
 */
function developer_starter_pro_get_working_hours() {
	$hours = developer_starter_pro_get_option( 'working_hours', array() );
	$defaults = developer_starter_pro_get_default_options();

	if ( empty( $hours ) ) {
		return $defaults['working_hours'];
	}

	return $hours;
}

/**
 * Check if today is a working day.
 *
 * @return bool True if the clinic is open today.
 */
function developer_starter_pro_is_open_today() {
	$hours     = developer_starter_pro_get_working_hours();
	$today     = strtolower( current_time( 'l' ) );

	if ( isset( $hours[ $today ] ) && ! $hours[ $today ]['closed'] ) {
		return true;
	}

	return false;
}

/**
 * Get today's working hours as a formatted string.
 *
 * @return string Formatted hours or 'Closed'.
 */
function developer_starter_pro_get_today_hours() {
	$hours = developer_starter_pro_get_working_hours();
	$today = strtolower( current_time( 'l' ) );

	if ( isset( $hours[ $today ] ) && ! $hours[ $today ]['closed'] ) {
		return esc_html( $hours[ $today ]['open'] . ' - ' . $hours[ $today ]['close'] );
	}

	return esc_html__( 'Closed', 'developer-starter-pro' );
}

/**
 * Get star rating HTML.
 *
 * @param int $rating Rating value (1-5).
 * @return string HTML for star rating.
 */
function developer_starter_pro_get_star_rating( $rating = 5 ) {
	$rating = intval( $rating );
	$rating = max( 1, min( 5, $rating ) );
	$output = '<div class="developer-starter-pro-star-rating" aria-label="' . sprintf( esc_attr__( '%d out of 5 stars', 'developer-starter-pro' ), $rating ) . '">';

	for ( $i = 1; $i <= 5; $i++ ) {
		if ( $i <= $rating ) {
			$output .= '<span class="star filled">★</span>';
		} else {
			$output .= '<span class="star empty">☆</span>';
		}
	}

	$output .= '</div>';

	return $output;
}

/**
 * Truncate text to a specific number of words.
 *
 * @param string $text      The text to truncate.
 * @param int    $num_words Number of words.
 * @param string $more      The "read more" text.
 * @return string Truncated text.
 */
function developer_starter_pro_truncate_text( $text, $num_words = 20, $more = '...' ) {
	return wp_trim_words( $text, $num_words, $more );
}

/**
 * Get dynamic booking page URL.
 *
 * @return string Booking page URL.
 */
function developer_starter_pro_get_booking_url() {
	$pages = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => 'page-templates/template-booking.php',
		'number'     => 1,
	) );

	if ( ! empty( $pages ) ) {
		return get_permalink( $pages[0]->ID );
	}

	return home_url( '/booking/' );
}

