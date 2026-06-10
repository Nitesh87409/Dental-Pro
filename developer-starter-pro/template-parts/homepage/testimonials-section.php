<?php
/**
 * Template Part: Homepage Testimonials Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$testimonials = get_posts( array(
	'post_type'      => 'testimonials',
	'posts_per_page' => 6,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
) );

if ( empty( $testimonials ) ) {
	return;
}
?>

<section class="developer-starter-pro-section developer-starter-pro-testimonials-section" id="testimonials">
	<div class="developer-starter-pro-container">
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Testimonials', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'What Our Patients Say', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Read reviews from our happy patients about their dental care experience.', 'developer-starter-pro' ); ?></p>
		</div>

		<div class="developer-starter-pro-testimonials-grid">
			<?php foreach ( $testimonials as $testimonial ) :
				$patient_name = get_post_meta( $testimonial->ID, '_developer_starter_pro_testimonial_patient_name', true );
				$rating       = get_post_meta( $testimonial->ID, '_developer_starter_pro_testimonial_rating', true );
				$treatment    = get_post_meta( $testimonial->ID, '_developer_starter_pro_testimonial_treatment', true );
			?>
				<div class="developer-starter-pro-testimonial-card">
					<div class="developer-starter-pro-testimonial-rating">
						<?php echo developer_starter_pro_get_star_rating( intval( $rating ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="developer-starter-pro-testimonial-text">
						<?php echo wp_kses_post( $testimonial->post_content ); ?>
					</div>
					<div class="developer-starter-pro-testimonial-author">
						<?php if ( has_post_thumbnail( $testimonial->ID ) ) : ?>
							<div class="developer-starter-pro-testimonial-avatar">
								<?php echo get_the_post_thumbnail( $testimonial->ID, 'developer-starter-pro-testimonial' ); ?>
							</div>
						<?php endif; ?>
						<div class="developer-starter-pro-testimonial-info">
							<?php if ( $patient_name ) : ?>
								<span class="developer-starter-pro-testimonial-name"><?php echo esc_html( $patient_name ); ?></span>
							<?php endif; ?>
							<?php if ( $treatment ) : ?>
								<span class="developer-starter-pro-testimonial-treatment"><?php echo esc_html( $treatment ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
