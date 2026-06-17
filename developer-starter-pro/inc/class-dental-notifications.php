<?php
/**
 * Email Notifications System & Automated Scheduler
 *
 * Registers customizable email templates and manages automatic patient confirmations,
 * administrator alerts, and daily WP-Cron reminders.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Notifications {

	/**
	 * Settings option name.
	 */
	private $option_name = 'developer_starter_pro_emails_settings';

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Admin Submenu
		add_action( 'admin_menu', array( $this, 'add_emails_submenu' ) );

		// Register hooks for triggers
		add_action( 'dentalpro_appointment_booked', array( $this, 'send_instant_notifications' ) );
		add_action( 'dentalpro_appointment_status_changed', array( $this, 'handle_status_change_notifications' ), 10, 3 );
		add_action( 'dentalpro_appointment_rescheduled', array( $this, 'handle_reschedule_notifications' ), 10, 1 );

		// Hook into WP-Cron event for reminders
		add_action( 'dentalpro_daily_reminder_cron', array( $this, 'send_daily_reminders' ) );
	}

	/**
	 * Add submenu under DentalPro Settings.
	 */
	public function add_emails_submenu() {
		add_submenu_page(
			'developer-starter-pro-settings',
			esc_html__( 'Email Templates', 'developer-starter-pro' ),
			esc_html__( 'Email Templates', 'developer-starter-pro' ),
			'manage_options',
			'developer-starter-pro-emails',
			array( $this, 'render_emails_admin' )
		);
	}

	/**
	 * Get Email settings.
	 */
	public function get_settings() {
		$defaults = array(
			// Patient Confirmation
			'patient_conf_enabled' => '1',
			'patient_conf_subject' => esc_html__( 'Appointment Scheduled: {service_name}', 'developer-starter-pro' ),
			'patient_conf_body'    => "<h2>Hello {patient_name},</h2>\n<p>Your appointment has been successfully scheduled with <strong>{doctor_name}</strong>.</p>\n<p><strong>Treatment:</strong> {service_name}<br>\n<strong>Date:</strong> {appointment_date}<br>\n<strong>Time:</strong> {appointment_time}</p>\n<p>Thank you for choosing our clinic!</p>",
			
			// Admin Alert
			'admin_alert_enabled' => '1',
			'admin_alert_subject' => esc_html__( '[New Booking] {patient_name} - {service_name}', 'developer-starter-pro' ),
			'admin_alert_body'    => "<h2>New Appointment Scheduled</h2>\n<p>A new appointment has been booked online:</p>\n<p><strong>Patient Name:</strong> {patient_name}<br>\n<strong>Email:</strong> {patient_email}<br>\n<strong>Phone:</strong> {patient_phone}<br>\n<strong>Doctor:</strong> {doctor_name}<br>\n<strong>Service:</strong> {service_name}<br>\n<strong>Date:</strong> {appointment_date}<br>\n<strong>Time:</strong> {appointment_time}<br>\n<strong>Notes:</strong> {patient_notes}</p>",

			// Patient 24h Reminder
			'patient_rem_enabled' => '1',
			'patient_rem_subject' => esc_html__( 'Reminder: Appointment tomorrow with {doctor_name}', 'developer-starter-pro' ),
			'patient_rem_body'    => "<h2>Hello {patient_name},</h2>\n<p>This is a reminder that you have an upcoming appointment scheduled tomorrow with <strong>{doctor_name}</strong>.</p>\n<p><strong>Treatment:</strong> {service_name}<br>\n<strong>Time:</strong> {appointment_time}</p>\n<p>We look forward to seeing you!</p>",
		);
		$saved = get_option( $this->option_name, array() );
		return wp_parse_args( $saved, $defaults );
	}

	/**
	 * Render Email Templates Admin Page.
	 */
	public function render_emails_admin() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Save handler
		if ( isset( $_POST['action'] ) && $_POST['action'] === 'save_emails_settings' ) {
			check_admin_referer( 'developer_starter_pro_emails_nonce' );

			$settings = array(
				'patient_conf_enabled' => isset( $_POST['patient_conf_enabled'] ) ? '1' : '0',
				'patient_conf_subject' => sanitize_text_field( $_POST['patient_conf_subject'] ),
				'patient_conf_body'    => wp_kses_post( wp_unslash( $_POST['patient_conf_body'] ) ),

				'admin_alert_enabled'  => isset( $_POST['admin_alert_enabled'] ) ? '1' : '0',
				'admin_alert_subject'  => sanitize_text_field( $_POST['admin_alert_subject'] ),
				'admin_alert_body'     => wp_kses_post( wp_unslash( $_POST['admin_alert_body'] ) ),

				'patient_rem_enabled'  => isset( $_POST['patient_rem_enabled'] ) ? '1' : '0',
				'patient_rem_subject'  => sanitize_text_field( $_POST['patient_rem_subject'] ),
				'patient_rem_body'     => wp_kses_post( wp_unslash( $_POST['patient_rem_body'] ) ),
			);

			update_option( $this->option_name, $settings );

			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Email Notification templates saved successfully.', 'developer-starter-pro' ) . '</p></div>';
		}

		$settings = $this->get_settings();
		?>
		<div class="wrap developer-starter-pro-admin-wrap">
			<div class="developer-starter-pro-admin-header">
				<div class="developer-starter-pro-admin-header-inner">
					<h1>
						<span class="developer-starter-pro-logo-icon">✉️</span>
						<?php esc_html_e( 'Email Notification Editor', 'developer-starter-pro' ); ?>
					</h1>
				</div>
			</div>

			<div style="background:#fff; border:1px solid #cbd5e1; padding:16px; border-radius:6px; margin-top:20px;">
				<p><strong><?php esc_html_e( 'Supported Merge Tags:', 'developer-starter-pro' ); ?></strong></p>
				<code>{patient_name}</code>, <code>{patient_email}</code>, <code>{patient_phone}</code>, <code>{patient_notes}</code>, <code>{doctor_name}</code>, <code>{service_name}</code>, <code>{appointment_date}</code>, <code>{appointment_time}</code>, <code>{clinic_name}</code>, <code>{google_calendar_link}</code>
			</div>

			<form method="post" action="" style="margin-top:24px;">
				<?php wp_nonce_field( 'developer_starter_pro_emails_nonce' ); ?>
				<input type="hidden" name="action" value="save_emails_settings">

				<!-- 1. Patient Confirmation Template -->
				<div class="developer-starter-pro-settings-section" style="background:#fff; padding:24px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:24px;">
					<h2><?php esc_html_e( 'Patient Booking Confirmation Email', 'developer-starter-pro' ); ?></h2>
					<table class="form-table">
						<tr>
							<th><label><?php esc_html_e( 'Enable Notification', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="checkbox" name="patient_conf_enabled" value="1" <?php checked( $settings['patient_conf_enabled'], '1' ); ?>>
							</td>
						</tr>
						<tr>
							<th><label for="patient_conf_subject"><?php esc_html_e( 'Subject', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="text" id="patient_conf_subject" name="patient_conf_subject" value="<?php echo esc_attr( $settings['patient_conf_subject'] ); ?>" class="large-text" required>
							</td>
						</tr>
						<tr>
							<th><label for="patient_conf_body"><?php esc_html_e( 'Email Body (HTML allowed)', 'developer-starter-pro' ); ?></label></th>
							<td>
								<?php wp_editor( $settings['patient_conf_body'], 'patient_conf_body', array( 'textarea_name' => 'patient_conf_body', 'rows' => 6 ) ); ?>
							</td>
						</tr>
					</table>
				</div>

				<!-- 2. Admin Alert Template -->
				<div class="developer-starter-pro-settings-section" style="background:#fff; padding:24px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:24px;">
					<h2><?php esc_html_e( 'Administrator New Booking Alert', 'developer-starter-pro' ); ?></h2>
					<table class="form-table">
						<tr>
							<th><label><?php esc_html_e( 'Enable Notification', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="checkbox" name="admin_alert_enabled" value="1" <?php checked( $settings['admin_alert_enabled'], '1' ); ?>>
							</td>
						</tr>
						<tr>
							<th><label for="admin_alert_subject"><?php esc_html_e( 'Subject', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="text" id="admin_alert_subject" name="admin_alert_subject" value="<?php echo esc_attr( $settings['admin_alert_subject'] ); ?>" class="large-text" required>
							</td>
						</tr>
						<tr>
							<th><label for="admin_alert_body"><?php esc_html_e( 'Email Body (HTML allowed)', 'developer-starter-pro' ); ?></label></th>
							<td>
								<?php wp_editor( $settings['admin_alert_body'], 'admin_alert_body', array( 'textarea_name' => 'admin_alert_body', 'rows' => 6 ) ); ?>
							</td>
						</tr>
					</table>
				</div>

				<!-- 3. Patient 24h Reminder Template -->
				<div class="developer-starter-pro-settings-section" style="background:#fff; padding:24px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:24px;">
					<h2><?php esc_html_e( 'Patient 24-Hour Reminder Email', 'developer-starter-pro' ); ?></h2>
					<table class="form-table">
						<tr>
							<th><label><?php esc_html_e( 'Enable Notification', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="checkbox" name="patient_rem_enabled" value="1" <?php checked( $settings['patient_rem_enabled'], '1' ); ?>>
							</td>
						</tr>
						<tr>
							<th><label for="patient_rem_subject"><?php esc_html_e( 'Subject', 'developer-starter-pro' ); ?></label></th>
							<td>
								<input type="text" id="patient_rem_subject" name="patient_rem_subject" value="<?php echo esc_attr( $settings['patient_rem_subject'] ); ?>" class="large-text" required>
							</td>
						</tr>
						<tr>
							<th><label for="patient_rem_body"><?php esc_html_e( 'Email Body (HTML allowed)', 'developer-starter-pro' ); ?></label></th>
							<td>
								<?php wp_editor( $settings['patient_rem_body'], 'patient_rem_body', array( 'textarea_name' => 'patient_rem_body', 'rows' => 6 ) ); ?>
							</td>
						</tr>
					</table>
				</div>

				<div style="margin-top:24px;">
					<?php submit_button( esc_html__( 'Save Email Templates', 'developer-starter-pro' ), 'primary', 'submit', true ); ?>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Send Instant Confirmation & Admin alert emails.
	 *
	 * @param int $booking_id Database booking record ID.
	 */
	public function send_instant_notifications( $booking_id ) {
		$options = developer_starter_pro_get_all_options();
		$mode = isset( $options['appointment_approval_mode'] ) ? $options['appointment_approval_mode'] : 'automatic';

		if ( 'automatic' === $mode ) {
			// In Automatic Mode, patient is confirmed instantly
			$this->send_email_by_id( $booking_id, 'patient_conf' );
			$this->send_email_by_id( $booking_id, 'admin_alert' );
			$this->send_sms_whatsapp( $booking_id );
		} else {
			// In Manual Mode, only notify admin (remains pending until approved)
			$this->send_email_by_id( $booking_id, 'admin_alert' );
		}
	}

	/**
	 * WP-Cron callback daily.
	 * Queries and sends reminder emails for slots scheduled tomorrow.
	 */
	public function send_daily_reminders() {
		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();
		
		if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) ) !== $table_name ) {
			return;
		}

		$tomorrow = date( 'Y-m-d', strtotime( '+1 day' ) );

		// Query active approved bookings for tomorrow
		$appointments = $wpdb->get_results( $wpdb->prepare(
			"SELECT id FROM $table_name WHERE booking_date = %s AND status != 'cancelled'",
			$tomorrow
		) );

		if ( empty( $appointments ) ) {
			return;
		}

		foreach ( $appointments as $apt ) {
			$this->send_email_by_id( $apt->id, 'patient_rem' );
		}
	}

	/**
	 * Core Email Dispatcher helper.
	 *
	 * Parses template, replaces merge tags, sets Headers, and sends wp_mail.
	 *
	 * @param int    $booking_id Database ID.
	 * @param string $type       Template type (patient_conf / admin_alert / patient_rem).
	 * @return bool Send status.
	 */
	public function send_email_by_id( $booking_id, $type ) {
		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $booking_id ) );
		if ( ! $booking ) {
			return false;
		}

		$settings = $this->get_settings();
		$enabled_key = $type . '_enabled';
		if ( ! isset( $settings[ $enabled_key ] ) || $settings[ $enabled_key ] !== '1' ) {
			return false;
		}

		// Fetch merge values
		$patient_name = $booking->patient_name;
		$patient_email = $booking->patient_email;
		$patient_phone = $booking->patient_phone;
		$patient_notes = ! empty( $booking->notes ) ? $booking->notes : __( 'None', 'developer-starter-pro' );
		$doctor_name = get_the_title( $booking->doctor_id );
		$service_name = get_the_title( $booking->service_id );
		$appointment_date = date_i18n( get_option( 'date_format' ), strtotime( $booking->booking_date ) );
		$appointment_time = date( 'g:i A', strtotime( $booking->time_slot ) );

		// Pull global option clinic name
		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );
		$admin_email = ! empty( $options['clinic_email'] ) ? $options['clinic_email'] : get_bloginfo( 'admin_email' );

		// Dynamic Google Calendar URL
		$google_calendar_url = $this->generate_google_calendar_url( $booking );

		// Subject and Body keys
		$subject = $settings[ $type . '_subject' ];
		$body    = $settings[ $type . '_body' ];

		// Replaces tags array
		$replacements = array(
			'{patient_name}'        => $patient_name,
			'{patient_email}'       => $patient_email,
			'{patient_phone}'       => $patient_phone,
			'{patient_notes}'       => $patient_notes,
			'{doctor_name}'         => $doctor_name,
			'{service_name}'        => $service_name,
			'{appointment_date}'    => $appointment_date,
			'{appointment_time}'    => $appointment_time,
			'{clinic_name}'         => $clinic_name,
			'{google_calendar_link}' => esc_url( $google_calendar_url ),
		);

		$subject = str_replace( array_keys( $replacements ), array_values( $replacements ), $subject );
		$body    = str_replace( array_keys( $replacements ), array_values( $replacements ), $body );

		// Wrap in simple responsive HTML design container
		$html_body = "
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset='UTF-8'>
			<title>" . esc_html( $subject ) . "</title>
			<style>
				body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; color: #1e293b; }
				.email-container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
				.email-header { background-color: #0d9488; color: #ffffff; padding: 24px; text-align: center; }
				.email-header h1 { margin: 0; font-size: 20px; font-weight: 700; }
				.email-body { padding: 30px; line-height: 1.6; font-size: 15px; }
				.email-footer { background-color: #f1f5f9; text-align: center; padding: 16px; font-size: 12px; color: #64748b; }
			</style>
		</head>
		<body>
			<div class='email-container'>
				<div class='email-header'>
					<h1>" . esc_html( $clinic_name ) . "</h1>
				</div>
				<div class='email-body'>
					" . $body . "
				</div>
				<div class='email-footer'>
					<p>&copy; " . date( 'Y' ) . " " . esc_html( $clinic_name ) . ". " . __( 'All rights reserved.', 'developer-starter-pro' ) . "</p>
				</div>
			</div>
		</body>
		</html>";

		// Setup Headers
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );

		// Set recipient
		$to = ( 'admin_alert' === $type ) ? $admin_email : $patient_email;

		// Handle ICS attachment if patient notification
		$attachments = array();
		$ics_file = '';
		if ( in_array( $type, array( 'patient_conf', 'patient_rem' ), true ) ) {
			$ics_file = $this->generate_ics_attachment( $booking );
			if ( $ics_file && file_exists( $ics_file ) ) {
				$attachments[] = $ics_file;
			}
		}

		$result = wp_mail( $to, $subject, $html_body, $headers, $attachments );

		// Cleanup temporary ICS file
		if ( ! empty( $ics_file ) && file_exists( $ics_file ) ) {
			unlink( $ics_file );
		}

		return $result;
	}

	/**
	 * Send SMS/WhatsApp notification to patient.
	 *
	 * @param int $booking_id Database ID.
	 */
	public function send_sms_whatsapp( $booking_id ) {
		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();
		$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $booking_id ) );
		if ( ! $booking ) {
			return;
		}

		$patient_phone = $booking->patient_phone;
		$patient_name  = $booking->patient_name;
		$doctor_name   = get_the_title( $booking->doctor_id );
		$service_name  = get_the_title( $booking->service_id );
		$appointment_date = date_i18n( get_option( 'date_format' ), strtotime( $booking->booking_date ) );
		$appointment_time = date( 'g:i A', strtotime( $booking->time_slot ) );
		$reference_id  = 'APT-' . sprintf( '%05d', $booking_id );

		$message = sprintf(
			__( "Hello %s, your appointment (Ref: %s) for %s with %s on %s at %s has been confirmed. Thank you!", 'developer-starter-pro' ),
			$patient_name,
			$reference_id,
			$service_name,
			$doctor_name,
			$appointment_date,
			$appointment_time
		);

		$this->dispatch_sms( $patient_phone, $message );
	}

	/**
	 * Core SMS Dispatcher helper using Twilio API or Custom HTTP Gateway.
	 */
	public function dispatch_sms( $phone, $message ) {
		$options = developer_starter_pro_get_all_options();
		$sms_enabled = isset( $options['twilio_sms_enabled'] ) ? $options['twilio_sms_enabled'] : '0';

		if ( '1' === $sms_enabled ) {
			$provider = isset( $options['sms_provider'] ) ? $options['sms_provider'] : 'twilio';

			if ( 'twilio' === $provider ) {
				$sid   = $options['twilio_sid'] ?? '';
				$token = $options['twilio_auth_token'] ?? '';
				$from  = $options['twilio_from_number'] ?? '';

				if ( ! empty( $sid ) && ! empty( $token ) && ! empty( $from ) ) {
					$url = 'https://api.twilio.com/2010-04-01/Accounts/' . $sid . '/Messages.json';
					
					$response = wp_remote_post( $url, array(
						'headers' => array(
							'Authorization' => 'Basic ' . base64_encode( $sid . ':' . $token ),
							'Content-Type'  => 'application/x-www-form-urlencoded',
						),
						'body' => array(
							'From' => $from,
							'To'   => $phone,
							'Body' => $message,
						),
					) );

					if ( is_wp_error( $response ) ) {
						error_log( 'Twilio SMS failed to dispatch: ' . $response->get_error_message() );
					} else {
						$code = wp_remote_retrieve_response_code( $response );
						$body = wp_remote_retrieve_body( $response );
						if ( $code < 200 || $code >= 300 ) {
							error_log( "Twilio SMS API Error (HTTP $code): " . $body );
						} else {
							error_log( "Twilio SMS successfully sent to $phone." );
						}
					}
				} else {
					error_log( 'Twilio SMS enabled but settings are incomplete.' );
				}
			} elseif ( 'custom' === $provider ) {
				$api_url     = $options['sms_custom_url'] ?? '';
				$method      = $options['sms_custom_method'] ?? 'GET';
				$headers_raw = $options['sms_custom_headers'] ?? '';
				$body_raw    = $options['sms_custom_body'] ?? '';

				if ( ! empty( $api_url ) ) {
					$headers = array();
					if ( ! empty( $headers_raw ) ) {
						$lines = explode( "\n", str_replace( "\r", "", $headers_raw ) );
						foreach ( $lines as $line ) {
							$line = trim( $line );
							if ( empty( $line ) ) {
								continue;
							}
							$parts = explode( ':', $line, 2 );
							if ( count( $parts ) === 2 ) {
								$headers[ trim( $parts[0] ) ] = trim( $parts[1] );
							}
						}
					}

					$phone_no_plus = ltrim( $phone, '+' );

					$replacements = array(
						'{phone}'         => $phone,
						'{phone_no_plus}' => $phone_no_plus,
						'{message}'       => $message,
					);

					// Replace placeholders in URL, Headers, and Body
					$api_url  = str_replace( array_keys( $replacements ), array_values( $replacements ), $api_url );
					$body_raw = str_replace( array_keys( $replacements ), array_values( $replacements ), $body_raw );
					foreach ( $headers as $k => $v ) {
						$headers[ $k ] = str_replace( array_keys( $replacements ), array_values( $replacements ), $v );
					}

					if ( 'GET' === $method ) {
						if ( ! empty( $body_raw ) ) {
							parse_str( $body_raw, $params );
							$api_url = add_query_arg( $params, $api_url );
						}
						$response = wp_remote_get( $api_url, array(
							'headers' => $headers,
							'timeout' => 15,
						) );
					} else {
						// POST methods
						$post_args = array(
							'headers' => $headers,
							'timeout' => 15,
						);

						if ( 'POST_JSON' === $method ) {
							$headers['Content-Type'] = 'application/json';
							$post_args['headers']    = $headers;
							
							$json_decoded = json_decode( $body_raw, true );
							if ( json_last_error() === JSON_ERROR_NONE ) {
								$post_args['body'] = $body_raw;
							} else {
								parse_str( $body_raw, $parsed_body );
								$post_args['body'] = wp_json_encode( $parsed_body );
							}
						} else {
							// POST Form-Data
							if ( ! isset( $headers['Content-Type'] ) ) {
								$headers['Content-Type'] = 'application/x-www-form-urlencoded';
								$post_args['headers']    = $headers;
							}
							parse_str( $body_raw, $parsed_body );
							$post_args['body'] = $parsed_body;
						}

						$response = wp_remote_post( $api_url, $post_args );
					}

					if ( is_wp_error( $response ) ) {
						error_log( 'Custom SMS failed to dispatch: ' . $response->get_error_message() );
					} else {
						$code = wp_remote_retrieve_response_code( $response );
						$body = wp_remote_retrieve_body( $response );
						if ( $code < 200 || $code >= 300 ) {
							error_log( "Custom SMS API Error (HTTP $code): " . $body );
						} else {
							error_log( "Custom SMS successfully sent to $phone via HTTP Gateway." );
						}
					}
				} else {
					error_log( 'Custom SMS Gateway enabled but API URL is empty.' );
				}
			}
		} else {
			// Mock mode logging
			error_log( "SMS/WhatsApp notification dispatched (Mock Mode) to $phone: $message" );
		}
	}

	/**
	 * Generate iCalendar .ics file and return the temporary file path.
	 */
	private function generate_ics_attachment( $booking ) {
		$doctor_name = get_the_title( $booking->doctor_id );
		$service_name = get_the_title( $booking->service_id );
		
		// Parse date/time
		$start_timestamp = strtotime( $booking->booking_date . ' ' . $booking->time_slot );
		
		// Get duration
		$duration_minutes = 30; // Default
		$duration = get_post_meta( $booking->service_id, '_developer_starter_pro_service_duration', true );
		if ( ! empty( $duration ) ) {
			$duration_num = preg_replace( '/\s*(mins?|minutes?)\s*/i', '', $duration );
			if ( ctype_digit( $duration_num ) ) {
				$duration_minutes = intval( $duration_num );
			}
		}

		$start_utc = $start_timestamp - ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
		$end_utc = $start_utc + ( $duration_minutes * MINUTE_IN_SECONDS );

		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );

		// Retrieve Branch location if set
		$location_name = '';
		if ( ! empty( $booking->location_id ) ) {
			$location_name = get_the_title( $booking->location_id );
			$loc_address = get_post_meta( $booking->location_id, '_developer_starter_pro_location_address', true );
			if ( ! empty( $loc_address ) ) {
				$location_name .= ' (' . $loc_address . ')';
			}
		}
		if ( empty( $location_name ) ) {
			$location_name = ! empty( $options['clinic_address'] ) ? $options['clinic_address'] : 'Online / Clinic';
		}

		$uid = 'apt-' . $booking->id . '-' . md5( $booking->created_at ) . '@' . parse_url( home_url(), PHP_URL_HOST );

		$ics_content = "BEGIN:VCALENDAR\r\n";
		$ics_content .= "VERSION:2.0\r\n";
		$ics_content .= "PRODID:-//Dental Pro//NONSGML Appointment Booking//EN\r\n";
		$ics_content .= "CALSCALE:GREGORIAN\r\n";
		$ics_content .= "METHOD:PUBLISH\r\n";
		$ics_content .= "BEGIN:VEVENT\r\n";
		$ics_content .= "UID:" . $uid . "\r\n";
		$ics_content .= "DTSTAMP:" . gmdate( 'Ymd\THis\Z' ) . "\r\n";
		$ics_content .= "DTSTART:" . gmdate( 'Ymd\THis\Z', $start_utc ) . "\r\n";
		$ics_content .= "DTEND:" . gmdate( 'Ymd\THis\Z', $end_utc ) . "\r\n";
		$ics_content .= "SUMMARY:" . sprintf( __( 'Dental Appointment: %1$s with %2$s', 'developer-starter-pro' ), $service_name, $doctor_name ) . "\r\n";
		$ics_content .= "DESCRIPTION:" . sprintf( __( 'Patient: %1$s\nDoctor: %2$s\nTreatment: %3$s\nClinic: %4$s', 'developer-starter-pro' ), $booking->patient_name, $doctor_name, $service_name, $clinic_name ) . "\r\n";
		$ics_content .= "LOCATION:" . str_replace( array( "\r", "\n" ), '', $location_name ) . "\r\n";
		$ics_content .= "END:VEVENT\r\n";
		$ics_content .= "END:VCALENDAR\r\n";

		// Write to temporary file in uploads directory
		$wp_uploads = wp_upload_dir();
		$temp_dir = $wp_uploads['basedir'] . '/dentalpro-ics';
		if ( ! file_exists( $temp_dir ) ) {
			wp_mkdir_p( $temp_dir );
		}
		
		$file_path = $temp_dir . '/appointment-' . $booking->id . '.ics';
		file_put_contents( $file_path, $ics_content );

		return $file_path;
	}

	/**
	 * Generate a Google Calendar Add Event URL link.
	 */
	private function generate_google_calendar_url( $booking ) {
		$doctor_name = get_the_title( $booking->doctor_id );
		$service_name = get_the_title( $booking->service_id );

		$start_timestamp = strtotime( $booking->booking_date . ' ' . $booking->time_slot );
		
		$duration_minutes = 30;
		$duration = get_post_meta( $booking->service_id, '_developer_starter_pro_service_duration', true );
		if ( ! empty( $duration ) ) {
			$duration_num = preg_replace( '/\s*(mins?|minutes?)\s*/i', '', $duration );
			if ( ctype_digit( $duration_num ) ) {
				$duration_minutes = intval( $duration_num );
			}
		}

		$start_utc = $start_timestamp - ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
		$end_utc = $start_utc + ( $duration_minutes * MINUTE_IN_SECONDS );

		$dates = gmdate( 'Ymd\THis\Z', $start_utc ) . '/' . gmdate( 'Ymd\THis\Z', $end_utc );
		
		$title = sprintf( __( 'Dental Appointment: %1$s with %2$s', 'developer-starter-pro' ), $service_name, $doctor_name );
		
		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );
		
		$details = sprintf( __( 'Patient: %1$s\nDoctor: %2$s\nTreatment: %3$s\nClinic: %4$s', 'developer-starter-pro' ), $booking->patient_name, $doctor_name, $service_name, $clinic_name );

		$location_name = '';
		if ( ! empty( $booking->location_id ) ) {
			$location_name = get_the_title( $booking->location_id );
			$loc_address = get_post_meta( $booking->location_id, '_developer_starter_pro_location_address', true );
			if ( ! empty( $loc_address ) ) {
				$location_name .= ' (' . $loc_address . ')';
			}
		}
		if ( empty( $location_name ) ) {
			$location_name = ! empty( $options['clinic_address'] ) ? $options['clinic_address'] : 'Online / Clinic';
		}

		return add_query_arg(
			array(
				'action'   => 'TEMPLATE',
				'text'     => rawurlencode( $title ),
				'dates'    => $dates,
				'details'  => rawurlencode( $details ),
				'location' => rawurlencode( $location_name ),
			),
			'https://calendar.google.com/calendar/render'
		);
	}

	/**
	 * Send Cancellation Notification emails to patient and admin.
	 *
	 * @param int $booking_id Database ID.
	 */
	public function send_cancellation_emails( $booking_id ) {
		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();
		$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $booking_id ) );
		if ( ! $booking ) {
			return;
		}

		$patient_name = $booking->patient_name;
		$patient_email = $booking->patient_email;
		$doctor_name = get_the_title( $booking->doctor_id );
		$service_name = get_the_title( $booking->service_id );
		$appointment_date = date_i18n( get_option( 'date_format' ), strtotime( $booking->booking_date ) );
		$appointment_time = date( 'g:i A', strtotime( $booking->time_slot ) );
		$reference_id  = 'APT-' . sprintf( '%05d', $booking_id );

		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );
		$admin_email = ! empty( $options['clinic_email'] ) ? $options['clinic_email'] : get_bloginfo( 'admin_email' );

		// Subject and Body for Patient
		$patient_subject = sprintf( __( 'Appointment Cancelled: %s', 'developer-starter-pro' ), $service_name );
		$patient_body = "<h2>Hello {$patient_name},</h2>\n<p>Your appointment has been <strong>cancelled</strong>.</p>\n<p><strong>Reference ID:</strong> {$reference_id}<br>\n<strong>Treatment:</strong> {$service_name}<br>\n<strong>Doctor:</strong> {$doctor_name}<br>\n<strong>Date:</strong> {$appointment_date}<br>\n<strong>Time:</strong> {$appointment_time}</p>";

		// Subject and Body for Admin
		$admin_subject = sprintf( __( '[Cancelled] %s - %s', 'developer-starter-pro' ), $patient_name, $service_name );
		$admin_body = "<h2>Appointment Cancelled</h2>\n<p>An appointment has been cancelled by the patient:</p>\n<p><strong>Reference ID:</strong> {$reference_id}<br>\n<strong>Patient Name:</strong> {$patient_name}<br>\n<strong>Email:</strong> {$patient_email}<br>\n<strong>Phone:</strong> {$booking->patient_phone}<br>\n<strong>Doctor:</strong> {$doctor_name}<br>\n<strong>Service:</strong> {$service_name}<br>\n<strong>Date:</strong> {$appointment_date}<br>\n<strong>Time:</strong> {$appointment_time}</p>";

		// Send formatted HTML emails
		$this->send_formatted_email( $patient_email, $patient_subject, $patient_body, $clinic_name, '#ef4444' );
		$this->send_formatted_email( $admin_email, $admin_subject, $admin_body, $clinic_name, '#ef4444' );
	}

	/**
	 * Send generic formatted HTML email.
	 */
	private function send_formatted_email( $to, $subject, $body, $clinic_name, $header_color = '#0d9488' ) {
		$html_body = "
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset='UTF-8'>
			<title>" . esc_html( $subject ) . "</title>
			<style>
				body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; color: #1e293b; }
				.email-container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
				.email-header { background-color: " . esc_attr( $header_color ) . "; color: #ffffff; padding: 24px; text-align: center; }
				.email-header h1 { margin: 0; font-size: 20px; font-weight: 700; }
				.email-body { padding: 30px; line-height: 1.6; font-size: 15px; }
				.email-footer { background-color: #f1f5f9; text-align: center; padding: 16px; font-size: 12px; color: #64748b; }
			</style>
		</head>
		<body>
			<div class='email-container'>
				<div class='email-header'>
					<h1>" . esc_html( $clinic_name ) . "</h1>
				</div>
				<div class='email-body'>
					" . $body . "
				</div>
				<div class='email-footer'>
					<p>&copy; " . date( 'Y' ) . " " . esc_html( $clinic_name ) . ". " . __( 'All rights reserved.', 'developer-starter-pro' ) . "</p>
				</div>
			</div>
		</body>
		</html>";

		return wp_mail( $to, $subject, $html_body, array( 'Content-Type: text/html; charset=UTF-8' ) );
	}

	/**
	 * Handle notifications on status change.
	 *
	 * @param int    $booking_id Database ID.
	 * @param string $old_status Old status value.
	 * @param string $new_status New status value.
	 */
	public function handle_status_change_notifications( $booking_id, $old_status, $new_status ) {
		if ( $old_status === $new_status ) {
			return;
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();
		$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $booking_id ) );
		if ( ! $booking ) {
			return;
		}

		$options = developer_starter_pro_get_all_options();
		$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );
		$admin_email = ! empty( $options['clinic_email'] ) ? $options['clinic_email'] : get_bloginfo( 'admin_email' );

		$patient_name = $booking->patient_name;
		$patient_email = $booking->patient_email;
		$doctor_name = get_the_title( $booking->doctor_id );
		$service_name = get_the_title( $booking->service_id );
		$appointment_date = date_i18n( get_option( 'date_format' ), strtotime( $booking->booking_date ) );
		$appointment_time = date( 'g:i A', strtotime( $booking->time_slot ) );
		$reference_id  = 'APT-' . sprintf( '%05d', $booking_id );

		switch ( $new_status ) {
			case 'confirmed':
			case 'approved':
				// Send confirmation email & SMS
				$this->send_email_by_id( $booking_id, 'patient_conf' );
				$this->send_sms_whatsapp( $booking_id );
				break;

			case 'cancelled':
				// Send cancellation notifications
				$subject = sprintf( __( 'Appointment Cancelled: %s', 'developer-starter-pro' ), $service_name );
				$body = "<h2>Hello {$patient_name},</h2>\n<p>Your appointment has been <strong>cancelled</strong>.</p>\n<p><strong>Reference ID:</strong> {$reference_id}<br>\n<strong>Treatment:</strong> {$service_name}<br>\n<strong>Doctor:</strong> {$doctor_name}<br>\n<strong>Date:</strong> {$appointment_date}<br>\n<strong>Time:</strong> {$appointment_time}</p>";
				$this->send_formatted_email( $patient_email, $subject, $body, $clinic_name, '#ef4444' );

				$sms_msg = sprintf(
					__( "Hello %s, your appointment %s on %s has been cancelled.", 'developer-starter-pro' ),
					$patient_name,
					$reference_id,
					$appointment_date
				);
				$this->dispatch_sms( $booking->patient_phone, $sms_msg );
				break;

			case 'rejected':
				$subject = sprintf( __( 'Appointment Declined: %s', 'developer-starter-pro' ), $service_name );
				$body = "<h2>Hello {$patient_name},</h2>\n<p>We regret to inform you that we are unable to accept your appointment request at this time.</p>\n<p><strong>Reference ID:</strong> {$reference_id}<br>\n<strong>Treatment:</strong> {$service_name}<br>\n<strong>Doctor:</strong> {$doctor_name}<br>\n<strong>Requested Date:</strong> {$appointment_date}<br>\n<strong>Requested Time:</strong> {$appointment_time}</p>\n<p>Please feel free to book another time or contact our clinic for assistance.</p>";
				$this->send_formatted_email( $patient_email, $subject, $body, $clinic_name, '#64748b' );

				$sms_msg = sprintf(
					__( "Hello %s, your appointment request %s has been declined. Please call us to reschedule.", 'developer-starter-pro' ),
					$patient_name,
					$reference_id
				);
				$this->dispatch_sms( $booking->patient_phone, $sms_msg );
				break;

			case 'rescheduled':
				$subject = sprintf( __( 'Appointment Rescheduled: %s', 'developer-starter-pro' ), $service_name );
				$body = "<h2>Hello {$patient_name},</h2>\n<p>Your appointment has been <strong>rescheduled</strong> by our clinic.</p>\n<p><strong>Reference ID:</strong> {$reference_id}<br>\n<strong>Treatment:</strong> {$service_name}<br>\n<strong>Doctor:</strong> {$doctor_name}<br>\n<strong>New Date:</strong> {$appointment_date}<br>\n<strong>New Time:</strong> {$appointment_time}</p>\n<p>We look forward to seeing you!</p>";
				$this->send_formatted_email( $patient_email, $subject, $body, $clinic_name, '#3b82f6' );

				$sms_msg = sprintf(
					__( "Hello %s, your appointment %s has been rescheduled to %s at %s.", 'developer-starter-pro' ),
					$patient_name,
					$reference_id,
					$appointment_date,
					$appointment_time
				);
				$this->dispatch_sms( $booking->patient_phone, $sms_msg );
				break;

			case 'completed':
				$subject = sprintf( __( 'Appointment Completed: %s', 'developer-starter-pro' ), $service_name );
				$body = "<h2>Hello {$patient_name},</h2>\n<p>Thank you for visiting our clinic today for your <strong>{$service_name}</strong> treatment.</p>\n<p>We hope you had a pleasant experience with <strong>{$doctor_name}</strong>.</p>\n<p>If you have any feedback or further questions, please do not hesitate to contact us.</p>\n<p>Wishing you great health!</p>";
				
				if ( ! empty( $options['google_review_url'] ) ) {
					$google_review_url = esc_url( $options['google_review_url'] );
					$body .= "<p style='margin-top: 24px; text-align: center;'><a href='{$google_review_url}' target='_blank' style='background-color: #10b981; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 24px; font-weight: 600; display: inline-block;'>" . esc_html__( 'Share Your Feedback on Google', 'developer-starter-pro' ) . "</a></p>";
				}
				
				error_log( "DentalPro: Completed notification sent to {$patient_email}" );
				$this->send_formatted_email( $patient_email, $subject, $body, $clinic_name, '#10b981' );

				$sms_msg = sprintf(
					__( "Hello %s, thank you for visiting us for your appointment %s today. We hope you had a great experience!", 'developer-starter-pro' ),
					$patient_name,
					$reference_id
				);
				
				if ( ! empty( $options['google_review_url'] ) ) {
					$google_review_url = esc_url( $options['google_review_url'] );
					$sms_msg .= " " . sprintf( __( "Please share your review on Google: %s", 'developer-starter-pro' ), $google_review_url );
				}
				
				$this->dispatch_sms( $booking->patient_phone, $sms_msg );
				break;
		}
	}

	/**
	 * Handle notifications on appointment reschedule.
	 *
	 * @param int $booking_id Database ID.
	 */
	public function handle_reschedule_notifications( $booking_id ) {
		$this->handle_status_change_notifications( $booking_id, 'dummy', 'rescheduled' );
	}
}
