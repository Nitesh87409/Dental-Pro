<?php
/**
 * Template Name: Patient Portal - Dashboard
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Redirect to login if not logged in
if ( ! is_user_logged_in() ) {
	wp_safe_redirect( Developer_Starter_Pro_Portal::get_login_url() );
	exit;
}

get_header();

$user = wp_get_current_user();
$user_id = $user->ID;

// Fetch patient custom metadata
$phone       = get_user_meta( $user_id, 'patient_phone', true );
$dob         = get_user_meta( $user_id, 'patient_dob', true );
$allergies   = get_user_meta( $user_id, 'medical_allergies', true );
$medications = get_user_meta( $user_id, 'medical_medications', true );
$conditions  = get_user_meta( $user_id, 'medical_conditions', true );

// Fetch patient appointments
global $wpdb;
$table_name = Developer_Starter_Pro_Booking::get_table_name();
$appointments = array();
if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
	$appointments = $wpdb->get_results( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE patient_email = %s ORDER BY booking_date DESC, time_slot ASC",
		$user->user_email
	) );
}

// Separate into upcoming and past
$upcoming = array();
$past     = array();
$today    = date( 'Y-m-d' );
$now_time = date( 'H:i' );

if ( ! empty( $appointments ) ) {
	foreach ( $appointments as $apt ) {
		if ( $apt->booking_date > $today || ( $apt->booking_date === $today && $apt->time_slot >= $now_time ) ) {
			if ( 'cancelled' !== $apt->status ) {
				$upcoming[] = $apt;
			} else {
				$past[] = $apt;
			}
		} else {
			$past[] = $apt;
		}
	}
}

$updated = isset( $_GET['updated'] );
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:24px;">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 40px 0; text-align: left;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Secure Portal', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php printf( esc_html__( 'Welcome, %s', 'developer-starter-pro' ), esc_html( $user->display_name ) ); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Manage your clinical relationship with our dental experts.', 'developer-starter-pro' ); ?></p>
			</div>
			<div>
				<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline" style="border-color: #f1f5f9; color:#fff;">
					<?php esc_html_e( 'Log Out', 'developer-starter-pro' ); ?>
				</a>
			</div>
		</div>
	</div>

	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">
			
			<?php if ( $updated ) : ?>
				<div class="portal-success-banner" style="background:#d1fae5; border:1px solid #a7f3d0; color:#065f46; border-radius:8px; padding:16px; margin-bottom:30px; font-weight:500; text-align:center;">
					🎉 <?php esc_html_e( 'Your patient profile & medical records updated successfully.', 'developer-starter-pro' ); ?>
				</div>
			<?php endif; ?>

			<div class="portal-dashboard-grid" style="display:grid; grid-template-columns: 1.2fr 2fr; gap:40px; align-items: flex-start;">
				
				<!-- Left Column: Patient Profile & Medical History Form -->
				<div class="portal-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:12px; padding:30px; box-shadow: var(--developer-starter-pro-shadow-sm);">
					<h3 style="margin-top:0; margin-bottom:20px; font-size:1.25rem; border-bottom:2px solid var(--developer-starter-pro-gray-100); padding-bottom:12px;">🛡️ <?php esc_html_e( 'Medical & Contact Profile', 'developer-starter-pro' ); ?></h3>
					
					<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
						<input type="hidden" name="action" value="dentalpro_patient_update_profile">
						<?php wp_nonce_field( 'dentalpro_update_profile_action', 'profile_nonce' ); ?>

						<div style="display:flex; flex-direction:column; gap:16px;">
							<div>
								<label style="display:block; font-weight:600; margin-bottom:4px; font-size:0.875rem;"><?php esc_html_e( 'Email Address (Account)', 'developer-starter-pro' ); ?></label>
								<input type="email" value="<?php echo esc_attr( $user->user_email ); ?>" disabled style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px; background:#f8fafc; cursor:not-allowed;">
							</div>

							<?php if ( $dob ) : ?>
								<div>
									<label style="display:block; font-weight:600; margin-bottom:4px; font-size:0.875rem;"><?php esc_html_e( 'Date of Birth', 'developer-starter-pro' ); ?></label>
									<input type="text" value="<?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $dob ) ) ); ?>" disabled style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px; background:#f8fafc; cursor:not-allowed;">
								</div>
							<?php endif; ?>

							<div>
								<label style="display:block; font-weight:600; margin-bottom:4px; font-size:0.875rem;"><?php esc_html_e( 'Contact Phone Number', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
								<input type="tel" name="patient_phone" value="<?php echo esc_attr( $phone ); ?>" required style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;">
							</div>

							<div style="margin-top:10px; border-top:1px solid var(--developer-starter-pro-gray-100); padding-top:16px;">
								<h4 style="margin:0 0 12px 0; font-size:1rem; color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Secure Medical History', 'developer-starter-pro' ); ?></h4>
								<span style="font-size:0.75rem; color:var(--developer-starter-pro-gray-400); display:block; margin-bottom:12px;"><?php esc_html_e( 'This clinical data is encrypted and visible only to your treating doctor.', 'developer-starter-pro' ); ?></span>
								
								<div style="margin-bottom:12px;">
									<label style="display:block; font-weight:600; margin-bottom:4px; font-size:0.875rem;"><?php esc_html_e( 'Known Allergies', 'developer-starter-pro' ); ?></label>
									<textarea name="medical_allergies" rows="2" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;" placeholder="e.g. Penicillin, Latex, None"><?php echo esc_textarea( $allergies ); ?></textarea>
								</div>

								<div style="margin-bottom:12px;">
									<label style="display:block; font-weight:600; margin-bottom:4px; font-size:0.875rem;"><?php esc_html_e( 'Current Medications', 'developer-starter-pro' ); ?></label>
									<textarea name="medical_medications" rows="2" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;" placeholder="e.g. Blood pressure pills, None"><?php echo esc_textarea( $medications ); ?></textarea>
								</div>

								<div>
									<label style="display:block; font-weight:600; margin-bottom:4px; font-size:0.875rem;"><?php esc_html_e( 'Pre-existing Medical Conditions', 'developer-starter-pro' ); ?></label>
									<textarea name="medical_conditions" rows="2" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;" placeholder="e.g. Diabetes, Pregnancy, None"><?php echo esc_textarea( $conditions ); ?></textarea>
								</div>
							</div>

							<div style="margin-top:10px;">
								<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="width:100%; padding:10px;">
									<?php esc_html_e( 'Update Patient File', 'developer-starter-pro' ); ?>
								</button>
							</div>
						</div>
					</form>
				</div>

				<!-- Right Column: Patient Appointments Schedules -->
				<div class="portal-appointments-area">
					
					<!-- Upcoming appointments -->
					<div class="portal-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:12px; padding:30px; box-shadow: var(--developer-starter-pro-shadow-sm); margin-bottom:30px;">
						<h3 style="margin-top:0; margin-bottom:20px; font-size:1.25rem; border-bottom:2px solid var(--developer-starter-pro-gray-100); padding-bottom:12px;">📅 <?php esc_html_e( 'Upcoming Appointments', 'developer-starter-pro' ); ?></h3>

						<?php if ( ! empty( $upcoming ) ) : ?>
							<div style="display:flex; flex-direction:column; gap:16px;">
								<?php foreach ( $upcoming as $apt ) : 
									$doc_name = get_the_title( $apt->doctor_id );
									$srv_name = get_the_title( $apt->service_id );
									$status_class = esc_attr( $apt->status );
									?>
									<div class="patient-appointment-card" style="border:1px solid var(--developer-starter-pro-gray-200); border-left:4px solid var(--developer-starter-pro-primary); padding:20px; border-radius:8px; display:flex; justify-content:space-between; align-items:center;">
										<div>
											<strong style="font-size:1.0625rem; display:block; color:var(--developer-starter-pro-secondary);"><?php echo esc_html( $srv_name ); ?></strong>
											<span style="font-size:0.875rem; color:var(--developer-starter-pro-gray-500); display:block; margin-top:2px;">👨‍⚕️ <?php echo esc_html( $doc_name ); ?></span>
											<span style="font-size:0.8125rem; color:var(--developer-starter-pro-gray-400); display:block; margin-top:4px;">
												🗓️ <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $apt->booking_date ) ) ); ?> at <?php echo esc_html( date( 'g:i A', strtotime( $apt->time_slot ) ) ); ?>
											</span>
										</div>
										<div style="text-align:right;">
											<span class="patient-status-badge <?php echo $status_class; ?>" style="display:inline-block; padding: 4px 12px; border-radius:12px; font-size:0.75rem; font-weight:700; text-transform:uppercase;">
												<?php echo esc_html( $apt->status ); ?>
											</span>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<p style="color:var(--developer-starter-pro-gray-400); font-style:italic;"><?php esc_html_e( 'You have no active upcoming appointments.', 'developer-starter-pro' ); ?></p>
							<div style="margin-top:16px;">
								<a href="<?php 
									// Find booking page URL
									$booking_pages = get_pages( array(
										'meta_key'   => '_wp_page_template',
										'meta_value' => 'page-templates/template-booking.php'
									) );
									echo ! empty( $booking_pages ) ? esc_url( get_permalink( $booking_pages[0]->ID ) ) : esc_url( home_url( '/booking/' ) );
								?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
									<?php esc_html_e( 'Schedule Appointment Now', 'developer-starter-pro' ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<!-- History / Past appointments -->
					<div class="portal-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:12px; padding:30px; box-shadow: var(--developer-starter-pro-shadow-sm);">
						<h3 style="margin-top:0; margin-bottom:20px; font-size:1.25rem; border-bottom:2px solid var(--developer-starter-pro-gray-100); padding-bottom:12px;">📜 <?php esc_html_e( 'Past & Cancelled Appointments', 'developer-starter-pro' ); ?></h3>

						<?php if ( ! empty( $past ) ) : ?>
							<table class="portal-history-table" style="width:100%; border-collapse: collapse; font-size:0.875rem;">
								<thead>
									<tr style="border-bottom: 2px solid var(--developer-starter-pro-gray-100); text-align: left;">
										<th style="padding:10px 0; font-weight:600; color:var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Service / Doctor', 'developer-starter-pro' ); ?></th>
										<th style="padding:10px 0; font-weight:600; color:var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'Date & Time', 'developer-starter-pro' ); ?></th>
										<th style="padding:10px 0; font-weight:600; color:var(--developer-starter-pro-gray-500); text-align:right;"><?php esc_html_e( 'Status', 'developer-starter-pro' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $past as $apt ) : 
										$doc_name = get_the_title( $apt->doctor_id );
										$srv_name = get_the_title( $apt->service_id );
										$status_class = esc_attr( $apt->status );
										?>
										<tr style="border-bottom:1px solid var(--developer-starter-pro-gray-100);">
											<td style="padding:12px 0;">
												<strong><?php echo esc_html( $srv_name ); ?></strong>
												<span style="display:block; font-size:0.75rem; color:var(--developer-starter-pro-gray-400); margin-top:2px;">👨‍⚕️ <?php echo esc_html( $doc_name ); ?></span>
											</td>
											<td style="padding:12px 0; color:var(--developer-starter-pro-gray-600);">
												<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $apt->booking_date ) ) ); ?>
												<span style="display:block; font-size:0.75rem; color:var(--developer-starter-pro-gray-400);"><?php echo esc_html( date( 'g:i A', strtotime( $apt->time_slot ) ) ); ?></span>
											</td>
											<td style="padding:12px 0; text-align:right;">
												<span class="patient-status-badge <?php echo $status_class; ?>" style="display:inline-block; padding: 2px 8px; border-radius:10px; font-size:0.6875rem; font-weight:700; text-transform:uppercase;">
													<?php echo esc_html( $apt->status ); ?>
												</span>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php else : ?>
							<p style="color:var(--developer-starter-pro-gray-400); font-style:italic; margin-bottom:0;"><?php esc_html_e( 'No past appointments on record.', 'developer-starter-pro' ); ?></p>
						<?php endif; ?>
					</div>

				</div>

			</div>

		</div>
	</section>

</main>

<style>
/* Portal badge styles */
.patient-status-badge.pending { background: #fef3c7; color: #d97706; }
.patient-status-badge.approved { background: #d1fae5; color: #065f46; }
.patient-status-badge.completed { background: #dbeafe; color: #1e40af; }
.patient-status-badge.cancelled { background: #fef2f2; color: #991b1b; }

@media (max-width: 991px) {
	.portal-dashboard-grid { grid-template-columns: 1fr !important; gap:30px !important; }
}
</style>

<?php
get_footer();
