<?php
/**
 * Template Name: Blog Catalog
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

// Fetch latest sticky/featured post
$featured_query = new WP_Query( array(
	'posts_per_page'      => 1,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => false,
) );

// Pagination setup
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$blog_query = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 6,
	'paged'          => $paged,
	'post_status'    => 'publish',
) );
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Dental Health Resources', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Educational guides, clinical news updates, and expert tips for oral wellness.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">

			<!-- Featured Post (Only on Page 1) -->
			<?php if ( 1 === $paged && $featured_query->have_posts() ) : $featured_query->the_post(); ?>
				<div class="featured-blog-post" style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px; margin-bottom: 60px; background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); overflow: hidden; box-shadow: var(--developer-starter-pro-shadow-sm);">
					<?php if ( has_post_thumbnail() ) : ?>
						<div style="height: 100%; min-height: 300px; overflow: hidden;">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'developer-starter-pro-blog-large', array( 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
							</a>
						</div>
					<?php endif; ?>
					
					<div style="padding: 48px 40px; display: flex; flex-direction: column; justify-content: center;">
						<span style="font-size: 0.8125rem; font-weight: 700; color: var(--developer-starter-pro-primary); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.05em;"><?php esc_html_e( 'Featured Article', 'developer-starter-pro' ); ?></span>
						<h2 style="font-size: 1.75rem; line-height: 1.3; margin: 0 0 16px 0;">
							<a href="<?php the_permalink(); ?>" style="color: var(--developer-starter-pro-secondary); text-decoration: none;">
								<?php the_title(); ?>
							</a>
						</h2>
						
						<p style="color: var(--developer-starter-pro-gray-500); font-size: 0.9375rem; line-height: 1.6; margin: 0 0 24px 0;">
							<?php echo wp_trim_words( get_the_excerpt(), 28, '...' ); ?>
						</p>
						
						<div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--developer-starter-pro-gray-200); padding-top: 20px;">
							<span style="font-size: 0.8125rem; color: var(--developer-starter-pro-gray-400);">📅 <?php echo get_the_date(); ?></span>
							<a href="<?php the_permalink(); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--primary">
								<?php esc_html_e( 'Read Article', 'developer-starter-pro' ); ?>
							</a>
						</div>
					</div>
				</div>
			<?php wp_reset_postdata(); endif; ?>

			<!-- Regular Blog Grid -->
			<div class="blog-catalog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
				<?php if ( $blog_query->have_posts() ) : ?>
					<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
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
									<div style="font-size: 0.8125rem; color: var(--developer-starter-pro-gray-400); margin-bottom: 12px; display: flex; gap: 12px;">
										<span>📅 <?php echo get_the_date(); ?></span>
										<span>👤 <?php the_author(); ?></span>
									</div>
									
									<h3 style="font-size: 1.1875rem; line-height: 1.4; margin: 0 0 12px 0;">
										<a href="<?php the_permalink(); ?>" style="color: var(--developer-starter-pro-secondary); text-decoration: none; transition: color 0.2s ease;">
											<?php the_title(); ?>
										</a>
									</h3>
									
									<div style="font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6; margin-bottom: 20px;">
										<?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
									</div>
								</div>
							</div>
							
							<div style="padding: 0 24px 24px;">
								<a href="<?php the_permalink(); ?>" class="developer-starter-pro-read-more" style="font-weight: 700; text-decoration: none; color: var(--developer-starter-pro-primary); display: inline-flex; align-items: center; gap: 6px; font-size: 0.875rem;">
									<?php esc_html_e( 'Read Article', 'developer-starter-pro' ); ?>
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
								</a>
							</div>
							
						</article>
					<?php endwhile; ?>
				<?php else : ?>
					<p style="grid-column: 1/-1; text-align: center; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'No articles posted yet.', 'developer-starter-pro' ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Pagination Navigation -->
			<?php if ( $blog_query->max_num_pages > 1 ) : ?>
				<div class="blog-pagination" style="margin-top: 50px; display: flex; justify-content: center; gap: 8px;">
					<?php
					echo paginate_links( array(
						'current'   => $paged,
						'total'     => $blog_query->max_num_pages,
						'prev_text' => '&laquo; Prev',
						'next_text' => 'Next &raquo;',
						'type'      => 'plain',
					) );
					?>
				</div>
			<?php endif; wp_reset_postdata(); ?>

		</div>
	</section>

</main>

<style>
.blog-pagination a, .blog-pagination span {
	padding: 10px 18px;
	border: 2px solid var(--developer-starter-pro-gray-200);
	border-radius: var(--developer-starter-pro-radius-md);
	font-weight: 600;
	color: var(--developer-starter-pro-gray-600);
	text-decoration: none;
	transition: all 0.2s ease;
}
.blog-pagination a:hover, .blog-pagination .current {
	background: var(--developer-starter-pro-primary);
	border-color: var(--developer-starter-pro-primary);
	color: #fff;
}
body.dark-mode .featured-blog-post,
body.dark-mode .blog-card {
	background: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode .featured-blog-post h2 a,
body.dark-mode .blog-card h3 a {
	color: #F8FAFC !important;
}
body.dark-mode .blog-pagination a,
body.dark-mode .blog-pagination span {
	border-color: #334155;
	color: #CBD5E1;
}
body.dark-mode .blog-pagination .current {
	background: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
}
@media (max-width: 768px) {
	.featured-blog-post {
		grid-template-columns: 1fr;
	}
	.featured-blog-post div[style*="padding"] {
		padding: 30px !important;
	}
}
</style>

<?php
get_footer();
