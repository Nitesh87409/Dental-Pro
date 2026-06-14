<?php
/**
 * Enqueue Scripts & Styles
 *
 * Handles loading of all CSS and JavaScript files for frontend and admin.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Enqueue {

	/**
	 * Constructor — hook into WordPress.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_head', array( $this, 'dynamic_css' ), 100 );
		add_action( 'wp_enqueue_scripts', array( $this, 'google_fonts' ), 5 );
		add_action( 'admin_print_footer_scripts', array( $this, 'admin_delete_button_fix' ) );
	}

	/**
	 * Enqueue Google Fonts.
	 */
	public function google_fonts() {
		$font_url = add_query_arg(
			array(
				'family'  => 'Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap',
			),
			'https://fonts.googleapis.com/css2'
		);

		wp_enqueue_style(
			'developer-starter-pro-google-fonts',
			$font_url,
			array(),
			developer_starter_pro_VERSION
		);
	}

	/**
	 * Enqueue frontend stylesheets.
	 */
	public function frontend_styles() {
		// Main theme stylesheet (style.css — for WP theme recognition).
		wp_enqueue_style(
			'developer-starter-pro-theme',
			get_stylesheet_uri(),
			array(),
			developer_starter_pro_VERSION
		);

		// Main CSS.
		wp_enqueue_style(
			'developer-starter-pro-main',
			developer_starter_pro_CSS . '/main.css',
			array( 'developer-starter-pro-theme' ),
			developer_starter_pro_VERSION
		);

		// Header CSS.
		wp_enqueue_style(
			'developer-starter-pro-header',
			developer_starter_pro_CSS . '/header.css',
			array( 'developer-starter-pro-main' ),
			developer_starter_pro_VERSION
		);

		// Footer CSS.
		wp_enqueue_style(
			'developer-starter-pro-footer',
			developer_starter_pro_CSS . '/footer.css',
			array( 'developer-starter-pro-main' ),
			developer_starter_pro_VERSION
		);

		// Responsive CSS.
		wp_enqueue_style(
			'developer-starter-pro-responsive',
			developer_starter_pro_CSS . '/responsive.css',
			array( 'developer-starter-pro-main' ),
			developer_starter_pro_VERSION
		);

		// Chatbot CSS
		if ( developer_starter_pro_get_option( 'enable_chatbot', '1' ) === '1' ) {
			wp_enqueue_style(
				'developer-starter-pro-chatbot',
				developer_starter_pro_CSS . '/chatbot.css',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION
			);
		}

		// Patient Portal CSS
		if ( is_page_template( 'page-templates/template-patient-dashboard.php' ) || is_page_template( 'page-templates/template-patient-login.php' ) || is_page_template( 'page-templates/template-patient-register.php' ) || is_page_template( 'page-templates/template-patient-forgot.php' ) ) {
			wp_enqueue_style(
				'developer-starter-pro-portal',
				developer_starter_pro_CSS . '/portal.css',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION
			);
		}

		// Cost Calculator CSS
		global $post;
		if ( ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'dental_calculator' ) ) || is_page_template( 'page-templates/template-pricing.php' ) ) {
			wp_enqueue_style(
				'developer-starter-pro-calculator',
				developer_starter_pro_CSS . '/calculator.css',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION
			);
		}

		// Before/After CSS
		if ( ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'dental_before_after' ) ) || is_page_template( 'page-templates/template-before-after.php' ) ) {
			wp_enqueue_style(
				'developer-starter-pro-before-after',
				developer_starter_pro_CSS . '/before-after.css',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION
			);
		}
	}

	/**
	 * Enqueue frontend scripts.
	 */
	public function frontend_scripts() {
		// Main JS.
		wp_enqueue_script(
			'developer-starter-pro-main',
			developer_starter_pro_JS . '/main.js',
			array(),
			developer_starter_pro_VERSION,
			true
		);

		// Header JS.
		wp_enqueue_script(
			'developer-starter-pro-header',
			developer_starter_pro_JS . '/header.js',
			array( 'developer-starter-pro-main' ),
			developer_starter_pro_VERSION,
			true
		);

		// Localize script for AJAX.
		wp_localize_script(
			'developer-starter-pro-main',
			'developerStarterProAjax',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'restUrl' => rest_url( 'developer-starter-pro/v1/' ),
				'nonce'   => wp_create_nonce( 'developer_starter_pro_nonce' ),
				'homeUrl' => home_url(),
			)
		);

		// Booking Wizard JS
		if ( is_page_template( 'page-templates/template-booking.php' ) ) {
			wp_enqueue_script(
				'developer-starter-pro-booking',
				developer_starter_pro_JS . '/booking.js',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION,
				true
			);

			wp_localize_script(
				'developer-starter-pro-booking',
				'developerStarterProBooking',
				array(
					'restUrl' => rest_url( 'dentalpro/v1/' ),
					'strings' => array(
						'loadingSlots'       => esc_html__( 'Loading available slots...', 'developer-starter-pro' ),
						'noSlots'           => esc_html__( 'No slot intervals generated.', 'developer-starter-pro' ),
						'serverError'       => esc_html__( 'Server request failed.', 'developer-starter-pro' ),
						'selectService'     => esc_html__( 'Please select a dental service to continue.', 'developer-starter-pro' ),
						'selectDoctor'      => esc_html__( 'Please select a doctor to continue.', 'developer-starter-pro' ),
						'selectDate'        => esc_html__( 'Please pick a booking date.', 'developer-starter-pro' ),
						'selectSlot'        => esc_html__( 'Please select a time slot.', 'developer-starter-pro' ),
						'bookAppointment'   => esc_html__( 'Book Appointment', 'developer-starter-pro' ),
						'continueText'      => esc_html__( 'Continue', 'developer-starter-pro' ),
						'processing'        => esc_html__( 'Processing...', 'developer-starter-pro' ),
						'communicationError'=> esc_html__( 'Server communication error. Please try again.', 'developer-starter-pro' ),
					)
				)
			);
		}

		// Chatbot JS
		if ( developer_starter_pro_get_option( 'enable_chatbot', '1' ) === '1' ) {
			wp_enqueue_script(
				'developer-starter-pro-chatbot',
				developer_starter_pro_JS . '/chatbot.js',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION,
				true
			);

			wp_localize_script(
				'developer-starter-pro-chatbot',
				'developerStarterProChatbot',
				array(
					'restUrl' => rest_url( 'dentalpro/v1/' ),
					'nonce'   => wp_create_nonce( 'developer_starter_pro_chatbot_nonce' ),
				)
			);
		}

		// Patient Portal JS
		if ( is_page_template( 'page-templates/template-patient-dashboard.php' ) || is_page_template( 'page-templates/template-patient-login.php' ) || is_page_template( 'page-templates/template-patient-register.php' ) || is_page_template( 'page-templates/template-patient-forgot.php' ) ) {
			wp_enqueue_script(
				'developer-starter-pro-portal',
				developer_starter_pro_JS . '/portal.js',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION,
				true
			);

			wp_localize_script(
				'developer-starter-pro-portal',
				'developerStarterProPortal',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'developer_starter_pro_portal_nonce' ),
				)
			);
		}

		// Cost Calculator JS
		global $post;
		if ( ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'dental_calculator' ) ) || is_page_template( 'page-templates/template-pricing.php' ) ) {
			wp_enqueue_script(
				'developer-starter-pro-calculator',
				developer_starter_pro_JS . '/calculator.js',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION,
				true
			);

			wp_localize_script(
				'developer-starter-pro-calculator',
				'developerStarterProCalculator',
				array(
					'bookingUrl' => developer_starter_pro_get_booking_url(), // fallback booking url
				)
			);
		}

		// Before/After JS
		if ( ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'dental_before_after' ) ) || is_page_template( 'page-templates/template-before-after.php' ) ) {
			wp_enqueue_script(
				'developer-starter-pro-before-after',
				developer_starter_pro_JS . '/before-after.js',
				array( 'developer-starter-pro-main' ),
				developer_starter_pro_VERSION,
				true
			);
		}

		// Comment reply script.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Enqueue admin stylesheets.
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	public function admin_styles( $hook_suffix ) {
		// Only load on our admin pages.
		if ( 'toplevel_page_developer-starter-pro-settings' === $hook_suffix || strpos( $hook_suffix, 'developer-starter-pro' ) !== false ) {
			wp_enqueue_style(
				'developer-starter-pro-admin',
				developer_starter_pro_CSS . '/admin.css',
				array( 'wp-color-picker' ),
				developer_starter_pro_VERSION
			);
		}

		// Load on all admin pages for CPT meta box styles.
		wp_enqueue_style(
			'developer-starter-pro-admin-global',
			developer_starter_pro_CSS . '/admin.css',
			array(),
			developer_starter_pro_VERSION
		);
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	public function admin_scripts( $hook_suffix ) {
		if ( 'toplevel_page_developer-starter-pro-settings' === $hook_suffix || strpos( $hook_suffix, 'developer-starter-pro' ) !== false ) {
			wp_enqueue_media();
			wp_enqueue_script( 'wp-color-picker' );

			wp_enqueue_script(
				'developer-starter-pro-admin',
				developer_starter_pro_JS . '/admin.js',
				array( 'jquery', 'wp-color-picker' ),
				developer_starter_pro_VERSION,
				true
			);

			wp_localize_script(
				'developer-starter-pro-admin',
				'developerStarterProAdmin',
				array(
					'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
					'nonce'       => wp_create_nonce( 'developer_starter_pro_admin_nonce' ),
					'mediaTitle'  => esc_html__( 'Select or Upload Image', 'developer-starter-pro' ),
					'mediaButton' => esc_html__( 'Use this image', 'developer-starter-pro' ),
				)
			);
		}
	}

	/**
	 * Output dynamic CSS based on theme options.
	 */
	public function dynamic_css() {
		$primary   = developer_starter_pro_get_option( 'color_primary', '#0D9488' );
		$secondary = developer_starter_pro_get_option( 'color_secondary', '#1E293B' );
		$accent    = developer_starter_pro_get_option( 'color_accent', '#F59E0B' );

		$css = "
		<style id='developer-starter-pro-dynamic-css'>
			:root {
				--developer-starter-pro-primary: {$primary};
				--developer-starter-pro-primary-light: {$primary}20;
				--developer-starter-pro-primary-dark: {$primary};
				--developer-starter-pro-secondary: {$secondary};
				--developer-starter-pro-accent: {$accent};
				--developer-starter-pro-font-primary: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
				--developer-starter-pro-font-heading: 'Outfit', 'Inter', -apple-system, sans-serif;
			}
		</style>";

		echo $css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Fix Delete Permanently button globally in WordPress admin list views and media modals
	 */
	public function admin_delete_button_fix() {
		?>
		<script type="text/javascript">
		(function() {
			// Helper to create and show the beautiful custom delete modal
			function showCustomDeleteModal(viewContext, directUrl) {
				var existing = document.getElementById('custom-delete-confirm-modal');
				if (existing) {
					existing.remove();
				}

				var modal = document.createElement('div');
				modal.id = 'custom-delete-confirm-modal';
				modal.style.position = 'fixed';
				modal.style.top = '0';
				modal.style.left = '0';
				modal.style.width = '100%';
				modal.style.height = '100%';
				modal.style.background = 'rgba(15, 23, 42, 0.6)';
				modal.style.backdropFilter = 'blur(4px)';
				modal.style.webkitBackdropFilter = 'blur(4px)';
				modal.style.zIndex = '999999';
				modal.style.display = 'flex';
				modal.style.alignItems = 'center';
				modal.style.justifyContent = 'center';
				modal.style.fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';

				modal.innerHTML = 
					'<div style="background: #ffffff; padding: 24px; border-radius: 12px; max-width: 400px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); text-align: center; border: 1px solid #e2e8f0;">' +
						'<div style="font-size: 40px; margin-bottom: 12px;">⚠️</div>' +
						'<h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600; color: #0f172a;">Permanently Delete?</h3>' +
						'<p style="margin: 0 0 24px 0; font-size: 14px; color: #64748b; line-height: 1.5;">Are you sure you want to permanently delete this item? This action cannot be undone.</p>' +
						'<div style="display: flex; justify-content: center; gap: 12px;">' +
							'<button id="custom-delete-cancel" style="padding: 10px 18px; border-radius: 6px; border: 1px solid #cbd5e1; background: #ffffff; color: #334155; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s;">Cancel</button>' +
							'<button id="custom-delete-confirm" style="padding: 10px 18px; border-radius: 6px; border: none; background: #ef4444; color: #ffffff; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s;">Delete</button>' +
						'</div>' +
					'</div>';

				document.body.appendChild(modal);

				document.getElementById('custom-delete-cancel').addEventListener('click', function() {
					modal.remove();
				});

				document.getElementById('custom-delete-confirm').addEventListener('click', function() {
					modal.remove();
					if (viewContext && viewContext.model) {
						viewContext.model.destroy();
					} else if (directUrl) {
						window.location.href = directUrl;
					}
				});
			}

			// 1. List views: Capturing phase click listener
			document.addEventListener('click', function(e) {
				var deleteLink = e.target.closest('a.submitdelete');
				if (deleteLink) {
					var href = deleteLink.getAttribute('href');
					if (href) {
						e.preventDefault();
						e.stopPropagation();
						e.stopImmediatePropagation();
						showCustomDeleteModal(null, href);
					}
				}
			}, true);

			// 2. Media Upload Modal: Override Backbone prototype functions when loaded
			function applyMediaDeleteOverride() {
				if (typeof wp !== 'undefined' && wp.media && wp.media.view) {
					// View type 1
					if (wp.media.view.Attachment && wp.media.view.Attachment.Details && !wp.media.view.Attachment.Details.prototype.customDeletePatched) {
						wp.media.view.Attachment.Details.prototype.customDeletePatched = true;
						wp.media.view.Attachment.Details.prototype.deleteAttachment = function(event) {
							event.preventDefault();
							showCustomDeleteModal(this);
						};
					}
					// View type 2
					if (wp.media.view.AttachmentDetails && !wp.media.view.AttachmentDetails.prototype.customDeletePatched) {
						wp.media.view.AttachmentDetails.prototype.customDeletePatched = true;
						wp.media.view.AttachmentDetails.prototype.deleteAttachment = function(event) {
							event.preventDefault();
							showCustomDeleteModal(this);
						};
					}
				}
			}

			var mediaPollInterval = setInterval(applyMediaDeleteOverride, 100);
			setTimeout(function() {
				clearInterval(mediaPollInterval);
			}, 15000); // Poll for 15s max
		})();
		</script>
		<?php
	}
}




