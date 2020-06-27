<template>
  <layout title="My Profile" :isAuth="false">
    <div class="container-fluid" v-if="is_eligible && is_surety_verified && is_loan_requested">
      <div class="col-lg-6 offset-lg-3 col-xl-4 offset-xl-2">
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

    <div class="container-fluid" v-else-if="is_eligible && is_surety_verified">
      <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-6">
          <div class="d-flex align-items-center justify-content-between mb-25">
            <h2 class="mnb-2" id="formBase">Your Smartloan sureties were verified successfully</h2>
          </div>
          <div class="row vertical-gap sm-gap">
            <div class="col-12 col-lg-6">
              <FlashMessage />
              <div class="col-12">
                <h3>Smartloan Details:</h3>
                <p>
                  <strong>Requested Amount:</strong>
                  {{loan_statistics.amount_requested | Naira }}
                </p>
                <p>
                  <strong>Interest Rate:</strong>
                  {{loan_statistics.interest_rate }}%
                </p>
                <p>
                  <strong>Amount to receive:</strong>
                  {{loan_statistics.amount_expected | Naira }}
                </p>

                <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
              </div>
              <div class="col-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text verified">
                      <span class="fas fa-check"></span>
                    </div>
                  </div>
                  <input
                    type="email"
                    disabled
                    class="form-control"
                    id="surety1"
                    :placeholder="loan_statistics.surety1"
                  />
                  <FlashMessage v-if="errors.surety1" :msg="errors.surety1[0]" />
                </div>
                <br />
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text verified">
                      <span class="fas fa-check"></span>
                    </div>
                  </div>
                  <input
                    type="email"
                    disabled
                    class="form-control"
                    id="surety2"
                    :placeholder="loan_statistics.surety2"
                  />
                  <FlashMessage v-if="errors.surety2" :msg="errors.surety2[0]" />
                </div>
              </div>
              <br />
              <div class="col-12">
                <label for="repaymentInstallationDuration">Refund Installation Methods</label>
                <select
                  class="custom-select"
                  id="repaymentInstallationDuration"
                  v-model="details.repayment_installation_duration"
                >
                  <option selected :value="null">Select</option>
                  <option
                    value="monthly"
                  >{{loan_statistics.monthly_installment_amount | Naira }} / Month</option>
                  <option
                    value="weekly"
                  >{{loan_statistics.weekly_installment_amount | Naira }} / Week</option>
                </select>
                <FlashMessage
                  v-if="errors.repayment_installation_duration"
                  :msg="errors.repayment_installation_duration[0]"
                />
              </div>
              <br />
              <div class="col-12">
                <div class="custom-control custom-switch">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="customSwitch1"
                    v-model="details.auto_debit"
                  />
                  <label class="custom-control-label" for="customSwitch1">
                    <strong class="d-block">AutoDebit</strong>
                  </label>
                  <FlashMessage v-if="errors.auto_debit" :msg="errors.auto_debit[0]" />
                </div>
                <span class="text-danger">(Always ensure you have sufficient funds on your card)</span>
              </div>
              <br />
              <div class="col-12 mb-30">
                <p class="mb-0">
                  <strong>Valid till:</strong>
                  {{loan_statistics.loan_expiration_date}}
                </p>
                <span class="text-danger">(Including 30 day grace period)</span>
              </div>
              <div class="col-12 text-center text-lg-right">
                <button type="button" class="btn btn-success btn-long" @click="makeLoanRequest">
                  <span class="text">Request Loan</span>
                  <span class="icon">
                    <span class="fas fa-chevron-circle-right"></span>
                  </span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid" v-else-if="is_eligible">
      <div class="row vertical-gap">
        <div class="col-lg-7 col-xl-6">
          <div class="d-flex align-items-center justify-content-between mb-25">
            <h2 class="mnb-2" id="formBase">You may be eligible for a SmartLoan</h2>
          </div>
          <form class="#">
            <div class="row vertical-gap sm-gap">
              <div class="col-12 col-lg-8">
                <FlashMessage />
                <label for="loanAmount">Enter an amount to check</label>
                <input
                  type="text"
                  class="form-control"
                  id="loanAmount"
                  placeholder="Loan Amount"
                  v-model="details.amount"
                />
                <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
                <br />
                <p class="text-secondary text-center text-sm-left">
                  <em>
                    <strong>{{interest_rate}}% interest rate</strong> would be deducted from
                    the loan amount. See our
                    <a
                      :href="$route('app.faqs')"
                    >FAQs</a> for more information
                  </em>
                </p>
              </div>
              <div class="col-12 col-lg-6">
                <FlashMessage v-if="errors.email" :msg="errors.email[0]" />
                <label for="details." class="text-uppercase">Provide Sureties Email Address</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div
                      class="input-group-text text-success"
                      v-if="details.surety1.isVerified"
                    >Verified</div>
                    <div
                      class="input-group-text text-danger"
                      v-else
                      @click="verifySuretyEligibility(details.surety1, 'surety1', )"
                    >
                      Verify
                      <span
                        data-feather="alert-circle"
                        class="rui-icon rui-icon-stroke-1_5 ml-5"
                      ></span>
                    </div>
                  </div>
                  <input
                    type="email"
                    class="form-control"
                    id="surety1"
                    placeholder="Surety 1"
                    :readonly="details.surety1.isVerified"
                    v-model="details.surety1.email"
                  />
                  <FlashMessage v-if="errors.surety1" :msg="errors.surety1[0]" />
                </div>
                <br />
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div
                      class="input-group-text text-success"
                      v-if="details.surety2.isVerified"
                    >Verified</div>
                    <div
                      class="input-group-text text-danger"
                      v-else
                      @click="verifySuretyEligibility(details.surety2, 'surety2')"
                    >
                      Verify
                      <span
                        data-feather="alert-circle"
                        class="rui-icon rui-icon-stroke-1_5 ml-5"
                      ></span>
                    </div>
                  </div>
                  <input
                    type="email"
                    class="form-control"
                    id="surety2"
                    :readonly="details.surety2.isVerified"
                    placeholder="Surety 2"
                    v-model="details.surety2.email"
                  />
                  <FlashMessage v-if="errors.surety2" :msg="errors.surety2[0]" />
                </div>
              </div>

              <div class="col-12 text-center text-md-right">
                <button
                  type="button"
                  class="btn btn-primary btn-long"
                  v-show="details.surety1.isVerified && details.surety2.isVerified"
                  @click="proceedToMakeLoanRequest"
                >
                  <span class="text">Proceed</span>
                  <span class="icon">
                    <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-5 col-xl-4">
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

    <div class="container-fluid" v-else>
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
            <inertia-link
              v-if="auth.user.is_loan_surety"
              :href="$route('appuser.surety.requests')"
              class="btn btn-brand btn-long mt-25 mt-md-0"
            >
              <span class="text">View Surtied Loans</span>
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
      loan_statistics: Object,
      interest_rate: Number
    },
    components: {
      Layout
    },
    remember: ["details"],
    data: () => {
      return {
        details: {
          surety1: {
            isVerified: false,
            email: null
          },
          surety2: {
            isVerified: false,
            email: null
          },
          amount: null
        }
      };
    },
    methods: {
      verifySuretyEligibility(suretyDetails, suretyPosition) {
        if (!suretyDetails.email || !this.details.amount) {
          ToastLarge.fire({
            title: "Error",
            html:
              "Enter an <b>amount</b> and a surety's <b>email address</b> to verify",
            position: "center",
            icon: "error"
          });
        } else {
          BlockToast.fire({
            text: `Verifying ${suretyDetails.email}'s eligibility...`
          });
          this.$inertia
            .post(
              this.$route("appuser.surety.verify"),
              {
                email: suretyDetails.email,
                amount: this.details.amount,
                surety: suretyPosition
              },
              {
                preserveState: true,
                preserveScroll: true,
                only: []
              }
            )
            .then(() => {
              if (this.flash.success) {
                if (suretyPosition == "surety1") {
                  this.details.surety1.isVerified = true;
                } else if (suretyPosition == "surety2") {
                  this.details.surety2.isVerified = true;
                }
              }
              swal.close();
            });
        }
      },
      proceedToMakeLoanRequest() {
        /**
         * ! Check if surety1 and surety2 are same email and not empty
         */
        if (false) {
          ToastLarge.fire({
            title: "Error",
            html:
              "Enter an <b>amount</b> and a surety's <b>email address</b> to verify",
            position: "center",
            icon: "error"
          });
        } else {
          BlockToast.fire({
            text: `Computing smartloan statistics...`
          });
          this.$inertia
            .post(
              this.$route("appuser.smart-loan"),
              {
                surety1: this.details.surety1.email,
                surety2: this.details.surety2.email,
                amount: this.details.amount
              },
              {
                preserveState: true,
                preserveScroll: true,
                only: ["is_surety_verified", "loan_statistics", "flash", "errors"]
              }
            )
            .then(() => {
              swal.close();
            });
        }
      },
      makeLoanRequest() {
        if (false) {
          ToastLarge.fire({
            title: "Error",
            html:
              "Enter an <b>amount</b> and a surety's <b>email address</b> to verify",
            position: "center",
            icon: "error"
          });
        } else {
          BlockToast.fire({
            text: `Submitting loan request...`
          });
          this.$inertia
            .post(
              this.$route("appuser.smart-loan.make-request"),
              {
                surety1: this.details.surety1.email,
                surety2: this.details.surety2.email,
                amount: this.details.amount,
                auto_debit: this.details.auto_debit,
                repayment_installation_duration: this.details
                  .repayment_installation_duration
              },
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "is_loan_requested"]
              }
            )
            .then(() => {
              swal.close();
            });
        }
      }
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
