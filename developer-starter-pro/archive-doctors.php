<?php
/**
 * Archive Doctors Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Banner -->
	<div class="developer-starter-pro-archive-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Team', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php esc_html_e( 'Meet Our Expert Doctors', 'developer-starter-pro' ); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Our team of experienced dental professionals is dedicated to providing you with the highest quality care.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<div class="developer-starter-pro-container">
		<div class="developer-starter-pro-section" style="padding-top: 16px;">

			<?php if ( have_posts() ) : ?>

				<!-- Filter by Department -->
				<?php
				$departments = get_terms( array(
					'taxonomy'   => 'department',
					'hide_empty' => true,
				) );

				if ( ! empty( $departments ) && ! is_wp_error( $departments ) ) : ?>
					<div class="developer-starter-pro-filter-bar" style="text-align: center; margin-bottom: 16px;">
						<button class="developer-starter-pro-filter-btn active" data-filter="all"><?php esc_html_e( 'All Departments', 'developer-starter-pro' ); ?></button>
						<?php foreach ( $departments as $dept ) : ?>
							<button class="developer-starter-pro-filter-btn" data-filter="<?php echo esc_attr( $dept->slug ); ?>"><?php echo esc_html( $dept->name ); ?></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="developer-starter-pro-doctors-grid">
					<?php
					$card_idx = 0;
					while ( have_posts() ) : the_post();
						$card_idx++;
						$speciality = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_speciality', true );
						$experience = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_experience', true );
						$social     = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_social', true );
						$dept_terms = get_the_terms( get_the_ID(), 'department' );
						$dept_slugs = is_array( $dept_terms ) ? implode( ' ', wp_list_pluck( $dept_terms, 'slug' ) ) : '';
					?>
						<div class="developer-starter-pro-doctor-card" data-department="<?php echo esc_attr( $dept_slugs ); ?>">
							<!-- Card Background Image -->
							<div class="developer-starter-pro-doctor-card-image">
								<?php 
								$default_img = '';
								$post_title = get_the_title();
								if ( stripos( $post_title, 'Emma' ) !== false || stripos( $post_title, 'Chen' ) !== false ) {
									$default_img = get_template_directory_uri() . '/assets/images/dr-emma-chen.png';
								} elseif ( stripos( $post_title, 'James' ) !== false || stripos( $post_title, 'Patel' ) !== false ) {
									$default_img = get_template_directory_uri() . '/assets/images/dr-james-patel.png';
								} elseif ( stripos( $post_title, 'Michael' ) !== false || stripos( $post_title, 'Ross' ) !== false ) {
									$default_img = get_template_directory_uri() . '/assets/images/dr-michael-ross.png';
								} elseif ( stripos( $post_title, 'Sarah' ) !== false || stripos( $post_title, 'Mitchell' ) !== false ) {
									$default_img = get_template_directory_uri() . '/assets/images/dr-sarah-mitchell.png';
								}
								if ( ! $default_img ) {
									$dr_images = array( 'dr-emma-chen.png', 'dr-james-patel.png', 'dr-michael-ross.png', 'dr-sarah-mitchell.png' );
									$default_img = get_template_directory_uri() . '/assets/images/' . $dr_images[ get_the_ID() % 4 ];
								}
								?>
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large' ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( $default_img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								<?php endif; ?>
							</div>

							<!-- Translucent Overlay -->
							<div class="developer-starter-pro-doctor-card-overlay"></div>

							<!-- Floating Social Bar (Top Left on Hover) -->
							<?php if ( is_array( $social ) && ! empty( array_filter( $social ) ) ) : ?>
								<div class="developer-starter-pro-doctor-social-overlay">
									<?php foreach ( $social as $platform => $url ) :
										if ( $url ) : ?>
											<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $platform ) ); ?>">
												<?php echo developer_starter_pro_get_social_icon( $platform ); // phpcs:ignore ?>
											</a>
										<?php endif;
									endforeach; ?>
								</div>
							<?php endif; ?>

							<!-- Number Badge (Top Right) -->
							<div class="developer-starter-pro-doctor-card-num" aria-hidden="true"><?php echo str_pad( $card_idx, 2, '0', STR_PAD_LEFT ); ?></div>

							<!-- Content Container -->
							<div class="developer-starter-pro-doctor-card-content">
								<?php if ( $speciality ) : ?>
									<span class="developer-starter-pro-doctor-speciality">
										<svg viewBox="0 0 12 12" fill="currentColor" width="6" height="6" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><circle cx="6" cy="6" r="6"/></svg>
										<?php echo esc_html( $speciality ); ?>
									</span>
								<?php endif; ?>
								<h3 class="developer-starter-pro-doctor-name">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								
								<!-- Hover Expandable Info -->
								<div class="developer-starter-pro-doctor-hover-content">
									<?php if ( $experience ) : ?>
										<span class="developer-starter-pro-doctor-experience">
											<?php printf( esc_html__( '%s+ Years Experience', 'developer-starter-pro' ), esc_html( $experience ) ); ?>
										</span>
									<?php endif; ?>
									<a href="<?php the_permalink(); ?>" class="developer-starter-pro-doctor-btn">
										<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
										<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="margin-left: 4px; display: inline-block; vertical-align: middle;"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
									</a>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>

				<div class="developer-starter-pro-pagination">
					<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
				</div>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</div>
</main>

<style>
.developer-starter-pro-filter-btn {
	padding: 6px 14px !important;
	font-size: 0.8rem !important;
}

.developer-starter-pro-filter-bar {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 8px;
}

.developer-starter-pro-filter-btn {
	padding: 8px 20px;
	background: var(--developer-starter-pro-gray-100);
	border: 1px solid var(--developer-starter-pro-gray-200);
	border-radius: var(--developer-starter-pro-radius-full);
	font-size: 0.875rem;
	font-weight: 500;
	cursor: pointer;
	transition: all 0.2s ease;
	color: var(--developer-starter-pro-gray-600);
}

.developer-starter-pro-filter-btn:hover,
.developer-starter-pro-filter-btn.active {
	background: var(--developer-starter-pro-primary);
	color: #fff;
	border-color: var(--developer-starter-pro-primary);
}

/* ── Doctor Card (Glassmorphic Redesign) ── */
.developer-starter-pro-doctors-grid {
	gap: 24px !important;
	grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)) !important;
}

