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
          >Manage Savings</a>
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
          <ManageSavings :savings_list="savings_list" @fund-savings="details=$event"></ManageSavings>
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
      <modal modalId="newTargetModal" modalTitle="Create New Target Savings">
        <form class="#" @submit.prevent="createTargetSavings">
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
              <select class="custom-select" name="target-type" v-model="details.target_type_id">
                <option selected>Select</option>
                <option
                  v-for="target in target_types"
                  :key="target.id"
                  :value="target.id"
                >{{target.name}}</option>
              </select>
              <FlashMessage v-if="errors.target_type_id" :msg="errors.target_type_id[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Initialise</span>
              </button>&nbsp;
            </div>
          </div>
        </form>
      </modal>
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
        :modalTitle="`Add funds to your ${details.target_type? details.target_type.name: '' } Savings`"
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
  import Layout from "@dashboard-assets/js/AppComponent";
  import ManageSavings from "@dashboard-assets/js/components/savings/partials/ManageSavings";
  import ManageAutoSaveSettings from "@dashboard-assets/js/components/savings/partials/ManageAutoSaveSettings";
  export default {
    name: "UserSavings",
    mixins: [mixins],
    props: ["target_types", "savings_list", "auto_save_list"],
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
      initialiseSmartSavings() {
        BlockToast.fire({ text: "creating..." });
        this.$inertia
          .post(this.$route("appuser.savings.smart.initialise"), {
            ...this.details
          })
          .then(() => {
            if (this.flash.success) {
              this.details = {};
            }
            swal.close();
          });
      },
      createTargetSavings() {
        BlockToast.fire({ text: "creating..." });
        this.$inertia
          .post(
            this.$route("appuser.savings.target.initialise"),
            {
              ...this.details
            },
            {
              preserveState: true
            }
          )
          .then(() => {
            this.details = {};
            swal.close();
          });
      },
      addFundsToThisSavings() {
        BlockToast.fire({ text: "Adding funds to your savings ..." });
        this.$inertia
          .post(
            this.$route("appuser.savings.target.fund"),
            {
              ...this.details
            },
            {
              preserveState: true
            }
          )
          .then(() => {
            if (this.flash.success) {
              $("#fundThisSavingsModal").modal("hide");
            }
            swal.close();
          });
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
