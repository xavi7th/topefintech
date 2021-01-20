<template>
  <layout title="Super Admin Dashboard" :isAuth="false">
    <div class="rui-page content-wrap">
      <div class="rui-page-content">
        <div class="container-fluid">
          <div
            class="rui-swiper"
            data-swiper-initialslide="1"
            data-swiper-loop="false"
            data-swiper-grabcursor="true"
            data-swiper-center="true"
            data-swiper-slides="auto"
            data-swiper-gap="30"
            data-swiper-speed="400"
          >
            <div class="swiper-container">
              <div class="swiper-wrapper">

                <div class="swiper-slide rui-swiper-slide-total">
                  <div class="rui-widget rui-widget-chart rui-widget-total">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h1">{{total_savings_amount | Naira}}</div>
                      <small class="rui-widget-subtitle">Total Income</small>
                    </div>
                    <div class="rui-widget-total-chart">
                      <canvas
                        class="rui-chartjs rui-chartjs-line rui-chartjs-total"
                        data-height="50"
                        data-chartjs-interval="3000"
                        data-chartjs-line-color="#8e9fff"
                      ></canvas>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{total_smart_savings_amount | Naira}}</div>
                      <small class="rui-widget-subtitle">Total Smart Savings</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_smart_savings_amount},${total_savings_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>


                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{total_target_savings_amount | Naira}}</div>
                      <small class="rui-widget-subtitle">Total Target Savings</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_target_savings_amount},${total_savings_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{total_investment_savings_amount | Naira}}</div>
                      <small class="rui-widget-subtitle">Total Investments</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_investment_savings_amount},${total_savings_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div
                        class="rui-widget-title h2"
                      >{{ total_uncleared_interests_amount | Naira }}</div>
                      <small class="rui-widget-subtitle">Total Uncleared Interests</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_uncleared_interests_amount},${total_cleared_interests_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ total_cleared_interests_amount | Naira }}</div>
                      <small class="rui-widget-subtitle">Total Cleared Interests</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_cleared_interests_amount},${total_uncleared_interests_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ total_daily_credits | Naira }}</div>
                      <small class="rui-widget-subtitle">Total Daily Credits</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_daily_credits},${total_uncleared_interests_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ total_daily_payouts | Naira }}</div>
                      <small class="rui-widget-subtitle">Total Daily Payouts</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_daily_payouts},${total_uncleared_interests_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ total_users  }}</div>
                      <small class="rui-widget-subtitle">Total Users</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_users},${total_uncleared_interests_amount}`"
                        data-chartist-width="4"
                        data-chartist-gradient="#8e9fff;#2bb7ef"
                      ></div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="rui-widget rui-widget-chart">
                    <div class="rui-widget-chart-info">
                      <div class="rui-widget-title h2">{{ total_independent_users }}</div>
                      <small class="rui-widget-subtitle">Total Independent Users</small>
                    </div>
                    <div class="rui-chartjs-container">
                      <div
                        class="rui-chartist rui-chartist-donut"
                        data-width="200"
                        data-height="200"
                        :data-chartist-series="`${total_independent_users},${total_uncleared_interests_amount}`"
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
          <!--
          <div class="row vertical-gap">
            <div class="col-lg-4">
              <div class="rui-widget rui-widget-actions">
                <div class="rui-widget-head">
                  <h4 class="rui-widget-title">Latest Tasks</h4>
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
                  <h4 class="rui-widget-title">Latest Uploads</h4>
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
                  <h4 class="rui-widget-title">Activity</h4>
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
          <div class="rui-gap-2"></div>
          <div class="row vertical-gap">
            <div class="col-lg-4">
              <div class="rui-widget rui-widget-server">
                <div class="rui-widget-head">
                  <h4 class="rui-widget-title">Memory Usage</h4>
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
                <div class="rui-widget-content mnt-5">
                  <span data-feather="server" class="rui-icon rui-icon-stroke-1_5"></span>16385 MB
                </div>
                <div class="rui-widget-server-chart">
                  <canvas
                    class="rui-chartjs rui-chartjs-line rui-chartjs-memory"
                    data-height="80"
                    data-chartjs-interval="3000"
                    data-chartjs-line-color="#8e9fff"
                  ></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="rui-widget rui-widget-server">
                <div class="rui-widget-head">
                  <h4 class="rui-widget-title">Disc Usage</h4>
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
                <div class="rui-widget-content mnt-5">
                  <span data-feather="disc" class="rui-icon rui-icon-stroke-1_5"></span> 200 GB
                </div>
                <div class="rui-widget-server-chart">
                  <canvas
                    class="rui-chartjs rui-chartjs-line rui-chartjs-disc"
                    data-height="80"
                    data-chartjs-interval="3000"
                    data-chartjs-line-color="#2bb7ef"
                  ></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="rui-widget rui-widget-server">
                <div class="rui-widget-head">
                  <h4 class="rui-widget-title">CPU Usage</h4>
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
                <div class="rui-widget-content mnt-5">
                  <span data-feather="cpu" class="rui-icon rui-icon-stroke-1_5"></span> 2x 3.60 MHz
                </div>
                <div class="rui-widget-server-chart">
                  <canvas
                    class="rui-chartjs rui-chartjs-line rui-chartjs-cpu"
                    data-height="80"
                    data-chartjs-interval="3000"
                    data-chartjs-line-color="#6bdea7"
                  ></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="rui-gap-3"></div>
          <h2>Earnings by Countries</h2>
          <div class="row vertical-gap">
            <div class="col-lg-8">
              <div class="rui-widget p-0">
                <div class="rui-jqvmap"></div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="rui-widget">
                <div class="rui-widget-content">
                  <ul
                    class="list-group list-group-flush rui-widget-list rui-widget-country-list rui-scrollbar"
                  >
                    <li class="list-group-item">
                      <div class="media media-filled media-country active">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/united-states-of-america.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">United States</div>
                            <div class="media-country-price">$795.43</div>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled media-country">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/germany.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">Germany</div>
                            <div class="media-country-price">$382.57</div>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled media-country">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/france.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">France</div>
                            <div class="media-country-price">$181.58</div>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled media-country">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/canada.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">Canada</div>
                            <div class="media-country-price">$126.98</div>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled media-country">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/netherlands.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">Netherlands</div>
                            <div class="media-country-price">$83.02</div>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled media-country">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/italy.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">Italy</div>
                            <div class="media-country-price">$79.63</div>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled media-country">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/russia.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">Russia</div>
                            <div class="media-country-price">$74.39</div>
                          </span>
                        </a>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="media media-filled media-country">
                        <a href="#" class="media-link">
                          <span class="media-img">
                            <img src="/img/czech-republic.svg" alt />
                          </span>
                          <span class="media-body">
                            <div class="media-title">Czech Republic</div>
                            <div class="media-country-price">$74.29</div>
                          </span>
                        </a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>-->
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent.vue";

  export default {
    name: "SuperAdminDashboard",
    props: {
      total_savings_amount: Number,
      total_uncleared_interests_amount: Number,
      total_cleared_interests_amount: Number,
      total_daily_credits: Number,
      total_daily_payouts: Number,
      total_users: Number,
      total_independent_users: Number,
      total_smart_savings_amount: Number,
      total_target_savings_amount: Number,
      total_investment_savings_amount: Number
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
