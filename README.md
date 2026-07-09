# wordpress-agency-site

[![WordPress](https://img.shields.io/badge/WordPress-6.7%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.2-777bb4.svg)](https://php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38bdf8.svg)](https://tailwindcss.com/)
[![License: GPL-2.0-or-later](https://img.shields.io/badge/License-GPL--2.0--or--later-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

A custom classic WordPress solution engineered for a high-growth digital marketing agency, growth consultancy, or creative performance studio. Built with **PHP 8.2**, **Tailwind CSS v3**, and **vanilla JavaScript**, adhering strictly to modern WordPress architecture standards.

---

## 🏛️ Architecture & Separation of Concerns

To guarantee that content, URLs, and data remain intact regardless of theme changes, functionality is strictly separated:

```text
wp-content/
├── .github/workflows/ci.yml    # GitHub Actions CI workflow (linting, build, test)
├── docs/                       # Comprehensive reviewer documentation
│   ├── Agency_Site_Implementation_Brief.md # Complete project brief & checklist
│   ├── architecture.md         # System boundaries, data models & lifecycle
│   ├── security.md             # Threat modeling, nonces, rate limiting, SSRF
│   ├── verification-report.md  # 21-point test results, curl checks & Mailpit evidence
│   ├── analytics-guide.md      # GA4 / GTM event map & dataLayer schema
│   ├── client-handoff.md       # Content editor manual & administration guide
│   ├── ai-workflow.md          # Account of AI pair-programming & debugging
│   └── design-evidence.md      # Breakpoint matrix, typography, accessibility & Figma audit
├── composer.json               # PHPCS and WordPress Coding Standards config
├── package.json                # Root orchestration scripts
├── phpcs.xml                   # Ruleset for WordPress-Core & WordPress-Extra
├── tests/
│   └── run-all-tests.php       # Automated 21-point security & integration test suite
├── themes/
│   └── agency-site/            # Presentation Layer (Theme)
│       ├── front-page.php      # Homepage template
│       ├── template-services.php # Service landing page template
│       ├── single-agency_service.php # Single service template
│       ├── home.php / index.php # Blog listing template
│       ├── single.php          # Single article template
│       ├── page-contact.php    # Contact page template
│       ├── header.php / footer.php # Navigation, drawer & footer
│       ├── template-parts/     # Reusable service-card, post-card & cta-banner
│       ├── assets/             # Tailwind CSS & vanilla JS assets
│       └── screenshot.png      # Theme preview thumbnail (1200x900)
└── plugins/
    └── agency-site-core/       # Business & Data Layer (Companion Plugin)
        ├── includes/
        │   ├── class-cpt-service.php        # Services CPT & custom meta
        │   ├── class-enquiry-handler.php    # Enquiries CPT, honeypot & rate limit
        │   ├── class-webhook-dispatcher.php # HMAC webhook & delivery logger
        │   ├── class-seo-manager.php        # Canonical, JSON-LD & 301 redirects
        │   ├── class-analytics-manager.php  # GA4/GTM script & event tracking
        │   └── class-admin-settings.php     # Webhook logs & settings UI
        └── templates/
            ├── email-confirmation.php       # Branded HTML customer confirmation
            └── email-internal-notification.php # Branded HTML admin lead alert
```

---

## 🚀 Key Features

### 1. Presentation & Responsive Layouts (`themes/agency-site`)
- **Homepage (`front-page.php`)**: Hero with conversion badges & dual CTAs, live acquisition dashboard graphic, client trust logos, Customizer-editable stats counter, core services grid, agency comparison matrix, CMO testimonials with 5-star ratings, and recent blog posts grid.
- **Service Landing Page (`template-services.php`)**: In-depth capability breakdown with deliverables checklists, pricing indicators, 4-stage growth framework, and an accessible FAQ accordion.
- **Blog & Single Articles (`home.php` & `single.php`)**: Category filter pills, featured article hero, 2-column post card grid, reading time calculation, pagination, sidebar widgets, tags, social share buttons with a **copy-link toast notification**, and author bio box.
- **Accessible Navigation (`header.php`)**: Sticky glassmorphic header on scroll, accessible mobile drawer with ARIA controls, Escape-key dismiss, and click-outside close.

### 2. Companion Plugin Business Logic (`plugins/agency-site-core`)
- **Services CPT (`agency_service`)**: Custom post type with rewrite slug `services`, REST API support, and custom meta boxes (Tagline, Pricing Indicator, Highlight Badge, Icon style, and Key Deliverables).
- **Inbound Enquiries (`agency_enquiry`)**: Custom post type storing all consultation leads directly in the WordPress dashboard with lead columns (Name, Email, Phone, Service, Budget, Webhook Delivery status, Date).
- **Configurable Webhook Integration**:
  - Dispatches JSON payloads to any configured webhook URL on every enquiry.
  - HMAC-SHA256 signature verification via `X-Agency-Signature: sha256=<hash>`.
  - Configurable request timeout and failure handling.
  - Delivery logging table under **Enquiries > Delivery Logs** with status, HTTP code, latency (ms), and error messages.
  - Built-in "Send Test Webhook" tool for 1-click verification.
- **Branded HTML Confirmation Email**:
  - Responsive email template with agency styling.
  - Summarizes the enquiry details and outlines the 24-hour onboarding timeline.
  - Verified in Local by Flywheel's Mailpit mailbox.
- **Technical SEO**:
  - Dynamic meta descriptions and canonical URLs.
  - Open Graph and Twitter Card tags.
  - JSON-LD Structured Data: `Organization` / `ProfessionalService`, `Service`, `Article` / `BlogPosting`, and `FAQPage`.
  - Core XML Sitemap integration: `agency_service` posts included in `/wp-sitemap.xml`.
  - Working 301 Redirects: e.g. `/audit` and `/free-audit` redirecting cleanly to `/contact/`, and `/case-studies` redirecting to `/services/`.
- **Configurable GA4 / GTM Analytics**:
  - Admin inputs for GA4 Measurement ID (`G-XXXXXXXXXX`) and GTM Container ID (`GTM-XXXXXXX`).
  - Automated event tracking in vanilla JS:
    - `agency_cta_click`: Tracks clicks on primary buttons with CTA text, target URL, and page section.
    - `agency_enquiry_submitted`: Fires on successful AJAX submission with service and budget tier (privacy-safe, no PII).
    - `agency_faq_opened`: Tracks interactions with service FAQs.
  - Developer console logging mode for testing without real analytics IDs.

---

## 📚 Reviewer Documentation Package

For in-depth review, technical audits, and client handoff details, refer to the following documents in `docs/`:

1. [**Architecture & System Design**](file://docs/architecture.md): Theme vs plugin boundaries, entity lifecycles, and hook extensibility points.
2. [**Security Architecture & Hardening**](file://docs/security.md): Threat modeling, nonces, honeypot, rate limiting, CRLF injection defense, and SSRF prevention.
3. [**Verification & QA Report**](file://docs/verification-report.md): Execution outputs, HTTP 200/301 statuses, Mailpit evidence, and webhook logs.
4. [**Analytics & Tag Management Guide**](file://docs/analytics-guide.md): DataLayer schema, GA4/GTM setup steps, and consent considerations.
5. [**Client Handoff & Editor Guide**](file://docs/client-handoff.md): Managing services, enquiries, webhooks, and troubleshooting.
6. [**AI-Assisted Workflow Retrospective**](file://docs/ai-workflow.md): Pair-programming methodology, errors encountered, and productivity impact.
7. [**Design System & Layout Evidence**](file://docs/design-evidence.md): Responsive breakpoint matrix, typography scale, WCAG 2.1 AA accessibility, and Figma audit note.

---

## 🛠️ Build Configuration & Asset Compilation

### Prerequisites
- **Node.js**: v18+ (tested on Node v20.20.2)
- **npm**: v9+ (tested on npm 10.8.2)
- **PHP**: 7.4+ (tested on PHP 8.2.29)

### Install Dependencies
```bash
cd wp-content/themes/agency-site
npm install
```

### Compile Tailwind CSS
```bash
# Minified production build
npm run build:css

# Development watch mode
npm run watch:css
```

---

## ⚙️ Setup & Activation Instructions

### 1. Activate Theme & Plugin
Via the WordPress Admin dashboard:
1. Navigate to **Plugins > Installed Plugins**, locate **Agency Site Core**, and click **Activate**.
2. Navigate to **Appearance > Themes**, locate **Agency Site**, and click **Activate**.

Or via WP-CLI:
```bash
wp plugin activate agency-site-core
wp theme activate agency-site
```

### 2. Configure Pages & Reading Settings
1. Go to **Pages > Add New**:
   - Create **Home** (uses `front-page.php` automatically).
   - Create **Services** and select template **Service Landing Page**.
   - Create **Blog & Insights**.
   - Create **Contact** and select template **Contact Page**.
2. Go to **Settings > Reading**:
   - Set **Your homepage displays** to **A static page**.
   - Homepage: **Home** | Posts page: **Blog & Insights**.
   - Click **Save Changes**.

### 3. Configure Webhooks & Analytics
1. Go to **Enquiries > Settings & Webhooks**:
   - Enter your **Webhook Destination URL** and optional **Secret Signature Key**.
   - Enter your **GA4 Measurement ID** (`G-XXXXXXXXXX`) or **GTM Container ID** (`GTM-XXXXXXX`).
   - Click **Save Configuration**.
2. Click **Send Test Webhook Now** to verify connectivity with your endpoint.

---

## 🔍 Verification & Testing Report

| Requirement / Feature | Status | Verification Method |
| :--- | :---: | :--- |
| **PHP 8.2 Linting** | **Verified** | Tested all 19 theme & plugin PHP files with `php -l`. 0 errors. |
| **Tailwind CSS Compilation** | **Verified** | Compiled minified CSS (61KB) into `assets/dist/css/style.css`. |
| **Theme & Plugin Activation** | **Verified** | Activated via WP-CLI on `wordpress-agency-site.local`. |
| **Live HTTP 200 Endpoints** | **Verified** | Verified `/`, `/services/`, `/blog/`, `/contact/`, `/services/search-engine-optimization/`. |
| **AJAX Enquiry Submission** | **Verified** | Form submission tested via curl against `admin-ajax.php`. Returns JSON success. |
| **HMAC Webhook Dispatch** | **Verified** | Dispatched test payload to local receiver; verified `X-Agency-Signature` and `signature_valid: true`. |
| **Webhook Failure Handling** | **Verified** | Tested unreachable port; verified error catch (`cURL error 7`) and delivery log entry. |
| **HTML Confirmation Email** | **Verified** | Inspected live email delivery in Local Mailpit API (`http://127.0.0.1:10000/api/v1/messages`). |
| **301 Example Redirects** | **Verified** | Tested `curl -sI /free-audit` returning `HTTP 301 Location: /contact/`. |
| **XML Sitemap** | **Verified** | Checked `/wp-sitemap.xml` and verified `agency_service` inclusion. |
| **JSON-LD Structured Data** | **Verified** | Checked `<script type="application/ld+json">` for `ProfessionalService`, `Service`, `Article`, `FAQPage`. |
| **GA4 / GTM DataLayer** | **Verified** | Verified GTM `<head>` / `<body>` injection and dataLayer tracking script in HTML footer. |

### ⚠️ External Verification Notice
- **GA4 / GTM Production Data Collection**: Injected snippets and dataLayer events are fully functional. Streaming real event data to Google servers requires entering a live GA4 Measurement ID (`G-XXXXXXXXXX`) or GTM Container ID created in your Google Analytics account.
- **Production Webhook Endpoints**: The webhook dispatcher was verified with a local endpoint. To route leads to external tools (HubSpot, Salesforce, Zapier, Make, Slack), enter the production webhook endpoint in **Enquiries > Settings & Webhooks**.

---

## 📢 Demonstration Content Notice

> **IMPORTANT**: All agency metrics (such as *"$45M+ Client Revenue Driven"*, *"340% Average ROI Increase"*, *"98% Client Retention"*, *"150+ Successful Campaigns"*) and client testimonials (*Elena Rostova*, *Marcus Vance*, *Sarah Jenkins*) are **fictional demonstration content** designed exclusively for portfolio illustration. All numbers, copy, and reviews can be customized in **Appearance > Customize > Agency Site Settings**.

---

## 🤖 Account of AI-Assisted Workflow

This project was built following an agentic pair-programming methodology:
1. **Environment & Sandbox Discovery**: Inspected the Local by Flywheel environment, identified Node 20 / npm 10, located the Local PHP 8.2 binary, and inspected Mailpit ports.
2. **Architecture Decoupling**: Migrated data handling, custom post types, and webhook integration out of the theme and into a dedicated companion plugin (`agency-site-core`) to adhere to WordPress coding standards and prevent data lock-in.
3. **Automated Verification**: Rather than assuming code works, each milestone was verified using shell commands (PHP linting, Tailwind compilation, WP-CLI database transactions, curl HTTP status checks, Mailpit API inspection, and mock webhook listeners).
4. **Resilience & Fallbacks**: Integrated defensive fallbacks so the site renders cleanly whether or not custom post types have been seeded, and included a debug mode for analytics tracking when real Google account keys are not yet configured.

