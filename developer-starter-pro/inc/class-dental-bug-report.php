<?php
/**
 * Bug / Problem Report System
 *
 * Provides a floating "Report a Problem" button on the frontend.
 * When clicked, opens a modal form where visitors can describe the issue,
 * optionally attach a screenshot, and send it as an email to the site admin.
 *
 * @package developer-starter-pro
 * @since   1.0.6
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Bug_Report {

	/**
	 * Rate limit: max reports per IP per hour.
	 */
	private $rate_limit = 5;

	/**
	 * Constructor — hook into WordPress.
	 */
	public function __construct() {
		// AJAX handlers (logged-in and guests).
		add_action( 'wp_ajax_developer_starter_pro_bug_report', array( $this, 'handle_bug_report' ) );
		add_action( 'wp_ajax_nopriv_developer_starter_pro_bug_report', array( $this, 'handle_bug_report' ) );

		// Inject the floating button + modal into the frontend footer.
		add_action( 'wp_footer', array( $this, 'render_bug_report_widget' ) );

		// Enqueue styles and scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue minimal inline CSS & JS for the bug report widget.
	 */
	public function enqueue_assets() {
		if ( is_admin() ) {
			return;
		}

		$options = get_option( 'developer_starter_pro_options', array() );
		$enabled = isset( $options['bugreport_enable'] ) && '1' === $options['bugreport_enable'];
		if ( ! $enabled ) {
			return;
		}

		// Register a dummy handle for inline styles/scripts.
		wp_register_style( 'developer-starter-pro-bugreport', false );
		wp_enqueue_style( 'developer-starter-pro-bugreport' );
		wp_add_inline_style( 'developer-starter-pro-bugreport', $this->get_inline_css() );
	}

	/**
	 * AJAX handler: process the bug report form submission.
	 */
	public function handle_bug_report() {
		// Verify nonce.
		check_ajax_referer( 'developer_starter_pro_nonce', 'nonce' );

		// Rate limiting by IP.
		$ip = $this->get_client_ip();
		$transient_key = 'dp_bugreport_' . md5( $ip );
		$count = (int) get_transient( $transient_key );

		if ( $count >= $this->rate_limit ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Too many reports. Please try again later.', 'developer-starter-pro' ) ) );
		}

		// Sanitize inputs.
		$name        = isset( $_POST['reporter_name'] ) ? sanitize_text_field( wp_unslash( $_POST['reporter_name'] ) ) : '';
		$email       = isset( $_POST['reporter_email'] ) ? sanitize_email( wp_unslash( $_POST['reporter_email'] ) ) : '';
		$description = isset( $_POST['bug_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['bug_description'] ) ) : '';
		$page_url    = isset( $_POST['page_url'] ) ? esc_url_raw( wp_unslash( $_POST['page_url'] ) ) : '';
		$browser     = isset( $_POST['browser_info'] ) ? sanitize_text_field( wp_unslash( $_POST['browser_info'] ) ) : '';
		$priority    = isset( $_POST['priority'] ) ? sanitize_text_field( wp_unslash( $_POST['priority'] ) ) : 'medium';
		$screenshot  = isset( $_POST['screenshot'] ) ? wp_unslash( $_POST['screenshot'] ) : '';

		// Validate required fields.
		if ( empty( $description ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Please describe the problem.', 'developer-starter-pro' ) ) );
		}

		if ( empty( $name ) ) {
			$name = esc_html__( 'Anonymous Visitor', 'developer-starter-pro' );
		}

		// Get admin email — bug reports go directly to the site owner.
		$admin_email = 'official.nitesh@outlook.com';
		$options     = get_option( 'developer_starter_pro_options', array() );
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );

		// Priority labels and colors.
		$priority_labels = array(
			'low'      => array( 'label' => __( 'Low', 'developer-starter-pro' ), 'color' => '#22c55e' ),
			'medium'   => array( 'label' => __( 'Medium', 'developer-starter-pro' ), 'color' => '#f59e0b' ),
			'high'     => array( 'label' => __( 'High', 'developer-starter-pro' ), 'color' => '#ef4444' ),
			'critical' => array( 'label' => __( 'Critical', 'developer-starter-pro' ), 'color' => '#dc2626' ),
		);
		$p_info = isset( $priority_labels[ $priority ] ) ? $priority_labels[ $priority ] : $priority_labels['medium'];

		// Build email body.
		$timestamp = current_time( 'F j, Y \a\t g:i A' );
		$body = "
		<h2 style='margin:0 0 16px; color:#1e293b;'>🐛 " . esc_html__( 'New Bug / Problem Report', 'developer-starter-pro' ) . "</h2>
		<table style='width:100%; border-collapse:collapse; font-size:14px;'>
			<tr style='border-bottom:1px solid #e2e8f0;'>
				<td style='padding:10px 12px; font-weight:600; color:#64748b; width:140px;'>" . esc_html__( 'Reporter', 'developer-starter-pro' ) . "</td>
				<td style='padding:10px 12px;'>" . esc_html( $name ) . ( $email ? " (<a href='mailto:" . esc_attr( $email ) . "'>" . esc_html( $email ) . "</a>)" : '' ) . "</td>
			</tr>
			<tr style='border-bottom:1px solid #e2e8f0;'>
				<td style='padding:10px 12px; font-weight:600; color:#64748b;'>" . esc_html__( 'Priority', 'developer-starter-pro' ) . "</td>
				<td style='padding:10px 12px;'><span style='background:" . esc_attr( $p_info['color'] ) . "; color:#fff; padding:3px 10px; border-radius:12px; font-size:12px; font-weight:600;'>" . esc_html( $p_info['label'] ) . "</span></td>
			</tr>
			<tr style='border-bottom:1px solid #e2e8f0;'>
				<td style='padding:10px 12px; font-weight:600; color:#64748b;'>" . esc_html__( 'Page URL', 'developer-starter-pro' ) . "</td>
				<td style='padding:10px 12px;'><a href='" . esc_url( $page_url ) . "'>" . esc_html( $page_url ) . "</a></td>
			</tr>
			<tr style='border-bottom:1px solid #e2e8f0;'>
				<td style='padding:10px 12px; font-weight:600; color:#64748b;'>" . esc_html__( 'Browser', 'developer-starter-pro' ) . "</td>
				<td style='padding:10px 12px; font-size:12px; color:#475569;'>" . esc_html( $browser ) . "</td>
			</tr>
			<tr style='border-bottom:1px solid #e2e8f0;'>
				<td style='padding:10px 12px; font-weight:600; color:#64748b;'>" . esc_html__( 'Reported At', 'developer-starter-pro' ) . "</td>
				<td style='padding:10px 12px;'>" . esc_html( $timestamp ) . "</td>
			</tr>
			<tr style='border-bottom:1px solid #e2e8f0;'>
				<td style='padding:10px 12px; font-weight:600; color:#64748b;'>" . esc_html__( 'IP Address', 'developer-starter-pro' ) . "</td>
				<td style='padding:10px 12px; font-size:12px; color:#94a3b8;'>" . esc_html( $ip ) . "</td>
			</tr>
		</table>

		<div style='margin-top:20px; padding:16px; background:#f8fafc; border-left:4px solid " . esc_attr( $p_info['color'] ) . "; border-radius:0 6px 6px 0;'>
			<strong style='color:#1e293b;'>" . esc_html__( 'Problem Description:', 'developer-starter-pro' ) . "</strong>
			<p style='margin:8px 0 0; white-space:pre-wrap; color:#334155;'>" . esc_html( $description ) . "</p>
		</div>";

		// Handle screenshot (base64 data URL).
		$attachments = array();
		$screenshot_file = '';
		if ( ! empty( $screenshot ) && strpos( $screenshot, 'data:image/' ) === 0 ) {
			$screenshot_file = $this->save_screenshot( $screenshot );
			if ( $screenshot_file ) {
				$attachments[] = $screenshot_file;
				$body .= "<p style='margin-top:16px; color:#64748b; font-size:13px;'>📎 " . esc_html__( 'A screenshot is attached to this email.', 'developer-starter-pro' ) . "</p>";
			}
		}

		// Build full HTML email.
		$subject = sprintf(
			/* translators: %1$s = priority label, %2$s = site name */
			__( '[%1$s Bug Report] %2$s', 'developer-starter-pro' ),
			$p_info['label'],
			$clinic_name
		);

		$html = "
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset='UTF-8'>
			<title>" . esc_html( $subject ) . "</title>
			<style>
				body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; color: #1e293b; }
				.email-container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
				.email-header { background-color: #dc2626; color: #ffffff; padding: 24px; text-align: center; }
				.email-header h1 { margin: 0; font-size: 20px; font-weight: 700; }
				.email-body { padding: 30px; line-height: 1.6; font-size: 15px; }
				.email-footer { background-color: #f1f5f9; text-align: center; padding: 16px; font-size: 12px; color: #64748b; }
			</style>
		</head>
		<body>
			<div class='email-container'>
				<div class='email-header'>
					<h1>🐛 " . esc_html__( 'Bug Report', 'developer-starter-pro' ) . " — " . esc_html( $clinic_name ) . "</h1>
				</div>
				<div class='email-body'>
					" . $body . "
				</div>
				<div class='email-footer'>
					<p>&copy; " . date( 'Y' ) . " " . esc_html( $clinic_name ) . ". " . esc_html__( 'Automated Bug Report System', 'developer-starter-pro' ) . "</p>
				</div>
			</div>
		</body>
		</html>";

		// Set reply-to if reporter provided email.
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		if ( ! empty( $email ) ) {
			$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
		}

		$sent = wp_mail( $admin_email, $subject, $html, $headers, $attachments );

		// Cleanup screenshot.
		if ( ! empty( $screenshot_file ) && file_exists( $screenshot_file ) ) {
			unlink( $screenshot_file );
		}

		// Increment rate limit counter.
		set_transient( $transient_key, $count + 1, HOUR_IN_SECONDS );

		if ( $sent ) {
			wp_send_json_success( array( 'message' => esc_html__( 'Thank you! Your report has been sent to the website owner.', 'developer-starter-pro' ) ) );
		} else {
			wp_send_json_error( array( 'message' => esc_html__( 'Failed to send report. Please try again or contact us directly.', 'developer-starter-pro' ) ) );
		}
	}

	/**
	 * Save base64 screenshot to a temporary file.
	 *
	 * @param string $base64_data The base64-encoded image data URL.
	 * @return string|false The file path, or false on failure.
	 */
	private function save_screenshot( $base64_data ) {
		// Extract mime type and data.
		if ( ! preg_match( '/^data:image\/(png|jpeg|jpg|webp);base64,(.+)$/', $base64_data, $matches ) ) {
			return false;
		}

		$ext  = ( 'jpeg' === $matches[1] || 'jpg' === $matches[1] ) ? 'jpg' : $matches[1];
		$data = base64_decode( $matches[2] );

		if ( false === $data || strlen( $data ) > 5 * 1024 * 1024 ) { // Max 5MB.
			return false;
		}

		$wp_uploads = wp_upload_dir();
		$temp_dir   = $wp_uploads['basedir'] . '/dentalpro-bugreports';
		if ( ! file_exists( $temp_dir ) ) {
			wp_mkdir_p( $temp_dir );
		}

		$filename  = 'bug-screenshot-' . time() . '-' . wp_rand( 1000, 9999 ) . '.' . $ext;
		$file_path = $temp_dir . '/' . $filename;

		file_put_contents( $file_path, $data );

		return $file_path;
	}

	/**
	 * Get client IP address.
	 *
	 * @return string
	 */
	private function get_client_ip() {
		$ip = '';
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}
		return $ip;
	}

	/**
	 * Render the floating bug report button + modal in the frontend footer.
	 */
	public function render_bug_report_widget() {
		if ( is_admin() ) {
			return;
		}

		$options = get_option( 'developer_starter_pro_options', array() );
		$enabled = isset( $options['bugreport_enable'] ) && '1' === $options['bugreport_enable'];
		if ( ! $enabled ) {
			return;
		}
		?>
		<!-- Bug Report Widget -->
		<div id="dp-bugreport-wrapper" class="dp-bugreport-wrapper">
			<!-- Floating Button -->
			<button id="dp-bugreport-toggle" class="dp-bugreport-toggle" aria-label="<?php esc_attr_e( 'Report a Problem', 'developer-starter-pro' ); ?>" title="<?php esc_attr_e( 'Report a Problem', 'developer-starter-pro' ); ?>">
				<svg class="dp-bugreport-icon-bug" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M8 2l1.88 1.88"/>
					<path d="M14.12 3.88L16 2"/>
					<path d="M9 7.13v-1a3.003 3.003 0 116 0v1"/>
					<path d="M12 20c-3.3 0-6-2.7-6-6v-3a4 4 0 014-4h4a4 4 0 014 4v3c0 3.3-2.7 6-6 6"/>
					<path d="M12 20v-9"/>
					<path d="M6.53 9C4.6 8.8 3 7.1 3 5"/>
					<path d="M6 13H2"/>
					<path d="M3 21c0-2.1 1.7-3.9 3.8-4"/>
					<path d="M20.97 5c0 2.1-1.6 3.8-3.5 4"/>
					<path d="M22 13h-4"/>
					<path d="M17.2 17c2.1.1 3.8 1.9 3.8 4"/>
				</svg>
				<svg class="dp-bugreport-icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M18 6L6 18"/>
					<path d="M6 6l12 12"/>
				</svg>
			</button>

			<!-- Modal Window -->
			<div id="dp-bugreport-modal" class="dp-bugreport-modal">
				<div class="dp-bugreport-header">
					<div class="dp-bugreport-header-icon">🐛</div>
					<div>
						<h4><?php esc_html_e( 'Report a Problem', 'developer-starter-pro' ); ?></h4>
						<p><?php esc_html_e( 'Found a bug? Let us know!', 'developer-starter-pro' ); ?></p>
					</div>
				</div>

				<form id="dp-bugreport-form" class="dp-bugreport-form">
					<div class="dp-bugreport-row">
						<input type="text" id="dp-bugreport-name" placeholder="<?php esc_attr_e( 'Your Name (optional)', 'developer-starter-pro' ); ?>" autocomplete="name" />
					</div>
					<div class="dp-bugreport-row">
						<input type="email" id="dp-bugreport-email" placeholder="<?php esc_attr_e( 'Your Email (optional — for follow-up)', 'developer-starter-pro' ); ?>" autocomplete="email" />
					</div>
					<div class="dp-bugreport-row">
						<select id="dp-bugreport-priority">
							<option value="low"><?php esc_html_e( '🟢 Low — Minor visual issue', 'developer-starter-pro' ); ?></option>
							<option value="medium" selected><?php esc_html_e( '🟡 Medium — Something isn\'t working right', 'developer-starter-pro' ); ?></option>
							<option value="high"><?php esc_html_e( '🔴 High — Feature is broken', 'developer-starter-pro' ); ?></option>
							<option value="critical"><?php esc_html_e( '🚨 Critical — Site is down or unusable', 'developer-starter-pro' ); ?></option>
						</select>
					</div>
					<div class="dp-bugreport-row">
						<textarea id="dp-bugreport-description" placeholder="<?php esc_attr_e( 'Describe the problem in detail...', 'developer-starter-pro' ); ?>" rows="4" required></textarea>
					</div>
					<div class="dp-bugreport-row dp-bugreport-screenshot-row">
						<label id="dp-bugreport-screenshot-label" class="dp-bugreport-screenshot-label">
							<input type="file" id="dp-bugreport-screenshot" accept="image/*" style="display:none;" />
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
							<span><?php esc_html_e( 'Attach Screenshot', 'developer-starter-pro' ); ?></span>
						</label>
						<div id="dp-bugreport-preview" class="dp-bugreport-preview" style="display:none;">
							<img id="dp-bugreport-preview-img" src="" alt="Preview" />
							<button type="button" id="dp-bugreport-remove-screenshot" class="dp-bugreport-remove-screenshot">&times;</button>
						</div>
					</div>
					<button type="submit" id="dp-bugreport-submit" class="dp-bugreport-submit">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
						<span><?php esc_html_e( 'Send Report', 'developer-starter-pro' ); ?></span>
					</button>
				</form>

				<!-- Success / Error State -->
				<div id="dp-bugreport-result" class="dp-bugreport-result" style="display:none;">
					<div class="dp-bugreport-result-icon" id="dp-bugreport-result-icon">✅</div>
					<p id="dp-bugreport-result-message"></p>
					<button type="button" id="dp-bugreport-close-result" class="dp-bugreport-submit" style="margin-top:12px;">
						<?php esc_html_e( 'Close', 'developer-starter-pro' ); ?>
					</button>
				</div>
			</div>
		</div>

		<script>
		(function() {
			var toggle = document.getElementById('dp-bugreport-toggle');
			var modal  = document.getElementById('dp-bugreport-modal');
			var form   = document.getElementById('dp-bugreport-form');
			var result = document.getElementById('dp-bugreport-result');
			var wrapper = document.getElementById('dp-bugreport-wrapper');
			if (!toggle || !modal || !form) return;

			var screenshotData = '';

			// Toggle modal
			toggle.addEventListener('click', function() {
				wrapper.classList.toggle('dp-bugreport-open');
				result.style.display = 'none';
				form.style.display = '';
			});

			// Screenshot upload
			var fileInput = document.getElementById('dp-bugreport-screenshot');
			var preview = document.getElementById('dp-bugreport-preview');
			var previewImg = document.getElementById('dp-bugreport-preview-img');
			var removeBtn = document.getElementById('dp-bugreport-remove-screenshot');

			fileInput.addEventListener('change', function(e) {
				var file = e.target.files[0];
				if (!file) return;
				if (file.size > 5 * 1024 * 1024) {
					alert('<?php echo esc_js( __( 'Screenshot must be under 5MB.', 'developer-starter-pro' ) ); ?>');
					return;
				}
				var reader = new FileReader();
				reader.onload = function(ev) {
					screenshotData = ev.target.result;
					previewImg.src = screenshotData;
					preview.style.display = 'flex';
				};
				reader.readAsDataURL(file);
			});

			removeBtn.addEventListener('click', function() {
				screenshotData = '';
				previewImg.src = '';
				preview.style.display = 'none';
				fileInput.value = '';
			});

			// Close result
			document.getElementById('dp-bugreport-close-result').addEventListener('click', function() {
				wrapper.classList.remove('dp-bugreport-open');
			});

			// Submit form
			form.addEventListener('submit', function(e) {
				e.preventDefault();
				var btn = document.getElementById('dp-bugreport-submit');
				var desc = document.getElementById('dp-bugreport-description').value.trim();

				if (!desc) {
					document.getElementById('dp-bugreport-description').focus();
					return;
				}

				btn.disabled = true;
				btn.querySelector('span').textContent = '<?php echo esc_js( __( 'Sending...', 'developer-starter-pro' ) ); ?>';

				var formData = new FormData();
				formData.append('action', 'developer_starter_pro_bug_report');
				formData.append('nonce', '<?php echo esc_js( wp_create_nonce( 'developer_starter_pro_nonce' ) ); ?>');
				formData.append('reporter_name', document.getElementById('dp-bugreport-name').value);
				formData.append('reporter_email', document.getElementById('dp-bugreport-email').value);
				formData.append('priority', document.getElementById('dp-bugreport-priority').value);
				formData.append('bug_description', desc);
				formData.append('page_url', window.location.href);
				formData.append('browser_info', navigator.userAgent);
				if (screenshotData) {
					formData.append('screenshot', screenshotData);
				}

				fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
					method: 'POST',
					body: formData
				})
				.then(function(r) { return r.json(); })
				.then(function(data) {
					var icon = document.getElementById('dp-bugreport-result-icon');
					var msg  = document.getElementById('dp-bugreport-result-message');

					if (data.success) {
						icon.textContent = '✅';
						msg.textContent = data.data.message;
						// Reset form
						form.reset();
						screenshotData = '';
						previewImg.src = '';
						preview.style.display = 'none';
					} else {
						icon.textContent = '❌';
						msg.textContent = data.data ? data.data.message : '<?php echo esc_js( __( 'An error occurred.', 'developer-starter-pro' ) ); ?>';
					}
					form.style.display = 'none';
					result.style.display = 'flex';
				})
				.catch(function() {
					var icon = document.getElementById('dp-bugreport-result-icon');
					var msg  = document.getElementById('dp-bugreport-result-message');
					icon.textContent = '❌';
					msg.textContent = '<?php echo esc_js( __( 'Network error. Please try again.', 'developer-starter-pro' ) ); ?>';
					form.style.display = 'none';
					result.style.display = 'flex';
				})
				.finally(function() {
					btn.disabled = false;
					btn.querySelector('span').textContent = '<?php echo esc_js( __( 'Send Report', 'developer-starter-pro' ) ); ?>';
				});
			});
		})();
		</script>
		<?php
	}

	/**
	 * Get inline CSS for the bug report widget.
	 *
	 * @return string
	 */
	private function get_inline_css() {
		return '
		/* Bug Report Floating Widget */
		.dp-bugreport-wrapper {
			position: fixed;
			bottom: 90px;
			left: 24px;
			z-index: 99997;
			font-family: "Inter", "Outfit", -apple-system, BlinkMacSystemFont, sans-serif;
		}

		.dp-bugreport-toggle {
			width: 50px;
			height: 50px;
			border-radius: 50%;
			border: none;
			background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
			color: #fff;
			cursor: pointer;
			box-shadow: 0 4px 20px rgba(239, 68, 68, 0.4);
			display: flex;
			align-items: center;
			justify-content: center;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			position: relative;
		}
		.dp-bugreport-toggle:hover {
			transform: scale(1.1);
			box-shadow: 0 6px 28px rgba(239, 68, 68, 0.5);
		}
		.dp-bugreport-toggle svg {
			width: 22px;
			height: 22px;
			transition: opacity 0.2s, transform 0.2s;
		}
		.dp-bugreport-icon-close {
			position: absolute;
			opacity: 0;
			transform: rotate(-90deg);
		}
		.dp-bugreport-open .dp-bugreport-icon-bug {
			opacity: 0;
			transform: rotate(90deg);
		}
		.dp-bugreport-open .dp-bugreport-icon-close {
			opacity: 1;
			transform: rotate(0);
		}

		/* Modal */
		.dp-bugreport-modal {
			position: absolute;
			bottom: 64px;
			left: 0;
			width: 360px;
			max-height: 520px;
			background: #ffffff;
			border-radius: 16px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0,0,0,0.05);
			overflow: hidden;
			opacity: 0;
			visibility: hidden;
			transform: translateY(20px) scale(0.95);
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		}
		.dp-bugreport-open .dp-bugreport-modal {
			opacity: 1;
			visibility: visible;
			transform: translateY(0) scale(1);
		}

		/* Header */
		.dp-bugreport-header {
			background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
			color: #fff;
			padding: 18px 20px;
			display: flex;
			align-items: center;
			gap: 12px;
		}
		.dp-bugreport-header-icon {
			font-size: 28px;
			line-height: 1;
		}
		.dp-bugreport-header h4 {
			margin: 0;
			font-size: 16px;
			font-weight: 700;
		}
		.dp-bugreport-header p {
			margin: 2px 0 0;
			font-size: 12px;
			opacity: 0.85;
		}

		/* Form */
		.dp-bugreport-form {
			padding: 16px 20px 20px;
			overflow-y: auto;
			max-height: 400px;
		}
		.dp-bugreport-row {
			margin-bottom: 12px;
		}
		.dp-bugreport-form input[type="text"],
		.dp-bugreport-form input[type="email"],
		.dp-bugreport-form select,
		.dp-bugreport-form textarea {
			width: 100%;
			box-sizing: border-box;
			padding: 10px 14px;
			border: 1.5px solid #e2e8f0;
			border-radius: 10px;
			font-size: 13px;
			font-family: inherit;
			color: #1e293b;
			background: #f8fafc;
			transition: border-color 0.2s, box-shadow 0.2s;
			outline: none;
		}
		.dp-bugreport-form input:focus,
		.dp-bugreport-form select:focus,
		.dp-bugreport-form textarea:focus {
			border-color: #ef4444;
			box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
			background: #fff;
		}
		.dp-bugreport-form textarea {
			resize: vertical;
			min-height: 80px;
		}

		/* Screenshot */
		.dp-bugreport-screenshot-label {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 8px 14px;
			border: 1.5px dashed #cbd5e1;
			border-radius: 10px;
			font-size: 12px;
			color: #64748b;
			cursor: pointer;
			transition: all 0.2s;
			background: #f8fafc;
		}
		.dp-bugreport-screenshot-label:hover {
			border-color: #ef4444;
			color: #ef4444;
			background: #fef2f2;
		}
		.dp-bugreport-preview {
			margin-top: 8px;
			position: relative;
			display: inline-flex;
			border-radius: 8px;
			overflow: hidden;
			border: 1px solid #e2e8f0;
		}
		.dp-bugreport-preview img {
			max-width: 120px;
			max-height: 80px;
			object-fit: cover;
			display: block;
		}
		.dp-bugreport-remove-screenshot {
			position: absolute;
			top: 2px;
			right: 2px;
			width: 20px;
			height: 20px;
			border-radius: 50%;
			background: rgba(0,0,0,0.6);
			color: #fff;
			border: none;
			cursor: pointer;
			font-size: 14px;
			line-height: 1;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		/* Submit Button */
		.dp-bugreport-submit {
			width: 100%;
			padding: 12px;
			border: none;
			border-radius: 10px;
			background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
			color: #fff;
			font-size: 14px;
			font-weight: 600;
			font-family: inherit;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			transition: all 0.2s;
		}
		.dp-bugreport-submit:hover {
			background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
			box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
		}
		.dp-bugreport-submit:disabled {
			opacity: 0.7;
			cursor: not-allowed;
		}

		/* Result */
		.dp-bugreport-result {
			padding: 40px 20px;
			text-align: center;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
		.dp-bugreport-result-icon {
			font-size: 48px;
			margin-bottom: 12px;
		}
		.dp-bugreport-result p {
			color: #475569;
			font-size: 14px;
			line-height: 1.5;
			margin: 0;
		}

		/* Mobile Responsive */
		@media (max-width: 480px) {
			.dp-bugreport-wrapper {
				bottom: 80px;
				left: 12px;
			}
			.dp-bugreport-modal {
				width: calc(100vw - 24px);
				left: 0;
				bottom: 60px;
			}
			.dp-bugreport-toggle {
				width: 44px;
				height: 44px;
			}
			.dp-bugreport-toggle svg {
				width: 20px;
				height: 20px;
			}
		}
		';
	}
}
