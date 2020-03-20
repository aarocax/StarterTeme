 // Gulp.js configuration
'use strict';

const

  // source and build folders
  dir = {
    src         : './static/',
    build       : './static/build/'
  },

  // Gulp and plugins
  gulp          = require('gulp'),
  gutil         = require('gulp-util'),
  newer         = require('gulp-newer'),
  imagemin      = require('gulp-imagemin'),
  sass          = require('gulp-sass'),
  postcss       = require('gulp-postcss'),
  deporder      = require('gulp-deporder'),
  concat        = require('gulp-concat'),
  stripdebug    = require('gulp-strip-debug'),
  uglify        = require('gulp-uglify')
;

// Browser-sync
var browsersync = true;


// JavaScript settings
const js = {
  src         : dir.src + 'js/*',
  build       : dir.build + 'js/',
  filename    : 'scripts.js'
};

// JavaScript processing
gulp.task('js', () => {
	console.log(js);
  return gulp.src(js.src)
    .pipe(deporder())
    .pipe(concat(js.filename))
    .pipe(stripdebug())
    .pipe(uglify())
    .pipe(gulp.dest(js.build))
    .pipe(browsersync ? browsersync.reload({ stream: true }) : gutil.noop());

});


// Concat js
gulp.task('js2', function() {
  return gulp.src([ './static/js/*.js' ])
        .pipe(concat('./static/build/js/concat.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./'));
});


// Gulp watch
gulp.task('watch', function() {
  gulp.watch('./static/js/*.js', gulp.series('js2'));
});
