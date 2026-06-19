<?php
/**
 * Template Name: HTML Sitemap
 *
 * A clean, comprehensive sitemap template for SEO and patient navigation.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Navigation Index', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Find all pages, dental treatments, clinical specialists, and recent health advice.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Sitemap Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">

			<div class="sitemap-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px; margin-bottom: 48px;">

				<!-- Column 1: Main Pages -->
				<div class="sitemap-col">
					<div class="sitemap-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 12px; padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); height: 100%;">
						<h3 class="sitemap-title" style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--developer-starter-pro-secondary); display: flex; align-items: center; gap: 8px;">
							<span>📄</span> <?php esc_html_e( 'Main Pages', 'developer-starter-pro' ); ?>
						</h3>
						<ul class="sitemap-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;">
							<?php
							$pages = get_pages( array(
								'sort_column' => 'post_title',
								'sort_order'  => 'ASC',
								'parent'      => 0,
							) );
							if ( $pages ) :
								foreach ( $pages as $page ) : ?>
									<li>
										<a href="<?php echo esc_url( get_permalink( $page->ID ) ); ?>" style="color: var(--developer-starter-pro-gray-600); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--developer-starter-pro-primary)'" onmouseout="this.style.color='var(--developer-starter-pro-gray-600)'">
											<?php echo esc_html( $page->post_title ); ?>
										</a>
									</li>
								<?php endforeach;
							else : ?>
								<li style="color: var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'No pages found.', 'developer-starter-pro' ); ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

				<!-- Column 2: Clinical Services -->
				<div class="sitemap-col">
					<div class="sitemap-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 12px; padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); height: 100%;">
						<h3 class="sitemap-title" style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--developer-starter-pro-secondary); display: flex; align-items: center; gap: 8px;">
							<span>🦷</span> <?php esc_html_e( 'Treatments & Services', 'developer-starter-pro' ); ?>
						</h3>
						<ul class="sitemap-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;">
							<?php
							$services_query = new WP_Query( array(
								'post_type'      => 'services',
								'posts_per_page' => 500,
								'orderby'        => 'title',
								'order'          => 'ASC',
								'post_status'    => 'publish',
							) );
							if ( $services_query->have_posts() ) :
								while ( $services_query->have_posts() ) : $services_query->the_post(); ?>
									<li>
										<a href="<?php the_permalink(); ?>" style="color: var(--developer-starter-pro-gray-600); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--developer-starter-pro-primary)'" onmouseout="this.style.color='var(--developer-starter-pro-gray-600)'">
											<?php the_title(); ?>
										</a>
									</li>
								<?php endwhile;
								wp_reset_postdata();
							else : ?>
								<li style="color: var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'No dental services registered.', 'developer-starter-pro' ); ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

				<!-- Column 3: Medical Specialists -->
				<div class="sitemap-col">
					<div class="sitemap-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 12px; padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); height: 100%;">
						<h3 class="sitemap-title" style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--developer-starter-pro-secondary); display: flex; align-items: center; gap: 8px;">
							<span>👨‍⚕️</span> <?php esc_html_e( 'Dental Doctors', 'developer-starter-pro' ); ?>
						</h3>
						<ul class="sitemap-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;">
							<?php
							$doctors_query = new WP_Query( array(
								'post_type'      => 'doctors',
								'posts_per_page' => 500,
								'orderby'        => 'title',
								'order'          => 'ASC',
								'post_status'    => 'publish',
							) );
							if ( $doctors_query->have_posts() ) :
								while ( $doctors_query->have_posts() ) : $doctors_query->the_post(); ?>
									<li>
										<a href="<?php the_permalink(); ?>" style="color: var(--developer-starter-pro-gray-600); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--developer-starter-pro-primary)'" onmouseout="this.style.color='var(--developer-starter-pro-gray-600)'">
											<?php the_title(); ?>
										</a>
									</li>
								<?php endwhile;
								wp_reset_postdata();
							else : ?>
								<li style="color: var(--developer-starter-pro-gray-400);"><?php esc_html_e( 'No specialists registered.', 'developer-starter-pro' ); ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

				<!-- Column 4: Blog & Categories -->
				<div class="sitemap-col">
					<div class="sitemap-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 12px; padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); height: 100%;">
						<h3 class="sitemap-title" style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--developer-starter-pro-secondary); display: flex; align-items: center; gap: 8px;">
							<span>📰</span> <?php esc_html_e( 'Dental News & Tips', 'developer-starter-pro' ); ?>
						</h3>
						<div style="margin-bottom: 20px;">
							<h4 style="margin: 0 0 10px 0; font-size: 0.875rem; text-transform: uppercase; color: var(--developer-starter-pro-gray-400); letter-spacing: 0.5px;"><?php esc_html_e( 'Categories', 'developer-starter-pro' ); ?></h4>
							<ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
								<?php
								$cats = get_categories();
								if ( $cats ) :
									foreach ( $cats as $cat ) : ?>
										<li>
											<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="color: var(--developer-starter-pro-gray-500); text-decoration: none; font-size: 0.9375rem; transition: color 0.2s;" onmouseover="this.style.color='var(--developer-starter-pro-primary)'" onmouseout="this.style.color='var(--developer-starter-pro-gray-500)'">
												📁 <?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
											</a>
										</li>
									<?php endforeach;
								endif; ?>
							</ul>
						</div>

						<div>
							<h4 style="margin: 0 0 10px 0; font-size: 0.875rem; text-transform: uppercase; color: var(--developer-starter-pro-gray-400); letter-spacing: 0.5px;"><?php esc_html_e( 'Recent Articles', 'developer-starter-pro' ); ?></h4>
							<ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
								<?php
								$recent_posts = get_posts( array(
									'posts_per_page' => 5,
									'post_status'    => 'publish',
								) );
								if ( $recent_posts ) :
									foreach ( $recent_posts as $post ) : ?>
										<li>
											<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" style="color: var(--developer-starter-pro-gray-600); text-decoration: none; font-size: 0.9375rem; transition: color 0.2s;" onmouseover="this.style.color='var(--developer-starter-pro-primary)'" onmouseout="this.style.color='var(--developer-starter-pro-gray-600)'">
												<?php echo esc_html( $post->post_title ); ?>
											</a>
										</li>
									<?php endforeach;
								endif; ?>
							</ul>
						</div>
					</div>
				</div>

			</div>

		</div>
	</section>

</main>

<style>
body.dark-mode .sitemap-card {
	background: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode .sitemap-title {
	color: #F8FAFC !important;
}
body.dark-mode .sitemap-card a {
	color: #94A3B8 !important;
}
body.dark-mode .sitemap-card a:hover {
	color: var(--developer-starter-pro-primary) !important;
}
</style>

<?php
get_footer();
