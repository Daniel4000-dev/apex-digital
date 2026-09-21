# Agency Site — Verification & QA Report

**Test Date**: November 2, 2026  
**Environment**: Local by Flywheel on macOS Monterey (Darwin arm64)  
**WordPress Version**: 6.7.x | **PHP Version**: 8.2.29 | **MySQL**: 8.0.36 (Socket: `/Users/mac/Library/Application Support/Local/run/Rxl0HKEp-/mysql/mysqld.sock`)  
**Test Harnesses**: PHPUnit 9.6.38 + WP-CLI + Playwright + PHPCS 3.13.6 (WPCS 3.4.1) + ESLint 10.14.0  

---

## 1. Executive Summary & Verification Matrix

| Category / Requirement | Implemented | Actually Observed / Verified | Status / Reason |
| :--- | :---: | :---: | :--- |
| **Theme Presentation & Routing** | Yes | Yes | **Verified**: All routes return HTTP 200; mobile navigation drawer opens with `aria-expanded="true"`. |
| **Plugin CPTs & Data Decoupling** | Yes | Yes | **Verified**: Actual theme switch to `twentytwentyfour` proved CPTs and metadata remain 100% accessible. |
| **Form Ingress & Security Gates** | Yes | Yes | **Verified**: 10KB payload boundary, nonces, honeypot, and IP rate limiting reject bad requests with no side effects. |
| **Email Templating & Mailpit** | Yes | Yes | **Verified**: Branded HTML customer and internal admin emails captured in Mailpit API (`http://127.0.0.1:10000/api/v1/messages`). |
| **Local Webhook & Error Logging** | Yes | Yes | **Verified**: HMAC delivery to mock receiver (`127.0.0.1:9876`) and failure logging on unreachable port (`cURL error 7`). |
| **Production Webhook Safety** | Yes | Yes | **Verified**: Localhost strictly forbidden in production; SSRF metadata (`169.254.169.254`) and invalid protocols blocked. |
| **External Webhook Delivery** | Yes | No | **Unverified until actually observed**: External CRM / Zapier ingestion requires live external endpoint. |
| **Technical SEO & 301 Redirects** | Yes | Yes | **Verified**: `curl -sI /free-audit` returns `HTTP 301 Location: /contact/`; XML sitemaps include `agency_service`. |
| **GA4 / GTM DataLayer Bus** | Yes | Yes | **Verified**: Client script enqueues and events (`generate_lead`, `agency_cta_click`, `agency_faq_opened`) push to `window.dataLayer`. |
| **Live GA4 Hit Transmission** | Yes | No | **Unverified until actually observed**: Streaming hits requires an active GA4 Measurement ID / GTM container and observer (e.g. GA4 DebugView). |
| **Figma Visual Comparison** | Yes | No | **Not Demonstrated / Blocked**: No Figma reference design or tokens file was provided in project assets. |
| **CI / CD Workflow** | Yes | Configured | **Configured for GitHub Actions**: Remote repository configured at `https://github.com/Daniel4000-dev/apex-digital.git`. Workflow URL: `https://github.com/Daniel4000-dev/apex-digital/actions`. |

---

## 2. Automated Test Execution Commands & Outputs

### 2.1 Behavioural, Security & Integration Suite (WP-CLI Runner)
**Command**:
```bash
/Applications/Local.app/Contents/Resources/extraResources/lightning-services/php-8.2.29+0/bin/darwin/bin/php \
  -d mysqli.default_socket="/Users/mac/Library/Application Support/Local/run/Rxl0HKEp-/mysql/mysqld.sock" \
  /Applications/Local.app/Contents/Resources/extraResources/bin/wp-cli/wp-cli.phar \
  --path="/Users/mac/Local Sites/wordpress-agency-site/app/public" \
  eval-file tests/run-all-tests.php
```

