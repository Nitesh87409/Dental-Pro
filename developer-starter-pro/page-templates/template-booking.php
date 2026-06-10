<?php
/**
 * Template Name: Appointment Booking Wizard
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

// Fetch services and doctors for lists
$services = get_posts( array(
	'post_type'      => 'services',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
) );

$doctors = get_posts( array(
	'post_type'      => 'doctors',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
) );

$selected_doctor  = isset( $_GET['doctor_id'] ) ? absint( $_GET['doctor_id'] ) : 0;
$selected_service = isset( $_GET['service_id'] ) ? absint( $_GET['service_id'] ) : 0;
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Scheduler', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Book your dental appointment in four simple steps.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Wizard Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container" style="max-width: 900px;">
			
			<div class="developer-starter-pro-booking-wizard-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:16px; padding: 40px; box-shadow: var(--developer-starter-pro-shadow-lg);">
				
				<!-- Steps Indicator Bar -->
				<div class="booking-wizard-steps" style="display:flex; justify-content:space-between; margin-bottom: 48px; position:relative; overflow:hidden;">
					<div class="step-progress-line" style="position:absolute; top: 20px; left: 0; right:0; height:3px; background:var(--developer-starter-pro-gray-200); z-index:1;">
						<div class="step-progress-fill" id="step-progress-fill" style="width: 0%; height:100%; background:var(--developer-starter-pro-primary); transition: width 0.3s ease;"></div>
					</div>
					
					<div class="wizard-step-indicator active" data-step="1" style="position:relative; z-index:2; text-align:center; flex:1;">
						<span class="step-number" style="width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background:#fff; border:3px solid var(--developer-starter-pro-gray-200); font-weight:700; color:var(--developer-starter-pro-gray-400); transition: all 0.3s ease;">1</span>
						<span class="step-label" style="display:block; font-size:0.75rem; font-weight:600; text-transform:uppercase; margin-top:8px; color:var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'Service', 'developer-starter-pro' ); ?></span>
					</div>
					
					<div class="wizard-step-indicator" data-step="2" style="position:relative; z-index:2; text-align:center; flex:1;">
						<span class="step-number" style="width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background:#fff; border:3px solid var(--developer-starter-pro-gray-200); font-weight:700; color:var(--developer-starter-pro-gray-400); transition: all 0.3s ease;">2</span>
						<span class="step-label" style="display:block; font-size:0.75rem; font-weight:600; text-transform:uppercase; margin-top:8px; color:var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'Doctor', 'developer-starter-pro' ); ?></span>
					</div>
					
					<div class="wizard-step-indicator" data-step="3" style="position:relative; z-index:2; text-align:center; flex:1;">
						<span class="step-number" style="width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background:#fff; border:3px solid var(--developer-starter-pro-gray-200); font-weight:700; color:var(--developer-starter-pro-gray-400); transition: all 0.3s ease;">3</span>
						<span class="step-label" style="display:block; font-size:0.75rem; font-weight:600; text-transform:uppercase; margin-top:8px; color:var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'Schedule', 'developer-starter-pro' ); ?></span>
					</div>
					
					<div class="wizard-step-indicator" data-step="4" style="position:relative; z-index:2; text-align:center; flex:1;">
						<span class="step-number" style="width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background:#fff; border:3px solid var(--developer-starter-pro-gray-200); font-weight:700; color:var(--developer-starter-pro-gray-400); transition: all 0.3s ease;">4</span>
						<span class="step-label" style="display:block; font-size:0.75rem; font-weight:600; text-transform:uppercase; margin-top:8px; color:var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'Patient Info', 'developer-starter-pro' ); ?></span>
					</div>
				</div>

				<!-- Wizard Form -->
				<form id="booking-wizard-form" method="post" action="#">
					
					<!-- Step 1: Choose Service -->
					<div class="booking-wizard-panel active" data-panel="1">
						<h2 style="margin-top:0; margin-bottom:24px; font-size:1.5rem; text-align:center;"><?php esc_html_e( 'Select Your Dental Treatment', 'developer-starter-pro' ); ?></h2>
						
						<div class="wizard-services-list" style="display:grid; grid-template-columns: 1fr; gap:16px;">
							<?php if ( ! empty( $services ) ) :
								foreach ( $services as $srv ) :
									$price = get_post_meta( $srv->ID, '_developer_starter_pro_service_price', true );
									$duration = get_post_meta( $srv->ID, '_developer_starter_pro_service_duration', true );
									$short_desc = get_post_meta( $srv->ID, '_developer_starter_pro_service_short_description', true );
									?>
									<label class="wizard-selection-card" style="display:flex; justify-content:space-between; align-items:center; border:2px solid var(--developer-starter-pro-gray-200); border-radius:12px; padding: 20px; cursor:pointer; transition:all 0.2s ease;">
										<div style="display:flex; align-items:center; gap:16px;">
											<input type="radio" name="service_id" value="<?php echo intval( $srv->ID ); ?>" <?php checked( $srv->ID, $selected_service ); ?> required style="width:20px; height:20px; accent-color: var(--developer-starter-pro-primary);">
											<div>
												<strong style="font-size:1.0625rem; display:block; color:var(--developer-starter-pro-secondary);"><?php echo esc_html( $srv->post_title ); ?></strong>
												<?php if ( $short_desc ) : ?>
													<span style="font-size:0.875rem; color:var(--developer-starter-pro-gray-500); display:block; margin-top:2px;"><?php echo esc_html( $short_desc ); ?></span>
												<?php endif; ?>
											</div>
										</div>
										<div style="text-align:right;">
											<?php if ( $price && $price > 0 ) : ?>
												<span style="font-size:1.25rem; font-weight:700; color:var(--developer-starter-pro-primary); display:block;">$<?php echo esc_html( number_format( (float) $price, 0 ) ); ?></span>
											<?php else : ?>
												<span style="font-size:1.0625rem; font-weight:600; color:var(--developer-starter-pro-gray-500); display:block;"><?php esc_html_e( 'Consultation', 'developer-starter-pro' ); ?></span>
											<?php endif; ?>
											<?php if ( $duration ) : ?>
												<span style="font-size:0.75rem; color:var(--developer-starter-pro-gray-400); display:block; margin-top:2px;"><?php echo esc_html( $duration ); ?> <?php esc_html_e( 'mins', 'developer-starter-pro' ); ?></span>
											<?php endif; ?>
										</div>
									</label>
								<?php endforeach;
							else : ?>
								<p style="text-align:center; color:var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'No services available to book.', 'developer-starter-pro' ); ?></p>
							<?php endif; ?>
						</div>
					</div>

					<!-- Step 2: Choose Doctor -->
					<div class="booking-wizard-panel" data-panel="2" style="display:none;">
						<h2 style="margin-top:0; margin-bottom:24px; font-size:1.5rem; text-align:center;"><?php esc_html_e( 'Select Your Doctor', 'developer-starter-pro' ); ?></h2>
						
						<div class="wizard-doctors-list" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:20px;">
							<?php if ( ! empty( $doctors ) ) :
								foreach ( $doctors as $doc ) :
									$spec = get_post_meta( $doc->ID, '_developer_starter_pro_doctor_speciality', true );
									?>
									<label class="wizard-selection-card flex-column" style="display:flex; flex-direction:column; align-items:center; border:2px solid var(--developer-starter-pro-gray-200); border-radius:12px; padding: 24px; cursor:pointer; text-align:center; transition:all 0.2s ease;">
										<input type="radio" name="doctor_id" value="<?php echo intval( $doc->ID ); ?>" <?php checked( $doc->ID, $selected_doctor ); ?> required style="margin-bottom:16px; width:20px; height:20px; accent-color: var(--developer-starter-pro-primary);">
										<div class="doctor-avatar" style="width:90px; height:90px; border-radius:50%; background:var(--developer-starter-pro-gray-100); display:flex; align-items:center; justify-content:center; font-size:2rem; margin-bottom:12px; overflow:hidden;">
											<?php if ( has_post_thumbnail( $doc->ID ) ) : ?>
												<?php echo get_the_post_thumbnail( $doc->ID, 'thumbnail', array( 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
											<?php else : ?>
												👨‍⚕️
											<?php endif; ?>
										</div>
										<strong style="font-size:1.0625rem; display:block; color:var(--developer-starter-pro-secondary);"><?php echo esc_html( $doc->post_title ); ?></strong>
										<?php if ( $spec ) : ?>
											<span style="font-size:0.8125rem; color:var(--developer-starter-pro-primary); display:block; font-weight:600; margin-top:4px;"><?php echo esc_html( $spec ); ?></span>
										<?php endif; ?>
									</label>
								<?php endforeach;
							else : ?>
								<p style="text-align:center; color:var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'No doctors available.', 'developer-starter-pro' ); ?></p>
							<?php endif; ?>
						</div>
					</div>

					<!-- Step 3: Choose Date & Time -->
					<div class="booking-wizard-panel" data-panel="3" style="display:none;">
						<h2 style="margin-top:0; margin-bottom:24px; font-size:1.5rem; text-align:center;"><?php esc_html_e( 'Select Appointment Date & Time', 'developer-starter-pro' ); ?></h2>
						
						<div class="wizard-schedule-split" style="display:grid; grid-template-columns: 1fr 1fr; gap:32px;">
							<div>
								<label style="display:block; font-weight:600; margin-bottom:8px;"><?php esc_html_e( 'Choose Date:', 'developer-starter-pro' ); ?></label>
								<input type="date" id="booking_date" name="booking_date" min="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>" style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem; font-family:inherit;">
							</div>
							<div>
								<label style="display:block; font-weight:600; margin-bottom:8px;"><?php esc_html_e( 'Available Slots:', 'developer-starter-pro' ); ?></label>
								<div id="slots-container" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap:10px; max-height: 250px; overflow-y: auto; padding: 4px;">
									<p style="color:var(--developer-starter-pro-gray-400); font-style:italic; font-size:0.9rem; grid-column: 1/-1; text-align:center; padding-top:20px;"><?php esc_html_e( 'Please select a date first.', 'developer-starter-pro' ); ?></p>
								</div>
							</div>
						</div>
					</div>

					<!-- Step 4: Patient Info -->
					<div class="booking-wizard-panel" data-panel="4" style="display:none;">
						<h2 style="margin-top:0; margin-bottom:24px; font-size:1.5rem; text-align:center;"><?php esc_html_e( 'Provide Contact Information', 'developer-starter-pro' ); ?></h2>
						
						<div style="display:flex; flex-direction:column; gap:16px;">
							<div>
								<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Full Name', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
								<input type="text" name="patient_name" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px;">
							</div>
							<div class="form-row" style="display:flex; gap:16px;">
								<div style="flex:1;">
									<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
									<input type="email" name="patient_email" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px;">
								</div>
								<div style="flex:1;">
									<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Phone Number', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
									<input type="tel" name="patient_phone" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px;">
								</div>
							</div>
							<div>
								<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Symptom Details / Medical Notes', 'developer-starter-pro' ); ?></label>
								<textarea name="notes" rows="3" style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px;" placeholder="<?php esc_attr_e( 'Briefly explain your reasons for booking (optional)...', 'developer-starter-pro' ); ?>"></textarea>
							</div>
						</div>
					</div>

					<!-- Error Feedback Banner -->
					<div id="booking-error-banner" style="display:none; background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:8px; padding:16px; margin-top:24px; font-weight:500;"></div>

					<!-- Wizard Buttons -->
					<div class="booking-wizard-actions" style="display:flex; justify-content:space-between; margin-top:40px; padding-top:24px; border-top:1px solid var(--developer-starter-pro-gray-200);">
						<button type="button" id="prev-step" class="developer-starter-pro-btn developer-starter-pro-btn--outline" style="visibility:hidden;">
							<?php esc_html_e( 'Back', 'developer-starter-pro' ); ?>
						</button>
						<button type="button" id="next-step" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
							<?php esc_html_e( 'Continue', 'developer-starter-pro' ); ?>
						</button>
					</div>

				</form>

				<!-- Success Panel -->
				<div id="booking-success-panel" style="display:none; text-align:center; padding: 40px 0;">
					<span class="success-icon" style="font-size:4.5rem; display:block; margin-bottom:24px; animation: scaleUp 0.4s ease;">🎉</span>
					<h2 style="font-size:1.75rem; margin-top:0; margin-bottom:12px; color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Appointment Scheduled!', 'developer-starter-pro' ); ?></h2>
					<p id="success-message-text" style="color:var(--developer-starter-pro-gray-500); max-width:500px; margin:0 auto 30px; font-size:1.0625rem; line-height:1.6;"></p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
						<?php esc_html_e( 'Back to Home', 'developer-starter-pro' ); ?>
					</a>
				</div>

			</div>

		</div>
	</section>

</main>

<style>
/* Selection Cards */
.wizard-selection-card:hover {
	border-color: var(--developer-starter-pro-primary) !important;
	background: var(--developer-starter-pro-primary-light);
}
.wizard-selection-card.selected {
	border-color: var(--developer-starter-pro-primary) !important;
	background: var(--developer-starter-pro-primary-light);
	box-shadow: 0 4px 12px rgba(var(--developer-starter-pro-primary-rgb), 0.15);
}

