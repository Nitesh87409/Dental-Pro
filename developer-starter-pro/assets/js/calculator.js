/**
 * Cost Calculator Frontend Actions
 *
 * @package developer-starter-pro
 */

document.addEventListener('DOMContentLoaded', function() {
	var calculator = document.getElementById('dental-cost-calculator');
	if (!calculator) return;

	var checkboxes = calculator.querySelectorAll('.treatment-select');
	var slider = document.getElementById('insurance-copay-slider');
	var percentageLabel = document.getElementById('insurance-percentage-label');
	
	var subtotalVal = document.getElementById('calc-subtotal');
	var savingsVal = document.getElementById('calc-savings');
	var totalVal = document.getElementById('calc-total');
	var bookBtn = document.getElementById('calc-book-btn');

	var config = window.dentalCalculatorConfig || {
		bookingUrl: '/booking/'
	};

	// Bind change triggers
	checkboxes.forEach(function(checkbox) {
		checkbox.addEventListener('change', function() {
			var card = checkbox.closest('.calculator-treatment-item');
			if (card) {
				if (checkbox.checked) {
					card.classList.add('selected');
				} else {
					card.classList.remove('selected');
				}
			}
			updateCalculatorTotals();
		});
	});

	if (slider) {
		slider.addEventListener('input', function() {
			percentageLabel.textContent = slider.value + '%';
			updateCalculatorTotals();
		});
	}

	function updateCalculatorTotals() {
		var subtotal = 0;
		var checkedCount = 0;
		var firstCheckedId = '';

		checkboxes.forEach(function(checkbox) {
			if (checkbox.checked) {
				subtotal += parseFloat(checkbox.getAttribute('data-price') || 0);
				checkedCount++;
				if (!firstCheckedId) {
					firstCheckedId = checkbox.value;
				}
			}
		});

		var copayPercent = slider ? parseFloat(slider.value) : 0;
		var savings = subtotal * (copayPercent / 100);
		var total = subtotal - savings;

		// Update fields with micro-scales
		animateCount(subtotalVal, '$' + subtotal.toLocaleString('en-US', { maximumFractionDigits: 0 }));
		animateCount(savingsVal, '-$' + savings.toLocaleString('en-US', { maximumFractionDigits: 0 }));
		animateCount(totalVal, '$' + total.toLocaleString('en-US', { maximumFractionDigits: 0 }));

		// Enable / Disable buttons
		if (checkedCount > 0) {
			bookBtn.removeAttribute('disabled');
			bookBtn.setAttribute('data-service', firstCheckedId);
		} else {
			bookBtn.setAttribute('disabled', 'disabled');
			bookBtn.removeAttribute('data-service');
		}
	}

	function animateCount(elem, text) {
		if (!elem) return;
		if (elem.textContent === text) return;
		elem.textContent = text;
		
		// Micro-animation scale
		elem.classList.remove('calc-bump');
		void elem.offsetWidth; // trigger reflow
		elem.classList.add('calc-bump');
	}

	// Route to Booking Wizard Form
	if (bookBtn) {
		bookBtn.addEventListener('click', function() {
			var serviceId = bookBtn.getAttribute('data-service');
			if (serviceId) {
				sessionStorage.setItem('selected_calculator_service', serviceId);
				window.location.href = config.bookingUrl;
			}
		});
	}
});
