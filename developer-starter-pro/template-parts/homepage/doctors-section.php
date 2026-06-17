<?php
/**
 * Template Part: Homepage Doctors / Meet Our Experts Section
 *
 * Premium dental clinic design: dark bg, portrait cards with
 * gradient overlay, gold specialty badge, slider carousel.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$doctors = get_posts( array(
	'post_type'      => 'doctors',
	'posts_per_page' => 8,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );
?>

<section class="dpt-doctors" id="doctors">

	<!-- Decorative background elements -->
	<div class="dpt-doctors__bg-deco" aria-hidden="true">
		<div class="dpt-deco-orb dpt-deco-orb--1"></div>
		<div class="dpt-deco-orb dpt-deco-orb--2"></div>
		<svg class="dpt-deco-cross dpt-deco-cross--1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 2v20M2 12h20"/></svg>
		<svg class="dpt-deco-cross dpt-deco-cross--2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 2v20M2 12h20"/></svg>
	</div>

	<div class="dpt-doctors__container">

		<!-- Section Header -->
		<div class="dpt-doctors__header">
			<span class="dpt-doctors__eyebrow">
				<svg viewBox="0 0 20 20" fill="currentColor" width="6" height="6"><circle cx="10" cy="10" r="10"/></svg>
				<?php esc_html_e( 'Our Medical Team', 'developer-starter-pro' ); ?>
				<svg viewBox="0 0 20 20" fill="currentColor" width="6" height="6"><circle cx="10" cy="10" r="10"/></svg>
			</span>
			<h2 class="dpt-doctors__title"><?php esc_html_e( 'Meet Our Experts', 'developer-starter-pro' ); ?></h2>
			<div class="dpt-doctors__rule" aria-hidden="true">
				<span></span>
				<svg viewBox="0 0 24 24" fill="#C9A84C" width="14" height="14"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
				<span></span>
			</div>
			<p class="dpt-doctors__subtitle">
				<?php esc_html_e( 'Our experienced dental professionals are dedicated to providing exceptional care with a gentle touch.', 'developer-starter-pro' ); ?>
			</p>
		</div>

		<!-- Slider Outer -->
		<div class="dpt-doctors__slider-outer">

			<!-- Prev Arrow -->
			<button class="dpt-doctors__arrow dpt-doctors__arrow--prev" aria-label="<?php esc_attr_e( 'Previous doctor', 'developer-starter-pro' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="20" height="20"><polyline points="15 18 9 12 15 6"/></svg>
			</button>

			<!-- Slider Track -->
			<div class="dpt-doctors__slider-container">
				<div class="dpt-doctors__slider-track">
					<?php
					$display_doctors = array();
					if ( ! empty( $doctors ) ) {
						foreach ( $doctors as $doctor ) {
							$specialty  = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_specialization', true ) ?: __( 'Dental Specialist', 'developer-starter-pro' );
							$bio        = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_bio', true );
							$photo_html = '';

							if ( has_post_thumbnail( $doctor->ID ) ) {
								$photo_html = get_the_post_thumbnail( $doctor->ID, 'medium_large', array( 'alt' => esc_attr( $doctor->post_title ) ) );
							} else {
								$slug = sanitize_title( $doctor->post_title );
								if ( strpos( $slug, 'connor' ) !== false || strpos( $slug, 'chen' ) !== false ) {
									$demo_img = 'dr-emma-chen.png';
								} elseif ( strpos( $slug, 'mercer' ) !== false || strpos( $slug, 'patel' ) !== false ) {
									$demo_img = 'dr-james-patel.png';
								} elseif ( strpos( $slug, 'jessica' ) !== false || strpos( $slug, 'miller' ) !== false ) {
									$demo_img = 'dr-sarah-mitchell.png';
								} elseif ( strpos( $slug, 'michael' ) !== false || strpos( $slug, 'ross' ) !== false ) {
									$demo_img = 'dr-michael-ross.png';
								} else {
									$img_choices = array( 'dr-sarah-mitchell.png', 'dr-james-patel.png', 'dr-emma-chen.png', 'dr-michael-ross.png' );
									$demo_img    = $img_choices[ $doctor->ID % 4 ];
								}
								$photo_html = '<img src="' . esc_url( get_theme_file_uri( 'assets/images/' . $demo_img ) ) . '" alt="' . esc_attr( $doctor->post_title ) . '">';
							}

							$display_doctors[] = array(
								'name'      => $doctor->post_title,
								'specialty' => $specialty,
								'bio'       => $bio,
								'photo'     => $photo_html,
								'url'       => get_permalink( $doctor->ID ),
							);
						}
					}

					// Fallback defaults
					$default_doctors = array(
						array(
							'name'      => __( 'Dr. Sarah Connor', 'developer-starter-pro' ),
							'specialty' => __( 'Dental Specialist', 'developer-starter-pro' ),
							'bio'       => __( '12+ years of experience in restorative and preventive dentistry.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-emma-chen.png' ) ) . '" alt="Dr. Sarah Connor">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Alex Mercer', 'developer-starter-pro' ),
							'specialty' => __( 'Orthodontist', 'developer-starter-pro' ),
							'bio'       => __( 'Specialist in clear aligners and traditional braces for all ages.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-james-patel.png' ) ) . '" alt="Dr. Alex Mercer">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Jessica Miller', 'developer-starter-pro' ),
							'specialty' => __( 'Cosmetic Dentist', 'developer-starter-pro' ),
							'bio'       => __( 'Expert in smile makeovers, veneers, and teeth whitening treatments.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-sarah-mitchell.png' ) ) . '" alt="Dr. Jessica Miller">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Sarah Mitchell', 'developer-starter-pro' ),
							'specialty' => __( 'Oral Surgeon', 'developer-starter-pro' ),
							'bio'       => __( 'Experienced in implant placement, extractions, and bone grafting.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-michael-ross.png' ) ) . '" alt="Dr. Sarah Mitchell">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. James Patel', 'developer-starter-pro' ),
							'specialty' => __( 'Endodontist', 'developer-starter-pro' ),
							'bio'       => __( 'Root canal specialist focused on pain-free endodontic treatments.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-james-patel.png' ) ) . '" alt="Dr. James Patel">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Emma Chen', 'developer-starter-pro' ),
							'specialty' => __( 'Periodontist', 'developer-starter-pro' ),
							'bio'       => __( 'Gum disease treatment and dental implant maintenance specialist.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-emma-chen.png' ) ) . '" alt="Dr. Emma Chen">',
							'url'       => '#',
						),
					);

					if ( count( $display_doctors ) < 4 ) {
						$needed = 4 - count( $display_doctors );
						for ( $i = 0; $i < $needed; $i++ ) {
							$display_doctors[] = $default_doctors[ $i % count( $default_doctors ) ];
						}
					}

					foreach ( $display_doctors as $idx => $doc ) :
					?>
					<article class="dpt-doctor-card">
						<!-- Photo with overlay -->
						<div class="dpt-doctor-card__photo-wrap">
							<div class="dpt-doctor-card__photo">
								<?php echo $doc['photo']; // phpcs:ignore ?>
							</div>

							<!-- Hover overlay -->
							<div class="dpt-doctor-card__overlay">
								<div class="dpt-doctor-card__overlay-content">
									<?php if ( ! empty( $doc['bio'] ) ) : ?>
									<p class="dpt-doctor-card__bio"><?php echo esc_html( $doc['bio'] ); ?></p>
									<?php endif; ?>
									<a href="<?php echo esc_url( $doc['url'] ); ?>" class="dpt-doctor-card__view-btn">
										<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
										<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
									</a>
								</div>
							</div>

							<!-- Number badge -->
							<div class="dpt-doctor-card__num" aria-hidden="true"><?php echo str_pad( $idx + 1, 2, '0', STR_PAD_LEFT ); ?></div>
						</div>

						<!-- Info -->
						<div class="dpt-doctor-card__info">
							<h3 class="dpt-doctor-card__name">
								<a href="<?php echo esc_url( $doc['url'] ); ?>"><?php echo esc_html( $doc['name'] ); ?></a>
							</h3>
							<span class="dpt-doctor-card__specialty">
								<svg viewBox="0 0 12 12" fill="currentColor" width="7" height="7"><circle cx="6" cy="6" r="6"/></svg>
								<?php echo esc_html( $doc['specialty'] ); ?>
							</span>
						</div>
					</article>
					<?php endforeach; ?>
				</div><!-- /.dpt-doctors__slider-track -->
			</div><!-- /.dpt-doctors__slider-container -->

			<!-- Next Arrow -->
			<button class="dpt-doctors__arrow dpt-doctors__arrow--next" aria-label="<?php esc_attr_e( 'Next doctor', 'developer-starter-pro' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="20" height="20"><polyline points="9 18 15 12 9 6"/></svg>
			</button>
		</div><!-- /.dpt-doctors__slider-outer -->

		<!-- Dot Indicators -->
		<div class="dpt-doctors__dots" aria-hidden="true"></div>

	</div><!-- /.dpt-doctors__container -->
</section>

<style>
/* =====================================================
   DOCTORS SECTION — Premium Dental Clinic v2
   ===================================================== */

