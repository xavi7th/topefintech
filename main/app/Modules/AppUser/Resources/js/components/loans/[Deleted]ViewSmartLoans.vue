<template>
  <layout title="My Profile" :isAuth="false">
    <div class="container-fluid">
      <div class="col-lg-12 col-xl-12">
        <div class="d-flex align-items-center justify-content-between mb-25">
          <h2 class="mnb-2" id="formBase">Logs</h2>
        </div>
        <table class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Loan Reference</th>
              <th scope="col">Requested Amount</th>
              <th scope="col">Total Amount</th>
              <th scope="col">Interest Rate</th>
              <th scope="col">Sureties</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>FWAHBA6473</td>
              <td>₦58,000</td>
              <td>₦60,000</td>
              <td>10%</td>
              <td>
                <span class="badge badge-success surties">Dafe Onosu</span>
                <span class="badge badge-success surties">Tanshi Jovwhorie</span>
              </td>
              <td>
                <inertia-link :href="$route('appuser.smart-loan.details')">
                  <span class="icon">
                    <span data-feather="corner-up-right" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                  View more
                </inertia-link>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>AKEHBA6473</td>
              <td>₦28,000</td>
              <td>₦40,000</td>
              <td>13%</td>
              <td>
                <span class="badge badge-success surties">Marcel Kevwe</span>
                <span class="badge badge-success surties">Agbani Jacobi</span>
              </td>
              <td>
                <inertia-link :href="$route('appuser.smart-loan.details')">
                  <span class="icon">
                    <span data-feather="corner-up-right" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                  View more
                </inertia-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "ViewSmartLoans",
    mixins: [mixins],
    components: {
      Layout
    },
    data: () => {
      return {};
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
