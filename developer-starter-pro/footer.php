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
?>

	</div><!-- #content -->

	<footer id="colophon" class="developer-starter-pro-footer developer-starter-pro-footer--style-<?php echo esc_attr( $footer_style ); ?>" role="contentinfo">

		<!-- Main Footer -->
		<div class="developer-starter-pro-footer-main">
			<div class="developer-starter-pro-container">
				<div class="developer-starter-pro-footer-grid developer-starter-pro-footer-grid--<?php echo esc_attr( $footer_style ); ?>">

					<!-- Column 1: About -->
					<div class="developer-starter-pro-footer-col">
						<div class="developer-starter-pro-footer-logo">
							<span class="developer-starter-pro-logo-icon">🦷</span>
							<?php echo esc_html( $clinic_name ); ?>
						</div>
						<p class="developer-starter-pro-footer-about">
							<?php esc_html_e( 'Your trusted partner in dental care. We provide comprehensive dental services with state-of-the-art technology and compassionate care.', 'developer-starter-pro' ); ?>
						</p>
						<div class="developer-starter-pro-footer-social">
							<?php
							$social_platforms = array( 'facebook', 'instagram', 'twitter', 'youtube', 'linkedin' );
							foreach ( $social_platforms as $platform ) :
								$url = developer_starter_pro_get_option( 'social_' . $platform, '' );
								if ( $url ) : ?>
									<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" class="developer-starter-pro-social-icon" aria-label="<?php echo esc_attr( ucfirst( $platform ) ); ?>">
										<?php echo developer_starter_pro_get_social_icon( $platform ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</a>
								<?php endif;
							endforeach; ?>
						</div>
					</div>

					<!-- Column 2: Quick Links -->
					<div class="developer-starter-pro-footer-col">
						<h4 class="developer-starter-pro-footer-title"><?php esc_html_e( 'Quick Links', 'developer-starter-pro' ); ?></h4>
						<?php
						if ( has_nav_menu( 'footer' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'menu_class'     => 'developer-starter-pro-footer-menu',
									'container'      => false,
									'depth'          => 1,
								)
							);
						} else {
							?>
							<ul class="developer-starter-pro-footer-menu">
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'developer-starter-pro' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'developer-starter-pro' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/doctors/' ) ); ?>"><?php esc_html_e( 'Our Doctors', 'developer-starter-pro' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'developer-starter-pro' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'developer-starter-pro' ); ?></a></li>
							</ul>
							<?php
						}
						?>
					</div>

					<!-- Column 3: Contact Info -->
					<div class="developer-starter-pro-footer-col">
						<h4 class="developer-starter-pro-footer-title"><?php esc_html_e( 'Contact Us', 'developer-starter-pro' ); ?></h4>
						<ul class="developer-starter-pro-footer-contact">
							<?php if ( $clinic_address ) : ?>
								<li>
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
									<?php echo esc_html( $clinic_address ); ?>
								</li>
							<?php endif; ?>
							<?php if ( $clinic_phone ) : ?>
								<li>
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $clinic_phone ) ); ?>"><?php echo esc_html( $clinic_phone ); ?></a>
								</li>
							<?php endif; ?>
							<?php if ( $clinic_email ) : ?>
								<li>
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
									<a href="mailto:<?php echo esc_attr( $clinic_email ); ?>"><?php echo esc_html( $clinic_email ); ?></a>
								</li>
							<?php endif; ?>
						</ul>
					</div>

					<?php if ( '1' === $footer_style ) : ?>
					<!-- Column 4: Working Hours (Style 1 only) -->
					<div class="developer-starter-pro-footer-col">
						<h4 class="developer-starter-pro-footer-title"><?php esc_html_e( 'Working Hours', 'developer-starter-pro' ); ?></h4>
						<ul class="developer-starter-pro-footer-hours">
							<?php
							$working_hours = developer_starter_pro_get_working_hours();
							$days_short = array(
								'monday'    => esc_html__( 'Mon', 'developer-starter-pro' ),
								'tuesday'   => esc_html__( 'Tue', 'developer-starter-pro' ),
								'wednesday' => esc_html__( 'Wed', 'developer-starter-pro' ),
								'thursday'  => esc_html__( 'Thu', 'developer-starter-pro' ),
								'friday'    => esc_html__( 'Fri', 'developer-starter-pro' ),
								'saturday'  => esc_html__( 'Sat', 'developer-starter-pro' ),
								'sunday'    => esc_html__( 'Sun', 'developer-starter-pro' ),
							);
							foreach ( $days_short as $day_key => $day_label ) :
								$is_closed = isset( $working_hours[ $day_key ]['closed'] ) && $working_hours[ $day_key ]['closed'];
								$today = strtolower( current_time( 'l' ) );
								$is_today = ( $today === $day_key );
								?>
								<li class="<?php echo $is_today ? 'today' : ''; ?>">
									<span class="day"><?php echo esc_html( $day_label ); ?></span>
									<span class="hours">
										<?php
										if ( $is_closed ) {
											esc_html_e( 'Closed', 'developer-starter-pro' );
										} else {
											echo esc_html( $working_hours[ $day_key ]['open'] . ' - ' . $working_hours[ $day_key ]['close'] );
										}
										?>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( '2' === $footer_style ) : ?>
					<!-- Newsletter (Style 2 only) -->
					<div class="developer-starter-pro-footer-col">
						<h4 class="developer-starter-pro-footer-title"><?php esc_html_e( 'Newsletter', 'developer-starter-pro' ); ?></h4>
						<p><?php esc_html_e( 'Subscribe to get dental tips and special offers.', 'developer-starter-pro' ); ?></p>
						<form class="developer-starter-pro-newsletter-form" action="#" method="post">
							<div class="developer-starter-pro-newsletter-input-group">
								<input type="email" placeholder="<?php esc_attr_e( 'Your email address', 'developer-starter-pro' ); ?>" required>
								<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
									<?php esc_html_e( 'Subscribe', 'developer-starter-pro' ); ?>
								</button>
							</div>
						</form>
					</div>
					<?php endif; ?>

				</div>
			</div>
		</div>

		<!-- Copyright Bar -->
		<div class="developer-starter-pro-footer-bottom">
			<div class="developer-starter-pro-container">
				<div class="developer-starter-pro-footer-bottom-inner">
					<p class="developer-starter-pro-copyright">
						&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( $clinic_name ); ?>.
						<?php esc_html_e( 'All rights reserved.', 'developer-starter-pro' ); ?>
					</p>
					<p class="developer-starter-pro-credits">
						<?php
						printf(
							/* translators: %s: Theme name */
							esc_html__( 'Theme: %s', 'developer-starter-pro' ),
							'DentalPro Elite'
						);
						?>
					</p>
				</div>
			</div>
		</div>

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
		?>
		<a href="<?php echo esc_url( $wa_link ); ?>" 
		   class="developer-starter-pro-whatsapp-float pos-<?php echo esc_attr( $wa_position ); ?>" 
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
