<?php
/**
 * Single Doctor Profile Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

$prefix      = '_developer_starter_pro_';
$speciality  = get_post_meta( get_the_ID(), $prefix . 'doctor_speciality', true );
$experience  = get_post_meta( get_the_ID(), $prefix . 'doctor_experience', true );
$quals       = get_post_meta( get_the_ID(), $prefix . 'doctor_qualifications', true );
$education   = get_post_meta( get_the_ID(), $prefix . 'doctor_education', true );
$phone       = get_post_meta( get_the_ID(), $prefix . 'doctor_phone', true );
$email       = get_post_meta( get_the_ID(), $prefix . 'doctor_email', true );
$schedule    = get_post_meta( get_the_ID(), $prefix . 'doctor_schedule', true );
$social      = get_post_meta( get_the_ID(), $prefix . 'doctor_social', true );
$departments = get_the_terms( get_the_ID(), 'department' );

$days_labels = array(
	'monday' => __( 'Monday', 'developer-starter-pro' ), 'tuesday' => __( 'Tuesday', 'developer-starter-pro' ),
	'wednesday' => __( 'Wednesday', 'developer-starter-pro' ), 'thursday' => __( 'Thursday', 'developer-starter-pro' ),
	'friday' => __( 'Friday', 'developer-starter-pro' ), 'saturday' => __( 'Saturday', 'developer-starter-pro' ),
	'sunday' => __( 'Sunday', 'developer-starter-pro' ),
);

if ( ! is_array( $schedule ) || empty( $schedule ) ) {
	$schedule = array();
	foreach ( $days_labels as $day_key => $day_label ) {
		$schedule[ $day_key ] = array(
			'available' => 'sunday' === $day_key ? '0' : '1',
			'start'     => '09:00',
			'end'       => '17:00',
		);
	}
}
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<nav class="developer-starter-pro-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'developer-starter-pro' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'developer-starter-pro' ); ?></a>
				<span class="sep">›</span>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'doctors' ) ); ?>"><?php esc_html_e( 'Doctors', 'developer-starter-pro' ); ?></a>
				<span class="sep">›</span>
				<span class="current"><?php the_title(); ?></span>
			</nav>
		</div>
	</div>

	<div class="developer-starter-pro-container">
		<article class="developer-starter-pro-doctor-profile">

			<!-- Doctor Header -->
			<div class="developer-starter-pro-doctor-profile-header">
				<div class="developer-starter-pro-doctor-profile-photo">
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
						<?php the_post_thumbnail( 'developer-starter-pro-doctor-large' ); ?>
					<?php else : ?>
						<img src="<?php echo esc_url( $default_img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
					<?php endif; ?>
				</div>

				<div class="developer-starter-pro-doctor-profile-info">
					<h1 class="developer-starter-pro-doctor-profile-name"><?php the_title(); ?></h1>

					<?php if ( $speciality ) : ?>
						<span class="developer-starter-pro-doctor-profile-spec">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
							<?php echo esc_html( $speciality ); ?>
						</span>
					<?php endif; ?>

					<?php if ( $departments && ! is_wp_error( $departments ) ) : ?>
						<div class="developer-starter-pro-doctor-profile-dept">
							<?php foreach ( $departments as $dept ) : ?>
								<span class="developer-starter-pro-tag"><?php echo esc_html( $dept->name ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php
					$comments = get_comments( array(
						'post_id' => get_the_ID(),
						'status'  => 'approve',
					) );

					$ratings_sum = 0;
					$ratings_count = 0;
					foreach ( $comments as $comment ) {
						$rating = get_comment_meta( $comment->comment_ID, 'rating', true );
						if ( $rating ) {
							$ratings_sum += intval( $rating );
							$ratings_count++;
						}
					}

					$average_rating = $ratings_count > 0 ? round( $ratings_sum / $ratings_count, 1 ) : 5.0;
					?>
					<div class="developer-starter-pro-doctor-profile-highlights">
						<?php if ( $experience ) : ?>
							<div class="highlight-item">
								<span class="highlight-number"><?php echo esc_html( $experience ); ?>+</span>
								<span class="highlight-label"><?php esc_html_e( 'Years Exp.', 'developer-starter-pro' ); ?></span>
							</div>
						<?php endif; ?>
						<div class="highlight-item">
							<span class="highlight-number">★ <?php echo number_format( $average_rating, 1 ); ?></span>
							<span class="highlight-label"><?php printf( esc_html( _n( '%s Review', '%s Reviews', $ratings_count, 'developer-starter-pro' ) ), number_format_i18n( $ratings_count ) ); ?></span>
						</div>
					</div>

					<div class="developer-starter-pro-doctor-profile-actions">
						<a href="<?php echo esc_url( add_query_arg( 'doctor_id', get_the_ID(), developer_starter_pro_get_booking_url() ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
							<?php esc_html_e( 'Book Appointment', 'developer-starter-pro' ); ?>
						</a>
						<?php if ( $phone ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72"/></svg>
								<?php esc_html_e( 'Call Doctor', 'developer-starter-pro' ); ?>
							</a>
						<?php endif; ?>
					</div>

					<?php if ( is_array( $social ) && ! empty( array_filter( $social ) ) ) : ?>
						<div class="developer-starter-pro-doctor-profile-social">
							<?php foreach ( $social as $platform => $url ) :
								if ( $url ) : ?>
									<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" class="developer-starter-pro-social-icon" aria-label="<?php echo esc_attr( ucfirst( $platform ) ); ?>">
										<?php echo developer_starter_pro_get_social_icon( $platform ); // phpcs:ignore ?>
									</a>
								<?php endif;
							endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Doctor Content Grid -->
			<div class="developer-starter-pro-doctor-profile-grid">

				<!-- Main Content -->
				<div class="developer-starter-pro-doctor-profile-main">

					<!-- About -->
					<div class="developer-starter-pro-card">
						<h2 class="developer-starter-pro-card-title"><?php esc_html_e( 'About', 'developer-starter-pro' ); ?></h2>
						<div class="developer-starter-pro-card-content">
							<?php the_content(); ?>
						</div>
					</div>

					<?php if ( $quals ) : ?>
					<!-- Qualifications -->
					<div class="developer-starter-pro-card">
						<h2 class="developer-starter-pro-card-title"><?php esc_html_e( 'Qualifications', 'developer-starter-pro' ); ?></h2>
						<ul class="developer-starter-pro-quals-list">
							<?php foreach ( explode( "\n", $quals ) as $qual ) :
								$qual = trim( $qual );
								if ( $qual ) : ?>
									<li>
										<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--developer-starter-pro-primary)" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
										<?php echo esc_html( $qual ); ?>
									</li>
								<?php endif;
							endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( $education ) : ?>
					<!-- Education -->
					<div class="developer-starter-pro-card">
						<h2 class="developer-starter-pro-card-title"><?php esc_html_e( 'Education', 'developer-starter-pro' ); ?></h2>
						<ul class="developer-starter-pro-education-list">
							<?php foreach ( explode( "\n", $education ) as $edu ) :
								$edu = trim( $edu );
								if ( $edu ) : ?>
									<li>
										<span class="edu-icon">🎓</span>
										<?php echo esc_html( $edu ); ?>
									</li>
								<?php endif;
							endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<!-- Patient Reviews Section -->
					<div class="developer-starter-pro-card doctor-reviews-card" id="reviews-section">
						<h2 class="developer-starter-pro-card-title"><?php esc_html_e( 'Patient Reviews', 'developer-starter-pro' ); ?></h2>
						
						<!-- List of Reviews -->
						<div class="doctor-reviews-list" style="margin-bottom: 40px; display:flex; flex-direction:column; gap:20px;">
							<?php if ( ! empty( $comments ) ) : ?>
								<?php foreach ( $comments as $comment ) :
									$comment_rating = get_comment_meta( $comment->comment_ID, 'rating', true );
									$stars = $comment_rating ? intval( $comment_rating ) : 5;
								?>
									<div class="review-item" style="border-bottom: 1px solid var(--developer-starter-pro-gray-100); padding-bottom: 20px;">
										<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 8px;">
											<strong style="color:var(--developer-starter-pro-secondary);"><?php echo esc_html( $comment->comment_author ); ?></strong>
											<span style="color:#f59e0b; font-size:0.9rem;"><?php echo str_repeat( '★', $stars ) . str_repeat( '☆', 5 - $stars ); ?></span>
										</div>
										<p style="margin: 0; font-size:0.9375rem; color:var(--developer-starter-pro-gray-500); line-height:1.6;"><?php echo esc_html( $comment->comment_content ); ?></p>
										<span style="font-size: 0.75rem; color: var(--developer-starter-pro-gray-400); margin-top: 6px; display:block;"><?php echo get_comment_date( '', $comment ); ?></span>
									</div>
								<?php endforeach; ?>
							<?php else : ?>
								<p style="color:var(--developer-starter-pro-gray-400); font-style:italic;"><?php esc_html_e( 'No reviews submitted yet. Be the first to review!', 'developer-starter-pro' ); ?></p>
							<?php endif; ?>
						</div>

						<!-- Review Form -->
						<div class="doctor-review-form-wrapper" style="background:var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 8px; padding: 30px;">
							<h3 style="margin-top:0; margin-bottom:20px; font-size:1.125rem; color:var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Write a Review', 'developer-starter-pro' ); ?></h3>
							
							<form action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>" method="post" id="commentform">
								<input type="hidden" name="comment_post_ID" value="<?php echo get_the_ID(); ?>" id="comment_post_ID">
								<input type="hidden" name="comment_parent" id="comment_parent" value="0">
								
								<div style="display:flex; flex-direction:column; gap:16px;">
									<!-- Star Rating Selection -->
									<div>
										<label style="display:block; font-weight:600; margin-bottom:8px;"><?php esc_html_e( 'Your Rating:', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
										<div class="star-rating-select" id="star-selector" style="display:flex; gap:8px; font-size:1.5rem; color:#f59e0b; cursor:pointer;">
											<span class="star-btn" data-val="1">★</span>
											<span class="star-btn" data-val="2">★</span>
											<span class="star-btn" data-val="3">★</span>
											<span class="star-btn" data-val="4">★</span>
											<span class="star-btn" data-val="5">★</span>
										</div>
										<input type="hidden" name="rating" id="selected-star-rating" value="5" required>
									</div>

									<?php if ( ! is_user_logged_in() ) : ?>
										<div class="form-row" style="display:flex; gap:16px;">
											<div style="flex:1;">
												<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Name', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
												<input type="text" name="author" required style="width:100%; padding:10px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:6px; background:#fff;">
											</div>
											<div style="flex:1;">
												<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Email', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
												<input type="email" name="email" required style="width:100%; padding:10px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:6px; background:#fff;">
											</div>
										</div>
									<?php endif; ?>

									<div>
										<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Your Review Comment', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
										<textarea name="comment" rows="4" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:6px; resize:vertical; background:#fff;"></textarea>
									</div>

									<div style="margin-top:10px;">
										<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="padding:12px 28px; font-weight:700;">
											<?php esc_html_e( 'Submit Review', 'developer-starter-pro' ); ?>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<script>
					document.addEventListener('DOMContentLoaded', function() {
						var stars = document.querySelectorAll('#star-selector .star-btn');
						var ratingInput = document.getElementById('selected-star-rating');
						
						stars.forEach(function(star) {
							star.addEventListener('click', function() {
								var val = parseInt(this.getAttribute('data-val'), 10);
								ratingInput.value = val;
								
								stars.forEach(function(s) {
									var sVal = parseInt(s.getAttribute('data-val'), 10);
									if (sVal <= val) {
										s.style.color = '#f59e0b';
									} else {
										s.style.color = '#cbd5e1';
									}
								});
							});
						});
					});
					</script>
				</div>

				<!-- Sidebar -->
				<div class="developer-starter-pro-doctor-profile-sidebar">

					<?php if ( is_array( $schedule ) && ! empty( $schedule ) ) : ?>
					<!-- Schedule -->
					<div class="developer-starter-pro-card">
						<h3 class="developer-starter-pro-card-title"><?php esc_html_e( 'Working Schedule', 'developer-starter-pro' ); ?></h3>
						<table class="developer-starter-pro-schedule-table">
							<?php foreach ( $days_labels as $day_key => $day_label ) :
								$is_available = isset( $schedule[ $day_key ]['available'] ) && '1' === $schedule[ $day_key ]['available'];
								$start = isset( $schedule[ $day_key ]['start'] ) ? $schedule[ $day_key ]['start'] : '';
								$end = isset( $schedule[ $day_key ]['end'] ) ? $schedule[ $day_key ]['end'] : '';
								$today = strtolower( current_time( 'l' ) );
							?>
								<tr class="<?php echo $today === $day_key ? 'today' : ''; ?>">
									<td class="day"><?php echo esc_html( $day_label ); ?></td>
									<td class="time">
										<?php if ( $is_available && $start && $end ) : ?>
											<?php echo esc_html( $start . ' - ' . $end ); ?>
										<?php else : ?>
											<span class="closed"><?php esc_html_e( 'Off', 'developer-starter-pro' ); ?></span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
					<?php endif; ?>

					<?php if ( $email ) : ?>
					<!-- Contact -->
					<div class="developer-starter-pro-card">
						<h3 class="developer-starter-pro-card-title"><?php esc_html_e( 'Contact', 'developer-starter-pro' ); ?></h3>
						<?php if ( $email ) : ?>
							<p><strong><?php esc_html_e( 'Email:', 'developer-starter-pro' ); ?></strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
						<?php endif; ?>
						<?php if ( $phone ) : ?>
							<p><strong><?php esc_html_e( 'Phone:', 'developer-starter-pro' ); ?></strong> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>

		</article>
	</div>
</main>

<style>
/* Doctor Profile Page */
.developer-starter-pro-page-banner {
	background: var(--developer-starter-pro-gray-50);
	padding: 20px 0;
	border-bottom: 1px solid var(--developer-starter-pro-gray-200);
}

