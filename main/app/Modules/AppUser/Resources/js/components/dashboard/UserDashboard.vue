<template>
  <layout title="My Dashboard" :isAuth="false">
    <div class="container-fluid">
      <div
        class="row vertical-gap rui-swiper"
        id="accountStatistics"
        data-swiper-initialslide="0"
        data-swiper-loop="true"
        data-swiper-grabcursor="true"
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
                  <div class="rui-widget-title h2">
                    {{
                    total_smart_savings_amount | Naira}}
                  </div>
                  <small class="rui-widget-subtitle">Smart Savings Balance</small>
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
            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ interest_today | Naira }}</div>
                  <small class="rui-widget-subtitle">Today's Interest</small>
                </div>
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`${total_uncleared_interests_amount},${total_interests_amount}`"
                    data-chartist-width="4"
                    data-chartist-gradient="#8e9fff;#2bb7ef"
                  ></div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ total_uncleared_interests_amount | Naira }}</div>
                  <small class="rui-widget-subtitle">Total Uncleared Interests</small>
                </div>
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`${total_uncleared_interests_amount},${total_savings_amount}`"
                    data-chartist-width="4"
                    data-chartist-gradient="#8e9fff;#2bb7ef"
                  ></div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ total_interests_amount | Naira }}</div>
                  <small class="rui-widget-subtitle">Total Accrued Interests</small>
                </div>
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`${total_interests_amount},${total_uncleared_interests_amount}`"
                    data-chartist-width="4"
                    data-chartist-gradient="#8e9fff;#2bb7ef"
                  ></div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ total_savings_amount | Naira }}</div>
                  <small class="rui-widget-subtitle">Total Savings Balance</small>
                </div>
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    data-chartist-series="8,1"
                    data-chartist-width="4"
                    data-chartist-gradient="#8e9fff;#2bb7ef"
                  ></div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ total_withdrawals_amount | Naira }}</div>
                  <small class="rui-widget-subtitle">Total Withdrawal</small>
                </div>
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    data-chartist-series="5,5"
                    data-chartist-width="4"
                    data-chartist-gradient="#8e9fff;#2bb7ef"
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
      <div class="rui-gap-2"></div>
      <div class="row" id="quickSavings">
        <div class="col-md-12">
          <div class="card text-center">
            <div class="card-header">
              <h5 class="card-title h2">How much do you want to save?</h5>
            </div>
            <div class="card-body d-flex justify-content-around flex-column flex-sm-row">
              <a
                href="#"
                class="justify-content-center btn btn-brand"
                @click="makeSavings(100)"
              >Save {{100 | Naira }}</a>
              <button
                type="button"
                class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-primary btn-w-sm"
                @click="makeSavings(200)"
              >Save {{200 | Naira }}</button>
              <button
                type="button"
                class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-success btn-w-sm"
                @click="makeSavings(500)"
              >Save {{500 | Naira }}</button>
              <button
                type="button"
                class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-outline-brand btn-w-sm"
                @click="makeSavings(1000)"
              >Save {{1000 | Naira }}</button>
              <button
                type="button"
                data-toggle="modal"
                data-target="#otherAmountSavingsModal"
                class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-outline-primary btn-w-sm"
              >Enter Amount</button>
            </div>

            <div class="card-footer text-muted">Last Savings: 2 days ago</div>
          </div>
        </div>
      </div>

      <div class="rui-gap-3"></div>
      <div class="rui-gap-3"></div>

      <div class="row xs-gap vertical-gap" id="savingsList" v-if="false">
        <div class="col-12">
          <div class="card-heading">
            <h4 class="card-heading-title">Ongoing Savings</h4>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title h2">Smart Savings</h5>
              <p
                class="card-text"
              >With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-brand">Go somewhere</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title h2">Special title treatment</h5>
              <p
                class="card-text"
              >With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-brand">Go somewhere</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card text-left">
            <div class="card-body">
              <h5 class="card-title h2">NYSC POP Savings</h5>
              <div class="fs-30 fw-600 text-primary">60000</div>
              <blockquote class="blockquote blockquote-style-2">
                <p class="mb-0 card-text">
                  <strong>40 days left</strong>
                  <br />
                  <span class="status-up">
                    <span class="text-light">Today's Interest</span>
                    #50.00
                    <i class="fa fa-angle-up"></i>
                  </span>
                  <span class="status-up">
                    <span class="text-light">Accrued Interest</span>
                    #5000.00
                    <i class="fa fa-angle-up"></i>
                  </span>
                </p>
                <footer class="blockquote-footer">John Doe</footer>
              </blockquote>
              <div class="progress">
                <div
                  class="progress-bar progress-bar-striped progress-bar-animated w-75 bg-brand"
                  role="progressbar"
                  aria-valuenow="75"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
              <a href="#" class="btn btn-brand">Add more funds</a>
            </div>
          </div>
        </div>
      </div>

      <div class="rui-gap-3"></div>
      <div class="rui-gap-3"></div>
    </div>
    <template v-slot:modals>
      <modal modalId="otherAmountSavingsModal" modalTitle="Save Funds">
        <form class="#">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="save-amount">Amount to save</label>
              <input
                type="text"
                class="form-control"
                id="save-amount"
                v-model="details.amount"
                placeholder="How much do you want to save"
              />
              <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
            </div>
            <div class="col-12">
              <button
                type="button"
                class="btn btn-success btn-long"
                :disabled="!details.amount"
                @click="makeSavings(details.amount)"
              >
                <span class="text">Process Savings</span>
              </button>
            </div>
          </div>
        </form>
      </modal>
    </template>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "UserDashboard",
    mixins: [mixins],
    props: {
      total_savings_amount: Number,
      total_smart_savings_amount: Number,
      interest_today: Number,
      total_interests_amount: Number,
      total_uncleared_interests_amount: Number,
      total_withdrawals_amount: Number
    },
    components: { Layout },
    data: () => {
      return {
        details: {}
      };
    },
    mounted() {
      this.$nextTick(() => {
        // Doughnut
        $(".rui-chartist").each(function() {
          const $this = $(this);
          let dataSeries = $this.attr("data-chartist-series");
          const dataWidth = $this.attr("data-width");
          const dataHeight = $this.attr("data-height");
          const dataGradient = $this.attr("data-chartist-gradient");
          const dataBorderWidth = parseInt($this.attr("data-chartist-width"), 10);
          const data = {};
          const conf = {};

          // Data
          if (dataSeries) {
            dataSeries = dataSeries.split(",");
            let dataSeriesNum = [];
            for (let i = 0; i < dataSeries.length; i++) {
              dataSeriesNum.push(parseInt(dataSeries[i], 10));
            }
            data.series = dataSeriesNum;
          }

          // Conf
          conf.donut = true;
          conf.showLabel = false;

          if (dataBorderWidth) {
            conf.donutWidth = dataBorderWidth;
          }
          if (dataWidth) {
            conf.width = dataWidth;
          }
          if (dataHeight) {
            conf.height = dataHeight;
          }

          const chart = new Chartist.Pie($this[0], data, conf);

          // Create gradient
          chart.on("created", function(ctx) {
            const defs = ctx.svg.elem("defs");
            defs
              .elem("linearGradient", {
                id: "gradient",
                x1: 0,
                y1: 1,
                x2: 0,
                y2: 0
              })
              .elem("stop", {
                offset: 0,
                "stop-color": dataGradient.split(";")[0]
              })
              .parent()
              .elem("stop", {
                offset: 1,
                "stop-color": dataGradient.split(";")[1]
              });
          });
        });
      });
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
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }
</style>
