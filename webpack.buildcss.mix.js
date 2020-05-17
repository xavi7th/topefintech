const mix = require( 'laravel-mix' );
mix.setPublicPath( './public_html' )
let fs = require( 'fs-extra' )
let modules = fs.readdirSync( './main/app/Modules' ) // Make sure the path of your modules are correct

if ( modules && modules.length > 0 ) {
  modules.forEach( module => {
    let path = `./main/app/Modules/${module}/webpack.mix.js`
    if ( fs.existsSync( path ) ) {
      require( path )
    }
  } )
}

// mix.webpackConfig( {
//   entry: {
//     main: [
//       './main/app/Modules/BasicSite/Resources/sass/app.scss',
//       './main/app/Modules/AppUser/Resources/sass/app.scss',
//       './main/app/Modules/Admin/Resources/sass/app.scss'
//     ]
//   }
// } );

mix
  .options( {
    // processCssUrls: false,
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
  .version()
  .mergeManifest();

// if ( !mix.inProduction() ) {
//   mix.sourceMaps();
// }