.developer-starter-pro-breadcrumb {
	font-size: 0.875rem;
	color: var(--developer-starter-pro-gray-500);
}

.developer-starter-pro-breadcrumb a { color: var(--developer-starter-pro-gray-500); }
.developer-starter-pro-breadcrumb a:hover { color: var(--developer-starter-pro-primary); }
.developer-starter-pro-breadcrumb .sep { margin: 0 8px; }
.developer-starter-pro-breadcrumb .current { color: var(--developer-starter-pro-secondary); font-weight: 500; }

.developer-starter-pro-doctor-profile { padding: 48px 0; }

.developer-starter-pro-doctor-profile-header {
	display: flex;
	gap: 48px;
	margin-bottom: 48px;
	padding-bottom: 48px;
	border-bottom: 1px solid var(--developer-starter-pro-gray-200);
}

.developer-starter-pro-doctor-profile-photo {
	flex-shrink: 0;
	width: 350px;
	border-radius: var(--developer-starter-pro-radius-lg);
	overflow: hidden;
	box-shadow: var(--developer-starter-pro-shadow-xl);
}

.developer-starter-pro-doctor-profile-photo img {
	width: 100%;
	height: auto;
}

.developer-starter-pro-doctor-placeholder-lg {
	width: 100%;
	height: 400px;
	display: flex;
	align-items: center;
	justify-content: center;
	background: var(--developer-starter-pro-gray-100);
	color: var(--developer-starter-pro-gray-400);
}

