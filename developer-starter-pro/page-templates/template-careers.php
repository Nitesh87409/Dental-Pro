<?php
/**
 * Template Name: Careers Directory
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Join Our Team', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Explore job openings and build your clinical career with leading dental specialists.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Careers Content -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">
			
			<div class="careers-split" style="display: grid; grid-template-columns: 1fr 380px; gap: 40px; align-items: flex-start;">
				
				<!-- Openings list -->
				<div>
					<h2 style="font-size: 1.5rem; border-bottom: 2px solid var(--developer-starter-pro-primary-light); padding-bottom: 10px; margin-bottom: 24px; margin-top: 0;"><?php esc_html_e( 'Active Professional Openings', 'developer-starter-pro' ); ?></h2>
					
					<div class="jobs-list" style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px;">
						
						<!-- Job 1 -->
						<div class="job-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); transition: var(--developer-starter-pro-transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
								<h3 style="margin: 0; font-size: 1.25rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Senior Dental Assistant', 'developer-starter-pro' ); ?></h3>
								<span style="padding: 4px 12px; background: var(--developer-starter-pro-primary-light); color: var(--developer-starter-pro-primary); border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'Full-Time', 'developer-starter-pro' ); ?></span>
							</div>
							<p style="margin: 0 0 16px 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'We are looking for a certified dental assistant with 3+ years of experience. Duties include chairside surgical assistance, radiography support, autoclave operations, and maintaining patient charts.', 'developer-starter-pro' ); ?></p>
							<div style="font-size: 0.8125rem; color: var(--developer-starter-pro-gray-400); display: flex; gap: 16px;">
								<span>📍 <?php esc_html_e( 'Main Clinic Suite', 'developer-starter-pro' ); ?></span>
								<span>💰 <?php esc_html_e( '$25 - $32 / Hour', 'developer-starter-pro' ); ?></span>
							</div>
						</div>

						<!-- Job 2 -->
						<div class="job-card" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-lg); padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm); transition: var(--developer-starter-pro-transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
								<h3 style="margin: 0; font-size: 1.25rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Pediatric Orthodontist', 'developer-starter-pro' ); ?></h3>
								<span style="padding: 4px 12px; background: var(--developer-starter-pro-primary-light); color: var(--developer-starter-pro-primary); border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;"><?php esc_html_e( 'Contract', 'developer-starter-pro' ); ?></span>
							</div>
							<p style="margin: 0 0 16px 0; font-size: 0.9375rem; color: var(--developer-starter-pro-gray-500); line-height: 1.6;"><?php esc_html_e( 'Seeking a certified pediatric orthodontist to consult on alignment, spacing, braces, and Invisalign treatment cases for pediatric patients.', 'developer-starter-pro' ); ?></p>
							<div style="font-size: 0.8125rem; color: var(--developer-starter-pro-gray-400); display: flex; gap: 16px;">
								<span>📍 <?php esc_html_e( 'North Branch Suite', 'developer-starter-pro' ); ?></span>
								<span>💰 <?php esc_html_e( 'Competitive Commissions', 'developer-starter-pro' ); ?></span>
							</div>
						</div>

					</div>
				</div>

				<!-- Application Form sidebar -->
				<div>
					<div class="apply-form-card" style="background: var(--developer-starter-pro-gray-50); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 12px; padding: 30px; box-shadow: var(--developer-starter-pro-shadow-sm);">
						<h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--developer-starter-pro-secondary);"><?php esc_html_e( 'Submit Application', 'developer-starter-pro' ); ?></h3>
						
						<form action="#" method="post" enctype="multipart/form-data" onsubmit="alert('Application submitted successfully!'); return false;">
							<div style="display: flex; flex-direction: column; gap: 16px;">
								<div>
									<label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 6px;"><?php esc_html_e( 'Full Name', 'developer-starter-pro' ); ?> *</label>
									<input type="text" required style="width: 100%; padding: 10px; border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 6px; background: #fff;">
								</div>
								
								<div>
									<label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 6px;"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?> *</label>
									<input type="email" required style="width: 100%; padding: 10px; border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 6px; background: #fff;">
								</div>
								
								<div>
									<label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 6px;"><?php esc_html_e( 'Position Applied For', 'developer-starter-pro' ); ?> *</label>
									<select required style="width: 100%; padding: 10px; border: 1px solid var(--developer-starter-pro-gray-200); border-radius: 6px; background: #fff;">
										<option value="assistant"><?php esc_html_e( 'Senior Dental Assistant', 'developer-starter-pro' ); ?></option>
										<option value="orthodontist"><?php esc_html_e( 'Pediatric Orthodontist', 'developer-starter-pro' ); ?></option>
										<option value="receptionist"><?php esc_html_e( 'Clinic Coordinator', 'developer-starter-pro' ); ?></option>
									</select>
								</div>
								
								<div>
									<label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 6px;"><?php esc_html_e( 'Attach CV / Resume (PDF)', 'developer-starter-pro' ); ?> *</label>
									<input type="file" accept=".pdf" required style="width: 100%; font-size: 0.875rem;">
								</div>
								
								<div style="margin-top: 10px;">
									<button type="submit" class="developer-starter-pro-btn developer-starter-pro-btn--primary" style="width: 100%; justify-content: center; font-weight: 700;">
										<?php esc_html_e( 'Send Application', 'developer-starter-pro' ); ?>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>

		</div>
	</section>

</main>

<style>
.job-card:hover {
	transform: translateY(-4px);
	box-shadow: var(--developer-starter-pro-shadow-md) !important;
	border-color: var(--developer-starter-pro-primary) !important;
}
body.dark-mode .job-card,
body.dark-mode .apply-form-card {
	background: #1E293B !important;
	border-color: #334155 !important;
}
body.dark-mode .apply-form-card input,
body.dark-mode .apply-form-card select {
	background: #0F172A !important;
	border-color: #334155 !important;
	color: #F8FAFC !important;
}
@media (max-width: 991px) {
	.careers-split {
		grid-template-columns: 1fr;
	}
}
</style>

<?php
get_footer();
