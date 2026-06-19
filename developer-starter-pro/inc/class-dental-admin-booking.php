<?php
/**
 * Appointments Admin Dashboard Page - Clinic Administration System
 *
 * Adds a professional clinic-grade management dashboard to view, filter, edit,
 * approve, cancel, and reschedule patient bookings with real-time AJAX.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Admin_Booking {

	/**
	 * Settings page slug.
	 */
	private $page_slug = 'developer-starter-pro-appointments';

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Run DB create/update check on admin load.
		Developer_Starter_Pro_Booking::create_db_table();

		add_action( 'admin_menu', array( $this, 'add_appointments_submenu' ) );
		
		// AJAX routes
		add_action( 'wp_ajax_developer_starter_pro_get_appointments', array( $this, 'ajax_get_appointments' ) );
		add_action( 'wp_ajax_developer_starter_pro_save_appointment', array( $this, 'ajax_save_appointment' ) );
		add_action( 'wp_ajax_developer_starter_pro_bulk_action', array( $this, 'ajax_bulk_action' ) );
		add_action( 'wp_ajax_developer_starter_pro_update_appointment_status', array( $this, 'ajax_update_status' ) );
		add_action( 'wp_ajax_developer_starter_pro_toggle_approval_mode', array( $this, 'ajax_toggle_approval_mode' ) );
		
		// Export routes
		add_action( 'admin_post_developer_starter_pro_export_appointments_csv', array( $this, 'export_appointments_csv' ) );
		add_action( 'admin_post_developer_starter_pro_export_appointments_excel', array( $this, 'export_appointments_excel' ) );
	}

	/**
	 * Add appointments submenu under DentalPro settings.
	 */
	public function add_appointments_submenu() {
		add_submenu_page(
			'developer-starter-pro-settings',
			esc_html__( 'Appointments', 'developer-starter-pro' ),
			esc_html__( 'Appointments', 'developer-starter-pro' ),
			'manage_options',
			$this->page_slug,
			array( $this, 'render_dashboard_page' )
		);
	}

	/**
	 * Render Dashboard Page HTML.
	 */
	public function render_dashboard_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		// Fetch Doctors list for filter dropdown
		$doctors = get_posts( array(
			'post_type'      => 'doctors',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );

		// Fetch Services list for filter dropdown
		$services = get_posts( array(
			'post_type'      => 'services',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );

		$options = developer_starter_pro_get_all_options();
		$mode = isset( $options['appointment_approval_mode'] ) ? $options['appointment_approval_mode'] : 'automatic';
		$nonce = wp_create_nonce( 'developer_starter_pro_appointment_nonce' );
		?>
		<div class="wrap developer-starter-pro-admin-wrap clinic-admin-system">
			
			<!-- System Header -->
			<div class="clinic-admin-header">
				<div class="clinic-admin-header-title">
					<h1>
						<span class="logo-emoji">🏥</span>
						<?php esc_html_e( 'Clinic Administration Dashboard', 'developer-starter-pro' ); ?>
					</h1>
					<p class="subtitle"><?php esc_html_e( 'Real-time clinic scheduling, patient management, and billing control.', 'developer-starter-pro' ); ?></p>
				</div>
				<div class="clinic-admin-header-actions" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
					<div class="approval-mode-switch-wrapper" style="display: flex; align-items: center; gap: 6px; background: #f1f5f9; padding: 0 12px; border-radius: 6px; border: 1px solid #cbd5e1; height: 30px; box-sizing: border-box;">
						<span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; display: flex; align-items: center; gap: 4px;">⚙️ <?php esc_html_e( 'Approval:', 'developer-starter-pro' ); ?></span>
						<select id="header-approval-mode-select" style="border: none !important; background: transparent url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20400%20400%22%3E%3Cpath%20fill%3D%22%23475569%22%20d%3D%22M100%20150l100%20100%20100-100H100z%22%2F%3E%3C%2Fsvg%3E') no-repeat right 2px center !important; background-size: 10px 10px !important; padding: 0 16px 0 2px !important; margin: 0 !important; font-size: 0.75rem !important; font-weight: 700 !important; color: #1e293b !important; cursor: pointer !important; height: 100% !important; line-height: 1.2 !important; box-shadow: none !important; outline: none !important; vertical-align: middle !important; -webkit-appearance: none !important; -moz-appearance: none !important; appearance: none !important;">
							<option value="automatic" <?php selected( $mode, 'automatic' ); ?>><?php esc_html_e( 'Automatic (Instant)', 'developer-starter-pro' ); ?></option>
							<option value="manual" <?php selected( $mode, 'manual' ); ?>><?php esc_html_e( 'Manual Review', 'developer-starter-pro' ); ?></option>
						</select>
					</div>

					<button type="button" class="button button-primary create-appointment-btn">
						➕ <?php esc_html_e( 'Create Appointment', 'developer-starter-pro' ); ?>
					</button>
					<a href="#" id="export-csv-link" class="button button-secondary">
						📥 <?php esc_html_e( 'CSV', 'developer-starter-pro' ); ?>
					</a>
					<a href="#" id="export-excel-link" class="button button-secondary">
						📊 <?php esc_html_e( 'Excel', 'developer-starter-pro' ); ?>
					</a>
				</div>
			</div>

			<!-- Notice banner if manual mode is enabled -->
			<div class="notice notice-warning inline manual-mode-alert" style="<?php echo ( 'manual' === $mode ) ? '' : 'display:none;'; ?>">
				<p>
					⚠️ <strong><?php esc_html_e( 'Manual Approval Mode Active:', 'developer-starter-pro' ); ?></strong> 
					<?php esc_html_e( 'All online bookings will remain "Pending" until approved by an administrator.', 'developer-starter-pro' ); ?>
				</p>
			</div>

			<!-- Top Summary Statistics -->
			<div class="clinic-stats-grid">
				<div class="clinic-stat-card stat-today">
					<div class="stat-icon">📅</div>
					<div class="stat-details">
						<span class="stat-label"><?php esc_html_e( "Today's Appointments", 'developer-starter-pro' ); ?></span>
						<strong class="stat-value" id="stat-val-today">0</strong>
					</div>
				</div>
				<div class="clinic-stat-card stat-pending">
					<div class="stat-icon">⏳</div>
					<div class="stat-details">
						<span class="stat-label"><?php esc_html_e( "Pending Requests", 'developer-starter-pro' ); ?></span>
						<strong class="stat-value" id="stat-val-pending">0</strong>
					</div>
				</div>
				<div class="clinic-stat-card stat-confirmed">
					<div class="stat-icon">✅</div>
					<div class="stat-details">
						<span class="stat-label"><?php esc_html_e( "Confirmed slots", 'developer-starter-pro' ); ?></span>
						<strong class="stat-value" id="stat-val-confirmed">0</strong>
					</div>
				</div>
				<div class="clinic-stat-card stat-completed">
					<div class="stat-icon">🩺</div>
					<div class="stat-details">
						<span class="stat-label"><?php esc_html_e( "Completed visits", 'developer-starter-pro' ); ?></span>
						<strong class="stat-value" id="stat-val-completed">0</strong>
					</div>
				</div>
				<div class="clinic-stat-card stat-cancelled">
					<div class="stat-icon">❌</div>
					<div class="stat-details">
						<span class="stat-label"><?php esc_html_e( "Cancelled", 'developer-starter-pro' ); ?></span>
						<strong class="stat-value" id="stat-val-cancelled">0</strong>
					</div>
				</div>
				<div class="clinic-stat-card stat-revenue">
					<div class="stat-icon">💰</div>
					<div class="stat-details">
						<span class="stat-label"><?php esc_html_e( "Today's Est. Revenue", 'developer-starter-pro' ); ?></span>
						<strong class="stat-value" id="stat-val-revenue">$0</strong>
					</div>
				</div>
			</div>

			<!-- Dynamic Filtering Workspace -->
			<div class="clinic-filters-workspace">
				
				<!-- Status Tabs -->
				<div class="clinic-status-tabs-container">
					<div class="clinic-status-tabs" id="status-tabs-list">
						<button class="status-tab active" data-status=""><?php esc_html_e( 'All', 'developer-starter-pro' ); ?></button>
						<button class="status-tab" data-status="pending"><?php esc_html_e( 'Pending', 'developer-starter-pro' ); ?> <span class="badge badge-pending" id="tab-count-pending" style="display:none;">0</span></button>
						<button class="status-tab" data-status="confirmed"><?php esc_html_e( 'Confirmed', 'developer-starter-pro' ); ?></button>
						<button class="status-tab" data-status="rescheduled"><?php esc_html_e( 'Rescheduled', 'developer-starter-pro' ); ?></button>
						<button class="status-tab" data-status="completed"><?php esc_html_e( 'Completed', 'developer-starter-pro' ); ?></button>
						<button class="status-tab" data-status="cancelled"><?php esc_html_e( 'Cancelled', 'developer-starter-pro' ); ?></button>
						<button class="status-tab" data-status="no_show"><?php esc_html_e( 'No Show', 'developer-starter-pro' ); ?></button>
						<button class="status-tab" data-status="expired"><?php esc_html_e( 'Expired', 'developer-starter-pro' ); ?> <span class="badge badge-expired" id="tab-count-expired" style="display:none;">0</span></button>
					</div>
				</div>

				<!-- Advanced Dropdowns Row -->
				<div class="clinic-filter-controls">
					
					<!-- Search Box -->
					<div class="filter-col search-box">
						<label><?php esc_html_e( 'Search Patient / ID / Phone', 'developer-starter-pro' ); ?></label>
						<input type="text" id="filter-search" placeholder="<?php esc_attr_e( 'Type name, email, phone, or APT-...', 'developer-starter-pro' ); ?>">
					</div>

					<!-- Date Filters -->
					<div class="filter-col date-filter">
						<label><?php esc_html_e( 'Date Period', 'developer-starter-pro' ); ?></label>
						<select id="filter-date-period">
							<option value=""><?php esc_html_e( 'All Dates', 'developer-starter-pro' ); ?></option>
							<option value="today"><?php esc_html_e( 'Today', 'developer-starter-pro' ); ?></option>
							<option value="tomorrow"><?php esc_html_e( 'Tomorrow', 'developer-starter-pro' ); ?></option>
							<option value="this_week"><?php esc_html_e( 'This Week', 'developer-starter-pro' ); ?></option>
							<option value="this_month"><?php esc_html_e( 'This Month', 'developer-starter-pro' ); ?></option>
							<option value="custom"><?php esc_html_e( 'Custom Date Range', 'developer-starter-pro' ); ?></option>
						</select>
					</div>

					<!-- Custom Date Inputs -->
					<div class="filter-col custom-dates" id="custom-date-range-fields" style="display:none;">
						<label><?php esc_html_e( 'Start & End Date', 'developer-starter-pro' ); ?></label>
						<div style="display:flex; gap:5px;">
							<input type="date" id="filter-start-date" style="padding:4px; font-size:0.8rem; width:125px;">
							<input type="date" id="filter-end-date" style="padding:4px; font-size:0.8rem; width:125px;">
						</div>
					</div>

					<!-- Doctor Filter -->
					<div class="filter-col doctor-filter">
						<label><?php esc_html_e( 'Assigned Doctor', 'developer-starter-pro' ); ?></label>
						<select id="filter-doctor">
							<option value=""><?php esc_html_e( 'All Doctors', 'developer-starter-pro' ); ?></option>
							<?php foreach ( $doctors as $doc ) : ?>
								<option value="<?php echo esc_attr( $doc->ID ); ?>"><?php echo esc_html( $doc->post_title ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<!-- Service Filter -->
					<div class="filter-col service-filter">
						<label><?php esc_html_e( 'Service / Treatment', 'developer-starter-pro' ); ?></label>
						<select id="filter-service">
							<option value=""><?php esc_html_e( 'All Services', 'developer-starter-pro' ); ?></option>
							<?php foreach ( $services as $srv ) : ?>
								<option value="<?php echo esc_attr( $srv->ID ); ?>"><?php echo esc_html( $srv->post_title ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>


					<!-- Booking Source -->
					<div class="filter-col source-filter">
						<label><?php esc_html_e( 'Booking Source', 'developer-starter-pro' ); ?></label>
						<select id="filter-booking-source">
							<option value=""><?php esc_html_e( 'All Sources', 'developer-starter-pro' ); ?></option>
							<option value="website"><?php esc_html_e( 'Website', 'developer-starter-pro' ); ?></option>
							<option value="phone"><?php esc_html_e( 'Phone Call', 'developer-starter-pro' ); ?></option>
							<option value="whatsapp"><?php esc_html_e( 'WhatsApp', 'developer-starter-pro' ); ?></option>
							<option value="walk_in"><?php esc_html_e( 'Walk-In', 'developer-starter-pro' ); ?></option>
							<option value="admin"><?php esc_html_e( 'Admin Created', 'developer-starter-pro' ); ?></option>
						</select>
					</div>

					<!-- Appointment Type -->
					<div class="filter-col type-filter">
						<label><?php esc_html_e( 'Appointment Type', 'developer-starter-pro' ); ?></label>
						<select id="filter-appointment-type">
							<option value=""><?php esc_html_e( 'All Types', 'developer-starter-pro' ); ?></option>
							<option value="clinic_visit"><?php esc_html_e( 'Clinic Visit', 'developer-starter-pro' ); ?></option>
							<option value="video_consultation"><?php esc_html_e( 'Video Consultation', 'developer-starter-pro' ); ?></option>
							<option value="emergency"><?php esc_html_e( 'Emergency Visit', 'developer-starter-pro' ); ?></option>
						</select>
					</div>

				</div>
			</div>

			<!-- Bulk Actions & Selection Controls -->
			<div class="clinic-bulk-actions-panel" id="bulk-actions-panel" style="display:none;">
				<div class="bulk-inner">
					<span class="selection-count"><strong id="bulk-select-count">0</strong> <?php esc_html_e( 'appointments selected', 'developer-starter-pro' ); ?></span>
					<div class="bulk-controls">
						<select id="bulk-action-selector">
							<option value=""><?php esc_html_e( 'Choose Bulk Action...', 'developer-starter-pro' ); ?></option>
							<option value="confirm"><?php esc_html_e( 'Confirm Selected', 'developer-starter-pro' ); ?></option>
							<option value="complete"><?php esc_html_e( 'Complete Selected', 'developer-starter-pro' ); ?></option>
							<option value="cancel"><?php esc_html_e( 'Cancel Selected', 'developer-starter-pro' ); ?></option>
							<option value="reschedule"><?php esc_html_e( 'Reschedule Selected', 'developer-starter-pro' ); ?></option>
							<option value="send_sms"><?php esc_html_e( 'Send Bulk SMS', 'developer-starter-pro' ); ?></option>
							<option value="send_whatsapp"><?php esc_html_e( 'Send Bulk WhatsApp Message', 'developer-starter-pro' ); ?></option>
						</select>
						<button type="button" class="button button-secondary" id="apply-bulk-action"><?php esc_html_e( 'Apply', 'developer-starter-pro' ); ?></button>
					</div>
				</div>
			</div>

			<!-- Core Data Grid -->
			<div class="clinic-appointments-table-container">
				<table class="clinic-appointments-table widefat striped">
					<thead>
						<tr>
							<th class="col-check" style="width: 35px;"><input type="checkbox" id="select-all-bookings"></th>
							<th class="col-id"><?php esc_html_e( 'ID', 'developer-starter-pro' ); ?></th>
							<th class="col-patient"><?php esc_html_e( 'Patient Info', 'developer-starter-pro' ); ?></th>
							<th class="col-location"><?php esc_html_e( 'Location/Branch', 'developer-starter-pro' ); ?></th>
							<th class="col-doctor"><?php esc_html_e( 'Doctor', 'developer-starter-pro' ); ?></th>
							<th class="col-service"><?php esc_html_e( 'Service / Treatment', 'developer-starter-pro' ); ?></th>
							<th class="col-datetime"><?php esc_html_e( 'Date/Time', 'developer-starter-pro' ); ?></th>
							<th class="col-source"><?php esc_html_e( 'Source', 'developer-starter-pro' ); ?></th>
							<th class="col-type"><?php esc_html_e( 'Type', 'developer-starter-pro' ); ?></th>
							<th class="col-status"><?php esc_html_e( 'Status', 'developer-starter-pro' ); ?></th>
							<th class="col-actions text-right" style="text-align:right;"><?php esc_html_e( 'Actions', 'developer-starter-pro' ); ?></th>
						</tr>
					</thead>
					<tbody id="clinic-appointments-list">
						<!-- Loaded dynamically via AJAX -->
					</tbody>
				</table>
				
				<!-- Loading Overlay -->
				<div class="clinic-table-loading-overlay" id="table-loading-spinner" style="display:none;">
					<div class="spinner-spinner"></div>
				</div>
			</div>

			<!-- Pagination Controls -->
			<div class="clinic-pagination-wrapper" id="clinic-pagination-container">
				<!-- Loaded dynamically via AJAX -->
			</div>

			<!-- EDIT/CREATE MODAL POPUP -->
			<div class="clinic-modal-backdrop" id="appointment-modal" style="display:none;">
				<div class="clinic-modal-card">
					<div class="clinic-modal-header">
						<h2 id="modal-title-label"><?php esc_html_e( 'Edit Appointment Details', 'developer-starter-pro' ); ?></h2>
						<button type="button" class="close-modal-btn" id="close-modal">&times;</button>
					</div>
					<form id="appointment-editor-form">
						<input type="hidden" name="id" id="edit-id" value="">
						<div class="clinic-modal-body">
							<div class="modal-form-grid">
								<!-- Patient Name -->
								<div class="form-group">
									<label><?php esc_html_e( 'Patient Name', 'developer-starter-pro' ); ?> *</label>
									<input type="text" name="patient_name" id="edit-patient_name" required>
								</div>
								<!-- Patient Phone -->
								<div class="form-group">
									<label><?php esc_html_e( 'Patient Phone', 'developer-starter-pro' ); ?> *</label>
									<input type="tel" name="patient_phone" id="edit-patient_phone" required>
								</div>
								<!-- Patient Email -->
								<div class="form-group">
									<label><?php esc_html_e( 'Patient Email', 'developer-starter-pro' ); ?> *</label>
									<input type="email" name="patient_email" id="edit-patient_email" required>
								</div>
								<!-- Location ID -->
								<div class="form-group">
									<label><?php esc_html_e( 'Clinic Location/Branch', 'developer-starter-pro' ); ?></label>
									<select name="location_id" id="edit-location_id">
										<option value="0"><?php esc_html_e( '— General (No Location) —', 'developer-starter-pro' ); ?></option>
										<?php 
										$locations = get_posts( array(
											'post_type'      => 'locations',
											'posts_per_page' => -1,
											'post_status'    => 'publish',
										) );
										foreach ( $locations as $loc ) : ?>
											<option value="<?php echo esc_attr( $loc->ID ); ?>"><?php echo esc_html( $loc->post_title ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- Doctor ID -->
								<div class="form-group">
									<label><?php esc_html_e( 'Assigned Doctor', 'developer-starter-pro' ); ?> *</label>
									<select name="doctor_id" id="edit-doctor_id" required>
										<?php foreach ( $doctors as $doc ) : ?>
											<option value="<?php echo esc_attr( $doc->ID ); ?>"><?php echo esc_html( $doc->post_title ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- Service ID -->
								<div class="form-group">
									<label><?php esc_html_e( 'Treatment Service', 'developer-starter-pro' ); ?> *</label>
									<select name="service_id" id="edit-service_id" required>
										<?php foreach ( $services as $srv ) : ?>
											<option value="<?php echo esc_attr( $srv->ID ); ?>"><?php echo esc_html( $srv->post_title ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- Booking Date -->
								<div class="form-group">
									<label><?php esc_html_e( 'Appointment Date', 'developer-starter-pro' ); ?> *</label>
									<input type="date" name="booking_date" id="edit-booking_date" required min="<?php echo date('Y-m-d'); ?>">
								</div>
								<!-- Time Slot -->
								<div class="form-group">
									<label><?php esc_html_e( 'Time Slot', 'developer-starter-pro' ); ?> *</label>
									<select name="time_slot" id="edit-time_slot" required>
										<option value="09:00">09:00 AM</option>
										<option value="09:30">09:30 AM</option>
										<option value="10:00">10:00 AM</option>
										<option value="10:30">10:30 AM</option>
										<option value="11:00">11:00 AM</option>
										<option value="11:30">11:30 AM</option>
										<option value="12:00">12:00 PM</option>
										<option value="12:30">12:30 PM</option>
										<option value="13:00">01:00 PM</option>
										<option value="13:30">01:30 PM</option>
										<option value="14:00">02:00 PM</option>
										<option value="14:30">02:30 PM</option>
										<option value="15:00">03:00 PM</option>
										<option value="15:30">03:30 PM</option>
										<option value="16:00">04:00 PM</option>
										<option value="16:30">04:30 PM</option>
									</select>
								</div>
								<!-- Appointment Status -->
								<div class="form-group">
									<label><?php esc_html_e( 'Appointment Status', 'developer-starter-pro' ); ?></label>
									<select name="status" id="edit-status">
										<option value="pending"><?php esc_html_e( 'Pending', 'developer-starter-pro' ); ?></option>
										<option value="confirmed"><?php esc_html_e( 'Confirmed', 'developer-starter-pro' ); ?></option>
										<option value="rescheduled"><?php esc_html_e( 'Rescheduled', 'developer-starter-pro' ); ?></option>
										<option value="completed"><?php esc_html_e( 'Completed', 'developer-starter-pro' ); ?></option>
										<option value="cancelled"><?php esc_html_e( 'Cancelled', 'developer-starter-pro' ); ?></option>
										<option value="no_show"><?php esc_html_e( 'No Show', 'developer-starter-pro' ); ?></option>
									</select>
								</div>

								<!-- Booking Source -->
								<div class="form-group">
									<label><?php esc_html_e( 'Booking Source', 'developer-starter-pro' ); ?></label>
									<select name="booking_source" id="edit-booking_source">
										<option value="website"><?php esc_html_e( 'Website', 'developer-starter-pro' ); ?></option>
										<option value="phone"><?php esc_html_e( 'Phone Call', 'developer-starter-pro' ); ?></option>
										<option value="whatsapp"><?php esc_html_e( 'WhatsApp', 'developer-starter-pro' ); ?></option>
										<option value="walk_in"><?php esc_html_e( 'Walk-In', 'developer-starter-pro' ); ?></option>
										<option value="admin"><?php esc_html_e( 'Admin Created', 'developer-starter-pro' ); ?></option>
									</select>
								</div>
								<!-- Appointment Type -->
								<div class="form-group col-span-2">
									<label><?php esc_html_e( 'Appointment Type', 'developer-starter-pro' ); ?></label>
									<select name="appointment_type" id="edit-appointment_type" style="width:100%;">
										<option value="clinic_visit"><?php esc_html_e( 'Clinic Visit', 'developer-starter-pro' ); ?></option>
										<option value="video_consultation"><?php esc_html_e( 'Video Consultation', 'developer-starter-pro' ); ?></option>
										<option value="emergency"><?php esc_html_e( 'Emergency Visit', 'developer-starter-pro' ); ?></option>
									</select>
								</div>
								<!-- Notes -->
								<div class="form-group col-span-2">
									<label><?php esc_html_e( 'Patient Symptom / Medical Notes', 'developer-starter-pro' ); ?></label>
									<textarea name="notes" id="edit-notes" rows="2" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:8px;"></textarea>
								</div>
								<!-- Internal Notes -->
								<div class="form-group col-span-2">
									<label><?php esc_html_e( 'Internal Admin Notes / Clinical Observations', 'developer-starter-pro' ); ?></label>
									<textarea name="internal_notes" id="edit-internal_notes" rows="3" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:8px;" placeholder="<?php esc_attr_e( 'Add clinical notes, payments details, billing logs, etc.', 'developer-starter-pro' ); ?>"></textarea>
								</div>
							</div>
						</div>
						<div class="clinic-modal-footer">
							<button type="submit" class="button button-primary" id="save-modal-btn"><?php esc_html_e( 'Save Changes', 'developer-starter-pro' ); ?></button>
							<button type="button" class="button" id="cancel-modal"><?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?></button>
						</div>
					</form>
				</div>
			</div>

			<!-- BULK RESCHEDULE MODAL -->
			<div class="clinic-modal-backdrop" id="bulk-reschedule-modal" style="display:none;">
				<div class="clinic-modal-card" style="max-width: 450px;">
					<div class="clinic-modal-header">
						<h2><?php esc_html_e( 'Bulk Reschedule Selected', 'developer-starter-pro' ); ?></h2>
						<button type="button" class="close-modal-btn" id="close-bulk-reschedule">&times;</button>
					</div>
					<div class="clinic-modal-body">
						<div class="form-group" style="margin-bottom:15px;">
							<label><?php esc_html_e( 'New Appointment Date', 'developer-starter-pro' ); ?></label>
							<input type="date" id="bulk-new-date" min="<?php echo date('Y-m-d'); ?>" style="width:100%;">
						</div>
						<div class="form-group">
							<label><?php esc_html_e( 'New Time Slot', 'developer-starter-pro' ); ?></label>
							<select id="bulk-new-time" style="width:100%;">
								<option value="09:00">09:00 AM</option>
								<option value="09:30">09:30 AM</option>
								<option value="10:00">10:00 AM</option>
								<option value="10:30">10:30 AM</option>
								<option value="11:00">11:00 AM</option>
								<option value="11:30">11:30 AM</option>
								<option value="12:00">12:00 PM</option>
								<option value="12:30">12:30 PM</option>
								<option value="13:00">01:00 PM</option>
								<option value="13:30">01:30 PM</option>
								<option value="14:00">02:00 PM</option>
								<option value="14:30">02:30 PM</option>
								<option value="15:00">03:00 PM</option>
								<option value="15:30">03:30 PM</option>
								<option value="16:00">04:00 PM</option>
								<option value="16:30">04:30 PM</option>
							</select>
						</div>
					</div>
					<div class="clinic-modal-footer">
						<button type="button" class="button button-primary" id="save-bulk-reschedule"><?php esc_html_e( 'Confirm Reschedule', 'developer-starter-pro' ); ?></button>
						<button type="button" class="button" id="cancel-bulk-reschedule"><?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?></button>
					</div>
				</div>
			</div>

			<!-- BULK MESSAGE MODAL -->
			<div class="clinic-modal-backdrop" id="bulk-message-modal" style="display:none;">
				<div class="clinic-modal-card" style="max-width: 500px;">
					<div class="clinic-modal-header">
						<h2 id="bulk-message-title"><?php esc_html_e( 'Send Bulk Message', 'developer-starter-pro' ); ?></h2>
						<button type="button" class="close-modal-btn" id="close-bulk-message">&times;</button>
					</div>
					<div class="clinic-modal-body">
						<div class="form-group">
							<label><?php esc_html_e( 'Custom Message Content', 'developer-starter-pro' ); ?></label>
							<textarea id="bulk-message-text" rows="5" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:8px;" placeholder="<?php esc_attr_e( 'Type your custom notifications payload here. Merge tags are supported.', 'developer-starter-pro' ); ?>"></textarea>
							<p class="description" style="margin-top:6px; font-size:0.75rem;">
								<?php esc_html_e( 'Available tags: {patient_name}, {appointment_date}, {appointment_time}, {clinic_name}', 'developer-starter-pro' ); ?>
							</p>
						</div>
					</div>
					<div class="clinic-modal-footer">
						<button type="button" class="button button-primary" id="send-bulk-message-btn"><?php esc_html_e( 'Send Notifications', 'developer-starter-pro' ); ?></button>
						<button type="button" class="button" id="cancel-bulk-message"><?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?></button>
					</div>
				</div>
			</div>

		</div>

		<!-- CLIENT JS SPA CONTROLLER -->
		<script>
		jQuery(document).ready(function($) {
			
			var currentFilters = {
				status: '',
				search: '',
				date_filter: '',
				start_date: '',
				end_date: '',
				doctor_id: '',
				service_id: '',
				booking_source: '',
				appointment_type: '',
				paged: 1
			};

			var selectedIDs = [];

			function openModal(id) {
				$(id).show();
				$('html, body').addClass('clinic-modal-open');
			}
			function closeModal(id) {
				$(id).hide();
				if ($('.clinic-modal-backdrop:visible').length === 0) {
					$('html, body').removeClass('clinic-modal-open');
				}
			}

			// Initial Load
			fetchAppointments();

			// AJAX query fetcher
			function fetchAppointments() {
				$('#table-loading-spinner').show();
				
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'developer_starter_pro_get_appointments',
						nonce: '<?php echo esc_js( $nonce ); ?>',
						filters: currentFilters
					},
					success: function(response) {
						if (response.success) {
							// Update Summary Cards
							$('#stat-val-today').text(response.data.stats.today);
							$('#stat-val-pending').text(response.data.stats.pending);
							$('#stat-val-confirmed').text(response.data.stats.confirmed);
							$('#stat-val-completed').text(response.data.stats.completed);
							$('#stat-val-cancelled').text(response.data.stats.cancelled);
							$('#stat-val-revenue').text(response.data.stats.revenue);

							// Update Pending Tab Counter badge
							if (parseInt(response.data.stats.pending, 10) > 0) {
								$('#tab-count-pending').text(response.data.stats.pending).show();
							} else {
								$('#tab-count-pending').hide();
							}

							// Update Expired Tab Counter badge
							if (response.data.stats.expired && parseInt(response.data.stats.expired, 10) > 0) {
								$('#tab-count-expired').text(response.data.stats.expired).show();
							} else {
								$('#tab-count-expired').hide();
							}

							// Update Table List & Pagination
							$('#clinic-appointments-list').html(response.data.table_html);
							$('#clinic-pagination-container').html(response.data.pagination_html);
							
							// Reset bulk checkbox selections
							selectedIDs = [];
							$('#select-all-bookings').prop('checked', false);
							updateBulkPanel();

							// Update dynamic CSV/Excel link hrefs with current filters
							var filterQuery = $.param({
								action: 'developer_starter_pro_export_appointments_csv',
								search: currentFilters.search,
								status: currentFilters.status,
								date_filter: currentFilters.date_filter,
								start_date: currentFilters.start_date,
								end_date: currentFilters.end_date,
								doctor_id: currentFilters.doctor_id,
								service_id: currentFilters.service_id,
								booking_source: currentFilters.booking_source,
								appointment_type: currentFilters.appointment_type
							});
							$('#export-csv-link').attr('href', admin_url_link(filterQuery));

							var filterQueryExcel = filterQuery.replace('developer_starter_pro_export_appointments_csv', 'developer_starter_pro_export_appointments_excel');
							$('#export-excel-link').attr('href', admin_url_link(filterQueryExcel));
						} else {
							console.error('Failed to fetch data');
						}
						$('#table-loading-spinner').hide();
					},
					error: function() {
						$('#table-loading-spinner').hide();
						console.error('AJAX communication error');
					}
				});
			}

			function admin_url_link(query) {
				return ajaxurl.replace('admin-ajax.php', 'admin-post.php') + '?' + query;
			}

			// Debounce Search
			var searchTimeout;
			$('#filter-search').on('input', function() {
				clearTimeout(searchTimeout);
				var val = $(this).val();
				searchTimeout = setTimeout(function() {
					currentFilters.search = val;
					currentFilters.paged = 1;
					fetchAppointments();
				}, 400);
			});

			// Status Tab Filter clicks
			$(document).on('click', '.status-tab', function() {
				$('.status-tab').removeClass('active');
				$(this).addClass('active');
				currentFilters.status = $(this).data('status');
				currentFilters.paged = 1;
				fetchAppointments();
			});

			// Dropdown Filters
			$('#filter-date-period').on('change', function() {
				var val = $(this).val();
				currentFilters.date_filter = val;
				currentFilters.paged = 1;
				if ('custom' === val) {
					$('#custom-date-range-fields').show();
				} else {
					$('#custom-date-range-fields').hide();
					currentFilters.start_date = '';
					currentFilters.end_date = '';
					$('#filter-start-date').val('');
					$('#filter-end-date').val('');
					fetchAppointments();
				}
			});

			$('#filter-start-date').on('change', function() {
				currentFilters.start_date = $(this).val();
				currentFilters.paged = 1;
				fetchAppointments();
			});

			$('#filter-end-date').on('change', function() {
				currentFilters.end_date = $(this).val();
				currentFilters.paged = 1;
				fetchAppointments();
			});

			$('#filter-doctor').on('change', function() {
				currentFilters.doctor_id = $(this).val();
				currentFilters.paged = 1;
				fetchAppointments();
			});

			$('#filter-service').on('change', function() {
				currentFilters.service_id = $(this).val();
				currentFilters.paged = 1;
				fetchAppointments();
			});


			$('#filter-booking-source').on('change', function() {
				currentFilters.booking_source = $(this).val();
				currentFilters.paged = 1;
				fetchAppointments();
			});

			$('#filter-appointment-type').on('change', function() {
				currentFilters.appointment_type = $(this).val();
				currentFilters.paged = 1;
				fetchAppointments();
			});

			// Pagination clicks
			$(document).on('click', '#clinic-pagination-container a', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var pageMatches = url.match(/[?&]paged=(\d+)/);
				if (pageMatches) {
					currentFilters.paged = parseInt(pageMatches[1], 10);
					fetchAppointments();
				}
			});

			// Selection Checkboxes Handlers
			$(document).on('change', '#select-all-bookings', function() {
				var checked = $(this).prop('checked');
				$('.booking-checkbox').prop('checked', checked);
				selectedIDs = [];
				if (checked) {
					$('.booking-checkbox').each(function() {
						selectedIDs.push($(this).val());
					});
				}
				updateBulkPanel();
			});

			$(document).on('change', '.booking-checkbox', function() {
				var id = $(this).val();
				if ($(this).prop('checked')) {
					if (selectedIDs.indexOf(id) === -1) {
						selectedIDs.push(id);
					}
				} else {
					var index = selectedIDs.indexOf(id);
					if (index !== -1) {
						selectedIDs.splice(index, 1);
					}
				}
				updateBulkPanel();
			});

			function updateBulkPanel() {
				if (selectedIDs.length > 0) {
					$('#bulk-select-count').text(selectedIDs.length);
					$('#bulk-actions-panel').slideDown(150);
				} else {
					$('#bulk-actions-panel').slideUp(150);
				}
			}

			// Apply Bulk Action click
			$('#apply-bulk-action').on('click', function() {
				var actionType = $('#bulk-action-selector').val();
				if (!actionType) {
					alert('Please choose a bulk action.');
					return;
				}

				if (selectedIDs.length === 0) {
					alert('Please select at least one appointment.');
					return;
				}

				if ('reschedule' === actionType) {
					openModal('#bulk-reschedule-modal');
					return;
				}

				if ('send_sms' === actionType || 'send_whatsapp' === actionType) {
					var serviceName = 'send_sms' === actionType ? 'SMS' : 'WhatsApp';
					$('#bulk-message-title').text('Send Bulk ' + serviceName);
					$('#bulk-message-text').val("Hello {patient_name}, this is a message from {clinic_name} regarding your appointment on {appointment_date} at {appointment_time}.");
					openModal('#bulk-message-modal');
					return;
				}

				if (confirm('Are you sure you want to perform this bulk update on ' + selectedIDs.length + ' appointments?')) {
					executeBulkAction(actionType, {});
				}
			});

			function executeBulkAction(actionType, extraData) {
				$('#table-loading-spinner').show();
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'developer_starter_pro_bulk_action',
						nonce: '<?php echo esc_js( $nonce ); ?>',
						action_type: actionType,
						ids: selectedIDs,
						extra: extraData
					},
					success: function(response) {
						if (response.success) {
							fetchAppointments();
						} else {
							alert(response.data.message || 'Error executing bulk action.');
							$('#table-loading-spinner').hide();
						}
					},
					error: function() {
						alert('Server request failed.');
						$('#table-loading-spinner').hide();
					}
				});
			}

			// Bulk Reschedule Confirm Save
			$('#save-bulk-reschedule').on('click', function() {
				var date = $('#bulk-new-date').val();
				var time = $('#bulk-new-time').val();
				if (!date || !time) {
					alert('Please select a valid date and time.');
					return;
				}
				executeBulkAction('reschedule', { date: date, time: time });
				closeModal('#bulk-reschedule-modal');
			});

			$('#cancel-bulk-reschedule, #close-bulk-reschedule').on('click', function() {
				closeModal('#bulk-reschedule-modal');
			});

			// Bulk Notification Sender Confirm Save
			$('#send-bulk-message-btn').on('click', function() {
				var text = $('#bulk-message-text').val();
				var actionType = $('#bulk-action-selector').val();
				if (!text) {
					alert('Message content cannot be empty.');
					return;
				}
				executeBulkAction(actionType, { message: text });
				closeModal('#bulk-message-modal');
			});

			$('#cancel-bulk-message, #close-bulk-message').on('click', function() {
				closeModal('#bulk-message-modal');
			});

			// OPEN CREATE APPOINTMENT MODAL
			$('.create-appointment-btn').on('click', function() {
				$('#appointment-editor-form')[0].reset();
				$('#edit-id').val('');
				$('#modal-title-label').text('Create Appointment Record');
				$('#edit-location_id').val('0');
				$('#edit-status').val('pending');
				$('#edit-booking_source').val('admin');
				$('#edit-appointment_type').val('clinic_visit');
				openModal('#appointment-modal');
			});

			// OPEN EDIT MODAL BY DYNAMIC ROW CLICK
			$(document).on('click', '.edit-booking-btn', function() {
				var data = $(this).data();
				$('#modal-title-label').text('Edit Appointment (APT-' + padZero(data.id) + ')');
				$('#edit-id').val(data.id);
				$('#edit-patient_name').val(data.patient_name);
				$('#edit-patient_phone').val(data.patient_phone);
				$('#edit-patient_email').val(data.patient_email);
				$('#edit-location_id').val(data.location_id || '0');
				$('#edit-doctor_id').val(data.doctor_id);
				$('#edit-service_id').val(data.service_id);
				$('#edit-booking_date').val(data.booking_date);
				$('#edit-time_slot').val(data.time_slot);
				$('#edit-status').val(data.status);
				$('#edit-booking_source').val(data.booking_source);
				$('#edit-appointment_type').val(data.appointment_type);
				$('#edit-notes').val(data.notes);
				$('#edit-internal_notes').val(data.internal_notes);
				openModal('#appointment-modal');
			});

			function padZero(num) {
				return ('00000' + num).slice(-5);
			}

			// Save Form (Create or Edit)
			$('#appointment-editor-form').on('submit', function(e) {
				e.preventDefault();
				
				var formData = $(this).serializeArray();
				$('#save-modal-btn').prop('disabled', true).text('Saving...');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'developer_starter_pro_save_appointment',
						nonce: '<?php echo esc_js( $nonce ); ?>',
						form_data: formData
					},
					success: function(response) {
						if (response.success) {
							closeModal('#appointment-modal');
							fetchAppointments();
						} else {
							alert(response.data.message || 'Error occurred while saving.');
						}
						$('#save-modal-btn').prop('disabled', false).text('Save Changes');
					},
					error: function() {
						alert('Server request failed.');
						$('#save-modal-btn').prop('disabled', false).text('Save Changes');
					}
				});
			});

			// CLOSE EDIT MODAL
			$('#cancel-modal, #close-modal').on('click', function() {
				closeModal('#appointment-modal');
			});

			// Inline quick action buttons click
			$(document).on('click', '.list-action-btn', function() {
				var $btn = $(this);
				var id = $btn.data('id');
				var status = $btn.data('status');
				
				if ('cancelled' === status && !confirm('Are you sure you want to cancel this appointment?')) {
					return;
				}

				$btn.prop('disabled', true);

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'developer_starter_pro_update_appointment_status',
						nonce: '<?php echo esc_js( $nonce ); ?>',
						id: id,
						status: status
					},
					success: function(response) {
						if (response.success) {
							fetchAppointments();
						} else {
							alert(response.data.message || 'Error occurred.');
							$btn.prop('disabled', false);
						}
					},
					error: function() {
						alert('Server request failed.');
						$btn.prop('disabled', false);
					}
				});
			});

			// Change Approval Mode
			$('#header-approval-mode-select').on('change', function() {
				var mode = $(this).val();
				var $alert = $('.manual-mode-alert');
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'developer_starter_pro_toggle_approval_mode',
						nonce: '<?php echo esc_js( $nonce ); ?>',
						mode: mode
					},
					success: function(response) {
						if (response.success) {
							if (mode === 'manual') {
								$alert.slideDown(150);
							} else {
								$alert.slideUp(150);
							}
						} else {
							alert(response.data.message || 'Error updating approval mode.');
						}
					},
					error: function() {
						alert('Server request failed.');
					}
				});
			});

		});
		</script>

		<!-- MODERN STYLING SYSTEM -->
		<style>
		.clinic-admin-system {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
			color: #1e293b;
			padding-right: 20px;
		}

		/* Header Section */
		.clinic-admin-header {
			background: #ffffff;
			padding: 24px;
			border-radius: 12px;
			border: 1px solid #e2e8f0;
			box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 24px;
			flex-wrap: wrap;
			gap: 15px;
		}
		.clinic-admin-header h1 {
			margin: 0;
			font-size: 1.6rem;
			font-weight: 800;
			color: #0f172a;
			display: flex;
			align-items: center;
			gap: 10px;
		}
		.clinic-admin-header .logo-emoji {
			font-size: 2rem;
		}
		.clinic-admin-header .subtitle {
			margin: 4px 0 0 0;
			color: #64748b;
			font-size: 0.9rem;
		}
		.clinic-admin-header-actions {
			display: flex;
			gap: 8px;
		}

		.manual-mode-alert {
			margin: 0 0 24px 0 !important;
			border-left-color: #f59e0b !important;
			background: #fffbeb !important;
			padding: 10px 20px !important;
			border-radius: 8px;
		}

		/* Summary Statistics Grid */
		.clinic-stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
			gap: 16px;
			margin-bottom: 24px;
		}
		.clinic-stat-card {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 12px;
			padding: 20px;
			display: flex;
			align-items: center;
			gap: 16px;
			box-shadow: 0 1px 3px rgba(0,0,0,0.02);
		}
		.clinic-stat-card .stat-icon {
			font-size: 1.8rem;
			width: 48px;
			height: 48px;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.clinic-stat-card .stat-details {
			display: flex;
			flex-direction: column;
		}
		.clinic-stat-card .stat-label {
			font-size: 0.75rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			color: #64748b;
			font-weight: 600;
		}
		.clinic-stat-card .stat-value {
			font-size: 1.4rem;
			font-weight: 800;
			color: #0f172a;
			margin-top: 2px;
		}
		
		/* Stat Colors */
		.stat-today .stat-icon { background: #f0fdf4; color: #15803d; }
		.stat-pending .stat-icon { background: #fffbeb; color: #b45309; }
		.stat-confirmed .stat-icon { background: #ecfeff; color: #0891b2; }
		.stat-completed .stat-icon { background: #e0e7ff; color: #4338ca; }
		.stat-cancelled .stat-icon { background: #faf5ff; color: #701a75; }
		.stat-revenue .stat-icon { background: #fef2f2; color: #b91c1c; }

		/* Filters workspace card */
		.clinic-filters-workspace {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 12px;
			box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
			margin-bottom: 24px;
			overflow: hidden;
		}
		
		/* Status Filter Tabs */
		.clinic-status-tabs-container {
			border-bottom: 1px solid #e2e8f0;
			background: #f8fafc;
			padding: 0 10px;
		}
		.clinic-status-tabs {
			display: flex;
			overflow-x: auto;
			gap: 5px;
		}
		.status-tab {
			background: none;
			border: none;
			border-bottom: 3px solid transparent;
			padding: 14px 18px;
			font-weight: 600;
			font-size: 0.9rem;
			color: #64748b;
			cursor: pointer;
			white-space: nowrap;
			display: flex;
			align-items: center;
			gap: 6px;
			transition: all 0.2s ease;
		}
		.status-tab:hover {
			color: #0f172a;
		}
		.status-tab.active {
			color: #0d9488;
			border-bottom-color: #0d9488;
		}
		.status-tab .badge {
			font-size: 0.7rem;
			font-weight: 700;
			padding: 1px 6px;
			border-radius: 10px;
			background: #cbd5e1;
			color: #1e293b;
		}
		.status-tab .badge.badge-pending {
			background: #f59e0b;
			color: #ffffff;
		}
		.status-tab .badge.badge-expired {
			background: #ef4444;
			color: #ffffff;
		}

		/* Advanced dropdown controls row */
		.clinic-filter-controls {
			padding: 20px;
			display: flex;
			flex-wrap: wrap;
			gap: 15px;
			background: #ffffff;
		}
		.filter-col {
			display: flex;
			flex-direction: column;
			flex: 1 1 160px;
		}
		.filter-col label {
			font-size: 0.75rem;
			font-weight: 700;
			color: #64748b;
			margin-bottom: 6px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.filter-col select,
		.filter-col input {
			padding: 8px 12px;
			border: 1px solid #cbd5e1;
			border-radius: 6px;
			font-size: 0.85rem;
			color: #1e293b;
			background-color: #ffffff;
			height: 38px;
			box-sizing: border-box;
			line-height: 1.4;
		}
		.filter-col select {
			padding: 6px 12px;
		}
		.filter-col select:focus,
		.filter-col input:focus {
			border-color: #0d9488;
			outline: none;
			box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.15);
		}
		.filter-col.search-box {
			flex: 2 1 240px;
		}

		/* Bulk Actions Panel */
		.clinic-bulk-actions-panel {
			background: #0f172a;
			color: #ffffff;
			padding: 14px 20px;
			border-radius: 8px;
			margin-bottom: 16px;
			box-shadow: 0 4px 10px rgba(0,0,0,0.15);
		}
		.bulk-inner {
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
			gap: 10px;
		}
		.bulk-inner .selection-count {
			font-size: 0.9rem;
			color: #94a3b8;
		}
		.bulk-inner .selection-count strong {
			color: #ffffff;
		}
		.bulk-controls {
			display: flex;
			gap: 8px;
		}
		.bulk-controls select {
			padding: 4px 12px !important;
			background: #1e293b !important;
			border: 1px solid #334155 !important;
			color: #ffffff !important;
			border-radius: 6px !important;
			font-size: 0.85rem !important;
			height: 32px !important;
			box-sizing: border-box !important;
		}
		.bulk-controls select:focus {
			outline: none;
			border-color: #0d9488;
		}
		.bulk-controls select option {
			background: #1e293b;
			color: #ffffff;
		}
		.bulk-controls .button {
			background: #0d9488 !important;
			border-color: #0d9488 !important;
			color: #ffffff !important;
			height: 32px !important;
			line-height: 30px !important;
			padding: 0 16px !important;
			font-weight: 600 !important;
			border-radius: 6px !important;
			box-shadow: none !important;
			text-shadow: none !important;
			transition: background 0.2s ease !important;
		}
		.bulk-controls .button:hover {
			background: #0f766e !important;
			border-color: #0f766e !important;
			color: #ffffff !important;
		}

		/* Appointments Table Container */
		.clinic-appointments-table-container {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 12px;
			overflow-x: auto;
			box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
			position: relative;
			margin-bottom: 20px;
		}
		.clinic-appointments-table {
			margin: 0 !important;
			border: none !important;
			border-collapse: collapse;
			width: 100%;
			min-width: 1200px;
		}
		.clinic-appointments-table th {
			background: #f8fafc !important;
			border-bottom: 2px solid #e2e8f0 !important;
			padding: 12px 10px !important;
			font-weight: 700 !important;
			color: #475569 !important;
			font-size: 0.8rem !important;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.clinic-appointments-table td {
			padding: 10px 8px !important;
			vertical-align: middle !important;
			font-size: 0.825rem !important;
			border-bottom: 1px solid #f1f5f9 !important;
		}

		/* Prevent vertical wrapping on metadata columns */
		.col-id,
		.col-doctor,
		.col-datetime,
		.col-source,
		.col-type,
		.col-status,
		.col-actions {
			white-space: nowrap;
		}

		/* Status Badges */
		.clinic-badge {
			display: inline-block;
			padding: 4px 10px;
			border-radius: 100px;
			font-size: 0.725rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.3px;
			white-space: nowrap;
		}
		
		/* Status Badges Style */
		.clinic-badge.status-pending { background: #fffbeb; color: #b45309; }
		.clinic-badge.status-confirmed { background: #d1fae5; color: #065f46; }
		.clinic-badge.status-approved { background: #d1fae5; color: #065f46; }
		.clinic-badge.status-rescheduled { background: #e0f2fe; color: #0369a1; }
		.clinic-badge.status-completed { background: #e0e7ff; color: #4338ca; }
		.clinic-badge.status-cancelled { background: #f1f5f9; color: #475569; }
		.clinic-badge.status-rejected { background: #fee2e2; color: #991b1b; }
		.clinic-badge.status-no_show { background: #fdf2f8; color: #9d174d; }
		.clinic-badge.status-expired { background: #fee2e2; color: #b91c1c; }

		/* Booking Source & Appt Type Badges */
		.clinic-badge.source-website { background: #f0fdfa; color: #0f766e; }
		.clinic-badge.source-phone { background: #f0fdf4; color: #166534; }
		.clinic-badge.source-whatsapp { background: #ecfdf5; color: #047857; }
		.clinic-badge.source-walk_in { background: #fff7ed; color: #9a3412; }
		.clinic-badge.source-admin { background: #faf5ff; color: #6b21a8; }

		.clinic-badge.type-clinic_visit { background: #f8fafc; color: #334155; border: 1px solid #cbd5e1; }
		.clinic-badge.type-video_consultation { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
		.clinic-badge.type-emergency { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }

		/* Table rows styling */
		.patient-cell strong {
			color: #0f172a;
			display: block;
			font-size: 0.95rem;
		}
		.patient-cell .contact-span {
			color: #64748b;
			font-size: 0.8rem;
			display: block;
			margin-top: 3px;
		}
		.patient-cell .notes-span {
			font-size: 0.8rem;
			color: #94a3b8;
			font-style: italic;
			display: block;
			margin-top: 6px;
		}
		.patient-cell .internal-notes-span {
			font-size: 0.8rem;
			color: #0d9488;
			font-weight: 500;
			display: block;
			margin-top: 4px;
		}

		/* Row Action Buttons */
		.action-buttons-cell {
			display: flex;
			flex-direction: column;
			gap: 4px;
			width: 85px;
			margin-left: auto;
		}
		.action-buttons-cell .button {
			padding: 4px 8px !important;
			height: 28px !important;
			line-height: 18px !important;
			font-size: 0.75rem !important;
			font-weight: 600 !important;
			text-align: center !important;
			display: block !important;
			width: 100% !important;
			box-sizing: border-box !important;
		}

		/* Table Spinner Loading Overlay */
		.clinic-table-loading-overlay {
			position: absolute;
			top: 0; left: 0; right: 0; bottom: 0;
			background: rgba(255,255,255,0.7);
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 10;
		}
		.spinner-spinner {
			width: 40px;
			height: 40px;
			border: 4px solid #cbd5e1;
			border-top-color: #0d9488;
			border-radius: 50%;
			animation: spin-spin 0.8s linear infinite;
		}
		@keyframes spin-spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}

		/* Pagination Wrapper */
		.clinic-pagination-wrapper {
			margin-top: 15px;
			display: flex;
			justify-content: center;
		}

		/* BACKDROP & MODAL DIALOGS */
		.clinic-modal-backdrop {
			position: fixed;
			top: 0; left: 0; right: 0; bottom: 0;
			background: rgba(15, 23, 42, 0.6);
			backdrop-filter: blur(4px);
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 99999;
			animation: fadeIn 0.15s ease-out;
		}
		html.clinic-modal-open,
		body.clinic-modal-open {
			overflow: hidden !important;
			height: 100% !important;
		}
		#appointment-editor-form {
			display: flex;
			flex-direction: column;
			overflow: hidden;
			flex-grow: 1;
		}
		.clinic-modal-card {
			background: #ffffff;
			border-radius: 16px;
			width: 100%;
			max-width: 650px;
			box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
			overflow: hidden;
			display: flex;
			flex-direction: column;
			max-height: 90vh;
			animation: scaleUpModal 0.2s cubic-bezier(0.16, 1, 0.3, 1);
		}
		.clinic-modal-header {
			padding: 20px 24px;
			border-bottom: 1px solid #e2e8f0;
			display: flex;
			justify-content: space-between;
			align-items: center;
			background: #f8fafc;
		}
		.clinic-modal-header h2 {
			margin: 0;
			font-size: 1.25rem;
			font-weight: 800;
			color: #0f172a;
		}
		.close-modal-btn {
			background: none;
			border: none;
			font-size: 1.7rem;
			color: #64748b;
			cursor: pointer;
			padding: 0;
			line-height: 1;
		}
		.close-modal-btn:hover {
			color: #0f172a;
		}
		.clinic-modal-body {
			padding: 24px;
			overflow-y: auto;
			flex-grow: 1;
		}
		.clinic-modal-footer {
			padding: 16px 24px;
			border-top: 2px solid #e2e8f0;
			display: flex;
			justify-content: flex-end;
			gap: 10px;
			background: #f8fafc;
			flex-shrink: 0;
			position: sticky;
			bottom: 0;
			z-index: 10;
			box-shadow: 0 -4px 12px rgba(0,0,0,0.06);
		}
		
		/* Modal Form Grid */
		.modal-form-grid {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 16px;
		}
		.form-group {
			display: flex;
			flex-direction: column;
		}
		.form-group label {
			font-size: 0.75rem;
			font-weight: 700;
			color: #475569;
			margin-bottom: 6px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.form-group input,
		.form-group select {
			padding: 8px 12px;
			border: 1px solid #cbd5e1;
			border-radius: 6px;
			font-size: 0.9rem;
			color: #1e293b;
		}
		.form-group input:focus,
		.form-group select:focus {
			border-color: #0d9488;
			outline: none;
		}
		.col-span-2 {
			grid-column: span 2;
		}

		@keyframes fadeIn {
			from { opacity: 0; }
			to { opacity: 1; }
		}
		@keyframes scaleUpModal {
			from { transform: scale(0.95); opacity: 0; }
			to { transform: scale(1); opacity: 1; }
		}

		@media (max-width: 768px) {
			.modal-form-grid {
				grid-template-columns: 1fr;
			}
			.col-span-2 {
				grid-column: span 1;
			}
			.clinic-admin-header {
				flex-direction: column;
				align-items: flex-start;
			}
			.clinic-admin-header-actions {
				width: 100%;
			}
			.clinic-admin-header-actions button,
			.clinic-admin-header-actions a {
				flex: 1;
				text-align: center;
			}
		}
		</style>
		<?php
	}

	/**
	 * AJAX Update Status handler (legacy/quick status updates).
	 */
	public function ajax_update_status() {
		check_ajax_referer( 'developer_starter_pro_appointment_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'developer-starter-pro' ) ) );
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		$id     = absint( $_POST['id'] ?? 0 );
		$status = sanitize_text_field( $_POST['status'] ?? '' );

		$allowed_statuses = array( 'approved', 'confirmed', 'rejected', 'rescheduled', 'completed', 'cancelled', 'no_show' );
		if ( ! in_array( $status, $allowed_statuses, true ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid status value.', 'developer-starter-pro' ) ) );
		}

		// Fetch current status before updating
		$old_status = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM $table_name WHERE id = %d", $id ) );

		$updated = $wpdb->update(
			$table_name,
			array( 'status' => $status ),
			array( 'id' => $id ),
			array( '%s' ),
			array( '%d' )
		);

		if ( false !== $updated ) {
			do_action( 'dentalpro_appointment_status_changed', $id, $old_status, $status );
			wp_send_json_success();
		}

		wp_send_json_error( array( 'message' => esc_html__( 'Error updating record in database.', 'developer-starter-pro' ) ) );
	}

	/**
	 * AJAX Fetch Filtered Appointments List, Summary Stats & Pagination.
	 */
	public function ajax_get_appointments() {
		check_ajax_referer( 'developer_starter_pro_appointment_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'developer-starter-pro' ) ) );
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		$filters = $_POST['filters'] ?? array();
		
		$search           = sanitize_text_field( $filters['search'] ?? '' );
		$status           = sanitize_text_field( $filters['status'] ?? '' );
		$date_filter      = sanitize_text_field( $filters['date_filter'] ?? '' );
		$start_date       = sanitize_text_field( $filters['start_date'] ?? '' );
		$end_date         = sanitize_text_field( $filters['end_date'] ?? '' );
		$doctor_id        = absint( $filters['doctor_id'] ?? 0 );
		$service_id       = absint( $filters['service_id'] ?? 0 );
		$booking_source   = sanitize_text_field( $filters['booking_source'] ?? '' );
		$appointment_type = sanitize_text_field( $filters['appointment_type'] ?? '' );
		$page             = max( 1, absint( $filters['paged'] ?? 1 ) );

		// 1. Build Query Conditions
		$where = array( "1=1" );

		$today        = date( 'Y-m-d' );
		$current_time = date( 'H:i' );

		if ( ! empty( $status ) ) {
			if ( 'expired' === $status ) {
				$where[] = $wpdb->prepare( "(booking_date < %s OR (booking_date = %s AND time_slot < %s)) AND status IN ('pending', 'confirmed', 'approved', 'rescheduled')", $today, $today, $current_time );
			} elseif ( 'confirmed' === $status || 'approved' === $status ) {
				$where[] = $wpdb->prepare( "status IN ('confirmed', 'approved') AND NOT (booking_date < %s OR (booking_date = %s AND time_slot < %s))", $today, $today, $current_time );
			} elseif ( in_array( $status, array( 'pending', 'rescheduled' ), true ) ) {
				$where[] = $wpdb->prepare( "status = %s AND NOT (booking_date < %s OR (booking_date = %s AND time_slot < %s))", $status, $today, $today, $current_time );
			} else {
				$where[] = $wpdb->prepare( "status = %s", $status );
			}
		} else {
			// Under 'All' status (or no status filter), exclude expired appointments.
			$where[] = $wpdb->prepare( "NOT ( (booking_date < %s OR (booking_date = %s AND time_slot < %s)) AND status IN ('pending', 'confirmed', 'approved', 'rescheduled') )", $today, $today, $current_time );
		}

		if ( ! empty( $doctor_id ) ) {
			$where[] = $wpdb->prepare( "doctor_id = %d", $doctor_id );
		}

		if ( ! empty( $service_id ) ) {
			$where[] = $wpdb->prepare( "service_id = %d", $service_id );
		}

		if ( ! empty( $booking_source ) ) {
			$where[] = $wpdb->prepare( "booking_source = %s", $booking_source );
		}

		if ( ! empty( $appointment_type ) ) {
			$where[] = $wpdb->prepare( "appointment_type = %s", $appointment_type );
		}

		if ( ! empty( $date_filter ) ) {
			$today = date( 'Y-m-d' );
			switch ( $date_filter ) {
				case 'today':
					$where[] = $wpdb->prepare( "booking_date = %s", $today );
					break;
				case 'tomorrow':
					$tomorrow = date( 'Y-m-d', strtotime( '+1 day' ) );
					$where[] = $wpdb->prepare( "booking_date = %s", $tomorrow );
					break;
				case 'this_week':
					$start_week = date( 'Y-m-d', strtotime( 'monday this week' ) );
					$end_week   = date( 'Y-m-d', strtotime( 'sunday this week' ) );
					$where[] = $wpdb->prepare( "booking_date BETWEEN %s AND %s", $start_week, $end_week );
					break;
				case 'this_month':
					$start_month = date( 'Y-m-01' );
					$end_month   = date( 'Y-m-t' );
					$where[] = $wpdb->prepare( "booking_date BETWEEN %s AND %s", $start_month, $end_month );
					break;
				case 'custom':
					if ( ! empty( $start_date ) && ! empty( $end_date ) ) {
						$where[] = $wpdb->prepare( "booking_date BETWEEN %s AND %s", $start_date, $end_date );
					} elseif ( ! empty( $start_date ) ) {
						$where[] = $wpdb->prepare( "booking_date >= %s", $start_date );
					} elseif ( ! empty( $end_date ) ) {
						$where[] = $wpdb->prepare( "booking_date <= %s", $end_date );
					}
					break;
			}
		}

		if ( ! empty( $search ) ) {
			if ( preg_match( '/^APT-(\d+)$/i', $search, $matches ) ) {
				$search_id = intval( $matches[1] );
				$where[] = $wpdb->prepare( "(id = %d OR patient_name LIKE %s OR patient_phone LIKE %s OR patient_email LIKE %s)", $search_id, '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%' );
			} else {
				$where[] = $wpdb->prepare( "(id = %d OR patient_name LIKE %s OR patient_phone LIKE %s OR patient_email LIKE %s)", intval( $search ), '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%' );
			}
		}

		$where_clause = implode( ' AND ', $where );

		// 2. Pagination Offset
		$limit = 15;
		$offset = ( $page - 1 ) * $limit;

		$appointments = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM $table_name WHERE $where_clause ORDER BY booking_date ASC, time_slot ASC LIMIT %d OFFSET %d",
			$limit,
			$offset
		) );

		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE $where_clause" );
		$total_pages = ceil( $total_items / $limit );

		// 3. Render HTML Table Body
		$table_html = '';
		if ( ! empty( $appointments ) ) {
			foreach ( $appointments as $apt ) {
				$doc_name = get_the_title( $apt->doctor_id );
				$srv_name = get_the_title( $apt->service_id );
				$ref_id   = 'APT-' . sprintf( '%05d', $apt->id );
				
				$is_expired = false;
				if ( in_array( $apt->status, array( 'pending', 'confirmed', 'approved', 'rescheduled' ), true ) ) {
					if ( $apt->booking_date < $today || ( $apt->booking_date === $today && $apt->time_slot < $current_time ) ) {
						$is_expired = true;
					}
				}
				$status = $is_expired ? 'expired' : $apt->status;
				$source      = ! empty( $apt->booking_source ) ? $apt->booking_source : 'website';
				$type        = ! empty( $apt->appointment_type ) ? $apt->appointment_type : 'clinic_visit';
				$source_labels = array(
					'website' => esc_html__( 'Website', 'developer-starter-pro' ),
					'phone'   => esc_html__( 'Phone', 'developer-starter-pro' ),
					'whatsapp'=> esc_html__( 'WhatsApp', 'developer-starter-pro' ),
					'walk_in' => esc_html__( 'Walk-In', 'developer-starter-pro' ),
					'admin'   => esc_html__( 'Admin', 'developer-starter-pro' ),
				);
				$type_labels = array(
					'clinic_visit'       => esc_html__( 'Clinic Visit', 'developer-starter-pro' ),
					'video_consultation' => esc_html__( 'Video Conf.', 'developer-starter-pro' ),
					'emergency'          => esc_html__( 'Emergency', 'developer-starter-pro' ),
				);

				$table_html .= '<tr id="appointment-row-' . intval( $apt->id ) . '">';
				$table_html .= '<td class="col-check"><input type="checkbox" class="booking-checkbox" value="' . intval( $apt->id ) . '"></td>';
				$table_html .= '<td class="col-id"><strong>' . esc_html( $ref_id ) . '</strong></td>';
				
				// Patient Cell
				$table_html .= '<td class="col-patient patient-cell">';
				$table_html .= '<strong>' . esc_html( $apt->patient_name ) . '</strong>';
				$table_html .= '<span class="contact-span">📞 ' . esc_html( $apt->patient_phone ) . '</span>';
				$table_html .= '<span class="contact-span">✉️ ' . esc_html( $apt->patient_email ) . '</span>';
				if ( ! empty( $apt->notes ) ) {
					$table_html .= '<span class="notes-span">"' . esc_html( $apt->notes ) . '"</span>';
				}
				if ( ! empty( $apt->internal_notes ) ) {
					$table_html .= '<span class="internal-notes-span">📝 ' . esc_html( $apt->internal_notes ) . '</span>';
				}
				$table_html .= '</td>';
				
				// Location Cell
				$loc_name = $apt->location_id ? get_the_title( $apt->location_id ) : esc_html__( 'General / All', 'developer-starter-pro' );
				$table_html .= '<td class="col-location">📍 ' . esc_html( $loc_name ) . '</td>';
				
				$table_html .= '<td class="col-doctor">👨‍⚕️ ' . esc_html( $doc_name ) . '</td>';
				$table_html .= '<td class="col-service"><span style="color:var(--developer-starter-pro-primary); font-weight:600;">' . esc_html( $srv_name ) . '</span></td>';
				
				// Date Time
				$table_html .= '<td class="col-datetime">';
				$table_html .= '<strong>' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $apt->booking_date ) ) ) . '</strong>';
				$table_html .= '<div style="margin-top:4px;"><span class="badge" style="background:#f1f5f9; color:#334155; font-size:0.75rem; font-weight:700; padding:3px 8px; border-radius:10px;">' . esc_html( date( 'g:i A', strtotime( $apt->time_slot ) ) ) . '</span></div>';
				$table_html .= '</td>';

				// Source
				$src_label = $source_labels[ $source ] ?? $source;
				$table_html .= '<td class="col-source"><span class="clinic-badge source-' . esc_attr( $source ) . '">' . esc_html( $src_label ) . '</span></td>';
				
				// Type
				$t_label = $type_labels[ $type ] ?? $type;
				$table_html .= '<td class="col-type"><span class="clinic-badge type-' . esc_attr( $type ) . '">' . esc_html( $t_label ) . '</span></td>';

				// Status Badge
				$table_html .= '<td class="col-status"><span class="clinic-badge status-' . esc_attr( $status ) . '" id="status-badge-' . intval( $apt->id ) . '">' . esc_html( ucfirst( $status ) ) . '</span></td>';
				
				// Action Buttons
				$table_html .= '<td class="col-actions text-right" style="text-align:right;">';
				$table_html .= '<div class="action-buttons-cell">';
				
				$table_html .= '<button type="button" class="button edit-booking-btn" ' . 
					'data-id="' . intval( $apt->id ) . '" ' .
					'data-patient_name="' . esc_attr( $apt->patient_name ) . '" ' .
					'data-patient_phone="' . esc_attr( $apt->patient_phone ) . '" ' .
					'data-patient_email="' . esc_attr( $apt->patient_email ) . '" ' .
					'data-location_id="' . intval( $apt->location_id ) . '" ' .
					'data-doctor_id="' . intval( $apt->doctor_id ) . '" ' .
					'data-service_id="' . intval( $apt->service_id ) . '" ' .
					'data-booking_date="' . esc_attr( $apt->booking_date ) . '" ' .
					'data-time_slot="' . esc_attr( $apt->time_slot ) . '" ' .
					'data-status="' . esc_attr( $apt->status ) . '" ' .
					'data-booking_source="' . esc_attr( $source ) . '" ' .
					'data-appointment_type="' . esc_attr( $type ) . '" ' .
					'data-notes="' . esc_attr( $apt->notes ) . '" ' .
					'data-internal_notes="' . esc_attr( $apt->internal_notes ) . '">' .
					'⚙️ ' . esc_html__( 'Manage', 'developer-starter-pro' ) . '</button>';

				if ( 'pending' === $status ) {
					$table_html .= '<button type="button" class="button button-primary list-action-btn" data-id="' . intval( $apt->id ) . '" data-status="confirmed">' . esc_html__( 'Approve', 'developer-starter-pro' ) . '</button>';
				}
				
				if ( in_array( $status, array( 'confirmed', 'approved', 'rescheduled' ), true ) ) {
					$table_html .= '<button type="button" class="button list-action-btn" style="background:#10b981; border-color:#10b981; color:#fff;" data-id="' . intval( $apt->id ) . '" data-status="completed">' . esc_html__( 'Complete', 'developer-starter-pro' ) . '</button>';
				}
				
				$table_html .= '</div>';
				$table_html .= '</td>';

				$table_html .= '</tr>';
			}
		} else {
			$table_html .= '<tr><td colspan="11" style="text-align: center; padding: 40px; color:#64748b; font-style:italic;">' . esc_html__( 'No clinic records found matching filters.', 'developer-starter-pro' ) . '</td></tr>';
		}

		// 4. Render Pagination HTML
		$pagination_html = '';
		if ( $total_pages > 1 ) {
			$pagination_links = paginate_links( array(
				'base'      => add_query_arg( 'paged', '%#%' ),
				'format'    => '',
				'prev_text' => '&laquo; Prev',
				'next_text' => 'Next &raquo;',
				'total'     => $total_pages,
				'current'   => $page,
				'type'      => 'plain'
			) );
			if ( $pagination_links ) {
				$pagination_html = '<div class="tablenav-pages"><span class="displaying-num">' . 
					sprintf( _n( '%s appointment', '%s appointments', $total_items, 'developer-starter-pro' ), number_format_i18n( $total_items ) ) . 
					'</span> <span class="pagination-links">' . $pagination_links . '</span></div>';
			}
		}

		// 5. Gather Summary Statistics (independent of filters except for date context)
		$today_str = date( 'Y-m-d' );
		$stat_today = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE booking_date = %s", $today_str ) );
		$stat_pending = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE status = 'pending' AND NOT (booking_date < %s OR (booking_date = %s AND time_slot < %s))", $today_str, $today_str, $current_time ) );
		$stat_confirmed = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE status IN ('confirmed', 'approved') AND NOT (booking_date < %s OR (booking_date = %s AND time_slot < %s))", $today_str, $today_str, $current_time ) );
		$stat_completed = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'completed'" );
		$stat_cancelled = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'cancelled'" );
		$stat_expired = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE status IN ('pending', 'confirmed', 'approved', 'rescheduled') AND (booking_date < %s OR (booking_date = %s AND time_slot < %s))", $today_str, $today_str, $current_time ) );

		$today_revenue_apts = $wpdb->get_results( $wpdb->prepare(
			"SELECT service_id FROM $table_name WHERE booking_date = %s AND status NOT IN ('cancelled', 'rejected')",
			$today_str
		) );
		$stat_revenue = 0;
		if ( ! empty( $today_revenue_apts ) ) {
			foreach ( $today_revenue_apts as $apt ) {
				$price = get_post_meta( $apt->service_id, '_developer_starter_pro_service_price', true );
				$stat_revenue += developer_starter_pro_get_clean_service_price( $price );
			}
		}

		// Send JSON Response
		wp_send_json_success( array(
			'stats' => array(
				'today'     => number_format_i18n( $stat_today ),
				'pending'   => number_format_i18n( $stat_pending ),
				'confirmed' => number_format_i18n( $stat_confirmed ),
				'completed' => number_format_i18n( $stat_completed ),
				'cancelled' => number_format_i18n( $stat_cancelled ),
				'expired'   => number_format_i18n( $stat_expired ),
				'revenue'   => '$' . number_format( $stat_revenue, 0 )
			),
			'table_html'      => $table_html,
			'pagination_html' => $pagination_html
		) );
	}

	/**
	 * AJAX Save or Create Appointment Handler.
	 */
	public function ajax_save_appointment() {
		check_ajax_referer( 'developer_starter_pro_appointment_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'developer-starter-pro' ) ) );
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		// Parse serialized form array
		$form_data = array();
		if ( isset( $_POST['form_data'] ) && is_array( $_POST['form_data'] ) ) {
			foreach ( $_POST['form_data'] as $item ) {
				$form_data[ $item['name'] ] = $item['value'];
			}
		}

		$id               = absint( $form_data['id'] ?? 0 );
		$patient_name     = sanitize_text_field( $form_data['patient_name'] ?? '' );
		$patient_phone    = sanitize_text_field( $form_data['patient_phone'] ?? '' );
		$patient_email    = sanitize_email( $form_data['patient_email'] ?? '' );
		$location_id      = absint( $form_data['location_id'] ?? 0 );
		$doctor_id        = absint( $form_data['doctor_id'] ?? 0 );
		$service_id       = absint( $form_data['service_id'] ?? 0 );
		$booking_date     = sanitize_text_field( $form_data['booking_date'] ?? '' );
		$time_slot        = sanitize_text_field( $form_data['time_slot'] ?? '' );
		$status           = sanitize_text_field( $form_data['status'] ?? 'pending' );
		$payment_status   = 'unpaid';
		$booking_source   = sanitize_text_field( $form_data['booking_source'] ?? 'admin' );
		$appointment_type = sanitize_text_field( $form_data['appointment_type'] ?? 'clinic_visit' );
		$notes            = sanitize_textarea_field( $form_data['notes'] ?? '' );
		$internal_notes   = sanitize_textarea_field( $form_data['internal_notes'] ?? '' );

		if ( empty( $patient_name ) || empty( $patient_phone ) || empty( $patient_email ) || empty( $doctor_id ) || empty( $service_id ) || empty( $booking_date ) || empty( $time_slot ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'All fields marked with * are required.', 'developer-starter-pro' ) ) );
		}

		if ( ! is_email( $patient_email ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Please enter a valid email address.', 'developer-starter-pro' ) ) );
		}

		$data = array(
			'patient_name'     => $patient_name,
			'patient_phone'    => $patient_phone,
			'patient_email'    => $patient_email,
			'location_id'      => $location_id,
			'doctor_id'        => $doctor_id,
			'service_id'       => $service_id,
			'booking_date'     => $booking_date,
			'time_slot'        => $time_slot,
			'status'           => $status,
			'payment_status'   => $payment_status,
			'booking_source'   => $booking_source,
			'appointment_type' => $appointment_type,
			'notes'            => $notes,
			'internal_notes'   => $internal_notes
		);
		$formats = array( '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );

		if ( ! empty( $id ) ) {
			// Update mode
			$old_booking = $wpdb->get_row( $wpdb->prepare( "SELECT booking_date, time_slot, status FROM $table_name WHERE id = %d", $id ) );
			$old_status  = $old_booking ? $old_booking->status : 'pending';
			$old_date    = $old_booking ? $old_booking->booking_date : '';
			$old_time    = $old_booking ? $old_booking->time_slot : '';

			$updated = $wpdb->update(
				$table_name,
				$data,
				array( 'id' => $id ),
				$formats,
				array( '%d' )
			);

			if ( false !== $updated ) {
				$date_changed = ( $old_date !== $booking_date );
				$time_changed = ( $old_time !== $time_slot );
				$status_is_terminal = in_array( $status, array( 'cancelled', 'rejected', 'completed' ), true );

				if ( ( $date_changed || $time_changed ) && ! $status_is_terminal ) {
					// Date or time slot changed, and it's not cancelled/declined/completed: trigger reschedule notification
					do_action( 'dentalpro_appointment_rescheduled', $id );
					
					// Also, if the status changed to something else (excluding rescheduled), trigger status changed
					if ( $old_status !== $status && 'rescheduled' !== $status ) {
						do_action( 'dentalpro_appointment_status_changed', $id, $old_status, $status );
					}
				} else {
					// Either no date change, or status changed to a terminal state (cancelled/rejected/completed)
					if ( $old_status !== $status ) {
						do_action( 'dentalpro_appointment_status_changed', $id, $old_status, $status );
					}
				}
				wp_send_json_success();
			}
		} else {
			// Create mode
			$inserted = $wpdb->insert( $table_name, $data, $formats );
			if ( $inserted ) {
				$new_id = $wpdb->insert_id;
				// Fire CPT booked trigger (which sends admin alert and/or auto-approves)
				do_action( 'dentalpro_appointment_booked', $new_id );
				
				// In manual mode, since it was created by admin directly, let's auto confirm if admin selected 'confirmed'
				if ( 'confirmed' === $status ) {
					do_action( 'dentalpro_appointment_status_changed', $new_id, 'pending', 'confirmed' );
				}
				wp_send_json_success();
			}
		}

		wp_send_json_error( array( 'message' => esc_html__( 'Error saving appointment to database.', 'developer-starter-pro' ) ) );
	}

	/**
	 * AJAX Bulk Actions Handler.
	 */
	public function ajax_bulk_action() {
		check_ajax_referer( 'developer_starter_pro_appointment_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'developer-starter-pro' ) ) );
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		$action_type = sanitize_text_field( $_POST['action_type'] ?? '' );
		$ids         = array_map( 'absint', $_POST['ids'] ?? array() );
		$extra       = isset( $_POST['extra'] ) && is_array( $_POST['extra'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['extra'] ) ) : array();

		if ( empty( $action_type ) || empty( $ids ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Missing arguments for bulk action.', 'developer-starter-pro' ) ) );
		}

		$success_count = 0;

		switch ( $action_type ) {
			case 'confirm':
				foreach ( $ids as $id ) {
					$old_status = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM $table_name WHERE id = %d", $id ) );
					if ( 'confirmed' !== $old_status && 'approved' !== $old_status ) {
						$updated = $wpdb->update( $table_name, array( 'status' => 'confirmed' ), array( 'id' => $id ) );
						if ( false !== $updated ) {
							do_action( 'dentalpro_appointment_status_changed', $id, $old_status, 'confirmed' );
							$success_count++;
						}
					}
				}
				break;

			case 'complete':
				foreach ( $ids as $id ) {
					$old_status = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM $table_name WHERE id = %d", $id ) );
					if ( 'completed' !== $old_status ) {
						$updated = $wpdb->update( $table_name, array( 'status' => 'completed' ), array( 'id' => $id ) );
						if ( false !== $updated ) {
							do_action( 'dentalpro_appointment_status_changed', $id, $old_status, 'completed' );
							$success_count++;
						}
					}
				}
				break;

			case 'cancel':
				foreach ( $ids as $id ) {
					$old_status = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM $table_name WHERE id = %d", $id ) );
					if ( 'cancelled' !== $old_status ) {
						$updated = $wpdb->update( $table_name, array( 'status' => 'cancelled' ), array( 'id' => $id ) );
						if ( false !== $updated ) {
							do_action( 'dentalpro_appointment_status_changed', $id, $old_status, 'cancelled' );
							$success_count++;
						}
					}
				}
				break;

			case 'reschedule':
				$new_date = sanitize_text_field( $extra['date'] ?? '' );
				$new_time = sanitize_text_field( $extra['time'] ?? '' );
				if ( empty( $new_date ) || empty( $new_time ) ) {
					wp_send_json_error( array( 'message' => esc_html__( 'Please provide date and time slot.', 'developer-starter-pro' ) ) );
				}
				foreach ( $ids as $id ) {
					$old_status = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM $table_name WHERE id = %d", $id ) );
					$updated = $wpdb->update(
						$table_name,
						array(
							'status'       => 'rescheduled',
							'booking_date' => $new_date,
							'time_slot'    => $new_time
						),
						array( 'id' => $id )
					);
					if ( false !== $updated ) {
						do_action( 'dentalpro_appointment_status_changed', $id, $old_status, 'rescheduled' );
						$success_count++;
					}
				}
				break;

			case 'send_sms':
			case 'send_whatsapp':
				// Bulk message sender log simulation
				$message_template = sanitize_textarea_field( $extra['message'] ?? '' );
				$service_label = ( 'send_sms' === $action_type ) ? 'SMS' : 'WhatsApp';
				
				foreach ( $ids as $id ) {
					$booking = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ) );
					if ( $booking ) {
						$appointment_date = date_i18n( get_option( 'date_format' ), strtotime( $booking->booking_date ) );
						$appointment_time = date( 'g:i A', strtotime( $booking->time_slot ) );
						
						$options = developer_starter_pro_get_all_options();
						$clinic_name = ! empty( $options['clinic_name'] ) ? $options['clinic_name'] : get_bloginfo( 'name' );

						// Parse tags
						$msg = str_replace(
							array( '{patient_name}', '{appointment_date}', '{appointment_time}', '{clinic_name}' ),
							array( $booking->patient_name, $appointment_date, $appointment_time, $clinic_name ),
							$message_template
						);

						error_log( "[BULK-{$service_label}] Dispatched to {$booking->patient_phone}: $msg" );
						$success_count++;
					}
				}
				break;
		}

		wp_send_json_success( array( 'count' => $success_count ) );
	}

	/**
	 * Export filtered appointments matching conditions to CSV.
	 */
	public function export_appointments_csv() {
		$this->export_appointments_raw( 'csv' );
	}

	/**
	 * Export filtered appointments matching conditions to Excel.
	 */
	public function export_appointments_excel() {
		$this->export_appointments_raw( 'excel' );
	}

	/**
	 * Core Export Dispatcher.
	 */
	private function export_appointments_raw( $format = 'csv' ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'developer-starter-pro' ) );
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		// Parse filters from GET parameters
		$search           = sanitize_text_field( $_GET['search'] ?? '' );
		$status           = sanitize_text_field( $_GET['status'] ?? '' );
		$date_filter      = sanitize_text_field( $_GET['date_filter'] ?? '' );
		$start_date       = sanitize_text_field( $_GET['start_date'] ?? '' );
		$end_date         = sanitize_text_field( $_GET['end_date'] ?? '' );
		$doctor_id        = absint( $_GET['doctor_id'] ?? 0 );
		$service_id       = absint( $_GET['service_id'] ?? 0 );
		$booking_source   = sanitize_text_field( $_GET['booking_source'] ?? '' );
		$appointment_type = sanitize_text_field( $_GET['appointment_type'] ?? '' );

		$where = array( "1=1" );

		$today        = date( 'Y-m-d' );
		$current_time = date( 'H:i' );

		if ( ! empty( $status ) ) {
			if ( 'expired' === $status ) {
				$where[] = $wpdb->prepare( "(booking_date < %s OR (booking_date = %s AND time_slot < %s)) AND status IN ('pending', 'confirmed', 'approved', 'rescheduled')", $today, $today, $current_time );
			} elseif ( 'confirmed' === $status || 'approved' === $status ) {
				$where[] = $wpdb->prepare( "status IN ('confirmed', 'approved') AND NOT (booking_date < %s OR (booking_date = %s AND time_slot < %s))", $today, $today, $current_time );
			} elseif ( in_array( $status, array( 'pending', 'rescheduled' ), true ) ) {
				$where[] = $wpdb->prepare( "status = %s AND NOT (booking_date < %s OR (booking_date = %s AND time_slot < %s))", $status, $today, $today, $current_time );
			} else {
				$where[] = $wpdb->prepare( "status = %s", $status );
			}
		} else {
			// Under 'All' status (or no status filter), exclude expired appointments.
			$where[] = $wpdb->prepare( "NOT ( (booking_date < %s OR (booking_date = %s AND time_slot < %s)) AND status IN ('pending', 'confirmed', 'approved', 'rescheduled') )", $today, $today, $current_time );
		}

		if ( ! empty( $doctor_id ) ) {
			$where[] = $wpdb->prepare( "doctor_id = %d", $doctor_id );
		}

		if ( ! empty( $service_id ) ) {
			$where[] = $wpdb->prepare( "service_id = %d", $service_id );
		}

		if ( ! empty( $booking_source ) ) {
			$where[] = $wpdb->prepare( "booking_source = %s", $booking_source );
		}

		if ( ! empty( $appointment_type ) ) {
			$where[] = $wpdb->prepare( "appointment_type = %s", $appointment_type );
		}

		if ( ! empty( $date_filter ) ) {
			$today = date( 'Y-m-d' );
			switch ( $date_filter ) {
				case 'today':
					$where[] = $wpdb->prepare( "booking_date = %s", $today );
					break;
				case 'tomorrow':
					$tomorrow = date( 'Y-m-d', strtotime( '+1 day' ) );
					$where[] = $wpdb->prepare( "booking_date = %s", $tomorrow );
					break;
				case 'this_week':
					$start_week = date( 'Y-m-d', strtotime( 'monday this week' ) );
					$end_week   = date( 'Y-m-d', strtotime( 'sunday this week' ) );
					$where[] = $wpdb->prepare( "booking_date BETWEEN %s AND %s", $start_week, $end_week );
					break;
				case 'this_month':
					$start_month = date( 'Y-m-01' );
					$end_month   = date( 'Y-m-t' );
					$where[] = $wpdb->prepare( "booking_date BETWEEN %s AND %s", $start_month, $end_month );
					break;
				case 'custom':
					if ( ! empty( $start_date ) && ! empty( $end_date ) ) {
						$where[] = $wpdb->prepare( "booking_date BETWEEN %s AND %s", $start_date, $end_date );
					}
					break;
			}
		}

		if ( ! empty( $search ) ) {
			if ( preg_match( '/^APT-(\d+)$/i', $search, $matches ) ) {
				$search_id = intval( $matches[1] );
				$where[] = $wpdb->prepare( "(id = %d OR patient_name LIKE %s OR patient_phone LIKE %s OR patient_email LIKE %s)", $search_id, '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%' );
			} else {
				$where[] = $wpdb->prepare( "(id = %d OR patient_name LIKE %s OR patient_phone LIKE %s OR patient_email LIKE %s)", intval( $search ), '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%', '%' . $wpdb->esc_like( $search ) . '%' );
			}
		}

		$where_clause = implode( ' AND ', $where );

		if ( ob_get_length() ) {
			ob_end_clean();
		}

		$filename = 'clinic-export-' . date( 'Y-m-d' ) . ( 'excel' === $format ? '.xls' : '.csv' );

		if ( 'excel' === $format ) {
			header( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
			header( "Content-Disposition: attachment; filename=$filename" );
		} else {
			header( 'Content-Type: text/csv; charset=utf-8' );
			header( "Content-Disposition: attachment; filename=$filename" );
		}
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		$output = fopen( 'php://output', 'w' );

		// Column headers
		fputcsv( $output, array(
			__( 'Appointment ID', 'developer-starter-pro' ),
			__( 'Patient Name', 'developer-starter-pro' ),
			__( 'Patient Phone', 'developer-starter-pro' ),
			__( 'Patient Email', 'developer-starter-pro' ),
			__( 'Doctor Name', 'developer-starter-pro' ),
			__( 'Service Name', 'developer-starter-pro' ),
			__( 'Booking Date', 'developer-starter-pro' ),
			__( 'Time Slot', 'developer-starter-pro' ),
			__( 'Booking Source', 'developer-starter-pro' ),
			__( 'Appointment Type', 'developer-starter-pro' ),
			__( 'Status', 'developer-starter-pro' ),
			__( 'Patient Notes', 'developer-starter-pro' ),
			__( 'Internal Notes', 'developer-starter-pro' ),
			__( 'Created At', 'developer-starter-pro' )
		) );

		$offset = 0;
		$limit  = 500;

		while ( true ) {
			$appointments = $wpdb->get_results( "SELECT * FROM $table_name WHERE $where_clause ORDER BY booking_date ASC, time_slot ASC LIMIT $limit OFFSET $offset" );

			if ( empty( $appointments ) ) {
				break;
			}

			foreach ( $appointments as $apt ) {
				$doc_name = get_the_title( $apt->doctor_id );
				$srv_name = get_the_title( $apt->service_id );
				$ref_id   = 'APT-' . sprintf( '%05d', $apt->id );
				
				fputcsv( $output, array(
					$ref_id,
					$apt->patient_name,
					$apt->patient_phone,
					$apt->patient_email,
					$doc_name,
					$srv_name,
					$apt->booking_date,
					$apt->time_slot,
					ucfirst( str_replace( '_', ' ', $apt->booking_source ) ),
					ucfirst( str_replace( '_', ' ', $apt->appointment_type ) ),
					( ( in_array( $apt->status, array( 'pending', 'confirmed', 'approved', 'rescheduled' ), true ) && ( $apt->booking_date < $today || ( $apt->booking_date === $today && $apt->time_slot < $current_time ) ) ) ? __( 'Expired', 'developer-starter-pro' ) : ucfirst( $apt->status ) ),
					$apt->notes,
					$apt->internal_notes,
					$apt->created_at
				) );
			}

			if ( count( $appointments ) < $limit ) {
				break;
			}

			$offset += $limit;
		}

		fclose( $output );
		exit;
	}

	/**
	 * AJAX Toggle Appointment Approval Mode.
	 */
	public function ajax_toggle_approval_mode() {
		check_ajax_referer( 'developer_starter_pro_appointment_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'developer-starter-pro' ) ) );
		}

		$mode = isset( $_POST['mode'] ) ? sanitize_text_field( $_POST['mode'] ) : 'automatic';
		if ( ! in_array( $mode, array( 'automatic', 'manual' ), true ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid mode.', 'developer-starter-pro' ) ) );
		}

		$options = get_option( 'developer_starter_pro_options', array() );
		$options['appointment_approval_mode'] = $mode;
		update_option( 'developer_starter_pro_options', $options );

		wp_send_json_success( array( 'message' => esc_html__( 'Approval mode updated successfully!', 'developer-starter-pro' ) ) );
	}
}
