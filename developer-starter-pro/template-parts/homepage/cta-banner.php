<?php
/**
 * Template Part: Homepage Appointment Booking Section
 *
 * Matches Apex Dental reference: "Appointment Booking" heading,
 * date picker + time slot buttons + Book Now button in one row.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$booking_url = developer_starter_pro_get_booking_url();
?>

<section class="dp-booking" id="booking">
	<div class="dp-section-container">

		<h2 class="dp-booking__heading"><?php esc_html_e( 'Appointment Booking', 'developer-starter-pro' ); ?></h2>

		<div class="dp-booking__bar">

			<!-- Date picker column -->
			<div class="dp-booking__field">
				<label class="dp-booking__label" for="dp-booking-date">
					<?php esc_html_e( 'Date picker', 'developer-starter-pro' ); ?>
				</label>
				<div class="dp-booking__date-wrap">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
						<line x1="16" y1="2" x2="16" y2="6"/>
						<line x1="8" y1="2" x2="8" y2="6"/>
						<line x1="3" y1="10" x2="21" y2="10"/>
					</svg>
					<input
						type="date"
						id="dp-booking-date"
						class="dp-booking__date-input"
						value="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>"
						aria-label="<?php esc_attr_e( 'Select appointment date', 'developer-starter-pro' ); ?>"
					>
				</div>
			</div>

			<!-- Time slots -->
			<div class="dp-booking__field dp-booking__field--time">
				<label class="dp-booking__label"><?php esc_html_e( 'Time', 'developer-starter-pro' ); ?></label>
				<div class="dp-booking__times">
					<button type="button" class="dp-time-slot dp-time-slot--active">9:00 AM</button>
					<button type="button" class="dp-time-slot">10:00 AM</button>
					<button type="button" class="dp-time-slot">2:00 PM</button>
					<button type="button" class="dp-time-slot">3:00 PM</button>
				</div>
			</div>

			<!-- Book Now CTA -->
			<div class="dp-booking__field dp-booking__field--cta">
				<a href="<?php echo esc_url( $booking_url ); ?>" class="dp-booking__btn" id="dpBookingBtn">
					<span class="dp-booking__btn-text"><?php esc_html_e( 'Book now', 'developer-starter-pro' ); ?></span>
					<span class="dp-booking__slider-track-text"><?php esc_html_e( 'Slide to Book', 'developer-starter-pro' ); ?></span>
					<span class="dp-booking__slider-handle">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</span>
				</a>
			</div>

		</div><!-- .dp-booking__bar -->

	</div>
</section>

<script>
// Time slot toggle
document.querySelectorAll('.dp-time-slot').forEach(function(btn) {
	btn.addEventListener('click', function() {
		document.querySelectorAll('.dp-time-slot').forEach(function(b) {
			b.classList.remove('dp-time-slot--active');
		});
		this.classList.add('dp-time-slot--active');
	});
});

// Mobile Slide to Book Logic
document.addEventListener('DOMContentLoaded', function() {
	var bookingBtn = document.getElementById('dpBookingBtn');
	if (!bookingBtn) return;
	
	var handle = bookingBtn.querySelector('.dp-booking__slider-handle');
	var trackText = bookingBtn.querySelector('.dp-booking__slider-track-text');
	if (!handle || !trackText) return;
	
	var isDragging = false;
	var startX = 0;
	var slideCompleted = false;
	
	function getClientX(e) {
		return e.clientX || (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
	}
	
	function onStart(e) {
		if (slideCompleted || window.innerWidth > 768) return;
		isDragging = true;
		startX = getClientX(e);
		handle.style.transition = 'none';
		trackText.style.transition = 'none';
	}
	
	function onMove(e) {
		if (!isDragging) return;
		var x = getClientX(e);
		var deltaX = x - startX;
		
		var containerWidth = bookingBtn.offsetWidth;
		var handleWidth = handle.offsetWidth;
		var maxSlide = containerWidth - handleWidth - 10; // 5px padding on each side
		
		deltaX = Math.max(0, Math.min(deltaX, maxSlide));
		
		handle.style.transform = 'translateX(' + deltaX + 'px)';
		
		// Fade out text as we slide
		var progress = deltaX / maxSlide;
		trackText.style.opacity = Math.max(0, 1 - progress * 1.5);
		
		// Prevent scroll on touch devices while sliding
		if (e.cancelable) {
			e.preventDefault();
		}
	}
	
	function onEnd() {
		if (!isDragging) return;
		isDragging = false;
		
		var containerWidth = bookingBtn.offsetWidth;
		var handleWidth = handle.offsetWidth;
		var maxSlide = containerWidth - handleWidth - 10;
		
		// Read current translation from style transform
		var transformMatrix = window.getComputedStyle(handle).transform;
		var currentX = 0;
		if (transformMatrix && transformMatrix !== 'none') {
			var values = transformMatrix.split('(')[1].split(')')[0].split(',');
			currentX = parseFloat(values[4]) || 0;
		}
		
		if (currentX >= maxSlide * 0.9) {
			// Complete the slide
			slideCompleted = true;
			handle.style.transition = 'transform 0.2s ease-out';
			handle.style.transform = 'translateX(' + maxSlide + 'px)';
			trackText.style.opacity = '0';
			
			// Show checkmark
			handle.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
			
			// Set transition state
			sessionStorage.setItem('dp_page_transition', 'active');
			
			// Display the transition curtain immediately
			var curtain = document.getElementById('dp-page-transition-curtain');
			if (curtain) {
				curtain.classList.add('is-active');
			}
			
			// Perform navigation
			setTimeout(function() {
				window.location.href = bookingBtn.getAttribute('href');
			}, 400);
		} else {
			// Bounce back spring animation
			handle.style.transition = 'transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
			handle.style.transform = 'translateX(0)';
			trackText.style.transition = 'opacity 0.3s ease';
			trackText.style.opacity = '1';
		}
	}
	
	// Touch events
	handle.addEventListener('touchstart', onStart, { passive: false });
	window.addEventListener('touchmove', onMove, { passive: false });
	window.addEventListener('touchend', onEnd);
	
	// Mouse events
	handle.addEventListener('mousedown', onStart);
	window.addEventListener('mousemove', onMove);
	window.addEventListener('mouseup', onEnd);
	
	// Prevent standard navigation click unless slider was completed
	bookingBtn.addEventListener('click', function(e) {
		if (window.innerWidth <= 768 && !slideCompleted) {
			e.preventDefault();
		}
	});
});
</script>

<style>
/* ================================================
   APPOINTMENT BOOKING — Apex Dental reference
   ================================================ */
