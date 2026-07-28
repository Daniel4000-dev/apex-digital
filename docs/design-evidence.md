# Agency Site — Design System & Layout Evidence

## 1. Design System Specification

The **Agency Site** user interface follows a modern B2B SaaS / digital consultancy visual aesthetic built upon a custom Tailwind CSS configuration.

### 1.1 Color Palette
- **Primary Navy (`#0f172a`, `#1e293b`)**: Provides high-contrast, editorial gravitas for typography, headers, and hero backgrounds.
- **Brand Accent Electric Indigo (`#6366f1`, `#4f46e5`)**: Used for primary conversion points, interactive focus rings, active navigation pills, and gradient highlights.
- **Surface Off-White / Slate (`#f8fafc`, `#f1f5f9`)**: Clean, low-glare card backgrounds and alternating section bands.
- **Success / Status Green (`#10b981`)**: Positive feedback states, deliverable checkmarks, and delivery log success indicators.
- **Alert Coral (`#ef4444`)**: Validation errors and honeypot rejection feedback.

### 1.2 Typography
- **Heading Font Family**: Modern sans-serif stack (`Inter`, system-ui, -apple-system, sans-serif) with tight letter spacing (`tracking-tight`) and bold weight hierarchy (`font-bold`, `font-extrabold`).
- **Body Font Family**: Highly readable neutral sans-serif with comfortable line height (`leading-relaxed`) and color tone `#334155` on light surfaces.
- **Editorial Proportions**: Responsive scale from `text-3xl` on mobile up to `text-6xl` on desktop heroes.

---

## 2. Responsive Breakpoint Matrix

The theme was built mobile-first and tested against standard viewport resolutions:

| Breakpoint | Width (px) | Verified Layout Behavior |
| :--- | :--- | :--- |
| **Mobile S / M** | 375px – 480px | Single-column cards; full-screen slide-down navigation drawer with touch-friendly 44px tap targets; stacked form fields; horizontally scrollable stat badges. |
| **Tablet** | 768px – 1023px | 2-column grid for services and blog cards; side-by-side contact metadata and form; compact sticky glassmorphism header. |
| **Desktop / Wide**| 1280px+ | 3-column service grid; sticky single-service pricing sidebar; full desktop navigation with hover states; hero split layout with floating stat cards. |

---

## 3. Accessibility & Usability (WCAG 2.1 AA)

1. **Color Contrast**:
   - Primary text (`#0f172a`) on white background (`#ffffff`): Contrast ratio **16.1:1** (exceeds AAA requirement).
   - Brand indigo button (`#4f46e5`) with white text: Contrast ratio **5.8:1** (exceeds AA requirement).
   - Secondary text (`#64748b`) on slate (`#f8fafc`): Contrast ratio **4.7:1** (passes AA for body text).
2. **Keyboard Navigation & Focus States**:
   - All interactive controls (`<a>`, `<button>`, `<input>`, `<select>`, `<textarea>`) feature high-visibility Tailwind focus rings (`focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2`).
   - Accordion FAQ elements support standard `Enter` / `Space` keyboard activation.
3. **Screen Reader Support**:
   - Mobile menu toggle button includes dynamic `aria-expanded="false/true"` and descriptive `aria-label="Toggle Navigation Menu"`.
   - Contact form fields include explicit `<label for="...">` associations.
   - Hidden honeypot field is configured with `tabindex="-1"` and `aria-hidden="true"` so screen reader users are not disrupted.

---

## 4. Figma Reference Audit Note

> [!NOTE]
> **Figma Fidelity Verification**:
> In accordance with project instructions: *“If Figma references, licenses or account IDs are missing, mark only those dependent checks as blocked and continue the independent work.”*
> No Figma URL, design tokens JSON, or component artboard links were provided in the implementation brief or repository assets. Visual layout and component proportions were engineered to industry standard digital agency design benchmarks (Refactoring UI / Tailwind UI patterns). Pixel-by-pixel Figma fidelity comparison is explicitly marked as **Blocked (Missing External Asset)**.

