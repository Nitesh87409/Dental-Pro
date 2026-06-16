<?php
/**
 * Template Part: Homepage Hero Section
 *
 * PIXEL-PERFECT recreation matching Apex Dental Care reference design.
 * - No slider arrows
 * - No floating badges
 * - No stats bar
 * - No badge pill
 * - Realistic patient photo, right side
 * - Botanical leaf decoration
 *
 * @package developer-starter-pro
 * @since   1.0.0
 * @modified 2026-06-16
 */

$clinic_name = developer_starter_pro_get_option( 'clinic_name', 'DentalPro Elite' );
$clinic_addr = developer_starter_pro_get_option( 'clinic_address', 'Central Avenue, City' );
$saved_hero_image = developer_starter_pro_get_option( 'hero_image' );
$hero_video  = developer_starter_pro_get_option( 'hero_video' );
$hero_image  = ! empty( $saved_hero_image ) ? $saved_hero_image : get_template_directory_uri() . '/assets/images/hero-patient.png';

// Get first active slide for the CTA button URL
$slides = Developer_Starter_Pro_Hero_Slider::get_slides();
$booking_url = developer_starter_pro_get_booking_url();

// Setup dynamic background style if custom background image is saved
$hero_style = '';
if ( ! empty( $saved_hero_image ) ) {
	$hero_style = 'background-image: url(' . esc_url( $saved_hero_image ) . '); background-size: cover; background-position: center; background-repeat: no-repeat;';
}

$has_media_class = ( ! empty( $saved_hero_image ) || ! empty( $hero_video ) ) ? 'dp-hero--has-media' : '';
?>