.developer-starter-pro-doctor-profile-name {
	font-size: 2.25rem;
	margin-bottom: 8px;
}

.developer-starter-pro-doctor-profile-spec {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	color: var(--developer-starter-pro-primary);
	font-weight: 600;
	font-size: 1.0625rem;
	margin-bottom: 12px;
}

.developer-starter-pro-tag {
	display: inline-block;
	padding: 4px 14px;
	background: var(--developer-starter-pro-primary-light);
	color: var(--developer-starter-pro-primary);
	border-radius: var(--developer-starter-pro-radius-full);
	font-size: 0.8125rem;
	font-weight: 500;
	margin: 4px 4px 4px 0;
}

.developer-starter-pro-doctor-profile-highlights {
	display: flex;
	gap: 24px;
	margin: 20px 0;
}

.developer-starter-pro-doctor-profile-highlights .highlight-item {
	text-align: center;
	padding: 16px 24px;
	background: var(--developer-starter-pro-gray-50);
	border-radius: var(--developer-starter-pro-radius-md);
}

.highlight-number {
	display: block;
	font-family: var(--developer-starter-pro-font-heading);
	font-size: 1.5rem;
	font-weight: 700;
	color: var(--developer-starter-pro-primary);
}

.highlight-label {
	font-size: 0.75rem;
	color: var(--developer-starter-pro-gray-500);
	text-transform: uppercase;
}

