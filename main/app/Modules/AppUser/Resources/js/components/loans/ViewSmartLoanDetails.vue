<template>
  <layout title="My Profile" :isAuth="false">
    <div class="container-fluid p-0 p-md-5">
      <div class="col-12 col-lg-10 offset-lg-1 p-0">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col" colspan="2">Reference: {{ loan_request.loan_ref }}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-primary">
                <strong>Date/Time</strong>
              </td>
              <td scope="row">
                <strong>{{ new Date(loan_request.created_at).toDateString() }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Requested Amount</strong>
              </td>
              <td scope="row">
                <strong>{{ loan_request.amount | Naira }}</strong>
                <em
                  class="text-danger d-block"
                >({{ ((loan_request.amount * loan_request.interest_rate / 100)) | Naira }} interest deducted)</em>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Interest Rate</strong>
              </td>
              <td scope="row">
                <strong>{{ loan_request.interest_rate }}%</strong>
              </td>
            </tr>
            <tr v-for="(item, idx) in loan_request.loan_sureties" :key="idx">
              <td class="text-primary">
                <strong>Surety {{ idx + 1 }}</strong>
              </td>
              <td scope="row">
                <strong>{{ item.surety.full_name }}</strong>
                <span
                  class="badge badge-warning surties"
                  v-if="item.is_surety_accepted == null"
                >Request Pending</span>
                <span
                  class="badge badge-danger surties"
                  v-else-if="!item.is_surety_accepted"
                >Request Declined</span>

                <button class="btn btn-brand btn-sm" v-if="!item.is_surety_accepted">Change Surety</button>

                <span
                  class="badge badge-success surties"
                  v-if="item.is_surety_accepted"
                >Request Accepted</span>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Loan Status</strong>
              </td>
              <td scope="row">
                <strong>{{ loan_request.loan_request_status }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Disburse Status</strong>
              </td>
              <td scope="row">
                <strong>{{ loan_request.is_disbursed ? 'Disbursed' : 'Not Disbursed' }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Time of Approval</strong>
              </td>
              <td scope="row" v-if="loan_request.is_approved">
                <strong>{{ new Date(loan_request.approved_at).toDateString() + ' ' + new Date(loan_request.approved_at).toLocaleTimeString() }}</strong>
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
                  {{ loan_request.installments.description }}
                  <span class="text-danger d-block">
                    <em>{{ loan_request.installments.duration }}</em>
                  </span>
                </strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Valid till</strong>
              </td>
              <td scope="row">
                <strong>{{ new Date(loan_request.expires_at).toDateString() }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Grace Period till</strong>
              </td>
              <td scope="row">
                <strong>
                  <em>{{ new Date(loan_request.grace_period_expiry).toDateString() }}</em>
                </strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Total refunded</strong>
              </td>
              <td scope="row">
                <strong>{{ loan_request.total_refunded | Naira }} / {{ loan_request.amount | Naira }}</strong>
              </td>
            </tr>
            <tr v-if="loan_request.auto_debit">
              <td class="text-primary">
                <strong>Auto refund settings</strong>
              </td>
              <td scope="row">
                <strong>{{ loan_request.auto_refund_settings }}</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary">
                <strong>Refund status</strong>
              </td>
              <td scope="row">
                <strong>{{loan_request.total_refunded / loan_request.amount * 100}}% complete</strong>
              </td>
            </tr>
            <tr>
              <td class="text-primary text-center" colspan="2">
                <button
                  type="button"
                  class="btn btn-primary btn-long"
                  data-toggle="modal"
                  data-target="#loanTransactions"
                >
                  <span class="text">Breakdown</span>
                  <span class="icon">
                    <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-danger btn-long">
                  <span class="text">Refund</span>
                  <span class="icon">
                    <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-success btn-long">
                  <span class="text">Pay More</span>
                  <span class="icon">
                    <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <template v-slot:modals>
      <modal
        modalId="loanTransactions"
        modalTitle="Smartloan Transaction Details"
        class="transaction-container"
      >
        <div class="rui-timeline rui-timeline-right-lg mt-30">
          <div class="rui-timeline-line"></div>

          <div
            class="rui-timeline-item"
            v-for="(trans, idx) in loan_request.loan_transactions"
            :key="idx"
            :class="{'rui-timeline-item-swap' : !!(counter++%2), ' mt-sm-4 mt-15 mt-lg-0': counter > 1}"
          >
            <div class="rui-timeline-icon">
              <span data-feather="clock" class="rui-icon rui-icon-stroke-1_5"></span>
            </div>
            <div class="rui-timeline-content p-0 border-0">
              <div class="list-group">
                <a
                  href="#home"
                  class="list-group-item list-group-item-action"
                  v-bind:class="[ trans.trans_type =='loan' ? 'list-group-item-brand': trans.trans_type=='repayment' ? 'list-group-item-success':  'list-group-item-danger' ]"
                >
                  <b class="text-capitalize mr-15">{{trans.trans_type}}:</b>
                  {{ trans.amount | Naira }}
                </a>
                <div class="rui-gap-3 d-none d-lg-block"></div>
              </div>
            </div>
            <div class="rui-timeline-date mt-0">{{ new Date(trans.created_at).toDateString() }}</div>
          </div>
        </div>
      </modal>
    </template>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "SmartLoanDetails",
    mixins: [mixins],
    props: {
      loan_request: Object
    },
    components: {
      Layout
    },
    data: () => {
      return {
        counter: 0
      };
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
</style>
