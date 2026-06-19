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
							$specialty  = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_speciality', true ) ?: ( get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_specialization', true ) ?: __( 'Dental Specialist', 'developer-starter-pro' ) );
							$bio        = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_bio', true ) ?: get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_qualifications', true );
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
								$photo_html = '<img src="' . esc_url( get_theme_file_uri( 'assets/images/' . $demo_img ) ) . '" alt="' . esc_attr( $doctor->post_title ) . '" loading="lazy">';
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
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-emma-chen.png' ) ) . '" alt="Dr. Sarah Connor" loading="lazy">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Alex Mercer', 'developer-starter-pro' ),
							'specialty' => __( 'Orthodontist', 'developer-starter-pro' ),
							'bio'       => __( 'Specialist in clear aligners and traditional braces for all ages.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-james-patel.png' ) ) . '" alt="Dr. Alex Mercer" loading="lazy">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Jessica Miller', 'developer-starter-pro' ),
							'specialty' => __( 'Cosmetic Dentist', 'developer-starter-pro' ),
							'bio'       => __( 'Expert in smile makeovers, veneers, and teeth whitening treatments.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-sarah-mitchell.png' ) ) . '" alt="Dr. Jessica Miller" loading="lazy">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Sarah Mitchell', 'developer-starter-pro' ),
							'specialty' => __( 'Oral Surgeon', 'developer-starter-pro' ),
							'bio'       => __( 'Experienced in implant placement, extractions, and bone grafting.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-michael-ross.png' ) ) . '" alt="Dr. Sarah Mitchell" loading="lazy">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. James Patel', 'developer-starter-pro' ),
							'specialty' => __( 'Endodontist', 'developer-starter-pro' ),
							'bio'       => __( 'Root canal specialist focused on pain-free endodontic treatments.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-james-patel.png' ) ) . '" alt="Dr. James Patel" loading="lazy">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Emma Chen', 'developer-starter-pro' ),
							'specialty' => __( 'Periodontist', 'developer-starter-pro' ),
							'bio'       => __( 'Gum disease treatment and dental implant maintenance specialist.', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-emma-chen.png' ) ) . '" alt="Dr. Emma Chen" loading="lazy">',
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
						<!-- Photo wrap -->
						<div class="dpt-doctor-card__photo-wrap">
							<div class="dpt-doctor-card__photo">
								<?php echo $doc['photo']; // phpcs:ignore ?>
							</div>
						</div>

						<!-- Hover overlay -->
						<div class="dpt-doctor-card__overlay"></div>

						<!-- Number badge -->
						<div class="dpt-doctor-card__num" aria-hidden="true"><?php echo str_pad( $idx + 1, 2, '0', STR_PAD_LEFT ); ?></div>

						<!-- Content overlaid at bottom -->
						<div class="dpt-doctor-card__content">
							<span class="dpt-doctor-card__specialty">
								<svg viewBox="0 0 12 12" fill="currentColor" width="6" height="6"><circle cx="6" cy="6" r="6"/></svg>
								<?php echo esc_html( $doc['specialty'] ); ?>
							</span>
							<h3 class="dpt-doctor-card__name">
								<a href="<?php echo esc_url( $doc['url'] ); ?>"><?php echo esc_html( $doc['name'] ); ?></a>
							</h3>
							
							<div class="dpt-doctor-card__hover-content">
								<?php if ( ! empty( $doc['bio'] ) ) : ?>
									<p class="dpt-doctor-card__bio"><?php echo esc_html( $doc['bio'] ); ?></p>
								<?php endif; ?>
								<a href="<?php echo esc_url( $doc['url'] ); ?>" class="dpt-doctor-card__view-btn">
									<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
									<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
								</a>
							</div>
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
	color: var(--developer-starter-pro-primary);
	background: var(--developer-starter-pro-primary-light);
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
	position: relative;
	min-height: 420px;
	border-radius: 18px;
	overflow: hidden;
	justify-content: flex-end;
	border: 1px solid rgba(255, 255, 255, 0.12);
	box-shadow:
		0 4px 20px rgba(0, 0, 0, 0.25),
		0 1px 4px rgba(0, 0, 0, 0.15);
	transition:
		transform 0.4s cubic-bezier(0.25, 1, 0.5, 1),
		box-shadow 0.4s cubic-bezier(0.25, 1, 0.5, 1);
	cursor: pointer;
}

.dpt-doctor-card:hover {
	transform: translateY(-8px);
	box-shadow:
		0 12px 36px rgba(78, 124, 89, 0.22),
		0 24px 56px rgba(0, 0, 0, 0.35);
}

/* Photo wrap */
.dpt-doctor-card__photo-wrap {
	position: absolute;
	inset: 0;
	z-index: 0;
	background: #101E12;
	overflow: hidden;
}

