<?php
/**
 * Template Name: Insurance Details
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
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Coverage Options', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Information about accepted insurance plans, direct billing workflows, and flexible clinical finance options.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Insurance Guide Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">
			
			<div class="insurance-guide-split" style="display: grid; grid-template-columns: 1fr 350px; gap: 40px;">
				
				<!-- Main Content -->
				<div>
					<h2 style="font-size: 1.5rem; margin-top: 0; border-bottom: 2px solid var(--developer-starter-pro-primary-light); padding-bottom: 10px; margin-bottom: 20px;"><?php esc_html_e( 'Direct Direct Billing Insurance Providers', 'developer-starter-pro' ); ?></h2>
					<p style="color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-size: 0.9375rem; margin-bottom: 24px;"><?php esc_html_e( 'We process direct insurance claims with major providers, minimizing your out-of-pocket costs at check-out. Bring your insurance membership ID card and photo identification on your first dental visit.', 'developer-starter-pro' ); ?></p>
					
					<!-- Grid of Providers -->
					<div class="provider-logos-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; margin-bottom: 40px;">
						<div style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Delta Dental', 'developer-starter-pro' ); ?></div>
						<div style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Aetna', 'developer-starter-pro' ); ?></div>
						<div style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Cigna', 'developer-starter-pro' ); ?></div>
						<div style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'MetLife', 'developer-starter-pro' ); ?></div>
						<div style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'BCBS Network', 'developer-starter-pro' ); ?></div>
						<div style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'UnitedHealthcare', 'developer-starter-pro' ); ?></div>
					</div>

					<h2 style="font-size: 1.5rem; border-bottom: 2px solid var(--developer-starter-pro-primary-light); padding-bottom: 10px; margin-bottom: 20px;"><?php esc_html_e( 'Frequently Asked Billing Questions', 'developer-starter-pro' ); ?></h2>
					<div style="display: flex; flex-direction: column; gap: 20px;">
						<div>
							<h4 style="margin: 0 0 6px 0; font-size: 1.0625rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'What if my plan is out-of-network?', 'developer-starter-pro' ); ?></h4>
							<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.5;"><?php esc_html_e( 'We can still process your claims! Out-of-network rates and standard deductibles will apply. Contact our reception desk for details.', 'developer-starter-pro' ); ?></p>
						</div>
						<div>
							<h4 style="margin: 0 0 6px 0; font-size: 1.0625rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Does insurance cover cosmetic procedures?', 'developer-starter-pro' ); ?></h4>
							<p style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.5;"><?php esc_html_e( 'Most basic plans do not cover purely cosmetic treatments (such as veneers or whitening). We offer financing installment programs for these cases.', 'developer-starter-pro' ); ?></p>
						</div>
					</div>
				</div>

				<!-- Sidebar Card: Checker Integration -->
				<div>
					<div style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); padding: 30px; border-radius: 12px; box-shadow: var(--developer-starter-pro-shadow-sm); text-align: center;">
						<span style="font-size: 2.5rem; display: block; margin-bottom: 12px;">🔍</span>
						<h3 style="margin-top: 0; margin-bottom: 10px; font-size: 1.25rem;"><?php esc_html_e( 'Insurance Checker', 'developer-starter-pro' ); ?></h3>
						<p style="font-size: 0.875rem; color: var(--developer-starter-pro-gray-500); line-height: 1.5; margin-bottom: 20px;"><?php esc_html_e( 'Check if your exact insurance provider and dental plan terms are in-network.', 'developer-starter-pro' ); ?></p>
						
						<?php
						$checker_url = home_url( '/insurance-checker/' );
						$checker_pages = get_pages( array(
							'meta_key'   => '_wp_page_template',
							'meta_value' => 'page-templates/template-insurance-checker.php'
						) );
						if ( ! empty( $checker_pages ) ) {
							$checker_url = get_permalink( $checker_pages[0]->ID );
						}
						?>
						<a href="<?php echo esc_url( $checker_url ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="width: 100%; justify-content: center; font-weight: 700;">
							<?php esc_html_e( 'Launch Checker Tool', 'developer-starter-pro' ); ?>
						</a>
					</div>
				</div>

			</div>

		</div>
	</section>

</main>

<style>
body.dark-mode .provider-logos-grid div,
body.dark-mode .insurance-guide-split div[style*="background"] {
	background: #1E293B !important;
	border-color: #334155 !important;
	color: #CBD5E1 !important;
}
@media (max-width: 768px) {
	.insurance-guide-split {
		grid-template-columns: 1fr;
	}
}
</style>

<?php
get_footer();
