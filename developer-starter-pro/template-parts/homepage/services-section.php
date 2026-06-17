<?php
/**
 * Template Part: Homepage Services Section — Premium v2
 *
 * Fully admin-panel driven. Shows price & duration from CPT meta.
 * No hardcoded services — all managed from WordPress admin.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$services = get_posts( array(
	'post_type'      => 'services',
	'posts_per_page' => 4,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );

// Default fallback services (shown when fewer than 4 CPT services exist)
$default_services = array(
	array(
		'title'    => __( 'Preventative Cleanings', 'developer-starter-pro' ),
		'desc'     => __( 'Comprehensive dental cleanings, exams, and digital X-rays for preventative care.', 'developer-starter-pro' ),
		'price'    => '89',
		'duration' => '30',
		'card_img' => get_theme_file_uri( 'assets/images/main-banner.jpeg' ),
		'icon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-5-8-11a8 8 0 0 1 16 0c0 6-8 11-8 11z"/><path d="M9 12l2 2 4-4"/></svg>',
		'url'      => '#',
		'color'    => 'green',
	),
	array(
		'title'    => __( 'Cosmetic Dentistry', 'developer-starter-pro' ),
		'desc'     => __( 'Transform your smile with veneers, whitening, bonding, and aesthetic treatments.', 'developer-starter-pro' ),
		'price'    => '299',
		'duration' => '60',
		'card_img' => get_theme_file_uri( 'assets/images/main-banner.jpeg' ),
		'icon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2c-.5 0-1 .5-1.5 1.5C9.5 5.5 9 6.5 8 7.5 7 8.5 5.5 9 4.5 9 3.5 9 3 9.5 3 10.5c0 1.5.5 3 1 4.5.5 1.5 1 3 1 4.5 0 1 .5 1.5 1.5 1.5.8 0 1.5-.5 2-1.5.5-1 1-2.5 1.5-2.5.5 0 1 1.5 1.5 2.5.5 1 1.2 1.5 2 1.5 1 0 1.5-.5 1.5-1.5 0-1.5.5-3 1-4.5.5-1.5 1-3 1-4.5 0-1-.5-1.5-1.5-1.5-1 0-2.5-.5-3.5-1.5-1-1-1.5-2-2.5-4C13 2.5 12.5 2 12 2z"/></svg>',
		'url'      => '#',
		'color'    => 'teal',
	),
	array(
		'title'    => __( 'Dental Implants', 'developer-starter-pro' ),
		'desc'     => __( 'Permanent, natural-looking solutions for missing teeth that restore function.', 'developer-starter-pro' ),
		'price'    => '1499',
		'duration' => '90',
		'card_img' => get_theme_file_uri( 'assets/images/main-banner.jpeg' ),
		'icon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="12" rx="4"/><path d="M12 14v8"/><path d="M9 19h6"/></svg>',
		'url'      => '#',
		'color'    => 'blue',
	),
	array(
		'title'    => __( 'Emergency Care', 'developer-starter-pro' ),
		'desc'     => __( 'Prompt emergency dental treatment to relieve pain and address urgent problems.', 'developer-starter-pro' ),
		'price'    => '150',
		'duration' => '45',
		'card_img' => get_theme_file_uri( 'assets/images/main-banner.jpeg' ),
		'icon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
		'url'      => '#',
		'color'    => 'red',
	),
);

// Color palette for cards (cycles for > 4 cards)
$card_colors = array(
	array( 'strip' => 'linear-gradient(135deg,#2E6B42,#4E9E6A)', 'glow' => 'rgba(46,107,66,0.18)', 'badge' => '#1E5A32' ),
	array( 'strip' => 'linear-gradient(135deg,#1B6B6B,#2DA89A)', 'glow' => 'rgba(27,107,107,0.18)', 'badge' => '#145050' ),
	array( 'strip' => 'linear-gradient(135deg,#2A527A,#4180C0)', 'glow' => 'rgba(42,82,122,0.18)', 'badge' => '#1A3A5C' ),
	array( 'strip' => 'linear-gradient(135deg,#7A2A2A,#C04141)', 'glow' => 'rgba(122,42,42,0.18)', 'badge' => '#5C1A1A' ),
	array( 'strip' => 'linear-gradient(135deg,#5A3A7A,#8F5EC0)', 'glow' => 'rgba(90,58,122,0.18)', 'badge' => '#3E2058' ),
	array( 'strip' => 'linear-gradient(135deg,#3A6B2E,#6EAA50)', 'glow' => 'rgba(58,107,46,0.18)', 'badge' => '#284E1E' ),
	array( 'strip' => 'linear-gradient(135deg,#6B5A1B,#C09A2A)', 'glow' => 'rgba(107,90,27,0.18)', 'badge' => '#4E3E0E' ),
	array( 'strip' => 'linear-gradient(135deg,#1B4A6B,#2A80B8)', 'glow' => 'rgba(27,74,107,0.18)', 'badge' => '#0E3050' ),
);
?>

<section class="dp-services" id="services">
	<div class="dp-services__bg-deco" aria-hidden="true">
		<div class="dp-deco-circle dp-deco-circle--1"></div>
		<div class="dp-deco-circle dp-deco-circle--2"></div>
		<div class="dp-deco-circle dp-deco-circle--3"></div>
	</div>

	<div class="dp-services__container">

		<!-- Section Header -->
		<div class="dp-services__header">
			<span class="dp-services__eyebrow">
				<svg viewBox="0 0 16 16" fill="currentColor" width="10" height="10"><circle cx="8" cy="8" r="8"/></svg>
				<?php esc_html_e( 'What We Offer', 'developer-starter-pro' ); ?>
				<svg viewBox="0 0 16 16" fill="currentColor" width="10" height="10"><circle cx="8" cy="8" r="8"/></svg>
			</span>
			<h2 class="dp-services__title"><?php esc_html_e( 'Our Services', 'developer-starter-pro' ); ?></h2>
			<div class="dp-services__rule" aria-hidden="true">
				<span></span><span class="dp-rule-diamond"></span><span></span>
			</div>
			<p class="dp-services__subtitle">
				<?php esc_html_e( 'Comprehensive dental care tailored to every need — from routine check-ups to complete smile transformations.', 'developer-starter-pro' ); ?>
			</p>
		</div>

		<!-- Services Grid -->
		<div class="dp-services__grid">
			<?php
			$display_services = array();

			if ( ! empty( $services ) ) {
				foreach ( $services as $idx => $service ) {
					$short_desc = get_post_meta( $service->ID, '_developer_starter_pro_service_short_description', true );
					$icon_key   = get_post_meta( $service->ID, '_developer_starter_pro_service_icon', true );
					$custom_svg = get_post_meta( $service->ID, '_developer_starter_pro_service_custom_svg', true );
					$price      = get_post_meta( $service->ID, '_developer_starter_pro_service_price', true );
					$duration   = get_post_meta( $service->ID, '_developer_starter_pro_service_duration', true );
					$card_img   = get_post_meta( $service->ID, '_developer_starter_pro_service_card_image', true );

					$icon_html = '';
					if ( ! empty( $custom_svg ) ) {
						$icon_html = $custom_svg;
					} elseif ( ! empty( $icon_key ) && function_exists( 'developer_starter_pro_get_service_icons' ) ) {
						$icons_list = developer_starter_pro_get_service_icons();
						$icon_html  = isset( $icons_list[ $icon_key ] ) ? $icons_list[ $icon_key ]['svg'] : '';
					}
					if ( empty( $icon_html ) ) {
						$icon_html = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2c-.5 0-1 .5-1.5 1.5C9.5 5.5 9 6.5 8 7.5 7 8.5 5.5 9 4.5 9 3.5 9 3 9.5 3 10.5c0 1.5.5 3 1 4.5.5 1.5 1 3 1 4.5 0 1 .5 1.5 1.5 1.5.8 0 1.5-.5 2-1.5.5-1 1-2.5 1.5-2.5.5 0 1 1.5 1.5 2.5.5 1 1.2 1.5 2 1.5 1 0 1.5-.5 1.5-1.5 0-1.5.5-3 1-4.5.5-1.5 1-3 1-4.5 0-1-.5-1.5-1.5-1.5-1 0-2.5-.5-3.5-1.5-1-1-1.5-2-2.5-4C13 2.5 12.5 2 12 2z"/></svg>';
					}

					$display_services[] = array(
						'title'    => $service->post_title,
						'desc'     => $short_desc ?: wp_trim_words( $service->post_content, 18 ),
						'icon'     => $icon_html,
						'url'      => get_permalink( $service->ID ),
						'price'    => $price,
						'duration' => $duration,
						'card_img' => $card_img,
					);
				}
			}

			// Fill to minimum 4 with defaults
			if ( count( $display_services ) < 4 ) {
				$needed = 4 - count( $display_services );
				for ( $i = 0; $i < $needed; $i++ ) {
					$d = $default_services[ $i % count( $default_services ) ];
					$display_services[] = array(
						'title'    => $d['title'],
						'desc'     => $d['desc'],
						'icon'     => $d['icon'],
						'url'      => $d['url'],
						'price'    => $d['price'],
						'duration' => $d['duration'],
						'card_img' => '',
					);
				}
			}

			// Limit to exactly 4 on homepage
			$display_services = array_slice( $display_services, 0, 4 );

			foreach ( $display_services as $idx => $svc ) :
				$color    = $card_colors[ $idx % count( $card_colors ) ];
				$clean_price = function_exists( 'developer_starter_pro_get_clean_service_price' ) ? developer_starter_pro_get_clean_service_price( $svc['price'] ) : floatval( preg_replace( '/[^\d.]/', '', (string) $svc['price'] ) );
				$has_price = $clean_price > 0;
				$price_fmt = $has_price ? '$' . number_format( $clean_price ) : '';
				$has_dur   = ! empty( $svc['duration'] );
				$has_card_img = ! empty( $svc['card_img'] );
				// Strip style: image bg or gradient
				if ( $has_card_img ) {
					$strip_style = 'background: url(' . esc_url( $svc['card_img'] ) . ') center/cover no-repeat; position:relative;';
				} else {
					$strip_style = 'background:' . esc_attr( $color['strip'] ) . ';';
				}
			?>
			<article class="dp-svc-card" style="--card-glow:<?php echo esc_attr( $color['glow'] ); ?>">

				<!-- Gradient Strip with Icon -->
				<div class="dp-svc-card__strip" style="<?php echo $strip_style; // phpcs:ignore ?>">
					<?php if ( $has_card_img ) : ?>
					<div class="dp-svc-card__strip-img-overlay" aria-hidden="true"></div>
					<?php endif; ?>
					<div class="dp-svc-card__icon-wrap">
						<?php echo $svc['icon']; // phpcs:ignore ?>
					</div>
					<div class="dp-svc-card__strip-deco" aria-hidden="true"></div>
					<?php if ( $has_dur ) : ?>
					<div class="dp-svc-card__dur-badge" style="background:<?php echo esc_attr( $color['badge'] ); ?>">
						<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><circle cx="8" cy="8" r="6"/><path d="M8 5v3l2 2"/></svg>
						<?php echo esc_html( $svc['duration'] ); ?> <?php esc_html_e( 'mins', 'developer-starter-pro' ); ?>
					</div>
					<?php endif; ?>
				</div>

				<!-- Card Body -->
				<div class="dp-svc-card__body">
					<h3 class="dp-svc-card__title">
						<a href="<?php echo esc_url( $svc['url'] ); ?>"><?php echo esc_html( $svc['title'] ); ?></a>
					</h3>
					<p class="dp-svc-card__desc"><?php echo esc_html( $svc['desc'] ); ?></p>
				</div>

				<!-- Card Footer -->
				<div class="dp-svc-card__footer">
					<div class="dp-svc-card__price">
						<?php if ( $has_price ) : ?>
							<span class="dp-price-amount"><?php echo esc_html( $price_fmt ); ?></span>
						<?php else : ?>
							<span class="dp-price-amount" style="font-size: 1.05rem; color: #5A6E5A;"><?php esc_html_e( 'Call Us', 'developer-starter-pro' ); ?></span>
						<?php endif; ?>
					</div>
					<a href="<?php echo esc_url( $svc['url'] ); ?>" class="dp-svc-card__btn" aria-label="<?php echo esc_attr( sprintf( __( 'Learn more about %s', 'developer-starter-pro' ), $svc['title'] ) ); ?>">
						<span><?php esc_html_e( 'Learn More', 'developer-starter-pro' ); ?></span>
						<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
					</a>
				</div>

				<!-- Hover shine effect -->
				<div class="dp-svc-card__shine" aria-hidden="true"></div>
			</article>
			<?php endforeach; ?>
		</div>

		<!-- Bottom CTA -->
		<div class="dp-services__cta-row">
			<a href="<?php echo esc_url( home_url( '/services' ) ); ?>" class="dp-services__view-all">
				<?php esc_html_e( 'View All Services', 'developer-starter-pro' ); ?>
				<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
			</a>
		</div>

	</div>
</section>

<style>
/* =====================================================
   SERVICES SECTION — Premium v2
   ===================================================== */