.dpt-doctors {
	position: relative;
	background: linear-gradient(160deg, #F4F8F5 0%, #FAFCFA 50%, #EEF4F0 100%);
	padding: 96px 0 100px;
	overflow: hidden;
}

/* Decorative background */
.dpt-doctors__bg-deco { position: absolute; inset: 0; pointer-events: none; }

.dpt-deco-orb {
	position: absolute;
	border-radius: 50%;
	filter: blur(80px);
}
.dpt-deco-orb--1 {
	width: 500px; height: 500px;
	background: radial-gradient(circle, rgba(78,124,89,0.10) 0%, transparent 70%);
	top: -120px; left: -80px;
}
.dpt-deco-orb--2 {
	width: 400px; height: 400px;
	background: radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 70%);
	bottom: -80px; right: -60px;
}
.dpt-deco-cross {
	position: absolute;
	color: rgba(78,124,89,0.12);
}
.dpt-deco-cross--1 { width: 48px; height: 48px; top: 18%; right: 12%; }
.dpt-deco-cross--2 { width: 32px; height: 32px; bottom: 22%; left: 8%; }

/* Container */
.dpt-doctors__container {
	position: relative;
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 32px;
	z-index: 1;
}

/* ── Header ── */
.dpt-doctors__header {
	text-align: center;
	margin-bottom: 60px;
}

