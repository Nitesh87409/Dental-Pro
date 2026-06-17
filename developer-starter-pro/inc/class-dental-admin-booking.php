<?php
/**
 * Appointments Admin Dashboard Page
 *
 * Adds a management dashboard to view, filter, approve, and cancel patient bookings.
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
	 * Database option / page settings.
	 */
	private $page_slug = 'developer-starter-pro-appointments';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_appointments_submenu' ) );
		add_action( 'wp_ajax_developer_starter_pro_update_appointment_status', array( $this, 'ajax_update_status' ) );
		add_action( 'admin_post_developer_starter_pro_export_appointments_csv', array( $this, 'export_appointments_csv' ) );
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

		// Read appointment approval mode settings
		$options = developer_starter_pro_get_all_options();
		$mode = isset( $options['appointment_approval_mode'] ) ? $options['appointment_approval_mode'] : 'automatic';
		$pending_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'pending'" );

		// Handle status filters.
		$filter_status = sanitize_text_field( $_GET['status'] ?? '' );
		$where_clause = "1=1";
		$allowed_filters = array( 'pending', 'approved', 'confirmed', 'rescheduled', 'rejected', 'completed', 'cancelled' );
		if ( in_array( $filter_status, $allowed_filters, true ) ) {
			if ( 'confirmed' === $filter_status || 'approved' === $filter_status ) {
				$where_clause = "status IN ('confirmed', 'approved')";
			} else {
				$where_clause = $wpdb->prepare( "status = %s", $filter_status );
			}
		}

		// Handle pagination.
		$limit = 20;
		$page = max( 1, absint( $_GET['paged'] ?? 1 ) );
		$offset = ( $page - 1 ) * $limit;

		$appointments = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM $table_name WHERE $where_clause ORDER BY booking_date DESC, time_slot ASC LIMIT %d OFFSET %d",
			$limit,
			$offset
		) );
		$total_items  = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE $where_clause" );
		$total_pages  = ceil( $total_items / $limit );

		$nonce = wp_create_nonce( 'developer_starter_pro_appointment_nonce' );
		?>
		<div class="wrap developer-starter-pro-admin-wrap">
			<div class="developer-starter-pro-admin-header">
				<div class="developer-starter-pro-admin-header-inner" style="display:flex; justify-content:space-between; align-items:center; width:100%; padding-right:20px;">
					<h1>
						<span class="developer-starter-pro-logo-icon">📅</span>
						<?php esc_html_e( 'Appointment Scheduling Manager', 'developer-starter-pro' ); ?>
					</h1>
					<a href="<?php echo esc_url( admin_url( 'admin-post.php?action=developer_starter_pro_export_appointments_csv' ) ); ?>" class="button button-secondary" style="font-weight:600; padding:5px 12px; height:auto; line-height:20px;">
						📥 <?php esc_html_e( 'Export to CSV', 'developer-starter-pro' ); ?>
					</a>
				</div>
			</div>

			<?php if ( 'manual' === $mode ) : ?>
				<div class="notice notice-warning inline" style="margin-top: 15px; border-left-color: #f59e0b; padding: 12px 15px; background: #fffdf5; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
					<p style="margin: 0; font-size: 0.95rem; font-weight: 500; color: #b45309;">
						⚠️ <strong><?php esc_html_e( 'Manual Approval Mode Active:', 'developer-starter-pro' ); ?></strong> 
						<?php esc_html_e( 'All new appointments are set to "Pending" and must be manually approved, rejected, or rescheduled.', 'developer-starter-pro' ); ?>
					</p>
				</div>
			<?php endif; ?>

			<div class="developer-starter-pro-admin-content" style="margin-top:20px;">
				
				<!-- Quick Filters -->
				<ul class="subsubsub">
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>" class="<?php echo empty( $filter_status ) ? 'current' : ''; ?>"><?php esc_html_e( 'All', 'developer-starter-pro' ); ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=pending" class="<?php echo 'pending' === $filter_status ? 'current' : ''; ?>"><?php esc_html_e( 'Pending', 'developer-starter-pro' ); ?> <?php echo $pending_count > 0 ? '<span class="count" style="background:#f59e0b; color:#fff; font-size:0.75rem; padding:2px 6px; border-radius:10px; font-weight:700; margin-left:3px;">' . intval( $pending_count ) . '</span>' : ''; ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=confirmed" class="<?php echo in_array( $filter_status, array( 'confirmed', 'approved' ), true ) ? 'current' : ''; ?>"><?php esc_html_e( 'Confirmed', 'developer-starter-pro' ); ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=rescheduled" class="<?php echo 'rescheduled' === $filter_status ? 'current' : ''; ?>"><?php esc_html_e( 'Rescheduled', 'developer-starter-pro' ); ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=rejected" class="<?php echo 'rejected' === $filter_status ? 'current' : ''; ?>"><?php esc_html_e( 'Rejected', 'developer-starter-pro' ); ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=completed" class="<?php echo 'completed' === $filter_status ? 'current' : ''; ?>"><?php esc_html_e( 'Completed', 'developer-starter-pro' ); ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=cancelled" class="<?php echo 'cancelled' === $filter_status ? 'current' : ''; ?>"><?php esc_html_e( 'Cancelled', 'developer-starter-pro' ); ?></a></li>
				</ul>

				<!-- Data Table -->
				<table class="wp-list-table widefat fixed striped table-view-list posts">
					<thead>
						<tr>
							<th scope="col" class="manage-column column-title column-primary"><?php esc_html_e( 'Patient Name', 'developer-starter-pro' ); ?></th>
							<th scope="col" class="manage-column"><?php esc_html_e( 'Contact Info', 'developer-starter-pro' ); ?></th>
							<th scope="col" class="manage-column"><?php esc_html_e( 'Doctor / Service', 'developer-starter-pro' ); ?></th>
							<th scope="col" class="manage-column"><?php esc_html_e( 'Booking Date', 'developer-starter-pro' ); ?></th>
							<th scope="col" class="manage-column"><?php esc_html_e( 'Time Slot', 'developer-starter-pro' ); ?></th>
							<th scope="col" class="manage-column"><?php esc_html_e( 'Status', 'developer-starter-pro' ); ?></th>
							<th scope="col" class="manage-column text-right" style="text-align: right;"><?php esc_html_e( 'Actions', 'developer-starter-pro' ); ?></th>
						</tr>
					</thead>
					<tbody id="the-list">
						<?php if ( ! empty( $appointments ) ) :
							foreach ( $appointments as $apt ) :
								$doc_name = get_the_title( $apt->doctor_id );
								$srv_name = get_the_title( $apt->service_id );
								$status_class = esc_attr( $apt->status );
								?>
								<tr id="appointment-row-<?php echo intval( $apt->id ); ?>">
									<td class="column-title has-row-actions column-primary">
										<strong><?php echo esc_html( $apt->patient_name ); ?></strong>
										<?php if ( ! empty( $apt->notes ) ) : ?>
											<p style="font-size: 0.8rem; color: #64748b; font-style: italic; margin: 4px 0 0 0;">
												"<?php echo esc_html( $apt->notes ); ?>"
											</p>
										<?php endif; ?>
									</td>
									<td>
										<div>📞 <a href="tel:<?php echo esc_attr( $apt->patient_phone ); ?>"><?php echo esc_html( $apt->patient_phone ); ?></a></div>
										<div>✉️ <a href="mailto:<?php echo esc_attr( $apt->patient_email ); ?>"><?php echo esc_html( $apt->patient_email ); ?></a></div>
									</td>
									<td>
										<div>👨‍⚕️ <?php echo esc_html( $doc_name ); ?></div>
										<div style="font-size: 0.8125rem; color: var(--developer-starter-pro-primary);"><?php echo esc_html( $srv_name ); ?></div>
									</td>
									<td><strong><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $apt->booking_date ) ) ); ?></strong></td>
									<td><span class="badge" style="background:#cbd5e1; color:#1e293b; padding: 4px 10px; border-radius: 12px; font-weight:600; font-size:0.8rem;"><?php echo esc_html( date( 'g:i A', strtotime( $apt->time_slot ) ) ); ?></span></td>
									<td>
										<span class="developer-starter-pro-slide-status <?php echo $status_class; ?>" id="status-badge-<?php echo intval( $apt->id ); ?>">
											<?php echo esc_html( ucfirst( $apt->status ) ); ?>
										</span>
									</td>
									<td style="text-align: right; vertical-align: middle;">
										<div class="appointment-actions" style="display:flex; justify-content:flex-end; gap:6px;">
											<?php if ( 'pending' === $apt->status ) : ?>
												<button type="button" class="button button-primary action-btn approve-btn" data-id="<?php echo intval( $apt->id ); ?>" data-status="confirmed">
													<?php esc_html_e( 'Approve', 'developer-starter-pro' ); ?>
												</button>
												<button type="button" class="button action-btn reject-btn" style="color:#ef4444; border-color:#fca5a5;" data-id="<?php echo intval( $apt->id ); ?>" data-status="rejected">
													<?php esc_html_e( 'Reject', 'developer-starter-pro' ); ?>
												</button>
												<button type="button" class="button action-btn reschedule-toggle-btn" data-id="<?php echo intval( $apt->id ); ?>">
													<?php esc_html_e( 'Reschedule', 'developer-starter-pro' ); ?>
												</button>
											<?php endif; ?>
											<?php if ( in_array( $apt->status, array( 'confirmed', 'approved', 'rescheduled' ), true ) ) : ?>
												<button type="button" class="button action-btn complete-btn" style="background: #10b981; border-color: #10b981; color:#fff;" data-id="<?php echo intval( $apt->id ); ?>" data-status="completed">
													<?php esc_html_e( 'Complete', 'developer-starter-pro' ); ?>
												</button>
												<button type="button" class="button action-btn reschedule-toggle-btn" data-id="<?php echo intval( $apt->id ); ?>">
													<?php esc_html_e( 'Reschedule', 'developer-starter-pro' ); ?>
												</button>
											<?php endif; ?>
											<?php if ( 'cancelled' !== $apt->status && 'completed' !== $apt->status && 'rejected' !== $apt->status ) : ?>
												<button type="button" class="button action-btn delete-btn" style="color: #64748b;" data-id="<?php echo intval( $apt->id ); ?>" data-status="cancelled">
													<?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?>
												</button>
											<?php endif; ?>
										</div>
									</td>
								</tr>
								<!-- Reschedule form row -->
								<tr id="reschedule-row-<?php echo intval( $apt->id ); ?>" class="reschedule-form-row" style="display:none; background:#f8fafc;">
									<td colspan="7" style="padding: 15px; border-left: 4px solid var(--developer-starter-pro-primary);">
										<div style="display:flex; gap:15px; align-items:center; flex-wrap:wrap;">
											<strong style="color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Reschedule Appointment:', 'developer-starter-pro' ); ?></strong>
											<input type="date" id="reschedule-date-<?php echo intval( $apt->id ); ?>" value="<?php echo esc_attr( $apt->booking_date ); ?>" min="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>" style="padding:6px 12px; border:1px solid #cbd5e1; border-radius:4px;">
											<input type="time" id="reschedule-time-<?php echo intval( $apt->id ); ?>" value="<?php echo esc_attr( $apt->time_slot ); ?>" style="padding:6px 12px; border:1px solid #cbd5e1; border-radius:4px;">
											<button type="button" class="button button-primary save-reschedule-btn" data-id="<?php echo intval( $apt->id ); ?>">
												<?php esc_html_e( 'Save', 'developer-starter-pro' ); ?>
											</button>
											<button type="button" class="button cancel-reschedule-btn" data-id="<?php echo intval( $apt->id ); ?>">
												<?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?>
											</button>
										</div>
									</td>
								</tr>
							<?php endforeach;
						else : ?>
							<tr>
								<td colspan="7" style="text-align: center; padding: 20px; color:#64748b;"><?php esc_html_e( 'No appointments scheduled matching filters.', 'developer-starter-pro' ); ?></td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>

				<!-- Pagination -->
				<?php if ( $total_pages > 1 ) : ?>
					<div class="tablenav bottom">
						<div class="tablenav-pages">
							<span class="displaying-num"><?php printf( esc_html( _n( '%s appointment', '%s appointments', $total_items, 'developer-starter-pro' ) ), number_format_i18n( $total_items ) ); ?></span>
							<span class="pagination-links">
								<?php
								echo paginate_links( array(
									'base'      => add_query_arg( 'paged', '%#%' ),
									'format'    => '',
									'prev_text' => '&laquo;',
									'next_text' => '&raquo;',
									'total'     => $total_pages,
									'current'   => $page,
								) );
								?>
							</span>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>

		<script>
		jQuery(document).ready(function($) {
			// Toggle Reschedule row
			$(document).on('click', '.reschedule-toggle-btn', function() {
				var id = $(this).data('id');
				$('#reschedule-row-' + id).toggle();
			});

			$(document).on('click', '.cancel-reschedule-btn', function() {
				var id = $(this).data('id');
				$('#reschedule-row-' + id).hide();
			});

			// Save Reschedule Click Handler
			$(document).on('click', '.save-reschedule-btn', function() {
				var $btn = $(this);
				var id = $btn.data('id');
				var date = $('#reschedule-date-' + id).val();
				var time = $('#reschedule-time-' + id).val();

				if ( ! date || ! time ) {
					alert('Please select a date and time.');
					return;
				}

				$btn.prop('disabled', true);

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'developer_starter_pro_update_appointment_status',
						nonce: '<?php echo esc_js( $nonce ); ?>',
						id: id,
						status: 'rescheduled',
						date: date,
						time: time
					},
					success: function(response) {
						if (response.success) {
							// Update badge
							var $badge = $('#status-badge-' + id);
							$badge.text('Rescheduled');
							$badge.removeClass('pending approved confirmed rescheduled completed cancelled rejected').addClass('rescheduled');

							// Update date and time text in row
							var formattedDate = new Date(date).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
							// Format time (12h format)
							var timeParts = time.split(':');
							var hour = parseInt(timeParts[0], 10);
							var min = timeParts[1];
							var ampm = hour >= 12 ? 'PM' : 'AM';
							var hour12 = hour % 12;
							hour12 = hour12 ? hour12 : 12;
							var formattedTime = hour12 + ':' + min + ' ' + ampm;

							var $row = $('#appointment-row-' + id);
							$row.find('td:nth-child(4)').html('<strong>' + formattedDate + '</strong>');
							$row.find('td:nth-child(5) .badge').text(formattedTime);

							// Update action buttons
							var actionsHtml = 
								'<button type="button" class="button action-btn complete-btn" style="background:#10b981; border-color:#10b981; color:#fff;" data-id="' + id + '" data-status="completed"><?php esc_html_e( 'Complete', 'developer-starter-pro' ); ?></button> ' +
								'<button type="button" class="button action-btn reschedule-toggle-btn" data-id="' + id + '"><?php esc_html_e( 'Reschedule', 'developer-starter-pro' ); ?></button> ' +
								'<button type="button" class="button action-btn delete-btn" style="color:#64748b;" data-id="' + id + '" data-status="cancelled"><?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?></button>';
							$row.find('.appointment-actions').html(actionsHtml);

							$('#reschedule-row-' + id).hide();
						} else {
							alert(response.data.message || 'Error occurred.');
						}
						$btn.prop('disabled', false);
					},
					error: function() {
						alert('Server request failed.');
						$btn.prop('disabled', false);
					}
				});
			});

			// Standard status action handler
			$(document).on('click', '.action-btn', function() {
				var $btn = $(this);
				var id = $btn.data('id');
				var status = $btn.data('status');

				if ( ! status ) return;

				if ( 'cancelled' === status && ! confirm('<?php esc_html_e( 'Are you sure you want to cancel this appointment?', 'developer-starter-pro' ); ?>') ) {
					return;
				}

				$btn.prop('disabled', true);

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'developer_starter_pro_update_appointment_status',
						nonce: '<?php echo esc_js( $nonce ); ?>',
						id: id,
						status: status
					},
					success: function(response) {
						if (response.success) {
							// Update badge
							var $badge = $('#status-badge-' + id);
							var label = status.charAt(0).toUpperCase() + status.slice(1);
							if ('confirmed' === status) label = 'Confirmed';
							$badge.text(label);
							$badge.removeClass('pending approved confirmed rescheduled completed cancelled rejected').addClass(status);

							// Update action buttons
							var $row = $('#appointment-row-' + id);
							if ('confirmed' === status) {
								var actionsHtml = 
									'<button type="button" class="button action-btn complete-btn" style="background:#10b981; border-color:#10b981; color:#fff;" data-id="' + id + '" data-status="completed"><?php esc_html_e( 'Complete', 'developer-starter-pro' ); ?></button> ' +
									'<button type="button" class="button action-btn reschedule-toggle-btn" data-id="' + id + '"><?php esc_html_e( 'Reschedule', 'developer-starter-pro' ); ?></button> ' +
									'<button type="button" class="button action-btn delete-btn" style="color:#64748b;" data-id="' + id + '" data-status="cancelled"><?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?></button>';
								$row.find('.appointment-actions').html(actionsHtml);
							} else if ('completed' === status || 'cancelled' === status || 'rejected' === status) {
								$row.find('.appointment-actions').fadeOut(200, function() { $(this).html(''); });
							}
						} else {
							alert(response.data.message || 'Error occurred.');
						}
						$btn.prop('disabled', false);
					},
					error: function() {
						alert('Server request failed.');
						$btn.prop('disabled', false);
					}
				});
			});
		});
		</script>

		<style>
		.developer-starter-pro-slide-status.pending { background: #fef3c7; color: #d97706; }
		.developer-starter-pro-slide-status.confirmed { background: #d1fae5; color: #065f46; }
		.developer-starter-pro-slide-status.approved { background: #d1fae5; color: #065f46; }
		.developer-starter-pro-slide-status.rescheduled { background: #e0f2fe; color: #0369a1; }
		.developer-starter-pro-slide-status.rejected { background: #fee2e2; color: #991b1b; }
		.developer-starter-pro-slide-status.completed { background: #dbeafe; color: #1e40af; }
		.developer-starter-pro-slide-status.cancelled { background: #f1f5f9; color: #475569; }
		.developer-starter-pro-slide-status {
			display: inline-block;
			padding: 4px 12px;
			border-radius: 12px;
			font-size: 0.8125rem;
			font-weight: 600;
		}
		.wp-list-table {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
		}
		</style>
		<?php
	}

	/**
	 * AJAX Update Status handler.
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

		$allowed_statuses = array( 'approved', 'confirmed', 'rejected', 'rescheduled', 'completed', 'cancelled' );
		if ( ! in_array( $status, $allowed_statuses, true ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid status value.', 'developer-starter-pro' ) ) );
		}

		// Fetch current status before updating
		$old_status = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM $table_name WHERE id = %d", $id ) );

		$update_data = array( 'status' => $status );
		$update_format = array( '%s' );

		$new_date = sanitize_text_field( $_POST['date'] ?? '' );
		$new_time = sanitize_text_field( $_POST['time'] ?? '' );

		if ( ! empty( $new_date ) && ! empty( $new_time ) ) {
			$update_data['booking_date'] = $new_date;
			$update_data['time_slot']    = $new_time;
			$update_format[] = '%s';
			$update_format[] = '%s';
		}

		$updated = $wpdb->update(
			$table_name,
			$update_data,
			array( 'id' => $id ),
			$update_format,
			array( '%d' )
		);

		if ( false !== $updated ) {
			// Trigger hooks
			do_action( 'dentalpro_appointment_status_changed', $id, $old_status, $status );
			wp_send_json_success();
		}

		wp_send_json_error( array( 'message' => esc_html__( 'Error updating record in database.', 'developer-starter-pro' ) ) );
	}

	/**
	 * Export appointments to CSV.
	 */
	public function export_appointments_csv() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'developer-starter-pro' ) );
		}

		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		// Clean output buffer to prevent stray characters
		if ( ob_get_length() ) {
			ob_end_clean();
		}

		// Set response headers for download
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=appointments-export-' . date( 'Y-m-d' ) . '.csv' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		// Open output stream
		$output = fopen( 'php://output', 'w' );

		// CSV Columns Header
		fputcsv( $output, array(
			__( 'ID', 'developer-starter-pro' ),
			__( 'Patient Name', 'developer-starter-pro' ),
			__( 'Patient Phone', 'developer-starter-pro' ),
			__( 'Patient Email', 'developer-starter-pro' ),
			__( 'Doctor Name', 'developer-starter-pro' ),
			__( 'Service Name', 'developer-starter-pro' ),
			__( 'Booking Date', 'developer-starter-pro' ),
			__( 'Time Slot', 'developer-starter-pro' ),
			__( 'Status', 'developer-starter-pro' ),
			__( 'Notes', 'developer-starter-pro' ),
			__( 'Created At', 'developer-starter-pro' )
		) );

		// Query all appointments from database
		$appointments = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY booking_date DESC, time_slot ASC" );

		if ( ! empty( $appointments ) ) {
			foreach ( $appointments as $apt ) {
				$doc_name = get_the_title( $apt->doctor_id );
				$srv_name = get_the_title( $apt->service_id );
				
				fputcsv( $output, array(
					$apt->id,
					$apt->patient_name,
					$apt->patient_phone,
					$apt->patient_email,
					$doc_name,
					$srv_name,
					$apt->booking_date,
					$apt->time_slot,
					ucfirst( $apt->status ),
					$apt->notes,
					$apt->created_at
				) );
			}
		}

		fclose( $output );
		exit;
	}
}
