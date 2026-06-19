<?php
/**
 * Template Name: Doctors Directory
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

// Fetch all doctors
$doctors_query = new WP_Query( array(
	'post_type'      => 'doctors',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
) );

$departments = get_terms( array(
	'taxonomy'   => 'department',
	'hide_empty' => true,
) );
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Team', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Meet our world-class team of certified dental surgeons, hygienists, and orthodontists.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">

			<!-- Directory Toolbar -->
			<div class="directory-toolbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; gap: 20px; flex-wrap: wrap;">
				<!-- Department Filters -->
				<?php if ( ! empty( $departments ) && ! is_wp_error( $departments ) ) : ?>
					<div class="doctors-dept-filters" style="display: flex; gap: 8px; flex-wrap: wrap;">
						<button class="filter-btn active" data-filter="all" style="padding: 8px 18px; border: 2px solid var(--developer-starter-pro-gray-200); background: transparent; border-radius: var(--developer-starter-pro-radius-full); font-weight: 600; cursor: pointer; transition: all 0.2s ease;"><?php esc_html_e( 'All Specialties', 'developer-starter-pro' ); ?></button>
						<?php foreach ( $departments as $dept ) : ?>
							<button class="filter-btn" data-filter="<?php echo esc_attr( $dept->slug ); ?>" style="padding: 8px 18px; border: 2px solid var(--developer-starter-pro-gray-200); background: transparent; border-radius: var(--developer-starter-pro-radius-full); font-weight: 600; cursor: pointer; transition: all 0.2s ease;"><?php echo esc_html( $dept->name ); ?></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- List/Grid Switcher -->
				<div class="layout-toggle" style="display: flex; border: 2px solid var(--developer-starter-pro-gray-200); border-radius: 8px; overflow: hidden; background: #fff;">
					<button id="grid-toggle" class="toggle-btn active" style="padding: 8px 14px; background: none; border: none; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; outline: none; transition: all 0.2s ease;">
						<span>⬜ Grid</span>
					</button>
					<button id="list-toggle" class="toggle-btn" style="padding: 8px 14px; background: none; border: none; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; outline: none; transition: all 0.2s ease;">
						<span>📋 List</span>
					</button>
				</div>
			</div>

			<!-- Doctors Grid Wrapper -->
			<div class="doctors-directory-wrap layout-grid" id="doctors-directory-grid">
				<?php if ( $doctors_query->have_posts() ) : ?>
					<?php while ( $doctors_query->have_posts() ) : $doctors_query->the_post();
						$spec        = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_speciality', true );
						$experience  = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_experience', true );
						$quals       = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_qualifications', true );
						$social      = get_post_meta( get_the_ID(), '_developer_starter_pro_doctor_social', true );
						
						// Get item categories
						$item_depts = get_the_terms( get_the_ID(), 'department' );
						$depts = array();
						if ( $item_depts && ! is_wp_error( $item_depts ) ) {
							foreach ( $item_depts as $d ) {
								$depts[] = $d->slug;
							}
						}
						$dept_string = implode( ' ', $depts );
					?>
						<div class="directory-doctor-card" data-depts="<?php echo esc_attr( $dept_string ); ?>">
							<!-- Card Background Image -->
							<div class="doctor-card-photo">
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

							<!-- Translucent Overlay (Only active in grid layout) -->
							<div class="doctor-card-overlay"></div>

							<!-- Floating Social Bar (Top Left on Hover - grid layout only) -->
							<?php if ( is_array( $social ) && ! empty( array_filter( $social ) ) ) : ?>
								<div class="doctor-card-social-overlay">
									<?php foreach ( $social as $platform => $url ) :
										if ( $url ) : ?>
											<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $platform ) ); ?>">
												<?php echo developer_starter_pro_get_social_icon( $platform ); // phpcs:ignore ?>
											</a>
										<?php endif;
									endforeach; ?>
								</div>
							<?php endif; ?>

							<!-- Number Badge (Top Right - grid layout only) -->
							<div class="doctor-card-num" aria-hidden="true"><?php echo str_pad( $doctors_query->current_post + 1, 2, '0', STR_PAD_LEFT ); ?></div>

							<!-- Content Container -->
							<div class="doctor-card-body">
								<div class="doctor-card-body-inner">
									<span class="doctor-card-spec">
										<svg viewBox="0 0 12 12" fill="currentColor" width="6" height="6" class="spec-dot" style="margin-right: 4px; display: inline-block; vertical-align: middle;"><circle cx="6" cy="6" r="6"/></svg>
										<?php echo esc_html( $spec ? $spec : __( 'General Practitioner', 'developer-starter-pro' ) ); ?>
									</span>
									<h3 class="doctor-card-name">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									
									<!-- Hover Expandable Info -->
									<div class="doctor-card-hover-content">
										<?php if ( $experience ) : ?>
											<span class="doctor-card-experience">
												⏱ <?php printf( esc_html__( '%s+ Years Experience', 'developer-starter-pro' ), esc_html( $experience ) ); ?>
											</span>
										<?php endif; ?>
										<?php if ( $quals ) : ?>
											<p class="doctor-card-quals-hover"><?php echo esc_html( wp_trim_words( $quals, 10, '...' ) ); ?></p>
										<?php endif; ?>
									</div>
								</div>
								
								<div class="doctor-card-actions">
									<a href="<?php the_permalink(); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--outline view-profile-btn">
										<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
										<svg class="btn-arrow" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12" style="margin-left: 4px; display: inline-block; vertical-align: middle;"><path d="M4 10h12M12 6l4 4-4 4"/></svg>
									</a>
									<a href="<?php echo esc_url( add_query_arg( 'doctor_id', get_the_ID(), developer_starter_pro_get_booking_url() ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--primary book-now-btn">
										<?php esc_html_e( 'Book Now', 'developer-starter-pro' ); ?>
									</a>
								</div>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<p style="text-align: center; color: var(--developer-starter-pro-gray-500);"><?php esc_html_e( 'No medical doctors configured yet.', 'developer-starter-pro' ); ?></p>
				<?php endif; ?>
			</div>

		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterButtons = document.querySelectorAll('.doctors-dept-filters .filter-btn');
	var cards = document.querySelectorAll('.directory-doctor-card');
	var container = document.getElementById('doctors-directory-grid');

	var gridToggle = document.getElementById('grid-toggle');
	var listToggle = document.getElementById('list-toggle');

	filterButtons.forEach(function(btn) {
		btn.addEventListener('click', function() {
			filterButtons.forEach(function(b) { b.classList.remove('active'); b.style.background = 'transparent'; b.style.borderColor = 'var(--developer-starter-pro-gray-200)'; b.style.color = ''; });
			this.classList.add('active');
			this.style.background = 'var(--developer-starter-pro-primary)';
			this.style.borderColor = 'var(--developer-starter-pro-primary)';
			this.style.color = '#fff';

			var filter = this.getAttribute('data-filter');

			cards.forEach(function(card) {
				var depts = card.getAttribute('data-depts').split(' ');
				if (filter === 'all' || depts.indexOf(filter) !== -1) {
					card.style.display = 'grid';
				} else {
					card.style.display = 'none';
				}
			});
		});
	});

	// Style active button initially
	var activeBtn = document.querySelector('.doctors-dept-filters .filter-btn.active');
	if (activeBtn) {
		activeBtn.style.background = 'var(--developer-starter-pro-primary)';
		activeBtn.style.borderColor = 'var(--developer-starter-pro-primary)';
		activeBtn.style.color = '#fff';
	}

	// Layout switcher
	if (gridToggle && listToggle && container) {
		gridToggle.addEventListener('click', function() {
			listToggle.classList.remove('active');
			listToggle.style.background = 'none';
			listToggle.style.color = '';
			
			this.classList.add('active');
			this.style.background = 'var(--developer-starter-pro-primary)';
			this.style.color = '#fff';
			
			container.className = 'doctors-directory-wrap layout-grid';
		});

		listToggle.addEventListener('click', function() {
			gridToggle.classList.remove('active');
			gridToggle.style.background = 'none';
			gridToggle.style.color = '';
			
			this.classList.add('active');
			this.style.background = 'var(--developer-starter-pro-primary)';
			this.style.color = '#fff';
			
			container.className = 'doctors-directory-wrap layout-list';
		});
		
		// Set grid active initially
		gridToggle.click();
	}
});
</script>

<style>
/* CSS Styles for Grid / List layouts */

