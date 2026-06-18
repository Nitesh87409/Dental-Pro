<?php
/**
 * Template Name: Terms & Conditions
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
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Legal & Compliance', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Agreement guidelines, scheduling policies, and payment terms for clinical treatments.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Terms Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container" style="max-width: 800px;">
			
			<div class="dp-legal-content" style="color: var(--developer-starter-pro-gray-500); line-height: 1.7; font-size: 0.9375rem;">
				
				<?php 
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						$content = get_the_content();
						if ( ! empty( trim( $content ) ) ) {
							the_content();
						} else {
							?>
							<p style="margin-top: 0; margin-bottom: 30px;">
								<?php esc_html_e( 'Welcome to the Apex Dental Care website. By accessing this website or scheduling clinical treatments with us, you agree to comply with and be bound by the following Terms & Conditions. Please read these terms carefully before scheduling your dental appointments.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '1. Clinical Treatment Agreement', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'All dental treatments, checkups, surgeries, and consultations provided at our clinic are based on professional clinical assessments. Before any treatment begins, you will be informed of the diagnosed condition, proposed options, estimated costs, and potential outcomes. Your consent is required before performing clinical procedures.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '2. Appointment Scheduling & Cancellations', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'We value your time and allocate dedicated time slots for each patient. If you need to cancel or reschedule your dental appointment, you must provide at least 24 hours advance notification. Failure to notify the clinic within 24 hours may result in a standard cancellation fee.', 'developer-starter-pro' ); ?>
							</p>
							<p>
								<?php esc_html_e( 'Please arrive 10-15 minutes prior to your scheduled time to fill out necessary clinical intake forms and verify insurance coverage.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '3. Financial Policies & Insurance Billing', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'Payment is required at the time treatment services are rendered. We accept cash, credit cards, and direct insurance billing claims. If we process direct insurance billing for you, you remain responsible for paying any co-payments, deductibles, or non-covered service balances at check-out.', 'developer-starter-pro' ); ?>
							</p>
							<p>
								<?php esc_html_e( 'For major procedures (implants, crowns, orthodontic treatments), we offer interest-free monthly installment financing plans which must be agreed upon and signed prior to beginning the procedure.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '4. Emergency Services & Boundaries', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'We provide after-hours emergency support for severe trauma, pain, or bleeding. However, our after-hours clinical assistance line is strictly limited to dental emergencies. For general medical emergencies, please dial local emergency services immediately.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '5. Modifications to Terms', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'Apex Dental Care reserves the right to modify these Terms & Conditions at any time without prior notice. Any updates will be posted directly to this page, and your continued usage of our clinical services implies acceptance of the updated terms.', 'developer-starter-pro' ); ?>
							</p>

							<p style="margin-top: 40px; font-size: 0.8125rem; color: var(--developer-starter-pro-gray-400);">
								<?php printf( esc_html__( 'Last updated: %s', 'developer-starter-pro' ), 'June 18, 2026' ); ?>
							</p>
							<?php
						}
					endwhile;
				endif;
				?>
			</div>

		</div>
	</section>

</main>

<style>
body.dark-mode .dp-legal-content h2 {
	color: #F8FAFC !important;
	border-bottom-color: #334155 !important;
}
body.dark-mode .dp-legal-content {
	color: #94A3B8 !important;
}
</style>

<?php
get_footer();
