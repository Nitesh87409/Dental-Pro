<?php
/**
 * Hero Slider Admin — Manage Hero Slides
 *
 * Adds a settings page under DentalPro menu to manage hero slider slides.
 * Each slide has: title, subtitle, background image, CTA buttons, overlay opacity.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Hero_Slider {

	/**
	 * Option name for slides.
	 *
	 * @var string
	 */
	private $option_name = 'developer_starter_pro_hero_slides';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_submenu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'wp_ajax_developer_starter_pro_save_slides', array( $this, 'ajax_save_slides' ) );
		add_action( 'wp_ajax_developer_starter_pro_delete_slide', array( $this, 'ajax_delete_slide' ) );
	}

	/**
	 * Add submenu page under DentalPro.
	 */
	public function add_submenu() {
		add_submenu_page(
			'developer-starter-pro-settings',
			esc_html__( 'Hero Slider', 'developer-starter-pro' ),
			esc_html__( 'Hero Slider', 'developer-starter-pro' ),
			'manage_options',
			'developer-starter-pro-hero-slider',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Register settings.
	 */
	public function register_settings() {
		register_setting(
			'developer_starter_pro_hero_slides_group',
			$this->option_name,
			array( $this, 'sanitize_slides' )
		);
	}

	/**
	 * Get all slides.
	 *
	 * @return array Slides data.
	 */
	public static function get_slides() {
		$slides = get_option( 'developer_starter_pro_hero_slides', array() );

		if ( empty( $slides ) ) {
			// Return default slides.
			return array(
				array(
					'title'           => 'Welcome to <span class="highlight">DentalPro Elite</span>',
					'subtitle'        => 'Your trusted partner in dental health. Experience world-class dental care with compassion, precision, and state-of-the-art technology.',
					'bg_image'        => '',
					'bg_video'        => '',
					'overlay_opacity' => '70',
					'btn1_text'       => 'Book Appointment',
					'btn1_url'        => '#booking',
					'btn2_text'       => 'Call Now',
					'btn2_url'        => '#',
					'active'          => true,
				),
			);
		}

		return $slides;
	}

	/**
	 * Sanitize slides data.
	 *
	 * @param array $input Raw slides data.
	 * @return array Sanitized data.
	 */
	public function sanitize_slides( $input ) {
		$sanitized = array();

		if ( ! is_array( $input ) ) {
			return $sanitized;
		}

		foreach ( $input as $slide ) {
			$sanitized[] = array(
				'title'           => wp_kses( $slide['title'] ?? '', array( 'span' => array( 'class' => array() ), 'br' => array(), 'em' => array(), 'strong' => array() ) ),
				'subtitle'        => sanitize_textarea_field( $slide['subtitle'] ?? '' ),
				'bg_image'        => esc_url_raw( $slide['bg_image'] ?? '' ),
				'bg_video'        => esc_url_raw( $slide['bg_video'] ?? '' ),
				'overlay_opacity' => absint( $slide['overlay_opacity'] ?? 70 ),
				'btn1_text'       => sanitize_text_field( $slide['btn1_text'] ?? '' ),
				'btn1_url'        => esc_url_raw( $slide['btn1_url'] ?? '' ),
				'btn2_text'       => sanitize_text_field( $slide['btn2_text'] ?? '' ),
				'btn2_url'        => esc_url_raw( $slide['btn2_url'] ?? '' ),
				'active'          => isset( $slide['active'] ) ? true : false,
			);
		}

		return $sanitized;
	}

	/**
	 * Render the slider admin page.
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$slides = self::get_slides();
		?>
		<div class="wrap developer-starter-pro-admin-wrap">
			<div class="developer-starter-pro-admin-header">
				<div class="developer-starter-pro-admin-header-inner">
					<h1>
						<span class="developer-starter-pro-logo-icon">🎠</span>
						<?php esc_html_e( 'Hero Slider Management', 'developer-starter-pro' ); ?>
					</h1>
				</div>
			</div>

			<div class="developer-starter-pro-admin-content">
				<form method="post" action="options.php" id="developer-starter-pro-slides-form">
					<?php settings_fields( 'developer_starter_pro_hero_slides_group' ); ?>

					<div class="developer-starter-pro-slides-container" id="slides-container">
						<?php foreach ( $slides as $index => $slide ) : ?>
							<?php $this->render_slide_panel( $index, $slide ); ?>
						<?php endforeach; ?>
					</div>

					<div class="developer-starter-pro-slides-actions">
						<button type="button" class="button button-secondary" id="add-new-slide">
							<span class="dashicons dashicons-plus-alt2" style="vertical-align: middle; margin-right: 4px;"></span>
							<?php esc_html_e( 'Add New Slide', 'developer-starter-pro' ); ?>
						</button>
					</div>

					<div class="developer-starter-pro-admin-actions" style="margin-top: 20px;">
						<?php submit_button( esc_html__( 'Save All Slides', 'developer-starter-pro' ), 'primary developer-starter-pro-save-btn', 'submit', false ); ?>
					</div>
				</form>
			</div>

			<!-- Slide Template (hidden, used by JS to add new slides) -->
			<script type="text/template" id="slide-template">
				<?php $this->render_slide_panel( '{{INDEX}}', array(
					'title' => '', 'subtitle' => '', 'bg_image' => '', 'bg_video' => '',
					'overlay_opacity' => '70', 'btn1_text' => 'Book Appointment', 'btn1_url' => '#booking',
					'btn2_text' => 'Learn More', 'btn2_url' => '#services', 'active' => true,
				) ); ?>
			</script>
		</div>

		<style>
			.developer-starter-pro-slide-panel {
				background: #fff;
				border: 1px solid #e2e8f0;
				border-radius: 12px;
				margin-bottom: 16px;
				overflow: hidden;
			}
			.developer-starter-pro-slide-header {
				display: flex;
				align-items: center;
				justify-content: space-between;
				padding: 16px 24px;
				background: #f8fafc;
				border-bottom: 1px solid #e2e8f0;
				cursor: pointer;
			}
			.developer-starter-pro-slide-header:hover {
				background: #f1f5f9;
			}
			.developer-starter-pro-slide-header h3 {
				margin: 0;
				font-size: 1rem;
				display: flex;
				align-items: center;
				gap: 8px;
			}
			.developer-starter-pro-slide-body {
				padding: 24px;
			}
			.developer-starter-pro-slide-body .form-table th {
				width: 160px;
			}
			.developer-starter-pro-slide-actions {
				display: flex;
				gap: 8px;
			}
			.developer-starter-pro-slide-toggle-btn,
			.developer-starter-pro-slide-delete-btn {
				background: none;
				border: none;
				cursor: pointer;
				padding: 4px 8px;
				font-size: 0.8125rem;
				border-radius: 4px;
			}
			.developer-starter-pro-slide-delete-btn {
				color: #ef4444;
			}
			.developer-starter-pro-slide-delete-btn:hover {
				background: #fef2f2;
			}
			.developer-starter-pro-slide-status {
				padding: 2px 10px;
				border-radius: 20px;
				font-size: 0.75rem;
				font-weight: 600;
			}
			.developer-starter-pro-slide-status.active {
				background: #d1fae5;
				color: #065f46;
			}
			.developer-starter-pro-slide-status.inactive {
				background: #fee2e2;
				color: #991b1b;
			}
			.developer-starter-pro-bg-preview {
				margin-top: 8px;
			}
			.developer-starter-pro-bg-preview img {
				max-height: 100px;
				border-radius: 6px;
				border: 2px dashed #e2e8f0;
				padding: 4px;
			}
			.developer-starter-pro-slides-actions {
				margin-top: 16px;
			}
			.developer-starter-pro-btn-row {
				display: flex;
				gap: 16px;
			}
			.developer-starter-pro-btn-row > div {
				flex: 1;
			}
		</style>

		<script>
		jQuery(document).ready(function($) {
			var slideCount = <?php echo count( $slides ); ?>;

			// Toggle slide body
			$(document).on('click', '.developer-starter-pro-slide-header', function(e) {
				if ($(e.target).closest('.developer-starter-pro-slide-actions').length) return;
				$(this).next('.developer-starter-pro-slide-body').slideToggle(200);
			});

			// Add new slide
			$('#add-new-slide').on('click', function() {
				var template = $('#slide-template').html();
				template = template.replace(/\{\{INDEX\}\}/g, slideCount);
				$('#slides-container').append(template);
				slideCount++;
				// Scroll to new slide
				$('html, body').animate({ scrollTop: $('#slides-container .developer-starter-pro-slide-panel:last').offset().top - 100 }, 300);
			});

			// Delete slide
			$(document).on('click', '.developer-starter-pro-slide-delete-btn', function(e) {
				e.stopPropagation();
				if (confirm('<?php esc_html_e( 'Are you sure you want to remove this slide?', 'developer-starter-pro' ); ?>')) {
					$(this).closest('.developer-starter-pro-slide-panel').fadeOut(300, function() { $(this).remove(); reindexSlides(); });
				}
			});

			// Image upload for slides
			$(document).on('click', '.developer-starter-pro-slide-upload-btn', function(e) {
				e.preventDefault();
				var $btn = $(this);
				var targetInput = $btn.data('target');
				var previewId = $btn.data('preview');

				var frame = wp.media({ title: 'Select Background Image', button: { text: 'Use this image' }, multiple: false });
				frame.on('select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					$('#' + targetInput).val(attachment.url);
					$('#' + previewId).html('<img src="' + attachment.url + '" alt="">');
					$btn.siblings('.developer-starter-pro-slide-remove-btn').show();
				});
				frame.open();
			});

			$(document).on('click', '.developer-starter-pro-slide-remove-btn', function(e) {
				e.preventDefault();
				var targetInput = $(this).data('target');
				var previewId = $(this).data('preview');
				$('#' + targetInput).val('');
				$('#' + previewId).html('');
				$(this).hide();
			});

			function reindexSlides() {
				$('.developer-starter-pro-slide-panel').each(function(index) {
					$(this).find('[name]').each(function() {
						var name = $(this).attr('name');
						name = name.replace(/\[\d+\]/, '[' + index + ']');
						$(this).attr('name', name);
					});
					$(this).find('[id]').each(function() {
						var id = $(this).attr('id');
						if (id) {
							id = id.replace(/_\d+$/, '_' + index);
							$(this).attr('id', id);
						}
					});
					$(this).find('.developer-starter-pro-slide-number').text('#' + (index + 1));
				});
			}
		});
		</script>
		<?php
	}

	/**
	 * Render a single slide panel.
	 *
	 * @param int|string $index Slide index.
	 * @param array      $slide Slide data.
	 */
	private function render_slide_panel( $index, $slide ) {
		$name_prefix = $this->option_name . '[' . $index . ']';
		$is_active = isset( $slide['active'] ) && $slide['active'];
		?>
		<div class="developer-starter-pro-slide-panel">
			<div class="developer-starter-pro-slide-header">
				<h3>
					<span class="dashicons dashicons-images-alt2"></span>
					<?php esc_html_e( 'Slide', 'developer-starter-pro' ); ?>
					<span class="developer-starter-pro-slide-number">#<?php echo intval( $index ) + 1; ?></span>
					<span class="developer-starter-pro-slide-status <?php echo $is_active ? 'active' : 'inactive'; ?>">
						<?php echo $is_active ? esc_html__( 'Active', 'developer-starter-pro' ) : esc_html__( 'Inactive', 'developer-starter-pro' ); ?>
					</span>
				</h3>
				<div class="developer-starter-pro-slide-actions">
					<button type="button" class="developer-starter-pro-slide-delete-btn" title="<?php esc_attr_e( 'Delete', 'developer-starter-pro' ); ?>">
						<span class="dashicons dashicons-trash"></span>
					</button>
				</div>
			</div>
			<div class="developer-starter-pro-slide-body">
				<table class="form-table">
					<tr>
						<th><label><?php esc_html_e( 'Active', 'developer-starter-pro' ); ?></label></th>
						<td>
							<label><input type="checkbox" name="<?php echo esc_attr( $name_prefix ); ?>[active]" value="1" <?php checked( $is_active ); ?>> <?php esc_html_e( 'Show this slide', 'developer-starter-pro' ); ?></label>
						</td>
					</tr>
					<tr>
						<th><label><?php esc_html_e( 'Title', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="text" name="<?php echo esc_attr( $name_prefix ); ?>[title]" value="<?php echo esc_attr( $slide['title'] ?? '' ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'Slide heading — use <span class=&quot;highlight&quot;>text</span> for colored text', 'developer-starter-pro' ); ?>">
						</td>
					</tr>
					<tr>
						<th><label><?php esc_html_e( 'Subtitle', 'developer-starter-pro' ); ?></label></th>
						<td>
							<textarea name="<?php echo esc_attr( $name_prefix ); ?>[subtitle]" rows="2" class="large-text" placeholder="<?php esc_attr_e( 'Slide description text', 'developer-starter-pro' ); ?>"><?php echo esc_textarea( $slide['subtitle'] ?? '' ); ?></textarea>
						</td>
					</tr>
					<tr>
						<th><label><?php esc_html_e( 'Background Image', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="hidden" id="slide_bg_image_<?php echo esc_attr( $index ); ?>" name="<?php echo esc_attr( $name_prefix ); ?>[bg_image]" value="<?php echo esc_url( $slide['bg_image'] ?? '' ); ?>">
							<div class="developer-starter-pro-bg-preview" id="slide_bg_preview_<?php echo esc_attr( $index ); ?>">
								<?php if ( ! empty( $slide['bg_image'] ) ) : ?>
									<img src="<?php echo esc_url( $slide['bg_image'] ); ?>" alt="">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-slide-upload-btn" data-target="slide_bg_image_<?php echo esc_attr( $index ); ?>" data-preview="slide_bg_preview_<?php echo esc_attr( $index ); ?>">
								<?php esc_html_e( 'Upload Image', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-slide-remove-btn" data-target="slide_bg_image_<?php echo esc_attr( $index ); ?>" data-preview="slide_bg_preview_<?php echo esc_attr( $index ); ?>" <?php echo empty( $slide['bg_image'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</td>
					</tr>
					<tr>
						<th><label><?php esc_html_e( 'Background Video URL', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="url" name="<?php echo esc_attr( $name_prefix ); ?>[bg_video]" value="<?php echo esc_url( $slide['bg_video'] ?? '' ); ?>" class="regular-text" placeholder="https://example.com/video.mp4">
							<p class="description"><?php esc_html_e( 'Optional. MP4 video URL for video background. Overrides image.', 'developer-starter-pro' ); ?></p>
						</td>
					</tr>
					<tr>
						<th><label><?php esc_html_e( 'Overlay Opacity', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="range" name="<?php echo esc_attr( $name_prefix ); ?>[overlay_opacity]" value="<?php echo esc_attr( $slide['overlay_opacity'] ?? 70 ); ?>" min="0" max="100" step="5" style="width: 200px;">
							<span><?php echo esc_html( ( $slide['overlay_opacity'] ?? 70 ) . '%' ); ?></span>
						</td>
					</tr>
				</table>

				<h4 style="margin: 20px 0 10px;"><?php esc_html_e( 'CTA Buttons', 'developer-starter-pro' ); ?></h4>
				<div class="developer-starter-pro-btn-row">
					<div>
						<label><strong><?php esc_html_e( 'Button 1 Text', 'developer-starter-pro' ); ?></strong></label><br>
						<input type="text" name="<?php echo esc_attr( $name_prefix ); ?>[btn1_text]" value="<?php echo esc_attr( $slide['btn1_text'] ?? '' ); ?>" class="regular-text"><br>
						<label><strong><?php esc_html_e( 'Button 1 URL', 'developer-starter-pro' ); ?></strong></label><br>
						<input type="text" name="<?php echo esc_attr( $name_prefix ); ?>[btn1_url]" value="<?php echo esc_attr( $slide['btn1_url'] ?? '' ); ?>" class="regular-text">
					</div>
					<div>
						<label><strong><?php esc_html_e( 'Button 2 Text', 'developer-starter-pro' ); ?></strong></label><br>
						<input type="text" name="<?php echo esc_attr( $name_prefix ); ?>[btn2_text]" value="<?php echo esc_attr( $slide['btn2_text'] ?? '' ); ?>" class="regular-text"><br>
						<label><strong><?php esc_html_e( 'Button 2 URL', 'developer-starter-pro' ); ?></strong></label><br>
						<input type="text" name="<?php echo esc_attr( $name_prefix ); ?>[btn2_url]" value="<?php echo esc_attr( $slide['btn2_url'] ?? '' ); ?>" class="regular-text">
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * AJAX save slides.
	 */
	public function ajax_save_slides() {
		check_ajax_referer( 'developer_starter_pro_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Permission denied.' ) );
		}

		parse_str( $_POST['form_data'], $form_data );

		if ( isset( $form_data[ $this->option_name ] ) ) {
			$sanitized = $this->sanitize_slides( $form_data[ $this->option_name ] );
			update_option( $this->option_name, $sanitized );
			wp_send_json_success( array( 'message' => 'Slides saved!' ) );
		}

		wp_send_json_error( array( 'message' => 'No data received.' ) );
	}

	/**
	 * AJAX delete slide.
	 */
	public function ajax_delete_slide() {
		check_ajax_referer( 'developer_starter_pro_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$index = absint( $_POST['slide_index'] ?? -1 );
		$slides = get_option( $this->option_name, array() );

		if ( isset( $slides[ $index ] ) ) {
			unset( $slides[ $index ] );
			$slides = array_values( $slides );
			update_option( $this->option_name, $slides );
			wp_send_json_success();
		}

		wp_send_json_error();
	}
}
