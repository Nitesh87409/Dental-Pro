<?php
/**
 * Template Name: Pricing Packages
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
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Cost Transparency', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Review clear, competitive treatment package costs. No hidden fees, clear consultations.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Pricing Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">

			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;
			?>

			<?php
			// Query treatment type terms
			$treatments = get_terms( array(
				'taxonomy'   => 'treatment_type',
				'hide_empty' => true,
			) );

			if ( ! empty( $treatments ) && ! is_wp_error( $treatments ) ) :
				foreach ( $treatments as $term ) :
					$services_query = new WP_Query( array(
						'post_type'      => 'services',
						'posts_per_page' => -1,
						'tax_query'      => array(
							array(
								'taxonomy' => 'treatment_type',
								'field'    => 'slug',
								'terms'    => $term->slug,
							),
						),
						'post_status'    => 'publish',
					) );

					if ( $services_query->have_posts() ) : ?>
						<div class="developer-starter-pro-pricing-category" style="margin-bottom: 56px;">
							<h2 style="border-bottom:2px solid var(--developer-starter-pro-primary-light); padding-bottom:12px; margin-bottom: 24px; font-size:1.75rem;">
								<?php echo esc_html( $term->name ); ?>
							</h2>
							
							<div class="developer-starter-pro-pricing-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
								<?php while ( $services_query->have_posts() ) : $services_query->the_post();
									$price = get_post_meta( get_the_ID(), '_developer_starter_pro_service_price', true );
									$duration = get_post_meta( get_the_ID(), '_developer_starter_pro_service_duration', true );
									$short_desc = get_post_meta( get_the_ID(), '_developer_starter_pro_service_short_description', true );
								?>
									<div class="developer-starter-pro-pricing-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:12px; padding:28px; display:flex; flex-direction:column; justify-content:space-between; box-shadow: var(--developer-starter-pro-shadow-sm); transition: var(--developer-starter-pro-transition);">
										<div>
											<h3 style="margin-top:0; margin-bottom:8px; font-size:1.25rem;"><?php the_title(); ?></h3>
											<?php if ( $short_desc ) : ?>
												<p style="color:var(--developer-starter-pro-gray-500); font-size:0.9rem; margin-bottom: 20px; line-height:1.6;"><?php echo esc_html( $short_desc ); ?></p>
											<?php endif; ?>
										</div>
										
										<div style="border-top: 1px solid var(--developer-starter-pro-gray-100); padding-top:16px; display:flex; align-items:center; justify-content:space-between;">
											<div>
												<?php 
												$price_clean = developer_starter_pro_get_clean_service_price( $price );
												if ( $price_clean > 0 ) : 
													?>
													<span style="font-family: var(--developer-starter-pro-font-heading); font-size: 1.75rem; font-weight: 800; color: var(--developer-starter-pro-primary);">$<?php echo esc_html( number_format( $price_clean, 0 ) ); ?></span>
												<?php else : ?>
													<span style="font-family: var(--developer-starter-pro-font-heading); font-size: 1.25rem; font-weight: 700; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Free Consultation', 'developer-starter-pro' ); ?></span>
												<?php endif; ?>
												
												<?php 
												$duration_clean = developer_starter_pro_get_clean_service_duration( $duration );
												if ( $duration_clean ) : 
													?>
													<span style="display:block; font-size:0.75rem; color:var(--developer-starter-pro-gray-400); margin-top:2px;">⏱ <?php echo esc_html( $duration_clean ); ?></span>
												<?php endif; ?>
											</div>
											<a href="<?php echo esc_url( developer_starter_pro_get_booking_url() ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--primary">
												<?php esc_html_e( 'Book Now', 'developer-starter-pro' ); ?>
											</a>
										</div>
									</div>
								<?php endwhile; wp_reset_postdata(); ?>
							</div>
						</div>
					<?php endif;
				endforeach;
			else : ?>
				<p style="text-align: center; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'No services or treatments configured yet.', 'developer-starter-pro' ); ?></p>
			<?php endif; ?>

		</div>
	</section>

</main>

<?php
get_footer();
