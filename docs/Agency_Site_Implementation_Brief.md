# Agency Site: implementation and code review brief

Prepared for the existing WordPress portfolio project on 2 November 2026.

## Purpose and current evidence

Implement this brief in the Antigravity workspace containing the running Local site. Continue the existing project; preserve its content and useful design work. This document specifies work to perform. It does not certify that the source has been reviewed or that these checks have passed.

The previous completion report describes an active classic PHP theme, Tailwind build, editable content, services custom post type, blog, and an AJAX enquiry form. Treat these as reported features until inspected and tested. PHP syntax checks and HTTP 200 responses establish only part of the required evidence.

The project must demonstrate the vacancy's main work: custom WordPress development, PHP, Tailwind, HTML/CSS/JavaScript, Figma implementation, landing pages, email development, SEO, integrations, maintenance, and responsible use of AI development tools.

## 1. Choose a coherent stack

| Requirement or checklist item | Priority | Evidence to deliver |
| --- | --- | --- |
| WordPress custom theme development | Core | A working original classic theme, editable content, reusable templates, documented setup and browser tests. |
| PHP | Core | Small readable modules, WordPress APIs, tested server-side behaviour, and clear error handling. |
| Tailwind CSS | Core | Reproducible compiled styles, reusable design tokens, correct scanning of PHP templates, responsive layouts. |
| HTML5, CSS and JavaScript | Core | Semantic markup, accessible navigation/forms, progressive enhancement and browser tests. |
| Figma designs | Core evidence gap | A genuine design reference and desktop/mobile comparisons. An AI-generated design alone does not demonstrate Figma-to-code fidelity. |
| Technical SEO implementation | Core | Inspectable metadata, canonical handling, native sitemap integration, valid structured data, one tested redirect and crawl checks. |
| HTML email development | Core | A branded acknowledgement and internal notification, with inline base CSS, sensible email layout fallbacks, plain-text alternatives and captured test messages. |
| Third-party integrations | Core | A real test webhook delivery using dummy data, plus deterministic failure tests. A configured URL alone is not verified delivery. |
| Google Analytics 4 and Google Tag Manager | Strong supporting evidence | A documented GTM-to-GA4 event path, configuration, consent behaviour, event assertions and real-account verification where credentials/IDs are supplied. |
| Cursor, GitHub Copilot, Claude Code | Report actual use | Document only tools actually used. Antigravity is valid AI-development evidence but is not evidence of using each named product. |
| ACF Pro | Optional, if available | A real installed integration, exported field definitions and tested editing/rendering; otherwise document the native field implementation. |
| Gravity Forms | Optional, if available | A genuine form integration with exported configuration and tested hooks; a custom form is not Gravity Forms experience. |
| Sass, Gulp, Twig, Foundation | Optional | Add only for an existing architectural reason or an explicit employer requirement. Do not combine overlapping frameworks merely to increase the checkbox count. |
| AI-powered WordPress integrations or automations | Optional product feature | Requires an actual AI feature or workflow inside WordPress. Using an AI coding assistant alone does not meet this description. |

The application asks for hands-on professional experience. Describe this new work as a portfolio project unless it genuinely forms part of professional work. Do not convert it into invented employment history or years of experience.

## 2. Work in this order

1. Inspect the actual theme, plugin directory, Git root, database configuration, installed versions and existing tests. Produce a short audit with file locations and specific findings.
2. Establish a baseline: screenshots, page/content checks, form behaviour and build output. Preserve a recoverable code checkpoint and back up the site's existing content before migrations.
3. Refactor boundaries and address security defects. Preserve the existing `agency_service` post type name, metadata keys and public URLs unless a documented migration is necessary.
4. Complete missing core requirements. Continue independent work when a Figma reference, commercial plugin, external account or test endpoint is missing; record that specific verification as blocked.
5. Run the meaningful tests below and fix failures. Do not stop at generating test files or commands.
6. Prepare the reviewer package and final evidence report. Keep implemented, tested and blocked items distinct.