<div class="dp-hero-wrapper">
<section class="dp-hero <?php echo esc_attr( $has_media_class ); ?>" id="hero" style="<?php echo esc_attr( $hero_style ); ?>">
	<?php if ( ! empty( $hero_video ) ) : ?>
		<div class="dp-hero__video-wrap">
			<video class="dp-hero__video" autoplay loop muted playsinline>
				<source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
			</video>
		</div>
	<?php endif; ?>
	<div class="dp-hero__container">
		<div class="dp-hero__grid">

			<!-- ==================== LEFT: TEXT ==================== -->
			<div class="dp-hero__content">

				<h1 class="dp-hero__heading">
					<?php esc_html_e( 'Your Smile,', 'developer-starter-pro' ); ?><br>
					<em class="dp-hero__heading-accent"><?php esc_html_e( 'Refined.', 'developer-starter-pro' ); ?></em>
				</h1>

				<p class="dp-hero__tagline">
					<?php esc_html_e( 'Modern Dental Care in Your City.', 'developer-starter-pro' ); ?>
				</p>

				<p class="dp-hero__desc">
					<?php esc_html_e( 'State-of-the-art care offering compassionate, personalized treatments. New patients welcome!', 'developer-starter-pro' ); ?>
				</p>

				<a href="<?php echo esc_url( $booking_url ); ?>" class="dp-hero__cta">
					<?php esc_html_e( 'Book Your Consultation', 'developer-starter-pro' ); ?>
				</a>

				<div class="dp-hero__address">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
						<circle cx="12" cy="10" r="3"/>
					</svg>
					<span><?php echo esc_html( $clinic_name . ', ' . $clinic_addr ); ?></span>
				</div>

			</div><!-- .dp-hero__content -->

			<!-- ==================== RIGHT: IMAGE ==================== -->
			<div class="dp-hero__visual" aria-hidden="true">
				<?php if ( empty( $saved_hero_image ) && empty( $hero_video ) ) : ?>
					<!-- Botanical leaf SVG — top right corner -->
					<div class="dp-hero__leaf">
						<svg viewBox="0 0 160 260" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M80 0 C 50 40, 20 90, 35 160 C 50 220, 80 250, 80 260" stroke="#4E7C59" stroke-width="2" fill="none" opacity="0.55"/>
							<path d="M80 35 C 115 22, 155 48, 142 88 C 130 118, 80 128, 80 128" fill="#7AAB8A" opacity="0.32"/>
							<path d="M80 35 C 48 22, 12 52, 28 90 C 44 120, 80 128, 80 128" fill="#5B8A6A" opacity="0.28"/>
							<path d="M80 95 C 120 82, 152 112, 140 145 C 128 172, 80 180, 80 180" fill="#7AAB8A" opacity="0.28"/>
							<path d="M80 95 C 42 82, 14 116, 30 148 C 46 172, 80 180, 80 180" fill="#4E7C59" opacity="0.22"/>
							<path d="M80 150 C 118 138, 148 164, 136 194 C 124 218, 80 225, 80 225" fill="#7AAB8A" opacity="0.26"/>
							<circle cx="82" cy="33" r="2.5" fill="#C9A84C" opacity="0.65"/>
							<circle cx="143" cy="86" r="2" fill="#C9A84C" opacity="0.55"/>
							<circle cx="138" cy="143" r="1.8" fill="#C9A84C" opacity="0.45"/>
						</svg>
					</div>

					<!-- Cream circle behind the photo -->
					<div class="dp-hero__circle"></div>

					<!-- Patient photo -->
					<div class="dp-hero__photo-wrap">
						<img
							src="<?php echo esc_url( $hero_image ); ?>"
							alt="<?php esc_attr_e( 'Happy dental patient', 'developer-starter-pro' ); ?>"
							class="dp-hero__photo"
							loading="eager"
							width="420"
							height="480"
						>
					</div>
				<?php else : ?>
					<!-- Spacer to preserve grid alignment on desktop -->
					<div class="dp-hero__spacer" style="height: 520px;"></div>
				<?php endif; ?>
			</div><!-- .dp-hero__visual -->

		</div><!-- .dp-hero__grid -->
	</div><!-- .dp-hero__container -->

	<!-- Stats Bar -->
	<div class="dp-stats-bar">
	<!-- Stat 1: Happy Patients -->
	<div class="dp-stats-item">
		<div class="dp-stats-icon-wrap">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<circle cx="12" cy="12" r="10"/>
				<path d="M8 14s1.5 2 4 2 4-2 4-2"/>
				<line x1="9" y1="9" x2="9.01" y2="9"/>
				<line x1="15" y1="9" x2="15.01" y2="9"/>
			</svg>
		</div>
		<div class="dp-stats-text">
			<span class="dp-stats-number">5,000+</span>
			<span class="dp-stats-label"><?php esc_html_e( 'Happy Patients', 'developer-starter-pro' ); ?></span>
		</div>
	</div>

	<!-- Stat 2: Expert Dentists -->
	<div class="dp-stats-item">
		<div class="dp-stats-icon-wrap">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
				<circle cx="9" cy="7" r="4"/>
				<path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
				<path d="M16 3.13a4 4 0 0 1 0 7.75"/>
			</svg>
		</div>
		<div class="dp-stats-text">
			<span class="dp-stats-number">15+</span>
			<span class="dp-stats-label"><?php esc_html_e( 'Expert Dentists', 'developer-starter-pro' ); ?></span>
		</div>
	</div>

	<!-- Stat 3: Patient Rating -->
	<div class="dp-stats-item">
		<div class="dp-stats-icon-wrap">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
			</svg>
		</div>
		<div class="dp-stats-text">
			<span class="dp-stats-number">4.9/5</span>
			<span class="dp-stats-label"><?php esc_html_e( 'Patient Rating', 'developer-starter-pro' ); ?></span>
		</div>
	</div>

	<!-- Stat 4: Advanced Treatments -->
	<div class="dp-stats-item">
		<div class="dp-stats-icon-wrap">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
				<polyline points="9 11 11 13 15 9"/>
			</svg>
		</div>
		<div class="dp-stats-text">
			<span class="dp-stats-number">20+</span>
			<span class="dp-stats-label"><?php esc_html_e( 'Advanced Treatments', 'developer-starter-pro' ); ?></span>
		</div>
	</div>
</div>
</section>
</div>

<style>
/* ---- VIDEO BACKGROUND STYLES ---- */
.dp-hero__video-wrap {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 0;
	overflow: hidden;
}

