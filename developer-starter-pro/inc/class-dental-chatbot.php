<?php
/**
 * AI Chatbot Module
 *
 * Handles admin FAQ configuration, REST API queries for rule-based keyword matching,
 * and rendering of the chatbot floating widget.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Chatbot {

	/**
	 * Options option name.
	 */
	private $option_name = 'developer_starter_pro_chatbot_faqs';
	private $settings_name = 'developer_starter_pro_chatbot_settings';

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Admin menus
		add_action( 'admin_menu', array( $this, 'add_chatbot_submenu' ) );
		add_action( 'admin_init', array( $this, 'register_chatbot_settings' ) );

		// REST API
		add_action( 'rest_api_init', array( $this, 'register_chatbot_routes' ) );

		// Hook chatbot widget to footer
		add_action( 'wp_footer', array( $this, 'render_chatbot_widget' ) );
	}

	/**
	 * Register submenus under DentalPro settings.
	 */
	public function add_chatbot_submenu() {
		add_submenu_page(
			'developer-starter-pro-settings',
			esc_html__( 'Chatbot FAQs', 'developer-starter-pro' ),
			esc_html__( 'Chatbot FAQs', 'developer-starter-pro' ),
			'manage_options',
			'developer-starter-pro-chatbot',
			array( $this, 'render_chatbot_admin' )
		);
	}

	/**
	 * Register Settings.
	 */
	public function register_chatbot_settings() {
		register_setting( 'developer_starter_pro_chatbot_group', $this->settings_name );
		register_setting( 'developer_starter_pro_chatbot_group', $this->option_name );
	}

	/**
	 * Get chatbot settings.
	 */
	public function get_settings() {
		$defaults = array(
			'enabled'       => '1',
			'bot_name'      => esc_html__( 'ProDent Assistant', 'developer-starter-pro' ),
			'welcome_msg'   => esc_html__( 'Hello! How can I help you improve your smile today?', 'developer-starter-pro' ),
			'theme_color'   => '#0D9488',
		);
		$saved = get_option( $this->settings_name, array() );
		return wp_parse_args( $saved, $defaults );
	}

	/**
	 * Get FAQ pairs list.
	 */
	public function get_faqs() {
		$default_faqs = array(
			array(
				'keys' => 'hours,timing,schedule,open,close,time',
				'question' => esc_html__( 'What are your clinic hours?', 'developer-starter-pro' ),
				'answer' => esc_html__( 'We are open Monday to Friday from 9:00 AM to 6:00 PM, and Saturdays from 9:00 AM to 2:00 PM. We are closed on Sundays.', 'developer-starter-pro' ),
			),
			array(
				'keys' => 'location,address,where,map,find',
				'question' => esc_html__( 'Where is the clinic located?', 'developer-starter-pro' ),
				'answer' => esc_html__( 'Our clinic is located in the health center district at 123 Dental Plaza, Suite 100. Valet parking is available for all patients.', 'developer-starter-pro' ),
			),
			array(
				'keys' => 'price,cost,insurance,fee,cheap',
				'question' => esc_html__( 'Do you accept insurance or how much do treatments cost?', 'developer-starter-pro' ),
				'answer' => esc_html__( 'Yes! We accept most major dental insurance plans. Please check our Pricing Packages page for estimated costs, or contact our desk for insurance verification details.', 'developer-starter-pro' ),
			),
			array(
				'keys' => 'emergency,pain,hurt,ache,urgent',
				'question' => esc_html__( 'What should I do in case of a dental emergency?', 'developer-starter-pro' ),
				'answer' => esc_html__( 'If you are experiencing severe pain or a dental emergency, call our Emergency Hotline immediately at our helpline listed in the contact section. We support walk-ins.', 'developer-starter-pro' ),
			),
		);
		return get_option( $this->option_name, $default_faqs );
	}

	/**
	 * Render Chatbot Admin Page.
	 */
	public function render_chatbot_admin() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Handle Form updates (Add/Delete FAQ) manually to avoid Settings API complexity
		if ( isset( $_POST['action'] ) && $_POST['action'] === 'save_chatbot_faqs' ) {
			check_admin_referer( 'developer_starter_pro_chatbot_nonce' );

			// Save Settings
			$settings = array(
				'enabled'     => isset( $_POST['bot_enabled'] ) ? '1' : '0',
				'bot_name'    => sanitize_text_field( $_POST['bot_name'] ),
				'welcome_msg' => sanitize_textarea_field( $_POST['welcome_msg'] ),
				'theme_color' => developer_starter_pro_sanitize_hex_color( $_POST['theme_color'] ),
			);
			update_option( $this->settings_name, $settings );

			// Save FAQs
			$faqs = array();
			if ( isset( $_POST['faq_questions'] ) && is_array( $_POST['faq_questions'] ) ) {
				for ( $i = 0; $i < count( $_POST['faq_questions'] ); $i++ ) {
					$q = sanitize_text_field( $_POST['faq_questions'][$i] ?? '' );
					$a = sanitize_textarea_field( $_POST['faq_answers'][$i] ?? '' );
					$k = sanitize_text_field( $_POST['faq_keywords'][$i] ?? '' );
					if ( ! empty( $q ) && ! empty( $a ) ) {
						$faqs[] = array(
							'keys'     => strtolower( $k ),
							'question' => $q,
							'answer'   => $a,
						);
					}
				}
			}
			update_option( $this->option_name, $faqs );

			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Chatbot Settings and FAQs updated successfully.', 'developer-starter-pro' ) . '</p></div>';
		}

		$settings = $this->get_settings();
		$faqs = $this->get_faqs();
		?>
		<div class="wrap developer-starter-pro-admin-wrap">
			<div class="developer-starter-pro-admin-header">
				<div class="developer-starter-pro-admin-header-inner">
					<h1>
						<span class="developer-starter-pro-logo-icon">🤖</span>
						<?php esc_html_e( 'AI Chatbot FAQ Manager', 'developer-starter-pro' ); ?>
					</h1>
				</div>
			</div>

			<form method="post" action="" style="margin-top: 24px;">
				<?php wp_nonce_field( 'developer_starter_pro_chatbot_nonce' ); ?>
				<input type="hidden" name="action" value="save_chatbot_faqs">

				<!-- Settings Section -->
				<div class="developer-starter-pro-settings-section" style="background:#fff; padding:24px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:24px;">
					<h2><?php esc_html_e( 'General Chatbot Settings', 'developer-starter-pro' ); ?></h2>
					<table class="form-table">
						<tr>
							<th><label for="bot_enabled"><?php esc_html_e( 'Enable Chatbot Widget', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="checkbox" id="bot_enabled" name="bot_enabled" value="1" <?php checked( $settings['enabled'], '1' ); ?>>
								<span class="description"><?php esc_html_e( 'Check to render the floating chatbot in the bottom right corner of the website.', 'developer-starter-pro' ); ?></span>
							</td>
						</tr>
						<tr>
							<th><label for="bot_name"><?php esc_html_e( 'Chatbot Name', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="text" id="bot_name" name="bot_name" value="<?php echo esc_attr( $settings['bot_name'] ); ?>" class="regular-text" required>
							</td>
						</tr>
						<tr>
							<th><label for="welcome_msg"><?php esc_html_e( 'Welcome Message', 'developer-starter-pro' ); ?></label></th>
							<td>
								<textarea id="welcome_msg" name="welcome_msg" rows="3" class="large-text" required><?php echo esc_textarea( $settings['welcome_msg'] ); ?></textarea>
							</td>
						</tr>
						<tr>
							<th><label for="theme_color"><?php esc_html_e( 'Chatbot Theme Color', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="text" id="theme_color" name="theme_color" value="<?php echo esc_attr( $settings['theme_color'] ); ?>" class="developer-starter-pro-color-picker" data-default-color="#0D9488">
							</td>
						</tr>
					</table>
				</div>

				<!-- FAQs Section -->
				<div class="developer-starter-pro-settings-section" style="background:#fff; padding:24px; border-radius:8px; border:1px solid #e2e8f0;">
					<h2><?php esc_html_e( 'Bot Q&A FAQ Database', 'developer-starter-pro' ); ?></h2>
					<p class="description"><?php esc_html_e( 'Define queries the bot can resolve automatically. Add keywords separated by commas to match user entries dynamically.', 'developer-starter-pro' ); ?></p>
					
					<div id="faq-rows-container" style="margin-top: 20px;">
						<?php 
						$index = 0;
						foreach ( $faqs as $faq ) : ?>
							<div class="faq-row" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 16px; position:relative;">
								<button type="button" class="button remove-faq-btn" style="position:absolute; top: 15px; right: 15px; color: #ef4444; border-color: #fca5a5;"><?php esc_html_e( 'Delete', 'developer-starter-pro' ); ?></button>
								<div style="margin-bottom:12px;">
									<label style="display:block; font-weight:600; margin-bottom:4px;"><?php esc_html_e( 'Keywords (comma separated):', 'developer-starter-pro' ); ?></label>
									<input type="text" name="faq_keywords[]" value="<?php echo esc_attr( $faq['keys'] ); ?>" class="large-text" placeholder="e.g. price, cost, insurance" required>
								</div>
								<div style="margin-bottom:12px;">
									<label style="display:block; font-weight:600; margin-bottom:4px;"><?php esc_html_e( 'Bot Question / Option Label:', 'developer-starter-pro' ); ?></label>
									<input type="text" name="faq_questions[]" value="<?php echo esc_attr( $faq['question'] ); ?>" class="large-text" placeholder="e.g. Do you accept insurance?" required>
								</div>
								<div>
									<label style="display:block; font-weight:600; margin-bottom:4px;"><?php esc_html_e( 'Bot Answer:', 'developer-starter-pro' ); ?></label>
									<textarea name="faq_answers[]" rows="3" class="large-text" placeholder="Enter answers details..." required><?php echo esc_textarea( $faq['answer'] ); ?></textarea>
								</div>
							</div>
						<?php 
						$index++;
						endforeach; ?>
					</div>

					<button type="button" id="add-faq-btn" class="button button-secondary" style="margin-top:10px;">
						<?php esc_html_e( '+ Add New Q&A Pair', 'developer-starter-pro' ); ?>
					</button>
				</div>

				<div style="margin-top:24px;">
					<?php submit_button( esc_html__( 'Save Chatbot Settings', 'developer-starter-pro' ), 'primary', 'submit', true ); ?>
				</div>
			</form>
		</div>

		<script>
		jQuery(document).ready(function($) {
			// Add Row
			$('#add-faq-btn').on('click', function() {
				var newRow = `
					<div class="faq-row" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 16px; position:relative;">
						<button type="button" class="button remove-faq-btn" style="position:absolute; top: 15px; right: 15px; color: #ef4444; border-color: #fca5a5;">Delete</button>
						<div style="margin-bottom:12px;">
							<label style="display:block; font-weight:600; margin-bottom:4px;">Keywords (comma separated):</label>
							<input type="text" name="faq_keywords[]" value="" class="large-text" placeholder="e.g. price, cost, insurance" required>
						</div>
						<div style="margin-bottom:12px;">
							<label style="display:block; font-weight:600; margin-bottom:4px;">Bot Question / Option Label:</label>
							<input type="text" name="faq_questions[]" value="" class="large-text" placeholder="e.g. Do you accept insurance?" required>
						</div>
						<div>
							<label style="display:block; font-weight:600; margin-bottom:4px;">Bot Answer:</label>
							<textarea name="faq_answers[]" rows="3" class="large-text" placeholder="Enter answers details..." required></textarea>
						</div>
					</div>
				`;
				$('#faq-rows-container').append(newRow);
			});

			// Remove Row
			$(document).on('click', '.remove-faq-btn', function() {
				if (confirm('Are you sure you want to remove this FAQ pair?')) {
					$(this).closest('.faq-row').fadeOut(300, function() {
						$(this).remove();
					});
				}
			});

			// Initialize Color Pickers on dynamic/default loaded ones
			if ($.isFunction($.fn.wpColorPicker)) {
				$('.developer-starter-pro-color-picker').wpColorPicker();
			}
		});
		</script>
		<?php
	}

	/**
	 * Register Chatbot REST API Routes.
	 */
	public function register_chatbot_routes() {
		register_rest_route(
			'dentalpro/v1',
			'/chatbot/query',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'query_chatbot' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Callback query chatbot.
	 *
	 * Matches user input against keywords.
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response REST Response.
	 */
	public function query_chatbot( $request ) {
		$query = sanitize_text_field( $request->get_param( 'q' ) );
		if ( empty( $query ) ) {
			return new WP_REST_Response( array( 'answer' => esc_html__( 'Please enter a message.', 'developer-starter-pro' ) ), 400 );
		}

		$query_lower = strtolower( trim( $query ) );
		$faqs = $this->get_faqs();
		$best_match = null;

		// Perform keyword matching
		foreach ( $faqs as $faq ) {
			$keywords = explode( ',', $faq['keys'] );
			foreach ( $keywords as $kw ) {
				$kw = trim( $kw );
				if ( ! empty( $kw ) && strpos( $query_lower, $kw ) !== false ) {
					$best_match = $faq['answer'];
					break 2;
				}
			}
		}

		if ( $best_match ) {
			return new WP_REST_Response( array(
				'success' => true,
				'answer'  => $best_match,
			), 200 );
		}

		// Fallback
		return new WP_REST_Response( array(
			'success' => false,
			'answer'  => esc_html__( 'I am not sure I understand that query completely. But you can easily book an appointment online or contact our clinical desk directly!', 'developer-starter-pro' ),
			'fallback'=> true,
		), 200 );
	}

	/**
	 * Render Chatbot Floating Widget in Footer.
	 */
	public function render_chatbot_widget() {
		$settings = $this->get_settings();
		if ( $settings['enabled'] !== '1' ) {
			return;
		}

		$faqs = $this->get_faqs();
		$options = developer_starter_pro_get_all_options();
		$phone = $options['clinic_phone'] ?? '';
		$whatsapp = $options['whatsapp_number'] ?? '';
		if ( empty( $whatsapp ) ) {
			$whatsapp = $phone;
		}
		// Sanitize WhatsApp number
		$whatsapp_cleaned = preg_replace( '/[^0-9]/', '', $whatsapp );
		
		// Find booking page URL
		$booking_url = developer_starter_pro_get_booking_url();
		?>
		
		<!-- DentalPro Chatbot Widget -->
		<div id="dental-chatbot-container" class="dental-chatbot-container" style="--chatbot-primary: <?php echo esc_attr( $settings['theme_color'] ); ?>;">
			
			<!-- Floating Trigger Bubble -->
			<button id="dental-chatbot-bubble" class="dental-chatbot-bubble" aria-label="<?php esc_attr_e( 'Open Chatbot', 'developer-starter-pro' ); ?>">
				<span class="chatbot-icon-open">💬</span>
				<span class="chatbot-icon-close" style="display:none;">✕</span>
				<span class="chatbot-pulse-ring"></span>
			</button>

			<!-- Chat Window Drawer -->
			<div id="dental-chatbot-drawer" class="dental-chatbot-drawer" style="display:none;">
				<!-- Drawer Header -->
				<div class="chatbot-drawer-header">
					<div class="chatbot-bot-info">
						<span class="chatbot-avatar">🤖</span>
						<div>
							<h4 class="chatbot-name"><?php echo esc_html( $settings['bot_name'] ); ?></h4>
							<span class="chatbot-status"><?php esc_html_e( 'Online | Clinician Bot', 'developer-starter-pro' ); ?></span>
						</div>
					</div>
					<button id="dental-chatbot-close" class="chatbot-drawer-close" aria-label="<?php esc_attr_e( 'Close Chat', 'developer-starter-pro' ); ?>">✕</button>
				</div>

				<!-- Drawer Messages Body -->
				<div id="chatbot-messages-body" class="chatbot-messages-body">
					<!-- Welcome message -->
					<div class="chatbot-message bot-msg">
						<div class="message-content">
							<?php echo esc_html( $settings['welcome_msg'] ); ?>
						</div>
					</div>
					
					<!-- Quick replies buttons -->
					<div class="chatbot-quick-replies" id="chatbot-quick-replies">
						<?php foreach ( $faqs as $faq ) : ?>
							<button type="button" class="quick-reply-btn" data-question="<?php echo esc_attr( $faq['question'] ); ?>">
								<?php echo esc_html( $faq['question'] ); ?>
							</button>
						<?php endforeach; ?>
						<a href="<?php echo esc_url( $booking_url ); ?>" class="quick-reply-btn cta-btn">
							📅 <?php esc_html_e( 'Book Appointment', 'developer-starter-pro' ); ?>
						</a>
					</div>
				</div>

				<!-- Typing Indicator -->
				<div id="chatbot-typing-indicator" class="chatbot-typing" style="display:none;">
					<span></span><span></span><span></span>
				</div>

				<!-- Drawer Form Footer -->
				<div class="chatbot-drawer-footer">
					<form id="chatbot-input-form" action="#" method="get" style="display:flex; width: 100%;">
						<input type="text" id="chatbot-user-input" class="chatbot-user-input" placeholder="<?php esc_attr_e( 'Type your question...', 'developer-starter-pro' ); ?>" required autocomplete="off">
						<button type="submit" class="chatbot-send-btn" aria-label="<?php esc_attr_e( 'Send Message', 'developer-starter-pro' ); ?>">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="22" y1="2" x2="11" y2="13"></line>
								<polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
							</svg>
						</button>
					</form>
				</div>
			</div>
		</div>

		<!-- Localized Fallback Values for JS -->
		<script>
		window.dentalChatbotData = {
			bookingUrl: <?php echo wp_json_encode( $booking_url ); ?>,
			whatsappUrl: <?php echo wp_json_encode( 'https://wa.me/' . $whatsapp_cleaned ); ?>
		};
		</script>
		<?php
	}
}
