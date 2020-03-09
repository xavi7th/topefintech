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

const mix = require( 'laravel-mix' )
require( 'laravel-mix-merge-manifest' )


mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@admin-components': __dirname + '/Resources/js/components',
            '@admin-assets': __dirname + '/Resources'
        },
    },
} )

mix.scripts( [
    __dirname + '/Resources/vendor/jquery/dist/jquery.min.js',
    __dirname + '/Resources/vendor/popper.js/dist/umd/popper.min.js',
    __dirname + '/Resources/vendor/bootstrap/dist/js/bootstrap.min.js',
    __dirname + '/Resources/vendor/feather-icons/dist/feather.min.js',
    __dirname + '/Resources/vendor/overlayscrollbars/js/jquery.overlayScrollbars.min.js',
    __dirname + '/Resources/vendor/yaybar.js',
    __dirname + '/Resources/vendor/object-fit-images/dist/ofi.min.js',
    __dirname + '/Resources/vendor/fancybox/dist/jquery.fancybox.min.js',
    __dirname + '/Resources/vendor/emojione/lib/js/emojione.min.js',
    __dirname + '/Resources/vendor/emojionearea/dist/emojionearea.min.js',
    __dirname + '/Resources/vendor/moment/min/moment.min.js',
    __dirname + '/Resources/vendor/swiper/js/swiper.min.js',
    __dirname + '/Resources/vendor/chart.js/dist/Chart.min.js',
    __dirname + '/Resources/vendor/chartist/dist/chartist.min.js',
], 'public_html/js/admin-app-vendor.js' );

mix.scripts( [
    __dirname + '/Resources/vendor/rootui.js',
    __dirname + '/Resources/vendor/rootui-init.js',
], 'public_html/js/admin-main.js' );

mix.copyDirectory( __dirname + '/Resources/img', 'public_html/img' );
mix.copyDirectory( __dirname + '/Resources/fonts', 'public_html/fonts' );

mix.js( __dirname + '/Resources/js/app.js', 'js/admin-app.js' )
mix.js( __dirname + '/Resources/js/auth.js', 'js/admin-auth-app.js' )

if ( mix.inProduction() ) {
    mix.version()
}
