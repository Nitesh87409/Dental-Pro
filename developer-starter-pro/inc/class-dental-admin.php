<?php
/**
 * Admin Theme Options Panel
 *
 * Custom admin settings page using WordPress Settings API.
 * Tabbed interface with 6 sections: General, Colors, Header, Footer, Social Media, Contact.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Admin {

	/**
	 * Option name in the database.
	 *
	 * @var string
	 */
	private $option_name = 'developer_starter_pro_options';

	/**
	 * Settings page slug.
	 *
	 * @var string
	 */
	private $page_slug = 'developer-starter-pro-settings';

	/**
	 * Constructor — hook into WordPress.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'wp_ajax_developer_starter_pro_save_options', array( $this, 'ajax_save_options' ) );
	}

	/**
	 * Add admin menu page.
	 */
	public function add_admin_menu() {
		add_menu_page(
			esc_html__( 'DentalPro Settings', 'developer-starter-pro' ),
			esc_html__( 'DentalPro', 'developer-starter-pro' ),
			'manage_options',
			$this->page_slug,
			array( $this, 'render_settings_page' ),
			'dashicons-admin-customizer',
			59
		);

		add_submenu_page(
			$this->page_slug,
			esc_html__( 'Theme Settings', 'developer-starter-pro' ),
			esc_html__( 'Theme Settings', 'developer-starter-pro' ),
			'manage_options',
			$this->page_slug,
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register settings.
	 */
	public function register_settings() {
		register_setting(
			'developer_starter_pro_settings_group',
			$this->option_name,
			array( $this, 'sanitize_options' )
		);
	}

	/**
	 * Sanitize all options before saving.
	 *
	 * @param array $input Raw option values.
	 * @return array Sanitized values.
	 */
	public function sanitize_options( $input ) {
		$existing = get_option( $this->option_name, array() );
		$sanitized = is_array( $existing ) ? $existing : array();

		// Field mapping for compaction
		$fields = array(
			'text' => array(
				'clinic_name', 'clinic_phone', 'header_style', 'footer_style', 
				'social_custom_1_label', 'social_custom_2_label', 'social_custom_1_icon', 'social_custom_2_icon',
				'google_maps_key', 'emergency_phone', 'whatsapp_number', 'whatsapp_message', 'whatsapp_position',
				'blog_section_eyebrow', 'blog_section_title', 'stat1_icon', 'stat1_number', 'stat1_label',
				'stat2_icon', 'stat2_number', 'stat2_label', 'stat3_icon', 'stat3_number', 'stat3_label',
				'stat4_icon', 'stat4_number', 'stat4_label', 'appointment_approval_mode', 'twilio_sid', 
				'twilio_auth_token', 'twilio_from_number', 'sms_provider', 'sms_custom_url', 'sms_custom_method',
				'archive_completed_months', 'archive_cancelled_months', 'why_choose_us_badge', 'why_choose_us_title',
				'gallery_section_badge', 'gallery_section_title', 'chatbot_api_key', 'chatbot_model'
			),
			'url' => array(
				'clinic_logo', 'hero_image', 'hero_video', 'page_banner_image', 
				'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube', 'social_linkedin',
				'social_tiktok', 'social_pinterest', 'social_custom_1_url', 'social_custom_2_url',
				'google_review_url', 'chatbot_api_url'
			),
			'textarea' => array(
				'clinic_address', 'blog_section_subtitle', 'sms_custom_headers', 'sms_custom_body', 
				'why_choose_us_subtitle', 'gallery_section_subtitle', 'chatbot_system_prompt'
			),
			'int' => array('clinic_logo_height', 'blog_section_count'),
			'color' => array('color_primary', 'color_secondary', 'color_accent'),
			'email' => array('clinic_email')
		);

		$active_tab = isset( $input['active_tab'] ) ? sanitize_text_field( $input['active_tab'] ) : '';

		// Loop through standard fields
		foreach ( $fields as $type => $keys ) {
			foreach ( $keys as $key ) {
				if ( ! isset( $input[ $key ] ) ) continue;
				switch ( $type ) {
					case 'text': $sanitized[ $key ] = sanitize_text_field( $input[ $key ] ); break;
					case 'url': $sanitized[ $key ] = esc_url_raw( $input[ $key ] ); break;
					case 'textarea': $sanitized[ $key ] = sanitize_textarea_field( $input[ $key ] ); break;
					case 'int': $sanitized[ $key ] = absint( $input[ $key ] ); break;
					case 'color': $sanitized[ $key ] = developer_starter_pro_sanitize_hex_color( $input[ $key ] ); break;
					case 'email': $sanitized[ $key ] = sanitize_email( $input[ $key ] ); break;
				}
			}
		}

		// Process Toggles based on active tab so unchecked boxes are saved correctly without wiping other tabs
		$toggles_by_tab = array(
			'header'       => array('header_sticky'),
			'contact'      => array('emergency_enabled', 'whatsapp_enabled'),
			'blog'         => array('blog_section_enabled'),
			'appointments' => array('twilio_sms_enabled'),
			'chatbot'      => array('chatbot_enable', 'bugreport_enable'),
		);

		if ( $active_tab && isset( $toggles_by_tab[ $active_tab ] ) ) {
			foreach ( $toggles_by_tab[ $active_tab ] as $toggle_key ) {
				$sanitized[ $toggle_key ] = isset( $input[ $toggle_key ] ) ? '1' : '0';
			}
		}

		// Complex: Map iframe
		if ( isset( $input['map_embed_code'] ) ) {
			$allowed_iframe = array(
				'iframe' => array(
					'src' => true, 'width' => true, 'height' => true, 'style' => true, 'frameborder' => true, 
					'allowfullscreen' => true, 'loading' => true, 'referrerpolicy' => true, 'class' => true, 'id' => true,
				),
			);
			$sanitized['map_embed_code'] = wp_kses( $input['map_embed_code'], $allowed_iframe );
		}

		// Complex: Working Hours
		if ( isset( $input['working_hours'] ) && is_array( $input['working_hours'] ) ) {
			$sanitized['working_hours'] = array();
			foreach ( $input['working_hours'] as $day => $hours ) {
				$sanitized['working_hours'][ sanitize_key( $day ) ] = array(
					'open'   => sanitize_text_field( $hours['open'] ),
					'close'  => sanitize_text_field( $hours['close'] ),
					'closed' => isset( $hours['closed'] ) ? true : false,
				);
			}
		}

		// Complex: Why Choose Us
		if ( isset( $input['why_choose_us_benefits'] ) ) {
			$raw_benefits = is_string( $input['why_choose_us_benefits'] ) ? json_decode( wp_unslash( $input['why_choose_us_benefits'] ), true ) : $input['why_choose_us_benefits'];
			$benefits = array();
			if ( is_array( $raw_benefits ) ) {
				foreach ( $raw_benefits as $benefit ) {
					if ( ! empty( $benefit['title'] ) ) {
						$benefits[] = array(
							'icon'        => isset( $benefit['icon'] ) ? developer_starter_pro_sanitize_svg( $benefit['icon'] ) : '',
							'title'       => sanitize_text_field( $benefit['title'] ),
							'description' => isset( $benefit['description'] ) ? sanitize_textarea_field( $benefit['description'] ) : '',
						);
					}
				}
			}
			$sanitized['why_choose_us_benefits'] = $benefits;
		}

		// Complex: Gallery Items
		if ( isset( $input['gallery_items'] ) ) {
			$raw_items = is_string( $input['gallery_items'] ) ? json_decode( wp_unslash( $input['gallery_items'] ), true ) : $input['gallery_items'];
			$gallery_items = array();
			if ( is_array( $raw_items ) ) {
				foreach ( $raw_items as $item ) {
					if ( ! empty( $item['image'] ) ) {
						$gallery_items[] = array(
							'image' => esc_url_raw( $item['image'] ),
							'title' => isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '',
						);
					}
				}
			}
			$sanitized['gallery_items'] = $gallery_items;
		}

		unset( $sanitized['active_tab'] );

		return $sanitized;
	}

	/**
	 * Render the settings page.
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options = developer_starter_pro_get_all_options();
		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
		?>
		<div class="wrap developer-starter-pro-admin-wrap">
			<div class="developer-starter-pro-admin-header">
				<div class="developer-starter-pro-admin-header-inner">
					<h1>
						<?php 
						$admin_logo = ! empty( $options['clinic_logo'] ) ? $options['clinic_logo'] : '';
						$admin_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : 'DentalPro Elite';
						if ( $admin_logo ) : ?>
							<img src="<?php echo esc_url( $admin_logo ); ?>" alt="Logo" style="max-height: 40px; margin-right: 15px; border-radius: 4px; vertical-align: middle; display: inline-block;">
						<?php else : ?>
							<span class="developer-starter-pro-logo-icon">🦷</span>
						<?php endif; ?>
						<?php echo esc_html( $admin_name . ' Settings' ); ?>
					</h1>
					<span class="developer-starter-pro-version"><?php echo 'v' . esc_html( developer_starter_pro_VERSION ); ?></span>
				</div>
			</div>

			<div class="developer-starter-pro-admin-tabs">
				<?php
				$tabs = array(
					'general' => array(
						'label' => esc_html__( 'General', 'developer-starter-pro' ),
						'icon'  => 'dashicons-admin-generic',
					),
					'colors' => array(
						'label' => esc_html__( 'Colors', 'developer-starter-pro' ),
						'icon'  => 'dashicons-art',
					),
					'header' => array(
						'label' => esc_html__( 'Header', 'developer-starter-pro' ),
						'icon'  => 'dashicons-align-full-width',
					),
					'footer' => array(
						'label' => esc_html__( 'Footer', 'developer-starter-pro' ),
						'icon'  => 'dashicons-align-wide',
					),
					'social' => array(
						'label' => esc_html__( 'Social Media', 'developer-starter-pro' ),
						'icon'  => 'dashicons-share',
					),
					'contact' => array(
						'label' => esc_html__( 'Contact', 'developer-starter-pro' ),
						'icon'  => 'dashicons-location',
					),
					'blog' => array(
						'label' => esc_html__( 'Homepage Blog', 'developer-starter-pro' ),
						'icon'  => 'dashicons-welcome-write-blog',
					),
					'stats' => array(
						'label' => esc_html__( 'Homepage Stats', 'developer-starter-pro' ),
						'icon'  => 'dashicons-chart-bar',
					),
					'why_choose_us' => array(
						'label' => esc_html__( 'Homepage Why Choose Us', 'developer-starter-pro' ),
						'icon'  => 'dashicons-thumbs-up',
					),
					'homepage_gallery' => array(
						'label' => esc_html__( 'Homepage Gallery', 'developer-starter-pro' ),
						'icon'  => 'dashicons-images-alt2',
					),
					'appointments' => array(
						'label' => esc_html__( 'Appointment Settings', 'developer-starter-pro' ),
						'icon'  => 'dashicons-calendar-alt',
					),
					'chatbot' => array(
						'label' => esc_html__( 'AI Chatbot', 'developer-starter-pro' ),
						'icon'  => 'dashicons-format-chat',
					),
				);

				foreach ( $tabs as $tab_key => $tab ) : ?>
					<a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&tab=<?php echo esc_attr( $tab_key ); ?>"
					   class="developer-starter-pro-admin-tab <?php echo $active_tab === $tab_key ? 'active' : ''; ?>">
					   <span class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></span>
						<?php echo esc_html( $tab['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>

			<div class="developer-starter-pro-admin-content">
				<form method="post" action="options.php" id="developer-starter-pro-settings-form">
					<?php
					settings_fields( 'developer_starter_pro_settings_group' );
					?>
					<input type="hidden" name="<?php echo esc_attr( $this->option_name ); ?>[active_tab]" value="<?php echo esc_attr( $active_tab ); ?>">
					<?php

					switch ( $active_tab ) {
						case 'general':
							require developer_starter_pro_INC . '/admin/tabs/tab-general.php';
							break;
						case 'colors':
							require developer_starter_pro_INC . '/admin/tabs/tab-colors.php';
							break;
						case 'header':
							require developer_starter_pro_INC . '/admin/tabs/tab-header.php';
							break;
						case 'footer':
							require developer_starter_pro_INC . '/admin/tabs/tab-footer.php';
							break;
						case 'social':
							require developer_starter_pro_INC . '/admin/tabs/tab-social.php';
							break;
						case 'contact':
							require developer_starter_pro_INC . '/admin/tabs/tab-contact.php';
							break;
						case 'blog':
							require developer_starter_pro_INC . '/admin/tabs/tab-blog.php';
							break;
						case 'stats':
							require developer_starter_pro_INC . '/admin/tabs/tab-stats.php';
							break;
						case 'why_choose_us':
							require developer_starter_pro_INC . '/admin/tabs/tab-why-choose-us.php';
							break;
						case 'homepage_gallery':
							require developer_starter_pro_INC . '/admin/tabs/tab-homepage-gallery.php';
							break;
						case 'appointments':
							require developer_starter_pro_INC . '/admin/tabs/tab-appointments.php';
							break;
						case 'chatbot':
							require developer_starter_pro_INC . '/admin/tabs/tab-chatbot.php';
							break;
					}
					?>

					<div class="developer-starter-pro-admin-actions">
						<?php submit_button( esc_html__( 'Save Settings', 'developer-starter-pro' ), 'primary developer-starter-pro-save-btn', 'submit', false ); ?>
						<button type="button" class="button developer-starter-pro-reset-btn" id="developer-starter-pro-reset-tab">
							<?php esc_html_e( 'Reset Tab', 'developer-starter-pro' ); ?>
						</button>
					</div>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * AJAX handler to save options.
	 */
	public function ajax_save_options() {
		check_ajax_referer( 'developer_starter_pro_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'developer-starter-pro' ) ) );
		}

		// Parse the form data.
		parse_str( wp_unslash( $_POST['form_data'] ), $form_data );

		if ( isset( $form_data[ $this->option_name ] ) ) {
			$sanitized = $this->sanitize_options( $form_data[ $this->option_name ] );
			update_option( $this->option_name, $sanitized );
			wp_send_json_success( array( 'message' => esc_html__( 'Settings saved successfully!', 'developer-starter-pro' ) ) );
		}

		wp_send_json_error( array( 'message' => esc_html__( 'No data received.', 'developer-starter-pro' ) ) );
	}

}
