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

		$active_tab = isset( $input['active_tab'] ) ? sanitize_key( $input['active_tab'] ) : '';

		if ( empty( $active_tab ) || 'general' === $active_tab ) {
			// General.
			$sanitized['clinic_name']    = isset( $input['clinic_name'] ) ? sanitize_text_field( $input['clinic_name'] ) : '';
			$sanitized['clinic_phone']   = isset( $input['clinic_phone'] ) ? sanitize_text_field( $input['clinic_phone'] ) : '';
			$sanitized['clinic_email']   = isset( $input['clinic_email'] ) ? sanitize_email( $input['clinic_email'] ) : '';
			$sanitized['clinic_address'] = isset( $input['clinic_address'] ) ? sanitize_textarea_field( $input['clinic_address'] ) : '';
			$sanitized['clinic_logo']    = isset( $input['clinic_logo'] ) ? esc_url_raw( $input['clinic_logo'] ) : '';
			$sanitized['clinic_logo_height'] = isset( $input['clinic_logo_height'] ) ? absint( $input['clinic_logo_height'] ) : 45;
			$sanitized['hero_image']     = isset( $input['hero_image'] ) ? esc_url_raw( $input['hero_image'] ) : '';
			$sanitized['hero_video']     = isset( $input['hero_video'] ) ? esc_url_raw( $input['hero_video'] ) : '';
			$sanitized['page_banner_image'] = isset( $input['page_banner_image'] ) ? esc_url_raw( $input['page_banner_image'] ) : '';
		}

		if ( empty( $active_tab ) || 'colors' === $active_tab ) {
			// Colors.
			$sanitized['color_primary']     = isset( $input['color_primary'] ) ? developer_starter_pro_sanitize_hex_color( $input['color_primary'] ) : '#0D9488';
			$sanitized['color_secondary']   = isset( $input['color_secondary'] ) ? developer_starter_pro_sanitize_hex_color( $input['color_secondary'] ) : '#1E293B';
			$sanitized['color_accent']      = isset( $input['color_accent'] ) ? developer_starter_pro_sanitize_hex_color( $input['color_accent'] ) : '#F59E0B';
		}

		if ( empty( $active_tab ) || 'header' === $active_tab ) {
			// Header.
			$sanitized['header_style']  = isset( $input['header_style'] ) ? sanitize_text_field( $input['header_style'] ) : '1';
			$sanitized['header_sticky'] = isset( $input['header_sticky'] ) ? '1' : '0';
		}

		if ( empty( $active_tab ) || 'footer' === $active_tab ) {
			// Footer.
			$sanitized['footer_style'] = isset( $input['footer_style'] ) ? sanitize_text_field( $input['footer_style'] ) : '1';
		}

		if ( empty( $active_tab ) || 'social' === $active_tab ) {
			// Social Media.
			$social_fields = array( 
				'social_facebook', 
				'social_instagram', 
				'social_twitter', 
				'social_youtube', 
				'social_linkedin',
				'social_tiktok',
				'social_pinterest',
				'social_custom_1_url',
				'social_custom_2_url'
			);
			foreach ( $social_fields as $field ) {
				$sanitized[ $field ] = isset( $input[ $field ] ) ? esc_url_raw( $input[ $field ] ) : '';
			}

			// Sanitize custom labels and icons
			$sanitized['social_custom_1_label'] = isset( $input['social_custom_1_label'] ) ? sanitize_text_field( $input['social_custom_1_label'] ) : '';
			$sanitized['social_custom_2_label'] = isset( $input['social_custom_2_label'] ) ? sanitize_text_field( $input['social_custom_2_label'] ) : '';
			$sanitized['social_custom_1_icon']  = isset( $input['social_custom_1_icon'] ) ? sanitize_text_field( $input['social_custom_1_icon'] ) : '🔗';
			$sanitized['social_custom_2_icon']  = isset( $input['social_custom_2_icon'] ) ? sanitize_text_field( $input['social_custom_2_icon'] ) : '🔗';
		}

		if ( empty( $active_tab ) || 'contact' === $active_tab ) {
			// Contact.
			$sanitized['google_maps_key'] = isset( $input['google_maps_key'] ) ? sanitize_text_field( $input['google_maps_key'] ) : '';
			
			// Sanitize map embed code allowing iframe tags
			$allowed_iframe = array(
				'iframe' => array(
					'src'             => true,
					'width'           => true,
					'height'          => true,
					'style'           => true,
					'frameborder'     => true,
					'allowfullscreen' => true,
					'loading'         => true,
					'referrerpolicy'  => true,
					'class'           => true,
					'id'              => true,
				),
			);
			$sanitized['map_embed_code'] = isset( $input['map_embed_code'] ) ? wp_kses( $input['map_embed_code'], $allowed_iframe ) : '';
			$sanitized['emergency_phone'] = isset( $input['emergency_phone'] ) ? sanitize_text_field( $input['emergency_phone'] ) : '';
			$sanitized['whatsapp_enabled']  = isset( $input['whatsapp_enabled'] ) ? '1' : '0';
			$sanitized['whatsapp_number']   = isset( $input['whatsapp_number'] ) ? sanitize_text_field( $input['whatsapp_number'] ) : '';
			$sanitized['whatsapp_message']  = isset( $input['whatsapp_message'] ) ? sanitize_text_field( $input['whatsapp_message'] ) : '';
			$sanitized['whatsapp_position'] = isset( $input['whatsapp_position'] ) ? sanitize_text_field( $input['whatsapp_position'] ) : 'right';

			// Working Hours.
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
		}

		if ( empty( $active_tab ) || 'blog' === $active_tab ) {
			// Blog section options
			$sanitized['blog_section_enabled']  = isset( $input['blog_section_enabled'] ) ? '1' : '0';
			$sanitized['blog_section_eyebrow']  = isset( $input['blog_section_eyebrow'] ) ? sanitize_text_field( $input['blog_section_eyebrow'] ) : '';
			$sanitized['blog_section_title']    = isset( $input['blog_section_title'] ) ? sanitize_text_field( $input['blog_section_title'] ) : '';
			$sanitized['blog_section_subtitle'] = isset( $input['blog_section_subtitle'] ) ? sanitize_textarea_field( $input['blog_section_subtitle'] ) : '';
			$sanitized['blog_section_count']    = isset( $input['blog_section_count'] ) ? absint( $input['blog_section_count'] ) : 3;
		}

		if ( empty( $active_tab ) || 'appointments' === $active_tab ) {
			// Appointment options
			$sanitized['appointment_approval_mode'] = isset( $input['appointment_approval_mode'] ) ? sanitize_text_field( $input['appointment_approval_mode'] ) : 'automatic';
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
						<span class="developer-starter-pro-logo-icon">🦷</span>
						<?php esc_html_e( 'DentalPro Elite Settings', 'developer-starter-pro' ); ?>
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
					'appointments' => array(
						'label' => esc_html__( 'Appointment Settings', 'developer-starter-pro' ),
						'icon'  => 'dashicons-calendar-alt',
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
							$this->render_tab_general( $options );
							break;
						case 'colors':
							$this->render_tab_colors( $options );
							break;
						case 'header':
							$this->render_tab_header( $options );
							break;
						case 'footer':
							$this->render_tab_footer( $options );
							break;
						case 'social':
							$this->render_tab_social( $options );
							break;
						case 'contact':
							$this->render_tab_contact( $options );
							break;
						case 'blog':
							$this->render_tab_blog( $options );
							break;
						case 'appointments':
							$this->render_tab_appointments( $options );
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
	 * Render General tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_general( $options ) {
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Clinic Information', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Basic information about your dental clinic.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="clinic_logo"><?php esc_html_e( 'Clinic Logo', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="clinic_logo" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_logo]" value="<?php echo esc_url( $options['clinic_logo'] ); ?>">
							<div class="developer-starter-pro-logo-preview" id="logo-preview">
								<?php if ( ! empty( $options['clinic_logo'] ) ) : ?>
									<img src="<?php echo esc_url( $options['clinic_logo'] ); ?>" alt="Logo">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="clinic_logo" data-preview="logo-preview">
								<?php esc_html_e( 'Upload Logo', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="clinic_logo" data-preview="logo-preview" <?php echo empty( $options['clinic_logo'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="clinic_logo_height"><?php esc_html_e( 'Logo Height (px)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="number" id="clinic_logo_height" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_logo_height]" value="<?php echo esc_attr( isset( $options['clinic_logo_height'] ) ? $options['clinic_logo_height'] : 45 ); ?>" min="20" max="150" class="small-text">
						<p class="description"><?php esc_html_e( 'Adjust the maximum height of the clinic logo in pixels (default is 45px).', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="hero_image"><?php esc_html_e( 'Hero Background Image', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="hero_image" name="<?php echo esc_attr( $this->option_name ); ?>[hero_image]" value="<?php echo esc_url( isset( $options['hero_image'] ) ? $options['hero_image'] : '' ); ?>">
							<div class="developer-starter-pro-logo-preview" id="hero-image-preview" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
								<?php if ( ! empty( $options['hero_image'] ) ) : ?>
									<img src="<?php echo esc_url( $options['hero_image'] ); ?>" alt="Hero Image" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="hero_image" data-preview="hero-image-preview">
								<?php esc_html_e( 'Upload Background', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="hero_image" data-preview="hero-image-preview" <?php echo empty( $options['hero_image'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
						<p class="description"><?php esc_html_e( 'Upload a full background image for the hero banner (recommended dimensions: 1920x800px). If empty, the default multi-layered layout will be used.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="page_banner_image"><?php esc_html_e( 'Page Banner Background Image', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="page_banner_image" name="<?php echo esc_attr( $this->option_name ); ?>[page_banner_image]" value="<?php echo esc_url( isset( $options['page_banner_image'] ) ? $options['page_banner_image'] : '' ); ?>">
							<div class="developer-starter-pro-logo-preview" id="page-banner-image-preview" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
								<?php if ( ! empty( $options['page_banner_image'] ) ) : ?>
									<img src="<?php echo esc_url( $options['page_banner_image'] ); ?>" alt="Page Banner Image" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="page_banner_image" data-preview="page-banner-image-preview">
								<?php esc_html_e( 'Upload Page Banner', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="page_banner_image" data-preview="page-banner-image-preview" <?php echo empty( $options['page_banner_image'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
						<p class="description"><?php esc_html_e( 'Upload a background image for all archive/inner page banners (recommended: 1920x400px). If empty, the default clinic interior background is used.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="hero_video"><?php esc_html_e( 'Hero Background Video (MP4)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="text" id="hero_video" name="<?php echo esc_attr( $this->option_name ); ?>[hero_video]" value="<?php echo esc_url( isset( $options['hero_video'] ) ? $options['hero_video'] : '' ); ?>" class="regular-text" style="margin-bottom: 10px; display: inline-block; vertical-align: middle;">
							<div class="developer-starter-pro-logo-preview" id="hero-video-preview" style="max-width: 300px; margin-bottom: 10px;">
								<?php if ( ! empty( $options['hero_video'] ) ) : ?>
									<video src="<?php echo esc_url( $options['hero_video'] ); ?>" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;" autoplay loop muted playsinline></video>
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="hero_video" data-preview="hero-video-preview" data-type="video">
								<?php esc_html_e( 'Upload Video', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="hero_video" data-preview="hero-video-preview" <?php echo empty( $options['hero_video'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
						<p class="description"><?php esc_html_e( 'Select/upload a self-hosted MP4 background video or paste a direct video URL. If configured, it will play as a muted background instead of the static hero background image or multi-layer graphics.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="clinic_name"><?php esc_html_e( 'Clinic Name', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="clinic_name" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_name]" value="<?php echo esc_attr( $options['clinic_name'] ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="clinic_phone"><?php esc_html_e( 'Phone Number', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="tel" id="clinic_phone" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_phone]" value="<?php echo esc_attr( $options['clinic_phone'] ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="clinic_email"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="email" id="clinic_email" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_email]" value="<?php echo esc_attr( $options['clinic_email'] ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="clinic_address"><?php esc_html_e( 'Address', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="clinic_address" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_address]" rows="3" class="large-text"><?php echo esc_textarea( $options['clinic_address'] ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Colors tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_colors( $options ) {
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Color Scheme', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Customize the color scheme of your theme.', 'developer-starter-pro' ); ?></p>

			<!-- Pre-made Skins Library -->
			<div class="developer-starter-pro-skins-library">
				<h3><?php esc_html_e( 'Pre-made Skins Library', 'developer-starter-pro' ); ?></h3>
				<p class="description"><?php esc_html_e( 'Click on the apply button to preview and load a pre-made color scheme.', 'developer-starter-pro' ); ?></p>
				
				<div class="skins-grid">
					<!-- Skin: Main -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Main (Teal)', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #0D9488;" title="Primary"></span>
							<span class="color-block" style="background-color: #1E293B;" title="Secondary"></span>
							<span class="color-block" style="background-color: #F59E0B;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#0D9488" 
								data-secondary="#1E293B" 
								data-accent="#F59E0B">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>

					<!-- Skin: Classic Blue -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Classic Blue', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #1E6FD9;" title="Primary"></span>
							<span class="color-block" style="background-color: #0F172A;" title="Secondary"></span>
							<span class="color-block" style="background-color: #60A5FA;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#1E6FD9" 
								data-secondary="#0F172A" 
								data-accent="#60A5FA">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>

					<!-- Skin: Forest Green -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Forest Green', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #4E7C59;" title="Primary"></span>
							<span class="color-block" style="background-color: #111827;" title="Secondary"></span>
							<span class="color-block" style="background-color: #82B08D;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#4E7C59" 
								data-secondary="#111827" 
								data-accent="#82B08D">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>

					<!-- Skin: Lavender Gray -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Lavender Gray', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #8F9BB3;" title="Primary"></span>
							<span class="color-block" style="background-color: #1A202C;" title="Secondary"></span>
							<span class="color-block" style="background-color: #CBD5E1;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#8F9BB3" 
								data-secondary="#1A202C" 
								data-accent="#CBD5E1">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>
				</div>
			</div>

			<table class="form-table">
				<tr>
					<th><label for="color_primary"><?php esc_html_e( 'Primary Color', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="color_primary" name="<?php echo esc_attr( $this->option_name ); ?>[color_primary]" value="<?php echo esc_attr( $options['color_primary'] ); ?>" class="developer-starter-pro-color-picker" data-default-color="#0D9488">
						<p class="description"><?php esc_html_e( 'Main theme color — buttons, links, accents.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="color_secondary"><?php esc_html_e( 'Secondary Color', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="color_secondary" name="<?php echo esc_attr( $this->option_name ); ?>[color_secondary]" value="<?php echo esc_attr( $options['color_secondary'] ); ?>" class="developer-starter-pro-color-picker" data-default-color="#1E293B">
						<p class="description"><?php esc_html_e( 'Headings, dark backgrounds.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="color_accent"><?php esc_html_e( 'Accent Color', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="color_accent" name="<?php echo esc_attr( $this->option_name ); ?>[color_accent]" value="<?php echo esc_attr( $options['color_accent'] ); ?>" class="developer-starter-pro-color-picker" data-default-color="#F59E0B">
						<p class="description"><?php esc_html_e( 'Highlights, badges, CTAs.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>

			</table>

			<div class="developer-starter-pro-color-preview">
				<h3><?php esc_html_e( 'Preview', 'developer-starter-pro' ); ?></h3>
				<div class="developer-starter-pro-color-swatches">
					<div class="swatch" id="swatch-primary" style="background-color: <?php echo esc_attr( $options['color_primary'] ); ?>">
						<span><?php esc_html_e( 'Primary', 'developer-starter-pro' ); ?></span>
					</div>
					<div class="swatch" id="swatch-secondary" style="background-color: <?php echo esc_attr( $options['color_secondary'] ); ?>">
						<span><?php esc_html_e( 'Secondary', 'developer-starter-pro' ); ?></span>
					</div>
					<div class="swatch" id="swatch-accent" style="background-color: <?php echo esc_attr( $options['color_accent'] ); ?>">
						<span><?php esc_html_e( 'Accent', 'developer-starter-pro' ); ?></span>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Header tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_header( $options ) {
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Header Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the header layout and behavior.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label><?php esc_html_e( 'Header Style', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-header-styles">
							<?php
							$header_styles = array(
								'1' => esc_html__( 'Classic — Logo left, menu right', 'developer-starter-pro' ),
								'2' => esc_html__( 'Centered — Logo center, menu below', 'developer-starter-pro' ),
								'3' => esc_html__( 'Full Width — Top bar + main header', 'developer-starter-pro' ),
								'4' => esc_html__( 'Transparent — Overlay on hero', 'developer-starter-pro' ),
							);
							foreach ( $header_styles as $value => $label ) : ?>
								<label class="developer-starter-pro-radio-card <?php echo $options['header_style'] === $value ? 'selected' : ''; ?>">
									<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[header_style]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $options['header_style'], $value ); ?>>
									<span class="developer-starter-pro-radio-card-label">
										<strong><?php echo esc_html( sprintf( __( 'Style %s', 'developer-starter-pro' ), $value ) ); ?></strong>
										<span><?php echo esc_html( $label ); ?></span>
									</span>
								</label>
							<?php endforeach; ?>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="header_sticky"><?php esc_html_e( 'Sticky Header', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="header_sticky" name="<?php echo esc_attr( $this->option_name ); ?>[header_sticky]" value="1" <?php checked( $options['header_sticky'], '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Enable sticky header on scroll', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Footer tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_footer( $options ) {
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Footer Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the footer layout.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label><?php esc_html_e( 'Footer Style', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-header-styles">
							<?php
							$footer_styles = array(
								'1' => esc_html__( '4 Columns — Full featured footer', 'developer-starter-pro' ),
								'2' => esc_html__( '3 Columns — With newsletter signup', 'developer-starter-pro' ),
								'3' => esc_html__( 'Minimal — 2 columns, clean design', 'developer-starter-pro' ),
							);
							foreach ( $footer_styles as $value => $label ) : ?>
								<label class="developer-starter-pro-radio-card <?php echo $options['footer_style'] === $value ? 'selected' : ''; ?>">
									<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[footer_style]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $options['footer_style'], $value ); ?>>
									<span class="developer-starter-pro-radio-card-label">
										<strong><?php echo esc_html( sprintf( __( 'Style %s', 'developer-starter-pro' ), $value ) ); ?></strong>
										<span><?php echo esc_html( $label ); ?></span>
									</span>
								</label>
							<?php endforeach; ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Social Media tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_social( $options ) {
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Social Media Links', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Add your social media profile URLs. Leave empty to hide.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<?php
				$social_platforms = array(
					'social_facebook'  => array( 'label' => 'Facebook',   'icon' => '📘', 'placeholder' => 'https://facebook.com/yourclinic' ),
					'social_instagram' => array( 'label' => 'Instagram',  'icon' => '📸', 'placeholder' => 'https://instagram.com/yourclinic' ),
					'social_twitter'   => array( 'label' => 'Twitter / X', 'icon' => '🐦', 'placeholder' => 'https://x.com/yourclinic' ),
					'social_youtube'   => array( 'label' => 'YouTube',    'icon' => '📺', 'placeholder' => 'https://youtube.com/@yourclinic' ),
					'social_linkedin'  => array( 'label' => 'LinkedIn',   'icon' => '💼', 'placeholder' => 'https://linkedin.com/company/yourclinic' ),
					'social_tiktok'    => array( 'label' => 'TikTok',     'icon' => '🎵', 'placeholder' => 'https://tiktok.com/@yourclinic' ),
					'social_pinterest' => array( 'label' => 'Pinterest',  'icon' => '📌', 'placeholder' => 'https://pinterest.com/yourclinic' ),
				);

				foreach ( $social_platforms as $key => $platform ) : ?>
					<tr>
						<th>
							<label for="<?php echo esc_attr( $key ); ?>">
								<?php echo esc_html( $platform['icon'] . ' ' . $platform['label'] ); ?>
							</label>
						</th>
						<td>
							<input type="url" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $this->option_name ); ?>[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_url( isset( $options[ $key ] ) ? $options[ $key ] : '' ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $platform['placeholder'] ); ?>">
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

			<h3 style="margin-top: 40px; margin-bottom: 5px; font-size: 1.2em; border-bottom: 1px solid #ddd; padding-bottom: 5px;"><?php esc_html_e( 'Custom Social Links', 'developer-starter-pro' ); ?></h3>
			<p class="description"><?php esc_html_e( 'Add custom links (e.g. blog, portal, or other platforms) with custom emojis, labels, and URLs.', 'developer-starter-pro' ); ?></p>
			
			<table class="form-table">
				<tr>
					<th><label><?php esc_html_e( 'Custom Link 1', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div style="display: flex; gap: 10px; max-width: 800px; align-items: center;">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_1_icon]" value="<?php echo esc_attr( isset($options['social_custom_1_icon']) ? $options['social_custom_1_icon'] : '🔗' ); ?>" style="width: 60px; text-align: center;" placeholder="Icon (Emoji)" title="Emoji Icon">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_1_label]" value="<?php echo esc_attr( isset($options['social_custom_1_label']) ? $options['social_custom_1_label'] : '' ); ?>" style="flex: 1;" placeholder="Label (e.g., Blog)">
							<input type="url" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_1_url]" value="<?php echo esc_url( isset($options['social_custom_1_url']) ? $options['social_custom_1_url'] : '' ); ?>" style="flex: 2;" placeholder="URL (https://...)">
						</div>
					</td>
				</tr>
				<tr>
					<th><label><?php esc_html_e( 'Custom Link 2', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div style="display: flex; gap: 10px; max-width: 800px; align-items: center;">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_2_icon]" value="<?php echo esc_attr( isset($options['social_custom_2_icon']) ? $options['social_custom_2_icon'] : '🔗' ); ?>" style="width: 60px; text-align: center;" placeholder="Icon (Emoji)" title="Emoji Icon">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_2_label]" value="<?php echo esc_attr( isset($options['social_custom_2_label']) ? $options['social_custom_2_label'] : '' ); ?>" style="flex: 1;" placeholder="Label (e.g., Portal)">
							<input type="url" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_2_url]" value="<?php echo esc_url( isset($options['social_custom_2_url']) ? $options['social_custom_2_url'] : '' ); ?>" style="flex: 2;" placeholder="URL (https://...)">
						</div>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Contact tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_contact( $options ) {
		$working_hours = isset( $options['working_hours'] ) ? $options['working_hours'] : developer_starter_pro_get_default_options()['working_hours'];

		$days = array(
			'monday'    => esc_html__( 'Monday', 'developer-starter-pro' ),
			'tuesday'   => esc_html__( 'Tuesday', 'developer-starter-pro' ),
			'wednesday' => esc_html__( 'Wednesday', 'developer-starter-pro' ),
			'thursday'  => esc_html__( 'Thursday', 'developer-starter-pro' ),
			'friday'    => esc_html__( 'Friday', 'developer-starter-pro' ),
			'saturday'  => esc_html__( 'Saturday', 'developer-starter-pro' ),
			'sunday'    => esc_html__( 'Sunday', 'developer-starter-pro' ),
		);
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Contact & Maps', 'developer-starter-pro' ); ?></h2>

			<table class="form-table">
				<tr>
					<th><label for="google_maps_key"><?php esc_html_e( 'Google Maps API Key', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="google_maps_key" name="<?php echo esc_attr( $this->option_name ); ?>[google_maps_key]" value="<?php echo esc_attr( $options['google_maps_key'] ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Required for Google Maps on the contact page.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="map_embed_code"><?php esc_html_e( 'Google Maps Embed Code / Iframe', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="map_embed_code" name="<?php echo esc_attr( $this->option_name ); ?>[map_embed_code]" rows="4" class="large-text" placeholder="<?php echo esc_attr( '<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' ); ?>"><?php echo esc_textarea( isset( $options['map_embed_code'] ) ? $options['map_embed_code'] : '' ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Paste the full Google Maps iframe embed code here (from Google Maps: Share -> Embed a map -> Copy HTML). If empty, the theme will automatically load a map based on your clinic address, or fall back to the vector map if no address is set.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="emergency_phone"><?php esc_html_e( 'Emergency Phone', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="tel" id="emergency_phone" name="<?php echo esc_attr( $this->option_name ); ?>[emergency_phone]" value="<?php echo esc_attr( $options['emergency_phone'] ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Displayed in the floating emergency call button.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_enabled"><?php esc_html_e( 'WhatsApp Floating Button', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="whatsapp_enabled" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_enabled]" value="1" <?php checked( $options['whatsapp_enabled'], '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Enable floating WhatsApp button', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_number"><?php esc_html_e( 'WhatsApp Number', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="whatsapp_number" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_number]" value="<?php echo esc_attr( $options['whatsapp_number'] ); ?>" class="regular-text" placeholder="e.g., 919876543210">
						<p class="description"><?php esc_html_e( 'Include country code without spaces, + or leading zeros (e.g. 15551234567 or 919876543210).', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_message"><?php esc_html_e( 'WhatsApp Default Message', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="whatsapp_message" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_message]" rows="2" class="large-text"><?php echo esc_textarea( $options['whatsapp_message'] ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Pre-filled message when patient starts a chat.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_position"><?php esc_html_e( 'Button Position', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="whatsapp_position" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_position]">
							<option value="right" <?php selected( $options['whatsapp_position'], 'right' ); ?>><?php esc_html_e( 'Bottom Right', 'developer-starter-pro' ); ?></option>
							<option value="left" <?php selected( $options['whatsapp_position'], 'left' ); ?>><?php esc_html_e( 'Bottom Left', 'developer-starter-pro' ); ?></option>
						</select>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Working Hours', 'developer-starter-pro' ); ?></h2>

			<table class="widefat fixed striped developer-starter-pro-working-hours">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Day', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Opening Time', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Closing Time', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Closed?', 'developer-starter-pro' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $days as $day_key => $day_label ) :
					$open   = isset( $working_hours[ $day_key ]['open'] ) ? $working_hours[ $day_key ]['open'] : '';
					$close  = isset( $working_hours[ $day_key ]['close'] ) ? $working_hours[ $day_key ]['close'] : '';
					$closed = isset( $working_hours[ $day_key ]['closed'] ) ? $working_hours[ $day_key ]['closed'] : false;
				?>
					<tr>
						<td><strong><?php echo esc_html( $day_label ); ?></strong></td>
						<td>
							<input type="time" name="<?php echo esc_attr( $this->option_name ); ?>[working_hours][<?php echo esc_attr( $day_key ); ?>][open]" value="<?php echo esc_attr( $open ); ?>">
						</td>
						<td>
							<input type="time" name="<?php echo esc_attr( $this->option_name ); ?>[working_hours][<?php echo esc_attr( $day_key ); ?>][close]" value="<?php echo esc_attr( $close ); ?>">
						</td>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $this->option_name ); ?>[working_hours][<?php echo esc_attr( $day_key ); ?>][closed]" value="1" <?php checked( $closed, true ); ?>>
								<?php esc_html_e( 'Closed', 'developer-starter-pro' ); ?>
							</label>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Homepage Blog tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_blog( $options ) {
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Homepage Blog Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the latest articles showcase section on your homepage.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="blog_section_enabled"><?php esc_html_e( 'Enable Blog Section', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="blog_section_enabled" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_enabled]" value="1" <?php checked( isset( $options['blog_section_enabled'] ) ? $options['blog_section_enabled'] : '1', '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Show latest posts on the homepage', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_eyebrow"><?php esc_html_e( 'Section Badge / Eyebrow', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="blog_section_eyebrow" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_eyebrow]" value="<?php echo esc_attr( isset( $options['blog_section_eyebrow'] ) ? $options['blog_section_eyebrow'] : 'Dental Insights' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_title"><?php esc_html_e( 'Section Title', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="blog_section_title" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_title]" value="<?php echo esc_attr( isset( $options['blog_section_title'] ) ? $options['blog_section_title'] : 'Latest News & Articles' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_subtitle"><?php esc_html_e( 'Section Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="blog_section_subtitle" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_subtitle]" rows="3" class="large-text"><?php echo esc_textarea( isset( $options['blog_section_subtitle'] ) ? $options['blog_section_subtitle'] : 'Stay informed with standard dental health tips and advice from our clinical experts.' ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_count"><?php esc_html_e( 'Post Display Count', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="number" id="blog_section_count" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_count]" value="<?php echo esc_attr( isset( $options['blog_section_count'] ) ? $options['blog_section_count'] : 3 ); ?>" min="1" max="12" class="small-text">
						<p class="description"><?php esc_html_e( 'Choose how many latest blog posts to show in the homepage grid.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Appointments tab.
	 *
	 * @param array $options Current options.
	 */
	private function render_tab_appointments( $options ) {
		$mode = isset( $options['appointment_approval_mode'] ) ? $options['appointment_approval_mode'] : 'automatic';
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Appointment Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the booking approval mode.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><?php esc_html_e( 'Appointment Approval Mode', 'developer-starter-pro' ); ?></th>
					<td>
						<fieldset>
							<label style="display:block; margin-bottom:15px;">
								<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[appointment_approval_mode]" value="automatic" <?php checked( $mode, 'automatic' ); ?>>
								<strong><?php esc_html_e( 'Automatic Approval', 'developer-starter-pro' ); ?></strong>
								<p class="description" style="margin-left: 24px; margin-top:4px;"><?php esc_html_e( 'Appointments are automatically confirmed immediately. Patients receive instant confirmations, and the status is set to "Confirmed".', 'developer-starter-pro' ); ?></p>
							</label>
							<label style="display:block;">
								<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[appointment_approval_mode]" value="manual" <?php checked( $mode, 'manual' ); ?>>
								<strong><?php esc_html_e( 'Manual Approval', 'developer-starter-pro' ); ?></strong>
								<p class="description" style="margin-left: 24px; margin-top:4px;"><?php esc_html_e( 'Appointments remain "Pending" upon submission. Admin receives notification to Approve, Reject, Reschedule, or Cancel, and the patient is notified of status changes.', 'developer-starter-pro' ); ?></p>
							</label>
						</fieldset>
					</td>
				</tr>
			</table>
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
