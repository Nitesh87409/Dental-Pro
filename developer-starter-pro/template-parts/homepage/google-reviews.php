<?php
/**
 * Template Part: Homepage Google Reviews Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<section class="developer-starter-pro-section google-reviews-section" id="reviews" style="background: var(--developer-starter-pro-white);">
	<div class="developer-starter-pro-container">
		
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Patient Feedback', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Verified Google Patient Reviews', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Read what our patients say about our dental treatments and customer service quality.', 'developer-starter-pro' ); ?></p>
		</div>

		<!-- Rating Summary Card -->
		<div class="reviews-summary-card" style="display: flex; align-items: center; justify-content: center; gap: 30px; padding: 30px; background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); max-width: 650px; margin: 40px auto 48px; box-shadow: var(--developer-starter-pro-shadow-sm); flex-wrap: wrap;">
			<div style="text-align: center;">
				<div style="font-size: 3.5rem; font-family: var(--developer-starter-pro-font-heading); font-weight: 800; color: var(--developer-starter-pro-secondary); line-height: 1;">4.9</div>
				<div style="color: #f59e0b; font-size: 1.25rem; margin-top: 8px;">★★★★★</div>
				<div style="font-size: 0.8125rem; color: var(--developer-starter-pro-gray-400); text-transform: uppercase; font-weight: 600; margin-top: 4px;"><?php esc_html_e( 'Based on 480+ Reviews', 'developer-starter-pro' ); ?></div>
			</div>
			
			<div style="border-left: 2px solid var(--developer-starter-pro-gray-200); padding-left: 30px; flex: 1; min-width: 200px;">
				<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
					<span style="font-weight: 700; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Google Rating Verified', 'developer-starter-pro' ); ?></span>
					<span style="color: #10b981; font-size: 0.875rem;">✔️</span>
				</div>
				<p style="margin: 0 0 12px 0; font-size: 0.875rem; color: var(--developer-starter-pro-gray-500); line-height: 1.5;"><?php esc_html_e( 'Our clinical and hygiene standards are verified by patient submissions directly on Google Maps.', 'developer-starter-pro' ); ?></p>
				<a href="https://google.com" target="_blank" rel="noopener noreferrer" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--outline" style="padding: 6px 14px; font-size: 0.8125rem;">
					<?php esc_html_e( 'Write a Google Review', 'developer-starter-pro' ); ?>
				</a>
			</div>
		</div>

		<!-- Reviews Grid -->
		<div class="reviews-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">

			<!-- Review 1 -->
			<div class="review-item-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
				<div style="position: absolute; right: 30px; top: 30px; color: var(--developer-starter-pro-gray-200); font-size: 3rem; font-family: Georgia, serif; line-height: 1; pointer-events: none;">“</div>
				<div>
					<div style="color: #f59e0b; margin-bottom: 12px; font-size: 0.875rem;">★★★★★</div>
					<p style="margin: 0 0 20px 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-style: italic;"><?php esc_html_e( 'Absolutely the best dental clinic experience. Dr. Adams explained my veneer procedure with a 3D scanner. The process was completely painless.', 'developer-starter-pro' ); ?></p>
				</div>
				<div style="display: flex; align-items: center; gap: 12px; border-top: 1px solid var(--developer-starter-pro-gray-100); padding-top: 16px;">
					<div style="width: 44px; height: 44px; border-radius: 50%; background: #cbd5e1; font-weight: 700; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.9375rem;">SM</div>
					<div>
						<h4 style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Sarah Mitchell', 'developer-starter-pro' ); ?></h4>
						<span style="font-size: 0.75rem; color: var(--developer-starter-pro-gray-400); display: block;"><?php esc_html_e( 'Patient (Veneers case)', 'developer-starter-pro' ); ?></span>
					</div>
				</div>
			</div>

			<!-- Review 2 -->
			<div class="review-item-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
				<div style="position: absolute; right: 30px; top: 30px; color: var(--developer-starter-pro-gray-200); font-size: 3rem; font-family: Georgia, serif; line-height: 1; pointer-events: none;">“</div>
				<div>
					<div style="color: #f59e0b; margin-bottom: 12px; font-size: 0.875rem;">★★★★★</div>
					<p style="margin: 0 0 20px 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-style: italic;"><?php esc_html_e( 'I had a wisdom tooth extraction emergency. The clinic booked me immediately at midnight. The surgeon was professional and gentle. Excellent 24/7 service!', 'developer-starter-pro' ); ?></p>
				</div>
				<div style="display: flex; align-items: center; gap: 12px; border-top: 1px solid var(--developer-starter-pro-gray-100); padding-top: 16px;">
					<div style="width: 44px; height: 44px; border-radius: 50%; background: #cbd5e1; font-weight: 700; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.9375rem;">JH</div>
					<div>
						<h4 style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'John Henderson', 'developer-starter-pro' ); ?></h4>
						<span style="font-size: 0.75rem; color: var(--developer-starter-pro-gray-400); display: block;"><?php esc_html_e( 'Emergency patient', 'developer-starter-pro' ); ?></span>
					</div>
				</div>
			</div>

			<!-- Review 3 -->
			<div class="review-item-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
				<div style="position: absolute; right: 30px; top: 30px; color: var(--developer-starter-pro-gray-200); font-size: 3rem; font-family: Georgia, serif; line-height: 1; pointer-events: none;">“</div>
				<div>
					<div style="color: #f59e0b; margin-bottom: 12px; font-size: 0.875rem;">★★★★★</div>
					<p style="margin: 0 0 20px 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-style: italic;"><?php esc_html_e( 'Very clean rooms, comfortable waiting lounge, and polite billing desk. They accepted my Delta Dental plan without any out-of-network costs.', 'developer-starter-pro' ); ?></p>
				</div>
				<div style="display: flex; align-items: center; gap: 12px; border-top: 1px solid var(--developer-starter-pro-gray-100); padding-top: 16px;">
					<div style="width: 44px; height: 44px; border-radius: 50%; background: #cbd5e1; font-weight: 700; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.9375rem;">EM</div>
					<div>
						<h4 style="margin: 0; font-size: 0.9375rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Emily Myers', 'developer-starter-pro' ); ?></h4>
						<span style="font-size: 0.75rem; color: var(--developer-starter-pro-gray-400); display: block;"><?php esc_html_e( 'Regular scaling patient', 'developer-starter-pro' ); ?></span>
					</div>
				</div>
			</div>

		</div>

	</div>
</section>
