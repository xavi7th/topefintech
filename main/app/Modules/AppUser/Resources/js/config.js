export const apiDomain = '/user/api/'
/**
 * @param {string} url
 */
export const rootUrl = url => '/user/' + ( url || '' )
export const apiRootUrl = url => apiDomain + ( url || '' )

export const logout = ( msg = null ) => {
    if ( !msg ) {
        msg = 'Logging you out....'
    }
    swal.fire( {
        text: msg,
        showCloseButton: false,
        showConfirmButton: false,
    } )
    sessionStorage.clear()
    axios.post( '/logout' ).then( rsp => {
        location.reload()
    } )
}

export const dashboardRootUrl = rootUrl()
export const siteRegister = 'register'
export const siteLogin = 'login'
export const verifyAuth = rootUrl( 'auth/verify' )



/**
 * API endpoints
 */
export const userDashboard = apiRootUrl( 'dashboard' )



/**
 * ! MIXINS
 */

export const mixins = {
    data: () => ( {

    } ),
    beforeRouteLeave( to, from, next ) {
        this.$emit( 'is-leaving' )
        next()
    },
    beforeDestroy() {
        this.$unloadScript( "/js/user-dashboard-main.js" );
    },
    created() {
        let idleTime = ( Date.now() - sessionStorage.getItem( 'LOG_IN_TIME' ) ) / ( 1000 );

        if ( !sessionStorage.getItem( 'LOG_IN_TIME' ) || idleTime > ( 60 * 60 ) ) {
            /**
             * If Idle for 1 hr reverify login
             */
            sessionStorage.setItem( 'LOG_IN_TIME', Date.now() )

            this.verifyAuth()

        }
    },
    mounted() {

    },
    methods: {
        verifyAuth() {
            axios.get( verifyAuth ).then( ( {
                data: {
                    LOGGED_IN
                }
            } ) => {
                if ( !LOGGED_IN ) {
                    this.$router.replace( {
                        name: 'dashboard.login'
                    } )
                } else {
                    this.getAccDetails()
                }
            } )
        }

    },
}
