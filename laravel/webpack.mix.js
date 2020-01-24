const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 | .sass('resources/sass/_dropdown.scss', 'public/css').version();
 */

mix.js('resources/js/popper.min.js', 'public/js')
   .js('resources/js/app.js', 'public/js')
   .js('resources/js/dashboard.js', 'public/js')
   .js('resources/js/tinymce.js', 'public/js')
   .sass(['resources/sass/app.scss', 'public/css',
   'resources/sass/dashboard.scss', 'public/css',
   'resources/sass/jumbotron.scss', 'public/css',
   'resources/sass/skeleton.scss', 'public/css',
   'resources/sass/normalize.scss','public/css']).version();

//todo tiny mce updates needs to work with all of the mix

if (mix.inProduction()) {
    mix.version();
}
