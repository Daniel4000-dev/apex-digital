# Agency Site - WordPress Theme

A modern, high-performance, polished classic WordPress theme built for fictional and real digital marketing agencies, growth consultancies, and creative studios. Engineered with **PHP**, **Tailwind CSS**, and **vanilla JavaScript**.

---

## 🚀 Key Features

- **Polished, Responsive Homepage (`front-page.php`)**:
  - High-converting hero with customizable headline, subhead, badges, and dual CTA buttons.
  - Interactive multi-channel acquisition dashboard graphic with live proof badges.
  - Social proof client logo strip.
  - Impact metrics counter (4 key stats editable via the WordPress Customizer).
  - Dynamic Core Services grid (pulls from Services CPT or provides rich default offerings).
  - "Why Partner With Us" comparison table and value pillars.
  - Client testimonial review cards with 5-star ratings.
  - Latest blog and growth teardowns grid.
- **Service Landing Page (`template-services.php` & `single-agency_service.php`)**:
  - Full-width hero with value badges and deliverable guarantees.
  - In-depth service breakdown with deliverables checklist and pricing indicators.
  - 4-Stage Growth Architecture framework (Discovery, Strategy, Sprints, Scale).
  - Interactive vanilla JavaScript FAQ accordion.
- **Blog Listing & Single Article Templates (`home.php` & `single.php`)**:
  - Category filter pills.
  - Featured article highlight on page 1.
  - Responsive post cards with reading time estimate, publication date, author avatar, and excerpts.
  - Accessible pagination (`agency_site_pagination`).
  - Search widget and newsletter callout card in sidebar.
  - Single post layout with typography, tags, author bio box, previous/next article navigation, social share buttons, and copy-link toast.
- **Contact Page (`page-contact.php`)**:
  - Strategic consultation booking form.
  - Supports URL pre-selection (e.g. `?service=SEO`).
  - Full AJAX submission with instant animated success/error alert.
  - Server-side email notification via `wp_mail()` with nonce security.
  - Direct contact cards (email, phone, address, business hours) and 3-step timeline.
- **Header & Navigation (`header.php`)**:
  - Top announcement banner.
  - Sticky header with glassmorphism backdrop blur on scroll.
  - Responsive desktop menu with fallback.
  - Accessible mobile hamburger drawer with ARIA controls, Escape-key dismiss, and click-outside close.
- **Custom Post Type (`inc/cpt-services.php`)**:
  - Registers `agency_service` with custom meta boxes for subtitle, pricing indicator, highlight badge, icon style, and bulleted deliverables.
- **WordPress Customizer (`inc/customizer.php`)**:
  - Edit hero copy, stats counters, header CTAs, contact information, and social links directly in `Appearance > Customize > Agency Site Settings`.

---

## 🛠️ Build Configuration & Asset Compilation

The theme uses **Tailwind CSS** with `@tailwindcss/typography` and **Autoprefixer**.

### Prerequisites
- **Node.js**: v18+ (tested on Node v20)
- **npm**: v9+ (tested on npm 10.8)

### Installation
Dependencies are already installed in `themes/agency-site/`. If installing fresh:

```bash
cd wp-content/themes/agency-site
npm install
```

### Compile Stylesheet
To compile and minify the production stylesheet into `assets/dist/css/style.css`:

```bash
npm run build:css
```

### Watch Mode for Development
To watch for template changes and recompile automatically:

```bash
npm run watch:css
```

---

## ⚙️ How to Activate and Set Up the Theme in WordPress

### Step 1: Activate the Theme
1. Open your WordPress admin dashboard (e.g. `http://wordpress-agency-site.local/wp-admin/`).
2. Navigate to **Appearance > Themes**.
3. Locate **Agency Site** and click **Activate**.

### Step 2: Configure Homepage and Blog Pages
1. Go to **Pages > Add New Page**:
   - Create a page titled **Home** (or leave empty; the theme will use `front-page.php` automatically for the front page).
   - Create a page titled **Services** and in the right sidebar under **Page Attributes > Template**, select **Service Landing Page**.
   - Create a page titled **Blog & Insights**.
   - Create a page titled **Contact** and select **Contact Page** under **Page Attributes > Template**.
