<?php
/**
 * Template Part: Homepage Doctors Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$doctors = get_posts( array(
	'post_type'      => 'doctors',
	'posts_per_page' => 4,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );

if ( empty( $doctors ) ) {
	return;
}
?>

<section class="developer-starter-pro-section developer-starter-pro-doctors-section" id="doctors">
	<div class="developer-starter-pro-container">
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Team', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Meet Our Expert Doctors', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Our team of experienced dental professionals is dedicated to your oral health.', 'developer-starter-pro' ); ?></p>
		</div>

		<div class="developer-starter-pro-doctors-grid">
			<?php foreach ( $doctors as $doctor ) :
				$speciality = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_speciality', true );
				$experience = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_experience', true );
				$social     = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_social', true );
			?>
				<div class="developer-starter-pro-doctor-card">
					<div class="developer-starter-pro-doctor-card-image">
						<?php if ( has_post_thumbnail( $doctor->ID ) ) : ?>
							<?php echo get_the_post_thumbnail( $doctor->ID, 'developer-starter-pro-doctor-thumb' ); ?>
						<?php else : ?>
							<div class="developer-starter-pro-doctor-placeholder">
								<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
							</div>
						<?php endif; ?>
						<?php if ( is_array( $social ) && ! empty( array_filter( $social ) ) ) : ?>
							<div class="developer-starter-pro-doctor-social-overlay">
								<?php foreach ( $social as $platform => $url ) :
									if ( $url ) : ?>
										<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $platform ) ); ?>">
											<?php echo developer_starter_pro_get_social_icon( $platform ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</a>
									<?php endif;
								endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="developer-starter-pro-doctor-card-content">
						<h3 class="developer-starter-pro-doctor-name">
							<a href="<?php echo esc_url( get_permalink( $doctor->ID ) ); ?>"><?php echo esc_html( $doctor->post_title ); ?></a>
						</h3>
						<?php if ( $speciality ) : ?>
							<span class="developer-starter-pro-doctor-speciality"><?php echo esc_html( $speciality ); ?></span>
						<?php endif; ?>
						<?php if ( $experience ) : ?>
							<span class="developer-starter-pro-doctor-experience">
								<?php printf( esc_html__( '%s+ Years Experience', 'developer-starter-pro' ), esc_html( $experience ) ); ?>
							</span>
						<?php endif; ?>
						<a href="<?php echo esc_url( get_permalink( $doctor->ID ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--outline">
							<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="developer-starter-pro-section-cta">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'doctors' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
				<?php esc_html_e( 'View All Doctors', 'developer-starter-pro' ); ?>
			</a>
		</div>
	</div>
</section>
