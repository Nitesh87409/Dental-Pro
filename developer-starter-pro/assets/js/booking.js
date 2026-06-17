/**
 * Appointment Booking Wizard Frontend Script
 *
 * @package developer-starter-pro
 */

document.addEventListener('DOMContentLoaded', function() {
	var currentStep = 1;
	var totalSteps = 5;
	
	var form = document.getElementById('booking-wizard-form');
	if (!form) return;

	var errorBanner = document.getElementById('booking-error-banner');
	var nextBtn = document.getElementById('next-step');
	var prevBtn = document.getElementById('prev-step');
	
	var progressFill = document.getElementById('step-progress-fill');
	var indicators = document.querySelectorAll('.wizard-step-indicator');
	var panels = document.querySelectorAll('.booking-wizard-panel');

	var phoneInput = form.querySelector('input[name="patient_phone"]');
	var iti = null;
	if (phoneInput && typeof window.intlTelInput === 'function') {
		iti = window.intlTelInput(phoneInput, {
			initialCountry: "in",
			separateDialCode: true,
			utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.1/build/js/utils.js"
		});
	}

	// Localized parameters setup fallback
	var l10n = window.developerStarterProBooking || {
		restUrl: '/wp-json/dentalpro/v1/',
		strings: {
			loadingSlots: 'Loading available slots...',
			noSlots: 'No slot intervals generated.',
			serverError: 'Server request failed.',
			selectLocation: 'Please select a clinic location to continue.',
			selectService: 'Please select a dental service to continue.',
			selectDoctor: 'Please select a doctor to continue.',
			selectDate: 'Please pick a booking date.',
			selectSlot: 'Please select a time slot.',
			bookAppointment: 'Book Appointment',
			continueText: 'Continue',
			processing: 'Processing...',
			communicationError: 'Server communication error. Please try again.'
		}
	};

	// Selection Cards highlight triggers
	var locationRadios = document.querySelectorAll('input[name="location_id"]');
	var serviceRadios = document.querySelectorAll('input[name="service_id"]');
	var doctorRadios = document.querySelectorAll('input[name="doctor_id"]');

	function updateSelectionHighlight(radios) {
		radios.forEach(function(radio) {
			var card = radio.closest('.wizard-selection-card');
			if (card) {
				if (radio.checked) {
					card.classList.add('selected');
				} else {
					card.classList.remove('selected');
				}
			}
		});
	}

	form.addEventListener('change', function(e) {
		if (e.target.name === 'location_id') updateSelectionHighlight(locationRadios);
		if (e.target.name === 'service_id') updateSelectionHighlight(serviceRadios);
		if (e.target.name === 'doctor_id') updateSelectionHighlight(doctorRadios);
	});

	// Pre-highlight initially selected cards
	updateSelectionHighlight(locationRadios);
	updateSelectionHighlight(serviceRadios);
	updateSelectionHighlight(doctorRadios);

	// Date Slot fetching triggers
	var dateInput = document.getElementById('booking_date');
	var slotsContainer = document.getElementById('slots-container');
	var selectedTimeSlot = '';

	if (dateInput) {
		dateInput.addEventListener('change', fetchTimeSlots);
	}

	function fetchTimeSlots() {
		var doctorId = form.elements['doctor_id'].value;
		var date = dateInput.value;

		if (!doctorId || !date) return;

		slotsContainer.innerHTML = '<p style="color:var(--developer-starter-pro-gray-400); font-style:italic; font-size:0.9rem; grid-column: 1/-1; text-align:center; padding-top:20px;">' + l10n.strings.loadingSlots + '</p>';

		fetch(l10n.restUrl + 'available-slots?doctor_id=' + doctorId + '&date=' + date)
			.then(function(res) { return res.json(); })
			.then(function(data) {
				slotsContainer.innerHTML = '';
				if (!data.available) {
					slotsContainer.innerHTML = '<p style="color:var(--developer-starter-pro-danger); font-weight:500; font-size:0.9rem; grid-column:1/-1; text-align:center; padding-top:20px;">' + (data.reason || 'Not available.') + '</p>';
					return;
				}

				if (data.slots.length === 0) {
					slotsContainer.innerHTML = '<p style="color:var(--developer-starter-pro-gray-400); font-style:italic; font-size:0.9rem; grid-column:1/-1; text-align:center; padding-top:20px;">' + l10n.strings.noSlots + '</p>';
					return;
				}

				data.slots.forEach(function(slot) {
					var button = document.createElement('button');
					button.type = 'button';
					button.className = 'time-slot-btn' + (slot.available ? '' : ' disabled');
					button.textContent = slot.formatted;
					button.setAttribute('data-time', slot.time);

					if (slot.available) {
						button.addEventListener('click', function() {
							document.querySelectorAll('.time-slot-btn').forEach(function(b) { b.classList.remove('selected'); });
							button.classList.add('selected');
							selectedTimeSlot = slot.time;
							errorBanner.style.display = 'none';
						});
					}

					slotsContainer.appendChild(button);
				});
			})
			.catch(function() {
				slotsContainer.innerHTML = '<p style="color:var(--developer-starter-pro-danger); font-weight:500; font-size:0.9rem; grid-column:1/-1; text-align:center; padding-top:20px;">' + l10n.strings.serverError + '</p>';
			});
	}

	function filterDoctorsByLocation(locationId) {
		var doctorCards = document.querySelectorAll('.wizard-doctors-list .wizard-selection-card');
		var checkedDoctor = form.elements['doctor_id'] ? form.elements['doctor_id'].value : '';
		
		doctorCards.forEach(function(card) {
			var docLoc = card.getAttribute('data-location-id');
			// Show doctor if they are general (0) or assigned to selected location
			if (docLoc === '0' || docLoc === locationId) {
				card.style.display = '';
			} else {
				card.style.display = 'none';
				var radio = card.querySelector('input[name="doctor_id"]');
				if (radio && radio.checked) {
					radio.checked = false;
					card.classList.remove('selected');
				}
			}
		});
	}

	// Step Navigation Logic
	if (nextBtn) {
		nextBtn.addEventListener('click', function() {
			errorBanner.style.display = 'none';

			// Validate current step fields
			if (1 === currentStep) {
				if (!form.elements['location_id'].value) {
					showError(l10n.strings.selectLocation || 'Please select a clinic location to continue.');
					return;
				}
				// Filter doctor cards based on selected location
				filterDoctorsByLocation(form.elements['location_id'].value);
			} else if (2 === currentStep) {
				if (!form.elements['service_id'].value) {
					showError(l10n.strings.selectService);
					return;
				}
			} else if (3 === currentStep) {
				if (!form.elements['doctor_id'].value) {
					showError(l10n.strings.selectDoctor);
					return;
				}
				// Trigger a slot fetch beforehand to prepopulate if date is selected
				fetchTimeSlots();
			} else if (4 === currentStep) {
				if (!dateInput.value) {
					showError(l10n.strings.selectDate);
					return;
				}
				if (!selectedTimeSlot) {
					showError(l10n.strings.selectSlot);
					return;
				}
			} else if (5 === currentStep) {
				if (!form.checkValidity()) {
					form.reportValidity();
					return;
				}
				if (iti && !iti.isValidNumber()) {
					showError('Please enter a valid phone number for the selected country.');
					return;
				}
				submitBooking();
				return;
			}

			goToStep(currentStep + 1);
		});
	}

	if (prevBtn) {
		prevBtn.addEventListener('click', function() {
			goToStep(currentStep - 1);
		});
	}

	function goToStep(step) {
		currentStep = step;

		// Toggle buttons visibility
		prevBtn.style.visibility = (currentStep === 1) ? 'hidden' : 'visible';
		nextBtn.textContent = (currentStep === totalSteps) ? l10n.strings.bookAppointment : l10n.strings.continueText;

		// Toggle Panels
		panels.forEach(function(panel) {
			if (parseInt(panel.getAttribute('data-panel'), 10) === currentStep) {
				panel.style.display = 'block';
			} else {
				panel.style.display = 'none';
			}
		});

		// Update indicator bar classes
		indicators.forEach(function(ind) {
			var indStep = parseInt(ind.getAttribute('data-step'), 10);
			if (indStep < currentStep) {
				ind.classList.remove('active');
				ind.classList.add('completed');
			} else if (indStep === currentStep) {
				ind.classList.remove('completed');
				ind.classList.add('active');
			} else {
				ind.classList.remove('active', 'completed');
			}
		});

		// Update Progress line
		progressFill.style.width = ((currentStep - 1) / (totalSteps - 1) * 100) + '%';
	}

	function showError(msg) {
		errorBanner.textContent = msg;
		errorBanner.style.display = 'block';
	}

	function submitBooking() {
		nextBtn.disabled = true;
		nextBtn.textContent = l10n.strings.processing;

		var payload = {
			location_id: parseInt(form.elements['location_id'].value, 10),
			service_id: parseInt(form.elements['service_id'].value, 10),
			doctor_id: parseInt(form.elements['doctor_id'].value, 10),
			date: dateInput.value,
			time_slot: selectedTimeSlot,
			patient_name: form.elements['patient_name'].value,
			patient_email: form.elements['patient_email'].value,
			patient_phone: (iti && iti.isValidNumber()) ? iti.getNumber() : form.elements['patient_phone'].value,
			notes: form.elements['notes'].value,
			website_url: form.elements['website_url'] ? form.elements['website_url'].value : ''
		};

		fetch(l10n.restUrl + 'book', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(payload)
		})
		.then(function(res) { return res.json(); })
		.then(function(data) {
			if (data.success) {
				form.style.display = 'none';
				var wizardSteps = document.querySelector('.booking-wizard-steps');
				if (wizardSteps) wizardSteps.style.display = 'none';
				
				var refIdElem = document.getElementById('success-ref-id');
				if (refIdElem && data.reference_id) {
					refIdElem.textContent = data.reference_id;
					var refBox = document.getElementById('booking-ref-box');
					if (refBox) refBox.style.display = 'inline-block';
				}
				
				var successMessageText = document.getElementById('success-message-text');
				if (successMessageText) successMessageText.textContent = data.message;
				var successPanel = document.getElementById('booking-success-panel');
				if (successPanel) successPanel.style.display = 'block';
			} else {
				showError(data.message || 'Booking submission error.');
				nextBtn.disabled = false;
				nextBtn.textContent = l10n.strings.bookAppointment;
			}
		})
		.catch(function() {
			showError(l10n.strings.communicationError);
			nextBtn.disabled = false;
			nextBtn.textContent = l10n.strings.bookAppointment;
		});
	}

	// URL query params or PHP pre-selected inputs auto-advance
	var initialLocationChecked = form.querySelector('input[name="location_id"]:checked');
	if (initialLocationChecked) {
		filterDoctorsByLocation(initialLocationChecked.value);
		goToStep(2);
		var initialServiceChecked = form.querySelector('input[name="service_id"]:checked');
		if (initialServiceChecked) {
			goToStep(3);
			var initialDoctorChecked = form.querySelector('input[name="doctor_id"]:checked');
			if (initialDoctorChecked) {
				goToStep(4);
				fetchTimeSlots();
			}
		}
	}
});
