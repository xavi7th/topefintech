window._ = require( 'lodash' )
window.swal = require( 'sweetalert2' )

window.Toast = swal.mixin( {
    toast: true,
    position: 'top-end', //'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', or 'bottom-end'
    showConfirmButton: false,
    timer: 5000,
    icon: "success"
} );

let timerInterval;

window.ToastLarge = swal.mixin( {
    icon: "success",
    title: 'To be implemented!',
    html: 'I will close in <b></b> milliseconds.',
    timer: 3000,
    timerProgressBar: true,
    onBeforeOpen: () => {
        swal.showLoading()
        // timerInterval = setInterval( () => {
        //     const content = swal.getContent()
        //     if ( content ) {
        //         const b = content.querySelector( 'b' )
        //         if ( b ) {
        //             b.textContent = Swal.getTimerLeft()
        //         }
        //     }
        // }, 100 )
    },
    // onClose: () => {
    //     clearInterval( timerInterval )
    // }
} )

window.BlockToast = swal.mixin( {
    showConfirmButton: true,
    onBeforeOpen: () => {
        swal.showLoading()
    },
    showCloseButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false
} );

window.swalPreconfirm = swal.mixin( {
    title: 'Are you sure?',
    text: "Implement this when you call the mixin",
    icon: 'question',
    showCloseButton: false,
    allowOutsideClick: () => !swal.isLoading(),
    allowEscapeKey: false,
    showCancelButton: true,
    focusCancel: true,
    cancelButtonColor: '#d33',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'To be implemented',
    showLoaderOnConfirm: true,
    preConfirm: () => {
        /** Implement this when you call the mixin */
    },
} )
/**
 * Implement this when you call the mixin
 * .then( ( result ) => {} );
 */


import {
    InertiaApp
} from '@inertiajs/inertia-vue'
import Vue from 'vue'
import Vue2Filters from 'vue2-filters'
import LoadScript from 'vue-plugin-load-script'
import route from 'ziggy';
import FlashMessage from '@dashboard-components/partials/FlashMessage'
import Modal from '@dashboard-components/partials/Modal'
import Dayjs from '@dashboard-assets/js/timeFormat';

Vue.prototype.$route = ( ...args ) => route( ...args ).url()
Vue.prototype.$isCurrentUrl = ( ...args ) => route().current( ...args )
Vue.prototype.$urlExists = ( ...args ) => route().check( ...args )

Vue.component( 'FlashMessage', FlashMessage );
Vue.component( 'Modal', Modal );

Vue.use( Vue2Filters )
Vue.use( LoadScript )
Vue.use( InertiaApp )
Vue.use( Dayjs );

/** ADD A NEW CURRENCY FILTER **/
Vue.filter( 'Naira', function ( value, symbol ) {
    let currency = Vue.filter( 'currency' )
    symbol = '₦'
    return currency( value, symbol, 2, {
        thousandsSeparator: ',',
        decimalSeparator: '.'
    } )
} )

const app = document.getElementById( 'app' )

new Vue( {
    render: h => h( InertiaApp, {
        props: {
            initialPage: JSON.parse( app.dataset.page ),
            resolveComponent: str => {
                let [ section, module ] = _.split( str, ',' );

                return import(
                        /* webpackChunkName: "js/[request]" */
                        /* webpackPrefetch: true */
                        `../../../${section}/Resources/js/components/${module}.vue` )
                    .then( module => module.default ).catch( err => {
                        if ( err.code == "MODULE_NOT_FOUND" ) {
                            console.log( err );
                            // debugger
                            // location.href = route( 'app.home' ).url()
                        } else {
                            console.error( err );
                        }
                    } )
            },
        },

    } )
} ).$mount( app )
