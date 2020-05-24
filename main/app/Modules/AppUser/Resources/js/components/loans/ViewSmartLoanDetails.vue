<template>
  <layout title="My Profile" :isAuth="false">
    <div class="container-fluid">
      <div class="container-fluid">
        <div class="col-lg-6">
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col" colspan="2">FWAHBA6473</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-primary">
                  <strong>Date/Time</strong>
                </td>
                <td scope="row">
                  <strong>6/5/2019 6:38:55 PM</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Requested Amount</strong>
                </td>
                <td scope="row">
                  <strong>₦18,000</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Interest Rate</strong>
                </td>
                <td scope="row">
                  <strong>
                    10%
                    <span class="text-danger">
                      <em>(₦2,000)</em>
                    </span>
                  </strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Total Amount</strong>
                </td>
                <td scope="row">
                  <strong>Total refunded</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Sureties</strong>
                </td>
                <td scope="row">
                  <span class="badge badge-success surties">Marcel Kevwe</span>
                  <span class="badge badge-success surties">Agbani Jacobi</span>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Status</strong>
                </td>
                <td scope="row">
                  <strong>Approved</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Time of Approval</strong>
                </td>
                <td scope="row">
                  <strong>6/5/2019 6:38:55 PM</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Refund Installment methods</strong>
                </td>
                <td scope="row">
                  <strong>
                    ₦2,667 / month
                    <span class="text-danger">
                      <em>(6 months)</em>
                    </span>
                  </strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Valid till</strong>
                </td>
                <td scope="row">
                  <strong>
                    9/5/2019 10:57:43 PM
                    <span class="text-danger">
                      <em>(Including 30 day grace period)</em>
                    </span>
                  </strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Total refunded</strong>
                </td>
                <td scope="row">
                  <strong>₦3,000 / ₦18,000</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Auto refund settings</strong>
                </td>
                <td scope="row">
                  <strong>23rd of every month</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary">
                  <strong>Refund status</strong>
                </td>
                <td scope="row">
                  <strong>20% complete</strong>
                </td>
              </tr>
              <tr>
                <td class="text-primary" colspan="2">
                  <button type="button" class="btn btn-primary btn-long">
                    <span class="text">Breakdown</span>
                    <span class="icon">
                      <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                    </span>
                  </button>
                  <button type="button" class="btn btn-danger btn-long">
                    <span class="text">Refund</span>
                    <span class="icon">
                      <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                    </span>
                  </button>
                  <button type="button" class="btn btn-success btn-long">
                    <span class="text">Pay More</span>
                    <span class="icon">
                      <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                    </span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "SmartLoanDetails",
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
