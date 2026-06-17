<?php
/**
 * Template Part: Homepage Testimonials Section
 *
 * Matches Apex Dental reference: "Patient Testimonials" heading,
 * 3 cards with star rating, italic quote text, patient name, dot pagination.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$testimonials = get_posts( array(
	'post_type'      => 'testimonials',
	'posts_per_page' => 9,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
) );

// Default demo testimonials
$defaults = array(
	array(
		'text'      => __( '"I was nervous about my visit, but the team made me feel so comfortable. Excellent service!"', 'developer-starter-pro' ),
		'name'      => __( 'James K.', 'developer-starter-pro' ),
		'treatment' => __( 'Regular patient', 'developer-starter-pro' ),
		'rating'    => 5,
		'initials'  => 'JK',
	),
	array(
		'text'      => __( '"I love how gentle and professional everyone was. My smile has never felt better!"', 'developer-starter-pro' ),
		'name'      => __( 'Jessica P.', 'developer-starter-pro' ),
		'treatment' => __( 'Cosmetic patient', 'developer-starter-pro' ),
		'rating'    => 5,
		'initials'  => 'JP',
	),
	array(
		'text'      => __( '"Fast response and top-notch care during my emergency. Highly recommend!"', 'developer-starter-pro' ),
		'name'      => __( 'Arun M.', 'developer-starter-pro' ),
		'treatment' => __( 'Emergency patient', 'developer-starter-pro' ),
		'rating'    => 5,
		'initials'  => 'AM',
	),
);

$display_testimonials = array();
if ( ! empty( $testimonials ) ) {
	foreach ( $testimonials as $t ) {
		$patient_name = get_post_meta( $t->ID, '_developer_starter_pro_testimonial_patient_name', true ) ?: $t->post_title;
		$rating       = intval( get_post_meta( $t->ID, '_developer_starter_pro_testimonial_rating', true ) ?: 5 );
		$treatment    = get_post_meta( $t->ID, '_developer_starter_pro_testimonial_treatment', true );
		$initials     = strtoupper( substr( $patient_name, 0, 1 ) );
		$avatar_html  = '';
		if ( has_post_thumbnail( $t->ID ) ) {
			$avatar_html = get_the_post_thumbnail( $t->ID, array( 36, 36 ) );
		}

		$display_testimonials[] = array(
			'text'      => $t->post_content,
			'name'      => $patient_name,
			'treatment' => $treatment,
			'rating'    => $rating,
			'initials'  => $initials,
			'avatar'    => $avatar_html,
		);
	}
}

if ( count( $display_testimonials ) < 6 ) {
	$needed = 6 - count( $display_testimonials );
	for ( $i = 0; $i < $needed; $i++ ) {
		$d = $defaults[ $i % count( $defaults ) ];
		$display_testimonials[] = array(
			'text'      => $d['text'],
			'name'      => $d['name'],
			'treatment' => $d['treatment'],
			'rating'    => $d['rating'],
			'initials'  => $d['initials'],
			'avatar'    => '',
		);
	}
}
?>

<section class="dp-testimonials" id="testimonials">
	<div class="dp-section-container">

		<div class="dp-section-header">
			<h2 class="dp-section-title"><?php esc_html_e( 'Patient Testimonials', 'developer-starter-pro' ); ?></h2>
			<div class="dp-section-rule" aria-hidden="true"></div>
		</div>

		<div class="dp-testimonials__slider-outer">
			<div class="dp-testimonials__slider-container">
				<div class="dp-testimonials__slider-track">
					<?php foreach ( $display_testimonials as $t ) : ?>
					<div class="dp-testimonial-card">
						<div class="dp-testimonial-card__stars" aria-label="<?php echo esc_attr( $t['rating'] . ' out of 5 stars' ); ?>">
							<?php for ( $i = 0; $i < 5; $i++ ) : ?>
								<span class="dp-star<?php echo $i < $t['rating'] ? ' dp-star--filled' : ''; ?>">★</span>
							<?php endfor; ?>
						</div>
						<p class="dp-testimonial-card__text"><?php echo wp_kses_post( $t['text'] ); ?></p>
						<div class="dp-testimonial-card__author">
							<?php if ( $t['avatar'] ) : ?>
								<div class="dp-testimonial-card__avatar">
									<?php echo $t['avatar']; ?>
								</div>
							<?php else : ?>
								<div class="dp-testimonial-card__avatar dp-testimonial-card__avatar--initials">
									<?php echo esc_html( $t['initials'] ); ?>
								</div>
							<?php endif; ?>
							<div>
								<span class="dp-testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></span>
								<?php if ( $t['treatment'] ) : ?>
									<span class="dp-testimonial-card__treatment"><?php echo esc_html( $t['treatment'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div><!-- .dp-testimonials__slider-track -->
			</div><!-- .dp-testimonials__slider-container -->
		</div><!-- .dp-testimonials__slider-outer -->

		<!-- Dynamic Pagination Dots -->
		<div class="dp-testimonials__dots" aria-hidden="true"></div>

	</div>
</section>

<style>
/* ================================================
   TESTIMONIALS — Slider Carousel Style
   ================================================ */
.dp-testimonials {
	background: #FFFFFF;
	padding: 72px 0 80px;
}