/* --- SHARED STYLES & OVERRIDES --- */
.doctors-dept-filters .filter-btn {
	padding: 8px 18px !important;
	border: 2px solid var(--developer-starter-pro-gray-200) !important;
	background: transparent !important;
	border-radius: var(--developer-starter-pro-radius-full) !important;
	font-weight: 600 !important;
	cursor: pointer !important;
	transition: all 0.2s ease !important;
	color: var(--developer-starter-pro-gray-600) !important;
}

.doctors-dept-filters .filter-btn.active {
	background: var(--developer-starter-pro-primary) !important;
	border-color: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
}

body.dark-mode .doctors-dept-filters .filter-btn {
	border-color: #334155 !important;
	color: #CBD5E1 !important;
}
body.dark-mode .doctors-dept-filters .filter-btn.active {
	background: var(--developer-starter-pro-primary) !important;
	border-color: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
}

/* --- GRID VIEW STYLES --- */
.doctors-directory-wrap.layout-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
	gap: 24px;
}

.doctors-directory-wrap.layout-grid .directory-doctor-card {
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

.doctors-directory-wrap.layout-grid .directory-doctor-card:hover {
	transform: translateY(-8px) !important;
	box-shadow:
		0 12px 36px rgba(78, 124, 89, 0.22),
		0 24px 56px rgba(0, 0, 0, 0.35) !important;
}

/* Background image overlay */
.doctors-directory-wrap.layout-grid .doctor-card-photo {
	position: absolute !important;
	inset: 0 !important;
	z-index: 0 !important;
	background: #101E12 !important;
	overflow: hidden !important;
	height: 100% !important;
	width: 100% !important;
	aspect-ratio: auto !important;
}

.doctors-directory-wrap.layout-grid .doctor-card-photo img {
	width: 100% !important;
	height: 100% !important;
	object-fit: cover !important;
	object-position: center top !important;
	display: block !important;
	transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1) !important;
}

