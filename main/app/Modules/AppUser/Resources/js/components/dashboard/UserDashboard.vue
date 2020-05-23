<template>
  <layout title="User Dashboard" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-lg-4 col-md-4">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">₦60,000.00</div>
              <small class="rui-widget-subtitle">Total Current Balance</small>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">₦60,000.86</div>
              <small class="rui-widget-subtitle">Flex Savings</small>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">₦40.01 (0.09%)</div>
              <small class="rui-widget-subtitle">Today's Interest</small>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">400.08</div>
              <small class="rui-widget-subtitle">Interest Accrued</small>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">₦137134.24</div>
              <small class="rui-widget-subtitle">Total Withdrawal</small>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">₦137134.24</div>
              <small class="rui-widget-subtitle">Total Loans</small>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-gap-2"></div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-title">
              <h4>How much do you want to save?</h4>
            </div>
            <div class="card-body">
              <inertia-link
                :href="$route('appuser.savings.distribution')"
                class="btn btn-shadow btn-info btn-w-sm"
              >100</inertia-link>
              <button type="button" class="btn btn-shadow btn-secondary btn-w-sm">200</button>
              <button type="button" class="btn btn-shadow btn-success btn-w-sm">500</button>
              <button type="button" class="btn btn-shadow btn-danger btn-w-sm">Other</button>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-gap-2"></div>

      <div class="card-heading">
        <h4 class="card-heading-title">Loans Summary</h4>
      </div>
      <div class="widget3">
        <div class="row no-gap bordered">
          <div class="col-lg-4 col-md-6">
            <div class="card mb-0">
              <div class="card-body">
                <div class="widget3-item">
                  <div class="widget3-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                  <div class>
                    <span class="widget3-value">
                      <strong>2000</strong>
                    </span>
                    <span class="widget3-label">Total Loans (2)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card mb-0">
              <div class="card-body">
                <div class="widget3-item">
                  <div class="widget3-icon">
                    <i class="fas fa-coins"></i>
                  </div>
                  <div class>
                    <span class="widget3-value">
                      <strong>40000</strong>
                    </span>
                    <span class="widget3-label">Outstanding Loans</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card mb-0">
              <div class="card-body">
                <div class="widget3-item">
                  <div class="widget3-icon">
                    <i class="fas fa-users"></i>
                  </div>
                  <div class>
                    <span class="widget3-value">
                      <strong>5000</strong>
                    </span>
                    <span class="widget3-label">Pending Loans</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-gap-3"></div>
      <div class="rui-gap-3"></div>
      <div class="card-heading">
        <h4 class="card-heading-title">Ongoing Savings</h4>
      </div>
      <div class="widget-savings">
        <div class="row no-gap bordered">
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <div class="flex j-c-between a-i-center">
                  <div>
                    <div class="fs-16 fw-600">Smart Lock</div>
                    <div class="text-light">40 days left</div>
                    <div class="status-up">
                      <span class="text-light">Today's Interest</span>
                      #50.00
                      <i class="fa fa-angle-up"></i>
                    </div>
                    <div class="status-up">
                      <span class="text-light">Accrued Interest</span>
                      #5000.00
                      <i class="fa fa-angle-up"></i>
                    </div>
                  </div>
                  <div class="fs-30 fw-600 text-primary">60000</div>
                </div>
                <div class="progress progress-xs mt-20">
                  <div
                    class="progress-bar bg-primary"
                    role="progressbar"
                    style="width: 70%;"
                    aria-valuenow="70"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <div data-v-40470ab0 class="badge badge-pill badge-success mt-20">Add more funds</div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <div class="flex j-c-between a-i-center">
                  <div>
                    <div class="fs-16 fw-600">NYSC POP Savings</div>
                    <div class="text-light">60 Days Left</div>
                    <div class="status-up">
                      <span class="text-light">Today's Interest</span>
                      #50.00
                      <i class="fa fa-angle-up"></i>
                    </div>
                    <div class="status-up">
                      <span class="text-light">Accrued Interest</span>
                      #5000.00
                      <i class="fa fa-angle-up"></i>
                    </div>
                  </div>
                  <div class="fs-30 fw-600 text-info">50000</div>
                </div>
                <div class="progress progress-xs mt-20">
                  <div
                    class="progress-bar bg-info"
                    role="progressbar"
                    style="width: 45%;"
                    aria-valuenow="45"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <div data-v-40470ab0 class="badge badge-pill badge-success mt-20">Add more funds</div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <div class="flex j-c-between a-i-center">
                  <div>
                    <div class="fs-16 fw-600">After School Savings</div>
                    <div class="text-light">364 days left</div>
                    <div class="status-up">
                      <span class="text-light">Today's Interest</span>
                      #50.00
                      <i class="fa fa-angle-up"></i>
                    </div>
                    <div class="status-up">
                      <span class="text-light">Accrued Interest</span>
                      #5000.00
                      <i class="fa fa-angle-up"></i>
                    </div>
                  </div>
                  <div class="fs-30 fw-600 text-danger">50000</div>
                </div>
                <div class="progress progress-xs mt-20">
                  <div
                    class="progress-bar bg-danger"
                    role="progressbar"
                    style="width: 20%;"
                    aria-valuenow="20"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <div data-v-40470ab0 class="badge badge-pill badge-success mt-20">Add more funds</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-gap-3"></div>
      <div class="rui-gap-3"></div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "UserDashboard",
    mixins: [mixins],
    components: { Layout },
    data: () => {
      return {};
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
