<template>
  <layout title="Admin Dashboard" :isAuth="false">
    <div class="rui-page content-wrap">
      <div class="rui-page-content">
        <div class="container-fluid">
          <div
            class="rui-swiper"
            data-swiper-initialslide="1"
            data-swiper-loop="true"
            data-swiper-grabcursor="true"
            data-swiper-center="true"
            data-swiper-slides="auto"
            data-swiper-gap="30"
            data-swiper-speed="400"
          >
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ totalTransactions }}</div>
                      <small class="rui-widget-subtitle">Total Transactions</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`3,8`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ walletBalance | Naira }}</div>
                      <small class="rui-widget-subtitle">Wallet Balance</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`1,7`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ dailySmartSavingsAmount | Naira }}</div>
                      <small class="rui-widget-subtitle">Daily Smart Savings Amount</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`3,17`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ dailyTargetSavingsAmount | Naira }}</div>
                      <small class="rui-widget-subtitle">Daily Target Savings Amount</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`6,10`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ dailyAgentSignupCount }}</div>
                      <small class="rui-widget-subtitle">Total Agent Daily Signups</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`7,17`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ matureSavingsCount }}</div>
                      <small class="rui-widget-subtitle">Total Accounts Due For Payouts</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`7,17`"
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

          <div class="row vertical-gap">
            <div class="col-lg-4">
              <div class="rui-widget rui-widget-actions">
                <div class="rui-widget-head">
                  <h4 class="rui-widget-title">Latest Wallet Funding</h4>
                  <div class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open ml-auto">
                    <a
                      class="dropdown-item mnr-8"
                      href="#"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                      data-offset="10,12"
                    >
                      <span class="btn btn-custom-round">
                        <span data-feather="more-vertical" class="rui-icon rui-icon-stroke-1_5"></span>
                      </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li>
                        <a class="dropdown-item" href="#">Export to XLS</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Export to PDF</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Export to XML</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="rui-widget-content">
                  <ul class="list-group list-group-flush rui-widget-list">
                    <li class="list-group-item">
                      <div class="media media-filled">
                        <a href="#" class="media-link">
                          <span class="media-img bg-transparent">
                            <img src="/img/icon-zip.svg" class="icon-file" alt />
                          </span>
                          <span class="media-body">
                            <span class="media-title">
                              Added banner archive
                              <span class="media-time">08:31</span>
                            </span>
                            <small class="media-subtitle">Commerce</small>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled">
                        <a href="#" class="media-link">
                          <span class="media-img bg-transparent">
                            <img src="/img/icon-zip.svg" class="icon-file" alt />
                          </span>
                          <span class="media-body">
                            <span class="media-title">
                              Sensific-1.2.0.zip
                              <span class="media-time">10:24</span>
                            </span>
                            <small class="media-subtitle">Template</small>
                          </span>
                        </a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@admin-assets/js/AdminAppComponent";

  export default {
    name: "AdminDashboard",
    props: {
      totalTransactions: Number,
      walletBalance: Number,
      dailySmartSavingsAmount: Number,
      dailyTargetSavingsAmount: Number,
      dailyAgentSignupCount: Number,
      matureSavingsCount: Number,
    },
    mixins: [mixins],
    components: { Layout },
    mounted() {
      // this.$nextTick(() => {
        (function() {
          // Chart
          $(".rui-chartjs").each(function() {
            const $this = $(this);
            const ctx = $this[0].getContext("2d");

            $this.attr("height", parseInt($this.attr("data-height"), 10));

            // Line Realtime
            if ($this.hasClass("rui-chartjs-line")) {
              const dataInterval = parseInt(
                $this.attr("data-chartjs-interval"),
                10
              );
              const dataBorderColor = $this.attr("data-chartjs-line-color");
              const conf = {};

              const gradient = ctx.createLinearGradient(0, 0, 0, 90);
              gradient.addColorStop(
                0,
                Chart.helpers
                  .color(dataBorderColor)
                  .alpha(0.1)
                  .rgbString()
              );
              gradient.addColorStop(
                1,
                Chart.helpers
                  .color(dataBorderColor)
                  .alpha(0)
                  .rgbString()
              );

              const rand = () =>
                Array.from(
                  {
                    length: 40
                  },
                  () => Math.floor(Math.random() * (100 - 40) + 40)
                );

              function addData(chart, data) {
                chart.data.datasets.forEach(dataset => {
                  let data = dataset.data;
                  const first = data.shift();
                  data.push(first);
                  dataset.data = data;
                });

                chart.update();
              }

              conf.type = "line";
              conf.data = {
                labels: rand(),
                datasets: [
                  {
                    backgroundColor: gradient,
                    borderColor: dataBorderColor,
                    borderWidth: 2,
                    pointHitRadius: 5,
                    pointBorderWidth: 0,
                    pointBackgroundColor: "transparent",
                    pointBorderColor: "transparent",
                    pointHoverBorderWidth: 0,
                    pointHoverBackgroundColor: dataBorderColor,
                    data: rand()
                  }
                ]
              };
              conf.options = {
                tooltips: {
                  mode: "index",
                  intersect: false,
                  backgroundColor: "#393f49",
                  bodyFontSize: 11,
                  bodyFontColor: "#d7d9e0",
                  bodyFontFamily: '"Open Sans", sans-serif',
                  xPadding: 10,
                  yPadding: 10,
                  displayColors: false,
                  caretPadding: 5,
                  cornerRadius: 4,
                  callbacks: {
                    title: () => {
                      return;
                    },
                    label: t => {
                      if ($this.hasClass("rui-chartjs-memory")) {
                        return [`In use ${t.value}%`, `${t.value * 100} MB`];
                      }
                      if ($this.hasClass("rui-chartjs-disc")) {
                        return [
                          `Read ${Math.round((t.value / 80) * 100) / 100} MB/s`,
                          `Write ${Math.round((t.value / 90) * 100) / 100} MB/s`
                        ];
                      }
                      if ($this.hasClass("rui-chartjs-cpu")) {
                        return [
                          `Utilization ${t.value}%`,
                          `Processes ${parseInt(t.value / 10, 10)}`
                        ];
                      }
                      if ($this.hasClass("rui-chartjs-total")) {
                        return `$${t.value}`;
                      }
                    }
                  }
                },
                legend: {
                  display: false
                },
                maintainAspectRatio: true,
                spanGaps: false,
                plugins: {
                  filler: {
                    propagate: false
                  }
                },
                scales: {
                  xAxes: [
                    {
                      display: false
                    }
                  ],
                  yAxes: [
                    {
                      display: false,
                      ticks: {
                        beginAtZero: true
                      }
                    }
                  ]
                }
              };
              const myChart = new Chart(ctx, conf);
              setInterval(() => addData(myChart), dataInterval);
            }
          });

          // Doughnut
          $(".rui-chartist").each(function() {
            const $this = $(this);
            let dataSeries = $this.attr("data-chartist-series");
            const dataWidth = $this.attr("data-width");
            const dataHeight = $this.attr("data-height");
            const dataGradient = $this.attr("data-chartist-gradient");
            const dataBorderWidth = parseInt(
              $this.attr("data-chartist-width"),
              10
            );
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
        })();
      // });
    }
  };
</script>
