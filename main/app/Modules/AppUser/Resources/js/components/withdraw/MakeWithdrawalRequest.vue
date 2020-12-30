<template>
  <layout title="Make Withdrawal Request" :isAuth="false">
    <div class="container-fluid text-center">
      <div class="col-lg-4 offset-lg-4 col-md-8 offset-md-2 text-center">
        <form class="#" @submit.prevent="makeRequest">
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
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
                            <img src="/img/exclamation-mark.svg" alt class="icon-file" />
                          </span>
                          <span class="media-body">
                            <span
                              class="media-title"
                            >You can only withdraw from your smart savings account</span>
                          </span>
                        </a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12">
              <input
                type="text"
                class="form-control"
                id="withdrawalAmount"
                v-model="amount"
                placeholder="Enter Amount"
              />
              <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-long">
                <span class="icon">
                  <span data-feather="plus-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                </span>
                <span class="text">Request Withdrawal</span>
              </button>&nbsp;
            </div>
          </div>
        </form>
      </div>
      <div class="col-12 mt-30">
        <inertia-link :href="$route('appuser.withdraw.requests')" class="btn btn-brand btn-long">
          <span class="text">View Withdrawal Requests</span>
          <span class="icon">
            <span data-feather="arrow-right-circle" class="rui-icon rui-icon-stroke-1_5"></span>
          </span>
        </inertia-link>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "MakeWithdrawalRequest",
    mixins: [mixins],
    components: {
      Layout
    },
    data: () => {
      return {
        amount: null
      };
    },
    methods: {
      makeRequest() {
        BlockToast.fire({
          text: "Sending withdrawal request ..."
        });

        this.$inertia
          .post(this.$route("appuser.withdraw.create"), { amount: this.amount })
      }
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
