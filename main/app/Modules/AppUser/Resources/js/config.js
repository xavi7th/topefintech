export const mixins = {
    props: {
        app: Object,
        isInertiaRequest: Boolean,
        auth: Object,
        flash: Object,
        errors: Object
    },
    beforeDestroy() {
        // console.log( 'clearing event handlers ...' );

        // var el = document.getElementsByTagName( 'body' )[ 0 ],
        //     clone = el.cloneNode( true );
        // console.log( el );
        // el.parentNode.replaceChild( clone, el );
        this.$unloadScript( "/js/user-dashboard-init.js" );

    },
    destroyed() {

    },
    mounted() {
        // setTimeout( () => {
        this.$loadScript( '/js/user-dashboard-init.js' ).then( () => {
            $( '.preloader' ).delay( 600 ).fadeOut( 300 );
        } )
        // }, 2000 );
    },
}

export const toOrdinalSuffix = num => {
    const int = parseInt( num ),
        digits = [ int % 10, int % 100 ],
        ordinals = [ 'st', 'nd', 'rd', 'th' ],
        oPattern = [ 1, 2, 3, 4 ],
        tPattern = [ 11, 12, 13, 14, 15, 16, 17, 18, 19 ];
    return oPattern.includes( digits[ 0 ] ) && !tPattern.includes( digits[ 1 ] ) ?
        int + ordinals[ digits[ 0 ] - 1 ] :
        int + ordinals[ 3 ];
};