## 3. Modular WordPress architecture

Keep `themes/agency-site` as the theme. Add a companion plugin, such as `plugins/agency-core`, for durable site functionality. Adapt names to the actual project rather than moving files blindly.

| Area | Responsibility |
| --- | --- |
| Theme bootstrap | Register theme support, menus, translations, image sizes and presentation hooks. Keep `functions.php` a short entry point. |
| Theme presentation modules | Asset loading, Customizer presentation settings and template helpers. |
| Template parts | Shared hero, service card, post card, pagination and CTA markup. Keep business processing out of templates. |
| Plugin content module | Service post type, field registration, metadata validation and authorized admin editing. |
| Enquiry validator and service | Validate requests, define acceptance rules, coordinate persistence and notifications. |
| Request handler | A thin AJAX or REST adapter that maps requests/results to the application service. Avoid changing the existing endpoint without a reason. |
| Integration adapters | Separate mail, webhook and scheduling code so failure paths can be tested without real external requests. |
| Plugin settings | Capability-protected configuration, using WordPress's settings and options APIs. |

Use consistent namespaces or distinctive prefixes. Prefer a few focused modules and explicit dependencies; add classes when they improve boundaries or testability. Avoid a large controller containing validation, SQL, mail, analytics and HTML rendering together. A framework or dependency-injection container is not required.

Use WordPress APIs for queries, metadata, HTTP, settings, mail and assets. Use prepared statements if custom SQL is genuinely needed. Enqueue assets through WordPress, version them consistently and load page-specific assets only where useful. Support translation of user-visible strings.

A theme switch must leave the services post type registered through the active plugin. Existing content must remain available to administrators. Deactivation must not silently erase content, settings or enquiries. Flush rewrite rules only on relevant activation/migration events, not on every request.

## 4. Security acceptance criteria

### Requests, fields and admin changes

- Validate field shape, allowed values, required fields and lengths on the server before performing side effects. Reject arrays where strings are expected; validate email addresses and service identifiers explicitly.
- Apply appropriate sanitization and contextual output escaping. Use HTML, attribute, URL and permitted-rich-text escaping according to the rendering context. Inspect database values and Customizer values as well as direct request input.
- Verify action-specific nonces where appropriate. WordPress nonces do not provide authorization or reliable anonymous bot prevention.
- Gate settings changes and metadata updates with appropriate capabilities. Check the specific post-edit capability for post updates; account for autosaves and revisions.
- Explicitly define public versus authenticated endpoints. Public enquiry submission should not expose administrative actions or stored enquiry data.
- Add modest abuse controls for the public form: honeypot, bounded payload size and a documented rate limiter. Document proxy/IP assumptions and the limitations of transient-based limiting.
- Prevent email header injection. Use configured recipients and validated reply-to values; public input must not select arbitrary recipients or headers.
- Return meaningful status codes and accessible errors. Reject invalid requests without creating records, sending mail, calling a webhook or recording successful conversion events.

### Accepted enquiries and external delivery

- Define the submission contract. Prefer saving a minimal private enquiry record before notifying external systems. Keep enquiry data out of public search, REST responses, feeds and sitemaps; restrict admin access.
- Make notification status explicit. A webhook failure after a saved enquiry must not lose that enquiry or claim that external delivery succeeded.
- Use a configured HTTPS destination controlled by an authorized administrator. Use `wp_safe_remote_post()` and URL validation; reject unsafe/private destinations and unsafe redirects rather than accepting a visitor-supplied target.
- Keep TLS verification enabled. Set bounded timeouts and handle `WP_Error`, non-2xx responses and malformed replies. Test unsafe destinations with mocks, without contacting internal or metadata services.
- Log useful request identifiers, delivery state and error categories without recording credentials or full enquiry bodies. Document stored data and how an administrator can remove it.
- If delivery retries are needed, use a small bounded retry mechanism with a manual retry path. Document that ordinary WP-Cron depends on site traffic and does not guarantee exact execution times. Explain any receiver-side idempotency assumption.

