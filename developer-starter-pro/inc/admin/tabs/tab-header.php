<?php
/**
 * Tab: header
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Header Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the header layout and behavior.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label><?php esc_html_e( 'Header Style', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-header-styles">
							<?php
							$header_styles = array(
								'1' => esc_html__( 'Classic — Logo left, menu right', 'developer-starter-pro' ),
								'2' => esc_html__( 'Centered — Logo center, menu below', 'developer-starter-pro' ),
								'3' => esc_html__( 'Full Width — Top bar + main header', 'developer-starter-pro' ),
								'4' => esc_html__( 'Transparent — Overlay on hero', 'developer-starter-pro' ),
							);
							foreach ( $header_styles as $value => $label ) : ?>
								<label class="developer-starter-pro-radio-card <?php echo $options['header_style'] === $value ? 'selected' : ''; ?>">
									<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[header_style]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $options['header_style'], $value ); ?>>
									<span class="developer-starter-pro-radio-card-label">
										<strong><?php echo esc_html( sprintf( __( 'Style %s', 'developer-starter-pro' ), $value ) ); ?></strong>
										<span><?php echo esc_html( $label ); ?></span>
									</span>
								</label>
							<?php endforeach; ?>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="header_sticky"><?php esc_html_e( 'Sticky Header', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="header_sticky" name="<?php echo esc_attr( $this->option_name ); ?>[header_sticky]" value="1" <?php checked( $options['header_sticky'], '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Enable sticky header on scroll', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
			</table>
		</div>
