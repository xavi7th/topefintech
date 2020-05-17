require( '@basicsite-assets/js/bootstrap' )

import {
    InertiaApp
} from '@inertiajs/inertia-vue'
import Vue from 'vue'
// import VeeValidate from 'vee-validate'
import Vue2Filters from 'vue2-filters'
import LoadScript from 'vue-plugin-load-script'
import route from 'ziggy';

Vue.prototype.$route = ( ...args ) => route( ...args ).url()

Vue.use( Vue2Filters )
Vue.use( LoadScript )
// Vue.use( VeeValidate )
Vue.use( InertiaApp )

const app = document.getElementById( 'app' )

new Vue( {
    render: h => h( InertiaApp, {
        props: {
            initialPage: JSON.parse( app.dataset.page ),
            resolveComponent: name => import( /* webpackChunkName: "js/public-" */ `./components/${name}.vue` )
                .then( module => module.default ),
        },
    } ),
} ).$mount( app )
