const mix = require( 'laravel-mix' );
const {
  CleanWebpackPlugin
} = require( 'clean-webpack-plugin' );
mix.setPublicPath( './public_html' )
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

mix.babelConfig( {
  plugins: [
    '@babel/plugin-syntax-dynamic-import'
  ],
} );

mix.webpackConfig( {
  output: {
    //   chunkFilename: '[name].js?id=[chunkhash]',
    filename: "[name].[chunkhash].js",
    chunkFilename: "[name].[chunkhash].js",
  },
  resolve: {
    alias: {
      ziggy: path.resolve( './main/vendor/tightenco/ziggy/src/js/route.js' ),
    },
  },
  plugins: [

    /**
     * All files inside webpack's output.path directory will be removed once, but the
     * directory itself will not be. If using webpack 4+'s default configuration,
     * everything under <PROJECT_DIR>/dist/ will be removed.
     * Use cleanOnceBeforeBuildPatterns to override this behavior.
     *
     * During rebuilds, all webpack assets that are not used anymore
     * will be removed automatically.
     *
     * See `Options and Defaults` for information
     */

    new CleanWebpackPlugin( {
      dry: !mix.inProduction(),
      cleanOnceBeforeBuildPatterns: [ 'js/*', 'css/*', '/img/*', 'fonts/*', 'robots.txt', 'mix-manifest.json' ]

    } ),
  ]
} );

if ( !mix.inProduction() ) {
  mix.sourceMaps();
}

mix
  .extract()
  .mergeManifest()
  .then( () => {
    const _ = require( 'lodash' )
    // let manifestData = require( './public_html/mix-manifest' )
    let oldManifestData = JSON.parse( fs.readFileSync( './public_html/mix-manifest.json', 'utf-8' ) )

    let newManifestData = {};

    _.map( oldManifestData, ( actualFilename, mixKeyName ) => {

      if ( _.startsWith( mixKeyName, '/css' ) ) {
        /** Exclude CSS files from renaming for now till we start cache busting them */
        newManifestData[ mixKeyName ] = actualFilename;
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