.developer-starter-pro-doctor-profile-actions {
	display: flex;
	gap: 12px;
	margin: 20px 0;
}

.developer-starter-pro-doctor-profile-social {
	display: flex;
	gap: 8px;
}

.developer-starter-pro-doctor-profile-social .developer-starter-pro-social-icon {
	width: 40px;
	height: 40px;
	background: var(--developer-starter-pro-gray-100);
	color: var(--developer-starter-pro-gray-600);
}

.developer-starter-pro-doctor-profile-social .developer-starter-pro-social-icon:hover {
	background: var(--developer-starter-pro-primary);
	color: #fff;
}

/* Content Grid */
.developer-starter-pro-doctor-profile-grid {
	display: grid;
	grid-template-columns: 1fr 380px;
	gap: 32px;
}

.developer-starter-pro-card {
	background: var(--developer-starter-pro-white);
	border: 1px solid var(--developer-starter-pro-gray-200);
	border-radius: var(--developer-starter-pro-radius-lg);
	padding: 28px;
	margin-bottom: 24px;
}

.developer-starter-pro-card-title {
	font-size: 1.25rem;
	margin-bottom: 16px;
	padding-bottom: 12px;
	border-bottom: 2px solid var(--developer-starter-pro-primary-light);
}

.developer-starter-pro-quals-list,
.developer-starter-pro-education-list {
	list-style: none;
	padding: 0;
	margin: 0;
}

