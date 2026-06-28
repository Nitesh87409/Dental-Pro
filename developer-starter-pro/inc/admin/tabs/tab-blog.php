<?php
/**
 * Tab: blog
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Homepage Blog Settings', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure the latest articles showcase section on your homepage.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="blog_section_enabled"><?php esc_html_e( 'Enable Blog Section', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="blog_section_enabled" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_enabled]" value="1" <?php checked( isset( $options['blog_section_enabled'] ) ? $options['blog_section_enabled'] : '1', '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
							<span class="developer-starter-pro-toggle-label"><?php esc_html_e( 'Show latest posts on the homepage', 'developer-starter-pro' ); ?></span>
						</label>
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_eyebrow"><?php esc_html_e( 'Section Badge / Eyebrow', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="blog_section_eyebrow" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_eyebrow]" value="<?php echo esc_attr( isset( $options['blog_section_eyebrow'] ) ? $options['blog_section_eyebrow'] : 'Dental Insights' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_title"><?php esc_html_e( 'Section Title', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="blog_section_title" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_title]" value="<?php echo esc_attr( isset( $options['blog_section_title'] ) ? $options['blog_section_title'] : 'Latest News & Articles' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_subtitle"><?php esc_html_e( 'Section Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="blog_section_subtitle" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_subtitle]" rows="3" class="large-text"><?php echo esc_textarea( isset( $options['blog_section_subtitle'] ) ? $options['blog_section_subtitle'] : 'Stay informed with standard dental health tips and advice from our clinical experts.' ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="blog_section_count"><?php esc_html_e( 'Post Display Count', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="number" id="blog_section_count" name="<?php echo esc_attr( $this->option_name ); ?>[blog_section_count]" value="<?php echo esc_attr( isset( $options['blog_section_count'] ) ? $options['blog_section_count'] : 3 ); ?>" min="1" max="12" class="small-text">
						<p class="description"><?php esc_html_e( 'Choose how many latest blog posts to show in the homepage grid.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
			</table>
		</div>
