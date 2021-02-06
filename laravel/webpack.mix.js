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
    .js('resources/js/dashboard.js', 'public/js')
    .js('resources/js/tinymce.js', 'public/js')
    /**
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
     **/
    .sass('resources/sass/carousel.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/email.scss', 'public/css')
    .sass('resources/sass/dashboard.scss', 'public/css')
    .sass('resources/sass/jumbotron.scss', 'public/css')
    .sass('resources/sass/skeleton.scss', 'public/css')
    .sass('resources/sass/normalize.scss','public/css')
    .sourceMaps()
    .version();
