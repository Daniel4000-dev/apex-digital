const fs = require('fs');
const path = require('path');
const sass = require('sass');
const twig = require('twig');

console.log('Compiling Legacy Maintenance Example...');

// 1. Compile SCSS
const scssPath = path.join(__dirname, 'src/scss/main.scss');
const distCssDir = path.join(__dirname, 'dist/css');
if (!fs.existsSync(distCssDir)) {
  fs.mkdirSync(distCssDir, { recursive: true });
}

const sassResult = sass.compile(scssPath, {
  style: 'compressed',
});
fs.writeFileSync(path.join(distCssDir, 'main.css'), sassResult.css);
console.log('✓ Compiled Sass to dist/css/main.css (' + sassResult.css.length + ' bytes)');

// 2. Render Twig template
const fixturePath = path.join(__dirname, 'src/data/audit-fixture.json');
const templatePath = path.join(__dirname, 'src/templates/audit-component.twig');
const distDir = path.join(__dirname, 'dist');

const data = JSON.parse(fs.readFileSync(fixturePath, 'utf8'));

twig.renderFile(templatePath, data, (err, html) => {
  if (err) {
    console.error('Error rendering Twig template:', err);
    process.exit(1);
  }
  fs.writeFileSync(path.join(distDir, 'audit-component.html'), html);
  console.log('✓ Rendered Twig template to dist/audit-component.html (' + html.length + ' bytes)');
  console.log('Done!');
});

