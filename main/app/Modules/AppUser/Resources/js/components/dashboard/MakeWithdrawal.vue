<template>
  <div class="plyenz-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="widget3">
            <div class="row no-gap bordered">
              <div class="col-lg-3 col-md-6">
                <!-- card -->
                <div class="card">
                  <div class="card-body">
                    <div class="widget3-item">
                      <div class="widget3-icon">
                        <i class="fas fa-wallet"></i>
                      </div>
                      <div class>
                        <span class="widget3-value">
                          <strong>{{ userDetails.total_deposit | currency(userDetails.currency) }}</strong>
                        </span>
                        <span class="widget3-label">Total Deposit</span>
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
                          <strong>{{ userDetails.total_profit | currency(userDetails.currency) }}</strong>
                        </span>
                        <span class="widget3-label">Total Profit</span>
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
                        <i class="fas fa-chart-line"></i>
                      </div>
                      <div class>
                        <span class="widget3-value">
                          <strong>{{ userDetails.target_profit | currency(userDetails.currency) }}</strong>
                        </span>
                        <span class="widget3-label">Target Profit</span>
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
                        <i class="fas fa-money-bill-wave"></i>
                      </div>
                      <div class>
                        <span class="widget3-value">
                          <strong>{{ userDetails.total_withdrawable | currency(userDetails.currency) }}</strong>
                        </span>
                        <span class="widget3-label">Total Withdrawable</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- card #end -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-title">
              <h4>CHOOSE WITHDRAWAL METHOD</h4>
            </div>
            <div class="card-body">
              <form @submit.prevent="makeWthRequest" novalidate>
                <div class="row">
                  <div class="col-md-6">
                    <div class="flex j-c-between">
                      <label class="control control-radio">
                        <span>Western Union</span>
                        <input
                          type="radio"
                          name="wthPaymentOption"
                          v-model="details.wthPaymentOption"
                          value="western"
                        />
                        <span class="control-icon"></span>
                      </label>
                      <div class="mr-300">
                        <i class="fas fa-money-bill-wave fs-22 text-gplus"></i>
                      </div>
                    </div>
                    <div class="flex j-c-between mt-20">
                      <label class="control control-radio">
                        <span>Bank Transfer</span>
                        <input
                          type="radio"
                          name="wthPaymentOption"
                          v-model="details.wthPaymentOption"
                          value="bank"
                        />
                        <span class="control-icon"></span>
                      </label>
                      <div class="mr-300">
                        <i class="fab fa-cc-amazon-pay fs-22"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="flex j-c-between">
                      <label class="control control-radio">
                        <span>Moneygram</span>
                        <input
                          type="radio"
                          name="wthPaymentOption"
                          v-model="details.wthPaymentOption"
                          value="moneygram"
                        />
                        <span class="control-icon"></span>
                      </label>
                      <div class="mr-300">
                        <i class="fas fa-money-check-alt fs-22 text-paypal"></i>
                      </div>
                    </div>
                    <div class="flex j-c-between mt-20">
                      <label class="control control-radio">
                        <span>Bitcoin</span>
                        <input
                          type="radio"
                          name="wthPaymentOption"
                          v-model="details.wthPaymentOption"
                          value="btc"
                        />
                        <span class="control-icon"></span>
                      </label>
                      <div class="mr-300">
                        <i class="fab fa-bitcoin fs-22 text-rss"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <hr />
                <div class="form-group">
                  <label class="required" for="form-wthAmt">
                    <strong>Amount</strong>
                  </label>
                  <input
                    type="text"
                    class="form-control"
                    id="form-wthAmt"
                    name="wthAmt"
                    v-model="details.wthAmt"
                    data-vv-as="amount"
                    v-validate="`required|decimal:2|max_value:${userDetails.total_withdrawable}|min_value:${userDetails.total_withdrawable}`"
                  />
                  <small
                    v-show="errors.has('wthAmt')"
                    class="help text-danger"
                  >{{ errors.first('wthAmt') }}</small>
                </div>
                <!-- <transition name="fade" mode="out-in" :duration="{ enter: 1300, leave: 200 }"> -->
                <div v-if="wthOthersMethod" id="wthOthersMethod">
                  <div class="form-group">
                    <label class="required" for="form-rn-1">
                      <strong>Receiver Name</strong>
                    </label>
                    <input
                      type="text"
                      class="form-control"
                      id="form-rn-1"
                      name="wthReceiverName"
                      v-model="details.wthReceiverName"
                      data-vv-as="Receiver Name"
                      v-validate="`required|regex:^([a-zA-Z\\s-\.]+)`"
                    />
                    <small
                      v-show="errors.has('wthReceiverName')"
                      class="help text-danger"
                    >{{ errors.first('wthReceiverName') }}</small>
                  </div>
                  <div class="form-group">
                    <label class="required" for="form-tq-1">
                      <strong>Test Question</strong>
                    </label>
                    <input
                      type="text"
                      class="form-control"
                      id="form-tq-1"
                      name="wthSecretQuestion"
                      v-model="details.wthSecretQuestion"
                      data-vv-as="Test Question"
                      v-validate="`required|regex:^([0-9a-zA-Z\\s-\.]+)`"
                    />
                    <small
                      v-show="errors.has('wthSecretQuestion')"
                      class="help text-danger"
                    >{{ errors.first('wthSecretQuestion') }}</small>
                  </div>
                  <div class="form-group">
                    <label class="required" for="form-ans-1">
                      <strong>Answer</strong>
                    </label>
                    <input
                      type="text"
                      class="form-control form-mask-1"
                      id="form-ans-1"
                      name="wthSecretAnswer"
                      v-model="details.wthSecretAnswer"
                      data-vv-as="Answer"
                      v-validate="`required|regex:^([0-9a-zA-Z\\s-\.]+)`"
                    />
                    <small
                      v-show="errors.has('wthSecretAnswer')"
                      class="help text-danger"
                    >{{ errors.first('wthSecretAnswer') }}</small>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="required" for="form-country">
                          <strong>Country</strong>
                          <small class="ml-10"></small>
                        </label>
                        <input
                          type="text"
                          class="form-control form-mask-2"
                          id="form-country"
                          name="wthCountry"
                          v-model="details.wthCountry"
                          data-vv-as="Country"
                          v-validate="`required|regex:^([0-9a-zA-Z\\s-\.]+)`"
                        />
                        <small
                          v-show="errors.has('wthCountry')"
                          class="help text-danger"
                        >{{ errors.first('wthCountry') }}</small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="required" for="form-id-card">
                          <strong>ID Card Type</strong>
                        </label>
                        <input
                          type="text"
                          class="form-control form-mask-3"
                          id="form-id-card"
                          name="wthIDType"
                          v-model="details.wthIDType"
                          data-vv-as="ID Card Type"
                          v-validate="`required|regex:^([0-9a-zA-Z\\s-\.]+)`"
                        />
                        <small
                          v-show="errors.has('wthIDType')"
                          class="help text-danger"
                        >{{ errors.first('wthIDType') }}</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="wthBankMethod" id="wthBankMethod">
                  <div class="form-group">
                    <label class="required" for="form-rn-1">
                      <strong>Account Name</strong>
                    </label>
                    <input
                      type="text"
                      class="form-control"
                      id="form-rn-1"
                      name="wthAccName"
                      v-model="details.wthAccName"
                      data-vv-as="Account Name"
                      v-validate="`required|regex:^([a-zA-Z\\s-\.]+)`"
                    />
                    <small
                      v-show="errors.has('wthAccName')"
                      class="help text-danger"
                    >{{ errors.first('wthAccName') }}</small>
                  </div>
                  <div class="form-group">
                    <label class="required" for="form-tq-1">
                      <strong>Account Number</strong>
                    </label>
                    <input
                      type="text"
                      class="form-control"
                      id="form-tq-1"
                      name="wthAccNum"
                      v-model="details.wthAccNum"
                      data-vv-as="Account Number"
                      v-validate="`required|numeric`"
                    />
                    <small
                      v-show="errors.has('wthAccNum')"
                      class="help text-danger"
                    >{{ errors.first('wthAccNum') }}</small>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="required" for="form-ans-1">
                          <strong>Receiving Bank</strong>
                        </label>
                        <input
                          type="text"
                          class="form-control form-mask-1"
                          id="form-ans-1"
                          name="wthAccBank"
                          v-model="details.wthAccBank"
                          data-vv-as="Receiving Bank"
                          v-validate="`required|regex:^([0-9a-zA-Z\\s-\.]+)`"
                        />
                        <small
                          v-show="errors.has('wthAccBank')"
                          class="help text-danger"
                        >{{ errors.first('wthAccBank') }}</small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="required" for="form-country">
                          <strong>Country</strong>
                          <small class="ml-10"></small>
                        </label>
                        <input
                          type="text"
                          class="form-control form-mask-2"
                          id="form-country"
                          name="wthCountry"
                          v-model="details.wthCountry"
                          data-vv-as="Country"
                          v-validate="`required|regex:^([0-9a-zA-Z\\s-\.]+)`"
                        />
                        <small
                          v-show="errors.has('wthCountry')"
                          class="help text-danger"
                        >{{ errors.first('wthCountry') }}</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="wthBitcoinMethod" id="wthBitcoinMethod">
                  <div class="form-group">
                    <label class="required" for="form-rn-1">
                      <strong>Bitcoin Wallet Address</strong>
                    </label>
                    <input
                      type="text"
                      class="form-control"
                      id="form-rn-1"
                      name="wthBitcoinAcc"
                      v-model="details.wthBitcoinAcc"
                      data-vv-as="wallet address"
                      v-validate="`required|regex:^([0-9a-zA-Z\-\=\_\/\.\@]+)`"
                    />
                    <small
                      v-show="errors.has('wthBitcoinAcc')"
                      class="help text-danger"
                    >{{ errors.first('wthBitcoinAcc') }}</small>
                  </div>
                </div>
                <!-- </transition> -->

                <button class="btn btn-primary btn-md btn-round">Request Withdrawal</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-12" v-if="!!wthRequests.length">
          <!-- card -->
          <div class="card">
            <div class="card-title">
              <h4>WITHDRAWAL REQUESTS</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-whs-nowrap">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Payment Option</th>
                      <th>Amount</th>
                      <th>Wallet Address</th>
                      <th>Receiver Name</th>
                      <th>Test Question</th>
                      <th>Answer</th>
                      <th>Id Type</th>
                      <th>Acc Name</th>
                      <th>Acc Nun</th>
                      <th>Bank</th>
                      <th>Country</th>
                      <!-- <th>Fee</th> -->
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="wth in wthRequests" :key="wth.id">
                      <td>{{ wth.created_at }}</td>
                      <td class="text-success">{{ wth.payment_option}}</td>
                      <td>{{ wth.amount | currency(userDetails.currency) }}</td>
                      <td>{{ wth.bitcoin_acc || 'N/A' }}</td>
                      <td>{{ wth.receiver_name || 'N/A' }}</td>
                      <td>{{ wth.secret_question || 'N/A' }}</td>
                      <td>{{ wth.secret_answer || 'N/A' }}</td>
                      <td>{{ wth.id_type || 'N/A' }}</td>
                      <td>{{ wth.acc_name || 'N/A' }}</td>
                      <td>{{ wth.acc_num || 'N/A' }}</td>
                      <td>{{ wth.acc_bank || 'N/A' }}</td>
                      <td>{{ wth.country || 'N/A' }}</td>
                      <!-- <td>
                        <span class="text-danger">-$8.00</span>
                      </td>-->
                      <td>
                        <div class="badge badge-warning badge-pill w-75">Pending</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- card #end -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  // import { withdrawFunds, withdrawalRequests } from "@dashboard-assets/js/config";
  export default {
    name: "MakeWithdrawal",
    mixins: [mixins],
    data: () => ({
      details: {},
      wthRequests: {}
    }),
    created() {
      axios
        .get(withdrawalRequests)
        .then(({ status, data: { data: withdrawalRequests } }) => {
          if (status == 200) {
            this.wthRequests = withdrawalRequests;
          } else {
            Toast.fire({
              title: "Oops",
              text:
                "There was an error retrieving information about your withdrawal requests",
              type: "warning",
              timer: 10000
            });
          }
        });
    },
    mounted() {
      this.$emit("page-loaded");
    },
    methods: {
      makeWthRequest() {
        if (this.validateUserInput()) {
          BlockToast.fire({
            text: "Processing request..."
          });
          return axios
            .put(withdrawFunds, {
              ...this.details
            })
            .then(rsp => {
              console.log(rsp);

              if (rsp.status == 205) {
                sessionStorage.setItem(
                  "userDetails",
                  '{"total_deposit":0,"total_withdrawal":0,"total_profit":0,"target_profit":0,"total_withdrawable":0}'
                );
                sessionStorage.removeItem("LOG_IN_TIME");
                swal
                  .fire({
                    title: "Success",
                    text:
                      "Your withdrawal requst has been processed successfully. A rep will get in touch with you shortly",
                    type: "success"
                  })
                  .then(() => {
                    location.reload();
                  });
                return true;
              }
            })
            .catch(err => {
              if (err.response && err.response.status == 409) {
                swal.fire({
                  title: "Not Approved",
                  text: err.response.data.msg,
                  type: "warning"
                });
              } else if (err.response && err.response.status == 423) {
                swal.fire({
                  title: "Oops",
                  text: err.response.data.msg,
                  type: "info"
                });
              }
            });
        }
      },
      validateUserInput() {
        let validatedFieldsStatus = false;

        if (undefined == this.details.wthPaymentOption) {
          Toast.fire({
            title: "Select a payment method",
            type: "error",
            position: "center"
          });
        } else if (this.details.wthAmt && this.details.wthAmt <= 0) {
          Toast.fire({
            title: "Insufficient funds",
            type: "error",
            position: "center"
          });
        } else if (this.details.wthPaymentOption == "btc") {
          this.validateFormField("wthBitcoinAcc");
          validatedFieldsStatus =
            this.isFormFieldValid("wthBitcoinAcc") &&
            this.isFormFieldValid("wthAmt");

          if (!validatedFieldsStatus) {
            Toast.fire({
              title: "Invalid data",
              text: "Check your entries and try again!",
              type: "error",
              position: "center"
            });
          }
        } else if (
          this.details.wthPaymentOption == "moneygram" ||
          this.details.wthPaymentOption == "western"
        ) {
          this.validateFormField("wthReceiverName");
          this.validateFormField("wthSecretQuestion");
          this.validateFormField("wthSecretAnswer");
          this.validateFormField("wthIDType");

          validatedFieldsStatus =
            // this.$refs.wthCountrySelect.isValid() &&
            this.isFormFieldValid("wthReceiverName") &&
            this.isFormFieldValid("wthAmt") &&
            this.isFormFieldValid("wthSecretQuestion") &&
            this.isFormFieldValid("wthSecretAnswer") &&
            this.isFormFieldValid("wthIDType");

          // this.$refs.wthCountrySelect.validate();

          if (!validatedFieldsStatus) {
            Toast.fire({
              title: "Invalid data",
              text: "Check your entries and try again!",
              type: "error",
              position: "center"
            });
          }
        } else if (this.details.wthPaymentOption == "bank") {
          this.$refs.wthCountrySelect.validate();
          this.validateFormField("wthAccName");
          this.validateFormField("wthAccNum");
          this.validateFormField("wthAccBank");

          validatedFieldsStatus =
            // this.$refs.wthCountrySelect.isValid() &&
            this.isFormFieldValid("wthAccName") &&
            this.isFormFieldValid("wthAmt") &&
            this.isFormFieldValid("wthAccNum") &&
            this.isFormFieldValid("wthAccBank");

          if (!validatedFieldsStatus) {
            Toast.fire({
              title: "Invalid data",
              text: "Check your entries and try again!",
              type: "error",
              position: "center"
            });
          }
        }

        return validatedFieldsStatus;
      },
      isFormFieldValid(field) {
        let isValid = false;
        if (this.fields[field]) {
          isValid = this.fields[field].validated && this.fields[field].valid;
        }
        return isValid;
      },
      validateFormField(fieldName) {
        this.$validator.validate("wthAmt", this.details["wthAmt"]);
        this.$validator.validate(fieldName, this.details[fieldName]);
      }
    },
    computed: {
      wthOthersMethod() {
        return (
          this.details.wthPaymentOption == "western" ||
          this.details.wthPaymentOption == "moneygram"
        );
      },
      wthBankMethod() {
        return this.details.wthPaymentOption == "bank";
      },
      wthBitcoinMethod() {
        return this.details.wthPaymentOption == "btc";
      }
    },
    watch: {
      "details.wthPaymentOption": function(newVal) {
        delete this.details.wthBitcoinAcc;
        delete this.details.wthCountry;
        delete this.details.wthReceiverName;
        delete this.details.wthSecretQuestion;
        delete this.details.wthSecretAnswer;
        delete this.details.wthIDType;
        delete this.details.wthAccName;
        delete this.details.wthAccNum;
        delete this.details.wthAccBank;
      }
    }
  };
</script>

<style lang="scss" scoped>
  .mr-300 {
    @media (max-width: 576px) {
      margin-right: 50px !important;
    }
    @media (min-width: 577px) and (max-width: 996px) {
      margin-right: 100px !important;
    }
    @media (min-width: 997px) and (max-width: 1199px) {
      margin-right: 200px !important;
    }
  }

  .j-c-between {
    &.mt-20 {
      @media (max-width: 767px) {
        margin-top: 0 !important;
      }
    }
  }
  .table-responsive {
    overflow-x: auto;
  }
</style>
