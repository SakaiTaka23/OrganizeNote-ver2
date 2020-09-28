const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .scripts([
        'resources/js/charts-bars.js',
        'resources/js/charts-lines.js',
        'resources/js/charts-pie.js',
        'resources/js/focus-trap.js',
        'resources/js/init-alpine.js'
    ], 'public/js/theme.js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
