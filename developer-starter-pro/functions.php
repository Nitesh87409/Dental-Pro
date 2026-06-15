<?php
/**
 * DentalPro Elite Theme Functions
 *
 * Main functions file that bootstraps the entire theme.
 * All functionality is organized into separate class files in the inc/ directory.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Constants
 */
define( 'developer_starter_pro_VERSION', '1.0.6' );
define( 'developer_starter_pro_DIR', get_template_directory() );
define( 'developer_starter_pro_URI', get_template_directory_uri() );
define( 'developer_starter_pro_INC', developer_starter_pro_DIR . '/inc' );
define( 'developer_starter_pro_ASSETS', developer_starter_pro_URI . '/assets' );
define( 'developer_starter_pro_CSS', developer_starter_pro_ASSETS . '/css' );
define( 'developer_starter_pro_JS', developer_starter_pro_ASSETS . '/js' );
define( 'developer_starter_pro_IMAGES', developer_starter_pro_ASSETS . '/images' );
define( 'developer_starter_pro_TEXT_DOMAIN', 'developer-starter-pro' );

/**
 * Load required theme files.
 */
require_once developer_starter_pro_INC . '/helpers.php';
require_once developer_starter_pro_INC . '/class-dental-setup.php';
require_once developer_starter_pro_INC . '/class-dental-enqueue.php';
require_once developer_starter_pro_INC . '/class-dental-cpt.php';
require_once developer_starter_pro_INC . '/class-dental-taxonomies.php';
require_once developer_starter_pro_INC . '/class-dental-meta-boxes.php';
require_once developer_starter_pro_INC . '/class-dental-admin.php';
require_once developer_starter_pro_INC . '/class-dental-hero-slider.php';
require_once developer_starter_pro_INC . '/class-dental-booking.php';
require_once developer_starter_pro_INC . '/class-dental-admin-booking.php';
require_once developer_starter_pro_INC . '/class-dental-chatbot.php';
require_once developer_starter_pro_INC . '/class-dental-portal.php';
require_once developer_starter_pro_INC . '/class-dental-calculator.php';
require_once developer_starter_pro_INC . '/class-dental-notifications.php';
require_once developer_starter_pro_INC . '/class-dental-seo.php';

/**
 * Initialize theme classes.
 */
function developer_starter_pro_init_theme() {
	new Developer_Starter_Pro_Setup();
	new Developer_Starter_Pro_Enqueue();
	new Developer_Starter_Pro_CPT();
	new Developer_Starter_Pro_Taxonomies();
	new Developer_Starter_Pro_Meta_Boxes();
	new Developer_Starter_Pro_Admin();
	new Developer_Starter_Pro_Hero_Slider();
	new Developer_Starter_Pro_Booking();
	new Developer_Starter_Pro_Admin_Booking();
	new Developer_Starter_Pro_Chatbot();
	new Developer_Starter_Pro_Portal();
	new Developer_Starter_Pro_Calculator();
	new Developer_Starter_Pro_Notifications();
	new Developer_Starter_Pro_SEO();
}
add_action( 'after_setup_theme', 'developer_starter_pro_init_theme', 5 );

/**
 * Theme activation hook — flush rewrite rules for CPTs and schedule cron task.
 */
function developer_starter_pro_activation() {
	// Register CPTs first.
	$cpt = new Developer_Starter_Pro_CPT();
	$cpt->register_doctors();
	$cpt->register_services();
	$cpt->register_testimonials();
	$cpt->register_appointments();

	// Register taxonomies.
	$tax = new Developer_Starter_Pro_Taxonomies();
	$tax->register_department();
	$tax->register_treatment_type();

	// Create custom DB table for scheduling
	Developer_Starter_Pro_Booking::create_db_table();

	// Schedule automated daily appointment reminder cron
	if ( ! wp_next_scheduled( 'dentalpro_daily_reminder_cron' ) ) {
		wp_schedule_event( time(), 'daily', 'dentalpro_daily_reminder_cron' );
	}

	// Flush rewrite rules.
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'developer_starter_pro_activation' );

/**
 * Theme deactivation hook — clear cron schedules.
 */
function developer_starter_pro_deactivation() {
	// Clear cron
	wp_clear_scheduled_hook( 'dentalpro_daily_reminder_cron' );
	flush_rewrite_rules();
}
add_action( 'switch_theme', 'developer_starter_pro_deactivation' );

/**
 * Auto-create required pages with their templates.
 */
function developer_starter_pro_create_pages() {
	$pages_to_create = array(
		'pricing' => array(
			'title'    => 'Pricing Packages',
			'template' => 'page-templates/template-pricing.php',
		),
		'patient-login' => array(
			'title'    => 'Patient Login',
			'template' => 'page-templates/template-patient-login.php',
		),
		'patient-register' => array(
			'title'    => 'Patient Register',
			'template' => 'page-templates/template-patient-register.php',
		),
		'patient-dashboard' => array(
			'title'    => 'Patient Dashboard',
			'template' => 'page-templates/template-patient-dashboard.php',
		),
		'about' => array(
			'title'    => 'About Us',
			'template' => 'page-templates/template-about.php',
		),
		'contact' => array(
			'title'    => 'Contact Us',
			'template' => 'page-templates/template-contact.php',
		),
		'faq' => array(
			'title'    => 'FAQs',
			'template' => 'page-templates/template-faq.php',
		),
		'gallery' => array(
			'title'    => 'Gallery',
			'template' => 'page-templates/template-gallery.php',
		),
		'services' => array(
			'title'    => 'Services Directory',
			'template' => 'page-templates/template-services.php',
		),
		'doctors' => array(
			'title'    => 'Doctors Directory',
			'template' => 'page-templates/template-doctors.php',
		),
		'video-consult' => array(
			'title'    => 'Video Consultation',
			'template' => 'page-templates/template-video-consult.php',
		),
		'emergency' => array(
			'title'    => 'Emergency Care',
			'template' => 'page-templates/template-emergency.php',
		),
		'blog' => array(
			'title'    => 'Blog Catalog',
			'template' => 'page-templates/template-blog.php',
		),
		'insurance' => array(
			'title'    => 'Insurance Details',
			'template' => 'page-templates/template-insurance.php',
		),
		'coming-soon' => array(
			'title'    => 'Coming Soon',
			'template' => 'page-templates/template-coming-soon.php',
		),
		'careers' => array(
			'title'    => 'Careers Directory',
			'template' => 'page-templates/template-careers.php',
		),
		'sitemap' => array(
			'title'    => 'Sitemap',
			'template' => 'page-templates/template-sitemap.php',
		),
	);

	foreach ( $pages_to_create as $slug => $page_data ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			$post_id = wp_insert_post( array(
				'post_title'   => $page_data['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
			) );

			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_wp_page_template', $page_data['template'] );
				// If pricing page, insert calculator shortcode as post content to support testing both template pricing list and calculator shortcode!
				if ( 'pricing' === $slug ) {
					wp_update_post( array(
						'ID'           => $post_id,
						'post_content' => '[dental_calculator]',
					) );
				}
			}
		}
	}
}
add_action( 'init', 'developer_starter_pro_create_pages' );

/**
 * Save rating comment meta for Doctor reviews.
 */
function developer_starter_pro_save_comment_rating( $comment_id ) {
	if ( isset( $_POST['rating'] ) ) {
		$rating = absint( $_POST['rating'] );
		update_comment_meta( $comment_id, 'rating', $rating );
	}
}
add_action( 'comment_post', 'developer_starter_pro_save_comment_rating' );




