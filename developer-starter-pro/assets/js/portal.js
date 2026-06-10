/**
 * Patient Portal Frontend Actions
 *
 * Handles tab switching, printing appointment cards, and AJAX cancellation.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	// =========================================================================
	// 1. Tab Switching Logic
	// =========================================================================
	const tabs = document.querySelectorAll('.portal-tab-btn');
	const panels = document.querySelectorAll('.portal-tab-panel');

	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			tabs.forEach(t => t.classList.remove('active'));
			panels.forEach(p => p.classList.remove('active'));

			this.classList.add('active');
			const targetId = this.getAttribute('data-target');
			const targetPanel = document.getElementById(targetId);
			if (targetPanel) {
				targetPanel.classList.add('active');
			}
		});
	});

	// =========================================================================
	// 2. Print Summary Logic
	// =========================================================================
	const printButtons = document.querySelectorAll('.print-appointment-btn');
	printButtons.forEach(function (btn) {
		btn.addEventListener('click', function () {
			const card = this.closest('.patient-appointment-card');
			if (!card) return;

			const docName = card.getAttribute('data-doctor');
			const srvName = card.getAttribute('data-service');
			const dateStr = card.getAttribute('data-date');
			const timeStr = card.getAttribute('data-time');
			const statusStr = card.getAttribute('data-status');

			const printWindow = window.open('', '_blank', 'width=600,height=500');
			if (!printWindow) {
				alert('Please allow popups to print appointment cards.');
				return;
			}

			printWindow.document.write(`
				<html>
				<head>
					<title>Appointment Summary</title>
					<style>
						body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; padding: 40px; color: #1e293b; background: #fff; }
						.card { border: 2px solid #e2e8f0; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
						.logo { font-size: 2rem; font-weight: bold; margin-bottom: 20px; text-align: center; }
						h2 { margin-top: 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; color: #0d9488; }
						.item { margin-bottom: 16px; font-size: 1.1rem; }
						.label { font-weight: bold; color: #64748b; display: block; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 4px; }
						.badge { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 0.8125rem; font-weight: bold; text-transform: uppercase; }
						.badge.approved { background: #d1fae5; color: #065f46; }
						.badge.pending { background: #fef3c7; color: #d97706; }
						.badge.completed { background: #dbeafe; color: #1e40af; }
						.footer { margin-top: 30px; text-align: center; font-size: 0.875rem; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 16px; }
					</style>
				</head>
				<body>
					<div class="card">
						<div class="logo">🦷 DentalPro Elite</div>
						<h2>Clinical Appointment Summary</h2>
						<div class="item">
							<span class="label">Dental Service</span>
							<strong>${srvName}</strong>
						</div>
						<div class="item">
							<span class="label">Treating Doctor</span>
							<strong>${docName}</strong>
						</div>
						<div class="item">
							<span class="label">Appointment Date</span>
							<strong>${dateStr}</strong>
						</div>
						<div class="item">
							<span class="label">Scheduled Time Slot</span>
							<strong>${timeStr}</strong>
						</div>
						<div class="item">
							<span class="label">Booking Status</span>
							<span class="badge ${statusStr.toLowerCase()}">${statusStr}</span>
						</div>
						<div class="footer">
							Thank you for choosing DentalPro Elite. Please arrive 10 minutes prior to your schedule.
						</div>
					</div>
					<script>
						window.onload = function() {
							window.print();
							setTimeout(function() { window.close(); }, 500);
						};
					</script>
				</body>
				</html>
			`);
			printWindow.document.close();
		});
	});

	// =========================================================================
	// 3. AJAX Cancellation Logic
	// =========================================================================
	const cancelButtons = document.querySelectorAll('.cancel-appointment-btn');
	cancelButtons.forEach(function (btn) {
		btn.addEventListener('click', function () {
			const appointmentId = this.getAttribute('data-id');
			if (!appointmentId) return;

			if (!confirm('Are you sure you want to cancel this appointment? This action cannot be undone.')) {
				return;
			}

			const card = this.closest('.patient-appointment-card');
			this.disabled = true;
			this.textContent = 'Cancelling...';

			const formData = new FormData();
			formData.append('action', 'dentalpro_cancel_appointment');
			formData.append('id', appointmentId);
			formData.append('nonce', developerStarterProPortal.nonce);

			fetch(developerStarterProPortal.ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Fade card out and remove
					card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
					card.style.opacity = 0;
					card.style.transform = 'translateY(20px)';
					setTimeout(function() {
						card.remove();
						const list = document.querySelector('.upcoming-appointments-list');
						if (list && list.children.length === 0) {
							list.innerHTML = '<p style="color:var(--developer-starter-pro-gray-400); font-style:italic;">You have no active upcoming appointments.</p>';
						}
					}, 400);
				} else {
					alert(data.data.message || 'Failed to cancel appointment.');
					this.disabled = false;
					this.textContent = 'Cancel Appointment';
				}
			})
			.catch(err => {
				alert('Server communication error. Please try again.');
				this.disabled = false;
				this.textContent = 'Cancel Appointment';
			});
		});
	});
});
