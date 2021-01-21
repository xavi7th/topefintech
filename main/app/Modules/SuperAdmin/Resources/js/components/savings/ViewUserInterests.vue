<template>
  <layout :title="`${$page.props.user.full_name}'s Savings Interests`" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <interests-summary />
      </div>
      <div class="rui-gap-3"></div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  import InterestsSummary from '@dashboard-components/savings/partials/InterestsSummary';

  export default {
    name: "ViewUserInterests",
    mixins: [mixins],
    components: {
      Layout,
      InterestsSummary
    }
  };
</script>
