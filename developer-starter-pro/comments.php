<?php
/**
 * Comments Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="developer-starter-pro-comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="developer-starter-pro-comments-title">
			<?php
			$comment_count = get_comments_number();
			printf(
				/* translators: 1: comment count, 2: post title */
				esc_html( _nx( '%1$s Comment on &ldquo;%2$s&rdquo;', '%1$s Comments on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'developer-starter-pro' ) ),
				esc_html( number_format_i18n( $comment_count ) ),
				get_the_title()
			);
			?>
		</h2>

		<ol class="developer-starter-pro-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 60,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		if ( ! comments_open() ) :
			?>
			<p class="developer-starter-pro-no-comments"><?php esc_html_e( 'Comments are closed.', 'developer-starter-pro' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div>
