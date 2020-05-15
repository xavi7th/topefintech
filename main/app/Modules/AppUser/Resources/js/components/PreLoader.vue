<template>
  <div class="rui-page-preloader" role="status">
    <div class="rui-page-preloader-inner">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
</template>
<style scoped>
  .rui-page-preloader {
    display: none;
  }

  .rui-page-preloader.rui-page-preloader-active {
    position: absolute;
    display: block;
    top: 0;
    right: 0;
    left: 0;
    height: 1px;
    opacity: 0;
    -webkit-transition: opacity 0.3s ease-in-out;
    -o-transition: 0.3s opacity ease-in-out;
    transition: opacity 0.3s ease-in-out;
    z-index: 1002;
  }

  .rui-page-loading-state .rui-page-preloader.rui-page-preloader-active {
    opacity: 1;
  }

  .rui-page-preloader.rui-page-preloader-active .rui-page-preloader-inner {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    height: 100%;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
  }

  .rui-page-preloader.rui-page-preloader-active .rui-page-preloader-inner > div {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    background: #725ec3;
    -webkit-box-shadow: 0 2px 20px #725ec3;
    box-shadow: 0 2px 20px #725ec3;
    -webkit-animation: rui-preloader-animation 0.8s ease infinite alternate;
    animation: rui-preloader-animation 0.8s ease infinite alternate;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:first-child {
    -webkit-animation-delay: 0.08s;
    animation-delay: 0.08s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(2) {
    -webkit-animation-delay: 0.16s;
    animation-delay: 0.16s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(3) {
    -webkit-animation-delay: 0.24s;
    animation-delay: 0.24s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(4) {
    -webkit-animation-delay: 0.32s;
    animation-delay: 0.32s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(5) {
    -webkit-animation-delay: 0.4s;
    animation-delay: 0.4s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(6) {
    -webkit-animation-delay: 0.48s;
    animation-delay: 0.48s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(7) {
    -webkit-animation-delay: 0.56s;
    animation-delay: 0.56s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(8) {
    -webkit-animation-delay: 0.64s;
    animation-delay: 0.64s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(9) {
    -webkit-animation-delay: 0.72s;
    animation-delay: 0.72s;
  }

  .rui-page-preloader.rui-page-preloader-active
    .rui-page-preloader-inner
    > div:nth-child(10) {
    -webkit-animation-delay: 0.8s;
    animation-delay: 0.8s;
  }

  @-webkit-keyframes rui-preloader-animation {
    to {
      -webkit-box-flex: 10;
      -webkit-flex: 10;
      flex: 10;
      background: rgba(0, 0, 0, 0);
      -webkit-box-shadow: 0 0 0 rgba(0, 0, 0, 0);
      box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    }
  }

  @keyframes rui-preloader-animation {
    to {
      -webkit-box-flex: 10;
      -webkit-flex: 10;
      -ms-flex: 10;
      flex: 10;
      background: rgba(0, 0, 0, 0);
      -webkit-box-shadow: 0 0 0 rgba(0, 0, 0, 0);
      box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    }
  }
</style>
