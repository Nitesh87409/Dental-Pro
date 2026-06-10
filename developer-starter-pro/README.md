# DentalPro Elite — WordPress Theme

🦷 A premium, professional WordPress theme designed specifically for dental clinics, dentists, and healthcare professionals. Built completely dependency-free from scratch following professional coding standards.

---

## 🚀 Complete Development Roadmap

- **Week 1: Foundation** ✅ COMPLETE — Theme structure, Custom Post Types, custom taxonomies, meta boxes, and native 6-tab Theme Options Panel.
- **Week 2: Design** ✅ COMPLETE — 4 Header styles, 3 Footer styles, WhatsApp floating bubble, and Swiper.js slider with dynamic admin slide uploads.
- **Week 3: Inner Templates** ✅ COMPLETE — Gallery lightboxes, FAQ accordions, contact maps, about pages, and service pricing package grids.
- **Week 4: Booking System** ✅ COMPLETE — Custom database table installation, time slot calculation algorithms, scheduler admin managers, and REST APIs.
- **Week 5: Advanced Features** ✅ COMPLETE — AI rule-based Chatbot FAQ widget, custom patient portal, and treatment cost calculators.
- **Week 6: Polish & Schema** ✅ COMPLETE — Custom email templates, automated daily WP-Cron reminders, and structured JSON-LD schemas.

---

## 🛠️ Key Feature Guides

### 1. Swiper.js Hero Slider
Admins can upload hero slide assets under **DentalPro → Hero Slider** in the WordPress dashboard. Supports video background check toggles, animated parallax headings, highlight brackets keywords rotation, and clinical badge counters.

### 2. Multi-Step Appointment Scheduler
A frontend multi-step booking wizard rendered via [template-booking.php](file:///D:/Dental%20Pro/developer-starter-pro/page-templates/template-booking.php). 
- Automatically generates daily 30-minute intervals according to doctor availability settings.
- Filters out already reserved slots dynamically via REST API.
- Submits form payloads to REST endpoint `/wp-json/dentalpro/v1/book`.
- Status logs and actions (Approve, Complete, Cancel) are managed under **DentalPro → Appointments**.

### 3. AI Chatbot FAQ Widget
Floating chat bubble enqueued globally. Uses rule-based search matching matching queries against admin-configured Q&A pairs.
- Configure settings and answers under **DentalPro Settings → Chatbot FAQs**.
- Matches keywords via `/wp-json/dentalpro/v1/chatbot/query`.
- Automatically responds with typing animations. Fallback states render booking links and WhatsApp triggers when matches aren't resolved.

### 4. Patient Portal Dashboard
Leverages custom user role `'dental_patient'` restricting portal files to medical accounts.
- **Pages**: Templates for Login, Registration, and Dashboard.
- **Sync**: Queries `wp_dental_appointments` matching the patient account email to display past and upcoming clinical logs.
- **Secure metadata**: Allows patients to edit allergies, active medications, and conditions stored securely to user meta tables.

### 5. Cost Treatment Calculator
Interactive sliding widget matching the shortcode `[dental_calculator]`.
- Pulls base clinical prices dynamically from the Services CPT.
- Uses range inputs to calculate insurance savings and net out-of-pocket values.
- Stores selection indices to sessionStorage, pre-filling Step 1 of the Scheduler upon redirection.

### 6. Email Customizations & WP-Cron
- Configure Subjects and HTML email body layouts under **DentalPro Settings → Email Templates**.
- Uses replacement codes (e.g. `{patient_name}`, `{doctor_name}`, `{date}`, `{time}`) for instant bookings alerts.
- Schedules daily checks via task `dentalpro_daily_reminder_cron` to alert tomorrow's patients.

### 7. Structured JSON-LD Markups
Automatically injects Schema.org compliant structured scripts into `wp_head` for search engine optimization (SEO):
- **Front page**: outputs `Dentist` business schema (logo, phone, address, coordinates, hours).
- **Doctors singular profiles**: outputs `Physician` specialized data.
- **Services singular pages**: outputs `Service` pricing tables.
- **FAQ pages**: outputs `FAQPage` index maps.
- **Inner pages**: outputs `BreadcrumbList` navigation paths.

---

## ⚙️ Installation

1. Upload the `developer-starter-pro` folder to `/wp-content/themes/`
2. Go to **Appearance → Themes** and activate "DentalPro Elite"
3. Go to **DentalPro Settings → Theme Settings** to configure logo and clinic information.

---

## 📋 Security & WPCS Compliance
- **Database queries**: Prepared with `$wpdb->prepare` including strict types placeholders (`%d` cast pagination limits and offsets).
- **Forms**: Fully protected using `check_admin_referer()` nonces and `current_user_can('manage_options')` capability validation.
- **Escape**: All HTML output templates processed via safe functions (`esc_html`, `esc_attr`, `esc_url`, `esc_textarea`).

---

## License
GPL v2 or later
