<template>
  <layout title="My Dashboard" :isAuth="false">
    <LivePortfolioStatistics
      @add-savings="details=$event"
      :userInvestments="userInvestments"
      :userSavings="userSavings"
    />
    <VaultStatistics
      @withdrawInterests="details=$event"
      :userSavings="userSavings"
      :userInvestments="userInvestments"
      :maturedSavings="maturedSavings"
      :liquidatedSavings="liquidatedSavings"
    />

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
  import LivePortfolioStatistics from "@dashboard-components/dashboard/LivePortfolioStatistics";
  import VaultStatistics from "@dashboard-components/dashboard/VaultStatistics";
  export default {
    name: "UserDashboard",
    mixins: [mixins],
    props: {
      userInvestments: Array,
      userSavings: Array,
      liquidatedSavings: Array,
      maturedSavings: Array,
    },
    data: () => {
      return {
        details: {},
      };
    },
    components: { Layout, LivePortfolioStatistics, VaultStatistics },
    mounted() {
      this.$nextTick(() => {
        // Doughnut
        $(".rui-chartist").each(function () {
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
          chart.on("created", function (ctx) {
            let defs = ctx.svg.elem("defs");
            defs
              .elem("linearGradient", {
                id: "gradient",
                x1: 0,
                y1: 1,
                x2: 0,
                y2: 0,
              })
              .elem("stop", {
                offset: 0,
                "stop-color": dataGradient.split(";")[0],
              })
              .parent()
              .elem("stop", {
                offset: 1,
                "stop-color": dataGradient.split(";")[1],
              });
          });
        });
      });
    },
    methods: {
      makeSavings(amount) {
        this.details.savings_id = this.details.id;
        BlockToast.fire({
          text: "Initialising transaction ...",
        });
        this.$inertia
          .post(
            this.$route("appuser.savings.target.fund"),
            {
              ...this.details,
            },
            {
              preserveState: true,
            }
          )
          .then(() => {
            console.log(this.$page.flash);

            if (this.$page.flash.error) {
              ToastLarge.fire({
                title: "Error",
                html: this.$page.flash.error,
                icon: "error",
              });
            } else if (this.$page.flash.success) {
              ToastLarge.fire({
                title: "Success",
                html: this.$page.flash.success,
                icon: "success",
              });
            } else {
              swal.close();
            }
          });
      },
    },
  };
</script>

<style lang="scss" >
  #vaultStatistics {
    .ct-slice-donut {
      fill: #d5e2cf;
      fill-opacity: 0.5;
    }
  }

  .rui-swiper .swiper-slide {
    width: auto !important;
  }
</style>
