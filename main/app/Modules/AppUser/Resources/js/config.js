export const mixins = {
    props: {
        app: Object,
        isInertiaRequest: Boolean,
        auth: Object,
        flash: Object,
        errors: Object
    },
    beforeDestroy() {
        this.$unloadScript( "/js/user-dashboard-init.js" );
    },
    mounted() {
        this.$loadScript( '/js/user-dashboard-init.js' ).then( () => {
            $( '.preloader' ).delay( 600 ).fadeOut( 300 );
        } )
    },
}
