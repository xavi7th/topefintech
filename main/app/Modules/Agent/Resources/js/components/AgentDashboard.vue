<template>
  <layout title="Agent Dashboard" :isAuth="false">
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
                      <div class="rui-widget-title h2">{{$page.auth.user.wallet_balance | Naira}}</div>
                      <small class="rui-widget-subtitle">Wallet Balance</small>
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
                      <div class="rui-widget-title h2">{{ totalClients }}</div>
                      <small class="rui-widget-subtitle">Total Clients</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`4,5`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>
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
                  <h4 class="rui-widget-title">Latest Clients</h4>
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
                  <ul class="list-group list-group-flush rui-widget-list rui-widget-task-list">
                    <li class="list-group-item">
                      <div class="rui-task rui-task-success">
                        <div class="rui-task-icon">
                          <span data-feather="alert-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                        </div>
                        <div class="rui-task-content">
                          <a class="rui-task-title" href="task.html">
                            Cattle whose. There isn&#39;t cattle rule
                            said
                          </a>
                          <small class="rui-task-subtitle">
                            #12 opened 4 days ago
                            by
                            <a href="#">Henry</a>
                          </small>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="rui-task rui-task-success">
                        <div class="rui-task-icon">
                          <span data-feather="alert-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                        </div>
                        <div class="rui-task-content">
                          <a class="rui-task-title" href="task.html">
                            Was living rule Him created a to. Light of
                            itself
                          </a>
                          <small class="rui-task-subtitle">
                            #11 opened 21 days
                            ago by
                            <a href="#">Neil</a>
                          </small>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
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
            <div class="col-lg-4">
              <div class="rui-widget rui-widget-actions">
                <div class="rui-widget-head">
                  <h4 class="rui-widget-title">Latest Notifications</h4>
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
                        <a href="#" class="media-link active">
                          <span class="media-img">P</span>
                          <span class="media-body">
                            <span class="media-title">[Project] Release Version 1.2.0</span>
                            <small class="media-subtitle">
                              Jul 05, 2019 10:22 —
                              created
                            </small>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled">
                        <a href="#" class="media-link active">
                          <span class="media-img">H</span>
                          <span class="media-body">
                            <span class="media-title">[Hotfix] Error login page</span>
                            <small class="media-subtitle">
                              Jul 04, 2019 10:38 —
                              created
                            </small>
                          </span>
                        </a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="rui-gap-3"></div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@agent-assets/js/AgentAppComponent.vue";

  export default {
    props: {
      totalClients: Number,
      totalTransactions: Number,
      latestNotifications: Array,
    },
    mixins: [mixins],
    components: { Layout },
    mounted() {
      this.$nextTick(() => {
        (function () {
          // Doughnut
          $(".rui-chartist").each(function () {
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
            chart.on("created", function (ctx) {
              const defs = ctx.svg.elem("defs");
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
        })();
      });
    },
  };
</script>
