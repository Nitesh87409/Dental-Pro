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
					<?php while ( have_posts() ) : the_post();
						$speciality = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_speciality', true );
						$experience = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_experience', true );
						$social     = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_social', true );
						$dept_terms = get_the_terms( get_the_ID(), 'department' );
						$dept_slugs = is_array( $dept_terms ) ? implode( ' ', wp_list_pluck( $dept_terms, 'slug' ) ) : '';
					?>
						<div class="developer-starter-pro-doctor-card" data-department="<?php echo esc_attr( $dept_slugs ); ?>">
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
									<?php the_post_thumbnail( 'developer-starter-pro-doctor-thumb' ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( $default_img ); ?>" alt="<?php the_title_attribute(); ?>" />
								<?php endif; ?>
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
							</div>
							<div class="developer-starter-pro-doctor-card-content">
								<h3 class="developer-starter-pro-doctor-name">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<?php if ( $speciality ) : ?>
									<span class="developer-starter-pro-doctor-speciality"><?php echo esc_html( $speciality ); ?></span>
								<?php endif; ?>
								<?php if ( $experience ) : ?>
									<span class="developer-starter-pro-doctor-experience">
										<?php printf( esc_html__( '%s+ Years Experience', 'developer-starter-pro' ), esc_html( $experience ) ); ?>
									</span>
								<?php endif; ?>
								<a href="<?php the_permalink(); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--outline">
									<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
								</a>
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

/* Compact doctor card sizes & layout */
.developer-starter-pro-doctors-grid {
	gap: 20px !important;
}
.developer-starter-pro-doctor-card {
	border: 1px solid rgba(0, 0, 0, 0.05);
	box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
	transition: var(--developer-starter-pro-transition) !important;
}
.developer-starter-pro-doctor-card:hover {
	transform: translateY(-4px) !important;
	box-shadow: 0 12px 30px rgba(13, 148, 136, 0.1) !important;
	border-color: rgba(13, 148, 136, 0.15) !important;
}
.developer-starter-pro-doctor-card-image {
	height: 240px !important; /* Slightly taller to prevent severe cropping */
}
.developer-starter-pro-doctor-card-image img {
	width: 100%;
	height: 100%;
	object-fit: cover !important;
	object-position: center top !important; /* Align to top to prevent doctor's head from being cut off */
}
.developer-starter-pro-doctor-card-content {
	padding: 12px 16px !important;
}
.developer-starter-pro-doctor-name {
	font-size: 1.1rem !important;
	margin-bottom: 2px !important;
}
.developer-starter-pro-doctor-speciality {
	font-size: 0.8rem !important;
	margin-bottom: 4px !important;
}
.developer-starter-pro-doctor-experience {
	font-size: 0.75rem !important;
	margin-bottom: 8px !important;
	display: block;
}
.developer-starter-pro-doctor-card-content .developer-starter-pro-btn {
	padding: 6px 12px !important;
	font-size: 0.75rem !important;
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
