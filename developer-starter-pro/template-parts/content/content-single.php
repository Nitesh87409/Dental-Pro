<?php
/**
 * Template Part: Single Post Content
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'developer-starter-pro-single-post' ); ?>>

	<header class="developer-starter-pro-post-header">
		<div class="developer-starter-pro-post-meta">
			<span class="developer-starter-pro-post-date">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
				<?php echo get_the_date(); ?>
			</span>
			<span class="developer-starter-pro-post-author">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
				<?php the_author(); ?>
			</span>
			<?php if ( has_category() ) : ?>
				<span class="developer-starter-pro-post-category">
					<?php the_category( ', ' ); ?>
				</span>
			<?php endif; ?>
		</div>

		<?php the_title( '<h1 class="developer-starter-pro-post-title">', '</h1>' ); ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="developer-starter-pro-post-thumbnail">
			<?php the_post_thumbnail( 'developer-starter-pro-blog-large' ); ?>
		</div>
	<?php endif; ?>

	<div class="developer-starter-pro-post-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'developer-starter-pro' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="developer-starter-pro-post-footer">
		<?php 
		// Social Share buttons
		if ( function_exists( 'developer_starter_pro_social_share' ) ) {
			developer_starter_pro_social_share();
		}
		?>

		<?php if ( has_tag() ) : ?>
			<div class="developer-starter-pro-post-tags">
				<?php the_tags( '<span class="tags-label">' . esc_html__( 'Tags:', 'developer-starter-pro' ) . '</span> ', ', ' ); ?>
			</div>
		<?php endif; ?>
	</footer>

</article>
