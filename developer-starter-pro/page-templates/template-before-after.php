<?php
/**
 * Template Name: Before & After Comparison
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
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Smile Makeovers', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Interactive before and after comparison of dental procedures and cosmetic smile transformations.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Gallery Comparison Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">

			<!-- Category Filter Tabs -->
			<?php
			$terms = get_terms( array(
				'taxonomy'   => 'before_after_cat',
				'hide_empty' => true,
			) );
			?>
			<div class="developer-starter-pro-ba-filters" style="display:flex; justify-content:center; gap:12px; margin-bottom: 50px; flex-wrap: wrap;">
				<button class="developer-starter-pro-ba-filter-btn active" data-filter="all"><?php esc_html_e( 'All Cases', 'developer-starter-pro' ); ?></button>
				<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
					<?php foreach ( $terms as $term ) : ?>
						<button class="developer-starter-pro-ba-filter-btn" data-filter="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></button>
					<?php endforeach; ?>
				<?php else : ?>
					<button class="developer-starter-pro-ba-filter-btn" data-filter="whitening"><?php esc_html_e( 'Teeth Whitening', 'developer-starter-pro' ); ?></button>
					<button class="developer-starter-pro-ba-filter-btn" data-filter="veneers"><?php esc_html_e( 'Veneers & Crowns', 'developer-starter-pro' ); ?></button>
					<button class="developer-starter-pro-ba-filter-btn" data-filter="ortho"><?php esc_html_e( 'Orthodontics', 'developer-starter-pro' ); ?></button>
				<?php endif; ?>
			</div>

			<!-- Comparison Grid -->
			<div class="developer-starter-pro-ba-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 40px;">

				<?php
				$cases_query = new WP_Query( array(
					'post_type'      => 'before_after',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				) );

				$count = 0;
				if ( $cases_query->have_posts() ) :
					while ( $cases_query->have_posts() ) : $cases_query->the_post();
						$count++;
						$before_image = get_post_meta( get_the_ID(), '_developer_starter_pro_before_image', true );
						$after_image  = get_post_meta( get_the_ID(), '_developer_starter_pro_after_image', true );
						$before_label = get_post_meta( get_the_ID(), '_developer_starter_pro_before_label', true );
						$after_label  = get_post_meta( get_the_ID(), '_developer_starter_pro_after_label', true );

						$before_label = $before_label ? $before_label : esc_html__( 'Before', 'developer-starter-pro' );
						$after_label  = $after_label ? $after_label : esc_html__( 'After', 'developer-starter-pro' );

						$case_terms = get_the_terms( get_the_ID(), 'before_after_cat' );
						$case_slugs = is_array( $case_terms ) ? implode( ' ', wp_list_pluck( $case_terms, 'slug' ) ) : '';
						?>
						<div class="developer-starter-pro-ba-item" data-category="<?php echo esc_attr( $case_slugs ); ?>">
							<?php
							echo do_shortcode( sprintf(
								'[dental_before_after title="%s" before_url="%s" after_url="%s" before_label="%s" after_label="%s"]',
								esc_attr( get_the_title() ),
								esc_url( $before_image ),
								esc_url( $after_image ),
								esc_attr( $before_label ),
								esc_attr( $after_label )
							) );
							?>
							<div style="text-align: center; margin-top: 15px; padding: 0 10px;">
								<p style="font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php echo esc_html( get_the_excerpt() ); ?></p>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php endif; ?>

				<?php
				// Fill up with format placeholders to ensure at least 2 cards are shown
				while ( $count < 2 ) :
					$count++;
					?>
					<div class="developer-starter-pro-ba-item placeholder-card" data-category="all" style="background: var(--developer-starter-pro-gray-50); border: 1px dashed var(--developer-starter-pro-gray-300); border-radius: var(--developer-starter-pro-radius-lg); padding: 15px; box-shadow: var(--developer-starter-pro-shadow-sm); display: flex; flex-direction: column; justify-content: space-between; min-height: 380px;">
						<div style="width: 100%; aspect-ratio: 4 / 3; background: var(--developer-starter-pro-gray-100); border-radius: var(--developer-starter-pro-radius-lg); display: flex; flex-direction: column; justify-content: center; align-items: center; border: 1.5px dashed var(--developer-starter-pro-gray-200); color: var(--developer-starter-pro-gray-400); margin-bottom: 20px;">
							<span style="font-size: 2.5rem; margin-bottom: 10px;">✨</span>
							<span style="font-size: 0.9rem; font-weight: 600;"><?php printf( esc_html__( 'Smile Transformation Case %d', 'developer-starter-pro' ), $count ); ?></span>
							<span style="font-size: 0.75rem; margin-top: 4px;"><?php esc_html_e( '(Configure in WP Admin)', 'developer-starter-pro' ); ?></span>
						</div>
						<div style="text-align: center; padding: 10px;">
							<h4 style="margin: 0 0 6px 0; color: var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'Pending Case Spot', 'developer-starter-pro' ); ?></h4>
							<p style="font-size: 0.875rem; color: var(--developer-starter-pro-gray-400); margin: 0;"><?php esc_html_e( 'Add clinical transformation cases under the Before/After Cases dashboard page.', 'developer-starter-pro' ); ?></p>
						</div>
					</div>
				<?php endwhile; ?>

			</div>

			<!-- Dynamic CTA -->
			<div class="developer-starter-pro-section-cta">
				<h3><?php esc_html_e( 'Ready for Your Own Smile Makeover?', 'developer-starter-pro' ); ?></h3>
				<p style="color: var(--developer-starter-pro-gray-500); max-width: 600px; margin: 10px auto 25px;"><?php esc_html_e( 'Consult with our experienced dental specialists and discover the best dental procedures for your aesthetic and restorative needs.', 'developer-starter-pro' ); ?></p>
				<a href="<?php echo esc_url( developer_starter_pro_get_booking_url() ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
					<?php esc_html_e( 'Book Treatment Consultation', 'developer-starter-pro' ); ?>
				</a>
			</div>

		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterButtons = document.querySelectorAll('.developer-starter-pro-ba-filter-btn');
	var items = document.querySelectorAll('.developer-starter-pro-ba-item');

	filterButtons.forEach(function(btn) {
		btn.addEventListener('click', function() {
			// Toggle active class on buttons
			filterButtons.forEach(function(b) { b.classList.remove('active'); });
			this.classList.add('active');

			var filter = this.getAttribute('data-filter');

			// Filter grid items
			items.forEach(function(item) {
				if (filter === 'all' || item.getAttribute('data-category') === filter) {
					item.style.display = 'block';
				} else {
					item.style.display = 'none';
				}
			});
		});
	});
});
</script>

<style>
.developer-starter-pro-ba-filter-btn {
	background: transparent;
	border: 2px solid var(--developer-starter-pro-gray-200);
	color: var(--developer-starter-pro-gray-600);
	padding: 8px 20px;
	border-radius: var(--developer-starter-pro-radius-full);
	font-weight: 600;
	cursor: pointer;
	transition: var(--developer-starter-pro-transition-fast);
}
.developer-starter-pro-ba-filter-btn.active,
.developer-starter-pro-ba-filter-btn:hover {
	background: var(--developer-starter-pro-primary);
	border-color: var(--developer-starter-pro-primary);
	color: var(--developer-starter-pro-white);
}
body.dark-mode .developer-starter-pro-ba-filter-btn {
	border-color: #334155;
	color: #CBD5E1;
}
body.dark-mode .developer-starter-pro-ba-filter-btn.active {
	background: var(--developer-starter-pro-primary);
	color: var(--developer-starter-pro-white);
}
@media (max-width: 480px) {
	.developer-starter-pro-ba-grid {
		grid-template-columns: 1fr !important;
	}
}
</style>

<?php
get_footer();