/* Indicators */
.wizard-step-indicator.active .step-number {
	border-color: var(--developer-starter-pro-primary) !important;
	background: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
	box-shadow: 0 0 0 6px rgba(var(--developer-starter-pro-primary-rgb), 0.15);
}
.wizard-step-indicator.active .step-label {
	color: var(--developer-starter-pro-secondary) !important;
}
.wizard-step-indicator.completed .step-number {
	border-color: var(--developer-starter-pro-primary) !important;
	background: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
}
.wizard-step-indicator.completed .step-label {
	color: var(--developer-starter-pro-primary) !important;
}

/* Time slots selection buttons */
.time-slot-btn {
	background: #fff;
	border: 2px solid var(--developer-starter-pro-gray-200);
	padding: 10px;
	border-radius: 8px;
	font-weight: 600;
	cursor: pointer;
	text-align: center;
	transition: all 0.2s ease;
	font-size: 0.875rem;
}
.time-slot-btn:hover {
	border-color: var(--developer-starter-pro-primary);
	background: var(--developer-starter-pro-primary-light);
}
.time-slot-btn.selected {
	border-color: var(--developer-starter-pro-primary);
	background: var(--developer-starter-pro-primary);
	color: #fff;
}
.time-slot-btn.disabled {
	background: var(--developer-starter-pro-gray-100);
	border-color: var(--developer-starter-pro-gray-200);
	color: var(--developer-starter-pro-gray-300);
	cursor: not-allowed;
	pointer-events: none;
}

@keyframes scaleUp {
	0% { transform: scale(0.7); opacity:0; }
	100% { transform: scale(1); opacity:1; }
}

@media (max-width: 768px) {
	.wizard-schedule-split { grid-template-columns: 1fr; gap:24px; }
	.booking-wizard-card { padding: 24px !important; }
}
</style>

<?php
get_footer();
