<template>
  <div class="col-12">
    <div class="d-flex align-items-center justify-content-between mb-25 flex-wrap flex-md-nowrap">
      <h2 class="mb-0 mr-md-5" id="formBase">My Savings Distribution (%)</h2>

      <div class="col-12 col-md justify-content-between">
        <button
          type="button"
          class="btn btn-brand"
          data-toggle="modal"
          data-target="#newGOSModal"
        >New GOS</button>
        <button
          type="button"
          class="btn btn-primary"
          data-toggle="modal"
          data-target="#newLockedModal"
        >New Locked Fund</button>
      </div>
      <div class="col-12 col-md text-md-right">
        <button
          v-show="editDistribution"
          type="button"
          class="btn btn-danger"
          @click="updateSavingsDistribution"
        >Update Savings Distribution</button>
        <button
          type="button"
          class="btn btn-success btn-uniform btn-round"
          @click="editDistribution = false"
          v-show="editDistribution"
        >
          <span class="icon">
            <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
          </span>
        </button>
      </div>
    </div>
    <FlashMessage />
    <template v-if="$page.errors">
      <div class="d-flex align-items-center justify-content-between flex-column mb-25">
        <FlashMessage v-for="err in $page.errors" :msg="err[0]" :key="err[0]" />
      </div>
    </template>
    <div class="table-responsive">
      <table class="table table-bordered rui-datatable" data-datatable-order="0:asc">
        <thead class="thead-dark">
          <tr>
            <th scope="col">
              #
              <span data-feather="chevron-down" class="rui-icon rui-icon-stroke-1_5"></span>
            </th>
            <th scope="col">
              Type
              <span data-feather="chevron-down" class="rui-icon rui-icon-stroke-1_5"></span>
            </th>
            <th scope="col">
              Name
              <span data-feather="chevron-down" class="rui-icon rui-icon-stroke-1_5"></span>
            </th>
            <th scope="col">
              Current Balance
              <span data-feather="chevron-down" class="rui-icon rui-icon-stroke-1_5"></span>
            </th>
            <th scope="col">
              Estimated Amount
              <span
                data-feather="chevron-down"
                class="rui-icon rui-icon-stroke-1_5"
              ></span>
            </th>
            <th scope="col">
              Percentage
              <span data-feather="chevron-down" class="rui-icon rui-icon-stroke-1_5"></span>
            </th>
            <th scope="col">
              Action
              <span data-feather="chevron-down" class="rui-icon rui-icon-stroke-1_5"></span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="savings in savings_list" :key="savings.id">
            <th scope="row">{{savings.id}}</th>
            <td class="text-capitalize">{{savings.type}} Savings</td>
            <td class="text-capitalize">{{savings.gos_type.name || 'N/A'}}</td>
            <td class="text-capitalize">{{savings.current_balance | Naira }}</td>
            <td>{{savings.savings_distribution * 10 | Naira }} for every {{1000|Naira}}</td>
            <td>
              <input
                v-model="savings.savings_distribution"
                v-if="editDistribution"
                class="form-control"
              />
              <span v-else>{{ savings.savings_distribution }}%</span>
            </td>
            <td>
              <a @click.prevent="editDistribution = true" href="#">
                <span class="icon">
                  <span data-feather="edit" class="rui-icon rui-icon-stroke-1_5"></span>
                </span>
                Edit
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    name: "SavingsDistribution",
    props: ["savings_list"],
    data: () => {
      return {
        editDistribution: false,
        details: {}
      };
    },
    methods: {
      updateSavingsDistribution() {
        this.editDistribution = false;
        Toast.fire({
          title: "Please Wait!",
          text: "Updating savings distribution...",
          icon: "info",
          timer: 100000,
          position: "center"
        });

        this.$inertia
          .put(
            this.$route("appuser.savings.distribution.update"),
            {
              ...this.savings_distribution
            },
            {
              preserveState: true
            }
          )
          .then(() => {
            if (this.$page.flash.success) {
              Toast.fire({
                title: "Success!",
                text: this.$page.flash.success,
                icon: "success",
                position: "center"
              });
            } else {
              Toast.fire({
                title: "Error!",
                text: "An error occured",

                icon: "error",
                position: "center"
              });
            }
          });
      }
    },
    computed: {
      savings_distribution() {
        return _.map(this.savings_list, val => {
          return _.pick(val, ["id", "savings_distribution"]);
        });
      }
    }
  };
</script>

<style scoped>
  .table thead th {
    padding: 10px !important;
  }

  input {
    min-width: 60px;
  }
</style>
