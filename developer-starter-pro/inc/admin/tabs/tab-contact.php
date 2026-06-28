<?php
/**
 * Tab: contact
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
$working_hours = isset( $options['working_hours'] ) ? $options['working_hours'] : developer_starter_pro_get_default_options()['working_hours'];

		$days = array(
			'monday'    => esc_html__( 'Monday', 'developer-starter-pro' ),
			'tuesday'   => esc_html__( 'Tuesday', 'developer-starter-pro' ),
			'wednesday' => esc_html__( 'Wednesday', 'developer-starter-pro' ),
			'thursday'  => esc_html__( 'Thursday', 'developer-starter-pro' ),
			'friday'    => esc_html__( 'Friday', 'developer-starter-pro' ),
			'saturday'  => esc_html__( 'Saturday', 'developer-starter-pro' ),
			'sunday'    => esc_html__( 'Sunday', 'developer-starter-pro' ),
		);
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Contact & Maps', 'developer-starter-pro' ); ?></h2>

			<table class="form-table">
				<tr>
					<th><label for="google_maps_key"><?php esc_html_e( 'Google Maps API Key', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="google_maps_key" name="<?php echo esc_attr( $this->option_name ); ?>[google_maps_key]" value="<?php echo esc_attr( $options['google_maps_key'] ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Required for Google Maps on the contact page.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="map_embed_code"><?php esc_html_e( 'Google Maps Embed Code / Iframe', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="map_embed_code" name="<?php echo esc_attr( $this->option_name ); ?>[map_embed_code]" rows="4" class="large-text" placeholder="<?php echo esc_attr( '<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' ); ?>"><?php echo esc_textarea( isset( $options['map_embed_code'] ) ? $options['map_embed_code'] : '' ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Paste the full Google Maps iframe embed code here (from Google Maps: Share -> Embed a map -> Copy HTML). If empty, the theme will automatically load a map based on your clinic address, or fall back to the vector map if no address is set.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="emergency_enabled"><?php esc_html_e( 'Emergency Floating Button', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="emergency_enabled" name="<?php echo esc_attr( $this->option_name ); ?>[emergency_enabled]" value="1" <?php checked( isset( $options['emergency_enabled'] ) ? $options['emergency_enabled'] : '1', '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Enable floating Emergency button', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
				<tr>
					<th><label for="emergency_phone"><?php esc_html_e( 'Emergency Phone', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="tel" id="emergency_phone" name="<?php echo esc_attr( $this->option_name ); ?>[emergency_phone]" value="<?php echo esc_attr( $options['emergency_phone'] ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Displayed in the floating emergency call button.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_enabled"><?php esc_html_e( 'WhatsApp Floating Button', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="whatsapp_enabled" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_enabled]" value="1" <?php checked( $options['whatsapp_enabled'], '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Enable floating WhatsApp button', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_number"><?php esc_html_e( 'WhatsApp Number', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="whatsapp_number" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_number]" value="<?php echo esc_attr( $options['whatsapp_number'] ); ?>" class="regular-text" placeholder="e.g., 919876543210">
						<p class="description"><?php esc_html_e( 'Include country code without spaces, + or leading zeros (e.g. 15551234567 or 919876543210).', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_message"><?php esc_html_e( 'WhatsApp Default Message', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="whatsapp_message" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_message]" rows="2" class="large-text"><?php echo esc_textarea( $options['whatsapp_message'] ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Pre-filled message when patient starts a chat.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="whatsapp_position"><?php esc_html_e( 'Button Position', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="whatsapp_position" name="<?php echo esc_attr( $this->option_name ); ?>[whatsapp_position]">
							<option value="right" <?php selected( $options['whatsapp_position'], 'right' ); ?>><?php esc_html_e( 'Bottom Right', 'developer-starter-pro' ); ?></option>
							<option value="left" <?php selected( $options['whatsapp_position'], 'left' ); ?>><?php esc_html_e( 'Bottom Left', 'developer-starter-pro' ); ?></option>
						</select>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Working Hours', 'developer-starter-pro' ); ?></h2>

			<table class="widefat fixed striped developer-starter-pro-working-hours">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Day', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Opening Time', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Closing Time', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Closed?', 'developer-starter-pro' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $days as $day_key => $day_label ) :
					$open   = isset( $working_hours[ $day_key ]['open'] ) ? $working_hours[ $day_key ]['open'] : '';
					$close  = isset( $working_hours[ $day_key ]['close'] ) ? $working_hours[ $day_key ]['close'] : '';
					$closed = isset( $working_hours[ $day_key ]['closed'] ) ? $working_hours[ $day_key ]['closed'] : false;
				?>
					<tr>
						<td><strong><?php echo esc_html( $day_label ); ?></strong></td>
						<td>
							<input type="time" name="<?php echo esc_attr( $this->option_name ); ?>[working_hours][<?php echo esc_attr( $day_key ); ?>][open]" value="<?php echo esc_attr( $open ); ?>">
						</td>
						<td>
							<input type="time" name="<?php echo esc_attr( $this->option_name ); ?>[working_hours][<?php echo esc_attr( $day_key ); ?>][close]" value="<?php echo esc_attr( $close ); ?>">
						</td>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $this->option_name ); ?>[working_hours][<?php echo esc_attr( $day_key ); ?>][closed]" value="1" <?php checked( $closed, true ); ?>>
								<?php esc_html_e( 'Closed', 'developer-starter-pro' ); ?>
							</label>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
