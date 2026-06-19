<?php
/**
 * SEO Schema Structured Data JSON-LD Module
 *
 * Automatically generates and injects search-engine compliant Schema.org JSON-LD scripts
 * into the header (wp_head) for Homepage Dentist, Person, Service, FAQ, and Breadcrumbs hierarchies.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_SEO {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'output_json_ld_schema' ), 20 );
	}

	/**
	 * Core dispatcher hook to render JSON-LD block inside head tags.
	 */
	public function output_json_ld_schema() {
		$schemas = array();

		// 1. Dentist/MedicalBusiness Schema (Front page / Homepage)
		if ( is_front_page() || is_home() ) {
			$schemas[] = $this->get_dentist_schema();
		}

		// 2. Doctor Person Schema (Doctor profile page)
		if ( is_singular( 'doctors' ) ) {
			$schemas[] = $this->get_doctor_schema();
		}

		// 3. Service Schema (Service page)
		if ( is_singular( 'services' ) ) {
			$schemas[] = $this->get_service_schema();
		}

		// 4. FAQPage Schema (FAQ page template)
		if ( is_page_template( 'page-templates/template-faq.php' ) ) {
			$schemas[] = $this->get_faq_schema();
		}

		// 5. BreadcrumbList Schema (Inner pages)
		if ( ! is_front_page() && ! is_home() ) {
			$schemas[] = $this->get_breadcrumbs_schema();
		}

		// Clean null arrays
		$schemas = array_filter( $schemas );

		if ( empty( $schemas ) ) {
			return;
		}

		foreach ( $schemas as $schema ) {
			echo "\n<!-- DentalPro Elite Structured Data JSON-LD -->\n";
			echo "<script type='application/ld+json'>\n";
			echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
			echo "\n</script>\n";
		}
	}

	/**
	 * Construct Dentist / MedicalBusiness Schema.
	 *
	 * @return array Schema structure.
	 */
	private function get_dentist_schema() {
		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );
		$logo        = ! empty( $options['clinic_logo'] ) ? $options['clinic_logo'] : '';
		$phone       = ! empty( $options['clinic_phone'] ) ? $options['clinic_phone'] : '';
		$email       = ! empty( $options['clinic_email'] ) ? $options['clinic_email'] : '';
		$address     = ! empty( $options['clinic_address'] ) ? $options['clinic_address'] : '';

		$schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Dentist',
			'name'        => esc_html( $clinic_name ),
			'url'         => esc_url( home_url( '/' ) ),
			'image'       => esc_url( $logo ),
			'logo'        => esc_url( $logo ),
			'telephone'   => esc_html( $phone ),
			'email'       => esc_html( $email ),
			'address'     => array(
				'@type'          => 'PostalAddress',
				'streetAddress' => esc_html( $address ),
				'addressLocality'=> esc_html( $options['clinic_city'] ?? 'City' ),
				'addressRegion'  => esc_html( $options['clinic_state'] ?? 'State' ),
				'postalCode'     => esc_html( $options['clinic_zip'] ?? 'Zip' ),
				'addressCountry' => 'US',
			),
		);

		// Format working hours from Options
		$hours = $options['working_hours'] ?? array();
		if ( is_array( $hours ) && ! empty( $hours ) ) {
			$opening_hours = array();
			$days_map = array(
				'monday'    => 'Mo',
				'tuesday'   => 'Tu',
				'wednesday' => 'We',
				'thursday'  => 'Th',
				'friday'    => 'Fr',
				'saturday'  => 'Sa',
				'sunday'    => 'Su',
			);

			foreach ( $hours as $day => $data ) {
				if ( isset( $days_map[ $day ] ) ) {
					$abbr = $days_map[ $day ];
					if ( isset( $data['closed'] ) && $data['closed'] ) {
						continue; // closed on this day
					}
					$open = ! empty( $data['open'] ) ? $data['open'] : '09:00';
					$close = ! empty( $data['close'] ) ? $data['close'] : '18:00';
					$opening_hours[] = "$abbr $open-$close";
				}
			}
			if ( ! empty( $opening_hours ) ) {
				$schema['openingHours'] = $opening_hours;
			}
		}

		return $schema;
	}

	/**
	 * Construct Doctor (Person) Schema.
	 *
	 * @return array|null Schema structure.
	 */
	private function get_doctor_schema() {
		$doctor_id = get_the_ID();
		if ( ! $doctor_id ) {
			return null;
		}

		$spec = get_post_meta( $doctor_id, '_developer_starter_pro_doctor_speciality', true );
		$image = get_the_post_thumbnail_url( $doctor_id, 'large' );

		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );

		$schema = array(
			'@context'          => 'https://schema.org',
			'@type'             => 'Physician',
			'name'              => get_the_title( $doctor_id ),
			'jobTitle'          => esc_html( $spec ? $spec : __( 'Dentist Specialist', 'developer-starter-pro' ) ),
			'medicalSpecialty' => 'Dentistry',
			'image'             => esc_url( $image ),
			'worksFor'          => array(
				'@type' => 'Dentist',
				'name'  => esc_html( $clinic_name ),
				'url'   => esc_url( home_url( '/' ) ),
			),
		);

		return $schema;
	}

	/**
	 * Construct Service Schema.
	 *
	 * @return array|null Schema structure.
	 */
	private function get_service_schema() {
		$service_id = get_the_ID();
		if ( ! $service_id ) {
			return null;
		}

		$price = get_post_meta( $service_id, '_developer_starter_pro_service_price', true );
		$desc  = get_post_meta( $service_id, '_developer_starter_pro_service_short_description', true );
		if ( empty( $desc ) ) {
			$desc = wp_strip_all_tags( get_the_excerpt( $service_id ) );
		}

		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );

		$schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Service',
			'name'        => get_the_title( $service_id ),
			'description' => esc_html( $desc ),
			'provider'    => array(
				'@type' => 'Dentist',
				'name'  => esc_html( $clinic_name ),
			),
		);

		if ( $price && $price > 0 ) {
			$schema['offers'] = array(
				'@type'         => 'Offer',
				'price'         => floatval( $price ),
				'priceCurrency' => 'USD',
			);
		}

		return $schema;
	}

	/**
	 * Construct FAQPage Schema.
	 *
	 * @return array|null Schema structure.
	 */
	private function get_faq_schema() {
		// Pull FAQs from the CPT
		$faq_posts = get_posts( array(
			'post_type'      => 'faqs',
			'posts_per_page' => 50,
			'post_status'    => 'publish',
		) );

		if ( empty( $faq_posts ) ) {
			return null;
		}

		$main_entity = array();
		foreach ( $faq_posts as $faq ) {
			$main_entity[] = array(
				'@type'          => 'Question',
				'name'           => esc_html( $faq->post_title ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_kses_post( apply_filters( 'the_content', $faq->post_content ) ),
				),
			);
		}

		return array(
			'@context'    => 'https://schema.org',
			'@type'       => 'FAQPage',
			'mainEntity' => $main_entity,
		);
	}

	/**
	 * Construct BreadcrumbList Schema.
	 *
	 * @return array Schema structure.
	 */
	private function get_breadcrumbs_schema() {
		$items = array();

		// Add home
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => esc_html__( 'Home', 'developer-starter-pro' ),
			'item'     => esc_url( home_url( '/' ) ),
		);

		$position = 2;

		if ( is_archive() ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => post_type_archive_title( '', false ),
				'item'     => esc_url( get_post_type_archive_link( get_post_type() ) ),
			);
		} elseif ( is_singular() ) {
			$post_type = get_post_type();
			if ( 'post' !== $post_type ) {
				$archive_link = get_post_type_archive_link( $post_type );
				if ( $archive_link ) {
					$items[] = array(
						'@type'    => 'ListItem',
						'position' => $position,
						'name'     => get_post_type_object( $post_type )->labels->name,
						'item'     => esc_url( $archive_link ),
					);
					$position++;
				}
			}
			
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => get_the_title(),
				'item'     => esc_url( get_permalink() ),
			);
		} else {
			// Normal pages
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => get_the_title(),
				'item'     => esc_url( get_permalink() ),
			);
		}

		return array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		);
	}
}
