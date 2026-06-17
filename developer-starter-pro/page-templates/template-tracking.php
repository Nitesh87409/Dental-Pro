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
							<td style="padding:12px 0; color:var(--developer-starter-pro-secondary); font-weight:600; text-align:right;">
								<?php 
								$booking_time = strtotime( $booking->booking_date );
								if ( $booking_time && $booking_time > 0 ) {
									echo esc_html( date_i18n( get_option( 'date_format' ), $booking_time ) );
								} else {
									echo esc_html__( 'Invalid Date', 'developer-starter-pro' );
								}
								?>
							</td>
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
							<button type="button" class="developer-starter-pro-btn" onclick="showCancelModal()" style="background:#ef4444; border:none; color:#fff; border-radius:24px; padding:10px 20px; font-weight:600; font-size:0.82rem; cursor:pointer;">
								<?php esc_html_e( 'Cancel Appointment', 'developer-starter-pro' ); ?>
							</button>
						<?php endif; ?>
					</div>

				</div>
			<?php endif; ?>

		</div>
	</section>

</main>

<!-- Custom Premium Cancellation Modal -->
<div id="dp-cancel-modal" class="dp-modal-backdrop" aria-hidden="true" role="dialog">
	<div class="dp-modal-card">
		<div class="dp-modal-icon">⚠️</div>
		<h3 class="dp-modal-title"><?php esc_html_e( 'Cancel Appointment?', 'developer-starter-pro' ); ?></h3>
		<p class="dp-modal-desc"><?php esc_html_e( 'Are you sure you want to cancel your scheduled appointment? This action cannot be undone.', 'developer-starter-pro' ); ?></p>
		<div class="dp-modal-actions">
			<button type="button" class="dp-modal-btn dp-modal-btn--secondary" onclick="closeCancelModal()">
				<?php esc_html_e( 'No, Keep It', 'developer-starter-pro' ); ?>
			</button>
			<form id="dp-cancel-form" method="post" action="">
				<?php wp_nonce_field( 'cancel_appointment_action', 'cancel_nonce' ); ?>
				<input type="hidden" name="tracking_action" value="cancel_appointment">
				<input type="hidden" name="booking_id" value="<?php echo intval( $booking ? $booking->id : 0 ); ?>">
				<input type="hidden" name="ref_id" value="<?php echo esc_attr( $ref_id ); ?>">
				<input type="hidden" name="phone" value="<?php echo esc_attr( $phone ); ?>">
				<button type="submit" class="dp-modal-btn dp-modal-btn--danger">
					<?php esc_html_e( 'Yes, Cancel It', 'developer-starter-pro' ); ?>
				</button>
			</form>
		</div>
	</div>
</div>

<style>
.dp-modal-backdrop {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(15, 23, 42, 0.4);
	backdrop-filter: blur(12px);
	-webkit-backdrop-filter: blur(12px);
	z-index: 99999;
	display: flex;
	align-items: center;
	justify-content: center;
	opacity: 0;
	pointer-events: none;
	transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.dp-modal-backdrop.is-active {
	opacity: 1;
	pointer-events: auto;
}
.dp-modal-card {
	background: rgba(255, 255, 255, 0.85);
	border: 1px solid rgba(255, 255, 255, 0.4);
	border-radius: 24px;
	padding: 32px;
	max-width: 420px;
	width: 90%;
	text-align: center;
	box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
	transform: scale(0.9);
	transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.dp-modal-backdrop.is-active .dp-modal-card {
	transform: scale(1);
}
.dp-modal-icon {
	font-size: 3rem;
	margin-bottom: 16px;
	display: inline-block;
}
.dp-modal-title {
	margin-top: 0;
	margin-bottom: 12px;
	font-size: 1.5rem;
	color: var(--developer-starter-pro-secondary);
	font-weight: 700;
}
.dp-modal-desc {
	color: var(--developer-starter-pro-gray-500);
	font-size: 0.95rem;
	line-height: 1.5;
	margin-bottom: 24px;
}
.dp-modal-actions {
	display: flex;
	gap: 12px;
	justify-content: center;
	align-items: center;
}
.dp-modal-btn {
	padding: 12px 24px;
	font-size: 0.9rem;
	font-weight: 600;
	border-radius: 24px;
	border: none;
	cursor: pointer;
	transition: all 0.2s ease;
}
.dp-modal-btn--secondary {
	background: var(--developer-starter-pro-gray-200);
	color: var(--developer-starter-pro-secondary);
}
.dp-modal-btn--secondary:hover {
	background: var(--developer-starter-pro-gray-300);
}
.dp-modal-btn--danger {
	background: #ef4444;
	color: #fff;
}
.dp-modal-btn--danger:hover {
	background: #dc2626;
	box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
}
#dp-cancel-form {
	margin: 0;
}
</style>

<script>
function showCancelModal() {
	const modal = document.getElementById('dp-cancel-modal');
	if (modal) {
		modal.classList.add('is-active');
		modal.setAttribute('aria-hidden', 'false');
	}
}
function closeCancelModal() {
	const modal = document.getElementById('dp-cancel-modal');
	if (modal) {
		modal.classList.remove('is-active');
		modal.setAttribute('aria-hidden', 'true');
	}
}
document.addEventListener('DOMContentLoaded', function() {
	const modal = document.getElementById('dp-cancel-modal');
	if (modal) {
		modal.addEventListener('click', function(e) {
			if (e.target === modal) {
				closeCancelModal();
			}
		});
	}
});
</script>

</main>

<?php
get_footer();
