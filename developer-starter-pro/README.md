# DentalPro Elite — WordPress Theme

**Version:** 1.0.6  
**Author:** NiteshCodes  
**License:** GPL v2 or later  
**Requires WordPress:** 6.0+  
**Requires PHP:** 7.4+  
**Tested up to:** 6.7

---

## Description

**DentalPro Elite** is a premium WordPress theme built specifically for dental clinics, dentists, orthodontists, and oral healthcare professionals. It combines a modern dark glassmorphic design with powerful built-in functionality — no page builder required.

---

## Features

### Core Theme
- Premium dark glassmorphic UI design
- 4 pre-built Header styles (Classic, Centered, Full Width, Transparent)
- 3 Footer layout options
- Swiper.js Hero Slider with video background support
- Fully responsive — mobile, tablet, desktop
- Dark Mode toggle (admin panel + frontend)
- Translation ready (`.pot` file included)
- RTL stylesheet support

### Homepage Sections (12 Built-In)
The homepage (`front-page.php`) is assembled from modular template parts:

1. **Hero Slider** — Full-width carousel with image/video backgrounds and CTA buttons
2. **Services Grid** — Pulls services from the Services CPT with icons and pricing
3. **Why Choose Us** — Configurable benefit cards with SVG icons
4. **Doctors Showcase** — Team carousel from the Doctors CPT
5. **Testimonials** — Patient review slider with star ratings
6. **Before & After** — Interactive comparison slider from the Before & After CPT
7. **CTA Booking Banner** — Full-width appointment call-to-action section
8. **Gallery** — Clinic photo gallery with lightbox
9. **Google Reviews** — External review aggregation display
10. **FAQ Accordion** — Collapsible FAQ section from the FAQs CPT
11. **Blog Posts** — Latest articles (toggle on/off from admin)
12. **Stats Counter** — Animated statistics (patients, years, specialists, locations)

### Custom Post Types (7)
- **Doctors** — Profiles with specialisation, experience, schedule, ratings
- **Services** — Dental treatments with pricing, duration, and SVG icons
- **Testimonials** — Patient reviews with star ratings
- **Appointments** — Full booking records management (admin-only)
- **Before & After** — Treatment transformation cases with interactive image slider
- **Locations** — Multi-branch clinic management with maps and hours
- **FAQs** — Frequently asked questions with category grouping

### Custom Taxonomies (4)
- **Departments** — Group doctors and services by department (e.g., Orthodontics)
- **Treatment Types** — Categorize services (e.g., Preventive, Cosmetic)
- **Case Categories** — Organize before/after cases (e.g., Veneers, Whitening)
- **FAQ Categories** — Group FAQs (e.g., Insurance, Procedures)

### Appointment Booking System
- Multi-step frontend booking wizard
- Auto-generated time slots per doctor based on working schedule
- REST API slot availability checker
- Admin Booking Manager (Approve / Complete / Cancel / Reschedule)
- WP-Cron automated daily appointment reminder emails
- Custom branded HTML email templates with `.ics` calendar attachment
- Appointment tracking page (patients can look up status by Reference ID)
- SMS notifications via Twilio or Custom HTTP Gateway
- CSV/Excel export of appointment data

### AI Chatbot (LLM-Powered)
- Floating chat widget with typing animations
- Powered by any **OpenAI-compatible API** (OpenAI, Groq, OpenRouter, TogetherAI, etc.)
- Configurable system prompt, model, and API endpoint from admin panel
- **Live booking capabilities** — patients can book, cancel, reschedule, and check appointment status directly through the chat
- Dynamic context injection: real-time booked slot data, available doctors, and clinic locations are injected into the system prompt
- Conflict checking before booking (prevents double-booking)
- SMS notification dispatch on chatbot-booked appointments
- Admin API test button to verify credentials without leaving the dashboard
- AJAX-based (secure WordPress nonce verification)

### Bug Report System
- Floating "Report a Problem" button (bottom-left)
- Modal form: name, email, priority level, description, screenshot attachment
- Branded HTML email sent to admin with full context (page URL, browser, IP, timestamp)
- Rate limiting (5 reports/hour per IP)
- Enable/disable toggle in admin panel

### SEO & Schema
- JSON-LD structured data: `Dentist`, `Physician`, `Service`, `FAQPage`, `BreadcrumbList`
- Auto-injected via `wp_head` with clinic address, phone, coordinates, hours

### WooCommerce Styling
- CSS-level styling for WooCommerce product grids, cart, checkout, and account pages
- Dark mode compatibility for all WooCommerce elements

---

## Installation

1. Upload the `developer-starter-pro` folder to `/wp-content/themes/`
2. Go to **Appearance → Themes** and activate **DentalPro Elite**
3. Navigate to **DentalPro Settings** to configure logo, clinic info, colors, and booking options
4. Import demo data via **Tools → Import → WordPress** using the included XML file

