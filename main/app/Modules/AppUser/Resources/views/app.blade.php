<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <style>
    .preloader {
      background: #fff;
      bottom: 0;
      height: 100%;
      left: 0;
      position: fixed;
      right: 0;
      top: 0;
      width: 100%;
      z-index: 99999;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .preloader img {
      max-width: 300px;
      margin-bottom: 120px;
    }


    @media (max-width: 767px) {
      ☄.preloader img {
        max-width: 230px;
      }
    }

    .la-ball-circus,
    .la-ball-circus>div {
      position: relative;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }

    .la-ball-circus {
      display: block;
      font-size: 0;
      color: #fff;
    }

    .la-ball-circus>div {
      display: inline-block;
      float: none;
      background-color: currentColor;
      border: 0 solid currentColor;
    }

    .la-ball-circus {
      width: 16px;
      height: 16px;
    }

    .la-ball-circus>div {
      position: absolute;
      top: 0;
      left: -100%;
      display: block;
      width: 16px;
      width: 100%;
      height: 16px;
      height: 100%;
      border-radius: 100%;
      opacity: .5;
      -webkit-animation: ball-circus-position 2.5s infinite cubic-bezier(0.25, 0, 0.75, 1), ball-circus-size 2.5s infinite cubic-bezier(0.25, 0, 0.75,
          1);
      -moz-animation: ball-circus-position 2.5s infinite cubic-bezier(0.25, 0, 0.75, 1), ball-circus-size 2.5s infinite cubic-bezier(0.25, 0, 0.75, 1);
      -o-animation: ball-circus-position 2.5s infinite cubic-bezier(0.25, 0, 0.75,
          1), ball-circus-size 2.5s infinite cubic-bezier(0.25, 0, 0.75, 1);
      animation: ball-circus-position 2.5s infinite cubic-bezier(0.25, 0, 0.75, 1), ball-circus-size 2.5s infinite cubic-bezier(0.25, 0, 0.75, 1);
    }

    .la-ball-circus>div:nth-child(1) {
      -webkit-animation-delay: 0s, -0.5s;
      -moz-animation-delay: 0s, -0.5s;
      -o-animation-delay: 0s, -0.5s;
      animation-delay: 0s, -0.5s;
    }

    .la-ball-circus>div:nth-child(2) {
      -webkit-animation-delay: -0.5s, -1s;
      -moz-animation-delay: -0.5s, -1s;
      -o-animation-delay: -0.5s, -1s;
      animation-delay: -0.5s, -1s;
    }

    .la-ball-circus>div:nth-child(3) {
      -webkit-animation-delay: -1s, -1.5s;
      -moz-animation-delay: -1s, -1.5s;
      -o-animation-delay: -1s, -1.5s;
      animation-delay: -1s, -1.5s;
    }

    .la-ball-circus>div:nth-child(4) {
      -webkit-animation-delay: -1.5s, -2s;
      -moz-animation-delay: -1.5s, -2s;
      -o-animation-delay: -1.5s, -2s;
      animation-delay: -1.5s, -2s;
    }

    .la-ball-circus>div:nth-child(5) {
      -webkit-animation-delay: -2s, -2.5s;
      -moz-animation-delay: -2s, -2.5s;
      -o-animation-delay: -2s, -2.5s;
      animation-delay: -2s, -2.5s;
    }

    .la-ball-circus.la-2x {
      width: 32px;
      height: 32px;
      left: 0;
      top: 0;
      right: 0;
      margin: auto;
      bottom: 0;
      position: absolute;
    }

    .la-ball-circus.la-2x>div {
      width: 32px;
      height: 32px;
    }

    /*! CSS Used keyframes */
    @-webkit-keyframes ball-circus-position {
      50% {
        left: 100%;
      }
    }

    @-moz-keyframes ball-circus-position {
      50% {
        left: 100%;
      }
    }

    @-o-keyframes ball-circus-position {
      50% {
        left: 100%;
      }
    }

    @keyframes ball-circus-position {
      50% {
        left: 100%;
      }
    }

    @-webkit-keyframes ball-circus-size {
      50% {
        -webkit-transform: scale(0.3, 0.3);
        transform: scale(0.3, 0.3);
      }
    }

    @-moz-keyframes ball-circus-size {
      50% {
        -moz-transform: scale(0.3, 0.3);
        transform: scale(0.3, 0.3);
      }
    }

    @-o-keyframes ball-circus-size {
      50% {
        -o-transform: scale(0.3, 0.3);
        transform: scale(0.3, 0.3);
      }
    }

    @keyframes ball-circus-size {
      50% {
        -webkit-transform: scale(0.3, 0.3);
        -moz-transform: scale(0.3,
            0.3);
        -o-transform: scale(0.3, 0.3);
        transform: scale(0.3, 0.3);
      }
    }
  </style>
  <style>
*,:after,:before{box-sizing:border-box;}
h2{margin-top:0;margin-bottom:.5rem;}
p{margin-top:0;margin-bottom:1rem;}
a{color:#007bff;text-decoration:none;background-color:transparent;}
a:hover{color:#0056b3;text-decoration:underline;}
img{border-style:none;}
img{vertical-align:middle;}
label{display:inline-block;margin-bottom:.5rem;}
button{border-radius:0;}
button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color;}
button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit;}
button,input{overflow:visible;}
button{text-transform:none;}
[type=submit],button{-webkit-appearance:button;}
[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none;}
input[type=checkbox]{box-sizing:border-box;padding:0;}
h2{margin-bottom:.5rem;font-weight:500;line-height:1.2;}
h2{font-size:26px;font-size:2rem;}
.display-3{font-size:58.5px;font-size:4.5rem;}
.display-3,.display-4{font-weight:300;line-height:1.2;}
.display-4{font-size:45.5px;font-size:3.5rem;}
.row{display:flex;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;}
.col-12,.col-sm-12{position:relative;width:100%;padding-right:15px;padding-left:15px;}
.col-12{flex:0 0 100%;max-width:100%;}
@media (min-width:576px){
.col-sm-12{flex:0 0 100%;max-width:100%;}
}
.form-control{display:block;width:100%;height:calc(1.5em + .75rem + 2px);padding:.375rem .75rem;font-size:13px;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
@media (prefers-reduced-motion:reduce){
.form-control{transition:none;}
}
.form-control::-ms-expand{background-color:transparent;border:0;}
.form-control:-moz-focusring{color:transparent;text-shadow:0 0 0 #495057;}
.form-control:focus{color:#495057;background-color:#fff;border-color:#80bdff;outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25);}
.form-control::-moz-placeholder{color:#6c757d;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;}
.form-control:-ms-input-placeholder{color:#6c757d;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;}
.form-control::placeholder{color:#6c757d;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;}
.form-control:disabled{background-color:#e9ecef;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;}
.btn{display:inline-block;font-weight:400;color:#212529;text-align:center;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:13px;font-size:1rem;line-height:1.5;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
@media (prefers-reduced-motion:reduce){
.btn{transition:none;}
}
.btn:hover{color:#212529;text-decoration:none;}
.btn:focus{outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25);}
.btn:disabled{-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";opacity:.65;}
.btn-brand{color:#fff;background-color:#725ec3;border-color:#725ec3;}
.btn-brand:focus,.btn-brand:hover{color:#fff;background-color:#5b44b7;border-color:#5641ad;}
.btn-brand:focus{box-shadow:0 0 0 .2rem rgba(135,118,204,.5);}
.btn-brand:disabled{color:#fff;background-color:#725ec3;border-color:#725ec3;}
.btn-block{display:block;width:100%;}
.custom-control{position:relative;display:block;min-height:19.5px;min-height:1.5rem;padding-left:1.5rem;}
.custom-control-input{position:absolute;left:0;z-index:-1;width:13px;width:1rem;height:16.25px;height:1.25rem;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;}
.custom-control-input:checked~.custom-control-label:before{color:#fff;border-color:#007bff;background-color:#007bff;}
.custom-control-input:focus~.custom-control-label:before{box-shadow:0 0 0 .2rem rgba(0,123,255,.25);}
.custom-control-input:disabled~.custom-control-label{color:#6c757d;}
.custom-control-input:disabled~.custom-control-label:before{background-color:#e9ecef;}
.custom-control-label{position:relative;margin-bottom:0;vertical-align:top;}
.custom-control-label:before{pointer-events:none;background-color:#fff;border:1px solid #adb5bd;}
.custom-control-label:after,.custom-control-label:before{position:absolute;top:3.25px;top:.25rem;left:-19.5px;left:-1.5rem;display:block;width:13px;width:1rem;height:13px;height:1rem;content:"";}
.custom-control-label:after{background:no-repeat 50%/50% 50%;}
.custom-checkbox .custom-control-label:before{border-radius:.25rem;}
.custom-checkbox .custom-control-input:checked~.custom-control-label:after{background-image:url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z'/%3E%3C/svg%3E");}
.custom-checkbox .custom-control-input:disabled:checked~.custom-control-label:before{background-color:rgba(0,123,255,.5);}
.custom-control-label:before{transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
@media (prefers-reduced-motion:reduce){
.custom-control-label:before{transition:none;}
}
.d-flex{display:flex!important;}
.flex-wrap{flex-wrap:wrap!important;}
.justify-content-start{justify-content:flex-start!important;}
.justify-content-center{justify-content:center!important;}
.align-items-center{align-items:center!important;}
.text-center{text-align:center!important;}
@media print{
*,:after,:before{text-shadow:none!important;box-shadow:none!important;}
a:not(.btn){text-decoration:underline;}
img{page-break-inside:avoid;}
h2,p{orphans:3;widows:3;}
h2{page-break-after:avoid;}
}
.rui-main{overflow:hidden;background:#555ba0;}
.bg-image{position:absolute;top:0;right:0;bottom:0;left:0;overflow:hidden;background-position:50% 50%;background-size:cover;z-index:-1;}
.bg-image>*{position:absolute;top:0;right:0;bottom:0;left:0;background-position:50% 50%;background-size:cover;z-index:1;}
a{color:#725ec3;transition:color .1s ease-in-out;}
a:hover{color:#438;text-decoration:none;}
a:active{color:#725ec3;}
p{margin-top:-5px;margin-bottom:1.8rem;}
label{margin-bottom:.7rem;font-weight:400;color:#6c757d;}
h2{margin-bottom:1.7rem;font-family:Nunito Sans,sans-serif;font-weight:400;line-height:1.5;color:#393f49;text-transform:none;letter-spacing:normal;}
h2{margin-top:-4px;font-size:19.994px;font-size:1.538rem;}
.display-3,.display-4{font-weight:300;text-transform:none;letter-spacing:normal;}
.display-3{margin-top:-7px;margin-bottom:1.45rem;font-size:35.997px;font-size:2.769rem;}
.display-4{margin-top:-5px;margin-bottom:1.55rem;font-size:28.002px;font-size:2.154rem;}
.row.vertical-gap{margin-top:-30px;}
.row.vertical-gap>[class*=col-]{padding-top:30px;}
.row.sm-gap{margin-right:-10px;margin-left:-10px;}
.row.sm-gap>[class*=col-]{padding-right:10px;padding-left:10px;}
.row.sm-gap.vertical-gap{margin-top:-20px;}
.row.sm-gap.vertical-gap>[class*=col-]{padding-top:20px;}
.text-2{color:#4b515b!important;}
.text-grey-5{color:#bcbec0!important;}
.bg-grey-1{background-color:#f8f9fa!important;}
.text-center{text-align:center;}
.fs-13{font-size:13px!important;}
.mt-20{margin-top:20px!important;}
.mb-10{margin-bottom:10px!important;}
.rui-sign{display:flex;flex-direction:column;}
.rui-sign{min-height:100vh;}
.rui-sign .rui-sign-form{max-width:380px;padding:30px;}
.rui-sign .rui-sign-form-cloud{max-width:400px;padding:40px;background-color:#fff;border-radius:.25rem;box-shadow:0 3px 10px rgba(0,0,0,.03);}
.rui-sign a:not(.btn){color:#bcbec0;}
.rui-sign a:not(.btn):hover{color:#4b515b;text-decoration:none;}
.btn{position:relative;display:inline-flex;align-items:stretch;padding:9px 15px;font-size:11px;font-weight:700;text-transform:uppercase;}
.btn.text-center{justify-content:center;}
.form-control::-moz-placeholder,::-moz-placeholder{color:#a4a6a8;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;will-change:opacity;-moz-transition:opacity .15s ease-in-out;transition:opacity .15s ease-in-out;}
.form-control:-ms-input-placeholder,:-ms-input-placeholder{color:#a4a6a8;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;will-change:opacity;-ms-transition:opacity .15s ease-in-out;transition:opacity .15s ease-in-out;}
.form-control::-moz-placeholder,::-moz-placeholder{color:#a4a6a8;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;will-change:opacity;-moz-transition:opacity .15s ease-in-out;transition:opacity .15s ease-in-out;}
.form-control:-ms-input-placeholder,:-ms-input-placeholder{color:#a4a6a8;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;will-change:opacity;-ms-transition:opacity .15s ease-in-out;transition:opacity .15s ease-in-out;}
.form-control::placeholder,::placeholder{color:#a4a6a8;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";opacity:1;will-change:opacity;transition:opacity .15s ease-in-out;}
button:focus{outline:0;}
.form-control{min-height:36px;padding:7.5px 17px 9px;background-color:#fbfcfc;border-color:#e6ecf0;}
.form-control:focus{background-color:#fbfcfc;border-color:rgba(114,94,195,.6);box-shadow:0 0 0 .2rem rgba(114,94,195,.2);}
.form-control:disabled{background-color:#f3f4f7;border-color:#e6ecf0;}
.custom-control{padding-left:2rem;}
.custom-control-label:after,.custom-control-label:before{top:3.9px;top:.3rem;left:-26px;left:-2rem;width:calc(1rem + 3px);height:calc(1rem + 3px);}
.custom-control-label:before{background-color:#d7d9e0;border-color:#d7d9e0;}
.custom-checkbox .custom-control-input:checked~.custom-control-label:before{background-color:#725ec3;border-color:#725ec3;}
.custom-checkbox .custom-control-input:focus~.custom-control-label:before{box-shadow:none;}
.custom-checkbox .custom-control-input:disabled~.custom-control-label{color:#a4a6a8;}
.custom-checkbox .custom-control-input:disabled~.custom-control-label:before{background-color:#eaecf0;border-color:#eaecf0;}
/*! CSS Used from: Embedded */
.rui-sign .rui-sign-form-cloud{max-width:450px;}
  </style>

  {{-- @routes(['appuser', 'basic'])  --}}


</head>

<body>
  <div class="preloader text-center">
    <img src="/img/logo.png" alt="" width="200">
    <div class="la-ball-circus la-2x">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>

  @inertia

  <link rel="stylesheet" href="{{ mix('css/user-app.css') }}">
  <script src="{{ mix('js/dashboard-app-vendor.js') }}" defer></script>
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor.js') }}" defer></script>
  <script src="{{ mix('js/dashboard-app.js') }}" defer></script>
</body>

</html>
