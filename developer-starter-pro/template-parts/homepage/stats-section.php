<?php
/**
 * Template Part: Homepage Stats Counter Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Retrieve stats settings from custom options panel with safe default fallbacks
$stat1_icon   = developer_starter_pro_get_option( 'stat1_icon', '🏆' );
$stat1_number = developer_starter_pro_get_option( 'stat1_number', '10+' );
$stat1_label  = developer_starter_pro_get_option( 'stat1_label', 'Years Experience' );

$stat2_icon   = developer_starter_pro_get_option( 'stat2_icon', '😊' );
$stat2_number = developer_starter_pro_get_option( 'stat2_number', '5000+' );
$stat2_label  = developer_starter_pro_get_option( 'stat2_label', 'Happy Patients' );

$stat3_icon   = developer_starter_pro_get_option( 'stat3_icon', '👨‍⚕️' );
$stat3_number = developer_starter_pro_get_option( 'stat3_number', '50+' );
$stat3_label  = developer_starter_pro_get_option( 'stat3_label', 'Dental Specialists' );

$stat4_icon   = developer_starter_pro_get_option( 'stat4_icon', '📍' );
$stat4_number = developer_starter_pro_get_option( 'stat4_number', '15+' );
$stat4_label  = developer_starter_pro_get_option( 'stat4_label', 'Clinic Locations' );
?>

<section class="developer-starter-pro-section stats-counter-section" id="stats">
	<div class="developer-starter-pro-container">
		<div class="stats-counter-grid">
			
			<div class="stat-card">
				<div class="stat-icon" style="font-size: 2.5rem; margin-bottom: 15px;"><?php echo esc_html( $stat1_icon ); ?></div>
				<h3 class="stat-number" style="font-family: var(--developer-starter-pro-font-heading); font-size: 3rem; font-weight: 800; margin: 0 0 8px 0; line-height: 1;"><?php echo esc_html( $stat1_number ); ?></h3>
				<p class="stat-label" style="font-size: 0.875rem; text-transform: uppercase; font-weight: 700; margin: 0; letter-spacing: 0.05em;"><?php echo esc_html( $stat1_label ); ?></p>
			</div>

			<div class="stat-card">
				<div class="stat-icon" style="font-size: 2.5rem; margin-bottom: 15px;"><?php echo esc_html( $stat2_icon ); ?></div>
				<h3 class="stat-number" style="font-family: var(--developer-starter-pro-font-heading); font-size: 3rem; font-weight: 800; margin: 0 0 8px 0; line-height: 1;"><?php echo esc_html( $stat2_number ); ?></h3>
				<p class="stat-label" style="font-size: 0.875rem; text-transform: uppercase; font-weight: 700; margin: 0; letter-spacing: 0.05em;"><?php echo esc_html( $stat2_label ); ?></p>
			</div>

			<div class="stat-card">
				<div class="stat-icon" style="font-size: 2.5rem; margin-bottom: 15px;"><?php echo esc_html( $stat3_icon ); ?></div>
				<h3 class="stat-number" style="font-family: var(--developer-starter-pro-font-heading); font-size: 3rem; font-weight: 800; margin: 0 0 8px 0; line-height: 1;"><?php echo esc_html( $stat3_number ); ?></h3>
				<p class="stat-label" style="font-size: 0.875rem; text-transform: uppercase; font-weight: 700; margin: 0; letter-spacing: 0.05em;"><?php echo esc_html( $stat3_label ); ?></p>
			</div>

			<div class="stat-card">
				<div class="stat-icon" style="font-size: 2.5rem; margin-bottom: 15px;"><?php echo esc_html( $stat4_icon ); ?></div>
				<h3 class="stat-number" style="font-family: var(--developer-starter-pro-font-heading); font-size: 3rem; font-weight: 800; margin: 0 0 8px 0; line-height: 1;"><?php echo esc_html( $stat4_number ); ?></h3>
				<p class="stat-label" style="font-size: 0.875rem; text-transform: uppercase; font-weight: 700; margin: 0; letter-spacing: 0.05em;"><?php echo esc_html( $stat4_label ); ?></p>
			</div>

		</div>
	</div>
</section>
