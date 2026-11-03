# Agency Site — Technical Architecture & System Design

## 1. System Overview

The **Agency Site** project is a production-grade classic WordPress website for **Apex Digital Strategy**, a premium digital marketing agency. The architecture enforces separation of concerns between presentation (Theme) and business logic/data persistence (Plugin).

```
                      ┌──────────────────────────────────────┐
                      │           Browser / Client           │
                      └──────────────────┬───────────────────┘
                                         │
                    HTTP Requests / AJAX │ Submissions
                                         ▼
┌────────────────────────────────────────────────────────────────────────────┐
│                             WordPress Core                                 │
├─────────────────────────────────────┬──────────────────────────────────────┤
│  PRESENTATION LAYER                 │  DATA & BUSINESS LOGIC LAYER         │
│  (Theme: `agency-site`)             │  (Plugin: `agency-site-core`)        │
├─────────────────────────────────────┼──────────────────────────────────────┤
│  • Classic WP Template Hierarchy    │  • CPT: `agency_service` (slug /services/)│
│  • Tailwind CSS 3.4 Utility Design  │  • CPT: `agency_enquiry` (submissions)│
│  • Vanilla JS UI Controller         │  • Nonce & CSRF Verification         │
│  • Accessible Navigation & Drawer   │  • Honeypot & Transient Rate Limiter │
│  • SEO Meta Presentation Hooks      │  • Webhook Dispatcher & HMAC-SHA256  │
│  • Analytics Event Triggers         │  • Transactional HTML Mail Templates │
│  • Template Parts (Cards, CTA)      │  • Technical SEO Engine & Redirects  │
│  • Page Templates (Home, Services,  │  • GA4 / GTM Injection Engine        │
│    Single Service, Blog, Contact)   │  • Delivery Logs Custom DB Table     │
└─────────────────────────────────────┴──────────────────────────────────────┘
                                         │
                         ┌───────────────┴───────────────┐
                         ▼                               ▼
              ┌─────────────────────┐        ┌───────────────────────┐
              │  Local SMTP Server  │        │   Webhook Receiver    │
              │  (Mailpit API/Port) │        │   (CRM / Zapier / N8N)│
              └─────────────────────┘        └───────────────────────┘
```

---

## 2. Theme vs Plugin Boundary Rationale

In accordance with WordPress development standards and portfolio review requirements:

### Theme Responsibility: Presentation Only (`themes/agency-site`)
- Declares page layouts, visual styling, responsive design breakpoints, and typography.
- Handles user interactions (mobile hamburger toggle, sticky header glassmorphism, FAQ accordion toggles, clipboard toasts).
- Enqueues minified Tailwind CSS (`assets/dist/css/style.css`) and vanilla JavaScript (`assets/dist/js/main.js`).
- Contains no Custom Post Type registrations, database schema definitions, or external API delivery mechanisms.
- **Theme Switch Decoupling**: If an administrator switches the theme to WordPress default Twenty Twenty-Four, all services, meta fields, inquiry logs, webhook delivery histories, and SEO redirects remain intact and functional in the WordPress admin.

### Plugin Responsibility: Data, Security, & Integrations (`plugins/agency-site-core`)
- Registers Custom Post Types:
  - `agency_service`: Represents agency offerings with rewrite slug `/services/`.
  - `agency_enquiry`: Represents lead inquiries submitted through the contact form.
- Manages custom metadata (service tagline, short summary, deliverables, timeline, pricing starting price).
- Handles AJAX inquiry endpoints (`agency_submit_contact`), applying strict rate limiting (5 req / 10 min), honeypot anti-spam verification, and CRLF header injection guards.
- Dispatches transactional HTML emails (branded confirmation email to customer, notification email to admin).
- Dispatches signed HTTP POST webhooks with HMAC-SHA256 signatures, timeout protection, and local delivery logging.
- Manages technical SEO (canonical URLs, meta descriptions, Open Graph / Twitter cards, core XML sitemap hooks, JSON-LD structured data, and 301 redirects).
- Manages analytics injection (GA4 and GTM containers with custom dataLayer event bus).

---

## 3. Data Model & Entity Lifecycle

