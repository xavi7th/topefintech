require( '@basicsite-assets/js/bootstrap' )

import {
    InertiaApp
} from '@inertiajs/inertia-vue'
import Vue from 'vue'
import Vue2Filters from 'vue2-filters'
import LoadScript from 'vue-plugin-load-script'
import route from 'ziggy';

Vue.prototype.$route = ( ...args ) => route( ...args ).url()

Vue.use( Vue2Filters )
Vue.use( LoadScript )
Vue.use( InertiaApp )

let mediaHandler = () => {
    if ( window.matchMedia( '(max-width: 767px)' ).matches ) {
        /** Mobile **/
    } else {
        /** Desktop **/
    }
    /** To set up a watcher **/
    // window.matchMedia( '(min-width: 992px)' ).addEventListener( "change", () => {
    // 	console.log( 'changed' )
    // } )
}

const app = document.getElementById( 'app' )

new Vue( {
    render: h => h( InertiaApp, {
        props: {
            initialPage: JSON.parse( app.dataset.page ),
            resolveComponent: name => import( /* webpackChunkName: "js/user-" */ `./components/${name}.vue` )
                .then( module => module.default ),
        },
    } ),
} ).$mount( app )
