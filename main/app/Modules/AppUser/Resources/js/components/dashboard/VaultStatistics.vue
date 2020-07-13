<template>
  <div class="container-fluid">
    <h2>My Vault</h2>

    <div
      class="row rui-swiper"
      id="vaultStatistics"
      data-swiper-initialslide="0"
      data-swiper-loop="false"
      data-swiper-grabcursor="false"
      data-swiper-center="false"
      data-swiper-slides="auto"
      data-swiper-gap="30"
      data-swiper-speed="400"
    >
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="rui-widget rui-widget-chart">
              <div class="rui-widget-chart-info">
                <div class="rui-widget-title h2">{{ 10000 | Naira}}</div>
                <small class="rui-widget-subtitle">Interests: Smart Savings</small>
                <button type="button" class="btn btn-warning btn-xs" @click="makeSavings(100)">
                  <span class="text">Withdraw</span>
                </button>
              </div>
              <div class="rui-chartjs-container">
                <div
                  class="rui-chartist rui-chartist-donut"
                  data-width="200"
                  data-height="200"
                  data-chartist-series="5,2"
                  data-chartist-width="4"
                  data-chartist-gradient="#8e9fff;#2bb7ef"
                ></div>
              </div>
            </div>
          </div>

          <div class="swiper-slide" v-if="!userInvestments.length">
            <div class="rui-widget rui-widget-chart">
              <div class="rui-chartjs-container">
                <div
                  class="rui-chartist rui-chartist-donut"
                  data-width="200"
                  data-height="200"
                  :data-chartist-series="`1,200`"
                  data-chartist-width="4"
                  data-chartist-gradient="#ff8ebc;#ef2b5a"
                ></div>
              </div>
              <div class="rui-widget-chart-info">
                <div class="rui-widget-title h2">{{ 0 | Naira }}</div>
                <small class="rui-widget-subtitle">Interest: Investments</small>
              </div>
            </div>
          </div>

          <div class="swiper-slide" v-if="!targetSavings.length">
            <div class="rui-widget rui-widget-chart">
              <div class="rui-widget-chart-info">
                <div class="rui-widget-title h2">{{ 0 | Naira }}</div>
                <small class="rui-widget-subtitle">Interests: Target Savings</small>
              </div>
              <div class="rui-chartjs-container">
                <div
                  class="rui-chartist rui-chartist-donut"
                  data-width="200"
                  data-height="200"
                  :data-chartist-series="`1,255`"
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
    name: "VaultStatistics",
    props: {
      userInvestments: {
        type: Array
      },
      targetSavings: {
        type: Array
      }
    },
    data: () => {
      return {
        details: {}
      };
    },
    methods: {
      makeSavings(amount = null) {
        BlockToast.fire({
          text: "Initialising transaction ..."
        });
        this.$inertia
          .visit(this.$route("appuser.paystack.initialise"), {
            method: "get",
            data: {
              amount: amount || this.details.amount,
              description:
                "Fund savings into account of " +
                this.$options.filters.Naira(amount)
            },
            replace: false,
            preserveState: false,
            preserveScroll: true,
            only: ["errors", "flash"]
          })
          .then(() => {
            console.log(this.$page.flash);

            if (this.$page.flash.error) {
              ToastLarge.fire({
                title: "Error",
                html: this.$page.flash.error,
                icon: "error"
              });
            } else if (this.$page.flash.success) {
              ToastLarge.fire({
                title: "Success",
                html: this.$page.flash.success,
                icon: "success"
              });
            } else {
              swal.close();
            }
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
