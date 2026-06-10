<?php
/**
 * 404 Error Page Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">
	<div class="developer-starter-pro-container">
		<section class="developer-starter-pro-404">
			<div class="developer-starter-pro-404-content">
				<div class="developer-starter-pro-404-icon">🦷</div>
				<h1 class="developer-starter-pro-404-title">404</h1>
				<h2 class="developer-starter-pro-404-subtitle"><?php esc_html_e( 'Page Not Found', 'developer-starter-pro' ); ?></h2>
				<p class="developer-starter-pro-404-text">
					<?php esc_html_e( 'Oops! The page you are looking for seems to have gone missing. It might have been moved, deleted, or maybe the URL is incorrect.', 'developer-starter-pro' ); ?>
				</p>
				<div class="developer-starter-pro-404-actions">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
						<?php esc_html_e( 'Back to Home', 'developer-starter-pro' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
						<?php esc_html_e( 'Contact Us', 'developer-starter-pro' ); ?>
					</a>
				</div>
				<div class="developer-starter-pro-404-search">
					<?php get_search_form(); ?>
				</div>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
