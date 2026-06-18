<?php
/**
 * Template Part: Homepage Before/After Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<section class="developer-starter-pro-section homepage-before-after-section" id="before-after" style="background: var(--developer-starter-pro-white);">
	<div class="developer-starter-pro-container">
		
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Smile Transformations', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Before & After Gallery', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Drag the comparison slider on each clinical image to view real restoration results.', 'developer-starter-pro' ); ?></p>
		</div>

		<div class="developer-starter-pro-ba-grid">

			<?php
			$cases_query = new WP_Query( array(
				'post_type'      => 'before_after',
				'posts_per_page' => 3,
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
					?>
					<div class="developer-starter-pro-ba-item" style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 15px; box-shadow: var(--developer-starter-pro-shadow-sm);">
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
						<div style="text-align: center; margin-top: 15px; padding: 10px;">
							<h4 style="margin: 0 0 6px 0; color: var(--developer-starter-pro-secondary);"><?php the_title(); ?></h4>
							<p style="font-size: 0.875rem; color: var(--developer-starter-pro-gray-500); margin: 0;"><?php echo esc_html( get_the_excerpt() ); ?></p>
						</div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php
			// Fill up with format placeholders to ensure at least 2 cards are shown
			while ( $count < 2 ) :
				$count++;
				?>
				<div class="developer-starter-pro-ba-item placeholder-card" style="background: var(--developer-starter-pro-gray-50); border: 1px dashed var(--developer-starter-pro-gray-300); border-radius: var(--developer-starter-pro-radius-lg); padding: 15px; box-shadow: var(--developer-starter-pro-shadow-sm); display: flex; flex-direction: column; justify-content: space-between; min-height: 380px;">
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

		<div class="developer-starter-pro-section-cta" style="margin-top: 40px; text-align: center;">
			<a href="<?php echo esc_url( home_url( '/before-after/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
				<?php esc_html_e( 'View All Cases', 'developer-starter-pro' ); ?>
			</a>
		</div>

	</div>
</section>
