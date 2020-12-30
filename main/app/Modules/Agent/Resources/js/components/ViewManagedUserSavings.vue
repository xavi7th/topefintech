<template>
  <layout :title="`${appUser.full_name}'s Savings`" :isAuth="false">
    <div class="container-fluid">
      <ul class="nav nav-pills rui-tabs-sliding" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link active"
            id="homePillsSliding-tab"
            data-toggle="pill"
            href="#homePillsSliding"
            role="tab"
            aria-controls="homePillsSliding"
            aria-selected="true"
          >View Managed Users' Savings</a>
        </li>
      </ul>
      <div class="tab-content">
        <div
          class="tab-pane fade show active"
          id="homePillsSliding"
          role="tabpanel"
          aria-labelledby="homePillsSliding-tab"
        >
          <ManageSavings :savings_list="savings_list" @fund-savings="details=$event"></ManageSavings>
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <modal modalId="createSmartSavings" modalTitle="Initialise Smart Savings Portfolio">
        <form class="#" @submit.prevent="initialiseSmartSavings">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="lock-duration">Duration (Months)</label>
              <input
                type="text"
                class="form-control"
                id="lock-duration"
                v-model="details.duration"
                placeholder="Enter duration to lock funds"
              />
              <FlashMessage v-if="errors.duration" :msg="errors.duration[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </modal>
      <modal
        modalId="fundThisSavingsModal"
        :modalTitle="`Add funds to your ${details.portfolio? details.portfolio.name: '' } Savings`"
      >
        <form class="#" @submit.prevent="addFundsToThisSavings">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="fund-amount">Amount to fund</label>
              <input
                type="number"
                class="form-control"
                id="fund-amount"
                v-model="details.amount"
                placeholder="Amount to add to funds"
              />
              <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </modal>
    </template>
  </layout>
</template>

<script>
  import { mixins, toOrdinalSuffix } from "@dashboard-assets/js/config";
  import axios from "axios";
  import Layout from "@admin-assets/js/AdminAppComponent";
  import ManageSavings from "@dashboard-assets/js/components/savings/partials/ManageSavings";
  import ManageAutoSaveSettings from "@dashboard-assets/js/components/savings/partials/ManageAutoSaveSettings";
  export default {
    mixins: [mixins],
    props: ["target_types", "savings_list", "auto_save_list", "appUser"],
    components: {
      Layout,
      ManageSavings,
      ManageAutoSaveSettings,
    },
    data: () => {
      return {
        details: {},
      };
    },

    methods: {
      initialiseSmartSavings() {
        BlockToast.fire({ text: "creating..." });
        this.$inertia
          .post(
            this.$route("agent.savings.smart.initialise", this.appUser.phone),
            {
              ...this.details,
            },{
              OnSuccess:() => this.details = {},
              OnFinish:() =>swal.close(),
            }
          )
      },
      addFundsToThisSavings() {
        BlockToast.fire({ text: "Adding funds to savings ..." });

        let url = this.$page.props.auth.user.isSuperAdmin
          ? this.$route("superadmin.user_savings.target.fund", this.appUser.id)
          : this.$route("appuser.savings.target.fund");

        this.$inertia
          .post(
            url,
            {
              ...this.details,
            },
            {
              preserveState: true,
              OnSuccess:() => $("#fundThisSavingsModal").modal("hide"),
              OnFinish:() => swal.close(),
            }
          )
      },
    },
  };
</script>

<style lang="scss" scoped>
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }

  .table thead th {
    padding: 10px !important;
  }
</style>
