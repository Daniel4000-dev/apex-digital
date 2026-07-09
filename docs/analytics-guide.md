# Agency Site — Analytics & Tag Management Guide

## 1. Overview

The **Agency Site** companion plugin (`agency-site-core`) provides configurable Google Analytics 4 (GA4) and Google Tag Manager (GTM) script injection and an event measurement layer built directly into the vanilla JavaScript frontend.

All tracking logic utilizes the standard `window.dataLayer = window.dataLayer || [];` event bus pattern. When GTM is installed, custom tags can fire on these events. When GA4 is loaded directly, `gtag('event', ...)` is executed automatically.

---

## 2. Configuration via WordPress Dashboard

Navigate to **WP Admin > Enquiries > Settings & Webhooks**:

1. **Google Analytics 4 Measurement ID**:
   - Format: `G-XXXXXXXXXX`
   - Example: `G-8ABC123XYZ`
   - If populated, the gtag.js loader is enqueued asynchronously in `<head>` with your measurement ID.
2. **Google Tag Manager Container ID**:
   - Format: `GTM-XXXXXXX`
   - Example: `GTM-N89P5K2`
   - If populated, the standard GTM `<head>` script and `<noscript>` `<iframe>` body fallback are enqueued.
3. Save settings. Changes take effect across all public pages immediately.

---

## 3. DataLayer Event Schema & Trigger Map

| Event Name | Trigger Condition | DataLayer Payload | Intended Marketing Goal |
| :--- | :--- | :--- | :--- |
| `generate_lead` | Successful AJAX response from contact form submission | `{ event: 'generate_lead', service: string, budget: string, lead_id: number }` | Key Conversion / Lead Submission |
| `agency_cta_click` | Clicks on primary or secondary action buttons (`data-agency-cta`) | `{ event: 'agency_cta_click', cta_text: string, cta_destination: string, cta_location: string }` | Micro-conversion / User Intent |
| `agency_faq_opened` | User clicks an accordion header on Services or Contact page | `{ event: 'agency_faq_opened', faq_question: string }` | Engagement / Content Relevance |

### Example DataLayer Payloads

#### 1. Lead Generation (`generate_lead`)
```javascript
window.dataLayer.push({
    event: 'generate_lead',
    event_category: 'lead_generation',
    service: 'Search Engine Optimization (SEO)',
    budget: '$10,000 - $25,000 / month',
    lead_id: 142
});
```

#### 2. CTA Click (`agency_cta_click`)
```javascript
window.dataLayer.push({
    event: 'agency_cta_click',
    cta_text: 'Schedule a Consultation',
    cta_destination: 'http://wordpress-agency-site.local/contact/',
    cta_location: 'hero_section'
});
```

#### 3. FAQ Accordion Interaction (`agency_faq_opened`)
```javascript
window.dataLayer.push({
    event: 'agency_faq_opened',
    faq_question: 'How long before we see organic search improvements?'
});
```

---

## 4. Google Tag Manager Setup Instructions

To route events into GA4 or ad platforms (LinkedIn Insight, Meta Pixel) via GTM:

1. **Create Custom Event Triggers**:
   - Trigger Type: **Custom Event**
   - Event Name: `generate_lead`
   - Create identical Custom Event triggers for `agency_cta_click` and `agency_faq_opened`.
2. **Create Data Layer Variables**:
   - Name: `dlv - service` | Data Layer Variable Name: `service`
   - Name: `dlv - budget` | Data Layer Variable Name: `budget`
   - Name: `dlv - cta_text` | Data Layer Variable Name: `cta_text`
3. **Create Google Analytics 4 Event Tag**:
   - Tag Type: **Google Analytics: GA4 Event**
   - Measurement ID: Your `G-XXXXXXXXXX`
   - Event Name: `generate_lead`
   - Event Parameters: Add parameters mapping to `{{dlv - service}}` and `{{dlv - budget}}`.
   - Firing Trigger: Trigger created in Step 1.

---

## 5. Live Verification vs Mock Environment Notice

- **Verified In Workspace**:
  - The script enqueues `<script>` tags correctly when valid ID formats are saved in settings.
  - The vanilla JS event dispatcher pushes events to `window.dataLayer` without JavaScript errors or blocking form workflows.
- **External Dependencies (Blocked in Local Dev)**:
  - Transmission of hits to Google servers requires live, active GA4 Measurement IDs and GTM containers authorized on a public top-level domain.
  - No personal Google credentials or third-party ad accounts were bundled into this repository.

---

## 6. Privacy & Consent Considerations

Before launching to European Union or UK audiences:
- Implement a Consent Management Platform (CMP) such as Complianz, Cookiebot, or OneTrust.
- Enqueue Google tags in **Consent Mode v2** (`analytics_storage: 'denied'`, `ad_storage: 'denied'`) until explicit visitor opt-in is registered.
- Notice that IP addresses stored in `agency_enquiry` CPT are accessible only to authenticated site administrators and can be anonymized in `includes/class-enquiry-handler.php` if required by legal counsel.
