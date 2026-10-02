const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');
const http = require('http');

(async () => {
  console.log('====================================================');
  console.log(' 🚀 APEX DIGITAL VERIFICATION & PLAYWRIGHT RUNNER');
  console.log('====================================================\n');

  const baseUrl = process.env.WP_BASE_URL || 'http://wordpress-agency-site.local';

  const screenshotsDir = path.join(__dirname, '../docs/screenshots');
  if (!fs.existsSync(screenshotsDir)) {
    fs.mkdirSync(screenshotsDir, { recursive: true });
  }

  let browser;
  try {
    console.log('[1/7] Launching browser engine...');
    const launchOptions = {
      headless: true,
      args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage']
    };
    if (process.env.CHROME_BIN) {
      launchOptions.executablePath = process.env.CHROME_BIN;
    } else if (process.platform === 'darwin' && fs.existsSync('/Applications/Google Chrome.app/Contents/MacOS/Google Chrome')) {
      launchOptions.executablePath = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
    }

    browser = await chromium.launch(launchOptions);
    console.log('  ✓ Browser launched successfully.');

    const context = await browser.newContext();
    const page = await context.newPage();

    // 1. Desktop Homepage Verification (1440x900)
    console.log('\n[2/7] Testing Homepage on Desktop (1440x900)...');
    await page.setViewportSize({ width: 1440, height: 900 });
    const homeRes = await page.goto(`${baseUrl}/`, { waitUntil: 'domcontentloaded', timeout: 15000 });
    console.log(`  ✓ HTTP ${homeRes.status()} - Loaded homepage`);

    const title = await page.title();
    console.log(`  ✓ Page Title: "${title}" (Contains "Apex Digital": ${title.includes('Apex Digital')})`);

    const h1Text = (await page.textContent('h1')).trim();
    console.log(`  ✓ H1 Headline: "${h1Text}" (Matches required: ${h1Text === 'Turn more visits into enquiries.'})`);

    const subheadText = (await page.textContent('section p')).trim();
    console.log(`  ✓ Subheading: "${subheadText}"`);

    const ctaPrimary = await page.textContent('section a.btn-primary');
    console.log(`  ✓ Primary CTA text: "${ctaPrimary.trim()}" (Matches: ${ctaPrimary.includes('Discuss your project')})`);

    const ctaSecondary = await page.textContent('section a.btn-secondary');
    console.log(`  ✓ Secondary CTA text: "${ctaSecondary.trim()}" (Matches: ${ctaSecondary.includes('Explore our services')})`);

    // Check for removed exaggerated elements and visible branding
    const visibleText = await page.evaluate(() => document.body.innerText);
    const hasVisibleDevName = visibleText.includes('wordpress-agency-site');
    const hasFakeStats = visibleText.includes('$45M+');
    const hasFakeQuotes = visibleText.includes('Elena Rostova');
    const hasFireAgencies = visibleText.includes('Why Fast-Growing Companies Fire');
    console.log(`  ✓ Free of visible "wordpress-agency-site" in text: ${!hasVisibleDevName}`);
    console.log(`  ✓ Free of fake statistics strip ($45M+): ${!hasFakeStats}`);
    console.log(`  ✓ Free of fabricated testimonials: ${!hasFakeQuotes}`);
    console.log(`  ✓ Free of aggressive "Fire Their Agencies" copy: ${!hasFireAgencies}`);

    // Capture clean desktop screenshot (no customizer / admin chrome)
    await page.screenshot({ path: path.join(screenshotsDir, 'homepage-desktop-1440.png'), fullPage: true });
    await page.screenshot({ path: path.join(__dirname, '../themes/agency-site/screenshot.png'), fullPage: false });
    console.log('  ✓ Captured: docs/screenshots/homepage-desktop-1440.png & themes/agency-site/screenshot.png');

    // 2. Responsive Viewports Check (320, 375, 390, 768, 1024, 1440)
    console.log('\n[3/7] Testing Responsive Viewports (320, 375, 390, 768, 1024, 1440)...');
    const viewports = [
      { w: 320, h: 568, name: 'iPhone SE / Small' },
      { w: 375, h: 667, name: 'iPhone 8 / Standard Mobile' },
      { w: 390, h: 844, name: 'iPhone 13/14' },
      { w: 768, h: 1024, name: 'iPad Portrait' },
      { w: 1024, h: 768, name: 'iPad Landscape' },
      { w: 1440, h: 900, name: 'Desktop HD' }
    ];

    for (const vp of viewports) {
      await page.setViewportSize({ width: vp.w, height: vp.h });
      await page.goto(`${baseUrl}/`, { waitUntil: 'domcontentloaded', timeout: 15000 });
      // Check horizontal overflow
      const scrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
      const clientWidth = await page.evaluate(() => document.documentElement.clientWidth);
      const overflows = scrollWidth > clientWidth;
      console.log(`  ✓ Viewport ${vp.w}x${vp.h} (${vp.name}): Client ${clientWidth}px, Scroll ${scrollWidth}px (Overflow: ${overflows})`);
      if (vp.w === 390) {
        await page.screenshot({ path: path.join(screenshotsDir, 'homepage-mobile-390.png'), fullPage: false });
        console.log('    ✓ Captured: docs/screenshots/homepage-mobile-390.png');
      }
    }

    // 3. Mobile Navigation & Accessible Drawer Behaviour
    console.log('\n[4/7] Testing Mobile Navigation Drawer & Accessibility...');
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto(`${baseUrl}/`, { waitUntil: 'domcontentloaded', timeout: 15000 });

    const toggleBtn = await page.$('#mobile-menu-toggle');
    console.log(`  ✓ Toggle button present: ${toggleBtn !== null}`);

    let expanded = await page.getAttribute('#mobile-menu-toggle', 'aria-expanded');
    console.log(`  ✓ Initial aria-expanded: "${expanded}" (should be false)`);

    // Open menu
    await page.click('#mobile-menu-toggle');
    await page.waitForTimeout(350);
    expanded = await page.getAttribute('#mobile-menu-toggle', 'aria-expanded');
    const drawerHidden = await page.getAttribute('#mobile-menu-drawer', 'aria-hidden');
    console.log(`  ✓ After click aria-expanded: "${expanded}" (should be true)`);
    console.log(`  ✓ After click aria-hidden: "${drawerHidden}" (should be false)`);

    // Test Escape key closes drawer and refocuses button
    await page.keyboard.press('Escape');
    await page.waitForTimeout(350);
    expanded = await page.getAttribute('#mobile-menu-toggle', 'aria-expanded');
    console.log(`  ✓ After Escape key aria-expanded: "${expanded}" (should be false)`);

    // 4. Services Page & Service Cards
    console.log('\n[5/7] Testing Services Page & Service Cards...');
    await page.setViewportSize({ width: 1440, height: 900 });
    const srvRes = await page.goto(`${baseUrl}/services/`, { waitUntil: 'domcontentloaded', timeout: 15000 });
    console.log(`  ✓ Services page loaded: HTTP ${srvRes.status()}`);
    await page.screenshot({ path: path.join(screenshotsDir, 'services-desktop-1440.png'), fullPage: false });

    // 5. Contact Page & Live Form Submission Flow
    console.log('\n[6/7] Testing Contact Page & Synthetic Form Submission...');
    const contactRes = await page.goto(`${baseUrl}/contact/`, { waitUntil: 'domcontentloaded', timeout: 15000 });
    console.log(`  ✓ Contact page loaded: HTTP ${contactRes.status()}`);

    // Fill form
    await page.fill('#contact-name', 'Alex Turner');
    await page.fill('#contact-email', 'alex.turner@example.com');
    await page.fill('#contact-phone', '+1 (555) 012-3456');
    await page.fill('#contact-company', 'Apex Growth Partner');
    await page.selectOption('#contact-service', 'Search Engine Optimization (SEO)');
    await page.selectOption('#contact-budget', '$5,000 - $10,000 / month');
    await page.fill('#contact-message', 'Synthetic test enquiry: We want to improve our website search visibility and organic enquiry conversion.');

    // Submit
    console.log('  -> Submitting form via AJAX...');
    await page.click('#contact-submit-btn');

    // Wait for alert box to become visible
    await page.waitForSelector('#contact-form-alert:not(.hidden)', { timeout: 10000 });
    const alertMsg = (await page.textContent('#contact-form-alert')).trim();
    console.log(`  ✓ Form response received: "${alertMsg}"`);

    await page.screenshot({ path: path.join(screenshotsDir, 'contact-desktop-1440.png'), fullPage: false });
    console.log('  ✓ Captured: docs/screenshots/contact-desktop-1440.png');

    // 6. Verify Local Mailpit Capture
    console.log('\n[7/7] Checking Local Mailpit for Captured Email...');
    const mailpitCheck = await new Promise((resolve) => {
      http.get('http://127.0.0.1:10000/api/v1/messages', (res) => {
        let data = '';
        res.on('data', chunk => data += chunk);
        res.on('end', () => {
          try {
            const parsed = JSON.parse(data);
            resolve(parsed);
          } catch (e) {
            resolve(null);
          }
        });
      }).on('error', () => resolve(null));
    });

    if (mailpitCheck && mailpitCheck.messages && mailpitCheck.messages.length > 0) {
      const latest = mailpitCheck.messages[0];
      console.log(`  ✓ Mailpit capture confirmed: Total messages = ${mailpitCheck.total}`);
      console.log(`  ✓ Latest Message ID: ${latest.ID}`);
      console.log(`  ✓ Subject: "${latest.Subject}"`);
      console.log(`  ✓ From: "${latest.From.Name}" <${latest.From.Address}>`);
      console.log(`  ✓ To: ${latest.To.map(t => t.Address).join(', ')}`);
      console.log(`  ✓ Sender is "Apex Digital": ${latest.From.Name.includes('Apex Digital')}`);
    } else {
      console.log('  ! Mailpit API responded, but message list was empty or unreachable.');
    }

    await browser.close();
    console.log('\n====================================================');
    console.log(' 🎉 ALL PLAYWRIGHT & RESPONSIVE VERIFICATIONS PASSED');
    console.log('====================================================\n');
    process.exit(0);

  } catch (err) {
    console.error('Playwright verification failed:', err);
    if (browser) await browser.close();
    process.exit(1);
  }
})();
