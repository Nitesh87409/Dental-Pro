<?php
/**
 * Header Template
 *
 * Displays the <head> section and site header with dynamic style selection.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$header_style = developer_starter_pro_get_option( 'header_style', '1' );
$header_sticky = developer_starter_pro_get_option( 'header_sticky', '1' );
$clinic_name  = developer_starter_pro_get_option( 'clinic_name', 'DentalPro Elite' );
$clinic_phone = developer_starter_pro_get_option( 'clinic_phone', '' );
$clinic_email = developer_starter_pro_get_option( 'clinic_email', '' );
$emergency_phone = developer_starter_pro_get_option( 'emergency_phone', '' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="developer-starter-pro-site">
	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to content', 'developer-starter-pro' ); ?>
	</a>

	<!-- Main Header -->
	<header id="masthead" class="developer-starter-pro-header developer-starter-pro-header--style-1 <?php echo '1' === $header_sticky ? 'developer-starter-pro-header--sticky-enabled' : ''; ?>" role="banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-header-inner">

				<!-- Logo -->
				<div class="developer-starter-pro-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dp-logo-link" rel="home">
						<svg class="dp-logo-svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#657F60" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M12 5c-1.5-2.5-4.5-2.5-6.5-1C3.5 5.5 3.5 8.5 4 11.5c.8 4.5 4 8 7 9.5v1.5"/>
							<path d="M12 5c1.5-2.5 4.5-2.5 6.5-1 2 1.5 2 4.5 1.5 7.5-.8 4.5-4 8-7 9.5v1.5"/>
							<path d="M9.5 11c1 1 2.5 1 3.5 0" stroke-width="1.3"/>
						</svg>
						<div class="dp-logo-text">
							<span class="brand-apex">Apex</span>
							<span class="brand-sub">Dental Care</span>
						</div>
					</a>
				</div>

				<!-- Navigation -->
				<nav id="site-navigation" class="developer-starter-pro-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'developer-starter-pro' ); ?>">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'developer-starter-pro-menu',
								'container'      => false,
								'depth'          => 3,
							)
						);
					} else {
						$services_url    = developer_starter_pro_get_template_page_url( 'page-templates/template-services.php', '#services' );
						$doctors_url     = developer_starter_pro_get_template_page_url( 'page-templates/template-doctors.php', '#doctors' );
						$beforeafter_url = developer_starter_pro_get_template_page_url( 'page-templates/template-before-after.php', '#before-after' );
						$pricing_url     = developer_starter_pro_get_template_page_url( 'page-templates/template-pricing.php', '#pricing' );
						$portal_url      = developer_starter_pro_get_template_page_url( 'page-templates/template-patient-login.php', '#portal' );
						$video_url       = developer_starter_pro_get_template_page_url( 'page-templates/template-video-consult.php', '#video' );

						echo '<ul id="primary-menu" class="developer-starter-pro-menu">';
						echo '<li><a href="' . esc_url( $services_url ) . '">' . esc_html__( 'Our Services', 'developer-starter-pro' ) . '</a></li>';
						echo '<li><a href="' . esc_url( $doctors_url ) . '">' . esc_html__( 'Meet the Team', 'developer-starter-pro' ) . '</a></li>';
						echo '<li><a href="' . esc_url( $beforeafter_url ) . '">' . esc_html__( 'Before & After', 'developer-starter-pro' ) . '</a></li>';
						echo '<li><a href="' . esc_url( $pricing_url ) . '">' . esc_html__( 'Cost Calculator', 'developer-starter-pro' ) . '</a></li>';
						echo '<li><a href="' . esc_url( $portal_url ) . '">' . esc_html__( 'Patient Portal', 'developer-starter-pro' ) . '</a></li>';
						echo '<li><a href="' . esc_url( $video_url ) . '">' . esc_html__( 'Video Consult', 'developer-starter-pro' ) . '</a></li>';
						echo '</ul>';
					}
					?>
				</nav>

				<!-- Header Actions -->
				<div class="developer-starter-pro-header-actions">
					<a href="tel:+18001234567" class="dp-header-call-btn">
						<svg class="dp-header-call-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
						</svg>
						<div class="dp-header-call-text">
							<span class="dp-header-call-label"><?php esc_html_e( 'Call Now', 'developer-starter-pro' ); ?></span>
							<span class="dp-header-call-num"><?php esc_html_e( '+1 800 123 4567', 'developer-starter-pro' ); ?></span>
						</div>
					</a>

					<!-- Mobile Menu Toggle -->
					<button class="developer-starter-pro-mobile-toggle" id="mobile-menu-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle Menu', 'developer-starter-pro' ); ?>">
						<span class="developer-starter-pro-hamburger">
							<span></span>
							<span></span>
							<span></span>
						</span>
					</button>
				</div>
			</div>
		</div>
	</header>

	<!-- Mobile Menu Overlay -->
	<div class="developer-starter-pro-mobile-menu" id="mobile-menu" aria-hidden="true">
		<div class="developer-starter-pro-mobile-menu-inner">
			<div class="developer-starter-pro-mobile-menu-header">
				<div class="developer-starter-pro-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dp-logo-link" rel="home">
						<svg class="dp-logo-svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#657F60" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M12 5c-1.5-2.5-4.5-2.5-6.5-1C3.5 5.5 3.5 8.5 4 11.5c.8 4.5 4 8 7 9.5v1.5"/>
							<path d="M12 5c1.5-2.5 4.5-2.5 6.5-1 2 1.5 2 4.5 1.5 7.5-.8 4.5-4 8-7 9.5v1.5"/>
							<path d="M9.5 11c1 1 2.5 1 3.5 0" stroke-width="1.3"/>
						</svg>
						<div class="dp-logo-text">
							<span class="brand-apex" style="font-size: 1.1rem; font-weight: 700; color: #1A2E1A;">Apex</span>
							<span class="brand-sub" style="font-size: 0.7rem; color: #7D7468; display: block; line-height: 1.1;">Dental Care</span>
						</div>
					</a>
				</div>
				<button class="developer-starter-pro-mobile-close" id="mobile-menu-close" aria-label="<?php esc_attr_e( 'Close Menu', 'developer-starter-pro' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
			</div>
			<?php
			if ( has_nav_menu( 'mobile' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'mobile',
						'menu_id'        => 'mobile-menu-nav',
						'menu_class'     => 'developer-starter-pro-mobile-menu-list',
						'container'      => false,
						'depth'          => 2,
					)
				);
			} elseif ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'mobile-menu-nav',
						'menu_class'     => 'developer-starter-pro-mobile-menu-list',
						'container'      => false,
						'depth'          => 2,
					)
				);
			} else {
				$services_url    = developer_starter_pro_get_template_page_url( 'page-templates/template-services.php', '#services' );
				$doctors_url     = developer_starter_pro_get_template_page_url( 'page-templates/template-doctors.php', '#doctors' );
				$beforeafter_url = developer_starter_pro_get_template_page_url( 'page-templates/template-before-after.php', '#before-after' );
				$pricing_url     = developer_starter_pro_get_template_page_url( 'page-templates/template-pricing.php', '#pricing' );
				$portal_url      = developer_starter_pro_get_template_page_url( 'page-templates/template-patient-login.php', '#portal' );
				$video_url       = developer_starter_pro_get_template_page_url( 'page-templates/template-video-consult.php', '#video' );

				echo '<ul id="mobile-menu-nav" class="developer-starter-pro-mobile-menu-list">';
				echo '<li><a href="' . esc_url( $services_url ) . '">' . esc_html__( 'Our Services', 'developer-starter-pro' ) . '</a></li>';
				echo '<li><a href="' . esc_url( $doctors_url ) . '">' . esc_html__( 'Meet the Team', 'developer-starter-pro' ) . '</a></li>';
				echo '<li><a href="' . esc_url( $beforeafter_url ) . '">' . esc_html__( 'Before & After', 'developer-starter-pro' ) . '</a></li>';
				echo '<li><a href="' . esc_url( $pricing_url ) . '">' . esc_html__( 'Cost Calculator', 'developer-starter-pro' ) . '</a></li>';
				echo '<li><a href="' . esc_url( $portal_url ) . '">' . esc_html__( 'Patient Portal', 'developer-starter-pro' ) . '</a></li>';
				echo '<li><a href="' . esc_url( $video_url ) . '">' . esc_html__( 'Video Consult', 'developer-starter-pro' ) . '</a></li>';
				echo '</ul>';
			}
			?>
			<div class="developer-starter-pro-mobile-menu-footer">
				<?php if ( $clinic_phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $clinic_phone ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary developer-starter-pro-btn--full">
						<?php esc_html_e( 'Call Now', 'developer-starter-pro' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php if ( $emergency_phone ) : ?>
	<!-- Emergency Call Floating Button -->
	<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $emergency_phone ) ); ?>" class="developer-starter-pro-emergency-btn" aria-label="<?php esc_attr_e( 'Emergency Call', 'developer-starter-pro' ); ?>" title="<?php esc_attr_e( 'Emergency Call', 'developer-starter-pro' ); ?>">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
		<span class="developer-starter-pro-emergency-text"><?php esc_html_e( 'Emergency', 'developer-starter-pro' ); ?></span>
	</a>
	<?php endif; ?>

	<div id="content" class="developer-starter-pro-site-content">