.dp-services {
	position: relative;
	background: linear-gradient(175deg, #F6F9F7 0%, #FAFCFA 55%, #EEF4F0 100%);
	padding: 96px 0 100px;
	overflow: hidden;
}

/* Decorative background circles */
.dp-services__bg-deco { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.dp-deco-circle {
	position: absolute;
	border-radius: 50%;
	opacity: 0.35;
}
.dp-deco-circle--1 {
	width: 480px; height: 480px;
	background: radial-gradient(circle, rgba(78,124,89,0.12) 0%, transparent 70%);
	top: -120px; left: -100px;
}
.dp-deco-circle--2 {
	width: 360px; height: 360px;
	background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%);
	top: 40%; right: -80px;
}
.dp-deco-circle--3 {
	width: 280px; height: 280px;
	background: radial-gradient(circle, rgba(78,124,89,0.08) 0%, transparent 70%);
	bottom: -60px; left: 35%;
}

.dp-services .dp-services__container {
	position: relative;
	max-width: 1160px;
	margin: 0 auto;
	padding: 0 32px;
	z-index: 1;
}

/* ── Section Header ── */
.dp-services__header {
	text-align: center;
	margin-bottom: 60px;
}

.dp-services__eyebrow {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	font-size: 0.68rem;
	font-weight: 700;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: var(--developer-starter-pro-primary);
	margin-bottom: 16px;
}

.dp-services__title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: clamp(2rem, 3.5vw, 2.8rem);
	font-weight: 700;
	color: #1A2E1A;
	margin: 0 0 16px 0;
	letter-spacing: -0.5px;
	line-height: 1.15;
}

