const {
  CleanWebpackPlugin
} = require( 'clean-webpack-plugin' );

mix.setPublicPath( './public_html' );

mix.webpackConfig( {
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
      /**
       * Simulate the removal of files
       * default: false
       */
      dry: true,
      cleanOnceBeforeBuildPatterns: [ 'js/*', 'css/*', '/img/*', 'fonts/*', 'robots.txt', 'mix-manifest.json' ]

    } ),
  ]
} );
