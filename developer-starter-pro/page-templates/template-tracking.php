<?php
/**
 * Template Name: Appointment Status Tracking
 *
 * Provides status tracking and cancellation functionality for patients
 * using Reference ID and Mobile Number.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

global $wpdb;
$table_name = Developer_Starter_Pro_Booking::get_table_name();

$ref_id = sanitize_text_field( $_POST['ref_id'] ?? '' );
$phone  = sanitize_text_field( $_POST['phone'] ?? '' );
$action = sanitize_text_field( $_POST['tracking_action'] ?? '' );

$booking = null;
$error = '';
$success_msg = '';

// 1. Process Cancellation
if ( 'cancel_appointment' === $action && isset( $_POST['cancel_nonce'] ) && wp_verify_nonce( $_POST['cancel_nonce'], 'cancel_appointment_action' ) ) {
	$booking_id = intval( $_POST['booking_id'] ?? 0 );
	
	$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $booking_id ) );
	if ( $booking ) {
		$phone_clean = preg_replace( '/[^\d]/', '', $phone );
		$db_phone_clean = preg_replace( '/[^\d]/', '', $booking->patient_phone );

		if ( $phone_clean === $db_phone_clean ) {
			$updated = $wpdb->update(
				$table_name,
				array( 'status' => 'cancelled' ),
				array( 'id' => $booking_id ),
				array( '%s' ),
				array( '%d' )
			);

			if ( false !== $updated ) {
				$success_msg = __( 'Your appointment has been successfully cancelled.', 'developer-starter-pro' );
				// Trigger cancellation notifications
				if ( class_exists( 'Developer_Starter_Pro_Notifications' ) ) {
					$notifications = new Developer_Starter_Pro_Notifications();
					$notifications->send_cancellation_emails( $booking_id );
				}
				// Refresh local record values
				$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $booking_id ) );
			} else {
				$error = __( 'Database update failed. Please try again.', 'developer-starter-pro' );
			}
		} else {
			$error = __( 'Verification failed. Mobile number does not match.', 'developer-starter-pro' );
		}
	} else {
		$error = __( 'Appointment record not found.', 'developer-starter-pro' );
	}
}
// 2. Process Lookup / Verify
elseif ( ! empty( $ref_id ) && ! empty( $phone ) ) {
	// Verify nonce for lookup
	if ( ! isset( $_POST['tracking_lookup_nonce'] ) || ! wp_verify_nonce( $_POST['tracking_lookup_nonce'], 'tracking_lookup_action' ) ) {
		$error = __( 'Security check failed. Please refresh and try again.', 'developer-starter-pro' );
	} else {
		// Rate limiting — 10 lookups per minute per IP
		$rl_check = developer_starter_pro_rate_limit( 'tracking', 10, 60 );
		if ( is_wp_error( $rl_check ) ) {
			$error = __( 'Too many attempts. Please wait a moment and try again.', 'developer-starter-pro' );
		} else {
			// Extract numeric ID from reference string (e.g. "APT-00095" -> "00095" -> 95)
			$booking_id = intval( preg_replace( '/[^\d]/', '', $ref_id ) );
			
			$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $booking_id ) );
			
			if ( $booking ) {
				$phone_clean = preg_replace( '/[^\d]/', '', $phone );
				$db_phone_clean = preg_replace( '/[^\d]/', '', $booking->patient_phone );

				// Match phone numbers (relaxed matching to handle suffix/prefix extensions)
				if ( $phone_clean !== $db_phone_clean && strpos( $db_phone_clean, $phone_clean ) === false && strpos( $phone_clean, $db_phone_clean ) === false ) {
					$error = __( 'Verification failed. Mobile number does not match.', 'developer-starter-pro' );
					$booking = null;
				}
			} else {
				$error = __( 'Invalid Reference ID. No matching appointment found.', 'developer-starter-pro' );
			}
		}
	}
}
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Status Tracker', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php esc_html_e( 'Track Your Appointment', 'developer-starter-pro' ); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Check status or cancel your scheduled appointment.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Main Container -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container" style="max-width: 650px;">

			<!-- Success / Error Banners -->
			<?php if ( $error ) : ?>
				<div class="dp-alert dp-alert--danger" style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:12px; padding:16px; margin-bottom:24px; font-weight:500;">
					<?php echo esc_html( $error ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $success_msg ) : ?>
				<div class="dp-alert dp-alert--success" style="background:#dcfce7; border:1px solid #86efac; color:#15803d; border-radius:12px; padding:16px; margin-bottom:24px; font-weight:500;">
					<?php echo esc_html( $success_msg ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! $booking ) : ?>
				<!-- Tracking Request Form -->
				<div class="dp-tracking-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:16px; padding: 40px; box-shadow: var(--developer-starter-pro-shadow-lg);">
					<h2 style="margin-top:0; margin-bottom:12px; font-size:1.5rem; text-align:center; color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Enter Details', 'developer-starter-pro' ); ?></h2>
					<p style="text-align:center; color:var(--developer-starter-pro-gray-500); font-size:0.9rem; margin-bottom:32px;"><?php esc_html_e( 'Provide your Reference ID and the mobile number used during booking.', 'developer-starter-pro' ); ?></p>

					<form method="post" action="">
						<?php wp_nonce_field( 'tracking_lookup_action', 'tracking_lookup_nonce' ); ?>
						<div style="display:flex; flex-direction:column; gap:20px;">
							<div>
								<label for="ref_id" style="display:block; font-weight:600; margin-bottom:8px; color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Appointment Reference ID', 'developer-starter-pro' ); ?></label>
								<input type="text" id="ref_id" name="ref_id" value="<?php echo esc_attr( $ref_id ); ?>" required placeholder="e.g. APT-00095" style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;">
							</div>
							<div>
								<label for="phone" style="display:block; font-weight:600; margin-bottom:8px; color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Mobile Number', 'developer-starter-pro' ); ?></label>
								<input type="tel" id="phone" name="phone" value="<?php echo esc_attr( $phone ); ?>" required placeholder="e.g. +1 (555) 123-4567" style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;">
							</div>
							<div style="margin-top:10px;">
								<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary developer-starter-pro-btn--full" style="padding:14px; font-size:1rem;">
									<?php esc_html_e( 'Check Status', 'developer-starter-pro' ); ?>
								</button>
							</div>
						</div>
					</form>
				</div>
			<?php else : ?>
				<!-- Booking Details Panel -->
				<div class="dp-tracking-details-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:16px; padding: 40px; box-shadow: var(--developer-starter-pro-shadow-lg);">
					
					<!-- Header Row -->
					<div style="display:flex; justify-content:space-between; align-items:flex-start; border-bottom:1px solid var(--developer-starter-pro-gray-200); padding-bottom:20px; margin-bottom:24px;">
						<div>
							<span style="font-size:0.75rem; text-transform:uppercase; color:var(--developer-starter-pro-gray-400); font-weight:700;"><?php esc_html_e( 'Appointment Reference ID', 'developer-starter-pro' ); ?></span>
							<h2 style="margin:4px 0 0 0; font-size:1.6rem; color:var(--developer-starter-pro-secondary); font-family: 'Inter', sans-serif;">APT-<?php echo esc_html( sprintf( '%05d', $booking->id ) ); ?></h2>
						</div>
						<div>
							<?php
							$status = strtolower( $booking->status );
							if ( 'confirmed' === $status ) {
								$badge_style = 'background:#dcfce7; color:#15803d; border-color:#86efac;';
								$status_lbl  = __( 'Confirmed', 'developer-starter-pro' );
							} elseif ( 'cancelled' === $status ) {
								$badge_style = 'background:#fee2e2; color:#b91c1c; border-color:#fca5a5;';
								$status_lbl  = __( 'Cancelled', 'developer-starter-pro' );
							} else {
								$badge_style = 'background:#fef9c3; color:#a16207; border-color:#fde047;';
								$status_lbl  = __( 'Pending Approval', 'developer-starter-pro' );
							}
							?>
							<span style="display:inline-block; padding: 6px 14px; border-radius:20px; font-size: 0.8rem; font-weight:700; text-transform:uppercase; border:1px solid; <?php echo $badge_style; ?>">
								<?php echo esc_html( $status_lbl ); ?>
							</span>
						</div>
					</div>

					<!-- Details Grid -->
					<table style="width:100%; border-collapse:collapse; margin-bottom:32px;">
						<tr style="border-bottom:1px solid var(--developer-starter-pro-gray-100);">
							<td style="padding:12px 0; color:var(--developer-starter-pro-gray-400); font-weight:500; font-size:0.9rem; width:35%;"><?php esc_html_e( 'Patient Name', 'developer-starter-pro' ); ?></td>
							<td style="padding:12px 0; color:var(--developer-starter-pro-secondary); font-weight:600; text-align:right;"><?php echo esc_html( $booking->patient_name ); ?></td>
						</tr>
						<tr style="border-bottom:1px solid var(--developer-starter-pro-gray-100);">
							<td style="padding:12px 0; color:var(--developer-starter-pro-gray-400); font-weight:500; font-size:0.9rem;"><?php esc_html_e( 'Treatment', 'developer-starter-pro' ); ?></td>
							<td style="padding:12px 0; color:var(--developer-starter-pro-secondary); font-weight:600; text-align:right;"><?php echo esc_html( get_the_title( $booking->service_id ) ); ?></td>
						</tr>
						<tr style="border-bottom:1px solid var(--developer-starter-pro-gray-100);">
							<td style="padding:12px 0; color:var(--developer-starter-pro-gray-400); font-weight:500; font-size:0.9rem;"><?php esc_html_e( 'Doctor', 'developer-starter-pro' ); ?></td>
							<td style="padding:12px 0; color:var(--developer-starter-pro-secondary); font-weight:600; text-align:right;"><?php echo esc_html( get_the_title( $booking->doctor_id ) ); ?></td>
						</tr>
						<tr style="border-bottom:1px solid var(--developer-starter-pro-gray-100);">
							<td style="padding:12px 0; color:var(--developer-starter-pro-gray-400); font-weight:500; font-size:0.9rem;"><?php esc_html_e( 'Appointment Date', 'developer-starter-pro' ); ?></td>
							<td style="padding:12px 0; color:var(--developer-starter-pro-secondary); font-weight:600; text-align:right;"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $booking->booking_date ) ) ); ?></td>
						</tr>
						<tr style="border-bottom:1px solid var(--developer-starter-pro-gray-100);">
							<td style="padding:12px 0; color:var(--developer-starter-pro-gray-400); font-weight:500; font-size:0.9rem;"><?php esc_html_e( 'Scheduled Time', 'developer-starter-pro' ); ?></td>
							<td style="padding:12px 0; color:var(--developer-starter-pro-secondary); font-weight:600; text-align:right;"><?php echo esc_html( date( 'g:i A', strtotime( $booking->time_slot ) ) ); ?></td>
						</tr>
						<?php if ( ! empty( $booking->notes ) ) : ?>
						<tr style="border-bottom:1px solid var(--developer-starter-pro-gray-100);">
							<td style="padding:12px 0; color:var(--developer-starter-pro-gray-400); font-weight:500; font-size:0.9rem; vertical-align:top;"><?php esc_html_e( 'Notes', 'developer-starter-pro' ); ?></td>
							<td style="padding:12px 0; color:var(--developer-starter-pro-secondary); font-size:0.9rem; text-align:right; line-height:1.4;"><?php echo esc_html( $booking->notes ); ?></td>
						</tr>
						<?php endif; ?>
					</table>

					<!-- Action Buttons -->
					<div style="display:flex; gap:16px; justify-content:space-between; align-items:center;">
						<a href="" style="color:var(--developer-starter-pro-gray-400); font-weight:600; text-decoration:none; font-size:0.875rem;">← <?php esc_html_e( 'Check Another', 'developer-starter-pro' ); ?></a>
						
						<?php if ( 'cancelled' !== $status ) : ?>
							<form method="post" action="" onsubmit="return confirm('<?php esc_attr_e( 'Are you sure you want to cancel this appointment?', 'developer-starter-pro' ); ?>');">
								<?php wp_nonce_field( 'cancel_appointment_action', 'cancel_nonce' ); ?>
								<input type="hidden" name="tracking_action" value="cancel_appointment">
								<input type="hidden" name="booking_id" value="<?php echo intval( $booking->id ); ?>">
								<input type="hidden" name="ref_id" value="<?php echo esc_attr( $ref_id ); ?>">
								<input type="hidden" name="phone" value="<?php echo esc_attr( $phone ); ?>">
								<button type="submit" class="developer-starter-pro-btn" style="background:#ef4444; border:none; color:#fff; border-radius:24px; padding:10px 20px; font-weight:600; font-size:0.82rem; cursor:pointer;">
									<?php esc_html_e( 'Cancel Appointment', 'developer-starter-pro' ); ?>
								</button>
							</form>
						<?php endif; ?>
					</div>

				</div>
			<?php endif; ?>

		</div>
	</section>

</main>

<?php
get_footer();