/* Decorative rule with diamond */
.dp-services__rule {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	margin-bottom: 20px;
}
.dp-services__rule span {
	display: block;
	height: 2px;
	width: 48px;
	background: linear-gradient(90deg, transparent, #C9A84C);
	border-radius: 2px;
}
.dp-services__rule span:last-child {
	background: linear-gradient(90deg, #C9A84C, transparent);
}
.dp-rule-diamond {
	width: 8px !important;
	height: 8px !important;
	background: #C9A84C !important;
	border-radius: 1px !important;
	transform: rotate(45deg);
}

.dp-services__subtitle {
	font-size: 1rem;
	color: #5A6E5A;
	line-height: 1.75;
	max-width: 540px;
	margin: 0 auto;
}

/* ── Grid ── */
.dp-services__grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 24px;
}

/* ── Service Card ── */
.dp-svc-card {
	position: relative;
	background: #FFFFFF;
	border-radius: 18px;
	overflow: hidden;
	display: flex;
	flex-direction: column;
	box-shadow:
		0 1px 3px rgba(26,46,26,0.06),
		0 4px 16px rgba(26,46,26,0.07);
	transition:
		transform 0.35s cubic-bezier(0.34, 1.5, 0.64, 1),
		box-shadow 0.35s ease;
	cursor: pointer;
}

.dp-svc-card:hover {
	transform: translateY(-10px);
	box-shadow:
		0 8px 32px var(--card-glow),
		0 24px 56px rgba(26,46,26,0.12),
		0 2px 8px rgba(26,46,26,0.08);
}

/* Hover shine sweep */
.dp-svc-card__shine {
	position: absolute;
	inset: 0;
	background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.18) 50%, transparent 60%);
	transform: translateX(-100%);
	transition: transform 0.6s ease;
	pointer-events: none;
	border-radius: 18px;
}
.dp-svc-card:hover .dp-svc-card__shine {
	transform: translateX(100%);
}

