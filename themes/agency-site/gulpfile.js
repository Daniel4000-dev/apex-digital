const path = require('path');
const gulp = require('gulp');
const gulpSass = require('gulp-sass');
const dartSass = require('sass');
const sass = gulpSass(dartSass);
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');

// File paths
const foundationPath = path.resolve(__dirname, 'node_modules/foundation-sites/scss');
const paths = {
  scss: {
    src: 'assets/src/scss/campaign.scss',
    watch: 'assets/src/scss/**/*.scss',
    dest: 'assets/dist/css'
  }
};

/**
 * Compile Sass to CSS with Foundation XY-Grid, Autoprefixer, Minification, and Sourcemaps
 */
function compileSass() {
  return gulp.src(paths.scss.src)
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: [foundationPath, 'assets/src/scss'],
      loadPaths: [foundationPath, 'assets/src/scss'],
      quietDeps: true,
      silenceDeprecations: ['import', 'global-builtin', 'color-functions']
    }).on('error', function(err) {
      console.error('Sass Compilation Error:\n', err.messageFormatted || err.message);
      this.emit('end');
      process.exitCode = 1;
    }))
    .pipe(postcss([autoprefixer()]))
    .pipe(cleanCSS({
      compatibility: 'ie11',
      level: {
        1: { specialComments: 0 }
      }
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.scss.dest));
}

/**
 * Watch Sass source files
 */
function watchSass() {
  gulp.watch(paths.scss.watch, compileSass);
}

exports.sass = compileSass;
exports.watch = watchSass;
exports.build = compileSass;
exports.default = compileSass;
