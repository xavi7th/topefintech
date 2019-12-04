import Vue from 'vue'
import VueRouter from 'vue-router'
import {
    siteRootUrl,
    siteContactUs,
    sitePrivacy,
    siteTerms,
}
from '@basicsite-assets/js/config'

// import App from '@basicsite-components/AppComponent'

Vue.use( VueRouter )

const APP_NAME = 'Amju Unique Micro Finance Bank'

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
                path: siteRootUrl,
                component: view( 'HomePage' ),
                name: 'site.root',
                meta: {
                    title: APP_NAME,
                    navSkip: true
                },
            },
            {
                path: '/personal',
                component: view( 'misc/EmptyComponent' ),
                children: [ {
                        path: '',
                        /** Empty path resolves to /home */
                        component: view( 'pb/PersonalBankingPage' ),
                        name: 'site.pb',
                        meta: {
                            title: 'Personal Banking - ' + APP_NAME,
                            breadcrumb: 'Personal Banking'
                        },
                    },
                    {
                        path: siteRootUrl,
                        component: view( 'pb/AmjuEdusaveSavingsPage' ),
                        name: 'site.pb.edusave',
                        meta: {
                            title: 'Amju Edusave Savings - ' + APP_NAME,
                            breadcrumb: 'Amju Edusave Savings'
                        },
                    }
                ]
            },

            {
                path: siteContactUs,
                component: view( 'ContactUsPage' ),
                name: 'site.contact',
                meta: {
                    title: 'Contacts - ' + APP_NAME,
                    breadcrumb: 'Contact Us',
                    navSkip: true
                },
            },

            {
                path: sitePrivacy,
                component: view( 'PrivacyPage' ),
                name: 'site.privacy',
                meta: {
                    title: 'Privacy - ' + APP_NAME,
                    breadcrumb: 'Privacy',
                    navSkip: true
                },
            },
            {
                path: siteTerms,
                component: view( 'TermsPage' ),
                name: 'site.terms',
                meta: {
                    title: 'Terms - ' + APP_NAME,
                    breadcrumb: 'Terms',
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
