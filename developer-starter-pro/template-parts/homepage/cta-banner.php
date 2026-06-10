<?php
/**
 * Template Part: Homepage CTA Banner Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<section class="developer-starter-pro-cta-banner-section" style="position: relative; overflow: hidden; background: linear-gradient(135deg, var(--developer-starter-pro-primary) 0%, var(--developer-starter-pro-secondary) 100%); padding: 80px 0; color: #fff; text-align: center;">
	<!-- Overlay patterns -->
	<div class="cta-overlay-bg" style="position: absolute; inset: 0; opacity: 0.1; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 24px 24px; pointer-events: none;"></div>
	
	<div class="developer-starter-pro-container" style="max-width: 800px; position: relative; z-index: 2;">
		<span style="display: inline-block; padding: 6px 16px; background: rgba(255,255,255,0.15); border-radius: 9999px; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; margin-bottom: 20px; letter-spacing: 0.05em;"><?php esc_html_e( 'Schedule Your Visit', 'developer-starter-pro' ); ?></span>
		<h2 style="font-family: var(--developer-starter-pro-font-heading); font-size: 2.5rem; font-weight: 800; line-height: 1.2; margin: 0 0 16px 0; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.15);"><?php esc_html_e( 'Book Your Appointment Today & Get a Healthier Smile', 'developer-starter-pro' ); ?></h2>
		<p style="font-size: 1.125rem; margin: 0 0 35px 0; color: rgba(255,255,255,0.9); line-height: 1.6; max-width: 600px; margin-inline: auto;"><?php esc_html_e( 'Use our interactive scheduling wizard to select your treatment, pick a physician, and confirm your slot in under 2 minutes.', 'developer-starter-pro' ); ?></p>
		
		<div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
			<a href="<?php echo esc_url( developer_starter_pro_get_booking_url() ); ?>" class="developer-starter-pro-btn" style="background: #fff; color: var(--developer-starter-pro-primary); padding: 16px 36px; font-size: 1.0625rem; font-weight: 700; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: none; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
				<?php esc_html_e( 'Book Appointment Now', 'developer-starter-pro' ); ?>
			</a>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', developer_starter_pro_get_option( 'clinic_phone', '' ) ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline" style="border-color: rgba(255,255,255,0.4); color: #fff; padding: 16px 36px; font-size: 1.0625rem; font-weight: 700; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s ease;">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72"/></svg>
				<?php esc_html_e( 'Call Emergency Desk', 'developer-starter-pro' ); ?>
			</a>
		</div>
	</div>
</section>
