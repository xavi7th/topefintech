<template>
  <div class="plyenz-main">
    <div class="container">
      <div class="row">
        <!-- card -->
        <div class="col-lg-8 col-md-12">
          <div class="card card-animation">
            <div class="card-body pb-0">
              <div class="widget8">
                <div class="widget8-label">Total Balance</div>
                <div class="widget8-value">
                  <div
                    class="mr-20"
                  >{{ userDetails.total_deposit + userDetails.total_profit | currency(userDetails.currency) }}</div>
                </div>
                <div class="mt-30">
                  <!-- <a href class="btn btn-primary btn-round mr-5">Add Deposit</a> -->
                  <!-- <a href class="btn btn-dark btn-round">Make Withdrawal</a> -->
                </div>
                <div class="card-row">
                  <hr class="my-30" />
                  <div class="widget8-chart">
                    <div class="mx-30 mb-30 flex a-i-center j-c-between">
                      <span class="fs-16 text-light">Account trade statistic chart</span>
                      <!-- <form>
                        <select class="form-control">
                          <option>Today</option>
                          <option>This Week</option>
                          <option>This Month</option>
                          <option>This Year</option>
                        </select>
                      </form>-->
                    </div>

                    <canvas id="statistics-chart-area" height="90"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- card #end -->

        <!-- card -->
        <div class="col-lg-4 col-md-12">
          <div class="card card-hover card-animation">
            <div class="card-body">
              <div class="flex a-i-center j-c-between py-3 mb-10">
                <div class>
                  <span
                    class="d-block fs-24 fw-600 mt-10"
                  >{{ userDetails.total_deposit | currency(userDetails.currency) }}</span>
                  <span class="text-light">Deposit Amount</span>
                </div>
                <i class="cc DOGE fs-40" title="DOGE"></i>
              </div>
            </div>
          </div>

          <!-- card -->
          <div class="card card-hover card-animation">
            <div class="card-body">
              <div class="flex a-i-center j-c-between py-3 mb-10">
                <div class>
                  <span
                    class="d-block fs-24 fw-600 mt-10"
                  >{{ userDetails.total_profit | currency(userDetails.currency) }}</span>
                  <span class="text-light">Total Profit</span>
                </div>
                <i class="cc BTA fs-40" title="BTA"></i>
              </div>
            </div>
          </div>

          <!-- card -->
          <div class="card card-hover card-animation">
            <div class="card-body">
              <div class="flex a-i-center j-c-between py-3 mb-10">
                <div class>
                  <span
                    class="d-block fs-24 fw-600 mt-10"
                  >{{ userDetails.target_profit| currency(userDetails.currency) }}</span>
                  <span class="text-light">Withdrawal Target</span>
                </div>
                <i class="cc XRP fs-40" title="XRP"></i>
              </div>
            </div>
          </div>
        </div>
        <!-- card #end -->
      </div>

      <div class="row">
        <!-- card -->
        <div class="col-lg-12 col-md-12">
          <div class="card card-hover">
            <div id="ticker-bar-chart"></div>
          </div>
        </div>
        <!-- card #end -->

        <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">
          <div class="card bg-danger">
            <div class="card-body">
              <div class="widget1">
                <div class="widget1-icon bg-white mb-15">
                  <i class="fas fa-info fs-20 text-danger"></i>
                </div>

                <p
                  class="widget1-label text-white fs-16"
                >Your trading account is a special account so avoid trading for yourself. Note that this account is being managed by our Assigned Account Managers.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="col-lg-3 col-md-6">
          <div class="card card-hover">
            <div class="p-30 flex a-i-center j-c-between">
              <i class="cc XMR fs-26"></i>
              <div>
                <span class="fs-20 fw-600">1.495</span>
                <span class="status-up">
                  <i class="fa fa-angle-up fs-14"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card card-hover">
            <div class="p-30 flex a-i-center j-c-between">
              <i class="cc DCR fs-26"></i>
              <div>
                <span class="fs-20 fw-600">89.000</span>
                <span class="status-down">
                  <i class="fa fa-angle-down fs-14"></i>
                </span>
              </div>
            </div>
          </div>
        </div>-->
      </div>

      <!-- card -->
      <div class="card">
        <div class="card-title">
          <h4>EUR/USD Forex Live Trading Charts</h4>
        </div>
        <div class="card-body p-0">
          <div id="forex-rates-chart"></div>
        </div>
      </div>
      <!-- card #end -->

      <div class="row">
        <div class="col-lg-4 col-md-12">
          <div class="card">
            <div class="card-title">
              <h4>Trading Profit History</h4>
            </div>
            <div class="card-body">
              <div class="widget2">
                <div class="chart-wrapper">
                  <canvas id="chart-donut"></canvas>
                </div>
                <div class="widget2-list">
                  <div class="widget2-item" v-for="data in donutData">
                    <div>
                      <span class="badge badge-primary badge-dot badge-md"></span>
                      <span>{{ data.desc | capitalize }}</span>
                    </div>
                    <span class="value">{{ data.amount |currency(userDetails.currency) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="card">
            <div class="card-body p-0">
              <div id="gbpusd-tech-analysis-chart"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="card">
            <div class="card-title">
              <h4>QUOTES CHART</h4>
            </div>
            <div class="card-body p-0">
              <div id="eurusd-single-ticker-chart"></div>
              <div id="btcusd-single-ticker-chart"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-title">
          <h4>USD/JPY Forex Live Trading Charts</h4>
        </div>
        <div class="card-body p-0">
          <div id="usdjpy-full-chart"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { getProfitTransactions } from "@dashboard-assets/js/config/endpoints";
  import mixins from "@dashboard-assets/js/config/mixins";

  export default {
    mixins: [mixins],
    name: "UserDashboard",
    data: () => {
      return {
        donutData: []
      };
    },
    components: {},
    created() {
      // axios.get(howItWorksChart).then(rsp => {
      //   /**
      //    *? Convert string to DOM Nodes
      //    */
      //   let frag = document
      //     .createRange()
      //     .createContextualFragment(rsp.data.template);
      //   document.querySelector("#chartHow").replaceWith(frag);
      // });
    },

    mounted() {
      axios.get(getProfitTransactions).then(({ data }) => {
        let labels = [];
        let amtData = [];
        let donutLabels = [];
        let donutAmtData = [];
        _.each(data, value => {
          labels.push(value.date);
          amtData.push(value.amount);
          if (_.includes(value.date, "profit")) {
            donutLabels.push(value.date);
            donutAmtData.push(value.amount);
            this.donutData.push({
              amount: value.amount,
              desc: value.date
            });
          }
        });

        let chartjs1 = $("#statistics-chart-area");
        if (chartjs1.length) {
          new Chart(chartjs1, {
            type: "line",
            data: {
              labels: labels,
              datasets: [
                {
                  data: amtData,
                  backgroundColor: "rgba(101,39,178,0.1)",
                  fill: true,
                  borderWidth: 3,
                  borderColor: "rgba(101,39,178,1)"
                }
              ]
            },
            options: {
              legend: {
                display: false,
                labels: {
                  display: false
                }
              },
              scales: {
                yAxes: [
                  {
                    display: false,
                    ticks: {
                      beginAtZero: true,
                      fontSize: 12
                    }
                  }
                ],
                xAxes: [
                  {
                    display: false,
                    ticks: {
                      beginAtZero: true,
                      fontSize: 14
                    }
                  }
                ]
              }
            }
          });
        }
        // _.remove(labels, v => !_.includes(v, "deposit"))
        var chartjs2 = $("#chart-donut");
        if (chartjs2.length) {
          new Chart(chartjs2, {
            type: "doughnut",
            data: {
              labels: donutLabels,
              datasets: [
                {
                  label: "Portfolio",
                  data: donutAmtData,
                  backgroundColor: ["#3e2bce", "#3AA4F5", "#DB3847"],
                  borderColor: ["#fff", "#fff", "#fff"],
                  borderWidth: 0,
                  hoverBorderColor: "transparent"
                }
              ]
            },
            options: {
              cutoutPercentage: 80,
              responsive: true,
              maintainAspectRatio: false,
              title: {
                display: false,
                position: "top",
                text: "Pie Chart",
                fontSize: 18,
                fontColor: "#333"
              },
              legend: {
                display: false,
                position: "bottom",
                labels: {
                  fontColor: "#666",
                  fontSize: 12
                }
              }
            }
          });
        }
        this.$emit("page-loaded");
      });

      this.getTickerBarChart();
      this.getForexRatesChart();
      this.getgpbusdTechAnalysisChart();
      this.usdjpyFullChart();
      //  this.getChart1();
      this.getChart4();
    },
    methods: {
      getForexRatesChart() {
        axios.get("/api/forex-rates-chart").then(rsp => {
          let frag = document
            .createRange()
            .createContextualFragment(rsp.data.template);
          document.querySelector("#forex-rates-chart").replaceWith(frag);
        });
      },
      getTickerBarChart() {
        axios.get("/api/ticker-bar-chart").then(rsp => {
          let frag = document
            .createRange()
            .createContextualFragment(rsp.data.template);
          document.querySelector("#ticker-bar-chart").replaceWith(frag);
        });
      },
      getgpbusdTechAnalysisChart() {
        axios.get("/api/gbpusd-tech-analysis").then(rsp => {
          let frag = document
            .createRange()
            .createContextualFragment(rsp.data.template);
          document.querySelector("#gbpusd-tech-analysis-chart").replaceWith(frag);
        });
      },
      usdjpyFullChart() {
        axios.get("/api/usdjpy-full-charts").then(rsp => {
          let frag = document
            .createRange()
            .createContextualFragment(rsp.data.template);
          document.querySelector("#usdjpy-full-chart").replaceWith(frag);
        });
      },
      getChart4() {
        axios.get("/api/eurusd-single-ticker-chart").then(rsp => {
          let frag = document
            .createRange()
            .createContextualFragment(rsp.data.template);
          document.querySelector("#eurusd-single-ticker-chart").replaceWith(frag);
        });
        axios.get("/api/btcusd-single-ticker-chart").then(rsp => {
          let frag = document
            .createRange()
            .createContextualFragment(rsp.data.template);
          document.querySelector("#btcusd-single-ticker-chart").replaceWith(frag);
        });
      }
    }
  };
</script>

<style lang="scss" scoped>
  .red-border {
    border: 2px solid #db3847;
  }
</style>
