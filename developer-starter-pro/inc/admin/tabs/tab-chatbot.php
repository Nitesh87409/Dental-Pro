<?php
/**
 * Tab: chatbot
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
$chatbot_enable        = isset( $options['chatbot_enable'] ) ? $options['chatbot_enable'] : '0';
		$chatbot_api_url       = isset( $options['chatbot_api_url'] ) ? $options['chatbot_api_url'] : 'https://api.openai.com/v1/chat/completions';
		$chatbot_api_key       = isset( $options['chatbot_api_key'] ) ? $options['chatbot_api_key'] : '';
		$chatbot_model         = isset( $options['chatbot_model'] ) ? $options['chatbot_model'] : 'gpt-3.5-turbo';
		
		$default_prompt = 'You are a helpful dental assistant for our clinic. Your job is to help patients and book appointments. You must ask the patient for their: Name, Phone number, Date, Time, and Service needed. Be polite and ask one or two questions at a time. ONCE you have collected all the required details, you MUST reply with a success message AND include exactly this JSON block at the very end of your response: {"action": "book_appointment", "name": "Patient Name", "phone": "Phone Number", "email": "", "date": "YYYY-MM-DD", "time": "HH:MM", "service": "Service Name"}';
		$chatbot_system_prompt = isset( $options['chatbot_system_prompt'] ) && ! empty( $options['chatbot_system_prompt'] ) ? $options['chatbot_system_prompt'] : $default_prompt;
		?>
		<div class="developer-starter-pro-settings-section">
			<h2><?php esc_html_e( 'AI Chatbot Integration', 'developer-starter-pro' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Configure your Universal AI Chatbot. You can use any OpenAI-compatible API (e.g., OpenAI, Groq, OpenRouter, TogetherAI).', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="chatbot_enable"><?php esc_html_e( 'Enable Chatbot', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="chatbot_enable" name="<?php echo esc_attr( $this->option_name ); ?>[chatbot_enable]" value="1" <?php checked( $chatbot_enable, '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
						</label>
						<p class="description"><?php esc_html_e( 'Turn the floating AI Chatbot widget on or off.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="chatbot_api_url"><?php esc_html_e( 'API Endpoint URL', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="url" id="chatbot_api_url" name="<?php echo esc_attr( $this->option_name ); ?>[chatbot_api_url]" value="<?php echo esc_attr( $chatbot_api_url ); ?>" class="regular-text" placeholder="https://api.openai.com/v1/chat/completions">
						<p class="description"><?php esc_html_e( 'The full chat completion URL.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="chatbot_model"><?php esc_html_e( 'Model Name', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="chatbot_model" name="<?php echo esc_attr( $this->option_name ); ?>[chatbot_model]" value="<?php echo esc_attr( $chatbot_model ); ?>" class="regular-text" placeholder="gpt-3.5-turbo">
						<p class="description"><?php esc_html_e( 'e.g., gpt-4, gpt-3.5-turbo, llama3-70b-8192', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="chatbot_api_key"><?php esc_html_e( 'API Key', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="password" id="chatbot_api_key" name="<?php echo esc_attr( $this->option_name ); ?>[chatbot_api_key]" value="<?php echo esc_attr( $chatbot_api_key ); ?>" class="regular-text" placeholder="sk-...">
						<p class="description"><?php esc_html_e( 'Your secret API key. It will be securely stored and never exposed to the frontend.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="chatbot_system_prompt"><?php esc_html_e( 'System Prompt', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="chatbot_system_prompt" name="<?php echo esc_attr( $this->option_name ); ?>[chatbot_system_prompt]" rows="6" class="large-text code"><?php echo esc_textarea( $chatbot_system_prompt ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Instruct the AI on how to behave. Tell it to only answer dental questions and act as a clinic assistant.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label><?php esc_html_e( 'API Test', 'developer-starter-pro' ); ?></label></th>
					<td>
						<button type="button" id="developer-starter-pro-test-api" class="button button-secondary">
							<?php esc_html_e( 'Test API Connection', 'developer-starter-pro' ); ?>
						</button>
						<span id="developer-starter-pro-test-result" style="margin-left: 10px; font-weight: 500;"></span>
						<p class="description"><?php esc_html_e( 'Click this to verify your API credentials without leaving the dashboard.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<div class="developer-starter-pro-settings-section" style="margin-top:30px; border-top: 2px solid #e0e0e0; padding-top: 24px;">
			<h2 style="display:flex; align-items:center; gap:10px;">
				<span style="font-size:22px;">🐛</span>
				<?php esc_html_e( 'Bug Report Widget', 'developer-starter-pro' ); ?>
			</h2>
			<p class="description"><?php esc_html_e( 'Enable a floating "Report a Problem" button on the frontend. Visitors can describe bugs, attach screenshots, and send reports directly to your admin email.', 'developer-starter-pro' ); ?></p>

			<table class="form-table">
				<tr>
					<th><label for="bugreport_enable"><?php esc_html_e( 'Enable Bug Report Widget', 'developer-starter-pro' ); ?></label></th>
					<td>
						<label class="developer-starter-pro-toggle">
							<input type="checkbox" id="bugreport_enable" name="<?php echo esc_attr( $this->option_name ); ?>[bugreport_enable]" value="1" <?php checked( isset( $options['bugreport_enable'] ) ? $options['bugreport_enable'] : '0', '1' ); ?>>
							<span class="developer-starter-pro-toggle-slider"></span>
						</label>
						<p class="description"><?php esc_html_e( 'Show a floating bug icon (bottom-left) on all frontend pages. Reports are sent to your clinic email address.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<script>
		jQuery(document).ready(function($) {
			$('#developer-starter-pro-test-api').on('click', function(e) {
				e.preventDefault();
				var btn = $(this);
				var resultSpan = $('#developer-starter-pro-test-result');
				
				var apiUrl = $('#chatbot_api_url').val();
				var apiKey = $('#chatbot_api_key').val();
				var model  = $('#chatbot_model').val();
				
				if (!apiUrl || !apiKey || !model) {
					resultSpan.css('color', 'red').text('Please fill API URL, Key, and Model to test.');
					return;
				}
				
				btn.prop('disabled', true).text('Testing...');
				resultSpan.text('');
				
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'developer_starter_pro_test_chatbot_api',
						nonce: '<?php echo esc_js( wp_create_nonce("developer_starter_pro_admin_nonce") ); ?>',
						api_url: apiUrl,
						api_key: apiKey,
						model: model
					},
					success: function(response) {
						if (response.success) {
							resultSpan.css('color', 'green').text(response.data);
						} else {
							resultSpan.css('color', 'red').text(response.data);
						}
					},
					error: function() {
						resultSpan.css('color', 'red').text('Server connection error.');
					},
					complete: function() {
						btn.prop('disabled', false).text('Test API Connection');
					}
				});
			});
		});
		</script>
