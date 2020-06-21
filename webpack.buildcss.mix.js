const mix = require( 'laravel-mix' );

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

mix
  .options( {
    fileLoaderDirs: {
      images: 'img',
    },
    postCss: [
      require( 'postcss-fixes' )(),
      require( 'cssnano' )( {
        'calc': false
      } ),
    ],
  } )
  .mergeManifest()
  .then( () => {
    const _ = require( 'lodash' );
    var crypto = require( "crypto" );
    const saltCssId = crypto.randomBytes( 7 )
      .toString( 'hex' );
    console.log(
      '\x1b[41m%s\x1b[0m',
      saltCssId
    )
    let oldManifestData = JSON.parse( fs.readFileSync( './public_html/mix-manifest.json', 'utf-8' ) )
    let newManifestData = {};

    _.map( oldManifestData, ( actualFilename, mixKeyName ) => {
      if ( _.startsWith( mixKeyName, '/css' ) ) {
        newManifestData[ mixKeyName ] = actualFilename + '?' + saltCssId;
      } else {
        newManifestData[ mixKeyName ] = actualFilename;
      }
    } );

    let data = JSON.stringify( newManifestData, null, 2 );
    fs.writeFileSync( './public_html/mix-manifest.json', data );
  } )

if ( !mix.inProduction() ) {
  mix.sourceMaps();
}
