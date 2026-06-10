<?php
/**
 * Search Results Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">
	<div class="developer-starter-pro-container">

		<header class="developer-starter-pro-archive-header">
			<h1 class="developer-starter-pro-archive-title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search Results for: %s', 'developer-starter-pro' ),
					'<span>' . get_search_query() . '</span>'
				);
				?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="developer-starter-pro-posts-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', 'archive' );
				endwhile;
				?>
			</div>
			<div class="developer-starter-pro-pagination">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<div class="developer-starter-pro-no-results">
				<h2><?php esc_html_e( 'Nothing Found', 'developer-starter-pro' ); ?></h2>
				<p><?php esc_html_e( 'Sorry, no results matched your search. Please try different keywords.', 'developer-starter-pro' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
