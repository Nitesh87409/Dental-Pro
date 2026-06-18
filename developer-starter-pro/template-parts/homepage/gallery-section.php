<?php
/**
 * Template Part: Homepage Gallery Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

$gallery_badge    = developer_starter_pro_get_option( 'gallery_section_badge', 'Our Facility' );
$gallery_title    = developer_starter_pro_get_option( 'gallery_section_title', 'Modern Dental Clinic Showcase' );
$gallery_subtitle = developer_starter_pro_get_option( 'gallery_section_subtitle', 'A visual tour inside our state-of-the-art diagnostic suites and patient-friendly dental operatories.' );
$gallery_items    = developer_starter_pro_get_option( 'gallery_items', array() );

if ( empty( $gallery_items ) ) {
	$gallery_items = developer_starter_pro_get_default_options()['gallery_items'];
}
?>

<section class="developer-starter-pro-section homepage-gallery-section" id="gallery" style="background: var(--developer-starter-pro-white);">
	<div class="developer-starter-pro-container">
		
		<div class="developer-starter-pro-section-header">
			<?php if ( ! empty( $gallery_badge ) ) : ?>
				<span class="developer-starter-pro-section-badge"><?php echo esc_html( $gallery_badge ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $gallery_title ) ) : ?>
				<h2 class="developer-starter-pro-section-title"><?php echo esc_html( $gallery_title ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $gallery_subtitle ) ) : ?>
				<p class="developer-starter-pro-section-subtitle"><?php echo esc_html( $gallery_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $gallery_items ) && is_array( $gallery_items ) ) : ?>
			<div class="gallery-showcase-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-top: 40px;">
				
				<?php foreach ( $gallery_items as $item ) : 
					if ( empty( $item['image'] ) ) continue;
				?>
					<div class="gallery-item" style="position: relative; overflow: hidden; border-radius: var(--developer-starter-pro-radius-lg); aspect-ratio: 3/2; box-shadow: var(--developer-starter-pro-shadow-md); cursor: pointer;">
						<img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" />
						<div class="gallery-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(13, 148, 136, 0.9) 0%, rgba(0,0,0,0) 100%); display: flex; align-items: flex-end; padding: 24px; opacity: 0; transition: opacity 0.3s ease;">
							<?php if ( ! empty( $item['title'] ) ) : ?>
								<h4 style="margin: 0; color: #fff; font-size: 1.125rem;"><?php echo esc_html( $item['title'] ); ?></h4>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>

			</div>
		<?php endif; ?>

		<div class="developer-starter-pro-section-cta" style="margin-top: 40px; text-align: center;">
			<a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
				<?php esc_html_e( 'View Full Gallery', 'developer-starter-pro' ); ?>
			</a>
		</div>

	</div>
</section>

<style>
.gallery-item:hover img {
	transform: scale(1.08);
}
.gallery-item:hover .gallery-overlay {
	opacity: 1 !important;
}
</style>
