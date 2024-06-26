<template>
  <layout title="My Savings" :isAuth="false">
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
            >Manage Savings</a
          >
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
            >Autosave Settings</a
          >
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
            @fund-savings="details = $event"
          />
        </div>
        <div
          class="tab-pane fade"
          id="profilePillsSliding"
          role="tabpanel"
          aria-labelledby="profilePillsSliding-tab"
        >
          <ManageAutoSaveSettings :auto_save_list="auto_save_list" />
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <form class="#" @submit.prevent="createInvestmentSavings">
        <modal modalId="newInvestmentModal" modalTitle="Create New Investment">
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="investment-duration">Duration (Months)</label>
              <input
                type="text"
                class="form-control"
                id="investment-duration"
                v-model="details.duration"
                readonly
                placeholder="Enter duration of savings"
              />
            </div>
            <div class="col-12">
              <label for="investment-type">Select Investment Plan</label>
              <select
                class="custom-select"
                name="investment-type"
                v-model="details.selected_investment"
                @change="() => {details.duration = details.selected_investment.duration; details.portfolio_id = details.selected_investment.id}"
              >
                <option :value="undefined">Select</option>
                <option
                  v-for="investment in investment_types"
                  :key="investment.name"
                  :value="investment"
                >
                  {{ investment.name }} ({{investment.interest_rate}}% in {{investment.duration}} months)
                </option>
              </select>
            </div>
          </div>
          <div slot="modal-buttons">
            <button type="submit" class="btn btn-success btn-long">
              <span class="text">Initialise</span>
            </button>
          </div>
        </modal>
      </form>
      <form class="#" @submit.prevent="createTargetSavings">
        <modal modalId="newTargetModal" modalTitle="Create New Target Savings">
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
              <select
                class="custom-select"
                name="target-type"
                v-model="details.portfolio_id"
              >
                <option selected>Select</option>
                <option
                  v-for="target in target_types"
                  :key="target.id"
                  :value="target.id"
                >
                  {{ target.name }}
                </option>
              </select>
              <FlashMessage
                v-if="errors.portfolio_id"
                :msg="errors.portfolio_id[0]"
              />
            </div>
          </div>
          <div slot="modal-buttons">
            <button type="submit" class="btn btn-success btn-long">
              <span class="text">Initialise</span>
            </button>
          </div>
        </modal>
      </form>
      <form class="#" @submit.prevent="initialiseSmartSavings">
        <modal
          modalId="createSmartSavings"
          modalTitle="Initialise Smart Savings Portfolio"
        >
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="lock-duration">Duration (Months)</label>
              <input
                type="text"
                class="form-control"
                id="lock-duration"
                v-model="details.duration"
                placeholder="Enter duration to save funds"
              />
              <FlashMessage v-if="errors.duration" :msg="errors.duration[0]" />
            </div>

            <div class="col-sm-12">
              <div
                class="custom-control custom-checkbox d-flex justify-content-start flex-wrap"
              >
                <input
                  type="checkbox"
                  class="custom-control-input"
                  v-model="details.interests_withdrawable"
                  id="interests-withdrawable"
                />
                <label
                  class="custom-control-label fs-13"
                  for="interests-withdrawable"
                >
                  I want to withdraw the interests from time to time
                </label>
                <FlashMessage
                  v-if="errors.interests_withdrawable"
                  :msg="errors.interests_withdrawable[0]"
                />
              </div>
            </div>
          </div>
          <div slot="modal-buttons">
            <button type="submit" class="btn btn-success btn-long">
              <span class="text">Create</span>
            </button>
          </div>
        </modal>
      </form>
      <form class="#" @submit.prevent="addFundsToThisSavings">
        <modal
          modalId="fundThisSavingsModal"
          :modalTitle="`Add funds to your ${
            details.portfolio ? details.portfolio.name : ''
          } Savings`"
        >
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="fund-amount">Amount to fund</label>
              <input
                type="number"
                class="form-control"
                id="fund-amount"
                v-model="details.amount"
                placeholder="Enter amount to save"
              />
              <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
            </div>
          </div>
          <div slot="modal-buttons">
            <button type="submit" class="btn btn-success btn-long">
              <span class="text">Create</span>
            </button>
          </div>
        </modal>
      </form>
    </template>
  </layout>
</template>

<script>
  import { mixins, toOrdinalSuffix } from "@dashboard-assets/js/config";
  import axios from "axios";
  import Layout from "@dashboard-assets/js/AppComponent";
  import ManageSavings from "@dashboard-assets/js/components/savings/partials/ManageSavings";
  import ManageAutoSaveSettings from "@dashboard-assets/js/components/savings/partials/ManageAutoSaveSettings";
  export default {
    name: "UserSavings",
    mixins: [mixins],
    props: ["target_types", 'investment_types', "savings_list", "auto_save_list"],
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
    beforeDestroy(){
      $('.modal').modal('hide');
      $('.modal-backdrop').remove();
    },

    methods: {
      initialiseSmartSavings() {
        BlockToast.fire({ text: "creating..." });
        this.$inertia
          .post(this.$route("appuser.savings.smart.initialise"), {
            ...this.details,
          },{
            onSuccess:() =>{
              this.details = {};
            }
          })
      },
      createInvestmentSavings() {
        BlockToast.fire({ text: "Initializing a new investment portfolio ..." });
        this.$inertia
          .post(
            this.$route("appuser.savings.investment.initialise"),
            {
              ...this.details,
            },
            {
              preserveState: true,
              onSuccess:() =>{
                this.details = {};
              }
            }
          )
      },
      createTargetSavings() {
        BlockToast.fire({ text: "creating..." });
        this.$inertia
          .post(
            this.$route("appuser.savings.target.initialise"),
            {
              ...this.details,
            },
            {
              preserveState: true,
              onSuccess:() =>{
                this.details = {};
              }
            }
          )
      },
      addFundsToThisSavings() {
        BlockToast.fire({ text: "Adding funds to your savings ..." });
        this.$inertia
          .post(
            this.$route("appuser.savings.target.fund"),
            {
              ...this.details,
            },
            {
              preserveState: true,
              onSuccess:() =>{
                $("#fundThisSavingsModal").modal("hide");
              }
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
