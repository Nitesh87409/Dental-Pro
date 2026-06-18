<?php
/**
 * Template Part: Homepage Why Choose Us Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$why_choose_us_badge    = developer_starter_pro_get_option( 'why_choose_us_badge', 'Our Core Strengths' );
$why_choose_us_title    = developer_starter_pro_get_option( 'why_choose_us_title', 'Why Choose DentalPro Elite?' );
$why_choose_us_subtitle = developer_starter_pro_get_option( 'why_choose_us_subtitle', 'We combine clinical precision, advanced technology, and personalized patient care to redefine your dental experience.' );
$why_choose_us_benefits = developer_starter_pro_get_option( 'why_choose_us_benefits', array() );

if ( empty( $why_choose_us_benefits ) ) {
	// Fallback to defaults if empty.
	$why_choose_us_benefits = developer_starter_pro_get_default_options()['why_choose_us_benefits'];
}
?>

<section class="developer-starter-pro-section why-choose-us-section" id="why-choose-us" style="background: var(--developer-starter-pro-gray-50); border-top: 1px solid var(--developer-starter-pro-gray-200); border-bottom: 1px solid var(--developer-starter-pro-gray-200);">
	<div class="developer-starter-pro-container">
		
		<div class="developer-starter-pro-section-header">
			<?php if ( ! empty( $why_choose_us_badge ) ) : ?>
				<span class="developer-starter-pro-section-badge"><?php echo esc_html( $why_choose_us_badge ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $why_choose_us_title ) ) : ?>
				<h2 class="developer-starter-pro-section-title"><?php echo esc_html( $why_choose_us_title ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $why_choose_us_subtitle ) ) : ?>
				<p class="developer-starter-pro-section-subtitle"><?php echo esc_html( $why_choose_us_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $why_choose_us_benefits ) && is_array( $why_choose_us_benefits ) ) : ?>
			<div class="why-choose-grid">
				<?php foreach ( $why_choose_us_benefits as $benefit ) : ?>
					<div class="benefit-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 35px; box-shadow: var(--developer-starter-pro-shadow-sm); transition: all 0.3s ease;">
						<?php if ( ! empty( $benefit['icon'] ) ) : ?>
							<div class="benefit-icon-wrapper" style="width: 60px; height: 60px; border-radius: 12px; background: var(--developer-starter-pro-primary-light); color: var(--developer-starter-pro-primary); display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
								<?php 
								// Render user-pasted SVG safely using the custom sanitizer helper
								echo developer_starter_pro_sanitize_svg( $benefit['icon'] ); 
								?>
							</div>
						<?php endif; ?>
						<?php if ( ! empty( $benefit['title'] ) ) : ?>
							<h3 style="font-size: 1.25rem; margin: 0 0 12px 0; color: var(--developer-starter-pro-secondary);"><?php echo esc_html( $benefit['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $benefit['description'] ) ) : ?>
							<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php echo esc_html( $benefit['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
