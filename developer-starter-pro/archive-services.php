<?php
/**
 * Archive Services Template — Premium Redesign
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

// Color palette cycling for cards
$card_colors = array(
	array( 'strip' => 'linear-gradient(135deg,#2E6B42,#4E9E6A)', 'glow' => 'rgba(46,107,66,0.18)',  'badge' => '#1E5A32' ),
	array( 'strip' => 'linear-gradient(135deg,#1B6B6B,#2DA89A)', 'glow' => 'rgba(27,107,107,0.18)', 'badge' => '#145050' ),
	array( 'strip' => 'linear-gradient(135deg,#2A527A,#4180C0)', 'glow' => 'rgba(42,82,122,0.18)',   'badge' => '#1A3A5C' ),
	array( 'strip' => 'linear-gradient(135deg,#7A2A2A,#C04141)', 'glow' => 'rgba(122,42,42,0.18)',  'badge' => '#5C1A1A' ),
	array( 'strip' => 'linear-gradient(135deg,#5A3A7A,#8F5EC0)', 'glow' => 'rgba(90,58,122,0.18)', 'badge' => '#3E2058' ),
	array( 'strip' => 'linear-gradient(135deg,#3A6B2E,#6EAA50)', 'glow' => 'rgba(58,107,46,0.18)', 'badge' => '#284E1E' ),
	array( 'strip' => 'linear-gradient(135deg,#6B5A1B,#C09A2A)', 'glow' => 'rgba(107,90,27,0.18)', 'badge' => '#4E3E0E' ),
	array( 'strip' => 'linear-gradient(135deg,#1B4A6B,#2A80B8)', 'glow' => 'rgba(27,74,107,0.18)', 'badge' => '#0E3050' ),
);
?>

<style>
/* =====================================================
   SERVICES ARCHIVE — Premium Design
   ===================================================== */

/* ── Page Banner ── */
.arc-banner {
	padding: 80px 0 76px;
	position: relative;
	overflow: hidden;
	background-size: cover !important;
	background-position: center center !important;
	background-repeat: no-repeat !important;
}
/* Dark transparent overlay */
.arc-banner::before {
	content: '';
	position: absolute;
	inset: 0;
	background: linear-gradient(
		135deg,
		rgba(15, 30, 15, 0.72) 0%,
		rgba(26, 46, 26, 0.65) 50%,
		rgba(20, 40, 20, 0.70) 100%
	);
	pointer-events: none;
	z-index: 1;
}
/* Subtle green glow on top of image */
.arc-banner::after {
	content: '';
	position: absolute;
	inset: 0;
	background:
		radial-gradient(ellipse at 15% 60%, rgba(78,124,89,0.25) 0%, transparent 50%),
		radial-gradient(ellipse at 85% 30%, rgba(201,168,76,0.12) 0%, transparent 45%);
	pointer-events: none;
	z-index: 1;
}
.arc-banner__inner {
	position: relative;
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 32px;
	text-align: center;
	z-index: 2;
}
.arc-banner__eyebrow {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	font-size: 0.68rem;
	font-weight: 700;
	letter-spacing: 0.22em;
	text-transform: uppercase;
	color: #C9A84C;
	margin-bottom: 16px;
}
.arc-banner__title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: clamp(2rem, 4vw, 3rem);
	font-weight: 700;
	color: #FFFFFF;
	margin: 0 0 16px 0;
	letter-spacing: -0.5px;
	line-height: 1.15;
}
.arc-banner__subtitle {
	font-size: 1rem;
	color: rgba(255,255,255,0.7);
	line-height: 1.75;
	max-width: 500px;
	margin: 0 auto;
}

