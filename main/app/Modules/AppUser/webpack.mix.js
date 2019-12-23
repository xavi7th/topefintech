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

const mix = require( 'laravel-mix' );
require( 'laravel-mix-merge-manifest' );

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@dashboard-components': __dirname + '/Resources/js/components',
            '@dashboard-assets': __dirname + '/Resources',
        },
    },
} )

mix.scripts( [
    __dirname + '/Resources/js/vendor/jquery-3.2.1.min.js',
    __dirname + '/Resources/js/vendor/popper.min.js',
    __dirname + '/Resources/js/vendor/bootstrap.min.js',
    __dirname + '/Resources/js/vendor/simplebar.min.js',
    __dirname + '/Resources/js/vendor/morris.min.js',
    __dirname + '/Resources/js/vendor/chartjs.min.js',
    __dirname + '/Resources/js/vendor/raphael.min.js',
    __dirname + '/Resources/js/vendor/owl.carousel.min.js'
], 'public_html/js/user-dashboard-app-vendor.js' );

mix.scripts( [
    __dirname + '/Resources/js/vendor/main.js'
], 'public_html/js/user-dashboard-main.js' );

mix.scripts( [
    __dirname + '/Resources/js/vendor/layout-side.js'
], 'public_html/js/user-dashboard-nav.js' );

mix.copyDirectory( __dirname + '/Resources/img', 'public_html/img' );
mix.copyDirectory( __dirname + '/Resources/fonts', 'public_html/fonts' );

mix.js( __dirname + '/Resources/js/main.js', 'js/user-dashboard-app.js' )

if ( mix.inProduction() ) {
    mix.version();
}
