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
 */

$clinic_name = developer_starter_pro_get_option( 'clinic_name', 'DentalPro Elite' );
$clinic_addr = developer_starter_pro_get_option( 'clinic_address', 'Central Avenue, City' );
$saved_hero_image = developer_starter_pro_get_option( 'hero_image' );
$hero_image  = ! empty( $saved_hero_image ) ? $saved_hero_image : get_template_directory_uri() . '/assets/images/hero-patient.png';

// Get first active slide for the CTA button URL
$slides = Developer_Starter_Pro_Hero_Slider::get_slides();
$booking_url = developer_starter_pro_get_booking_url();

// Setup dynamic background style if custom background image is saved
$hero_style = '';
if ( ! empty( $saved_hero_image ) ) {
	$hero_style = 'background-image: url(' . esc_url( $saved_hero_image ) . '); background-size: cover; background-position: center; background-repeat: no-repeat;';
}
?>

<section class="dp-hero" id="hero" style="<?php echo esc_attr( $hero_style ); ?>">
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
				<?php if ( empty( $saved_hero_image ) ) : ?>
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
</section>

<style>
/* =============================================================
   HERO — Pixel-perfect Apex Dental reference recreation
   ============================================================= */

.dp-hero {
	background: #F9F8F5;
	padding: 60px 0 0;
	overflow: hidden;
	position: relative;
}

.dp-hero__container {
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 32px;
}

/* Two-column grid */
.dp-hero__grid {
	display: grid;
	grid-template-columns: 1fr 1fr;
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
	font-size: 3.25rem;
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
	font-size: 1rem;
	font-weight: 500;
	color: #3D3830;
	margin: 14px 0 10px 0;
}

.dp-hero__desc {
	font-size: 0.9375rem;
	color: #6B6355;
	line-height: 1.7;
	margin: 0 0 28px 0;
	max-width: 380px;
}

.dp-hero__cta {
	display: inline-block;
	background: #4E7C59;
	color: #FFFFFF;
	font-size: 0.9rem;
	font-weight: 600;
	padding: 12px 24px;
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
	.dp-hero__grid {
		grid-template-columns: 1fr;
		gap: 0;
		text-align: center;
	}
	.dp-hero__heading {
		font-size: 2.5rem;
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
	.dp-hero {
		padding: 40px 0 0;
	}
	.dp-hero__container {
		padding: 0 20px;
	}
	.dp-hero__heading {
		font-size: 2rem;
	}
}
</style>
