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
export const withdrawFunds = apiRootUrl( 'withdraw/request' )
export const withdrawalRequests = apiRootUrl( 'withdraw/requests' )
export const verifyAuth = apiRootUrl( 'auth/verify' )
export const getAccDetails = apiRootUrl( 'profile' )
export const getProfitTransactions = apiRootUrl( 'profits' )



/**
 * API endpoints
 */
export const userDashboard = apiRootUrl( 'dashboard' )
