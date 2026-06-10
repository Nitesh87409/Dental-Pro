<?php
/**
 * Template Part: No Content Found
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<section class="developer-starter-pro-no-results">
	<header class="developer-starter-pro-page-header">
		<h1 class="developer-starter-pro-page-title"><?php esc_html_e( 'Nothing Found', 'developer-starter-pro' ); ?></h1>
	</header>

	<div class="developer-starter-pro-page-content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'developer-starter-pro' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'developer-starter-pro' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
