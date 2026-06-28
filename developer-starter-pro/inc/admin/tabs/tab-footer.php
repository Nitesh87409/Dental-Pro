<?php
/**
 * Tab: footer
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Footer Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the footer layout.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label><?php esc_html_e( 'Footer Style', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-header-styles">
							<?php
							$footer_styles = array(
								'1' => esc_html__( '3 Columns — Map, Contact & Quick Links', 'developer-starter-pro' ),
								'2' => esc_html__( '2 Columns — Map & Contact Info', 'developer-starter-pro' ),
								'3' => esc_html__( 'Minimal — 2 Columns (Info & Social Links)', 'developer-starter-pro' ),
							);
							foreach ( $footer_styles as $value => $label ) : ?>
								<label class="developer-starter-pro-radio-card <?php echo $options['footer_style'] === $value ? 'selected' : ''; ?>">
									<input type="radio" name="<?php echo esc_attr( $this->option_name ); ?>[footer_style]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $options['footer_style'], $value ); ?>>
									<span class="developer-starter-pro-radio-card-label">
										<strong><?php echo esc_html( sprintf( __( 'Style %s', 'developer-starter-pro' ), $value ) ); ?></strong>
										<span><?php echo esc_html( $label ); ?></span>
									</span>
								</label>
							<?php endforeach; ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
