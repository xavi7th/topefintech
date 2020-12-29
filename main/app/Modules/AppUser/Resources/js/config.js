/**
 * Transforms an error object into HTML string
 *
 * @param {String|Array|null} errors The errors to transform
 */
export const getErrorString = errors => {

    if ( _.isString( errors ) ) {
        var errs = errors;
    } else if ( _.size( errors ) == 1 ) {
        var errs = _.reduce( errors, function ( val, n ) {
            return val;
        } );
    } else {
        var errs = _.reduce( errors, function ( val, n ) {
            return ( _.isString( val ) ? val : val.join( "<br>" ) ) + "<br>" + n;
        } );
    }
    return errs
}

/**
 * Display flash error or success in a sweetalert modal. This should be called before displayErrors()
 *! The function keyword is required to bind this into the function scope
 */
const displayResponse = function ( duration = null ) {

    if ( this.$page.props.flash.error ) {
        ToastLarge.fire( {
            title: "Error",
            html: this.$page.flash.error,
            icon: "error",
            timer: duration || 3000
        } )
    } else if ( this.$page.props.flash.success ) {
        ToastLarge.fire( {
            title: "Success",
            html: this.$page.flash.success,
            icon: "success",
            timer: duration || 3000
        } );
    } else {
        swal.close();
    }
}

/**
 * This displays the laravel error object in a nicely formatted way using sweetalert
 * @param {Number} duration The duration in milliseconds to keep the errors page open
 */
const displayErrors = function ( duration = null ) {
    if ( _.size( this.$page.props.errors ) ) {
        ToastLarge.fire( {
            title: "Error",
            html: getErrorString( this.$page.props.errors ),
            icon: "error",
            timer: duration || 3000 //milliseconds
        } );
    }
}

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

export const errorHandlers = {
    methods: {
        displayErrors,
        displayResponse
    }
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
