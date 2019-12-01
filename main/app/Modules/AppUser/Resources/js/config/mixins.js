import {
    verifyAuth,
    getAccDetails
}
from "@dashboard-assets/js/config/endpoints";
export default {
    data: () => ( {

    } ),
    beforeRouteLeave( to, from, next ) {
        this.$emit( 'is-leaving' )
        next()
    },
    beforeDestroy() {
        this.$unloadScript( "/js/dashboard-main.js" );
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
        },
        getAccDetails() {
            axios.get( getAccDetails ).then( ( {
                data
            } ) => {
                sessionStorage.setItem( 'userDetails', JSON.stringify( data ) )

            } )
        }

    },
    computed: {
        userDetails() {
            return JSON.parse( sessionStorage.getItem( 'userDetails' ) ) || {};
        },
        profitDetails() {
            return JSON.parse( sessionStorage.getItem( 'profitTransactions' ) ) || {};
        }
    }
}
