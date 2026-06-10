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

		// Handle status filters.
		$filter_status = sanitize_text_field( $_GET['status'] ?? '' );
		$where_clause = "1=1";
		if ( in_array( $filter_status, array( 'pending', 'approved', 'completed', 'cancelled' ), true ) ) {
			$where_clause = $wpdb->prepare( "status = %s", $filter_status );
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

			<div class="developer-starter-pro-admin-content" style="margin-top:20px;">
				
				<!-- Quick Filters -->
				<ul class="subsubsub">
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>" class="<?php echo empty( $filter_status ) ? 'current' : ''; ?>"><?php esc_html_e( 'All', 'developer-starter-pro' ); ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=pending" class="<?php echo 'pending' === $filter_status ? 'current' : ''; ?>"><?php esc_html_e( 'Pending', 'developer-starter-pro' ); ?></a> |</li>
					<li><a href="?page=<?php echo esc_attr( $this->page_slug ); ?>&status=approved" class="<?php echo 'approved' === $filter_status ? 'current' : ''; ?>"><?php esc_html_e( 'Approved', 'developer-starter-pro' ); ?></a> |</li>
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
												<button type="button" class="button button-primary action-btn approve-btn" data-id="<?php echo intval( $apt->id ); ?>" data-status="approved">
													<?php esc_html_e( 'Approve', 'developer-starter-pro' ); ?>
												</button>
											<?php endif; ?>
											<?php if ( 'approved' === $apt->status ) : ?>
												<button type="button" class="button action-btn complete-btn" style="background: #10b981; border-color: #10b981; color:#fff;" data-id="<?php echo intval( $apt->id ); ?>" data-status="completed">
													<?php esc_html_e( 'Done', 'developer-starter-pro' ); ?>
												</button>
											<?php endif; ?>
											<?php if ( 'cancelled' !== $apt->status && 'completed' !== $apt->status ) : ?>
												<button type="button" class="button action-btn delete-btn" style="color: #ef4444;" data-id="<?php echo intval( $apt->id ); ?>" data-status="cancelled">
													<?php esc_html_e( 'Cancel', 'developer-starter-pro' ); ?>
												</button>
											<?php endif; ?>
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
			$('.action-btn').on('click', function() {
				var $btn = $(this);
				var id = $btn.data('id');
				var status = $btn.data('status');

				if ( 'cancelled' === status && ! confirm('<?php esc_html_e( 'Are you sure you want to cancel this appointment?', 'developer-starter-pro' ); ?>') ) {
					return;
				}

				$btn.prop('disabled', true).addClass('loading');

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
							// Update badge text and classes
							var $badge = $('#status-badge-' + id);
							$badge.text(status.charAt(0).toUpperCase() + status.slice(1));
							$badge.removeClass('pending approved completed cancelled').addClass(status);

							// Update layout or hide button
							if ('approved' === status) {
								$btn.replaceWith('<button type="button" class="button action-btn complete-btn" style="background:#10b981; border-color:#10b981; color:#fff;" data-id="' + id + '" data-status="completed"><?php esc_html_e( 'Done', 'developer-starter-pro' ); ?></button>');
								// Rebind complete button click
								bindActions();
							} else if ('completed' === status || 'cancelled' === status) {
								$('#appointment-row-' + id + ' .action-btn').fadeOut(200, function() { $(this).remove(); });
							}
						} else {
							alert(response.data.message || 'Error occurred.');
							$btn.prop('disabled', false).removeClass('loading');
						}
					},
					error: function() {
						alert('Server request failed.');
						$btn.prop('disabled', false).removeClass('loading');
					}
				});
			});

			function bindActions() {
				// Prevent double trigger on dynamically replaced buttons
				$('.complete-btn').off('click').on('click', function() {
					var $btn = $(this);
					var id = $btn.data('id');
					var status = $btn.data('status');

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
								var $badge = $('#status-badge-' + id);
								$badge.text('Completed');
								$badge.removeClass('pending approved completed cancelled').addClass('completed');
								$('#appointment-row-' + id + ' .action-btn').fadeOut(200, function() { $(this).remove(); });
							} else {
								alert(response.data.message);
								$btn.prop('disabled', false);
							}
						}
					});
				});
			}
			bindActions();
		});
		</script>

		<style>
		.developer-starter-pro-slide-status.pending { background: #fef3c7; color: #d97706; }
		.developer-starter-pro-slide-status.approved { background: #d1fae5; color: #065f46; }
		.developer-starter-pro-slide-status.completed { background: #dbeafe; color: #1e40af; }
		.developer-starter-pro-slide-status.cancelled { background: #fef2f2; color: #991b1b; }
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

		if ( ! in_array( $status, array( 'approved', 'completed', 'cancelled' ), true ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid status value.', 'developer-starter-pro' ) ) );
		}

		$updated = $wpdb->update(
			$table_name,
			array( 'status' => $status ),
			array( 'id' => $id ),
			array( '%s' ),
			array( '%d' )
		);

		if ( false !== $updated ) {
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
