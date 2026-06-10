<?php
/**
 * Template Name: Insurance Checker
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
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Coverage & Billing', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Search and verify if your dental insurance provider is accepted at our clinic.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Insurance Checker Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container" style="max-width: 900px;">

			<!-- Search Bar -->
			<div class="developer-starter-pro-insurance-search" style="margin-bottom: 40px; position: relative;">
				<input type="text" id="insurance-search-input" placeholder="<?php esc_attr_e( 'Type your insurance provider name (e.g. Delta Dental, Aetna)...', 'developer-starter-pro' ); ?>" style="width: 100%; padding: 16px 24px; font-size: 1.125rem; border: 2px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); outline: none; transition: var(--developer-starter-pro-transition-fast);" />
				<span style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: var(--developer-starter-pro-gray-400); font-size: 1.25rem;">🔍</span>
			</div>

			<!-- Insurance Provider List -->
			<div id="insurance-providers-list" style="display: flex; flex-direction: column; gap: 20px;">

				<!-- Provider 1 -->
				<div class="insurance-provider-card" data-name="delta dental" style="display: flex; align-items: center; justify-content: space-between; padding: 24px; background: var(--developer-starter-pro-white); border-radius: var(--developer-starter-pro-radius-lg); box-shadow: var(--developer-starter-pro-shadow-md); border: 1px solid var(--developer-starter-pro-gray-200); transition: var(--developer-starter-pro-transition-fast);">
					<div>
						<h3 style="margin-bottom: 6px; font-size: 1.25rem;">Delta Dental</h3>
						<p style="margin: 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Covers: 100% Preventative, 80% Basic Restorative, 50% Major.', 'developer-starter-pro' ); ?></p>
					</div>
					<span class="provider-badge in-network" style="padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: #10B981; border-radius: var(--developer-starter-pro-radius-full); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'In-Network', 'developer-starter-pro' ); ?></span>
				</div>

				<!-- Provider 2 -->
				<div class="insurance-provider-card" data-name="aetna" style="display: flex; align-items: center; justify-content: space-between; padding: 24px; background: var(--developer-starter-pro-white); border-radius: var(--developer-starter-pro-radius-lg); box-shadow: var(--developer-starter-pro-shadow-md); border: 1px solid var(--developer-starter-pro-gray-200); transition: var(--developer-starter-pro-transition-fast);">
					<div>
						<h3 style="margin-bottom: 6px; font-size: 1.25rem;">Aetna Dental</h3>
						<p style="margin: 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Covers: 100% Preventative, 80% Basic Restorative, 50% Major.', 'developer-starter-pro' ); ?></p>
					</div>
					<span class="provider-badge in-network" style="padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: #10B981; border-radius: var(--developer-starter-pro-radius-full); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'In-Network', 'developer-starter-pro' ); ?></span>
				</div>

				<!-- Provider 3 -->
				<div class="insurance-provider-card" data-name="metlife cigna" style="display: flex; align-items: center; justify-content: space-between; padding: 24px; background: var(--developer-starter-pro-white); border-radius: var(--developer-starter-pro-radius-lg); box-shadow: var(--developer-starter-pro-shadow-md); border: 1px solid var(--developer-starter-pro-gray-200); transition: var(--developer-starter-pro-transition-fast);">
					<div>
						<h3 style="margin-bottom: 6px; font-size: 1.25rem;">MetLife Dental</h3>
						<p style="margin: 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Covers: 80% Preventative, 70% Basic Restorative, 40% Major.', 'developer-starter-pro' ); ?></p>
					</div>
					<span class="provider-badge partial-network" style="padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: #F59E0B; border-radius: var(--developer-starter-pro-radius-full); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'Partial (Co-Pay)', 'developer-starter-pro' ); ?></span>
				</div>

				<!-- Provider 4 -->
				<div class="insurance-provider-card" data-name="cigna dental" style="display: flex; align-items: center; justify-content: space-between; padding: 24px; background: var(--developer-starter-pro-white); border-radius: var(--developer-starter-pro-radius-lg); box-shadow: var(--developer-starter-pro-shadow-md); border: 1px solid var(--developer-starter-pro-gray-200); transition: var(--developer-starter-pro-transition-fast);">
					<div>
						<h3 style="margin-bottom: 6px; font-size: 1.25rem;">Cigna Dental</h3>
						<p style="margin: 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Covers: 100% Preventative, 80% Basic Restorative, 50% Major.', 'developer-starter-pro' ); ?></p>
					</div>
					<span class="provider-badge in-network" style="padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: #10B981; border-radius: var(--developer-starter-pro-radius-full); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'In-Network', 'developer-starter-pro' ); ?></span>
				</div>

				<!-- Provider 5 -->
				<div class="insurance-provider-card" data-name="blue cross blue shield bcbs" style="display: flex; align-items: center; justify-content: space-between; padding: 24px; background: var(--developer-starter-pro-white); border-radius: var(--developer-starter-pro-radius-lg); box-shadow: var(--developer-starter-pro-shadow-md); border: 1px solid var(--developer-starter-pro-gray-200); transition: var(--developer-starter-pro-transition-fast);">
					<div>
						<h3 style="margin-bottom: 6px; font-size: 1.25rem;">Blue Cross Blue Shield</h3>
						<p style="margin: 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Covers: 90% Preventative, 80% Basic Restorative, 50% Major.', 'developer-starter-pro' ); ?></p>
					</div>
					<span class="provider-badge in-network" style="padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: #10B981; border-radius: var(--developer-starter-pro-radius-full); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'In-Network', 'developer-starter-pro' ); ?></span>
				</div>

				<!-- Provider 6 -->
				<div class="insurance-provider-card" data-name="guardian dental" style="display: flex; align-items: center; justify-content: space-between; padding: 24px; background: var(--developer-starter-pro-white); border-radius: var(--developer-starter-pro-radius-lg); box-shadow: var(--developer-starter-pro-shadow-md); border: 1px solid var(--developer-starter-pro-gray-200); transition: var(--developer-starter-pro-transition-fast);">
					<div>
						<h3 style="margin-bottom: 6px; font-size: 1.25rem;">Guardian Dental</h3>
						<p style="margin: 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Covers: 100% Preventative, 70% Basic Restorative, 40% Major.', 'developer-starter-pro' ); ?></p>
					</div>
					<span class="provider-badge partial-network" style="padding: 6px 14px; background: rgba(245, 158, 11, 0.1); color: #F59E0B; border-radius: var(--developer-starter-pro-radius-full); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'Partial (Co-Pay)', 'developer-starter-pro' ); ?></span>
				</div>

				<!-- Provider 7 -->
				<div class="insurance-provider-card" data-name="unitedhealthcare uhc" style="display: flex; align-items: center; justify-content: space-between; padding: 24px; background: var(--developer-starter-pro-white); border-radius: var(--developer-starter-pro-radius-lg); box-shadow: var(--developer-starter-pro-shadow-md); border: 1px solid var(--developer-starter-pro-gray-200); transition: var(--developer-starter-pro-transition-fast);">
					<div>
						<h3 style="margin-bottom: 6px; font-size: 1.25rem;">UnitedHealthcare</h3>
						<p style="margin: 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Covers: Out-of-network rates apply for restorative and major operations.', 'developer-starter-pro' ); ?></p>
					</div>
					<span class="provider-badge out-network" style="padding: 6px 14px; background: rgba(239, 68, 68, 0.1); color: #EF4444; border-radius: var(--developer-starter-pro-radius-full); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'Out of Network', 'developer-starter-pro' ); ?></span>
				</div>

			</div>

			<!-- No Results message -->
			<div id="no-insurance-results" style="display: none; text-align: center; padding: 40px; background: var(--developer-starter-pro-gray-50); border-radius: var(--developer-starter-pro-radius-lg); border: 1px dashed var(--developer-starter-pro-gray-300);">
				<h3 style="margin-bottom: 8px; color: var(--developer-starter-pro-gray-700);"><?php esc_html_e( 'Provider Not Found', 'developer-starter-pro' ); ?></h3>
				<p style="color: var(--developer-starter-pro-gray-500); max-width: 500px; margin: 0 auto 20px;"><?php esc_html_e( 'We may still accept your provider on out-of-network terms. Contact our administrative helpdesk to check manual coverage terms.', 'developer-starter-pro' ); ?></p>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', developer_starter_pro_get_option( 'clinic_phone', '' ) ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
					📞 <?php esc_html_e( 'Call Admin Desk', 'developer-starter-pro' ); ?>
				</a>
			</div>

			<!-- Quick Info CTA -->
			<div class="developer-starter-pro-section-cta" style="margin-top: 50px;">
				<h3><?php esc_html_e( 'Have a Question About Your Insurance Plan?', 'developer-starter-pro' ); ?></h3>
				<p style="color: var(--developer-starter-pro-gray-500); max-width: 600px; margin: 10px auto 25px;"><?php esc_html_e( 'Bring your insurance ID card on your first visit. Our administrative desk handles all insurance billing directly with your provider.', 'developer-starter-pro' ); ?></p>
				<a href="<?php echo esc_url( developer_starter_pro_get_booking_url() ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
					<?php esc_html_e( 'Schedule Appointment Now', 'developer-starter-pro' ); ?>
				</a>
			</div>

		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var searchInput = document.getElementById('insurance-search-input');
	var cards = document.querySelectorAll('.insurance-provider-card');
	var noResults = document.getElementById('no-insurance-results');

	if (searchInput) {
		searchInput.addEventListener('input', function(e) {
			var query = e.target.value.toLowerCase().trim();
			var visibleCount = 0;

			cards.forEach(function(card) {
				var name = card.getAttribute('data-name');
				if (name.indexOf(query) !== -1 || query === '') {
					card.style.display = 'flex';
					visibleCount++;
				} else {
					card.style.display = 'none';
				}
			});

			if (visibleCount === 0) {
				noResults.style.display = 'block';
			} else {
				noResults.style.display = 'none';
			}
		});
	}
});
</script>

<style>
body.dark-mode #insurance-search-input {
	background-color: #0F172A;
	border-color: #334155;
	color: #F8FAFC;
}
body.dark-mode #insurance-search-input:focus {
	border-color: var(--developer-starter-pro-primary);
}
body.dark-mode .insurance-provider-card {
	background-color: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode #no-insurance-results {
	background-color: #0F172A !important;
	border-color: #334155 !important;
}
</style>

<?php
get_footer();
