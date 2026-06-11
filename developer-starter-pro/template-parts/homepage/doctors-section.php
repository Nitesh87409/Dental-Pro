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
	'posts_per_page' => 4,
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

		<div class="dp-doctors__grid">
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

			if ( count( $display_doctors ) < 4 ) {
				$needed = 4 - count( $display_doctors );
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
		</div><!-- .dp-doctors__grid -->

	</div>
</section>

<style>
/* ================================================
   DOCTORS — Apex Dental reference match
   ================================================ */
.dp-doctors {
	background: #F9F8F5;
	padding: 72px 0 80px;
}

/* 4-column horizontal cards */
.dp-doctors__grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 20px;
}

/* Doctor card — vertical: photo top, info bottom */
.dp-doctor-card {
	background: #FFFFFF;
	border: 1px solid #E8E4DC;
	border-radius: 10px;
	padding: 0; /* Clear padding for edge-to-edge top image */
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
	display: block;
	transition: transform 0.4s ease;
}

.dp-doctor-card:hover .dp-doctor-card__photo img {
	transform: scale(1.04);
}

.dp-doctor-card__photo-placeholder {
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	background: #F4EFEB;
}

.dp-doctor-card__info {
	padding: 16px 20px;
	text-align: center;
}

.dp-doctor-card__name {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.05rem; /* Larger font size for premium visibility */
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

@media (max-width: 1024px) {
	.dp-doctors__grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 540px) {
	.dp-doctors__grid { grid-template-columns: 1fr; }
}
</style>