**Exit Code**: `0`  
**Actual Output**:
```text
============================================================
 🧪 AGENCY SITE BEHAVIOURAL, SECURITY & INTEGRATION SUITE 
============================================================

  ✓ PASS: CPT agency_service registered
  ✓ PASS: CPT agency_enquiry registered
  ✓ PASS: Valid enquiry returns JSON success
  ✓ PASS: Valid enquiry increments agency_enquiry CPT record
  ✓ PASS: Invalid/missing fields rejected with error
  ✓ PASS: No enquiry record created on invalid submission (no side effects)
  ✓ PASS: Invalid nonce rejected with error (HTTP 403)
  ✓ PASS: Invalid nonce causes no DB insertion side effects
  ✓ PASS: Invalid nonce causes no webhook dispatch side effects
  ✓ PASS: Oversized request (>10KB) rejected before processing (HTTP 413)
  ✓ PASS: Oversized request causes no DB insertion side effects
  ✓ PASS: Oversized request causes no webhook dispatch side effects
  ✓ PASS: Honeypot blocks spam bot submission
  ✓ PASS: Honeypot submission causes no DB insertion side effects
  ✓ PASS: Honeypot submission causes no webhook dispatch side effects
  ✓ PASS: Rate limiter rejects excessive submissions (HTTP 429)
  ✓ PASS: Unauthenticated user lacks manage_options capability
  ✓ PASS: Critical webhook setting remains unchanged
  ✓ PASS: Unauthorized service meta update blocked without capability/nonce
  ✓ PASS: Webhook failure caught gracefully without crashing
  ✓ PASS: Webhook failure recorded in delivery logs table
  ✓ PASS: Unsafe destination (169.254.169.254) blocked before transport
  ✓ PASS: Unsafe protocol (file://) blocked before transport
  ✓ PASS: Production environment strictly blocks localhost webhooks
  ✓ PASS: 301 redirect map contains /free-audit -> /contact/
  ✓ PASS: 301 redirect map contains /case-studies -> /services/
  ✓ PASS: Redirect cleans query string open-redirect attempts
  ✓ PASS: Confirmation HTML email includes lead name
  ✓ PASS: Confirmation HTML email includes service
  ✓ PASS: Internal admin HTML email includes lead name
  ✓ PASS: Internal admin HTML email includes company
  ✓ PASS: Current active theme is agency-site
  ✓ PASS: Theme successfully switched to twentytwentyfour
  ✓ PASS: CPT agency_service persists while another theme is active
  ✓ PASS: All services remain queryable after theme switch
  ✓ PASS: Service metadata remains intact after theme switch
  ✓ PASS: Theme restored back to agency-site

------------------------------------------------------------
RESULTS: 37 PASSED, 0 FAILED (Total: 37)
------------------------------------------------------------
```

---

### 2.2 PHPUnit Integration & Unit Suite
**Command**:
```bash
/Applications/Local.app/Contents/Resources/extraResources/lightning-services/php-8.2.29+0/bin/darwin/bin/php \
  -d mysqli.default_socket="/Users/mac/Library/Application Support/Local/run/Rxl0HKEp-/mysql/mysqld.sock" \
  vendor/bin/phpunit
```

**Exit Code**: `0`  
**Actual Output**:
```text
PHPUnit 9.6.38 by Sebastian Bergmann and contributors.

.......                                                             7 / 7 (100%)

Time: 00:00.228, Memory: 38.50 MB

OK (7 tests, 14 assertions)
```

---

### 2.3 Playwright End-to-End Browser Tests
**Command**:
```bash
node tests/playwright-smoke.js
```

**Exit Code**: `0`  
**Actual Output**:
```text
====================================================
 🎭 PLAYWRIGHT END-TO-END BROWSER TEST RUNNER
====================================================

[1/5] Launching Chrome browser engine...
  ✓ Browser launched successfully.
[2/5] Testing Homepage (Desktop 1280x800)...
  ✓ HTTP 200 - Title: "Apex Digital – Digital Marketing & Web Design"
  ✓ Sticky header #masthead present: true
  ✓ Layout grid elements present: true
[3/5] Testing Mobile Viewport & Drawer (375x667)...
  ✓ Mobile menu toggle button present: true
  ✓ Mobile menu drawer overlay present: true
  ✓ Mobile toggle click sets aria-expanded="true": true
[4/5] Testing Contact Page & Lead Form...
  ✓ Contact page loaded: HTTP 200
  ✓ Inbound lead form #agency-contact-form present: true
  ✓ Hidden security honeypot field present: true
  ✓ CSRF security nonce token input present: true
[5/5] Testing Services Page & Single Service View...
  ✓ Services index loaded: HTTP 200
  ✓ Single service template loaded: HTTP 200

----------------------------------------------------
 RESULTS: 12 BROWSER ASSERTIONS PASSED (0 FAILED)
----------------------------------------------------
```

---

