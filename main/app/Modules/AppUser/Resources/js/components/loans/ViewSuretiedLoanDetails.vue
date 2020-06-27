<template>
  <layout title="Surtied Loans" :isAuth="false">
    <div class="container-fluid p-0 p-md-5">
      <div class="col-12 col-lg-10 offset-lg-1 p-0">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col" colspan="2">Reference: {{ suretied_loan.loan_request.loan_ref }}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-primary">
                <strong>Date/Time</strong>
              </td>
              <td scope="row">
                <strong>{{ new Date(suretied_loan.loan_request.created_at).toDateString() }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Applicant</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.app_user.full_name }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Requested Amount</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.amount | Naira }}</strong>
                <em
                  class="text-danger d-block"
                >({{ ((suretied_loan.loan_request.amount * suretied_loan.loan_request.interest_rate / 100)) | Naira }} interest deducted)</em>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Interest Rate</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.interest_rate }}%</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Surety Request Status</strong>
              </td>
              <td scope="row">
                <span
                  class="badge badge-warning surties"
                  v-if="suretied_loan.is_surety_accepted == null"
                >Request Pending</span>
                <span
                  class="badge badge-danger surties"
                  v-else-if="!suretied_loan.is_surety_accepted"
                >Request Declined</span>
                <span
                  class="badge badge-success surties"
                  v-if="suretied_loan.is_surety_accepted"
                >Request Accepted</span>
                <br />
                <button
                  class="btn btn-success btn-xs"
                  v-if="suretied_loan.is_surety_accepted == null"
                  @click="respondToSuretyRequest(true)"
                >Accept</button>
                <button
                  class="btn btn-danger btn-xs"
                  v-if="suretied_loan.is_surety_accepted == null"
                  @click="respondToSuretyRequest(false)"
                >Decline</button>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Your Stake</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.stakes_for_default.surety_stake | Naira }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Applicant's Stake</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.stakes_for_default.lender_stake | Naira }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Disburse Status</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.is_disbursed ? 'Disbursed' : 'Not Disbursed' }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Time of Approval</strong>
              </td>
              <td scope="row" v-if="suretied_loan.loan_request.is_approved">
                <strong>{{ new Date(suretied_loan.loan_request.approved_at).toDateString() + ' ' + new Date(suretied_loan.loan_request.approved_at).toLocaleTimeString() }}</strong>
              </td>
              <td v-else>
                <strong>Approval Pending</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Refund Installment methods</strong>
              </td>
              <td scope="row">
                <strong>
                  {{ suretied_loan.loan_request.installments.description }}
                  <span
                    class="text-danger d-block"
                  >
                    <em>{{ suretied_loan.loan_request.installments.duration }}</em>
                  </span>
                </strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Valid till</strong>
              </td>
              <td scope="row">
                <strong>{{ new Date(suretied_loan.loan_request.expires_at).toDateString() }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Grace Period till</strong>
              </td>
              <td scope="row">
                <strong>
                  <em>{{ new Date(suretied_loan.loan_request.grace_period_expiry).toDateString() }}</em>
                </strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Total refunded</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.total_refunded | Naira }} / {{ suretied_loan.loan_request.amount | Naira }}</strong>
              </td>
            </tr>
            <tr v-if="suretied_loan.loan_request.auto_debit">
              <td class="text-primary">
                <strong>Auto refund settings</strong>
              </td>
              <td scope="row">
                <strong>{{ suretied_loan.loan_request.auto_refund_settings }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Refund status</strong>
              </td>
              <td scope="row">
                <strong>{{suretied_loan.loan_request.total_refunded / suretied_loan.loan_request.amount * 100}}% complete</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Missed Instalments</strong>
              </td>
              <td scope="row">
                <strong></strong>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "SurtiedLoanDetails",
    mixins: [mixins],
    props: {
      suretied_loan: Object
    },
    components: {
      Layout
    },
    data: () => {
      return {};
    },
    created() {
      console.log("created");

      if (!this.suretied_loan) {
        this.$inertia.replace(this.$route("appuser.smart-loan"), {
          method: "get",
          preserveState: false,
          preserveScroll: false,
          only: ["is_eligible", "eligibility_failures"]
        });
      }
    },
    methods: {
      respondToSuretyRequest(rsp) {
        let popupMsg = rsp
          ? "Notifying applicant of your acceptance"
          : "Marking surety request as declined";
        BlockToast.fire({
          text: popupMsg + "..."
        });
        this.$inertia
          .put(
            this.$route("appuser.surety.requests.respond"),
            {
              accepted: rsp
            },
            {
              preserveState: true,
              preserveScroll: true,
              only: ["suretied_loan"]
            }
          )
          .then(() => {
            if (this.flash.success) {
              ToastLarge.fire({
                title: "Success",
                html: this.flash.success,
                timer: 5000
              });
              this.flash.success = null;
            } else if (this.flash.error) {
              ToastLarge.fire({
                title: "Oops!",
                html: this.flash.error,
                timer: 5000,
                icon: "info"
              });
              this.flash.success = null;
            } else {
              swal.close();
            }
          });
      }
    }
  };
</script>

<style lang="scss" >
  .transaction-container {
    @media (min-width: 576px) {
      .modal-dialog {
        max-width: 90%;
      }
    }
    .modal-body {
      max-height: 70vh;
      overflow-y: scroll;
    }
    .rui-timeline .rui-timeline-icon {
      top: 0;
    }

    @media (min-width: 576px) and (max-width: 991px) {
      .rui-timeline .rui-timeline-line {
        left: 24%;
      }

      .rui-timeline .rui-timeline-icon {
        left: 20%;
      }

      .rui-timeline-date {
        width: 25% !important;
      }
    }
  }
  .btn-xs {
    padding: 4px 6px;
    font-size: 9px;
  }
</style>
