<?php
/**
 * Template Part: Homepage Doctors / Meet Our Experts Section
 *
 * Matches Apex Dental reference: "Meet Our Experts" heading,
 * horizontal cards with square photo + name + specialty.
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

<section class="dp-doctors" id="doctors">
	<div class="dp-section-container">

		<div class="dp-section-header">
			<h2 class="dp-section-title"><?php esc_html_e( 'Meet Our Experts', 'developer-starter-pro' ); ?></h2>
			<div class="dp-section-rule" aria-hidden="true"></div>
		</div>

		<div class="dp-doctors__slider-outer">
			<!-- Prev Arrow -->
			<button class="dp-doctors__arrow dp-doctors__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'developer-starter-pro' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
			</button>

			<div class="dp-doctors__slider-container">
				<div class="dp-doctors__slider-track">
					<?php
					$display_doctors = array();
					if ( ! empty( $doctors ) ) {
						foreach ( $doctors as $doctor ) {
							$specialty  = get_post_meta( $doctor->ID, '_developer_starter_pro_doctor_specialization', true ) ?: __( 'Dental Specialist', 'developer-starter-pro' );
							$photo_html = '';
							if ( has_post_thumbnail( $doctor->ID ) ) {
								$photo_html = get_the_post_thumbnail( $doctor->ID, 'medium_large', array( 'alt' => esc_attr( $doctor->post_title ) ) );
							} else {
								// Assign a realistic name-appropriate or cyclic demo portrait from assets
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
									$demo_img = $img_choices[ $doctor->ID % 4 ];
								}
								$photo_html = '<img src="' . esc_url( get_theme_file_uri( 'assets/images/' . $demo_img ) ) . '" alt="' . esc_attr( $doctor->post_title ) . '">';
							}
							$display_doctors[] = array(
								'name'      => $doctor->post_title,
								'specialty' => $specialty,
								'photo'     => $photo_html,
								'url'       => get_permalink( $doctor->ID ),
							);
						}
					}

					$default_doctors = array(
						array(
							'name'      => __( 'Dr. Sarah Mitchell', 'developer-starter-pro' ),
							'specialty' => __( 'Dental Specialist', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-sarah-mitchell.png' ) ) . '" alt="' . esc_attr__( 'Dr. Sarah Mitchell', 'developer-starter-pro' ) . '">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. James Patel', 'developer-starter-pro' ),
							'specialty' => __( 'Orthodontist', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-james-patel.png' ) ) . '" alt="' . esc_attr__( 'Dr. James Patel', 'developer-starter-pro' ) . '">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Emma Chen', 'developer-starter-pro' ),
							'specialty' => __( 'Cosmetic Dentist', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-emma-chen.png' ) ) . '" alt="' . esc_attr__( 'Dr. Emma Chen', 'developer-starter-pro' ) . '">',
							'url'       => '#',
						),
						array(
							'name'      => __( 'Dr. Michael Ross', 'developer-starter-pro' ),
							'specialty' => __( 'Oral Surgeon', 'developer-starter-pro' ),
							'photo'     => '<img src="' . esc_url( get_theme_file_uri( 'assets/images/dr-michael-ross.png' ) ) . '" alt="' . esc_attr__( 'Dr. Michael Ross', 'developer-starter-pro' ) . '">',
							'url'       => '#',
						),
					);

					if ( count( $display_doctors ) < 8 ) {
						$needed = 8 - count( $display_doctors );
						for ( $i = 0; $i < $needed; $i++ ) {
							$display_doctors[] = $default_doctors[ $i % count( $default_doctors ) ];
						}
					}

					foreach ( $display_doctors as $doc ) :
					?>
					<div class="dp-doctor-card">
						<div class="dp-doctor-card__photo">
							<?php echo $doc['photo']; // phpcs:ignore ?>
						</div>
						<div class="dp-doctor-card__info">
							<h3 class="dp-doctor-card__name">
								<a href="<?php echo esc_url( $doc['url'] ); ?>"><?php echo esc_html( $doc['name'] ); ?></a>
							</h3>
							<p class="dp-doctor-card__specialty"><?php echo esc_html( $doc['specialty'] ); ?></p>
						</div>
					</div>
					<?php endforeach; ?>
				</div><!-- .dp-doctors__slider-track -->
			</div><!-- .dp-doctors__slider-container -->

			<!-- Next Arrow -->
			<button class="dp-doctors__arrow dp-doctors__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'developer-starter-pro' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
			</button>
		</div><!-- .dp-doctors__slider-outer -->

	</div>
</section>

<style>
/* ================================================
   DOCTORS — Slider Carousel Style
   ================================================ */
.dp-doctors {
	background: #F9F8F5;
	padding: 72px 0 80px;
}

.dp-doctors__slider-outer {
	position: relative;
	width: 100%;
	display: flex;
	align-items: center;
}

.dp-doctors__slider-container {
	overflow: hidden;
	width: 100%;
	padding: 15px 0;
	margin: -15px 0;
}

.dp-doctors__slider-track {
	display: flex;
	gap: 20px;
	transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
	width: 100%;
}

