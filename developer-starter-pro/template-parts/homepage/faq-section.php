<?php
/**
 * Template Part: Homepage FAQ Accordion Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<section class="developer-starter-pro-section homepage-faq-section" id="faqs" style="background: var(--developer-starter-pro-gray-50); border-top: 1px solid var(--developer-starter-pro-gray-200); border-bottom: 1px solid var(--developer-starter-pro-gray-200);">
	<div class="developer-starter-pro-container" style="max-width: 800px;">
		
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Common Queries', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Frequently Asked Questions', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Find answers to standard questions about dental procedures, payments, and clinic operations.', 'developer-starter-pro' ); ?></p>
		</div>

		<div class="faq-accordion-container" style="margin-top: 40px; display: flex; flex-direction: column; gap: 16px;">

			<?php
			$faq_query = new WP_Query( array(
				'post_type'      => 'faqs',
				'posts_per_page' => 10,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) );

			if ( $faq_query->have_posts() ) :
				?>
				<style>
				.faq-rich-text p {
					margin: 0 0 12px 0;
				}
				.faq-rich-text p:last-child {
					margin-bottom: 0;
				}
				</style>
				<?php
				while ( $faq_query->have_posts() ) : $faq_query->the_post();
					?>
					<div class="faq-item" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); overflow: hidden; transition: all 0.3s ease;">
						<button class="faq-trigger" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 22px 28px; background: none; border: none; font-size: 1.0625rem; font-weight: 700; text-align: left; color: var(--developer-starter-pro-secondary); cursor: pointer; outline: none;">
							<span><?php the_title(); ?></span>
							<span class="faq-icon" style="font-size: 1.25rem; transition: transform 0.2s ease;">+</span>
						</button>
						<div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; padding: 0 28px;">
							<div class="faq-rich-text" style="margin: 0; padding-bottom: 24px; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-size: 0.9375rem;">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<!-- FAQ Item 1 -->
				<div class="faq-item" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); overflow: hidden; transition: all 0.3s ease;">
					<button class="faq-trigger" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 22px 28px; background: none; border: none; font-size: 1.0625rem; font-weight: 700; text-align: left; color: var(--developer-starter-pro-secondary); cursor: pointer; outline: none;">
						<span><?php esc_html_e( 'How often should I visit the dentist for cleanings?', 'developer-starter-pro' ); ?></span>
						<span class="faq-icon" style="font-size: 1.25rem; transition: transform 0.2s ease;">+</span>
					</button>
					<div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; padding: 0 28px;">
						<p style="margin: 0; padding-bottom: 24px; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-size: 0.9375rem;"><?php esc_html_e( 'We recommend visiting the clinic at least once every six months for a standard dental scale and polish. Routine checkups prevent plaque buildup and detect minor issues before they worsen.', 'developer-starter-pro' ); ?></p>
					</div>
				</div>

				<!-- FAQ Item 2 -->
				<div class="faq-item" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); overflow: hidden; transition: all 0.3s ease;">
					<button class="faq-trigger" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 22px 28px; background: none; border: none; font-size: 1.0625rem; font-weight: 700; text-align: left; color: var(--developer-starter-pro-secondary); cursor: pointer; outline: none;">
						<span><?php esc_html_e( 'What accepted insurance companies are in-network?', 'developer-starter-pro' ); ?></span>
						<span class="faq-icon" style="font-size: 1.25rem; transition: transform 0.2s ease;">+</span>
					</button>
					<div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; padding: 0 28px;">
						<p style="margin: 0; padding-bottom: 24px; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-size: 0.9375rem;"><?php esc_html_e( 'We are in-network with Delta Dental, Aetna, Cigna, and Blue Cross Blue Shield. You can search for your plan terms using our integrated Insurance Checker page template.', 'developer-starter-pro' ); ?></p>
					</div>
				</div>

				<!-- FAQ Item 3 -->
				<div class="faq-item" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); overflow: hidden; transition: all 0.3s ease;">
					<button class="faq-trigger" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 22px 28px; background: none; border: none; font-size: 1.0625rem; font-weight: 700; text-align: left; color: var(--developer-starter-pro-secondary); cursor: pointer; outline: none;">
						<span><?php esc_html_e( 'What should I do in a dental emergency after hours?', 'developer-starter-pro' ); ?></span>
						<span class="faq-icon" style="font-size: 1.25rem; transition: transform 0.2s ease;">+</span>
					</button>
					<div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; padding: 0 28px;">
						<p style="margin: 0; padding-bottom: 24px; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-size: 0.9375rem;"><?php esc_html_e( 'If you experience severe trauma, swelling, or pain after clinical hours, contact our dedicated emergency desk immediately. We have doctors on-call 24/7 to manage immediate care.', 'developer-starter-pro' ); ?></p>
					</div>
				</div>

				<!-- FAQ Item 4 -->
				<div class="faq-item" style="background: var(--developer-starter-pro-white); border: 1px solid var(--developer-starter-pro-gray-200); border-radius: var(--developer-starter-pro-radius-md); overflow: hidden; transition: all 0.3s ease;">
					<button class="faq-trigger" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 22px 28px; background: none; border: none; font-size: 1.0625rem; font-weight: 700; text-align: left; color: var(--developer-starter-pro-secondary); cursor: pointer; outline: none;">
						<span><?php esc_html_e( 'Do you offer monthly payment/financing installments?', 'developer-starter-pro' ); ?></span>
						<span class="faq-icon" style="font-size: 1.25rem; transition: transform 0.2s ease;">+</span>
					</button>
					<div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; padding: 0 28px;">
						<p style="margin: 0; padding-bottom: 24px; color: var(--developer-starter-pro-gray-500); line-height: 1.6; font-size: 0.9375rem;"><?php esc_html_e( 'Yes, for major procedures like orthodontics, implants, or crowns, we offer flexible interest-free monthly installment programs in cooperation with CareCredit and other dental finance networks.', 'developer-starter-pro' ); ?></p>
					</div>
				</div>
				<?php
			endif;
			?>

		</div>

		<div class="developer-starter-pro-section-cta" style="margin-top: 40px; text-align: center;">
			<a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>" class="developer-starter-pro-btn developer-starter-pro-btn--outline">
				<?php esc_html_e( 'Read More FAQs', 'developer-starter-pro' ); ?>
			</a>
		</div>

	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var triggers = document.querySelectorAll('.faq-trigger');
	
	triggers.forEach(function(trigger) {
		trigger.addEventListener('click', function() {
			var item = this.parentElement;
			var content = this.nextElementSibling;
			var icon = this.querySelector('.faq-icon');
			
			// Close other accordion items
			document.querySelectorAll('.faq-item').forEach(function(i) {
				if (i !== item) {
					i.querySelector('.faq-content').style.maxHeight = null;
					i.querySelector('.faq-icon').textContent = '+';
					i.style.borderColor = 'var(--developer-starter-pro-gray-200)';
				}
			});
			
			// Toggle current item
			if (content.style.maxHeight) {
				content.style.maxHeight = null;
				icon.textContent = '+';
				item.style.borderColor = 'var(--developer-starter-pro-gray-200)';
			} else {
				content.style.maxHeight = content.scrollHeight + 'px';
				icon.textContent = '−';
				item.style.borderColor = 'var(--developer-starter-pro-primary)';
			}
		});
	});
});
</script>
