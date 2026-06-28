<?php
/**
 * Tab: general
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Clinic Information', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Basic information about your dental clinic.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="clinic_logo"><?php esc_html_e( 'Clinic Logo', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="clinic_logo" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_logo]" value="<?php echo esc_url( $options['clinic_logo'] ); ?>">
							<div class="developer-starter-pro-logo-preview" id="logo-preview">
								<?php if ( ! empty( $options['clinic_logo'] ) ) : ?>
									<img src="<?php echo esc_url( $options['clinic_logo'] ); ?>" alt="Logo">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="clinic_logo" data-preview="logo-preview">
								<?php esc_html_e( 'Upload Logo', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="clinic_logo" data-preview="logo-preview" <?php echo empty( $options['clinic_logo'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="clinic_logo_height"><?php esc_html_e( 'Logo Height (px)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="number" id="clinic_logo_height" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_logo_height]" value="<?php echo esc_attr( isset( $options['clinic_logo_height'] ) ? $options['clinic_logo_height'] : 45 ); ?>" min="20" max="150" class="small-text">
						<p class="description"><?php esc_html_e( 'Adjust the maximum height of the clinic logo in pixels (default is 45px).', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="hero_image"><?php esc_html_e( 'Hero Background Image', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="hero_image" name="<?php echo esc_attr( $this->option_name ); ?>[hero_image]" value="<?php echo esc_url( isset( $options['hero_image'] ) ? $options['hero_image'] : '' ); ?>">
							<div class="developer-starter-pro-logo-preview" id="hero-image-preview" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
								<?php if ( ! empty( $options['hero_image'] ) ) : ?>
									<img src="<?php echo esc_url( $options['hero_image'] ); ?>" alt="Hero Image" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="hero_image" data-preview="hero-image-preview">
								<?php esc_html_e( 'Upload Background', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="hero_image" data-preview="hero-image-preview" <?php echo empty( $options['hero_image'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
						<p class="description"><?php esc_html_e( 'Upload a full background image for the hero banner (recommended dimensions: 1920x800px). If empty, the default multi-layered layout will be used.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="page_banner_image"><?php esc_html_e( 'Page Banner Background Image', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="page_banner_image" name="<?php echo esc_attr( $this->option_name ); ?>[page_banner_image]" value="<?php echo esc_url( isset( $options['page_banner_image'] ) ? $options['page_banner_image'] : '' ); ?>">
							<div class="developer-starter-pro-logo-preview" id="page-banner-image-preview" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
								<?php if ( ! empty( $options['page_banner_image'] ) ) : ?>
									<img src="<?php echo esc_url( $options['page_banner_image'] ); ?>" alt="Page Banner Image" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="page_banner_image" data-preview="page-banner-image-preview">
								<?php esc_html_e( 'Upload Page Banner', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="page_banner_image" data-preview="page-banner-image-preview" <?php echo empty( $options['page_banner_image'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
						<p class="description"><?php esc_html_e( 'Upload a background image for all archive/inner page banners (recommended: 1920x400px). If empty, the default clinic interior background is used.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="hero_video"><?php esc_html_e( 'Hero Background Video (MP4)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="text" id="hero_video" name="<?php echo esc_attr( $this->option_name ); ?>[hero_video]" value="<?php echo esc_url( isset( $options['hero_video'] ) ? $options['hero_video'] : '' ); ?>" class="regular-text" style="margin-bottom: 10px; display: inline-block; vertical-align: middle;">
							<div class="developer-starter-pro-logo-preview" id="hero-video-preview" style="max-width: 300px; margin-bottom: 10px;">
								<?php if ( ! empty( $options['hero_video'] ) ) : ?>
									<video src="<?php echo esc_url( $options['hero_video'] ); ?>" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;" autoplay loop muted playsinline></video>
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="hero_video" data-preview="hero-video-preview" data-type="video">
								<?php esc_html_e( 'Upload Video', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="hero_video" data-preview="hero-video-preview" <?php echo empty( $options['hero_video'] ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
						<p class="description"><?php esc_html_e( 'Select/upload a self-hosted MP4 background video or paste a direct video URL. If configured, it will play as a muted background instead of the static hero background image or multi-layer graphics.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="clinic_name"><?php esc_html_e( 'Clinic Name', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="clinic_name" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_name]" value="<?php echo esc_attr( $options['clinic_name'] ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="clinic_phone"><?php esc_html_e( 'Phone Number', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="tel" id="clinic_phone" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_phone]" value="<?php echo esc_attr( $options['clinic_phone'] ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="clinic_email"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="email" id="clinic_email" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_email]" value="<?php echo esc_attr( $options['clinic_email'] ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="clinic_address"><?php esc_html_e( 'Address', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="clinic_address" name="<?php echo esc_attr( $this->option_name ); ?>[clinic_address]" rows="3" class="large-text"><?php echo esc_textarea( $options['clinic_address'] ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>
