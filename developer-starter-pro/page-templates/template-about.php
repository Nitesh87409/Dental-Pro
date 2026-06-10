<?php
/**
 * Template Name: About Us
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Story', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Learn more about our mission, core values, and dedicated team of dental experts.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Story Section -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-about-grid">
				<div class="developer-starter-pro-about-content">
					<h2 class="developer-starter-pro-about-title"><?php esc_html_e( 'Providing Quality Dental Care Since 2012', 'developer-starter-pro' ); ?></h2>
					<div class="developer-starter-pro-about-text">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="developer-starter-pro-about-image-wrap">
					<div class="developer-starter-pro-about-image">
						<div class="developer-starter-pro-about-image-placeholder">
							<span class="placeholder-icon">🏥</span>
						</div>
					</div>
					<div class="developer-starter-pro-about-experience-badge">
						<span class="years">10+</span>
						<span class="text"><?php esc_html_e( 'Years of Trust & Caring', 'developer-starter-pro' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Core Values Section -->
	<section class="developer-starter-pro-section developer-starter-pro-section--alt" style="background-color: var(--developer-starter-pro-gray-50);">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Why Choose Us', 'developer-starter-pro' ); ?></span>
				<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Our Core Values', 'developer-starter-pro' ); ?></h2>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'We build our practice around standards that put our patients first.', 'developer-starter-pro' ); ?></p>
			</div>

			<div class="developer-starter-pro-values-grid">
				<div class="developer-starter-pro-value-card">
					<div class="value-icon">🤝</div>
					<h3 class="value-title"><?php esc_html_e( 'Patient-First Focus', 'developer-starter-pro' ); ?></h3>
					<p class="value-desc"><?php esc_html_e( 'Your comfort and dental health are our top priorities. We customize treatments to suit your specific health needs.', 'developer-starter-pro' ); ?></p>
				</div>
				<div class="developer-starter-pro-value-card">
					<div class="value-icon">🔬</div>
					<h3 class="value-title"><?php esc_html_e( 'Advanced Technology', 'developer-starter-pro' ); ?></h3>
					<p class="value-desc"><?php esc_html_e( 'We utilize state-of-the-art diagnostic and surgical equipment to guarantee precision, safety, and comfort.', 'developer-starter-pro' ); ?></p>
				</div>
				<div class="developer-starter-pro-value-card">
					<div class="value-icon">🩺</div>
					<h3 class="value-title"><?php esc_html_e( 'Expert Professionals', 'developer-starter-pro' ); ?></h3>
					<p class="value-desc"><?php esc_html_e( 'Our staff consists of board-certified dentists and trained clinical assistants with years of specialized experience.', 'developer-starter-pro' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- Dynamic Team Section -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Experts', 'developer-starter-pro' ); ?></span>
				<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Meet Our Dedicated Doctors', 'developer-starter-pro' ); ?></h2>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Our specialists work together to deliver comprehensive care across all dental disciplines.', 'developer-starter-pro' ); ?></p>
			</div>

			<?php
			$doctors_query = new WP_Query( array(
				'post_type'      => 'doctors',
				'posts_per_page' => 4,
				'post_status'    => 'publish',
			) );

			if ( $doctors_query->have_posts() ) : ?>
				<div class="developer-starter-pro-doctors-grid">
					<?php while ( $doctors_query->have_posts() ) : $doctors_query->the_post();
						$speciality = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_speciality', true );
						$experience = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_experience', true );
						$social     = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_social', true );
					?>
						<div class="developer-starter-pro-doctor-card">
							<div class="developer-starter-pro-doctor-card-image">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'developer-starter-pro-doctor-thumb' ); ?>
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
													<?php echo developer_starter_pro_get_social_icon( $platform ); // phpcs:ignore ?>
												</a>
											<?php endif;
										endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="developer-starter-pro-doctor-card-content">
								<h3 class="developer-starter-pro-doctor-name">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<?php if ( $speciality ) : ?>
									<span class="developer-starter-pro-doctor-speciality"><?php echo esc_html( $speciality ); ?></span>
								<?php endif; ?>
								<?php if ( $experience ) : ?>
									<span class="developer-starter-pro-doctor-experience">
										<?php printf( esc_html__( '%s+ Years Experience', 'developer-starter-pro' ), esc_html( $experience ) ); ?>
									</span>
								<?php endif; ?>
								<a href="<?php the_permalink(); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--outline">
									<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
								</a>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php else : ?>
				<p style="text-align: center; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'No doctor profiles created yet.', 'developer-starter-pro' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php
get_footer();
