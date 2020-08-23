const mix = require( 'laravel-mix' )

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@agent-components': __dirname + '/Resources/js/components',
            '@agent-assets': __dirname + '/Resources'
        },
    },
} )

mix.js( __dirname + '/Resources/js/app.js', 'js/agent-app.js' )
