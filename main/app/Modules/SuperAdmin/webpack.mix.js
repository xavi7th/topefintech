const mix = require( 'laravel-mix' )

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@superadmin-components': __dirname + '/Resources/js/components',
            '@superadmin-assets': __dirname + '/Resources'
        },
    },
} )

mix.js( __dirname + '/Resources/js/app.js', 'js/superadmin-app.js' )
