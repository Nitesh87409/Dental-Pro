<?php
/**
 * Footer Template
 *
 * Displays the site footer with dynamic style selection.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$footer_style  = developer_starter_pro_get_option( 'footer_style', '1' );
$clinic_name   = developer_starter_pro_get_option( 'clinic_name', 'Apex Dental Care' );
$clinic_phone  = developer_starter_pro_get_option( 'clinic_phone', '' );
$clinic_email  = developer_starter_pro_get_option( 'clinic_email', '' );
$clinic_address = developer_starter_pro_get_option( 'clinic_address', '' );
$map_embed_code = developer_starter_pro_get_option( 'map_embed_code', '' );

// Get dynamic social links
$social_links = array(
	'facebook'  => array( 'url' => developer_starter_pro_get_option( 'social_facebook', '' ), 'label' => 'Facebook', 'svg' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>' ),
	'instagram' => array( 'url' => developer_starter_pro_get_option( 'social_instagram', '' ), 'label' => 'Instagram', 'svg' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>' ),
	'twitter'   => array( 'url' => developer_starter_pro_get_option( 'social_twitter', '' ), 'label' => 'Twitter / X', 'svg' => '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>' ),
	'youtube'   => array( 'url' => developer_starter_pro_get_option( 'social_youtube', '' ), 'label' => 'YouTube', 'svg' => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>' ),
	'linkedin'  => array( 'url' => developer_starter_pro_get_option( 'social_linkedin', '' ), 'label' => 'LinkedIn', 'svg' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>' ),
	'tiktok'    => array( 'url' => developer_starter_pro_get_option( 'social_tiktok', '' ), 'label' => 'TikTok', 'svg' => '<path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>' ),
	'pinterest' => array( 'url' => developer_starter_pro_get_option( 'social_pinterest', '' ), 'label' => 'Pinterest', 'svg' => '<path d="M8 22a9 9 0 0 1-1.91-5.17c0-2.6 1.34-4.89 3.25-6a5.57 5.57 0 0 0-.17 1.36c0 2 1.36 4.7 3.5 4.7 1.8 0 3.5-1.5 3.5-4 0-3.3-2.6-5.5-6.5-5.5-4 0-7.5 2.8-7.5 7.5 0 2.2 1.1 4.2 2.8 5l-.5 2C2.8 19 1 15.7 1 12 1 5.9 5.9 1 12 1s11 4.9 11 11c0 5.6-4 10-9.5 10a7.21 7.21 0 0 1-3.64-.95c-.83 1.63-1.85 3.12-2.86 4.65l-1 1.3Z"/>' )
);

$custom_1_url   = developer_starter_pro_get_option( 'social_custom_1_url', '' );
$custom_1_label = developer_starter_pro_get_option( 'social_custom_1_label', '' );
$custom_1_icon  = developer_starter_pro_get_option( 'social_custom_1_icon', '🔗' );
if ( ! empty( $custom_1_url ) && ! empty( $custom_1_label ) ) {
	$social_links['custom_1'] = array(
		'url'       => $custom_1_url,
		'label'     => $custom_1_label,
		'is_custom' => true,
		'icon'      => $custom_1_icon,
	);
}

$custom_2_url   = developer_starter_pro_get_option( 'social_custom_2_url', '' );
$custom_2_label = developer_starter_pro_get_option( 'social_custom_2_label', '' );
$custom_2_icon  = developer_starter_pro_get_option( 'social_custom_2_icon', '🔗' );
if ( ! empty( $custom_2_url ) && ! empty( $custom_2_label ) ) {
	$social_links['custom_2'] = array(
		'url'       => $custom_2_url,
		'label'     => $custom_2_label,
		'is_custom' => true,
		'icon'      => $custom_2_icon,
	);
}

// Fallback to defaults if no social link is filled
$has_social_links = false;
foreach ( $social_links as $link ) {
	if ( ! empty( $link['url'] ) ) {
		$has_social_links = true;
		break;
	}
}
if ( ! $has_social_links ) {
	$social_links['facebook']['url']  = 'https://facebook.com';
	$social_links['instagram']['url'] = 'https://instagram.com';
}
?>

	</div><!-- #content -->

	<footer id="colophon" class="dp-footer" role="contentinfo">
		<div class="dp-footer__container">
			<div class="dp-footer__grid dp-footer__grid--style-<?php echo esc_attr( $footer_style ); ?>">

				<?php if ( '3' === $footer_style ) : ?>
					<!-- Style 3: 2 Columns (Minimal) -->
					
					<!-- Column 1: Clinic Location & Contact Info combined -->
					<div class="dp-footer__col dp-footer__col--info">
						<h3 class="dp-footer__title"><?php echo esc_html( $clinic_name ); ?></h3>
						<p style="font-size: 0.875rem; color: #5C5449; line-height: 1.6; margin-bottom: 20px;">
							<?php echo esc_html( ! empty( $clinic_address ) ? $clinic_address : __( 'Apex Dental Care, Central Avenue, City', 'developer-starter-pro' ) ); ?>
						</p>
						<ul class="dp-footer__list">
							<li>
								<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
								<?php $display_email = ! empty( $clinic_email ) ? $clinic_email : 'info@apexdentalcare.com'; ?>
								<a href="mailto:<?php echo esc_attr( $display_email ); ?>"><?php echo esc_html( $display_email ); ?></a>
							</li>
							<li>
								<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
								<?php $display_phone = ! empty( $clinic_phone ) ? $clinic_phone : '+1 800 123 4567'; ?>
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $display_phone ) ); ?>"><?php echo esc_html( $display_phone ); ?></a>
							</li>
						</ul>
					</div>

					<!-- Column 2: Social Us / Quick Links -->
					<div class="dp-footer__col dp-footer__col--social">
						<h3 class="dp-footer__title"><?php esc_html_e( 'Connect With Us', 'developer-starter-pro' ); ?></h3>
						<ul class="dp-footer__list">
							<?php foreach ( $social_links as $id => $link ) : 
								if ( empty( $link['url'] ) ) continue;
							?>
								<li>
									<?php if ( ! empty( $link['is_custom'] ) ) : ?>
										<span class="dp-footer-icon" style="font-size: 16px; width: 16px; height: 16px; display: inline-flex; align-items: center; justify-content: center; line-height: 1;"><?php echo esc_html( $link['icon'] ); ?></span>
									<?php else : ?>
										<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
											<?php echo $link['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</svg>
									<?php endif; ?>
									<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $link['label'] ); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>

				<?php elseif ( '2' === $footer_style ) : ?>
					<!-- Style 2: 3 Columns (With newsletter) -->
					
					<!-- Column 1: Map -->
					<div class="dp-footer__col dp-footer__col--map">
						<div class="dp-footer__map-wrapper <?php echo ( ! empty( $map_embed_code ) || ! empty( $clinic_address ) ) ? 'has-real-map' : 'has-vector-map'; ?>">
							<?php $address_for_map = ! empty( $clinic_address ) ? $clinic_address : __( 'Apex Dental Care, Central Avenue, City', 'developer-starter-pro' ); ?>
							<a class="dp-footer-map-action-link" href="#" target="_blank" data-address="<?php echo esc_attr( $address_for_map ); ?>" style="display: block; width: 100%; height: 100%; color: inherit; text-decoration: none;">
								<?php if ( ! empty( $map_embed_code ) ) : ?>
									<?php echo wp_kses( $map_embed_code, array('iframe' => array('src'=>true,'width'=>true,'height'=>true,'style'=>true,'frameborder'=>true,'allowfullscreen'=>true,'loading'=>true,'referrerpolicy'=>true,'class'=>true,'id'=>true)) ); ?>
								<?php elseif ( ! empty( $clinic_address ) ) : ?>
									<iframe width="100%" height="192" style="border:0;" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=<?php echo urlencode( $clinic_address ); ?>&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
								<?php else : ?>
									<svg class="dp-footer-map-svg" viewBox="0 0 320 130" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="320" height="130" rx="8" fill="#F4EFEB"/>
										<path d="M10 100 C20 95 40 105 50 120 L40 130 L0 130 Z" fill="#D3DEC6"/>
										<path d="M250 12 C260 10 270 20 280 30 L290 0 L240 0 Z" fill="#D3DEC6"/>
										<path d="M290 0 C280 40 250 80 255 130" stroke="#A7D2EB" stroke-width="26" stroke-linecap="square" fill="none"/>
										<path d="M0 25 L320 25" stroke="#FFFFFF" stroke-width="4"/><path d="M0 65 C100 70 200 60 320 75" stroke="#FFFFFF" stroke-width="4"/><path d="M0 110 L320 110" stroke="#FFFFFF" stroke-width="3"/><path d="M50 0 L50 130" stroke="#FFFFFF" stroke-width="4"/><path d="M130 0 L90 130" stroke="#FFFFFF" stroke-width="4.5"/><path d="M210 0 C200 40 205 90 180 130" stroke="#FFFFFF" stroke-width="4"/><path d="M80 0 L250 130" stroke="#FFFFFF" stroke-width="3"/>
										<ellipse cx="140" cy="85" rx="6" ry="3" fill="rgba(0,0,0,0.15)"/>
										<g transform="translate(128, 52)"><path d="M12 0C5.37 0 0 5.37 0 12C0 19.5 9.6 27.6 11.15 28.87C11.65 29.28 12.35 29.28 12.85 28.87C14.4 27.6 24 19.5 24 12C24 5.37 18.63 0 12 0Z" fill="currentColor" style="color: var(--developer-starter-pro-primary);"/><circle cx="12" cy="12" r="4.5" fill="#FFFFFF"/></g>
									</svg>
								<?php endif; ?>
							</a>
						</div>
					</div>

					<!-- Column 2: Contact Info -->
					<div class="dp-footer__col dp-footer__col--contact">
						<h3 class="dp-footer__title"><?php esc_html_e( 'Contact Info', 'developer-starter-pro' ); ?></h3>
						<ul class="dp-footer__list">
							<li>
								<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
								<span><?php echo esc_html( ! empty( $clinic_address ) ? $clinic_address : __( 'Apex Dental Care, Central Avenue, City', 'developer-starter-pro' ) ); ?></span>
							</li>
							<li>
								<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
								<?php $display_email = ! empty( $clinic_email ) ? $clinic_email : 'info@apexdentalcare.com'; ?>
								<a href="mailto:<?php echo esc_attr( $display_email ); ?>"><?php echo esc_html( $display_email ); ?></a>
							</li>
						</ul>
					</div>



				<?php else : ?>
					<!-- Style 1: 4 Columns (Full Featured) -->
					
					<!-- Column 1: Map -->
					<div class="dp-footer__col dp-footer__col--map">
						<div class="dp-footer__map-wrapper <?php echo ( ! empty( $map_embed_code ) || ! empty( $clinic_address ) ) ? 'has-real-map' : 'has-vector-map'; ?>">
							<?php $address_for_map = ! empty( $clinic_address ) ? $clinic_address : __( 'Apex Dental Care, Central Avenue, City', 'developer-starter-pro' ); ?>
							<a class="dp-footer-map-action-link" href="#" target="_blank" data-address="<?php echo esc_attr( $address_for_map ); ?>" style="display: block; width: 100%; height: 100%; color: inherit; text-decoration: none;">
								<?php if ( ! empty( $map_embed_code ) ) : ?>
									<?php echo wp_kses( $map_embed_code, array('iframe' => array('src'=>true,'width'=>true,'height'=>true,'style'=>true,'frameborder'=>true,'allowfullscreen'=>true,'loading'=>true,'referrerpolicy'=>true,'class'=>true,'id'=>true)) ); ?>
								<?php elseif ( ! empty( $clinic_address ) ) : ?>
									<iframe width="100%" height="192" style="border:0;" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=<?php echo urlencode( $clinic_address ); ?>&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
								<?php else : ?>
									<svg class="dp-footer-map-svg" viewBox="0 0 320 130" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="320" height="130" rx="8" fill="#F4EFEB"/>
										<path d="M10 100 C20 95 40 105 50 120 L40 130 L0 130 Z" fill="#D3DEC6"/>
										<path d="M250 12 C260 10 270 20 280 30 L290 0 L240 0 Z" fill="#D3DEC6"/>
										<path d="M290 0 C280 40 250 80 255 130" stroke="#A7D2EB" stroke-width="26" stroke-linecap="square" fill="none"/>
										<path d="M0 25 L320 25" stroke="#FFFFFF" stroke-width="4"/><path d="M0 65 C100 70 200 60 320 75" stroke="#FFFFFF" stroke-width="4"/><path d="M0 110 L320 110" stroke="#FFFFFF" stroke-width="3"/><path d="M50 0 L50 130" stroke="#FFFFFF" stroke-width="4"/><path d="M130 0 L90 130" stroke="#FFFFFF" stroke-width="4.5"/><path d="M210 0 C200 40 205 90 180 130" stroke="#FFFFFF" stroke-width="4"/><path d="M80 0 L250 130" stroke="#FFFFFF" stroke-width="3"/>
										<ellipse cx="140" cy="85" rx="6" ry="3" fill="rgba(0,0,0,0.15)"/>
										<g transform="translate(128, 52)"><path d="M12 0C5.37 0 0 5.37 0 12C0 19.5 9.6 27.6 11.15 28.87C11.65 29.28 12.35 29.28 12.85 28.87C14.4 27.6 24 19.5 24 12C24 5.37 18.63 0 12 0Z" fill="currentColor" style="color: var(--developer-starter-pro-primary);"/><circle cx="12" cy="12" r="4.5" fill="#FFFFFF"/></g>
									</svg>
								<?php endif; ?>
							</a>
						</div>
					</div>

					<!-- Column 2: Contact Info -->
					<div class="dp-footer__col dp-footer__col--contact">
						<h3 class="dp-footer__title"><?php esc_html_e( 'Contact Info', 'developer-starter-pro' ); ?></h3>
						<ul class="dp-footer__list">
							<li>
								<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
								<span><?php echo esc_html( ! empty( $clinic_address ) ? $clinic_address : __( 'Apex Dental Care, Central Avenue, City', 'developer-starter-pro' ) ); ?></span>
							</li>
							<li>
								<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
								<?php $display_email = ! empty( $clinic_email ) ? $clinic_email : 'info@apexdentalcare.com'; ?>
								<a href="mailto:<?php echo esc_attr( $display_email ); ?>"><?php echo esc_html( $display_email ); ?></a>
							</li>
						</ul>
					</div>

					<!-- Column 3: Quick Links -->
					<div class="dp-footer__col dp-footer__col--social">
						<h3 class="dp-footer__title"><?php esc_html_e( 'Quick Links', 'developer-starter-pro' ); ?></h3>
						<ul class="dp-footer__list">
							<?php foreach ( $social_links as $id => $link ) : 
								if ( empty( $link['url'] ) ) continue;
							?>
								<li>
									<?php if ( ! empty( $link['is_custom'] ) ) : ?>
										<span class="dp-footer-icon" style="font-size: 16px; width: 16px; height: 16px; display: inline-flex; align-items: center; justify-content: center; line-height: 1;"><?php echo esc_html( $link['icon'] ); ?></span>
									<?php else : ?>
										<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
											<?php echo $link['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</svg>
									<?php endif; ?>
									<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $link['label'] ); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>



				<?php endif; ?>

			</div><!-- .dp-footer__grid -->

			<hr class="dp-footer__sep">

			<div class="dp-footer__bottom">
				<p class="dp-footer__copyright">
					&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php printf( esc_html__( '%s. All rights reserved.', 'developer-starter-pro' ), esc_html( $clinic_name ) ); ?>
				</p>
				<div class="dp-footer__links">
					<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'developer-starter-pro' ); ?></a>
					<span class="dp-footer__links-sep">|</span>
					<a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'developer-starter-pro' ); ?></a>
					<span class="dp-footer__links-sep">|</span>
					<a href="<?php echo esc_url( home_url( '/sitemap/' ) ); ?>"><?php esc_html_e( 'Sitemap', 'developer-starter-pro' ); ?></a>
				</div>
			</div>

		</div><!-- .dp-footer__container -->
	</footer>

	<!-- Unified Emergency & WhatsApp Floating Widget (Logic Eval) -->
	<?php
	$emergency_enabled = developer_starter_pro_get_option( 'emergency_enabled', '1' );
	$emergency_phone   = developer_starter_pro_get_option( 'emergency_phone', '' );
	$wa_enabled        = developer_starter_pro_get_option( 'whatsapp_enabled', '0' );
	$wa_number         = developer_starter_pro_get_option( 'whatsapp_number', '' );
	$wa_message        = developer_starter_pro_get_option( 'whatsapp_message', '' );
	$wa_position       = developer_starter_pro_get_option( 'whatsapp_position', 'right' );

	$show_emergency = ( '1' === $emergency_enabled && ! empty( $emergency_phone ) );
	$show_whatsapp  = ( '1' === $wa_enabled && ! empty( $wa_number ) );
	$has_fab = $show_emergency || $show_whatsapp;

	// Determine back-to-top alignment to prevent clash with FAB
	$btt_style = '';
	if ( $has_fab && 'left' === $wa_position ) {
		$btt_style = ' style="left: auto !important; right: 30px !important;"';
	}
	?>

	<!-- Back to Top Button -->
	<button class="developer-starter-pro-back-to-top" id="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'developer-starter-pro' ); ?>"<?php echo $btt_style; ?>>
		<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
	</button>

	<!-- Unified Emergency & WhatsApp Floating Widget (Render) -->
	<?php
	if ( $has_fab ) :
		$wa_clean_number = preg_replace( '/[^0-9]/', '', $wa_number );
		$wa_link = 'https://wa.me/' . $wa_clean_number;
		if ( ! empty( $wa_message ) ) {
			$wa_link .= '?text=' . rawurlencode( $wa_message );
		}

		$is_expandable  = ( $show_emergency && $show_whatsapp );
		$widget_classes = array( 'dp-unified-fab-widget', 'pos-' . $wa_position );
		if ( $is_expandable ) {
			$widget_classes[] = 'has-menu';
		} else {
			$widget_classes[] = 'direct-action';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $widget_classes ) ); ?>" id="dp-unified-fab-widget">
			<?php if ( $is_expandable ) : ?>
				<!-- Expandable Options Menu -->
				<div class="dp-fab-menu" id="dp-fab-menu">
					<?php if ( $show_whatsapp ) : ?>
						<a href="<?php echo esc_url( $wa_link ); ?>" class="dp-fab-item whatsapp-item" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'developer-starter-pro' ); ?>">
							<span class="dp-fab-label"><?php esc_html_e( 'WhatsApp Chat', 'developer-starter-pro' ); ?></span>
							<span class="dp-fab-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.248 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.863-9.864.001-2.636-1.023-5.11-2.884-6.974C16.59 1.897 14.1 1.87 11.465 1.87 6.03 1.87 1.606 6.291 1.603 11.737c-.001 1.638.5 3.226 1.458 4.825L2.046 22l5.602-1.468zM17.65 14.49c-.3-.15-1.782-.88-2.057-.98-.275-.1-.475-.15-.675.15-.2.3-.775.98-.95 1.18-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.794-1.49-1.775-1.665-2.075-.175-.3-.019-.462.13-.61.135-.133.3-.35.45-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.625-.925-2.225-.244-.588-.491-.508-.675-.518-.174-.01-.374-.012-.574-.012-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.075 2.9 1.225 3.1c.15.2 2.11 3.22 5.11 4.52.714.31 1.27.496 1.703.635.717.228 1.37.195 1.886.118.574-.085 1.782-.73 2.032-1.435.25-.705.25-1.31.175-1.435-.075-.125-.275-.2-.575-.35z"/></svg>
							</span>
						</a>
					<?php endif; ?>

					<?php if ( $show_emergency ) : ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $emergency_phone ) ); ?>" class="dp-fab-item emergency-item" aria-label="<?php esc_attr_e( 'Emergency Call', 'developer-starter-pro' ); ?>">
							<span class="dp-fab-label"><?php esc_html_e( 'Emergency Call', 'developer-starter-pro' ); ?></span>
							<span class="dp-fab-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
							</span>
						</a>
					<?php endif; ?>
				</div>

				<!-- Main Floating Trigger Button -->
				<button class="dp-fab-trigger" id="dp-fab-trigger" aria-label="<?php esc_attr_e( 'Clinic Help Options', 'developer-starter-pro' ); ?>">
					<span class="dp-fab-pulse"></span>
					<span class="dp-fab-trigger-icon">🚨</span>
					<span class="dp-fab-close-icon" style="display:none;">&times;</span>
					<span class="dp-fab-tooltip"><?php esc_html_e( 'Need Help?', 'developer-starter-pro' ); ?></span>
				</button>
			<?php else : ?>
				<!-- Direct Action Floating Button (No Menu) -->
				<?php if ( $show_whatsapp ) : ?>
					<a href="<?php echo esc_url( $wa_link ); ?>" class="dp-fab-trigger whatsapp-direct" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'developer-starter-pro' ); ?>" style="background-color: #25D366; text-decoration: none; display: flex; align-items: center; justify-content: center;">
						<span class="dp-fab-pulse" style="background-color: #25D366;"></span>
						<span class="dp-fab-trigger-icon" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
							<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="currentColor" style="color: #fff; display: block; margin: 0 auto;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.248 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.863-9.864.001-2.636-1.023-5.11-2.884-6.974C16.59 1.897 14.1 1.87 11.465 1.87 6.03 1.87 1.606 6.291 1.603 11.737c-.001 1.638.5 3.226 1.458 4.825L2.046 22l5.602-1.468zM17.65 14.49c-.3-.15-1.782-.88-2.057-.98-.275-.1-.475-.15-.675.15-.2.3-.775.98-.95 1.18-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.794-1.49-1.775-1.665-2.075-.175-.3-.019-.462.13-.61.135-.133.3-.35.45-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.625-.925-2.225-.244-.588-.491-.508-.675-.518-.174-.01-.374-.012-.574-.012-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.075 2.9 1.225 3.1c.15.2 2.11 3.22 5.11 4.52.714.31 1.27.496 1.703.635.717.228 1.37.195 1.886.118.574-.085 1.782-.73 2.032-1.435.25-.705.25-1.31.175-1.435-.075-.125-.275-.2-.575-.35z"/></svg>
						</span>
						<span class="dp-fab-tooltip"><?php esc_html_e( 'Chat on WhatsApp', 'developer-starter-pro' ); ?></span>
					</a>
				<?php elseif ( $show_emergency ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $emergency_phone ) ); ?>" class="dp-fab-trigger emergency-direct" aria-label="<?php esc_attr_e( 'Emergency Call', 'developer-starter-pro' ); ?>" style="background-color: #ef4444; text-decoration: none; display: flex; align-items: center; justify-content: center; animation: pulseRed 1.5s infinite;">
						<span class="dp-fab-pulse" style="background-color: #ef4444;"></span>
						<span class="dp-fab-trigger-icon" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #fff; display: block; margin: 0 auto;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
						</span>
						<span class="dp-fab-tooltip"><?php esc_html_e( 'Emergency Call', 'developer-starter-pro' ); ?></span>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var trigger = document.getElementById('dp-fab-trigger');
				var widget = document.getElementById('dp-unified-fab-widget');
				
				if (trigger && widget && widget.classList.contains('has-menu')) {
					// Toggle expanded state on click
					trigger.addEventListener('click', function(e) {
						e.stopPropagation();
						widget.classList.toggle('expanded');
						var closeIcon = trigger.querySelector('.dp-fab-close-icon');
						var triggerIcon = trigger.querySelector('.dp-fab-trigger-icon');
						if (widget.classList.contains('expanded')) {
							closeIcon.style.display = 'block';
							triggerIcon.style.display = 'none';
						} else {
							closeIcon.style.display = 'none';
							triggerIcon.style.display = 'block';
						}
					});

					// Close when clicking outside
					document.addEventListener('click', function() {
						if (widget.classList.contains('expanded')) {
							widget.classList.remove('expanded');
							trigger.querySelector('.dp-fab-close-icon').style.display = 'none';
							trigger.querySelector('.dp-fab-trigger-icon').style.display = 'block';
						}
					});
				}
			});
		</script>
	<?php endif; ?>

	<!-- GDPR Cookie Consent Banner -->
	<div class="dentalpro-cookie-notice" id="cookie-notice">
		<div class="cookie-notice-container" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
			<div class="cookie-notice-text" style="flex: 1; min-width: 280px; text-align: left;">
				<p style="margin: 0; font-size: 0.9rem; line-height: 1.5; color: #cbd5e1;">
					🍪 <strong><?php esc_html_e( 'Cookie Consent notice:', 'developer-starter-pro' ); ?></strong> 
					<?php esc_html_e( 'We use cookies to optimize patient portal logins, automate booking schedules, and review diagnostic feedback. By continuing to browse, you agree to our standard medical privacy policies.', 'developer-starter-pro' ); ?>
				</p>
			</div>
			<div class="cookie-notice-actions" style="display: flex; gap: 10px; align-items: center;">
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" style="font-size: 0.8125rem; color: #94a3b8; text-decoration: underline; margin-right: 10px; font-weight: 500;"><?php esc_html_e( 'Details', 'developer-starter-pro' ); ?></a>
				<button class="developer-starter-pro-btn developer-starter-pro-btn--primary" id="cookie-accept-btn" style="padding: 10px 24px; font-size: 0.875rem; font-weight: 700; border-radius: 6px; border: none; cursor: pointer; background: var(--developer-starter-pro-primary); color: #fff;">
					<?php esc_html_e( 'Accept All', 'developer-starter-pro' ); ?>
				</button>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var banner = document.getElementById('cookie-notice');
			var acceptBtn = document.getElementById('cookie-accept-btn');
			
			if (banner && acceptBtn) {
				// If not accepted yet, show banner with a small delay
				if (!localStorage.getItem('dentalpro_cookies_accepted')) {
					setTimeout(function() {
						banner.classList.add('visible');
					}, 1000);
				}
				
				// Accept event listener
				acceptBtn.addEventListener('click', function() {
					localStorage.setItem('dentalpro_cookies_accepted', 'true');
					banner.classList.remove('visible');
					banner.classList.add('fade-out');
					setTimeout(function() {
						banner.style.display = 'none';
					}, 500);
				});
			}

			// Dynamic Map Link Redirection (Apple Maps for iOS, Google Maps for Android/Others)
			var mapLinks = document.querySelectorAll('.dp-footer-map-action-link');
			mapLinks.forEach(function(link) {
				var address = link.getAttribute('data-address');
				if (address) {
					var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
					if (isIOS) {
						link.href = 'https://maps.apple.com/?q=' + encodeURIComponent(address);
					} else {
						link.href = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(address);
					}
				}
			});
		});
	</script>
	<!-- Page Transition Curtain Overlay (Blank Solid Theme Color Sheet) -->
	<div id="dp-page-transition-curtain" class="dp-transition-curtain"></div>

	<style>
	/* Page Transition Curtain */
	.dp-transition-curtain {
		position: fixed !important;
		top: 0 !important;
		left: 0 !important;
		width: 100% !important;
		height: 100% !important;
		background: #FAFAF8 !important;
		z-index: 999999 !important;
		opacity: 0 !important;
		visibility: hidden !important;
		transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out !important;
		pointer-events: none !important;
	}
	body.dark-mode .dp-transition-curtain {
		background: #1E293B !important;
	}
	.dp-transition-curtain.is-active {
		opacity: 1 !important;
		visibility: visible !important;
		pointer-events: auto !important;
	}
	</style>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var curtain = document.getElementById('dp-page-transition-curtain');
		if (curtain) {
			if (sessionStorage.getItem('dp_page_transition') === 'active') {
				curtain.classList.add('is-active');
				
				var bookingContent = document.getElementById('primary');
				if (bookingContent) {
					bookingContent.style.opacity = '0';
					bookingContent.style.transform = 'translateY(20px)';
					bookingContent.style.transition = 'opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
				}
				
				var completedTransition = false;
				function triggerTransitionEnd() {
					if (completedTransition) return;
					completedTransition = true;
					curtain.style.opacity = '0';
					curtain.style.visibility = 'hidden';
					if (bookingContent) {
						bookingContent.style.opacity = '1';
						bookingContent.style.transform = 'translateY(0)';
					}
					setTimeout(function() {
						curtain.classList.remove('is-active');
						sessionStorage.removeItem('dp_page_transition');
					}, 500);
				}
				
				window.addEventListener('load', function() {
					setTimeout(triggerTransitionEnd, 400);
				});
				// Fallback timeout in case page load is blocked or slow
				setTimeout(triggerTransitionEnd, 2000);
			}
		}
	});
	</script>

