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

if ( [ 'buildcss' ].includes( process.env.npm_config_section ) ) {
    mix.copyDirectory( __dirname + '/Resources/img', 'public_html/img' );
    mix.copyDirectory( __dirname + '/Resources/fonts', 'public_html/fonts' );

    mix.sass( __dirname + '/Resources/sass/app.scss', 'css/admin-app.css' )
} else {

    // mix.scripts( [
    //     __dirname + '/Resources/vendor/jquery/dist/jquery.min.js',
    //     __dirname + '/Resources/vendor/popper.js/dist/umd/popper.min.js',
    // ], 'public_html/js/admin-app-vendor.js' );

    // mix.scripts( [
    //     __dirname + '/Resources/vendor/rootui.js',
    //     __dirname + '/Resources/vendor/rootui-init.js',
    // ], 'public_html/js/admin-main.js' );

    mix.js( __dirname + '/Resources/js/app.js', 'js/admin-app.js' )
    mix.js( __dirname + '/Resources/js/auth.js', 'js/admin-auth-app.js' )
}
