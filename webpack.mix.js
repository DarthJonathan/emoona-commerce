let mix = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

mix.options({
    processCssUrls: false
});

mix.sass('resources/assets/sass/styleadmin.scss', 'public/css');
mix.sass('resources/assets/sass/style404.scss', 'public/css');
mix.sass('resources/assets/sass/style.scss', 'public/css');
mix.sass('resources/assets/sass/userstyle.scss', 'public/css');

mix.scripts('resources/assets/js/all.js', 'public/js/all.js');
mix.js('resources/assets/js/dependency.js', 'public/js');
mix.babel('resources/assets/js/front.js', 'public/js/front.js');