/* ── Page Body ── */
.arc-body {
	background: linear-gradient(175deg, #F6F9F7 0%, #FAFCFA 55%, #EEF4F0 100%);
	padding: 64px 0 96px;
	position: relative;
	overflow: hidden;
}
.arc-body::before {
	content: '';
	position: absolute;
	top: -80px; left: -80px;
	width: 400px; height: 400px;
	background: radial-gradient(circle, rgba(78,124,89,0.07) 0%, transparent 70%);
	pointer-events: none;
}
.arc-body::after {
	content: '';
	position: absolute;
	bottom: -60px; right: -60px;
	width: 320px; height: 320px;
	background: radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 70%);
	pointer-events: none;
}
.arc-container {
	position: relative;
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 32px;
	z-index: 1;
}

/* ── Filter Bar ── */
.arc-filter-bar {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	justify-content: center;
	gap: 10px;
	margin-bottom: 52px;
}
.arc-filter-btn {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	padding: 10px 22px;
	border: 1.5px solid rgba(78,124,89,0.25);
	background: #FFFFFF;
	color: #4A6A4A;
	border-radius: 30px;
	font-size: 0.82rem;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.25s ease;
	letter-spacing: 0.02em;
	box-shadow: 0 2px 8px rgba(26,46,26,0.06);
}
.arc-filter-btn:hover {
	border-color: #4E7C59;
	background: rgba(78,124,89,0.06);
	color: #2E5A38;
	transform: translateY(-1px);
	box-shadow: 0 4px 14px rgba(78,124,89,0.15);
}
.arc-filter-btn.active {
	background: linear-gradient(135deg, #4E7C59, #3A6045);
	border-color: transparent;
	color: #FFFFFF;
	box-shadow: 0 4px 16px rgba(78,124,89,0.35);
}

/* ── Grid ── */
.arc-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 24px;
}

/* ── Service Card ── */
.arc-card {
	position: relative;
	background: #FFFFFF;
	border-radius: 18px;
	overflow: hidden;
	display: flex;
	flex-direction: column;
	box-shadow: 0 2px 12px rgba(26,46,26,0.07), 0 1px 3px rgba(26,46,26,0.05);
	transition: transform 0.35s cubic-bezier(0.34, 1.5, 0.64, 1), box-shadow 0.35s ease;
}
.arc-card:hover {
	transform: translateY(-10px);
	box-shadow:
		0 8px 32px var(--card-glow, rgba(78,124,89,0.18)),
		0 24px 56px rgba(26,46,26,0.12),
		0 2px 8px rgba(26,46,26,0.07);
}

/* Shine sweep on hover */
.arc-card::after {
	content: '';
	position: absolute;
	inset: 0;
	background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.16) 50%, transparent 60%);
	transform: translateX(-100%);
	transition: transform 0.6s ease;
	pointer-events: none;
	border-radius: 18px;
}
.arc-card:hover::after { transform: translateX(100%); }

/* ── Gradient Strip ── */
.arc-card__strip {
	position: relative;
	padding: 22px 18px 18px;
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	min-height: 100px;
	overflow: hidden;
}
.arc-card__strip::before {
	content: '';
	position: absolute;
	bottom: -28px; right: -28px;
	width: 90px; height: 90px;
	background: rgba(255,255,255,0.1);
	border-radius: 50%;
}
.arc-card__strip::after {
	content: '';
	position: absolute;
	bottom: 4px; right: 4px;
	width: 54px; height: 54px;
	background: rgba(255,255,255,0.07);
	border-radius: 50%;
}

/* Thumbnail if exists — overlay on strip */
.arc-card__thumb {
	position: absolute;
	inset: 0;
	z-index: 0;
}
.arc-card__thumb img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	opacity: 0.25;
	mix-blend-mode: luminosity;
}
.arc-card__thumb-overlay {
	position: absolute;
	inset: 0;
	background: inherit; /* inherits strip gradient */
	opacity: 0.8;
}

