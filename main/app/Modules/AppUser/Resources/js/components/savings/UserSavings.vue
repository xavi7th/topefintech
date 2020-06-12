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
                  <th scope="col">Name</th>
                  <th scope="col">Amount</th>
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
          <div class="col-12">
            <div
              class="d-flex align-items-center justify-content-between mb-25 flex-wrap flex-md-nowrap"
            >
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
            <template v-if="errors">
              <div class="d-flex align-items-center justify-content-between flex-column mb-25">
                <FlashMessage v-for="err in errors" :msg="err[0]" :key="err[0]" />
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
                      <span
                        data-feather="chevron-down"
                        class="rui-icon rui-icon-stroke-1_5"
                      ></span>
                    </th>
                    <th scope="col">
                      Start Date
                      <span
                        data-feather="chevron-down"
                        class="rui-icon rui-icon-stroke-1_5"
                      ></span>
                    </th>
                    <th scope="col">
                      Maturity Date
                      <span
                        data-feather="chevron-down"
                        class="rui-icon rui-icon-stroke-1_5"
                      ></span>
                    </th>
                    <th scope="col">
                      Percentage
                      <span
                        data-feather="chevron-down"
                        class="rui-icon rui-icon-stroke-1_5"
                      ></span>
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
                    <td class="text-capitalize">{{savings.current_balance | currency }}</td>
                    <td class="text-capitalize">{{moment(savings.funded_at).format('YYYY-MM-DD')}}</td>
                    <td
                      class="text-capitalize"
                    >{{moment(savings.maturity_date).format('YYYY-MM-DD')}}</td>
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
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "UserSavings",
    mixins: [mixins],
    props: ["gos_types", "savings_list"],
    components: {
      Layout
    },
    data: () => {
      return {
        editDistribution: false,
        details: {}
      };
    },
    beforeCreate() {
      console.log(moment.locale());

      moment.updateLocale("en", {
        invalidDate: "N/A"
      });
    },
    computed: {
      savings_distribution() {
        return _.map(this.savings_list, val => {
          return _.pick(val, ["id", "savings_distribution"]);
        });
      }
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
          .post(this.$route("appuser.savings.locked.initialise"), {
            ...this.details
          })
          .then(() => {
            this.details = {};
            swal.close();
          });
      },
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
            this.$route("appuser.savings.distribution.update", {
              ...this.savings_distribution
            })
          )
          .then(() => {
            if (this.flash.success) {
              Toast.fire({
                title: "Success!",
                text: this.flash.success,
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
