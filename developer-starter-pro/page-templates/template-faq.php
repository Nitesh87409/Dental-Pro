<?php
/**
 * Template Name: FAQs
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
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Questions & Answers', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Find quick answers to common queries regarding treatments, billing, scheduling, and general policies.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- FAQ Content Section -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container" style="max-width: 900px;">

			<!-- Category Tabs -->
			<div class="developer-starter-pro-faq-tabs" style="display:flex; justify-content:center; gap:12px; margin-bottom: 40px; flex-wrap: wrap;">
				<button class="developer-starter-pro-faq-tab-btn active" data-category="general"><?php esc_html_e( 'General Info', 'developer-starter-pro' ); ?></button>
				<button class="developer-starter-pro-faq-tab-btn" data-category="treatments"><?php esc_html_e( 'Treatments', 'developer-starter-pro' ); ?></button>
				<button class="developer-starter-pro-faq-tab-btn" data-category="pricing"><?php esc_html_e( 'Pricing & Insurance', 'developer-starter-pro' ); ?></button>
			</div>

			<!-- FAQ Groups -->
			<div class="developer-starter-pro-faq-groups">

				<!-- Group: General -->
				<div class="developer-starter-pro-faq-group active" id="faq-group-general">
					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'How do I schedule my first appointment?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'You can schedule an appointment by calling our clinic directly or by using our online booking form. Our coordinator will follow up to verify your details.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>

					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'What should I bring on my first visit?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'Please bring a valid photo identification card, any current dental insurance documentation, and your medical history records (including current medication listings).', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>

					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'What is your cancellation policy?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'We require at least 24 hours advance notification for cancellation or rescheduling to avoid a cancellation fee. This allows other patients to utilize the time slot.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>
				</div>

				<!-- Group: Treatments -->
				<div class="developer-starter-pro-faq-group" id="faq-group-treatments">
					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'How often should I visit the dentist?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'We recommend visiting us for a standard professional cleaning and dental examination every six months to identify potential issues early and maintain healthy gums.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>

					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'Are dental X-rays safe?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'Yes, our clinic uses state-of-the-art digital radiography machines which emit up to 90% less radiation than classic film X-rays, making them extremely safe for children and adults.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>

					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'What options do you offer for teeth whitening?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'We provide both in-office laser teeth whitening (completed in a single 60-minute session) and custom home whitening trays with medical-grade bleaching gels.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>
				</div>

				<!-- Group: Pricing -->
				<div class="developer-starter-pro-faq-group" id="faq-group-pricing">
					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'Do you accept dental insurance?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'Yes, we accept major private dental insurance plans. We also assist in submitting claims directly to your provider to maximize your plan coverage advantages.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>

					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'What payment options do you support?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'We accept cash payments, credit cards (Visa, MasterCard, Amex), and offer interest-free flexible payment plans for extensive restorative procedures.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>

					<div class="developer-starter-pro-accordion-item">
						<button class="developer-starter-pro-accordion-trigger">
							<span class="faq-question"><?php esc_html_e( 'How much do standard implants cost?', 'developer-starter-pro' ); ?></span>
							<span class="faq-icon">▼</span>
						</button>
						<div class="developer-starter-pro-accordion-content">
							<div class="inner-content">
								<p><?php esc_html_e( 'Implants vary depending on requirements (bone grafting, materials). We provide structured, upfront prices on our Services and Pricing pages, and detail customized plans during consultation.', 'developer-starter-pro' ); ?></p>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Category filtering logic
	var faqTabs = document.querySelectorAll('.developer-starter-pro-faq-tab-btn');
	var faqGroups = document.querySelectorAll('.developer-starter-pro-faq-group');

	faqTabs.forEach(function(tab) {
		tab.addEventListener('click', function() {
			faqTabs.forEach(function(btn) { btn.classList.remove('active'); });
			this.classList.add('active');

			var category = this.getAttribute('data-category');
			faqGroups.forEach(function(group) {
				if (group.getAttribute('id') === 'faq-group-' + category) {
					group.classList.add('active');
				} else {
					group.classList.remove('active');
				}
			});
		});
	});

	// Accordion click logic
	var triggers = document.querySelectorAll('.developer-starter-pro-accordion-trigger');
	triggers.forEach(function(trigger) {
		trigger.addEventListener('click', function() {
			var parent = this.parentElement;
			var isAlreadyActive = parent.classList.contains('active');

			// Close others in this active group
			var activeGroup = parent.parentElement;
			activeGroup.querySelectorAll('.developer-starter-pro-accordion-item').forEach(function(item) {
				item.classList.remove('active');
				item.querySelector('.developer-starter-pro-accordion-content').style.maxHeight = null;
			});

			if (!isAlreadyActive) {
				parent.classList.add('active');
				var content = parent.querySelector('.developer-starter-pro-accordion-content');
				content.style.maxHeight = content.scrollHeight + 'px';
			}
		});
	});
});
</script>

<?php
get_footer();
