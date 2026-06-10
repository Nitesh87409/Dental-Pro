<?php
/**
 * Template Part: Homepage Hero Slider (Swiper.js)
 *
 * Full-featured hero slider with Swiper.js, video backgrounds, animated text, and CTA buttons.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$slides       = Developer_Starter_Pro_Hero_Slider::get_slides();
$clinic_name  = developer_starter_pro_get_option( 'clinic_name', 'DentalPro Elite' );
$clinic_phone = developer_starter_pro_get_option( 'clinic_phone', '' );

// Filter only active slides.
$active_slides = array_filter( $slides, function( $slide ) {
	return ! empty( $slide['active'] );
} );

if ( empty( $active_slides ) ) {
	$active_slides = $slides; // Fallback to all slides.
}

$has_multiple = count( $active_slides ) > 1;
?>

<!-- Swiper CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<section class="developer-starter-pro-hero" id="hero">
	<div class="swiper developer-starter-pro-hero-swiper">
		<div class="swiper-wrapper">
			<?php foreach ( $active_slides as $index => $slide ) :
				$overlay_opacity = isset( $slide['overlay_opacity'] ) ? intval( $slide['overlay_opacity'] ) / 100 : 0.7;
				$has_video = ! empty( $slide['bg_video'] );
				$has_image = ! empty( $slide['bg_image'] );
			?>
			<div class="swiper-slide developer-starter-pro-hero-slide">
				<!-- Background -->
				<?php if ( $has_video ) : ?>
					<video class="developer-starter-pro-hero-video" autoplay muted loop playsinline>
						<source src="<?php echo esc_url( $slide['bg_video'] ); ?>" type="video/mp4">
					</video>
				<?php elseif ( $has_image ) : ?>
					<div class="developer-starter-pro-hero-bg" style="background-image: url('<?php echo esc_url( $slide['bg_image'] ); ?>');"></div>
				<?php else : ?>
					<div class="developer-starter-pro-hero-bg developer-starter-pro-hero-bg--gradient"></div>
				<?php endif; ?>

				<!-- Overlay -->
				<div class="developer-starter-pro-hero-overlay" style="background: rgba(15, 23, 42, <?php echo esc_attr( $overlay_opacity ); ?>);"></div>

				<!-- Decorative Elements -->
				<div class="developer-starter-pro-hero-decoration">
					<div class="developer-starter-pro-hero-circle developer-starter-pro-hero-circle--1"></div>
					<div class="developer-starter-pro-hero-circle developer-starter-pro-hero-circle--2"></div>
					<div class="developer-starter-pro-hero-dots"></div>
				</div>

				<!-- Content -->
				<div class="developer-starter-pro-container">
					<div class="developer-starter-pro-hero-content">
						<?php if ( $index === 0 ) : ?>
							<span class="developer-starter-pro-hero-badge" data-swiper-parallax="-100" data-swiper-parallax-opacity="0">
								<?php esc_html_e( '🦷 Premium Dental Care', 'developer-starter-pro' ); ?>
							</span>
						<?php endif; ?>

						<h1 class="developer-starter-pro-hero-title" data-swiper-parallax="-200" data-swiper-parallax-opacity="0">
							<?php
							$title_html = wp_kses( $slide['title'], array( 'span' => array( 'class' => array() ), 'br' => array(), 'em' => array(), 'strong' => array() ) );
							if ( preg_match( '/\[(.*?)\]/', $title_html, $matches ) ) {
								$words = array_map( 'trim', explode( ',', $matches[1] ) );
								if ( ! empty( $words ) ) {
									$rotator_html = '<span class="txt-rotate-wrap">';
									foreach ( $words as $w_idx => $word ) {
										$active_class = ( 0 === $w_idx ) ? ' active' : '';
										$rotator_html .= '<span class="txt-rotate-word' . $active_class . '">' . esc_html( $word ) . '</span>';
									}
									$rotator_html .= '</span>';
									$title_html = str_replace( '[' . $matches[1] . ']', $rotator_html, $title_html );
								}
							}
							echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</h1>

						<?php if ( ! empty( $slide['subtitle'] ) ) : ?>
							<p class="developer-starter-pro-hero-subtitle" data-swiper-parallax="-300" data-swiper-parallax-opacity="0">
								<?php echo esc_html( $slide['subtitle'] ); ?>
							</p>
						<?php endif; ?>

						<div class="developer-starter-pro-hero-actions" data-swiper-parallax="-400" data-swiper-parallax-opacity="0">
							<?php if ( ! empty( $slide['btn1_text'] ) ) : 
								$btn1_url = ( '#booking' === $slide['btn1_url'] ) ? developer_starter_pro_get_booking_url() : $slide['btn1_url'];
							?>
								<a href="<?php echo esc_url( $btn1_url ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary developer-starter-pro-btn--lg developer-starter-pro-btn--glow">
									<?php echo esc_html( $slide['btn1_text'] ); ?>
								</a>
							<?php endif; ?>
							<?php if ( ! empty( $slide['btn2_text'] ) ) : 
								$btn2_url = ( '#booking' === $slide['btn2_url'] ) ? developer_starter_pro_get_booking_url() : $slide['btn2_url'];
							?>
								<a href="<?php echo esc_url( $btn2_url ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline developer-starter-pro-btn--lg">
									<?php if ( $clinic_phone && strpos( $btn2_url, 'tel:' ) !== false ) : ?>
										<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
									<?php endif; ?>
									<?php echo esc_html( $slide['btn2_text'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<?php if ( $has_multiple ) : ?>
			<!-- Navigation -->
			<div class="swiper-button-next developer-starter-pro-swiper-btn"></div>
			<div class="swiper-button-prev developer-starter-pro-swiper-btn"></div>

			<!-- Pagination -->
			<div class="swiper-pagination developer-starter-pro-swiper-pagination"></div>
		<?php endif; ?>
	</div>

	<!-- Trust Stats Bar -->
	<div class="developer-starter-pro-hero-stats-bar">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-hero-stats">
				<div class="developer-starter-pro-hero-stat">
					<span class="stat-number" data-count="10">0</span><span class="stat-plus">+</span>
					<span class="stat-label"><?php esc_html_e( 'Years Experience', 'developer-starter-pro' ); ?></span>
				</div>
				<div class="developer-starter-pro-hero-stat-divider"></div>
				<div class="developer-starter-pro-hero-stat">
					<span class="stat-number" data-count="5000">0</span><span class="stat-plus">+</span>
					<span class="stat-label"><?php esc_html_e( 'Happy Patients', 'developer-starter-pro' ); ?></span>
				</div>
				<div class="developer-starter-pro-hero-stat-divider"></div>
				<div class="developer-starter-pro-hero-stat">
					<span class="stat-number" data-count="50">0</span><span class="stat-plus">+</span>
					<span class="stat-label"><?php esc_html_e( 'Expert Doctors', 'developer-starter-pro' ); ?></span>
				</div>
				<div class="developer-starter-pro-hero-stat-divider"></div>
				<div class="developer-starter-pro-hero-stat">
					<span class="stat-number" data-count="99">0</span><span class="stat-plus">%</span>
					<span class="stat-label"><?php esc_html_e( 'Patient Satisfaction', 'developer-starter-pro' ); ?></span>
				</div>
			</div>
		</div>
	</div>

	<!-- Scroll Indicator -->
	<div class="developer-starter-pro-hero-scroll">
		<span><?php esc_html_e( 'Scroll Down', 'developer-starter-pro' ); ?></span>
		<div class="developer-starter-pro-scroll-indicator"></div>
	</div>
</section>

<!-- Swiper JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
	// Initialize Swiper
	var heroSwiper = new Swiper('.developer-starter-pro-hero-swiper', {
		loop: <?php echo $has_multiple ? 'true' : 'false'; ?>,
		speed: 1000,
		autoplay: {
			delay: 6000,
			disableOnInteraction: false,
		},
		effect: 'fade',
		fadeEffect: {
			crossFade: true,
		},
		parallax: true,
		<?php if ( $has_multiple ) : ?>
		pagination: {
			el: '.developer-starter-pro-swiper-pagination',
			clickable: true,
			dynamicBullets: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		<?php endif; ?>
		on: {
			slideChangeTransitionStart: function() {
				// Pause videos on inactive slides
				document.querySelectorAll('.swiper-slide:not(.swiper-slide-active) video').forEach(function(v) { v.pause(); });
			},
			slideChangeTransitionEnd: function() {
				// Play video on active slide
				var activeVideo = document.querySelector('.swiper-slide-active video');
				if (activeVideo) activeVideo.play();
			}
		}
	});

	// Counter animation for stats
	function animateCounter(el) {
		var target = parseInt(el.getAttribute('data-count'), 10);
		var current = 0;
		var duration = 2000;
		var step = target / (duration / 16);

		function update() {
			current += step;
			if (current >= target) {
				el.textContent = target.toLocaleString();
				return;
			}
			el.textContent = Math.floor(current).toLocaleString();
			requestAnimationFrame(update);
		}

		update();
	}

		// Trigger counter on scroll into view
		var statsBar = document.querySelector('.developer-starter-pro-hero-stats-bar');
		if (statsBar) {
			var statsObserver = new IntersectionObserver(function(entries) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting) {
						entry.target.querySelectorAll('[data-count]').forEach(animateCounter);
						statsObserver.unobserve(entry.target);
					}
				});
			}, { threshold: 0.5 });
			statsObserver.observe(statsBar);
		}

		// Text Rotator animation
		document.querySelectorAll('.txt-rotate-wrap').forEach(function(wrap) {
			var words = wrap.querySelectorAll('.txt-rotate-word');
			if (words.length <= 1) return;
			var currentIndex = 0;
			setInterval(function() {
				var activeWord = words[currentIndex];
				activeWord.classList.remove('active');
				activeWord.classList.add('exit');
				
				setTimeout(function() {
					activeWord.classList.remove('exit');
				}, 500);

				currentIndex = (currentIndex + 1) % words.length;
				var nextWord = words[currentIndex];
				nextWord.classList.add('active');
			}, 3000);
		});
	});
	</script>

<style>
/* Hero Slider Enhancements */
.developer-starter-pro-hero {
	position: relative;
}