Secrets must remain server-side and outside version control. Do not expose keys in JavaScript, HTML, screenshots, test traces or logs. Debug output should be suitable for development, with production settings documented separately.

## 5. Finish the main job deliverables

### A. Figma-to-code proof

Use a genuine Figma reference supplied or approved for this project. Record its URL/file and the frames implemented. Match typography, spacing, component states and responsive behaviour; capture comparable desktop/mobile screenshots and document intentional differences. If no reference exists, mark fidelity testing as blocked. Do not claim a Figma implementation from a design created entirely in code.

### B. Editable website and client handoff

Verify editing a hero headline, navigation item, service, featured image and blog article through WordPress. Changes must survive reload and remain visible in the intended template. Provide helpful empty states and 404 handling. Ensure public pages render sensibly when an optional integration is disabled.

Create a brief client handoff explaining routine edits, form enquiries, plugin/theme updates, backups and rollback. Include one actual maintenance change and its validation in the changelog. Label simulated client requests as simulations.

### C. Technical SEO

Audit the existing output before adding another metadata generator. Implement or configure page titles/descriptions, one correct canonical per page, appropriate social metadata, native WordPress sitemap support and accurate structured data. Do not invent rating markup or add duplicate SEO output alongside an installed SEO plugin.

Test blog pagination and service pages, not just the homepage. Include one fixed, same-site 301 redirect example with no loop or open-redirect behaviour. Verify a real 404 response for an invalid URL. Keep development/demo indexing policy explicit; a local site is not evidence of Google indexing or ranking.

### D. GA4 and GTM

Prefer one documented tracking path: GTM containing the GA4 configuration and relevant events. Avoid also loading a duplicate direct GA4 installation. Validate configuration, respect the chosen consent mechanism, and keep tracking disabled until the required IDs/configuration are supplied.

Emit `generate_lead` only after the server accepts a valid enquiry. Record CTA events without names, email addresses, phone numbers or message contents. Verify that invalid submissions and duplicate handlers do not generate successful conversions. Test consent-denied and consent-granted behaviour.

Deliver an event map and setup instructions. Local tests can verify event payloads and script behaviour. GTM Preview and GA4 DebugView evidence require real configured accounts; do not label them verified until observed. A placeholder container ID is not a completed integration.

### E. HTML email

Build both an enquiry acknowledgement and an internal notification. Keep email templates separate from browser page templates. Use email-appropriate structure, inline base styles, responsive enhancements with fallbacks, readable system fonts, useful alt text, absolute image/link URLs and a plain-text alternative. Escape dynamic content and use dummy enquiry data for examples.

Capture real messages in Local's Mailpit and inspect both HTML and text content. Verify subject, sender/reply-to, substituted fields, links and error handling. Mailpit capture establishes local mail generation; it does not prove external inbox delivery or compatibility with every email client. Record actual Gmail/Outlook/mobile testing separately if available.

### F. Optional commercial and AI integrations

If legitimate ACF Pro access is available, use it for a clear feature and version the field definitions through Local JSON or documented exports. If Gravity Forms is available, use its real configuration/hooks for a purposeful form path. Do not build duplicate public forms solely to collect tool names. Keep vendor plugin distributions and license keys out of the public source package; document installation requirements.

If no license is available, complete the native fields/custom form and record the commercial integration as not demonstrated. Native field code does not establish ACF Pro experience, and an adapter stub does not establish a tested Gravity Forms integration.

Only after core work is complete, an optional admin-only AI draft assistant could demonstrate an AI-powered WordPress feature. It must require an appropriate capability, keep provider credentials server-side, validate requests and outputs, handle failures, and save drafts for human review rather than automatically publishing. A mock provider is useful for tests, but real provider functionality must be separately verified before claiming it works.

## 6. Meaningful automated tests

