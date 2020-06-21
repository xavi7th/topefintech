window._ = require( 'lodash' )
window.swal = require( 'sweetalert2' )

window.Toast = swal.mixin( {
    toast: true,
    position: 'top-end', //'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', or 'bottom-end'
    showConfirmButton: false,
    timer: 5000,
    icon: "success"
} );

let timerInterval;

window.ToastLarge = swal.mixin( {
    icon: "success",
    title: 'To be implemented!',
    html: 'I will close in <b></b> milliseconds.',
    timer: 3000,
    timerProgressBar: true,
    onBeforeOpen: () => {
        swal.showLoading()
        // timerInterval = setInterval( () => {
        //     const content = swal.getContent()
        //     if ( content ) {
        //         const b = content.querySelector( 'b' )
        //         if ( b ) {
        //             b.textContent = Swal.getTimerLeft()
        //         }
        //     }
        // }, 100 )
    },
    // onClose: () => {
    //     clearInterval( timerInterval )
    // }
} )

window.BlockToast = swal.mixin( {
    showConfirmButton: true,
    onBeforeOpen: () => {
        swal.showLoading()
    },
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
/**
 * Implement this when you call the mixin
 * .then( ( result ) => {} );
 */
