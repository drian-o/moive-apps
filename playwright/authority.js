const { chromium } = require('playwright');

(async () => {

    const domains = process.argv.slice(2);

    if (!domains.length) {
        console.error('Tidak ada domain.');
        process.exit(1);
    }

const context = await chromium.launchPersistentContext(
    './playwright-profile',
    {
        headless: false,
        channel: 'chrome',
        slowMo: 100,

        viewport: {
            width: 1600,
            height: 900
        },

        userAgent:
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'
    }
);

const page = context.pages()[0] || await context.newPage();
await page.addInitScript(() => {
    Object.defineProperty(navigator, 'webdriver', {
        get: () => undefined
    });
});

page.on('request', req => {
    const url = req.url();

    if (url.includes('challenges.cloudflare.com')) {
        console.log('CF REQUEST:', req.method(), url);
    }
});

    console.log('Opening GuestPostLinks...');

    await page.goto(
        'https://tools.guestpostlinks.net/bulk-da-pa-checker-tool/',
        {
            waitUntil: 'domcontentloaded'
        }
    );

    console.log('Page Loaded.');

    await page.locator('#dapa_link').fill(domains.join('\n'));

    // Listener HARUS sebelum klik
const responses = [];

page.on('response', async (res) => {

const url = res.url();

if (!url.includes('/wp-admin/admin-ajax.php')) {
    return;
}

console.log('REQ:', res.request().method(), url);

try {

    console.log('AJAX:', res.url());

    const json = await res.json();

    console.log(JSON.stringify(json, null, 2));
    console.log('ACTION:', res.request().postData());

    // Abaikan response cek kredit
    if (!Array.isArray(json.data)) {
        return;
    }

        // Cari response yang benar-benar ada api_result
        const valid = json.data.some(item => item.api_result);

        if (valid) {

            console.log('RESULT RESPONSE DITEMUKAN');

            responses.push(json);

        }

    } catch (e) {
    console.error('ERROR PARSE:', e.message);
}

});


    console.log('');
    console.log('===========================================');
    console.log('Klik CHECK AUTHORITY...');
    console.log('===========================================');

    // Klik NORMAL
    await page.locator('#DAPAformsend').click();

await page.waitForTimeout(5000);

const token = await page.evaluate(() => {
    const el = document.querySelector('[name="cf-turnstile-response"]');
    return el ? el.value : null;
});

console.log('TURNSTILE TOKEN:', token);

    console.log('');
    console.log('===========================================');
    console.log('SELESAIKAN TURNSTILE');
    console.log('Tunggu sampai hasil keluar...');
    console.log('===========================================');
    // Tunggu sampai listener mendapatkan response hasil checker
    while (responses.length === 0) {
        await page.waitForTimeout(500);
    }

    console.log('AJAX diterima.');

    const json = responses[0];

    console.log(JSON.stringify(json, null, 2));
    // Tunggu response AJAX
    const results = [];

    if (json.success && Array.isArray(json.data)) {

        for (const item of json.data) {

            if (!item.api_result) continue;

            for (const domain in item.api_result) {

                const metrics = item.api_result[domain].metrics;

                results.push({
                    domain,
                    da: metrics.domain_authority,
                    pa: metrics.page_authority,
                    ss: metrics.spam_score,
                    tb: metrics.root_domains_to_root_domain ?? 0,
                    qb: metrics.pages_to_root_domain ?? 0
                });

            }

        }

    }

    console.log(JSON.stringify(results, null, 2));

    await context.close();

})();