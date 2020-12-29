import Vue from 'vue'
import Vue2Filters from 'vue2-filters'
import { Inertia } from "@inertiajs/inertia";
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import Dayjs from '@dashboard-assets/js/timeFormat';
import LoadScript from 'vue-plugin-load-script'

import Modal from '@dashboard-components/partials/Modal'
import FlashMessage from '@dashboard-components/partials/FlashMessage'

window._ = require( 'lodash' )
window.swal = require( 'sweetalert2' )

window.Toast = swal.mixin( {
    toast: true,
    position: 'top-end', //'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', or 'bottom-end'
    showConfirmButton: false,
    timer: 5000,
    icon: "success"
} );

window.ToastLarge = swal.mixin( {
  icon: "success",
  title: 'To be implemented!',
  html: 'To be implemented',
  timer: 3000,
  timerProgressBar: true,
  onBeforeOpen: () => { swal.showLoading() },
  onClose: () => {}
} )

window.BlockToast = swal.mixin( {
  showConfirmButton: true,
  onBeforeOpen: () => { swal.showLoading()},
  showCloseButton: false,
  allowOutsideClick: false,
  allowEscapeKey: false
} );

window.swalPreconfirm = swal.mixin( {
    title: 'Are you sure?',
    text: "Implement this when you call the mixin",
    icon: 'question',
    showCloseButton: false,
    allowOutsideClick: () => !swal.isLoading(),
    allowEscapeKey: false,
    showCancelButton: true,
    focusCancel: true,
    cancelButtonColor: '#d33',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'To be implemented',
    showLoaderOnConfirm: true,
    preConfirm: () => {
        /** Implement this when you call the mixin */
    },
} )

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#8180e0',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: true,
})

Inertia.on('progress', (event) => {
  console.log(event);
  if (event.detail.progress.percentage) {
    NProgress.set((event.detail.progress.percentage / 100) * 0.9)
  }
})

Inertia.on('success', (event) => {
  console.log(event);
  console.log(`Successfully made a visit to ${event.detail.page.url}`)
  if (event.detail.page.props.flash.success) {
    ToastLarge.fire( {
      title: "Success",
      html: event.detail.page.props.flash.success,
      icon: "success",
      timer: 3000
    } );
  }
  else if (event.detail.page.props.flash.error) {
    ToastLarge.fire( {
      title: "Error",
      html: event.detail.page.props.flash.error,
      icon: "error",
      timer: 3000
    } );
  }
})

Inertia.on('error', (errors) => {
  console.log(`There were errors on your visit`)
  console.log(errors)
  ToastLarge.fire( {
    title: "Error",
    html: getErrorString( errors ),
    icon: "error",
    timer:10000 //milliseconds
  } );
})

Inertia.on('invalid', (event) => {
  console.log(`An invalid Inertia response was received.`)

  console.log(event);

  event.preventDefault()
  Toast.fire({
    position: 'top',
    title: 'Oops!',
    text: event.detail.response.statusText,
    icon:'error'
  })
})

Inertia.on('exception', (event) => {
  console.log(event);
  console.log(`An unexpected error occurred during an Inertia visit.`)
  console.log(event.detail.error)
})

Inertia.on('finish', (event) => {
  console.log(event);
})

Vue.component( 'FlashMessage', FlashMessage );
Vue.component( 'Modal', Modal );

Vue.use(plugin)
Vue.use( Vue2Filters )
Vue.use( LoadScript )
Vue.use( Dayjs );

Vue.filter( 'Naira', function ( value, symbol ) {
    let currency = Vue.filter( 'currency' )
    symbol = '₦'
    return currency( value, symbol, 2, {
        thousandsSeparator: ',',
        decimalSeparator: '.'
    } )
} )

Vue.prototype.$route = ( ...args ) => route( ...args )
Vue.prototype.$isCurrentUrl = ( ...args ) => route().current( ...args )
Vue.prototype.$urlExists = ( ...args ) => route().has( ...args )
Vue.prototype.$urlParams = route().params

const el = document.getElementById('app')

new Vue( {
  render: h => h( App, {
    props: {
      initialPage: JSON.parse( el.dataset.page ),
      resolveComponent: str => {
        let [ module, component ] = _.split( str, ',' );

        return import(
            /* webpackChunkName: "js/[request]" */
            /* webpackPrefetch: true */
            `../../../${module}/Resources/js/components/${component}.vue` )
          .then( module => module.default )
      },
    },
  } )
} ).$mount( el )

/**
 *! Cause back() and forward() buttons of the browser to refresh the browser state
 *? This is to prevent stale data displaying in the browser
 */

// window.addEventListener( 'popstate', () => {
//     Inertia.reload( {
//         preserveScroll: true,
//         preserveState: false
//     } )
// } )
