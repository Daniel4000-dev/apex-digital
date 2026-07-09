# Agency Site — Security Architecture & Hardening Report

## 1. Security Overview

The **Agency Site** theme and `agency-site-core` plugin implement defensive, multi-layered security controls adhering to the OWASP Top 10 and WordPress Core Security Best Practices. All inputs are untrusted by default, validated on the boundary, and sanitized before storage or execution. All outputs are context-sensitively escaped.

---

## 2. Threat Modeling & Defensive Controls

| Threat / Attack Vector | Risk Level | Defensive Implementation | Verification Status |
| :--- | :--- | :--- | :--- |
| **Cross-Site Request Forgery (CSRF)** | High | WordPress Nonce verification (`check_ajax_referer('agency_contact_action_nonce', 'security')`) | Verified |
| **Spam Bot Automation** | Medium | Hidden Honeypot field (`agency_hp_website`) with bot decoy styling (`opacity: 0; pointer-events: none; tabindex: -1`) | Verified |
| **Denial of Service / Flooding** | High | IP-based transient rate limiter (5 submissions per 10-minute window) + 10KB payload hard ceiling | Verified |
| **Cross-Site Scripting (XSS)** | Critical | `sanitize_text_field()`, `sanitize_email()`, `sanitize_textarea_field()` on ingress; `esc_html()`, `esc_attr()`, `esc_url()` on egress | Verified |
| **Email Header Injection (CRLF)** | High | Strip `\r`, `\n`, `%0a`, `%0d` from sender name, subject, and email fields before `wp_mail()` | Verified |
| **Server-Side Request Forgery (SSRF)** | Critical | `wp_safe_remote_post()` + explicit blocking of AWS/GCP/Azure link-local metadata address `169.254.169.254` | Verified |
| **Webhook Payload Tampering** | High | HMAC-SHA256 signature calculated over raw body (`X-Agency-Signature: sha256=...`) with user-configurable shared secret | Verified |
| **Privilege Escalation** | High | All admin menus and settings pages require `current_user_can('manage_options')` | Verified |
| **Database Injection (SQLi)** | Critical | Exclusive use of `$wpdb->prepare()`, core CRUD (`wp_insert_post`, `update_post_meta`), and table abstraction | Verified |

---

## 3. Detailed Control Specifications

### 3.1 Input Validation & Ingress Boundaries
All incoming requests hitting `agency_submit_contact` undergo sequential defensive validation:
1. **Payload Size Guard**:
   ```php
   $raw_input = file_get_contents('php://input');
   if (strlen($raw_input) > 10240) {
       wp_send_json_error(['message' => 'Request payload exceeds 10KB.'], 413);
   }
   ```
2. **CSRF Nonce Check**:
   ```php
   if (!check_ajax_referer('agency_contact_action_nonce', 'security', false)) {
       wp_send_json_error(['message' => 'Invalid or expired security token.'], 403);
   }
   ```
3. **Spam Honeypot Verification**:
   If the hidden field `agency_hp_website` contains any characters, the request is flagged as a bot. The handler returns a friendly message to avoid bot feedback loops without storing or emailing the submission:
   ```php
   if (!empty($_POST['agency_hp_website'])) {
       wp_send_json_error(['message' => 'Automated submission detected.'], 200);
   }
   ```
4. **Transient-based Rate Limiter**:
   ```php
   $ip = preg_replace('/[^0-9a-fA-F:.]/', '', $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
   $rate_key = 'agency_rate_' . md5($ip);
   $hits = (int) get_transient($rate_key);
   if ($hits >= 5) {
       wp_send_json_error(['message' => 'Too many requests. Please wait a few minutes.'], 429);
   }
   set_transient($rate_key, $hits + 1, 600);
   ```

### 3.2 Output Escaping Strategy
Every template adheres strictly to contextual escaping:
- **HTML Content**: `esc_html( $variable )`
- **HTML Attributes**: `esc_attr( $attribute )`
- **Hyperlinks & Assets**: `esc_url( $url )`
- **JavaScript Variables**: `wp_json_encode( $data )` or `esc_js( $value )`
- **Translatable Text**: `esc_html__( 'Text', 'agency-site' )`

### 3.3 Email Header Injection (CRLF) Protection
Before passing variables to `wp_mail()` headers, line breaks are stripped:
```php
$name  = str_replace(["\r", "\n", "%0a", "%0d"], '', sanitize_text_field($_POST['name']));
$email = sanitize_email($_POST['email']);
$headers = [
    'Content-Type: text/html; charset=UTF-8',
    'Reply-To: ' . $name . ' <' . $email . '>',
];
```

### 3.4 Webhook Transport & SSRF Defense
The Webhook Dispatcher enforces strict safeguards:
1. **Destination Verification**:
   - Must be a valid URL via `wp_http_validate_url()`.
   - Explicitly rejects cloud metadata endpoints (`169.254.169.254`) and AWS instance identity documents.
   - Restricts ports to standard HTTP/HTTPS (`80`, `443`, or designated testing port).
2. **Payload Cryptographic Signature**:
   - The outbound JSON payload is serialized with `wp_json_encode()`.
   - A keyed-hash message authentication code (`HMAC-SHA256`) is computed with the configured shared secret:
     ```php
     $signature = hash_hmac('sha256', $json_payload, $secret);
     $headers['X-Agency-Signature'] = 'sha256=' . $signature;
     $headers['X-Agency-Timestamp'] = time();
     ```
3. **Transport Resilience**:
   - Executed via `wp_safe_remote_post()` with an 8-second connection timeout.
   - Failures (network timeouts, 4xx/5xx responses) are caught gracefully in a `try/catch` block without crashing the user's form submission or interrupting email delivery.
   - All outcomes (headers, request body, response code, response body, latency, error messages) are persisted to `{$wpdb->prefix}agency_webhook_delivery_logs`.

### 3.5 Administrative Capabilities & Access Control
- All settings forms verify nonces (`check_admin_referer('agency_settings_verify', 'agency_settings_nonce')`).
- Access to the Settings and Webhook Delivery Logs screens is gated with `current_user_can('manage_options')`.
- Non-administrators cannot read enquiry records or inspect webhook logs.
