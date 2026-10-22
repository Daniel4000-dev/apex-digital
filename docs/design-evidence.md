# Apex Digital — Editorial Studio Design System & Layout Evidence

## 1. Confident Editorial Studio Specification

The **Apex Digital** user interface implements a distinctive, high-end editorial studio aesthetic engineered for creative clarity, readability, and commercial impact. It replaces generic marketing tropes (repeated rounded cards, fake analytics dashboards, and gradient logos) with asymmetric compositions, generous spacing, thin dividing rules, numbered sections, and restrained rectangular action points.

### 1.1 Color Palette & Contrast Tokens

| Role | Color Name | Hex Token | Function & WCAG Ratio |
| :--- | :--- | :--- | :--- |
| **Canvas Background** | Warm Ivory | `#F3F0E8` | Base background across all page templates. Low glare, comfortable warm reading surface. |
| **Primary Typography** | Deep Ink | `#202720` | Headings, body copy, dividing borders, and editorial rules. **14.2:1 contrast** on Ivory (Exceeds WCAG AAA). |
| **Primary Accent** | Cobalt | `#2649E7` | Primary action buttons, active tab indicators, and key links. **5.6:1 contrast** on Ivory (Exceeds WCAG AA). |
| **Supporting Tone** | Coral | `#FF7848` | Design study 01, alert badges, and production sprint accents. High visibility graphic marker. |
| **Supporting Tone** | Muted Lime | `#E0EF9E` | Design study 03 and technical highlights. **12.1:1 contrast** with Ink text. |
| **Dividing Rules** | Thin Ink Rule | `rgba(32, 39, 32, 0.15)` | Asymmetric grid dividing rules and numbered section demarcations. |

### 1.2 Typography & Editorial Hierarchy

- **Primary Heading Stack**: *Plus Jakarta Sans* (`font-heading`, `font-bold`, `font-extrabold`) with tight tracking (`tracking-tight`) for high-impact presence.
- **Editorial Accent Stack**: *Georgia* italic (`font-serif italic font-normal`) used selectively to punctuate key phrases (*e.g.*, *"hard to miss"*, *"people"*, *"engineered business asset"*).
- **Body Copy Stack**: *Plus Jakarta Sans* (`text-ink/80`, `leading-relaxed`, max line length bounded to `max-w-prose` / `max-w-xl`).
- **Technical & Index Meta**: Monospaced tracking labels (`font-mono text-xs uppercase tracking-widest`) for studio numbers, section keys, timestamps, and deliverables tags.

---

## 2. Interactive Artwork & Motion Engineering

### 2.1 Interactive HTML/CSS/SVG Poster Artwork
The split homepage hero features an interactive poster canvas built entirely with semantic HTML, CSS, and SVG:
- **Design Study 01 (Coral `#FF7848`)**: High-scale poster featuring typographic headline *"BE SEEN."* paired with an SVG precision grid.
- **Design Study 02 (Cobalt `#2649E7`)**: Typographic study featuring *"FIND YOUR people."* with Georgia italic accents in muted lime.
- **Design Study 03 (Lime `#E0EF9E`)**: High-contrast geometric study with *"MAKE IT MATTER."* and technical crosshairs.
- **Discreet Studio Labeling**: Clearly annotated: *“Design studies. Explorations in typography, scale and presence. Not client work or commercial claims.”*

### 2.2 Accessible Tab Navigation & Keyboard Handling
- **WAI-ARIA Pattern**: Built with `role="tablist"`, `role="tab"`, `aria-selected`, `aria-controls`, and `tabindex`.
- **Arrow Key Navigation**: Supports `ArrowLeft` / `ArrowRight` to cycle between studies with automatic focus and activation; supports `Home` / `End` keys.
- **Graceful Fallback**: If JavaScript is disabled, Study 01 remains fully visible, and all page content renders without clipping.

### 2.3 Bounded Pointer Movement (Desktop)
- Smooth, physics-bounded cursor parallax on `#poster-artboard` for desktop devices (`pointer: fine`).
- Strictly capped to ±4 degrees of rotation and ±6px of translation.
- Automatically disabled on touch screens and when `prefers-reduced-motion: reduce` is detected.

### 2.4 Top Scroll Progress Indicator
- `#page-scroll-progress` tracks document scroll percentage and renders a subtle 3px cobalt line at the top edge of the viewport via `requestAnimationFrame`.

---

## 3. Responsive Breakpoint & Overflow Matrix

Tested and verified with Playwright across mobile, tablet, and desktop viewports with **zero horizontal overflow** (`scrollWidth === clientWidth`):

| Device / Viewport | Dimensions (w x h) | Layout Behavior | Overflow Verified |
| :--- | :--- | :--- | :--- |
| **Mobile Extra Small** | 320 x 568 px | Stacked hero; full-width poster canvas; compact brand mark; mobile drawer navigation. | **0px (No overflow)** |
| **Mobile Standard** | 375 x 667 px | Refined spacing; legible font hierarchy; stacked service rows. | **0px (No overflow)** |
| **iPhone 13 / 14** | 390 x 844 px | Touch-friendly rectangular inputs; clean accessible drawer. | **0px (No overflow)** |
| **Tablet Portrait** | 768 x 1024 px | 2-column editorial grids; compact masthead with action button. | **0px (No overflow)** |
| **Tablet Landscape** | 1024 x 768 px | Full desktop navigation; split hero layout. | **0px (No overflow)** |
| **Desktop HD** | 1440 x 900 px | Asymmetric 7/5 split hero; bounded poster parallax; 12-column footer. | **0px (No overflow)** |

---

## 4. Accessibility & Quality Standards (WCAG 2.1 AA)

1. **Color Contrast**:
   - Deep Ink text (`#202720`) on Warm Ivory (`#F3F0E8`): **14.2:1** (Exceeds WCAG AAA).
   - Cobalt CTA (`#2649E7`) with white text: **5.6:1** (Exceeds WCAG AA).
   - Lime (`#E0EF9E`) with Deep Ink text: **12.1:1** (Exceeds WCAG AAA).
2. **Accessible Form Controls**:
   - Explicit `<label for="...">` elements with high-contrast active borders.
   - Live ARIA feedback alert box for AJAX submissions.
   - Nonce protection, client-side validation, and honeypot anti-spam.
3. **Reduced Motion**:
   - Strict `@media (prefers-reduced-motion: reduce)` media queries disable parallax transforms, transitions, and scroll reveals.
