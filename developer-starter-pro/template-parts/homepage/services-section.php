<?php
/**
 * Template Part: Homepage Services Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$services = get_posts( array(
	'post_type'      => 'services',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );

if ( empty( $services ) ) {
	return;
}
?>

<section class="developer-starter-pro-section developer-starter-pro-services-section" id="services">
	<div class="developer-starter-pro-container">
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Services', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Comprehensive Dental Care', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'We offer a full range of dental services to keep your smile healthy and beautiful.', 'developer-starter-pro' ); ?></p>
		</div>

		<div class="developer-starter-pro-services-grid">
			<?php foreach ( $services as $service ) :
				$price      = get_post_meta( $service->ID, '_developer_starter_pro_service_price', true );
				$duration   = get_post_meta( $service->ID, '_developer_starter_pro_service_duration', true );
				$short_desc = get_post_meta( $service->ID, '_developer_starter_pro_service_short_description', true );
				$icon       = get_post_meta( $service->ID, '_developer_starter_pro_service_icon', true );
			?>
				<div class="developer-starter-pro-service-card">
					<?php if ( has_post_thumbnail( $service->ID ) ) : ?>
						<div class="developer-starter-pro-service-card-image">
							<?php echo get_the_post_thumbnail( $service->ID, 'developer-starter-pro-service-thumb' ); ?>
						</div>
					<?php endif; ?>
					<div class="developer-starter-pro-service-card-content">
						<h3 class="developer-starter-pro-service-card-title">
							<a href="<?php echo esc_url( get_permalink( $service->ID ) ); ?>">
								<?php echo esc_html( $service->post_title ); ?>
							</a>
						</h3>
						<?php if ( $short_desc ) : ?>
							<p class="developer-starter-pro-service-card-desc"><?php echo esc_html( $short_desc ); ?></p>
						<?php endif; ?>
						<div class="developer-starter-pro-service-card-meta">
							<?php if ( $price && $price > 0 ) : ?>
								<span class="developer-starter-pro-service-price"><?php echo esc_html( '$' . number_format( (float) $price, 0 ) ); ?></span>
							<?php endif; ?>
							<?php if ( $duration ) : ?>
								<span class="developer-starter-pro-service-duration"><?php echo esc_html( $duration . ' min' ); ?></span>
							<?php endif; ?>
						</div>
						<a href="<?php echo esc_url( get_permalink( $service->ID ) ); ?>" class="developer-starter-pro-read-more">
							<?php esc_html_e( 'Learn More', 'developer-starter-pro' ); ?>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="developer-starter-pro-section-cta">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'services' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
				<?php esc_html_e( 'View All Services', 'developer-starter-pro' ); ?>
			</a>
		</div>
	</div>
</section>
