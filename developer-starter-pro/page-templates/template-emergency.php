<?php
/**
 * Template Name: Emergency Care
 * @package developer-starter-pro
 */
$options = get_option('developer_starter_pro_options', []);
$emergency_phone = !empty($options['emergency_phone']) ? $options['emergency_phone'] : '+1 (800) 000-0000';
get_header(); ?>
<main id="primary" class="developer-starter-pro-main">
<div style="background:#DC2626;color:#fff;padding:20px 0;text-align:center;">
<div class="developer-starter-pro-container">
<h2 style="margin:0;font-size:1.25rem;">🚨 <?php esc_html_e('DENTAL EMERGENCY? Call Now:', 'developer-starter-pro'); ?>
<a href="tel:<?php echo esc_attr($emergency_phone); ?>" style="color:#fff;font-size:1.5rem;font-weight:900;margin-left:12px;"><?php echo esc_html($emergency_phone); ?></a></h2>
</div>
</div>
<div class="developer-starter-pro-container" style="padding:60px 0;">
<div style="text-align:center;margin-bottom:48px;">
<h1><?php esc_html_e('Emergency Dental Care', 'developer-starter-pro'); ?></h1>
<p><?php esc_html_e('We are available 24/7 for dental emergencies. Do not wait — call us immediately.', 'developer-starter-pro'); ?></p>
</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-bottom:48px;">
<div>
<h2><?php esc_html_e('Common Dental Emergencies', 'developer-starter-pro'); ?></h2>
<?php
$emergencies = [
    '🦷 Severe toothache or tooth pain',
    '💔 Cracked or broken tooth',
    '🩸 Knocked out tooth',
    '🔴 Dental abscess or swelling',
    '🩹 Lost filling or crown',
    '😬 Broken braces or wires',
    '🤕 Jaw injury or trauma',
    '🔥 Soft tissue injury or bleeding',
];
foreach($emergencies as $e): ?>
<div style="display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid #e2e8f0;">
<span style="font-size:1.1rem;"><?php echo $e; ?></span>
</div>
<?php endforeach; ?>
</div>
<div>
<div style="background:#FEE2E2;border:2px solid #DC2626;border-radius:16px;padding:32px;text-align:center;margin-bottom:24px;">
<div style="font-size:3rem;margin-bottom:12px;">📞</div>
<h3 style="color:#DC2626;margin:0 0 8px;font-size:1.25rem;"><?php esc_html_e('Emergency Hotline', 'developer-starter-pro'); ?></h3>
<a href="tel:<?php echo esc_attr($emergency_phone); ?>" style="display:block;font-size:2rem;font-weight:900;color:#DC2626;text-decoration:none;"><?php echo esc_html($emergency_phone); ?></a>
<p style="margin:8px 0 0;color:#64748b;"><?php esc_html_e('Available 24 hours, 7 days a week', 'developer-starter-pro'); ?></p>
</div>
<div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:24px;">
<h3 style="margin:0 0 16px;"><?php esc_html_e('What To Do While You Wait', 'developer-starter-pro'); ?></h3>
<ol style="margin:0;padding-left:20px;color:#475569;line-height:2;">
<li><?php esc_html_e('Call our emergency number immediately', 'developer-starter-pro'); ?></li>
<li><?php esc_html_e('Do not take aspirin for toothache', 'developer-starter-pro'); ?></li>
<li><?php esc_html_e('Apply cold compress for swelling', 'developer-starter-pro'); ?></li>
<li><?php esc_html_e('Keep knocked-out tooth moist', 'developer-starter-pro'); ?></li>
<li><?php esc_html_e('Avoid hot or cold foods/drinks', 'developer-starter-pro'); ?></li>
</ol>
</div>
</div>
</div>
</div>
</main>
<?php get_footer(); ?>