</div><!-- #page -->

	<?php
	$options = get_option( 'developer_starter_pro_options', array() );
	$chatbot_enabled = isset( $options['chatbot_enable'] ) && '1' === $options['chatbot_enable'];
	if ( $chatbot_enabled ) :
		// Shift chatbot up if unified FAB is present on the right
		$chatbot_style = '';
		if ( ( $show_emergency || $show_whatsapp ) && 'right' === $wa_position ) {
			$chatbot_style = ' style="bottom: 110px;"';
		}
	?>
	<!-- AI Chatbot Widget -->
	<div class="dentalpro-chatbot-wrapper"<?php echo $chatbot_style; ?>>
		<div class="dentalpro-chatbot-window">
			<div class="dentalpro-chatbot-header">
				<div class="dentalpro-chatbot-header-icon">🤖</div>
				<div class="dentalpro-chatbot-header-text">
					<h4><?php esc_html_e( 'Virtual Assistant', 'developer-starter-pro' ); ?></h4>
					<p><?php esc_html_e( 'Powered by AI', 'developer-starter-pro' ); ?></p>
				</div>
			</div>
			<div class="dentalpro-chatbot-messages">
				<div class="dentalpro-chatbot-msg msg-ai">
					<p><?php esc_html_e( 'Hello! How can I help you with your dental needs today?', 'developer-starter-pro' ); ?></p>
				</div>
				<div class="dentalpro-chatbot-typing">
					<div class="dot"></div>
					<div class="dot"></div>
					<div class="dot"></div>
				</div>
			</div>
			<div class="dentalpro-chatbot-input">
				<input type="text" id="dentalpro-chatbot-input-field" placeholder="<?php esc_attr_e( 'Type your message...', 'developer-starter-pro' ); ?>" autocomplete="off" />
				<button id="dentalpro-chatbot-send" aria-label="<?php esc_attr_e( 'Send Message', 'developer-starter-pro' ); ?>">
					<svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
				</button>
			</div>
		</div>
		<div class="dentalpro-chatbot-toggle">
			<svg class="chat-icon" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
			<svg class="close-icon" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
		</div>
	</div>
	<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
