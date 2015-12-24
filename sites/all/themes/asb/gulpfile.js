// npm install --save-dev gulp gulp-compass gulp-plumber gulp-watch gulp-livereload gulp-minify-css gulp-uglify gulp-rename gulp-notify gulp-include

var gulp = require('gulp'),
    sass = require('gulp-compass'),
	plumber = require( 'gulp-plumber' ),
	watch = require( 'gulp-watch' ),
	livereload = require( 'gulp-livereload' ),
	minifycss = require( 'gulp-minify-css' ),
	uglify = require( 'gulp-uglify' ),
	rename = require( 'gulp-rename' ),
	notify = require( 'gulp-notify' ),
	include = require( 'gulp-include' );

var onError = function( err ) {
	console.log( 'An error occurred:', err.message );
	this.emit( 'end' );
}

gulp.task( 'sass', function() {
	return gulp.src( './sass/style.scss', {
		style: 'expanded'
	} )
	.pipe( plumber( { errorHandler: onError } ) )
	.pipe( sass() )
	.pipe( gulp.dest( '.' ) )
	.pipe( minifycss() )
	.pipe( rename( { suffix: '.min' } ) )
	.pipe( gulp.dest( './css' ) )
	.pipe( notify( { message: 'Styles task complete' } ) )
} );


gulp.task( 'watch', function() {
	gulp.watch( './sass/**/*.scss', [ 'sass' ] );
} );

gulp.task( 'default', [ 'sass', 'watch' ], function() {

} )