.dp-booking {
	background: #F9F8F5;
	padding: 56px 0 64px;
}

.dp-booking__heading {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.625rem;
	font-weight: 700;
	color: #1A2E1A;
	margin: 0 0 24px 0;
}

/* Full-width booking bar */
.dp-booking__bar {
	background: #FFFFFF;
	border: 1px solid #E8E4DC;
	border-radius: 10px;
	padding: 20px 24px;
	display: flex;
	align-items: flex-end;
	gap: 24px;
	flex-wrap: wrap;
}

.dp-booking__label {
	display: block;
	font-size: 0.75rem;
	font-weight: 600;
	color: #A89F8F;
	text-transform: uppercase;
	letter-spacing: 0.8px;
	margin-bottom: 8px;
}

/* Date field */
.dp-booking__date-wrap {
	display: flex;
	align-items: center;
	gap: 8px;
	border: 1px solid #E8E4DC;
	border-radius: 6px;
	padding: 9px 14px;
	background: #FAFAF8;
	min-width: 160px;
}

.dp-booking__date-wrap svg {
	color: #7D7468;
	flex-shrink: 0;
}

.dp-booking__date-input {
	border: none;
	background: transparent;
	font-size: 0.875rem;
	color: #3D3830;
	outline: none;
	width: 130px;
	cursor: pointer;
}

/* Time slots */
.dp-booking__field--time {
	flex: 1;
}

.dp-booking__times {
	display: flex;
	gap: 8px;
	flex-wrap: wrap;
}

.dp-time-slot {
	padding: 9px 16px;
	border: 1px solid #E8E4DC;
	border-radius: 6px;
	background: #FAFAF8;
	font-size: 0.875rem;
	color: #5C5449;
	cursor: pointer;
	font-weight: 500;
	transition: all 0.15s;
}

.dp-time-slot:hover {
	border-color: var(--developer-starter-pro-primary);
	color: var(--developer-starter-pro-primary);
}

.dp-time-slot--active {
	background: var(--developer-starter-pro-primary);
	border-color: var(--developer-starter-pro-primary);
	color: #FFFFFF;
	font-weight: 600;
}

