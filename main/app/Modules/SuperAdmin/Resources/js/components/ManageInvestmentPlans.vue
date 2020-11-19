<template>
  <layout title="Create Investment Plans" :isAuth="false">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8">
          <div class="table-responsive">
            <table class="table table-bordered" data-datatable-order="0:asc">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Duration</th>
                  <th scope="col">Interest</th>
                  <th scope="col">Daily Rate</th>
                  <th scope="col">Active Investments</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="investment in investment_list" :key="investment.id">
                  <th scope="row">{{ investment.id }}</th>
                  <td>{{ investment.name }} Investment</td>
                  <td>{{ investment.duration }} months</td>
                  <td>{{ investment.interest_rate }}%</td>
                  <td>{{ investment.daily_interest_rate }}%</td>
                  <td class="text-capitalize text-nowrap">
                    {{ investment.savings_count }} investments
                    <button
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#newInvestmentModal"
                      @click="details = investment"
                    >
                      Edit
                    </button>
                    <button
                      class="btn btn-danger btn-xs"
                      v-if="investment.savings_count == 0"
                      @click="deleteInvestment(investment.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-lg-4 col-xl-4">
          <div class="d-flex align-items-center justify-content-between mb-25">
            <h2 class="mnb-2" id="formBase">Create New Investment Plan</h2>
          </div>
          <form class="#" @submit.prevent="createInvestment">
            <div class="row vertical-gap sm-gap">
              <div class="col-12">
                <label for="investmentName"> Investment Plan Name </label>
                <input
                  type="text"
                  class="form-control"
                  id="investmentName"
                  v-model="investmentType.name"
                  placeholder="Please Specify"
                />
              </div>

              <div class="col-12">
                <label for="investmentDuration"> Duration </label>
                <input
                  type="text"
                  class="form-control"
                  id="investmentDuration"
                  v-model="investmentType.duration"
                  placeholder="Duration (months)"
                />
              </div>

              <div class="col-12">
                <label for="investmentInterestRate">
                  Investment Plan Interest Rate
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="investmentInterestRate"
                  v-model="investmentType.interest_rate"
                  placeholder="Per annum"
                />
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-long">
                  <span class="icon">
                    <span
                      data-feather="plus-circle"
                      class="rui-icon rui-icon-stroke-1_5"
                    ></span>
                  </span>
                  <span class="text">Create</span></button
                >&nbsp;
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <form class="#" @submit.prevent="updateInvestmentPlan">
        <modal modalId="newInvestmentModal" modalTitle="Create New Investment">
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name"> Investment Plan Name </label>
              <input
                type="text"
                class="form-control"
                readonly
                id="name"
                v-model="details.name"
                placeholder="Please Specify"
              />
            </div>

            <div class="col-12">
              <label for="duration"> Duration </label>
              <input
                type="text"
                class="form-control"
                readonly
                id="duration"
                v-model="details.duration"
                placeholder="Duration (months)"
              />
            </div>

            <div class="col-12">
              <label for="interest-rate"> Investment Plan Interest Rate </label>
              <input
                type="text"
                class="form-control"
                id="interest-rate"
                v-model="details.interest_rate"
                placeholder="Per annum"
              />
            </div>
          </div>
          <div slot="modal-buttons">
            <button type="submit" class="btn btn-primary btn-long">
              <span class="icon">
                <span
                  data-feather="plus-circle"
                  class="rui-icon rui-icon-stroke-1_5"
                ></span>
              </span>
              <span class="text">Update</span>
            </button>
          </div>
        </modal>
      </form>
    </template>
  </layout>
</template>

<script>
  import { mixins, errorHandlers } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent.vue";
  export default {
    name: "ManageInvestmentPlans",
    mixins: [mixins, errorHandlers],
    props: {
      investment_list: Array,
    },
    components: {
      Layout,
    },
    data: () => {
      return {
        investmentType: {},
        details: {},
      };
    },
    methods: {
      createInvestment() {
        BlockToast.fire({
          text: "Creating investment portfolio ...",
        });

        this.$inertia
          .post(
            this.$route("superadmin.investment_plan.create"),
            this.investmentType,
            {
              preserveState: true,
              preserveScroll: true,
              only: ["investment_list", "errors", "flash"],
            }
          )
          .then(() => {
            this.displayResponse(10000);
            this.displayErrors(10000);
          });
      },

      updateInvestmentPlan() {
        BlockToast.fire({
          text: "Creating investment portfolio ...",
        });

        this.$inertia
          .put(this.$route("superadmin.investment_plan.update", this.details.id), this.details, {
            preserveState: true,
            preserveScroll: true,
            only: ["investment_list", "errors", "flash"],
          })
          .then(() => {
            this.displayResponse(10000);
            this.displayErrors(10000);
          });
      },

      deleteInvestment(id) {
        BlockToast.fire({
          text: "Deleting ...",
        });

        this.$inertia
          .delete(this.$route("superadmin.investment_plan.delete", id), {
            preserveState: true,
            preserveScroll: true,
            only: ["investment_list", "errors", "flash"],
          })
          .then(() => {
            this.displayResponse(10000);
            this.displayErrors(10000);
          });
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
</style>