/* ── Gradient Strip (top) ── */
.dp-svc-card__strip {
	position: relative;
	padding: 24px 20px 20px;
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	min-height: 110px;
	overflow: hidden;
}

/* Strip decorative circle */
.dp-svc-card__strip-deco {
	position: absolute;
	bottom: -30px;
	right: -30px;
	width: 100px;
	height: 100px;
	background: rgba(255,255,255,0.1);
	border-radius: 50%;
}
.dp-svc-card__strip-deco::before {
	content: '';
	position: absolute;
	bottom: 10px; right: 10px;
	width: 60px; height: 60px;
	background: rgba(255,255,255,0.08);
	border-radius: 50%;
}

/* Icon wrapper */
.dp-svc-card__icon-wrap {
	width: 56px;
	height: 56px;
	background: rgba(255,255,255,0.2);
	backdrop-filter: blur(4px);
	border: 1.5px solid rgba(255,255,255,0.35);
	border-radius: 14px;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-shrink: 0;
	transition: transform 0.3s ease, background 0.3s ease;
}
.dp-svc-card:hover .dp-svc-card__icon-wrap {
	transform: scale(1.1) rotate(-3deg);
	background: rgba(255,255,255,0.3);
}

.dp-svc-card__icon-wrap svg {
	width: 26px;
	height: 26px;
	stroke: #FFFFFF;
	color: #FFFFFF;
}

