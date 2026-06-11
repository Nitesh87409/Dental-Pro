<?php
/**
 * WooCommerce Template wrapper for DentalPro Elite
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">
	<div class="developer-starter-pro-container" style="padding: 48px 0;">
		<div class="developer-starter-pro-woocommerce-content">
			<?php woocommerce_content(); ?>
		</div>
	</div>
</main>

<?php
get_footer();
