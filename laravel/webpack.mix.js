const mix = require('laravel-mix');

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
mix.js('resources/js/admin/dashboard.js', 'public/js/admin')
    .js('resources/js/admin/color-modes.js', 'public/js/admin')
    .js('resources/js/admin/app.js', 'public/js/admin')
    .js('resources/js/admin/ck_main_admin.js', 'public/js/ckeditor5')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/ck_main.js', 'public/js/ckeditor5')
    .sass('resources/sass/carousel.scss', 'public/css')
    .sass('resources/sass/bootstrap.min.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/email.scss', 'public/css')
    .sass('resources/sass/dashboard.scss', 'public/css')
    .sass('resources/sass/dashboard-inline.scss', 'public/css')
    .sass('resources/sass/jumbotron.scss', 'public/css')
    .sass('resources/sass/skeleton.scss', 'public/css')
    .sass('resources/sass/ck_style.scss', 'public/css')
    .sass('resources/sass/normalize.scss','public/css')
    .js('resources/js/google-analytics.js', 'public/js')
    .sourceMaps()
    .version();