.developer-starter-pro-doctor-card {
	display: flex !important;
	flex-direction: column;
	position: relative;
	min-height: 420px;
	border-radius: 18px !important;
	overflow: hidden !important;
	justify-content: flex-end;
	border: 1px solid rgba(255, 255, 255, 0.12) !important;
	box-shadow:
		0 4px 20px rgba(0, 0, 0, 0.25),
		0 1px 4px rgba(0, 0, 0, 0.15) !important;
	transition:
		transform 0.4s cubic-bezier(0.25, 1, 0.5, 1),
		box-shadow 0.4s cubic-bezier(0.25, 1, 0.5, 1) !important;
	cursor: pointer;
	text-align: left !important;
	background: #101E12 !important;
}

.developer-starter-pro-doctor-card:hover {
	transform: translateY(-8px) !important;
	box-shadow:
		0 12px 36px rgba(78, 124, 89, 0.22),
		0 24px 56px rgba(0, 0, 0, 0.35) !important;
}

/* Image Wrap / Card Background */
.developer-starter-pro-doctor-card-image {
	position: absolute !important;
	inset: 0 !important;
	z-index: 0 !important;
	background: #101E12 !important;
	overflow: hidden !important;
	height: 100% !important;
}

.developer-starter-pro-doctor-card-image img {
	width: 100% !important;
	height: 100% !important;
	object-fit: cover !important;
	object-position: center top !important;
	display: block !important;
	transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1) !important;
}

.developer-starter-pro-doctor-card:hover .developer-starter-pro-doctor-card-image img {
	transform: scale(1.08) !important;
}

/* Hover overlay */
.developer-starter-pro-doctor-card-overlay {
	position: absolute;
	inset: 0;
	background: linear-gradient(
		to bottom,
		rgba(10, 20, 15, 0.15) 0%,
		rgba(10, 20, 12, 0.45) 50%,
		rgba(5, 10, 6, 0.88) 100%
	);
	z-index: 1;
	transition: background 0.4s ease;
	pointer-events: none;
}
.developer-starter-pro-doctor-card:hover .developer-starter-pro-doctor-card-overlay {
	background: linear-gradient(
		to bottom,
		rgba(10, 20, 15, 0.08) 0%,
		rgba(10, 20, 12, 0.55) 45%,
		rgba(5, 10, 6, 0.94) 100%
	);
}

/* Floating Social Bar (Top Left on Hover) */
.developer-starter-pro-doctor-social-overlay {
	position: absolute !important;
	top: 16px !important;
	left: 16px !important;
	bottom: auto !important;
	right: auto !important;
	display: flex !important;
	flex-direction: column !important;
	gap: 8px !important;
	padding: 0 !important;
	background: transparent !important;
	transform: translateY(0) !important;
	opacity: 0 !important;
	z-index: 10 !important;
	transition: opacity 0.3s ease !important;
}
.developer-starter-pro-doctor-card:hover .developer-starter-pro-doctor-social-overlay {
	opacity: 1 !important;
}
.developer-starter-pro-doctor-social-overlay a {
	display: flex !important;
	align-items: center !important;
	justify-content: center !important;
	width: 30px !important;
	height: 30px !important;
	background: rgba(255, 255, 255, 0.12) !important;
	backdrop-filter: blur(8px) !important;
	-webkit-backdrop-filter: blur(8px) !important;
	border: 1px solid rgba(255, 255, 255, 0.25) !important;
	border-radius: 8px !important;
	color: #FFFFFF !important;
	transition: transform 0.2s ease, background 0.2s ease !important;
}
.developer-starter-pro-doctor-social-overlay a:hover {
	background: var(--developer-starter-pro-primary) !important;
	transform: scale(1.08);
}
.developer-starter-pro-doctor-social-overlay a svg {
	width: 13px !important;
	height: 13px !important;
	fill: currentColor !important;
}

