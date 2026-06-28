<?php
/**
 * Tab: social
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Social Media Links', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Add your social media profile URLs. Leave empty to hide.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<?php
				$social_platforms = array(
					'social_facebook'  => array( 'label' => 'Facebook',   'icon' => '📘', 'placeholder' => 'https://facebook.com/yourclinic' ),
					'social_instagram' => array( 'label' => 'Instagram',  'icon' => '📸', 'placeholder' => 'https://instagram.com/yourclinic' ),
					'social_twitter'   => array( 'label' => 'Twitter / X', 'icon' => '🐦', 'placeholder' => 'https://x.com/yourclinic' ),
					'social_youtube'   => array( 'label' => 'YouTube',    'icon' => '📺', 'placeholder' => 'https://youtube.com/@yourclinic' ),
					'social_linkedin'  => array( 'label' => 'LinkedIn',   'icon' => '💼', 'placeholder' => 'https://linkedin.com/company/yourclinic' ),
					'social_tiktok'    => array( 'label' => 'TikTok',     'icon' => '🎵', 'placeholder' => 'https://tiktok.com/@yourclinic' ),
					'social_pinterest' => array( 'label' => 'Pinterest',  'icon' => '📌', 'placeholder' => 'https://pinterest.com/yourclinic' ),
				);

				foreach ( $social_platforms as $key => $platform ) : ?>
					<tr>
						<th>
							<label for="<?php echo esc_attr( $key ); ?>">
								<?php echo esc_html( $platform['icon'] . ' ' . $platform['label'] ); ?>
							</label>
						</th>
						<td>
							<input type="url" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $this->option_name ); ?>[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_url( isset( $options[ $key ] ) ? $options[ $key ] : '' ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $platform['placeholder'] ); ?>">
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

			<h3 style="margin-top: 40px; margin-bottom: 5px; font-size: 1.2em; border-bottom: 1px solid #ddd; padding-bottom: 5px;"><?php esc_html_e( 'Custom Social Links', 'developer-starter-pro' ); ?></h3>
			<p class="description"><?php esc_html_e( 'Add custom links (e.g. blog, portal, or other platforms) with custom emojis, labels, and URLs.', 'developer-starter-pro' ); ?></p>
			
			<table class="form-table">
				<tr>
					<th><label><?php esc_html_e( 'Custom Link 1', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div style="display: flex; gap: 10px; max-width: 800px; align-items: center;">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_1_icon]" value="<?php echo esc_attr( isset($options['social_custom_1_icon']) ? $options['social_custom_1_icon'] : '🔗' ); ?>" style="width: 60px; text-align: center;" placeholder="Icon (Emoji)" title="Emoji Icon">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_1_label]" value="<?php echo esc_attr( isset($options['social_custom_1_label']) ? $options['social_custom_1_label'] : '' ); ?>" style="flex: 1;" placeholder="Label (e.g., Blog)">
							<input type="url" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_1_url]" value="<?php echo esc_url( isset($options['social_custom_1_url']) ? $options['social_custom_1_url'] : '' ); ?>" style="flex: 2;" placeholder="URL (https://...)">
						</div>
					</td>
				</tr>
				<tr>
					<th><label><?php esc_html_e( 'Custom Link 2', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div style="display: flex; gap: 10px; max-width: 800px; align-items: center;">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_2_icon]" value="<?php echo esc_attr( isset($options['social_custom_2_icon']) ? $options['social_custom_2_icon'] : '🔗' ); ?>" style="width: 60px; text-align: center;" placeholder="Icon (Emoji)" title="Emoji Icon">
							<input type="text" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_2_label]" value="<?php echo esc_attr( isset($options['social_custom_2_label']) ? $options['social_custom_2_label'] : '' ); ?>" style="flex: 1;" placeholder="Label (e.g., Portal)">
							<input type="url" name="<?php echo esc_attr( $this->option_name ); ?>[social_custom_2_url]" value="<?php echo esc_url( isset($options['social_custom_2_url']) ? $options['social_custom_2_url'] : '' ); ?>" style="flex: 2;" placeholder="URL (https://...)">
						</div>
					</td>
				</tr>
			</table>
		</div>
