<?php
/**
 * Template Part: Homepage Latest Blog Section — Premium v2 (SEO Friendly)
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$blog_count    = (int) developer_starter_pro_get_option( 'blog_section_count', 3 );
$blog_eyebrow  = developer_starter_pro_get_option( 'blog_section_eyebrow', __( 'Dental Insights', 'developer-starter-pro' ) );
$blog_title    = developer_starter_pro_get_option( 'blog_section_title', __( 'Latest News & Articles', 'developer-starter-pro' ) );
$blog_subtitle = developer_starter_pro_get_option( 'blog_section_subtitle', __( 'Stay informed with standard dental health tips and advice from our clinical experts.', 'developer-starter-pro' ) );

$recent_posts = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => $blog_count,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
) );

if ( ! $recent_posts->have_posts() ) {
	return;
}
?>

<section class="dp-blog" id="blog" aria-labelledby="dp-blog-title">
	<div class="dp-blog__bg-deco" aria-hidden="true">
		<div class="dp-blog-deco-circle dp-blog-deco-circle--1"></div>
		<div class="dp-blog-deco-circle dp-blog-deco-circle--2"></div>
	</div>

	<div class="dp-blog__container">
		
		<!-- Section Header -->
		<header class="dp-blog__header">
			<span class="dp-blog__eyebrow">
				<svg viewBox="0 0 16 16" fill="currentColor" width="10" height="10" aria-hidden="true"><circle cx="8" cy="8" r="8"/></svg>
				<?php echo esc_html( $blog_eyebrow ); ?>
				<svg viewBox="0 0 16 16" fill="currentColor" width="10" height="10" aria-hidden="true"><circle cx="8" cy="8" r="8"/></svg>
			</span>
			<h2 class="dp-blog__title" id="dp-blog-title"><?php echo esc_html( $blog_title ); ?></h2>
			<div class="dp-blog__rule" aria-hidden="true">
				<span></span><span class="dp-rule-diamond"></span><span></span>
			</div>
			<?php if ( ! empty( $blog_subtitle ) ) : ?>
				<p class="dp-blog__subtitle"><?php echo esc_html( $blog_subtitle ); ?></p>
			<?php endif; ?>
		</header>

		<!-- Blog Posts Grid -->
		<div class="dp-blog__grid">
			<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
				<article class="dp-blog-card">
					
					<!-- Card Header / Image -->
					<header class="dp-blog-card__header">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="dp-blog-card__img-wrap">
								<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read article: %s', 'developer-starter-pro' ), get_the_title() ) ); ?>">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'dp-blog-card__img', 'alt' => get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?: get_the_title() ) ); ?>
								</a>
							</div>
						<?php else : ?>
							<div class="dp-blog-card__img-wrap dp-blog-card__img-wrap--placeholder">
								<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read article: %s', 'developer-starter-pro' ), get_the_title() ) ); ?>">
									<div class="dp-blog-card__placeholder-icon" aria-hidden="true">📰</div>
								</a>
							</div>
						<?php endif; ?>
					</header>
					
					<!-- Card Content -->
					<div class="dp-blog-card__body">
						<!-- Meta Row -->
						<div class="dp-blog-card__meta">
							<time class="dp-blog-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
								<?php echo esc_html( get_the_date() ); ?>
							</time>
							<span class="dp-blog-card__author">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
								<?php echo esc_html( get_the_author() ); ?>
							</span>
						</div>

						<h3 class="dp-blog-card__post-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						
						<p class="dp-blog-card__excerpt">
							<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '...' ) ); ?>
						</p>
					</div>
					
					<!-- Card Footer -->
					<footer class="dp-blog-card__footer">
						<a href="<?php the_permalink(); ?>" class="dp-blog-card__read-more" aria-label="<?php echo esc_attr( sprintf( __( 'Read full article: %s', 'developer-starter-pro' ), get_the_title() ) ); ?>">
							<span><?php esc_html_e( 'Read Article', 'developer-starter-pro' ); ?></span>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</footer>
					
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<!-- View All CTA -->
		<div class="dp-blog__cta-row">
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="dp-blog__view-all">
				<?php esc_html_e( 'View All Articles', 'developer-starter-pro' ); ?>
				<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" aria-hidden="true"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
			</a>
		</div>

	</div>
</section>

<style>
/* =====================================================
   HOMEPAGE BLOG SECTION — Premium v2
   ===================================================== */

