<?php
/**
 * Front Page Template
 *
 * Displays all dental marketing, dynamic metrics, sliders, and scheduling sections.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main developer-starter-pro-front-page" role="main">

	<?php
	// 1. Hero Slider Section
	get_template_part( 'template-parts/homepage/hero', 'slider' );

	// 3. Services Grid Section
	get_template_part( 'template-parts/homepage/services', 'section' );

	// 4. Why Choose Us Section
	get_template_part( 'template-parts/homepage/why-choose', 'us' );

	// 5. Doctors List Section
	get_template_part( 'template-parts/homepage/doctors', 'section' );

	// 8. Testimonials Section
	get_template_part( 'template-parts/homepage/testimonials', 'section' );

	// Treatment Cost Calculator Section
	get_template_part( 'template-parts/homepage/calculator', 'section' );

	// 7. CTA Banner Booking Section (Appointment Booking)
	get_template_part( 'template-parts/homepage/cta', 'banner' );

	/* Comment out non-essential sections to match the clean reference layout
	// 6. Before/After Comparison Slider Section
	get_template_part( 'template-parts/homepage/before-after', 'section' );

	// 6.5. Gallery Showcase Section
	get_template_part( 'template-parts/homepage/gallery', 'section' );

	// 7.5. Clinic 360-Degree Virtual Tour Section
	get_template_part( 'template-parts/homepage/tour', 'section' );

	// 9. Google Reviews Section
	get_template_part( 'template-parts/homepage/google', 'reviews' );

	// 10. FAQ Accordion Section
	get_template_part( 'template-parts/homepage/faq', 'section' );

	// 11. Latest Blog Posts Section
	get_template_part( 'template-parts/homepage/blog', 'section' );
	*/
	?>

</main>

<?php
get_footer();
