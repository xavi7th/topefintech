<template>
  <div class="container-fluid">
    <h2>My Live Account Portfolio(s)</h2>
    <div
      class="row rui-swiper"
      id="liveAccountStatistics"
      data-swiper-initialslide="0"
      :data-swiper-loop="!!userSavings.length || !!userInvestments.length"
      data-swiper-grabcursor="true"
      data-swiper-center="false"
      data-swiper-slides="auto"
      data-swiper-gap="30"
      data-swiper-speed="400"
    >
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <template v-if="!userSavings.length">
            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ 0 | Naira }}</div>
                  <small class="rui-widget-subtitle">Target Savings Balance</small>
                </div>
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    data-chartist-series="1,20"
                    data-chartist-width="4"
                    data-chartist-gradient="#ff8ebc;#ef2b5a"
                  ></div>
                </div>
              </div>
            </div>
          </template>
          <template v-else>
            <div class="swiper-slide" v-for="portfolio in userSavings" :key="portfolio.id">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`${portfolio.total_duration},${portfolio.elapsed_duration}`"
                    data-chartist-width="4"
                    data-chartist-gradient="#8e9fff;#2bb7ef"
                  ></div>
                </div>
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ portfolio.current_balance | Naira }}</div>
                  <small
                    class="rui-widget-subtitle text-capitalize"
                  >{{ portfolio.name }} Savings Balance</small>
                  <div class="d-flex">
                    <button
                      type="button"
                      data-toggle="modal"
                      data-target="#otherAmountSavingsModal"
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-outline-primary btn-xs mr-5"
                      @click="$emit('addSavings', portfolio)"
                    >Add Savings</button>
                    <button
                      type="button"
                      data-toggle="modal"
                      data-target="#otherAmountSavingsModal"
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-outline-danger btn-xs"
                      v-if="portfolio.type === 'smart'"
                    >Liquidate</button>
                  </div>
                </div>
              </div>
            </div>
          </template>

          <div class="swiper-slide" v-if="!userInvestments.length">
            <div class="rui-widget rui-widget-chart">
              <div class="rui-widget-chart-info">
                <div class="rui-widget-title h2">{{ 0 | Naira }}</div>
                <small class="rui-widget-subtitle">Total Investments Balance</small>
              </div>
              <div class="rui-chartjs-container">
                <div
                  class="rui-chartist rui-chartist-donut"
                  data-width="200"
                  data-height="200"
                  data-chartist-series="1,25"
                  data-chartist-width="4"
                  data-chartist-gradient="#ff8ebc;#ef2b5a"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-button-next">
        <span data-feather="chevron-right" class="rui-icon rui-icon-stroke-1_5"></span>
      </div>
      <div class="swiper-button-prev">
        <span data-feather="chevron-left" class="rui-icon rui-icon-stroke-1_5"></span>
      </div>
    </div>

    <div class="rui-gap-3"></div>
    <div class="rui-gap-3"></div>
  </div>
</template>

<script>
  export default {
    name: "LivePortfolioStatistics",
    props: {
      userInvestments: {
        type: Array
      },
      userSavings: {
        type: Array
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
