<?php
/**
 * AI Chatbot Module
 *
 * Handles backend AJAX requests from the frontend chatbot widget,
 * securely proxies them to the specified LLM API endpoint, and injects
 * the system prompt for strict role-playing control.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Chatbot {

	public function __construct() {
		add_action( 'wp_ajax_developer_starter_pro_chatbot_message', array( $this, 'handle_chat_message' ) );
		add_action( 'wp_ajax_nopriv_developer_starter_pro_chatbot_message', array( $this, 'handle_chat_message' ) );
		
		add_action( 'wp_ajax_developer_starter_pro_test_chatbot_api', array( $this, 'test_api_connection' ) );
	}

	/**
	 * Frontend Chat Handler
	 */
	public function handle_chat_message() {
		check_ajax_referer( 'developer_starter_pro_nonce', 'nonce' );

		$options = get_option( 'developer_starter_pro_options', array() );
		$is_enabled = isset( $options['chatbot_enable'] ) && '1' === $options['chatbot_enable'];
		
		if ( ! $is_enabled ) {
			wp_send_json_error( array( 'message' => 'Chatbot is disabled.' ) );
		}

		$user_message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
		$chat_history = isset( $_POST['history'] ) ? json_decode( wp_unslash( $_POST['history'] ), true ) : array();

		if ( empty( $user_message ) ) {
			wp_send_json_error( array( 'message' => 'Message is empty.' ) );
		}

		$api_url = ! empty( $options['chatbot_api_url'] ) ? $options['chatbot_api_url'] : 'https://api.openai.com/v1/chat/completions';
		$api_key = ! empty( $options['chatbot_api_key'] ) ? $options['chatbot_api_key'] : '';
		$model   = ! empty( $options['chatbot_model'] ) ? $options['chatbot_model'] : 'gpt-3.5-turbo';
		
		$default_prompt = 'You are a helpful dental assistant for our clinic. Only answer questions related to the clinic and dental services. If a patient wants to book an appointment, give them this exact link: ' . home_url( '/booking/' ) . ' and ask them to fill out the form.';
		$system  = ! empty( $options['chatbot_system_prompt'] ) ? $options['chatbot_system_prompt'] : $default_prompt;

		if ( empty( $api_key ) ) {
			wp_send_json_error( array( 'message' => 'API Key is not configured.' ) );
		}

		// --- Dynamic Context Injection ---
		global $wpdb;
		$table_name = class_exists('Developer_Starter_Pro_Booking') ? Developer_Starter_Pro_Booking::get_table_name() : $wpdb->prefix . 'dentalpro_appointments';
		
		$today = current_time('Y-m-d');
		$end_date = date('Y-m-d', strtotime(current_time('Y-m-d') . ' +30 days'));
		$booked_slots = $wpdb->get_results( $wpdb->prepare(
			"SELECT booking_date, time_slot FROM $table_name WHERE booking_date BETWEEN %s AND %s AND status NOT IN ('cancelled', 'rejected') ORDER BY booking_date ASC, time_slot ASC",
			$today, $end_date
		) );

		$system .= "\n\n--- SYSTEM REAL-TIME DATA ---\n";
		$system .= "Today's Date is: " . $today . "\n";
		$system .= "Clinic Business Hours: 09:00 to 18:00 (Monday - Friday). Do not offer appointments outside these hours or on weekends.\n";
		
		if ( ! empty($booked_slots) ) {
			$system .= "The following time slots are ALREADY BOOKED and UNAVAILABLE. DO NOT offer these exact times to the patient:\n";
			$last_date = '';
			foreach ( $booked_slots as $slot ) {
				if ( $last_date !== $slot->booking_date ) {
					$system .= "\n" . $slot->booking_date . ": ";
					$last_date = $slot->booking_date;
				}
				$system .= $slot->time_slot . ", ";
			}
			$system .= "\n";
		} else {
			$system .= "Currently, all time slots during business hours for the next 30 days are completely open and available.\n";
		}
		$system .= "-----------------------------\n";
		
		// Fetch clinics
		$locations = get_posts(array('post_type' => 'locations', 'posts_per_page' => -1, 'post_status' => 'publish'));
		if (!empty($locations)) {
			$system .= "\nAvailable Clinic Locations:\n";
			foreach($locations as $loc) {
				$address = get_post_meta($loc->ID, '_developer_starter_pro_location_address', true);
				$system .= "- " . $loc->post_title . ($address ? " ($address)" : "") . "\n";
			}
		}

		// Fetch doctors
		$doctors = get_posts(array('post_type' => 'doctors', 'posts_per_page' => -1, 'post_status' => 'publish'));
		if (!empty($doctors)) {
			$system .= "\nAvailable Doctors:\n";
			foreach($doctors as $doc) {
				$system .= "- " . $doc->post_title . "\n";
			}
		}

		$system .= "\nCRITICAL UI INSTRUCTION:\nWhen you ask the patient to select a Clinic Location or a Doctor, present the available options using exactly this format: [BTN: Option Name]. For example: [BTN: Dr. Sharma] or [BTN: Metro Plaza]. This will render as a clickable button in the patient's chat UI.\n";
		$system .= "-----------------------------\n";
		// ---------------------------------

		// Prepare messages array for OpenAI-compatible endpoint
		$messages = array(
			array(
				'role'    => 'system',
				'content' => $system
			)
		);

		// Append recent history (limit to last 10 to save tokens)
		if ( is_array( $chat_history ) ) {
			$history_slice = array_slice( $chat_history, -10 );
			foreach ( $history_slice as $msg ) {
				if ( isset( $msg['role'] ) && isset( $msg['content'] ) ) {
					$messages[] = array(
						'role'    => sanitize_text_field( $msg['role'] ),
						'content' => sanitize_textarea_field( $msg['content'] )
					);
				}
			}
		}

		$messages[] = array(
			'role'    => 'user',
			'content' => $user_message
		);

		$body = array(
			'model'       => $model,
			'messages'    => $messages,
			'temperature' => 0.7,
			'max_tokens'  => 500,
		);

		$args = array(
			'method'      => 'POST',
			'timeout'     => 45,
			'headers'     => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $api_key,
			),
			'body'        => wp_json_encode( $body ),
			'data_format' => 'body',
		);

		// Custom groq/anthropic/gemini handling if needed based on URL, but standard OpenAI format covers 90% of proxies.
		$response = wp_remote_post( $api_url, $args );

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => 'Connection error: ' . $response->get_error_message() ) );
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		$body_json   = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( 200 !== $status_code ) {
			$err_msg = isset( $body_json['error']['message'] ) ? $body_json['error']['message'] : 'API Error ' . $status_code;
			wp_send_json_error( array( 'message' => $err_msg ) );
		}

		if ( isset( $body_json['choices'][0]['message']['content'] ) ) {
			$reply = $body_json['choices'][0]['message']['content'];
			
			// Intercept {"action": "book_appointment", "cancel_appointment", "reschedule_appointment", "check_status"...}
			if ( preg_match('/\{[\s\S]*"action"\s*:\s*"(book_appointment|cancel_appointment|reschedule_appointment|check_status)"[\s\S]*\}/', $reply, $matches) ) {
				$json_str = $matches[0];
				$booking_data = json_decode($json_str, true);
				
				if ( $booking_data && isset($booking_data['action']) ) {
					global $wpdb;
					$table_name = $wpdb->prefix . 'dentalpro_appointments'; // fallback
					if ( class_exists('Developer_Starter_Pro_Booking') ) {
						$table_name = Developer_Starter_Pro_Booking::get_table_name();
					}

					$action = $booking_data['action'];

					if ( $action === 'book_appointment' ) {
						$req_date = isset($booking_data['date']) ? sanitize_text_field($booking_data['date']) : date('Y-m-d');
						$req_time = isset($booking_data['time']) ? sanitize_text_field($booking_data['time']) : '10:00';

						// 1. Conflict Check
						$existing = $wpdb->get_var( $wpdb->prepare(
							"SELECT COUNT(*) FROM $table_name WHERE booking_date = %s AND time_slot = %s AND status NOT IN ('cancelled', 'rejected')",
							$req_date, $req_time
						) );

						if ( $existing > 0 ) {
							$reply = "I apologize, but the time slot at **$req_time** on **$req_date** is already booked. Please choose a different time or date.";
						} else {
							// 2. Approval Mode Check
							$approval_mode = isset( $options['appointment_approval_mode'] ) ? $options['appointment_approval_mode'] : 'automatic';
							$final_status  = ( 'automatic' === $approval_mode ) ? 'confirmed' : 'pending';

							// 3. Insert
							$data = array(
								'patient_name'     => isset($booking_data['name']) ? sanitize_text_field($booking_data['name']) : 'Unknown',
								'patient_phone'    => isset($booking_data['phone']) ? sanitize_text_field($booking_data['phone']) : '',
								'patient_email'    => isset($booking_data['email']) ? sanitize_email($booking_data['email']) : '',
								'location_id'      => 0,
								'doctor_id'        => 0,
								'service_id'       => 0,
								'booking_date'     => $req_date,
								'time_slot'        => $req_time,
								'status'           => $final_status,
								'payment_status'   => 'unpaid',
								'booking_source'   => 'ai_chatbot',
								'appointment_type' => 'clinic_visit',
								'notes'            => isset($booking_data['service']) ? 'Service requested: ' . sanitize_text_field($booking_data['service']) : '',
								'internal_notes'   => 'Booked via AI Chatbot.'
							);
							$formats = array( '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
							$inserted = $wpdb->insert( $table_name, $data, $formats );
							
							$reply = str_replace($json_str, '', $reply);
							$reply = trim($reply);

							if ( $inserted ) {
							$appointment_id = $wpdb->insert_id;
							// Fire the correct hooks so notifications (email/SMS) are sent
							do_action( 'dentalpro_appointment_booked', $appointment_id );
							if ( 'confirmed' === $final_status ) {
								do_action( 'dentalpro_appointment_status_changed', $appointment_id, 'pending', 'confirmed' );
							}

							// Direct SMS fallback — hooks may fail for chatbot bookings (doctor_id=0)
						$patient_phone = isset($booking_data['phone']) ? sanitize_text_field($booking_data['phone']) : '';
						$patient_name  = isset($booking_data['name']) ? sanitize_text_field($booking_data['name']) : 'Patient';
						$service_label = isset($booking_data['service']) ? sanitize_text_field($booking_data['service']) : 'Dental Service';
						$apt_ref       = 'APT-' . str_pad( $appointment_id, 5, '0', STR_PAD_LEFT );
						$apt_date_fmt  = date_i18n( get_option('date_format'), strtotime($req_date) );
						$apt_time_fmt  = date('g:i A', strtotime($req_time));

						// Use admin-editable SMS template
						if ( class_exists('Developer_Starter_Pro_Notifications') ) {
							$notifier = new Developer_Starter_Pro_Notifications();
							$sms_settings = $notifier->get_settings();
							$sms_template = isset($sms_settings['sms_template']) ? $sms_settings['sms_template'] : 'Hello {patient_name}, your appointment (Ref: {appointment_id}) for {service_name} on {appointment_date} at {appointment_time} has been confirmed. Thank you!';
							$sms_message = str_replace(
								array('{patient_name}', '{appointment_id}', '{service_name}', '{appointment_date}', '{appointment_time}', '{patient_phone}', '{doctor_name}'),
								array($patient_name, $apt_ref, $service_label, $apt_date_fmt, $apt_time_fmt, $patient_phone, 'Our Dental Team'),
								$sms_template
							);
							if ( ! empty($patient_phone) ) {
								$notifier->dispatch_sms( $patient_phone, $sms_message );
							}
							}

							$formatted_id = $apt_ref;
							$status_text = ( 'confirmed' === $final_status ) ? 'Confirmed ✅' : 'Pending Approval ⏳';
							$reply .= "\n\n**Appointment ID:** " . $formatted_id;
							$reply .= "\n**Status:** " . $status_text;
							} else {
								$reply = "There was a system error while trying to save your appointment. Please call the clinic directly.";
							}
						}
					} 
					elseif ( $action === 'cancel_appointment' || $action === 'reschedule_appointment' ) {
						$apt_string = isset($booking_data['appointment_id']) ? sanitize_text_field($booking_data['appointment_id']) : '';
						$apt_id = (int) str_replace('APT-', '', strtoupper($apt_string));
						$phone = isset($booking_data['phone']) ? sanitize_text_field($booking_data['phone']) : '';

						// Authentication
						$appointment = $wpdb->get_row( $wpdb->prepare(
							"SELECT * FROM $table_name WHERE id = %d AND patient_phone = %s",
							$apt_id, $phone
						) );

						$reply = str_replace($json_str, '', $reply);
						$reply = trim($reply);

						if ( ! $appointment ) {
							$reply = "Authentication Failed: We could not find an appointment with that ID and Phone Number. Please check your details and try again.";
						} else {
							if ( $action === 'cancel_appointment' ) {
								$wpdb->update( $table_name, array( 'status' => 'cancelled' ), array( 'id' => $apt_id ), array( '%s' ), array( '%d' ) );
								do_action( 'dentalpro_appointment_status_changed', $apt_id, $appointment->status, 'cancelled' );
								$reply .= "\n\n✅ Your appointment (APT-" . str_pad($apt_id, 5, '0', STR_PAD_LEFT) . ") has been successfully cancelled.";
							} 
							elseif ( $action === 'reschedule_appointment' ) {
								$req_date = isset($booking_data['date']) ? sanitize_text_field($booking_data['date']) : '';
								$req_time = isset($booking_data['time']) ? sanitize_text_field($booking_data['time']) : '';

								// Conflict Check
								$existing = $wpdb->get_var( $wpdb->prepare(
									"SELECT COUNT(*) FROM $table_name WHERE booking_date = %s AND time_slot = %s AND status NOT IN ('cancelled', 'rejected')",
									$req_date, $req_time
								) );

								if ( $existing > 0 ) {
									$reply = "I apologize, but the new time slot at **$req_time** on **$req_date** is already booked. Please choose a different time.";
								} else {
									$wpdb->update( $table_name, array( 'booking_date' => $req_date, 'time_slot' => $req_time ), array( 'id' => $apt_id ), array( '%s', '%s' ), array( '%d' ) );
									do_action( 'dentalpro_appointment_rescheduled', $apt_id );
									$reply .= "\n\n✅ Your appointment (APT-" . str_pad($apt_id, 5, '0', STR_PAD_LEFT) . ") has been successfully rescheduled to **$req_date** at **$req_time**.";
								}
							}
						}
					} 
					elseif ( $action === 'check_status' ) {
						$apt_string = isset($booking_data['appointment_id']) ? sanitize_text_field($booking_data['appointment_id']) : '';
						$apt_id = (int) str_replace('APT-', '', strtoupper($apt_string));
						$phone = isset($booking_data['phone']) ? sanitize_text_field($booking_data['phone']) : '';

						$reply = str_replace($json_str, '', $reply);
						$reply = trim($reply);

						$appointment = $wpdb->get_row( $wpdb->prepare(
							"SELECT * FROM $table_name WHERE id = %d AND patient_phone = %s",
							$apt_id, $phone
						) );

						if ( ! $appointment ) {
							$reply .= "\n\n⚠️ **System Update:** We could not find any appointment matching ID **$apt_string** and Phone **$phone**. Please check the details and try again.";
						} else {
							$service_name = get_the_title($appointment->service_id);
							if (empty($service_name)) {
								$service_name = str_replace('Service requested: ', '', $appointment->notes);
							}
							$apt_date = date_i18n( get_option('date_format'), strtotime($appointment->booking_date) );
							$apt_time = date('g:i A', strtotime($appointment->time_slot));
							$status_display = ucfirst($appointment->status);
							if ($appointment->status === 'confirmed') $status_display .= ' ✅';
							if ($appointment->status === 'cancelled') $status_display .= ' ❌';
							if ($appointment->status === 'pending') $status_display .= ' ⏳';

							$reply .= "\n\n📊 **Status Update for $apt_string:**\n";
							$reply .= "- **Service:** " . $service_name . "\n";
							$reply .= "- **Date:** " . $apt_date . " at " . $apt_time . "\n";
							$reply .= "- **Current Status:** **" . $status_display . "**";
						}
					}
				}
			}

			wp_send_json_success( array( 'reply' => $reply ) );
		} else {
			wp_send_json_error( array( 'message' => 'Invalid response format from API.' ) );
		}
	}

	/**
	 * Admin API Tester
	 */
	public function test_api_connection() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Permission denied.' );
		}
		
		check_ajax_referer( 'developer_starter_pro_admin_nonce', 'nonce' );

		$api_url = isset( $_POST['api_url'] ) ? esc_url_raw( wp_unslash( $_POST['api_url'] ) ) : '';
		$api_key = isset( $_POST['api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['api_key'] ) ) : '';
		$model   = isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : '';

		if ( empty( $api_url ) || empty( $api_key ) || empty( $model ) ) {
			wp_send_json_error( 'Please provide URL, Key, and Model to test.' );
		}

		$body = array(
			'model'    => $model,
			'messages' => array(
				array( 'role' => 'user', 'content' => 'Say "API Connection Successful!"' )
			),
			'max_tokens' => 10,
		);

		$args = array(
			'method'  => 'POST',
			'timeout' => 15,
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $api_key,
			),
			'body'    => wp_json_encode( $body ),
		);

		$response = wp_remote_post( $api_url, $args );

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( 'Error: ' . $response->get_error_message() );
		}

		$status = wp_remote_retrieve_response_code( $response );
		$body_json = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( 200 === $status && isset( $body_json['choices'][0]['message']['content'] ) ) {
			wp_send_json_success( 'Success! AI Response: ' . $body_json['choices'][0]['message']['content'] );
		} else {
			$err = isset( $body_json['error']['message'] ) ? $body_json['error']['message'] : wp_remote_retrieve_body( $response );
			wp_send_json_error( 'API Error (' . $status . '): ' . $err );
		}
	}
}

new Developer_Starter_Pro_Chatbot();
