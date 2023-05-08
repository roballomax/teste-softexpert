let gulp    = require('gulp');
let less    = require('gulp-less');
let cssc    = require('gulp-css-condense');

//exporta o less para css
gulp.task('less', () => {
    return gulp.src('./public/assets/src/less/style.less')
    .pipe(less())
    .pipe(gulp.dest('./public/assets/dist/css/'));
});
//minifica o css gerado do less
gulp.task('cssc', () => {
    return gulp.src('./public/assets/dist/css/style.css')
    .pipe(cssc())
    .pipe(gulp.dest('./public/assets/dist/css/'));
});

gulp.task('watch', gulp.series(['less', 'cssc'], () => {
    gulp.watch([
        './public/assets/src/less/*.less',
        './public/assets/src/**/*.less'
    ], gulp.series(['less', 'cssc']));
}));

gulp.task('default', () => {
    return;
});