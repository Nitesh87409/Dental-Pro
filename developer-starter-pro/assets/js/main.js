/**
 * DentalPro Elite — Main JavaScript
 *
 * Handles: scroll animations, back to top, smooth scroll, general interactions.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

(function () {
	'use strict';

	// =========================================================================
	// DOM Ready
	// =========================================================================
	document.addEventListener('DOMContentLoaded', function () {
		initBackToTop();
		initSmoothScroll();
		initScrollAnimations();
		initVideoModal();
	});

	window.addEventListener('load', function () {
		document.documentElement.classList.add('page-loaded');
	});
	// Fallback to trigger page-loaded if window load is slow or has already fired.
	setTimeout(function () {
		document.documentElement.classList.add('page-loaded');
	}, 1500);

	// =========================================================================
	// Back to Top Button
	// =========================================================================
	function initBackToTop() {
		const btn = document.getElementById('back-to-top');
		if (!btn) return;

		window.addEventListener('scroll', function () {
			if (window.scrollY > 500) {
				btn.classList.add('visible');
			} else {
				btn.classList.remove('visible');
			}
		}, { passive: true });

		btn.addEventListener('click', function () {
			window.scrollTo({
				top: 0,
				behavior: 'smooth',
			});
		});
	}

	// =========================================================================
	// Smooth Scroll for Anchor Links
	// =========================================================================
	function initSmoothScroll() {
		document.querySelectorAll('a[href^="#"]').forEach(function (link) {
			link.addEventListener('click', function (e) {
				const targetId = this.getAttribute('href');
				if (targetId === '#' || targetId === '') return;

				const target = document.querySelector(targetId);
				if (!target) return;

				e.preventDefault();
				const headerOffset = document.querySelector('.developer-starter-pro-header')?.offsetHeight || 80;

				window.scrollTo({
					top: target.offsetTop - headerOffset,
					behavior: 'smooth',
				});
			});
		});
	}

	// =========================================================================
	// Scroll Animations (Intersection Observer)
	// =========================================================================
	function initScrollAnimations() {
		if (!('IntersectionObserver' in window)) return;

		const animatedElements = document.querySelectorAll(
			'.dp-section-header, ' +
			'.dp-service-card, ' +
			'.dp-doctor-card, ' +
			'.dp-testimonial-card, ' +
			'.benefit-card, ' +
			'.dp-stats-item, ' +
			'.dp-booking__heading, ' +
			'.dp-booking__bar, ' +
			'.developer-starter-pro-section-header, ' +
			'.developer-starter-pro-service-card, ' +
			'.developer-starter-pro-doctor-card, ' +
			'.developer-starter-pro-testimonial-card'
		);

		if (animatedElements.length === 0) return;

		// Add animation class programmatically.
		animatedElements.forEach(function (el, index) {
			el.classList.add('dp-animate-on-scroll');
			// Stagger animation delay.
			el.style.transitionDelay = (index % 4) * 0.1 + 's';
		});

		const observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						const el = entry.target;
						el.classList.add('is-visible');
						
						// Clean up classes once transition is done to restore original CSS states.
						const delay = parseFloat(window.getComputedStyle(el).transitionDelay || '0') * 1000;
						setTimeout(function () {
							el.classList.remove('dp-animate-on-scroll', 'is-visible');
							el.style.removeProperty('transition-delay');
						}, 850 + delay);

						observer.unobserve(el);
					}
				});
			},
			{
				threshold: 0.1,
				rootMargin: '0px 0px -50px 0px',
			}
		);

		animatedElements.forEach(function (el) {
			observer.observe(el);
		});
	}

	// =========================================================================
	// Video Testimonials Modal
	// =========================================================================
	function initVideoModal() {
		const playButtons = document.querySelectorAll('.testimonial-video-play-btn');
		const modal = document.getElementById('testimonials-video-modal');
		const closeBtn = document.getElementById('close-video-modal');
		const iframe = document.getElementById('video-iframe');

		if (!modal || !closeBtn || !iframe) return;

		playButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				const videoUrl = this.getAttribute('data-video');
				if (videoUrl) {
					iframe.src = videoUrl + (videoUrl.indexOf('?') !== -1 ? '&' : '?') + 'autoplay=1';
					modal.classList.add('active');
				}
			});
		});

		function closeModal() {
			modal.classList.remove('active');
			iframe.src = '';
		}

		closeBtn.addEventListener('click', closeModal);
		modal.addEventListener('click', function (e) {
			if (e.target === modal) {
				closeModal();
			}
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				closeModal();
			}
		});
	}
})();
