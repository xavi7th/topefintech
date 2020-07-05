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
      <modal
        modalId="fundThisSavingsModal"
        :modalTitle="`Add funds to your ${details.gos_type? details.gos_type.name: '' } Savings`"
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
      <modal
        modalId="defundThisSavingsModal"
        :modalTitle="`Remove funds to this ${details.gos_type? details.gos_type.name: '' } Savings`"
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
      <modal modalId="fundSavingsModal" :modalTitle="`Add distributed funds to your savings`">
        <form class="#" @submit.prevent="addFundsToSavings">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="amount-to-distribute">Amount to fund</label>
              <input
                type="number"
                class="form-control"
                id="amount-to-distribute"
                v-model="details.amount"
                placeholder="Amount to add to funds"
              />
              <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long mr-25">
                <span class="text">Pay</span>
              </button>
              <button
                type="button"
                class="btn btn-brand btn-long"
                @click="getDistributionDetails"
                v-if="!auth.user.isAdmin"
              >
                <span class="text">View Distribution Details</span>
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
  import SavingsDistribution from "@dashboard-assets/js/components/savings/partials/SavingsDistribution";
  export default {
    name: "AdminManageUserSavings",
    mixins: [mixins],
    props: ["gos_types", "savings_list", "auto_save_list", "user"],
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
      addFundsToThisSavings() {
        BlockToast.fire({ text: "Adding funds to savings ..." });

        let url = this.$page.auth.user.isAdmin
          ? this.$route("admin.user_savings.locked.fund", this.user.id)
          : this.$route("appuser.savings.locked.fund");

        this.$inertia
          .post(
            url,
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
      },
      removeFundsFromThisSavings() {
        BlockToast.fire({ text: "Removing funds from this savings ..." });

        this.$inertia
          .post(
            this.$route("admin.user_savings.locked.defund", this.user.id),
            {
              ...this.details
            },
            {
              preserveState: true
            }
          )
          .then(() => {
            if (this.flash.success) {
              $("#defundThisSavingsModal").modal("hide");
            }
            swal.close();
          });
      },
      getDistributionDetails() {
        BlockToast.fire({ text: "Getting distribution details ..." });

        axios
          .get(this.$route("appuser.savings.distribution"), {
            params: {
              amount: this.details.amount
            }
          })
          .then(({ data }) => {
            let str = "";
            console.log(data);
            _.each(data, ($val, $key) => {
              str =
                str +
                "<br><b class='mb-10 d-inline-block'>" +
                $key +
                " Savings :</b>" +
                this.$options.filters.Naira($val);
            });

            console.log(str);

            swal.fire({
              title: "<strong>Savings Breakdown</strong>",
              icon: "info",
              html: `<div class="card"><div class="card-header">TOTAL: ${this.$options.filters.Naira(
                this.details.amount
              )}</div><div class="card-body  p-0"><blockquote class="blockquote mb-0 text-left text-capitalize"><p>${str}</p><footer class="blockquote-footer text-right">Proceed?</footer></blockquote></div></div>`,
              showCloseButton: false,
              showCancelButton: true,
              focusConfirm: true,
              confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
              confirmButtonAriaLabel: "Thumbs up, great!"
            });
          })
          .catch(err => {
            if (err.response) {
              swal.fire({
                position: "top-end",
                icon: "error",
                title: err.response.data.message[0],
                showConfirmButton: false,
                timer: 3500
              });
            }
          });
      },
      addFundsToSavings() {
        BlockToast.fire({ text: "Adding distributed funds to your savings ..." });

        let url = this.$page.auth.user.isAdmin
          ? this.$route("admin.user_savings.fund", this.user.id)
          : this.$route("appuser.savings.fund");

        this.$inertia
          .post(
            url,
            {
              ...this.details
            },
            {
              preserveState: true
            }
          )
          .then(() => {
            if (this.flash.success) {
              this.details = {};
              $("#fundSavingsModal").modal("hide");
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
