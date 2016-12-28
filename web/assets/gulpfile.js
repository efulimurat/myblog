var gulp = require('gulp');
var less = require('gulp-less');
var browserSync = require('browser-sync').create();
var cleanCSS = require('gulp-clean-css');
var rename = require("gulp-rename");
var uglify = require('gulp-uglify');

gulp.task('css', function() {
    return gulp.src(['css/*.css'])
        .pipe(gulp.dest('dist/css'))
        .pipe(browserSync.reload({
            stream: true
        }))
})
gulp.task('minify-css', ['css'], function() {
    return gulp.src(['dist/*.css'])
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('dist/css'))
        .pipe(browserSync.reload({
            stream: true
        }))
});

gulp.task('js', function() {
    return gulp.src(['js/*.js'])
        .pipe(gulp.dest('dist/js'))
        .pipe(browserSync.reload({
            stream: true
        }))
})
gulp.task('minify-js', ['js'], function() {
    return gulp.src(['dist/*.js','!**.min.js'])
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('dist/js'))
        .pipe(browserSync.reload({
            stream: true
        }))
});
gulp.task('default', ['minify-css', 'minify-js']);

// Configure the browserSync task
gulp.task('browserSync', function() {
    browserSync.init({
        server: {
            baseDir: ''
        },
    })
})

// Dev task with browserSync
gulp.task('dev', ['browserSync', 'css', 'minify-css', 'js', 'minify-js'], function() {
    gulp.watch('css/*.css', ['css']);
    gulp.watch('dist/css/*.css', ['minify-css']);
    gulp.watch('js/*.js', ['minify-js']);
    // Reloads the browser whenever HTML or JS files change
    gulp.watch('dist/js/*.js', browserSync.reload);
});
