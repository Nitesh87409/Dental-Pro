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
$clinic_name   = developer_starter_pro_get_option( 'clinic_name', 'DentalPro Elite' );
$clinic_phone  = developer_starter_pro_get_option( 'clinic_phone', '' );
$clinic_email  = developer_starter_pro_get_option( 'clinic_email', '' );
$clinic_address = developer_starter_pro_get_option( 'clinic_address', '' );
$map_embed_code = developer_starter_pro_get_option( 'map_embed_code', '' );
?>

	</div><!-- #content -->

	<footer id="colophon" class="dp-footer" role="contentinfo">
		<div class="dp-footer__container">
			<div class="dp-footer__grid">

				<!-- Column 1: Map Location -->
				<div class="dp-footer__col dp-footer__col--map">
					<div class="dp-footer__map-wrapper <?php echo ( ! empty( $map_embed_code ) || ! empty( $clinic_address ) ) ? 'has-real-map' : 'has-vector-map'; ?>">
						<?php if ( ! empty( $map_embed_code ) ) : ?>
							<?php echo wp_kses( $map_embed_code, array(
								'iframe' => array(
									'src'             => true,
									'width'           => true,
									'height'          => true,
									'style'           => true,
									'frameborder'     => true,
									'allowfullscreen' => true,
									'loading'         => true,
									'referrerpolicy'  => true,
									'class'           => true,
									'id'              => true,
								),
							) ); ?>
							<div class="dp-footer__map-overlay">
								<span class="dp-footer__map-badge"><?php esc_html_e( 'Interact with Map', 'developer-starter-pro' ); ?></span>
							</div>
						<?php elseif ( ! empty( $clinic_address ) ) : ?>
							<iframe 
								width="100%" 
								height="192" 
								style="border:0;" 
								loading="lazy" 
								allowfullscreen 
								referrerpolicy="no-referrer-when-downgrade"
								src="https://maps.google.com/maps?q=<?php echo urlencode( $clinic_address ); ?>&t=&z=14&ie=UTF8&iwloc=&output=embed">
							</iframe>
							<div class="dp-footer__map-overlay">
								<span class="dp-footer__map-badge"><?php esc_html_e( 'Interact with Map', 'developer-starter-pro' ); ?></span>
							</div>
						<?php else : ?>
							<svg class="dp-footer-map-svg" viewBox="0 0 320 130" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="<?php esc_attr_e( 'Map of clinic location', 'developer-starter-pro' ); ?>">
								<!-- Map Background -->
								<rect width="320" height="130" rx="8" fill="#F4EFEB"/>
								
								<!-- Parks (Green Blocks) -->
								<path d="M10 100 C20 95 40 105 50 120 L40 130 L0 130 Z" fill="#D3DEC6"/>
								<path d="M250 12 C260 10 270 20 280 30 L290 0 L240 0 Z" fill="#D3DEC6"/>
								
								<!-- Water / River -->
								<path d="M290 0 C280 40 250 80 255 130" stroke="#A7D2EB" stroke-width="26" stroke-linecap="square" fill="none"/>
								
								<!-- Road Grid -->
								<path d="M0 25 L320 25" stroke="#FFFFFF" stroke-width="4"/>
								<path d="M0 65 C100 70 200 60 320 75" stroke="#FFFFFF" stroke-width="4"/>
								<path d="M0 110 L320 110" stroke="#FFFFFF" stroke-width="3"/>
								<path d="M50 0 L50 130" stroke="#FFFFFF" stroke-width="4"/>
								<path d="M130 0 L90 130" stroke="#FFFFFF" stroke-width="4.5"/>
								<path d="M210 0 C200 40 205 90 180 130" stroke="#FFFFFF" stroke-width="4"/>
								<path d="M80 0 L250 130" stroke="#FFFFFF" stroke-width="3"/>
								
								<!-- Pin shadow -->
								<ellipse cx="140" cy="85" rx="6" ry="3" fill="rgba(0,0,0,0.15)"/>
								
								<!-- Map Pin -->
								<g transform="translate(128, 52)">
									<path d="M12 0C5.37 0 0 5.37 0 12C0 19.5 9.6 27.6 11.15 28.87C11.65 29.28 12.35 29.28 12.85 28.87C14.4 27.6 24 19.5 24 12C24 5.37 18.63 0 12 0Z" fill="#657F60"/>
									<circle cx="12" cy="12" r="4.5" fill="#FFFFFF"/>
								</g>
							</svg>
						<?php endif; ?>
					</div>
				</div>

				<!-- Column 2: Contact -->
				<div class="dp-footer__col dp-footer__col--contact">
					<h3 class="dp-footer__title"><?php esc_html_e( 'Contact', 'developer-starter-pro' ); ?></h3>
					<ul class="dp-footer__list">
						<li>
							<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
								<circle cx="12" cy="10" r="3"/>
							</svg>
							<span><?php echo esc_html( ! empty( $clinic_address ) ? $clinic_address : __( 'Apex Dental Care, Central Avenue, City', 'developer-starter-pro' ) ); ?></span>
						</li>
						<li>
							<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
								<polyline points="22,6 12,13 2,6"/>
							</svg>
							<?php 
							$display_email = ! empty( $clinic_email ) ? $clinic_email : 'info@apexdentalcare.com';
							?>
							<a href="mailto:<?php echo esc_attr( $display_email ); ?>"><?php echo esc_html( $display_email ); ?></a>
						</li>
						<li>
							<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
							</svg>
							<?php 
							$display_phone = ! empty( $clinic_phone ) ? $clinic_phone : '+1 800 123 4567';
							$clean_phone = preg_replace( '/[^0-9+]/', '', $display_phone );
							?>
							<a href="tel:<?php echo esc_attr( $clean_phone ); ?>"><?php echo esc_html( $display_phone ); ?></a>
						</li>
					</ul>
				</div>

				<!-- Column 3: Social Us -->
				<div class="dp-footer__col dp-footer__col--social">
					<h3 class="dp-footer__title"><?php esc_html_e( 'Social Us', 'developer-starter-pro' ); ?></h3>
					<ul class="dp-footer__list">
						<li>
							<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
							</svg>
							<a href="https://facebook.com" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Apex Dental Care', 'developer-starter-pro' ); ?></a>
						</li>
						<li>
							<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
								<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
								<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
							</svg>
							<a href="https://instagram.com" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Apex Media', 'developer-starter-pro' ); ?></a>
						</li>
						<li>
							<svg class="dp-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
							</svg>
							<a href="#booking"><?php esc_html_e( 'Contact', 'developer-starter-pro' ); ?></a>
						</li>
					</ul>
				</div>

			</div><!-- .dp-footer__grid -->

			<hr class="dp-footer__sep">

			<div class="dp-footer__bottom">
				<p class="dp-footer__copyright">
					&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php esc_html_e( 'Apex Dental Care. All rights reserved.', 'developer-starter-pro' ); ?>
				</p>
			</div>

		</div><!-- .dp-footer__container -->
	</footer>

	<!-- Back to Top Button -->
	<button class="developer-starter-pro-back-to-top" id="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'developer-starter-pro' ); ?>">
		<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
	</button>

	<!-- WhatsApp Floating Button -->
	<?php
	$wa_enabled  = developer_starter_pro_get_option( 'whatsapp_enabled', '0' );
	$wa_number   = developer_starter_pro_get_option( 'whatsapp_number', '' );
	$wa_message  = developer_starter_pro_get_option( 'whatsapp_message', '' );
	$wa_position = developer_starter_pro_get_option( 'whatsapp_position', 'right' );

	if ( '1' === $wa_enabled && ! empty( $wa_number ) ) :
		// Remove any non-numeric characters from the phone number
		$wa_clean_number = preg_replace( '/[^0-9]/', '', $wa_number );
		$wa_link = 'https://wa.me/' . $wa_clean_number;
		if ( ! empty( $wa_message ) ) {
			$wa_link .= '?text=' . rawurlencode( $wa_message );
		}

		// Detect if chatbot is active and position is right to avoid overlap
		$chatbot_settings = get_option( 'developer_starter_pro_chatbot_settings', array() );
		$chatbot_active   = isset( $chatbot_settings['enabled'] ) ? $chatbot_settings['enabled'] : '1';
		$wa_classes       = array( 'developer-starter-pro-whatsapp-float', 'pos-' . $wa_position );
		if ( '1' === $chatbot_active && 'right' === $wa_position ) {
			$wa_classes[] = 'has-chatbot-active';
		}
		?>
		<a href="<?php echo esc_url( $wa_link ); ?>" 
		   class="<?php echo esc_attr( implode( ' ', $wa_classes ) ); ?>" 
		   target="_blank" 
		   rel="noopener noreferrer" 
		   aria-label="<?php esc_attr_e( 'Contact us on WhatsApp', 'developer-starter-pro' ); ?>">
			<span class="developer-starter-pro-whatsapp-pulse"></span>
			<span class="developer-starter-pro-whatsapp-tooltip"><?php esc_html_e( 'Chat with us!', 'developer-starter-pro' ); ?></span>
			<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
				<path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.248 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.863-9.864.001-2.636-1.023-5.11-2.884-6.974C16.59 1.897 14.1 1.87 11.465 1.87 6.03 1.87 1.606 6.291 1.603 11.737c-.001 1.638.5 3.226 1.458 4.825L2.046 22l5.602-1.468zM17.65 14.49c-.3-.15-1.782-.88-2.057-.98-.275-.1-.475-.15-.675.15-.2.3-.775.98-.95 1.18-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.794-1.49-1.775-1.665-2.075-.175-.3-.019-.462.13-.61.135-.133.3-.35.45-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.625-.925-2.225-.244-.588-.491-.508-.675-.518-.174-.01-.374-.012-.574-.012-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.075 2.9 1.225 3.1c.15.2 2.11 3.22 5.11 4.52.714.31 1.27.496 1.703.635.717.228 1.37.195 1.886.118.574-.085 1.782-.73 2.032-1.435.25-.705.25-1.31.175-1.435-.075-.125-.275-.2-.575-.35z"/>
			</svg>
		</a>
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
		});
	</script>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
