import Vue from 'vue'
import Router from 'vue-router'

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * @param  {string}   name     the filename (basename) of the view to load.
 */
function view( name ) {
    return function ( resolve ) {
        require( [ '@dashboard-components/' + name ], resolve )
    }
}

Vue.use( Router )

const APP_NAME = 'SampleSite Dashboard'

export default new Router( {
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior( to, from, savedPosition ) {
        if ( savedPosition ) {
            return savedPosition
        } else {
            return {
                x: 0,
                y: 0,
            }
        }
    },
    routes: [ {
            path: '/register',
            component: view( 'auth/Register' ),
            name: 'dashboard.register',
            meta: {
                title: 'Register | ' + APP_NAME,
            },
        },
        {
            path: '/login',
            component: view( 'auth/Login' ),
            name: 'dashboard.login',
            meta: {
                title: 'Login | ' + APP_NAME,
            },
        },
        {
            path: '/user/dashboard',
            component: view( 'dashboard/UserDashboard' ),
            name: 'dashboard.root',
            meta: {
                title: APP_NAME,
            },
        },
        // {
        // 	path: '/user/invest-funds',
        // 	component: view( 'dashboard/InvestFunds' ),
        // 	name: 'dashboard.invest',
        // 	meta: {
        // 		title: 'Invest Funds | ' + APP_NAME,
        // 	},
        // },
        {
            path: '/user/make-withdrawal',
            component: view( 'dashboard/MakeWithdrawal' ),
            name: 'dashboard.withdraw',
            meta: {
                title: 'Withdraw Funds | ' + APP_NAME,
            },
        },
        {
            path: '/user/profile',
            component: view( 'dashboard/UserProfile' ),
            name: 'dashboard.profile',
            meta: {
                title: 'My Profile | ' + APP_NAME,
            },
        },
        {
            path: '*',
            redirect: {
                name: 'dashboard.root'
            }
        }
    ],
} )
