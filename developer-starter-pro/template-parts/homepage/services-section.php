<?php
/**
 * Template Part: Homepage Services Section
 *
 * Matches Apex Dental reference: "Our Services" heading with gold underline,
 * 4-column icon cards — Preventative, Cosmetic, Implants, Emergency.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$services = get_posts( array(
	'post_type'      => 'services',
	'posts_per_page' => 8,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );

// Default demo services to match reference design (shown when no CPT data)
$default_services = array(
	array(
		'title' => __( 'Preventative', 'developer-starter-pro' ),
		'desc'  => __( 'Preventive care and regular check-ups for a healthy smile.', 'developer-starter-pro' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-5-8-11a8 8 0 0 1 16 0c0 6-8 11-8 11z"/><path d="M9 12l2 2 4-4"/></svg>',
		'url'   => '#',
	),
	array(
		'title' => __( 'Cosmetic', 'developer-starter-pro' ),
		'desc'  => __( 'Improve your smile with cosmetic treatments and enhancements.', 'developer-starter-pro' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M8 8s1 3 4 3 4-3 4-3"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg>',
		'url'   => '#',
	),
	array(
		'title' => __( 'Implants', 'developer-starter-pro' ),
		'desc'  => __( 'Long-lasting, natural-looking solutions for missing teeth.', 'developer-starter-pro' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="12" rx="4"/><path d="M12 14v8"/><path d="M9 19h6"/></svg>',
		'url'   => '#',
	),
	array(
		'title' => __( 'Emergency', 'developer-starter-pro' ),
		'desc'  => __( 'Emergency dental care when you need it most. Available 24/7.', 'developer-starter-pro' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
		'url'   => '#',
	),
);
?>

<section class="dp-services" id="services">
	<div class="dp-section-container">

		<!-- Section header -->
		<div class="dp-section-header">
			<h2 class="dp-section-title"><?php esc_html_e( 'Our Services', 'developer-starter-pro' ); ?></h2>
			<div class="dp-section-rule" aria-hidden="true"></div>
		</div>

		<!-- Cards grid -->
		<div class="dp-services__grid">
			<?php
			$display_services = array();
			if ( ! empty( $services ) ) {
				foreach ( $services as $service ) {
					$short_desc = get_post_meta( $service->ID, '_developer_starter_pro_service_short_description', true );
					$icon_html  = get_post_meta( $service->ID, '_developer_starter_pro_service_icon', true );
					if ( empty( $icon_html ) ) {
						$icon_html = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s-8-5-8-11a8 8 0 0 1 16 0c0 6-8 11-8 11z"/></svg>';
					}
					$display_services[] = array(
						'title' => $service->post_title,
						'desc'  => $short_desc ?: wp_trim_words( $service->post_content, 12 ),
						'icon'  => $icon_html,
						'url'   => get_permalink( $service->ID ),
					);
				}
			}

			if ( count( $display_services ) < 4 ) {
				$needed = 4 - count( $display_services );
				for ( $i = 0; $i < $needed; $i++ ) {
					$display_services[] = $default_services[ $i % count( $default_services ) ];
				}
			}

			foreach ( $display_services as $svc ) :
			?>
				<div class="dp-service-card">
					<div class="dp-service-card__icon"><?php echo $svc['icon']; // phpcs:ignore ?></div>
					<h3 class="dp-service-card__title">
						<a href="<?php echo esc_url( $svc['url'] ); ?>"><?php echo esc_html( $svc['title'] ); ?></a>
					</h3>
					<p class="dp-service-card__desc"><?php echo esc_html( $svc['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<style>
/* ================================================
   SERVICES — Apex Dental reference match
   ================================================ */
.dp-services {
	background: #FFFFFF;
	padding: 72px 0 80px;
}

.dp-section-container {
	max-width: 1100px;
	margin: 0 auto;
	padding: 0 32px;
}

/* Section header — centered, gold rule under title */
.dp-section-header {
	text-align: center;
	margin-bottom: 44px;
}

.dp-section-title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 2rem;
	font-weight: 700;
	color: #1A2E1A;
	margin: 0 0 10px 0;
	letter-spacing: -0.2px;
}

.dp-section-rule {
	width: 40px;
	height: 3px;
	background: #C9A84C;
	margin: 0 auto;
	border-radius: 2px;
}

/* 4-column services grid */
.dp-services__grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 20px;
}

/* Service card */
.dp-service-card {
	background: #FFFFFF;
	border: 1px solid #E8E4DC;
	border-radius: 10px;
	padding: 24px 20px 22px;
	transition: box-shadow 0.22s ease, transform 0.22s ease;
}

.dp-service-card:hover {
	box-shadow: 0 6px 20px rgba(78, 124, 89, 0.1);
	transform: translateY(-3px);
}

/* Icon circle */
.dp-service-card__icon {
	width: 44px;
	height: 44px;
	background: rgba(78, 124, 89, 0.08);
	border: 1px solid rgba(78, 124, 89, 0.15);
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	margin-bottom: 14px;
}

.dp-service-card__icon svg {
	width: 22px;
	height: 22px;
	color: #4E7C59;
	stroke: #4E7C59;
}

.dp-service-card__title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1rem;
	font-weight: 600;
	color: #1A2E1A;
	margin: 0 0 8px 0;
}

.dp-service-card__title a {
	color: #1A2E1A;
	text-decoration: none;
	transition: color 0.15s;
}

.dp-service-card__title a:hover {
	color: #4E7C59;
}

.dp-service-card__desc {
	font-size: 0.8125rem;
	color: #7D7468;
	line-height: 1.65;
	margin: 0;
}

@media (max-width: 900px) {
	.dp-services__grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 540px) {
	.dp-services__grid { grid-template-columns: 1fr; }
}
</style>