.developer-starter-pro-quals-list li,
.developer-starter-pro-education-list li {
	display: flex;
	align-items: center;
	gap: 10px;
	padding: 10px 0;
	border-bottom: 1px solid var(--developer-starter-pro-gray-100);
	font-size: 0.9375rem;
}

.developer-starter-pro-education-list li .edu-icon { font-size: 1.25rem; }

/* Schedule Table */
.developer-starter-pro-schedule-table {
	width: 100%;
	border-collapse: collapse;
}

.developer-starter-pro-schedule-table tr {
	border-bottom: 1px solid var(--developer-starter-pro-gray-100);
}

.developer-starter-pro-schedule-table td {
	padding: 10px 0;
	font-size: 0.875rem;
}

.developer-starter-pro-schedule-table .day { font-weight: 500; color: var(--developer-starter-pro-gray-700); }
.developer-starter-pro-schedule-table .time { text-align: right; color: var(--developer-starter-pro-gray-500); }
.developer-starter-pro-schedule-table .closed { color: var(--developer-starter-pro-danger); font-weight: 500; }
.developer-starter-pro-schedule-table tr.today { background: var(--developer-starter-pro-primary-light); border-radius: 6px; }
.developer-starter-pro-schedule-table tr.today .day { color: var(--developer-starter-pro-primary); }

@media (max-width: 768px) {
	.developer-starter-pro-doctor-profile-header { flex-direction: column; gap: 24px; }
	.developer-starter-pro-doctor-profile-photo { width: 100%; max-width: 300px; margin: 0 auto; }
	.developer-starter-pro-doctor-profile-grid { grid-template-columns: 1fr; }
	.developer-starter-pro-doctor-profile-name { font-size: 1.75rem; }
	.developer-starter-pro-doctor-profile-actions { flex-direction: column; }
}
</style>

<?php
get_footer();
