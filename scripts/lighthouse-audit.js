/**
 * Auditoría Lighthouse del sitio local (XAMPP).
 * Uso: npm run audit  [-- http://localhost/telcosur-spa-web/index.php]
 * Genera un reporte HTML en reports/lighthouse-<pagina>.html y muestra las notas.
 */
const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const reportsDir = path.join(root, 'reports');

const targetUrl = process.argv[2] || 'http://localhost/telcosur-spa-web/index.php';

(async () => {
  const lighthouse = (await import('lighthouse')).default;
  const chromeLauncher = await import('chrome-launcher');

  fs.mkdirSync(reportsDir, { recursive: true });

  const chrome = await chromeLauncher.launch({ chromeFlags: ['--headless=new', '--no-sandbox'] });
  try {
    const options = {
      logLevel: 'error',
      output: 'html',
      onlyCategories: ['performance', 'accessibility', 'best-practices', 'seo'],
      port: chrome.port,
    };

    const runnerResult = await lighthouse(targetUrl, options);
    const { categories } = runnerResult.lhr;

    const slug = targetUrl.replace(/[^a-z0-9]+/gi, '_').replace(/^_+|_+$/g, '');
    const reportPath = path.join(reportsDir, `lighthouse-${slug}.html`);
    fs.writeFileSync(reportPath, runnerResult.report, 'utf8');

    console.log(`\nAuditoría: ${targetUrl}`);
    Object.entries(categories).forEach(([key, cat]) => {
      const score = cat.score === null ? 'n/a' : Math.round(cat.score * 100);
      console.log(`  ${cat.title.padEnd(16)} ${score}`);
    });

    const audits = runnerResult.lhr.audits;
    const metricKeys = ['first-contentful-paint', 'largest-contentful-paint', 'total-blocking-time', 'cumulative-layout-shift', 'speed-index'];
    console.log('\nMétricas:');
    metricKeys.forEach((k) => {
      if (audits[k]) {
        console.log(`  ${audits[k].title.padEnd(28)} ${audits[k].displayValue || ''}`);
      }
    });

    const opportunities = Object.values(audits)
      .filter((a) => a.details && a.details.type === 'opportunity' && a.details.overallSavingsMs > 50)
      .sort((a, b) => b.details.overallSavingsMs - a.details.overallSavingsMs)
      .slice(0, 6);
    if (opportunities.length) {
      console.log('\nOportunidades:');
      opportunities.forEach((a) => {
        console.log(`  ~${Math.round(a.details.overallSavingsMs)} ms  ${a.title}`);
      });
    }

    console.log(`\nReporte HTML: ${reportPath}`);
  } finally {
    try {
      await chrome.kill();
    } catch (_) {
      // La limpieza del temporal de Chrome puede fallar en Windows; no afecta el reporte.
    }
  }
})().catch((err) => {
  console.error('Error en auditoría:', err.message);
  process.exit(1);
});
