const gulp = require('gulp');
const fs = require('fs');
const path = require('path');
const sass = require('sass');
const twig = require('twig');

// Compile Sass using Dart Sass
function styles(cb) {
  const result = sass.compile(path.join(__dirname, 'src/scss/main.scss'), {
    style: 'compressed',
  });

  const distCssDir = path.join(__dirname, 'dist/css');
  if (!fs.existsSync(distCssDir)) {
    fs.mkdirSync(distCssDir, { recursive: true });
  }

  fs.writeFileSync(path.join(distCssDir, 'main.css'), result.css);
  cb();
}

// Render Twig template using JSON fixture
function templates(cb) {
  const fixturePath = path.join(__dirname, 'src/data/audit-fixture.json');
  const templatePath = path.join(__dirname, 'src/templates/audit-component.twig');
  const distDir = path.join(__dirname, 'dist');

  if (!fs.existsSync(distDir)) {
    fs.mkdirSync(distDir, { recursive: true });
  }

  const data = JSON.parse(fs.readFileSync(fixturePath, 'utf8'));

  twig.renderFile(templatePath, data, (err, html) => {
    if (err) {
      return cb(err);
    }
    fs.writeFileSync(path.join(distDir, 'audit-component.html'), html);
    cb();
  });
}

exports.styles = styles;
exports.templates = templates;
exports.build = gulp.parallel(styles, templates);
exports.default = exports.build;
