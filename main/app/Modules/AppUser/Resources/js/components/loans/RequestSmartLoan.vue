<template>
  <layout title="My Profile" :isAuth="false">
    <div class="container-fluid" v-if="!is_eligible">
      <div class="row">
        <div class="col-lg-6 col-xl-5 text-center mb-35 mb-lg-0">
          <div class="align-items-center justify-content-between mb-25">
            <h1 class="display-1">Sorry</h1>
            <p class="lead">You are not eligible for Smartloans at this time.</p>
          </div>
          <div class="col-12">
            <inertia-link
              :href="$route('appuser.smart-loan.logs')"
              class="btn btn-primary btn-long"
            >
              <span class="text">View Smartloan Logs</span>
              <span class="icon">
                <span data-feather="arrow-right-circle" class="rui-icon rui-icon-stroke-1_5"></span>
              </span>
            </inertia-link>
          </div>
        </div>

        <div class="col-xl-7 col-lg-6">
          <div class="card">
            <div class="card-body p-0">
              <ul class="list-group list-group-flush rui-profile-task-list">
                <li class="list-group-item active bg-primary">
                  <h2
                    class="card-title mnb-6 text-light text-center display-4 p-5"
                  >Ineligibility Reasons</h2>
                </li>
                <li
                  class="list-group-item p-0 px-sm-4"
                  v-for="(reason, idx) in eligibility_failures"
                  :key="idx"
                >
                  <div class="rui-task rui-task-warning">
                    <div class="rui-task-icon">
                      <span data-feather="alert-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                    </div>
                    <div class="rui-task-content">
                      <a class="rui-task-title" href="#">{{reason}}</a>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid" v-else-if="is_eligible">
      <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-6">
          <div class="d-flex align-items-center justify-content-between mb-25">
            <h2 class="mnb-2" id="formBase">You may be eligible for a SmartLoan</h2>
          </div>
          <form class="#">
            <div class="row vertical-gap sm-gap">
              <div class="col-8">
                <label for="loanAmount">Enter an amount to check</label>
                <input type="text" class="form-control" id="loanAmount" placeholder="Loan Amount" />
                <br />
                <p class="text-danger">
                  <em>
                    <strong>{{interest_rate}}% interest rate</strong> would be deducted from
                    the loan amount. See our
                    <a :href="$route('app.faqs')">FAQs</a> for more information
                  </em>
                </p>
              </div>
              <!-- <span class="fas fa-check"></span> -->
              <div class="col-6">
                <label for="exampleBase1">Provide Sureties Email Address</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span data-feather="at-sign" class="rui-icon rui-icon-stroke-1_5"></span>
                    </div>
                  </div>
                  <input type="email" class="form-control" id="exampleBase2" placeholder="Surety 1" />
                </div>
                <br />
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span data-feather="at-sign" class="rui-icon rui-icon-stroke-1_5"></span>
                    </div>
                  </div>
                  <input type="email" class="form-control" id="exampleBase2" placeholder="Surety 2" />
                </div>
              </div>
              <div class="col-12">
                <button type="button" class="btn btn-primary btn-long">
                  <span class="text">Verify Sureties</span>
                  <span class="icon">
                    <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 col-xl-4">
          <div class="rui-widget rui-widget-actions">
            <div class="rui-widget-head">
              <h4 class="rui-widget-title">Note</h4>
            </div>
            <div class="rui-widget-content">
              <ul class="list-group list-group-flush rui-widget-list">
                <li class="list-group-item">
                  <div class="media media-filled">
                    <a href="#" class="media-link">
                      <span class="media-img bg-transparent">
                        <img src="/img/exclamation-mark.svg" class="icon-file" alt />
                      </span>
                      <span class="media-body">
                        <span class="media-title">
                          Please do not use a surety that hasn't
                          given
                          you authorization to make use of his/her details. Else your
                          request may be declined.
                        </span>
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

    <div class="container-fluid" v-else-if="is_eligible && is_surety_verified">
      <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-6">
          <div class="d-flex align-items-center justify-content-between mb-25">
            <h2 class="mnb-2" id="formBase">Your SmartLoan Request was verified successfully</h2>
          </div>
          <div class="row vertical-gap sm-gap">
            <div class="col-6">
              <div class="col-12">
                <p>
                  <strong>Total Amount:</strong> ₦50,000
                </p>
                <p>
                  <strong>Interest Rate:</strong> 10%
                </p>
                <p>
                  <strong>Requested Amount:</strong> ₦45,000
                </p>
              </div>
              <div class="col-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text verified">
                      <span data-feather="check" class="rui-icon rui-icon-stroke-1_5"></span>
                    </div>
                  </div>
                  <input
                    type="email"
                    disabled
                    class="form-control"
                    id="exampleBase2"
                    placeholder="Hannah@vibes.com"
                  />
                </div>
                <br />
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text verified">
                      <span data-feather="check" class="rui-icon rui-icon-stroke-1_5"></span>
                    </div>
                  </div>
                  <input
                    type="email"
                    disabled
                    class="form-control"
                    id="exampleBase2"
                    placeholder="itse@sagay.com"
                  />
                </div>
              </div>
              <br />
              <div class="col-12">
                <label for="exampleBase1">Refund Installation Methods</label>
                <select class="custom-select">
                  <option selected>Select</option>
                  <option value="1">₦5,000 / Month (6 Months)</option>
                  <option value="1">₦834 / Week</option>
                </select>
              </div>
              <br />
              <div class="col-12">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="customSwitch1" />
                  <label class="custom-control-label" for="customSwitch1">
                    <strong>AutoDebit</strong>
                    <span class="text-danger">
                      (Always ensure you have sufficient funds on your
                      card)
                    </span>
                  </label>
                </div>
              </div>
              <br />
              <div class="col-12">
                <label for="exampleBase1">Select Date</label>
                <input
                  class="rui-datetimepicker form-control w-auto"
                  type="text"
                  placeholder="Select a date"
                  data-datetimepicker-format="m.d.Y"
                  data-datetimepicker-time="false"
                />
                <br />
                <p>
                  <strong>Valid till:</strong> 09/05/2020 10:57:43 PM
                  <span class="text-danger">(Including 30 day grace period)</span>
                </p>
              </div>
              <div class="col-12">
                <button type="button" class="btn btn-success btn-long">
                  <span class="text">Submit Request</span>
                  <span class="icon">
                    <span data-feather="check-square" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                </button>&nbsp;
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid" v-else-if="is_eligible && is_surety_verified && is_loan_requested">
      <div class="col-lg-4 col-xl-4">
        <div class="rui-widget rui-widget-actions">
          <div class="rui-widget-head">
            <h4 class="rui-widget-title">SmartLoan Request</h4>
          </div>
          <div class="rui-widget-content">
            <ul class="list-group list-group-flush rui-widget-list">
              <li class="list-group-item">
                <div class="media media-filled">
                  <a href="#" class="media-link">
                    <span class="media-img bg-transparent">
                      <img src="/img/tick.svg" class="icon-file" alt />
                    </span>
                    <span class="media-body">
                      <span
                        class="media-title"
                      >Your SmartLoan request has been submitted. Kindly contact your sureties to approve your request. You will be paid as soon as they confirm your request</span>
                    </span>
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "RequestSmartLoan",
    mixins: [mixins],
    props: {
      is_eligible: Boolean,
      is_eligible_for_amount: Boolean,
      is_surety_verified: Boolean,
      is_loan_requested: Boolean,
      eligibility_failures: Array,
      interest_rate: Number
    },
    components: {
      Layout
    },
    data: () => {
      return {};
    }
  };
</script>

<style lang="scss" scoped>
  .display-4 {
    @media (max-width: 991px) {
      font-size: 1.4rem !important;
    }
  }
</style>
