 // Gulp.js configuration
'use strict';

var gulp       = require('gulp');
var concat     = require('gulp-concat');
var sass       = require('gulp-sass');
var watch      = require('gulp-watch');
var stripdebug = require('gulp-strip-debug');
var uglify     = require('gulp-uglify');
//var minifyCSS  = require('gulp-minify-css');
var cleanCSS   = require('gulp-clean-css');
var merge      = require('merge-stream');


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

  // script para uso en la parte pública
  var concatenados = gulp.src([ 
                    './static/src/js/SiteUtils.js', // Librería con el endpoint ajax y otras utilidades
                    './static/src/js/scripts.js',
                    './static/src/js/other_scripts.js',
                  ])
        .pipe(concat('./static/build/js/site.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./'));

  // scripts para uso en panel de administración
  var concatenados_admin = gulp.src([ 
                    './static/src/js/admin/scripts_admin.js',
                  ])
        .pipe(concat('./static/build/js/admin/site_admin.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./'));

  // mueve archivos no concatenados a la carpeta build
  var no_concatenados = gulp
        .src([
          './static/src/js/no_concatenar.js'
          ])
        .pipe(gulp.dest('static/build/js'));

  return merge(concatenados, no_concatenados, concatenados_admin);

});


// Gulp watch
gulp.task('watch', function() {
  gulp.watch('./static/js/*.js', gulp.series('js'));
});