.doctors-directory-wrap.layout-grid .directory-doctor-card:hover .doctor-card-photo img {
	transform: scale(1.08) !important;
}

/* Overlay gradients */
.doctors-directory-wrap.layout-grid .doctor-card-overlay {
	display: block !important;
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
.doctors-directory-wrap.layout-grid .directory-doctor-card:hover .doctor-card-overlay {
	background: linear-gradient(
		to bottom,
		rgba(10, 20, 15, 0.08) 0%,
		rgba(10, 20, 12, 0.55) 45%,
		rgba(5, 10, 6, 0.94) 100%
	);
}

/* Floating social overlay */
.doctors-directory-wrap.layout-grid .doctor-card-social-overlay {
	display: flex !important;
	position: absolute !important;
	top: 16px !important;
	left: 16px !important;
	bottom: auto !important;
	right: auto !important;
	flex-direction: column !important;
	gap: 8px !important;
	padding: 0 !important;
	background: transparent !important;
	transform: translateY(0) !important;
	opacity: 0 !important;
	z-index: 10 !important;
	transition: opacity 0.3s ease !important;
}
.doctors-directory-wrap.layout-grid .directory-doctor-card:hover .doctor-card-social-overlay {
	opacity: 1 !important;
}
.doctors-directory-wrap.layout-grid .doctor-card-social-overlay a {
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
.doctors-directory-wrap.layout-grid .doctor-card-social-overlay a:hover {
	background: var(--developer-starter-pro-primary) !important;
	transform: scale(1.08);
}
.doctors-directory-wrap.layout-grid .doctor-card-social-overlay a svg {
	width: 13px !important;
	height: 13px !important;
	fill: currentColor !important;
}

/* Number badge */
.doctors-directory-wrap.layout-grid .doctor-card-num {
	display: flex !important;
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
	align-items: center;
	justify-content: center;
	font-size: 0.72rem;
	font-weight: 700;
	color: #FFFFFF;
	z-index: 3;
}

/* Content body */
.doctors-directory-wrap.layout-grid .doctor-card-body {
	position: relative !important;
	z-index: 2 !important;
	padding: 24px !important;
	width: 100% !important;
	box-sizing: border-box !important;
	text-align: left !important;
	background: transparent !important;
	display: flex !important;
	flex-direction: column !important;
	justify-content: flex-end !important;
	flex-grow: 1 !important;
	border: none !important;
	box-shadow: none !important;
}

.doctors-directory-wrap.layout-grid .doctor-card-spec {
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
.doctors-directory-wrap.layout-grid .doctor-card-spec svg.spec-dot {
	display: inline-block !important;
}

.doctors-directory-wrap.layout-grid .doctor-card-name {
	font-family: 'Playfair Display', Georgia, serif !important;
	font-size: 1.25rem !important;
	font-weight: 600 !important;
	color: #FFFFFF !important;
	margin: 0 !important;
	line-height: 1.35 !important;
	text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6) !important;
}
.doctors-directory-wrap.layout-grid .doctor-card-name a {
	color: inherit !important;
	text-decoration: none !important;
	transition: color 0.2s !important;
}
.doctors-directory-wrap.layout-grid .doctor-card-name a:hover {
	color: #F3C64F !important;
}

/* Hover expandable info wrapper */
.doctors-directory-wrap.layout-grid .doctor-card-hover-content {
	max-height: 0;
	opacity: 0;
	overflow: hidden;
	transition: max-height 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease;
}
.doctors-directory-wrap.layout-grid .directory-doctor-card:hover .doctor-card-hover-content {
	max-height: 160px;
	opacity: 1;
	margin-top: 12px;
}

.doctors-directory-wrap.layout-grid .doctor-card-experience {
	font-size: 0.82rem !important;
	color: rgba(255, 255, 255, 0.85) !important;
	line-height: 1.5 !important;
	margin: 0 0 10px 0 !important;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
	display: block !important;
}

.doctors-directory-wrap.layout-grid .doctor-card-quals-hover {
	display: block !important;
	font-size: 0.78rem !important;
	color: rgba(255, 255, 255, 0.72) !important;
	line-height: 1.5 !important;
	margin: 0 0 16px 0 !important;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
}

/* Actions buttons container */
.doctors-directory-wrap.layout-grid .doctor-card-actions {
	display: flex !important;
	gap: 10px !important;
	opacity: 0 !important;
	max-height: 0 !important;
	overflow: hidden !important;
	transition: max-height 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease !important;
}
.doctors-directory-wrap.layout-grid .directory-doctor-card:hover .doctor-card-actions {
	opacity: 1 !important;
	max-height: 80px !important;
	margin-top: 16px !important;
	overflow: visible !important;
}

.doctors-directory-wrap.layout-grid .doctor-card-actions .developer-starter-pro-btn {
	flex: 1 !important;
	justify-content: center !important;
	padding: 9px 12px !important;
	font-size: 0.75rem !important;
	font-weight: 600 !important;
	border-radius: 24px !important;
	white-space: nowrap !important;
}

.doctors-directory-wrap.layout-grid .doctor-card-actions .view-profile-btn {
	display: inline-flex !important;
	align-items: center !important;
	gap: 4px !important;
	background: transparent !important;
	border: 1px solid rgba(255, 255, 255, 0.35) !important;
	color: #FFFFFF !important;
	box-shadow: none !important;
	transition: all 0.25s ease !important;
}
.doctors-directory-wrap.layout-grid .doctor-card-actions .view-profile-btn:hover {
	background: rgba(255, 255, 255, 0.15) !important;
	border-color: #FFFFFF !important;
	gap: 8px !important;
}
.doctors-directory-wrap.layout-grid .doctor-card-actions .view-profile-btn svg.btn-arrow {
	transition: transform 0.25s ease;
	stroke: currentColor;
}
.doctors-directory-wrap.layout-grid .doctor-card-actions .view-profile-btn:hover svg.btn-arrow {
	transform: translateX(2px);
}

.doctors-directory-wrap.layout-grid .doctor-card-actions .book-now-btn {
	background: linear-gradient(135deg, var(--developer-starter-pro-primary), var(--developer-starter-pro-primary-dark)) !important;
	color: #FFFFFF !important;
	border: 1px solid rgba(255, 255, 255, 0.08) !important;
	box-shadow: 0 4px 12px rgba(78, 124, 89, 0.2) !important;
	transition: all 0.25s ease !important;
}
.doctors-directory-wrap.layout-grid .doctor-card-actions .book-now-btn:hover {
	box-shadow: 0 6px 20px rgba(78, 124, 89, 0.45) !important;
	transform: translateY(-1px);
}

/* --- LIST VIEW STYLES & OVERRIDES --- */
.doctors-directory-wrap.layout-list {
	display: flex;
	flex-direction: column;
	gap: 20px;
}

.doctors-directory-wrap.layout-list .directory-doctor-card {
	display: grid;
	grid-template-columns: 180px 1fr;
	background: var(--developer-starter-pro-white);
	border: 1px solid var(--developer-starter-pro-gray-200);
	border-radius: var(--developer-starter-pro-radius-lg);
	overflow: hidden;
	box-shadow: var(--developer-starter-pro-shadow-sm);
	transition: all 0.3s ease;
}

.doctors-directory-wrap.layout-list .doctor-card-overlay,
.doctors-directory-wrap.layout-list .doctor-card-social-overlay,
.doctors-directory-wrap.layout-list .doctor-card-num,
.doctors-directory-wrap.layout-list .spec-dot {
	display: none !important;
}

.doctors-directory-wrap.layout-list .doctor-card-photo {
	position: relative !important;
	height: 100% !important;
	width: auto !important;
	aspect-ratio: auto !important;
}

.doctors-directory-wrap.layout-list .doctor-card-photo img {
	width: 100% !important;
	height: 100% !important;
	object-fit: cover !important;
}

.doctors-directory-wrap.layout-list .doctor-card-body {
	padding: 30px;
	display: flex !important;
	flex-direction: row !important;
	justify-content: space-between;
	align-items: center;
	background: transparent !important;
	width: auto !important;
	border: none !important;
	box-shadow: none !important;
}

.doctors-directory-wrap.layout-list .doctor-card-body-inner {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
}

.doctors-directory-wrap.layout-list .doctor-card-spec {
	font-size: 0.8125rem !important;
	font-weight: 600 !important;
	color: var(--developer-starter-pro-primary) !important;
	text-transform: uppercase !important;
	text-shadow: none !important;
	margin-bottom: 0 !important;
}

.doctors-directory-wrap.layout-list .doctor-card-name {
	font-family: var(--developer-starter-pro-font-primary), -apple-system, BlinkMacSystemFont, sans-serif !important;
	font-size: 1.375rem !important;
	margin: 6px 0 10px !important;
	text-shadow: none !important;
}
.doctors-directory-wrap.layout-list .doctor-card-name a {
	color: var(--developer-starter-pro-secondary) !important;
}

.doctors-directory-wrap.layout-list .doctor-card-hover-content {
	max-height: none !important;
	opacity: 1 !important;
	margin-top: 0 !important;
	overflow: visible !important;
}

.doctors-directory-wrap.layout-list .doctor-card-experience {
	font-size: 0.875rem !important;
	color: var(--developer-starter-pro-gray-500) !important;
	display: block !important;
	margin-bottom: 8px !important;
	text-shadow: none !important;
}

.doctors-directory-wrap.layout-list .doctor-card-quals-hover {
	display: block !important;
	font-size: 0.9375rem !important;
	color: var(--developer-starter-pro-gray-400) !important;
	margin: 0 !important;
	line-height: 1.5 !important;
	max-width: 500px !important;
	text-shadow: none !important;
}

.doctors-directory-wrap.layout-list .doctor-card-actions {
	display: flex !important;
	flex-direction: column !important;
	gap: 10px !important;
	min-width: 150px !important;
	opacity: 1 !important;
	max-height: none !important;
	overflow: visible !important;
	margin-top: 0 !important;
}

.doctors-directory-wrap.layout-list .doctor-card-actions .developer-starter-pro-btn {
	width: 100% !important;
	justify-content: center !important;
	border-radius: 8px !important;
	padding: 8px 14px !important;
	font-size: 0.875rem !important;
}

.doctors-directory-wrap.layout-list .doctor-card-actions .view-profile-btn {
	background: transparent !important;
	border: 2px solid var(--developer-starter-pro-gray-200) !important;
	color: var(--developer-starter-pro-gray-600) !important;
	box-shadow: none !important;
}
.doctors-directory-wrap.layout-list .doctor-card-actions .view-profile-btn:hover {
	border-color: var(--developer-starter-pro-primary) !important;
	color: var(--developer-starter-pro-primary) !important;
}
.doctors-directory-wrap.layout-list .doctor-card-actions .view-profile-btn svg.btn-arrow {
	display: none !important;
}

.doctors-directory-wrap.layout-list .doctor-card-actions .book-now-btn {
	background: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
}

/* Hover effects */
.directory-doctor-card:hover {
	transform: translateY(-4px);
	box-shadow: var(--developer-starter-pro-shadow-md) !important;
	border-color: var(--developer-starter-pro-primary) !important;
}

body.dark-mode .directory-doctor-card {
	background: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode .layout-toggle,
body.dark-mode .layout-toggle button {
	background: #0F172A !important;
	border-color: #334155 !important;
	color: #CBD5E1 !important;
}
body.dark-mode .layout-toggle button.active {
	background: var(--developer-starter-pro-primary) !important;
	color: #fff !important;
}

@media (max-width: 768px) {
	.doctors-directory-wrap.layout-list .directory-doctor-card {
		grid-template-columns: 1fr;
	}
	.doctors-directory-wrap.layout-list .doctor-card-photo {
		aspect-ratio: 4/5;
	}
	.doctors-directory-wrap.layout-list .doctor-card-body {
		flex-direction: column !important;
		align-items: flex-start;
		gap: 20px;
	}
	.doctors-directory-wrap.layout-list .doctor-card-actions {
		width: 100%;
		flex-direction: row !important;
	}
}
</style>

<?php
get_footer();
