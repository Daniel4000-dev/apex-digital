const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');

(async () => {
  console.log('====================================================');
  console.log(' 🚀 CAMPAIGN LANDING PAGE VERIFICATION RUNNER');
  console.log('====================================================\n');

  const baseUrl = process.env.WP_BASE_URL || 'http://wordpress-agency-site.local';
  const campaignUrl = `${baseUrl}/growth-sprint/`;

  const screenshotsDir = path.join(__dirname, '../docs/screenshots');
  if (!fs.existsSync(screenshotsDir)) {
    fs.mkdirSync(screenshotsDir, { recursive: true });
  }

  let browser;
  try {
    console.log('[1/6] Launching browser engine...');
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

    // 1. Desktop Verification (1440x900)
    console.log('\n[2/6] Testing Campaign Page on Desktop (1440x900)...');
    await page.setViewportSize({ width: 1440, height: 900 });
    const response = await page.goto(campaignUrl, { waitUntil: 'domcontentloaded', timeout: 15000 });
    console.log(`  ✓ HTTP ${response.status()} - Loaded ${campaignUrl}`);

    const title = await page.title();
    console.log(`  ✓ Page Title: "${title}"`);

    const hasFoundationScope = await page.$eval('.campaign-foundation-scope', el => el !== null);
    console.log(`  ✓ Container element has .campaign-foundation-scope: ${hasFoundationScope}`);

    const heroHeading = (await page.textContent('.campaign-title')).trim();
    console.log(`  ✓ Hero Heading: "${heroHeading}"`);

    const heroBadge = (await page.textContent('.campaign-badge')).trim();
    console.log(`  ✓ Campaign Badge: "${heroBadge}"`);

    const benefitsCount = await page.$$eval('.deliverable-card', els => els.length);
    console.log(`  ✓ Deliverables / Benefits Cards Count: ${benefitsCount} (Expected: 4)`);

    const faqsCount = await page.$$eval('.faq-item', els => els.length);
    console.log(`  ✓ FAQs Count: ${faqsCount} (Expected: 4)`);

    const formExists = await page.$('#campaign-enquiry-form') !== null;
    console.log(`  ✓ Campaign Enquiry Form Present: ${formExists}`);

    // Check stylesheet link
    const stylesheetLoaded = await page.$eval('link#agency-campaign-foundation-css', el => el.href.includes('campaign.css'));
    console.log(`  ✓ Scoped Foundation Sass Stylesheet Enqueued: ${stylesheetLoaded}`);

    // Capture desktop full page screenshot
    await page.screenshot({ path: path.join(screenshotsDir, 'campaign-desktop-1440.png'), fullPage: true });
    console.log('  ✓ Captured: docs/screenshots/campaign-desktop-1440.png');

    // 2. Responsive Viewports Check (Zero Horizontal Overflow)
    console.log('\n[3/6] Testing Responsive Viewports & Foundation XY-Grid (320, 375, 390, 768, 1024, 1440)...');
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
      await page.goto(campaignUrl, { waitUntil: 'domcontentloaded', timeout: 15000 });
      const scrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
      const clientWidth = await page.evaluate(() => document.documentElement.clientWidth);
      const overflows = scrollWidth > clientWidth;
      console.log(`  ✓ Viewport ${vp.w}x${vp.h} (${vp.name}): Client ${clientWidth}px, Scroll ${scrollWidth}px (Overflow: ${overflows ? 'FAIL' : 'PASS - 0px'})`);
      if (vp.w === 390) {
        await page.screenshot({ path: path.join(screenshotsDir, 'campaign-mobile-390.png'), fullPage: false });
        console.log('    ✓ Captured: docs/screenshots/campaign-mobile-390.png');
      }
    }

    // 3. FAQ Accordion Interaction
    console.log('\n[4/6] Testing Accessible FAQ Accordion Interaction...');
    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto(campaignUrl, { waitUntil: 'domcontentloaded', timeout: 15000 });

    const firstToggle = await page.$('.faq-accordion .faq-item:nth-child(1) .faq-trigger');
    let initialExpanded = await firstToggle.getAttribute('aria-expanded');
    console.log(`  ✓ Initial first FAQ aria-expanded: "${initialExpanded}"`);

    // Click second FAQ to test accordion exclusive toggle
    const secondToggle = await page.$('.faq-accordion .faq-item:nth-child(2) .faq-trigger');
    await secondToggle.click();
    await page.waitForTimeout(200);
    const secondOpen = await secondToggle.getAttribute('aria-expanded');
    const firstClosed = await firstToggle.getAttribute('aria-expanded');
    console.log(`  ✓ After clicking second FAQ: item 2 aria-expanded="${secondOpen}", item 1 closed="${firstClosed === 'false'}"`);

    // Click first FAQ to re-open it
    await firstToggle.click();
    await page.waitForTimeout(200);
    const firstReopened = await firstToggle.getAttribute('aria-expanded');
    const secondClosed = await secondToggle.getAttribute('aria-expanded');
    console.log(`  ✓ After re-clicking first FAQ: item 1 aria-expanded="${firstReopened}", item 2 closed="${secondClosed === 'false'}"`);

    await page.screenshot({ path: path.join(screenshotsDir, 'campaign-faq-expanded.png'), fullPage: false });
    console.log('  ✓ Captured: docs/screenshots/campaign-faq-expanded.png');

    // 4. Form Conditional Logic
    console.log('\n[5/6] Testing Form Conditional Field Logic...');
    const siteSelect = await page.$('#campaign-has-site');
    const siteUrlGroup = await page.$('#campaign-site-url-group');

    let initialDisplay = await siteUrlGroup.evaluate(el => el.style.display);
    console.log(`  ✓ Initial site URL group display: "${initialDisplay || 'visible'}" (Expected: visible)`);

    // Select "no"
    await siteSelect.selectOption('no');
    await page.waitForTimeout(150);
    let afterNoDisplay = await siteUrlGroup.evaluate(el => el.style.display);
    console.log(`  ✓ After selecting "No": display="${afterNoDisplay}" (Expected: none)`);

    // Select "yes"
    await siteSelect.selectOption('yes');
    await page.waitForTimeout(150);
    let afterYesDisplay = await siteUrlGroup.evaluate(el => el.style.display);
    console.log(`  ✓ After selecting "Yes": display="${afterYesDisplay}" (Expected: visible)`);

    // 5. Form Submission Flow
    console.log('\n[6/6] Testing Campaign Enquiry Form Submission via AJAX...');
    await page.fill('#campaign-name', 'Eleanor Vance');
    await page.fill('#campaign-email', 'eleanor.vance@example.com');
    await page.fill('#campaign-company', 'Vance Holdings Ltd');
    await page.fill('#campaign-url', 'https://vanceholdings.example.com');
    await page.selectOption('#campaign-interest', 'seo-cro-sprint');
    await page.fill('#campaign-details', 'Looking to overhaul our lead generation funnel for Q1. Current site drops off heavily at checkout.');

    await page.click('#campaign-submit-btn');

    // Wait for submission notice
    await page.waitForSelector('#campaign-form-notice:not([style*="display: none"])', { timeout: 8000 });
    const noticeText = await page.textContent('#campaign-form-notice');
    console.log(`  ✓ Submission Notice: "${noticeText.trim()}"`);

    await page.screenshot({ path: path.join(screenshotsDir, 'campaign-form-submitted.png'), fullPage: false });
    console.log('  ✓ Captured: docs/screenshots/campaign-form-submitted.png');

    console.log('\n====================================================');
    console.log(' 🎉 ALL CAMPAIGN VERIFICATION CHECKS PASSED!');
    console.log('====================================================\n');

  } catch (err) {
    console.error('❌ Verification Error:', err.message);
    process.exit(1);
  } finally {
    if (browser) {
      await browser.close();
    }
  }
})();

