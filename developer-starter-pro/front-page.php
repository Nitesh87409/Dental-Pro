<?php
/**
 * Front Page Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main developer-starter-pro-front-page" role="main">

	<?php
	// Hero Section.
	get_template_part( 'template-parts/homepage/hero', 'slider' );

	// Services Section.
	get_template_part( 'template-parts/homepage/services', 'section' );

	// Doctors Section.
	get_template_part( 'template-parts/homepage/doctors', 'section' );

	// Testimonials Section.
	get_template_part( 'template-parts/homepage/testimonials', 'section' );
	?>

</main>

<?php
get_footer();
