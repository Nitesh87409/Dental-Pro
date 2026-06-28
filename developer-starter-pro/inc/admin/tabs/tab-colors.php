<?php
/**
 * Tab: colors
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Color Scheme', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Customize the color scheme of your theme.', 'developer-starter-pro' ); ?></p>

			<!-- Pre-made Skins Library -->
			<div class="developer-starter-pro-skins-library">
				<h3><?php esc_html_e( 'Pre-made Skins Library', 'developer-starter-pro' ); ?></h3>
				<p class="description"><?php esc_html_e( 'Click on the apply button to preview and load a pre-made color scheme.', 'developer-starter-pro' ); ?></p>
				
				<div class="skins-grid">
					<!-- Skin: Main -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Main (Teal)', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #0D9488;" title="Primary"></span>
							<span class="color-block" style="background-color: #1E293B;" title="Secondary"></span>
							<span class="color-block" style="background-color: #F59E0B;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#0D9488" 
								data-secondary="#1E293B" 
								data-accent="#F59E0B">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>

					<!-- Skin: Classic Blue -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Classic Blue', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #1E6FD9;" title="Primary"></span>
							<span class="color-block" style="background-color: #0F172A;" title="Secondary"></span>
							<span class="color-block" style="background-color: #60A5FA;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#1E6FD9" 
								data-secondary="#0F172A" 
								data-accent="#60A5FA">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>

					<!-- Skin: Forest Green -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Forest Green', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #4E7C59;" title="Primary"></span>
							<span class="color-block" style="background-color: #111827;" title="Secondary"></span>
							<span class="color-block" style="background-color: #82B08D;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#4E7C59" 
								data-secondary="#111827" 
								data-accent="#82B08D">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>

					<!-- Skin: Lavender Gray -->
					<div class="skin-card">
						<div class="skin-name"><?php esc_html_e( 'Lavender Gray', 'developer-starter-pro' ); ?></div>
						<div class="skin-palette">
							<span class="color-block" style="background-color: #8F9BB3;" title="Primary"></span>
							<span class="color-block" style="background-color: #1A202C;" title="Secondary"></span>
							<span class="color-block" style="background-color: #CBD5E1;" title="Accent"></span>
						</div>
						<button type="button" class="button developer-starter-pro-apply-skin-btn" 
								data-primary="#8F9BB3" 
								data-secondary="#1A202C" 
								data-accent="#CBD5E1">
							<?php esc_html_e( 'APPLY', 'developer-starter-pro' ); ?>
						</button>
					</div>
				</div>
			</div>

			<table class="form-table">
				<tr>
					<th><label for="color_primary"><?php esc_html_e( 'Primary Color', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="color_primary" name="<?php echo esc_attr( $this->option_name ); ?>[color_primary]" value="<?php echo esc_attr( $options['color_primary'] ); ?>" class="developer-starter-pro-color-picker" data-default-color="#0D9488">
						<p class="description"><?php esc_html_e( 'Main theme color — buttons, links, accents.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="color_secondary"><?php esc_html_e( 'Secondary Color', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="color_secondary" name="<?php echo esc_attr( $this->option_name ); ?>[color_secondary]" value="<?php echo esc_attr( $options['color_secondary'] ); ?>" class="developer-starter-pro-color-picker" data-default-color="#1E293B">
						<p class="description"><?php esc_html_e( 'Headings, dark backgrounds.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="color_accent"><?php esc_html_e( 'Accent Color', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="color_accent" name="<?php echo esc_attr( $this->option_name ); ?>[color_accent]" value="<?php echo esc_attr( $options['color_accent'] ); ?>" class="developer-starter-pro-color-picker" data-default-color="#F59E0B">
						<p class="description"><?php esc_html_e( 'Highlights, badges, CTAs.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>

			</table>

			<div class="developer-starter-pro-color-preview">
				<h3><?php esc_html_e( 'Preview', 'developer-starter-pro' ); ?></h3>
				<div class="developer-starter-pro-color-swatches">
					<div class="swatch" id="swatch-primary" style="background-color: <?php echo esc_attr( $options['color_primary'] ); ?>">
						<span><?php esc_html_e( 'Primary', 'developer-starter-pro' ); ?></span>
					</div>
					<div class="swatch" id="swatch-secondary" style="background-color: <?php echo esc_attr( $options['color_secondary'] ); ?>">
						<span><?php esc_html_e( 'Secondary', 'developer-starter-pro' ); ?></span>
					</div>
					<div class="swatch" id="swatch-accent" style="background-color: <?php echo esc_attr( $options['color_accent'] ); ?>">
						<span><?php esc_html_e( 'Accent', 'developer-starter-pro' ); ?></span>
					</div>
				</div>
			</div>
		</div>
