require( '@basicsite-assets/js/bootstrap' )
import {
    InertiaApp
} from '@inertiajs/inertia-vue'
import Vue from 'vue'
import Vue2Filters from 'vue2-filters'
import LoadScript from 'vue-plugin-load-script'
import route from 'ziggy';
import FlashMessage from '@dashboard-components/partials/FlashMessage'
import Modal from '@dashboard-components/partials/Modal'

Vue.prototype.$route = ( ...args ) => route( ...args ).url()
Vue.prototype.$isCurrentUrl = ( ...args ) => route().current( ...args )

Vue.component( 'FlashMessage', FlashMessage );
Vue.component( 'Modal', Modal );

Vue.use( Vue2Filters )
Vue.use( LoadScript )
Vue.use( InertiaApp )

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
            resolveComponent: name => import( /* webpackChunkName: "js/admin-" */ `./components/${name}.vue` )
                .then( module => module.default ).catch( err => {
                    debugger
                    if ( err.code == "MODULE_NOT_FOUND" ) {
                        location.href = route( 'admin.dashboard' ).url()
                    } else {
                        console.error( err );
                    }
                } ),
        },
    } ),
} ).$mount( app )
