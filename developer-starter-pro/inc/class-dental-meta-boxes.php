<?php
/**
 * Meta Boxes
 *
 * Custom meta boxes for all CPTs:
 * - Doctors: speciality, experience, qualifications, schedule, social links
 * - Services: price, duration, icon, short description
 * - Testimonials: patient name, rating, treatment
 * - Appointments: patient info, doctor, date, time, status, notes
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Meta_Boxes {

	/**
	 * Meta key prefix.
	 *
	 * @var string
	 */
	private $prefix = '_developer_starter_pro_';

	/**
	 * Constructor — hook into WordPress.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_doctor_meta' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_service_meta' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_testimonial_meta' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_appointment_meta' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_before_after_meta' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_location_meta' ), 10, 2 );
	}

	/**
	 * Register all meta boxes.
	 */
	public function register_meta_boxes() {
		// Doctor meta boxes.
		add_meta_box(
			'developer_starter_pro_doctor_details',
			esc_html__( 'Doctor Details', 'developer-starter-pro' ),
			array( $this, 'render_doctor_details' ),
			'doctors',
			'normal',
			'high'
		);

		add_meta_box(
			'developer_starter_pro_doctor_schedule',
			esc_html__( 'Working Schedule', 'developer-starter-pro' ),
			array( $this, 'render_doctor_schedule' ),
			'doctors',
			'normal',
			'default'
		);

		add_meta_box(
			'developer_starter_pro_doctor_social',
			esc_html__( 'Social Links', 'developer-starter-pro' ),
			array( $this, 'render_doctor_social' ),
			'doctors',
			'side',
			'default'
		);

		// Service meta box.
		add_meta_box(
			'developer_starter_pro_service_details',
			esc_html__( 'Service Details', 'developer-starter-pro' ),
			array( $this, 'render_service_details' ),
			'services',
			'normal',
			'high'
		);

		// Testimonial meta box.
		add_meta_box(
			'developer_starter_pro_testimonial_details',
			esc_html__( 'Testimonial Details', 'developer-starter-pro' ),
			array( $this, 'render_testimonial_details' ),
			'testimonials',
			'normal',
			'high'
		);

		// Appointment meta box.
		add_meta_box(
			'developer_starter_pro_appointment_details',
			esc_html__( 'Appointment Details', 'developer-starter-pro' ),
			array( $this, 'render_appointment_details' ),
			'appointments',
			'normal',
			'high'
		);

		// Before & After meta box.
		add_meta_box(
			'developer_starter_pro_before_after_details',
			esc_html__( 'Before & After Details', 'developer-starter-pro' ),
			array( $this, 'render_before_after_details' ),
			'before_after',
			'normal',
			'high'
		);

		// Location Details meta box.
		add_meta_box(
			'developer_starter_pro_location_details',
			esc_html__( 'Location Details', 'developer-starter-pro' ),
			array( $this, 'render_location_details' ),
			'locations',
			'normal',
			'high'
		);

		// Doctor Location assignment meta box.
		add_meta_box(
			'developer_starter_pro_doctor_location',
			esc_html__( 'Branch Location Assignment', 'developer-starter-pro' ),
			array( $this, 'render_doctor_location' ),
			'doctors',
			'side',
			'default'
		);
	}

	// =========================================================================
	// DOCTOR META BOXES
	// =========================================================================

	/**
	 * Render Doctor Details meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_doctor_details( $post ) {
		wp_nonce_field( 'developer_starter_pro_doctor_details', 'developer_starter_pro_doctor_nonce' );

		$speciality     = get_post_meta( $post->ID, $this->prefix . 'doctor_speciality', true );
		$experience     = get_post_meta( $post->ID, $this->prefix . 'doctor_experience', true );
		$qualifications = get_post_meta( $post->ID, $this->prefix . 'doctor_qualifications', true );
		$education      = get_post_meta( $post->ID, $this->prefix . 'doctor_education', true );
		$phone          = get_post_meta( $post->ID, $this->prefix . 'doctor_phone', true );
		$email          = get_post_meta( $post->ID, $this->prefix . 'doctor_email', true );
		?>
		<div class="developer-starter-pro-meta-box">
			<table class="form-table">
				<tr>
					<th><label for="doctor_speciality"><?php esc_html_e( 'Speciality', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="doctor_speciality" name="doctor_speciality" value="<?php echo esc_attr( $speciality ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g., Orthodontist, Oral Surgeon', 'developer-starter-pro' ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="doctor_experience"><?php esc_html_e( 'Experience (Years)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="number" id="doctor_experience" name="doctor_experience" value="<?php echo esc_attr( $experience ); ?>" class="small-text" min="0" max="60">
						<span class="description"><?php esc_html_e( 'Years of experience', 'developer-starter-pro' ); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="doctor_qualifications"><?php esc_html_e( 'Qualifications', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="doctor_qualifications" name="doctor_qualifications" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'BDS, MDS, FICOI (one per line)', 'developer-starter-pro' ); ?>"><?php echo esc_textarea( $qualifications ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Enter qualifications, one per line', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="doctor_education"><?php esc_html_e( 'Education', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="doctor_education" name="doctor_education" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'University Name - Degree (one per line)', 'developer-starter-pro' ); ?>"><?php echo esc_textarea( $education ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="doctor_phone"><?php esc_html_e( 'Direct Phone', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="tel" id="doctor_phone" name="doctor_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="doctor_email"><?php esc_html_e( 'Email', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="email" id="doctor_email" name="doctor_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text">
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Doctor Schedule meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_doctor_schedule( $post ) {
		$schedule = get_post_meta( $post->ID, $this->prefix . 'doctor_schedule', true );
		$schedule = is_array( $schedule ) ? $schedule : array();

		$days = array(
			'monday'    => esc_html__( 'Monday', 'developer-starter-pro' ),
			'tuesday'   => esc_html__( 'Tuesday', 'developer-starter-pro' ),
			'wednesday' => esc_html__( 'Wednesday', 'developer-starter-pro' ),
			'thursday'  => esc_html__( 'Thursday', 'developer-starter-pro' ),
			'friday'    => esc_html__( 'Friday', 'developer-starter-pro' ),
			'saturday'  => esc_html__( 'Saturday', 'developer-starter-pro' ),
			'sunday'    => esc_html__( 'Sunday', 'developer-starter-pro' ),
		);
		?>
		<div class="developer-starter-pro-meta-box">
			<table class="widefat fixed striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Day', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Start Time', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'End Time', 'developer-starter-pro' ); ?></th>
						<th><?php esc_html_e( 'Available', 'developer-starter-pro' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $days as $key => $label ) :
					$start     = isset( $schedule[ $key ]['start'] ) ? $schedule[ $key ]['start'] : '09:00';
					$end       = isset( $schedule[ $key ]['end'] ) ? $schedule[ $key ]['end'] : '17:00';
					$available = isset( $schedule[ $key ]['available'] ) ? $schedule[ $key ]['available'] : ( 'sunday' === $key ? '0' : '1' );
				?>
					<tr>
						<td><strong><?php echo esc_html( $label ); ?></strong></td>
						<td><input type="time" name="doctor_schedule[<?php echo esc_attr( $key ); ?>][start]" value="<?php echo esc_attr( $start ); ?>"></td>
						<td><input type="time" name="doctor_schedule[<?php echo esc_attr( $key ); ?>][end]" value="<?php echo esc_attr( $end ); ?>"></td>
						<td>
							<select name="doctor_schedule[<?php echo esc_attr( $key ); ?>][available]">
								<option value="1" <?php selected( $available, '1' ); ?>><?php esc_html_e( 'Available', 'developer-starter-pro' ); ?></option>
								<option value="0" <?php selected( $available, '0' ); ?>><?php esc_html_e( 'Not Available', 'developer-starter-pro' ); ?></option>
							</select>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Doctor Social Links meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_doctor_social( $post ) {
		$social = get_post_meta( $post->ID, $this->prefix . 'doctor_social', true );
		$social = is_array( $social ) ? $social : array();

		$platforms = array(
			'facebook'  => 'Facebook',
			'instagram' => 'Instagram',
			'twitter'   => 'Twitter / X',
			'linkedin'  => 'LinkedIn',
		);
		?>
		<div class="developer-starter-pro-meta-box">
			<?php foreach ( $platforms as $key => $label ) : ?>
				<p>
					<label for="doctor_social_<?php echo esc_attr( $key ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label><br>
					<input type="url" id="doctor_social_<?php echo esc_attr( $key ); ?>" name="doctor_social[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_url( isset( $social[ $key ] ) ? $social[ $key ] : '' ); ?>" class="widefat" placeholder="https://">
				</p>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Save Doctor meta.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public function save_doctor_meta( $post_id, $post ) {
		if ( 'doctors' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['developer_starter_pro_doctor_nonce'] ) || ! wp_verify_nonce( $_POST['developer_starter_pro_doctor_nonce'], 'developer_starter_pro_doctor_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save text fields.
		$text_fields = array( 'doctor_speciality', 'doctor_experience', 'doctor_qualifications', 'doctor_education', 'doctor_phone', 'doctor_email' );

		foreach ( $text_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = sanitize_text_field( wp_unslash( $_POST[ $field ] ) );
				if ( 'doctor_qualifications' === $field || 'doctor_education' === $field ) {
					$value = sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) );
				}
				if ( 'doctor_email' === $field ) {
					$value = sanitize_email( wp_unslash( $_POST[ $field ] ) );
				}
				if ( 'doctor_experience' === $field ) {
					$value = absint( $_POST[ $field ] );
				}
				update_post_meta( $post_id, $this->prefix . $field, $value );
			}
		}

		// Save schedule.
		if ( isset( $_POST['doctor_schedule'] ) && is_array( $_POST['doctor_schedule'] ) ) {
			$schedule = array();
			foreach ( $_POST['doctor_schedule'] as $day => $data ) {
				$schedule[ sanitize_key( $day ) ] = array(
					'start'     => sanitize_text_field( $data['start'] ),
					'end'       => sanitize_text_field( $data['end'] ),
					'available' => sanitize_text_field( $data['available'] ),
				);
			}
			update_post_meta( $post_id, $this->prefix . 'doctor_schedule', $schedule );
		}

		// Save social links.
		if ( isset( $_POST['doctor_social'] ) && is_array( $_POST['doctor_social'] ) ) {
			$social = array();
			foreach ( $_POST['doctor_social'] as $platform => $url ) {
				$social[ sanitize_key( $platform ) ] = esc_url_raw( $url );
			}
			update_post_meta( $post_id, $this->prefix . 'doctor_social', $social );
		}

		// Save Location Assignment
		if ( isset( $_POST['doctor_location_id'] ) ) {
			update_post_meta( $post_id, $this->prefix . 'doctor_location_id', absint( wp_unslash( $_POST['doctor_location_id'] ) ) );
		}
	}

	// =========================================================================
	// SERVICE META BOX
	// =========================================================================

	/**
	 * Render Service Details meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_service_details( $post ) {
		wp_nonce_field( 'developer_starter_pro_service_details', 'developer_starter_pro_service_nonce' );

		$price       = get_post_meta( $post->ID, $this->prefix . 'service_price', true );
		$duration    = get_post_meta( $post->ID, $this->prefix . 'service_duration', true );
		$icon        = get_post_meta( $post->ID, $this->prefix . 'service_icon', true );
		$custom_svg  = get_post_meta( $post->ID, $this->prefix . 'service_custom_svg', true );
		$short_desc  = get_post_meta( $post->ID, $this->prefix . 'service_short_description', true );
		$card_image  = get_post_meta( $post->ID, $this->prefix . 'service_card_image', true );
		?>
		<div class="developer-starter-pro-meta-box">
			<table class="form-table">
				<tr>
					<th><label for="service_price"><?php esc_html_e( 'Price ($)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="number" id="service_price" name="service_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" min="0" step="0.01" placeholder="0.00">
						<p class="description"><?php esc_html_e( 'Starting price for this service. Enter 0 for "Contact for Price".', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="service_duration"><?php esc_html_e( 'Duration (minutes)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="number" id="service_duration" name="service_duration" value="<?php echo esc_attr( $duration ); ?>" class="small-text" min="0" step="5">
						<span class="description"><?php esc_html_e( 'Average treatment duration in minutes', 'developer-starter-pro' ); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="service_icon"><?php esc_html_e( 'Icon Selection', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="service_icon" name="service_icon" class="regular-text">
							<option value=""><?php esc_html_e( '— Default Theme Fallback —', 'developer-starter-pro' ); ?></option>
							<?php 
							if ( function_exists( 'developer_starter_pro_get_service_icons' ) ) {
								foreach ( developer_starter_pro_get_service_icons() as $key => $icon_data ) {
									echo '<option value="' . esc_attr( $key ) . '" ' . selected( $icon, $key, false ) . '>' . esc_html( $icon_data['label'] ) . '</option>';
								}
							}
							?>
						</select>
						<p class="description"><?php esc_html_e( 'Choose a premium, modern line-art icon to represent this service.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="service_custom_svg"><?php esc_html_e( 'Custom SVG Icon (Optional)', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="service_custom_svg" name="service_custom_svg" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'e.g., <svg>...</svg>', 'developer-starter-pro' ); ?>"><?php echo esc_textarea( $custom_svg ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Paste raw SVG XML code to use a custom icon. This overrides the dropdown selection above.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="service_short_description"><?php esc_html_e( 'Short Description', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="service_short_description" name="service_short_description" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'Brief description for service cards (max 150 characters)', 'developer-starter-pro' ); ?>"><?php echo esc_textarea( $short_desc ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label><?php esc_html_e( 'Card Background Image', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div style="margin-bottom:8px;">
							<?php if ( ! empty( $card_image ) ) : ?>
								<img id="service-card-image-preview" src="<?php echo esc_url( $card_image ); ?>" alt="Card Image" style="max-width:200px;height:auto;display:block;border-radius:6px;border:1px solid #ddd;margin-bottom:8px;">
							<?php else : ?>
								<img id="service-card-image-preview" src="" alt="" style="max-width:200px;height:auto;display:none;border-radius:6px;border:1px solid #ddd;margin-bottom:8px;">
							<?php endif; ?>
						</div>
						<input type="hidden" id="service_card_image" name="service_card_image" value="<?php echo esc_url( $card_image ); ?>">
						<button type="button" class="button developer-starter-pro-upload-btn" data-target="service_card_image" data-preview="service-card-image-preview">
							<?php esc_html_e( 'Upload / Choose Image', 'developer-starter-pro' ); ?>
						</button>
						<?php if ( ! empty( $card_image ) ) : ?>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="service_card_image" data-preview="service-card-image-preview">
								<?php esc_html_e( 'Remove Image', 'developer-starter-pro' ); ?>
							</button>
						<?php else : ?>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="service_card_image" data-preview="service-card-image-preview" style="display:none;">
								<?php esc_html_e( 'Remove Image', 'developer-starter-pro' ); ?>
							</button>
						<?php endif; ?>
						<p class="description"><?php esc_html_e( 'Upload a background image for this service card strip. If set, it will replace the gradient color with the image + dark overlay.', 'developer-starter-pro' ); ?></p>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Save Service meta.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public function save_service_meta( $post_id, $post ) {
		if ( 'services' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['developer_starter_pro_service_nonce'] ) || ! wp_verify_nonce( $_POST['developer_starter_pro_service_nonce'], 'developer_starter_pro_service_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = array(
			'service_price'             => 'floatval',
			'service_duration'          => 'absint',
			'service_icon'              => 'sanitize_text_field',
			'service_custom_svg'        => 'wp_kses_post',
			'service_short_description' => 'sanitize_textarea_field',
			'service_card_image'        => 'esc_url_raw',
		);

		foreach ( $fields as $field => $sanitize_callback ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = call_user_func( $sanitize_callback, wp_unslash( $_POST[ $field ] ) );
				update_post_meta( $post_id, $this->prefix . $field, $value );
			}
		}
	}

	// =========================================================================
	// TESTIMONIAL META BOX
	// =========================================================================

	/**
	 * Render Testimonial Details meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_testimonial_details( $post ) {
		wp_nonce_field( 'developer_starter_pro_testimonial_details', 'developer_starter_pro_testimonial_nonce' );

		$patient_name = get_post_meta( $post->ID, $this->prefix . 'testimonial_patient_name', true );
		$rating       = get_post_meta( $post->ID, $this->prefix . 'testimonial_rating', true );
		$treatment    = get_post_meta( $post->ID, $this->prefix . 'testimonial_treatment', true );
		?>
		<div class="developer-starter-pro-meta-box">
			<table class="form-table">
				<tr>
					<th><label for="testimonial_patient_name"><?php esc_html_e( 'Patient Name', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="testimonial_patient_name" name="testimonial_patient_name" value="<?php echo esc_attr( $patient_name ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'Patient display name', 'developer-starter-pro' ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="testimonial_rating"><?php esc_html_e( 'Rating', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="testimonial_rating" name="testimonial_rating">
							<option value="5" <?php selected( $rating, '5' ); ?>>★★★★★ (5 Stars)</option>
							<option value="4" <?php selected( $rating, '4' ); ?>>★★★★☆ (4 Stars)</option>
							<option value="3" <?php selected( $rating, '3' ); ?>>★★★☆☆ (3 Stars)</option>
							<option value="2" <?php selected( $rating, '2' ); ?>>★★☆☆☆ (2 Stars)</option>
							<option value="1" <?php selected( $rating, '1' ); ?>>★☆☆☆☆ (1 Star)</option>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="testimonial_treatment"><?php esc_html_e( 'Treatment Received', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="testimonial_treatment" name="testimonial_treatment" value="<?php echo esc_attr( $treatment ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g., Teeth Whitening, Root Canal', 'developer-starter-pro' ); ?>">
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Save Testimonial meta.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public function save_testimonial_meta( $post_id, $post ) {
		if ( 'testimonials' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['developer_starter_pro_testimonial_nonce'] ) || ! wp_verify_nonce( $_POST['developer_starter_pro_testimonial_nonce'], 'developer_starter_pro_testimonial_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = array(
			'testimonial_patient_name' => 'sanitize_text_field',
			'testimonial_rating'       => 'absint',
			'testimonial_treatment'    => 'sanitize_text_field',
		);

		foreach ( $fields as $field => $sanitize_callback ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = call_user_func( $sanitize_callback, wp_unslash( $_POST[ $field ] ) );
				update_post_meta( $post_id, $this->prefix . $field, $value );
			}
		}
	}

	// =========================================================================
	// APPOINTMENT META BOX
	// =========================================================================

	/**
	 * Render Appointment Details meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_appointment_details( $post ) {
		wp_nonce_field( 'developer_starter_pro_appointment_details', 'developer_starter_pro_appointment_nonce' );

		$patient_name  = get_post_meta( $post->ID, $this->prefix . 'appointment_patient_name', true );
		$patient_email = get_post_meta( $post->ID, $this->prefix . 'appointment_patient_email', true );
		$patient_phone = get_post_meta( $post->ID, $this->prefix . 'appointment_patient_phone', true );
		$doctor_id     = get_post_meta( $post->ID, $this->prefix . 'appointment_doctor_id', true );
		$service_id    = get_post_meta( $post->ID, $this->prefix . 'appointment_service_id', true );
		$appt_date     = get_post_meta( $post->ID, $this->prefix . 'appointment_date', true );
		$appt_time     = get_post_meta( $post->ID, $this->prefix . 'appointment_time', true );
		$status        = get_post_meta( $post->ID, $this->prefix . 'appointment_status', true );
		$notes         = get_post_meta( $post->ID, $this->prefix . 'appointment_notes', true );

		// Get doctors list.
		$doctors = get_posts( array(
			'post_type'      => 'doctors',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		) );

		// Get services list.
		$services = get_posts( array(
			'post_type'      => 'services',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		) );
		?>
		<div class="developer-starter-pro-meta-box">
			<table class="form-table">
				<tr>
					<th><label for="appointment_patient_name"><?php esc_html_e( 'Patient Name', 'developer-starter-pro' ); ?></label></th>
					<td><input type="text" id="appointment_patient_name" name="appointment_patient_name" value="<?php echo esc_attr( $patient_name ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="appointment_patient_email"><?php esc_html_e( 'Patient Email', 'developer-starter-pro' ); ?></label></th>
					<td><input type="email" id="appointment_patient_email" name="appointment_patient_email" value="<?php echo esc_attr( $patient_email ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="appointment_patient_phone"><?php esc_html_e( 'Patient Phone', 'developer-starter-pro' ); ?></label></th>
					<td><input type="tel" id="appointment_patient_phone" name="appointment_patient_phone" value="<?php echo esc_attr( $patient_phone ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="appointment_doctor_id"><?php esc_html_e( 'Doctor', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="appointment_doctor_id" name="appointment_doctor_id" class="regular-text">
							<option value=""><?php esc_html_e( '— Select Doctor —', 'developer-starter-pro' ); ?></option>
							<?php foreach ( $doctors as $doctor ) : ?>
								<option value="<?php echo esc_attr( $doctor->ID ); ?>" <?php selected( $doctor_id, $doctor->ID ); ?>><?php echo esc_html( $doctor->post_title ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="appointment_service_id"><?php esc_html_e( 'Service', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="appointment_service_id" name="appointment_service_id" class="regular-text">
							<option value=""><?php esc_html_e( '— Select Service —', 'developer-starter-pro' ); ?></option>
							<?php foreach ( $services as $service ) : ?>
								<option value="<?php echo esc_attr( $service->ID ); ?>" <?php selected( $service_id, $service->ID ); ?>><?php echo esc_html( $service->post_title ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="appointment_date"><?php esc_html_e( 'Appointment Date', 'developer-starter-pro' ); ?></label></th>
					<td><input type="date" id="appointment_date" name="appointment_date" value="<?php echo esc_attr( $appt_date ); ?>"></td>
				</tr>
				<tr>
					<th><label for="appointment_time"><?php esc_html_e( 'Appointment Time', 'developer-starter-pro' ); ?></label></th>
					<td><input type="time" id="appointment_time" name="appointment_time" value="<?php echo esc_attr( $appt_time ); ?>"></td>
				</tr>
				<tr>
					<th><label for="appointment_status"><?php esc_html_e( 'Status', 'developer-starter-pro' ); ?></label></th>
					<td>
						<select id="appointment_status" name="appointment_status">
							<option value="pending" <?php selected( $status, 'pending' ); ?>><?php esc_html_e( 'Pending', 'developer-starter-pro' ); ?></option>
							<option value="confirmed" <?php selected( $status, 'confirmed' ); ?>><?php esc_html_e( 'Confirmed', 'developer-starter-pro' ); ?></option>
							<option value="cancelled" <?php selected( $status, 'cancelled' ); ?>><?php esc_html_e( 'Cancelled', 'developer-starter-pro' ); ?></option>
							<option value="completed" <?php selected( $status, 'completed' ); ?>><?php esc_html_e( 'Completed', 'developer-starter-pro' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="appointment_notes"><?php esc_html_e( 'Notes', 'developer-starter-pro' ); ?></label></th>
					<td>
						<textarea id="appointment_notes" name="appointment_notes" rows="4" class="large-text"><?php echo esc_textarea( $notes ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Save Appointment meta.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public function save_appointment_meta( $post_id, $post ) {
		if ( 'appointments' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['developer_starter_pro_appointment_nonce'] ) || ! wp_verify_nonce( $_POST['developer_starter_pro_appointment_nonce'], 'developer_starter_pro_appointment_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = array(
			'appointment_patient_name'  => 'sanitize_text_field',
			'appointment_patient_email' => 'sanitize_email',
			'appointment_patient_phone' => 'sanitize_text_field',
			'appointment_doctor_id'     => 'absint',
			'appointment_service_id'    => 'absint',
			'appointment_date'          => 'sanitize_text_field',
			'appointment_time'          => 'sanitize_text_field',
			'appointment_status'        => 'sanitize_text_field',
			'appointment_notes'         => 'sanitize_textarea_field',
		);

		foreach ( $fields as $field => $sanitize_callback ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = call_user_func( $sanitize_callback, wp_unslash( $_POST[ $field ] ) );
				update_post_meta( $post_id, $this->prefix . $field, $value );
			}
		}
	}

	/**
	 * Render Before & After Details meta box.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_before_after_details( $post ) {
		wp_nonce_field( 'developer_starter_pro_before_after_details', 'developer_starter_pro_before_after_nonce' );

		$before_image = get_post_meta( $post->ID, $this->prefix . 'before_image', true );
		$after_image  = get_post_meta( $post->ID, $this->prefix . 'after_image', true );
		$before_label = get_post_meta( $post->ID, $this->prefix . 'before_label', true );
		$after_label  = get_post_meta( $post->ID, $this->prefix . 'after_label', true );

		// Defaults
		$before_label = $before_label ? $before_label : esc_html__( 'Before Treatment', 'developer-starter-pro' );
		$after_label  = $after_label ? $after_label : esc_html__( 'After Treatment', 'developer-starter-pro' );
		?>
		<div class="developer-starter-pro-meta-box">
			<table class="form-table">
				<tr>
					<th><label for="before_image"><?php esc_html_e( 'Before Image', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="before_image" name="before_image" value="<?php echo esc_url( $before_image ); ?>">
							<div class="developer-starter-pro-logo-preview" id="before-image-preview" style="max-width: 150px; max-height: 150px; margin-bottom: 10px;">
								<?php if ( ! empty( $before_image ) ) : ?>
									<img src="<?php echo esc_url( $before_image ); ?>" alt="Before Preview" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="before_image" data-preview="before-image-preview">
								<?php esc_html_e( 'Upload Before Image', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="before_image" data-preview="before-image-preview" <?php echo empty( $before_image ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="before_label"><?php esc_html_e( 'Before Image Label', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="before_label" name="before_label" value="<?php echo esc_attr( $before_label ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="after_image"><?php esc_html_e( 'After Image', 'developer-starter-pro' ); ?></label></th>
					<td>
						<div class="developer-starter-pro-media-upload">
							<input type="hidden" id="after_image" name="after_image" value="<?php echo esc_url( $after_image ); ?>">
							<div class="developer-starter-pro-logo-preview" id="after-image-preview" style="max-width: 150px; max-height: 150px; margin-bottom: 10px;">
								<?php if ( ! empty( $after_image ) ) : ?>
									<img src="<?php echo esc_url( $after_image ); ?>" alt="After Preview" style="max-width: 100%; height: auto; display: block; border-radius: 4px; border: 1px solid #ddd;">
								<?php endif; ?>
							</div>
							<button type="button" class="button developer-starter-pro-upload-btn" data-target="after_image" data-preview="after-image-preview">
								<?php esc_html_e( 'Upload After Image', 'developer-starter-pro' ); ?>
							</button>
							<button type="button" class="button developer-starter-pro-remove-btn" data-target="after_image" data-preview="after-image-preview" <?php echo empty( $after_image ) ? 'style="display:none"' : ''; ?>>
								<?php esc_html_e( 'Remove', 'developer-starter-pro' ); ?>
							</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="after_label"><?php esc_html_e( 'After Image Label', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="after_label" name="after_label" value="<?php echo esc_attr( $after_label ); ?>" class="regular-text">
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Save Before & After meta.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public function save_before_after_meta( $post_id, $post ) {
		if ( 'before_after' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['developer_starter_pro_before_after_nonce'] ) || ! wp_verify_nonce( $_POST['developer_starter_pro_before_after_nonce'], 'developer_starter_pro_before_after_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = array(
			'before_image' => 'esc_url_raw',
			'after_image'  => 'esc_url_raw',
			'before_label' => 'sanitize_text_field',
			'after_label'  => 'sanitize_text_field',
		);

		foreach ( $fields as $field => $sanitize_callback ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = call_user_func( $sanitize_callback, wp_unslash( $_POST[ $field ] ) );
				update_post_meta( $post_id, $this->prefix . $field, $value );
			}
		}
	}

	/**
	 * Render Location Details meta box.
	 */
	public function render_location_details( $post ) {
		wp_nonce_field( 'developer_starter_pro_location_details', 'developer_starter_pro_location_nonce' );

		$address = get_post_meta( $post->ID, $this->prefix . 'location_address', true );
		$phone   = get_post_meta( $post->ID, $this->prefix . 'location_phone', true );
		$email   = get_post_meta( $post->ID, $this->prefix . 'location_email', true );
		?>
		<div class="developer-starter-pro-meta-box">
			<table class="form-table">
				<tr>
					<th><label for="location_address"><?php esc_html_e( 'Address', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="text" id="location_address" name="location_address" value="<?php echo esc_attr( $address ); ?>" class="large-text" placeholder="<?php esc_attr_e( '123 Branch St, City', 'developer-starter-pro' ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="location_phone"><?php esc_html_e( 'Phone Number', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="tel" id="location_phone" name="location_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="location_email"><?php esc_html_e( 'Email Address', 'developer-starter-pro' ); ?></label></th>
					<td>
						<input type="email" id="location_email" name="location_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text">
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render Doctor Location selection dropdown.
	 */
	public function render_doctor_location( $post ) {
		$selected_location = get_post_meta( $post->ID, $this->prefix . 'doctor_location_id', true );

		$locations = get_posts( array(
			'post_type'      => 'locations',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );
		?>
		<div class="developer-starter-pro-meta-box">
			<label for="doctor_location_id"><strong><?php esc_html_e( 'Assigned Branch:', 'developer-starter-pro' ); ?></strong></label>
			<select id="doctor_location_id" name="doctor_location_id" class="widefat" style="margin-top: 8px;">
				<option value="0"><?php esc_html_e( '— No Location (General) —', 'developer-starter-pro' ); ?></option>
				<?php foreach ( $locations as $loc ) : ?>
					<option value="<?php echo esc_attr( $loc->ID ); ?>" <?php selected( $selected_location, $loc->ID ); ?>>
						<?php echo esc_html( $loc->post_title ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php
	}

	/**
	 * Save Location meta.
	 */
	public function save_location_meta( $post_id, $post ) {
		if ( 'locations' !== $post->post_type ) {
			return;
		}

		if ( ! isset( $_POST['developer_starter_pro_location_nonce'] ) || ! wp_verify_nonce( $_POST['developer_starter_pro_location_nonce'], 'developer_starter_pro_location_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = array(
			'location_address' => 'sanitize_text_field',
			'location_phone'   => 'sanitize_text_field',
			'location_email'   => 'sanitize_email',
		);

		foreach ( $fields as $field => $sanitize_callback ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = call_user_func( $sanitize_callback, wp_unslash( $_POST[ $field ] ) );
				update_post_meta( $post_id, $this->prefix . $field, $value );
			}
		}
	}
}
