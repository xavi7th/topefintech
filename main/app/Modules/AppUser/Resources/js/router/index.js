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
            path: 'admin.ui',
            component: view( 'EmptyComponent' ),
            meta: {
                iconClass: 'home',
                menuName: 'Manage UI',
                skip: true
            },
            children: [ {
                path: '/manage-ui/testimonials',
                component: view( 'ui/ManageTestimonials' ),
                name: 'admin.ui.testimonials',
                meta: {
                    title: APP_NAME + ' | Manage Testimonials',
                    iconClass: 'home',
                    menuName: 'Manage Testimonials'
                },
            } ],

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
