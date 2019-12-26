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
                menuName: 'Register',
                skip: true
            },
        },
        {
            path: '/login',
            component: view( 'auth/Login' ),
            name: 'dashboard.login',
            meta: {
                title: 'Login | ' + APP_NAME,
                menuName: 'Login',
                iconClass: 'fa fa-home',
                skip: true
            },
        },
        {
            path: '/user/dashboard',
            component: view( 'dashboard/UserDashboard' ),
            name: 'dashboard.root',
            meta: {
                title: APP_NAME,
                menuName: 'Dashboard',
                iconClass: 'fas fa-th-large',
            },
        },
        {
            path: '/savings',
            component: view( 'EmptyComponent' ),
            meta: {
                iconClass: 'fa fa-piggy-bank',
                menuName: 'Savings',
            },
            children: [ {
                    path: '/savings/add',
                    component: view( 'savings/AddSavings' ),
                    name: 'savings.add',
                    meta: {
                        title: APP_NAME + ' | Add Savings',
                        menuName: 'Add to Savings'
                    },
                },
                {
                    path: '/savings/autosave-settings',
                    component: view( 'savings/AutosaveSettings' ),
                    name: 'savings.autosave-settings',
                    meta: {
                        title: APP_NAME + ' | Autosave Settings',
                        menuName: 'Autosave Settings'
                    },
                },
                {
                    path: '/savings/savings-distribution',
                    component: view( 'savings/SavingsDistribution' ),
                    name: 'savings.savings-distribution',
                    meta: {
                        title: APP_NAME + ' | Savings Distribution',
                        menuName: 'Savings Distribution'
                    },
                },
                {
                    path: '/savings/savings-log',
                    component: view( 'savings/SavingsLog' ),
                    name: 'savings.savings-log',
                    meta: {
                        title: APP_NAME + ' | Savings Log',
                        menuName: 'Savings Log'
                    },
                },
            ],

        },
        {
            path: '/smart-loans',
            component: view( 'EmptyComponent' ),
            meta: {
                iconClass: 'fa fa-hand-holding-usd',
                menuName: 'Smart Loans',
            },
            children: [ {
                    path: '/loans/eligibility',
                    component: view( 'loans/CheckEligibility' ),
                    name: 'loans.add',
                    meta: {
                        title: APP_NAME + ' | Check Loan Eligibility',
                        menuName: 'Check Eligibility'
                    },
                },
                {
                    path: '/loans/request-for-surety',
                    component: view( 'loans/SuretyRequest' ),
                    name: 'loans.surety',
                    meta: {
                        title: APP_NAME + ' | Requests for Surety',
                        menuName: 'Requests for Surety'
                    },
                },
                {
                    path: '/loans/log',
                    component: view( 'loans/LoansLog' ),
                    name: 'loans.log',
                    meta: {
                        title: APP_NAME + ' | Loans Log',
                        menuName: 'Loans Log'
                    },
                },
            ],

        },
        {
            path: '/admins/:id/route-permissions',
            component: view( 'dashboard/ManageAdmins' ),
            name: 'admin.admins.permissions',
            props: true,
            meta: {
                title: APP_NAME + ' | View Admin Permissions',
                iconClass: 'home',
                menuName: 'View Admin Permission',
                skip: true
            },
        },

        {
            path: '/user/profile',
            component: view( 'dashboard/UserProfile' ),
            name: 'dashboard.profile',
            meta: {
                title: 'My Profile | ' + APP_NAME,
                menuName: 'Profile',
                skip: true
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
