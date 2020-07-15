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
          <template v-if="!userSavings.length">
            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ 0 | Naira }}</div>
                  <small class="rui-widget-subtitle">Interests: Balance</small>
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
            <div class="swiper-slide" v-for="portfolio in liquidatedSavings" :key="portfolio.id">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`1,1`"
                    data-chartist-width="4"
                    data-chartist-gradient="#ff8ebc;#ef2b5a"
                  ></div>
                </div>
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ portfolio.current_balance | Naira }}</div>
                  <small
                    class="rui-widget-subtitle text-uppercase text-danger"
                  >Liquidated: {{ portfolio.name }} Savings</small>
                  <div class="d-flex">
                    <button
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-warning btn-xs mr-5"
                      v-if="portfolio.can_withdraw"
                      @click="withdrawSavings(portfolio)"
                    >Withdraw</button>
                    <div
                      class="alert alert-danger btn-xs fs-11"
                      role="alert"
                      v-else
                    >LOCKED: {{ portfolio.locktime_countdown }} days</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide" v-for="portfolio in userSavings" :key="portfolio.id">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`${portfolio.total_duration},${portfolio.elapsed_duration}`"
                    data-chartist-width="4"
                    data-chartist-gradient="#ff8ebc;#ef2b5a"
                  ></div>
                </div>
                <div class="rui-widget-chart-info">
                  <div
                    class="rui-widget-title h2"
                  >{{ portfolio.total_unprocessed_interest_amount | Naira }}</div>
                  <small
                    class="rui-widget-subtitle text-capitalize"
                  >Interests: {{ portfolio.name }} Savings</small>
                  <div class="d-flex">
                    <button
                      type="button"
                      v-if="portfolio.type !== 'target'"
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-warning btn-xs mr-5"
                    >Withdraw</button>
                  </div>
                </div>
              </div>
            </div>
          </template>

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
      userInvestments: Array,
      userSavings: Array,
      liquidatedSavings: Array
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
      },
      withdrawSavings(savings) {
        console.log(savings);
        swalPreconfirm
          .fire({
            confirmButtonText: "Carry on!",
            text:
              "This will close this savings portfolio and send a request for its current balance.",
            preConfirm: () => {
              return this.$inertia
                .post(this.$route("appuser.withdraw.create", savings.id), {
                  description: "Withdraw liquidated smart savings funds"
                })
                .then(rsp => {
                  return true;
                })
                .catch(error => {
                  if (error.response) {
                    swal.showValidationMessage(
                      `Request failed: ${error.response.data.message}`
                    );
                  } else {
                    swal.showValidationMessage(`Request failed: ${error}`);
                  }
                });
            }
          })
          .then(val => {
            // debugger;

            if (val.isDismissed) {
              Toast.fire({
                title: "Canceled",
                icon: "info",
                position: "center"
              });
            } else if (val.value) {
              if (this.$page.errors.length) {
                ToastLarge.fire({
                  title: "Oops",
                  html: _.join(this.$page.errors.amount, "<br>"),
                  position: "bottom",
                  icon: "error",
                  timer: 10000
                });
              } else if (this.$page.flash.success) {
                ToastLarge.fire({
                  title: "Success",
                  html: this.$page.flash.success,
                  position: "bottom",
                  icon: "success",
                  timer: 10000
                });
              }
            }
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