/* Number Badge (Top Right) */
.developer-starter-pro-doctor-card-num {
	position: absolute;
	top: 16px;
	right: 16px;
	width: 32px;
	height: 32px;
	background: rgba(255, 255, 255, 0.12);
	backdrop-filter: blur(8px);
	-webkit-backdrop-filter: blur(8px);
	border: 1px solid rgba(255, 255, 255, 0.25);
	border-radius: 8px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 0.72rem;
	font-weight: 700;
	color: #FFFFFF;
	z-index: 3;
}

/* Content container */
.developer-starter-pro-doctor-card-content {
	position: relative !important;
	z-index: 2 !important;
	padding: 24px !important;
	width: 100% !important;
	box-sizing: border-box !important;
	text-align: left !important;
	background: transparent !important;
}

.developer-starter-pro-doctor-speciality {
	display: inline-flex !important;
	align-items: center;
	gap: 4px !important;
	font-size: 0.68rem !important;
	font-weight: 700 !important;
	letter-spacing: 0.12em !important;
	text-transform: uppercase !important;
	color: #F3C64F !important;
	margin-bottom: 8px !important;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4) !important;
}

.developer-starter-pro-doctor-name {
	font-family: 'Playfair Display', Georgia, serif !important;
	font-size: 1.25rem !important;
	font-weight: 600 !important;
	color: #FFFFFF !important;
	margin: 0 !important;
	line-height: 1.35 !important;
	text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6) !important;
}
.developer-starter-pro-doctor-name a {
	color: inherit !important;
	text-decoration: none !important;
	transition: color 0.2s !important;
}
.developer-starter-pro-doctor-name a:hover {
	color: #F3C64F !important;
}

/* Expandable hover content */
.developer-starter-pro-doctor-hover-content {
	max-height: 0;
	opacity: 0;
	overflow: hidden;
	transition: max-height 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease;
}
.developer-starter-pro-doctor-card:hover .developer-starter-pro-doctor-hover-content {
	max-height: 160px;
	opacity: 1;
	margin-top: 12px;
}

.developer-starter-pro-doctor-experience {
	font-size: 0.82rem !important;
	color: rgba(255, 255, 255, 0.85) !important;
	line-height: 1.5 !important;
	margin: 0 0 16px 0 !important;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
	display: block !important;
}

.developer-starter-pro-doctor-btn {
	display: inline-flex !important;
	align-items: center;
	gap: 6px;
	padding: 9px 18px !important;
	background: linear-gradient(135deg, var(--developer-starter-pro-primary), var(--developer-starter-pro-primary-dark)) !important;
	color: #FFFFFF !important;
	border-radius: 24px !important;
	font-size: 0.78rem !important;
	font-weight: 600 !important;
	text-decoration: none !important;
	letter-spacing: 0.02em !important;
	box-shadow: 0 4px 12px rgba(78, 124, 89, 0.2) !important;
	border: 1px solid rgba(255, 255, 255, 0.08) !important;
	transition: gap 0.25s ease, box-shadow 0.25s ease, transform 0.2s ease !important;
}
.developer-starter-pro-doctor-btn:hover {
	color: #FFFFFF !important;
	gap: 10px;
	box-shadow: 0 6px 20px rgba(78, 124, 89, 0.45) !important;
	transform: translateX(2px) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterBtns = document.querySelectorAll('.developer-starter-pro-filter-btn');
	var doctorCards = document.querySelectorAll('.developer-starter-pro-doctor-card[data-department]');

	filterBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			filterBtns.forEach(function(b) { b.classList.remove('active'); });
			this.classList.add('active');

			var filter = this.getAttribute('data-filter');
			doctorCards.forEach(function(card) {
				if (filter === 'all' || card.getAttribute('data-department').indexOf(filter) !== -1) {
					card.style.display = '';
					card.style.animation = 'fadeInUp 0.4s ease-out';
				} else {
					card.style.display = 'none';
				}
			});
		});
	});
});
</script>

<?php
get_footer();
