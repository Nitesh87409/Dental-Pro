<?php
/**
 * Template Part: Archive Post Card
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'developer-starter-pro-post-card' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="developer-starter-pro-post-card-image">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'developer-starter-pro-blog-thumb' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="developer-starter-pro-post-card-content">
		<div class="developer-starter-pro-post-card-meta">
			<span class="developer-starter-pro-post-date"><?php echo get_the_date(); ?></span>
			<?php if ( has_category() ) : ?>
				<span class="developer-starter-pro-post-category"><?php the_category( ', ' ); ?></span>
			<?php endif; ?>
		</div>

		<?php the_title( '<h2 class="developer-starter-pro-post-card-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

		<div class="developer-starter-pro-post-card-excerpt">
			<?php the_excerpt(); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="developer-starter-pro-read-more">
			<?php esc_html_e( 'Read More', 'developer-starter-pro' ); ?>
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
		</a>
	</div>

</article>
