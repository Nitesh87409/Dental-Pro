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
				<a href="<?php echo esc_url( $booking_url ); ?>" class="dp-booking__btn">
					<?php esc_html_e( 'Book now', 'developer-starter-pro' ); ?>
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
	border-color: #4E7C59;
	color: #4E7C59;
}

.dp-time-slot--active {
	background: #4E7C59;
	border-color: #4E7C59;
	color: #FFFFFF;
	font-weight: 600;
}

/* Book Now */
.dp-booking__btn {
	display: inline-block;
	background: #4E7C59;
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
	background: #3D6347;
	color: #fff;
}

@media (max-width: 768px) {
	.dp-booking__bar { flex-direction: column; align-items: stretch; }
	.dp-booking__field--cta { text-align: center; }
	.dp-booking__btn { width: 100%; text-align: center; display: block; }
}
</style>
