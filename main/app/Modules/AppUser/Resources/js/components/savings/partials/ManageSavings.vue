<template>
  <div class="col-lg-12 col-xl-12">
    <div class="col-12">
      <!-- <button type="button" class="btn btn-success btn-long">
						<span class="text">Proceed to Payment</span>
      </button>&nbsp;-->

      <div class="col-12 col-md justify-content-between">
        <button
          type="button"
          class="btn btn-brand mb-10"
          data-toggle="modal"
          data-target="#createSmartSavings"
          v-if="!$page.auth.user.has_smart_savings && !$page.auth.user.isAdmin"
        >New Smart Savings</button>
        <button
          type="button"
          class="btn btn-primary mb-10"
          data-toggle="modal"
          data-target="#newTargetModal"
          v-if="!$page.auth.user.isAdmin && !$page.auth.user.isAgent"
        >New Target Savings</button>
        <button
          type="button"
          class="btn btn-info mb-10"
          data-toggle="modal"
          data-target="#newInvestmentModal"
          v-if="!$page.auth.user.isAdmin && !$page.auth.user.isAgent"
        >New Investment Savings</button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered" data-datatable-order="0:asc">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Current Balance</th>
            <th scope="col">Start Date</th>
            <th scope="col">Maturity Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="savings in savings_list" :key="savings.id">
            <th scope="row">{{savings.id}}</th>
            <td class="text-capitalize d-flex justify-content-between align-items-center">
              {{savings.name || savings.portfolio.name || 'N/A'}} {{savings.type == 'investment' ? 'Investment' : 'Savings'}}
              <span class="badge badge-danger" v-if="savings.is_matured && $page.auth.user.isAdmin">MATURED</span>
              <button
                type="button"
                v-if="!savings.is_matured"
                class="btn btn-success btn-uniform btn-round btn-xs"
                @click="fundThisSavings(savings)"
              >
                <span class="icon">
                  <span data-feather="plus" class="rui-icon rui-icon-stroke-1_5"></span>
                </span>
              </button>
              <button
                type="button"
                class="btn btn-danger btn-uniform btn-round btn-xs"
                @click="defundThisSavings(savings)"
                v-if="$page.auth.user.isAdmin && !savings.is_matured"
              >
                <span class="icon">
                  <span data-feather="credit-card" class="rui-icon rui-icon-stroke-1_5"></span>
                </span>
              </button>
            </td>
            <td class="text-capitalize">{{savings.current_balance | Naira }}</td>
            <td class="text-capitalize">{{savings.funded_at | dayjs('YYYY-MM-DD') }}</td>
            <td class="text-capitalize">{{ savings.maturity_date | dayjs('YYYY-MM-DD') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    name: "ManageSavings",
    props: ["savings_list"],
    methods: {
      fundThisSavings(savings) {
        savings.savings_id = savings.id;
        /** Connect to paystack? */
        $("#fundThisSavingsModal").modal("show");
        this.$emit("fund-savings", savings);
      },
      defundThisSavings(savings) {
        savings.savings_id = savings.id;
        /** Connect to paystack? */
        $("#defundThisSavingsModal").modal("show");
        this.$emit("defund-savings", savings);
      },
    },
  };
</script>

<style scoped>
  .btn-xs {
    padding: 3px !important;
  }

  .table thead th {
    padding: 10px !important;
  }
</style>
