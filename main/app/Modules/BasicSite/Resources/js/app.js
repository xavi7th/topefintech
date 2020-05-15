/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require( '@basicsite-assets/js/bootstrap' )


import {
    InertiaApp
} from '@inertiajs/inertia-vue'
import Vue from 'vue'
import VeeValidate from 'vee-validate'
import Vue2Filters from 'vue2-filters'
import LoadScript from 'vue-plugin-load-script'

Vue.use( Vue2Filters )
Vue.use( LoadScript )
Vue.use( VeeValidate )
Vue.use( InertiaApp )

const app = document.getElementById( 'app' )

new Vue( {
    render: h => h( InertiaApp, {
        props: {
            initialPage: JSON.parse( app.dataset.page ),
            resolveComponent: name => require( `./components/${name}` ).default,
        },
    } ),
} ).$mount( app )
