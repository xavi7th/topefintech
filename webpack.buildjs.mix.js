const mix = require( 'laravel-mix' );
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
  plugins: [ '@babel/plugin-syntax-dynamic-import' ],
} );

mix.webpackConfig( {
  output: {
    chunkFilename: '[name].js?id=[chunkhash]',
  },
  resolve: {
    alias: {
      ziggy: path.resolve( './main/vendor/tightenco/ziggy/src/js/route.js' ),
    },
  },
} );

mix
  .options( {
    fileLoaderDirs: {
      images: 'img'
    }
  } )
  .extract()
  .version()
  .mergeManifest();


if ( !mix.inProduction() ) {
  mix.sourceMaps();
}

if ( mix.inProduction() ) {
  mix.version().then( () => {
    const convertToFileHash = require( "laravel-mix-make-file-hash" );
    convertToFileHash( {
      publicPath: "./public_html",
      manifestFilePath: "./public_html/mix-manifest.json",
      blacklist: [ "user-*", "public-*", "super-*" ],
      keepBlacklistedEntries: true,
      // debug: true
    } );
  } );
}
