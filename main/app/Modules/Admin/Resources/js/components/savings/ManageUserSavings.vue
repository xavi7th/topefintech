<template>
  <layout :title="`${user.full_name}'s Savings`" :isAuth="false">
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
          >Add to Savings</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link"
            id="profilePillsSliding-tab"
            data-toggle="pill"
            href="#profilePillsSliding"
            role="tab"
            aria-controls="profilePillsSliding"
            aria-selected="false"
          >Autosave Settings</a>
        </li>
      </ul>
      <div class="tab-content">
        <div
          class="tab-pane fade show active"
          id="homePillsSliding"
          role="tabpanel"
          aria-labelledby="homePillsSliding-tab"
        >
          <ManageSavings
            :savings_list="savings_list"
            @fund-savings="details=$event"
            @defund-savings="details=$event"
          ></ManageSavings>
        </div>
        <div
          class="tab-pane fade"
          id="profilePillsSliding"
          role="tabpanel"
          aria-labelledby="profilePillsSliding-tab"
        >
          <ManageAutoSaveSettings :auto_save_list="auto_save_list"></ManageAutoSaveSettings>
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <modal modalId="newTargetModal" modalTitle="Create New Goal Oriented Savings">
        <form class="#" @submit.prevent="createTarget">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="duration">Duration (Months)</label>
              <input
                type="text"
                class="form-control"
                id="duration"
                v-model="details.duration"
                placeholder="Enter duration of savings"
              />
              <FlashMessage v-if="errors.duration" :msg="errors.duration[0]" />
            </div>
            <div class="col-12">
              <label for="target-type">Select Target Plan</label>
              <select class="custom-select" name="target-type" v-model="details.portfolio_id">
                <option selected>Select</option>
                <option
                  v-for="target in target_types"
                  :key="target.id"
                  :value="target.id"
                >{{target.name}}</option>
              </select>
              <FlashMessage v-if="errors.portfolio_id" :msg="errors.portfolio_id[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Initialise</span>
              </button>&nbsp;
            </div>
          </div>
        </form>
      </modal>
      <modal
        modalId="fundThisSavingsModal"
        :modalTitle="`Add funds to your ${details.portfolio? details.portfolio.name: '' } Savings`"
      >
        <form class="#" @submit.prevent="addFundsToThisSavings">
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
      <modal
        modalId="defundThisSavingsModal"
        :modalTitle="`Remove funds to this ${details.portfolio? details.portfolio.name: '' } Savings`"
      >
        <form class="#" @submit.prevent="removeFundsFromThisSavings">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="defund-amount">Amount to remove</label>
              <input
                type="number"
                class="form-control"
                id="defund-amount"
                v-model="details.amount"
                placeholder="Amount to remove from funds"
              />
              <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Deduct Savings</span>
              </button>
            </div>
          </div>
        </form>
      </modal>
      <modal modalId="fundSavingsModal" :modalTitle="`Add funds to user's savings`">
        <form class="#" @submit.prevent="addFundsToSavings">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="amount-to-fund">Amount to fund</label>
              <input
                type="number"
                class="form-control"
                id="amount-to-fund"
                v-model="details.amount"
                placeholder="Amount to add to funds"
              />
              <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long mr-25">
                <span class="text">Pay</span>
              </button>
            </div>
          </div>
        </form>
      </modal>
    </template>
  </layout>
</template>

<script>
  import { errorHandlers, mixins, toOrdinalSuffix } from "@dashboard-assets/js/config";
  import axios from "axios";
  import Layout from "@admin-assets/js/AdminAppComponent";
  import ManageSavings from "@dashboard-assets/js/components/savings/partials/ManageSavings.vue";
  import ManageAutoSaveSettings from "@dashboard-assets/js/components/savings/partials/ManageAutoSaveSettings";
  export default {
    name: "ManageUserSavings",
    mixins: [mixins, errorHandlers],
    props: ["target_types", "savings_list", "auto_save_list", "user"],
    components: {
      Layout,
      ManageSavings,
      ManageAutoSaveSettings
    },
    data: () => {
      return {
        details: {}
      };
    },

    methods: {
      addFundsToThisSavings() {
        BlockToast.fire({ text: "Adding funds to savings ..." });

        let url = this.$page.props.auth.user.isSuperAdmin ? this.$route("superadmin.user_savings.target.fund", this.user.id)
          : this.$page.props.auth.user.isAdmin ? this.$route("admin.user_savings.target.fund", this.user.phone)
          : this.$route("appuser.savings.target.fund");

        this.$inertia
          .post(
            url,
            {
              ...this.details
            },
            {
              preserveState: true,
              onSuccess: () => $("#fundThisSavingsModal").modal("hide")
            }
          )
      },
      removeFundsFromThisSavings() {
        BlockToast.fire({ text: "Removing funds from this savings ..." });

        this.$inertia
          .post(
            this.$route("superadmin.user_savings.target.defund", this.user.id),
            {
              ...this.details
            },
            {
              preserveState: true,
              onSuccess: () => $("#defundThisSavingsModal").modal("hide"),
              onFinish:() => swal.close()
            }
          )
      },
      addFundsToSavings() {
        BlockToast.fire({ text: "Adding funds to this savings ..." });

        let url = this.$page.props.auth.user.isAdmin
          ? this.$route("admin.user_savings.fund", this.user.id)
          : this.$route("appuser.savings.fund");

        this.$inertia
          .post(
            url,
            {
              ...this.details
            },
            {
              preserveState: true,
              onSuccess:() => $("#fundSavingsModal").modal("hide"),
              onFinish:() => {
                this.details = {}
                // swal.close();
              }
            }
          )
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

  .table thead th {
    padding: 10px !important;
  }
</style>