/* Icon */
.arc-card__icon-wrap {
	position: relative;
	z-index: 1;
	width: 54px;
	height: 54px;
	background: rgba(255,255,255,0.22);
	backdrop-filter: blur(4px);
	border: 1.5px solid rgba(255,255,255,0.35);
	border-radius: 13px;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-shrink: 0;
	transition: transform 0.3s ease, background 0.3s ease;
}
.arc-card:hover .arc-card__icon-wrap {
	transform: scale(1.1) rotate(-3deg);
	background: rgba(255,255,255,0.32);
}
.arc-card__icon-wrap svg {
	width: 24px; height: 24px;
	stroke: #FFFFFF; color: #FFFFFF;
}

/* Duration badge */
.arc-card__dur {
	position: relative;
	z-index: 1;
	display: inline-flex;
	align-items: center;
	gap: 4px;
	padding: 5px 10px;
	border-radius: 20px;
	font-size: 0.69rem;
	font-weight: 600;
	color: rgba(255,255,255,0.92);
	letter-spacing: 0.02em;
	white-space: nowrap;
	margin-top: 3px;
}
.arc-card__dur svg { stroke: rgba(255,255,255,0.8); }

/* ── Card Body ── */
.arc-card__body {
	padding: 18px 18px 10px;
	flex: 1;
}
.arc-card__title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.05rem;
	font-weight: 600;
	color: #1A2E1A;
	margin: 0 0 9px 0;
	line-height: 1.3;
}
.arc-card__title a { color: inherit; text-decoration: none; transition: color 0.2s; }
.arc-card__title a:hover { color: #4E7C59; }
.arc-card__desc {
	font-size: 0.82rem;
	color: #6B7C6B;
	line-height: 1.7;
	margin: 0;
}

/* ── Card Footer ── */
.arc-card__footer {
	padding: 13px 18px 18px;
	border-top: 1px solid rgba(78,124,89,0.09);
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 10px;
	margin-top: auto;
}
.arc-card__price-block { display: flex; flex-direction: column; line-height: 1; }
.arc-price-label {
	font-size: 0.6rem;
	font-weight: 700;
	letter-spacing: 0.12em;
	text-transform: uppercase;
	color: #9AAA9A;
	margin-bottom: 3px;
}
.arc-price-amount {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.45rem;
	font-weight: 700;
	color: #C9A84C;
	letter-spacing: -0.5px;
	line-height: 1;
}
.arc-card__btn {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	padding: 9px 16px;
	background: linear-gradient(135deg, #4E7C59, #3A6045);
	color: #FFFFFF;
	border-radius: 24px;
	font-size: 0.77rem;
	font-weight: 600;
	text-decoration: none;
	letter-spacing: 0.02em;
	transition: gap 0.25s ease, box-shadow 0.25s ease, transform 0.2s ease;
	white-space: nowrap;
	flex-shrink: 0;
}
.arc-card__btn:hover {
	gap: 10px;
	box-shadow: 0 6px 18px rgba(78,124,89,0.35);
	transform: translateX(2px);
}
.arc-card__btn svg { transition: transform 0.25s ease; }
.arc-card__btn:hover svg { transform: translateX(3px); }

/* ── Fallback tooth icon SVG (inline default) ── */
.arc-tooth-icon { display: contents; }

/* ── Pagination ── */
.arc-pagination { text-align: center; margin-top: 56px; }
.arc-pagination .page-numbers {
	display: inline-flex; align-items: center; justify-content: center;
	width: 40px; height: 40px;
	border: 1.5px solid rgba(78,124,89,0.2);
	border-radius: 50%;
	color: #4E7C59;
	font-size: 0.875rem;
	font-weight: 600;
	text-decoration: none;
	margin: 0 4px;
	transition: all 0.2s ease;
}
.arc-pagination .page-numbers.current,
.arc-pagination .page-numbers:hover {
	background: linear-gradient(135deg, #4E7C59, #3A6045);
	border-color: transparent;
	color: #FFFFFF;
	box-shadow: 0 4px 14px rgba(78,124,89,0.3);
}

/* ── Responsive ── */
@media (max-width: 1100px) { .arc-grid { grid-template-columns: repeat(3,1fr); } }
@media (max-width: 800px) {
	.arc-body { padding: 48px 0 72px; }
	.arc-grid { grid-template-columns: repeat(2,1fr); gap: 16px; }
}
@media (max-width: 500px) {
	.arc-grid { grid-template-columns: 1fr; }
	.arc-container { padding: 0 16px; }
	.arc-card__footer { flex-direction: column; align-items: flex-start; gap: 12px; }
	.arc-card__btn { width: 100%; justify-content: center; }
	.arc-banner__inner { padding: 0 20px; }
}
</style>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- ── Premium Page Banner with Background Image ── -->
	<?php $arc_banner_img = function_exists( 'developer_starter_pro_get_banner_bg_url' ) ? developer_starter_pro_get_banner_bg_url() : get_template_directory_uri() . '/assets/images/main-banner.jpeg'; ?>
	<div class="arc-banner" style="background-image: url('<?php echo esc_url( $arc_banner_img ); ?>');">
		<div class="arc-banner__inner">
			<span class="arc-banner__eyebrow">
				<svg viewBox="0 0 16 16" fill="currentColor" width="8" height="8"><circle cx="8" cy="8" r="8"/></svg>
				<?php esc_html_e( 'Expert Dental Care', 'developer-starter-pro' ); ?>
				<svg viewBox="0 0 16 16" fill="currentColor" width="8" height="8"><circle cx="8" cy="8" r="8"/></svg>
			</span>
			<h1 class="arc-banner__title"><?php esc_html_e( 'Dental Services & Treatments', 'developer-starter-pro' ); ?></h1>
			<p class="arc-banner__subtitle"><?php esc_html_e( 'Comprehensive dental care for every need — from preventive check-ups to complete smile makeovers.', 'developer-starter-pro' ); ?></p>
		</div>
	</div>

	<!-- ── Cards Section ── -->
	<div class="arc-body">
		<div class="arc-container">

			<?php if ( have_posts() ) : ?>

				<?php
				// Filter buttons (treatment type taxonomy)
				$treatment_types = get_terms( array(
					'taxonomy'   => 'treatment_type',
					'hide_empty' => true,
				) );
				if ( ! empty( $treatment_types ) && ! is_wp_error( $treatment_types ) ) :
				?>
				<div class="arc-filter-bar" role="group" aria-label="<?php esc_attr_e( 'Filter services', 'developer-starter-pro' ); ?>">
					<button class="arc-filter-btn active" data-filter="all">
						<svg viewBox="0 0 16 16" fill="currentColor" width="10" height="10"><circle cx="8" cy="8" r="8"/></svg>
						<?php esc_html_e( 'All Services', 'developer-starter-pro' ); ?>
					</button>
					<?php foreach ( $treatment_types as $type ) : ?>
						<button class="arc-filter-btn" data-filter="<?php echo esc_attr( $type->slug ); ?>">
							<?php echo esc_html( $type->name ); ?>
						</button>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<!-- Cards Grid -->
				<div class="arc-grid">
					<?php
					$card_idx = 0;
					while ( have_posts() ) :
						the_post();
						$price      = get_post_meta( get_the_ID(), '_developer_starter_pro_service_price', true );
						$duration   = get_post_meta( get_the_ID(), '_developer_starter_pro_service_duration', true );
						$short_desc = get_post_meta( get_the_ID(), '_developer_starter_pro_service_short_description', true );
						$icon_key   = get_post_meta( get_the_ID(), '_developer_starter_pro_service_icon', true );
						$custom_svg = get_post_meta( get_the_ID(), '_developer_starter_pro_service_custom_svg', true );
						$type_terms = get_the_terms( get_the_ID(), 'treatment_type' );
						$type_slugs = is_array( $type_terms ) ? implode( ' ', wp_list_pluck( $type_terms, 'slug' ) ) : '';

						// Resolve icon
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

						$color       = $card_colors[ $card_idx % count( $card_colors ) ];
						$price_clean = function_exists( 'developer_starter_pro_get_clean_service_price' ) ? developer_starter_pro_get_clean_service_price( $price ) : floatval( $price );
						$dur_clean   = function_exists( 'developer_starter_pro_get_clean_service_duration' ) ? developer_starter_pro_get_clean_service_duration( $duration ) : $duration;
						$has_price   = $price_clean > 0;
						$has_dur     = ! empty( $dur_clean );
					?>
					<article class="arc-card"
						data-treatment="<?php echo esc_attr( $type_slugs ); ?>"
						style="--card-glow:<?php echo esc_attr( $color['glow'] ); ?>">

						<!-- Gradient Strip -->
						<div class="arc-card__strip" style="background:<?php echo esc_attr( $color['strip'] ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
							<div class="arc-card__thumb">
								<?php the_post_thumbnail( 'developer-starter-pro-service-thumb' ); ?>
							</div>
							<?php endif; ?>

							<div class="arc-card__icon-wrap">
								<?php echo $icon_html; // phpcs:ignore ?>
							</div>

							<?php if ( $has_dur ) : ?>
							<div class="arc-card__dur" style="background:<?php echo esc_attr( $color['badge'] ); ?>">
								<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><circle cx="8" cy="8" r="6"/><path d="M8 5v3l2 2"/></svg>
								<?php echo esc_html( $dur_clean ); ?>
							</div>
							<?php endif; ?>
						</div>

						<!-- Body -->
						<div class="arc-card__body">
							<h2 class="arc-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<?php if ( $short_desc ) : ?>
							<p class="arc-card__desc"><?php echo esc_html( $short_desc ); ?></p>
							<?php endif; ?>
						</div>

						<!-- Footer -->
						<div class="arc-card__footer">
							<?php if ( $has_price ) : ?>
							<div class="arc-card__price-block">
								<span class="arc-price-label"><?php esc_html_e( 'From', 'developer-starter-pro' ); ?></span>
								<span class="arc-price-amount">$<?php echo esc_html( number_format( $price_clean, 0 ) ); ?></span>
							</div>
							<?php endif; ?>
							<a href="<?php the_permalink(); ?>" class="arc-card__btn"
								aria-label="<?php echo esc_attr( sprintf( __( 'Learn more about %s', 'developer-starter-pro' ), get_the_title() ) ); ?>">
								<?php esc_html_e( 'Learn More', 'developer-starter-pro' ); ?>
								<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
							</a>
						</div>

					</article>
					<?php
					$card_idx++;
					endwhile;
					?>
				</div>

				<!-- Pagination -->
				<div class="arc-pagination">
					<?php the_posts_pagination( array(
						'mid_size'  => 2,
						'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'developer-starter-pro' ) . ' </span>',
					) ); ?>
				</div>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
			<?php endif; ?>

		</div>
	</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var filterBtns  = document.querySelectorAll('.arc-filter-btn');
	var cards       = document.querySelectorAll('.arc-card[data-treatment]');

	filterBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			filterBtns.forEach(function (b) { b.classList.remove('active'); });
			this.classList.add('active');

			var filter = this.getAttribute('data-filter');
			cards.forEach(function (card) {
				if (filter === 'all' || card.getAttribute('data-treatment').indexOf(filter) !== -1) {
					card.style.display = '';
					card.style.animation = 'none';
					requestAnimationFrame(function () {
						card.style.animation = 'arcFadeUp 0.4s ease-out';
					});
				} else {
					card.style.display = 'none';
				}
			});
		});
	});
});
</script>

<style>
@keyframes arcFadeUp {
	from { opacity: 0; transform: translateY(16px); }
	to   { opacity: 1; transform: translateY(0); }
}
</style>

<?php get_footer(); ?>
