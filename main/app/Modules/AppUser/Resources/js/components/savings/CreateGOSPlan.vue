<template>
  <layout title="Create GOS Savings Funds" :isAuth="false">
    <div class="container-fluid">
      <div class="col-lg-6 col-xl-5">
        <div class="d-flex align-items-center justify-content-between mb-25">
          <h2 class="mnb-2" id="formBase">Create Plan</h2>
        </div>
        <form class="#">
          <div class="row vertical-gap sm-gap">
            <div class="col-8">
              <label for="exampleBase1">Type</label>
              <select class="custom-select">
                <option selected>Select</option>
                <option value="NYSC POP Savings">NYSC POP Savings</option>
                <option value="After School Savings">After School Savings</option>
                <option value="House Rent Savings">House Rent Savings</option>
                <option value="Office/Shop Rent">Office/Shop Rent</option>
                <option value="Kid's Fees">Kid's Fees</option>
                <option value="Christmas Gbedu Savings">Christmas Gbedu Savings</option>
                <option value="Others">Others</option>
              </select>
            </div>
            <div class="col-8">
              <label for="exampleBase1">
                Others
                <span style="color: red;">(Optional)</span>
              </label>
              <input
                type="text"
                class="form-control"
                id="exampleBase1"
                placeholder="Please Specify"
              />
            </div>
            <div class="col-12">
              <label for="exampleBase1">Start Date</label>
              <input
                class="rui-datetimepicker form-control w-auto"
                type="text"
                placeholder="Select a date"
                data-datetimepicker-format="m.d.Y"
                data-datetimepicker-time="false"
              />
            </div>
            <div class="col-12">
              <label for="exampleBase1">End Date</label>
              <input
                class="rui-datetimepicker form-control w-auto"
                type="text"
                placeholder="Select a date"
                data-datetimepicker-format="m.d.Y"
                data-datetimepicker-time="false"
              />
            </div>
            <div class="col-8">
              <label for="exampleBase1">Start Amount</label>
              <input type="text" class="form-control" id="exampleBase1" placeholder="Enter Amount" />
            </div>
            <div class="col-12">
              <button type="button" class="btn btn-primary btn-long">
                <span class="icon">
                  <span data-feather="plus-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                </span>
                <span class="text">Create</span>
              </button>&nbsp;
            </div>
          </div>
        </form>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "CreateGOS",
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
