<?php
/**
 * Patient Portal Module
 *
 * Registers custom patient roles, handles patient account creation, login routing,
 * and profile meta updates.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Portal {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Register patient role on theme setup
		add_action( 'init', array( $this, 'register_patient_role' ) );

		// Process registration post
		add_action( 'admin_post_nopriv_dentalpro_patient_register', array( $this, 'handle_registration' ) );
		add_action( 'admin_post_dentalpro_patient_register', array( $this, 'handle_registration' ) );

		// Process login post
		add_action( 'admin_post_nopriv_dentalpro_patient_login', array( $this, 'handle_login' ) );
		add_action( 'admin_post_dentalpro_patient_login', array( $this, 'handle_login' ) );

		// Process profile and medical updates
		add_action( 'admin_post_dentalpro_patient_update_profile', array( $this, 'handle_profile_update' ) );
	}

	/**
	 * Register Patient Role.
	 */
	public function register_patient_role() {
		if ( ! get_role( 'dental_patient' ) ) {
			add_role(
				'dental_patient',
				esc_html__( 'Dental Patient', 'developer-starter-pro' ),
				array(
					'read'         => true,
					'edit_posts'   => false,
					'delete_posts' => false,
				)
			);
		}
	}

	/**
	 * Helper: Get Portal Dashboard Page URL.
	 */
	public static function get_dashboard_url() {
		$pages = get_pages( array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-templates/template-patient-dashboard.php'
		) );
		return ! empty( $pages ) ? get_permalink( $pages[0]->ID ) : home_url( '/patient-dashboard/' );
	}

	/**
	 * Helper: Get Portal Login Page URL.
	 */
	public static function get_login_url() {
		$pages = get_pages( array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-templates/template-patient-login.php'
		) );
		return ! empty( $pages ) ? get_permalink( $pages[0]->ID ) : wp_login_url();
	}

	/**
	 * Handle Registration Form POST.
	 */
	public function handle_registration() {
		check_admin_referer( 'dentalpro_register_action', 'register_nonce' );

		$name     = sanitize_text_field( $_POST['patient_name'] ?? '' );
		$email    = sanitize_email( $_POST['patient_email'] ?? '' );
		$password = $_POST['patient_password'] ?? '';
		$phone    = sanitize_text_field( $_POST['patient_phone'] ?? '' );
		$dob      = sanitize_text_field( $_POST['patient_dob'] ?? '' );

		$reg_url = wp_get_referer();

		// Validation
		if ( empty( $name ) || empty( $email ) || empty( $password ) || empty( $phone ) ) {
			wp_safe_redirect( add_query_arg( 'err', 'missing_fields', $reg_url ) );
			exit;
		}

		if ( ! is_email( $email ) ) {
			wp_safe_redirect( add_query_arg( 'err', 'invalid_email', $reg_url ) );
			exit;
		}

		if ( email_exists( $email ) ) {
			wp_safe_redirect( add_query_arg( 'err', 'email_exists', $reg_url ) );
			exit;
		}

		// Insert User
		$username = explode( '@', $email )[0];
		// Enforce unique username
		$original_username = $username;
		$count = 1;
		while ( username_exists( $username ) ) {
			$username = $original_username . $count;
			$count++;
		}

		$user_id = wp_insert_user( array(
			'user_login' => $username,
			'user_email' => $email,
			'user_pass'  => $password,
			'display_name'=> $name,
			'role'       => 'dental_patient',
		) );

		if ( is_wp_error( $user_id ) ) {
			wp_safe_redirect( add_query_arg( 'err', 'registration_failed', $reg_url ) );
			exit;
		}

		// Save User Metadata
		update_user_meta( $user_id, 'patient_phone', $phone );
		update_user_meta( $user_id, 'patient_dob', $dob );

		// Sign user in automatically
		wp_clear_auth_cookie();
		wp_set_current_user( $user_id );
		wp_set_auth_cookie( $user_id );

		// Redirect to dashboard
		wp_safe_redirect( self::get_dashboard_url() );
		exit;
	}

	/**
	 * Handle Login Form POST.
	 */
	public function handle_login() {
		check_admin_referer( 'dentalpro_login_action', 'login_nonce' );

		$email    = sanitize_email( $_POST['patient_email'] ?? '' );
		$password = $_POST['patient_password'] ?? '';
		$remember = isset( $_POST['patient_remember'] );

		$login_url = wp_get_referer();

		if ( empty( $email ) || empty( $password ) ) {
			wp_safe_redirect( add_query_arg( 'err', 'missing_fields', $login_url ) );
			exit;
		}

		$user = get_user_by( 'email', $email );
		if ( ! $user ) {
			wp_safe_redirect( add_query_arg( 'err', 'invalid_credentials', $login_url ) );
			exit;
		}

		// Verify Sign-on credentials
		$creds = array(
			'user_login'    => $user->user_login,
			'user_password' => $password,
			'remember'      => $remember,
		);

		$secure_cookie = is_ssl();
		$login_user = wp_signon( $creds, $secure_cookie );

		if ( is_wp_error( $login_user ) ) {
			wp_safe_redirect( add_query_arg( 'err', 'invalid_credentials', $login_url ) );
			exit;
		}

		wp_safe_redirect( self::get_dashboard_url() );
		exit;
	}

	/**
	 * Handle profile updates and medical histories.
	 */
	public function handle_profile_update() {
		check_admin_referer( 'dentalpro_update_profile_action', 'profile_nonce' );

		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			wp_die( esc_html__( 'Unauthorized access.', 'developer-starter-pro' ) );
		}

		$phone       = sanitize_text_field( $_POST['patient_phone'] ?? '' );
		$allergies   = sanitize_textarea_field( $_POST['medical_allergies'] ?? '' );
		$medications = sanitize_textarea_field( $_POST['medical_medications'] ?? '' );
		$conditions  = sanitize_textarea_field( $_POST['medical_conditions'] ?? '' );

		update_user_meta( $user_id, 'patient_phone', $phone );
		update_user_meta( $user_id, 'medical_allergies', $allergies );
		update_user_meta( $user_id, 'medical_medications', $medications );
		update_user_meta( $user_id, 'medical_conditions', $conditions );

		wp_safe_redirect( add_query_arg( 'updated', 'true', wp_get_referer() ) );
		exit;
	}
}
