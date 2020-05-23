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

if ( [ 'buildjs' ].includes( process.env.npm_config_section ) ) {
    mix.js( __dirname + '/Resources/js/app.js', 'js/admin-app.js' )
}
