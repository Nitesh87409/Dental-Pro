<?php
/**
 * Custom Post Types
 *
 * Registers all Custom Post Types for the DentalPro Elite theme:
 * Doctors, Services, Testimonials, Appointments.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_CPT {

	/**
	 * Constructor — hook into WordPress.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_doctors' ) );
		add_action( 'init', array( $this, 'register_services' ) );
		add_action( 'init', array( $this, 'register_testimonials' ) );
		add_action( 'init', array( $this, 'register_appointments' ) );

		// Custom admin columns.
		add_filter( 'manage_doctors_posts_columns', array( $this, 'doctors_columns' ) );
		add_action( 'manage_doctors_posts_custom_column', array( $this, 'doctors_column_data' ), 10, 2 );

		add_filter( 'manage_services_posts_columns', array( $this, 'services_columns' ) );
		add_action( 'manage_services_posts_custom_column', array( $this, 'services_column_data' ), 10, 2 );

		add_filter( 'manage_testimonials_posts_columns', array( $this, 'testimonials_columns' ) );
		add_action( 'manage_testimonials_posts_custom_column', array( $this, 'testimonials_column_data' ), 10, 2 );

		add_filter( 'manage_appointments_posts_columns', array( $this, 'appointments_columns' ) );
		add_action( 'manage_appointments_posts_custom_column', array( $this, 'appointments_column_data' ), 10, 2 );
	}

	/**
	 * Register Doctors CPT.
	 */
	public function register_doctors() {
		$labels = array(
			'name'                  => _x( 'Doctors', 'Post Type General Name', 'developer-starter-pro' ),
			'singular_name'         => _x( 'Doctor', 'Post Type Singular Name', 'developer-starter-pro' ),
			'menu_name'             => esc_html__( 'Doctors', 'developer-starter-pro' ),
			'name_admin_bar'        => esc_html__( 'Doctor', 'developer-starter-pro' ),
			'archives'              => esc_html__( 'Doctor Archives', 'developer-starter-pro' ),
			'attributes'            => esc_html__( 'Doctor Attributes', 'developer-starter-pro' ),
			'parent_item_colon'     => esc_html__( 'Parent Doctor:', 'developer-starter-pro' ),
			'all_items'             => esc_html__( 'All Doctors', 'developer-starter-pro' ),
			'add_new_item'          => esc_html__( 'Add New Doctor', 'developer-starter-pro' ),
			'add_new'               => esc_html__( 'Add New', 'developer-starter-pro' ),
			'new_item'              => esc_html__( 'New Doctor', 'developer-starter-pro' ),
			'edit_item'             => esc_html__( 'Edit Doctor', 'developer-starter-pro' ),
			'update_item'           => esc_html__( 'Update Doctor', 'developer-starter-pro' ),
			'view_item'             => esc_html__( 'View Doctor', 'developer-starter-pro' ),
			'view_items'            => esc_html__( 'View Doctors', 'developer-starter-pro' ),
			'search_items'          => esc_html__( 'Search Doctor', 'developer-starter-pro' ),
			'not_found'             => esc_html__( 'No doctors found', 'developer-starter-pro' ),
			'not_found_in_trash'    => esc_html__( 'No doctors found in Trash', 'developer-starter-pro' ),
			'featured_image'        => esc_html__( 'Doctor Photo', 'developer-starter-pro' ),
			'set_featured_image'    => esc_html__( 'Set doctor photo', 'developer-starter-pro' ),
			'remove_featured_image' => esc_html__( 'Remove doctor photo', 'developer-starter-pro' ),
			'use_featured_image'    => esc_html__( 'Use as doctor photo', 'developer-starter-pro' ),
		);

		$args = array(
			'label'               => esc_html__( 'Doctor', 'developer-starter-pro' ),
			'description'         => esc_html__( 'Dental clinic doctors and specialists', 'developer-starter-pro' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
			'taxonomies'          => array( 'department' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-businessman',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rewrite'             => array(
				'slug'       => 'doctors',
				'with_front' => false,
			),
		);

		register_post_type( 'doctors', $args );
	}

	/**
	 * Register Services CPT.
	 */
	public function register_services() {
		$labels = array(
			'name'                  => _x( 'Services', 'Post Type General Name', 'developer-starter-pro' ),
			'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'developer-starter-pro' ),
			'menu_name'             => esc_html__( 'Services', 'developer-starter-pro' ),
			'name_admin_bar'        => esc_html__( 'Service', 'developer-starter-pro' ),
			'archives'              => esc_html__( 'Service Archives', 'developer-starter-pro' ),
			'all_items'             => esc_html__( 'All Services', 'developer-starter-pro' ),
			'add_new_item'          => esc_html__( 'Add New Service', 'developer-starter-pro' ),
			'add_new'               => esc_html__( 'Add New', 'developer-starter-pro' ),
			'new_item'              => esc_html__( 'New Service', 'developer-starter-pro' ),
			'edit_item'             => esc_html__( 'Edit Service', 'developer-starter-pro' ),
			'update_item'           => esc_html__( 'Update Service', 'developer-starter-pro' ),
			'view_item'             => esc_html__( 'View Service', 'developer-starter-pro' ),
			'view_items'            => esc_html__( 'View Services', 'developer-starter-pro' ),
			'search_items'          => esc_html__( 'Search Service', 'developer-starter-pro' ),
			'not_found'             => esc_html__( 'No services found', 'developer-starter-pro' ),
			'not_found_in_trash'    => esc_html__( 'No services found in Trash', 'developer-starter-pro' ),
			'featured_image'        => esc_html__( 'Service Image', 'developer-starter-pro' ),
			'set_featured_image'    => esc_html__( 'Set service image', 'developer-starter-pro' ),
			'remove_featured_image' => esc_html__( 'Remove service image', 'developer-starter-pro' ),
			'use_featured_image'    => esc_html__( 'Use as service image', 'developer-starter-pro' ),
		);

		$args = array(
			'label'               => esc_html__( 'Service', 'developer-starter-pro' ),
			'description'         => esc_html__( 'Dental services and treatments', 'developer-starter-pro' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
			'taxonomies'          => array( 'treatment_type' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-heart',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rewrite'             => array(
				'slug'       => 'services',
				'with_front' => false,
			),
		);

		register_post_type( 'services', $args );
	}

	/**
	 * Register Testimonials CPT.
	 */
	public function register_testimonials() {
		$labels = array(
			'name'               => _x( 'Testimonials', 'Post Type General Name', 'developer-starter-pro' ),
			'singular_name'      => _x( 'Testimonial', 'Post Type Singular Name', 'developer-starter-pro' ),
			'menu_name'          => esc_html__( 'Testimonials', 'developer-starter-pro' ),
			'all_items'          => esc_html__( 'All Testimonials', 'developer-starter-pro' ),
			'add_new_item'       => esc_html__( 'Add New Testimonial', 'developer-starter-pro' ),
			'add_new'            => esc_html__( 'Add New', 'developer-starter-pro' ),
			'edit_item'          => esc_html__( 'Edit Testimonial', 'developer-starter-pro' ),
			'view_item'          => esc_html__( 'View Testimonial', 'developer-starter-pro' ),
			'search_items'       => esc_html__( 'Search Testimonials', 'developer-starter-pro' ),
			'not_found'          => esc_html__( 'No testimonials found', 'developer-starter-pro' ),
			'not_found_in_trash' => esc_html__( 'No testimonials found in Trash', 'developer-starter-pro' ),
		);

		$args = array(
			'label'               => esc_html__( 'Testimonial', 'developer-starter-pro' ),
			'description'         => esc_html__( 'Patient testimonials and reviews', 'developer-starter-pro' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 22,
			'menu_icon'           => 'dashicons-format-quote',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rewrite'             => array(
				'slug'       => 'testimonials',
				'with_front' => false,
			),
		);

		register_post_type( 'testimonials', $args );
	}

	/**
	 * Register Appointments CPT.
	 */
	public function register_appointments() {
		$labels = array(
			'name'               => _x( 'Appointments', 'Post Type General Name', 'developer-starter-pro' ),
			'singular_name'      => _x( 'Appointment', 'Post Type Singular Name', 'developer-starter-pro' ),
			'menu_name'          => esc_html__( 'Appointments', 'developer-starter-pro' ),
			'all_items'          => esc_html__( 'All Appointments', 'developer-starter-pro' ),
			'add_new_item'       => esc_html__( 'Add New Appointment', 'developer-starter-pro' ),
			'add_new'            => esc_html__( 'Add New', 'developer-starter-pro' ),
			'edit_item'          => esc_html__( 'Edit Appointment', 'developer-starter-pro' ),
			'view_item'          => esc_html__( 'View Appointment', 'developer-starter-pro' ),
			'search_items'       => esc_html__( 'Search Appointments', 'developer-starter-pro' ),
			'not_found'          => esc_html__( 'No appointments found', 'developer-starter-pro' ),
			'not_found_in_trash' => esc_html__( 'No appointments found in Trash', 'developer-starter-pro' ),
		);

		$args = array(
			'label'               => esc_html__( 'Appointment', 'developer-starter-pro' ),
			'description'         => esc_html__( 'Patient appointment bookings', 'developer-starter-pro' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 23,
			'menu_icon'           => 'dashicons-calendar-alt',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rewrite'             => false,
		);

		register_post_type( 'appointments', $args );
	}

	/**
	 * Custom columns for Doctors.
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public function doctors_columns( $columns ) {
		$new_columns = array(
			'cb'                    => $columns['cb'],
			'title'                 => esc_html__( 'Doctor Name', 'developer-starter-pro' ),
			'doctor_photo'          => esc_html__( 'Photo', 'developer-starter-pro' ),
			'doctor_speciality'     => esc_html__( 'Speciality', 'developer-starter-pro' ),
			'doctor_experience'     => esc_html__( 'Experience', 'developer-starter-pro' ),
			'taxonomy-department'   => esc_html__( 'Department', 'developer-starter-pro' ),
			'date'                  => $columns['date'],
		);

		return $new_columns;
	}

	/**
	 * Populate custom columns for Doctors.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public function doctors_column_data( $column, $post_id ) {
		switch ( $column ) {
			case 'doctor_photo':
				if ( has_post_thumbnail( $post_id ) ) {
					echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
				} else {
					echo '—';
				}
				break;

			case 'doctor_speciality':
				$speciality = get_post_meta( $post_id, '_developer_starter_pro_doctor_speciality', true );
				echo esc_html( $speciality ? $speciality : '—' );
				break;

			case 'doctor_experience':
				$experience = get_post_meta( $post_id, '_developer_starter_pro_doctor_experience', true );
				echo esc_html( $experience ? $experience . ' ' . __( 'Years', 'developer-starter-pro' ) : '—' );
				break;
		}
	}

	/**
	 * Custom columns for Services.
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public function services_columns( $columns ) {
		$new_columns = array(
			'cb'                       => $columns['cb'],
			'title'                    => esc_html__( 'Service Name', 'developer-starter-pro' ),
			'service_price'            => esc_html__( 'Price', 'developer-starter-pro' ),
			'service_duration'         => esc_html__( 'Duration', 'developer-starter-pro' ),
			'taxonomy-treatment_type'  => esc_html__( 'Treatment Type', 'developer-starter-pro' ),
			'date'                     => $columns['date'],
		);

		return $new_columns;
	}

	/**
	 * Populate custom columns for Services.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public function services_column_data( $column, $post_id ) {
		switch ( $column ) {
			case 'service_price':
				$price = get_post_meta( $post_id, '_developer_starter_pro_service_price', true );
				echo esc_html( $price ? '$' . number_format( (float) $price, 2 ) : '—' );
				break;

			case 'service_duration':
				$duration = get_post_meta( $post_id, '_developer_starter_pro_service_duration', true );
				echo esc_html( $duration ? $duration . ' ' . __( 'min', 'developer-starter-pro' ) : '—' );
				break;
		}
	}

	/**
	 * Custom columns for Testimonials.
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public function testimonials_columns( $columns ) {
		$new_columns = array(
			'cb'                    => $columns['cb'],
			'title'                 => esc_html__( 'Title', 'developer-starter-pro' ),
			'patient_name'          => esc_html__( 'Patient', 'developer-starter-pro' ),
			'testimonial_rating'    => esc_html__( 'Rating', 'developer-starter-pro' ),
			'testimonial_treatment' => esc_html__( 'Treatment', 'developer-starter-pro' ),
			'date'                  => $columns['date'],
		);

		return $new_columns;
	}

	/**
	 * Populate custom columns for Testimonials.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public function testimonials_column_data( $column, $post_id ) {
		switch ( $column ) {
			case 'patient_name':
				$name = get_post_meta( $post_id, '_developer_starter_pro_testimonial_patient_name', true );
				echo esc_html( $name ? $name : '—' );
				break;

			case 'testimonial_rating':
				$rating = get_post_meta( $post_id, '_developer_starter_pro_testimonial_rating', true );
				if ( $rating ) {
					echo esc_html( str_repeat( '★', intval( $rating ) ) . str_repeat( '☆', 5 - intval( $rating ) ) );
				} else {
					echo '—';
				}
				break;

			case 'testimonial_treatment':
				$treatment = get_post_meta( $post_id, '_developer_starter_pro_testimonial_treatment', true );
				echo esc_html( $treatment ? $treatment : '—' );
				break;
		}
	}

	/**
	 * Custom columns for Appointments.
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public function appointments_columns( $columns ) {
		$new_columns = array(
			'cb'                  => $columns['cb'],
			'title'               => esc_html__( 'Appointment', 'developer-starter-pro' ),
			'patient_name'        => esc_html__( 'Patient', 'developer-starter-pro' ),
			'patient_email'       => esc_html__( 'Email', 'developer-starter-pro' ),
			'appointment_doctor'  => esc_html__( 'Doctor', 'developer-starter-pro' ),
			'appointment_date'    => esc_html__( 'Date & Time', 'developer-starter-pro' ),
			'appointment_status'  => esc_html__( 'Status', 'developer-starter-pro' ),
		);

		return $new_columns;
	}

	/**
	 * Populate custom columns for Appointments.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public function appointments_column_data( $column, $post_id ) {
		switch ( $column ) {
			case 'patient_name':
				$name = get_post_meta( $post_id, '_developer_starter_pro_appointment_patient_name', true );
				echo esc_html( $name ? $name : '—' );
				break;

			case 'patient_email':
				$email = get_post_meta( $post_id, '_developer_starter_pro_appointment_patient_email', true );
				echo esc_html( $email ? $email : '—' );
				break;

			case 'appointment_doctor':
				$doctor_id = get_post_meta( $post_id, '_developer_starter_pro_appointment_doctor_id', true );
				if ( $doctor_id ) {
					echo esc_html( get_the_title( $doctor_id ) );
				} else {
					echo '—';
				}
				break;

			case 'appointment_date':
				$date = get_post_meta( $post_id, '_developer_starter_pro_appointment_date', true );
				$time = get_post_meta( $post_id, '_developer_starter_pro_appointment_time', true );
				if ( $date && $time ) {
					echo esc_html( date_i18n( 'M d, Y', strtotime( $date ) ) . ' @ ' . $time );
				} else {
					echo '—';
				}
				break;

			case 'appointment_status':
				$status = get_post_meta( $post_id, '_developer_starter_pro_appointment_status', true );
				$status = $status ? $status : 'pending';
				$status_labels = array(
					'pending'   => esc_html__( 'Pending', 'developer-starter-pro' ),
					'confirmed' => esc_html__( 'Confirmed', 'developer-starter-pro' ),
					'cancelled' => esc_html__( 'Cancelled', 'developer-starter-pro' ),
					'completed' => esc_html__( 'Completed', 'developer-starter-pro' ),
				);
				$label = isset( $status_labels[ $status ] ) ? $status_labels[ $status ] : $status;
				echo '<span class="developer-starter-pro-status developer-starter-pro-status--' . esc_attr( $status ) . '">' . esc_html( $label ) . '</span>';
				break;
		}
	}
}
