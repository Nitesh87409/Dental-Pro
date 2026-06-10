<?php
/**
 * Archive Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">
	<div class="developer-starter-pro-container">

		<header class="developer-starter-pro-archive-header">
			<?php
			the_archive_title( '<h1 class="developer-starter-pro-archive-title">', '</h1>' );
			the_archive_description( '<div class="developer-starter-pro-archive-description">', '</div>' );
			?>
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
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => '&laquo;',
						'next_text' => '&raquo;',
					)
				);
				?>
			</div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
		<?php endif; ?>

	</div>
</main>

<?php
get_sidebar();
get_footer();
