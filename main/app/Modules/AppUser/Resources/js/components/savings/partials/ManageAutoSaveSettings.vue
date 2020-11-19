<template>
  <div class="row">
    <div class="col-lg-4 col-xl-4" v-if="!$page.auth.user.isAdmin && !$page.auth.user.isSuperAdmin">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">My AutoSave Settings</h2>
      </div>
      <form
        class="#"
        @submit.prevent="saveAutoSaveSetting"
        :class="{'was-validated': formSubmitted}"
      >
        <FlashMessage />
        <template v-if="$page.errors">
          <div class="d-flex align-items-center justify-content-between flex-column mb-25">
            <FlashMessage v-for="err in $page.errors" :msg="err[0]" :key="err[0]" />
          </div>
        </template>
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="amount">AutoSave Amount</label>
            <input
              type="text"
              class="form-control"
              id="amount"
              placeholder="Enter amount to auto save"
              v-model="details.amount"
              :class="{'is-invalid': $page.errors.amount, 'is-valid': !$page.errors.amount}"
            />
          </div>
          <div class="col-12">
            <label>Frequency</label>
            <div class="custom-control custom-radio">
              <input
                type="radio"
                id="daily_frequency"
                name="save_frequency"
                class="custom-control-input"
                v-model="details.frequency"
                value="daily"
                :class="{'is-invalid': $page.errors.frequency, 'is-valid': !$page.errors.frequency}"
              />
              <label class="custom-control-label" for="daily_frequency">Daily</label>
            </div>
            <div class="custom-control custom-radio mt-5">
              <input
                type="radio"
                id="weekly_frequency"
                name="save_frequency"
                class="custom-control-input"
                v-model="details.frequency"
                value="weekly"
                :class="{'is-invalid': $page.errors.frequency, 'is-valid': !$page.errors.frequency}"
              />
              <label class="custom-control-label" for="weekly_frequency">Weekly</label>
            </div>
            <div class="custom-control custom-radio mt-5">
              <input
                type="radio"
                id="monthly_frequency"
                name="save_frequency"
                class="custom-control-input"
                v-model="details.frequency"
                value="monthly"
                :class="{'is-invalid': $page.errors.frequency, 'is-valid': !$page.errors.frequency}"
              />
              <label class="custom-control-label" for="monthly_frequency">Monthly</label>
            </div>
            <div class="custom-control custom-radio mt-5">
              <input
                type="radio"
                id="quarterly_frequency"
                name="save_frequency"
                class="custom-control-input"
                v-model="details.frequency"
                value="quarterly"
                :class="{'is-invalid': $page.errors.frequency, 'is-valid': !$page.errors.frequency}"
              />
              <label class="custom-control-label" for="quarterly_frequency">Every Quarter</label>
            </div>
          </div>
          <div class="col-12" v-show="details.frequency == `daily`">
            <label for="time">Time of Day</label>
            <input
              class="rui-datetimepicker form-control w-auto"
              type="text"
              name="time"
              placeholder="Select a time"
              data-datetimepicker-format="H:i"
              data-datetimepicker-date="false"
              @blur="setTime"
              ref="timeField"
              :class="{'is-invalid': $page.errors.time, 'is-valid': !$page.errors.time}"
            />
          </div>
          <div class="col-12" v-show="details.frequency == `monthly`">
            <label for="month">Select Month</label>
            <select
              class="custom-select"
              name="month"
              v-model="details.date"
              :class="{'is-invalid': $page.errors.date, 'is-valid': !$page.errors.date}"
            >
              <option selected>Select</option>
              <option v-for="n in 31" :key="n" :value="n">Every {{ suffix(n) }}</option>
            </select>
          </div>
          <div class="col-12" v-show="details.frequency == `weekly`">
            <label for="week">Select Weekday</label>
            <select
              class="custom-select"
              name="week"
              v-model="details.weekday"
              :class="{'is-invalid': $page.errors.weekday, 'is-valid': !$page.errors.weekday}"
            >
              <option selected>Select</option>
              <option value="Monday">On Mondays</option>
              <option value="Tuesday">On Tuesdays</option>
              <option value="Wednesday">On Wednesdays</option>
              <option value="Thursday">On Thursdays</option>
              <option value="Friday">On Fridays</option>
              <option value="Saturday">On Saturdays</option>
              <option value="Sunday">On Sundays</option>
            </select>
          </div>
          <div class="col-12">
            <div class="custom-control custom-switch">
              <input
                type="checkbox"
                class="custom-control-input"
                id="auto_save_status"
                v-model="details.try_other_cards"
                :value="true"
              />
              <label
                class="custom-control-label"
                for="auto_save_status"
                title="We will attempt to deduct your other cards on record if the default card fails"
              >Try Other Cards</label>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-success btn-long">
              <!-- <span class="icon">
                      <span stroke-width="1.5" data-feather="check"></span>
              </span>-->
              <span class="text">Save</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Current Auto Save Settings</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amount</th>
              <th scope="col">Frequency</th>
              <th scope="col">Period</th>
              <th scope="col">Last Processed</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(asv, idx) in auto_save_list" :key="asv.id">
              <td>{{ idx + 1 }}</td>
              <td>{{ asv.amount | Naira }}</td>
              <td>{{ asv.period }}</td>
              <td>{{ asv.period != 'quarterly' && (asv.time || asv.weekday || 'Every ' + suffix(asv.date)) }}</td>
              <td class="d-flex justify-content-between align-content-center">
                {{ asv.processed_at | ago }}
                <button
                  type="button"
                  class="btn btn-danger btn-uniform btn-round btn-xs"
                  @click="deleteAutoSave(asv)"
                  v-if="!$page.auth.user.isAdmin && !$page.auth.user.isSuperAdmin"
                >
                  <span class="icon">
                    <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
                  </span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  import { toOrdinalSuffix } from "@dashboard-assets/js/config";
  export default {
    name: "ManageAutoSaveSettings",
    props: ["auto_save_list"],
    data: () => {
      return {
        formSubmitted: false,
        details: {}
      };
    },
    methods: {
      setTime() {
        this.details.time = this.$refs.timeField.value;
      },
      suffix(val) {
        return toOrdinalSuffix(val);
      },

      saveAutoSaveSetting() {
        this.formSubmitted = false;
        Toast.fire({
          title: "Please Wait!",
          icon: "info",
          text: "Creating a new autosave profile...",
          timer: 100000,
          position: "center"
        });

        this.$inertia
          .post(
            this.$route("appuser.savings.create-autosave"),
            {
              ...this.details
            },
            {
              preserveState: true
            }
          )
          .then(() => {
            this.formSubmitted = true;
            if (this.$page.flash.success) {
              this.formSubmitted = false;
              this.details = {};
              Toast.fire({
                title: "Success!",
                text: this.$page.flash.success,
                icon: "success",
                position: "center"
              });
            } else if (this.$page.flash.error) {
              Toast.fire({
                title: "Error!",
                text: this.$page.flash.error,
                icon: "error",
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
      },
      deleteAutoSave(asv) {
        Toast.fire({
          title: "Please Wait!",
          text: "deleting auto save profile ...",
          icon: "warning",
          timer: 100000,
          position: "center"
        });

        this.$inertia
          .delete(this.$route("appuser.savings.delete-autosave", asv.id), {
            preserveState: true
          })
          .then(() => {
            if (this.$page.flash.success) {
              Toast.fire({
                title: "Success!",
                text: this.$page.flash.success,
                icon: "success",
                position: "center"
              });
            } else if (this.$page.flash.error) {
              Toast.fire({
                title: "Error!",
                text: this.$page.flash.error,
                icon: "error",
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

<style scoped>
  .btn-xs {
    padding: 3px !important;
  }

  .table thead th {
    padding: 10px !important;
  }
</style>
