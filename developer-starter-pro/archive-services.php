<?php
/**
 * Archive Services Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Banner -->
	<div class="developer-starter-pro-archive-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Services', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php esc_html_e( 'Dental Services & Treatments', 'developer-starter-pro' ); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'We offer a comprehensive range of dental services to meet all your oral health needs.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<div class="developer-starter-pro-container">
		<div class="developer-starter-pro-section" style="padding-top: 48px;">

			<?php if ( have_posts() ) : ?>

				<!-- Filter by Treatment Type -->
				<?php
				$treatment_types = get_terms( array(
					'taxonomy'   => 'treatment_type',
					'hide_empty' => true,
				) );

				if ( ! empty( $treatment_types ) && ! is_wp_error( $treatment_types ) ) : ?>
					<div class="developer-starter-pro-filter-bar" style="text-align: center; margin-bottom: 40px;">
						<button class="developer-starter-pro-filter-btn active" data-filter="all"><?php esc_html_e( 'All Services', 'developer-starter-pro' ); ?></button>
						<?php foreach ( $treatment_types as $type ) : ?>
							<button class="developer-starter-pro-filter-btn" data-filter="<?php echo esc_attr( $type->slug ); ?>"><?php echo esc_html( $type->name ); ?></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="developer-starter-pro-services-grid">
					<?php while ( have_posts() ) : the_post();
						$price      = get_post_meta( get_the_ID(), '_developer_starter_pro_service_price', true );
						$duration   = get_post_meta( get_the_ID(), '_developer_starter_pro_service_duration', true );
						$short_desc = get_post_meta( get_the_ID(), '_developer_starter_pro_service_short_description', true );
						$type_terms = get_the_terms( get_the_ID(), 'treatment_type' );
						$type_slugs = is_array( $type_terms ) ? implode( ' ', wp_list_pluck( $type_terms, 'slug' ) ) : '';
					?>
						<div class="developer-starter-pro-service-card" data-treatment="<?php echo esc_attr( $type_slugs ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="developer-starter-pro-service-card-image">
									<?php the_post_thumbnail( 'developer-starter-pro-service-thumb' ); ?>
								</div>
							<?php endif; ?>
							<div class="developer-starter-pro-service-card-content">
								<h3 class="developer-starter-pro-service-card-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
								<a href="<?php the_permalink(); ?>" class="developer-starter-pro-read-more">
									<?php esc_html_e( 'Learn More', 'developer-starter-pro' ); ?>
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
								</a>
							</div>
						</div>
					<?php endwhile; ?>
				</div>

				<div class="developer-starter-pro-pagination">
					<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
				</div>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</div>
</main>


<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterBtns = document.querySelectorAll('.developer-starter-pro-filter-btn');
	var serviceCards = document.querySelectorAll('.developer-starter-pro-service-card[data-treatment]');

	filterBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			filterBtns.forEach(function(b) { b.classList.remove('active'); });
			this.classList.add('active');

			var filter = this.getAttribute('data-filter');
			serviceCards.forEach(function(card) {
				if (filter === 'all' || card.getAttribute('data-treatment').indexOf(filter) !== -1) {
					card.style.display = '';
					card.style.animation = 'fadeInUp 0.4s ease-out';
				} else {
					card.style.display = 'none';
				}
			});
		});
	});
});
</script>

<?php
get_footer();