2. Go to **Settings > Reading**:
   - Set **Your homepage displays** to **A static page**.
   - Select **Homepage**: **Home**.
   - Select **Posts page**: **Blog & Insights**.
   - Click **Save Changes**.

### Step 3: Set Up Navigation Menus
1. Go to **Appearance > Menus**.
2. Create a new menu titled **Primary Menu**.
3. Add your pages (**Home**, **Services**, **Blog & Insights**, **Contact**).
4. Under **Menu Settings > Display location**, check **Primary Navigation**.
5. Click **Save Menu**.

### Step 4: Customize Copy & Branding
1. Go to **Appearance > Customize > Agency Site Settings**:
   - **Homepage Hero**: Customize the headline, subhead, badge, and primary/secondary button links.
   - **Key Statistics**: Update revenue metrics, average ROI, retention rate, and campaign numbers.
   - **Header & Navigation**: Set custom button text and destination URL.
   - **Contact Information**: Set agency phone, email, physical address, and operating hours.
   - **Social Media Profiles**: Link your Twitter/X, LinkedIn, Instagram, and GitHub profiles.
2. Click **Publish**.

### Step 5: Add Agency Services (Optional)
The theme comes with rich built-in fallback services out of the box. To add custom services:
1. In the WordPress sidebar, click **Services > Add New Service**.
2. Enter the service title (e.g. *Enterprise SEO Strategy*).
3. Add the description in the block or classic editor.
4. Fill in the **Service Details & Specifications** meta box:
   - **Subtitle / Tagline**
   - **Pricing Indicator** (e.g. *From $3,500 / month*)
   - **Highlight Badge** (e.g. *Most Popular*)
   - **Icon Style** (Chart, Megaphone, Target/Click, Lightning, Content, Code)
   - **Key Deliverables** (one item per line)
5. Set a **Featured Image** (optional) and click **Publish**.

---

## 📁 File Structure

```text
themes/agency-site/
├── 404.php                     # 404 error template with search
├── archive.php                 # Category, tag, and date archive template
├── archive-agency_service.php  # Archive template for /services/
├── comments.php                # Accessible comments list and form
├── footer.php                  # Pre-footer CTA, multi-column footer & copyright
├── front-page.php              # Polished responsive agency homepage
├── functions.php               # Theme setup, assets enqueue, AJAX handlers & menu walkers
├── header.php                  # Announcement bar, sticky header & mobile drawer
├── home.php                    # Blog listing template with featured post & sidebar
├── index.php                   # Universal fallback template
├── package.json                # npm scripts and devDependencies
├── page.php                    # Standard page template
├── page-contact.php            # Contact page template with AJAX form
├── postcss.config.js           # PostCSS Tailwind and Autoprefixer config
├── README.md                   # Setup documentation
├── screenshot.png              # Theme preview image for WP dashboard
├── search.php                  # Search results template
├── single.php                  # Individual blog article template
├── single-agency_service.php   # Individual service detail template
├── style.css                   # Theme header descriptor & core WP styles
├── tailwind.config.js          # Tailwind theme colors, fonts, and content paths
├── template-services.php       # Service landing page template
├── assets/
│   ├── dist/
│   │   ├── css/style.css       # Compiled, minified Tailwind stylesheet
│   │   └── js/main.js          # Vanilla JavaScript bundle
│   └── src/
│       ├── css/input.css       # Tailwind base, components & utilities
│       └── js/main.js          # Vanilla JS source
└── inc/
    ├── cpt-services.php        # Custom Post Type & custom meta boxes
    ├── customizer.php          # WordPress Theme Customizer options
    └── template-tags.php       # SVG icons, reading time & pagination helpers
```

---

## 🛡️ Best Practices & Quality Standards
- **Pure Native WordPress API**: Uses `wp_enqueue_scripts`, `wp_localize_script`, `add_theme_support`, `wp_nav_menu`, `get_theme_mod`, and `WP_Query`.
- **Zero WordPress Core Modifications**: Fully encapsulated inside `wp-content/themes/agency-site/`.
- **Clean Vanilla JavaScript**: Zero jQuery dependencies, accessible keyboard navigation, focus trap handling, and smooth UX states.
- **Security**: All forms, AJAX actions, and Customizer inputs use strict nonces, `sanitize_text_field`, `sanitize_email`, `sanitize_textarea_field`, and output escaping (`esc_html`, `esc_url`, `esc_attr`).

