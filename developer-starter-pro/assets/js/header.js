/**
 * DentalPro Elite — Header JavaScript
 *
 * Handles: sticky header, mobile menu, hamburger toggle.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		initStickyHeader();
		initMobileMenu();
		initDarkMode();
	});

	// =========================================================================
	// Dark Mode
	// =========================================================================
	function initDarkMode() {
		const toggle = document.getElementById('dark-mode-toggle');
		if (!toggle) return;

		const storedTheme = localStorage.getItem('theme');
		const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

		if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
			document.body.classList.add('dark-mode');
		}

		toggle.addEventListener('click', function () {
			document.body.classList.toggle('dark-mode');
			const currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
			localStorage.setItem('theme', currentTheme);
		});
	}

	// =========================================================================
	// Sticky Header
	// =========================================================================
	function initStickyHeader() {
		const header = document.querySelector('.developer-starter-pro-header--sticky-enabled');
		if (!header) return;

		const isTransparent = header.classList.contains('dp-header--transparent');
		let lastScroll = 0;
		const headerHeight = header.offsetHeight;

		// Create a placeholder to prevent content jump (not needed for transparent headers).
		const placeholder = document.createElement('div');
		placeholder.style.height = headerHeight + 'px';
		placeholder.style.display = 'none';
		placeholder.className = 'developer-starter-pro-header-placeholder';
		if (!isTransparent) {
			header.parentNode.insertBefore(placeholder, header.nextSibling);
		}

		window.addEventListener('scroll', function () {
			const currentScroll = window.scrollY;
			const threshold = isTransparent ? 50 : headerHeight + 100;

			if (currentScroll > threshold) {
				if (!header.classList.contains('is-sticky')) {
					header.classList.add('is-sticky');
					if (!isTransparent) placeholder.style.display = 'block';
				}
			} else {
				header.classList.remove('is-sticky');
				if (!isTransparent) placeholder.style.display = 'none';
			}

			lastScroll = currentScroll;
		}, { passive: true });
	}

	// =========================================================================
	// Mobile Menu
	// =========================================================================
	function initMobileMenu() {
		const toggle = document.getElementById('mobile-menu-toggle');
		const close = document.getElementById('mobile-menu-close');
		const menu = document.getElementById('mobile-menu');
		const hamburger = toggle?.querySelector('.developer-starter-pro-hamburger');

		if (!toggle || !menu) return;

		// Create backdrop.
		const backdrop = document.createElement('div');
		backdrop.className = 'developer-starter-pro-mobile-backdrop';
		document.body.appendChild(backdrop);

		function openMenu() {
			menu.classList.add('is-open');
			menu.setAttribute('aria-hidden', 'false');
			backdrop.classList.add('is-visible');
			document.body.style.overflow = 'hidden';
			if (hamburger) hamburger.classList.add('active');
			toggle.setAttribute('aria-expanded', 'true');
		}

		function closeMenu() {
			menu.classList.remove('is-open');
			menu.setAttribute('aria-hidden', 'true');
			backdrop.classList.remove('is-visible');
			document.body.style.overflow = '';
			if (hamburger) hamburger.classList.remove('active');
			toggle.setAttribute('aria-expanded', 'false');
		}

		toggle.addEventListener('click', function () {
			if (menu.classList.contains('is-open')) {
				closeMenu();
			} else {
				openMenu();
			}
		});

		if (close) {
			close.addEventListener('click', closeMenu);
		}

		backdrop.addEventListener('click', closeMenu);

		// Close on Escape key.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && menu.classList.contains('is-open')) {
				closeMenu();
			}
		});

		// Close menu on window resize (if opened on mobile then resized to desktop).
		window.addEventListener('resize', function () {
			if (window.innerWidth > 768 && menu.classList.contains('is-open')) {
				closeMenu();
			}
		});

		// Handle submenu toggles in mobile.
		const subMenuParents = menu.querySelectorAll('.menu-item-has-children');
		subMenuParents.forEach(function (parent) {
			const link = parent.querySelector(':scope > a');
			const subMenu = parent.querySelector(':scope > .sub-menu');

			if (link && subMenu) {
				// Create toggle button.
				const toggleBtn = document.createElement('button');
				toggleBtn.className = 'developer-starter-pro-submenu-toggle';
				toggleBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>';
				toggleBtn.setAttribute('aria-label', 'Toggle submenu');
				toggleBtn.style.cssText = 'background:none;border:none;cursor:pointer;padding:8px;position:absolute;right:8px;top:8px;color:#64748b;';
				parent.style.position = 'relative';
				parent.appendChild(toggleBtn);

				toggleBtn.addEventListener('click', function (e) {
					e.preventDefault();
					e.stopPropagation();
					subMenu.style.display = subMenu.style.display === 'block' ? 'none' : 'block';
					this.classList.toggle('active');
				});
			}
		});
	}
})();
