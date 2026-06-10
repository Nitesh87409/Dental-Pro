<?php
/**
 * Single Service Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

$prefix    = '_developer_starter_pro_';
$price     = get_post_meta( get_the_ID(), $prefix . 'service_price', true );
$duration  = get_post_meta( get_the_ID(), $prefix . 'service_duration', true );
$icon      = get_post_meta( get_the_ID(), $prefix . 'service_icon', true );
$short_desc = get_post_meta( get_the_ID(), $prefix . 'service_short_description', true );
$treatments = get_the_terms( get_the_ID(), 'treatment_type' );

// Related services.
$related = get_posts( array(
	'post_type'      => 'services',
	'posts_per_page' => 3,
	'post__not_in'   => array( get_the_ID() ),
	'orderby'        => 'rand',
	'post_status'    => 'publish',
) );
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Breadcrumb -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<nav class="developer-starter-pro-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'developer-starter-pro' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'developer-starter-pro' ); ?></a>
				<span class="sep">›</span>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'services' ) ); ?>"><?php esc_html_e( 'Services', 'developer-starter-pro' ); ?></a>
				<span class="sep">›</span>
				<span class="current"><?php the_title(); ?></span>
			</nav>
		</div>
	</div>

	<div class="developer-starter-pro-container">
		<article class="developer-starter-pro-service-detail">

			<!-- Service Header -->
			<div class="developer-starter-pro-service-detail-header">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="developer-starter-pro-service-detail-image">
						<?php the_post_thumbnail( 'developer-starter-pro-gallery-large' ); ?>
					</div>
				<?php endif; ?>

				<div class="developer-starter-pro-service-detail-meta-bar">
					<h1 class="developer-starter-pro-service-detail-title"><?php the_title(); ?></h1>

					<div class="developer-starter-pro-service-detail-badges">
						<?php if ( $price && $price > 0 ) : ?>
							<span class="developer-starter-pro-service-detail-price">
								<?php esc_html_e( 'From', 'developer-starter-pro' ); ?>
								$<?php echo esc_html( number_format( (float) $price, 0 ) ); ?>
							</span>
						<?php endif; ?>
						<?php if ( $duration ) : ?>
							<span class="developer-starter-pro-service-detail-duration">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
								<?php echo esc_html( $duration ); ?> <?php esc_html_e( 'minutes', 'developer-starter-pro' ); ?>
							</span>
						<?php endif; ?>
						<?php if ( $treatments && ! is_wp_error( $treatments ) ) : ?>
							<?php foreach ( $treatments as $term ) : ?>
								<span class="developer-starter-pro-tag"><?php echo esc_html( $term->name ); ?></span>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Service Content -->
			<div class="developer-starter-pro-service-detail-grid">
				<div class="developer-starter-pro-service-detail-content">
					<div class="developer-starter-pro-card">
						<div class="developer-starter-pro-card-content developer-starter-pro-post-content">
							<?php the_content(); ?>

							<?php 
							// Social Share buttons
							if ( function_exists( 'developer_starter_pro_social_share' ) ) {
								echo '<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--developer-starter-pro-gray-200);">';
								developer_starter_pro_social_share();
								echo '</div>';
							}
							?>
						</div>
					</div>
				</div>

				<!-- Sidebar CTA -->
				<div class="developer-starter-pro-service-detail-sidebar">
					<div class="developer-starter-pro-card developer-starter-pro-cta-card">
						<h3 class="developer-starter-pro-card-title"><?php esc_html_e( 'Ready to Get Started?', 'developer-starter-pro' ); ?></h3>
						<p><?php esc_html_e( 'Book your appointment today and take the first step towards a healthier smile.', 'developer-starter-pro' ); ?></p>
						<a href="<?php echo esc_url( developer_starter_pro_get_booking_url() ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary developer-starter-pro-btn--full" style="margin-bottom: 12px;">
							<?php esc_html_e( 'Book Appointment', 'developer-starter-pro' ); ?>
						</a>
						<?php $clinic_phone = developer_starter_pro_get_option( 'clinic_phone', '' ); ?>
						<?php if ( $clinic_phone ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $clinic_phone ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline developer-starter-pro-btn--full">
								<?php esc_html_e( 'Call Us', 'developer-starter-pro' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<?php if ( ! empty( $related ) ) : ?>
			<!-- Related Services -->
			<div class="developer-starter-pro-related-section">
				<h2 class="developer-starter-pro-section-title" style="text-align: center; margin-bottom: 32px;"><?php esc_html_e( 'Related Services', 'developer-starter-pro' ); ?></h2>
				<div class="developer-starter-pro-services-grid">
					<?php foreach ( $related as $service ) :
						$r_price = get_post_meta( $service->ID, $prefix . 'service_price', true );
						$r_duration = get_post_meta( $service->ID, $prefix . 'service_duration', true );
						$r_desc = get_post_meta( $service->ID, $prefix . 'service_short_description', true );
					?>
						<div class="developer-starter-pro-service-card">
							<?php if ( has_post_thumbnail( $service->ID ) ) : ?>
								<div class="developer-starter-pro-service-card-image">
									<?php echo get_the_post_thumbnail( $service->ID, 'developer-starter-pro-service-thumb' ); ?>
								</div>
							<?php endif; ?>
							<div class="developer-starter-pro-service-card-content">
								<h3 class="developer-starter-pro-service-card-title">
									<a href="<?php echo esc_url( get_permalink( $service->ID ) ); ?>"><?php echo esc_html( $service->post_title ); ?></a>
								</h3>
								<?php if ( $r_desc ) : ?>
									<p class="developer-starter-pro-service-card-desc"><?php echo esc_html( $r_desc ); ?></p>
								<?php endif; ?>
								<a href="<?php echo esc_url( get_permalink( $service->ID ) ); ?>" class="developer-starter-pro-read-more">
									<?php esc_html_e( 'Learn More', 'developer-starter-pro' ); ?> →
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>

		</article>
	</div>
</main>

<style>
.developer-starter-pro-service-detail { padding: 48px 0; }

.developer-starter-pro-service-detail-image {
	border-radius: var(--developer-starter-pro-radius-lg);
	overflow: hidden;
	margin-bottom: 24px;
	box-shadow: var(--developer-starter-pro-shadow-lg);
}

.developer-starter-pro-service-detail-title { font-size: 2.25rem; margin-bottom: 16px; }

.developer-starter-pro-service-detail-badges {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 12px;
	margin-bottom: 32px;
}

.developer-starter-pro-service-detail-price {
	font-family: var(--developer-starter-pro-font-heading);
	font-size: 1.5rem;
	font-weight: 700;
	color: var(--developer-starter-pro-primary);
}

.developer-starter-pro-service-detail-duration {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	padding: 6px 16px;
	background: var(--developer-starter-pro-gray-100);
	border-radius: var(--developer-starter-pro-radius-full);
	font-size: 0.875rem;
	color: var(--developer-starter-pro-gray-600);
}

.developer-starter-pro-service-detail-grid {
	display: grid;
	grid-template-columns: 1fr 350px;
	gap: 32px;
	margin-bottom: 48px;
}

.developer-starter-pro-cta-card {
	background: linear-gradient(135deg, var(--developer-starter-pro-gray-50) 0%, #fff 100%);
	border: 2px solid var(--developer-starter-pro-primary-light);
	text-align: center;
	position: sticky;
	top: 100px;
}

.developer-starter-pro-related-section {
	padding-top: 48px;
	border-top: 1px solid var(--developer-starter-pro-gray-200);
}

@media (max-width: 768px) {
	.developer-starter-pro-service-detail-grid { grid-template-columns: 1fr; }
	.developer-starter-pro-service-detail-title { font-size: 1.75rem; }
}
</style>

<?php
get_footer();
