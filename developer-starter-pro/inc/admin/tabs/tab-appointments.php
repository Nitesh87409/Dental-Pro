<?php
/**
 * Tab: appointments
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
$mode = isset( $options['appointment_approval_mode'] ) ? $options['appointment_approval_mode'] : 'automatic';
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Appointment Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the booking approval mode.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><?php esc_html_e( 'Appointment Approval Mode', 'developer-starter-pro' ); ?></th>
					<td>
						<fieldset>
							<label style="display:block; margin-bottom:15px;">
								<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[appointment_approval_mode]" value="automatic" <?php checked( $mode, 'automatic' ); ?>>
								<strong><?php esc_html_e( 'Automatic Approval', 'developer-starter-pro' ); ?></strong>
								<p class="description" style="margin-left: 24px; margin-top:4px;"><?php esc_html_e( 'Appointments are automatically confirmed immediately. Patients receive instant confirmations, and the status is set to "Confirmed".', 'developer-starter-pro' ); ?></p>
							</label>
							<label style="display:block;">
								<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[appointment_approval_mode]" value="manual" <?php checked( $mode, 'manual' ); ?>>
								<strong><?php esc_html_e( 'Manual Approval', 'developer-starter-pro' ); ?></strong>
								<p class="description" style="margin-left: 24px; margin-top:4px;"><?php esc_html_e( 'Appointments remain "Pending" upon submission. Admin receives notification to Approve, Reject, Reschedule, or Cancel, and the patient is notified of status changes.', 'developer-starter-pro' ); ?></p>
							</label>
						</fieldset>
					</td>
				</tr>
			</table>

			<h2 style="margin-top: 30px;"><?php esc_html_e( 'Google Review / Rating Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the Google Review Link that will be sent to patients when their appointment is completed.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="google_review_url"><?php esc_html_e( 'Google Review URL', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="url" id="google_review_url" name="<?php echo esc_attr( $this->option_name ); ?>[google_review_url]" value="<?php echo esc_url( isset( $options['google_review_url'] ) ? $options['google_review_url'] : '' ); ?>" class="large-text" placeholder="https://g.page/r/your-clinic-id/review" style="width:100%; max-width:600px;">
						<p class="description"><?php esc_html_e( 'Enter your Google Business review link. Patients will receive this link to rate their visit upon completion.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
			</table>

			<h2 style="margin-top: 30px;"><?php esc_html_e( 'SMS Notification Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure real-time SMS notifications for patient appointments.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="twilio_sms_enabled"><?php esc_html_e( 'Enable SMS Notifications', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="twilio_sms_enabled" name="<?php echo esc_attr( $this->option_name ); ?>[twilio_sms_enabled]" value="1" <?php checked( isset( $options['twilio_sms_enabled'] ) ? $options['twilio_sms_enabled'] : '0', '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Send automatic SMS on booking and confirmation', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
				<tr class="sms-toggle-dep">
					<th><label for="sms_provider"><?php esc_html_e( 'SMS Gateway Provider', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="sms_provider" name="<?php echo esc_attr( $this->option_name ); ?>[sms_provider]">
							<option value="twilio" <?php selected( isset( $options['sms_provider'] ) ? $options['sms_provider'] : 'twilio', 'twilio' ); ?>><?php esc_html_e( 'Twilio API', 'developer-starter-pro' ); ?></option>
							<option value="custom" <?php selected( isset( $options['sms_provider'] ) ? $options['sms_provider'] : 'twilio', 'custom' ); ?>><?php esc_html_e( 'Custom HTTP Gateway (Fast2SMS, MSG91, etc.)', 'developer-starter-pro' ); ?></option>
						</select>
					</td>
				</tr>
				
				<!-- Twilio Gateway Settings -->
				<tbody class="sms-gateway-fields sms-gateway-twilio">
					<tr>
						<th><label for="twilio_sid"><?php esc_html_e( 'Account SID', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="text" id="twilio_sid" name="<?php echo esc_attr( $this->option_name ); ?>[twilio_sid]" value="<?php echo esc_attr( isset( $options['twilio_sid'] ) ? $options['twilio_sid'] : '' ); ?>" class="regular-text" placeholder="ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX">
						</td>
					</tr>
					<tr>
						<th><label for="twilio_auth_token"><?php esc_html_e( 'Auth Token', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="password" id="twilio_auth_token" name="<?php echo esc_attr( $this->option_name ); ?>[twilio_auth_token]" value="<?php echo esc_attr( isset( $options['twilio_auth_token'] ) ? $options['twilio_auth_token'] : '' ); ?>" class="regular-text" placeholder="••••••••••••••••••••••••••••••••">
						</td>
					</tr>
					<tr>
						<th><label for="twilio_from_number"><?php esc_html_e( 'Twilio Phone Number', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="text" id="twilio_from_number" name="<?php echo esc_attr( $this->option_name ); ?>[twilio_from_number]" value="<?php echo esc_attr( isset( $options['twilio_from_number'] ) ? $options['twilio_from_number'] : '' ); ?>" class="regular-text" placeholder="+1234567890">
							<p class="description"><?php esc_html_e( 'Twilio phone number or Sender ID in E.164 format.', 'developer-starter-pro' ); ?></p>
						</td>
					</tr>
				</tbody>

				<!-- Custom HTTP Gateway Settings -->
				<tbody class="sms-gateway-fields sms-gateway-custom" style="display:none;">
					<tr>
						<th><label for="sms_custom_url"><?php esc_html_e( 'API URL', 'developer-starter-pro' ); ?></label></th>
						<td>
							<input type="text" id="sms_custom_url" name="<?php echo esc_attr( $this->option_name ); ?>[sms_custom_url]" value="<?php echo esc_attr( isset( $options['sms_custom_url'] ) ? $options['sms_custom_url'] : '' ); ?>" class="large-text" placeholder="https://api.provider.com/send?to={phone}&msg={message}" style="width:100%; max-width:600px;">
							<p class="description"><?php esc_html_e( 'The HTTP/HTTPS API endpoint URL. Supported placeholders: {phone} (with + sign), {phone_no_plus} (without + sign), {message} (text message).', 'developer-starter-pro' ); ?></p>
						</td>
					</tr>
					<tr>
						<th><label for="sms_custom_method"><?php esc_html_e( 'HTTP Method', 'developer-starter-pro' ); ?></label></th>
						<td>
							<select id="sms_custom_method" name="<?php echo esc_attr( $this->option_name ); ?>[sms_custom_method]">
								<option value="GET" <?php selected( isset( $options['sms_custom_method'] ) ? $options['sms_custom_method'] : 'GET', 'GET' ); ?>><?php esc_html_e( 'GET Request', 'developer-starter-pro' ); ?></option>
								<option value="POST_FORM" <?php selected( isset( $options['sms_custom_method'] ) ? $options['sms_custom_method'] : 'POST_FORM', 'POST_FORM' ); ?>><?php esc_html_e( 'POST Request (Form Data / URL encoded)', 'developer-starter-pro' ); ?></option>
								<option value="POST_JSON" <?php selected( isset( $options['sms_custom_method'] ) ? $options['sms_custom_method'] : 'POST_JSON', 'POST_JSON' ); ?>><?php esc_html_e( 'POST Request (JSON Payload)', 'developer-starter-pro' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="sms_custom_headers"><?php esc_html_e( 'Custom HTTP Headers', 'developer-starter-pro' ); ?></label></th>
						<td>
							<textarea id="sms_custom_headers" name="<?php echo esc_attr( $this->option_name ); ?>[sms_custom_headers]" rows="3" class="large-text" placeholder="Authorization: Bearer YOUR_API_KEY&#10;api-key: 123456" style="width:100%; max-width:600px;"><?php echo esc_textarea( isset( $options['sms_custom_headers'] ) ? $options['sms_custom_headers'] : '' ); ?></textarea>
							<p class="description"><?php esc_html_e( 'Enter custom headers, one header per line. e.g. "Authorization: Bearer KEY". Supports placeholders.', 'developer-starter-pro' ); ?></p>
						</td>
					</tr>
					<tr>
						<th><label for="sms_custom_body"><?php esc_html_e( 'Request Body / Parameters', 'developer-starter-pro' ); ?></label></th>
						<td>
							<textarea id="sms_custom_body" name="<?php echo esc_attr( $this->option_name ); ?>[sms_custom_body]" rows="3" class="large-text" placeholder="route=q&message={message}&numbers={phone_no_plus}" style="width:100%; max-width:600px;"><?php echo esc_textarea( isset( $options['sms_custom_body'] ) ? $options['sms_custom_body'] : '' ); ?></textarea>
							<p class="description"><?php esc_html_e( 'Query string format (e.g. param1=val1&param2={message}) or raw JSON depending on selected method. For GET requests, these are appended as query arguments.', 'developer-starter-pro' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<?php // ---- Archive & Cleanup Section ---- ?>
		<div class="developer-starter-pro-settings-section" style="margin-top:30px; border-top: 2px solid #e0e0e0; padding-top: 24px;">
			<h2 style="display:flex; align-items:center; gap:10px;">
				<span style="font-size:22px;">🗄️</span>
				<?php esc_html_e( 'Database Archive & Cleanup', 'developer-starter-pro' ); ?>
			</h2>
			<p class="description">
				<?php esc_html_e( 'Old appointment records are automatically archived to CSV and deleted monthly. Configure retention periods below. Active appointments (Pending / Confirmed) are never deleted.', 'developer-starter-pro' ); ?>
			</p>

			<table class="form-table">
				<tr>
					<th><label for="archive_completed_months"><?php esc_html_e( 'Keep Completed Appointments For', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="archive_completed_months" name="<?php echo esc_attr( $this->option_name ); ?>[archive_completed_months]">
							<?php
							$completed_val = isset( $options['archive_completed_months'] ) ? $options['archive_completed_months'] : '12';
							$completed_options = array( '3' => '3 Months', '6' => '6 Months', '12' => '12 Months (Recommended)', '24' => '24 Months', '0' => 'Never Delete' );
							foreach ( $completed_options as $val => $label ) {
								printf( '<option value="%s" %s>%s</option>', esc_attr( $val ), selected( $completed_val, $val, false ), esc_html( $label ) );
							}
							?>
						</select>
						<p class="description"><?php esc_html_e( 'Completed appointments older than this will be exported to CSV and deleted automatically each month.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="archive_cancelled_months"><?php esc_html_e( 'Keep Cancelled / Rejected Records For', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="archive_cancelled_months" name="<?php echo esc_attr( $this->option_name ); ?>[archive_cancelled_months]">
							<?php
							$cancelled_val = isset( $options['archive_cancelled_months'] ) ? $options['archive_cancelled_months'] : '6';
							$cancelled_options = array( '1' => '1 Month', '3' => '3 Months', '6' => '6 Months (Recommended)', '12' => '12 Months', '0' => 'Never Delete' );
							foreach ( $cancelled_options as $val => $label ) {
								printf( '<option value="%s" %s>%s</option>', esc_attr( $val ), selected( $cancelled_val, $val, false ), esc_html( $label ) );
							}
							?>
						</select>
						<p class="description"><?php esc_html_e( 'Cancelled, rejected, and no-show appointments older than this will be exported to CSV and deleted.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
			</table>

			<?php
			// Show live preview count if archive class is loaded
			if ( class_exists( 'Developer_Starter_Pro_Archive' ) ) {
				$archive     = new Developer_Starter_Pro_Archive();
				$preview     = $archive->get_cleanup_preview();
				$total_recs  = $preview['total'];
				$badge_color = $total_recs > 0 ? '#d63638' : '#00a32a';
				?>
				<div id="dentalpro-archive-preview" style="background:#f8f9fa; border:1px solid #ddd; border-radius:8px; padding:16px 20px; margin:20px 0; display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
					<div style="flex:1; min-width:200px;">
						<strong><?php esc_html_e( 'Records Eligible for Cleanup:', 'developer-starter-pro' ); ?></strong><br>
						<span style="font-size:13px; color:#666;">
							✅ <?php printf( esc_html__( 'Completed: %d records', 'developer-starter-pro' ), $preview['completed'] ); ?><br>
							❌ <?php printf( esc_html__( 'Cancelled/Rejected: %d records', 'developer-starter-pro' ), $preview['cancelled'] ); ?>
						</span>
					</div>
					<div>
						<span style="background:<?php echo esc_attr( $badge_color ); ?>; color:#fff; padding:4px 12px; border-radius:20px; font-weight:600; font-size:14px;">
							<?php printf( esc_html__( 'Total: %d', 'developer-starter-pro' ), $total_recs ); ?>
						</span>
					</div>
				</div>
				<?php
			}
			?>

			<div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-top:10px;">
				<button type="button" id="dentalpro-manual-cleanup-btn" class="button button-primary"
					style="background:#d63638; border-color:#d63638; font-weight:600; padding:6px 18px; height:auto; font-size:14px;"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'dentalpro_archive_nonce' ) ); ?>">
					🗑️ <?php esc_html_e( 'Run Manual Cleanup Now', 'developer-starter-pro' ); ?>
				</button>
				<span id="dentalpro-cleanup-status" style="font-size:13px;"></span>
			</div>

			<div id="dentalpro-cleanup-download" style="margin-top:14px; display:none;">
				<strong><?php esc_html_e( 'CSV Backup Files:', 'developer-starter-pro' ); ?></strong>
				<ul id="dentalpro-cleanup-links" style="margin-top:6px;"></ul>
			</div>

			<p class="description" style="margin-top:12px; font-style:italic; color:#888;">
				⚠️ <?php esc_html_e( 'Manual cleanup will permanently delete matching records. CSV files are generated as backup before deletion and are available for download for 1 hour.', 'developer-starter-pro' ); ?>
			</p>

			<script>
			(function() {
				var btn = document.getElementById('dentalpro-manual-cleanup-btn');
				if ( ! btn ) return;
				btn.addEventListener('click', function() {
					if ( ! confirm('<?php echo esc_js( __( 'Are you sure? This will permanently delete old records (CSV backup will be created). Continue?', 'developer-starter-pro' ) ); ?>') ) {
						return;
					}
					var status = document.getElementById('dentalpro-cleanup-status');
					status.innerHTML = '⏳ <?php echo esc_js( __( 'Running cleanup...', 'developer-starter-pro' ) ); ?>';
					btn.disabled = true;

					var formData = new FormData();
					formData.append('action', 'dentalpro_manual_cleanup');
					formData.append('nonce', btn.getAttribute('data-nonce'));

					fetch(ajaxurl, { method: 'POST', body: formData })
						.then(function(r) { return r.json(); })
						.then(function(data) {
							if ( data.success ) {
								status.innerHTML = '✅ ' + data.data.message;
								var dl = document.getElementById('dentalpro-cleanup-download');
								var ul = document.getElementById('dentalpro-cleanup-links');
								ul.innerHTML = '';
								if ( data.data.download_links && data.data.download_links.length > 0 ) {
									dl.style.display = 'block';
									data.data.download_links.forEach(function(link) {
										var li = document.createElement('li');
										li.innerHTML = '📥 <a href="' + link.url + '" target="_blank" style="font-weight:600;">' + link.filename + '</a>';
										ul.appendChild(li);
									});
								} else {
									dl.style.display = 'none';
								}
							} else {
								status.innerHTML = '❌ ' + (data.data ? data.data.message : '<?php echo esc_js( __( 'Error occurred.', 'developer-starter-pro' ) ); ?>');
							}
							btn.disabled = false;
						})
						.catch(function() {
							status.innerHTML = '❌ <?php echo esc_js( __( 'Request failed.', 'developer-starter-pro' ) ); ?>';
							btn.disabled = false;
						});
				});
			})();
			</script>
		</div>
