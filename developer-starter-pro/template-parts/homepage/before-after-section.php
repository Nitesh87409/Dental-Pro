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

		<div class="developer-starter-pro-ba-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; margin-top: 40px;">

			<!-- Case 1: Whitening -->
			<div class="developer-starter-pro-ba-item" style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 15px; box-shadow: var(--developer-starter-pro-shadow-sm);">
				<?php
				echo do_shortcode( '[dental_before_after title="Laser Teeth Whitening" before_url="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=600" after_url="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=600" before_label="Before Treatment" after_label="After Whitening"]' );
				?>
				<div style="text-align: center; margin-top: 15px; padding: 10px;">
					<h4 style="margin: 0 0 6px 0; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Cosmetic Teeth Whitening', 'developer-starter-pro' ); ?></h4>
					<p style="font-size: 0.875rem; color: var(--developer-starter-pro-gray-500); margin: 0;"><?php esc_html_e( 'Results achieved after a single 60-minute in-office teeth laser whitening session.', 'developer-starter-pro' ); ?></p>
				</div>
			</div>

			<!-- Case 2: Veneers -->
			<div class="developer-starter-pro-ba-item" style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 15px; box-shadow: var(--developer-starter-pro-shadow-sm);">
				<?php
				echo do_shortcode( '[dental_before_after title="Porcelain Veneers Restorations" before_url="https://images.unsplash.com/photo-1579684389782-64d84b5e902a?auto=format&fit=crop&q=80&w=600" after_url="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=600" before_label="Crooked Teeth" after_label="Perfect Veneers"]' );
				?>
				<div style="text-align: center; margin-top: 15px; padding: 10px;">
					<h4 style="margin: 0 0 6px 0; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Porcelain Veneers', 'developer-starter-pro' ); ?></h4>
					<p style="font-size: 0.875rem; color: var(--developer-starter-pro-gray-500); margin: 0;"><?php esc_html_e( 'Full upper arch smile restoration using custom dental porcelain veneers.', 'developer-starter-pro' ); ?></p>
				</div>
			</div>

		</div>

		<div class="developer-starter-pro-section-cta" style="margin-top: 40px; text-align: center;">
			<a href="<?php echo esc_url( home_url( '/before-after/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
				<?php esc_html_e( 'View All Cases', 'developer-starter-pro' ); ?>
			</a>
		</div>

	</div>
</section>