/* Doctor card — vertical: photo top, info bottom */
.dp-doctor-card {
	flex: 0 0 calc((100% - 60px) / 4);
	box-sizing: border-box;
	background: #FFFFFF;
	border: 1px solid #E8E4DC;
	border-radius: 10px;
	padding: 0;
	display: flex;
	flex-direction: column;
	align-items: stretch;
	overflow: hidden;
	transition: box-shadow 0.25s ease, transform 0.25s ease;
}

.dp-doctor-card:hover {
	box-shadow: 0 10px 24px rgba(78, 124, 89, 0.08);
	transform: translateY(-4px);
}

/* Photo portrait container */
.dp-doctor-card__photo {
	width: 100%;
	height: 240px; /* Tall portrait height */
	overflow: hidden;
	flex-shrink: 0;
	background: #F4EFEB;
	position: relative;
	border-bottom: 1px solid #E8E4DC;
}

.dp-doctor-card__photo img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	object-position: center top; /* Prevent head crop */
	display: block;
	transition: transform 0.4s ease;
}

.dp-doctor-card:hover .dp-doctor-card__photo img {
	transform: scale(1.04);
}

.dp-doctor-card__info {
	padding: 16px 20px;
	text-align: center;
}

.dp-doctor-card__name {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.05rem;
	font-weight: 600;
	color: #1A2E1A;
	margin: 0 0 6px 0;
}

.dp-doctor-card__name a {
	color: #1A2E1A;
	text-decoration: none;
	transition: color 0.15s;
}

.dp-doctor-card__name a:hover {
	color: #4E7C59;
}

.dp-doctor-card__specialty {
	font-size: 0.85rem;
	color: #4E7C59;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	margin: 0;
}

/* Arrow Styles */
.dp-doctors__arrow {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	width: 44px;
	height: 44px;
	border-radius: 50%;
	background: rgba(255, 255, 255, 0.9);
	border: 1px solid rgba(0, 0, 0, 0.08);
	color: #1A2E1A;
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	z-index: 10;
	transition: all 0.25s ease;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.dp-doctors__arrow:hover {
	background: #4E7C59;
	color: #ffffff;
	border-color: #4E7C59;
	box-shadow: 0 6px 16px rgba(78, 124, 89, 0.25);
}

.dp-doctors__arrow--prev {
	left: -22px;
}

.dp-doctors__arrow--next {
	right: -22px;
}

/* Responsive columns */
@media (max-width: 1024px) {
	.dp-doctor-card {
		flex: 0 0 calc((100% - 20px) / 2);
	}
	.dp-doctors__arrow {
		display: none;
	}
}

@media (max-width: 600px) {
	.dp-doctor-card {
		flex: 0 0 100%;
	}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var container = document.querySelector('.dp-doctors__slider-container');
	if (!container) return;

	var track = container.querySelector('.dp-doctors__slider-track');
	var cards = track.querySelectorAll('.dp-doctor-card');
	var prevBtn = document.querySelector('.dp-doctors__arrow--prev');
	var nextBtn = document.querySelector('.dp-doctors__arrow--next');

	var currentIndex = 0;
	var autoPlayInterval = null;
	var intervalTime = 3000; // 3 seconds

	function getItemsPerView() {
		if (window.innerWidth <= 600) return 1;
		if (window.innerWidth <= 1024) return 2;
		return 4;
	}

	function updateSlider() {
		var itemsPerView = getItemsPerView();
		var maxIndex = Math.max(0, cards.length - itemsPerView);

		if (currentIndex > maxIndex) {
			currentIndex = 0; // Wrap around
		} else if (currentIndex < 0) {
			currentIndex = maxIndex;
		}

		var firstCard = cards[0];
		if (firstCard) {
			var cardWidth = firstCard.getBoundingClientRect().width;
			var gap = 20; // gap in px
			var offset = currentIndex * (cardWidth + gap);
			track.style.transform = 'translateX(-' + offset + 'px)';
		}
	}

	function slideNext() {
		currentIndex++;
		updateSlider();
	}

	function slidePrev() {
		currentIndex--;
		updateSlider();
	}

	function startAutoPlay() {
		var itemsPerView = getItemsPerView();
		if (cards.length > itemsPerView) {
			stopAutoPlay();
			autoPlayInterval = setInterval(slideNext, intervalTime);
		}
	}

	function stopAutoPlay() {
		if (autoPlayInterval) {
			clearInterval(autoPlayInterval);
			autoPlayInterval = null;
		}
	}

	if (prevBtn) {
		prevBtn.addEventListener('click', function() {
			slidePrev();
			startAutoPlay();
		});
	}

	if (nextBtn) {
		nextBtn.addEventListener('click', function() {
			slideNext();
			startAutoPlay();
		});
	}

	// Hover to pause
	var outer = document.querySelector('.dp-doctors__slider-outer');
	if (outer) {
		outer.addEventListener('mouseenter', stopAutoPlay);
		outer.addEventListener('mouseleave', startAutoPlay);
	}

	// Resize handling
	window.addEventListener('resize', function() {
		updateSlider();
		startAutoPlay();
	});

	// Initialize
	updateSlider();
	startAutoPlay();
});
</script>