/* Scoped header fix — prevents conflict with services section CSS */
.dp-testimonials .dp-section-container {
	max-width: 1160px;
	margin: 0 auto;
	padding: 0 32px;
}
.dp-testimonials .dp-section-header {
	text-align: center;
	margin-bottom: 44px;
}
.dp-testimonials .dp-section-title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: clamp(1.8rem, 3vw, 2.4rem);
	font-weight: 700;
	color: #1A2E1A;
	margin: 0 0 12px 0;
	letter-spacing: -0.3px;
}
.dp-testimonials .dp-section-rule {
	width: 48px;
	height: 3px;
	background: linear-gradient(90deg, #C9A84C, #E8C76A);
	margin: 0 auto;
	border-radius: 2px;
}
@media (max-width: 500px) {
	.dp-testimonials .dp-section-container { padding: 0 18px; }
}

.dp-testimonials__slider-outer {
	position: relative;
	width: 100%;
}

.dp-testimonials__slider-container {
	overflow: hidden;
	width: 100%;
	padding: 15px 0;
	margin: -15px 0;
}

.dp-testimonials__slider-track {
	display: flex;
	gap: 20px;
	transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
	width: 100%;
}

/* Testimonial card */
.dp-testimonial-card {
	flex: 0 0 calc((100% - 40px) / 3);
	box-sizing: border-box;
	background: #FFFFFF;
	border: 1px solid #E8E4DC;
	border-radius: 10px;
	padding: 24px 22px;
	transition: box-shadow 0.22s, transform 0.22s;
}

.dp-testimonial-card:hover {
	box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
	transform: translateY(-4px);
}

/* Stars */
.dp-testimonial-card__stars {
	display: flex;
	gap: 3px;
	margin-bottom: 12px;
}

.dp-star {
	font-size: 1rem;
	color: #E5E2DA;
}

.dp-star--filled {
	color: #F4C430;
}

/* Quote text */
.dp-testimonial-card__text {
	font-size: 0.875rem;
	color: #5C5449;
	line-height: 1.72;
	font-style: italic;
	margin: 0 0 18px 0;
}

/* Author row */
.dp-testimonial-card__author {
	display: flex;
	align-items: center;
	gap: 10px;
}

/* Avatar circle */
.dp-testimonial-card__avatar {
	width: 36px;
	height: 36px;
	border-radius: 50%;
	overflow: hidden;
	flex-shrink: 0;
	background: #EDE9DF;
}

.dp-testimonial-card__avatar img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.dp-testimonial-card__avatar--initials {
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 0.8rem;
	font-weight: 700;
	color: #4E7C59;
	background: rgba(78, 124, 89, 0.12);
}

.dp-testimonial-card__name {
	display: block;
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 0.9rem;
	font-weight: 600;
	color: #1A2E1A;
}

.dp-testimonial-card__treatment {
	display: block;
	font-size: 0.75rem;
	color: #A89F8F;
	margin-top: 1px;
}

/* Dynamic dot pagination */
.dp-testimonials__dots {
	display: flex;
	justify-content: center;
	gap: 6px;
	margin-top: 24px;
}

.dp-dot {
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: #D0CCC2;
	display: block;
	cursor: pointer;
	transition: all 0.25s ease;
}

.dp-dot--active {
	background: #4E7C59;
	width: 22px;
	border-radius: 4px;
}

/* Responsive columns */
@media (max-width: 1024px) {
	.dp-testimonial-card {
		flex: 0 0 calc((100% - 20px) / 2);
	}
}

@media (max-width: 600px) {
	.dp-testimonial-card {
		flex: 0 0 100%;
	}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var container = document.querySelector('.dp-testimonials__slider-container');
	if (!container) return;

	var track = container.querySelector('.dp-testimonials__slider-track');
	var cards = track.querySelectorAll('.dp-testimonial-card');
	var dotsContainer = document.querySelector('.dp-testimonials__dots');

	var currentIndex = 0;
	var autoPlayInterval = null;
	var intervalTime = 4000; // 4 seconds interval for quote readability

	function getItemsPerView() {
		if (window.innerWidth <= 600) return 1;
		if (window.innerWidth <= 1024) return 2;
		return 3;
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

		// Update active dot styling
		if (dotsContainer) {
			var dots = dotsContainer.querySelectorAll('.dp-dot');
			dots.forEach(function(dot, idx) {
				if (idx === currentIndex) {
					dot.classList.add('dp-dot--active');
				} else {
					dot.classList.remove('dp-dot--active');
				}
			});
		}
	}

	function renderDots() {
		if (!dotsContainer) return;
		dotsContainer.innerHTML = '';
		var itemsPerView = getItemsPerView();
		var maxIndex = Math.max(0, cards.length - itemsPerView);

		for (var i = 0; i <= maxIndex; i++) {
			var dot = document.createElement('span');
			dot.className = 'dp-dot' + (i === currentIndex ? ' dp-dot--active' : '');
			dot.setAttribute('data-index', i);
			dot.addEventListener('click', function() {
				currentIndex = parseInt(this.getAttribute('data-index'));
				updateSlider();
				startAutoPlay();
			});
			dotsContainer.appendChild(dot);
		}
	}

	function slideNext() {
		currentIndex++;
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

	// Hover to pause
	var outer = document.querySelector('.dp-testimonials__slider-outer');
	if (outer) {
		outer.addEventListener('mouseenter', stopAutoPlay);
		outer.addEventListener('mouseleave', startAutoPlay);
	}

	// Resize handling
	window.addEventListener('resize', function() {
		renderDots();
		updateSlider();
		startAutoPlay();
	});

	// Initialize
	renderDots();
	updateSlider();
	startAutoPlay();
});
</script>
