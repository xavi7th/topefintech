<template>
  <div class="preloader">
    <div class="preloader-body">
      <div class="preloader-item">
        <div class="diamond"></div>
        <div class="diamond"></div>
        <div class="diamond"></div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {};
</script>
<style lang="scss" scoped>
  .preloader {
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    z-index: 9999999;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px 20px 6%;
    background: #fff;
    transition: 0.15s all linear;
  }

  .preloader.loaded {
    opacity: 0;
    visibility: hidden;
  }

  .preloader-body {
    text-align: center;
  }

  .preloader-item {
    position: relative;
    width: 30px;
    height: 120px;
    display: flex;
    flex-flow: column nowrap;
  }

  .preloader-item .diamond {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    margin: 0 auto;
    width: 30px;
    height: 30px;
    border-radius: 2px;
    background: #00b9d4;
    transform: translateY(0) rotate(45deg) scale(0);
    animation: diamonds 1500ms linear infinite;
  }

  .preloader-item .diamond:nth-child(1) {
    animation-delay: -1000ms;
  }

  .preloader-item .diamond:nth-child(2) {
    animation-delay: -2000ms;
  }

  .preloader-item .diamond:nth-child(3) {
    animation-delay: -3000ms;
  }

  .preloader-item .diamond:nth-child(4) {
    animation-delay: -4000ms;
  }

  @keyframes diamonds {
    50% {
      transform: translateY(-50px) rotate(45deg) scale(1);
    }
    100% {
      transform: translateY(-100px) rotate(45deg) scale(0);
    }
  }
</style>
