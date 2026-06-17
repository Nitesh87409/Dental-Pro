<?php
/**
 * Template Name: Services Directory
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

// Fetch all services
$services_query = new WP_Query( array(
	'post_type'      => 'services',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );

$terms = get_terms( array(
	'taxonomy'   => 'treatment_type',
	'hide_empty' => true,
) );
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Offerings', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Explore our specialized clinical treatments and oral hygiene services.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">

			<!-- Category Filter Buttons -->
			<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
				<div class="services-category-filters" style="display: flex; justify-content: center; gap: 10px; margin-bottom: 40px; flex-wrap: wrap;">
					<button class="filter-btn active" data-filter="all" style="padding: 10px 22px; border: 2px solid var(--developer-starter-pro-gray-200); background: transparent; border-radius: var(--developer-starter-pro-radius-full); font-weight: 600; cursor: pointer; transition: all 0.2s ease;"><?php esc_html_e( 'All Services', 'developer-starter-pro' ); ?></button>
					<?php foreach ( $terms as $term ) : ?>
						<button class="filter-btn" data-filter="<?php echo esc_attr( $term->slug ); ?>" style="padding: 10px 22px; border: 2px solid var(--developer-starter-pro-gray-200); background: transparent; border-radius: var(--developer-starter-pro-radius-full); font-weight: 600; cursor: pointer; transition: all 0.2s ease;"><?php echo esc_html( $term->name ); ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Services Grid -->
			<div class="services-directory-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
				<?php if ( $services_query->have_posts() ) : ?>
					<?php while ( $services_query->have_posts() ) : $services_query->the_post();
						$price      = get_post_meta( get_the_ID(), '_developer_starter_pro_service_price', true );
						$duration   = get_post_meta( get_the_ID(), '_developer_starter_pro_service_duration', true );
						$short_desc = get_post_meta( get_the_ID(), '_developer_starter_pro_service_short_description', true );
						
						// Get item categories
						$item_terms = get_the_terms( get_the_ID(), 'treatment_type' );
						$categories = array();
						if ( $item_terms && ! is_wp_error( $item_terms ) ) {
							foreach ( $item_terms as $t ) {
								$categories[] = $t->slug;
							}
						}
						$category_string = implode( ' ', $categories );
					?>
						<div class="directory-service-card" data-categories="<?php echo esc_attr( $category_string ); ?>" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); overflow: hidden; box-shadow: var(--developer-starter-pro-shadow-sm); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">
							
							<div>
								<?php if ( has_post_thumbnail() ) : ?>
									<div style="aspect-ratio: 16/10; overflow: hidden;">
										<?php the_post_thumbnail( 'developer-starter-pro-service-thumb', array( 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
									</div>
								<?php endif; ?>
								
								<div style="padding: 28px;">
									<h3 style="margin-top: 0; margin-bottom: 10px; font-size: 1.25rem;">
										<a href="<?php the_permalink(); ?>" style="color: var(--developer-starter-pro-secondary); text-decoration: none;">
											<?php the_title(); ?>
										</a>
									</h3>
									<?php if ( $short_desc ) : ?>
										<p style="color: var(--developer-starter-pro-gray-500); font-size: 0.9375rem; line-height: 1.6; margin: 0;"><?php echo esc_html( $short_desc ); ?></p>
									<?php endif; ?>
								</div>
							</div>
							
							<div style="border-top: 1px solid var(--developer-starter-pro-gray-100); padding: 20px 28px; display: flex; align-items: center; justify-content: space-between;">
								<div>
									<?php 
									$price_clean = developer_starter_pro_get_clean_service_price( $price );
									if ( $price_clean > 0 ) : 
										?>
										<span style="font-family: var(--developer-starter-pro-font-heading); font-size: 1.375rem; font-weight: 800; color: var(--developer-starter-pro-primary);">$<?php echo esc_html( number_format( $price_clean, 0 ) ); ?></span>
									<?php else : ?>
										<span style="font-size: 0.9375rem; font-weight: 600; color: var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'Consultation', 'developer-starter-pro' ); ?></span>
									<?php endif; ?>
									
									<?php 
									$duration_clean = developer_starter_pro_get_clean_service_duration( $duration );
									if ( $duration_clean ) : 
										?>
										<span style="display: block; font-size: 0.75rem; color: var(--developer-starter-pro-gray-400); margin-top: 2px;"><?php echo esc_html( $duration_clean ); ?></span>
									<?php endif; ?>
								</div>
								
								<a href="<?php echo esc_url( add_query_arg( 'service_id', get_the_ID(), developer_starter_pro_get_booking_url() ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--primary">
									<?php esc_html_e( 'Book', 'developer-starter-pro' ); ?>
								</a>
							</div>
							
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<p style="grid-column: 1/-1; text-align: center; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'No clinical services configured yet.', 'developer-starter-pro' ); ?></p>
				<?php endif; ?>
			</div>

		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterButtons = document.querySelectorAll('.services-category-filters .filter-btn');
	var cards = document.querySelectorAll('.directory-service-card');

	filterButtons.forEach(function(btn) {
		btn.addEventListener('click', function() {
			filterButtons.forEach(function(b) { b.classList.remove('active'); b.style.background = 'transparent'; b.style.borderColor = 'var(--developer-starter-pro-gray-200)'; b.style.color = ''; });
			this.classList.add('active');
			this.style.background = 'var(--developer-starter-pro-primary)';
			this.style.borderColor = 'var(--developer-starter-pro-primary)';
			this.style.color = '#fff';

			var filter = this.getAttribute('data-filter');

			cards.forEach(function(card) {
				var categories = card.getAttribute('data-categories').split(' ');
				if (filter === 'all' || categories.indexOf(filter) !== -1) {
					card.style.display = 'flex';
				} else {
					card.style.display = 'none';
				}
			});
		});
	});

	// Style active button initially
	var activeBtn = document.querySelector('.services-category-filters .filter-btn.active');
	if (activeBtn) {
		activeBtn.style.background = 'var(--developer-starter-pro-primary)';
		activeBtn.style.borderColor = 'var(--developer-starter-pro-primary)';
		activeBtn.style.color = '#fff';
	}
});
</script>

<style>
.directory-service-card:hover {
	transform: translateY(-4px);
	box-shadow: var(--developer-starter-pro-shadow-md) !important;
	border-color: var(--developer-starter-pro-primary) !important;
}
body.dark-mode .directory-service-card {
	background: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode .filter-btn {
	border-color: #334155;
	color: #CBD5E1;
}
body.dark-mode .filter-btn.active {
	background: var(--developer-starter-pro-primary) !important;
	border-color: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
}
</style>

<?php
get_footer();
