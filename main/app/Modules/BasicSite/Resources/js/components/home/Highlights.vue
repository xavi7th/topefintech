<template>
  <section class="commonSection">
    <div class="container">
      <div class="row">
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
            <a href target="_blank">
              <img src="/img/thrive-agric.png" alt="Thrive agric logo" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
  .homeService {
    padding-top: 0 !important;

    &:before {
      background: none;
    }

    &:after {
      top: -300px;
    }
  }
  .serviceArea {
    padding: 0 !important;
  }

  .latestPost {
    border-bottom-color: transparent;
    margin-bottom: 50px;
  }
</style>
