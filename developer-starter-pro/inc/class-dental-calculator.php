<?php
/**
 * Dental Treatment Cost Calculator Shortcode
 *
 * Implements the treatment price estimations calculator with insurance slider levels
 * and booking page pre-selection routing.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Calculator {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_shortcode( 'dental_calculator', array( $this, 'render_calculator_shortcode' ) );
	}

	/**
	 * Render Calculator Shortcode [dental_calculator]
	 *
	 * @return string HTML Markup.
	 */
	public function render_calculator_shortcode() {
		// Fetch active services
		$services = get_posts( array(
			'post_type'      => 'services',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );

		if ( empty( $services ) ) {
			return '<p class="description">' . esc_html__( 'No dental services available for calculation.', 'developer-starter-pro' ) . '</p>';
		}

		// Find booking page URL
		$booking_url = developer_starter_pro_get_booking_url();

		ob_start();
		?>
		<div class="developer-starter-pro-calculator-wrapper" id="dental-cost-calculator">
			
			<div class="calculator-grid" style="display:grid; grid-template-columns: 1.5fr 1fr; gap:40px; align-items:flex-start;">
				
				<!-- Left Column: Treatments Selection & Insurance Slider -->
				<div class="calculator-left-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:16px; padding:36px; box-shadow:var(--developer-starter-pro-shadow-md);">
					<h3 style="margin-top:0; margin-bottom:20px; font-size:1.25rem;"><?php esc_html_e( '1. Select Dental Treatments', 'developer-starter-pro' ); ?></h3>
					
					<div class="calculator-treatments-list" style="display:flex; flex-direction:column; gap:12px; margin-bottom:30px;">
						<?php foreach ( $services as $srv ) : 
							$price = get_post_meta( $srv->ID, '_developer_starter_pro_service_price', true );
							$short_desc = get_post_meta( $srv->ID, '_developer_starter_pro_service_short_description', true );
							if ( empty( $price ) ) {
								$price = 0;
							}
							?>
							<label class="calculator-treatment-item" style="display:flex; justify-content:space-between; align-items:center; border:2px solid var(--developer-starter-pro-gray-200); border-radius:10px; padding:16px; cursor:pointer; transition:all 0.2s ease;">
								<div style="display:flex; align-items:center; gap:12px;">
									<input type="checkbox" class="treatment-select" value="<?php echo intval( $srv->ID ); ?>" data-price="<?php echo esc_attr( $price ); ?>" style="width:18px; height:18px; accent-color:var(--developer-starter-pro-primary);">
									<div>
										<strong style="display:block; color:var(--developer-starter-pro-secondary); font-size:0.95rem;"><?php echo esc_html( $srv->post_title ); ?></strong>
										<?php if ( $short_desc ) : ?>
											<span style="font-size:0.8rem; color:var(--developer-starter-pro-gray-400);"><?php echo esc_html( $short_desc ); ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div>
									<span class="treatment-price-label" style="font-weight:700; color:var(--developer-starter-pro-primary); font-size:1.0625rem;">
										$<?php echo esc_html( number_format( (float) $price, 0 ) ); ?>
									</span>
								</div>
							</label>
						<?php endforeach; ?>
					</div>

					<h3 style="margin-bottom:16px; font-size:1.25rem;"><?php esc_html_e( '2. Insurance Coverage Level', 'developer-starter-pro' ); ?></h3>
					<div class="calculator-insurance-section" style="background:var(--developer-starter-pro-gray-100); padding:20px; border-radius:10px;">
						<div style="display:flex; justify-content:space-between; margin-bottom:8px; font-weight:600; font-size:0.875rem;">
							<span><?php esc_html_e( 'Insurance Co-Pay Contribution:', 'developer-starter-pro' ); ?></span>
							<span id="insurance-percentage-label" style="color:var(--developer-starter-pro-primary);">0%</span>
						</div>
						<input type="range" id="insurance-copay-slider" min="0" max="100" value="0" step="5" style="width:100%; height:6px; background:#cbd5e1; border-radius:3px; outline:none; accent-color:var(--developer-starter-pro-primary);">
						<div style="display:flex; justify-content:space-between; font-size:0.75rem; color:var(--developer-starter-pro-gray-400); margin-top:6px;">
							<span>0% (<?php esc_html_e( 'Self-Funded', 'developer-starter-pro' ); ?>)</span>
							<span>50% (<?php esc_html_e( 'Standard Co-Pay', 'developer-starter-pro' ); ?>)</span>
							<span>100% (<?php esc_html_e( 'Full Coverage', 'developer-starter-pro' ); ?>)</span>
						</div>
					</div>
				</div>

				<!-- Right Column: Live Breakdowns Card -->
				<div class="calculator-right-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:16px; padding:36px; box-shadow:var(--developer-starter-pro-shadow-md); position:sticky; top:30px;">
					<h3 style="margin-top:0; margin-bottom:20px; font-size:1.25rem;"><?php esc_html_e( 'Treatment Summary', 'developer-starter-pro' ); ?></h3>
					
					<div class="calculator-breakdown-details" style="display:flex; flex-direction:column; gap:12px; margin-bottom:24px; font-size:0.9375rem;">
						<div style="display:flex; justify-content:space-between; color:var(--developer-starter-pro-gray-500);">
							<span><?php esc_html_e( 'Subtotal Treatments:', 'developer-starter-pro' ); ?></span>
							<span id="calc-subtotal" style="font-weight:600; color:var(--developer-starter-pro-secondary);">$0</span>
						</div>
						<div style="display:flex; justify-content:space-between; color:var(--developer-starter-pro-gray-500);">
							<span><?php esc_html_e( 'Insurance Savings:', 'developer-starter-pro' ); ?></span>
							<span id="calc-savings" style="font-weight:600; color:#10b981;">-$0</span>
						</div>
						<div style="border-top:1.5px dashed var(--developer-starter-pro-gray-200); margin:8px 0; padding-top:16px; display:flex; justify-content:space-between; align-items:center;">
							<strong style="font-size:1.0625rem; color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Estimated Out-of-Pocket:', 'developer-starter-pro' ); ?></strong>
							<span id="calc-total" style="font-size:1.75rem; font-weight:800; color:var(--developer-starter-pro-primary);">$0</span>
						</div>
					</div>

					<button type="button" id="calc-book-btn" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="width:100%; padding:14px; font-size:1.0625rem; font-weight:700;" disabled>
						📅 <?php esc_html_e( 'Book Treatments', 'developer-starter-pro' ); ?>
					</button>
					<span style="font-size:0.7rem; color:var(--developer-starter-pro-gray-400); text-align:center; display:block; margin-top:10px;"><?php esc_html_e( '*Calculated price is a clinical estimate only.', 'developer-starter-pro' ); ?></span>
				</div>

			</div>

		</div>

		<!-- Pass local config variables to JS -->
		<script>
		window.dentalCalculatorConfig = {
			bookingUrl: <?php echo wp_json_encode( $booking_url ); ?>
		};
		</script>
		<?php
		return ob_get_clean();
	}
}
