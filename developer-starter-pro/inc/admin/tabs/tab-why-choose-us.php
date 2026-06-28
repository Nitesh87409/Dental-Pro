<?php
/**
 * Tab: why_choose_us
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
$benefits = isset( $options['why_choose_us_benefits'] ) ? $options['why_choose_us_benefits'] : array();
		if ( ! is_array( $benefits ) ) {
			$benefits = array();
		}
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Homepage "Why Choose Us" Section', 'developer-starter-pro' ); ?></h2>

			<table class="form-table">
				<tr>
					<th><label for="why_choose_us_badge"><?php esc_html_e( 'Section Badge / Eyebrow', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="why_choose_us_badge" name="<?php echo esc_attr( $this->option_name ); ?>[why_choose_us_badge]" value="<?php echo esc_attr( isset( $options['why_choose_us_badge'] ) ? $options['why_choose_us_badge'] : 'Our Core Strengths' ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Small label shown above the section title.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="why_choose_us_title"><?php esc_html_e( 'Section Title', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="why_choose_us_title" name="<?php echo esc_attr( $this->option_name ); ?>[why_choose_us_title]" value="<?php echo esc_attr( isset( $options['why_choose_us_title'] ) ? $options['why_choose_us_title'] : 'Why Choose DentalPro Elite?' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="why_choose_us_subtitle"><?php esc_html_e( 'Section Subtitle / Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="why_choose_us_subtitle" name="<?php echo esc_attr( $this->option_name ); ?>[why_choose_us_subtitle]" rows="3" class="large-text"><?php echo esc_textarea( isset( $options['why_choose_us_subtitle'] ) ? $options['why_choose_us_subtitle'] : '' ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Benefit Cards (Repeatable)', 'developer-starter-pro' ); ?></th>
					<td>
						<div id="why-choose-us-benefits-container" class="dp-repeatable-container">
							<!-- Items will be loaded here dynamically by JS -->
						</div>
						
						<!-- Hidden input storing serialized benefits data -->
						<input type="hidden" id="why_choose_us_benefits_input" name="<?php echo esc_attr( $this->option_name ); ?>[why_choose_us_benefits]" value="<?php echo esc_attr( wp_json_encode( $benefits ) ); ?>">
						
						<button type="button" class="button button-secondary" id="dp-add-benefit-btn" style="margin-top: 15px;">
							<span class="dashicons dashicons-plus" style="vertical-align: middle; margin-top: -3px;"></span>
							<?php esc_html_e( 'Add New Benefit Card', 'developer-starter-pro' ); ?>
						</button>
					</td>
				</tr>
			</table>
		</div>

		<!-- Repeatable benefits template & script -->
		<style>
		.dp-benefit-item {
			background: #fdfdfd;
			border: 1px solid #e2e8f0;
			border-radius: 6px;
			padding: 20px;
			margin-bottom: 15px;
			position: relative;
			box-shadow: 0 1px 3px rgba(0,0,0,0.02);
		}
		.dp-benefit-item-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 12px;
			border-bottom: 1px dashed #e2e8f0;
			padding-bottom: 8px;
		}
		.dp-benefit-item-title-label {
			font-weight: 600;
			color: #2d3748;
		}
		.dp-benefit-item-controls {
			display: flex;
			gap: 5px;
		}
		.dp-benefit-field {
			margin-bottom: 10px;
		}
		.dp-benefit-field label {
			display: block;
			font-weight: 500;
			font-size: 11px;
			text-transform: uppercase;
			color: #718096;
			margin-bottom: 4px;
		}
		.dp-benefit-field input[type="text"],
		.dp-benefit-field textarea {
			width: 100%;
			box-sizing: border-box;
		}
		</style>

		<script>
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
		</script>
