<?php
/**
 * Template Name: Video Consultation
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner" style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.05) 0%, rgba(30, 41, 59, 0.05) 100%);">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 64px 0; text-align: center;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Teledentistry', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title" style="font-size: 2.75rem; font-weight: 800;"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle" style="max-width: 650px; margin-inline: auto;"><?php esc_html_e( 'Consult with our leading dental experts virtually from the comfort of your home. Convenient, secure, and professional advice.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Process Steps -->
	<section class="developer-starter-pro-section" style="background: var(--developer-starter-pro-white);">
		<div class="developer-starter-pro-container">
			
			<div class="developer-starter-pro-section-header">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'How it Works', 'developer-starter-pro' ); ?></span>
				<h2 class="developer-starter-pro-section-title"><?php esc_html_e( '3 Simple Steps to Virtual Dental Care', 'developer-starter-pro' ); ?></h2>
			</div>

			<div class="steps-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 40px;">
				
				<div class="step-card" style="text-align: center; padding: 40px 30px; background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); position: relative;">
					<div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; border-radius: 50%; background: var(--developer-starter-pro-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">1</div>
					<div style="font-size: 2.5rem; margin-bottom: 20px;">📅</div>
					<h3 style="font-size: 1.25rem; margin: 0 0 10px 0; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Book Online Slot', 'developer-starter-pro' ); ?></h3>
					<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'Choose "Virtual Consultation" in the booking wizard, choose a doctor, and pick an available date and time.', 'developer-starter-pro' ); ?></p>
				</div>

				<div class="step-card" style="text-align: center; padding: 40px 30px; background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); position: relative;">
					<div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; border-radius: 50%; background: var(--developer-starter-pro-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">2</div>
					<div style="font-size: 2.5rem; margin-bottom: 20px;">✉️</div>
					<h3 style="font-size: 1.25rem; margin: 0 0 10px 0; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Receive Video Link', 'developer-starter-pro' ); ?></h3>
					<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'Our system generates a secure, private Zoom or Google Meet URL sent straight to your email inbox with preparation guidelines.', 'developer-starter-pro' ); ?></p>
				</div>

				<div class="step-card" style="text-align: center; padding: 40px 30px; background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); position: relative;">
					<div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; border-radius: 50%; background: var(--developer-starter-pro-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">3</div>
					<div style="font-size: 2.5rem; margin-bottom: 20px;">💻</div>
					<h3 style="font-size: 1.25rem; margin: 0 0 10px 0; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Join Consultation', 'developer-starter-pro' ); ?></h3>
					<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'Click the email video link on your smartphone, tablet, or laptop. Talk to your dentist face-to-face in high definition.', 'developer-starter-pro' ); ?></p>
				</div>

			</div>

		</div>
	</section>

	<!-- Technical Pre-checks & CTA -->
	<section class="developer-starter-pro-section" style="background: var(--developer-starter-pro-gray-50); border-top: 1px solid var(--developer-starter-pro-gray-200); border-bottom: 1px solid var(--developer-starter-pro-gray-200);">
		<div class="developer-starter-pro-container" style="max-width: 800px; text-align: center;">
			<div style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 16px; padding: 50px; box-shadow: var(--developer-starter-pro-shadow-md);">
				<span style="font-size: 2.5rem; display: block; margin-bottom: 15px;">🔒</span>
				<h3 style="font-size: 1.5rem; margin: 0 0 10px 0; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'HIPAA-Compliant & Secure Data', 'developer-starter-pro' ); ?></h3>
				<p style="color: var(--developer-starter-pro-gray-500); line-height: 1.6; margin: 0 0 30px 0; font-size: 1rem;"><?php esc_html_e( 'Your medical consultation is encrypted and secure. We comply with all medical data privacy regulations to ensure your diagnosis details and chat logs remain confidential.', 'developer-starter-pro' ); ?></p>
				
				<div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
					<a href="<?php echo esc_url( developer_starter_pro_get_booking_url() ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="padding: 15px 35px; font-weight: 700; font-size: 1.0625rem;">
						<?php esc_html_e( 'Book Video Consultation', 'developer-starter-pro' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline" style="padding: 15px 35px; font-weight: 700; font-size: 1.0625rem;">
						<?php esc_html_e( 'Contact Helpdesk', 'developer-starter-pro' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

</main>

<style>
body.dark-mode .step-card,
body.dark-mode .developer-starter-pro-section[style*="white"] {
	background: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode div[style*="white"] {
	background: #0F172A !important;
	border-color: #334155 !important;
}
</style>

<?php
get_footer();