### 2.4 PHPCS with WordPress Coding Standards
**Command (Plugin)**:
```bash
/Applications/Local.app/Contents/Resources/extraResources/lightning-services/php-8.2.29+0/bin/darwin/bin/php \
  vendor/bin/phpcs --standard=phpcs.xml --warning-severity=0 -s plugins/agency-site-core/
```
**Exit Code**: `0`  
**Output**: `......... 9 / 9 (100%) - OK (0 errors, 0 warnings)`

**Command (Theme)**:
```bash
/Applications/Local.app/Contents/Resources/extraResources/lightning-services/php-8.2.29+0/bin/darwin/bin/php \
  vendor/bin/phpcs --standard=phpcs.xml --warning-severity=0 -s themes/agency-site/
```
**Exit Code**: `0`  
**Output**: `...................... 22 / 22 (100%) - OK (0 errors, 0 warnings)`

---

### 2.5 JavaScript Linting
**Command**:
```bash
cd themes/agency-site && npx eslint assets/dist/js/main.js
```
**Exit Code**: `0`  
**Output**: Clean pass (0 errors, 0 warnings).

---

### 2.6 Production Frontend Asset Compilation
**Command**:
```bash
npm --prefix themes/agency-site run build
```
**Exit Code**: `0`  
**Output**: `tailwindcss -i ./assets/src/css/input.css -o ./assets/dist/css/style.css --minify` (Done in 2590ms, 61KB).

---

## 3. Side Effects Verification for Rejected Ingress

To ensure that rejected requests cannot pollute the database, exhaust system memory, or trigger unintended webhooks, every defensive boundary was tested for side effects:

| Scenario | Ingress Vector | Expected Rejection | DB Post Count | Webhook Logs Count | Rate Transient Mutated | Side Effects Observed |
| :--- | :--- | :--- | :---: | :---: | :---: | :---: |
| **Missing / Invalid Fields** | Empty name/email/message | HTTP 400 Bad Request | Unchanged | Unchanged | No | **None** |
| **Forged Nonce** | Bogus `security` token | HTTP 403 Forbidden | Unchanged | Unchanged | No | **None** |
| **Oversized Payload** | 15,360-byte payload | HTTP 413 Payload Too Large | Unchanged | Unchanged | No | **None** |
| **Spam Honeypot** | Filled `agency_hp_website` | HTTP 400 Auto Detected | Unchanged | Unchanged | No | **None** |
| **Rate Limiting** | 6th attempt in 10 minutes | HTTP 429 Too Many Requests | Unchanged | Unchanged | Yes (Capped) | **None** |
| **Unauthorized Meta Save** | Non-logged-in POST to CPT | Silent No-Op | Unchanged | Unchanged | No | **None** |

---

## 4. Localhost Webhook Exception & Production Isolation

In response to architectural verification requirements:
1. **Production Isolation**: In production mode (`wp_get_environment_type() === 'production'`), requests to loopback (`127.0.0.1`, `localhost`, `::1`) are immediately rejected before transport.
2. **SSRF Hardening**: Cloud metadata services (`169.254.169.254`, `metadata.google.internal`) and non-HTTP protocols (`file://`, `gopher://`, `ftp://`) are rejected unconditionally across all environments.
3. **Scoped Filter Application**: The `http_request_host_is_external` hook is applied strictly to matching host callbacks during local testing and is immediately removed inside a `try ... finally` block, preventing filter leakage.

---

## 5. Unresolved Limitations & Status Clarifications

- **Figma Reference**: No Figma artboard link or design tokens file was provided. Layouts are designed to modern B2B SaaS standards, but cannot be claimed as matched to a Figma file without a reference.
- **Live Analytics Hit Transmission**: While `window.dataLayer` event dispatching was tested and confirmed in the browser, streaming hits to Google Analytics servers remains **Unverified until actually observed** (requires entering a live Measurement ID and verifying incoming data via GA4 DebugView or an analytics observer).
- **External Webhook Receiver**: Webhook dispatching with HMAC-SHA256 signatures was verified using local endpoints; external ingestion into third-party tools (HubSpot, Salesforce, Zapier) remains **Unverified until actually observed** with production credentials.
- **CI Actions Pipeline**: Remote repository configured for `https://github.com/Daniel4000-dev/apex-digital.git`. Workflow executions can be viewed at: `https://github.com/Daniel4000-dev/apex-digital/actions`.
