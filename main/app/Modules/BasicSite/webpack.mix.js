const mix = require( 'laravel-mix' );
require( 'laravel-mix-merge-manifest' );

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@basicsite-components': __dirname + '/Resources/js/components',
            '@basicsite-assets': __dirname + '/Resources',
        },
    },
} )

mix.scripts( [
//    __dirname + '/Resources/js/vendor/core.min.js',
    // __dirname + '/Resources/js/vendor/mordernizr.js',
    // __dirname + '/Resources/js/vendor/jquery.aim.js',
    // __dirname + '/Resources/js/vendor/mega-menu.js',
], 'public_html/js/app-vendor.js' );

//mix.copy( __dirname + '/Resources/js/vendor/core.min.js', 'public_html/js/app-vendor.js' );
//mix.copy( __dirname + '/Resources/js/vendor/script.js', 'public_html/js/main.js' );

//mix.copyDirectory( __dirname + '/Resources/img', 'public_html/img' );
//mix.copyDirectory( __dirname + '/Resources/fonts', 'public_html/fonts' );

mix.js( __dirname + '/Resources/js/app.js', 'js/basic-app.js' );

if ( mix.inProduction() ) {
    mix.version();
}
