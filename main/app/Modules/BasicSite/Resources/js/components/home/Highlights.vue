<template>
  <section class="commonSection homeService">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <div class="latestPost">
            <h2>
              <a href="#">Our Fund Managers</a>
            </h2>
          </div>

          <div class="row justify-content-around">
            <a href target="_blank">
              <img src="/img/united-capital.png" alt="United Capital logo" />
            </a>
            <a href target="_blank">
              <img src="/img/fbn-quest.png" alt="FBN Quest logo" />
            </a>
          </div>
        </div>
        <div class="col-12 text-center">
          <div class="latestPost">
            <h2>
              <a href="#">Our Investment Partners</a>
            </h2>
          </div>

          <div class="row justify-content-around">
            <a href target="_blank">
              <img src="/img/farm-crowdy.png" alt="farm Crowdy logo" />
            </a>
            <a href target="_blank">
              <img src="/img/farm-centa.png" alt="Farm Centa logo" />
            </a>
          </div>
        </div>
        <div class="col-12 text-center">
          <div class="latestPost">
            <h2>
              <a href="#">Mobile Apps</a>
            </h2>
          </div>

          <div class="row justify-content-around">
            <a href target="_blank">
              <img src="/img/playstore.jpg" alt="United Capital logo" />
            </a>
            <a href target="_blank">
              <img src="/img/appstore.jpg" alt="FBN Quest logo" />
            </a>
          </div>
        </div>
      </div>
    </div>
    <section class="commonSection callToAction_3">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-8">
            <h3 class="sec_title">Create account for free</h3>
          </div>
          <div class="col-lg-5 col-md-4 text-center">
            <a class="common_btn" href="#">Create Account</a>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>

<style lang="scss" scoped>
  .homeService {
    padding-top: 0 !important;

    &:before {
      background: none;
    }
  }
  .serviceArea {
    padding: 0 !important;
  }

  .latestPost {
    border-bottom-color: transparent;
    margin-top: 50px;
  }

  .callToAction_3 {
    padding: 30px 0 30px;
    margin-top: 100px;

    .sec_title {
      font-weight: 300;
      text-align: center;
    }

    .common_btn {
      margin-top: 0 !important;
      height: 50px;
      padding: 20px 50px;
      font-weight: 200;
    }
  }
</style>
