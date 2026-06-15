<?php
/**
 * Template Part: Homepage Treatment Cost Calculator
 *
 * Renders the dental calculator shortcode inside a beautifully styled homepage section.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>
<section class="dp-calculator-section" id="cost-calculator">
	<div class="dp-section-container">
		<div class="dp-section-header">
			<h2 class="dp-section-title"><?php esc_html_e( 'Treatment Cost Calculator', 'developer-starter-pro' ); ?></h2>
			<div class="dp-section-rule" aria-hidden="true"></div>
		</div>
		<div class="dp-calculator-section__content">
			<?php echo do_shortcode( '[dental_calculator]' ); ?>
		</div>
	</div>
</section>

<style>
.dp-calculator-section {
	background: #F8F7F4; /* Light warm cream background */
	padding: 72px 0 80px;
}
.dp-calculator-section__content {
	max-width: 900px;
	margin: 0 auto;
}
</style>
