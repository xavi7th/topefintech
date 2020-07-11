<template>
  <layout title="Create Target Savings Funds" :isAuth="false">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6">
          <div class="table-responsive">
            <table class="table table-bordered" data-datatable-order="0:asc">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Active Savings</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="target in target_list" :key="target.id">
                  <th scope="row">{{target.id}}</th>
                  <td
                    class="text-capitalize d-flex justify-content-between align-items-center"
                  >{{ target.name }} Savings</td>
                  <td class="text-capitalize">
                    {{target.savings_count }}
                    <button
                      class="btn btn-danger btn-sm"
                      v-if="target.savings_count == 0"
                      @click="deleteTarget(target.id)"
                    >Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-lg-6 col-xl-5">
          <div class="d-flex align-items-center justify-content-between mb-25">
            <h2 class="mnb-2" id="formBase">Create New Target Plan</h2>
          </div>
          <form class="#" @submit.prevent="createTarget">
            <div class="row vertical-gap sm-gap">
              <div class="col-12">
                <label for="targetName">
                  Target Plan Name
                  <span
                    style="color: red;"
                  >(What do you want to user to save towards?)</span>
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="targetName"
                  v-model="name"
                  placeholder="Please Specify"
                />
                <FlashMessage v-if="flash.error" :msg="flash.error.name" />
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-long">
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
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@admin-assets/js/AdminAppComponent";
  export default {
    name: "ManageTargetPlans",
    mixins: [mixins],
    props: {
      target_list: Array
    },
    components: {
      Layout
    },
    data: () => {
      return {
        name: null
      };
    },
    methods: {
      createTarget() {
        BlockToast.fire({
          text: "Creating ..."
        });

        this.$inertia
          .post(this.$route("admin.target.create"), { name: this.name })
          .then(() => {
            console.log(this.flash);

            if (this.flash.success) {
              Toast.fire({
                title: "Success",
                text: this.flash.success,
                position: "center"
              });
            } else {
              swal.close();
            }
          });
      },
      deleteTarget(id) {
        BlockToast.fire({
          text: "Deleting ..."
        });

        this.$inertia.delete(this.$route("admin.target.delete", id)).then(() => {
          console.log(this.flash);

          if (this.flash.success) {
            Toast.fire({
              title: "Success",
              text: this.flash.success,
              position: "center"
            });
          } else {
            swal.close();
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
