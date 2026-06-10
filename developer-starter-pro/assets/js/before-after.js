/**
 * DentalPro Elite — Before/After Comparison Slider JavaScript
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		initBeforeAfterSliders();
	});

	/**
	 * Initialize all comparison sliders on the page.
	 */
	function initBeforeAfterSliders() {
		const wrappers = document.querySelectorAll('.developer-starter-pro-ba-wrapper');

		wrappers.forEach(function (wrapper) {
			const slider = wrapper.querySelector('.developer-starter-pro-ba-slider');
			const beforeEl = wrapper.querySelector('.developer-starter-pro-ba-before');
			const handle = wrapper.querySelector('.developer-starter-pro-ba-handle');

			if ( ! slider || ! beforeEl || ! handle ) {
				return;
			}

			// Add event listener for slider input changes
			slider.addEventListener('input', function (e) {
				const value = e.target.value;
				
				// Clip the before image container from the right
				beforeEl.style.clipPath = 'inset(0 ' + (100 - value) + '% 0 0)';
				
				// Shift the dividing handle line
				handle.style.left = value + '%';
			});
		});
	}
})();
