<template>
  <layout title="Create Target Savings Funds" :isAuth="false">
    <div class="container-fluid">
      <div class="col-lg-6 col-xl-5">
        <div class="d-flex align-items-center justify-content-between mb-25">
          <h2 class="mnb-2" id="formBase">Create New Target Plan</h2>
        </div>
        <form class="#" @submit.prevent="createTarget">
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="targetName">
                Target Plan Name
                <span style="color: red;">(What do you want to save towards?)</span>
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
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "CreateTargetPlan",
    mixins: [mixins],
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

        this.$inertia.post(this.$route("appuser.target_type.create"), { name: this.name })
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
