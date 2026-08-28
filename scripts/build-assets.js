/**
 * Build de assets para TelcoSur SPA.
 * - Une y minifica las hojas CSS en css/bundle.min.css (con autoprefixer).
 * - Une y minifica los JS en js/bundle.min.js.
 * El orden se respeta para no romper la cascada de estilos.
 */
const fs = require('fs');
const path = require('path');
const CleanCSS = require('clean-css');
const postcss = require('postcss');
const autoprefixer = require('autoprefixer');
const { minify } = require('terser');

const root = path.resolve(__dirname, '..');

const cssOrder = [
  'css/fonts.css',
  'css/style.css',
  'css/corporate.css',
  'css/animations.css',
  'css/polish.css',
  'css/accessibility.css',
];

const jsOrder = [
  'js/animations.js',
  'js/main.js',
];

function readIfExists(rel) {
  const abs = path.join(root, rel);
  if (!fs.existsSync(abs)) {
    console.warn(`  (omitido, no existe) ${rel}`);
    return '';
  }
  return fs.readFileSync(abs, 'utf8');
}

function humanKb(bytes) {
  return (bytes / 1024).toFixed(1) + ' KB';
}

async function minifyCss(input, outRel) {
  const prefixed = await postcss([autoprefixer]).process(input, { from: undefined });
  const minified = new CleanCSS({ level: 2 }).minify(prefixed.css);
  if (minified.errors.length) {
    throw new Error('CleanCSS: ' + minified.errors.join('; '));
  }
  const out = path.join(root, outRel);
  fs.writeFileSync(out, minified.styles, 'utf8');
  return { raw: Buffer.byteLength(input, 'utf8'), min: Buffer.byteLength(minified.styles, 'utf8') };
}

async function buildCss() {
  const combined = cssOrder.map(readIfExists).join('\n');
  const bundle = await minifyCss(combined, 'css/bundle.min.css');
  console.log(`CSS  ${humanKb(bundle.raw)} -> ${humanKb(bundle.min)}  (css/bundle.min.css)`);

  const critical = readIfExists('css/critical.css');
  if (critical) {
    const crit = await minifyCss(critical, 'css/critical.min.css');
    console.log(`Crit ${humanKb(crit.raw)} -> ${humanKb(crit.min)}  (css/critical.min.css)`);
  }
}

async function buildJs() {
  const files = {};
  jsOrder.forEach((rel) => {
    const content = readIfExists(rel);
    if (content) {
      files[rel] = content;
    }
  });

  const rawSize = Object.values(files).reduce((n, s) => n + Buffer.byteLength(s, 'utf8'), 0);

  const result = await minify(files, {
    compress: true,
    mangle: true,
    format: { comments: false },
  });

  if (result.error) {
    throw result.error;
  }

  const out = path.join(root, 'js/bundle.min.js');
  fs.writeFileSync(out, result.code, 'utf8');
  console.log(`JS   ${humanKb(rawSize)} -> ${humanKb(Buffer.byteLength(result.code, 'utf8'))}  (js/bundle.min.js)`);
}

(async () => {
  console.log('Construyendo assets...');
  await buildCss();
  await buildJs();
  console.log('Build completado.');
})().catch((err) => {
  console.error('Error en build:', err.message);
  process.exit(1);
});
