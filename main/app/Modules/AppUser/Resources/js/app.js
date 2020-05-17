// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import '@basicsite-assets/js/bootstrap';
import Vue from 'vue'
// import VeeValidate from 'vee-validate'
import App from './AppComponent'
// import router from './router'
import LoadScript from 'vue-plugin-load-script'
import Vue2Filters from 'vue2-filters'
import {
    verifyAuth
} from "@dashboard-assets/js/config";

Vue.use( VeeValidate )
Vue.use( Vue2Filters )
Vue.use( LoadScript )

let mediaHandler = () => {
    if ( window.matchMedia( '(max-width: 767px)' ).matches ) {
        /**
         * Mobile
         */
    } else {
        /**
         * Desktop
         */
    }
    /**
     * To set up a watcher
     */
    // window.matchMedia( '(min-width: 992px)' ).addEventListener( "change", () => {
    // 	console.log( 'changed' )
    // } )
}

// axios.get( verifyAuth ).then( ( {
//     data: {
//         LOGGED_IN,
//         user
//     }
// } ) => {

//     Object.defineProperty( Vue.prototype, '$user', {
//         value: user,
//         writable: false
//     } )

//     router.beforeEach( ( to, from, next ) => {
//         document.title = to.meta.title
//         if ( to.path.match( "login" ) || to.path.match( "register" ) ) {
//             next()
//         } else if ( LOGGED_IN ) {
//             next()
//         } else {
//             next( {
//                 name: 'dashboard.login'
//             } )
//         }



//         // store.commit( 'setLoading', true )
//         next()
//     } )

//     router.afterEach( ( to, from ) => {
//         /**
//          * Emit finished loading event?
//          */
//         // store.commit( 'setLoading', false )
//         /**
//          * Handle resize based on the browser size
//          */
//         mediaHandler()
//     } )

//     /* eslint-disable no-new */
//     new Vue( {
//         el: '#app',
//         template: '<App/>',
//         components: {
//             App
//         },
//         router,
//     } )
// } )
