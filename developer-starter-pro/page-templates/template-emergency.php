<?php
/**
 * Template Name: Emergency Care
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(30, 41, 59, 0.05) 100%); border-bottom: 1px solid var(--developer-starter-pro-gray-200);">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 64px 0; text-align: center;">
				<span class="developer-starter-pro-section-badge" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;"><?php esc_html_e( 'Urgent Attention', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title" style="font-size: 2.75rem; font-weight: 800; color: var(--developer-starter-pro-secondary);"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle" style="max-width: 650px; margin-inline: auto;"><?php esc_html_e( 'Have a dental emergency? Read our immediate advice tips below and call our 24/7 emergency hotline for priority assistance.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Emergency Contact Hotline -->
	<section class="developer-starter-pro-section" style="background: var(--developer-starter-pro-white);">
		<div class="developer-starter-pro-container" style="max-width: 800px; text-align: center;">
			<div class="emergency-hotline-card" style="background: #FEF2F2; border: 2px solid #FCA5A5; border-radius: 16px; padding: 48px; box-shadow: var(--developer-starter-pro-shadow-lg);">
				<span style="font-size: 3.5rem; display: block; margin-bottom: 12px; animation: pulse 2s infinite;">☎️</span>
				<h2 style="font-family: var(--developer-starter-pro-font-heading); font-size: 2rem; color: #991B1B; margin: 0 0 10px 0;"><?php esc_html_e( '24/7 Dental Emergency Hotline', 'developer-starter-pro' ); ?></h2>
				<p style="color: #7F1D1D; font-size: 1.125rem; margin: 0 0 28px 0; font-weight: 500;"><?php esc_html_e( 'Call us now to reserve a priority surgical slot.', 'developer-starter-pro' ); ?></p>
				
				<?php $emergency_phone = developer_starter_pro_get_option( 'clinic_phone', '1-800-DENTAL' ); ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $emergency_phone ) ); ?>" class="developer-starter-pro-btn" style="background: #EF4444; color: #fff; padding: 18px 40px; font-size: 1.25rem; font-weight: 800; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; box-shadow: 0 10px 15px -3px rgba(239,68,68,0.3); transition: all 0.2s ease;">
					<span><?php echo esc_html( $emergency_phone ); ?></span>
				</a>
			</div>
		</div>
	</section>

	<!-- Immediate Help Instructions -->
	<section class="developer-starter-pro-section" style="background: var(--developer-starter-pro-gray-50); border-top: 1px solid var(--developer-starter-pro-gray-200); border-bottom: 1px solid var(--developer-starter-pro-gray-200);">
		<div class="developer-starter-pro-container">
			
			<div class="developer-starter-pro-section-header">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Clinical Tips', 'developer-starter-pro' ); ?></span>
				<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Immediate Steps for Common Emergencies', 'developer-starter-pro' ); ?></h2>
			</div>

			<div class="emergency-advice-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-top: 40px;">
				
				<!-- Emergency Case 1 -->
				<div class="advice-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 35px; box-shadow: var(--developer-starter-pro-shadow-sm);">
					<h3 style="font-size: 1.25rem; color: #991B1B; margin: 0 0 12px 0; font-weight: 700;"><?php esc_html_e( 'Knocked-Out Tooth', 'developer-starter-pro' ); ?></h3>
					<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'Keep the tooth moist. Avoid touching the root. Gently try placing it back in the socket, or store it in a container of milk or saline solution. Contact us within 60 minutes.', 'developer-starter-pro' ); ?></p>
				</div>

				<!-- Emergency Case 2 -->
				<div class="advice-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 35px; box-shadow: var(--developer-starter-pro-shadow-sm);">
					<h3 style="font-size: 1.25rem; color: #991B1B; margin: 0 0 12px 0; font-weight: 700;"><?php esc_html_e( 'Severe Toothache', 'developer-starter-pro' ); ?></h3>
					<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'Rinse your mouth with warm saline. Gently floss around the sore tooth to remove food particles. Apply a cold compress to your cheek to reduce swelling. Do not place aspirin directly on the gums.', 'developer-starter-pro' ); ?></p>
				</div>

				<!-- Emergency Case 3 -->
				<div class="advice-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 35px; box-shadow: var(--developer-starter-pro-shadow-sm);">
					<h3 style="font-size: 1.25rem; color: #991B1B; margin: 0 0 12px 0; font-weight: 700;"><?php esc_html_e( 'Lost Filling or Crown', 'developer-starter-pro' ); ?></h3>
					<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'Protect the sensitive cavity. Apply temporary dental cement or sugarless gum. Keep the lost crown safe and bring it to our emergency room so we can attempt to re-cement it.', 'developer-starter-pro' ); ?></p>
				</div>

			</div>

		</div>
	</section>

</main>

<style>
@keyframes pulse {
	0% { transform: scale(1); }
	50% { transform: scale(1.05); }
	100% { transform: scale(1); }
}
body.dark-mode .advice-card,
body.dark-mode .developer-starter-pro-section[style*="white"] {
	background: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode .emergency-hotline-card {
	background: #3B0712 !important;
	border-color: #991B1B !important;
	color: #FECDD3 !important;
}
body.dark-mode .emergency-hotline-card h2,
body.dark-mode .emergency-hotline-card p {
	color: #FFE4E6 !important;
}
</style>

<?php
get_footer();
