<template>
  <layout title="Manage Withdrawal Requests">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12 col-lg-8 offset-lg-2">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">List of Withdrawal Requests</th>
                </tr>
              </thead>
              <tbody
                class="list-group list-group-flush rui-project-releases-list m-0"
              >
                <tr
                  class="list-group-item p-0"
                  v-for="withdrawalRequest in withdrawal_requests"
                  :key="withdrawalRequest.id"
                >
                  <td class="rui-changelog d-block">
                    <h3 class="rui-changelog-title">
                      User Full Name: {{ withdrawalRequest.user_full_name }}
                    </h3>
                    <h4 class="rui-changelog-title">
                      Amount Requested:
                      {{ withdrawalRequest.amount_requested | Naira }}
                      <span
                        class="badge badge-danger"
                        v-if="withdrawalRequest.is_declined"
                        >DELETED REQUEST</span
                      >
                      <span
                        class="badge badge-info"
                        v-if="withdrawalRequest.is_interests"
                        >INTERESTS</span
                      >
                      <span
                        class="badge badge-danger"
                        v-else-if="!withdrawalRequest.is_user_verified"
                        >WITHDRAWAL OTP NOT VERIFIED</span
                      >
                      <span
                        class="badge badge-success"
                        v-if="withdrawalRequest.is_processed"
                        >REQUEST PROCESSED</span
                      >
                    </h4>
                    <div class="rui-changelog-subtitle">
                      <a href="#">Request Date:</a>
                      {{
                        new Date(withdrawalRequest.request_date).toDateString()
                      }}
                      {{
                        new Date(
                          withdrawalRequest.request_date
                        ).toLocaleTimeString()
                      }}
                    </div>
                    <ul class="list-unstyled">
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[
                            withdrawalRequest.is_user_verified
                              ? 'rui-changelog-success'
                              : 'rui-changelog-danger',
                          ]"
                        >
                          <span class="rui-changelog-item-type"
                            >PHONE NUMBER:
                            {{ withdrawalRequest.user_phone }}</span
                          >
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[
                            withdrawalRequest.is_user_verified
                              ? 'rui-changelog-success'
                              : 'rui-changelog-danger',
                          ]"
                        >
                          <span class="rui-changelog-item-type"
                            >ACCOUNT NAME:
                            {{ withdrawalRequest.user_account_name }}</span
                          >
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[
                            withdrawalRequest.is_user_verified
                              ? 'rui-changelog-success'
                              : 'rui-changelog-danger',
                          ]"
                        >
                          <span class="rui-changelog-item-type"
                            >ACCOUNT NUMBER:{{
                              withdrawalRequest.user_account_number
                            }}
                            ({{ withdrawalRequest.user_account_bank }} -
                            {{ withdrawalRequest.user_account_type }})</span
                          >
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[
                            withdrawalRequest.is_user_verified
                              ? 'rui-changelog-success'
                              : 'rui-changelog-danger',
                          ]"
                        >
                          <span class="rui-changelog-item-type"
                            >AGENT:
                            {{
                              withdrawalRequest.user_smart_collector_full_name
                            }}</span
                          >
                        </div>
                      </li>
                    </ul>
                    <div class="d-flex justify-content-around">
                      <button
                        class="btn btn-brand btn-xs text-nowrap"
                        type="button"
                        data-toggle="collapse"
                        :data-target="`#revealDetails${withdrawalRequest.id}`"
                        aria-expanded="false"
                        :aria-controls="`revealDetails${withdrawalRequest.id}`"
                      >
                        View Full Details
                      </button>
                      <button
                        class="btn btn-danger btn-xs text-nowrap"
                        type="button"
                        @click="deleteWithdrawalRequest(withdrawalRequest)"
                        v-if="!withdrawalRequest.is_processed && !withdrawalRequest.is_user_verified && !withdrawalRequest.is_declined"
                      >
                        DELETE REQUEST
                      </button>
                      <button
                        class="btn btn-danger btn-xs text-nowrap"
                        type="button"
                        @click="deleteWithdrawalRequest(withdrawalRequest)"
                        v-if="withdrawalRequest.is_declined"
                      >
                        PURGE REQUEST
                      </button>
                      <button
                        class="btn btn-success btn-xs text-nowrap"
                        type="button"
                        v-if="!withdrawalRequest.is_processed && withdrawalRequest.is_user_verified"
                        @click="markWithdrawalRequestAsProcessed(withdrawalRequest)"
                      >
                        MARK PROCESSED
                      </button>
                    </div>
                    <div
                      class="collapse"
                      :id="`revealDetails${withdrawalRequest.id}`"
                    >
                      <div class="pt-15">
                        <ul class="list-unstyled">
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type">
                                DESCRIPTION: {{ withdrawalRequest.description }}
                              </span>
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type">
                                USER EMAIL: {{ withdrawalRequest.user_email }}
                              </span>
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type">
                                SMART COLLECTOR PHONE:
                                {{
                                  withdrawalRequest.user_smart_collector_phone
                                }}
                              </span>
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type">
                                SMART COLLECTOR AREA OF OPERATION:
                                {{
                                  withdrawalRequest.user_smart_collector_city_of_operation
                                }}
                              </span>
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type">
                                SAVINGS TYPE:
                                {{ withdrawalRequest.savings_portfolio_type }}
                                <span
                                  class="badge badge-danger"
                                  v-if="withdrawalRequest.savings_is_liquidated"
                                  >Liquidated</span
                                >
                                <span
                                  class="badge badge-success"
                                  v-if="withdrawalRequest.is_charge_free"
                                  >Charge Free</span
                                >
                                <span
                                  class="badge badge-danger"
                                  v-if="withdrawalRequest.is_declined"
                                  >Deleted Request</span
                                >
                              </span>
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type"
                                >SAVINGS CURRENT BALANCE:{{
                                  withdrawalRequest.savings_current_balance
                                }}</span
                              >
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type"
                                >SAVINGS START DATE:{{
                                  new Date(
                                    withdrawalRequest.savings_start_date
                                  ).toLocaleString("en-US", {
                                    timeZone: "Africa/Lagos",
                                  })
                                }}</span
                              >
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type"
                                >SAVINGS MATURITY DATE:{{
                                  new Date(
                                    withdrawalRequest.savings_maturity_date
                                  ).toLocaleString("en-US", {
                                    timeZone: "Africa/Lagos",
                                  })
                                }}</span
                              >
                            </div>
                          </li>
                          <li>
                            <div
                              class="rui-changelog-item"
                              :class="[
                                withdrawalRequest.is_user_verified
                                  ? 'rui-changelog-success'
                                  : 'rui-changelog-danger',
                              ]"
                            >
                              <span class="rui-changelog-item-type"
                                >REQUEST PROCESSED BY:
                                {{ withdrawalRequest.processed_by }}</span
                              >
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins, errorHandlers } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  export default {
    name: "WithdrawalRequests",
    props: {
      withdrawal_requests: Array,
    },
    components: { Layout },
    mixins: [mixins, errorHandlers],
    data: () => ({}),

    methods: {
      markWithdrawalRequestAsProcessed(withdrawalRequest) {
        BlockToast.fire({
          text: "working ...",
        });

        this.$inertia
          .post(this.$route("superadmin.withdrawal_request.mark_complete", withdrawalRequest.id), null, {
             preserveState: true,
              preserveScroll: true,
              only: ['flash','errors', 'withdrawal_requests'],
          })
          .then(() => {
            this.displayResponse();
           this.displayErrors();
          });
      },
      deleteWithdrawalRequest(withdrawalRequest) {
        BlockToast.fire({
          text: "Deleting Request...",
        });

        this.$inertia
          .delete(
            this.$route("superadmin.withdrawal_request.delete", withdrawalRequest.id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ['flash','errors', 'withdrawal_requests'],
            }
          )
          .then(() => {
           this.displayResponse();
           this.displayErrors();
          });
      },
    },
  };
</script>
