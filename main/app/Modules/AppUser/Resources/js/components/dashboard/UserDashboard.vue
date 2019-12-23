<template>
  <!-- main content -->
  <div class="plyenz-main">
    <div class="container">
      <div class="card-heading">
        <h4 class="card-heading-title">Overview</h4>
      </div>
      <div class="row">
        <!-- card -->
        <div class="col-lg-3 col-md-6">
          <div class="card card-hover card-animation">
            <div class="card-body">
              <div class="widget1">
                <div class="widget1-icon bg-pale-info">
                  <i class="fa fa-users text-info"></i>
                </div>
                <span class="widget1-value">17.5K+</span>
                <span class="widget1-label">Total Followers</span>
                <div class="status-down">
                  17.15 %
                  <i class="fa fa-angle-down"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- card #end -->

        <!-- card -->
        <div class="col-lg-3 col-md-6">
          <div class="card card-hover card-animation">
            <div class="card-body">
              <div class="widget1">
                <div class="widget1-icon bg-pale-success">
                  <i class="fas fa-money-bill text-success"></i>
                </div>
                <span class="widget1-value">$22.736</span>
                <span class="widget1-label">Weekly Balance</span>
                <div class="status-up">
                  20.15 %
                  <i class="fa fa-angle-up"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- card #end -->

        <!-- card -->
        <div class="col-lg-3 col-md-6">
          <div class="card card-hover card-animation">
            <div class="card-body">
              <div class="widget1">
                <div class="widget1-icon bg-pale-purple">
                  <i class="fa fa-shopping-cart text-purple"></i>
                </div>
                <span class="widget1-value">816</span>
                <span class="widget1-label">Today's Order</span>
                <div class="status-down">
                  1.35 %
                  <i class="fa fa-angle-down"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- card #end -->

        <!-- card -->
        <div class="col-lg-3 col-md-6">
          <div class="card card-hover card-animation">
            <div class="card-body">
              <div class="widget1">
                <div class="widget1-icon bg-pale-info">
                  <i class="fa fa-users text-info"></i>
                </div>
                <span class="widget1-value">31.27 %</span>
                <span class="widget1-label">Total Balance</span>
                <div class="status-up">
                  3.00 %
                  <i class="fa fa-angle-up"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- card #end -->
      </div>

      <div class="row">
        <div class="col-lg-9 col-md-12">
          <div class="card">
            <div class="card-title">
              <h4>VISITORS</h4>
              <ul class="nav nav-fill nav-sm">
                <li class="nav-item">
                  <a href class="nav-link active">Day</a>
                </li>
                <li class="nav-item">
                  <a href class="nav-link">Week</a>
                </li>
                <li class="nav-item">
                  <a href class="nav-link">Month</a>
                </li>
              </ul>
            </div>
            <div class="card-body pb-0">
              <div class="card-value-text text-lg">
                <span class="label">Avg Sessions</span>
                <div class="value">17.247</div>
              </div>
              <div class="card-row p-0">
                <canvas id="chart-area" height="80"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-12">
          <div class="card card-hover">
            <div class="card-title">
              <h4>ONLINE</h4>
            </div>
            <div class="card-body">
              <div class="card-value-text text-lg mb-30">
                <span class="label">Online Visitor</span>
                <div class="value">127</div>
              </div>
              <div>
                <span>Windows (55%)</span>
                <div class="progress progress-sm mb-20">
                  <div
                    class="progress-bar bg-purple"
                    role="progressbar"
                    style="width: 55%"
                    aria-valuenow="55"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
              </div>
              <div>
                <span>Mac OSX (20%)</span>
                <div class="progress progress-sm mb-20">
                  <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width: 20%"
                    aria-valuenow="20"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
              </div>
              <div>
                <span>Linux (15%)</span>
                <div class="progress progress-sm mb-20">
                  <div
                    class="progress-bar bg-info"
                    role="progressbar"
                    style="width: 15%"
                    aria-valuenow="15"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
              </div>
              <div>
                <span>Other (10%)</span>
                <div class="progress progress-sm mb-20">
                  <div
                    class="progress-bar bg-warning"
                    role="progressbar"
                    style="width: 10%"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="widget3">
        <div class="row no-gap bordered">
          <div class="col-lg-3 col-md-6">
            <!-- card -->
            <div class="card">
              <div class="card-body">
                <div class="widget3-item">
                  <div class="widget3-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                  <div class>
                    <span class="widget3-value">
                      <strong>32475 MB</strong>
                    </span>
                    <span class="widget3-label">Today`s Bandwidth</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- card #end -->
          </div>
          <div class="col-lg-3 col-md-6">
            <!-- card -->
            <div class="card">
              <div class="card-body">
                <div class="widget3-item">
                  <div class="widget3-icon">
                    <i class="fas fa-coins"></i>
                  </div>
                  <div class>
                    <span class="widget3-value">
                      <strong>$4767</strong>
                    </span>
                    <span class="widget3-label">Today's Earnings</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- card #end -->
          </div>
          <div class="col-lg-3 col-md-6">
            <!-- card -->
            <div class="card">
              <div class="card-body">
                <div class="widget3-item">
                  <div class="widget3-icon">
                    <i class="fas fa-users"></i>
                  </div>
                  <div class>
                    <span class="widget3-value">
                      <strong>3154</strong>
                    </span>
                    <span class="widget3-label">Today's Customers</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- card #end -->
          </div>
          <div class="col-lg-3 col-md-6">
            <!-- card -->
            <div class="card">
              <div class="card-body">
                <div class="widget3-item">
                  <div class="widget3-icon">
                    <i class="fas fa-box"></i>
                  </div>
                  <div class>
                    <span class="widget3-value">
                      <strong>7468</strong>
                    </span>
                    <span class="widget3-label">Products on Sale</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- card #end -->
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3 col-md-12">
          <div class="card card-hover">
            <div class="card-title">
              <h4>DEVICES</h4>
            </div>
            <div class="card-body">
              <div class="widget2">
                <div class="chart-wrapper">
                  <canvas id="chart-donut"></canvas>
                </div>
                <div class="widget2-list">
                  <div class="widget2-item">
                    <div>
                      <span class="badge badge-primary badge-dot badge-md"></span>
                      <span>Android</span>
                    </div>
                    <span class="value">1277</span>
                  </div>
                  <div class="widget2-item">
                    <div>
                      <span class="badge badge-info badge-dot badge-md"></span>
                      <span>IOS</span>
                    </div>
                    <span class="value">916</span>
                  </div>
                  <div class="widget2-item">
                    <div>
                      <span class="badge badge-danger badge-dot badge-md"></span>
                      <span>Windows</span>
                    </div>
                    <span class="value">869</span>
                  </div>
                  <div class="widget2-item">
                    <div>
                      <span class="badge badge-warning badge-dot badge-md"></span>
                      <span>Other</span>
                    </div>
                    <span class="value">175</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-md-12">
          <div class="card">
            <div class="card-title">
              <h4>LASTEST SELLINGS</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Chris Martin</td>
                      <td>Apple iPhone X</td>
                      <td>$2100</td>
                      <td>
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <td>Chris Martin</td>
                      <td>Apple iPhone X</td>
                      <td>$2100</td>
                      <td>
                        <span class="badge badge-warning">Pending</span>
                      </td>
                    </tr>
                    <tr>
                      <td>Chris Martin</td>
                      <td>Apple iPhone X</td>
                      <td>$2100</td>
                      <td>
                        <span class="badge badge-danger">Problem</span>
                      </td>
                    </tr>
                    <tr>
                      <td>Chris Martin</td>
                      <td>Apple iPhone X</td>
                      <td>$2100</td>
                      <td>
                        <span class="badge badge-info">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <td>Chris Martin</td>
                      <td>Apple iPhone X</td>
                      <td>$2100</td>
                      <td>
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-title">
              <h4>PEOPLES</h4>
            </div>
            <div class="card-body">
              <div class="card-row">
                <div class="widget5">
                  <div class="widget5-item">
                    <div class="avatar avatar-lg mr-20">
                      <img src="/img/avatar1.jpg" class="img-responsive" alt="..." />
                    </div>
                    <div class="widget5-text">
                      <div class="widget5-label">Micheal Deep</div>
                      <span>Back-end Developer</span>
                    </div>
                    <a href class="btn btn-primary btn-round btn-icon">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>
                  <div class="widget5-item">
                    <div class="avatar avatar-lg mr-20">
                      <img src="/img/avatar2.jpg" class="img-responsive" alt="..." />
                    </div>
                    <div class="widget5-text">
                      <div class="widget5-label">Karl Dole</div>
                      <span>UX Engineer</span>
                    </div>
                    <a href class="btn btn-primary btn-round btn-icon">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>
                  <div class="widget5-item">
                    <div class="avatar avatar-lg mr-20">
                      <img src="/img/avatar3.jpg" class="img-responsive" alt="..." />
                    </div>
                    <div class="widget5-text">
                      <div class="widget5-label">Dogukan</div>
                      <span>UI Engineer</span>
                    </div>
                    <a href class="btn btn-primary btn-round btn-icon">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>
                  <div class="widget5-item">
                    <div class="avatar avatar-lg mr-20">
                      <img src="/img/avatar4.jpg" class="img-responsive" alt="..." />
                    </div>
                    <div class="widget5-text">
                      <div class="widget5-label">Daniel Artson</div>
                      <span>UI Developer</span>
                    </div>
                    <a href class="btn btn-primary btn-round btn-icon">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card card-hover">
            <div class="card-body text-center">
              <span class="fs-16">
                <strong>Time On Site</strong>
              </span>
              <div class="status-up">
                77.15 %
                <i class="fa fa-angle-up"></i>
              </div>
            </div>
            <div class="h-85">
              <canvas id="chart-line1"></canvas>
            </div>
          </div>
          <div class="card card-hover">
            <div class="card-body text-center">
              <span class="fs-16">
                <strong>Page Views</strong>
              </span>
              <div class="status-down">
                14.15 %
                <i class="fa fa-angle-down"></i>
              </div>
            </div>
            <div class="h-85">
              <canvas id="chart-line2"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card">
            <div class="card-title">
              <h4>ACTIVITY</h4>
            </div>
            <div class="card-body">
              <div class="widget4">
                <div class="widget4-item">
                  <span class="badge badge-success badge-dot badge-lg widget4-status"></span>
                  <span class="widget4-value">JUL 20</span>
                  <p class="widget4-label">New updates "Prepared"</p>
                </div>
                <div class="widget4-item">
                  <span class="badge badge-info badge-dot badge-lg widget4-status"></span>
                  <span class="widget4-value">JUL 19</span>
                  <p class="widget4-label">
                    2018 Reports "
                    <a href>Here</a>"
                  </p>
                </div>
                <div class="widget4-item">
                  <span class="badge badge-primary badge-dot badge-lg widget4-status"></span>
                  <span class="widget4-value">JUL 17</span>
                  <p class="widget4-label">New Event Created</p>
                </div>
                <div class="widget4-item">
                  <span class="badge badge-warning badge-dot badge-lg widget4-status"></span>
                  <span class="widget4-value">JUL 12</span>
                  <p class="widget4-label">Product stock is low "KLJ0017"</p>
                </div>
                <div class="widget4-item">
                  <span class="badge badge-warning badge-dot badge-lg widget4-status"></span>
                  <span class="widget4-value">JUL 12</span>
                  <p class="widget4-label">Product stock is low "KLJ0017"</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- main content #end -->
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  export default {
    mixins: [mixins],
    name: "UserDashboard",
    data: () => {
      return {};
    },
    components: {},
    created() {},

    mounted() {
      this.$emit("page-loaded");
    },
    methods: {}
  };
</script>

<style lang="scss" scoped>
</style>