/* Book Now */
.dp-booking__btn {
	display: inline-block;
	background: var(--developer-starter-pro-primary);
	color: #FFFFFF;
	font-size: 0.9rem;
	font-weight: 600;
	padding: 11px 26px;
	border-radius: 6px;
	text-decoration: none;
	transition: background 0.2s;
	white-space: nowrap;
}

.dp-booking__btn:hover {
	background: var(--developer-starter-pro-primary-dark);
	color: #fff;
}

/* Hide slider elements on desktop/PC */
.dp-booking__slider-track-text,
.dp-booking__slider-handle {
	display: none;
}

/* Hide entire booking section on desktop/PC */
@media (min-width: 769px) {
	.dp-booking {
		display: none !important;
	}
}

/* Mobile: Floating pill "Book now" button / Slider */
@media (max-width: 768px) {
	.dp-booking {
		padding: 0 !important;
		background: transparent !important;
		position: fixed;
		bottom: 20px;
		left: 16px;
		right: 16px;
		z-index: 9997;
		pointer-events: none;
	}
	.dp-booking .dp-section-container {
		padding: 0 !important;
		max-width: 100% !important;
	}
	.dp-booking__heading {
		display: none !important;
	}
	.dp-booking__bar {
		background: transparent !important;
		border: none !important;
		box-shadow: none !important;
		padding: 0 !important;
		display: block !important;
		pointer-events: auto;
	}
	.dp-booking__field,
	.dp-booking__field--time {
		display: none !important;
	}
	.dp-booking__field--cta {
		display: block !important;
	}
	
	/* iOS Slider Layout */
	.dp-booking__btn-text {
		display: none !important;
	}
	.dp-booking__slider-track-text {
		display: block !important;
		position: absolute !important;
		left: 50% !important;
		top: 50% !important;
		transform: translate(-50%, -50%) !important;
		font-size: 1.05rem !important;
		font-weight: 700 !important;
		letter-spacing: 0.5px !important;
		white-space: nowrap !important;
		pointer-events: none !important;
		z-index: 1 !important;
		
		/* Shimmer effect */
		background: linear-gradient(to right, rgba(13, 148, 136, 0.4) 0%, rgba(13, 148, 136, 1) 50%, rgba(13, 148, 136, 0.4) 100%);
		background-size: 200% auto;
		color: transparent !important;
		-webkit-background-clip: text !important;
		background-clip: text !important;
		animation: dpShimmer 2.5s infinite linear !important;
	}
	
	@keyframes dpShimmer {
		0% { background-position: 200% 0; }
		100% { background-position: -200% 0; }
	}
	
	.dp-booking__btn {
		position: relative !important;
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		width: 100% !important;
		height: 60px !important;
		padding: 0 !important;
		background: rgba(var(--developer-starter-pro-primary-rgb, 13, 148, 136), 0.1) !important;
		backdrop-filter: blur(12px) !important;
		-webkit-backdrop-filter: blur(12px) !important;
		border: 1.5px solid var(--developer-starter-pro-primary) !important;
		border-radius: 50px !important;
		overflow: hidden !important;
		user-select: none !important;
		-webkit-user-select: none !important;
		box-shadow: 0 8px 32px 0 rgba(var(--developer-starter-pro-primary-rgb, 13, 148, 136), 0.1), 0 2px 8px 0 rgba(0, 0, 0, 0.05) !important;
	}
	
	.dp-booking__slider-handle {
		display: flex !important;
		position: absolute !important;
		left: 5px !important;
		top: 5px !important;
		bottom: 5px !important;
		width: 50px !important;
		height: 50px !important;
		border-radius: 50% !important;
		background: var(--developer-starter-pro-primary) !important;
		color: #ffffff !important;
		align-items: center !important;
		justify-content: center !important;
		cursor: grab !important;
		z-index: 2 !important;
		box-shadow: 0 4px 12px rgba(var(--developer-starter-pro-primary-rgb, 13, 148, 136), 0.3) !important;
		touch-action: none;
	}
	.dp-booking__slider-handle:active {
		cursor: grabbing !important;
	}
	
	/* Dark Mode Support */
	body.dark-mode .dp-booking__btn {
		background: rgba(var(--developer-starter-pro-primary-rgb, 13, 148, 136), 0.2) !important;
	}
	body.dark-mode .dp-booking__slider-track-text {
		background: linear-gradient(to right, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.3) 100%);
		background-size: 200% auto;
		-webkit-background-clip: text !important;
		background-clip: text !important;
	}
}
</style>
