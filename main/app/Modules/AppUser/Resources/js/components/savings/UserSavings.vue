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
          <div class="col-lg-4 col-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-25">
              <h2 class="mnb-2" id="formBase">Add to Savings</h2>
            </div>
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Type</th>
                  <th scope="col">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Core Savings</td>
                  <th scope="row">₦3,000</th>
                </tr>
                <tr>
                  <td>Locked Balance</td>
                  <th scope="row">₦2,000</th>
                </tr>
                <tr>
                  <td>GOS Balance</td>
                  <th scope="row">₦1,000</th>
                </tr>
                <tr>
                  <td>Total Amount</td>
                  <th scope="row">₦6,000</th>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12">
            <!-- <button type="button" class="btn btn-success btn-long">
						<span class="text">Proceed to Payment</span>
            </button>&nbsp;-->
            <inertia-link
              class="btn btn-success btn-long"
              :href="$route('appuser.savings.distribution')"
            >Proceed to Payment</inertia-link>
          </div>
        </div>
        <div
          class="tab-pane fade"
          id="profilePillsSliding"
          role="tabpanel"
          aria-labelledby="profilePillsSliding-tab"
        >
          <div class="col-lg-6 col-xl-5">
            <div class="d-flex align-items-center justify-content-between mb-25">
              <h2 class="mnb-2" id="formBase">My AutoSave Settings</h2>
            </div>
            <form class="#">
              <div class="row vertical-gap sm-gap">
                <div class="col-12">
                  <label for="amount">AutoSave Amount</label>
                  <input type="text" class="form-control" id="amount" placeholder="Enter Amount" />
                </div>
                <div class="col-12">
                  <label>Frequency</label>
                  <div class="custom-control custom-radio">
                    <input
                      type="radio"
                      id="daily_frequency"
                      name="save_frequency"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="daily_frequency">Daily</label>
                  </div>
                  <div class="custom-control custom-radio mt-5">
                    <input
                      type="radio"
                      id="weekly_frequency"
                      name="save_frequency"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="weekly_frequency">Weekly</label>
                  </div>
                  <div class="custom-control custom-radio mt-5">
                    <input
                      type="radio"
                      id="monthly_frequency"
                      name="save_frequency"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="monthly_frequency">Monthly</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="time">Time of Day</label>
                  <input
                    class="rui-datetimepicker form-control w-auto"
                    type="text"
                    name="time"
                    placeholder="Select a time"
                    data-datetimepicker-format="H:i"
                    data-datetimepicker-date="false"
                  />
                </div>
                <div class="col-12">
                  <label for="week">Select Week</label>
                  <select class="custom-select" name="week">
                    <option selected>Select</option>
                    <option value="1">1st</option>
                    <option value="2">2nd</option>
                    <option value="3">3rd</option>
                    <option value="4">4th</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="month">Select Month</label>
                  <select class="custom-select" name="month">
                    <option selected>Select</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="auto_save_limit">AutoSave Limit</label>
                  <input
                    type="text"
                    class="form-control"
                    id="auto_save_limit"
                    placeholder="Please Specify"
                  />
                </div>
                <div class="col-12">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="auto_save_status" />
                    <label class="custom-control-label" for="auto_save_status">AutoSave Status</label>
                  </div>
                </div>
                <div class="col-12">
                  <button type="button" class="btn btn-success btn-long">
                    <!-- <span class="icon">
                      <span stroke-width="1.5" data-feather="check"></span>
                    </span>-->
                    <span class="text">Save</span>
                  </button>&nbsp;
                </div>
              </div>
            </form>
          </div>
        </div>
        <div
          class="tab-pane fade"
          id="contactPillsSliding"
          role="tabpanel"
          aria-labelledby="contactPillsSliding-tab"
        >
          <div class="col-lg-8 col-xl-8">
            <div class="d-flex align-items-center justify-content-between mb-25">
              <h2 class="mnb-2" id="formBase">My Savings Distribution (%)</h2>
            </div>
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Type</th>
                  <th scope="col">Percentage</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Core Savings</td>
                  <td>10%</td>
                  <td>
                    <a href="#">
                      <span class="icon">
                        <span data-feather="edit" class="rui-icon rui-icon-stroke-1_5"></span>
                      </span>
                      Edit
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Locked Funds</td>
                  <td>30%</td>
                  <td>
                    <a href="#">
                      <span class="icon">
                        <span data-feather="edit" class="rui-icon rui-icon-stroke-1_5"></span>
                      </span>
                      Edit
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>NYSC POP</td>
                  <td>50%</td>
                  <td>
                    <a href="#">
                      <span class="icon">
                        <span data-feather="edit" class="rui-icon rui-icon-stroke-1_5"></span>
                      </span>
                      Edit
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">4</th>
                  <td>After School Savings</td>
                  <td>10%</td>
                  <td>
                    <a href="#">
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
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "UserSavings",
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