.dp-hero__video {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.dp-hero__container {
	position: relative;
	z-index: 2;
}

body.dark-mode .dp-hero {
	background: #0F172A;
}

/* Gradient overlay for media background (video/image) */
.dp-hero--has-media::after {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: linear-gradient(90deg, rgba(15, 23, 42, 0.82) 0%, rgba(15, 23, 42, 0.5) 45%, rgba(15, 23, 42, 0.15) 100%);
	z-index: 1;
	pointer-events: none;
}

/* Contrast color overrides for media background */
.dp-hero--has-media .dp-hero__heading {
	color: #FFFFFF;
}

.dp-hero--has-media .dp-hero__heading-accent {
	color: #F59E0B; /* Amber gold */
}

.dp-hero--has-media .dp-hero__tagline {
	color: #F1F5F9;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.dp-hero--has-media .dp-hero__desc {
	color: #CBD5E1;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.dp-hero--has-media .dp-hero__address {
	color: #E2E8F0;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.dp-hero--has-media .dp-hero__address svg {
	color: #F59E0B;
}

.dp-hero--has-media .dp-hero__cta {
	background: #F59E0B;
	color: #0F172A;
}

.dp-hero--has-media .dp-hero__cta:hover {
	background: #D97706;
	color: #0F172A;
}

.dp-hero--has-media .dp-hero__visual {
	display: none !important;
}

/* =============================================================
   HERO — Pixel-perfect Apex Dental reference recreation
   ============================================================= */

.dp-hero-wrapper {
	background: #FAFAF8;
}
body.dark-mode .dp-hero-wrapper {
	background: #0F172A;
}

.dp-stats-bar {
	background: rgba(255, 255, 255, 0.72) !important;
	backdrop-filter: blur(20px);
	-webkit-backdrop-filter: blur(20px);
	border: 1px solid rgba(255, 255, 255, 0.5);
	border-radius: 16px;
	box-shadow: 0 8px 32px 0 rgba(78, 124, 89, 0.08);
	width: calc(100% - 50px);
	max-width: 1100px;
	position: absolute;
	bottom: 35px;
	left: 50%;
	transform: translateX(-50%);
	z-index: 10;
	padding: 10px 24px;
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 20px;
	transition: all 0.3s ease;
}

body.dark-mode .dp-stats-bar {
	background: rgba(30, 41, 59, 0.6);
	border-color: rgba(255, 255, 255, 0.1);
	box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
}

.dp-stats-item {
	display: flex;
	align-items: center;
	gap: 16px;
	padding: 0 20px;
}

.dp-stats-item:not(:last-child) {
	border-right: 1px solid #EAE6DF;
}

body.dark-mode .dp-stats-item:not(:last-child) {
	border-right-color: #334155;
}

.dp-stats-icon-wrap {
	width: 40px;
	height: 40px;
	border-radius: 50%;
	background: var(--developer-starter-pro-primary-light);
	display: flex;
	align-items: center;
	justify-content: center;
	flex-shrink: 0;
}

body.dark-mode .dp-stats-icon-wrap {
	background: rgba(13, 148, 136, 0.15);
}

.dp-stats-icon-wrap svg {
	width: 20px;
	height: 20px;
	color: var(--developer-starter-pro-primary);
}

body.dark-mode .dp-stats-icon-wrap svg {
	color: var(--developer-starter-pro-primary);
}

.dp-stats-text {
	display: flex;
	flex-direction: column;
}

.dp-stats-number {
	font-family: var(--developer-starter-pro-font-primary), -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
	font-size: 1.5rem;
	font-weight: 700;
	color: #1A2E1A;
	line-height: 1.2;
}

body.dark-mode .dp-stats-number {
	color: #F8FAFC;
}

.dp-stats-label {
	font-size: 0.9375rem;
	color: #3D3830;
	font-weight: 600;
}

body.dark-mode .dp-stats-label {
	color: #94A3B8;
}

.dp-hero {
	background: #F9F8F5;
	padding: 100px 0 120px; /* space for header at top, stats bar at bottom */
	overflow: hidden;
	position: relative;
	margin: 0;
	border-radius: 0;
	min-height: 100vh;
	display: flex;
	align-items: center;
	box-sizing: border-box;
}

.dp-hero__container {
	width: 100%;
	max-width: 100%;
	margin: 0;
	padding: 0 5% 0 15%;
	box-sizing: border-box;
}

/* Two-column grid */
.dp-hero__grid {
	display: grid;
	grid-template-columns: 1.3fr 0.7fr; /* Shift ratio slightly leftwards */
	align-items: center;
	gap: 48px;
	min-height: 480px;
}

/* ---- LEFT CONTENT ---- */
.dp-hero__content {
	padding-bottom: 48px;
}

.dp-hero__heading {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 4.25rem;
	font-weight: 700;
	line-height: 1.12;
	color: #1A2E1A;
	margin: 0 0 4px 0;
	letter-spacing: -0.5px;
}

.dp-hero__heading-accent {
	color: #B8975A;
	font-style: italic;
	font-family: 'Playfair Display', Georgia, serif;
	font-weight: 700;
}

.dp-hero__tagline {
	font-size: 1.25rem;
	font-weight: 500;
	color: #3D3830;
	margin: 14px 0 10px 0;
}

.dp-hero__desc {
	font-size: 1.1rem;
	color: #6B6355;
	line-height: 1.7;
	margin: 0 0 28px 0;
	max-width: 480px;
}

.dp-hero__cta {
	display: inline-block;
	background: #4E7C59;
	color: #FFFFFF;
	font-size: 1rem;
	font-weight: 600;
	padding: 14px 28px;
	border-radius: 6px;
	text-decoration: none;
	transition: background 0.2s ease;
}

.dp-hero__cta:hover {
	background: #3D6347;
	color: #fff;
}

.dp-hero__address {
	display: flex;
	align-items: center;
	gap: 7px;
	margin-top: 22px;
	color: #7D7468;
	font-size: 0.875rem;
}

.dp-hero__address svg {
	color: #4E7C59;
	flex-shrink: 0;
}

/* ---- RIGHT VISUAL ---- */
.dp-hero__visual {
	position: relative;
	display: flex;
	align-items: flex-end;
	justify-content: center;
	height: 520px;
}

/* Botanical leaf */
.dp-hero__leaf {
	position: absolute;
	top: -10px;
	right: 10px;
	width: 130px;
	z-index: 3;
	pointer-events: none;
}

/* Cream circle */
.dp-hero__circle {
	position: absolute;
	width: 360px;
	height: 360px;
	border-radius: 50%;
	background: #EDE9DF;
	top: 60px;
	right: 20px;
	z-index: 0;
}

/* Photo wrapper — clips bottom, organic shape */
.dp-hero__photo-wrap {
	position: relative;
	z-index: 2;
	width: 340px;
	height: 460px;
	overflow: hidden;
	border-radius: 50% 50% 0 0 / 55% 55% 0 0;
	bottom: 0;
}

.dp-hero__photo {
	width: 100%;
	height: 100%;
	object-fit: cover;
	object-position: top center;
	display: block;
}

/* ---- RESPONSIVE ---- */
@media (max-width: 991px) {
	.dp-stats-bar {
		margin: 0 auto;
		position: absolute;
		bottom: 25px;
		width: 90%;
		grid-template-columns: repeat(2, 1fr);
		gap: 24px 0;
	}
	.dp-stats-item:nth-child(2n) {
		border-right: none;
	}
	.dp-hero {
		margin: 0;
		border-radius: 0;
	}
	.dp-hero__grid {
		grid-template-columns: 1fr;
		gap: 0;
		text-align: center;
	}
	.dp-hero__heading {
		font-size: 3rem;
	}
	.dp-hero__tagline {
		font-weight: 500;
		font-size: 1.125rem;
	}
	.dp-hero__desc {
		max-width: 100%;
		margin-left: auto;
		margin-right: auto;
	}
	.dp-hero__address {
		justify-content: center;
	}
	.dp-hero__visual {
		height: 360px;
		margin-top: 32px;
	}
	.dp-hero__circle {
		width: 260px;
		height: 260px;
		top: 20px;
		right: 50%;
		transform: translateX(50%);
	}
	.dp-hero__photo-wrap {
		width: 240px;
		height: 320px;
	}
	.dp-hero__leaf {
		right: 20px;
		width: 90px;
	}
}

@media (max-width: 600px) {
	.dp-stats-bar {
		position: relative;
		margin: 20px auto 0 auto;
		bottom: auto;
		left: auto;
		transform: none;
		grid-template-columns: 1fr;
		gap: 20px;
		padding: 20px;
		width: calc(100% - 40px);
	}
	.dp-stats-item {
		border-right: none !important;
		padding: 0 10px;
	}
	.dp-hero {
		margin: 0;
		border-radius: 0;
		padding: 100px 0 40px;
		min-height: auto;
	}
	.dp-hero__container {
		padding: 0 20px;
	}
	.dp-hero__heading {
		font-size: 2.25rem;
	}
}
</style>