---

## Demo Data

A sample `demo-data.xml` is included in `/demo-data/`. Import via **Tools → Import → WordPress** to populate dummy doctors, services, testimonials, and appointments.

---

## Page Templates

### Auto-Created Pages (14)
DentalPro Elite automatically creates pages with pre-assigned templates on activation:

| Page | Template | URL Slug |
|------|----------|----------|
| Pricing Packages | `template-pricing.php` | `/pricing/` |
| Track Appointment | `template-tracking.php` | `/tracking/` |
| About Us | `template-about.php` | `/about/` |
| Contact Us | `template-contact.php` | `/contact/` |
| FAQs | `template-faq.php` | `/faq/` |
| Gallery | `template-gallery.php` | `/gallery/` |
| Services Directory | `template-services.php` | `/services/` |
| Doctors Directory | `template-doctors.php` | `/doctors/` |
| Emergency Care | — *(page created, template pending)* | `/emergency/` |
| Blog Catalog | `template-blog.php` | `/blog/` |
| Insurance Details | `template-insurance.php` | `/insurance/` |
| Coming Soon | `template-coming-soon.php` | `/coming-soon/` |
| Careers Directory | `template-careers.php` | `/careers/` |
| Sitemap | `template-sitemap.php` | `/sitemap/` |

### Additional Templates (assign manually)

| Template | Purpose |
|----------|---------|
| `template-booking.php` | Full appointment booking form page |
| `template-before-after.php` | Before & After cases showcase |
| `template-privacy.php` | Privacy Policy page |
| `template-terms.php` | Terms & Conditions page |

---

## Customisation

All theme settings are managed from the native **DentalPro Settings** panel (12 tabs + 3 submenus):

**Tabs:**
- **General** — Clinic name, phone, email, address, hero media
- **Colors** — Primary, secondary, accent with pre-made skin library
- **Header** — Style selection, sticky behaviour
- **Footer** — Layout options
- **Social Media** — Social profile URLs
- **Contact** — Map embed, WhatsApp, working hours, emergency toggle
- **Homepage Blog** — Blog section toggle and configuration
- **Homepage Stats** — Animated statistics counter
- **Homepage Why Choose Us** — Benefits section
- **Homepage Gallery** — Clinic photo gallery
- **Appointment Settings** — Approval mode, SMS gateway, data archival
- **AI Chatbot** — Enable/disable, API config, system prompt, bug report widget toggle

**Submenus:**
- **Hero Slider** — Manage homepage carousel slides
- **Email Templates** — Custom subject lines, HTML body, and SMS templates
- **Appointments Dashboard** — Full SPA booking manager with filters and exports

---

## Security

- All database queries use `$wpdb->prepare()` with typed placeholders
- All output escaped via `esc_html()`, `esc_attr()`, `esc_url()`, `esc_textarea()`
- Admin forms protected by `check_admin_referer()` nonces
- Capability checks via `current_user_can('manage_options')`
- AJAX endpoints protected with `check_ajax_referer()`
- Rate limiting on booking and bug report endpoints

---

## REST API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/wp-json/dentalpro/v1/available-slots` | GET | Get available time slots for a doctor on a specific date |
| `/wp-json/dentalpro/v1/book` | POST | Submit a new appointment booking |

Both endpoints have **rate limiting** built in (20 requests/min for slots, 10 requests/min for bookings).

---

## Third-Party Libraries

| Library | Version | License |
|---------|---------|---------|
| Swiper.js | 11.x | MIT |
| Font Awesome | 6.x (SVG icons inline) | MIT / CC BY 4.0 |
| Google Fonts — Outfit, Inter | via @import | Open Font License |
| Normalize.css | Latest | MIT |

---

## Changelog

### 1.0.6 — June 2026
- Added AI Chatbot with LLM-powered booking (OpenAI-compatible API)
- Added Before & After CPT with interactive comparison slider
- Added Locations CPT for multi-branch management
- Added FAQs CPT with category grouping and schema
- Added Bug Report / Problem Report widget
- Added SMS/WhatsApp notification system (Twilio + Custom Gateway)
- Added Appointment Tracking page template
- Added Google Reviews homepage section
- Added 4 pre-made color skins
- Added database archive & cleanup system
- Improved email templates with .ics calendar attachments
- Security hardening and rate limiting

### 1.0.0 — Initial Release
- Full theme launch with core features

---

## Support

For support, customisation requests, or bug reports, please use the **ThemeForest comments section** on the item page.

---

## License

This theme is licensed under the GNU General Public License v2 or later.  
Full license text: http://www.gnu.org/licenses/gpl-2.0.html
