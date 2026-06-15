/**
 * DentalPro Elite — Admin JavaScript
 *
 * Handles: color picker, media uploader, tab interactions, radio card selection.
 *
 * @package developer-starter-pro
 * @since   1.0.1
 */

(function ($) {
	'use strict';

	$(document).ready(function () {
		initColorPickers();
		initMediaUploader();
		initRemoveButtons();
		initRadioCards();
	});

	// =========================================================================
	// Color Pickers
	// =========================================================================
	function initColorPickers() {
		if (typeof $.fn.wpColorPicker !== 'function') {
			return;
		}
		$('.developer-starter-pro-color-picker').each(function () {
			var $this = $(this);
			var target = $this.attr('id');

			$this.wpColorPicker({
				change: function (event, ui) {
					// Update swatch preview.
					var color = ui.color.toString();
					if (target === 'color_primary') {
						$('#swatch-primary').css('background-color', color);
					} else if (target === 'color_secondary') {
						$('#swatch-secondary').css('background-color', color);
					} else if (target === 'color_accent') {
						$('#swatch-accent').css('background-color', color);
					}
				},
			});
		});
	}

	// =========================================================================
	// Media Uploader (requires wp.media)
	// =========================================================================
	function initMediaUploader() {
		if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
			return;
		}
		var mediaFrame;

		$(document).on('click', '.developer-starter-pro-upload-btn', function (e) {
			e.preventDefault();

			var $button = $(this);
			var targetInput = $button.data('target');
			var previewId = $button.data('preview');
			var mediaType = $button.data('type') || 'image';

			mediaFrame = wp.media({
				title: mediaType === 'video' ? 'Select Video' : (typeof developerStarterProAdmin !== 'undefined' ? developerStarterProAdmin.mediaTitle : 'Select Image'),
				button: { text: mediaType === 'video' ? 'Use this video' : (typeof developerStarterProAdmin !== 'undefined' ? developerStarterProAdmin.mediaButton : 'Use this image') },
				library: { type: mediaType },
				multiple: false,
			});

			mediaFrame.on('select', function () {
				var attachment = mediaFrame.state().get('selection').first().toJSON();
				$('#' + targetInput).val(attachment.url);
				if (previewId) {
					if (mediaType === 'video') {
						$('#' + previewId).html('<video src="' + attachment.url + '" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;" autoplay loop muted playsinline></video>');
					} else {
						$('#' + previewId).html('<img src="' + attachment.url + '" alt="Preview">');
					}
				}
				$button.siblings('.developer-starter-pro-remove-btn').show();
			});

			mediaFrame.open();
		});
	}

	// =========================================================================
	// Remove Buttons (NO wp.media dependency — always works)
	// =========================================================================
	function initRemoveButtons() {
		$(document).on('click', '.developer-starter-pro-remove-btn', function (e) {
			e.preventDefault();

			var targetInput = $(this).data('target');
			var previewId = $(this).data('preview');

			$('#' + targetInput).val('');
			$('#' + previewId).html('');
			$(this).hide();
		});
	}

	// =========================================================================
	// Radio Cards — Visual Selection
	// =========================================================================
	function initRadioCards() {
		$(document).on('change', '.developer-starter-pro-radio-card input[type="radio"]', function () {
			var $card = $(this).closest('.developer-starter-pro-radio-card');
			var $group = $card.closest('.developer-starter-pro-header-styles');

			$group.find('.developer-starter-pro-radio-card').removeClass('selected');
			$card.addClass('selected');
		});
	}
})(jQuery);
