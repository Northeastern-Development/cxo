const gulp          = require('gulp'),
      gulpPlugin    = require('gulp-load-plugins')(),
      postcss       = require('gulp-postcss'),
      autoprefixer  = require('autoprefixer'),
      cssnano       = require('cssnano'),
      browserSync   = require('browser-sync').create(),
      webpackStream = require('webpack-stream'),
      webpack       = require('webpack');

const isDevelopment = ( process.env.NODE_ENV !== 'production' );

// Compile and bundle js
gulp.task('js', () => {

  let scripts = gulp.src('static/js/entry.js')
  .pipe(webpackStream( require('./webpack.config.js'), webpack))
  .pipe(gulp.dest('static/build/js'));

  if ( isDevelopment ) {
    scripts
    .pipe(browserSync.stream({ once: true }));
  }

  return scripts;
});

gulp.task('styles', () => {
  return gulp.src('static/scss/**/*.scss')
  .pipe(gulpPlugin.sourcemaps.init())
  .pipe(gulpPlugin.sass({
    outputStyle : 'expanded',
    includePaths: [require('ups-mixin-lib').includePaths]
  }))
  .on('error', gulpPlugin.sass.logError)
  .pipe(gulpPlugin.sourcemaps.write({includeContent: false}))
  .pipe(gulpPlugin.sourcemaps.init({loadMaps: true}))
  .pipe(gulpPlugin.postcss([
    autoprefixer({
      browsers: [
      '> 1%',
      'last 4 versions',
      ]
    }),
    cssnano()
    ]))
  .pipe(gulpPlugin.sourcemaps.write('.'))
  .pipe(gulp.dest('./static/build/css/'))
  .pipe(browserSync.stream());
});

/**
*   Build a custom modernizr file
*/
gulp.task('modernizr', () => {
  gulp.src(['./static/scss/**/*.scss', './static/js/**/*.js'])
  .pipe(gulpPlugin.modernizr({
    options: [
    "setClasses"
    ]
  }))
  .pipe(gulpPlugin.uglify())
  .pipe(gulp.dest('./static/build/'));
});

// Serve via browsersync, watching scss and js files
gulp.task('browser-sync', ['build'], () => {

  browserSync.init({
    logPrefix : 'cxo',
    notify    : false,
    open      : false,
    ghostMode : false,
    proxy     : 'http://localhost:8081'
  });

  gulp.watch('static/scss/**/*.scss', ['styles']);
  gulp.watch('static/js/**/*.js', ['js']);
});

gulp.task('build', ['styles', 'js', 'modernizr']);

gulp.task('default', ['build', 'browser-sync']);

