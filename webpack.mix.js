if ( [ 'buildcss', 'buildjs' ].includes( process.env.npm_config_section ) ) {
  require( `${__dirname}/webpack.${process.env.npm_config_section}.mix.js` )
} else {
  console.log(
    '\x1b[41m%s\x1b[0m',
    'Provide correct --section argument to build command: buildcss, buildjs. For example npm --section=buildjs run dev '
  )

  function createError( msg, status ) {
    var err = new Error( msg );
    err.status = status;

    // uncomment this next line to get a clean stack trace in node.js
    // Error.captureStackTrace( err, createError );
    Error.captureStackTrace( err, function () {} );
    return err;
  }

  var err = createError( 'Provide correct --section argument to build command!', 500 );
  throw err;
  // throw new Error(  )
}
