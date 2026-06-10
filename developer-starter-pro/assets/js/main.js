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
	});

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
			'.developer-starter-pro-service-card, ' +
			'.developer-starter-pro-doctor-card, ' +
			'.developer-starter-pro-testimonial-card, ' +
			'.developer-starter-pro-post-card, ' +
			'.developer-starter-pro-section-header'
		);

		if (animatedElements.length === 0) return;

		// Add initial state.
		animatedElements.forEach(function (el) {
			el.style.opacity = '0';
			el.style.transform = 'translateY(30px)';
			el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
		});

		const observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.style.opacity = '1';
						entry.target.style.transform = 'translateY(0)';
						observer.unobserve(entry.target);
					}
				});
			},
			{
				threshold: 0.1,
				rootMargin: '0px 0px -50px 0px',
			}
		);

		animatedElements.forEach(function (el, index) {
			// Stagger animation delay.
			el.style.transitionDelay = (index % 4) * 0.1 + 's';
			observer.observe(el);
		});
	}
})();
