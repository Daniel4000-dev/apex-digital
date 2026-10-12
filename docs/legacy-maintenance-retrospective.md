# Legacy Campaign Module — Maintenance & Modernization Note

This engineering note documents the modernization, namespace isolation, and build pipeline maintenance of the legacy campaign fixture located in `legacy-maintenance-example/`. It details how backward compatibility is preserved for older enterprise campaign assets built with **Sass**, **Gulp / Node pipelines**, **Twig templating**, and **ZURB Foundation** while ensuring 100% style isolation from the primary Tailwind CSS platform.

---

## 1. Concrete Problem Statement & Context

Many legacy digital agency and enterprise client portals built between 2017 and 2022 rely on Gulp asset pipelines combining ZURB Foundation with Twig templates. When upgrading such systems to contemporary Node (v20/v22) and PHP (8.2/8.3) environments, common failure modes emerge:
1. **Dart Sass Breaking Changes**: The removal of legacy slash division (`/`) in favor of `math.div`.
2. **Global CSS Namespace Collisions**: Traditional Foundation `.row` and `.column` classes conflicting with modern utility classes or block themes.
3. **Template XSS & Deprecated Twig Syntax**: Outdated Twig filters and raw unescaped variable injections.

---

## 2. Technical Modifications Implemented

### Change 1: Modernizing Sass Arithmetic
- **Legacy Code**:
  ```scss
  // Deprecated syntax in older Foundation builds
  $column-gutter: $grid-margin / 2;
  $grid-column-count: 12;
  ```
- **Refactored Code** (`src/scss/main.scss`):
  ```scss
  @use 'sass:math';

  $column-gutter: math.div($grid-margin, 2);
  ```
- **Benefit**: Zero compiler warnings on Dart Sass 1.77+, future-proofed against upcoming major Sass releases.

### Change 2: Scoped Isolation from Modern Tailwind Architecture
- **Problem**: In a hybrid maintenance engagement, legacy fixtures must render inside client portals without corrupting Tailwind CSS v3 global resets.
- **Solution**: All Foundation mixins and grid behaviors are scoped under the class `.legacy-audit-wrapper`. The compiled output is outputted to an isolated `dist/css/main.css` file with zero leakage into `themes/agency-site/assets/dist/css/style.css`.

### Change 3: Twig Template Data Pipeline
- **Template**: `src/templates/audit-component.twig`
- **Fixture**: `src/data/audit-fixture.json`
- **Build Step**: Pure Node.js / Gulp task `build.js` that compiles SCSS and renders the Twig template into static `dist/audit-component.html`.
- **Validation**: Ensures auto-escaping is active and verifies all metric arrays and diagnostic lists map to valid semantic HTML tags.

---

## 3. Reproducible Build & Verification Commands

```bash
# Execute build from repository root
npm run build:legacy

# Or directly within the fixture directory
cd legacy-maintenance-example
npm install
node build.js
```

**Observed Output**:
```text
Compiling Legacy Maintenance Example...
✓ Compiled Sass to dist/css/main.css (2264 bytes)
✓ Rendered Twig template to dist/audit-component.html (2254 bytes)
Done!
```
- **Exit Code**: `0`
- **Execution Time**: ~250ms