.dp-blog {
	position: relative;
	background: linear-gradient(175deg, #EEF4F0 0%, #FAFCFA 45%, #F4F8F5 100%);
	padding: 96px 0 100px;
	overflow: hidden;
	border-top: 1px solid rgba(78, 124, 89, 0.08);
}

.dp-blog__bg-deco { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.dp-blog-deco-circle {
	position: absolute;
	border-radius: 50%;
	opacity: 0.25;
}
.dp-blog-deco-circle--1 {
	width: 400px; height: 400px;
	background: radial-gradient(circle, rgba(78,124,89,0.1) 0%, transparent 70%);
	bottom: -100px; left: -100px;
}
.dp-blog-deco-circle--2 {
	width: 320px; height: 320px;
	background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
	top: -50px; right: -50px;
}

.dp-blog__container {
	position: relative;
	max-width: 1160px;
	margin: 0 auto;
	padding: 0 32px;
	z-index: 1;
}

/* ── Header ── */
.dp-blog__header {
	text-align: center;
	margin-bottom: 60px;
}

.dp-blog__eyebrow {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	font-size: 0.68rem;
	font-weight: 700;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: #4E7C59;
	margin-bottom: 16px;
}

.dp-blog__title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: clamp(2rem, 3.5vw, 2.8rem);
	font-weight: 700;
	color: #1A2E1A;
	margin: 0 0 16px 0;
	letter-spacing: -0.5px;
	line-height: 1.15;
}

.dp-blog__rule {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	margin-bottom: 20px;
}
.dp-blog__rule span {
	display: block;
	height: 2px;
	width: 48px;
	background: linear-gradient(90deg, transparent, #C9A84C);
	border-radius: 2px;
}
.dp-blog__rule span:last-child {
	background: linear-gradient(90deg, #C9A84C, transparent);
}

.dp-blog__subtitle {
	font-size: 1rem;
	color: #5A6E5A;
	line-height: 1.75;
	max-width: 580px;
	margin: 0 auto;
}

/* ── Grid ── */
.dp-blog__grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 30px;
}

/* ── Card ── */
.dp-blog-card {
	background: #FFFFFF;
	border-radius: 18px;
	border: 1px solid rgba(78, 124, 89, 0.08);
	overflow: hidden;
	display: flex;
	flex-direction: column;
	box-shadow:
		0 1px 3px rgba(26,46,26,0.04),
		0 4px 16px rgba(26,46,26,0.05);
	transition: transform 0.35s cubic-bezier(0.34, 1.5, 0.64, 1), box-shadow 0.35s ease, border-color 0.35s ease;
}

.dp-blog-card:hover {
	transform: translateY(-8px);
	border-color: rgba(78, 124, 89, 0.2);
	box-shadow:
		0 12px 32px rgba(78,124,89,0.12),
		0 4px 12px rgba(26,46,26,0.06);
}

/* ── Image Header ── */
.dp-blog-card__header {
	position: relative;
	overflow: hidden;
}

.dp-blog-card__img-wrap {
	aspect-ratio: 16/10;
	overflow: hidden;
	background: #EEF4F0;
}
.dp-blog-card__img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	transition: transform 0.5s ease;
}
.dp-blog-card:hover .dp-blog-card__img {
	transform: scale(1.06);
}

/* Placeholder image */
.dp-blog-card__img-wrap--placeholder {
	display: flex;
	align-items: center;
	justify-content: center;
	background: linear-gradient(135deg, #EEF4F0, #E2ECE5);
}
.dp-blog-card__placeholder-icon {
	font-size: 3rem;
	opacity: 0.6;
}

/* ── Body ── */
.dp-blog-card__body {
	padding: 24px;
	flex: 1;
	display: flex;
	flex-direction: column;
}

.dp-blog-card__meta {
	display: flex;
	align-items: center;
	gap: 16px;
	font-size: 0.76rem;
	color: #7D8E7D;
	margin-bottom: 12px;
}
.dp-blog-card__date,
.dp-blog-card__author {
	display: inline-flex;
	align-items: center;
	gap: 6px;
}
.dp-blog-card__meta svg {
	opacity: 0.75;
}

.dp-blog-card__post-title {
	font-family: 'Playfair Display', Georgia, serif;
	font-size: 1.15rem;
	font-weight: 600;
	color: #1A2E1A;
	margin: 0 0 10px 0;
	line-height: 1.35;
}
.dp-blog-card__post-title a {
	color: inherit;
	text-decoration: none;
	transition: color 0.2s;
}
.dp-blog-card__post-title a:hover {
	color: var(--developer-starter-pro-primary);
}

.dp-blog-card__excerpt {
	font-size: 0.86rem;
	color: #6B7C6B;
	line-height: 1.65;
	margin: 0;
}

/* ── Footer ── */
.dp-blog-card__footer {
	padding: 0 24px 24px;
	background: transparent;
	margin-top: auto;
}

.dp-blog-card__read-more {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	color: var(--developer-starter-pro-primary);
	font-weight: 700;
	font-size: 0.82rem;
	text-decoration: none;
	letter-spacing: 0.01em;
	transition: gap 0.25s ease, color 0.25s ease;
}
.dp-blog-card__read-more:hover {
	color: #C9A84C;
	gap: 10px;
}
.dp-blog-card__read-more svg {
	transition: transform 0.25s ease;
}
.dp-blog-card__read-more:hover svg {
	transform: translateX(2px);
}

/* ── CTA Bottom Row ── */
.dp-blog__cta-row {
	text-align: center;
	margin-top: 52px;
}
.dp-blog__view-all {
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
.dp-blog__view-all:hover {
	background: var(--developer-starter-pro-primary);
	color: #FFFFFF;
	gap: 14px;
	box-shadow: 0 8px 24px rgba(78,124,89,0.2);
}
.dp-blog__view-all svg {
	transition: transform 0.25s ease;
}
.dp-blog__view-all:hover svg {
	transform: translateX(4px);
}

/* ── Responsive ── */
@media (max-width: 1000px) {
	.dp-blog__grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
}
@media (max-width: 800px) {
	.dp-blog { padding: 64px 0 72px; }
	.dp-blog__header { margin-bottom: 40px; }
}
@media (max-width: 600px) {
	.dp-blog__grid { grid-template-columns: 1fr; }
	.dp-blog__container { padding: 0 20px; }
	.dp-blog-card__body { padding: 20px; }
	.dp-blog-card__footer { padding: 0 20px 20px; }
}
</style>
