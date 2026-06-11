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
	'posts_per_page' => 3,
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

$has_real = ! empty( $testimonials );
?>

<section class="dp-testimonials" id="testimonials">
	<div class="dp-section-container">

		<div class="dp-section-header">
			<h2 class="dp-section-title"><?php esc_html_e( 'Patient Testimonials', 'developer-starter-pro' ); ?></h2>
			<div class="dp-section-rule" aria-hidden="true"></div>
		</div>

		<div class="dp-testimonials__grid">

			<?php if ( $has_real ) :
				foreach ( $testimonials as $t ) :
					$patient_name = get_post_meta( $t->ID, '_developer_starter_pro_testimonial_patient_name', true ) ?: $t->post_title;
					$rating       = intval( get_post_meta( $t->ID, '_developer_starter_pro_testimonial_rating', true ) ?: 5 );
					$treatment    = get_post_meta( $t->ID, '_developer_starter_pro_testimonial_treatment', true );
					$initials     = strtoupper( substr( $patient_name, 0, 1 ) );
			?>
			<div class="dp-testimonial-card">
				<div class="dp-testimonial-card__stars" aria-label="<?php echo esc_attr( $rating . ' out of 5 stars' ); ?>">
					<?php for ( $i = 0; $i < 5; $i++ ) : ?>
						<span class="dp-star<?php echo $i < $rating ? ' dp-star--filled' : ''; ?>">★</span>
					<?php endfor; ?>
				</div>
				<p class="dp-testimonial-card__text"><?php echo wp_kses_post( $t->post_content ); ?></p>
				<div class="dp-testimonial-card__author">
					<?php if ( has_post_thumbnail( $t->ID ) ) : ?>
						<div class="dp-testimonial-card__avatar">
							<?php echo get_the_post_thumbnail( $t->ID, array( 36, 36 ) ); ?>
						</div>
					<?php else : ?>
						<div class="dp-testimonial-card__avatar dp-testimonial-card__avatar--initials">
							<?php echo esc_html( $initials ); ?>
						</div>
					<?php endif; ?>
					<div>
						<span class="dp-testimonial-card__name"><?php echo esc_html( $patient_name ); ?></span>
						<?php if ( $treatment ) : ?>
							<span class="dp-testimonial-card__treatment"><?php echo esc_html( $treatment ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
			<?php else :
				foreach ( $defaults as $d ) : ?>
			<div class="dp-testimonial-card">
				<div class="dp-testimonial-card__stars" aria-label="5 out of 5 stars">
					<span class="dp-star dp-star--filled">★</span><span class="dp-star dp-star--filled">★</span><span class="dp-star dp-star--filled">★</span><span class="dp-star dp-star--filled">★</span><span class="dp-star dp-star--filled">★</span>
				</div>
				<p class="dp-testimonial-card__text"><?php echo esc_html( $d['text'] ); ?></p>
				<div class="dp-testimonial-card__author">
					<div class="dp-testimonial-card__avatar dp-testimonial-card__avatar--initials">
						<?php echo esc_html( $d['initials'] ); ?>
					</div>
					<div>
						<span class="dp-testimonial-card__name"><?php echo esc_html( $d['name'] ); ?></span>
						<span class="dp-testimonial-card__treatment"><?php echo esc_html( $d['treatment'] ); ?></span>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
			<?php endif; ?>

		</div><!-- .dp-testimonials__grid -->

		<!-- Dot pagination (decorative) -->
		<div class="dp-testimonials__dots" aria-hidden="true">
			<span class="dp-dot dp-dot--active"></span>
			<span class="dp-dot"></span>
			<span class="dp-dot"></span>
			<span class="dp-dot"></span>
		</div>

	</div>
</section>

<style>
/* ================================================
   TESTIMONIALS — Apex Dental reference match
   ================================================ */
.dp-testimonials {
	background: #FFFFFF;
	padding: 72px 0 80px;
}

/* 3-column grid */
.dp-testimonials__grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 20px;
	margin-bottom: 28px;
}

/* Testimonial card */
.dp-testimonial-card {
	background: #FFFFFF;
	border: 1px solid #E8E4DC;
	border-radius: 10px;
	padding: 24px 22px;
	transition: box-shadow 0.22s;
}

.dp-testimonial-card:hover {
	box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
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

/* Dot pagination */
.dp-testimonials__dots {
	display: flex;
	justify-content: center;
	gap: 6px;
	margin-top: 8px;
}

.dp-dot {
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: #D0CCC2;
	display: block;
	transition: background 0.2s;
}

.dp-dot--active {
	background: #4E7C59;
	width: 22px;
	border-radius: 4px;
}

@media (max-width: 900px) {
	.dp-testimonials__grid { grid-template-columns: 1fr; }
}
</style>
