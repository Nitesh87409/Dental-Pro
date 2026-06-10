<?php
/**
 * Template Part: Homepage Gallery Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<section class="developer-starter-pro-section homepage-gallery-section" id="gallery" style="background: var(--developer-starter-pro-white);">
	<div class="developer-starter-pro-container">
		
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Facility', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Modern Dental Clinic Showcase', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'A visual tour inside our state-of-the-art diagnostic suites and patient-friendly dental operatories.', 'developer-starter-pro' ); ?></p>
		</div>

		<div class="gallery-showcase-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-top: 40px;">
			
			<!-- Image 1 -->
			<div class="gallery-item" style="position: relative; overflow: hidden; border-radius: var(--developer-starter-pro-radius-lg); aspect-ratio: 3/2; box-shadow: var(--developer-starter-pro-shadow-md); cursor: pointer;">
				<img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=600" alt="<?php esc_attr_e( 'Dental Surgery Room', 'developer-starter-pro' ); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" />
				<div class="gallery-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(13, 148, 136, 0.9) 0%, rgba(0,0,0,0) 100%); display: flex; align-items: flex-end; padding: 24px; opacity: 0; transition: opacity 0.3s ease;">
					<h4 style="margin: 0; color: #fff; font-size: 1.125rem;"><?php esc_html_e( 'State-of-the-Art Surgery Suite', 'developer-starter-pro' ); ?></h4>
				</div>
			</div>

			<!-- Image 2 -->
			<div class="gallery-item" style="position: relative; overflow: hidden; border-radius: var(--developer-starter-pro-radius-lg); aspect-ratio: 3/2; box-shadow: var(--developer-starter-pro-shadow-md); cursor: pointer;">
				<img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=600" alt="<?php esc_attr_e( 'Sterilized Instruments', 'developer-starter-pro' ); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" />
				<div class="gallery-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(13, 148, 136, 0.9) 0%, rgba(0,0,0,0) 100%); display: flex; align-items: flex-end; padding: 24px; opacity: 0; transition: opacity 0.3s ease;">
					<h4 style="margin: 0; color: #fff; font-size: 1.125rem;"><?php esc_html_e( 'Hygienic Sterilized Materials', 'developer-starter-pro' ); ?></h4>
				</div>
			</div>

			<!-- Image 3 -->
			<div class="gallery-item" style="position: relative; overflow: hidden; border-radius: var(--developer-starter-pro-radius-lg); aspect-ratio: 3/2; box-shadow: var(--developer-starter-pro-shadow-md); cursor: pointer;">
				<img src="https://images.unsplash.com/photo-1579684389782-64d84b5e902a?auto=format&fit=crop&q=80&w=600" alt="<?php esc_attr_e( 'Patient Care Operatory', 'developer-starter-pro' ); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" />
				<div class="gallery-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(13, 148, 136, 0.9) 0%, rgba(0,0,0,0) 100%); display: flex; align-items: flex-end; padding: 24px; opacity: 0; transition: opacity 0.3s ease;">
					<h4 style="margin: 0; color: #fff; font-size: 1.125rem;"><?php esc_html_e( 'Patient Comfort Operatory', 'developer-starter-pro' ); ?></h4>
				</div>
			</div>

		</div>

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
