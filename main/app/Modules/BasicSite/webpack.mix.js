const mix = require( 'laravel-mix' );

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@basicsite-components': __dirname + '/Resources/js/components',
            '@basicsite-assets': __dirname + '/Resources',
        },
    },
} )

mix.copyDirectory( __dirname + '/Resources/img', 'public_html/img' );
mix.copyDirectory( __dirname + '/Resources/fonts', 'public_html/fonts' );

mix.scripts( [
    __dirname + '/Resources/js/vendor/jquery.js',
    __dirname + '/Resources/js/vendor/bootstrap.min.js',
    __dirname + '/Resources/js/vendor/modernizr.custom.js',
    __dirname + '/Resources/js/vendor/jquery.themepunch.revolution.min.js',
    __dirname + '/Resources/js/vendor/jquery.themepunch.tools.min.js',
    __dirname + '/Resources/js/vendor/jquery-ui.js',
    __dirname + '/Resources/js/vendor/shuffle.js',
    __dirname + '/Resources/js/vendor/slick.js',
    __dirname + '/Resources/js/vendor/owl.carousel.js',
], 'public_html/js/site-app-vendor.js' );

mix.copy( __dirname + '/Resources/js/vendor/theme.js', 'public_html/js/main.js' );
mix.js( __dirname + '/Resources/js/app.js', 'js/site-app.js' )
