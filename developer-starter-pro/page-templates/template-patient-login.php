<?php
/**
 * Template Name: Patient Portal - Login
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Redirect if already logged in
if ( is_user_logged_in() ) {
	wp_safe_redirect( Developer_Starter_Pro_Portal::get_dashboard_url() );
	exit;
}

get_header();

$err = sanitize_text_field( $_GET['err'] ?? '' );
$error_message = '';

if ( 'missing_fields' === $err ) {
	$error_message = esc_html__( 'Please fill in both fields.', 'developer-starter-pro' );
} elseif ( 'invalid_credentials' === $err ) {
	$error_message = esc_html__( 'Invalid email or password. Please try again.', 'developer-starter-pro' );
}
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Patient Portal', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php esc_html_e( 'Patient Sign In', 'developer-starter-pro' ); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Access your upcoming appointments, medical history, and clinical summaries.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container" style="max-width: 480px;">
			<div class="developer-starter-pro-portal-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:16px; padding: 40px; box-shadow: var(--developer-starter-pro-shadow-lg);">
				
				<?php if ( $error_message ) : ?>
					<div class="portal-error-banner" style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:8px; padding:16px; margin-bottom:24px; font-weight:500;">
						<?php echo esc_html( $error_message ); ?>
					</div>
				<?php endif; ?>

				<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
					<input type="hidden" name="action" value="dentalpro_patient_login">
					<?php wp_nonce_field( 'dentalpro_login_action', 'login_nonce' ); ?>

					<div style="display:flex; flex-direction:column; gap:20px;">
						<div>
							<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
							<input type="email" name="patient_email" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;" placeholder="e.g. yourname@example.com">
						</div>

						<div>
							<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Password', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
							<input type="password" name="patient_password" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;" placeholder="••••••••">
						</div>

						<div style="display:flex; align-items:center; justify-content:space-between; font-size:0.875rem;">
							<label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer;">
								<input type="checkbox" name="patient_remember" style="width:16px; height:16px; accent-color:var(--developer-starter-pro-primary);">
								<?php esc_html_e( 'Remember Me', 'developer-starter-pro' ); ?>
							</label>
							<a href="<?php echo esc_url( Developer_Starter_Pro_Portal::get_forgot_url() ); ?>" style="color:var(--developer-starter-pro-gray-500); text-decoration:none;">
								<?php esc_html_e( 'Forgot Password?', 'developer-starter-pro' ); ?>
							</a>
						</div>

						<div style="margin-top:10px;">
							<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="width:100%; padding:14px; font-size:1.0625rem; font-weight:700;">
								<?php esc_html_e( 'Sign In', 'developer-starter-pro' ); ?>
							</button>
						</div>
					</div>
				</form>

				<div style="text-align:center; margin-top:24px; color:var(--developer-starter-pro-gray-500); font-size:0.9375rem;">
					<?php esc_html_e( 'New patient?', 'developer-starter-pro' ); ?> 
					<a href="<?php echo esc_url( home_url( '/patient-register/' ) ); ?>" style="color:var(--developer-starter-pro-primary); font-weight:600; text-decoration:none;">
						<?php esc_html_e( 'Register Account Here', 'developer-starter-pro' ); ?>
					</a>
				</div>

			</div>
		</div>
	</section>

</main>

<?php
get_footer();