Use PHPUnit for PHP unit and WordPress integration tests, plus Playwright for key browser flows. Use WordPress's actual test environment for capability, nonce, metadata and registration behaviour; do not mock WordPress itself and then claim integration coverage. Use a separate disposable test database/site, never a database reset against the user's working Local content.

| Scenario | Required assertion |
| --- | --- |
| Valid enquiry | Expected accepted record/result; intended mail and webhook behaviour; useful confirmation. |
| Invalid/missing/oversized fields or wrong types | Request rejected; no enquiry record, notification, webhook or successful conversion event. |
| Invalid nonce | Protected operation rejected with the expected response and no side effects. |
| Unauthorized settings/meta changes | Anonymous and insufficient-role requests fail; an authorized administrator succeeds. |
| Unsafe saved content | Dynamic values render safely in their HTML/attribute/URL contexts while permitted rich content still works. |
| Repeated/abusive requests | Honeypot and rate-limit behaviour work under documented assumptions. |
| Mail transport failure | Error/status accurately reflects the defined submission contract; no silent loss of an accepted enquiry. |
| Webhook timeout, error and non-2xx response | Delivery status is accurate, logs are safe, retry behaviour is bounded and the enquiry is retained. |
| Unsafe webhook destination | Request blocked before transport; test does not contact the dangerous address. |
| Theme switch | Services remain registered and existing content remains editable while the companion plugin stays active. |
| SEO URLs | Expected title/canonical, sitemap entries, one 301 and a real 404; pagination tested. |
| Analytics | One expected event after successful acceptance; none for rejected submissions; no PII; correct consent behaviour. |
| Browser navigation | Main links, service prefill, blog pagination and the 404 experience work. |
| Mobile/keyboard | Menu state, Escape handling, appropriate focus management, visible focus and labelled form errors. |
| Email rendering/content | Real HTML/text messages captured locally with expected escaped fields and links. |

Exercise representative mobile, tablet and desktop widths. Add axe checks for applicable accessibility issues and manual keyboard checks; automated scans alone are not complete accessibility certification. Assert user-visible behaviour and security boundaries rather than CSS class names or trivial getters.

Keep normal test runs deterministic: stub external HTTP/provider calls and reserve clearly labelled integration checks for real test endpoints. Include a negative test showing a meaningful failure is detected. Do not add a large collection of shallow tests simply to advertise a count or coverage percentage.

## 7. Build, tooling and continuous integration

Provide working commands in the actual root README and package files for:

- Installing locked dependencies and building production CSS/assets.
- PHP lint and PHP_CodeSniffer with WordPress Coding Standards.
- JavaScript lint.
- PHP unit/WordPress integration tests.
- Playwright browser and accessibility checks.

Use compatible stable tool versions and commit lockfiles. Inspect the reported Node 20 setup: Node 20 is listed as EOL at preparation time. Select and test a currently supported LTS for this project's build, record it in version configuration, and keep CI aligned. Read the real Local WordPress/PHP versions and document the tested compatibility range rather than guessing it.

Configure PHPCS for custom theme/plugin source, excluding vendor and generated files appropriately. Address security-related findings; do not suppress the escaping, nonce or authorization checks merely to obtain a passing output. Document any narrowly justified style exceptions. Investigate relevant dependency advisories and document any unresolved tooling constraint instead of forcing breaking upgrades blindly.

Create a GitHub Actions workflow that installs dependencies from lockfiles, builds assets, runs the quality gates and fails on failures. Give CI only the permissions it needs and use dedicated test configuration. Browser/integration tests should have a reproducible WordPress runtime such as wp-env with pinned tested versions and sample content. Document Docker/prerequisites for that runtime without requiring the user to abandon their working Local installation.

Demonstrate the commands on a fresh disposable checkout/runtime. A workflow YAML file or a list of proposed scripts is not proof that CI ran. Keep logs/artifacts sufficient to reproduce results, without secrets or personal data.