/* Duration badge (top-right of strip) */
.dp-svc-card__dur-badge {
	display: inline-flex;
	align-items: center;
	gap: 4px;
	padding: 5px 10px;
	border-radius: 20px;
	font-size: 0.7rem;
	font-weight: 600;
	color: rgba(255,255,255,0.92);
	letter-spacing: 0.02em;
	white-space: nowrap;
	margin-top: 4px;
}
.dp-svc-card__dur-badge svg {
	stroke: rgba(255,255,255,0.8);
}

/* ── Card Body ── */
.dp-svc-card__body {
	padding: 20px 20px 12px;
	flex: 1;
}

.dp-svc-card__title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.05rem;
	font-weight: 600;
	color: #1A2E1A;
	margin: 0 0 10px 0;
	line-height: 1.3;
}
.dp-svc-card__title a {
	color: inherit;
	text-decoration: none;
	transition: color 0.2s;
}
.dp-svc-card__title a:hover { color: var(--developer-starter-pro-primary); }

.dp-svc-card__desc {
	font-size: 0.83rem;
	color: #6B7C6B;
	line-height: 1.7;
	margin: 0;
}

/* ── Card Footer ── */
.dp-svc-card__footer {
	padding: 14px 20px 20px;
	border-top: 1px solid rgba(78,124,89,0.08);
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 12px;
	margin-top: auto;
}

/* Price */
.dp-svc-card__price {
	display: flex;
	align-items: center;
	gap: 6px;
}
.dp-price-label {
	font-family: 'Inter', 'Helvetica Neue', sans-serif;
	font-size: 0.68rem;
	font-weight: 600;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	color: #9AAA9A;
	line-height: 1;
}
.dp-price-amount {
	font-family: 'Inter', 'Helvetica Neue', sans-serif;
	font-size: 1.25rem;
	font-weight: 700;
	color: #C9A84C;
	letter-spacing: -0.02em;
	line-height: 1;
}

/* Learn More button */
.dp-svc-card__btn {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	padding: 9px 16px;
	background: linear-gradient(135deg, var(--developer-starter-pro-primary), var(--developer-starter-pro-primary-dark));
	color: #FFFFFF;
	border-radius: 24px;
	font-size: 0.78rem;
	font-weight: 600;
	text-decoration: none;
	letter-spacing: 0.02em;
	transition: gap 0.25s ease, box-shadow 0.25s ease, transform 0.2s ease;
	white-space: nowrap;
	flex-shrink: 0;
}
.dp-svc-card__btn:hover {
	gap: 10px;
	box-shadow: 0 6px 18px rgba(78,124,89,0.35);
	transform: translateX(2px);
}
.dp-svc-card__btn svg {
	transition: transform 0.25s ease;
}
.dp-svc-card__btn:hover svg {
	transform: translateX(3px);
}

/* ── Bottom CTA Row ── */
.dp-services__cta-row {
	text-align: center;
	margin-top: 52px;
}
.dp-services__view-all {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 14px 32px;
	border: 2px solid var(--developer-starter-pro-primary);
	color: var(--developer-starter-pro-primary);
	border-radius: 32px;
	font-size: 0.9rem;
	font-weight: 600;
	text-decoration: none;
	letter-spacing: 0.03em;
	transition: background 0.25s ease, color 0.25s ease, gap 0.25s ease, box-shadow 0.25s ease;
}
.dp-services__view-all:hover {
	background: var(--developer-starter-pro-primary);
	color: #FFFFFF;
	gap: 14px;
	box-shadow: 0 8px 24px rgba(78,124,89,0.25);
}
.dp-services__view-all svg {
	transition: transform 0.25s ease;
}
.dp-services__view-all:hover svg {
	transform: translateX(4px);
}

/* ── Responsive ── */
@media (max-width: 1100px) {
	.dp-services__grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 800px) {
	.dp-services { padding: 64px 0 72px; }
	.dp-services__grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
	.dp-services__header { margin-bottom: 40px; }
}
@media (max-width: 500px) {
	.dp-services__grid { grid-template-columns: 1fr; }
	.dp-services__container { padding: 0 18px; }
	.dp-svc-card__footer { flex-direction: column; align-items: flex-start; gap: 12px; }
	.dp-svc-card__btn { width: 100%; justify-content: center; }
}
</style>
