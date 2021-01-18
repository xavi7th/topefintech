const mix = require( 'laravel-mix' );
const {
  CleanWebpackPlugin
} = require( 'clean-webpack-plugin' );
const path = require( 'path' );
let fs = require( 'fs-extra' )
let modules = fs.readdirSync( './main/app/Modules' )

if ( modules && modules.length > 0 ) {
  modules.forEach( module => {
    let path = `./main/app/Modules/${module}/webpack.mix.js`
    if ( fs.existsSync( path ) ) {
      require( path )
    }
  } )
}

mix.setPublicPath( './public_html' )
mix.babelConfig( {
  plugins: [
    '@babel/plugin-syntax-dynamic-import'
  ],
} );

mix.webpackConfig( {
  output: {
    //   chunkFilename: '[name].js?id=[chunkhash]',
    filename: mix.inProduction() ? "[name].[contenthash].js" : "[name].[hash].js",
    chunkFilename: mix.inProduction() ? "[name].[contenthash].js" : "[name].[hash].js",
  },
  plugins: [
    new CleanWebpackPlugin( {
      dry: false,
      cleanOnceBeforeBuildPatterns: [ 'js/*', 'css/*', '/img/*', 'fonts/*', 'robots.txt', 'mix-manifest.json' ]

    } ),
  ]
} );

mix
  .options( {
    processCssUrls :false,
    fileLoaderDirs: {
      images: 'img',
    },
    postCss: [
      require( 'postcss-fixes' )(),
      require( 'cssnano' )( {
        'calc': false
      } ),
    ],
    notifications: {
      onFailure: true,
      onSuccess: false
    }
  } )
  .extract( [ 'vue', 'sweetalert2', 'axios', 'lodash', 'vue-plugin-load-script','@inertiajs/inertia','@inertiajs/inertia-vue','vue2-filters', 'jquery' ] )
  .then( () => {
    const _ = require( 'lodash' )

    var crypto = require( "crypto" );
    const saltCssId = crypto.randomBytes( 7 )
      .toString( 'hex' );
    // console.log(
    //   '\x1b[41m%s\x1b[0m',
    //   saltCssId
    // )

    let oldManifestData = JSON.parse( fs.readFileSync( './public_html/mix-manifest.json', 'utf-8' ) )
    let newManifestData = {};

    _.map( oldManifestData, ( actualFilename, mixKeyName ) => {

      if ( _.startsWith( mixKeyName, '/css' ) ) {
        newManifestData[ mixKeyName ] = actualFilename + '?' + saltCssId;
      } else {

        /**
         * Remove the hash from the mix key name so that we can reference the files
         * by their base name in our codes and mix will automatically replace that
         * with a call to the hashed actual file name
         */
        let newMixKeyName = _.split( mixKeyName, '.' ).tap( o => {
          _.pullAt( o, 1 );
        } ).join( '.' )

        /** If the js extension has been stripped we add it back */
        newMixKeyName = _.endsWith( newMixKeyName, '.js' ) ? newMixKeyName : newMixKeyName + '.js'
        newManifestData[ newMixKeyName ] = actualFilename;
      }

    } );

    let data = JSON.stringify( newManifestData, null, 2 );
    fs.writeFileSync( './public_html/mix-manifest.json', data );
  } )

if ( !mix.inProduction() ) {
  mix.sourceMaps();

}

if ( mix.inProduction() ) {
  mix.version();
}
