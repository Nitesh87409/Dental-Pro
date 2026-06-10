/**
 * AI Chatbot Frontend Actions
 *
 * @package developer-starter-pro
 */

document.addEventListener('DOMContentLoaded', function() {
	var chatbotContainer = document.getElementById('dental-chatbot-container');
	if (!chatbotContainer) return;

	var bubble = document.getElementById('dental-chatbot-bubble');
	var drawer = document.getElementById('dental-chatbot-drawer');
	var closeBtn = document.getElementById('dental-chatbot-close');
	
	var iconOpen = bubble.querySelector('.chatbot-icon-open');
	var iconClose = bubble.querySelector('.chatbot-icon-close');
	
	var messagesBody = document.getElementById('chatbot-messages-body');
	var quickReplies = document.getElementById('chatbot-quick-replies');
	var typingIndicator = document.getElementById('chatbot-typing-indicator');
	
	var inputForm = document.getElementById('chatbot-input-form');
	var userInput = document.getElementById('chatbot-user-input');

	// Fallback actions URL from window.dentalChatbotData
	var config = window.dentalChatbotData || {
		bookingUrl: '/booking/',
		whatsappUrl: 'https://wa.me/'
	};

	var l10n = window.developerStarterProChatbot || {
		restUrl: '/wp-json/dentalpro/v1/'
	};

	// Toggle Chat Window
	bubble.addEventListener('click', function() {
		var isHidden = drawer.style.display === 'none';
		if (isHidden) {
			drawer.style.display = 'flex';
			iconOpen.style.display = 'none';
			iconClose.style.display = 'block';
			scrollToBottom();
		} else {
			closeChat();
		}
	});

	closeBtn.addEventListener('click', closeChat);

	function closeChat() {
		drawer.style.display = 'none';
		iconOpen.style.display = 'block';
		iconClose.style.display = 'none';
	}

	// Message UI Helpers
	function appendMessage(text, sender) {
		var msg = document.createElement('div');
		msg.className = 'chatbot-message ' + sender + '-msg';
		
		var content = document.createElement('div');
		content.className = 'message-content';
		content.innerHTML = text; // Safe raw inserts or innerHTML if link templates are added
		msg.appendChild(content);
		
		messagesBody.appendChild(msg);
		scrollToBottom();
	}

	function scrollToBottom() {
		messagesBody.scrollTop = messagesBody.scrollHeight;
	}

	function showTyping(show) {
		typingIndicator.style.display = show ? 'flex' : 'none';
		scrollToBottom();
	}

	// Trigger Query REST endpoint
	function queryBot(question) {
		appendMessage(question, 'user');
		showTyping(true);
		
		// Hide quick replies momentarily
		if (quickReplies) quickReplies.style.display = 'none';

		fetch(l10n.restUrl + 'chatbot/query?q=' + encodeURIComponent(question))
			.then(function(res) { return res.json(); })
			.then(function(data) {
				// Simulate standard typing delay (800ms)
				setTimeout(function() {
					showTyping(false);
					
					if (data.fallback) {
						// Render standard answers + fallback links
						var responseHTML = data.answer + '<div class="chatbot-fallback-actions" style="display:flex; flex-direction:column; gap:8px; margin-top:12px;">' +
							'<a href="' + config.bookingUrl + '" class="chatbot-action-btn cta-btn">📅 Book Appointment</a>' +
							'<a href="' + config.whatsappUrl + '" target="_blank" class="chatbot-action-btn wa-btn">💬 Chat on WhatsApp</a>' +
							'</div>';
						appendMessage(responseHTML, 'bot');
					} else {
						appendMessage(data.answer, 'bot');
					}

					// Show quick replies again
					if (quickReplies) quickReplies.style.display = 'flex';
				}, 800);
			})
			.catch(function() {
				setTimeout(function() {
					showTyping(false);
					appendMessage('Communication check failed. Please check connection.', 'bot');
					if (quickReplies) quickReplies.style.display = 'flex';
				}, 800);
			});
	}

	// Input form triggers
	inputForm.addEventListener('submit', function(e) {
		e.preventDefault();
		var val = userInput.value.trim();
		if (!val) return;
		userInput.value = '';
		queryBot(val);
	});

	// Quick Replies handler
	messagesBody.addEventListener('click', function(e) {
		if (e.target.classList.contains('quick-reply-btn') && !e.target.classList.contains('cta-btn')) {
			e.preventDefault();
			var question = e.target.getAttribute('data-question');
			queryBot(question);
		}
	});
});