.developer-starter-pro-hero-swiper {
	width: 100%;
	height: 90vh;
	min-height: 600px;
}

.developer-starter-pro-hero-slide {
	position: relative;
	display: flex;
	align-items: center;
	overflow: hidden;
}

.developer-starter-pro-hero-bg {
	position: absolute;
	inset: 0;
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
	transform: scale(1.1);
	transition: transform 8s ease;
}

.swiper-slide-active .developer-starter-pro-hero-bg {
	transform: scale(1);
}

.developer-starter-pro-hero-bg--gradient {
	background: linear-gradient(135deg, #1E293B 0%, #0f2027 50%, #334155 100%);
}

.developer-starter-pro-hero-video {
	position: absolute;
	inset: 0;
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.developer-starter-pro-hero-overlay {
	position: absolute;
	inset: 0;
	z-index: 1;
}

/* Decorative Elements */
.developer-starter-pro-hero-decoration {
	position: absolute;
	inset: 0;
	z-index: 1;
	pointer-events: none;
	overflow: hidden;
}

.developer-starter-pro-hero-circle {
	position: absolute;
	border-radius: 50%;
	border: 1px solid rgba(255, 255, 255, 0.06);
}

.developer-starter-pro-hero-circle--1 {
	width: 600px;
	height: 600px;
	top: -200px;
	right: -100px;
	animation: heroFloat 20s ease-in-out infinite;
}

.developer-starter-pro-hero-circle--2 {
	width: 400px;
	height: 400px;
	bottom: -150px;
	left: -50px;
	animation: heroFloat 15s ease-in-out infinite reverse;
}

.developer-starter-pro-hero-dots {
	position: absolute;
	inset: 0;
	background-image: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
	background-size: 24px 24px;
}

@keyframes heroFloat {
	0%, 100% { transform: translate(0, 0) rotate(0deg); }
	33% { transform: translate(30px, -20px) rotate(5deg); }
	66% { transform: translate(-20px, 15px) rotate(-3deg); }
}

/* Swiper Navigation Buttons */
.developer-starter-pro-swiper-btn {
	width: 50px !important;
	height: 50px !important;
	background: rgba(255, 255, 255, 0.1) !important;
	backdrop-filter: blur(10px);
	border-radius: 50% !important;
	transition: all 0.3s ease;
}

.developer-starter-pro-swiper-btn::after {
	font-size: 18px !important;
	color: #fff;
}

.developer-starter-pro-swiper-btn:hover {
	background: var(--developer-starter-pro-primary) !important;
}

/* Swiper Pagination */
.developer-starter-pro-swiper-pagination {
	bottom: 30px !important;
}

.developer-starter-pro-swiper-pagination .swiper-pagination-bullet {
	width: 12px;
	height: 12px;
	background: rgba(255, 255, 255, 0.4);
	opacity: 1;
	transition: all 0.3s ease;
}

.developer-starter-pro-swiper-pagination .swiper-pagination-bullet-active {
	background: var(--developer-starter-pro-primary);
	width: 32px;
	border-radius: 6px;
}

/* Glow Button */
.developer-starter-pro-btn--glow {
	box-shadow: 0 0 20px rgba(var(--developer-starter-pro-primary-rgb), 0.4);
}

.developer-starter-pro-btn--glow:hover {
	box-shadow: 0 0 30px rgba(var(--developer-starter-pro-primary-rgb), 0.6);
}

/* Stats Bar */
.developer-starter-pro-hero-stats-bar {
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	z-index: 10;
	background: rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(20px);
	border-top: 1px solid rgba(255, 255, 255, 0.1);
	padding: 24px 0;
}

.developer-starter-pro-hero-stats {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 0;
}

.developer-starter-pro-hero-stat {
	flex: 1;
	text-align: center;
}

.developer-starter-pro-hero-stat .stat-number {
	font-family: var(--developer-starter-pro-font-heading);
	font-size: 2.25rem;
	font-weight: 800;
	color: #fff;
	line-height: 1.1;
}

.developer-starter-pro-hero-stat .stat-plus {
	font-family: var(--developer-starter-pro-font-heading);
	font-size: 1.5rem;
	font-weight: 700;
	color: var(--developer-starter-pro-primary);
}

.developer-starter-pro-hero-stat .stat-label {
	display: block;
	font-size: 0.8125rem;
	color: rgba(255, 255, 255, 0.6);
	text-transform: uppercase;
	letter-spacing: 0.5px;
	margin-top: 4px;
}

.developer-starter-pro-hero-stat-divider {
	width: 1px;
	height: 50px;
	background: rgba(255, 255, 255, 0.15);
}

/* Hero Content Z-Index */
.developer-starter-pro-hero-slide .developer-starter-pro-container {
	position: relative;
	z-index: 5;
}

.developer-starter-pro-hero-content {
	max-width: 700px;
}

/* Hero Scroll */
.developer-starter-pro-hero-scroll {
	position: absolute;
	bottom: 100px;
	left: 50%;
	transform: translateX(-50%);
	z-index: 10;
}

@media (max-width: 768px) {
	.developer-starter-pro-hero-swiper {
		height: 100vh;
		min-height: 500px;
	}

	.developer-starter-pro-hero-stats {
		flex-wrap: wrap;
		gap: 16px;
	}

	.developer-starter-pro-hero-stat {
		flex: 0 0 45%;
	}

	.developer-starter-pro-hero-stat-divider {
		display: none;
	}

	.developer-starter-pro-hero-stats-bar {
		padding: 16px 0;
	}

	.developer-starter-pro-hero-stat .stat-number {
		font-size: 1.5rem;
	}

	.developer-starter-pro-hero-scroll {
		display: none;
	}

	.developer-starter-pro-swiper-btn {
		display: none !important;
	}
}
</style>
