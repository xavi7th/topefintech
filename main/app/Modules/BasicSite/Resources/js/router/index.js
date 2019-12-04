import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use( VueRouter )

const APP_NAME = 'Smart Coop'

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * @param  {string}   name     the filename (basename) of the view to load.
 */
function view( name ) {
    return function ( resolve ) {
        require( [ '@basicsite-components/' + name ], resolve )
    }
}

export function createRouter() {
    return new VueRouter( {
        mode: 'history',
        linkActiveClass: 'active',
        scrollBehavior( to, from, savedPosition ) {
            if ( to.hash )
                return {
                    selector: to.hash
                }
            else if ( savedPosition ) {
                return savedPosition
            } else {
                return {
                    x: 0,
                    y: 0,
                }
            }
        },
        routes: [ {
                path: '/',
                component: view( 'HomePage' ),
                name: 'site.root',
                meta: {
                    title: APP_NAME,
                    menuName: 'Home',
                    navSkip: true
                },
            },
            {
                path: '/blog',
                component: view( 'OurBlogPage' ),
                name: 'site.blog',
                meta: {
                    title: 'Our Blog - ' + APP_NAME,
                    breadcrumb: 'Our Blog',
                    menuName: 'Blog'
                },
            },
            {
                path: '/frequently-asked-questions',
                component: view( 'FAQPage' ),
                name: 'site.faq',
                meta: {
                    title: 'FAQ - ' + APP_NAME,
                    breadcrumb: 'Frequently Asked Questions',
                    menuName: 'FAQ'
                },
            },
            {
                path: '/careers',
                component: view( 'CareersPage' ),
                name: 'site.career',
                meta: {
                    title: 'Careers - ' + APP_NAME,
                    breadcrumb: 'Work With Us',
                    menuName: 'Careers'
                },
            },
            {
                path: '/contact-us',
                component: view( 'ContactUsPage' ),
                name: 'site.contact',
                meta: {
                    title: 'Contact Us - ' + APP_NAME,
                    breadcrumb: 'Contact Us',
                    menuName: 'Contact Us'
                },
            },

            {
                path: '/privacy',
                component: view( 'PrivacyPage' ),
                name: 'site.privacy',
                meta: {
                    title: 'Privacy - ' + APP_NAME,
                    breadcrumb: 'Privacy',
                    navSkip: true
                },
            },
            {
                path: '/terms-and-conditions',
                component: view( 'TermsPage' ),
                name: 'site.terms',
                meta: {
                    title: 'Terms - ' + APP_NAME,
                    breadcrumb: 'Terms & Conditions',
                    navSkip: true
                },
            },
            {
                path: '/page-not-found',
                component: view( '404Page' ),
                name: 'site.error',
                meta: {
                    title: `404 - ${APP_NAME}`,
                    navSkip: true
                },
            },
            {
                path: '*',
                meta: {
                    navSkip: true
                },
                redirect: {
                    name: 'site.error',
                },
            },
        ],
    } )
}
