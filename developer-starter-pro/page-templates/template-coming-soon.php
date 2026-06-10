<?php
/**
 * Template Name: Coming Soon
 *
 * Distraction-free layout for maintenance or pre-launch countdowns.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Basic HTML structure directly to avoid standard header/footer wrappers
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php esc_html_e( 'Coming Soon - DentalPro Elite', 'developer-starter-pro' ); ?></title>
	<?php wp_head(); ?>
	<style>
		body {
			background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
			color: #f8fafc;
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0;
			padding: 20px;
			text-align: center;
		}
		.coming-soon-card {
			background: rgba(30, 41, 59, 0.7);
			border: 1px solid rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(16px);
			padding: 60px 40px;
			border-radius: 20px;
			max-width: 600px;
			width: 100%;
			box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
		}
		h1 {
			font-size: 2.5rem;
			color: #fff;
			margin-top: 0;
			margin-bottom: 15px;
			font-family: 'Outfit', sans-serif;
		}
		p {
			color: #94a3b8;
			font-size: 1.1rem;
			line-height: 1.6;
			margin-bottom: 40px;
		}
		.countdown-grid {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			gap: 15px;
			margin-bottom: 40px;
		}
		.countdown-item {
			background: rgba(255, 255, 255, 0.05);
			border: 1px solid rgba(255, 255, 255, 0.1);
			padding: 15px 10px;
			border-radius: 12px;
		}
		.countdown-number {
			font-size: 2rem;
			font-weight: 800;
			color: #0d9488;
			display: block;
			line-height: 1;
		}
		.countdown-label {
			font-size: 0.75rem;
			color: #64748b;
			text-transform: uppercase;
			margin-top: 6px;
			display: block;
			font-weight: 700;
		}
		.newsletter-form input[type="email"] {
			background: rgba(15, 23, 42, 0.6);
			border: 1px solid rgba(255, 255, 255, 0.15);
			padding: 14px 20px;
			border-radius: 8px;
			color: #fff;
			font-size: 1rem;
			width: 100%;
			max-width: 320px;
			outline: none;
			margin-bottom: 12px;
		}
		.newsletter-form button {
			background: #0d9488;
			color: #fff;
			border: none;
			padding: 14px 30px;
			border-radius: 8px;
			font-weight: 700;
			font-size: 1rem;
			cursor: pointer;
			transition: background 0.2s ease;
		}
		.newsletter-form button:hover {
			background: #0b7a70;
		}
		.contacts-info {
			margin-top: 40px;
			border-top: 1px solid rgba(255, 255, 255, 0.1);
			padding-top: 25px;
			font-size: 0.875rem;
			color: #64748b;
		}
		.contacts-info a {
			color: #0d9488;
			text-decoration: none;
			font-weight: 600;
		}
	</style>
</head>
<body <?php body_class(); ?>>

	<div class="coming-soon-card">
		<div style="font-size: 3.5rem; margin-bottom: 20px;">🦷</div>
		<h1><?php esc_html_e( 'We Are Opening Soon!', 'developer-starter-pro' ); ?></h1>
		<p><?php esc_html_e( 'Our state-of-the-art dental clinic facility is finishing final layouts. Sign up below to get opening discounts and scheduling notifications.', 'developer-starter-pro' ); ?></p>
		
		<!-- Countdown grid -->
		<div class="countdown-grid">
			<div class="countdown-item">
				<span class="countdown-number" id="days">24</span>
				<span class="countdown-label"><?php esc_html_e( 'Days', 'developer-starter-pro' ); ?></span>
			</div>
			<div class="countdown-item">
				<span class="countdown-number" id="hours">12</span>
				<span class="countdown-label"><?php esc_html_e( 'Hours', 'developer-starter-pro' ); ?></span>
			</div>
			<div class="countdown-item">
				<span class="countdown-number" id="minutes">45</span>
				<span class="countdown-label"><?php esc_html_e( 'Mins', 'developer-starter-pro' ); ?></span>
			</div>
			<div class="countdown-item">
				<span class="countdown-number" id="seconds">30</span>
				<span class="countdown-label"><?php esc_html_e( 'Secs', 'developer-starter-pro' ); ?></span>
			</div>
		</div>

		<!-- Newsletter Form -->
		<form class="newsletter-form" action="#" method="post" onsubmit="alert('Thank you for subscribing!'); return false;">
			<div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
				<input type="email" placeholder="<?php esc_attr_e( 'Enter your email address...', 'developer-starter-pro' ); ?>" required>
				<button type="submit"><?php esc_html_e( 'Notify Me', 'developer-starter-pro' ); ?></button>
			</div>
		</form>

		<div class="contacts-info">
			<?php esc_html_e( 'Emergency Desk Support:', 'developer-starter-pro' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', developer_starter_pro_get_option( 'clinic_phone', '' ) ) ); ?>"><?php echo esc_html( developer_starter_pro_get_option( 'clinic_phone', '' ) ); ?></a>
		</div>
	</div>

	<script>
		// Setup basic live countdown timer decrement
		var d = 24, h = 12, m = 45, s = 30;
		setInterval(function() {
			s--;
			if (s < 0) {
				s = 59;
				m--;
				if (m < 0) {
					m = 59;
					h--;
					if (h < 0) {
						h = 23;
						d--;
						if (d < 0) {
							d = 0; h = 0; m = 0; s = 0;
						}
					}
				}
			}
			document.getElementById('days').textContent = d;
			document.getElementById('hours').textContent = h;
			document.getElementById('minutes').textContent = m;
			document.getElementById('seconds').textContent = s;
		}, 1000);
	</script>
	<?php wp_footer(); ?>
</body>
</html>
