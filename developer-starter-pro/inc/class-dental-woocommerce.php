<?php
/**
 * WooCommerce Integration
 *
 * Handles WooCommerce compatibility, dental product setup,
 * and payment integration for dental services.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_WooCommerce {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Check if WooCommerce is active.
		if ( ! $this->is_woocommerce_active() ) {
			return;
		}

		// Theme support.
		add_action( 'after_setup_theme', array( $this, 'add_woocommerce_support' ) );

		// Remove default WooCommerce styles (we use our own).
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

		// Enqueue our WooCommerce styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_woo_styles' ) );

		// Customize WooCommerce templates.
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		add_action( 'woocommerce_before_main_content', array( $this, 'before_main_content' ) );
		add_action( 'woocommerce_after_main_content', array( $this, 'after_main_content' ) );

		// Remove default WooCommerce breadcrumbs.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Modify products per row.
		add_filter( 'loop_shop_columns', array( $this, 'products_per_row' ) );

		// Add dental product admin page.
		add_action( 'admin_menu', array( $this, 'add_products_submenu' ) );

		// Auto-create dental service products.
		add_action( 'dentalpro_service_published', array( $this, 'sync_service_to_product' ), 10, 2 );
		add_action( 'save_post_services', array( $this, 'sync_service_to_product' ), 10, 2 );
	}

	/**
	 * Check if WooCommerce plugin is active.
	 *
	 * @return bool
	 */
	public static function is_woocommerce_active() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Add WooCommerce theme support.
	 */
	public function add_woocommerce_support() {
		add_theme_support(
			'woocommerce',
			array(
				'thumbnail_image_width' => 400,
				'single_image_width'    => 600,
				'product_grid'          => array(
					'default_rows'    => 3,
					'min_rows'        => 1,
					'max_rows'        => 6,
					'default_columns' => 3,
					'min_columns'     => 1,
					'max_columns'     => 4,
				),
			)
		);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Enqueue WooCommerce compatible styles.
	 */
	public function enqueue_woo_styles() {
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
			return;
		}
		wp_enqueue_style(
			'developer-starter-pro-woocommerce',
			developer_starter_pro_CSS . '/woocommerce.css',
			array( 'developer-starter-pro-main' ),
			developer_starter_pro_VERSION
		);
	}

	/**
	 * WooCommerce main content wrapper open.
	 */
	public function before_main_content() {
		echo '<main id="primary" class="developer-starter-pro-main developer-starter-pro-woo-main">';
		echo '<div class="developer-starter-pro-container">';
	}

	/**
	 * WooCommerce main content wrapper close.
	 */
	public function after_main_content() {
		echo '</div>';
		echo '</main>';
	}

	/**
	 * Set products per row in shop loop.
	 *
	 * @return int
	 */
	public function products_per_row() {
		return 3;
	}

	/**
	 * Add dental products submenu under DentalPro.
	 */
	public function add_products_submenu() {
		add_submenu_page(
			'developer-starter-pro-settings',
			esc_html__( 'Dental Products', 'developer-starter-pro' ),
			esc_html__( 'Dental Products', 'developer-starter-pro' ),
			'manage_options',
			'developer-starter-pro-products',
			array( $this, 'render_products_page' )
		);
	}

	/**
	 * Render dental products admin page.
	 */
	public function render_products_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap developer-starter-pro-admin-wrap">
			<div class="developer-starter-pro-admin-header">
				<div class="developer-starter-pro-admin-header-inner">
					<h1>
						<span class="developer-starter-pro-logo-icon">🛒</span>
						<?php esc_html_e( 'Dental Products & Payments', 'developer-starter-pro' ); ?>
					</h1>
				</div>
			</div>

			<div class="developer-starter-pro-admin-content" style="margin-top:24px;">

				<?php if ( ! $this->is_woocommerce_active() ) : ?>
					<div class="notice notice-warning" style="padding:16px; border-left:4px solid #f59e0b;">
						<h3 style="margin:0 0 8px;"><?php esc_html_e( 'WooCommerce Not Installed', 'developer-starter-pro' ); ?></h3>
						<p><?php esc_html_e( 'To enable online payments and dental product sales, please install and activate WooCommerce.', 'developer-starter-pro' ); ?></p>
						<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) ); ?>" class="button button-primary">
							<?php esc_html_e( 'Install WooCommerce', 'developer-starter-pro' ); ?>
						</a>
					</div>
				<?php else : ?>

					<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; margin-bottom:30px;">
						<?php
						$product_count  = wp_count_posts( 'product' );
						$order_count    = wp_count_posts( 'shop_order' );
						$revenue        = $this->get_total_revenue();
						?>
						<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:20px; text-align:center;">
							<div style="font-size:2rem; font-weight:700; color:#0D9488;"><?php echo intval( $product_count->publish ); ?></div>
							<div style="color:#64748b; font-size:0.875rem; margin-top:4px;"><?php esc_html_e( 'Active Products', 'developer-starter-pro' ); ?></div>
						</div>
						<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:20px; text-align:center;">
							<div style="font-size:2rem; font-weight:700; color:#0D9488;"><?php echo intval( isset( $order_count->{'wc-completed'} ) ? $order_count->{'wc-completed'} : 0 ); ?></div>
							<div style="color:#64748b; font-size:0.875rem; margin-top:4px;"><?php esc_html_e( 'Completed Orders', 'developer-starter-pro' ); ?></div>
						</div>
						<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:20px; text-align:center;">
							<div style="font-size:2rem; font-weight:700; color:#0D9488;"><?php echo wc_price( $revenue ); ?></div>
							<div style="color:#64748b; font-size:0.875rem; margin-top:4px;"><?php esc_html_e( 'Total Revenue', 'developer-starter-pro' ); ?></div>
						</div>
					</div>

					<div style="display:flex; gap:12px; margin-bottom:24px;">
						<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ); ?>" class="button button-primary">
							<?php esc_html_e( '+ Add New Product', 'developer-starter-pro' ); ?>
						</a>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product' ) ); ?>" class="button button-secondary">
							<?php esc_html_e( 'View All Products', 'developer-starter-pro' ); ?>
						</a>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_order' ) ); ?>" class="button button-secondary">
							<?php esc_html_e( 'View Orders', 'developer-starter-pro' ); ?>
						</a>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=wc-settings' ) ); ?>" class="button button-secondary">
							<?php esc_html_e( 'WooCommerce Settings', 'developer-starter-pro' ); ?>
						</a>
					</div>

					<div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:24px;">
						<h3 style="margin-top:0;"><?php esc_html_e( 'Suggested Dental Products to Sell', 'developer-starter-pro' ); ?></h3>
						<ul style="columns:2; column-gap:40px; margin:0; padding-left:20px;">
							<li><?php esc_html_e( 'Teeth Whitening Kits', 'developer-starter-pro' ); ?></li>
							<li><?php esc_html_e( 'Electric Toothbrush Bundles', 'developer-starter-pro' ); ?></li>
							<li><?php esc_html_e( 'Dental Checkup Packages', 'developer-starter-pro' ); ?></li>
							<li><?php esc_html_e( 'Orthodontic Consultation Vouchers', 'developer-starter-pro' ); ?></li>
							<li><?php esc_html_e( 'Family Dental Plans', 'developer-starter-pro' ); ?></li>
							<li><?php esc_html_e( 'Night Guard & Retainers', 'developer-starter-pro' ); ?></li>
							<li><?php esc_html_e( 'Oral Hygiene Gift Sets', 'developer-starter-pro' ); ?></li>
							<li><?php esc_html_e( 'Fluoride Treatment Packages', 'developer-starter-pro' ); ?></li>
						</ul>
					</div>

				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get total WooCommerce revenue.
	 *
	 * @return float
	 */
	private function get_total_revenue() {
		global $wpdb;
		$revenue = $wpdb->get_var(
			"SELECT SUM( meta_value ) FROM {$wpdb->postmeta}
			INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
			WHERE meta_key = '_order_total'
			AND post_status IN ( 'wc-completed', 'wc-processing' )
			AND post_type = 'shop_order'"
		);
		return floatval( $revenue );
	}

	/**
	 * Sync Services CPT to WooCommerce product when service is published.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public function sync_service_to_product( $post_id, $post ) {
		if ( ! $this->is_woocommerce_active() ) {
			return;
		}
		if ( wp_is_post_revision( $post_id ) || 'publish' !== $post->post_status ) {
			return;
		}

		$price = get_post_meta( $post_id, '_developer_starter_pro_service_price', true );
		if ( empty( $price ) ) {
			return;
		}

		// Check if a linked product already exists.
		$linked_product_id = get_post_meta( $post_id, '_dentalpro_linked_product_id', true );

		if ( $linked_product_id && get_post( $linked_product_id ) ) {
			// Update existing product price.
			update_post_meta( $linked_product_id, '_regular_price', $price );
			update_post_meta( $linked_product_id, '_price', $price );
		} else {
			// Create a new simple WooCommerce product.
			$product_id = wp_insert_post( array(
				'post_title'   => $post->post_title,
				'post_content' => $post->post_content,
				'post_status'  => 'publish',
				'post_type'    => 'product',
			) );

			if ( $product_id && ! is_wp_error( $product_id ) ) {
				update_post_meta( $product_id, '_regular_price', $price );
				update_post_meta( $product_id, '_price', $price );
				update_post_meta( $product_id, '_stock_status', 'instock' );
				update_post_meta( $product_id, '_virtual', 'yes' );
				wp_set_object_terms( $product_id, 'simple', 'product_type' );

				// Link service to product.
				update_post_meta( $post_id, '_dentalpro_linked_product_id', $product_id );
			}
		}
	}
}
