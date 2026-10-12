# Apex Digital — Legacy Campaign Component Module

This directory houses a self-contained, backward-compatible marketing landing page fixture for **Apex Digital**. Engineered to maintain ongoing support for legacy enterprise campaign assets built with **Sass**, **Gulp / Node build pipelines**, **Twig template rendering**, and **ZURB Foundation** without conflicting with the platform's primary Tailwind CSS v3 architecture.

---

## 🎯 Purpose & Scope

- **Fixture**: Reusable "Enterprise Performance & Conversion Audit" landing-page component.
- **Isolation**: Assets, styles, and templates are strictly contained within `legacy-maintenance-example/` and do not leak into or conflict with the main site's Tailwind CSS v3 architecture.

---

## 🛠️ Stack

- **Sass (Dart Sass 1.77+)**: Stylesheet compilation with modern `@use 'sass:math'` module syntax.
- **Foundation Sites (v6.8+)**: Responsive grid layout and global UI mixins.
- **Twig (v1.17+)**: Flexible, secure templating engine rendering structured JSON fixtures to static HTML.
- **Build Pipeline**: Gulp / Node.js automated compile workflow.

---

## 📦 Reproducible Build Instructions

To install dependencies and compile the fixture:

```bash
# From within this directory
npm install
npm run build
```

Or from the repository root:
```bash
npm --prefix legacy-maintenance-example run build
```

### Build Artifacts Produced:
- `dist/css/main.css`: Minified stylesheet compiled from Foundation-augmented SCSS.
- `dist/audit-component.html`: Fully rendered semantic HTML component merged with `src/data/audit-fixture.json`.

---

## 📝 Concrete Maintenance Retrospective & Technical Changes

During the modernization and stabilization of this legacy component, the following concrete improvements were executed:

1. **Migration of Deprecated Sass Division (`/`) to `sass:math`**:
   - *Problem*: Older Foundation/Sass implementations used the `/` operator for division, which emits deprecation warnings and breaks under modern Dart Sass compilers.
   - *Fix*: Refactored mathematical calculations to use the official `@use 'sass:math';` module and `math.div()` syntax, eliminating all compilation warnings.

2. **Decoupling Foundation XY Grid from Global State**:
   - *Problem*: Traditional Foundation builds polluted the global CSS namespace with universal reset classes (`.row`, `.column`), interfering with modern utility-first frameworks.
   - *Fix*: Encapsulated all Foundation grid behaviors inside scoped component wrappers (`.legacy-audit-wrapper`), ensuring 100% style isolation from Tailwind.

3. **Twig Fixture Data Validation & Auto-Escaping**:
   - *Problem*: Legacy template string interpolations posed XSS risks when receiving unvalidated marketing parameters.
   - *Fix*: Added strict JSON schema validation for `src/data/audit-fixture.json` and ensured Twig auto-escaping protects against payload injection while cleanly mapping metrics and diagnostic bullet lists.

