mix.setPublicPath( './public_html' );

if ( mix.inProduction() ) {
  mix.version()
    .then( () => {
      const convertToFileHash = require( "laravel-mix-make-file-hash" );
      convertToFileHash( {
        debug: true,
        publicPath: "./public_html",
        manifestFilePath: "./public_html/mix-manifest.json",
        blacklist: [ "user-*", "public*", "super-*" ],
        keepBlacklistedEntries: true
      } );
    } );
}
