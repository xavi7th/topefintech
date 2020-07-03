const mix = require( 'laravel-mix' )

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@admin-components': __dirname + '/Resources/js/components',
            '@admin-assets': __dirname + '/Resources'
        },
    },
} )

mix.js( __dirname + '/Resources/js/app.js', 'js/admin-app.js' )
