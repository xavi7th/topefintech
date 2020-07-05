<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/vendor/img/favicon.png">
  <style>
    .preloader {
      background: #24b3ff;
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
    .slide-left-enter-active,
    .slide-left-leave-active,
    .slide-right-enter-active,
    .slide-right-leave-active {
      transition-duration: 0.5s;
      transition-property: height, opacity, transform;
      transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
      overflow: hidden;
    }

    .slide-left-enter,
    .slide-right-leave-active {
      opacity: 0;
      transform: translate(2em, 0);
    }

    .slide-left-leave-active,
    .slide-right-enter {
      opacity: 0;
      transform: translate(-2em, 0);
    }

    .slide-out-in-enter-active {
      transition: all .3s ease;
    }

    .slide-out-in-leave-active {
      transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .slide-out-in-enter,
    .slide-out-in-leave-to {
      transform: translateX(80%);
      opacity: 0;
    }

    .nav-transition-enter-active {
      transition: all 0.5s ease;
    }

    .nav-transition-leave-active {
      transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
    }

    .nav-transition-enter,
    .nav-transition-leave-to

    /* .nav-transition-leave-active below version 2.1.8 */
      {
      transform: translateY(-10px);
      opacity: 0;
    }
  </style>
  @routes(['admin', 'basic'])
  <script src="{{ mix('js/dashboard-app-vendor.js') }}" defer></script>
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor.js') }}" defer></script>
  <script src="{{ mix('js/admin-app.js') }}" defer></script>
</head>

<body>
  <div class="preloader text-center">
    <img src="/img/logo-white.png" alt="">
    <div class="la-ball-circus la-2x">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
  @inertia
</body>

</html>
