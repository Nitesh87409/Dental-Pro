/**
 * DentalPro Elite — Admin JavaScript
 *
 * Handles: color picker, media uploader, tab interactions, radio card selection.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

(function ($) {
	'use strict';

	$(document).ready(function () {
		initColorPickers();
		initMediaUploader();
		initRadioCards();
	});

	// =========================================================================
	// Color Pickers
	// =========================================================================
	function initColorPickers() {
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
	// Media Uploader
	// =========================================================================
	function initMediaUploader() {
		var mediaFrame;

		$(document).on('click', '.developer-starter-pro-upload-btn', function (e) {
			e.preventDefault();

			var $button = $(this);
			var targetInput = $button.data('target');
			var previewId = $button.data('preview');

			mediaFrame = wp.media({
				title: developerStarterProAdmin.mediaTitle || 'Select Image',
				button: { text: developerStarterProAdmin.mediaButton || 'Use this image' },
				multiple: false,
			});

			mediaFrame.on('select', function () {
				var attachment = mediaFrame.state().get('selection').first().toJSON();
				$('#' + targetInput).val(attachment.url);
				$('#' + previewId).html('<img src="' + attachment.url + '" alt="Preview">');
				$button.siblings('.developer-starter-pro-remove-btn').show();
			});

			mediaFrame.open();
		});

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
