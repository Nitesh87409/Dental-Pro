document.addEventListener('DOMContentLoaded', function() {
			var container = document.getElementById('why-choose-us-benefits-container');
			var inputEl = document.getElementById('why_choose_us_benefits_input');
			var addBtn = document.getElementById('dp-add-benefit-btn');
			if (!container || !inputEl || !addBtn) return;

			var items = [];
			try {
				items = JSON.parse(inputEl.value) || [];
			} catch(e) {
				items = [];
			}

			function updateHiddenInput() {
				inputEl.value = JSON.stringify(items);
			}

			function renderItems() {
				container.innerHTML = '';
				if (items.length === 0) {
					container.innerHTML = '<div style="padding: 15px; background: #f7fafc; border: 1px dashed #cbd5e0; border-radius: 4px; color: #718096; text-align: center;"><?php esc_html_e( 'No benefits added yet. Click "Add New Benefit Card" below.', 'developer-starter-pro' ); ?></div>';
					return;
				}

				items.forEach(function(item, idx) {
					var itemDiv = document.createElement('div');
					itemDiv.className = 'dp-benefit-item';
					
					var html = '<div class="dp-benefit-item-header">';
					html += '<span class="dp-benefit-item-title-label">Benefit Card #' + (idx + 1) + (item.title ? ': ' + item.title : '') + '</span>';
					html += '<div class="dp-benefit-item-controls">';
					
					// Sort buttons
					if (idx > 0) {
						html += '<button type="button" class="button button-small dp-move-up-btn" data-index="' + idx + '">▲</button>';
					}
					if (idx < items.length - 1) {
						html += '<button type="button" class="button button-small dp-move-down-btn" data-index="' + idx + '">▼</button>';
					}
					
					html += '<button type="button" class="button button-small button-link-delete dp-delete-btn" data-index="' + idx + '"><?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?></button>';
					html += '</div></div>';

					// Icon SVG Markup
					html += '<div class="dp-benefit-field">';
					html += '<label>Icon (SVG Markup)</label>';
					html += '<textarea class="dp-item-icon" rows="2" data-index="' + idx + '" placeholder="' + escAttr('<svg ...>...</svg>') + '">' + escapeHtml(item.icon || '') + '</textarea>';
					html += '</div>';

					// Title
					html += '<div class="dp-benefit-field">';
					html += '<label>Title</label>';
					html += '<input type="text" class="dp-item-title" value="' + escapeHtml(item.title || '') + '" data-index="' + idx + '">';
					html += '</div>';

					// Description
					html += '<div class="dp-benefit-field">';
					html += '<label>Description</label>';
					html += '<textarea class="dp-item-description" rows="2" data-index="' + idx + '">' + escapeHtml(item.description || '') + '</textarea>';
					html += '</div>';

					itemDiv.innerHTML = html;
					container.appendChild(itemDiv);
				});

				// Bind change events
				container.querySelectorAll('.dp-item-icon').forEach(function(el) {
					el.addEventListener('change', function() {
						var index = parseInt(this.getAttribute('data-index'));
						items[index].icon = this.value;
						updateHiddenInput();
					});
				});

				container.querySelectorAll('.dp-item-title').forEach(function(el) {
					el.addEventListener('input', function() {
						var index = parseInt(this.getAttribute('data-index'));
						items[index].title = this.value;
						
						// Update label real-time
						var headerLabel = this.closest('.dp-benefit-item').querySelector('.dp-benefit-item-title-label');
						if (headerLabel) {
							headerLabel.textContent = 'Benefit Card #' + (index + 1) + (this.value ? ': ' + this.value : '');
						}
						updateHiddenInput();
					});
				});

				container.querySelectorAll('.dp-item-description').forEach(function(el) {
					el.addEventListener('change', function() {
						var index = parseInt(this.getAttribute('data-index'));
						items[index].description = this.value;
						updateHiddenInput();
					});
				});

				// Bind control buttons
				container.querySelectorAll('.dp-delete-btn').forEach(function(el) {
					el.addEventListener('click', function() {
						var index = parseInt(this.getAttribute('data-index'));
						items.splice(index, 1);
						updateHiddenInput();
						renderItems();
					});
				});

				container.querySelectorAll('.dp-move-up-btn').forEach(function(el) {
					el.addEventListener('click', function() {
						var index = parseInt(this.getAttribute('data-index'));
						if (index > 0) {
							var temp = items[index];
							items[index] = items[index - 1];
							items[index - 1] = temp;
							updateHiddenInput();
							renderItems();
						}
					});
				});

				container.querySelectorAll('.dp-move-down-btn').forEach(function(el) {
					el.addEventListener('click', function() {
						var index = parseInt(this.getAttribute('data-index'));
						if (index < items.length - 1) {
							var temp = items[index];
							items[index] = items[index + 1];
							items[index + 1] = temp;
							updateHiddenInput();
							renderItems();
						}
					});
				});
			}

			function escAttr(str) {
				return str.replace(/"/g, '&quot;');
			}

			function escapeHtml(str) {
				if (!str) return '';
				return str
					.replace(/&/g, '&amp;')
					.replace(/</g, '&lt;')
					.replace(/>/g, '&gt;')
					.replace(/"/g, '&quot;')
					.replace(/'/g, '&#039;');
			}

			// Add event
			addBtn.addEventListener('click', function() {
				items.push({
					icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
					title: '',
					description: ''
				});
				updateHiddenInput();
				renderItems();
			});

			renderItems();
		});