Measure representative page performance using a documented lab setup and preserve results. Distinguish lab measurements from real-user Core Web Vitals. Fix observed causes such as oversized images, missing dimensions, unnecessary scripts or excessive queries; report actual measurements rather than an invented score improvement.

## 8. Reviewer package

Prepare the repository named `wordpress-agency-site`, using one source of truth for the custom theme and companion plugin. Inspect the existing Git root before restructuring anything. Exclude WordPress core, third-party plugin distributions, node_modules, vendor, private configuration, runtime databases and real uploads/secrets. Include the source, lockfiles, build configuration, tests and a straightforward activation path. If compiled assets are needed for installation without Node, include them in the documented distributable and make their build reproducible.

Deliver these documents, consolidating where that improves readability:

| Deliverable | What the reviewer should learn |
| --- | --- |
| README | Purpose, screenshots, demo access, setup, prerequisites, activation and exact test commands. |
| Architecture notes | Theme/plugin boundaries, enquiry lifecycle and important tradeoffs. |
| Verification report | Actual commands, exit codes, tested runtime, browser checks, failures fixed and remaining blockers. |
| Security notes | Input/authorization/output controls, webhook controls, data handling and known limitations; no unsupported claim of a penetration test. |
| Design evidence | Genuine Figma reference and comparable implementation screenshots, or a clearly marked missing reference. |
| Analytics/integration guide | Event map, account configuration, webhook contract, verified external tests and configuration-only items. |
| Client handoff | How an editor manages content and enquiries; practical update/backup/rollback instructions. |
| AI workflow | Actual tool names, representative tasks, reviewed code changes and examples of human correction. |

Use clearly fictional branding and mark sample testimonials/statistics as demonstration content. Do not present generated marketing claims as achievements for real clients. Include a short walkthrough showing a content edit, mobile navigation, a test enquiry, captured email and integration evidence. A `.local` URL only works in the developer's environment; provide a reviewer-accessible demo or documented reproducible preview when preparing the application.

## 9. Completion contract

For every main requirement, report one of: **Implemented and verified**, **Implemented but not externally verified**, **Blocked**, or **Not included (optional)**.

For each claim include the relevant source path, actual command/check and result. Record missing Figma input, licenses, analytics IDs, endpoint access or email-client tooling explicitly. Do not claim that an adapter, mocked test or configuration placeholder proves a live integration.

Finish by explaining the code that the applicant should be able to discuss: template hierarchy, hooks, enqueueing, content versus presentation, validation/sanitization/escaping, nonces versus capabilities, webhook failure handling, test isolation and build/CI choices. The applicant must be able to run, modify and explain the submitted work.

## Primary references

- WordPress post type boundaries: https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/
- WordPress input validation: https://developer.wordpress.org/apis/security/data-validation/
- WordPress escaping: https://developer.wordpress.org/apis/security/escaping/
- WordPress nonces and their limits: https://developer.wordpress.org/apis/security/nonces/
- WordPress Coding Standards: https://developer.wordpress.org/coding-standards/wordpress-coding-standards/
- Official PHPCS rules: https://github.com/WordPress/WordPress-Coding-Standards
- WordPress PHPUnit guidance: https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/
- Safe outbound POST requests: https://developer.wordpress.org/reference/functions/wp_safe_remote_post/
- WP-Cron behaviour: https://developer.wordpress.org/plugins/cron/
- Mail processing semantics: https://developer.wordpress.org/reference/functions/wp_mail/
- Local Mailpit: https://localwp.com/help-docs/local-features/mailpit/
- Playwright accessibility testing: https://playwright.dev/docs/accessibility-testing
- Responsive email guidance: https://templates.mailchimp.com/development/responsive-email/
- GA4 recommended events: https://developers.google.com/analytics/devguides/collection/ga4/reference/events
- ACF Local JSON: https://www.advancedcustomfields.com/resources/local-json/
- Gravity Forms installation: https://docs.gravityforms.com/getting-started/
- Supported Node releases: https://nodejs.org/en/about/previous-releases

