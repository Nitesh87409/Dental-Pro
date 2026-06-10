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
							<div class="doctor-card-photo">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'developer-starter-pro-doctor-thumb' ); ?>
								<?php else : ?>
									<div class="doctor-card-placeholder">👨‍⚕️</div>
								<?php endif; ?>
							</div>
							
							<div class="doctor-card-body">
								<div>
									<span class="doctor-card-spec"><?php echo esc_html( $spec ? $spec : __( 'General Practitioner', 'developer-starter-pro' ) ); ?></span>
									<h3 class="doctor-card-name">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<?php if ( $experience ) : ?>
										<span class="doctor-card-experience">⏱ <?php printf( esc_html__( '%s Years Experience', 'developer-starter-pro' ), esc_html( $experience ) ); ?></span>
									<?php endif; ?>
									<?php if ( $quals ) : ?>
										<p class="doctor-card-quals"><?php echo esc_html( wp_trim_words( $quals, 10, '...' ) ); ?></p>
									<?php endif; ?>
								</div>
								
								<div class="doctor-card-actions">
									<a href="<?php the_permalink(); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--outline">
										<?php esc_html_e( 'View Profile', 'developer-starter-pro' ); ?>
									</a>
									<a href="<?php echo esc_url( add_query_arg( 'doctor_id', get_the_ID(), developer_starter_pro_get_booking_url() ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--sm developer-starter-pro-btn--primary">
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
.doctors-directory-wrap.layout-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
	gap: 30px;
}
.doctors-directory-wrap.layout-grid .directory-doctor-card {
	display: flex;
	flex-direction: column;
	background: var(--developer-starter-pro-white);
	border: 1px solid var(--developer-starter-pro-gray-200);
	border-radius: var(--developer-starter-pro-radius-lg);
	overflow: hidden;
	box-shadow: var(--developer-starter-pro-shadow-sm);
	transition: all 0.3s ease;
}
.doctors-directory-wrap.layout-grid .doctor-card-photo {
	aspect-ratio: 4/5;
	overflow: hidden;
}
.doctors-directory-wrap.layout-grid .doctor-card-photo img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}
.doctors-directory-wrap.layout-grid .doctor-card-placeholder {
	width: 100%;
	height: 100%;
	background: var(--developer-starter-pro-gray-100);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 2.5rem;
}
.doctors-directory-wrap.layout-grid .doctor-card-body {
	padding: 24px;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	flex-grow: 1;
}
.doctors-directory-wrap.layout-grid .doctor-card-spec {
	font-size: 0.8125rem;
	font-weight: 600;
	color: var(--developer-starter-pro-primary);
	text-transform: uppercase;
}
.doctors-directory-wrap.layout-grid .doctor-card-name {
	font-size: 1.1875rem;
	margin: 6px 0 10px;
}
.doctors-directory-wrap.layout-grid .doctor-card-name a {
	color: var(--developer-starter-pro-secondary);
	text-decoration: none;
}
.doctors-directory-wrap.layout-grid .doctor-card-experience {
	font-size: 0.8125rem;
	color: var(--developer-starter-pro-gray-500);
	display: block;
	margin-bottom: 8px;
}
.doctors-directory-wrap.layout-grid .doctor-card-quals {
	font-size: 0.875rem;
	color: var(--developer-starter-pro-gray-400);
	margin: 0 0 20px 0;
	line-height: 1.5;
}
.doctors-directory-wrap.layout-grid .doctor-card-actions {
	display: flex;
	gap: 10px;
}
.doctors-directory-wrap.layout-grid .doctor-card-actions a {
	flex: 1;
	justify-content: center;
}

/* LIST VIEW */
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
.doctors-directory-wrap.layout-list .doctor-card-photo {
	height: 100%;
}
.doctors-directory-wrap.layout-list .doctor-card-photo img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}
.doctors-directory-wrap.layout-list .doctor-card-placeholder {
	width: 100%;
	height: 100%;
	background: var(--developer-starter-pro-gray-100);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 2.5rem;
}
.doctors-directory-wrap.layout-list .doctor-card-body {
	padding: 30px;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.doctors-directory-wrap.layout-list .doctor-card-spec {
	font-size: 0.8125rem;
	font-weight: 600;
	color: var(--developer-starter-pro-primary);
	text-transform: uppercase;
}
.doctors-directory-wrap.layout-list .doctor-card-name {
	font-size: 1.375rem;
	margin: 6px 0 10px;
}
.doctors-directory-wrap.layout-list .doctor-card-name a {
	color: var(--developer-starter-pro-secondary);
	text-decoration: none;
}
.doctors-directory-wrap.layout-list .doctor-card-experience {
	font-size: 0.875rem;
	color: var(--developer-starter-pro-gray-500);
	display: block;
	margin-bottom: 8px;
}
.doctors-directory-wrap.layout-list .doctor-card-quals {
	font-size: 0.9375rem;
	color: var(--developer-starter-pro-gray-400);
	margin: 0;
	line-height: 1.5;
	max-width: 500px;
}
.doctors-directory-wrap.layout-list .doctor-card-actions {
	display: flex;
	flex-direction: column;
	gap: 10px;
	min-width: 150px;
}
.doctors-directory-wrap.layout-list .doctor-card-actions a {
	width: 100%;
	justify-content: center;
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
body.dark-mode .filter-btn {
	border-color: #334155;
	color: #CBD5E1;
}
body.dark-mode .filter-btn.active {
	background: var(--developer-starter-pro-primary) !important;
	border-color: var(--developer-starter-pro-primary) !important;
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
		flex-direction: column;
		align-items: flex-start;
		gap: 20px;
	}
	.doctors-directory-wrap.layout-list .doctor-card-actions {
		width: 100%;
		flex-direction: row;
	}
}
</style>

<?php
get_footer();