.dpt-doctors__eyebrow {
	display: inline-flex;
	align-items: center;
	gap: 10px;
	font-size: 0.65rem;
	font-weight: 700;
	letter-spacing: 0.25em;
	text-transform: uppercase;
	color: #4E7C59;
	background: rgba(78,124,89,0.1);
	padding: 5px 14px;
	border-radius: 20px;
	margin-bottom: 16px;
}

.dpt-doctors__title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: clamp(2rem, 3.5vw, 2.8rem);
	font-weight: 700;
	color: #1A2E1A;
	margin: 0 0 16px 0;
	letter-spacing: -0.5px;
	line-height: 1.15;
}

.dpt-doctors__rule {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 12px;
	margin-bottom: 18px;
}
.dpt-doctors__rule span {
	display: block;
	height: 2px;
	width: 56px;
	background: linear-gradient(90deg, transparent, #C9A84C);
	border-radius: 2px;
}
.dpt-doctors__rule span:last-child {
	background: linear-gradient(90deg, #C9A84C, transparent);
}

.dpt-doctors__subtitle {
	font-size: 0.97rem;
	color: #5A6E5A;
	line-height: 1.75;
	max-width: 500px;
	margin: 0 auto;
}

/* ── Slider ── */
.dpt-doctors__slider-outer {
	position: relative;
	display: flex;
	align-items: center;
}

.dpt-doctors__slider-container {
	overflow: hidden;
	width: 100%;
	padding: 16px 0 20px;
	margin: -16px 0 -20px;
}

.dpt-doctors__slider-track {
	display: flex;
	gap: 22px;
	transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* ── Doctor Card ── */
.dpt-doctor-card {
	flex: 0 0 calc((100% - 66px) / 4);
	box-sizing: border-box;
	display: flex;
	flex-direction: column;
}

/* Photo wrap */
.dpt-doctor-card__photo-wrap {
	position: relative;
	border-radius: 16px 16px 0 0;
	overflow: hidden;
	background: #E8EFE8;
	margin-bottom: 0;
}

.dpt-doctor-card__photo {
	width: 100%;
	aspect-ratio: 3 / 4;
	overflow: hidden;
}

.dpt-doctor-card__photo img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	object-position: center top;
	display: block;
	transition: transform 0.5s ease;
}

.dpt-doctor-card:hover .dpt-doctor-card__photo img {
	transform: scale(1.06);
}

/* Permanent bottom gradient for readability */
.dpt-doctor-card__photo-wrap::after {
	content: '';
	position: absolute;
	bottom: 0; left: 0; right: 0;
	height: 50%;
	background: linear-gradient(to top, rgba(10,20,10,0.85) 0%, transparent 100%);
	pointer-events: none;
	transition: height 0.4s ease;
	z-index: 1;
}

/* Hover overlay */
.dpt-doctor-card__overlay {
	position: absolute;
	inset: 0;
	background: linear-gradient(
		to top,
		rgba(26,46,26,0.95) 0%,
		rgba(46,77,46,0.88) 40%,
		rgba(78,124,89,0.60) 70%,
		rgba(78,124,89,0.10) 100%
	);
	display: flex;
	align-items: flex-end;
	justify-content: flex-start;
	padding: 22px 20px;
	opacity: 0;
	transition: opacity 0.35s ease;
	z-index: 2;
}

.dpt-doctor-card:hover .dpt-doctor-card__overlay {
	opacity: 1;
}

.dpt-doctor-card__overlay-content {
	transform: translateY(12px);
	transition: transform 0.35s ease;
}
.dpt-doctor-card:hover .dpt-doctor-card__overlay-content {
	transform: translateY(0);
}

.dpt-doctor-card__bio {
	font-size: 0.8rem;
	color: rgba(255,255,255,0.8);
	line-height: 1.6;
	margin: 0 0 14px 0;
}

.dpt-doctor-card__view-btn {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	padding: 8px 16px;
	background: linear-gradient(135deg, #C9A84C, #E8C76A);
	color: #1A2E1A;
	border-radius: 20px;
	font-size: 0.76rem;
	font-weight: 700;
	text-decoration: none;
	letter-spacing: 0.02em;
	transition: box-shadow 0.25s ease, transform 0.2s ease;
}
.dpt-doctor-card__view-btn:hover {
	box-shadow: 0 6px 20px rgba(201,168,76,0.4);
	transform: translateX(2px);
}

/* Card number */
.dpt-doctor-card__num {
	position: absolute;
	top: 14px;
	right: 14px;
	width: 32px;
	height: 32px;
	background: rgba(255,255,255,0.85);
	border: 1px solid rgba(78,124,89,0.2);
	border-radius: 8px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 0.7rem;
	font-weight: 700;
	color: #4E7C59;
	letter-spacing: 0.02em;
	z-index: 3;
	backdrop-filter: blur(4px);
}

/* ── Info Bar ── */
.dpt-doctor-card__info {
	background: #FFFFFF;
	border: 1px solid rgba(78,124,89,0.12);
	border-top: 0;
	border-radius: 0 0 16px 16px;
	padding: 16px 18px;
	text-align: center;
	box-shadow: 0 4px 16px rgba(26,46,26,0.07);
}

/* Re-attach photo to info bar */
.dpt-doctor-card__photo-wrap {
	border-radius: 16px 16px 0 0;
}

.dpt-doctor-card__name {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1rem;
	font-weight: 600;
	color: #1A2E1A;
	margin: 0 0 7px 0;
	line-height: 1.3;
}
.dpt-doctor-card__name a {
	color: #1A2E1A;
	text-decoration: none;
	transition: color 0.2s;
}
.dpt-doctor-card__name a:hover { color: #4E7C59; }

.dpt-doctor-card__specialty {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	font-size: 0.7rem;
	font-weight: 700;
	letter-spacing: 0.12em;
	text-transform: uppercase;
	color: #4E7C59;
}

/* ── Arrows ── */
.dpt-doctors__arrow {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	width: 46px;
	height: 46px;
	border-radius: 50%;
	background: rgba(255,255,255,0.9);
	border: 1.5px solid rgba(78,124,89,0.2);
	color: #4E7C59;
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	z-index: 10;
	transition: all 0.25s ease;
	box-shadow: 0 4px 12px rgba(26,46,26,0.1);
}
.dpt-doctors__arrow:hover {
	background: #4E7C59;
	color: #FFFFFF;
	border-color: #4E7C59;
	box-shadow: 0 6px 20px rgba(78,124,89,0.3);
}
.dpt-doctors__arrow--prev { left: -23px; }
.dpt-doctors__arrow--next { right: -23px; }

/* ── Dots ── */
.dpt-doctors__dots {
	display: flex;
	justify-content: center;
	gap: 8px;
	margin-top: 36px;
}
.dpt-dot {
	width: 8px; height: 8px;
	border-radius: 50%;
	background: rgba(78,124,89,0.2);
	cursor: pointer;
	transition: all 0.3s ease;
	border: none;
}
.dpt-dot--active {
	background: #4E7C59;
	width: 24px;
	border-radius: 4px;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
	.dpt-doctor-card { flex: 0 0 calc((100% - 22px) / 2); }
	.dpt-doctors__arrow { display: none; }
}
@media (max-width: 600px) {
	.dpt-doctors { padding: 64px 0 72px; }
	.dpt-doctor-card { flex: 0 0 80%; }
	.dpt-doctors__container { padding: 0 20px; }
	.dpt-doctors__header { margin-bottom: 40px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var container = document.querySelector('.dpt-doctors__slider-container');
	if (!container) return;

	var track    = container.querySelector('.dpt-doctors__slider-track');
	var cards    = track.querySelectorAll('.dpt-doctor-card');
	var prevBtn  = document.querySelector('.dpt-doctors__arrow--prev');
	var nextBtn  = document.querySelector('.dpt-doctors__arrow--next');
	var dotsWrap = document.querySelector('.dpt-doctors__dots');

	var currentIndex     = 0;
	var autoPlayInterval = null;
	var INTERVAL_MS      = 3500;

	function getItemsPerView() {
		if (window.innerWidth <= 600)  return 1;
		if (window.innerWidth <= 1024) return 2;
		return 4;
	}

	function getMaxIndex() {
		return Math.max(0, cards.length - getItemsPerView());
	}

	function updateSlider() {
		var ipv = getItemsPerView();
		var max = getMaxIndex();

		if (currentIndex > max) currentIndex = 0;
		if (currentIndex < 0)   currentIndex = max;

		var cardWidth = cards[0] ? cards[0].getBoundingClientRect().width : 0;
		track.style.transform = 'translateX(-' + (currentIndex * (cardWidth + 22)) + 'px)';

		// Update dots
		if (dotsWrap) {
			var dots = dotsWrap.querySelectorAll('.dpt-dot');
			dots.forEach(function (d, i) {
				d.classList.toggle('dpt-dot--active', i === currentIndex);
			});
		}
	}

	function renderDots() {
		if (!dotsWrap) return;
		dotsWrap.innerHTML = '';
		var max = getMaxIndex();
		for (var i = 0; i <= max; i++) {
			var dot = document.createElement('button');
			dot.className = 'dpt-dot' + (i === currentIndex ? ' dpt-dot--active' : '');
			dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
			dot.setAttribute('data-i', i);
			dot.addEventListener('click', function () {
				currentIndex = parseInt(this.getAttribute('data-i'));
				updateSlider();
				restartAutoPlay();
			});
			dotsWrap.appendChild(dot);
		}
	}

	function slide(dir) {
		currentIndex += dir;
		updateSlider();
	}

	function startAutoPlay() {
		if (cards.length > getItemsPerView()) {
			autoPlayInterval = setInterval(function () { slide(1); }, INTERVAL_MS);
		}
	}

	function stopAutoPlay() {
		clearInterval(autoPlayInterval);
		autoPlayInterval = null;
	}

	function restartAutoPlay() {
		stopAutoPlay();
		startAutoPlay();
	}

	if (prevBtn) prevBtn.addEventListener('click', function () { slide(-1); restartAutoPlay(); });
	if (nextBtn) nextBtn.addEventListener('click', function () { slide(1);  restartAutoPlay(); });

	var outer = document.querySelector('.dpt-doctors__slider-outer');
	if (outer) {
		outer.addEventListener('mouseenter', stopAutoPlay);
		outer.addEventListener('mouseleave', startAutoPlay);
	}

	window.addEventListener('resize', function () {
		renderDots();
		updateSlider();
		restartAutoPlay();
	});

	renderDots();
	updateSlider();
	startAutoPlay();
});
</script>
