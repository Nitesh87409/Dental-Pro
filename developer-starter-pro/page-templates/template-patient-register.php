<?php
/**
 * Template Name: Patient Portal - Register
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
	$error_message = esc_html__( 'Please fill in all required fields.', 'developer-starter-pro' );
} elseif ( 'invalid_email' === $err ) {
	$error_message = esc_html__( 'Please provide a valid email address.', 'developer-starter-pro' );
} elseif ( 'email_exists' === $err ) {
	$error_message = esc_html__( 'This email address is already registered. Please log in.', 'developer-starter-pro' );
} elseif ( 'registration_failed' === $err ) {
	$error_message = esc_html__( 'An error occurred during registration. Please try again.', 'developer-starter-pro' );
}
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Patient Portal', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php esc_html_e( 'Patient Registration', 'developer-starter-pro' ); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Create your secure account to manage clinical appointments and medical profiles.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container" style="max-width: 550px;">
			<div class="developer-starter-pro-portal-card" style="background:#fff; border:1px solid var(--developer-starter-pro-gray-200); border-radius:16px; padding: 40px; box-shadow: var(--developer-starter-pro-shadow-lg);">
				
				<?php if ( $error_message ) : ?>
					<div class="portal-error-banner" style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:8px; padding:16px; margin-bottom:24px; font-weight:500;">
						<?php echo esc_html( $error_message ); ?>
					</div>
				<?php endif; ?>

				<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
					<input type="hidden" name="action" value="dentalpro_patient_register">
					<?php wp_nonce_field( 'dentalpro_register_action', 'register_nonce' ); ?>

					<div style="display:flex; flex-direction:column; gap:20px;">
						<div>
							<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Full Name', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
							<input type="text" name="patient_name" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;" placeholder="e.g. John Doe">
						</div>

						<div>
							<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
							<input type="email" name="patient_email" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;" placeholder="e.g. johndoe@example.com">
						</div>

						<div>
							<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Choose Password', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
							<input type="password" name="patient_password" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;" placeholder="Min. 8 characters">
						</div>

						<div style="display:flex; gap:16px;">
							<div style="flex:1;">
								<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Phone Number', 'developer-starter-pro' ); ?> <span style="color:var(--developer-starter-pro-danger);">*</span></label>
								<input type="tel" name="patient_phone" required style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem;" placeholder="e.g. +123456789">
							</div>
							<div style="flex:1;">
								<label style="display:block; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Date of Birth', 'developer-starter-pro' ); ?></label>
								<input type="date" name="patient_dob" style="width:100%; padding:12px; border:2px solid var(--developer-starter-pro-gray-200); border-radius:8px; font-size:1rem; font-family:inherit;">
							</div>
						</div>

						<div style="margin-top:10px;">
							<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="width:100%; padding:14px; font-size:1.0625rem; font-weight:700;">
								<?php esc_html_e( 'Create Account', 'developer-starter-pro' ); ?>
							</button>
						</div>
					</div>
				</form>

				<div style="text-align:center; margin-top:24px; color:var(--developer-starter-pro-gray-500); font-size:0.9375rem;">
					<?php esc_html_e( 'Already have an account?', 'developer-starter-pro' ); ?> 
					<a href="<?php echo esc_url( Developer_Starter_Pro_Portal::get_login_url() ); ?>" style="color:var(--developer-starter-pro-primary); font-weight:600; text-decoration:none;">
						<?php esc_html_e( 'Log In Here', 'developer-starter-pro' ); ?>
					</a>
				</div>

			</div>
		</div>
	</section>

</main>

<?php
get_footer();
