<template>
  <layout :title="`${user.full_name}'s Savings`" :isAuth="false">
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
      </ul>
      <div class="tab-content">
        <div
          class="tab-pane fade show active"
          id="homePillsSliding"
          role="tabpanel"
          aria-labelledby="homePillsSliding-tab"
        >
          <ManageSavings
            :savings_list="savings_list"
          ></ManageSavings>
        </div>
        <div
          class="tab-pane fade"
          id="profilePillsSliding"
          role="tabpanel"
          aria-labelledby="profilePillsSliding-tab"
        >
          <ManageAutoSaveSettings :auto_save_list="auto_save_list"></ManageAutoSaveSettings>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins, toOrdinalSuffix } from "@dashboard-assets/js/config";
  import axios from "axios";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  import ManageSavings from "@dashboard-assets/js/components/savings/partials/ManageSavings.vue";
  import ManageAutoSaveSettings from "@dashboard-assets/js/components/savings/partials/ManageAutoSaveSettings";
  export default {
    name: "SuperAdminManageUserSavings",
    mixins: [mixins],
    props: ["target_types", "savings_list", "auto_save_list", "user"],
    components: {
      Layout,
      ManageSavings,
      ManageAutoSaveSettings
    },
    data: () => {
      return {
        details: {}
      };
    },
  };
</script>

<style lang="scss" scoped>
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }

  .table thead th {
    padding: 10px !important;
  }
</style>
