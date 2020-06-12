<template>
  <layout title="User Savings" :isAuth="false">
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
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link"
            id="contactPillsSliding-tab"
            data-toggle="pill"
            href="#contactPillsSliding"
            role="tab"
            aria-controls="contactPillsSliding"
            aria-selected="false"
          >Savings Distribution</a>
        </li>
      </ul>
      <div class="tab-content">
        <div
          class="tab-pane fade show active"
          id="homePillsSliding"
          role="tabpanel"
          aria-labelledby="homePillsSliding-tab"
        >
          <ManageSavings :savings_list="savings_list"></ManageSavings>
        </div>
        <div
          class="tab-pane fade"
          id="profilePillsSliding"
          role="tabpanel"
          aria-labelledby="profilePillsSliding-tab"
        >
          <ManageAutoSaveSettings :auto_save_list="auto_save_list"></ManageAutoSaveSettings>
        </div>
        <div
          class="tab-pane fade"
          id="contactPillsSliding"
          role="tabpanel"
          aria-labelledby="contactPillsSliding-tab"
        >
          <SavingsDistribution :savings_list="savings_list"></SavingsDistribution>
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <modal modalId="newGOSModal" modalTitle="Create New Goal Oriented Savings">
        <form class="#" @submit.prevent="createGOS">
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
              <label for="gos-type">Select GOS Plan</label>
              <select class="custom-select" name="gos-type" v-model="details.gos_type_id">
                <option selected>Select</option>
                <option v-for="gos in gos_types" :key="gos.id" :value="gos.id">{{gos.name}}</option>
              </select>
              <FlashMessage v-if="errors.gos_type_id" :msg="errors.gos_type_id[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Initialise</span>
              </button>&nbsp;
            </div>
          </div>
        </form>
      </modal>
      <modal modalId="newLockedModal" modalTitle="Initialise Locked Funds">
        <form class="#" @submit.prevent="createLockedFunds">
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
    </template>
  </layout>
</template>

<script>
  import { mixins, toOrdinalSuffix } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  import ManageSavings from "@dashboard-assets/js/components/savings/partials/ManageSavings";
  import ManageAutoSaveSettings from "@dashboard-assets/js/components/savings/partials/ManageAutoSaveSettings";
  import SavingsDistribution from "@dashboard-assets/js/components/savings/partials/SavingsDistribution";
  export default {
    name: "UserSavings",
    mixins: [mixins],
    props: ["gos_types", "savings_list", "auto_save_list"],
    components: {
      Layout,
      ManageSavings,
      ManageAutoSaveSettings,
      SavingsDistribution
    },
    data: () => {
      return {
        details: {}
      };
    },

    methods: {
      createGOS() {
        BlockToast.fire({ text: "creating..." });
        this.$inertia
          .post(this.$route("appuser.savings.gos.initialise"), {
            ...this.details
          })
          .then(() => {
            if (this.flash.success) {
              this.details = {};
            }
            swal.close();
          });
      },
      createLockedFunds() {
        BlockToast.fire({ text: "creating..." });
        this.$inertia
          .post(
            this.$route("appuser.savings.locked.initialise"),
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
