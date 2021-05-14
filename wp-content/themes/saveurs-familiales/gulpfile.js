// Sass configuration
const gulp = require('gulp');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const wait = require('gulp-wait');
const autoprefixer = require('gulp-autoprefixer');
const size = require('gulp-size');
const notify = require('gulp-notify');

// JS configuration
const webpack = require('webpack-stream');
const WebpackNotifierPlugin = require('webpack-notifier');

// Gulp configturation
const icon = "images/favicons/android-chrome-192x192.png";
const Title = "Compile SASS";

const path = __dirname;
const segment_array = path.split('\\');
const current_theme = segment_array[segment_array.length - 1];

/**
* SASS
*/

//Prod Task
gulp.task('deploy-sass', () => {
	gulp.src('./css/theme.scss', { cwd: __dirname })
		.pipe(sass({
			outputStyle: 'compressed',
			includePaths: ['./css']
		}).on('error', sass.logError))
		.pipe(concat('style.css'))
		.pipe(autoprefixer({ cascade: false }))
		.pipe(gulp.dest('./css/', { cwd: __dirname }));
});

//Dev Task
gulp.task('theme-sass', () => {

	const s = size();

	gulp.src('./css/theme.scss', { cwd: __dirname })
		.pipe(wait(400))
		.pipe(sass({
			outputStyle: 'normal',
			includePaths: ['./css']
		}).on('error', sass.logError))
		.pipe(concat('style.css'))
		.pipe(autoprefixer({ cascade: false }))
		.pipe(s)
		.pipe(gulp.dest('./css/', { cwd: __dirname }))
		.pipe(notify({ title: Title, message: () => `Total size ${s.prettySize}`, appIcon: icon, silent: true }));
});

/**
* JavaScript
*/

// Base Configuration
const webpackConfig = {
	output : { filename : 'app.js' },
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: ['babel-loader']
			},{
				test: /\.(png|jp(e*)g|svg)$/,
				use: [{
					loader: 'url-loader',
					options: {
						limit: 8000, // Convert images < 8kb to base64 strings
						name: 'images/[hash]-[name].[ext]'
					}
				}]
			}
		]
	},
	plugins: []
}

//Prod Task
gulp.task('deploy-script', () => {
	const config = { ...webpackConfig };
	config.watch = false;
	config.mode = 'production';

	gulp.src(`${__dirname}/js/src/index.js`)
		.pipe(
			webpack(config)
		)
		.pipe(gulp.dest(`${__dirname}/js/dist/`));

});

//Dev Task
gulp.task('theme-script', () => {
	const config = { ...webpackConfig };
	config.watch = true;
	config.mode = 'development';
	config.plugins.push( new WebpackNotifierPlugin({ title: 'Webpack', alwaysNotify: true }) );

	gulp.src(`${__dirname}/js/src/index.js`)
		.pipe(
			webpack(config)
		)
		.pipe(gulp.dest(`${__dirname}/js/dist/`));

});


/**
*	WATCHER
*/

//Dev Task Watch
gulp.task(`${current_theme}-watch-theme`, ['theme-sass', 'theme-script'], () => {
	gulp.watch('./css/**/*.scss', { cwd: __dirname }, ['theme-sass']);
});
