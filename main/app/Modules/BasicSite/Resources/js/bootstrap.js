import Vue from 'vue'
import Vue2Filters from 'vue2-filters'
import { Inertia } from "@inertiajs/inertia";
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import LoadScript from 'vue-plugin-load-script'
import CKEditor from '@ckeditor/ckeditor5-vue2';
import Dayjs from '@dashboard-assets/js/timeFormat';
import { getErrorString } from '@dashboard-assets/js/config';

import Modal from '@dashboard-components/partials/Modal'
import FlashMessage from '@dashboard-components/partials/FlashMessage'

export const editorConfig = (uploadUrl, csrfToken = null) => {
  return {
    toolbar: {
      items: [
        'heading',
        '|',
        'bold',
        'italic',
        'link',
        'underline',
        'superscript',
        'subscript',
        'bulletedList',
        'numberedList',
        '|',
        'indent',
        'outdent',
        'alignment',
        'horizontalLine',
        '|',
        'imageUpload',
        'blockQuote',
        'insertTable',
        'mediaEmbed',
        'undo',
        'redo'
      ]
    },
     placeholder: 'Type the content here!',
    wordCount: {
      onUpdate: stats => {
        // Prints the current content statistics.
        console.log( `Characters: ${ stats.characters }\nWords: ${ stats.words }` );
      }
    },
    image: {
      toolbar: [
        'imageTextAlternative',
        'imageStyle:full',
        'imageStyle:side',
        'imageResize'
      ],
      table: {
        contentToolbar: [
          'tableColumn',
          'tableRow',
          'mergeTableCells'
        ]
      },
      styles: ["full", "side"],
      resizeUnit: "%",
      resizeOptions: [
        {
          name: "imageResize:original",
          value: null,
        },
        {
          name: "imageResize:25",
          value: "25",
        },
        {
          name: "imageResize:50",
          value: "50",
        },
        {
          name: "imageResize:75",
          value: "75",
        },
      ],
    },
    simpleUpload: {
      uploadUrl,

      // Enable the XMLHttpRequest.withCredentials property.
      withCredentials: false,
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        // Authorization: 'Bearer <JSON Web Token>'
      }
    },
  }
}

window._ = require( 'lodash' )
window.swal = require( 'sweetalert2' )

window.Toast = swal.mixin( {
    toast: true,
    position: 'top-end', //'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', or 'bottom-end'
    showConfirmButton: false,
    timer: 5000,
    icon: "success"
})

window.ToastLarge = swal.mixin( {
  icon: "success",
  title: 'To be implemented!',
  html: 'To be implemented',
  timer: 3000,
  timerProgressBar: true,
  onBeforeOpen: () => { swal.showLoading() },
  onClose: () => {}
})

window.BlockToast = swal.mixin( {
  showConfirmButton: true,
  onBeforeOpen: () => { swal.showLoading()},
  showCloseButton: false,
  allowOutsideClick: false,
  allowEscapeKey: false
})

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
})

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
})

Inertia.on('success', (e) => {
  console.log(e);
  console.log(`Successfully made a visit to ${e.detail.page.url}`)
  if (e.detail.page.props.flash.success) {
    ToastLarge.fire( {
      title: "Success",
      html: e.detail.page.props.flash.success,
      icon: "success",
      timer: 3000
    } );
  }
  else if (e.detail.page.props.flash.error) {
    ToastLarge.fire( {
      title: "Error",
      html: e.detail.page.props.flash.error,
      icon: "error",
      timer: 3000
    } );
  }
  else {
    swal.close();
  }
})

Inertia.on('error', (e) => {
  console.log(`There were errors on your visit`)
  console.log(e)
  ToastLarge.fire( {
    title: "Error",
    html: getErrorString( e.detail.errors ),
    icon: "error",
    timer:10000, //milliseconds
    footer: `Our email: &nbsp;&nbsp;&nbsp; <a target="_blank" href="mailto:hello@smartmoniehq.org">hello@smartmoniehq.org</a>`,
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

Inertia.on('finish', (e) => {
  // console.log(e);
})

Vue.component( 'FlashMessage', FlashMessage );
Vue.component( 'Modal', Modal );

Vue.use(plugin)
Vue.use( Vue2Filters )
Vue.use( LoadScript )
Vue.use( Dayjs );
Vue.use( CKEditor )

Vue.filter( 'Naira', function ( value, symbol ) {
    let currency = Vue.filter( 'currency' )
    symbol = '₦'
    return currency( value, symbol, 2, {
        thousandsSeparator: ',',
        decimalSeparator: '.'
    } )
})

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
  })
}).$mount( el )

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
