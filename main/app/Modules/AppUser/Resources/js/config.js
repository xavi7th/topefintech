export const mixins = {
    beforeDestroy() {
        this.$unloadScript( "/js/user-dashboard-init.js" );
    },
    mounted() {
        this.$loadScript( '/js/user-dashboard-init.js' ).then( () => {
            $( '.preloader' ).delay( 600 ).fadeOut( 300 );
        } )
    },
}
