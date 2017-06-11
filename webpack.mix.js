const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.combine([
	'public/css/app.css',
    'resources/assets/css/nprogress.min.css',
    'resources/assets/css/style.css'
], 'public/css/custom.css')
    .minify('public/css/custom.css');
    // .version('public/css/custom.css');

mix.combine([
    'resources/assets/js/nprogress.min.js',
    'public/js/app.js',
    'resources/assets/js/main.js',
], 'public/js/custom.js')
    .minify('public/js/custom.js');
    // .version('public/js/custom.js');