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

	<?php if ( '3' === $header_style || '1' === $header_style ) : ?>
	<!-- Top Bar -->
	<div class="developer-starter-pro-top-bar">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-top-bar-inner">
				<div class="developer-starter-pro-top-bar-left">
					<?php if ( $clinic_phone ) : ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $clinic_phone ) ); ?>" class="developer-starter-pro-top-bar-item">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
							<?php echo esc_html( $clinic_phone ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $clinic_email ) : ?>
						<a href="mailto:<?php echo esc_attr( $clinic_email ); ?>" class="developer-starter-pro-top-bar-item">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							<?php echo esc_html( $clinic_email ); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="developer-starter-pro-top-bar-right">
					<?php
					// Social icons.
					$social_platforms = array( 'facebook', 'instagram', 'twitter', 'youtube', 'linkedin' );
					foreach ( $social_platforms as $platform ) :
						$url = developer_starter_pro_get_option( 'social_' . $platform, '' );
						if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" class="developer-starter-pro-social-icon" aria-label="<?php echo esc_attr( ucfirst( $platform ) ); ?>">
								<?php echo developer_starter_pro_get_social_icon( $platform ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endif;
					endforeach; ?>

					<span class="developer-starter-pro-top-bar-hours">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						<?php echo esc_html( developer_starter_pro_get_today_hours() ); ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- Main Header -->
	<header id="masthead" class="developer-starter-pro-header developer-starter-pro-header--style-<?php echo esc_attr( $header_style ); ?> <?php echo '1' === $header_sticky ? 'developer-starter-pro-header--sticky-enabled' : ''; ?>" role="banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-header-inner">

				<!-- Logo -->
				<div class="developer-starter-pro-logo">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="developer-starter-pro-site-title" rel="home">
							<span class="developer-starter-pro-logo-icon">🦷</span>
							<?php echo esc_html( $clinic_name ); ?>
						</a>
					<?php endif; ?>
				</div>

				<!-- Navigation -->
				<nav id="site-navigation" class="developer-starter-pro-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'developer-starter-pro' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'developer-starter-pro-menu',
							'container'      => false,
							'fallback_cb'    => false,
							'depth'          => 3,
						)
					);
					?>
				</nav>

				<!-- Header Actions -->
				<div class="developer-starter-pro-header-actions">
					<button id="dark-mode-toggle" class="developer-starter-pro-dark-mode-btn" aria-label="<?php esc_attr_e( 'Toggle Dark Mode', 'developer-starter-pro' ); ?>">
						<svg class="sun-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
						<svg class="moon-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
					</button>

					<?php if ( $clinic_phone ) : ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $clinic_phone ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary developer-starter-pro-header-cta">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
							<?php esc_html_e( 'Book Now', 'developer-starter-pro' ); ?>
						</a>
					<?php endif; ?>

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
					<span class="developer-starter-pro-logo-icon">🦷</span>
					<?php echo esc_html( $clinic_name ); ?>
				</div>
				<button class="developer-starter-pro-mobile-close" id="mobile-menu-close" aria-label="<?php esc_attr_e( 'Close Menu', 'developer-starter-pro' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
			</div>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'mobile',
					'menu_id'        => 'mobile-menu-nav',
					'menu_class'     => 'developer-starter-pro-mobile-menu-list',
					'container'      => false,
					'fallback_cb'    => function() {
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_class'     => 'developer-starter-pro-mobile-menu-list',
							'container'      => false,
						) );
					},
					'depth'          => 2,
				)
			);
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
