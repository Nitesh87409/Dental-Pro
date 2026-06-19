/**
 * AI Chatbot Frontend Script
 */
(function ($) {
	'use strict';

	$(document).ready(function () {
		var $wrapper = $('.dentalpro-chatbot-wrapper');
		var $toggle = $('.dentalpro-chatbot-toggle');
		var $messages = $('.dentalpro-chatbot-messages');
		var $input = $('#dentalpro-chatbot-input-field');
		var $sendBtn = $('#dentalpro-chatbot-send');
		var $typing = $('.dentalpro-chatbot-typing');
		
		var chatHistory = [];

		// Toggle window
		$toggle.on('click', function () {
			$wrapper.toggleClass('open');
			if ($wrapper.hasClass('open')) {
				setTimeout(function() {
					$input.focus();
				}, 300);
			}
		});

		// Send message
		function sendMessage() {
			var message = $input.val().trim();
			if (!message) return;

			// Add user message to UI
			appendMessage('user', message);
			$input.val('');

			// Add to history
			chatHistory.push({ role: 'user', content: message });

			// Show typing indicator and scroll to bottom
			$typing.addClass('active');
			scrollToBottom();

			// Disable input while waiting
			$input.prop('disabled', true);
			$sendBtn.prop('disabled', true);

			// AJAX call
			$.ajax({
				url: developerStarterProAjax.ajaxUrl,
				type: 'POST',
				data: {
					action: 'developer_starter_pro_chatbot_message',
					nonce: developerStarterProAjax.nonce,
					message: message,
					history: JSON.stringify(chatHistory)
				},
				success: function (response) {
					$typing.removeClass('active');
					$input.prop('disabled', false).focus();
					$sendBtn.prop('disabled', false);

					if (response.success && response.data.reply) {
						var reply = response.data.reply;
						appendMessage('ai', reply);
						chatHistory.push({ role: 'assistant', content: reply });
					} else {
						appendMessage('ai', 'Sorry, I am having trouble connecting right now. Please try again later.');
					}
				},
				error: function () {
					$typing.removeClass('active');
					$input.prop('disabled', false).focus();
					$sendBtn.prop('disabled', false);
					appendMessage('ai', 'Network error. Please check your connection.');
				}
			});
		}

		function appendMessage(sender, text) {
			// Convert markdown to HTML
			var formattedText = text;
			
			// Bold
			formattedText = formattedText.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
			// Italic
			formattedText = formattedText.replace(/\*(.*?)\*/g, '<em>$1</em>');
			// Markdown links
			formattedText = formattedText.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank" style="color: var(--developer-starter-pro-primary); text-decoration: underline; font-weight: 600;">$1</a>');
			// Raw URLs (basic regex that avoids touching existing hrefs)
			formattedText = formattedText.replace(/(^|[^"'])(https?:\/\/[^\s<)]+)/g, '$1<a href="$2" target="_blank" style="color: var(--developer-starter-pro-primary); text-decoration: underline; font-weight: 600;">$2</a>');
			// Choice Buttons
			formattedText = formattedText.replace(/\[BTN:\s*(.+?)\]/g, '<button class="developer-starter-pro-chatbot-choice-btn" data-value="$1">$1</button>');
			// Convert basic newlines to HTML
			formattedText = formattedText.replace(/\n/g, '<br>');
			
			var msgHtml = '<div class="dentalpro-chatbot-msg msg-' + sender + '">' + formattedText + '</div>';
			$(msgHtml).insertBefore($typing);
			scrollToBottom();
		}

		function scrollToBottom() {
			$messages.scrollTop($messages[0].scrollHeight);
		}

		// Events
		$sendBtn.on('click', function (e) {
			e.preventDefault();
			sendMessage();
		});

		$input.on('keypress', function (e) {
			if (e.which === 13) {
				e.preventDefault();
				sendMessage();
			}
		});

		// Dynamic Choice Buttons Click
		$messages.on('click', '.developer-starter-pro-chatbot-choice-btn', function() {
			var val = $(this).data('value');
			$input.val(val);
			sendMessage();
			// Disable all buttons in this message to prevent double clicking
			$(this).siblings('.developer-starter-pro-chatbot-choice-btn').addBack().prop('disabled', true).css('opacity', '0.6');
		});
	});

})(jQuery);
