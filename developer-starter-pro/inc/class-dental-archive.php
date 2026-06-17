<?php
/**
 * Database Archive & Auto-Cleanup System
 *
 * Handles automatic archiving (CSV export + deletion) of old appointment records
 * via WP-Cron monthly schedule, and provides manual cleanup via admin AJAX.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Archive {

	/**
	 * Constructor — register hooks.
	 */
	public function __construct() {
		// WP-Cron monthly cleanup callback
		add_action( 'dentalpro_monthly_cleanup_cron', array( $this, 'auto_cleanup' ) );

		// AJAX handlers for manual cleanup
		add_action( 'wp_ajax_dentalpro_manual_cleanup', array( $this, 'ajax_manual_cleanup' ) );
		add_action( 'wp_ajax_dentalpro_download_archive', array( $this, 'ajax_download_archive' ) );
	}

	/**
	 * WP-Cron: Automatically cleanup old records monthly.
	 */
	public function auto_cleanup() {
		$options = developer_starter_pro_get_all_options();

		$completed_months = ! empty( $options['archive_completed_months'] ) ? intval( $options['archive_completed_months'] ) : 12;
		$cancelled_months = ! empty( $options['archive_cancelled_months'] ) ? intval( $options['archive_cancelled_months'] ) : 6;

		if ( $completed_months > 0 ) {
			$records = $this->get_old_records( array( 'completed' ), $completed_months );
			if ( ! empty( $records ) ) {
				$this->export_to_csv( $records, 'auto-completed' );
				$this->delete_old_records( array( 'completed' ), $completed_months );
			}
		}

		if ( $cancelled_months > 0 ) {
			$records = $this->get_old_records( array( 'cancelled', 'rejected', 'no_show' ), $cancelled_months );
			if ( ! empty( $records ) ) {
				$this->export_to_csv( $records, 'auto-cancelled' );
				$this->delete_old_records( array( 'cancelled', 'rejected', 'no_show' ), $cancelled_months );
			}
		}

		error_log( 'DentalPro: Monthly auto-cleanup completed at ' . current_time( 'mysql' ) );
	}

	/**
	 * Get old records eligible for archiving.
	 *
	 * @param array $statuses   Status values to filter.
	 * @param int   $months     How many months back to archive.
	 * @return array
	 */
	public function get_old_records( $statuses, $months ) {
		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		if ( empty( $statuses ) || $months <= 0 ) {
			return array();
		}

		$cutoff = date( 'Y-m-d H:i:s', strtotime( "-{$months} months" ) );
		$placeholders = implode( ', ', array_fill( 0, count( $statuses ), '%s' ) );

		$params = array_merge( $statuses, array( $cutoff ) );

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $table_name WHERE status IN ($placeholders) AND created_at < %s ORDER BY created_at ASC",
				...$params
			),
			ARRAY_A
		);
	}

	/**
	 * Delete old records from the DB.
	 *
	 * @param array $statuses Status values to delete.
	 * @param int   $months   How many months back to delete.
	 * @return int  Number of deleted rows.
	 */
	public function delete_old_records( $statuses, $months ) {
		global $wpdb;
		$table_name = Developer_Starter_Pro_Booking::get_table_name();

		if ( empty( $statuses ) || $months <= 0 ) {
			return 0;
		}

		$cutoff = date( 'Y-m-d H:i:s', strtotime( "-{$months} months" ) );
		$placeholders = implode( ', ', array_fill( 0, count( $statuses ), '%s' ) );

		$params = array_merge( $statuses, array( $cutoff ) );

		return $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $table_name WHERE status IN ($placeholders) AND created_at < %s",
				...$params
			)
		);
	}

	/**
	 * Export records to a CSV file in the uploads directory.
	 *
	 * @param array  $records  Array of record rows.
	 * @param string $prefix   Filename prefix.
	 * @return string|false    File path on success, false on failure.
	 */
	public function export_to_csv( $records, $prefix = 'archive' ) {
		if ( empty( $records ) ) {
			return false;
		}

		$wp_uploads = wp_upload_dir();
		$archive_dir = $wp_uploads['basedir'] . '/dentalpro-archives';

		if ( ! file_exists( $archive_dir ) ) {
			wp_mkdir_p( $archive_dir );
			// Protect the directory from direct web access
			file_put_contents( $archive_dir . '/.htaccess', "deny from all\n" );
			file_put_contents( $archive_dir . '/index.php', "<?php // Silence is golden\n" );
		}

		$filename = $prefix . '-' . date( 'Y-m-d-His' ) . '.csv';
		$filepath = $archive_dir . '/' . $filename;

		$handle = fopen( $filepath, 'w' );
		if ( ! $handle ) {
			return false;
		}

		// Add UTF-8 BOM for Excel compatibility
		fwrite( $handle, "\xEF\xBB\xBF" );

		// Write header row
		$headers = array_keys( $records[0] );
		fputcsv( $handle, $headers );

		// Write data rows
		foreach ( $records as $row ) {
			fputcsv( $handle, $row );
		}

		fclose( $handle );

		return array(
			'path'     => $filepath,
			'filename' => $filename,
			'url'      => $wp_uploads['baseurl'] . '/dentalpro-archives/' . $filename,
		);
	}

	/**
	 * AJAX: Manual cleanup triggered from admin panel.
	 */
	public function ajax_manual_cleanup() {
		check_ajax_referer( 'dentalpro_archive_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'developer-starter-pro' ) ) );
		}

		$options = developer_starter_pro_get_all_options();

		$completed_months = ! empty( $options['archive_completed_months'] ) ? intval( $options['archive_completed_months'] ) : 12;
		$cancelled_months = ! empty( $options['archive_cancelled_months'] ) ? intval( $options['archive_cancelled_months'] ) : 6;

		$total_deleted = 0;
		$csv_files     = array();

		// Archive completed
		if ( $completed_months > 0 ) {
			$records = $this->get_old_records( array( 'completed' ), $completed_months );
			if ( ! empty( $records ) ) {
				$csv = $this->export_to_csv( $records, 'completed' );
				if ( $csv ) {
					$csv_files[] = $csv;
				}
				$deleted = $this->delete_old_records( array( 'completed' ), $completed_months );
				$total_deleted += (int) $deleted;
			}
		}

		// Archive cancelled/rejected/no-show
		if ( $cancelled_months > 0 ) {
			$records = $this->get_old_records( array( 'cancelled', 'rejected', 'no_show' ), $cancelled_months );
			if ( ! empty( $records ) ) {
				$csv = $this->export_to_csv( $records, 'cancelled' );
				if ( $csv ) {
					$csv_files[] = $csv;
				}
				$deleted = $this->delete_old_records( array( 'cancelled', 'rejected', 'no_show' ), $cancelled_months );
				$total_deleted += (int) $deleted;
			}
		}

		// Store CSV paths in transient for download (expire in 1 hour)
		set_transient( 'dentalpro_archive_csv_files', $csv_files, HOUR_IN_SECONDS );

		$download_links = array_map( function( $csv ) {
			return array(
				'filename' => $csv['filename'],
				'url'      => add_query_arg(
					array(
						'action'   => 'dentalpro_download_archive',
						'filename' => rawurlencode( $csv['filename'] ),
						'nonce'    => wp_create_nonce( 'dentalpro_download_nonce' ),
					),
					admin_url( 'admin-ajax.php' )
				),
			);
		}, $csv_files );

		wp_send_json_success( array(
			'deleted'        => $total_deleted,
			'download_links' => $download_links,
			'message'        => sprintf(
				_n(
					'%d appointment record archived and deleted.',
					'%d appointment records archived and deleted.',
					$total_deleted,
					'developer-starter-pro'
				),
				$total_deleted
			),
		) );
	}

	/**
	 * AJAX: Serve the CSV archive file for download.
	 */
	public function ajax_download_archive() {
		check_ajax_referer( 'dentalpro_download_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'Permission denied.', 'developer-starter-pro' ) );
		}

		$filename = isset( $_GET['filename'] ) ? sanitize_file_name( $_GET['filename'] ) : '';
		if ( empty( $filename ) ) {
			wp_die( __( 'Invalid filename.', 'developer-starter-pro' ) );
		}

		$wp_uploads = wp_upload_dir();
		$filepath   = $wp_uploads['basedir'] . '/dentalpro-archives/' . $filename;

		if ( ! file_exists( $filepath ) ) {
			wp_die( __( 'File not found or expired.', 'developer-starter-pro' ) );
		}

		// Serve file
		header( 'Content-Type: text/csv; charset=UTF-8' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'Content-Length: ' . filesize( $filepath ) );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
		readfile( $filepath );

		// Delete the file after serving (one-time download)
		unlink( $filepath );
		exit;
	}

	/**
	 * Get count of archivable records (preview before cleanup).
	 *
	 * @return array
	 */
	public function get_cleanup_preview() {
		$options = developer_starter_pro_get_all_options();

		$completed_months = ! empty( $options['archive_completed_months'] ) ? intval( $options['archive_completed_months'] ) : 12;
		$cancelled_months = ! empty( $options['archive_cancelled_months'] ) ? intval( $options['archive_cancelled_months'] ) : 6;

		$completed_count = $completed_months > 0
			? count( $this->get_old_records( array( 'completed' ), $completed_months ) )
			: 0;

		$cancelled_count = $cancelled_months > 0
			? count( $this->get_old_records( array( 'cancelled', 'rejected', 'no_show' ), $cancelled_months ) )
			: 0;

		return array(
			'completed' => $completed_count,
			'cancelled' => $cancelled_count,
			'total'     => $completed_count + $cancelled_count,
		);
	}
}
