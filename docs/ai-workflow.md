# AI-Assisted Engineering Workflow & Retrospective

## 1. Overview & Tooling

This project was engineered using **Google Antigravity**, an agentic AI pair programming environment developed by the Google DeepMind team. The workflow combined rapid synthesis, codebase-wide refactoring, defensive code generation, and rigorous verification via local CLI tooling.

---

## 2. Iteration Strategy & Workflow Phases

```
┌─────────────────────────────────┐
│ 1. Discovery & Environment Sync │  Local Mac, PHP 8.2, MySQL Socket, Mailpit
└────────────────┬────────────────┘
                 │
                 ▼
┌─────────────────────────────────┐
│ 2. Theme Prototyping (Tailwind) │  Mobile Drawer, Component Breakdown, Templates
└────────────────┬────────────────┘
                 │
                 ▼
┌─────────────────────────────────┐
│ 3. Modular Decoupling (Plugin)  │  CPTs, Meta Boxes, Nonce, Honeypot, Rate Limiting
└────────────────┬────────────────┘
                 │
                 ▼
┌─────────────────────────────────┐
│ 4. Integrations & Hardening     │  HMAC Webhooks, SSRF Filter, HTML Emails, SEO
└────────────────┬────────────────┘
                 │
                 ▼
┌─────────────────────────────────┐
│ 5. Automated Verification & QA  │  WP-CLI Test Harness, Mailpit API, Mock HTTP
└─────────────────────────────────┘
```

---

## 3. Key Technical Challenges & Solutions

### Challenge 1: Tailwind CSS v4 vs v3 Compilation
- **Issue**: Attempting to invoke `tailwindcss` via npm resulted in `sh: tailwindcss: command not found` due to the v4 CLI package restructuring.
- **AI Solution**: Inspected `package.json`, pinned `@tailwindcss/typography`, and installed `tailwindcss@^3.4.17` with PostCSS and Autoprefixer, configuring `tailwind.config.js` with content purge paths covering all PHP template files. Rebuilt a minified 61KB CSS bundle.

### Challenge 2: Local by Flywheel MySQL Unix Socket
- **Issue**: Standard WP-CLI commands failed with `Error establishing a database connection` because Local uses a dynamically generated Unix socket (`/Users/mac/Library/Application Support/Local/run/Rxl0HKEp-/mysql/mysqld.sock`) rather than TCP port 3306.
- **AI Solution**: Identified the socket configuration from `wp-config.php` and configured all CLI commands with `-d mysqli.default_socket="..."`.

### Challenge 3: WP-CLI Process Termination on `wp_send_json_success()`
- **Issue**: When executing the automated integration test script via `wp eval-file`, the script unexpectedly terminated midway through execution after outputting JSON.
- **AI Solution**: Analyzed WordPress core source in `wp-includes/functions.php`. Discovered that when `wp_doing_ajax()` evaluates to false in CLI contexts, `wp_send_json()` calls PHP `die;` directly. Set `define('DOING_AJAX', true);` and registered custom `wp_die_ajax_handler` exception interceptors, allowing all 21 test assertions to execute to completion.

---

## 4. Verification & Defensive Coding Practices

Rather than accepting AI-generated code on faith, every critical system was subjected to real-world verification:
1. **SSRF Boundary Testing**: Simulated an attacker pointing the webhook destination at `169.254.169.254`. Confirmed the dispatcher caught and blocked the request before network transmission.
2. **Rate Limiting Simulation**: Simulated an abusive IP address hitting the endpoint 6 times within 10 minutes. Confirmed the 6th submission returned HTTP 429.
3. **Mailpit API Evidence**: Queried `http://127.0.0.1:10000/api/v1/messages` to verify transactional HTML formatting, ensuring responsiveness on mobile clients.
4. **Decoupling Verification**: Verified that custom post types and inquiries exist independently of whether the custom theme or a default theme is active.

---

## 5. Lessons Learned & Productivity Assessment

1. **Architecture First**: Defining the boundary between Theme (presentation) and Plugin (data/integrations) early prevented messy technical debt when extracting CPTs.
2. **Automated Test Runners in CLI**: Writing a self-contained CLI test runner (`tests/run-all-tests.php`) saved hours of manual form submissions and provided instant regression feedback.
3. **Honest Reporting**: Clearly documenting what was verified (local endpoints, Mailpit, mock webhooks) versus what was blocked by external accounts (live GA4 container, Figma design file) establishes trust and transparency in engineering handoffs.
