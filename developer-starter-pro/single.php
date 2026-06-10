<?php
/**
 * Single Post Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">
	<div class="developer-starter-pro-container">
		<div class="developer-starter-pro-content-area">

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', 'single' );

				// Post navigation.
				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'developer-starter-pro' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'developer-starter-pro' ) . '</span> <span class="nav-title">%title</span>',
					)
				);

				// Comments.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
			?>

		</div>
	</div>
</main>

<?php
get_sidebar();
get_footer();
