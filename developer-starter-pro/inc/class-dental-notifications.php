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
				<code>{patient_name}</code>, <code>{patient_email}</code>, <code>{patient_phone}</code>, <code>{patient_notes}</code>, <code>{doctor_name}</code>, <code>{service_name}</code>, <code>{appointment_date}</code>, <code>{appointment_time}</code>, <code>{clinic_name}</code>
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
		$this->send_email_by_id( $booking_id, 'patient_conf' );
		$this->send_email_by_id( $booking_id, 'admin_alert' );
	}

	/**
	 * WP-Cron callback daily.
	 * Queries and sends reminder emails for slots scheduled tomorrow.
	 */
	public function send_daily_reminders() {
		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();
		
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
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

		// Subject and Body keys
		$subject = $settings[ $type . '_subject' ];
		$body    = $settings[ $type . '_body' ];

		// Replaces tags array
		$replacements = array(
			'{patient_name}'     => $patient_name,
			'{patient_email}'    => $patient_email,
			'{patient_phone}'    => $patient_phone,
			'{patient_notes}'    => $patient_notes,
			'{doctor_name}'      => $doctor_name,
			'{service_name}'     => $service_name,
			'{appointment_date}' => $appointment_date,
			'{appointment_time}' => $appointment_time,
			'{clinic_name}'      => $clinic_name,
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

		return wp_mail( $to, $subject, $html_body, $headers );
	}
}
