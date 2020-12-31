const mix = require( 'laravel-mix' );

mix.webpackConfig( {
    resolve: {
        extensions: [ '.js', '.vue', '.json' ],
        alias: {
            '@dashboard-components': __dirname + '/Resources/js/components',
            '@dashboard-assets': __dirname + '/Resources',
        },
    },
} )
mix.copyDirectory( __dirname + '/Resources/img', 'public_html/img' );
// mix.copyDirectory( __dirname + '/Resources/fonts', 'public_html/fonts' );

mix.scripts( [
    __dirname + '/Resources/js/vendor/jquery.min.js',
    __dirname + '/Resources/js/vendor/popper.min.js',
    __dirname + '/Resources/js/vendor/bootstrap.min.js',
    __dirname + '/Resources/js/vendor/feather.min.js',
    __dirname + '/Resources/js/vendor/jquery.overlayScrollbars.min.js',
    __dirname + '/Resources/js/vendor/ofi.min.js',
    __dirname + '/Resources/js/vendor/jquery.fancybox.min.js',
    // __dirname + '/Resources/js/vendor/emojione.min.js',
    // __dirname + '/Resources/js/vendor/emojionearea.min.js',
    __dirname + '/Resources/js/vendor/moment.min.js',
    __dirname + '/Resources/js/vendor/swiper.min.js',
    // __dirname + '/Resources/js/vendor/Chart.min.js',
    __dirname + '/Resources/js/vendor/chartist.min.js',
    __dirname + '/Resources/js/vendor/jquery.dataTables.min.js',
    __dirname + '/Resources/js/vendor/all.js',
    __dirname + '/Resources/js/vendor/v4-shims.js',
    __dirname + '/Resources/js/vendor/jquery.datetimepicker.full.min.js',
], 'public_html/js/dashboard-app-vendor.js' );

mix.scripts( [
    __dirname + '/Resources/js/vendor/yaybar.js',
    __dirname + '/Resources/js/vendor/rootui.js',
    __dirname + '/Resources/js/vendor/rootui-init.js',
], 'public_html/js/user-dashboard-init.js' );

mix.js( __dirname + '/Resources/js/app.js', 'js/dashboard-app.js' ).vue()

mix.sass(__dirname + '/Resources/sass/app.scss', 'css/user-app.css')
