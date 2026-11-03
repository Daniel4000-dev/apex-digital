# Apex Digital — Enterprise WordPress Platform

[![WordPress](https://img.shields.io/badge/WordPress-6.7%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.2-777bb4.svg)](https://php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38bdf8.svg)](https://tailwindcss.com/)
[![License: GPL-2.0-or-later](https://img.shields.io/badge/License-GPL--2.0--or--later-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![GitHub Repository](https://img.shields.io/badge/GitHub-apex--digital-181717.svg?logo=github)](https://github.com/Daniel4000-dev/apex-digital.git)
[![CI Pipeline](https://img.shields.io/badge/CI-GitHub_Actions-success.svg)](https://github.com/Daniel4000-dev/apex-digital/actions)

The official client acquisition and growth performance platform for **Apex Digital**, a digital performance marketing and web design agency. Engineered for high-conversion inbound sales pipelines, robust data resilience, strict security boundaries, technical search engine optimization, and enterprise tag management.

---

## 🏛️ Platform Architecture & Separation of Concerns

The platform strictly enforces the WordPress architectural boundary separating presentation from business data:
- **Presentation Layer (`themes/agency-site`)**: Custom classic PHP theme styled with Tailwind CSS v3 and vanilla JavaScript. Handles templating, mobile navigation, layout grids, and client-side interactions.
- **Business & Data Engine (`plugins/agency-site-core`)**: Custom companion plugin handling Custom Post Types (`agency_service`, `agency_enquiry`), CRM webhook dispatching with HMAC-SHA256 signatures, transactional email notifications, rate limiting, and technical SEO schema.
- **Data Persistence Guarantee**: Content, services, and enquiry pipelines remain 100% operational across theme activations and updates.

```text
wp-content/
├── .github/workflows/ci.yml       # Production GitHub Actions CI/CD pipeline
├── docs/                          # Platform architecture, security, and integration runbooks
│   ├── architecture.md            # System boundaries, data schemas, and lifecycle flows
│   ├── security.md                # Threat models, nonces, SSRF prevention, and rate limits
│   ├── verification-report.md     # 52-point quality assurance release audit
│   ├── acf-gravityforms-integration.md # ACF Pro & Gravity Forms integration guide
│   ├── legacy-maintenance-retrospective.md # Legacy maintenance & modernization note
│   ├── analytics-guide.md         # GA4 / GTM event map and dataLayer schema
│   ├── client-handoff.md          # Content editor guide & dashboard runbook
│   └── design-evidence.md         # Breakpoint matrix, WCAG AA compliance, and typography
├── composer.json                  # PHPCS, WPCS, Timber/Twig v2, and unit testing dependencies
├── package.json                   # Root workspace orchestration scripts
├── phpcs.xml                      # Strict WordPress Coding Standards configuration
├── scripts/
│   └── run-with-env.sh            # Portable cross-environment execution harness
├── legacy-maintenance-example/    # Scoped legacy campaign fixture (Foundation + Sass + Twig)
├── tests/
│   ├── run-all-tests.php          # 52-assertion behavioural, security & ingress suite
│   ├── send-test-emails.php       # Transactional & promotional email test runner
│   ├── verify-apex-digital.js     # Playwright responsive & end-to-end browser automation
│   ├── verify-campaign-page.js    # Playwright browser runner for campaign page & grid checks
│   └── phpunit/                   # PHPUnit unit & integration tests
├── themes/
│   └── agency-site/               # Presentation Layer (Custom Classic Theme)
│       ├── front-page.php         # Homepage with value propositions & conversion paths
│       ├── template-services.php  # Service capabilities and deliverables matrix
│       ├── template-campaign.php  # Reusable Campaign Landing Page (ACF Pro + Timber/Twig + Foundation)
│       ├── page-contact.php       # Strategy consultation ingress with fallback routing
│       ├── single-agency_service.php # Single service template
│       ├── home.php / single.php  # Insights & thought leadership publication templates
│       ├── acf-json/              # Synchronized ACF Pro field group definitions (Local JSON)
│       ├── views/                 # Modular Timber/Twig v2 template inheritance hierarchy
│       │   ├── layouts/           # campaign-base.twig (WordPress lifecycle hooks)
│       │   ├── campaign.twig      # Master campaign template extension
│       │   └── partials/          # hero, intro, benefits, faqs, enquiry Twig components
│       ├── gulpfile.js            # Gulp 5 Sass build pipeline (Autoprefixer, minification, sourcemaps)
│       └── assets/                # Asset pipelines
│           ├── src/scss/          # Dart Sass architecture (_settings, _mixins, _layout, components/)
│           ├── dist/css/          # Built CSS (Tailwind style.css & scoped Foundation campaign.css)
│           └── src/js/ / dist/js/ # Vanilla JavaScript (drawer, accordion, AJAX enquiry, poster switcher)
└── plugins/
    └── agency-site-core/          # Business & Data Layer (Companion Plugin)
        ├── includes/
        │   ├── class-cpt-service.php        # Services CPT with custom meta fields
        │   ├── class-enquiry-handler.php    # Inbound consultation CPT, honeypot & rate limit
        │   ├── class-webhook-dispatcher.php # HMAC-SHA256 webhook dispatcher & delivery logger
        │   ├── class-acf-integration.php    # ACF Pro programmatic field bridge
        │   ├── class-gravity-forms-integration.php # Gravity Forms post-submission bridge
        │   ├── class-seo-manager.php        # Canonical URLs, JSON-LD schema & 301 redirects
        │   ├── class-analytics-manager.php  # GA4 / GTM script injector & event bus
        │   └── class-admin-settings.php     # Webhook logs & integration settings UI
        └── templates/
            ├── email-confirmation.php       # Branded customer consultation receipt
            ├── email-internal-notification.php # Branded internal sales lead alert
            └── email-promotional-audit.php  # Complimentary growth audit campaign email
```

---

## 🚀 Core Platform Capabilities

### 1. Inbound Growth Marketing Engine
- **Strategic Homepage (`front-page.php`)**:
  - Clear value proposition: *"Turn more visits into enquiries."*
  - Dual conversion pathways: Primary *"Discuss your project"* (`/contact/`) and secondary *"Explore our services"* (`/services/`).
  - Transparent 3-stage delivery roadmap (*Audit & Discovery*, *Focused Execution Sprints*, *Review & Ongoing Support*).
  - Sample campaign performance report featuring grounded, illustrative performance data without exaggerated claims.
  - Uniform service cards featuring distinct strategic taglines and checkmarked deliverables.
- **Service Capability Framework (`template-services.php`)**:
  - Detailed breakdown of core agency offerings (Search Engine Optimization, Performance Web Design, Paid Advertising, Conversion Rate Optimization, Growth Strategy).
  - Reusable deliverables matrix and accessible FAQ accordion.
- **Thought Leadership & Insights (`home.php` & `single.php`)**:
  - Educational articles across high-intent categories (SEO, Paid Advertising, Conversion Optimization).
  - Reading time calculation, author attribution, related posts, and native copy-link toast notifications.

### 2. Secure Inbound Lead Processing & CRM Webhooks
- **Private Lead Repository**: All consultation requests are stored in the private `agency_enquiry` post type (`'public' => false`), restricted to administrators with `manage_options` capabilities.
- **Defensive Ingress Perimeter**:
  - Bounded 10KB request size ceiling (rejects oversized payloads with HTTP 413).
  - Scalar type enforcement and length limits (Name/Company ≤ 100 chars, Message: 10–3000 chars).
  - Anti-spam honeypot field (`agency_hp_website`) silently discarding automated bot submissions.
  - Transient-based IP rate limiter (capped at 5 submissions per 10 minutes per IP).
  - CRLF injection mitigation on all email headers and form variables.
- **Transactional Persistence Guard**: If database persistence fails (`wp_insert_post()`), execution halts immediately with HTTP 500, preventing premature webhook dispatches or unrecorded notification emails.
- **HMAC-SHA256 Webhook Pipeline**:
  - Dispatches JSON payloads to any configured CRM or automation receiver (HubSpot, Salesforce, Zapier, Make).
  - Verifiable signature header: `X-Agency-Signature: sha256=<hash>`.
  - Ingress/egress logging under **Enquiries > Delivery Logs** with duration, HTTP status, and response bodies.
  - Log privacy: Basic auth credentials and query tokens (`?token=...`, `?key=...`) are redacted before logging; customer personal data (PII) is excluded from log payloads.
  - SSRF & loopback protection: Rejects cloud metadata services (`169.254.169.254`) and enforces production loopback blocking.
- **Resilient Fallback Routing**: If the companion plugin is ever deactivated, `/contact/` alerts administrators and gracefully routes public inquiries through the theme's built-in `wp_mail()` handler.

### 3. Campaign Landing Page & Multi-Tech System (Sass, Gulp, Twig, Foundation, ACF Pro, Gravity Forms)
- **Editor-Managed Campaign Template (`template-campaign.php`)**:
  - Reusable template supporting promotional offers (e.g. *Q1 Performance Growth Sprint*).
  - Uses **ACF Pro** Local JSON (`themes/agency-site/acf-json/group_campaign_page_meta.json`) featuring genuine Pro-only **Repeaters** for deliverables and FAQs, with non-destructive fallback to native metadata.
  - Features **Gravity Forms** campaign enquiry integration (`docs/gravityforms-campaign-export-sanitized.json`) with conditional website URL visibility, spam protection, and deduplicated post-submission lead routing.
- **Twig (Timber v2) Template Hierarchy**:
  - Layout inheritance via `views/layouts/campaign-base.twig` preserving WordPress lifecycle hooks (`get_header()`, `get_footer()`, `wp_head()`, `wp_footer()`).
  - Modular partials (`views/partials/`): `campaign-hero.twig`, `campaign-intro.twig`, `campaign-benefits.twig`, `campaign-faq.twig`, `campaign-enquiry.twig`.
  - Contextual auto-escaping (`|e('html')`, `|e('html_attr')`) and a native PHP fallback view if Timber is uninstalled.
- **Sass Architecture & Gulp Pipeline**:
  - Modular Dart Sass partials under `assets/src/scss/` (`_settings.scss`, `_mixins.scss`, `_layout.scss`, and `components/_*.scss`).
  - Scoped **Foundation 6 XY Grid** (`.campaign-foundation-scope`) with zero style bleed into Tailwind CSS.
  - Gulp 5 build pipeline (`gulpfile.js`) compiling minified `campaign.css` with Autoprefixer, PostCSS, and sourcemaps in ~3.2 seconds.

### 4. Enterprise Integration Bridges (ACF Pro & Gravity Forms)
- **Advanced Custom Fields Pro**:
  - Pre-configured programmatic field definitions in `Agency_Core_ACF_Integration`.
  - Auto-synchronizing field group JSON in `themes/agency-site/acf-json/group_agency_service_meta.json`.
  - Dual-mode data fetching: Templates check ACF `get_field()` first, with zero-downtime fallback to native WordPress post meta.
- **Gravity Forms**:
  - Native integration listener `Agency_Core_Gravity_Forms_Integration` hooked to `gform_after_submission`.
  - Transient idempotency caching (`agency_gf_processed_{entry_id}`) preventing duplicate CPT insertions or double webhook dispatches.
  - Sanitized form export template provided in `docs/gravityforms-export-sanitized.json`.

### 4. Technical SEO & Analytics
- **Dynamic Meta & Canonical URLs**: Automated canonical tag calculation and Open Graph/Twitter Card tags.
- **JSON-LD Structured Data**: Emits valid schema markup for `ProfessionalService`, `Service`, `Article`, and `FAQPage`.
- **Core XML Sitemaps**: Seamless integration including custom service entities in `/wp-sitemap.xml`.
- **Safe 301 Redirects**: Built-in redirect map routing legacy aliases (e.g. `/audit` -> `/contact/`) with open-redirect protection.
- **GA4 / GTM Event Bus**:
  - Configurable IDs via **Enquiries > Settings & Webhooks**.
  - Custom events pushed to `window.dataLayer`: `agency_cta_click`, `agency_enquiry_submitted`, `agency_faq_opened`.
  - Privacy compliance: Customer personal data (names, emails, phone numbers, messages) is strictly excluded from analytics payloads.

### 5. Multi-Part Marketing & Transactional HTML Emails
- **Transactional Confirmation**: Responsive table-based customer receipt (`email-confirmation.php`) with inline CSS, MSO conditionals, and multi-part plain-text alternative.
- **Promotional Marketing Campaign**: High-impact Q4 Growth Audit advisory email (`email-promotional-audit.php` / `.txt`) with bulletproof CTA button and compliance footer.
- **Local Mail Capture**: Verified via `tests/send-test-emails.php` using Local by Flywheel's Mailpit mailbox (`127.0.0.1:10000`).

### 6. Contained Legacy Marketing Campaign Fixture
- **Location**: `legacy-maintenance-example/`
- **Stack**: ZURB Foundation + Dart Sass (`@use 'sass:math'`) + Twig + Gulp/Node.
- **Purpose**: A self-contained, backward-compatible landing page component fixture maintaining legacy marketing assets without CSS namespace leakage into the primary Tailwind CSS site.
- **Build**: Compiles in ~250ms via `npm run build:legacy` into `dist/css/main.css` and `dist/audit-component.html`.

---

## 🛠️ Build Configuration & Local Development

### Prerequisites
- **PHP**: 8.1+ (tested on PHP 8.2.29)
- **Node.js**: v18+ (tested on Node v20.20.2 / v22 LTS)
- **npm**: v9+ (tested on npm 10.8.2)
- **WordPress**: 6.4+ (tested on WordPress 6.7.x)

### 1. Install Dependencies
```bash
# Install frontend theme dependencies
cd wp-content/themes/agency-site
npm install

# Install root dependencies and test harnesses
cd ../..
npm install
composer install
```

### 2. Asset Compilation
```bash
# Production Tailwind CSS build
npm run build

# Watch mode for local theme development
npm run watch

# Compile legacy maintenance campaign fixture
npm run build:legacy
```

### 3. Run Quality Assurance Test Suites
All commands route portably through `scripts/run-with-env.sh`, automatically discovering local or CI environments without hardcoded paths:

```bash
# 1. PHP syntax verification across all files
npm run lint:php

# 2. Strict WordPress Coding Standards check (0 errors, 0 warnings)
npm run lint:phpcs:strict

# 3. JavaScript source linting
npm run lint:js

# 4. PHPUnit unit & integration tests
npm run test:phpunit

# 5. Behavioural, security & ingress suite (52 assertions)
npm run test:behavioural

# 6. HTML email dispatch to local Mailpit
npm run test:emails

# 7. Playwright cross-viewport browser verification
npm run test:browser
```

---

## ⚙️ Platform Setup & Activation

### 1. Activate Core Components
Via WP-CLI:
```bash
wp plugin activate agency-site-core
wp theme activate agency-site
wp rewrite structure '/%postname%/'
```

### 2. Configure Site Navigation & Reading Settings
1. In **Pages > Add New**:
   - Create **Home** (automatically loads `front-page.php`).
   - Create **Services** (select template **Service Landing Page**).
   - Create **Blog & Insights**.
   - Create **Contact** (select template **Contact Page**).
2. In **Settings > Reading**:
   - Set **Your homepage displays** to **A static page**.
   - Set **Homepage** to **Home** and **Posts page** to **Blog & Insights**.

### 3. Configure CRM Webhook & Analytics
1. Navigate to **Enquiries > Settings & Webhooks** in the WordPress admin:
   - Enter your **Webhook Destination URL** and optional **Secret Signature Key**.
   - Enter your **GA4 Measurement ID** (`G-XXXXXXXXXX`) or **GTM Container ID** (`GTM-XXXXXXX`).
   - Save configuration.
2. Click **Send Test Webhook Now** to verify connectivity with your endpoint.

---

## 📊 Platform Release Verification Matrix

| Capability / Subsystem | Implementation Deliverable | Test & Verification Target | Release Status |
| :--- | :--- | :--- | :---: |
| **Theme Presentation** | Responsive classic PHP theme (`themes/agency-site`) with Tailwind CSS v3. | 0px overflow across 320px–1440px viewports; mobile drawer ARIA toggle verified. | **Verified** |
| **Data Decoupling** | Custom post types in companion plugin (`plugins/agency-site-core`). | Theme switched to `twentytwentyfour`; all services and metadata remained 100% accessible. | **Verified** |
| **Security Gates** | 10KB ceiling, nonces, honeypot, rate-limit, CRLF defense, length bounds. | 52 automated tests in `tests/run-all-tests.php`; rejected requests produce zero side effects. | **Verified** |
| **Persistence Guard** | Transactional check: database failure halts downstream actions. | Forced database failure halts webhook and email dispatch with clean HTTP 500. | **Verified** |
| **Webhook Redaction** | Basic auth passwords and query tokens redacted from URLs and logs. | Verified via `Agency_Core_Webhook_Dispatcher::redact_sensitive_url`; zero PII in logs. | **Verified** |
| **ACF Pro Bridge** | Synchronized field group JSON and programmatic bridge with native fallback. | Verified via `Agency_Core_ACF_Integration`; documented in `docs/acf-gravityforms-integration.md`. | **Active / Pre-configured** |
| **Gravity Forms Bridge** | Ingestion hook `gform_after_submission` with idempotency deduplication. | Verified via `Agency_Core_Gravity_Forms_Integration`; form export in `docs/gravityforms-export-sanitized.json`. | **Active / Pre-configured** |
| **HTML Email Delivery** | Multi-part transactional confirmation & promotional Q4 audit emails. | Captured live in Local Mailpit API (`127.0.0.1:10000`); plain-text AltBody verified. | **Verified** |
| **Legacy Fixture** | Contained Foundation + Sass (`sass:math`) + Twig component fixture. | Compiles via `npm run build:legacy` in 250ms; zero CSS leakage into Tailwind. | **Verified** |
| **Code Standards** | Strict WordPress-Core and WordPress-Extra ruleset compliance. | `vendor/bin/phpcs --standard=phpcs.xml`: 34/34 files (100%), 0 errors, 0 warnings. | **Verified** |
| **CI / CD Automation** | GitHub Actions workflow (`.github/workflows/ci.yml`) on Node 22 / PHP 8.2. | Automated lint, build, PHPUnit, and 52-assertion behavioural suite in ephemeral container. | **Verified** |

---

## 📢 Product Disclosure & Sample Data Notice

> **Apex Digital** is a digital marketing agency platform engineered to demonstrate enterprise-grade custom WordPress development. All client case study metrics, ratings, and performance dashboards reflect illustrative sample data designed to showcase real-world platform presentation and data flows. All branding, service offerings, and webhook endpoints can be customized directly via WordPress options and customizer controls.
