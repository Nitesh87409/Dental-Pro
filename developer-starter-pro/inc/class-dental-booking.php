<?php
/**
 * Appointment Booking Core Logic
 *
 * Handles database table installation, REST API endpoints, time slot calculation,
 * and appointment submission.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Booking {

	/**
	 * Custom DB table name.
	 *
	 * @var string
	 */
	public static $table_name = 'dental_appointments';

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Register REST API routes.
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
	}

	/**
	 * Get absolute table name with prefix.
	 *
	 * @return string Table name.
	 */
	public static function get_table_name() {
		global $wpdb;
		return $wpdb->prefix . self::$table_name;
	}

	/**
	 * Create Custom DB Table on Theme Activation.
	 */
	public static function create_db_table() {
		global $wpdb;
		$table_name = self::get_table_name();
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			patient_name varchar(100) NOT NULL,
			patient_email varchar(100) NOT NULL,
			patient_phone varchar(50) NOT NULL,
			doctor_id bigint(20) NOT NULL,
			service_id bigint(20) NOT NULL,
			booking_date date NOT NULL,
			time_slot varchar(10) NOT NULL,
			status varchar(20) DEFAULT 'pending' NOT NULL,
			notes text DEFAULT '' NOT NULL,
			created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY  (id),
			KEY doctor_date_idx (doctor_id, booking_date)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Register REST API Routes.
	 */
	public function register_rest_routes() {
		register_rest_route(
			'dentalpro/v1',
			'/available-slots',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_available_slots' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			'dentalpro/v1',
			'/book',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'process_booking' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Get Available Time Slots for Doctor & Date.
	 *
	 * Query Parameters:
	 * - doctor_id (int)
	 * - date (YYYY-MM-DD)
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response REST Response.
	 */
	public function get_available_slots( $request ) {
		global $wpdb;

		$doctor_id = absint( $request->get_param( 'doctor_id' ) );
		$date      = sanitize_text_field( $request->get_param( 'date' ) );

		if ( empty( $doctor_id ) || empty( $date ) ) {
			return new WP_REST_Response( array( 'error' => __( 'Missing required parameters.', 'developer-starter-pro' ) ), 400 );
		}

		// Calculate weekday name.
		$timestamp = strtotime( $date );
		if ( ! $timestamp ) {
			return new WP_REST_Response( array( 'error' => __( 'Invalid date format.', 'developer-starter-pro' ) ), 400 );
		}
		$weekday = strtolower( date( 'l', $timestamp ) );

		// Retrieve doctor schedule.
		$prefix = '_developer_starter_pro_';
		$schedule = get_post_meta( $doctor_id, $prefix . 'doctor_schedule', true );

		$is_available = false;
		$start_time   = '09:00';
		$end_time     = '17:00'; // Default end time is 17:00 to match meta boxes

		if ( is_array( $schedule ) && ! empty( $schedule ) ) {
			if ( isset( $schedule[ $weekday ] ) ) {
				$is_available = isset( $schedule[ $weekday ]['available'] ) && '1' === $schedule[ $weekday ]['available'];
				$start_time   = ! empty( $schedule[ $weekday ]['start'] ) ? $schedule[ $weekday ]['start'] : '09:00';
				$end_time     = ! empty( $schedule[ $weekday ]['end'] ) ? $schedule[ $weekday ]['end'] : '17:00';
			}
		} else {
			// Fallback default schedule: Monday-Saturday available, Sunday off
			if ( 'sunday' !== $weekday ) {
				$is_available = true;
			}
		}

		if ( ! $is_available ) {
			return new WP_REST_Response( array(
				'available' => false,
				'slots'     => array(),
				'reason'    => __( 'Doctor is off duty on this day.', 'developer-starter-pro' ),
			), 200 );
		}

		// Generate 30-minute intervals between start_time and end_time.
		$slots = array();
		$start = strtotime( $start_time );
		$end   = strtotime( $end_time );

		// Query existing approved bookings in database.
		$table_name = self::get_table_name();
		$booked_slots = $wpdb->get_col( $wpdb->prepare(
			"SELECT time_slot FROM $table_name WHERE doctor_id = %d AND booking_date = %s AND status != 'cancelled'",
			$doctor_id,
			$date
		) );

		while ( $start < $end ) {
			$slot_str = date( 'H:i', $start );
			$slots[] = array(
				'time'      => $slot_str,
				'formatted' => date( 'g:i A', $start ),
				'available' => ! in_array( $slot_str, $booked_slots, true ),
			);
			$start = strtotime( '+30 minutes', $start );
		}

		return new WP_REST_Response( array(
			'available' => true,
			'slots'     => $slots,
		), 200 );
	}

	/**
	 * Process Frontend Booking Request.
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response REST Response.
	 */
	public function process_booking( $request ) {
		global $wpdb;

		$params = $request->get_json_params();

		$name      = sanitize_text_field( $params['patient_name'] ?? '' );
		$email     = sanitize_email( $params['patient_email'] ?? '' );
		$phone     = sanitize_text_field( $params['patient_phone'] ?? '' );
		$doctor_id = absint( $params['doctor_id'] ?? 0 );
		$service_id = absint( $params['service_id'] ?? 0 );
		$date      = sanitize_text_field( $params['date'] ?? '' );
		$time_slot = sanitize_text_field( $params['time_slot'] ?? '' );
		$notes     = sanitize_textarea_field( $params['notes'] ?? '' );

		// Basic validation.
		if ( empty( $name ) || empty( $email ) || empty( $phone ) || empty( $doctor_id ) || empty( $service_id ) || empty( $date ) || empty( $time_slot ) ) {
			return new WP_REST_Response( array( 'success' => false, 'message' => __( 'Please fill in all required fields.', 'developer-starter-pro' ) ), 400 );
		}

		if ( ! is_email( $email ) ) {
			return new WP_REST_Response( array( 'success' => false, 'message' => __( 'Please enter a valid email address.', 'developer-starter-pro' ) ), 400 );
		}

		// Double check availability to prevent race conditions.
		$table_name = self::get_table_name();
		$exists = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM $table_name WHERE doctor_id = %d AND booking_date = %s AND time_slot = %s AND status != 'cancelled'",
			$doctor_id,
			$date,
			$time_slot
		) );

		if ( $exists > 0 ) {
			return new WP_REST_Response( array( 'success' => false, 'message' => __( 'This slot has already been reserved. Please select another time.', 'developer-starter-pro' ) ), 409 );
		}

		// Check approval mode setting
		$options = developer_starter_pro_get_all_options();
		$mode = isset( $options['appointment_approval_mode'] ) ? $options['appointment_approval_mode'] : 'automatic';
		$initial_status = ( 'automatic' === $mode ) ? 'confirmed' : 'pending';

		// Insert booking.
		$inserted = $wpdb->insert(
			$table_name,
			array(
				'patient_name' => $name,
				'patient_email' => $email,
				'patient_phone' => $phone,
				'doctor_id'    => $doctor_id,
				'service_id'   => $service_id,
				'booking_date' => $date,
				'time_slot'    => $time_slot,
				'status'       => $initial_status,
				'notes'        => $notes,
			),
			array( '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s' )
		);

		if ( ! $inserted ) {
			return new WP_REST_Response( array( 'success' => false, 'message' => __( 'Database insertion error. Please try again.', 'developer-starter-pro' ) ), 500 );
		}

		$booking_id = $wpdb->insert_id;
		$reference_id = 'APT-' . sprintf( '%05d', $booking_id );

		// Trigger notifications hooks
		do_action( 'dentalpro_appointment_booked', $booking_id );

		return new WP_REST_Response( array(
			'success'      => true,
			'booking_id'   => $booking_id,
			'reference_id' => $reference_id,
			'message'      => sprintf( __( 'Your appointment has been successfully scheduled! Your Reference ID is %s.', 'developer-starter-pro' ), $reference_id ),
		), 200 );
	}
}
