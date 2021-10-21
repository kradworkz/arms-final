const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/pusher.js', 'public/js')
    .vue()
    .sass('resources/sass/style.scss', 'public/css')
    .scripts([
        'public/assets/libs/metismenu/metisMenu.min.js',
        'public/assets/libs/simplebar/simplebar.min.js',
        'public/assets/libs/node-waves/waves.min.js',
        'public/assets/libs/jquery.easing/jquery.easing.min.js',
        'public/assets/js/pages/ico-landing.init.js',
        'public/assets/js/app.js',
     ], 'public/js/frontend.js');
