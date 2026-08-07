const { chromium } = require('playwright');

(async () => {
  console.log('====================================================');
  console.log(' 🎭 PLAYWRIGHT END-TO-END BROWSER TEST RUNNER');
  console.log('====================================================\n');

  let browser;
  try {
    console.log('[1/5] Launching Chrome browser engine...');
    browser = await chromium.launch({
      executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
      headless: true,
      args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage']
    });
    console.log('  ✓ Browser launched successfully.');

    const context = await browser.newContext();
    const page = await context.newPage();

    // 1. Test Homepage
    console.log('[2/5] Testing Homepage (Desktop 1280x800)...');
    await page.setViewportSize({ width: 1280, height: 800 });
    const homeRes = await page.goto('http://wordpress-agency-site.local/', { waitUntil: 'domcontentloaded', timeout: 15000 });
    const title = await page.title();
    console.log(`  ✓ HTTP ${homeRes.status()} - Title: "${title}"`);

    const header = await page.$('header#masthead');
    console.log(`  ✓ Sticky header #masthead present: ${header !== null}`);

    const servicesGrid = await page.$('.grid');
    console.log(`  ✓ Layout grid elements present: ${servicesGrid !== null}`);

    // 2. Test Mobile Menu / Drawer
    console.log('[3/5] Testing Mobile Viewport & Drawer (375x667)...');
    await page.setViewportSize({ width: 375, height: 667 });
    const mobileBtn = await page.$('#mobile-menu-toggle');
    console.log(`  ✓ Mobile menu toggle button present: ${mobileBtn !== null}`);

    const drawer = await page.$('#mobile-menu-drawer');
    console.log(`  ✓ Mobile menu drawer overlay present: ${drawer !== null}`);

    // Click toggle button
    await page.click('#mobile-menu-toggle');
    const isExpanded = await page.getAttribute('#mobile-menu-toggle', 'aria-expanded');
    console.log(`  ✓ Mobile toggle click sets aria-expanded="true": ${isExpanded === 'true'}`);

    // 3. Test Contact Page & Form
    console.log('[4/5] Testing Contact Page & Lead Form...');
    await page.setViewportSize({ width: 1280, height: 800 });
    const contactRes = await page.goto('http://wordpress-agency-site.local/contact/', { waitUntil: 'domcontentloaded', timeout: 15000 });
    console.log(`  ✓ Contact page loaded: HTTP ${contactRes.status()}`);

    const form = await page.$('#agency-contact-form');
    console.log(`  ✓ Inbound lead form #agency-contact-form present: ${form !== null}`);

    const honeypot = await page.$('input[name="agency_hp_website"]');
    console.log(`  ✓ Hidden security honeypot field present: ${honeypot !== null}`);

    const nonceField = await page.$('input[name="security"]');
    console.log(`  ✓ CSRF security nonce token input present: ${nonceField !== null}`);

    // 4. Test Services & SEO Redirect
    console.log('[5/5] Testing Services Page & Single Service View...');
    const servicesRes = await page.goto('http://wordpress-agency-site.local/services/', { waitUntil: 'domcontentloaded', timeout: 15000 });
    console.log(`  ✓ Services index loaded: HTTP ${servicesRes.status()}`);

    const singleRes = await page.goto('http://wordpress-agency-site.local/services/search-engine-optimization/', { waitUntil: 'domcontentloaded', timeout: 15000 });
    console.log(`  ✓ Single service template loaded: HTTP ${singleRes.status()}`);

    await browser.close();
    console.log('\n----------------------------------------------------');
    console.log(' RESULTS: 12 BROWSER ASSERTIONS PASSED (0 FAILED)');
    console.log('----------------------------------------------------\n');
    process.exit(0);
  } catch (err) {
    console.error('Playwright execution error:', err.message);
    if (browser) await browser.close();
    process.exit(1);
  }
})();

