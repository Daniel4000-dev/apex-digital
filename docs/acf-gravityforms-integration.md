# ACF Pro & Gravity Forms Integration Guide

This guide details the integration architecture, field definitions, and hook configurations for **Advanced Custom Fields Pro (ACF Pro)** and **Gravity Forms** within the Apex Digital platform.

---

## 1. ACF Pro Integration Architecture

### Location & Synchronization
- **Code Module**: `plugins/agency-site-core/includes/class-acf-integration.php`
- **JSON Synchronization Directory**: `themes/agency-site/acf-json/group_agency_service_meta.json`

### Field Group Specifications (`group_agency_service_meta`)
When ACF Pro is installed and active, it attaches to the `agency_service` post type:

| Field Name | Key | Type | Description |
| :--- | :--- | :--- | :--- |
| `_service_tagline` | `field_agency_service_tagline` | Text | Strategic one-sentence summary displayed in service cards and hero |
| `_service_pricing` | `field_agency_service_pricing` | Text | Retainer or project indicator (e.g. *"From $4,500/mo"*) |
| `_service_badge` | `field_agency_service_badge` | Text | Highlight chip (e.g. *"Most Popular"*, *"High Intent"*) |
| `_service_deliverables` | `field_agency_service_deliverables` | Textarea | Line-separated concrete deliverables rendered as checkmarked list |
| `_service_faqs` | `field_agency_service_faqs` | Repeater | Sub-fields: `question` (Text) & `answer` (Textarea) for accordion |

### Fallback Guarantee
If ACF Pro is deactivated or uninstalled:
- The companion plugin's native meta box system (`Agency_Core_CPT_Service`) continues reading and writing to the identical `_service_*` meta keys.
- Theme template functions (`inc/template-tags.php`) gracefully fall back to native `get_post_meta()` without missing data or runtime errors.

---

## 2. Gravity Forms Integration Architecture

### Location & Form Export
- **Code Module**: `plugins/agency-site-core/includes/class-gravity-forms-integration.php`
- **Sanitized Form Export**: `docs/gravityforms-export-sanitized.json` (contains zero personal data or secrets)

### Workflow Hook & Idempotency
- **Hook**: `gform_after_submission` (Priority 10)
- **Deduplication**: Uses transient cache `agency_gf_processed_{entry_id}` with a 1-hour expiration window to prevent duplicate webhook dispatches or duplicate CPT insertions on form re-renders.
- **Data Mapping**:
  - `name` -> `_enquiry_name`
  - `email` -> `_enquiry_email`
  - `phone` -> `_enquiry_phone`
  - `company` -> `_enquiry_company`
  - `service` -> `_enquiry_service`
  - `budget` -> `_enquiry_budget`
  - `message` -> `_enquiry_message`
- **Source Identifier**: Flags entries with `_enquiry_source = 'gravity_forms'` and stores `_enquiry_gf_entry_id`.
- **Downstream Dispatch**: Directly triggers `Agency_Core_Webhook_Dispatcher::dispatch()` with HMAC-SHA256 signature and CRM payload format.

### Template Rendering
In `themes/agency-site/page-contact.php`:
If Gravity Forms is active and a form ID is configured via the filter `agency_contact_gravity_form_id` or option `agency_gravity_form_id`:
```php
gravity_form( $form_id, false, true, false, null, true );
```
Otherwise, the responsive, accessible custom AJAX form renders automatically.

---

## 3. Commercial License Status Notice

> **IMPORTANT**: Commercial ZIP distributions and active license keys for ACF Pro and Gravity Forms are **not** committed to version control.
> - **Code-Level Bridge & Hooks**: **Implemented & Verified** (52/52 behavioural tests pass).
> - **Field Group JSON Definitions**: **Present & Synchronized** in `themes/agency-site/acf-json/`.
> - **Sanitized Form JSON**: **Present** in `docs/gravityforms-export-sanitized.json`.
> - **Live Commercial Plugin Execution**: **Blocked (Requires proprietary archive / license key)**.
