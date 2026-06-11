<?php
/**
 * Template Name: Video Consultation
 * @package developer-starter-pro
 */
get_header(); ?>
<main id="primary" class="developer-starter-pro-main">
<div class="developer-starter-pro-container" style="padding:60px 0;">
<div style="text-align:center; margin-bottom:48px;">
<h1><?php esc_html_e('Video Consultation', 'developer-starter-pro'); ?></h1>
<p><?php esc_html_e('Consult our dental experts from the comfort of your home.', 'developer-starter-pro'); ?></p>
</div>
<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:24px; margin-bottom:48px;">
<?php
$benefits = [
    ['icon'=>'📹','title'=>'HD Video Call','desc'=>'Crystal clear video with our specialists'],
    ['icon'=>'🏠','title'=>'From Home','desc'=>'No travel needed — consult from anywhere'],
    ['icon'=>'⚡','title'=>'Quick Response','desc'=>'Get expert advice within 24 hours'],
    ['icon'=>'🔒','title'=>'100% Private','desc'=>'Encrypted secure video platform'],
    ['icon'=>'📋','title'=>'Digital Prescription','desc'=>'Receive prescription via email'],
    ['icon'=>'💳','title'=>'Easy Payment','desc'=>'Pay online before the consultation'],
];
foreach($benefits as $b): ?>
<div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:24px;text-align:center;">
<div style="font-size:2rem;margin-bottom:12px;"><?php echo $b['icon']; ?></div>
<h3 style="margin:0 0 8px;font-size:1rem;"><?php echo esc_html($b['title']); ?></h3>
<p style="margin:0;color:#64748b;font-size:0.875rem;"><?php echo esc_html($b['desc']); ?></p>
</div>
<?php endforeach; ?>
</div>
<div style="background:linear-gradient(135deg,#0D9488,#0B7A70);border-radius:16px;padding:48px;text-align:center;color:#fff;">
<h2 style="margin:0 0 12px;font-size:1.75rem;"><?php esc_html_e('Book Your Video Consultation', 'developer-starter-pro'); ?></h2>
<p style="margin:0 0 24px;opacity:0.9;"><?php esc_html_e('Select a date and time that works best for you.', 'developer-starter-pro'); ?></p>
<a href="<?php echo esc_url(get_permalink(get_page_by_path('booking'))); ?>" style="display:inline-block;background:#fff;color:#0D9488;padding:14px 36px;border-radius:8px;font-weight:700;text-decoration:none;">
<?php esc_html_e('Book Video Consultation', 'developer-starter-pro'); ?>
</a>
</div>
</div>
</main>
<?php get_footer(); ?>