<?php
/**
 * Tab: stats
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Homepage Stats Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the key statistics displayed in the stats section on your homepage.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<!-- Stat 1 -->
				<tr style="border-bottom: 1px solid #eee;">
					<th colspan="2" style="padding-left: 0; padding-top: 20px;"><h3><?php esc_html_e( 'Stat Card 1', 'developer-starter-pro' ); ?></h3></th>
				</tr>
				<tr>
					<th><label for="stat1_icon"><?php esc_html_e( 'Icon (Emoji or character)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat1_icon" name="<?php echo esc_attr( $this->option_name ); ?>[stat1_icon]" value="<?php echo esc_attr( isset( $options['stat1_icon'] ) ? $options['stat1_icon'] : '🏆' ); ?>" class="small-text" style="text-align: center;">
					</td>
				</tr>
				<tr>
					<th><label for="stat1_number"><?php esc_html_e( 'Number / Stat Value', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat1_number" name="<?php echo esc_attr( $this->option_name ); ?>[stat1_number]" value="<?php echo esc_attr( isset( $options['stat1_number'] ) ? $options['stat1_number'] : '10+' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="stat1_label"><?php esc_html_e( 'Label / Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat1_label" name="<?php echo esc_attr( $this->option_name ); ?>[stat1_label]" value="<?php echo esc_attr( isset( $options['stat1_label'] ) ? $options['stat1_label'] : 'Years Experience' ); ?>" class="regular-text">
					</td>
				</tr>

				<!-- Stat 2 -->
				<tr style="border-bottom: 1px solid #eee;">
					<th colspan="2" style="padding-left: 0; padding-top: 20px;"><h3><?php esc_html_e( 'Stat Card 2', 'developer-starter-pro' ); ?></h3></th>
				</tr>
				<tr>
					<th><label for="stat2_icon"><?php esc_html_e( 'Icon (Emoji or character)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat2_icon" name="<?php echo esc_attr( $this->option_name ); ?>[stat2_icon]" value="<?php echo esc_attr( isset( $options['stat2_icon'] ) ? $options['stat2_icon'] : '😊' ); ?>" class="small-text" style="text-align: center;">
					</td>
				</tr>
				<tr>
					<th><label for="stat2_number"><?php esc_html_e( 'Number / Stat Value', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat2_number" name="<?php echo esc_attr( $this->option_name ); ?>[stat2_number]" value="<?php echo esc_attr( isset( $options['stat2_number'] ) ? $options['stat2_number'] : '5000+' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="stat2_label"><?php esc_html_e( 'Label / Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat2_label" name="<?php echo esc_attr( $this->option_name ); ?>[stat2_label]" value="<?php echo esc_attr( isset( $options['stat2_label'] ) ? $options['stat2_label'] : 'Happy Patients' ); ?>" class="regular-text">
					</td>
				</tr>

				<!-- Stat 3 -->
				<tr style="border-bottom: 1px solid #eee;">
					<th colspan="2" style="padding-left: 0; padding-top: 20px;"><h3><?php esc_html_e( 'Stat Card 3', 'developer-starter-pro' ); ?></h3></th>
				</tr>
				<tr>
					<th><label for="stat3_icon"><?php esc_html_e( 'Icon (Emoji or character)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat3_icon" name="<?php echo esc_attr( $this->option_name ); ?>[stat3_icon]" value="<?php echo esc_attr( isset( $options['stat3_icon'] ) ? $options['stat3_icon'] : '👨‍⚕️' ); ?>" class="small-text" style="text-align: center;">
					</td>
				</tr>
				<tr>
					<th><label for="stat3_number"><?php esc_html_e( 'Number / Stat Value', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat3_number" name="<?php echo esc_attr( $this->option_name ); ?>[stat3_number]" value="<?php echo esc_attr( isset( $options['stat3_number'] ) ? $options['stat3_number'] : '50+' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="stat3_label"><?php esc_html_e( 'Label / Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat3_label" name="<?php echo esc_attr( $this->option_name ); ?>[stat3_label]" value="<?php echo esc_attr( isset( $options['stat3_label'] ) ? $options['stat3_label'] : 'Dental Specialists' ); ?>" class="regular-text">
					</td>
				</tr>

				<!-- Stat 4 -->
				<tr style="border-bottom: 1px solid #eee;">
					<th colspan="2" style="padding-left: 0; padding-top: 20px;"><h3><?php esc_html_e( 'Stat Card 4', 'developer-starter-pro' ); ?></h3></th>
				</tr>
				<tr>
					<th><label for="stat4_icon"><?php esc_html_e( 'Icon (Emoji or character)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat4_icon" name="<?php echo esc_attr( $this->option_name ); ?>[stat4_icon]" value="<?php echo esc_attr( isset( $options['stat4_icon'] ) ? $options['stat4_icon'] : '📍' ); ?>" class="small-text" style="text-align: center;">
					</td>
				</tr>
				<tr>
					<th><label for="stat4_number"><?php esc_html_e( 'Number / Stat Value', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat4_number" name="<?php echo esc_attr( $this->option_name ); ?>[stat4_number]" value="<?php echo esc_attr( isset( $options['stat4_number'] ) ? $options['stat4_number'] : '15+' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="stat4_label"><?php esc_html_e( 'Label / Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="stat4_label" name="<?php echo esc_attr( $this->option_name ); ?>[stat4_label]" value="<?php echo esc_attr( isset( $options['stat4_label'] ) ? $options['stat4_label'] : 'Clinic Locations' ); ?>" class="regular-text">
					</td>
				</tr>
			</table>
		</div>
