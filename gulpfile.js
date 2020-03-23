 // Gulp.js configuration
'use strict';

var gulp       = require('gulp');
var concat     = require('gulp-concat');
var sass       = require('gulp-sass');
var watch      = require('gulp-watch');
var stripdebug = require('gulp-strip-debug');
var uglify     = require('gulp-uglify');
//var minifyCSS  = require('gulp-minify-css');
var cleanCSS = require('gulp-clean-css');


gulp.task('css', function() {
  return gulp.src([
                    './static/css/styles.css',
                  ])
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(concat('./static/build/css/site.css'))
        .pipe(gulp.dest('./'));
});

// Concat js
gulp.task('js', function() {
  return gulp.src([ 
                    './static/js/SiteUtils.js', // Librería con el endpoint ajax y otras utilidades
                    './static/js/scripts.js',
                    './static/js/other_scripts.js',
                  ])
        .pipe(concat('./static/build/js/site.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./'));
});


// Gulp watch
gulp.task('watch', function() {
  gulp.watch('./static/js/*.js', gulp.series('js'));
});
