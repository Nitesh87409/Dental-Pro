<?php
/**
 * Template Name: Privacy Policy
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
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'How we handle patient records, data collection protocols, and HIPAA privacy compliance.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Privacy Content -->
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
								<?php esc_html_e( 'At Apex Dental Care, we take patient confidentiality and data security very seriously. This Privacy Policy describes how we collect, store, share, and protect your personal information and protected health information (PHI) in compliance with HIPAA guidelines and local medical regulations.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '1. Information We Collect', 'developer-starter-pro' ); ?>
							</h2>
							<p><?php esc_html_e( 'We collect information directly from you when you schedule appointments, fill out intake forms, register on our website, or interact with our clinical reception staff. This information includes:', 'developer-starter-pro' ); ?></p>
							<ul style="padding-left: 20px; margin-bottom: 24px; list-style-type: disc;">
								<li style="margin-bottom: 8px;"><strong><?php esc_html_e( 'Personal details:', 'developer-starter-pro' ); ?></strong> <?php esc_html_e( 'Name, date of birth, contact numbers, email address, and home address.', 'developer-starter-pro' ); ?></li>
								<li style="margin-bottom: 8px;"><strong><?php esc_html_e( 'Medical history:', 'developer-starter-pro' ); ?></strong> <?php esc_html_e( 'Intake charts, past dental surgeries, current medications, allergies, and oral checkup records.', 'developer-starter-pro' ); ?></li>
								<li style="margin-bottom: 8px;"><strong><?php esc_html_e( 'Insurance & billing details:', 'developer-starter-pro' ); ?></strong> <?php esc_html_e( 'Insurance policy numbers, group numbers, coverage details, and payment histories.', 'developer-starter-pro' ); ?></li>
							</ul>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '2. Protected Health Information (PHI) & HIPAA', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'Your medical and dental records are classified as Protected Health Information (PHI) and are guarded under the Health Insurance Portability and Accountability Act (HIPAA). We use and disclose your PHI solely for coordinating your diagnosis, treatment, billing operations, and clinical healthcare workflows.', 'developer-starter-pro' ); ?>
							</p>
							<p>
								<?php esc_html_e( 'We will never sell, rent, or distribute your PHI to external marketing companies, third-party brokers, or advertisers under any circumstances.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '3. Data Retention & Safeguards', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'Apex Dental Care employs industry-standard technical, physical, and administrative safeguards to keep your records secure. Website traffic is encrypted using Secure Sockets Layer (SSL) certificates, and access to clinic management databases is restricted to authorized medical staff with unique log credentials.', 'developer-starter-pro' ); ?>
							</p>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '4. Patient Rights & Record Access', 'developer-starter-pro' ); ?>
							</h2>
							<p><?php esc_html_e( 'As our patient, you have the right to:', 'developer-starter-pro' ); ?></p>
							<ul style="padding-left: 20px; margin-bottom: 24px; list-style-type: disc;">
								<li style="margin-bottom: 8px;"><?php esc_html_e( 'Request a copy of your dental records and digital X-rays.', 'developer-starter-pro' ); ?></li>
								<li style="margin-bottom: 8px;"><?php esc_html_e( 'Request corrections to errors in your contact details or insurance files.', 'developer-starter-pro' ); ?></li>
								<li style="margin-bottom: 8px;"><?php esc_html_e( 'Revoke previous authorizations for shared treatment details at any time.', 'developer-starter-pro' ); ?></li>
							</ul>

							<h2 style="font-size: 1.4rem; color: var(--developer-starter-pro-secondary); margin-top: 36px; margin-bottom: 16px; font-family: var(--developer-starter-pro-font-heading); border-bottom: 1px solid var(--developer-starter-pro-gray-200); padding-bottom: 8px;">
								<?php esc_html_e( '5. Policy Amendments & Contact', 'developer-starter-pro' ); ?>
							</h2>
							<p>
								<?php esc_html_e( 'We may update our Privacy Policy periodically to match changes in healthcare privacy laws. For any questions regarding your data privacy rights, please contact our privacy compliance officer directly at our clinic address.', 'developer-starter-pro' ); ?>
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
