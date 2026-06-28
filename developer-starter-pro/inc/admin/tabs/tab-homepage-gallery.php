<?php
/**
 * Tab: homepage_gallery
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
$gallery_items = isset( $options['gallery_items'] ) ? $options['gallery_items'] : array();
		if ( ! is_array( $gallery_items ) ) {
			$gallery_items = array();
		}
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'Homepage Gallery Section', 'developer-starter-pro' ); ?></h2>

			<table class="form-table">
				<tr>
					<th><label for="gallery_section_badge"><?php esc_html_e( 'Section Badge / Eyebrow', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="gallery_section_badge" name="<?php echo esc_attr( $this->option_name ); ?>[gallery_section_badge]" value="<?php echo esc_attr( isset( $options['gallery_section_badge'] ) ? $options['gallery_section_badge'] : 'Our Facility' ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Small label shown above the section title.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="gallery_section_title"><?php esc_html_e( 'Section Title', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="gallery_section_title" name="<?php echo esc_attr( $this->option_name ); ?>[gallery_section_title]" value="<?php echo esc_attr( isset( $options['gallery_section_title'] ) ? $options['gallery_section_title'] : 'Modern Dental Clinic Showcase' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="gallery_section_subtitle"><?php esc_html_e( 'Section Subtitle / Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="gallery_section_subtitle" name="<?php echo esc_attr( $this->option_name ); ?>[gallery_section_subtitle]" rows="3" class="large-text"><?php echo esc_textarea( isset( $options['gallery_section_subtitle'] ) ? $options['gallery_section_subtitle'] : '' ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Gallery Items (Repeatable)', 'developer-starter-pro' ); ?></th>
					<td>
						<div id="homepage-gallery-container" class="dp-repeatable-container">
							<!-- Items will be loaded here dynamically by JS -->
						</div>
						
						<!-- Hidden input storing serialized gallery data -->
						<input type="hidden" id="homepage_gallery_input" name="<?php echo esc_attr( $this->option_name ); ?>[gallery_items]" value="<?php echo esc_attr( wp_json_encode( $gallery_items ) ); ?>">
						
						<button type="button" class="button button-secondary" id="dp-add-gallery-item-btn" style="margin-top: 15px;">
							<span class="dashicons dashicons-plus" style="vertical-align: middle; margin-top: -3px;"></span>
							<?php esc_html_e( 'Add New Gallery Item', 'developer-starter-pro' ); ?>
						</button>
					</td>
				</tr>
			</table>
		</div>

		<!-- Repeatable gallery template & script -->
		<style>
		.dp-gallery-item {
			background: #fdfdfd;
			border: 1px solid #e2e8f0;
			border-radius: 6px;
			padding: 20px;
			margin-bottom: 15px;
			position: relative;
			box-shadow: 0 1px 3px rgba(0,0,0,0.02);
		}
		.dp-gallery-item-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 12px;
			border-bottom: 1px dashed #e2e8f0;
			padding-bottom: 8px;
		}
		.dp-gallery-item-title-label {
			font-weight: 600;
			color: #2d3748;
		}
		.dp-gallery-item-controls {
			display: flex;
			gap: 5px;
		}
		.dp-gallery-field {
			margin-bottom: 10px;
		}
		.dp-gallery-field label {
			display: block;
			font-weight: 500;
			font-size: 11px;
			text-transform: uppercase;
			color: #718096;
			margin-bottom: 4px;
		}
		.dp-gallery-field input[type="text"] {
			width: 100%;
			box-sizing: border-box;
		}
		.dp-gallery-img-preview img {
			max-width: 120px;
			height: 80px;
			object-fit: cover;
			border: 1px solid #e2e8f0;
			border-radius: 4px;
			display: block;
			margin-top: 8px;
		}
		</style>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			var container = document.getElementById('homepage-gallery-container');
			var inputEl = document.getElementById('homepage_gallery_input');
			var addBtn = document.getElementById('dp-add-gallery-item-btn');
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
					container.innerHTML = '<div style="padding: 15px; background: #f7fafc; border: 1px dashed #cbd5e0; border-radius: 4px; color: #718096; text-align: center;"><?php esc_html_e( 'No gallery items added yet. Click "Add New Gallery Item" below.', 'developer-starter-pro' ); ?></div>';
					return;
				}

				items.forEach(function(item, idx) {
					var itemDiv = document.createElement('div');
					itemDiv.className = 'dp-gallery-item';
					
					var html = '<div class="dp-gallery-item-header">';
					html += '<span class="dp-gallery-item-title-label">Gallery Item #' + (idx + 1) + (item.title ? ': ' + item.title : '') + '</span>';
					html += '<div class="dp-gallery-item-controls">';
					
					// Sort buttons
					if (idx > 0) {
						html += '<button type="button" class="button button-small dp-gallery-move-up-btn" data-index="' + idx + '">▲</button>';
					}
					if (idx < items.length - 1) {
						html += '<button type="button" class="button button-small dp-gallery-move-down-btn" data-index="' + idx + '">▼</button>';
					}
					
					html += '<button type="button" class="button button-small button-link-delete dp-gallery-delete-btn" data-index="' + idx + '"><?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?></button>';
					html += '</div></div>';

					// Image field with WordPress Uploader integration
					html += '<div class="dp-gallery-field">';
					html += '<label>Image</label>';
					html += '<div style="display:flex; gap:8px;">';
					html += '<input type="text" id="dp_gallery_img_' + idx + '" class="dp-gallery-image-url regular-text" value="' + escapeHtml(item.image || '') + '" data-index="' + idx + '" style="flex:1;">';
					html += '<button type="button" class="button developer-starter-pro-upload-btn" data-target="dp_gallery_img_' + idx + '" data-preview="dp_gallery_preview_' + idx + '">Choose Image</button>';
					html += '</div>';
					html += '<div id="dp_gallery_preview_' + idx + '" class="dp-gallery-img-preview">';
					if (item.image) {
						html += '<img src="' + escapeHtml(item.image) + '" alt="Preview">';
					}
					html += '</div>';
					html += '</div>';

					// Title
					html += '<div class="dp-gallery-field">';
					html += '<label>Title / Caption</label>';
					html += '<input type="text" class="dp-gallery-title" value="' + escapeHtml(item.title || '') + '" data-index="' + idx + '">';
					html += '</div>';

					itemDiv.innerHTML = html;
					container.appendChild(itemDiv);
				});

				// Bind change/input events
				container.querySelectorAll('.dp-gallery-image-url').forEach(function(el) {
					el.addEventListener('change', function() {
						var index = parseInt(this.getAttribute('data-index'));
						items[index].image = this.value;
						updateHiddenInput();
					});
				});

				container.querySelectorAll('.dp-gallery-title').forEach(function(el) {
					el.addEventListener('input', function() {
						var index = parseInt(this.getAttribute('data-index'));
						items[index].title = this.value;
						
						// Update label real-time
						var headerLabel = this.closest('.dp-gallery-item').querySelector('.dp-gallery-item-title-label');
						if (headerLabel) {
							headerLabel.textContent = 'Gallery Item #' + (index + 1) + (this.value ? ': ' + this.value : '');
						}
						updateHiddenInput();
					});
				});

				// Bind control buttons
				container.querySelectorAll('.dp-gallery-delete-btn').forEach(function(el) {
					el.addEventListener('click', function() {
						var index = parseInt(this.getAttribute('data-index'));
						items.splice(index, 1);
						updateHiddenInput();
						renderItems();
					});
				});

				container.querySelectorAll('.dp-gallery-move-up-btn').forEach(function(el) {
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

				container.querySelectorAll('.dp-gallery-move-down-btn').forEach(function(el) {
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
					image: '',
					title: ''
				});
				updateHiddenInput();
				renderItems();
			});

			renderItems();
		});
		</script>
