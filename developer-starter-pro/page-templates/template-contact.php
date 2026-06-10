<?php
/**
 * Template Name: Contact Us
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();

$clinic_phone   = developer_starter_pro_get_option( 'clinic_phone', '' );
$clinic_email   = developer_starter_pro_get_option( 'clinic_email', '' );
$clinic_address = developer_starter_pro_get_option( 'clinic_address', '' );
$emergency_phone = developer_starter_pro_get_option( 'emergency_phone', '' );
$google_maps_key = developer_starter_pro_get_option( 'google_maps_key', '' );
$working_hours  = developer_starter_pro_get_working_hours();

$days = array(
	'monday'    => __( 'Monday', 'developer-starter-pro' ),
	'tuesday'   => __( 'Tuesday', 'developer-starter-pro' ),
	'wednesday' => __( 'Wednesday', 'developer-starter-pro' ),
	'thursday'  => __( 'Thursday', 'developer-starter-pro' ),
	'friday'    => __( 'Friday', 'developer-starter-pro' ),
	'saturday'  => __( 'Saturday', 'developer-starter-pro' ),
	'sunday'    => __( 'Sunday', 'developer-starter-pro' ),
);
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Get in Touch', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Have a question or want to schedule a visit? Reach out to our friendly clinic staff.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Contact Content Grid -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-contact-grid">
				
				<!-- Contact Info Block -->
				<div class="developer-starter-pro-contact-info">
					<div class="developer-starter-pro-card" style="margin-bottom: 24px;">
						<h2 class="developer-starter-pro-card-title"><?php esc_html_e( 'Contact Channels', 'developer-starter-pro' ); ?></h2>
						<ul class="developer-starter-pro-contact-details-list" style="list-style:none; padding:0; margin:0;">
							<?php if ( $clinic_address ) : ?>
								<li style="display:flex; gap:16px; margin-bottom: 20px;">
									<span class="contact-icon" style="font-size:1.5rem; background: var(--developer-starter-pro-primary-light); width: 44px; height: 44px; display:flex; align-items:center; justify-content:center; border-radius:50%; color:var(--developer-starter-pro-primary);">📍</span>
									<div>
										<strong><?php esc_html_e( 'Location Address', 'developer-starter-pro' ); ?></strong>
										<p style="margin: 4px 0 0; color: var(--developer-starter-pro-gray-500);"><?php echo esc_html( $clinic_address ); ?></p>
									</div>
								</li>
							<?php endif; ?>
							<?php if ( $clinic_phone ) : ?>
								<li style="display:flex; gap:16px; margin-bottom: 20px;">
									<span class="contact-icon" style="font-size:1.5rem; background: var(--developer-starter-pro-primary-light); width: 44px; height: 44px; display:flex; align-items:center; justify-content:center; border-radius:50%; color:var(--developer-starter-pro-primary);">📞</span>
									<div>
										<strong><?php esc_html_e( 'Phone Line', 'developer-starter-pro' ); ?></strong>
										<p style="margin: 4px 0 0;"><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $clinic_phone ) ); ?>" style="color: var(--developer-starter-pro-gray-500);"><?php echo esc_html( $clinic_phone ); ?></a></p>
									</div>
								</li>
							<?php endif; ?>
							<?php if ( $clinic_email ) : ?>
								<li style="display:flex; gap:16px; margin-bottom: 20px;">
									<span class="contact-icon" style="font-size:1.5rem; background: var(--developer-starter-pro-primary-light); width: 44px; height: 44px; display:flex; align-items:center; justify-content:center; border-radius:50%; color:var(--developer-starter-pro-primary);">✉️</span>
									<div>
										<strong><?php esc_html_e( 'Email Inbox', 'developer-starter-pro' ); ?></strong>
										<p style="margin: 4px 0 0;"><a href="mailto:<?php echo esc_attr( $clinic_email ); ?>" style="color: var(--developer-starter-pro-gray-500);"><?php echo esc_html( $clinic_email ); ?></a></p>
									</div>
								</li>
							<?php endif; ?>
							<?php if ( $emergency_phone ) : ?>
								<li style="display:flex; gap:16px; padding-top: 16px; border-top: 1px solid var(--developer-starter-pro-gray-200);">
									<span class="contact-icon" style="font-size:1.5rem; background: #fee2e2; width: 44px; height: 44px; display:flex; align-items:center; justify-content:center; border-radius:50%; color:var(--developer-starter-pro-danger);">🚨</span>
									<div>
										<strong style="color: var(--developer-starter-pro-danger);"><?php esc_html_e( 'Emergency Line (24/7)', 'developer-starter-pro' ); ?></strong>
										<p style="margin: 4px 0 0;"><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $emergency_phone ) ); ?>" style="color: var(--developer-starter-pro-danger); font-weight:700;"><?php echo esc_html( $emergency_phone ); ?></a></p>
									</div>
								</li>
							<?php endif; ?>
						</ul>
					</div>

					<div class="developer-starter-pro-card">
						<h3 class="developer-starter-pro-card-title"><?php esc_html_e( 'Working Hours', 'developer-starter-pro' ); ?></h3>
						<table class="developer-starter-pro-schedule-table" style="width:100%; border-collapse:collapse;">
							<?php foreach ( $days as $day_key => $day_label ) :
								$is_closed = isset( $working_hours[ $day_key ]['closed'] ) && $working_hours[ $day_key ]['closed'];
								$open   = isset( $working_hours[ $day_key ]['open'] ) ? $working_hours[ $day_key ]['open'] : '';
								$close  = isset( $working_hours[ $day_key ]['close'] ) ? $working_hours[ $day_key ]['close'] : '';
								$today = strtolower( current_time( 'l' ) );
							?>
								<tr class="<?php echo $today === $day_key ? 'today' : ''; ?>" style="border-bottom: 1px solid var(--developer-starter-pro-gray-100);">
									<td style="padding:10px 0; font-weight: 500;"><?php echo esc_html( $day_label ); ?></td>
									<td style="padding:10px 0; text-align: right; color: var(--developer-starter-pro-gray-500);">
										<?php if ( $is_closed ) : ?>
											<span class="closed" style="color: var(--developer-starter-pro-danger); font-weight: 600;"><?php esc_html_e( 'Closed', 'developer-starter-pro' ); ?></span>
										<?php else : ?>
											<?php echo esc_html( $open . ' - ' . $close ); ?>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>

				<!-- Form Block -->
				<div class="developer-starter-pro-contact-form">
					<div class="developer-starter-pro-card">
						<h2 class="developer-starter-pro-card-title"><?php esc_html_e( 'Send Us a Message', 'developer-starter-pro' ); ?></h2>
						<form class="developer-starter-pro-contact-inquiry-form" action="#" method="post" style="display:flex; flex-direction:column; gap:16px;">
							<div class="form-row" style="display:flex; gap:16px;">
								<div style="flex:1;">
									<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Your Name', 'developer-starter-pro' ); ?> <span class="required" style="color:var(--developer-starter-pro-danger);">*</span></label>
									<input type="text" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;" required>
								</div>
								<div style="flex:1;">
									<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Your Email', 'developer-starter-pro' ); ?> <span class="required" style="color:var(--developer-starter-pro-danger);">*</span></label>
									<input type="email" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;" required>
								</div>
							</div>
							<div>
								<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Phone Number', 'developer-starter-pro' ); ?></label>
								<input type="tel" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;">
							</div>
							<div>
								<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Subject', 'developer-starter-pro' ); ?> <span class="required" style="color:var(--developer-starter-pro-danger);">*</span></label>
								<input type="text" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;" required>
							</div>
							<div>
								<label style="display:block; font-weight:500; margin-bottom:6px;"><?php esc_html_e( 'Your Message', 'developer-starter-pro' ); ?> <span class="required" style="color:var(--developer-starter-pro-danger);">*</span></label>
								<textarea rows="4" style="width:100%; padding:10px; border:1px solid var(--developer-starter-pro-gray-200); border-radius:6px;" required></textarea>
							</div>
							<div>
								<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary">
									<?php esc_html_e( 'Send Message', 'developer-starter-pro' ); ?>
								</button>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- Map Section -->
	<?php if ( ! empty( $clinic_address ) ) : ?>
		<section class="developer-starter-pro-map-section" style="height: 450px; position:relative; overflow:hidden;">
			<?php if ( ! empty( $google_maps_key ) ) : ?>
				<iframe 
					width="100%" 
					height="100%" 
					style="border:0;" 
					loading="lazy" 
					allowfullscreen 
					src="https://www.google.com/maps/embed/v1/place?key=<?php echo esc_attr( $google_maps_key ); ?>&q=<?php echo urlencode( $clinic_address ); ?>">
				</iframe>
			<?php else : ?>
				<!-- Standard OpenStreetMap/No-key fallback to prevent visual collapse -->
				<iframe 
					width="100%" 
					height="100%" 
					style="border:0;" 
					loading="lazy" 
					allowfullscreen 
					src="https://maps.google.com/maps?q=<?php echo urlencode( $clinic_address ); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed">
				</iframe>
			<?php endif; ?>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