### 3.1 Custom Post Type: `agency_service`
- **Identifier**: `agency_service`
- **Rewrite Slug**: `/services/` (with single service URL: `/services/%postname%/`)
- **Supports**: `title`, `editor`, `thumbnail`, `excerpt`, `custom-fields`
- **Hierarchical**: No
- **Meta Fields**:
  - `_agency_service_icon`: SVG icon identifier or class name.
  - `_agency_service_tagline`: Subhead summary.
  - `_agency_service_short_summary`: 2-line excerpt for cards and metadata.
  - `_agency_service_deliverables`: Multi-line key deliverables (parsed as list).
  - `_agency_service_timeline`: Typical delivery timeline (e.g. `3–6 months`).
  - `_agency_service_price_range`: Budget starting tier (e.g. `Starting at $4,500/mo`).

### 3.2 Custom Post Type: `agency_enquiry`
- **Identifier**: `agency_enquiry`
- **Capability Type**: `post` (restricted to `manage_options` administrators)
- **Public**: False (hidden from front-end search and archive queries)
- **Meta Fields**:
  - `_agency_enquiry_name`: Full name.
  - `_agency_enquiry_email`: Validated email address.
  - `_agency_enquiry_phone`: Sanitized telephone string.
  - `_agency_enquiry_company`: Organization name.
  - `_agency_enquiry_service`: Selected service interest.
  - `_agency_enquiry_budget`: Budget bracket.
  - `_agency_enquiry_message`: Project details.
  - `_agency_enquiry_ip`: Client IP address.
  - `_agency_enquiry_user_agent`: Submitting browser user-agent.
  - `_agency_enquiry_webhook_status`: Status (`delivered`, `failed`, `disabled`, `error`).

### 3.3 Custom Database Table: `agency_webhook_delivery_logs`
Created upon plugin activation via `dbDelta()`:
```sql
CREATE TABLE {$wpdb->prefix}agency_webhook_delivery_logs (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    enquiry_id bigint(20) unsigned NOT NULL,
    webhook_url varchar(255) NOT NULL,
    payload_hash varchar(64) NOT NULL,
    http_status smallint(5) DEFAULT NULL,
    status varchar(20) NOT NULL,
    attempt_count tinyint(3) unsigned NOT NULL DEFAULT 1,
    request_headers longtext,
    request_body longtext,
    response_body longtext,
    error_message text,
    created_at datetime NOT NULL,
    PRIMARY KEY (id),
    KEY enquiry_id (enquiry_id),
    KEY status (status)
) {$charset_collate};
```

---

## 4. Enquiry Lifecycle & Webhook Pipeline

```
[User Submits Form]
         │
         ▼
[1. Payload Size Check] ──> Exceeds 10KB? ──> [Reject HTTP 413]
         │
         ▼
[2. Honeypot Check] ─────> Value Present? ──> [Silent Success / Drop]
         │
         ▼
[3. Transient Rate Limit] ─> >5 req / 10m? ──> [Reject HTTP 429]
         │
         ▼
[4. Nonce & Field Sanitize] ─> Invalid? ────> [Reject HTTP 400]
         │
         ▼
[5. Store in DB] ───────> `wp_insert_post` -> CPT `agency_enquiry` + metadata
         │
         ├────────────────────────────────────────┐
         ▼                                        ▼
[6. Send HTML Emails via wp_mail()]       [7. Webhook Dispatcher]
  ├─ Customer Confirmation                  ├─ Check if enabled
  └─ Internal Admin Alert                   ├─ SSRF check (reject metadata IPs)
                                            ├─ Sign payload (HMAC-SHA256)
                                            ├─ wp_safe_remote_post() (8s timeout)
                                            ├─ Parse response code & body
                                            └─ Record in `agency_webhook_delivery_logs`
         │
         ▼
[8. Return JSON Response to Client UI]
```

---

## 5. Extensibility Points & Hooks

The companion plugin provides WordPress filters for third-party expansion:

- `agency_core_enquiry_data`: Filter sanitized enquiry payload before DB insertion.
- `agency_core_webhook_payload`: Filter JSON payload before HMAC signing and HTTP transmission.
- `agency_core_webhook_headers`: Filter HTTP headers sent to CRM endpoint.
- `agency_core_confirmation_email_subject`: Customize customer email subject line.
- `agency_core_admin_email_subject`: Customize internal notification subject line.
- `agency_core_seo_redirects`: Filter URL rewrite/redirect mapping.

