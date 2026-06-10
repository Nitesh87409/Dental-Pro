<?php
/**
 * Template Part: Homepage Latest Blog Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$recent_posts = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'ignore_sticky_posts' => true,
) );

if ( ! $recent_posts->have_posts() ) {
	return;
}
?>

<section class="developer-starter-pro-section latest-blog-section" id="blog" style="background: var(--developer-starter-pro-gray-50); border-top: 1px solid var(--developer-starter-pro-gray-200);">
	<div class="developer-starter-pro-container">
		
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Dental Insights', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Latest News & Articles', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Stay informed with standard dental health tips and advice from our clinical experts.', 'developer-starter-pro' ); ?></p>
		</div>

		<div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px;">
			
			<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
				<article class="blog-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); overflow: hidden; box-shadow: var(--developer-starter-pro-shadow-sm); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">
					
					<div>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="blog-card-image" style="aspect-ratio: 16/10; overflow: hidden;">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'developer-starter-pro-blog-thumb', array( 'style' => 'width:100%; height:100%; object-fit:cover; transition:transform 0.4s ease;' ) ); ?>
								</a>
							</div>
						<?php endif; ?>
						
						<div class="blog-card-content" style="padding: 24px;">
							<div class="blog-card-meta" style="font-size: 0.8125rem; color: var(--developer-starter-pro-gray-400); margin-bottom: 12px; display: flex; gap: 12px;">
								<span>📅 <?php echo get_the_date(); ?></span>
								<span>👤 <?php the_author(); ?></span>
							</div>
							
							<h3 class="blog-card-title" style="font-size: 1.1875rem; line-height: 1.4; margin: 0 0 12px 0;">
								<a href="<?php the_permalink(); ?>" style="color: var(--developer-starter-pro-secondary); text-decoration: none; transition: color 0.2s ease;">
									<?php the_title(); ?>
								</a>
							</h3>
							
							<div class="blog-card-excerpt" style="font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6; margin-bottom: 20px;">
								<?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
							</div>
						</div>
					</div>
					
					<div class="blog-card-footer" style="padding: 0 24px 24px; background: none;">
						<a href="<?php the_permalink(); ?>" class="developer-starter-pro-read-more" style="font-weight: 700; text-decoration: none; color: var(--developer-starter-pro-primary); display: inline-flex; align-items: center; gap: 6px; font-size: 0.875rem;">
							<?php esc_html_e( 'Read Article', 'developer-starter-pro' ); ?>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</div>
					
				</article>
			<?php endwhile; wp_reset_postdata(); ?>

		</div>

		<div class="developer-starter-pro-section-cta" style="margin-top: 40px; text-align: center;">
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
				<?php esc_html_e( 'View All Articles', 'developer-starter-pro' ); ?>
			</a>
		</div>

	</div>
</section>

<style>
.blog-card:hover {
	transform: translateY(-5px);
	box-shadow: var(--developer-starter-pro-shadow-lg) !important;
	border-color: var(--developer-starter-pro-primary) !important;
}
.blog-card:hover .blog-card-image img {
	transform: scale(1.05);
}
.blog-card-title a:hover {
	color: var(--developer-starter-pro-primary) !important;
}
</style>
