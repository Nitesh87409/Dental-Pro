# DentalPro Elite — WordPress Theme

**Version:** 1.0.0  
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
- 4 pre-built Header styles (solid, transparent, sticky, centred)
- 3 Footer layout options
- Swiper.js Hero Slider with video background support
- Fully responsive — mobile, tablet, desktop
- Dark Mode toggle (admin panel + frontend)
- Translation ready (`.pot` file included)
- RTL stylesheet support

### Custom Post Types
- **Doctors** — profiles with specialisation, experience, ratings
- **Services** — dental treatments with pricing and duration
- **Testimonials** — patient reviews with star ratings
- **Appointments** — full booking records management

### Appointment Booking System
- Multi-step frontend booking wizard
- Auto-generated 30-minute time slots per doctor
- REST API slot availability checker
- Admin booking manager (Approve / Complete / Cancel)
- WP-Cron automated daily appointment reminder emails
- Custom branded HTML email templates

### Patient Portal
- Secure login / registration for `dental_patient` role
- Dashboard showing upcoming and past appointments
- Patient profile: allergies, medications, medical notes (stored to user meta)

### AI Chatbot
- Floating chat bubble with typing animations
- Rule-based keyword matching against admin-configured Q&A pairs
- REST API endpoint: `/wp-json/dentalpro/v1/chatbot/query`
- Fallback states with booking links and WhatsApp triggers

### Treatment Cost Calculator
- Shortcode `[dental_calculator]`
- Pulls base prices from Services CPT dynamically
- Range sliders for insurance savings calculation
- Pre-fills booking step 1 via sessionStorage

### SEO & Schema
- JSON-LD structured data: `Dentist`, `Physician`, `Service`, `FAQPage`, `BreadcrumbList`
- Auto-injected via `wp_head` with clinic address, phone, coordinates, hours

### WooCommerce Ready
- Shop, cart, checkout, and account templates included
- Single product pages styled to match theme design

### Child Theme Support
- `dentalpro-elite-child` starter kit bundled in `/child-theme/` folder

---

## Installation

1. Upload the `developer-starter-pro` folder to `/wp-content/themes/`
2. Go to **Appearance → Themes** and activate **DentalPro Elite**
3. Navigate to **DentalPro Settings** to configure logo, clinic info, colors, and booking options
4. Import demo data via **DentalPro Settings → Demo Import**

---

## Demo Data

A sample `demo-data.xml` is included in `/demo-data/`. Import via **Tools → Import → WordPress** to populate dummy doctors, services, testimonials, and appointments.

---

## Customisation

All theme settings are managed from the native **DentalPro Settings** panel:
- **General** — clinic name, phone, email, address, Google Maps embed
- **Colors** — primary, secondary, accent (CSS custom properties)
- **Header** — style, sticky behaviour, transparent mode
- **Footer** — layout, newsletter form toggle
- **Booking** — doctor availability, slot duration, reminder email toggle
- **Email Templates** — custom subject lines and HTML body templates
- **Hero Slider** — add/edit/delete slides with image or video backgrounds
- **Chatbot FAQs** — configure Q&A pairs

---

## Security

- All database queries use `$wpdb->prepare()` with typed placeholders
- All output escaped via `esc_html()`, `esc_attr()`, `esc_url()`, `esc_textarea()`
- Admin forms protected by `check_admin_referer()` nonces
- Capability checks via `current_user_can('manage_options')`

---

## Third-Party Libraries

| Library | Version | License |
|---|---|---|
| Swiper.js | 11.x | MIT |
| Font Awesome | 6.x (SVG icons inline) | MIT / CC BY 4.0 |
| Google Fonts — Outfit, Inter | via @import | Open Font License |

---

## Changelog

### 1.0.0 — Initial Release
- Full theme launch with all features listed above

---

## Support

For support, customisation requests, or bug reports, please use the **ThemeForest comments section** on the item page.

---

## License

This theme is licensed under the GNU General Public License v2 or later.  
Full license text: http://www.gnu.org/licenses/gpl-2.0.html