.dpt-doctor-card__photo {
	width: 100%;
	height: 100%;
}

.dpt-doctor-card__photo img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	object-position: center top;
	display: block;
	transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
}

.dpt-doctor-card:hover .dpt-doctor-card__photo img {
	transform: scale(1.08);
}

/* Premium dark gradient overlay */
.dpt-doctor-card__overlay {
	position: absolute;
	inset: 0;
	background: linear-gradient(
		to bottom,
		rgba(10, 20, 15, 0.15) 0%,
		rgba(10, 20, 12, 0.45) 50%,
		rgba(5, 10, 6, 0.88) 100%
	);
	z-index: 1;
	transition: background 0.4s ease;
	pointer-events: none;
}
.dpt-doctor-card:hover .dpt-doctor-card__overlay {
	background: linear-gradient(
		to bottom,
		rgba(10, 20, 15, 0.08) 0%,
		rgba(10, 20, 12, 0.55) 45%,
		rgba(5, 10, 6, 0.94) 100%
	);
}

/* Card number */
.dpt-doctor-card__num {
	position: absolute;
	top: 16px;
	right: 16px;
	width: 32px;
	height: 32px;
	background: rgba(255, 255, 255, 0.12);
	backdrop-filter: blur(8px);
	-webkit-backdrop-filter: blur(8px);
	border: 1px solid rgba(255, 255, 255, 0.25);
	border-radius: 8px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 0.72rem;
	font-weight: 700;
	color: #FFFFFF;
	z-index: 3;
}

/* Content container */
.dpt-doctor-card__content {
	position: relative;
	z-index: 2;
	padding: 24px;
	width: 100%;
	box-sizing: border-box;
}

.dpt-doctor-card__specialty {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	font-size: 0.68rem;
	font-weight: 700;
	letter-spacing: 0.12em;
	text-transform: uppercase;
	color: #F3C64F;
	margin-bottom: 8px;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
}
.dpt-doctor-card__specialty svg {
	color: #F3C64F;
	opacity: 0.85;
}

.dpt-doctor-card__name {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.25rem;
	font-weight: 600;
	color: #FFFFFF;
	margin: 0;
	line-height: 1.35;
	text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
}
.dpt-doctor-card__name a {
	color: inherit;
	text-decoration: none;
	transition: color 0.2s;
}
.dpt-doctor-card__name a:hover {
	color: #F3C64F;
}

/* Expandable hover content */
.dpt-doctor-card__hover-content {
	max-height: 0;
	opacity: 0;
	overflow: hidden;
	transition: max-height 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease;
}
.dpt-doctor-card:hover .dpt-doctor-card__hover-content {
	max-height: 160px;
	opacity: 1;
	margin-top: 12px;
}

.dpt-doctor-card__bio {
	font-size: 0.82rem;
	color: rgba(255, 255, 255, 0.85);
	line-height: 1.5;
	margin: 0 0 16px 0;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.dpt-doctor-card__view-btn {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	padding: 9px 18px;
	background: linear-gradient(135deg, var(--developer-starter-pro-primary), var(--developer-starter-pro-primary-dark));
	color: #FFFFFF !important;
	border-radius: 24px;
	font-size: 0.78rem;
	font-weight: 600;
	text-decoration: none;
	letter-spacing: 0.02em;
	box-shadow: 0 4px 12px rgba(78, 124, 89, 0.2);
	border: 1px solid rgba(255, 255, 255, 0.08);
	transition: gap 0.25s ease, box-shadow 0.25s ease, transform 0.2s ease;
}
.dpt-doctor-card__view-btn:hover {
	color: #FFFFFF !important;
	gap: 10px;
	box-shadow: 0 6px 20px rgba(78, 124, 89, 0.45);
	transform: translateX(2px);
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
	border: 1.5px solid var(--developer-starter-pro-primary-light);
	color: var(--developer-starter-pro-primary);
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	z-index: 10;
	transition: all 0.25s ease;
	box-shadow: 0 4px 12px rgba(26,46,26,0.1);
}
.dpt-doctors__arrow:hover {
	background: var(--developer-starter-pro-primary);
	color: #FFFFFF;
	border-color: var(--developer-starter-pro-primary);
	box-shadow: 0 6px 20px rgba(var(--developer-starter-pro-primary-rgb, 78, 124, 89), 0.3);
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
	background: var(--developer-starter-pro-primary);
	width: 24px;
	border-radius: 4px;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
	.dpt-doctor-card { flex: 0 0 calc((100% - 22px) / 2); min-height: 380px; }
	.dpt-doctors__arrow { display: none; }
}
@media (max-width: 600px) {
	.dpt-doctors { padding: 64px 0 72px; }
	.dpt-doctor-card { flex: 0 0 80%; min-height: 360px; }
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
