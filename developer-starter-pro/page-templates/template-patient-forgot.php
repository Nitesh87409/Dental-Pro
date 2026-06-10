<?php
/**
 * Template Name: Patient Portal - Forgot Password
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
$status = sanitize_text_field( $_GET['status'] ?? '' );
$error_message = '';
$success_message = '';

if ( 'missing_fields' === $err ) {
	$error_message = esc_html__( 'Please enter your email address.', 'developer-starter-pro' );
} elseif ( 'invalid_email' === $err ) {
	$error_message = esc_html__( 'Invalid email format.', 'developer-starter-pro' );
} elseif ( 'user_not_found' === $err ) {
	$error_message = esc_html__( 'No registered account found with that email.', 'developer-starter-pro' );
} elseif ( 'success' === $status ) {
	$success_message = esc_html__( 'A secure password reset link has been sent to your email address.', 'developer-starter-pro' );
}
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Account Recovery', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php esc_html_e( 'Forgot Password', 'developer-starter-pro' ); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Enter your registered email address to recover your account credentials.', 'developer-starter-pro' ); ?></p>
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

				<?php if ( $success_message ) : ?>
					<div class="portal-success-banner" style="background:#d1fae5; border:1px solid #a7f3d0; color:#065f46; border-radius:8px; padding:16px; margin-bottom:24px; font-weight:500;">
						<?php echo esc_html( $success_message ); ?>
					</div>
				<?php endif; ?>

				<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
					<input type="hidden" name="action" value="dentalpro_patient_forgot_password">
					<?php wp_nonce_field( 'dentalpro_forgot_action', 'forgot_nonce' ); ?>

					<div style="display:flex; flex-direction:column; gap:20px;">
						<div>
							<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
							<input type="email" name="patient_email" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;" placeholder="e.g. yourname@example.com">
						</div>

						<div style="margin-top:10px;">
							<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="width:100%; padding:14px; font-size:1.0625rem; font-weight:700; justify-content:center;">
								<?php esc_html_e( 'Send Reset Link', 'developer-starter-pro' ); ?>
							</button>
						</div>
					</div>
				</form>

				<div style="text-align:center; margin-top:24px; color:var(--developer-starter-pro-gray-500); font-size:0.9375rem;">
					<a href="<?php echo esc_url( home_url( '/patient-login/' ) ); ?>" style="color:var(--developer-starter-pro-primary); font-weight:600; text-decoration:none;">
						← <?php esc_html_e( 'Back to Login', 'developer-starter-pro' ); ?>
					</a>
				</div>

			</div>
		</div>
	</section>

</main>

<?php
get_footer();
