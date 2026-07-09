# Agency Site — Client & Content Editor Handoff Guide

Welcome to the **Apex Digital Strategy** WordPress management guide. This document explains how content editors and administrators manage services, review lead inquiries, configure integrations, and maintain the site.

---

## 1. Content Management

### 1.1 Managing Services (`Services` Menu)
Services are registered as a custom content type independent of the theme:
1. In the WordPress sidebar, click **Services > Add New Service**.
2. **Title**: The public service name (e.g. *Conversion Rate Optimization*).
3. **Editor / Main Content**: Deep dive into your methodology, process, and deliverables.
4. **Featured Image**: High-resolution image displayed in the hero and service cards.
5. **Service Metadata Box** (below editor):
   - **Service Icon**: Lucide SVG name or CSS class (e.g., `chart-bar`, `search`, `users`, `target`).
   - **Tagline**: Punchy benefit statement (e.g., *Data-driven testing programs that turn traffic into pipeline*).
   - **Short Summary**: 2-sentence description for listing cards and meta tags.
   - **Key Deliverables**: Enter one deliverable per line (rendered as structured checkmarks).
   - **Typical Timeline**: e.g., `3–6 months initial sprint`.
   - **Price Tier / Starting Price**: e.g., `Starting at $5,000 / month`.
6. Click **Publish** or **Update**. The new service is immediately listed at `/services/` and included in the automated XML sitemap.

### 1.2 Managing Blog Articles (`Posts` Menu)
- Standard WordPress posts populate the `/blog/` archive and homepage insights section.
- Assign **Categories** (e.g. *Strategy*, *SEO*, *Paid Growth*) and **Featured Images** to populate post cards.
- Reading time and publication dates are calculated automatically by theme template tags.

### 1.3 Demonstration Content Notice
> [!IMPORTANT]
> **Fictional Demonstration Content**: Statistics displayed on the homepage ($45M+ Pipeline Generated, 340% Average ROI, 98% Client Retention) and testimonials (Elena Rostova / CloudScale AI, Marcus Vance / Hyperion Logistics, Sarah Jenkins / Aura Health) are sample placeholders created for portfolio and testing purposes. Replace them with verified client metrics before launching to production.

---

## 2. Inquiries & Webhook Management

### 2.1 Reviewing Lead Inquiries (`Enquiries` Menu)
When a prospective client submits the contact form:
1. An inquiry post is created under **Enquiries > All Enquiries**.
2. Click any inquiry to inspect full lead details:
   - Prospect Name, Work Email, Phone Number
   - Company Name, Service Requested, Monthly Budget Bracket
   - Full Message / Scope Details
   - Submitter IP, Timestamp, and Webhook Status
3. An HTML confirmation is automatically dispatched to the prospect and an alert is delivered to the administrator email.

### 2.2 Webhook Integration Settings (`Enquiries > Settings & Webhooks`)
To forward leads into your CRM (HubSpot, Salesforce, Zapier, Make, n8n):
1. Navigate to **Enquiries > Settings & Webhooks**.
2. Check **Enable Webhook Delivery**.
3. **Webhook URL**: Enter your external webhook ingestion URL (must begin with `https://`).
4. **Shared Secret**: Enter an alphanumeric signing secret. Outbound requests include header:
   `X-Agency-Signature: sha256=<HMAC>`
5. Click **Save Settings**.
6. Use the **Test Webhook Dispatch** button to verify payload transmission with a sample lead.

### 2.3 Inspecting Delivery Logs (`Enquiries > Delivery Logs`)
- View historical webhook transmission attempts.
- Table columns indicate: **Log ID**, **Enquiry ID**, **Target URL**, **HTTP Status**, **Status** (`delivered` / `failed`), **Timestamp**, and **Error Details**.
- Click **View Full Payload & Response** to inspect raw request headers and response bodies for debugging.

---

## 3. SEO & Redirects Management

- **Automated Metadata**: The core plugin generates meta titles, descriptions, canonical URLs, and Open Graph tags automatically.
- **XML Sitemaps**: WordPress Core Sitemaps are enabled at `/wp-sitemap.xml` and include `/wp-sitemap-posts-agency_service-1.xml`.
- **Pre-Configured 301 Redirects**:
  - `/free-audit` ➔ `/contact/`
  - `/audit` ➔ `/contact/`
  - `/case-studies` ➔ `/services/`

---

## 4. Maintenance & Backups

1. **Database Backups**: Always back up the WordPress database (`wp_posts`, `wp_postmeta`, and `wp_agency_webhook_delivery_logs`) before updating core or plugins.
2. **Rebuilding Frontend Assets**:
   If editing CSS styles in `themes/agency-site/assets/src/css/input.css`:
   ```bash
   cd themes/agency-site
   npm run build
   ```
3. **Decoupled Architecture Safety**:
   If the theme is ever switched, all service data, inquiry submissions, and webhook history remain intact in the database.
