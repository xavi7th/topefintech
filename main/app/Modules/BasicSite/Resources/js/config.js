let apiDomain = '/api/'
/**
 *
 * @param {string} url
 */
let rootUrl = url => '/' + ( url || '' )
let apiRootUrl = url => apiDomain + ( url || '' )

export const CONSTANTS = {
    facebook: 'smartcoop-facebook',
    twitter: 'smartcoop-twitter',
    instagram: 'smartcoop-instagram',
    facebookMessenger: 'smartcoop-facebook-messenger',
    linkedin: 'smartcoop-linkedin',
    snapchat: 'smartcoop-snapchat',
    phone1: '+2348176233714',
    email: 'hello@smartcoophq.com'
}
/**
 * API endpoints
 */
export const siteInternetBanking = 'https://ibank.amjuuniquemfbng.com/'
export const siteTestimonials = apiRootUrl( 'testimonials' )
export const siteFAQ = apiRootUrl( 'faq' )
export const siteContact = apiRootUrl( 'contact' )
export const siteCreateAccountApi = apiRootUrl( 'account/create' )
